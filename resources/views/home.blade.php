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
            @if (count($definitions['data']) > 0)
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
            @endif
			</div>
		</div>
	</div>
@stop
