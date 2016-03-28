@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class='ui vertical segment'>
        <div class='ui stackable grid container'>
            <div class='row'>
                <div class='fourteen wide column'>
                    <h2>Add video</h2>

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

                    <div class="ui warning message">
                        <div class="header">Video support</div>
                        <p>
                            We allow only YouTube videos for expressions.
                        </p>
                    </div>

                    <form id="form" class="ui form" method="post" action="{{ action('ExpressionController@postVideo') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="definition_id" value="{{ $definition_id }}">
                        <div class="field">
                            <label>Expression in Portuguese</label>
                            <p>{{ $definition['text'] }}</p>
                        </div>
                        <div class="field">
                            <label>Description in {{ $selected_language }}</label>
                            <p>{!! html_entity_decode(
                                            get_definition_formatted_text(
                                                $definition['description']
                                            )
                                        )  !!}</p>
                        </div>
                        <div class="field">
                            <label for="video-url-input">YouTube video URL</label>
                            <input type="text" name="video-url-input" id="video-url-input" value="{{ old('video-url-input') }}" data-parsley-maxlength="255" data-parsley-minlength="1" data-parsley-required="true" data-parsley-type="url" />
                        </div>
                        <div class="field">
                            <label for="video-reason-input">Why is this video related to the "{{ $definition['text'] }}" expression?</label>
                            <input name="video-reason-input" id="video-reason-input" value="{{ old('video-reason-input') }}" placeholder="Give a short description why you would like to share this video with others" type="text" data-parsley-maxlength="500" data-parsley-minlength="1" data-parsley-required="true" />
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label for="video-pseudonym-input">Your pseudonym</label>
                                <input name="video-pseudonym-input" id="video-pseudonym-input" value="{{ old('video-pseudonym-input') }}" placeholder="Your pseudonym" type="text" data-parsley-maxlength="50" data-parsley-minlength="1" data-parsley-required="true" />
                            </div>
                            <div class="field">
                                <label for="video-email-input">Your e-mail</label>
                                <input name="video-email-input" id="video-email-input" value="{{ old('video-email-input') }}" placeholder="Your e-mail" type="email" data-parsley-maxlength="255" data-parsley-required="true" data-parsley-minlength="5" data-parsley-type="email" />
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
