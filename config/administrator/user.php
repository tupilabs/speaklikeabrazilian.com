<?php

/**
 * Users model config
 */

return array(

    'title' => 'Users',

    'single' => 'user',

    'model' => '\Cartalyst\Sentinel\Users\EloquentUser',

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
        'activations' => array(
            'title' => 'Activations',
            'relationship' => 'activations',
            'select' => "COUNT((:table).id)"
        ),
        'roles' => array(
            'title' => 'Roles',
            'relationship' => 'roles',
            'select' => "COUNT((:table).id)"
        )
    ),

    /**
     * The filter set
     */
    'filters' => array(
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
        'user_id' => array(
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
        'roles' => array(
            'title' => 'Roles',
            'type' => 'relationship',
            'name_field' => 'name'
        ),
        'password' => array(
            'title' => 'Password',
            'type' => 'password'
        ),
        
    ),

);