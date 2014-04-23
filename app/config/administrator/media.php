<?php

/**
 * Medias model config
 */

return array(

	'title' => 'Medias',

	'single' => 'media',

	'model' => 'Media',

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
		'url' => array(
			'title' => 'URL',
			'type' => 'text',
			'sortable' => false
		),
		'reason' => array(
			'title' => 'Reason',
			'type' => 'text',
			'sortable' => false	
		),
		'status' => array(
			'title' => 'Status',
			'type' => 'number'
		),
		'content_type' => array(
			'title' => 'Content Type',
			'type' => 'text'
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
		'content_type' => array(
			'title' => 'Content Type',
			'type' => 'text'
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
		'url' => array(
			'title' => 'URL',
			'type' => 'text',
			'sortable' => false
		),
		'reason' => array(
			'title' => 'Reason',
			'type' => 'text',
			'sortable' => false	
		),
		'status' => array(
			'title' => 'Status',
			'type' => 'number'
		),
		'content_type' => array(
			'title' => 'Content Type',
			'type' => 'text'
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
		)
	),

);