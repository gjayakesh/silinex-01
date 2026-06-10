<?php
$page_title = 'Search Results | Silinex Global Services';
$page_desc  = 'Search Silinex Global Services website for services, industries, blogs and more.';
require_once __DIR__ . '/../includes/config.php';

$q      = trim($_GET['q'] ?? '');
$results = [];
$count   = 0;

if (strlen($q) >= 2) {
    $terms  = array_filter(array_map('trim', explode(' ', strtolower($q))));
    $scored = [];
    foreach ($search_index as $item) {
        $score = 0;
        foreach ($terms as $term) {
            if (str_contains(strtolower($item['title']), $term)) $score += 10;
            if (str_contains(strtolower($item['desc']),  $term)) $score += 5;
            if (str_contains(strtolower($item['tags'] ?? ''), $term)) $score += 3;
            if (similar_text($term, strtolower($item['title'])) / max(strlen($term),1) > 0.6) $score += 2;
        }
        if ($score > 0) $scored[] = array_merge($item, ['score' => $score]);
    }
    usort($scored, fn($a,$b) => $b['score'] <=> $a['score']);
    $results = $scored;
    $count   = count($results);
}

function hl(string $text, string $q): string {
    $terms = array_filter(array_map('trim', explode(' ', $q)));
    $safe  = htmlspecialchars($text);
    foreach ($terms as $term) {
        $safe = preg_replace('/('.preg_quote(htmlspecialchars($term),'/').')/i','<mark>$1</mark>',$safe);
    }
    return $safe;
}

require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>/</span><span>Search</span>
    </nav>
    <h1>
      <?php if ($q): ?>
        Results for <span>"<?= htmlspecialchars($q) ?>"</span>
      <?php else: ?>
        <span>Search</span> the Site
      <?php endif; ?>
    </h1>
  </div>
</section>

<section style="padding:60px 0 88px;background:var(--bg)">
  <div class="container">

    <!-- Search form -->
    <form class="search-page-form" action="/search" method="GET" role="search" style="max-width:640px;margin-bottom:40px">
      <input type="search" name="q"
             value="<?= htmlspecialchars($q) ?>"
             placeholder="Search services, industries, Oracle, GRC…"
             aria-label="Search" autofocus>
      <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($q): ?>

      <?php if ($count > 0): ?>
      <p class="result-count">
        Found <strong><?= $count ?></strong> result<?= $count !== 1 ? 's' : '' ?> for
        "<strong><?= htmlspecialchars($q) ?></strong>"
      </p>

      <div style="display:flex;flex-direction:column;gap:0" role="list">
        <?php foreach ($results as $r): ?>
        <a href="<?= htmlspecialchars($r['url']) ?>" class="search-result-card" role="listitem">
          <div class="src-title"><?= hl($r['title'], $q) ?></div>
          <div class="src-url">silinexglobal.com<?= htmlspecialchars($r['url']) ?></div>
          <div class="src-desc"><?= hl(substr($r['desc'],0,200), $q) ?></div>
        </a>
        <?php endforeach; ?>
      </div>

      <?php else: ?>
      <!-- No results -->
      <div class="no-results">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="1.5" width="72" height="72" style="margin:0 auto 20px">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          <line x1="8" y1="11" x2="14" y2="11"/>
        </svg>
        <h2 style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:var(--navy);margin-bottom:10px">
          No results for "<?= htmlspecialchars($q) ?>"
        </h2>
        <p style="margin-bottom:28px;font-size:.95rem">Try a different term or browse our main sections below.</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center">
          <a href="/services"  class="btn btn-primary">Our Services</a>
          <a href="/about"     class="btn btn-secondary">About Us</a>
          <a href="/contact"   class="btn btn-secondary">Contact Us</a>
        </div>
      </div>
      <?php endif; ?>

      <!-- Popular suggestions always shown -->
      <div style="margin-top:56px">
        <p style="font-weight:800;color:var(--navy);font-size:.9rem;margin-bottom:14px;text-align:center">Browse Popular Topics</p>
        <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center">
          <?php foreach(['Oracle Services','IT Staffing','GRC','Application Managed Services','PropTech','Careers','Contact'] as $tag): ?>
          <a href="/search?q=<?= urlencode($tag) ?>" class="ind-tab"><?= htmlspecialchars($tag) ?></a>
          <?php endforeach; ?>
        </div>
      </div>

    <?php else: ?>
    <!-- Empty state -->
    <div style="text-align:center;padding:60px 0">
      <div style="font-size:3.5rem;margin-bottom:18px">🔍</div>
      <p style="font-size:1.05rem;color:var(--text-muted);margin-bottom:28px">
        Enter a search term above to find services, industries, blog posts and more.
      </p>
      <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center">
        <?php foreach(['Oracle','Staffing','GRC','AMS','PropTech','Contact'] as $tag): ?>
        <a href="/search?q=<?= urlencode($tag) ?>"
           style="padding:9px 20px;border-radius:50px;border:1.5px solid var(--border);font-size:.87rem;font-weight:700;color:var(--blue);background:var(--blue-light);transition:var(--trans)"
           onmouseover="this.style.background='var(--blue)';this.style.color='#fff'"
           onmouseout="this.style.background='var(--blue-light)';this.style.color='var(--blue)'">
          <?= htmlspecialchars($tag) ?>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
