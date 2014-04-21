<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2014 TupiLabs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 *  this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

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
				return Redirect::to('/')->with('success', 'Expression added! It will get published after one of our moderators review it. Thank you!');
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
		$rating = Input::get('rating');
		$userIp = Request::getClientIp();
		$rate = API::post(sprintf('api/v1/expressions/%d/definitions/%d/rate', $expressionId, $definitionId), 
			array(
				'rating' => $rating,
				'user_ip' => $userIp
			)
		);
		return $rate;
	}

	public function getEmbed($id) 
	{
		$args = array();
		$args['url'] = sprintf('/expression/%d/display_embedded', $id);
		$this->theme->layout('message');
		return $this->theme->scope('expression.embed', $args)->render();
	}

	public function displayEmbedded($definitionId)
	{
		// TODO: simplify to a single call by def id
		$expression = API::get("api/v1/expressions/findByDefinitionId?definitionId=$definitionId");
		$expressionId = $expression->id;
		$definition = API::get("api/v1/expressions/$expressionId/definitions/$definitionId");
		$args = array();
		$args['definition'] = $definition;
		$this->theme->layout('message');
		return $this->theme->scope('expression.display_embedded', $args)->render();
	}

	public function getShare($definitionId)
	{
		$expressionId = Input::get('expressionId');
		$definition = API::get("api/v1/expressions/$expressionId/definitions/$definitionId");
		$likes = 0;
		$dislikes = 0;
		foreach ($definition['ratings'] as $rating)
		{
			if ($rating['rating'] == 1)
			{
				$likes += 1;
			}
			else
			{
				$dislikes += 1;
			}
		}
		$args = array();
		$args['definition'] = $definition;
		$args['likes'] = $likes;
		$args['dislikes'] = $dislikes;
		$this->theme->layout('message');
		return $this->theme->scope('expression.share', $args)->render();
	}

	public function postShare($definitionId)
	{
		// TODO: send e-mail
		echo "TODO: send e-mail";
		exit;
	}

	public function getVideos($definitionId)
	{
		$expressionId = Input::get('expressionId');
		$definition = API::get("api/v1/expressions/$expressionId/definitions/$definitionId");
		$likes = 0;
		$dislikes = 0;
		foreach ($definition['ratings'] as $rating)
		{
			if ($rating['rating'] == 1)
			{
				$likes += 1;
			}
			else
			{
				$dislikes += 1;
			}
		}
		$args = array();
		$args['definition'] = $definition;
		$args['likes'] = $likes;
		$args['dislikes'] = $dislikes;
		$this->theme->layout('message');
		return $this->theme->scope('expression.videos', $args)->render();
	}

	public function postVideos()
	{
		echo "TODO";
		exit;
	}

	public function getPictures($definitionId)
	{
		$expressionId = Input::get('expressionId');
		$definition = API::get("api/v1/expressions/$expressionId/definitions/$definitionId");
		$likes = 0;
		$dislikes = 0;
		foreach ($definition['ratings'] as $rating)
		{
			if ($rating['rating'] == 1)
			{
				$likes += 1;
			}
			else
			{
				$dislikes += 1;
			}
		}
		$args = array();
		$args['definition'] = $definition;
		$args['likes'] = $likes;
		$args['dislikes'] = $dislikes;
		$this->theme->layout('message');
		return $this->theme->scope('expression.pictures', $args)->render();
	}

	public function postPictures()
	{
		echo "TODO";
		exit;
	}

}