<?php

use App\Events\TestEvent;
use Livewire\Component;

new class extends Component {
    public string $status = 'Waiting for event...';
    public string $receivedAt = '';
    public bool $received = false;
    public int $dispatchCount = 0;

    public function getListeners(): array
    {
        return [
            'echo-private:test.' . auth()->id() . ',.test.event' => 'onTestEvent',
        ];
    }

    public function onTestEvent(array $data): void
    {
        $this->status = 'Event received: ' . ($data['message'] ?? 'no message');
        $this->receivedAt = $data['time'] ?? now()->toTimeString();
        $this->received = true;
    }

    public function fireEvent(): void
    {
        $this->dispatchCount++;
        TestEvent::dispatch(auth()->id(), 'Sync test #' . $this->dispatchCount);
        $this->status = "Sync event dispatched (#{$this->dispatchCount}) — waiting...";
        $this->received = false;
    }

    public function fireQueued(): void
    {
        $this->dispatchCount++;
        TestEvent::dispatch(auth()->id(), 'Queued test #' . $this->dispatchCount);
        $this->status = "Queued event dispatched (#{$this->dispatchCount}) — waiting...";
        $this->received = false;
    }
};
?>

<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow space-y-6">
    <h2 class="text-xl font-bold text-zinc-800">Broadcasting Test</h2>

    {{-- Channel info --}}
    <div class="text-sm text-zinc-500">
        Listening on:
        <code class="bg-zinc-100 px-2 py-0.5 rounded">
            private-test.{{ auth()->id() }}
        </code>
    </div>

    {{-- Status box --}}
    <div
        class="p-4 rounded-lg border-2 transition-colors
        {{ $received ? 'border-green-400 bg-green-50' : 'border-zinc-200 bg-zinc-50' }}">
        <p class="font-medium {{ $received ? 'text-green-700' : 'text-zinc-600' }}">
            {{ $status }}
        </p>
        @if ($received)
            <p class="text-xs text-green-600 mt-1">Received at: {{ $receivedAt }}</p>
        @endif
    </div>

    {{-- Buttons --}}
    <div class="flex gap-3">
        <button wire:click="fireEvent"
            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium">
            Fire Sync
        </button>

        <button wire:click="fireQueued"
            class="flex-1 px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 text-sm font-medium">
            Fire Queued
        </button>
    </div>

    <p class="text-xs text-zinc-400">
        Queued simulates the webhook scenario.
        Ensure <code>php artisan queue:listen</code> is running.
    </p>
</div>
