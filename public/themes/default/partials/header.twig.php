<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="nav-header">
    <div class="navbar-collapse" id="navbar-collapse-01" style="">
    	<a href="{{ URL.action('ExpressionController@getNew') }}" class='btn btn-menu navbar-btn btn-xs'>SLBR Home</a>
    	<a href="http://twitter.com/SpeakLikeABR" class='btn btn-sm navbar-btn btn-inverse btn-xs'>@SpeakLikeABR</a>
    	<a href="http://facebook.com/SpeakLikeABrazilian" class='btn btn-sm navbar-btn btn-inverse btn-xs'>Facebook Fan Page</a>
    	<a href="{{ URL.action('ModeratorController@getModerators') }}" class='btn btn-sm btn-info navbar-btn btn-xs'>Moderators area</a>
    	<a href='{{ URL.to('/en') }}' class=''><img src='/themes/default/assets/img/flags/flag_great_britain.png' width="24px" /></a>
    	<a href='{{ URL.to('/es') }}' class=''><img src='/themes/default/assets/img/flags/flag_spain.png' width="24px" /></a>
	</div>
</nav>
<section id='header'>
    <div class='container'>
        <div class='row'>
            <div class='col-xs-12'>
				<span class='title'>Speak Like A Brazilian<img src="{{ URL.to('/themes/default/assets/img/slbr.png') }}" class="logo" alt="Speak Like A Brazilian | Learn Portuguese" title="Speak Like A Brazilian | Learn Portuguese" /></span>
			</div>
	    </div>
	    <div class='row'>
	    	<div class='col-xs-6 col-xs-offset-3'>
				<script>
				  (function() {
				    var cx = '005522759953720342982:iqpzpagyfes';
				    var gcse = document.createElement('script');
				    gcse.type = 'text/javascript';
				    gcse.async = true;
				    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
				        '//www.google.com/cse/cse.js?cx=' + cx;
				    var s = document.getElementsByTagName('script')[0];
				    s.parentNode.insertBefore(gcse, s);
				  })();
				</script>
				<gcse:searchbox-only></gcse:searchbox-only>
			</div>
		</div>
    </div>
</section>
<section id="menu">
	<div class='container-fluid'>
        <div class='row'>
    	    {% include 'partials/menu.twig.php' %}
        </div>
    </div>
</section>
