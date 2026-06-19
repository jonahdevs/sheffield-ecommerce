// Sheffield Admin — dashboard data + ApexCharts/Leaflet renderers.
// Mirrors the live Livewire dashboard (chartData() + Alpine dashboardCharts).
(function () {
  const money = v => 'KES ' + Number(v || 0).toLocaleString();
  window.adminMoney = money;

  // ── Seeded RNG so the demo data is stable across reloads ──
  let seed = 20260619;
  const rnd = () => { seed = (seed * 1664525 + 1013904223) % 4294967296; return seed / 4294967296; };
  const between = (a, b) => a + (b - a) * rnd();

  // ── 30-day daily series ending today (Jun 19, 2026) ──
  const DAYS = 30;
  const labels = [], revenue = [], orders = [], customers = [];
  const end = new Date(2026, 5, 19);
  const MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  for (let i = DAYS - 1; i >= 0; i--) {
    const d = new Date(end); d.setDate(end.getDate() - i);
    labels.push(MONTHS[d.getMonth()] + ' ' + d.getDate());
    const weekend = d.getDay() === 0 || d.getDay() === 6;
    const base = weekend ? between(180000, 420000) : between(420000, 1150000);
    revenue.push(Math.round(base / 1000) * 1000);
    orders.push(Math.max(1, Math.round(between(weekend ? 1 : 3, weekend ? 5 : 9))));
    customers.push(Math.round(between(0, 4)));
  }
  const sum = a => a.reduce((s, x) => s + x, 0);

  const DATA = {
    metrics: {
      revenue: sum(revenue),
      revenueTrend: 12.3,
      orders: sum(orders),
      ordersTrend: 8.1,
      customersTotal: 1284,
      customersTrend: 6.4,
      productsActive: 487,
      needAttention: 14,
    },
    revenue: { labels, revenue, orders, customers },
    funnel: { labels: ['Requested', 'Sent', 'Approved', 'Ordered', 'Paid'], data: [86, 64, 41, 28, 24] },
    channel: { labels: ['M-Pesa / Mobile', 'Card', 'Bank Transfer', 'Airtel Money'], data: [7480000, 5260000, 4910000, 760000] },
    status: { labels: ['Processing', 'Out for delivery', 'Completed', 'Pending', 'Cancelled'], data: [38, 19, 61, 16, 8] },
    categories: { labels: ['Refrigeration', 'Ovens', 'Meat Processors', 'Coffee Machines', 'Dishwashers'], data: [142, 118, 96, 74, 58] },
    topProducts: {
      labels: ['Combi Oven iCombi', 'Espresso Classe 5', 'Blast Chiller 5T', 'Undercounter LF322', 'Meat Slicer 300MM', 'Upright Freezer'],
      data: [100, 82, 71, 60, 54, 41],
      units: [34, 28, 24, 20, 18, 14],
    },
    satisfaction: { total: 318, average: 4.6, distribution: [214, 64, 22, 11, 7] },
    countyMap: {
      Nairobi: 8200000, Kiambu: 2150000, Mombasa: 1980000, Nakuru: 1240000, Kisumu: 980000,
      'Uasin Gishu': 760000, Machakos: 640000, Kajiado: 580000, Nyeri: 410000, Meru: 360000,
      Kilifi: 320000, Kericho: 260000, Bungoma: 210000, Kakamega: 180000, Laikipia: 150000,
    },
    recentOrders: [
      { no: 'SHF-2026-0142', who: 'Artcaffé Group', when: '12 min ago', total: 612000, status: ['Processing', 'blue'] },
      { no: 'SHF-2026-0141', who: 'Hilton Garden Inn', when: '1 hr ago', total: 1840000, status: ['Out for delivery', 'amber'] },
      { no: 'SHF-2026-0140', who: 'Java House', when: '3 hr ago', total: 389000, status: ['Completed', 'green'] },
      { no: 'SHF-2026-0139', who: 'Tamarind Group', when: '5 hr ago', total: 247000, status: ['Completed', 'green'] },
      { no: 'SHF-2026-0138', who: 'Kempinski Villa Rosa', when: 'Yesterday', total: 489000, status: ['Cancelled', 'red'] },
    ],
    activity: [
      { icon: 'banknotes', tone: 'green', label: 'Payment received', target: 'Order SHF-2026-0142 · M-Pesa', when: '12 min ago' },
      { icon: 'shopping-bag', tone: 'blue', label: 'Order placed', target: 'Order SHF-2026-0142 · Artcaffé Group', when: '12 min ago' },
      { icon: 'document-text', tone: 'amber', label: 'Quote sent for approval', target: 'Quote QTN-2026-0061 · Hilton', when: '48 min ago' },
      { icon: 'star', tone: 'green', label: 'Review approved', target: 'Combi Oven iCombi Pro · ★★★★★', when: '2 hr ago' },
      { icon: 'shopping-bag', tone: 'green', label: 'Order completed', target: 'Order SHF-2026-0140 · Java House', when: '3 hr ago' },
      { icon: 'user', tone: 'blue', label: 'Customer registered', target: 'procurement@serenahotels.com', when: '4 hr ago' },
    ],
    lowStock: [
      { name: 'Meat Slicer Ø 300MM', sku: 'IMG/FPR/00046', qty: 2, level: ['Low', 'amber'] },
      { name: 'Espresso Machine Classe 5', sku: 'IMG/COF/00033', qty: 1, level: ['Low', 'amber'] },
      { name: 'Blast Chiller 5 Trays', sku: 'IMG/REF/00210', qty: 0, level: ['Out of stock', 'red'] },
      { name: 'Potato Peeler 20 KG', sku: 'IMG/FPR/00008', qty: 3, level: ['Low', 'amber'] },
      { name: 'Curved-Glass Cake Display', sku: 'IMG/CDS/00094', qty: 0, level: ['Out of stock', 'red'] },
      { name: 'Bean-to-Cup C11', sku: 'IMG/COF/00041', qty: 2, level: ['Low', 'amber'] },
    ],
  };
  window.ADMIN_DATA = DATA;

  // ─────────────────────── Charts ───────────────────────
  const PALETTE = ['#0d9488', '#2563eb', '#f59e0b', '#7c3aed', '#64748b', '#dc2626'];
  const charts = {};
  let revType = 'area';
  const axisColor = () => document.documentElement.classList.contains('dark') ? '#a1a1aa' : '#71717a';

  function revSeries() {
    return [
      { name: 'Revenue', type: revType, data: DATA.revenue.revenue },
      { name: 'Orders', type: 'area', data: DATA.revenue.orders },
    ];
  }
  function revFill() {
    return revType === 'bar'
      ? { type: 'solid', opacity: [0.9, 0.2] }
      : { type: 'gradient', gradient: { opacityFrom: 0.35, opacityTo: 0.05 } };
  }
  function revStroke() { return { curve: 'smooth', width: revType === 'bar' ? [0, 2] : 2 }; }

  function renderAll() {
    // Revenue & orders (combo area/bar)
    charts.revenue = new ApexCharts(document.querySelector('#c-revenue'), {
      chart: { type: 'area', height: 320, fontFamily: 'inherit', toolbar: { show: false } },
      series: revSeries(),
      colors: ['#0d9488', '#7c3aed'],
      plotOptions: { bar: { columnWidth: '55%', borderRadius: 3 } },
      stroke: revStroke(), fill: revFill(),
      dataLabels: { enabled: false },
      grid: { borderColor: document.documentElement.classList.contains('dark') ? '#3f3f46' : '#f1f1f4', strokeDashArray: 4 },
      xaxis: { categories: DATA.revenue.labels, tickAmount: 8, labels: { rotate: 0, hideOverlappingLabels: true, style: { colors: axisColor() } } },
      yaxis: [
        { seriesName: 'Revenue', labels: { formatter: v => money(Math.round(v)), style: { colors: axisColor() } } },
        { seriesName: 'Orders', opposite: true, labels: { formatter: v => Math.round(v), style: { colors: axisColor() } } },
      ],
      tooltip: { y: { formatter: (v, o) => o.seriesIndex === 0 ? money(v) : v } },
      legend: { position: 'top', horizontalAlign: 'right', labels: { colors: axisColor() } },
    });
    charts.revenue.render();

    // Quotes → orders funnel
    charts.funnel = new ApexCharts(document.querySelector('#c-funnel'), {
      chart: { type: 'bar', height: 320, fontFamily: 'inherit', toolbar: { show: false } },
      series: [{ name: 'Count', data: DATA.funnel.data }],
      plotOptions: { bar: { horizontal: true, distributed: true, barHeight: '70%', isFunnel: true } },
      colors: PALETTE,
      xaxis: { categories: DATA.funnel.labels },
      legend: { show: false },
      dataLabels: { enabled: true, formatter: (val, o) => o.w.globals.labels[o.dataPointIndex] + ': ' + val },
    });
    charts.funnel.render();

    polarArea('#c-channel', DATA.channel, true);
    polarArea('#c-status', DATA.status, false);
    radialBar('#c-topProducts', DATA.topProducts);
    bar('#c-categories', DATA.categories);

    // Sparklines
    sparkline('#s-revenue', DATA.revenue.revenue, '#10b981');
    sparkline('#s-orders', DATA.revenue.orders, '#3b82f6');
    sparkline('#s-customers', DATA.revenue.customers, '#8b5cf6');

    // Satisfaction donut
    charts.satisfaction = new ApexCharts(document.querySelector('#c-satisfaction'), {
      chart: { type: 'donut', height: 220, fontFamily: 'inherit' },
      series: DATA.satisfaction.total > 0 ? DATA.satisfaction.distribution : [1],
      labels: ['5★', '4★', '3★', '2★', '1★'],
      colors: ['#10b981', '#3b82f6', '#f59e0b', '#f97316', '#f43f5e'],
      plotOptions: { pie: { donut: { size: '72%' } } },
      legend: { position: 'bottom', labels: { colors: axisColor() } },
      dataLabels: { enabled: false },
      stroke: { colors: [document.documentElement.classList.contains('dark') ? '#27272a' : '#fff'] },
    });
    charts.satisfaction.render();

    initCountyMap();
  }

  function polarArea(sel, d, isMoney) {
    const c = new ApexCharts(document.querySelector(sel), {
      chart: { type: 'polarArea', height: 300, fontFamily: 'inherit', toolbar: { show: false } },
      series: d.data, labels: d.labels, colors: PALETTE,
      stroke: { colors: [document.documentElement.classList.contains('dark') ? '#27272a' : '#fff'], width: 2 },
      fill: { opacity: 0.85 },
      legend: { position: 'bottom', labels: { colors: axisColor() } },
      yaxis: { show: false },
      dataLabels: { enabled: false },
      tooltip: isMoney ? { y: { formatter: v => money(v) } } : {},
    });
    c.render(); charts[sel] = c;
  }
  function radialBar(sel, d) {
    const units = d.units || [];
    const c = new ApexCharts(document.querySelector(sel), {
      chart: { type: 'radialBar', height: 300, fontFamily: 'inherit', toolbar: { show: false } },
      series: d.data, labels: d.labels, colors: PALETTE,
      plotOptions: { radialBar: {
        offsetY: 0, startAngle: 0, endAngle: 270,
        hollow: { margin: 5, size: '30%', background: 'transparent' },
        track: { background: document.documentElement.classList.contains('dark') ? '#3f3f46' : '#f4f4f5', margin: 4 },
        dataLabels: { name: { show: false }, value: { show: false } },
        barLabels: { enabled: true, useSeriesColors: true, offsetX: -8, fontSize: '12px',
          formatter: (name, opts) => name + ':  ' + (units[opts.seriesIndex] ?? '') + ' units' },
      } },
      legend: { show: false },
    });
    c.render(); charts[sel] = c;
  }
  function bar(sel, d) {
    const c = new ApexCharts(document.querySelector(sel), {
      chart: { type: 'bar', height: 300, fontFamily: 'inherit', toolbar: { show: false } },
      series: [{ name: 'Units', data: d.data }],
      plotOptions: { bar: { horizontal: true, borderRadius: 4, barHeight: '60%' } },
      colors: ['#2563eb'],
      grid: { borderColor: document.documentElement.classList.contains('dark') ? '#3f3f46' : '#f1f1f4', strokeDashArray: 4 },
      xaxis: { categories: d.labels, labels: { style: { colors: axisColor() } } },
      yaxis: { labels: { style: { colors: axisColor() } } },
      dataLabels: { enabled: false },
    });
    c.render(); charts[sel] = c;
  }
  function sparkline(sel, data, color) {
    const c = new ApexCharts(document.querySelector(sel), {
      chart: { type: 'area', height: 56, sparkline: { enabled: true }, fontFamily: 'inherit', animations: { enabled: false } },
      series: [{ data }], colors: [color],
      stroke: { curve: 'smooth', width: 1.5 },
      fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.8, opacityTo: 0.3, stops: [0, 100] } },
      tooltip: { enabled: false },
    });
    c.render(); charts[sel] = c;
  }

  // County choropleth
  let lmap, geoLayer, countyData = DATA.countyMap, countyMax = Math.max(1, ...Object.values(DATA.countyMap));
  function countyColor(v) {
    if (!v) return document.documentElement.classList.contains('dark') ? '#27272a' : '#eef2f6';
    const t = v / countyMax;
    if (t > 0.66) return '#0f766e';
    if (t > 0.33) return '#14b8a6';
    return '#5eead4';
  }
  function countyStyle(f) {
    return { fillColor: countyColor(countyData[f.properties.shapeName] || 0), weight: 1, color: document.documentElement.classList.contains('dark') ? '#18181b' : '#ffffff', fillOpacity: 0.85 };
  }
  function countyTooltip(name) { return `<strong>${name}</strong><br>${money(countyData[name] || 0)}`; }
  async function initCountyMap() {
    const el = document.querySelector('#c-countyMap');
    if (typeof L === 'undefined' || !el) return;
    lmap = L.map(el, { attributionControl: false, zoomControl: true, scrollWheelZoom: false, preferCanvas: true, renderer: L.canvas() });
    try {
      const geo = await fetch('kenya-counties.geojson').then(r => r.json());
      geoLayer = L.geoJSON(geo, {
        style: countyStyle,
        onEachFeature: (f, layer) => {
          layer.bindTooltip(countyTooltip(f.properties.shapeName), { sticky: true });
          layer.on({
            mouseover: e => e.target.setStyle({ weight: 2, fillOpacity: 1 }),
            mouseout: e => geoLayer.resetStyle(e.target),
          });
        },
      }).addTo(lmap);
      const bounds = geoLayer.getBounds();
      lmap.fitBounds(bounds, { padding: [8, 8] });
      lmap.setMaxBounds(bounds.pad(0.3));
      lmap.setMinZoom(lmap.getZoom() - 1);
    } catch (e) { /* leave blank if geojson fails */ }
  }

  // Revenue chart type toggle (area / bar)
  window.toggleRevenue = function (type) {
    revType = type;
    charts.revenue?.updateOptions({ series: revSeries(), fill: revFill(), stroke: revStroke() });
  };

  // Re-theme charts on light/dark switch
  window.retheveAdminCharts = function () {
    Object.values(charts).forEach(c => { try { c.destroy(); } catch (e) {} });
    if (lmap) { try { lmap.remove(); } catch (e) {} lmap = null; }
    renderAll();
  };

  window.renderAdminDashboard = renderAll;
})();
