/**
 * Created by Saif on 11/26/2019.
 */

//var start = moment().subtract(29, 'days');
var start_sb = moment().tz('America/Los_Angeles').subtract(29, 'days');
var init_start_sb = start_sb;
//var end = moment();
var end_sb = moment().tz('America/Los_Angeles');
// console.log(start.format('YYYY-MM-DD HH:mm Z'));
// console.log(end.format('YYYY-MM-DD HH:mm Z'));
var init_end_sb = end_sb;
var stats_data_sb = null;
// var ctx = document.getElementById("myChart");
window.myChart = null;
var dateFormat = "MM / DD / YYYY";
var mysqDateFormat = "YYYY-MM-DD";

// lp stickbar stats report popshow

$(document).ready(function () {
    $('body').on('click','.lp-stickybar__item_stats', function(){
        // $('body').addClass('modal-open');
        $("#stats_v2").modal('show');
    });

    $(document).on('click','.btn__close-sb-modal', function(){
        console.info("sdad");
        $(document).find("#Overview").addClass('active in');
        $(document).find("#urlreport").removeClass('active in');
        $(document).find(".stickybar-stats__tabs li").removeClass('active');
        $(document).find(".stickybar-stats__tabs li").eq(0).addClass('active');
    });




});




/*$('#stats_v2').on('hidden.bs.modal', function () {
    // $('body').removeClass('modal-open');
});*/

// Date range picker

function cb(start, end) {
    // $('#reportrange_v2 span').html('<id class="fa fa-calendar cal-size" aria-hidden="true"></id>'+start.format(dateFormat) + ' - ' + end.format(dateFormat)+"<span class='caret'></span>");

    // $('#startDatev2').val(start.format(mysqDateFormat));
    // $('#endDatev2').val(end.format(mysqDateFormat));
}
$('.daterangepicker_sb li').click(function () {
});
// Date Range Buttons CTA

$('#reportrange_v2').daterangepicker({
    startDatev2: start,
    endDatev2: end,
    parentEl:'.date-range-selector__wrapper',
    ranges: {
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Previous Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, function(start, end) {
    // cb(start, end);
    // var post_data = { hash: $("#clicked_by_sb").val(), start_date: $("#startDatev2").val(), end_date: $("#endDatev2").val()};
    // $('#start-date').val( start.format(dateFormat) );
    // $('#end-date').val(  end.format(dateFormat) );
    // Stats.getStatsInfo(post_data, 'total')
});



/*$(".daterangepicker .applyBtn").click(function(e){
    var post_data = { hash: $("#clicked_by").val(), start_date: $("#startDatev2").val(), end_date: $("#endDatev2").val()};

    var sd = new Date($("#startDatev2").val());
    var sdate = $("#start-date").val();

    var ed = new Date($("#endDatev2").val());
    var edate = $("#end-date").val();

    var stat_implementation_date = new Date("2017-10-31");
    if( (stat_implementation_date < sd == false) || (stat_implementation_date < ed == false) ){
        $("#modal_statsWarning").modal("show");
    } else {
        $('#reportrange_v2 span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+sdate + ' - ' + edate+"<span class='caret'></span>");
        $("div.ranges").find("li").removeClass("active");

        Stats.getStatsInfo(post_data, 'total')
    }
});*/


// cb(start, end);


$('#start-date').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    parentEl:'.date-wrapper',
    opens:'down',
    locale: {
        format: dateFormat
    }
});
// function(start, end, label) {
//     $('li').removeClass('active');
//     $('#start-date').val(start.format(dateFormat));
//     $('#startDatev2').val(start.format(mysqDateFormat));
//
//     $('#reportrange_v2').data('daterangepicker').setstartDatev2(start.format(dateFormat));
// }
// );

$('#end-date').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    parentEl:'.date-wrapper',
    opens:'down',
    locale: {
        format: dateFormat
    }
});
// function(start, end, label) {
//     $('li').removeClass('active');
//     $('#end-date').parent().addClass('active');
//     $('#end-date').val(start.format(dateFormat));
//     $('#endDatev2').val(start.format(mysqDateFormat));
//
//     $('#reportrange_v2').data('daterangepicker').setendDatev2(start.format(dateFormat));
// }
// );

/*
$("#end-date").on('apply.daterangepicker', function(ev, picker){
    var startDatev2 = $('#startDatev2').val();
    var endDatev2  = $('#endDatev2').val();
    $('#reportrange_v2 span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+startDatev2+' - '+endDatev2+"<span class='caret'></span>");
});
*/

var Stats_sb = {
    init: function(elem){
        $("#clicked_by").val( elem.data('hash') );
        $("#startDatev2").val( init_start.format(mysqDateFormat) );
        $("#endDatev2").val( init_end.format(mysqDateFormat) );

        // $('#reportrange_v2 span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+init_start.format(dateFormat) + ' - ' + init_end.format(dateFormat)+"<span class='caret'></span>");
        /*$(".device-dropdown").attr('data-value', 'total');
        $(".device-dropdown").find('.displayText span').html('All');*/

        /*$('#start-date').val( init_start.format(dateFormat) );
        $('#start-date').data('daterangepicker').setStartDate(init_start);
        $('#start-date').data('daterangepicker').setEndDate(init_start);

        $('#end-date').val(  init_end.format(dateFormat) );
        $('#end-date').data('daterangepicker').setStartDate(init_end);
        $('#end-date').data('daterangepicker').setEndDate(init_end);*/

        var post_data = { hash: elem.data('hash'), start_date: init_start.format(mysqDateFormat), end_date: init_end.format(mysqDateFormat) };
        Stats_sb.getStatsInfo(post_data, 'total')
    },
    getStatsInfo: function(post_data, stats_level){
        var notifyElem = $(".stats_model_notification_v2");
        notifyElem.html('Loading...').removeClass('hide');
        $(".reportContent_v2").addClass('hide');
        $('#stats_v2').modal('show');
        notifyElem.html('').addClass('hide');
        $(".reportContent_v2").removeClass('hide');

        /*$(".device-dropdown").attr('data-value', 'total');
        $(".device-dropdown").find('.displayText span').html('All');*/

    }
}
