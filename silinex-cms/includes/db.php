<?php
/**
 * Silinex CMS — Database Connection
 * Provides $pdo (PDO instance) and bootstraps the schema on first run.
 */

require_once __DIR__ . '/config.php';

function cms_db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    if (DB_DRIVER === 'mysql') {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
        );
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } else {
        $dir = dirname(DB_PATH);
        if (!is_dir($dir)) mkdir($dir, 0700, true);

        $pdo = new PDO('sqlite:' . DB_PATH, null, null, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec('PRAGMA journal_mode = WAL');
        $pdo->exec('PRAGMA foreign_keys = ON');
    }

    cms_init_schema($pdo);
    return $pdo;
}

function cms_init_schema(PDO $pdo): void
{
    $isMysql = DB_DRIVER === 'mysql';

    if ($isMysql) {
        // ── Users ─────────────────────────────────────────────────────────
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name        VARCHAR(120) NOT NULL,
            email       VARCHAR(190) NOT NULL UNIQUE,
            password    VARCHAR(255) NOT NULL,
            role        ENUM('admin','editor') NOT NULL DEFAULT 'editor',
            created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // ── Pages ─────────────────────────────────────────────────────────
        $pdo->exec("CREATE TABLE IF NOT EXISTS pages (
            id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title       VARCHAR(200) NOT NULL,
            slug        VARCHAR(200) NOT NULL UNIQUE,
            meta_title  VARCHAR(200) DEFAULT NULL,
            meta_desc   VARCHAR(500) DEFAULT NULL,
            status      ENUM('draft','published') NOT NULL DEFAULT 'draft',
            in_navbar   TINYINT(1) NOT NULL DEFAULT 1,
            nav_order   INT UNSIGNED NOT NULL DEFAULT 0,
            created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // ── Sections ──────────────────────────────────────────────────────
        $pdo->exec("CREATE TABLE IF NOT EXISTS sections (
            id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            page_id       INT UNSIGNED NOT NULL,
            section_type  VARCHAR(60) NOT NULL DEFAULT 'custom-html',
            title         VARCHAR(300) DEFAULT NULL,
            content       MEDIUMTEXT DEFAULT NULL,
            settings_json TEXT DEFAULT NULL,
            bg_theme      VARCHAR(40) NOT NULL DEFAULT 'white',
            section_order INT UNSIGNED NOT NULL DEFAULT 0,
            status        ENUM('draft','published') NOT NULL DEFAULT 'draft',
            created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // ── Navbar items ──────────────────────────────────────────────────
        $pdo->exec("CREATE TABLE IF NOT EXISTS navbar_items (
            id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            label        VARCHAR(120) NOT NULL,
            href         VARCHAR(300) NOT NULL,
            parent_id    INT UNSIGNED DEFAULT NULL,
            nav_order    INT UNSIGNED NOT NULL DEFAULT 0,
            is_visible   TINYINT(1) NOT NULL DEFAULT 1,
            created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // ── Versions ──────────────────────────────────────────────────────
        $pdo->exec("CREATE TABLE IF NOT EXISTS versions (
            id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            version_number VARCHAR(20) NOT NULL UNIQUE,
            label          VARCHAR(200) DEFAULT NULL,
            snapshot_json  LONGTEXT NOT NULL,
            status         ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
            created_by     INT UNSIGNED DEFAULT NULL,
            created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

        // ── Images ────────────────────────────────────────────────────────
        $pdo->exec("CREATE TABLE IF NOT EXISTS images (
            id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            filename    VARCHAR(300) NOT NULL,
            alt_text    VARCHAR(300) DEFAULT NULL,
            file_size   INT UNSIGNED DEFAULT NULL,
            mime_type   VARCHAR(80) DEFAULT NULL,
            uploaded_by INT UNSIGNED DEFAULT NULL,
            created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    } else {
        // SQLite
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            name       VARCHAR(120) NOT NULL,
            email      VARCHAR(190) NOT NULL UNIQUE,
            password   VARCHAR(255) NOT NULL,
            role       VARCHAR(20) NOT NULL DEFAULT 'editor',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS pages (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            title      VARCHAR(200) NOT NULL,
            slug       VARCHAR(200) NOT NULL UNIQUE,
            meta_title VARCHAR(200) DEFAULT NULL,
            meta_desc  VARCHAR(500) DEFAULT NULL,
            status     VARCHAR(20)  NOT NULL DEFAULT 'draft',
            in_navbar  INTEGER      NOT NULL DEFAULT 1,
            nav_order  INTEGER      NOT NULL DEFAULT 0,
            created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS sections (
            id            INTEGER PRIMARY KEY AUTOINCREMENT,
            page_id       INTEGER NOT NULL,
            section_type  VARCHAR(60)  NOT NULL DEFAULT 'custom-html',
            title         VARCHAR(300) DEFAULT NULL,
            content       TEXT         DEFAULT NULL,
            settings_json TEXT         DEFAULT NULL,
            bg_theme      VARCHAR(40)  NOT NULL DEFAULT 'white',
            section_order INTEGER      NOT NULL DEFAULT 0,
            status        VARCHAR(20)  NOT NULL DEFAULT 'draft',
            created_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS navbar_items (
            id         INTEGER PRIMARY KEY AUTOINCREMENT,
            label      VARCHAR(120) NOT NULL,
            href       VARCHAR(300) NOT NULL,
            parent_id  INTEGER DEFAULT NULL,
            nav_order  INTEGER NOT NULL DEFAULT 0,
            is_visible INTEGER NOT NULL DEFAULT 1,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS versions (
            id             INTEGER PRIMARY KEY AUTOINCREMENT,
            version_number VARCHAR(20)  NOT NULL UNIQUE,
            label          VARCHAR(200) DEFAULT NULL,
            snapshot_json  TEXT         NOT NULL,
            status         VARCHAR(20)  NOT NULL DEFAULT 'draft',
            created_by     INTEGER      DEFAULT NULL,
            created_at     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS images (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            filename    VARCHAR(300) NOT NULL,
            alt_text    VARCHAR(300) DEFAULT NULL,
            file_size   INTEGER DEFAULT NULL,
            mime_type   VARCHAR(80)  DEFAULT NULL,
            uploaded_by INTEGER      DEFAULT NULL,
            created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
        )");
    }

    // Seed default admin user if table is empty
    $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ((int)$count === 0) {
        $hash = password_hash('Admin@1234', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')")
            ->execute(['Admin', 'admin@silinexglobal.com', $hash]);
    }
}

// Make $pdo available as a variable in all files that include db.php
$pdo = cms_db();
