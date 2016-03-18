<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
                                <a href="{{ URL::to('/' . $language->slug) }}"><img width='24px' src="{{ URL::asset('images/flags/flag_' . $language->slug . '.png') }}" /></a>&nbsp;&nbsp;
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui container computer only grid" id="header-wrapper">
            <div class="ui sizer vertical column">
                <h1 class='ui center aligned header' id="header-title">Speak Like A Brazilian <img src="{{ URL::asset('images/slbr.png') }}" class="logo" alt="Speak Like A Brazilian Logo" title="Logo"></h1>
            </div>
        </div>
        <div class="ui container mobile only grid" id="mobile-header-wrapper">
            <div class="ui center aligned column">
                <h2 class='ui'>Speak Like A Brazilian</h2>
            </div>
        </div>
        @include('partials/search')

    </section>
@show
@section('menu')
    <div class="ui center aligned vertical segment" id="menu">
        <a href="{{ URL::to('/') }}" class="item">New</a>
@foreach (range('A', 'Z') as $char)
        <a href="{{ URL::to('/expression/letter/' . strtolower($char)) }}" class="item">{{ $char }}</a>
@endforeach
        <a href="{{ URL::to('/0-9') }}" class="item">0-9</a>
        <a href="{{ URL::to('/top') }}" class="item">Top</a>
        <a href="{{ URL::to('/random') }}" class="item">Random</a>
    </div>
@show
@yield('content')
@section('footer')
    <div class="ui vertical footer segment" id="footer">
        <div class="ui two column computer only grid container">
            <div class="column">
                <h1>Speak Like A Brazilian is Open Source!</h1>
                <p>
                    Our content is created by users like you, and with software that was created
                    and distributed by great developers! The source code for this web site was
                    created by TupiLabs and open sourced via GitHub, licensed under the MIT License.
                </p>
                <p>&copy; TupiLabs &mdash; Source code licensed under the MIT License</p>
            </div>
        </div>
        <div class="ui one column mobile only grid container">
            <div class="column">
                <h1>Speak Like A Brazilian is Open Source!</h1>
                <p>
                    Our content is created by users like you, and with software that was created
                    and distributed by great developers! The source code for this web site was
                    created by TupiLabs and open sourced via GitHub, licensed under the MIT License.
                </p>
                <p>&copy; TupiLabs &mdash; Source code licensed under the MIT License</p>
            </div>
        </div>
    </div>
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
    });
    </script>
</body>
</html>
