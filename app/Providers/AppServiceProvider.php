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
        if (\Config::get('database.log', false))
        {
            DB::listen(function($queryObj) 
            {

                $bindings = $queryObj->bindings;
                foreach ($bindings as $i => $binding)
                {   
                    if ($binding instanceof \DateTime)
                    {   
                        $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    }
                    else if (is_string($binding))
                    {   
                        $bindings[$i] = "'$binding'";
                    }   
                } 
                // Insert bindings into query
                $query = $queryObj->sql;
                $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
                $query = vsprintf($query, $bindings); 

                Log::debug($query);
            });
        }
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
