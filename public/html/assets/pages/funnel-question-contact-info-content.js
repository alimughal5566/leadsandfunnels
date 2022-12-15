var contact_info_content = {

    /*
   ** Input Focus Function
   **/

    inputFocus: function() {
        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.input-wrap').addClass('focused');
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
    },

    /*
   ** Input mask Function
   **/

    inputmask: function() {
        if(jQuery(window).width() >= 768 ) {
            jQuery("#phone_number").inputmask("(999) 999-9999");
        } else {
            jQuery("#phone_number").attr('maxlength','14');
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
    },
};

jQuery(document).ready(function() {
    contact_info_content.init();
});

