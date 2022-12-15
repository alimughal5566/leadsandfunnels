$(document).ready(function(){
	$( "body" ).on( "change",".conttogbtn" , function() {
		var con_key=$(this).data('lpkeys');
		contactinclude(con_key);
    });
	/*
	 *
	 // contact info form validation
	 *
	 */
	var $form = $("#contact-info"),
	$successMsg = $(".alert");
	$form.validate({
	    rules: {
	        companyname: {
                required: function (element) {
                    return $('.companyname_tbt').prop("checked");
                }
            },
	        phonenumber: {
	            required: function (element) {
                    return $('.phonenumber_tbt').prop("checked");
                }
	        },
	        email: {
	            required: function (element) {
                    return $('.email_tbt').prop("checked");
                },
	            email:true
	        }
	    },
	    messages: {
	        companyname:"please specify the company name",
	        phonenumber:"Please enter the phone number",
	        email: "Please specify a valid email address"

	    },
	    submitHandler: function(form) {
	        form.submit();
	    }

	});    

});
function contactinclude(lpkeys) { // hogs
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
	    url : "/lp/ajax/updatecontact",
	    data : post,
	    success : function(d) {
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

