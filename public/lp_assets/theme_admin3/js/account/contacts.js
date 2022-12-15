(function ($) {
    ajaxRequestHandler.init('#fnewrecipient', {
        autoEnableDisableButton: false,
        submitButton: "._add_recipient_btn"
    });

    var ajaxDeleteHandler = Object.assign({}, ajaxRequestHandler);
    ajaxDeleteHandler.init('#deleteRecipientForm', {
        autoEnableDisableButton: false,
        submitButton: ".lp-table_yes"
    });

    $(".button-cancel").click(function () {
        Recipient.resetForm();
    });

    $(document).on('hidden.bs.modal', '.modal', function (evt) {
        // console.log("closed");
        $(this).find(".form-control.error").removeClass("error");
        $('label.error').hide();
        // multiRequestHandler.stoppingAjaxRequest();
    });
    lpUtilities.addFunnelTags();

    var amIclosing = false;
    $('.select2js__cell-carrier').select2({
        dropdownPosition: 'above',
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__cell-carrier-parent')
    }).on('change', function (event) {
        if(event.target.value){
            $(this).removeClass("error");
            $("#cell_carrier-error").html("");
        }
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
        lpUtilities.niceScroll();

        setTimeout(function () {
            jQuery('.select2js__cell-carrier-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('.select2js__cell-carrier').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight - 50;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
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
        jQuery('.select2js__cell-carrier-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2js__cell-carrier-parent .select2-selection__rendered').show();
        jQuery('.select2js__cell-carrier-parent .select2-results__options').css('pointer-events', 'none');
    });

    $(document).on("keydown",".select2js__cell-carrier-parent .select2-selection--single",  function (e) {
        $('.select2js__cell-carrier').select2('close');
        if (e.keyCode == 13) {
            $('#fnewrecipient').submit();
        }
    });

    var Recipient = {
        bindTextToggle: function () {
            $('.lp-popup-radio').change(function (e) {
                if ($(this).val() == 'y'){
                    $(".textToggleCtrl").slideDown(170);
                    if($('#cell_number').val() == '') {
                        setTimeout(function () {
                            $('#cell_number').val('');
                            $('#cell_number').focus();
                        }, 400);
                    }
                }
                else
                    $(".textToggleCtrl").slideUp(170);

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
            $("#editrowid").val('');
            $("#isnewrowid").val('y');
            $("#newemail").val('');

            $('#newtextcell_yes').removeAttr('checked');
            $("#newtextcell_no").attr("checked", "checked");

            $("#cell_number").val('');
            $("#cell_carrier").val("").trigger('change.select2');

            // $("#cell_carrier").val("tmomail.net").change();
            // $('#cell_carrier option[value="tmomail.net"]').attr('selected','selected');

            // $('#cell_carrier').selectpicker('refresh');
            // $("#select2-cell_carrier-container").text("T-Mobile").attr("title","T-Mobile");

            $(".model_notification").removeClass('alert-info');
            $(".model_notification").removeClass('alert-danger');
            $(".model_notification").addClass('d-none');
            $(".model_notification").html("");
        },

        submitProcess: function () {
            // alert('hee')
            var notifyElem = $(".model_notification");
            // Recipient.formValidate();
            $('#fnewrecipient').submit();
            // $('#fnewrecipient').submit()
            // if(Recipient.formValidate()){
            //    if(multiRequestHandler.isAjaxRequestInProcess()) {
             //       return false;
             //   }
               /// multiRequestHandler.startingAjaxRequest();
              //  let {hide} = displayAlert("loading", "Processing your request");


                // debugger;
              //  $('#fnewrecipient').submit();
               // var dstr = $('#fnewrecipient').serialize();

               /* $.ajax({
                    type: "POST",
                    data: dstr,
                    url: $('#fnewrecipient').attr('action'),
                    error: function (e) {
                        hide();
                        setTimeout(function(){
                            displayAlert("danger", "Your request was not processed. Please try again.");
                        }, 500)
                    },
                    success: function (d) {
                        hide();
                        var slength = 0;
                        if (d != "") {
                            d = d.replace(/(\r\n|\n|\r)/gm, "");
                            var ids = d.split("~~~");
                            var slength = ids.length;
                        }

                        if(ids[0] == 'new-duplicate' || ids[0] == 'edit-duplicate') {
                        setTimeout(function(){
                            displayAlert("danger", "This email address already exists in the list.");
                        }, 500)
                        } else if (slength == 2) {
                            $("#lead-recipients").modal('toggle');

                            if (ids[1] == 'edit-success') {
                                setTimeout(function(){
                                    displayAlert("success", "Lead recipient has been updated.");
                                }, 400)
                                var elem = $("#rcp_" + ids[0]),
                                    primary = "";
                                if(elem.find(".lead-alert-email-address em").length){
                                    primary = " <em>" + elem.find(".lead-alert-email-address em").html() + "</em>";
                                }
                                elem.find(".lead-alert-email-address").html($("#newemail").val() + primary);
                                elem.find(".lead-alert-full-name").html($("#full_name").val());

                                //Reset value to empty value when
                                if($('[name="newtextcell"]:checked').val() == "n") {
                                    $("#cell_number").val("");
                                }

                                var cell_val="N/A";
                                if($("#cell_number").val()){
                                    cell_val=$("#cell_number").val();
                                }
                                var full_name="N/A";
                                if($("#full_name").val()){
                                    full_name=$("#full_name").val();
                                }
                                elem.find(".lead-alert-cell").html(cell_val);
                                elem.find(".lead-alert-full-name").html(full_name);


                                elem.find(".edit-recipient").attr("data-name", $("#full_name").val());
                                elem.find(".edit-recipient").attr("data-email", $("#newemail").val());
                                elem.find(".edit-recipient").attr("data-cell", $("#cell_number").val());
                                elem.find(".edit-recipient").attr("data-carrier", $("#cell_carrier").val());
                            } else {

                                setTimeout(function(){
                                    displayAlert("success", "Lead recipient has been added.");
                                }, 400)
                                var full_name = $("#full_name").val()?$("#full_name").val():'N/A';
                                var reciepientTemplate = '<ul class="lp-table__list lead-alert-data" id="rcp_' + ids[0] + '">'+
                                    '<li class="lp-table__item lead-alert-full-name">' + full_name + '</li>'+
                                    '<li class="lp-table__item"><span class="lead-alert-email-address">' + $("#newemail").val() + '</span></li>'+
                                    '<li class="lp-table__item lead-alert-cell">' + ($("#cell_number").val() ? $("#cell_number").val() : "N/A") + '</li>'+
                                    '<li class="lp-table__item">'+
                                        '<div class="action action_options non-global-divs">'+
                                            '<ul class="action__list">'+
                                                '<li class="action__item">'+
                                                    '<a href="#" class="action__link edit-recipient"'+
                                                        'data-id="' + ids[0] + '" ' +
                                                        'data-name="' + $("#full_name").val() + '" ' +
                                                        'data-email="' + $("#newemail").val() + '"'+
                                                        'data-cell="' + $("#cell_number").val() + '"'+
                                                        'data-carrier="' + $("#cell_carrier").val() + '" data-text="Edit">'+
                                                        '<span class="ico ico-edit"></span>edit'+
                                                    '</a>'+
                                                '</li>'+
                                                '<li class="action__item">'+
                                                    '<a href="#" class="action__link remove-recipient"'+
                                                        'data-id="' + ids[0] + '"'+
                                                        'data-clientid="' + ids[1] + '">'+
                                                        '<span class="ico ico-cross"></span>delete'+
                                                    '</a>'+
                                                '</li>'+
                                            '</ul>'+
                                            '<ul class="action__list">'+
                                            '<li class="action__item">'+
                                            '<i class="fa fa-circle" aria-hidden="true"></i>\n'+
                                            '<i class="fa fa-circle" aria-hidden="true"></i>\n'+
                                            '<i class="fa fa-circle" aria-hidden="true"></i>\n'+
                                            '</li>'+
                                            '</ul>'+
                                        '</div>'+
                                    '</li>'+
                                    '</ul>';

                                // var elem = $("#RecipientRowTemplate").html();
                                // elem = elem.replace("#rcp_ROWID#", "rcp_" + ids[0]);
                                // elem = elem.replace("#EMAIL#", $("#newemail").val());
                                // elem = elem.replace("#EMAIL2#", $("#newemail").val());
                                // elem = elem.replace("#CELL#", $("#cell_number").val());
                                // elem = elem.replace("#CELL2#", $("#cell_number").val());
                                // elem = elem.replace("#CARRIER#", $("#cell_carrier").val());
                                // elem = elem.replace("#EDIT-ROWID#", ids[0]);
                                // elem = elem.replace("#DELETE-ROWID#", ids[0]);
                                // elem = elem.replace("#DELETE-CLIENTID#", ids[1]);

                                $(reciepientTemplate).insertAfter(".lead-alert-data:last");

                                Recipient.bindCtaEvents($("#rcp_" + ids[0]));
                            }
                        } else {
                            displayAlert("danger", "Processing error");
                        }
                    },
                    complete: function (d) {
                        multiRequestHandler.stoppingAjaxRequest();
                    },
                    cache: false,
                    async: true
                });*/
            // }
            // else {
            //     notifyElem.html('Error during submit data').removeClass('d-none').removeClass('alert-info').addClass('alert-warning');
            // }
        },


        formValidate: function () {
            var is_valid = true;
            var error = [];
            $.validator.addMethod("phoneValid", function (value, element, regexpr) {
                return regexpr.test(value);
            }, "Please enter a valid phone number.");

            $.validator.addMethod('emailtld', function(val, elem){
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                if(!filter.test(val)) {
                    return false;
                } else {
                    return true;
                }
            }, 'Please enter a valid email address.');

            var $form = $('#fnewrecipient');
            $form.validate({
                rules: {
                    // we don't need to required full name according to Sir andrew @mzac90
                    // full_name: {
                    //     required: true,
                    //     minlength: 3,
                    // },
                    cell_number: {
                        required: true,
                        phoneValid: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/
                    },
                    carrier: {
                        required: true
                    },
                    newemail: {
                        required: true,
                        email: true,
                        emailtld: true
                    }
                },
                messages: {
                    // we don't need to required full name according to Sir andrew @mzac90
                    // full_name: {
                    //     required: "Please enter your first name."
                    // },
                    cell_number: {
                        required: "Mobile number is required to receive text alerts."
                    },
                    carrier: {
                        required: "You must select a Carrier to receive text alerts."
                    },
                    newemail: {
                        required: "Please enter your email address.",
                        email:"Please enter a valid email address."
                    }
                },
                debug: true,
                submitHandler: function (form) {
                    ajaxRequestHandler.submitForm(function (response, isError) {
                        $("#lead-recipients").modal('toggle');
                        console.log("Lead alerts submit callback...");

                        if(isError !== true) {
                            let data = response.result === undefined ? null : response.result;
                            if (data.action === "add") {
                                let full_name = $("#full_name").val()?$("#full_name").val():'N/A',
                                    email = $("#newemail").val(),
                                    cell_number = $("#cell_number").val() ? $("#cell_number").val() : "N/A";
                                let reciepientTemplate = '<div class="lp-table-item lead-alert-data">' +
                                        '<ul class="lp-table__list" id="rcp_' + data.id + '">' +
                                            '<li class="lp-table__item lead-alert-full-name">' + full_name + '</li>' +
                                            '<li class="lp-table__item"><span class="lead-alert-email-address">' + email + '</span></li>' +
                                            '<li class="lp-table__item lead-alert-cell">' + cell_number + '</li>' +
                                            '<li class="lp-table__item">' +
                                                '<div class="action action_options non-global-divs">' +
                                                    '<ul class="action__list">' +
                                                        '<li class="action__item">' +
                                                            '<a href="#" class="action__link edit-recipient"' +
                                                                'data-id="' + data.id + '" ' +
                                                                'data-name="' + full_name + '" ' +
                                                                'data-email="' + email + '"' +
                                                                'data-cell="' + $("#cell_number").val() + '"' +
                                                                'data-carrier="' + $("#cell_carrier").val() + '" data-text="Edit">' +
                                                                    '<span class="ico ico-edit"></span>edit' +
                                                            '</a>' +
                                                        '</li>' +
                                                        '<li class="action__item">' +
                                                            '<a href="#" class="action__link remove-recipient"' +
                                                                'data-id="' + data.id + '"' +
                                                                'data-clientid="' + $("#newclient_id").val() + '">' +
                                                                    '<span class="ico ico-cross"></span>delete' +
                                                            '</a>' +
                                                        '</li>' +
                                                    '</ul>' +
                                                    '<ul class="action__list">' +
                                                        '<li class="action__item">' +
                                                            '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                                                            '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                                                            '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                                                        '</li>' +
                                                    '</ul>' +
                                                '</div>' +
                                            '</li>' +
                                        '</ul>' +
                                        '<div class="lp-table__item-msg">' +
                                            '<div class="lp-table__item-confirmation">' +
                                                '<p>Are you sure you want to remove this lead recipient?</p>' +
                                                '<ul class="control">' +
                                                    '<li class="control__item">' +
                                                        '<a href="javascript:void(0);" class="lp-table_yes">Yes</a>' +
                                                    '</li>' +
                                                    '<li class="control__item">' +
                                                        '<a href="javascript:void(0);" class="lp-table_no">No</a>' +
                                                    '</li>' +
                                                '</ul>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';
                                $(reciepientTemplate).insertAfter(".lead-alert-data:last");
                                Recipient.bindCtaEvents($("#rcp_" + data.id));
                            } else if (data.action === "edit") {
                                console.log("Edit success");
                                var elem = $("#rcp_" + $("#editrowid").val()),
                                    primary = "";
                                if(elem.find(".lead-alert-email-address em").length){
                                    primary = " <em>" + elem.find(".lead-alert-email-address em").html() + "</em>";
                                }
                                elem.find(".lead-alert-email-address").html($("#newemail").val() + primary);
                                elem.find(".lead-alert-full-name").html($("#full_name").val());

                                //Reset value to empty value when
                                if($('[name="newtextcell"]:checked').val() == "n") {
                                    $("#cell_number").val("");
                                }

                                var cell_val="N/A";
                                if($("#cell_number").val()){
                                    cell_val=$("#cell_number").val();
                                }
                                var full_name="N/A";
                                if($("#full_name").val()){
                                    full_name=$("#full_name").val();
                                }
                                elem.find(".lead-alert-cell").html(cell_val);
                                elem.find(".lead-alert-full-name").html(full_name);

                                //Updated edit link data attributes
                                elem.find(".edit-recipient").attr("data-name", $("#full_name").val());
                                elem.find(".edit-recipient").attr("data-email", $("#newemail").val());
                                elem.find(".edit-recipient").attr("data-cell", $("#cell_number").val());
                                elem.find(".edit-recipient").attr("data-carrier", $("#cell_carrier").val());
                            }
                        }
                    });
                    // if (GLOBAL_MODE) {
                    //     if (checkIfFunnelsSelected()) {
                    //         //  debugger;
                    //         if (confirmationModalObj.globalConfirmationCurrentForm == $form) {
                    //             form.submit();
                    //         } else {
                    //             $("#lead-recipients").modal('hide');
                    //             showGlobalRequestConfirmationForm($form);
                    //         }
                    //     }
                    // } else {
                    //     form.submit();
                    // }
                }
            });

            return $form.valid();
        },


        bindCtaEvents: function (containerElem) {
            if (containerElem == undefined) {
                delLinkElem = $('.remove-recipient');
                editLinkElem = $('.edit-recipient');
                delConfirmationNoElem = $('.lp-table_no');
                delConfirmationYesElem = $('.lp-table_yes');
            } else {
                delLinkElem = $(containerElem).find('.remove-recipient');
                editLinkElem = $(containerElem).find('.edit-recipient');

                //binding events on confirmation buttons
                let parentEl = $(containerElem).parents('.lead-alert-data');
                delConfirmationNoElem = $(parentEl).find('.lp-table_no');
                delConfirmationYesElem = $(parentEl).find('.lp-table_yes');
            }

            delLinkElem.click(function (e) {
                e.preventDefault();
                var elem = $(this);

                $(this).parents('.lp-table-item').find('.lp-table__list').slideUp();
                $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideDown();
                $('#del_recipient_id').val(elem.data('id'));
                $('#del_client_id').val(elem.data('clientid'));
                $('.lp-table_yes').attr('data-id', elem.data('id'));
                $('.lp-table_yes').attr('data-clientid', elem.data('clientid'));
            });

            delConfirmationYesElem.click(function (e) {
                Recipient.deleteProcess();
                // if(GLOBAL_MODE) {
                //     var $form = $('#deleteRecipientForm');
                //     if (checkIfFunnelsSelected()){
                //         showGlobalRequestConfirmationForm($form);
                //     }
                // } else {
                //     Recipient.deleteProcess();
                // }
            });

            delConfirmationNoElem.click(function(){
                $(this).parents('.lp-table-item').find('.lp-table__list').slideDown();
                $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideUp();
            });

            editLinkElem.click(function (e) {
                e.preventDefault();
                var elem = $(this);
                var id = elem.attr('data-id');
                var name = elem.attr('data-name')
                var email = elem.attr('data-email');
                var cell = elem.attr('data-cell');
                var carrier = elem.attr('data-carrier');

                var notifyElem = $(".model_notification");
                notifyElem.html("").addClass('d-none').removeClass('alert-info alert-danger');

                //$("#edit_rcpt").val("Edit Recipient");
                $("#edit_rcpt").val("Save");
                $("#isnewrowid").val("n");
                $(".modal-title").text("Edit Recipient");

                $("#editrowid").val(id);
                $("#full_name").val(name);
                $("#isnewrowid").val('n');
                $("#newemail").val(email);
                $("#old_email").val(email);
                //alert($("#rcp_"+id).find(".lead-alert-action").html());
                //alert($(this).wrap("<p />").parent().html());
                //alert(cell);

                if (cell == "") {
                    $("#cell_number").val("");
                    $("input[name='newtextcell'][value='n']").prop('checked', true);
                    $("#cell_carrier").removeAttr("selected");
                    $("#cell_carrier").val("").trigger('change.select2');
                    $(".textToggleCtrl").hide();
                } else {
                    $("#cell_number").val(cell);
                    $("input[name='newtextcell'][value='y']").prop('checked', true);
                    // $("#cell_carrier option[value='"+carrier+"']").attr("selected","selected");
                    $("#cell_carrier").val(carrier);
                    $("#cell_carrier").trigger('change');
                    $(".textToggleCtrl").show();
                }
                // $('#carrier').selectpicker('refresh');
                Recipient.bindCellSection();
                $('#lead-recipients').modal('show');
                Recipient.formValidate();
                //enable
                ajaxRequestHandler.setAutoEnableDisableButton(true);
                ajaxRequestHandler.loadFormSavedValues();
            });
        },

        deleteProcess: function () {
            var id = $(".lp-table_yes").attr('data-id');
            var clientid = $(".lp-table_yes").attr('data-clientid');

            $('#del_recipient_id').val(id);
            $('#del_client_id').val(clientid);
            // $('#deleteRecipientForm').submit();
            ajaxDeleteHandler.submitForm(function (response, isError) {
                console.log("deleted lead alert callback...");
                if(response.status == true || response.status == 'true') {
                    $('#modal_delete_domain ._delete_btn').removeAttr('data-id');
                    $('#modal_delete_domain ._delete_btn').removeAttr('data-clientid');
                    $("#rcp_" + id).parents('.lead-alert-data').remove();
                    console.log("#rcp_" + id + " parent div will be deleted");
                }
            }, true);

       /*     if(multiRequestHandler.isAjaxRequestInProcess()) {
                return false;
            }
            multiRequestHandler.startingAjaxRequest();

            let {hide} = displayAlert("loading", "Processing your request...");
            var requestUrl = "/lp/account/deleteleadrecipient";
            if(GLOBAL_MODE){
                requestUrl = "lp/global/deleteRecipientGlobalAdminThree";
            }*/

            // $.ajax({
            //     type: "POST",
            //     data: {client_id: clientid, recipient_id: id},
            //     url: requestUrl,
            //     error: function (e) {
            //         hide();
            //         setTimeout(function(){
            //             displayAlert("danger", "Your request was not processed. Please try again.");
            //         }, 400)
            //
            //     },
            //     success: function (d) {
            //         hide();
            //         setTimeout(function(){
            //             displayAlert("success", "Lead recipient has been deleted.");
            //         }, 400)
            //         $('#modal_delete_domain ._delete_btn').removeAttr('data-id');
            //         $('#modal_delete_domain ._delete_btn').removeAttr('data-clientid');
            //         $('#modal_delete_domain').modal('toggle');
            //         $("#rcp_" + id).remove();
            //     },
            //     complete: function(response) {
            //         multiRequestHandler.stoppingAjaxRequest();
            //     },
            //     cache: false,
            //     async: true
            // });
        }
    };

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
        Recipient.formValidate();

        Recipient.resetForm();
        ajaxRequestHandler.setAutoEnableDisableButton(false);
    });

    // $('._add_recipient_btn').click(function (e) {
    // });


   /*$("#fnewrecipient").on('submit', function (event) {
         event.preventDefault();
        Recipient.formValidate();
    });*/


//  Carrier link popup code here
    var carrier_link_width    = 600;
    var carrier_link_height   = 600;
    var carrier_top_position  = ($(window).height() - carrier_link_height) / 2;
    var carrier_left_position = ($(window).width() - carrier_link_width) / 2;

    $('.carrier-lookup-link').click(function(){
        window.open('https://freecarrierlookup.com/','popup','width='+carrier_link_width+',height='+carrier_link_height+',top='+carrier_top_position+',left='+carrier_left_position+'');
        return false;
    });



    $("#lead-recipients")
        .on('shown.bs.modal', function () {
            $('.recipient-form').find('#full_name').focus();
        })
        .on('hidden.bs.modal', function () {
        });

})(jQuery);



/**
 * To handle multiple AJAX requests
 * @type {{initModalClosedEvents: multiRequestHandler.initModalClosedEvents, isAjaxInProcess: boolean, startingAjaxRequest: multiRequestHandler.startingAjaxRequest, isAjaxRequestInProcess: multiRequestHandler.isAjaxRequestInProcess, isImmediatelyClicked(): boolean, last_clicked: number, stoppingAjaxRequest: multiRequestHandler.stoppingAjaxRequest, time_since_clicked: number}}
 */
var multiRequestHandler = {
    last_clicked: 0,
    time_since_clicked: Date.now(),
    isAjaxInProcess: false,

    /**
     * TO track button is immediately clicked OR not
     * @returns {boolean}
     */
    isImmediatelyClicked() {
        if (this.last_clicked) {
            this.time_since_clicked = Date.now() - this.last_clicked;

            if (this.time_since_clicked < 2000) {
                // console.log("isImmediatelyClicked -- true");
                return true
            }
        }

        // console.log("isImmediatelyClicked -- false");
        this.last_clicked = Date.now();
        return false;
    },

    /**
     * Set check if button is not immediately clicked if not immediately clicked than return isAjaxInProcess bit
     */
    isAjaxRequestInProcess: function () {
        if(this.isImmediatelyClicked()) {
            return true;
        }
        return this.isAjaxInProcess;
    },

    /**
     * Set isAjaxInProcess bit before starting AJAX request
     */
    startingAjaxRequest: function () {
        this.isAjaxInProcess = true;
        // console.log("startingAjaxRequest");
    },


    /**
     * Reset isAjaxInProcess bit after AJAX request completion
     */
    stoppingAjaxRequest: function () {
        this.isAjaxInProcess = false;
        // console.log("stoppingAjaxRequest");
    },

    /**
     * initialize modal close event, this will fix multiple AJAX request exceptional issue with modal
     * Exceptional issue - after AJAX request modal take some delay to hide it self, between that time if button is clicked it was sending request
     */
    initModalClosedEvents: function (modals = false) {
        if(modals) {
            // $(document).on('hidden.bs.modal', modals, function (event) {
            $(modals).on('hidden.bs.modal', function () {
                // console.log($(this).attr("id") + " modal closed...");

                multiRequestHandler.stoppingAjaxRequest();
            });
        }
    }
};
