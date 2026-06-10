<?php
require_once __DIR__ . '/../includes/config.php';
$page_title = 'IT Staffing, Oracle & Managed Services | Silinex Global';
$page_desc = 'Silinex Global Services delivers world-class IT staffing, Oracle ERP, Application Managed Services and GRC solutions powered by 100+ years of combined leadership.';

require_once __DIR__ . '/../includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════════
     HERO SLIDER
════════════════════════════════════════════════════════════ -->
<section class="hero-section" aria-label="Hero banner">
  <div class="hero-bg"></div>
  <div class="hero-shapes" aria-hidden="true">
    <img src="<?= CDN ?>/assets/images/hero/shape_image_1.webp" alt="" style="top:10%;left:2%;width:120px;opacity:.35"
      loading="lazy">
    <img src="<?= CDN ?>/assets/images/hero/shape_image_2.webp" alt="" style="bottom:12%;right:4%;width:160px;opacity:.25"
      loading="lazy">
  </div>
  <div class="container hero-slider">

    <!-- Slide 1 -->
    <div class="hero-slide active" role="group" aria-label="Slide 1">
      <div class="hero-content">
        <span class="hero-badge">Welcome to Silinex Global Services</span>
        <h1 class="hero-title">Empowering Digital Growth with <span>Intelligent IT & Staffing</span></h1>
        <p class="hero-desc">Silinex Global Services delivers world-class IT consulting, staffing, and technology
          solutions powered by innovation, trust, and over 100+ years of combined industry leadership.</p>
        <div class="hero-actions">
          <a href="/services#service" class="btn btn-primary">Explore Our Services</a>
          <a href="/contact#contact" class="btn btn-secondary">Get to Know</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="<?= CDN ?>/firm/assets/images/693a745ccc7eb.png" alt="IT Solutions Hero" width="540" height="440"
          loading="eager">
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="hero-slide" role="group" aria-label="Slide 2">
      <div class="hero-content">
        <span class="hero-badge">Technology & Talent</span>
        <h1 class="hero-title">Empowering Businesses Through <span>Technology & Talent</span></h1>
        <p class="hero-desc">We deliver smart IT solutions and expert staffing to drive innovation, growth, and global
          success.</p>
        <div class="hero-actions">
          <a href="/services#service" class="btn btn-primary">Explore Our Services</a>
          <a href="/contact#contact" class="btn btn-secondary">Talk to an Expert</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="<?= CDN ?>/firm/assets/images/69493643d0632_20251222_174459.png" alt="Oracle Cloud Services" width="540" height="440"
          loading="lazy">
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="hero-slide" role="group" aria-label="Slide 3">
      <div class="hero-content">
        <span class="hero-badge">Global IT Staffing</span>
        <h1 class="hero-title">Right Talent. <span>Right Time.</span> Every Time.</h1>
        <p class="hero-desc">Our staffing division connects high-calibre technology professionals with forward-thinking
          companies — contract, permanent and remote placements across the globe.</p>
        <div class="hero-actions">
          <a href="/services#staffing" class="btn btn-primary">Staffing Solutions</a>
          <a href="/career#career" class="btn btn-secondary">Join Our Team</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="<?= CDN ?>/firm/assets/images/693a757b9cde8_20251211_131043.png" alt="IT Staffing" width="540" height="440"
          loading="lazy">
      </div>
    </div>

    <!-- Dots -->
    <div class="hero-dots" role="tablist" aria-label="Slider navigation">
      <button class="hero-dot active" role="tab" aria-label="Go to slide 1"></button>
      <button class="hero-dot" role="tab" aria-label="Go to slide 2"></button>
      <button class="hero-dot" role="tab" aria-label="Go to slide 3"></button>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     PARTNERS / TRUSTED BY
════════════════════════════════════════════════════════════ -->
<section class="partners-section" aria-label="Our partners">
  <div class="container">
    <p class="partners-label">Trusted by Leading Organisations</p>
    <div class="partners-ticker" style="overflow:hidden;position:relative">
      <div class="partners-track" aria-hidden="true">
        <?php
        $logos = [
          ['src' => CDN . '/firm/assets/images/561.jpg', 'alt' => 'Partner 1'],
          ['src' => CDN . '/firm/assets/images/896.jpg', 'alt' => 'Partner 2'],
          ['src' => CDN . '/firm/assets/images/747.jpg', 'alt' => 'Partner 3'],
          ['src' => CDN . '/firm/assets/images/315.jpg', 'alt' => 'Partner 4'],
          ['src' => CDN . '/firm/assets/images/227.jpg', 'alt' => 'Partner 5'],
          ['src' => CDN . '/firm/assets/images/69538b2a833ce.jpeg', 'alt' => 'Partner 6'],
          ['src' => CDN . '/firm/assets/images/406.jpeg', 'alt' => 'Partner 7'],
          ['src' => CDN . '/firm/assets/images/436.png', 'alt' => 'Partner 8'],
        ];
        // Duplicate for seamless loop
        foreach (array_merge($logos, $logos) as $l):
          ?>
          <img src="<?= $l['src'] ?>" alt="<?= htmlspecialchars($l['alt']) ?>" height="42" loading="lazy">
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     SERVICES
════════════════════════════════════════════════════════════ -->
<section class="services-section" id="service" aria-labelledby="svc-heading">
  <div class="container">
    <div class="text-center">
      <span class="section-badge">What We Do</span>
      <h2 class="section-title" id="svc-heading">Our Core <span>Services</span></h2>
      <p class="tag-line">From staffing to enterprise cloud solutions, we deliver end-to-end technology services that
        fuel your business forward.</p>
    </div>
    <div class="services-grid">
      <?php
      $services = [
        ['img' => CDN . '/firm/assets/images/693a757b9cde8_20251211_131043.png', 'title' => 'IT Staffing', 'desc' => 'End-to-end staffing connecting top technology professionals with leading organisations. Contract, permanent and remote placements across industries and geographies.', 'link' => '/services#staffing'],
        ['img' => CDN . '/firm/assets/images/693a75f17717a_20251211_131241.png', 'title' => 'Application Managed Services', 'desc' => 'Keep your enterprise applications running at peak performance. We monitor, maintain and optimise so your teams can focus on innovation.', 'link' => '/services#ams'],
        ['img' => CDN . '/firm/assets/images/693a7658a4e31_20251211_131424.png', 'title' => 'GRC Services', 'desc' => 'Build a resilient, audit-ready organisation with our Governance, Risk and Compliance solutions. We help enterprises meet regulatory requirements with confidence.', 'link' => '/services#grc'],
        ['img' => CDN . '/firm/assets/images/694cd81582088_20251225_115213.jpeg', 'title' => 'Oracle Services', 'desc' => 'Certified Oracle implementation, migration and managed services across Fusion ERP, HCM Cloud, SCM Cloud, CX Cloud, PPM Cloud and Oracle Integration Cloud (OIC).', 'link' => '/services#oracle'],
        ['img' => CDN . '/firm/assets/images/6953a0fa98d6d_20251230_152258.png', 'title' => 'PropTech Solutions', 'desc' => 'Smart digital platforms for property management, tenant engagement and real-time asset performance insights for the modern real-estate sector.', 'link' => '/services#proptech'],
        ['img' => CDN . '/firm/assets/images/69539e32406f5_20251230_151106.png', 'title' => 'Digital Transformation', 'desc' => 'Modernise legacy systems, adopt cloud-first strategies and harness data analytics to outperform the competition in a rapidly evolving landscape.', 'link' => '/services'],
      ];
      foreach ($services as $s):
        ?>
        <article class="service-card">
          <div class="sc-img-wrap">
            <img class="sc-img" src="<?= $s['img'] ?>" alt="<?= htmlspecialchars($s['title']) ?>" width="64" height="64"
              loading="lazy">
          </div>
          <h3 class="sc-title"><?= htmlspecialchars($s['title']) ?></h3>
          <p class="sc-desc"><?= htmlspecialchars($s['desc']) ?></p>
          <a href="<?= $s['link'] ?>" class="sc-link" aria-label="Learn more about <?= htmlspecialchars($s['title']) ?>"
            style="display:inline-flex;align-items:center;gap:6px;margin-top:16px;font-weight:700;font-size:.85rem;color:inherit;position:relative;z-index:1;transition:var(--trans)">
            Learn More
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14">
              <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="services-cta">
      <a href="/services#service" class="btn btn-primary">View All Services</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     ABOUT STRIP
════════════════════════════════════════════════════════════ -->
<section class="about-section" aria-labelledby="about-heading">
  <div class="container about-inner">
    <!-- Images -->
    <div class="about-imgs">
      <img class="img-main" src="<?= CDN ?>/assets/images/about/about.jpg" alt="About Silinex Global"
        loading="lazy">
      <div class="img-badge">
        <div class="num">100+</div>
        <div class="label">Years Combined<br>Experience</div>
      </div>
    </div>
    <!-- Copy -->
    <div class="about-copy">
      <span class="section-badge">Who We Are</span>
      <h2 class="section-title" id="about-heading">Empowering Growth Through <span>Technology & Talent</span></h2>
      <p style="color:var(--text-muted);margin:16px 0;line-height:1.75">Silinex is founded on decades of expertise in
        IT, staffing, and digital transformation. Our leadership team brings proven success across energy, healthcare,
        technology, and enterprise sectors. We partner with organizations to build resilient systems, high-performing
        teams, and future-ready digital foundations.</p>
      <div class="happy-line">
        <div class="about-avatars">
          <img src="<?= CDN ?>/assets/images/avatar/1.jpg" alt="Client 1" width="36" height="36">
          <img src="<?= CDN ?>/assets/images/avatar/2.jpg" alt="Client 2" width="36" height="36">
          <img src="<?= CDN ?>/assets/images/avatar/3.jpg" alt="Client 3" width="36" height="36">
        </div>
        <span>200+ Happy clients worldwide</span>
      </div>
      <a href="/about#about" class="btn btn-primary">Learn More About Us</a>
      <div class="stat-row">
        <?php
        $stats = [['num' => '500+', 'label' => 'Projects Delivered'], ['num' => '50+', 'label' => 'Technology Experts'], ['num' => '15+', 'label' => 'Countries Served'], ['num' => '98%', 'label' => 'Client Satisfaction']];
        foreach ($stats as $st):
          ?>
          <div class="stat-box">
            <div class="num"><?= $st['num'] ?></div>
            <p><?= $st['label'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     INDUSTRIES
════════════════════════════════════════════════════════════ -->
<section class="industries-section" aria-labelledby="ind-heading">
  <div class="container">
    <div class="text-center">
      <span class="section-badge">Industries We Serve</span>
      <h2 class="section-title" id="ind-heading">Sector-Deep <span>Expertise</span></h2>
      <p class="tag-line">We bring specialised knowledge across verticals so our solutions fit your industry's unique
        demands.</p>
    </div>
    <?php
    $industries = [
      ['id' => 'ind-proptech', 'label' => 'PropTech', 'icon' => '🏗️', 'title' => 'PropTech (Real Estate)', 'desc' => 'We deliver smart digital platforms that streamline property management, tenant engagement, and real-time asset performance for real estate businesses.'],
      ['id' => 'ind-retail', 'label' => 'Retail', 'icon' => '🛍️', 'title' => 'Retail', 'desc' => 'We help retail businesses optimize operations, enhance customer experiences, and scale faster through intelligent technology and data-driven solutions.'],
      ['id' => 'ind-health', 'label' => 'Healthcare', 'icon' => '🏥', 'title' => 'Healthcare / Pharma', 'desc' => 'We enable healthcare and pharmaceutical organizations to improve efficiency, compliance, and data accuracy through secure, scalable digital systems.'],
      ['id' => 'ind-energy', 'label' => 'Energy', 'icon' => '⚡', 'title' => 'Energy', 'desc' => 'We support energy companies with reliable digital infrastructure, automation, and real-time analytics to improve operational performance and sustainability.'],
      ['id' => 'ind-enterprise', 'label' => 'Enterprise', 'icon' => '💻', 'title' => 'Enterprise & Technology', 'desc' => 'We empower enterprises and technology companies with scalable, secure, and high-performance solutions that drive innovation and business growth.'],
      ['id' => 'ind-edtech', 'label' => 'EdTech', 'icon' => '🎓', 'title' => 'EdTech', 'desc' => 'We provide vetted and skilled professionals who help you manage daily tasks, improve learning experiences and scale your programs with confidence.'],
    ];
    ?>
    <div class="industries-tabs" role="tablist" aria-label="Industry tabs">
      <?php foreach ($industries as $i => $ind): ?>
        <button class="ind-tab<?= $i === 0 ? ' active' : '' ?>" data-tab="<?= $ind['id'] ?>" role="tab"
          aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="<?= $ind['id'] ?>">
          <?= $ind['icon'] ?>   <?= htmlspecialchars($ind['label']) ?>
        </button>
      <?php endforeach; ?>
    </div>
    <div class="ind-panels">
      <?php foreach ($industries as $i => $ind): ?>
        <div class="ind-panel<?= $i === 0 ? ' active' : '' ?>" id="<?= $ind['id'] ?>" role="tabpanel">
          <div>
            <h3 class="ind-panel-title"><?= htmlspecialchars($ind['title']) ?></h3>
            <p class="ind-panel-desc"><?= htmlspecialchars($ind['desc']) ?></p>
            <a href="/services" class="btn btn-primary" style="margin-top:24px">Explore Solutions</a>
          </div>
          <div class="ind-panel-icon" aria-hidden="true"><?= $ind['icon'] ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     TECHNOLOGIES
════════════════════════════════════════════════════════════ -->
<section class="tech-section" aria-labelledby="tech-heading">
  <div class="container">
    <div class="text-center">
      <span class="section-badge">Technologies</span>
      <h2 class="section-title" id="tech-heading">Tools & Platforms We <span>Master</span></h2>
      <p class="tag-line">Our team is certified and experienced across the full modern technology stack.</p>
    </div>
    <?php
    $tech_cats = ['All', 'Oracle', 'Cloud', 'ERP', 'Integration', 'Analytics'];
    $technologies = [
      ['name' => 'PHP', 'cat' => 'erp', 'img' => CDN . '/firm/assets/images/69490a10ecdbb_20251222_143624.svg'],
      ['name' => 'JavaScript', 'cat' => 'erp', 'img' => CDN . '/firm/assets/images/69490a231d49f_20251222_143643.svg'],
      ['name' => 'Swift', 'cat' => 'erp', 'img' => CDN . '/firm/assets/images/69490a88cbbcd_20251222_143824.svg'],
      ['name' => 'Java', 'cat' => 'erp', 'img' => CDN . '/firm/assets/images/69490ad43ee8a_20251222_143940.svg'],
      ['name' => 'Database Platform', 'cat' => 'analytics', 'img' => CDN . '/firm/assets/images/69539bf8d5e30_20251230_150136.png'],
      ['name' => 'Data Services', 'cat' => 'analytics', 'img' => CDN . '/firm/assets/images/69539c4e95395_20251230_150302.png'],
      ['name' => 'Cloud Platform', 'cat' => 'cloud', 'img' => CDN . '/firm/assets/images/69539e32406f5_20251230_151106.png'],
      ['name' => 'DevOps', 'cat' => 'cloud', 'img' => CDN . '/firm/assets/images/69539e51b8db4_20251230_151137.png'],
      ['name' => 'Oracle Cloud', 'cat' => 'oracle', 'img' => CDN . '/firm/assets/images/694cd826b3bfe_20251225_115230.png'],
      ['name' => 'Oracle HCM', 'cat' => 'oracle', 'img' => CDN . '/firm/assets/images/6953a2db5a124_20251230_153059.png'],
      ['name' => 'Integration Cloud', 'cat' => 'oracle integration', 'img' => CDN . '/firm/assets/images/6953a0fa98d6d_20251230_152258.png'],
      ['name' => 'API Integration', 'cat' => 'integration', 'img' => CDN . '/firm/assets/images/6953a1161d5e3_20251230_152326.png'],
    ];
    ?>
    <div class="tech-tabs" role="tablist">
      <?php foreach ($tech_cats as $cat): ?>
        <button class="tech-tab" data-cat="<?= strtolower($cat) ?>" role="tab"><?= htmlspecialchars($cat) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="tech-grid" role="list">
      <?php foreach ($technologies as $t): ?>
        <div class="tech-card" data-cat="<?= htmlspecialchars($t['cat']) ?>" role="listitem">
          <img src="<?= $t['img'] ?>" alt="<?= htmlspecialchars($t['name']) ?>" width="44" height="44" loading="lazy"
            onerror="this.style.display='none'">
          <?= htmlspecialchars($t['name']) ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     TESTIMONIALS
════════════════════════════════════════════════════════════ -->
<section class="testimonials-section" aria-labelledby="testi-heading">
  <div class="container">
    <div class="text-center">
      <span class="section-badge">Client Stories</span>
      <h2 class="section-title" id="testi-heading">What Our Clients Say</h2>
    </div>
    <div class="testi-slider">
      <div class="testi-track">
        <?php
        $testimonials = [
          ['quote' => 'Silinex Global Services delivered exceptional results for our digital transformation journey. Their technical expertise and commitment to quality helped us scale faster with confidence.', 'name' => 'Compliance Manager', 'role' => 'Digital Transformation Client', 'img' => CDN . '/firm/assets/images/606.jpg'],
          ['quote' => 'The Silinex team provided us with highly skilled professionals who perfectly matched our project requirements. Their staffing solutions were fast, reliable, and effective.', 'name' => 'HR Director', 'role' => 'Staffing Client', 'img' => CDN . '/firm/assets/images/633.jpg'],
          ['quote' => 'We partnered with Silinex for managed services, and they exceeded our expectations. Their proactive support and deep technical knowledge significantly improved our system performance.', 'name' => 'Operations Head', 'role' => 'Managed Services Client', 'img' => CDN . '/firm/assets/images/625.jpg'],
        ];
        foreach ($testimonials as $t):
          ?>
          <div class="testi-card">
            <svg width="28" height="20" viewBox="0 0 28 20" fill="none" aria-hidden="true"
              style="margin-bottom:14px;opacity:.5">
              <path
                d="M0 20V12.5C0 5.596 3.795 1.458 11.384 0L12.5 2.115C9.263 2.948 7.276 4.923 6.538 8H11.5V20H0ZM16.5 20V12.5C16.5 5.596 20.295 1.458 27.884 0L29 2.115C25.763 2.948 23.776 4.923 23.038 8H28V20H16.5Z"
                fill="white" />
            </svg>
            <p class="testi-quote"><?= htmlspecialchars($t['quote']) ?></p>
            <div class="testi-author">
              <img src="<?= $t['img'] ?>" alt="<?= htmlspecialchars($t['name']) ?>" width="48" height="48" loading="lazy"
                onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($t['name']) ?>&background=1355c7&color=fff&size=48'">
              <div>
                <div class="testi-author-name"><?= htmlspecialchars($t['name']) ?></div>
                <div class="testi-author-role"><?= htmlspecialchars($t['role']) ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="testi-controls" role="group" aria-label="Testimonial navigation">
      <button class="testi-btn" aria-label="Previous testimonial">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="18" height="18">
          <path d="M15 18l-6-6 6-6" />
        </svg>
      </button>
      <button class="testi-btn" aria-label="Next testimonial">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="18" height="18">
          <path d="M9 18l6-6-6-6" />
        </svg>
      </button>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     FAQ
════════════════════════════════════════════════════════════ -->
<section class="faq-section" aria-labelledby="faq-heading">
  <div class="container">
    <div class="text-center">
      <span class="section-badge">FAQ</span>
      <h2 class="section-title" id="faq-heading">Frequently Asked <span>Questions</span></h2>
    </div>
    <div class="faq-list" role="list">
      <?php
      $faqs = [
        ['q' => 'What services does Silinex Global Services provide?', 'a' => 'Silinex Global Services provides IT staffing, application managed services, GRC (Governance, Risk & Compliance) services, Oracle and Zoho consulting, and digital transformation solutions.'],
        ['q' => 'What industries do you work with?', 'a' => 'We work with clients across real estate (PropTech), retail, healthcare, pharma, energy, fintech, manufacturing, and enterprise technology sectors.'],
        ['q' => 'Do you offer flexible staffing models?', 'a' => 'Yes, we offer flexible hiring models including contract, permanent, contract-to-hire, and remote or offshore resource augmentation.'],
        ['q' => 'What is Application Managed Services (AMS)?', 'a' => 'Application Managed Services is a support model where we manage, monitor, maintain, and optimize your enterprise applications so you can focus on core business operations.'],
        ['q' => 'How do you ensure compliance and security in your services?', 'a' => 'We follow industry best practices in governance, risk management, and compliance, and implement strong cybersecurity measures to protect client data and systems.'],
      ];
      foreach ($faqs as $i => $faq):
        ?>
        <div class="faq-item" role="listitem">
          <button class="faq-q" aria-expanded="false" aria-controls="faq-a-<?= $i ?>">
            <?= htmlspecialchars($faq['q']) ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="18" height="18"
              aria-hidden="true">
              <path d="M6 9l6 6 6-6" />
            </svg>
          </button>
          <div class="faq-a" id="faq-a-<?= $i ?>" role="region">
            <div class="faq-a-inner"><?= htmlspecialchars($faq['a']) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     BLOGS PREVIEW
════════════════════════════════════════════════════════════ -->
<section class="blogs-section" aria-labelledby="blog-heading">
  <div class="container">
    <div class="text-center">
      <span class="section-badge">Latest Insights</span>
      <h2 class="section-title" id="blog-heading">From Our <span>Blog</span></h2>
      <p class="tag-line">Stay ahead with expert perspectives on enterprise technology, staffing trends and digital
        transformation.</p>
    </div>
    <div class="blogs-grid">
      <?php
      $blogs = [
        ['img' => CDN . '/firm/assets/images/6a08abcd066fc_20260516_230925.png', 'cat' => 'AI & Workforce', 'date' => 'May 13, 2026', 'title' => 'Future of Work: How Human + AI Collaboration is Reshaping the Enterprise', 'link' => '/blog#blog'],
        ['img' => CDN . '/firm/assets/images/69fb719d13559_20260506_222141.png', 'cat' => 'AI & Leadership', 'date' => 'May 04, 2026', 'title' => 'Leadership Skills Needed in the AI Era', 'link' => '/blog#blog'],
      ];
      foreach ($blogs as $b):
        ?>
        <article class="blog-card">
          <div class="blog-card-img">
            <img src="<?= $b['img'] ?>" alt="<?= htmlspecialchars($b['title']) ?>" loading="lazy"
              onerror="this.parentElement.style.background='var(--blue-light)'">
          </div>
          <div class="blog-card-body">
            <div class="blog-meta">
              <span><?= htmlspecialchars($b['cat']) ?></span>
              <span>·</span>
              <span><?= htmlspecialchars($b['date']) ?></span>
            </div>
            <h3 class="blog-card-title"><?= htmlspecialchars($b['title']) ?></h3>
            <a href="<?= $b['link'] ?>" class="btn btn-primary"
              style="margin-top:18px;padding:9px 22px;font-size:.85rem">Read More</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="blogs-cta">
      <a href="/blog#blog" class="btn btn-primary">View All Articles</a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CTA BANNER
════════════════════════════════════════════════════════════ -->
<section class="cta-banner" aria-labelledby="cta-heading">
  <div class="container">
    <h2 id="cta-heading">Ready to Transform Your Business?</h2>
    <p>Let's discuss how Silinex Global can accelerate your technology journey.</p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap">
      <a href="/contact#contact" class="btn btn-secondary">Contact Us Today</a>
      <a href="<?= WA_LINK ?>" target="_blank" rel="noopener" class="btn btn-accent">
        <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18" aria-hidden="true">
          <path
            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
        WhatsApp Us
      </a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
