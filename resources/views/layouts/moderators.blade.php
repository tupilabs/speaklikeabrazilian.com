<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Speak Like A Brazilian</title>
    <link rel="stylesheet" href="{{ URL::asset('css/slbr.css') }}">
    <style>
* {
  margin: 0;
  padding: 0;
}

body {
  background-color: #F5F5F5 !important;
}

.ui.main.grid {
  left: 18.75%;
  position: relative;
  width: 81.25%;
}

.ui.main.grid .ui.secondary.pointing.fluid.menu h2 {
  margin: calc(2rem - .14285em) 0 1rem;
}

.ui.fixed.inverted.main.menu {
  display: none;
}

.ui.left.fixed.vertical.inverted.menu {
  padding-left: 0;
  padding-right: 0;
}

.ui.left.fixed.vertical.inverted.menu a.item:first-child {
  padding-bottom: 30px;
  padding-top: 60px;
}

.ui.sidebar.inverted.vertical.menu a.item:first-child {
  padding-bottom: 15px;
  padding-top: 30px;
}

/* LOGIN STYLES */

[data-page="login"] .ui.container {
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: center;
  margin: 0 auto;
  width: 465px;
}

.dashboard.brand.icon {
  width: 100%;
  margin-bottom: 36px;
}

[data-page="login"] .ui.container .ui.segment {
  padding: 35px;
}

p.signup {
  padding-top: 25px;
}

p.dashboard {
  font-size: 12px;
  padding-top: 10px;
  text-transform: uppercase;
}

p.signup, p.dashboard {
  color: #999999;
  text-align: center;
}

/* PRODUCTS STYLES */
.ui.striped.table {
  padding-left: 0;
  padding-right: 0;
}

.ui.main.grid .products.column, .ui.main.grid .products.column .basic.segment {
  padding: 1rem 0;
}

.ui.divided.product.items {
  width: 100%;
}

.ui.divided.product.items img {
  height: 187px;
  width: 150px;
}

/* CUSTOMER STYLES */

.customer.statistics {
  width: 100%;
}

.feedback.segments {
  width: 100%;
}

/* EMPLOYEES STYLES */

.ui.mobile.cards {
  display: none;
}

/* DASHBOARD STYLES */

.ui.dashboard.segment {
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 171px;
}

.ui.dashboard.statistic .value {
  color: #FFFFFF;
}

.ui.dashboard.statistic .label {
  color: #F5F5F5;
}

.top-table.column {
  width: 33.33333333% !important;
}

.top-table.column .ui.segment:last-child, .doughnut-chart.column .ui.segment:last-child {
  height: 219px;
}

.doughnut-chart.column {
  width: 66.66666666% !important;
}

ul#dashboard_legend {
  display: inline-block;
  vertical-align: top;
}

ul.doughnut-legend {
  list-style-type: none;
}

.doughnut-legend li span{
  border-radius: 50%;
  display: inline-block;
  margin-right: 8px;
  height: 12px;
  width: 12px;
}

/* SMARTPHONE */
@media only screen and (min-width: 320px) and (max-width: 767px) {
  .ui.mobile.cards {
    display: flex;
  }

  .ui.special.three.cards {
    display: none;
  }

  .ui.main.grid .row {
    padding-top: 0;
    padding-bottom: 0;
  }

  .top-table.column .ui.segment:last-child, .doughnut-chart.column .ui.segment:last-child {
    height: auto;
  }

  .ui.special.three.cards .card .content a.header,
  .ui.special.three.cards .card .content div.header {
    font-size: 1em;
  }

  .ui.four.customer.statistics .statistic .value {
    font-size: 1.5em;
  }

  .ui.grid .nine.wide.products.column, .ui.grid .seven.wide.products.column {
    padding: 0;
    width: 100% !important;
  }

  .ui.grid .seven.wide.products.column .ui.basic.right.aligned.segment {
    text-align: left;
  }

  .ui.grid .ui.three.column.row .dashboard-stat.column,
  .ui.grid .row .top-table.column, .ui.grid .row .doughnut-chart.column, .ui.grid .four.wide.sales.column,
  .ui.grid .twelve.wide.sales.column {
    margin-bottom: 30px;
    width: 100% !important;
  }

  .ui.header.datetime {
    margin: 3rem 0 1rem;
  }

  .ui.left.fixed.vertical.inverted.menu {
    display: none;
  }

  .ui.fixed.inverted.main.menu {
    display: block;
  }

  .ui.main.grid {
    left: 0%;
    margin: 0 auto;
    padding: 2.75rem 0 0;
    position: relative;
    width: 100%;
  }
}

/* TABLET */
@media only screen and (min-width: 768px) and (max-width: 991px) {
  .ui.header.datetime {
    margin: 3rem 0 1rem;
  }

  .ui.left.fixed.vertical.inverted.menu {
    display: none;
  }

  .ui.fixed.inverted.main.menu {
    display: block;
  }

  .ui.main.grid {
    left: 0%;
    padding-top: 2.75rem !important;
    position: relative;
    width: 100%;
  }
}

@media only screen and (min-width: 992px) {
  .ui.fixed.inverted.main.menu {
    display: none;
  }

  .ui.left.fixed.vertical.inverted.menu {
    display: block;
  }
}
    </style>
</head>
<body>
<div class="ui grid container">
    <div class="ui sidebar inverted vertical menu">
        <a class="active gray item" href="{{ URL::to('/moderators/') }}">Dashboard</a>
        <a class="item" href="{{ URL::to('/moderators/expressions') }}">
            Pending Expressions
            <div class="ui label">11</div>
        </a>
        <a class="item" href="{{ URL::to('/moderators/pictures') }}">
            Pending Pictures
            <div class="ui label">2</div>
        </a>
        <a class="item" href="{{ URL::to('/moderators/videos') }}">
            Pending Videos
        </a>
        <a class="item" href="{{ URL::to('/moderators/blog') }}">Blog</a>
        <a class="item" href="{{ URL::to('/moderators/logout') }}">
            <p>Sign Out</p>
        </a>
    </div>
    <!-- Non-responsive main left menu -->
    <div class="ui left fixed vertical inverted menu">
        @if (Request::is('moderators'))
        <a class="active gray item" href="{{ URL::to('/moderators/') }}">Dashboard</a>
        @else
        <a class="gray item" href="{{ URL::to('/moderators/') }}">Dashboard</a>
        @endif
        @if (Request::is('moderators/expressions'))
        <a class="active item" href="{{ URL::to('/moderators/expressions') }}">
        @else
        <a class="item" href="{{ URL::to('/moderators/expressions') }}">
        @endif
            Pending Expressions
            <div class="ui label">{{ $count_pending_expressions }}</div>
        </a>
        @if (Request::is('moderators/pictures'))
        <a class="active item" href="{{ URL::to('/moderators/pictures') }}">
        @else
        <a class="item" href="{{ URL::to('/moderators/pictures') }}">
        @endif
            Pending Pictures
            <div class="ui label">{{ $count_pending_pictures }}</div>
        </a>
        @if (Request::is('moderators/videos'))
        <a class="active item" href="{{ URL::to('/moderators/videos') }}">
        @else
        <a class="item" href="{{ URL::to('/moderators/videos') }}">
        @endif
            Pending Videos
            <div class="ui label">{{ $count_pending_videos }}</div>
        </a>
        @if (Request::is('moderators/blog'))
        <a class="active item" href="{{ URL::to('/moderators/blog') }}">Blog</a>
        @else
        <a class="item" href="{{ URL::to('/moderators/blog') }}">Blog</a>
        @endif
        <a class="item" href="{{ URL::to('/moderators/logout') }}">
            <p>Sign Out</p>
        </a>
    </div>
    <div class="ui main grid">
        <!-- Responsive top menu -->
        <div class="ui fixed inverted main menu">
            <div class="ui container">
                <a class="launch icon item sidebar-toggle"> <i class="sidebar icon"></i>
                </a>
            </div>
        </div>
@yield('content')
    </div>
</div>
    <script type="text/javascript" src="{{ URL::to('/js/all.js') }}"></script>
    <script>
    $( document ).ready(function() {
        $('a.video-colorbox')
            .colorbox({
                title: function() {
                    var title = $(this).attr('title');
                    return title;
                },
                iframe: true,
                width: '600px',
                height: '400px'
            })
        ;

        $('a.image-colorbox')
            .colorbox({
                title: function() {
                    var title = $(this).attr('title');
                    return title;
                },
                iframe: false,
                width: '600px',
                height: '400px'
            })
        ;

        var form = $('#form');
        if (typeof form != 'undefined' && form.length > 0)
            $('#form')
                .parsley({
                })
            ;

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
