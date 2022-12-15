jQuery(document).ready(function () {
    // Delete TCPA FORM
    var ajaxDeleteHandler = Object.assign({}, ajaxRequestHandler);
    ajaxDeleteHandler.init('#deleteMessageForm', {
        autoEnableDisableButton: false,
        submitButton: ".lp-table_yes"
    });

    bindCtaEvents = function () {
        delLinkElem = $('.remove-tcpa');
        delConfirmationNoElem = $('.lp-table_no');
        delConfirmationYesElem = $('.lp-table_yes');

        delLinkElem.click(function (e) {
         //   debugger;
            e.preventDefault();
            var elem = $(this);

            $(this).parents('.lp-table-item').find('.lp-table__list').slideUp();
            $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideDown();
            $('#message_id').val(elem.data('id'));
           // $('#del_client_id').val(elem.data('clientid'));
            $('.lp-table_yes').attr('data-id', elem.data('id'));
            $('.lp-table_yes').attr('data-clientid', elem.data('clientid'));
        });

        delConfirmationYesElem.click(function (e) {
            deleteProcess();
        });

        delConfirmationNoElem.click(function(){
            $(this).parents('.lp-table-item').find('.lp-table__list').slideDown();
            $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideUp();
        });
    };

    deleteProcess =function () {
        var id = $(".lp-table_yes").attr('data-id');
        var clientid = $(".lp-table_yes").attr('data-clientid');

        $('#message_id').val(id);
      //  $('#del_client_id').val(clientid);
        // $('#deleteRecipientForm').submit();
        ajaxDeleteHandler.submitForm(function (response, isError) {
            console.log("deleted lead alert callback...");
            if(response.status == true || response.status == 'true') {
                $('[data-delete-yes]').removeAttr('data-id');
                $('#security-message-confirmation').modal('hide');
                $('#modal_delete_domain ._delete_btn').removeAttr('data-id');
                $('#modal_delete_domain ._delete_btn').removeAttr('data-clientid');
                $("#rcp_" + id).parents('.tcp-message-data').remove();
                console.log("#rcp_" + id + " parent div will be deleted");
            }
        }, true);
    };
    bindCtaEvents();
});

jQuery(document).ready(function () {
    remLSPref("tcpa_module_");

    var ajaxHandler = Object.assign({}, ajaxRequestHandler),
        $form = $("#createMessageForm");

    ajaxHandler.init("#createMessageForm", {
        autoEnableDisableButton: false,
        submitButton: "#createSecurityMsgBtn"
    });

    $('#createSecurityMsgBtn').on('click', function () {
        $form.submit();
    });

    $('[data-delete-security]').click(function (){
       let id= $(this).data('id');
        $('[data-delete-yes]').attr('data-id',id);
    });

    // Security Message FORM
    let validator = $form.validate({
        rules: {
            security_message_title: {
                required: true,
            }
        },
        messages: {
            security_message_title: {
                required: "Please enter the message name."
            }
        },
        submitHandler: function (form) {
            // debugger;
            ajaxHandler.submitForm(function (response, isError) {
                var createdMessageId = response.result.id;
                var current_hash = response.result.current_hash;

              //  debugger;
                if(createdMessageId &&  current_hash) {
                    $('#create-message').modal('hide');
                    var url = site.baseUrl + site.lpPath + '/popadmin/security-messages-edit/' + current_hash + "/" + createdMessageId;
                    window.location.href = url;
                }
                console.log("submit callback...", response, isError);
            });
        }
    });

    // reset validations when open create message modal
    jQuery('#create-message').on('show.bs.modal', function () {
        if(validator) {
            validator.resetForm();
            $form.find(".error").removeClass("error");
        }
    });
});

function remLSPref(pref) {
    for (var key in localStorage) {
        if (key.indexOf(pref) == 0) {
                localStorage.removeItem(key);
        }
    }
}
