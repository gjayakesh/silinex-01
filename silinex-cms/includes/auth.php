<?php
/**
 * Silinex CMS — Authentication helpers
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in(): bool {
    return isset($_SESSION['cms_user_id']) && !empty($_SESSION['cms_user_id']);
}

function current_user(): ?array {
    return $_SESSION['cms_user'] ?? null;
}

function is_admin(): bool {
    return (current_user()['role'] ?? '') === 'admin';
}

function is_editor(): bool {
    $role = current_user()['role'] ?? '';
    return $role === 'editor' || $role === 'admin';
}

function require_auth(): void {
    if (!is_logged_in()) {
        header('Location: /cms/login.php');
        exit;
    }
}

function require_editor_or_admin(): void {
    require_auth();
    if (!is_editor()) {
        http_response_code(403);
        die('Access denied.');
    }
}

function require_admin_role(): void {
    require_auth();
    if (!is_admin()) {
        http_response_code(403);
        die('Admins only.');
    }
}

// Alias used by some pages
function require_admin(): void {
    require_admin_role();
}
