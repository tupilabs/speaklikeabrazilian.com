<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
 * Controller used to create captchas using secure image.
 */
class Captcha extends CI_Controller {
	
	/**
	 * Constructor.
	 */
	function __construct() {
		parent::__construct();
	}

	function index() {
		// Initialize securimage library
		$config = array (
				'image_width' => '180',
				'image_height'  => '80',
				'code_length' => rand(4,6),
				'perturbation' => '0.8',
				'num_lines' => rand(4,6),
				'captcha_type' => '0',
				'charset' => 'abcdefghkmnprstuvwyz23456789',
				//'text_color' => '#5e5e5e',
				'system_secureimage_path' => APPPATH.'secureimage/'
		);
		$this->load->library('securimage', $config);
		$this->securimage->show();
	}
}
