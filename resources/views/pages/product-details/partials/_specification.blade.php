<div wire:cloak wire:show="selectedTab == 'specification'">
    @if (!empty($product->technical_specification))
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <tbody class="divide-y dark:divide-zinc-700">
                    @foreach ($product->technical_specification as $key => $value)
                        <tr class="even:bg-zinc-50 dark:even:bg-zinc-800/50">
                            <td class="px-4 py-3 font-medium text-zinc-700 dark:text-zinc-300 w-1/3">
                                {{ $key }}
                            </td>
                            <td class="px-4 py-3 text-zinc-500 dark:text-zinc-400">
                                {{ is_array($value) ? implode(', ', $value) : $value }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-sm text-zinc-400">No specifications available for this product.</p>
    @endif
</div>
