/**
 * Created by Jazib on 08/09/2017.
 */

// $('.modal#google-analysis').on('hidden.bs.modal', function (e) {
//     $('body').addClass('modal-open');
// });
// $('.modal#ip-block').on('hidden.bs.modal', function (e) {
//     $('body').addClass('modal-open');
// });
$('.modal').on('hidden.bs.modal', function () {
    $('body').removeClass('modal-open');
});



$(window).on("load",function(){
    $(".referral").mCustomScrollbar({
        //        axis:"yx",
        theme:"dark",
        autoExpandScrollbar: true,
        mouseWheel:{ scrollAmount: 300 }
    });
   /* $(".mcustom__scroll").mCustomScrollbar({
        axis:"y",
        theme:"dark",
        autoExpandScrollbar: true,
        mouseWheel:{ scrollAmount: 300
        },
        callbacks:{
            onOverflowY: function(){
                $("#ip-block").addClass("overflow__y");
            }
        }
    });*/

});

//var start = moment().subtract(29, 'days');
var start = moment().tz('America/Los_Angeles').subtract(29, 'days');
var init_start = start;
//var end = moment();
var end = moment().tz('America/Los_Angeles');
// console.log(start.format('YYYY-MM-DD HH:mm Z'));
// console.log(end.format('YYYY-MM-DD HH:mm Z'));
var init_end = end;
var stats_data = null;
// var ctx = document.getElementById("myChart");
// window.myChart = null;
var dateFormat = "MM/DD/YYYY";
var mysqDateFormat = "YYYY/MM/DD";

$(function() {

    $(document).on('click' , '.remove-recipient', function(){
        $(this).parents('.lp-table-item').find('.lp-table__list').slideUp();
        $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideDown();
    });
    $(document).on('click' , '.lp-table_no', function(){
        $(this).parents('.lp-table-item').find('.lp-table__list').slideDown();
        $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideUp();
    });
    $(document).on('click' , '.lp-table_yes', function(e){
        e.preventDefault();
        $(this).parents('.lp-table-item').find('.lp-table__list').slideDown();
        $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideUp();
    });

    var amIclosing = false;
    $('.select2__device-type').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__device-type-parent')
    }).on('select2:openning', function() {
        jQuery('.select2__device-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__device-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__device-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__device-type-parent .select2-dropdown').hide();
        jQuery('.select2__device-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__device-type-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__device-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__device-type').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__device-type-parent .select2-selection__rendered').show();
        jQuery('.select2__device-type-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2__datatype').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__datatype-parent')
    }).on('select2:openning', function() {
        jQuery('.select2__datatype-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__datatype-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__datatype-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__datatype-parent .select2-dropdown').hide();
        jQuery('.select2__datatype-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__datatype-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__datatype-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__datatype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__datatype-parent .select2-selection__rendered').show();
        jQuery('.select2__datatype-parent .select2-results__options').css('pointer-events', 'none');
    });

    jQuery.validator.addMethod("ipvalid", function(value, element) {

        if (/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/.test(value))
        {
            return true;
        }
        return false;
    }, 'Please enter a valid IP address.');

    var $form = $(".ip-block-form"),
        $successMsg = $(".alert");
    validator = $form.validate({
        rules: {
            ip_name: {
                required: true,
            },
            ip_address: {
                required: true,
                ipvalid:true
            }
        },
        messages: {
            ip_name: {
                required: "Please enter the IP name."
            },
            ip_address: {
                required: "Please enter the IP address."
            }
        },
        submitHandler: function() {
            $form.submit();
        }
    });
    var $form = $(".google-form"),
        $successMsg = $(".alert");
    $form.validate({
        rules: {
            google_anal: {
                required: true,
            },
        },
        messages: {
            google_anal: {
                required: "Please enter the google tracking ID."
            }
        },
        submitHandler: function() {
            $form.submit();
        }
    });

    $('.dropdown-toggle li').click(function () {
        $(this).parents('.dropdown-toggle').find('.displayText').html( $(this).html() );
        $(this).parents('.dropdown-toggle').attr( 'data-value', $(this).attr('data-value') );

        if($(this).parents('.dropdown-toggle').hasClass('device-dropdown')){
            $(".statsSummary").addClass('hide');
            $(".stats_"+$(this).attr('data-value')).removeClass('hide');
            Stats.updateChart();
        }

        if($(this).parents('.dropdown-toggle').hasClass('display-dropdown')){
            Stats.updateChart();
        }
    });

    function cb(start, end) {
        $('#reportrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+start.format(dateFormat) + ' - ' + end.format(dateFormat)+"<span class='caret'></span>");

        $('#startDate').val(start.format(mysqDateFormat));
        $('#endDate').val(end.format(mysqDateFormat));

        $('#start-date').val(start.format(dateFormat));
        $('#end-date').val(end.format(dateFormat));
    }
    /*$('.daterangepicker li').click(function () {
        alert('sss');s
    });*/
    // Date Range Buttons CTA
    $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            parentEl:'.data-range',
            ranges: {
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'previous Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        },
        function(start, end) {
            cb(start, end);

            var post_data = { hash: $("#clicked_by").val(), start_date: $("#startDate").val(), end_date: $("#endDate").val()};
            $('#start-date').val( start.format(dateFormat) );
            $('#end-date').val(  end.format(dateFormat) );

            Stats.getStatsInfo(post_data, 'total')
        });

    // $("#reportrange").mouseenter(function(){
    //     $(this).trigger('click');
    // });
    // $(".data-range > .daterangepicker").mouseleave(function(){
    //     $("#reportrange").trigger('click');
    // });

    $(".daterangepicker .applyBtn").click(function(e){
        var post_data = { hash: $("#clicked_by").val(), start_date: $("#startDate").val(), end_date: $("#endDate").val()};

        var sd = new Date($("#startDate").val());
        var sdate = $("#start-date").val();

        var ed = new Date($("#endDate").val());
        var edate = $("#end-date").val();

        var stat_implementation_date = new Date("2017-10-31");
        if( (stat_implementation_date < sd == false) || (stat_implementation_date < ed == false) ){
            $("#modal_statsWarning").modal("show");
        } else {
            $('#reportrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+sdate + ' - ' + edate+"<span class='caret'></span>");
            $("div.ranges").find("li").removeClass("active");

            Stats.getStatsInfo(post_data, 'total')
        }
    });

    $(".daterangepicker .cancelBtn").click(function(e){
        cb(start, end);
        $('#start-date').val( start.format(dateFormat) ).trigger("keyup");
        $('#end-date').val(  end.format(dateFormat) ).trigger("keyup");
        //     // $('#reportrange').data('daterangepicker').setStartDate(start.format(dateFormat));
        //     $('#start-date').val(start.format(dateFormat));
        //     $('#end-date').val(end.format(dateFormat));
        //     $('#reportrange').data('daterangepicker').setStartDate(start.format(dateFormat));
        //     $('#reportrange').data('daterangepicker').setEndDate(start.format(dateFormat));
    });

    cb(start, end);


    $('#start-date').daterangepicker({
            autoUpdateInput:true,
            singleDatePicker: true,
            showDropdowns: true,
            parentEl:'.date-wrapper',
            opens:'down',
            locale: {
                format: dateFormat
            }
        },
        function(start, end, label) {
            cb(start, end);
            $('li').removeClass('active');
            $('#start-date').val(start.format(dateFormat));
            $('#startDate').val(start.format(mysqDateFormat));

            $('#reportrange').data('daterangepicker').setStartDate(start.format(dateFormat));
        }
    );

    $('#end-date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            parentEl:'.date-wrapper',
            opens:'down',
            locale: {
                format: dateFormat
            }
        },
        function(start, end, label) {
            $('li').removeClass('active');
            $('#end-date').parent().addClass('active');
            $('#end-date').val(start.format(dateFormat));
            $('#endDate').val(start.format(mysqDateFormat));

            $('#reportrange').data('daterangepicker').setEndDate(start.format(dateFormat));
        }
    );

    $("#end-date").on('apply.daterangepicker', function(ev, picker){
        var startDate = $('#startDate').val();
        var endDate  = $('#endDate').val();
        $('#reportrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+startDate+' - '+endDate+"<span class='caret'></span>");
    });

    $(".statsInnerPopupCta").click(function(e){
        e.preventDefault();
        Stats.init( $(this) );
    });

    $(".google_code_cta").click(function(e){
        $.ajax( {
            type : "POST",
            data: { gaorigdomain: $("#google_domain").val(), gaclient_id: $("#google_clientid").val(), gaurlkey: $("#google_tracking").val() },
            url : "/lp/stats/savegoogleanalytics",
            error: function (e) {
                $("#google_tracking").val('Your request was not processed. Please try again.');
            },
            success : function(rsp) {

                $('#google-analysis').modal('toggle');

            },
            always: function(d) { },
            cache : false,
            async : true
        });
    });

    $(".google-delete").click(function(e){
        $.ajax( {
            type : "POST",
            data: { gaorigdomain: $("#google_domain").val(), gaclient_id: $("#google_clientid").val(), gaurlkey: $("#google_tracking").val() },
            url : "/lp/stats/deletegoogleanalytics",
            error: function (e) {
                $("#google_tracking").val('Your request was not processed. Please try again.');
            },
            success : function(rsp) {


                $('#google-analysis').modal('toggle');


            },
            always: function(d) { },
            cache : false,
            async : true
        });
    });

    $(".block_ip_cta").click(function(e){
        if($("#ip_name").val() != ""  && $("#ip_address").val() != ""){
            $.ajax( {
                type : "POST",
                data: { hash: $("#funnel_hash").val(), ip_name: $("#ip_name").val(), ip_address: $("#ip_address").val(), action:$("#ip_action").val(), id:$("#ip_id").val() },
                url : "/lp/stats/blockipaddress",
                dataType : "json",
                error: function (e) {
                },
                success : function(rsp) {
                    if(rsp.response == 'added'){
                        $(".blocked-list").append(rsp.html);
                    }

                    else if(rsp.response == 'updated'){
                        $(".ip_row_"+rsp.id+' .ip_name').html( $("#ip_name").val() );
                        $(".ip_row_"+rsp.id+' .ip_address').html( $("#ip_address").val() );
                    }

                    resetBlockIpForm();
                },
                always: function(d) { },
                cache : false,
                async : true
            });
        }
    });
    $(".google-analytics").click(function(){
        if($("#google_tracking").val()!=""){
            $(".google-delete").removeClass("hidden");

        }else{
            $(".google-delete").addClass("hidden");

        }

    });

    function resetBlockIpForm(){
        $("#ip_name").val('');
        $("#ip_address").val('');
        $("#ip_action").val('add');
        $("#add").val('');
        $("#ip_id").val('');
        $(".block_ip_cta").val('Block IP');
        $(".modal-content").find(".form-control.error").removeClass("error");
    }
    $(".ip-block").click(function () {
        resetBlockIpForm();
        validator.resetForm();
    });

    $(document).on('click', ".edit_ip" , function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $("#ip_name").val( $(".ip_row_"+id).find('.ip_name').html() );
        $("#ip_address").val( $(".ip_row_"+id).find('.ip_address').html() );
        $("#ip_action").val('update')
        $("#ip_id").val(id)
        $(".block_ip_cta").val('Update');
    });

    $(document).on('click', ".delete_ip" , function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $("#action_confirmDeleteIp").val(id);
        $('#modal_confirmDeleteIp').modal('show');
    });

    $('#modal_confirmDeleteIp').on('show.bs.modal', function (e) {
        $(".btnAction_confirmDeleteIp").click(function(){
            var data_id = $("#action_confirmDeleteIp").val();
            $.ajax( {
                type : "POST",
                data: { id: data_id, hash: $("#funnel_hash").val() },
                url : "/lp/stats/deleteblockipaddress",
                dataType : "json",
                error: function (e) {
                },
                complete : function(rsp) {
                    $(".ip_row_"+data_id).remove();
                    $('#modal_confirmDeleteIp').modal('toggle');

                    resetBlockIpForm()
                },
                always: function(d) { },
                cache : false,
                async : true
            });
        })
    });

    $('#modal_confirmDeleteIp').on('hidden.bs.modal', function (e) {
        $("#action_confirmDeleteIp").val("");
        $(".btnAction_confirmDeleteIp").unbind('click');
    });


//    high chart js work
    var statsChart = Highcharts.chart('myhighchart', {
        chart: {
            type: 'areaspline',
            plotBorderWidth: 1,
            height: 400,
        },
        title: {
            text: ''
        },
        legend: {
            enabled: false,
        },
        xAxis: {
            lineColor: '#02abec',
            lineWidth: 1,
            gridLineWidth: 1,
            categories: [
                '10 / 27/ 2020',
                '10 / 28 / 2020',
                '10 / 29 / 2020',
                '10 / 30 / 2020',
                '11 / 01 / 2020',
                '11 / 02 / 2020',
                '11 / 03 / 2020',
                '11 / 04 / 2020',
                '11 / 05 / 2020'
            ],
            tickmarkPlacement: 'on',
            // tickPosition:"inside",
            plotBands: [{ // visualize the weekend
                // from: 4.5,
                // to: 6.5,
                // color: 'rgba(68, 170, 213, .2)'
            }],
            crosshair: {
                width: 1,
                color: '#262d37',
                dashStyle: 'Dash'
            },
            labels:{
                y: 30,
                style: {
                    color: '#85969f',
                    fontSize: '14px',
                    fontWeight: '400',
                    fontFamily:'"Open Sans", "Arial", "Helvetica Neue", "Helvetica", sans-serif',
                },
                formatter: function(){
                    if(this.pos > 0 && this.pos < 8){
                        var days = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
                        var d = new Date(this.value);
                        var dayName = days[d.getDay()];
                        return dayName;
                    } else{
                        return "";
                    }
                }
            }
            // tickPositioner: function () {
            //     var positions = [],
            //         tick = Math.floor(this.dataMin),
            //         increment = Math.ceil((this.dataMax - this.dataMin) / 6);
            //
            //     if (this.dataMax !== null && this.dataMin !== null) {
            //         for (tick; tick - increment <= this.dataMax; tick += increment) {
            //             positions.push(tick);
            //         }
            //     }
            //     return positions;
            // },
            // labels: {
            //     align:'left',
            //
            // },
            // tickmarkPlacement:'on',
        },
        yAxis: {
            labels:{
                x: -20,
                style: {
                    color: '#85969f',
                    fontSize: '14px',
                    fontWeight: '400',
                    fontFamily:'"Open Sans", "Arial", "Helvetica Neue", "Helvetica", sans-serif',
                },
            },
            title: {
                text: ''
            }
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
                "font-weight": "bold",
            },
            formatter: function() {
                if(this.point.index == 0 || this.point.index == 8)
                    return false;
                else
                    return '<div class="chart-tooltip-wrapper">'+
                        '<span class="point-date">'+this.x+'</span>'+
                        '<span class="point-year">'+this.y+'</span>'
                '<div>';
            },
            // positioner: function(labelWidth, labelHeight, point) {
            //     var tooltipX = point.plotX - 50;
            //     var tooltipY = point.plotY - 55;
            //     return {
            //         x: tooltipX,
            //         y: tooltipY
            //     };
            // }
        },
        credits: {
            enabled: false
        },
        rangeSelector: {
            // selected : 1,
            enabled: false
        },
        plotOptions: {
            series: {
                lineWidth: 4,
                color: '#02abec',
                fillColor: 'rgba(2, 171, 236, 0.25)',
                states: {
                    hover: {
                        enabled: true,
                        lineWidth: 4
                    }
                },
                marker: {
                    radius: 6,
                    fillColor: '#FFFFFF',
                    lineWidth: 4,
                    lineColor: null, // inherit from series
                    states: {
                        hover: {
                            enabled: true,
                            lineWidth: 10,
                            fillColor: '#02abec',
                            lineColor: '#FFFFFF',
                        }
                    },
                },
                pointPlacement: 'on',
            },
            areaspline: {
                fillOpacity: 0.5
            },
        },
        series: [{
            name: 'John',
            data: [50, 70, 50, 20, 30, 55, 80, 85, 92],

        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 428
                },
            }]
        },
        exporting: { enabled: false },
    });

  /*function (chart) {
        $.each(chart.series[0].data, function (i, point) {
            if(i == 0 || i == 8) {
                this.graphic.destroy();
            }
        });
    }*/

  /* abubakar added this code to make the animtion work on date dropdown */
    $('#reportrange').on('show.daterangepicker', function(ev, picker) {
        $(this).parents('.data-range').find('.daterangepicker').addClass('date-active');
    });
    $('#reportrange').on('hide.daterangepicker', function(ev, picker) {
        $(this).parents('.data-range').find('.daterangepicker').removeClass('date-active');
    });
});

var Stats = {

    init: function(elem){
        $("#clicked_by").val( elem.data('hash') );
        $("#startDate").val( init_start.format(mysqDateFormat) );
        $("#endDate").val( init_end.format(mysqDateFormat) );


        $('#reportrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+init_start.format(dateFormat) + ' - ' + init_end.format(dateFormat)+"<span class='caret'></span>");
        $(".device-dropdown").attr('data-value', 'total');

        $(".device-dropdown").find('.displayText span').html('All');
        $('#start-date').val( init_start.format(dateFormat) );
        $('#start-date').data('daterangepicker').setStartDate(init_start);

        $('#start-date').data('daterangepicker').setEndDate(init_start);
        $('#end-date').val(  init_end.format(dateFormat) );
        $('#end-date').data('daterangepicker').setStartDate(init_end);
        $('#end-date').data('daterangepicker').setEndDate(init_end);

        var post_data = { hash: elem.data('hash'), start_date: init_start.format(mysqDateFormat), end_date: init_end.format(mysqDateFormat) };
        Stats.getStatsInfo(post_data, 'total')
    },
    getStatsInfo: function(post_data, stats_level){
        var notifyElem = $(".stats_model_notification");
        notifyElem.html('Loading...').removeClass('hide');
        $(".reportContent").addClass('hide');
        $('#stats').modal('show');

        $.ajax( {
            type : "POST",
            data: post_data,
            dataType: 'json',
            url : "/lp/stats/index",
            error: function (e) {
                notifyElem.html('Your request was not processed. Please try again.').removeClass('hide').addClass('alert-warning');
            },
            success : function(rsp) {
                stats_data = rsp;
                notifyElem.html('').addClass('hide');
                $(".reportContent").removeClass('hide');

                $("#google_tracking").val(rsp.metrics.meta.google_tracking);

                $("#google_domain").val(rsp.metrics.meta.google_domain);
                $("#google_clientid").val(rsp.metrics.meta.client_id);
                $("#funnel_hash").val(rsp.metrics.meta.hash);

                $(".device-dropdown").attr('data-value', 'total');
                $(".device-dropdown").find('.displayText span').html('All');

                // Setting Summary Stats
                $(".statsSummary").addClass('hide');
                $(".stats_"+stats_level).removeClass('hide');

                // this is causing an error, for now i am commenting this one.... fix this issue and uncomment (Jazib)

                if(rsp.video.wistia_id){
                    var ele=$("#stats #stats-lp-video");
                    ele.attr("data-lp-wistia-title",rsp.video.title);
                    ele.attr("data-lp-wistia-key",rsp.video.wistia_id);
                    ele.css("display","inline-block");
                }
                $.each(rsp['stats'], function( stats_level, stats ) {
                    $.each(stats, function( key, value ) {
                        if(key == 'conversion'){
                            $(".stats_"+stats_level).find('.'+key).html(value + "%");
                        } else {
                            $(".stats_"+stats_level).find('.'+key).html(value);
                        }
                    });
                });

                var customTooltips = function(tooltip) {
                    var tooltipEl = document.getElementById('chartjs-tooltip');
                    if (!tooltipEl) {
                        tooltipEl = document.createElement('div');
                        tooltipEl.id = 'chartjs-tooltip';
                        tooltipEl.innerHTML = "<table></table>";
                        this._chart.canvas.parentNode.appendChild(tooltipEl);
                    }

                    // Hide if no tooltip
                    if (tooltip.opacity === 0) {
                        tooltipEl.style.opacity = 0;
                        return;
                    }

                    // Set caret Position
                    tooltipEl.classList.remove('above', 'below', 'no-transform');
                    if (tooltip.yAlign) {
                        //tooltipEl.classList.add(tooltip.yAlign);
                        tooltipEl.classList.add('above');
                    } else {
                        tooltipEl.classList.add('no-transform');
                    }

                    function getBody(bodyItem) {
                        return bodyItem.lines;
                    }

                    // Set Text
                    if (tooltip.body) {
                        var titleLines = tooltip.title || [];
                        var bodyLines = tooltip.body.map(getBody);

                        var innerHtml = '<tbody>';
                        titleLines.forEach(function(title) {
                            var td = new Date(title);
                            innerHtml += '<tr class="chartjs-row"><td class="pr"><div class="stat-date">Date <br />' + ("0" + (td.getMonth() + 1)).slice(-2) + "-" + ("0" + td.getDate()).slice(-2) + "-" + td.getFullYear() + '</div></td>';
                        });

                        bodyLines.forEach(function(body, i) {
                            var arr = body[0].split(":");
                            var arrType = arr[0].split(" / ");

                            if(arrType[0] == "Conversion Rate")
                                var statNum = arr[1]+"%";
                            else
                                var statNum = arr[1];

                            innerHtml += '<td class="chartjs-stat pl">' + statNum + '</td></tr>';
                        });
                        innerHtml += '</tbody>';

                        var tableRoot = tooltipEl.querySelector('table');
                        tableRoot.innerHTML = innerHtml;
                    }

                    var positionY = this._chart.canvas.offsetTop - 92;
                    var positionX = this._chart.canvas.offsetLeft - 2;

                    // Display, position, and set styles for font
                    tooltipEl.style.opacity = 1;
                    tooltipEl.style.left = positionX + tooltip.caretX + 'px';
                    tooltipEl.style.top = positionY + tooltip.caretY + 'px';
                    tooltipEl.style.fontSize = tooltip.fontSize;
                    tooltipEl.style.fontStyle = tooltip._fontStyle;
                    tooltipEl.style.padding = '10px 10px';
                };

                if (myChart) myChart.chart.destroy();
                // Rendering Data on Chart
                var display_unit = rsp['metrics']['meta']['x_display_unit'];
                window.myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: [{
                            showLine: "true",
                            label: "",
                            data: [],
                            backgroundColor:"rgba(25,89,117,0.4)",
                            borderWidth:3,
                            borderColor:"rgba(0,170,237,1)",
                            pointBorderColor:"#fff",
                            pointStyle:'circle',
                            pointRadius: 3,
                            pointHoverRadius:6,
                            pointHoverBorderWidth:6,
                            scaleLineWidth : 20,
                            pointDotStrokeWidth : 5,
                        }],
                        labels: rsp['metrics']['meta']['x_labels']
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    fontColor: '#acbdc9',
                                    fontSize: 15,
                                    stacked:true,
                                    beginAtZero:true,
                                    //min: 0,
                                    //max: 100,
                                    //stepSize: 20
                                }
                            }],
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: display_unit,
                                    displayFormats: {
                                        'day': 'MM-DD-YYYY',
                                        'week': 'MM-DD-YYYY',
                                        'month': 'MM-YYYY',
                                        'quarter': 'MM-YYYY',
                                        'year': 'YYYY'
                                    }
                                },
                                ticks: {
                                    fontColor: '#acbdc9',
                                    fontSize: 15,
                                    bounds: 'ticks'
                                }
                            }]
                        },
                        tooltips: {
                            enabled: false,
                            mode: 'index',
                            position: 'nearest',
                            caretSize: 8,
                            custom: customTooltips
                        },
                        legend: {
                            display: false,
                            labels: {
                                fontColor: '#acbdc9',
                                fontSize: 15
                            }
                        }
                    }
                });

                console.log("before update");
                Stats.updateChart();
                Stats.load_blocked_ip_list();
            },
            always: function(d) { },
            cache : false,
            async : true
        });
    },
    updateChart: function(){
        var chart_data = [];
        var device = $(".device-dropdown").attr('data-value');
        var data_type = $(".display-dropdown").attr('data-value');
        var device_label = $(".device-dropdown").find('.displayText span').html();
        var device_type = $(".device-list").find("[data-label='" + device_label + "']").attr('data-value');
        var deviceLabel = (device_type == 'total' ? 'All Devices' : (device_type == 'mobile' ? 'Tablet/Smartphone' : 'Desktop'));
        var chart_label = $(".display-dropdown").find('.displayText span').html() +" / "+ deviceLabel;
        //  var chart_label = $(".display-dropdown").find('.displayText span').html() +" / "+ $(".device-dropdown").find('.displayText span').html() +" Device(s)";

        var maxVal = 0;
        $.each(stats_data['metrics']['data'], function( i, stats ) {
            val = stats[device][data_type];
            if(maxVal < val) maxVal = val;
            chart_data.push(stats[device][data_type]);
        });

        console.log(chart_data);
        myChart.data.datasets[0].data = chart_data;
        myChart.data.datasets[0].label = chart_label;

        var stepSize =  Math.round(maxVal / 10);
        if(stepSize == 0) stepSize = 1;
        // console.log("MaxVal "+maxVal+" >> StepSize "+stepSize);

        var numOfStep = Math.round(maxVal / stepSize);
        if(numOfStep < 4) numOfStep = 4;
        numOfStep += 1;
        maxVal = (stepSize * numOfStep)
        // console.log(numOfStep+" >> "+maxVal);

        myChart.options.scales.yAxes[0].ticks.min = 0;
        myChart.options.scales.yAxes[0].ticks.max = maxVal;
        myChart.options.scales.yAxes[0].ticks.stepSize = stepSize;

        myChart.update();
    },
    load_blocked_ip_list:function (){
        $.ajax( {
            type : "POST",
            data: { hash: $("#funnel_hash").val() },
            url : "/lp/stats/blockipaddresslist",
            dataType : "json",
            error: function (e) {
            },
            success : function(rsp) {
                $(".blocked-list").html(rsp.html);
                Stats.resetBlockIpForm();
            },
            always: function(d) { },
            cache : false,
            async : true
        });
    },
    resetBlockIpForm: function(){
        $("#ip_name").val('');
        $("#ip_address").val('');
        $("#ip_action").val('add');
        $("#add").val('');
        $("#ip_id").val('');
        $(".block_ip_cta").val('Block IP');
    }
};