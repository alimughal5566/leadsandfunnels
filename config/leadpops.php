<?php

return [
    'leadpopSubDomainTypeId' => 1,
    'leadpopDomainTypeId' => 2,
    'design' => [
        'logo' => [
            'minHeight' => 30,          // Slider Minimum value (%)
            'maxHeight' => 100,         // Slider Max value (%)

            'defaultHeight' => 58,       // Slider starting value (%)

            'defaultHeightPx' => 70,       // Default/Initial value (px)
            'maxAllowedHeightPx' => 120,    // value in pixel
        ],
        'featureImage' => [
            'sliderMin' => 30,          // Slider Minimum value (%)
            'sliderMax' => 100,         // Slider Max value (%)

            'sliderDefault' => 95,       // Slider starting value (%)

            'sliderDefaultPx' => 469,       // Default/Initial value (px)
            'maxAllowedWidthPx' => 469,    // value in pixel
        ],

    ],
    'default_top_level_domain' => env('DEFAULT_TLD', 'secure-clix.com'),
    'funnel_subdomain_postfix' => env('FUNNEL_SUBDOMAIN_POSTFIX', ''),
    'default_feature_image_name' => "blank.png",
];
