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
                    <flux:heading>Identity</flux:heading>
                </div>

                <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Site Name --}}
                    <flux:input label="Site Name" wire:model="site_name" placeholder="e.g. Sheffield Africa" />

                    {{-- Site Tagline --}}
                    <flux:input label="Site Tagline (optional)" wire:model="site_tagline"
                        placeholder="e.g. Quality Products, Delivered Fast" />


                    {{-- Logo --}}
                    <flux:field>
                        <flux:label>Logo</flux:label>
                        @if ($existing_logo && !$logo)
                            <div class="flex items-center gap-4 mb-2">
                                <img src="{{ asset('storage/' . $existing_logo) }}" alt="Logo"
                                    class="h-12 object-contain rounded border border-zinc-200 dark:border-zinc-700 p-1" />
                                <flux:button size="sm" variant="ghost" class="text-red-500!"
                                    wire:click="removeLogo" wire:confirm="Remove the current logo?">
                                    Remove
                                </flux:button>
                            </div>
                        @endif
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" alt="Logo preview"
                                class="h-12 object-contain rounded border border-zinc-200 dark:border-zinc-700 p-1 mb-2" />
                        @endif
                        <flux:input type="file" wire:model="logo" accept="image/*" />
                        <flux:description>Recommended size: 200x60px. Max 2MB.</flux:description>
                        <flux:error name="logo" />
                    </flux:field>

                    {{-- Favicon --}}
                    <flux:field>
                        <flux:label>Favicon</flux:label>
                        @if ($existing_favicon && !$favicon)
                            <div class="flex items-center gap-4 mb-2">
                                <img src="{{ asset('storage/' . $existing_favicon) }}" alt="Favicon"
                                    class="size-8 object-contain rounded border border-zinc-200 dark:border-zinc-700 p-1" />
                                <flux:button size="sm" variant="ghost" class="text-red-500!"
                                    wire:click="removeFavicon" wire:confirm="Remove the current favicon?">
                                    Remove
                                </flux:button>
                            </div>
                        @endif
                        @if ($favicon)
                            <img src="{{ $favicon->temporaryUrl() }}" alt="Favicon preview"
                                class="size-8 object-contain rounded border border-zinc-200 dark:border-zinc-700 p-1 mb-2" />
                        @endif

                        <flux:input type="file" wire:model="favicon" accept="image/*" />
                        <flux:description>Recommended size: 32x32px. Max 512KB.</flux:description>
                        <flux:error name="favicon" />
                    </flux:field>
                </div>
            </flux:card>

            {{-- Contact --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Contact</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Contact Email --}}
                        <flux:input label="Contact Email" wire:model="contact_email" type="email"
                            description:trailing="Used in transactional emails and invoices"
                            placeholder="hello@sheffield.com" />

                        {{-- Support Phone --}}
                        <flux:input label="Support Phone" wire:model="support_phone" placeholder="+254 700 000 000" />
                    </div>


                    <flux:textarea label="Physical Address" wire:model="physical_address"
                        description:trailing="Shown in the footer and on invoices"
                        placeholder="e.g. 4th Floor, TRG Plaza, Nairobi" rows="2" />
                </div>
            </flux:card>

            {{-- Localization --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Localization</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Currency Code --}}
                        <flux:input label="Currency Code" description:trailing="e.g. KES, USD, EUR"
                            wire:model="currency" placeholder="KES" />

                        {{-- Currency Symbol --}}
                        <flux:input label="Currency Symbol" description:trailing="e.g. KSh, $, €"
                            wire:model="currency_symbol" placeholder="KSh" />
                    </div>

                    <flux:select label="Timezone" wire:model="timezone">
                        @foreach (timezone_identifiers_list() as $tz)
                            <flux:select.option :value="$tz">{{ $tz }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

            </flux:card>

            {{-- Business --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Business</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    {{-- VAT / Tax Number --}}
                    <flux:input label="VAT / Tax Number (optional)"
                        description:trailing="Printed on invoices and receipts" wire:model="vat_number"
                        placeholder="e.g. P051234567X" />

                    {{-- Registration Number --}}
                    <flux:input label="Registration Number (optional)" wire:model="registration_number"
                        placeholder="e.g. CPR/2020/12345" />
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
