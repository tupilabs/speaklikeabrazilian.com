<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- TODO: add language locale -->
        <meta http-equiv="content-language" content="en" />
        <title>{{ Theme.get('title') }}</title>
        <meta name="author" content="TupiLabs">
		<meta name="keywords" content="learn portuguese, aprender portugues, portuguese translator, portuguese dictionary, Speak Like A Brazilian" />
        <meta name="description" content="Your place to learn common daily Brazilian Portuguese expressions and slangs">
        <meta property="og:image" content="{{ URL.to('themes/default/assets/img/icon-facebook.gif') }}" />
        <meta property="og:title" content="Speak Like A Brazilian" />
		<meta property="og:site_name" content="Speak Like A Brazilian" />
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL.to('/favicon.ico') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <!-- Apple devices Homescreen icon -->
        <link rel="apple-touch-icon-precomposed" href="{{ URL.to('themes/default/assets/img/apple-touch-icon-precomposed.png') }}" />
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        {{ Theme.asset().styles() }}
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head>
    <body>
    	<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=221891907922920";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
       	{{ Theme.partial('header') }}

		{{ Theme.content() }}

		{{ Theme.partial('footer') }}
		
		{{ Theme.asset().scripts() }}

		<script type='text/javascript'>
function maincallback() {
	$(document).ajaxStop(jQuery.unblockUI);
	$.jGrowl.defaults.closerTemplate = '<div>[ Close all ]</div>';
	$(document).ready(function() {
		{% if tooltip is not defined %}
			{% set tooltip = Session.get('tooltip') %}
		{% endif %}
		{% if message is not defined %}
			{% set message = Session.get('message') %}
		{% endif %}
		{% if warning is not defined %}
			{% set warning = Session.get('warning') %}
		{% endif %}
		{% if success is not defined %}
			{% set success = Session.get('success') %}
		{% endif %}
		{% if tooltip is defined and tooltip is not empty %}
			{% if tooltip[0] is defined %}
				{% for tp in tooltip %}
				$.jGrowl('{{ tp }}', { sticky: true , position: 'top-right', glue: 'after', closer: true});
				{% endfor %}
			{% else %}
				$.jGrowl('{{ tooltip }}', { sticky: true , position: 'top-right'});
			{% endif %}
		{% endif %}
		{% if message is defined and message is not empty %}
			{% if message[0] is defined %}
				{% for msg in message %}
				$.jGrowl('{{ msg }}', { sticky: true , position: 'top-right', glue: 'after', closer: true});
				{% endfor %}
			{% else %}
				$.jGrowl('{{ message }}', { sticky: true , position: 'top-right'});
			{% endif %}
		{% endif %}
		{% if errors is defined %}
			{% for err in errors.all() %}
			$.jGrowl('{{ err }}', { sticky: true , position: 'top-right', glue: 'after', closer: true});
			{% endfor %}
		{% endif %}
		{% if warning is defined and warning is not empty %}
			{% if warning[0] is defined %}
				{% for warn in warning %}
				$.jGrowl('{{ warn }}', { sticky: true , position: 'top-right', glue: 'after', closer: true});
				{% endfor %}
			{% else %}
				$.jGrowl('{{ warning }}', { sticky: true , position: 'top-right'});
			{% endif %}
		{% endif %}
		{% if success is defined and success != '' %}
			{% if success[0] is defined %}
				{% for msg in success %}
				$.jGrowl('{{ msg }}', { sticky: true , position: 'top-right', glue: 'after', closer: true});
				{% endfor %}
			{% else %}
				$.jGrowl('{{ success }}', { sticky: true , position: 'top-right'});
			{% endif %}
		{% endif %}
	});
}
		</script>
    </body>
</html>