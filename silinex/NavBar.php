<?php
$current = $current ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$current = rtrim($current, '/') ?: '/';

$mega_copy = [
  'Services' => [
    'eyebrow' => 'What we do',
    'title' => 'Technology, talent and managed services for growing teams.',
    'desc' => 'Explore focused Silinex capabilities built around staffing, Oracle, GRC and enterprise application support.',
  ],
  'Industries' => [
    'eyebrow' => 'Industries',
    'title' => 'Domain-led solutions for modern enterprises.',
    'desc' => 'See how our delivery teams support real estate, retail, healthcare, energy, enterprise and education technology.',
  ],
  'Customer Success' => [
    'eyebrow' => 'Customer success',
    'title' => 'Partnerships and outcomes that compound.',
    'desc' => 'Browse client stories, alliances and measurable results from Silinex engagements.',
  ],
  'About' => [
    'eyebrow' => 'Who we are',
    'title' => 'A consulting partner built on execution and trust.',
    'desc' => 'Learn about our company, leadership thinking, values and latest insights.',
  ],
];
?>

<header class="site-header" id="siteHeader">
  <div class="container header-inner">
    <a href="/" class="logo-wrap" aria-label="Silinex Global Home">
      <img class="logo-dark" src="<?= CDN ?>/firm/assets/images/693d415aae1a4.png" alt="Silinex Global" width="160" height="46" loading="eager">
      <img class="logo-light" src="<?= CDN ?>/firm/assets/images/693d416941fe9.png" alt="Silinex Global" width="160" height="46" loading="eager">
    </a>

    <nav class="main-nav" id="mainNav" aria-label="Main navigation">
      <ul class="nav-list" role="list">
        <?php foreach ($nav_items as $item):
          $href = $item['href'];
          $active = ($href === '/' ? $current === '/' : str_starts_with($current, $href));
          $has_dropdown = !empty($item['sub']);
          $copy = $mega_copy[$item['label']] ?? null;
        ?>
        <li class="nav-item<?= $has_dropdown ? ' has-dropdown' : '' ?>">
          <a href="<?= htmlspecialchars($href) ?>" class="nav-link<?= $active ? ' active' : '' ?>" <?= $has_dropdown ? 'aria-haspopup="true" aria-expanded="false"' : '' ?>>
            <span><?= htmlspecialchars($item['label']) ?></span>
            <?php if ($has_dropdown): ?>
            <svg class="chevron" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
            <?php endif; ?>
          </a>

          <?php if ($has_dropdown): ?>
          <div class="mega-menu" role="region" aria-label="<?= htmlspecialchars($item['label']) ?> menu">
            <div class="container mega-inner">
              <div class="mega-intro">
                <p class="mega-eyebrow"><?= htmlspecialchars($copy['eyebrow'] ?? $item['label']) ?></p>
                <h2><?= htmlspecialchars($copy['title'] ?? $item['label']) ?></h2>
                <p><?= htmlspecialchars($copy['desc'] ?? 'Explore Silinex Global services and resources.') ?></p>
                <a href="<?= htmlspecialchars($href) ?>" class="mega-feature-link">
                  Discover more
                  <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </a>
              </div>

              <div class="mega-links">
                <?php foreach ($item['sub'] as $sub): ?>
                <a href="<?= htmlspecialchars($sub['href']) ?>" class="mega-card">
                  <span class="mega-dot" aria-hidden="true"></span>
                  <span><?= htmlspecialchars($sub['label']) ?></span>
                </a>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="header-actions">
      <a href="/contact#contact" class="btn btn-outline-navy header-contact" style="font-size: 0.82rem; padding: 10px 24px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">
        Get to Know
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 2px"><path d="M7 17L17 7M17 7H7M17 7V17"/></svg>
      </a>
      <button class="hamburger" id="menuToggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="mainNav">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<div class="nav-overlay" id="navOverlay" aria-hidden="true"></div>
