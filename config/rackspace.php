<?php

return [
    /*
    |--------------------------------------------------------------------------
    | RackSpace CDN Region
    |--------------------------------------------------------------------------
    |
    | A region is the area the service will operate and is required to communicate with RackSpace API
    | Possible values:
    |   DFW (Dallas-Fort Worth, TX, US)
    |   HKG (Hong Kong, China)
    |   IAD (Blacksburg, VA, US)
    |   LON (London, England)
    |   SYD (Sydney, Australia)
    */
    'region' => env('RS_REGION', 'ORD'),

    /*
    |--------------------------------------------------------------------------
    | RackSpace Username
    |--------------------------------------------------------------------------
    */
    'username' => env('RS_USERNAME', ''),

    /*
    |--------------------------------------------------------------------------
    | RackSpace API KEY
    |--------------------------------------------------------------------------
    | To view or reset your API key, use the following steps:
    |   Log in to the Cloud Control Panel.
    |   In the upper-right corner of the Cloud Control Panel, click your username and select My Profile & Settings.
    |   Scroll down to Security Settings.
    |   To view your API key, click the Show link next to Rackspace API Key. You can copy the API key from this screen.
    */
    'apiKey' => env('RS_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | RackSpace URL Type
    |--------------------------------------------------------------------------
    | urlType is the type of URL to use, depending on which endpoints your catalog provides.
    | If omitted, it will default to the public network
    | Possible values:
    |       - publicURL
    |       - internalURL
    */
    'urlType' => env('RS_URLTYPE', 'publicURL'),

    /*
    |--------------------------------------------------------------------------
    | Default Featured Image Directory
    |--------------------------------------------------------------------------
    | rs_featured_image_dir is the path of default featured image in default assets
    | container inside default directory
    */
    #'rs_featured_image_dir' => env('RS_FEATURED_IMAGE_DIR', 'stockimages/classicimages/'),
    'rs_featured_image_dir' => env('RS_FEATURED_IMAGE_DIR', 'stockimages/featured/'),

    /*
    |--------------------------------------------------------------------------
    | Default Stock Logo Directory
    |--------------------------------------------------------------------------
    | rs_stock_logo_dir is the path of default Logos in default assets
    | container inside default directory
    */
    'rs_stock_logo_dir' => env('RS_STOCK_IMAGE_DIR', 'stockimages/logos/'),
    # 'rs_stock_logo_dir' => env('RS_STOCK_IMAGE_DIR', 'images/'),
];
