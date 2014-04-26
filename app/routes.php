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

// Route::get('set-language/{lang}', array('as' => 'set-language', function($lang) {
    
//     if( in_array($lang, Config::get('app.languages')) )
//     {
//         Log::debug('Changing language to ' . $lang);
//         App::setLocale($lang);
//         Session::set('locale', $lang);
//         return Redirect::to(URL::previous());
//     }
// }));

$languages = Config::get('app.languages');
$locale = Request::segment(1);
if(in_array($locale, $languages)){
    Cookie::forever('slbr_language', $locale); // TODO: put in session too?
    App::setLocale($locale);
}else{
    $locale = null;
}
Route::group(array('prefix' => $locale), function()
{
    // Users
    Route::get('/user/login', 'UserController@getLogin');
    Route::post('/user/login', 'UserController@postLogin');
    Route::get('/user/logout', 'UserController@getLogout');
    // Moderators
    Route::filter('moderators', function() {
        if (!Sentry::check())
        {
            return Redirect::to('user/login?from=moderators')
                ->with('message', 'Log in first');
        }
        $user = Sentry::getUser();
        if (!$user->hasAccess('moderator'))
        {
            return Redirect::to('user/login?from=moderators')
                ->with('message', 'Log in first');
        }
    });
    Route::when('moderators/*', 'moderators');
    Route::get('moderators', 'ModeratorController@getModerators');
    Route::get('moderators/pendingExpressions', 'ModeratorController@getPendingExpressions');
    Route::post('moderators/approveExpression', 'ModeratorController@approveExpression');
    Route::post('moderators/rejectExpression', 'ModeratorController@rejectExpression');
    Route::get('moderators/pendingVideos', 'ModeratorController@getPendingVideos');
    Route::post('moderators/approveVideo', 'ModeratorController@approveVideo');
    Route::post('moderators/rejectVideo', 'ModeratorController@rejectVideo');
    Route::get('moderators/pendingPictures', 'ModeratorController@getPendingPictures');
    Route::post('moderators/approvePicture', 'ModeratorController@approvePicture');
    Route::post('moderators/rejectPicture', 'ModeratorController@rejectPicture');
    // Rating
    Route::post('/rate', 'ExpressionController@postRate');
    // Main app
    Route::get('/', 'ExpressionController@getNew');
    Route::get('/new', 'ExpressionController@getNew');
    Route::get('/top', 'ExpressionController@getTop');
    Route::get('/random', 'ExpressionController@getRandom');
    Route::get('/expression/{id}/videos', 'ExpressionController@getVideos')->where('id', '[0-9]+');
    Route::post('/expression/{id}/videos', 'ExpressionController@postVideos')->where('id', '[0-9]+');
    Route::get('/expression/{id}/pictures', 'ExpressionController@getPictures')->where('id', '[0-9]+');
    Route::post('/expression/{id}/pictures', 'ExpressionController@postPictures')->where('id', '[0-9]+');
    Route::controller('/expression', 'ExpressionController');
    // Subscribe
    Route::post('/subscribe', 'SubscribeController@postSubscribe');
    // Links
    Route::get('/links', 'LinksController@getLinks');
});

// Users
Route::get('/user/login', 'UserController@getLogin');
Route::post('/user/login', 'UserController@postLogin');
Route::get('/user/logout', 'UserController@getLogout');
// Moderators
Route::filter('moderators', function() {
    if (!Sentry::check())
    {
        return Redirect::to('user/login?from=moderators')
            ->with('message', 'Log in first');
    }
    $user = Sentry::getUser();
    if (!$user->hasAccess('moderator'))
    {
        return Redirect::to('user/login?from=moderators')
            ->with('message', 'Log in first');
    }
});
Route::when('moderators/*', 'moderators');
Route::get('moderators', 'ModeratorController@getModerators');
Route::get('moderators/pendingExpressions', 'ModeratorController@getPendingExpressions');
Route::post('moderators/approveExpression', 'ModeratorController@approveExpression');
Route::post('moderators/rejectExpression', 'ModeratorController@rejectExpression');
Route::get('moderators/pendingVideos', 'ModeratorController@getPendingVideos');
Route::post('moderators/approveVideo', 'ModeratorController@approveVideo');
Route::post('moderators/rejectVideo', 'ModeratorController@rejectVideo');
Route::get('moderators/pendingPictures', 'ModeratorController@getPendingPictures');
Route::post('moderators/approvePicture', 'ModeratorController@approvePicture');
Route::post('moderators/rejectPicture', 'ModeratorController@rejectPicture');
// Rating
Route::post('/rate', 'ExpressionController@postRate');
// Main app
Route::get('/', 'ExpressionController@getNew');
Route::get('/new', 'ExpressionController@getNew');
Route::get('/top', 'ExpressionController@getTop');
Route::get('/random', 'ExpressionController@getRandom');
Route::get('/expression/{id}/display_embedded', 'ExpressionController@displayEmbedded')->where('id', '[0-9]+');
Route::get('/expression/{id}/embed', 'ExpressionController@getEmbed')->where('id', '[0-9]+');
Route::get('/expression/{id}/videos', 'ExpressionController@getVideos')->where('id', '[0-9]+');
Route::post('/expression/{id}/videos', 'ExpressionController@postVideos')->where('id', '[0-9]+');
Route::get('/expression/{id}/pictures', 'ExpressionController@getPictures')->where('id', '[0-9]+');
Route::post('/expression/{id}/pictures', 'ExpressionController@postPictures')->where('id', '[0-9]+');
Route::controller('/expression', 'ExpressionController');
Route::get('/search', 'ExpressionController@search');
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