<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/addfunnelprocess.php',
        '/addfunnelprocess_mvp.php',
        '/addfunnelprocess_fairway.php',
        '/addfunnelprocess_baller.php',
        '/clonefunnelprocess_mvp_fix.php',
        '/clonefunnelprocess_mvp_movement_fix.php',
        '/clonefunnelprocess_mvp_fairway_fix.php',
        '/clonefunnelprocess_insurance_mvp_fix.php',
        '/clonefunnelprocess_mvp_baller_fix.php',
        '/clonefunnelprocess_realestate_mvp_fix.php',
        '/clonefunnelprocess_mvp_stearns_websites.php',
        '/api/homebot.php',
        '/add_missing_website_funnel_script.php',
        '/accountpause',
        '/accountcancellation',
        '/removeaccountcancellation'
    ];
}
