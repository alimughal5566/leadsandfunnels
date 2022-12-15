$(document).ready(function() {
    // Login form validation
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    var $form = $("#go"),
        $successMsg = $(".alert");
    var login = $form.validate({
        rules: {
            un: {
                required: true,
                email: true
            },
            pw: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            un: {
                required: "Please enter your email address.",
                email:"Please enter a valid email address."
            },
            pw: {
                required: "Please enter your password."
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });


    var $form = $("#goemma"),
        $successMsg = $(".alert");
    var fire_login = $form.validate({
        rules: {
            username: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            username: {
                required: "Please enter your email address.",
                email:"Please enter a valid email address."
            },
            password: {
                required: "Please enter your password."
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });


    var $form = $("#reset-password-form"),
        $successMsg = $(".alert");
    var reset_password =  $form.validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter your email address.",
                email:"Please enter a valid email address."
            }
        },
        submitHandler: function(form) {
            var email = $("#email").val();
            $.ajax( {
                type : "POST",
                // url :  site.baseUrl+"/lp/password/forgotpassword",
                url: site.baseUrl+"/lp/password/reset_link",
                data : "email=" + email+'&_token='+ajax_token,
                success : function(value) {
                    if (value.indexOf("error") >= 0){
                        if(!validEmail(email)){
                            $("#reset-password-alert").removeClass("alert-success").addClass("alert-danger");
                            $("#reset-password-alert").html("Please enter a valid email address.");
                            $("#reset-password-alert").show();
                        } else {
                            $("#reset-password-alert").removeClass("alert-success").addClass("alert-danger");
                            $("#reset-password-alert").html("<strong>Error:</strong> Sorry, "+email+" is not recognized as a registered email.");
                            $("#reset-password-alert").show();
                        }
                    } else if (value.indexOf("Exception caught:") >= 0){
                        $("#reset-password-alert").removeClass("alert-success").addClass("alert-danger");
                        $("#reset-password-alert").html("<strong>Error:</strong> Sorry, unable to send email.");
                        $("#reset-password-alert").show();
                    } else {
                        $("#email").val('');
                        $("#reset-password-alert").removeClass("alert-danger").addClass("alert-success");
                        $("#reset-password-alert").html("<strong>Success:</strong> Check your email address for the password.");
                        $("#reset-password-alert").show();
                    }

                    $("#reset-password-alert").fadeTo(3000, 500).slideUp(500, function(){
                        $(this).slideUp(500);
                    });
                },
                cache : false,
                async : false
            });
        }
    });


    $(document).on('click' , '#forgot-password' ,function(e){
        e.preventDefault();
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)){ // If Internet Explorer, return version number
            $(this).closest('#login-tabs').addClass('ie-flipped');
            $($(this).closest("#login-tabs")).find('.flip-back').removeClass("flip-back").addClass("ie-flip-back");
            $('.flip-front').hide('100');
        }else{
            $(this).closest('#login-tabs').addClass('flipped');
            $('.flip-front').hide('1000');
        }
        login.resetForm();
    });
    $(document).on('click' , '#forgot-revert' ,function(e){
        e.preventDefault();
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)){ // If Internet Explorer, return version number
            $(this).closest('#login-tabs').removeClass('ie-flipped');
            $($(this).closest("#login-tabs")).find('.ie-flip-back').removeClass("ie-flip-back").addClass("flip-back");
            $('.flip-front').show('100');
        }else{
            $(this).closest('#login-tabs').removeClass('flipped');
            $('.flip-front').show('1000');
        }
        reset_password.resetForm();
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        fire_login.resetForm();
        login.resetForm();
    });
    $(document).on('click' , '#reset-password-btn' ,function(e){
        e.preventDefault();
        $("#reset-password-form").submit();
    });

    if ( getUrlParameter("ok") == "no" ) {
        incorrectLoginNotice();
    }
    $("#lb1").click(function(event){
        $("#go").submit();
        event.preventDefault();
    });
    $("#emmaLoginBtn").click(function( event ) {
        $("#goemma").submit();
        event.preventDefault();
    });
    // Submit the form with enter key
    $("form input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            var target_ele="";
            if($(this).attr('name') == 'un' || $(this).attr('name') == 'pw' ){
                target_ele="#lb1";
            }else if($(this).attr('name') == "username" || $(this).attr('name') == "password"){
                target_ele="#emmaLoginBtn";
            }else if($(this).attr('name') == 'email'){
                target_ele="#reset-password-btn";
            }
            $(target_ele).click();
            return false;
        } else {
            return true;
        }
    });


    // jQuery('.content-reset').slideUp();
    // jQuery(document).on('click' , '#forgot-password' ,function(e){
    //     e.preventDefault();
    //     jQuery('.content-login').slideUp();
    //     jQuery('.content-reset').slideDown();
    // });
    //
    // jQuery(document).on('click' , '#cancel-recovery' ,function(e){
    //     e.preventDefault();
    //     jQuery('.content-login').slideDown();
    //     jQuery('.content-reset').slideUp();
    // });

});
function validEmail(str){
    var patt= /^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/;
    var check = patt.test(str);
    if(check){
        return true;
    }else{
        return false;
    }
}

function incorrectLoginNotice(){
    console.log("incorrectLoginNotice calll");
    return;
    var incorrectLoginNoticeHtml =
        "<div id='incorrectLoginDiv' >" +
        "<p>Incorrect username/password</p>" +
        "<img src='images/x_sign_icon_red.png' style='display:inline-block;' height='100' width='100' alt='Success'>" +
        "<a href='#' onclick='showLoginBox(event)' class='loginButton' style='display:block; width:90%;'>OK</a>" +
        "</div>";
    $("#login1 > *").css("display","none");
    $("#login1").append(incorrectLoginNoticeHtml);
}

function showLoginBox(event){
    $("#login1 > div#incorrectLoginDiv").detach();
    $("#login1 > *").css("display","inline");
    event.preventDefault();
}


function validateEmail(fld) {
    var error = false;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(fld)) {
        error = true;
    }
    return error;
}


function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}
