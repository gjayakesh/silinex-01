<?php
/**
 * Silinex — Main router (PHP built-in dev server).
 *
 * Run from inside the silinex/ folder:
 *   cd path/to/silinexglobal/silinex
 *   php -S 127.0.0.1:8080 -t . router.php
 *
 * URLs:
 *   http://127.0.0.1:8080/           → main site
 *   http://127.0.0.1:8080/admin-data → data viewer (password: admin123)
 *   http://127.0.0.1:8080/cms/       → CMS admin
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// ── 1. Silinex static files (CSS, JS, images inside silinex/) ─────────────
if ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false; // Built-in server serves it
}

// ── 2. CMS requests (/cms/*) ──────────────────────────────────────────────
if (strpos($uri, '/cms') === 0) {

    $cmsRoot    = realpath(__DIR__ . '/../silinex-cms');
    $cmsRelPath = substr($uri, 4); // strip /cms  =>  /assets/css/cms.css
    if ($cmsRelPath === '' || $cmsRelPath === false) $cmsRelPath = '/';

    $cmsFile = $cmsRoot . $cmsRelPath;

    // Static asset extensions — serve with readfile() (return false doesn't
    // work when this router is required rather than being the top-level router)
    static $staticExts = ['css','js','png','jpg','jpeg','webp','gif','svg',
                          'ico','woff','woff2','ttf','eot','map'];

    $ext = strtolower(pathinfo($cmsRelPath, PATHINFO_EXTENSION));

    if (in_array($ext, $staticExts) && file_exists($cmsFile) && !is_dir($cmsFile)) {
        $mimeMap = [
            'css'  => 'text/css; charset=utf-8',
            'js'   => 'application/javascript; charset=utf-8',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'webp' => 'image/webp',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'ico'  => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2'=> 'font/woff2',
            'ttf'  => 'font/ttf',
            'eot'  => 'application/vnd.ms-fontobject',
            'map'  => 'application/json',
        ];
        header('Content-Type: ' . ($mimeMap[$ext] ?? 'application/octet-stream'));
        header('Content-Length: ' . filesize($cmsFile));
        header('Cache-Control: public, max-age=3600');
        readfile($cmsFile);
        exit;
    }

    // PHP / dynamic CMS request — delegate to CMS router
    require $cmsRoot . '/router.php';
    exit;
}

// ── 3. Main site front controller ─────────────────────────────────────────
require __DIR__ . '/index.php';
