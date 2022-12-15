window.selectItems = {
    'position-select':[
        {
            id: 'left',
            text: '<div class="options-style"><span class="name">Position:</span><span class="text">Stick to the left side</span></div>',
            title: 'Left Side'
        },
        {
            id: 'right',
            text: '<div class="options-style"><span class="name">Position:</span><span class="text">Stick to the right side</span></div>',
            title: 'Right Side'
        },
        {
            id: 'center',
            text: '<div class="options-style"><span class="name">Position:</span><span class="text">Place it inside content area</span></div>',
            title: 'Content area'
        },
    ],
    'ex-content-sort-select':[
        {
            id: 'left',
            text: '<div class="options-style"><span class="name">Sort by:</span><span class="text">Most' +
            ' Recent</span></div>',
            title: 'Most Recent'
        },
        {
            id: 'right',
            text: '<div class="options-style"><span class="name">Sort by:</span><span' +
            ' class="text">Ascending</span></div>',
            title: 'Ascending'
        },
        {
            id: 'center',
            text: '<div class="options-style"><span class="name">Sort by:</span><span' +
            ' class="text">Descending</span></div>',
            title: 'Descending'
        },
    ],
    'funnel-search-select':[
        {
            id: 'funnel-name',
            text: '<div class="options-style"><span class="name">Search by Funnel Name</span></div>',
            title: 'Search by Funnel Name'
        },
        {
            id: 'funnel-tags',
            text: '<div class="options-style"><span class="name">Search by Funnel Tags</span></div>',
            title: 'Search by Funnel Tags'
        },
    ],
    'select-size':[
        {
            id: '0',
            text: '<div class="options-style option-placeholder"><span class="name">Button size</span></div>',
            title: 'Button size'
        },
        {
            id: '1',
            text: '<div class="options-style"><span class="name">Small</span></div>',
            title: 'Small'
        },
        {
            id: '2',
            text: '<div class="options-style"><span class="name">Medium</span></div>',
            title: 'Medium'
        },
        {
            id: '3',
            text: '<div class="options-style"><span class="name">Large</span></div>',
            title: 'Large'
        },
    ],
    'select-cta':[
        {
            id: '0',
            text: '<div class="options-style option-placeholder"><span class="name">button labels</span></div>',
            title: 'button labels'
        },
        {
            id: '1',
            text: '<div class="options-style"><span class="name">Call to Action</span></div>',
            title: 'Call to Action'
        },
        {
            id: '2',
            text: '<div class="options-style"><span class="name">Share Counts</span></div>',
            title: 'Share Counts'
        },
        {
            id: '3',
            text: '<div class="options-style"><span class="name">None</span></div>',
            title: 'None'
        },
    ],
};

var extra_content = {

    ex_content_select_list : [
        {selecter:".position-select", parent:".position-select-parent"},
        {selecter:".ex-content-sort-select", parent:".ex-content-sort-parent"},
        {selecter:".funnel-search-select", parent:".funnel-search-select-parent"},
        {selecter:".select-size", parent:".select-size-parent"},
        {selecter:".select-cta", parent:".select-cta-parent"},
    ],

    /*
    ** custom select loop
    **/
    allCustomSelect: function () {
        var selectlist = extra_content.ex_content_select_list;
        for(var i = 0; i < selectlist.length; i++){
            extra_content.initCustomSelect(selectlist[i].selecter,selectlist[i].parent);
        }
    },

    /*
    ** init custom select
    **/
    initCustomSelect: function (selecter,parent) {
        var amIclosing = false;
        var _selector = jQuery(selecter);
        var _parent = jQuery(parent);
        var selectorClass = selecter.replace(/[#.]/g,'');
        _selector.select2({
            data: selectItems[selectorClass],
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(parent),
            width: '100%',
            templateResult: function (d) {
                return $(d.text);
            },
            templateSelection: function (d) {
                return $(d.text);
            }

            /*
            ** Triggered before the drop-down is opened.
            */
        }).on('select2:opening', function() {
            _parent.find('.select2-selection__rendered').css('opacity', '0');

            /*
            ** Triggered whenever the drop-down is opened.
            ** select2:opening is fired before this and can be prevented.
            */
        }).on('select2:open', function() {
            var _selectoptions = _parent.find('.select2-results__options');
            var _selectdropdown = _parent.find('.select2-dropdown');

            _selectoptions.css('pointer-events', 'none');

            setTimeout(function() {
                _selectoptions.css('pointer-events', 'auto');
            }, 300);

            _selectdropdown.hide();
            _selectdropdown.css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            _parent.find('.select2-selection__rendered').hide();
            extra_content.nice_scroll();
            setTimeout(function () {
                _parent.find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                    var getindex = _selector.find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    jQuery(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                });
            }, 100);

            /*
            ** Triggered before the drop-down is closed.
            */
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;

                _parent.find('.select2-dropdown').attr('style', '');
                setTimeout(function () {
                    _selector.select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }

            /*
            ** Triggered whenever the drop-down is closed.
            ** select2:closing is fired before this and can be prevented.
            */
        }).on('select2:close', function() {
            _parent.find('.select2-selection__rendered').show();
            _parent.find('.select2-selection__rendered').css('opacity', '1');
            _parent.find('.select2-results__options').css('pointer-events', 'none');
        });

        if (selectorClass == 'funnel-search-select') {
            _selector.on('change', function () {
                if(jQuery(this).val() == 'funnel-name') {
                    jQuery('.funnel-search-area__input-name').show();
                    jQuery('.funnel-search-area__input-tag').hide();
                }
                if(jQuery(this).val() == 'funnel-tags') {
                    jQuery('.funnel-search-area__input-name').hide();
                    jQuery('.funnel-search-area__input-tag').show();
                }
            });
        }
        $('.select-size, .select-cta').val(1).trigger('change');
    },

    /* tooltip function */

    tooltip: function () {
        jQuery('.ex-content-tooltip').tooltipster({
            contentAsHTML: true
        });

        jQuery('.ex-content-button-tooltip').tooltipster({
            contentAsHTML: true,
            delay: 0,
            speed: 50,
            debug: false
        });
    },

    /* Rangebar slider function */

    range_slider: function () {
        jQuery('.size-range-bar-slide').bootstrapSlider({
            formatter: function(value) {
                jQuery('.size-range-bar-val').val(value);
                return   value +'%';
            },
            min: 75,
            max: 100,
            value: jQuery('.size-range-bar-val').val(),
            tooltip: 'always',
            tooltip_position:'bottom'
        });

        jQuery('.icon-range-bar-slide').bootstrapSlider({
            formatter: function(value) {
                jQuery('.size-range-bar-val').val(value);
                return   value +'px';
            },
            min: 10,
            max: 30,
            value: jQuery('.icon-range-bar-val').val(),
            tooltip: 'always',
            tooltip_position:'bottom'
        });

        jQuery('.video-range-bar-slide').bootstrapSlider({
            formatter: function(value) {
                jQuery('.video-range-bar-val').val(value);
                return   value +'%';
            },
            min: 30,
            max: 100,
            value: jQuery('.video-range-bar-val').val(),
            tooltip: 'always',
            tooltip_position:'bottom'
        }).on("slide", function(slideEvt) {
            jQuery("#preview-img").css('width', slideEvt.value + '%');
            jQuery("#preview-img").css('height', slideEvt.value + '%');
        });
    },

    /* zoom lock function */

    zoom_toggle: function () {
        jQuery('.lock-zoom-view').click(function(){
            jQuery(this).parents('.zoom-slider-item').addClass('zoom-slider-disable');
            jQuery('.range-slider-overlay').tooltipster('enable');
        });

        jQuery('.unlock-zoom-view').click(function(){
            jQuery(this).parents('.zoom-slider-item').removeClass('zoom-slider-disable');
            jQuery('.range-slider-overlay').tooltipster('disable');
        });
    },

    /* Custom Scroll function */

    custom_scroll: function () {
        if(jQuery('[data-custom-scroll]').length > 0) {
            jQuery('[data-custom-scroll]').mCustomScrollbar({
                scrollInertia: 500,
                axis: "y",
                callbacks:{
                    whileScrolling:function(){
                        var galleryLength = jQuery(this).find('[data-gallery-opener]').length;
                        var iconsLength = jQuery(this).find('[data-icons-opener]').length;
                        var tagsLength =  jQuery(this).find('[data-tags-opener]').length;
                        var swatchLength = jQuery(this).find('.ex-content__color-swatch').length;
                        if(galleryLength) {
                            var offset = jQuery(this).find('[data-gallery-opener]')[0].getBoundingClientRect();
                            var offsetTop = offset.top;
                            var offsetLeft = offset.left;
                            var self = jQuery(this).parent().find('.ex-content__gallery-dropdown');
                            self.css('top', offsetTop + 50);
                            self.css('left', offsetLeft - 25);
                        }

                        if(iconsLength) {
                            var offset = jQuery(this).find('[data-icons-opener]')[0].getBoundingClientRect();
                            var offsetTop = offset.top;
                            var offsetLeft = offset.left;
                            var self = jQuery(this).parent().find('.ex-content__icons-popup');
                            self.css('top', offsetTop - 235);
                            self.css('left', offsetLeft + 185);
                        }

                        if(tagsLength) {
                            jQuery('[data-tags-opener]').each(function(){
                                var offset = jQuery(this)[0].getBoundingClientRect();
                                var offsetTop = offset.top;
                                var offsetLeft = offset.left;
                                var self = jQuery(this).parent().find('.modal-tags-popup-wrap');
                                var getHeight = self.height() + 40;
                                self.css('top', offsetTop - getHeight);
                                self.css('left', offsetLeft);
                            });
                        }

                        if(swatchLength) {
                            var select_button = $(".ex-content__label-color-parent").offset();
                            var select_button1 = $(".ex-content__strip-color-parent").offset();
                            var window_height = $(window).height();
                            var select_dropdown = $('.color-box__panel-wrapper').height();
                            var select_total = select_button.top + select_dropdown;
                            var select_total1 = select_button1.top + select_dropdown;
                            if(window_height < select_total){
                                $(".color-box__panel-wrapper.ex-content__label-color").offset({top:select_button.top-select_dropdown-47, left:select_button.left-280});
                            }
                            else {
                                $(".color-box__panel-wrapper.ex-content__label-color").offset({top:select_button.top+47, left:select_button.left-280});
                            }

                            if(window_height < select_total1){
                                $(".color-box__panel-wrapper.ex-content__strip-color").offset({top:select_button1.top-select_dropdown-47, left:select_button1.left-280});
                            }
                            else {
                                $(".color-box__panel-wrapper.ex-content__strip-color").offset({top:select_button1.top+47, left:select_button1.left-280});
                            }
                        }
                    },
                },
            });
        }
    },

    /* Open Close function */

    open_close: function () {
        jQuery('[data-opener]').click(function(e){
            e.preventDefault();
            jQuery(this).parent().find('[data-slide]').stop().slideToggle();
            jQuery(this).parent().toggleClass('active');
        });

        jQuery('[popup-opener]').click(function(e){
            e.preventDefault();
            jQuery(this).toggleClass('popup-active');
            jQuery(this).parent().toggleClass('active');
            if(jQuery(this).parent().find('.ex-content__gallery-dropdown').length > 0) {
                var offset = this.getBoundingClientRect();
                var offsetTop = offset.top;
                var offsetLeft = offset.left;
                var self = jQuery(this).parent().find('.ex-content__gallery-dropdown');
                self.css('top', offsetTop + 50);
                self.css('left', offsetLeft - 25);
            }

            if(jQuery(this).parent().find('.ex-content__icons-popup').length > 0) {
                var offset = this.getBoundingClientRect();
                var offsetTop = offset.top;
                var offsetLeft = offset.left;
                var self = jQuery(this).parent().find('.ex-content__icons-popup');
                self.css('top', offsetTop - 235);
                self.css('left', offsetLeft + 185);
            }
        });

        jQuery('[design-block]').click(function(){
            var _self = jQuery(this);
            if(_self.hasClass('active')) {
                _self.removeClass('active');
            } else {
                jQuery('[design-block]').removeClass('active');
                _self.addClass('active');
            }
        });

        jQuery('body').on('change', '[data-checkbox]', function(){
            var _self = jQuery(this);
            var _parent_self =  _self.parents('[data-checkbox-parent]').find('[checkbox-slide]').stop();
            if(_self.is(':checked')) {
                _parent_self.slideDown(function () {
                    jQuery('.ex-content-sidebar__body').mCustomScrollbar("scrollTo","bottom",{
                        scrollInertia: 500
                    });
                });
            } else {
                _parent_self.slideUp();
            }
        });

        jQuery('body').on('change', '[ex-content-data-count]', function(){
            var _self = jQuery(this);
            if(_self.is(':checked')) {
                _self.parents('li').find('.form-control').attr('disabled', false);
            } else {
                _self.parents('li').find('.form-control').attr('disabled', true);
            }
        });

        jQuery('[data-tags-opener]').click(function(e){
            e.preventDefault();
            jQuery(this).toggleClass('active');
            jQuery(this).parent().toggleClass('popup-active');
            var offset = this.getBoundingClientRect();
            var offsetTop = offset.top;
            var offsetLeft = offset.left;
            var self = jQuery(this).parent().find('.modal-tags-popup-wrap');
            var getHeight = self.height() + 40;
            self.css('top', offsetTop - getHeight);
            self.css('left', offsetLeft);
        });
    },

    /* Accordion function */

    accordion: function () {
        jQuery('[accordion-opener]').click(function(e){
            e.preventDefault();
            var _self = jQuery(this).parents('[accordion-parent]');
            if(_self.hasClass('active')) {
                _self.find('[accordion-slide]').stop().slideUp();
                _self.removeClass('active');
            } else {
                _self.parents('[accordion-parent-row]').find('[accordion-slide]').stop().slideUp();
                _self.find('[accordion-slide]').stop().slideDown();
                _self.parents('[accordion-parent-row]').find('[accordion-parent]').removeClass('active');
                _self.addClass('active');
            }
            extra_content.tags_funcation();
        });
    },

    /* Tags function */

    tags_funcation: function () {

        jQuery('.modal-tags-holder-wrap').each(function(){
            var temp_width = 45;
            var index = 0;
            var room = 500;
            jQuery(this).find('li').each(function(){
                temp_width = temp_width + jQuery(this).outerWidth();
                if(temp_width < room){
                    index++;
                }
            });
            jQuery(this).find('li:gt('+ (index-1) +')').hide();
            jQuery(this).parents('.modal-tags-holder').find('.modal-more').show();
            if(temp_width <= room){
                jQuery(this).parents('.modal-tags-holder').find('.modal-more').hide();
            }
        });
    },

    //*
    // ** clone function
    // *

    clone_function:function () {
        jQuery('.tags-list').each(function(){
            var _self = jQuery(this);
            var html = _self.clone();
            _self.parents('.modal-tags-holder').find('.modal-tags-popup-list').append(html);
        });
    },

    //*
    // ** Nice Scroll
    // *

    nice_scroll:function () {
        jQuery(".ex-content-select2-parent").click(function () {
            jQuery('.select2-results__options').niceScroll({
                cursorcolor:" #fff",
                cursorwidth: "7px",
                autohidemode: false,
                railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
                cursorborder: "1px solid #02abec",
            });
        });
    },

    /*
       * Checkbox function
   * */

    check_funcation: function () {
        jQuery('[social-network-checkbox]').change(function () {
            var _self = jQuery(this).parents('.social-networks-modal').find('[save-btn]');
            if (jQuery('[social-network-checkbox]:checked').length <= 0) {
                _self.prop("disabled", true);
            } else {
                _self.prop("disabled", false);
            }
        });

        jQuery('[share-funnel-checkbox]').change(function () {
            var _self = jQuery(this).parents('.share-funnel-modal').find('[save-btn]');
            if (jQuery('[share-funnel-checkbox]:checked').length <= 0) {
                _self.prop("disabled", true);
            } else {
                _self.prop("disabled", false);
            }
        });

        jQuery('[design-block]').click(function () {
            var _self = jQuery(this);
            var _parent_self = _self.parents('.design-block-modal').find('[save-btn]');
            if(_self.hasClass('active')) {
                _parent_self.prop("disabled", false);
            } else {
                _parent_self.prop("disabled", true);
            }
        });
    },

    /*
    ** Drag Feature function
    **/

    drag_feature: function () {
        jQuery('[drag-parent]').sortable({
            placeholder: "drag-highlight-row",
            scroll: true,
            axis: "y",
            handle: "[drag-handle]",
            start:function(){
                jQuery('.drag-highlight-row').text('Drop Your Element Here');
            },
        });
    },

    /*
    * outsideClick function
  * */

    outside_click: function () {
        jQuery(document).click(function (e) {
            var target = e.target;

            if(jQuery('[data-gallery-parent]').hasClass('active')) {
                if (jQuery(target).parents('[data-gallery-parent]').length > 0) {
                }
                else {
                    jQuery('[data-gallery-parent]').removeClass('active');
                }
            }

            if(jQuery('[data-icons-parent]').hasClass('active')) {
                if (jQuery(target).parents('[data-icons-parent]').length > 0) {
                }
                else {
                    jQuery('[data-icons-parent]').removeClass('active');
                }
            }

            if(jQuery('[data-tags-parent]').hasClass('popup-active')) {
                if (jQuery(target).parents('[data-tags-parent]').length > 0) {
                }
                else {
                    jQuery('[data-tags-parent]').removeClass('popup-active');
                }
            }

            if(jQuery(".lp-custom-select").hasClass('lp-custom-select-active')) {
                if (jQuery(target).parents('.lp-custom-select').length > 0 || jQuery(target).hasClass('lp-custom-select__opener') == true) {
                }
                else {
                    jQuery('.lp-custom-select').removeClass('lp-custom-select-active');
                }
            }
        });
    },

    /*
       ** Modal callbacks function
    **/

    modal_callbacks: function () {
        jQuery('.ex-content-modal').on('shown.bs.modal', function () {
            jQuery('[date-field]').find('.form-control').focus();
        });

        jQuery('.insert-video-modal').on('hidden.bs.modal', function () {
            var _self = jQuery(this);
            _self.find('.url-validate').val('');
            _self.find('.ex-content-video-block-area').hide();
            _self.find('#preview-img').attr('src', '');
        });

        jQuery('.ex-content-gallery-modal').on('hidden.bs.modal', function () {
            jQuery(this).find('.btn-insert-image').prop("disabled", true);
        });

        jQuery('.design-block-modal').on('hidden.bs.modal', function () {
            var _self = jQuery(this);
            _self.find('.block-item').removeClass('active');
            _self.find('[save-btn]').prop("disabled", true);
        });
    },

    /*
      ** init function
    **/

    init: function() {
        extra_content.tooltip();
        extra_content.range_slider();
        extra_content.zoom_toggle();
        extra_content.custom_scroll();
        extra_content.open_close();
        extra_content.nice_scroll();
        extra_content.check_funcation();
        extra_content.drag_feature();
        extra_content.accordion();
        extra_content.tags_funcation();
        extra_content.clone_function();
        extra_content.outside_click();
        extra_content.allCustomSelect();
        extra_content.modal_callbacks();
    },
};

jQuery(document).ready(function() {
    extra_content.init();
});