<?php

/**
 * Subscriptions model config
 */

return array(

	'title' => 'Subscriptions',

	'single' => 'subscription',

	'model' => 'Subscription',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'ip' => array(
			'title' => 'IP Address',
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
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'ip' => array(
			'title' => 'IP Address',
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