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
 * Share an expression.
 */
class Share extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// Model
		$this->load->model('expressions_model');
		// UI
		$this->twiggy->set('active', 'share');
	}
	
	public function index($definition_id) {
		if (v::notEmpty()->numeric()->min(1, TRUE /*inclusive*/)) {
			$this->form_validation->set_rules('from_name', 'Your name', 'trim|required|xss_clean|max_length[255]');
            $this->form_validation->set_rules('from_email', 'Your email', 'trim|required|xss_clean|email|max_length[255]');
            $this->form_validation->set_rules('to', 'To', 'trim|required|xss_clean|max_length[255]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|email|max_length[255]');
            $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|max_length[30]|required|callback__check_captcha');
            if($this->form_validation->run()) {
                $from_name = $this->form_validation->set_value('from_name');
                $from_email = $this->form_validation->set_value('from_email');
                $name = $this->form_validation->set_value('to');
                $email = $this->form_validation->set_value('email');
                $expression = $this->expressions_model->getByDefinitionId($definition_id);
                $expression->description = parse_expression($expression->description);
                $expression->example = parse_expression($expression->example);
                $email = array();
                $email['name'] = $from_name;
                $email['from'] = $from_email;
                $email['to'] = $name;
                $email['email'] = $email;
                $email['subject'] = 'Someone wants to share a Brazilian expression with you!';
                $email['expression'] = $expression;
                $email['url'] = base_url(sprintf('expression/%d', $expression->definition_id));
                $this->_send_email('share-html', 'share-txt', $email);
                // UI
                $this->twiggy->set('message', 'Your message was sent!');
                $this->twiggy->display('thank_you');
            } else {
                $expression = $this->expressions_model->getByDefinitionId($definition_id);
                $captcha = $this->_create_captcha();
                $this->twiggy->set('captcha', $captcha);
                $this->twiggy->set('expression', $expression);
                $this->twiggy->display('expression/share');
            }
		} else {
			$this->add_warning('Invalid request: missing definition ID');
			redirect('/');
		}
	}
	
}
