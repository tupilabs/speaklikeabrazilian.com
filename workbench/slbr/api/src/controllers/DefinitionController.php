<?php namespace Slbr\Api;

use \Controller;
use \App;
use \Definition;
use \DB;
use \Input;
use \Illuminate\Database\Query\Expression;

class DefinitionController extends \BaseController {

	public function getDefinitions($id) 
	{
		$definitions = Definition::where('expression_id', '=', $id)->get();
		if ($definitions->count() > 0)
		{
			return $definitions;
		}
		else
		{
			return array();
		}
	}

	public function getNewest()
	{
		$definitions = Definition::where('status', '=', 2)
			->orderBy('created_at', 'desc')
			->get();
		return $definitions;
	}

	public function getTop()
	{
		$definitions = Definition::where('status', '=', 2)
			->orderBy('created_at', 'desc')
			->get();
		return $definitions;
	}

	public function getRandom()
	{
		$definitions = Definition::where('status', '=', 2)
			->orderBy(DB::raw('RANDOM()'))
			->get();
		return $definitions;
	}

	public function getByLetter($letter)
	{
		$definitions = Definition::join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('expressions.char', '=', strtoupper($letter))
			->where('status', '=', 2)
			->get();
		return $definitions;
	}

	public function getByExpressionText() 
	{
		$text = Input::get('e');
		$definitions = Definition::join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower(htmlentities($text)))
			->where('status', '=', 2)
			->get();
		return $definitions;
	}

	public function postDefinition($id)
	{
		return Definition::create(array(
			'expression_id' => $id, 
			'description' => Input::get('description'),
			'example' => Input::get('example'),
			'tags' => Input::get('tags'),
			'status' => Input::get('status', 1),
			'email' => Input::get('email'),
			'contributor' => Input::get('contributor'),
			'moderator_id' => Input::get('moderator_id', NULL)
		));
	}

}