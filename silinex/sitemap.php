<?php
// sitemap.php – Dynamic XML Sitemap (route this via .htaccess)
require_once __DIR__ . '/includes/config.php';

header('Content-Type: application/xml; charset=utf-8');
header('Cache-Control: public, max-age=86400');

$base = SITE_URL;
$now  = date('Y-m-d');

$urls = [
  ['loc' => '/',                'priority' => '1.00', 'changefreq' => 'weekly'],
  ['loc' => '/services',        'priority' => '0.90', 'changefreq' => 'monthly'],
  ['loc' => '/industries',      'priority' => '0.88', 'changefreq' => 'monthly'],
  ['loc' => '/services#staffing','priority'=> '0.85', 'changefreq' => 'monthly'],
  ['loc' => '/services#ams',    'priority' => '0.85', 'changefreq' => 'monthly'],
  ['loc' => '/services#grc',    'priority' => '0.85', 'changefreq' => 'monthly'],
  ['loc' => '/services#oracle', 'priority' => '0.85', 'changefreq' => 'monthly'],
  ['loc' => '/about',           'priority' => '0.80', 'changefreq' => 'monthly'],
  ['loc' => '/success-stories', 'priority' => '0.75', 'changefreq' => 'monthly'],
  ['loc' => '/blog',            'priority' => '0.75', 'changefreq' => 'weekly'],
  ['loc' => '/career',          'priority' => '0.70', 'changefreq' => 'weekly'],
  ['loc' => '/contact',         'priority' => '0.70', 'changefreq' => 'monthly'],
  ['loc' => '/privacy-policy',  'priority' => '0.30', 'changefreq' => 'yearly'],
  ['loc' => '/terms-condition', 'priority' => '0.30', 'changefreq' => 'yearly'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
foreach ($urls as $u) {
    $loc = htmlspecialchars($base . $u['loc']);
    echo "  <url>\n";
    echo "    <loc>{$loc}</loc>\n";
    echo "    <lastmod>{$now}</lastmod>\n";
    echo "    <changefreq>{$u['changefreq']}</changefreq>\n";
    echo "    <priority>{$u['priority']}</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>' . PHP_EOL;
