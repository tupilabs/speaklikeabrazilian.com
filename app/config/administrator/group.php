<?php

/**
 * Groups model config
 */

return array(

	'title' => 'Groups',

	'single' => 'group',

	'model' => '\Cartalyst\Sentry\Groups\Eloquent\Group',

	/**
	 * The display columns
	 */
	'columns' => array(
		'id' => array(
			'title' => 'ID',
			'type' => 'key'
		),
		'name' => array(
			'title' => 'Name',
			'type' => 'text'
		),
		'permissions' => array(
			'title' => 'Permissions',
			'type' => 'textarea',
			'sortable' => false,
			'output' => function($value)
			{
				return json_encode($value);
			}
		)
	),

	/**
	 * The filter set
	 */
	'filters' => array(
		'name' => array(
			'title' => 'Name',
			'type' => 'text'
		)
	),

	/**
	 * The editable fields
	 */
	'edit_fields' => array(
		'name' => array(
			'title' => 'Name',
			'type' => 'text'
		)
	),

);