<?php
/**
 * Editor/Admin delete endpoint for website versions.
 */
require_once __DIR__ . '/../includes/auth.php'; require_editor_or_admin();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/versions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf_token'] ?? '')) {
    header('Location: /cms/versions/version-list.php?error=' . urlencode('Invalid delete request.'));
    exit;
}

try {
    delete_version($pdo, (int)($_POST['id'] ?? 0), (int)current_user()['id']);
    header('Location: /cms/versions/version-list.php?deleted=1');
} catch (Throwable $e) {
    header('Location: /cms/versions/version-list.php?error=' . urlencode($e->getMessage()));
}
exit;
