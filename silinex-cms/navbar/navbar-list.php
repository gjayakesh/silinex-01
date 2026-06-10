<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$error = ''; $success = '';

// Add item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        $label = trim($_POST['label'] ?? '');
        $href  = trim($_POST['href']  ?? '');
        if ($label && $href) {
            $max = $pdo->query("SELECT MAX(nav_order) FROM navbar_items")->fetchColumn();
            $pdo->prepare("INSERT INTO navbar_items (label, href, nav_order) VALUES (?,?,?)")
                ->execute([$label, $href, ((int)$max) + 1]);
            $success = 'Item added.';
        } else {
            $error = 'Label and URL are required.';
        }
    }
}

// Delete item
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM navbar_items WHERE id = ?")->execute([(int)$_GET['delete']]);
    header('Location: /cms/navbar/navbar-list.php?deleted=1');
    exit;
}

$items = $pdo->query("SELECT * FROM navbar_items ORDER BY nav_order ASC")->fetchAll();
$pageTitle = 'Navbar Manager';
$activeNav = 'navbar';
include __DIR__ . '/../includes/layout-header.php';
?>
<?php if (isset($_GET['deleted'])): ?><div class="alert alert-success">Item deleted.</div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div><?php endif; ?>
<?php if ($error):   ?><div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="page-header"><h2>Navbar Manager</h2></div>

<div class="card" style="margin-bottom:var(--space-lg);max-width:500px;">
  <h3 style="margin-bottom:var(--space-md);">Add Nav Item</h3>
  <form method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="add_item" value="1">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md);">
      <div class="form-group"><label>Label</label><input type="text" name="label" required></div>
      <div class="form-group"><label>URL</label><input type="text" name="href" required placeholder="/services"></div>
    </div>
    <button type="submit" class="btn-primary">Add</button>
  </form>
</div>

<div class="card">
  <table class="cms-table">
    <thead><tr><th>Label</th><th>URL</th><th>Visible</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
      <td><?= htmlspecialchars($item['label']) ?></td>
      <td><code><?= htmlspecialchars($item['href']) ?></code></td>
      <td><?= $item['is_visible'] ? '✅' : '❌' ?></td>
      <td>
        <a href="?delete=<?= $item['id'] ?>" data-confirm="Remove this nav item?" class="btn-danger btn-sm">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$items): ?>
    <tr><td colspan="4" class="caption" style="text-align:center;padding:24px;">No items yet.</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</div>
<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
