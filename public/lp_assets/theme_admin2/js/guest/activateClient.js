$(document).ready(function () {
    var $errorText = $('.errorTxt');
    var $password = $('#password');
    var $confirmPassword = $('#confirm_password');
    var $passValidationIcon = $password.next().find('.validation');
    var $conPassValidationIcon = $confirmPassword.next().find('.validation');

    /*
    * Tooltip for toggle input view button
    * */
    var $tooltip =  $('.tooltip').tooltipster({
        side: 'top'
    });


    /*
    * Password & confirm password keyup event
    * */
    $password.on('keyup',function (e) {
        var code = e.keyCode || e.which;
        if (code == '9') {
            e.preventDefault();
        }else {
            if ($password.val() == ''){
                $errorText.text("Please enter your new password.").show();
            }else {
                if (this.value.length >= 5){
                    $password.addClass("valid");
                    $passValidationIcon.css('display','flex');
                    $passValidationIcon.addClass('valid');
                    $passValidationIcon.html('<i class="fas fa-check" ></i>');
                    $errorText.hide();
                    if ($confirmPassword.val() !== ""){
                        if ($password.val() != $confirmPassword.val()){
                            $confirmPassword.removeClass("valid");
                            $conPassValidationIcon.css('display','flex');
                            $conPassValidationIcon.removeClass('valid');
                            $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
                            $errorText.text("Password and confirmation password do not match.").show();
                        }else {
                            $confirmPassword.addClass("valid");
                            $conPassValidationIcon.addClass('valid');
                            $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
                            $errorText.hide();
                        }
                    }
                }else {
                    $(this).removeClass("valid");
                    $passValidationIcon.css('display','flex');
                    $passValidationIcon.removeClass('valid');
                    $passValidationIcon.html('<i class="fas fa-times" ></i>');
                    $errorText.text("Please enter at least 5 characters.").show();
                }
            }
        }
        form_submmit();
    });

    $confirmPassword.on('keyup',function (e) {
        var code = e.keyCode || e.which;
        if (code == '9') {
            e.preventDefault();
        }else {
            if ($password.val() == ''){
                $errorText.text("Please enter your new password.").show();
            }else {
                if ($confirmPassword.val() == ''){
                    $errorText.text("Pleas enter your confirm password.").show();
                }else {
                    if ($password.val() != $confirmPassword.val()){
                        $confirmPassword.removeClass("valid");
                        $conPassValidationIcon.css('display','flex');
                        $conPassValidationIcon.removeClass('valid');
                        $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
                        $errorText.text("Password and confirmation password do not match.").show();
                    }else {
                        $confirmPassword.addClass("valid");
                        $conPassValidationIcon.addClass('valid');
                        $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
                        $errorText.hide();
                    }
                }
            }
        }
        form_submmit();
    });

    /*
    * Password & confirm password blur event
    * */
    $password.on('focus',function () {
        $(".server-side-errors").hide();
        if($(this).val() == '') {
            $errorText.text("Please enter your new password.").show();
        }else {
            if ($password.val() != $confirmPassword.val()){
                $confirmPassword.removeClass("valid");
                $conPassValidationIcon.css('display','flex');
                $conPassValidationIcon.removeClass('valid');
                $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
                $errorText.text("Password and confirmation password do not match.").show();
            }else {
                $confirmPassword.addClass("valid");
                $conPassValidationIcon.addClass('valid');
                $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
                $errorText.hide();
            }
        }
        form_submmit();
    });
    $confirmPassword.on('focus',function () {
        $(".server-side-errors").hide();
        if ($password.val() == ''){
            $errorText.text("Please enter your new password.").show();
        }else {
            if (this.value == ''){
                $errorText.text("Pleas enter your confirm password.").show();
            }else {
                if ($password.val() != $confirmPassword.val()){
                    $confirmPassword.removeClass("valid");
                    $conPassValidationIcon.css('display','flex');
                    $conPassValidationIcon.removeClass('valid');
                    $conPassValidationIcon.html('<i class="fas fa-times" ></i>');
                    $errorText.text("Password and confirmation password do not match.").show();
                }else {
                    $confirmPassword.addClass("valid");
                    $conPassValidationIcon.addClass('valid');
                    $conPassValidationIcon.html('<i class="fas fa-check" ></i>');
                    $errorText.hide();
                }
            }
        }
        form_submmit();
    });

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
});
