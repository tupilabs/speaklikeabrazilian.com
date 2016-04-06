<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2016 TupiLabs
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
namespace SLBR\Http\Controllers;

use Es;
use Exception;
use Log;
use Redirect;
use Illuminate\Http\Request;
use SLBR\Repositories\DefinitionRepository;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

class SearchController extends Controller
{

    /**
     * SLBR\Repositories\DefinitionRepository
     */
    private $definitionRepository;

    public function __construct(DefinitionRepository $definitionRepository)
    {
        $this->definitionRepository = $definitionRepository;
    }

    /**
     * Search expressions.
     *
     * @param Illuminate\Http\Request $request
     */
    public function getSearch(Request $request)
    {
        // tally search params
        $languages = $request->get('languages');
        $language = $this->getLanguage($languages, $request);
        $q = $request->get('q');
        $from = $request->get('from');
        $size = $request->get('size');
        $page = $request->get('page');

        if (!isset($size) || !is_numeric($size)) {
            $size = 10;
        }
        if (!isset($from) || !is_numeric($from)) {
            $from = 0;
        }
        if (isset($page) && is_numeric($page)) {
            $from = $size * ($page-1);
        } else {
            $page = 1;
        }

        if (!isset($q) || empty($q)) {
            Log::warning('Invalid search params');
            return Redirect::to('/')
                ->withInput()
                ->with('search_error', "Missing search parameters");
        }

        $json = '
        {
            "query": {
                "multi_match": {
                    "query":                "'.urlencode($q).'",
                    "type":                 "best_fields", 
                    "fields":               [ "expression^30", "description^2", "example", "tags" ],
                    "tie_breaker":          0.3,
                    "minimum_should_match": "30%" 
                }
            },
            "filter" : {
                "term" : {"language_id":"'.$language['id'].'"}
            }
        }
        ';

        $searchParams = array();
        $searchParams['index'] = 'slbr_index';
        $searchParams['size'] = $size;
        $searchParams['from'] = 0;
        $searchParams['body'] = $json;

        $hits = array();
        $total = 0;

        try {
            $result = Es::search($searchParams);
            $hits = $result['hits'];
            $total = $hits['total'];
        } catch (Exception $e) {
            Log::error('Search server error: ' . $e->getMessage());
            return Redirect::to('/')
                ->withInput()
                ->with('search_error', "Search server error. Please report to the site administrator.");
        }

        $ids = array();
        $pagination = array();
        $definitions = array();
        if (isset($hits['hits'])) {
            foreach ($hits['hits'] as $hit) {
                $ids[] = $hit['_id'];
            }
        }

        if (!empty($ids)) {
            $pagination = $this->definitionRepository->retrieve($ids, $language);
        }

        if (array_key_exists('data', $pagination)) {
            $definitions = $pagination['data'];
        }

        $data = array(
            'languages' => $languages,
            'lang' => $language['id'],
            'selected_language' => $language,
            'q' => $q,
            'size' => $size,
            'from' => $from,
            'definitions' => $definitions,
            'pagination' => $pagination,
            'query_parameters' => "&q=${q}"
        );
        return view('home', $data);
    }

    public function getSearchJson(Request $request)
    {
        $q = $request->get('q');
        $definitions = array();
        if (isset($q) && !empty($q)) {
            $languages = $request->get('languages');
            $language = $this->getLanguageBySlug($languages, 'en');
            $definitions = $this->definitionRepository->getRandom($language);

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
                    "term" : {"language_id":"'.$language['id'].'"}
                }
            }
            ';

            $searchParams = array();
            $searchParams['index'] = 'slbr_index';
            $searchParams['size'] = 20;
            $searchParams['from'] = 0;
            $searchParams['body'] = $json;

            $hits = array();
            $total = 0;

            try {
                $result = Es::search($searchParams);
                $hits = $result['hits'];
                $total = $hits['total'];
            } catch (Exception $e) {
                Log::error('Search server error: ' . $e->getMessage());
                return Redirect::to('/')
                    ->withInput()
                    ->with('search_error', "Search server error. Please report to the site administrator.");
            }

            $ids = array();
            $pagination = array();
            $definitions = array();
            if (isset($hits['hits'])) {
                foreach ($hits['hits'] as $hit) {
                    $ids[] = $hit['_id'];
                }
            }

            if (!empty($ids)) {
                $pagination = $this->definitionRepository->retrieve($ids, $language);
            }

            if (array_key_exists('data', $pagination)) {
                $definitions = $pagination['data'];
            }
        }
        return response()->json($definitions);
    }

    public function recreateSearchIndex(Request $request)
    {
        $admin = false;
        if (Sentinel::check()) {
            $user = Sentinel::getUser();
            $admin = $user->inRole('admins');
        }

        if (!$admin) {
            Log::warning(sprintf("Invalid user %s trying to recreate search index!", $request->getClientIp()));
            return Redirect::to('/admin/');
        }

        $definitions = $this->definitionRepository->with('expression')->all();
        foreach ($definitions as $definition) {
            $expression = $definition->expression;
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
            if (isset($ret['created']) && $ret['created'] == true) {
                Log::info('Document indexed');
            } else {
                Log::error('Failed to index document');
            }
        }

        echo "OK!";
    }
}
