            @if (isset($pagination) and count($definitions) > 0)
            <div class='row'>
                <div class='sixteen wide center aligned column'>
                    <div class="ui pagination menu">
                        @if ($pagination['last_page'] > 1 and $pagination['current_page'] != 1)
                        <a class="icon item" href="{{ $pagination['prev_page_url'] }}"><i class="left arrow icon"></i></a>
                        @else
                        <a class="disabled icon item"><i class="left arrow icon"></i></a>
                        @endif
                        @for ($i = 1; $i <= $pagination['last_page']; $i++)
                            @if ($pagination['current_page'] == $i)
                        <a class="active item">{{ $i }}</a>
                            @else
                        <a class="item" href="{{ Request::url() }}?page={{ $i }}">{{ $i }}</a>
                            @endif

                            @if ($i >= 2 and $i < $pagination['last_page'] - 2)
                            <?php $i = ((int) $pagination['last_page']) - 2 ?>
                        <a class="disabled item">...</a>
                            @endif
                        @endfor
                        @if ($pagination['last_page'] <= 1 or $pagination['last_page'] == $pagination['current_page'])
                        <a class='disabled icon item'><i class="right arrow icon"></i></a>
                        @else
                        <a class='icon item' href="{{ $pagination['next_page_url'] }}"><i class="right arrow icon"></i></a>
                        @endif
                    </div>
                </div>
            @endif
