<?php

class HomeController extends BaseController {

	public function getIndex()
	{
		return $this->theme->scope('home.index')->render();
	}

}