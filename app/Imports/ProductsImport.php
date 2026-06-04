<?php

namespace App\Imports;

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Enums\ProductVisibility;
use App\Enums\StockStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements SkipsOnError, SkipsOnFailure, ToModel, WithHeadingRow, WithValidation
{
    use SkipsErrors, SkipsFailures;

    public int $importedCount = 0;

    public int $updatedCount = 0;

    public function model(array $row): ?Product
    {
        $brandId = ! empty($row['brand'])
            ? Brand::where('name', $row['brand'])->value('id')
            : null;

        $categoryId = ! empty($row['primary_category'])
            ? Category::where('name', $row['primary_category'])->value('id')
            : null;

        $product = null;
        $isNew = true;

        if (! empty($row['sku'])) {
            $product = Product::where('sku', $row['sku'])->first();
            $isNew = $product === null;
        }

        $product ??= new Product;

        $product->name = $row['name'];
        if ($isNew) {
            $product->slug = $this->uniqueSlug($row['name'], null);
        }
        if (! empty($row['sku'])) {
            $product->sku = $row['sku'];
        }
        $product->brand_id = $brandId;
        $product->primary_category_id = $categoryId;
        $product->type = ProductType::tryFrom((string) ($row['type'] ?? '')) ?? ProductType::SIMPLE;
        $product->status = ProductStatus::tryFrom((string) ($row['status'] ?? '')) ?? ProductStatus::DRAFT;
        $product->price = $this->toCents($row['price_kes'] ?? null);
        $product->sale_price = $this->toCents($row['sale_price_kes'] ?? null);
        $product->cost_price = $this->toCents($row['cost_price_kes'] ?? null);
        $product->stock_status = StockStatus::tryFrom((string) ($row['stock_status'] ?? '')) ?? StockStatus::IN_STOCK;
        $product->stock_quantity = isset($row['stock_quantity']) && $row['stock_quantity'] !== '' ? (int) $row['stock_quantity'] : null;
        $product->visibility = ProductVisibility::tryFrom((string) ($row['visibility'] ?? '')) ?? ProductVisibility::VISIBLE;
        $product->weight = isset($row['weight']) && $row['weight'] !== '' ? (float) $row['weight'] : null;
        $product->is_taxable = strtolower((string) ($row['is_taxable'] ?? 'yes')) !== 'no';
        $product->requires_shipping = strtolower((string) ($row['requires_shipping'] ?? 'yes')) !== 'no';
        $product->short_description = $row['short_description'] ?? null;
        $product->meta_title = $row['meta_title'] ?? null;
        $product->meta_description = $row['meta_description'] ?? null;

        $isNew ? $this->importedCount++ : $this->updatedCount++;

        return $product;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    private function toCents(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) round((float) $value * 100);
    }

    private function uniqueSlug(string $name, ?int $excludeId): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Product::where('slug', $slug)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $base.'-'.++$i;
        }

        return $slug;
    }
}
