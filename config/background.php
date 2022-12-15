<?php
/**
 * Created by PhpStorm.
 * User: mzac90
 * Date: 05/03/2021
 * Time: 16:05
 */

return [

    'color_option' => [
        'mode_rgb' => 'rgb',
        'mode_hex' => 'hex',
        'pull_logo_color' => 1,
        'customize_own_color' => 2,
        'upload_background_image' => 3,
    ],
    'background_position' =>  [
        'background_repeat_select_list' => [
        array('title'=>'No Repeat', 'value'=>'no-repeat'),
        array('title'=>'Repeat', 'value'=>'repeat'),
        array('title'=>'Repeat-X', 'value'=>'repeat-x'),
        array('title'=>'Repeat-Y', 'value'=>'repeat-y')
        ],
        'background_position_select_list' => [
            array('title'=>'Center Center', 'value'=>'center center'),
            array('title'=>'Center Left', 'value'=>'center left'),
            array('title'=>'Center Right', 'value'=>'center right'),
            array('title'=>'Top Center', 'value'=>'top center'),
            array('title'=>'Top Left', 'value'=>'top left'),
            array('title'=>'Top Right', 'value'=>'top right'),
            array('title'=>'Bottom Center', 'value'=>'bottom center'),
            array('title'=>'Bottom Left', 'value'=>'bottom left'),
            array('title'=>'Bottom Right', 'value'=>'bottom right')
        ],
        'background_size_select_list' => [
            array('title'=>'Cover', 'value'=>'cover'),
            array('title'=>'Contain', 'value'=>'contain'),
            array('title'=>'Default', 'value'=>'auto'),
        ]
     ],
    'background_tabs' => [
        ["tab"=>"Main", "href"=>"#main", "active"=>true],
        ["tab"=>"Funnel", "href"=>"#funnel", "disabled"=>true ]
    ]
];
