<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Rating
Route::post('/rate', 'ExpressionController@postRate');
// Main app
Route::get('/', 'ExpressionController@getNew');
Route::get('/new', 'ExpressionController@getNew');
Route::get('/top', 'ExpressionController@getTop');
Route::get('/random', 'ExpressionController@getRandom');
Route::get('/expression/{id}/display_embedded', 'ExpressionController@displayEmbedded')->where('id', '[0-9]+');
Route::get('/expression/{id}/embed', 'ExpressionController@getEmbed')->where('id', '[0-9]+');
Route::get('/expression/{id}/share', 'ExpressionController@getShare')->where('id', '[0-9]+');
Route::post('/expression/{id}/share', 'ExpressionController@postShare')->where('id', '[0-9]+');
Route::controller('/expression', 'ExpressionController');
// Subscribe
Route::post('/subscribe', 'SubscribeController@postSubscribe');
// Links
Route::get('/links', 'LinksController@getLinks');

if (Config::get('database.log', false))
{           
    Event::listen('illuminate.query', function($query, $bindings, $time, $name)
    {
        $data = compact('bindings', 'time', 'name');

        // Format binding data for sql insertion
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
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings); 

        Log::info($query, $data);
    });
}