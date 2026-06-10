<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/db.php';

$id     = (int)($_GET['id']      ?? 0);
$pageId = (int)($_GET['page_id'] ?? 0);

if ($id) {
    $pdo->prepare("DELETE FROM sections WHERE id = ?")->execute([$id]);
}
header('Location: /cms/pages/page-edit.php?id=' . $pageId);
exit;
