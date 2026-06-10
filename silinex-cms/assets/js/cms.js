/* Silinex CMS — Admin JavaScript */

// ── Confirm-data attribute handler ────────────────────────────────────────
document.addEventListener('click', function (e) {
  const el = e.target.closest('[data-confirm]');
  if (!el) return;
  const msg = el.dataset.confirm || 'Are you sure?';
  if (!window.confirm(msg)) e.preventDefault();
});

// ── Nav-toggle (navbar visibility) ────────────────────────────────────────
document.addEventListener('change', function (e) {
  const toggle = e.target.closest('.nav-toggle');
  if (!toggle) return;
  const id = toggle.dataset.id;
  const val = toggle.checked ? 1 : 0;
  fetch('/cms/api/toggle-navbar.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id, value: val })
  });
});
