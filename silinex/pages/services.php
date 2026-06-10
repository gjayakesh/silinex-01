<?php
$page_title = 'Our Services – IT Staffing, Oracle, AMS & GRC | Silinex Global';
$page_desc  = 'Explore Silinex Global\'s full suite: IT Staffing, Application Managed Services, GRC and Oracle Cloud solutions.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Services</span></nav>
    <h1>Our <span>Services</span></h1>
    <p>Comprehensive IT consulting and staffing solutions designed to help enterprises grow faster, operate smarter, and innovate continuously.</p>
  </div>
</section>

<?php
$services = [
  [
    'id'=>'staffing','alt_bg'=>false,
    'tag'=>'IT Staffing',
    'title'=>'Connect with the <span>Right Talent</span>',
    'img'=>CDN.'/firm/assets/images/693a757b9cde8_20251211_131043.png',
    'desc'=>'Silinex delivers end-to-end staffing solutions that connect top technology professionals with leading organizations across industries. From contract and permanent placements to remote and offshore models, we match the right talent to every opportunity — fast.',
    'features'=>['Contract & Permanent Placements','Remote & On-site Engagements','Pre-screened, Interview-ready Candidates','Niche Technology Specialists','Avg. 5 business-day turnaround','Vendor-neutral, Client-first Approach'],
    'cta'=>'Request Talent',
  ],
  [
    'id'=>'ams','alt_bg'=>true,
    'tag'=>'Application Managed Services',
    'title'=>'Keep Your Apps <span>Running Flawlessly</span>',
    'img'=>CDN.'/firm/assets/images/693a75f17717a_20251211_131241.png',
    'desc'=>'Our Managed Services framework enables you to focus on business outcomes while we take care of your IT environment. We monitor, maintain and continuously optimise your enterprise applications for peak performance.',
    'features'=>['24/7 Application Monitoring & Support','Incident Management & SLA Governance','Performance Tuning & Optimisation','Patch & Release Management','Change & Problem Management','Dedicated Service Delivery Manager'],
    'cta'=>'Get AMS Quote',
  ],
  [
    'id'=>'grc','alt_bg'=>false,
    'tag'=>'GRC Services',
    'title'=>'Govern. Manage Risk. <span>Stay Compliant.</span>',
    'img'=>CDN.'/firm/assets/images/693a7658a4e31_20251211_131424.png',
    'desc'=>'Silinex Global Services offers comprehensive GRC (Governance, Risk & Compliance) solutions that help enterprises build trust, transparency, and operational resilience. Our specialists bring deep regulatory knowledge and proven frameworks.',
    'features'=>['Risk Assessment & Mitigation Frameworks','Regulatory Compliance (SOX, GDPR, ISO 27001)','Internal Audit Support','Policy Design & Implementation','Business Continuity Planning','GRC Technology Implementation'],
    'cta'=>'Talk to GRC Expert',
  ],
  [
    'id'=>'oracle','alt_bg'=>true,
    'tag'=>'Oracle Services',
    'title'=>'Oracle Cloud <span>Expertise You Can Trust</span>',
    'img'=>CDN.'/firm/assets/images/694cd81582088_20251225_115213.jpeg',
    'desc'=>'Our certified Oracle consultants deliver full-cycle implementation, migration and managed services across the complete Oracle Cloud portfolio — helping you maximise your Oracle investment and accelerate transformation.',
    'features'=>['Oracle Fusion ERP','Oracle HCM Cloud','Oracle SCM Cloud','Oracle CX Cloud','Oracle PPM Cloud','Oracle Integration Cloud (OIC)'],
    'cta'=>'Start Oracle Project',
  ],
];
foreach ($services as $s):
$bg = $s['alt_bg'] ? 'var(--bg)' : 'var(--white)';
?>
<section id="<?= $s['id'] ?>" style="padding:88px 0;background:<?= $bg ?>;position:relative;overflow:hidden">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center<?= $s['alt_bg'] ? '' : '' ?>">
      <?php if ($s['alt_bg']): ?>
      <img src="<?= $s['img'] ?>" alt="<?= htmlspecialchars($s['tag']) ?>" loading="lazy"
           style="border-radius:var(--radius-xl);box-shadow:var(--shadow-lg);width:100%;max-height:420px;object-fit:cover">
      <?php endif; ?>
      <div>
        <span class="section-tag"><?= htmlspecialchars($s['tag']) ?></span>
        <h2 class="section-title"><?= $s['title'] ?></h2>
        <p style="color:var(--text-muted);margin:18px 0 22px;line-height:1.78;font-size:.95rem"><?= htmlspecialchars($s['desc']) ?></p>
        <ul class="about-feature-list">
          <?php foreach ($s['features'] as $f): ?>
          <li><?= htmlspecialchars($f) ?></li>
          <?php endforeach; ?>
        </ul>
        <a href="/contact#contact" class="btn btn-primary" style="margin-top:28px"><?= htmlspecialchars($s['cta']) ?></a>
      </div>
      <?php if (!$s['alt_bg']): ?>
      <img src="<?= $s['img'] ?>" alt="<?= htmlspecialchars($s['tag']) ?>" loading="lazy"
           style="border-radius:var(--radius-xl);box-shadow:var(--shadow-lg);width:100%;max-height:420px;object-fit:cover">
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<!-- CTA -->
<section class="cta-banner">
  <div class="container">
    <h2>Not Sure Which Service Fits Your Needs?</h2>
    <p>Our consultants will assess your requirements and recommend the right engagement model — at no obligation.</p>
    <div class="btn-wrap">
      <a href="/contact#contact" class="btn btn-secondary">Book a Free Consultation</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
