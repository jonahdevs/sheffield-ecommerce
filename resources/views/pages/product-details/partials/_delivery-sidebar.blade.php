<div class="lg:col-span-1">
    <flux:card class="sticky top-44 p-0">
        <div class="border-b px-3 py-2">
            <flux:heading>Delivery & Returns</flux:heading>
        </div>

        <div class="p-3">
            <h4 class="text-sm font-medium text-slate-600">Choose your location</h4>

            <flux:select class="w-full mt-2" wire:model.live.debounce.300ms="selectedCounty"
                placeholder="Select County...">
                @foreach ($this->counties as $county)
                    <flux:select.option :value="$county->id">{{ $county->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model.live.debounce.300ms="selectedArea"
                :placeholder="$selectedCounty ? 'Select Area' : 'Select a county first'" :disabled="!$selectedCounty"
                class="mt-2">
                @foreach ($this->areas as $area)
                    <flux:select.option :value="$area->id">{{ $area->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="border-t p-3 flex items-center">
            <div class="border rounded-sm flex items-center justify-center p-1">
                <svg class="size-7 shrink-0" fill="currentColor" version="1.1" viewBox="0 0 100 100">
                    <path
                        d="m56.59 6.8594c-16.781-1.4375-33.602 7.0391-41.996 22.824-2.7969 5.2617-4.4023 10.852-4.9023 16.445l-0.17578 1.9922 3.9844 0.35547 0.17578-1.9922c0.45312-5.0742 1.9062-10.141 4.4531-14.926 10.18-19.145 33.863-26.434 53.047-16.328 19.184 10.105 26.566 33.766 16.535 52.988-10.027 19.215-33.621 26.699-53.18 16.602-9.7031-5.207-16.332-13.73-19.281-23.355l-0.58203-1.918-3.8242 1.1719 0.58203 1.9102c3.25 10.602 10.578 20.008 21.215 25.719 0.011719 0.007813 0.019531 0.011719 0.03125 0.015625 21.449 11.09 47.562 2.8398 58.59-18.293 11.027-21.133 2.8711-47.266-18.219-58.375-5.2734-2.7773-10.859-4.3555-16.453-4.8359z" />
                    <path
                        d="m29.336 34.293c-0.62109-0.29688-1.3516-0.25781-1.9336 0.11328-0.58203 0.36719-0.93359 1.0078-0.93359 1.6953v29.004c0.003906 0.80078 0.48047 1.5234 1.2188 1.8359l24.367 10.438c0.50391 0.21875 1.0781 0.21875 1.582 0l24.367-10.438c0.73438-0.31641 1.2109-1.0391 1.2109-1.8359v-29.004c0-0.6875-0.35156-1.3242-0.92969-1.6914-0.58203-0.36719-1.3086-0.41406-1.9297-0.11719l-23.512 11.191zm1.1367 4.9688 21.52 10.246-0.003907-0.003906c0.54297 0.25781 1.1719 0.25781 1.7148 0l21.52-10.246v24.523l-22.375 9.582-22.375-9.582z" />
                    <path
                        d="m52.848 45.695c-0.53125 0-1.043 0.21094-1.418 0.58594s-0.58594 0.88672-0.58594 1.4141v27.848c0 0.53125 0.21094 1.0391 0.58594 1.4141s0.88672 0.58594 1.418 0.58594c0.52734 0 1.0391-0.21094 1.4141-0.58594s0.58594-0.88281 0.58594-1.4141v-27.848c0-0.52734-0.21094-1.0391-0.58594-1.4141s-0.88672-0.58594-1.4141-0.58594z" />
                    <path
                        d="m52.055 22.656-24.367 10.445c-1.0117 0.43359-1.4844 1.6055-1.0547 2.6211 0.20703 0.48828 0.60156 0.875 1.0938 1.0742 0.49219 0.19922 1.0469 0.19141 1.5352-0.015625l23.586-10.105 23.586 10.105h-0.003906c0.48828 0.20703 1.043 0.21484 1.5352 0.015625 0.49219-0.19922 0.88672-0.58594 1.0938-1.0742 0.42969-1.0156-0.042969-2.1875-1.0547-2.6211l-24.367-10.445c-0.50391-0.21484-1.0781-0.21484-1.582 0z" />
                    <path
                        d="m19.488 38.859-1.4102 1.418-5.5234 5.582-4.5039-4.4531-1.418-1.4023-2.8125 2.8438 1.418 1.4023 5.9219 5.8594c0.78516 0.77734 2.0508 0.76953 2.8281-0.011719l6.9297-6.9961 1.4102-1.4258z" />
                </svg>
            </div>
            <div class="ms-2">
                <flux:heading>Return Policy</flux:heading>
                <flux:text class="text-xs">Easy Returns, Quick Refund. <flux:link>Details</flux:link>
                </flux:text>
            </div>
        </div>

        <div class="border-t p-3 flex items-center">
            <div class="border rounded-sm flex items-center justify-center p-1">
                <flux:icon.shield-check class="size-7 shrink-0 stroke-1" />
            </div>
            <div class="ms-2">
                <flux:heading>Warranty</flux:heading>
                <flux:text class="text-xs">Covered against manufacturing defects. See <flux:link>Details</flux:link>
                </flux:text>
            </div>
        </div>
    </flux:card>
</div>
