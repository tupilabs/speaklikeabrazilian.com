@extends('layouts.login')

@section('content')
    <div class="ui middle aligned center aligned grid" style='height: 100%;'>
        <div class="column" style='max-width: 450px;'>
            <h2 class="ui teal image header">
                <div class="content">Administrators area</div>
            </h2>
            <form action='{{ URL::to("/auth/login") }}' method='post' id='form' class="ui large form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {!! Honeypot::generate('username', 'my_time') !!}
                <div class="ui stacked segment">
                    <div class="field">
                        <div class="ui left icon input"><i class="user icon"></i>
                            <input type="text" name="administrator-email-input" id="administrator-email-input" placeholder="E-mail address" value='{{ old("administrator-email-input") }}' type="email" data-parsley-maxlength="255" data-parsley-required="true" data-parsley-minlength="5" data-parsley-type="email">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input"><i class="lock icon"></i>
                            <input type="password" name="administrator-password-input" id="administrator-password-input" placeholder="Password" data-parsley-maxlength="100" data-parsley-required="true" data-parsley-minlength="5">
                        </div>
                    </div>
                    <button class="ui fluid large teal submit button" type='submit'>Login</button>
                </div>
            </form>
            @if (count($errors) > 0)
            <div class="ui error message">
                <div class="header">Validation error</div>
                <p>You have the following validation errors:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class='ui message'>
                <p><a href="{{ URL::to('/') }}">&lt; Go back</a></p>
            </div>
        </div>
    </div>
@stop