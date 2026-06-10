<?php
/**
 * silinex/includes/db.php
 * Provides $pdo for the site frontend renderer (silinex-cms/site/index.php).
 * Bridges to the CMS database (SQLite by default).
 *
 * The CMS database path mirrors what silinex-cms/includes/config.php sets.
 */

// Use CMS DB settings if the CMS config has been loaded; otherwise fall back to defaults.
$_cms_db_path = defined('CMS_DB_PATH')
    ? CMS_DB_PATH
    : __DIR__ . '/../../silinex-cms/data/silinex_cms.sqlite';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    if (file_exists($_cms_db_path)) {
        $pdo = new PDO('sqlite:' . $_cms_db_path, null, null, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec('PRAGMA foreign_keys = ON');
    } else {
        // CMS database not set up yet — $pdo stays null; site will show 404.
        $pdo = null;
    }
}
