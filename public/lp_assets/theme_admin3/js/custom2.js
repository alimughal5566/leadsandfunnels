var pos_top = '';
var pos_left = '';
var color_picker_block_height = '';
var color_picker_elm = '';
var $elem_this = '';
var rtl = '';
var $elm = '';
window.parentClass = selector = render = selected_folder_list = '';
window.selected_tag_list = funnel_selected_tag_list = window.selected_clone_tag_list = new Array();
window.tag_dropdown = jQuery.parseJSON(tag_list);
window.niceScrollHide = false;
window.folder_data = jQuery.parseJSON(folder_list);
var lpUtilities = {

    // select2 for multi selction
    lp_tag_list : [
//        {selecter:"#dashboard_tag_list",parent:".dashboard-tag-result"},
//        {selecter:"#tag_list",parent:".tag-result"},
//        {selecter:".top-tag-search",parent:".top-tag-result"},
//        {selecter:".tag_list",parent:".clone-new-tag"},
//        {selecter:"#tag_list-pop",parent:".tag-result-pop"},
//        {selecter:"#tag_list-pop-zapier",parent:".zapier-funnel-tag-parent"},
        {selecter: "#create_funnel_tag_list",parent: ".funnel-tag-result"}
    ],

    //select2 for single selection
    lpSelect2List : [
        {selecter:".select2js__folder",parent:".select2js__folder-parent"}
    ],

    //Folder select2
    lpFolderSelect2list : [
        {selecter:".select2js__folder_list",parent:".funnel-tag-result"}
    ],


    /* custom accordion function */
    initCustomAccordion: function() {
        jQuery('.custom-accordion__opener').click(function (e) {
            e.preventDefault();
            var _self = jQuery(this);
            if(_self.hasClass('active')) {
                _self.removeClass('active');
                _self.next('.custom-accordion__slide').slideUp();
            }

            else {
                _self.parents('.custom-accordion').find('.custom-accordion__opener').removeClass('active');
                _self.parents('.custom-accordion').find('.custom-accordion__slide').slideUp();
                _self.addClass('active');
                _self.next('.custom-accordion__slide').slideDown();
            }
        });
    },

    /*
    * sidebarMenu Function
    * */
    sidebarMenu: function () {
        // jQuery('.menu__link-text').fadeOut(100);
        if (window.location.href.indexOf("dashboard.php") > -1) {
            jQuery(".collapse-link").click(function (e) {
                e.preventDefault();
                //set from @mzac90
                setTimeout(function() {
                    lpUtilities.dashboardChart();
                }, 300);
                if(jQuery('body').hasClass('sidebar-active') == true) {
                    jQuery('body').removeClass('sidebar-active');
                    jQuery('aside.sidebar .menu__link-icon').tooltipster({
                        position: 'right',
                    });
                    jQuery('aside.sidebar .menu__link-icon').tooltipster('enable');
                }else{
                    jQuery('body').addClass('sidebar-active');
                    jQuery('aside.sidebar .menu__link-icon').tooltipster('disable');
                    // jQuery('aside.sidebar .menu__link-icon').tooltipster('hide');
                }
                setTimeout(function(){
                    $("#statsChart").highcharts().reflow();
                }, 300);
            });
        }else {
            jQuery('aside.sidebar .menu__link-icon').tooltipster({
                position: 'right',
            });

            if(jQuery('body').hasClass('funnel-question-page-group')){
                jQuery('.menu__link').tooltipster({
                    position: 'right',
                });
            }
        }

        // jQuery("aside.sidebar").mouseenter(function() {
        //     jQuery('body').addClass('sidebar-active');
        // }).mouseleave(function() {
        //     jQuery('body').removeClass('sidebar-active');
        // });
        jQuery(function() {
            var timeoutid = null;
            jQuery("aside.sidebar-inner").mouseenter(function () {
                /*jQuery('.funnels-dropdown .toggle-menu').slideUp(function () {
                    jQuery('.funnels-dropdown.toggle-dropdown').removeClass('open');
                });*/

                if(!(jQuery('body').hasClass('funnel-question-page-group'))) {
                    timeoutid = setTimeout(function () {
                        if (jQuery('body').hasClass('off-sidebar')) {
                            jQuery('body').stop().addClass('sidebar-inner-active');
                        } else {
                            return true;
                        }
                    }, 250);
                }
            }).mouseleave(function () {
                clearTimeout(timeoutid);
                if(!(jQuery('body').hasClass('funnel-question-page-group'))) {
                    if (jQuery('body').hasClass('off-sidebar')) {
                        jQuery('body').stop().removeClass('sidebar-inner-active');
                    } else {
                        return true;
                    }
                }
            });
        });

        jQuery(".menu__list.menu__list_sub-menu").mouseenter(function(){
            if(!(jQuery('body').hasClass('funnel-question-page-group'))) {
                jQuery("input").trigger("blur");
                jQuery('aside.sidebar-inner').css('overflow', 'visible');
                jQuery('.sidebar-inner-menu-wrap').css('overflow', 'visible');
                jQuery('.sidebar-inner-menu-wrap .mCustomScrollBox').css('overflow', 'visible');
                jQuery('.sidebar-inner-menu-wrap .mCSB_container').css('overflow', 'visible');
            }
        }).mouseleave(function() {
            if(!(jQuery('body').hasClass('funnel-question-page-group'))) {
                jQuery('.sidebar-inner-menu-wrap').css('overflow', 'hidden');
                jQuery('.sidebar-inner-menu-wrap .mCustomScrollBox').css('overflow', 'hidden');
                jQuery('.sidebar-inner-menu-wrap .mCSB_container').css('overflow', 'hidden');
                //jQuery('aside.sidebar-inner').css('overflow','hidden');
            }
        });
        jQuery('.funnel-question-page-group .menu__list.menu__list_sub-menu').click(function (e){
            //e.preventDefault();
            if(jQuery(this).hasClass('menu-active')) {
                jQuery('.sidebar-inner-menu-wrap').css('overflow', 'hidden');
                jQuery('.sidebar-inner-menu-wrap .mCustomScrollBox').css('overflow', 'hidden');
                jQuery('.sidebar-inner-menu-wrap .mCSB_container').css('overflow', 'hidden');
                jQuery('.menu__dropdown-wrapper').removeClass('menu-dropdown-active');
                jQuery(this).removeClass('menu-active');
            }
            else {
                jQuery('.menu__list.menu__list_sub-menu').removeClass('menu-active');
                jQuery(this).addClass('menu-active');
                jQuery('.menu__dropdown-wrapper').removeClass('menu-dropdown-active');
                jQuery(this).find('.menu__dropdown-wrapper').addClass('menu-dropdown-active');
                jQuery("input").trigger("blur");
                jQuery('aside.sidebar-inner').css('overflow', 'visible');
                jQuery('.sidebar-inner-menu-wrap').css('overflow', 'visible');
                jQuery('.sidebar-inner-menu-wrap .mCustomScrollBox').css('overflow', 'visible');
                jQuery('.sidebar-inner-menu-wrap .mCSB_container').css('overflow', 'visible');
            }
        });

    },

    sidebMenuToggle: function() {
        jQuery('.funnel-question-page-group .menu-holder__head').click(function (){
            jQuery('body').toggleClass('sidebar-inner-active');
            if(jQuery('body').hasClass('sidebar-inner-active')) {
                jQuery('aside.sidebar-inner .menu__link').tooltipster('disable');
            }
            else{
                jQuery('aside.sidebar-inner .menu__link').tooltipster('enable');
            }
        });
    },

    /*
    * selectFunnel Function
    * */
    selectFunnel: function() {
        // jQuery('.funnels-dropdown .toggle-menu').slideUp();
        jQuery('.funnels-dropdown .toggle-link').click(function (e) {
            e.preventDefault();
            if(jQuery(this).parent('.toggle-dropdown').hasClass('open')) {
                jQuery(this).parent('.toggle-dropdown').find('.toggle-menu').attr('style', '');
                jQuery(this).parent('.toggle-dropdown').removeClass('open');
            } else {
                jQuery(this).parent('.toggle-dropdown').addClass('open');
                jQuery(this).parent('.toggle-dropdown').find('.toggle-menu').css({'display': 'block', 'opacity': '1', 'transform': 'scaleX(1) scaleY(1)'});
                lpUtilities.searchplaceholder();
            }
        });
    },

    /*
    * quick access menu Function
    * */
    quickAccess: function() {
        jQuery('.quick-dropdown').slideUp();
        jQuery('.client-setting__opener').click(function (e) {
            e.preventDefault();
            if(jQuery(this).parent('.client-setting__quick').hasClass('quick-active')) {
                jQuery(this).parent('.client-setting__quick').find('.quick-dropdown').slideUp(400, function () {
                    jQuery(this).parent('.client-setting__quick').removeClass('quick-active');
                });
            } else {
                jQuery(this).parent('.client-setting__quick').addClass('quick-active');
                jQuery(this).parent('.client-setting__quick').find('.quick-dropdown').slideDown();
            }
        });
    },

    /*
    * profileSetting Function
    * */
    profileSetting: function () {
        jQuery('.account-setting').click(function () {
            if(jQuery(this).hasClass('open')) {
                jQuery(this).find('.settings__dropdown').attr('style', '');
                jQuery(this).removeClass('open');
            } else {
                jQuery(this).addClass('open');
                jQuery(this).find('.settings__dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scaleX(1) scaleY(1)'});
            }
        });

        jQuery('.toggle-link').click(function (e) {
            e.preventDefault();
        });
    },

    /*
    * select custom Function
    * */
    init_customSelect: function() {
        var amIclosing = false;
        // funnel type
        jQuery('.select-custom_type').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".funnel-type"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.funnel-type .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.funnel-type .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.funnel-type .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.funnel-type .select2-dropdown').hide();
            jQuery('.funnel-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            lpUtilities.niceScroll();
            jQuery('.funnel-type .select2-selection__rendered').hide();
            setTimeout(function () {
                jQuery('.funnel-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                    var getindex = jQuery('.select-custom_type').find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight - 50;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.funnel-type .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select-custom_type').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.funnel-type .select2-selection__rendered').show();
            jQuery('.funnel-type .select2-results__options').css('pointer-events', 'none');
        });

        // funnel type by category
        jQuery('.select-custom_category').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".funnel-category"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.funnel-category .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.funnel-category .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.funnel-category .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.funnel-category .select2-dropdown').hide();
            jQuery('.funnel-category .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.funnel-category .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.funnel-category .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select-custom_category').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.funnel-category .select2-selection__rendered').show();
            jQuery('.funnel-category .select2-results__options').css('pointer-events', 'auto');
        });

        // funnel type by tags
        jQuery('.select-custom_tag').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".funnel-tag"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.funnel-tag .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.funnel-tag .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.funnel-tag .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.funnel-category .select2-dropdown').hide();
            jQuery('.funnel-tag .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.funnel-tag .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.funnel-tag .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select-custom_tag').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.funnel-tag .select2-selection__rendered').show();
            jQuery('.funnel-tag .select2-results__options').css('pointer-events', 'auto');
        });

        // funnel folder dropdown

        jQuery('.megamenu__folder_select').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".megamenu__folder"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.megamenu__folder .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.megamenu__folder .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.megamenu__folder .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.megamenu__folder .select2-dropdown').hide();
            jQuery('.megamenu__folder .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.megamenu__folder .select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                jQuery('.megamenu__folder .select2-dropdown .nicescroll-rails-vr').each(function () {
                    var getindex = jQuery('.megamenu__folder_select').find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight - 50;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.megamenu__folder .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.megamenu__folder_select').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.megamenu__folder .select2-selection__rendered').show();
            jQuery('.megamenu__folder .select2-results__options').css('pointer-events', 'auto');
        });

        // funnel type by megamenu category select for mortagage
        jQuery('.megamenu__category_select').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".megamenu__category"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.megamenu__category .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.megamenu__category .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.megamenu__category .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.megamenu__category .select2-dropdown').hide();
            jQuery('.megamenu__category .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.megamenu__category .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.megamenu__category .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.megamenu__category_select').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.megamenu__category .select2-selection__rendered').show();
            jQuery('.megamenu__category .select2-results__options').css('pointer-events', 'auto');
        });

        // funnel type by megamenu tag
        jQuery('.megamenu__tag_select').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".megamenu__tag"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.megamenu__tag .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.megamenu__tag .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.megamenu__tag .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.megamenu__tag .select2-dropdown').hide();
            jQuery('.megamenu__tag .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.megamenu__tag .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.megamenu__tag .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.megamenu__tag_select').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.megamenu__tag .select2-selection__rendered').show();
            jQuery('.megamenu__tag .select2-results__options').css('pointer-events', 'auto');
        });

        // sorting select
        jQuery('.select-custom_sorting').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".heading-bar__sorting-list"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.heading-bar__sorting-list .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.heading-bar__sorting-list .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.heading-bar__sorting-list .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.heading-bar__sorting-list .select2-dropdown').hide();
            jQuery('.heading-bar__sorting-list .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.heading-bar__sorting-list .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.heading-bar__sorting-list .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select-custom_sorting').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.heading-bar__sorting-list .select2-selection__rendered').show();
            jQuery('.heading-bar__sorting-list .select2-results__options').css('pointer-events', 'auto');
        });
    },

    /*
    * select2 search for tags
    * */
    searchplaceholder: function() {
        jQuery('.custom-search').select2({
            width: '100%',
            /*dropdownParent: $('.funnel-tag-search'),*/
            placeholder: {
                text: 'Type in Funnel Tag(s)...'
            }
        });
    },

    /*
    * select search bar funnel-category Function
    * */
    selectCategory: function () {
        // search bar
        var self = this
        jQuery('.select-custom_category').change(function (){
            var $searchFilter = jQuery(this).parents('.search-bar__filter');
            if(jQuery(this).val() == 2) {
                //jQuery(this).parents('.search-bar__filter').addClass('show-funnel-tag');
                $searchFilter.find('.funnel-name-search,.funnel-url-search').hide();
                $searchFilter.find('.funnel-tag-search,.funnel-tag').show();
                lpUtilities.searchplaceholder();
                self.calculateTopTagSearchPosition()
                self.select2jsPlaceholder()

            }else if(jQuery(this).val() == 3) {
                $searchFilter.find('.funnel-name-search,.funnel-tag,.funnel-tag-search').hide();
                $searchFilter.find('.row').removeClass('col-equal')
                $searchFilter.find('.funnel-url-search').show();
                lpUtilities.searchplaceholder();
            } else {
                //jQuery(this).parents('.search-bar__filter').removeClass('show-funnel-tag');
                $searchFilter.find('.funnel-tag-search,.funnel-tag,.funnel-url-search').hide();
                $searchFilter.find('.row').removeClass('col-equal')
                $searchFilter.find('.funnel-name-search').show();
            }
        });

        // megamenu search bar funnel-category Function
        jQuery('.megamenu__category_select').change(function (){
            if(jQuery(this).val() == 2) {
                jQuery(this).parents('.search-bar__filter').addClass('megamenu-show-funnel-tag');
                jQuery(this).parents('.search-bar__filter').find('.funnel-name-search,.funnel-url-search').hide();
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag-search,.megamenu__tag').show();
                lpUtilities.searchplaceholder();
            }else if(jQuery(this).val() == 3) {
                jQuery(this).parents('.search-bar__filter').addClass('megamenu-show-funnel-tag');
                jQuery(this).parents('.search-bar__filter').find('.funnel-name-search,.funnel-tag-search,.megamenu__tag').hide();
                jQuery(this).parents('.search-bar__filter').find('.funnel-url-search').show();
                lpUtilities.searchplaceholder();
            } else {
                jQuery(this).parents('.search-bar__filter').removeClass('megamenu-show-funnel-tag');
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag-search,.funnel-url-search,.megamenu__tag').hide();
                jQuery(this).parents('.search-bar__filter').find('.funnel-name-search').show();
            }
        });
    },

    /*
    * Megamenu init tabs
    * */
    megaMenu: function() {
        // jQuery('.megamenu a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        //     e.target // newly activated tab
        //     e.relatedTarget // previous active tab
        //     e.target.attributes.href.nodeValue;
        // e.target.attributes.href.nodeValue + '
        jQuery('.megamenu__category_select').select2({
            minimumResultsForSearch: -1,
            // e.target.attributes.href.nodeValue +
            dropdownParent: jQuery(".megamenu__category"),
            width: '100%'
        });
        // e.target.attributes.href.nodeValue +
        jQuery('.custom-search').select2({
            width: '100%',
            placeholder: {
                text: 'Type in Funnel Tag(s)...'
            }
        });

        lpUtilities.searchplaceholder();
        // });
    },

    /*
    * megamenu-funnels mCustomScrollbar
    * */
    megamenu_mCustomScrollbar: function() {
        jQuery('.megamenu-funnels').mCustomScrollbar({
            mouseWheel:{
                scrollAmount: 80,
            },
            scrollInertia: 0,
            live: true,
            callbacks:{
                onScroll:function(){
                    jQuery('.tags-popup-wrap').css('display', 'none');
                }
            }
        });
    },

    /*
    * outsideClick close all dropdowns
    * */

    outsideClick: function () {
        jQuery(document).click(function(e) {
            var target = e.target;

            // sidebar menu outside click
            /*if(jQuery("body").hasClass('sidebar-active')) {
                // Navbar is opened on mobile
                if (jQuery(target).parents('.sidebar').length > 0) { }
                else{
                    jQuery('.menu__link-text').fadeOut(100);
                    jQuery('.large-logo').fadeOut(100, function () {
                        jQuery('.micro-logo').fadeIn(100);
                    });
                    jQuery('body').removeClass('sidebar-active');
                }
            }*/

            // select funnels dropdown outside click
            if(jQuery(".toggle-dropdown").hasClass('open')) {
                // Close mega menu only when click outside, when website modal isn't open OR not clicked on website modal close button
                var is_website_modal_open_or_hidding = ($("#modal_mortgageWebsiteFunnel").hasClass("show") || jQuery(target).attr("id") === "website_funnel_modal_hide");
                if (is_website_modal_open_or_hidding || jQuery(target).parents('.toggle-dropdown').length > 0 || jQuery(target).hasClass('select2-selection__choice__remove') == true) {
                }
                else {
                    jQuery(this).find('.toggle-menu').attr('style', '');
                    jQuery(".toggle-dropdown").removeClass('open');
                }
            }

            if(jQuery(".funnel-head").hasClass('tags-active')) {
                if (jQuery(target).parents('.tags-holder').length > 0) {
                }
                else {
                    jQuery('.tags-popup-wrap').fadeOut(400, function () {
                        jQuery('.funnel-head').removeClass('tags-active');
                    });
                }
            }

            if(jQuery(".megamenu-funnels__box").hasClass('tag-active')) {
                if (jQuery(target).parents('.tags-holder').length > 0) {
                }
                else {
                    jQuery('.tags-popup-wrap').fadeOut(400, function () {
                        jQuery('.megamenu-funnels__box').removeClass('tag-active');
                    });
                }
            }

            if(jQuery(".modal-tags-holder").hasClass('modal-seetings-tags')) {
                if (jQuery(target).parents('.modal-tags-holder').length > 0) {
                }
                else {
                    jQuery('.modal-tags-popup-wrap').fadeOut(400, function () {
                        jQuery('.modal-tags-holder').removeClass('modal-seetings-tags');
                    });
                }
            }

            if(jQuery(".confirm-modal-tags-holder").hasClass('confirm-modal-seetings-tags')) {
                if (jQuery(target).parents('.confirm-modal-tags-holder').length > 0) {
                }
                else {
                    jQuery('.confirm-modal-tags-popup-wrap').fadeOut(400, function () {
                        jQuery('.confirm-modal-tags-holder').removeClass('confirm-modal-seetings-tags');
                    });
                }
            }

            if(jQuery(".inte-modal-tags-holder").hasClass('inte-modal-seetings-tags')) {
                if (jQuery(target).parents('.inte-modal-tags-holder').length > 0) {
                }
                else {
                    jQuery('.inte-modal-tags-popup-wrap').fadeOut(400, function () {
                        jQuery('.inte-modal-tags-holder').removeClass('inte-modal-seetings-tags');
                    });
                }
            }

            if(jQuery(".menu__list").hasClass('menu-active')) {
                if (jQuery(target).parents('.menu-active').length > 0 || jQuery(target).hasClass('menu__list')) {
                }
                else {
                    jQuery('.sidebar-inner-menu-wrap').css('overflow', 'hidden');
                    jQuery('.sidebar-inner-menu-wrap .mCustomScrollBox').css('overflow', 'hidden');
                    jQuery('.sidebar-inner-menu-wrap .mCSB_container').css('overflow', 'hidden');
                    jQuery('.menu__list').removeClass('menu-active');
                }
            }


            if(jQuery(".lp-custom-select").hasClass('lp-custom-select-active')) {
                if (jQuery(target).parents('.lp-custom-select').length > 0 || jQuery(target).hasClass('lp-custom-select__opener') == true) {
                }
                else {
                    jQuery('.lp-custom-select').removeClass('lp-custom-select-active');
                }
            }

            // profile menu outside click
            // if(jQuery(".account-setting__info").hasClass('open')) {
            //     if (jQuery(target).parents('.account-setting__info').length > 0) { }
            //     else{
            //         jQuery('.settings__dropdown').slideUp(400, function () {
            //             jQuery('.account-setting__info').removeClass('open');
            //         });
            //     }
            // }
        });
    },

    /*
    * outsideHover close all dropdowns
    * */

    outsideHover: function () {
        jQuery('.account-setting').mouseleave(function() {
            jQuery(this).find('.settings__dropdown').attr('style', '');
            jQuery(this).removeClass('open');
        });
    },

    /*
    * options-menu Function
    * */
    OptionMenu: function() {
        // jQuery('.options-submenu').click(function (e) {
        //     e.preventDefault();
        //     if(jQuery(this).parent().hasClass('open')) {
        //         jQuery(this).parent().removeClass('open');
        //         jQuery(this).next().slideUp();
        //     } else {
        //         jQuery('.options-submenu').parent().removeClass('open');
        //         jQuery('.options-submenu').next().slideUp();
        //         jQuery(this).parent().addClass('open');
        //         jQuery(this).next().slideDown();
        //     }
        // });
    },

    /*
    * options-Submenu Function
    * */
    OptionSubMenu: function() {
        jQuery('.submenu-link').click(function (e) {
            e.preventDefault();
            if(jQuery(this).parent().hasClass('open')) {
                jQuery(this).parent().removeClass('open');
                jQuery(this).next().slideUp();
            } else {
                jQuery('.submenu-link').parent().removeClass('open');
                jQuery('.submenu-link').next().slideUp();
                jQuery(this).parent().addClass('open');
                jQuery(this).next().slideDown();
            }
        });
    },

    /*
    * slider Function
    * */

    headerRangeSlider: function () {
        $('.ex1').bootstrapSlider({
            formatter: function(value) {
                // $('#defaultSize').val(value);
                $(".button-pop").css('font-size', value);
                return   value +'%';
            },
            min: 75,
            max: 100,
            step: 1,
            value: 75,
            tooltip: 'hide',
            tooltip_position:'bottom',
        }).on("slide", function(slideEvt) {
            $(".ex1SliderVal").text(slideEvt.value+'%');
            $('.scaling-viewport').css('transform','scale('+slideEvt.value/100+')');
        });
    },

    /*
    * funnel block toggle Function
    * */

    funnelToggle: function (){
        $(document).on('click', '.funnels-box, .funnels-details__options .title', function (e) {
            var $toggle_elem = $(this).parents('.funnels-details');
            var funnel_id = jQuery($toggle_elem).attr('id');
            if(!jQuery($toggle_elem).hasClass('disable_lite_package')) {
                $(".dashboard-funnels .funnels-details").removeClass('active');
                $toggle_elem.toggleClass('open active');
                $toggle_elem.find('.funnels-details-wrap').stop().slideToggle();
                /*$toggle_elem.find('.funnel-head').slideToggle();*/
                getLeadsGraph(funnel_id);
                //comment from @mzac90
                // fitTextLeads(funnel_id);
            }

            var status = $("#" + funnel_id + " .funnel-head .funnel-status").data('status');
            if(jQuery($toggle_elem).hasClass('open')) {
                if (status) {
                    $("#" + funnel_id + " .funnel-head .funnel-status").addClass('d-none');
                } else {
                    $("#" + funnel_id + " .funnel-head .funnel-status").removeClass('d-none');
                }
            }
            // setTimeout(function(){
            //
            // }, 1000);
            // $toggle_elem.find('.funnels-details__box-wrapper').toggle();
            // $toggle_elem.find('.funnels-details__options').toggle(function () {
            //     var $offset = $('.funnels-block__title_tag').parent().offset();
            //     $('.funnels-box__tags').parent().offset({left: $offset.left});
            // });
        });
    },

    /*
    * funnel tag offsets
    * */
    funnelOffset: function(){
        if (site.route == 'dashboard') {
            var $offset = $('.funnels-block__title_tag').parent().offset();
            $('.funnels-box__tags').parent().offset({left: $offset.left});
        }
    },

    //*
    // ** Tooltip
    // *

    globalTooltip: function (){
        $('.el-tooltip').tooltipster({
            contentAsHTML:true,
            debug:false
        });

        $('.menu-tooltip').tooltipster({
            contentAsHTML:true,
            delay: 50,
            debug:false
        });

        $('.el-button-tooltip').tooltipster({
            contentAsHTML:true,
            delay: 0,
            speed: 50,
            debug:false
        });
    },

    //*
    // ** hex to rgb
    // *

    hexToRgb: function (hex){
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    },

    /**
     *
     * rgb color convert into hex color
     * @param rgb
     * @returns {string}
     */

    rgbToHex:function(rgb) {
        //rgb to hex
       var result = /^(\s*[012]?[0-9]{1,2}\s*,\s*[012]?[0-9]{1,2}\s*,\s*[012]?[0-9]{1,2}\s*)$/i.test(rgb);
       if(result){
        let arrayList = rgb.split(',');
        let r = parseInt(arrayList[0]);
        let g = parseInt(arrayList[1]);
        let b = parseInt(arrayList[2]);
           rgb = "#" + lpUtilities.componentToHex(r) + lpUtilities.componentToHex(g) + lpUtilities.componentToHex(b);
       }
       else{
           rgb = null;
       }
       return rgb;
    },

    // converts rgb to rgba using opacity
    rgbToRgba:function(rgbString, opacity ){
        rgbString = rgbString.replace(/[^\d,]/g, '').split(',');
        rgbString[3]=opacity;
        return "rgba( "+rgbString.join(', ')+" )";
    },

    /**
     * convert hex color code
     * @param c
     * @returns {string|string}
     */
    componentToHex: function (c) {
        var hex = c.toString(16);
        return hex.length == 1 ? "0" + hex : hex;
    },

    //*
    // ** set color picker code
    // *

    set_colorpicker_box: function (box_name,hex_code){
        console.log($(box_name).find('.color-box__r').children('.color-box__rgb'));
        $(box_name).find('.color-box__r').children('.color-box__rgb').val(lpUtilities.hexToRgb(hex_code).r);
        $(box_name).find('.color-box__g').children('.color-box__rgb').val(lpUtilities.hexToRgb(hex_code).g);
        $(box_name).find('.color-box__b').children('.color-box__rgb').val(lpUtilities.hexToRgb(hex_code).b);
        $(box_name).find('.color-box__hex-block').val(hex_code);
    },

    //*
    // ** color picker global function
    // *

    custom_color_picker: function (elm){
        event.stopPropagation();
        $elm = elm;
        $elem_this = this;
        select_button = $(this).offset();
        pos_top = select_button.top;
        pos_left = select_button.left;
        var color_picker_block = $('.color-box__panel-wrapper');

        if($(elm).find('.color-picker-options').val() == 1){
            $(color_picker_elm).parents().find('.color-pull-block').hide();
            $(color_picker_elm).parents().find('.color-picker-block').show();
        }else {
            $(color_picker_elm).parents().find('.color-picker-block').hide();
            $(color_picker_elm).parents().find('.color-pull-block').show();
        }

        color_picker_elm = $('.color-box__panel-wrapper'+ elm +'');
        color_picker_block_height = $(color_picker_elm).outerHeight();
        rtl = pos_left + $(this).outerWidth() -330;
        // var not_this = $(color_picker_elm);
        // $(color_picker_block).not(not_this).fadeOut();
        // $(color_picker_elm).fadeToggle();

        $(color_picker_elm).css('opacity','0');
        if($(color_picker_elm).is(':visible')) {
            $(color_picker_elm).fadeOut(function () {
                $('.last-selected').removeClass('up down');
            });
        }else {
            $('.color-box__panel-wrapper').fadeOut(function () {
                $('.last-selected').removeClass('up down');
            });
            $(color_picker_elm).fadeIn(function () {
                lpUtilities.custom_color_pos(pos_top, color_picker_elm, color_picker_block_height, rtl);
                $(color_picker_elm).css('opacity','1');
            });
        }
    },

    //*
    // ** color picker positioning
    // *

    custom_color_pos: function (pos_top, color_picker_elm, color_picker_block_height, rtl){

        var scrollHeight = Math.max(
            document.body.scrollHeight, document.documentElement.scrollHeight,
            document.body.offsetHeight, document.documentElement.offsetHeight,
            document.body.clientHeight, document.documentElement.clientHeight
        );
        // console.info($elem_this);
        // console.info($($elem_this));
        // $($elem_this).addClass('open');
        $('.last-selected').removeClass('up down');
        if(pos_top > color_picker_block_height){
            if(scrollHeight - pos_top > color_picker_block_height + 50) {
                $($elem_this).removeClass('up');
                $($elem_this).addClass('down');
                $(color_picker_elm).offset({top:pos_top+48, left: rtl });
            }else {
                $($elem_this).removeClass('down');
                $($elem_this).addClass('up');
                $(color_picker_elm).offset({top:pos_top - color_picker_block_height + 2, left: rtl });
            }
        }else {
            $($elem_this).removeClass('up');
            $($elem_this).addClass('down');
            $(color_picker_elm).offset({top:pos_top+48, left: rtl });
        }
    },

    //*
    // ** color picker dropdown
    // *

    color_picker_dropdown: function () {
        $('.color-picker-options').select2({
            width: '100%',
            // containerCssClass: "error",
            // dropdownCssClass: "colorpicker__",
            minimumResultsForSearch: -1,
        }).addClass("error");
        $('.color-picker-options').on('change', function () {
            var $this = $(this).val();
            if($this == 1){
                lpUtilities.custom_color_pos(pos_top, $elm, 529, rtl);
                $(color_picker_elm).parents().find('.color-pull-block').hide();
                $(color_picker_elm).parents().find('.color-picker-block').show();
            }else {
                lpUtilities.custom_color_pos(pos_top, $elm, 254, rtl);
                $(color_picker_elm).parents().find('.color-picker-block').hide();
                $(color_picker_elm).parents().find('.color-pull-block').show();

            }
        });
    },

    //*
    // ** Nice Scroll
    // *

    niceScroll:function () {
        $(".select2js__nice-scroll").click(function () {
            $('.select2-results__options').niceScroll({
                cursorcolor:"#fff",
                cursorwidth: "10px",
                autohidemode: false,
                smoothscroll: false,
                scrollspeed: 10,
                railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
                cursorborder: "1px solid #02abec",
            });
        });
    },

    //*
    // ** scroll Scroll
    // *

    scrollmenu: function () {
        if(jQuery(".sidebar-inner-wrap").length > 0) {
            jQuery(".sidebar-inner-wrap").mCustomScrollbar({
                axis: "y",
                autoExpandScrollbar: true,
                autoHideScrollbar: true,
                mouseWheel: {
                    scrollAmount: 100
                },
            });
        }
        if(jQuery(".sidebar-inner-menu-wrap").length > 0) {
            jQuery(".sidebar-inner-menu-wrap").mCustomScrollbar({
                axis: "y",
                autoExpandScrollbar: true,
                autoHideScrollbar: true,
                mouseWheel: {
                    scrollAmount: 100
                },
            });
        }
    },

    /*
    * delete funnel global setting
    * */

    deleteGlobalFunnel: function () {
        $(document).on('click' , '.del-funnel', function(){
            $(this).parents('li').find('.funnel__name').slideUp();
            $(this).parents('li').find('.funnel__action').slideDown();
        });
    },

    /*
    * confirmation no delete funnel setting
    * */

    deleteNoGlobalFunnel: function () {
        $(document).on('click' , '.control__item .no', function(){
            $(this).parents('li').find('.funnel__action').slideUp();
            $(this).parents('li').find('.funnel__name').slideDown();
        });
    },


    /*
    * confirmation no delete funnel setting
    * */

    deleteYesGlobalFunnel: function () {
        $(document).on('click' , '.control__item .yes', function(){
            $(this).parents('li').slideUp(function () {
                $(this).remove();
                lpUtilities.lenght_checker();
            });
        });
    },

    /*
    * scrollbar funnel setting
    * */

    scrollbarFunnelSetting: function () {

        $('.quick-scroll').mCustomScrollbar({
            scrollInertia: 0,
            live: true,
            callbacks:{
                onScrollStart:function(){
                    if($(this).parents('.clone-new-tag')) {
                        $(".clone-tag-drop-down").select2('close');
                    }
                },
                onScroll:function(){
                    jQuery('.modal-tags-popup-wrap').fadeOut();
                    jQuery('.confirm-modal-tags-popup-wrap').fadeOut();
                    jQuery('.inte-modal-tags-popup-wrap').fadeOut();
                }
            }
        });

        $(document).on("click","#global-setting-funnel-list-pop .funnels__header .btn",function (){
            $('.scroll-holder').mCustomScrollbar({
                scrollInertia: 0,
                live: true,
                callbacks:{
                    onScroll:function(){
                        jQuery('.modal-tags-popup-wrap').fadeOut();
                    }
                }
            });
        });

        $(document).on("click","#global-confirmation-pop .funnels__header .btn",function (){
            $('.scroll-holder').mCustomScrollbar({
                scrollInertia: 0,
                live: true,
                callbacks:{
                    onScroll:function(){
                        jQuery('.confirm-modal-tags-popup-wrap').fadeOut();
                    }
                }
            });

        });
    },

    /*
    * global modal funnel show/hide
    * */

    globalFunnelModal: function () {
        $('#global-funnel-list').click(function () {
            $('#global-setting-placeholder-pop').modal('hide');
            $('#global-setting-funnel-list-pop').modal('show');
        });
    },

    /*
    * show modal callback
    * */

    showModalCallback: function () {
        $(document).on('shown.bs.modal', '.modal', function (event) {
            // added by M.A
            lpUtilities.scrollArea();
            lpUtilities.globalTooltip();
            $('body').addClass('modal-open');
            // jQuery('body').css('padding-right', '0');
            var headerHeight = $(this).find('.modal-header').outerHeight();
            var footerHeight = $(this).find('.modal-footer').outerHeight();
            var totalHeight = (headerHeight + footerHeight + 88) + 'px';
            $(this).find('.modal-body').css( {'max-height': 'calc(100vh - ' + totalHeight +')' } );
            if($(".quick-scroll").length > 0) {
                $(".quick-scroll").mCustomScrollbar("update");
            }
            if($(".ip-quick-scroll-wrap").length > 0) {
                $(".ip-quick-scroll-wrap").mCustomScrollbar("update");
            }
            if($(".instrucation-body-scroll").length > 0) {
                $(".instrucation-body-scroll").mCustomScrollbar("update");
            }
        });
    },

    scrollResizing: function () {
        lpUtilities.scrollArea();
        $('.quick-scroll, .pixel-quick-scroll,.folder-listing').mCustomScrollbar('update');
        $('.ip-quick-scroll-wrap').mCustomScrollbar('update');
        $('.left_column_scrollbar').mCustomScrollbar('update');
        $('.right-section').mCustomScrollbar('update');
        $(".instrucation-body-scroll").mCustomScrollbar("update");
        console.log('resized');
    },


    /*
    * hide modal callback
    * */
    /* Abubakar change this function */
    hideModalCallback: function () {
        $(window).on('hidden.bs.modal', function() {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
                jQuery('body').css('overflow', 'hidden');
            }
            else {
                $('body').removeClass('modal-open');
                jQuery('body').css('overflow', 'visible');
            }
        });
    },


    /*
    * funnel check length
    * */

    lenght_checker: function () {
        if ($('.gl-funnel__body li').length <= 0) {
            $('.gl-funnel').slideUp();
            $('.funnel__list-placeholder').slideDown();
            $('.pop-create-funnel').hide();
            $('#btn-save').hide();
        }else {
            $('.pop-create-funnel').show();
            $('.gl-funnel').slideDown();
            $('.funnel__list-placeholder').slideUp();
            $('#btn-save').show();
        }
    },


    /*
    * Below function should not be in the back end code. This is already initialized in the global_modal.js
    * */

    /*
    * global setting modal select2js
    * */

    // globalModalSelectFunnel: function () {
    //     $('#funnel-search__by').select2({
    //         width: '100%',
    //         minimumResultsForSearch: -1,
    //         dropdownParent: $('.funnel-search__category')
    //     }).on('change',function () {
    //         $(".zapier-funnel-name-search").val('');
    //         $(".tag-result-pop .select2-selection__choice").remove();
    //         $('.tag-result-pop .select2-container .select2-search--inline .select2-search__field').attr('placeholder', 'Type in Funnel Tag(s)...');
    //
    //         if ($(this).val() == '1') {
    //             $('.funnel-search__input-tag').hide();
    //             $('.funnel-search__input-name').show();
    //         }else {
    //             $('.funnel-search__input-name').hide();
    //             $('.funnel-search__input-tag').show();
    //         }
    //     });
    // },


    /*
    * funnel tag(s) select2js
    * */

    initSelect2:function (selecter,parent) {
        var dropdown =  $(selecter).select2({
            width: '100%',
            placeholder: 'Type in Funnel Tag(s)...',
            dropdownParent: $(parent),
            selectionAdapter: $.fn.select2.amd.require("CustomSelectionAdapter"),
            templateResult: function (data, container) {
                if (data.element) {
                    $(container).addClass('za-tag-list');
                }
                var $result = $("<span></span>");

                $result.text(data.text);
                return $result;
            },
            matcher: function (params, data) {
                $('.dashboard-tag-result .za-tag-custom .select2-results__options').getNiceScroll().hide();
                return lpUtilities.matchStart(params, data);
            },
            sorter: function(data){
                return data.sort(function (a,b){
                    return a.text.localeCompare(b.text)
                })
            },
            language:{
                    noResults: function() {
                        if($.inArray(parent,['.tag-result','.clone-new-tag']) != -1) {
                            var term = $(parent).find("input[type='search']").val();
                            return $(" <a href='#' class='add-tag' data-parent='"+parentClass+"' data-tag='" + term + "'>Create new tag <b>" + term + "</b></a><span class='result-text'>No results found</span>");
                        }
                        else if($.inArray(parent,['.funnel-tag-result']) != -1) {
                            return '';
                        }
                        return "No results found";
                    }
                },
            escapeMarkup: function(markup) {
                return markup;
            }
        });

        dropdown.on("select2:open", function () {
            selector = '';
            parentClass = parent.replace(/[#.]/g,'');
            $(`.${parentClass} .select2-dropdown`).addClass('za-tag-custom za-tag-dropdown-modifier');
            $(".select2-search.select2-search--inline .select2-search__field").addClass('za-tag-dropdown-modifier').css('border-radius', '3px 3px 0 0');
            $('.lp-tag .clone-tag-result .select2-container .select2-search--inline .select2-search__field').attr('placeholder', '');
            if(niceScrollHide === false && parentClass === "dashboard-tag-result") {
                tagScroll();
            }
            else{
                tagScroll();
            }
            if($.inArray( parentClass,['clone-new-tag','funnel-tag-result']) != -1) {
                $(`.${parentClass}`).parents('.modal').addClass('tag-dropdown-active');
            }
            $(parent).find('.select2-search__field').removeClass('select2-remove-focus');
        });

        dropdown.on("select2:close", function () {
            lpUtilities.select2jsPlaceholder();
            $("#tag_list-error").remove();
            $(`.${parentClass}`).parents('.modal').removeClass('tag-dropdown-active');

        });

        dropdown.on('select2:select', function (e) {
            if($.inArray( parentClass,['tag-result','clone-new-tag','funnel-tag-result']) != -1) {
               tagManage(parentClass);
            }
            var self = this
            var element = e.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
            setTimeout(function (){
                $($(parent).find(".select2-search__field")[0]).focus();
                lpUtilities.select2jsPlaceholder();
            },100);
            requestAnimationFrame(function () {
                var $parents = $(self).parents('.lp-tag-scroll, .lp-tag-scroll > .mCustomScrollBox');
                $parents.scrollTop(0)
            });
            $(parent).find('.select2-search__field').removeClass('select2-remove-focus');
        });

        dropdown.on('select2:unselecting', function (e) {
            dropdown.on('select2:opening', function (e) {
                e.preventDefault();
                dropdown.off('select2:opening');
            });
        });
        dropdown.on('select2:unselect', function (e) {
            parentClass = parent.replace(/[#.]/g,'');
            if(jQuery(e.target.offsetParent).hasClass('dashboard-tag-result')) {
                if (site.route == 'dashboard') {
                    var selectedTag = $(".dashboard-tag-result .select2-selection__choice").length;
                    var tagSearch = $(".dashboard-tag-result .select2-search__field").val();
                    if(selectedTag === 0 && tagSearch === "") {
                        _search();
                    }
                }
            }
            if($.inArray( parentClass,['tag-result','clone-new-tag','funnel-tag-result']) != -1) {
                $(parent).find('.select2-search__field').addClass('select2-remove-focus');
                var tag = '';
                tagManage(parentClass);
                lpUtilities.tag_drop_down_list(render,2);
            }
            setTimeout(function (){
                $(parent).find(".select2-search__field").focus();
                lpUtilities.select2jsPlaceholder();
            },100);
        });
        if(parent == '.tag-result') {
            lpUtilities.setSelectDropDownPosition();
        }
    },


    tagFilterPositionInit: function(){
        $('#dashboard_tag_list').on('change', this.calculateTopTagSearchPosition.bind(this))
        $(window).on('resize', this.debounce(this.calculateTopTagSearchPosition.bind(this), 250))
    },

    /**
     * It calculates tag search bar content width and adds/removes classes based
     * on that to position it.
     *
     * To optimize the function, minimum number of calculations have been performed
     * which depend on current CSS styling of tag search bar, so if styling for
     * search bar is changed, this function and its companion functions called
     * from within may need to be adjusted
     */
    calculateTopTagSearchPosition: function(){
        var $searchBar = $('.search-bar-slide .search-bar__filter');
        if(!$searchBar.length){
            return
        }
        var $searchBarRow = $searchBar.find('.row');
        var searchBarWidth = $searchBar.width();

        var self = this

        var $tagSearchColumn = $searchBar.find('.search-bar__column.funnel-tag-search');
        var $tagSeachBox = $tagSearchColumn.find('.select2-selection__rendered');

        if(!$tagSeachBox.length){
            return
        }

        var calculationAllowence = 10;

        var columnHorizontalPadding = this.calculateHorizontalPadding($tagSearchColumn);
        var searchHorizontalPadding = this.calculateHorizontalPadding($tagSeachBox);

        $searchBarRow.hide()
        var dropdownsWidth = 0;
        $searchBar.find('.funnel-type, .funnel-category, .funnel-tag').each(function(){
            var width = self.getElementCssWidthInPixels(this, searchBarWidth)
            dropdownsWidth += width + columnHorizontalPadding
        })
        $searchBarRow.show()

        var allTagsWidth = 0;
        $tagSeachBox.find('> li').each(function (){
            allTagsWidth += $(this).outerWidth()
        })

        var allChildWidths = dropdownsWidth + allTagsWidth + searchHorizontalPadding + calculationAllowence

        if(searchBarWidth < allChildWidths){
            $searchBarRow.addClass('col-equal')
        } else {
            $searchBarRow.removeClass('col-equal')
        }
    },

    calculateHorizontalPadding: function(element) {
        var $element = $(element)
        var leftPadding = $element.css('padding-left')
        var rightPadding = $element.css('padding-right')
        return parseFloat(leftPadding) + parseFloat(rightPadding)
    },

    getElementCssWidthInPixels: function(element, parentWidth) {
        var width = $(element).css('width');
        if(width.match(/\%$/)){
            width = parentWidth * parseFloat(width) / 100
        }

        width = parseFloat(width)
        return width
    },

    debounce: function (func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            }, wait);
            if (immediate && !timeout) func.apply(context, args);
        };
    },

    /*
    * funnel tag(s) select2js start match
    * */

    matchStart: function (params, data) {
        params.term = params.term || '';
        //debugger;

        if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
            return data;
        }

        return null;
    },

    /*
    * funnel tag(s) select2js dropdown positions
    * */

    dropdownpos: function (ele) {
        if($.inArray( ele,['clone-new-tag','funnel-tag-result']) != -1) {
            var $cloneTag = $('.'+ele);
            var $searchField = $cloneTag.find('.select2js__tags-parent .select2-search__field');
            if(selector){
                var $searchField = $cloneTag.find('.funnel_select2js__folder-parent .select2-search__field');
            }
            var $dropdown = $cloneTag.find('.select2-container--open:not(.select2)');

            if(!$searchField.length || !$dropdown.length){
                return;
            }

            var searchFieldHeight = $searchField.innerHeight();
            var searchFieldOffset = $searchField[0].getBoundingClientRect();
            var modalOffset = $dropdown.parent()[0].getBoundingClientRect();
            $dropdown.css({
                top: searchFieldOffset.top + searchFieldHeight - modalOffset.top,
                left: searchFieldOffset.left - modalOffset.left - 1
            });
            if(ele === 'funnel-tag-result' && $(".funnel-empty-tag-list").length === 0) {
                console.log("JAZ >>>>>>>>>> ");
                //$(".select2-results__options").append('<li role="alert" aria-live="assertive" class="select2-results__option select2-results__message funnel-empty-tag-list"><span class="result-text">No results found</span><div class="add-tag-wrap"><a href="#" class="add-tag" data-parent="funnel-tag-result" data-tag=""><i class="ico ico-plus"></i><span class="create-new-tag-text">Create new tag</span> <span class="tag-item"><i class="ico ico-tag"></i><span class="terms"></span></span></a></div></li>');
            }
        }
        else {
            $(".za-tag-custom").parent().css({
                top: $("." + ele + " .select2-search--inline")[0].offsetTop + $("." + ele + " .select2-search--inline")[0].offsetHeight - 4,
                left: $("." + ele + " .select2-search__field")[0].parentNode.offsetLeft + 1
            });
        }
    },


    /*
    * funnel tag(s) placeholder
    *
    .tag-result-common remove class in placeholder from @mzac90
     */
    select2jsPlaceholder: function () {
        if(selector == '') {
            $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').show();
            if ($(".lp-tag .select2-container ul li").hasClass('select2-selection__choice') == false) {
                placeholder = 'Type in Funnel Tag(ssssssss)...';
            } else {
                placeholder = 'Add another tag';
            }
            $('.lp-tag .select2-container .select2-search--inline .select2-search__field').attr('placeholder', placeholder);
        }
        $('.funnel_select2js__folder-parent .select2-container .select2-search--inline .select2-search__field').attr('placeholder', 'Type in Funnel Folder...');
    },

    /*
    * funnel tag(s) select2js add funnels
    * */

    addFunnelTags: function () {
        $.fn.select2.amd.define("CustomSelectionAdapter", [
                "select2/utils",
                "select2/selection/multiple",
                "select2/selection/placeholder",
                "select2/selection/eventRelay",
                "select2/selection/search",
            ],
            function(Utils, MultipleSelection, Placeholder,EventRelay,SelectionSearch) {

                var adapter = Utils.Decorate(MultipleSelection, Placeholder);
                adapter = Utils.Decorate(adapter, SelectionSearch);
                adapter = Utils.Decorate(adapter, EventRelay);

                adapter.prototype.update = function(data) {
                    this.clear();
                    if (data.length === 0) {

                        this.$selection.find('.select2-selection__rendered')
                            .append(this.$searchContainer);
                        return;
                    }

                    var $selections = [];
                    var selected_tag_list = jQuery(".tag-result").data('tags');

                    for (var d = 0; d < data.length; d++) {
                        var selection = data[d];
                        var $selection = this.selectionContainer();
                        if ($('[name="global_mode_bar"]').is(':checked')) {
                            jQuery(selected_tag_list).each(function (k, v) {
                                if(selection.id.indexOf('new_') === -1) {
                                    if (selection.id == v) {
                                        $selection.addClass('tags-disabled');
                                        $(".tags-disabled .select2-selection__choice__remove").hide();
                                    }
                                }
                            });
                        }
                        else{
                            $(".tags-disabled .select2-selection__choice__remove").hide();
                        }
                        var formatted = this.display(selection, $selection);
                        $selection.append(formatted);
                        $selection.prop('title', selection.title || selection.text);
                        $selection.data('data', selection);
                        $selections.push($selection);
                    }
                    var $rendered = this.$selection.find('.select2-selection__rendered');
                    Utils.appendMany($rendered, $selections);
                    var searchHadFocus = this.$search[0] == document.activeElement;
                    this.$search.attr('placeholder', '');
                    this.$selection.find('.select2-selection__rendered')
                        .append(this.$searchContainer);
                    this.resizeSearch();
                    if (searchHadFocus) {
                        this.$search.focus();
                    }
                };

                return adapter;
            });
        // select init for get the drop down position
        var Defaults = $.fn.select2.amd.require('select2/defaults');
        $.extend(Defaults.defaults, {
            dropdownPosition: 'auto'
        });






        var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');
        AttachBody.prototype._positionDropdown = function() {
            var $offsetParent = this.$dropdownParent;
            if($offsetParent.hasClass(parentClass)) {
                    $('.tag-result-common .select2-selection__choice').mouseenter(function () {
                        lpUtilities.dropdownpos(parentClass);
                        $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').hide();
                    });
                    $('.tag-result-common .select2-selection__choice').mouseleave(function () {
                        $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').show();
                        lpUtilities.dropdownpos(parentClass);
                        lpUtilities.select2jsPlaceholder();
                    });
                    $('.tag-result-common .select2-search__field').blur(function () {
                        lpUtilities.dropdownpos(parentClass);

                        lpUtilities.select2jsPlaceholder();
                    });
                lpUtilities.dropdownpos(parentClass);
            }
            else{
                var $window = $(window);
                var isCurrentlyAbove = this.$dropdown.hasClass('select2-dropdown--above');
                var isCurrentlyBelow = this.$dropdown.hasClass('select2-dropdown--below');

                var newDirection = null;

                var offset = this.$container.offset();

                offset.bottom = offset.top + this.$container.outerHeight(false);

                var container = {
                    height: this.$container.outerHeight(false)
                };

                container.top = offset.top;
                container.bottom = offset.top + container.height;

                var dropdown = {
                    height: this.$dropdown.outerHeight(false)
                };

                var viewport = {
                    top: $window.scrollTop(),
                    bottom: $window.scrollTop() + $window.height()
                };

                var enoughRoomAbove = viewport.top < (offset.top - dropdown.height);
                var enoughRoomBelow = viewport.bottom > (offset.bottom + dropdown.height);

                var css = {
                    left: offset.left,
                    top: container.bottom
                };

                // Determine what the parent element is to use for calciulating the offset
                // For statically positoned elements, we need to get the element
                // that is determining the offset
                if ($offsetParent.css('position') === 'static') {
                    $offsetParent = $offsetParent.offsetParent();
                }

                var parentOffset = $offsetParent.offset();

                css.top -= parentOffset.top
                css.left -= parentOffset.left;
                var dropdownPositionOption = this.options.get('dropdownPosition');

                if (dropdownPositionOption === 'above' || dropdownPositionOption === 'below') {

                    newDirection = dropdownPositionOption;

                } else {

                    if (!isCurrentlyAbove && !isCurrentlyBelow) {
                        newDirection = 'below';
                    }

                    if (!enoughRoomBelow && enoughRoomAbove && !isCurrentlyAbove) {
                        newDirection = 'above';
                    } else if (!enoughRoomAbove && enoughRoomBelow && isCurrentlyAbove) {
                        newDirection = 'below';
                    }

                }

                if (newDirection == 'above' ||
                    (isCurrentlyAbove && newDirection !== 'below')) {
                    css.top = container.top - parentOffset.top - dropdown.height;
                }

                if (newDirection != null) {
                    this.$dropdown
                        .removeClass('select2-dropdown--below select2-dropdown--above')
                        .addClass('select2-dropdown--' + newDirection);
                    this.$container
                        .removeClass('select2-container--below select2-container--above')
                        .addClass('select2-container--' + newDirection);
                }
                this.$dropdownContainer.css(css);
            }
        };
        if(parentClass == 'tag-result') {
            AttachBody.prototype._resizeDropdown = function (decorated) {
                lpUtilities.setSelectDropDownPosition();
            };
        }
    },


    /*
    * funnel tag(s) loop
    * */


    funneltagsloop: function () {
        var taglist = lpUtilities.lp_tag_list;
        for(var i = 0; i < taglist.length; i++){
            lpUtilities.initSelect2(taglist[i].selecter,taglist[i].parent);
        }
    },

    /*
    * modal dropdowns
    * */

    cloneModalDropdowns: function () {
        var amIclosing = false;

        $('#topleveldomain').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select2js__lvl-domain-parent')
        }).on('select2:opening', function() {

        }).on('select2:open', function() {
            jQuery('.select2js__lvl-domain-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.select2js__lvl-domain-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2js__lvl-domain-parent .select2-dropdown').hide();
            jQuery('.select2js__lvl-domain-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.select2js__lvl-domain-parent .select2-selection__rendered').hide();
            lpUtilities.niceScroll();

            setTimeout(function () {
                jQuery('.select2js__lvl-domain-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                    var getindex = jQuery('#topleveldomain').find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight - 50;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);

            $('#modal_SubdomainCloneFunnel').removeClass('tag-dropdown-active')

        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2js__lvl-domain-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#topleveldomain').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.select2js__lvl-domain-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.select2js__lvl-domain-parent .select2-selection__rendered').show();
            jQuery('.select2js__lvl-domain-parent .select2-results__options').css('pointer-events', 'none');
        });



        /**
         * @mzac90
         * select2 work for create new funnel modal and clone
         * we will use this function for signle select2 drop down in future
         */

        var selectList = lpUtilities.lpSelect2List;
        let parentElement = '';
        for(var i = 0; i < selectList.length; i++){
            let selecter = selectList[i].selecter;
            let selecterParent = selectList[i].parent;
            $(selecter).select2({
                minimumResultsForSearch: -1,
                width: '100%', // need to override the changed default
                dropdownParent: $(selecterParent)
            }).on('select2:open', function() {
                parentElement = jQuery(this).parents(selecterParent);
                parentElement.find('.select2-results__options').css('pointer-events', 'none');
                setTimeout(function() {
                    parentElement.find('.select2-results__options').css('pointer-events', 'auto');
                }, 300);
                parentElement.find('.select2-dropdown').hide();
                parentElement.find('.select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
                parentElement.find('.select2-selection__rendered').hide();
                lpUtilities.niceScroll();
                setTimeout(function () {
                    parentElement.find('.nicescroll-rails-vr').each(function () {
                        var getindex = jQuery(selecter).find(':selected').index();
                        var defaultHeight = 44;
                        var scrolledArea = getindex * defaultHeight - 50;
                        $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                        this.style.setProperty( 'opacity', '1', 'important' );
                    });
                }, 400);

            }).on('select2:closing', function(e) {
                if(!amIclosing) {
                    e.preventDefault();
                    amIclosing = true;
                    parentElement.find('.select2-dropdown').attr('style', '');
                    setTimeout(function () {
                        jQuery(selecter).select2("close");
                    }, 200);
                } else {
                    amIclosing = false;
                }
                parentElement.find('.nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '0', 'important' );
                });
            }).on('select2:close', function() {
                parentElement.find('.select2-selection__rendered').show();
                parentElement.find('.select2-results__options').css('pointer-events', 'none');
            });
        }
    },

    /*
    * scroll area
    * */

    scrollArea: function () {
        if(jQuery(".quick-scroll").length > 0) {
            jQuery(".quick-scroll").mCustomScrollbar({
                axis: "y",
                autoExpandScrollbar: true,
                autoHideScrollbar: false,
                mouseWheel: {
                    scrollAmount: 100
                }
            });
        }
        if(jQuery(".left_column_scrollbar").length > 0) {
            jQuery(".left_column_scrollbar").mCustomScrollbar({
                axis: "y",
            });
        }
        if(jQuery(".right-section").length > 0) {
            jQuery(".right-section").mCustomScrollbar({
                axis: "y",
            });
        }

        if(jQuery(".instrucation-body-scroll").length > 0) {
            jQuery(".instrucation-body-scroll").mCustomScrollbar({
                axis: "y",
            });
        }
    },

    /*
    * Global settings toggle
    * */

    globalSettingToggle: function () {
        $('[name="global_mode_bar"]').change(function(){
            if ($(this).is(':checked')) {
                $(this).parents('#wrapper').find('.global').removeClass('global_mode-off');
                $(this).parents('#wrapper').find('.global').addClass('global_mode-on');
                $(this).parents().find('.global__bar p').text("GLOBAL SETTINGS MODE IS ON");
            }else {
                $(this).parents('#wrapper').find('.global').removeClass('global_mode-on');
                $(this).parents('#wrapper').find('.global').addClass('global_mode-off');
                $(this).parents().find('.global__bar p').text("GLOBAL SETTINGS MODE IS OFF");
            }
        });
    },

    /*
    * submit support request
    * */

    requestForm : function() {
        $.validator.addMethod("no_space", function (value, element, regexpr) {
            return $.trim( value );
        }, "This field is required.");
        var request_form = $("#lp-support-form");
        request_form.validate({
            rules: {
                maintopic: {
                    required: true
                },
                mainissue: {
                    required: true
                },
                subject: {
                    required: true,
                    no_space:true
                },
                message: {
                    required: true,
                    no_space:true
                }
            },
            messages: {
                maintopic: {
                    required: "Please select category"
                },
                mainissue: {
                    required: "Please select topic"
                },
                subject: {
                    required: "Please enter subject"
                },
                message: {
                    required: "Please enter message"
                }
            },
            errorPlacement: function(error, element) {
                //Custom position: main topic and main issue
                if (element.attr("name") == "maintopic" ) {
                    error.appendTo($(".subject-select-parent01, .global_maintopic-parent"));
                }else if (element.attr("name") == "mainissue" ) {
                    error.appendTo($(".subject-select-parent02, .global_mainissue-parent"));
                }else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                if($(form).find('.button-secondary').attr('id') !== undefined
                    && $(form).find('.button-secondary').attr('id') == 'global_btn-spt-form') {
                    globalSupportTicket.submitTicket();
                }else {
                    form.submit();
                }
            }
        });

        $('#global_maintopic').select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownParent: $(".global_maintopic-parent")
        }).on("select2:select", function () {
            if($(this).val() == ''){
                $(this).parents('.input__holder').find('.error').show();
            }else {
                $(this).parents('.input__holder').find('.error').hide();
            }
        }).on('select2:select', function(){
            $('#global_mainissue').removeAttr('disabled');
        });

        $('#global_mainissue').select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownParent: $(".global_mainissue-parent")
        }).on("select2:select", function () {
            if($(this).val() == ''){
                $(this).parents('.input__holder').find('.error').show();
            }else {
                $(this).parents('.input__holder').find('.error').hide();
            }
        });
    },

    addclassscroll: function() {
        jQuery(window).scroll(function() {
            var scroll = jQuery(window).scrollTop();
            if (scroll >= 50) {
                jQuery("body").addClass("fixed-header");
            } else {
                jQuery("body").removeClass("fixed-header");
            }
        });
    },

    addclasssclick: function() {
        jQuery("#lp-train-module").click(function () {
            jQuery('body').addClass('libaray-open');
        });

        jQuery(".libaray-close").click(function () {
            jQuery('body').removeClass('libaray-open');
        });

        jQuery(".lp-controls__edit").click(function () {
            jQuery(this).parents('.shortUrl').addClass('active');
        });

        jQuery(".cancel-option").click(function () {
            jQuery(this).parents('.shortUrl').removeClass('active');
        });
    },

    addclasshover: function() {
        jQuery(".menu__list_sub-menu").hover(function () {
            jQuery(this).parents('.sidebar-inner').toggleClass('menu-hover');
        });

        jQuery(".lp-controls__link").hover(function () {
            var _self = jQuery(this);
            setTimeout(function () {
                _self.parents('body').toggleClass('tooltip-hover');
            },400);
        });

        jQuery(".stats-trigger").hover(function () {
            var _self = jQuery(this);
            setTimeout(function () {
                _self.parents('body').toggleClass('stats-tooltip-hover');
            },400);
        });

        jQuery(".funnel-name").hover(function () {
            jQuery(this).parents('body').toggleClass('funnel-name-tooltip');
        });

        jQuery('#add_code_submit').hover(function () {
            if (jQuery(this).hasClass('disabled')) {
                jQuery("body").removeClass("code-tooltip-active");
            } else {
                jQuery("body").addClass("code-tooltip-active");
            }
        });

        jQuery('body').on('hover', '.select2-results__option.disbale', function(){
            var _self = jQuery(this);
            setTimeout(function () {
                _self.parents('body').toggleClass('disbale-tooltip-hover');
                _self.parents('body').removeClass('code-tooltip-active');
            },400);
        });

        jQuery(function() {
            var timeoutid = null;
            jQuery('.options-menu__item.view .view-wrap').hover(function() {
                var _self = jQuery(this);
                timeoutid = setTimeout(function (){
                    _self.parents('.options-menu').find('.view-popup-wrap').stop().fadeIn();
                    //lpUtilities.dashboardViewHoverBlock();
                },250);
            }, function() {
                clearTimeout(timeoutid);
                jQuery(this).parents('.options-menu').find('.view-popup-wrap').stop().fadeOut();
            });
        });

        jQuery(function() {
            var timeoutid = null;
            jQuery('.menu__list.view .view-wrap').hover(function() {
                var _self = jQuery(this);
                timeoutid = setTimeout(function (){
                    _self.parents('.menu').find('.view-popup-wrap').stop().fadeIn();
                    lpUtilities.viewhoverblock();
                },250);
            }, function() {
                clearTimeout(timeoutid);
                jQuery(this).parents('.menu').find('.view-popup-wrap').stop().fadeOut();
            });
        });
    },

    addclassfunnel: function() {
        jQuery(".funnels-details__info-name").hover(function () {
            jQuery(this).parents('.funnels-box').toggleClass('funnels-box-hover');
        });
    },

    /*Abubakar added this */
    innerPopup: function() {
        jQuery(".modal [data-toggle='modal']").click(function () {
            jQuery('body').addClass('modal-open');
            jQuery('body').css('overflow', 'hidden');
        });
    },

    /*Abubakar added this to showw popup when we go back from */
    globalPopupopener: function () {
        $("#global-setting-funnel-list-pop [data-toggle='modal']").click(function () {
            jQuery('body').addClass('modal-open video-open');
            jQuery('body').css('overflow', 'hidden');
        });
        $('.lp-global-opener').on('hidden.bs.modal', function () {
            if(jQuery('body').hasClass('video-open')) {
                jQuery('body').css('overflow', 'hidden');
                jQuery('body').addClass('modal-open');
                $('#global-setting-funnel-list-pop').modal('show');
                setTimeout(function () {
                    jQuery('body').removeClass('video-open');
                }, 1000);
            }
        });
    },

    /*
    * search toggle link
    * */
    searchSlideToggle: function () {
        jQuery('.search-trigger').click(function (){
            jQuery('body').toggleClass('hide-seach');
            jQuery('.search-bar-slide').slideToggle();
            jQuery('.search-bar-slide').removeClass('d-none');
            tag_filter_session();
        });
    },

    /*
    * search toggle link
    * */
    statsSlideToggle: function () {
        jQuery('.stats-trigger').click(function (){
            jQuery('body').toggleClass('hide-stats');
            jQuery('.stats-area-slide').slideToggle();
            jQuery('.stats-area-slide').removeClass('d-block');
            if($("body").hasClass('hide-stats')){
                $('.heading-bar__funnels-info.total_funnels,.heading-bar__funnels-info.total-leads').addClass('d-none');
            }
            else{
                $('.heading-bar__funnels-info.total_funnels,.heading-bar__funnels-info.total-leads').removeClass('d-none');
            }
            tag_filter_session();
        });
    },
    //from @mzac09
    //tag drop down list
    tag_drop_down_list: function(ele = 1 , del = 1){
        var opt = render_class = '';
        var selected_list = [];
        //ele = 2 for clone funnel tags list, ele = 3 for create new funnel tag list
        if(ele == 2){
            selected_list = selected_clone_tag_list;
            render_class = '.clone-tag-drop-down';
        }
       else if(ele == 3){
            selected_list = funnel_selected_tag_list;
            render_class = '.create_funnel_tag_list';
        }
        else{
            selected_list = selected_tag_list;
            render_class = '.tag-drop-down';
        }

        var tagsToRender = tag_dropdown;
        // Disabling order on delete
        if(del == 2) {
            var savedSelectedTagsIds = selected_list;

            if (savedSelectedTagsIds && savedSelectedTagsIds.length) {
                var selectedTagsIds = [];

                savedSelectedTagsIds.forEach(function (id) {
                        var index = tag_dropdown.findIndex(tag => tag.id === id)

                        if (index > -1) {
                            selectedTagsIds.push(tag_dropdown[index])
                        }
                });

                tagsToRender = selectedTagsIds;

                tag_dropdown.forEach(function (tag) {
                        if (savedSelectedTagsIds.indexOf(tag.id) < 0) {
                            tagsToRender.push(tag)
                        }
                });
            }
        }
        $(tagsToRender).each(function (index, el) {
            opt += '<option value="'+el.id+'"  '+lpUtilities.isSelected(selected_list,el.id)+'>'+el.tag_name+'</option>';
        });
        $(render_class).html(opt);
    },

    //drop down option selected function
    isSelected: function (v,m){
        var ret = '';
        if(typeof v === 'number') {

            if (v == m) {
                ret = 'selected';
            }
        }else if(typeof v === 'string') {

            if (v == m) {
                ret = 'selected';
            }
        }else{
            if(jQuery.inArray(m, v) !== -1) {
                ret = 'selected';
            }
        }
        return ret;
    },

    /*
    * radio button accordion
    * */
    radioaccortion: function () {
        jQuery('body').on('change', '.background-card input[type="radio"]', function(){
            var _self = jQuery(this);
            jQuery('.background-slide').slideUp();
            jQuery('.background-card').removeClass('active');
            _self.parents('.background-card').addClass('active');
            _self.parents('.background-card').find('.background-slide').slideDown();
        });

        jQuery('body').on('change', '.domain-card input[type="radio"]', function(){
            var _self = jQuery(this);
            jQuery('.domain-slide').slideUp();
            jQuery('.domain-card').removeClass('active');
            _self.parents('.domain-card').addClass('active');
            _self.parents('.domain-card').find('.domain-slide').slideDown();
        });
    },

    cloneFunnelAddClassOnScrollInit: function(){
        var $modal = $('#modal_SubdomainCloneFunnel');
        var $modalBody = $modal.find('.modal-body');
        var $scrollBox = $modalBody.find('.mCustomScrollBox');
        if(!$scrollBox.length){
            return;
        }
        var scrollBox = $scrollBox.get(0);
        var addClassIfHasScroll = function(){
            if(!scrollBox.scrollHeight || !scrollBox.offsetHeight){
                $modalBody.removeClass('modal-has-no-scroll');
            } else if(scrollBox.scrollHeight > scrollBox.offsetHeight + 15){
                $modalBody.removeClass('modal-has-no-scroll');
            } else {
                $modalBody.addClass('modal-has-no-scroll');
            }
        }
        $modal.on('shown.bs.modal hidden.bs.modal', function(){
            addClassIfHasScroll();
            setTimeout(function(){
                addClassIfHasScroll()
            }, 500);
        })

        $(window).resize(addClassIfHasScroll)
    },

    /* function to show animation when copy to clipboard event is called */
    copyToClipboard: function() {
        jQuery('.copy-btn,.funnel-url-copy').click(function (){
            var _self = jQuery(this);
            _self.parents('.copy-btn-area').addClass('active');
            setTimeout(function () {
                _self.parents('.copy-btn-area').removeClass('active');
            }, 1000);
        });
    },

    /* view hover block postion */
    viewhoverblock: function() {
                var windowOffset = $(window).scrollTop();
                var offset = jQuery('.menu__list.view .view-wrap').offset();
                var height = jQuery('.view-popup-wrap').outerHeight();
                jQuery('.view-popup-wrap').css('top', ((offset.top-windowOffset) - height));
    },

    /**
     * dashboard view hover tooltip set position
      */
    dashboardViewHoverBlock: function (){
        var windowOffset = $(window).scrollTop();
        var offset = jQuery('.active .options-menu__item.view .view-wrap').offset();
        var height = jQuery('.active.view-popup-wrap').outerHeight();
        jQuery('.active .view-popup-wrap').css('top', ((offset.top-windowOffset) - height));
    },

    /**
     * select2 dropdown set width accroding to selected tags
     * calculate the width of selected tags and set the dropdown depend on search box remaining width
     */
    setSelectDropDownPosition: function (){
        let searchBoxWidth = 182; //max search box width
        let defaultWidth = 130; //min search box width
        let searchBoxTopOffset = selectedTagsTopOffset = width = remainingWidth = 0; // use value default set 0
        let renderData =  jQuery(".tags-render .select2-selection__rendered");
        let selectedTags = jQuery(renderData).find('li.select2-selection__choice'); // get selected tags list
        let searchBoxli = renderData.find('.select2-search'); // search box li
        if(selectedTags.length){
            selectedTagsTopOffset = selectedTags[0].offsetTop; // getting one selected tag top offset
        }
        if(searchBoxli.length) {
             searchBoxTopOffset = (searchBoxli) ? parseInt(searchBoxli[0].offsetTop) + selectedTagsTopOffset : selectedTagsTopOffset; // getting search box li top offset
        }
        selectedTags.each( function (index,el){
            selectedTagsTopOffset = parseInt(jQuery(el)[0].offsetTop); // getting each tag top offset
            if(searchBoxTopOffset == selectedTagsTopOffset) {
                width += parseFloat(jQuery(el).outerWidth());
            }
        });
        width = parseInt(width);
        let boxWidth = renderData.outerWidth()-searchBoxWidth;
        let element = jQuery(".tags-render .za-tag-custom,.tags-render .za-tag-custom .select2-results__options");
        remainingWidth = parseInt(boxWidth-width);
         if(remainingWidth >= defaultWidth && remainingWidth <= searchBoxWidth){ // if remaining value greater than and less than to min and max value
             remainingWidth = remainingWidth;
        }
         else  if(remainingWidth >= 50 && remainingWidth <= defaultWidth){ //if  remaining value less than to min value
             let newWidth = remainingWidth+(140-(searchBoxWidth-remainingWidth));
             remainingWidth = newWidth;
         }
        else{
            remainingWidth  =  searchBoxWidth; // default search box value
        }
        jQuery('.za-tag-custom,.select2-search__field').removeClass('za-tag-dropdown-modifier'); // remove the css set width
        element.css('width',remainingWidth+'px'); // set new width  of dropdown
        setTimeout(function (){
            renderData.find('.select2-search__field').css('width',remainingWidth+'px'); // set new width search box
        },100);
    },

    /**
     * strip tags
     * @param input
     * @param allowed
     * @returns {*}
     */
    strip_tags: function (input, allowed) {
        allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi
        var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi
        return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : ''
        });
    },


    /**
     * @mzac90
     * select2 work for folder list in create new funnel modal
     * we will use this function for folder multi select2 drop down in future
     */

    renderFolderDropDown: function (){
        var folderList = lpUtilities.lpFolderSelect2list;
        for(var i = 0; i < folderList.length; i++) {
            selecter = folderList[i].selecter;
            let parent = folderList[i].parent;
            var dropdown = $(selecter).select2({
                width: '100%',
                placeholder: 'Type in Funnel Folder...',
                dropdownParent: $(parent),
                selectionAdapter: $.fn.select2.amd.require("CustomSelectionAdapter"),
                templateResult: function (data, container) {
                    if (data.element) {
                        $(container).addClass('za-tag-list');
                    }
                    var $result = $("<span></span>");

                    $result.text(data.text);
                    return $result;
                },
                matcher: function (params, data) {
                    return lpUtilities.matchStart(params, data);
                },
                sorter: function (data) {
                    return data.sort(function (a, b) {
                        return a.text.localeCompare(b.text)
                    })
                },
                language: {
                    noResults: function () {
                        var term = $(parent +' .funnel_select2js__folder-parent').find("input[type='search']").val();
                        return $("<span class='result-text'>No results found</span><div class='add-tag-wrap'><a href='#' class='add-funnel-folder' data-parent='" + parentClass + "' data-folder='" + term + "'><i class='ico ico-plus'></i><span class='create-new-tag-text'>Create new folder</span> <span class='tag-item'><i class='ico ico-tag'></i>" + term + "</span></a></div>");
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            });
            dropdown.on("select2:opening", function (e) {
                var selected = $(".funnel_select2js__folder-parent .select2-selection__choice").length;
                if(selected) {
                    dropdown.off('select2:opening');
                }
            });
            dropdown.on("select2:open", function () {
                selector = selecter;
                parentClass = parent.replace(/[#.]/g, '');
                $(`.${parentClass} .select2-dropdown`).addClass('za-tag-custom za-tag-dropdown-modifier');
                $(".select2-search.select2-search--inline .select2-search__field").addClass('za-tag-dropdown-modifier').css('border-radius', '3px 3px 0 0');
                $('.lp-tag .clone-tag-result .select2-container .select2-search--inline .select2-search__field').attr('placeholder', '');
                $('.za-tag-custom .select2-results__options').niceScroll({
                    //background: "#009edb",
                    background: "#02abec",
                    cursorcolor: "#ffffff",
                    cursorwidth: "7px",
                    autohidemode: false,
                    railalign: "right",
                    railvalign: "bottom",
                    railpadding: {top: 0, right: 0, left: 0, bottom: 4}, // set padding for rail bar
                    cursorborder: "1px solid #fff",
                    cursorborderradius: "5px"
                });
                $(`.${parentClass}`).parents('.modal').addClass('tag-dropdown-active');
                $(parent).find('.select2-search__field').removeClass('select2-remove-focus');
            });
            dropdown.on('select2:select', function (e) {
                $(parent +'  .funnel_select2js__folder-parent').addClass("folder-search-disabled");
            });
            dropdown.on("select2:close", function () {
            });
            dropdown.on('select2:unselect', function (e) {
                $(parent +'  .funnel_select2js__folder-parent').removeClass("folder-search-disabled");
            });
        }
    },

    //from @mzac09
    //folder drop down list
    folderList: function(){
        var opt = '';
        $(folder_data).each(function (index, el) {
            opt += '<option value="'+el.id+'" '+lpUtilities.isSelected(selected_folder_list,el.id)+'>'+el.folder_name+'</option>';
        });
        $('#create_funnel_folder_id').html(opt);
    },

    // Create New Funnel - custom select jQuery functions
    lpCustomSelect: function () {
        jQuery('.lp-custom-select__opener').click(function(e){
            e.preventDefault();
            var _self = jQuery(this);
            _self.parent('.lp-custom-select').addClass('lp-custom-select-active');
        });

        // ON Selection in Folder custom dropdown
        jQuery(document).on('click', '.lp-custom-select__list__item', function(e){
            var getHTML = jQuery(this).html();
            if(jQuery(this).attr('data-id') !== undefined && jQuery(this).attr('data-id') != ""){
                $("#create_funnel_folder_id").val(jQuery(this).attr('data-id'))
            } else {
                $("#create_funnel_folder_id").val("new_" + getHTML);
            }
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').html(getHTML);
            jQuery('.lp-custom-select__list__item').removeClass('selected');
            jQuery(this).addClass('selected');
            jQuery(this).parents('.lp-custom-select').removeClass('lp-custom-select-active');
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').addClass('text-selected');
            createFunnelButtonEnable();
        });

        jQuery(document).on('click', '.new-tags-opener', function(e){
            e.preventDefault();
            jQuery(this).parent('.new-tags-holder').addClass('lp-text-field-active');
            setTimeout(function (){
                jQuery("#new_folder").focus();
            },500);
        });

        jQuery('.lp-close-custom-tag').click(function(e){
            e.preventDefault();
            jQuery(this).parents('.new-tags-holder').removeClass('lp-text-field-active');
        });

        // ON adding new Folder in custom dropdown
        jQuery(document).on('click', '.lp-add-custom-tag', function(e){
            e.preventDefault();
            jQuery('.lp-custom-select__list__item').removeClass('selected');
            var getVal = jQuery(this).parents('.new-tag-field').find('input').val();
            if($.trim(getVal).length === 0)
            {
                return false;
            }
            $("#create_funnel_folder_id").val("new_"+getVal);
            var setVal = '<li class="lp-custom-select__list__item selected">'+ getVal +'</li>';
            jQuery('.lp-custom-select__list').append(setVal);
            jQuery(this).parents('.new-tags-holder').removeClass('lp-text-field-active');
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').html(getVal);
            jQuery(this).parents('.lp-custom-select').removeClass('lp-custom-select-active');
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').addClass('text-selected');
            jQuery("#new_folder").val('');
            createFunnelButtonEnable();
        });
    },

    /* Funcation of heading ellipsis */
        heading_ellipsis: function() {
            var parent_width =  $('.main-content__head').width();
            var right_width =  $('.main-content__head .col-right').width();
            var left_width =  $('.main-content__head .col-left').width();
            var title_parent_width =  $('.main-content__head .title').width();
            var title_width =  $('.page-name').width();
            var funnel_name_width =  $('.funnel-name').width();
            var left_col =  parent_width - right_width;
            var funnel_width =  left_col - title_width - 195;
            jQuery('.funnel-name').css({"max-width": funnel_width});
            if (jQuery('.main-content__head').find('.disabled-wrapper').length > 0) {
                jQuery('.funnel-name').css({"max-width": funnel_width - 130});
            }
            else {
                jQuery('.funnel-name').css({"max-width": funnel_width});
            }
            if(jQuery('body').hasClass('global-bar-active')) {
                jQuery('.funnel-name').css({"max-width": funnel_width - 200});
            }
            else {
                jQuery('.funnel-name').css({"max-width": funnel_width - 60});
            }
        },

    /*
    * init Function
    * */

    init: function () {
        lpUtilities.sidebarMenu();
        lpUtilities.selectFunnel();
        lpUtilities.profileSetting();
        lpUtilities.init_customSelect();
        lpUtilities.selectCategory();
        lpUtilities.searchplaceholder();
        lpUtilities.megaMenu();
        lpUtilities.megamenu_mCustomScrollbar();
        lpUtilities.outsideClick();
        lpUtilities.outsideHover();
        lpUtilities.OptionMenu();
        lpUtilities.OptionSubMenu();
        lpUtilities.headerRangeSlider();
        lpUtilities.funnelToggle();
        lpUtilities.globalTooltip();
        lpUtilities.color_picker_dropdown();
        lpUtilities.niceScroll();
        lpUtilities.deleteGlobalFunnel();
        lpUtilities.deleteNoGlobalFunnel();
        lpUtilities.deleteYesGlobalFunnel();
        lpUtilities.scrollbarFunnelSetting();
        lpUtilities.globalFunnelModal();
        lpUtilities.showModalCallback();
        lpUtilities.hideModalCallback();
        // lpUtilities.globalModalSelectFunnel();
        lpUtilities.addFunnelTags();
        lpUtilities.funneltagsloop();
        lpUtilities.cloneModalDropdowns();
        lpUtilities.scrollArea();
        lpUtilities.quickAccess();
        lpUtilities.globalSettingToggle();
        lpUtilities.requestForm();
        lpUtilities.innerPopup();
        lpUtilities.globalPopupopener();
        lpUtilities.addclassscroll();
        lpUtilities.scrollmenu();
        lpUtilities.addclassfunnel();
        lpUtilities.addclasshover();
        lpUtilities.searchSlideToggle();
        lpUtilities.statsSlideToggle();
        lpUtilities.addclasssclick();
        lpUtilities.cloneFunnelAddClassOnScrollInit();
        lpUtilities.copyToClipboard();
        lpUtilities.calculateTopTagSearchPosition();
        lpUtilities.tagFilterPositionInit();
        lpUtilities.tag_drop_down_list();
        lpUtilities.renderFolderDropDown();
        lpUtilities.lpCustomSelect();
        lpUtilities.heading_ellipsis();
    }
};




jQuery(document).ready(function () {
    lpUtilities.init();
    /*if( jQuery('#footer-page').hasClass('global-content-form') === true ) {
        jQuery('body').addClass('footer-page');
    }*/

    if ($(".classic-editor__wrapper").length > 0) {
        jQuery('body').addClass('footer-page');
    }


    $('#conversion_pro_website').click(()=>{
        if($('#conversion_pro_website').data('website') && $('#conversion_pro_website').data('status')=='1'){
            window.open($('#conversion_pro_website').data('website'), '_blank');
        }else{

            let wistiskey = $('#conversion_pro_website').data("lp-wistia-key");
            let title = $('#conversion_pro_website').data("lp-wistia-title");
            pausewistiavideos();
            // $("#website-video-modal .modal-dialog .modal-content .modal-header .modal-title").html(title);
            var wisurl='https://fast.wistia.com/embed/iframe/'+wistiskey;
            //var wisurl='https://leadpops.wistia.com/medias/'+wistiskey;
            var htmlString = '<div class="video-lp-wistia"> <iframe class="wistia_embed video__iframe" src="' + wisurl + '" allowtransparency="true" frameborder="0" scrolling="no"  name="wistia_embed" allowfullscreen mozallowfullscreen webkitallowfullscreen oallowfullscreen msallowfullscreen ></iframe></div>';
            var iframe_ele=$("#website-video-modal .modal-dialog .modal-content .modal-body .ifram-wrapper .video");
            iframe_ele.html(htmlString);
            $('#website-video-modal').modal('show');
            // $('.website-video-modal').modal();
        }
    });
    $(document).on('click','.tags-disabled',function (e){
        e.preventDefault();
        $(".za-tag-custom").parent('.select2-container--open').hide();
        $(".tag-result").find('.select2').removeClass('select2-container--open');
    });
    $(document).on('click','.select2-search__field',function (e){
        e.preventDefault();
        $(".za-tag-custom").parent('.select2-container--open').show();
    });

    //add new tag when no results found in tag drop down list @mzac90
    $(document).on('click','.add-tag',function (e){
        var id = 'new_'+$(this).data('tag');
        var _class = $(this).data('parent');
        var new_tag = {
            'id':  id,
            'client_id': parseInt(site.clientID),
            'tag_name': $(this).data('tag'),
            'is_default': 0
        }
        tag_dropdown.push(new_tag);
        if(_class == 'clone-new-tag'){
            selected_clone_tag_list.push(id);
            var type = 2;
        }
        else if(_class == 'funnel-tag-result'){
            funnel_selected_tag_list.push(id);
            var type = 3;
        }
        else{
            selected_tag_list.push(id);
            var type = 1;
        }
        lpUtilities.tag_drop_down_list(type,2);
        setTimeout(function (){
             $('.'+_class).find("input[type='search']").val('').click();

             // Exceptional case - To fix save button disabled issue on adding tag
             if(type !== undefined && type === 1) {
                 $("#tag_list").trigger("change");
             }
        },100);
    });

    $(document).on('keyup', '.funnel_select2js__folder-parent .select2-search__field', function(e){
        if (e.keyCode == 13) {
            $('.add-funnel-folder').click();
        }
    });

    $(document).on('keyup', '.select2js__tags-parent .select2-search__field', function(e){
        if (e.keyCode == 13) {
            $('.add-tag').click();
        }
    });

   // reset the state of stats and conversion rate setting modal on dashboard
    jQuery(".conversion-setting .button-cancel").click(function () {
        let status = parseInt($(this).attr('data-status'));
        let value = parseInt($(this).attr('data-value'));
        let modalId = $(this).parents('.conversion-setting').attr('id');
        let checked = (status)?true:false;
        jQuery("#"+modalId+ " input[type='checkbox']").prop('checked',checked);
        jQuery("#"+modalId+ " input[type='text']").val(value);

    });
    $(document).keydown(function(event) {
        if (event.keyCode == 27) {
            $('.modal').modal('hide');
        }
    });
    $(document).on('click','.select2-selection__choice__remove',function(event) {
        $('.select2-search__field').removeClass('select2-remove-focus');
    });

    jQuery(".actions-button__link_create-funnels").click( ()=>{
        lpUtilities.tag_drop_down_list(3);
        jQuery("#create-funnel").modal("show");
    });

    $('#create-funnel').on('shown.bs.modal', function () {
        $("#funnel_name,#create_funnel_tag_list").val('');
        $("#funnel_name").focus();
    });

    jQuery(document).on('submit',"#create-funnel-pop",function (e)
    {
        e.preventDefault();
        let formId = document.getElementById('create-funnel-pop');
        let formData = new FormData(formId);
        let url = jQuery(formId).attr('action');
        let response = createFunnelNameValidation();
        $("#funnel_name").val(lpUtilities.strip_tags($("#funnel_name").val()));
        if(response){
            jQuery.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: "json",
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    if(response.redirect !== undefined) {
                        window.location.href = response.redirect;
                    }
                }
            });
        }
    });

    //add new funnel folder when no results found in folder drop down list @mzac90 (NOT REQUIRED)
    $(document).on('click','.add-funnel-folder',function (e){
        var id = 'new_'+$(this).data('folder');
        selected_folder_list = id;
        var _class = $(this).data('parent');
        var new_tag = {
            'id':  id,
            'client_id': parseInt(site.clientID),
            'folder_name': $(this).data('folder'),
            'is_default': 0,
            'order': folder_data.length+1,
            'is_website': 0,
            'unsort_len': 0
        }
        folder_data.push(new_tag);
        lpUtilities.folderList();
        $('.'+_class +'  .funnel_select2js__folder-parent').addClass("folder-search-disabled");
        $('.'+_class +'  .funnel_select2js__folder-parent').find("input[type='search']").val('').click();
    });
});

$(window).resize(function(){
    lpUtilities.scrollResizing();
    lpUtilities.addclassfunnel();
    lpUtilities.addclasshover();
    lpUtilities.heading_ellipsis();
});

$(document).click(function(e) {
    var container = $(".pull-clr__wrapper,.color-box__panel-wrapper");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
        $('.last-selected').removeClass('up down');
    }
});

function goToByScroll(id){
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    if(id != "" && id !== undefined){
        if( $("#"+id).offset() !== undefined) {
            $('html,body').animate({
                    scrollTop: $("#" + id).offset().top - 100
                },
                'slow');
        }
    }
}

$(window).on('load', function (){
    lpUtilities.select2jsPlaceholder();
});

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

/*
* rgbStringToHex
* returns hex color for rgb or rgba color. It ommits opacity
* */
function rgbStringToHex(color) {
    let r=0,g=0,b=0;
    if(color.indexOf('rgba')>-1 || color.indexOf('rgb')>-1){
        r = parseInt(color.split(",")[0].split('(')[1]);
        g = parseInt(color.split(",")[1].split(')')[0]);
        b = parseInt(color.split(",")[2].split(')')[0]);
    }
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

/**
 * disabled selet tags when enable global setting
 */
function tagsDisable(){
    var selected_tag_list = jQuery(".tag-result").data('tags');
    if ($('[name="global_mode_bar"]').is(':checked')) {
        setTimeout(function (){
            jQuery(selected_tag_list).each(function (k,v){
                $(".select2-selection__choice[title='"+$("#tag_list [value='"+v+"']").text()+"']").addClass('tags-disabled');
                $(".tags-disabled .select2-selection__choice__remove").hide();
            });
        },2);
    }else{
        setTimeout(function (){
            jQuery(selected_tag_list).each(function (k,v){
                $(".select2-selection__choice[title='"+$("#tag_list [value='"+v+"']").text()+"']").removeClass('tags-disabled');
                $(".select2-selection__choice .select2-selection__choice__remove").show();
            });
        },2);
    }
}

//nice scroll init for tags dropdown
function tagScroll(){
     $('.za-tag-custom .select2-results__options').niceScroll({
        background: "#02abec",
        cursorcolor: "#ffffff",
        cursorwidth: "7px",
        autohidemode: false,
        railalign: "right",
        railvalign: "bottom",
        railpadding: {top: 0, right: 0, left: 0, bottom: 4}, // set padding for rail bar
        cursorborder: "1px solid #fff",
        cursorborderradius: "5px"
    });
}

function tagManage(parentClass){
    var tag = '';
    render = 1;
    if(parentClass == 'tag-result') {
        selected_tag_list = new Array();
        if ($("#tag_list").val()) {
            $($("#tag_list").val()).each(function (k, v) {
                if(parseInt(v)){
                    tag = parseInt(v);
                }
                else{
                    tag = v;
                }
                selected_tag_list.push(tag);
            });
        }
    }
    if(parentClass == 'funnel-tag-result') {
        funnel_selected_tag_list = new Array();
        if ($("#create_funnel_tag_list").val()) {
            $($("#create_funnel_tag_list").val()).each(function (k, v) {
                if(parseInt(v)){
                    tag = parseInt(v);
                }
                else{
                    tag = v;
                }
                funnel_selected_tag_list.push(tag);
            });
        }
        render = 3;
    }
    if(parentClass == 'clone-new-tag') {
        selected_clone_tag_list = new Array();
        if ($(".tag_list").val()) {
            $($(".tag_list").val()).each(function (k, v) {
                if(parseInt(v)){
                    tag = parseInt(v);
                }
                else{
                    tag = v;
                }
                selected_clone_tag_list.push(tag);
            });
        }
        render = 2;
    }
}


/**
 * funnel name duplicate validation
 */
function createFunnelNameValidation(){
    var response = true;
    var funnel_name = $("#funnel_name").val().toLowerCase();
    if(funnel_name == "") {
        displayAlert('warning', 'Funnel name is required.');
        return false;
    }else if(funnel_name != "") {
        var rec = jQuery.parseJSON(funnel_json);
        $(rec).each(function (index, el) {
            if(el.funnel_name != "" && el.funnel_name != null) {
                if (funnel_name.toLowerCase() == el.funnel_name.toLowerCase()) {
                    displayAlert('danger', 'Funnel name ' + funnel_name + ' is already in use. Please try something else.');
                    $(".create-new-funnel button[type=submit]").attr('disabled',true);
                    response = false;
                }
            }
        });
    }
    return response;
}

function createFunnelButtonEnable(){
    let inputValue = $('.create-new-funnel-validate').map((i,el) => (el.value != '')?el.value:null).toArray();
    console.log(inputValue);
    if(inputValue.length === 2){
        $(".create-new-funnel button[type=submit]").removeAttr('disabled');
    }
    else{
        $(".create-new-funnel button[type=submit]").attr('disabled',true);
    }
}
