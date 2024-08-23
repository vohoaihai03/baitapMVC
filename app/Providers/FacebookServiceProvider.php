<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Facebook\Facebook;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Facebook::class, function ($app) {
            return new Facebook([
                'app_id' => config('facebook.app_id'),
                'app_secret' => config('facebook.app_secret'),
                'default_graph_version' => config('facebook.default_graph_version'),
            ]);
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
