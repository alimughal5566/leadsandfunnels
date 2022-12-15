(function ($) {

    $(".button-cancel").click(function () {
        Recipient.resetForm();
    });


    $(document).on('hidden.bs.modal', '.modal', function (evt) {
        console.log("closed");
        $(this).find(".form-control.error").removeClass("error");
        $('label.error').hide();
    })

    var amIclosing = false;
    $('.select2js__cell-carrier').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__cell-carrier-parent')
    }).on('change', function () {
        $("#edit_rcpt").trigger( "click" );
    }).on('select2:openning', function() {
        jQuery('.select2js__cell-carrier-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__cell-carrier-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__cell-carrier-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__cell-carrier-parent .select2-dropdown').hide();
        jQuery('.select2js__cell-carrier-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__cell-carrier-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__cell-carrier-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2js__cell-carrier').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__cell-carrier-parent .select2-selection__rendered').show();
        jQuery('.select2js__cell-carrier-parent .select2-results__options').css('pointer-events', 'none');
    });

    var Recipient = {
        bindTextToggle: function () {
            $('.lp-popup-radio').change(function (e) {
                if ($(this).val() == 'y'){
                    $(".textToggleCtrl").slideDown();
                    if($('#cell_number').val() == '') {
                        setTimeout(function () {
                            $('#cell_number').val('');
                            $('#cell_number').focus();
                        }, 400);
                    }
                }
                else {
                    $(".textToggleCtrl").slideUp();
                }
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
            $("#full_name").val('');
            // $("#isnewrowid").val('no');
            $("#newemail").val('');

            $('#newtextcell_yes').removeAttr('checked');
            $("#newtextcell_no").attr("checked", "checked");

            $("#cell_number").val('');
            $("#cell_carrier").val('').trigger('change.select2');
            // $("#cell_carrier").removeAttr("selected");
            // $('#carrier').selectpicker('refresh');


        },
        submitProcess: function () {
            var notifyElem = $(".model_notification");
            if(Recipient.formValidate()){
                console.info("sssssssss");
                notifyElem.html('Processing your request').removeClass('hide').removeClass('alert-warning alert-danger').addClass('alert-info');
                var dstr = $('#fnewrecipient').serialize();
                $.ajax({
                    type: "POST",
                    data: dstr,
                    // url: $('#fnewrecipient').attr('action'),
                    // error: function (e) {
                    //     notifyElem.html('Your request was not processed. Please try again.').removeClass('hide').removeClass('alert-info').addClass('alert-warning');
                    // },
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

                                elem.find(".edit-recipient").attr("data-carrier", $("#cell_carrier").val());
                            } else {

                                var elem = $("#RecipientRowTemplate").html();
                                elem = elem.replace("#rcp_ROWID#", "rcp_" + ids[0]);
                                elem = elem.replace("#EMAIL#", $("#newemail").val());
                                elem = elem.replace("#EMAIL2#", $("#newemail").val());
                                elem = elem.replace("#CELL#", $("#cell_number").val());
                                elem = elem.replace("#CELL2#", $("#cell_number").val());
                                elem = elem.replace("#CARRIER#", $("#cell_carrier").val());
                                elem = elem.replace("#EDIT-ROWID#", ids[0]);
                                elem = elem.replace("#DELETE-ROWID#", ids[0]);
                                elem = elem.replace("#DELETE-CLIENTID#", ids[1]);
                                $(elem).insertAfter(".lead-alert-data:last");
                                Recipient.bindCtaEvents($("#rcp_" + ids[0]));
                            }
                        } else {
                            // notifyElem.html('Processing error').removeClass('hide').removeClass('alert-info').addClass('alert-info');
                        }
                    },
                    always: function (d) {
                    },
                    cache: false,
                    async: true
                });
            }else {
                notifyElem.html('Error during submit data').removeClass('hide').removeClass('alert-info').addClass('alert-warning');
            }


        },
        formValidate: function () {
            var is_valid = true;
            var error = [];
            $.validator.addMethod("emailValid", function (value, element, regexpr) {
                return regexpr.test(value);
            }, "Please enter a valid email address.");
            $.validator.addMethod("phoneValid", function (value, element, regexpr) {
                return regexpr.test(value);
            }, "Please enter a valid phone number.");
            $('#fnewrecipient').validate({
                rules: {
                    full_name: {
                        required: false
                    },
                    cell_number: {
                        required: true,
                        phoneValid: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/
                    },
                    cell_carrier: {
                        required: true
                    },
                    newemail: {
                        required: true,
                        emailValid: /(.+)@(.+){2,}\.(.+){2,}/
                    }
                },
                messages: {
                    full_name: {
                        required: "Please enter your first name."
                    },
                    cell_number: {
                        required: "Mobile number is required to receive text alerts."
                    },
                    cell_carrier: {
                        required: "You must select a Carrier to receive text alerts."
                    },
                    newemail: {
                        required: "Please enter your email address."
                    }
                },
                debug: true,
                submitHandler: function () {
                    console.info('submitted');
                }
            });
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

                $('#modal_delete_domain .modal-title').html('Delete Recipient');
                $('#modal_delete_domain .modal-msg').removeClass("alert-danger").html('Are you sure you want to delete this lead recipient?');
                $('#modal_delete_domain .modal-msg').removeClass('alert alert-info alert-warning');
                $('#modal_delete_domain ._delete_btn').attr('data-id', elem.data('id'));
                $('#modal_delete_domain ._delete_btn').attr('data-clientid', elem.data('clientid'));
                $('#modal_delete_domain').modal('show');
            });

            editLinkElem.click(function (e) {

                e.preventDefault();
                var elem = $(this);
                var id = elem.attr('data-id');
                var name = elem.attr('data-name')
                var email = elem.attr('data-email');
                var cell = elem.attr('data-cell');
                var carrier = elem.attr('data-carrier');


                //$("#edit_rcpt").val("Edit Recipient");
                $("#edit_rcpt").val("Save");
                $("#isnewrowid").val("n");
                $(".modal-title").text("Edit Recipient");

                $("#editrowid").val(id);
                $("#full_name").val(name);
                $("#isnewrowid").val('n');
                $("#newemail").val(email);
                //alert($("#rcp_"+id).find(".lead-alert-action").html());
                //alert($(this).wrap("<p />").parent().html());
                //alert(cell);
                if (cell == "") {
                    $("#cell_number").val("");
                    $('#newtextcell_yes').removeAttr('checked');
                    $("#newtextcell_no").attr("checked", "checked");
                    $("#cell_carrier").removeAttr("selected");
                    $(".textToggleCtrl").hide();
                } else {
                    $("#cell_number").val(cell);
                    $('#newtextcell_no').removeAttr('checked');
                    $("#newtextcell_yes").attr("checked", "checked");
                    //$("#carrier option[value='"+carrier+"']").attr("selected","selected");
                    // $("#cell_carrier").val('');
                    // $("#cell_carrier").trigger('change');

                    $(".textToggleCtrl").show();
                }
                // $('#carrier').selectpicker('refresh');
                Recipient.bindCellSection();
                $('#lead-recipients').modal('show');

            });
        },
        deleteProcess: function () {
            var id = $("._delete_btn").attr('data-id');
            var clientid = $("._delete_btn").attr('data-clientid');
            $('#modal_delete_domain .modal-msg').html('Processing your request...').removeClass('hide').addClass('alert alert-info');
            $.ajax({
                type: "POST",
                data: {client_id: clientid, recipient_id: id},
                url: "/lp/account/deleteleadrecipient",
                error: function (e) {
                    $('#modal_delete_domain .modal-msg').html('Your request was not processed. Please try again.').removeClass('hide').addClass('alert alert-danger');
                },
                success: function (d) {
                    $('#modal_delete_domain ._delete_btn').removeAttr('data-id');
                    $('#modal_delete_domain ._delete_btn').removeAttr('data-clientid');
                    $('#modal_delete_domain').modal('toggle');
                    $("#rcp_" + id).remove();
                },
                cache: false,
                async: true
            });
        }
    }

    $('#cell_number').inputmask({"mask": "(999) 999-9999"});  // INPUT MASK FOR CELL NUMBER
    $('#lead-recipients').find('');
    Recipient.bindTextToggle();
    Recipient.bindCtaEvents();


    //Open Modal Box
    $('.lp-btn-addRecipient').click(function (e) {
        e.preventDefault();
        $("#edit_rcpt").val("add recipient");
        $("#isnewrowid").val("y");
        $("#lead-recipients").find("#newtextcell_no").prop('checked', 'checked');
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
    });

    $('#lead-recipients').on('shown.bs.modal', function (e) {
        $('.recipient-form').find('#full_name').focus();
    })

})(jQuery);
