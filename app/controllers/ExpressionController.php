<?php

class ExpressionController extends BaseController {

	public function getAdd()
	{
		return $this->theme->scope('expression.add')->render();
	}

	public function getDefine()
	{
		$expression = Input::get('e');
		$definitions = API::get(sprintf('api/v1/definition?e=%s', $expression));
		$args = array();
		$args['definitions'] = $definitions;
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getLetter($letter)
	{
		$definitions = API::get(sprintf('api/v1/expressions/letters/%s', $letter));
		$args = array();
		$args['definitions'] = $definitions;
		return $this->theme->scope('home.index', $args)->render();
	}

}