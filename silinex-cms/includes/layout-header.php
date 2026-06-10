<?php
/**
 * Silinex CMS — Layout Header
 * Variables expected: $pageTitle (string), $activeNav (string, optional)
 */
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';
if (!isset($pageTitle)) $pageTitle = 'Silinex CMS';
if (!isset($activeNav)) $activeNav = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($pageTitle) ?> — Silinex CMS</title>
<link rel="stylesheet" href="/cms/assets/css/cms.css">
</head>
<body>

<div class="cms-layout">

  <!-- Sidebar -->
  <aside class="cms-sidebar">
    <div class="cms-logo">
      <a href="/cms/dashboard.php">
        <span style="font-weight:900;font-size:1.25rem;color:var(--color-corporate-blue);">Silinex</span>
        <span style="font-size:.75rem;color:var(--color-muted-text);display:block;">CMS Admin</span>
      </a>
    </div>

    <nav class="cms-nav">
      <a href="/cms/dashboard.php"       class="cms-nav-item <?= $activeNav==='dashboard'?'active':'' ?>">📊 Dashboard</a>
      <a href="/cms/pages/pages-list.php" class="cms-nav-item <?= $activeNav==='pages'?'active':'' ?>">📄 Pages</a>
      <a href="/cms/versions/version-list.php" class="cms-nav-item <?= $activeNav==='versions'?'active':'' ?>">🗂 Versions</a>
      <a href="/cms/images/image-list.php" class="cms-nav-item <?= $activeNav==='images'?'active':'' ?>">🖼 Images</a>
      <a href="/cms/navbar/navbar-list.php" class="cms-nav-item <?= $activeNav==='navbar'?'active':'' ?>">🔗 Navbar</a>
      <?php if (is_admin()): ?>
      <a href="/cms/users/user-list.php"  class="cms-nav-item <?= $activeNav==='users'?'active':'' ?>">👤 Users</a>
      <?php endif; ?>
      <hr style="border-color:var(--color-border);margin:12px 0;">
      <a href="<?= SITE_URL ?>" target="_blank" class="cms-nav-item">🌐 View Site</a>
      <a href="/cms/logout.php" class="cms-nav-item" style="color:#e53e3e;">⏏ Logout</a>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="cms-main">
    <div class="cms-topbar">
      <span class="cms-page-title"><?= htmlspecialchars($pageTitle) ?></span>
      <?php $user = current_user(); if ($user): ?>
      <span class="cms-user-badge"><?= htmlspecialchars($user['name']) ?> (<?= $user['role'] ?>)</span>
      <?php endif; ?>
    </div>
    <div class="cms-content">
