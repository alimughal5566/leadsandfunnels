$(document).ready(function() {
    $('.close').click(function() {
     $('.alert').hide();
    });
    $( "body" ).on( "change",".pptogbtn" , function() {
        var con_key=$(this).data('lpkeys');
        detailincludepage(con_key);
    });
    mytoggledestination();
});
function mytoggledestination() {
    var thelink = $('#linktype').val();
    if(thelink == 'u') {
        $('#theselection').val('u');
        $('#webmodal').hide();
        $('#webaddress').show();
    }
    else if (thelink == 'm') {
        $('#theselection').val('m');
        $('#webaddress').hide();
        $('#webmodal').show();
    }
    else {
        $(".lp-auto-responder .lp-pp-box").css("padding-bottom","10px");
        $('#webaddress').hide();
        $('#webmodal').hide();
    }
}
function detailincludepage(lpkeys) {
    var client_id = $('#client_id').val();
    var akeys = lpkeys.split("~");
    var vertical_id = akeys[0];
    var subvertical_id = akeys[1];
    var leadpop_id = akeys[2];
    var version_seq = akeys[3];
    var thelink =  akeys[4];
    var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink+ "&_token="+ajax_token;
    $.ajax( {
        type : "POST",
        url : "/lp/ajax/updatebottomlinks",
        data : post,
        success : function(d) {
        },
        cache : false,
        async : false
    });
}
function savebottomlinkmessage() {
    var error=false;
    var html =  lp_html_editor.froalaEditor('html.get');
    var theurl = $('#theurl').val();
    switch ($('#linktype').val()){
        case 'u':
            if($('#theurltext').val() == ""){
                errormessage("Please enter Link Text.");
                error=true;
            }
            else if($('#theurl').val() == "" || ((theurl.toLowerCase().indexOf("http://") < 0) && (theurl.toLowerCase().indexOf("https://") < 0))){
                errormessage("Please enter a valid URL.");
                error=true;
            }
            break;
        case 'm':

            if($('#theurltext').val() == ""){
                errormessage("Please enter Link Text.");
                error=true;
            }else if(html==""){
                errormessage("Please enter the detail.");
                error=true;
            }
            break;
        default:
            errormessage("Choose your option and enter the appropriate data before saving.");
            error=true;
            break;
    }
    if(error===false){
        $('#ffooter').submit();
    }
}
function errormessage(textval){
    $("#alert-danger").find('p').text(textval);
    $("#alert-danger").fadeIn("slow");
    return false;
    /*$("#alert-danger").fadeTo(2000, 2000).slideUp(2000, function(){
        $("#alert-danger").slideUp(2000);
    });               */
    //return false;
}
