<?php
// index.php – Front Controller (all requests routed here via .htaccess)

require_once __DIR__ . '/includes/config.php';

// Parse the clean URL path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

// ── Route table ───────────────────────────────────────────────
$routes = [
    '/' => __DIR__ . '/pages/home.php',
    '/services' => __DIR__ . '/pages/services.php',
    '/about' => __DIR__ . '/pages/about.php',
    '/contact' => __DIR__ . '/pages/contact.php',
    '/career' => __DIR__ . '/pages/career.php',
    '/blog' => __DIR__ . '/pages/blog.php',
    '/success-stories' => __DIR__ . '/pages/success-stories.php',
    '/search' => __DIR__ . '/pages/search.php',
    '/industries' => __DIR__ . '/pages/industries.php',
    '/privacy-policy' => __DIR__ . '/pages/privacy.php',
    '/terms-condition' => __DIR__ . '/pages/terms.php',
    '/admin-data' => __DIR__ . '/pages/admin-data.php',
    '/cms' => __DIR__ . '/../silinex-cms/site',
];

// ── API pass-through (handled by Apache before PHP, but safety net) ──
if (str_starts_with($uri, '/api/')) {
    $api_file = __DIR__ . $uri . '.php';
    if (is_file($api_file)) {
        require $api_file;
        exit;
    }
}

// ── CMS pass-through ──
if (str_starts_with($uri, '/cms')) {
    require_once __DIR__ . '/../silinex-cms/router.php';
    exit;
}

// ── Dispatch ─────────────────────────────────────────────────

if (str_starts_with($uri, '/blog/') && is_file($routes['/blog'])) {
    require $routes['/blog'];
} elseif (array_key_exists($uri, $routes) && is_file($routes[$uri])) {
    require $routes[$uri];
} else {
    // 404
    http_response_code(404);
    $page_title = '404 – Page Not Found | Silinex Global';
    $page_desc = 'The page you are looking for could not be found.';
    require_once __DIR__ . '/includes/header.php';
    ?>
    <section
        style="min-height:80vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:120px 24px 80px">
        <div>
            <div
                style="font-family:var(--font-head);font-size:8rem;font-weight:900;color:var(--blue);line-height:1;margin-bottom:8px">
                404</div>
            <h1 style="font-family:var(--font-head);font-size:2rem;font-weight:800;margin-bottom:12px">Page Not Found</h1>
            <p style="color:var(--text-muted);max-width:480px;margin:0 auto 32px;line-height:1.7">
                Sorry, the page you're looking for doesn't exist or has been moved. Let's get you back on track.
            </p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                <a href="/" class="btn btn-primary">Go Home</a>
                <a href="/services" class="btn btn-secondary">Our Services</a>
                <a href="/contact" class="btn btn-secondary">Contact Us</a>
            </div>
            <p style="margin-top:28px;font-size:.9rem;color:var(--text-muted)">
                Or try searching:
                <a href="/search" style="color:var(--blue);font-weight:600">Search the site →</a>
            </p>
        </div>
    </section>
    <?php
    require_once __DIR__ . '/includes/footer.php';
}
