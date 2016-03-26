<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Speak Like A Brazilian</title>
    <link rel="stylesheet" href="{{ URL::asset('css/slbr.css') }}">
</head>
<body>
@section('header')
    <section id='header'>
        <div class="ui container computer only grid">
            <div class="ui fixed small column" id="top">
                <div class="ui small centered grid">
                    <div class="center aligned column">
                        <div class="ui secondary small compact menu">
                            <a href="{{ URL::to('/') }}" class="small item"><i class="home icon"></i> Home</a>
                            <a href="http://twitter.com/SpeakLikeABR" class="small item"><i class="twitter square icon"></i> @SpeakLikeABR</a>
                            <a href="http://facebook.com/SpeakLikeABrazilian" class="small item"><i class="facebook square icon"></i> FaceBook Fan Page</a>
                            <a href="http://speaklikeabrazilian.com/moderators" class="small item"><i class="privacy icon"></i> Moderators Area</a>
                            <div class="small item">
                                @foreach ($languages as $language)
                                <a href="{{ URL::to('/' . $language['slug']) }}"><img width='24px' src="{{ URL::asset('images/flags/flag_' . $language['slug'] . '.png') }}" /></a>&nbsp;&nbsp;
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui container mobile only grid" id="mobile-header-wrapper">
            <div class="center aligned column" style='margin: 0px; padding: 0px;'>
                <div class="small item">
                    @foreach ($languages as $language)
                    <a href="{{ URL::to('/' . $language['slug']) }}"><img width='24px' src="{{ URL::asset('images/flags/flag_' . $language['slug'] . '.png') }}" /></a>&nbsp;&nbsp;
                    @endforeach
                </div>
            </div>
        </div>
        <div class="ui container computer only grid" id="header-wrapper">
            <div class="ui sizer vertical column">
                <h1 class='ui center aligned header' id="header-title">Speak Like A Brazilian <img src="{{ URL::asset('images/slbr.png') }}" class="logo" alt="Speak Like A Brazilian Logo" title="Logo"></h1>
            </div>
        </div>
        <div class="ui container mobile only grid" style="margin: 0px">
            <div class="ui center aligned column">
                <h2 class='ui'>Speak Like A Brazilian</h2>
            </div>
        </div>
        @include('partials/search')

    </section>
@show
@section('menu')
    <div class="ui center aligned vertical segment" id="menu">
        @if (isset($active) and $active == 'new')
        <a href="{{ URL::to('/new') }}" class="active item">New</a>
        @else
        <a href="{{ URL::to('/new') }}" class="item">New</a>
        @endif
@foreach (range('a', 'z') as $char)
        @if (isset($active) and $active == $char)
        <a href="{{ action('ExpressionController@getLetter', ['letter' => $char]) }}" class="active item">{{ strtoupper($char) }}</a>
        @else
        <a href="{{ action('ExpressionController@getLetter', ['letter' => $char]) }}" class="item">{{ strtoupper($char) }}</a>
        @endif
@endforeach
        @if (isset($active) and $active == '0-9')
        <a href="{{ action('ExpressionController@getLetter', ['letter' => '0-9']) }}" class="active item">0-9</a>
        @else
        <a href="{{ action('ExpressionController@getLetter', ['letter' => '0-9']) }}" class="item">0-9</a>
        @endif
        @if (isset($active) and $active == 'top')
        <a href="{{ URL::to('/top') }}" class="active item">Top</a>
        @else
        <a href="{{ URL::to('/top') }}" class="item">Top</a>
        @endif
        @if (isset($active) and $active == 'random')
        <a href="{{ URL::to('/random') }}" class="active item">Random</a>
        @else
        <a href="{{ URL::to('/random') }}" class="item">Random</a>
        @endif
    </div>
@show
@yield('content')
@section('footer')
    @include('partials/footer')
@show
    <script type="text/javascript" src="{{ URL::to('/js/all.js') }}"></script>
    <script>
    $( document ).ready(function() {
        $('form#search-form')
          .form({
            fields: {
              q: {
                identifier: 'q',
                rules: [
                    {
                        type: 'empty',
                        prompt: 'Please enter your query'
                    },
                    {
                        type: 'minLength[3]',
                        prompt: 'Your query must be at least three characters long'
                    },
                    {
                        type: 'maxLength[50]',
                        prompt: 'Your query must not be longer than 50 characters'
                    }
                ]
              }
            }
          })
        ;

        $('a.image-media')
            .colorbox({
                title: function() {
                    var title = $(this).attr('title');
                    return title;
                }
            })
        ;

        var form = $('#form');
        if (typeof form != 'undefined' && form.length > 0)
            $('#form')
                .parsley({
                })
            ;

        /* START: like and dislike buttons */
        function onError(jqXHR, textStatus, errorThrown) {
            console.log('Error voting: ' + errorThrown);
            console.log('Response text: ' + jqXHR.responseText);
        }

        function onComplete(jqXHR, textStatus) {
            var ret = jqXHR.responseText;
            try {
                data = $.parseJSON(jqXHR.responseText);
                if (/*jqXHR.status != 200 || */data.err != undefined || data.message != 'OK') {
                    console.log(data.message);
                    alert(data.message);
                    //console.log(data.msg);
                } else {
                    if(data.message != 'OK') {
                        console.log(data.message);
                    }
                }
            } catch (e) {
                console.log('Unkown internal error [9000], please report to the site administrator: ' + e);
            }
            $.unblockUI();
        }

        function onBeforeSend(formData, jqForm, options) {
            // formd = $.param(formData);
            $.blockUI({
                message : '<div style="padding: 10px 0px;"><h3>Processing your vote...</h3></div>'
            });
            return true;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".like").click(function() {
            var definitionId = $(this).data('definitionid');
            var self = this;
            $.ajax({
                type : 'POST', 
                url : '{{ action('ExpressionController@postLike') }}',
                data: { definition_id: definitionId },
                dataType : 'json',
                complete : onComplete,
                beforeSend : onBeforeSend,
                success : function(data, textStatus, jqXHR) {
                    if(data.message != undefined && data.message == 'OK') {
                        var likes = $(self).find('.like_count');
                        likes.text(parseInt(likes.text())+1);
                        if(data.balance == true) {
                            var dislikes = $(self).parent().find('.dislike_count');
                            if (dislikes.text() > 0)
                                dislikes.text(parseInt(dislikes.text())-1);
                        }
                    } else {
                        console.log(data);
                        console.log(textStatus);
                        console.log(jqXHR);
                    }
                },
                error : onError
            });
            return false;
            // $definition_id = form
        });

        $(".dislike").click(function() {
            var definitionId = $(this).data('definitionid');
            var self = this;
            $.ajax({
                type : "post",
                url : '{{ action('ExpressionController@postDislike') }}',
                data: { definition_id: definitionId },
                dataType : 'json',
                complete : onComplete,
                beforeSend : onBeforeSend,
                success : function(data, textStatus, jqXHR) {
                    if(data.message != undefined && data.message == 'OK') {
                        var dislikes = $(self).find('.dislike_count');
                        dislikes.text(parseInt(dislikes.text())+1);
                        if(data.balance == true) {
                            var likes = $(self).parent().find('.like_count');
                            if (likes.text() > 0)
                                likes.text(parseInt(likes.text())-1);
                        }
                    } else {
                        console.log(data);
                        console.log(textStatus);
                        console.log(jqXHR);
                    }
                },
                error : onError
            });
            return false;
        });

        /* ENDE: like and dislike buttons */

        $("a.tts")
            .colorbox({
                iframe:true, 
                onOpen: function() {
                    // prevent Overlay from being displayed...
                    $('#cboxOverlay,#colorbox').css('visibility', 'hidden');
                },
                width:"300px", 
                height:"200px"}
            )
        ;
    });
    </script>
</body>
</html>
