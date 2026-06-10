<?php
/**
 * Silinex Global Services — Main Website Frontend
 * Reads published content from the CMS database.
 * Handles preview tokens to show draft content when coming from the CMS.
 *
 * Runs on: http://127.0.0.1:8080
 */

$cmsIncludes = __DIR__ . '/../../silinex/includes';

require_once $cmsIncludes . '/config.php';
require_once $cmsIncludes . '/db.php';
require_once $cmsIncludes . '/versions.php';

// ── Preview token validation ────────────────────────────────────────────────
$isPreview = false;
$previewVersionNumber = null;
if (isset($_GET['preview'], $_GET['token']) && $_GET['preview'] === '1') {
    $raw   = base64_decode($_GET['token']);
    $token = json_decode($raw, true);

    if (
        is_array($token) &&
        isset($token['page'], $token['user_id'], $token['expires'], $token['signature']) &&
        $token['expires'] > time()
    ) {
        $signaturePayload = $token['page'] . $token['user_id'] . ($token['version'] ?? '');
        $expectedSig = hash_hmac('sha256', $signaturePayload, CMS_SECRET_KEY);
        if (hash_equals($expectedSig, $token['signature'])) {
            $isPreview = true;
            $previewVersionNumber = $token['version'] ?? null;
        }
    }
}

if (!$previewVersionNumber && preg_match('#^/preview/([0-9]+\.[0-9]{2})#', parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '', $match)) {
    $isPreview = true;
    $previewVersionNumber = $match[1];
}

// Status filter: preview shows draft + published; normal shows published only
$statusIn = $isPreview ? "('draft','published')" : "('published')";

// ── Route: determine which page to load ─────────────────────────────────────
$slug = trim($_GET['p'] ?? 'home', '/');
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug)) ?: 'home';

$versionSnapshot = load_version_site_snapshot($pdo, $previewVersionNumber);
$page = null;
$sections = [];
$navItems = [];

if ($versionSnapshot) {
    $versionPages = $versionSnapshot['pages'];
    $versionPage = $versionPages[$slug] ?? ($slug !== 'home' ? ($versionPages['home'] ?? null) : null);
    if ($versionPage) {
        $page = $versionPage['page'];
        $sections = array_values(array_filter($versionPage['sections'], static function ($section) use ($isPreview) {
            return $isPreview || ($section['status'] ?? 'published') === 'published';
        }));
        usort($sections, static fn($a, $b) => ((int)($a['section_order'] ?? 0)) <=> ((int)($b['section_order'] ?? 0)));
        $navItems = array_values(array_filter($versionSnapshot['navbar'], static fn($item) => (int)($item['is_visible'] ?? 1) === 1));
    }
}

if (!$page) {
    $pageStmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ? AND status IN {$statusIn}");
    $pageStmt->execute([$slug]);
    $page = $pageStmt->fetch();
}

// Fallback: try home
if (!$page && $slug !== 'home') {
    $pageStmt->execute(['home']);
    $page = $pageStmt->fetch();
    if (!$page) { http_response_code(404); include '404.php'; exit; }
} elseif (!$page) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

// ── Load sections ────────────────────────────────────────────────────────────
if (!$sections && empty($versionSnapshot)) {
    $secStmt = $pdo->prepare(
        "SELECT * FROM sections
         WHERE page_id = ? AND status IN {$statusIn}
         ORDER BY section_order ASC"
    );
    $secStmt->execute([$page['id']]);
    $sections = $secStmt->fetchAll();
}

// ── Load nav items ────────────────────────────────────────────────────────────
if (!$navItems) {
    $navItems = $pdo->query(
        "SELECT n.*, n.href AS page_slug
         FROM navbar_items n
         WHERE n.is_visible = 1
         ORDER BY n.nav_order ASC"
    )->fetchAll();
}

// ── Helpers ──────────────────────────────────────────────────────────────────
function e(string $str): string { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }

function render_section(array $section, bool $isPreview): void {
    $content  = json_decode($section['content'] ?? '{}', true) ?: [];
    $bgMap    = [
        'white'      => 'background:#fff;',
        'light-blue' => 'background:#E8F0FB;',
        'dark-navy'  => 'background:#0B1C3D;color:#fff;',
    ];
    $bg = $bgMap[$section['bg_theme'] ?? 'white'] ?? 'background:#fff;';

    // Draft watermark in preview mode
    $draftBadge = '';
    if ($isPreview && $section['status'] === 'draft') {
        $draftBadge = '<div style="position:absolute;top:10px;right:10px;background:#F47B20;color:#fff;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;z-index:10;letter-spacing:0.05em;">DRAFT</div>';
    }

    echo '<section style="position:relative;' . $bg . '">';
    echo $draftBadge;
    echo '<div style="max-width:1200px;margin:0 auto;padding:80px 24px;">';

    switch ($section['section_type']) {

        // ── HERO ────────────────────────────────────────────────────────────
        case 'hero':
            $heading   = e($content['heading']            ?? 'Welcome to Silinex Global Services');
            $sub       = e($content['subheading']         ?? '');
            $ctaPLabel = e($content['cta_primary_label']  ?? $content['primary_label']   ?? $content['cta_primary']['label']   ?? '');
            $ctaPHref  = e($content['cta_primary_href']   ?? $content['primary_url']     ?? $content['cta_primary']['href']    ?? '#');
            $ctaSLabel = e($content['cta_secondary_label']?? $content['secondary_label'] ?? $content['cta_secondary']['label'] ?? '');
            $ctaSHref  = e($content['cta_secondary_href'] ?? $content['secondary_url']   ?? $content['cta_secondary']['href']  ?? '#');
            $textColor = ($section['bg_theme'] === 'dark-navy') ? '#fff' : '#0B1C3D';
            echo "
              <div style='max-width:760px;'>
                <h1 style='font-family:Manrope,sans-serif;font-size:52px;font-weight:800;color:{$textColor};line-height:1.15;margin:0 0 24px;'>{$heading}</h1>
                " . ($sub ? "<p style='font-size:18px;color:" . ($section['bg_theme']==='dark-navy' ? 'rgba(255,255,255,0.75)' : '#4A5568') . ";line-height:1.7;margin:0 0 40px;'>{$sub}</p>" : '') . "
                <div style='display:flex;gap:16px;flex-wrap:wrap;'>
                  " . ($ctaPLabel ? "<a href='{$ctaPHref}' style='display:inline-block;background:#0057B8;color:#fff;padding:14px 32px;border-radius:50px;font-family:Inter,sans-serif;font-weight:600;font-size:16px;text-decoration:none;'>{$ctaPLabel}</a>" : '') . "
                  " . ($ctaSLabel ? "<a href='{$ctaSHref}' style='display:inline-block;border:2px solid " . ($section['bg_theme']==='dark-navy' ? 'rgba(255,255,255,0.5)' : '#0057B8') . ";color:" . ($section['bg_theme']==='dark-navy' ? '#fff' : '#0057B8') . ";padding:12px 32px;border-radius:50px;font-family:Inter,sans-serif;font-weight:600;font-size:16px;text-decoration:none;'>{$ctaSLabel}</a>" : '') . "
                </div>
              </div>
            ";
            break;

        // ── ABOUT ────────────────────────────────────────────────────────────
        case 'about':
            $heading = e($content['heading'] ?? '');
            $body    = e($content['body']    ?? '');
            $img     = e($content['image']   ?? '');
            echo "
              <div style='display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;'>
                <div>
                  " . ($heading ? "<h2 style='font-family:Manrope,sans-serif;font-size:36px;font-weight:800;color:#0B1C3D;margin:0 0 20px;'>{$heading}</h2>" : '') . "
                  " . ($body ? "<p style='font-family:Inter,sans-serif;font-size:16px;color:#4A5568;line-height:1.8;'>{$body}</p>" : '') . "
                </div>
                " . ($img ? "<img src='{$img}' alt='' style='width:100%;border-radius:16px;object-fit:cover;'>" : '<div style="background:#E8F0FB;height:320px;border-radius:16px;"></div>') . "
              </div>
            ";
            break;

        // ── SERVICES ─────────────────────────────────────────────────────────
        case 'services':
            $items = $content['items'] ?? [];
            echo '<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;">';
            foreach ($items as $item) {
                $icon  = e($item['icon']        ?? '');
                $title = e($item['title']       ?? '');
                $desc  = e($item['description'] ?? '');
                echo "
                  <div style='background:#fff;border:1px solid #E2E8F0;border-radius:16px;padding:28px;'>
                    " . ($icon ? "<div style='font-size:32px;margin-bottom:16px;'>{$icon}</div>" : '') . "
                    <h3 style='font-family:Manrope,sans-serif;font-size:18px;font-weight:700;color:#0B1C3D;margin:0 0 10px;'>{$title}</h3>
                    <p  style='font-family:Inter,sans-serif;font-size:14px;color:#4A5568;line-height:1.7;margin:0;'>{$desc}</p>
                  </div>
                ";
            }
            echo '</div>';
            break;

        // ── STATS ────────────────────────────────────────────────────────────
        case 'stats':
            $items = $content['items'] ?? [];
            echo '<div style="display:flex;gap:40px;flex-wrap:wrap;justify-content:center;">';
            foreach ($items as $item) {
                $number = e($item['number'] ?? '');
                $label  = e($item['label']  ?? '');
                $tc     = ($section['bg_theme'] === 'dark-navy') ? '#fff' : '#0B1C3D';
                $mc     = ($section['bg_theme'] === 'dark-navy') ? 'rgba(255,255,255,0.7)' : '#4A5568';
                echo "
                  <div style='text-align:center;min-width:160px;'>
                    <div style='font-family:Manrope,sans-serif;font-size:52px;font-weight:800;color:#F47B20;line-height:1;'>{$number}</div>
                    <div style='font-family:Inter,sans-serif;font-size:15px;color:{$mc};margin-top:8px;'>{$label}</div>
                  </div>
                ";
            }
            echo '</div>';
            break;

        // ── TESTIMONIALS ─────────────────────────────────────────────────────
        case 'testimonial':
            $items = $content['items'] ?? [];
            echo '<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;">';
            foreach ($items as $item) {
                $quote  = e($item['quote']  ?? '');
                $author = e($item['author'] ?? '');
                $role   = e($item['role']   ?? '');
                echo "
                  <div style='background:#fff;border:1px solid #E2E8F0;border-radius:16px;padding:28px;'>
                    <p style='font-family:Inter,sans-serif;font-size:15px;color:#4A5568;line-height:1.8;font-style:italic;margin:0 0 20px;'>&ldquo;{$quote}&rdquo;</p>
                    <div style='font-family:Manrope,sans-serif;font-size:14px;font-weight:700;color:#0B1C3D;'>{$author}</div>
                    <div style='font-family:Inter,sans-serif;font-size:12px;color:#718096;'>{$role}</div>
                  </div>
                ";
            }
            echo '</div>';
            break;

        // ── FAQ ──────────────────────────────────────────────────────────────
        case 'faq':
            $items = $content['items'] ?? [];
            echo '<div style="max-width:760px;margin:0 auto;">';
            foreach ($items as $i => $item) {
                $q = e($item['question'] ?? '');
                $a = e($item['answer']   ?? '');
                echo "
                  <details style='border-bottom:1px solid #E2E8F0;padding:20px 0;'>
                    <summary style='font-family:Manrope,sans-serif;font-size:17px;font-weight:700;color:#0B1C3D;cursor:pointer;list-style:none;'>{$q}</summary>
                    <p style='font-family:Inter,sans-serif;font-size:15px;color:#4A5568;line-height:1.8;margin:16px 0 0;'>{$a}</p>
                  </details>
                ";
            }
            echo '</div>';
            break;

        // ── CTA BANNER ───────────────────────────────────────────────────────
        case 'cta-banner':
            $heading  = e($content['heading']   ?? '');
            $ctaLabel = e($content['cta_label'] ?? '');
            $ctaHref  = e($content['cta_href']  ?? '#');
            $tc = ($section['bg_theme'] === 'dark-navy') ? '#fff' : '#0B1C3D';
            echo "
              <div style='text-align:center;'>
                " . ($heading ? "<h2 style='font-family:Manrope,sans-serif;font-size:36px;font-weight:800;color:{$tc};margin:0 0 32px;'>{$heading}</h2>" : '') . "
                " . ($ctaLabel ? "<a href='{$ctaHref}' style='display:inline-block;background:#F47B20;color:#fff;padding:16px 40px;border-radius:50px;font-family:Inter,sans-serif;font-weight:700;font-size:16px;text-decoration:none;'>{$ctaLabel}</a>" : '') . "
              </div>
            ";
            break;

        // ── CUSTOM HTML ──────────────────────────────────────────────────────
        case 'custom-html':
            // Only output raw HTML — do NOT escape
            echo $content['html'] ?? '';
            break;

        default:
            if ($isPreview) {
                echo "<p style='color:#718096;font-style:italic;'>Unknown section type: " . e($section['section_type']) . "</p>";
            }
    }

    echo '</div></section>';
}

// ── Page metadata ─────────────────────────────────────────────────────────────
$metaTitle = e($page['meta_title'] ?: $page['title'] . ' — Silinex Global Services');
$metaDesc  = e($page['meta_desc']  ?? 'Silinex Global Services — Empowering Businesses Through Technology & Talent.');

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $metaTitle ?></title>
  <meta name="description" content="<?= $metaDesc ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <?php if ($isPreview): ?>
  <style>
    body { outline: 3px solid #F47B20; }
    .preview-bar {
      position: fixed; top: 0; left: 0; right: 0; z-index: 9999;
      background: #F47B20; color: #fff;
      font-family: Inter, sans-serif; font-size: 13px; font-weight: 600;
      padding: 8px 20px; text-align: center; letter-spacing: 0.04em;
    }
    body { padding-top: 36px; }
  </style>
  <?php endif; ?>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { font-size: 16px; scroll-behavior: smooth; }
    body { font-family: Inter, sans-serif; color: #4A5568; background: #fff; }
    nav { height: 72px; background: #fff; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; justify-content: space-between; padding: 0 40px; position: sticky; top: <?= $isPreview ? '36px' : '0' ?>; z-index: 100; }
    nav .logo { font-family: Manrope, sans-serif; font-size: 22px; font-weight: 800; color: #0B1C3D; text-decoration: none; }
    nav .logo span { color: #F47B20; }
    nav ul { list-style: none; display: flex; align-items: center; gap: 8px; }
    nav ul a { font-family: Inter, sans-serif; font-size: 15px; font-weight: 500; color: #4A5568; text-decoration: none; padding: 8px 14px; border-radius: 8px; transition: color 0.15s; }
    nav ul a:hover { color: #0057B8; }
    nav ul a.btn-nav-primary { background: #0057B8; color: #fff; border-radius: 50px; padding: 10px 22px; }
    nav ul a.btn-nav-accent  { background: #F47B20; color: #fff; border-radius: 50px; padding: 10px 22px; }
    nav ul a.btn-nav-primary:hover { background: #003F87; }
    nav ul a.btn-nav-accent:hover  { background: #d96a14; }
    footer { background: #0B1C3D; color: rgba(255,255,255,0.6); text-align: center; padding: 32px 24px; font-family: Inter, sans-serif; font-size: 14px; }
    footer strong { color: #fff; }
    details summary::-webkit-details-marker { display: none; }
  </style>
</head>
<body>

<?php if ($isPreview): ?>
<div class="preview-bar">⚠️ CMS PREVIEW MODE — Showing draft content — Changes not yet live</div>
<?php endif; ?>

<!-- NAVBAR -->
<nav>
  <a class="logo" href="/">Silinex<span>.</span></a>
  <ul>
    <?php foreach ($navItems as $item):
      $href     = $item['href'] ?: '/?p=' . ($item['page_slug'] ?? '#');
      $label    = e($item['label']);
      $isActive = ($item['page_slug'] ?? '') === $slug;
      $btnClass = '';
      if ($item['is_cta_button']) {
          $btnClass = $item['cta_style'] === 'accent' ? ' btn-nav-accent' : ' btn-nav-primary';
      }
    ?>
    <li><a href="<?= e($href) ?>" class="<?= $isActive ? 'active' : '' ?><?= $btnClass ?>"><?= $label ?></a></li>
    <?php endforeach; ?>
  </ul>
</nav>

<!-- PAGE SECTIONS -->
<?php if ($sections): ?>
  <?php foreach ($sections as $section): ?>
    <?php render_section($section, $isPreview); ?>
  <?php endforeach; ?>
<?php else: ?>
  <div style="max-width:760px;margin:80px auto;padding:0 24px;text-align:center;">
    <h1 style="font-family:Manrope,sans-serif;font-size:36px;font-weight:800;color:#0B1C3D;">
      <?= e($page['title']) ?>
    </h1>
    <p style="color:#718096;margin-top:16px;">This page has no content sections yet.</p>
    <?php if ($isPreview): ?>
    <a href="<?= e(CMS_URL) ?>/cms/pages/page-edit.php?id=<?= $page['id'] ?>"
       style="display:inline-block;margin-top:24px;background:#0057B8;color:#fff;padding:12px 28px;border-radius:50px;font-family:Inter,sans-serif;font-weight:600;text-decoration:none;">
      Add Sections in CMS →
    </a>
    <?php endif; ?>
  </div>
<?php endif; ?>

<!-- FOOTER -->
<footer>
  <strong>Silinex Global Services</strong><br>
  Empowering Businesses Through Technology &amp; Talent<br>
  <span style="font-size:12px;margin-top:8px;display:block;">© <?= date('Y') ?> Silinex Global Services. All rights reserved.</span>
</footer>

</body>
</html>
