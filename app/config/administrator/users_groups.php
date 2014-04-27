<?php

/**
 * User Groups model config
 */

return array(

	'title' => 'Users Groups',

	'single' => 'users group',

	'model' => 'UsersGroups',

	/**
	 * The display columns
	 */
	'columns' => array(
		'user_id' => array(
			'title' => 'User ID',
			'type' => 'key'
		),
		'group_id' => array(
			'title' => 'Group ID',
			'type' => 'key'
		),
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'user_id' => array(
			'title' => 'User ID',
			'type' => 'key'
		),
		'group_id' => array(
			'title' => 'Group ID',
			'type' => 'key'
		),
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'user_id' => array(
			'title' => 'User ID',
			'type' => 'text'
		),
		'group_id' => array(
			'title' => 'Group ID',
			'type' => 'text'
		),
	),

);