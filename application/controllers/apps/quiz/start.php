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
 * Quiz start.
 * @since 0.1
 */
class Start extends MY_Controller {
	
	/**
	 * Constructor.
	 */
    public function __construct() {
        parent::__construct();
        // models
        $this->load->model('expressions_model');
        // UI
        $this->twiggy->title()->append('Apps');
        $this->twiggy->title()->append('Quiz');
        $this->twiggy->set('active', 'quiz');
    }

    /**
     * Index.
     */
	public function index() {
		$this->form_validation->set_rules('number_of_questions', 'Number of questions', 'trim|required|xss_clean');
		if($this->form_validation->run()) {
			$quiz = new stdClass();
			$quiz->number_of_questions = $this->form_validation->set_value('number_of_questions');
			if ($quiz->number_of_questions != 5 && $quiz->number_of_questions != 10 && $quiz->number_of_questions != 20) {
				$this->session->set_flashdata('message', 'Invalid number of questions');
				redirect('/apps/quiz/welcome');
			}
			$expressions = $this->expressions_model->getRandomExpressions($quiz->number_of_questions, 0);
			$quiz->questions = $this->_get_questions($expressions);
			$this->session->set_userdata('quiz', $quiz);
			$this->twiggy->set('quiz', $quiz);
			$this->twiggy->display('apps/quiz/start');
		} else {
			$this->session->unset_userdata('quiz');
			$this->twiggy->display('apps/quiz/home');
		}
	}
	
	private function _get_questions($expressions) {
		$questions = array();
		foreach ($expressions as $expression) {
			$question = new stdClass();
			$question->text = $expression->text;
			$question->expression_id = $expression->id;
			$question->answer = $expression->description;
			$question->answer_definition_id = $expression->definition_id;
			
			$question->alternatives = array();
			$dummy_alternative = new stdClass();
			$dummy_alternative->expression_id = $expression->id;
			$dummy_alternative->definition_id = $expression->definition_id;
			$dummy_alternative->text = $expression->text;
			$dummy_alternative->description = $expression->description;
			$dummy_alternative->order = 0;
			$question->alternatives[] = $dummy_alternative;
			
			$shuffled_expressions = $expressions;
			shuffle($expressions);
			
			$index = 0;
			foreach ($shuffled_expressions as $random_expression) {
				if ($expression->definition_id == $random_expression->definition_id) 
					continue;
				
				if ($index > 1)
					break;
				
				$index += 1;
				
				$alternative = new stdClass();
				$alternative->expression_id = $random_expression->id;
				$alternative->definition_id = $random_expression->definition_id;
				$alternative->text = $random_expression->text;
				$alternative->description = $random_expression->description;
				$alternative->order = $index; // 0 is the dummy_alternative
				$question->alternatives[] = $alternative;
			}
			
			// shuffle alternatives, otherwise the first is always the right one
			shuffle($question->alternatives);
			
			$questions[] = $question;
		}
		
		return $questions;
	}
	
}
