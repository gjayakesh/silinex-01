<?php
// includes/seo.php – Injects JSON-LD structured data per page
// Usage: require_once __DIR__ . '/seo.php';  (called inside header.php or individual pages)

$schema_org = [
    'organization' => [
        '@context'  => 'https://schema.org',
        '@type'     => 'Organization',
        'name'      => 'Silinex Global Services Pvt. Ltd.',
        'url'       => 'https://www.silinexglobal.com',
        'logo'      => 'https://www.silinexglobal.com/firm/assets/images/693d415aae1a4.png',
        'sameAs'    => [
            'https://www.linkedin.com/company/silinex-global-services/',
            'https://x.com/silinexglobal',
            'https://www.facebook.com/profile.php?id=61585783763864',
            'https://www.instagram.com/silinexglobal',
        ],
        'contactPoint' => [
            '@type'       => 'ContactPoint',
            'telephone'   => '+91-868-894-5694',
            'contactType' => 'customer service',
            'areaServed'  => 'Worldwide',
            'availableLanguage' => 'English',
        ],
        'address' => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Laxmi Cyber City, 8th Floor, C Block, Whitefields, Kondapur',
            'addressLocality' => 'Hyderabad',
            'addressRegion'   => 'Telangana',
            'postalCode'      => '500084',
            'addressCountry'  => 'IN',
        ],
    ],

    'website' => [
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        'name'            => 'Silinex Global Services',
        'url'             => 'https://www.silinexglobal.com',
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => [
                '@type'       => 'EntryPoint',
                'urlTemplate' => 'https://www.silinexglobal.com/search?q={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ],

    'local_business' => [
        '@context'    => 'https://schema.org',
        '@type'       => 'ProfessionalService',
        'name'        => 'Silinex Global Services Pvt. Ltd.',
        'image'       => 'https://www.silinexglobal.com/firm/assets/images/693d415aae1a4.png',
        'url'         => 'https://www.silinexglobal.com',
        'telephone'   => '+91-868-894-5694',
        'email'       => 'info@silinexglobal.com',
        'priceRange'  => '$$',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Laxmi Cyber City, 8th Floor, C Block, Whitefields, Kondapur',
            'addressLocality' => 'Hyderabad',
            'addressRegion'   => 'Telangana',
            'postalCode'      => '500084',
            'addressCountry'  => 'IN',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 17.46010,
            'longitude' => 78.36320,
        ],
        'openingHoursSpecification' => [
            [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
                'opens'     => '09:00',
                'closes'    => '18:00',
            ],
        ],
    ],
];

/**
 * Outputs a <script type="application/ld+json"> block.
 *
 * @param array  $data   The schema array
 * @param string $indent Optional label for readability
 */
function output_schema(array $data, string $indent = ''): void {
    echo "\n<script type=\"application/ld+json\">\n";
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    echo "\n</script>\n";
}
