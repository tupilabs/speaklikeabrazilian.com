<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2014 TupiLabs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use \Definition;

class ModeratorController extends BaseController {

	public function getModerators()
	{
		if (!Sentry::check()){
			return Redirect::to('user/login?from=moderators');
		}
		return $this->theme->scope('moderators.home')->render();
	}

	// expressions

	public function getPendingExpressions()
	{
		$definition = Definition::with('expression', 'ratings')
			->where('definitions.status', '=', 1)
			->orderByRaw((Config::get('database.default') =='mysql' ? 'RAND()' : 'RANDOM()'))
			->first();
		$args = array();
		$args['definition'] = $definition;
		return $this->theme->scope('moderators.pendingExpressions', $args)->render();
	}

	public function approveExpression()
	{
		$definitionId = Input::get('definitionId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s approved definition %d', $user->id, $definitionId));
		$definition = Definition::where('id', '=', $definitionId)->firstOrFail();
		$definition->status = 2;
		$definition->save();
		return Redirect::to('/moderators/pendingExpressions')
			->with('success', 'Definition approved!');
	}

	public function rejectExpression()
	{
		$definitionId = Input::get('definitionId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s rejected definition %d', $user->id, $definitionId));
		$definition = Definition::where('id', '=', $definitionId)->firstOrFail();
		$definition->status = 3;
		$definition->save();
		return Redirect::to('/moderators/pendingExpressions')
			->with('success', 'Definition rejected!');
	}

	// videos

	public function getPendingVideos()
	{
		$media = Media::where('medias.status', '=', 1)
			->where('content_type', '=', 'video/youtube')
			->orderByRaw((Config::get('database.default') =='mysql' ? 'RAND()' : 'RANDOM()'))
			->first();
		$args = array();
		if ($media) 
		{
			$args['url'] = $media->url;
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media->url, $match))
			{
				$args['video_id'] = $match[1];
			}
			if (preg_match('%(?:t=)([0-9]+)%i', $media->url, $match)) 
			{
				$args['t'] = $match[1];
			}
		}
		$args['media'] = $media;
		return $this->theme->scope('moderators.pendingVideos', $args)->render();
	}

	public function approveVideo()
	{
		$mediaId = Input::get('mediaId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s approved video %d', $user->id, $mediaId));
		$video = Media::where('id', '=', $mediaId)->firstOrFail();
		$video->status = 2;
		$video->save();
		return Redirect::to('/moderators/pendingVideos')
			->with('success', 'Video approved!');
	}

	public function rejectVideo()
	{
		$mediaId = Input::get('mediaId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s rejected video %d', $user->id, $mediaId));
		$video = Media::where('id', '=', $mediaId)->firstOrFail();
		$video->status = 3;
		$video->save();
		return Redirect::to('/moderators/pendingVideos')
			->with('success', 'Video rejected!');
	}

	// Pictures

	public function getPendingPictures()
	{
		$media = Media::where('medias.status', '=', 1)
			->where('content_type', '=', 'image/unknown')
			->orderByRaw((Config::get('database.default') =='mysql' ? 'RAND()' : 'RANDOM()'))
			->first();
		$args = array();
		$args['media'] = $media;
		return $this->theme->scope('moderators.pendingPictures', $args)->render();
	}

	public function approvePicture()
	{
		$mediaId = Input::get('mediaId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s approved picture %d', $user->id, $mediaId));
		$video = Media::where('id', '=', $mediaId)->firstOrFail();
		$video->status = 2;
		$video->save();
		return Redirect::to('/moderators/pendingPictures')
			->with('success', 'Picture approved!');
	}

	public function rejectPicture()
	{
		$mediaId = Input::get('mediaId');
		$user = Sentry::getUser();
		Log::info(sprintf('User %s rejected picture %d', $user->id, $mediaId));
		$video = Media::where('id', '=', $mediaId)->firstOrFail();
		$video->status = 3;
		$video->save();
		return Redirect::to('/moderators/pendingPictures')
			->with('success', 'Picture rejected!');
	}

	public function getProfile()
	{
		$user = Sentry::getUser();
		$args = array();
		$args['user'] = $user;
		return $this->theme->scope('moderators.profile', $args)->render();
	}

	public function postProfile()
	{
		$lang = App::getLocale();
		$save = FALSE;
		$user = Sentry::getUser();
		Log::debug(sprintf('Moderator %d is updating its profile...', $user->id));

		$user->email = Input::get('email');
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');

		$password = Input::get('password');
		$confirm = Input::get('password_confirm');

		if ($password) 
		{
			if (0 ===strcmp($password, $confirm))
			{
				Log::debug('Setting new password');
				$user->password = $password;
			} 
			else
			{
				Log::debug("Passwords don't match");
				return Redirect::to(URL::current())
					->withInput()
					->with('message', "Passwords don't match");
			}
		}

		try 
		{
			Log::debug('Saving moderator profile');
			if ($user->save())
			{
				Log::info(sprintf("Moderator %d updated its profile successfully!", $user->id));
				return Redirect::to("$lang/moderators/")
					->with('success', "Profile updated!");
			}
			else
			{
				Log::debug("Failed to save moderator.");
				return Redirect::to(URL::current())
					->withInput()
					->with('message', "Failed to save user");
			}
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
	    {	
	    	Log::debug("User with this login already exists.");
	        return Redirect::to(URL::current())
				->withInput()
				->with('message', "User with this login already exists.");
	    }
	    catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	    {
	    	Log::debug("User was not found.");
	        return Redirect::to(URL::current())
				->withInput()
				->with('message', "User was not found.");
	    }
	}

}