<?php

class LinksController extends BaseController {

	public function getLinks() 
	{
		return $this->theme->scope('links')->render();
	}

}
