{{-- Inventory --}}
<div wire:cloak wire:show="activeTab == 'inventory'" class="space-y-5">
    {{-- SKU --}}
    <flux:input :label="__('SKU')" wire:model="form.sku" />

    {{-- Manage stock --}}
    <flux:field>
        <flux:label>Manage Stock</flux:label>

        <flux:checkbox wire:model="form.manage_stock" :label="__('Enable stock management for this product')" />
    </flux:field>

    <div wire:cloak wire:show="form.manage_stock" class="space-y-5">
        <flux:input wire:model="form.stock_quantity" :label="__('Stock Quantity')" type="number" />

        <flux:select :label="__('Allow backorder?')" wire:model="form.allow_backorder">
            <flux:select.option value="no">Do not allow</flux:select.option>
            <flux:select.option value="notify">Allow, but notify customer</flux:select.option>
            <flux:select.option value="yes">Allow</flux:select.option>
        </flux:select>

        <flux:input wire:model="form.low_stock_threshold" wire:model="form.low_stock_threshold"
            :label="__('Low Stock Threshold')" type="number" />
    </div>

    {{-- Stock Status --}}
    <div wire:cloak wire:show="!form.manage_stock">
        <flux:select wire:model="form.stock_status" :label="__('Stock Status *')">
            <flux:select.option value="in_stock">
                In Stock
            </flux:select.option>
            <flux:select.option value="out_of_stock">
                Out of Stock
            </flux:select.option>
            <flux:select.option value="backorder">
                Backorder
            </flux:select.option>
        </flux:select>
    </div>

    <flux:separator />
    <flux:field>
        <flux:label>Sold Individually</flux:label>

        <flux:checkbox wire:model="form.sold_individually"
            :label="__('Enable this to only allow one time to be bought in a single order')" />
    </flux:field>
</div>
