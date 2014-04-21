<div class='entry'>
	<div class='text'>
		<div>
			<span class='expression'>
    			{{ definition.expression.text }}
    			&nbsp;<a class='tts' href="http://translate.google.com/translate_tts?ie=UTF-8&amp;tl=pt&amp;q={{ definition.expression.text }}"><span class="glyphicon glyphicon-play"></span></a>
			</span>
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
	</div>
</div>