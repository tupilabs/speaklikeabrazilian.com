<?php namespace Slbr\Api;

use \Controller;
use \App;
use \Expression;
use \Input;
use \Log;
use \Request;
use \Response;

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
		$q = Input::get('q');
		$json = '
		{
			"query": {
			    "multi_match": {
			        "query":                "'.$q.'",
			        "type":                 "best_fields", 
			        "fields":               [ "expression^3", "description^2", "example", "tags" ],
			        "tie_breaker":          0.3,
			        "minimum_should_match": "30%" 
			    }
		    },
		    "filter" : {
		        "term" : {"language_id":"1"}
		    }
		}
		'; // 1 is English // FIXME: constants

		$searchParams = array();
		$searchParams['index'] = 'slbr_index';
		$searchParams['size'] = 20;
		$searchParams['from'] = 0;
		$searchParams['body'] = $json;

		$hits = array();
		$total = 0;

		try
		{
			$result = \Es::search($searchParams);
			$hits = $result['hits'];
			$total = $hits['total'];
		} 
		catch (\Exception $e)
		{
			\Log::error('Search server error: ' . $e->getMessage());
		}

		$ids = array();
		if (isset($hits['hits']))
		{
			foreach ($hits['hits'] as $hit)
			{
				$ids[] = $hit['_id'];
			}
		}

		if (empty($ids))
		{
			$definitions = array();
		}
		else
		{
			$definitions = \Definition::
				join('expressions', 'definitions.expression_id', '=', 'expressions.id')
				->where('status', '=', 2)
				->where('language_id', '=', '1')
				->whereIn('definitions.id', $ids)
				->orderBy('created_at', 'desc')
				->select('definitions.*', 
					'expressions.text',
					new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
					new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
					)
				->get();
		}

		return Response::json($definitions)->setCallback(Input::get('callback'));
	}

	public function findByDefinitionId()
	{
		$definitionId = Input::get('definitionId');
		if (!$definitionId)
		{
			return Response::json(NULL);
		}
		$expression = Expression::
			join('definitions', 'expressions.id', '=', 'definitions.expression_id')
			->where('definitions.id', '=', $definitionId)
			->select('expressions.*')
			->get();
		return (count($expression) == 0 ? Response::json(NULL) : $expression[0]);
	}

}