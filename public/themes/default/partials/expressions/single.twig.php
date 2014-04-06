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
    			&nbsp;<a class='tts' href="http://translate.google.com/translate_tts?ie=UTF-8&amp;tl=pt&amp;q={{ definition.expression.text }}"><i class='icon-play'></i></a>
			</span>
			<div class='rating'>
				{{ Form.open({'url': 'rating/definition/' ~ definition.id }) }}
				<small>
					<input type="hidden" name="_method" value="put" />
					<input type="hidden" name="definition_id" value="{{ expression.definition_id }}" />
					<span class="like_count">{{ definition.likes }} </span> 
					<input type="hidden" name="rating" value="0" /> ups, 
					<span class="dislike_count">{{ definition.dislikes }} </span> 
					downs <a href="#" class="like"><i class="icon-thumbs-up">&nbsp;</i>
					</a> <a href="#" class="dislike"><i class="icon-thumbs-down">&nbsp;</i>
					</a>
				</small>
				{{ Form.close() }}
			</div>
			<div class="date">
				<small>{{ definition.created_at }}</small>
			</div>
		</div>
	</div>
	<div class='description'>
		<p>{{ definition.description }}</p>
	</div>
	<div class='example'>
		<p>{{ definition.example }}</p>
	</div>
	<div class='tags'>
		<small>
    		<strong>Tags</strong>&nbsp;
    		{% if definition.tags is defined %}
    			{% for tag in definition.tags|split(',') %}
    				{% set tag = tag|trim %}
    		<span><a class="label label-info" href="{{ URL.to('expression/define?e=' ~ tag) }}">{{ tag }}</a></span> 
    			{% endfor %}
    		{% endif %}
		</small>
	</div>
	<div class='authorship'>
		<small>
    		<strong>By</strong> <span class="">@{{ definition.contributor }}
    		</span> 
    		<span class='share'>
    			<a class="label label-inverse" href="{{ URL.to('expression/' ~ definition.id) }}/share">share this</a>
    		</span> 
    		<span class='share'>
    			<a class="label label-inverse" href="{{ URL.to('expression/' ~  definition.id) }}/embed">embed</a> 
    		</span>
		</small>
	</div>
	<div class='entry-media'>
		<small>
    	    <strong>Media</strong> <span class='share'>
    	        <a class='btn btn-mini btn-media' href="{{ URL.to('expression/' ~ definition.id) }}/videos">+ add video</a> 
    	      </span>
    	</small>
	</div>
</div>