<?php

namespace App\Livewire\Concerns;

use App\Models\Attribute as ProductAttribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Tag;
use App\Models\TaxClass;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

trait ManagesProductForm
{
    // ── Linked-product search state

    public string $upsellQuery = '';

    public string $crossSellQuery = '';

    public string $accessoryQuery = '';

    // ── Tag management state ───────────────────────────────────────────────────

    public string $tagQuery = '';

    public string $newTagInput = '';

    // ── Variant image uploads ──────────────────────────────────────────────────

    /** @var array<int, TemporaryUploadedFile|null> */
    public array $variantImages = [];

    // ── Product Image actions ──────────────────────────────────────────────────

    public function removeProductImage(): void
    {
        $this->form->image = null;
        $this->form->existing_image = null;
    }

    // ── Tag actions ────────────────────────────────────────────────────────────

    public function addTags(): void
    {
        $names = array_filter(array_map('trim', explode(',', $this->newTagInput)));

        foreach ($names as $name) {
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );

            if (!in_array($tag->id, $this->form->tag_ids, true)) {
                $this->form->tag_ids[] = $tag->id;
            }
        }

        $this->newTagInput = '';
    }

    public function addTag(int $tagId): void
    {
        if (!in_array($tagId, $this->form->tag_ids, true)) {
            $this->form->tag_ids[] = $tagId;
        }
    }

    public function removeTag(int $tagId): void
    {
        $this->form->tag_ids = array_values(
            array_filter($this->form->tag_ids, fn($id) => $id !== $tagId)
        );
    }

    // ── Computed data ──────────────────────────────────────────────────────────

    #[Computed]
    public function taxClasses()
    {
        return TaxClass::orderBy('name')->get();
    }

    /**
     * All active attributes with their values (for value checkboxes).
     */
    #[Computed]
    public function availableAttributes()
    {
        return ProductAttribute::with('values')->where('is_active', true)->orderBy('name')->get();
    }

    /**
     * Active attributes not yet added to this product (for the "Add existing" dropdown).
     */
    #[Computed]
    public function selectableAttributes()
    {
        $selectedIds = collect($this->form->product_attributes)
            ->where('is_new', false)
            ->pluck('attribute_id')
            ->filter()
            ->all();

        return ProductAttribute::where('is_active', true)
            ->whereNotIn('id', $selectedIds)
            ->orderBy('name')
            ->get();
    }

    /**
     * Returns the value options (id + label) for a given attribute ID.
     */
    public function getProductAttributeValues(int $attributeId): array
    {
        return $this->availableAttributes
            ->firstWhere('id', $attributeId)
            ?->values
            ->where('is_active', true)
            ->map(fn($v) => ['id' => $v->id, 'label' => $v->label])
            ->values()
            ->toArray() ?? [];
    }

    #[Computed]
    public function unpricedVariantsCount(): int
    {
        return collect($this->form->variations)
            ->filter(fn($v) => $v['price'] === '' || $v['price'] === null)
            ->count();
    }

    #[Computed]
    public function upsellResults(): array
    {
        return $this->searchLinkedProducts($this->upsellQuery);
    }

    #[Computed]
    public function crossSellResults(): array
    {
        return $this->searchLinkedProducts($this->crossSellQuery);
    }

    #[Computed]
    public function accessoryResults(): array
    {
        return $this->searchLinkedProducts($this->accessoryQuery);
    }

    #[Computed]
    public function selectedTags()
    {
        if (empty($this->form->tag_ids)) {
            return collect();
        }

        return Tag::whereIn('id', $this->form->tag_ids)->get();
    }

    #[Computed]
    public function availableTags()
    {
        return Tag::whereNotIn('id', $this->form->tag_ids ?: [])
            ->when(
                strlen(trim($this->tagQuery)) >= 1,
                fn($q) => $q->where('name->en', 'like', "%{$this->tagQuery}%")
            )
            ->orderBy('name')
            ->limit(50)
            ->get();
    }

    private function searchLinkedProducts(string $query): array
    {
        if (strlen(trim($query)) < 2) {
            return [];
        }

        $excluded = array_merge(
            [$this->product?->id ?? 0],
            array_column($this->form->upsell_products, 'id'),
            array_column($this->form->cross_sell_products, 'id'),
            array_column($this->form->accessory_products, 'id'),
        );

        return Product::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('sku', 'like', "%{$query}%");
        })
            ->whereNotIn('id', array_filter($excluded))
            ->limit(8)
            ->get(['id', 'name', 'sku'])
            ->toArray();
    }

    // ── Linked product actions ─────────────────────────────────────────────────

    public function addLinkedProduct(int $productId, string $type): void
    {
        $product = Product::find($productId, ['id', 'name', 'sku']);
        if (!$product) {
            return;
        }

        $data = ['id' => $product->id, 'name' => $product->name, 'sku' => $product->sku];
        $list = $this->resolveLinkedList($type);

        if (!collect($this->form->{$list})->contains('id', $productId)) {
            $this->form->{$list}[] = $data;
        }

        match ($type) {
            'upsell' => $this->upsellQuery = '',
            'cross_sell' => $this->crossSellQuery = '',
            'accessory' => $this->accessoryQuery = '',
        };
    }

    public function removeLinkedProduct(int $index, string $type): void
    {
        $list = $this->resolveLinkedList($type);
        array_splice($this->form->{$list}, $index, 1);
        $this->form->{$list} = array_values($this->form->{$list});
    }

    private function resolveLinkedList(string $type): string
    {
        return match ($type) {
            'upsell' => 'upsell_products',
            'cross_sell' => 'cross_sell_products',
            'accessory' => 'accessory_products',
        };
    }

    // ── Attribute actions ──────────────────────────────────────────────────────

    public function addNewAttribute(): void
    {
        $this->form->product_attributes[] = [
            'attribute_id' => null,
            'name' => '',
            'values' => '',
            'is_variation_attribute' => false,
            'is_visible' => true,
            'is_new' => true,
        ];
    }

    public function addExistingAttribute(int $attributeId): void
    {
        $attr = $this->availableAttributes->firstWhere('id', $attributeId);

        if (!$attr) {
            return;
        }

        $alreadyAdded = collect($this->form->product_attributes)
            ->where('is_new', false)
            ->pluck('attribute_id')
            ->contains($attributeId);

        if ($alreadyAdded) {
            return;
        }

        $this->form->product_attributes[] = [
            'attribute_id' => $attr->id,
            'name' => $attr->name,
            'values' => [],
            'is_variation_attribute' => false,
            'is_visible' => true,
            'is_new' => false,
        ];
    }

    public function removeSelectedAttribute(int $index): void
    {
        array_splice($this->form->product_attributes, $index, 1);
        $this->form->product_attributes = array_values($this->form->product_attributes);
    }

    // ── Variation actions ──────────────────────────────────────────────────────

    public function addVariant(): void
    {
        $this->form->variations[] = $this->blankVariation();
    }

    public function removeVariant(int $index): void
    {
        array_splice($this->form->variations, $index, 1);
        $this->form->variations = array_values($this->form->variations);

        unset($this->variantImages[$index]);
        $this->variantImages = array_values($this->variantImages);
    }

    public function removeVariantImage(int $index): void
    {
        unset($this->variantImages[$index]);
        if (isset($this->form->variations[$index])) {
            $this->form->variations[$index]['image_path'] = null;
        }
    }

    public function removeDownload(int $downloadId): void
    {
        $this->form->downloads_to_delete[] = $downloadId;
        $this->form->existing_downloads = array_values(
            array_filter($this->form->existing_downloads, fn($d) => $d['id'] !== $downloadId)
        );
    }

    public function removeNewDownload(int $index): void
    {
        array_splice($this->form->new_download_files, $index, 1);
        $this->form->new_download_files = array_values($this->form->new_download_files);
        array_splice($this->form->new_download_names, $index, 1);
        $this->form->new_download_names = array_values($this->form->new_download_names);
    }

    public function activateAllVariants(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if (!$v['is_active']) {
                $count++;
            }
            $v['is_active'] = true;
            return $v;
        }, $this->form->variations);

        $this->dispatch(
            'notify',
            title: 'Variants Activated',
            variant: 'success',
            message: $count > 0 ? "{$count} variant(s) activated." : "All variants were already active."
        );
    }

    public function deactivateAllVariants(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if ($v['is_active']) {
                $count++;
            }
            $v['is_active'] = false;
            return $v;
        }, $this->form->variations);

        $this->dispatch(
            'notify',
            title: 'Variants Deactivated',
            variant: 'success',
            message: $count > 0 ? "{$count} variant(s) deactivated." : "All variants were already inactive."
        );
    }

    public function enableAllVariantsStockManagement(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if (!$v['manage_stock']) {
                $count++;
            }
            $v['manage_stock'] = true;
            return $v;
        }, $this->form->variations);

        $this->dispatch(
            'notify',
            title: 'Stock Management Enabled',
            variant: 'success',
            message: $count > 0 ? "Stock management enabled for {$count} variant(s)." : "All variants already have stock management enabled."
        );
    }

    public function disableAllVariantsStockManagement(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if ($v['manage_stock']) {
                $count++;
            }
            $v['manage_stock'] = false;
            return $v;
        }, $this->form->variations);

        $this->dispatch(
            'notify',
            title: 'Stock Management Disabled',
            variant: 'success',
            message: $count > 0 ? "Stock management disabled for {$count} variant(s)." : "All variants already have stock management disabled."
        );
    }

    public function setAllVariantsStockStatus(string $status): void
    {
        // Validate status
        $validStatuses = ['in_stock', 'out_of_stock', 'backorder'];
        if (!in_array($status, $validStatuses)) {
            $this->dispatch(
                'notify',
                title: 'Invalid Status',
                variant: 'danger',
                message: 'Invalid stock status provided.'
            );
            return;
        }

        // Only update variants with stock management enabled
        $managedCount = collect($this->form->variations)
            ->where('manage_stock', true)
            ->count();

        if ($managedCount === 0) {
            $this->dispatch(
                'notify',
                title: 'No Stock Management',
                variant: 'warning',
                message: 'None of the variants have stock management enabled.'
            );
            return;
        }

        $updatedCount = 0;
        $this->form->variations = array_map(function ($v) use ($status, &$updatedCount) {
            if ($v['manage_stock']) {
                $v['stock_status'] = $status;
                $updatedCount++;
            }
            return $v;
        }, $this->form->variations);

        $statusLabel = str_replace('_', ' ', $status);
        $this->dispatch(
            'notify',
            title: 'Stock Status Updated',
            variant: 'success',
            message: "{$updatedCount} variant(s) set to {$statusLabel}."
        );
    }

    public function clearAllVariants(): void
    {
        $count = count($this->form->variations);
        $this->form->variations = [];
        $this->variantImages = [];

        $this->dispatch(
            'notify',
            title: 'Variants Deleted',
            variant: 'success',
            message: "{$count} variant(s) deleted."
        );
    }

    // ── Bulk Pricing Actions ──────────────────────────────────────────────────

    public function bulkSetPrice(float $price): void
    {
        if ($price < 0) {
            $this->dispatch('notify', title: 'Invalid Price', variant: 'danger', message: 'Price cannot be negative.');
            return;
        }

        $count = count($this->form->variations);
        $this->form->variations = array_map(function ($v) use ($price) {
            $v['price'] = (string) $price;
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Prices Updated', variant: 'success', message: "Price set to " . format_currency($price) . " for {$count} variant(s).");
    }

    public function bulkSetCostPrice(float $price): void
    {
        if ($price < 0) {
            $this->dispatch('notify', title: 'Invalid Price', variant: 'danger', message: 'Cost price cannot be negative.');
            return;
        }

        $count = count($this->form->variations);
        $this->form->variations = array_map(function ($v) use ($price) {
            $v['cost_price'] = (string) $price;
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Cost Prices Updated', variant: 'success', message: "Cost price set to " . format_currency($price) . " for {$count} variant(s).");
    }

    public function bulkSetSalePrice(float $price): void
    {
        if ($price < 0) {
            $this->dispatch('notify', title: 'Invalid Price', variant: 'danger', message: 'Sale price cannot be negative.');
            return;
        }

        $count = count($this->form->variations);
        $this->form->variations = array_map(function ($v) use ($price) {
            $v['sale_price'] = (string) $price;
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Sale Prices Updated', variant: 'success', message: "Sale price set to " . format_currency($price) . " for {$count} variant(s).");
    }

    public function bulkClearSalePrice(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if ($v['sale_price'] !== '' && $v['sale_price'] !== null) {
                $count++;
            }
            $v['sale_price'] = '';
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Sale Prices Cleared', variant: 'success', message: $count > 0 ? "Sale price cleared for {$count} variant(s)." : "No variants had sale prices.");
    }

    public function bulkAdjustPriceByPercent(float $percent): void
    {
        if ($percent < -100) {
            $this->dispatch('notify', title: 'Invalid Percentage', variant: 'danger', message: 'Percentage cannot be less than -100%.');
            return;
        }

        $count = 0;
        $this->form->variations = array_map(function ($v) use ($percent, &$count) {
            if ($v['price'] !== '' && $v['price'] !== null) {
                $currentPrice = (float) $v['price'];
                $newPrice = $currentPrice * (1 + ($percent / 100));
                $v['price'] = (string) round($newPrice, 2);
                $count++;
            }
            return $v;
        }, $this->form->variations);

        $direction = $percent > 0 ? 'increased' : 'decreased';
        $this->dispatch('notify', title: 'Prices Adjusted', variant: 'success', message: "{$count} variant price(s) {$direction} by " . abs($percent) . "%.");
    }

    // ── Bulk SKU Actions ───────────────────────────────────────────────────────

    public function bulkGenerateSKUs(string $prefix = ''): void
    {
        $basePrefix = $prefix ?: ($this->form->sku ?: 'VAR');
        $count = 0;

        $this->form->variations = array_map(function ($v, $index) use ($basePrefix, &$count) {
            if (empty($v['sku'])) {
                $suffix = '';
                if (!empty($v['name'])) {
                    $suffix = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', substr($v['name'], 0, 10)));
                } else {
                    $suffix = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
                }
                $v['sku'] = $basePrefix . '-' . $suffix;
                $count++;
            }
            return $v;
        }, $this->form->variations, array_keys($this->form->variations));

        $this->dispatch('notify', title: 'SKUs Generated', variant: 'success', message: $count > 0 ? "Generated SKUs for {$count} variant(s)." : "All variants already have SKUs.");
    }

    public function bulkClearSKUs(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if (!empty($v['sku'])) {
                $count++;
            }
            $v['sku'] = '';
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'SKUs Cleared', variant: 'success', message: "{$count} variant SKU(s) cleared.");
    }

    // ── Bulk Dimensions Actions ────────────────────────────────────────────────

    public function bulkSetStockQuantity(int $quantity): void
    {
        if ($quantity < 0) {
            $this->dispatch('notify', title: 'Invalid Quantity', variant: 'danger', message: 'Stock quantity cannot be negative.');
            return;
        }

        // Only update variants with stock management enabled
        $managedCount = collect($this->form->variations)
            ->where('manage_stock', true)
            ->count();

        if ($managedCount === 0) {
            $this->dispatch('notify', title: 'No Stock Management', variant: 'warning', message: 'None of the variants have stock management enabled.');
            return;
        }

        $updatedCount = 0;
        $this->form->variations = array_map(function ($v) use ($quantity, &$updatedCount) {
            if ($v['manage_stock']) {
                $v['stock_quantity'] = $quantity;
                $updatedCount++;
            }
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Stock Quantity Updated', variant: 'success', message: "Stock quantity set to {$quantity} for {$updatedCount} variant(s).");
    }

    public function bulkSetWeight(float $weight): void
    {
        if ($weight < 0) {
            $this->dispatch('notify', title: 'Invalid Weight', variant: 'danger', message: 'Weight cannot be negative.');
            return;
        }

        $count = count($this->form->variations);
        $this->form->variations = array_map(function ($v) use ($weight) {
            $v['weight'] = (string) $weight;
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Weight Updated', variant: 'success', message: "Weight set to {$weight} kg for {$count} variant(s).");
    }

    public function bulkSetDimensions(float $length, float $width, float $height): void
    {
        if ($length < 0 || $width < 0 || $height < 0) {
            $this->dispatch('notify', title: 'Invalid Dimensions', variant: 'danger', message: 'Dimensions cannot be negative.');
            return;
        }

        $count = count($this->form->variations);
        $this->form->variations = array_map(function ($v) use ($length, $width, $height) {
            $v['length'] = (string) $length;
            $v['width'] = (string) $width;
            $v['height'] = (string) $height;
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Dimensions Updated', variant: 'success', message: "Dimensions set to {$length}×{$width}×{$height} cm for {$count} variant(s).");
    }

    public function bulkCopyDimensionsFromParent(): void
    {
        $parentWeight = $this->form->weight;
        $parentLength = $this->form->length;
        $parentWidth = $this->form->width;
        $parentHeight = $this->form->height;

        if (empty($parentWeight) && empty($parentLength) && empty($parentWidth) && empty($parentHeight)) {
            $this->dispatch('notify', title: 'No Parent Dimensions', variant: 'warning', message: 'Parent product has no dimensions set.');
            return;
        }

        $count = count($this->form->variations);
        $this->form->variations = array_map(function ($v) use ($parentWeight, $parentLength, $parentWidth, $parentHeight) {
            if (!empty($parentWeight)) {
                $v['weight'] = $parentWeight;
            }
            if (!empty($parentLength)) {
                $v['length'] = $parentLength;
            }
            if (!empty($parentWidth)) {
                $v['width'] = $parentWidth;
            }
            if (!empty($parentHeight)) {
                $v['height'] = $parentHeight;
            }
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Dimensions Copied', variant: 'success', message: "Parent dimensions copied to {$count} variant(s).");
    }

    // ── Bulk Backorder Actions ─────────────────────────────────────────────────

    public function bulkEnableBackorders(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if (!$v['allow_backorders']) {
                $count++;
            }
            $v['allow_backorders'] = true;
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Backorders Enabled', variant: 'success', message: $count > 0 ? "Backorders enabled for {$count} variant(s)." : "All variants already allow backorders.");
    }

    public function bulkDisableBackorders(): void
    {
        $count = 0;
        $this->form->variations = array_map(function ($v) use (&$count) {
            if ($v['allow_backorders']) {
                $count++;
            }
            $v['allow_backorders'] = false;
            return $v;
        }, $this->form->variations);

        $this->dispatch('notify', title: 'Backorders Disabled', variant: 'success', message: $count > 0 ? "Backorders disabled for {$count} variant(s)." : "All variants already disallow backorders.");
    }

    // ── Bulk Default Variant ───────────────────────────────────────────────────

    public function setFirstActiveAsDefault(): void
    {
        $foundDefault = false;
        $defaultName = '';

        $this->form->variations = array_map(function ($v) use (&$foundDefault, &$defaultName) {
            if (!$foundDefault && $v['is_active']) {
                $v['is_default'] = true;
                $foundDefault = true;
                $defaultName = $v['name'] ?: 'Unnamed variant';
            } else {
                $v['is_default'] = false;
            }
            return $v;
        }, $this->form->variations);

        if ($foundDefault) {
            $this->dispatch('notify', title: 'Default Variant Set', variant: 'success', message: "\"{$defaultName}\" set as default variant.");
        } else {
            $this->dispatch('notify', title: 'No Active Variants', variant: 'warning', message: 'No active variants found to set as default.');
        }
    }

    /**
     * Set default variant by matching attribute value IDs.
     * Called when user selects values from the default variant selector dropdowns.
     */
    public function setDefaultVariantByAttributes(array $selectedValueIds): void
    {
        // Filter out empty values
        $selectedValueIds = array_filter($selectedValueIds, fn($id) => !empty($id));

        if (empty($selectedValueIds)) {
            // Clear default if no values selected
            $this->form->variations = array_map(function ($v) {
                $v['is_default'] = false;
                return $v;
            }, $this->form->variations);
            return;
        }

        // Sort for comparison
        $selectedSorted = array_map('intval', $selectedValueIds);
        sort($selectedSorted);

        $foundDefault = false;
        $defaultName = '';

        $this->form->variations = array_map(function ($v) use ($selectedSorted, &$foundDefault, &$defaultName) {
            $variantAttrs = array_map('intval', $v['attributes'] ?? []);
            sort($variantAttrs);

            if (!$foundDefault && $variantAttrs === $selectedSorted && $v['is_active']) {
                $v['is_default'] = true;
                $foundDefault = true;
                $defaultName = $v['name'] ?: 'Unnamed variant';
            } else {
                $v['is_default'] = false;
            }
            return $v;
        }, $this->form->variations);

        if ($foundDefault) {
            $this->dispatch('notify', title: 'Default Variant Set', variant: 'success', message: "\"{$defaultName}\" set as default variant.");
        } else {
            $this->dispatch('notify', title: 'No Matching Variant', variant: 'warning', message: 'No active variant matches the selected combination.');
        }
    }

    /**
     * Get the current default variant's attribute values for pre-selecting the dropdowns.
     */
    #[Computed]
    public function defaultVariantAttributeValues(): array
    {
        $defaultVariant = collect($this->form->variations)->firstWhere('is_default', true);

        if (!$defaultVariant) {
            return [];
        }

        return array_map('intval', $defaultVariant['attributes'] ?? []);
    }

    /**
     * Get variation attributes with their values for the default variant selector.
     * Only returns attributes that are marked as variation attributes with selected values.
     */
    #[Computed]
    public function variationAttributesForSelector(): array
    {
        $result = [];

        foreach ($this->form->product_attributes as $attr) {
            // Only include existing attributes marked for variations with values
            if (($attr['is_new'] ?? false) || empty($attr['is_variation_attribute']) || empty($attr['values'])) {
                continue;
            }

            $attribute = $this->availableAttributes->firstWhere('id', $attr['attribute_id']);
            if (!$attribute) {
                continue;
            }

            $values = $attribute->values
                ->whereIn('id', $attr['values'])
                ->where('is_active', true)
                ->map(fn($v) => ['id' => $v->id, 'label' => $v->label ?: $v->value])
                ->values()
                ->toArray();

            if (!empty($values)) {
                $result[] = [
                    'id' => $attr['attribute_id'],
                    'name' => $attribute->name,
                    'values' => $values,
                ];
            }
        }

        return $result;
    }

    public function regenerateVariations(): void
    {
        $this->generateVariations();
    }

    public function generateVariations(): void
    {
        // Only use existing (non-new) attributes flagged for variations with selected values
        $variationAttrs = array_values(array_filter(
            $this->form->product_attributes,
            fn($a) => !($a['is_new'] ?? false)
            && !empty($a['is_variation_attribute'])
            && !empty($a['values'])
        ));

        if (empty($variationAttrs)) {
            $this->dispatch(
                'notify',
                title: 'No Variation Attributes',
                variant: 'warning',
                message: 'Mark at least one attribute as "Used for variations" and select its values first.'
            );

            return;
        }

        $allValueIds = array_merge(...array_column($variationAttrs, 'values'));
        $valueLabels = AttributeValue::whereIn('id', $allValueIds)->pluck('label', 'id')->toArray();

        $valueSets = array_column($variationAttrs, 'values');
        $combinations = $this->cartesianProduct($valueSets);

        $added = 0;
        foreach ($combinations as $combo) {
            $sorted = $combo;
            sort($sorted);
            $exists = collect($this->form->variations)->contains(function ($v) use ($sorted) {
                $attrs = $v['attributes'] ?? [];
                sort($attrs);

                return $attrs === $sorted;
            });

            if (!$exists) {
                $name = implode(' / ', array_map(fn($id) => $valueLabels[$id] ?? "Value {$id}", $combo));
                $this->form->variations[] = $this->blankVariation($name, $combo);
                $added++;
            }
        }

        $this->dispatch(
            'notify',
            title: $added > 0 ? 'Variations Generated' : 'No New Variations',
            variant: $added > 0 ? 'success' : 'info',
            message: $added > 0 ? "{$added} variation(s) added." : 'All combinations already exist.',
        );
    }

    /**
     * Stores pending variant image uploads and writes their paths into form->variations.
     * Must be called before form->store() / form->update().
     */
    protected function processVariantImages(): void
    {
        foreach ($this->variantImages as $index => $image) {
            if ($image && is_object($image) && isset($this->form->variations[$index])) {
                $this->form->variations[$index]['image_path'] = $image->store('products/variants', 'public');
            }
        }
    }

    private function cartesianProduct(array $sets): array
    {
        if (empty($sets)) {
            return [[]];
        }
        $result = [[]];
        foreach ($sets as $set) {
            $newResult = [];
            foreach ($result as $existing) {
                foreach ($set as $value) {
                    $newResult[] = [...$existing, $value];
                }
            }
            $result = $newResult;
        }

        return $result;
    }

    private function blankVariation(string $name = '', array $attributes = []): array
    {
        return [
            'id' => null,
            'name' => $name,
            'sku' => '',
            'price' => '',
            'sale_price' => '',
            'cost_price' => '',
            'manage_stock' => false,
            'stock_quantity' => 0,
            'stock_status' => 'in_stock',
            'allow_backorders' => false,
            'backorder_message' => '',
            'max_backorder_quantity' => '',
            'expected_restock_date' => '',
            'low_stock_threshold' => '',
            'weight' => '',
            'height' => '',
            'width' => '',
            'length' => '',
            'image_path' => null,
            'is_default' => false,
            'is_active' => true,
            'description' => '',
            'attributes' => $attributes,
        ];
    }
}
