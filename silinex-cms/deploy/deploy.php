<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';

$pageId = (int)($_GET['page_id'] ?? 0);
if (!$pageId) { header('Location: /cms/pages/pages-list.php'); exit; }

// Publish all draft sections for this page
$pdo->prepare("UPDATE sections SET status='published', updated_at=CURRENT_TIMESTAMP WHERE page_id = ? AND status = 'draft'")
    ->execute([$pageId]);

// Publish the page itself
$pdo->prepare("UPDATE pages SET status='published', updated_at=CURRENT_TIMESTAMP WHERE id = ?")
    ->execute([$pageId]);

header('Location: /cms/pages/page-edit.php?id=' . $pageId . '&deployed=1');
exit;
