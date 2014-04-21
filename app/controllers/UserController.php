<?php

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