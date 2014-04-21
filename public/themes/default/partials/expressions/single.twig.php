<div class='entry'>
	<div class='text'>
		<div>
			<span class='expression'>
    			{% if nolink %}
    			{{ definition.text }}
    			{% else %}
    			<a href="{{ URL.to('/expression/define?e=' ~ definition.text) }}">
    				{{ definition.text }}
    			</a>
    			{% endif %}
    			&nbsp;<a class='tts' href="http://translate.google.com/translate_tts?ie=UTF-8&amp;tl=pt&amp;q={{ definition.text }}"><span class="glyphicon glyphicon-play"></span></a>
			</span>
			<div class='rating'>
				{{ Form.open({'url': '/rate' }) }}
				<small>
					<input type="hidden" name="expressionId" value="{{ definition.expression_id }}" />
					<input type="hidden" name="definitionId" value="{{ definition.id }}" />
					<span class="like_count">{{ definition['likes']|default(0) }} </span> 
					<input type="hidden" name="rating" value="0" /> ups, 
					<span class="dislike_count">{{ definition['dislikes']|default(0) }} </span> 
					downs <a href="#" class="like"><span class="glyphicon glyphicon-thumbs-up"></span>
					</a> <a href="#" class="dislike"><span class="glyphicon glyphicon-thumbs-down"></span>
					</a>
				</small>
				{{ Form.close() }}
			</div>
			<div class="date">
				<small>{{ definition.created_at|date('F jS \\a\\t g:ia') }}</small>
			</div>
		</div>
	</div>
	<div class='description'>
		<p class='entry-paragraph'>{{ definition.description }}</p>
	</div>
	<div class='example'>
		<p class='entry-paragraph'>{{ definition.example }}</p>
	</div>
	{% set medias = definition.medias.where('status', '=', 2).get() %}
	{% if medias is not empty %}
	<div>
		{% for media in definition.medias.get %}
			{% if media.content_type == 'video/youtube' %}
				{% set data = media.getVideoData() %}
				<a style='width: 38px; display: inline' class='thumbnail colorbox' href="http://www.youtube.com/embed/{{ data.video_id }}?wmode=opaque{% if data.t is defined and data.t > 0 %}&start={{ data.t }}{% endif %}" class='colorbox'><span class="fui-video"></span></a>
			{% else %}
				<a style='width: 38px; display: inline' class='thumbnail colorbox' href='{{ media.url }}'><span class="fui-photo"></span></a>
			{% endif %}
		{% endfor %}
	</div>
	{% endif %}
	<div class='tags'>
		<small>
    		<strong>Tags</strong>
    	</small>
    	&nbsp;
		{% if definition.tags is defined %}
			{% for tag in definition.tags|split(',') %}
				{% set tag = tag|trim %}
		<span class='label label-default'><a href="{{ URL.to('expression/define?e=' ~ tag) }}" style='color: white'>{{ tag }}</a></span> 
			{% endfor %}
		{% endif %}
	</div>
	<div class='authorship'>
		<small>
    		<strong>Author</strong> <span class="">{{ definition.contributor }}
    		</span> 
    	</small>
	</div>
	<div class='entry-media'>
		<small>
    	    <strong>Media</strong>
    	</small>
	    <span class='share2'>
	    	<a class='label label-info btn-media' href="{{ URL.to('expression/' ~ definition.id) }}/videos?expressionId={{ definition.expression_id }}">+ add video</a> 
	    </span>
	    <span class='share2'>
	    	<a class='label label-info btn-media' href="{{ URL.to('expression/' ~ definition.id) }}/pictures?expressionId={{ definition.expression_id }}">+ add picture</a> 
	    </span>
		<span class=''>
			<small>
				{% set expression_text = definition.text|url_encode|url_encode(true) %}
				{% set url = URL.to('/expression/define?e='~ expression_text) %}
				<a target="_blank" class="twitter-btn" title="Share this expression on Twitter" href="https://twitter.com/share?text={{ definition.text ~ ' #BrazilianPortuguese via @SpeakLikeABR '|url_encode(true) ~ url}}">
					<i></i>
					<span class="label">tweet</span>
				</a>
	        </small>
		</span>
	</div>
</div>