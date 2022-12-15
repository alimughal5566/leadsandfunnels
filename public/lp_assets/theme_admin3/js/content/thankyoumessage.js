$(document).ready(function(){
    $( "#thankyou_slug" ).keydown(function() {
        var replaceSpace = $(this).val();
        var result = replaceSpace.replace(" ", "-");
        $("#thankyou_slug").val(result);
    });
    // setTimeout(function () {
    //     logo_trigger(false);
    // },400)



    var $form = $("#thankYouMessageForm");
    ajaxRequestHandler.init("#thankYouMessageForm");
    if (!$('#funnel_builder').length) {
        $('#main-submit').on('click', function () {
            ajaxRequestHandler.submitForm(function (response, isError) {
                console.log("Thank you message submit callback...", response, isError);
            }, true);

            // debugger;
            // if (GLOBAL_MODE) {
            //     if (checkIfFunnelsSelected()){
            //         //  debugger;
            //         if(confirmationModalObj.globalConfirmationCurrentForm == $form){
            //             console.log("THank you - global");
            //             $form.submit();
            //         } else {
            //             console.log("THank you - global popup");
            //             showGlobalRequestConfirmationForm($form);
            //         }
            //     }
            //     // form.submit();
            // } else {
            //     console.log("THank you - single");
            //     $form.submit();
            // }

        });
    }
    $(document).data('lpFroalaEditorLoadTemplateFor', 'thank-you-message');

});


//
function logo_trigger(event){
    let editor = lpHtmlEditor.getInstance(),
        advancehtml = editor.html.get(),
        defaultLogo  = $("#default_logo").attr('src'),
        client_id = $('#client_id').val(),
        current_hash=$('#current_hash').val(),
        toggleButton = $("#typ_logo");

    if(toggleButton.is(":checked")) {
        $("#thankyou_logo").val(1);
        let {hide} = displayAlert("loading", "Loading current logo...");
        toggleButton.bootstrapToggle('disable');
        $.ajax({
            type: "POST",
            url: site.baseUrl + site.lpPath + '/ajax/current_logo',
            data: "client_id=" + client_id + "&current_hash=" + current_hash + '&_token=' + ajax_token,
            success: function (data) {
                hide();
                if (data.status == true || data.status == 'true') {
                    defaultLogo = data.currentLogoSrc;
                }
                var html = "<img alt=\"\" id=\"defaultLogo\" style=\"max-width: 350px; max-height: 120px;\" src=\"" + defaultLogo + "\" class=\"fr-fic fr-dib thank-page-image\" />";
                editor.html.set("<p>&nbsp;</p><p id=\"defaultLogoContainer\" style=\"text-align: center;\">" + html + "</p>" + advancehtml);
                editor.undo.saveStep();
            }, complete: function(response){
                toggleButton.bootstrapToggle('enable');
            }
        });
    } else {
        $("#thankyou_logo").val(0);
      //  debugger;
      //  console.log(advancehtml);
        if(advancehtml) {
            advancehtml = advancehtml.replace(/<p(.*?)><span(.*?)><img(?=[^>]*id="defaultLogo")(.*?)><\/span><\/p>/g, '');
            advancehtml = advancehtml.replace(/<img(?=[^>]*id="defaultLogo")(.*?)>/g, '');
            advancehtml = advancehtml.replace(/<p(?=[^>]*id="defaultLogoContainer")(.*?)>(.*?)<\/p>/g, '');
            advancehtml = advancehtml.replace(/<p>&nbsp;<\/p>/, '');
            advancehtml = advancehtml.replace(/<p style="text-align:center;"><br><\/p>/, '');
        }
        editor.html.set(advancehtml);
        editor.undo.saveStep();
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
  /*  var html = '<div class="alert alert-success lp-success-msg">'+
                'Success! URL has been copied.'+
                '</div>';
    $(html).hide().appendTo("#msg").slideDown(500).delay(1000).slideUp(500 , function(){
        $(this).remove();
    });*/

    displayAlert('success', 'URL has been copied.');

});


