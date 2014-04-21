<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="nav-header">
    <div class="navbar-collapse" id="navbar-collapse-01" style="">
    	<a href="{{ URL.to('/') }}" class='btn btn-menu navbar-btn btn-xs'>SLBR Home</a>
    	<a href="{{ URL.to('/links/') }}" class='btn btn-sm navbar-btn btn-inverse btn-xs'>Links</a>
    	<a href="http://twitter.com/SpeakLikeABR" class='btn btn-sm navbar-btn btn-inverse btn-xs'>@SpeakLikeABR</a>
    	<a href="http://facebook.com/SpeakLikeABrazilian" class='btn btn-sm navbar-btn btn-inverse btn-xs'>Facebook Fan Page</a>
    	<a href="{{ URL.to('/moderators/') }}" class='btn btn-sm btn-info navbar-btn btn-xs'>Moderators area</a>
	</div>
</nav>
<section id='header'>
    <div class='container'>
        <div class='row'>
            <div class='col-xs-12'>
				<a href="{{ URL.to('/') }}">Speak Like A Brazilian<img src="{{ URL.to('/themes/default/assets/img/slbr.png') }}" class="logo" alt="Speak Like A Brazilian | Learn Portuguese" title="Speak Like A Brazilian | Learn Portuguese" /></a>
			</div>
	    </div>
	    <div class='row'>
			<div class='col-sm-offset-2 col-md-offset-3 col-lg-offset-3 col-sm-8 col-md-6 col-lg input-append' id="search">
				{{ Form.open({'url': 'search', 'class': 'form-search', 'method': 'get'}) }}
					<div class='form-group'>
						<div class='input-group'>
							<input 
								class="form-control input-sm" 
								type="text" 
								id="q" 
								name="q" 
								value="{{ query }}" 
								placeholder="Search for expressions in English or Portuguese" />
							<span class='input-group-btn'>
								<button type="submit" class="btn btn-inverse input-sm">
									<span class='fui-search'></span>
								</button>	
							</span>
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
