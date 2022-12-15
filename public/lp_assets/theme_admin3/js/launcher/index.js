var funnel_template = {

    /**
     ** Swatches Function
     **/
    SwatchesInit: function () {
        jQuery('body').on('change', '.list-swatches__li input[type=radio]', function () {
            var colorCode = jQuery(this).attr('data-color');
            //Added to fix issue: wasn't applying background color when have semicolon at end
            colorCode = colorCode.replace(/;\s*$/, "");
            jQuery('.block-preview').css('background', colorCode);
            jQuery('#base_color').val(colorCode);
            jQuery(this).parents('.list-steps__li').addClass('visited');
        });
    },

    /**
     ** Accordion Function
     **/
    AccodrionInit: function () {
        jQuery('.list-steps__opener').click(function (e) {
            e.preventDefault();
            jQuery(this).toggleClass('active');
            jQuery('.list-steps__opener').next().slideUp();
            jQuery('.list-steps__opener').removeClass('active');
            if (jQuery(this).next().is(':visible') == false) {
                jQuery(this).next().slideDown(function () {
                    jQuery(this).parent('.list-steps__li').find('input').focus();
                });
                jQuery(this).addClass('active');
            }
            if (jQuery('.list-steps__li').hasClass('visited')) {
                jQuery('.list-steps__li.visited').addClass('check-active');
            }
            else {
                jQuery('.list-steps__li').removeClass('check-active');
            }
            var checkedItems = jQuery('.list-steps__li.check-active').length;
            if (checkedItems >= 1) {
                jQuery('.sidebar .progress-area').addClass('progress-active');
            }
            else {
                jQuery('.sidebar .progress-area').removeClass('progress-active');
            }

            if (checkedItems >= 6) {
                jQuery('.btn-finished .btn').removeClass('disabled');
            }
            else {
                jQuery('.btn-finished .btn').addClass('disabled');
                jQuery('.sidebar__btn').addClass('disabled');
            }

            switch (checkedItems) {
                case 1:
                    jQuery('.sidebar .progress__progress-bar').css('width', '16%');
                    jQuery('.sidebar  .progress-area__num').html('16');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 2:
                    jQuery('.sidebar .progress__progress-bar').css('width', '32%');
                    jQuery('.sidebar  .progress-area__num').html('32');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 3:
                    jQuery('.sidebar .progress__progress-bar').css('width', '48%');
                    jQuery('.sidebar  .progress-area__num').html('48');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 4:
                    jQuery('.sidebar .progress__progress-bar').css('width', '64%');
                    jQuery('.sidebar  .progress-area__num').html('64');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 5:
                    jQuery('.sidebar .progress__progress-bar').css('width', '80%');
                    jQuery('.sidebar  .progress-area__num').html('80');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 6:
                    jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                    jQuery('.sidebar  .progress-area__num').html('100');
                    break;
            }
        });
    },

    /**
     ** Company Number Clone Function
     **/
    CompanyNameInit: function () {
        jQuery('body').on('keyup', '.company-name', function () {
            var c_name = jQuery(this).val();
            if (c_name.length > 1) {
                jQuery(this).parents('.list-steps__li').addClass('visited');
                jQuery('.contact-detail__name').html(c_name);
                jQuery(this).removeClass('has-error');
            }
            else {
                jQuery('.contact-detail__name').html('');
                jQuery(this).parents('.list-steps__li').removeClass('visited check-active');
                jQuery('.sidebar__btn').addClass('disabled');
            }

            var checkedItems = jQuery('.list-steps__li.visited').length;

            if (checkedItems >= 6) {
                jQuery('.sidebar__btn').removeClass('disabled');
            }

            switch (checkedItems) {
                case 1:
                    jQuery('.sidebar .progress__progress-bar').css('width', '16%');
                    jQuery('.sidebar  .progress-area__num').html('16');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 2:
                    jQuery('.sidebar .progress__progress-bar').css('width', '32%');
                    jQuery('.sidebar  .progress-area__num').html('32');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 3:
                    jQuery('.sidebar .progress__progress-bar').css('width', '48%');
                    jQuery('.sidebar  .progress-area__num').html('48');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 4:
                    jQuery('.sidebar .progress__progress-bar').css('width', '64%');
                    jQuery('.sidebar  .progress-area__num').html('64');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 5:
                    jQuery('.sidebar .progress__progress-bar').css('width', '80%');
                    jQuery('.sidebar  .progress-area__num').html('80');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 6:
                    jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                    jQuery('.sidebar  .progress-area__num').html('100');
                    break;
            }
        });

        jQuery('body').on('keydown', '.company-name', function (e) {
            if (e.keyCode === 13) {
                var activeItems = jQuery('.list-steps__li.visited').length;
                var c_name = jQuery(this).val();
                if (c_name.length > 1) {
                    if (activeItems != 6) {
                        jQuery(this).removeClass('has-error');
                        jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
                        jQuery(this).parents('.list-steps__slide').slideUp();
                        jQuery(this).parents('.visited').addClass('check-active');
                        jQuery(this).parents('.list-steps__li').next().find('.list-steps__slide').slideDown();
                        jQuery(this).parents('.list-steps__li').next().find('.list-steps__slide input').focus();
                    }
                    else {
                        jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
                        jQuery(this).parents('.list-steps__slide').slideUp();
                        jQuery(this).parents('.visited').addClass('check-active');
                    }
                }
                else {
                    jQuery(this).addClass('has-error');
                }
                var checkedItems = jQuery('.list-steps__li.check-active').length;
                if (checkedItems >= 1) {
                    jQuery('.sidebar .progress-area').addClass('progress-active');
                }
                else {
                    jQuery('.sidebar .progress-area').removeClass('progress-active');
                }
            }
        });
    },

    /**
     ** Hover class function for css
     **/
    HoverClassInit: function () {
        jQuery('.tooltip-opener').hover(function (e) {
            jQuery(this).parent('.tooltip-area').toggleClass('tooltip-active');
        });

        jQuery('.list-steps__li--color').hover(function () {
            jQuery(this).toggleClass('tooltip-active');
        });

        jQuery('.tooltip-opener').click(function () {
            return false;
        });
    },
    /**
     ** Phone Number CLone Function
     **/
    PhoneCloneInit: function () {
        jQuery('body').on('keyup', '.company-phone', function () {
            var c_length = jQuery(this).val().length;
            var c_phone = jQuery(this).val();
            jQuery('.contact-detail__num').html(c_phone);
        });
    },

    /**
     ** Phone number validation
     **/
    validatePhoneNumberInit: function () {
        $('#phone').keyup(function (e) {
            var value = jQuery("#phone").val();
            var return_value = value.replace(/[^A-Z0-9]/ig, "");
            if (return_value.length == '10') {
                jQuery(this).parents('.list-steps__li').addClass('visited');
                jQuery(this).removeClass('has-error');
            } else {
                jQuery(this).parents('.list-steps__li').removeClass('visited check-active');
                jQuery('.sidebar__btn').addClass('disabled');
            }

            var checkedItems = jQuery('.list-steps__li.visited').length;

            if (checkedItems >= 6) {
                jQuery('.sidebar__btn').removeClass('disabled');
            }

            switch (checkedItems) {
                case 1:
                    jQuery('.sidebar .progress__progress-bar').css('width', '16%');
                    jQuery('.sidebar  .progress-area__num').html('16');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 2:
                    jQuery('.sidebar .progress__progress-bar').css('width', '32%');
                    jQuery('.sidebar  .progress-area__num').html('32');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 3:
                    jQuery('.sidebar .progress__progress-bar').css('width', '48%');
                    jQuery('.sidebar  .progress-area__num').html('48');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 4:
                    jQuery('.sidebar .progress__progress-bar').css('width', '64%');
                    jQuery('.sidebar  .progress-area__num').html('64');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 5:
                    jQuery('.sidebar .progress__progress-bar').css('width', '80%');
                    jQuery('.sidebar  .progress-area__num').html('80');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 6:
                    jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                    jQuery('.sidebar  .progress-area__num').html('100');
                    break;
            }
        });

        jQuery('body').on('keydown', '#phone', function (e) {
            if (e.keyCode === 13) {
                var value = jQuery("#phone").val();
                var return_value = value.replace(/[^A-Z0-9]/ig, "");
                var activeItems = jQuery('.list-steps__li.visited').length;
                if (return_value.length == '10') {
                    if (activeItems != 6) {
                        jQuery(this).removeClass('has-error');
                        jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
                        jQuery(this).parents('.list-steps__slide').slideUp();
                        jQuery(this).parents('.visited').addClass('check-active');
                        jQuery(this).parents('.list-steps__li').next().find('.list-steps__slide').slideDown();
                        jQuery(this).parents('.list-steps__li').next().find('.list-steps__slide input').focus();
                    }
                    else {
                        jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
                        jQuery(this).parents('.list-steps__slide').slideUp();
                        jQuery(this).parents('.visited').addClass('check-active');
                    }
                } else {
                    jQuery(this).addClass('has-error');
                }

                var checkedItems = jQuery('.list-steps__li.check-active').length;
                if (checkedItems >= 1) {
                    jQuery('.sidebar .progress-area').addClass('progress-active');
                }
                else {
                    jQuery('.sidebar .progress-area').removeClass('progress-active');
                }
            }
        });
    },

    /**
     ** Email Validation Function
     **/
    EmailValidationInit: function () {
        var validateEmail = function (elementValue) {
            var emailPattern = /^\s*[a-zA-Z0-9._-]+\@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,8}\s*(?:\s*\,\s*[a-zA-Z0-9._-]+\@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,8}){0,4}\s*$/;
            return emailPattern.test(elementValue);
        }
        $('#email').keyup(function () {
            var value = $(this).val();
            var valid = validateEmail(value);
            if (!valid) {
                jQuery(this).parents('.list-steps__li').removeClass('visited check-active');
                jQuery('.btn-finished').removeClass('hide-btn');
                jQuery('.btn-finished .btn').addClass('disabled');
                jQuery('.sidebar__btn').addClass('disabled');
            } else {
                jQuery(this).removeClass('has-error');
                jQuery(this).parents('.list-steps__li').addClass('visited');
                var checkedItems = jQuery('.list-steps__li.visited').length;
                if (checkedItems >= 6) {
                    jQuery('.btn-finished .btn').removeClass('disabled');
                }
            }

            var checkedItems = jQuery('.list-steps__li.visited').length;
            switch (checkedItems) {
                case 1:
                    jQuery('.sidebar .progress__progress-bar').css('width', '16%');
                    jQuery('.sidebar  .progress-area__num').html('16');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 2:
                    jQuery('.sidebar .progress__progress-bar').css('width', '32%');
                    jQuery('.sidebar  .progress-area__num').html('32');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 3:
                    jQuery('.sidebar .progress__progress-bar').css('width', '48%');
                    jQuery('.sidebar  .progress-area__num').html('48');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 4:
                    jQuery('.sidebar .progress__progress-bar').css('width', '64%');
                    jQuery('.sidebar  .progress-area__num').html('64');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 5:
                    jQuery('.sidebar .progress__progress-bar').css('width', '80%');
                    jQuery('.sidebar  .progress-area__num').html('80');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 6:
                    jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                    jQuery('.sidebar  .progress-area__num').html('100');
                    break;
            }
        });

        jQuery('body').on('keydown', '#email', function (e) {
            if (e.keyCode === 13) {
                var value = $(this).val();
                var valid = validateEmail(value);
                if (!valid) {
                    jQuery(this).addClass('has-error');
                } else {
                    jQuery(this).removeClass('has-error');
                    jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
                    jQuery(this).parents('.list-steps__slide').slideUp();
                    jQuery(this).parents('.visited').addClass('check-active');
                    jQuery(this).parents('.list-steps__li').addClass('visited');
                    var checkedItems = jQuery('.list-steps__li.visited').length;
                    if (checkedItems >= 6) {
                        jQuery('.btn-finished .btn').removeClass('disabled');
                        jQuery('.sidebar__btn').removeClass('disabled');
                        jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                        jQuery('.sidebar .progress-area__num').html('100');
                        jQuery('.btn-finished').addClass('hide-btn');
                    }
                }

                var checkedItems = jQuery('.list-steps__li.check-active').length;
                if (checkedItems >= 1) {
                    jQuery('.sidebar .progress-area').addClass('progress-active');
                }
                else {
                    jQuery('.sidebar .progress-area').removeClass('progress-active');
                }

                if (jQuery(window).width() < 540) {
                    jQuery('html, body').animate({
                        scrollTop: jQuery("#scroll-point").offset().top
                    }, 1000);
                }
            }
        });
    },

    /**
     ** Allow Only Numbers Function
     **/
    LogoInit: function () {
        jQuery(".input-file").on('change', function () {
            // console.log(jQuery(".input-file"))
            jQuery(".logo-validate").html('');
            var fd = new FormData();
            fd.append( "logo", jQuery('#imageInput')[0].files[0]);
            fd.append( "_token", ajax_token);
            $("#mask").show();
            jQuery.ajax({
                type: "POST",
                data: fd,
                datatype:"json",
                processData: false,
                contentType: false,
                url: site.baseUrl+"/lp/launcher/getlogoprimarycolor",
                success: function (data) {
                    $("#mask").delay(500).fadeOut(600);
                    window.color = [];
                    if(jQuery.parseJSON(data).error){
                        jQuery(".logo-validate").html(jQuery.parseJSON(data).error);
                    }
                    else if(jQuery.parseJSON(data).color) {
                        window.color = hexToRgb(jQuery.parseJSON(data).color);
                        loadLogo();
                    }
                },
                error: function (e) {
                    console.log(e);
                    jQuery(".logo-validate").html('Logo valid type is required.');
                    $("#mask").delay(500).fadeOut(600);
                }
            });
        });
    },

    /*
    **  Allow Only Numbers Function
    **/
    NumbersInit: function () {
        function validateNumber(event) {
            var key = window.evet ? event.keyCode : event.which;
            if (event.keyCode === 8 || event.keyCode === 46) {
                return true;
            } else if (key < 48 || key > 57) {
                return false;
            } else {
                return true;
            }
        };

        if(jQuery('#nmls').attr("placeholder") == "123456") jQuery('#nmls').keypress(validateNumber);
        jQuery('#nmls').keyup(function () {
            var n_length = jQuery(this).val().length;
            if (n_length >= 4) {
                jQuery(this).parents('.list-steps__li').addClass('visited');
                jQuery(this).removeClass('has-error');
            }
            else {
                jQuery(this).parents('.list-steps__li').removeClass('visited check-active');
                jQuery('.sidebar__btn').addClass('disabled');
            }

            var checkedItems = jQuery('.list-steps__li.visited').length;

            if (checkedItems >= 6) {
                jQuery('.sidebar__btn').removeClass('disabled');
            }
            switch (checkedItems) {
                case 1:
                    jQuery('.sidebar .progress__progress-bar').css('width', '16%');
                    jQuery('.sidebar  .progress-area__num').html('16');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 2:
                    jQuery('.sidebar .progress__progress-bar').css('width', '32%');
                    jQuery('.sidebar  .progress-area__num').html('32');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 3:
                    jQuery('.sidebar .progress__progress-bar').css('width', '48%');
                    jQuery('.sidebar  .progress-area__num').html('48');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 4:
                    jQuery('.sidebar .progress__progress-bar').css('width', '64%');
                    jQuery('.sidebar  .progress-area__num').html('64');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 5:
                    jQuery('.sidebar .progress__progress-bar').css('width', '80%');
                    jQuery('.sidebar  .progress-area__num').html('80');
                    jQuery('.btn-finished').removeClass('hide-btn');
                    break;
                case 6:
                    jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                    jQuery('.sidebar  .progress-area__num').html('100');
                    break;
            }
        });

        jQuery('body').on('keydown', '#nmls', function (e) {
            if (e.keyCode === 13) {
                var n_length = jQuery(this).val().length;
                var activeItems = jQuery('.list-steps__li.visited').length;
                if (n_length >= 4) {
                    if (activeItems != 6) {
                        jQuery(this).removeClass('has-error');
                        jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
                        jQuery(this).parents('.list-steps__slide').slideUp();
                        jQuery(this).parents('.visited').addClass('check-active');
                        jQuery(this).parents('.list-steps__li').next().find('.list-steps__slide').slideDown();
                        jQuery(this).parents('.list-steps__li').next().find('.list-steps__slide input').focus();
                    }
                    else {
                        jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
                        jQuery(this).parents('.list-steps__slide').slideUp();
                        jQuery(this).parents('.visited').addClass('check-active');
                    }
                }
                else {
                    jQuery(this).addClass('has-error');
                }

                var checkedItems = jQuery('.list-steps__li.check-active').length;
                if (checkedItems >= 1) {
                    jQuery('.sidebar .progress-area').addClass('progress-active');
                }
                else {
                    jQuery('.sidebar .progress-area').removeClass('progress-active');
                }
            }
        });
    },

    /**
     ** Activite the launch button on chick
     **/
    LuncActivateInit: function () {
        jQuery('.btn-finished .btn').click(function (e) {
            e.preventDefault();
            jQuery('.btn-finished').addClass('hide-btn');
            jQuery('.sidebar__btn').removeClass('disabled');
            jQuery('.sidebar .progress__progress-bar').css('width', '100%');
            jQuery('.sidebar .progress-area__num').html('100');
            jQuery(this).parents('.list-steps__slide').slideUp();
            jQuery(this).parents('.list-steps__li').find('.list-steps__opener').removeClass('active');
            jQuery(this).parents('.list-steps__li').addClass('check-active');
            if (jQuery(window).width() < 540) {
                jQuery('html, body').animate({
                    scrollTop: jQuery("#btn-launch").offset().top
                }, 2000);
            }
        });
    },

    /**
     ** Empty Logo
     **/
    LogoEmpty: function () {
        jQuery('.link-logo').click(function (e) {
            e.preventDefault();
            jQuery('.list-steps__li--logo .list-steps__opener').removeClass('active');
            jQuery('.list-steps__li--logo .list-steps__slide').slideUp();
            jQuery('.list-steps__li--logo').addClass('visited check-active');
            jQuery('.list-steps__li--color').addClass('visited check-active');
            jQuery('.list-steps__li--company .list-steps__opener').addClass('active');
            jQuery('.list-steps__li--company .list-steps__slide').slideDown(function () {
                jQuery(this).parent('.list-steps__li').find('input').focus();
            });
            setTimeout(function () {
                jQuery('.sidebar .progress-area').addClass('progress-active');
                var checkedItems = jQuery('.list-steps__li.visited').length;
                switch (checkedItems) {
                    case 1:
                        jQuery('.sidebar .progress__progress-bar').css('width', '16%');
                        jQuery('.sidebar  .progress-area__num').html('16');
                        jQuery('.btn-finished').removeClass('hide-btn');
                        break;
                    case 2:
                        jQuery('.sidebar .progress__progress-bar').css('width', '32%');
                        jQuery('.sidebar  .progress-area__num').html('32');
                        jQuery('.btn-finished').removeClass('hide-btn');
                        break;
                    case 3:
                        jQuery('.sidebar .progress__progress-bar').css('width', '48%');
                        jQuery('.sidebar  .progress-area__num').html('48');
                        jQuery('.btn-finished').removeClass('hide-btn');
                        break;
                    case 4:
                        jQuery('.sidebar .progress__progress-bar').css('width', '64%');
                        jQuery('.sidebar  .progress-area__num').html('64');
                        jQuery('.btn-finished').removeClass('hide-btn');
                        break;
                    case 5:
                        jQuery('.sidebar .progress__progress-bar').css('width', '80%');
                        jQuery('.sidebar  .progress-area__num').html('80');
                        jQuery('.btn-finished').removeClass('hide-btn');
                        break;
                    case 6:
                        jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                        jQuery('.sidebar  .progress-area__num').html('100');
                        break;
                }

            }, 100);
        });
    },

    /*
    ** init Function
    **/
    init: function () {
        funnel_template.AccodrionInit();
        funnel_template.SwatchesInit();
        funnel_template.CompanyNameInit();
        funnel_template.HoverClassInit();
        funnel_template.PhoneCloneInit();
        funnel_template.EmailValidationInit();
        funnel_template.validatePhoneNumberInit();
        funnel_template.LogoInit();
        funnel_template.NumbersInit();
        funnel_template.LuncActivateInit();
        funnel_template.LogoEmpty();
        jQuery("#phone").inputmask({"mask": "(999) 999-9999"});

        //initialize default swatcher
        if (defaultSwatches !== undefined && defaultSwatches.length > 0) {
            funnel_template.initSwatchSwitcher(defaultSwatches);
        }
    },


    initSwatchSwitcher: function (swatches) {
        if (swatches.length) {
            // debugger;
            //removed previous colors from swatcher
             $(".list-swatches").html("");

            jQuery.each(swatches, function (index, swatch) {
                var swatcher = '<li class="list-swatches__li">' +
                    '<label class="custom-radio">' +
                    '<input type="radio" data-color="' + swatch + '" name="swatcher">' +
                    '<span class="fake-radio"><span class="fake-radio__bg" style="background: ' + swatch + '"></span></span>' +
                    '</label>' +
                    ' </li>';

                $(".list-swatches").append(swatcher);

                if (index == 0) {
                    //Added to fix issue: wasn't applying background color when have semicolon at end
                    var colorCode = swatches[0].replace(/;\s*$/, "");
                    jQuery('.block-preview').css('background', colorCode);
                }
            });
        }
    }
};

jQuery(document).ready(function () {
    funnel_template.init();
    $("#mask").delay(500).fadeOut(600);
    function uploadClientLogoImage() {



        /*   $(document).ready(function(){
               $("#testAjax").click(function(e){
                   $.ajax({
                       type: "POST",
                       data: {'_token': '{{csrf_token()}}'},
                       cache: false,
                       url: "/ajax-data",
                       success: function (rsp) {
                           var html = '';
                           $.each(rsp, function(index, value) {
                               html += "<h2>"+index+": "+value+"</h2>";
                           });

                           $("#ajaxResponse").html(html)
                       },
                       error: function (e) {
                           $("#ajaxResponse").html("ERROR")
                       },
                       always: function (d) {
                       }
                   });
               })
           });*/

    }
    $('#fuploadlogoimage').on('submit', function(e){
        $("#mask").show();
    });
});

function loadLogo(){
    var image_holder = jQuery("#img-preview");
    if (typeof (FileReader) != "undefined") {
        jQuery(".link-logo").hide();
        jQuery(".file-text").text('upload new logo');
        jQuery('.preview-area').removeClass('preview-active');
        var i = 0;
        if (i == 0) {
            jQuery('.block-logo').addClass('hidden');
            jQuery('.progress-area__logo').addClass('bar-active');
            i = 1;
            var elem = document.getElementById("num-counter");
            var elemwidth = document.getElementById("myBar");
            var width = 0;
            var id = setInterval(frame, 10);

            function frame() {
                if (width >= 100) {
                    clearInterval(id);
                    i = 0;
                } else {
                    width++;
                    elemwidth.style.width = width + "%";
                    elem.innerHTML = width + "%";
                }
            }
        }
        image_holder.empty();
        jQuery('.preview-head__logo').html('');
        jQuery(".input-file").parents('.list-steps__li').addClass('visited');
        jQuery('.list-steps__li--color').addClass('pointer-active').removeClass('visited check-active');
        var checkedItems = jQuery('.list-steps__li.visited').length;
        switch (checkedItems) {
            case 1:
                jQuery('.sidebar .progress__progress-bar').css('width', '16%');
                jQuery('.sidebar  .progress-area__num').html('16');
                jQuery('.btn-finished').removeClass('hide-btn');
                jQuery('.sidebar__btn').addClass('disabled');
                break;
            case 2:
                jQuery('.sidebar .progress__progress-bar').css('width', '32%');
                jQuery('.sidebar  .progress-area__num').html('32');
                jQuery('.btn-finished').removeClass('hide-btn');
                jQuery('.sidebar__btn').addClass('disabled');
                break;
            case 3:
                jQuery('.sidebar .progress__progress-bar').css('width', '48%');
                jQuery('.sidebar  .progress-area__num').html('48');
                jQuery('.btn-finished').removeClass('hide-btn');
                jQuery('.sidebar__btn').addClass('disabled');
                break;
            case 4:
                jQuery('.sidebar .progress__progress-bar').css('width', '64%');
                jQuery('.sidebar  .progress-area__num').html('64');
                jQuery('.btn-finished').removeClass('hide-btn');
                jQuery('.sidebar__btn').addClass('disabled');
                break;
            case 5:
                jQuery('.sidebar .progress__progress-bar').css('width', '80%');
                jQuery('.sidebar  .progress-area__num').html('80');
                jQuery('.btn-finished').removeClass('hide-btn');
                jQuery('.sidebar__btn').addClass('disabled');
                break;
            case 6:
                jQuery('.sidebar .progress__progress-bar').css('width', '100%');
                jQuery('.sidebar  .progress-area__num').html('100');
                break;
        }
        //loop for each file selected for uploaded.
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.createElement('img');
            img.setAttribute('src', e.target.result);
            img.setAttribute('class', "logo-preview__img");
            $(img).appendTo(image_holder);

            img.addEventListener("load", function () {
                setSwatches(img,false);
            });
        }

        image_holder.show();
        reader.readAsDataURL($(".input-file")[0].files[0]);
        setTimeout(function () {
            jQuery('.progress-area__logo').removeClass('bar-active');
            jQuery('.preview-area').addClass('preview-active');
            var currentImage = jQuery('#img-preview .logo-preview__img').clone();
            jQuery('.preview-head__logo').html(currentImage);
            $("li.list-swatches__li input[type=radio]").eq(0).trigger('click');

            // uploadClientLogoImage();
        }, 1000);

    } else {
        alert("This browser does not support FileReader.");
    }
}
function setSwatches(img,def){
    var colorThief = new ColorThief(),
    palette = colorThief.getPalette(img,  6, 10),
        swatchesStr = "", red = "", green = "", blue = "";
    if(def && client_type.is_fairway == 1){
        palette.unshift(hexToRgb('#84BD00'));
        palette.splice(3,1);
        palette.unshift([20,92,68]);
    }
    else if(def && client_type.is_mm == 1){
        palette.unshift(hexToRgb('#A8000D'));
    }
    else if(def && client_type.is_thrive == 1){
        palette.unshift(hexToRgb('#C60903'));
    }
    else{
        //custom logo primary color
        if(color) {
            palette.unshift(color);
        }
    }
    //console.log("palette", palette);
    if (palette.length) {
        const clientSwatches = [];
        $(".list-swatches").html("");
        jQuery.each(palette, function (index, plate) {
            swatches[index] = "rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ")";
            if (index < 1) {
                var str = "linear-gradient(to bottom, rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",1.0) 0%,rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",1.0) 100%)";
            } else {
                var str = "linear-gradient(to bottom, rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",1.0) 0%,rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",.7) 100%)";
            }

            var str1 = "linear-gradient(to top, rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",1.0) 0%,rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",.7) 100%)";
            var str2 = "linear-gradient(to bottom right, rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",1.0) 0%,rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",.7) 100%)";
            var str3 = "linear-gradient(to bottom, rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",1.0) 0%,rgba(" + plate[0] + "," + plate[1] + "," + plate[2] + ",1.0) 100%)";
            var new_swatches = [str, str1, str2, str3];
            jQuery.each(new_swatches, function (i, bg) {
                var swatcher = '<li class="list-swatches__li">' +
                    '<label class="custom-radio">' +
                    '<input type="radio" data-color="' + bg + '" name="swatcher" value="' + swatches[index] + '" id="swatcher">' +
                    '<span class="fake-radio"><span class="fake-radio__bg" style="background: ' + bg+ '"></span></span>' +
                    '</label>' +
                    ' </li>';
                $(".list-swatches").append(swatcher);
                clientSwatches.push(bg);

            });
            red = palette[index][0];
            green = palette[index][1];
            blue = palette[index][2];

            swatchesStr += red + "-" + green + "-" + blue;
            if (index < (palette.length - 1)) {
                swatchesStr += "#";
            }
        });
        // debugger;
        $('#swatches').val(swatchesStr);
        console.log($('#swatches').val())
    }
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? [
        parseInt(result[1], 16),
        parseInt(result[2], 16),
        parseInt(result[3], 16)
    ] : null;
}

