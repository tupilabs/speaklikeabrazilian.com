<?php namespace Slbr\Api;

use \Controller;
use \App;
use \Expression;
use \Input;
use \Log;
use \Request;

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

	public function postExpression()
	{
		return Expression::create(array(
			'text' => Input::get('text'),
			'char' => Input::get('char'),
			'contributor' => Input::get('contributor'),
			'moderator_id' => NULL
		));
	}

	public function searchByText()
	{
		$text = Input::get('e');
		if (!$text)
		{
			return array();
		}
		$expressions = Expression::where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower($text))
			->get();

		return $expressions;
	}

}