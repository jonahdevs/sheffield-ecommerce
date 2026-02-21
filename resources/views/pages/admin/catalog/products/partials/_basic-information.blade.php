{{-- Basic Information Section --}}
<flux:card class="p-0">
    <div class="border-b px-3 py-2">
        <flux:heading>Basic Information</flux:heading>
    </div>

    <div class="p-5 space-y-5">
        {{-- Product Name --}}
        <flux:input :label="__('Product Name')" wire:model="form.name" />

        <div class="grid grid-cols-2 gap-5">
            {{-- Model Number --}}
            <flux:input :label="__('Model Number')" wire:model="form.model_number" />

            {{-- Slug --}}
            <flux:input :label="__('Slug')" wire:model="form.slug" />
        </div>

        <flux:field>
            <flux:label>{{ __('Short Description') }}</flux:label>
            <x-my-markdown wire:model="form.short_description" />
            <flux:error name="form.short_description" />
        </flux:field>
    </div>
</flux:card>
