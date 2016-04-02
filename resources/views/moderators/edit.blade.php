@extends('layouts.moderators')
@section('content')
<!-- I use this to just show a DateTime, remove/replace as you wish -->
<h1 class="ui header datetime">{{ $title }}</h1>
<div class="row">
    <div class="column">
        @if (isset($definition))
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

                            <form id="form" class="ui form" method="post" action="{{ URL::to('/moderators/edit') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="definition_id" value="{{ $definition_id }}">
                                <div class="field">
                                    <label for="expression-text-input">Expression in Portuguese</label>
                                    <input name="expression-text-input" id="expression-text-input" value="{{ $definition['text'] }}" type="text" readonly="readonly" disabled="disabled" />
                                </div>
                                <div class="field">
                                    <label for="expression-description-input">Description in {{ $selected_language['description'] }}</label>
                                    <textarea name="expression-description-input" id="expression-description-input" data-parsley-maxlength="1000" data-parsley-minlength="1" data-parsley-required="true">{{ $definition['description'] }}</textarea>
                                </div>
                                <div class="field">
                                    <label for="expression-example-input">Example in Portuguese</label>
                                    <textarea name="expression-example-input" id="expression-example-input" data-parsley-maxlength="1000" data-parsley-minlength="1" data-parsley-required="true">{{ $definition['example'] }}</textarea>
                                </div>
                                <div class="field">
                                    <label for="expression-tags-input">Tags</label>
                                    <input name="expression-tags-input" id="expression-tags-input" value="{{ $definition['tags'] }}" placeholder="Comma separated list of tags and similar expressions" type="text" data-parsley-maxlength="100" data-parsley-minlength="1" data-parsley-required="true" />
                                </div>
                                <div class="field">
                                    <label for="expression-pseudonym-input">Contributor pseudonym</label>
                                    <input name="expression-pseudonym-input" id="expression-pseudonym-input" value="{{ $definition['contributor'] }}" placeholder="Your pseudonym" type="text" readonly="readonly" disabled="disabled" />
                                </div>
                                <div class="ui center aligned container">
                                    <button class="ui primary large button" type="submit">Update it!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="ui segments">
            <div class='ui vertical segment'>
                <div class='ui stackable grid container'>
                    <div class='row'>
                        <div class='sixteen wide column'>
                            <h2>Enter expression ID</h2>

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

                            <form id="form" class="ui form" method="get" action="{{ URL::to('/moderators/edit') }}">
                                <div class="field">
                                    <label for="definition_id">Expression ID</label>
                                    <input name="definition_id" id="definition_id" value="{{ $definition['definition_id'] }}" placeholder="You can find it in the add picture/video links" type="text" data-parsley-maxlength="255" data-parsley-minlength="1" data-parsley-required="true" />
                                </div>
                                <div class="ui center aligned container">
                                    <button class="ui primary large button" type="submit">View Expression</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@stop