<?php namespace Slbr\Api;

use \Controller;
use \App;
use \Definition;
use \DB;
use \Input;
use \Illuminate\Database\Query\Expression;
use \Log;
use \Request;
use \Rating;
use \Response;

class DefinitionController extends \BaseController {

	public function getDefinitions($id) 
	{
		$definitions = Definition::with('expression', 'rating')
			->where('expression_id', '=', $id)->get();
		if ($definitions->count() > 0)
		{
			return $definitions;
		}
		else
		{
			return array();
		}
	}

	public function getDefinition($expressionId, $definitionId)
	{
		$definition = Definition::with('expression', 'ratings')
			->where('status', '=', 2)
			->where('expression_id', $expressionId)
			->where('id', $definitionId)
			->first();
		return Response::json($definition);
	}

	public function getNewest()
	{
		$definitions = Definition::with('expression', 'ratings')
			->where('status', '=', 2)
			->orderBy('created_at', 'desc')
			->get();
		return $definitions;
	}

	public function getTop()
	{
		$definitions = Definition::with('expression', 'ratings')
			->where('status', '=', 2)
			->get();
		$definitions->sortBy(function($definition){
			$ratings = $definition->ratings();
			$rate = 0;
			foreach ($ratings as $rating) 
			{
				$rate += $rating->rating;
			}
			Log::debug(sprintf("RATE: %s", $rate));
			return $rate;
		});
		return $definitions->reverse();
	}

	public function getRandom()
	{
		$definitions = Definition::with('expression', 'ratings')
			->where('status', '=', 2)
			->orderBy(DB::raw('RANDOM()'))
			->get();
		return $definitions;
	}

	public function getByLetter($letter)
	{
		$definitions = Definition::with('expression', 'ratings')
			->join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('expressions.char', '=', strtoupper($letter))
			->where('status', '=', 2)
			->select('definitions.*')
			->get();
		return $definitions;
	}

	public function getByExpressionText() 
	{
		$text = Input::get('e');
		$definitions = Definition::with('expression', 'ratings')
			->join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower(htmlentities($text)))
			->where('status', '=', 2)
			->select('definitions.*')
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

	public function postRate($expressionId, $definitionId)
	{
		Log::debug(sprintf('User %s rated definition %d with %d', 
			Request::getClientIp(),
			$definitionId,
			Input::get('rating')
		));

		// Check if user already voted up this expression
		$count = Rating::where('definition_id', '=', $definitionId)
			->where('user_ip', Request::getClientIp())
			->where('rating', Input::get('rating'))
			->count();
		if ($count > 0)
		{
			return Response::json(array('msg' => 'You cannot repeat your vote'));
		}

		// Try to update previous vote
		$rating = Rating::where('definition_id', '=', $definitionId)
			->where('user_ip', Request::getClientIp())->first();

		if ($rating) 
		{
			$rating->rating = Input::get('rating');
			$rating->save();
			return Response::json(array('msg' => 'OK', 'balance' => true));
		}

		Rating::create(array(
			'definition_id' => $definitionId,
			'rating' => Input::get('rating'),
			'user_ip' => Request::getClientIp()
		));
		
		return Response::json(array('msg' => 'OK'));
	}

}