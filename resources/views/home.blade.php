@extends('layouts.master')

@section('title', 'Home')

@section('content')
	<div class='ui vertical segment'>
		<div class='ui stackable grid container'>
			<div class='row'>
            @if (count($definitions) > 0)
		    	<div class='seven wide column'>
                @foreach (array_slice($definitions, 0, 4) as $definition)
					@include('partials/expression')
                @endforeach
		    	</div>
                <div class='seven wide column'>
                @foreach (array_slice($definitions, 4, 4) as $definition)
                    @include('partials/expression')
                @endforeach
                </div>
            @else
                <div class='fourteen wide column'>
                    <p>No expressions found. <a href="{{ URL::to('/expression/add') }}">Add yours!</a></p>
                </div>
            @endif
		    	<div class='two wide column'>
					@include('partials/sidebar')
		    	</div>
			</div>
            @include('partials/pagination')
		</div>
	</div>
@stop
