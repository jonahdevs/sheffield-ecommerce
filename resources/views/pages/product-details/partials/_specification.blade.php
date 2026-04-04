<div wire:cloak wire:show="selectedTab == 'specification'">
    @if (!empty($product->technical_specification))
        <div class="prose prose-sm max-w-none dark:prose-invert">
            {!! $product->technical_specification !!}
        </div>
    @else
        <p class="text-sm text-zinc-400">No specifications available for this product.</p>
    @endif
</div>
