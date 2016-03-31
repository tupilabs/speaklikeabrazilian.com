					<div class="ui fluid card">
					  	<div class="content">
                            @if (!isset($hide_votes) or !$hide_votes)
	   						<a data-definitionid='{{ $definition["id"] }}' class='dislike right floated'><small class='dislike_count'>{{ $definition['dislikes'] or 0 }}</small> <i class="thumbs down outline icon"></i></a>
	   						<a data-definitionid='{{ $definition["id"] }}' class='like right floated'><small class='like_count'>{{ $definition['likes'] or 0 }}</small> <i class="right floated thumbs up outline icon"></i></a>
                            @endif
					    	<div class="header"><a href="{{ URL::to($selected_language['slug'] . '/expression/define') }}?e={{ urlencode($definition['text']) }}">{{ urldecode($definition['text']) }}</a><a class='tts' href="http://translate.google.com/translate_tts?ie=UTF-8&total=1&idx=0&textlen=32&client=tw-ob&q={{ $definition['text'] }}&tl=pt-br"><i class="unmute icon"></i></a></div>
					    	<div class="meta">
					    		<span class="right floated time"><small>{{ '@'.$definition['contributor'] }}</small></span>
					    		<span class="category"><small>{{ date('F jS \\a\\t g:ia', $definition['created_at']) }}</small></span>
					    	</div>
					    	<div class="description">
								<p>{!! html_entity_decode(
                                            get_definition_formatted_text(
                                                $definition['description'],
                                                $selected_language
                                            )
                                        ) !!}</p>

								<p><i>Examples</i></p>
								<p style='font-style: italic;'>
									{!! html_entity_decode(
                                            get_definition_formatted_text(
                                                $definition['example'],
                                                $selected_language
                                            )
                                        ) !!}
								</p>
                                @if (isset($definition['medias']) and count($definition['medias']) > 0)
								<div class='expression media'>
                                    @foreach ($definition['medias'] as $media)
                                    @if ($media['content_type'] == 'video/youtube')
                                    <?php $data = get_video_data($media) ?>
									<a 
                                        class='ui small icon button video-colorbox' 
                                        title="{{ $definition['text'] }}" 
                                        @if (array_has($data, 't'))
                                        href="http://www.youtube.com/embed/{{ $data['video_id'] }}?wmode=opaque&start={{ $data['t'] }}">
                                        @else
                                        href="http://www.youtube.com/embed/{{ $data['video_id'] }}?wmode=opaque">
                                        @endif
                                        <i class="film icon"></i>
                                    </a>
                                    @else
									<a class='ui small icon button image-colorbox' title="{{ $definition['text'] }}" href="{{ $media['url'] }}"><i class="photo icon"></i></a>
                                    @endif
                                    @endforeach
								</div>
                                @endif
						    </div>
					  	</div>
					  	<div class='extra content'>
					    	<p class='left floated'>
                                <small>
                                    See also: 
                                    @foreach (explode(',', $definition['tags']) as $tag)
                                    <a href="{{ action('ExpressionController@getDefine') }}?e={{ urlencode(trim($tag)) }}">{{ trim($tag) }}</a>
                                    @endforeach
                                </small>
                            </p>
                            @if (!isset($hide_links) or !$hide_links)
					    	<span class='right floated'>
					    		<small>
					    		<a href="{{ action('ExpressionController@getAddimage') }}?definition_id={{ $definition['id'] }}"><i class="plus icon"></i>picture</a>
					    		<a href="{{ action('ExpressionController@getAddvideo') }}?definition_id={{ $definition['id'] }}"><i class="plus icon"></i>video</a>
                                <a 
                                    target="_blank" 
                                    title="Share this expression on Twitter" 
                                    href="https://twitter.com/share?text=Learn what is '{{ $definition['text'] }}' via @SpeakLikeABR&url={{ action('ExpressionController@getDefine') }}?e={{ urlencode($definition['text']) }}">
                                    <i class="twitter icon"></i>tweet
                                </a>
					    		</small>
					    	</span>
                            @endif
					    </div>
					</div>