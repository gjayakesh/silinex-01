<?php
/**
 * Silinex CMS — Entry Point
 * Redirects to dashboard if logged in, otherwise to login.
 */
require_once __DIR__ . '/includes/auth.php';

if (is_logged_in()) {
    header('Location: /cms/dashboard.php');
} else {
    header('Location: /cms/login.php');
}
exit;
