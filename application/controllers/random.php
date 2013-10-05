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
 * Random expressions controller.
 */
class Random extends MY_Controller {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// libraries
		$this->load->library('pagination');
		// models
		$this->load->model('expressions_model');
		// UI
		$this->twiggy->title()->append('Random expressions');
		$this->twiggy->set('active', 'random');
	}
	
	/**
	 * Handles index
	 */
	public function index()	{
		// Pagination
		$this->load->config('pagination', TRUE);
		$config = $this->config->config['pagination'];
		$config['base_url'] = base_url('');
		$config['total_rows'] = $this->expressions_model->countExpressions();
		$this->pagination->initialize($config);
		$page = $this->input->get('page', TRUE);
		if (v::notEmpty()->numeric()->validate($page) === TRUE) {
			$page = ($page - 1) * $config['per_page'];
		} else {
			$page = 0;
		}
		$expressions = $this->expressions_model->getRandomExpressions($config['per_page'], $page);
		$pagination_links = $this->pagination->create_links();
		
		// UI
		$this->twiggy->set('subtitle', 'Displaying random expressions');
		$this->twiggy->set('no_expressions_message', 'No expressions found');
		
		$this->twiggy->set('expressions', $expressions);
		$this->twiggy->set('pagination_links', $pagination_links);
		$this->twiggy->display('random');
	}
}
