<?php

/**
 * Users model config
 */

return array(

    'title' => 'Activations',

    'single' => 'activation',

    'model' => '\Cartalyst\Sentinel\Activations\EloquentActivation',

    /**
     * The display columns
     */
    'columns' => array(
        'id' => array(
            'title' => 'ID',
            'type' => 'key'
        ),
        'code' => array(
            'title' => 'Code',
            'type' => 'text'
        ),
        'completed' => array(
            'title' => 'Completed?',
            'type' => 'bool'
        ),
        'completed_at' => array(
            'title' => 'Completed At',
            'type' => 'datetime',
            'date_format' => 'yy-mm-dd',
            'time_format' => 'HH:mm',
        )
    ),

    /**
     * The filter set
     */
    'filters' => array(
        'id' => array(
            'title' => 'ID',
            'type' => 'key'
        ),
        'code' => array(
            'title' => 'Code',
            'type' => 'text'
        ),
        'completed' => array(
            'title' => 'Completed?',
            'type' => 'bool'
        ),
        'completed_at' => array(
            'title' => 'Completed At',
            'type' => 'datetime',
            'date_format' => 'yy-mm-dd',
            'time_format' => 'HH:mm',
        )
    ),

    /**
     * The editable fields
     */
    'edit_fields' => array(
        'code' => array(
            'title' => 'Code',
            'type' => 'text'
        ),
        'completed' => array(
            'title' => 'Completed?',
            'type' => 'bool'
        ),
        'completed_at' => array(
            'title' => 'Completed At',
            'type' => 'datetime',
            'date_format' => 'yy-mm-dd',
            'time_format' => 'HH:mm',
        ),
        'user_id' => array(
            'title' => 'User ID',
            'type' => 'number'
        ),
    ),

);