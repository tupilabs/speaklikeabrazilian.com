<?php

/**
 * Ratings model config
 */

return array(

	'title' => 'Languages',

	'single' => 'language',

	'model' => 'Language',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'number'
		),
		'slug' => array(
			'title' => 'Slug',
			'type' => 'text'
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'text'
		),
	    'local_description' => array(
	    	'title' => 'Description in local language',
	    	'type' => 'text'
	    ),
	    'created_at' => array(
	    	'title' => 'Created at',
	    	'type' => 'datetime'
	    ),
	    'updated_at' => array(
	    	'title' => 'Updated at',
	    	'type' => 'datetime'
	    )
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'slug' => array(
			'title' => 'Slug',
			'type' => 'text'
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'text'
		),
	    'local_description' => array(
	    	'title' => 'Description in local language',
	    	'type' => 'text'
	    ),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'number'
		),
		'slug' => array(
			'title' => 'Slug',
			'type' => 'text'
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'text'
		),
	    'local_description' => array(
	    	'title' => 'Description in local language',
	    	'type' => 'text'
	    ),
	),

);