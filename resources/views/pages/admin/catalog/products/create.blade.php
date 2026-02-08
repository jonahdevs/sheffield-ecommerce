<?php
use App\Models\Product;
use App\Livewire\Forms\Admin\ProductForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use Livewire\Attributes\Computed;

new class extends Component {
    use WithFileUploads;
    public ProductForm $form;
    public string $activeTab = 'general';

    #[Computed]
    public function categories()
    {
        $categories = Category::active()->ordered()->with('children')->whereNull('parent_id')->get();

        return $this->flattenCategories($categories);
    }

    private function flattenCategories($categories, $depth = 0)
    {
        $result = [];

        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'name' => $category->name,
                'depth' => $depth,
            ];

            if ($category->children->isNotEmpty()) {
                $result = array_merge($result, $this->flattenCategories($category->children, $depth + 1));
            }
        }

        return $result;
    }
}; ?>

<div>

    <flux:heading size="xl" class="mb-2">Create New Product</flux:heading>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="#" icon="squares-2x2" icon-variant="outline"></flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.products')">Products</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Create</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">


        <div class="col-span-3 space-y-5">
            {{-- Basic Inforation Section --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Basic Information</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    <div class="grid grid-cols-2 gap-5">
                        {{-- Product Name --}}
                        <flux:input :label="__('Product Name')" />

                        {{-- Model Number --}}
                        <flux:input :label="__('Model Number')" />

                        {{-- SKU --}}
                        <flux:input :label="__('SKU')" />

                        {{-- Slug --}}
                        <flux:input :label="__('Slug')" />
                    </div>

                    {{-- Short Description --}}
                    <flux:textarea :label="__('Short Description')" />

                    {{-- Description --}}
                    <flux:textarea :label="__('Description')" />
                </div>
            </flux:card>

            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <div class="flex items-center gap-3">
                        <flux:heading>Product Data</flux:heading>

                        <flux:select size="sm" class="w-fit" wire:model="form.product_type">
                            <flux:select.option value="simple">Simple</flux:select.option>
                            <flux:select.option value="variable">Variable Product</flux:select.option>
                        </flux:select>
                    </div>
                </div>

                <div class="grid grid-cols-4">
                    <div class="col-span-1 bg-zinc-100 border-r flex flex-col divide-y overflow-hidden rounded-bl-xl">
                        <flux:button class="w-full rounded-none! cursor-pointer justify-start!" variant="ghost"
                            x-bind:class="{ 'bg-zinc-200!': $wire.activeTab === 'general' }" icon="truck"
                            icon-variant="outline" @click="$wire.activeTab = 'general'">
                            General
                        </flux:button>

                        <flux:button class="w-full rounded-none! cursor-pointer justify-start!" variant="ghost"
                            x-bind:class="{ 'bg-zinc-200!': $wire.activeTab === 'inventory' }" icon="archive-box"
                            icon-variant="outline" @click="$wire.activeTab = 'inventory'">
                            Inventory
                        </flux:button>

                        <flux:button class="w-full rounded-none! cursor-pointer justify-start!" variant="ghost"
                            x-bind:class="{ 'bg-zinc-200!': $wire.activeTab === 'shipping' }" icon="truck"
                            icon-variant="outline" @click="$wire.activeTab = 'shipping'">
                            Shipping
                        </flux:button>

                        <flux:button class="w-full rounded-none! cursor-pointer justify-start!" variant="ghost"
                            x-bind:class="{ 'bg-zinc-200!': $wire.activeTab === 'linked-products' }" icon="link"
                            icon-variant="outline" @click="$wire.activeTab = 'linked-products'">
                            Linked Products
                        </flux:button>

                        <flux:button class="w-full rounded-none! cursor-pointer justify-start!" variant="ghost"
                            x-bind:class="{
                                'bg-zinc-200!': $wire.activeTab === 'attributes',
                            }"
                            icon="tag" icon-variant="outline" @click="$wire.activeTab = 'attributes'">
                            Attributes
                        </flux:button>

                        <flux:button wire:show="form.product_type === 'variable'"
                            class="w-full rounded-none! cursor-pointer justify-start!" variant="ghost"
                            x-bind:class="{ 'bg-zinc-200!': $wire.activeTab === 'variations' }" icon="squares-2x2"
                            icon-variant="outline" @click="$wire.activeTab = 'variations'">
                            Variations
                        </flux:button>

                        <flux:button class="w-full rounded-none! cursor-pointer justify-start!" variant="ghost"
                            x-bind:class="{ 'bg-zinc-200!': $wire.activeTab === 'advanced' }" icon="cog"
                            icon-variant="outline" @click="$wire.activeTab = 'advanced'">
                            Advanced
                        </flux:button>
                    </div>

                    <div class="col-span-3 p-5">
                        {{-- General --}}
                        <div wire:show="activeTab == 'general'" class="space-y-5">
                            <flux:input :label="__('Regular Price')" type="number" />
                            <flux:input :label="__('Sale Price')" type="number" />
                        </div>

                        {{-- Inventory --}}
                        <div wire:show="activeTab == 'inventory'" class="space-y-5">

                            {{-- Manage stock --}}
                            <flux:field>
                                <flux:label>Manage Stock</flux:label>

                                <flux:checkbox wire:model="form.manage_stock"
                                    label="Enable stock management for this product" />
                            </flux:field>

                            <div wire:show="form.manage_stock" class="space-y-5">
                                <flux:input wire:model="form.stock_quantity" :label="__('Stock Quantity')"
                                    type="number" />

                                <flux:select :label="__('Allow backorder?')">
                                    <flux:select.option value="no">Do not allow</flux:select.option>
                                    <flux:select.option value="notify">Allow, but notify customer</flux:select.option>
                                    <flux:select.option value="yes">Allow</flux:select.option>
                                </flux:select>

                                <flux:input wire:model="form.low_stock_threshold" :label="__('Low Stock Threshold')"
                                    type="number" />
                            </div>

                            {{-- Stock Status --}}
                            <div wire:show="!form.manage_stock">
                                <flux:select wire:model="form.stock_status" label="Stock Status *">
                                    <flux:select.option value="in_stock">
                                        In Stock
                                    </flux:select.option>
                                    <flux:select.option value="out_of_stock">
                                        Out of Stock
                                    </flux:select.option>
                                    <flux:select.option value="backorder">
                                        Backorder
                                    </flux:select.option>
                                </flux:select>
                            </div>

                            <flux:separator />
                            <flux:field>
                                <flux:label>Sold Individually</flux:label>

                                <flux:checkbox
                                    label="Enable this to only allow one time to be bought in a single order" />
                            </flux:field>
                        </div>

                        {{-- Shipping --}}
                        <div wire:show="activeTab == 'shipping'" class="space-y-5">
                            <flux:input type="number" wire:model="form.weight" label=" Weight (kg)" placeholder="0.00"
                                step="0.01" min="0" />

                            <flux:field>
                                <flux:label>Dimensions</flux:label>

                                <flux:input.group>
                                    <flux:input type="number" wire:model="form.length" placeholder="Length (0.00)"
                                        step="0.01" min="0" />

                                    <flux:input type="number" wire:model="form.width" placeholder="Width (0.00)"
                                        step="0.01" min="0" />

                                    <flux:input type="number" wire:model="form.height" placeholder="Height (0.00)"
                                        step="0.01" min="0" />
                                </flux:input.group>

                                <flux:error name="form.length" />
                                <flux:error name="form.width" />
                                <flux:error name="form.height" />
                            </flux:field>
                        </div>

                        {{-- Linked Products --}}
                        <div wire:show="activeTab == 'linked-products'" class="space-y-5">
                            <flux:input :label="__('Up-Sells')" />
                            <flux:input :label="__('Cross-Sells')" />
                        </div>

                        {{-- Attributes --}}
                        <div wire:show="activeTab == 'attributes'" class="space-y-5">
                            <flux:input :label="__('Attributes')" />
                        </div>

                        {{-- Variations --}}
                        <div wire:show="activeTab == 'variations'" class="space-y-5">
                            <flux:input :label="__('Variations')" />
                        </div>
                    </div>
                </div>

            </flux:card>

            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>SEO & Meta Information</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    <!-- Meta title -->
                    <flux:input wire:model="form.meta_title" label="Meta Title"
                        placeholder="SEO title for this product" />

                    <!-- Meta description -->
                    <flux:textarea wire:model="form.meta_description" label="Meta Description" rows="3"
                        placeholder="SEO description for this product" />

                    <!-- Meta keywords -->
                    <flux:input wire:model="form.meta_keywords" label="Meta Keywords"
                        placeholder="keyword1, keyword2, keyword3"
                        description:trailing="Separate keywords with commas" />

                    <flux:field>
                        <flux:label>Canonical URL</flux:label>
                        <flux:input.group>
                            <flux:input.group.prefix>{{ config('app.url') }}</flux:input.group.prefix>
                            <flux:input wire:model="form.canonical_url" placeholder="products" />
                        </flux:input.group>

                        <flux:error name="form.canonical_url" />
                    </flux:field>
                </div>

            </flux:card>
        </div>

        <div class="col-span-1 space-y-5">
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Status & Visibility</flux:heading>
                </div>
                <div class="p-5 space-y-5">
                    {{-- Publication Status --}}

                    <flux:select wire:model="form.status" label="Publication Status">
                        <flux:select.option value="draft">Draft</flux:select.option>
                        <flux:select.option value="published">Published</flux:select.option>
                        <flux:select.option value="archived">Archived</flux:select.option>
                    </flux:select>

                    <flux:separator />

                    {{-- Visibility Options --}}
                    <div class="pt-2 space-y-3 ">
                        <flux:field variant="inline">
                            <flux:checkbox wire:model="form.is_active" />
                            <flux:label class="flex flex-col items-start">
                                <p>Active</p>
                                <p class="text-xs text-zinc-500">Display on website</p>
                            </flux:label>
                            <flux:error name="terms" />
                        </flux:field>

                        <flux:field variant="inline">
                            <flux:checkbox wire:model="form.is_featured" />
                            <flux:label class="flex flex-col items-start">
                                <p> Featured</p>
                                <p class="text-xs text-zinc-500">Show in featured section</p>
                            </flux:label>
                            <flux:error name="terms" />
                        </flux:field>
                    </div>
                </div>
            </flux:card>



            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Product Image</flux:heading>
                </div>


                <div class="p-5">
                    <input type="file" class="hidden" id="product-image-input" wire:model="form.image" />

                    @if ($form->image)
                        <div class="space-y-3">
                            <div @click="document.getElementById('product-image-input').click()"
                                class="relative mx-auto w-full aspect-square rounded-sm overflow-hidden border-2 border-zinc-200">
                                <img src="{{ $form->image->temporaryUrl() }}" alt="Product Image preview"
                                    class="w-full h-full object-cover">
                            </div>

                            <flux:text>Click the image to edit or update</flux:text>
                            <flux:link wire:click="$set('form.image', null)"
                                class="text-sm text-red-500 cursor-pointer">Remove Image
                            </flux:link>
                        </div>
                    @else
                        <flux:link @click="document.getElementById('product-image-input').click()"
                            class="text-sm text-sheffield-blue cursor-pointer">Set
                            product image
                        </flux:link>
                    @endif
                </div>

            </flux:card>

            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Product Gallery</flux:heading>
                </div>

                <div class="p-5">
                    <input type="file" class="hidden" id="product-gallery-input" wire:model="form.images"
                        multiple />

                    @if (!empty($form->images) || !empty($form->existingImages))
                        <div class="grid grid-cols-3 gap-3 mb-3">
                            @foreach ($form->images as $index => $img)
                                <div
                                    class="relative mx-auto w-full aspect-square rounded-sm overflow-hidden border-2 border-zinc-200">
                                    <img src="{{ $img->temporaryUrl() }}" alt="Image Image preview"
                                        class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <flux:link @click="document.getElementById('product-gallery-input').click()"
                        class="text-sm text-sheffield-blue cursor-pointer">Set
                        product gallery images
                    </flux:link>
                </div>
            </flux:card>

            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Product Categories</flux:heading>
                </div>
                <div class="p-5 max-h-96 overflow-y-auto">
                    <div class="space-y-2">
                        @foreach ($this->categories as $category)
                            <div class="flex items-center gap-2">
                                @if ($category['depth'] > 0)
                                    <flux:icon.chevron-right variant="micro" class="text-zinc-400 ms-2" />
                                @endif

                                <flux:checkbox wire:model="form.category_ids" :value="$category['id']"
                                    :label="$category['name']" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </flux:card>

            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Product Tag</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    <flux:input.group>
                        <flux:input />
                        <flux:button>Add</flux:button>
                    </flux:input.group>

                    <flux:text>Seperate tags with commas</flux:text>

                    <flux:link class="text-sm text-sheffield-blue">Choose from the most used tags</flux:link>

                </div>
            </flux:card>
        </div>
    </form>
</div>
