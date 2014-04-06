<?php 

use \Eloquent;

class Definition extends Eloquent {

	protected $table = 'definitions';

	public function expression()
	{
		return $this->belongsTo('Expression')->first();
	}

	public function ratings() 
	{
		return $this->hasMany('Rating')->get();
	}

	public function likes()
	{
		return Rating::where('definition_id', $this->id)->where('rating', 1)->count();
	}

	public function dislikes()
	{
		return Rating::where('definition_id', $this->id)->where('rating', -1)->count();
	}

}