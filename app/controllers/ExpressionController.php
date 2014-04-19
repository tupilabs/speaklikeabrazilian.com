<?php

class ExpressionController extends BaseController {

	public function getNew()
	{
		$definitions = API::get('/api/v1/expressions/newest');
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = "New expressions";
		$this->theme->set('active', 'new');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getDefine()
	{
		$expression = Input::get('e');
		$definitions = API::get(sprintf('api/v1/definition?e=%s', $expression));
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = sprintf("Definitions of '%s'", $expression);
		$args['expression'] = $expression;
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getLetter($letter)
	{
		$definitions = API::get(sprintf('api/v1/expressions/letters/%s', $letter));
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = sprintf("Expressions starting with '%s'", strtoupper($letter));
		$letter = strtoupper($letter);
		$args['letter'] = $letter;
		$this->theme->set('active', $letter);
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getAdd()
	{
		$expression = Input::get('e');
		$args = array();
		if (isset($expression) && strlen($expression) > 0)
			$args['expression'] = ucfirst($expression);
		return $this->theme->scope('expression.add', $args)->render();
	}

	public function postAdd()
	{
		Log::debug('Starting transaction to add new expression');
		DB::beginTransaction();

		try 
		{
			// Get existing expressions
			$expression = API::get(sprintf('api/v1/expressions/search?e=%s', Input::get('text')));
			if (count($expression) <= 0)
			{
				$expression = API::post('api/v1/expressions/', array(
					'text' => Input::get('text'),
					'char' => strtoupper(substr(Input::get('text'), 0, 1)),
					'contributor' => Input::get('pseudonym')
				));

				if (!$expression->isValid() || !$expression->isSaved())
				{
					return Redirect::to('expression/add')
						->withInput()
						->withErrors($expression->errors());
				}
			}

			$definition = API::post(sprintf('api/v1/expressions/%d/definitions', $expression->id), array(
				'description' => Input::get('definition'),
				'example' => Input::get('example'),
				'tags' => Input::get('tags'),
				'status' => 1,
				'email' => Input::get('email'),
				'contributor' => Input::get('pseudonym'),
				'moderator_id' => NULL
			));

			if (Input::get('subscribe') === 'checked')
			{
				Subscription::create(array(
					'email' => Input::get('email'),
					'ip' => Request::getClientIp()
				));
				Log::debug('User subscribed!');
			}

			if ($definition->isValid() && $definition->isSaved())
			{
				Log::debug('Committing transaction');
				DB::commit();
				Log::info(sprintf('New definition for %s added!', Input::get('text')));
				return Redirect::to('/')->with('success', 'Expression added!');
			} 
			else
			{
				Log::debug('Rolling back transaction');
				DB::rollback();
				return Redirect::to('expression/add')
					->withInput()
					->withErrors($definition->errors());
			}
		} 
		catch (\Exception $e) 
		{
			Log::debug('Rolling back transaction');
			DB::rollback();
			return Redirect::to('/')->with('error', $e->getMessage());
		}
	}

	public function getTop()
	{
		$definitions = API::get('/api/v1/expressions/top');
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = "Top expressions";
		$this->theme->set('active', 'top');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getRandom()
	{
		$definitions = API::get('/api/v1/expressions/random');
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = "Random expressions";
		$this->theme->set('active', 'random');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function postRate()
	{
		$expressionId = Input::get('expressionId');
		$definitionId = Input::get('definitionId');
		$rate = API::post(sprintf('api/v1/expressions/%d/definitions/%d/rate', $expressionId, $definitionId), 
			array(
				'rating' => Input::get('rating'),
				'user_ip' => Request::getClientIp()
			)
		);
		return $rate;
	}

}