<?php

namespace App\Console\Commands;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

#[Signature('products:process-images
    {--sku= : Limit to a single product by SKU}
    {--limit= : Maximum number of images to process}
    {--output= : Directory to write processed images (default storage/app/public/products/product-images-processed)}
    {--replace : Swap the processed image into the media library (destructive — alters originals)}
    {--fresh : Reprocess images even if an output already exists / was already processed}
    {--size=1200 : Square canvas edge in px for the processed master}
    {--margin=0.06 : Empty margin around the subject (fraction of canvas, 0-0.4)}
    {--bg=transparent : "transparent" or a hex colour (e.g. FFFFFF) for the backdrop}
    {--quality=90 : WebP quality (1-100)}
    {--model=isnet-general-use : rembg model name}
    {--ai : Pre-enhance each image with the Gemini image API (sharpen/clean) before cutout — needs GEMINI_API_KEY}
    {--ai-model=gemini-2.5-flash-image : Gemini image model id used with --ai}
    {--dry-run : Show what would be processed without writing anything}')]
#[Description('Remove backgrounds, center subjects on a square canvas, and convert product images to WebP. Non-destructive by default — writes to a review folder unless --replace is passed.')]
class ProcessProductImages extends Command
{
    public function handle(): int
    {
        $script = base_path('scripts/process_product_image.py');

        if (! File::exists($script)) {
            $this->error("Processing script not found: {$script}");

            return self::FAILURE;
        }

        $python = env('PYTHON_BIN', 'python');
        $fresh = (bool) $this->option('fresh');
        $dryRun = (bool) $this->option('dry-run');
        $replace = (bool) $this->option('replace');
        $ai = (bool) $this->option('ai');
        $limit = $this->option('limit') !== null ? (int) $this->option('limit') : null;

        $apiKey = (string) config('services.gemini.key', '');

        if ($ai) {
            if ($apiKey === '') {
                $this->error('--ai requires GEMINI_API_KEY to be set in your .env.');

                return self::FAILURE;
            }

            if (! File::exists(base_path('scripts/gemini_enhance.py'))) {
                $this->error('AI script not found: scripts/gemini_enhance.py');

                return self::FAILURE;
            }
        }

        $outputDir = $this->option('output')
            ? rtrim((string) $this->option('output'), '/\\')
            : storage_path('app/public/products/product-images-processed');

        $query = Media::query()
            ->where('collection_name', 'images')
            ->where('model_type', (new Product)->getMorphClass())
            ->with('model')
            ->orderBy('model_id')
            ->orderBy('id');

        if ($sku = $this->option('sku')) {
            $productIds = Product::query()->where('sku', $sku)->pluck('id');

            if ($productIds->isEmpty()) {
                $this->error("No product found with SKU: {$sku}");

                return self::FAILURE;
            }

            $query->whereIn('model_id', $productIds);
        }

        // In --replace mode we can skip already-adopted media at the SQL level.
        // In folder mode we skip per-image based on whether the output already exists.
        if ($replace && ! $fresh) {
            $query->where(function ($q) {
                $q->whereNull('custom_properties->bg_processed')
                    ->orWhere('custom_properties->bg_processed', false);
            });
        }

        $total = (clone $query)->count();

        if ($total === 0) {
            $this->info('No images to process.'.($fresh ? '' : ' Use --fresh to reprocess.'));

            return self::SUCCESS;
        }

        $mode = $replace ? 'replace' : 'folder';
        $flags = $mode.($ai ? ', ai' : '').($dryRun ? ', dry run' : '');
        $this->info("Processing up to {$total} image(s) [{$flags}].");
        if (! $replace && ! $dryRun) {
            $this->line("  Writing to <comment>{$outputDir}</comment> — originals untouched.");
        }

        $processed = 0;
        $skipped = 0;
        $failed = 0;

        $query->each(function (Media $media) use (
            &$processed, &$skipped, &$failed, $python, $script, $outputDir, $dryRun, $replace, $fresh, $limit, $ai, $apiKey
        ) {
            if ($limit && $processed >= $limit) {
                return false;
            }

            $source = $media->getPath();

            if (! File::exists($source)) {
                $this->warn("  [missing] media #{$media->id} — {$media->file_name}");
                $failed++;

                return true;
            }

            $target = $this->outputPathFor($media, $outputDir);

            if (! $fresh && ! $replace && File::exists($target)) {
                $skipped++;

                return true;
            }

            if ($dryRun) {
                $this->line("  [would process] media #{$media->id} — {$media->file_name}");
                $processed++;

                return true;
            }

            File::ensureDirectoryExists(dirname($target));

            // AI mode: enhance the source first, then run the normal cutout on the
            // enhanced copy. If the AI step fails, fall back to the original source so
            // the image is still processed (just without enhancement).
            $cutoutSource = $source;
            $aiTemp = null;

            if ($ai) {
                $aiTemp = $this->aiTempPath($target);

                if ($this->runAiEnhance($python, $aiTemp, $source, $apiKey)) {
                    $cutoutSource = $aiTemp;
                } else {
                    $this->warn("  [ai-skipped] media #{$media->id} — enhancing failed, using original.");
                }
            }

            if (! $this->runScript($python, $script, $cutoutSource, $target)) {
                $failed++;
                $this->cleanup($aiTemp);

                return true;
            }

            $this->cleanup($aiTemp);

            if ($replace) {
                $this->replaceMedia($media, $target);
            }

            $this->line("  [done] media #{$media->id} → {$media->model?->name}");
            $processed++;

            return true;
        });

        $this->newLine();
        $this->info("Processed: {$processed}, skipped: {$skipped}, failed: {$failed}.");

        if ($processed > 0 && ! $dryRun) {
            if ($replace) {
                $this->line('  Run <comment>php artisan media-library:regenerate</comment> to (re)build responsive conversions.');
            } else {
                $this->line("  Review <comment>{$outputDir}</comment>, then re-run with <comment>--replace</comment> to adopt them.");
            }
        }

        return $failed > 0 && $processed === 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Flat output path — all processed images land in the one review folder. The
     * media file name already encodes the product name + SKU, so it stays unique.
     */
    private function outputPathFor(Media $media, string $outputDir): string
    {
        $basename = pathinfo($media->file_name, PATHINFO_FILENAME);

        return $outputDir.DIRECTORY_SEPARATOR.$basename.'.webp';
    }

    /**
     * Invoke the Python processor for a single image. Returns false on failure.
     */
    private function runScript(string $python, string $script, string $source, string $target): bool
    {
        $process = new Process([
            $python,
            $script,
            $source,
            $target,
            '--size', (string) (int) $this->option('size'),
            '--margin', (string) (float) $this->option('margin'),
            '--bg', (string) $this->option('bg'),
            '--quality', (string) (int) $this->option('quality'),
            '--model', (string) $this->option('model'),
        ]);
        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            $this->warn('  [failed] '.trim($process->getErrorOutput() ?: $process->getOutput()));

            return false;
        }

        return true;
    }

    /**
     * Run the Gemini enhancement script, writing the enhanced image to $target.
     * The API key is passed via the child process environment (never logged).
     * Returns false on any failure so the caller can fall back to the original.
     */
    private function runAiEnhance(string $python, string $target, string $source, string $apiKey): bool
    {
        $process = new Process(
            [
                $python,
                base_path('scripts/gemini_enhance.py'),
                $source,
                $target,
                '--model', (string) $this->option('ai-model'),
            ],
            env: ['GEMINI_API_KEY' => $apiKey],
        );
        $process->setTimeout(300);
        $process->run();

        if (! $process->isSuccessful()) {
            $this->warn('  [ai-error] '.trim($process->getErrorOutput() ?: $process->getOutput()));

            return false;
        }

        return File::exists($target);
    }

    /**
     * Temp path for the AI-enhanced intermediate, alongside the final target.
     */
    private function aiTempPath(string $target): string
    {
        return $target.'.ai.png';
    }

    private function cleanup(?string $path): void
    {
        if ($path !== null && File::exists($path)) {
            File::delete($path);
        }
    }

    /**
     * Swap the processed WebP in for the original media item, preserving the
     * cover flag, alt text and ordering, then remove the old file. Only runs
     * under --replace. The processed file in the output folder is kept.
     */
    private function replaceMedia(Media $media, string $processedPath): void
    {
        /** @var Product $product */
        $product = $media->model;
        $order = $media->order_column;
        $properties = [...$media->custom_properties, 'bg_processed' => true];

        $name = pathinfo($media->file_name, PATHINFO_FILENAME);

        $newMedia = $product->addMedia($processedPath)
            ->preservingOriginal()
            ->usingName($media->name)
            ->usingFileName("{$name}.webp")
            ->withCustomProperties($properties)
            ->toMediaCollection('images');

        $newMedia->order_column = $order;
        $newMedia->save();

        $media->delete();
    }
}
