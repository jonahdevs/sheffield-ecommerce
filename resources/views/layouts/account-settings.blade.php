<x-layouts::storefront :title="$title ?? null">
    {{-- no pb: the newsletter section's own mt-12 provides the gap --}}
    <div class="shell pt-4">
        <div class="border-b border-zinc-200 pb-3">
            @stack('breadcrumbs')
        </div>
        <div class="mt-6 flex flex-col gap-8 lg:flex-row lg:items-start">

            {{-- Settings sidebar --}}
            <aside class="w-full shrink-0 lg:w-64">
                <div class="overflow-hidden rounded-md border border-zinc-200 bg-white">

                    <div class="p-2">
                        <flux:navlist>

                            <flux:navlist.group heading="Settings">
                                <flux:navlist.item icon="user" :href="route('profile.edit')" :current="request()->routeIs('profile.edit')" wire:navigate>
                                    Profile
                                </flux:navlist.item>
                                <flux:navlist.item icon="shield-check" :href="route('security.edit')" :current="request()->routeIs('security.edit')" wire:navigate>
                                    Password & Security
                                </flux:navlist.item>
                                <flux:navlist.item icon="bell" :href="route('notifications.edit')" :current="request()->routeIs('notifications.edit')" wire:navigate>
                                    Notifications
                                </flux:navlist.item>
                                <flux:navlist.item icon="lock-closed" :href="route('privacy.edit')" :current="request()->routeIs('privacy.edit')" wire:navigate>
                                    Privacy & Data
                                </flux:navlist.item>
                            </flux:navlist.group>

                            <flux:separator class="my-2" />

                            <flux:navlist.item icon="chevron-left" :href="route('account.dashboard')" wire:navigate>
                                Back to account
                            </flux:navlist.item>

                        </flux:navlist>
                    </div>

                </div>
            </aside>

            {{-- Content --}}
            <main class="min-w-0 flex-1">
                {{ $slot }}
            </main>

        </div>
    </div>
</x-layouts::storefront>
