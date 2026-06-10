<?php
/**
 * Versions gallery for creating, previewing, editing, and publishing website versions.
 */
require_once __DIR__ . '/../includes/auth.php'; require_editor_or_admin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/versions.php';

$versions = list_versions($pdo);
$pageTitle = 'Versions';
$activeNav = 'versions';
include __DIR__ . '/../includes/layout-header.php';
?>

<?php if (isset($_GET['created'])): ?><div class="alert alert-success">Version created as draft.</div><?php endif; ?>
<?php if (isset($_GET['published'])): ?><div class="alert alert-success">Version published. Previous published version was archived.</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="alert alert-success">Version deleted successfully.</div><?php endif; ?>
<?php if (isset($_GET['error'])): ?><div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div><?php endif; ?>

<div class="page-header">
  <div>
    <h2>Version Gallery</h2>
    <p class="caption">Manage draft, published, and archived website snapshots.</p>
  </div>
  <a href="/cms/versions/version-create.php" class="btn-primary">+ Create Version</a>
</div>

<div class="version-grid">
  <?php foreach ($versions as $version): ?>
  <article class="version-card">
    <div class="version-card-head">
      <h3>Version <?= htmlspecialchars(format_version_number($version['version_number'])) ?></h3>
      <span class="status-badge status-<?= strtolower($version['status']) ?>"><?= htmlspecialchars($version['status']) ?></span>
    </div>
    <p class="version-description"><?= nl2br(htmlspecialchars($version['description'])) ?></p>
    <div class="version-meta">
      <div><strong>Type:</strong> <?= ucfirst(htmlspecialchars($version['version_type'])) ?></div>
      <div><strong>Created:</strong> <?= date('d-M-Y', strtotime($version['created_at'])) ?></div>
      <div><strong>By:</strong> <?= htmlspecialchars($version['creator_name'] ?? 'System') ?></div>
    </div>
    <div class="version-actions">
      <a href="/cms/preview/preview.php?version=<?= urlencode($version['version_number']) ?>" target="_blank" class="btn-secondary btn-sm">Preview</a>
      <a href="/cms/versions/version-edit.php?id=<?= (int)$version['id'] ?>" class="btn-secondary btn-sm">Edit</a>
      <?php if ($version['status'] !== 'Published'): ?>
      <form method="POST" action="/cms/versions/version-delete.php" style="display:inline;">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$version['id'] ?>">
        <button type="submit" class="btn-secondary btn-sm" style="color: #ef4444; border-color: #fca5a5;" data-confirm="Are you sure you want to delete Version <?= htmlspecialchars(format_version_number($version['version_number'])) ?>?">Delete</button>
      </form>
      <?php endif; ?>
      <?php if (is_admin()): ?>
      <form method="POST" action="/cms/versions/version-publish.php" style="display:inline;">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$version['id'] ?>">
        <button type="submit" class="btn-accent btn-sm" data-confirm="Publish Version <?= htmlspecialchars(format_version_number($version['version_number'])) ?> ? This will become the active website.">Publish</button>
      </form>
      <?php endif; ?>
    </div>
  </article>
  <?php endforeach; ?>
</div>

<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
