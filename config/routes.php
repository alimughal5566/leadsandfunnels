<?php
/**
 * Created by PhpStorm.
 * User: Jazib
 * Date: 08/11/2020
 * Time: 02:36
 */


return [
    /*
    |--------------------------------------------------------------------------
    | Routes with Global Settings
    |--------------------------------------------------------------------------
    |
    | The routes listed here will be have global settings
    |
    */

    'globalSettings' => [
        "funnel-question",
        "calltoaction",
        "footeroption",
        "advance_footer",
        "privacypolicy",
        "termsofuse",
        "disclosures",
        "licensinginformation",
        "aboutus",
        "contactus",
        "autoresponder",
        "seo",
        "contact",
        "thankyou",
        "thankyoumessage",
        "logo",
        "dashboard",
        "statistics",
        "background",
        "featuredmedia",
        "pixels",
        "integration",
        "ada_accessibility",
        "tag",
        "contacts",
        "support",
        "my_profile",
        "createTcpaFromPage",
        "EditTcpaFromPage",
        "tcpaIndex",
        "SecurityMessagesIndex",
        "EditSecurityMessagesFromPage",
        "branding"
    ],

    'blueBarRoutes' => ['funnel-question', 'domain', 'statistics', 'myleads', "integration", "shareFunnel", "integrate", "support", "my_profile"],

    /*
    |--------------------------------------------------------------------------
    | Top Variation View
    |--------------------------------------------------------------------------
    |
    | This option determines Button settings for top naivation for each view
    |
    */

    'top_nav_view' => [
        "no_buttons" => [],
        "save_button_only" => ["save"],
        "preview_button_only" => ["view_funnels"],
        'variation0' => ["create_funnels", "global_settings", "save"],
        'variation1' => ["create_funnels", "global_settings"],
        'variation2' => ["create_funnels", "global_settings", "view_funnels", "save"],
        'variation3' => ["create_funnels", "view_funnels"],
        'variation4' => ["close", "view_funnels", "save"],
        'variation5' => ["global_settings","view_funnels"],
        'variation6' => ["create_funnels", "global_settings", "view_funnels"],
        'variation7' => ["view_funnels" ,"global_settings", "save"], // blue bar only
        'variation8' => ["create_funnels", "view_funnels", "save"],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes with Top variation Options
    |--------------------------------------------------------------------------
    |
    | In headerOptons, we have list of all named routes against each variations
    |
    */
    'headerOptions' => [
        "no_buttons" => ["hub", "hubdetail", "videos", "ticket","support"],
        "save_button_only" => ["my_profile"],
        "preview_button_only" => [],//from @mzac90
        "variation0" => ["account" ],
        "variation1" => ["dashboard"],
        "variation2" => [],     // Currently this is Default for all Screens except those which are defined in each varition index
        "variation3" => ["myleads","statistics","integration"],
        "variation4" => [],
        "variation5" => [],
        "variation6" => ["pixels", "contacts"],
        "variation7" => ['funnel-question'], // blue bar only // from @mzac90 remove myleads and statistics
        "variation8" => ["integrate","shareFunnel",'funnel-builder']
    ],

    /*
    |--------------------------------------------------------------------------
    | Top Variation Home - routes
    |--------------------------------------------------------------------------
    |
    | This option determines Home Button settings for top navigation for each view
    |
    */

    'top_nav_home' => [
        "my_profile",
        "videos",
        "ticket",
        "support"
    ],

    'sidebar_config' => [
        'edit' => [
            //Edit->Content
            'autoresponder', 'calltoaction', 'contact', 'advance_footer',
            'footeroption' => [
                'privacypolicy',
                'termsofuse',
                'disclosures',
                'licensinginformation',
                'aboutus',
                'contactus'
            ],
            'thankyou' => [
                'thankyoumessage'
            ],

            //Edit->Design
            'logo', 'background', 'featuredmedia',

            //Edit->Settings
            'ada_accessibility', 'contacts', 'pixels',
            'integration' => [
                'integrate'
            ],

            //Edit->Basic Info
            'domain', 'tag', 'seo'
        ],
        'promote' => [
            'shareFunnel'
        ]
    ]
];
