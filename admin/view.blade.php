@php
    $defaults = [
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
    $cfg = isset($dracoConfig) && is_array($dracoConfig) ? array_merge($defaults, $dracoConfig) : $defaults;
    if (!isset($dracoConfig)) {
        try {
            $raw = app(\Pterodactyl\Contracts\Repository\SettingsRepositoryInterface::class)->get('draco::config');
            if (is_string($raw)) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) { $cfg = array_merge($defaults, $decoded); }
            }
        } catch (\Throwable $e) {}
    }
    $formAction = isset($root) && is_string($root) ? $root : '/admin/extensions/draco';
@endphp

<style>
.de-shell {
    display: flex; flex-direction: column;
    background: #0d1021;
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 16px; overflow: hidden;
    color: #f3f4f6;
    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    min-height: 760px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.55);
}
.de-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 18px; background: #12162b;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    flex-wrap: wrap; gap: 10px;
}
.de-brand { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 16px; }
.de-badge {
    width: 32px; height: 32px; border-radius: 9px;
    background: linear-gradient(135deg, #7c3aed, #3b82f6);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; color: #fff;
}
.de-global-pill {
    font-size: 11px; padding: 3px 9px; border-radius: 99px;
    background: rgba(16, 185, 129, 0.16); color: #6ee7b7;
    border: 1px solid rgba(16, 185, 129, 0.35); font-weight: 600;
}
.de-preview-tabs { display: flex; gap: 6px; background: rgba(0,0,0,0.28); padding: 4px; border-radius: 10px; }
.de-ptab {
    background: transparent; border: none; color: #94a3b8; padding: 6px 12px;
    border-radius: 7px; font-size: 12px; font-weight: 600; cursor: pointer;
}
.de-ptab.active { background: #7c3aed; color: #fff; }
.de-body { display: grid; grid-template-columns: 62px 340px 1fr; flex: 1; min-height: 700px; }
@media (max-width: 1180px) {
    .de-body { grid-template-columns: 58px 1fr; }
    .de-preview-col { grid-column: 1 / -1; min-height: 460px; border-top: 1px solid rgba(255,255,255,0.08); }
}
.de-rail {
    background: #0a0d1a; border-right: 1px solid rgba(255,255,255,0.07);
    display: flex; flex-direction: column; align-items: center; padding: 14px 0; gap: 8px;
}
.de-rail-btn {
    width: 42px; height: 42px; border-radius: 11px;
    background: transparent; border: 1px solid transparent;
    color: #94a3b8; cursor: pointer;
    display: flex; align-items: center; justify-content: center; transition: all 0.16s ease;
}
.de-rail-btn:hover { background: rgba(255,255,255,0.06); color: #fff; }
.de-rail-btn.active { background: rgba(124,58,237,0.22); color: #fff; border-color: rgba(124,58,237,0.55); }
.de-drawer {
    background: #101428; border-right: 1px solid rgba(255,255,255,0.07);
    display: flex; flex-direction: column; max-height: 740px;
}
.de-drawer-scroll { padding: 18px; overflow-y: auto; flex: 1; }
.de-drawer-footer {
    padding: 14px 18px; background: #0d1021;
    border-top: 1px solid rgba(255,255,255,0.08); display: flex; gap: 8px;
}
.de-pane { display: none; }
.de-pane.active { display: block; }
.de-title { font-size: 16px; font-weight: 700; margin: 0 0 4px; color: #fff; }
.de-sub { font-size: 12px; color: #94a3b8; margin: 0 0 16px; }
.de-field { margin-bottom: 14px; }
.de-label {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 12px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px;
}
.de-val { background: rgba(124,58,237,0.22); color: #c4b5fd; padding: 2px 7px; border-radius: 6px; font-size: 11px; }
.de-input, .de-textarea {
    width: 100%; background: #090c18 !important; color: #f3f4f6 !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
    border-radius: 9px !important; padding: 8px 11px !important; font-size: 13px !important;
}
.de-range { width: 100%; accent-color: #7c3aed; cursor: pointer; }
.de-color-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.de-color-box {
    display: flex; align-items: center; gap: 8px;
    background: #090c18; border: 1px solid rgba(255,255,255,0.1);
    padding: 6px 8px; border-radius: 9px;
}
.de-color-box input[type="color"] { width: 28px; height: 28px; border: none; background: none; cursor: pointer; padding: 0; }
.de-color-box span { font-size: 11px; color: #cbd5e1; font-family: monospace; }
.de-toggle {
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07);
    padding: 10px 12px; border-radius: 10px; margin-bottom: 10px; cursor: pointer;
}
.de-toggle input { width: 18px; height: 18px; accent-color: #7c3aed; cursor: pointer; }
.de-presets { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 16px; }
.de-preset-btn {
    padding: 8px 10px; border-radius: 9px; border: 1px solid rgba(255,255,255,0.1);
    background: #090c18; color: #e2e8f0; font-size: 12px; font-weight: 600;
    display: flex; align-items: center; gap: 8px; cursor: pointer;
}
.de-preset-btn:hover { border-color: #7c3aed; }
.de-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
.de-layout-grid { display: flex; flex-direction: column; gap: 10px; }
.de-layout-card {
    border: 2px solid rgba(255,255,255,0.1); border-radius: 12px;
    padding: 12px; background: #0a0d1c; cursor: pointer; transition: all 0.16s ease;
}
.de-layout-card.selected { border-color: #7c3aed; background: rgba(124,58,237,0.14); }
.de-layout-card input { display: none; }
.de-wireframe {
    height: 74px; border-radius: 8px; background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08); padding: 8px; display: flex; gap: 8px;
}
.de-wf-form {
    background: rgba(255,255,255,0.09); border-radius: 6px; padding: 8px;
    display: flex; flex-direction: column; justify-content: center; gap: 5px;
}
.de-wf-bar { height: 7px; border-radius: 4px; background: rgba(255,255,255,0.22); }
.de-wf-img {
    flex: 1; border-radius: 6px;
    background: linear-gradient(135deg, rgba(124,58,237,0.35), rgba(59,130,246,0.3));
    border: 1px dashed rgba(255,255,255,0.2);
}
.de-save-btn {
    flex: 1; padding: 10px 16px; border: none; border-radius: 10px;
    background: linear-gradient(135deg, #7c3aed, #4f46e5); color: #fff;
    font-weight: 700; font-size: 13px; cursor: pointer;
}
.de-reset-btn {
    padding: 10px 12px; border: 1px solid rgba(239,68,68,0.4); border-radius: 10px;
    background: rgba(239,68,68,0.12); color: #fca5a5; font-weight: 600; font-size: 12px; cursor: pointer;
}
.de-preview-col { padding: 18px; background: #070914; display: flex; flex-direction: column; }
.de-stage {
    flex: 1; border-radius: 14px; border: 1px solid rgba(255,255,255,0.1);
    overflow: hidden; position: relative; display: flex;
    background-size: cover; background-position: center; min-height: 620px;
}
.de-stage-dim { position: absolute; inset: 0; pointer-events: none; z-index: 0; }
.de-pv-shell { position: relative; z-index: 1; display: flex; width: 100%; height: 100%; }
.de-pv-side {
    width: 195px; padding: 14px 10px; border-right: 1px solid rgba(255,255,255,0.08);
    display: flex; flex-direction: column; gap: 10px; flex-shrink: 0;
}
.de-pv-main { flex: 1; display: flex; flex-direction: column; padding: 14px; gap: 12px; overflow: hidden; }
.de-pv-top {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.08);
}
.de-pv-ann { padding: 8px 12px; border-radius: 9px; font-size: 12px; border-left: 3px solid #f59e0b; background: rgba(255,255,255,0.06); }
.de-pv-cat { font-size: 9px; font-weight: 700; letter-spacing: 0.12em; opacity: 0.55; margin: 6px 0 3px 6px; }
.de-pv-item { padding: 6px 9px; border-radius: 7px; font-size: 11px; display: flex; align-items: center; gap: 7px; }
.de-pv-console {
    flex: 1; min-height: 220px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);
    padding: 12px; display: flex; flex-direction: column; justify-content: space-between;
    font-family: monospace; font-size: 11px;
}
.de-pv-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.de-pv-stat {
    padding: 12px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);
    display: flex; justify-content: space-between; align-items: center;
}
.de-pv-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; }
.de-pv-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.de-pv-scard { border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.09); }
.de-pv-sbanner {
    height: 78px; background-size: cover; background-position: center;
    position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center;
}
</style>

@if(session('draco_status'))
<div class="alert alert-success" style="border-radius:10px; margin-bottom:14px;">
    {{ session('draco_status') }}
</div>
@endif

<form method="POST" action="{{ $formAction }}" id="dracoEditorForm">
@csrf
@method('PATCH')
<input type="hidden" name="draco_action" id="dracoActionInput" value="save">

<div class="de-shell">
    <div class="de-header">
        <div class="de-brand">
            <div class="de-badge">D</div>
            <span>Draco Edit Theme</span>
            <span class="de-global-pill">Admin Only • Global (All Servers)</span>
        </div>
        <div class="de-preview-tabs">
            <button type="button" class="de-ptab active" data-pmode="console">Console View</button>
            <button type="button" class="de-ptab" data-pmode="dashboard">2-Col Cards</button>
            <button type="button" class="de-ptab" data-pmode="login">Login Screen</button>
        </div>
    </div>

    <div class="de-body">
        <div class="de-rail">
            <button type="button" class="de-rail-btn active" data-tab="bg" title="Background & Glass"><i class="fa fa-image"></i></button>
            <button type="button" class="de-rail-btn" data-tab="colors" title="Colors & Presets"><i class="fa fa-paint-brush"></i></button>
            <button type="button" class="de-rail-btn" data-tab="login" title="Login Layout"><i class="fa fa-columns"></i></button>
            <button type="button" class="de-rail-btn" data-tab="dashboard" title="Dashboard & Cards"><i class="fa fa-th-large"></i></button>
            <button type="button" class="de-rail-btn" data-tab="branding" title="Branding & Links"><i class="fa fa-bullhorn"></i></button>
            <button type="button" class="de-rail-btn" data-tab="advanced" title="Advanced & CSS"><i class="fa fa-code"></i></button>
        </div>

        <div class="de-drawer">
            <div class="de-drawer-scroll">

                <div class="de-pane active" id="tab-bg">
                    <h4 class="de-title">Background &amp; Glass</h4>
                    <p class="de-sub">Custom wallpaper, blurriness aur transparency sabhi servers ke liye set karein.</p>

                    <div class="de-field">
                        <label class="de-label">Custom Background Image URL</label>
                        <input type="text" class="de-input" name="bg_url" id="f_bg_url" value="{{ $cfg['bg_url'] }}" placeholder="https://.../wallpaper.jpg (blank = Nebula gradient)">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Card Blurriness <span class="de-val" id="v_blur">{{ $cfg['bg_blur'] }}px</span></label>
                        <input type="range" class="de-range" name="bg_blur" id="f_bg_blur" min="0" max="30" value="{{ $cfg['bg_blur'] }}">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Card Transparency / Opacity <span class="de-val" id="v_opacity">{{ $cfg['card_opacity'] }}%</span></label>
                        <input type="range" class="de-range" name="card_opacity" id="f_card_opacity" min="20" max="100" value="{{ $cfg['card_opacity'] }}">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Background Dimmer <span class="de-val" id="v_dim">{{ $cfg['bg_dim'] }}%</span></label>
                        <input type="range" class="de-range" name="bg_dim" id="f_bg_dim" min="0" max="95" value="{{ $cfg['bg_dim'] }}">
                    </div>

                    <label class="de-toggle">
                        <span style="font-size:12px;">Ambient Nebula Glow</span>
                        <input type="checkbox" name="ambient_glow" id="f_ambient_glow" {{ $cfg['ambient_glow'] ? 'checked' : '' }}>
                    </label>
                </div>

                <div class="de-pane" id="tab-colors">
                    <h4 class="de-title">Colors &amp; Presets</h4>
                    <p class="de-sub">1-click preset choose karein ya har color custom set karein.</p>

                    <div class="de-presets">
                        <button type="button" class="de-preset-btn" onclick="applyDracoPreset('nebula')"><span class="de-dot" style="background:#7c3aed;"></span>Nebula Violet</button>
                        <button type="button" class="de-preset-btn" onclick="applyDracoPreset('crimson')"><span class="de-dot" style="background:#ef4444;"></span>Draco Crimson</button>
                        <button type="button" class="de-preset-btn" onclick="applyDracoPreset('emerald')"><span class="de-dot" style="background:#10b981;"></span>Cyber Emerald</button>
                        <button type="button" class="de-preset-btn" onclick="applyDracoPreset('ocean')"><span class="de-dot" style="background:#0ea5e9;"></span>Midnight Blue</button>
                    </div>

                    <div class="de-color-row">
                        <div class="de-field">
                            <label class="de-label">Primary Accent</label>
                            <div class="de-color-box"><input type="color" name="accent_primary" id="f_accent_primary" value="{{ $cfg['accent_primary'] }}"><span>{{ $cfg['accent_primary'] }}</span></div>
                        </div>
                        <div class="de-field">
                            <label class="de-label">Secondary Glow</label>
                            <div class="de-color-box"><input type="color" name="accent_secondary" id="f_accent_secondary" value="{{ $cfg['accent_secondary'] }}"><span>{{ $cfg['accent_secondary'] }}</span></div>
                        </div>
                        <div class="de-field">
                            <label class="de-label">Base Background</label>
                            <div class="de-color-box"><input type="color" name="bg_color" id="f_bg_color" value="{{ $cfg['bg_color'] }}"><span>{{ $cfg['bg_color'] }}</span></div>
                        </div>
                        <div class="de-field">
                            <label class="de-label">Sidebar Surface</label>
                            <div class="de-color-box"><input type="color" name="sidebar_color" id="f_sidebar_color" value="{{ $cfg['sidebar_color'] }}"><span>{{ $cfg['sidebar_color'] }}</span></div>
                        </div>
                        <div class="de-field">
                            <label class="de-label">Card Surface</label>
                            <div class="de-color-box"><input type="color" name="card_color" id="f_card_color" value="{{ $cfg['card_color'] }}"><span>{{ $cfg['card_color'] }}</span></div>
                        </div>
                        <div class="de-field">
                            <label class="de-label">Console Box</label>
                            <div class="de-color-box"><input type="color" name="console_color" id="f_console_color" value="{{ $cfg['console_color'] }}"><span>{{ $cfg['console_color'] }}</span></div>
                        </div>
                        <div class="de-field">
                            <label class="de-label">Primary Text</label>
                            <div class="de-color-box"><input type="color" name="text_color" id="f_text_color" value="{{ $cfg['text_color'] }}"><span>{{ $cfg['text_color'] }}</span></div>
                        </div>
                        <div class="de-field">
                            <label class="de-label">Muted Text</label>
                            <div class="de-color-box"><input type="color" name="muted_color" id="f_muted_color" value="{{ $cfg['muted_color'] }}"><span>{{ $cfg['muted_color'] }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="de-pane" id="tab-login">
                    <h4 class="de-title">Login Layout Settings</h4>
                    <p class="de-sub">Login screen ke liye 3 layouts me se choose karein.</p>

                    <div class="de-layout-grid">
                        <label class="de-layout-card {{ $cfg['login_layout'] == 1 ? 'selected' : '' }}">
                            <input type="radio" name="login_layout" value="1" {{ $cfg['login_layout'] == 1 ? 'checked' : '' }}>
                            <div class="de-wireframe" style="justify-content:center;">
                                <div class="de-wf-form" style="width:52%;"><div class="de-wf-bar"></div><div class="de-wf-bar"></div><div class="de-wf-bar"></div></div>
                            </div>
                            <div style="font-size:12px; font-weight:600; margin-top:7px;">1. Centered Glass Card</div>
                        </label>

                        <label class="de-layout-card {{ $cfg['login_layout'] == 2 ? 'selected' : '' }}">
                            <input type="radio" name="login_layout" value="2" {{ $cfg['login_layout'] == 2 ? 'checked' : '' }}>
                            <div class="de-wireframe" style="padding:0; overflow:hidden;">
                                <div class="de-wf-form" style="width:45%; border-radius:0;"><div class="de-wf-bar"></div><div class="de-wf-bar"></div><div class="de-wf-bar"></div></div>
                                <div class="de-wf-img" style="border-radius:0; border:none;"></div>
                            </div>
                            <div style="font-size:12px; font-weight:600; margin-top:7px;">2. Split Screen (Left Form + Right Wallpaper)</div>
                        </label>

                        <label class="de-layout-card {{ $cfg['login_layout'] == 3 ? 'selected' : '' }}">
                            <input type="radio" name="login_layout" value="3" {{ $cfg['login_layout'] == 3 ? 'checked' : '' }}>
                            <div class="de-wireframe">
                                <div class="de-wf-form" style="width:44%;"><div class="de-wf-bar"></div><div class="de-wf-bar"></div><div class="de-wf-bar"></div></div>
                                <div class="de-wf-img"></div>
                            </div>
                            <div style="font-size:12px; font-weight:600; margin-top:7px;">3. Framed Split Card</div>
                        </label>
                    </div>

                    <div class="de-field" style="margin-top:14px;">
                        <label class="de-label">Login Wallpaper URL (Optional)</label>
                        <input type="text" class="de-input" name="login_bg_url" id="f_login_bg_url" value="{{ $cfg['login_bg_url'] }}" placeholder="Blank = main background URL">
                    </div>
                </div>

                <div class="de-pane" id="tab-dashboard">
                    <h4 class="de-title">Dashboard &amp; Server Cards</h4>
                    <p class="de-sub">2-column banner cards aur server banner customize karein.</p>

                    <label class="de-toggle">
                        <span style="font-size:12px;">2-Column Banner Server Cards</span>
                        <input type="checkbox" name="server_grid" id="f_server_grid" {{ $cfg['server_grid'] ? 'checked' : '' }}>
                    </label>

                    <div class="de-field">
                        <label class="de-label">Server Card Banner Image URL</label>
                        <input type="text" class="de-input" name="banner_url" id="f_banner_url" value="{{ $cfg['banner_url'] }}" placeholder="https://.../minecraft-banner.jpg">
                    </div>
                </div>

                <div class="de-pane" id="tab-branding">
                    <h4 class="de-title">Branding &amp; Announcement</h4>
                    <p class="de-sub">Panel naam, logo, Discord/Support links aur announcement set karein.</p>

                    <div class="de-field">
                        <label class="de-label">Panel Name</label>
                        <input type="text" class="de-input" name="panel_name" id="f_panel_name" value="{{ $cfg['panel_name'] }}">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Logo Image URL (Optional)</label>
                        <input type="text" class="de-input" name="logo_url" id="f_logo_url" value="{{ $cfg['logo_url'] }}" placeholder="https://.../logo.png">
                    </div>

                    <label class="de-toggle">
                        <span style="font-size:12px;">Show Announcement Banner</span>
                        <input type="checkbox" name="announcement_enabled" id="f_announcement_enabled" {{ $cfg['announcement_enabled'] ? 'checked' : '' }}>
                    </label>

                    <div class="de-field">
                        <label class="de-label">Announcement Text</label>
                        <input type="text" class="de-input" name="announcement_text" id="f_announcement_text" value="{{ $cfg['announcement_text'] }}">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Announcement Accent Color</label>
                        <div class="de-color-box"><input type="color" name="announcement_color" id="f_announcement_color" value="{{ $cfg['announcement_color'] }}"><span>{{ $cfg['announcement_color'] }}</span></div>
                    </div>

                    <div class="de-field">
                        <label class="de-label">Discord Invite URL</label>
                        <input type="text" class="de-input" name="discord_url" id="f_discord_url" value="{{ $cfg['discord_url'] }}" placeholder="https://discord.gg/...">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Support Center URL</label>
                        <input type="text" class="de-input" name="support_url" id="f_support_url" value="{{ $cfg['support_url'] }}" placeholder="https://...">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Footer Text</label>
                        <input type="text" class="de-input" name="footer_text" id="f_footer_text" value="{{ $cfg['footer_text'] }}">
                    </div>

                    <div class="de-field">
                        <label class="de-label">Footer Links (About / Privacy / Terms)</label>
                        <input type="text" class="de-input" name="footer_about" value="{{ $cfg['footer_about'] }}" placeholder="About URL" style="margin-bottom:6px;">
                        <input type="text" class="de-input" name="footer_privacy" value="{{ $cfg['footer_privacy'] }}" placeholder="Privacy URL" style="margin-bottom:6px;">
                        <input type="text" class="de-input" name="footer_terms" value="{{ $cfg['footer_terms'] }}" placeholder="Terms URL">
                    </div>
                </div>

                <div class="de-pane" id="tab-advanced">
                    <h4 class="de-title">Advanced Settings</h4>
                    <p class="de-sub">Admin panel theme sync aur extra Custom CSS.</p>

                    <label class="de-toggle">
                        <span style="font-size:12px;">Sync Admin Panel with Draco Theme</span>
                        <input type="checkbox" name="sync_admin" id="f_sync_admin" {{ $cfg['sync_admin'] ? 'checked' : '' }}>
                    </label>

                    <div class="de-field">
                        <label class="de-label">Custom CSS (Optional)</label>
                        <textarea class="de-textarea" name="custom_css" rows="10" placeholder="/* Extra custom CSS */">{{ $cfg['custom_css'] }}</textarea>
                    </div>
                </div>

            </div>

            <div class="de-drawer-footer">
                <button type="submit" class="de-save-btn" onclick="document.getElementById('dracoActionInput').value='save'">Save Changes</button>
                <button type="submit" class="de-reset-btn" onclick="if(!confirm('Reset all Draco theme settings?')) return false; document.getElementById('dracoActionInput').value='reset'">Reset</button>
            </div>
        </div>

        <div class="de-preview-col">
            <div class="de-stage" id="pvStage">
                <div class="de-stage-dim" id="pvDim"></div>

                <div class="de-pv-shell" id="pvAppShell">
                    <div class="de-pv-side" id="pvSidebar">
                        <div style="display:flex; align-items:center; gap:8px; font-weight:700; font-size:14px;">
                            <div id="pvLogoMark" style="width:26px; height:26px; border-radius:7px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800;">D</div>
                            <span id="pvPanelName">{{ $cfg['panel_name'] }}</span>
                        </div>
                        <div style="padding:8px; border-radius:9px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.07);">
                            <div style="font-size:12px; font-weight:700;">Draco SMP</div>
                            <div style="font-size:10px; opacity:0.65;">play.novamc.in:25565</div>
                            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:5px; margin-top:8px;">
                                <div style="background:#16a34a; height:22px; border-radius:6px; text-align:center; line-height:22px; font-size:10px;">▶</div>
                                <div style="background:#334155; height:22px; border-radius:6px; text-align:center; line-height:22px; font-size:10px;">↻</div>
                                <div style="background:#dc2626; height:22px; border-radius:6px; text-align:center; line-height:22px; font-size:10px;">■</div>
                            </div>
                        </div>
                        <div>
                            <div class="de-pv-cat">GENERAL</div>
                            <div class="de-pv-item">Dashboard</div>
                            <div class="de-pv-item" id="pvActiveNav">Console</div>
                            <div class="de-pv-item">Settings</div>
                            <div class="de-pv-cat">MANAGEMENT</div>
                            <div class="de-pv-item">Files</div>
                            <div class="de-pv-item">Databases</div>
                            <div class="de-pv-item">Backups</div>
                            <div class="de-pv-cat">ADDONS</div>
                            <div class="de-pv-item">Plugins &amp; Mods</div>
                            <div class="de-pv-item">Egg Changer</div>
                        </div>
                    </div>

                    <div class="de-pv-main">
                        <div class="de-pv-top" id="pvTopbar">
                            <span style="font-size:12px; font-weight:600;">Draco SMP</span>
                            <div style="display:flex; gap:12px; font-size:11px; opacity:0.85;">
                                <span>Discord</span><span>Support</span><span>Account</span>
                            </div>
                        </div>

                        <div class="de-pv-ann" id="pvAnn">{{ $cfg['announcement_text'] }}</div>

                        <div id="pvConsoleView" style="display:flex; flex-direction:column; gap:12px; flex:1;">
                            <div class="de-pv-console" id="pvConsoleBox">
                                <div style="opacity:0.8;">
                                    [Draco Daemon]: Checking server disk space usage...<br>
                                    [Server thread/INFO]: Starting Minecraft server on 0.0.0.0:25565<br>
                                    [Server thread/INFO]: Done (3.42s)! For help, type "help"
                                </div>
                                <div style="padding:7px 10px; border-radius:7px; background:rgba(255,255,255,0.06); opacity:0.7;">&raquo; Type a command...</div>
                            </div>
                            <div class="de-pv-stats">
                                <div class="de-pv-stat pv-card">
                                    <div><div style="font-size:10px; opacity:0.65;">CPU Usage</div><div style="font-size:12px; font-weight:700;">18.4% / 400%</div></div>
                                    <div class="de-pv-icon pv-accent-bg">C</div>
                                </div>
                                <div class="de-pv-stat pv-card">
                                    <div><div style="font-size:10px; opacity:0.65;">Memory</div><div style="font-size:12px; font-weight:700;">2.4 / 8 GiB</div></div>
                                    <div class="de-pv-icon pv-accent-bg">R</div>
                                </div>
                                <div class="de-pv-stat pv-card">
                                    <div><div style="font-size:10px; opacity:0.65;">Disk</div><div style="font-size:12px; font-weight:700;">4.1 / 50 GiB</div></div>
                                    <div class="de-pv-icon pv-accent-bg">D</div>
                                </div>
                            </div>
                        </div>

                        <div id="pvDashboardView" style="display:none; flex:1;">
                            <div class="de-pv-cards">
                                <div class="de-pv-scard pv-card">
                                    <div class="de-pv-sbanner pv-banner">
                                        <strong style="font-size:13px; text-shadow:0 2px 8px #000;">Draco SMP</strong>
                                        <span style="background:#16a34a; font-size:9px; padding:2px 8px; border-radius:99px; margin-top:4px;">RUNNING</span>
                                    </div>
                                    <div style="padding:10px; font-size:11px; display:flex; justify-content:space-between;">
                                        <span>RAM: 2.4 GiB</span><span>CPU: 18%</span>
                                    </div>
                                </div>
                                <div class="de-pv-scard pv-card">
                                    <div class="de-pv-sbanner pv-banner">
                                        <strong style="font-size:13px; text-shadow:0 2px 8px #000;">Bedwars Arena</strong>
                                        <span style="background:#dc2626; font-size:9px; padding:2px 8px; border-radius:99px; margin-top:4px;">OFFLINE</span>
                                    </div>
                                    <div style="padding:10px; font-size:11px; display:flex; justify-content:space-between;">
                                        <span>RAM: 0 MB</span><span>CPU: 0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="pvLoginShell" style="display:none; position:relative; z-index:1; width:100%; height:100%; align-items:center; justify-content:center; padding:24px;">
                    <div id="pvLoginContainer" style="display:flex; width:100%; height:100%; align-items:center; justify-content:center;">
                        <div id="pvLoginCard" class="pv-card" style="width:280px; padding:22px; border-radius:16px; border:1px solid rgba(255,255,255,0.12);">
                            <div style="font-weight:800; font-size:15px;
