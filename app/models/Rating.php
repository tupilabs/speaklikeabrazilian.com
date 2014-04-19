<?php

use Magniloquent\Magniloquent\Magniloquent;

class Rating extends Magniloquent {

	protected $table = 'ratings';

	protected $guarded = array();

    protected $fillable = array('definition_id', 'user_ip', 'rating');

    public static $rules = array(
	  "save" => array(
	  	'definition_id' => 'required|numeric',
	  	'user_ip' => 'required|min:3|max:50',
	  	'rating' => 'required|numeric'
	  ),
	  "create" => array(
	  ),
	  "update" => array(
	  )
	);

}
