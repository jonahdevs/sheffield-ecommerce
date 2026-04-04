<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CleanupUnusedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:cleanup 
                            {--dry-run : Show what would be deleted without actually deleting}
                            {--force : Skip confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up unused images from storage (products and categories)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $isForce = $this->option('force');

        $this->info('🔍 Scanning for unused images...');
        $this->newLine();

        // Get all images referenced in products.json and categories.json
        $referencedImages = $this->getReferencedImages();

        if (empty($referencedImages)) {
            $this->error('❌ Could not read JSON files or no images found.');

            return Command::FAILURE;
        }

        $this->info("✅ Found {$referencedImages->count()} images referenced in JSON files");
        $this->newLine();

        // Get all images in storage
        $storageImages = $this->getStorageImages();

        if (empty($storageImages)) {
            $this->warn('⚠️  No images found in storage');

            return Command::SUCCESS;
        }

        $this->info("📁 Found {$storageImages->count()} images in storage");
        $this->newLine();

        // Find unused images
        $unusedImages = $storageImages->diff($referencedImages);

        if ($unusedImages->isEmpty()) {
            $this->info('✨ No unused images found. All images are being used!');

            return Command::SUCCESS;
        }

        // Display unused images
        $this->warn("🗑️  Found {$unusedImages->count()} unused images:");
        $this->newLine();

        $table = [];
        $totalSize = 0;

        foreach ($unusedImages as $image) {
            $path = storage_path("app/public/products/seeder/{$image}");
            $size = File::exists($path) ? File::size($path) : 0;
            $totalSize += $size;

            $table[] = [
                'filename' => $image,
                'size' => $this->formatBytes($size),
            ];
        }

        $this->table(['Filename', 'Size'], $table);
        $this->newLine();
        $this->info("💾 Total space to be freed: {$this->formatBytes($totalSize)}");
        $this->newLine();

        // Dry run mode
        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE: No files will be deleted.');
            $this->info('Run without --dry-run to actually delete these files.');

            return Command::SUCCESS;
        }

        // Confirmation
        if (!$isForce) {
            if (!$this->confirm('⚠️  Are you sure you want to delete these images? This action cannot be undone.')) {
                $this->info('❌ Operation cancelled.');

                return Command::SUCCESS;
            }
        }

        // Delete unused images
        $this->info('🗑️  Deleting unused images...');
        $progressBar = $this->output->createProgressBar($unusedImages->count());
        $progressBar->start();

        $deleted = 0;
        $failed = 0;

        $searchPaths = [
            'products',
            'products/gallery',
            'products/variants',
            'categories',
        ];

        foreach ($unusedImages as $image) {
            $found = false;

            // Search in all possible paths
            foreach ($searchPaths as $searchPath) {
                $path = "{$searchPath}/{$image}";

                if (Storage::disk('public')->exists($path)) {
                    if (Storage::disk('public')->delete($path)) {
                        $deleted++;
                        $found = true;
                        break;
                    } else {
                        $failed++;
                        $this->newLine();
                        $this->error("Failed to delete: {$path}");
                        $found = true;
                        break;
                    }
                }
            }

            if (!$found) {
                $this->newLine();
                $this->warn("Image not found in storage: {$image}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Summary
        if ($deleted > 0) {
            $this->info("✅ Successfully deleted {$deleted} unused images");
            $this->info("💾 Freed up approximately {$this->formatBytes($totalSize)}");
        }

        if ($failed > 0) {
            $this->error("❌ Failed to delete {$failed} images");
        }

        return Command::SUCCESS;
    }

    /**
     * Get all images referenced in products.json and categories.json
     */
    private function getReferencedImages()
    {
        $images = collect();

        // Get product images
        $productImages = $this->getProductImages();
        $images = $images->merge($productImages);

        // Get category images
        $categoryImages = $this->getCategoryImages();
        $images = $images->merge($categoryImages);

        return $images->unique();
    }

    /**
     * Get all images referenced in products.json
     */
    private function getProductImages()
    {
        $jsonPath = database_path('seeders/data/products.json');

        if (!File::exists($jsonPath)) {
            return collect();
        }

        $products = json_decode(File::get($jsonPath), true);

        if (!is_array($products)) {
            return collect();
        }

        $images = collect();

        foreach ($products as $product) {
            // Check for 'image' field (single image)
            if (isset($product['image']) && !empty($product['image'])) {
                $imagePath = $product['image'];
                // Extract just the filename from the path
                $filename = basename($imagePath);
                $images->push($filename);
            }

            // Check for 'gallery' field (array of images)
            if (isset($product['gallery']) && is_array($product['gallery'])) {
                foreach ($product['gallery'] as $imagePath) {
                    if (!empty($imagePath)) {
                        $filename = basename($imagePath);
                        $images->push($filename);
                    }
                }
            }

            // Check for 'images' array field (if you have multiple images with different key)
            if (isset($product['images']) && is_array($product['images'])) {
                foreach ($product['images'] as $imagePath) {
                    if (!empty($imagePath)) {
                        $filename = basename($imagePath);
                        $images->push($filename);
                    }
                }
            }
        }

        return $images;
    }

    /**
     * Get all images referenced in categories.json
     */
    private function getCategoryImages()
    {
        $jsonPath = database_path('seeders/data/categories.json');

        if (!File::exists($jsonPath)) {
            return collect();
        }

        $categories = json_decode(File::get($jsonPath), true);

        if (!is_array($categories)) {
            return collect();
        }

        $images = collect();

        foreach ($categories as $category) {
            // Check for 'image_path' field
            if (isset($category['image_path']) && !empty($category['image_path'])) {
                $imagePath = $category['image_path'];
                $filename = basename($imagePath);
                $images->push($filename);
            }

            // Check for 'image_icon' field
            if (isset($category['image_icon']) && !empty($category['image_icon'])) {
                $imagePath = $category['image_icon'];
                $filename = basename($imagePath);
                $images->push($filename);
            }

            // Check for 'image' field (alternative naming)
            if (isset($category['image']) && !empty($category['image'])) {
                $imagePath = $category['image'];
                $filename = basename($imagePath);
                $images->push($filename);
            }
        }

        return $images;
    }

    /**
     * Get all images from storage
     */
    private function getStorageImages()
    {
        $images = collect();

        // Scan products folder
        $paths = [
            'products',
            'products/gallery',
            'products/variants',
            'categories',
        ];

        foreach ($paths as $path) {
            if (!Storage::disk('public')->exists($path)) {
                continue;
            }

            $files = Storage::disk('public')->files($path);

            $pathImages = collect($files)->map(function ($file) {
                return basename($file);
            })->filter(function ($filename) {
                // Only include image files
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
            });

            $images = $images->merge($pathImages);
        }

        return $images->unique();
    }

    /**
     * Format bytes to human-readable size
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
