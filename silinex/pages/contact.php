<?php
$page_title = 'Contact Us | Silinex Global Services';
$page_desc  = 'Reach out to Silinex Global Services. Based in Hyderabad, serving clients globally. We respond within 24 hours.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Contact Us</span></nav>
    <h1>Contact <span>Us</span></h1>
    <p>Have a project in mind? We'd love to hear from you. Send us a message and we'll respond within 24 hours.</p>
  </div>
</section>

<section class="contact-section" id="contact">
  <div class="container contact-grid">

    <!-- Info -->
    <div>
      <span class="section-tag">Get In Touch</span>
      <h2 class="section-title" style="margin-bottom:32px">We're Here to <span>Help</span></h2>

      <div class="contact-info-item">
        <div class="ci-icon">
          <img src="<?= CDN ?>/assets/images/icons/icon_mail.svg" alt="" width="22" height="22"
               onerror="this.outerHTML='<span style=\'font-size:1.2rem\'>✉️</span>'">
        </div>
        <div>
          <strong>Email us</strong>
          <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a>
        </div>
      </div>

      <div class="contact-info-item">
        <div class="ci-icon">
          <img src="<?= CDN ?>/assets/images/icons/icon_calling_2.svg" alt="" width="22" height="22"
               onerror="this.outerHTML='<span style=\'font-size:1.2rem\'>📞</span>'">
        </div>
        <div>
          <strong>Call us</strong>
          <a href="tel:+918688945694"><?= SITE_PHONE ?></a>
        </div>
      </div>

      <div class="contact-info-item">
        <div class="ci-icon">
          <img src="<?= CDN ?>/assets/images/icons/icon_global.svg" alt="" width="22" height="22"
               onerror="this.outerHTML='<span style=\'font-size:1.2rem\'>📍</span>'">
        </div>
        <div>
          <strong>Our Office</strong>
          <p><?= SITE_ADDRESS ?></p>
        </div>
      </div>

      <!-- Social -->
      <div style="margin-top:36px">
        <p style="font-weight:800;color:var(--navy);font-size:.92rem;margin-bottom:14px">Follow Us</p>
        <ul class="social-list">
          <?php foreach ($socials as $name => $s): ?>
          <li>
            <a href="<?= $s['url'] ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= ucfirst($name) ?>">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="17" height="17" aria-hidden="true">
                <path d="<?= $s['icon'] ?>"/>
              </svg>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- WhatsApp -->
      <a href="<?= WA_LINK ?>" target="_blank" rel="noopener"
         style="display:inline-flex;align-items:center;gap:10px;margin-top:28px;background:#25D366;color:#fff;padding:13px 24px;border-radius:50px;font-weight:800;font-size:.9rem;transition:var(--trans)"
         onmouseover="this.style.background='#1da851'" onmouseout="this.style.background='#25D366'">
        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        Chat with us!
      </a>
    </div>

    <!-- Form -->
    <div class="contact-form">
      <h3 class="form-title">Send Us a Message</h3>
      <p class="form-subtitle">We typically respond within 24 business hours.</p>
      <form id="contactForm" novalidate>
        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
        <div class="form-row">
          <div class="form-group">
            <label for="name">Full Name <span style="color:var(--orange)">*</span></label>
            <input type="text" id="name" name="name" placeholder="John Smith" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address <span style="color:var(--orange)">*</span></label>
            <input type="email" id="email" name="email" placeholder="john@company.com" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210">
          </div>
          <div class="form-group">
            <label for="subject">Subject</label>
            <select id="subject" name="subject">
              <option value="">Select a topic…</option>
              <option>IT Staffing Enquiry</option>
              <option>Oracle Services</option>
              <option>Application Managed Services</option>
              <option>GRC Services</option>
              <option>Partnership / Alliance</option>
              <option>Careers</option>
              <option>General Enquiry</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="message">Message <span style="color:var(--orange)">*</span></label>
          <textarea id="message" name="message" placeholder="Tell us about your project or how we can help…" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;font-size:1rem">
          Send Message
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" aria-hidden="true"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z"/></svg>
        </button>
        <div class="form-msg" id="formMsg" aria-live="polite"></div>
      </form>
    </div>

  </div>
</section>

<!-- Map -->
<div style="line-height:0;margin-top:-1px">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3806.2282038875637!2d78.36320!3d17.46010!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb93ef4b5c6b8f%3A0x0!2sLaxmi+Cyber+City%2C+Kondapur%2C+Hyderabad!5e0!3m2!1sen!2sin!4v1700000000000"
    width="100%" height="360" style="border:0;display:block" allowfullscreen loading="lazy"
    referrerpolicy="no-referrer-when-downgrade" title="Silinex Global Office Location"></iframe>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
