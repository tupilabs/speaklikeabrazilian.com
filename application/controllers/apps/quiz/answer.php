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
 * Quiz answers.
 * @since 0.1
 */
class Answer extends MY_Controller {
	
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();
		// model
		$this->load->model('expressions_model');
		// UI
		$this->twiggy->title()->append('Apps');
		$this->twiggy->title()->append('Quiz');
		$this->twiggy->set('active', 'quiz');
	}

	public function index() {
		$quiz = $this->session->userdata('quiz');
		if (is_null($quiz) || empty($quiz)) {
			$this->session->set_flashdata('message', 'No quiz session. You must answer all questions. Please, try again.');
			redirect('/apps/quiz/home');
		}
		for ($i = 0; $i < $quiz->number_of_questions ; $i+=1) {
			$answer = $this->input->post('question_' . $i);
			if (!isset($answer) || is_null($answer) || empty($answer)) {
				$this->session->set_flashdata('message', 'You must answer all questions. Please, try again.');
				redirect('/apps/quiz/home');
			}
		}
		$correct_count = 0;
		for ($i = 0; $i < $quiz->number_of_questions ; $i+=1) {
			$answer = $this->input->post('question_' . $i);
			$quiz->questions[$i]->alternative = $answer;
			$expression = $this->expressions_model->getByDefinitionId($quiz->questions[$i]->answer_definition_id);
			if ($expression->id == $answer) {
				$quiz->questions[$i]->correct = true;
				$correct_count += 1;
			} else {
				$quiz->questions[$i]->correct = false;
			}
		}
		$quiz->complete = true;
		$quiz->result = ($correct_count/$quiz->number_of_questions)*100;
		$this->twiggy->set('quiz', $quiz);
		$this->twiggy->display('apps/quiz/answer');
	}
	
}
