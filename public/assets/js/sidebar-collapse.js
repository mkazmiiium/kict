/**
 * Desktop sidebar collapse-to-icons toggle.
 *
 * The vendor Sneat "free" bundle's Helpers.toggleCollapsed() never actually
 * adds/removes the `layout-menu-collapsed` class on desktop (only the
 * mobile off-canvas path works), so the built-in toggle button is a no-op
 * for the icon-only collapse. This restores that behavior directly.
 */
(function () {
  var STORAGE_KEY = 'kict-sidebar-collapsed';
  var BREAKPOINT = 1200;

  function isSmallScreen() {
    return (window.innerWidth || document.documentElement.clientWidth) < BREAKPOINT;
  }

  function updateIcon(toggle) {
    var icon = toggle.querySelector('i');
    if (!icon) return;
    var collapsed = document.documentElement.classList.contains('layout-menu-collapsed');
    icon.classList.toggle('bx-chevron-left', !collapsed);
    icon.classList.toggle('bx-chevron-right', collapsed);
  }

  document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.querySelector('.app-brand .layout-menu-toggle');
    if (!toggle) return;

    updateIcon(toggle);

    toggle.addEventListener('click', function () {
      if (isSmallScreen()) return;

      var collapsed = document.documentElement.classList.toggle('layout-menu-collapsed');
      localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
      updateIcon(toggle);
      window.dispatchEvent(new Event('resize'));
    });
  });
})();
