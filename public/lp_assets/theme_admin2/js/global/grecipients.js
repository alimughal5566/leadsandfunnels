(function ($) {
    var GRecipient = {
        bindTextToggle:function(){
            $(".gtextToggleCtrl").hide();
            $('.lp-popup-radio').change(function(e){
                if($(this).val() == 'y')
                    $(".gtextToggleCtrl").slideDown();
                else
                    $(".gtextToggleCtrl").slideUp();

            });
        },
        resetForm: function(){
            $("#edit_rcpt").val("Save");

            $("#fnewrecipient h2.lp-heading-2").text("Add Recipient");
            $(".gtextToggleCtrl").hide();

            $("#editrowid").val('');
            $("#isnewrowid").val('y');
            $("#newemail").val('');

            $('#newtextcell_yes').removeAttr('checked').trigger('click');
            $("#newtextcell_no").attr("checked", "checked").trigger('click');

            $("#cell_number").val('');

            $("#carrier").removeAttr("selected");
            $('#carrier').selectpicker('refresh');

            $(".model_notification").removeClass('alert-info alert-danger').addClass('hide');
            $(".model_notification").html("");
        },
        submitProcess: function(){
            var notifyElem = $(".model_notification");
            if(GRecipient.formValidate()){
                notifyElem.html('Processing your request').removeClass('hide').removeClass('alert-warning alert-danger').addClass('alert-success');
                var dstr = $('#fnewrecipient').serialize();
                $.ajax( {
                    type : "POST",
                    data: dstr,
                    url : $('#fnewrecipient').attr('action'),
                    error: function (e) {
                        notifyElem.html('Your request was not processed. Please try again.').removeClass('hide').removeClass('alert-info').addClass('alert-warning');
                    },
                    success : function(d) {
                        var slength = 0;
                        if(d != ""){
                            d = d.replace(/(\r\n|\n|\r)/gm,"");
                            var ids = d.split("~~~");
                            var slength = ids.length;
                        }

                        if(slength == 2) {
                            //$("#recipient_modal").modal('toggle');
                            var r_data = ids[0].split("--");
                            var action=r_data[0];
                            var fkeys=r_data[1];
                            var group_identifier=r_data[2];
                            var rid=r_data[3];

                            if(action == 'edit'){

                                var elem = $("#rcp_"+rid);
                                elem.find(".lead-alert-email-address").html( $("#newemail").val() );
                                elem.find(".edit-recipient").attr("data-email", $("#newemail").val());

                                elem.find(".lead-alert-cell").html( $("#cell_number").val());
                                elem.find(".edit-recipient").attr("data-cell", $("#cell_number").val());

                                elem.find(".edit-recipient").attr("data-carrier", $("#carrier").val());

                            }else{
                                var elem = $("#RecipientRowTemplate").html();
                                elem = elem.replace("#rcp_ROWID#", "rcp_"+rid);
                                elem = elem.replace("#EMAIL#", $("#newemail").val());
                                elem = elem.replace("#EMAIL2#", $("#newemail").val());
                                elem = elem.replace("#CELL#", $("#cell_number").val());
                                elem = elem.replace("#CELL2#", $("#cell_number").val());
                                elem = elem.replace("#CARRIER#", $("#carrier").val());
                                elem = elem.replace("#EDIT-ROWID#", rid);
                                elem = elem.replace("#EDIT-ROWID1#", rid);
                                elem = elem.replace("#EDIT-GIID#", group_identifier);
                                elem = elem.replace("#DELETE-GIID1#", group_identifier);
                                elem = elem.replace("#FUNNEL-LP-RECKEY#", fkeys);
                                elem = elem.replace("#FUNNEL-LP-RECKEY1#", fkeys);
                                elem = elem.replace("#DELETE-ROWID#", rid);
                                elem = elem.replace("#DELETE-CLIENTID#", ids[1]);
                                $( elem ).insertAfter( ".lead-alert-data:last");
                                GRecipient.bindCtaEvents( $("#rcp_"+rid) );
                            }
                            GRecipient.resetForm();
                            GRecipient.pageReset();
                        }else{
                            notifyElem.html('Processing error').removeClass('hide').removeClass('alert-info').addClass('alert-danger');
                        }
                    },
                    always: function(d) { },
                    cache : false,
                    async : true
                });
            }else{
                GRecipient.formError();
            }
        },
        formValidate: function(){
            var is_valid = true;
            var error = []
            if ($("#lpkey_recip").val() == '') {
                is_valid = false;
                error.push("Please Select Funnel From List.")
            };
            if(!validateField("newemail","required~email")){
                is_valid = false;
                error.push("Invalid email address")
            }

            if($("#newtextcell_yes").is(':checked')==true){
                if(!validateField("cell_number","required~phone")){
                    is_valid = false;
                    error.push("Cellphone is missing")
                }
            }

            if(!is_valid){
                var notifyElem = $(".model_notification");
                notifyElem.html(error.join("<br />")).removeClass('hide').addClass('alert-danger');
            }
            return is_valid;
        },
        bindCtaEvents:function(containerElem){
            if(containerElem == undefined){
                delLinkElem = $('.remove-recipient');
                editLinkElem = $('.edit-recipient');
            }else{
                delLinkElem = $(containerElem).find('.remove-recipient');
                editLinkElem = $(containerElem).find('.edit-recipient');
            }

            delLinkElem.click(function(e){
                e.preventDefault();
                var elem = $(this);

                $('#modal_delete_domain .modal-title').html('Delete Recipient');
                $('#modal_delete_domain .modal-msg').html('Are you sure you want to delete this lead recipient? ');
                $('#modal_delete_domain .modal-msg').removeClass('alert alert-info alert-warning');
                $('#modal_delete_domain ._delete_btn').attr('data-rid', elem.data('rid'));
                $('#modal_delete_domain ._delete_btn').attr('data-frkey', elem.data('frkey'));
                $('#modal_delete_domain ._delete_btn').attr('data-id', elem.data('id'));
                $('#modal_delete_domain ._delete_btn').attr('data-clientid', elem.data('clientid'));
                $('#modal_delete_domain').modal('show');
            });

            editLinkElem.click(function(e){
                e.preventDefault();
                var elem = $(this);
                var id = elem.attr('data-id');
                var email = elem.attr('data-email');
                var cell = elem.attr('data-cell');
                var carrier = elem.attr('data-carrier');

                var notifyElem = $(".model_notification");
                notifyElem.html("").addClass('hide').removeClass('alert-info alert-danger');

                $("#edit_rcpt").val("Save");
                $("#isnewrowid").val("n");
                $("#fnewrecipient h2.lp-heading-2").text("Edit Recipient");

                $("#editrowid").val(id);
                $("#isnewrowid").val('n');
                $("#newemail").val( email );

                $("#funnel-selector").find("input[type=checkbox]").prop("checked", false);
                $("#lpkey_recip").val(elem.attr('data-frkey'));
                var fkeys = elem.attr('data-frkey').split(',');
                $.each(fkeys, function (index, fkey) {
                    $("#funnel-selector input[type=checkbox][data-fkey='" + fkey + "']").prop("checked", true);
                });
                $('[data-target="#funnel-selector"]').html('<i class="fa fa-cog"></i> Selected (' + fkeys.length + ')');
                if(cell == ""){
                    $("#cell_number").val( "" );
                    $('#newtextcell_yes').removeAttr('checked').trigger('click');
                    $("#newtextcell_no").attr("checked", "checked").trigger('click');
                    $("#carrier").removeAttr("selected");
                    $(".gtextToggleCtrl").hide();
                }else{
                    $("#cell_number").val( cell );
                    $('#newtextcell_no').removeAttr('checked').trigger('click');
                    $("#newtextcell_yes").attr("checked", "checked").trigger('click');
                    //$("#carrier option[value='"+carrier+"']").attr("selected","selected");
                    $("#carrier").val(carrier);
                    $("#carrier").trigger('change');
                    $(".gtextToggleCtrl").show();
                }
                $('#carrier').selectpicker('refresh');
                $("._add_recipient_btn").val('Update');


            });
        },
        deleteProcess: function(){
            var rcpid = $("._delete_btn").attr('data-rid');
            var id = $("._delete_btn").attr('data-id');
            var clientid = $("._delete_btn").attr('data-clientid');
            $('#modal_delete_domain .modal-msg').html('Processing your request...').removeClass('hide').addClass('alert alert-success');
            $.ajax( {
                type : "POST",
                data: { client_id: clientid, group_identifier: id,_token:ajax_token },
                url : "/lp/account/deleteleadrecipient",
                error: function (e) {
                    $('#modal_delete_domain .modal-msg').html('Your request was not processed. Please try again.').removeClass('hide').addClass('alert alert-danger');
                },
                success : function(d) {
                    $('#modal_delete_domain ._delete_btn').removeAttr('data-id');
                    $('#modal_delete_domain ._delete_btn').removeAttr('data-clientid');
                    $('#modal_delete_domain').modal('toggle');
                    $("#rcp_"+rcpid).remove();
                    GRecipient.resetForm();
                    GRecipient.pageReset();
                },
                cache : false,
                async : true
            });
        },
        pageReset:function(){
            $("[data-id='integration-pixels']").trigger('click');
            $("a[href='#leadalerts']").trigger('click');
        }
    }

    $('#cell_number').inputmask({"mask": "(999) 999-9999"});  // INPUT MASK FOR CELL NUMBER
    $('#recipient_modal').find('');

    GRecipient.bindTextToggle();
    GRecipient.bindCtaEvents();

    $('._add_recipient_btn').click(function (e) {
        GRecipient.submitProcess();
    });

    $("._delete_btn").click(function (e){
        GRecipient.deleteProcess();
    })
    // Cancel button — Delete Popup
    $(".btnCancel_confirmReciDelete, .btnCancel_reciadd").click(function(e){
        e.preventDefault();
        GRecipient.pageReset();
    });

})(jQuery);
