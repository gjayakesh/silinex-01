<?php
$page_title = 'Our Industries – PropTech, Retail, Healthcare & More | Silinex Global';
$page_desc = 'Silinex Global delivers smart digital platforms across PropTech, Retail, Healthcare, Energy, Enterprise Technology and EdTech industries.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';

$industries = [
  [
    'id' => 'proptech',
    'icon' => 'proptech',
    'bg' => '#E8F0FB',
    'color' => '#0057B8',
    'name' => 'PropTech (Real Estate)',
    'short' => 'Smart solutions for modern real estate operations.',
    'detail' => 'From lease lifecycle management and tenant portals to IoT-driven building intelligence and real-time asset performance dashboards — we modernise every facet of property operations.',
  ],
  [
    'id' => 'retail',
    'icon' => 'retail',
    'bg' => '#E2F7F6',
    'color' => '#0e7370',
    'name' => 'Retail',
    'short' => 'Enhancing customer experience and operational efficiency.',
    'detail' => 'Omni-channel commerce platforms, inventory optimisation, and AI-driven personalisation tools that help retail brands grow faster and operate leaner in a competitive market.',
  ],
  [
    'id' => 'healthcare',
    'icon' => 'healthcare',
    'bg' => '#F3F0FD',
    'color' => '#5B21B6',
    'name' => 'Healthcare / Pharma',
    'short' => 'Advanced technology for better patient outcomes.',
    'detail' => 'Secure, scalable digital systems for clinical operations, regulatory compliance, and data-driven decision making — improving outcomes for patients and practitioners alike.',
  ],
  [
    'id' => 'energy',
    'icon' => 'energy',
    'bg' => '#FEF0E4',
    'color' => '#c15c0f',
    'name' => 'Energy',
    'short' => 'Intelligent systems for a sustainable future.',
    'detail' => 'Digital infrastructure, automation and advanced analytics for oil & gas, renewables and utility companies — enabling operational excellence in a rapidly changing energy sector.',
  ],
  [
    'id' => 'enterprise',
    'icon' => 'enterprise',
    'bg' => '#E8F0FB',
    'color' => '#003F87',
    'name' => 'Enterprise & Technology',
    'short' => 'Driving innovation and digital transformation.',
    'detail' => 'ERP modernisation, cloud migration, Oracle implementation, and integration services that unify your enterprise technology landscape and drive measurable, sustained ROI.',
  ],
  [
    'id' => 'edtech',
    'icon' => 'edtech',
    'bg' => '#F0FDF4',
    'color' => '#166534',
    'name' => 'EdTech',
    'short' => 'Empowering learning with technology.',
    'detail' => 'Adaptive learning platforms, student engagement tools, LMS integrations and analytics dashboards that make education smarter, more accessible and more effective.',
  ],
];

/* SVG icon paths keyed by id */
$svgs = [
  'proptech' => '<path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 9h1m4 0h1M9 13h1m4 0h1"/>',
  'retail' => '<circle cx="9" cy="19" r="1"/><circle cx="20" cy="19" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>',
  'healthcare' => '<path d="M19.5 12.572l-7.5 7.428-7.5-7.428A5 5 0 1112 6.006a5 5 0 117.5 6.566zM15 9h6m-3-3v6"/>',
  'energy' => '<path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>',
  'enterprise' => '<rect x="2" y="2" width="20" height="20" rx="2"/><path d="M7 7h.01M17 7h.01M7 17h.01M17 17h.01M7 12h10M12 7v10"/>',
  'edtech' => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
];
?>

<style>
  /* ── Industries page overrides ─────────────────────── */
  .ind-page {
    padding-top: var(--header-h, 80px);
    background: #fff;
  }

  .ind-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: calc(100vh - var(--header-h, 80px) - 120px);
  }

  /* LEFT */
  .ind-left {
    padding: 52px 52px 52px 48px;
    display: flex;
    flex-direction: column;
  }

  .ind-rule {
    width: 48px;
    height: 4px;
    background: var(--blue);
    border-radius: 2px;
    margin-bottom: 22px;
  }

  .ind-intro {
    color: var(--text-muted);
    font-size: .91rem;
    line-height: 1.72;
    max-width: 420px;
    margin-bottom: 36px;
  }

  /* Accordion */
  .acc-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .acc-row {
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    cursor: pointer;
    transition: border-color var(--trans), box-shadow var(--trans);
  }

  .acc-row:hover {
    border-color: #b5c7ea;
  }

  .acc-row.active {
    border-color: var(--blue);
    box-shadow: 0 2px 16px rgba(39, 99, 255, .11);
  }

  .acc-trigger {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: #fff;
    transition: background var(--trans);
  }

  .acc-row.active .acc-trigger {
    background: var(--blue-mid);
  }

  .acc-ico {
    width: 42px;
    height: 42px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .acc-text {
    flex: 1;
    min-width: 0;
  }

  .acc-name {
    font-weight: 800;
    font-size: .92rem;
    color: var(--navy);
    transition: color var(--trans);
  }

  .acc-row.active .acc-name {
    color: var(--blue);
  }

  .acc-hint {
    font-size: .76rem;
    color: #9aaabf;
    margin-top: 2px;
  }

  .acc-arrow {
    flex-shrink: 0;
    color: #bdc9dc;
    transition: transform var(--trans), color var(--trans);
  }

  .acc-row.active .acc-arrow {
    transform: rotate(180deg);
    color: var(--blue);
  }

  .acc-panel {
    max-height: 0;
    overflow: hidden;
    transition: max-height .38s ease;
  }

  .acc-panel-inner {
    padding: 0 16px 15px 70px;
    font-size: .88rem;
    color: var(--text-muted);
    line-height: 1.68;
    border-top: 1px solid var(--border);
    padding-top: 12px;
  }

  .acc-row.active .acc-panel {
    max-height: 160px;
  }

  /* RIGHT */
  .ind-right {
    background: var(--bg);
    border-left: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 48px 40px;
    gap: 28px;
  }

  .ind-right-head h2 {
    font-family: 'Syne', sans-serif;
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--navy);
    line-height: 1.55;
    text-align: center;
  }

  .ind-right-head h2 span {
    color: var(--blue);
  }

  .ind-right-head p {
    font-size: .83rem;
    color: var(--text-muted);
    margin-top: 6px;
    text-align: center;
  }

  /* Card stack — equal-height, no overlap */
  .ind-card-stack {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .ind-card {
    display: flex;
    align-items: center;
    gap: 16px;
    height: 64px;
    padding: 0 20px;
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    background: #fff;
    cursor: pointer;
    transition: border-color var(--trans), background var(--trans), box-shadow var(--trans);
  }

  .ind-card:hover:not(.active) {
    border-color: #b5c7ea;
    box-shadow: 0 2px 12px rgba(39, 99, 255, .07);
  }

  .ind-card.active {
    background: var(--blue);
    border-color: var(--blue);
    box-shadow: 0 4px 20px rgba(39, 99, 255, .28);
  }

  .card-ico {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background var(--trans), color var(--trans);
  }

  .ind-card.active .card-ico {
    background: rgba(255, 255, 255, .15);
    color: #fff;
  }

  .card-name {
    font-weight: 800;
    font-size: .92rem;
    color: var(--navy);
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color var(--trans);
  }

  .ind-card.active .card-name {
    color: #fff;
  }

  .card-arrow {
    color: #bdc9dc;
    flex-shrink: 0;
    transition: color var(--trans), transform var(--trans);
  }

  .ind-card.active .card-arrow {
    color: rgba(255, 255, 255, .6);
    transform: translateX(3px);
  }

  /* Features strip */
  .feat-strip {
    background: var(--navy);
    padding: 32px 0;
  }

  .feat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
  }

  .feat-cell {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 6px 28px;
    border-right: 1px solid rgba(255, 255, 255, .09);
  }

  .feat-cell:last-child {
    border-right: none;
  }

  .feat-ico-w {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.3rem;
  }

  .feat-t {
    font-weight: 800;
    font-size: .9rem;
    color: #fff;
    margin-bottom: 3px;
  }

  .feat-d {
    font-size: .78rem;
    color: rgba(255, 255, 255, .58);
    line-height: 1.5;
  }

  /* Responsive */
  @media(max-width:1024px) {
    .ind-layout {
      grid-template-columns: 1fr;
    }

    .ind-right {
      border-left: none;
      border-top: 1px solid var(--border);
      padding: 40px 24px;
    }

    .feat-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .feat-cell {
      border-right: none;
      border-bottom: 1px solid rgba(255, 255, 255, .09);
      padding: 14px 20px;
    }

    .feat-cell:nth-child(odd) {
      border-right: 1px solid rgba(255, 255, 255, .09);
    }
  }

  @media(max-width:640px) {
    .ind-left {
      padding: 32px 20px;
    }

    .feat-grid {
      grid-template-columns: 1fr;
    }

    .feat-cell:nth-child(odd) {
      border-right: none;
    }
  }
</style>

<main class="ind-page">

  <!-- Breadcrumb strip -->
  <div style="background:var(--bg);border-bottom:1px solid var(--border);padding:14px 0">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="/">Home</a><span>/</span><span>Industries</span>
      </nav>
    </div>
  </div>

  <div class="ind-layout">

    <!-- ══ LEFT ══ -->
    <div class="ind-left">
      <span class="section-tag" style="margin-bottom:14px">What We Serve</span>
      <h1 class="section-title" style="margin-bottom:10px">Our <span>Industries</span></h1>
      <div class="ind-rule"></div>
      <p style="font-weight:800;font-size:.97rem;color:var(--navy);margin-bottom:8px">Powering Growth. Enabling
        Excellence.</p>
      <p class="ind-intro">We deliver smart digital platforms that streamline property management, boost engagement, and
        real-time asset performance across diverse industries.</p>

      <div class="acc-list" id="accList" role="list">
        <?php foreach ($industries as $i => $ind): ?>
          <div class="acc-row<?= $i === 0 ? ' active' : '' ?>" data-id="<?= $ind['id'] ?>" role="listitem"
            onclick="switchIndustry('<?= $ind['id'] ?>')" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
            <div class="acc-trigger">
              <div class="acc-ico" style="background:<?= $ind['bg'] ?>;color:<?= $ind['color'] ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="22" height="22"
                  aria-hidden="true">
                  <?= $svgs[$ind['icon']] ?? '' ?>
                </svg>
              </div>
              <div class="acc-text">
                <div class="acc-name">
                  <?= htmlspecialchars($ind['name']) ?>
                </div>
                <div class="acc-hint">
                  <?= htmlspecialchars($ind['short']) ?>
                </div>
              </div>
              <svg class="acc-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="17"
                height="17" aria-hidden="true">
                <path d="M6 9l6 6 6-6" />
              </svg>
            </div>
            <div class="acc-panel" id="panel-<?= $ind['id'] ?>">
              <div class="acc-panel-inner">
                <?= htmlspecialchars($ind['detail']) ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ══ RIGHT ══ -->
    <div class="ind-right">
      <div class="ind-right-head">
        <h2>One Platform. Multiple Industries.<br><span>Infinite Possibilities.</span></h2>
        <p>Select an industry to explore our solutions</p>
      </div>

      <div class="ind-card-stack" id="cardStack" role="list" aria-label="Industry platforms">
        <?php foreach ($industries as $i => $ind): ?>
          <div class="ind-card<?= $i === 0 ? ' active' : '' ?>" data-id="<?= $ind['id'] ?>" data-bg="<?= $ind['bg'] ?>"
            data-col="<?= $ind['color'] ?>" role="listitem" tabindex="0" onclick="switchIndustry('<?= $ind['id'] ?>')"
            onkeydown="if(event.key==='Enter'||event.key===' '){switchIndustry('<?= $ind['id'] ?>');event.preventDefault()}"
            aria-label="<?= htmlspecialchars($ind['name']) ?>">
            <div class="card-ico"
              style="background:<?= $i === 0 ? 'rgba(255,255,255,.15)' : $ind['bg'] ?>;color:<?= $i === 0 ? '#fff' : $ind['color'] ?>">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="20" height="20"
                aria-hidden="true">
                <?= $svgs[$ind['icon']] ?? '' ?>
              </svg>
            </div>
            <span class="card-name">
              <?= htmlspecialchars($ind['name']) ?>
            </span>
            <svg class="card-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="15"
              height="15" aria-hidden="true">
              <path d="M9 18l6-6-6-6" />
            </svg>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div><!-- /ind-layout -->

  <!-- ══ FEATURES STRIP ══ -->
  <div class="feat-strip">
    <div class="container">
      <div class="feat-grid">
        <?php
        $feats = [
          ['ico' => '📊', 't' => 'Industry Expertise', 'd' => 'Deep understanding across multiple sectors'],
          ['ico' => '🛡️', 't' => 'Secure & Compliant', 'd' => 'Enterprise-grade security and compliance'],
          ['ico' => '☁️', 't' => 'Scalable Platform', 'd' => 'Built to scale with your business growth'],
          ['ico' => '🎧', 't' => 'Reliable Support', 'd' => '24/7 support from our expert team'],
        ];
        foreach ($feats as $f):
          ?>
          <div class="feat-cell">
            <div class="feat-ico-w" aria-hidden="true">
              <?= $f['ico'] ?>
            </div>
            <div>
              <div class="feat-t">
                <?= htmlspecialchars($f['t']) ?>
              </div>
              <div class="feat-d">
                <?= htmlspecialchars($f['d']) ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

</main>

<script>
  (function () {
    function switchIndustry(id) {
      /* Accordion */
      document.querySelectorAll('.acc-row').forEach(function (row) {
        var on = row.dataset.id === id;
        row.classList.toggle('active', on);
        row.setAttribute('aria-expanded', on ? 'true' : 'false');
      });
      /* Cards */
      document.querySelectorAll('.ind-card').forEach(function (card) {
        var on = card.dataset.id === id;
        card.classList.toggle('active', on);
        var ico = card.querySelector('.card-ico');
        if (on) {
          ico.style.background = 'rgba(255,255,255,.15)';
          ico.style.color = '#fff';
        } else {
          ico.style.background = card.dataset.bg;
          ico.style.color = card.dataset.col;
        }
      });
    }
    window.switchIndustry = switchIndustry;
  })();
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>