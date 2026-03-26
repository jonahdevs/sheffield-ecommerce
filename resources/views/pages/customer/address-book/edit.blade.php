<?php

use Livewire\Component;
use Livewire\Attributes\{Layout, Computed};
use App\Models\{County, Area, Address};
use App\Livewire\Forms\CustomerAddressForm;
use Illuminate\Validation\ValidationException;

new #[Layout('layouts.customer')] class extends Component {
    public Address $address;
    public CustomerAddressForm $form;

    public function mount(Address $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);
        $this->form->setAddress($address);
    }

    #[Computed]
    public function counties()
    {
        return County::with('shippingZone')->orderBy('name')->get()->groupBy(fn($county) => $county->shippingZone->is_delivery_available ? ' Available for Delivery' : ' Request a Quote')->sortKeysUsing(fn($a, $b) => str_contains($a, 'Available') ? -1 : 1);
    }

    #[Computed]
    public function areas()
    {
        if (!$this->form->county_id) {
            return collect();
        }

        return Area::where('county_id', $this->form->county_id)->orderBy('name')->get();
    }

    #[Computed]
    public function hasDefaultAddress(): bool
    {
        return auth()->user()->addresses()->where('is_default', true)->exists();
    }

    #[Computed]
    public function mapState(): array
    {
        $county = $this->form->county_id ? County::with('boundary')->find($this->form->county_id) : null;

        $area = $this->form->area_id ? Area::find($this->form->area_id) : null;

        return [
            'pin' => [
                'lat' => $this->form->latitude,
                'lng' => $this->form->longitude,
            ],
            'center' => [
                'lat' => $area?->lat_center ?? ($county?->lat_center ?? -1.2921),
                'lng' => $area?->lng_center ?? ($county?->lng_center ?? 36.8219),
            ],
            'countyName' => $county?->name,
            'boundaryGeojson' => $county?->boundary?->geojson ?? null,
        ];
    }

    public function getMapState(): array
    {
        return $this->mapState();
    }

    public function updatedFormCountyId()
    {
        $this->form->area_id = null;
    }

    public function updatedFormAreaId(): void
    {
        // Triggers mapState recompute — JS picks it up via $wire
    }

    public function update()
    {
        try {
            $this->form->update();
            $this->dispatch('notify', title: 'Address Updated', variant: 'success', message: 'Your delivery address has been updated successfully');
            return $this->redirectRoute('customer.address-book.index', navigate: true);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            $this->dispatch('notify', title: 'Update Failed', variant: 'danger', message: $th->getMessage() ?: 'Unable to update address');
        }
    }
};

?>

<div>
    <flux:card class="p-0">
        <div class="flex items-center gap-3 px-3 py-2 border-b">
            <flux:button size="xs" icon="arrow-long-left" variant="ghost" class="cursor-pointer"
                :href="route('customer.address-book.index')" wire:navigate></flux:button>

            <flux:heading size="lg">Edit Address</flux:heading>
        </div>

        <form wire:submit="update" class="space-y-5 p-5">
            @include('pages.checkout.address._form-fields')

            <flux:separator />

            <div class="flex items-center justify-end gap-3">
                <flux:button :href="route('checkout.addresses.index')" wire:navigate class="cursor-pointer">
                    Cancel
                </flux:button>

                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Save Address
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
