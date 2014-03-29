<?php

class ExpressionController extends BaseController {

	public function getAdd()
	{
		return $this->theme->scope('expression.add')->render();
	}

}