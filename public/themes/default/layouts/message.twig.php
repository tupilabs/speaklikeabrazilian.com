<!doctype html>
<html lang="en" style='background-color: #EEEEEE; width: 100%; height: 100%;'>
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
        <link rel="shortcut icon" type="image/x-icon" href="{{ base_url }}favicon.ico">
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
    </head>
    <body style='background-color: #EEEEEE; width: 100%; height: 100%;'>
		{{ Theme.content() }}
		
		{{ Theme.asset().scripts() }}
        <script type='text/javascript'>
function maincallback() {}
        </script>
    </body>
</html>