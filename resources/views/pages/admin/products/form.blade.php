<?php

use App\Enums\ProductType;
use App\Enums\ProductVisibility;
use App\Enums\StockStatus;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::app')] class extends Component
{
    // ─── Identity ──────────────────────────────────────────────────────────────
    public ?int $productId = null;

    public string $name = '';
    public string $slug = '';
    public string $sku = '';
    public string $model_number = '';
    public string $type = 'simple';

    // ─── Content ───────────────────────────────────────────────────────────────
    public string $short_description = '';
    public string $description = '';

    // ─── Organisation ──────────────────────────────────────────────────────────
    public ?int $brand_id = null;
    public ?int $primary_category_id = null;

    // ─── Pricing (stored in KES, converted to cents on save) ───────────────────
    public ?float $price = null;
    public ?float $sale_price = null;
    public ?float $cost_price = null;
    public bool $is_taxable = true;

    // ─── Inventory ─────────────────────────────────────────────────────────────
    public string $stock_status = 'in_stock';
    public ?int $stock_quantity = null;
    public bool $allow_backorder = false;

    // ─── Visibility ────────────────────────────────────────────────────────────
    public string $visibility = 'visible';
    public int $sort_order = 0;

    // ─── B2B ───────────────────────────────────────────────────────────────────
    public bool $requires_quotation = false;
    public string $quotation_notes = '';

    /** Whether the slug was typed by the user (stops auto-generation). */
    private bool $slugManuallyEdited = false;

    public function mount(?Product $product = null): void
    {
        if (! $product) {
            return;
        }

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->sku = (string) $product->sku;
        $this->model_number = (string) $product->model_number;
        $this->type = $product->type->value;
        $this->short_description = (string) $product->short_description;
        $this->description = (string) $product->description;
        $this->brand_id = $product->brand_id;
        $this->primary_category_id = $product->primary_category_id;
        $this->price = $product->price ? round($product->price / 100, 2) : null;
        $this->sale_price = $product->sale_price ? round($product->sale_price / 100, 2) : null;
        $this->cost_price = $product->cost_price ? round($product->cost_price / 100, 2) : null;
        $this->is_taxable = (bool) $product->is_taxable;
        $this->stock_status = $product->stock_status->value;
        $this->stock_quantity = $product->stock_quantity;
        $this->allow_backorder = (bool) $product->allow_backorder;
        $this->visibility = $product->visibility->value;
        $this->sort_order = (int) $product->sort_order;
        $this->requires_quotation = (bool) $product->requires_quotation;
        $this->quotation_notes = (string) $product->quotation_notes;
        $this->slugManuallyEdited = true;
    }

    public function updatedName(): void
    {
        if (! $this->slugManuallyEdited) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function updatedSlug(): void
    {
        $this->slugManuallyEdited = true;
        $this->slug = Str::slug($this->slug);
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255',
                Rule::unique('products', 'slug')->ignore($this->productId),
            ],
            'sku' => [
                'nullable', 'string', 'max:100',
                Rule::unique('products', 'sku')->ignore($this->productId)->whereNull('deleted_at'),
            ],
            'type' => ['required', Rule::in(array_column(ProductType::cases(), 'value'))],
            'price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'stock_status' => ['required', Rule::in(array_column(StockStatus::cases(), 'value'))],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'visibility' => ['required', Rule::in(array_column(ProductVisibility::cases(), 'value'))],
            'sort_order' => ['integer', 'min:0'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'primary_category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku ?: null,
            'model_number' => $this->model_number ?: null,
            'type' => $this->type,
            'short_description' => $this->short_description ?: null,
            'description' => $this->description ?: null,
            'brand_id' => $this->brand_id,
            'primary_category_id' => $this->primary_category_id,
            'price' => $this->price !== null ? (int) round($this->price * 100) : null,
            'sale_price' => $this->sale_price !== null ? (int) round($this->sale_price * 100) : null,
            'cost_price' => $this->cost_price !== null ? (int) round($this->cost_price * 100) : null,
            'is_taxable' => $this->is_taxable,
            'stock_status' => $this->stock_status,
            'stock_quantity' => $this->stock_quantity,
            'allow_backorder' => $this->allow_backorder,
            'visibility' => $this->visibility,
            'sort_order' => $this->sort_order,
            'requires_quotation' => $this->requires_quotation,
            'quotation_notes' => $this->quotation_notes ?: null,
        ];

        if ($this->productId) {
            Product::findOrFail($this->productId)->update($data);
            Flux::toast(heading: 'Product updated', text: $this->name.' has been saved.', variant: 'success');
        } else {
            Product::create($data);
            Flux::toast(heading: 'Product created', text: $this->name.' has been added.', variant: 'success');
        }

        $this->redirectRoute('admin.products.index', navigate: true);
    }

    #[Computed]
    public function brands()
    {
        return Brand::where('is_active', true)->orderBy('name')->get(['id', 'name']);
    }

    #[Computed]
    public function categories()
    {
        return Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'parent_id']);
    }

    public function getTitle(): string
    {
        return $this->productId ? 'Edit product — Admin' : 'New product — Admin';
    }

    public function render(): \Illuminate\View\View
    {
        return view('pages.admin.products.form')->title($this->getTitle());
    }
}; ?>

<div>
    {{-- Page header --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item :href="route('dashboard')" wire:navigate>Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item :href="route('admin.products.index')" wire:navigate>Products</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ $productId ? $name : 'New product' }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <flux:heading size="xl" class="mt-2">
                {{ $productId ? 'Edit product' : 'New product' }}
            </flux:heading>
        </div>
        <div class="flex items-center gap-3">
            <flux:button variant="ghost" :href="route('admin.products.index')" wire:navigate>Cancel</flux:button>
            <flux:button variant="primary" wire:click="save" wire:loading.attr="disabled" wire:target="save">
                {{ $productId ? 'Save changes' : 'Create product' }}
            </flux:button>
        </div>
    </div>

    {{-- Form grid --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- ── Left / main (2 cols) ── --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- General --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">General</flux:heading>

                <div class="space-y-4">
                    <flux:input wire:model.live.debounce.400ms="name" label="Product name" placeholder="e.g. Commercial Wok Range 4-Burner" required />

                    <flux:input wire:model.blur="slug"
                                label="Slug"
                                description="URL-safe identifier. Auto-generated from name; edit to customise."
                                placeholder="auto-generated-from-name" />

                    <div class="grid grid-cols-2 gap-4">
                        <flux:select wire:model="type" label="Product type">
                            @foreach (ProductType::cases() as $t)
                                <flux:select.option :value="$t->value">{{ ucfirst($t->value) }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input wire:model="model_number" label="Model number" placeholder="e.g. WR-4B-900" />
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">Description</flux:heading>

                <div class="space-y-4">
                    <flux:textarea wire:model="short_description"
                                   label="Short description"
                                   description="Shown in listing cards and search snippets."
                                   rows="3"
                                   placeholder="One or two sentences summarising the product…" />

                    <flux:textarea wire:model="description"
                                   label="Full description"
                                   rows="8"
                                   placeholder="Detailed product description…" />
                </div>
            </div>

        </div>

        {{-- ── Right / sidebar (1 col) ── --}}
        <div class="space-y-6">

            {{-- Product details --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">Product details</flux:heading>
                <div class="space-y-4">
                    <flux:input wire:model="sku"
                                label="SKU"
                                description="Stock keeping unit. Must be unique."
                                placeholder="e.g. WR-4B" />
                </div>
            </div>

            {{-- Organisation --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">Organisation</flux:heading>
                <div class="space-y-4">
                    <flux:select wire:model="brand_id" label="Brand">
                        <flux:select.option value="">No brand</flux:select.option>
                        @foreach ($this->brands as $brand)
                            <flux:select.option :value="$brand->id">{{ $brand->name }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model="primary_category_id" label="Primary category">
                        <flux:select.option value="">No category</flux:select.option>
                        @foreach ($this->categories as $cat)
                            <flux:select.option :value="$cat->id">{{ $cat->name }}</flux:select.option>
                            @foreach ($cat->children as $child)
                                <flux:select.option :value="$child->id">&nbsp;&nbsp;&nbsp;{{ $child->name }}</flux:select.option>
                            @endforeach
                        @endforeach
                    </flux:select>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">Pricing</flux:heading>
                <div class="space-y-4">
                    <flux:input wire:model="price" label="Price (KES)" type="number" min="0" step="0.01" placeholder="0.00" />
                    <flux:input wire:model="sale_price" label="Sale price (KES)" type="number" min="0" step="0.01" placeholder="0.00" />
                    <flux:input wire:model="cost_price" label="Cost price (KES)" type="number" min="0" step="0.01" placeholder="0.00" />
                    <div class="flex items-center justify-between rounded-md bg-zinc-50 px-3 py-2.5 dark:bg-zinc-800">
                        <flux:label>Taxable (VAT 16%)</flux:label>
                        <flux:switch wire:model="is_taxable" />
                    </div>
                </div>
            </div>

            {{-- Inventory --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">Inventory</flux:heading>
                <div class="space-y-4">
                    <flux:select wire:model="stock_status" label="Stock status">
                        @foreach (StockStatus::cases() as $s)
                            <flux:select.option :value="$s->value">{{ $s->label() }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input wire:model="stock_quantity" label="Stock quantity" type="number" min="0" placeholder="Leave blank if untracked" />

                    <div class="flex items-center justify-between rounded-md bg-zinc-50 px-3 py-2.5 dark:bg-zinc-800">
                        <flux:label>Allow backorder</flux:label>
                        <flux:switch wire:model="allow_backorder" />
                    </div>
                </div>
            </div>

            {{-- Visibility --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">Visibility</flux:heading>
                <div class="space-y-4">
                    <flux:select wire:model="visibility" label="Visibility">
                        @foreach (ProductVisibility::cases() as $v)
                            <flux:select.option :value="$v->value">{{ $v->label() }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input wire:model="sort_order" label="Sort order" type="number" min="0" />
                </div>
            </div>

            {{-- B2B --}}
            <div class="rounded-lg border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:heading size="base" class="mb-4">B2B</flux:heading>
                <div class="space-y-4">
                    <div class="flex items-center justify-between rounded-md bg-zinc-50 px-3 py-2.5 dark:bg-zinc-800">
                        <div>
                            <flux:label>Requires quotation</flux:label>
                            <flux:text size="sm" class="text-xs">Hide price; show "Request a quote" instead.</flux:text>
                        </div>
                        <flux:switch wire:model="requires_quotation" />
                    </div>

                    @if ($requires_quotation)
                        <flux:textarea wire:model="quotation_notes" label="Quotation notes" rows="2"
                                       placeholder="Internal notes shown to sales team…" />
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
