<?php
$page_title = 'Terms & Conditions | Silinex Global Services';
$page_desc  = 'Read the terms and conditions governing use of the Silinex Global Services website and our service engagements.';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="inner-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="/">Home</a><span>/</span><span>Terms &amp; Conditions</span></nav>
    <h1>Terms &amp; <span>Conditions</span></h1>
    <p>Last updated: January 2025</p>
  </div>
</section>

<section id="terms" style="padding:80px 0;background:var(--white)">
  <div class="container" style="max-width:860px">

    <div style="background:var(--blue-light);border:1.5px solid var(--blue);border-radius:var(--radius-lg);padding:28px 32px;margin-bottom:48px">
      <p style="font-size:.95rem;color:var(--navy);line-height:1.75">
        By accessing and using the <strong>Silinex Global Services</strong> website or engaging our services, you accept and agree to be bound by these Terms and Conditions and our Privacy Policy. If you do not agree, please do not use the site or our services.
      </p>
    </div>

    <?php
    $sections = [
      ['title'=>'Use of the Website',
       'body'=>'You agree to use this site only for lawful purposes and in a manner that does not infringe the rights of others or restrict their use and enjoyment of the site. You must not misuse the site by knowingly introducing viruses, trojans, worms or other malicious code.'],
      ['title'=>'Intellectual Property',
       'body'=>'All content on this site — including text, graphics, logos, images, icons and software — is the property of Silinex Global Services Pvt. Ltd. or its content suppliers and is protected by applicable intellectual property laws. You may not reproduce, distribute or create derivative works without our prior written consent.'],
      ['title'=>'Services & Engagements',
       'body'=>'All service engagements are subject to a separate written agreement or Statement of Work (SOW) executed between Silinex Global Services and the client. These Terms do not constitute a service contract. Specific deliverables, timelines, pricing and SLAs are defined in the applicable engagement documentation.'],
      ['title'=>'Disclaimer of Warranties',
       'body'=>'The site and its content are provided on an "as is" and "as available" basis without warranties of any kind, either express or implied. Silinex Global Services does not warrant that the site will be uninterrupted, error-free or free of viruses or other harmful components.'],
      ['title'=>'Limitation of Liability',
       'body'=>'To the fullest extent permitted by law, Silinex Global Services shall not be liable for any indirect, incidental, special, consequential or punitive damages arising out of or in connection with your use of the site or our services, even if we have been advised of the possibility of such damages.'],
      ['title'=>'Third-Party Links',
       'body'=>'The site may contain links to third-party websites for your convenience. Silinex Global Services does not endorse or accept any responsibility for the content or practices of those sites. Accessing third-party links is done entirely at your own risk.'],
      ['title'=>'Privacy',
       'body'=>'Your use of the site is also governed by our Privacy Policy, which is incorporated into these Terms by reference. Please review our Privacy Policy to understand our practices regarding the collection and use of your personal information.'],
      ['title'=>'Governing Law',
       'body'=>'These Terms shall be governed by and construed in accordance with the laws of India. Any disputes arising in connection with these Terms shall be subject to the exclusive jurisdiction of the courts of Hyderabad, Telangana, India.'],
      ['title'=>'Changes to Terms',
       'body'=>'We reserve the right to modify these Terms at any time. Changes will be effective immediately upon posting to the site. Your continued use of the site following the posting of revised Terms constitutes your acceptance of the changes.'],
      ['title'=>'Contact',
       'body'=>'For any questions regarding these Terms and Conditions, please contact us at: Silinex Global Services Pvt. Ltd., Laxmi Cyber City, 8th Floor, C Block, Whitefields, Kondapur, Hyderabad – 500084. Email: ' . SITE_EMAIL . ' | Phone: ' . SITE_PHONE],
    ];
    foreach ($sections as $i => $s):
    ?>
    <div style="margin-bottom:36px;padding-bottom:36px;border-bottom:1px solid var(--border)<?= $i===count($sections)-1?';border-bottom:none':'' ?>">
      <h2 style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--blue);margin-bottom:12px;display:flex;align-items:center;gap:10px">
        <span style="width:28px;height:28px;border-radius:50%;background:var(--blue-light);color:var(--blue);display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:900;flex-shrink:0"><?= $i+1 ?></span>
        <?= htmlspecialchars($s['title']) ?>
      </h2>
      <p style="color:var(--text-muted);line-height:1.8;font-size:.93rem;padding-left:38px"><?= htmlspecialchars($s['body']) ?></p>
    </div>
    <?php endforeach; ?>

  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
