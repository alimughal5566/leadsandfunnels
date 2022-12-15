<?php

/**
 * Configurations related to chargebee
 */

return [
    // Map for default fallback plans and prices baased on client type
    // Prices are in cents because chargebee sends prices in cents also
    // we convert them back to dollars prior to rendering

    // It is of the form default_plan_map[VerticalName][ClientType] ==> DefaultPlanAndPriceMap
    // DefaultPlanAndPriceMap['plan']  ==> DefaultPlan
    // DefaultPlanAndPriceMap['prices'] ==> DefaultPrices
    // DefaultPrices[PlanType] ==> Price
    'default_plan_map' => [
        'mortgage' => [
            'Default' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ],
            'AIME' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ],
            'BAB' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ],
            'Ballers' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ],
            'Fairway' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ],
            'Movement' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ],
            'Thrive' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ],
            'C2' => [
                'plan' => 'mortgage-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ]
        ],

        'real_estate' => [
            'Default' => [
                'plan' => 'real-estate-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ]
        ],

        'insurance' => [
            'Default' => [
                'plan' => 'insurance-funnels-"marketer"-plan',
                'prices' => [
                    'marketer' => 9700,
                    'pro' => 19700,
                    'pro_yearly' => 212700
                ]
            ]
        ]
    ],

    // Map between marketer and pro plan
    // it is of the form plan_upgrade_map[ClientType][CurrentMarketerPlan][period] ==> UpgradeProPlan
    'plan_upgrade_map' => [
        'Default' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ],
        'AIME' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ],
        'BAB' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ],
        'Ballers' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ],
        'Fairway' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ],
        'Movement' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ],
        'Thrive' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ],
        'C2' => [
            'mortgage-funnels-"marketer"-plan' => [
                'monthly' => 'mortgage-funnels-"pro"-plan',
                'yearly' => 'leadpops-marketer-pro-annual-plan'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Branding Plan IDs
    |--------------------------------------------------------------------------
    |
    | This key holds all the Plans available for Branding (Monthly OR Yearly)
    |
    | Plans change be changed anytime from this config settings
    |
    */
    'branding_plan_ids' => ['branding-monthly','branding-yearly'],

];
