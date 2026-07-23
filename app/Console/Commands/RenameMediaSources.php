<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Renames raw source images on the `public` disk to a stable, human/SEO-friendly
 * scheme and rewrites the matching paths in the seed JSON so the next seed/sync
 * picks up the new names.
 *
 *   products   {name}-{sku}.{ext}                 (gallery → -1, -2 …)
 *   categories {slug}.{ext}, {slug}-icon|banner   (square / icon / banner)
 *   brands     {slug}.{ext}                        (logo)
 *
 * Safe by default: runs as a DRY RUN unless --execute is passed. Source files
 * shared by more than one row are COPIED (never moved) so nothing is left without
 * an image. Idempotent - re-running after a successful pass is a no-op.
 */
#[Signature('media:rename-sources
    {--target=all : Which source set to rename: products, categories, brands, or all}
    {--execute : Actually move files and rewrite the JSON (otherwise dry-run)}')]
#[Description('Rename raw source images to readable {name}/{slug}-based filenames and update the seed JSON references.')]
class RenameMediaSources extends Command
{
    private const TARGETS = ['products', 'categories', 'brands'];

    public function handle(): int
    {
        $target = (string) $this->option('target');

        if ($target !== 'all' && ! in_array($target, self::TARGETS, true)) {
            $this->error('Invalid --target. Use one of: all, '.implode(', ', self::TARGETS));

            return self::FAILURE;
        }

        $execute = (bool) $this->option('execute');
        $targets = $target === 'all' ? self::TARGETS : [$target];
        $collisions = 0;

        foreach ($targets as $set) {
            $this->newLine();
            $this->line("<fg=cyan;options=bold>━━ {$set} ━━</>");
            $collisions += match ($set) {
                'products' => $this->processProducts($execute),
                'categories' => $this->processCategories($execute),
                'brands' => $this->processBrands($execute),
            };
        }

        $this->newLine();
        if (! $execute) {
            $this->warn('DRY RUN - nothing was changed. Re-run with --execute to apply.');
        } else {
            $this->info('Done. Re-seed (migrate:fresh --seed) so stored media adopts the new names.');
        }

        return $collisions > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function processProducts(bool $execute): int
    {
        return $this->processFile('data/products.json', $execute, function (array &$rows, array $refCounts, Filesystem $disk, array &$claimed, array &$stats, array &$samples) use ($execute) {
            foreach ($rows as &$row) {
                $name = Str::slug($row['name'] ?? '') ?: 'product';
                $sku = Str::slug($row['sku'] ?? '') ?: 'no-sku';
                $base = $name.'-'.$sku;

                if (! empty($row['image'])) {
                    $row['image'] = $this->plan($row['image'], 'products/'.$base.'.'.$this->ext($row['image']), $refCounts, $disk, $claimed, $execute, $stats, $samples);
                }
                foreach ($row['gallery'] ?? [] as $i => $path) {
                    $row['gallery'][$i] = $this->plan($path, 'products/gallery/'.$base.'-'.($i + 1).'.'.$this->ext($path), $refCounts, $disk, $claimed, $execute, $stats, $samples);
                }
            }
        });
    }

    private function processCategories(bool $execute): int
    {
        return $this->processFile('data/categories.json', $execute, function (array &$rows, array $refCounts, Filesystem $disk, array &$claimed, array &$stats, array &$samples) use ($execute) {
            foreach ($rows as &$row) {
                $slug = Str::slug($row['name'] ?? '') ?: 'category';

                if (! empty($row['image'])) {
                    $row['image'] = $this->plan($row['image'], 'categories/'.$slug.'.'.$this->ext($row['image']), $refCounts, $disk, $claimed, $execute, $stats, $samples);
                }
                if (! empty($row['icon'])) {
                    $row['icon'] = $this->plan($row['icon'], 'categories/'.$slug.'-icon.'.$this->ext($row['icon']), $refCounts, $disk, $claimed, $execute, $stats, $samples);
                }
                if (! empty($row['banner'])) {
                    $row['banner'] = $this->plan($row['banner'], 'categories/'.$slug.'-banner.'.$this->ext($row['banner']), $refCounts, $disk, $claimed, $execute, $stats, $samples);
                }
            }
        });
    }

    private function processBrands(bool $execute): int
    {
        return $this->processFile('data/brands.json', $execute, function (array &$rows, array $refCounts, Filesystem $disk, array &$claimed, array &$stats, array &$samples) use ($execute) {
            foreach ($rows as &$row) {
                $slug = Str::slug($row['slug'] ?? ($row['name'] ?? '')) ?: 'brand';

                if (! empty($row['logo'])) {
                    $row['logo'] = $this->plan($row['logo'], 'brands/'.$slug.'.'.$this->ext($row['logo']), $refCounts, $disk, $claimed, $execute, $stats, $samples);
                }
            }
        });
    }

    /**
     * Shared machinery: load the JSON, count references (to spot shared files),
     * run the target-specific renamer, print a report, and (when executing) write
     * the JSON back with a .bak backup.
     *
     * @param  callable(array<int,array<string,mixed>>&, array<string,int>, Filesystem, array<string,string>&, array<string,int>&, array<int,string>&):void  $renamer
     */
    private function processFile(string $relativeJson, bool $execute, callable $renamer): int
    {
        $jsonPath = database_path($relativeJson);

        if (! File::exists($jsonPath)) {
            $this->error("Not found: {$jsonPath}");

            return 0;
        }

        /** @var array<int, array<string, mixed>> $rows */
        $rows = json_decode(File::get($jsonPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Could not parse {$relativeJson}: ".json_last_error_msg());

            return 0;
        }

        // Count every referenced path so shared files can be copied, not moved.
        $refCounts = [];
        array_walk_recursive($rows, function ($value, $key) use (&$refCounts) {
            if (in_array($key, ['image', 'icon', 'banner', 'logo'], true) && is_string($value) && $value !== '') {
                $refCounts[$value] = ($refCounts[$value] ?? 0) + 1;
            } elseif (is_string($value) && str_starts_with((string) $value, 'products/gallery/')) {
                $refCounts[$value] = ($refCounts[$value] ?? 0) + 1;
            }
        });

        $disk = Storage::disk('public');
        $claimed = [];
        $stats = ['moved' => 0, 'copied' => 0, 'skipped' => 0, 'missing' => 0, 'collisions' => 0];
        $samples = [];

        $renamer($rows, $refCounts, $disk, $claimed, $stats, $samples);

        if ($execute) {
            File::copy($jsonPath, $jsonPath.'.bak');
            File::put($jsonPath, json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $this->line("  <fg=green>{$relativeJson} rewritten</> (backup at {$relativeJson}.bak)");
        }

        foreach (array_slice($samples, 0, 5) as $sample) {
            $this->line('    '.$sample);
        }

        $this->table(
            ['Moved', 'Copied (shared)', 'Skipped (done)', 'Missing', 'Collisions'],
            [[$stats['moved'], $stats['copied'], $stats['skipped'], $stats['missing'], $stats['collisions']]],
        );

        return $stats['collisions'];
    }

    private function ext(string $path): string
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION)) ?: 'jpg';
    }

    /**
     * Resolve a single source → target rename, performing the disk op when
     * executing. Returns the path to write back into the JSON.
     *
     * @param  array<string, int>  $refCounts
     * @param  array<string, string>  $claimed
     * @param  array<string, int>  $stats
     * @param  array<int, string>  $samples
     */
    private function plan(
        string $old,
        string $newPath,
        array $refCounts,
        Filesystem $disk,
        array &$claimed,
        bool $execute,
        array &$stats,
        array &$samples,
    ): string {
        // Already named correctly, or a previous run completed this one.
        if ($old === $newPath || $disk->exists($newPath)) {
            $stats['skipped']++;

            return $newPath;
        }

        // Two different rows resolving to the same target - guard against silent
        // overwrites (shouldn't happen: sku/slug are unique).
        if (isset($claimed[$newPath]) && $claimed[$newPath] !== $old) {
            $this->error("  Target collision: {$newPath} wanted by both {$claimed[$newPath]} and {$old}");
            $stats['collisions']++;

            return $old;
        }
        $claimed[$newPath] = $old;

        if (! $disk->exists($old)) {
            $this->warn("  Missing source: {$old}");
            $stats['missing']++;

            return $old;
        }

        $isShared = ($refCounts[$old] ?? 0) > 1;
        $samples[] = ($isShared ? '[copy] ' : '[move] ').$old.'  →  '.$newPath;

        if ($execute) {
            $isShared ? $disk->copy($old, $newPath) : $disk->move($old, $newPath);
        }

        $isShared ? $stats['copied']++ : $stats['moved']++;

        return $newPath;
    }
}
