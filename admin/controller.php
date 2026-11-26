<?php

namespace Pterodactyl\Http\Controllers\Admin\Extensions\draco;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory as ViewFactory;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class dracoExtensionController extends Controller
{
    public function __construct(
        private ViewFactory $view,
        private SettingsRepositoryInterface $settings,
    ) {}

    public static function defaults(): array
    {
        return [
            'panel_name'           => 'Draco',
            'logo_url'             => '',
            'bg_url'               => '',
            'bg_blur'              => 16,
            'card_opacity'         => 78,
            'bg_dim'               => 55,
            'ambient_glow'         => 1,
            'accent_primary'       => '#7c3aed',
            'accent_secondary'     => '#3b82f6',
            'bg_color'             => '#090b16',
            'sidebar_color'        => '#0d1021',
            'card_color'           => '#14182e',
            'console_color'        => '#070914',
            'text_color'           => '#f3f4f6',
            'muted_color'          => '#94a3b8',
            'login_layout'         => 1,
            'login_bg_url'         => '',
            'banner_url'           => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
            'server_grid'          => 1,
            'announcement_enabled' => 1,
            'announcement_text'    => 'Welcome to Draco Panel — High Performance Game Hosting!',
            'announcement_color'   => '#f59e0b',
            'discord_url'          => '',
            'support_url'          => '',
            'footer_text'          => '© 2026 Draco Panel',
            'footer_about'         => '',
            'footer_privacy'       => '',
            'footer_terms'         => '',
            'sync_admin'           => 1,
            'custom_css'           => '',
        ];
    }

    private function resolveBlueprint(): mixed
    {
        $candidates = [
            '\\Pterodactyl\\BlueprintFramework\\Libraries\\ExtensionLibrary\\Admin\\BlueprintAdminLibrary',
            '\\Pterodactyl\\BlueprintFramework\\Libraries\\ExtensionLibrary\\BlueprintExtensionLibrary',
        ];
        foreach ($candidates as$class) {
            if (class_exists($class)) {
                try {
                    return app($class);
                } catch (\Throwable $e) {
                    // Fallback safely if container resolution fails
                }
            }
        }
        return null;
    }

    private function getConfig(): array
    {
        $defaults = self::defaults();
        try {
            $raw = $this->settings->get('draco::config');$saved = is_string($raw) ? json_decode($raw, true) : [];
            return array_merge($defaults, is_array($saved) ?$saved : []);
        } catch (\Throwable $e) {
            return $defaults;
        }
    }

    private function cleanHex(?string $value, string$fallback): string
    {
        $v = trim((string)$value);
        return preg_match('/^#[0-9a-fA-F]{6}$/',$v) ? $v :$fallback;
    }

    private function flashSuccess(string $message): void
    {
        try {
            if (class_exists('\\Prologue\\Alerts\\AlertsMessageBag')) {
                app('\\Prologue\\Alerts\\AlertsMessageBag')->success($message)->flash();
                return;
            }
        } catch (\Throwable $e) {}
        session()->flash('draco_status', $message);
    }

    public function index(): View
    {
        return $this->view->make('admin.extensions.draco.index', [
            'blueprint'   => $this->resolveBlueprint(),
            'root'        => '/admin/extensions/draco',
            'dracoConfig' => $this->getConfig(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $defaults = self::defaults();

        if ($request->input('draco_action') === 'reset') {$this->settings->set('draco::config', json_encode($defaults));$this->flashSuccess('Draco theme default settings par reset ho gaya hai!');
            return redirect('/admin/extensions/draco');
        }

        $config = [
            'panel_name'           => mb_substr(trim((string) $request->input('panel_name',$defaults['panel_name'])), 0, 40) ?: 'Draco',
            'logo_url'             => trim((string) $request->input('logo_url', '')),
            'bg_url'               => trim((string) $request->input('bg_url', '')),
            'bg_blur'              => max(0, min(30, (int) $request->input('bg_blur',$defaults['bg_blur']))),
            'card_opacity'         => max(20, min(100, (int) $request->input('card_opacity',$defaults['card_opacity']))),
            'bg_dim'               => max(0, min(95, (int) $request->input('bg_dim',$defaults['bg_dim']))),
            'ambient_glow'         => $request->has('ambient_glow') ? 1 : 0, 'accent_primary'       =>$this->cleanHex($request->input('accent_primary'),$defaults['accent_primary']),
            'accent_secondary'     => $this->cleanHex($request->input('accent_secondary'),$defaults['accent_secondary']),
            'bg_color'             => $this->cleanHex($request->input('bg_color'),$defaults['bg_color']),
            'sidebar_color'        => $this->cleanHex($request->input('sidebar_color'),$defaults['sidebar_color']),
            'card_color'           => $this->cleanHex($request->input('card_color'),$defaults['card_color']),
            'console_color'        => $this->cleanHex($request->input('console_color'),$defaults['console_color']),
            'text_color'           => $this->cleanHex($request->input('text_color'),$defaults['text_color']),
            'muted_color'          => $this->cleanHex($request->input('muted_color'),$defaults['muted_color']),
            'login_layout'         => in_array((int) $request->input('login_layout', 1), [1, 2, 3], true) ? (int) $request->input('login_layout', 1) : 1, 'login_bg_url'         => trim((string)$request->input('login_bg_url', '')),
            'banner_url'           => trim((string) $request->input('banner_url',$defaults['banner_url'])),
            'server_grid'          => $request->has('server_grid') ? 1 : 0, 'announcement_enabled' =>$request->has('announcement_enabled') ? 1 : 0,
            'announcement_text'    => mb_substr(trim((string) $request->input('announcement_text', '')), 0, 260), 'announcement_color'   =>$this->cleanHex($request->input('announcement_color'),$defaults['announcement_color']),
            'discord_url'          => trim((string) $request->input('discord_url', '')),
            'support_url'          => trim((string) $request->input('support_url', '')),
            'footer_text'          => mb_substr(trim((string) $request->input('footer_text', $defaults['footer_text'])), 0, 120), 'footer_about'         => trim((string)$request->input('footer_about', '')),
            'footer_privacy'       => trim((string) $request->input('footer_privacy', '')),
            'footer_terms'         => trim((string) $request->input('footer_terms', '')),
            'sync_admin'           => $request->has('sync_admin') ? 1 : 0, 'custom_css'           => (string)$request->input('custom_css', ''),
        ];

        $this->settings->set('draco::config', json_encode($config));$this->flashSuccess('Draco theme save ho gaya hai — sabhi servers par apply ho chuka hai!');

        return redirect('/admin/extensions/draco');
    }

    public function post(Request $request): RedirectResponse
    {
        return $this->update($request);
    }

    public function patch(Request $request): RedirectResponse
    {
        return $this->update($request);
    }
}
