$(document).ready(function() {
    module.init();

    //*
    // ** Alert Messages Panel
    // *

    $(".alert__messages .close").click(function () {
        $(".alert__messages").slideUp();
    });


    //*
    // ** Validation Js Account Page
    // *

    $.validator.addMethod("phoneValid", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Please enter a valid phone number.");

    $.validator.addMethod("lowcase_password", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "At least 1 lowercase letter (a-z).");

    $.validator.addMethod("uppercase_password", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "At least 1 uppercase letter (A-Z).");

    $.validator.addMethod("number_password", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "At least 1 number (0-9)");

    $.validator.addMethod("no_space", function (value, element, regexpr) {
        return $.trim( value );
    }, "This field is required.");

    ajaxRequestHandler.init("#fcontactinfo");
    var valid_obj = $('#fcontactinfo').validate({
        rules: {
            profile_img: {
                // required: true,
                accept: false
            },
            first_name: {
                required: true,
                no_space:true
            },
            last_name: {
                required: true,
                no_space:true
            },
            contact_email: {
                required: true,
                cus_email: true
            },
            password: {
                minlength: 5,
                // required: true,
                // lowcase_password: /[A-z]/,
                // uppercase_password: /[A-Z]/,
                // number_password:  /\d/
            },
            confirmpassword: {
                equalTo: "#password"
            },
            company_name: {
                required: true,
                no_space:true
            },
            cell_number: {
                required: true,
                phoneValid: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/
            },
            carrier: {
                required: true,
            },
            address1: {
                required: true,
                no_space:true
            },
            city: {
                required: true,
                no_space:true
            },
            state: {
                required: true
            },
            zip: {
                required: true,
                no_space:true
            }
        },
        messages: {
            first_name: {
                required: "Please enter your first name."
            },
            last_name: {
                required: "Please enter your last name."
            },
            contact_email: {
                required: "Please enter your email address."
            },
            password: {
                required: "Please enter your password.",
                minlength:"Please enter at least 5 characters."

            },
            confirmpassword: {
                required: "Confirm password field is required.",
                equalTo: "Both passwords are not matching."
            },
            company_name: {
                required: "Please enter your company name."
            },
            cell_number: {
                required: "Please enter your phone number."
            },
            carrier: {
                required: "Please select your cell carrier."
            },
            address1: {
                required: "Please enter your address."
            },
            city: {
                required: "Please enter your city name."
            },
            state: {
                required: "Please select your state."
            },
            zip: {
                required: "Please enter your zip code."
            }
        },
        onfocusout: false,
        onkeyup: function (element){
            this.hideThese( this.errorsFor( element ) );
            $(element).removeClass(this.settings.errorClass);
        },
        onclick: false,
        submitHandler: function (form) {
            let url = ajaxRequestHandler.form.attr('action');
            ajaxRequestHandler.sendRequest(url, function (response, isError) {
                console.log("Profile callback...", response);
            });
            // form.submit();
        }
    });

    //*
    // ** Input Mask Init
    // *

    selector = $('#cell_phone');
    var im = new Inputmask("(999) 999-9999");
    im.mask(selector);
    $('#cell_phone').keyup(function(e){
        console.log(e.keyCode);
        if(e.keyCode == 8)
        {
            return true;
        }
        /*console.log($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'$1-$2-$3'))*/
        if(e.keyCode > 36 && e.keyCode < 41)
        {
            return true;
        }
        if ((e.keyCode > 47 && e.keyCode <58) || (e.keyCode < 106 && e.keyCode > 95))
        {
            $(this).val($(this).val().replace(/(\d{3})\-?(\d{3})\-?(\d{4})/,'($1) $2-$3'))
            //this.value = this.value.replace(/(\d{3})\-?/g,'$1-');
            return true;
        }
        //this.value = this.value.replace(/[^\-0-9]/g,'');
        this.value = this.value.replace(/[\-\(\)\W]/g,'');
    });

    //*
    // ** Select2 Js Init
    // *

    var amIclosing = false;


    $('#state').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-state')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-state .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-state .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-state .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-state .select2-dropdown').hide();
        jQuery('.select2__parent-state .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-state .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-state .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#state').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 100);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-state .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#state').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2-results__options .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2-results__options .select2-selection__rendered').show();
        jQuery('.select2-results__options .select2-results__options').css('pointer-events', 'none');
    });


    $('#cell_carrier').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-cell-carrier')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-cell-carrier .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-cell-carrier .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-cell-carrier .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-cell-carrier .select2-dropdown').hide();
        jQuery('.select2__parent-cell-carrier .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-cell-carrier .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-cell-carrier .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#cell_carrier').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-cell-carrier .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#cell_carrier').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2-results__options .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2-results__options .select2-selection__rendered').show();
        jQuery('.select2-results__options .select2-results__options').css('pointer-events', 'none');
    });

    //*
    // **  Profile Image Preview
    // *

    function readURL(input) {
        if (input.files && input.files[0]) {

            /*
             ** Profile Image Upload Validation
             */

            var file = input.files[0];
            if ($.inArray(file.type, ['image/png','image/jpg','image/jpeg']) == -1){
                $('.file__extension').slideDown("slow");
                $('.file__size').slideUp("slow");
            }else if((file.size/1024/1024) > 2) {
                $('.file__size').slideDown("slow");
                $('.file__extension').slideUp("slow");

            }else{
                $('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.lp-image__preview,.user-image').html("");
                    $(".user-image").removeClass("no-image");
                    $('.lp-image__preview').css('background-image', 'url('+e.target.result +')');
                    $('.user-image').html('<img src="'+e.target.result +'">');

                    $(".lp-image__uploader").addClass("has__background");
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    $(".btn-image__upload").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function() {
        readURL(this);
        // valid_obj.form();
    });

    //*
    // **  Delete Profile Image Preview
    // *

    $(".btn-image__del").click(function () {
        $('.lp-image__preview,.user-image').html($('.lp-image__preview').attr("noProfileImageText"));
        $('.lp-image__preview').removeAttr("style");
        $(".user-image").addClass("no-image");
        $("#profile_img").val('').trigger("change");
        $(".lp-image__uploader").removeClass("has__background");
        $("#delete_image").val('y');
    });

    //*
    // **  Nice Scroll Global Style ((== select2js ==))
    // *

});

var module = {
    init: function(){
        if( $('input[name=textcell]:checked').val() == 'y'){
            $(".text_cell_carrier").slideDown();
        }else{
            $(".text_cell_carrier").slideUp();
        }

        $('input[name=textcell]').change(function(e){
            if($(this).val() == 'y')
                $(".text_cell_carrier").slideDown();
            else
                $(".text_cell_carrier").slideUp();

        });

        module.formSubmit();
    },
    formSubmit: function(){
        $("#main-submit").click(function(e){
            $('#fcontactinfo').submit();
        });
    },
    formValidate: function(){
        // var is_valid = true;
        //LP-TODO: Develop the validation logic here
        // return is_valid;

    }
}


$(window).on('load', function (){
    $('#cb-frame').attr('scrolling', 'no');
})
