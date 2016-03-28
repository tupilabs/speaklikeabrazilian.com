@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class='ui vertical segment'>
        <div class='ui stackable grid container'>
            <div class='row'>
                <div class='fourteen wide column'>
                    <h2>Add video</h2>

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
                            <input type="text" name="video-url-input" id="video-url-input" data-parsley-maxlength="255" data-parsley-minlength="1" data-parsley-required="true" data-parsley-type="url" />
                        </div>
                        <div class="field">
                            <label for="video-reason-input">Why is this video related to the "{{ $definition['text'] }}" expression?</label>
                            <input name="video-reason-input" id="video-reason-input" placeholder="Give a short description why you would like to share this video with others" type="text" data-parsley-maxlength="500" data-parsley-minlength="1" data-parsley-required="true" />
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label for="expression-pseudonym-input">Your pseudonym</label>
                                <input name="expression-pseudonym-input" id="expression-pseudonym-input" placeholder="Your pseudonym" type="text" data-parsley-maxlength="50" data-parsley-minlength="1" data-parsley-required="true" />
                            </div>
                            <div class="field">
                                <label for="expression-email-input">Your e-mail</label>
                                <input name="expression-email-input" id="expression-email-input" placeholder="Your e-mail" type="email" data-parsley-maxlength="255" data-parsley-required="true" data-parsley-minlength="5" data-parsley-type="email" />
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
