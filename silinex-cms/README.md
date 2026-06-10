# Silinex Global Services — CMS

> **Version:** 1.0 | **Stack:** PHP 8.1+ · MySQL 8.0+ · Vanilla JS

A custom Content Management System for **silinexglobal.com** that lets authorized users manage all website content — pages, sections, navigation, images, and deployments — through a secure, brand-consistent admin interface.

---

## Quick Start

### 1. Prerequisites

```bash
php -v        # must be 8.1+
mysql --version
composer -V
```

### 2. Clone / Copy the project

Place the `cms/` folder inside your web server's root (e.g. `/var/www/html/cms/` or inside XAMPP/Laragon's `htdocs/`).

### 3. Install PHP dependencies

```bash
cd /path/to/cms
composer install
```

### 4. Create the database

```bash
mysql -u root -p < schema.sql
```

This creates the `silinex_cms` database with all tables and a default admin account:

For local development, if MySQL is not reachable with the credentials in `includes/config.php`, the CMS automatically falls back to a seeded SQLite database at `data/silinex_cms.sqlite` so the UI can still run.

| Field    | Value                       |
|----------|-----------------------------|
| Email    | `admin@silinexglobal.com`   |
| Password | `Admin@1234` ← **Change immediately** |

### 5. Configure the app

Edit `includes/config.php` and fill in:

```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'silinex_cms');
define('DB_USER', 'root');
define('DB_PASS', 'YOUR_DB_PASSWORD');

define('SITE_URL', 'http://127.0.0.1:8080');      // main website
define('CMS_URL',  'http://127.0.0.1:8080/cms');  // CMS

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'cms@silinexglobal.com');
define('SMTP_PASS', 'YOUR_APP_PASSWORD');

define('CMS_SECRET_KEY', 'change_this_to_64_random_chars');
```

### 6. Set file permissions

```bash
chmod 755 uploads/
# Make sure the web server user (www-data / apache) can write to uploads/
chown -R www-data:www-data uploads/
```

### 7. Start the server

**PHP built-in server (dev only, standalone CMS):**
```bash
php -S 127.0.0.1:8081 -t /path/to/cms /path/to/cms/router.php
```

**Same server as the website:**
Keep `silinex/` and `silinex-cms/` as sibling folders, then run this from the website folder:

```bash
cd D:\Antigravity\Internship\silinex
php -S 127.0.0.1:8080 -t . router.php
```

Website: `http://127.0.0.1:8080/`
CMS: `http://127.0.0.1:8080/cms/`

**Apache / Nginx:** Point the virtual host root to `/path/to/cms` and ensure `mod_rewrite` is enabled.

### 8. Login

Open `http://127.0.0.1:8080/cms/` in your browser and log in with the default admin credentials.

---

## Project Structure

```
/cms/
├── index.php                  # Entry point → redirects to login or dashboard
├── login.php                  # Login page
├── logout.php                 # Logout handler
├── dashboard.php              # Main CMS dashboard
├── schema.sql                 # Full database schema (run once)
├── composer.json              # PHP dependencies (PHPMailer)
├── .htaccess                  # Security + rewrite rules
│
├── /pages/
│   ├── pages-list.php         # All pages with drag-to-reorder + nav toggles
│   ├── page-create.php        # Create a new page
│   ├── page-edit.php          # Edit page settings + manage sections
│   └── page-delete.php        # Delete page handler (admin only)
│
├── /sections/
│   ├── section-create.php     # Add a section to a page
│   ├── section-edit.php       # Edit section content (type-aware fields)
│   └── section-delete.php     # Remove a section
│
├── /navbar/
│   └── navbar-manager.php     # Nav visibility, labels, CTA buttons, reorder
│
├── /users/
│   ├── user-list.php          # View & manage CMS users (admin only)
│   ├── user-invite.php        # Invite a new user via email
│   ├── user-accept.php        # Accept invite token + set password
│   └── user-delete.php        # Remove a user (admin only)
│
├── /images/
│   ├── image-upload-page.php  # Upload UI with drag-and-drop + presets
│   ├── image-upload.php       # Upload handler with dimension validation
│   ├── image-library.php      # Browse all uploaded images
│   └── image-delete.php       # Delete image (admin only)
│
├── /preview/
│   └── preview.php            # Live preview of draft content in an iframe
│
├── /deploy/
│   └── deploy.php             # Publish all draft sections of a page
│
├── /api/                      # Internal AJAX endpoints (JSON responses)
│   ├── save-section.php       # Save section content as draft
│   ├── reorder-pages.php      # Update page nav_order
│   ├── reorder-sections.php   # Update section_order within a page
│   ├── toggle-nav.php         # Toggle page in_navbar flag
│   ├── save-navbar.php        # Save full navbar configuration
│   └── delete-nav-item.php    # Remove a navbar config item
│
├── /assets/
│   ├── /css/
│   │   └── cms-main.css       # Full brand design system + all component styles
│   └── /js/
│       ├── cms-main.js        # Toggles, toast notifications, slug generation
│       ├── image-upload.js    # Drag-and-drop upload with dimension preview
│       └── preview.js         # Preview iframe viewport controls
│
├── /includes/
│   ├── config.php             # App configuration (DB, SMTP, URLs, secrets)
│   ├── db.php                 # PDO database connection
│   ├── auth.php               # Session & role-based access helpers
│   ├── csrf.php               # CSRF token generation & validation
│   ├── mailer.php             # PHPMailer wrapper for invite emails
│   ├── layout-header.php      # Shared HTML head + sidebar + topbar
│   └── layout-footer.php      # Shared closing HTML
│
├── /errors/
│   └── 403.php                # Access denied error page
│
└── /uploads/                  # User-uploaded images (with .htaccess protection)
    └── .htaccess
```

---

## Section Types

| Type | Fields |
|------|--------|
| `hero` | heading, subheading, primary CTA, secondary CTA |
| `services` | JSON items array (icon, title, description) |
| `stats` | JSON items array (number, label) |
| `about` | heading, body text, image URL |
| `testimonial` | JSON items array (quote, author, role) |
| `faq` | JSON items array (question, answer) |
| `cta-banner` | heading, CTA label, CTA URL |
| `custom-html` | Raw HTML block |

---

## Internal API Reference

All endpoints require an authenticated session and respond with JSON.

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/save-section.php` | POST | Save draft content for a section |
| `/api/reorder-pages.php` | POST | Update `nav_order` for multiple pages |
| `/api/reorder-sections.php` | POST | Update `section_order` within a page |
| `/api/toggle-nav.php` | POST | Toggle `in_navbar` for a page |
| `/api/save-navbar.php` | POST | Save full navbar config |
| `/api/delete-nav-item.php` | POST | Remove a navbar config item |
| `/images/image-upload.php` | POST | Upload image with dimension validation |
| `/deploy/deploy.php` | GET | Publish all draft sections of a page |

---

## Security Checklist

Before going live, verify:

- [ ] `config.php` is outside webroot or protected
- [ ] All forms submit and validate CSRF tokens
- [ ] Session ID is regenerated on login
- [ ] `uploads/` directory blocks PHP execution (`.htaccess` in place)
- [ ] `display_errors = 0` in production (`APP_ENV = 'production'`)
- [ ] SMTP credentials are app-specific passwords, not account passwords
- [ ] Default admin password has been changed
- [ ] `CMS_SECRET_KEY` is a random 64-character string
- [ ] Invite tokens expire after 48 hours
- [ ] Rate limiting is active on the login endpoint

---

## Brand Design Tokens (quick reference)

| Token | Value | Usage |
|-------|-------|-------|
| `--color-corporate-blue` | `#0057B8` | Primary CTAs, active states |
| `--color-deep-navy` | `#003F87` | Hover states |
| `--color-dark-navy` | `#0B1C3D` | Sidebar background |
| `--color-orange` | `#F47B20` | Accent CTAs, deploy button |
| `--color-teal` | `#00A99D` | Success states |
| `--color-page-surface` | `#F7F9FC` | Main content background |
| `--font-heading` | Manrope 700/800 | All headings and page titles |
| `--font-body` | Inter 400/500/600 | Body text, labels, inputs |

---

*Silinex Global Services CMS · v1.0 · silinexglobal.com*
