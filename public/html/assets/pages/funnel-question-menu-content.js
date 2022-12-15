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
        });

        jQuery('.other-button').click(function(e) {
            e.preventDefault();
            jQuery(this).next('.input-wrap-other').slideDown();
        });
    },

    /**
     ** CheckBox Question function
     **/
    checkBoxQuestion: function() {
        jQuery('.checkbox-button').click(function(e) {
            e.preventDefault();
            var $questions = jQuery(this).parents('.question');
            jQuery('.question').removeClass('active');
            $questions.addClass('active');

            if(jQuery(this).hasClass('uncheck-all')) {
                if(jQuery(this).hasClass('active')) {
                    $questions.find('.uncheck-all').removeClass('active');
                    $questions.find('.uncheck-all input').prop('checked', false);
                } else {
                    $questions.find('.uncheck-all').addClass('active');
                    $questions.find('.uncheck-all input').prop('checked', true);
                    $questions.find('.checkbox-button').not('.uncheck-all').removeClass('active');
                    $questions.find('.checkbox-button').not('.uncheck-all').find('input').prop('checked', false);
                }
            } else if(!jQuery(this).hasClass('active')) {
                jQuery(this).addClass('active');
                jQuery(this).find('input').prop('checked', true);
                $questions.find('.uncheck-all').removeClass('active');
                $questions.find('.uncheck-all input').prop('checked', false);
            } else {
                jQuery(this).removeClass('active focus');
                jQuery(this).find('input').prop('checked', false);
            }

            var active = $questions.find('.checkbox-button.active').length;
            if(active >= 1) {
                if($questions.find('.btn-wrap').hasClass('hide')) {
                    $questions.find('.btn-wrap').removeClass('hide');
                    setTimeout(function () {
                        $questions.find('.btn-wrap').removeClass('visuallyhidden');
                    }, 200);
                }
            } else {
                $questions.find('.btn-wrap').addClass('visuallyhidden');
                setTimeout(function () {
                    $questions.find('.btn-wrap').addClass('hide');
                }, 200);
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
        menu_content.radioQuestion();
        menu_content.checkBoxQuestion();
        menu_content.inputFocus();
        menu_content.inputBlur();
        menu_content.addclass();
    },
};

jQuery(document).ready(function() {
    menu_content.init();
});

