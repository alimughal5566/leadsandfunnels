var vehicle_field_content = {
    models: null,
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
    ** Single Select DropDown Question function
    **/

    single_select_dropdown: function() {
        jQuery(document).on('click', '.select-opener', function(e) {
            e.preventDefault();
            jQuery(this).parents('.single-select-area').addClass('select-active');
            if(jQuery('.mobile-preview').hasClass('mobile-view')) {
              jQuery('.funnel-iframe-inner-holder').mCustomScrollbar("scrollTo","top",{
                scrollInertia: 100
              });
              setTimeout(function () {
                jQuery('.funnel-iframe-inner-holder').addClass('dropdown-active');
              },300);
            }
            vehicle_field_content.iframe_custom_scroll();

            vehicle_field_content.handleHideUntilNotAnswered();

            // ADA this funcation for move the scroll accroding to the active item
            var _self = jQuery(this);
            var _length = _self.parents('.single-select-area').find('.single-select-list a.selected').length;

            if (_length > 0) {
                setTimeout(function () {
                    var getindex = _self.parents('.single-select-area').find('.single-select-list a.selected').parent().index();
                    var item_height = _self.parents('.single-select-area').find('.single-select-list > li').height();
                    var defaultHeight = item_height + 1;
                    var scrolledArea = getindex * defaultHeight;
                    jQuery('.scroll-bar').mCustomScrollbar('scrollTo', scrolledArea, {
                        scrollInertia: 500
                    });
                }, 200);
            }
        });

        // close single menu question on cross click in mobile view
        jQuery(document).on('click', '.icon-cancel', function() {
            jQuery(this).parents(".single-select-area").removeClass("select-active");
            jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
        });
    },

    /*
    ** Single Select DropDown value Question function
    **/

    single_select_dropdown_val: function() {
        jQuery(document).on('click', '.single-select-list li a', function(e) {
            e.preventDefault();
            var _self = jQuery(this);
            var getHtml = _self.html();
            jQuery('.single-select-list li a').removeClass('selected');
            _self.addClass('selected');
            _self.parents('.single-select-area').addClass('select-active-text');
            _self.parents('.single-select-area').find('.select-opener-text').html(getHtml);

            if(!_self.hasClass('other-button')) {
                jQuery('.input-wrap-other').slideUp();
                setTimeout(function() {
                    _self.parents('.single-select-area').removeClass('select-active');
                    jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
                    FunnelsPreview.setCTAButtonMode(json['options']['cta-button-settings']['enable-hide-until-answer'], funnel_info);
                    if (json['options']['cta-button-settings']['enable-hide-until-answer'] == 1) {
                        $('.cta-btn-wrap').removeClass('hide-btn');
                    }
                }, 300);
            }

            vehicle_field_content.handleHideUntilNotAnswered();
        });
    },


    /*
    ** Outside click Function
    **/

    outsideclick: function () {
        jQuery(document).click(function(e) {
            var target = e.target;

            if (jQuery('.single-select-area').hasClass('select-active')) {
                if (jQuery(target).parents('.single-select-area').length > 0) {
                }
                else {
                    jQuery('.single-select-area').removeClass('select-active');
                    jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
                }
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
                scrollInertia: 500,
            });
        }
    },

    handleHideUntilNotAnswered: function () {
        let is_hide_until_not_answered = json['options']['cta-button-settings']['enable-hide-until-answer'];
        //when enable-hide-until-answer is enabled than hide button until user not answered question
        if(is_hide_until_not_answered) {
            let active = jQuery('.question_vehicle .single-select-list a.selected').length;
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered, (active >= 1));
        } else {
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered);
        }
    },

    /**
     * set JSON models into JSON object
     * @param questionJson
     */
    setModels: function(questionJson) {
        if(this.models == null) {
            this.models = JSON.parse($.getJSON({'url': hbar._json_dir + "models.json", 'async': false}).responseText);
        }
        if(questionJson['options']['models'] === undefined) {
            questionJson['options']['models'] = this.models;
        }
    },

    /*
    ** init Function
    **/
    init: function() {
        vehicle_field_content.inputFocus();
        vehicle_field_content.inputBlur();
        vehicle_field_content.addclass();
        vehicle_field_content.single_select_dropdown();
        vehicle_field_content.single_select_dropdown_val();
        vehicle_field_content.iframe_custom_scroll();
        vehicle_field_content.outsideclick();
    },
};

jQuery(document).ready(function() {
    vehicle_field_content.init();
});

