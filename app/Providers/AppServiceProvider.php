<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\UrlGenerator;
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

    // public function boot()
    // {
    //     //
    // }


    public function boot(UrlGenerator $url)
    {
        $url->forceScheme('https');
        
    }
}

