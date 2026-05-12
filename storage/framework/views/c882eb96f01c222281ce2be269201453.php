<?php

use App\Enums\{OrderStatus, PaymentStatus};
use App\Models\Order;
use Livewire\Attributes\{Computed, Layout, Title};
use Livewire\Component;
use App\Services\CartService;

new #[Title('Order Details')] #[Layout('layouts.customer')] class extends Component {
    public Order $order;

    public function mount(Order $order): void
    {
        // Guard: order must belong to the authenticated customer
        if ($order->user_id !== auth()->id()) {
            $this->redirectRoute('customer.orders.index', navigate: true);
            return;
        }

        $this->order = $order
            ->load([
                'items.product.brand',
                'payment',
                'statusHistories',
                'quote',
            ])
            ->loadCount('items');
    }

    // =====================================================
    // Computed
    // =====================================================

    #[Computed]
    public function isPaid(): bool
    {
        return $this->order->payment?->status?->value === PaymentStatus::PAID->value;
    }

    #[Computed]
    public function hasKraReceipt(): bool
    {
        return $this->order->hasKraReceipt();
    }

    #[Computed]
    public function isAwaitingKraValidation(): bool
    {
        return $this->order->isAwaitingKraValidation();
    }

    #[Computed]
    public function hasSapSyncFailed(): bool
    {
        return $this->order->hasSapSyncFailed();
    }

    // =====================================================
    // Actions
    // =====================================================

    public function buyAgain(int $productId): void
    {
        try {
            app(CartService::class)->addItem($productId, 1);
            $this->dispatch('cart-updated');
            $this->dispatch('notify', title: 'Cart Updated', variant: 'success', message: 'Item added to your cart');
        } catch (\RuntimeException $th) {
            $this->dispatch('notify', title: 'Add to Cart Failed', variant: 'danger', message: $th->getMessage() ?: 'Unable to add item to cart');
        }
    }
};
?>

<div>
    <?php if (isset($component)) { $__componentOriginalc7f54b8f583d0f8b3734fff24e9ce48e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7f54b8f583d0f8b3734fff24e9ce48e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.card','data' => ['title' => 'Order','titleEm' => '#' . $order->reference]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Order','titleEm' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('#' . $order->reference)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('icon', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal21f15c70e6086ddbf85b176abe9e3a93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal21f15c70e6086ddbf85b176abe9e3a93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.package','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.package'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal21f15c70e6086ddbf85b176abe9e3a93)): ?>
<?php $attributes = $__attributesOriginal21f15c70e6086ddbf85b176abe9e3a93; ?>
<?php unset($__attributesOriginal21f15c70e6086ddbf85b176abe9e3a93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal21f15c70e6086ddbf85b176abe9e3a93)): ?>
<?php $component = $__componentOriginal21f15c70e6086ddbf85b176abe9e3a93; ?>
<?php unset($__componentOriginal21f15c70e6086ddbf85b176abe9e3a93); ?>
<?php endif; ?>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('action', null, []); ?> 
            <a href="<?php echo e(route('customer.orders.index')); ?>" wire:navigate
                class="flex items-center gap-1.5 text-xs font-bold tracking-wider uppercase text-zinc-500 hover:text-primary transition-colors">
                <?php if (isset($component)) { $__componentOriginal93e8a1cf63877447e3f60f50005ff258 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93e8a1cf63877447e3f60f50005ff258 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.chevron-left','data' => ['class' => 'w-3.5 h-3.5 stroke-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.chevron-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3.5 h-3.5 stroke-2']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal93e8a1cf63877447e3f60f50005ff258)): ?>
<?php $attributes = $__attributesOriginal93e8a1cf63877447e3f60f50005ff258; ?>
<?php unset($__attributesOriginal93e8a1cf63877447e3f60f50005ff258); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal93e8a1cf63877447e3f60f50005ff258)): ?>
<?php $component = $__componentOriginal93e8a1cf63877447e3f60f50005ff258; ?>
<?php unset($__componentOriginal93e8a1cf63877447e3f60f50005ff258); ?>
<?php endif; ?>
                Back to Orders
            </a>
         <?php $__env->endSlot(); ?>

        <div class="flex flex-col gap-8">
            
            <?php
                $mainPath = [
                    OrderStatus::PENDING,
                    OrderStatus::CONFIRMED,
                    OrderStatus::PROCESSING,
                    OrderStatus::SHIPPED,
                    OrderStatus::DELIVERED,
                ];
                $currentStatus = $order->status;
                $currentStatusIndex = array_search($currentStatus, $mainPath);
                $isTerminal = in_array($currentStatus, [OrderStatus::CANCELLED, OrderStatus::RETURNED]);
                $histories = $order->statusHistories->keyBy('to_status');
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isTerminal): ?>
                <div class="relative w-full py-4 px-2 overflow-x-auto scrollbar-hide">
                    <div class="min-w-[600px] flex justify-between relative">
                        
                        <div class="absolute top-4.5 left-0 w-full h-1 bg-zinc-100 -z-0"></div>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStatusIndex !== false && $currentStatusIndex > 0): ?>
                            <div class="absolute top-4.5 left-0 h-1 bg-primary -z-0 transition-all duration-500"
                                style="width: <?php echo e(($currentStatusIndex / (count($mainPath) - 1)) * 100); ?>%"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mainPath; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $reached = $currentStatusIndex !== false && $index <= $currentStatusIndex;
                                $isCurrent = $currentStatusIndex !== false && $index === $currentStatusIndex;
                                $history = $histories->get($step->value);
                            ?>
                            <div class="relative z-10 flex flex-col items-center group w-24">
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300',
                                    'bg-primary text-white shadow-lg ring-4 ring-[#fff8f6]' => $reached,
                                    'bg-white text-zinc-300 border-2 border-zinc-100' => !$reached,
                                ]); ?>">
                                    <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => $step->icon(),'class' => 'size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($step->icon()),'class' => 'size-5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                                </div>
                                <div class="mt-3 text-center">
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                        'text-[11px] font-bold uppercase tracking-wider',
                                        'text-zinc-950' => $reached,
                                        'text-zinc-400' => !$reached,
                                    ]); ?>"><?php echo e($step->label()); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history): ?>
                                        <div class="text-[9px] text-zinc-500 mt-0.5 font-medium whitespace-nowrap">
                                            <?php echo e($history->created_at->format('d M, g:i A')); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                
                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'flex items-center gap-4 p-4 rounded-sm border',
                    'bg-red-50 border-red-100 text-red-700' => $currentStatus === OrderStatus::CANCELLED,
                    'bg-orange-50 border-orange-100 text-orange-700' => $currentStatus === OrderStatus::RETURNED,
                ]); ?>">
                    <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center shrink-0">
                        <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => $currentStatus->icon(),'class' => 'size-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentStatus->icon()),'class' => 'size-6']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $attributes = $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2)): ?>
<?php $component = $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2; ?>
<?php unset($__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2); ?>
<?php endif; ?>
                    </div>
                    <div>
                        <div class="text-sm font-bold uppercase tracking-wider">Order <?php echo e($currentStatus->label()); ?></div>
                        <div class="text-xs opacity-80 mt-1">
                            This order was <?php echo e(strtolower($currentStatus->label())); ?> on
                            <?php echo e($order->updated_at->format('M j, Y \a\t g:i A')); ?>.
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <div>
                        <h3 class="text-[15px] font-black uppercase tracking-wider text-zinc-950 mb-4 font-serif">
                            Items in Your Order <span class="text-primary ml-1">(<?php echo e($order->items_count); ?>)</span>
                        </h3>

                        <div class="flex flex-col border border-zinc-200 divide-y divide-zinc-200 rounded-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $name = $item->product_snapshot['name'] ?? ($item->product?->name ?? '—');
                                    $sku = $item->product_snapshot['sku'] ?? null;
                                    $brand = $item->product?->brand?->name ?? null;
                                    $imagePath = $item->product_image_url ?? $item->product?->image_url;
                                    $inStock = ($item->product?->stock_quantity ?? 0) > 0;
                                ?>

                                <div class="flex items-center gap-4 p-4 hover:bg-zinc-50 transition-colors">
                                    <div class="w-16 h-16 bg-zinc-50 flex items-center justify-center shrink-0 border border-zinc-100 relative">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imagePath): ?>
                                            <img src="<?php echo e(asset($imagePath)); ?>" alt="<?php echo e($name); ?>"
                                                class="w-[85%] h-[85%] object-contain">
                                        <?php else: ?>
                                            <?php if (isset($component)) { $__componentOriginal2d7605e1adbee8a1737ebec29a91da61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d7605e1adbee8a1737ebec29a91da61 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.photo','data' => ['class' => 'w-8 h-8 text-zinc-200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-zinc-200']); ?>
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
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-[10px] font-bold tracking-widest uppercase text-zinc-500 mb-0.5">
                                            <?php echo e($brand); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sku): ?> · SKU: <?php echo e($sku); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="text-[14px] font-bold text-zinc-950 truncate mb-1">
                                            <?php echo e($name); ?>

                                        </div>
                                        <div class="text-[12px] text-zinc-600 font-medium">
                                            <?php echo e($item->quantity); ?> × <?php echo e(format_currency($item->unit_price_cents / 100)); ?>

                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2 shrink-0">
                                        <div class="text-[14px] font-black text-primary font-barlow-condensed tracking-tight">
                                            <?php echo e(format_currency($item->total_cents / 100)); ?>

                                        </div>
                                        <button wire:click="buyAgain(<?php echo e($item->product_id); ?>)" <?php if(!$inStock): ?> disabled <?php endif; ?>
                                            class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 hover:text-primary disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                            <?php echo e($inStock ? 'Buy Again' : 'Out of Stock'); ?>

                                        </button>
                                    </div>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->wasConvertedFromQuote() && $order->quote): ?>
                        <div class="flex items-center gap-3 p-4 bg-[#f0f9ff] border border-[#bae6fd] rounded-sm text-blue-800">
                            <?php if (isset($component)) { $__componentOriginal372652fcc747cd9bb1f591829ed1255a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal372652fcc747cd9bb1f591829ed1255a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.tag','data' => ['class' => 'size-5 shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.tag'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-5 shrink-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal372652fcc747cd9bb1f591829ed1255a)): ?>
<?php $attributes = $__attributesOriginal372652fcc747cd9bb1f591829ed1255a; ?>
<?php unset($__attributesOriginal372652fcc747cd9bb1f591829ed1255a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal372652fcc747cd9bb1f591829ed1255a)): ?>
<?php $component = $__componentOriginal372652fcc747cd9bb1f591829ed1255a; ?>
<?php unset($__componentOriginal372652fcc747cd9bb1f591829ed1255a); ?>
<?php endif; ?>
                            <div class="text-xs font-medium leading-relaxed">
                                This order was created from quote <?php if (isset($component)) { $__componentOriginal54ddb5b70b37b1e1cf0f2f95e4c53477 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal54ddb5b70b37b1e1cf0f2f95e4c53477 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::link','data' => ['href' => route('customer.quotes.show', $order->quote),'wire:navigate' => true,'class' => 'font-bold underline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('customer.quotes.show', $order->quote)),'wire:navigate' => true,'class' => 'font-bold underline']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php echo e($order->quote->reference); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal54ddb5b70b37b1e1cf0f2f95e4c53477)): ?>
<?php $attributes = $__attributesOriginal54ddb5b70b37b1e1cf0f2f95e4c53477; ?>
<?php unset($__attributesOriginal54ddb5b70b37b1e1cf0f2f95e4c53477); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal54ddb5b70b37b1e1cf0f2f95e4c53477)): ?>
<?php $component = $__componentOriginal54ddb5b70b37b1e1cf0f2f95e4c53477; ?>
<?php unset($__componentOriginal54ddb5b70b37b1e1cf0f2f95e4c53477); ?>
<?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="flex flex-col gap-6">
                    
                    <div class="bg-zinc-50 border border-zinc-200 rounded-sm overflow-hidden">
                        <div class="px-5 py-4 border-b border-zinc-200 bg-white">
                            <h3 class="text-[13px] font-bold uppercase tracking-widest text-zinc-950 font-serif">Order Summary</h3>
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="flex justify-between text-[13px]">
                                <span class="text-zinc-500 font-medium">Subtotal</span>
                                <span class="text-zinc-950 font-bold"><?php echo e(format_currency($order->subtotal)); ?></span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->discount > 0): ?>
                                <div class="flex justify-between text-[13px]">
                                    <span class="text-green-600 font-medium">Discount</span>
                                    <span class="text-green-600 font-bold">− <?php echo e(format_currency($order->discount)); ?></span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex justify-between text-[13px]">
                                <span class="text-zinc-500 font-medium">Shipping</span>
                                <span class="text-zinc-950 font-bold">
                                    <?php echo e($order->shipping == 0 ? 'FREE' : format_currency($order->shipping)); ?>

                                </span>
                            </div>
                            <div class="pt-3 border-t border-zinc-200 flex justify-between items-baseline">
                                <span class="text-[14px] font-bold uppercase tracking-widest text-zinc-950">Total</span>
                                <span class="text-[24px] font-black text-primary font-barlow-condensed leading-none">
                                    <?php echo e(format_currency($order->total)); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-white border border-zinc-200 rounded-sm overflow-hidden">
                        <div class="px-5 py-3 border-b border-zinc-200">
                            <h3 class="text-[12px] font-bold uppercase tracking-widest text-zinc-950 font-serif">Shipping Address</h3>
                        </div>
                        <div class="p-5 text-[13px] leading-relaxed">
                            <div class="font-bold text-zinc-950 mb-1">
                                <?php echo e(trim(($order->shipping_address['first_name'] ?? '') . ' ' . ($order->shipping_address['last_name'] ?? '')) ?: $order->shipping_address['full_name'] ?? 'N/A'); ?>

                            </div>
                            <div class="text-zinc-500">
                                <?php echo e(format_phone($order->shipping_address['phone_number'] ?? '')); ?><br>
                                <?php echo e($order->shipping_address['address'] ?? 'N/A'); ?><br>
                                <?php echo e(implode(', ', array_filter([$order->shipping_address['area'] ?? null, $order->shipping_address['county'] ?? null]))); ?>

                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->shipping_snapshot['method_name'] ?? null): ?>
                                <div class="mt-4 pt-4 border-t border-zinc-100 flex items-start gap-3">
                                    <?php if (isset($component)) { $__componentOriginal7a62c53a9a388e917a2ccf86cb1b44e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a62c53a9a388e917a2ccf86cb1b44e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.truck','data' => ['class' => 'size-5 text-zinc-400 shrink-0 mt-0.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.truck'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-5 text-zinc-400 shrink-0 mt-0.5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7a62c53a9a388e917a2ccf86cb1b44e8)): ?>
<?php $attributes = $__attributesOriginal7a62c53a9a388e917a2ccf86cb1b44e8; ?>
<?php unset($__attributesOriginal7a62c53a9a388e917a2ccf86cb1b44e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7a62c53a9a388e917a2ccf86cb1b44e8)): ?>
<?php $component = $__componentOriginal7a62c53a9a388e917a2ccf86cb1b44e8; ?>
<?php unset($__componentOriginal7a62c53a9a388e917a2ccf86cb1b44e8); ?>
<?php endif; ?>
                                    <div>
                                        <div class="text-[11px] font-bold uppercase text-zinc-400 mb-0.5">Method</div>
                                        <div class="font-bold text-zinc-900 leading-tight"><?php echo e($order->shipping_snapshot['method_name']); ?></div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->shipping_snapshot['delivery_window'] ?? null): ?>
                                            <div class="text-[11px] text-zinc-500 mt-1 italic font-medium">Est. <?php echo e($order->shipping_snapshot['delivery_window']); ?></div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->tracking_number): ?>
                                <div class="mt-3 pt-3 border-t border-zinc-100">
                                    <div class="text-[11px] font-bold uppercase text-zinc-400 mb-0.5">Tracking Number</div>
                                    <div class="font-mono text-[13px] font-bold text-primary"><?php echo e($order->tracking_number); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->courier_name): ?>
                                        <div class="text-[11px] text-zinc-500 mt-0.5">via <?php echo e($order->courier_name); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="bg-white border border-zinc-200 rounded-sm overflow-hidden">
                        <div class="px-5 py-3 border-b border-zinc-200">
                            <h3 class="text-[12px] font-bold uppercase tracking-widest text-zinc-950 font-serif">Payment Method</h3>
                        </div>
                        <div class="p-5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment): ?>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-[13px] font-bold text-zinc-950 uppercase tracking-tight">
                                        <?php echo e($order->payment->gateway ?? '—'); ?>

                                    </div>
                                    <?php if (isset($component)) { $__componentOriginal4cc377eda9b63b796b6668ee7832d023 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4cc377eda9b63b796b6668ee7832d023 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::badge.index','data' => ['size' => 'sm','color' => $order->payment->status->color()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm','color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($order->payment->status->color())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                        <?php echo e($order->payment->status->label()); ?>

                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4cc377eda9b63b796b6668ee7832d023)): ?>
<?php $attributes = $__attributesOriginal4cc377eda9b63b796b6668ee7832d023; ?>
<?php unset($__attributesOriginal4cc377eda9b63b796b6668ee7832d023); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4cc377eda9b63b796b6668ee7832d023)): ?>
<?php $component = $__componentOriginal4cc377eda9b63b796b6668ee7832d023; ?>
<?php unset($__componentOriginal4cc377eda9b63b796b6668ee7832d023); ?>
<?php endif; ?>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-[12px]">
                                        <span class="text-zinc-500">Amount Paid</span>
                                        <span class="font-bold text-zinc-950"><?php echo e(format_currency(($order->payment->amount_cents ?? 0) / 100)); ?></span>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment->paid_at): ?>
                                        <div class="flex justify-between text-[12px]">
                                            <span class="text-zinc-500">Transaction Date</span>
                                            <span class="font-bold text-zinc-950"><?php echo e($order->payment->paid_at->format('M j, Y')); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isPaid): ?>
                                    <div class="mt-6 pt-5 border-t border-zinc-200">
                                        <h4 class="text-[11px] font-bold uppercase tracking-widest text-zinc-400 mb-3">Tax Invoice</h4>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->hasKraReceipt): ?>
                                            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['tag' => 'a','href' => route('customer.orders.receipt', $order),'size' => 'sm','variant' => 'customer-primary','icon' => 'arrow-down-tray','class' => 'w-full font-bold uppercase tracking-wider text-[10px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'a','href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('customer.orders.receipt', $order)),'size' => 'sm','variant' => 'customer-primary','icon' => 'arrow-down-tray','class' => 'w-full font-bold uppercase tracking-wider text-[10px]']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                                Download Invoice
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
                                            <div class="mt-2 text-center">
                                                <div class="text-[10px] text-emerald-600 font-bold uppercase tracking-wide">KRA Validated</div>
                                                <div class="text-[9px] text-zinc-500 mt-0.5">CU No: <?php echo e($order->kra_cu_number); ?></div>
                                            </div>
                                        <?php elseif($this->isAwaitingKraValidation): ?>
                                            <div class="p-3 bg-purple-50 border border-purple-100 rounded-sm text-[11px] text-purple-700 leading-relaxed font-medium">
                                                Pending KRA validation. This usually takes a few minutes.
                                            </div>
                                        <?php elseif($this->hasSapSyncFailed): ?>
                                            <div class="p-3 bg-red-50 border border-red-100 rounded-sm text-[11px] text-red-700 leading-relaxed font-medium">
                                                Invoice generation issue. Support has been notified.
                                            </div>
                                        <?php else: ?>
                                            <div class="p-3 bg-zinc-50 border border-zinc-100 rounded-sm text-[11px] text-zinc-500 leading-relaxed italic">
                                                Your invoice is being prepared...
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php else: ?>
                                <div class="p-4 bg-zinc-50 border border-zinc-200 border-dashed text-center">
                                    <div class="text-[12px] text-zinc-400 italic">No payment info available</div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mt-4 pt-8 border-t border-zinc-200 text-center pb-4">
                <div class="text-[13px] text-zinc-500">
                    Need help with this order? <a href="#" class="font-bold text-zinc-950 hover:text-primary transition-colors ml-1">Contact Support</a>
                </div>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7f54b8f583d0f8b3734fff24e9ce48e)): ?>
<?php $attributes = $__attributesOriginalc7f54b8f583d0f8b3734fff24e9ce48e; ?>
<?php unset($__attributesOriginalc7f54b8f583d0f8b3734fff24e9ce48e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7f54b8f583d0f8b3734fff24e9ce48e)): ?>
<?php $component = $__componentOriginalc7f54b8f583d0f8b3734fff24e9ce48e; ?>
<?php unset($__componentOriginalc7f54b8f583d0f8b3734fff24e9ce48e); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views\pages\customer\orders\test.blade.php ENDPATH**/ ?>