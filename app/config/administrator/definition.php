<?php

/**
 * Expressions model config
 */

return array(

	'title' => 'Definitions',

	'single' => 'definition',

	'model' => 'Definition',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'expression' => array(
			'title' => 'Expression',
			'relationship' => 'expression',
			'select' => "(:table).text",
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'textarea',
			'sortable' => false
		),
		'tags' => array(
			'title' => 'Tags',
			'type' => 'text',
			'sortable' => false
		),
		'status' => array(
			'title' => 'Status',
			'type' => 'number'
		),
		'contributor' => array(
			'title' => 'Contributor',
			'type' => 'text', 
			'sortable' => false
		),
		'email' => array(
			'title' => 'E-mail',
			'type' => 'text', 
			'sortable' => false
		),
		'ratings' => array(
			'title' => '# Ratings',
			'relationship' => 'ratings',
			'select' => "COUNT((:table).id)"
		),
		'moderator_id' => array(
			'title' => 'Moderator ID',
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
		'status' => array(
			'title' => 'Status',
			'type' => 'number'
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'expression' => array(
			'title' => 'Expression',
			'type' => 'relationship',
			'name_field' => "text",
		),
		'description' => array(
			'title' => 'Description',
			'type' => 'textarea',
			'sortable' => false
		),
		'tags' => array(
			'title' => 'Tags',
			'type' => 'text',
			'sortable' => false
		),
		'status' => array(
			'title' => 'Status',
			'type' => 'number'
		),
		'contributor' => array(
			'title' => 'Contributor',
			'type' => 'text', 
			'sortable' => false
		),
		'email' => array(
			'title' => 'E-mail',
			'type' => 'text', 
			'sortable' => false
		),
		'moderator_id' => array(
			'title' => 'Moderator ID',
			'type' => 'number'
	    ),
	),

);