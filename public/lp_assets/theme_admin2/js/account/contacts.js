(function ($) {

    var Recipient = {
        bindTextToggle: function () {
            $('.lp-popup-radio').change(function (e) {
                if ($(this).val() == 'y')
                    $(".textToggleCtrl").slideDown();
                else
                    $(".textToggleCtrl").slideUp();

            });
        },
        bindCellSection: function (e) {
            var lp_popup_radio = $('[name="newtextcell"]:checked').val();

            if (lp_popup_radio == 'y')
                $(".textToggleCtrl").show();
            else
                $(".textToggleCtrl").hide();

        },
        resetForm: function () {
            $("#editrowid").val('');
            $("#isnewrowid").val('y');
            $("#newemail").val('');

            $('#newtextcell_yes').removeAttr('checked');
            $("#newtextcell_no").attr("checked", "checked");

            $("#cell_number").val('');

            $("#carrier").val("tmomail.net");
            $('#carrier').selectpicker('refresh');
            $("#select2-carrier-container").text("T-Mobile").attr("title","T-Mobile");

            $(".model_notification").removeClass('alert-info');
            $(".model_notification").removeClass('alert-danger');
            $(".model_notification").addClass('hide');
            $(".model_notification").html("");
        },
        submitProcess: function () {
            var notifyElem = $(".model_notification");
            if (Recipient.formValidate()) {
                notifyElem.html('Processing your request').removeClass('hide').removeClass('alert-warning alert-danger').addClass('alert-success');
                var dstr = $('#fnewrecipient').serialize();
                $.ajax({
                    type: "POST",
                    data: dstr,
                    url: $('#fnewrecipient').attr('action'),
                    error: function (e) {
                        notifyElem.html('Your request was not processed. Please try again.').removeClass('hide').removeClass('alert-success').addClass('alert-warning');
                    },
                    success: function (d) {
                        var slength = 0;
                        if (d != "") {
                            d = d.replace(/(\r\n|\n|\r)/gm, "");
                            var ids = d.split("~~~");
                            var slength = ids.length;
                        }
                        if (slength == 2) {
                            $("#recipient_modal").modal('toggle');


                            if (ids[1] == 'edit-success') {
                                var elem = $("#rcp_" + ids[0]);
                                elem.find(".lead-alert-email-address").html($("#newemail").val());
                                elem.find(".edit-recipient").attr("data-email", $("#newemail").val());
                                var cell_val="-";
                                if($("#cell_number").val()){
                                    cell_val=$("#cell_number").val();
                                }
                                elem.find(".lead-alert-cell").html(cell_val);
                                elem.find(".edit-recipient").attr("data-cell", $("#cell_number").val());

                                elem.find(".edit-recipient").attr("data-carrier", $("#carrier").val());
                            } else {

                                var elem = $("#RecipientRowTemplate").html();
                                elem = elem.replace("#rcp_ROWID#", "rcp_" + ids[0]);
                                elem = elem.replace("#EMAIL#", $("#newemail").val());
                                elem = elem.replace("#EMAIL2#", $("#newemail").val());
                                elem = elem.replace("#CELL#", $("#cell_number").val());
                                elem = elem.replace("#CELL2#", $("#cell_number").val());
                                elem = elem.replace("#CARRIER#", $("#carrier").val());
                                elem = elem.replace("#EDIT-ROWID#", ids[0]);
                                elem = elem.replace("#DELETE-ROWID#", ids[0]);
                                elem = elem.replace("#DELETE-CLIENTID#", ids[1]);
                                $(elem).insertAfter(".lead-alert-data:last");
                                Recipient.bindCtaEvents($("#rcp_" + ids[0]));
                            }
                        } else {
                            notifyElem.html('Processing error').removeClass('hide').removeClass('alert-info').addClass('alert-info');
                        }
                    },
                    always: function (d) {
                    },
                    cache: false,
                    async: true
                });
            } else {
                Recipient.formError();
            }
        },
        formValidate: function () {
            var is_valid = true;
            var error = []
            if (!validateField("newemail", "required~email")) {
                is_valid = false;
                error.push("Invalid email address")
            }

            if ($("#newtextcell_yes").is(':checked') == true) {
                if (!validateField("cell_number", "required~phone")) {
                    is_valid = false;
                    error.push("Cellphone is missing");
                }
                if(!validateField("carrier","required~select")){
                    is_valid = false;
                    error.push("Select Carrier")
                }
            }else if($("#newtextcell_yes").is(':checked')==false){
                $("#cell_number").val("");
            }

            if (!is_valid) {
                var notifyElem = $(".model_notification");
                notifyElem.html(error.join("<br />")).removeClass('hide').addClass('alert-danger');
            }
            return is_valid;
        },
        bindCtaEvents: function (containerElem) {
            if (containerElem == undefined) {
                delLinkElem = $('.remove-recipient');
                editLinkElem = $('.edit-recipient');
            } else {
                delLinkElem = $(containerElem).find('.remove-recipient');
                editLinkElem = $(containerElem).find('.edit-recipient');
            }

            delLinkElem.click(function (e) {
                e.preventDefault();
                var elem = $(this);
                $('#modal_delete_domain .modal-msg').removeClass('alert alert-info alert-warning alert-danger');
                $('#modal_delete_domain .modal-title').html('Delete Recipient');
                $('#modal_delete_domain .modal-msg').html('Are you sure you want to delete this lead recipient?');
                $('#modal_delete_domain ._delete_btn').attr('data-id', elem.data('id'));
                $('#modal_delete_domain ._delete_btn').attr('data-clientid', elem.data('clientid'));
                $('#modal_delete_domain ._delete_btn').removeAttr('disabled');
                $('#modal_delete_domain').modal('show');
            });

            editLinkElem.click(function (e) {

                e.preventDefault();
                var elem = $(this);
                var id = elem.attr('data-id');
                var email = elem.attr('data-email');
                var cell = elem.attr('data-cell');
                var carrier = elem.attr('data-carrier');

                var notifyElem = $(".model_notification");
                notifyElem.html("").addClass('hide').removeClass('alert-info alert-danger');

                //$("#edit_rcpt").val("Edit Recipient");
                $("#edit_rcpt").val("Save");
                $("#isnewrowid").val("n");
                $(".modal-title").text("Edit Recipient");

                $("#editrowid").val(id);
                $("#isnewrowid").val('n');
                $("#newemail").val(email);
                //alert($("#rcp_"+id).find(".lead-alert-action").html());
                //alert($(this).wrap("<p />").parent().html());
                //alert(cell);
                if (cell == "") {
                    $("#cell_number").val("");
                    $('#newtextcell_yes').removeAttr('checked');
                    $("#newtextcell_no").attr("checked", "checked");
                    $("#carrier").removeAttr("selected");
                    $(".textToggleCtrl").hide();
                } else {
                    $("#cell_number").val(cell);
                    $('#newtextcell_no').removeAttr('checked');
                    $("#newtextcell_yes").attr("checked", "checked");
                    //$("#carrier option[value='"+carrier+"']").attr("selected","selected");
                    $("#carrier").val(carrier);
                    $("#carrier").trigger('change');
                    $(".textToggleCtrl").show();
                }
                $('#carrier').selectpicker('refresh');
                Recipient.bindCellSection();
                $('#recipient_modal').modal('show');

            });
        },
        deleteProcess: function () {
            $("._delete_btn").attr('disabled','disabled');
            var id = $("._delete_btn").attr('data-id');
            var clientid = $("._delete_btn").attr('data-clientid');
            if(clientid) {
                $('#modal_delete_domain .modal-msg').html('Processing your request...').removeClass('hide').addClass('alert alert-info');
                $.ajax({
                    type: "POST",
                    data: {client_id: clientid, recipient_id: id, _token: ajax_token},
                    url: "/lp/account/deleteleadrecipient",
                    error: function (e) {
                        $('#modal_delete_domain .modal-msg').html('Your request was not processed. Please try again.').removeClass('hide').addClass('alert alert-danger');
                        $("._delete_btn").removeAttr('disabled');
                        console.log('aqs');
                    },
                    success: function (d) {
                        $('#modal_delete_domain ._delete_btn').removeAttr('data-id');
                        $('#modal_delete_domain ._delete_btn').removeAttr('data-clientid');
                        $('#modal_delete_domain').modal('hide');
                        $("#rcp_" + id).remove();
                    },
                    cache: false,
                    async: true
                });
            }else{
                $('#modal_delete_domain').modal('hide');
            }
        }
    }

    $('#cell_number').inputmask({"mask": "(999) 999-9999"});  // INPUT MASK FOR CELL NUMBER
    $('#recipient_modal').find('');
    Recipient.bindTextToggle();
    Recipient.bindCtaEvents();


    //Open Modal Box
    $('.lp-btn-addRecipient').click(function (e) {
        e.preventDefault();
        $("#edit_rcpt").val("Save");
        $("#isnewrowid").val("y");
        $("#recipient_modal").find("#newtextcell_no").prop('checked', 'checked');
        $("#recipient_modal").find(".modal-title").text("Add Recipient");
        $('#recipient_modal').modal('show');
        $(".textToggleCtrl").hide();

        Recipient.resetForm();
    });

    $('._add_recipient_btn').click(function (e) {
        Recipient.submitProcess();
    });

    $("._delete_btn").click(function (e) {
        Recipient.deleteProcess();
    })

//  Carrier link popup code here
    var carrier_link_width    = 600;
    var carrier_link_height   = 600;
    var carrier_top_position  = ($(window).height() - carrier_link_height) / 2;
    var carrier_left_position = ($(window).width() - carrier_link_width) / 2;

    $('.carrier-lookup-link').click(function(){
        window.open('https://freecarrierlookup.com/','popup','width='+carrier_link_width+',height='+carrier_link_height+',top='+carrier_top_position+',left='+carrier_left_position+'');
        return false;
    })

})(jQuery);
