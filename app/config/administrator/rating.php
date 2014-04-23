<?php

/**
 * Ratings model config
 */

return array(

	'title' => 'Ratings',

	'single' => 'rating',

	'model' => 'Rating',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'definition' => array(
			'title' => 'Definition',
			'relationship' => 'definition',
			'select' => "(:table).description",
			'sortable' => false
		),
		'user_ip' => array(
			'title' => 'User IP',
			'type' => 'text',
			'sortable' => false
		),
		'rating' => array(
			'title' => 'Rating',
			'type' => 'number'
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
		'user_ip' => array(
			'title' => 'User IP',
			'type' => 'text',
			'sortable' => false
		),
		'rating' => array(
			'title' => 'Rating',
			'type' => 'number'
		),
		'definition_id' => array(
			'title' => 'Definition ID',
			'type' => 'number'
		)
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'definition' => array(
			'title' => 'Definition',
			'type' => 'relationship',
			'name_field' => 'description'
		),
		'user_ip' => array(
			'title' => 'User IP',
			'type' => 'text',
			'sortable' => false
		),
		'rating' => array(
			'title' => 'Rating',
			'type' => 'number'
		)
	),

);