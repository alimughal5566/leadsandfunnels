$(document).ready(function () {




    $("#msg_subject").empty();

    //*
    // ** Validation Js auto responder Page
    // *

    var _modalvalidation = $("#modal_emailform"),

        validator = _modalvalidation.validate({
            rules: {
                modal_email: {
                    required: true,
                    emailValid: /(.+)@(.+){2,}\.(.+){2,}/
                },
                host_name: {
                    required: true
                },
                port: {
                    required: true
                },
                user_name: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 5

                }
            },
            messages: {
                modal_email: {
                    required: "Please enter your email address."
                },
                host_name: {
                    required: "Please enter your hostname."
                },
                port: {
                    required: "Please enter your port number."
                },
                user_name: {
                    required: "Please enter your user name."
                },
                password: {
                    required: "Please enter your password.",
                }
            },
            debug: true,
            submitHandler: function () {
                console.info('submitted');
            }
        });

    //*
    // ** Validation Js auto responder Page
    // *

    $.validator.addMethod("emailValid", function (value, element, regexpr) {
        return regexpr.test(value);
    }, "Please enter a valid email address.");

/*    $('#auto_responderform').validate({
        rules: {
            subline: {
                required: true

            },

           /!* sender_name: {
                required: true

            },
            email: {
                required: true,
                emailValid: /(.+)@(.+){2,}\.(.+){2,}/
            },
            mg_subject: {
                required: true
            } *!/
        },
        messages: {
            subline:"please specify the message subject",

            sender_name: {
                required: "Please enter your name."
            },
            email: {
                required: "Please enter your email address."
            },
            mg_subject: {
                required: "Please enter your message subject."
            }
        },
        debug: true,
        submitHandler: function () {
            console.info('submitted');
        }
    });*/

    // tooltip

    $('.el-tooltip').tooltip();

    // auto responder page

    var select2js_email_type = $('.select2js__email-type');
    var select2js_sec_protocol  = $('.select2js__sec-protocol');
    var select2js_answer_msgtype  = $('.msgtype-dynamic-anwser');
    var select2js_answer_submsg  = $('.submsg-dynamic-anwser');
    var _msgtype = $('.submsg-dynamic-anwser-parent');

    select2js_email_type.select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__email-type-parent')
    });

    select2js_sec_protocol.select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__sec-protocol-parent')
    });

    select2js_answer_msgtype.select2({
        minimumResultsForSearch: -1,
        width: '284', // need to override the changed default
        dropdownParent: $('.msgtype-dynamic-anwser-parent')
    });



    // get set caret postion
    function pasteHtmlAtCaret(html) {
        var sel, range;
        if (document.getSelection) {
            // IE9 and non-IE
            sel = document.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                range = sel.getRangeAt(0);
                range.deleteContents();

                // Range.createContextualFragment() would be useful here but is
                // non-standard and not supported in all browsers (IE9, for one)
                var el = document.createElement("div");
                el.innerHTML = html;
                var frag = document.createDocumentFragment(), node, lastNode;
                while ( (node = el.firstChild) ) {
                    lastNode = frag.appendChild(node);
                }
                range.insertNode(frag);

                // Preserve the selection
                if (lastNode) {
                    range = range.cloneRange();
                    range.setStartAfter(lastNode);
                    range.collapse(true);
                    sel.removeAllRanges();
                    sel.addRange(range);
                }
            }
        } else if (document.selection && document.selection.type != "Control") {
            // IE < 9
            document.selection.createRange().pasteHTML(html);
        }
    }

    // function doGetCaretPosition (oField) {
    //
    //     // Initialize
    //     var iCaretPos = 0;
    //
    //     // IE Support
    //     if (document.selection) {
    //
    //         // Set focus on the element
    //         oField.focus ();
    //
    //         // To get cursor position, get empty selection range
    //         var oSel = document.selection.createRange ();
    //
    //         // Move selection start to 0 position
    //         oSel.moveStart ('character', -oField.value.length);
    //
    //         // The caret position is selection length
    //         iCaretPos = oSel.text.length;
    //     }
    //
    //     // Firefox support
    //     else if (oField.selectionStart || oField.selectionStart == '0')
    //         iCaretPos = oField.selectionStart;
    //
    //     // Return results
    //     return (iCaretPos);
    //     console.info(iCaretPos);
    // }


    // $("#msg_subject").blur(function () {
    //     console.info(doGetCaretPosition("#msg_subject"));
    // });


    var caretPosObj = {
        pos: 0
    };

    // $('#msg_subject').data('caretPosObj',caretPosObj);

    var update = function(event ) {


        var caretPos = getCaretPosition( $('#msg_subject').get(0) );
        console.log( caretPos);


        caretPosObj.pos = caretPos;
    };
    $('#msg_subject').on("mousedown mouseup keydown keyup", update);
    function getCaretPosition(editableDiv) {
        var caretPos = 0,
            sel, range;
        if (window.getSelection) {
            sel = window.getSelection();
            if (sel.rangeCount) {
                range = sel.getRangeAt(0);
                if (range.commonAncestorContainer.parentNode == editableDiv) {
                    caretPos = range.endOffset;
                }
            }
        } else if (document.selection && document.selection.createRange) {
            range = document.selection.createRange();
            if (range.parentElement() == editableDiv) {
                var tempEl = document.createElement("span");
                editableDiv.insertBefore(tempEl, editableDiv.firstChild);
                var tempRange = range.duplicate();
                tempRange.moveToElementText(tempEl);
                tempRange.setEndPoint("EndToEnd", range);
                caretPos = tempRange.text.length;
            }
        }
        return caretPos;
    }



    $("#msg_subject").click(function () {
        $(this).addClass("active__click");
        $(_msgtype).removeClass("validation_error");
        $(_msgtype).find(".error").remove();

    });
    $(document).mouseup(function (e){
        // console.info(e.target);
        var container = $("#msg_subject,.submsg-dynamic-anwser-parent,.select2-results__option"); // YOUR CONTAINER SELECTOR
        // console.info(container.has(e.target).addClass('ssss'));
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.removeClass("active__click");

        }
        // $("#msg_subject").removeClass("active__click");
    });
    $('#msg_subject').on('keydown', function (event) {
        if (window.getSelection && event.which == 8) { // backspace
            // fix backspace bug in FF
            // https://bugzilla.mozilla.org/show_bug.cgi?id=685445
            var selection = window.getSelection();
            if (!selection.isCollapsed || !selection.rangeCount) {
                return;
            }

            var curRange = selection.getRangeAt(selection.rangeCount - 1);
            if (curRange.commonAncestorContainer.nodeType == 3 && curRange.startOffset > 0) {
                // we are in child selection. The characters of the text node is being deleted
                return;
            }

            var range = document.createRange();
            if (selection.anchorNode != this) {
                // selection is in character mode. expand it to the whole editable field
                range.selectNodeContents(this);
                range.setEndBefore(selection.anchorNode);
            } else if (selection.anchorOffset > 0) {
                range.setEnd(this, selection.anchorOffset);
            } else {
                // reached the beginning of editable field
                return;
            }
            range.setStart(this, range.endOffset - 1);


            var previousNode = range.cloneContents().lastChild;
            if (previousNode && previousNode.contentEditable == 'false') {
                // this is some rich content, e.g. smile. We should help the user to delete it
                range.deleteContents();
                event.preventDefault();
            }
        }
    });
    select2js_answer_submsg.select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.submsg-dynamic-anwser-parent')
    }).on("select2:select", function (e) {
        if($("#msg_subject").hasClass("active__click")){
            var selected_val = $(this).val();
            var wrap_tag = '&nbsp;&nbsp;<span contentEditable="false" class="tag__wrapper">'+selected_val+'<i class="ico ico-cross"></i></span>&nbsp;&nbsp;';
            // $("#msg_subject").append("abdullah");
            var selector = $('#msg_subject');
            var pos = caretPosObj.pos;
            var str  = $(selector).html();
            var set_str = str.slice(0, pos) + wrap_tag + str.slice(pos);
            console.info(selector.html(set_str));
            caretPosObj.pos += wrap_tag.length;
            var msg_val = $('#msg_subject').keyup().text();
            $("#msg_subject_val").val(msg_val);
            setTimeout(function(){
                $("#msg_subject").addClass("active__click");
                $("#msg_subject").removeClass("valid");
            },200)
        }else {
            $(_msgtype).addClass("validation_error");
            $(_msgtype).append('<label class="error">Please click in message subject before addding a dynamic answer.</label>')

        }
    });

    $(document).on('click','.tag__wrapper i.ico',function(){
        $(this).closest('.tag__wrapper').remove();
    });

    $('.msg__sbj-search').select2({
        width: '100%',
    });

    $('input:radio[name=theoption]').change(function () {
        if($(this).attr("value")=="html"){
            $(".html-email__body").show();
            $(".text-email__body").hide();

        }
        if($(this).attr("value")=="text"){
            $(".html-email__body").hide();
            $(".text-email__body").show();
        }

    });

    $(document).on('click','.smtp__detail-pop',function(){
        $(this).find(".error").removeClass("error");
        $('#add-email').modal('hide');
        $('#confirm-email').modal('hide');
        setTimeout(function () {
            $('#smtp-pop').modal('show');
        },500);
    });

    $(document).on('click','.new__email-pop',function(){
        $('#smtp-pop').modal('hide');
        $('#confirm-email').modal('hide');
        setTimeout(function () {
            $('#add-email').modal('show');
        },500);
    });

    $(document).on('click','.confirm-email-pop',function(){
        if (_modalvalidation.valid()){
            $('#smtp-pop').modal('hide');
            $('#add-email').modal('hide');
            setTimeout(function () {
                $('#confirm-email').modal('show');
            },500);
        }

    });

    $(".sender-email-address_add").click(function () {
        validator.resetForm();
        Recipient.form_reset();
    });

    // $('.button-cancel').on('hidden.bs.modal', function () {
    //     $('#auto_responderform')[0].reset();
    // });

    $(function() {
        $('.html-email__froala-editor').froalaEditor({
            key:"lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==",
            toolbarButtons: ['bold', 'italic', 'underline', 'fontSize', 'fontFamily', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '|', 'insertLink', 'insertImage',  'undo', 'redo', 'html'],
            quickInsertTags: [],
            height: 318,
            placeholderText: ' ',
            charCounterCount: false,
        });
    });


    // images preview
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var file = input.files[0];
                var file_name = file.name;
                var _size = input.files[0].size;
                var fSExt = new Array('Bytes', 'kb', 'mb', 'gb'),
                    i=0;while(_size>900){_size/=1024;i++;}
                var exactSize = (Math.round(_size*100)/100)+' '+fSExt[i];
                var list = '';
                list = '<ul class="lp-table__list ">\n' +
                    '<li class="lp-table__item">'+file_name+'</li>\n' +
                    '<li class="lp-table__item">'+exactSize+'</li>\n' +
                    '<li class="lp-table__item">\n' +
                    '<div class="action action_options">\n' +
                    '<ul class="action__list">\n' +
                    '<li class="action__item">\n' +
                    '<a href="#" class="action__link remove-recipient">\n' +
                    '<span class="ico ico-cross"></span>delete\n' +
                    '</a>\n' +
                    '</li>\n' +
                    '</ul>\n' +
                    '<ul class="action__list">\n' +
                    '<li class="action__item">\n' +
                    '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                    '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                    '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                    '</li>\n' +
                    '</ul>\n' +
                    '</div>\n' +

                    '</li>\n' +
                    '</ul>';

                $("#browse-doc__list").append(list);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#browse").change(function () {
        readURL(this);
    });
    var Recipient = {
        bindCtaEvents: function (containerElem) {
            if (containerElem == undefined) {
                delLinkElem = $('.remove-recipient');
            } else {
                delLinkElem = $(containerElem).find('.remove-recipient');
            }

            delLinkElem.click(function (e) {
                e.preventDefault();
                var elem = $(this);

                $('#modal_delete_attachment .modal-title').html('Delete attachment Recipient');
                $('#modal_delete_attachment .modal-msg').html('Are you sure delete attachment recipient?');
                $('#modal_delete_attachment .modal-msg').removeClass('alert alert-info alert-warning');
                $('#modal_delete_attachment ._delete_btn').attr('data-id', elem.data('id'));
                $('#modal_delete_attachment').modal('show');
            });
        },
        deleteProcess: function () {
            $('#modal_delete_attachment').modal('show');
            var id = $("._delete_btn").attr('data-id');
            var clientid = $("._delete_btn").attr('data-clientid');
            $('#modal_delete_attachment .modal-msg').html('Processing your request...').removeClass('hide').addClass('alert alert-info');

        },
        form_reset: function () {
            $("#modal_email").val('');
            $("#host_name").val('');
            $("#port").val('');
            $("#user_name").val('');
            $("#password").val('');
            select2js_sec_protocol.val(1).trigger('change.select2');
            select2js_email_type.val(1).trigger('change.select2');
            $(".modal-content").find(".form-control.error").removeClass("error");
        }
    }

    $(document).on('click','.remove-recipient', function(e){
        Recipient.deleteProcess();
    });

    $('input:radio[name=email-temp]').change(function () {
        if($(this).attr("value")=="htmlemail"){
            $(".html-email__body").show();
            $(".text-email__body").hide();

        }
        if($(this).attr("value")=="textemail"){
            $(".html-email__body").hide();
            $(".text-email__body").show();
        }

    });





});

