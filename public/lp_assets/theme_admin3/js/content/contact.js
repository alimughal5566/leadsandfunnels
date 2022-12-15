$(document).ready(function(){
	$( "body" ).on( "change",".conttogbtn" , function() {

		var con_key=$(this).data('lpkeys');

		// if(!GLOBAL_ADJUSTMENT) {
		//	debugger;

			// In case of Global mode it will work on form submit instead of ajax

			/*if(!GLOBAL_MODE) {
                var checked = $(this).prop('checked');
                contactinclude(con_key);
            }*/


            if ($(this).prop('checked') == true) {
                $('#'+$(this).data('field')).val('y');
            } else {
                $('#'+$(this).data('field')).val('n');
            }
        // }
    });



	/*
	 *
	 // contact info form validation
	 *
	 */
	var $form = $("#contact-info");
    ajaxRequestHandler.init("#contact-info");

    $('#main-submit').on('click', function () {
        $form.submit();
    });

    $form.validate({
	    rules: {
	        companyname: {
                required: function (element) {
                	// console.log('companyname_tbt =>' + $('.companyname_tbt').prop("checked"));
                    return $('.companyname_tbt').prop("checked");
                }
            },
	        phonenumber: {
	            required: function (element) {
                    // console.log('phonenumber_tbt =>' + $('.phonenumber_tbt').prop("checked"));
                    return $('.phonenumber_tbt').prop("checked");
                }
	        },
	        email: {
	            required: function (element) {
                    // console.log('email_tbt =>' + $('.email_tbt').prop("checked"));
                    return $('.email_tbt').prop("checked");
                },
                cus_email:true
	        }
	    },
	    messages: {
	        companyname:"Please enter the company name.",
	        phonenumber:"Please enter your phone number.",
	        email: {
                required: "Please enter your email address."
            }

	    },
	    submitHandler: function(form) {
            ajaxRequestHandler.submitForm(function (response, isError) {
                console.log("submit callback...", response, isError);
            });

            // if (GLOBAL_MODE) {
            //     if (checkIfFunnelsSelected()){
            //         //  debugger;
            //         if(confirmationModalObj.globalConfirmationCurrentForm == $form){
            //             form.submit();
            //         } else {
            //             showGlobalRequestConfirmationForm($form);
            //         }
            //     }
            //     // form.submit();
            // } else {
            //     form.submit();
            // }
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

