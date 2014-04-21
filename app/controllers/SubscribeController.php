<?php

use \Subscription;

class SubscribeController extends BaseController {

	public function postSubscribe()
	{
		if (!Input::get('email'))
			return Redirect::to('/')
				->with('message', 'You have to provide a valid e-mail');
		Subscription::create(array(
			'email' => Input::get('email'),
			'ip' => Request::getClientIp()
		));
		return Redirect::to('/')
			->with('success', 'You have been subscribed to out mailing list!');
	}

}