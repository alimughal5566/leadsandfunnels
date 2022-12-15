var tcpaEditor,
    security_message = {

    /*
     ** Iframe Scaling Function
     **/

    iframe_scaling: function () {
        var boxWidth = jQuery('.tcpa-message-content .theme__body').width();
        var getScale = boxWidth / 1220;
        var boxHeight = 1 - getScale;
        var parentHeight = jQuery('.tcpa-message-detail').height();
        var getScaleHeight = parentHeight + (parentHeight * boxHeight) - 45;
        jQuery('.tcpa-message-content .tcpa-security-preview-iframe').css({'height': getScaleHeight});
        if (getScale > 1) {
            return false;
        }
        else {
            jQuery('.tcpa-message-content .tcpa-security-preview-iframe-holder').css({'transform': 'scale('+getScale+')'});
        }
    },

    /*
     ** Outside click Function
     **/

    outsideclick: function () {
        jQuery(document).click(function (e) {
            var target = e.target;

            if (jQuery(".classic-editor__wrapper").hasClass('focus')) {
                if (jQuery(target).parents('.classic-editor__wrapper').length > 0) {
                }
                else {
                    jQuery('.classic-editor__wrapper').removeClass('focus');
                }
            }
        });
    },

    /*
     * Farola Editor Funcation
     * */

    farola_editor: function () {
        var fontSize = [];
        for (var i = 8; i <= 72; i++) {
            fontSize.push(i);
        }

        // Initialize the editor.
        tcpaEditor = new FroalaEditor('.tcpa-message-froala', {
            key: froala_key,
            iconsTemplate: 'font_awesome',
            placeholderText: 'Type Something…',
            fontFamily: lp_helper_font_families,
            fontSize: fontSize,
            autofocus: false,
            toolbarSticky: false,
            charCounterCount: false,
            imageUploadURL: site.baseUrl + '/lp/popadmin/' + fileuploadpath,
            // Additional upload params.
            imageUploadParams: {
                uploadtype: jQuery("#uploadtype").val(),
                current_hash: funnel_hash,
                client_id: site.clientID,
                _token: ajax_token
            },
            toolbarButtons: ['bold', 'italic', 'fontSize', 'fontFamily', 'textColor', 'backgroundColor', 'insertImage', 'insertVideo', 'html', '|', 'starOption'],
            moreOptionsButtons:['align', 'insertLink', 'formatUL', 'lineHeight', 'underline', '-', 'fontAwesome', 'emoticons', 'strikeThrough', 'undo', 'redo'],
            events: {
                'initialized': function(){
                    $('#contentHtml').html();
                    this.events.focus(false);
                    if (this.$box.parents('.classic-editor__wrapper').hasClass('update-version')) {
                        jQuery("body").addClass("froala-editor-update");
                    } else {
                        jQuery("body").removeClass("froala-editor-update");
                    }
                    security_message.iframe_scaling();
                },
                'popups.show.starOption': function () {
                    $('.classic-editor__wrapper').addClass('star-pop-active');
                },
                'popups.hide.starOption': function () {
                    $('.classic-editor__wrapper').removeClass('star-pop-active');
                },
                'popups.show.emoticons': function () {
                    $('.classic-editor__wrapper').addClass('pop-emotions');
                },
                'popups.hide.emoticons': function () {
                    $('.classic-editor__wrapper').removeClass('pop-emotions');
                },
                'popups.show.fontAwesome': function () {
                    $('.classic-editor__wrapper').addClass('pop-fontawesome');
                },
                'popups.hide.fontAwesome': function () {
                    $('.classic-editor__wrapper').removeClass('pop-fontawesome');
                },
                'popups.show.link.insert': function () {
                    $('.classic-editor__wrapper').addClass('pop-link');
                },
                'popups.hide.link.insert': function () {
                    $('.classic-editor__wrapper').removeClass('pop-link');
                },
                'click': function () {
                    $('.classic-editor__wrapper').addClass('focus');
                 },
                'contentChanged': function () {
                    let html = this.html.get();
                    $('#messageContent').val(html).trigger('change');

                    // assignment by reference
                    preview_module.funnelInfo.tcpa_messages[0]["tcpa_text"] = html;
                    previewIframe.reloadIframe(false);
                    security_message.iframe_scaling();
                    security_message.editorValidation();
                },
                'image.removed': function ($img) {
                    $.ajax({
                        // Request method.
                        method: "POST",
                        // Request URL.
                        url: site.baseUrl + '/lp/popadmin/' + fileremovepath,
                        // Request params.
                        data: {
                            src: $img.attr('src'),
                            current_hash: jQuery("#current_hash").val(),
                            _token: ajax_token
                        }
                    }).done(function (data) {
                        console.log('image was deleted');
                    }).fail(function () {
                        console.log('image delete problem');
                    });
                }
            }
        });
    },

    isContentEmpty: function (text) {
        text = text.replaceAll("&nbsp;", "").
        replaceAll(" ", "").
        replaceAll("<p>", "").
        replaceAll("</p>", "").trim();
        return (text.length == 0) ? true : false;
    },

    editorValidation: function() {
        if(tcpaEditor && !this.isContentEmpty(tcpaEditor.html.get())) {
            $('.classic-editor__wrapper').removeClass('error');
            $('.editor-error-message').text('').removeClass('d-block').addClass('d-none');
            return true;
        } else {
            $('.classic-editor__wrapper').addClass('error');
            $('.editor-error-message').text('Please enter the message content.').removeClass('d-none').addClass('d-block');
            return false;
        }
    },

    init: function () {
        security_message.outsideclick();
        security_message.farola_editor();
        security_message.iframe_scaling();
    },
};

jQuery(document).ready(function () {
    security_message.init();
    var $form = $("#create-tcpa-form"),
        $successMsg = $(".alert");

    ajaxRequestHandler.init("#create-tcpa-form", {
        autoEnableDisableButton: true,
    });

    $('body').addClass('tcpa-inner-page');

    ajaxRequestHandler.setActiveLoadingToastMessage(true);

    if ($($form).attr("data-edit") == "true") {
        console.log('edit form');
        // ajaxHandler.setAutoEnableDisableButton(true);
    }


    //  ajaxRequestHandler.changeSubmitButtonStatus(false);
    // $('#main-submit').prop('disabled', false);


    $('#main-submit').on('click', function () {
        $form.submit();
    });


    // TCPA FORM
    $form.validate({
        rules: {
            tcpa_title: {
                required: true,
                no_space:true
            },
        },

        messages: {
            tcpa_title: {
                required: "Please enter the message name.",
                no_space: "Please enter the message name."
            },
            messageContent: {
                required: "Please enter the message content."
            }
        },

        submitHandler: function (form) {
            if(security_message.editorValidation() == false) {
                return false
            }
            ajaxRequestHandler.submitForm(function (response, isError) {
                //  ajaxRequestHandler.setActiveLoadingToastMessage(true);
                //  ajaxRequestHandler.handleRequestLoading();

                // $( '#iframe' ).attr( 'src', function ( i, val ) { return val; });
                console.log("submit callback...", response, isError);
                if(response.result.url !== undefined)
                {
                    window.location.href = response.result.url;
                }
            });
        }

    });

    $('#is_required_ckb').on("change", function (e) {
            if ($(this).is(':checked')) {
                preview_module.funnelInfo.tcpa_messages[0]["is_required"] = true;
            } else {
                preview_module.funnelInfo.tcpa_messages[0]["is_required"] = false;
            }
        previewIframe.reloadIframe(false);
    });


    jQuery('.action-view-list .action-view-item').click(function (e) {
        e.preventDefault();
        jQuery('.action-view-item').removeClass('active');
        jQuery(this).addClass('active');
        let postAttribute = '';
        if (jQuery(this).hasClass('mobile')) {
            postAttribute = 'mobile-preview';
            jQuery('.tcpa-security-preview-iframe-holder').addClass('mobile-view-active');
        }
        else {
            postAttribute = 'desktop-preview';
            jQuery('.tcpa-security-preview-iframe-holder').removeClass('mobile-view-active');
        }
        previewIframe.reloadIframe(false, false, postAttribute);
    });

    jQuery(".right-sidebar").mCustomScrollbar({
        axis:"y",
        autoExpandScrollbar: true,
        autoHideScrollbar : true,
        scrollInertia: 200,
        callbacks: {
            whileScrolling: function () {
                var select_button = $(".right-sidebar").find('.classic-editor__wrapper .fr-wrapper').offset();
                var block_height = $(".right-sidebar").find('.classic-editor__wrapper .fr-wrapper').height();
                var window_height = $('.right-sidebar').height();
                var select_dropdown = $('.fr-popup.fr-active').height();

                if(select_button !== undefined && !$('.tcpa-message-froala').parents('.classic-editor__wrapper.focus').find('.fr-popup').hasClass('fr-active')) {

                    var select_total = select_button.top + select_dropdown;
                    lpUtilities.editorPopupPosition(window_height,select_total,select_dropdown,block_height,select_button);
                }
            }
        }
    });

});


jQuery(window).resize(function() {
    security_message.iframe_scaling();
});
