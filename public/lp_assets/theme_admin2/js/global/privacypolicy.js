var msg;
$(document).ready(function() {
    $('.close').click(function() {
        $("#alert-danger").find('span').text("");
        $('.alert').hide();
    });
    $('.gfooter-toggle').change(function() {
        if ($(this).prop('checked') == true) {
            $('#'+$(this).data('field')).val('y');
        }else {
            $('#'+$(this).data('field')).val('n');
        }
        $("#gfot-ai-flg").val('1');
        
    });
    mytoggledestination();
});
function mytoggledestination() {
    var thelink = $('#linktype').val();
    if(thelink == 'u') {
        $('#theselection').val('u');
        $('#webmodal').hide();
        $('#webaddress').show();
    }else if (thelink == 'm') {
        $('#theselection').val('m');
        $('#webaddress').hide();
        $('#webmodal').show();
    }else {
        $(".lp-auto-responder .lp-pp-box").css("padding-bottom","10px");
        $('#webaddress').hide();
        $('#webmodal').hide();
    }
}

function saveglobalprivacypolicy() {
    msg = '';
    var error=false;
    if ($("#lpkey_privacypolicy").val() == '') {
        msg = "Please Select Funnel From List.<br />";
        error=true;
    }
    var html = lp_html_editor.froalaEditor('html.get');
    theurl = $('#theurl').val();
    if($('#linktype').val() == '-1') {
        msg += "Choose your option and enter the appropriate data before saving.<br />";
        error=true;
    }
    if($('#linktype').val() == 'u' && ($('#theurl').val() == "" || $('#theurltext').val() == "")) {
        msg += "Choose your option and enter the appropriate data before saving.<br />";
        error=true;
    }
    if(html == "" && $('#linktype').val() == 'm') {
        msg += "Choose your option and enter the appropriate data before saving.<br />";
        error=true;
    }
    if($('#linktype').val() == 'u' && ((theurl.toLowerCase().indexOf("http://") < 0) && (theurl.toLowerCase().indexOf("https://") < 0))) {
        msg += "Please enter the correct url including http.";
        error=true;
    }
    if(error===false){
        $('#gffooter').submit();
    }else {
        errormessage();
    }
}
function errormessage(){
    $("#alert-danger").find('p').html(msg);
    $("#alert-danger").fadeIn("slow");
    return false;
}
