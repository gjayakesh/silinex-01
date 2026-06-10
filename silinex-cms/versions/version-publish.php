<?php
/**
 * Admin-only publish endpoint for website versions.
 */
require_once __DIR__ . '/../includes/auth.php'; require_admin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/versions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf_token'] ?? '')) {
    header('Location: /cms/versions/version-list.php?error=' . urlencode('Invalid publish request.'));
    exit;
}

try {
    publish_version($pdo, (int)($_POST['id'] ?? 0), (int)current_user()['id']);
    header('Location: /cms/versions/version-list.php?published=1');
} catch (Throwable $e) {
    header('Location: /cms/versions/version-list.php?error=' . urlencode($e->getMessage()));
}
exit;
