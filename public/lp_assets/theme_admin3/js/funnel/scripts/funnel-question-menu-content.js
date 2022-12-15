var menu_content = {
    /*
  ** Input Focus Function
  **/

    inputFocus: function() {
        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.input-wrap-other').addClass('focused');
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
                jQuery(this).parents('.input-wrap-other').removeClass('focused');
            } else {
                jQuery(this).addClass('filled');
            }
        });
    },

    /**
     ** Radio Question function
     **/
    radioQuestion: function() {
        jQuery('.single-radio').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $questions = jQuery(this).parents('.question');
            jQuery('.question').removeClass('active');
            $questions.addClass('active');
            jQuery(this).parents('.step-holder').find('.single-radio').removeClass('active focus');
            jQuery(this).addClass('active focus');
            jQuery('.input-wrap-other').slideUp();

            menu_content.handleHideUntilNotAnswered();
        });
    },

    /**
     ** CheckBox Question function
     **/
    checkBoxQuestion: function() {
        jQuery(document).off('click').on('click','.checkbox-button',function(e) {
            e.preventDefault();
            var $questions = jQuery(this).parents('.question');
            jQuery('.question').removeClass('active');
            $questions.addClass('active');
            let extraOption = $.trim(jQuery(".step-holder").data('extra-options').toLowerCase());
            if($.trim(jQuery(this).text().toLowerCase()) === extraOption) {
                jQuery(this).addClass('uncheck-all');
                if(jQuery(this).hasClass('active')) {
                    $questions.find('.uncheck-all').removeClass('active');
                    $questions.find('.uncheck-all input').prop('checked', false);
                } else {
                    $questions.find('.uncheck-all').addClass('active');
                    $questions.find('.uncheck-all input').prop('checked', true);
                    $questions.find('.checkbox-button').not('.uncheck-all').removeClass('active');
                    $questions.find('.checkbox-button').not('.uncheck-all').find('input').prop('checked', false);
                    jQuery('.input-wrap-other').slideUp();
                }
            } else if(!jQuery(this).hasClass('active')) {
                jQuery(this).addClass('active');
                jQuery(this).find('input').prop('checked', true);
                $questions.find('.uncheck-all').removeClass('active');
                $questions.find('.uncheck-all input').prop('checked', false);
            } else {
                jQuery(this).removeClass('active focus');
                jQuery(this).find('input').prop('checked', false);
                if(jQuery('[data-button-type="other_answer"]').val() == "") {
                    jQuery('.input-wrap-other').slideUp();
                }
            }

            menu_content.handleHideUntilNotAnswered();
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

    otherFieldSet: function(){
        jQuery('[data-selection-input]').each(function(i,v){
            //add other button class if extra option `other` option value match in options list
            let option = $.trim(jQuery(v).text().toLowerCase());
            let extraOptionOther = $.trim(jQuery(".step-holder").data('extra-options-other').toLowerCase());
            if(option === extraOptionOther) {
                jQuery(this).addClass('other-button');
                jQuery(this).after(' <div class="input-wrap-other">\n' +
                    ' <div class="other-input">\n' +
                    ' <input id="other_answer-1" type="text" data-button-type="other_answer" class="form-control validate-input" autocomplete="off" data-function-name="formValidation">\n' +
                    '  <label for="other_answer-1" class="input-label">'+$.trim(jQuery(v).text())+'</label>\n' +
                    '  </div>\n' +
                    '  </div>');

                jQuery(".other-button").parents('.form-group').addClass('other-parent');
                jQuery(".other-button").css({'height':jQuery('.other-parent').find('div[data-selection-input]')[0].offsetHeight});

            }
        });
        jQuery('.other-button').unbind( event );
        jQuery('.other-button').bind('click',function(e) {
            e.preventDefault();
            jQuery(this).parents('.form-group').addClass('other-parent');
            jQuery(this).next('.input-wrap-other').slideDown(function(){
                menu_content.inputFocus();
                $(this).find('input').focus();
            });
        });
    },
    /*
    ** Outside click Function
    **/

    outsideclick: function () {
        jQuery(document).click(function(e) {
            var target = e.target;
                if (!jQuery(target).hasClass('other-button') && jQuery(target).parents('.other-button').length == 0) {
                    if(jQuery('[data-button-type="other_answer"]').val() == "") {
                        jQuery('.other-button').removeClass('active');
                        jQuery('.input-wrap-other').slideUp();
                    }
                }
        });
    },

    handleHideUntilNotAnswered: function () {
        let is_hide_until_not_answered = json['options']['cta-button-settings']['enable-hide-until-answer'];
        //when enable-hide-until-answer is enabled than hide button until user not answered question
        if(is_hide_until_not_answered) {
            let active = 0;
            if(json['options']["select-multiple"] == 1) {
                active = jQuery('.question_menu .checkbox-button.active').length;
            } else {
                active = jQuery('.question_menu .single-radio.active').length;
            }

            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered, (active >= 1));
        } else {
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered);
        }
    },

    /*
    ** init Function
    **/

    init: function() {
        menu_content.radioQuestion();
        menu_content.checkBoxQuestion();
        menu_content.inputFocus();
        menu_content.inputBlur();
        menu_content.addclass();
        menu_content.otherFieldSet();
        menu_content.outsideclick();
    },
};

jQuery(document).ready(function() {
    menu_content.init();
});

