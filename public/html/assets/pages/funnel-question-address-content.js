var address_content = {

    /*
   ** Input Focus Function
   **/

    inputFocus: function() {
        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.input-wrap').addClass('focused');
        });
        jQuery('.question_zip-code.active .input-label').click(function(){
            jQuery(this).parents('.input-wrap').find('.form-control').focus();
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
    ** Iframe custom scroll Function
    **/

    iframe_custom_scroll: function() {

        if(jQuery('.scroll-bar').length > 0) {
            jQuery('.scroll-bar').mCustomScrollbar({
                axis: "y",
            });
        }
    },

    /**
     ** Select address function
     **/
    select_address: function() {
        jQuery('.address-link').click(function(e){
            e.preventDefault();
            var $questions = jQuery('.question');
            var $active_slide = $questions.filter('.active');
            var _this = jQuery(this);
            jQuery('.address-link').removeClass('selected hover');
            _this.addClass('selected');
            setTimeout(function() {
                jQuery('.address-link').parents('.input-wrap').addClass('active-box');
                jQuery('.address-link').parents('.question_address__fields').find('.address-box').slideUp();
            }, 400);
            var textVal = jQuery(this).text();
            jQuery(this).parents('.input-wrap').find('#address-field').val(textVal);
            if(jQuery('#address-field').val() != '') {
                jQuery('#address-field').focus();
            }
        });
    },

    /**
     ** Address slide function
     **/

    address_slide: function() {
        jQuery('#address-field').on('keyup' ,function() {

            if(jQuery(this).val() == '') {
                jQuery(this).parents('.question_address__fields').find('.address-box').slideUp();
                jQuery(this).parents('.input-wrap').removeClass('active-box');
            }
            else {
                jQuery(this).parents('.question_address__fields').find('.address-box').slideDown();
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
    },

    /*
    ** init Function
    **/

    init: function() {
        address_content.inputFocus();
        address_content.inputBlur();
        address_content.iframe_custom_scroll();
        address_content.select_address();
        address_content.address_slide();
        address_content.addclass();
    },
};

jQuery(document).ready(function() {
    address_content.init();
});

