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
 * Controller to add a new expression/definition.
 */
class Add extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// models
		$this->load->model('expressions_model');
		$this->load->model('definitions_model');
		$this->load->model('ratings_model');
		$this->load->model('subscribers_dao');
		// UI
		$this->twiggy->set('active', 'define');
	}
	
	public function index() {
		$this->form_validation->set_rules('expression', 'Expression', 'trim|required|xss_clean|max_length[255]');
		$this->form_validation->set_rules('definition', 'Definition', 'trim|required|xss_clean|max_length[1000]');
		$this->form_validation->set_rules('example', 'Example', 'trim|required|xss_clean|max_length[1000]');
		$this->form_validation->set_rules('tags', 'Tags', 'trim|required|xss_clean|max_length[255]');
		$this->form_validation->set_rules('pseudonym', 'Pseudonym', 'trim|required|xss_clean|max_length[255]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|email|max_length[255]');
		$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|max_length[30]|required|callback__check_captcha');
		
		if($this->form_validation->run() === TRUE) {
			$text = $this->form_validation->set_value('expression');
			$letter = is_numeric($text[0]) ? '0' : $text[0];
			
			$this->db->trans_start();
			
			// Expression
			$expression = $this->expressions_model->getExpressionOnlyByText($text)->row();
			// If not existent, then create a new one
			if (!v::notEmpty()->validate($expression)) {
				$expression = new stdClass();
				$expression->text = $text;
				$expression->create_user = $this->form_validation->set_value('pseudonym');
				$expression->letter = $letter;
		        $id = $this->expressions_model->create((array) $expression);
		        if($id <= 0) {
		            show_error('1020: Error creating expression', 500);
		        }
		        $expression->id = $id;
			}
			
			// Definition
			$definition = new stdClass();
			$definition->expression_id = $expression->id;
			$definition->description = urlencode($this->form_validation->set_value('definition'));
			$definition->example = urlencode($this->form_validation->set_value('example'));
			$definition->create_user = $this->form_validation->set_value('pseudonym');
			$definition->email = $this->form_validation->set_value('email');
			$definition->tags = $this->form_validation->set_value('tags');
			$definition->status = 'P';
			$ip = $_SERVER['REMOTE_ADDR'];
			$definition->create_user_ip = $ip;
			$id = $this->definitions_model->create((array) $definition);
			$definition->id = $id;
			
			$subscribe_checked = $this->input->post('subscribe');
			if (v::notEmpty()->string()->equals('checked')->validate($subscribe_checked)) {
				$existing_subscriber = $this->subscribers_dao->get_by_email($definition->email);
				if (!$existing_subscriber) {
					$subscriber = new stdClass();
					$subscriber->email = $definition->email;
					$this->subscribers_dao->create($subscriber);
				}
			}
			
			$this->db->trans_complete();
			$this->add_success('Thank you! You will receive a notification when your expression has been published!');
			redirect('/');
		} else {
			// UI
			$this->twiggy->set('active', 'add');
			$captcha = $this->_create_captcha();
			$this->twiggy->set('captcha', $captcha);
			$this->twiggy->display('expression/add');
		}
	}
	
}
