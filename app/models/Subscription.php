<?php 

use Magniloquent\Magniloquent\Magniloquent;

class Subscription extends Magniloquent {

	protected $table = 'subscriptions';

    protected $guarded = array();

    protected $fillable = array('email', 'ip');

    public static $rules = array(
	  "save" => array(
	  	'email' => 'required|email|max:255|unique:subscriptions',
	  	'ip' => ''
	  ),
	  "create" => array(
	  ),
	  "update" => array(
	  )
	);

}