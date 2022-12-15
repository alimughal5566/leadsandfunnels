var pos_top = '';
var pos_left = '';
var color_picker_block_height = '';
var color_picker_elm = '';
var $elem_this = '';
var rtl = '';
var $elm = '';
var  parentClass  = '';
var lpUtilities = {

    lp_tag_list : [
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
        }

        // jQuery("aside.sidebar").mouseenter(function() {
        //     jQuery('body').addClass('sidebar-active');
        // }).mouseleave(function() {
        //     jQuery('body').removeClass('sidebar-active');
        // });

        jQuery("aside.sidebar-inner").mouseenter(function() {
            /*jQuery('.funnels-dropdown .toggle-menu').slideUp(function () {
                jQuery('.funnels-dropdown.toggle-dropdown').removeClass('open');
            });*/
            if(jQuery('body').hasClass('off-sidebar')) {
                jQuery('body').addClass('sidebar-inner-active');
            }else {
                return true;
            }
        }).mouseleave(function() {
            if(jQuery('body').hasClass('off-sidebar')) {
                jQuery('body').removeClass('sidebar-inner-active');
            }else {
                return true;
            }
        });

        jQuery(".menu__list.menu__list_sub-menu").mouseenter(function(){
            jQuery("input").trigger("blur");
            jQuery('aside.sidebar-inner').css('overflow','visible');
        }).mouseleave(function() {
            jQuery('aside.sidebar-inner').css('overflow','hidden');
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
        $(".funnels-details-wrap").stop().slideUp();
        $('.funnels-box, .funnels-details__options .title').click(function () {
            var $toggle_elem = $(this).parents('.funnels-details');
            $toggle_elem.toggleClass('open');
            $toggle_elem.find('.funnels-details-wrap').stop().slideToggle();
            /*$toggle_elem.find('.funnel-head').slideToggle();*/
            lpUtilities.funnelOffset();
            //set from @mzac90
            lpUtilities.dashboardChart();
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
            var $offset = $('.funnels-block__title_tag').parent().offset();
            $('.funnels-box__tags').parent().offset({left: $offset.left});
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
                            color: 'rgba(2, 171, 236)',
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
        });
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
                autohidemode:false,
                railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
                cursorborder: "1px solid #02abec",
            });
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
        $(window).on('shown.bs.modal', function() {
            $('body').addClass('modal-open');
            jQuery('body').css('padding-right', '0');
        });
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
            }
        });
        dropdown.on("select2:open", function () {
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
            parentClass = parent.replace(/[#.]/g,'');
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
        $(".za-tag-custom").parent().css({
            top: $("."+ele+" .select2-search--inline")[0].offsetTop + $("."+ele+" .select2-search--inline")[0].offsetHeight - 4,
            left: $("."+ele+" .select2-search__field")[0].parentNode.offsetLeft+1
        });
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
            console.log($offsetParent.attr("class"));
            if($offsetParent.hasClass(parentClass)) {
                // console.log(parentClass);
                $('.tag-result-common .select2-selection__choice').mouseenter(function(){
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
        $('.select2js__folder').select2({
            width: '100%',
            minimumResultsForSearch: -1,
            dropdownParent: $(".select2js__folder-parent")
        });
    },

    /*
    * scroll area
    * */

    scrollArea: function () {
        jQuery(".quick-scroll").mCustomScrollbar({
            axis: "y",
            autoExpandScrollbar: true,
            autoHideScrollbar: false,
            mouseWheel: {
                scrollAmount: 100
            },
        });
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
    * Global tags toggle
    * */

    globaltags: function () {
        jQuery('.funnels-box__tags').each(function(){
            var _self = jQuery(this);
            var html = _self.clone();
            _self.parents('.funnels-details').find('.tags-popup').append(html);
            var getlength = _self.find('li').length;
            if (getlength < 5) {
                _self.parents('.tags-holder').addClass('hide');
            }
        });

        jQuery('.more-tags').click(function(){
            jQuery(this).parents('.funnels-details').find('.tags-popup-wrap').fadeToggle();
            return false;
        });
    },

    innerPopup: function() {
        jQuery(".modal [data-toggle='modal']").click(function () {
            jQuery('body').addClass('modal-open');
            jQuery('body').css('overflow', 'hidden');
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
        lpUtilities.funnelOffset();
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
        lpUtilities.globaltags();
        lpUtilities.innerPopup();
    },
};




jQuery(document).ready(function () {
    lpUtilities.init();
});

$(window).resize(function(){
    lpUtilities.funnelOffset();
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
