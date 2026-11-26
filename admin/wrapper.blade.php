@php
    $dracoDefaults = [
        'bg_url' => '', 'bg_blur' => 16, 'card_opacity' => 82, 'bg_dim' => 55,
        'accent_primary' => '#7c3aed', 'accent_secondary' => '#3b82f6',
        'bg_color' => '#090b16', 'sidebar_color' => '#0d1021',
        'card_color' => '#14182e', 'text_color' => '#f3f4f6', 'muted_color' => '#94a3b8',
        'sync_admin' => 1,
    ];
    $draco =$dracoDefaults;
    try {
        $raw = app(\Pterodactyl\Contracts\Repository\SettingsRepositoryInterface::class)->get('draco::config');
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {$draco = array_merge($dracoDefaults,$decoded); }
        }
    } catch (\Throwable $e) {}

    $toRgb = function ($hex) {
        $h = ltrim((string)$hex, '#');
        if (strlen($h) !== 6) return '20, 24, 46';
        return hexdec(substr($h,0,2)).', '.hexdec(substr($h,2,2)).', '.hexdec(substr($h,4,2));
    };
    $op = round(max(20, min(100, (int)$draco['card_opacity'])) / 100, 2);
    $dim = round(max(0, min(95, (int)$draco['bg_dim'])) / 100, 2);
@endphp

<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

@if($draco['sync_admin'])
<style>
:root {
    --da-bg: {{ $draco['bg_color'] }};
    --da-accent: {{ $draco['accent_primary'] }};
    --da-accent2: {{ $draco['accent_secondary'] }};
    --da-accent-rgb: {{ $toRgb($draco['accent_primary']) }};
    --da-side-rgb: {{ $toRgb($draco['sidebar_color']) }};
    --da-card-rgb: {{ $toRgb($draco['card_color']) }};
    --da-blur: {{ (int)$draco['bg_blur'] }}px;
    --da-op: {{ $op }};
    --da-text: {{ $draco['text_color'] }};
    --da-muted: {{ $draco['muted_color'] }};
}

html, body, .wrapper, .content-wrapper, .right-side {
    background-color: var(--da-bg) !important;
    background-image:
        {!! $draco['bg_url'] ? "linear-gradient(rgba(5,7,14,{$dim}), rgba(5,7,14,{$dim})), url('".e($draco['bg_url'])."')" : "radial-gradient(circle at 12% 14%, rgba(var(--da-accent-rgb),0.20), transparent 42%), radial-gradient(circle at 88% 85%, rgba(59,130,246,0.14), transparent 44%)" !!} !important;
    background-size: cover !important;
    background-attachment: fixed !important;
    color: var(--da-text) !important;
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
}

.main-header .navbar, .main-header .logo {
    background: rgba(var(--da-side-rgb), 0.92) !important;
    backdrop-filter: blur(var(--da-blur)) !important;
    border-bottom: 1px solid rgba(255,255,255,0.08) !important;
    color: #fff !important;
}
.main-sidebar, .left-side {
    background: rgba(var(--da-side-rgb), 0.95) !important;
    border-right: 1px solid rgba(255,255,255,0.08) !important;
}
.sidebar-menu > li > a {
    color: var(--da-muted) !important; margin: 3px 10px !important; border-radius: 10px !important; border-left: none !important;
}
.sidebar-menu > li > a:hover { background: rgba(255,255,255,0.06) !important; color: #fff !important; }
.sidebar-menu > li.active > a {
    background: linear-gradient(90deg, rgba(var(--da-accent-rgb), 0.30), transparent) !important;
    color: #fff !important; border: 1px solid rgba(var(--da-accent-rgb), 0.45) !important;
}

.box, .nav-tabs-custom, .info-box {
    background: rgba(var(--da-card-rgb), var(--da-op)) !important;
    backdrop-filter: blur(var(--da-blur)) !important;
    border: 1px solid rgba(255,255,255,0.08) !important;
    border-top: 2px solid var(--da-accent) !important;
    border-radius: 14px !important;
    color: var(--da-text) !important;
}
.box-header, .box-footer {
    background: rgba(5, 7, 14, 0.45) !important;
    border-color: rgba(255,255,255,0.08) !important;
    color: #fff !important;
}
.table, .table td, .table th { border-color: rgba(255,255,255,0.07) !important; color: var(--da-text) !important; }
.table-hover > tbody > tr:hover { background: rgba(var(--da-accent-rgb), 0.1) !important; }
.form-control, .select2-selection, .select2-dropdown {
    background: rgba(7, 10, 20, 0.9) !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
    color: var(--da-text) !important; border-radius: 9px !important;
}
.btn-primary, .btn-info {
    background: linear-gradient(135deg, var(--da-accent), var(--da-accent2)) !important;
    border: none !important; color: #fff !important; border-radius: 9px !important; font-weight: 600 !important;
}
.modal-content, .sweet-alert {
    background: rgb(var(--da-card-rgb)) !important; color: var(--da-text) !important; border-radius: 16px !important;
}
.main-footer {
    background: rgba(var(--da-side-rgb), 0.88) !important;
    border-top: 1px solid rgba(255,255,255,0.08) !important; color: var(--da-muted) !important;
}
</style>
@endif

<script>
(function () {
    function injectEditThemeIntoBasicAdmin() {
        if (document.getElementById('draco-basic-admin-edit-theme')) return;
        var sidebar = document.querySelector('ul.sidebar-menu');
        if (!sidebar) return;

        // Locate "Application API" inside BASIC ADMINISTRATION
        var apiLink = sidebar.querySelector('a[href$="/admin/api"]');
        if (!apiLink) {
            var links = sidebar.querySelectorAll('li > a');
            for (var i = 0; i < links.length; i++) {
                var txt = (links[i].textContent || '').trim().toLowerCase();
                var href = (links[i].getAttribute('href') || '').toLowerCase();
                if (txt.indexOf('application api') !== -1 || href.indexOf('/admin/api') !== -1) {
                    apiLink = links[i];
                    break;
                }
            }
        }
        if (!apiLink || !apiLink.parentElement) return;

        var isDracoPage = window.location.pathname.indexOf('/admin/extensions/draco') === 0;
        var li = document.createElement('li');
        li.id = 'draco-basic-admin-edit-theme';

        if (isDracoPage) {
            var activeItems = sidebar.querySelectorAll('li.active');
            for (var j = 0; j < activeItems.length; j++) {
                activeItems[j].classList.remove('active');
            }
            li.classList.add('active');
        }

        li.innerHTML = '<a href="/admin/extensions/draco"><i class="fa fa-paint-brush"></i> <span>Edit Theme</span></a>';
        apiLink.parentElement.insertAdjacentElement('afterend', li);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', injectEditThemeIntoBasicAdmin);
    } else {
        injectEditThemeIntoBasicAdmin();
    }
})();
</script>
