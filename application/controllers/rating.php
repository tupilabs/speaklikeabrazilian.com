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

// RESTful controller
require APPPATH . '/libraries/REST_Controller.php';

use Respect\Validation\Validator as v;

/**
 * Rating controller.
 */
class Rating extends REST_Controller {

	/**
	 * Constructor.
	 */
	function __construct() {
		parent::__construct();
		// libraries
		$this->load->library('form_validation');
		// models
		$this->load->model('ratings_model');
	}

	/**
	 * Gets the votes for a definition.
	 * @param number $definition_id
	 */
	function expression_get($definition_id) {
		header('Content-Type: application/json');
		$votes = $this->ratings_model->getVotes($definition_id);
		$this->response($votes, 200);
		$this->output->cache(0);
	}

	/**
	 * Casts a vote.
	 * TODO: legacy code. Rewrite the response objects? Revisit it later.
	 * @param number $definition_id
	 */
	function expression_put($definition_id) {
		header('Content-Type: application/json');
		$rating = $this->put('rating');
		$ip = $_SERVER['REMOTE_ADDR'];
		if (isset($rating) && !empty($rating) && isset($ip) && !empty($ip)) {
			if ($rating > 0) {
				if ($this->_has_user_already_voted_up($definition_id, $ip)) {
					$this->response(array('msg' => 'You already voted up'), 200);
				} else {
					$balance = TRUE;
					if ($this->_has_user_already_voted_down($definition_id, $ip)) 
						$balance = TRUE;
					$this->ratings_model->vote($definition_id, $ip, $rating);
					$this->response(array('msg' => 'OK', 'balance' => $balance), 200);
				}
			} else if ($rating < 0) {
				if ($this->_has_user_already_voted_down($definition_id, $ip)) {
					$this->response(array('msg' => 'You already voted down'), 200);
				} else {
					$balance = FALSE;
					if ($this->_has_user_already_voted_up($definition_id, $ip))
						$balance = TRUE;
					$this->ratings_model->vote($definition_id, $ip, $rating);
					$this->response(array('msg' => 'OK', 'balance' => $balance), 200);
				}
			} else {
				$this->response(array('msg' => 'UH-OH! Something went wrong'), 500);
			}
		} else {
			$this->response(array('msg' => 'Invalid request'), 401);
		}
		$this->output->cache(0);
	}

	/**
	 * @param number $rating
	 * @param string $ip
	 * @access private
	 */
	function _has_user_already_voted_up($rating, $ip) {
		return $this->ratings_model->hasUserVotedUp($rating, $ip);
	}

	/**
	 * @param number $rating
	 * @param string $ip
	 * @access private
	 */
	function _has_user_already_voted_down($rating, $ip) {
		return $this->ratings_model->hasUserVotedDown($rating, $ip);
	}

}
?>