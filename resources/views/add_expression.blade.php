@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class='ui vertical segment'>
        <div class='ui stackable grid container'>
            <div class='row'>
                <div class='fourteen wide column'>
                    <h2>Add expression</h2>

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

                    <div class="ui message">
                        <div class="header">Content Licensing</div>
                        <p>
                            By sharing your content in Speak Like A Brazilian, you are accepting to license it
                            under the <a href="http://creativecommons.org/licenses/by/4.0/">
                            Creative Commons Attribution 4.0 International</a>.
                        </p>
                    </div>

                    <form id="form" class="ui form" method="post" action="{{ action('ExpressionController@postAdd') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                        {!! Honeypot::generate('username', 'my_time') !!}
                        <div class="field">
                            <label for="expression-text-input">Expression in Portuguese</label>
                            <input name="expression-text-input" id="expression-text-input" value="{{ old('expression-text-input') }}" placeholder="Expression in Portuguese" type="text" data-parsley-maxlength="255" data-parsley-minlength="1" data-parsley-required="true" />
                        </div>
                        <div class="field">
                            <label for="expression-description-input">Description in {{ $selected_language }}</label>
                            <textarea name="expression-description-input" id="expression-description-input" data-parsley-maxlength="1000" data-parsley-minlength="1" data-parsley-required="true">{{ old('expression-description-input') }}</textarea>
                        </div>
                        <div class="field">
                            <label for="expression-example-input">Example in Portuguese</label>
                            <textarea name="expression-example-input" id="expression-example-input" data-parsley-maxlength="1000" data-parsley-minlength="1" data-parsley-required="true">{{ old('expression-example-input') }}</textarea>
                        </div>
                        <div class="field">
                            <label for="expression-tags-input">Tags</label>
                            <input name="expression-tags-input" id="expression-tags-input" value="{{ old('expression-tags-input') }}" placeholder="Comma separated list of tags and similar expressions" type="text" data-parsley-maxlength="100" data-parsley-minlength="1" data-parsley-required="true" />
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label for="expression-pseudonym-input">Your pseudonym</label>
                                <input name="expression-pseudonym-input" id="expression-pseudonym-input" value="{{ old('expression-pseudonym-input') }}" placeholder="Your pseudonym" type="text" data-parsley-maxlength="50" data-parsley-minlength="1" data-parsley-required="true" />
                            </div>
                            <div class="field">
                                <label for="expression-email-input">Your e-mail</label>
                                <input name="expression-email-input" id="expression-email-input" value="{{ old('expression-email-input') }}" placeholder="Your e-mail" type="email" data-parsley-maxlength="255" data-parsley-required="true" data-parsley-minlength="5" data-parsley-type="email" />
                            </div>
                        </div>
                        <div class="ui center aligned container">
                            <button class="ui primary large button" type="submit">Send it!</button>
                        </div>
                    </form>
                </div>
                <div class='two wide column'>
                    @include('partials/sidebar')
                </div>
            </div>
        </div>
    </div>
@stop
