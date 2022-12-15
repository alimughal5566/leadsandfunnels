$(document).ready(function() {

    var amIclosing = false;
    $('.select2js__linkpage-option').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__linkpage-option-parent')
    }).on('change', function (e) {
        console.info($(this).val());
        var this_val = $(this).val();
        if(this_val == 'u') {
            $('.another-web').slideDown();
            $('.own-web').slideUp();
        }
        else {
            $('.another-web').slideUp();
            $('.own-web').slideDown();
        }
    }).on('select2:openning', function() {
        jQuery('.select2js__linkpage-option-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__linkpage-option-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__linkpage-option-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__linkpage-option-parent .select2-dropdown').hide();
        jQuery('.select2js__linkpage-option-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__linkpage-option-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__linkpage-option-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2js__linkpage-option').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__linkpage-option-parent .select2-selection__rendered').show();
        jQuery('.select2js__linkpage-option-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.gfooter-toggle').change(function() {
        if ($(this).prop('checked') == true) {
            $('#'+$(this).data('field')).val('y');
        }else {
            $('#'+$(this).data('field')).val('n');
        }
        $("#gfot-ai-flg").val('1');

    });


    $('.gfooter-toggle').change(function() {
        if ($(this).prop('checked') == true) {
            $('#'+$(this).data('field')).val('y');
        }else {
            $('#'+$(this).data('field')).val('n');
        }
        $("#gfot-ai-flg").val('1');

    });



    var privacy_msg_html = "";

    //$("#success-alert,#alert-danger").hide();
    $('.close').click(function() {
        $('.alert').hide();
    });
    $( "body" ).on( "change",".pptogbtn" , function() {
        if(!GLOBAL_ADJUSTMENT && !GLOBAL_MODE) {
            var con_key = $(this).data('lpkeys');
            // detailincludepage(con_key);
        }
    });



  //  mytoggledestination();


    $.validator.addMethod("cus_url", function (value, element) {
        return this.optional(element) || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Please enter a valid url.");


    var $form = $('#pricay-page');
    ajaxRequestHandler.init("#pricay-page");

    $('#main-submit').on('click', function () {
        $form.submit();
    });




    var valid_obj = $($form).validate({
        rules: {
            theurltext: {
                required: function (element) {
                    return $("#fp-privacy-policy").is(':checked');
                }
            },
            theurl: {
                required: function (element) {
                    return $("#linktype").val() == "u" && $("#fp-privacy-policy").is(':checked');
                },
                url: function (element) {
                    return $("#linktype").val() == "u" && $("#fp-privacy-policy").is(':checked');
                }
            }
        },
        messages: {
            theurltext: {
                required: "Please enter link text."
            },
            theurl: {
                required: "Please enter your URL."
            },
        },
        debug: false,
        submitHandler: function (form) {
            if(savebottomlinkmessage()) {
                ajaxRequestHandler.submitForm(function (response, isError) {
                    console.log("submit privacy policy callback...", response, isError);
                });

                // if (GLOBAL_MODE) {
                //     if (checkIfFunnelsSelected()) {
                //         //  debugger;
                //         if (confirmationModalObj.globalConfirmationCurrentForm == $form) {
                //             form.submit();
                //         } else {
                //             showGlobalRequestConfirmationForm($form);
                //         }
                //     }
                // } else {
                //     form.submit();
                // }
            }
        }
    });

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

        $('#linktype').val("u");
        $('#webmodal').hide();
        $('#webaddress').show();
    }
}
function detailincludepage(lpkeys) {

    if(GLOBAL_MODE){

        return false;

    } else {

        var client_id = $('#client_id').val();
        var akeys = lpkeys.split("~");
        var vertical_id = akeys[0];
        var subvertical_id = akeys[1];
        var leadpop_id = akeys[2];
        var version_seq = akeys[3];
        var thelink = akeys[4];
        var post = "client_id=" + client_id + "&vertical_id=" + vertical_id + "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink + "&_token=" + ajax_token;
        $.ajax({
            type: "POST",
            url: "/lp/ajax/updatebottomlinks",
            data: post,
            success: function (d) {
            },
            cache: false,
            async: false
        });
    }
}
function savebottomlinkmessage() {
    console.info("call");
    if(!$("#fp-privacy-policy").is(':checked')) {
        return true;
    }

    let error=false,
        theurl = $('#theurl').val();
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
            let editor = lpHtmlEditor.getInstance();
            if(editor.core.isEmpty()){
                errormessage("Please enter details.");
                editor.events.focus(true);
                error=true;
            }
            break;
        default:
                errormessage("Choose your option and enter the appropriate data before saving.");
                error=true;
            break;
    }
    return !error;
}
function errormessage(textval){
    $('#main-submit').prop('disabled', true);
    setTimeout(function () {
        $('#main-submit').prop('disabled', false);
        displayAlert("danger", textval);
    }, 1100);

   /* $("#alert-danger").find('p').text(textval);
    $("#alert-danger").fadeIn("slow");
    goToByScroll("alert-danger");
    $("#alert-danger").fadeTo(2000, 2000).slideUp(2000, function(){
        $("#alert-danger").slideUp(2000);
    });*/
    //return false;
}
