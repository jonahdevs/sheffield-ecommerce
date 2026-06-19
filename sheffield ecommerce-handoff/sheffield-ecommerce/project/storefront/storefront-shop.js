// Sheffield Shop — filters, sort, grid (faithful to catalog.blade.php behaviour)
(function () {
  const SF = window.SF, C = window.SFChrome, KES = C.KES, svg = C.svg;
  const ABS_MIN = 0, ABS_MAX = 6000000, STEP = 50000;

  C.mount('shop');

  // Facets derived from the catalog
  const catCounts = {};
  SF.catalog.forEach(p => catCounts[p.cat] = (catCounts[p.cat]||0)+1);
  const cats = SF.categories.filter(c => catCounts[c.name]).map(c => ({ name: c.name, count: catCounts[c.name] }));
  const brands = [...new Set(SF.catalog.map(p => p.brand))].sort();
  document.getElementById('catCount').textContent = cats.length;
  document.getElementById('brandCount').textContent = brands.length;

  // State
  const S = { cats: new Set(), brands: new Set(), pmin: ABS_MIN, pmax: ABS_MAX, rating: 0, stock: false, sort: 'popularity' };
  const fmtK = v => 'KES ' + Number(v).toLocaleString();

  function hasFilters() { return S.cats.size || S.brands.size || S.stock || S.rating>0 || S.pmin>ABS_MIN || S.pmax<ABS_MAX; }

  // ───────── Filter panel markup ─────────
  function section(title, open, body) {
    return `<div class="filter-section px-5 py-4" data-open="${open?'true':'false'}">
      <button type="button" class="filter-toggle flex w-full cursor-pointer items-center justify-between text-[12px] font-bold uppercase tracking-[0.08em] text-ink-2">
        <span>${title}</span><span class="filter-chevron flex text-zinc-400">${svg('chevron-down','size-3.5')}</span>
      </button>
      <div class="filter-body mt-3">${body}</div>
    </div>`;
  }
  function checkRow(f, value, label, count) {
    return `<label class="flex cursor-pointer items-center gap-2.5 text-[13.5px] text-ink-2">
      <input type="checkbox" data-f="${f}" value="${value}" class="size-4 rounded border-zinc-300 text-brand-500 focus:ring-brand-500"/>
      <span class="flex-1">${label}</span>${count!=null?`<span class="text-xs text-ink-4 tabular-nums">${count}</span>`:''}
    </label>`;
  }
  function priceBody() {
    return `<div class="price-filter">
      <div class="mb-3 flex justify-between text-[12.5px] text-ink-3"><span class="pf-min-read"></span><span class="pf-max-read font-semibold text-ink"></span></div>
      <div class="relative h-5">
        <div class="pointer-events-none absolute inset-x-0 top-1/2 h-1 -translate-y-1/2 rounded-full bg-zinc-200"></div>
        <div class="pf-fill pointer-events-none absolute top-1/2 h-1 -translate-y-1/2 rounded-full bg-brand-500"></div>
        <input type="range" data-f="pmin" min="${ABS_MIN}" max="${ABS_MAX}" step="${STEP}" class="price-thumb absolute inset-0 h-5 w-full appearance-none bg-transparent"/>
        <input type="range" data-f="pmax" min="${ABS_MIN}" max="${ABS_MAX}" step="${STEP}" class="price-thumb absolute inset-0 h-5 w-full appearance-none bg-transparent"/>
      </div>
      <div class="mt-4 flex items-end gap-2">
        <div class="flex-1"><label class="mb-1 block text-[11px] text-ink-4">Min</label><input type="number" data-f="pminN" min="${ABS_MIN}" max="${ABS_MAX}" step="${STEP}" class="w-full rounded border border-zinc-300 px-2 py-1.5 text-[13px] tabular-nums focus:border-brand-500 focus:outline-none"/></div>
        <span class="pb-2 text-ink-4">—</span>
        <div class="flex-1"><label class="mb-1 block text-[11px] text-ink-4">Max</label><input type="number" data-f="pmaxN" min="${ABS_MIN}" max="${ABS_MAX}" step="${STEP}" class="w-full rounded border border-zinc-300 px-2 py-1.5 text-[13px] tabular-nums focus:border-brand-500 focus:outline-none"/></div>
      </div>
    </div>`;
  }
  function ratingBody() {
    let h = '<div class="flex flex-col gap-2.5">';
    for (let r=4; r>=1; r--) {
      let stars=''; for (let i=1;i<=5;i++) stars += svg('star', 'size-4 '+(i<=r?'text-amber-500':'text-zinc-300'));
      h += `<label class="flex cursor-pointer items-center gap-2"><input type="radio" name="rating" data-f="rating" value="${r}" class="size-4 border-zinc-300 text-brand-500 focus:ring-brand-500"/><span class="flex items-center gap-1.5">${stars}<span class="ms-1 text-[12.5px]">&amp; up</span></span></label>`;
    }
    return h + '</div>';
  }
  function panelHTML(includeCategory) {
    const brandRows = brands.map((b,i) => `<div class="${i>=6?'brand-extra hidden':''}">${checkRow('brand', b, b)}</div>`).join('');
    const brandMore = brands.length>6 ? `<button type="button" class="brand-more mt-2 cursor-pointer text-[12.5px] text-brand-500 hover:underline">Show all ${brands.length} brands</button>` : '';
    return `<div class="divide-y divide-zinc-200 rounded-md border border-zinc-200 bg-white text-sm">
      ${includeCategory ? section('Category', true, `<div class="scrollbar-hover flex max-h-64 flex-col gap-2 overflow-y-auto pr-1">${cats.map(c=>checkRow('cat',c.name,c.name,c.count)).join('')}</div>`) : ''}
      ${section('Price', true, priceBody())}
      ${section('Rating', false, ratingBody())}
      ${section('Brand', false, `<div class="flex flex-col gap-2">${brandRows}</div>${brandMore}`)}
      ${section('Availability', true, checkRow('stock','1','In stock — ships now'))}
    </div>`;
  }

  // ───────── Wire a panel's controls ─────────
  function wirePanel(root) {
    root.querySelectorAll('.filter-toggle').forEach(btn => btn.onclick = () => {
      const sec = btn.closest('.filter-section'); sec.dataset.open = sec.dataset.open==='true' ? 'false' : 'true';
    });
    root.querySelectorAll('[data-f="cat"]').forEach(cb => cb.onchange = () => { cb.checked ? S.cats.add(cb.value) : S.cats.delete(cb.value); applyAll(); });
    root.querySelectorAll('[data-f="brand"]').forEach(cb => cb.onchange = () => { cb.checked ? S.brands.add(cb.value) : S.brands.delete(cb.value); applyAll(); });
    root.querySelectorAll('[data-f="rating"]').forEach(rb => rb.onchange = () => { S.rating = +rb.value; applyAll(); });
    const stock = root.querySelector('[data-f="stock"]'); if (stock) stock.onchange = () => { S.stock = stock.checked; applyAll(); };
    const pmin = root.querySelector('[data-f="pmin"]'), pmax = root.querySelector('[data-f="pmax"]');
    const pminN = root.querySelector('[data-f="pminN"]'), pmaxN = root.querySelector('[data-f="pmaxN"]');
    if (pmin) {
      pmin.oninput = () => { S.pmin = Math.min(+pmin.value, S.pmax); syncPrice(); };
      pmax.oninput = () => { S.pmax = Math.max(+pmax.value, S.pmin); syncPrice(); };
      pmin.onchange = pmax.onchange = applyAll;
      pminN.onchange = () => { S.pmin = Math.min(Math.max(+pminN.value||ABS_MIN, ABS_MIN), S.pmax); applyAll(); };
      pmaxN.onchange = () => { S.pmax = Math.min(Math.max(+pmaxN.value||ABS_MAX, S.pmin), ABS_MAX); applyAll(); };
    }
    const more = root.querySelector('.brand-more');
    if (more) more.onclick = () => {
      const hidden = root.querySelector('.brand-extra.hidden');
      root.querySelectorAll('.brand-extra').forEach(e => e.classList.toggle('hidden', !hidden));
      more.textContent = hidden ? 'Show fewer' : `Show all ${brands.length} brands`;
    };
  }

  // ───────── Sync control values from state (both panels) ─────────
  function syncPrice() {
    document.querySelectorAll('.price-filter').forEach(pf => {
      pf.querySelector('[data-f="pmin"]').value = S.pmin;
      pf.querySelector('[data-f="pmax"]').value = S.pmax;
      pf.querySelector('[data-f="pminN"]').value = S.pmin>ABS_MIN ? S.pmin : '';
      pf.querySelector('[data-f="pmaxN"]').value = S.pmax<ABS_MAX ? S.pmax : '';
      pf.querySelector('.pf-min-read').textContent = fmtK(S.pmin);
      pf.querySelector('.pf-max-read').textContent = fmtK(S.pmax);
      const fill = pf.querySelector('.pf-fill');
      fill.style.left = ((S.pmin-ABS_MIN)/(ABS_MAX-ABS_MIN)*100)+'%';
      fill.style.right = (100-(S.pmax-ABS_MIN)/(ABS_MAX-ABS_MIN)*100)+'%';
    });
  }
  function syncControls() {
    document.querySelectorAll('[data-f="cat"]').forEach(cb => cb.checked = S.cats.has(cb.value));
    document.querySelectorAll('[data-f="brand"]').forEach(cb => cb.checked = S.brands.has(cb.value));
    document.querySelectorAll('[data-f="rating"]').forEach(rb => rb.checked = (+rb.value===S.rating));
    document.querySelectorAll('[data-f="stock"]').forEach(cb => cb.checked = S.stock);
    syncPrice();
  }

  // ───────── Filter + sort + render ─────────
  function filtered() {
    let list = SF.catalog.filter(p => {
      if (S.cats.size && !S.cats.has(p.cat)) return false;
      if (S.brands.size && !S.brands.has(p.brand)) return false;
      if (S.stock && p.stock===false) return false;
      if (S.rating>0 && (p.rating||0) < S.rating) return false;
      const price = p.sale ?? p.price;
      if (price==null) return !(S.pmin>ABS_MIN); // unpriced kept only while lower bound untouched
      if (price < S.pmin || price > S.pmax) return false;
      return true;
    });
    const pr = p => (p.sale ?? p.price);
    switch (S.sort) {
      case 'price-asc':  list.sort((a,b)=>(pr(a)??Infinity)-(pr(b)??Infinity)); break;
      case 'price-desc': list.sort((a,b)=>(pr(b)??-1)-(pr(a)??-1)); break;
      case 'name-asc':   list.sort((a,b)=>a.name.localeCompare(b.name)); break;
      case 'newest':     list.reverse(); break;
    }
    return list;
  }
  function chips() {
    const el = document.getElementById('chips'); const items = [];
    const chip = (label, on) => `<button class="sf-chip inline-flex h-7 cursor-pointer items-center gap-1.5 rounded-full bg-surface-sunken px-3 text-[12.5px] font-medium text-ink-2 hover:bg-zinc-200" data-clear="${on}">${label} ${svg('x','size-3 text-ink-3')}</button>`;
    S.cats.forEach(c => items.push(chip(c,'cat:'+c)));
    S.brands.forEach(b => items.push(chip(b,'brand:'+b)));
    if (S.stock) items.push(chip('In stock only','stock'));
    if (S.pmin>ABS_MIN || S.pmax<ABS_MAX) items.push(chip((S.pmin>ABS_MIN&&S.pmax<ABS_MAX)?`${fmtK(S.pmin)} – ${fmtK(S.pmax)}`:(S.pmin>ABS_MIN?`From ${fmtK(S.pmin)}`:`Up to ${fmtK(S.pmax)}`),'price'));
    if (S.rating>0) items.push(chip(`${S.rating}★ &amp; up`,'rating'));
    el.innerHTML = items.join('');
    el.querySelectorAll('.sf-chip').forEach(b => b.onclick = () => {
      const v = b.dataset.clear;
      if (v.startsWith('cat:')) S.cats.delete(v.slice(4));
      else if (v.startsWith('brand:')) S.brands.delete(v.slice(6));
      else if (v==='stock') S.stock=false;
      else if (v==='price') { S.pmin=ABS_MIN; S.pmax=ABS_MAX; }
      else if (v==='rating') S.rating=0;
      applyAll();
    });
  }
  function applyAll() {
    const list = filtered();
    document.getElementById('grid').innerHTML = list.map(p => C.productCard(p)).join('');
    C.wireCards(document.getElementById('grid'));
    document.getElementById('resultCount').textContent = list.length;
    document.getElementById('resultNoun').textContent = list.length===1?'product':'products';
    document.getElementById('empty').classList.toggle('hidden', list.length>0);
    document.getElementById('grid').classList.toggle('hidden', list.length===0);
    const cl = document.getElementById('clearInline'); cl.classList.toggle('hidden', !hasFilters());
    document.getElementById('mfDot').classList.toggle('hidden', !hasFilters());
    document.getElementById('drawerClearAll').classList.toggle('hidden', !hasFilters());
    chips();
    syncControls();
  }
  function clearAll() { S.cats.clear(); S.brands.clear(); S.pmin=ABS_MIN; S.pmax=ABS_MAX; S.rating=0; S.stock=false; applyAll(); }

  // Build panels
  document.getElementById('filters').innerHTML = panelHTML(true);
  document.getElementById('filtersMobile').innerHTML = `<div class="px-0">${panelHTML(true)}</div>`;
  wirePanel(document.getElementById('filters'));
  wirePanel(document.getElementById('filtersMobile'));

  document.getElementById('sortSel').onchange = e => { S.sort = e.target.value; applyAll(); };
  document.getElementById('clearInline').onclick = clearAll;
  document.getElementById('emptyClear').onclick = clearAll;
  document.getElementById('drawerClearAll').onclick = clearAll;

  // Mobile drawer
  const drawer = document.getElementById('mobileDrawer');
  const openDrawer = () => drawer.classList.remove('hidden');
  const closeDrawer = () => drawer.classList.add('hidden');
  document.getElementById('mobileFilterBtn').onclick = openDrawer;
  document.getElementById('drawerClose').onclick = closeDrawer;
  document.getElementById('drawerBackdrop').onclick = closeDrawer;
  document.getElementById('drawerApply').onclick = closeDrawer;

  applyAll();
})();
