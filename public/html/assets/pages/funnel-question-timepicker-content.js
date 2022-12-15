var timepicker_content = {

    /*
   ** Input Focus Function
   **/
    inputFocus: function() {
        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.input-wrap').addClass('focused');
        });
        jQuery('.question_answer.active .input-label').click(function(){
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
        });
    },

    /*
   ** Input mask Function
   **/

    inputmask: function() {
        $("#timer").inputmask({ mask: '99 : 99 : 99' , greedy: false, placeholder:"HH : MM : XM"});
    },

    /*
   ** circular slider Function
   **/

    circularSlider: function() {
        $("#hours").roundSlider({
            svgMode: false,
            borderWidth: 1,
            rangeColor: "#01c6f7",
            value: 0,
            max: 12,
            handleSize: 48,
            min: 0,
            startAngle: "90°",
            endAngle: "-0°",
            lineCap: "square",
            editableTooltip: false,
            sliderType: "min-range"
        });
        $("#minutes").roundSlider({
            svgMode: false,
            borderWidth: 1,
            rangeColor: "#01c6f7",
            value: 0,
            max: 60,
            handleSize: 48,
            min: 0,
            startAngle: "90°",
            endAngle: "-0°",
            lineCap: "square",
            editableTooltip: false,
            sliderType: "min-range"
        });
        $("#seconds").roundSlider({
            svgMode: false,
            borderWidth: 1,
            rangeColor: "#01c6f7",
            value: 0,
            max: 60,
            handleSize: 48,
            min: 0,
            startAngle: "90°",
            endAngle: "-0°",
            lineCap: "square",
            editableTooltip: false,
            sliderType: "min-range"
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
        timepicker_content.iframe_custom_scroll();
        timepicker_content.single_select_dropdown();
        timepicker_content.outsideclick();
        timepicker_content.inputmask();
        timepicker_content.circularSlider();
        timepicker_content.addclass();
        timepicker_content.inputFocus();
        timepicker_content.inputBlur();
    },
};

jQuery(document).ready(function() {
    timepicker_content.init();
});

