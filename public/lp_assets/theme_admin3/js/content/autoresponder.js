$(document).ready(function () {
    //    Auto responder
    // $('input[data-id]').click(function () {
    //     $('.lp-email-section').removeClass('editor-active');
    //     var cur_editor=$(this).data('id').split("-");
    //     $("#theoption").val(cur_editor[0]);
    //     $("#lp-"+$(this).data('id')).addClass('editor-active');
    //     if ($('#textwrapper').hasClass('editor-inactive')) {
    //         $('#textwrapper').removeClass('editor-inactive');
    //     } else {
    //         $('#textwrapper').addClass('editor-inactive');
    //     }
    // });
    // $('input[data-id]').click(function () {
    // 	$('.lp-email-section').removeClass('editor-active');
    // 	$("#lp-"+$(this).data('id')).addClass('editor-active');
    //
    // 	if ($('#textwrapper').hasClass('hide')) {
    // 		$('#textwrapper').removeClass('hide');
    // 	} else {
    // 		$('#textwrapper').addClass('hide');
    // 	}
    // });

    var tid = '';
    $('#htmlemail, #textemail').on('change', function (e) {
        if (tid === '')
            tid = e.currentTarget.id;
        if (e.currentTarget.id !== tid)
            return false;
        tid = e.currentTarget.id;
        setTimeout(function () {
            tid = ''
        }, 400);


        var val = $(this).val();
        var htmlemail = '';
        var textemail = '';

        htmlemail = $('#htmlemail').data('val');
        textemail = $('#textemail').data('val');

        if ($('#htmlemail').is(':checked')) {
            $('#active_respondertext').val('n');
            $('#active_responderhtml').val('y');
            $('#theoption').val('html');
            $(".html-email__body").show();
            $(".text-email__body").hide();
        } else if ($('#textemail').is(':checked')) {
            $('#active_respondertext').val('y');
            $('#active_responderhtml').val('n');
            $('#theoption').val('text');
            $(".html-email__body").hide();
            $(".text-email__body").show();
        }
        console.log("Checks", $('#htmlemail').is(':checked'), $('#textemail').is(':checked'));
    });


    $("body").on("change", "#autoreschk", function () {
        var active_value = "n";
        if ($("#autoreschk:checked").val()) {
            active_value = "y";

        } else {
            active_value = 'n';
        }

        $('#active').val(active_value);
        var con_key = $(this).data('lpkeys') + "~" + $('input[name=theoption]:checked').val() + "_active";
    });

    /*
     *
     // Auto responder form validation
     *
     */

    var $form = $("#add_autoresponder");
    ajaxRequestHandler.init("#add_autoresponder", {
        autoEnableDisableButton: false
    });

    $('#main-submit').on('click', function () {
        $("#sinle").val($("#subline").val());
        $form.submit();
    });

    /**
     * This function will addd styles on CTA button inline in froala editor so that
     * CTA is styled correctly in email body
     */
    function updateFroalaEditorStyles(){
        $('.fr-element.fr-view .za_cta_style').each(function (){
            var styles = [
                'padding: 0.5em 1em;',
                'border-radius: 50px;',
                'line-height: 1;',
                'background-color: rgb(255,135,0);',
                'border: 2px solid rgb(255,135,0);',
                'color: rgb(255,255,255);',
                'text-decoration: none;',
                'text-align: center;',
                'margin-top: 4px;',
                'vertical-align: middle;',
                'background-image: none;',
                'display: inline-block;'
            ];

            $(this).attr('style', styles.join(''));
        })

        let editor = lpHtmlEditor.getInstance();
        $('[name="htmlautoeditor"]').val(editor.html.get());
    }
    $form.validate({
        rules: {
            subline: {
                required: function (element) {
                    return $("#autoreschk").is(':checked');
                }
            }
        },
        messages: {
            subline: "Please enter your message subject."
        },
        submitHandler: function (form) {
            updateFroalaEditorStyles();
            ajaxRequestHandler.submitForm(function (response, isError) {
                console.log("Autoresponder submit callback...", response, isError);
            });

            // if (GLOBAL_MODE) {
            //     if (checkIfFunnelsSelected()) {
            //         if (confirmationModalObj.globalConfirmationCurrentForm == $form) {
            //             updateFroalaEditorStyles();
            //             form.submit();
            //         } else {
            //             showGlobalRequestConfirmationForm($form);
            //         }
            //     }
            //     // form.submit();
            // } else {
            //     updateFroalaEditorStyles()
            //     form.submit();
            // }
        }

    });

    if ($('#auto_active').val() == 'html') {
        $("#htmlemail").trigger("click");
        $(".html-email__body").show();
        $(".text-email__body").hide();
    } else {
        $("#textemail").trigger("click");
        $(".html-email__body").hide();
        $(".text-email__body").show();
    }

});


function includeauto(lpkeys, active_value) {
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
        url: site.baseUrl + site.lpPath + '/popadmin/updateautoresponder',
        //url : "/updateautorespondertest.php",
        data: post,
        success: function (d) {
            //                         alert(d);
            var change = d.split("~");
            var imgId = change[0];
            var toggle = change[1];
            var active = change[2];
            $('#active_responderhtml , #active_respondertext').val(active);
            if (toggle == 'y') {
                $('#thankyou_activelink').attr('href', "#");
                $('#information_activelink').attr('href', "#");
                $('#thirdparty_activelink').attr('href', "#");
            }
            if (active == 'y') {
                // $('#'+imgId).attr('src','/images/active.png');
                $('#text_active').attr('src', '/images/active.png');
                $('#html_active').attr('src', '/images/active.png');
            } else if (active == 'n') {
                // $('#'+imgId).attr('src','/images/inactive.png');
                $('#text_active').attr('src', '/images/inactive.png');
                $('#html_active').attr('src', '/images/inactive.png');
            }
        },
        cache: false,
        async: false
    });

}
