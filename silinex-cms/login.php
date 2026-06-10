<?php
/**
 * Silinex CMS — Login
 */
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

if (is_logged_in()) {
    header('Location: /cms/dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['cms_user_id'] = $user['id'];
        $_SESSION['cms_user']    = [
            'id'   => $user['id'],
            'name' => $user['name'],
            'role' => $user['role'],
        ];
        header('Location: /cms/dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login — Silinex CMS</title>
<link rel="stylesheet" href="/cms/assets/css/cms.css">
</head>
<body>
<div class="login-wrap">
  <div class="login-card">
    <div class="cms-logo" style="margin-bottom:24px;">
      <span style="font-weight:900;font-size:1.5rem;color:var(--color-corporate-blue);">Silinex</span>
      <span style="font-size:.8rem;color:var(--color-muted-text);display:block;">CMS Admin</span>
    </div>
    <p class="login-title">Sign in</p>
    <p class="login-sub">Enter your admin credentials to continue.</p>

    <?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" required autofocus
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
      </div>
      <button type="submit" class="btn-primary btn-full" style="margin-top:8px;">Login</button>
    </form>
  </div>
</div>
</body>
</html>
