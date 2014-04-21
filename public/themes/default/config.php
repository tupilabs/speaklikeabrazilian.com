<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials", "views" and "widgets"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => array(

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
            $theme->setTitle('Speak Like A Brazilian');

            // Breadcrumb template.
            // $theme->breadcrumb()->setTemplate('
            //     <ul class="breadcrumb">
            //     @foreach ($crumbs as $i => $crumb)
            //         @if ($i != (count($crumbs) - 1))
            //         <li><a href="{{ $crumb["url"] }}">{{ $crumb["label"] }}</a><span class="divider">/</span></li>
            //         @else
            //         <li class="active">{{ $crumb["label"] }}</li>
            //         @endif
            //     @endforeach
            //     </ul>
            // ');
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function($theme)
        {
            // You may use this event to set up your assets.
            // $theme->asset()->usePath()->add('core', 'core.js');
            // $theme->asset()->add('jquery', 'vendor/jquery/jquery.min.js');
            // $theme->asset()->add('jquery-ui', 'vendor/jqueryui/jquery-ui.min.js', array('jquery'));

            // Partial composer.
            // $theme->partialComposer('header', function($view)
            // {
            //     $view->with('auth', Auth::user());
            // });
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => array(

            'default' => function($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            }

        ),

        'asset' => function($asset) {
        	// CSS
            $asset->add('bootstrap-css', 'themes/default/assets/css/bootstrap.min.css');
            $asset->add('bootstrap-theme-css', 'themes/default/assets/css/bootstrap-theme.min.css');
            $asset->add('prettify-css', 'themes/default/assets/css/prettify.css');
            $asset->add('flatui-css', 'themes/default/assets/css/flat-ui.css');
            $asset->add('jgrowl-css', 'themes/default/assets/js/plugins/jgrowl/jquery.jgrowl.css');
            $asset->add('fancytree-css', 'themes/default/assets/css/plugins/colorbox/colorbox.css');
        	$asset->add('style-css', 'themes/default/assets/css/default.css');
			// JS
            $asset->add('jquery-js', 'themes/default/assets/js/jquery.js');
            $asset->add('bootstrap-js', 'themes/default/assets/js/bootstrap.min.js');
            $asset->add('flatui-checkbox-js', 'themes/default/assets/js/flatui-checkbox.js');
            $asset->add('jquery-blockui-js', 'themes/default/assets/js/plugins/blockui/jquery.blockUI.js');
            $asset->add('jgrowl-js', 'themes/default/assets/js/plugins/jgrowl/jquery.jgrowl_minimized.js');
            $asset->add('jquery-colorbox-js', 'themes/default/assets/js/plugins/colorbox/jquery.colorbox.js');
            //$asset->add('yui3-js', 'themes/default/assets/js/yui-min.js');
            $asset->add('aui-js', 'themes/default/assets/js/aui-min.js');
            //$asset->add('aui-form-validator-js', 'themes/default/assets/js/aui-form-validator-min.js');
            $asset->add('slbr-js', 'themes/default/assets/js/slbr.js');
            $asset->add('slbr-rating-js', 'themes/default/assets/js/rating.js');
        }

    )

);