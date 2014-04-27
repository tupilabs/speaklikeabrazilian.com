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
		'first_name' => array(
			'title' => 'First Name',
			'type' => 'text'
		),
		'last_name' => array(
			'title' => 'Last Name',
			'type' => 'text'
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
		'activated' => array(
			'title' => 'Activated?',
			'type' => 'bool'
	    ),
	    'groups' => array(
	    	'title' => '# Groups',
	    	'relationship' => 'groups',
	    	'select' => "COUNT((:table).id)"
	    )
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
	    'first_name' => array(
			'title' => 'First Name',
			'type' => 'text'
		),
		'last_name' => array(
			'title' => 'Last Name',
			'type' => 'text'
		),
		'email' => array(
			'title' => 'E-mail'
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
		'first_name' => array(
			'title' => 'First Name',
			'type' => 'text'
		),
		'last_name' => array(
			'title' => 'Last Name',
			'type' => 'text'
		),
		'activated' => array(
			'title' => 'Activated?',
			'type' => 'bool'
	    ),
	),

);