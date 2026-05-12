<?php

namespace App\Console\Commands;

use App\Models\ProductVariant;
use Illuminate\Console\Command;

class SyncVariantAttributeValues extends Command
{
    protected $signature = 'variants:sync-attribute-values';

    protected $description = 'Sync variant attribute values from the attributes JSON field to the pivot table';

    public function handle(): int
    {
        $this->info('Syncing variant attribute values...');

        $variants = ProductVariant::whereNotNull('attributes')
            ->where('attributes', '!=', '[]')
            ->get();

        $synced = 0;
        $skipped = 0;

        foreach ($variants as $variant) {
            // Skip if already has attribute values
            if ($variant->attributeValues()->count() > 0) {
                $skipped++;
                continue;
            }

            $attributeValueIds = collect($variant->attributes)
                ->map(fn($id) => (int) $id)
                ->filter()
                ->toArray();

            if (!empty($attributeValueIds)) {
                $variant->attributeValues()->sync($attributeValueIds);
                $synced++;
                $this->line("  Synced variant #{$variant->id} ({$variant->name})");
            }
        }

        $this->info("Done! Synced: {$synced}, Skipped (already had values): {$skipped}");

        return Command::SUCCESS;
    }
}
