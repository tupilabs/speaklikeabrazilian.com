@extends('layouts.moderators')
@section('content')
<!-- I use this to just show a DateTime, remove/replace as you wish -->
<h1 class="ui header datetime">{{ $title }}</h1>
<div class="row">
    <div class="column">
        @if ($definition)
        <img class='image' width='24px' src="{{ URL::asset('images/flags/flag_' . $selected_language['slug'] . '.png') }}" />
        <div class="ui fluid card">
            <div class="center aligned content">
                <div class='image'>
                    <img src="{{ $picture['url'] }}" />
                </div>
                <h2>Reason:</h2>
                <p>{{ $picture['reason'] }}</p>
            </div>
        </div>
        @include('../partials/expression', ['hide_votes' => TRUE, 'hide_links' => TRUE])
        <div class="ui two bottom attached buttons">
            <a class="ui primary button" href="{{ URL::to('/moderators/pictures/' . $picture['id'] . '/approve') }}">Approve</a>
            <div class="or"></div>
            <a class="ui negative button" href="{{ URL::to('/moderators/pictures/' . $picture['id'] . '/reject') }}">Reject</a>
        </div>
        @else
        <div class="ui segments">
            <div class="ui segment">
                <h2>No pending pictures! Good job!</h2>
            </div>
        </div>
        @endif
    </div>
</div>
@stop