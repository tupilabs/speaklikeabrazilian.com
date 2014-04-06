<?php

use Magniloquent\Magniloquent\Magniloquent;

class Expression extends Magniloquent {

	protected $table = 'expressions';

    protected $guarded = array();

    protected $fillable = array('text', 'char', 'contributor', 'moderator_id');

    public static $rules = array(
	  "save" => array(
	    'text' => 'required|min:3',
	    'char'    => 'required|min:1|max:1',
	    'contributor' => 'required|min:3'
	  ),
	  "create" => array(
	    'text'              => 'unique:expressions',
	  ),
	  "update" => array(
	  	'text'              => 'unique:expressions',
	  )
	);

	/*protected static $relationships = array(
        'trophies' => array('hasMany', 'Trophy'),
        'team'     => array('belongsTo', 'Team', 'team_id'),
        'sports'   => array('belongsToMany', 'Sport', 'athletes_sports', 'athlete_id', 'sport_id')
    );*/
}
