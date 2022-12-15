var datepicker_content = {

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
        jQuery('#datepicker').focus(function(){
            jQuery(this).parents('.input-wrap').addClass('form-active');
            jQuery('.btn-confirm').removeClass('btn-active');
        });
        jQuery('.btn-finish').click(function(e){
            e.preventDefault();
            jQuery(this).parents('.input-wrap').removeClass('form-active');
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

    /*
    ** Single Select DropDown Question function
    **/

    single_select_dropdown: function() {
        jQuery('.field-opener').click(function(e){
            e.preventDefault();
            jQuery('.field-holder').removeClass('select-active');
            jQuery(this).parent().addClass('select-active');
        });

        jQuery('.list-options a').click(function (e) {
            e.preventDefault();
            var getText = jQuery(this).html();
            jQuery(this).parents('.field-holder').removeClass('select-active');
            jQuery(this).parents('.field-holder').find('.selected_text').html(getText);
            jQuery(this).parents('.list-options').find('active').removeClass('active');
            jQuery('.list-options a').removeClass('active');
            jQuery(this).addClass('active');
            jQuery(this).parents('.field-holder').find('.field-opener').addClass('field-active');
        });
    },


    /*
    ** Outside click Function
    **/

    outsideclick: function () {
        jQuery(document).click(function(e) {
            var target = e.target;

            if (jQuery('.field-holder').hasClass('select-active')) {
                if (jQuery(target).parents('.field-holder').length > 0) {
                }
                else {
                    jQuery('.field-holder').removeClass('select-active');
                }
            }

            if (jQuery('.input-wrap').hasClass('form-active')) {
                if (jQuery(target).parents('.input-wrap').length > 0) {
                    console.log('if');
                }
                else {
                    jQuery('.input-wrap').removeClass('form-active');
                    console.log('else');
                }
            }
        });
    },


    /*
    ** calendar picker function
    **/

    dateSelector: function() {
        jQuery(".date-selector").flatpickr({
            inline: true,
            yearSelectorType: "static",
            dateFormat: "Y/m/d",
            onChange: function(selectedDates, dateStr, instance) {
                jQuery('.btn-confirm').addClass('btn-active');
                var getVal = jQuery('.date-selector').val();
                console.log(getVal);
                jQuery('#datepicker').val(getVal);
                jQuery('.input-wrap').addClass('focused');
            },
        });
    },

    /*
    ** init Function
    **/

    init: function() {
        datepicker_content.iframe_custom_scroll();
        datepicker_content.single_select_dropdown();
        datepicker_content.outsideclick();
        datepicker_content.inputFocus();
        datepicker_content.inputBlur();
        datepicker_content.dateSelector();
    },
};

jQuery(document).ready(function() {
    datepicker_content.init();
});

