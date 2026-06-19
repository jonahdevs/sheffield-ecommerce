// Sheffield storefront — shared chrome (header, category nav, footer, product card, interactions)
window.SFChrome = (function () {
  const SF = window.SF;
  const KES = n => 'KES\u00A0' + Number(n).toLocaleString('en-KE');

  const P = d => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">${d}</svg>`;
  const ICONS = {
    truck: P('<path d="M2 5h11v11H2zM13 8h4l3 3v5h-7"/><circle cx="6" cy="18" r="1.6"/><circle cx="16.5" cy="18" r="1.6"/>'),
    shield: P('<path d="M12 3l7 3v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6z"/><path d="m9 12 2 2 4-4"/>'),
    phone: P('<path d="M5 4h3l1.5 4-2 1.5a11 11 0 0 0 5 5L19 12l4 1.5V17a2 2 0 0 1-2 2A16 16 0 0 1 5 4z" transform="translate(-1 0)"/>'),
    bars: P('<path d="M4 6h16M4 12h16M4 18h16"/>'),
    search: P('<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>'),
    scale: P('<path d="M12 4v16M7 8h10M5 8l-2.5 5a3 3 0 0 0 5 0L5 8zM19 8l-2.5 5a3 3 0 0 0 5 0L19 8zM7 20h10"/>'),
    heart: P('<path d="M12 20s-7-4.5-9.5-9A4.5 4.5 0 0 1 12 6a4.5 4.5 0 0 1 9.5 5C19 15.5 12 20 12 20z"/>'),
    user: P('<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>'),
    cart: P('<circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/><path d="M3 4h2l2.5 12h11l2-8H6"/>'),
    'arrow-right': P('<path d="M4 12h16M14 6l6 6-6 6"/>'),
    'chevron-down': P('<path d="m6 9 6 6 6-6"/>'),
    envelope: P('<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>'),
    photo: P('<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="m4 18 5-5 4 4 3-3 4 4"/>'),
    plus: P('<path d="M12 5v14M5 12h14"/>'),
    minus: P('<path d="M5 12h14"/>'),
    trash: P('<path d="M4 7h16M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2M6 7l1 13h10l1-13"/>'),
    doc: P('<path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5M9.5 13h5M9.5 16.5h5"/>'),
    funnel: P('<path d="M3 5h18l-7 8v6l-4-2v-4z"/>'),
    star: '<svg viewBox="0 0 24 24" fill="currentColor"><path d="m12 3 2.6 5.6 6 .7-4.5 4 1.3 6L12 16.6 6.6 19.3l1.3-6-4.5-4 6-.7z"/></svg>',
    x: P('<path d="M6 6l12 12M18 6 6 18"/>'),
  };
  const svg = (name, cls) => `<span class="${cls || ''} inline-flex shrink-0">${ICONS[name] || ''}</span>`;

  // ───────── Header (promo + logo bar + category nav) ─────────
  function header(active) {
    const navItem = (label, key) => `<a href="${key==='shop'?'Shop.html':'#'}" class="${active===key?'text-brand-500':'text-zinc-900 hover:text-brand-500'} transition-colors">${label}</a>`;
    const cats = SF.categories.slice(0, 12);
    return `
    <div class="sticky top-0 z-40 bg-white">
      <div class="bg-brand-blue-500 text-[#f2ead9]">
        <div class="shell flex h-9 items-center justify-between gap-4 text-[12.5px]">
          <div class="flex items-center gap-7 overflow-hidden">
            <span class="flex items-center gap-1.5">${svg('truck','size-3.5')}Free delivery within Nairobi</span>
            <span class="hidden opacity-60 md:inline">·</span>
            <span class="hidden items-center gap-1.5 md:flex">${svg('shield','size-3.5')}Local parts &amp; service across East Africa</span>
            <span class="hidden opacity-60 lg:inline">·</span>
            <a href="tel:+254713777111" class="hidden items-center gap-1.5 hover:text-white lg:flex">${svg('phone','size-3.5')}+254&nbsp;713&nbsp;777&nbsp;111</a>
          </div>
          <div class="flex items-center gap-3 text-[#d8c79d]">
            <a href="#" class="hidden hover:text-white sm:inline">Sign in</a>
            <span class="hidden opacity-50 sm:inline">·</span><a href="#" class="hover:text-white">KES</a>
          </div>
        </div>
      </div>
      <header style="background-image:url('assets/navbar-bg.webp');background-size:cover;background-position:center;">
        <div class="shell relative flex flex-wrap items-center gap-x-4 gap-y-3 py-3 lg:h-[72px] lg:flex-nowrap lg:gap-6 lg:py-0">
          <button class="order-1 inline-flex size-11 shrink-0 items-center justify-center rounded-md text-zinc-900 hover:bg-black/5 lg:hidden">${svg('bars','size-6')}</button>
          <a href="Home.html" class="order-2 flex shrink-0 items-center lg:order-1"><img src="assets/logo.png" alt="Sheffield" class="h-9 w-auto sm:h-10"/></a>
          <div class="hidden lg:order-2 lg:block lg:w-auto lg:max-w-xl lg:flex-1">
            <div class="relative">
              <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-ink-4">${svg('search','size-5')}</span>
              <input type="search" placeholder="Search 2,000+ products, brands or SKU…" class="h-11 w-full rounded-md border border-zinc-200 bg-white/95 pl-10 pr-16 text-sm text-ink shadow-sm outline-none placeholder:text-ink-4 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30"/>
              <kbd class="absolute right-3 top-1/2 hidden -translate-y-1/2 rounded border border-zinc-200 bg-zinc-50 px-1.5 py-0.5 text-[10px] font-medium text-ink-4 xl:block">⌘K</kbd>
            </div>
          </div>
          <nav class="order-3 hidden items-center gap-6 text-sm font-semibold text-zinc-900 lg:flex">
            ${navItem('Shop','shop')}${navItem('Request quote','quote')}${navItem('Contact','contact')}
          </nav>
          <div class="order-3 ml-auto flex items-center gap-1 lg:order-4">
            <button class="inline-flex size-11 shrink-0 items-center justify-center rounded-md text-zinc-900 hover:bg-black/5 lg:hidden">${svg('search','size-6')}</button>
            <div class="hidden items-center gap-1 sm:flex">
              <button class="relative inline-flex size-10 items-center justify-center rounded-md text-ink-2 hover:bg-black/5">${svg('scale','size-5')}</button>
              <button class="relative inline-flex size-10 items-center justify-center rounded-md text-ink-2 hover:bg-black/5">${svg('heart','size-5')}<span class="absolute right-1 top-1 flex size-4 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white">3</span></button>
            </div>
            <button class="inline-flex size-10 items-center justify-center rounded-md text-ink-2 hover:bg-black/5 hover:text-ink">${svg('user','size-5')}</button>
            <button class="relative inline-flex size-10 items-center justify-center rounded-md text-ink-2 hover:bg-black/5">${svg('cart','size-5')}<span class="absolute right-1 top-1 flex size-4 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white">2</span></button>
          </div>
        </div>
      </header>
      <nav class="bg-brand-blue-500 text-[#f2ead9]">
        <div class="shell hidden lg:block">
          <div class="grid grid-cols-6 grid-rows-2 auto-rows-[0] gap-px overflow-hidden border-x border-white/20 bg-white/20">
            ${cats.map(c => `<a href="Category.html?c=${encodeURIComponent(c.name)}" class="flex items-center gap-2 px-3 py-2.5 text-sm transition bg-brand-blue-500 text-[#f2ead9] hover:bg-brand-blue-600 hover:text-white"><span class="truncate">${c.name}</span></a>`).join('')}
          </div>
        </div>
        <div class="shell flex items-center lg:hidden">
          <button class="mr-1 flex shrink-0 items-center gap-1.5 border-r border-white/20 py-3 pr-3 text-xs font-medium text-white">${svg('bars','size-4')}Browse</button>
          <div class="flex w-full overflow-x-auto no-scrollbar">
            ${cats.map(c => `<a href="Category.html?c=${encodeURIComponent(c.name)}" class="shrink-0 whitespace-nowrap px-3 py-3 text-xs hover:opacity-80 sm:px-4 sm:text-sm">${c.name}</a>`).join('')}
          </div>
        </div>
      </nav>
    </div>`;
  }

  // ───────── Footer + newsletter ─────────
  function footer() {
    const cats = SF.categories.slice(0, 7);
    const showroom = (city, addr, phone, hq) => `<div><div class="inline-flex items-center gap-2 text-[13px] font-semibold text-[#f3eadd]">${city}${hq?' <span class="rounded-sm bg-brand-500 px-1.5 py-px text-[9px] tracking-wider text-white">HQ</span>':''}</div><div class="mt-1 text-[12px] leading-snug text-[#c9bea4]">${addr}</div><div class="mt-1.5 text-[12px] text-[#d8c79d]"><a href="#" class="hover:text-white">${phone}</a></div></div>`;
    return `
    <section class="mt-20 bg-surface-sunken">
      <div class="shell grid grid-cols-1 items-center gap-6 py-12 md:grid-cols-[1fr_auto]">
        <div>
          <h2 class="font-serif text-[26px] font-semibold text-ink">Stay ahead of the kitchen.</h2>
          <p class="mt-1.5 text-[14px] text-ink-3">New arrivals, clearance deals and procurement tips — once a month, no spam.</p>
        </div>
        <form class="flex w-full max-w-md gap-2" onsubmit="return false">
          <input type="email" placeholder="you@business.co.ke" class="h-12 flex-1 rounded-md border border-line bg-white px-4 text-sm text-ink outline-none placeholder:text-ink-4 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/30"/>
          <button class="h-12 shrink-0 rounded-md bg-brand-500 px-6 text-sm font-semibold text-white transition hover:bg-brand-600">Subscribe</button>
        </form>
      </div>
    </section>
    <footer class="bg-brand-blue-500 pt-16 pb-8 text-[#e6ddc8]">
      <div class="shell">
        <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-12">
          <div class="col-span-2 sm:col-span-3 md:col-span-4">
            <a href="Home.html" class="inline-flex items-center"><img src="assets/logo-inverse.png" alt="Sheffield" class="h-9 w-auto"/></a>
            <p class="mt-4 max-w-xs text-sm leading-relaxed text-[#c9bea4]">Commercial kitchen equipment for restaurants, hotels and catering operations across East Africa. Since 2003.</p>
            <div class="mt-5 flex flex-col gap-2 text-[13.5px] text-[#c9bea4]">
              <a href="mailto:info@sheffieldafrica.com" class="inline-flex items-center gap-2 hover:text-white">${svg('envelope','size-3.5')}info@sheffieldafrica.com</a>
              <a href="tel:+254713777111" class="inline-flex items-center gap-2 hover:text-white">${svg('phone','size-3.5')}+254 713 777 111</a>
            </div>
            <div class="mt-5 flex flex-wrap gap-x-4 gap-y-2 text-[12px] font-medium tracking-wide text-[#d8c79d]">
              <a href="#" class="hover:text-white">Facebook</a><a href="#" class="hover:text-white">Instagram</a><a href="#" class="hover:text-white">LinkedIn</a><a href="#" class="hover:text-white">WhatsApp</a>
            </div>
          </div>
          <div class="md:col-span-2"><h3 class="mb-4 text-xs font-bold uppercase tracking-widest text-[#d8c79d]">Showrooms</h3><div class="flex flex-col gap-5">${showroom('Nairobi','Enterprise Road, Industrial Area, Kenya','+254 713 777 111',true)}${showroom('Mombasa','Nyali Road, Mombasa, Kenya','+254 713 777 222',false)}</div></div>
          <div class="md:col-span-2"><h3 class="mb-4 text-xs font-bold uppercase tracking-widest text-[#d8c79d]">Showrooms</h3><div class="flex flex-col gap-5">${showroom('Kampala','Ntinda Industrial Area, Uganda','+256 772 100 200',false)}${showroom('Kigali','KN 5 Road, Kigali, Rwanda','+250 788 300 400',false)}</div></div>
          <div class="md:col-span-2"><h3 class="mb-4 text-xs font-bold uppercase tracking-widest text-[#d8c79d]">Business</h3><ul class="space-y-2.5 text-[13.5px] text-[#c9bea4]"><li><a href="Categories.html" class="hover:text-white">All categories</a></li><li><a href="#" class="hover:text-white">Request a quote</a></li></ul></div>
          <div class="md:col-span-2"><h3 class="mb-4 text-xs font-bold uppercase tracking-widest text-[#d8c79d]">Shop</h3><ul class="space-y-2.5 text-[13.5px] text-[#c9bea4]">${cats.map(c=>`<li><a href="Category.html?c=${encodeURIComponent(c.name)}" class="hover:text-white">${c.name}</a></li>`).join('')}</ul></div>
        </div>
        <div class="mt-14 flex flex-wrap items-center justify-between gap-4 border-t border-[#e6ddc8]/15 pt-6 text-[12.5px] text-[#9c927c]">
          <div class="flex items-center gap-4"><span>&copy; 2026 Sheffield Steel Systems Ltd.</span><a href="#" class="hover:text-white">Terms</a><a href="#" class="hover:text-white">Privacy</a><a href="#" class="hover:text-white">Cookies</a></div>
          <div class="flex items-center gap-4"><span>Authorised distributor</span><span class="h-4 w-px bg-[#e6ddc8]/20"></span><span class="font-serif text-sm text-[#d8c79d]">NSF · CE · KEBS</span></div>
        </div>
      </div>
    </footer>`;
  }

  // ───────── Product card ─────────
  function productCard(p, extraCls) {
    const price = p.sale ?? p.price;
    const discount = p.sale && p.price ? Math.round((1 - p.sale/p.price) * 100) : null;
    const priceLabel = price != null ? KES(price) : 'Request quote';
    const action = (p.quote || price == null)
      ? `<a href="#" class="absolute bottom-2.5 right-2.5 z-10 inline-flex h-9 items-center gap-1.5 rounded-full bg-brand-500 px-3.5 text-[12px] font-semibold text-white shadow-md transition hover:bg-brand-600">${svg('doc','size-3.5')} Quote</a>`
      : `<div class="sf-stepper absolute bottom-2.5 right-2.5 z-10">
           <div class="stepper-pill relative h-9 w-9 overflow-hidden rounded-full bg-brand-500 text-white shadow-md transition-[width] duration-200">
             <div class="stepper-left pointer-events-none absolute inset-y-0 left-0 right-9 flex items-center opacity-0 transition-opacity duration-150">
               <button class="stepper-minus flex size-9 shrink-0 items-center justify-center transition hover:bg-brand-600">${svg('trash','size-3.5')}</button>
               <span class="stepper-count flex-1 text-center text-[13px] font-bold tabular-nums">0</span>
             </div>
             <button class="stepper-add absolute right-0 flex size-9 items-center justify-center rounded-full transition hover:bg-brand-600">${svg('cart','size-3.5')}</button>
           </div>
         </div>`;
    return `
    <article class="group flex flex-col overflow-hidden rounded border border-zinc-200 bg-white transition hover:shadow-md ${extraCls||''}">
      <div class="relative aspect-square w-full overflow-hidden bg-surface-sunken">
        <a href="#" class="absolute inset-0 grid place-items-center text-ink-4">${svg('photo','size-12')}</a>
        ${discount ? `<span class="absolute left-0 top-2.5 z-10 inline-flex h-5 items-center rounded-r bg-brand-500 px-2 text-[10.5px] font-bold tracking-wider text-white">−${discount}%</span>`:''}
        ${p.stock===false ? `<span class="absolute left-2.5 ${discount?'top-9':'top-2.5'} z-10 inline-flex h-5 items-center rounded bg-zinc-900/80 px-2 text-[10px] font-semibold tracking-wide text-white">On order</span>`:''}
        <div class="absolute right-2.5 top-2.5 z-10 flex flex-col gap-1.5">
          <button class="wish inline-flex size-8 items-center justify-center rounded-full border border-zinc-200 bg-white/95 text-ink opacity-0 shadow-sm transition hover:bg-white group-hover:opacity-100">${svg('heart','size-4')}</button>
          <button class="cmp inline-flex size-8 items-center justify-center rounded-full border border-zinc-200 bg-white/95 text-ink opacity-0 shadow-sm transition hover:bg-white group-hover:opacity-100">${svg('scale','size-4')}</button>
        </div>
        ${action}
      </div>
      <a href="#" class="flex flex-1 flex-col px-3 py-3 sm:px-4 sm:py-3.5">
        <div class="text-[11px] font-bold uppercase tracking-[0.08em] text-brand-blue-600">${p.brand}</div>
        <div class="mt-1 line-clamp-2 min-h-[38px] text-[13.5px] font-medium leading-snug text-ink">${p.name}</div>
        <div class="mt-0.5 text-[11px] text-ink-4 tabular-nums">${p.sku}</div>
        <div class="mt-3">
          ${p.sale ? `<div class="text-[11.5px] text-ink-4 line-through">${KES(p.price)}</div>`:''}
          <div class="whitespace-nowrap text-[15px] font-bold tabular-nums text-ink">${priceLabel}</div>
        </div>
      </a>
    </article>`;
  }

  function wireCards(root) {
    (root || document).querySelectorAll('.sf-stepper:not([data-wired])').forEach(stp => {
      stp.dataset.wired = '1';
      const pill = stp.querySelector('.stepper-pill'), left = stp.querySelector('.stepper-left');
      const count = stp.querySelector('.stepper-count'), minus = stp.querySelector('.stepper-minus'), add = stp.querySelector('.stepper-add');
      let qty = 0, expanded = false, timer = null;
      const render = () => {
        pill.style.width = expanded ? '100px' : '36px';
        left.style.opacity = expanded ? '1' : '0'; left.style.pointerEvents = expanded ? 'auto' : 'none';
        count.textContent = qty;
        minus.innerHTML = svg(qty <= 1 ? 'trash' : 'minus','size-3.5');
        add.innerHTML = svg(expanded ? 'plus' : 'cart','size-3.5');
      };
      const expand = () => { expanded = true; clearTimeout(timer); timer = setTimeout(() => { expanded = false; render(); }, 3000); render(); };
      add.onclick = e => { e.preventDefault(); if (!expanded && qty>0) return expand(); qty++; expand(); };
      minus.onclick = e => { e.preventDefault(); qty = qty>1 ? qty-1 : 0; if (qty>0) expand(); else { expanded=false; render(); } };
      render();
    });
    (root || document).querySelectorAll('.wish:not([data-wired])').forEach(b => { b.dataset.wired='1'; b.onclick = e => { e.preventDefault(); ['!opacity-100','border-brand-500','bg-brand-500','text-white'].forEach(c=>b.classList.toggle(c)); }; });
    (root || document).querySelectorAll('.cmp:not([data-wired])').forEach(b => { b.dataset.wired='1'; b.onclick = e => { e.preventDefault(); ['!opacity-100','border-brand-blue-500','bg-brand-blue-500','text-white'].forEach(c=>b.classList.toggle(c)); }; });
  }

  function mount(activeNav) {
    const h = document.getElementById('sf-header'); if (h) h.innerHTML = header(activeNav);
    const f = document.getElementById('sf-footer'); if (f) f.innerHTML = footer();
  }

  // ───────── Category glyph tiles (used on Home + Categories index) ─────────
  const Pg = d => `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">${d}</svg>`;
  const GLYPH = {
    blade: Pg('<circle cx="12" cy="12" r="8"/><path d="M12 4v8l5.5 3"/>'),
    fridge: Pg('<rect x="6" y="3" width="12" height="18" rx="1.5"/><path d="M6 10h12M10 6v1.5M10 13v2"/>'),
    cup: Pg('<path d="M6 8h11v5a5 5 0 0 1-10 0zM17 9h2a2 2 0 0 1 0 4h-2M5 21h13"/>'),
    cake: Pg('<path d="M4 21V12a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9zM4 16c2 0 2 1.5 4 1.5S10 16 12 16s2 1.5 4 1.5S18 16 20 16M12 5v4"/>'),
    oven: Pg('<rect x="4" y="4" width="16" height="16" rx="1.5"/><path d="M4 9h16M7 6.5h2"/><rect x="8" y="12" width="8" height="6" rx="1"/>'),
    flame: Pg('<path d="M12 3c1 3 4 4 4 8a4 4 0 0 1-8 0c0-2 1-3 2-4 .5 1 1 1.5 2 1.5C12 6.5 11 5 12 3z"/>'),
  };
  function categoryTile(c) {
    return `<a href="Category.html?c=${encodeURIComponent(c.name)}" class="group block">
      <div class="relative grid aspect-square place-items-center overflow-hidden bg-surface-sunken text-ink-3 transition group-hover:text-brand-500">
        <span class="size-12 transition group-hover:scale-110">${GLYPH[c.glyph] || GLYPH.fridge}</span>
      </div>
      <div class="flex items-baseline justify-between gap-2 pt-2.5">
        <div class="text-[11.5px] font-semibold uppercase leading-tight tracking-[0.06em] text-ink transition-colors group-hover:text-brand-500">${c.name}</div>
        <div class="shrink-0 text-[11px] text-ink-3 tabular-nums">${c.count}</div>
      </div>
    </a>`;
  }

  return { ICONS, svg, KES, header, footer, productCard, wireCards, mount, GLYPH, categoryTile };
})();
