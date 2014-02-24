<section id='nav-header'>
	<div class='container'>
		<div class='row'>
			<div class='span12'>
				<ul>
					<li><a class='btn btn-mini btn-menu' href='{{ URL.to('/') }}'>SLBR Home</a></li>
            		<li><a class='btn btn-mini' href='{{ URL.to('/blog/') }}'>Blog</a></li>
            		<li><a class='btn btn-mini' href='{{ URL.to('/apps/sentences/') }}'>Sentences</a></li>
            		<li><a class='btn btn-mini' href='{{ URL.to('/apps/quiz/') }}'>Quiz</a></li>
            		<li><a class='btn btn-mini' href='{{ URL.to('/links/') }}'>Links</a></li>
            		<li><a class='btn btn-mini' href='http://twitter.com/SpeakLikeABR'>@SpeakLikeABR</a></li>
            		<li><a class='btn btn-mini' href='http://facebook.com/SpeakLikeABrazilian'>FaceBook Fan Page</a></li>
            		<li><a class='btn btn-mini btn-info' href='{{ URL.to('/moderators/') }}'>Moderators area</a></li>
            		<div id="fb-root"></div>
            		<!-- div class="fb-like" data-href="https://www.facebook.com/SpeakLikeABrazilian" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div -->
            	</ul>
			</div>
		</div>
	</div>
</section>
<section id='header'>
    <div class='container'>
        <div class='row'>
            <div class='span12'>
				<a href="{{ URL.to('/') }}">Speak Like A Brazilian<img src="{{ URL.to('/themes/default/assets/img/slbr.png') }}" class="logo" alt="Speak Like A Brazilian | Learn Portuguese" title="Speak Like A Brazilian | Learn Portuguese" /></a>
			</div>
	    </div>
	    <div class='row'>
			<div class='span12 input-append' id="search">
				{{ Form.open({'url': 'search', 'class': 'form-search', 'method': 'get'}) }}
				<input 
					class="search-query input-xxlarge" 
					type="text" 
					id="q" 
					name="q" 
					value="{{ query }}" 
					placeholder="Search for expressions in English or Portuguese" />
				<button type="submit" class="btn btn-inverse"><i class='icon-search'></i> Search</button>
				{{ Form.close() }}
			</div>
		</div>
    </div>
</section>
<section id="menu">
	<div class='container-fluid'>
        <div class='row-fluid'>
    	    {% include 'partials/menu.twig.php' %}
        </div>
    </div>
</section>
