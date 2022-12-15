
var allchecked=false;
var uncheckstring="";
var checkstring="";

$(document).ready(function(){

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
});
    var page = $("#page").val();

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
            if(newKeyValue) $("#allfunnelkey").val(newKeyValue);
            return;
        }
    }
    function resetcheckuncheckbox(){
        var check_all=$("#selactionall").is(":checked") ? true : false;
        if(check_all=true){
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
                $(".lp-lead-layer__inner").show();
                allchecked=true;
                var form_data=$('#mylead').serializeArray();
                $.ajax({

                    dataType: 'json',

                    url: site.baseUrl+site.lpPath+'/myleads/getallfunnelkey/'+cur_hash,

                    type: 'POST',

                    data: form_data,

                }).done(function(allkey){

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
                    $(".lp-lead-layer__inner").hide();
                })
            }
        }else if(callfor=="uncheck"){
            allchecked=false;
            checkstring="";
            uncheckstring="";
            $("#allfunnelkey").val("");
            $("#allfunnelkeytotal").val("");
        }
        return;
    }
    var my_lead_timer;

    /* Get Page Data*/
    function getPageData(start_page,check_all) {

            start_page = start_page || 1;
            check_all = check_all || false;
            var form_data=$('#mylead').serializeArray();
            $("#mask").show();

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

                        $(".my-lead-title").find("h4 span").text(data.totalleads);
                        $("#lp-new-lead").text(data.newleads);
                        total_page = Math.ceil(data.total/result_per_page_val);
                        current_page = page;
                        $('.my-lead-pagination').removeClass("hide");
                        $('#mylead-top-sect').removeClass("hide");
                        $('.my-lead-result').removeClass("hide");
                        getPagination(total_page,start_page);
                        manageRow(data.data);
                    }else{
                        $(".my-lead-title").find("h4 span").text('0');
                        $("#myleads_results").html('<h1 class="not-found-msg text-center">(No Leads to Show at This Time)</h1>');
                        $('.my-lead-pagination').addClass("hide");
                        $('#mylead-top-sect').addClass("hide");
                        $('.my-lead-result').addClass("hide");
                        $(".my-lead-action-box").css({'border':'none'});
                        $("#lp-new-lead").text('0');
                        $(".my-lead-pagination .ptitle").removeClass("show").addClass("hide");
                    }
                    if(check_all==true){
                        $('.all-check-box').trigger("change");
                    }else{
                        $("#selactionall").prop('checked', false);
                        $("#selactionall").next().removeClass('label-color');
                    }
                  },complete: function () {
                    $("#mask").hide();
                  }

                });


         }, 1000);
    }

    function getPagination(total_page,start_page){
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
                getPageData(pageL,check_all);    // don't why adding this line to make loop so commenting this line
            }
        });
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
            data: {unique_key:unique_key,client_id:client_id,_token:ajax_token},
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

            if($(this).data("sortvalue")=="asc"){
                $.each( $(".lead-items[data-itemids^='lp-lead-item']"), function () {
                  finalhtml+=$(this).sort(function(a, b){
                    return ($(b).data('position')) < ($(a).data('position')) ? 1 : -1;
                  });
                });
            }else{
                $.each( $(".lead-items[data-itemids^='lp-lead-item']"), function () {
                  finalhtml+=$(this).sort(function(a, b){
                    return ($(b).data('position')) < ($(a).data('position')) ? -1 : 1;
                  });
                });
            }
            $("#myleads_results").html("");
            $("#myleads_results").html(finalhtml);

        });
    });

    $('body').on('change','input:checkbox',function(){
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
            alert("Please select at least one lead to print.");
            return;
        }else {
            unique_keys = unique_keys.substring(0, unique_keys.length - 1);
            var check_all=$("#selactionall").is(":checked") ? true : false;
            if(check_all==true){
                unique_keys=$("#allfunnelkey").val();
            }

            var client_id = $('#client_id').val();
            $.ajax( {
                type : "POST",
                url: site.baseUrl+site.lpPath+'/export/myleadsprint',
                data : "u=" + unique_keys + "&client_id=" + client_id+'&_token='+ajax_token,
                success : function(data) {
                    window.open(data,'popUpWindow','height=850,width=700,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
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
            $.ajax( {
                type : "POST",
                url: site.baseUrl+site.lpPath+'/export/myleadsemail',
                data : "u=" + unique_keys + "&client_id=" + client_id+'&_token='+ajax_token,
                success : function(data) {
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
        e.preventDefault();
        var unique_keys =  $(this).data("uniquekey");
        var client_id = $('#client_id').val();
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/export/myleadpopprint',
            data : "u=" + unique_keys + "&client_id=" + client_id+'&_token='+ajax_token,
            success : function(data) {
                window.open(data,'popUpWindow','height=850,width=700,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');
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
            url: site.baseUrl+site.lpPath+'/export/myleadpopemail',
            data : "u=" + unique_keys + "&client_id=" + client_id+"&_token="+ajax_token,
            success : function(data) {
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
        $('#leadpopconfirm').on('hidden.bs.modal', function ()
        {
            $("body").addClass('modal-open');
        });

    });
    function deletePopLead(unique_key,client_id){
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/myleads/deletepoplead',
            data : "u=" + unique_key + '&client_id=' + client_id+'&_token='+ajax_token,
            success : function(data) {
                $('#single-lead-modal').modal('hide');
                $("#page").val(1);
                $("#success-alert").find("span").text("Lead has been deleted.");
                $("#success-alert").fadeTo(3000, 500).slideUp("slow", function(){
                    $("#success-alert").slideUp("slow");
                });
                getPageData();

            },
            cache : false,
            async : false
        });
    }
    function deleteCurrent(unique_keys,stotal) {
        var client_id = $('#client_id').val();
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/myleads/deleteselectedleads/'+cur_hash,
            data : "u=" + unique_keys + '&client_id=' + client_id+'&_token='+ajax_token,
            success : function(data) {
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
        $("#target_ele").val(target_ele);
        if(check_all==false){
            $("#allfunnelkey").val(unique_keys);
        }
        var total_sel_leads=$("#allfunnelkey").val().split("~").length;
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
        $('#myleadsemail').modal('hide');
        var _lead_ids=$("#allfunnelkey").val();
        var client_id = $('#client_id').val();
        var email = $('#newemail').val();
        var export_type = $('#target_ele').val();
        $.ajax({

            url: site.baseUrl+site.lpPath+'/export/exportleadsemaildata/'+cur_hash,

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
        if(cnt > 0) {
            unique_keys = unique_keys.substring(0, unique_keys.length - 1);
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
                $( "input:checkbox[id^=selaction]").each(function() {
                    if($(this).is(':checked') && $(this).attr('id') != 'selactionall') {
                        cnt = cnt + 1;
                        key = $(this).data("uniquekey");
                        unique_keys = unique_keys +  key + "~";
                    }
                });
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
        oIFrm.src = url + '?u=' + unique_keys+'&client_id=' + client_id;
    }
    function capitalizeFirstLetter(string) {
        if(string.length > 0){
            return string[0].toUpperCase() + string.slice(1);
        }
    }
