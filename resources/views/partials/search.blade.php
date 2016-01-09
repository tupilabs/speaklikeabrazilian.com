    <div class="ui center aligned vertical basic segment" id='search'>
        <div class='ui stackable grid center aligned container'>
            <div class='row'>
                <div class='ten wide column'>
                    {!! Form::open(array('url' => 'search', 'method' => 'get')) !!}
                    <div class="ui small fluid action input">
                        <input class="prompt" name='q' placeholder="Search..." type="text">
                        <button class="ui button">Search</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>