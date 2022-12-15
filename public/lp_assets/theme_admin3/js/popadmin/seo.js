$(document).ready(function() {
    var $form = $('#add-seo');
    ajaxRequestHandler.init("#add-seo");
    $('#main-submit').on('click', function () {
        $form.submit();
    });

    //*
    // ** Validation Js Account Page
    // *

    $('#add-seo').validate({
        onfocusout: false,
        rules: {
            titletag: {
                required: {
                    depends: function () { return $("#seo_title_active").val() == 'y' }
                }
            },

            metatags: {
                required: {
                    depends: function () { return $("#seo_keyword_active").val() == 'y' }
                }

            },
            description: {
                required: {
                    depends: function () { return $("#seo_description_active").val() == 'y' }
                }
            }
        },
        messages: {
            titletag: {
                required: "Please enter your title tag."
            },

            metatags: {
                required: "Please enter your keywords."
            },
            description: {
                required: "Please enter your description."
            }
        },
        submitHandler: function(form) {
            ajaxRequestHandler.submitForm(function (response, isError) {
                console.log("submit callback...", response, isError);
            });
	    }
    });

    /**
     * Toggle Button Functionality
     */
	$( "body" ).on( "change",".seotogbtn" , function() {
		var con_key=$(this).data('lpkeys');

		// AJAX REQUEST DEPRECATED
		/*
		if(!GLOBAL_MODE) {
            seoinclude(con_key);
        }
		*/

        if ($(this).prop('checked') == true) {
           $('#' + $(this).data('field')).val('y')
        } else {
            $('#' + $(this).data('field')).val('n')
        }
    });

    function seoinclude(lpkeys) { // hogs
        var client_id = $('#client_id').val();
        var akeys = lpkeys.split("~");
        var vertical_id = akeys[0];
        var subvertical_id = akeys[1];
        var leadpop_id = akeys[2];
        var version_seq = akeys[3];
        var thelink =  akeys[4];
        var post =  "client_id=" + client_id + "&vertical_id=" +
            vertical_id +  "&subvertical_id=" +
            subvertical_id + "&leadpop_id=" +
            leadpop_id + "&version_seq=" +
            version_seq + "&thelink=" +
            thelink + "&_token="+ajax_token;

        //alert(post);
        $.ajax( {
            type : "POST",
            url : "/lp/ajax/updateseotags",
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
});
