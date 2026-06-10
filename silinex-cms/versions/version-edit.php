<?php
/**
 * Version snapshot overview and audit trail.
 */
require_once __DIR__ . '/../includes/auth.php'; require_editor_or_admin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/versions.php';

$versionId = (int)($_GET['id'] ?? 0);
$version = get_version_by_id($pdo, $versionId);
if (!$version) { http_response_code(404); die('Version not found.'); }

$pages = get_version_pages($pdo, $versionId);
$auditStmt = $pdo->prepare("
    SELECT a.*, u.name AS user_name
    FROM version_audit_log a
    LEFT JOIN users u ON u.id = a.user_id
    WHERE a.version_id = ?
    ORDER BY a.created_at DESC
");
$auditStmt->execute([$versionId]);
$auditRows = $auditStmt->fetchAll();

$pageTitle = 'Edit Version ' . format_version_number($version['version_number']);
$activeNav = 'versions';
include __DIR__ . '/../includes/layout-header.php';
?>

<div class="breadcrumb">
  <a href="/cms/versions/version-list.php">Versions</a>
  <span class="breadcrumb-sep">›</span>
  <span><?= htmlspecialchars(format_version_number($version['version_number'])) ?></span>
</div>

<?php if (isset($_GET['created'])): ?><div class="alert alert-success">Version created. You can now edit its snapshot content.</div><?php endif; ?>
<?php if (isset($_GET['saved'])): ?><div class="alert alert-success">Version content saved.</div><?php endif; ?>

<div class="page-header">
  <div>
    <h2>Version <?= htmlspecialchars(format_version_number($version['version_number'])) ?></h2>
    <span class="status-badge status-<?= strtolower($version['status']) ?>"><?= htmlspecialchars($version['status']) ?></span>
    <p class="caption"><?= nl2br(htmlspecialchars($version['description'])) ?></p>
  </div>
  <div style="display:flex;gap:8px;flex-wrap:wrap;">
    <a href="/cms/preview/preview.php?version=<?= urlencode($version['version_number']) ?>" target="_blank" class="btn-secondary">Preview</a>
    <?php if (is_admin()): ?>
    <form method="POST" action="/cms/versions/version-publish.php" style="display:inline;">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= (int)$version['id'] ?>">
      <button type="submit" class="btn-accent" data-confirm="Publish Version <?= htmlspecialchars(format_version_number($version['version_number'])) ?>? This will become the active website.">Publish</button>
    </form>
    <?php endif; ?>
    <a href="/cms/versions/version-list.php" class="btn-secondary">Back</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:var(--space-lg);align-items:start;">
  <div class="card">
    <h3 style="margin-bottom:var(--space-md);">Pages in This Version</h3>
    <?php foreach ($pages as $row): ?>
    <div class="version-page-row">
      <div>
        <strong><?= htmlspecialchars($row['page']['title'] ?? 'Untitled') ?></strong>
        <div class="caption">/<?= htmlspecialchars($row['page']['slug'] ?? '') ?> · <?= count($row['sections']) ?> sections</div>
      </div>
      <a href="/cms/versions/version-page-edit.php?id=<?= (int)$row['content_id'] ?>" class="btn-secondary btn-sm">Edit</a>
    </div>
    <?php endforeach; ?>
  </div>

  <aside class="card">
    <h3 style="margin-bottom:var(--space-md);">Audit History</h3>
    <?php foreach ($auditRows as $row): ?>
    <div class="audit-row">
      <strong><?= htmlspecialchars(ucfirst($row['action'])) ?></strong>
      <div class="caption"><?= htmlspecialchars($row['user_name'] ?? 'System') ?> · <?= date('d-M-Y H:i', strtotime($row['created_at'])) ?></div>
      <?php if ($row['details']): ?><p class="caption"><?= htmlspecialchars($row['details']) ?></p><?php endif; ?>
    </div>
    <?php endforeach; ?>
  </aside>
</div>

<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
