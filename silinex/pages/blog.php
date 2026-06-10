<?php
$page_title = 'Blog – IT Insights & Enterprise Technology | Silinex Global';
$page_desc  = 'Expert insights on Oracle, IT staffing, GRC, AI and digital transformation from the Silinex Global team.';
require_once __DIR__ . '/../includes/config.php';

$blogs = [
  ['cat'=>'AI & Enterprise','date'=>'13/05/2026','slug'=>'ai-human-collaboration-enterprise',   'img'=>CDN.'/firm/assets/images/6a08abcd066fc_20260516_230925.png','title'=>'Future of Work: How Human + AI Collaboration is Reshaping the Enterprise','desc'=>'Discover how the fusion of human creativity and AI capability is driving the next wave of enterprise productivity and competitive advantage.'],
  ['cat'=>'Leadership',     'date'=>'04/05/2026','slug'=>'leadership-skills-ai-era',            'img'=>CDN.'/firm/assets/images/69fb719d13559_20260506_222141.png','title'=>'Leadership Skills Needed in the AI Era',                                    'desc'=>'The rise of AI demands a new kind of leader — one who blends strategic vision with technological fluency to guide organisations forward.'],
  ['cat'=>'Technology',     'date'=>'23/04/2026','slug'=>'ai-implementation-challenges',        'img'=>CDN.'/firm/assets/images/6a105bcb22ac9_20260522_190611.png','title'=>'AI Implementation Challenges and Solutions Introduction',                   'desc'=>'From data readiness to change management, we explore the most common hurdles enterprises face when deploying AI — and how to overcome them.'],
  ['cat'=>'Oracle',         'date'=>'Apr 22, 2025','slug'=>'oracle-hcm-vs-sap-successfactors', 'img'=>CDN.'/firm/assets/images/694cd81582088_20251225_115213.jpeg',                         'title'=>'Oracle Fusion HCM vs SAP SuccessFactors: A 2025 Comparison',              'desc'=>'Our Oracle-certified consultants break down the key differences in functionality, implementation effort and total cost of ownership.'],
  ['cat'=>'GRC',            'date'=>'Apr 05, 2025','slug'=>'future-proof-grc-framework',       'img'=>CDN.'/firm/assets/images/693a7658a4e31_20251211_131424.png',                         'title'=>'Building a Future-Proof GRC Framework for Mid-Enterprise Companies',      'desc'=>'Governance, Risk and Compliance doesn\'t have to be overwhelming. This guide walks through the core pillars of an effective GRC programme.'],
  ['cat'=>'PropTech',       'date'=>'Feb 14, 2025','slug'=>'proptech-trends-2025',             'img'=>CDN.'/firm/assets/images/6953a0fa98d6d_20251230_152258.png',                         'title'=>'PropTech Trends Redefining Real Estate Operations in 2025',               'desc'=>'From AI-driven lease analytics to IoT building management, the property technology landscape is evolving rapidly.'],
];
$all_cats = array_unique(array_column($blogs,'cat'));
$blog_slug = trim(str_replace('/blog', '', parse_url($_SERVER['REQUEST_URI'] ?? '/blog', PHP_URL_PATH)), '/');
$active_blog = null;

if ($blog_slug !== '') {
  foreach ($blogs as $blog) {
    if ($blog['slug'] === $blog_slug) {
      $active_blog = $blog;
      break;
    }
  }

  if ($active_blog) {
    $page_title = $active_blog['title'] . ' | Silinex Global';
    $page_desc = $active_blog['desc'];
  } else {
    http_response_code(404);
    $page_title = 'Blog Not Found | Silinex Global';
    $page_desc = 'The requested Silinex Global blog article could not be found.';
  }
}

require_once __DIR__ . '/../includes/header.php';
?>

<?php if ($blog_slug !== ''): ?>
  <?php if ($active_blog): ?>
    <section class="inner-hero">
      <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><a href="/blog">Blog</a><span>/</span><span><?= htmlspecialchars($active_blog['cat']) ?></span></nav>
        <h1><?= htmlspecialchars($active_blog['title']) ?></h1>
        <p><?= htmlspecialchars($active_blog['desc']) ?></p>
      </div>
    </section>

    <section style="padding:88px 0;background:var(--bg)">
      <div class="container" style="max-width:920px">
        <article class="blog-card" style="overflow:hidden">
          <div class="blog-card-img" style="height:auto;aspect-ratio:16/9">
            <img src="<?= $active_blog['img'] ?>" alt="<?= htmlspecialchars($active_blog['title']) ?>" loading="eager"
                 onerror="this.parentElement.style.background='var(--blue-light)';this.style.display='none'">
          </div>
          <div class="blog-card-body" style="padding:32px">
            <div class="blog-meta">
              <span class="blog-cat"><?= htmlspecialchars($active_blog['cat']) ?></span>
              <span>Â·</span>
              <span>By <strong style="color:var(--navy)">Admin</strong></span>
              <span>Â·</span>
              <span><?= htmlspecialchars($active_blog['date']) ?></span>
            </div>
            <p style="color:var(--text-muted);font-size:1rem;line-height:1.85;margin:0 0 18px">
              <?= htmlspecialchars($active_blog['desc']) ?>
            </p>
            <p style="color:var(--text);font-size:1rem;line-height:1.85;margin:0 0 28px">
              Silinex Global helps enterprises turn this kind of technology insight into practical execution through consulting, staffing, managed services and governance support.
            </p>
            <a href="/blog" class="btn btn-secondary">Back to Blog</a>
          </div>
        </article>
      </div>
    </section>
  <?php else: ?>
    <section style="min-height:70vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:120px 24px 80px">
      <div>
        <div style="font-family:var(--font-head);font-size:6rem;font-weight:900;color:var(--blue);line-height:1;margin-bottom:8px">404</div>
        <h1 style="font-family:var(--font-head);font-size:2rem;font-weight:800;margin-bottom:12px">Blog Not Found</h1>
        <p style="color:var(--text-muted);max-width:480px;margin:0 auto 32px;line-height:1.7">The article you are looking for is unavailable or has been moved.</p>
        <a href="/blog" class="btn btn-primary">Back to Blog</a>
      </div>
    </section>
  <?php endif; ?>
  <?php require_once __DIR__ . '/../includes/footer.php'; return; ?>
<?php endif; ?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Blog</span></nav>
    <h1>Latest <span>Blogs</span></h1>
    <p>Expert thinking on enterprise technology, staffing trends, Oracle, GRC and digital transformation.</p>
  </div>
</section>

<section id="blog" style="padding:88px 0;background:var(--bg);position:relative;overflow:hidden">
  <img src="<?= CDN ?>/assets/images/shapes/shape_line_7.svg" alt="" aria-hidden="true" style="position:absolute;top:0;right:0;opacity:.3;pointer-events:none" loading="lazy">

  <div class="container">
    <!-- Filter tabs -->
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:44px" role="group" aria-label="Filter by category">
      <button class="ind-tab active" onclick="filterBlogs('all',this)">All</button>
      <?php foreach ($all_cats as $cat): ?>
      <button class="ind-tab" onclick="filterBlogs('<?= htmlspecialchars($cat) ?>',this)"><?= htmlspecialchars($cat) ?></button>
      <?php endforeach; ?>
    </div>

    <div class="blogs-grid" id="blogsGrid">
      <?php foreach ($blogs as $b): ?>
      <article class="blog-card" data-cat="<?= htmlspecialchars($b['cat']) ?>">
        <div class="blog-card-img">
          <img src="<?= $b['img'] ?>" alt="<?= htmlspecialchars($b['title']) ?>" loading="lazy"
               onerror="this.parentElement.style.background='var(--blue-light)';this.style.display='none'">
        </div>
        <div class="blog-card-body">
          <div class="blog-meta">
            <span class="blog-cat"><?= htmlspecialchars($b['cat']) ?></span>
            <span>·</span>
            <span style="display:flex;align-items:center;gap:5px">
              <img src="<?= CDN ?>/assets/images/icons/icon_calendar.svg" alt="" width="13" height="13" loading="lazy" onerror="this.style.display='none'">
              By <strong style="color:var(--navy)">Admin</strong>
            </span>
            <span>·</span>
            <span><?= htmlspecialchars($b['date']) ?></span>
          </div>
          <h2 class="blog-card-title"><a href="/blog/<?= htmlspecialchars($b['slug']) ?>"><?= htmlspecialchars($b['title']) ?></a></h2>
          <p style="color:var(--text-muted);font-size:.87rem;line-height:1.65;margin-bottom:18px"><?= htmlspecialchars($b['desc']) ?></p>
          <a href="/blog/<?= htmlspecialchars($b['slug']) ?>" class="sc-link">
            Read More
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Newsletter -->
<section style="padding:80px 0;background:var(--white)">
  <div class="container" style="max-width:620px;text-align:center">
    <span class="section-tag">Stay Updated</span>
    <h2 class="section-title" style="margin-bottom:14px">Subscribe to Our <span>Newsletter</span></h2>
    <p style="color:var(--text-muted);margin-bottom:28px">Get the latest insights on Oracle, staffing trends and enterprise technology — delivered monthly.</p>
    <form id="newsletterForm" style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center" novalidate>
      <input type="text" name="url" style="display:none" tabindex="-1" autocomplete="off">
      <input type="email" name="email" placeholder="Your email address" required
             style="flex:1;min-width:220px;height:50px;border:1.5px solid var(--border);border-radius:50px;padding:0 22px;font-size:.9rem;outline:none;transition:var(--trans)"
             onfocus="this.style.borderColor='var(--blue)';this.style.boxShadow='0 0 0 4px rgba(39,99,255,.1)'"
             onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
      <button type="submit" class="btn btn-primary" id="newsletterBtn">Subscribe</button>
    </form>
    <div id="newsletterMsg" style="margin-top:14px;font-size:.9rem;min-height:22px;font-weight:700" aria-live="polite"></div>
  </div>
</section>

<script>
function filterBlogs(cat, btn) {
  document.querySelectorAll('[onclick^="filterBlogs"]').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#blogsGrid .blog-card').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
  });
}
document.getElementById('newsletterForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const btn = document.getElementById('newsletterBtn');
  const msg = document.getElementById('newsletterMsg');
  btn.disabled = true; btn.textContent = 'Subscribing…';
  try {
    const res  = await fetch('/api/newsletter.php',{method:'POST',body:new FormData(this)});
    const data = await res.json();
    msg.style.color = data.ok ? 'var(--blue)' : '#dc2626';
    msg.textContent = (data.ok ? '✓ ' : '✗ ') + data.message;
    if (data.ok) this.reset();
  } catch(_) { msg.style.color='#dc2626'; msg.textContent='✗ Something went wrong. Try again.'; }
  btn.disabled = false; btn.textContent = 'Subscribe';
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
