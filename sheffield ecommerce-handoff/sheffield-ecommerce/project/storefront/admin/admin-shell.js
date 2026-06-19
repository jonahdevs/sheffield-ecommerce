// Sheffield Admin — shell chrome: heroicons, sidebar nav, top header, appearance toggle.
window.AdminShell = (function () {
  // Heroicons (outline, 1.5) — only the set the admin uses.
  const D = {
    home: '<path d="M2.25 12 11.2 3.05a1.13 1.13 0 0 1 1.6 0L21.75 12M4.5 9.75v10.5a.75.75 0 0 0 .75.75H9.75v-6h4.5v6h4.5a.75.75 0 0 0 .75-.75V9.75"/>',
    cube: '<path d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>',
    folder: '<path d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-.94-.94a2.25 2.25 0 0 0-1.59-.66H4.5A2.25 2.25 0 0 0 2.25 6.75v10.5A2.25 2.25 0 0 0 4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V9A2.25 2.25 0 0 0 19.5 6.75h-5.69a2.25 2.25 0 0 1-1.59-.66Z"/>',
    tag: '<path d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.1 18.1 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/><path d="M6 6h.008v.008H6V6Z"/>',
    'adjustments-horizontal': '<path d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 0H3.75m13.5 6H20.25m-3 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 0H3.75m6 6h10.5m-10.5 0a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 0H3.75"/>',
    hashtag: '<path d="M5.25 8.25h13.5m-13.5 7.5h13.5M9.563 3.75 7.5 20.25m9-16.5L14.437 20.25"/>',
    'receipt-percent': '<path d="M9 14.25 15 8.25m-6 0h.008v.008H9V8.25Zm6 6h.008v.008H15v-.008ZM3.75 5.25v15l2.25-1.5 2.25 1.5 2.25-1.5 2.25 1.5 2.25-1.5 2.25 1.5v-15l-2.25 1.5-2.25-1.5-2.25 1.5-2.25-1.5L6 6.75 3.75 5.25Z"/>',
    'document-text': '<path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm-1.5 12h6m-6 3h3.75M9 13.5h.008v.008H9V13.5Z"/>',
    'shopping-cart': '<path d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121 0 2.1-.747 2.4-1.83l1.03-3.737a.75.75 0 0 0-.722-.952H5.106M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>',
    'credit-card': '<path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>',
    users: '<path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.34 9.34 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.32 12.32 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>',
    envelope: '<path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>',
    star: '<path d="M11.48 3.5a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>',
    'shield-check': '<path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.96 11.96 0 0 1 3.598 6 12 12 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.249-8.25-3.285Z"/>',
    key: '<path d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H9v1.5H7.5v1.5H6v1.5H3.75a.75.75 0 0 1-.75-.75v-2.69c0-.2.079-.39.22-.53l6.69-6.69c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"/>',
    'map-pin': '<path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>',
    truck: '<path d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.9 17.9 0 0 0-3.213-9.193 2.06 2.06 0 0 0-1.692-.879H13.5m3.75 11.196h-6m0-11.196V14.25m0-9.876a1.125 1.125 0 0 0-1.125-1.125H4.125A1.125 1.125 0 0 0 3 4.5v9.75m10.5 0V4.875c0-.621-.504-1.125-1.125-1.125"/>',
    'building-office-2': '<path d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21a.75.75 0 0 1 .75.75V21"/>',
    'cog-6-tooth': '<path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.7 7.7 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.5 6.5 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.5 6.5 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a7 7 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>',
    bell: '<path d="M14.857 17.082a23.85 23.85 0 0 0 5.454-1.31A8.97 8.97 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.97 8.97 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24 24 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>',
    sun: '<path d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>',
    moon: '<path d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z"/>',
    'computer-desktop': '<path d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>',
    'chevron-down': '<path d="m19.5 8.25-7.5 7.5-7.5-7.5"/>',
    'chevron-right': '<path d="m8.25 4.5 7.5 7.5-7.5 7.5"/>',
    'magnifying-glass': '<path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>',
    'bars-3': '<path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>',
    banknotes: '<path d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>',
    'shopping-bag': '<path d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>',
    user: '<path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.93 17.93 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>',
    bolt: '<path d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z"/>',
    cube4: '<path d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>',
    'arrow-trending-up': '<path d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/>',
    'arrow-trending-down': '<path d="M2.25 6 9 12.75l4.286-4.286a11.95 11.95 0 0 1 4.534 3.954L21 14.5m0 0v-4.5m0 4.5h-4.5"/>',
    'presentation-chart-line': '<path d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h12a2.25 2.25 0 0 0 2.25-2.25V3m-16.5 0h16.5m-16.5 0h-1.5m18 0h1.5m-16.5 16.5L12 16.5l4.5 4.5M9 12.75l2.25 2.25L15 9.75"/>',
    'chart-bar': '<path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>',
    'arrow-right': '<path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>',
    'calendar-days': '<path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z"/>',
    'arrow-top-right-on-square': '<path d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>',
    'arrow-right-start-on-rectangle': '<path d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/>',
    cog: '<path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.7 7.7 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.5 6.5 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.5 6.5 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a7 7 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>',
  };
  const icon = (name, cls) => `<svg class="${cls || 'size-5'}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">${D[name] || ''}</svg>`;

  // Sidebar nav config (mirrors partials/admin/sidebar.blade.php)
  const NAV = [
    { heading: 'Overview', items: [{ icon: 'home', label: 'Dashboard', current: true }] },
    { heading: 'Catalog', items: [
      { icon: 'cube', label: 'Products' },
      { icon: 'folder', label: 'Categories', children: ['All categories', 'Placements'] },
      { icon: 'tag', label: 'Brands' },
      { icon: 'adjustments-horizontal', label: 'Attributes' },
      { icon: 'hashtag', label: 'Tags' },
      { icon: 'receipt-percent', label: 'Tax classes' },
    ] },
    { heading: 'Sales', items: [
      { icon: 'document-text', label: 'Quotations' },
      { icon: 'shopping-cart', label: 'Orders', children: ['All orders', 'SAP sync'] },
      { icon: 'credit-card', label: 'Payments' },
    ] },
    { heading: 'Customers', items: [
      { icon: 'users', label: 'All customers' },
      { icon: 'envelope', label: 'Subscribers' },
      { icon: 'star', label: 'Reviews' },
    ] },
    { heading: 'Access', items: [
      { icon: 'shield-check', label: 'Roles' },
      { icon: 'key', label: 'Permissions' },
    ] },
    { heading: 'Logistics', items: [
      { icon: 'map-pin', label: 'Delivery', children: ['Zones', 'Promotions'] },
      { icon: 'truck', label: 'Shipping', children: ['Methods', 'Carriers'] },
      { icon: 'building-office-2', label: 'Locations', children: ['Warehouses', 'Showrooms'] },
    ] },
    { heading: 'System', items: [{ icon: 'cog-6-tooth', label: 'Settings' }] },
  ];

  function navItem(it) {
    const base = 'group flex items-center gap-2.5 rounded-lg px-2.5 py-1.5 text-sm transition-colors';
    if (it.children) {
      const open = it.current ? 'true' : 'false';
      return `<div class="nav-group" data-open="${open}">
        <button type="button" class="nav-group-btn ${base} w-full text-white/70 hover:bg-white/10 hover:text-white">
          <span class="shrink-0 text-white/45">${icon(it.icon, 'size-5')}</span>
          <span class="flex-1 text-left">${it.label}</span>
          <span class="nav-caret text-white/40 transition-transform">${icon('chevron-down', 'size-4')}</span>
        </button>
        <div class="nav-children mt-0.5 ml-4 flex flex-col gap-0.5 border-l border-white/15 pl-3">
          ${it.children.map(c => `<a href="#" class="rounded-lg px-2.5 py-1.5 text-sm text-white/55 transition-colors hover:bg-white/10 hover:text-white">${c}</a>`).join('')}
        </div>
      </div>`;
    }
    const cur = it.current
      ? 'bg-white text-zinc-900 shadow-sm'
      : 'text-white/70 hover:bg-white/10 hover:text-white';
    const curStyle = '';
    const iconCls = it.current ? 'text-[hsl(354,68%,45%)]' : 'text-white/45 group-hover:text-white/70';
    return `<a href="#"${curStyle} class="${base} ${cur}"><span class="shrink-0 ${iconCls}">${icon(it.icon, 'size-5')}</span><span>${it.label}</span></a>`;
  }

  function sidebar() {
    return `
    <div class="flex h-full flex-col">
      <div class="flex h-16 shrink-0 items-center gap-2.5 border-b border-white/10 px-4">
        <span class="flex size-8 items-center justify-center rounded-md bg-white shadow-sm ring-1 ring-white/20">
          <img src="favicon.png" alt="" class="size-6 object-contain"/>
        </span>
        <span class="text-sm font-semibold text-white">Sheffield Africa</span>
      </div>
      <nav class="scrollbar-thin flex-1 overflow-y-auto px-3 pb-6">
        ${NAV.map(g => `
          <div class="mt-4 first:mt-1">
            <div class="px-2.5 pb-1 text-[11px] font-semibold uppercase tracking-wider text-white/40">${g.heading}</div>
            <div class="flex flex-col gap-0.5">${g.items.map(navItem).join('')}</div>
          </div>`).join('')}
      </nav>
    </div>`;
  }

  function header() {
    return `
    <button id="sidebarToggle" class="inline-flex size-9 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 lg:hidden dark:text-zinc-400 dark:hover:bg-zinc-800" aria-label="Menu">${icon('bars-3', 'size-5')}</button>
    <div class="hidden min-w-0 items-center gap-2 text-sm lg:flex">
      <span class="text-zinc-400 dark:text-zinc-500">${icon('home', 'size-4')}</span>
      <span class="text-zinc-400 dark:text-zinc-600">${icon('chevron-right', 'size-3.5')}</span>
      <span class="font-medium text-zinc-700 dark:text-zinc-200">Dashboard</span>
    </div>
    <div class="flex-1"></div>
    <button class="relative inline-flex size-9 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800" aria-label="Notifications">
      ${icon('bell', 'size-5')}
      <span class="absolute right-1.5 top-1.5 flex size-2 rounded-full bg-rose-500 ring-2 ring-white dark:ring-zinc-900"></span>
    </button>
    <button id="appearanceToggle" class="inline-flex size-9 items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800" aria-label="Appearance">
      <span data-appear="light">${icon('sun', 'size-5')}</span>
      <span data-appear="dark" class="hidden">${icon('moon', 'size-5')}</span>
    </button>
    <div class="ml-1 flex items-center gap-2.5 border-l border-zinc-200 pl-3 dark:border-zinc-700">
      <span class="flex size-8 items-center justify-center rounded-full bg-zinc-800 text-xs font-semibold text-white dark:bg-zinc-700">AK</span>
      <span class="hidden text-zinc-400 sm:inline dark:text-zinc-500">${icon('chevron-down', 'size-4')}</span>
    </div>`;
  }

  function wire() {
    // collapsible nav groups
    document.querySelectorAll('.nav-group-btn').forEach(btn => btn.onclick = () => {
      const g = btn.closest('.nav-group');
      g.dataset.open = g.dataset.open === 'true' ? 'false' : 'true';
    });
    // mobile sidebar
    const sb = document.getElementById('adminSidebar'), bd = document.getElementById('sidebarBackdrop');
    const toggle = document.getElementById('sidebarToggle');
    if (toggle) toggle.onclick = () => { sb.classList.toggle('-translate-x-full'); bd.classList.toggle('hidden'); };
    if (bd) bd.onclick = () => { sb.classList.add('-translate-x-full'); bd.classList.add('hidden'); };
    // appearance
    const at = document.getElementById('appearanceToggle');
    if (at) at.onclick = () => {
      const dark = document.documentElement.classList.toggle('dark');
      at.querySelector('[data-appear="light"]').classList.toggle('hidden', dark);
      at.querySelector('[data-appear="dark"]').classList.toggle('hidden', !dark);
      if (window.retheveAdminCharts) window.retheveAdminCharts();
    };
  }

  function mount() {
    document.getElementById('adminSidebar').innerHTML = sidebar();
    document.getElementById('adminHeader').innerHTML = header();
    wire();
  }

  return { icon, mount };
})();
