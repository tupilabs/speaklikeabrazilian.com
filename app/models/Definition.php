<?php 
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2013-2014 TupiLabs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use Magniloquent\Magniloquent\Magniloquent;

class Definition extends Magniloquent {

	protected $table = 'definitions';

    protected $guarded = array();

    protected $fillable = array('expression_id', 'description', 'example', 'tags', 'status', 'email', 'contributor', 'moderator_id', 'language_id');

    public static $rules = array(
	  "save" => array(
	  	'expression_id' => 'required|numeric',
	  	'description' => 'required|min:3|max:1000',
	  	'example' => 'required|min:3|max:1000',
	  	'tags' => 'required|min:3|max:100',
	    'status' => '',
	    'email' => 'required|email',
	    'contributor' => 'required|min:3',
	    'moderator_id' => '',
	    'language_id' => 'required|numeric'
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