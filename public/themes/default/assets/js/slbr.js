$(function() {
	
	$(document).ajaxStop(jQuery.unblockUI);
	$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	$.jGrowl.defaults.closerTemplate = '<div>[ Close all ]</div>';
	
	// captcha
	$("#refresh_captcha").click(function(){
		$.blockUI();
		d = new Date();
		url = '';
		if (window.base_url)
			url = window.base_url;
		$("#captcha").attr("src", url + "captcha/"+d.getTime());
		setTimeout('jQuery.unblockUI()', 2000);
		return false;
	});
	
	nav_header_height = $("#nav-header").height();
	
    // Fixed elements on the screen
    /*$(window).scroll(function (event) {
    	// what the y position of the scroll is
        var y = $(this).scrollTop();
        if (y >= (nav_header_height+100)) {
        	$('#menu').addClass('menu-fixed');
        	$('#menu').css('top', nav_header_height);
        } else {
        	$('#menu').removeClass('menu-fixed');
        	$('#menu').css('top', 30);
        }
    });*/
    
    // handy confirmation dialog
    $('.form-delete').submit(function(e) {
		if (!confirm("Are you sure?")) {
			e.preventDefault();
			return;
		}
	});
    
    // function called within template blocks
	if (window.templatecallback) {
		templatecallback();
	}
	
	// function called within main page template
	if (window.maincallback) {
		maincallback();
	}
	
	$(".share2 a").colorbox({
		iframe:true,
		onOpen: function() {
	        // prevent Overlay from being displayed...
	        $('#cboxOverlay,#colorbox').css('visibility', 'hidden');
		},
		width:"80%", 
		height:"90%"});

	$(".embed a").colorbox({
		iframe:true,
		onOpen: function() {
	        // prevent Overlay from being displayed...
	        $('#cboxOverlay,#colorbox').css('visibility', 'hidden');
		},
		width:"550px", 
		height:"375px"});
	
	$("a.tts").colorbox({
		iframe:true, 
		onOpen: function() {
	        // prevent Overlay from being displayed...
	        $('#cboxOverlay,#colorbox').css('visibility', 'hidden');
		},
		width:"400px", 
		height:"300px"});

	$("a.colorbox").colorbox({
		iframe:true, 
		onOpen: function() {
	        // prevent Overlay from being displayed...
	        $('#cboxOverlay,#colorbox').css('visibility', 'hidden');
		},
		width:"600px", 
		height:"400px"});
	
/*	// avoid duplicate button calls
	$("input[type='submit']").attr("disabled", false);
	$("input[type='button']").attr("disabled", false);
	$("form").submit(function(){
		$("input[type='submit']").attr("disabled", true).val("Please wait...");
		$("input[type='button']").attr("disabled", true).val("Please wait...");
		return true;
	});*/
	
});

YUI().use(
  'aui-form-validator',
  'node',
  function(Y) {
    var rules = {
        email: {
            required: true, 
            email: true
        }
    };

    var form = Y.one('#subscribeForm');
    if (form) {
	    var validator = new Y.FormValidator(
	    {
	        boundingBox: '#subscribeForm',
	        //fieldStrings: fieldStrings,
	        rules: rules,
	        showAllMessages: true,
	        validateOnInput: false,
	        validateOnBlur: false
	    });
	}
  }
);