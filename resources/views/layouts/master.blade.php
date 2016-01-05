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
    <div class="ui fixed small" id="top">
        <div class="ui small centered grid">
            <div class="center aligned column">
                <div class="ui secondary small compact menu">
                    <a href="#" class="small item"><i class="home icon"></i> Home</a>
                    <a href="#" class="small item"><i class="twitter square icon"></i> @SpeakLikeABR</a>
                    <a href="#" class="small item"><i class="facebook square icon"></i> FaceBook Fan Page</a>
                    <a href="#" class="small item"><i class="privacy icon"></i> Moderators Area</a>
                </div>
            </div>
        </div>
    </div>
    <div class="ui sizer vertical">
        <h1 class='ui center aligned header' id="header">Speak Like A Brazilian <img src="{{ URL::asset('images/slbr.png') }}" class="logo" alt="logo" title="logo"></h1>
    </div>
    
    <div class="ui center aligned vertical basic segment" id='search'>
        <div class="ui large action input">
            <input class="prompt" placeholder="Search..." type="text">
            <button class="ui button">Search</button>
        </div>
    </div>
    @show
    
    @section('menu')
    <div class="ui center aligned basic vertical segment" id="menu">
        <a href="" class="item">
            New
        </a>
        @foreach (range('A', 'Z') as $char)
        <a href="" class="item">
            {{ $char }}
        </a>
        @endforeach
        <a href="" class="item">
            0 - 9
        </a>
        <a href="" class="item">
            Top
        </a>
        <a href="" class="item">
            Random
        </a>
    </div>
    @show
    
    @yield('content')
    
    @section('footer')
    <div class="ui vertical footer segment" id="footer">
        <div class="ui two column grid container">
            <div class="column">
                <h1>Speak Like A Brazilian is Open Source!</h1>
                <p>
                    Our content is created by users like you, and with software that was created
                    and distributed by great developers! The source code for this web site was
                    created by TupiLabs and open sourced via GitHub, via the MIT License.
                </p>
                
                <p>&copy; TupiLabs &mdash; Source code licensed under MIT License</p>
            </div>
        </div>
    </div>
    @show
</body>
</html>
