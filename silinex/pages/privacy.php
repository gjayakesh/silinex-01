<?php
$page_title = 'Privacy Policy | Silinex Global Services';
$page_desc  = 'Read the Silinex Global Services privacy policy – how we collect, use and protect your personal data.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Privacy Policy</span></nav>
    <h1>Privacy <span>Policy</span></h1>
    <p>Last updated: January 2025</p>
  </div>
</section>

<section id="policy" style="padding:80px 0;background:var(--white)">
  <div class="container" style="max-width:860px">

    <!-- Intro card -->
    <div style="background:var(--blue-light);border:1.5px solid var(--blue);border-radius:var(--radius-lg);padding:28px 32px;margin-bottom:48px">
      <p style="font-size:.95rem;color:var(--navy);line-height:1.75">
        At <strong>Silinex Global Services Pvt. Ltd.</strong>, your privacy is our priority. This Privacy Policy outlines how we collect, use, and protect your personal information when you interact with our website or services. Please read it carefully and contact us if you have any questions.
      </p>
    </div>

    <?php
    $sections = [
      ['title'=>'1. Information We Collect',
       'body'=>'We may collect personal information that you voluntarily provide when you fill in a contact or enquiry form, subscribe to our newsletter, apply for a job opening, or communicate with us via email, phone or social media. This may include your name, email address, phone number, company name, job title and the content of your message.'],
      ['title'=>'2. How We Use Your Information',
       'body'=>'We use the information we collect to: respond to your enquiries and provide requested services; send you relevant updates, newsletters and marketing communications (with your consent); process job applications; improve our website and service offerings; comply with legal obligations; and prevent fraudulent or harmful activity.'],
      ['title'=>'3. Sharing of Information',
       'body'=>'We do not sell, trade or rent your personal information to third parties. We may share information with trusted service providers who assist us in operating our website and delivering services, subject to appropriate confidentiality agreements. We may also disclose information when required by law or to protect our legal rights.'],
      ['title'=>'4. Data Retention',
       'body'=>'We retain your personal data only for as long as necessary to fulfil the purposes for which it was collected, including to satisfy legal, accounting or reporting requirements. Enquiry and contact data is typically retained for up to 3 years unless you request earlier deletion.'],
      ['title'=>'5. Cookies',
       'body'=>'Our website may use cookies and similar tracking technologies to improve your browsing experience, analyse site traffic and understand where our visitors are coming from. You can control cookie settings through your browser preferences. Disabling cookies may affect some site functionality.'],
      ['title'=>'6. Your Rights',
       'body'=>'Depending on your location, you may have the right to: access the personal data we hold about you; request correction of inaccurate data; request deletion of your personal data; object to or restrict certain processing activities; and withdraw consent where processing is based on consent. To exercise any of these rights, please contact us at ' . SITE_EMAIL . '.'],
      ['title'=>'7. Data Security',
       'body'=>'We implement appropriate technical and organisational measures to protect your personal data against unauthorised access, loss, alteration or disclosure. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.'],
      ['title'=>'8. Third-Party Links',
       'body'=>'Our website may contain links to third-party websites. We are not responsible for the privacy practices or content of those sites. We encourage you to review the privacy policies of any third-party sites you visit.'],
      ['title'=>'9. Changes to This Policy',
       'body'=>'We may update this Privacy Policy from time to time. We will notify you of significant changes by posting the updated policy on this page with a revised "Last updated" date. Continued use of our website after any changes constitutes your acceptance of the updated policy.'],
      ['title'=>'10. Contact Us',
       'body'=>'If you have questions, concerns or requests regarding this Privacy Policy or the handling of your personal data, please contact us at: Silinex Global Services Pvt. Ltd., Laxmi Cyber City, 8th Floor, C Block, Whitefields, Kondapur, Hyderabad – 500084, India. Email: ' . SITE_EMAIL . ' | Phone: ' . SITE_PHONE],
    ];
    foreach ($sections as $i => $s):
    ?>
    <div style="margin-bottom:36px;padding-bottom:36px;border-bottom:1px solid var(--border)<?= $i===count($sections)-1?';border-bottom:none':'' ?>">
      <h2 style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--blue);margin-bottom:12px;display:flex;align-items:center;gap:10px">
        <span style="width:28px;height:28px;border-radius:50%;background:var(--blue-light);color:var(--blue);display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:900;flex-shrink:0"><?= $i+1 ?></span>
        <?= htmlspecialchars(substr($s['title'], strpos($s['title'],' ')+1)) ?>
      </h2>
      <p style="color:var(--text-muted);line-height:1.8;font-size:.93rem;padding-left:38px"><?= htmlspecialchars($s['body']) ?></p>
    </div>
    <?php endforeach; ?>

  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
