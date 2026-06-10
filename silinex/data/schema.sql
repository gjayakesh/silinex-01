-- Silinex Global Services website database schema.
-- SQLite runs automatically through includes/database.php.

CREATE TABLE IF NOT EXISTS contact_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(40) DEFAULT NULL,
    subject VARCHAR(190) DEFAULT NULL,
    message TEXT NOT NULL,
    ip_address VARCHAR(64) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(190) NOT NULL UNIQUE,
    ip_address VARCHAR(64) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
