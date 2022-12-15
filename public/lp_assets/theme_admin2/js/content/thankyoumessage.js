$(document).ready(function(){
    $( "#thankyou_slug" ).keydown(function() {
        var replaceSpace = $(this).val();
        var result = replaceSpace.replace(" ", "-");
        $("#thankyou_slug").val(result);
    });
    logo_trigger(false);
});
//
function logo_trigger(triggerAjax){
    var isLogoAjaxCall = triggerAjax == undefined ? true : false;
    var advancehtml = $('.lp-froala-textbox').froalaEditor('html.get');
    var defaultLogo  = $("#default_logo").attr('src');
    var client_id = $('#client_id').val();
    var funneldata=$('#funneldata').val();

    if($("#typ_logo").is(":checked")) {
        $("#thankyou_logo").val(1);
        if(isLogoAjaxCall) {
            $.ajax({
                type: "POST",
                url: site.baseUrl + site.lpPath + '/ajax/current_logo',
                data: "client_id=" + client_id + "&funneldata=" + funneldata + '&_token=' + ajax_token,
                success: function (data) {
                    if (data.status == true || data.status == 'true') {
                        defaultLogo = data.currentLogoSrc;
                    }
                    var html = "<img alt=\"\" id=\"defaultLogo\" style=\"max-width: 350px; max-height: 120px;\" src=\"" + defaultLogo + "\" />";
                    $('.lp-froala-textbox').froalaEditor('html.set', "<p id=\"defaultLogoContainer\" style=\"text-align: center;\">" + html + "</p>" + advancehtml);
                }
            });
        } else {
            var html = "<img alt=\"\" id=\"defaultLogo\" style=\"max-width: 350px; max-height: 120px;\" src=\"" + defaultLogo + "\" />";
            $('.lp-froala-textbox').froalaEditor('html.set', "<p id=\"defaultLogoContainer\" style=\"text-align: center;\">" + html + "</p>" + advancehtml);
        }
    } else {
        $("#thankyou_logo").val(0);
        advancehtml = advancehtml.replace(/<img(?=[^>]*id="defaultLogo")(.*?)>/g, '');
        advancehtml = advancehtml.replace(/<p(?=[^>]*id="defaultLogoContainer")(.*?)>(.*?)<\/p>/g, '');
        advancehtml = advancehtml.replace(/<p style="text-align: center;"><br><\/p>/, '');
        //advancehtml = advancehtml.replace(/<p>(.*?)<\/p>/, '');
        $('.lp-froala-textbox').froalaEditor('html.set', advancehtml);
    }
}

function copyToClipboard(element) {
    var $temp = $("<INPUT>");
    $("body").append($temp);
    $temp.val($.trim($(element).text())).select();
    document.execCommand("copy");
    $temp.remove();
}
$('#clone-url').click(function(){
    copyToClipboard($('#url-text'));
    var html = '<div class="alert alert-success lp-success-msg">'+
                'Success! Thank You Page URL has been copied'+
                '</div>';
    $(html).hide().appendTo("#msg").slideDown(500).delay(1000).slideUp(500 , function(){
        $(this).remove();
    });

});


