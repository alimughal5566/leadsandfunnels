var pos_top = '';
var pos_left = '';
var color_picker_block_height = '';
var color_picker_elm = '';
var $elem_this = '';
var rtl = '';
var $elm = '';
var  parentClass  = '';
let tagModal = [ 'clone-new-tag','create-new-funnel'];
var lpUtilities = {

    lp_tag_list : [
        {selecter:"#funnel-tag_list",parent:".create-new-funnel"},
        {selecter:"#tag_list",parent:".tag-result"},
        {selecter:".top-tag-search",parent:".top-tag-result"},
        {selecter:".tag_list",parent:".clone-tag-result"},
        {selecter:".tag-drop-down-pop",parent:".tag-result-pop"},
    ],

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
                jQuery(this).removeClass('menu-active');
            }
            else {
                jQuery('.menu__list.menu__list_sub-menu').removeClass('menu-active');
                jQuery(this).addClass('menu-active');
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
        jQuery('.client-setting__opener').click(function (e) {
            e.preventDefault();
            if(jQuery(this).parents('.client-setting__quick').hasClass('quick-active')) {
                jQuery(this).parents('.client-setting__quick').find('.quick-dropdown').attr('style', '');
                jQuery(this).parents('.client-setting__quick').removeClass('quick-active');
            } else {
                jQuery(this).parents('.client-setting__quick').addClass('quick-active');
                jQuery(this).parents('.client-setting__quick').find('.quick-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scaleX(1) scaleY(1)'});
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
            theme: 'default custom-select-class',
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
            jQuery('.funnel-type .select2-selection__rendered').hide();
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


        jQuery('.select2js__folder').select2({
            minimumResultsForSearch: -1,
            theme: 'default custom-select-class',
            dropdownParent: jQuery(".select2js__folder-parent"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.select2js__folder-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.select2js__folder-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.select2js__folder-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2js__folder-parent .select2-dropdown').hide();
            jQuery('.select2js__folder-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.select2js__folder-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2js__folder-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select2js__folder').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.select2js__folder-parent .select2-selection__rendered').show();
            jQuery('.select2js__folder-parent .select2-results__options').css('pointer-events', 'none');
        });

        /*jQuery('.select-custom_type').on('select2:open', function (e) {
          jQuery('.select2-dropdown').hide();
         setTimeout(function(){ jQuery('.select2-dropdown').fadeIn(300); }, 0);
        });*/


        /*jQuery('body').on('click', '.select2-selection, .select2-results__option' , function () {
            jQuery(this).parents('.select-test').toggleClass('select-active');
        });*/

        /*jQuery('.select-custom_type').on('select2:closing', function(e) {
            e.preventDefault();
            setTimeout(function () {
                jQuery('.select2-dropdown').fadeOut(300, function () {
                    $(".select-custom_type").select2('destroy').select2({
                        width: "100%",
                        minimumResultsForSearch: -1,
                        theme: 'default custom-select-class',
                       dropdownParent: jQuery(".select-test"),
                   });
                });
            }, 0);
        });*/

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

        //jQuery('.select-custom_category').on('select2:open', function (e) {
        //    jQuery('.select2-dropdown').hide();
        //    setTimeout(function(){ jQuery('.select2-dropdown').slideDown("medium"); }, 50);
        //});

        //jQuery('.select-custom_category').on('select2:closing', function(e) {
        //    e.preventDefault();
        //    setTimeout(function () {
        //       jQuery('.select2-dropdown').slideUp("medium", function () {
        //            $(".select-custom_category").select2('destroy').select2({
        //                width: "100%",
        //                dropdownParent: jQuery(".funnel-category"),
        //                minimumResultsForSearch: -1,
        //            });
        //        });
        //    }, 50);
        //});

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
        jQuery('.select-custom_category').change(function (){
            if(jQuery(this).val() == 2) {
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag').show();
                //jQuery(this).parents('.search-bar__filter').delay(5000).addClass('show-funnel-tag');
                jQuery(this).parents('.search-bar__filter').find('.funnel-name-search').hide();
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag-search').show();
                lpUtilities.searchplaceholder();
            } else {
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag').hide();
                //jQuery(this).parents('.search-bar__filter').delay(5000).removeClass('show-funnel-tag');
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag-search').hide();
                jQuery(this).parents('.search-bar__filter').find('.funnel-name-search').show();
            }
        });

        // megamenu search bar funnel-category Function
        jQuery('.megamenu__category_select').change(function (){
            if(jQuery(this).val() == 2) {
                jQuery(this).parents('.search-bar__filter').find('.megamenu__tag').show();
                jQuery(this).parents('.search-bar__filter').addClass('megamenu-show-funnel-tag');
                jQuery(this).parents('.search-bar__filter').find('.funnel-name-search').hide();
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag-search').show();
                lpUtilities.searchplaceholder();
            } else {
                jQuery(this).parents('.search-bar__filter').find('.megamenu__tag').hide();
                jQuery(this).parents('.search-bar__filter').removeClass('megamenu-show-funnel-tag');
                jQuery(this).parents('.search-bar__filter').find('.funnel-tag-search').hide();
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
            mouseWheel:{ scrollAmount: 80}
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
                if (jQuery(target).parents('.toggle-dropdown').length > 0 || jQuery(target).hasClass('select2-selection__choice__remove') == true) {
                }
                else {
                    jQuery(this).find('.toggle-menu').attr('style', '');
                    jQuery(".toggle-dropdown").removeClass('open');
                }
            }

            if(jQuery(".client-setting__quick").hasClass('quick-active')) {
                if (jQuery(target).parents('.client-setting__quick').length > 0) {
                }
                else {
                    jQuery('.quick-dropdown').slideUp(400, function () {
                        jQuery('.client-setting__quick').removeClass('quick-active');
                    });
                }
            }

            if(jQuery("body").hasClass('background-active')) {
                if (jQuery(target).parents('.background-clr-picker-lightbox').length > 0) {
                }
                else {
                    jQuery('body').removeClass('background-active');
                }
            }

            if(jQuery(".sender-email-parent").hasClass('active')) {
                if (jQuery(target).parents('.sender-email-parent').length > 0) {
                }
                else {
                    jQuery(this).find('.sender-email-list-dropdown').attr('style', '');
                    jQuery(".sender-email-parent").removeClass('active');
                }
            }

            if(jQuery(".select-box").hasClass('open')) {
                if (jQuery(target).parents('.answer-preview .dropdown').length > 0) {
                }
                else {
                    jQuery(this).find('.dropdown__list').attr('style', '');
                    jQuery(".select-box").removeClass('open');
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

            /*if(jQuery(".select-test").hasClass('select-active')) {
                if (jQuery(target).parents('.select-test').length > 0) {
                }
                else {
                    jQuery('.select-test').removeClass('select-active');
                }
            }*/

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
        jQuery('.client-setting__quick').mouseleave(function() {
            jQuery(this).find('.quick-dropdown').attr('style', '');
            jQuery(this).removeClass('quick-active');
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

        $('.opacity-slider').bootstrapSlider({
            min: 0,
            max: 100,
            step: 1,
            value: 1,
            tooltip: 'hide',
            tooltip_position:'bottom',
        }).on("slide", function(slideEvt) {
            $(".opacity-slider-val").text(slideEvt.value+'%');
        });
    },

    /*
    * funnel block toggle Function
    * */

    funnelToggle: function (){
        // $(".funnels-details-wrap").stop().slideUp();
        $('.funnels-box, .funnels-details__options .title').click(function () {
            var $toggle_elem = $(this).parents('.funnels-details');
            $toggle_elem.toggleClass('open');
            $toggle_elem.find('.funnels-details-wrap').stop().slideToggle();
            /*$toggle_elem.find('.funnel-head').slideToggle();*/
            //lpUtilities.funnelOffset();
            //set from @mzac90
            lpUtilities.dashboardChart();
            lpUtilities.globallength();
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
        if (window.location.href.indexOf("dashboard.php") > -1) {
            if($('.funnels-details').hasClass(('open'))) {
                setTimeout(function () {
                    var $offset = $('.funnels-block__title_tag').parent().offset().left;
                    console.info($offset);

                    var $offset_inner_tags = $('.funnels-box-inner__tags').parent().offset().left;
                    console.info($('.funnels-box-inner__tags').parent().position()    );
                    console.info($offset_inner_tags);
                }, 1000);
            }

            //var total_offset =  $offset.left - $offset_inner_tags.left;
            //$('.funnels-box-inner__tags').parent().offset({left: $offset.left + 15});
            //$('.funnels-box .funnels-box__name').css('padding-right', total_offset);
        }
    },


    /*
    ** dashboard charts
    * */
    dashboardChart: function(){
        if (window.location.href.indexOf("dashboard.php") > -1) {
            var chart = Highcharts.chart('statsChart', {
                chart: {
                    type: 'column',
                },
                title: {
                    text: ' '
                },
                subtitle: {
                    text: ' '
                },
                tooltip: {
                    outside: true,
                    borderRadius: 8,
                    backgroundColor: '#02abec',
                    borderWidth: 0,
                    shadow: false,
                    useHTML: true,
                    style: {
                        color: '#ffffff',
                        "font-size": "12px",
                        "font-weight": "bold"
                    },
                    formatter: function() {
                        return '<div class="chart-tooltip-wrapper chart-tooltip-wrapper_dashboard">'+
                            '<span class="point-date">'+this.x+'</span>'+
                            '<span class="point-year">'+this.y+'</span>'+
                            '<div>';
                    },
                    // positioner: function(labelWidth, labelHeight, point) {
                    //     var tooltipX = point.plotX - 15;
                    //     var tooltipY = point.plotY - 60;
                    //     return {
                    //         x: tooltipX,
                    //         y: tooltipY
                    //     };
                    // }
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    gridLineWidth: 1,
                    categories: ['Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Today'],
                    labels: {
                        style: {
                            color: '#85969f',
                            fontSize: '14px',
                            fontWeight: '700',
                            fontFamily:'"Open Sans", "Arial", "Helvetica Neue", "Helvetica", sans-serif',
                        },
                        format: '{value} <br> <div class="chart-date">10/23/20</div>'
                    },
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        style: {
                            color: '#85969f',
                            fontSize: '15px',
                            fontFamily:'"Open Sans", "Arial", "Helvetica Neue", "Helvetica", sans-serif',
                        }
                    },
                },
                plotOptions: {
                    series: {
                        pointWidth: 62,
                        borderColor: 'transparent'
                    }
                },
                series: [{
                    data: [
                        {
                            y: 1,
                            color: 'rgba(192, 234, 250)',
                        },
                        {
                            y: 2,
                            color: 'rgba(192, 234, 250)',
                        },
                        {
                            y: 3,
                            color: 'rgba(192, 234, 250)',
                        },
                        {
                            y: 2,
                            color: 'rgba(192, 234, 250)',
                        },
                        {
                            y: 4,
                            color: 'rgba(192, 234, 250)',
                        },
                        {
                            y: 2,
                            color: 'rgba(192, 234, 250)',
                        },
                        {
                            y: 4,
                            color: 'rgba(192, 234, 250)',
                        },
                        {
                            y: 2,
                            color: 'rgba(39, 194, 76)',
                        },
                    ],
                    showInLegend: false
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 630
                        },
                        chartOptions: {
                            plotOptions: {
                                series: {
                                    pointWidth: 45,
                                }
                            }
                        }
                    }, {
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            plotOptions: {
                                series: {
                                    pointWidth: 30,
                                }
                            }
                        }
                    }]
                },
                exporting: { enabled: false },
            });
        }
    },

    //*
    // ** Tooltip
    // *

    globalTooltip: function (){
        $('.el-tooltip').tooltipster({
            contentAsHTML:true
        });

        $('.question-tooltip').tooltipster({
            interactive: true,
            multiple: true,
            contentAsHTML:true
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


    //*
    // ** set color picker code
    // *

    set_colorpicker_box: function (box_name,hex_code){
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
        color_picker_elm = $('.color-box__panel-wrapper'+ elm +'');
        color_picker_block_height = $(color_picker_elm).outerHeight();
        rtl = pos_left + $(this).outerWidth() -330;
        console.log(pos_top, color_picker_elm, color_picker_block_height, rtl);

        if($(elm).find('.color-picker-options').val() == 1){
            $(color_picker_elm).parents().find('.color-pull-block').hide();
            $(color_picker_elm).parents().find('.color-picker-block').show();
        }else {
            $(color_picker_elm).parents().find('.color-picker-block').hide();
            $(color_picker_elm).parents().find('.color-pull-block').show();
        }

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
            $('.color-box__panel-wrapper.desc-message-clr').offset({top:pos_top - color_picker_block_height + 2, left: rtl });
        }
    },

    //*
    // ** color picker dropdown
    // *

    color_picker_dropdown: function () {
        $('.color-picker-options').select2({
            width: '100%',
            minimumResultsForSearch: -1,
        });
        /* $('.color-picker-options-message').select2().data('select2').$dropdown.addClass('color-picker-dropdown');
         $('.color-picker-options-description').select2().data('select2').$dropdown.addClass('color-picker-dropdown');*/
        $('.color-picker-options').on('change', function () {
            var $this = $(this).val();
            if($this == 1){
                if(jQuery('body').hasClass('background-advance-page')) {
                    lpUtilities.custom_color_pos(pos_top, $elm, 537, rtl);
                }
                else {
                    lpUtilities.custom_color_pos(pos_top, $elm, 529, rtl);
                }
                $('.color-box__panel-wrapper.desc-message-clr').offset({top:pos_top - color_picker_block_height + 2, left: rtl });
                $(this).parents('.color-box__panel-wrapper').find('.color-pull-block').hide();
                $(this).parents('.color-box__panel-wrapper').find('.color-picker-block').show();
            }else {
                if(jQuery('body').hasClass('background-advance-page')) {
                    lpUtilities.custom_color_pos(pos_top, $elm, 274, rtl);
                }
                else {
                    lpUtilities.custom_color_pos(pos_top, $elm, 254, rtl);
                }
                $(this).parents('.color-box__panel-wrapper').find('.color-picker-block').hide();
                $(this).parents('.color-box__panel-wrapper').find('.color-pull-block').show();
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
                autohidemode:false,
                railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
                cursorborder: "1px solid #02abec",
            });
        });

        $(".fuunel-select2js__nice-scroll").click(function () {
            $('.select2-results__options').niceScroll({
                cursorcolor:"#fff",
                cursorwidth: "10px",
                autohidemode:false,
                railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
                cursorborder: "1px solid #02abec",
            });
        });
    },


    //*
    // ** scroll Scroll
    // *

    scrollmenu: function () {
        jQuery(".sidebar-inner-wrap").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar : true,
            mouseWheel:{
                scrollAmount: 100
            },
        });

        jQuery(".check-body").mCustomScrollbar({
            axis:"y"
        });

        jQuery(".sidebar-inner-menu-wrap").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar : true,
            mouseWheel:{
                scrollAmount: 100
            },
        });

        jQuery(".right-sidebar").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar : true,
            mouseWheel:{
                scrollAmount: 100
            },
            callbacks:{
                whileScrolling:function(){
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.last-selected').removeClass('up down');
                },

                onScroll:function(){
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.last-selected').removeClass('up down');
                },
            },
        });

        jQuery(".question-option-scroll").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar : true,
            mouseWheel:{
                scrollAmount: 200
            },
        });
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
        $(document).on("click","#global-setting-funnel-list-pop .funnels__header .btn",function (){
            $('.scroll-holder').mCustomScrollbar({});
        });

        $(document).on("click","#global-confirmation-pop .funnels__header .btn",function (){
            $('.scroll-holder').mCustomScrollbar({});
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
            lpUtilities.scrollArea();
            // comment by M.Abdullah modal smooth work
            // $('body').addClass('modal-open');
            // jQuery('body').css('padding-right', '0');
            var headerHeight = $(this).find('.modal-header, .fb-modal__header').outerHeight();
            var footerHeight = $(this).find('.modal-footer, .fb-modal__footer').outerHeight();
            var totalHeight = (headerHeight + footerHeight + 88) + 'px';
            $(this).find('.modal-body, .fb-modal__body').css( {'max-height': 'calc(100vh - ' + totalHeight +')' } );
            // add by M.Abdullah make modal smooth
            setTimeout(function(){
                $(".quick-scroll").mCustomScrollbar("update");
            }, 500);
        });
    },

    scrollResizing: function () {
        lpUtilities.scrollArea();
        $('.quick-scroll, .pixel-quick-scroll, .folder-listing').mCustomScrollbar('update');
        $(".panel-aside-wrap").mCustomScrollbar("update");
    },

    /*
    * hide modal callback
    * */

    hideModalCallback: function () {
        $(window).on('hidden.bs.modal', function() {
            if ($('.modal:visible').length) {
                jQuery('body').addClass('modal-open');
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
    * global setting modal select2js
    * */

    globalModalSelectFunnel: function () {
        var amIclosing = false;
        $('#funnel-search__by').select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownParent: $('.funnel-search__category')
        }).on('change',function () {
            if ($(this).val() == 'n') {
                $('.funnel-search__input-tag').hide();
                $('.funnel-search__input-name').show();
            }else {
                $('.funnel-search__input-name').hide();
                $('.funnel-search__input-tag').show();
            }
        }).on('select2:openning', function() {
            jQuery('.funnel-search__category .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.funnel-search__category .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.funnel-search__category .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.funnel-search__category .select2-dropdown').hide();
            jQuery('.funnel-search__category .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.funnel-search__category .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.funnel-search__category .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#funnel-search__by').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.funnel-search__category .select2-selection__rendered').show();
            jQuery('.funnel-search__category .select2-results__options').css('pointer-events', 'none');
        });
    },


    /*
    * funnel tag(s) select2js
    * */

    initSelect2:function (selecter,parent) {
        var dropdown =  $(selecter).select2({
            width: '100%',
            placeholder: 'Type in Funnel Tag(s)...',
            dropdownParent: $(parent),
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
            language:{
                noResults: function() {
                    if(parent == '.funnel-tag-result' || parent == '.create-new-funnel') {
                        var term = $(parent).find("input[type='search']").val();
                        return $("<span class='result-text'>No results found</span><div class='add-tag-wrap'><a href='#' class='add-tag' data-parent='"+parentClass+"' data-tag='" + term + "'><i class='ico ico-plus'></i>Create new tag <b></b></a><span class='tag-item'><i class='ico ico-tag'></i>"+term+"</span></div>");
                    }
                    return "No results found";
                }
            },
        });
        dropdown.on("select2:open", function () {
            parentClass = parent.replace(/[#.]/g,'');
            $(".select2-dropdown").addClass('za-tag-custom');
            $(".select2-search.select2-search--inline .select2-search__field").css('border-radius', '3px 3px 0 0');
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
        });
        dropdown.on("select2:close", function () {
            var placeholder = '';
            if ($(".lp-tag .clone-tag-result .select2-container ul li").hasClass('select2-selection__choice') == false) {
                placeholder = 'Type in Funnel Tag(s)...';
            } else {
                placeholder = 'Add another tag';
            }
            $('.lp-tag .clone-tag-result .select2-container .select2-search--inline .select2-search__field').attr('placeholder', placeholder);
            $("#tag_list-error").remove();
        });
        dropdown.on('select2:unselecting', function (e) {
            dropdown.on('select2:opening', function (e) {
                e.preventDefault();
                dropdown.off('select2:opening');
            });
        });
        dropdown.on('select2:unselect', function (e) {
            /*$("#tag_list").select2("close");*/
            /* discuss with Sir Zulfiqar that we don't need it in HTML version */
            /*if(parentClass == 'tag-result') {
                if (site.route == 'dashboard') {
                    _search();
                }
            }
            else if(parentClass === 'top-tag-result'){
                topHeaderFunnelFilter();
            }*/
        });
    },

    /*
    * funnel tag(s) select2js start match
    * */

    matchStart: function (params, data) {
        params.term = params.term || '';
        if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
            return data;
        }
        return null;
    },

    /*
    * funnel tag(s) select2js dropdown positions
    * */

    dropdownpos: function (ele) {
        if(jQuery.inArray( ele, tagModal)){
            var $cloneTag = $('.'+ele);
            var $searchField = $cloneTag.find('.select2js__tags-parent .select2-search__field');
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
            })
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
    * */

    select2jsPlaceholder: function () {
        $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').show();
        if($(".lp-tag .tag-result-common .select2-container ul li").hasClass('select2-selection__choice') == false ){
            placeholder = 'Type in Funnel Tag(s)...';
        }else{
            placeholder = 'Add another tag';
        }
        $('.lp-tag .tag-result-common .select2-container .select2-search--inline .select2-search__field').attr('placeholder',placeholder);
    },

    /*
    * funnel tag(s) select2js add funnels
    * */

    addFunnelTags: function () {
        // select init for get the drop down position
        var Defaults = $.fn.select2.amd.require('select2/defaults');
        $.extend(Defaults.defaults, {
            dropdownPosition: 'auto'
        });
        var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');
        var _positionDropdown = AttachBody.prototype._positionDropdown;
        AttachBody.prototype._positionDropdown = function() {
            var $offsetParent = this.$dropdownParent;
            /*console.log($offsetParent.attr("class"));
            console.log(parentClass);*/
            if($offsetParent.hasClass(parentClass)) {
                 console.log('if condition');
                /*$('.tag-result-common .select2-selection__choice').mouseenter(function(){
                    lpUtilities.dropdownpos(parentClass);
                    $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').hide();
                });
                $('.tag-result-common .select2-selection__choice').mouseleave(function(){
                    lpUtilities.dropdownpos(parentClass);
                    $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').show();
                    lpUtilities.select2jsPlaceholder();
                });
                $('.tag-result-common .select2-search__field').blur(function () {
                    lpUtilities.dropdownpos(parentClass);
                    lpUtilities.select2jsPlaceholder();
                });*/

                lpUtilities.dropdownpos(parentClass);
            }
            else{
                console.log('else condition');
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
    },


    /*
    * funnel tag(s) loop
    * */


    funneltagsloop: function () {
        var taglist = lpUtilities.lp_tag_list;
        for(var i = 0; i < taglist.length; i++){
            console.log(taglist[i].selecter);
            lpUtilities.initSelect2(taglist[i].selecter,taglist[i].parent);
        }
    },

    /*
    * modal dropdowns
    * */

    cloneModalDropdowns: function () {
        $('.select2js__lvl-domain').select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownParent: $(".select2js__lvl-domain-parent")
        });
        /*$('.select2js__folder').select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownParent: $(".select2js__folder-parent")
        });*/
    },

    /*
    * scroll area
    * */

    scrollArea: function () {

        if(jQuery('.sidebar-inner-wrap').length > 0) {
            jQuery('.sidebar-inner-wrap').mCustomScrollbar({
                axis: "y",
            });
        }

        if(jQuery('.sidebar-inner-menu-wrap').length > 0) {
            jQuery('.sidebar-inner-menu-wrap').mCustomScrollbar({
                axis: "y",
            });
        }

        if(jQuery('.panel-aside-wrap').length > 0) {

            jQuery(".panel-aside-wrap").mCustomScrollbar({
                autoHideScrollbar: true,
                axis: "y",
                mouseWheel: {
                    scrollAmount: 200
                },
                callbacks: {
                    whileScrolling: function () {
                        var select_button = $("#clr-icon").offset();
                        var select_button1 = $("#fb-clr-icon").offset();
                        var select_button2 = $("#cta-clr-icon").offset();
                        var select_button7 = $("#menu-clr-icon").offset();
                        var select_button8 = $("#num-clr-icon").offset();
                        var select_button9 = $("#non-num-clr-icon").offset();
                        var select_button3 = $("#contact-clr-icon").offset();
                        var select_button4 = $("#textfield-clr-icon").offset();
                        var select_button5 = $("#textfield-large-clr-icon").offset();
                        var select_button6 = $("#dropdown-clr-icon").offset();
                        var window_height = $(window).height();
                        var select_dropdown = $('.color-box__panel-wrapper').height();
                        var select_total = select_button.top + select_dropdown;
                        var select_total2 = select_button2.top + select_dropdown;
                        var select_total1 = select_button1.top + select_dropdown;
                        var select_total7 = select_button7.top + select_dropdown;
                        var select_total8 = select_button8.top + select_dropdown;
                        var select_total9 = select_button9.top + select_dropdown;
                        var select_total3 = select_button3.top + select_dropdown;
                        var select_total4 = select_button4.top + select_dropdown;
                        var select_total5 = select_button5.top + select_dropdown;
                        var select_total6 = select_button6.top + select_dropdown;
                        if (window_height < select_total) {
                            $(".icon-clr").offset({
                                top: select_button.top - select_dropdown - 44,
                                left: select_button.left - 174
                            });
                        }
                        else {
                            $(".icon-clr").offset({top: select_button.top + 46, left: select_button.left - 174});
                        }
                        if (window_height < select_total1) {
                            $(".fb-icon-clr").offset({
                                top: select_button1.top - select_dropdown - 44,
                                left: select_button1.left - 174
                            });
                        }
                        else {
                            $(".fb-icon-clr").offset({top: select_button1.top + 46, left: select_button1.left - 174});
                        }
                        if (window_height < select_total2) {
                            $(".cta-icon-clr").offset({
                                top: select_button2.top - select_dropdown - 44,
                                left: select_button2.left - 174
                            });
                        }
                        else {
                            $(".cta-icon-clr").offset({top: select_button2.top + 46, left: select_button2.left - 174});
                        }
                        if (window_height < select_total7) {
                            $(".menu-icon-clr").offset({
                                top: select_button7.top - select_dropdown - 44,
                                left: select_button7.left - 174
                            });
                        }
                        else {
                            $(".menu-icon-clr").offset({top: select_button7.top + 46, left: select_button7.left - 174});
                        }
                        if (window_height < select_total8) {
                            $(".num-icon-clr").offset({
                                top: select_button8.top - select_dropdown - 44,
                                left: select_button8.left - 174
                            });
                        }
                        else {
                            $(".num-icon-clr").offset({top: select_button8.top + 46, left: select_button8.left - 174});
                        }
                        if (window_height < select_total9) {
                            $(".non-num-icon-clr").offset({
                                top: select_button9.top - select_dropdown - 44,
                                left: select_button9.left - 174
                            });
                        }
                        else {
                            $(".non-num-icon-clr").offset({
                                top: select_button9.top + 46,
                                left: select_button9.left - 174
                            });
                        }
                        if (window_height < select_total3) {
                            $(".contact-icon-clr").offset({
                                top: select_button3.top - select_dropdown - 44,
                                left: select_button3.left - 174
                            });
                        }
                        else {
                            $(".contact-icon-clr").offset({
                                top: select_button3.top + 46,
                                left: select_button3.left - 174
                            });
                        }
                        if (window_height < select_total4) {
                            $(".textfield-icon-clr").offset({
                                top: select_button4.top - select_dropdown - 44,
                                left: select_button4.left - 174
                            });
                        }
                        else {
                            $(".textfield-icon-clr").offset({
                                top: select_button4.top + 46,
                                left: select_button4.left - 174
                            });
                        }
                        if (window_height < select_total5) {
                            $(".textfield-large-icon-clr").offset({
                                top: select_button5.top - select_dropdown - 44,
                                left: select_button5.left - 174
                            });
                        }
                        else {
                            $(".textfield-large-icon-clr").offset({
                                top: select_button5.top + 46,
                                left: select_button5.left - 174
                            });
                        }
                        if (window_height < select_total6) {
                            $(".dropdown-icon-clr").offset({
                                top: select_button6.top - select_dropdown - 44,
                                left: select_button6.left - 174
                            });
                        }
                        else {
                            $(".dropdown-icon-clr").offset({
                                top: select_button6.top + 46,
                                left: select_button6.left - 174
                            });
                        }
                    },
                },
            });
        }

        if(jQuery('.quick-scroll').length > 0) {

            jQuery(".quick-scroll").mCustomScrollbar({
                axis: "y",
                autoExpandScrollbar: true,
                autoHideScrollbar: false,
                mouseWheel: {
                    scrollAmount: 100
                },
                callbacks:{
                    whileScrolling:function(){
                        jQuery('.color-box__panel-wrapper').css('display', 'none');
                    },

                    onScroll:function(){
                        jQuery('.color-box__panel-wrapper').css('display', 'none');
                    },
                }
            });
        }

        jQuery(".color-picker-homepage-cta-message").mCustomScrollbar({
            autoHideScrollbar :false,
            axis: "y",
            mouseWheel: {
                scrollAmount: 100
            },
            callbacks:{
                whileScrolling:function(){
                    jQuery('.color-picker-options').select2("close");
                },

                onScroll:function(){
                    jQuery('.color-picker-options').select2("close")
                },
            }
        });

        if(jQuery('.advance-intergration-holder').length > 0) {

            jQuery(".advance-intergration-holder").mCustomScrollbar({
                autoHideScrollbar: false,
                axis: "y",
                mouseWheel: {
                    scrollAmount: 200
                },
            });
        }

        if(jQuery('.funnel-body-scroll').length > 0) {

            jQuery(".funnel-body-scroll").mCustomScrollbar({
                autoHideScrollbar: false,
                axis: "y",
                mouseWheel: {
                    scrollAmount: 200
                },
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
                    required: "Please select a category."
                },
                mainissue: {
                    required: "Please select a topic."
                },
                subject: {
                    required: "Please enter a subject."
                },
                message: {
                    required: "Please enter a message."
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

    /*
    * Global tags toggle
    * */

    globaltags: function () {
        jQuery('.funnels-box__tags').each(function(){
            var _self = jQuery(this);
            var html = _self.clone();
            _self.parents('.funnels-details').find('.tags-popup').append(html);
            var getlength = _self.find('li').length;
        });

        jQuery('.more-tags').click(function(){
            jQuery(this).parents('.funnels-details').find('.tags-popup-wrap').fadeToggle();
            jQuery(this).parents('.tags-holder').toggleClass('tags-active');
            return false;
        });

        jQuery('.megamenu-funnels .tags-list').each(function(){
            var _self = jQuery(this);
            var html = _self.clone();
            _self.parents('.megamenu-funnels__column').find('.tags-popup').append(html);
            var getlength = _self.find('li').length;
            /*if (getlength < 4) {
                _self.parents('.tags-holder').addClass('hide');
            }*/
        });

        jQuery('.more-tag').click(function(){
            jQuery(this).parents('.megamenu-funnels__column').find('.tags-popup-wrap').fadeToggle();
            jQuery(this).parents('.tags-holder').toggleClass('tag-active');
        });
    },

    /*
    * Global length toggle
    * */

    globallength: function () {

        jQuery('.tags-holder-wrap').each(function(){
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
            jQuery(this).parents('.tags-holder').find('.more').show();
            if(temp_width <= room){
                jQuery(this).parents('.tags-holder').find('.more').hide();
            }
        });

        jQuery('.tag-select-wrap').each(function(){
            var temp_width = 45;
            var index = 0;
            var room = 450;
            jQuery(this).find('li').show().each(function(){
                temp_width = temp_width + jQuery(this).outerWidth();
                if(temp_width < room){
                    index++;
                }
            });
            jQuery(this).find('li:gt('+ (index-1) +')').hide();
            if(temp_width <= room){
                jQuery(this).parents('.tags-holder').find('.more').hide();
            }
        });
    },

    innerPopup: function() {
        jQuery(".modal [data-toggle='modal']").click(function () {
            jQuery('body').addClass('modal-open');
            jQuery('body').css('overflow', 'hidden');
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

        jQuery("#bg_color01").click(function () {
            jQuery('body').toggleClass('background-active');
        });

        jQuery(".lp-controls__edit").click(function () {
            jQuery(this).parents('.shortUrl').addClass('active');
            var _self = jQuery(this);
            _self.parents('.url-expand').find('input.form-control').select();
        });

        jQuery(".cancel-option").click(function () {
            jQuery(this).parents('.shortUrl').removeClass('active');
        });

        jQuery(".plan-tabs a").click(function () {
            jQuery('.plan-tabs li').removeClass('active');
            jQuery(this).parent().addClass('active');
        });
    },

    addclasshover: function() {
        jQuery(".menu__list_sub-menu").hover(function () {
            if(!(jQuery('body').hasClass('funnel-question-page-group'))) {
                jQuery(this).parents('.sidebar-inner').toggleClass('menu-hover');
            }
        });

        jQuery(".list-actions__link").hover(function () {
            jQuery(this).parents('body').toggleClass('tooltip-hover');
        });

        jQuery(".funnel-name").hover(function () {
            jQuery(this).parents('body').toggleClass('funnel-name-tooltip');
        });

        jQuery(".funnels-details__info-name").hover(function () {
            jQuery(this).parents('.funnels-box').toggleClass('funnels-box-hover');
        });

        jQuery(".options-menu__item.view").hover(function () {
            jQuery(this).toggleClass('view-hover');
        });
    },

    /*
    * Open up the Global Popup
    * */
    globalPopupopener: function () {
        $("#global-setting-placeholder-pop [data-toggle='modal']").click(function () {
            jQuery('body').addClass('modal-open video-open');
            jQuery('body').css('overflow', 'hidden');
        });
        $('.lp-global-opener').on('hidden.bs.modal', function () {
            if(jQuery('body').hasClass('video-open')) {
                jQuery('body').css('overflow', 'hidden');
                jQuery('body').addClass('modal-open');
                $('#global-setting-placeholder-pop').modal('show');
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
        });
    },

    /*
    * search toggle link
    * */
    statsSlideToggle: function () {
        jQuery('.stats-trigger').click(function (){
            jQuery('body').toggleClass('hide-stats');
            jQuery('.stats-area-slide').slideToggle();
        });
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

    /* custom tabs function */
    initCustomtabs: function() {
        jQuery('.tab-opener').on('click',function (e) {
            e.preventDefault();
            jQuery('.tab-slide').hide();
            var index = jQuery(".tab-opener").index(this);
            jQuery('.tab-opener').removeClass('active');
            jQuery(this).addClass('active');
            var activeSlideIndex = jQuery('.tab-slide').index($('.tab-slide-active'));
            jQuery('.tab-slide').removeClass('tab-slide-active right');
            jQuery('.tab-slide').eq(index).addClass('tab-slide-active');
            var currSlideIndex = jQuery('.tab-slide').index($('.tab-slide-active'));
            console.log(activeSlideIndex);
            if(currSlideIndex > activeSlideIndex) {
                jQuery('.tab-slide').removeClass('tab-left');
                jQuery('.tab-slide').eq(index).removeClass('right');
            }
            else {
                jQuery('.tab-slide').addClass('tab-left');
                jQuery('.tab-slide').eq(index).addClass('right');
            }
        });
    },

    /*
   * selecticon function
   * */
    selecticon: function () {
        jQuery('body').on('change', '.icons-list input[type="radio"]', function(){
            var _self = jQuery(this);
            _self.parents('.select-icon-modal').find('.button-primary').removeClass('disabled');
        });

        jQuery('#select-icon-modal').on('hidden.bs.modal', function () {
            jQuery('.select-icon-modal').find('.button-primary').addClass('disabled');
            jQuery('.select-icon-modal').find('input[type="radio"]:checked').prop('checked', false);
        });
    },

    /**
     ** add new tag function
     **/
    addTagInit: function() {
        var tag_dropdown = [];
        $(document).on('click', '.add-tag', function (e) {
            e.preventDefault();
            var id = 'new_' + $(this).data('tag');
            $('#funnel-tag_list').append('<option value="'+id+'">'+$(this).data('tag')+'</option>');
            var getVal = jQuery('#funnel-tag_list').val();
            getVal.push(id);
            $("#funnel-tag_list").val(getVal);
            setTimeout(function (){
                $('.funnel-tag-result').find("input[type='search']").val('').click();
            },100);
        });
    },

    /*funnelTagpos: function () {
        $(document).on('click', '.funnel-tag-result .select2-search__field', function (e) {
            var x = $('.funnel-tag-result .select2-search__field').offset();
            var modalOffset = $('#create-funnel .modal-content').offset();
            console.log(x.left, x.top);
            $('.create-new-funnel > .select2-container').css({'left': (x.left - modalOffset.left) - 1 +'px', 'top': (x.top - modalOffset.top) + 38 +'px'});
        });

        $(document).on('click', '.za-tag-list', function (e) {
            console.log('clicked');
        });

        $('#create-funnel').on('select2:open', '#funnel-tag_list',function (e) {
        });
    },*/

    scrollbarFunnelTags: function () {
        $('.quick-scroll-holder, .lp-tag-scroll').mCustomScrollbar({
            scrollInertia: 0,
            live: true,
            callbacks:{
                onScrollStart:function(){
                    if($(this).parents('.create-new-funnel')) {
                        $("#funnel-tag_list").select2('close');
                    }
                },
                onScroll:function(){
                }
            }
        });
    },

    /*
  * graph tab function
  * */
    graph_tabs: function () {
        jQuery('.graph-tab-link').click(function(e){
            e.preventDefault();
            jQuery(this).parents('.leads-graph').find('.graph-tab-link').removeClass('active');
            jQuery(this).parents('.leads-graph').find(this).addClass('active');
            if(jQuery(this).hasClass('month')){
                jQuery(this).parents('.leads-graph').find('.days-chart').removeClass('active');
                jQuery(this).parents('.leads-graph').find('.month-chart').addClass('active');
            }
            else {
                jQuery(this).parents('.leads-graph').find('.days-chart').addClass('active');
                jQuery(this).parents('.leads-graph').find('.month-chart').removeClass('active');
            }
        });
    },

    /*
    * color picker advance feature funcation
    * */
    color_picker_advance_feature: function () {
        jQuery('.has-shadow-parent').click(function(e){
            e.preventDefault();
            var _self = jQuery(this);
            var window_height = jQuery(window).height();
            var select_button = jQuery(this).offset();
            var select_dropdown = jQuery('.color-box__panel-wrapper').height();
            var select_total = select_button.top + select_dropdown;
            _self.toggleClass('color-picker-active');
            if(window_height < select_total){
                _self.addClass("up").removeClass('down');
            }
            else {
                _self.addClass("down").removeClass('up');
            }
        });
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
        //lpUtilities.funnelOffset();
        lpUtilities.color_picker_dropdown();
        lpUtilities.niceScroll();
        lpUtilities.deleteGlobalFunnel();
        lpUtilities.deleteNoGlobalFunnel();
        lpUtilities.deleteYesGlobalFunnel();
        lpUtilities.scrollbarFunnelSetting();
        lpUtilities.globalFunnelModal();
        lpUtilities.showModalCallback();
        lpUtilities.hideModalCallback();
        lpUtilities.globalModalSelectFunnel();
        lpUtilities.addFunnelTags();
        lpUtilities.funneltagsloop();
        lpUtilities.cloneModalDropdowns();
        lpUtilities.scrollArea();
        lpUtilities.quickAccess();
        lpUtilities.globalSettingToggle();
        lpUtilities.requestForm();
        lpUtilities.globallength();
        lpUtilities.globaltags();
        lpUtilities.innerPopup();
        lpUtilities.globalPopupopener();
        lpUtilities.addclassscroll();
        lpUtilities.scrollmenu();
        lpUtilities.addclasshover();
        lpUtilities.addclasssclick();
        lpUtilities.searchSlideToggle();
        lpUtilities.statsSlideToggle();
        lpUtilities.radioaccortion();
        lpUtilities.selecticon();
        lpUtilities.initCustomAccordion();
        lpUtilities.initCustomtabs();
        lpUtilities.addTagInit();
        //lpUtilities.funnelTagpos();
        lpUtilities.scrollbarFunnelTags();
        lpUtilities.sidebMenuToggle();
        lpUtilities.graph_tabs();
        //lpUtilities.color_picker_advance_feature();
    },

    tagAlignment: function(){
        if($('.funnels-block__title_tag').length > 0) {
            var $offset = $('.funnels-block__title_tag').parent().offset().left;
            var $offset_inner_tags = $('.funnels-box-inner__tags').parent().offset().left;
            var extraSpace =  $offset_inner_tags - $offset - 15 ;
            $('body').find('.tags-wrap').addClass('test');
            $('.funnels-box-inner__tags').parent().css({'margin-left': '-'+parseInt(extraSpace)+'px'});
            $('.funnels-box-inner__name').css({'padding-right': parseInt(extraSpace - 10) +'px'});
        }
    }
};




jQuery(document).ready(function () {
    lpUtilities.tagAlignment();
    $(".funnels-details-wrap").css({'visibility':'visible','height':'auto'}).hide();

    lpUtilities.init();
});


$(window).resize(function(){
    lpUtilities.tagAlignment();
    lpUtilities.scrollResizing();
    $(".panel-aside__body-holder").mCustomScrollbar("update");
    $(".funnel-body-scroll").mCustomScrollbar("update");
    $(".right-sidebar").mCustomScrollbar("update");
    //lpUtilities.funnelOffset();
});

$(document).click(function(e) {
    var container = $(".pull-clr__wrapper,.color-box__panel-wrapper");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
        $('.last-selected').removeClass('up down');
        $('.has-shadow-parent').removeClass('color-picker-active up down');
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
