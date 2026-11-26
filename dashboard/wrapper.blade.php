@php
    $dracoDefaults = [
        'panel_name' => 'Draco', 'logo_url' => '', 'bg_url' => '', 'bg_blur' => 16,
        'card_opacity' => 78, 'bg_dim' => 55, 'ambient_glow' => 1,
        'accent_primary' => '#7c3aed', 'accent_secondary' => '#3b82f6',
        'bg_color' => '#090b16', 'sidebar_color' => '#0d1021',
        'card_color' => '#14182e', 'console_color' => '#070914',
        'text_color' => '#f3f4f6', 'muted_color' => '#94a3b8',
        'login_layout' => 1, 'login_bg_url' => '',
        'banner_url' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
        'server_grid' => 1, 'announcement_enabled' => 1,
        'announcement_text' => 'Welcome to Draco Panel — High Performance Game Hosting!',
        'announcement_color' => '#f59e0b', 'discord_url' => '', 'support_url' => '',
        'footer_text' => '© 2026 Draco Panel', 'footer_about' => '',
        'footer_privacy' => '', 'footer_terms' => '', 'sync_admin' => 1, 'custom_css' => '',
    ];
    $draco = $dracoDefaults;
    try {
        $raw = app(\Pterodactyl\Contracts\Repository\SettingsRepositoryInterface::class)->get('draco::config');
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) { $draco = array_merge($dracoDefaults, $decoded); }
        }
    } catch (\Throwable $e) {}

    $toRgb = function ($hex) {
        $h = ltrim((string)$hex, '#');
        if (strlen($h) !== 6) return '20, 24, 46';
        return hexdec(substr($h,0,2)).', '.hexdec(substr($h,2,2)).', '.hexdec(substr($h,4,2));
    };

    $opacityDec = round(max(20, min(100, (int)$draco['card_opacity'])) / 100, 2);
    $dimDec = round(max(0, min(95, (int)$draco['bg_dim'])) / 100, 2);
    $blurPx = max(0, min(30, (int)$draco['bg_blur']));
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style id="draco-dynamic-vars">
:root {
    --draco-bg: {{ $draco['bg_color'] }};
    --draco-accent: {{ $draco['accent_primary'] }};
    --draco-accent-2: {{ $draco['accent_secondary'] }};
    --draco-accent-rgb: {{ $toRgb($draco['accent_primary']) }};
    --draco-accent2-rgb: {{ $toRgb($draco['accent_secondary']) }};
    --draco-sidebar-rgb: {{ $toRgb($draco['sidebar_color']) }};
    --draco-card-rgb: {{ $toRgb($draco['card_color']) }};
    --draco-console-rgb: {{ $toRgb($draco['console_color']) }};
    --draco-text: {{ $draco['text_color'] }};
    --draco-muted: {{ $draco['muted_color'] }};
    --draco-blur: {{ $blurPx }}px;
    --draco-opacity: {{ $opacityDec }};
    --draco-dim: {{ $dimDec }};
    --draco-ann-color: {{ $draco['announcement_color'] }};
    --draco-bg-url: {!! $draco['bg_url'] ? "url('" . e($draco['bg_url']) . "')" : 'none' !!};
    --draco-login-bg-url: {!! ($draco['login_bg_url'] ?: $draco['bg_url'] ?: $draco['banner_url']) ? "url('" . e($draco['login_bg_url'] ?: $draco['bg_url'] ?: $draco['banner_url']) . "')" : 'none' !!};
    --draco-banner-url: {!! $draco['banner_url'] ? "url('" . e($draco['banner_url']) . "')" : 'none' !!};
}
{!! $draco['custom_css'] !!}
</style>

<div class="draco-bg-layer" aria-hidden="true"></div>
@if($draco['ambient_glow'])
<div class="draco-glow-layer" aria-hidden="true"></div>
@endif
<div class="draco-dim-layer" aria-hidden="true"></div>

<script>
window.DRACO_CONFIG = @json($draco);

(function () {
    const CFG = window.DRACO_CONFIG || {};
    let scheduled = false;
    let lastSidebarSig = '';
    let mobileOpen = false;

    const ICONS = {
        dashboard: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>',
        console: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>',
        files: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>',
        databases: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>',
        backups: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>',
        network: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
        schedules: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        users: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>',
        startup: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>',
        settings: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
        activity: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
        addon: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>',
        egg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>',
        account: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        admin: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        logout: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>',
        menu: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
    };

    function getIcon(href, text) {
        const s = (href + ' ' + text).toLowerCase();
        if (s.includes('/files')) return ICONS.files;
        if (s.includes('/databases')) return ICONS.databases;
        if (s.includes('/backups')) return ICONS.backups;
        if (s.includes('/network')) return ICONS.network;
        if (s.includes('/schedules')) return ICONS.schedules;
        if (s.includes('/users')) return ICONS.users;
        if (s.includes('/startup')) return ICONS.startup;
        if (s.includes('/settings')) return ICONS.settings;
        if (s.includes('/activity')) return ICONS.activity;
        if (s.includes('egg') || s.includes('version')) return ICONS.egg;
        if (s.includes('plugin') || s.includes('mod') || s.includes('addon') || s.includes('trash')) return ICONS.addon;
        if (href === '/' || s.includes('dashboard')) return ICONS.dashboard;
        if (s.includes('/account')) return ICONS.account;
        if (s.includes('/admin')) return ICONS.admin;
        return ICONS.console;
    }

    function getCategory(href, text) {
        const s = (href + ' ' + text).toLowerCase();
        if (s.includes('/files') || s.includes('/databases') || s.includes('/backups') || s.includes('/network')) return 'MANAGEMENT';
        if (s.includes('/schedules') || s.includes('/users') || s.includes('/startup')) return 'CONFIGURATION';
        if (s.includes('/settings') || s.includes('/activity') || s.includes('console') || /^\/server\/[^/]+\/?$/.test(href)) return 'GENERAL';
        return 'ADDONS';
    }

    function ensureShell() {
        if (!document.getElementById('draco-backdrop')) {
            const bd = document.createElement('div');
            bd.id = 'draco-backdrop';
            bd.addEventListener('click', () => setMobileMenu(false));
            document.body.appendChild(bd);
        }
        if (!document.getElementById('draco-sidebar')) {
            const sb = document.createElement('aside');
            sb.id = 'draco-sidebar';
            document.body.appendChild(sb);
        }
        if (!document.getElementById('draco-topbar')) {
            const tb = document.createElement('header');
            tb.id = 'draco-topbar';
            document.body.appendChild(tb);
        }
        if (!document.getElementById('draco-announcement') && CFG.announcement_enabled && CFG.announcement_text) {
            const ann = document.createElement('div');
            ann.id = 'draco-announcement';
            ann.innerHTML = `<span class="draco-ann-dot"></span><span></span>`;
            ann.querySelector('span:last-child').textContent = CFG.announcement_text;
            document.body.appendChild(ann);
        }
        if (!document.getElementById('draco-footer') && (CFG.footer_text || CFG.footer_about || CFG.footer_privacy || CFG.footer_terms)) {
            const ft = document.createElement('footer');
            ft.id = 'draco-footer';
            const links = [];
            if (CFG.footer_about) links.push(`<a href="${CFG.footer_about}" target="_blank" rel="noreferrer">About</a>`);
            if (CFG.footer_privacy) links.push(`<a href="${CFG.footer_privacy}" target="_blank" rel="noreferrer">Privacy Policy</a>`);
            if (CFG.footer_terms) links.push(`<a href="${CFG.footer_terms}" target="_blank" rel="noreferrer">Terms</a>`);
            ft.innerHTML = `<span>${CFG.footer_text || ''}</span><div class="draco-footer-links">${links.join('')}</div>`;
            document.body.appendChild(ft);
        }
    }

    function setMobileMenu(open) {
        mobileOpen = open;
        document.documentElement.classList.toggle('draco-mobile-open', open);
    }

    function findRealButtons(app) {
        const res = { start: null, restart: null, stop: null };
        app.querySelectorAll('button').forEach(btn => {
            const t = (btn.textContent || '').trim().toLowerCase();
            if (t === 'start') res.start = btn;
            else if (t === 'restart') res.restart = btn;
            else if (t === 'stop' || t === 'kill') res.stop = btn;
        });
        return res;
    }

    function detectServerMeta(app, serverId) {
        const key = 'draco_srv_' + serverId;
        let cached = {};
        try { cached = JSON.parse(sessionStorage.getItem(key) || '{}'); } catch (e) {}

        const h1 = app.querySelector('h1');
        if (h1 && h1.textContent.trim().length > 1) {
            cached.name = h1.textContent.trim();
        }
        const textBlocks = app.querySelectorAll('p, span, code');
        for (let i = 0; i < textBlocks.length; i++) {
            const txt = (textBlocks[i].textContent || '').trim();
            if (/^([a-zA-Z0-9.-]+|\d{1,3}(?:\.\d{1,3}){3}):\d{2,5}$/.test(txt)) {
                cached.ip = txt;
                break;
            }
        }
        try { sessionStorage.setItem(key, JSON.stringify(cached)); } catch (e) {}
        return { name: cached.name || ('Server ' + serverId), ip: cached.ip || '' };
    }

    function classifySurface(bg) {
        if (!bg || bg === 'transparent' || bg === 'rgba(0, 0, 0, 0)') return null;
        const m = bg.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?/);
        if (!m) return null;
        const r = +m[1], g = +m[2], b = +m[3], a = m[4] === undefined ? 1 : +m[4];
        if (a < 0.7) return null;

        if (window.location.pathname.startsWith('/auth') && r > 235 && g > 235 && b > 235) {
            return 'login-card';
        }
        const isNeutralDark =
            r >= 14 && r <= 86 &&
            g >= 20 && g <= 96 &&
            b >= 26 && b <= 116 &&
            (b - r) >= -2 && (b - r) <= 38 &&
            Math.abs(g - r) <= 24;
        if (!isNeutralDark) return null;
        return (r + g + b) < 115 ? 'panel-deep' : 'panel-card';
    }

    function buildShellUI(app) {
        const path = window.location.pathname;
        const isAuth = path.startsWith('/auth');
        document.documentElement.classList.toggle('draco-auth-page', isAuth);
        document.documentElement.setAttribute('data-draco-login-layout', String(CFG.login_layout || 1));

        if (isAuth) {
            document.documentElement.classList.remove('draco-shell-active');
            ['draco-sidebar', 'draco-topbar', 'draco-announcement', 'draco-footer', 'draco-backdrop'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
            // Inject split artwork for Login Layout 2 & 3
            if ((CFG.login_layout == 2 || CFG.login_layout == 3) && !document.getElementById('draco-login-art')) {
                const art = document.createElement('div');
                art.id = 'draco-login-art';
                art.innerHTML = `<div class="draco-login-art-badge">${CFG.panel_name || 'Draco'}</div>`;
                document.body.appendChild(art);
            }
            return;
        }

        const oldArt = document.getElementById('draco-login-art');
        if (oldArt) oldArt.remove();

        ensureShell();
        document.documentElement.classList.add('draco-shell-active');
        ['draco-sidebar', 'draco-topbar', 'draco-footer'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = '';
        });
        const annEl = document.getElementById('draco-announcement');
        if (annEl) annEl.style.display = (CFG.announcement_enabled && CFG.announcement_text) ? 'flex' : 'none';

        // Tag original Pterodactyl navbar & subnav so CSS keeps them mounted off-screen
        const logo = document.getElementById('logo');
        let realTopbar = null;
        if (logo && logo.parentElement && logo.parentElement.parentElement) {
            realTopbar = logo.parentElement.parentElement;
            realTopbar.setAttribute('data-draco-native', 'topbar');
        }

        const subAnchor = app.querySelector('a[href$="/files"], a[href$="/startup"], a[href$="/settings"], a[href$="/databases"], a[href="/account/api"], a[href="/account/ssh"]');
        let realSubnav = null;
        let realLinks = [];
        if (subAnchor && subAnchor.parentElement && subAnchor.parentElement.parentElement) {
            realSubnav = subAnchor.parentElement.parentElement;
            realSubnav.setAttribute('data-draco-native', 'subnav');
            realLinks = Array.from(subAnchor.parentElement.querySelectorAll(':scope > a'));
        }

        const adminAnchor = realTopbar ? realTopbar.querySelector('a[href="/admin"]') : null;
        const accountAnchor = realTopbar ? realTopbar.querySelector('a[href="/account"]') : null;
        const logoutBtn = realTopbar ? Array.from(realTopbar.querySelectorAll('button')).pop() : null;

        const serverMatch = path.match(/^\/server\/([^/]+)/);
        const serverId = serverMatch ? serverMatch[1] : null;
        const serverMeta = serverId ? detectServerMeta(app, serverId) : null;
        const powerBtns = serverId ? findRealButtons(app) : { start: null, restart: null, stop: null };

        // Build signature to avoid unnecessary re-renders
        const sig = JSON.stringify({
            path,
            serverMeta,
            hasAdmin: !!adminAnchor,
            p: [
                powerBtns.start ? !powerBtns.start.disabled : -1,
                powerBtns.restart ? !powerBtns.restart.disabled : -1,
                powerBtns.stop ? !powerBtns.stop.disabled : -1
            ],
            links: realLinks.map(a => a.getAttribute('href') + '|' + a.textContent.trim() + '|' + a.classList.contains('active'))
        });

        if (sig !== lastSidebarSig) {
            lastSidebarSig = sig;

            // Render Topbar
            const tb = document.getElementById('draco-topbar');
            tb.innerHTML = `
                <div class="draco-tb-left">
                    <button type="button" class="draco-tb-burger" id="dracoBurgerBtn" aria-label="Menu">${ICONS.menu}</button>
                    <div class="draco-tb-crumb">${serverMeta ? serverMeta.name : (path.startsWith('/account') ? 'Account Settings' : 'Your Servers')}</div>
                </div>
                <div class="draco-tb-right">
                    ${CFG.discord_url ? `<a class="draco-tb-link" href="${CFG.discord_url}" target="_blank" rel="noreferrer">Discord</a>` : ''}
                    ${CFG.support_url ? `<a class="draco-tb-link" href="${CFG.support_url}" target="_blank" rel="noreferrer">Support</a>` : ''}
                    ${adminAnchor ? `<a class="draco-tb-pill" href="/admin">${ICONS.admin}<span>Admin</span></a>` : ''}
                </div>
            `;
            document.getElementById('dracoBurgerBtn').addEventListener('click', () => setMobileMenu(!mobileOpen));

            // Render Sidebar
            const sb = document.getElementById('draco-sidebar');
            const brandHtml = CFG.logo_url
                ? `<img src="${CFG.logo_url}" class="draco-sb-logo-img" alt="${CFG.panel_name}"><span>${CFG.panel_name || 'Draco'}</span>`
                : `<span class="draco-sb-badge">${(CFG.panel_name || 'D').charAt(0).toUpperCase()}</span><span>${CFG.panel_name || 'Draco'}</span>`;

            let serverHeaderHtml = '';
            if (serverMeta) {
                serverHeaderHtml = `
                    <div class="draco-srv-card">
                        <div class="draco-srv-name" title="${serverMeta.name}">${serverMeta.name}</div>
                        ${serverMeta.ip ? `<button type="button" class="draco-srv-ip" id="dracoCopyIp" title="Click to copy IP">${serverMeta.ip}</button>` : ''}
                        <div class="draco-power-row">
                            <button type="button" class="draco-pwr start" data-pwr="start" ${!powerBtns.start || powerBtns.start.disabled ? 'disabled' : ''} title="Start">▶</button>
                            <button type="button" class="draco-pwr restart" data-pwr="restart" ${!powerBtns.restart || powerBtns.restart.disabled ? 'disabled' : ''} title="Restart">↻</button>
                            <button type="button" class="draco-pwr stop" data-pwr="stop" ${!powerBtns.stop || powerBtns.stop.disabled ? 'disabled' : ''} title="Stop">■</button>
                        </div>
                    </div>
                `;
            }

            // Build categorized links
            const groups = { GENERAL: [], MANAGEMENT: [], CONFIGURATION: [], ADDONS: [] };
            groups.GENERAL.push({ href: '/', label: 'Dashboard', active: path === '/', realEl: logo ? logo.querySelector('a') : null });

            if (serverId) {
                realLinks.forEach(a => {
                    const href = a.getAttribute('href') || '';
                    const label = a.textContent.trim();
                    const active = a.classList.contains('active') || a.getAttribute('aria-current') === 'page' || path === href;
                    const cat = getCategory(href, label);
                    groups[cat].push({ href, label, active, realEl: a });
                });
            } else {
                // Dashboard or Account view
                if (realLinks.length) {
                    realLinks.forEach(a => {
                        const href = a.getAttribute('href') || '';
                        const label = a.textContent.trim();
                        const active = a.classList.contains('active') || path === href;
                        groups.GENERAL.push({ href, label, active, realEl: a });
                    });
                } else {
                    groups.GENERAL.push({ href: '/account', label: 'Account Settings', active: path === '/account', realEl: accountAnchor });
                    groups.GENERAL.push({ href: '/account/api', label: 'API Credentials', active: path === '/account/api', realEl: null });
                    groups.GENERAL.push({ href: '/account/ssh', label: 'SSH Keys', active: path === '/account/ssh', realEl: null });
                }
                if (adminAnchor) {
                    groups.CONFIGURATION.push({ href: '/admin', label: 'Admin Panel', active: false, realEl: null, external: true });
                    groups.CONFIGURATION.push({ href: '/admin/extensions/draco', label: 'Edit Draco Theme', active: false, realEl: null, external: true });
                }
            }

            let navHtml = '';
            Object.keys(groups).forEach(cat => {
                if (!groups[cat].length) return;
                navHtml += `<div class="draco-sb-cat">${cat}</div>`;
                groups[cat].forEach((item, idx) => {
                    navHtml += `<a href="${item.href}" class="draco-sb-link ${item.active ? 'active' : ''}" data-cat="${cat}" data-idx="${idx}">${getIcon(item.href, item.label)}<span>${item.label}</span></a>`;
                });
            });

            sb.innerHTML = `
                <a href="/" class="draco-sb-brand" id="dracoBrandLink">${brandHtml}</a>
                ${serverHeaderHtml}
                <nav class="draco-sb-nav">${navHtml}</nav>
                <div class="draco-sb-footer">
                    <a href="/account" class="draco-sb-account" id="dracoAccBtn">${ICONS.account}<span>Account</span></a>
                    <button type="button" class="draco-sb-logout" id="dracoLogoutBtn" title="Sign Out">${ICONS.logout}</button>
                </div>
            `;

            // Bind SPA navigation clicks
            sb.querySelectorAll('.draco-sb-link').forEach(link => {
                const item = groups[link.dataset.cat][+link.dataset.idx];
                if (!item.external && item.realEl) {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        item.realEl.click();
                        setMobileMenu(false);
                    });
                } else {
                    link.addEventListener('click', () => setMobileMenu(false));
                }
            });

            const brandBtn = document.getElementById('dracoBrandLink');
            if (brandBtn && logo && logo.querySelector('a')) {
                brandBtn.addEventListener('click', (e) => { e.preventDefault(); logo.querySelector('a').click(); setMobileMenu(false); });
            }
            const accBtn = document.getElementById('dracoAccBtn');
            if (accBtn && accountAnchor) {
                accBtn.addEventListener('click', (e) => { e.preventDefault(); accountAnchor.click(); setMobileMenu(false); });
            }
            const outBtn = document.getElementById('dracoLogoutBtn');
            if (outBtn && logoutBtn) {
                outBtn.addEventListener('click', () => logoutBtn.click());
            }
            const copyBtn = document.getElementById('dracoCopyIp');
            if (copyBtn && serverMeta && serverMeta.ip) {
                copyBtn.addEventListener('click', () => {
                    navigator.clipboard && navigator.clipboard.writeText(serverMeta.ip);
                    const old = copyBtn.textContent;
                    copyBtn.textContent = 'Copied!';
                    setTimeout(() => { copyBtn.textContent = old; }, 1200);
                });
            }
            sb.querySelectorAll('.draco-pwr').forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = findRealButtons(app)[btn.dataset.pwr];
                    if (target && !target.disabled) target.click();
                });
            });
        }
    }

    function applyDracoDOM() {
        scheduled = false;
        const app = document.getElementById('app');
        if (!app) return;

        buildShellUI(app);

        // Tag 2-Column Server Banner Grid on Dashboard
        const serverCards = app.querySelectorAll('a[href^="/server/"]');
        if (serverCards.length > 0 && window.location.pathname === '/') {
            const parent = serverCards[0].parentElement;
            if (parent && CFG.server_grid) {
                parent.setAttribute('data-draco', 'server-grid');
            }
            serverCards.forEach(card => {
                card.setAttribute('data-draco', 'server-card');
            });
        }

        // Tag dark neutral surfaces & modals safely
        const vw = window.innerWidth;
        const vh = window.innerHeight;
        const nodes = app.querySelectorAll('div, section, form, article');
        for (let i = 0; i < nodes.length; i++) {
            const el = nodes[i];
            if (el.hasAttribute('data-draco') || el.hasAttribute('data-draco-native')) continue;
            if (el.closest('.xterm') || el.closest('.CodeMirror') || el.closest('.ace_editor')) continue;

            const rect = el.getBoundingClientRect();
            if (rect.width < 80 || rect.height < 30) continue;
            if (rect.width >= vw - 4 && rect.height >= vh - 4) {
                el.setAttribute('data-draco', 'root-wrap');
                continue;
            }
            const kind = classifySurface(getComputedStyle(el).backgroundColor);
            if (kind) el.setAttribute('data-draco', kind);
        }
    }

    function schedule() {
        if (!scheduled) {
            scheduled = true;
            requestAnimationFrame(applyDracoDOM);
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', schedule);
    else schedule();

    new MutationObserver(schedule).observe(document.documentElement, { childList: true, subtree: true });
    window.addEventListener('popstate', schedule);
    window.addEventListener('resize', schedule);
})();
</script>
