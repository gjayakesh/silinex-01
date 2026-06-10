<?php
/**
 * Silinex CMS — Configuration
 * Edit these settings before running locally or deploying.
 */

// ── Site URLs ──────────────────────────────────────────────────────────────
define('SITE_URL', 'http://127.0.0.1:8080');   // main website
define('CMS_URL',  'http://127.0.0.1:8080/cms'); // CMS

// ── Database ───────────────────────────────────────────────────────────────
// Default: SQLite (zero config, works out of the box).
// For MySQL: change DB_DRIVER to 'mysql' and fill in the values below.
define('DB_DRIVER',  'sqlite');
define('DB_PATH',    '/tmp/silinex_cms.sqlite');

define('DB_HOST',    '127.0.0.1');
define('DB_PORT',    '3306');
define('DB_NAME',    'silinex_cms');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');

// ── Security ───────────────────────────────────────────────────────────────
// Generate a strong random string: php -r "echo bin2hex(random_bytes(32));"
define('CMS_SECRET_KEY', 'change_this_to_64_random_chars_before_production_use');

// ── SMTP (optional — only needed for email notifications) ─────────────────
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMTP_FROM', 'cms@silinexglobal.com');
