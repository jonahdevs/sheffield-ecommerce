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
        $this->form->setAddress($address);
    }

    #[Computed]
    public function counties()
    {
        return County::withShippingRates()->orderBy('name')->get();
    }

    #[Computed]
    public function areas()
    {
        if (!$this->form->county_id) {
            return collect();
        }

        return Area::where('county_id', $this->form->county_id)->orderBy('name')->get();
    }

    public function updatedFormCountyId()
    {
        $this->form->area_id = '';
    }

    public function update()
    {
        try {
            $this->form->update();
            $this->dispatch('notify', variant: 'success', message: 'Address updated successfully');
            return $this->redirectRoute('customer.address-book.index', navigate: true);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $th) {
            $this->dispatch('notify', variant: 'danger', message: $th->getMessage());
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
                <flux:button :href="route('checkout.addresses')" wire:navigate class="cursor-pointer">
                    Cancel
                </flux:button>

                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Save Address
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
