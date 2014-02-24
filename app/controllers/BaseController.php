<?php

use \Session;

class BaseController extends Controller {

	/**
	 * Application Theme
	 * @var \Teepluss\Theme\Theme
	 */
	protected $theme;
	
	public function __construct()
	{
		$this->theme = Theme::uses('default'); // FIXME: get theme name from config or DB
		$this->theme->setTitle('Speak Like A Brazilian'); // FIXME: get it from the configs or DB
	}
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}