<?php

namespace SLBR\Providers;

use DB;
use Log;
use Blade;
use URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function($query) {
            //Log::debug($query->sql);
            Log::debug($query->sql);
            Log::debug($query->bindings);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
