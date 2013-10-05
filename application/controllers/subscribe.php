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
 * Controller for subscriptions to the word of the day.
 */
class Subscribe extends MY_Controller {

	/**
	 * Constructor.
	 */
    function __construct() {
        parent::__construct();
        // models
        $this->load->model('subscribers_dao');
        // UI
        $this->twiggy->title()->append('Subscribe');
        $this->twiggy->set('active', 'subscribe');
    }

    function index() {
    	$this->form_validation->set_rules('email', 'E-mail', 'xss_clean|trim|required|valid_email');
    	if ($this->form_validation->run()) {
    		$email = $this->form_validation->set_value('email');
    		
    		$existing_subscriber = $this->subscribers_dao->get_by_email($email);
    		if (isset($existing_subscriber) && !empty($existing_subscriber)) {
    			// UI
    			$this->twiggy->set('message', 'Thank you for subscribing! You will receive our first word of the day tomorrow.');
    			$this->twiggy->display('thank_you');
    		} else {
    			$subscriber = new stdClass();
    			$subscriber->email = $email;
    			$this->subscribers_dao->create($subscriber);
    			// UI
    			$this->twiggy->set('message', 'Thank you for subscribing! You will receive our first word of the day tomorrow.');
    			$this->twiggy->display('thank_you');
    		}
    	} else {
    		// UI
    		$this->twiggy->display('subscribe');
    	}
    }
}
