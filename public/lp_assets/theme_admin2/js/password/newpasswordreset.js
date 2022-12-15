

$(document).ready(function() {

    var $form = $("#reset-password-form"),
        $successMsg = $(".alert");
    var login = $form.validate({
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
        submitHandler: function (form) {
            form.submit();
        }
    });
    //
    // $(document).on('click' , '#reset-password-btn' ,function(e){
    //     e.preventDefault();
    //     $("#reset-password-form").submit();
    // });
});
