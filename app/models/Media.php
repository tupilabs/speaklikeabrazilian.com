<?php

use Magniloquent\Magniloquent\Magniloquent;

class Media extends Magniloquent {

	protected $table = 'medias';

	protected $guarded = array();

    protected $fillable = array('definition_id', 'url', 'reason', 'email', 'status', 'content_type', 'contributor', 'moderator_id');

    public static $rules = array(
	  "save" => array(
	  	'definition_id' => 'required|numeric',
	  	'url' => 'required|url|max:255',
	  	'reason' => 'required|min:3|max:500',
	  	'email' => 'required|email',
	  	'status' => 'required|numeric',
	  	'content_type' => 'required|min:1|max:20',
	  	'contributor' => 'required|min:1|max:50',
	  	'moderator_id' => ''
	  ),
	  "create" => array(
	  ),
	  "update" => array(
	  )
	);

}
