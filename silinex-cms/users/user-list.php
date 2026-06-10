<?php
require_once __DIR__ . '/../includes/auth.php'; require_admin_role();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$error = ''; $success = '';

// Add user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    if (!csrf_verify($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid request.';
    } else {
        $name  = trim($_POST['name']  ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass  = trim($_POST['password'] ?? '');
        $role  = in_array($_POST['role'] ?? '', ['admin','editor']) ? $_POST['role'] : 'editor';
        if (!$name || !$email || !$pass) {
            $error = 'Name, email and password are required.';
        } else {
            try {
                $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?,?,?,?)")
                    ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT), $role]);
                $success = 'User created.';
            } catch (PDOException $e) {
                $error = 'Email already in use.';
            }
        }
    }
}

// Delete user (can't delete yourself)
if (isset($_GET['delete'])) {
    $me = current_user();
    $delId = (int)$_GET['delete'];
    if ($delId !== (int)$me['id']) {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$delId]);
    }
    header('Location: /cms/users/user-list.php?deleted=1');
    exit;
}

$users = $pdo->query("SELECT id, name, email, role, created_at FROM users ORDER BY id ASC")->fetchAll();
$pageTitle = 'Users';
$activeNav = 'users';
include __DIR__ . '/../includes/layout-header.php';
?>
<?php if (isset($_GET['deleted'])): ?><div class="alert alert-success">User deleted.</div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div><?php endif; ?>
<?php if ($error):   ?><div class="alert alert-error">❌ <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div class="page-header"><h2>Users</h2></div>

<div class="card" style="margin-bottom:var(--space-lg);max-width:560px;">
  <h3 style="margin-bottom:var(--space-md);">Add User</h3>
  <form method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="add_user" value="1">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-md);">
      <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
      <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
      <div class="form-group"><label>Role</label>
        <select name="role"><option value="editor">Editor</option><option value="admin">Admin</option></select>
      </div>
    </div>
    <button type="submit" class="btn-primary">Create User</button>
  </form>
</div>

<div class="card">
  <table class="cms-table">
    <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th></tr></thead>
    <tbody>
    <?php $me = current_user(); foreach ($users as $u): ?>
    <tr>
      <td><?= htmlspecialchars($u['name']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><span class="status-badge status-<?= $u['role']==='admin'?'published':'draft' ?>"><?= ucfirst($u['role']) ?></span></td>
      <td class="caption"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
      <td>
        <?php if ((int)$u['id'] !== (int)$me['id']): ?>
        <a href="?delete=<?= $u['id'] ?>" data-confirm="Delete user <?= htmlspecialchars($u['name']) ?>?" class="btn-danger btn-sm">Delete</a>
        <?php else: ?>
        <span class="caption">(you)</span>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php include __DIR__ . '/../includes/layout-footer.php'; ?>
