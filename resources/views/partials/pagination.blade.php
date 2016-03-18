            @if (count($definitions['data']) > 0)
            <div class='row'>
                <div class='sixteen wide center aligned column'>
                    <div class="ui pagination menu">
                        @if ($definitions['last_page'] > 1 and $definitions['current_page'] != 1)
                        <a class="icon item" href="{{ $definitions['prev_page_url'] }}"><i class="left arrow icon"></i></a>
                        @else
                        <a class="disabled icon item"><i class="left arrow icon"></i></a>
                        @endif
                        @for ($i = 1; $i <= $definitions['last_page']; $i++)
                            @if ($definitions['current_page'] == $i)
                        <a class="active item">{{ $i }}</a>
                            @else
                        <a class="item" href="{{ Request::url() }}?page={{ $i }}">{{ $i }}</a>
                            @endif

                            @if ($i >= 2 and $i < $definitions['last_page'] - 2)
                            <?php $i = ((int) $definitions['last_page']) - 2 ?>
                        <a class="disabled item">...</a>
                            @endif
                        @endfor
                        @if ($definitions['last_page'] <= 1 or $definitions['last_page'] == $definitions['current_page'])
                        <a class='disabled icon item'><i class="right arrow icon"></i></a>
                        @else
                        <a class='icon item' href="{{ $definitions['next_page_url'] }}"><i class="right arrow icon"></i></a>
                        @endif
                    </div>
                </div>
            @endif