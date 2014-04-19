<?php

use \Subscription;

class SubscribeController extends BaseController {

	public function postSubscribe()
	{
		Subscription::create(array(
			'email' => Input::get('email'),
			'ip' => Request::getClientIp()
		));
		return Redirect::to('/')
			->with('success', 'You have been subscribed to out mailing list!');
	}

}