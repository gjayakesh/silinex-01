<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (!function_exists('define_if_missing')) {
    function define_if_missing(string $name, $value): void
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }
}

if (!function_exists('site_url_from_request')) {
    function site_url_from_request(): string
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        if ($host === '') {
            return 'https://www.silinexglobal.com';
        }

        $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');

        return ($isHttps ? 'https' : 'http') . '://' . $host;
    }
}

define_if_missing('SITE_NAME',    'Silinex Global Services');
define_if_missing('SITE_URL',     site_url_from_request());
define_if_missing('SITE_EMAIL',   'info@silinexglobal.com');

define_if_missing('SITE_PHONE',   '+91 868 894 5694');
define_if_missing('SITE_ADDRESS', 'Silinex Global Services Pvt Ltd, Laxmi Cyber City, 8th Floor, C Block, Whitefields, Kondapur, Hyderabad-500084');
define_if_missing('WA_LINK',      'https://api.whatsapp.com/send?phone=+918688945694&text=I%20am%20interested%20in%20learning%20more%20about%20your%20services.');
define_if_missing('CDN',          '');

/* Database
   The site works out of the box with SQLite. For production MySQL hosting,
   set DB_DRIVER to 'mysql' and fill in the MySQL connection values below. */
define_if_missing('DB_DRIVER', 'sqlite'); // sqlite or mysql
define_if_missing('DB_PATH', __DIR__ . '/../data/silinex.sqlite');
define_if_missing('DB_HOST', '127.0.0.1');
define_if_missing('DB_PORT', '3306');
define_if_missing('DB_NAME', 'silinex');
define_if_missing('DB_USER', 'root');
define_if_missing('DB_PASS', '');
define_if_missing('DB_CHARSET', 'utf8mb4');

/* Admin data viewer
   Change this password before deployment. */
define_if_missing('ADMIN_DATA_PASSWORD', 'admin123');

/* ── Navigation ─────────────────────────────────────────── */
$nav_items = [
  ['label'=>'Home',             'href'=>'/',                'sub'=>[]],
  ['label'=>'Services',         'href'=>'/services',        'sub'=>[
    ['label'=>'Staffing',                    'href'=>'/services#staffing'],
    ['label'=>'Application Managed Services','href'=>'/services#ams'],
    ['label'=>'GRC Services',                'href'=>'/services#grc'],
    ['label'=>'Oracle Services',             'href'=>'/services#oracle'],
  ]],
  ['label'=>'Industries',       'href'=>'/industries',      'sub'=>[
    ['label'=>'PropTech (Real Estate)',  'href'=>'/industries#proptech'],
    ['label'=>'Retail',                  'href'=>'/industries#retail'],
    ['label'=>'Healthcare / Pharma',     'href'=>'/industries#healthcare'],
    ['label'=>'Energy',                  'href'=>'/industries#energy'],
    ['label'=>'Enterprise & Technology', 'href'=>'/industries#enterprise'],
    ['label'=>'EdTech',                  'href'=>'/industries#edtech'],
  ]],
  ['label'=>'Customer Success', 'href'=>'/success-stories', 'sub'=>[
    ['label'=>'Partners & Alliances','href'=>'/success-stories#partner'],
  ]],
  ['label'=>'About',            'href'=>'/about',           'sub'=>[
    ['label'=>'Who We Are','href'=>'/about#about'],
    ['label'=>'Blogs',     'href'=>'/blog#blog'],
  ]],
  ['label'=>'Careers',          'href'=>'/career',          'sub'=>[]],
  ['label'=>'Contact Us',       'href'=>'/contact',         'sub'=>[]],
];

/* ── Social links (SVG path data) ───────────────────────── */
$socials = [
  'facebook'  => ['url'=>'https://www.facebook.com/profile.php?id=61585783763864',
                  'icon'=>'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
  'twitter'   => ['url'=>'https://x.com/silinexglobal',
                  'icon'=>'M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0016.5 3c-2.5 0-4.5 2-4.5 4.5v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z'],
  'linkedin'  => ['url'=>'https://www.linkedin.com/company/silinex-global-services/',
                  'icon'=>'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],
  'instagram' => ['url'=>'https://www.instagram.com/silinexglobal',
                  'icon'=>'M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5h.01M7.55 2h8.9A5.55 5.55 0 0122 7.55v8.9A5.55 5.55 0 0116.45 22H7.55A5.55 5.55 0 012 16.45V7.55A5.55 5.55 0 017.55 2z'],
  'youtube'   => ['url'=>'https://www.youtube.com/',
                  'icon'=>'M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58zM9.75 15.02V8.98L15.5 12l-5.75 3.02z'],
];

/* ── Search index (all pages + sections) ────────────────── */
$search_index = [
  ['title'=>'IT Staffing Solutions',       'url'=>'/services#staffing',  'desc'=>'End-to-end staffing connecting top technology professionals with leading organisations.','tags'=>'staffing hire contract permanent remote augmentation talent'],
  ['title'=>'Application Managed Services','url'=>'/services#ams',       'desc'=>'Managed IT support model to monitor, maintain and optimise your enterprise applications.','tags'=>'AMS managed services application support monitoring SLA'],
  ['title'=>'GRC Services',               'url'=>'/services#grc',        'desc'=>'Governance, Risk & Compliance solutions helping enterprises build trust and operational resilience.','tags'=>'governance risk compliance GRC audit SOX GDPR ISO'],
  ['title'=>'Oracle Fusion ERP',           'url'=>'/services#oracle',    'desc'=>'Oracle Fusion ERP, HCM Cloud, SCM Cloud, CX Cloud, PPM Cloud and OIC implementation.','tags'=>'oracle ERP HCM SCM CX PPM OIC fusion cloud'],
  ['title'=>'Oracle HCM Cloud',            'url'=>'/services#oracle',    'desc'=>'Oracle Human Capital Management Cloud implementation and managed services.','tags'=>'oracle HCM human capital management payroll HR'],
  ['title'=>'Oracle Integration Cloud',    'url'=>'/services#oracle',    'desc'=>'Oracle OIC integration design, build and support services.','tags'=>'oracle OIC integration cloud REST SOAP API'],
  ['title'=>'PropTech / Real Estate',      'url'=>'/industries#proptech','desc'=>'Smart digital platforms for property management, tenant engagement and real-time asset performance.','tags'=>'real estate proptech property management IoT lease'],
  ['title'=>'Retail Technology',           'url'=>'/industries#retail',  'desc'=>'Omni-channel commerce and AI personalisation for retail brands.','tags'=>'retail ecommerce omnichannel inventory customer experience'],
  ['title'=>'Healthcare & Pharma',         'url'=>'/industries#healthcare','desc'=>'Improve efficiency and compliance through secure, scalable digital systems.','tags'=>'healthcare pharma compliance digital clinical'],
  ['title'=>'Energy Sector',              'url'=>'/industries#energy',   'desc'=>'Digital infrastructure, automation and analytics for energy companies.','tags'=>'energy oil gas automation analytics renewable utility'],
  ['title'=>'Enterprise & Technology',    'url'=>'/industries#enterprise','desc'=>'ERP modernisation and cloud migration for enterprise technology firms.','tags'=>'enterprise technology ERP cloud digital transformation'],
  ['title'=>'EdTech Solutions',           'url'=>'/industries#edtech',   'desc'=>'Adaptive learning platforms and LMS integrations for education.','tags'=>'edtech education learning LMS adaptive elearning'],
  ['title'=>'Our Industries',             'url'=>'/industries',          'desc'=>'Silinex serves PropTech, Retail, Healthcare, Energy, Enterprise and EdTech industries.','tags'=>'industries sectors verticals'],
  ['title'=>'Who We Are – About Silinex', 'url'=>'/about#about',        'desc'=>'Next-generation IT consulting and staffing company with 100+ years of combined leadership.','tags'=>'about us company leadership mission vision values'],
  ['title'=>'Careers at Silinex',         'url'=>'/career#career',      'desc'=>'Join our fast-growing team of technology professionals. Open roles in Oracle, GRC, Staffing.','tags'=>'jobs careers hiring work oracle grc staffing'],
  ['title'=>'Contact Us',                 'url'=>'/contact#contact',    'desc'=>'Reach us at Hyderabad or send a message. We respond within 24 hours.','tags'=>'contact phone email address hyderabad'],
  ['title'=>'Blog – AI & Enterprise',     'url'=>'/blog#blog',          'desc'=>'Insights on AI, staffing trends, Oracle, GRC and enterprise technology.','tags'=>'blog articles news AI enterprise leadership oracle grc'],
  ['title'=>'Customer Success Stories',   'url'=>'/success-stories',    'desc'=>'Case studies and client testimonials from Silinex engagements across industries.','tags'=>'case studies success stories clients results outcomes'],
  ['title'=>'Partners & Alliances',       'url'=>'/success-stories#partner','desc'=>'Our featured technology partners and alliance ecosystem.','tags'=>'partners alliances ecosystem technology oracle zoho'],
  ['title'=>'Privacy Policy',             'url'=>'/privacy-policy',     'desc'=>'How Silinex Global collects, uses and protects your personal data.','tags'=>'privacy data protection policy GDPR'],
  ['title'=>'Terms & Conditions',         'url'=>'/terms-condition',    'desc'=>'Terms governing use of the Silinex Global website and service engagements.','tags'=>'terms conditions legal policy'],
];
