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

use \User;

class UserController extends BaseController {

	public function getLogin()
	{
		$args = array();
		$args['from'] = Input::get('from');
		return $this->theme->scope('user.login', $args)->render();
	}

	public function postLogin()
	{
		try
		{
			$from = Input::get('from');
		    // Set login credentials
		    $credentials = array(
		        'email'    => Input::get('user'),
		        'password' => Input::get('password')
		    );

		    // Try to authenticate the user
    		$user = Sentry::authenticate($credentials, Input::get('remember-me' === 'remember-me'));

    		if ($from)
    			return Redirect::to($from);
    		return Redirect::to('/')->with('message', 'You are logged in');
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    return Redirect::to('/user/login?from=' . $from)->with('message', 'Login field is required.');
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return Redirect::to('/user/login?from=' . $from)->with('message', 'Password field is required.');
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			return Redirect::to('/user/login?from=' . $from)->with('message', 'Wrong password, try again.');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('/user/login?from=' . $from)->with('message', 'User was not found.');
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    return Redirect::to('/user/login?from=' . $from)->with('message', 'User is not activated.');
		}

		// The following is only required if throttle is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    return Redirect::to('/user/login?from=' . $from)->with('message', 'User is suspended.');
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    return Redirect::to('/user/login?from=' . $from)->with('message', 'User is banned.');
		}
	}

	public function getLogout()
	{
		Sentry::logout();
		return Redirect::to('/user/login')
			->with('success', 'You have been logged out');
	}

}