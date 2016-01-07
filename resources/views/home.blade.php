@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div class='ui vertical segment'>
	<div class='ui stackable grid container'>
		<div class='row'>
	    	<div class='sixteen wide column'>
				<h3>New expressions</h3>
			</div>
		</div>
		<div class='row'>
	    	<div class='six wide column'>
				<div class="ui fluid card">
				  	<div class="content">
   						<a><i class="right floated thumbs down icon"></i></a>
   						<a><i class="right floated thumbs up icon"></i></a>
				    	<div class="header"><a>Cafune</a><a><i class="unmute icon"></i></a></div>
				    	<div class="meta">January 5th at 1:42am &mdash; @kinow</div>
				    	<div class="description">
							<p>The act of tenderly running fingers through someone's hair.</p>

							<p><i>Examples</i></p>
							<p style='font-style: italic;'>
							1. Eu amo cafuné!
							<br/>
							2. Esse cafuné tá me dando sono.
							</p>
					    </div>
				  	</div>
				  	<div class='extra content'>
				    	<p class='left floated'>Tags: <a>tag1</a>, <a>tag2</a></p>
				    	<span class='right floated'>
				    		<a>+ picture</a>
				    		<a>+ video</a>
				    		<a class='ui mini button'><i class="twitter icon"></i> tweet</a>
				    	</span>
				    </div>
				</div>
	    	</div>
	    	<div class='six wide column'>
				<p>Expressions</p>
	    	</div>
	    	<div class='two wide column'>
				<p>Search &amp; mailing list</p>
	    	</div>
		</div>
	</div>
</div>
@stop
