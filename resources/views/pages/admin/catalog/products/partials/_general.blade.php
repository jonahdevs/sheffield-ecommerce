<div wire:cloak wire:show="activeTab == 'general'" class="space-y-5">
    <flux:input :label="__('Regular Price')" type="number" wire:model="form.price" />
    <flux:input :label="__('Sale Price')" type="number" wire:model="form.sale_price" />
</div>
