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
$found = FALSE;
foreach ($languages as $ids => $language)
{
    if ($locale == $language['slug'])
    {
        App::setLocale($locale);
        $found = TRUE;
    }
}
if (!$found)
{
    $locale = 'en';
}
App::setLocale($locale);

// You repeat routes in the group and outside, to play nice with the prefix language in the URL

Route::group(array('prefix' => $locale), function()
{
    // Main app
    Route::get('/', 'ExpressionController@getNew');
    Route::get('/new', 'ExpressionController@getNew');
    Route::get('/top', 'ExpressionController@getTop');
    Route::get('/random', 'ExpressionController@getRandom');
    Route::get('/thankyou', 'ExpressionController@getThankYou');
    Route::controller('/expression', 'ExpressionController');
    Route::get('/search', 'SearchController@getSearch');
    Route::get('/recreateSearchIndex', 'SearchController@recreateSearchIndex');
});

// Main app
Route::get('/', 'ExpressionController@getNew');
Route::get('/new', 'ExpressionController@getNew');
Route::get('/top', 'ExpressionController@getTop');
Route::get('/random', 'ExpressionController@getRandom');
Route::get('/thankyou', 'ExpressionController@getThankYou');
Route::controller('/expression', 'ExpressionController');
Route::get('/search', 'SearchController@getSearch');
Route::get('/recreateSearchIndex', 'SearchController@recreateSearchIndex');

// Moderators
Route::get('/moderators/expressions/{definition_id}/approve', 'ModeratorController@approveExpression');
Route::get('/moderators/expressions/{definition_id}/reject', 'ModeratorController@rejectExpression');
Route::get('/moderators/pictures/{picture_id}/approve', 'ModeratorController@approvePicture');
Route::get('/moderators/pictures/{picture_id}/reject', 'ModeratorController@rejectPicture');
Route::get('/moderators/videos/{video_id}/approve', 'ModeratorController@approveVideo');
Route::get('/moderators/videos/{video_id}/reject', 'ModeratorController@rejectVideo');
Route::controller('/moderators', 'ModeratorController');
