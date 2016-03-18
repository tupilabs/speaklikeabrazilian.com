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

Route::group(array('prefix' => $locale), function()
{
    // Main app
    Route::get('/', 'ExpressionController@getNew');
    Route::get('/new', 'ExpressionController@getNew');
});

Route::get('/', 'ExpressionController@getNew');
Route::get('/new', 'ExpressionController@getNew');
