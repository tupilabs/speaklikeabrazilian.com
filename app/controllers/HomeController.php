<?php

class HomeController extends BaseController {

	public function getIndex()
	{
		$definitions = API::get('/api/v1/expressions/newest');
		$args = array();
		$args['definitions'] = $definitions;
		return $this->theme->scope('home.index', $args)->render();
	}

}