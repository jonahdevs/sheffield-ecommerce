<?php
    $cancelHref = $cancelHref ?? null;
    $submitLabel = $submitLabel ?? 'Save Address';
    $mapsKey = config('services.google.maps_key', '');

    $inputClass = 'customer-input font-barlow text-on-surface bg-white placeholder:text-zinc-300';
    $selectArrow =
        "appearance-none bg-[url('data:image/svg+xml,%3Csvg_xmlns=%22http://www.w3.org/2000/svg%22_width=%2210%22_height=%226%22%3E%3Cpath_d=%22M0_0l5_6_5-6z%22_fill=%22%23888%22/%3E%3C/svg%3E')] bg-no-repeat bg-[right_12px_center]";

    $tagBase =
        'px-4 py-1.5 border-[1.5px] border-zinc-200 bg-white text-[11px] font-bold font-barlow tracking-[0.04em] uppercase cursor-pointer transition-all hover:border-zinc-950';
    $tagSelected = 'bg-zinc-950 border-zinc-950 text-white';

    $hasPinnedInit = !empty($form->latitude) ? 'true' : 'false';
    $initCounty = !empty($form->county_id) ? \App\Models\County::find($form->county_id) : null;
    $countyResolvedInit = $initCounty ? 'true' : 'false';
    $countyNameInit = $initCounty ? "'" . addslashes($initCounty->name) . "'" : "''";
?>

<div x-data="{
    step: 'map',
    hasPinned: false,
    pinnedText: '',
    countyResolved: false,
    countyResolving: false,
    countyName: '',
}" x-init="hasPinned = <?php echo e($hasPinnedInit); ?>;
countyResolved = <?php echo e($countyResolvedInit); ?>;
countyName = <?php echo e($countyNameInit); ?>;"
    @map-pin-placed.window="hasPinned = true; pinnedText = $event.detail.text; countyResolving = true"
    @county-resolved.window="countyResolved = $event.detail.resolved; countyName = $event.detail.name; countyResolving = false">

    
    <div x-show="step === 'map'">
        <div class="p-6 space-y-5">

            
            <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'Search location']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Search location']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <input type="text" id="map-search-input" placeholder="e.g. Westlands, Nairobi…"
                    class="<?php echo e($inputClass); ?> flex-1" autocomplete="off">
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>

            
            <div>
                <label class="block text-[10px] font-bold tracking-widest uppercase text-on-surface-variant mb-1.5">📍 Pin your
                    exact delivery location</label>

                <div id="address-map" wire:ignore class="w-full border-[1.5px] border-zinc-200 z-0"
                    style="height:320px;"></div>

                <div
                    class="bg-zinc-50 border-x-[1.5px] border-b-[1.5px] border-zinc-200 p-2.5 flex items-center gap-2 text-[11px] text-on-surface-variant">
                    <?php if (isset($component)) { $__componentOriginal1f8061448e375a811323d4736f7bf58b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f8061448e375a811323d4736f7bf58b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.information-circle','data' => ['class' => 'size-3 shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.information-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-3 shrink-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f8061448e375a811323d4736f7bf58b)): ?>
<?php $attributes = $__attributesOriginal1f8061448e375a811323d4736f7bf58b; ?>
<?php unset($__attributesOriginal1f8061448e375a811323d4736f7bf58b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f8061448e375a811323d4736f7bf58b)): ?>
<?php $component = $__componentOriginal1f8061448e375a811323d4736f7bf58b; ?>
<?php unset($__componentOriginal1f8061448e375a811323d4736f7bf58b); ?>
<?php endif; ?>
                    Click anywhere on the map to drop a delivery pin. Drag the pin to adjust.
                </div>
            </div>



            <div x-show="hasPinned && !countyResolved && !countyResolving" x-cloak class="space-y-3">
                <div class="bg-amber-50 border-l-[3px] border-amber-500 px-4 py-3 flex items-start gap-2.5">
                    <?php if (isset($component)) { $__componentOriginal7f0e8d69add49581695c1337b3f85fff = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f0e8d69add49581695c1337b3f85fff = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.exclamation-triangle','data' => ['class' => 'w-4 h-4 text-amber-500 mt-0.5 shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.exclamation-triangle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-amber-500 mt-0.5 shrink-0']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f0e8d69add49581695c1337b3f85fff)): ?>
<?php $attributes = $__attributesOriginal7f0e8d69add49581695c1337b3f85fff; ?>
<?php unset($__attributesOriginal7f0e8d69add49581695c1337b3f85fff); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f0e8d69add49581695c1337b3f85fff)): ?>
<?php $component = $__componentOriginal7f0e8d69add49581695c1337b3f85fff; ?>
<?php unset($__componentOriginal7f0e8d69add49581695c1337b3f85fff); ?>
<?php endif; ?>
                    <div class="min-w-0">
                        <p x-text="pinnedText" class="text-[12px] font-semibold text-on-surface truncate mb-0.5"></p>
                        <p class="text-[11px] text-amber-700">County not detected — please select it below.</p>
                    </div>
                </div>
                <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'County','name' => 'form.county_id','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'County','name' => 'form.county_id','required' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <select id="addr-county-select" wire:model.live="form.county_id"
                        class="<?php echo e($inputClass); ?> <?php echo e($selectArrow); ?>"
                        @change="countyResolved = !!$el.value; countyName = $el.options[$el.selectedIndex]?.text || ''">
                        <option value="">Select County…</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($county->id); ?>"><?php echo e($county->name); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
            </div>

        </div>

        
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-zinc-100">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cancelHref): ?>
                <a href="<?php echo e($cancelHref); ?>" wire:navigate>
                    <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['tag' => 'span','variant' => 'customer-outline','size' => 'customer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tag' => 'span','variant' => 'customer-outline','size' => 'customer']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
                </a>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['type' => 'button','wire:click' => 'closeModal','variant' => 'customer-outline','size' => 'customer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','wire:click' => 'closeModal','variant' => 'customer-outline','size' => 'customer']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Cancel
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

            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['variant' => 'customer-primary','size' => 'customer-lg','type' => 'button','class' => 'inline-flex items-center gap-2','xBind:disabled' => '!hasPinned || !countyResolved || countyResolving','xBind:class' => '(!hasPinned || !countyResolved || countyResolving) ? \'opacity-40 cursor-not-allowed!\' : \'\'','@click' => 'step = \'form\'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'customer-primary','size' => 'customer-lg','type' => 'button','class' => 'inline-flex items-center gap-2','x-bind:disabled' => '!hasPinned || !countyResolved || countyResolving','x-bind:class' => '(!hasPinned || !countyResolved || countyResolving) ? \'opacity-40 cursor-not-allowed!\' : \'\'','@click' => 'step = \'form\'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                Continue
                <?php if (isset($component)) { $__componentOriginal3b3f8b5ed735ca7de69214f23bc10d21 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b3f8b5ed735ca7de69214f23bc10d21 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.move-right','data' => ['class' => 'size-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.move-right'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b3f8b5ed735ca7de69214f23bc10d21)): ?>
<?php $attributes = $__attributesOriginal3b3f8b5ed735ca7de69214f23bc10d21; ?>
<?php unset($__attributesOriginal3b3f8b5ed735ca7de69214f23bc10d21); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b3f8b5ed735ca7de69214f23bc10d21)): ?>
<?php $component = $__componentOriginal3b3f8b5ed735ca7de69214f23bc10d21; ?>
<?php unset($__componentOriginal3b3f8b5ed735ca7de69214f23bc10d21); ?>
<?php endif; ?>
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

    
    <div x-show="step === 'form'">
        <div class="p-6 space-y-5">

            
            <div class="bg-zinc-100 border-l-[3px] border-primary px-3.5 py-2.5 flex items-start justify-between gap-3">
                <div class="flex items-start gap-2 min-w-0">
                    <?php if (isset($component)) { $__componentOriginal0d48bd54d72df81b49ee07c1a3735f04 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0d48bd54d72df81b49ee07c1a3735f04 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.map-pin','data' => ['class' => 'w-3.5 h-3.5 text-primary shrink-0 mt-0.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.map-pin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3.5 h-3.5 text-primary shrink-0 mt-0.5']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0d48bd54d72df81b49ee07c1a3735f04)): ?>
<?php $attributes = $__attributesOriginal0d48bd54d72df81b49ee07c1a3735f04; ?>
<?php unset($__attributesOriginal0d48bd54d72df81b49ee07c1a3735f04); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d48bd54d72df81b49ee07c1a3735f04)): ?>
<?php $component = $__componentOriginal0d48bd54d72df81b49ee07c1a3735f04; ?>
<?php unset($__componentOriginal0d48bd54d72df81b49ee07c1a3735f04); ?>
<?php endif; ?>
                    <span x-text="pinnedText || 'Location pinned'"
                        class="text-[12px] font-semibold text-on-surface leading-snug"></span>
                </div>
                <button type="button"
                    class="text-[11px] font-bold tracking-[0.06em] uppercase text-primary cursor-pointer hover:opacity-70 transition-opacity shrink-0 whitespace-nowrap bg-none border-none p-0 mt-0.5"
                    @click="step = 'map'; $nextTick(() => { setTimeout(() => window.resizeDeliveryMap?.(), 80); })">
                    Change Pin
                </button>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'First Name','name' => 'form.first_name','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'First Name','name' => 'form.first_name','required' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <input type="text" wire:model="form.first_name" placeholder="John"
                        class="<?php echo e($inputClass); ?><?php echo e($errors->has('form.first_name') ? ' border-red-500' : ''); ?>">
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'Last Name','name' => 'form.last_name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Last Name','name' => 'form.last_name']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <input type="text" wire:model="form.last_name" placeholder="Doe"
                        class="<?php echo e($inputClass); ?><?php echo e($errors->has('form.last_name') ? ' border-red-500' : ''); ?>">
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
            </div>

            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'Phone Number','name' => 'form.phone_number','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Phone Number','name' => 'form.phone_number','required' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                     <?php $__env->slot('prefix', null, []); ?> +254 <?php $__env->endSlot(); ?>
                    <input type="text" wire:model="form.phone_number" placeholder="712 345 678"
                        class="<?php echo e($inputClass); ?> border-l-0<?php echo e($errors->has('form.phone_number') ? ' border-red-500' : ''); ?>">
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>

                <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'Alternative Phone (Optional)','name' => 'form.alternative_phone_number']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Alternative Phone (Optional)','name' => 'form.alternative_phone_number']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                     <?php $__env->slot('prefix', null, []); ?> +254 <?php $__env->endSlot(); ?>
                    <input type="text" wire:model="form.alternative_phone_number" placeholder="722 000 000"
                        class="<?php echo e($inputClass); ?> border-l-0<?php echo e($errors->has('form.alternative_phone_number') ? ' border-red-500' : ''); ?>">
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
            </div>

            
            <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'Street / Apartment / Office','name' => 'form.address_text','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Street / Apartment / Office','name' => 'form.address_text','required' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <input type="text" wire:model="form.address_text" placeholder="e.g. Westlands Road, Apartment 3B"
                    class="<?php echo e($inputClass); ?><?php echo e($errors->has('form.address_text') ? ' border-red-500' : ''); ?>">
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal071cba40201c8f65242f69b169ef9aaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal071cba40201c8f65242f69b169ef9aaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer.form-field','data' => ['label' => 'Delivery Instructions (Optional)','name' => 'form.additional_information']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer.form-field'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Delivery Instructions (Optional)','name' => 'form.additional_information']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <textarea wire:model="form.additional_information" rows="3"
                    placeholder="e.g. Green gate, 2nd floor, call on arrival"
                    class="<?php echo e($inputClass); ?> h-24<?php echo e($errors->has('form.additional_information') ? ' border-red-500' : ''); ?>"></textarea>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $attributes = $__attributesOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__attributesOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal071cba40201c8f65242f69b169ef9aaa)): ?>
<?php $component = $__componentOriginal071cba40201c8f65242f69b169ef9aaa; ?>
<?php unset($__componentOriginal071cba40201c8f65242f69b169ef9aaa); ?>
<?php endif; ?>

            
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <label class="block text-[10px] font-bold tracking-widest uppercase text-on-surface-variant">Label:</label>
                    <div class="flex gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Home', 'Work', 'Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addrLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <button type="button"
                                class="<?php echo e($tagBase); ?> <?php echo e(($form->label ?? 'Home') === $addrLabel ? $tagSelected : ''); ?>"
                                wire:click="$set('form.label', '<?php echo e($addrLabel); ?>')"><?php echo e($addrLabel); ?></button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->hasDefaultAddress): ?>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" wire:model="form.is_default" class="w-4 h-4 accent-brand-primary">
                        <span
                            class="text-[12px] font-bold uppercase tracking-widest text-on-surface-variant group-hover:text-on-surface">Set
                            as default</span>
                    </label>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <input type="hidden" wire:model="form.latitude" />
            <input type="hidden" wire:model="form.longitude" />

        </div>

        
        <div class="flex justify-end gap-3 px-6 py-4 border-t border-zinc-100">
            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['type' => 'button','variant' => 'customer-outline','size' => 'customer','class' => 'inline-flex items-center gap-2','@click' => 'step = \'map\'; $nextTick(() => { setTimeout(() => window.resizeDeliveryMap?.(), 80); })']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'customer-outline','size' => 'customer','class' => 'inline-flex items-center gap-2','@click' => 'step = \'map\'; $nextTick(() => { setTimeout(() => window.resizeDeliveryMap?.(), 80); })']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <?php if (isset($component)) { $__componentOriginalb0b0f95de346be490fafdebd65ddfb51 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb0b0f95de346be490fafdebd65ddfb51 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::icon.move-left','data' => ['class' => 'size-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::icon.move-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'size-4']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb0b0f95de346be490fafdebd65ddfb51)): ?>
<?php $attributes = $__attributesOriginalb0b0f95de346be490fafdebd65ddfb51; ?>
<?php unset($__attributesOriginalb0b0f95de346be490fafdebd65ddfb51); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb0b0f95de346be490fafdebd65ddfb51)): ?>
<?php $component = $__componentOriginalb0b0f95de346be490fafdebd65ddfb51; ?>
<?php unset($__componentOriginalb0b0f95de346be490fafdebd65ddfb51); ?>
<?php endif; ?>
                Back to Map
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

            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['variant' => 'customer-primary','size' => 'customer-lg','type' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'customer-primary','size' => 'customer-lg','type' => 'submit']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <?php echo e($submitLabel); ?>

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

</div>

    <?php
        $__scriptKey = '3413711716-0';
        ob_start();
    ?>
    <script>
        // ── Shared state ──────────────────────────────────────────────────────────
        let map = null, pin = null, infoWindow = null, geocoder = null;
        const KENYA_CENTER = { lat: -1.2921, lng: 36.8219 };
        const MAPS_KEY = <?php echo \Illuminate\Support\Js::from($mapsKey)->toHtml() ?>;
        const PIN_SVG = `<svg viewBox="0 0 32 40" xmlns="http://www.w3.org/2000/svg"><path d="M16 0C7.163 0 0 7.163 0 16c0 10 16 24 16 24S32 26 32 16C32 7.163 24.837 0 16 0z" fill="#FF4500"/><circle cx="16" cy="16" r="7" fill="white"/><circle cx="16" cy="16" r="4" fill="#FF4500"/></svg>`;

        // ── CSS injections ────────────────────────────────────────────────────────

        if (!document.getElementById('address-map-pac-css')) {
            const style = document.createElement('style');
            style.id = 'address-map-pac-css';
            style.textContent = `
                .pac-container {
                    z-index: 9999 !important;
                    border-radius: 0 !important;
                    border: 1.5px solid #e4e4e7 !important;
                    border-top: none !important;
                    box-shadow: 4px 4px 0 rgba(0,0,0,.08) !important;
                    font-family: var(--font-barlow, sans-serif) !important;
                }
                .pac-item {
                    font-size: 12px !important;
                    padding: 8px 12px !important;
                    cursor: pointer !important;
                    border-top: 1px solid #f4f4f5 !important;
                }
                .pac-item:hover, .pac-item-selected { background: #f4f4f5 !important; }
                .pac-item-query { font-weight: 600 !important; color: #18181b !important; }
                .pac-matched { font-weight: 700 !important; }
                .pac-icon { display: none !important; }
                .gm-style-iw-c { border-radius: 0 !important; padding: 0 !important; }
                .gm-style-iw-d { padding: 8px 12px !important; font-size: 12px !important; font-weight: 600 !important; line-height: 1.5 !important; overflow: auto !important; }
                .gm-style-iw-chr { display: none !important; }
            `;
            document.head.appendChild(style);
        }

        // ── Loader ────────────────────────────────────────────────────────────────

        function loadGoogleMaps(key, cb) {
            if (window.google?.maps?.places) { return cb(); }
            const s = document.createElement('script');
            s.src = `https://maps.googleapis.com/maps/api/js?key=${key}&libraries=places`;
            s.onload = cb;
            document.head.appendChild(s);
        }

        // ── Helpers ───────────────────────────────────────────────────────────────

        window.resizeDeliveryMap = () => {
            if (window.deliveryMap && window.google?.maps) {
                google.maps.event.trigger(window.deliveryMap, 'resize');
            }
        };

        function placePin(lat, lng) {
            if (!window.google?.maps || !map) { return; }

            if (pin) {
                pin.setPosition({ lat, lng });
            } else {
                pin = new google.maps.Marker({
                    position: { lat, lng },
                    map,
                    draggable: true,
                    icon: {
                        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(PIN_SVG),
                        scaledSize: new google.maps.Size(32, 40),
                        anchor: new google.maps.Point(16, 40),
                    },
                });
                pin.addListener('dragend', (e) => {
                    const lat = e.latLng.lat();
                    const lng = e.latLng.lng();
                    $wire.set('form.latitude', lat);
                    $wire.set('form.longitude', lng);
                    reverseGeocode(lat, lng);
                });
            }

            if (!infoWindow) { infoWindow = new google.maps.InfoWindow(); }
        }

        function showInfoWindow(text) {
            if (!infoWindow || !pin || !map) { return; }
            infoWindow.setContent(`<div>📍 <b>Delivery here</b><br>${text}</div>`);
            infoWindow.open({ map, anchor: pin });
        }

        function dispatchCounty(countyRaw, areaRaw) {
            if (!countyRaw) {
                window.dispatchEvent(new CustomEvent('county-resolved', { detail: { resolved: false, name: '' } }));
                return;
            }
            $wire.call('resolveCountyFromName', countyRaw).then(result => {
                window.dispatchEvent(new CustomEvent('county-resolved', {
                    detail: { resolved: !!result, name: result?.name || '' }
                }));
                if (result && areaRaw) {
                    $wire.call('resolveAreaFromName', areaRaw);
                }
            });
        }

        // ── Reverse geocoding (Google Geocoder) ───────────────────────────────────

        function reverseGeocode(lat, lng) {
            if (!geocoder) { geocoder = new google.maps.Geocoder(); }

            geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                if (status !== 'OK' || !results?.length) {
                    const fallback = `${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                    window.dispatchEvent(new CustomEvent('map-pin-placed', { detail: { text: fallback } }));
                    window.dispatchEvent(new CustomEvent('county-resolved', { detail: { resolved: false, name: '' } }));
                    return;
                }

                const comps = results[0].address_components;
                const get = (type) => comps.find(c => c.types.includes(type))?.long_name || '';

                const countyRaw = get('administrative_area_level_1');
                const areaRaw = get('sublocality_level_1') || get('locality') || get('administrative_area_level_2');

                const road = get('route') || get('establishment') || get('point_of_interest');
                const suburb = get('sublocality_level_1') || get('neighborhood');
                const city = get('locality');
                const parts = [road, suburb, city].filter(Boolean);
                const shortDisp = parts.length
                    ? parts.join(', ')
                    : (results[0].formatted_address || `${lat.toFixed(5)}, ${lng.toFixed(5)}`);

                showInfoWindow(shortDisp);
                window.dispatchEvent(new CustomEvent('map-pin-placed', { detail: { text: shortDisp } }));
                dispatchCounty(countyRaw, areaRaw);
            });
        }

        // ── Map setup ─────────────────────────────────────────────────────────────

        function setupMap() {
            const container = document.getElementById('address-map');
            if (!container) { return; }

            if (map && (!document.body.contains(map.getDiv()) || map.getDiv() !== container)) {
                map = null;
                pin = null;
                infoWindow = null;
            }

            if (!map) {
                map = new google.maps.Map(container, {
                    center: KENYA_CENTER,
                    zoom: 13,
                    mapTypeId: 'roadmap',
                    zoomControl: true,
                    streetViewControl: false,
                    mapTypeControl: false,
                    fullscreenControl: false,
                    clickableIcons: false,
                });
                window.deliveryMap = map;

                map.addListener('click', (e) => {
                    const lat = e.latLng.lat();
                    const lng = e.latLng.lng();
                    placePin(lat, lng);
                    $wire.set('form.latitude', lat);
                    $wire.set('form.longitude', lng);
                    reverseGeocode(lat, lng);
                });
            }

            setTimeout(() => {
                google.maps.event.trigger(map, 'resize');
                $wire.call('getMapState').then(state => {
                    if (state?.pin?.lat) {
                        map.setCenter({ lat: state.pin.lat, lng: state.pin.lng });
                        map.setZoom(15);
                        placePin(state.pin.lat, state.pin.lng);
                        reverseGeocode(state.pin.lat, state.pin.lng);
                    } else {
                        if (pin) { pin.setMap(null); pin = null; }
                        map.setCenter(KENYA_CENTER);
                        map.setZoom(13);
                    }
                });
            }, 150);
        }

        // ── Autocomplete setup ────────────────────────────────────────────────────

        function setupAutocomplete() {
            const input = document.getElementById('map-search-input');
            if (!input || input._googleAutocomplete) { return; }
            input._googleAutocomplete = true;

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') { e.preventDefault(); }
            });

            const ac = new google.maps.places.Autocomplete(input, {
                componentRestrictions: { country: 'ke' },
                fields: ['geometry', 'address_components', 'formatted_address', 'name'],
            });

            ac.addListener('place_changed', () => {
                const place = ac.getPlace();
                if (!place.geometry?.location) { return; }

                const lat = place.geometry.location.lat();
                const lng = place.geometry.location.lng();

                const comps = place.address_components || [];
                const get = (type) => comps.find(c => c.types.includes(type))?.long_name || '';

                const countyRaw = get('administrative_area_level_1');
                const areaRaw = get('sublocality_level_1') || get('locality') || get('administrative_area_level_2');
                const city = get('locality') || get('administrative_area_level_2') || '';
                const displayText = place.name
                    ? [place.name, city].filter(Boolean).join(', ')
                    : (place.formatted_address || `${lat.toFixed(5)}, ${lng.toFixed(5)}`);

                if (map) { map.setCenter({ lat, lng }); map.setZoom(16); }
                placePin(lat, lng);
                $wire.set('form.latitude', lat);
                $wire.set('form.longitude', lng);
                showInfoWindow(displayText);

                window.dispatchEvent(new CustomEvent('map-pin-placed', { detail: { text: displayText } }));
                dispatchCounty(countyRaw, areaRaw);
            });
        }

        // ── Bootstrap ─────────────────────────────────────────────────────────────

        loadGoogleMaps(MAPS_KEY, () => {
            $wire.on('address-modal-opened', () => {
                setupMap();
                setupAutocomplete();
            });

            if (document.getElementById('address-map')) { setupMap(); }
            setupAutocomplete();
        });
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views/pages/customer/address-book/_form-fields.blade.php ENDPATH**/ ?>