<?php
$page_title = 'Careers – Join Our Team | Silinex Global Services';
$page_desc  = 'Explore exciting career opportunities at Silinex Global Services in Hyderabad. Join a fast-growing IT consulting and staffing company with global reach.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Careers</span></nav>
    <h1>Build Your Career with <span>Silinex Global</span></h1>
    <p>We're growing fast and always looking for talented, passionate technology professionals to join our team.</p>
  </div>
</section>

<!-- Why Work With Us -->
<section id="career" style="padding:88px 0;background:var(--white)">
  <div class="container">
    <div class="text-center">
      <span class="section-tag">Why Silinex</span>
      <h2 class="section-title">A Place Where <span>Talent Thrives</span></h2>
      <p class="section-sub">We invest in our people as much as we invest in our clients.</p>
    </div>
    <div class="values-grid">
      <?php
      $perks = [
        ['emoji'=>'🌍','title'=>'Global Exposure',       'desc'=>'Work on projects spanning US, UK, Middle East and APAC regions from our Hyderabad base.'],
        ['emoji'=>'📈','title'=>'Fast Career Growth',    'desc'=>'Structured growth paths, regular performance reviews and internal mobility across service lines.'],
        ['emoji'=>'🎓','title'=>'Learning & Development','desc'=>'Oracle certifications, cloud training, leadership programmes and industry conferences.'],
        ['emoji'=>'🤝','title'=>'Collaborative Culture', 'desc'=>'A flat, open environment where every voice counts and ideas are welcomed at every level.'],
        ['emoji'=>'💰','title'=>'Competitive Packages',  'desc'=>'Market-competitive salaries, performance bonuses and comprehensive benefits.'],
        ['emoji'=>'⚖️','title'=>'Work-Life Balance',     'desc'=>'Flexible hybrid and remote options to support your lifestyle and productivity.'],
      ];
      foreach ($perks as $p):
      ?>
      <div class="value-card">
        <div class="vc-emoji"><?= $p['emoji'] ?></div>
        <h3><?= htmlspecialchars($p['title']) ?></h3>
        <p><?= htmlspecialchars($p['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Open Positions -->
<section style="padding:88px 0;background:var(--bg)">
  <div class="container">
    <div class="text-center">
      <span class="section-tag">Open Roles</span>
      <h2 class="section-title">Current <span>Openings</span></h2>
      <p class="section-sub">We're hiring across multiple practice areas. Don't see a fit? Send us your CV anyway.</p>
    </div>
    <?php
    $jobs = [
      ['title'=>'Oracle Fusion HCM Consultant',       'type'=>'Full-time','location'=>'Hyderabad / Remote','exp'=>'3–8 Yrs', 'skills'=>['Oracle HCM','Fusion','Fast Formula','OIC']],
      ['title'=>'Oracle ERP (Finance) Consultant',    'type'=>'Full-time','location'=>'Hyderabad / Remote','exp'=>'4–9 Yrs', 'skills'=>['Oracle ERP','GL','AR','AP','Fixed Assets']],
      ['title'=>'IT Staffing Specialist',             'type'=>'Full-time','location'=>'Hyderabad',         'exp'=>'2–5 Yrs', 'skills'=>['Talent Acquisition','IT Staffing','LinkedIn Recruiter']],
      ['title'=>'GRC Analyst',                        'type'=>'Full-time','location'=>'Hyderabad / Remote','exp'=>'3–6 Yrs', 'skills'=>['GRC','SOX','ISO 27001','Risk Management']],
      ['title'=>'Oracle OIC Developer',               'type'=>'Contract / FT','location'=>'Remote',        'exp'=>'2–6 Yrs', 'skills'=>['OIC','REST','SOAP','Oracle ERP Integration']],
      ['title'=>'Business Development Manager',       'type'=>'Full-time','location'=>'Hyderabad / US',   'exp'=>'5–10 Yrs','skills'=>['IT Sales','Client Acquisition','Staffing']],
    ];
    ?>
    <div style="display:flex;flex-direction:column;gap:14px;margin-top:52px">
      <?php foreach ($jobs as $j): ?>
      <div style="background:var(--white);border:1.5px solid var(--border);border-radius:var(--radius-lg);padding:24px 28px;display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;transition:var(--trans)"
           onmouseover="this.style.borderColor='var(--blue)';this.style.boxShadow='var(--shadow)'"
           onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow='none'">
        <div style="flex:1;min-width:200px">
          <h3 style="font-weight:800;font-size:1.02rem;color:var(--navy);margin-bottom:8px"><?= htmlspecialchars($j['title']) ?></h3>
          <div style="display:flex;gap:18px;flex-wrap:wrap;font-size:.8rem;color:var(--text-muted);margin-bottom:10px">
            <span>📍 <?= htmlspecialchars($j['location']) ?></span>
            <span>⏱ <?= htmlspecialchars($j['type']) ?></span>
            <span>💼 <?= htmlspecialchars($j['exp']) ?></span>
          </div>
          <div style="display:flex;gap:6px;flex-wrap:wrap">
            <?php foreach ($j['skills'] as $sk): ?>
            <span style="background:var(--blue-light);color:var(--blue);font-size:.74rem;font-weight:800;padding:3px 11px;border-radius:50px"><?= htmlspecialchars($sk) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <a href="/contact#contact" class="btn btn-primary" style="flex-shrink:0">Apply Now</a>
      </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center;margin-top:44px;background:var(--white);border:2px dashed var(--border);border-radius:var(--radius-lg);padding:44px 24px">
      <div style="font-size:2.5rem;margin-bottom:12px">📬</div>
      <h3 style="font-weight:800;color:var(--navy);margin-bottom:8px">Don't See a Matching Role?</h3>
      <p style="color:var(--text-muted);margin-bottom:22px">Send us your CV and a brief introduction — we'll reach out when the right opportunity arises.</p>
      <a href="mailto:<?= SITE_EMAIL ?>?subject=General%20Application%20–%20Silinex%20Global" class="btn btn-primary">Send Your CV</a>
    </div>
  </div>
</section>

<!-- Hiring process -->
<section style="padding:88px 0;background:var(--white)">
  <div class="container">
    <div class="text-center">
      <span class="section-tag">Our Process</span>
      <h2 class="section-title">Simple, Transparent <span>Hiring</span></h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:24px;margin-top:52px;text-align:center">
      <?php
      $steps = [
        ['num'=>'01','title'=>'Apply',            'desc'=>'Submit your CV or apply for an open role. We review every application personally.'],
        ['num'=>'02','title'=>'Screening Call',   'desc'=>'A 20-min call with our talent team to understand your background and goals.'],
        ['num'=>'03','title'=>'Technical Round',  'desc'=>'A focused discussion with the hiring manager on your expertise.'],
        ['num'=>'04','title'=>'Offer & Onboarding','desc'=>'Receive a competitive offer. Our team ensures a smooth, warm start.'],
      ];
      foreach ($steps as $st):
      ?>
      <div style="padding:28px 16px">
        <div style="width:62px;height:62px;border-radius:50%;background:var(--blue);color:#fff;font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;box-shadow:0 4px 20px rgba(39,99,255,.3)"><?= $st['num'] ?></div>
        <h3 style="font-weight:800;color:var(--navy);margin-bottom:9px"><?= htmlspecialchars($st['title']) ?></h3>
        <p style="color:var(--text-muted);font-size:.88rem;line-height:1.65"><?= htmlspecialchars($st['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-banner">
  <div class="container">
    <h2>Ready to Take the Next Step?</h2>
    <p>Join a team that's shaping the future of enterprise technology — one client, one solution at a time.</p>
    <div class="btn-wrap"><a href="mailto:<?= SITE_EMAIL ?>?subject=Career%20Enquiry" class="btn btn-primary">Get in Touch</a></div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
