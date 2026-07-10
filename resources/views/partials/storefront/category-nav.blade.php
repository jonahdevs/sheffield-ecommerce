{{-- $navCategories is computed once in layouts/storefront.blade.php (with children eager-loaded).

     Two responsive layouts (pattern carried over from the previous site):
       • lg+   : capped 2-row grid (6 cols) of triggers + a Reka-style mega-menu.
                 Hovering/focusing a trigger opens a single shared "viewport" that
                 cross-fades content and smoothly morphs height between categories.
       • < lg  : a horizontal scroll strip with fade/chevron affordances (broad swipe browse).

     Flyout content is fetched on hover from route('menu.flyout', $category) and rendered
     by partials/storefront/mega-menu-panel.blade.php — the category's image on the left,
     a grid of child categories on the right. See App\Http\Controllers\Storefront\
     CategoryMenuController for the (currently random) children source. --}}
<nav x-data="megaMenu" @mousemove="trackPointer($event)" @mouseleave="close()"
    @keydown.escape.window="close()" @scroll.window.passive="onScroll()"
    class="relative bg-brand-blue-500 text-[#f2ead9]">

    {{-- Desktop (lg+) — trigger grid. grid-rows-2 + auto-rows-[0] caps visible content at
         exactly 2 rows; overflow rows collapse to 0 height and get clipped. --}}
    <div class="shell hidden lg:block">
        <div
            class="grid grid-cols-6 grid-rows-2 auto-rows-[0] gap-px overflow-hidden border-x border-white/20 bg-white/20">
            @foreach ($navCategories as $category)
                @php
                    $isActive =
                        request()->routeIs('category.show') && request()->route('category')?->id === $category->id;
                @endphp
                {{-- Only categories with sub-categories are mega-menu triggers; the rest
                     stay plain links (no empty flyout). Settling on — or tabbing to — a
                     plain link dismisses an open panel, since the pointer never leaves the
                     nav and so the nav-level mouseleave never fires. The dismissal waits
                     for the pointer to settle so that sweeping down through a plain link,
                     on the way from a top-row trigger to the panel, doesn't close it. --}}
                <a href="{{ route('category.show', $category) }}" wire:navigate
                    @if ($category->children_count > 0)
                        @mouseenter="hover($event, {{ $category->id }}, '{{ route('menu.flyout', $category) }}')"
                        @mouseleave="cancelOpen()"
                        @focus="focus($event, {{ $category->id }}, '{{ route('menu.flyout', $category) }}')"
                        aria-haspopup="true" :aria-expanded="(active === {{ $category->id }} && isOpen).toString()"
                    @else
                        @mouseenter="closeIntent($event)"
                        @mouseleave="cancelClose()"
                        @focus="close()"
                    @endif
                    @class([
                        'flex items-center gap-2 px-3 py-2.5 text-sm transition',
                        'bg-brand-blue-700 font-medium text-white' => $isActive,
                        'bg-brand-blue-500 text-[#f2ead9] hover:bg-brand-blue-600 hover:text-white' => !$isActive,
                    ])
                    :class="active === {{ $category->id }} && isOpen ? 'bg-brand-blue-600 text-white' : ''">
                    @if ($category->icon_svg)
                        <span class="grid size-5 shrink-0 place-items-center [&>svg]:size-full">
                            {!! $category->icon_svg !!}
                        </span>
                    @elseif ($category->icon_image_url)
                        <img src="{{ $category->icon_image_url }}" alt=""
                            class="size-5 shrink-0 object-contain brightness-0 invert" loading="lazy" />
                    @endif
                    <span class="truncate">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Shared mega-menu viewport (lg+). Two stacked layers cross-slide: the
         outgoing panel exits toward the direction of travel while the incoming
         one enters from the opposite edge. The viewport morphs height between
         them. Layer transforms/opacity are driven imperatively from swap(). --}}
    {{-- perspective on the direct parent gives the card's rotateX real depth (Reka scaleIn). --}}
    <div class="absolute inset-x-0 top-full z-40 hidden text-ink lg:block">
        <div class="shell [perspective:2000px]">
            <div x-cloak x-show="isOpen" x-transition:enter="transition duration-200 ease-out origin-top transform-3d"
                x-transition:enter-start="opacity-0 -rotate-x-10 scale-90"
                x-transition:enter-end="opacity-100 rotate-x-0 scale-100"
                x-transition:leave="transition duration-150 ease-in origin-top transform-3d"
                x-transition:leave-start="opacity-100 rotate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -rotate-x-10 scale-95"
                class="relative overflow-hidden rounded-b-md bg-white shadow-xl ring-1 ring-zinc-200 transition-[height] duration-300 ease-out"
                :style="`height: ${height || 240}px`">
                {{-- Two content layers, populated + cross-slid by swap() --}}
                <div x-ref="layer0" class="absolute inset-x-0 top-0 transition duration-300 ease-out"></div>
                <div x-ref="layer1" class="absolute inset-x-0 top-0 transition duration-300 ease-out"></div>

                {{-- Loading spinner on first fetch (before any content exists) --}}
                <div x-show="loading && ! hasContent" class="grid h-60 place-items-center">
                    <span class="size-6 animate-spin rounded-full border-2 border-zinc-200 border-t-brand-blue-500"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile / tablet (< lg) — horizontal scroller with edge fades --}}
    <section x-data="{
        showLeft: false,
        showRight: true,
        updateArrows() {
            const el = this.$refs.scroller;
            this.showLeft = el.scrollLeft > 10;
            this.showRight = el.scrollLeft + el.clientWidth < el.scrollWidth - 10;
        },
        scrollByDir(dir) {
            this.$refs.scroller.scrollBy({ left: dir * 160, behavior: 'smooth' });
            setTimeout(() => this.updateArrows(), 300);
        },
    }" x-init="updateArrows()" @resize.window="updateArrows()"
        class="group relative shell flex items-center lg:hidden">

        {{-- Left chevron (appears once scrolled) --}}
        <button type="button" x-cloak x-show="showLeft" x-transition.opacity @click="scrollByDir(-1)"
            aria-label="Scroll categories left"
            class="invisible absolute left-0 z-10 flex h-full w-8 cursor-pointer items-center justify-center bg-linear-to-r from-brand-blue-500 via-brand-blue-500/90 to-transparent text-white group-hover:visible">
            <flux:icon.chevron-left variant="micro" class="size-4" />
        </button>

        {{-- Scrollable strip --}}
        <div x-ref="scroller" @scroll="updateArrows()"
            class="flex w-full overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
            @foreach ($navCategories as $category)
                @php
                    $isActive =
                        request()->routeIs('category.show') && request()->route('category')?->id === $category->id;
                @endphp
                <a href="{{ route('category.show', $category) }}" wire:navigate @class([
                    'shrink-0 px-3 py-3 text-xs whitespace-nowrap transition sm:text-sm sm:px-4',
                    'font-medium text-white' => $isActive,
                    'hover:opacity-80' => !$isActive,
                ])>
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Right chevron --}}
        <button type="button" x-cloak x-show="showRight" x-transition.opacity @click="scrollByDir(1)"
            aria-label="Scroll categories right"
            class="invisible absolute right-0 z-10 flex h-full w-8 cursor-pointer items-center justify-center bg-linear-to-l from-brand-blue-500 via-brand-blue-500/90 to-transparent text-white group-hover:visible">
            <flux:icon.chevron-right variant="micro" class="size-4" />
        </button>
    </section>
</nav>
