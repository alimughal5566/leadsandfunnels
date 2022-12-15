var zip_code_content = {

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
     ** ZipCode length on keyPress function
     **/

    zipCodeLength: function() {
        jQuery('input#zip_code').on('keypress' ,function(e) {
            if((event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 8)return false;
            if (e.which < 0x20)return;
        });
    },

    /**
     ** Select State ZipCode function
     **/
    select_State_ZipCode: function() {
        jQuery('.states-box a').click(function(e){
            e.preventDefault();
            var $questions = jQuery('.question');
            var $active_slide = $questions.filter('.active');
            var _this = jQuery(this);
            jQuery('.states-box a').removeClass('selected hover');
            _this.addClass('selected');
            setTimeout(function() {
                jQuery('.states-box a').parents('.input-wrap').removeClass('active-box');
                jQuery('.states-box a').parents('.input-wrap').find('.states-box').slideUp();
            }, 400);
            var textVal = jQuery(this).text();
            jQuery(this).parents('.input-wrap').find('#city_zip_code').val(textVal);
            if(jQuery('#city_zip_code').val() != '') {
                jQuery('#city_zip_code').focus();
            }
        });
    },

    /**
     ** ZipCode slide function
     **/

    city_code_slide: function() {
        jQuery('#city_zip_code').on('keyup' ,function() {

           if(jQuery(this).val() == '') {
               jQuery(this).parents('.question_zip-code__fields').find('.states-box').slideUp();
           }
           else {
               jQuery(this).parents('.question_zip-code__fields').find('.states-box').slideDown();
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
        zip_code_content.inputFocus();
        zip_code_content.inputBlur();
        zip_code_content.zipCodeLength();
        zip_code_content.iframe_custom_scroll();
        zip_code_content.city_code_slide();
        zip_code_content.select_State_ZipCode();
        zip_code_content.addclass();

    },
};

jQuery(document).ready(function() {
    zip_code_content.init();
});

