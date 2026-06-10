<?php
$current    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$page_title = $page_title ?? 'IT Staffing & Managed Services | Silinex Global';
$page_desc  = $page_desc  ?? 'Silinex Global Services delivers world-class IT consulting, staffing, and technology solutions powered by innovation and over 100+ years of combined industry leadership.';
$page_robots = $page_robots ?? 'index, follow';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?= htmlspecialchars($page_title) ?></title>
<meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
<meta name="robots" content="<?= htmlspecialchars($page_robots) ?>">
<meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
<meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>">
<meta property="og:image" content="<?= SITE_URL ?>/firm/assets/images/693d415aae1a4.png">
<meta property="og:type" content="website">
<link rel="canonical" href="<?= SITE_URL ?><?= htmlspecialchars($current) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="icon" href="data:,">
<?php
require_once __DIR__ . '/seo.php';
output_schema($schema_org['organization']);
output_schema($schema_org['website']);
output_schema($schema_org['local_business']);
?>
</head>
<body>

<div class="page-loader" id="pageLoader">
  <img src="<?= CDN ?>/assets/images/loader.gif" alt="Loading" width="60" height="60">
</div>

<?php include __DIR__ . '/../NavBar.php'; ?>
