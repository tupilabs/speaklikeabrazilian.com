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
 * Adds videos to expressions.
 */
class Video extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// models
		$this->load->model('media_model');
		$this->load->model('expressions_model');
		// UI
		$this->twiggy->set('active', 'pending_expressions');
	}
	
	public function index($definition_id) {
		if (v::notEmpty()->numeric()->min(1, TRUE /*inclusive*/)) {
			$this->form_validation->set_rules('url', 'YouTube URL', 'trim|required|xss_clean|max_length[255]|callback__check_youtube_url');
			$this->form_validation->set_rules('reason', 'Reason', 'trim|required|xss_clean|max_length[255]');
			if($this->form_validation->run()) {
				$url = $this->form_validation->set_value('url');
				$reason = $this->form_validation->set_value('reason');
				$media_data = array();
				$media_data['definition_id'] = $definition_id;
				$media_data['url'] = $url;
				$media_data['reason'] = $reason;
				$media_data['content_type'] = 'video/youtube';
				$this->media_model->create($media_data);
				// UI
				$this->twiggy->set('active', 'none');
				$this->twiggy->display('expression/thank_you_video');
			} else {
				$expression = $this->expressions_model->getByDefinitionId($definition_id);
				// UI
				$this->twiggy->set('expression', $expression);
				$this->twiggy->display('expression/video');
			}
		} else {
			$this->add_warning('Invalid request: missing definition ID');
			redirect('/');
		}
	}
	
}
