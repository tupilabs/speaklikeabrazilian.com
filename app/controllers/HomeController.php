<?php

class HomeController extends BaseController {

	public function getIndex()
	{
		$definitions = API::get('/api/v1/expressions/newest');
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = "New expressions";
		return $this->theme->scope('home.index', $args)->render();
	}

}