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

	public function definition()
	{
		return $this->belongsTo('Definition');
	}

	public function getVideoData() 
	{
		$data = array();
		$url = $this->url;
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->url, $match))
		{
			$data['video_id'] = $match[1];
		}
		if (preg_match('%(?:t=)([0-9]+)%i', $this->url, $match)) 
		{
			$data['t'] = $match[1];
		}
		return $data;
	}

}
