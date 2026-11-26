<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* =========================================================
   DRACO PANEL THEME — MATCHING NEBULA ADMIN PANEL
   ========================================================= */
:root {
    --draco-bg: #070911;
    --draco-surface: rgba(16, 21, 35, 0.84);
    --draco-surface-solid: #101523;
    --draco-sidebar: #0a0e1a;
    --draco-border: rgba(255, 255, 255, 0.08);

    /* Accent (Client Panel se match rakhein) */
    --draco-accent: #8b5cf6;
    --draco-accent-2: #3b82f6;
    --draco-accent-soft: rgba(139, 92, 246, 0.18);
    --draco-accent-glow: rgba(139, 92, 246, 0.30);

    --draco-text: #f3f4f6;
    --draco-muted: #94a3b8;
}

html, body, .wrapper, .content-wrapper, .right-side {
    background-color: var(--draco-bg) !important;
    background-image:
        radial-gradient(circle at 12% 14%, var(--draco-accent-soft), transparent 40%),
        radial-gradient(circle at 88% 85%, rgba(59, 130, 246, 0.13), transparent 42%) !important;
    background-attachment: fixed !important;
    color: var(--draco-text) !important;
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
}

/* Header & Logo */
.main-header .navbar,
.main-header .logo {
    background: rgba(10, 14, 26, 0.90) !important;
    backdrop-filter: blur(16px) !important;
    -webkit-backdrop-filter: blur(16px) !important;
    border-bottom: 1px solid var(--draco-border) !important;
    color: #ffffff !important;
}

.main-header .logo {
    border-right: 1px solid var(--draco-border) !important;
    font-weight: 700 !important;
    letter-spacing: 0.04em !important;
}

.main-header .navbar .nav > li > a,
.main-header .navbar .sidebar-toggle {
    color: var(--draco-muted) !important;
}

.main-header .navbar .nav > li > a:hover,
.main-header .navbar .sidebar-toggle:hover {
    background: rgba(255, 255, 255, 0.06) !important;
    color: #ffffff !important;
}

/* Left Sidebar */
.main-sidebar, .left-side {
    background: var(--draco-sidebar) !important;
    border-right: 1px solid var(--draco-border) !important;
}

.sidebar-menu > li.header {
    background: transparent !important;
    color: #64748b !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.08em !important;
    text-transform: uppercase !important;
    padding: 14px 18px 6px !important;
}

.sidebar-menu > li > a {
    color: var(--draco-muted) !important;
    margin: 3px 10px !important;
    border-radius: 10px !important;
    border-left: none !important;
    transition: all 0.18s ease !important;
}

.sidebar-menu > li > a:hover {
    background: rgba(255, 255, 255, 0.05) !important;
    color: #ffffff !important;
}

.sidebar-menu > li.active > a {
    background: linear-gradient(135deg, var(--draco-accent-soft), rgba(59, 130, 246, 0.14)) !important;
    color: #ffffff !important;
    border: 1px solid rgba(139, 92, 246, 0.45) !important;
    box-shadow: 0 0 14px rgba(139, 92, 246, 0.22) !important;
}

/* Breadcrumbs & Page Titles */
.content-header > h1 {
    color: #ffffff !important;
    font-weight: 700 !important;
}
.content-header > h1 > small,
.content-header > .breadcrumb > li > a {
    color: var(--draco-muted) !important;
}
.content-header > .breadcrumb > .active {
    color: var(--draco-accent) !important;
}

/* Boxes & Cards */
.box, .nav-tabs-custom {
    background: var(--draco-surface) !important;
    backdrop-filter: blur(14px) !important;
    border: 1px solid var(--draco-border) !important;
    border-top: 2px solid var(--draco-accent) !important;
    border-radius: 14px !important;
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.36) !important;
}

.box-header, .box-footer {
    background: rgba(7, 9, 17, 0.48) !important;
    border-color: var(--draco-border) !important;
    color: var(--draco-text) !important;
    border-radius: 12px 12px 0 0 !important;
}

.box-footer {
    border-radius: 0 0 12px 12px !important;
}

.box-title {
    color: #ffffff !important;
    font-weight: 600 !important;
}

.info-box {
    background: var(--draco-surface) !important;
    border: 1px solid var(--draco-border) !important;
    border-radius: 14px !important;
    color: var(--draco-text) !important;
    overflow: hidden;
}

/* Tables & Pagination */
.table, .table > tbody > tr > td, .table > thead > tr > th, .table > tfoot > tr > th {
    border-color: var(--draco-border) !important;
    color: var(--draco-text) !important;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.02) !important;
}

.table-hover > tbody > tr:hover {
    background-color: rgba(139, 92, 246, 0.09) !important;
}

.pagination > li > a,
.pagination > li > span {
    background: var(--draco-surface-solid) !important;
    border-color: var(--draco-border) !important;
    color: var(--draco-text) !important;
}

.pagination > .active > a,
.pagination > .active > span {
    background: var(--draco-accent) !important;
    border-color: var(--draco-accent) !important;
    color: #ffffff !important;
}

/* Forms, Inputs & Select2 Dropdowns */
.form-control,
.input-group-addon,
.select2-container--default .select2-selection--single,
.select2-container--default .select2-selection--multiple,
.select2-dropdown,
.select2-search__field {
    background-color: rgba(8, 11, 20, 0.90) !important;
    border: 1px solid var(--draco-border) !important;
    color: var(--draco-text) !important;
    border-radius: 10px !important;
}

.form-control:focus {
    border-color: var(--draco-accent) !important;
    box-shadow: 0 0 0 2px var(--draco-accent-soft) !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered,
.select2-results__option {
    color: var(--draco-text) !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: var(--draco-accent) !important;
    color: #ffffff !important;
}

.help-block, .text-muted {
    color: var(--draco-muted) !important;
}

/* Tabs & Nav Pills */
.nav-tabs-custom > .nav-tabs {
    background: rgba(7, 9, 17, 0.5) !important;
    border-bottom: 1px solid var(--draco-border) !important;
}
.nav-tabs-custom > .nav-tabs > li > a {
    color: var(--draco-muted) !important;
}
.nav-tabs-custom > .nav-tabs > li.active {
    border-top-color: var(--draco-accent) !important;
}
.nav-tabs-custom > .nav-tabs > li.active > a {
    background: transparent !important;
    color: #ffffff !important;
    border-color: transparent !important;
}

/* Buttons */
.btn {
    border-radius: 9px !important;
    font-weight: 600 !important;
    transition: all 0.15s ease !important;
}

.btn-primary, .btn-info {
    background: linear-gradient(135deg, var(--draco-accent), var(--draco-accent-2)) !important;
    border: none !important;
    color: #ffffff !important;
    box-shadow: 0 4px 14px var(--draco-accent-glow) !important;
}

.btn-default {
    background: rgba(255, 255, 255, 0.06) !important;
    border: 1px solid var(--draco-border) !important;
    color: var(--draco-text) !important;
}
.btn-default:hover {
    background: rgba(255, 255, 255, 0.12) !important;
    color: #ffffff !important;
}

/* Code, Modals, SweetAlert Popups & Footer */
code, pre {
    font-family: 'JetBrains Mono', monospace !important;
    background: #05070e !important;
    color: #c4b5fd !important;
    border: 1px solid var(--draco-border) !important;
    border-radius: 8px !important;
}

.modal-content, .sweet-alert {
    background: #0e1322 !important;
    border: 1px solid var(--draco-border) !important;
    border-radius: 16px !important;
    color: var(--draco-text) !important;
}

.sweet-alert h2, .sweet-alert p {
    color: var(--draco-text) !important;
}

.modal-header, .modal-footer {
    border-color: var(--draco-border) !important;
}

.main-footer {
    background: rgba(10, 14, 26, 0.88) !important;
    border-top: 1px solid var(--draco-border) !important;
    color: var(--draco-muted) !important;
}

/* Scrollbar */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: var(--draco-bg); }
::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, var(--draco-accent), var(--draco-accent-2));
    border-radius: 10px;
}
</style>
