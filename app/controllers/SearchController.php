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

class SearchController extends \BaseController {

	public function getSearch()
	{
		$lang = App::getLocale();
		$languageId = Config::get("constants.$lang", Config::get('constants.en', 1));
		$q = Input::get('q');
		$from = Input::get('from');
		$size = Input::get('size');
		$page = Input::get('page');

		if (!isset($size) || !is_numeric($size))
		{
			$size = 10;
		}
		if (!isset($from) || !is_numeric($from))
		{
			$from = 0;
		}
		if (isset($page) && is_numeric($page))
		{
			$from = $size * ($page-1);
		} 
		else
		{
			$page = 1;
		}

		if (!isset($q) || empty($q))
		{
			Log::debug('Invalid search');
			return Redirect::to('/')
				->withInput()
				->with('message', "Missing search parameters.");
		}

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
		        "term" : {"language_id":"'.$languageId.'"}
		    }
		}
		';
		//Log::debug($json);

		$searchParams = array();
		$searchParams['index'] = 'slbr_index';
		$searchParams['size'] = $size;
		$searchParams['from'] = $from;
		$searchParams['body'] = $json;

		$hits = array();
		$total = 0;

		try
		{
			$result = Es::search($searchParams);
			$hits = $result['hits'];
			$total = $hits['total'];
		} 
		catch (Exception $e)
		{
			Log::error('Search server error: ' . $e->getMessage());
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
			$definitions = Definition::
				join('expressions', 'definitions.expression_id', '=', 'expressions.id')
				->where('status', '=', 2)
				->where('language_id', '=', Config::get("constants.$lang", Config::get('constants.en', 1)))
				->whereIn('definitions.id', $ids)
				->orderBy('created_at', 'desc')
				->select('definitions.*', 
					'expressions.text',
					new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) FROM ratings where ratings.definition_id = definitions.id and ratings.rating = 1) as likes"),
					new \Illuminate\Database\Query\Expression("(SELECT sum(ratings.rating) * -1 FROM ratings where ratings.definition_id = definitions.id and ratings.rating = -1) as dislikes")
					)
				->get();
			$links = '<ul class="pagination">';
			$pages = ceil($total / $size);
			if ($page <= 1)
			{
				$links .= "<li><a>&laquo;</a></li>";
			}
			else
			{
				$previous = $page - 1;
				$links .= "<li><a href='". URL::to("$lang/search?q=$q&page=$previous") ."'>&laquo;</a></li>";
			}
			for ($i = 1; $i <= $pages; $i++)
			{
				$class = ($i == $page ? "active" : "");
				$links .= "<li class='$class'><a href='" . URL::to("$lang/search?q=$q&page=$i") . "'>$i</a></li>";
			}
			if ($page >= $pages)
			{
				$links .= "<li><a>&raquo;</a></li>";
			}
			else
			{
				$next = $page + 1;
				$links .= "<li><a href='". URL::to("$lang/search?q=$q&page=$next") ."'>&raquo;</a></li>";
			}
			$links .= "</ul>";
			$definitions->links = $links;
		}

		Theme::set('q', $q);
		Theme::set('size', $size);
		Theme::set('from', $from);

		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = Lang::get('messages.search_results');
		$this->theme->set('active', 'search');
		return $this->theme->scope('search.index', $args)->render();
	}

	public function recreateSearchIndex()
	{
		$admin = false;
		if (Sentry::check())
		{
			$user = Sentry::getUser();
			$admin = $user->hasAccess('admin');
		}

		if (!$admin)
		{
			return Redirect::to('/user/login?from=admin');
		}

		$definitions = Definition::get();
		foreach ($definitions as $definition)
		{
			$expression = Expression::where('id', '=', $definition->expression_id)->firstOrFail();
			// Index document into search server
			$params = array();
			$params['body']  = array(
				'expression' => $expression->text,
				'description' => $definition->description,
				'example' => $definition->example,
				'tags' => $definition->tags,
				'language_id' => $definition->language_id
			);
			$params['index'] = 'slbr_index';
			$params['type']  = 'definition';
			$params['id']    = $definition->id;

			// Document will be indexed to slbr_index/definition/id
			Log::debug('Indexing into search server');
			$ret = Es::index($params);
			if (isset($ret['created']) && $ret['created'] == true)
			{
				Log::info('Document indexed');
			}
			else
			{
				Log::error('Failed to index document');
			}
		}

		echo "OK!";
	}

}
