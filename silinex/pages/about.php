<?php
$page_title = 'About Us – Engineering Intelligence | Silinex Global Services';
$page_desc  = 'Silinex Global Services – next-generation IT Consulting and Staffing Solutions company with 100+ years of combined leadership in IT, Energy, Healthcare and Digital Transformation.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero" style="position:relative;overflow:hidden">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>About Us</span></nav>
    <h1>About <span>Us</span></h1>
    <p>Engineering Intelligence. Enabling Transformation.</p>
  </div>
</section>

<!-- About Intro -->
<section id="about" style="padding:88px 0;background:var(--white);position:relative;overflow:hidden">
  <img src="<?= CDN ?>/assets/images/shapes/shape_angle_1.webp" alt="" aria-hidden="true" style="position:absolute;top:0;right:0;opacity:.5;pointer-events:none;max-width:200px" loading="lazy">
  <img src="<?= CDN ?>/assets/images/shapes/shape_angle_2.webp" alt="" aria-hidden="true" style="position:absolute;bottom:0;left:0;opacity:.4;pointer-events:none;max-width:160px" loading="lazy">

  <div class="container" style="position:relative">
    <div class="about-inner">
      <div class="about-imgs">
        <img class="about-img-main"
             src="<?= CDN ?>/assets/images/about/about.jpg"
             alt="About Silinex" loading="lazy">
        <div class="about-img-badge">
          <img src="<?= CDN ?>/firm/assets/images/69493643d0632_20251222_174459.png" alt="IT Partner India" loading="lazy" style="border-radius:var(--radius-lg)">
        </div>
      </div>
      <div>
        <span class="section-tag">About Us</span>
        <h2 class="section-title">Engineering Intelligence.<br><span>Enabling Transformation.</span></h2>
        <p style="color:var(--text-muted);margin:18px 0 14px;line-height:1.78;font-size:.95rem">Silinex Global Services is a next-generation IT Consulting and Staffing Solutions company empowering global enterprises with technology-driven talent, innovation, and transformation.</p>
        <p style="color:var(--text-muted);margin-bottom:14px;line-height:1.78;font-size:.95rem">We specialize in Staffing Services, Managed IT Solutions, Oracle and Zoho Platforms, and ATML-powered digital applications — helping businesses adapt, scale, and lead in today's connected world.</p>
        <p style="color:var(--text-muted);margin-bottom:28px;line-height:1.78;font-size:.95rem">With over 100+ years of combined leadership experience, our founding team brings deep expertise across IT, Energy, Healthcare, and Digital Transformation, united by a shared vision — to simplify technology and amplify human potential.</p>
        <div class="about-counters">
          <?php foreach([['500+','Projects Delivered'],['100+','Years Combined Experience'],['50+','Technology Experts'],['98%','Client Satisfaction']] as $s): ?>
          <div class="count-box">
            <div class="count-num"><?= $s[0] ?></div>
            <div class="count-label"><?= $s[1] ?></div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section style="padding:88px 0;background:var(--bg);position:relative;overflow:hidden">
  <img src="<?= CDN ?>/assets/images/shapes/shape_space_2.svg" alt="" aria-hidden="true" style="position:absolute;right:0;bottom:0;opacity:.15;pointer-events:none;max-width:280px" loading="lazy">
  <div class="container">
    <div class="text-center">
      <span class="section-tag">Purpose & Direction</span>
      <h2 class="section-title">Mission &amp; <span>Vision</span></h2>
    </div>
    <div class="mission-vision">
      <div class="mv-card">
        <img src="<?= CDN ?>/assets/images/icons/icon_global.svg" alt="Mission" width="52" height="52"
             onerror="this.outerHTML='<div style=\'font-size:2rem;margin-bottom:16px\'>🎯</div>'">
        <h3>Our Mission</h3>
        <p>To empower businesses through intelligent technology, strategic staffing, and digital innovation — enabling them to achieve growth, resilience, and global excellence.</p>
      </div>
      <div class="mv-card">
        <img src="<?= CDN ?>/assets/images/icons/icon_mail.svg" alt="Vision" width="52" height="52"
             onerror="this.outerHTML='<div style=\'font-size:2rem;margin-bottom:16px\'>🌐</div>'">
        <h3>Our Vision</h3>
        <p>To be a trusted global partner delivering technology and talent solutions that transform enterprises and empower people worldwide.</p>
      </div>
    </div>
  </div>
</section>

<!-- Core Values -->
<section style="padding:88px 0;background:var(--white)">
  <div class="container">
    <div class="text-center">
      <span class="section-tag">What Guides Us</span>
      <h2 class="section-title">Our <span>Values</span></h2>
    </div>
    <div class="values-grid">
      <?php
      $values = [
        ['img'=>CDN.'/firm/assets/images/69490a10ecdbb_20251222_143624.svg','title'=>'Integrity',         'desc'=>'We build trust through transparency, ethics, and accountability.'],
        ['img'=>CDN.'/firm/assets/images/69490a231d49f_20251222_143643.svg','title'=>'Innovation',        'desc'=>'We embrace new technologies to drive intelligent transformation.'],
        ['img'=>CDN.'/firm/assets/images/69490a88cbbcd_20251222_143824.svg','title'=>'Collaboration',     'desc'=>'We grow through shared goals and partnerships.'],
        ['img'=>CDN.'/firm/assets/images/69490ad43ee8a_20251222_143940.svg','title'=>'Customer Success',  'desc'=>'We measure our success by the value we create for clients.'],
        ['img'=>CDN.'/firm/assets/images/69539bf8d5e30_20251230_150136.png','title'=>'Excellence',        'desc'=>'We deliver quality that inspires confidence.'],
        ['img'=>CDN.'/firm/assets/images/69539e32406f5_20251230_151106.png','title'=>'Service Excellence','desc'=>'We commit to world-class service, every time. Customer success is our highest priority.'],
      ];
      foreach ($values as $v):
      ?>
      <div class="value-card">
        <img src="<?= $v['img'] ?>" alt="<?= htmlspecialchars($v['title']) ?>" width="52" height="52" loading="lazy" style="margin:0 auto 16px;width:52px;height:52px;object-fit:contain"
             onerror="this.outerHTML='<div class=\'vc-emoji\'>⭐</div>'">
        <h3><?= htmlspecialchars($v['title']) ?></h3>
        <p><?= htmlspecialchars($v['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Why Choose Silinex -->
<section style="padding:88px 0;background:var(--bg)">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center">
      <div>
        <img src="<?= CDN ?>/firm/assets/images/693a745ccc7eb.png" alt="Why Choose Silinex Global Services"
             style="border-radius:var(--radius-xl);box-shadow:var(--shadow-lg);width:100%" loading="lazy">
      </div>
      <div>
        <span class="section-tag">Why Choose Silinex</span>
        <h2 class="section-title">Why Choose <span>Silinex</span><br>Global Services</h2>
        <ul class="about-feature-list" style="margin-top:24px">
          <?php foreach([
            'Proven expertise in IT, Staffing, and Digital Transformation',
            'Global Delivery Model with 24/7 operational support',
            'Strong partnerships with Oracle, Zoho, and cloud providers',
            'Agile, customer-first engagement models',
            'Focus on innovation in AI, ML, and Automation',
          ] as $point): ?>
          <li><?= htmlspecialchars($point) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Connect CTA -->
<section style="padding:88px 0;background:var(--blue);text-align:center;position:relative;overflow:hidden">
  <div class="container" style="position:relative;z-index:1">
    <h2 style="font-family:'Syne',sans-serif;font-size:clamp(1.6rem,3vw,2.3rem);font-weight:800;color:var(--white);margin-bottom:14px">Connect with Us for Smart Solutions</h2>
    <p style="color:rgba(255,255,255,.8);margin-bottom:28px;font-size:1.02rem">Share your goals with us, and we'll help you build smarter, more efficient solutions.</p>
    <a href="/contact#contact" class="btn btn-primary">Contact Us Today!</a>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
