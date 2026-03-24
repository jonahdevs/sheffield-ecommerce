@if (auth()->check() && auth()->user()->is_staff)
    <x-layouts::app>
        <div class="flex flex-col items-center justify-center min-h-[60vh] text-center">
            <div class="max-w-md">
                <h1 class="text-6xl font-bold text-orange-600 mb-4">429</h1>
                <h2 class="text-2xl font-semibold text-zinc-800 mb-4">Too Many Requests</h2>
                <p class="text-zinc-600 mb-8">You've made too many requests. Please wait a moment and try again.</p>
                <flux:button href="{{ route('dashboard') }}" wire:navigate variant="primary" icon="arrow-left">
                    Back to Dashboard
                </flux:button>
            </div>
        </div>
    </x-layouts::app>
@else
    <x-layouts::guest>
        <div class="container mx-auto px-4 py-20 flex flex-col items-center justify-center min-h-[60vh] text-center">
            <div class="max-w-md">
                <h1 class="text-6xl font-bold text-orange-600 mb-4">429</h1>
                <h2 class="text-2xl font-semibold text-zinc-800 mb-4">Too Many Requests</h2>
                <p class="text-zinc-600 mb-8">You've made too many requests. Please wait a moment and try again.</p>
                <div class="flex flex-col gap-3">
                    <flux:button href="{{ route('home') }}" wire:navigate variant="primary" icon="arrow-left"
                        class="w-full">
                        Back to Home
                    </flux:button>
                    @auth
                        <flux:button href="{{ route('account.index') }}" wire:navigate variant="ghost" class="w-full">
                            Go to Account
                        </flux:button>
                    @endauth
                </div>
            </div>
        </div>
    </x-layouts::guest>
@endif
