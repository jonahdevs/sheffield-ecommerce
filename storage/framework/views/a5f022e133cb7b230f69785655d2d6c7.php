<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->accessories->count() > 0): ?>
    <div id="accessories" class="mt-8 scroll-mt-44">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->accessories->count() <= 3): ?>

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-semibold text-zinc-800">Recommended Accessories</h2>
                    <span class="text-xs text-zinc-500 bg-zinc-100 border border-zinc-200 rounded-full px-2.5 py-0.5">
                        <?php echo e($this->accessories->count()); ?>

                    </span>
                </div>
                <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:click' => 'addAllAccessoriesToCart','wire:loading.attr' => 'disabled','wire:target' => 'addAllAccessoriesToCart','size' => 'sm','variant' => 'filled','icon' => 'shopping-cart','class' => 'cursor-pointer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'addAllAccessoriesToCart','wire:loading.attr' => 'disabled','wire:target' => 'addAllAccessoriesToCart','size' => 'sm','variant' => 'filled','icon' => 'shopping-cart','class' => 'cursor-pointer']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    Add all
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

            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'grid gap-4',
                'grid-cols-1' => $this->accessories->count() === 1,
                'grid-cols-1 sm:grid-cols-2' => $this->accessories->count() === 2,
                'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3' =>
                    $this->accessories->count() === 3,
            ]); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('accessory-item', ['product' => $accessory,'recommended-quantity' => $accessory->pivot->quantity ?? 1]);

$__keyOuter = $__key ?? null;

$__key = 'accessory-' . $accessory->id;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3254798411-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

            
        <?php else: ?>
            <div x-data="{
                current: 0,
                total: <?php echo e($this->accessories->count()); ?>,
                perPage() {
                    if (window.innerWidth >= 1280) return 4;
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 640) return 2;
                    return 1;
                },
                get maxIndex() { return Math.max(0, this.total - this.perPage()); },
                get canPrev() { return this.current > 0; },
                get canNext() { return this.current < this.maxIndex; },
                prev() { if (this.canPrev) this.current--; },
                next() { if (this.canNext) this.current++; },
                clamp() { this.current = Math.min(this.current, this.maxIndex); },
            }" x-init="window.addEventListener('resize', () => clamp())">
                
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <h2 class="text-lg font-semibold text-zinc-800">Recommended Accessories</h2>
                        <span
                            class="text-xs text-zinc-500 bg-zinc-100 border border-zinc-200 rounded-full px-2.5 py-0.5">
                            <?php echo e($this->accessories->count()); ?>

                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        
                        <button @click="prev" :disabled="!canPrev"
                            :class="!canPrev ? 'opacity-30 cursor-not-allowed' : 'hover:bg-zinc-100'"
                            class="w-8 h-8 flex items-center justify-center border border-zinc-300 rounded-md transition-colors cursor-pointer"
                            aria-label="Previous">
                            <?php if (isset($component)) { $__componentOriginal93e8a1cf63877447e3f60f50005ff258 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal93e8a1cf63877447e3f60f50005ff258 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.chevron-left','data' => ['class' => 'w-4 h-4 text-zinc-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.chevron-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-zinc-600']); ?>
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
                        </button>

                        
                        <button @click="next" :disabled="!canNext"
                            :class="!canNext ? 'opacity-30 cursor-not-allowed' : 'hover:bg-zinc-100'"
                            class="w-8 h-8 flex items-center justify-center border border-zinc-300 rounded-md transition-colors cursor-pointer"
                            aria-label="Next">
                            <?php if (isset($component)) { $__componentOriginal31cb76c8d087d4f00797aeea7232b4c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31cb76c8d087d4f00797aeea7232b4c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.chevron-right','data' => ['class' => 'w-4 h-4 text-zinc-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.chevron-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-zinc-600']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal31cb76c8d087d4f00797aeea7232b4c3)): ?>
<?php $attributes = $__attributesOriginal31cb76c8d087d4f00797aeea7232b4c3; ?>
<?php unset($__attributesOriginal31cb76c8d087d4f00797aeea7232b4c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal31cb76c8d087d4f00797aeea7232b4c3)): ?>
<?php $component = $__componentOriginal31cb76c8d087d4f00797aeea7232b4c3; ?>
<?php unset($__componentOriginal31cb76c8d087d4f00797aeea7232b4c3); ?>
<?php endif; ?>
                        </button>

                        <div class="w-px h-5 bg-zinc-200 mx-1"></div>

                        
                        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:click' => 'addAllAccessoriesToCart','wire:loading.attr' => 'disabled','wire:target' => 'addAllAccessoriesToCart','size' => 'sm','variant' => 'filled','icon' => 'shopping-cart','class' => 'cursor-pointer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'addAllAccessoriesToCart','wire:loading.attr' => 'disabled','wire:target' => 'addAllAccessoriesToCart','size' => 'sm','variant' => 'filled','icon' => 'shopping-cart','class' => 'cursor-pointer']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            Add all
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
                </div>

                
                <div class="overflow-hidden">
                    <div class="flex gap-4 transition-transform duration-300 ease-in-out"
                        :style="`transform: translateX(calc(-${current} * (100% / ${perPage()} + (16px / ${perPage()}))))`">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->accessories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $accessory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <div class="shrink-0 transition-all duration-300"
                                :style="`width: calc(${100 / perPage()}% - ${16 * (perPage() - 1) / perPage()}px)`">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('accessory-item', ['product' => $accessory,'recommended-quantity' => $accessory->pivot->quantity ?? 1]);

$__keyOuter = $__key ?? null;

$__key = 'accessory-' . $accessory->id;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3254798411-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                
                <div class="flex justify-center gap-1.5 mt-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 0; $i <= $this->accessories->count() - 1; $i++): ?>
                        <button @click="current = Math.min(<?php echo e($i); ?>, maxIndex)"
                            :class="<?php echo e($i); ?> === current ? 'bg-brand-secondary w-4' : 'bg-zinc-300 w-1.5'"
                            class="h-1.5 rounded-full transition-all duration-200"
                            aria-label="Go to slide <?php echo e($i + 1); ?>"></button>
                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views/pages/product-details/partials/_accessories.blade.php ENDPATH**/ ?>