<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach($_ENV AS $varname=>$val){
            if(strpos($varname, "constants.") !== false) {
                define(str_replace("constants.", "", $varname), $val);
            }
        }

        if(getenv('APP_ENV') != config('app.env_local')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
