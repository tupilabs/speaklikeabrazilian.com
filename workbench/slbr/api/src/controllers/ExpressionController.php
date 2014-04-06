<?php namespace Slbr\Api;

use \Controller;
use \App;
use \Expression;

class ExpressionController extends \BaseController {
	
	public function getExpression($id) 
	{
		$expression = Expression::find($id);
		if ($expression)
		{
			return $expression;
		}
		else
		{
			return App::abort(404);
		}
	}

}