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

/**
 * Feedback controller.
 */
class Feedback extends MY_Controller {

	/**
	 * Constructor.
	 */
    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean|max_length[1000]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|email|max_length[255]');
        $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|max_length[30]|required|callback__check_captcha');
        // Validate contact form submission
        if($this->form_validation->run()) {
            $message = $this->form_validation->set_value('message');
            $name = $this->form_validation->set_value('name');
            $email = $this->form_validation->set_value('email');
            $data = array();
            $data['message'] = $message;
            $data['name'] = $name;
            $data['from'] = $email;
            $this->_send_email('contact', $data);
            // UI
            $this->twiggy->set('active', 'thank_you');
            $this->twiggy->display('thank_you');
        } else {
        	// UI
        	$captcha = $this->_create_captcha();
        	$this->twiggy->set('captcha', $captcha);
        	$this->twiggy->display('feedback');
        }
    }
    
}
