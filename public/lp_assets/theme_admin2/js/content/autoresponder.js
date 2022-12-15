$(document).ready(function(){
	//    Auto responder
	// $('input[data-id]').click(function () {
	//     $('.lp-email-section').removeClass('editor-active');
	//     var cur_editor=$(this).data('id').split("-");
	//     $("#theoption").val(cur_editor[0]);
	//     $("#lp-"+$(this).data('id')).addClass('editor-active');
	//     if ($('#textwrapper').hasClass('editor-inactive')) {
	//         $('#textwrapper').removeClass('editor-inactive');
	//     } else {
	//         $('#textwrapper').addClass('editor-inactive');
	//     }
	// });
	// $('input[data-id]').click(function () {
	// 	$('.lp-email-section').removeClass('editor-active');
	// 	$("#lp-"+$(this).data('id')).addClass('editor-active');
    //
	// 	if ($('#textwrapper').hasClass('hide')) {
	// 		$('#textwrapper').removeClass('hide');
	// 	} else {
	// 		$('#textwrapper').addClass('hide');
	// 	}
	// });

	$('input[data-id]').click(function(){
		if($('#r3').is(':checked')){
			$('#textwrapper').removeClass('editor-inactive');
			$('#lp-html-editor').addClass('editor-active');
			$('#lp-text-editor').removeClass('editor-active');
			$('#active_respondertext').val('n');
			$('#active_responderhtml').val('y');
            $('#theoption').val('html');
		}else{
            $('#active_respondertext').val('y');
            $('#active_responderhtml').val('n');
			$('#textwrapper').addClass('editor-inactive');
			$('#lp-html-editor').removeClass('editor-active');
			$('#lp-text-editor').addClass('editor-active');
            $('#theoption').val('text');
		}
	});

	$( "body" ).on( "change","#autoreschk" , function() {
		var active_value="n";
		if($("#autoreschk:checked").val()){
			active_value="y";
		}
		var con_key=$(this).data('lpkeys')+"~"+$('input[name=theoption]:checked').val()+"_active";
		includeauto(con_key);
    });
	/*
	 *
	 // Auto responder form validation
	 *
	 */
	var $form = $("#add_autoresponder"),
    $successMsg = $(".alert");
	$form.validate({
	    rules: {
	        subline: {
	            required: true
	        }
	    },
	    messages: {
	        subline:"please specify the message subject"
	    },
	    submitHandler: function(form) {
	        form.submit();
	    }

	});

    if($('#auto_active').val()=='html'){
        $( "#r3" ).trigger( "click" );
    }else{
        $( "#r4" ).trigger( "click" );
    }
});
	function saveautooptions() {
		$("#sinle").val($("#subline").val());
        $('#add_autoresponder').submit();
	}

	function includeauto(lpkeys,active_value) {
		var client_id = $('#client_id').val();
		var akeys = lpkeys.split("~");
		var vertical_id = akeys[0];
		var subvertical_id = akeys[1];
		var leadpop_id = akeys[2];
		var version_seq = akeys[3];
		var thelink =  akeys[4];
		var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink + "&_token="+ajax_token;
		$.ajax( {
			type : "POST",
			url: site.baseUrl+site.lpPath+'/popadmin/updateautoresponder',
			//url : "/updateautorespondertest.php",
			data : post,
			success : function(d) {
				//                         alert(d);
				var change = d.split("~");
				var imgId = change[0];
				var toggle = change[1];
				var active = change[2];
				$('#active_responderhtml , #active_respondertext').val(active);
				if(toggle == 'y') {
					$('#thankyou_activelink').attr('href',"#");
					$('#information_activelink').attr('href',"#");
					$('#thirdparty_activelink').attr('href',"#");
				}
				if (active == 'y') {
				// $('#'+imgId).attr('src','/images/active.png');
				$('#text_active').attr('src','/images/active.png');
				$('#html_active').attr('src','/images/active.png');
				}else if(active == 'n') {
					// $('#'+imgId).attr('src','/images/inactive.png');
					$('#text_active').attr('src','/images/inactive.png');
					$('#html_active').attr('src','/images/inactive.png');
				}
			},
			cache : false,
			async : false
		});

	}
