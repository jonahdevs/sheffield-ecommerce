<?php

use App\Settings\SeoSettings;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

new #[Title('SEO Settings')] class extends Component {
    use WithFileUploads;

    public string $meta_title = '';
    public string $meta_description = '';
    public string $meta_keywords = '';
    public $og_image = null;
    public ?string $existing_og_image = null;
    public string $google_analytics_id = '';
    public string $google_tag_manager_id = '';
    public string $google_site_verification = '';
    public bool $indexing_enabled = true;

    public function mount(SeoSettings $settings): void
    {
        $this->meta_title = $settings->meta_title;
        $this->meta_description = $settings->meta_description;
        $this->meta_keywords = $settings->meta_keywords;
        $this->existing_og_image = $settings->og_image;
        $this->google_analytics_id = $settings->google_analytics_id ?? '';
        $this->google_tag_manager_id = $settings->google_tag_manager_id ?? '';
        $this->google_site_verification = $settings->google_site_verification ?? '';
        $this->indexing_enabled = $settings->indexing_enabled;
    }

    public function rules(): array
    {
        return [
            'meta_title' => ['required', 'string', 'max:70'],
            'meta_description' => ['required', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'og_image' => ['nullable', 'image', 'max:2048'],
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:50'],
            'google_site_verification' => ['nullable', 'string', 'max:100'],
            'indexing_enabled' => ['boolean'],
        ];
    }

    public function save(SeoSettings $settings): void
    {
        $this->validate();

        try {
            $settings->meta_title = $this->meta_title;
            $settings->meta_description = $this->meta_description;
            $settings->meta_keywords = $this->meta_keywords;
            $settings->google_analytics_id = $this->google_analytics_id ?: null;
            $settings->google_tag_manager_id = $this->google_tag_manager_id ?: null;
            $settings->google_site_verification = $this->google_site_verification ?: null;
            $settings->indexing_enabled = $this->indexing_enabled;

            if ($this->og_image) {
                $settings->og_image = $this->og_image->store('settings', 'public');
                $this->existing_og_image = $settings->og_image;
                $this->og_image = null;
            }

            $settings->save();

            $this->dispatch('notify', variant: 'success', message: 'SEO settings saved.');
        } catch (\Throwable $e) {
            logger()->error('Failed to save SEO settings.', ['exception' => $e->getMessage()]);
            $this->dispatch('notify', variant: 'danger', message: 'Something went wrong. Please try again.');
        }
    }

    public function removeOgImage(SeoSettings $settings): void
    {
        $settings->og_image = null;
        $settings->save();
        $this->existing_og_image = null;
    }
}; ?>

<div>
    @include('partials.settings-heading')

    <x-pages::admin.settings.layout :heading="__('SEO Settings')" :subheading="__('Manage how your store appears in search engines and social media')">
        <form wire:submit="save" class="space-y-6">

            {{-- Meta Tags --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Meta Tags</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    {{-- Meta Title --}}
                    <flux:input label="Meta Title" wire:model.live="meta_title"
                        placeholder="e.g. Sheffield Africa — Quality Products"
                        description:trailing="{{ strlen($meta_title) }}/70 characters. Recommended: 50-70 characters." />

                    {{-- Meta Description --}}
                    <flux:textarea label="Meta Description"
                        description:trailing="{{ strlen($meta_description) }}/160 characters. Recommended: 120-160 characters."
                        wire:model="meta_description" rows="3"
                        placeholder="A short description of your store shown in search results..." />

                    {{-- Meta Keywords --}}
                    <flux:input label="Meta Keywords (optional)" description:trailing="Comma-separated keywords"
                        wire:model="meta_keywords" placeholder="e.g. electronics, kenya, online shop" />
                </div>
            </flux:card>

            {{-- Open Graph --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Open Graph Image</flux:heading>
                    <flux:text class="text-xs text-zinc-400 mt-1">
                        Shown when your site is shared on social media (Facebook, Twitter, WhatsApp etc.)
                    </flux:text>
                </div>

                <div class="p-5 space-y-5">
                    @if ($existing_og_image && !$og_image)
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . $existing_og_image) }}" alt="OG Image"
                                class="h-24 w-auto object-cover rounded border border-zinc-200 dark:border-zinc-700" />
                            <flux:button size="sm" variant="ghost" class="text-red-500!" wire:click="removeOgImage"
                                wire:confirm="Remove the current OG image?">
                                Remove
                            </flux:button>
                        </div>
                    @endif

                    @if ($og_image)
                        <img src="{{ $og_image->temporaryUrl() }}" alt="OG Image preview"
                            class="h-24 w-auto object-cover rounded border border-zinc-200 dark:border-zinc-700" />
                    @endif


                    <flux:input description:trailing="Recommended size: 1200x630px. Max 2MB." type="file"
                        wire:model="og_image" accept="image/*" />
                </div>
            </flux:card>

            {{-- Google --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Google</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    {{-- Google Analytics --}}
                    <flux:input label="Google Analytics ID (Optional)" wire:model="google_analytics_id"
                        placeholder="G-XXXXXXXXXX" />

                    {{-- Google Tag Manager ID --}}
                    <flux:input label="Google Tag Manager ID (optional)" wire:model="google_tag_manager_id"
                        placeholder="GTM-XXXXXXX" />

                    {{-- Google Site Verification --}}
                    <flux:input label="Google Site Verification (optional)" wire:model="google_site_verification"
                        description:trailing="The content value from the Google Search Console verification meta tag."
                        placeholder="Verification meta content value" />
                </div>
            </flux:card>

            {{-- Indexing --}}
            <div class="space-y-2">
                <flux:heading>Search Engine Indexing</flux:heading>

                <div
                    class="flex items-start justify-between gap-4 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                    <div>
                        <flux:text class="text-sm font-medium">Allow Search Engine Indexing</flux:text>
                        <flux:text class="text-xs text-zinc-400 mt-0.5">
                            Disabling this adds a noindex tag — search engines will stop showing your site in results.
                            Useful during development or maintenance.
                        </flux:text>
                    </div>
                    <flux:switch wire:model="indexing_enabled" />
                </div>
            </div>

            <flux:separator />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" class="cursor-pointer">
                    Save Changes
                </flux:button>
            </div>

        </form>
    </x-pages::admin.settings.layout>
</div>
