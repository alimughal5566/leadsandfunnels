/*
* Statistics code
*****************
* Usage:    Used in statistics.blade.php
* Chart used in this Component is HighChart (https://www.highcharts.com/)
* *********************************************************************** */

/*
* Deep copy an object/array
* */
function deepCopy(obj){
    return JSON.parse(JSON.stringify(obj));
}

function isValidIp(value){
    if (/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/.test(value)){
        return true;
    }
    return false;
}

let requesting = false;
let statsAjaxRequest = null;

var global = {
    weekView : false,
    chartSize : [],
    chart : null,
    devicesTypes : ['total', 'desktop', 'mobile'],
    selectedDeviceType : 'total',
    filters : ['visits', 'leads', 'conversion'],
    selectedFilter : 'conversion',
    stats : {
        total : { visits:0, leads:0, conversion:0, new_leads:0, current_week_visitor:0, current_month_visitor:0 },
        desktop : { visits:1, leads:1, conversion:1, new_leads:1, current_week_visitor:1, current_month_visitor:1 },
        mobile : { visits:2, leads:2, conversion:2, new_leads:2, current_week_visitor:2, current_month_visitor:2 }
    },
    catagories:[],
    seriesData:[],
    filteredStat:this.initFilteredStat(),
    blockedList:[],
    weekList: [30,31,32,33],
    /*
    * Initialize Page data
    * */
    init: function(){
        $("#clicked_by").val( hash );
        $("#startDate").val( init_start.format(mysqDateFormat) );
        $("#endDate").val( init_end.format(mysqDateFormat) );
        $('#reportrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+init_start.format(dateFormat) + ' - ' + init_end.format(dateFormat)+"<span class='caret'></span>");
        $(".device-dropdown").attr('data-value', 'total');
        $(".device-dropdown").find('.displayText span').html('All');
        $('#start-date').val( init_start.format(dateFormat) );
        $('#end-date').val(  init_end.format(dateFormat) );

        var post_data = {
            hash: hash,
            start_date: init_start.format(mysqDateFormat),
            end_date: init_end.format(mysqDateFormat)
        };
        this.getStatsInfo(post_data, 'total')
    },
    getStatsInfo: function(post_data){
        $('#stats').modal('show');
        statsAjaxRequest = $.ajax( {
            type : "POST",
            data: post_data,
            dataType: 'json',
            url : "/lp/stats/index",
            beforeSend : function()    {
                if(statsAjaxRequest != null) {
                    statsAjaxRequest.abort();
                }
            },
            error: function (e) {
                if(e.statusText !== "abort"){
                    let message = 'Your request was not processed. Please try again.';
                    displayAlert('danger', message);
                }
                else{
                    // $(".ct-group").html('');
                    // $(".ct-group").remove();
                }
            },
            success : function(rsp) {
                $(".ct-group").html('');
                stats_data = rsp;
                $("#funnel_hash").val(rsp.metrics.meta.hash);

                $('#device_type').val('total');
                $('#device_type').trigger('change');

                global.stats = rsp['stats'];
                global.catagories = rsp['metrics']['meta']['x_labels'];
                global.filteredStat =global.initFilteredStat();
                /* ******************************************************************
                For testing purpose only. Adding some dummy data to render chart
                You can execute this code to test the graph if you are not getting data from back end in any case
                */
                // var limit = {
                //     total:25,
                //     desktop:20,
                //     mobile:10,
                // };
                // Object.keys(rsp['metrics']['data']).forEach(
                //     function(key) {
                //         global.devicesTypes.forEach(function (type) {
                //             global.filters.forEach(function (filterValue) {
                //                 rsp['metrics']['data'][key][type][filterValue] = Math.ceil(Math.random()*limit[type]);
                //             })
                //         })
                //     }
                // )
                /* ******************************************************************* */
                global.setFilteredStat(rsp['metrics']['data']);
                global.updateHighChart();
                global.load_blocked_ip_list();
                global.displayStats();
            },
            always: function(d) { },
            cache : false,
            async : true
        });
    },
    /*
    * Organize and set filtered stat according to required structure
    * */
    setFilteredStat:function(data){
        Object.keys(data).forEach(
            function(key) {
                global.devicesTypes.forEach(function (type) {
                    global.filters.forEach(function (filterValue) {
                        let val = parseInt(data[key][type][filterValue]);
                        global.filteredStat[type][filterValue].push(val);
                        if(global.filteredStat[type].max[filterValue]<val){
                            global.filteredStat[type].max[filterValue]= val;
                        }
                    })
                })
            }
        )
    },
    /*
    * Initialize Filtered stats object
    * */
    initFilteredStat:function(){
        var max = { visits:0, leads:0, conversion:0 };
        var initialStats = { max:deepCopy(max), visits:[], leads:[], conversion:[] };
        return {
            desktop:deepCopy(initialStats),
            mobile:deepCopy(initialStats),
            total:deepCopy(initialStats)
        }
    },
    /*
    * Determine which step size and max limit is suitable and returns its value
    * @param max > Maximum limit in the record.
    * usage global.getStepSizeAndMaxLimit(12);
    * */
    getStepSizeAndMaxLimit:function (max){
        var result = global.chartSize.find(function(size){
            return size.max>=max;
        });
        return result;
    },
    setSeriesData:function(){
        this.seriesData =[];
        this.seriesData.push({label:this.selectedFilter, data:this.filteredStat[this.selectedDeviceType][this.selectedFilter]})
    },

    createHighChart:function(){
        let max = this.filteredStat[this.selectedDeviceType].max[this.selectedFilter];
        this.setSeriesData();
        var result = this.getStepSizeAndMaxLimit( max );
        var rotate = align = '';
        if (jQuery.inArray(global.catagories.length ,global.weekList) != -1) {
            rotate = 'rotate(360deg)';
            align = 'center';
        }
       else if (global.catagories.length == 7) {
            rotate = 'rotate(360deg)';
            align = 'center';
        }
        else{
            rotate = '';
            align = 'right';
        }
        this.chart = Highcharts.chart('myhighchart', {
            chart: { type: 'areaspline', plotBorderWidth: 1 , height:400, reflow: false},
            title: { text: '' },
            legend: { enabled: false, },
            xAxis: {
                lineColor: '#02abec',
                lineWidth: 1,
                gridLineWidth: 1,
                categories: global.catagories,
                tickmarkPlacement: 'on',
                plotBands: [{ }],
                crosshair: {    width: 1,   color: '#262d37',   dashStyle: 'Dash' },
                labels: {
                    y: 30,
                    align:align,
                    style: {
                        color: '#85969f',
                        fontSize: '14px',
                        fontWeight: '400',
                        fontFamily:'"Open Sans", "Arial", "Helvetica Neue", "Helvetica", sans-serif',
                        transform: rotate
                    },
                    formatter:function(){
                        var date = new Date(this.value);
                            if (this.pos > 0 && this.pos < global.catagories.length - 1) {
                                if (global.wewekView) {
                                    return moment(this.value).format('dddd');
                                } else {
                                    if (jQuery.inArray(global.catagories.length ,global.weekList) != -1) {
                                        if (global.catagories.length == 30 && global.catagories[28] == this.value) {
                                            return moment(this.value).format('MM/DD/YYYY');
                                        }else if (global.catagories[1] == this.value || global.catagories[8] == this.value || global.catagories[15] == this.value
                                            || global.catagories[22] == this.value || global.catagories[29] == this.value) {
                                            return moment(this.value).format('MM/DD/YYYY');
                                        } else {
                                            return '';
                                        }
                                    }
                                    else{
                                        return moment(this.value).format('MM/DD/YYYY');
                                    }
                                }
                            } else {
                                return '';
                            }

                        // return (global.catagories.length<=7)?moment(this.value).format('dddd'):moment(this.value).format('MM-DD-YYYY');
                    },
                },
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
                alignTicks:false,
                min:0,
                max:result.max,
                tickInterval:result.stepSize,
                title: {
                    text: ''
                },
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
                    // var date = moment(this.x).format('dddd')+" ("+moment(this.x).format('MM-DD-YYYY')+")";
                    var date = (global.wewekView)?moment(this.x).format('dddd'):moment(this.x).format('M/D/YYYY');
                    let y = this.y || 0;
                    return '<div class="chart-tooltip-wrapper">'+
                        '<span class="point-date">'+date+'</span>'+
                        '<span class="point-year">'+y+(global.selectedFilter=='conversion' ? '%' : '')+'</span>'
                    '<div>';
                },
                // positioner: function(labelWidth, labelHeight, point) {
                //     var tooltipX = point.plotX - 50;
                //     var tooltipY = point.plotY - 55;
                //     return {
                //         x: tooltipX,
                //         y: tooltipY
                //     };
                // },
            },
            credits: {
                enabled: false
            },
            rangeSelector: {
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
            series:  this.seriesData,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 428
                    },
                }]
            },
            exporting: { enabled: false }
        }
        ,function (chart) {
                $(".highcharts-markers").find('path').eq(0).remove();
                $(".highcharts-markers").find('path').last().remove();
            $.each(chart.series[0].data, function (i, point) {
                if(i == 0 || i == global.catagories.length-1) {
                    point.visible = false;
                }
            });
        }
        );
    },
    updateHighChart:function(){
        if(!this.chart){
            this.createHighChart();
        }else{
            this.chart.destroy();
            this.createHighChart();
        }
        // $(".highcharts-markers").find('path').eq(0).remove();
        // $(".highcharts-markers").find('path').last().remove();
        // global.chart.series[0].data[0].visible = false;
        // global.chart.series[0].data[global.catagories.length-1].visible = false;
        //
        // $.each(chart.series[0].data, function (i, point) {
        //     if(i == 0 || i == global.catagories.length-1) {
        //         console.log();
        //         point.visible = false;
        //         // point.destroy();
        //     }
        // });

        // else{
        //     // var result = global.getStepSizeAndMaxLimit( global.filteredStat[global.selectedDeviceType].max[global.selectedFilter] );
        //     // console.log(result);
        //     // global.chart.axes[0].setCategories(global.catagories)
        //     // global.chart.series[0].setData(global.seriesData[0].data);
        //     // global.chart.yAxis[0].setTickInterval(result.stepSize);
        //     // global.chart.yAxis[0].setExtremes(0, result.max)
        //     // global.chart.redraw();
        //     // global.chart.render();
        // }

    },

    displayStats: function(){
        var device = global.stats[global.selectedDeviceType];
        for (var key in device) {
            // if(key !== 'conversion'){
            //     device[key] = parseFloat(device[key]).toLocaleString()
            // }
            if (device.hasOwnProperty(key)) {
                $("#"+key).html(device[key]);
            }
        }
    },
    load_blocked_ip_list:function (){
        $.ajax( {
            type : "POST",
            data: { hash: $("#funnel_hash").val() },
            url : "/lp/stats/blockipaddresslist/v3",
            dataType : "json",
            error: function (e) {
            },
            success : function(rsp) {
                if(rsp['success']){
                    global.blockedList = rsp['data'];
                    generateBlockedList();

                }
                // $(".mcustom__scroll").appendTo("asdfaf");
                global.resetBlockIpForm();
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
        $("#addUpdateIpAddress").val('Block IP');
        $(".modal-content").find(".form-control.error").removeClass("error");
    }
}

/*
* Setting up step sizes loaded from config/lp.php
* */
for (const [key, value] of Object.entries(stats_graph_steps)) {
    global.chartSize.push({stepSize:value,max:parseInt(key)});
}

/*
* Initialize Filtered stats object
* */
function initFilteredStat(){
    var max = { visits:0, leads:0, conversion:0 };
    var initialStats = { max:deepCopy(max), visits:[], leads:[], conversion:[] };
    return {
        desktop:deepCopy(initialStats),
        mobile:deepCopy(initialStats),
        total:deepCopy(initialStats)
    }
}

$('.modal').on('hidden.bs.modal', function () {
    $('body').removeClass('modal-open');
});

$(window).on("load",function(){
    global.init();

    $('#device_type').change(function(e){
        e.preventDefault();
        global.selectedDeviceType =$(this).val();
        global.displayStats();
        global.updateHighChart();

    });

    $('#chart_title').change(function(){
        global.selectedFilter =$(this).val();
        // global.displayStats();
        global.updateHighChart();

    });

    jQuery('.tooltipster').tooltipster({
        trigger: 'hover',
        animation: 'fade',
        contentAsHTML: true,
        maxWidth: 300,
        delay: 100,
        contentCloning: true,
        interactive: true
    });
});

moment.tz.setDefault("America/Los_Angeles");
var start = moment().subtract(29, 'days');
var init_start = start;
var end = moment();
var init_end = end;
var stats_data = null;
var dateFormat = "M/D/YYYY";
var mysqDateFormat = "YYYY/MM/DD";

$(function() {

    var amIclosing = false;
    $('#device_type').select2({
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
                jQuery('#device_type').select2("close");
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
        return isValidIp(value);
        }, 'Please enter a valid IP address.'
    );

    var $form1= $(".ip-block-form"),
        $successMsg = $(".alert");
    validator = $form1.validate({
        rules: {
            // ip_name: {
            //     required: true,
            // },
            ip_address: {
                // required: true,
                ipvalid:true
            }
        },
        // messages: {
        //     ip_name: {
        //         required: "Please enter the IP name."
        //     },
        //     ip_address: {
        //         required: "Please enter the IP address."
        //     }
        // },
        submitHandler: function() {
            $form1.submit();
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
            global.updateChart();
        }

        if($(this).parents('.dropdown-toggle').hasClass('display-dropdown')){
            global.updateChart();
        }
    });

    function cb(start, end) {
        $('#reportrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+start.format(dateFormat) + ' - ' + end.format(dateFormat)+"<span class='caret'></span>");

        $('#startDate').val(start.format(mysqDateFormat));
        $('#endDate').val(end.format(mysqDateFormat));

        $('#start-date').val(start.format(dateFormat));
        $('#end-date').val(end.format(dateFormat));
    }

    $('#reportrange').daterangepicker(
        {
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
            jQuery('.ranges').find('.custom-date-slide').slideUp();

        var post_data = { hash: $("#clicked_by").val(), start_date: $("#startDate").val(), end_date: $("#endDate").val()};
        $('#start-date').val( start.format(dateFormat) );
        $('#end-date').val(  end.format(dateFormat) );

        if(!end.diff(moment(), 'days') && !moment().subtract(6, 'days').diff(start, 'days') ){
            //this is a week selection
            global.wewekView = true;
        }else{
            global.wewekView = false;
        }
        displayToastAlert('loading', 'Please Wait... Processing your request...',0);
        global.getStatsInfo(post_data, 'total')
    });

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

            global.getStatsInfo(post_data, 'total')
        }
    });

    $(".daterangepicker .cancelBtn").click(function(e){
        cb(start, end);
        $('#start-date').val( start.format(dateFormat) ).trigger("keyup");
        $('#end-date').val(  end.format(dateFormat) ).trigger("keyup");
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
            // cb(start, end);
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
        global.init();
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

    $("#addUpdateIpAddress").click(function(e){
        e.preventDefault();
        addUpdateIp();

    });
    $(".google-analytics").click(function(){
        if($("#google_tracking").val()!=""){
            $(".google-delete").removeClass("hidden");

        }else{
            $(".google-delete").addClass("hidden");

        }

    });

    $(".ip-block").click(function () {
        global.resetBlockIpForm();
        validator.resetForm();
    });

    /* abubakar added this code to make the animtion work on date dropdown */
    $('#reportrange').on('show.daterangepicker', function(ev, picker) {
        $(this).parents('.data-range').find('.daterangepicker').addClass('date-active');
    });
    $('#reportrange').on('hide.daterangepicker', function(ev, picker) {
        $(this).parents('.data-range').find('.daterangepicker').removeClass('date-active');
    });

    $(document).on('click' , '.remove-recipient', function(){
        $(this).parents('.lp-table-item').find('.lp-table__list').slideUp();
        $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideDown();
        lpUtilities.scrollArea();
    });
    $(document).on('click' , '.lp-table_no', function(){
        $(this).parents('.lp-table-item').find('.lp-table__list').slideDown();
        $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideUp();
        lpUtilities.scrollArea();
    });
    $(document).on('click' , '.lp-table_yes', function(){
        if(!requesting){
            requesting = true;
            var data_id = $(this).data("id");
            console.info(data_id)
            // $('#modal_confirmDeleteIp').modal('toggle');
            $.ajax( {
                type : "POST",
                data: { id: data_id, hash: $("#funnel_hash").val() },
                url : "/lp/stats/deleteblockipaddress",
                dataType : "json",
                error: function (e) {
                    requesting = false;
                    let message ="Your request was not processed. Please try again.";
                    displayAlert('danger', message);
                },
                complete : function(rsp) {
                    requesting = false;
                    global.blockedList = global.blockedList.filter(function(list){return list.id!=data_id});
                    global.resetBlockIpForm();
                    generateBlockedList();
                    let message ="IP address has been deleted.";
                    displayAlert('success', message);
                },
                always: function(d) { },
                cache : false,
                async : true
            });
        }
    })


    // Code to slide down Custom Date Range Picker
    jQuery('.custom-date-opener').click(function () {
        if(!jQuery(this).parents('.ranges').find('li:eq(4)').hasClass('active')){
            jQuery(this).parents('.ranges').find('li').removeClass('active');
            jQuery(this).addClass('active');
            jQuery(this).parents('.ranges').find('.custom-date-slide').slideDown();
        }
    });
});


function generateHTML(record){
    let ip_name = record['ip_name'];
    let ip_address = record['ip_address'];
    let id = record['id'];

    return `<div class="lp-table-item">
            <ul class="lp-table__list ">
                <li class="lp-table__item" id="${id}_name">${ip_name}</span></li>
                <li class="lp-table__item" id="${id}_address"><span>${ip_address}</span></li>
                <li class="lp-table__item">
                    <div class="action action_options">
                        <ul class="action__list">
                            <li class="action__item">
                                <a href="#" class="action__link edit-recipient" onclick="editBlockedIp(${id})"
                                   data-id="${id}" data-text="Edit">
                                    <span class="ico ico-edit"></span>edit
                                </a>
                            </li>
                            <li class="action__item">
                                <a href="#" data-id="${id}" class="action__link remove-recipient">
                                    <span class="ico ico-cross"></span>delete
                                </a>
                            </li>
                        </ul>
                        <ul class="action__list">
                            <li class="action__item">
                                <i class="fa fa-circle" aria-hidden="true"></i>
                                <i class="fa fa-circle" aria-hidden="true"></i>
                                <i class="fa fa-circle" aria-hidden="true"></i>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="lp-table__item-msg">
                <div class="lp-table__item-confirmation">
                    <p>Are you sure you want to remove this IP?</p>
                    <ul class="control">
                        <li class="control__item">
                            <a href="#" class="lp-table_yes" data-id="${id}">Yes</a>
                        </li>
                        <li class="control__item">
                            <a href="javascript:void();" class="lp-table_no">No</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>`;
}
function generateBlockedList(){
    $(".ip-quick-scroll").html("");
    if(!global.blockedList.length){
        $('#message-block').css("display", 'flex')
        $("#ip-block_header").addClass("d-none");
        $(".lp-table__head").addClass("d-none");
    }else {
        $('#message-block').css("display", 'none');
        $("#ip-block_header").removeClass("d-none");
        $(".lp-table__head").removeClass("d-none");
    }
    global.blockedList.forEach(function(record){
        $(".ip-quick-scroll").append(generateHTML(record));
    });

    jQuery(".ip-quick-scroll-wrap").mCustomScrollbar({
        axis: "y",
        autoExpandScrollbar: true,
        autoHideScrollbar: false,
        mouseWheel: {
            scrollAmount: 100
        },
    });
}

function editBlockedIp(id){
    let row = global.blockedList.find(function(list){return list.id==id});
    if(row){
        $("#ip_name").val( row.ip_name );
        $("#ip_address").val(  row.ip_address );
        $("#ip_action").val('update')
        $("#ip_id").val(row.id)
        $("#addUpdateIpAddress").val('Update');
    }
}

// function deleteBlockedIp(id){
//     $("#action_confirmDeleteIp").val(id);
//     $('#modal_confirmDeleteIp').modal('show');
// }
function hasErrors(ipName,ipAddress,ipId  ) {

    let hasError = false;
    if(ipName == "" && ipAddress == ""){
        let message ="Please enter an IP name and IP address.";
        displayAlert('danger', message);
        hasError = true;
    }else if(ipName == ""){
        let message ="Please enter an IP name.";
        displayAlert('danger', message);
        hasError = true;
    }else if( ipAddress == ""){
        let message ="Please enter an IP address.";
        displayAlert('danger', message);
        hasError = true;
    }
    if(hasError){
        callDummyRequest();
        return hasError;
    }

    let found = global.blockedList.find((list)=>{
        return ipAddress == list.ip_address && (!ipId || list.id != ipId);
    });

    let foundName = global.blockedList.find((list)=>{
        return ipName == list.ip_name && (!ipId || list.id != ipId);
    })
    if(found && foundName){
        let message ="IP name and IP address are already in the list.";
        displayAlert('danger', message);
        hasError = true;
    }else if(found){
        let message ="IP address already in the list.";
        displayAlert('danger', message);
        hasError = true;
    }else if(foundName){
        let message ="IP name already in the list.";
        displayAlert('danger', message);
        hasError = true;
    }

    if(hasError){
        callDummyRequest();
    }

    return hasError;
}
function callDummyRequest(){
    requesting = true;
    setTimeout(function(){
        requesting = false;
    }, 1000);
}
function addUpdateIp(){
    if(requesting){
       return;
    }
    var ipName = $("#ip_name").val();
    var ipAddress = $("#ip_address").val();
    var funnelHash = $("#funnel_hash").val();
    var ipAction = $("#ip_action").val();
    var ipId = $("#ip_id").val();

    if(hasErrors(ipName,ipAddress,ipId)){
        return;
    }


    // if(!ipId){
    //     let found = global.blockedList.find((list)=>{
    //         return ipAddress == list.ip_address;
    //
    //     })
    //     if(found){
    //         let message ="IP address already in the list.";
    //         displayAlert('danger', message);
    //         return;
    //     }
    //
    //     let foundName = global.blockedList.find((list)=>{
    //         return ipName == list.ip_name;
    //     })
    //     if(foundName){
    //         let message ="IP name already in the list.";
    //         displayAlert('danger', message);
    //         return;
    //     }
    // }else{
    //     let found = global.blockedList.find((list)=>{
    //         return ipAddress == list.ip_address && list.id != ipId;
    //
    //     })
    //     if(found){
    //         let message ="IP address already in the list.";
    //         displayAlert('danger', message);
    //         return;
    //     }
    // }
        if(isValidIp(ipAddress)){

            $("#addUpdateIpAddress").attr("disabled", "disabled");
            $.ajax( {
                type : "POST",
                data: {
                    hash: funnelHash,
                    ip_name: ipName,
                    ip_address: ipAddress,
                    action:ipAction,
                    id:ipId
                },
                url : "/lp/stats/blockipaddress",
                dataType : "json",
                error: function (e) {
                    $("#addUpdateIpAddress").removeAttr("disabled");
                    let message ="Your request was not processed. Please try again.";
                    displayAlert('danger', message);
                },
                success : function(rsp) {
                    $("#addUpdateIpAddress").removeAttr("disabled");
                    var data = {
                        id:rsp.id,
                        ip_name:ipName,
                        ip_address:ipAddress
                    };
                    if(rsp.response == 'added'){
                        global.blockedList.push(data);
                        let message ="IP address has been added.";
                        displayAlert('success', message);
                    }

                    else if(rsp.response == 'updated'){
                        global.blockedList.forEach(function(row){
                            if(row.id ==data.id){
                                row.ip_name = data.ip_name;
                                row.ip_address = data.ip_address;
                            }
                        });
                        let message ="IP address has been updated.";
                        displayAlert('success', message);
                    }
                    generateBlockedList();
                    global.resetBlockIpForm();
                },
                always: function(d) { },
                cache : false,
                async : true
            });
        }
}
