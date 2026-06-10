<?php
/**
 * Silinex CMS — PHP Router
 *
 * Called by silinex/router.php for all /cms/* dynamic PHP requests.
 * Also works standalone:
 *   php -S 127.0.0.1:8081 -t . router.php   (from inside silinex-cms/)
 *
 * __DIR__ always = silinex-cms/ regardless of who required this file.
 */

$docRoot = __DIR__;
$uri     = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ── Strip /cms prefix (requests arrive as /cms/login.php etc.) ─────────────
if (strpos($uri, '/cms/') === 0) {
    $localUri = '/' . substr($uri, 5); // /cms/login.php -> /login.php
} elseif ($uri === '/cms') {
    $localUri = '/';
} else {
    $localUri = $uri; // running standalone, already relative
}
$localUri = $localUri ?: '/';

$filePath = $docRoot . $localUri;

// ── Directory index ────────────────────────────────────────────────────────
if (is_dir($filePath)) {
    $index = rtrim($filePath, '/') . '/index.php';
    if (file_exists($index)) {
        require $index;
        exit;
    }
}

// ── Exact .php file ────────────────────────────────────────────────────────
if (file_exists($filePath) && !is_dir($filePath)) {
    require $filePath;
    exit;
}

// ── Try appending .php ─────────────────────────────────────────────────────
if (file_exists($filePath . '.php')) {
    require $filePath . '.php';
    exit;
}

// ── Clean URL shortcuts ────────────────────────────────────────────────────
$cleanRoutes = [
    '/'          => '/index.php',
    '/login'     => '/login.php',
    '/logout'    => '/logout.php',
    '/dashboard' => '/dashboard.php',
];
$clean = rtrim($localUri, '/') ?: '/';
if (isset($cleanRoutes[$clean])) {
    require $docRoot . $cleanRoutes[$clean];
    exit;
}

// ── 404 fallback ───────────────────────────────────────────────────────────
http_response_code(404);
echo '<h2 style="font-family:sans-serif;padding:40px;">CMS page not found: ' . htmlspecialchars($localUri) . '</h2>';
