<?php

use App\Settings\GeneralSettings;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

new #[Title('General Settings')] class extends Component {
    use WithFileUploads;

    // Identity
    public string $site_name = '';
    public string $site_tagline = '';
    public $logo = null;
    public $favicon = null;

    // Contact
    public string $contact_email = '';
    public string $support_phone = '';
    public string $physical_address = '';

    // Localization
    public string $currency = 'KES';
    public string $currency_symbol = 'KSh';
    public string $timezone = 'Africa/Nairobi';

    // Business
    public string $vat_number = '';
    public string $registration_number = '';

    // Track existing images
    public ?string $existing_logo = null;
    public ?string $existing_favicon = null;

    public function mount(GeneralSettings $settings): void
    {
        $this->site_name = $settings->site_name;
        $this->site_tagline = $settings->site_tagline;
        $this->existing_logo = $settings->logo;
        $this->existing_favicon = $settings->favicon;
        $this->contact_email = $settings->contact_email;
        $this->support_phone = $settings->support_phone;
        $this->physical_address = $settings->physical_address;
        $this->currency = $settings->currency;
        $this->currency_symbol = $settings->currency_symbol;
        $this->timezone = $settings->timezone;
        $this->vat_number = $settings->vat_number ?? '';
        $this->registration_number = $settings->registration_number ?? '';
    }

    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:100'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:512'],
            'contact_email' => ['required', 'email'],
            'support_phone' => ['required', 'string', 'max:20'],
            'physical_address' => ['required', 'string', 'max:255'],
            'currency' => ['required', 'string', 'max:10'],
            'currency_symbol' => ['required', 'string', 'max:10'],
            'timezone' => ['required', 'string', 'timezone'],
            'vat_number' => ['nullable', 'string', 'max:50'],
            'registration_number' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function save(GeneralSettings $settings): void
    {
        $this->validate();

        try {
            $settings->site_name = $this->site_name;
            $settings->site_tagline = $this->site_tagline;
            $settings->contact_email = $this->contact_email;
            $settings->support_phone = $this->support_phone;
            $settings->physical_address = $this->physical_address;
            $settings->currency = $this->currency;
            $settings->currency_symbol = $this->currency_symbol;
            $settings->timezone = $this->timezone;
            $settings->vat_number = $this->vat_number ?: null;
            $settings->registration_number = $this->registration_number ?: null;

            if ($this->logo) {
                $settings->logo = $this->logo->store('settings', 'public');
            }

            if ($this->favicon) {
                $settings->favicon = $this->favicon->store('settings', 'public');
            }

            $settings->save();

            // Refresh existing image references
            $this->existing_logo = $settings->logo;
            $this->existing_favicon = $settings->favicon;
            $this->logo = null;
            $this->favicon = null;

            $this->dispatch('notify', variant: 'success', message: 'General settings saved.');
        } catch (\Throwable $e) {
            logger()->error('Failed to save general settings.', ['exception' => $e->getMessage()]);
            $this->dispatch('notify', variant: 'danger', message: 'Something went wrong. Please try again.');
        }
    }

    public function removeLogo(GeneralSettings $settings): void
    {
        $settings->logo = null;
        $settings->save();
        $this->existing_logo = null;
    }

    public function removeFavicon(GeneralSettings $settings): void
    {
        $settings->favicon = null;
        $settings->save();
        $this->existing_favicon = null;
    }
}; ?>

<div>
    @include('partials.settings-heading')

    <x-pages::admin.settings.layout :heading="__('General Settings')" :subheading="__('Manage your store identity, contact details and localization')">
        <form wire:submit="save" class="space-y-6">

            {{-- Identity --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Basic Information</flux:heading>
                </div>

                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Company Name --}}
                    <flux:input label="Company Name" wire:model="company_name" placeholder="e.g. Sheffield Africa" />

                    {{-- Email --}}
                    <flux:input label="Email Address" wire:model="email_address"
                        placeholder="e.g. Quality Products, Delivered Fast" />

                    <flux:input label="Phone Number" wire:model="phone_number" placeholder="" />
                </div>

                <flux:separator />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 p-5">

                    <div class="flex items-center gap-2 bg-zinc-50 rounded-sm p-3 inset-shadow-sm">
                        <div class="shrink-0">
                            <flux:icon.photo class="size-20 text-inherit! stroke-1!" />
                        </div>

                        <div>
                            <flux:heading>White logo</flux:heading>
                            <flux:text class="text-xs">Recommended image size is 160px x 50px</flux:text>

                            <div class="flex items-center items-center gap-2 mt-2">
                                <flux:button class="cursor-pointer" variant="primary" size="xs">Change
                                </flux:button>
                                <flux:button class="cursor-pointer" size="xs">Cancel</flux:button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-zinc-50 rounded-sm p-3 inset-shadow-sm">
                        <div class="shrink-0">
                            <flux:icon.photo class="size-20 text-inherit! stroke-1!" />
                        </div>

                        <div>
                            <flux:heading>White logo</flux:heading>
                            <flux:text class="text-xs">Recommended image size is 160px x 50px</flux:text>

                            <div class="flex items-center items-center gap-2 mt-2">
                                <flux:button class="cursor-pointer" variant="primary" size="xs">Change
                                </flux:button>
                                <flux:button class="cursor-pointer" size="xs">Cancel</flux:button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-zinc-50 rounded-sm p-3 inset-shadow-sm">
                        <div class="shrink-0">
                            <flux:icon.photo class="size-20 text-inherit! stroke-1!" />
                        </div>

                        <div>
                            <flux:heading>White logo</flux:heading>
                            <flux:text class="text-xs">Recommended image size is 160px x 50px</flux:text>

                            <div class="flex items-center items-center gap-2 mt-2">
                                <flux:button class="cursor-pointer" variant="primary" size="xs">Change
                                </flux:button>
                                <flux:button class="cursor-pointer" size="xs">Cancel</flux:button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-zinc-50 rounded-sm p-3 inset-shadow-sm">
                        <div class="shrink-0">
                            <flux:icon.photo class="size-20 text-inherit! stroke-1!" />
                        </div>

                        <div>
                            <flux:heading>White logo</flux:heading>
                            <flux:text class="text-xs">Recommended image size is 160px x 50px</flux:text>

                            <div class="flex items-center items-center gap-2 mt-2">
                                <flux:button class="cursor-pointer" variant="primary" size="xs">Change
                                </flux:button>
                                <flux:button class="cursor-pointer" size="xs">Cancel</flux:button>
                            </div>
                        </div>
                    </div>

                </div>
            </flux:card>

            {{-- Address Information --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Address Information</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    {{-- Address --}}
                    <flux:input label="Address" wire:model="address" type="email"
                        description:trailing="Used in transactional emails and invoices"
                        placeholder="hello@sheffield.com" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Support Phone --}}
                        <flux:input label="Country" wire:model="support_phone" placeholder="+254 700 000 000" />
                        <flux:input label="Town" wire:model="support_phone" placeholder="+254 700 000 000" />
                        <flux:input label="Postal Code" wire:model="support_phone" placeholder="+254 700 000 000" />
                    </div>
                </div>
            </flux:card>

            <flux:separator />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Save Changes
                </flux:button>
            </div>

        </form>
    </x-pages::admin.settings.layout>
</div>
