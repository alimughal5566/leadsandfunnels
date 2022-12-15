$(document).ready(function () {

    var amIclosing = false;
    // funnel type
    jQuery('.select2__funnel-version').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__funnel-version-parent"),
        width: '100%'
    }).on('change',function () {
        $('#selectfunnel').modal('show');
    }).on('select2:openning', function() {
        jQuery('.select2__funnel-version-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__funnel-version-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__funnel-version-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__funnel-version-parent .select2-dropdown').hide();
        jQuery('.select2__funnel-version-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__funnel-version-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__funnel-version-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__funnel-version').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__funnel-version-parent .select2-selection__rendered').show();
        jQuery('.select2__funnel-version-parent .select2-results__options').css('pointer-events', 'none');
    }).on('change',function () {
        $('#selectfunnel').modal('show');
    });


    jQuery('.select2__str-hours').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__str-hours-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__str-hours-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__str-hours-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__str-hours-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__str-hours-parent .select2-dropdown').hide();
        jQuery('.select2__str-hours-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__str-hours-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__str-hours-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('.select2__str-hours').find(':selected').index();
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
            jQuery('.select2__str-hours-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__str-hours').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__str-hours-parent .select2-selection__rendered').show();
        jQuery('.select2__str-hours-parent .select2-results__options').css('pointer-events', 'none');
    });


    jQuery('.select2__str-min').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__str-min-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__str-min-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__str-min-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__str-min-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__str-min-parent .select2-dropdown').hide();
        jQuery('.select2__str-min-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__str-min-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__str-min-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('.select2__str-min').find(':selected').index();
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
            jQuery('.select2__str-min-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__str-min').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__str-min-parent .select2-selection__rendered').show();
        jQuery('.select2__str-min-parent .select2-results__options').css('pointer-events', 'none');
    });


    jQuery('.select2__str-timezone').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__str-timezone-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__str-timezone-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__str-timezone-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__str-timezone-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__str-timezone-parent .select2-dropdown').hide();
        jQuery('.select2__str-timezone-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__str-timezone-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__str-timezone-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__str-timezone').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__str-timezone-parent .select2-selection__rendered').show();
        jQuery('.select2__str-timezone-parent .select2-results__options').css('pointer-events', 'none');
    });


    jQuery('.select2__end-hours').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__end-hours-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__end-hours-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__end-hours-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__end-hours-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__end-hours-parent .select2-dropdown').hide();
        jQuery('.select2__end-hours-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__end-hours-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__end-hours-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('.select2__end-hours').find(':selected').index();
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
            jQuery('.select2__end-hours-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__end-hours').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__end-hours-parent .select2-selection__rendered').show();
        jQuery('.select2__end-hours-parent .select2-results__options').css('pointer-events', 'none');
    });


    jQuery('.select2__end-min').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__end-min-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__end-min-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__end-min-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__end-min-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__end-min-parent .select2-dropdown').hide();
        jQuery('.select2__end-min-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__end-min-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__end-min-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('.select2__end-min').find(':selected').index();
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
            jQuery('.select2__end-min-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__end-min').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__end-min-parent .select2-selection__rendered').show();
        jQuery('.select2__end-min-parent .select2-results__options').css('pointer-events', 'none');
    });


    jQuery('.select2__end-timezone').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__end-timezone-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__end-timezone-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__end-timezone-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__end-timezone-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__end-timezone-parent .select2-dropdown').hide();
        jQuery('.select2__end-timezone-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__end-timezone-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__end-timezone-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__end-timezone').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__end-timezone-parent .select2-selection__rendered').show();
        jQuery('.select2__end-timezone-parent .select2-results__options').css('pointer-events', 'none');
    });


    jQuery('.select2__datetime').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__datetime-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__datetime-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__datetime-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__datetime-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__datetime-parent .select2-dropdown').hide();
        jQuery('.select2__datetime-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__datetime-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__datetime-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__datetime').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__datetime-parent .select2-selection__rendered').show();
        jQuery('.select2__datetime-parent .select2-results__options').css('pointer-events', 'none');
    });


    jQuery('.select2__datetime-or').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2__datetime-or-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2__datetime-or-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__datetime-or-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__datetime-or-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__datetime-or-parent .select2-dropdown').hide();
        jQuery('.select2__datetime-or-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__datetime-or-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__datetime-or-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__datetime-or').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__datetime-or-parent .select2-selection__rendered').show();
        jQuery('.select2__datetime-or-parent .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('.select2js__funnel-sort').select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2js__funnel-sort-parent"),
        width: '100%'
    }).on('select2:openning', function() {
        jQuery('.select2js__funnel-sort-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__funnel-sort-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__funnel-sort-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__funnel-sort-parent .select2-dropdown').hide();
        jQuery('.select2js__funnel-sort-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__funnel-sort-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__funnel-sort-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2js__funnel-sort').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__funnel-sort-parent .select2-selection__rendered').show();
        jQuery('.select2js__funnel-sort-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.expand-or').click(function () {
        $(this).css('opacity','0');
        $('.scheduling-expand').slideDown();
    });

    $('.collapse-or').click(function () {
        $('.scheduling-expand').slideUp(function () {
            $('.expand-or').css('opacity','1');
        });
    });

    $(".funnel__list").mCustomScrollbar({
        theme:"dark",
        mouseWheel:{ scrollAmount: 80}
    });

    $('#startdatemodal .button-cancel').click(function () {
        $('#popstartdatepicker').val(datepicker_start);
        $('#popstartdatepicker').trigger('keyup');
    });

    $('#popstartdatepicker').click(function () {
        window.datepicker_start = $(this).val();
        $('#startdatemodal').modal('show');
    });

    $('#enddatemodal .button-cancel').click(function () {
        $('#popenddatepicker').val(datepicker_end);
        $('#popenddatepicker').trigger('keyup');
    });

    $('#popenddatepicker').click(function () {
        window.datepicker_end = $(this).val();
        $('#enddatemodal').modal('show');
    });

    $('#next-step').click(function () {
        $('#finalizetab').trigger('click');
    });

    $(document).on('click', '.funnel-contest__action', function(e){
        $('.action__list-details').show();
        $('.action__list-controls').hide();
        $(this).parents('.action').find('.action__list-details').hide();
        $(this).parents('.action').find('.action__list-controls').show();
    });

    $('.dropdown-menu_status a').click(function () {
        var status_tag = $(this).html();
        $('.button-status').html(status_tag);
    });

    drawPiCharts(".knob");

    $(".contest-per-page .action__link").click(function () {
        $(".contest-per-page .action__link").removeClass("active");
        $(this).addClass("active");
    });

    $(".contest-page .action__link").click(function () {
        $(".contest-page .action__link").removeClass("active");
        $(this).addClass("active");
    });
});


function drawPiCharts(selector) {
    $(selector).each(function () {
        var elm = $(this);
        var color = elm.attr("data-fgColor");
        var perc = elm.attr("value");
        elm.knob({
            readOnly: true,
            dynamicDraw: true,
            displayInput: true,
            autocomplete: false,
            tickColorizeValues: true,
            draw: function () {
                   console.log(this.i);
                $(this.i).css('display', 'none');
//                    $(this.i).val(this.cv + '%');
                $(this.i).next('.knob_p').remove();
                $(this.i).after('<span class="knob_p"><span style="color:'+color+'">' + perc + '</span><span>%</span></span>');

                // if($(elm).attr("value") == "0") {
                //     $(this.i).after('<span class="knob_p"><span style="color:'+color+'">N/A</span><span>%</span></span>');
                // }else {
                //     $(this.i).after('<span class="knob_p"><span style="color:'+color+'">' + perc + '</span><span>%</span></span>');
                // }
            }
        });
        $({value: 0}).animate({value: perc}, {
            duration: 1000,
            easing: 'swing',
            progress: function () {
                elm.val(Math.ceil(this.value)).trigger('change')
            }
        });
    });
}

$(function() {
    $('#popstartdatepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: false,
        // "autoUpdateInput": false,
        alwaysShowCalendars:true,
        parentEl: ".dd-start-parent",
        "locale": {
            "daysOfWeek": [
                "S",
                "M",
                "T",
                "W",
                "T",
                "F",
                "S"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ]
        },
    },function (start) {
        //console.log(start.format('YYYY-MM-DD'));
    }).on('hide.daterangepicker', function(ev, picker) {
        $('.dd-start-parent .daterangepicker').show();
    });
    $('#popenddatepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: false,
        // "autoUpdateInput": false,
        dateFormat: 'dd-mm-yy',
        alwaysShowCalendars:true,
        parentEl: ".dd-end-parent",
        "locale": {
            "daysOfWeek": [
                "S",
                "M",
                "T",
                "W",
                "T",
                "F",
                "S"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ]
        },
    },function (start) {
        //console.log(start.format('YYYY-MM-DD'));
    }).on('hide.daterangepicker', function(ev, picker) {
        $('.dd-end-parent .daterangepicker').show();
    });
});
