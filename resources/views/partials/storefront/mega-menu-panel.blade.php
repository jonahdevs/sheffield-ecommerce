{{-- Mega-menu flyout body, fetched on hover by the category navigation.
     Left: the hovered category's own image. Right: a grid of child categories
     as home-style bordered image cards (image + centered name, no count).

     No Alpine directives here - this markup is injected via x-html, which does
     not initialise nested Alpine components. --}}
@php
    $blurb =
        \Illuminate\Support\Str::limit(strip_tags($category->description ?? ''), 90) ?:
        'Explore our full ' . $category->name . ' range.';
@endphp
<div class="grid gap-6 p-6 lg:grid-cols-9">
    {{-- Promo (left) - category image --}}
    <a href="{{ route('category.show', $category) }}" wire:navigate
        class="group relative col-span-2 flex min-h-48 flex-col justify-end overflow-hidden rounded-md bg-brand-blue-700 p-5 text-white">
        @if ($category->banner_url ?: $category->image_url)
            <img src="{{ $category->banner_url ?: $category->image_url }}" alt=""
                class="absolute inset-0 size-full object-cover opacity-50" loading="lazy" />
        @endif
        <div class="absolute inset-0 bg-linear-to-t from-black/85 via-black/40 to-black/10"></div>
        <div class="relative">
            <p class="text-xs font-medium uppercase tracking-wide text-white/70">Explore</p>
            <h3 class="mt-1 font-serif text-lg font-bold">{{ $category->name }}</h3>
            <p class="mt-1 line-clamp-2 text-sm text-white/80">{{ $blurb }}</p>
        </div>
    </a>

    {{-- Children grid (right) --}}
    <div class="col-span-7">
        <div class="grid grid-cols-6 gap-2">
            @foreach ($children as $child)
                <a href="{{ route('category.show', $child) }}" wire:navigate
                    class="group block overflow-hidden rounded border border-zinc-200 bg-white">
                    <div class="relative aspect-4/3 overflow-hidden bg-zinc-100">
                        @if ($child->image_url)
                            <img src="{{ $child->image_url }}" alt="" loading="lazy"
                                class="size-full object-cover" />
                        @elseif ($child->icon_svg)
                            <span
                                class="grid size-full place-items-center p-3 text-brand-blue-600 [&>svg]:size-6">{!! $child->icon_svg !!}</span>
                        @else
                            <span
                                class="grid size-full place-items-center text-lg font-bold text-brand-blue-600/40">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($child->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div
                        class="truncate px-1.5 py-1.5 text-center text-xs font-semibold uppercase tracking-wider text-ink underline-offset-2 group-hover:underline">
                        {{ $child->name }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
