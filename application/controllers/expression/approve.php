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
 * Approve pending expressions.
 */
class Approve extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// models
		$this->load->model('expressions_model');
		$this->load->model('definitions_model');
		$this->load->model('ratings_model');
		// UI
		$this->twiggy->set('active', 'pending_expressions');
	}
	
	public function index($expression_id) {
		if (v::notEmpty()->numeric()->min(1, TRUE /*inclusive*/)) {
			$this->form_validation->set_rules('expression', 'Expression', 'trim|required|xss_clean|max_length[255]');
			$this->form_validation->set_rules('definition', 'Definition', 'trim|required|xss_clean|max_length[1000]');
			$this->form_validation->set_rules('example', 'Example', 'trim|required|xss_clean|max_length[1000]');
			$this->form_validation->set_rules('tags', 'Tags', 'trim|required|xss_clean|max_length[255]');
			if($this->form_validation->run()) {
				$expression_data = array();
				$expression_data['expression_id'] = $expression_id;
				$expression_data['expression'] = $this->form_validation->set_value('expression');
				$expression_data['description'] = $this->form_validation->set_value('definition');
				$expression_data['example'] = $this->form_validation->set_value('example');
				$expression_data['tags'] = $this->form_validation->set_value('tags');
				if($this->expressions_model->approve($expression_id, $expression_data)) {
					$this->session->set_flashdata('message', 'Expression published! Yay!');
					$expression_data['definition_id'] = $expression_id;
					$expression_data['url'] = base_url('expression/'.$expression_id);
					$email = $this->definitions_model->getEmail($expression_id);
					$expression_data['from'] = $this->config->item('slbr_email');
					$expression_data['name'] = $this->config->item('slbr_name');
					$expression_data['to'] = $email;
					$expression_data['subject'] = 'Your expression has been published in SLBR!';
					$this->_send_email('approval-html', 'approval-txt', $expression_data);
					$this->ratings_model->vote2($expression_id);
					redirect('/expression/pending');
				} else {
					$this->add_error('Something went wrong. Try again.');
					redirect('/expression/pending');
				}
			} else {
				redirect('/expression/pending');
			}
		} else {
			$this->add_warning('Invalid request: missing expression ID');
			redirect('/');
		}
	}
	
}
