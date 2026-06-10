<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';

$pages = $pdo->query("SELECT * FROM pages ORDER BY nav_order ASC, id ASC")->fetchAll();

$pageTitle = 'Pages';
$activeNav = 'pages';
include __DIR__ . '/../includes/layout-header.php';
?>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-success">Page deleted successfully.</div>
<?php endif; ?>

<div class="page-header">
  <h2>All Pages</h2>
  <a href="/cms/pages/page-create.php" class="btn-primary">+ New Page</a>
</div>

<div class="card">
  <p class="caption" style="margin-bottom:var(--space-md);">Drag rows to reorder. Toggle to control navbar visibility.</p>

  <div id="pages-sortable">
    <?php foreach ($pages as $page): ?>
    <div class="page-card" data-page-id="<?= $page['id'] ?>" style="display:flex;align-items:center;gap:var(--space-md);padding:16px 0;border-bottom:1px solid var(--color-border);">

      <span class="drag-handle" title="Drag to reorder">⠿</span>

      <div class="page-meta" style="flex:1;">
        <div style="font-weight:600;color:var(--color-dark-navy);"><?= htmlspecialchars($page['title']) ?></div>
        <div class="caption"><?= $page['slug'] === 'home' ? '/' : '/' . htmlspecialchars($page['slug']) ?></div>
      </div>

      <span class="status-badge status-<?= $page['status'] ?>"><?= ucfirst($page['status']) ?></span>

      <label style="display:flex;align-items:center;gap:8px;cursor:pointer;" title="Show in Navbar">
        <label class="toggle-switch">
          <input type="checkbox" class="nav-toggle" data-id="<?= $page['id'] ?>"
                 <?= $page['in_navbar'] ? 'checked' : '' ?>>
          <span class="toggle-track"></span>
        </label>
        <span class="caption">Navbar</span>
      </label>

      <div style="display:flex;gap:8px;">
        <a href="/cms/pages/page-edit.php?id=<?= $page['id'] ?>" class="btn-secondary btn-sm">Edit</a>
        <a href="/cms/preview/preview.php?page=<?= urlencode($page['slug']) ?>" target="_blank" class="btn-accent btn-sm">Preview</a>
        <?php if (is_admin()): ?>
        <a href="/cms/pages/page-delete.php?id=<?= $page['id'] ?>"
           class="btn-danger btn-sm"
           data-confirm="Delete '<?= htmlspecialchars($page['title']) ?>'? This cannot be undone.">Delete</a>
        <?php endif; ?>
      </div>

    </div>
    <?php endforeach; ?>
    <?php if (!$pages): ?>
    <div style="text-align:center;padding:48px;color:var(--color-muted-text);">
      No pages yet. <a href="/cms/pages/page-create.php" style="color:var(--color-corporate-blue);">Create your first page →</a>
    </div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
Sortable.create(document.getElementById('pages-sortable'), {
  handle: '.drag-handle',
  animation: 150,
  ghostClass: 'sortable-ghost',
  onEnd: function () {
    const ids = [...document.querySelectorAll('#pages-sortable [data-page-id]')]
                  .map(el => parseInt(el.dataset.pageId));
    fetch('/cms/api/reorder-pages.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ ids })
    });
  }
});
</script>

<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
