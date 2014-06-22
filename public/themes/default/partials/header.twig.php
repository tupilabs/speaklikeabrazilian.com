<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="nav-header">
    <div class="navbar-collapse" id="navbar-collapse-01" style="">
    	<a href="{{ URL.action('ExpressionController@getNew') }}" class='btn btn-menu navbar-btn btn-xs'>SLBR Home</a>
    	<a href="http://twitter.com/SpeakLikeABR" class='btn btn-sm navbar-btn btn-inverse btn-xs'>@SpeakLikeABR</a>
    	<a href="http://facebook.com/SpeakLikeABrazilian" class='btn btn-sm navbar-btn btn-inverse btn-xs'>Facebook Fan Page</a>
    	<a href="{{ URL.action('ModeratorController@getModerators') }}" class='btn btn-sm btn-info navbar-btn btn-xs'>Moderators area</a>
    	<a href='{{ URL.to('/en') }}' class=''><img src='/themes/default/assets/img/flags/flag_great_britain.png' width="24px" /></a>
    	<a href='{{ URL.to('/es') }}' class=''><img src='/themes/default/assets/img/flags/flag_spain.png' width="24px" /></a>
    	<a href='{{ URL.to('/it') }}' class=''><img src='/themes/default/assets/img/flags/flag_italy.png' width="24px" /></a>
    	<a href='{{ URL.to('/pt') }}' class=''><img src='/themes/default/assets/img/flags/flag_portugal.png' width="24px" /></a>
    	<a href='{{ URL.to('/jp') }}' class=''><img src='/themes/default/assets/img/flags/flag_japan.png' width="24px" /></a>
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
				{{ Form.open({'url': '/search', 'class': 'form-horizontal', 'id': 'searchFrom', 'method': 'get', 'role': 'search'}) }}
					<div class="input-group">
			            <input type="text" value="{{ Theme.get('q') }}" class="form-control input-sm" placeholder="Search" name="q" id="q">
			            <div class="input-group-btn">
			                <button class="btn btn-default input-sm" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			            </div>
			        </div>
				{{ Form.close() }}
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
