<?php

namespace SLBR\Provides;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('SLBR\Repositories\ExpressionRepository', 'SLBR\Repositories\ExpressionRepositoryEloquent');
    }
}
