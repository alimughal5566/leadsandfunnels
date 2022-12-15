$(document).ready(function(){
	$( "body" ).on( "change",".seotogbtn" , function() {
		var con_key=$(this).data('lpkeys');
		seoinclude(con_key);
    });

	/*
	 *
	 // SEO form validation
	 *
	 */
	var $form = $("#add-seo"),
    $successMsg = $(".alert");
	$form.validate({
	    rules: {
	        /*titletag: {
	            required: true
	        },
	        description: {
	            required: true,
	            minlength:100
	        },
	        metatags: {
	            required: true,
	            minlength:50
	        }*/
	    },
	    messages: {
	        /*titletag:"please specify the title tag",
	        description: {
	            required:"Please enter your description",
	            minlength:"Write more than 100 letters"
	        },
	        metatags: {
	            required:"Please specify your success keywords",
	            minlength:"Enter minimum 50 letter."
	        }*/
	    },
	    submitHandler: function(form) {
	        form.submit();
	    }
	});

});
function seoinclude(lpkeys) { // hogs
	var client_id = $('#client_id').val();
	var akeys = lpkeys.split("~");
	var vertical_id = akeys[0];
	var subvertical_id = akeys[1];
	var leadpop_id = akeys[2];
	var version_seq = akeys[3];
	var thelink =  akeys[4];
	var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink;
	//alert(post);
	$.ajax( {
		type : "POST",
		url : "/updateseotags.php",
		data : post,
		success : function(d) {
		    //alert(d);
			var change = d.split("~");
			var imgId = change[0];
			var toggle = change[1];
			if(toggle == 'y') {
				$('#'+imgId).attr('src','/images/active.png');
			}
			else   if(toggle == 'n') {
				$('#'+imgId).attr('src','/images/inactive.png');
			}
		},
		cache : false,
		async : false
	});
}
