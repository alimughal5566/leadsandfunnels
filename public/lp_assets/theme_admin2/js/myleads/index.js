
var allchecked=false;
var uncheckstring="";
var checkstring="";

$(document).ready(function(){
    /*$('body').on('click' , '.myleaddetail' , function(e){
       e.preventDefault();
        $(this).closest('.lead-item').removeClass('lp-new-lead');
    });*/

    getPageData();
    var dateFormat = "MM/DD/YYYY";
    $('#leadrange').daterangepicker({
        autoUpdateInput: false,
        parentEl:'.lp-parent',
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#leadrange').on('apply.daterangepicker', function(ev, picker) {
        // $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+picker.startDate.format(dateFormat) + ' - ' + picker.endDate.format(dateFormat)+"<span class='caret'></span>")
        $('#myleadstart').val(picker.startDate.format(mysqDateFormat));
        $('#myleadend').val(picker.endDate.format(mysqDateFormat));
        $("#page").val(1);
        getPageData();

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
        getPageData();
    });



    //  predefine date range start

    // var start = moment().subtract(29, 'days');
    // var end = moment();
    // var dateFormat = "MM/DD/YYYY";
    //
    // function lp_cb(start, end) {
    //     $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+start.format(dateFormat) + ' - ' + end.format(dateFormat)+"<span class='caret'></span>");
    // }
    //
    // $('#leadrange').daterangepicker({
    //     startDate: start,
    //     endDate: end,
    //     parentEl:'.lp-parent',
    //     showCustomRangeLabel:'Custom date',
    //     ranges: {
    //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //         'This Month': [moment().startOf('month'), moment().endOf('month')],
    //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //     }
    // }, lp_cb);
    //
    // lp_cb(start, end);
    // $('#start-date').daterangepicker({
    //         singleDatePicker: true,
    //         showDropdowns: true,
    //         parentEl:'.date-wrapper',
    //         opens:'down',
    //         locale: {
    //             format: dateFormat
    //         }
    //     },
    //     function(start, end, label) {
    //         $('li').removeClass('active');
    //         $('#start-date').val(start.format(dateFormat));
    //         $('#lp-startDate').val(start.format(mysqDateFormat));
    //     }
    // );
    //
    // $('#end-date').daterangepicker({
    //         singleDatePicker: true,
    //         showDropdowns: true,
    //         parentEl:'.date-wrapper',
    //         opens:'down',
    //         locale: {
    //             format: dateFormat
    //         }
    //     },
    //     function(start, end, label) {
    //         $('.ranges li').removeClass('active');
    //         $('#end-date').parent().addClass('active');
    //         $('#end-date').val(start.format(dateFormat));
    //         $('#lp-endDate').val(start.format(dateFormat));
    //     }
    // );
    //  predefine date range end

    // $("#end-date").on('apply.daterangepicker', function(ev, picker){
    //     var startDate = $('#lp-startDate').val();
    //     var endDate  = $('#lp-endDate').val();
    //     $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+startDate+' - '+endDate+"<span class='caret'></span>");
    // });
        /*$(".daterangepicker .applyBtn").click(function(e){
            var post_data = { hash: $("#clicked_by").val(), start_date: $("#lp-startDate").val(), end_date: $("#lp-endDate").val()};

            var sd = new Date($("#myleadstart").val());
            var sdate = ( ("0" + (sd.getMonth()+1)).slice(-2) + '/' + ("0" + sd.getDate()).slice(-2) + '/' +  sd.getFullYear() );
            var ed = new Date($("#lp-endDate").val());
            var edate = ( ("0" + (ed.getMonth()+1)).slice(-2) + '/' + ("0" + ed.getDate()).slice(-2) + '/' +  ed.getFullYear() );
            $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>'+sdate + ' - ' + edate+"<span class='caret'></span>");
            $("div.ranges").find("li").removeClass("active");
        });    */


    });

    /*$('input[name="myleaddaterange"]').daterangepicker({
            parentEl:'#mylead-date-range',
            autoUpdateInput:false,
            opens: "down",
            locale: {
                format: dateFormat,
                //format: 'YYYY-MM-DD',
            }
        },function(start, end, label) {
            console.log(start);
            console.log(end);
            $('#myleadstart').val(start.format(mysqDateFormat));
            $('#myleadend').val(end.format(mysqDateFormat));
        }
    );
    $('input[name="myleaddaterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        $('#myleadstart').val(picker.startDate.format(mysqDateFormat));
        $('#myleadend').val(picker.endDate.format(mysqDateFormat));

    });
    $('input[name="myleaddaterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $('#myleadstart').val('');
        $('#myleadend').val('');
    });*/

    var page = $("#page").val();

    //var current_page = $("#current_page").val();

    var result_per_page_val = $("#result_per_page_val").val();

    var total_page = 0;

    var cur_hash=$("#current_hash").val();




    /* manage myleads data list */

    function manageMyLeads1() {

        var form_data=$('#mylead').serializeArray();
        //form_data.push({page:page});
        $.ajax({
            dataType: 'json',
            url: site.baseUrl+site.lpPath+'/myleads/getleads/'+cur_hash,
            type: 'POST',
            data: form_data,
        }).done(function(data){
            total_page = Math.ceil(data.total/result_per_page_val);
            current_page = page;
            getPagination(total_page);
            manageRow(data.data);
        });
    }
    function funnelKeuUpdate(callfor,uniquekey){

        var check_all=$("#selactionall").is(":checked") ? true : false;

        if(check_all==true){

            var oldkeyValue=$("#allfunnelkey").val();
            var newKeyValue="";
            //console.log(uniquekey);
            //console.log(oldkeyValue);

            if(callfor=="check"){
                if(oldkeyValue.indexOf(uniquekey) == -1){
                    newKeyValue = uniquekey+oldkeyValue;
                }
                if(checkstring.indexOf(uniquekey) == -1){
                    checkstring = uniquekey+checkstring;
                }
                if(uncheckstring.indexOf(uniquekey) != -1){
                    //console.log("check to set uncheck");
                    uncheckstring = uncheckstring.replace(uniquekey,'');
                }
            }else if(callfor=="uncheck"){
                if(oldkeyValue.indexOf(uniquekey) >= 0){
                    newKeyValue = oldkeyValue.replace(uniquekey,'');
                }
                if(uncheckstring.indexOf(uniquekey) == -1){
                    uncheckstring = uniquekey+uncheckstring;
                }
                if(checkstring.indexOf(uniquekey) != -1){
                    //console.log("uncheck to set check");
                    checkstring=checkstring.replace(uniquekey,'');
                }
            }
            //console.log(newKeyValue);
            if(newKeyValue) $("#allfunnelkey").val(newKeyValue);
            //console.log($("#allfunnelkey").val());
            return;
        }
    }
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
    function allFunnelKey(callfor){
        if(callfor=="check"){
            if(allchecked==false){
                /*$("#allfunnelkey").val("");
                $("#allfunnelkeytotal").val("");*/
                $(".lp-lead-layer").show();
                //console.log("log only one time ");
                allchecked=true;
                // set the allfunnelkey value
                var form_data=$('#mylead').serializeArray();
                $.ajax({

                    dataType: 'json',

                    url: site.baseUrl+site.lpPath+'/myleads/getallfunnelkey/'+cur_hash,

                    type: 'POST',

                    data: form_data,

                    /*cache : false,

                    async : false,*/

                }).done(function(allkey){

                    //console.log(allkey.length);

                    var allfunkey="";

                    if(allkey.length){

                        for (var i = 0; i < allkey.length; i++) {

                            allfunkey = allfunkey +  allkey[i] + "~";
                        }

                        allfunkey = allfunkey.substring(0, allfunkey.length - 1);

                        $("#allfunnelkey").val(allfunkey);
                        $("#allfunnelkeytotal").val(allkey.length);
                    }else{
                        $("#allfunnelkey").val("");
                        $("#allfunnelkeytotal").val("");
                    }
                    $(".lp-lead-layer").hide();
                })
            }
        }else if(callfor=="uncheck"){
            allchecked=false;
            checkstring="";
            uncheckstring="";
            // set the allfunnelkey value to null
            $("#allfunnelkey").val("");
            $("#allfunnelkeytotal").val("");
        }
        return;
    }
    var my_lead_timer;

    /* Get Page Data*/
    function getPageData(start_page,check_all) {

        /*window.clearTimeout(my_lead_timer);
        my_lead_timer = window.setTimeout(function(){*/

            start_page = start_page || 1;
            check_all = check_all || false;
            var form_data=$('#mylead').serializeArray();

            console.log($("#mask").length);

            $("#mask").show();
            console.log(start_page+ " ~~ "+check_all);
            console.log(">> "+window.running);

            setTimeout(function() {
                if (!window.running) {
                    window.running = true;
                }

                $.ajax({

                    dataType: 'json',

                    url: site.baseUrl+site.lpPath+'/myleads/getleads/'+cur_hash,

                    type: 'POST',

                    data: form_data,

                    async: false,

                    cache:false,
                    success: function (data) {

                        if(data.total > 0){

                        //console.log(data.q);
                        //console.log(data.newleads);
                        //console.log(result_per_page_val);
                        //console.log(start_page);
                        $(".my-lead-title").find("h4 span").text(data.totalleads);
                        $("#lp-new-lead").text(data.newleads);
                        total_page = Math.ceil(data.total/result_per_page_val);
                        current_page = page;
                        $('.my-lead-pagination').removeClass("hide");
                        $('#mylead-top-sect').removeClass("hide");
                        $('.my-lead-action-box').removeClass("hide");
                        getPagination(total_page,start_page);
                        manageRow(data.data);
                        //$("#mask").hide();
                    }else{
                        $(".my-lead-title").find("h4 span").text('0');
                        $("#myleads_results").html('<h1 class="not-found-msg text-center">(No Leads to Show at This Time)</h1>');
                        $('.my-lead-pagination').addClass("hide");
                        $('#mylead-top-sect').addClass("hide");
                        $('.my-lead-action-box').addClass("hide");
                        $("#lp-new-lead").text('0');
                        $(".my-lead-pagination .ptitle").removeClass("show").addClass("hide");
                        //$("#mask").hide();
                    }
                    if(check_all==true){
                        //console.log("heeooo ");
                        $('.all-check-box').trigger("change");
                    }
                  },complete: function () {
                    $("#mask").hide();
                    // enable this when posting to server
                    //setTimeout(function () { document.getElementById("window").style.width = "0%"; }, 3000);
                  }

                });


         }, 1000);


        //},10000);


        /*.done(function(data){
            //console.log(data.q);
            //console.log(data.data);

        });*/

    }

    function getPagination(total_page,start_page){
        console.log("test test test");
        if(total_page > 1){
            $(".my-lead-pagination .ptitle .per-page-title").removeClass("hide").addClass("show");
        }else{
            $(".my-lead-pagination .ptitle .per-page-title").removeClass("show").addClass("hide");
        }
        $('#leadpop-pagination').twbsPagination('destroy');
        $('#leadpop-pagination').twbsPagination({
            totalPages: total_page,
            initiateStartPageClick:false,
            startPage:start_page,
            //visiblePages: current_page,
            visiblePages: 6,
            hideOnlyOnePage:true,
            next: '',
            prev: '',
            first: '',
            last: '',
            onPageClick: function (event, pageL) {
                console.log("page is clicked");
                var check_all=$("#selactionall").is(":checked") ? true : false;
                $("#page").val(pageL);
                page = pageL;
                //console.info(page);
                getPageData(pageL,check_all);    // don't why adding this line to make loop so commenting this line
            }
        });
        //$('#leadpop-pagination').twbsPagination('show', start_page);
    }


    /* Add new Item table row */

    function manageRow(data) {
        var rows = '';
        var i=0;
        $.each( data, function( key, value ) {
            i++;
            var lp_new_lead=(value.opened==0)?"lp-new-lead":"";
            rows = rows +'<div data-lpleadspos="'+i+'" data-itemids="lp-lead-item'+i+'" class="lead-items" id="'+value.id+'">';
                rows = rows +'<div class="lead-item ' +lp_new_lead+' ">';
                    rows = rows +'<div class="lead-user">';
                        rows = rows +'<div class="row">';
                            rows = rows +'<div class="col-sm-6 ">';
                                rows= rows +'<input type="checkbox" id="selaction'+key+'" data-uniquekey="'+value.id+'" name="selaction'+key+'" />';
                                rows= rows +'<label class="" for="selaction'+key+'"><span></span><a data-toggle="modal" data-target="#single-lead-modal" class="myleaddetail" data-uniquekey="'+value.id+'">'+capitalizeFirstLetter(value.firstname)+" "+capitalizeFirstLetter(value.lastname)+'</a></label>';
                            rows= rows +'</div>';
                            rows= rows +'<div class="col-sm-6 text-right">';
                            rows= rows +value.datecompleted;
                            rows= rows +'</div>';
                         rows= rows +'</div>';
                    rows= rows +'</div>';

                    rows= rows +'<div class="row">';
                        rows= rows +'<div class="lead-user-info">';
                            rows= rows +'<div class="col-sm-4 text-center">'+value.phone+'</div>';
                            rows= rows +'<div class="col-sm-4 text-center">'+value.email+'</div>';
                            rows= rows +'<div class="col-sm-4 text-center">'+value.address+'</div>';
                        rows= rows +'</div>';
                    rows= rows +'</div>';
                rows= rows +'</div>';
            rows= rows +'</div>';
        });
        $("#myleads_results").html(rows);
    }

    $("body").on("click",".myleaddetail",function(){

        var total_leads=$("#lp-new-lead").text();
        //console.log(total_leads);
        if($(this).closest('.lead-item').hasClass('lp-new-lead') && total_leads > 0){
            $("#lp-new-lead").text(total_leads-1);
            $(this).closest('.lead-item').removeClass('lp-new-lead');
        }

        var unique_key = $(this).data("uniquekey");
        var client_id = $('#client_id').val();
        $.ajax({
            url: site.baseUrl+site.lpPath+'/myleads/getleaddetail/'+cur_hash,
            type: 'POST',
            data: {unique_key:unique_key,client_id:client_id},
            cache : false,
            async : false,
        }).done(function(data){
            //console.log(data);
            $("#single-lead-modal").html(data);
        });
    });

    $("#result_per_page").find("li a").each(function(){
        $(this).on("click",function(e){
            e.preventDefault();
            //$("#selactionall").prop("checked",false);
            $("#result_per_page").find("li a").removeClass("pag-active");
            $(this).addClass("pag-active");
            result_per_page_val=$(this).data("value");
            $("#result_per_page_val").val($(this).data("value"));
            $("#page").val(1);
            var check_all=$("#selactionall").is(":checked") ? true : false;
            getPageData(1,check_all);
        });
    });
    $(".alpha-search").find("li a").each(function(){
        $(this).on("click",function(e){
            e.preventDefault();
            $(".alpha-search").find("li").removeClass("mylead_active");
            $(this).parent().addClass("mylead_active");
            $("#letter").val($(this).text().toLowerCase());
            if($(this).text().toLowerCase()=="all"){
                $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>Select Date<span class="caret"></span>');
                $("#selactionall").prop('checked', false);
                $('#search').val("");
                $('#myleaddaterange').val("");
                $('#myleadstart').val('');
                $('#myleadend').val('');
            }
            $("#page").val(1);
            getPageData();
        });
    });
    /*$("#lp-reset-btn").on("click",function(e){
        e.preventDefault();
        $('#leadrange span').html('<i class="fa fa-calendar cal-size" aria-hidden="true"></i>Select Date<span class="caret"></span>');
        $(".alpha-search").find("li").removeClass("mylead_active");
        $("#letter").val("");
        $("#selactionall").prop('checked', false);
        $('#search').val("");
        $('#myleaddaterange').val("");
        $('#myleadstart').val('');
        $('#myleadend').val('');
        $("#page").val(1);
        getPageData();
    });*/

    $('#search').bind('keypress keydown keyup', function(e){
       if(e.keyCode == 13) {
            e.preventDefault();
            $("#page").val(1);
            getPageData();
        }
    });
    $("#lp-search-btn").on("click",function(e){
        e.preventDefault();
        $("#page").val(1);
        getPageData();
    });
    $(".leadsort").each(function(){
        $(this).on("click",function(e){
            var isActive = $(this).hasClass("sort-active");
            if(isActive) return false;

            var ele_arr=Array();
            var asc_arr=Array();
            var desc_arr=Array();
            var finalhtml="";
            e.preventDefault();
            $(".leadsort").removeClass("sort-active");
            $(this).addClass("sort-active");
            $("#sortby").val($(this).data("sortvalue"));
            $("#page").val(1);
            //getPageData($("#page").val());
            getPageData();
            return;

            /*$.each( $(".lead-items[data-itemids^='lp-lead-item']"), function () {
                ele_arr.push(this);
            });*/

            if($(this).data("sortvalue")=="asc"){
                $.each( $(".lead-items[data-itemids^='lp-lead-item']"), function () {
                  finalhtml+=$(this).sort(function(a, b){
                    return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;
                  });
                });
                //console.log("asc");
                /*for (var i = 0; i < ele_arr.length; i++) {
                    finalhtml+=ele_arr[i].outerHTML;
                }*/
            }else{
                //console.log("desc");
                $.each( $(".lead-items[data-itemids^='lp-lead-item']"), function () {
                  finalhtml+=$(this).sort(function(a, b){
                    return ($(b).data('position')) < ($(a).data('position')) ? -1 : 1;
                  });
                });
                /*var rev_arr=ele_arr.reverse();
                for (var i = 0; i < rev_arr.length; i++) {
                    finalhtml+=rev_arr[i].outerHTML;
                }*/

            }
            //console.log(finalhtml);
            $("#myleads_results").html("");
            $("#myleads_results").html(finalhtml);

        });
    });

    $('body').on('change','input:checkbox',function(){
    //$('input:checkbox').change(function(){
        if($(this).is(":checked")) {
            if($(this).attr('id') != 'selactionall') {
                funnelKeuUpdate("check",$(this).data("uniquekey")+"~");
                $(this).next().addClass('label-color');
            }
        } else {
            if($(this).attr('id') != 'selactionall') {
                funnelKeuUpdate("uncheck",$(this).data("uniquekey")+"~");
                $(this).next().removeClass('label-color');

            }
        }
    });
    $('.all-check-box').change(function(){
        if($(this).is(":checked")) {
            allFunnelKey("check");
            $('input:checkbox').prop('checked', true);
            $('input:checkbox').next().addClass('label-color');
        } else {
            allFunnelKey("uncheck");
            $('input:checkbox').prop('checked', false);
            $('input:checkbox').next().removeClass('label-color');
        }
        resetcheckuncheckbox();
    });

    $('#printmailtolefthref').click(function(e) {
        e.preventDefault();
        var cnt = 0 ;
        var unique_keys = "";
        var key = "";
        $( "input:checkbox[id^=selaction]").each(function() {
            if($(this).is(':checked') && $(this).attr('id') != 'selactionall') {
                cnt = cnt + 1;
                key = $(this).data("uniquekey");
                unique_keys = unique_keys +  key + "~";
            }
        });
        if(cnt == 0) {
            alert("Please select at least one lead to email.");
            return;
            //$('#notchecked').dialog('open');
        }else {
            unique_keys = unique_keys.substring(0, unique_keys.length - 1);
            var check_all=$("#selactionall").is(":checked") ? true : false;
            if(check_all==true){
                unique_keys=$("#allfunnelkey").val();
            }

            var client_id = $('#client_id').val();
            $.ajax( {
                type : "POST",
                url: site.baseUrl+site.lpPath+'/myleads/myleadsprint',
                data : "u=" + unique_keys + "&client_id=" + client_id,
                success : function(data) {
                    alert(data);
                    var  w = window.open (data , "menu","location=1,status=1,scrollbars=1,width=700,height=850");
                },
                cache : false,
                async : false
            });
        }
    });
    $('#mailtolefthref').click(function(e) {
        var cnt = 0 ;
        var unique_keys = "";
        var key = "";
        $( "input:checkbox[id^=selaction]").each(function() {
            if($(this).is(':checked') && $(this).attr('id') != 'selactionall') {
                cnt = cnt + 1;
                key = $(this).data("uniquekey");
                unique_keys = unique_keys +  key + "~";
            }
        });

        if(cnt == 0) {
            e.preventDefault();
            alert("Please select at least one lead to email.");
            return;
        }else{
            var client_id = $('#client_id').val();
            unique_keys = unique_keys.substring(0, unique_keys.length - 1);
            var check_all=$("#selactionall").is(":checked") ? true : false;
            if(check_all==true){
                unique_keys=$("#allfunnelkey").val();
            }
           //alert(unique_keys);
            $.ajax( {
                type : "POST",
                url: site.baseUrl+site.lpPath+'/myleads/myleadsemail',
                data : "u=" + unique_keys + "&client_id=" + client_id,
                success : function(data) {
                    //alert(data);
                    data = "mailto:?body=" + data;
                    $('#mailtolefthref').attr('href',data);
                },
                cache : false,
                async : false
            });
        }
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
            var total_text=(cnt > 1)?cnt+" Leads":cnt+" Lead";
            var text="Are you sure to delete "+total_text;
            $("#deleteleads").find(".funnel-message").text(text);
        }
    });

    $("#deletethelead").click(function(){
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
        if(cnt > 0) {
                unique_keys = unique_keys.substring(0, unique_keys.length - 1);
                var check_all=$("#selactionall").is(":checked") ? true : false;
                if(check_all==true){
                    unique_keys=$("#allfunnelkey").val();
                    cnt=$("#allfunnelkeytotal").val();
                }
                deleteCurrent(unique_keys,cnt);
        }else {
            alert("Please select at least one lead to delete.");
            return;
        }
    });
    $("body").on("click","#printmailtopophref",function(e){
        //$('#printmailtopophref').click(function(e) {
        e.preventDefault();
        var unique_keys =  $(this).data("uniquekey");
        var client_id = $('#client_id').val();
        /*console.log(unique_keys +" "+client_id);
        return;*/
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/myleads/myleadpopprint',
            data : "u=" + unique_keys + "&client_id=" + client_id+'&_token='+ajax_token,
            success : function(data) {
                //alert(data);
                var  w = window.open (data , "menu","location=1,status=1,scrollbars=1,width=700,height=850");
            },
            cache : false,
            async : false
        });
    });
    $("body").on("click","#mailtopophref",function(e){
        var client_id = $('#client_id').val();
        var unique_keys =  $(this).data("uniquekey");
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/myleads/myleadpopemail',
            data : "u=" + unique_keys + "&client_id=" + client_id,
            success : function(data) {
                //alert(data);
                data = "mailto:?body=" + data;
                $('#mailtopophref').attr('href',data);
            },
            cache : false,
            async : false
        });
    });
    $("body").on("click","#leadpopdelete",function(e){
        e.preventDefault();
        var unique_key=$(this).data("uniquekey");
        var client_id = $('#client_id').val();
        $('#leadpopconfirm').modal("show");
        $('#leadpopconfirm').modal({
          backdrop: 'static',
          keyboard: false
        }).one('click', '#leadpopcondelete', function(e) {
         $('#leadpopconfirm').modal("hide");
          deletePopLead(unique_key,client_id);
        });
    });
    function deletePopLead(unique_key,client_id){
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/myleads/deletepoplead',
            data : "u=" + unique_key + '&client_id=' + client_id,
            success : function(data) {
                $('#single-lead-modal').modal('hide');
                $("#page").val(1);
                getPageData();
                $("#success-alert").find("span").text("Lead has been deleted.");
                $("#success-alert").fadeTo(3000, 500).slideUp("slow", function(){
                    $("#success-alert").slideUp("slow");
                });
            },
            cache : false,
            async : false
        });
    }

    function deleteCurrent(unique_keys,stotal) {
        var client_id = $('#client_id').val();
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/myleads/deleteselectedleads',
            data : "u=" + unique_keys + '&client_id=' + client_id,
            success : function(data) {
                //console.log(data);
                var popid = $('#zclickedcategory').val();
                var t = popid.split("~");
                var leadpop_id = t[0];
                var leadpop_version_seq = t[1];
                var client_id = t[2];
                var total_leads=$(".my-lead-title").find("h4 span").text();
                $(".my-lead-title").find("h4 span").text(total_leads-stotal);
                $("#lp-new-lead").text("");
                $('#deleteleads').modal('hide');
                $("#page").val(1);
                getPageData();
                $("#success-alert").find("span").text("Lead has been deleted.");
                $("#success-alert").fadeTo(3000, 500).slideUp("slow", function(){
                    $("#success-alert").slideUp("slow");
                });
            },
            cache : false,
            async : false
        });
    };
function exportsdata(etype){
    var cnt = 0 ;
    var unique_keys = "";
    var key = "";
    $( "input:checkbox[id^=selaction]").each(function() {
        if($(this).is(':checked') && $(this).attr('id') != 'selactionall') {
            cnt = cnt + 1;
            key = $(this).data("uniquekey");
            unique_keys = unique_keys +  key + "~";
            //unique_keys = unique_keys +  key + ",";
        }
    });

    var client_id = $('#client_id').val();

    if(cnt > 0) {
        var url="";
        var target_ele="";
        switch (etype) {
            case 'word':
                url=site.baseUrl+site.lpPath+'/export/exportsworddata';
                target_ele="expswdlnk";
            break;
            case 'excel':
                url=site.baseUrl+site.lpPath+'/export/exportsexcelddata';
                target_ele="expsexelnk";
            break;
            case 'pdf':
                url=site.baseUrl+site.lpPath+'/export/exportspdfdata';
                target_ele="expspdflnk";
            break;
        }
        unique_keys = unique_keys.substring(0, unique_keys.length - 1);
        var check_all=$("#selactionall").is(":checked") ? true : false;
        /*console.log(check_all);
        return false;*/
        $("#target_ele").val(target_ele);
        if(check_all==false){
            $("#allfunnelkey").val(unique_keys);

            /*
            var orignal=$("#"+target_ele).attr('href');
            orignal = url + '?u=' + unique_keys+'&client_id=' + client_id;
            //console.log([orignal,replace_search_type,ptype]);
            $("#"+target_ele).attr('href',orignal);
            return true;*/
        }
        var total_sel_leads=$("#allfunnelkey").val().split("~").length;
        //total_sel_leads=1002;
        if(total_sel_leads <= 1000){
            $("#mylead").attr('action',url);
            $("#mylead").submit();
        }else{
            $('#myleadsemail').modal('show');
        }
        return;
    }else {
        alert("Please select at least one lead to export.");
        return false;
    }

}
$("#myleademail").click(function(){

    var is_valid = true;
    /*var error = []
    if(!validateField("newemail","required~email")){
        is_valid = false;
        error.push("Invalid email address")
    }
    if(!is_valid){
        var notifyElem = $(".model_notification");
        notifyElem.html(error.join("<br />")).removeClass('hide').addClass('alert-danger');
    }else{}*/
        $('#myleadsemail').modal('hide');
        var _lead_ids=$("#allfunnelkey").val();
        var client_id = $('#client_id').val();
        var email = $('#newemail').val();
        var export_type = $('#target_ele').val();

        /*console.log(_lead_ids);
        console.log(client_id);*/
        $.ajax({

            url: site.baseUrl+site.lpPath+'/myleads/exportleadsemaildata/'+cur_hash,

            type: 'POST',

            data: {client_id:client_id,lead_ids:_lead_ids,email:email,export_type:export_type},

            success: function (data) {

            },complete: function () {

            }

        });


});


function downLoadLeadLeft(url, id) {
    var cnt = 0 ;
    var unique_keys = "";
    var key = "";
    $( "input:checkbox[id^=selaction]").each(function() {
        if($(this).is(':checked') && $(this).attr('id') != 'selactionall') {
            cnt = cnt + 1;
            key = $(this).data("uniquekey");
            unique_keys = unique_keys +  key + "~";
        }
    });

    var client_id = $('#client_id').val();
    /*console.log(client_id);
    console.log(unique_keys);
    console.log(cnt);
    return false;*/
    if(cnt > 0) {
        unique_keys = unique_keys.substring(0, unique_keys.length - 1);
       /*console.log(url + '?u=' + unique_keys+'&client_id=' + client_id);
       return;*/
        oIFrm = document.getElementById(id);
        oIFrm.src = url + '?u=' + unique_keys+'&client_id=' + client_id;
    }
    else {
        alert("Please select at least one lead to export.");
        return;
        $('#notchecked').dialog('open');
    }

}

function csvdownload(url, id) {
        var cnt = 0 ;
        var unique_keys = "";
        var key = "";
        var client_id = $('#client_id').val();
        var clickedkey = $("#clickedkey").val();
        /*if ($("#selactionall").is(":checked")) {
            oIFrm = document.getElementById(id);
            alert(site.baseUrl+"/downloads/csvdownloadexcelleft.php"  + "?client_id=" + client_id + "&clickedkey=" + clickedkey);
            oIFrm.src = site.baseUrl+"/downloads/csvdownloadexcelleft.php"  + "?client_id=" + client_id + "&clickedkey=" + clickedkey;
            // https://myleads.leadpops.com/downloads/csvdownloadexcelleft.php?client_id=700&clickedkey=Mortgage~Home Purchase~28~2~700
        }else{
        }*/
            $( "input:checkbox[id^=selaction]").each(function() {
                if($(this).is(':checked') && $(this).attr('id') != 'selactionall') {
                    cnt = cnt + 1;
                    key = $(this).data("uniquekey");
                    unique_keys = unique_keys +  key + "~";
                }
            });
            /*console.log(cnt);
            console.log(unique_keys);
            return;*/
            if(cnt > 0) {
                unique_keys = unique_keys.substring(0, unique_keys.length - 1);
                oIFrm = document.getElementById(id);
                //console.log(url + '?u=' + unique_keys+'&client_id=' + client_id);
                oIFrm.src = url + '?u=' + unique_keys+'&client_id=' + client_id;
            }
            else {
                alert("Please select at least one lead to export.");
                return;
                $('#notchecked').dialog('open');
            }
}
function exportPopLead(url, id,unique_keys) {
    var client_id = $('#client_id').val();
    oIFrm = document.getElementById(id);
    /*console.log(url + '?u=' + unique_keys+'&client_id=' + client_id);
    return;*/
    oIFrm.src = url + '?u=' + unique_keys+'&client_id=' + client_id;
}
function capitalizeFirstLetter(string) {
    if(string.length > 0){
        return string[0].toUpperCase() + string.slice(1);
    }
}
//old
/*
$(document).ready(function(){

    var page = 1;

    var current_page = 1;

    var total_page = 0;

    var is_ajax_fire = 0;

    var cur_hash=$("#current_hash").val();


    manageMyLeads();

    // manage myleads data list

    function manageMyLeads() {
        var form_data=$('#mylead').serializeArray();
        //form_data.push({page:page});
        $.ajax({
            dataType: 'json',
            url: site.baseUrl+site.lpPath+'/myleads/getleads/'+cur_hash,
            type: 'POST',
            data: form_data,
        }).done(function(data){
            total_page = Math.ceil(data.total/10);
            current_page = page;
            $('#leadpop-pagination').twbsPagination({
                totalPages: total_page,
                //visiblePages: current_page,
                visiblePages: 6,
                next: '',
                prev: '',
                first: '',
                last: '',
                onPageClick: function (event, pageL) {
                    page = pageL;
                    if(is_ajax_fire != 0){
                      getPageData();
                    }
                }
            });
            manageRow(data.data);
            is_ajax_fire = 1;
        });
    }
    // Get Page Data
    function getPageData() {
        var form_data=$('#mylead').serializeArray();
        form_data.push({page:page});
        $.ajax({

            dataType: 'json',

            url: site.baseUrl+site.lpPath+'/myleads/getleads/'+cur_hash,

            type: 'POST',

            data: form_data,
        }).done(function(data){
            manageRow(data.data);
        });

    }


     //Add new Item table row

    function manageRow(data) {
        var rows = '';
        $.each( data, function( key, value ) {
            rows = rows +'<div class="lead-items" id="'+value.unique_key+'">';
                rows = rows +'<div class="lead-item">';
                    rows = rows +'<div class="lead-user">';
                        rows = rows +'<div class="row">';
                            rows = rows +'<div class="col-sm-6 ">';
                                rows= rows +'<input type="checkbox" id="selaction'+key+'" data-uniquekey="'+value.unique_key+'" name="selaction'+key+'" />';
                                rows= rows +'<label class="label-color" for="selaction'+key+'"><span></span><a data-toggle="modal" data-target="#single-lead-modal" class="myleaddetail" data-uniquekey="'+value.unique_key+'">'+value.firstname+" "+value.lastname+'</a></label>';
                            rows= rows +'</div>';
                            rows= rows +'<div class="col-sm-6 text-right">';
                            rows= rows +value.date_completed;
                            rows= rows +'</div>';
                         rows= rows +'</div>';
                    rows= rows +'</div>';

                    rows= rows +'<div class="row">';
                        rows= rows +'<div class="lead-user-info">';
                            rows= rows +'<div class="col-sm-4 text-center">'+value.phone+'</div>';
                            rows= rows +'<div class="col-sm-4 text-center">'+value.email+'</div>';
                            rows= rows +'<div class="col-sm-4 text-center">San Diego-CA-92124</div>';
                        rows= rows +'</div>';
                    rows= rows +'</div>';
                rows= rows +'</div>';
            rows= rows +'</div>';
        });
        $("#myleads_results").html(rows);
    }

    $("body").on("click",".myleaddetail",function(){
        var unique_key = $(this).data("uniquekey");
        /*$.ajax({
            dataType: 'json',
            url: site.baseUrl+site.lpPath+'/myleads/leadchangestatus/'+cur_hash,
            type: 'POST',
            data: {unique_key:unique_key},
            cache : false,
            async : false,
        }).done(function(data){
        });*/

        /*var client_id = $('#client_id').val();
        $.ajax({
            url: site.baseUrl+site.lpPath+'/myleads/getleaddetail/'+cur_hash,
            type: 'POST',
            data: {unique_key:unique_key,client_id:client_id},
            cache : false,
            async : false,
        }).done(function(data){
            //console.log(data);
            //$("#single-lead-modal").html(data);
        });
    });
    $("#result_per_page").find("li a").each(function(){
        $(this).on("click",function(e){
            e.preventDefault();
            $("#result_per_page").find("li a").removeClass("pag-active");
            $(this).addClass("pag-active");
            $("#result_per_page_val").val($(this).data("value"));
        });
    });


    $('input:checkbox').change(function(){
        if($(this).is(":checked")) {
            $(this).next().addClass('label-color');
        } else {
            $(this).next().removeClass('label-color');
        }
    });
    $('.all-check-box').change(function(){
        if($(this).is(":checked")) {
            $('input:checkbox').prop('checked', true);
            $('input:checkbox').next().addClass('label-color');
        } else {
            $('input:checkbox').prop('checked', false);
            $('input:checkbox').next().removeClass('label-color');
        }
    });

});
*/
