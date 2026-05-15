<?php

use App\Models\Product;
use App\Services\QuoteBasketService;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

new class extends Component {
    public string $search = '';
    public int $perPage = 18;
    public int $page = 1;
    public bool $hasMore = true;
    public array $loadedProducts = [];
    public array $addedProductIds = [];

    public function mount(): void
    {
        $this->syncBasketState();
        $this->loadProducts();
    }

    public function syncBasketState(): void
    {
        $this->addedProductIds = app(QuoteBasketService::class)->items()->pluck('product_id')->toArray();
    }

    public function updatedSearch(): void
    {
        $this->reset(['page', 'loadedProducts', 'hasMore']);
        $this->loadProducts();
    }

    public function loadMore(): void
    {
        if (!$this->hasMore) {
            return;
        }
        $this->page++;
        $this->loadProducts();
    }

    public function loadProducts(): void
    {
        $query = Product::query()
            ->select(['id', 'name', 'slug', 'image_path', 'price', 'sale_price', 'type', 'requires_quotation', 'status', 'visibility'])
            ->with([
                'variants' => fn($q) => $q
                    ->where('is_active', true)
                    ->whereNotNull('price')
                    ->select(['id', 'product_id', 'price', 'sale_price']),
            ])
            ->active()
            ->visibleInSearch()
            ->when($this->search, fn(Builder $q) => $q->where(fn(Builder $q2) => $q2->where('name', 'like', "%{$this->search}%")->orWhere('sku', 'like', "%{$this->search}%")))
            ->orderBy('name')
            ->limit($this->perPage + 1)
            ->offset(($this->page - 1) * $this->perPage)
            ->get();

        $this->hasMore = $query->count() > $this->perPage;

        $newItems = $query
            ->take($this->perPage)
            ->map(
                fn($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'image_url' => $p->image_url,
                    'requires_quotation' => $p->requires_quotation,
                    'display_price' => $p->display_price,
                    'has_price_prefix' => $p->has_price_prefix,
                    'display_price_prefix' => $p->display_price_prefix,
                ],
            )
            ->toArray();

        $this->loadedProducts = [...$this->loadedProducts, ...$newItems];
    }

    public function addToQuote(int $productId): void
    {
        app(QuoteBasketService::class)->add($productId, 1);
        $this->addedProductIds[] = $productId;
        $this->dispatch('quote-basket-updated');
        $this->dispatch('quote-item-added');
    }

    public function removeFromQuote(int $productId): void
    {
        app(QuoteBasketService::class)->remove($productId);
        $this->addedProductIds = array_values(array_filter($this->addedProductIds, fn($id) => $id !== $productId));
        $this->dispatch('quote-basket-updated');
        $this->dispatch('quote-item-removed');
    }
};
?>

<div class="flex flex-col h-full">

    
    <div class="px-4 pt-4 pb-3 border-b border-zinc-200 dark:border-zinc-700 shrink-0">
        <div class="relative">
            <?php if (isset($component)) { $__componentOriginalc3d062a579167d374258253d48d4177f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc3d062a579167d374258253d48d4177f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.magnifying-glass','data' => ['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-zinc-400 pointer-events-none']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.magnifying-glass'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'absolute left-3 top-1/2 -translate-y-1/2 size-4 text-zinc-400 pointer-events-none']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc3d062a579167d374258253d48d4177f)): ?>
<?php $attributes = $__attributesOriginalc3d062a579167d374258253d48d4177f; ?>
<?php unset($__attributesOriginalc3d062a579167d374258253d48d4177f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3d062a579167d374258253d48d4177f)): ?>
<?php $component = $__componentOriginalc3d062a579167d374258253d48d4177f; ?>
<?php unset($__componentOriginalc3d062a579167d374258253d48d4177f); ?>
<?php endif; ?>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products by name or SKU..."
                class="customer-input pl-9 bg-white w-full" autocomplete="off" />
        </div>
    </div>

    
    <div class="flex-1 overflow-y-auto p-4 @container" x-data="{ loading: false }"
        x-on:scroll.passive="
            if (!loading && ($el.scrollTop + $el.clientHeight >= $el.scrollHeight - 100)) {
                loading = true;
                $wire.loadMore().then(() => loading = false);
            }
        ">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($loadedProducts) > 0): ?>
            <div class="grid grid-cols-2 @sm:grid-cols-3 @lg:grid-cols-4 @xl:grid-cols-5 gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $loadedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $isAdded = in_array($product['id'], $addedProductIds); ?>

                    <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'picker-'.e($product['id']).''; ?>wire:key="picker-<?php echo e($product['id']); ?>"
                        class="flex flex-col overflow-hidden group bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 hover:shadow-[0px_0px_6px_2px_rgba(0,0,0,0.08)] transition-all duration-200">

                        
                        <div class="relative aspect-square bg-zinc-50 dark:bg-zinc-800 overflow-hidden">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product['image_url']): ?>
                                <img src="<?php echo e($product['image_url']); ?>" alt="<?php echo e($product['name']); ?>"
                                    class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
                                    loading="lazy" />
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal2d7605e1adbee8a1737ebec29a91da61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d7605e1adbee8a1737ebec29a91da61 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.photo','data' => ['class' => 'size-10 text-zinc-300 stroke-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-10 text-zinc-300 stroke-1']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2d7605e1adbee8a1737ebec29a91da61)): ?>
<?php $attributes = $__attributesOriginal2d7605e1adbee8a1737ebec29a91da61; ?>
<?php unset($__attributesOriginal2d7605e1adbee8a1737ebec29a91da61); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2d7605e1adbee8a1737ebec29a91da61)): ?>
<?php $component = $__componentOriginal2d7605e1adbee8a1737ebec29a91da61; ?>
<?php unset($__componentOriginal2d7605e1adbee8a1737ebec29a91da61); ?>
<?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <div class="absolute bottom-2 right-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAdded): ?>
                                    <button type="button" wire:click="removeFromQuote(<?php echo e($product['id']); ?>)"
                                        class="w-7 h-7 flex items-center justify-center rounded-full bg-primary text-on-primary shadow-md hover:bg-primary/80 transition-colors cursor-pointer"
                                        title="Remove from quote">
                                        <?php if (isset($component)) { $__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.minus','data' => ['class' => 'size-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.minus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-3.5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50)): ?>
<?php $attributes = $__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50; ?>
<?php unset($__attributesOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50)): ?>
<?php $component = $__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50; ?>
<?php unset($__componentOriginal01ef35ccfb2d03cc6412dbe2dc9e1a50); ?>
<?php endif; ?>
                                    </button>
                                <?php else: ?>
                                    <button type="button" wire:click="addToQuote(<?php echo e($product['id']); ?>)"
                                        class="w-7 h-7 flex items-center justify-center rounded-full bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 shadow-md border border-zinc-200 dark:border-zinc-600 hover:bg-primary hover:text-on-primary hover:border-primary transition-colors cursor-pointer"
                                        title="Add to quote">
                                        <?php if (isset($component)) { $__componentOriginal37c717510e7a32140849d8d5dd9d632e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal37c717510e7a32140849d8d5dd9d632e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.plus','data' => ['class' => 'size-3.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-3.5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal37c717510e7a32140849d8d5dd9d632e)): ?>
<?php $attributes = $__attributesOriginal37c717510e7a32140849d8d5dd9d632e; ?>
<?php unset($__attributesOriginal37c717510e7a32140849d8d5dd9d632e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal37c717510e7a32140849d8d5dd9d632e)): ?>
<?php $component = $__componentOriginal37c717510e7a32140849d8d5dd9d632e; ?>
<?php unset($__componentOriginal37c717510e7a32140849d8d5dd9d632e); ?>
<?php endif; ?>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="p-2.5 space-y-0.5">
                            <p class="text-xs font-medium text-zinc-800 dark:text-zinc-100 line-clamp-2 leading-snug">
                                <?php echo e($product['name']); ?>

                            </p>
                            <div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product['requires_quotation']): ?>
                                    <span class="text-xs text-amber-600 font-medium">Quote only</span>
                                <?php elseif($product['display_price']): ?>
                                    <div class="flex items-baseline gap-1 flex-wrap">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product['has_price_prefix']): ?>
                                            <span
                                                class="text-[10px] text-zinc-400"><?php echo e($product['display_price_prefix']); ?></span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <span
                                            class="text-xs font-bold text-primary"><?php echo e($product['display_price']); ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-xs text-zinc-400">Price on request</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <?php if (isset($component)) { $__componentOriginalc3d062a579167d374258253d48d4177f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc3d062a579167d374258253d48d4177f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.magnifying-glass','data' => ['class' => 'size-10 text-zinc-300 mb-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.magnifying-glass'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-10 text-zinc-300 mb-3']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc3d062a579167d374258253d48d4177f)): ?>
<?php $attributes = $__attributesOriginalc3d062a579167d374258253d48d4177f; ?>
<?php unset($__attributesOriginalc3d062a579167d374258253d48d4177f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3d062a579167d374258253d48d4177f)): ?>
<?php $component = $__componentOriginalc3d062a579167d374258253d48d4177f; ?>
<?php unset($__componentOriginalc3d062a579167d374258253d48d4177f); ?>
<?php endif; ?>
                <p class="text-sm text-zinc-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                        No products found for "<?php echo e($search); ?>"
                    <?php else: ?>
                        No products available
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasMore): ?>
            <div class="flex items-center justify-center py-6">
                <div class="w-5 h-5 border-2 border-zinc-200 border-t-zinc-500 rounded-full animate-spin"></div>
            </div>
        <?php elseif(count($loadedProducts) > 0): ?>
            <p class="text-center text-xs text-zinc-400 py-4">All products loaded</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

</div>
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views\livewire\quote-product-picker.blade.php ENDPATH**/ ?>