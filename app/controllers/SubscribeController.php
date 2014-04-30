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

use \Subscription;

class SubscribeController extends BaseController {

	public function postSubscribe()
	{
		if (!Input::get('email'))
			return Redirect::to('/')
				->with('message', 'You have to provide a valid e-mail');
		$existing = Subscription::where('email', '=', Input::get('email'))->count();
		if ($existing == 0)
		{
			Log::info('Yay! We got a new subscription from ' . Request::getClientIp());
			try 
			{
				$subscription = Subscription::create(array(
					'email' => Input::get('email'),
					'ip' => Request::getClientIp()
				));
				if ($subscription->isValid() && $subscription->isSaved())
				{
					$environment = App::environment();
					if ($environment == 'production')
					{
						Log::info('A new user is subscribed! Sending it to the mailing list server, under list ID ' . Config::get('mailchimp::list_id'));
						$r = MailchimpWrapper::lists()->subscribe(Config::get('mailchimp::list_id'), array('email' => Input::get('email')));
						Log::debug('MailChimp response: ' . var_export($r, true));
					}
					else
					{
						Log::info('Mailing list subscription enabled only in production. Current env: ' . $environment);
					}
				}
				else
				{
					Log::error('Error subscribing user: ' . var_export($subscription->errors(), true));
					return Redirect::to('/')
						->withInput()
						->withErrors($subscription->errors())
						->with('message', 'You have to provide a valid e-mail');
				}
			}
			catch (Exception $e)
			{
				Log::error('Internal error. Error subscribing user: ' . $e->getMessage());
				Log::error($e);
				return Redirect::to('/')
					->with('message', 'You have to provide a valid e-mail');
			}
		}
		else
		{
			Log::debug('User tried to subscribe twice to our mailing list. Yipie!');
		}
		
		return Redirect::to('/')
			->with('success', 'You have been subscribed to out mailing list!');
	}

}