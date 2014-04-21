<?php 

use Magniloquent\Magniloquent\Magniloquent;

class Definition extends Magniloquent {

	protected $table = 'definitions';

    protected $guarded = array();

    protected $fillable = array('expression_id', 'description', 'example', 'tags', 'status', 'email', 'contributor', 'moderator_id');

    public static $rules = array(
	  "save" => array(
	  	'expression_id' => 'required|numeric',
	  	'description' => 'required|min:3|max:1000',
	  	'example' => 'required|min:3|max:1000',
	  	'tags' => 'required|min:3|max:100',
	    'status' => '',
	    'email' => 'required|email',
	    'contributor' => 'required|min:3',
	    'moderator_id' => ''
	  ),
	  "create" => array(
	  ),
	  "update" => array(
	  )
	);

	public function expression()
	{
		return $this->belongsTo('Expression');
	}

	public function ratings() 
	{
		return $this->hasMany('Rating');
	}

	public function medias()
	{
		return $this->hasMany('Media');
	}

	// public function likes()
	// {
	// 	return Rating::where('definition_id', $this->id)->where('rating', 1)->count();
	// }

	// public function dislikes()
	// {
	// 	return Rating::where('definition_id', $this->id)->where('rating', -1)->count();
	// }

}