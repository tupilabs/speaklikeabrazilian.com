<div class='entry'>
	<div class='text'>
		<div>
			<span class='expression'>
    			{% if nolink %}
    			{{ definition.expression.text }}
    			{% else %}
    			<a href="{{ URL.to('/expression/define?e=' ~ definition.expression.text) }}">
    				{{ definition.expression.text }}
    			</a>
    			{% endif %}
    			&nbsp;<a class='tts' href="http://translate.google.com/translate_tts?ie=UTF-8&amp;tl=pt&amp;q={{ definition.expression.text }}"><span class="glyphicon glyphicon-play"></span></a>
			</span>
			<div class='rating'>
				{{ Form.open({'url': '/rate' }) }}
				<small>
					<input type="hidden" name="expressionId" value="{{ definition.expression_id }}" />
					<input type="hidden" name="definitionId" value="{{ definition.id }}" />
					<span class="like_count">{{ definition.likes }} </span> 
					<input type="hidden" name="rating" value="0" /> ups, 
					<span class="dislike_count">{{ definition.dislikes }} </span> 
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
		<span class='share2'>
			<a class="label label-info" href="{{ URL.to('expression/' ~ definition.id) }}/share">share this</a>
		</span> 
		<span class='embed'>
			<a class="label label-info" href="{{ URL.to('expression/' ~  definition.id) }}/embed">embed</a> 
		</span>		
	</div>
	<div class='entry-media'>
		<small>
    	    <strong>Media</strong>
    	</small>
	    <span class='share2'>
	    	<a class='label label-info btn-media' href="{{ URL.to('expression/' ~ definition.id) }}/videos">+ add video</a> 
	    </span>
	    <span class='share2'>
	    	<a class='label label-info btn-media' href="{{ URL.to('expression/' ~ definition.id) }}/pictures">+ add picture</a> 
	    </span>
	</div>
</div>