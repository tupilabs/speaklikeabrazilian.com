@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class='ui vertical segment'>
        <div class="ui middle aligned stackable grid container">
            <div class="row">
                <div class="eight wide column">
                <h3 class="ui header">Thank You!</h3>
                <p>Your expression has been submitted, and will be reviewed by one of our moderators.
                You will receive an e-mail (only one, no spam) when your expression is published.</p>
                <p>Speak Like A Brazilian is maintained by a network of volunters, and we have great
                content thanks to contributors like you. Muito obrigado por compartilhar! <i class="heart icon"></i></p>
                <p>Click <a href="{{ URL::to('/new') }}">here</a> to continue navigating in the web site.</p>
                </div>
            </div>
        </div>
    </div>
@stop
