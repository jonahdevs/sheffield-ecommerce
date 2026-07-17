<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromQuery, WithColumnWidths, WithHeadings, WithMapping, WithStyles
{
    public function __construct(
        private readonly string $search = '',
        private readonly string $filterStatus = '',
        private readonly string $filterVisibility = '',
        private readonly string $filterStock = '',
        private readonly string $filterCategory = '',
    ) {}

    public function query()
    {
        return Product::query()
            ->with(['brand', 'primaryCategory'])
            ->when($this->search, fn ($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('sku', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterVisibility, fn ($q) => $q->where('visibility', $this->filterVisibility))
            ->when($this->filterStock, fn ($q) => $q->where('stock_status', $this->filterStock))
            ->when($this->filterCategory, fn ($q) => $q->inCategoryTree((int) $this->filterCategory))
            ->orderBy('name');
    }

    /** @return array<int, string> */
    public function headings(): array
    {
        return [
            'ID', 'Name', 'SKU', 'Brand', 'Primary Category',
            'Type', 'Status', 'Price (KES)', 'Sale Price (KES)', 'Cost Price (KES)',
            'Stock Status', 'Stock Quantity', 'Visibility',
            'Weight', 'Is Taxable', 'Requires Shipping',
            'Short Description', 'Meta Title', 'Meta Description',
        ];
    }

    /** @param Product $product */
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->sku,
            $product->brand?->name,
            $product->primaryCategory?->name,
            $product->type->value,
            $product->status->value,
            $product->price !== null ? round($product->price / 100, 2) : null,
            $product->sale_price !== null ? round($product->sale_price / 100, 2) : null,
            $product->cost_price !== null ? round($product->cost_price / 100, 2) : null,
            $product->stock_status->value,
            $product->stock_quantity,
            $product->visibility->value,
            $product->weight,
            $product->is_taxable ? 'yes' : 'no',
            $product->requires_shipping ? 'yes' : 'no',
            $product->short_description,
            $product->meta_title,
            $product->meta_description,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /** @return array<string, int> */
    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 35,
            'C' => 15,
            'D' => 20,
            'E' => 22,
            'F' => 12,
            'G' => 12,
            'H' => 14,
            'I' => 16,
            'J' => 16,
            'K' => 14,
            'L' => 14,
            'M' => 14,
            'N' => 10,
            'O' => 12,
            'P' => 18,
            'Q' => 40,
            'R' => 30,
            'S' => 40,
        ];
    }
}
