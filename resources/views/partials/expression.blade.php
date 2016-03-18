					<div class="ui fluid card">
					  	<div class="content">
	   						<a class='right floated'><small>{{ $definition['dislikes'] or 0 }}</small> <i class="thumbs down outline icon"></i></a>
	   						<a class='right floated'><small>{{ $definition['likes'] or 0 }}</small> <i class="right floated thumbs up outline icon"></i></a>
					    	<div class="header"><a>{{ $definition['text'] }}</a><a><i class="unmute icon"></i></a></div>
					    	<div class="meta">
					    		<span class="right floated time"><small>{{ '@'.$definition['contributor'] }}</small></span>
					    		<span class="category"><small>{{ date('F jS \\a\\t g:ia', $definition['created_at']) }}</small></span>
					    	</div>
					    	<div class="description">
								<p>{{ $definition['description'] }}</p>

								<p><i>Examples</i></p>
								<p style='font-style: italic;'>
									{{ $definition['example'] }}
								</p>
								<div class='expression media'>
									<button class='ui small icon button'><i class="photo icon"></i></button>
									<button class='ui small icon button'><i class="photo icon"></i></button>
									<button class='ui small icon button'><i class="film icon"></i></button>
								</div>
						    </div>
					  	</div>
					  	<div class='extra content'>
					    	<p class='left floated'>
                                <small>
                                    See also: {{ $definition['tags'] }}
                                </small>
                            </p>
					    	<span class='right floated'>
					    		<small>
					    		<a><i class="plus icon"></i>picture</a>
					    		<a><i class="plus icon"></i>video</a>
					    		<a class=''><i class="twitter icon"></i>tweet</a>
					    		</small>
					    	</span>
					    </div>
					</div>