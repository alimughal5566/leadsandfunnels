<?php

if(isset($_GET['app_theme']) && $_GET['app_theme'] != "")
    $app_theme = $_GET['app_theme'];
else if(isset($_COOKIE['app_theme']) && $_COOKIE['app_theme'] != "")
    $app_theme = $_COOKIE['app_theme'];
else
    $app_theme = env('APP_THEME', 'theme_admin2');

return [
    /*
    |--------------------------------------------------------------------------
    | View Theme Directory
    |--------------------------------------------------------------------------
    |
    | Load all views from specified theme directory
    |
    */

    'theme' => $app_theme,
    'theme_assets' => env("constants.LP_ASSETS_PATH")."/".$app_theme,
    'rackspace_default_images' => env('constants.RACKSPACE_DEFAULT_IMAGES_URI', 'https://images.lp-images1.com/default/app'),

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views/'.$app_theme),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
