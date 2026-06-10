<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        $title    = trim($_POST['title']     ?? '');
        $slug     = trim($_POST['slug']      ?? '');
        $metaTitle = trim($_POST['meta_title'] ?? '');
        $metaDesc  = trim($_POST['meta_desc']  ?? '');

        // Slugify if blank
        if (!$slug) {
            $slug = preg_replace('/[^a-z0-9-]/', '-', strtolower($title));
            $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        }

        if (!$title) { $error = 'Page title is required.'; }
        else {
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO pages (title, slug, meta_title, meta_desc, status)
                     VALUES (?, ?, ?, ?, 'draft')"
                );
                $stmt->execute([$title, $slug, $metaTitle, $metaDesc]);
                $newId = $pdo->lastInsertId();
                header('Location: /cms/pages/page-edit.php?id=' . $newId . '&created=1');
                exit;
            } catch (PDOException $e) {
                $error = strpos($e->getMessage(), 'Duplicate') !== false
                    ? "A page with slug '{$slug}' already exists. Choose a different slug."
                    : 'Could not create page. Please try again.';
            }
        }
    }
}

$pageTitle = 'New Page';
$activeNav = 'pages';
include __DIR__ . '/../includes/layout-header.php';
?>

<div class="breadcrumb">
  <a href="/cms/pages/pages-list.php">Pages</a>
  <span class="breadcrumb-sep">›</span>
  <span>New Page</span>
</div>

<div class="page-header">
  <h2>Create New Page</h2>
</div>

<?php if ($error): ?>
<div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card" style="max-width:680px;">
  <form method="POST" action="/cms/pages/page-create.php">
    <?= csrf_field() ?>

    <div class="form-group">
      <label for="page-title">Page Title <span style="color:#E53E3E;">*</span></label>
      <input type="text" id="page-title" name="title"
             placeholder="e.g. About Us"
             value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
    </div>

    <div class="form-group">
      <label for="page-slug">URL Slug</label>
      <input type="text" id="page-slug" name="slug"
             placeholder="e.g. about-us (auto-generated if blank)"
             value="<?= htmlspecialchars($_POST['slug'] ?? '') ?>">
      <div class="caption" style="margin-top:4px;">Will be previewed at: <code>/{slug}</code></div>
    </div>

    <div class="form-group">
      <label for="meta-title">Meta Title</label>
      <input type="text" id="meta-title" name="meta_title"
             placeholder="SEO title (leave blank to use page title)"
             value="<?= htmlspecialchars($_POST['meta_title'] ?? '') ?>">
    </div>

    <div class="form-group">
      <label for="meta-desc">Meta Description</label>
      <textarea id="meta-desc" name="meta_desc" rows="3"
                placeholder="SEO description (≤ 160 characters)"><?= htmlspecialchars($_POST['meta_desc'] ?? '') ?></textarea>
    </div>

    <div style="display:flex;gap:var(--space-sm);margin-top:var(--space-md);">
      <button type="submit" class="btn-primary">Create Page</button>
      <a href="/cms/pages/pages-list.php" class="btn-secondary">Cancel</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
