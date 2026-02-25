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
                    <flux:input label="Meta Title" wire:model="meta_title" />

                    {{-- Meta Keywords --}}
                    <flux:input label="Meta Keywords (optional)" wire:model="meta_keywords" />

                    {{-- Meta Description --}}
                    <flux:textarea label="Meta Description" wire:model="meta_description" rows="3" />

                    {{-- Canonical Url --}}
                    <flux:input label="Canonical Url" wire:model="canonical_url" />

                </div>
            </flux:card>

            {{-- Open Graph --}}
            <flux:card class="p-0">
                <div class="border-b px-3 py-2">
                    <flux:heading>Open Graph</flux:heading>
                </div>

                <div class="p-5 space-y-5">
                    {{-- Og Title --}}
                    <flux:input label="Og Title" wire:model.live="og_title" />

                    {{-- Og Description --}}
                    <flux:textarea label="Og Description" wire:model="og_description" rows="3" />

                    <flux:field>

                        <flux:label>Og Image</flux:label>
                        <div class="flex items-center gap-2 bg-zinc-50 rounded-sm p-3 inset-shadow-sm">
                            <div class="shrink-0">
                                <flux:icon.photo class="size-20 text-inherit! stroke-1!" />
                            </div>

                            <div>
                                <flux:heading>OG Image</flux:heading>
                                <flux:text class="text-xs">Recommended image size is 160px x 50px</flux:text>

                                <div class="flex items-center items-center gap-2 mt-2">
                                    <flux:button class="cursor-pointer" variant="primary" size="xs">Change
                                    </flux:button>
                                    <flux:button class="cursor-pointer" size="xs">Cancel</flux:button>
                                </div>
                            </div>
                    </flux:field>
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
