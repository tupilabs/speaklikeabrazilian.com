<?php

class ExpressionController extends BaseController {

	public function getDefine()
	{
		$expression = Input::get('e');
		$definitions = API::get(sprintf('api/v1/definition?e=%s', $expression));
		$args = array();
		$args['definitions'] = $definitions;
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getLetter($letter)
	{
		$definitions = API::get(sprintf('api/v1/expressions/letters/%s', $letter));
		$args = array();
		$args['definitions'] = $definitions;
		return $this->theme->scope('home.index', $args)->render();
	}

	public function getAdd()
	{
		return $this->theme->scope('expression.add')->render();
	}

	public function postAdd()
	{
		DB::beginTransaction();

		try 
		{
			// Get existing expressions
			$expression = API::get(sprintf('api/v1/expressions/search?e=%s', Input::get('text')));
			if (count($expression) <= 0)
			{
				$expression = API::post('api/v1/expressions/', array(
					'text' => Input::get('text'),
					'char' => strtoupper(substr(Input::get('text'), 0, 1)),
					'contributor' => Input::get('pseudonym')
				));

				if (!$expression->isValid() || !$expression->isSaved())
				{
					return Redirect::to('expression/add')
						->withInput()
						->withErrors($expression->errors());
				}
			}

			$definition = API::post(sprintf('api/v1/expressions/%d/definitions', $expression->id), array(
				'description' => Input::get('definition'),
				'example' => Input::get('example'),
				'tags' => Input::get('tags'),
				'status' => 1,
				'email' => Input::get('email'),
				'contributor' => Input::get('pseudonym'),
				'moderator_id' => NULL
			));

			if ($definition->isValid() && $definition->isSaved())
			{
				DB::commit();
				return Redirect::to('/')->with('success', 'Expression added!');
			} 
			else
			{
				DB::rollback();
				return Redirect::to('expression/add')
					->withInput()
					->withErrors($definition->errors());
			}
		} 
		catch (\Exception $e) 
		{
			DB::rollback();
			return Redirect::to('/')->with('error', $e->getMessage());
		}

/*
		
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
		redirect('/');*/
	}

}