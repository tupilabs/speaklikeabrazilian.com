<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Retrieve languages from database
// TODO: cache
$languages = \SLBR\Models\Language::all()->toArray();
$locale = Request::segment(1);
if(in_array($locale, $languages))
{
    App::setLocale($locale);
}
else
{
    $locale = 'en';
    App::setLocale($locale);
}

// You repeat routes in the group and outside, to play nice with the prefix language in the URL

Route::group(array('prefix' => $locale), function()
{
    // Main app
    Route::get('/', 'ExpressionController@getNew');
    Route::get('/new', 'ExpressionController@getNew');
    Route::get('/top', 'ExpressionController@getTop');
    Route::get('/random', 'ExpressionController@getRandom');
    Route::controller('/expression', 'ExpressionController');
});

// Main app
Route::get('/', 'ExpressionController@getNew');
Route::get('/new', 'ExpressionController@getNew');
Route::get('/top', 'ExpressionController@getTop');
Route::get('/random', 'ExpressionController@getRandom');
Route::controller('/expression', 'ExpressionController');
