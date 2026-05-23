<?php

use App\Enums\ShippingMethodStatus;
use App\Livewire\Forms\Admin\ShippingMethodForm;
use App\Models\LogisticsProvider;
use App\Models\ShippingMethod;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, Title};
use Livewire\Component;

new #[Title('Edit Shipping Method')] class extends Component {
    public ShippingMethodForm $form;
    public ShippingMethod $shippingMethod;

    public function mount(ShippingMethod $shippingMethod): void
    {
        $this->shippingMethod = $shippingMethod;
        $this->form->setMethod($shippingMethod);
    }

    #[Computed]
    public function providers(): Collection
    {
        return LogisticsProvider::where('status', 'active')->orderBy('name')->get();
    }

    #[Computed]
    public function statuses(): array
    {
        return ShippingMethodStatus::cases();
    }

    public function save(): void
    {
        try {
            $this->form->update();
            $this->dispatch('notify', title: 'Method Updated', variant: 'success', message: 'Shipping method updated successfully.');
            $this->redirectRoute('admin.logistics.configuration.methods.index', navigate: true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            logger()->error('Failed to update shipping method.', ['exception' => $e->getMessage()]);
            $this->dispatch('notify', title: 'Save Failed', variant: 'danger', message: 'Something went wrong. Please try again.');
        }
    }
}; ?>

<x-admin.logistics.layout heading="Edit Shipping Method"
    subheading="Update the delivery option details and configuration.">

    @push('breadcrumbs')
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('admin.logistics.configuration.methods.index')" wire:navigate>
                Shipping Methods
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Edit Method</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    @endpush

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main fields --}}
            <div class="lg:col-span-2 space-y-5">

                <flux:card class="p-0">
                    <div class="px-5 py-3 border-b border-zinc-200 dark:border-zinc-600">
                        <flux:heading>Method Details</flux:heading>
                    </div>
                    <div class="p-5 space-y-4">
                        <flux:input wire:model="form.name" label="Method Name"
                            placeholder="e.g. Same-Day Delivery"
                            description="Shown to customers at checkout." />

                        <div class="grid grid-cols-2 gap-4">
                            <flux:input wire:model="form.code" label="Code"
                                placeholder="e.g. same_day"
                                description="Unique identifier. Lowercase, underscores only." />

                            <flux:input wire:model="form.sort_order" label="Sort Order" type="number" min="0"
                                description="Lower numbers appear first at checkout." />
                        </div>

                        <flux:textarea wire:model="form.description" label="Description"
                            placeholder="Describe this delivery option to customers..." rows="2" />

                        <flux:input wire:model="form.icon" label="Icon"
                            placeholder="e.g. truck"
                            description="Heroicon name used in the UI." />
                    </div>
                </flux:card>

                <flux:card class="p-0">
                    <div class="px-5 py-3 border-b border-zinc-200 dark:border-zinc-600">
                        <flux:heading>Pricing & Delivery</flux:heading>
                    </div>
                    <div class="p-5 space-y-4">
                        <flux:select wire:model="form.logistics_provider_id" label="Logistics Provider"
                            placeholder="Select a provider...">
                            @foreach ($this->providers as $provider)
                                <flux:select.option value="{{ $provider->id }}">{{ $provider->name }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <div class="grid grid-cols-2 gap-4">
                            <flux:field>
                                <flux:label>Pricing Engine</flux:label>
                                <flux:select wire:model="form.type">
                                    <flux:select.option value="flat">Flat Rate (weight × zone)</flux:select.option>
                                    <flux:select.option value="distance">Distance (vehicle × km)</flux:select.option>
                                    <flux:select.option value="pus">Pickup Station (flat + surcharge)</flux:select.option>
                                </flux:select>
                                <flux:description>Determines how shipping cost is calculated.</flux:description>
                            </flux:field>

                            <flux:field>
                                <flux:label>Delivery Time Unit</flux:label>
                                <flux:select wire:model="form.delivery_time_unit">
                                    <flux:select.option value="hours">Hours (e.g. Same-Day)</flux:select.option>
                                    <flux:select.option value="days">Days (e.g. Standard)</flux:select.option>
                                </flux:select>
                                <flux:description>Unit used to display the delivery window.</flux:description>
                            </flux:field>
                        </div>

                        <flux:checkbox wire:model="form.supports_returns"
                            label="Supports return shipments"
                            description="Allow this method to be used for return delivery orders." />
                    </div>
                </flux:card>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">

                <flux:card class="p-0">
                    <div class="px-5 py-3 border-b border-zinc-200 dark:border-zinc-600">
                        <flux:heading>Status</flux:heading>
                    </div>
                    <div class="p-5">
                        <flux:select wire:model="form.status">
                            @foreach ($this->statuses as $status)
                                <flux:select.option value="{{ $status->value }}">{{ $status->label() }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:description class="mt-2">Inactive or deprecated methods are hidden from checkout.</flux:description>
                    </div>
                </flux:card>

                <div class="flex flex-col gap-3">
                    <flux:button type="submit" variant="primary" class="w-full cursor-pointer">
                        Save Changes
                    </flux:button>
                    <flux:button variant="ghost" :href="route('admin.logistics.configuration.methods.index')"
                        wire:navigate class="w-full cursor-pointer">
                        Cancel
                    </flux:button>
                </div>

            </div>
        </div>
    </form>

</x-admin.logistics.layout>
