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
 * Displayed an expression embedded.
 */
class Display_embedded extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// models
		$this->load->model('expressions_model');
		// UI
		$this->twiggy->set('active', 'display_embedded');
	}
	
	public function index($definition_id) {
		if (v::notEmpty()->numeric()->min(1, TRUE /*inclusive*/)) {
			$expression = $this->expressions_model->getByDefinitionId($definition_id);
			$expression->description = parse_expression($expression->description);
			$expression->example = parse_expression($expression->example);
			// UI
			$this->twiggy->set('expression', $expression);
			$this->twiggy->set('url', sprintf('expression/%d/display_embedded', $definition_id));
			$this->twiggy->display('expression/display_embedded');
		} else {
			$this->add_warning('Invalid request: missing definition ID');
			redirect('/');
		}
	}
	
}
