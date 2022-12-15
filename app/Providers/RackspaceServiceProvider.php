<?php

namespace App\Providers;

use App\Services\RackspaceUploader;
use Illuminate\Support\ServiceProvider;

class RackspaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RackspaceUploader::class, function($app){
            return new RackspaceUploader();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
