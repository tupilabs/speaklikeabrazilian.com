@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class='ui vertical segment'>
        <div class='ui stackable grid container'>
            <div class='row'>
                <div class='fourteen wide column'>
                    <h2>Add picture</h2>

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
                        <div class="header">Picture support</div>
                        <p>
                            We allow only imgur pictures for expressions.
                        </p>
                    </div>

                    <form id="form" class="ui form" method="post" action="{{ action('ExpressionController@postPicture') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="definition_id" value="{{ $definition_id }}">
                        {!! Honeypot::generate('username', 'picture_time') !!}
                        <div class="field">
                            <label>Expression in Portuguese</label>
                            <p>{{ $definition['text'] }}</p>
                        </div>
                        <div class="field">
                            <label>Description in {{ $selected_language['description'] }}</label>
                            <p>{!! html_entity_decode(
                                            get_definition_formatted_text(
                                                $definition['description']
                                            )
                                        )  !!}</p>
                        </div>
                        <div class="field">
                            <label for="picture-url-input">imgur picture URL</label>
                            <input type="text" name="picture-url-input" id="picture-url-input" value="{{ old('picture-url-input') }}" data-parsley-maxlength="255" data-parsley-minlength="1" data-parsley-required="true" data-parsley-type="url" />
                        </div>
                        <div class="field">
                            <label for="picture-reason-input">Why is this picture related to the "{{ $definition['text'] }}" expression?</label>
                            <input name="picture-reason-input" id="picture-reason-input" value="{{ old('picture-reason-input') }}" placeholder="Give a short description why you would like to share this picture with others" type="text" data-parsley-maxlength="500" data-parsley-minlength="1" data-parsley-required="true" />
                        </div>
                        <div class="two fields">
                            <div class="field">
                                <label for="picture-pseudonym-input">Your pseudonym</label>
                                <input name="picture-pseudonym-input" id="picture-pseudonym-input" value="{{ old('picture-pseudonym-input') }}" placeholder="Your pseudonym" type="text" data-parsley-maxlength="50" data-parsley-minlength="1" data-parsley-required="true" />
                            </div>
                            <div class="field">
                                <label for="picture-email-input">Your e-mail</label>
                                <input name="picture-email-input" id="picture-email-input" value="{{ old('picture-email-input') }}" placeholder="Your e-mail" type="email" data-parsley-maxlength="255" data-parsley-required="true" data-parsley-minlength="5" data-parsley-type="email" />
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
