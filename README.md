# Silinex Global Services – CMS & Site

## Overview
This repository contains a **custom Content Management System (CMS)** built with **PHP 8.5**, **SQLite**, and a lightweight front‑end. The CMS lives in the `silinex-cms/` directory and manages the website content for the sibling site located in `silinex/`.

The project demonstrates:
- A PHP built‑in development server for quick local testing.
- A simple routing layer (`silinex-cms/router.php`) that serves the CMS under `/cms/` and forwards all other requests to the website project.
- Automatic SQLite database creation (`setup_db.php`).
- Composer‑managed dependencies (PHPMailer, etc.).

## Directory Layout
```
silinexglobal/
├─ silinex/               # Front‑end website (static pages, assets)
├─ silinex-cms/           # The CMS application
│   ├─ router.php         # Development router (serves /cms/ routes)
│   ├─ setup_db.php      # Creates SQLite DB and seed data
│   ├─ composer.json
│   └─ ...               # PHP source, assets, migrations
└─ README.md              # <‑ you are here
```

## Prerequisites
- **PHP 8.5+** (included with Windows builds)
- **Composer** (the project ships a `composer.phar` so you can run `php composer.phar install` without installing Composer globally)
- **Git** (for version control)

## Installation Steps
1. **Clone the repository** (already done).  
2. **Install PHP dependencies**
   ```powershell
   cd d:\Antigravity\Internship\silinexglobal\silinex-cms
   php composer.phar install
   ```
3. **Create the SQLite database**
   ```powershell
   php setup_db.php
   ```
   You should see `Database created successfully!`.
4. **Start the development server**
   ```powershell
   php -S 127.0.0.1:8080 -t d:\Antigravity\Internship\silinexglobal\silinex-cms d:\Antigravity\Internship\silinexglobal\silinex-cms\router.php
   ```
   The server will listen on **http://127.0.0.1:8080**.

## Accessing the CMS
- Open a browser and navigate to **http://127.0.0.1:8080/cms/**.
- You will be redirected to the login page.  
- Default admin credentials (as defined in `setup_db.php`):
  - **Email:** `admin@silinexglobal.com`
  - **Password:** `Admin@1234` (change immediately after first login).

## Running the Website
- Any request that does **not** start with `/cms/` is served from the sibling `silinex/` folder.
- Example: **http://127.0.0.1:8080/** loads the public site.

## Git Workflow (already initialized)
```powershell
# Stage all changes
git add .
# Commit the initial version
git commit -m "Initial commit – CMS and website skeleton"
# Push to the remote repository
git push origin main   # replace ‘main’ with your default branch name
```

## Troubleshooting
- **Missing `silinex/index.php`** – The router expects the website entry point at `../silinex/silinex/index.php`.  The recent fix in `router.php` points to the correct nested folder.
- **Port already in use** – Choose another port, e.g. `-S 127.0.0.1:8081`.
- **Database errors** – Delete `data/silinex.sqlite` and rerun `php setup_db.php` to recreate the DB.

---
*Happy coding!*
