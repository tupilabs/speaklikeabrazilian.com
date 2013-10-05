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
 * Sentences application controller.
 * @since 0.1
 */
class Home extends MY_Controller {
    
	/**
	 * Constructor.
	 */
    public function __construct() {
        parent::__construct();
        // libraries
		$this->load->library('pagination');
		// models
        $this->load->model('expressions_model');
        $this->load->library('pagination');
        // UI
        // UI
        $this->twiggy->title()->append('Apps');
        $this->twiggy->title()->append('Sentences');
        $this->twiggy->set('active', 'sentences');
    }

    /**
     * Index.
     */
    public function index() {
    	// UI
    	$this->twiggy->display('apps/sentences/home');
    }
    
    /**
     * Display sentences search results.
     */
    public function search() {
    	$word = $this->input->get('q', TRUE);
    	$this->sphinxsearch->setServer('localhost', 9312);
    	$this->sphinxsearch->setMatchMode(SPH_MATCH_EXTENDED2);
    	$this->sphinxsearch->setMaxQueryTime(3);
    	
    	if (v::notEmpty()->string()->length(1, 1000, TRUE)->validate($word)) {
    		$result = $this->sphinxsearch->Query(sprintf("@example %s", $word));
    		$docs = array();
    		if ($result !== FALSE && count($result) > 0 && $result['total_found'] > 0) {
    			// Pagination
    			$this->load->config('pagination', TRUE);
    			$config = $this->config->config['pagination'];
    			$config['base_url'] = base_url(sprintf('/apps/sentences/search?q=%s', $word));
    			$config['total_rows'] = $result['total_found'];
    			$this->pagination->initialize($config);
    			$page = $this->input->get('page', TRUE);
    			if (v::notEmpty()->numeric()->validate($page) === TRUE) {
    				$page = ($page - 1) * $config['per_page'];
    			} else {
    				$page = 0;
    			}
    			
    			$pagination_links = $this->pagination->create_links();
    			$this->twiggy->set('pagination_links', $pagination_links);
    			
    			$index = 0;
    			$from = $page * $config['per_page'];
    			$to = ($page * $config['per_page']) + $config['per_page'];
    			foreach($result['matches'] as $key => $match) {
    				if ($index >= $from && $index <= $to) {
	    				array_push($docs, $key);
	    				$index++;
    				}
    			}
    			
    			$expressions = $this->expressions_model->get_search_results($docs);
    			$this->twiggy->set('sentences', $expressions);
    		} else {
    			$this->add_warning('No expressions found. Please, try again.');
    		}
    		
    		// UI
    		$this->twiggy->set('word', $word);
    		$this->twiggy->display('apps/sentences/home');
    	} else {
    		$this->add_warning('Missing query parameter. Please, try again.');
    		redirect('/apps/sentences/');
    	}
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/apps/sentences/welcome.php */
