@extends('layouts.master')

@section('title', 'Home')

@section('content')
	<div class='ui vertical segment'>
		<div class='ui stackable grid container'>
			<div class='row'>
		    	<div class='seven wide column'>
					@include('partials/expression')

					@include('partials/expression')

					@include('partials/expression')

					@include('partials/expression')

		    	</div>
		    	<div class='seven wide column'>
					@include('partials/expression')

					@include('partials/expression')

					@include('partials/expression')

					@include('partials/expression')

		    	</div>
		    	<div class='two wide column'>
					@include('partials/sidebar')

		    	</div>
			</div>
			<div class='row'>
		    	<div class='sixteen wide center aligned column'>
					<div class="ui pagination menu">
						<a class="icon item"><i class="left arrow icon"></i></a>
						<a class="active item">1</a>
						<a class="active item">2</a>
						<div class="disabled item">...</div>
						<a class="item">11</a>
						<a class="item">12</a>
						<a class='icon item'><i class="right arrow icon"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
