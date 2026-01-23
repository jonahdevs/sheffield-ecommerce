<?php

use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.guest')] class extends Component {
    //
};
?>

<div>
    <div class="container mx-auto px-4 py-4">
        {{-- Breadcrumbs --}}
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('home') }}" wire:navigate>
                <flux:icon.home class="w-4 h-4 me-1.5 inline-block" />
                Home
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('products') }}">Products</flux:breadcrumbs.item>
        </flux:breadcrumbs>



    </div>
</div>
