<flux:card class="p-0">
    <div class="border-b px-3 py-2">
        <flux:heading>Product Description</flux:heading>
    </div>

    <div class="p-5">
        <flux:field>
            <x-my-markdown wire:model="form.description" />
            <flux:error name="form.description" />
        </flux:field>
    </div>
</flux:card>
