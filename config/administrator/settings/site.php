<?php

/**
 * The main site settings page
 */

return array(

    /**
     * Settings page title
     *
     * @type string
     */
    'title' => 'Site Settings',

    /**
     * The edit fields array
     *
     * @type array
     */
    'edit_fields' => array(
        'site_name' => array(
            'title' => 'SLBR',
            'type' => 'text',
            'limit' => 50,
        )
    ),

    'actions' => array(
        //Ordering an item up
        'clear_page_cache' => array(
            'title' => 'Clear Page Cache',
            'messages' => array(
                'active' => 'Clearing cache...',
                'success' => 'Page Cache Cleared',
                'error' => 'There was an error while clearing the page cache',
            ),
            //the settings data is passed to the closure and saved if a truthy response is returned
            'action' => function(&$data)
            {
                Cache::forget('pages');
                return true;
            }
        ),
    ),
    
);