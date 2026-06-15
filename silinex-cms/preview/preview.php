<?php
require_once __DIR__ . '/../includes/auth.php'; require_auth();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/versions.php';

$slug  = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['page'] ?? 'home'));
$version = preg_replace('/[^0-9\.]/', '', $_GET['version'] ?? '');
// Verify preview token
$tokenData = json_decode(base64_decode($_GET['token'] ?? ''), true);
$valid = false;
if ($tokenData && isset($tokenData['user_id'], $tokenData['page'], $tokenData['version'], $tokenData['expires'], $tokenData['signature'])) {
    $expected = hash_hmac('sha256', $tokenData['page'] . $tokenData['user_id'] . $tokenData['version'], CMS_SECRET_KEY);
    if (hash_equals($expected, $tokenData['signature']) && $tokenData['expires'] >= time() &&
        $tokenData['user_id'] == ($_SESSION['cms_user_id'] ?? null) && $tokenData['page'] == $slug) {
        $valid = true;
    }
}
if (!$valid) {
    http_response_code(403);
    echo '<h2>Invalid or expired preview token.</h2>';
    exit;
}

$sitePath = $slug === 'home' ? '/' : '/' . $slug;
$previewUrl = $version
    ? rtrim(SITE_URL, '/') . '/preview/' . rawurlencode($version) . '?p=' . urlencode($slug) . '&preview=1&token=' . urlencode($token)
    : rtrim(SITE_URL, '/') . $sitePath . '?preview=1&token=' . urlencode($token);

// Get page ID for deploy link
$pageId = 0;
require_once __DIR__ . '/../includes/db.php';
$pg = $pdo->prepare("SELECT id FROM pages WHERE slug=?");
$pg->execute([$slug]);
$pg = $pg->fetch();
if ($pg) $pageId = $pg['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preview - <?= htmlspecialchars($version ?: $slug) ?> - Silinex CMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/cms/assets/css/cms.css">
  <style>
    body { margin:0; display:flex; flex-direction:column; height:100vh; overflow:hidden; }
    #pf { flex:0 0 auto; width:100%; max-width:100%; border:none; background:#fff; transition:width 0.3s, flex-basis 0.3s; }
    .preview-frame-wrap { flex:1; overflow:auto; background:#CBD5E0; display:flex; justify-content:center; padding:20px; }
  </style>
</head>
<body>

  <!-- Preview Toolbar -->
  <div class="preview-toolbar">
    <span class="label">PREVIEWING WEBSITE: <?= $version ? 'VERSION ' . htmlspecialchars(format_version_number($version)) : strtoupper(htmlspecialchars($slug)) ?></span>

    <div style="display:flex;gap:10px;align-items:center;">
      <a href="/cms/edit-page.php?id=<?= $pageId ?>" class="btn-accent btn-sm edit-button">Edit Title</a>
      <button id="preview-tablet" class="btn-secondary btn-sm" type="button" aria-pressed="false">Tablet</button>
      <button id="preview-desktop" class="btn-secondary btn-sm active" type="button" aria-pressed="true">Desktop</button>
      <?php if (!$version): ?>
      <a href="/cms/pages/page-edit.php?id=<?= $pageId ?>" class="btn-secondary btn-sm">Edit</a>
      <?php endif; ?>
      <?php if (!$version && $pageId): ?>
      <a href="/cms/deploy/deploy.php?page_id=<?= $pageId ?>" class="btn-accent btn-sm" onclick="return confirm('Publish all draft sections of this page?')">Publish</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Preview Frame -->
  <div class="preview-frame-wrap">
    <iframe id="pf"
            src="<?= htmlspecialchars($previewUrl) ?>"
            style="width:100%;border:none;background:#fff;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,0.2);">
    </iframe>
  </div>

  <script src="/cms/assets/js/preview.js"></script>
</body>
</html>
