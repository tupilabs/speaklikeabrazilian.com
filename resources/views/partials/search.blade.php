        <div class="ui center aligned vertical basic segment" id='search'>
            <div class='ui stackable grid center aligned container'>
                <div class='row'>
                    <div class='ten wide column'>
                        {!! Form::open(array('url' => $selected_language['slug'] . '/search', 'method' => 'get', 'class' => 'ui form', 'id' => 'search-form')) !!}
                            <div class='field'>
                                <div class="ui small fluid action input">
                                    <input class="prompt" name='q' id='q' value="{{ $q or old('q') }}" placeholder="Search..." type="text">
                                    <button class="ui submit button">Search</button>
                                </div>
                            </div>
                            <div class="ui error message"></div>
                        {!! Form::close() !!}
                        @if (session('search_error'))
                        <div class="ui error message">
                            <div class="header">Search error</div>
                            <p>{{ session('search_error') }}</p>
                        </div>
                        <br/>
                        @endif
                    </div>
                </div>
            </div>
        </div>