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
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->orderBy('updated_at', 'desc')
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->paginate(10);
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = "New expressions";
		$this->theme->set('active', 'new');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getDefine()
	{
		$text = Input::get('e');
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('definitions.status', '=', 2)
			->where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower($text))
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->paginate(10);
		$args = array();
		$definitions->appends(array('e' => $text));
		$args['definitions'] = $definitions;
		$args['subtitle'] = sprintf("Definitions of '%s'", $text);
		$args['expression'] = $text;
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getLetter($letter)
	{
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->where('expressions.char', '=', strtoupper($letter))
			->orderBy('expressions.text', 'asc')
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->paginate(10);
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
				'moderator_id' => NULL,
				'user_ip' => Request::getClientIp()
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
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->orderByRaw('(COALESCE(likes, 0) - COALESCE(dislikes, 0)) DESC')
			->paginate(10);
		// $definitions->sortBy(function($definition){
		// 	$ratings = $definition->ratings()->get();
		// 	$rate = 0;
		// 	foreach ($ratings as $rating) 
		// 	{
		// 		$rate += $rating->rating;
		// 	}
		// 	//Log::debug(sprintf("RATE: %s", $rate));
		// 	return $rate;
		// });
		// $definitions = $definitions->reverse();

		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = "Top expressions";
		$this->theme->set('active', 'top');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getRandom()
	{
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->orderByRaw((Config::get('database.default') =='mysql' ? 'RAND()' : 'RANDOM()'))
			->take(10)
			->get();
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
		Log::info(sprintf('User %s wants to share a new video %s for definition ID %d', 
			Request::getClientIp(), Input::get('youtube_url'), Input::get('definitionId')));
		$url = Input::get('youtube_url');
		if (!preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
		{
			$args = array();
			$args['message'] = 'Sorry, only YouTube videos are allowed at the moment.';
			Log::error(sprintf('Error uploading video %s to definition %d', $url, Input::get('definitionId')));
			$this->theme->layout('message');
			return $this->theme->scope('message', $args)->render();
		}
		$media = Media::create(
			array(
				'definition_id' => Input::get('definitionId'),
				'url' => $url,
				'reason' => Input::get('reason'),
				'email' => Input::get('email'),
				'status' => 1, 
				'contributor' => Input::get('contributor'),
				'content_type' => 'video/youtube'
			)
		);
		if($media->isValid() && $media->isSaved())
		{
			$args = array();
			$args['message'] = 'Your video has been saved for review by our moderators';
			$this->theme->layout('message');
			return $this->theme->scope('message', $args)->render();
		} 
		else
		{
			$args = array();
			$args['message'] = 'An error occurred while adding your video. Please, try again later.';
			Log::error(sprintf('Error uploading video %s to definition %d', $url, Input::get('definitionId')));
			$this->theme->layout('message');
			return $this->theme->scope('message', $args)->render();
		}
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
		Log::info(sprintf('User %s wants to share a new picture %s for definition ID %d', 
			Request::getClientIp(), Input::get('url'), Input::get('definitionId')));
		$url = Input::get('url');
		if (!preg_match('%(?:imgur\.com/)([^"&?/ ]{11})%i', $url, $match))
		{
			$args = array();
			$args['message'] = 'Sorry, only imgur links are allowed at the moment.';
			Log::error(sprintf('Error uploading picture %s to definition %d', $url, Input::get('definitionId')));
			$this->theme->layout('message');
			return $this->theme->scope('message', $args)->render();
		}
		$media = Media::create(
			array(
				'definition_id' => Input::get('definitionId'),
				'url' => Input::get('url'),
				'reason' => Input::get('reason'),
				'email' => Input::get('email'),
				'status' => 1, 
				'contributor' => Input::get('contributor'),
				'content_type' => 'image/unknown'
			)
		);
		if($media->isValid() && $media->isSaved())
		{
			$args = array();
			$args['message'] = 'Your picture has been saved for review by our moderators';
			$this->theme->layout('message');
			return $this->theme->scope('message', $args)->render();
		} 
		else
		{
			return Redirect::to(sprintf('expression/%d/pictures?expressionId=%d', Input::get('definitionid'), Input::get('expressionId')))
				->withErrors($media->errors)
				->withInput();
		}
	}

}