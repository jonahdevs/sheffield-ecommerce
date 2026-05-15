<?php

use App\Enums\OrderStatus;
use App\Models\OrderItem;
use App\Models\Review;
use Livewire\Attributes\{Layout, Computed};
use Livewire\Component;
use Artesaos\SEOTools\Facades\SEOMeta;

new #[Layout('layouts.customer')] class extends Component {
    public function mount(): void
    {
        SEOMeta::setRobots('noindex,nofollow');
    }

    #[Computed]
    public function pendingProducts()
    {
        $userId = auth()->id();

        // Get product IDs the user has already reviewed
        $reviewedProductIds = Review::where('user_id', $userId)->pluck('product_id');

        // Get products from delivered orders that haven't been reviewed
        return OrderItem::query()
            ->select('order_items.*')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', $userId)
            ->where('orders.status', OrderStatus::DELIVERED)
            ->whereNotIn('order_items.product_id', $reviewedProductIds)
            ->with(['product:id,name,slug,image_path,price,sale_price', 'order:id,reference,created_at'])
            ->orderByDesc('orders.created_at')
            ->get()
            ->unique('product_id');
    }
}; ?>

@placeholder
    <div class="bg-white rounded-lg border">
        
        <div class="px-6 py-4 border-b border-zinc-200 flex items-center gap-3">
            <?php if (isset($component)) { $__componentOriginale27b9f538b18752a4e62486fb1a784aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale27b9f538b18752a4e62486fb1a784aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::skeleton.index','data' => ['animate' => 'shimmer','class' => 'w-5 h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::skeleton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animate' => 'shimmer','class' => 'w-5 h-5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $attributes = $__attributesOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $component = $__componentOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__componentOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginale27b9f538b18752a4e62486fb1a784aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale27b9f538b18752a4e62486fb1a784aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::skeleton.index','data' => ['animate' => 'shimmer','class' => 'w-20 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::skeleton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animate' => 'shimmer','class' => 'w-20 h-6']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $attributes = $__attributesOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $component = $__componentOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__componentOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginale27b9f538b18752a4e62486fb1a784aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale27b9f538b18752a4e62486fb1a784aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::skeleton.index','data' => ['animate' => 'shimmer','class' => 'w-16 h-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::skeleton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animate' => 'shimmer','class' => 'w-16 h-6']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $attributes = $__attributesOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $component = $__componentOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__componentOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
        </div>

        
        <div class="flex flex-col bg-white">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="p-4.5 border-b border-zinc-200 last:border-b-0 flex items-center gap-4">
                    
                    <?php if (isset($component)) { $__componentOriginale27b9f538b18752a4e62486fb1a784aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale27b9f538b18752a4e62486fb1a784aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::skeleton.index','data' => ['animate' => 'shimmer','class' => 'w-16 h-16 rounded-sm shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::skeleton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animate' => 'shimmer','class' => 'w-16 h-16 rounded-sm shrink-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $attributes = $__attributesOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $component = $__componentOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__componentOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>

                    
                    <div class="flex-1 min-w-0 space-y-2">
                        <?php if (isset($component)) { $__componentOriginale27b9f538b18752a4e62486fb1a784aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale27b9f538b18752a4e62486fb1a784aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::skeleton.index','data' => ['animate' => 'shimmer','class' => 'w-48 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::skeleton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animate' => 'shimmer','class' => 'w-48 h-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $attributes = $__attributesOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $component = $__componentOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__componentOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginale27b9f538b18752a4e62486fb1a784aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale27b9f538b18752a4e62486fb1a784aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::skeleton.index','data' => ['animate' => 'shimmer','class' => 'w-32 h-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::skeleton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animate' => 'shimmer','class' => 'w-32 h-3']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $attributes = $__attributesOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $component = $__componentOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__componentOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
                    </div>

                    
                    <?php if (isset($component)) { $__componentOriginale27b9f538b18752a4e62486fb1a784aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale27b9f538b18752a4e62486fb1a784aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::skeleton.index','data' => ['animate' => 'shimmer','class' => 'w-24 h-8 shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::skeleton'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['animate' => 'shimmer','class' => 'w-24 h-8 shrink-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $attributes = $__attributesOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__attributesOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale27b9f538b18752a4e62486fb1a784aa)): ?>
<?php $component = $__componentOriginale27b9f538b18752a4e62486fb1a784aa; ?>
<?php unset($__componentOriginale27b9f538b18752a4e62486fb1a784aa); ?>
<?php endif; ?>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
@endplaceholder

<?php if (isset($component)) { $__componentOriginalc7f54b8f583d0f8b3734fff24e9ce48e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7f54b8f583d0f8b3734fff24e9ce48e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.card','data' => ['title' => 'Pending','titleEm' => 'Reviews','bodyClass' => 'p-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pending','titleEm' => 'Reviews','bodyClass' => 'p-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

     <?php $__env->slot('icon', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal0bc6ca59f258b8d2577c76df279598af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0bc6ca59f258b8d2577c76df279598af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.star','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0bc6ca59f258b8d2577c76df279598af)): ?>
<?php $attributes = $__attributesOriginal0bc6ca59f258b8d2577c76df279598af; ?>
<?php unset($__attributesOriginal0bc6ca59f258b8d2577c76df279598af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0bc6ca59f258b8d2577c76df279598af)): ?>
<?php $component = $__componentOriginal0bc6ca59f258b8d2577c76df279598af; ?>
<?php unset($__componentOriginal0bc6ca59f258b8d2577c76df279598af); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->pendingProducts->isEmpty()): ?>
        <div class="text-center py-16 flex flex-col items-center justify-center">
            <?php if (isset($component)) { $__componentOriginal0bc6ca59f258b8d2577c76df279598af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0bc6ca59f258b8d2577c76df279598af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.star','data' => ['class' => 'w-12 h-12 text-zinc-300 mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-12 h-12 text-zinc-300 mb-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0bc6ca59f258b8d2577c76df279598af)): ?>
<?php $attributes = $__attributesOriginal0bc6ca59f258b8d2577c76df279598af; ?>
<?php unset($__attributesOriginal0bc6ca59f258b8d2577c76df279598af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0bc6ca59f258b8d2577c76df279598af)): ?>
<?php $component = $__componentOriginal0bc6ca59f258b8d2577c76df279598af; ?>
<?php unset($__componentOriginal0bc6ca59f258b8d2577c76df279598af); ?>
<?php endif; ?>
            <h4 class="text-lg font-medium text-zinc-900"><?php echo e(__('No pending reviews')); ?></h4>
            <p class="text-sm text-zinc-500 mt-1"><?php echo e(__('You have reviewed all your purchased products.')); ?></p>
            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['variant' => 'customer-primary','href' => ''.e(route('customer.orders.index')).'','wire:navigate' => true,'class' => 'mt-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'customer-primary','href' => ''.e(route('customer.orders.index')).'','wire:navigate' => true,'class' => 'mt-6']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <?php echo e(__('View Orders')); ?>

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
        </div>
    <?php else: ?>
        <div class="flex flex-col bg-white">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->pendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div
                    class="p-4.5 border-b border-zinc-200 last:border-b-0 flex items-center gap-4 transition-colors hover:bg-zinc-50">
                    
                    <div
                        class="w-16 h-16 bg-zinc-50 flex items-center justify-center shrink-0 overflow-hidden border border-zinc-200 rounded-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->product?->image_path): ?>
                            <img src="<?php echo e(asset('storage/' . $item->product->image_path)); ?>"
                                alt="<?php echo e($item->product->name); ?>" class="w-[85%] h-[85%] object-contain" />
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal2d7605e1adbee8a1737ebec29a91da61 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2d7605e1adbee8a1737ebec29a91da61 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.photo','data' => ['class' => 'w-8 h-8 text-zinc-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.photo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-zinc-300']); ?>
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
                        <div class="text-[13px] font-bold text-zinc-950 mb-0.5 truncate">
                            <?php echo e($item->product?->name ?? ($item->product_snapshot['name'] ?? 'Product')); ?>

                        </div>
                        <div class="text-[11px] text-zinc-500 mt-0.5">
                            <?php echo e(__('Order')); ?>: #<?php echo e($item->order->reference); ?>

                        </div>
                    </div>

                    
                    <div class="shrink-0 flex items-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->product): ?>
                            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => ''.e(route('products.reviews', $item->product->slug)).'','wire:navigate' => true,'size' => 'sm','variant' => 'customer-primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('products.reviews', $item->product->slug)).'','wire:navigate' => true,'size' => 'sm','variant' => 'customer-primary']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                                <?php echo e(__('Write Review')); ?>

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
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views\pages\customer\pending-reviews.blade.php ENDPATH**/ ?>