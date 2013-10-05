<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 TupiLabs
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

use Respect\Validation\Validator as v;

/**
 * Define expressions controller. The s is to avoid conflict with a PHP reserved word.
 */
class Defines extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// libraries
		$this->load->library('pagination');
		// models
		$this->load->model('expressions_model');
		$this->load->model('ratings_model');
		// UI
		$this->twiggy->set('active', 'define');
	}
	
	/**
	 * Defines an expression. If already existing, lists the existing definitions.
	 * Otherwise it displays a form to define a new expression, similar to #add().
	 */
	public function index() {
		$expression = $this->input->get('e');
		
		$this->twiggy->set('expression', $expression);
		if (v::notEmpty()->string()->validate($expression) === TRUE) {
			// UI
			$this->twiggy->title(sprintf("Define '%s'", $expression));
			$this->twiggy->set('subtitle', sprintf("Define '%s'", $expression));
			// UI
			$this->twiggy->set('no_expressions_message', sprintf("No definitions for '%s' found. Share yours at SLBR", $expression));
		} else {
			// UI
			$this->twiggy->title('Define new expression');
		}
		
		// Pagination
		$this->load->config('pagination', TRUE);
		$config = $this->config->config['pagination'];
		$config['base_url'] = base_url(sprintf('expression/define/%s', $expression));
		$config['total_rows'] = $this->expressions_model->countByText($expression);
		$this->pagination->initialize($config);
		$page = $this->input->get('page', TRUE);
		if (v::notEmpty()->numeric()->validate($page) === TRUE) {
			$page = ($page - 1) * $config['per_page'];
		} else {
			$page = 0;
		}
		$expressions = $this->expressions_model->getByText($expression, $config['per_page'], $page);
		$this->twiggy->set('expressions', $expressions);
		$pagination_links = $this->pagination->create_links();
		
		if (v::arr()->notEmpty()->validate($expressions)) {
			$this->twiggy->display('expression/define');
		} else {
			// UI
			$this->twiggy->set('active', 'add');
			$captcha = $this->_create_captcha();
			$this->twiggy->set('captcha', $captcha);
			$this->twiggy->display('expression/add');
		}
	}
	
}
