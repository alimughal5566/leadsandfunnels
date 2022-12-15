$(document).ready(function () {

    var $errorText = $('.errorTxt');
    var $password = $('#password');
    var $confirmPassword = $('#confirm_password');
    // var $passValidationIcon = $password.next().find('.validation');
    var $conPassValidationIcon = $confirmPassword.next().find('.validation');
    var passwordKeyupValidate = false;
    var crfPasswordKeyupValidate = false;

    /*
    * Tooltip for toggle input view button
    * */

    var $tooltip =  $('.tooltip').tooltipster({
        side: 'top'
    });

    $('#password').focus();

    function invalidHandler($selector) {
        var $passValidationIcon = $selector.parents('.lp-input__holder').find('.validation');
        $selector.removeClass("valid");
        $passValidationIcon.css('display','flex');
        $passValidationIcon.removeClass('valid');
        $passValidationIcon.html('<i class="fas fa-times" ></i>');
    }

    function validHandler($selector){
        var $passValidationIcon = $selector.parents('.lp-input__holder').find('.validation');
        $selector.addClass("valid");
        $passValidationIcon.css('display','flex');
        $passValidationIcon.addClass('valid');
        $passValidationIcon.html('<i class="fas fa-check" ></i>');
        $errorText.hide();
    }

    function newPasswordValidation() {
        if($password.val() == ''){
            if(!passwordKeyupValidate)return;
            invalidHandler.call(this, $password);
            $errorText.text("Please enter your new password.").show();
        }else{
            if($(this).val().length >= 5){
                validHandler.call(this, $password);
                passwordKeyupValidate = true;
                if($confirmPassword.val().length >= 5){
                    passwordMatch();
                }
            }else{
                if(!passwordKeyupValidate)return;
                invalidHandler.call(this, $password);
                $errorText.text("Please enter at least 5 characters.").show();
            }
        }
        form_submmit();
    }

    function passwordMatch() {
        crfPasswordKeyupValidate = true;
        if ($password.val() != $confirmPassword.val()){
            invalidHandler.call(this, $confirmPassword);
            $errorText.text("Password and confirmation password do not match.").show();
        }else{
            // validHandler.call(this, $password);
            validHandler.call(this, $confirmPassword);
        }
    }

    function confirmPasswordValidation() {

        if($password.val() == '' || !$password.hasClass('valid'))return;

        if ($confirmPassword.val() == ''){
            $errorText.text("Pleas enter your confirm password.").show();
            invalidHandler.call(this, $confirmPassword);
        }else {
            if ($password.val() != $confirmPassword.val()){
                if(!crfPasswordKeyupValidate)return;
                invalidHandler.call(this, $confirmPassword);
                $errorText.text("Password and confirmation password do not match.").show();
            }else {
                if($confirmPassword.val().length < 5){
                    $errorText.text("Please enter at least 5 characters.").show();
                    invalidHandler.call(this, $confirmPassword);
                    return;
                }
                crfPasswordKeyupValidate = true;
                validHandler.call(this, $confirmPassword)
            }
        }
        form_submmit();
    }

    $password.on('keyup',function (e) {
        var keycode = e.keyCode || e.which;
        if(keycode == 9)return;
        newPasswordValidation.call(this);
    });

    $password.on('blur',function (e) {
        var keycode = e.keyCode || e.which;
        if(keycode == 9)return;
        if($(this).val() != ''){
            passwordKeyupValidate = true;
        }
        newPasswordValidation.call(this);
    });

    $confirmPassword.on('keyup',function (e) {
        var keycode = e.keyCode || e.which;
        if(keycode == 9)return;
        confirmPasswordValidation.call(this);
    });

    $confirmPassword.on('blur',function (e) {
        var keycode = e.keyCode || e.which;
        if(keycode == 9)return;
        crfPasswordKeyupValidate = true;
        confirmPasswordValidation.call(this);
    });

    /*
    * Password & confirm password keyup event
    * */

    // $password.on('keyup',function (e) {
    //     var code = e.keyCode || e.which;
    //     if (code == '9') {
    //         e.preventDefault();
    //     }else {
    //         if ($password.val() == ''){
    //             $errorText.text("Please enter your new password.").show();
    //         }else {
    //             if (this.value.length >= 5){
    //                 $password.addClass("valid");
    //                 $passValidationIcon.css('display','flex');
    //                 $passValidationIcon.addClass('valid');
    //                 $passValidationIcon.html('<i class="fas fa-check" ></i>');
    //                 $errorText.hide();
    //                 if ($confirmPassword.val() !== ""){
    //                     if ($password.val() != $confirmPassword.val()){
    //                         $confirmPassword.removeClass("valid");
    //                         $conPassValidationIcon.css('display','flex');
    //                         $conPassValidationIcon.removeClass('valid');
    //                         $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
    //                         $errorText.text("Password and confirmation password do not match.").show();
    //                     }else {
    //                         $confirmPassword.addClass("valid");
    //                         $conPassValidationIcon.addClass('valid');
    //                         $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
    //                         $errorText.hide();
    //                     }
    //                 }
    //             }else {
    //                 $(this).removeClass("valid");
    //                 $passValidationIcon.css('display','flex');
    //                 $passValidationIcon.removeClass('valid');
    //                 $passValidationIcon.html('<i class="fas fa-times" ></i>');
    //                 $errorText.text("Please enter at least 5 characters.").show();
    //             }
    //         }
    //     }
    //     form_submmit();
    // });
    // $confirmPassword.on('keyup',function (e) {
    //     var code = e.keyCode || e.which;
    //     if (code == '9') {
    //         e.preventDefault();
    //     }else {
    //         if ($password.val() == ''){
    //             $errorText.text("Please enter your new password.").show();
    //         }else {
    //             if ($confirmPassword.val() == ''){
    //                 $errorText.text("Pleas enter your confirm password.").show();
    //             }else {
    //                 if ($password.val() != $confirmPassword.val()){
    //                     $confirmPassword.removeClass("valid");
    //                     $conPassValidationIcon.css('display','flex');
    //                     $conPassValidationIcon.removeClass('valid');
    //                     $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
    //                     $errorText.text("Password and confirmation password do not match.").show();
    //                 }else {
    //                     $confirmPassword.addClass("valid");
    //                     $conPassValidationIcon.addClass('valid');
    //                     $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
    //                     $errorText.hide();
    //                 }
    //             }
    //         }
    //     }
    //     form_submmit();
    // });

    /*
    * Password & confirm password blur event
    * */


    // $password.on('focus',function () {
    //     if($(this).val() == '') {
    //         $errorText.text("Please enter your new password.").show();
    //     }else {
    //         if ($password.val() != $confirmPassword.val()){
    //             $confirmPassword.removeClass("valid");
    //             $conPassValidationIcon.css('display','flex');
    //             $conPassValidationIcon.removeClass('valid');
    //             $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
    //             $errorText.text("Password and confirmation password do not match.").show();
    //         }else {
    //             $confirmPassword.addClass("valid");
    //             $conPassValidationIcon.addClass('valid');
    //             $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
    //             $errorText.hide();
    //         }
    //     }
    //     form_submmit();
    // });
    // $confirmPassword.on('focus',function () {
    //     if ($password.val() == ''){
    //         $errorText.text("Please enter your new password.").show();
    //     }else {
    //         if (this.value == ''){
    //             $errorText.text("Pleas enter your confirm password.").show();
    //         }else {
    //             if ($password.val() != $confirmPassword.val()){
    //                 $confirmPassword.removeClass("valid");
    //                 $conPassValidationIcon.css('display','flex');
    //                 $conPassValidationIcon.removeClass('valid');
    //                 $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
    //                 $errorText.text("Password and confirmation password do not match.").show();
    //             }else {
    //                 $confirmPassword.addClass("valid");
    //                 $conPassValidationIcon.addClass('valid');
    //                 $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
    //                 $errorText.hide();
    //             }
    //         }
    //     }
    //     form_submmit();
    // });

    /*
    * Toggle view input type
    * */

    $('.view').click(function () {
        $input = $(this).parents('.lp-input__holder').find('input');
        var type = $input.attr('type');
        $(this).find('i').toggleClass('fa-eye');
        $(this).find('i').toggleClass('fa-ban');
        if (type == "password"){
            $(this).tooltipster('content', 'Hide Password');
            $input.attr('type', 'text');
        }else {
            $(this).tooltipster('content', 'Show Password');
            $input.attr('type', 'password');
        }
    });

    /*
    * All field validation checker
    * */

    function form_submmit(){
        var form_submit = true;
        $('.lp-input__holder').each(function(){
            if(!$(this).find('input').hasClass('valid')){
                form_submit = false;
            }
        });
        if(form_submit){
            $('#button-submit').removeClass('button-invalid');
        }else {
            $('#button-submit').addClass('button-invalid');
        }
    }

    /* AB's code */
    $('#button-submit').click(function (e) {
        e.preventDefault();
        var length = 2;
        var validLength = $('#reset-password .lp-input__field.valid').length;
        console.log(validLength);
        if(length == validLength) {
            $(this).addClass('spinner-active');
            setTimeout(function () {
                $('#button-submit').removeClass('spinner-active');
                $('#reset-password').addClass('success-active');
            }, 2000);
            setTimeout(function () {
                $('#reset-password').submit();
            }, 4000);
        }
    });
});