$(document).ready(function () {
    // openSections is defined in footeroption.blade.php
    for(section of openSections){
        if(section){
            $('#'+section).collapse('show');
        }
    }
    /*$('.lp-footer-collapse').click(function () {
        if($(this).hasClass('footer-expand')){
            $(this).html('<i class="fa fa-times" aria-hidden="true"></i>Collapse');
            // $(this).removeClass('footer-expand');
        }else{
            $(this).html('<i class="fa fa-arrows-alt" aria-hidden="true"></i>Expand');
            // $(this).addClass('footer-expand');
        }
    });*/

    var $form = $('#footer-page');
    ajaxRequestHandler.init('#footer-page');

    $('.sticky-tooltip').tooltip();


    $(".bombbomb-wrapper img").mouseout(function () {
        $(".bombomb_desc").css('display', 'none');
    });

    $("#success-alert").hide();
    $("#advanced-success-alert").hide();
    // $('#primaryfooter').collapse('hide');

    function saveForm(){
        ajaxRequestHandler.submitForm(function (response, isError) {
            console.log("Footer Options submit callback...", response, isError);
        }, true);

        // if (GLOBAL_MODE) {
        //     if (checkIfFunnelsSelected()) {
        //         if (confirmationModalObj.globalConfirmationCurrentForm === $form) {
        //             $($form).submit();
        //         } else {
        //             showGlobalRequestConfirmationForm($form);
        //         }
        //     }
        // } else {
        //     $($form).submit();
        // }
    }

    $('#main-submit').click(function (e) {

        var onButtons = [];

        if($("#primaryfooter").hasClass('show')){
            onButtons.push('primaryfooter');
        }
        if($("#secondaryfooter").hasClass('show')){
            onButtons.push('secondaryfooter');
        }
        if($("#superfooter").length && $("#superfooter").hasClass('show')){
            onButtons.push('superfooter');
        }

        openSections = onButtons.join(',');
        $('#openSections').val(openSections);

        var fields = ["compliance_text", "compliance_link", "license_number_text", "license_number_link", "license_number_is_linked", "compliance_is_linked"];

        fields.forEach(function (field) {
            var value = '';
            var $el = $('#' + field);
            if ($el.is(':checkbox')) {
                value = $el.get(0).checked ? 'y' : 'n'
            } else {
                value = $el.val()
                $el.removeClass("error");
            }
            $('[name="' + field + '"]').val(value)
        });

        if(isValidSecondaryFooterOptions()) {
            if(superFooterUpdate()) {
                saveForm();
            }
        }
    });

    $("#_update_template_cta_btn").click(function (e) {
        var radioValue = $("input[name='property_cta']:checked").val();
        $('#update_template_cta').val(radioValue);
        $('#modal_proerty_template').modal('hide');

        if(superFooterUpdate(false, radioValue)) {
            saveForm();
        }
    });

    $(document).data('lpFroalaEditorLoadTemplateFor', 'footer');

});




//Url-edit-footer ,liences edit
$('.lp_footer_toggle').click(function (e) {
    e.preventDefault();
    var tar_ele = $(this).data('togele');
    if ($('#' + tar_ele).hasClass('hide')) {
        $(this).html('<i class="fa fa-remove"></i> CANCEL');
        $('#' + tar_ele).removeClass('hide');
    } else {
        $('#' + tar_ele).addClass('hide');
        $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
    }
});
$('.lp_footer_toggle_compliance').click(function (e) {
    e.preventDefault();
    var tar_ele = $(this).data('togele');
    if ($('#' + tar_ele).hasClass('hide')) {
        $(this).html('<i class="fa fa-remove"></i> CANCEL');

        $('#compliance_text').prop("disabled", false);
        $('#' + tar_ele).removeClass('hide');

    } else {
        $('#' + tar_ele).addClass('hide');
        $('#compliance_text').prop("disabled", true);
        $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
    }
});
$('.lp_footer_toggle_licence').click(function (e) {
    e.preventDefault();
    var tar_ele = $(this).data('togele');
    if ($('#' + tar_ele).hasClass('hide')) {
        $(this).html('<i class="fa fa-remove"></i> CANCEL');
        $('#license_number_text').prop("disabled", false);
        $('#' + tar_ele).removeClass('hide');
    } else {
        $('#' + tar_ele).addClass('hide');
        $('#license_number_text').prop("disabled", true);
        $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
    }
});
$('#compliance_is_linked,#license_number_is_linked').change(function () {
    var tar_ele = $(this).data('tarele');
    if ($(this).is(':checked')) {
        $('#' + tar_ele).prop('disabled', false);
    } else {
        $('#' + tar_ele).prop('disabled', true);
    }
});

$(document).on('click', "#_reset_default_btn", function (e) {
    resetdefaultfooter();
});


$('.action__link_edit').click(function () {
    $(this).hide();
    $(this).closest('.lp-panel').find('.line-input').prop("disabled", false);
    $(this).closest('.lp-panel').find(".action__link_cancel").css({display: "flex"});
    $(this).closest('.lp-panel').find('.collapse-box').slideDown();
});
$('.action__link_cancel').click(function () {
    $(this).closest('.lp-panel').find('.action__link_cancel').hide();
    $(this).closest('.lp-panel').find('.action__link_edit').show();
    $(this).closest('.lp-panel').find('.line-input').prop("disabled", true);
    $(this).closest('.lp-panel').find('.collapse-box').slideToggle();
});

$('.collapse-checkbox').change(function () {
    if ($(this).is(':checked')) {
        $(this).closest('.lp-panel').find('.collapse-next-input').prop("disabled", false);
    } else {
        $(this).closest('.lp-panel').find('.collapse-next-input').prop("disabled", true);
    }
});


/*function compliance_update () {
    var error=false;
    var client_id = $('#client_id').val();
    if ($("#lpkey_secfot").val() == '') {
        errormessage("Please select Funnels for global action. <br>");
        return;
    }
    //$("#leadpopovery").show();
    $("#mask").show();
    var compliance_text = $('#compliance_text').val();
    var compliance_is_linked = 'n';
    var compliance_link = $('#compliance_link').val();
    var license_number_text = $('#license_number_text').val();

    if($('#compliance_is_linked:checkbox:checked').length){
        if(compliance_link=="")
            compliance_link = "#";
        label_compliance_text = "<a target='_blank' href='"+compliance_link+"'>"+compliance_text+"</a>";
        compliance_is_linked = 'y';
    }else{
        label_compliance_text = compliance_text;
    }

    var license_number_is_linked = 'n';
    if($('#license_number_is_linked:checkbox:checked').length){
        license_number_is_linked = 'y';
    }
    var license_number_link = $('#license_number_link').val();

    $('#label_compliance_text').html(label_compliance_text);
    $('#label_license_number_text').html(license_number_text);

    //var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&compliance_text="+compliance_text+"&compliance_is_linked="+compliance_is_linked+"&compliance_link="+compliance_link+"&license_number_text="+license_number_text+"&license_number_link="+license_number_link+"&license_number_is_linked="+license_number_is_linked;
    var post = {client_id:client_id,lpkey_secfot:$("#lpkey_secfot").val(),compliance_text:compliance_text,compliance_is_linked:compliance_is_linked,compliance_link:compliance_link,license_number_text:license_number_text,license_number_link:license_number_link,license_number_is_linked:license_number_is_linked,_token:ajax_token};
    post.sec_fot_url_active=$("#sec_fot_url_active").val();
    post.sec_fot_license_number_active=$("#sec_fot_license_number_active").val();
    post.gfot_ai_val=$("#gfot_ai_val").val();
    post.gfot_ai_val1=$("#gfot_ai_val1").val();
    post.thelink=$("#thelink").val();
    post.gfot_ai_flg=$("#gfot-ai-flg").val();
    post.gfot_ai_flg1=$("#gfot-ai-flg1").val();
    console.log(post);
    if(error===false){
        $.ajax( {
            type : "POST",
            url: site.baseUrl+site.lpPath+'/global/updatecompliance',
            data : post,
            success : function(data) {
                var obj = jQuery.parseJSON( data );
                /!*console.log(obj.changeto);
                console.log(obj.changeto1);
                console.log(obj.result);*!/
                if(obj.changeto !="undefined" && obj.changeto !="" ){
                    $("#sec_fot_url_active").val(obj.changeto);
                    $("#gfot_ai_val").val(obj.changeto);
                }
                if(obj.changeto1 !="undefined" && obj.changeto1 !="" ){
                    $("#sec_fot_license_number_active").val(obj.changeto1);
                    $("#gfot_ai_val1").val(obj.changeto1);
                }
                //$("#leadpopovery").hide();
                $("#mask").hide();
                $("#gfot-ai-flg").val('0');
                $("#gfot-ai-flg1").val('0');
                if(obj.result==true){
                    $("#success-alert").find("span").text("Success ! Global Secondary Footer Option has been saved..");
                    goToByScroll("success-alert");
                    $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                        $(this).slideUp(500);
                    });
                }else{
                    errormessage("Error:Setting compliance and lincense.");
                }
            }
        });
    }
    return false;
}*/


// function updatetemplatecta(lpkeys) {


//     var client_id = $('#client_id').val();
//     var akeys = lpkeys.split("~");
//     var vertical_id = akeys[0];
//     var subvertical_id = akeys[1];
//     var leadpop_id = akeys[2];
//     var version_seq = akeys[3];
//     var thelink = akeys[4];
//     var logocolor = $('#logocolor').val();
//     var templatetype = $('#templatetype').val();
//     var post = "client_id=" + client_id + "&is_global= false" + "&vertical_id=" + vertical_id + "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&logocolor=" + logocolor + "&thelink=" + thelink + "&templatetype=" + templatetype + "&_token=" + ajax_token;
//     console.info(post);
//     debugger;
//     var globalMode = $('#footer-page').data('global_mode');
//     $.ajax({
//         type: "POST",
//         url: "/lp/ajax/updatetemplatecta",
//         data: post,
//         success: function (d) {
//             if (d == 'y') {
//                 $('#modal_proerty_template').modal('toggle');
//             }
//         },
//         cache: false,
//         async: false
//     });
// }


function hidetoggel(toggle, text) {

    var tar_ele = $(toggle).data('togele');
    if ($('#' + tar_ele).hasClass('hide')) {
        $(toggle).html('<i class="fa fa-remove"></i> CANCEL');
        $(text).prop("disabled", false);
        $('#' + tar_ele).removeClass('hide');
    } else {
        $('#' + tar_ele).addClass('hide');
        $(text).prop("disabled", true);
        $(toggle).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
    }
}


// function includepage(lpkeys) {
//     var client_id = $('#client_id').val();
//     var akeys = lpkeys.split("~");
//     var vertical_id = akeys[0];
//     var subvertical_id = akeys[1];
//     var leadpop_id = akeys[2];
//     var version_seq = akeys[3];
//     var thelink = akeys[4];
//     var post = "";
//     var url = "";
//     debugger;


//     url = "/lp/ajax/updatebottomlinks";

//     post = "client_id=" + client_id +
//         "&vertical_id=" + vertical_id +
//         "&subvertical_id=" + subvertical_id +
//         "&leadpop_id=" + leadpop_id +
//         "&version_seq=" + version_seq +
//         "&thelink=" + thelink + "&_token=" + ajax_token;

//     $.ajax({
//         type: "POST",
//         url: url,
//         data: post,
//         success: function (d) {
//             /*var change = d.split("~");
//             var imgId = change[0];
//             var toggle = change[1];
//             var linkchange = change[2];
//             if(toggle == 'y') {
//                 $('#'+imgId).attr('src','/images/active.png');
//                 $('#'+imgId + 'link').attr('href',linkchange);
//             }
//             else   if(toggle == 'n') {
//                 $('#'+imgId).attr('src','/images/inactive.png');
//                 $('#'+imgId + 'link').attr('href','#');
//             }*/
//         },
//         cache: false,
//         async: false
//     });
// }





function includepage_update(lpkeys) {
    var client_id = $('#client_id').val();
    var akeys = lpkeys.split("~");
    var vertical_id = akeys[0];
    var subvertical_id = akeys[1];
    var leadpop_id = akeys[2];
    var version_seq = akeys[3];
    var thelink = akeys[4];
    var post = "client_id=" + client_id + "&vertical_id=" + vertical_id + "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&thelink=" + thelink + "&_token=" + ajax_token;

    debugger;
    var globalMode = $('#footer-page').data('global_mode');

    $.ajax({
        type: "POST",
        url: "/lp/ajax/updatebottomlinks",
        data: post,
        success: function (d) {
            var change = d.split("~");
            var imgId = change[0];
            var toggle = change[1];
            var linkchange = change[2];
            if (toggle == 'y') {
                $('.' + imgId).attr('src', '/images/active.png');
            }
            else if (toggle == 'n') {
                $('.' + imgId).attr('src', '/images/inactive.png');
            }
        },
        cache: false,
        async: false
    });
    return false;
}

// ****************************************************************************//
// **************************Primary FOOTER *********************************//
// ****************************************************************************//


/*$(".global_switch_holder").click(function() {
   // debugger;
    if(GLOBAL_MODE){
        if (!checkIfFunnelsSelected()) {
            $('.global-switch').bootstrapToggle('disable')
        } else {
            $('.global-switch').bootstrapToggle('enable')
        }
    } else {
      //  $('.global-switch').bootstrapToggle('enable')
    }

});*/

$("body").on("change", ".pfobtn,.sfobtn", function (e) {

    //  debugger;
    /*    if (GLOBAL_ADJUSTMENT) {
            if (GLOBAL_MODE) {
                if (checkIfFunnelsSelectedWithoutMessage()) {
                    $(this).bootstrapToggle('enable')
                } else {
                    $(this).bootstrapToggle('disable')
                }
            }
            return false;
        }*/


    /*    if (GLOBAL_MODE) {

            if (!checkIfFunnelsSelected()) {
                e.preventDefault();
                return false;
            }

            const thelink = $(this).data('thelink');
            const status = $(this).prop('checked') ? 'y' : "n";
            const post = {
                thelink: thelink,
                status: status
            }

            if (thelink !== 'compliance_active' &&
                thelink !== 'license_number_active') {
                // these two will be handled in save
                includePageGlobal(post);
            }

            return false;
        } else {
            var con_key = $(this).data('lpkeys');
            var is_advance_footer = $(this).attr("data-lpkeys");

            is_advance_footer = is_advance_footer.split("~");
            /!* if (window.speacific_advance_footer == 1 && is_advance_footer[4] == "advanced_footer_active") {
                 $(".lp-footer-save .col-xs-push-1 button").trigger("click");
             }*!/

            includepage(con_key);

        }*/

});





// ****************************************************************************//
// ************************** Super FOOTER ************************************//
// ****************************************************************************//

function superFooterUpdate(cta_update = true, defaultTplCtaMessage = "n") {
    /*  if (GLOBAL_ADJUSTMENT)
          return false;*/
    /*  if (GLOBAL_MODE) {
          if (!checkIfFunnelsSelected())
              return false
      }*/
    // var lpkeys = $('#lp-keys-value').val();
    // var client_id = $('#client_id').val();
    // var akeys = lpkeys.split("~");
    // var vertical_id = akeys[0];
    // var subvertical_id = akeys[1];
    // var leadpop_id = akeys[2];
    // var version_seq = akeys[3];
    var advancehtml = FroalaEditor('.lp-froala-textbox');
    // advancehtml = advancehtml.replace("<p><br></p><p><br></p>", "");
    var templatetype = $('#templatetype').val();

    if ((templatetype == 'property_template' || templatetype == 'property_template2') && cta_update) {
        // $("#modal_proerty_template").find(".modal-msg").html('<p>Would you like to use our default CTA Message that goes with Property Template?</p>');
        $("#modal_proerty_template").modal();
        return false;
    }

    // var hideofooter = '';

    // if ($('#hideofooter:checkbox:checked').length) {
    //     hideofooter = 'y';
    // } else {
    //     hideofooter = 'n';
    // }

    // var post = "client_id=" + client_id + "&vertical_id=" + vertical_id + "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&hideofooter=" + hideofooter + "&version_seq=" + version_seq + "&templatetype=" + templatetype + "&defaultTplCtaMessage=" + defaultTplCtaMessage + "&advancehtml=" + escape(advancehtml) + "&_token=" + ajax_token;

    var fields = {
        defaultTplCtaMessage: defaultTplCtaMessage,
        advancehtml: advancehtml
    }
    for (var name in fields) {
        $('[name="' + name + '"]').val(fields[name])
    }
    // var url = $('#footer-page').prop('action');
    // var url = '';

    // $('#superFooterUpdateId').prop('disabled', true);

    // url = GLOBAL_MODE ? '/lp/global/updateglobaladvancefooterAdminThree' : "/lp/ajax/updateadvancefooter";
    // $.ajax({
    //     type: "POST",
    //     // url: "/lp/ajax/updateadvancefooter",
    //     url: url,
    //     data: post,
    //     success: function (d) {
    //         //             if ( $('#compliance_text').prop( "disabled" ) )
    //         //         	{
    //         //                 hidetoggel(".lp_footer_toggle_licence","#license_number_text");
    //         // } else{
    //         //                 hidetoggel(".lp_footer_toggle_compliance","#compliance_text");
    //         // }


    //         /*goToByScroll("advanced-success-alert");
    //         $("#advanced-success-alert").fadeTo(2000, 500).slideUp(500, function () {
    //             $(this).slideUp(500);
    //         });*/
    //         setTimeout(function () {
    //             displayAlert('success', 'Advanced Footer Option has been saved.');
    //             $('#superFooterUpdateId').prop('disabled', false);
    //         }, 1500);


    //     },
    //     cache: false,
    //     async: false
    // });
    return true;
}

function resetSuperFooterOptions() {

    if (GLOBAL_MODE) {

        /*    if (GLOBAL_ADJUSTMENT)
                return false;*/
        if (!checkIfFunnelsSelected())
            return false;
    }

    $("#notification_confirmPixelDelete").html('Are you sure you want to reset back to the default advanced footer content?');
    //$("#id_confirmPixelDelete").val( $(this).attr('data-id') );
    $("#id_confirmPixelDelete").val($(this).attr('data-id'));

    $("#model_confirmPixelDelete").modal('show');

    // console.info($('#default-html').html());
    //$('.lp-froala-textbox').html($('#default-html').html());

    //   resetdefaultfooter();
    // $("#modal_reset_default").find(".modal-msg").html('<p>Are you sure you want to reset back to the default advanced footer content?</p>');
    // $("#modal_reset_default").modal();
}


$(".btnAction_confirmPixelDelete").click(function (e) {
    e.preventDefault();

    if (GLOBAL_MODE) {

        /* if (GLOBAL_ADJUSTMENT)
             return false;*/
        if (!checkIfFunnelsSelected())
            return false;
    }
    resetdefaultfooter()
    //  deletePixelCode($(this));
});


function resetdefaultfooter() {
    insertTemplate('default_template');
    $('#model_confirmPixelDelete').modal('toggle');
    $('#superfooter .lp-panel__footer .save_option').trigger('click');
}

/**
 * validate secondary footer options fields
 * @returns {boolean}
 */
function isValidSecondaryFooterOptions() {
    var isValid= true,
        urlRegex = new RegExp(/^(?:(?:(?:https?):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i),
        message = "Required field(s) left blank.";

    // Validate when compliance text is active
    if($('#sec_fot_url_active_switch').prop("checked")) {
        if(!$('#compliance_text').val()) {
            $('#compliance_text').addClass("error");
            isValid = false;
        }

        // Validate when link to URL is active
        if($('#compliance_is_linked').prop("checked")) {
            if(!$('#compliance_link').val()) {
                $('#compliance_link').addClass("error");
                isValid = false;
            }else if(isValid && !urlRegex.test($('#compliance_link').val())) {
                message = "Please enter a valid URL.";
                $('#compliance_link').addClass("error");
                isValid = false;
                $('#compliance_text').parent().parent().find(".action__link_edit").trigger("click");
            }
        }
    }

    // Validate when license number is active
    if($('#sec_fot_license_number_active_switch').prop("checked")) {
        if(!$("#license_number_text").val()) {
            $('#license_number_text').addClass("error");
            isValid = false;
        }

        if($('#license_number_is_linked').prop("checked")) {
            if(!$('#license_number_link').val()) {
                $('#license_number_link').addClass("error");
                isValid = false;
            // Validate when link to URL is active
            }else if(isValid && !urlRegex.test($('#license_number_link').val())) {
                message = "Please enter a valid URL.";
                $('#license_number_link').addClass("error");
                isValid = false;
                $('#license_number_text').parent().parent().find(".action__link_edit").trigger("click");
            }
        }
    }
    if(!isValid) {
        displayAlert("danger", message);
    }
    return isValid;
}



//=======================================================================================================================================================
//=========================================================deprecated in admin3.0-----===================================================================
//=======================================================================================================================================================

/**
 * @deprecated deprecated in admin3.0
 * Individual Ajax replaced with common save button
 */


function includePageGlobal(post) {


    var url = "";

    if (post.thelink === "advanced_footer_active") {
        url = "/lp/global/updateStatusGlobalAdvanceFooterAdminThree";
    } else {
        url = "/lp/global/updatePrimaryFooterTogglesAdminThree"
    }

    // post = {"footer_status": status, _token: ajax_token};


    $.ajax({
        type: "POST",
        url: url,
        data: post,
        success: function (d) {
        },
        cache: false,
        async: false
    });
}


// ****************************************************************************//
// **************************SECONDARY FOOTER *********************************//
// ****************************************************************************//

/**
 * @deprecated deprecated in admin3.0
 * Individual Ajax replaced with common save button
 */

function secondaryFooterUpdate() {
    var client_id = $('#client_id').val();
    // var akeys = lpkeys.split("~");
    // var vertical_id = akeys[0];
    // var subvertical_id = akeys[1];
    // var leadpop_id = akeys[2];
    // var version_seq = akeys[3];

    var compliance_text = $('#compliance_text').val();
    var compliance_is_linked = 'n';
    var compliance_link = $('#compliance_link').val();
    var license_number_text = $('#license_number_text').val();

    if ($('#compliance_is_linked:checkbox:checked').length) {
        if (compliance_link == "")
            compliance_link = "#";
        label_compliance_text = "<a target='_blank' href='" + compliance_link + "'>" + compliance_text + "</a>";

        compliance_is_linked = 'y';
    } else {
        label_compliance_text = compliance_text;
    }

    var license_number_is_linked = 'n';
    if ($('#license_number_is_linked:checkbox:checked').length) {
        license_number_is_linked = 'y';
    }
    var license_number_link = $('#license_number_link').val();

    $('#label_compliance_text').html(label_compliance_text);
    $('#label_license_number_text').html(license_number_text);

    //  var globalMode = $('#footer-page').data('global_mode');

    var post;
    if (GLOBAL_MODE) {

        // if (GLOBAL_ADJUSTMENT)
        //     return false;

        if (!checkIfFunnelsSelected())
            return false;


        post = {
            client_id: client_id,
            lpkey_secfot: $("#lpkey_secfot").val(),
            compliance_text: compliance_text,
            compliance_is_linked: compliance_is_linked,
            compliance_link: compliance_link,
            license_number_text: license_number_text,
            license_number_link: license_number_link,
            license_number_is_linked: license_number_is_linked,
            _token: ajax_token
        };
        post.sec_fot_url_active = $("#sec_fot_url_active_switch").is(':checked') ? 'y' : 'n';
        post.sec_fot_license_number_active = $("#sec_fot_license_number_active_switch").is(':checked') ? 'y' : 'n';
        post.gfot_ai_val = $("#gfot_ai_val").val();
        post.gfot_ai_val1 = $("#gfot_ai_val1").val();
        post.thelink = $("#thelink").val();
        post.gfot_ai_flg = $("#gfot-ai-flg").val();
        post.gfot_ai_flg1 = $("#gfot-ai-flg1").val();
        console.log(post);

    } else {


        // var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&compliance_text="+compliance_text+"&compliance_is_linked="+compliance_is_linked+"&compliance_link="+compliance_link+"&license_number_text="+encodeURIComponent(license_number_text)+"&license_number_link="+license_number_link+"&license_number_is_linked="+license_number_is_linked;
        // post = {
        //     client_id: client_id,
        //     vertical_id: vertical_id,
        //     subvertical_id: subvertical_id,
        //     leadpop_id: leadpop_id,
        //     version_seq: version_seq,
        //     compliance_text: compliance_text,
        //     compliance_is_linked: compliance_is_linked,
        //     compliance_link: compliance_link,
        //     license_number_text: license_number_text,
        //     license_number_link: license_number_link,
        //     license_number_is_linked: license_number_is_linked,
        //     "_token": ajax_token
        // };
    }


    // $('#secondaryFooterUpdateId').prop('disabled', true);

    // // var url = globalMode? site.baseUrl+site.lpPath+'/global/updatecompliance' : "/lp/ajax/updatecompliance";
    // var url = GLOBAL_MODE ? site.baseUrl + site.lpPath + '/global/updateComplianceAdminThree' : "/lp/ajax/updatecompliance";
    // $.ajax({
    //     type: "POST",
    //     // url : "/lp/ajax/updatecompliance",
    //     url: url,
    //     data: post,
    //     success: function (d) {
    //         if ($('#compliance_text').prop("disabled")) {
    //             //  hidetoggel(".action__link_edit", "#license_number_text");
    //         } else {
    //             //   hidetoggel(".lp_footer_toggle_compliance", "#compliance_text");
    //         }

    //         setTimeout(function () {
    //             displayAlert('success', 'Secondary Footer Option has been saved.');
    //             $('#secondaryFooterUpdateId').prop('disabled', false);
    //         }, 1500);


    //         // goToByScroll("success-alert");
    //         // $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
    //         //     $(this).slideUp(500);
    //         // });

    //     },
    //     cache: false,
    //     async: false
    // });
    return false;
}
















