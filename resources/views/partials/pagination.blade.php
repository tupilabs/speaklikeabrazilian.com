            @if (count($definitions['data']) > 0)
            <div class='row'>
                <div class='sixteen wide center aligned column'>
                    <div class="ui pagination menu">
                        @if ($definitions['last_page'] > 1 and $definitions['current_page'] != 1)
                        <a class="icon item" href="{{ $definitions['prev_page_url'] }}"><i class="left arrow icon"></i></a>
                        @else
                        <a class="disabled icon item"><i class="left arrow icon"></i></a>
                        @endif
                        <a class="active item">1</a>
                        <a class="active item">2</a>
                        <div class="disabled item">...</div>
                        <a class="item">11</a>
                        <a class="item">12</a>
                        @if ($definitions['last_page'] <= 1 or $definitions['last_page'] == $definitions['current_page'])
                        <a class='disabled icon item'><i class="right arrow icon"></i></a>
                        @else
                        <a class='icon item' href="{{ $definitions['next_page_url'] }}"><i class="right arrow icon"></i></a>
                        @endif
                    </div>
                </div>
            @endif