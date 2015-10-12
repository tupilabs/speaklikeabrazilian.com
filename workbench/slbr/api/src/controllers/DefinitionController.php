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
		/*$definitions = Definition::with('expression', 'rating')
			->where('expression_id', '=', $id)->get();
		if ($definitions->count() > 0)
		{
			return $definitions;
		}
		else
		{
			return array();
		}*/
		return App::abort(403);
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
		/*$definitions = Definition::with('expression', 'ratings')
			->where('status', '=', 2)
			->orderBy('created_at', 'desc')
			->get();
		return $definitions;*/
		return App::abort(403);
	}

	public function getTop()
	{
		/*$definitions = Definition::with('expression', 'ratings')
			->where('status', '=', 2)
			->get();
		$definitions->sortBy(function($definition){
			$ratings = $definition->ratings()->get();
			$rate = 0;
			foreach ($ratings as $rating) 
			{
				$rate += $rating->rating;
			}
			//Log::debug(sprintf("RATE: %s", $rate));
			return $rate;
		});
		return $definitions->reverse();*/
		return App::abort(403);
	}

	public function getRandom()
	{
		$lang = App::getLocale();
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->where('language_id', '=', \Config::get("constants.$lang", \Config::get('constants.en', 1)))
			->select('definitions.created_at',
				'definitions.description',
				'definitions.contributor',
				'definitions.example',
				'definitions.expression_id',
				'definitions.id',
				'definitions.language_id',
				'definitions.status',
				'definitions.tags',
				'definitions.updated_at',
				'definitions.created_at',
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->orderByRaw((\Config::get('database.default') =='mysql' ? 'RAND()' : 'RANDOM()'))
			->take(10)
			->get();
		return Response::json($definitions)->setCallback(Input::get('callback'));
	}

	public function getByLetter($letter)
	{
		/*$definitions = Definition::with('expression', 'ratings')
			->join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('expressions.char', '=', strtoupper($letter))
			->where('status', '=', 2)
			->select('definitions.*')
			->get();*/
		//return $definitions;
		return App::abort(403);
	}

	public function getByExpressionText() 
	{
		/*$text = Input::get('e');
		$definitions = Definition::with('expression', 'ratings')
			->join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower(htmlentities($text)))
			->where('status', '=', 2)
			->select('definitions.*')
			->get();
		return $definitions;*/
		return App::abort(403);
	}

	public function postDefinition($id)
	{
		/*return Definition::create(array(
			'expression_id' => $id, 
			'description' => Input::get('description'),
			'example' => Input::get('example'),
			'tags' => Input::get('tags'),
			'status' => Input::get('status', 1),
			'email' => Input::get('email'),
			'contributor' => Input::get('contributor'),
			'moderator_id' => Input::get('moderator_id', NULL)
		));*/
		return App::abort(403);
	}

	public function postRate($expressionId, $definitionId)
	{
		$userIp = Input::get('user_ip');
		if (!isset($userIp) || !$userIp) {
			$userIp = Request::getClientIp();
		}
		Log::debug(sprintf('User %s rated definition %d with %d', 
			$userIp,
			$definitionId,
			Input::get('rating')
		));

		// Check if user already voted up this expression
		$count = Rating::where('definition_id', '=', $definitionId)
			->where('user_ip', $userIp)
			->where('rating', Input::get('rating'))
			->count();
		if ($count > 0)
		{
			return Response::json(array('msg' => 'You cannot repeat your vote'));
		}

		// Try to update previous vote
		$rating = Rating::where('definition_id', '=', $definitionId)
			->where('user_ip', $userIp)->first();

		if ($rating) 
		{
			$rating->rating = Input::get('rating');
			$rating->save();
			return Response::json(array('msg' => 'OK', 'balance' => true));
		}

		Rating::create(array(
			'definition_id' => $definitionId,
			'rating' => Input::get('rating'),
			'user_ip' => $userIp
		));
		
		return Response::json(array('msg' => 'OK'));
	}

}