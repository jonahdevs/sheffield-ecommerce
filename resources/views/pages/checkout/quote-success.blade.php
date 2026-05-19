<?php

use App\Models\Quote;
use Livewire\Attributes\{Layout, Locked};
use Livewire\Component;
use Artesaos\SEOTools\Facades\SEOMeta;

new #[Layout('layouts.guest')] class extends Component {
    #[Locked]
    public string $reference = '';

    public function mount(string $reference): void
    {
        SEOMeta::setRobots('noindex,nofollow');

        $quote = Quote::where('reference', $reference)->first();

        if (!$quote) {
            $this->redirectRoute('home', navigate: true);

            return;
        }

        // If the quote has an owner, only that owner can see this page.
        // Guest-submitted quotes (user_id = NULL) are accessible to anyone holding the reference.
        if ($quote->user_id && $quote->user_id !== auth()->id()) {
            $this->redirectRoute('home', navigate: true);

            return;
        }

        $this->dispatch('quote-basket-updated');
        $this->reference = $reference;
    }
};
?>

<div>
    <x-slot:heading>Quote Request</x-slot:heading>

    <div class="max-w-lg mx-auto text-center py-10">

        {{-- Success icon --}}
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <flux:icon.check class="size-8 text-green-600" />
        </div>

        {{-- Heading --}}
        <flux:heading size="xl" class="mb-2">Quote Request Sent!</flux:heading>

        <flux:text class="text-on-surface-variant text-sm mb-1">
            Your quotation reference is:
        </flux:text>
        <p class="font-mono font-semibold text-on-surface text-sm mb-5">
            {{ $reference }}
        </p>

        {{-- What happens next --}}
        <div class="text-left bg-zinc-50 border border-zinc-200 rounded-lg p-4 mb-6 space-y-3">
            <p class="text-sm font-medium text-on-surface">What happens next:</p>

            <div class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                    <span class="text-xs font-bold text-amber-600">1</span>
                </div>
                <p class="text-sm text-on-surface-variant">
                    Our team reviews your request and prepares a priced quotation.
                </p>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                    <span class="text-xs font-bold text-amber-600">2</span>
                </div>
                <p class="text-sm text-on-surface-variant">
                    You'll receive an email with the priced quote and a link to review it.
                </p>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                    <span class="text-xs font-bold text-amber-600">3</span>
                </div>
                <p class="text-sm text-on-surface-variant">
                    Accept the quotation to proceed to payment, or reject it if it doesn't work for you.
                </p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-center gap-3">
            {{-- Links to quotations page — not orders page --}}
            <flux:button :href="route('customer.quotations.index')" wire:navigate variant="customer-primary"
                size="customer-lg" class="cursor-pointer">
                View My Quotations
            </flux:button>

            <flux:button :href="route('shop.index')" wire:navigate variant="customer-outline" size="customer-lg"
                class="cursor-pointer">
                Continue Shopping
            </flux:button>
        </div>
    </div>
</div>
