{{-- Linked Products --}}
<div wire:cloak wire:show="activeTab == 'linked-products'" class="space-y-5">

    <flux:field>
        <flux:label> Upsells</flux:label>

        <x-my-choices-offline wire:model="form.selectedUpsells" placeholder="Select products for upsells"
            :options="$this->products" option-sub-label="sku" option-avatar="image_url" clearable searchable />
        <flux:error name="form.selectedUpsells" />
    </flux:field>

    <flux:field>
        <flux:label> Cross Sells</flux:label>
        <x-my-choices-offline wire:model="form.selectedCrossSells" :options="$this->products"
            placeholder="Select products for cross sells (.e.g. Accessories)" option-sub-label="sku"
            option-avatar="image_url" clearable searchable />
        <flux:error name="form.selectedCrossSells" />
    </flux:field>
</div>
