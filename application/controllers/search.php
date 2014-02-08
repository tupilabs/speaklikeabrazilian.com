<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 TupiLabs
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

use Respect\Validation\Validator as v;

/**
 * Search controller.
 */
class Search extends MY_Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// models
		$this->load->model('expressions_model');
		// UI
		$this->twiggy->title()->append('Search results');
		$this->twiggy->set('active', 'search');
	}
	
	public function index() {
		$q = $this->input->get('q', TRUE);
		$this->sphinxsearch->setServer('localhost', 9312);
		$this->sphinxsearch->setMatchMode(SPH_MATCH_EXTENDED2);
		$this->sphinxsearch->setMaxQueryTime(3);
		
		if (v::notEmpty()->string()->length(1, 1000, TRUE)->validate($q)) {
			$result = $this->sphinxsearch->Query($q);
			$expressions = array();
			$docs = array();
                        if ($result !== FALSE && count($result) > 0 && isset($result['mtaches']) && $result['matches']) {
				foreach($result['matches'] as $key => $match) {
					array_push($docs, $key);
				}
				
				$expressions = $this->expressions_model->get_search_results($docs);
			}
			// UI
			$this->twiggy->set('subtitle', sprintf("Found %d expressions matching with your search results", count($expressions)));
			$this->twiggy->set('no_expressions_message', sprintf("No expressions found matching '%s'", $q));
			$this->twiggy->set('expressions', $expressions);
			$this->twiggy->display('expression/search_result');
		} else {
			$this->add_warning('Missing query parameter. Please, try again.');
			redirect('/');
		}
	}
	
}
