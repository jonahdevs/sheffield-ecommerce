<div wire:cloak wire:show="selectedTab == 'specification'">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($product->technical_specification)): ?>
        <div class="prose prose-sm max-w-none dark:prose-invert">
            <?php echo $product->technical_specification; ?>

        </div>
    <?php else: ?>
        <p class="text-sm text-zinc-400">No specifications available for this product.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\jonah.wakahiu\Desktop\ecommerce\sheffield_ecommerce\resources\views/pages/product-details/partials/_specification.blade.php ENDPATH**/ ?>