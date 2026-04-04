<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncProductsFromMain extends Command
{
    protected $signature = 'products:sync-from-main 
                            {--dry-run : Run without making changes}
                            {--backup : Create backup before syncing}';

    protected $description = 'Sync product descriptions and dimensions from main_products.json to products.json';

    public function handle()
    {
        $mainPath = database_path('seeders/data/main_products.json');
        $productsPath = database_path('seeders/data/products.json');

        // Check if files exist
        if (!File::exists($mainPath)) {
            $this->error("Main products file not found: {$mainPath}");
            return Command::FAILURE;
        }

        if (!File::exists($productsPath)) {
            $this->error("Products file not found: {$productsPath}");
            return Command::FAILURE;
        }

        $this->info('Loading JSON files...');

        // Load main_products.json
        $mainContent = File::get($mainPath);
        $mainData = json_decode($mainContent, true);

        // Extract the actual products data from the PHPMyAdmin export format
        $mainProducts = [];
        if (isset($mainData[2]['data'])) {
            $mainProducts = $mainData[2]['data'];
        } else {
            $this->error('Invalid main_products.json format');
            return Command::FAILURE;
        }

        // Load products.json
        $products = json_decode(File::get($productsPath), true);

        if (!is_array($mainProducts) || !is_array($products)) {
            $this->error('Failed to parse JSON files');
            return Command::FAILURE;
        }

        $this->info('Loaded ' . count($mainProducts) . ' products from main_products.json');
        $this->info('Loaded ' . count($products) . ' products from products.json');

        // Create a lookup map by SKU for main products
        $mainProductsBySku = [];
        foreach ($mainProducts as $mainProduct) {
            $sku = $mainProduct['sku'] ?? null;
            if ($sku) {
                $mainProductsBySku[$sku] = $mainProduct;
            }
        }

        $this->info('Indexed ' . count($mainProductsBySku) . ' products by SKU from main_products.json');
        $this->newLine();

        // Create backup if requested
        if ($this->option('backup') && !$this->option('dry-run')) {
            $timestamp = now()->format('Y-m-d_His');
            $backupPath = database_path("seeders/data/products.json.backup.{$timestamp}");
            File::copy($productsPath, $backupPath);
            $this->info("✓ Backup created: products.json.backup.{$timestamp}");
            $this->newLine();
        }

        // Track changes
        $stats = [
            'matched' => 0,
            'description_updated' => 0,
            'technical_spec_updated' => 0,
            'dimensions_added' => 0,
            'dimensions_updated' => 0,
            'no_changes' => 0,
        ];

        $this->info('Processing products...');
        $progressBar = $this->output->createProgressBar(count($products));

        // Process each product
        foreach ($products as $index => &$product) {
            $sku = $product['sku'] ?? null;

            if (!$sku || !isset($mainProductsBySku[$sku])) {
                $progressBar->advance();
                continue;
            }

            $mainProduct = $mainProductsBySku[$sku];
            $stats['matched']++;
            $hasChanges = false;

            // Update description if different (and main has a description)
            $mainDescription = $this->cleanDescription($mainProduct['description'] ?? '');
            $currentDescription = $product['description'] ?? '';

            if (!empty($mainDescription) && $mainDescription !== $currentDescription) {
                $product['description'] = $mainDescription;
                $stats['description_updated']++;
                $hasChanges = true;
            }

            // Update technical_specification if available
            $mainTechnicalSpec = $this->cleanDescription($mainProduct['technical_specification'] ?? '');
            $currentTechnicalSpec = $product['technical_specification'] ?? '';

            if (!empty($mainTechnicalSpec) && $mainTechnicalSpec !== $currentTechnicalSpec) {
                $product['technical_specification'] = $mainTechnicalSpec;
                $stats['technical_spec_updated']++;
                $hasChanges = true;
            }

            // Add/Update dimensions
            $dimensionFields = ['length', 'width', 'height'];
            foreach ($dimensionFields as $field) {
                $mainValue = $mainProduct[$field] ?? null;

                if ($mainValue !== null && $mainValue !== '' && $mainValue !== '0.00') {
                    $mainValue = (float) $mainValue;

                    if (!isset($product[$field]) || $product[$field] === null) {
                        $product[$field] = $mainValue;
                        $stats['dimensions_added']++;
                        $hasChanges = true;
                    } elseif ((float) $product[$field] !== $mainValue) {
                        $product[$field] = $mainValue;
                        $stats['dimensions_updated']++;
                        $hasChanges = true;
                    }
                }
            }

            if (!$hasChanges) {
                $stats['no_changes']++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Save changes
        if (!$this->option('dry-run')) {
            $jsonOutput = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            File::put($productsPath, $jsonOutput);
            $this->info('✓ Changes saved to products.json');
        } else {
            $this->warn('DRY RUN - No changes were saved');
        }

        // Display summary
        $this->newLine();
        $this->info('=== Sync Summary ===');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Products matched by SKU', $stats['matched']],
                ['Descriptions updated', $stats['description_updated']],
                ['Technical specs updated', $stats['technical_spec_updated']],
                ['Dimensions added', $stats['dimensions_added']],
                ['Dimensions updated', $stats['dimensions_updated']],
                ['Products with no changes', $stats['no_changes']],
            ]
        );

        return Command::SUCCESS;
    }

    /**
     * Clean and normalize description HTML
     */
    private function cleanDescription(?string $description): ?string
    {
        if (empty($description) || $description === 'null') {
            return null;
        }

        // Remove escaped slashes
        $description = stripslashes($description);

        // Trim whitespace
        $description = trim($description);

        return $description ?: null;
    }
}
