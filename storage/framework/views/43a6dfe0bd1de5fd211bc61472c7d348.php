<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

new #[Title('Order Tracking')] #[Layout('layouts.customer')] class extends Component {
    public Order $order;

    public function mount(Order $order): void
    {
        // Guard: order must belong to the authenticated customer
        if ($order->user_id !== auth()->id()) {
            $this->redirectRoute('customer.orders.index', navigate: true);
            return;
        }

        $this->order = $order->load(['statusHistories.changedBy', 'quote']);
    }
};
?>

<div>
    <?php if (isset($component)) { $__componentOriginalc7f54b8f583d0f8b3734fff24e9ce48e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7f54b8f583d0f8b3734fff24e9ce48e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.card','data' => ['title' => 'Order','titleEm' => 'Tracking']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Order','titleEm' => 'Tracking']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

         <?php $__env->slot('icon', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal7a62c53a9a388e917a2ccf86cb1b44e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7a62c53a9a388e917a2ccf86cb1b44e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.truck','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.truck'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('action', null, []); ?> 
            <a href="<?php echo e(route('customer.orders.show', $order)); ?>" wire:navigate
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
                Back to Details
            </a>
         <?php $__env->endSlot(); ?>

        <div class="py-3">
            <div class="text-[10px] font-bold uppercase tracking-[0.15em] text-zinc-400 mb-1">Order Reference</div>
            <h2 class="font-barlow-condensed text-[24px] font-black text-zinc-950 leading-tight">#<?php echo e($order->reference); ?>

            </h2>
            <div class="text-[13px] text-zinc-500 mt-1">
                Placed on <?php echo e($order->created_at->format('d M Y')); ?> at <?php echo e($order->created_at->format('g:i A')); ?>

            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->wasConvertedFromQuote() && $order->quote): ?>
                <div class="flex items-center gap-2 mt-3 p-2 bg-blue-50 border border-blue-100 rounded-sm">
                    <?php if (isset($component)) { $__componentOriginal372652fcc747cd9bb1f591829ed1255a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal372652fcc747cd9bb1f591829ed1255a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.tag','data' => ['class' => 'size-3.5 text-blue-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.tag'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-3.5 text-blue-500']); ?>
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
                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-800">
                        Converted from quote
                        <a href="<?php echo e(route('customer.quotations.show', $order->quote)); ?>" wire:navigate
                            class="underline ml-1">
                            <?php echo e($order->quote->reference); ?>

                        </a>
                    </span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="relative px-2">
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

                $maxReachedIndex = 0;
                if ($currentStatusIndex !== false) {
                    $maxReachedIndex = $currentStatusIndex;
                }
                foreach ($histories as $to_status => $history) {
                    foreach ($mainPath as $i => $step) {
                        if ($step->value === $to_status && $i > $maxReachedIndex) {
                            $maxReachedIndex = $i;
                        }
                    }
                }

                $stepMeta = [
                    'pending' => [
                        'label' => 'Order Placed',
                        'desc' => 'Your order has been placed successfully.',
                    ],
                    'confirmed' => [
                        'label' => 'Payment Confirmed',
                        'desc' => 'Your payment was received and your order is confirmed.',
                    ],
                    'processing' => [
                        'label' => 'Being Prepared',
                        'desc' => 'Your items are being packed and getting ready.',
                    ],
                    'shipped' => [
                        'label' => 'Out for Delivery',
                        'desc' => 'Your order is on its way to you.',
                    ],
                    'delivered' => [
                        'label' => 'Delivered',
                        'desc' => 'Your order was delivered. Enjoy your purchase!',
                    ],
                ];
            ?>

            <div class="relative">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mainPath; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php
                        $reached = $index <= $maxReachedIndex;
                        $isCurrent = $currentStatusIndex !== false && $index === $currentStatusIndex;
                        
                        $history = $histories->get($step->value);
                        if (!$history && $step === OrderStatus::PENDING) {
                            $history = (object) ['created_at' => $order->created_at];
                        }
                        
                        $isLast = $index === count($mainPath) - 1;
                        $injectTerminalHere = $isTerminal && $index === $maxReachedIndex;
                        $meta = $stepMeta[$step->value];
                    ?>

                    <div class="relative flex gap-6 <?php echo e(($isLast && !$injectTerminalHere) ? 'pb-0' : 'pb-10'); ?>">

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isLast && !$injectTerminalHere): ?>
                            <?php
                                $nextStepIndex = $index + 1;
                                $nextReached = $nextStepIndex <= $maxReachedIndex;
                            ?>
                            <div
                                class="absolute left-4.5 top-9 bottom-0 w-0.75 z-0
                                <?php echo e($nextReached ? 'bg-primary' : 'bg-zinc-100'); ?>">
                            </div>
                        <?php elseif($injectTerminalHere): ?>
                            <div
                                class="absolute left-4.5 top-9 bottom-0 w-0.75 z-0 bg-primary">
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <div
                            class="relative z-10 shrink-0 w-9 h-9 rounded-full flex items-center justify-center transition-all duration-300
                            <?php echo e($reached
                                ? 'bg-primary text-white ring-4 ring-[#fff8f6]'
                                : 'bg-zinc-50 text-zinc-300 border border-zinc-100'); ?>">
                            <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => ''.e($step->icon()).'','class' => 'size-4.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($step->icon()).'','class' => 'size-4.5']); ?>
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

                        
                        <div class="flex-1 pt-0.5">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <div
                                        class="text-[14px] font-bold
                                        <?php echo e($reached ? 'text-zinc-950' : 'text-zinc-400'); ?>">
                                        <?php echo e($meta['label']); ?>


                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isCurrent): ?>
                                            <span
                                                class="ml-2 inline-flex items-center gap-1.5 text-[10px] font-extrabold tracking-widest uppercase text-primary bg-[#fff4f0] px-2 py-0.5 border border-[#ffe4da] rounded-sm">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span
                                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                                    <span
                                                        class="relative inline-flex rounded-full h-1.5 w-1.5 bg-primary"></span>
                                                </span>
                                                Current
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div
                                        class="text-[12px] mt-1 leading-relaxed
                                        <?php echo e($reached ? 'text-zinc-500 font-medium' : 'text-zinc-300'); ?>">
                                        <?php echo e($history ? $meta['desc'] : ($reached ? $meta['desc'] : 'Pending...')); ?>

                                    </div>
                                </div>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($history): ?>
                                    <div class="sm:text-right shrink-0">
                                        <div class="text-[12px] font-bold text-zinc-950">
                                            <?php echo e($history->created_at->format('M j, Y')); ?>

                                        </div>
                                        <div class="text-[11px] text-zinc-500 font-medium mt-0.5">
                                            <?php echo e($history->created_at->format('g:i A')); ?>

                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($injectTerminalHere): ?>
                        
                        <div class="relative flex gap-6 pb-0">
                            <div
                                class="relative z-10 shrink-0 w-9 h-9 rounded-full flex items-center justify-center
                                <?php echo e($currentStatus === OrderStatus::CANCELLED ? 'bg-red-50 text-red-600 border border-red-100 ring-4 ring-red-50/50' : 'bg-orange-50 text-brand-primary border border-orange-100 ring-4 ring-orange-50/50'); ?>">
                                <?php if (isset($component)) { $__componentOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7d5f44bf2a2d803ed0b55f72f1f82e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.index','data' => ['name' => ''.e($currentStatus->icon()).'','class' => 'size-4.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($currentStatus->icon()).'','class' => 'size-4.5']); ?>
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
                            <div class="flex-1 pt-0.5">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                    <div>
                                        <div class="text-[14px] font-bold <?php echo e($currentStatus === OrderStatus::CANCELLED ? 'text-red-600' : 'text-brand-primary'); ?>">
                                            <?php echo e($currentStatus === OrderStatus::CANCELLED ? 'Order Cancelled' : 'Order Returned'); ?>

                                            
                                            <span class="ml-2 inline-flex items-center gap-1.5 text-[10px] font-extrabold tracking-widest uppercase <?php echo e($currentStatus === OrderStatus::CANCELLED ? 'text-red-600 bg-red-50 border-red-100' : 'text-brand-primary bg-orange-50 border-orange-100'); ?> px-2 py-0.5 border rounded-sm">
                                                <span class="relative flex h-1.5 w-1.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full <?php echo e($currentStatus === OrderStatus::CANCELLED ? 'bg-red-600' : 'bg-brand-primary'); ?> opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 <?php echo e($currentStatus === OrderStatus::CANCELLED ? 'bg-red-600' : 'bg-brand-primary'); ?>"></span>
                                                </span>
                                                Current
                                            </span>
                                        </div>
                                        <div class="text-[12px] text-zinc-500 mt-1 font-medium">
                                            <?php echo e($currentStatus === OrderStatus::CANCELLED ? 'This order has been cancelled and will not be processed further.' : 'This order was returned by the customer.'); ?>

                                        </div>
                                    </div>
                                    <?php $terminalHistory = $histories->get($currentStatus->value); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($terminalHistory): ?>
                                        <div class="sm:text-right shrink-0">
                                            <div class="text-[12px] font-bold text-zinc-950">
                                                <?php echo e($terminalHistory->created_at->format('M j, Y')); ?>

                                            </div>
                                            <div class="text-[11px] text-zinc-500 font-medium mt-0.5">
                                                <?php echo e($terminalHistory->created_at->format('g:i A')); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php break; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        
        <div class="mt-12 pt-8 border-t border-zinc-200 text-center">
            <div class="text-[13px] text-zinc-500">
                Have questions about your order status?
                <?php if (isset($component)) { $__componentOriginal54ddb5b70b37b1e1cf0f2f95e4c53477 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal54ddb5b70b37b1e1cf0f2f95e4c53477 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::link','data' => ['href' => '#','class' => 'font-bold text-zinc-950 hover:text-primary ml-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '#','class' => 'font-bold text-zinc-950 hover:text-primary ml-1']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Contact Support
                 <?php echo $__env->renderComponent(); ?>
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
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views\pages\customer\orders\tracking.blade.php ENDPATH**/ ?>