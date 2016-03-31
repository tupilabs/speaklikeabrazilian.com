@extends('layouts.moderators')
@section('content')
<!-- I use this to just show a DateTime, remove/replace as you wish -->
<h1 class="ui header datetime">{{ $title }}</h1>
<div class="row">
    <div class="column">
        @if ($definition)
        <img class='image' width='24px' src="{{ URL::asset('images/flags/flag_' . $selected_language['slug'] . '.png') }}" />
        @include('../partials/expression', ['hide_votes' => TRUE, 'hide_links' => TRUE])
        <div class="ui two bottom attached buttons">
            <a class="ui primary button" href="{{ URL::to('/moderators/expressions/' . $definition['id'] . '/approve') }}">Approve</a>
            <div class="or"></div>
            <a class="ui negative button" href="{{ URL::to('/moderators/expressions/' . $definition['id'] . '/reject') }}">Reject</a>
        </div>
        @else
        <div class="ui segments">
            <div class="ui segment">
                <h2>No pending expressions! Good job!</h2>
            </div>
        </div>
        @endif
    </div>
</div>
@stop