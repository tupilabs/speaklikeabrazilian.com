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
			'title' => 'Password'
		),
		'permissions' => array(
			'title' => 'Permissions',
			'output' => function($value) {
				return sprintf("[%s]", implode($value, ', '));
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
		'password' => array(
			'title' => 'Password'
		),
		'permissions' => array(
			'title' => 'Permissions',
			'output' => function($value) {
				return sprintf("[%s]", implode($value, ', '));
			}
		), 
		'activated' => array(
			'title' => 'Activated?',
			'type' => 'bool'
	    ),
	),

);