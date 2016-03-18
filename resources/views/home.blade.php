@extends('layouts.master')

@section('title', 'Home')

@section('content')
	<div class='ui vertical segment'>
		<div class='ui stackable grid container'>
			<div class='row'>
            @if (count($definitions['data']) > 0)
		    	<div class='seven wide column'>
                @foreach (array_slice($definitions['data'], 0, 4) as $definition)
					@include('partials/expression')
                @endforeach
		    	</div>
                <div class='seven wide column'>
                @foreach (array_slice($definitions['data'], 4, 4) as $definition)
                    @include('partials/expression')
                @endforeach
                </div>
            @else
                <div class='fourteen wide column'>
                    <h2>No expressions found</h2>                    
                </div>
            @endif
		    	<div class='two wide column'>
					@include('partials/sidebar')
		    	</div>
			</div>
            @include('partials/pagination')
			</div>
		</div>
	</div>
@stop
