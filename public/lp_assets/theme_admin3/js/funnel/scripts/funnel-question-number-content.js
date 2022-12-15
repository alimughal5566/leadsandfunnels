var number_content = {

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
   ** Input mask Function
   **/

    inputmask: function() {
        jQuery("#number").inputmask({ mask: '$999999' , greedy: false, placeholder:" "});
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

    // currencyFormat: function() {
    //     jQuery(".number-input").inputmask({ mask: '$ 99999999' , greedy: false, placeholder:" "});
    // },
    //
    // percentageFormat: function() {
    //     jQuery(".number-input").inputmask({ mask: '99 %' , greedy: false, placeholder:" "});
    // },
    //
    // numberFormat: function() {
    //     jQuery(".number-input").inputmask({ mask: '99 %' , greedy: false, placeholder:" "});
    // },

    numericKeysOnly: function(event){
        jQuery(".number-input").keydown(function (event) {
            if (event.shiftKey == true) {
                event.preventDefault();
            }

            console.log(event.keyCode);

            // Only Allow Numbers
            if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

            } else {
                event.preventDefault();
            }

            let opt = window.json;

            // For Currency Formatting
            if(opt['options']['formatting']['enable-format-as-currency'] == '1'){
                if(event.keyCode == 8 && $(this).val().length <= 2){
                    event.preventDefault();
                }
            }

            // else if(opt['options']['formatting']['enable-format-as-percentage'] == '1'){
            //     let inputValue = jQuery(this).val();
            //     inputValue = inputValue.replace(/\D/g,'');
            //     if(new Number(inputValue) > 100){
            //         event.preventDefault();
            //     }
            // }

            if(jQuery(this).val().indexOf('.') !== -1 && event.keyCode == 110)
                event.preventDefault();

        });
    },

    loadFormats: function(){
        jQuery(".number-input").focus(function (event) {
            let opt = window.json;
            let inputValue = jQuery(this).val();
            inputValue = inputValue.replace(/[^0-9.]/g,'');

            // For Currency Formatting
            if(opt['options']['formatting']['enable-format-as-currency'] == '1'){
                $(this).val("$ "+inputValue);
                $(this).get(0).setSelectionRange(2);
            }

            // For Percentage Formatting
            else if(opt['options']['formatting']['enable-format-as-percentage'] == '1'){
                $(this).val(inputValue+" %");
                $(this).get(0).setSelectionRange(0,0);
            }

        });
    },

    applyNumberValidation: function(){
        //Bind Events
        $(".number-input").off('keyup input paste').on('keyup input paste', FunnelsUtil.debounce(function (event) {
            let opt = window.json;
            let inputValue = jQuery(this).val();
            inputValue = inputValue.replace(/[^0-9.]/g,'');
            $('[data-error-msg]').html("");

            if(opt['options']['enable-min-number'] == '1' && inputValue){
                if(inputValue < (Number(opt['options']['min-number']))){
                    $('[data-error-msg]').html("Input is less than minimum number");
                }
            }

            if(opt['options']['enable-max-number'] == '1' && inputValue){
                if(inputValue > (Number(opt['options']['max-number']))){
                    $('[data-error-msg]').html("Input is greater than maximum number");
                }
            }


            // For Currency Formatting
            if(opt['options']['formatting']['enable-format-as-currency'] == '1'){
                //jQuery(this).val( inputValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
                let formatedValue = number_content._number_format(inputValue);
                jQuery(this).val("$ "+formatedValue);

            }

            else if(opt['options']['formatting']['enable-format-as-percentage'] == '1'){
                if(new Number(inputValue) > 100){
                    jQuery(this).val("100 %");
                    if(jQuery(this).val().length <= 2 ) {
                        $(this).get(0).setSelectionRange(0,0);
                    }
                } else {
                    jQuery(this).val(inputValue+" %");
                    if(jQuery(this).val().length <= 2 ) {
                        $(this).get(0).setSelectionRange(0,0);
                    }
                }

            }

            else if(opt['options']['formatting']['enable-format-with-comma'] == '1'){
                let formatedValue = number_content._number_format(inputValue);
                jQuery(this).val(formatedValue);
            } else {
                jQuery(this).val(inputValue);
            }

            // hide CTA button
            if ($('#hide_cta').val() == 1) {
                inputValue = jQuery(this).val();
                inputValue = inputValue.replace(/[^0-9.]/g,'');
                if (inputValue == "" || inputValue.length <= 1) {
                    $('.cta-btn-wrap').addClass('hide-btn');
                } else {
                    if (inputValue.length >= 2) {
                        $('.cta-btn-wrap').removeClass('hide-btn');
                    }
                }
            }

            // save value
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            funnel_info.question_value = jQuery(this).val();
            FunnelsUtil.saveFunnelData(funnel_info);
        }, 250));
    },

    _number_format: function(value){
        var result = '';
        var values = value.split('.');
        var valueArray = values[0].split('');
        var resultArray = [];
        var counter = 0;
        var temp = '';

        for (var i = valueArray.length - 1; i >= 0; i--) {
            temp += valueArray[i];
            counter++
            if(counter == 3){
                resultArray.push(temp);
                counter = 0;
                temp = '';
            }
        };

        if(counter > 0){
            resultArray.push(temp);
        }
        console.log(resultArray);

        for (var i = resultArray.length - 1; i >= 0; i--) {
            var resTemp = resultArray[i].split('');
            for (var j = resTemp.length - 1; j >= 0; j--) {
                result += resTemp[j];
            };
            if(i > 0){
                result += ','
            }
        }

        return value.indexOf('.') !== -1 ? result + "." + values[1] : result;
    },

    /*
    ** init Function
    **/

    init: function() {
        number_content.inputFocus();
        number_content.inputBlur();
        number_content.addclass();

        number_content.numericKeysOnly();
        //number_content.loadFormats();
    },
};
