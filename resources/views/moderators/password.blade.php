@extends('layouts.moderators')
@section('content')
<!-- I use this to just show a DateTime, remove/replace as you wish -->
<h1 class="ui header datetime">{{ $title }}</h1>
<div class="row">
    <div class="column">
        <div class="ui segments">
            <div class='ui vertical segment'>
                <div class='ui stackable grid container'>
                    <div class='row'>
                        <div class='sixteen wide column'>
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

                            <form id="form" class="ui form" method="post" action="{{ URL::to('/moderators/password') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="field">
                                    <label for="password-current-input">Current Password</label>
                                    <input name="password-current-input" id="password-current-input" value="" type="password" data-parsley-maxlength="255" data-parsley-minlength="5" data-parsley-required="true"/>
                                </div>
                                <div class="field">
                                    <label for="password-repeat-input">Repeat Current Password</label>
                                    <input name="password-repeat-input" id="password-repeat-input" value="" type="password" data-parsley-maxlength="255" data-parsley-minlength="5" data-parsley-required="true" data-parsley-equalto="#password-current-input"/>
                                </div>
                                <div class="field">
                                    <label for="password-new-input">New Password</label>
                                    <input name="password-new-input" id="password-new-input" value="" type="password" data-parsley-maxlength="255" data-parsley-minlength="5" data-parsley-required="true"/>
                                </div>
                                <div class="ui center aligned container">
                                    <button class="ui primary large button" type="submit">Change it!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop