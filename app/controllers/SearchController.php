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
		$q = Input::get('q');
		$from = Input::get('from');
		$size = Input::get('size');

		if (!isset($size) || !is_numeric($size))
		{
			$size = 10;
		}
		if (!isset($from) || !is_numeric($from))
		{
			$from = 0;
		}

		if (!isset($q))
		{
			Log::debug('Invalid search');
			return Redirect::to('/')
				->withInput()
				->with('message', "Missing search parameters.");
		}

		$json = '
		{
			"query": {
		    	"fuzzy_like_this" : {
		    		"like_text":    "' . $q . '", 
		    		"fields": [ "expression", "description", "example", "tags" ],
		    		"max_query_terms" : 10
		  		}
		  	}
		}
		';

		$searchParams['index'] = 'slbr_index';
		$searchParams['size'] = $size;
		$searchParams['from'] = $from;
		$searchParams['body'] = $json;
		$result = Es::search($searchParams);
		$hits = $result['hits'];

		$ids = array();
		foreach ($hits['hits'] as $hit)
		{
			$ids[] = $hit['_id'];
		}

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

		Theme::set('q', $q);

		$args = array();
		$args['definitions'] = $definitions;
		$args['subtitle'] = Lang::get('messages.search_results');
		$this->theme->set('active', 'search');
		return $this->theme->scope('search.index', $args)->render();
	}

	public function recreateSearchIndex()
	{
		// FIXME: check if the user is admin
		
	}

}
