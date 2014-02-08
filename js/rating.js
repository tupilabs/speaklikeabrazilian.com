$(".like").click(function() {
	var leform = $(this).closest('form');
	var definition_id = leform.find('[name="definition_id"]').val();
	leform.find('[name="rating"]').val(1);
	var formAction = leform.attr('action');
	var formData = leform.serialize();
	$.ajax({
		type : "post", 
		url : formAction,
		data : formData,
		dataType : 'json',
		complete : onComplete,
		beforeSend : onBeforeSend,
		success : function(data, textStatus, jqXHR) {
			if (data.msg != undefined && data.msg == 'OK') {
				var likes = leform.find('.like_count');
				likes.text(parseInt(likes.text())+1);
				if(data.balance == true) {
					var dislikes = leform.find('.dislike_count');
					if (dislikes.text() > 0)
						dislikes.text(parseInt(dislikes.text())-1);
				}
			}
		},
		error : onError
	});
	return false;
	// $definition_id = form
});

$(".dislike").click(function() {
	var leform = $(this).closest('form');
	var definition_id = leform.find('[name="definition_id"]').val();
	leform.find('[name="rating"]').val(-1);
	var formAction = leform.attr('action');
	var formData = leform.serialize();
	$.ajax({
		type : "post",
		url : formAction,
		data : formData,
		dataType : 'json',
		complete : onComplete,
		beforeSend : onBeforeSend,
		success : function(data, textStatus, jqXHR) {
			if(data.msg != undefined && data.msg == 'OK') {
				var dislikes = leform.find('.dislike_count');
				dislikes.text(parseInt(dislikes.text())+1);
				if(data.balance == true) {
					var likes = leform.find('.like_count');
					if (likes.text() > 0)
						likes.text(parseInt(likes.text())-1);
				}
			}
		},
		error : onError
	});
	return false;
	// $definition_id = form
});

function onError(jqXHR, textStatus, errorThrown) {
	console.log('Error voting: ' + errorThrown);
	console.log('Response text: ' + jqXHR.responseText);
}

function onComplete(jqXHR, textStatus) {
	var ret = jqXHR.responseText;
	try {
		data = $.parseJSON(jqXHR.responseText);
		if (/*jqXHR.status != 200 || */data.err != undefined || data.msg != 'OK') {
			alert(data.msg);
			//console.log(data.msg);
		} else {
			if(data.msg != 'OK') {
				alert(data.msg);
			}
		}
	} catch (e) {
		alert('Unkown internal error [9000], please report to the site administrator: '
				+ e);
	}
	$.unblockUI();
}

function onBeforeSend(formData, jqForm, options) {
	// formd = $.param(formData);
	$
			.blockUI({
				// message: '<div style="padding: 10px 0px;"><h3><img
				// src="../assets/img/loading.gif" />Processing your
				// vote...</h3></div>'
				message : '<div style="padding: 10px 0px;"><h3>Processing your vote...</h3></div>'
			});
	return true;
}
