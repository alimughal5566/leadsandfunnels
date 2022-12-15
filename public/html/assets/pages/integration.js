$(document).ready(function () {

    //integrations-funnel page

    $(".integration__box").click(function () {
        $(".integration__box").removeClass("integration__box_active");
        $(this).addClass("integration__box_active");
    });


    $('#velocify_form').validate({
        rules: {
            api_key: {
                required: true

            }
        },
        messages: {
            api_key: {
                required: "This field is required."
            }
        },
        debug: true,
        submitHandler: function () {
            console.info('submitted');
        }
    });



    $('#bntouch_form').validate({
        rules: {
            user_name: {
                required: true
            },
            password: {
                required: true,
                minlength: 5
            },
            sec_token: {
                required: true
            }
        },
        messages: {
            user_name: {
                required: "Please enter your first name."
            },
            password: {
                required: "Please enter your password.",
                minlength:"Please enter at least 5 characters."
            },
            sec_token: {
                required: "Please enter your security token.",
            }
        },
        debug: true,
        submitHandler: function () {
            console.info('submitted');
        }
    });


    $('#mortech_form').validate({
        rules: {
            user_name: {
                required: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            user_name: {
                required: "Please enter your first name."
            },
            password: {
                required: "Please enter your password.",
                minlength:"Please enter at least 5 characters."
            }
        },
        debug: true,
        submitHandler: function () {
            console.info('submitted');
        }
    });

    $( "body" ).on( "change","#homebot-contact" , function() {
        if($(this).is(":checked")){
            $('.authenticate__placeholder').slideDown();
            $('.authenticate__panel').slideUp();
        }else {
            $('.authenticate__placeholder').slideUp();
            $('.authenticate__panel').slideDown();
        }
    });



});