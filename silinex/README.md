# Silinex Global Services Website

This is a PHP website for Silinex Global Services with clean routing, responsive pages, AJAX forms, search, newsletter signup, SEO files, and a database-backed contact/newsletter system.

The site runs without a separate database server by default because it uses SQLite at `data/silinex.sqlite`. If you deploy to hosting that provides MySQL, switch the database settings in `includes/config.php`.

## Main Features

- Responsive PHP website with pages for Home, Services, Industries, About, Careers, Blog, Success Stories, Contact, Privacy, and Terms.
- Clean URLs through `index.php`, `router.php`, and `.htaccess`.
- AJAX contact form connected to the `contact_messages` database table.
- AJAX newsletter form connected to the `newsletter_subscribers` database table.
- Site search API using the search index in `includes/config.php`.
- SEO support with canonical URLs, Open Graph tags, sitemap, robots file, and structured data.
- Protected `data/` directory for private database files.

## Project Structure

```text
silinex/
|-- .htaccess                  Apache rewrite, cache, and security rules
|-- index.php                  Main front controller and route dispatcher
|-- router.php                 PHP built-in server router
|-- sitemap.php                Dynamic XML sitemap
|-- robots.txt                 Search engine crawl rules
|-- README.md                  Project documentation
|
|-- api/
|   |-- contact.php            Saves contact messages and sends notification email
|   |-- newsletter.php         Saves newsletter subscribers and sends notification email
|   `-- search.php             Returns JSON search results
|
|-- assets/
|   |-- css/style.css          Website styling
|   `-- js/main.js             Menu, sliders, tabs, search, and AJAX form logic
|
|-- data/
|   |-- .htaccess              Blocks browser access to data files
|   |-- README.txt             Data directory note
|   |-- schema.sql             Database table reference
|   `-- silinex.sqlite         Auto-created SQLite database file
|
|-- includes/
|   |-- config.php             Site constants, navigation, search index, DB settings
|   |-- database.php           PDO database connection and table creation
|   |-- footer.php             Shared footer
|   |-- header.php             Shared head/header/navigation
|   `-- seo.php                JSON-LD structured data
|
`-- pages/
    |-- about.php
    |-- blog.php
    |-- career.php
    |-- contact.php
    |-- home.php
    |-- industries.php
    |-- privacy.php
    |-- search.php
    |-- services.php
    |-- success-stories.php
    `-- terms.php
```

## Requirements

- PHP 8.0 or newer
- PDO extension
- `pdo_sqlite` for the default database setup
- Apache with `mod_rewrite` for production clean URLs
- Optional: `pdo_mysql` for MySQL hosting

Check PHP and extensions:

```bash
php -v
php -m
```

## Run Locally

From the project folder:

```bash
php -S 127.0.0.1:8080 -t . router.php
```

Open:

```text
http://127.0.0.1:8080/
```

Useful local URLs:

```text
http://127.0.0.1:8080/
http://127.0.0.1:8080/services
http://127.0.0.1:8080/industries
http://127.0.0.1:8080/about
http://127.0.0.1:8080/career
http://127.0.0.1:8080/blog
http://127.0.0.1:8080/contact
http://127.0.0.1:8080/search?q=oracle
http://127.0.0.1:8080/sitemap.xml
http://127.0.0.1:8080/cms/
```

### Run Website And CMS On One Server

Keep these folders next to each other:

```text
Internship/
|-- silinex/
`-- silinex-cms/
```

Then start only the website server from `silinex/`:

```bash
cd D:\Antigravity\Internship\silinex
php -S 127.0.0.1:8080 -t . router.php
```

Open the website at:

```text
http://127.0.0.1:8080/
```

Open the CMS at:

```text
http://127.0.0.1:8080/cms/
```

## Database Setup

The database is created automatically on first form submission or whenever `db()` is called from `includes/database.php`.

Default SQLite settings in `includes/config.php`:

```php
define('DB_DRIVER', 'sqlite');
define('DB_PATH', __DIR__ . '/../data/silinex.sqlite');
```

The created tables are:

```text
contact_messages
newsletter_subscribers
```

Reference schema is stored in:

```text
data/schema.sql
```

### Contact Messages Table

Stores messages from `/contact`.

Columns:

```text
id
name
email
phone
subject
message
ip_address
user_agent
created_at
```

### Newsletter Subscribers Table

Stores subscribers from `/blog`.

Columns:

```text
id
email
ip_address
user_agent
created_at
```

The `email` column is unique so duplicate subscriptions are prevented.

## Switch To MySQL

Create a MySQL database:

```sql
CREATE DATABASE silinex CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Update `includes/config.php`:

```php
define('DB_DRIVER', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'silinex');
define('DB_USER', 'your_mysql_user');
define('DB_PASS', 'your_mysql_password');
define('DB_CHARSET', 'utf8mb4');
```

The site will create the required tables automatically when the database connection is first used.

## API Endpoints

### Contact Form

Endpoint:

```text
POST /api/contact.php
```

Fields:

```text
name      required
email     required
phone     optional
subject   optional
message   required
website   hidden honeypot field
```

Example command:

```bash
curl -X POST http://127.0.0.1:8080/api/contact.php \
  -d "name=Test User" \
  -d "email=test@example.com" \
  -d "phone=9876543210" \
  -d "subject=General Enquiry" \
  -d "message=This is a test message from the website."
```

What happens:

1. The PHP endpoint validates the form values.
2. Bot submissions are ignored through the hidden honeypot field.
3. Valid messages are inserted into `contact_messages`.
4. The site attempts to send an email notification to `SITE_EMAIL`.
5. JSON is returned to the browser and shown in the form message area.

### Newsletter Form

Endpoint:

```text
POST /api/newsletter.php
```

Fields:

```text
email   required
url     hidden honeypot field
```

Example command:

```bash
curl -X POST http://127.0.0.1:8080/api/newsletter.php \
  -d "email=reader@example.com"
```

What happens:

1. The PHP endpoint validates the email.
2. Bot submissions are ignored through the hidden honeypot field.
3. The endpoint checks for an existing subscriber.
4. New subscribers are inserted into `newsletter_subscribers`.
5. The site attempts to send an email notification to `SITE_EMAIL`.
6. JSON is returned to the browser.

### Search API

Endpoint:

```text
GET /api/search.php?q=oracle&limit=7
```

Example command:

```bash
curl "http://127.0.0.1:8080/api/search.php?q=oracle&limit=7"
```

Search data comes from `$search_index` in `includes/config.php`. Results are scored by title, description, tags, and fuzzy title matching.

## How The Website Works

### Routing

`index.php` reads the current URL path and loads the matching file from `pages/`.

Examples:

```text
/                  -> pages/home.php
/services          -> pages/services.php
/contact           -> pages/contact.php
/privacy-policy    -> pages/privacy.php
/terms-condition   -> pages/terms.php
```

API requests under `/api/` are handled by the endpoint files in the `api/` folder.

### Shared Layout

Each page includes:

```php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
```

Most pages end with:

```php
require_once __DIR__ . '/../includes/footer.php';
```

This keeps the navigation, SEO, footer, floating WhatsApp button, and shared assets consistent across the website.

### Frontend JavaScript

`assets/js/main.js` handles:

- Page loader
- Sticky header
- Mobile navigation
- Hero slider
- Industry tabs
- Technology tabs
- Testimonial slider
- FAQ accordion
- Search autocomplete
- Contact form AJAX submission
- Scroll animations
- Counter animations

### Contact Page

`pages/contact.php` displays company contact details, WhatsApp link, social links, Google Map, and the contact form.

When the form is submitted, JavaScript sends the form data to:

```text
/api/contact.php
```

The endpoint saves the message to the database and returns a JSON success or error message.

### Blog Newsletter

`pages/blog.php` contains the newsletter form.

When submitted, inline JavaScript sends the email to:

```text
/api/newsletter.php
```

The endpoint saves the subscriber to the database and prevents duplicates.

## View Database Records

### Browser Admin Viewer

The project includes a private browser page for viewing stored records:

```text
http://127.0.0.1:8080/admin-data
```

On Windows, the easiest way is to double-click:

```text
open-admin-data.bat
```

This starts the PHP server and opens the data viewer automatically.

Default password:

```text
admin123
```

Change the password before deployment in `includes/config.php`:

```php
define('ADMIN_DATA_PASSWORD', 'your-strong-password');
```

After login, the page shows:

- Contact messages from `contact_messages`
- Newsletter subscribers from `newsletter_subscribers`
- Counts for both tables
- Newest records first

The page file is:

```text
pages/admin-data.php
```

The route is registered in:

```text
index.php
```

### Command Line

If SQLite CLI is installed:

```bash
sqlite3 data/silinex.sqlite ".tables"
sqlite3 data/silinex.sqlite "SELECT id, name, email, subject, created_at FROM contact_messages ORDER BY id DESC;"
sqlite3 data/silinex.sqlite "SELECT id, email, created_at FROM newsletter_subscribers ORDER BY id DESC;"
```

You can also inspect SQLite data with tools like DB Browser for SQLite.

## Configuration

Main settings are in `includes/config.php`:

```php
define('SITE_NAME', 'Silinex Global Services');
define('SITE_URL', 'https://www.silinexglobal.com');
define('SITE_EMAIL', 'info@silinexglobal.com');
define('SITE_PHONE', '+91 868 894 5694');
define('SITE_ADDRESS', '...');
define('CDN', 'https://www.silinexglobal.com');
```

Update these values when deploying to a new domain or changing business contact details.

## Deployment Notes

1. Upload the project files to your web root.
2. Make sure Apache allows `.htaccess` overrides.
3. Keep `data/` protected from public access.
4. Confirm PHP has PDO and either `pdo_sqlite` or `pdo_mysql`.
5. Update `SITE_URL`, `SITE_EMAIL`, phone, address, and database settings.
6. Configure real SMTP mail for production if your hosting does not support PHP `mail()`.
7. Test `/contact`, `/blog`, `/search`, `/sitemap.xml`, and `/robots.txt`.

Apache virtual host example:

```apache
<Directory /var/www/html>
    AllowOverride All
    Require all granted
</Directory>
```

Enable rewrite on Ubuntu:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

## Production Checklist

- Update site constants in `includes/config.php`.
- Confirm database connection settings.
- Test contact form database insertion.
- Test newsletter subscription database insertion.
- Configure SMTP or transactional email service.
- Enable HTTPS.
- Submit `/sitemap.xml` to Google Search Console.
- Test mobile navigation and all main pages.
- Run a Lighthouse check for performance, accessibility, and SEO.

## Troubleshooting

If form submission fails:

```bash
php -m
```

Confirm `PDO` and `pdo_sqlite` or `pdo_mysql` are listed.

If SQLite cannot write:

```bash
chmod 700 data
```

If Apache clean URLs do not work:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

Also confirm the virtual host has `AllowOverride All`.

If emails do not arrive, the database may still be saving records correctly. PHP `mail()` depends on server mail configuration, so production should use SMTP through PHPMailer, SendGrid, Mailgun, or a similar provider.

## License

This project is for Silinex Global Services website development. Brand assets, logo, and business content belong to Silinex Global Services Pvt. Ltd.
#   s i l i n e x - 1  
 