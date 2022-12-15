var dropdown_content = {

    /*
   ** Input Focus Function
   **/

    inputFocus: function() {
        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.input-wrap-other, .search-input-wrap').addClass('focused');
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
                jQuery(this).parents('.input-wrap-other, .search-input-wrap').removeClass('focused');

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
                scrollInertia: 500,
            });
        }
    },

    /*
    ** Single Select DropDown Question function
    **/
    single_select_dropdown: function() {
        jQuery('.select-opener').click(function(e){
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
            if(jQuery('.single-select-list li a').hasClass('selected')) {
                let option = $.trim(jQuery('.single-select-list li a.selected').text().toLowerCase());
                let extraOptionOther = $.trim(jQuery(".step-holder").data('extra-options-other').toLowerCase());
                if (option === extraOptionOther) {
                    $('.single-bottom-area').show();
                }
            }
        });

        // close single menu question on cross click in mobile view
        setTimeout(function () {
            jQuery(document).on('click', '.icon-cancel', function() {
                jQuery(this).parents(".single-select-area").removeClass("select-active");
            });
        },500);
    },

    /*
    ** Single Select DropDown value Question function
    **/

    single_select_dropdown_val: function() {

        jQuery('.single-select-list li a').click(function(e){
            e.preventDefault();
            var _self = jQuery(this);
            var getHtml = _self.html();
            jQuery('.single-select-list li a').removeClass('selected');
            _self.addClass('selected');
            _self.parents('.single-select-area').addClass('select-active-text');
            _self.parents('.single-select-area').find('.select-opener-text').html(getHtml);

            if(!_self.hasClass('other-button')) {
                jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
                jQuery('.input-wrap-other').slideUp(function (){
                    $(this).find('input').val('');
                });
                setTimeout(function() {
                    _self.parents('.single-select-area').removeClass('select-active');
                }, 300);
                $(".single-bottom-area").slideUp();
            }
        });
    },

    /*
    ** multi Select DropDown Question function
    **/

    multi_select_dropdown: function() {
        jQuery('.multi-select-opener').click(function(e){
            e.preventDefault();
            jQuery(this).parents('.multi-select-area').addClass('multi-select-active');
            if(jQuery('.mobile-preview').hasClass('mobile-view')) {
                jQuery('.funnel-iframe-inner-holder').mCustomScrollbar("scrollTo","top",{
                    scrollInertia: 100
                });
                setTimeout(function () {
                    jQuery('.funnel-iframe-inner-holder').addClass('dropdown-active');
                },300);
            }
        });

        // close multi menu question on cross click in mobile view

        setTimeout(function () {
            jQuery(document).on('click', '.icon-cancel', function() {
                jQuery(this).parents(".multi-select-area").removeClass("multi-select-active");
                jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
            });
        },500);
    },

    /*
    ** multi Select DropDown checkbox function
    **/

    multi_select_checkbox: function() {
        let extraOption = jQuery(".step-holder").data('extra-options');
        if(extraOption) {
            $('input[type=checkbox][value="' + extraOption + '"]').removeClass('checkbox').addClass('uncheckbox').parent(".check-label").addClass('uncheck-all');
        }
        jQuery('.checkbox:not(.uncheckbox)').change(function () {
            var _self = jQuery(this);
            var _getparent = _self.parents('.multi-select-area');
            if (jQuery('.checkbox:checked').length <= 0) {
                _getparent.find('.bottom-area,.input-wrap-other').slideUp(function (){
                    $(this).find('input').val('');
                });
            }
            else {
                _getparent.find('.bottom-area').slideDown();
                _getparent.find('.uncheckbox').prop("checked", false);
            }
            let extraOptionOther = $.trim(jQuery(".step-holder").data('extra-options-other').toLowerCase());
            if(!jQuery(this).is(":checked") && $.trim(jQuery(this).val().toLowerCase()) === extraOptionOther) {
                jQuery('.input-wrap-other').slideUp(function (){
                    $(this).find('input').val('');
                });
            }
        });

        jQuery(document).off('change', '.uncheckbox').on("change",'.uncheckbox',function (e) {
            var _getparent = jQuery(this).parents('.multi-select-area');
            var _self = jQuery(this);
            _getparent.find('.checkbox').prop("checked", false);
            if(_self.is(":checked")){
                _getparent.find('.bottom-area').slideDown();
            } else {
                _getparent.find('.bottom-area').slideUp();
            }

            _getparent.find('.input-wrap-other').slideUp(function (){
                $(this).find('input').val('');
            });
        });
    },

    /*
    ** multi Select DropDown Finish Button function
    **/

    multi_select_finish_btn: function() {
        jQuery('.finish-btn').click(function(e){
            e.preventDefault();
            var _getparent = jQuery(this);
            var x = 0, checkboxes, tags;
            _getparent.removeClass('multi-select-active');
            let _parent = _getparent.parents('.multi-select-area');
            checkboxes = _parent.find('.check-label input[type="checkbox"]:checked');
            tags = _parent.find('.multi-select-area__tag');
            jQuery(tags).html('');
            jQuery(checkboxes).each(function(){
                jQuery(this).attr('data-id', 'tag-text' + x);
                var checkItem_text = jQuery(this).val();
                var subItem = String(checkItem_text);
                if(!tags.find('[data-id="' + 'tag-text' + x + '"]').length) {
                    tags.append('<li><span class="tag-text" data-id="tag-text'+x+'">' + subItem + '<a href="#" class="cancel"><i class="ico-cross"></i></a></span></li>');
                }
                x++;
            });
            jQuery('.multi-select-area').removeClass('multi-select-active');
            jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
            dropdown_content.handleHideUntilNotAnswered();
        });
    },

    /*
    ** multi Select DropDown Remove Tag function
    **/

    multi_select_remove_tag: function() {
        jQuery(document).off('click').on('click', '.multi-select-area__tag .cancel', function (e) {
            e.preventDefault();
            var _getparent = jQuery(this).parents('.multi-select-area');
            jQuery(this).parents('.multi-select-area__tag li').remove();
            var tag_id = jQuery(this).parent().attr('data-id');
            _getparent.find(".multi-check-list input[data-id="+tag_id+"]").prop('checked', false);
            _getparent.find('.multi-select-dropdown .bottom-area').slideDown();

            if(jQuery('.multi-select-area__tag li').length == 0) {
                _getparent.find('.bottom-area').slideUp();
            }
            else {
                _getparent.find('.bottom-area').slideDown();
            }

            let option = $.trim(_getparent.find(".multi-check-list input[data-id="+tag_id+"]").val().toLowerCase());
            let extraOptionOther = $.trim(jQuery(".step-holder").data('extra-options-other').toLowerCase());
            if(option === extraOptionOther){
                jQuery('.input-wrap-other').slideUp(function (){
                    $(this).find('input').val('');
                });
            }
            dropdown_content.handleHideUntilNotAnswered();
        });
    },

    /**
     ** Search slide function
     **/

    search_slide: function() {
        jQuery('.search-input').on('keyup' ,function() {

            if(jQuery(this).val() == '') {
                jQuery(this).parents('.search-mode-area').find('.search-box').slideUp();
            }
            else {
                jQuery(this).parents('.search-mode-area').find('.search-box').slideDown();
                if(jQuery('.single-search-option-list li a').hasClass('selected')) {
                    let option = $.trim(jQuery('.single-search-option-list li a.selected').text().toLowerCase());
                    let extraOptionOther = $.trim(jQuery(".step-holder").data('extra-options-other').toLowerCase());
                    if (option === extraOptionOther) {
                        $('.single-bottom-area').show();
                    }
                }

                if (jQuery('.question_dropdown .row').height() > 380) {
                  jQuery('.question_dropdown').addClass('search-dropdown-up');
                }
                else {
                  jQuery('.question_dropdown').removeClass('search-dropdown-up');
                }
            }
        });

        jQuery('.checkbox').change(function () {
            var _getparent = jQuery(this).parents('.search-box');
            if (jQuery('.checkbox:checked').length <= 0) {
                _getparent.find('.bottom-area').slideUp();
            }
            else {
                _getparent.find('.bottom-area').slideDown();
            }
        });
    },

    /*
   ** search Select DropDown Finish Button function
   **/

    search_select_finish_btn: function() {
        jQuery('.search-box .finish-btn').click(function(e){
            e.preventDefault();
            var _getparent = jQuery(this).parents('.search-mode-area');
            var x = 0, checkboxes, tags;
            _getparent.find('.search-box').slideUp();
            _getparent.find('.search-input-wrap').addClass('tags-active');
            checkboxes = _getparent.find('input[type=checkbox]:checked');
            tags = _getparent.find('.tag-box__list');
            jQuery(tags).html('');
            jQuery(checkboxes).each(function () {
                jQuery(this).attr('data-id', 'tag-text' + x);
                var checkItem_text = jQuery(this).val();
                var subItem = String(checkItem_text);
                if (!tags.find('[data-id="' + 'tag-text' + x + '"]').length) {
                    tags.append('<li><span class="tag-text" data-id="tag-text' + x + '">' + subItem + '<a href="#" class="cancel"><i class="ico-cross"></i></a></span></li>');
                }
                x++;
            });
            _getparent.find('.search-input-wrap').removeClass('focused');
            _getparent.find('.search-input').val('');
        });
    },

    /*
    ** multi Select DropDown Remove Tag function
    **/

    search_select_remove_tag: function() {
        jQuery('body').off('click').on('click', '.tag-box__list .cancel', function (e) {
            e.preventDefault();
            var _getparent = jQuery(this).parents('.search-mode-area');
            jQuery(this).parents('.tag-box__list li').remove();
            var tag_id = jQuery(this).parent().attr('data-id');
            _getparent.find(".search-box__list input[data-id="+tag_id+"]").prop('checked', false);
            _getparent.find('.search-box .bottom-area').slideDown();

            if(jQuery('.tag-box__list li').length == 0) {
                _getparent.find('.bottom-area').slideUp();
                _getparent.find('.search-input-wrap').removeClass('tags-active');
            }
            else {
                _getparent.find('.bottom-area').slideDown();
                _getparent.find('.search-input-wrap').addClass('tags-active');
            }
            let option = $.trim(_getparent.find(".search-box__list input[data-id="+tag_id+"]").val().toLowerCase());
            let extraOptionOther = $.trim(jQuery(".step-holder").data('extra-options-other').toLowerCase());
            if(option === extraOptionOther){
                jQuery('.input-wrap-other').slideUp(function (){
                    $(this).find('input').val('');
                });
            }
        });
    },

    /*
   ** Single search DropDown value Question function
   **/

    single_search_dropdown_val: function() {

        jQuery('.single-search-option-list a').click(function(e){
            e.preventDefault();
            var _self = jQuery(this);
            var getHtml = _self.html();
            jQuery('.single-search-option-list li a').removeClass('selected');
            _self.addClass('selected');
            _self.parents('.search-mode-area').find('.search-input-wrap').addClass('tags-active');
            _self.parents('.search-mode-area').find('.search-tag-text').html(getHtml);
            if(!_self.hasClass('other-button')) {
                jQuery('.input-wrap-other').slideUp(function () {
                    $(this).find('input').val('');
                });
                _self.parents('.search-mode-area').find('.search-box').slideUp();
                $(".single-bottom-area").slideUp();
            }
            _self.parents('.search-mode-area').find('.search-input-wrap').removeClass('focused');
            _self.parents('.search-mode-area').find('.search-input').val('');
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
                dropdown_content.handleHideUntilNotAnswered();
            }

            if (jQuery('.multi-select-area').hasClass('multi-select-active')) {
                if (jQuery(target).parents('.multi-select-area').length > 0) {
                }
                else {
                    jQuery('.multi-select-area').removeClass('multi-select-active');
                    jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
                }
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

    otherFieldSet: function(){
        jQuery('[data-selection-input]').each(function(i,v){
            //add other button class if extra option `other` option value match in options list
            let option = $.trim(jQuery(v).find('input').val().toLowerCase());
            let extraOptionOther = $.trim(jQuery(".step-holder").data('extra-options-other').toLowerCase());
            if(option === extraOptionOther) {
                jQuery(this).addClass('other-button');
                jQuery(".input-wrap-other").remove();
                jQuery(this).after(' <div class="input-wrap-other">\n' +
                    ' <div class="other-input">\n' +
                    ' <input id="other_answer-1" type="text" data-button-type="other_answer" class="form-control validate-input" autocomplete="off" data-function-name="formValidation">\n' +
                    '  <label for="other_answer-1" class="input-label">your answer</label>\n' +
                    '  </div>\n' +
                    '  </div>');
            }
        });
        jQuery('.other-button').click(function(e) {
            jQuery(this).next('.input-wrap-other').slideDown(function () {
                dropdown_content.inputFocus();
                $('.scroll-bar').mCustomScrollbar("scrollTo","bottom",{
                    scrollInertia: 300
                });
                $(this).find('input').focus();
                $(".single-bottom-area").slideDown();
            });
        });
        jQuery('.single-finish-btn').click(function(e){
            $(this).parents('.single-select-area').removeClass('select-active');
            if ($(this).parents('.search-mode-area')) {
                $(this).parents('.search-mode-area').find('.search-box').slideUp();
            }
            $(".single-bottom-area").slideUp();
            jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
        });

        $(document).on('keyup','input[type="search"]',function(){
            var searchText = $(this).val().toLowerCase();
            $('[data-search-list] > li').each(function(){
                var currentLiText = $.trim($(this).find('[data-selection-input]').text().replace(/[\n]+/g,' ')).toLowerCase(),
                    showCurrentLi = currentLiText.indexOf(searchText) !== -1;
                $(this).toggle(showCurrentLi);
            });
        });
    },

    /**
     * handle hide until not answered functionality
     */
    handleHideUntilNotAnswered: function () {
        let is_hide_until_not_answered = json['options']['cta-button-settings']['enable-hide-until-answer'];
        //when enable-hide-until-answer is enabled than hide button until user not answered question
        if (is_hide_until_not_answered) {
            let active = 0;
            if (json['options']["select-multiple"] == 1) {
                active = jQuery('.question_dropdown .multi-check-list input[type="checkbox"]:checked').length;
            } else {
                active = jQuery('.question_dropdown .single-select-list li a.selected').length;
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
        dropdown_content.inputFocus();
        dropdown_content.inputBlur();
        dropdown_content.iframe_custom_scroll();
        dropdown_content.single_select_dropdown();
        dropdown_content.single_select_dropdown_val();
        dropdown_content.multi_select_dropdown();
        dropdown_content.multi_select_checkbox();
        dropdown_content.multi_select_finish_btn();
        dropdown_content.multi_select_remove_tag();
        dropdown_content.search_select_finish_btn();
        dropdown_content.search_select_remove_tag();
        dropdown_content.outsideclick();
        dropdown_content.addclass();
        dropdown_content.search_slide();
        dropdown_content.single_search_dropdown_val();
        dropdown_content.otherFieldSet();
    },
};
// No need for this, this is causing double event binding
// jQuery(document).ready(function() {
//     dropdown_content.init();
// });

