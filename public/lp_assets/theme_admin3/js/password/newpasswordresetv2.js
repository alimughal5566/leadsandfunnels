var changePassword = {
    reset_form: jQuery("#reset-password-form"),

    /*
    ** Reset Password validation Function
    **/
    resetPassword: function() {
        changePassword.reset_form.validate({
            rules: {
                password: {
                    required: true,
                    minlength: 5
                },
                password2: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                password: {
                    required: "Please enter your new password."
                },
                password2: {
                    required: "Please confirm your new password."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    },


    /*
    ** Submit the form with enter key Function
    **/
    enterKey: function () {
        jQuery("form input").keypress(function (e) {
            if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                var target_ele="";
                if(jQuery(this).attr('name') == 'password' || jQuery(this).attr('name') == 'password2'){
                    console.log("Reset password", jQuery(this).attr('name'));

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
    ** init Function
    **/
    init: function () {
        changePassword.resetPassword();
        changePassword.enterKey();
    },
};

jQuery(document).ready(function () {
    changePassword.init();
});

