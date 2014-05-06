<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2014 TupiLabs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
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
		$lang = App::getLocale();
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->where('language_id', '=', Config::get("constants.$lang", Config::get('constants.en', 1)))
			->orderBy('created_at', 'desc')
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->paginate(10);
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = Lang::get('messages.new_expressions');
		$this->theme->set('active', 'new');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getTop()
	{
		$lang = App::getLocale();
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->where('language_id', '=', Config::get("constants.$lang", Config::get('constants.en', 1)))
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->orderByRaw('(COALESCE(likes, 0) - COALESCE(dislikes, 0)) DESC')
			->paginate(10);

		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = Lang::get('messages.top_expressions');
		$this->theme->set('active', 'top');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getRandom()
	{
		$lang = App::getLocale();
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->where('language_id', '=', Config::get("constants.$lang", Config::get('constants.en', 1)))
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
		$args['subtitle'] = Lang::get('messages.random_expressions');
		$this->theme->set('active', 'random');
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getDefine()
	{
		$lang = App::getLocale();
		$text = Input::get('e');
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('definitions.status', '=', 2)
			->where('language_id', '=', Config::get("constants.$lang", Config::get('constants.en', 1)))
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
		$args['subtitle'] = Lang::get('messages.definitions_of', array('definition' => $text));
		$args['expression'] = $text;
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getLetter($letter)
	{
		$lang = App::getLocale();
		$queryLetter = $letter === '0-9' ? '0' : strtoupper($letter);
		$definitions = Definition::
			join('expressions', 'definitions.expression_id', '=', 'expressions.id')
			->where('status', '=', 2)
			->where('language_id', '=', Config::get("constants.$lang", Config::get('constants.en', 1)))
			->where('expressions.char', '=', $queryLetter)
			->orderBy('expressions.text', 'asc')
			->select('definitions.*', 
				'expressions.text',
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
				new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
				)
			->paginate(10);
		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = Lang::get('messages.letter_expressions', array('letter' => strtoupper($letter)));
		$letter = strtoupper($letter);
		$args['letter'] = $letter;
		$this->theme->set('active', $letter);
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getAdd()
	{
		$args = array();

		$expression = Input::get('e');
		if (isset($expression) && strlen($expression) > 0)
			$args['expression'] = ucfirst($expression);

		$lang = App::getLocale();
		$args['lang'] = Config::get("constants.$lang", Config::get('constants.en', 1));

		$languages = Language::all();
		$languagesArray = array();
		foreach ($languages as $language)
		{
			$languagesArray[$language->id] = $language->description;
			if ($language->id == $args['lang'])
			{
				$args['selectedLanguage'] = $language->description;
			}
		}
		$args['languages'] = $languagesArray;
	
		return $this->theme->scope('expression.add', $args)->render();
	}

	public function postAdd()
	{
		Log::debug('Starting transaction to add new expression');
		DB::beginTransaction();

		try 
		{
			$lang = App::getLocale();
			$text = Input::get('text');
			// Get existing expressions
			$expression = Expression::
				where(new \Illuminate\Database\Query\Expression("lower(expressions.text)"), '=', strtolower($text))
				->first();

			$letter = substr($text, 0, 1);
			if (is_numeric($letter))
			{
				$letter = '0';
			}
			else
			{
				$unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
				$text2 = strtr($text, $unwanted_array );
				$letter = substr($text2, 0, 1);
			}
			if (!$expression)
			{
				$expression = Expression::create(array(
					'text' => $text,
					'char' => strtoupper($letter),
					'contributor' => Input::get('pseudonym'),
					'moderator_id' => NULL
				));

				if (!$expression->isValid() || !$expression->isSaved())
				{
					return Redirect::to("$lang/expression/add")
						->withInput()
						->withErrors($expression->errors());
				}
			}

			$definition = Definition::create(array(
				'expression_id' => $expression->id, 
				'description' => Input::get('definition'),
				'example' => Input::get('example'),
				'tags' => Input::get('tags'),
				'status' => 1,
				'email' => Input::get('email'),
				'contributor' => Input::get('pseudonym'),
				'moderator_id' => NULL,
				'user_ip' => Request::getClientIp(),
				'language_id' => Input::get('language')
			));

			if (Input::get('subscribe') === 'checked')
			{
				$existing = Subscription::where('email', '=', Input::get('email'))->count();
				if ($existing == 0)
				{
					Log::info('Yay! We got a new subscription from ' . Request::getClientIp());
					try 
					{
						$subscription = Subscription::create(array(
							'email' => Input::get('email'),
							'ip' => Request::getClientIp()
						));
						if ($subscription->isValid() && $subscription->isSaved())
						{
							$environment = App::environment();
							if ($environment == 'production')
							{
								Log::info('A new user is subscribed! Sending it to the mailing list server, under list ID ' . Config::get('mailchimp::list_id'));
								$r = MailchimpWrapper::lists()->subscribe(Config::get('mailchimp::list_id'), array('email' => Input::get('email')));
								Log::debug('MailChimp response: ' . var_export($r, true));
							}
							else
							{
								Log::info('Mailing list subscription enabled only in production. Current env: ' . $environment);
							}
						}
						else
						{
							Log::error('Error subscribing user: ' . var_export($subscription->errors(), true));
						}
					}
					catch (Exception $e)
					{
						Log::error('Internal error. Error subscribing user: ' . $e->getMessage());
						Log::error($e);
					}
				}
				else
				{
					Log::debug('User tried to subscribe twice to our mailing list. Yipie!');
				}
			}

			if ($definition->isValid() && $definition->isSaved())
			{
				Log::debug('Committing transaction');
				DB::commit();
				Log::info(sprintf('New definition for %s added!', Input::get('text')));
				return Redirect::to("/$lang")->with('success', Lang::get('messages.expression_added'));
			} 
			else
			{
				Log::debug('Rolling back transaction');
				DB::rollback();
				return Redirect::to("$lang/expression/add")
					->withInput()
					->withErrors($definition->errors());
			}
		} 
		catch (\Exception $e) 
		{
			Log::debug('Rolling back transaction');
			DB::rollback();
			return Redirect::to("/$lang")->with('error', $e->getMessage());
		}
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
			$args['message'] = Lang::get('messages.video_added');
			$this->theme->layout('message');
			return $this->theme->scope('message', $args)->render();
		} 
		else
		{
			$args = array();
			$args['message'] = Lang::get('messages.video_not_added');
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
			$args['message'] = Lang::get('messages.picture_added');
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