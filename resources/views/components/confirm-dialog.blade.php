{{-- Styled replacement for wire:confirm's native browser dialog. Included once
     per layout; the click interceptor in resources/js/app.js routes every
     wire:confirm action through this modal, so call sites keep the plain
     wire:confirm attribute. The data-confirm-dialog marker is how the
     interceptor detects the dialog is available before hijacking the click. --}}
<flux:modal name="confirm-dialog" class="max-w-sm" data-confirm-dialog>
    <flux:heading class="uppercase tracking-wide">Please confirm</flux:heading>
    <flux:subheading class="mt-1" x-data x-text="$store.confirmDialog.message"></flux:subheading>
    <div class="mt-6 flex justify-end gap-3">
        <flux:modal.close>
            <flux:button variant="ghost">Cancel</flux:button>
        </flux:modal.close>
        <flux:button variant="danger" x-data x-on:click="$store.confirmDialog.proceed()">Confirm</flux:button>
    </div>
</flux:modal>
