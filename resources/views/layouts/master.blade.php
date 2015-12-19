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
    <div class="ui sizer vertical">
        <h1 class='ui center aligned header' id="header">Speak Like A Brazilian <img src="{{ URL::asset('images/slbr.png') }}" class="logo" alt="logo" title="logo"></h1>
    </div>

    <div class="ui center aligned container">
        <div class="ui fluid icon input">
            <input class="prompt" placeholder="Search..." type="text">
            <i class="search icon"></i>
        </div>
    </div>
    @show

    @section('menu')
    <div class="ui center aligned container">
        <div class="ui">
          <a class="item">
            New
          </a>
          @foreach (range('A', 'Z') as $char)
          <a class="item">
            {{ $char }}
          </a>
          @endforeach
          <a class="item">
            0 - 9
          </a>
          <a class="item">
            Top
          </a>
          <a class="item">
            Random
          </a>
        </div>
    </div>
    @show

    @yield('content')

    @section('footer')
    <div class="ui inverted vertical footer segment">
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
