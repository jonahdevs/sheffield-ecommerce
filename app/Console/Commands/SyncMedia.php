<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

#[Signature('media:sync
    {--model=all : Which model to sync: categories, products, or all}
    {--fresh : Clear existing media before syncing}')]
#[Description('Backfill Spatie Media Library from legacy image sources for categories and products.')]
class SyncMedia extends Command
{
    /** @var array<string, string> category column → media collection */
    private const CATEGORY_MAP = [
        'banner' => 'banner',
        'image' => 'square',
        'icon' => 'icon',
    ];

    public function handle(): int
    {
        $model = $this->option('model');
        $fresh = (bool) $this->option('fresh');

        if (in_array($model, ['all', 'categories'], true)) {
            $this->syncCategories($fresh);
        }

        if (in_array($model, ['all', 'products'], true)) {
            $this->syncProducts($fresh);
        }

        return self::SUCCESS;
    }

    private function syncCategories(bool $fresh): void
    {
        $added = 0;
        $cleared = 0;

        Category::query()->each(function (Category $category) use (&$added, &$cleared, $fresh) {
            foreach (self::CATEGORY_MAP as $column => $collection) {
                if ($fresh && $category->getFirstMedia($collection)) {
                    $category->clearMediaCollection($collection);
                    $cleared++;
                }

                $path = $category->getAttribute($column);

                if (! $path || ! Storage::disk('public')->exists($path)) {
                    continue;
                }

                if ($category->getFirstMedia($collection)) {
                    continue;
                }

                $category->addMediaFromDisk($path, 'public')
                    ->preservingOriginal()
                    ->toMediaCollection($collection);

                $added++;
            }
        });

        $this->info("Categories - added {$added}".($fresh ? ", cleared {$cleared}" : '').'.');
    }

    private function syncProducts(bool $fresh): void
    {
        $jsonPath = database_path('data/products.json');

        if (! File::exists($jsonPath)) {
            $this->warn('products.json not found - skipping product sync.');

            return;
        }

        /** @var array<int, array<string, mixed>> $data */
        $data = json_decode(File::get($jsonPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Could not parse products.json: '.json_last_error_msg());

            return;
        }

        // Build a SKU → data map for O(1) lookups inside each().
        $bySku = [];
        foreach ($data as $item) {
            if (! empty($item['sku'])) {
                $bySku[$item['sku']] = $item;
            }
        }

        $added = 0;
        $cleared = 0;

        // Push conversion jobs to the null driver so this command stays fast.
        // Run `php artisan media-library:regenerate` afterwards to build all conversions.
        $previousQueue = config('queue.default');
        config(['queue.default' => 'null']);

        try {
            Product::query()->with('media')->each(function (Product $product) use (&$added, &$cleared, $fresh, $bySku) {
                $item = $bySku[$product->sku] ?? null;

                if (! $item) {
                    return;
                }

                if ($fresh && $product->getFirstMedia('images')) {
                    $product->clearMediaCollection('images');
                    $cleared++;
                }

                if ($product->getFirstMedia('images')) {
                    return;
                }

                if (! empty($item['image']) && Storage::disk('public')->exists($item['image'])) {
                    $product->addMediaFromDisk($item['image'], 'public')
                        ->withCustomProperties(['is_cover' => true])
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                    $added++;
                }

                foreach ($item['gallery'] ?? [] as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        $product->addMediaFromDisk($path, 'public')
                            ->withCustomProperties(['is_cover' => false])
                            ->preservingOriginal()
                            ->toMediaCollection('images');
                        $added++;
                    }
                }
            });
        } finally {
            config(['queue.default' => $previousQueue]);
        }

        $this->info("Products - added {$added}".($fresh ? ", cleared {$cleared}" : '').'.');
        if ($added > 0) {
            $this->line('  Run <comment>php artisan media-library:regenerate</comment> to generate all image conversions.');
        }
    }
}
