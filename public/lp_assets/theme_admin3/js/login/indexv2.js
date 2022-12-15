var login = {
    funnel_form: jQuery("#funnel-form"),
    fire_form: jQuery("#fire-form"),
    reset_form: jQuery("#reset-password-form"),

    /*
    ** Funnel Login Form validation Function
    **/
    funnelForm: function () {
        login.funnel_form.validate({
            rules: {
                un: {
                    required: true,
                    cus_email: true
                },
                pw: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                un: {
                    required: "Please enter your email address."
                },
                pw: {
                    required: "Please enter your password."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    },

    /*
    ** Fire Login Form validation Function
    **/
    fireForm: function () {
        login.fire_form.validate({
            rules: {
                username: {
                    required: true,
                    cus_email: true
                },
                password: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                username: {
                    required: "Please enter your email address."
                },
                password: {
                    required: "Please enter your password."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    },

    /*
    ** Filp tabs Function
    **/
    flipTabs: function() {
        jQuery(document).on('click' , '#forgot-password' ,function(e){
            e.preventDefault();
            jQuery(this).closest('#login-tabs').addClass('flipped');
            jQuery(this).parents().find('.login-flip').addClass('flip');
            jQuery('.flip-front').fadeOut('1000');
            jQuery('.login-form').find('.form-control').removeClass('error');
            jQuery('.login-form').find('.form-control').removeClass('error');
            jQuery('.login-form').find('label.error').remove();
        });
        jQuery(document).on('click' , '#forgot-revert' ,function(e){
            e.preventDefault();
            jQuery(this).closest('#login-tabs').removeClass('flipped');
            jQuery(this).parents().find('.login-flip').removeClass('flip');
            jQuery('.flip-front').show('1000');
        });
    },

    /*
    ** Reset Password validation Function
    **/
    resetPassword: function() {
        login.reset_form.validate({
            rules: {
                email: {
                    required: true,
                    cus_email: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email address."
                }
            },
            submitHandler: function(form) {
                var email = $("#email").val();
                $.ajax( {
                    type : "POST",
                    // url :  site.baseUrl+"/lp/password/forgotpassword",
                    url: site.baseUrl+"/lp/password/reset_link",
                    data : "email=" + email,
                    success : function(value) {
                        $(".login-flip").addClass("fliped_height");
                        if (value.indexOf("error") >= 0){
                            if(!validEmail(email)){
                                $("#reset-password-alert").removeClass("alert-success").addClass("alert-danger");
                                $("#reset-password-alert").html("<strong>Error:</strong> Please enter a valid email address.");
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
                            $(".login-flip").removeClass("fliped_height");
                            $(this).slideUp(500);
                        });
                    },
                    cache : false,
                    async : false
                });
            }
        });
    },

    /*
    ** submitResetPassword Function
    **/
    submitResetPassword: function() {
        jQuery(document).on('click' , '#reset-password-btn' ,function(e){
            e.preventDefault();
            jQuery("#reset-password-form").submit();
        });
    },

    /*
    ** Submit the form with enter key Function
    **/
    enterKey: function () {
        jQuery("form input").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                var target_ele="";
                if(jQuery(this).attr('name') == 'un' || jQuery(this).attr('name') == 'pw' ){
                    target_ele="#lb1";
                }else if(jQuery(this).attr('name') == "username" || jQuery(this).attr('name') == "password"){
                    target_ele="#emmaLoginBtn";
                }else if(jQuery(this).attr('name') == 'email'){
                    target_ele="#reset-password-btn";
                }
                jQuery(target_ele).click();
                return false;
            } else {
                return true;
            }
        });
    },

    /*
    ** Change tabs Function
    **/
    loginTabs: function() {
        jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            jQuery('.login-form').find('.form-control').removeClass('error');
            jQuery('.login-form').find('.form-control').removeClass('error');
            jQuery('.login-form').find('label.error').remove();
        })
    },

    /*
    ** init Function
    **/
    init: function () {
        login.funnelForm();
        login.fireForm();
        login.flipTabs();
        login.resetPassword();
        login.enterKey();
        login.submitResetPassword();
        login.loginTabs();

        jQuery("#lb1").click(function(event){
            $("#funnel-form").submit();
            event.preventDefault();
        });

        jQuery("#emmaLoginBtn").click(function(event) {
            $("#fire-form").submit();
            event.preventDefault();
        });
    },
};

jQuery(document).ready(function () {
    login.init();
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
