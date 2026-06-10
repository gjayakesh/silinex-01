<?php // includes/footer.php ?>

<!-- WhatsApp float -->
<a href="<?= WA_LINK ?>" class="wa-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <img src="<?= CDN ?>/assets/images/whatsapp-button-white.png" alt="Chat with us on WhatsApp" width="58" height="58"
    loading="lazy">
</a>

<!-- Ticker -->
<div class="ticker-wrap" aria-hidden="true">
  <div class="ticker-track">
    <?php
    $ticks = ['Custom Web Apps', 'App Development', 'Web Development', 'Software Solution', 'Enterprise Apps', 'Devops Services'];
    for ($r = 0; $r < 4; $r++)
      foreach ($ticks as $t)
        echo "<span>{$t}</span>";
    ?>
  </div>
</div>

<!-- Footer -->
<footer class="site-footer">
  <div class="container footer-grid">

    <!-- Brand col -->
    <div class="footer-brand">
      <a href="/" aria-label="Silinex Global Home">
        <img src="<?= CDN ?>/firm/assets/images/693d416941fe9.png" alt="Silinex Global Services" width="155" height="44"
          loading="lazy">
      </a>
      <p>Silinex Global Services Pvt. Ltd. is a next-generation IT consulting and staffing company delivering innovative
        technology and talent solutions. We empower businesses with Oracle, enterprise, and digital services to drive
        growth, efficiency, and global success.</p>
      <ul class="social-list">
        <?php foreach ($socials as $name => $s): ?>
          <li>
            <a href="<?= $s['url'] ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= ucfirst($name) ?>">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="17" height="17"
                aria-hidden="true">
                <path d="<?= $s['icon'] ?>" />
              </svg>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Quick Links -->
    <nav class="footer-col" aria-label="Quick Links">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/services#service">Services</a></li>
        <li><a href="/success-stories">Customer Success</a></li>
        <li><a href="/about#about">About Us</a></li>
        <li><a href="/career#career">Careers</a></li>
        <li><a href="/contact#contact">Contact Us</a></li>
      </ul>
    </nav>

    <!-- Services -->
    <nav class="footer-col" aria-label="Our Services">
      <h4>Our Services</h4>
      <ul>
        <li><a href="/services#staffing">Staffing</a></li>
        <li><a href="/services#ams">Application Managed Services</a></li>
        <li><a href="/services#grc">GRC Services</a></li>
        <li><a href="/services#oracle">Oracle Services</a></li>
      </ul>
    </nav>

    <!-- Contact -->
    <div class="footer-col footer-contact">
      <h4>Get In Touch</h4>
      <div class="contact-item">
        <img src="<?= CDN ?>/assets/images/icons/icon_mail.svg" alt="" width="22" height="22" aria-hidden="true"
          onerror="this.outerHTML='<span style=\'font-size:1.1rem\'>✉️</span>'">
        <div>
          <strong>Email us</strong>
          <a href="mailto:<?= SITE_EMAIL ?>"><?= SITE_EMAIL ?></a>
        </div>
      </div>
      <div class="contact-item">
        <img src="<?= CDN ?>/assets/images/icons/icon_calling_2.svg" alt="" width="22" height="22" aria-hidden="true"
          onerror="this.outerHTML='<span style=\'font-size:1.1rem\'>📞</span>'">
        <div>
          <strong>Call us</strong>
          <a href="tel:+918688945694"><?= SITE_PHONE ?></a>
        </div>
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <p>Copyright &copy; <?= date('Y') ?> Silinex Global Services, All rights reserved.</p>
      <ul>
        <li><a href="/terms-condition#terms">Terms &amp; Conditions</a></li>
        <li><a href="/privacy-policy#policy">Privacy Policy</a></li>
      </ul>
    </div>
  </div>
</footer>
<script src="/assets/js/main.js" defer></script>
<script>
  (function (w, d, src, widgetKey, apiBase) {
    w.VoiceAgent = w.VoiceAgent || {};
    w.VoiceAgent.q = w.VoiceAgent.q || [];
    w.VoiceAgent.q.push(function () {
      w.VoiceAgent.init({ widgetKey: widgetKey, apiBase: apiBase });
    });
    if (!d.querySelector('script[data-nexora-widget]')) {
      var s = d.createElement('script');
      s.src = src;
      s.async = true;
      s.dataset.nexoraWidget = 'true';
      (d.head || d.body || d.documentElement).appendChild(s);
    }
  })(window, document, "https://nexora-admin-eeog.onrender.com/widget/embed.js", "va_widget_live_GP0ARnEb1NsVBpXsufzhAW1OQ0saJ6zoihtHq0Qx", "https://nexora-api-ngnu.onrender.com/api/v1");
</script>


</body>

</html>