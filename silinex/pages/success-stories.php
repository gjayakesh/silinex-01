<?php
$page_title = 'Customer Success & Partners | Silinex Global Services';
$page_desc  = 'Discover how Silinex Global delivers measurable results for clients across industries and meet our technology alliance partners.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Customer Success</span></nav>
    <h1>Customer <span>Success Stories</span></h1>
    <p>Real results. Measurable impact. Long-term partnerships built on trust and outcomes.</p>
  </div>
</section>

<!-- Stats strip -->
<section style="padding:56px 0;background:var(--blue)">
  <div class="container">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:24px;text-align:center;color:#fff">
      <?php foreach([['500+','Projects Delivered'],['200+','Happy Clients'],['15+','Countries Served'],['98%','Satisfaction Rate']] as $s): ?>
      <div>
        <div style="font-family:'Syne',sans-serif;font-size:2.6rem;font-weight:800;line-height:1"><?= $s[0] ?></div>
        <div style="font-size:.87rem;opacity:.8;margin-top:6px;font-weight:700"><?= $s[1] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Case studies -->
<section style="padding:88px 0;background:var(--bg)">
  <div class="container">
    <div class="text-center">
      <span class="section-tag">Case Studies</span>
      <h2 class="section-title">Stories of <span>Impact</span></h2>
      <p class="section-sub">A selection of client engagements that illustrate the depth and breadth of our capabilities.</p>
    </div>
    <div style="display:flex;flex-direction:column;gap:28px;margin-top:52px">
      <?php
      $cases = [
        ['ind'=>'Healthcare & Pharma','icon'=>'🏥','color'=>'#059669','bg'=>'#ecfdf5',
         'title'=>'Oracle HCM Cloud for a Leading Pharma Group',
         'ch'=>'A 5,000-employee pharma organisation was managing HR on disparate legacy systems, causing payroll errors and compliance gaps.',
         'sol'=>'Silinex delivered full Oracle Fusion HCM covering Core HR, Payroll, Absence and Talent Management — completed in 6 months with zero critical go-live issues.',
         'out'=>['40% reduction in HR administration time','Payroll accuracy improved to 99.8%','Full regulatory compliance achieved','Employee self-service adoption at 87%']],
        ['ind'=>'Energy & Utilities','icon'=>'⚡','color'=>'#d97706','bg'=>'#fffbeb',
         'title'=>'GRC Framework for a Mid-Sized Energy Company',
         'ch'=>'Rapid expansion left the client with fragmented risk processes, inconsistent audit trails and growing regulatory scrutiny across three operating regions.',
         'sol'=>'We designed and implemented a comprehensive GRC framework with risk assessment, control documentation, policy management and automated compliance reporting.',
         'out'=>['Audit preparation time cut by 60%','Unified risk register across all units','Regulatory findings reduced by 75%','Board-ready compliance dashboards']],
        ['ind'=>'Banking & Finance','icon'=>'🏦','color'=>'#2763ff','bg'=>'#eff6ff',
         'title'=>'IT Staffing Programme for a Digital-First FinTech',
         'ch'=>'A fast-scaling fintech needed 30 specialised technology professionals across Oracle, cloud and data engineering — in under 45 days.',
         'sol'=>'Our staffing team delivered 28 of 30 roles within 38 days with full technical screening, background verification and onboarding support.',
         'out'=>['28/30 roles filled within 38 days','Zero mis-hires in 6 months','Avg. 3-day time-to-interview','35% cost saving vs previous vendor']],
      ];
      foreach ($cases as $c):
      ?>
      <div style="background:var(--white);border:1.5px solid var(--border);border-radius:var(--radius-lg);overflow:hidden">
        <div style="padding:8px 22px;background:<?= $c['bg'] ?>;display:flex;align-items:center;gap:10px">
          <span><?= $c['icon'] ?></span>
          <span style="font-weight:800;font-size:.81rem;color:<?= $c['color'] ?>"><?= htmlspecialchars($c['ind']) ?></span>
        </div>
        <div style="padding:28px 32px">
          <h3 style="font-family:'Syne',sans-serif;font-size:1.12rem;font-weight:800;color:var(--navy);margin-bottom:20px"><?= htmlspecialchars($c['title']) ?></h3>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:28px">
            <div>
              <p style="font-weight:800;font-size:.78rem;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted);margin-bottom:8px">The Challenge</p>
              <p style="color:var(--text-muted);font-size:.9rem;line-height:1.68"><?= htmlspecialchars($c['ch']) ?></p>
              <p style="font-weight:800;font-size:.78rem;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted);margin:16px 0 8px">Our Solution</p>
              <p style="color:var(--text-muted);font-size:.9rem;line-height:1.68"><?= htmlspecialchars($c['sol']) ?></p>
            </div>
            <div>
              <p style="font-weight:800;font-size:.78rem;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted);margin-bottom:12px">Key Outcomes</p>
              <ul style="display:flex;flex-direction:column;gap:10px">
                <?php foreach ($c['out'] as $o): ?>
                <li style="display:flex;gap:10px;font-size:.9rem;color:var(--text-muted);align-items:flex-start">
                  <span style="color:<?= $c['color'] ?>;font-weight:900;flex-shrink:0">✓</span><?= htmlspecialchars($o) ?>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="testimonials-section" style="padding:88px 0;position:relative;overflow:hidden">
  <img src="<?= CDN ?>/assets/images/shapes/shape_line_2.svg" alt="" aria-hidden="true" style="position:absolute;top:0;left:0;opacity:.25;pointer-events:none" loading="lazy">
  <img src="<?= CDN ?>/assets/images/shapes/shape_space_3.svg" alt="" aria-hidden="true" style="position:absolute;right:0;top:50%;transform:translateY(-50%);opacity:.1;pointer-events:none;max-width:200px" loading="lazy">
  <div class="container" style="position:relative">
    <div class="text-center" style="margin-bottom:48px">
      <span class="section-tag" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9)">Client Voices</span>
      <h2 class="section-title" style="color:var(--white)">What Our <span style="color:var(--orange)">Clients Say</span></h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px">
      <?php
      $quotes = [
        ['q'=>'Silinex Global Services delivered exceptional results for our digital transformation journey. Their technical expertise and commitment to quality helped us scale faster with confidence.','name'=>'Compliance Manager','role'=>'Financial Services Firm','img'=>CDN.'/firm/assets/images/606.jpg'],
        ['q'=>'The Silinex team provided us with highly skilled professionals who perfectly matched our project requirements. Their staffing solutions were fast, reliable, and effective.','name'=>'HR Director','role'=>'Global Services Company','img'=>CDN.'/firm/assets/images/633.jpg'],
        ['q'=>'We partnered with Silinex for managed services and they exceeded our expectations. Their proactive support and deep technical knowledge significantly improved our system performance.','name'=>'Operations Head','role'=>'Retail Organization','img'=>CDN.'/firm/assets/images/625.jpg'],
      ];
      foreach ($quotes as $q):
      ?>
      <div class="testi-card" style="flex:none">
        <svg width="28" height="20" viewBox="0 0 28 20" fill="none" aria-hidden="true" style="margin-bottom:14px;opacity:.3">
          <path d="M0 20V12.5C0 5.596 3.795 1.458 11.384 0L12.5 2.115C9.263 2.948 7.276 4.923 6.538 8H11.5V20H0ZM16.5 20V12.5C16.5 5.596 20.295 1.458 27.884 0L29 2.115C25.763 2.948 23.776 4.923 23.038 8H28V20H16.5Z" fill="white"/>
        </svg>
        <p class="testi-quote"><?= htmlspecialchars($q['q']) ?></p>
        <div class="testi-author">
          <img src="<?= $q['img'] ?>" alt="<?= htmlspecialchars($q['name']) ?>" width="50" height="50" loading="lazy"
               onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($q['name']) ?>&background=2763ff&color=fff&size=50'">
          <div>
            <div class="testi-author-name"><?= htmlspecialchars($q['name']) ?></div>
            <div class="testi-author-role"><?= htmlspecialchars($q['role']) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Partners -->
<section id="partner" style="padding:88px 0;background:var(--white)">
  <div class="container">
    <div class="text-center">
      <span class="section-tag">Alliance Ecosystem</span>
      <h2 class="section-title">Partners &amp; <span>Alliances</span></h2>
      <p class="section-sub">We work alongside the world's leading technology platforms to deliver integrated, best-in-class solutions.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:18px;margin-top:52px">
      <?php
      $partners = [
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/561.jpg'],
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/896.jpg'],
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/747.jpg'],
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/315.jpg'],
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/227.jpg'],
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/69538b2a833ce.jpeg'],
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/406.jpeg'],
        ['name'=>'Partner','img'=>CDN.'/firm/assets/images/436.png'],
      ];
      foreach ($partners as $p):
      ?>
      <div style="display:flex;align-items:center;justify-content:center;background:var(--bg);border:1.5px solid var(--border);border-radius:var(--radius-lg);padding:20px;height:96px;transition:var(--trans)"
           onmouseover="this.style.borderColor='var(--blue)';this.style.boxShadow='var(--shadow)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
        <img src="<?= $p['img'] ?>" alt="<?= htmlspecialchars($p['name']) ?>" height="40" loading="lazy"
             style="max-width:140px;height:40px;object-fit:contain;filter:grayscale(50%);transition:var(--trans)"
             onmouseover="this.style.filter='none'" onmouseout="this.style.filter='grayscale(50%)'">
      </div>
      <?php endforeach; ?>
    </div>
    <div style="text-align:center;margin-top:44px">
      <a href="/contact#contact" class="btn btn-primary">Explore Partnership</a>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="container">
    <h2>Ready to Write Your Success Story?</h2>
    <p>Let's talk about your challenges and how we can help you achieve measurable results.</p>
    <div class="btn-wrap"><a href="/contact#contact" class="btn btn-primary">Start a Conversation</a></div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
