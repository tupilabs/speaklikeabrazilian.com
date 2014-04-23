<?php

/**
 * Expressions model config
 */

return array(

	'title' => 'Expressions',

	'single' => 'expression',

	'model' => 'Expression',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'char' => array(
			'title' => 'Letter',
			'type' => 'text'
		),
		'text' => array(
			'title' => 'Text', 
			'type' => 'text',
			'sortable' => false
		),
		'definitions' => array(
			'title' => '# Definitions',
			'relationship' => 'definitions',
			'select' => "COUNT((:table).id)"
		),
		'contributor' => array(
			'title' => 'Contributor',
			'type' => 'text'
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
		'char' => array(
			'title' => 'Letter',
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
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'text' => array(
			'title' => 'Text', 
			'type' => 'text'
		),
		'char' => array(
			'title' => 'Letter',
			'type' => 'text'
		),
		'contributor' => array(
			'title' => 'Contributor',
			'type' => 'text'
		), 
		'moderator_id' => array(
			'title' => 'Moderator ID',
			'type' => 'number'
	    )
	),

);