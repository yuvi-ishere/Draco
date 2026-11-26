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
    $cfg = $defaults;
    if (isset($dracoConfig) && is_array($dracoConfig)) {
        $cfg = array_merge($defaults, $dracoConfig);
    } else {
        try {
            $raw = app(\Pterodactyl\Contracts\Repository\SettingsRepositoryInterface::class)->get('draco::config');
            if (is_string($raw)) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) { $cfg = array_merge($defaults, $decoded); }
            }
        } catch (\Throwable $e) {}
    }
@endphp

<style>
.de-shell{display:flex;flex-direction:column;background:#0d1021;border:1px solid rgba(255,255,255,.09);border-radius:16px;overflow:hidden;color:#f3f4f6;font-family:'Plus Jakarta Sans',system-ui,sans-serif;min-height:720px;box-shadow:0 20px 50px rgba(0,0,0,.5)}
.de-header{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;background:#12162b;border-bottom:1px solid rgba(255,255,255,.08);flex-wrap:wrap;gap:10px}
.de-brand{display:flex;align-items:center;gap:10px;font-weight:700;font-size:15px}
.de-badge{width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#7c3aed,#3b82f6);display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff}
.de-ptabs{display:flex;gap:5px;background:rgba(0,0,0,.3);padding:4px;border-radius:9px}
.de-ptab{background:0 0;border:none;color:#94a3b8;padding:5px 11px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer}
.de-ptab.active{background:#7c3aed;color:#fff}
.de-body{display:grid;grid-template-columns:58px 330px 1fr;flex:1}
@media(max-width:1180px){.de-body{grid-template-columns:54px 1fr}.de-pv-col{grid-column:1/-1;min-height:420px;border-top:1px solid rgba(255,255,255,.08)}}
.de-rail{background:#0a0d1a;border-right:1px solid rgba(255,255,255,.07);display:flex;flex-direction:column;align-items:center;padding:12px 0;gap:8px}
.de-rbtn{width:40px;height:40px;border-radius:10px;background:0 0;border:1px solid transparent;color:#94a3b8;cursor:pointer;display:flex;align-items:center;justify-content:center}
.de-rbtn:hover{background:rgba(255,255,255,.06);color:#fff}
.de-rbtn.active{background:rgba(124,58,237,.22);color:#fff;border-color:rgba(124,58,237,.55)}
.de-drawer{background:#101428;border-right:1px solid rgba(255,255,255,.07);display:flex;flex-direction:column;max-height:700px}
.de-scroll{padding:16px;overflow-y:auto;flex:1}
.de-foot{padding:12px 16px;background:#0d1021;border-top:1px solid rgba(255,255,255,.08);display:flex;gap:8px}
.de-pane{display:none}.de-pane.active{display:block}
.de-title{font-size:15px;font-weight:700;margin:0 0 4px;color:#fff}
.de-sub{font-size:12px;color:#94a3b8;margin:0 0 14px}
.de-f{margin-bottom:13px}
.de-lbl{display:flex;justify-content:space-between;align-items:center;font-size:12px;font-weight:600;color:#cbd5e1;margin-bottom:5px}
.de-val{background:rgba(124,58,237,.22);color:#c4b5fd;padding:2px 7px;border-radius:6px;font-size:11px}
.de-in,.de-ta{width:100%;background:#090c18!important;color:#f3f4f6!important;border:1px solid rgba(255,255,255,.1)!important;border-radius:8px!important;padding:8px 10px!important;font-size:12.5px!important}
.de-rng{width:100%;accent-color:#7c3aed;cursor:pointer}
.de-cgrid{display:grid;grid-template-columns:1fr 1fr;gap:9px}
.de-cbox{display:flex;align-items:center;gap:7px;background:#090c18;border:1px solid rgba(255,255,255,.1);padding:5px 8px;border-radius:8px}
.de-cbox input[type=color]{width:26px;height:26px;border:none;background:0 0;cursor:pointer;padding:0}
.de-cbox span{font-size:11px;color:#cbd5e1;font-family:monospace}
.de-tog{display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);padding:9px 11px;border-radius:9px;margin-bottom:10px;cursor:pointer;font-size:12px}
.de-tog input{width:17px;height:17px;accent-color:#7c3aed;cursor:pointer}
.de-presets{display:grid;grid-template-columns:1fr 1fr;gap:7px;margin-bottom:14px}
.de-pbtn{padding:7px 9px;border-radius:8px;border:1px solid rgba(255,255,255,.1);background:#090c18;color:#e2e8f0;font-size:12px;font-weight:600;display:flex;align-items:center;gap:7px;cursor:pointer}
.de-pbtn:hover{border-color:#7c3aed}
.de-dot{width:11px;height:11px;border-radius:50%;flex-shrink:0}
.de-lcard{display:block;border:2px solid rgba(255,255,255,.1);border-radius:11px;padding:10px;background:#0a0d1c;cursor:pointer;margin-bottom:9px}
.de-lcard.selected{border-color:#7c3aed;background:rgba(124,58,237,.14)}
.de-lcard input{display:none}
.de-wf{height:64px;border-radius:7px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);padding:7px;display:flex;gap:7px}
.de-wff{background:rgba(255,255,255,.09);border-radius:5px;padding:6px;display:flex;flex-direction:column;justify-content:center;gap:4px}
.de-wfb{height:6px;border-radius:3px;background:rgba(255,255,255,.22)}
.de-wfi{flex:1;border-radius:5px;background:linear-gradient(135deg,rgba(124,58,237,.35),rgba(59,130,246,.3));border:1px dashed rgba(255,255,255,.2)}
.de-save{flex:1;padding:10px;border:none;border-radius:9px;background:linear-gradient(135deg,#7c3aed,#4f46e5);color:#fff;font-weight:700;font-size:13px;cursor:pointer}
.de-rst{padding:10px 12px;border:1px solid rgba(239,68,68,.4);border-radius:9px;background:rgba(239,68,68,.12);color:#fca5a5;font-weight:600;font-size:12px;cursor:pointer}
.de-pv-col{padding:16px;background:#070914;display:flex;flex-direction:column}
.de-stage{flex:1;border-radius:13px;border:1px solid rgba(255,255,255,.1);overflow:hidden;position:relative;display:flex;background-size:cover;background-position:center;min-height:560px}
.de-dim{position:absolute;inset:0;pointer-events:none;z-index:0}
.de-pvshell{position:relative;z-index:1;display:flex;width:100%;height:100%}
.de-pvside{width:185px;padding:12px 9px;border-right:1px solid rgba(255,255,255,.08);display:flex;flex-direction:column;gap:9px;flex-shrink:0}
.de-pvmain{flex:1;display:flex;flex-direction:column;padding:12px;gap:10px;overflow:hidden}
.de-pvtop{display:flex;justify-content:space-between;align-items:center;padding:8px 11px;border-radius:9px;border:1px solid rgba(255,255,255,.08)}
.de-pvann{padding:7px 11px;border-radius:8px;font-size:11.5px;border-left:3px solid #f59e0b;background:rgba(255,255,255,.06)}
.de-pvcat{font-size:9px;font-weight:700;letter-spacing:.12em;opacity:.55;margin:5px 0 2px 5px}
.de-pvitem{padding:5px 8px;border-radius:6px;font-size:11px}
.de-pvcon{flex:1;min-height:200px;border-radius:11px;border:1px solid rgba(255,255,255,.08);padding:11px;display:flex;flex-direction:column;justify-content:space-between;font-family:monospace;font-size:11px}
.de-pvstats{display:grid;grid-template-columns:repeat(3,1fr);gap:9px}
.de-pvstat{padding:10px;border-radius:11px;border:1px solid rgba(255,255,255,.08);display:flex;justify-content:space-between;align-items:center}
.de-pvico{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:11px}
.de-pvcards{display:grid;grid-template-columns:1fr 1fr;gap:11px}
.de-pvscard{border-radius:11px;overflow:hidden;border:1px solid rgba(255,255,255,.09)}
.de-pvsban{height:74px;background-size:cover;background-position:center;display:flex;flex-direction:column;align-items:center;justify-content:center}
</style>

<form method="POST" action="" id="dracoEditorForm">
@csrf
@method('PATCH')
<input type="hidden" name="draco_action" id="dracoActionInput" value="save">

<div class="de-shell">
    <div class="de-header">
        <div class="de-brand">
            <div class="de-badge">D</div>
            <span>Draco Editor</span>
            <span style="font-size:11px;color:#94a3b8;font-weight:500;">v3.0 Live Customizer</span>
        </div>
        <div class="de-ptabs">
            <button type="button" class="de-ptab active" data-pmode="console">Console View</button>
            <button type="button" class="de-ptab" data-pmode="dashboard">2-Col Cards</button>
            <button type="button" class="de-ptab" data-pmode="login">Login Screen</button>
        </div>
    </div>

    <div class="de-body">
        <div class="de-rail">
            <button type="button" class="de-rbtn active" data-tab="bg" title="Background & Glass"><i class="fa fa-image"></i></button>
            <button type="button" class="de-rbtn" data-tab="colors" title="Colors & Presets"><i class="fa fa-paint-brush"></i></button>
            <button type="button" class="de-rbtn" data-tab="login" title="Login Layout"><i class="fa fa-columns"></i></button>
            <button type="button" class="de-rbtn" data-tab="dashboard" title="Dashboard Cards"><i class="fa fa-th-large"></i></button>
            <button type="button" class="de-rbtn" data-tab="branding" title="Branding & Links"><i class="fa fa-bullhorn"></i></button>
            <button type="button" class="de-rbtn" data-tab="advanced" title="Advanced & CSS"><i class="fa fa-code"></i></button>
        </div>

        <div class="de-drawer">
            <div class="de-scroll">

                <div class="de-pane active" id="tab-bg">
                    <h4 class="de-title">Background &amp; Glass</h4>
                    <p class="de-sub">Custom wallpaper, blurriness aur transparency set karein.</p>
                    <div class="de-f">
                        <label class="de-lbl">Background Image URL</label>
                        <input type="text" class="de-in" name="bg_url" id="f_bg_url" value="{{ $cfg['bg_url'] }}" placeholder="https://.../wallpaper.jpg">
                    </div>
                    <div class="de-f">
                        <label class="de-lbl">Card Blurriness <span class="de-val" id="v_blur">{{ $cfg['bg_blur'] }}px</span></label>
                        <input type="range" class="de-rng" name="bg_blur" id="f_bg_blur" min="0" max="30" value="{{ $cfg['bg_blur'] }}">
                    </div>
                    <div class="de-f">
                        <label class="de-lbl">Card Transparency / Opacity <span class="de-val" id="v_opacity">{{ $cfg['card_opacity'] }}%</span></label>
                        <input type="range" class="de-rng" name="card_opacity" id="f_card_opacity" min="20" max="100" value="{{ $cfg['card_opacity'] }}">
                    </div>
                    <div class="de-f">
                        <label class="de-lbl">Background Dimmer <span class="de-val" id="v_dim">{{ $cfg['bg_dim'] }}%</span></label>
                        <input type="range" class="de-rng" name="bg_dim" id="f_bg_dim" min="0" max="95" value="{{ $cfg['bg_dim'] }}">
                    </div>
                    <label class="de-tog">
                        <span>Ambient Nebula Glow</span>
                        <input type="checkbox" name="ambient_glow" id="f_ambient_glow" {{ $cfg['ambient_glow'] ? 'checked' : '' }}>
                    </label>
                </div>

                <div class="de-pane" id="tab-colors">
                    <h4 class="de-title">Colors &amp; Presets</h4>
                    <p class="de-sub">1-click preset choose karein ya custom colors set karein.</p>
                    <div class="de-presets">
                        <button type="button" class="de-pbtn" onclick="applyDracoPreset('nebula')"><span class="de-dot" style="background:#7c3aed"></span>Nebula Violet</button>
                        <button type="button" class="de-pbtn" onclick="applyDracoPreset('crimson')"><span class="de-dot" style="background:#ef4444"></span>Draco Crimson</button>
                        <button type="button" class="de-pbtn" onclick="applyDracoPreset('emerald')"><span class="de-dot" style="background:#10b981"></span>Cyber Emerald</button>
                        <button type="button" class="de-pbtn" onclick="applyDracoPreset('ocean')"><span class="de-dot" style="background:#0ea5e9"></span>Midnight Blue</button>
                    </div>
                    <div class="de-cgrid">
                        <div class="de-f"><label class="de-lbl">Primary Accent</label><div class="de-cbox"><input type="color" name="accent_primary" id="f_accent_primary" value="{{ $cfg['accent_primary'] }}"><span>{{ $cfg['accent_primary'] }}</span></div></div>
                        <div class="de-f"><label class="de-lbl">Secondary Glow</label><div class="de-cbox"><input type="color" name="accent_secondary" id="f_accent_secondary" value="{{ $cfg['accent_secondary'] }}"><span>{{ $cfg['accent_secondary'] }}</span></div></div>
                        <div class="de-f"><label class="de-lbl">Base Background</label><div class="de-cbox"><input type="color" name="bg_color" id="f_bg_color" value="{{ $cfg['bg_color'] }}"><span>{{ $cfg['bg_color'] }}</span></div></div>
                        <div class="de-f"><label class="de-lbl">Sidebar Surface</label><div class="de-cbox"><input type="color" name="sidebar_color" id="f_sidebar_color" value="{{ $cfg['sidebar_color'] }}"><span>{{ $cfg['sidebar_color'] }}</span></div></div>
                        <div class="de-f"><label class="de-lbl">Card Surface</label><div class="de-cbox"><input type="color" name="card_color" id="f_card_color" value="{{ $cfg['card_color'] }}"><span>{{ $cfg['card_color'] }}</span></div></div>
                        <div class="de-f"><label class="de-lbl">Console Box</label><div class="de-cbox"><input type="color" name="console_color" id="f_console_color" value="{{ $cfg['console_color'] }}"><span>{{ $cfg['console_color'] }}</span></div></div>
                        <div class="de-f"><label class="de-lbl">Primary Text</label><div class="de-cbox"><input type="color" name="text_color" id="f_text_color" value="{{ $cfg['text_color'] }}"><span>{{ $cfg['text_color'] }}</span></div></div>
                        <div class="de-f"><label class="de-lbl">Muted Text</label><div class="de-cbox"><input type="color" name="muted_color" id="f_muted_color" value="{{ $cfg['muted_color'] }}"><span>{{ $cfg['muted_color'] }}</span></div></div>
                    </div>
                </div>

                <div class="de-pane" id="tab-login">
                    <h4 class="de-title">Login Layout Settings</h4>
                    <p class="de-sub">Login screen ke 3 layouts me se choose karein.</p>
                    <label class="de-lcard {{ $cfg['login_layout'] == 1 ? 'selected' : '' }}">
                        <input type="radio" name="login_layout" value="1" {{ $cfg['login_layout'] == 1 ? 'checked' : '' }}>
                        <div class="de-wf" style="justify-content:center"><div class="de-wff" style="width:52%"><div class="de-wfb"></div><div class="de-wfb"></div><div class="de-wfb"></div></div></div>
                        <div style="font-size:12px;font-weight:600;margin-top:6px">1. Centered Glass Card</div>
                    </label>
                    <label class="de-lcard {{ $cfg['login_layout'] == 2 ? 'selected' : '' }}">
                        <input type="radio" name="login_layout" value="2" {{ $cfg['login_layout'] == 2 ? 'checked' : '' }}>
                        <div class="de-wf" style="padding:0;overflow:hidden"><div class="de-wff" style="width:45%;border-radius:0"><div class="de-wfb"></div><div class="de-wfb"></div><div class="de-wfb"></div></div><div class="de-wfi" style="border-radius:0;border:none"></div></div>
                        <div style="font-size:12px;font-weight:600;margin-top:6px">2. Split Screen (Left Form + Right Art)</div>
                    </label>
                    <label class="de-lcard {{ $cfg['login_layout'] == 3 ? 'selected' : '' }}">
                        <input type="radio" name="login_layout" value="3" {{ $cfg['login_layout'] == 3 ? 'checked' : '' }}>
                        <div class="de-wf"><div class="de-wff" style="width:44%"><div class="de-wfb"></div><div class="de-wfb"></div><div class="de-wfb"></div></div><div class="de-wfi"></div></div>
                        <div style="font-size:12px;font-weight:600;margin-top:6px">3. Framed Split Card</div>
                    </label>
                    <div class="de-f" style="margin-top:12px">
                        <label class="de-lbl">Login Wallpaper URL (Optional)</label>
                        <input type="text" class="de-in" name="login_bg_url" id="f_login_bg_url" value="{{ $cfg['login_bg_url'] }}" placeholder="Blank = main background URL">
                    </div>
                </div>

                <div class="de-pane" id="tab-dashboard">
                    <h4 class="de-title">Dashboard &amp; Server Cards</h4>
                    <p class="de-sub">2-column banner cards aur banner image set karein.</p>
                    <label class="de-tog">
                        <span>2-Column Banner Server Cards</span>
                        <input type="checkbox" name="server_grid" id="f_server_grid" {{ $cfg['server_grid'] ? 'checked' : '' }}>
                    </label>
                    <div class="de-f">
                        <label class="de-lbl">Server Card Banner URL</label>
                        <input type="text" class="de-in" name="banner_url" id="f_banner_url" value="{{ $cfg['banner_url'] }}" placeholder="https://.../banner.jpg">
                    </div>
                </div>

                <div class="de-pane" id="tab-branding">
                    <h4 class="de-title">Branding &amp; Links</h4>
                    <p class="de-sub">Panel naam, logo, announcement aur footer links.</p>
                    <div class="de-f"><label class="de-lbl">Panel Name</label><input type="text" class="de-in" name="panel_name" id="f_panel_name" value="{{ $cfg['panel_name'] }}"></div>
                    <div class="de-f"><label class="de-lbl">Logo Image URL</label><input type="text" class="de-in" name="logo_url" id="f_logo_url" value="{{ $cfg['logo_url'] }}" placeholder="https://.../logo.png"></div>
                    <label class="de-tog"><span>Show Announcement Banner</span><input type="checkbox" name="announcement_enabled" id="f_announcement_enabled" {{ $cfg['announcement_enabled'] ? 'checked' : '' }}></label>
                    <div class="de-f"><label class="de-lbl">Announcement Text</label><input type="text" class="de-in" name="announcement_text" id="f_announcement_text" value="{{ $cfg['announcement_text'] }}"></div>
                    <div class="de-f"><label class="de-lbl">Announcement Accent</label><div class="de-cbox"><input type="color" name="announcement_color" id="f_announcement_color" value="{{ $cfg['announcement_color'] }}"><span>{{ $cfg['announcement_color'] }}</span></div></div>
                    <div class="de-f"><label class="de-lbl">Discord URL</label><input type="text" class="de-in" name="discord_url" value="{{ $cfg['discord_url'] }}" placeholder="https://discord.gg/..."></div>
                    <div class="de-f"><label class="de-lbl">Support URL</label><input type="text" class="de-in" name="support_url" value="{{ $cfg['support_url'] }}" placeholder="https://..."></div>
                    <div class="de-f"><label class="de-lbl">Footer Text</label><input type="text" class="de-in" name="footer_text" value="{{ $cfg['footer_text'] }}"></div>
                    <div class="de-f">
                        <label class="de-lbl">Footer Links (About / Privacy / Terms)</label>
                        <input type="text" class="de-in" name="footer_about" value="{{ $cfg['footer_about'] }}" placeholder="About URL" style="margin-bottom:5px">
                        <input type="text" class="de-in" name="footer_privacy" value="{{ $cfg['footer_privacy'] }}" placeholder="Privacy URL" style="margin-bottom:5px">
                        <input type="text" class="de-in" name="footer_terms" value="{{ $cfg['footer_terms'] }}" placeholder="Terms URL">
                    </div>
                </div>

                <div class="de-pane" id="tab-advanced">
                    <h4 class="de-title">Advanced Settings</h4>
                    <p class="de-sub">Admin panel theme sync aur Custom CSS.</p>
                    <label class="de-tog"><span>Sync Admin Panel with Draco Theme</span><input type="checkbox" name="sync_admin" {{ $cfg['sync_admin'] ? 'checked' : '' }}></label>
                    <div class="de-f"><label class="de-lbl">Custom CSS</label><textarea class="de-ta" name="custom_css" rows="9" placeholder="/* Extra CSS */">{{ $cfg['custom_css'] }}</textarea></div>
                </div>

            </div>
            <div class="de-foot">
                <button type="submit" class="de-save" onclick="document.getElementById('dracoActionInput').value='save'">Save Changes</button>
                <button type="submit" class="de-rst" onclick="if(!confirm('Reset Draco theme to default?'))return false;document.getElementById('dracoActionInput').value='reset'">Reset</button>
            </div>
        </div>

        <div class="de-pv-col">
            <div class="de-stage" id="pvStage">
                <div class="de-dim" id="pvDim"></div>

                <div class="de-pvshell" id="pvAppShell">
                    <div class="de-pvside" id="pvSidebar">
                        <div style="display:flex;align-items:center;gap:8px;font-weight:700;font-size:13.5px">
                            <div id="pvLogoMark" style="width:24px;height:24px;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800">D</div>
                            <span id="pvPanelName">{{ $cfg['panel_name'] }}</span>
                        </div>
                        <div style="padding:7px;border-radius:8px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07)">
                            <div style="font-size:11.5px;font-weight:700">Draco SMP</div>
                            <div style="font-size:10px;opacity:.65">play.novamc.in:25565</div>
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:4px;margin-top:7px">
                                <div style="background:#16a34a;height:20px;border-radius:5px;text-align:center;line-height:20px;font-size:9px">▶</div>
                                <div style="background:#334155;height:20px;border-radius:5px;text-align:center;line-height:20px;font-size:9px">↻</div>
                                <div style="background:#dc2626;height:20px;border-radius:5px;text-align:center;line-height:20px;font-size:9px">■</div>
                            </div>
                        </div>
                        <div>
                            <div class="de-pvcat">GENERAL</div>
                            <div class="de-pvitem">Dashboard</div>
                            <div class="de-pvitem" id="pvActiveNav">Console</div>
                            <div class="de-pvcat">MANAGEMENT</div>
                            <div class="de-pvitem">Files</div>
                            <div class="de-pvitem">Databases</div>
                            <div class="de-pvitem">Backups</div>
                            <div class="de-pvcat">ADDONS</div>
                            <div class="de-pvitem">Plugins &amp; Mods</div>
                            <div class="de-pvitem">Egg Changer</div>
                        </div>
                    </div>

                    <div class="de-pvmain">
                        <div class="de-pvtop" id="pvTopbar">
                            <span style="font-size:12px;font-weight:600">Draco SMP</span>
                            <div style="display:flex;gap:10px;font-size:11px;opacity:.85"><span>Discord</span><span>Support</span><span>Account</span></div>
                        </div>
                        <div class="de-pvann" id="pvAnn">{{ $cfg['announcement_text'] }}</div>

                        <div id="pvConsoleView" style="display:flex;flex-direction:column;gap:10px;flex:1">
                            <div class="de-pvcon" id="pvConsoleBox">
                                <div style="opacity:.8">[Draco Daemon]: Server online on 0.0.0.0:25565<br>[Server/INFO]: Done (2.8s)! Type "help"</div>
                                <div style="padding:6px 9px;border-radius:6px;background:rgba(255,255,255,.06);opacity:.7">&raquo; Type a command...</div>
                            </div>
                            <div class="de-pvstats">
                                <div class="de-pvstat pv-card"><div><div style="font-size:10px;opacity:.65">CPU</div><div style="font-size:11.5px;font-weight:700">18% / 400%</div></div><div class="de-pvico pv-acc">C</div></div>
                                <div class="de-pvstat pv-card"><div><div style="font-size:10px;opacity:.65">RAM</div><div style="font-size:11.5px;font-weight:700">2.4 / 8 GiB</div></div><div class="de-pvico pv-acc">R</div></div>
                                <div class="de-pvstat pv-card"><div><div style="font-size:10px;opacity:.65">Disk</div><div style="font-size:11.5px;font-weight:700">4 / 50 GiB</div></div><div class="de-pvico pv-acc">D</div></div>
                            </div>
                        </div>

                        <div id="pvDashboardView" style="display:none;flex:1">
                            <div class="de-pvcards">
                                <div class="de-pvscard pv-card">
                                    <div class="de-pvsban pv-ban"><strong style="font-size:12px;text-shadow:0 2px 6px #000">Draco SMP</strong><span style="background:#16a34a;font-size:9px;padding:2px 7px;border-radius:99px;margin-top:3px">RUNNING</span></div>
                                    <div style="padding:9px;font-size:11px;display:flex;justify-content:space-between"><span>RAM: 2.4 GiB</span><span>CPU: 18%</span></div>
                                </div>
                                <div class="de-pvscard pv-card">
                                    <div class="de-pvsban pv-ban"><strong style="font-size:12px;text-shadow:0 2px 6px #000">Bedwars</strong><span style="background:#dc2626;font-size:9px;padding:2px 7px;border-radius:99px;margin-top:3px">OFFLINE</span></div>
                                    <div style="padding:9px;font-size:11px;display:flex;justify-content:space-between"><span>RAM: 0 MB</span><span>CPU: 0%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="pvLoginShell" style="display:none;position:relative;z-index:1;width:100%;height:100%;align-items:center;justify-content:center;padding:20px">
                    <div id="pvLoginWrap" style="display:flex;width:100%;height:100%;align-items:center;justify-content:center">
                        <div id="pvLoginCard" class="pv-card" style="width:260px;padding:20px;border-radius:15px;border:1px solid rgba(255,255,255,.12)">
                            <div style="font-weight:800;font-size:14px;margin-bottom:12px" id="pvLoginTitle">DRACO PANEL</div>
                            <div style="height:30px;border-radius:7px;background:rgba(0,0,0,.35);margin-bottom:9px"></div>
                            <div style="height:30px;border-radius:7px;background:rgba(0,0,0,.35);margin-bottom:13px"></div>
                            <div class="pv-acc" style="height:32px;border-radius:7px;text-align:center;line-height:32px;font-size:12px;font-weight:700;color:#fff">Login</div>
                        </div>
                        <div id="pvLoginArt" style="display:none;flex:1;height:100%;background-size:cover;background-position:center;border-radius:11px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
(function(){
    var presets={
        nebula:{accent_primary:'#7c3aed',accent_secondary:'#3b82f6',bg_color:'#090b16',sidebar_color:'#0d1021',card_color:'#14182e',console_color:'#070914'},
        crimson:{accent_primary:'#ef4444',accent_secondary:'#f97316',bg_color:'#0b0709',sidebar_color:'#140b0e',card_color:'#1e1116',console_color:'#090507'},
        emerald:{accent_primary:'#10b981',accent_secondary:'#06b6d4',bg_color:'#060d0c',sidebar_color:'#0a1614',card_color:'#10211e',console_color:'#050a09'},
        ocean:{accent_primary:'#0ea5e9',accent_secondary:'#6366f1',bg_color:'#060b16',sidebar_color:'#0b1325',card_color:'#121d36',console_color:'#050912'}
    };
    window.applyDracoPreset=function(n){
        var p=presets[n];if(!p)return;
        Object.keys(p).forEach(function(k){
            var el=document.getElementById('f_'+k);
            if(el){el.value=p[k];if(el.nextElementSibling)el.nextElementSibling.textContent=p[k];}
        });
        updatePreview();
    };
    function hexRgb(h){
        h=(h||'#14182e').replace('#','');
        return [parseInt(h.substr(0,2),16)||20,parseInt(h.substr(2,2),16)||24,parseInt(h.substr(4,2),16)||46].join(',');
    }
    var pmode='console';
    function setMode(m){
        pmode=m;
        document.querySelectorAll('.de-ptab').forEach(function(b){b.classList.toggle('active',b.dataset.pmode===m);});
        document.getElementById('pvAppShell').style.display=m==='login'?'none':'flex';
        document.getElementById('pvLoginShell').style.display=m==='login'?'flex':'none';
        document.getElementById('pvConsoleView').style.display=m==='console'?'flex':'none';
        document.getElementById('pvDashboardView').style.display=m==='dashboard'?'block':'none';
        updatePreview();
    }
    document.querySelectorAll('.de-ptab').forEach(function(b){b.addEventListener('click',function(){setMode(b.dataset.pmode);});});
    document.querySelectorAll('.de-rbtn').forEach(function(b){
        b.addEventListener('click',function(){
            document.querySelectorAll('.de-rbtn').forEach(function(x){x.classList.remove('active');});
            document.querySelectorAll('.de-pane').forEach(function(x){x.classList.remove('active');});
            b.classList.add('active');
            var p=document.getElementById('tab-'+b.dataset.tab);if(p)p.classList.add('active');
            if(b.dataset.tab==='login')setMode('login');
            else if(b.dataset.tab==='dashboard')setMode('dashboard');
            else if(pmode==='login')setMode('console');
        });
    });
    document.querySelectorAll('.de-lcard input').forEach(function(r){
        r.addEventListener('change',function(){
            document.querySelectorAll('.de-lcard').forEach(function(c){c.classList.remove('selected');});
            r.closest('.de-lcard').classList.add('selected');
            updatePreview();
        });
    });
    function updatePreview(){
        var bgUrl=document.getElementById('f_bg_url').value.trim();
        var loginBg=document.getElementById('f_login_bg_url').value.trim()||bgUrl;
        var blur=document.getElementById('f_bg_blur').value;
        var op=document.getElementById('f_card_opacity').value/100;
        var dim=document.getElementById('f_bg_dim').value/100;
        var a1=document.getElementById('f_accent_primary').value;
        var a2=document.getElementById('f_accent_secondary').value;
        var bgC=document.getElementById('f_bg_color').value;
        var sC=document.getElementById('f_sidebar_color').value;
        var cC=document.getElementById('f_card_color').value;
        var conC=document.getElementById('f_console_color').value;
        var tC=document.getElementById('f_text_color').value;
        var pName=document.getElementById('f_panel_name').value||'Draco';
        var banUrl=document.getElementById('f_banner_url').value.trim();
        var annOn=document.getElementById('f_announcement_enabled').checked;
        var annTxt=document.getElementById('f_announcement_text').value;
        var annC=document.getElementById('f_announcement_color').value;
        var lay=(document.querySelector('input[name="login_layout"]:checked')||{value:'1'}).value;

        document.getElementById('v_blur').textContent=blur+'px';
        document.getElementById('v_opacity').textContent=Math.round(op*100)+'%';
        document.getElementById('v_dim').textContent=Math.round(dim*100)+'%';

        var st=document.getElementById('pvStage');
        st.style.backgroundColor=bgC;st.style.color=tC;
        var curBg=pmode==='login'?loginBg:bgUrl;
        st.style.backgroundImage=curBg?"url('"+curBg+"')":'radial-gradient(circle at 18% 18%,rgba('+hexRgb(a1)+',.28),transparent 45%),radial-gradient(circle at 85% 85%,rgba('+hexRgb(a2)+',.24),transparent 45%)';
        document.getElementById('pvDim').style.background=curBg?'rgba(5,7,14,'+dim+')':'transparent';

        var sb=document.getElementById('pvSidebar');
        sb.style.background='rgba('+hexRgb(sC)+','+op+')';sb.style.backdropFilter='blur('+blur+'px)';
        var tb=document.getElementById('pvTopbar');
        tb.style.background='rgba('+hexRgb(cC)+','+op+')';tb.style.backdropFilter='blur('+blur+'px)';

        document.getElementById('pvConsoleBox').style.background='rgba('+hexRgb(conC)+','+Math.min(1,op+.1)+')';
        document.getElementById('pvActiveNav').style.background='linear-gradient(90deg,rgba('+hexRgb(a1)+',.35),transparent)';
        document.getElementById('pvActiveNav').style.borderLeft='2px solid '+a1;
        document.getElementById('pvLogoMark').style.background='linear-gradient(135deg,'+a1+','+a2+')';
        document.getElementById('pvPanelName').textContent=pName;
        document.getElementById('pvLoginTitle').textContent=pName.toUpperCase()+' PANEL';

        var ann=document.getElementById('pvAnn');
        ann.style.display=annOn&&annTxt?'block':'none';ann.textContent=annTxt;ann.style.borderLeftColor=annC;

        document.querySelectorAll('.pv-card').forEach(function(el){el.style.background='rgba('+hexRgb(cC)+','+op+')';el.style.backdropFilter='blur('+blur+'px)';});
        document.querySelectorAll('.pv-acc').forEach(function(el){el.style.background='linear-gradient(135deg,'+a1+','+a2+')';});
        document.querySelectorAll('.pv-ban').forEach(function(el){el.style.backgroundImage=banUrl?"linear-gradient(to bottom,rgba(0,0,0,.2),rgba(0,0,0,.75)),url('"+banUrl+"')":'linear-gradient(135deg,'+a1+','+a2+')';});

        var lw=document.getElementById('pvLoginWrap'),la=document.getElementById('pvLoginArt'),lc=document.getElementById('pvLoginCard');
        var art=loginBg||banUrl;
        la.style.backgroundImage=art?"url('"+art+"')":'linear-gradient(135deg,'+a1+','+a2+')';
        if(lay==='1'){lw.style.gap='0';lw.style.maxWidth='100%';la.style.display='none';lc.style.width='260px';lc.style.height='auto';}
        else if(lay==='2'){lw.style.gap='0';lw.style.maxWidth='100%';la.style.display='block';la.style.height='100%';lc.style.width='230px';lc.style.height='100%';}
        else{lw.style.gap='10px';lw.style.maxWidth='520px';la.style.display='block';la.style.height='240px';lc.style.width='230px';lc.style.height='240px';}
    }
    document.querySelectorAll('#dracoEditorForm input,#dracoEditorForm textarea').forEach(function(el){
        el.addEventListener('input',function(){if(el.type==='color'&&el.nextElementSibling)el.nextElementSibling.textContent=el.value;updatePreview();});
        el.addEventListener('change',updatePreview);
    });
    updatePreview();
})();
</script>
<!-- END DRACO VIEW -->
