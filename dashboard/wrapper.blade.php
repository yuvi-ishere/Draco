<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<div class="draco-ambient-bg" aria-hidden="true"></div>

<script>
(function () {
  let scheduled = false;

  function classifySurface(bg) {
    if (!bg || bg === 'transparent' || bg === 'rgba(0, 0, 0, 0)') return null;
    const m = bg.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?/);
    if (!m) return null;
    const r = +m[1], g = +m[2], b = +m[3], a = m[4] === undefined ? 1 : +m[4];
    if (a < 0.7) return null;

    // White login card detection
    if (window.location.pathname.startsWith('/auth') && r > 235 && g > 235 && b > 235) {
      return 'login-card';
    }

    // Pterodactyl neutral/slate dark surfaces (neutral-900/800/700/600 & gray equivalents)
    const isNeutralDark =
      r >= 14 && r <= 82 &&
      g >= 20 && g <= 94 &&
      b >= 26 && b <= 112 &&
      (b - r) >= -2 && (b - r) <= 36 &&
      Math.abs(g - r) <= 22;

    if (!isNeutralDark) return null;
    return (r + g + b) < 115 ? 'panel-deep' : 'panel-card';
  }

  function applyDracoUI() {
    scheduled = false;
    const app = document.getElementById('app');
    if (!app) return;

    // 1. Tag Top Navigation Bar via #logo
    const logo = document.getElementById('logo');
    if (logo && logo.parentElement && logo.parentElement.parentElement) {
      const topbar = logo.parentElement.parentElement;
      if (topbar.offsetHeight > 30 && topbar.offsetHeight < 120) {
        topbar.setAttribute('data-draco', 'topbar');
      }
    }

    // 2. Tag SubNavigation -> Transform into Nebula Floating Left Sidebar
    const navAnchor = app.querySelector(
      'a[href$="/files"], a[href$="/startup"], a[href$="/settings"], a[href$="/databases"], a[href$="/network"], a[href="/account/api"], a[href="/account/ssh"]'
    );
    let sidebar = null;
    if (navAnchor && navAnchor.parentElement && navAnchor.parentElement.parentElement) {
      const inner = navAnchor.parentElement;
      const outer = inner.parentElement;
      if (outer && outer.id !== 'app' && inner.querySelectorAll(':scope > a').length >= 2) {
        sidebar = outer;
        sidebar.setAttribute('data-draco', 'sidebar');
        inner.setAttribute('data-draco', 'sidebar-inner');
        if (sidebar.nextElementSibling) {
          sidebar.nextElementSibling.setAttribute('data-draco', 'main-content');
        }
      }
    }
    document.documentElement.toggleAttribute('data-draco-has-sidebar', !!sidebar);

    // 3. Tag Server Cards on Dashboard
    app.querySelectorAll('a[href^="/server/"]').forEach((a) => {
      if (!a.closest('[data-draco="sidebar"]')) {
        a.setAttribute('data-draco', 'server-card');
      }
    });

    // 4. Tag Cards, Stat Blocks, Console Boxes, Modals & Login Card
    const vw = window.innerWidth;
    const vh = window.innerHeight;
    const nodes = app.querySelectorAll('div, section, form, article, aside');

    for (let i = 0; i < nodes.length; i++) {
      const el = nodes[i];
      if (el.hasAttribute('data-draco')) continue;
      if (el.closest('.xterm') || el.closest('.CodeMirror') || el.closest('.ace_editor')) continue;

      const rect = el.getBoundingClientRect();
      if (rect.width < 90 || rect.height < 32) continue;
      // Skip full-viewport root wrappers so Nebula background stays visible
      if (rect.width >= vw - 2 && rect.height >= vh - 2) {
        el.setAttribute('data-draco', 'root-wrap');
        continue;
      }

      const bg = getComputedStyle(el).backgroundColor;
      const kind = classifySurface(bg);
      if (kind) {
        el.setAttribute('data-draco', kind);
      }
    }
  }

  function schedule() {
    if (!scheduled) {
      scheduled = true;
      requestAnimationFrame(applyDracoUI);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', schedule);
  } else {
    schedule();
  }

  const observer = new MutationObserver(schedule);
  observer.observe(document.documentElement, { childList: true, subtree: true });
  window.addEventListener('resize', schedule);
})();
</script>
