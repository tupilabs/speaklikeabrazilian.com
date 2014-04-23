<?php

/**
 * Users model config
 */

return array(

	'title' => 'Users',

	'single' => 'user',

	'model' => 'User',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'email' => array(
			'title' => 'E-mail'
		),
		'password' => array(
			'title' => 'Password',
			'type' => 'password',
			'sortable' => false,
			'output' => function($value)
			{
				return "******";
			}
		),
		'permissions' => array(
			'title' => 'Permissions',
			'output' => function($value) 
			{
				return var_export($value, true);
			}
		), 
		'activated' => array(
			'title' => 'Activated?',
			'type' => 'bool'
	    ),
		// 'isSuperUser' => array(
		// 	'title' => 'Super user?'
		// )
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'activated' => array(
			'title' => 'Activated?',
			'type' => 'bool'
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
		'email' => array(
			'title' => 'E-mail'
		),
		'activated' => array(
			'title' => 'Activated?',
			'type' => 'bool'
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

);