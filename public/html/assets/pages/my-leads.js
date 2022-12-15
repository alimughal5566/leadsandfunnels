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

$('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+init_start.format(dateFormat) + ' - ' + init_end.format(dateFormat)+"<span class='caret'></span>");

$(document).ready(function(){


    // tooltip

    $('.el-tooltip').tooltip();

    $(".alpha__item").click(function () {
        $(".alpha__item").removeClass("active__lead");
        $(this).addClass("active__lead");
    });

    var dateFormat = "MM/DD/YYYY";
    $('#leadrange').daterangepicker({
        autoUpdateInput: true,
        parentEl:'.qa-select-menu',
        // locale: {
        //     cancelLabel: 'Clear'
        // }
    });

    // $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+picker.startDate.format(dateFormat) + ' - ' + picker.endDate.format(dateFormat)+"<span class='caret'></span>")

    $('#leadrange').on('apply.daterangepicker', function(ev, picker) {
        // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+picker.startDate.format(dateFormat) + ' - ' + picker.endDate.format(dateFormat)+"<span class='caret'></span>")
        $('#myleadstart').val(picker.startDate.format(mysqDateFormat));
        $('#myleadend').val(picker.endDate.format(mysqDateFormat));
        $("#page").val(1);
        // getPageData();

    });

    $('#leadrange').on('cancel.daterangepicker', function(ev, picker) {
        $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>Select Date<span class="caret"></span>');
        $(".alpha-search").find("li").removeClass("mylead_active");
        $("#letter").val("");
        $("#selactionall").prop('checked', false);
        $('#search').val("");
        $('#myleaddaterange').val("");
        $('#myleadstart').val('');
        $('#myleadend').val('');
        $("#page").val(1);
        location.reload();
        // getPageData();
    });

    $('.all-check-box').change(function(){
        if($(this).is(":checked")) {
            // allFunnelKey("check");
            $('input:checkbox').prop('checked', true);
            $('input:checkbox').next().addClass('label-color');
        } else {
            // allFunnelKey("uncheck");
            $('input:checkbox').prop('checked', false);
            $('input:checkbox').next().removeClass('label-color');
        }
        resetcheckuncheckbox();
    });

    $(".lead-per-page .action__link").click(function () {
        $(".lead-per-page .action__link").removeClass("active");
        $(this).addClass("active");
    });

    $(".lead-page .action__link").click(function () {
        $(".lead-page .action__link").removeClass("active");
        $(this).addClass("active");
    });

    $("#delmyleads").click(function(){
        var unique_keys = "";
        var key = "";
        var cnt = 0 ;
        $( "input:checkbox[id^=selaction]").each(function() {
            if($(this).is(":checked") && $(this).attr('id') != 'selactionall') {
                cnt = cnt + 1;
                key = $(this).data("uniquekey");
                unique_keys = unique_keys +  key + "~";
            }
        });
        var check_all=$("#selactionall").is(":checked") ? true : false;
        if(check_all==true){
            cnt=$("#allfunnelkeytotal").val();
        }
        if(cnt===0) {
            alert("Please select at least one lead to delete.");
            return false;
        }else{
            var total_text=(cnt > 1)?cnt+" Leads?":cnt+" Lead?";
            var text="Are you sure to delete "+total_text;
            $("#deleteleads").find(".funnel-message").text(text);
        }
    });

    function resetcheckuncheckbox(){
        var check_all=$("#selactionall").is(":checked") ? true : false;
        if(check_all=true){
            /*console.log("uncheckstring"+uncheckstring);
            console.log(checkstring);*/
            if(checkstring!=""){
                $( "input:checkbox[id^=selaction]").each(function() {
                    var key = $(this).data("uniquekey");
                    if(checkstring.indexOf(key + "~") != -1) {
                        $(this).prop('checked', true);
                        $(this).next().addClass('label-color');
                    }
                });
            }
            if(uncheckstring!=""){
                $( "input:checkbox[id^=selaction]").each(function() {
                    var key = $(this).data("uniquekey");
                    //console.log("each key"+key + "~");
                    if(uncheckstring.indexOf(key + "~") != -1) {
                        $(this).prop('checked', false);
                        $(this).next().removeClass('label-color');
                    }
                });
            }
        }
        return;
    }

});