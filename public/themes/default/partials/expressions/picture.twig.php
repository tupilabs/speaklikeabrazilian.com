<div class='entry'>
	<div class='text'>
		<div>
			<span class='expression'>
	    		<p>
		    	    <img width="600" src="{{ media.url }}" />
	    		</p>
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