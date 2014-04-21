<div class='entry'>
	<div class='text'>
		<div>
			<span class='expression'>
	    		{% if video_id is defined and video_id != '' %}
	    		<p>
		    	    <iframe width="100%" height="400px" src="http://www.youtube.com/embed/{{ video_id }}?wmode=opaque{% if t is defined and t > 0 %}&start={{ t }}{% endif %}" frameborder="0" allowfullscreen></iframe>
	    		</p>
	    		{% endif %}
			</span>
			<div class="date">
				<small>{{ media.created_at|date('F jS \\a\\t g:ia') }}</small>
			</div>
		</div>
	</div>
	<div class='description'>
		<p class='entry-paragraph'><strong>Reason</strong></p>
		<p class='entry-paragraph'>{{ media.reason }}</p>
	</div>
	<div class='authorship'>
		<small>
    		<strong>Author</strong> <span class="">{{ media.contributor }}
    		</span> 
    	</small>	
	</div>
</div>