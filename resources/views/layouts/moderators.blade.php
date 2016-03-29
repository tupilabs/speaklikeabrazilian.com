<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Speak Like A Brazilian</title>
    <link rel="stylesheet" href="{{ URL::asset('css/slbr.css') }}">
    <style type="text/css">
body {
  background-color: #DADADA;
}
body > .grid {
  height: 100%;
}
.image {
  margin-top: -100px;
}
.column {
  max-width: 450px;
}
    </style>
</head>
<body>
@yield('content')
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
