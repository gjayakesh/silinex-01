<?php
require_once __DIR__ . '/../includes/auth.php'; require_admin(); // Admin only
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';

$pageId = (int)($_GET['id'] ?? 0);
if (!$pageId) { header('Location: /cms/pages/pages-list.php'); exit; }

// Cascade deletes sections via FK
$pdo->prepare("DELETE FROM pages WHERE id = ?")->execute([$pageId]);
header('Location: /cms/pages/pages-list.php?deleted=1');
exit;
