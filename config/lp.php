<?php
/**
 * Created by PhpStorm.
 * User: haroon
 * Date: 23/07/2020
 * Time: 16:05
 */



return [

    'launch_status' => [
        'not_password_nor_launchscreen' => 0,
        'password_only' => 1,
        'both_password_and_launchscreen' => 2
    ],

    'chargebee' => [
        'lp_api_endpoint_base_url' => "http://hooks.leadpops.com",
        'lp_api_endpoint_auth_key' => 12345
    ],

    'pro_package_price' => [
        'thrive_pro' => '79',
        'aime_pro' => '147',
        'movement_pro' => '79',
        'mortgage_pro' => '187',
        'fairway_lite_pro' => '49',
        'fairway_pro' => '79',
        'c2_pro' => '89'
    ],
    'stats_graph_steps' => [
        '5' => 1,
        '10' => 2,
        '15' => 3,
        '20' => 4,
        '25' => 5,
        '30' => 6,
        '35' => 7,
        '40' => 8,
        '45' => 9,
        '50' => 10,
        '55' => 11,
        '60' => 12,
        '65' => 13,
        '70' => 14,
        '75' => 15,
        '80' => 16,
        '85' => 17,
        '90' => 18,
        '95' => 19,
        '100' => 20,
        '105' => 21,
        '110' => 22,
        '115' => 23,
        '120' => 24,
        '125' => 25,
        '130' => 26,
        '135' => 27,
        '140' => 28,
        '145' => 29,
        '150' => 30,
        '155' => 31,
        '160' => 32,
        '165' => 33,
        '170' => 34,
        '175' => 35,
        '180' => 36,
        '185' => 37,
        '190' => 38,
        '195' => 39,
        '200' => 40,
        '205' => 41,
        '210' => 42,
        '215' => 43,
        '220' => 44,
        '225' => 45,
        '230' => 46,
        '235' => 47,
        '240' => 48,
        '245' => 49,
        '250' => 50,
        '375' => 75,
        '500' => 100,
        '750' => 150,
        '1000' => 200,
        '1250' => 250,
        '1500' => 300,
        '1750' => 350,
        '2000' => 400,
    ],

    'leadpop_background_types' => [
        'BACKGROUND_IMAGE' => 3,
        'OWN_COLOR' => 2,   // Not sure this is 2 or what but currently setting it 2
        'LOGO_COLOR' => 1,
    ],

    'gm' => [
    ],

//    For screens in which we have tabs in header
    'actions_having_tabs' =>[
        'App\Http\Controllers\DesignController@backgroundAction',
        'App\Http\Controllers\ContentController@calltoactionAction'
    ],
    'my_website_text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. At aut autem consequuntur eligendi illum non nostrum nulla porro praesentium sit. Ab alias aperiam, consequuntur deleniti ea iure nostrum recusandae. Tempore.',
    'conversion_rate' => env('CONVERSION_RATE', '60'),
    'funnel_visitor' => env('FUNNEL_VISITOR', '5'),
    'funnel_clone_limit' => env('FUNNEL_CLONE_LIMIT', '2'),
    'cta_enable_new_feature' => env('SHOW_NEW_FEATURE',0),

    'cta_button_show_super_footer' =>  [
        'footeroption',
        'global_settings',
//        'autoresponder',
//        'thankyoumessage',
        'advance_footer'
    ],

    'froala_editor' => [
        'froala_editor_key' =>  env('FROALA_VERSION_KEY','yDC5hF4I4C10A8D7E4gKTRe1CD1PGb1DESAb1Kd1EBH1Pd1TKoD6C5G5C4G2D3J4B4D6A5=='),
        'froala_editor_version' => env('FROALA_VERSION',2),
    ],

    'sidebar-off-page' => [
        'funnel-question.php',
        'new-transition.php',
        'fb-zip-code.php',
        'fb-menu.php',
        'fb-slider.php',
        'fb-text-field.php',
        'fb-drop-down.php',
        'fb-cta-message.php',
        'fb-date-birthday.php',
        'fb-list-of-states.php',
        'fb-vehicle-modal-make.php',
        'sticky-bar.php',
        'funnel-builder'
    ],
    'branding_file_dimension' => [
      'width' => 70,
      'height' => 70
    ],

    "security_message" => [
        "defaults" =>[
            "icon" => [
                "enabled" => false,
                "icon" =>  "ico ico-shield-2",
                "color" => '#24b928',
                "position" => 'Left Align',
                "size" => '28'
            ],
            "tcpa_text_style"=> [
                "is_bold" => false,
                "is_italic" => false,
                "color" => '#b4bbbc'
            ],
            "tcpa_text" => 'Privacy & Security Guaranteed',
            "tcpa_title" => 'Security Message'
        ]
    ],

    "tcpa_message" => [
        "defaults" =>[
            "tcpa_checkbox" => 1,
            "tcpa_title" => 'Default TCPA Message',
            "tcpa_text" => 'By clicking on “Submit” button, I verify this is my email address and consent to receive email messages via automated technology.',
            "is_required_ckb" => 0,
        ]
    ]
];
