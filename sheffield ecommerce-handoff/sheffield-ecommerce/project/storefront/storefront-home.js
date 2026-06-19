// Sheffield storefront home — renderer + interactions (faithful to the Livewire/Alpine original)
(function () {
  const SF = window.SF;
  const KES = n => 'KES\u00A0' + Number(n).toLocaleString('en-KE');

  // ───────── Icons (heroicons, 1.5 stroke) ─────────
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
    'arrow-left': P('<path d="M20 12H4M10 6l-6 6 6 6"/>'),
    'arrow-right': P('<path d="M4 12h16M14 6l6 6-6 6"/>'),
    'chevron-left': P('<path d="m15 6-6 6 6 6"/>'),
    'chevron-right': P('<path d="m9 6 6 6-6 6"/>'),
    building: P('<path d="M4 21V5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v16M13 9h6a1 1 0 0 1 1 1v11M7 8h2M7 12h2M7 16h2M16 13h1M16 17h1"/>'),
    check: P('<circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5 4.5-5"/>'),
    expand: P('<path d="M8 3H4v4M16 3h4v4M8 21H4v-4M16 21h4v-4"/>'),
    code: P('<path d="m8 8-4 4 4 4M16 8l4 4-4 4"/>'),
    envelope: P('<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>'),
    photo: P('<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="m4 18 5-5 4 4 3-3 4 4"/>'),
    plus: P('<path d="M12 5v14M5 12h14"/>'),
    minus: P('<path d="M5 12h14"/>'),
    trash: P('<path d="M4 7h16M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2M6 7l1 13h10l1-13"/>'),
    doc: P('<path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5M9.5 13h5M9.5 16.5h5"/>'),
  };
  const svg = (name, cls) => `<span class="${cls || ''} inline-flex shrink-0">${ICONS[name] || ''}</span>`;

  // Inline data-icon helpers (prepend small icons into labels)
  document.querySelectorAll('[data-icon]').forEach(el => {
    const map = { truck:'truck', shield:'shield', phone:'phone', 'arrow-right-sm':'arrow-right', 'arrow-right-w':'arrow-right', 'bars-w':'bars', envelope:'envelope' };
    const n = map[el.dataset.icon]; if (!n) return;
    el.insertAdjacentHTML('afterbegin', svg(n, 'size-3.5'));
  });
  document.querySelectorAll('[data-icon-btn]').forEach(el => {
    const map = { bars:'bars', search:'search', scale:'scale', heart:'heart', user:'user', cart:'cart', 'arrow-left':'arrow-left', 'arrow-right':'arrow-right', 'chevron-left':'chevron-left', 'chevron-right':'chevron-right' };
    el.insertAdjacentHTML('beforeend', svg(map[el.dataset.iconBtn], el.dataset.iconBtn.startsWith('chevron')?'size-3.5':'size-5'));
  });

  // ───────── Hero rotator ─────────
  (function hero() {
    const stage = document.getElementById('hero');
    const dotsEl = document.getElementById('heroDots');
    const numEl = document.getElementById('heroNum');
    const align = a => a === 'left' ? 'left center' : a === 'right' ? 'right center' : 'center';
    SF.hero.forEach((s, i) => {
      stage.insertAdjacentHTML('afterbegin', `
        <button type="button" data-slide="${i}" aria-label="${s.alt}"
          class="absolute inset-0 cursor-pointer border-0 p-0 transition-opacity duration-700 ${i===0?'opacity-100':'opacity-0 pointer-events-none'}">
          <img src="${s.src}" alt="${s.alt}" class="block size-full object-cover" style="object-position:${align(s.align)}" draggable="false"/>
          <span class="pointer-events-none absolute bottom-6 ${s.align==='left'?'right-6':'left-6'} inline-flex items-center gap-2 rounded-full bg-white/90 px-4 py-2.5 text-[13px] font-semibold text-ink shadow-lg backdrop-blur-md">
            ${s.cta} ${svg('arrow-right','size-3.5')}
          </span>
        </button>`);
      dotsEl.insertAdjacentHTML('beforeend', `<button type="button" data-dot="${i}" aria-label="Go to slide ${i+1}" class="h-1.5 rounded-full transition-all duration-200 ${i===0?'w-5 bg-white':'w-1.5 bg-white/55'}"></button>`);
    });
    const slides = [...stage.querySelectorAll('[data-slide]')];
    const dots = [...dotsEl.querySelectorAll('[data-dot]')];
    let idx = 0, paused = false;
    const show = n => {
      idx = (n + slides.length) % slides.length;
      slides.forEach((el, i) => el.className = el.className.replace(/opacity-\S+|pointer-events-\S+/g,'').trim() + (i===idx?' opacity-100':' opacity-0 pointer-events-none'));
      dots.forEach((d, i) => d.className = 'h-1.5 rounded-full transition-all duration-200 ' + (i===idx?'w-5 bg-white':'w-1.5 bg-white/55'));
      numEl.textContent = String(idx+1).padStart(2,'0');
    };
    document.getElementById('heroPrev').onclick = () => show(idx-1);
    document.getElementById('heroNext').onclick = () => show(idx+1);
    dots.forEach((d,i) => d.onclick = () => show(i));
    stage.addEventListener('mouseenter', () => paused = true);
    stage.addEventListener('mouseleave', () => paused = false);
    setInterval(() => { if (!paused) show(idx+1); }, 6500);
  })();

  // ───────── USPs ─────────
  document.getElementById('usps').innerHTML = SF.usps.map(u => `
    <div class="flex flex-col items-center gap-3 px-5 py-6 text-center">
      ${svg(u.icon,'size-9 text-brand-500')}
      <div>
        <div class="text-[11px] font-bold uppercase tracking-widest text-ink">${u.title}</div>
        <div class="mt-0.5 text-[11px] text-ink-3">${u.sub}</div>
      </div>
    </div>`).join('');

  // ───────── Category nav (sticky bar) ─────────
  const navCats = SF.categories.slice(0, 12);
  document.getElementById('catGrid').innerHTML = navCats.map((c,i) => `
    <a href="Category.html?c=${encodeURIComponent(c.name)}" class="flex items-center gap-2 px-3 py-2.5 text-sm transition ${i===0?'bg-brand-blue-700 font-medium text-white':'bg-brand-blue-500 text-[#f2ead9] hover:bg-brand-blue-600 hover:text-white'}">
      <span class="truncate">${c.name}</span>
    </a>`).join('');
  document.getElementById('catScroller').innerHTML = navCats.map((c,i) => `
    <a href="Category.html?c=${encodeURIComponent(c.name)}" class="shrink-0 whitespace-nowrap px-3 py-3 text-xs transition sm:px-4 sm:text-sm ${i===0?'font-medium text-white':'hover:opacity-80'}">${c.name}</a>`).join('');

  // ───────── Category tiles ─────────
  const GLYPH = {
    blade: P('<circle cx="12" cy="12" r="8"/><path d="M12 4v8l5.5 3"/>'),
    fridge: P('<rect x="6" y="3" width="12" height="18" rx="1.5"/><path d="M6 10h12M10 6v1.5M10 13v2"/>'),
    cup: P('<path d="M6 8h11v5a5 5 0 0 1-10 0zM17 9h2a2 2 0 0 1 0 4h-2M5 21h13"/>'),
    cake: P('<path d="M4 21V12a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v9zM4 16c2 0 2 1.5 4 1.5S10 16 12 16s2 1.5 4 1.5S18 16 20 16M12 5v4M12 4.5a.5.5 0 1 1-.001-.001"/>'),
    oven: P('<rect x="4" y="4" width="16" height="16" rx="1.5"/><path d="M4 9h16M7 6.5h2"/><rect x="8" y="12" width="8" height="6" rx="1"/>'),
    flame: P('<path d="M12 3c1 3 4 4 4 8a4 4 0 0 1-8 0c0-2 1-3 2-4 .5 1 1 1.5 2 1.5C12 6.5 11 5 12 3z"/>'),
  };
  document.getElementById('catTiles').innerHTML = SF.categories.map(c => `
    <a href="Category.html?c=${encodeURIComponent(c.name)}" class="group block">
      <div class="relative grid aspect-square place-items-center overflow-hidden bg-surface-sunken text-ink-3 transition group-hover:text-brand-500">
        <span class="size-12 transition group-hover:scale-110">${GLYPH[c.glyph] || GLYPH.fridge}</span>
      </div>
      <div class="flex items-baseline justify-between gap-2 pt-2.5">
        <div class="text-[11.5px] font-semibold uppercase leading-tight tracking-[0.06em] text-ink transition-colors group-hover:text-brand-500">${c.name}</div>
        <div class="shrink-0 text-[11px] text-ink-3 tabular-nums">${c.count}</div>
      </div>
    </a>`).join('');

  // ───────── Brands marquee ─────────
  const brandCell = b => `<a href="#" class="flex w-[180px] shrink-0 flex-col items-center justify-center gap-2 self-stretch border-r border-zinc-200 px-5 py-7 text-center transition hover:bg-surface-sunken"><div class="font-serif text-lg text-ink">${b}</div></a>`;
  document.getElementById('brandTrack').innerHTML = [...SF.brands, ...SF.brands].map(brandCell).join('');

  // ───────── Product card ─────────
  function card(p, extraCls) {
    const price = p.sale ?? p.price;
    const discount = p.sale && p.price ? Math.round((1 - p.sale/p.price) * 100) : null;
    const priceLabel = price != null ? KES(price) : 'Request quote';
    const action = p.quote
      ? `<a href="#" class="absolute bottom-2.5 right-2.5 z-10 inline-flex h-9 items-center gap-1.5 rounded-full bg-brand-500 px-3.5 text-[12px] font-semibold text-white shadow-md transition hover:bg-brand-600">${svg('doc','size-3.5')} Quote</a>`
      : `<div class="sf-stepper absolute bottom-2.5 right-2.5 z-10" data-qty="0">
           <div class="stepper-pill relative h-9 w-9 overflow-hidden rounded-full bg-brand-500 text-white shadow-md transition-[width] duration-200">
             <div class="stepper-left pointer-events-none absolute inset-y-0 left-0 right-9 flex items-center opacity-0 transition-opacity duration-150">
               <button type="button" aria-label="Remove one" class="stepper-minus flex size-9 shrink-0 items-center justify-center transition hover:bg-brand-600">${svg('trash','size-3.5')}</button>
               <span class="stepper-count flex-1 text-center text-[13px] font-bold tabular-nums">0</span>
             </div>
             <button type="button" aria-label="Add to cart" class="stepper-add absolute right-0 flex size-9 items-center justify-center rounded-full transition hover:bg-brand-600">${svg('cart','size-3.5')}</button>
           </div>
         </div>`;
    return `
    <article class="group flex flex-col overflow-hidden rounded border border-zinc-200 bg-white transition hover:shadow-md ${extraCls||''}">
      <div class="relative aspect-square w-full overflow-hidden bg-surface-sunken">
        <a href="#" class="absolute inset-0 grid place-items-center text-ink-4">${svg('photo','size-12')}</a>
        ${discount ? `<span class="absolute left-0 top-2.5 z-10 inline-flex h-5 items-center rounded-r bg-brand-500 px-2 text-[10.5px] font-bold tracking-wider text-white">−${discount}%</span>`:''}
        <div class="absolute right-2.5 top-2.5 z-10 flex flex-col gap-1.5">
          <button type="button" aria-label="Save to wishlist" class="wish inline-flex size-8 items-center justify-center rounded-full border border-zinc-200 bg-white/95 text-ink opacity-0 shadow-sm transition hover:bg-white group-hover:opacity-100">${svg('heart','size-4')}</button>
          <button type="button" aria-label="Add to compare" class="cmp inline-flex size-8 items-center justify-center rounded-full border border-zinc-200 bg-white/95 text-ink opacity-0 shadow-sm transition hover:bg-white group-hover:opacity-100">${svg('scale','size-4')}</button>
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

  document.getElementById('arrivals').innerHTML = SF.arrivals.map(p => `<div class="w-[44%] shrink-0 sm:w-[30%] md:w-[23%] lg:w-[19%]">${card(p,'h-full')}</div>`).join('');
  document.getElementById('featured').innerHTML = SF.featured.map(p => card(p)).join('');

  // Arrivals scroll buttons
  const track = document.getElementById('arrivals');
  document.getElementById('arrPrev').onclick = () => track.scrollBy({ left: -track.clientWidth*0.6, behavior:'smooth' });
  document.getElementById('arrNext').onclick = () => track.scrollBy({ left:  track.clientWidth*0.6, behavior:'smooth' });

  // ───────── Cart stepper behaviour ─────────
  document.querySelectorAll('.sf-stepper').forEach(stp => {
    const pill = stp.querySelector('.stepper-pill');
    const left = stp.querySelector('.stepper-left');
    const count = stp.querySelector('.stepper-count');
    const minus = stp.querySelector('.stepper-minus');
    const add = stp.querySelector('.stepper-add');
    let qty = 0, expanded = false, timer = null;
    const render = () => {
      pill.style.width = expanded ? '100px' : '36px';
      left.style.opacity = expanded ? '1' : '0';
      left.style.pointerEvents = expanded ? 'auto' : 'none';
      count.textContent = qty;
      minus.innerHTML = qty <= 1 ? ICONS.trash.replace('<svg','<svg class="size-3.5"') : ICONS.minus.replace('<svg','<svg class="size-3.5"');
      add.innerHTML = svg(expanded ? 'plus' : 'cart','size-3.5');
    };
    const expand = () => { expanded = true; clearTimeout(timer); timer = setTimeout(() => { expanded = false; render(); }, 3000); render(); };
    add.onclick = e => { e.preventDefault(); if (!expanded && qty>0) return expand(); qty++; expand(); };
    minus.onclick = e => { e.preventDefault(); qty = qty>1 ? qty-1 : 0; if (qty>0) expand(); else { expanded=false; render(); } };
    render();
  });

  // Wishlist / compare visual toggle
  document.querySelectorAll('.wish').forEach(b => b.onclick = e => { e.preventDefault(); b.classList.toggle('!opacity-100'); b.classList.toggle('border-brand-500'); b.classList.toggle('bg-brand-500'); b.classList.toggle('text-white'); });
  document.querySelectorAll('.cmp').forEach(b => b.onclick = e => { e.preventDefault(); b.classList.toggle('!opacity-100'); b.classList.toggle('border-brand-blue-500'); b.classList.toggle('bg-brand-blue-500'); b.classList.toggle('text-white'); });

  // ───────── Footer categories ─────────
  document.getElementById('footerCats').innerHTML = SF.categories.slice(0,7).map(c => `<li><a href="#" class="hover:text-white">${c.name}</a></li>`).join('');
})();
