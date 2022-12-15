var dropdown_content = {

    /*
   ** Input Focus Function
   **/

    inputFocus: function() {
        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.input-wrap').addClass('focused');
        });

        jQuery('.form-control').focus(function(){
            jQuery(this).parents('.search-input-wrap').addClass('focused');
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
                jQuery(this).parents('.search-input-wrap').removeClass('focused');
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
        jQuery('.select-opener').click(function(e){
            e.preventDefault();
            jQuery(this).parents('.single-select-area').addClass('select-active');
        });

        // close single menu question on cross click in mobile view
        jQuery(document).on('click', '.icon-cancel', function() {
            jQuery(this).parents(".single-select-area").removeClass("select-active");
        });
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

            if(_self.hasClass('other-button')) {
                jQuery(this).next('.input-wrap').slideDown(function (e) {
                    $('.scroll-bar').mCustomScrollbar("scrollTo","bottom",{
                        scrollInertia: 300
                    });
                });
            }
            else {
                jQuery('.input-wrap').slideUp();
                setTimeout(function() {
                    _self.parents('.single-select-area').removeClass('select-active');
                }, 300);
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
        });

        // close multi menu question on cross click in mobile view
        jQuery(document).on('click', '.icon-cancel', function() {
            jQuery(this).parents(".multi-select-area").removeClass("multi-select-active");
        });
    },

    /*
    ** multi Select DropDown checkbox function
    **/

    multi_select_checkbox: function() {

        jQuery('.checkbox:not(.uncheckbox)').change(function () {
            var _getparent = jQuery(this).parents('.multi-select-area');
            if (jQuery('.checkbox:checked').length <= 0) {
                _getparent.find('.bottom-area').slideUp();
                _getparent.find('.uncheckbox').prop("checked", true);
            }
            else {
                _getparent.find('.bottom-area').slideDown();
                _getparent.find('.uncheckbox').prop("checked", false);
            }
        });

        jQuery('.uncheck-all').click(function (e) {
            var _getparent = jQuery(this).parents('.multi-select-area');
            var _self = jQuery(this);
            _getparent.find('.checkbox').prop("checked", false);
            _self.find('.checkbox').prop("checked", true);
            _getparent.find('.bottom-area').slideUp();
        });
    },

    /*
    ** multi Select DropDown Finish Button function
    **/

    multi_select_finish_btn: function() {
        jQuery('.finish-btn').click(function(e){
            e.preventDefault();
            var _getparent = jQuery(this).parents('.multi-select-area');
            var x = 0, checkboxes, tags;
            _getparent.removeClass('multi-select-active');
            checkboxes = _getparent.find('.checkbox:checked');
            tags = _getparent.find('.multi-select-area__tag');
            jQuery(checkboxes).each(function(){
                jQuery(this).attr('data-id', 'tag-text' + x);
                var checkItem_text = jQuery(this).parent('.check-label').find('.fake-label').html();
                var subItem = String(checkItem_text);
                if(!tags.find('[data-id="' + 'tag-text' + x + '"]').length) {
                    tags.append('<li><span class="tag-text" data-id="tag-text'+x+'">' + subItem + '<a href="#" class="cancel"><i class="ico-cross"></i></a></span></li>');
                }
                x++;
            });
        });
    },

    /*
    ** multi Select DropDown Remove Tag function
    **/

    multi_select_remove_tag: function() {
        jQuery('body').on('click', '.multi-select-area__tag .cancel', function (e) {
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
                }
            }

            if (jQuery('.multi-select-area').hasClass('multi-select-active')) {
                if (jQuery(target).parents('.multi-select-area').length > 0) {
                }
                else {
                    jQuery('.multi-select-area').removeClass('multi-select-active');
                }
            }
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
        jQuery('.finish-btn').click(function(e){
            e.preventDefault();
            var _getparent = jQuery(this).parents('.search-mode-area');
            var x = 0, checkboxes, tags;
            _getparent.find('.search-box').slideUp();
            _getparent.find('.search-input-wrap').addClass('tags-active');
            checkboxes = _getparent.find('.checkbox:checked');
            tags = _getparent.find('.tag-box__list');
            jQuery(checkboxes).each(function(){
                jQuery(this).attr('data-id', 'tag-text' + x);
                var checkItem_text = jQuery(this).parent('.check-label').find('.fake-label').html();
                var subItem = String(checkItem_text);
                if(!tags.find('[data-id="' + 'tag-text' + x + '"]').length) {
                    tags.append('<li><span class="tag-text" data-id="tag-text'+x+'">' + subItem + '<a href="#" class="cancel"><i class="ico-cross"></i></a></span></li>');
                }
                x++;
            });
        });
    },

    /*
    ** multi Select DropDown Remove Tag function
    **/

    search_select_remove_tag: function() {
        jQuery('body').on('click', '.tag-box__list .cancel', function (e) {
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
            _self.parents('.search-mode-area').find('.search-box').slideUp();
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
    },
};

jQuery(document).ready(function() {
    dropdown_content.init();
});

