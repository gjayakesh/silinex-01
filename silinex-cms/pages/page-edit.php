<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$pageId = (int)($_GET['id'] ?? 0);
if (!$pageId) { header('Location: /cms/pages/pages-list.php'); exit; }

$page = $pdo->prepare("SELECT * FROM pages WHERE id = ?");
$page->execute([$pageId]);
$page = $page->fetch();
if (!$page) { http_response_code(404); die('Page not found.'); }

// Handle page settings save
$error = ''; $saveSuccess = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        $title     = trim($_POST['title']      ?? '');
        $slug      = trim($_POST['slug']       ?? $page['slug']);
        $metaTitle = trim($_POST['meta_title'] ?? '');
        $metaDesc  = trim($_POST['meta_desc']  ?? '');
        try {
            $pdo->prepare("UPDATE pages SET title=?,slug=?,meta_title=?,meta_desc=? WHERE id=?")
                ->execute([$title, $slug, $metaTitle, $metaDesc, $pageId]);
            $saveSuccess = 'Page settings saved.';
            $page = array_merge($page, ['title' => $title, 'slug' => $slug, 'meta_title' => $metaTitle, 'meta_desc' => $metaDesc]);
        } catch (PDOException $e) {
            $error = 'Could not save: ' . ($e->getCode() == 23000 ? 'Slug already in use.' : $e->getMessage());
        }
    }
}

$sections = $pdo->prepare("SELECT * FROM sections WHERE page_id = ? ORDER BY section_order ASC");
$sections->execute([$pageId]);
$sections = $sections->fetchAll();

$sectionTypes = ['hero','services','stats','about','testimonial','faq','cta-banner','custom-html'];

$pageTitle = 'Edit: ' . $page['title'];
$activeNav = 'pages';
include __DIR__ . '/../includes/layout-header.php';
?>

<div class="breadcrumb">
  <a href="/cms/pages/pages-list.php">Pages</a>
  <span class="breadcrumb-sep">›</span>
  <span><?= htmlspecialchars($page['title']) ?></span>
</div>

<?php if (isset($_GET['created'])): ?>
<div class="alert alert-success">✅ Page created! Now add sections below.</div>
<?php endif; ?>
<?php if (isset($_GET['deployed'])): ?>
<div class="alert alert-success">
  🚀 Page published! Live at
  <a href="<?= rtrim(SITE_URL, '/') ?><?= $page['slug'] === 'home' ? '/' : '/' . htmlspecialchars($page['slug']) ?>" target="_blank"><?= rtrim(SITE_URL, '/') ?><?= $page['slug'] === 'home' ? '/' : '/' . htmlspecialchars($page['slug']) ?></a>
</div>
<?php endif; ?>
<?php if ($saveSuccess): ?><div class="alert alert-success">✅ <?= htmlspecialchars($saveSuccess) ?></div><?php endif; ?>
<?php if ($error):       ?><div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div><?php endif; ?>

<!-- Page Header Row -->
<div class="page-header">
  <div>
    <h2><?= htmlspecialchars($page['title']) ?></h2>
    <span class="status-badge status-<?= $page['status'] ?>"><?= ucfirst($page['status']) ?></span>
    <span class="caption" style="margin-left:8px;"><?= $page['slug'] === 'home' ? '/' : '/' . htmlspecialchars($page['slug']) ?></span>
  </div>
  <div style="display:flex;gap:8px;">
    <a href="/cms/preview/preview.php?page=<?= urlencode($page['slug']) ?>" target="_blank" class="btn-secondary">Preview</a>
    <a href="/cms/deploy/deploy.php?page_id=<?= $pageId ?>" class="btn-accent"
       data-confirm="Publish all draft sections of this page?">🚀 Publish</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:var(--space-lg);align-items:start;">

  <!-- Sections Column -->
  <div>
    <div class="page-header">
      <h3>Page Sections</h3>
      <a href="/cms/sections/section-create.php?page_id=<?= $pageId ?>" class="btn-primary btn-sm">+ Add Section</a>
    </div>

    <?php if (!$sections): ?>
    <div class="card" style="text-align:center;padding:48px;color:var(--color-muted-text);">
      No sections yet. <a href="/cms/sections/section-create.php?page_id=<?= $pageId ?>" style="color:var(--color-corporate-blue);">Add the first section →</a>
    </div>
    <?php endif; ?>

    <div id="sections-sortable">
    <?php foreach ($sections as $sec): ?>
    <div class="section-editor card" id="section-editor-<?= $sec['id'] ?>" data-section-id="<?= $sec['id'] ?>" style="margin-bottom:var(--space-md);">

      <div class="section-editor-header">
        <div style="display:flex;align-items:center;gap:10px;">
          <span class="drag-handle">⠿</span>
          <span class="label"><?= strtoupper(str_replace('-', ' ', $sec['section_type'])) ?> SECTION</span>
          <span class="status-badge status-<?= $sec['status'] ?>"><?= ucfirst($sec['status']) ?></span>
        </div>
        <div class="section-controls">
          <a href="/cms/sections/section-edit.php?id=<?= $sec['id'] ?>" class="btn-secondary btn-sm">✏️ Edit</a>
          <a href="/cms/sections/section-delete.php?id=<?= $sec['id'] ?>&page_id=<?= $pageId ?>"
             class="btn-danger btn-sm"
             data-confirm="Delete this section?">Delete</a>
        </div>
      </div>

      <div style="color:var(--color-body-text);font-size:14px;">
        <?php if ($sec['title']): ?>
        <strong><?= htmlspecialchars($sec['title']) ?></strong><br>
        <?php endif; ?>
        <span class="caption">Type: <?= htmlspecialchars($sec['section_type']) ?> · Background: <?= $sec['bg_theme'] ?></span>
      </div>

    </div>
    <?php endforeach; ?>
    </div>

  </div>

  <!-- Settings Sidebar -->
  <div>
    <div class="card">
      <h3 style="margin-bottom:var(--space-md);">Page Settings</h3>
      <form method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="save_settings" value="1">

        <div class="form-group">
          <label>Page Title</label>
          <input type="text" name="title" value="<?= htmlspecialchars($page['title']) ?>" required>
        </div>
        <div class="form-group">
          <label>URL Slug</label>
          <input type="text" name="slug" value="<?= htmlspecialchars($page['slug']) ?>">
        </div>
        <div class="form-group">
          <label>Meta Title</label>
          <input type="text" name="meta_title" value="<?= htmlspecialchars($page['meta_title'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label>Meta Description</label>
          <textarea name="meta_desc" rows="3"><?= htmlspecialchars($page['meta_desc'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn-primary btn-full">Save Settings</button>
      </form>
    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
const list = document.getElementById('sections-sortable');
if (list) {
  Sortable.create(list, {
    handle: '.drag-handle',
    animation: 150,
    ghostClass: 'sortable-ghost',
    onEnd: function () {
      const ids = [...document.querySelectorAll('#sections-sortable [data-section-id]')]
                    .map(el => parseInt(el.dataset.sectionId));
      fetch('/cms/api/reorder-sections.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids })
      });
    }
  });
}
</script>

<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
