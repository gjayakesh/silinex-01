<?php
require_once __DIR__ . '/includes/auth.php'; require_auth();
require_once __DIR__ . '/includes/db.php';

$pageCount    = $pdo->query("SELECT COUNT(*) FROM pages")->fetchColumn();
$sectionCount = $pdo->query("SELECT COUNT(*) FROM sections")->fetchColumn();
$versionCount = $pdo->query("SELECT COUNT(*) FROM versions")->fetchColumn();
$userCount    = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$draftPages   = $pdo->query("SELECT COUNT(*) FROM pages WHERE status='draft'")->fetchColumn();

$pageTitle = 'Dashboard';
$activeNav = 'dashboard';
include __DIR__ . '/includes/layout-header.php';
?>

<div class="stats-row">
  <div class="stat-card">
    <div class="stat-number"><?= $pageCount ?></div>
    <div class="stat-label">Total Pages</div>
  </div>
  <div class="stat-card">
    <div class="stat-number"><?= $sectionCount ?></div>
    <div class="stat-label">Sections</div>
  </div>
  <div class="stat-card">
    <div class="stat-number"><?= $versionCount ?></div>
    <div class="stat-label">Versions</div>
  </div>
  <div class="stat-card">
    <div class="stat-number"><?= $draftPages ?></div>
    <div class="stat-label">Draft Pages</div>
  </div>
  <?php if (is_admin()): ?>
  <div class="stat-card">
    <div class="stat-number"><?= $userCount ?></div>
    <div class="stat-label">Users</div>
  </div>
  <?php endif; ?>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-lg);">

  <div class="card">
    <div class="page-header">
      <h3>Quick Actions</h3>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px;">
      <a href="/cms/pages/page-create.php" class="btn-primary">+ New Page</a>
      <a href="/cms/versions/version-create.php" class="btn-secondary">📸 Create Snapshot</a>
      <a href="/cms/images/image-list.php" class="btn-secondary">🖼 Manage Images</a>
      <a href="/cms/navbar/navbar-list.php" class="btn-secondary">🔗 Edit Navbar</a>
    </div>
  </div>

  <div class="card">
    <div class="page-header">
      <h3>Recent Pages</h3>
      <a href="/cms/pages/pages-list.php" class="caption">View all →</a>
    </div>
    <?php
    $recent = $pdo->query("SELECT * FROM pages ORDER BY updated_at DESC LIMIT 5")->fetchAll();
    foreach ($recent as $p): ?>
    <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--color-border);">
      <div>
        <span style="font-weight:600;"><?= htmlspecialchars($p['title']) ?></span>
        <span class="caption" style="margin-left:8px;">/<?= htmlspecialchars($p['slug']) ?></span>
      </div>
      <span class="status-badge status-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span>
    </div>
    <?php endforeach; ?>
    <?php if (!$recent): ?>
    <p class="caption">No pages yet. <a href="/cms/pages/page-create.php">Create one →</a></p>
    <?php endif; ?>
  </div>

</div>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
