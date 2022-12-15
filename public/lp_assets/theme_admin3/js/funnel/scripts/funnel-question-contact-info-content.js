window.phoneFormat = {
    'update-phone-format' : [
        {
            'country-code' : [
                {
                    '0' :[
                        {
                            'phone-format' :[
                                {
                                    '0' : 'XXXXXXXXXX',
                                    '1' : '(XXX) XXX-XXXX'
                                },
                            ],
                        }
                    ],
                    '1' : [
                        {
                            'phone-format' :[
                                {
                                    '0' : '+1XXXXXXXXXX',
                                    '1' : '+1 (XXX) XXX-XXXX'
                                },
                            ],
                        }
                    ],
                }
            ],
        }
    ],
};

var contact_info_content = {


    /*
   ** Input Focus Function
   **/
    inputFocus: function() {
        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.input-wrap').addClass('focused');
            if(jQuery(this).parents('.input-wrap').hasClass('focused')) {
                jQuery(this).parents('.step-holder').find('.input-wrap').removeClass('field-focus');
            }
            else {
                jQuery(this).parents('.step-holder').find('.form-group:first-child .input-wrap').addClass('field-focus');
            }
        });
    },

    /*
    ** Input Blur Function
    **/

    inputBlur: function() {
        jQuery('.form-control').blur(function(){
            var inputValue = jQuery(this).val();
            if (inputValue == "") {
                jQuery(this).removeClass('filled');
                jQuery(this).parents('.input-wrap').removeClass('focused');
            } else {
                jQuery(this).addClass('filled');
            }
        });
    },

    /*
    ** add Class Function
    **/
    addclass: function() {
        if(jQuery('.cta-btn').width() > 250) {
            jQuery('.cta-btn').addClass('large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('large-btn');
        }

        if(jQuery('.cta-btn').width() > 420) {
            jQuery('.cta-btn').addClass('x-large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('x-large-btn');
        }

        if(jQuery('.cta-btn').width() > 550) {
            jQuery('.cta-btn').addClass('xx-large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('xx-large-btn');
        }

        if(jQuery('.cta-btn').width() > 650) {
            jQuery('.cta-btn').addClass('xxx-large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('xxx-large-btn');
        }
    },

    /*
   ** Input mask Function
   **/

    inputmask: function() {
        if(jQuery(window).width() >= 768 ) {
            let country_code = $('.country-code').val()??0;
            let phone_format = $('.phone-format').val()??1;
            let active_step_now = json['options']['activesteptype']-1;
            if(typeof json['options']['all-step-types'][active_step_now]['steps'][0]['fields'][5]['phone']['auto-format'] !== 'undefined')
            {
                 country_code = json['options']['all-step-types'][active_step_now]['steps'][0]['fields'][5]['phone']['country-code'];
                 phone_format = json['options']['all-step-types'][active_step_now]['steps'][0]['fields'][5]['phone']['auto-format'];
            }
            let masking = phoneFormat['update-phone-format'][0]['country-code'][0][country_code][0]['phone-format'][0][phone_format];
            masking = masking.replace(/[a-zA-Z]/g,9);
            jQuery("#phone_number").inputmask(masking);
        } else {
            jQuery("#phone_number").attr('maxlength','14');
        }
    },

    inputKeyPress: function() {
        jQuery('.form-control').on('keyup input paste', FunnelsUtil.debounce(function (event) {
            contact_info_content.handleHideUntilNotAnswered();
        }, 500));
    },

    /**
     * handle CTA button, it will check all input values
     */
    handleHideUntilNotAnswered: function () {
        let is_hide_until_not_answered = json['contact-form']['cta-button-settings']['enable-hide-until-answer'];
        //when enable-hide-until-answer is enabled than hide button until user not answered question
        if(is_hide_until_not_answered) {
            let is_validated_any = false,
                is_validated = true;
            jQuery.each(jQuery(".input-wrap input"), function (i, input) {
                input = jQuery(input);
                let required = parseInt(input.data("required"));
                if(required && input.val() == "") {
                    is_validated = false;
                } else if(!is_validated_any) {
                    is_validated_any = true;
                }
            });
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered, (is_validated_any && is_validated));
        } else {
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered);
        }
    },

    /*
    ** init Function
    **/
    init: function() {
        contact_info_content.inputFocus();
        contact_info_content.inputBlur();
        contact_info_content.inputmask();
        contact_info_content.addclass();
        contact_info_content.inputKeyPress();
    },
};

jQuery(document).ready(function() {
    contact_info_content.init();
});

