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
 * Reject pending expressions.
 */
class Reject extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// models
		$this->load->model('expressions_model');
		$this->load->model('definitions_model');
		// UI
		$this->twiggy->set('active', 'pending_expressions');
	}
	
	public function index($expression_id) {
		if (v::notEmpty()->numeric()->min(1, TRUE /*inclusive*/)) {
	        $this->form_validation->set_rules('expression_id', 'Expression ID', 'trim|required|xss_clean|numeric|max_length[255]');
    	    $this->form_validation->set_rules('definition_id', 'Definition ID', 'trim|required|xss_clean|numeric|max_length[255]');
    	    if($this->form_validation->run()) {
    	        $definition_id = $this->form_validation->set_value('definition_id');
    	        $expression_id = $this->form_validation->set_value('expression_id');
    	        if($this->definitions_model->delete2($definition_id, $expression_id)) {
    	            $this->session->set_flashdata('message', 'Definition removed successfully');
    	        } else {
    	            $this->session->set_flashdata('error', 'Failed to remove definition');
    	        }
    	        redirect('/expression/pending');
    	    } else {
    	        $this->session->set_flashdata('error', 'Ops, something went wrong. Try again.');
    	        redirect('/expression/pending');
    	    }
		} else {
			$this->add_warning('Invalid request: missing expression ID');
			redirect('/');
		}
	}
	
}
