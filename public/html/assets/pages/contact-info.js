$(document).ready(function(){
    $( "body" ).on( "change",".conttogbtn" , function() {
        var con_key=$(this).data('lpkeys');
        contactinclude(con_key);
    });


    $('.button-save').click(function () {
       $form.submit();
    });

    /*
     *
     // contact info form validation
     *
     */
    var $form = $("#contact-info"),
        $successMsg = $(".alert");
    $.validator.addMethod("emailValid", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Please enter a valid email address.");
    $form.validate({
        rules: {
            company_name: {
                required: true
            },
            phone_number: {
                required: true
            },
            email: {
                required: true,
                emailValid: /(.+)@(.+){2,}\.(.+){2,}/
            }
        },
        messages: {
            company_name: {
                required: "Please enter the company name."
            },
            phone_number: {
                required: "Please enter your phone number."
            },
            email: {
                required: "Please add your email address."
            }

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
    var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink;
    $.ajax( {
        type : "POST",
        url : "/updatecontact.php",
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

