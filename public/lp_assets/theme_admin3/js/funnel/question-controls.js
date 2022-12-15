//froala editor change text and changes from toolbar options
var get_length = '',
    fb_html_editor,
    ajaxSecurityMessageHandler = Object.assign({}, ajaxRequestHandler);
    FBEditor = {
    editorSelector: ".fb-froala__init",
    funnelFontObject: lp_helper_font_families,

    /*
    * Froala Editor Function
    * */

    init: function () {
        let $self = this,
            fontSize = [];
        for(var i = 8 ; i <=72 ; i++){
            fontSize.push(i);
        }

        //initializing AJAX request handler
        ajaxSecurityMessageHandler.init('.security-popup-handler', {
            submitButton: "[data-security-message-save]"
        });

        $width = jQuery(window).width();
        $resize_width = 1500;
        let editor_focus = false;

        if($width > $resize_width){
            editor_focus = true;
        }

        // Initialize the editor.
        fb_html_editor = new FroalaEditor($self.editorSelector, {
            key: froala_key,

            iconsTemplate: 'font_awesome',
            fontFamily: this.funnelFontObject,
            fontSize: fontSize,
            autofocus: editor_focus,
            placeholderText: '',
            toolbarSticky: false,
            charCounterCount: false,
            imageMaxSize: 2 * 1024 * 1024,
            fileMaxSize: 1024 * 1024 * 5,
            imageMultipleStyles: true,
            imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
            imageUploadURL: site.baseUrl + '/lp/popadmin/footerimageupload',
            // Additional upload params.
            imageUploadParams: {
                id: 'footer_image',
                uploadtype: jQuery("#uploadtype").val(),
                current_hash: funnel_hash,
                client_id: site.clientID,
                _token: ajax_token
            },
            // Set request type.
            imageUploadMethod: 'POST',
            fileAllowedTypes: ['*'],
            videoResponsive: false,
            videoAllowedProviders: ['.*'],
            imageDefaultDisplay: 'inline',
            imageEditButtons: ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'],
            lineHeights: {
                Default: '',
                Single: '1',
                '1.15': '1.15',
                '1.5': '1.5',
                Double: '2'
            },
            toolbarButtons: ['bold', 'italic', 'fontSize', 'fontFamily', 'textColor', 'backgroundColor', 'insertImage', 'insertVideo', 'html', '|', 'starOption'],
            linkEditButtons: ['linkOpen', 'linkStyle', 'linkEdit', 'phoneNumberEdit', 'linkRemove'],
            moreOptionsButtons: ['strikeThrough','align', 'lineHeight', 'formatUL', 'insertLink', 'underline','-','emoticons', 'fontAwesome', 'insertPhoneNumber', 'undo', 'redo'],

            events: {
                'initialized': function () {
                    let fontSize = this.$oel.data("custom-font-size");
                    if(fontSize !== undefined) {
                        //in case client updated style
                        let firstSpan = this.$el.find("span").get(0);
                        if(firstSpan !== undefined && firstSpan.style !== undefined && firstSpan.style.fontSize !== undefined && firstSpan.style.fontSize != "") {
                            fontSize = firstSpan.style.fontSize;
                        }
                        $self.applyCustomFontSize(this, fontSize);
                    }
                    if (jQuery('.classic-editor__wrapper').hasClass('update-version')) {
                        jQuery("body").addClass("froala-editor-update");
                    } else {
                        jQuery("body").removeClass("froala-editor-update");
                    }
                    if(this.core.isEmpty())
                    {
                        $(this.$box).parents('.classic-editor__wrapper').find('p br').remove();
                    }
                    $self.bindEvents(this);
                },
                'contentChanged': function () {
                    SaveChangesPreview.saveOptions(this);
                },
                'html.set html.insert': function () {
                    SaveChangesPreview.saveOptions(this);
                },
                'image.beforeUpload': function (images) {
                    jQuery(jQuery('.fr-popup.fr-desktop:last-child')[jQuery('.fr-popup.fr-desktop:last-child').length - 1]).addClass('fr-active');
                },
                'image.inserted': function ($img, response) {
                    $self.addOrRemoveWrapperClass(this, 'head-dropdown-active', true);
                    SaveChangesPreview.saveOptions(this);
                    jQuery(jQuery('.fr-popup.fr-desktop:last-child')[jQuery('.fr-popup.fr-desktop:last-child').length - 1]).addClass('fr-active');
                },
                'image.resize': function () {
                    SaveChangesPreview.saveOptions(this);
                },
                'video.inserted': function () {
                    $self.addOrRemoveWrapperClass(this, 'head-dropdown-active', true);
                    SaveChangesPreview.saveOptions(this);
                },
                'popups.show.emoticons': function () {
                    $self.addOrRemoveWrapperClass(this, 'pop-emotions pop-custom-active');
                },
                'popups.hide.emoticons': function () {
                    $self.addOrRemoveWrapperClass(this, 'pop-emotions pop-custom-active', true);
                },
                'popups.show.fontAwesome': function () {
                    $self.addOrRemoveWrapperClass(this, 'pop-fontawesome pop-custom-active');
                },
                'popups.hide.fontAwesome': function () {
                    $self.addOrRemoveWrapperClass(this, 'pop-fontawesome pop-custom-active', true);
                },
                'popups.show.link.insert': function () {
                    $self.addOrRemoveWrapperClass(this, 'pop-link');
                },
                'popups.hide.link.insert': function () {
                    $self.addOrRemoveWrapperClass(this, 'pop-link', true);
                },
                'paste.before': function () {
                  //$self.attr('style', '');
                },
                'click': function (domEvent) {
                    $('.classic-editor__wrapper').removeClass('focus');
                    $self.addOrRemoveWrapperClass(this, 'focus');
                    get_length = $('.classic-editor__wrapper.focus .fr-view').text().trim().length;
                },
                'commands.after': function (cmd, param1, param2) {
                    let editor = this;
                    if (cmd === 'imageAlign') {
                        var imageSrc = editor.image.get();
                        if ($(imageSrc).hasClass('fr-fil') || $(imageSrc).hasClass('fr-fir')) {
                            $($(imageSrc).parent($(imageSrc).parent()[0].tagName)).removeAttr('style');
                        } else {
                            $(imageSrc).parent($(imageSrc).parent()[0].tagName).css({'text-align': 'center'});
                            let imageOffset = $(imageSrc);
                            $(".fr-image-resizer.fr-active").css({'left': imageOffset[0].offsetLeft});
                            $(".fr-popup.fr-desktop.fr-active").css({'left': imageOffset.offset().left});
                        }
                    } else if (cmd === "fontSize") {
                        // custom classes will be added on selected dropdown and font-size
                        if (this.$oel.data("custom-font-size") !== undefined) {
                            $self.applyCustomFontSize(this, param1);
                        }
                    }
                    SaveChangesPreview.saveOptions(this);
                }, 'keyup': FunnelsUtil.debounce(function (keyupEvent) {
                    if (jQuery('.funnel-cta-overlay').length === 1) {
                        var get_new_length = $('.classic-editor__wrapper.focus .fr-view').text().trim().length;
                        if (get_length !== get_new_length) {
                            jQuery(this).closest('[data-parent]').find('[data-delete-content]').remove();
                        }
                    }
                    SaveChangesPreview.saveOptions(this);
                }, 500)
            }
        });

        // focus on first froala editor
        jQuery(".funnel-iframe-holder iframe").on('load', function() {
            //jQuery('[data-cta-button-menu]').find('[data-handler]').trigger('click');
            let editor = lpHtmlEditor.getInstance(".question-editor " + $self.editorSelector);
            editor.events.focus(true);
            $('.question-editor').eq(0).addClass('focus').setCursorPosition('froala');
            $(document).on('click','.fb-phone-number',function (){
                $('.fb-phone-number').removeClass('phone-active');
                $(this).addClass('phone-active');
            });
        });
    },

    /**
     *
     */
     addOrRemoveWrapperClass: function(editor, cls, isRemove=false){
         if(isRemove) {
             editor.$box.parents('.classic-editor__wrapper').removeClass(cls);
         } else if(!editor.$box.parents('.classic-editor__wrapper').hasClass(cls)) {
             editor.$box.parents('.classic-editor__wrapper').addClass(cls);
         }
    },

    /**
     * bind events on froala instance HTML
     * Direct binding wasn't working after froala upgrade
     * @param editor
     */
    bindEvents: function(editor){
        $('#fontSize-' + editor.id).bind("click", this.selectFontSize);

        /**
         * This will fix issue with dropdown
         */
        editor.$box.find(".fr-toolbar").on("click", "button", function () {
            let wrapper = jQuery(this).parents('.classic-editor__wrapper');
            if(jQuery(this).hasClass('fr-active')) {
                wrapper.addClass('head-dropdown-active');
            }
            else {
                wrapper.removeClass('head-dropdown-active');
            }

            if(wrapper.find('.fr-popup').hasClass('fr-active')) {
                wrapper.addClass('head-dropdown-active');
            }
        });
    },

    /**
     * This will show custom selected font-size
     * it was always showing default font-size which we are using for editor text
     * @param e
     */
    selectFontSize: function () {
        let dropdown = jQuery("#dropdown-menu-" + jQuery(this).attr("id")),
            activeFont = dropdown.find('.custom-active');
        if (dropdown && activeFont.length > 0) {
            let dropdownList = dropdown.find(".fr-dropdown-content");
            dropdownList.find('.fr-command.fr-active').removeClass('fr-active');
            activeFont.addClass("fr-active").focus();
            dropdownList.animate({
                scrollTop: dropdownList.scrollTop() + (activeFont.offset().top - dropdownList.offset().top) - 110
            });
        }
    },

    /**
     * apply custom classes on selected font-size
     * @param el
     * @param fontSize
     */
    applyCustomFontSize: function (editor, fontSize) {
        let dropdown = jQuery('#dropdown-menu-fontSize-' + editor.id);
        if(dropdown !== undefined) {
            dropdown.find(".fr-command.custom-active").removeClass("custom-active");
            if (!dropdown.hasClass("custom-dropdown-parent")) {
                dropdown.addClass("custom-dropdown-parent");
            }
            dropdown.find("[data-param1=" + fontSize + "]").addClass("custom-active");
        }
    }
};


//this object work for input ,select,checkbox and radio button
var InputControls = {
    populateSecurityPopup: false,
    obj_fontawsome: {
        "plus": 'Plus',
        "arrow-thick-right": 'Forward',
        "forward": 'Replay',
        "long-arrow": 'Next',
        "double-arrow": 'Refer',
        "check": 'Check',
        "dotted-check": 'Mark',
        "lock": 'Lock',
        "search": 'Search',
        "thumbs": 'Thumb',
        "start-rate": 'Star',
        "heart": 'Heart',
        "location": 'Location',
        "client": 'Client',
        "email": 'Email',
        "file-upload": 'Upload',
    },
    init: function () {
        this.populateAddEditSecurityMessage();
        this.saveSecurityMessageDB();
        this.openclose();
        this.quick_access();
        this.outside_hover();
        this.remove_empty_space();
        this.disbale_mouse_postion();
        this.tooltip();
        //font icon list render in modal
        this.fontIconList();
        //input range bar
        this.rangeBar();
        this.setLockZoomSlider();
        this.allowDigitsOnly();
        this.securityMessage();
        // left panel hide/show
        this.addClassClick();
        //mcustomscroll init
        this.customScroll();
        //colorpicker init
        colorPicker.init();
        //click outside functionality
        this.outSideClick();
        //reset options functionl init
        resetOptions.init();

        //navigate question rendering.
        this.navigateQuestion();

        // this function will work for menu question
        multiOptions.init();
        FunnelsBuilder.ctaLoadDataClick();
        this.security_select_funcation();

        // re-enable funnel builder tooltip which was disabled in FunnelsBuilder.setQuestionOptions()
        // $('.fb-tooltip_control').tooltipster('enable');
    },

    /**
     * Populate values for add/edit security message popup
     */
    populateAddEditSecurityMessage: function() {
        $('[data-add-edit-security-message]').once('click', function () {
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            let selected_val = $("[data-field-name='security-message-id']").val();
            let selected_val_index = FunnelsUtil.getTcpaMessageIndex(selected_val, funnel_info.tcpa_messages);

            if (selected_val_index !== -1) {
                $('[data-security-message-title]').html('Edit Security Message');
                let selected_tcpa_message = funnel_info.tcpa_messages[selected_val_index];
                let icon = JSON.parse(selected_tcpa_message['icon']);
                let text_style = JSON.parse(selected_tcpa_message['tcpa_text_style']);

                InputControls.populateSecurityMessagePopup(icon, text_style, selected_tcpa_message['tcpa_text']);
                ajaxSecurityMessageHandler.loadFormSavedValues();
            } else {
                $('[data-security-message-title]').html('Add Security Message');

                // enable security dropdown
                $('.security-message-type').prop('disabled', false);
                $('[data-add-edit-security-message]').tooltipster('content', '<div class="security-tooltip">Edit Security Message</div>');

                /**
                 * TODO: cleanup, need to remove this code
                // default settings for new security message
                let icon = {};
                icon.enabled = true;
                icon.icon = 'ico ico-shield-2';
                icon.color = '#24b928';
                icon.position = 'Left Align';
                icon.size = '28';
                let text_style = {};
                text_style.is_bold = false;
                text_style.is_italic = false;
                text_style.color = '#b4bbbc';
                let text = 'Privacy & Security Guaranteed';
                let security_message_obj = {icon: JSON.stringify(icon), id:0, tcpa_id:'null', text:text, text_style: JSON.stringify(text_style), title:"Message"};

                // entry in local storage
                funnel_info.tcpa_messages.push(security_message_obj);
                FunnelsUtil.saveFunnelData(funnel_info);

                // reinitialize security dropdown
                security_message_obj.text = '<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>'+text+'</span></div>';
                initSelect.selectItems['security-message-type'] = [security_message_obj];
                $('.security-message-type').select2('destroy').empty();
                initSelect.initCustomSelect('.security-message-type', '.security-message-parent');
                 */
                let defaultSecurityMessage = securityMessage.getDefaultMessage();
                InputControls.populateSecurityMessagePopup(defaultSecurityMessage.icon, defaultSecurityMessage.tcpa_text_style, defaultSecurityMessage.tcpa_text);
            }
        });
    },

    /**
     * Populate values for security message
     */
    securityMessage: function ()
    {
        //security message set
        initSelect.selectItems["security-message-type"] = initSelect.getTcpaMessages();
        //select2 init
        initSelect.allCustomSelect();
        // disable security dropdown if no security message exists
        if (initSelect.selectItems["security-message-type"].length == 0) {
            $('.security-message-type').prop('disabled', true);
            $('[data-add-edit-security-message]').tooltipster('content', '<div class="security-tooltip">Add Security Message</div>');
        }
    },

    /**
     * Populate security message popup
     * @param icon
     * @param text_style
     * @param text
     */
    populateSecurityMessagePopup: function(icon, text_style, text) {
        // populate icon settings
        $('[data-security-message-icon-class]').html('');
        $('[data-security-message-icon-class]').html('<i class="'+icon.icon+'"></i>');
        $('#ico-shield-form-field').val('<i class="'+icon.icon+'"></i>');
        $("[data-security-message-icon-position]").val(icon.position).trigger('change.select2');
        $('[data-security-message-icon-size]').bootstrapSlider('setValue', icon.size);
        $("#clr-icon").ColorPickerSetColor(icon.color);
        InputControls.populateSecurityPopup = true;
        if (icon.enabled) {
            $('[data-security-message-icon]').prop('checked', true).change();
            $('[data-icon-setting]').show();
        } else {
            $('[data-security-message-icon]').prop('checked', false).change();
            $('[data-icon-setting]').hide();
        }
        setTimeout(function () {
            InputControls.populateSecurityPopup = false;
        }, 200);

        // populate text settings
        $('[data-security-message-button-text]').removeClass('error');
        $('[data-security-message-text-error]').hide();
        $('[data-security-message-button-text]').val(text);
        $('[data-security-message-button-text]').css('font-weight', text_style.is_bold ? 700 : 600);
        $('[data-security-message-button-text]').css('font-style', text_style.is_italic ? 'italic' : 'normal');
        if (text_style.is_bold) {
            $('[data-security-message-bold]').addClass('active');
            $('#cta-text-bold-form-field').val('active');
        } else {
            $('[data-security-message-bold]').removeClass('active');
            $('#cta-text-bold-form-field').val('none');
        }
        if (text_style.is_italic) {
            $('[data-security-message-italic]').addClass('active');
            $('#cta-text-itelic-form-field').val('itelic');
        } else {
            $('[data-security-message-italic]').removeClass('active');
            $('#cta-text-itelic-form-field').val('none');
        }
        $("#clr-text").ColorPickerSetColor(text_style.color);
    },

    /**
     * Update security message in local storage
     * @param selected_val
     * @param resetDropdown
     */
    updatedSecurityMessage: function(index, secMessage, is_inserted=false) {
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage'),
            previousSecurityMessage = is_inserted ? secMessage : funnel_info.tcpa_messages[index];

        if(is_inserted) {
            funnel_info.tcpa_messages.push(secMessage);
        } else {
            funnel_info.tcpa_messages[index] = secMessage;
        }
        FunnelsUtil.saveFunnelData(funnel_info);

        let selected_val = is_inserted ? secMessage.id : $("[data-field-name='security-message-id']").val();
        // update dropdown as well
        if (securityMessage.getButtonText() !== previousSecurityMessage.text || is_inserted) {
            initSelect.selectItems["security-message-type"] = initSelect.getTcpaMessages();
            $('.security-message-type').select2('destroy').empty();
            initSelect.initCustomSelect('.security-message-type', '.security-message-parent');
            $('.security-message-type').val(selected_val).trigger('change.select2');

            // if (is_inserted) {
                $("[data-field-name='security-message-id']").val(selected_val);
                setTimeout(function () {
                    SaveChangesPreview.saveJson('security-message-id', selected_val);
                }, 300);
            // }
        }
    },

    /**
     * Save security message in database
     */
    saveSecurityMessageDB: function() {
        $('[data-security-message-save]').once('click', function () {

            if (securityMessage.getButtonText() == '') {
                return false;
            }

            $('[data-security-message-save]').prop('disabled', true);
            $('[data-security-message-save]').addClass("saving");
            // InputControls.updatedSecurityMessage();
            setTimeout(function () {
                let hash = $('[data-lpkeys]').data('lpkeys'),
                    funnel_info = FunnelsUtil._getFunnelInfo('local_storage'),
                    selected_val = $("[data-field-name='security-message-id']").val(),
                    selected_val_index = 0,
                    selected_tcpa_message;
                if(selected_val) {
                    selected_val_index = FunnelsUtil.getTcpaMessageIndex(selected_val, funnel_info.tcpa_messages);
                    selected_tcpa_message = securityMessage.getMessage(funnel_info.tcpa_messages[selected_val_index]);
                } else {
                    selected_tcpa_message = securityMessage.getMessage();
                }
                let url = ajaxSecurityMessageHandler.form.attr('action');
                ajaxSecurityMessageHandler.sendRequest(url, function (response, isError) {
                    if (response.status) {
                        let inserted_id = Number(response.result),
                            is_inserted = false;
                        if ( inserted_id > 0) {
                            is_inserted = true;
                            selected_tcpa_message['id'] = inserted_id;
                        }
                        $('.security-message-parent-wrap').removeClass('disabled');
                        // update security dropdown
                        InputControls.updatedSecurityMessage(selected_val_index, selected_tcpa_message, is_inserted);
                    }
                },selected_tcpa_message);


                // $.ajax( {
                //     type : "POST",
                //     data: {icon: selected_tcpa_message['icon'], text_style: selected_tcpa_message['text_style'], text: selected_tcpa_message['message'], id: tcpa_id},
                //     url : "/lp/ajax/savesecuritymessage/"+hash,
                //     error: function (xhr) {
                //         var err = JSON.parse(xhr.responseText);
                //         if(site.env_production.toLowerCase() == "local") console.log('Saving security message failed with error', err);
                //     },
                //     cache : false,
                //     async : false
                // }).done(function( data ) {
                //     let inserted_id = Number(data),
                //         is_inserted = false;
                //     if ( inserted_id > 0 && tcpa_id == 'null' ) {
                //         is_inserted = true;
                //         selected_tcpa_message['tcpa_id'] = inserted_id;
                //         selected_tcpa_message['id'] = inserted_id;
                //     }
                //     $('.security-message-parent-wrap').removeClass('disabled');
                //     // update security dropdown
                //     InputControls.updatedSecurityMessage(selected_val_index, selected_tcpa_message, is_inserted);
                // });
                SaveChangesPreview.iframePostMessage();
                $('[data-security-message-save]').removeClass("saving");
                $('[data-security-message-save]').prop('disabled', false);
                $('#security-message-modal').modal('hide');
            }, 200);
        });
    },

    /**
     * Set zoom
     */
    setLockZoomSlider: function() {
        let zoom = FunnelsUtil._getZoomSettings();
        if (zoom && zoom['lock'] == 1) {
            let slider_val = zoom['value'];
            jQuery('.size-range-bar-val').val(slider_val);
            jQuery('.size-range-bar-slide').bootstrapSlider('setValue', slider_val);
        }
    },

    /**
     * Allow digits input only
     */
    allowDigitsOnly: function() {
        jQuery('[data-allow-digits-only]').on('keypress' ,function(e) {
            if((event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 8)return false;
            if (e.which < 0x20)return;
        });
    },

    /**
     * Set icon positioning and security message drop downs on edit/first load
     */
    setIconSecurityDropdown: function() {
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        let ques_id = $('[data-id="ques_id"]').val();
        let security_message_id, button_icon_position;

        if (funnel_info.questions[ques_id]['question-type'] == 'contact') {
            let mappedFields = SaveContactPreviewChanges.getContactMappedFields(funnel_info, false);
            button_icon_position = mappedFields['cta-button-settings']['button-icon-position'];
            security_message_id = mappedFields['security-message-id'];
        }else if(funnel_info.questions[ques_id]['question-type'] == 'vehicle'){
            button_icon_position =  funnel_info.questions[ques_id]['options']['cta-button-settings'][FunnelsUtil.tabStep]['button-icon-position'];
            security_message_id = funnel_info.questions[ques_id]['options']['security-message-id'][FunnelsUtil.tabStep];
        }else {
            button_icon_position = funnel_info.questions[ques_id]['options']['cta-button-settings']['button-icon-position'];
            security_message_id = funnel_info.questions[ques_id]['options']['security-message-id'];
        }

        // if no security message is selected then select 1st in list
        if (security_message_id == 0 && funnel_info.tcpa_messages[0] !== undefined) {
            security_message_id = funnel_info.tcpa_messages[0]['id'];
        }

        let button_icon_position_val = FunnelsUtil.getKeyByValue(Constants.BUTTON_ICON_POSITION, button_icon_position);
        $("[data-field-name='cta-button-settings.button-icon-position']").val(button_icon_position_val).change();
        $("[data-field-name='security-message-id']").val(security_message_id).change();
        if ($.inArray(funnel_info.questions[ques_id]['question-type'], ['dropdown','menu']) !== -1 && security_message_id !== 0) {
            // Fix issue with dropdown & menu question
            FunnelActions.setCurrentQuestionOptionValue('security-message-id', security_message_id);
            SaveChangesPreview.saveJson('security-message-id', security_message_id);
        }
    },

    /**
     * This will close question overlay & refresh listing
     */
    closeQuestionOverlay: function(checkSaveButtonState = false) {
        if(checkSaveButtonState) {
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            if(FunnelsUtil.haveNewQuestions(funnel_info) || FunnelsUtil.isRemovedExistingQuestion(funnel_info)) {
                FunnelActions.enableFunnelSaveBtn();
            } else {
                FunnelActions.disableFunnelSaveBtn();
            }
        }
        jQuery('body').removeClass('overlay-active panel-aside_closed full-screen-preview');
        jQuery('.disbale-option-tooltip-area.mobile-mode').css({"display":"none","opacity": '0', "visibility": 'hidden'});
        jQuery('.funnel-overlay, .funnel-iframe-holder').remove();
        // Reload Questions Grid to show impact of change
        FunnelActions.loadQuestions(false);
        FunnelActions.resetBeforeQuestionEditSettings();
    },

    urlValidation: function (url_input,url){
        if($(url_input).attr('data-field-name') == 'cta-button-settings.outside-url'){
            var valid = /^((ftp|http|https):\/\/)?.([A-z]+)\.([A-z]{2,})/.test(url);
            $('.outside-url-field input').removeClass('error');
            FunnelsUtil.setSubmitButtonErrorState(false);
            if(valid == false)
            {
                $('.outside-url-field input').addClass('error');
                FunnelsUtil.setSubmitButtonErrorState(true);
                return false;
            }
        }
    },

    /*
    ** Open Close Function
    **/
    openclose: function () {
        jQuery(document).off("click", '.last-selected').on("click", '.last-selected', function(){
            jQuery('body').toggleClass('colorpicker-active');
        });

        jQuery(document).off("click", '.overlay-active [question-preview-close]').on('click', '.overlay-active [question-preview-close]',function (e) {
            e.preventDefault();
            if(FunnelActions.isQuestionChanged()) {
                $('#question-confirmation-close').modal('show');
            } else {
                InputControls.closeQuestionOverlay(true);
            }
            setTimeout(function(){
                funnelConditions.setQuestionCLActive();
            },0);
        });

        /**
         * revert question JSON back when clos confirmation box
         */
        jQuery(document).off("click", '#question-confirmation-close .button-cancel').on("click", '#question-confirmation-close .button-cancel', function (e) {
            e.stopPropagation();
            $('#question-confirmation-close').modal('hide');
            if(typeof FunnelActions.questionBeforeChange === "object") {
                let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
                funnel_info.questions[FunnelActions.currentQuestionId] = FunnelActions.questionBeforeChange;
                localStorage.setItem(FunnelsUtil.ls_key, JSON.stringify(funnel_info));
            }
            setTimeout(function(){
                funnelConditions.setQuestionCLActive();
            },0);
            InputControls.closeQuestionOverlay(true);
        });

        jQuery(document).off("click", '#question-confirmation-close #save-changes').on("click", '#question-confirmation-close #save-changes',  function (e) {
            e.stopPropagation();
            $('[data-id="main-submit"]').trigger('click', {question_confirmation_close: true});
        });

        // jQuery('[question-preview-close]').off("click").on('click', function (e) {
        //     if (FunnelsBuilder.validHiddenField && FunnelsBuilder.validHiddenParam) {
        //         $('body').removeClass('hidden-field-modal');
        //         e.preventDefault();
        //         $('#hidden-field-modal').modal('hide');
        //     } else if ($('[data-field-name="hidden.field-label"]').val().trim() == '') {
        //         $('[data-hidden-save-btn]').click();
        //     }
        // });

        jQuery(document).off('keyup input paste', '[data-change-text], [data-change-unique-variable]').on('keyup input paste', '[data-change-text], [data-change-unique-variable]', FunnelsUtil.debounce(function (event) {
            if(event.target.dataset.fieldName === 'unique-variable-name' || event.target.dataset.changeUniqueVariable !== undefined){
                event.target.value = $.trim(event.target.value);
                let questionId = $('[data-id="ques_id"]').val(),
                currentQuestion = FunnelsUtil._getFunnelInfo('local_storage').questions[questionId];
                if (currentQuestion && currentQuestion['question-type'] === 'contact'){
                    SaveContactPreviewChanges.saveUniqueVariableName(event);
                } else {
                    SaveChangesPreview.saveQuestion(event, "text");
                }
                $('[data-change-unique-variable]').removeClass('error');
                FunnelActions.enableFunnelSaveBtn();
            } else {
                if($(this).attr('data-field-name') == 'cta-button-settings.outside-url'){
                    var valid = /^((ftp|http|https):\/\/)?.([A-z]+)\.([A-z]{2,})/.test($(this).val());
                    if(valid == true)
                    {
                        $('.outside-url-field input').removeClass('error')
                    }
                }
                SaveChangesPreview.saveQuestion(event, "text");
                //this check work for slider question
                if (window.question_type === 'slider') {
                    sliderOptionLoad();
                    sliderManage();
                }
            }
            if($(this).attr('data-field-name') == 'cta-button-settings.outside-url')
            {
                var top_field_name = 'cta-button-settings.link-destination';
                var top_field_value = $('.cta-link-text').val();
                console.log(top_field_name,top_field_value,22)
                SaveChangesPreview.saveJson(top_field_name,top_field_value);
            }

        }, 500));

        $(document).on('blur','.outside-url-field input',function (e){
            let url = $(this).val();
            let url_input = $(this);
            InputControls.urlValidation(url_input,url);
        })

        /**
         * Edit security message validation in popup
         */
        jQuery(document).off('keyup input paste', '[data-security-message-button-text]').on('keyup input paste', '[data-security-message-button-text]', FunnelsUtil.debounce(function (event) {
            if ($(this).val().trim() != '') {
                $('[data-security-message-button-text]').removeClass('error');
                $('[data-security-message-text-error]').hide();
            } else if ($(this).val().trim() == '') {
                $('[data-security-message-button-text]').addClass('error');
                $('[data-security-message-text-error]').show();
            }
        }, 500));

        jQuery(document).off("change", '.hide-checkbox-field').on('change', '.hide-checkbox-field',function (event) {
            if (this.checked) {
                jQuery('.cta-btn-wrap').hide();
            } else {
                jQuery('.cta-btn-wrap').show();
            }
            SaveChangesPreview.saveQuestion(event, 'enable-hide-until-answer');
        });


        // Section Expand/Collapse
        setTimeout(function(){
            var sections = $('.panel-aside-wrap-overlay');

            jQuery(document).off("click", '[data-handler]').on('click', '[data-handler]', function(){
                jQuery(this).closest('[data-parent]').toggleClass('active');
                if(jQuery(this).hasClass('open')) {
                    if(jQuery(this).closest('[data-parent]').find('[data-delete-content]').length)
                        jQuery(this).closest('[data-parent]').find('[data-delete-content]').slideUp('slow');

                    jQuery(this).closest('[data-parent]').find('[data-handler-slide]:first').stop().slideUp('slow');
                }
                else {
                    if(jQuery(this).closest('[data-parent]').find('[data-delete-content]').length)
                        jQuery(this).closest('[data-parent]').find('[data-delete-content]').slideDown();

                    jQuery(this).closest('[data-parent]').find('[data-handler-slide]:first').stop().slideDown(function () {

                        var link = jQuery(this);

                        sections.mCustomScrollbar("scrollTo", link.position().top - 60, {
                            timeout: 0,
                            scrollInertia: 850,
                        });

                        // disable original jumping
                        //return false;

                       if( jQuery(this).closest('[data-parent]').find('.form-control').length > 0) {
                            jQuery(this).closest('[data-parent]').find('.form-control').setCursorPosition(this);
                        }
                    });
                }
                if(jQuery('.advance-options-wrap').hasClass('active')) {
                   jQuery(this).parents('.panel-aside').removeClass('advance-option-active');
               }
               else {
                   jQuery(this).parents('.panel-aside').addClass('advance-option-active');
               }
                jQuery(this).toggleClass('open');
            });
        }, 500);

        //Toggle Checkboxes for automatic progress / alphabetize / select-multiple
        jQuery(document).off("change", '[data-opener-checkbox]').on('change', '[data-opener-checkbox]',function (event) {
            // update multiple fields to remove recursive call to this function which was happening because of .trigger("change") on bootstrap toggle
            let updateMultipleFields = false;
            if (jQuery(this).data('on-checked-update-fields') !== undefined || jQuery(this).data('on-unchecked-update-fields') !== undefined) {
                updateMultipleFields = true;
            } else {
                SaveChangesPreview.saveQuestion(event);
            }
            let ctaButton = jQuery('[data-cta-button-menu]');
            if(event.target.dataset.fieldName == 'automatic-progress'){
                if(event.target.checked){
                    ctaButton.slideUp( "slow", function() {
                        ctaButton.addClass('question-hide'); // Hide CTA Section
                    });
                    jQuery("[data-required-option]").addClass('question-hide').find('[data-opener-checkbox]').prop('checked',false);
                    // jQuery('.hide-checkbox-field').prop('checked',true).stop().trigger('change');
                    if (updateMultipleFields && question_type == 'menu') {
                        jQuery("[data-none-field]").slideUp();
                        jQuery("[data-none-field]").find('[data-include-option]').prop('checked', false).trigger("change");
                        SaveChangesPreview.updateMultipleFields(jQuery(this).data('field-name'), 1, jQuery(this).data('on-checked-update-fields'));
                        jQuery("[data-field-name='select-multiple']").prop('checked', false);
                    }else{
                        SaveChangesPreview.saveJson(jQuery(this).data('field-name'), 1);
                    }
                }
                else{
                    ctaButton.slideDown( "slow", function() {
                        ctaButton.removeClass('question-hide'); //show CTA Section
                    });
                    jQuery("[data-required-option]").removeClass('question-hide').find('[data-opener-checkbox]').prop('checked',true);
                    // jQuery('.hide-checkbox-field').prop('checked',false).stop().trigger('change');
                    if (updateMultipleFields && question_type == 'menu') {
                        SaveChangesPreview.updateMultipleFields(jQuery(this).data('field-name'), 0, jQuery(this).data('on-checked-update-fields'));
                    }else{
                        SaveChangesPreview.saveJson(jQuery(this).data('field-name'), 0);
                    }
                    $('[data-cta-button]').removeClass('d-none');
                    setTimeout(function(){
                        jQuery('.panel-aside-wrap-overlay').mCustomScrollbar("scrollTo","bottom",{
                            scrollInertia: 500
                        });
                    }, 100);
                }
            }
            else if(event.target.dataset.fieldName == 'required'){
                if(!event.target.checked){
                    if($('#zip-code-showonly-option').prop('checked')){
                        $('#zip-code-showonly-option').click();
                    }
                    $('[data-cta-button]').addClass('d-none');
                }else{
                    $('[data-cta-button]').removeClass('d-none');
                }
                if($("[data-automatic-progress-option]").length) {
                    if (!event.target.checked) {
                        jQuery("[data-required-option]").find('[data-opener-checkbox]').prop('checked', false);
                    }
                }
            }
            else if(event.target.dataset.fieldName == 'alphabetize'){
                if (event.target.checked && updateMultipleFields) {
                    SaveChangesPreview.updateMultipleFields(jQuery(this).data('field-name'), 1, jQuery(this).data('on-checked-update-fields'));
                    jQuery("[data-randomize]").find('[data-opener-checkbox]').prop('checked', false);
                } else {
                    SaveChangesPreview.saveJson(jQuery(this).data('field-name'), 0);
                }
            }
            else if(event.target.dataset.fieldName == 'randomize'){
                if (event.target.checked && updateMultipleFields) {
                    SaveChangesPreview.updateMultipleFields(jQuery(this).data('field-name'), 1, jQuery(this).data('on-checked-update-fields'));
                    jQuery("[data-alphabetize]").find('[data-opener-checkbox]').prop('checked', false);
                } else {
                    SaveChangesPreview.saveJson(jQuery(this).data('field-name'), 0);
                }
            }
            else if(event.target.dataset.fieldName == 'select-multiple'){
                    if (event.target.checked) {
                        jQuery("[data-none-field]").slideDown();
                        ctaButton.find('[data-handler-slide]').slideUp();
                        ctaButton.slideDown( "slow", function() {
                            ctaButton.removeClass('question-hide'); //show CTA Section
                        });
                        if (updateMultipleFields && question_type == 'menu') {
                            SaveChangesPreview.updateMultipleFields(jQuery(this).data('field-name'), 1, jQuery(this).data('on-checked-update-fields'));
                            jQuery("[data-automatic-progress-option]").find('[data-opener-checkbox]').prop('checked', false);
                            ctaButton.slideDown( "slow", function() {
                                ctaButton.removeClass('question-hide'); //show CTA Section
                            });
                        }else{
                            SaveChangesPreview.saveJson(jQuery(this).data('field-name'), 1);
                        }
                    } else {
                        jQuery("[data-none-field]").slideUp();
                        jQuery("[data-none-field]").find('[data-include-option]').prop('checked', false).trigger("change");
                        ctaButton.slideUp( "slow", function() {
                            ctaButton.addClass('question-hide'); // hide CTA Section
                        });
                        if(!event.isTrigger) {
                            if (updateMultipleFields && question_type == 'menu') {
                                SaveChangesPreview.updateMultipleFields(jQuery(this).data('field-name'), 0, jQuery(this).data('on-unchecked-update-fields'));
                                jQuery("[data-automatic-progress-option]").find('[data-opener-checkbox]').prop('checked', true);
                            }else{
                                SaveChangesPreview.saveJson(jQuery(this).data('field-name'), 0);
                            }
                        }
                    }
            }
            else if(event.target.dataset.fieldName == 'zip-code-only' || event.target.dataset.fieldName == 'city-or-zip-code'){

                if(event.target.dataset.fieldName == 'zip-code-only'){
                    $.each(cl_object.conditions, function (key, condition) {
                        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
                        let dataFieldId = funnel_info.questions[current_question_id].options['data-field']
                        let clFieldIds= condition.terms['t1'].actionFieldId;
                        let quesType = funnel_info.questions[current_question_id]['question-type'];
                        if(QuestionConditions.hasTriggerAssociations(clFieldIds, dataFieldId, quesType) &&
                            QuestionConditions.checkAlphabet(condition.terms['t1'].value[0])
                        ){

                            condition.active= -1;
                        }
                    });
                }


                zipCodeHanlder.zipcodePreviewHandler(event);
            }
            else if(event.target.dataset.fieldName == 'required-us-zip'){
                if (event.target.checked) {
                    jQuery("[data-field-name='required-canadian-zip']").prop('checked', false).trigger('change');
                }
            }
            else if(event.target.dataset.fieldName == 'required-canadian-zip'){
                if (event.target.checked) {
                    jQuery("[data-field-name='required-us-zip']").prop('checked', false).trigger('change');
                    event.target.dataset.fieldName = 'field-label';
                    event.target.value = 'POSTAL CODE';
                    SaveChangesPreview.saveQuestion(event,'text');
                    $(".label-field").val(event.target.value);
                    event.target.dataset.fieldName = 'required-canadian-zip';
                    }
                else {
                    // jQuery("[name='zipcode-input']:checked").change();
                }
            }
        });

        // Toggle Checkbox Handlers
        jQuery(document).off('change', '[data-opener]').on('change', '[data-opener]',function (event) {
            SaveChangesPreview.saveQuestion(event);
            $width = jQuery(window).width();
            $resize_width = 1500;
            if(this.checked){
                $this = this;
                setTimeout(function() {
                    if (jQuery($this).closest('[data-parent]').find('.form-control').length > 0) {
                        jQuery($this).closest('[data-parent]').find('.form-control').focus().setCursorPosition($this);
                    }
                }, 100);

                if(jQuery(this).closest('[data-parent]').find('[data-delete-content]').length)
                    jQuery(this).closest('[data-parent]').find('[data-delete-content]').show();

                jQuery(this).closest('[data-parent]').find('[data-slide]').stop().slideDown(function (){
                    var childdivs = jQuery('[data-slide]');
                    var withheight = childdivs.filter('[style*=height]');

                    $(withheight).addClass('height-added');

                    if( jQuery($this).closest('[data-parent]').find('.fb-froala__init').length > 0) {
                        jQuery($this).closest('[data-parent]').addClass('active');
                        if($width > $resize_width){
                            jQuery($this).closest('[data-parent]').find('.classic-editor__wrapper').addClass('focus').setCursorPosition('froala');
                        }
                        let parent = jQuery($this).closest('[data-parent]');
                        if (parent.length > 0) {
                            let editor = lpHtmlEditor.getInstance(parent.find('.fb-froala__init'));
                            editor.events.focus(false);
                            if($width > $resize_width){
                                editor.events.focus(true);
                            }
                            parent.addClass('active');
                            if($width > $resize_width){
                                parent.find('.classic-editor__wrapper').addClass('focus').setCursorPosition('froala');
                            }
                        }
                        if (parent.find('.form-control').length > 0) {
                            parent.find('.form-control').setCursorPosition($this);
                        }
                    }
                });
            }
            else {
                if (jQuery(this).closest('[data-parent]').find('[data-delete-content]').length)
                    jQuery(this).closest('[data-parent]').find('[data-delete-content]').hide();

                jQuery(this).closest('[data-parent]').find('[data-slide]').stop().slideUp(function () {
                    jQuery(this).closest('[data-parent]').find('.classic-editor__wrapper').removeClass('focus');
                    jQuery(this).closest('[data-parent]').removeClass('active');
                    let parent = jQuery(this).closest('[data-parent]');
                    if (parent.find('[data-delete-content]').length)
                        parent.find('[data-delete-content]').hide();

                    parent.find('[data-slide]').stop().slideUp(function () {
                        if (parent.find('.fb-froala__init').length > 0) {
                            let editor = lpHtmlEditor.getInstance(parent.find('.fb-froala__init'));
                            editor.events.focus(true);
                            parent.find('.classic-editor__wrapper').removeClass('focus');
                            parent.removeClass('active');
                        }
                    });
                });
            }
        });

        // Button Icon Toggle
        jQuery(document).off('change', '[data-icon-opener]').on('change', '[data-icon-opener]',function (event) {
            SaveChangesPreview.saveQuestion(event);
            if(this.checked){
                jQuery(this).parents('[data-parent]').find('[data-icon-slide]').stop().slideDown();
                jQuery('.cta-btn .icon-holder').show();
                if(event.target.dataset.fieldName === 'cta-button-settings.enable-button-icon') {
                    jQuery('[data-silder-ranger-icon]').bootstrapSlider('setValue', jQuery('[data-silder-value]').val());
                    SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName: "data-slider-icon"});
                }
            }
            else {
                jQuery(this).parents('[data-parent]').find('[data-icon-slide]').stop().slideUp();
                jQuery('.cta-btn .icon-holder').hide();
            }
        });

        //Toggle Checkboxes for slider format
        jQuery(document).off('change', '[data-slider-format-checkbox]').on('change', '[data-slider-format-checkbox]', function (event) {
            SaveChangesPreview.saveQuestion(event);
            slider.refresh();
        });

        jQuery(document).off("click", '.action_dresponsive .view-link').on("click", '.action_dresponsive .view-link', function(e){
            e.preventDefault();
            jQuery('.view-link').removeClass('active');
            jQuery(this).addClass('active');
            let postAttribute = '';
            if(jQuery(this).hasClass('mobile-view-link')){
                jQuery('.funnel-iframe-holder').addClass('mobile-view-active');
                jQuery('.panel-aside').addClass('disable-options');
                jQuery('.bottom-toggle-info .fb-field-label').prop("checked", true);
                postAttribute = 'mobile-preview';
            }
            else {
                jQuery('.funnel-iframe-holder').removeClass('mobile-view-active');
                jQuery('.panel-aside').removeClass('disable-options');
                jQuery('.bottom-toggle-info .fb-field-label').prop("checked", false);
                postAttribute = 'desktop-preview';
            }
            if(jQuery(this).hasClass('desktop-view-link')){
                jQuery('.disbale-option-tooltip-area.mobile-mode').css({"display":"none","opacity": '0', "visibility": 'hidden'});
            }
            jQuery(".panel-aside-wrap-overlay").removeClass('active-mobile-mode');
            jQuery(".funnel-iframe-holder iframe")[0].contentWindow.postMessage(postAttribute, '*');
        });

        jQuery(document).off("click", '.full-screen-link').on("click", '.full-screen-link', function(){
            jQuery(this).toggleClass('active');
            if (jQuery(this).hasClass('active')) {
                SaveChangesPreview.saveJson('full_screen', 1);
            } else {
                SaveChangesPreview.saveJson('full_screen', 0);
            }
            jQuery('body').toggleClass('full-screen-preview');
            let postAttribute = '';
            if(jQuery('.funnel-iframe-holder').hasClass('mobile-view-active')){
                postAttribute = 'mobile-preview';
            }
            else {
                postAttribute = 'desktop-preview';
            }
            jQuery(".funnel-iframe-holder iframe")[0].contentWindow.postMessage(postAttribute, '*');
        });

        jQuery(document).off("click", '.lock-zoom-view').on("click", '.lock-zoom-view', function(){
            jQuery(this).parents('.zoom-slider-item').addClass('zoom-slider-disable');
            $('.range-slider-overlay').tooltipster('enable');
            SaveChangesPreview.saveJson('zoom_lock', 1);
        });

        jQuery(document).off("click", '.unlock-zoom-view').on("click", '.unlock-zoom-view', function(){
            jQuery(this).parents('.zoom-slider-item').removeClass('zoom-slider-disable');
            $('.range-slider-overlay').tooltipster('disable');
            SaveChangesPreview.saveJson('zoom_lock', 0);
        });

        /*jQuery('.funnel-checkbox').click(function(){
            jQuery('.funnel-checkbox').removeClass('mobile-mode-active');
            jQuery(this).addClass('mobile-mode-active');
        });*/


        jQuery(document).off("change", '.bottom-toggle-info .fb-field-label').on("change", '.bottom-toggle-info .fb-field-label', function (event) {
            let postAttribute = '';
            if(this.checked){
                jQuery('.panel-aside').addClass('disable-options');
                jQuery('.funnel-iframe-holder').addClass('mobile-view-active');
                jQuery('.funnel-checkbox').addClass('mobile-mode-active');
                jQuery('.mobile-view-link').addClass('active');
                jQuery('.desktop-view-link').removeClass('active');
                jQuery(this).parents('.disbale-option-tooltip-area').css({"display":"block", "opacity": '1', "visibility": 'visible'});
                postAttribute = 'mobile-preview';
            }
            else {
                jQuery('.panel-aside').removeClass('disable-options');
                jQuery('.funnel-iframe-holder').removeClass('mobile-view-active');
                jQuery('.funnel-checkbox').removeClass('mobile-mode-active');
                jQuery('.mobile-view-link').removeClass('active');
                jQuery('.desktop-view-link').addClass('active');
                jQuery(this).parents('.disbale-option-tooltip-area').css({"display":"none", "opacity": '0', "visibility": 'hidden'});
                postAttribute = 'desktop-preview';
            }
            jQuery(".funnel-iframe-holder iframe")[0].contentWindow.postMessage(postAttribute, '*');

        });

        if(jQuery('.funnel-cta-overlay').length === 1) {
            jQuery('[data-delete-content]').off("click").on("click", function(){
                let field = $(this).closest('[data-parent]').find('.fb-froala__init').data('field-name');
                jQuery(this).closest('[data-parent]').find('.fr-view').html('');
                jQuery('.classic-editor__wrapper').removeClass('focus');
                jQuery(this).closest('[data-parent]').find('.classic-editor__wrapper').addClass('focus').setCursorPosition('froala');
                jQuery(this).remove();
                SaveChangesPreview.saveJson(field,'');
            });

            // Toggle Checkbox Handlers for CTA message overlay
            jQuery(document).off("change", '[data-opener-cta]').on("change", '[data-opener-cta]', function () {
                var sections = $('.panel-aside-wrap-overlay');
                if (this.checked) {
                    jQuery(this).addClass('open');
                    jQuery(this).closest('[data-parent]').find('[data-slide]').stop().slideDown(function () {
                        var link = $(this);

                        sections.mCustomScrollbar("scrollTo", link.position().top - 60, {
                            timeout: 0,
                            scrollInertia: 500,
                        });
                    });
                    if( jQuery(this).closest('[data-parent]').find('.form-control').length > 0) {
                        jQuery(this).closest('[data-parent]').find('.form-control').setCursorPosition(this);
                    }
                }
                else {
                    jQuery(this).removeClass('open');
                }
            });
        }

        FunnelsUtil.exitFullScreen();
    },

    /*
   * Outside hover close dropdown
   * */
    outside_hover: function () {
        jQuery('.client-setting__quick').mouseleave(function() {
            jQuery(this).find('.quick-dropdown').attr('style', '');
            jQuery(this).removeClass('quick-active');
        });
    },

    /*
    * Remove Empty Space on Field
    * */
    remove_empty_space: function () {
      jQuery('.outside-url-field .form-control').keypress(function(e) {
        if(e.which === 32)
          return false;
      })
    },

    /*
  * Disable mouse postion
  * */
    disbale_mouse_postion: function () {
        jQuery(document).off('click' , '.disable-options .panel-aside-wrap-overlay').on('click' , '.disable-options .panel-aside-wrap-overlay', function(e){
            jQuery(this).addClass('active-mobile-mode');
            var block_height =  $('.disbale-option-tooltip-area.mobile-mode').height();
            var newX = Math.max(e.clientX - 230, 10);
            let newY = e.pageY-block_height+15;
            if(newY < block_height){
                newY = 82;
            }
            jQuery('.disbale-option-tooltip-area.mobile-mode').css({"display":"block","opacity": '1', "visibility": 'visible',"top": newY, left: newX});
        });
    },

    /*
    * Quick Access Menu Function
    * */
    quick_access: function() {
        jQuery('.client-setting__opener').click(function (e) {
            e.preventDefault();
            if(jQuery(this).parents('.client-setting__quick').hasClass('quick-active')) {
                jQuery(this).parents('.client-setting__quick').find('.quick-dropdown').attr('style', '');
                jQuery(this).parents('.client-setting__quick').removeClass('quick-active');
            } else {
                jQuery(this).parents('.client-setting__quick').addClass('quick-active');
                jQuery(this).parents('.client-setting__quick').find('.quick-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scaleX(1) scaleY(1)'});
            }
        });
    },

    /*
    * Security select Function
    * */
    security_select_funcation: function() {
        var option_length = jQuery('.security-message-type option').length;
        if(option_length === 0) {
            jQuery('.security-message-parent-wrap').addClass('disabled').tooltipster('enable');
        }
        else {
            jQuery('.security-message-parent-wrap').removeClass('disabled').tooltipster('disable');
        }
    },

    /*
  ** Tool Tip Function
  **/
    tooltip: function () {

        jQuery('.el-tooltip').tooltipster({
            contentAsHTML:true
        });

        $('.el-button-tooltip').tooltipster({
            contentAsHTML:true,
            delay: 0,
            speed: 50,
            debug:false
        });
    },

    /*
     ** Range bar Function
     **/
    rangeBar: function () {
        let fontSlider = jQuery('[data-silder-ranger]').bootstrapSlider({
            formatter: function(value) {
                jQuery('[data-silder-value]').val(value);
                return   value +'px';
            },
            min: 12,
            max: 50,
            value: jQuery('[data-silder-value]').val(),
            id: "data-silder-ranger",
            tooltip: 'always',
            tooltip_position: 'bottom'
        });

        fontSlider.on('change', function (event) {
            SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName:"data-silder-value"});
            if(jQuery('[data-lock-slider]').hasClass('selected')) {
                jQuery('[data-silder-ranger-icon]').bootstrapSlider('setValue', jQuery('[data-silder-value]').val());
                SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName: "data-slider-icon"});
            }
        });

        fontSlider.on('slide', function () {
            jQuery('body').addClass('slide-move-active');
        });

        fontSlider.on('slideStop', function () {
            jQuery('body').removeClass('slide-move-active');
        });

        let iconSlider = jQuery('[data-silder-ranger-icon]').bootstrapSlider({
            formatter: function(value) {
                jQuery('[data-slider-icon]').val(value);
                return   value +'px';
            },
            min: 12,
            max: 50,
            value: jQuery('[data-slider-icon]').val(),
            id: "data-slider-icon",
            tooltip: 'always',
            tooltip_position: 'bottom'
        });

        iconSlider.on('change', function (event) {
            SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName:"data-slider-icon"});
        });

        iconSlider.on('slide', function () {
            jQuery('body').addClass('slide-move-active');
        });

        iconSlider.on('slideStop', function () {
            jQuery('body').removeClass('slide-move-active');
        });

        jQuery('.size-range-bar-slide').bootstrapSlider({
            formatter: function(value) {
                jQuery('.size-range-bar-val').val(value);
                return   value +'%';
            },
            min: 75,
            max: 100,
            value: jQuery('.size-range-bar-val').val(),
            id: "size-range-bar",
            tooltip: 'always',
            tooltip_position: 'top'
        }).on("change", function(slideEvt) {
            var pass_data = {
                'scale-view': slideEvt.value.newValue
            };
            jQuery(".funnel-iframe-holder iframe")[0].contentWindow.postMessage(pass_data, '*');
        });

    },

    /*
     ** select Icon Function
     **/
    fontIconList: function () {

        function fontAwsome() {
            jQuery('.icons-list').html('');
            jQuery.each(InputControls.obj_fontawsome,function (index,value) {
                jQuery('.icons-list').append('<li class="list-icon-item"><span class="icon-label"><span class="icon-wrap"><i class="ico-'+index+'"></i></span>' +
                    '<span class="text-icon-wrap"><span class="icon-title">Icon:</span><span class="text-icon">'+value+'</span></span></span></li>');
            });
        }
        fontAwsome();

        var $fontAsome;

        jQuery(document).on('click','.select-icon-opener',function () {
            jQuery(this).addClass('icon-popup-active');
            var get_class = jQuery(this).find('.icon-wrap').children().attr('class');
            var icon_path = jQuery('.icons-list').find('.' + get_class);
            jQuery(icon_path).parents('.icon-label').addClass('active');
            jQuery(icon_path).parents('.list-icon-item').addClass('parent-active');
        });

        jQuery('#select-icon-modal').on('hidden.bs.modal', function () {
            jQuery('.select-icon-opener').removeClass('icon-popup-active');
            jQuery('.icons-list li > span').removeClass('active').parent().removeClass('parent-active');
        });

        jQuery('#select-icon-modal').on('show.bs.modal', function () {
            jQuery('.button-primary').prop("disabled", true);
        });

        jQuery('.icons-list li > span').once('click', function(){
            var _self = jQuery(this);
            jQuery('.icons-list li > span').removeClass('active').parent().removeClass('parent-active');
            _self.addClass('active').parent().addClass('parent-active');
            $fontAsome = _self.html();
            jQuery('.button-primary').prop("disabled", false);
        });

        jQuery('.btn-add-icon').click(function () {
            jQuery('.icon-popup-active').html('');
            jQuery('.icon-popup-active').html($fontAsome);
            jQuery('.cta-btn .icon-holder').html($fontAsome);
            jQuery('.select-icon-opener').removeClass('icon-popup-active');
            jQuery('.icons-list li > span').removeClass('active').parent().removeClass('parent-active');
            jQuery('#select-icon-modal').modal('hide');
            SaveChangesPreview.saveQuestion('', 'add-icon');
        });
    },


    /*
    ** Add Class Click Function
    **/
    addClassClick: function () {
        jQuery(document).on('click' , '.panel-aside__head .back-ico', function(){
            jQuery('body').toggleClass('panel-aside_closed');
        });

        jQuery("[data-lock-slider]").click(function () {
            jQuery(this).parents('[data-icon-slide]').toggleClass('slider-disabled');
            jQuery(this).toggleClass('selected');
            jQuery('[data-silder-ranger-icon]').bootstrapSlider('setValue', jQuery('[data-silder-value]').val());
            SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName: "data-slider-icon"});
        });

        jQuery(document).on('mouseenter' , '.full-screen-preview .header', function(){
            jQuery('body').addClass('header-hover');
        });

        jQuery(document).on('mouseleave' , '.full-screen-preview .header', function(){
            jQuery('body').removeClass('header-hover');
        });

        jQuery(document).on('click' , '.dropdown-option-block', function(){
            jQuery(this).addClass('focus');
        });

        jQuery(document).on('click' , '.funnel-content .header, .funnel-content .panel-aside__head', function(){
            jQuery('.disbale-option-tooltip-area.mobile-mode').css({"display":"none", "opacity": '0', "visibility": 'hidden'});
        });
    },


    /*
   ** Custom scroll Function
   **/
    customScroll: function () {

        if(jQuery('.panel-aside-wrap-overlay').length > 0) {
            jQuery('.panel-aside-wrap-overlay').mCustomScrollbar({
                axis: "y",
                scrollInertia: 200,
                callbacks: {
                    whileScrolling: function () {
                        var select_button = $(".fb-froala.focus").find('.fb-froala__init .fr-wrapper').offset();
                        var block_height = $(".fb-froala.focus").find('.fb-froala__init .fr-wrapper').height();
                        var window_height = $('.panel-aside-wrap-overlay').height();
                        var select_dropdown = $('.fr-popup.fr-active').height();

                        if(select_button !== undefined && !$('.fb-froala__init').parents('.fb-froala.focus').find('.fr-popup').hasClass('fr-active')) {
                            var select_total = select_button.top + select_dropdown;
                            lpUtilities.editorPopupPosition(window_height,select_total,select_dropdown,block_height,select_button);
                        }
                    }
                }
            });
        }

        if(jQuery('.quick-scroll').length > 0) {
            jQuery('.quick-scroll').mCustomScrollbar({
                axis: "y",
            });
        }

        if(jQuery('.dropdown-option-list-holder').length > 0) {
            jQuery('.dropdown-option-list-holder').mCustomScrollbar({
                axis: "y",
            });
        }
    },

    /*
     ** Outside click Function
     **/
    outSideClick: function () {
        jQuery(document).click(function (e) {
            var target = e.target;

            if (jQuery("body").hasClass('colorpicker-active')) {
                if (jQuery(target).parents('.color-box__panel-wrapper').length > 0 || jQuery(target).hasClass('color-box__panel-wrapper')) {
                } else {
                    SaveChangesPreview.saveQuestion('', 'color-picker');
                    colorPicker.color_picker_clicked = false;
                    jQuery('body').removeClass('colorpicker-active');
                }
            }

            if (jQuery(".client-setting__quick").hasClass('quick-active')) {
                if (jQuery(target).parents('.client-setting__quick').length > 0) {
                } else {
                    jQuery('.quick-dropdown').slideUp(400, function () {
                        jQuery('.client-setting__quick').removeClass('quick-active');
                    });
                }
            }

            if (jQuery(".classic-editor__wrapper").hasClass('focus')) {
                if (jQuery(target).parents('.classic-editor__wrapper').length > 0 || jQuery(target).hasClass('froala-clear-text')) {
                }
                else {
                    jQuery('.classic-editor__wrapper').removeClass('focus');
                }
            }

            if (jQuery(".classic-editor__wrapper").hasClass('head-dropdown-active')) {
                if (jQuery(target).parents('.classic-editor__wrapper').length > 0) {
                }
                else {
                    jQuery('.classic-editor__wrapper').removeClass('head-dropdown-active');
                }
            }

            if (jQuery(".dropdown-option-block").hasClass('focus')) {
                if (jQuery(target).parents('.dropdown-option-block').length > 0) {
                }
                else {
                    jQuery('.dropdown-option-block').removeClass('focus');
                }
            }

            if (jQuery(".funnel-checkbox").hasClass('mobile-mode-active')) {
                if (jQuery(target).parents('.funnel-checkbox').length > 0 || jQuery(target).hasClass('funnel-checkbox')) {
                } else {
                    jQuery('.funnel-checkbox').removeClass('mobile-mode-active');
                }
            }
        });
    },

    /**
     * Navigate to text-field/text-area sections
     */
    navigateQuestion: function() {
        $('[data-nav-id]').click(function () {
            $(this).addClass('active');
            if ($(this).data('nav-id') == 'long_text') {
                $('[data-nav-id="short_text"]').removeClass('active');
                SaveChangesPreview.saveJson('question-type', 'textarea');
            } else {
                $('[data-nav-id="long_text"]').removeClass('active');
                SaveChangesPreview.saveJson('question-type', 'text');
            }
        });
    }
};


var initSelect = {

    getTcpaMessages: function () {
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        let tcpaMessages = [];
        $.each(funnel_info.tcpa_messages, function( index, value ) {
            tcpaMessages[index] = value;
            tcpaMessages[index]['text'] = '<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>'+value['tcpa_title']+'</span></div>';
        });

        return tcpaMessages;
    },

    selectItems: {
        'alignment-icon-type' :[
            {
                id:0,
                text:'<div class="select2_style"><span class="select2js-placeholder">Icon positioning:</span><span>Left Align</span></div>',
                title: 'Left Align'
            },
            {
                id:1,
                text:'<div class="select2_style"><span class="select2js-placeholder">Icon positioning:</span><span>Right Align</span></div>',
                title: 'Right Align'
            }
        ],

        'security-message-type': [],

        'fb-select_unit' :[
            {
                id:'$',
                text:'<div class="select2_style">$</div>',
                title: '$'
            },
            {
                id:'%',
                text:'<div class="select2_style">%</div>',
                title: '%'
            },
            {
                id:'#',
                text:'<div class="select2_style">#</div>',
                title: '#'
            }
        ],

        'fb-select_by' :[
            {
                id:'subrange',
                text:'<div class="select2_style">By: Subranges</div>',
                title: 'By: Subranges'
            },
            {
                id:'increment',
                text:'<div class="select2_style">By: Increment</div>',
                title: 'By: Increment'
            }
        ],

        'fb-select_start' :[
            {
                id:0,
                text:'<div class="select2_style">Starting Number Ends with: 0</div>',
                title: '0'
            },
            {
                id:1,
                text:'<div class="select2_style">Starting Number Ends with: 1</div>',
                title: '1'
            }
        ]
    },

    /**
     * select2 rendering selection
     * if wee need to add select2 on any select dropdown so, we will pass the select option class/id and parent class/id
     */
    overlay_select_list : [
        {selecter:".alignment-icon-type", parent:".alignment-icon-parent"},
        {selecter:".security-message-type", parent:".security-message-parent"},
        {selecter:".fb-select_unit", parent:".select-unit"},
        {selecter:".fb-select_by", parent:".select-by"},
        {selecter:".fb-select_start", parent:".select-start"},
        {selecter:".fb-select_unit-1", parent:".select-unit-1"},
        {selecter:".fb-select_by-1", parent:".select-by-1"},
        {selecter:".fb-select_start-1", parent:".select-start-1"}
    ],

    /*
   ** custom select loop
   **/
    allCustomSelect: function (){
        var selectlist = this.overlay_select_list;
        for(var i = 0; i < selectlist.length; i++){
            this.initCustomSelect(selectlist[i].selecter,selectlist[i].parent);
        }
    },

    /*
  ** custom select
  **/

    /*
     ** init custom select
      **/

   initCustomSelect: function (selecter,parent) {
        var amIclosing = false;
        var _selector = jQuery(selecter);
        var _parent = jQuery(parent);
        var selectorClass = selecter.replace(/[#.]/g,'');
        if(selectorClass === 'fb-select_unit-1'){
            selectorClass = 'fb-select_unit';
        } else if(selectorClass === 'fb-select_by-1'){
            selectorClass = 'fb-select_by';
        }
        else if(selectorClass === 'fb-select_start-1'){
            selectorClass = 'fb-select_start';
        }
        _selector.select2({
            data: this.selectItems[selectorClass] ? this.selectItems[selectorClass] : window.selectItems[selectorClass],
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(parent),
            width: '100%',
            templateResult: function (d) {
                return $(d.text);
            },
            templateSelection: function (d) {
                return $(d.text);
            }

            /*
            ** Triggered before the drop-down is opened.
            */
        }).on('select2:opening', function() {
            $(this).parent().find('.select2-selection__rendered').css('opacity', '0');

            /*
            ** Triggered whenever the drop-down is opened.
            ** select2:opening is fired before this and can be prevented.
            */
        }).on('select2:open', function() {
            var _self = jQuery(this);
            var _selectoptions = _parent.find('.select2-results__options');
            var _selectdropdown = _parent.find('.select2-dropdown');

            _selectoptions.css('pointer-events', 'none');

            setTimeout(function() {
                _selectoptions.css('pointer-events', 'auto');
            }, 300);

            setTimeout(function() {
                _selectdropdown.hide();
                _selectdropdown.css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
                _parent.find('.select2-selection__rendered').hide();
            }, 50);
            lpUtilities.niceScroll();
            setTimeout(function () {
                _parent.find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                    var getindex = _selector.find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 100);

            /*
            ** Triggered before the drop-down is closed.
            */

        }).on('select2:select', function(e) {
            SaveChangesPreview.saveQuestion(e, 'select');

        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;

                _parent.find('.select2-dropdown').attr('style', '');

                setTimeout(function () {
                    _selector.select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }

            /*
            ** Triggered whenever the drop-down is closed.
            ** select2:closing is fired before this and can be prevented.
            */

        }).on('select2:close', function() {
            _parent.find('.select2-selection__rendered').show();
            _parent.find('.select2-selection__rendered').css('opacity', '1');
            _parent.find('.select2-results__options').css('pointer-events', 'none');
        });
       let selectedValue = _selector.attr('data-value');
       if(typeof selectedValue !== "undefined") {
           _selector.val(selectedValue).change();
       }
    }
};

/*
** Color Picker Function
**/
var colorPicker = {
    color_picker_clicked: false,
    init: function() {
        this.color_picker();
        // lpUtilities.color_picker_dropdown();
    },

    color_picker: function () {
        $('[button-icon-color]').ColorPicker({
            opacity: true,
            flat: true,
            auto_show: false,
            onChange: function (hsb, hex, rgb, rgba) {
                console.trace();
                let rgba_fn = lpUtilities.getRGBAString(rgba);
                $("[data-color-dropdown] .color-box__hex-block").val('#' + hex);
                $('[button-icon-color]').find('.last-selected__box').css('backgroundColor', rgba_fn);
                $('[button-icon-color]').find('.last-selected__code').text('#' + hex);
                $('[button-icon-color]').find('.custom-color-value').val(rgba_fn);
                $('.cta-btn .icon').css('color', rgba_fn);
                SaveChangesPreview.saveQuestion('', 'color-picker');
            },
            onShow: function () {
              $('.questions-button-color-picker').addClass('color-picker-active');
            },
            onHide: function () {
              $('.questions-button-color-picker').removeClass('color-picker-active');
            },
        });
    },
};

/*
** Reset Menu options Function
**/
var resetOptions = {

    init: function (){
        this.resetText();
        this.resetDefaultUniqueVariable();
        this.contentUniqueVariableReset();
        this.enableSaveButton();
    },

    enableSaveButton: function (){
        $('[data-content-number-format]').change(function (){
            $('[data-phone-settings-save]').attr('disabled',false)
        })
    },

    resetDefaultUniqueVariable: function (){
        $(document).on('click',"a.btn-unique-variable",function (e){
            e.preventDefault();
            const current_val = $('.unique-variable-text').val();
            const current_id = window.current_question_id;
            let value = sessionStorage.getItem("unique_variable")
            if (value === "NEW"){
                value = $(this).data('value')
            }
            if (window.question_type === 'vehicle'){
                value = FunnelsUtil.tabStep === 0 ? `make_${current_id}` : `model_${current_id}`
            }
            $("input.unique-variable-text").val(value)
            if (current_val !== value){
                $(".unique-variable-text").trigger("input");
            }
        })
    },

    contentUniqueVariableReset: function (){
        $('[data-btn-unique-variable]').click(function (){
            const default_val = $(this).data("default");
            let value = sessionStorage.getItem("unique_variable")
            let step = '1';
            let select_step = $('select[name="edit-content-step3"]');
            if (select_step.is(':visible')){
                step = select_step.val()
            }
            if (value === "NEW"){
                value = $(this).data('value')
                $(this).prev('.fb-form__group').children('input').val(value)
            }else {
                $(this).prev('.fb-form__group').children('input').val(`${default_val}${step}_${value}`)
            }
            $(this).prev('.fb-form__group').children('input').trigger('input');
        })
    },

    /**
     * Reset text on reset Button
     */
    resetText: function() {
        $(document).on('click','[data-reset]',function (event) {
            let fields = {},
                button_text,
                question_option,
                button_settings_field = "cta-button-settings",
                question_default_setting = hbar.getJson(question_type + ".json");

            if(question_type == 'contact') {
                let active_step = $('[data-id="active_step"]').val() - 1;
                let active_slide = $('[data-id="active_slide"]').val();
                question_option = question_default_setting['options']['all-step-types'][active_step]['steps'][active_slide];
                button_text = question_option["button-text"];
                fields["all-step-types." + active_step + ".steps." + active_slide + ".button-text"] = button_text;
                fields["all-step-types." + active_step + ".steps." + active_slide + "." + button_settings_field] = question_option[button_settings_field];
            } else {
                question_option = Object.assign({},question_default_setting['options']);
                if(question_type == 'vehicle') {
                    button_text = question_option["button-text"][FunnelsUtil.tabStep];
                    fields["button-text" + '.' + FunnelsUtil.tabStep] = button_text;
                    fields[button_settings_field + '.' + FunnelsUtil.tabStep] = question_option[button_settings_field][FunnelsUtil.tabStep];
                    //assigning single
                    question_option[button_settings_field] = question_option[button_settings_field][FunnelsUtil.tabStep];
                }else if(question_type == 'ctamessage'){
                    button_text = question_option["button-text"];
                    fields["button-text"] = button_text;
                    fields[button_settings_field] = question_option[button_settings_field];
                    $('.cta-link-text').val(question_option[button_settings_field]['link-destination']).trigger('change');
                    $(".outside-url-slide").slideUp();
                    $(".select-funnel-slide").slideUp();
                    $(".outside-url-field input").val(question_option[button_settings_field]['outside-url']);
                    $(".open-url-checkbox input").prop('checked',false);
                    $(".select-funnel-slide span").text(question_option[button_settings_field]['leadpops-funnel-name']);
                    $(".select-funnel-slide .select-funnel-opener").attr('data-domain-id','');
                    $(".select-funnel-slide .select-funnel-opener").removeClass('selected');
                }
                else {
                    button_text = question_option["button-text"];
                    fields["button-text"] = button_text;
                    fields[button_settings_field] = question_option[button_settings_field];
                }
            }

            //button text
            jQuery('[data-field-name="button-text"]').val(button_text);


            //button icon setting enable/disable
            if (question_option['cta-button-settings']['enable-button-icon'] == 0) {
                jQuery('[data-icon-opener]').prop("checked", false).trigger('change');
            } else {
                jQuery('[data-icon-opener]').prop("checked", true).trigger('change');
            }

            //button font size
            jQuery('[data-silder-value]').val(question_option['cta-button-settings']['font-size']);
            jQuery('[data-silder-ranger]').bootstrapSlider('setValue', question_option['cta-button-settings']['font-size']);
            // SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName: "data-silder-value"});

            //button icon set
            let button_icon = question_option['cta-button-settings']['button-icon'];
            let button_icon_name = InputControls.obj_fontawsome[button_icon];
            jQuery('[data-text-icon] .icon-wrap > i').removeClass().addClass('ico-' + button_icon);
            jQuery('[data-text-icon] .text-icon-wrap .text-icon').html(button_icon_name);
            // SaveChangesPreview.saveQuestion('', 'add-icon');

            //button icon color set
            jQuery('[button-icon-color]').ColorPickerSetColor(question_option['cta-button-settings']['button-icon-color']);
            // SaveChangesPreview.saveQuestion('', 'color-picker');

            //button icon position set
            let button_icon_position = question_option['cta-button-settings']['button-icon-position'];
            let button_icon_position_val = FunnelsUtil.getKeyByValue(Constants.BUTTON_ICON_POSITION, button_icon_position);
            jQuery("[data-field-name='cta-button-settings.button-icon-position']").val(button_icon_position_val).trigger('change');
            // event.target.dataset.fieldName = 'cta-button-settings.button-icon-position';
            // event.target.value = button_icon_position_val;
            // SaveChangesPreview.saveQuestion(event, 'select');

            //button icon font size set
            jQuery('[data-slider-icon]').val(question_option['cta-button-settings']['button-icon-size']);
            jQuery('[data-silder-ranger-icon]').bootstrapSlider('setValue', question_option['cta-button-settings']['button-icon-size']);
            // SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName: "data-slider-icon"});
            jQuery('[data-icon-slide]').addClass('slider-disabled');
            jQuery('[data-lock-slider]').addClass('selected');

            //button hide/show setting until answer
            if($('[data-field-name="cta-button-settings.enable-hide-until-answer"]').prop('checked')==true)
            {
                jQuery('[data-field-name="cta-button-settings.enable-hide-until-answer"]').click();
            }
            SaveChangesPreview.saveJsonObject(fields);
        });
    }
};

// it will work for menu question
var multiOptions = {
    iframeSwtich: 1,
    shiftkey: false,

    /**
     * This will remove duplicate option when OTHER/NONE option added
     */
    handleDuplicatedOption: function(field) {
        let currentOptions = this.getOptionsExculingCurrent(field),
            optionValue = jQuery.trim(field.val());
        if(currentOptions.indexOf(optionValue.toLowerCase()) !== -1) {
            let duplicateOption = $('[data-menu-options]').filter(function() {
                return jQuery.trim(jQuery(this).val()).toLowerCase() == optionValue.toLowerCase();
            });

            if(duplicateOption.length) {
                this.showDuplicateWarning(duplicateOption);
            }
        }
    },

    /**
     * Only used for option duplication logic
     * @returns {*|jQuery}
     */
    getOptionsExculingCurrent: function($this){
        return $('[data-menu-options]').map((i,el) => ($this !== el && jQuery.trim(el.value) != '')?jQuery.trim(el.value).toLowerCase():null).toArray();
    },

    /**
     * get options excluding error
     * @param $this
     * @returns {*|jQuery}
     */
    getOptions: function(){
        return $('[data-menu-options]').map((i,el) => (!jQuery(el).hasClass("error") && jQuery.trim(el.value) != '' && !jQuery(el).parents('.fb-options__list').hasClass('question-hide'))?jQuery.trim(el.value):null).toArray();
    },

    /**
     * Show duplicate warning
     * @param $this
     */
    showDuplicateWarning: function($this){
        displayAlert('warning', 'You have added duplicate entry.');
        jQuery($this).removeClass("error").addClass('error').focus();
        jQuery($this).parents('.fb-options__list').addClass('empty-field');
    },

    /**
     * Tab key handling for options text field for menu and dropdown question
     */
    tabKey: function () {
        $('.form-control').off('keydown').on('keydown', function (e) {
            if (!multiOptions.shiftkey && e.which == 9) { // tabKey Pressed
                e.preventDefault();
                let elem = $(this).parents('.fb-options__list').next('.fb-options__list:not(.question-hide)').find('.form-control');

                if (elem.length != 0) {
                    elem.select();
                } else {
                    $('.lp-btn_add-option').focus();
                }
            }
            else if (multiOptions.shiftkey && e.which == 9) {   // ShiftKey + tabKey Pressed
                e.preventDefault();
                let elem = $(this).parents('.fb-options__list').prev('.fb-options__list:not(.question-hide)').find('.form-control');

                if (elem.length != 0) {
                    elem.select();
                }
            }
            else if (!multiOptions.shiftkey && e.which == 16) { //ShiftKey Pressed
                e.preventDefault();
                multiOptions.shiftkey = true;
            }
        });

        $('.form-control').off('keyup').on('keyup', function (e) {
            if (e.which == 16) { // ShiftKey Pressed
                e.preventDefault();
                multiOptions.shiftkey = false
            }
        });
    },

    /**
     *  Clone menu option and append
     */
    cloneOption: function (_this){
        var cloned = $('.clone-option').clone();
        cloned.removeClass("question-hide clone-option").addClass('empty-field');
        let optionLength = $('.empty-field').length;
            cloned.find('.clear-btn').removeClass('question-hide');
            cloned.find('input').attr('data-menu-options',true).val('');
             if(optionLength == 0) {
                 if(typeof _this === "undefined") {
                     $('.fb-options__clone .clone-option').before(cloned);
                 }
                 else {
                     $(_this).parents('.fb-options__list').after(cloned);
                 }
                 cloned.find('input').focus();
             }
             else {
                     $('.empty-field').find('input').focus();
            }
        // tab key bind again
        jQuery('.form-control').unbind('keydown');
        multiOptions.tabKey();
        // disable delete/move
        multiOptions.toggleMoveDelete();
    },

    /**
     * Toggle (enable/disable) delete and move operation
     * @param toggle
     */
    toggleMoveDelete: function () {
        let remaining_opts = multiOptions.getFieldsLength();

        if (remaining_opts < 2) {
            $('.fb-options').find('.fb-options__list:not(.empty-field, .question-hide, .none, .other)').addClass('not-allowed');
            //$("[data-option-sort], .dropdown-option-list").sortable('disable');
            $("[data-option-sort]").sortable('disable');
        } else {
            $('.fb-options').find('.fb-options__list').removeClass('not-allowed');
            $("[data-option-sort]").sortable('enable');
        }
    },

    /**
     * Get fields length from local storage
     * @returns number
     */
    getFieldsLength: function () {
        //return $('[data-menu-options]').length;
        return $(".fb-options__list:not(.empty-field, .question-hide, .none, .other)").find("[data-menu-options]").length;
    },

    dropDownPreview: function (){
        let funnelOverlay = jQuery('.funnel-overlay');
        if(funnelOverlay.hasClass('funnel-menu-overlay') || funnelOverlay.hasClass('funnel-dropdown-overlay')) {
            let questionKey = $('[data-id="ques_id"]').val(),
                currentQuestion = this.getCurrentQuestion(questionKey),
                activeOptions = currentQuestion["options"].fields.length;

            if (currentQuestion["question-type"] == "menu" && activeOptions > 8) {
                jQuery(".funnel-iframe-holder iframe").attr('src', site.baseUrl + '/previewbars/dropdown-preview.php?ques_id=' + jQuery('[data-id="ques_id"]').val() + '&ls_key=' + FunnelsUtil.ls_key);
                //converting menu question to dropdown
                menuToDropdown.saveConvertedQuestion(questionKey, "dropdown");
            } else if (menuToDropdown.isConverted(questionKey) && activeOptions < 9) {
                jQuery(".funnel-iframe-holder iframe").attr('src', site.baseUrl + '/previewbars/menu-preview.php?ques_id=' + jQuery('[data-id="ques_id"]').val() + '&ls_key=' + FunnelsUtil.ls_key);
                //converting back to menu question
                menuToDropdown.saveConvertedQuestion(questionKey, "menu");
            }
        }
    },

    /**
     * Get active options
     * @returns {number}
     */
    getActiveOptions: function() {
        let options = jQuery('[data-menu-options]');
        let count = 0;
        options.each(function () {
            if ($( this ).val().trim() != '') {
                count++;
            }
        });

        return count;
    },

    /**
     * get current opened question from local storage
     * @param key
     * @returns {*}
     */
    getCurrentQuestion: function(key = undefined) {
        key = key !== undefined ? key : $('[data-id="ques_id"]').val();
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        return funnel_info.questions[key];
    },

    optionsValueChecker: function (_this){
        let findValue = jQuery.grep($('[data-menu-options]:visible'), function (el, i) {
                if (el.value) {
                    return $.trim(el.value.toLowerCase()) == $.trim($(_this).val().toLowerCase());
                }
            });
            return findValue;
    },

    init: function (){
        multiOptions.tabKey();
        //add new option add in menu question when click on add new option button
        $('.lp-btn_add-option').once('click', function(e){
            e.preventDefault();
            multiOptions.cloneOption();
        });

        //sort menu option
        $("[data-option-sort]").sortable({
            handle: ".fb-options__col_handler",
            tolerance: "pointer",
            update: function (event, ui) {
                SaveChangesPreview.saveQuestion(event, 'multiOption');
            }
        });

        //sort dropdown option
        $('.dropdown-option-list').sortable({
            scroll: true,
            axis: "y",
            handle: ".drag-row",
            update: function (event, ui) {
                SaveChangesPreview.saveQuestion(event, 'multiOption');
            }
        });

        //remove dropdown and menu option
        $(document).off('click' , '.fb-options__delete').on('click' , '.fb-options__delete',function (event) {
            event.preventDefault();
            let _self = this;
            if($(_self).parents('[data-question-none]').length === 1){
                jQuery("[data-none-field]").find('[data-include-option]').prop('checked',false).trigger("change");
                jQuery(".question-none").val(jQuery(".question-none").data('value'));
            }
            else if($(_self).parents('[data-question-other]').length === 1){
                jQuery("[data-field-name='add-other-option']").prop('checked',false).trigger("change");
                jQuery(".question-other").val(jQuery(".question-other").data('value'));
            }
            else{
                $(_self).parents('.fb-options__list').remove();
            }

            // disable delete/move
            multiOptions.toggleMoveDelete();
            // save changes
            SaveChangesPreview.saveQuestion(event, 'multiOption');
            // preview change menu and dropdown according to options list
            multiOptions.dropDownPreview();
        });

        jQuery(document).off('paste','.fb-options__list').on('paste','.fb-options__list', function (event) {
            if($(this).find('input').hasClass('dropdown-option-clone')) {
                event.stopPropagation();
                event.preventDefault();

                var pasted_str = event.originalEvent.clipboardData.getData("text/plain")
                var inputs = [];
                $.each(pasted_str.split("\n"), function (i, el) {
                    if ($.inArray(el, inputs) === -1) inputs.push(el);
                });
                console.log(inputs);

                let elem = $(this);
                jQuery.each(inputs, function (index, value) {
                    if (index === 0) {
                        elem.removeClass('empty-field');
                        elem.find('input').attr('data-menu-options', true).val(value);
                    } else {
                        let cloned = $('.clone-option').clone();
                        cloned.removeClass("question-hide clone-option");
                        cloned.find('.clear-btn').removeClass('question-hide');
                        cloned.find('input').attr('data-menu-options', true).val(value);
                        elem.after(cloned);
                        elem = cloned;
                    }
                });

                jQuery('.form-control').unbind('keydown');
                multiOptions.toggleMoveDelete();
                SaveChangesPreview.saveQuestion(event, 'multiOption');

                jQuery('.dropdown-option-list-holder').mCustomScrollbar('destroy');
                if(jQuery('.dropdown-option-list-holder').length > 0) {
                    jQuery('.dropdown-option-list-holder').mCustomScrollbar({
                        axis: "y",
                    });
                    setTimeout(function(){
                        jQuery('.dropdown-option-list-holder').mCustomScrollbar("scrollTo","bottom",{
                            scrollInertia: 500
                        });
                    }, 1);
                    setTimeout(function(){
                        // find last element
                        let lastElement = elem.nextAll('.fb-options__list:not(.question-hide):last');
                        let useElement = lastElement.length != 0 ? lastElement : elem;
                        var tmp = useElement.find('input').val();
                        useElement.find('input').focus().val("").blur().focus().val(tmp);
                    }, 50);
                }
            }
        });

        //dropdown and menu add new option,duplicate and write the text
        jQuery(document).off('keyup input','[data-menu-options]').on('keyup input','[data-menu-options]', FunnelsUtil.debounce(function (event) {
            var this_val = jQuery(this).val();
            this_val = this_val.charAt(0).toUpperCase() + this_val.slice(1)
            $(this).val(this_val);
            var keycode = (event.keyCode ?event.keyCode : event.which),
                optionValue = jQuery.trim(jQuery(this).val());

            if(keycode === 13){
                if (optionValue != '') {
                    let currentOptions = multiOptions.getOptionsExculingCurrent(this);
                    if(currentOptions.indexOf(optionValue.toLowerCase()) === -1) {
                        if ($(this).hasClass('dropdown-option-clone')) {
                            multiOptions.cloneOption(this);
                        } else {
                            multiOptions.cloneOption();
                        }
                    } else {
                        multiOptions.showDuplicateWarning(this);
                    }
                }
            }
            else {
                let result = multiOptions.optionsValueChecker(this);
                if (result == "" || result.length == 1) {
                    jQuery(this).removeClass('error');
                    if (optionValue) {
                        jQuery(this).parents('.fb-options__list').removeClass('empty-field');
                    } else {
                        jQuery(this).parents('.fb-options__list').addClass('empty-field');
                    }
                    // disable delete/move
                    multiOptions.toggleMoveDelete();
                    multiOptions.extraOptions(this,event);
                } else {
                    multiOptions.showDuplicateWarning(this);
                }
                SaveChangesPreview.saveQuestion(event, 'multiOption');
                multiOptions.dropDownPreview();
            }
        }, 50));

        //dropdown and menu none and other option handle
        jQuery('[data-include-option]').once('change',function (event){
            SaveChangesPreview.saveQuestion(event);
            if(event.target.value.toLowerCase() == 'none') {
                if(event.target.checked ) {
                    let noneField = $('[data-option-sort]').find('[data-question-none]')[0],
                        noneInputField = jQuery(".question-none");
                    multiOptions.handleDuplicatedOption(noneInputField);
                    noneInputField.val(noneInputField.data('value'));
                    let result = multiOptions.optionsValueChecker(noneInputField);
                    //if add none field then we will replace the default none field
                    let duplicateNoneField = jQuery(result).parents('.fb-options__list')[0];
                    jQuery(duplicateNoneField).html(noneField);
                    jQuery("[data-question-none]").removeClass('question-hide').find('input').attr('data-menu-options',true);
                    console.log("none -> ", noneField, result, duplicateNoneField);
                }
                else {
                    $("[ data-extra-option-none]").remove();
                    $("[data-question-none]").addClass('question-hide').find('input').removeAttr('data-menu-options');
                }
            }
            else if(event.target.value.toLowerCase() == 'other') {
                if(event.target.checked ) {
                   let otherField = $('[data-option-sort]').find('[data-question-other]')[0],
                       otherInputField = jQuery(".question-other");
                    multiOptions.handleDuplicatedOption(otherInputField);
                    otherInputField.val(otherInputField.data('value'));
                    let result = multiOptions.optionsValueChecker(otherInputField);
                    //if add other field then we will replace the default other field
                    let duplicateOtherField = jQuery(result).parents('.fb-options__list')[0];
                    jQuery(duplicateOtherField).html(otherField);
                    $("[ data-question-other]").removeClass('question-hide').find('input').attr('data-menu-options',true);
                }
                else {
                    $("[ data-extra-option-other]").remove();
                    $("[ data-question-other]").addClass('question-hide').find('input').removeAttr('data-menu-options');
                }
            }

            SaveChangesPreview.saveQuestion(event, 'multiOption');
            // disable delete/move
            multiOptions.toggleMoveDelete();
            // check menu and dropdown preview
            multiOptions.dropDownPreview();
        });

        //dropdown and menu option value reset
        jQuery(document).off('click','.clear-btn').on('click','.clear-btn',function (event){
            jQuery(this).parents('.fb-options__list').find('.fb-form-control').val('').focus();
            jQuery(this).parents('.fb-options__list').addClass('empty-field');
            SaveChangesPreview.saveQuestion(event, 'multiOption');
            // disable delete/move
            multiOptions.toggleMoveDelete();
            // check menu and dropdown preview
            multiOptions.dropDownPreview();
        });
    },

    extraOptions: function (_this,event){
        if ($("[data-none-field]").find('[data-include-option]').is(':checked') && $(_this).hasClass('question-none')) {
            event.target.dataset.fieldName = 'extra_options.none';
            event.target.value = $("[data-question-none]:visible").find('input').val();
            $("[data-question-none].question-hide").find('input').attr('value',event.target.value);
            $("[data-question-none].question-hide").find('input').attr('data-value',event.target.value);
            SaveChangesPreview.saveQuestion(event, 'text');
        }
        if ($("[data-other-field]").find('[data-include-option]').is(':checked') && $(_this).hasClass('question-other')) {
            event.target.dataset.fieldName = 'extra_options.other';
            event.target.value = $("[data-question-other]:visible").find('input').val();
            $("[data-question-other].question-hide").find('input').attr('value',event.target.value);
            $("[data-question-other].question-hide").find('input').attr('data-value',event.target.value);
            SaveChangesPreview.saveQuestion(event, 'text');
        }
    },
};

// zipcode left panel preview handle
var zipCodeHanlder = {

    zipcodePreviewHandler: function (event){
    if(event.target.dataset.fieldName == 'zip-code-only'){
            if(event.target.checked){
                event.target.dataset.fieldName = 'city-or-zip-code';
                event.target.value = 0;
                SaveChangesPreview.saveQuestion(event,'text');
                event.target.dataset.fieldName = 'field-label';
                event.target.value = 'Zip Code';
                SaveChangesPreview.saveQuestion(event,'text');
                jQuery("[data-automatic-progress-option]").find('[data-opener-checkbox]').prop('checked', false).trigger("change");
                jQuery("[required-zip-code-field]").removeClass('question-hide');
                jQuery("[cannadian-postal-code-field]").removeClass('question-hide');
                jQuery("[data-automatic-progress-option]").addClass('question-hide');
            }
            event.target.dataset.fieldName = 'zip-code-only';
        }
        else if(event.target.dataset.fieldName == 'city-or-zip-code'){
            if(event.target.checked){
                event.target.dataset.fieldName = 'zip-code-only';
                event.target.value = 0;
                SaveChangesPreview.saveQuestion(event,'text');
                event.target.dataset.fieldName = 'field-label';
                event.target.value = 'CITY OR ZIP CODE';
                SaveChangesPreview.saveQuestion(event,'text');
                jQuery("[data-automatic-progress-option]").removeClass('question-hide');
                jQuery("[cannadian-postal-code-field]").addClass('question-hide');
                jQuery("[required-zip-code-field]").addClass('question-hide');
                jQuery("[data-automatic-progress-option]").find('[data-opener-checkbox]').prop('checked', false).trigger("change");
            }
            event.target.dataset.fieldName = 'city-or-zip-code';
        }
        $(".label-field").val(event.target.value);
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        funnel_info.question_value = '';
        FunnelsUtil.saveFunnelData(funnel_info);
    }
};

var vehicleHanler = {
    init: function (){
        let $self = this;
        $(document).on('click','.vehicle-tab-link',function () {
            if($(this).hasClass('active') == false) {
                let timeout;
                $('.vehicle-tab-link').removeClass('active');
                $(this).addClass('active');
                let questionType = 'vehicle';
                if ($(this).hasClass('vehicle-make')) {
                    $('.tab-content').removeClass('vehicle-model-active').addClass('vehicle-make-active');
                    FunnelsUtil.tabStep = 0;
                } else {
                    $('.tab-content').removeClass('vehicle-make-active').addClass('vehicle-model-active');
                    FunnelsUtil.tabStep = 1;
                }
                FunnelsUtil.refreshVehicleIframePreview();
                vehicleHanler.vehicleReInitializeFunctions();
                InputControls.openclose();
            }
        });
        vehicleHanler.vehicleReInitializeFunctions();
    },
    renderTemplate: function (){
        let questionId = $('[data-id="ques_id"]').val();
        let currentQuestion =FunnelsBuilder.setQuestionOptions(questionId);
        hbar.renderTemplate('vehicle-form.hbs', "vehicleForm", currentQuestion);
        FBEditor.init();
    },
    vehicleTabActive: function (){
        if(FunnelsUtil.tabStep == 1){
            $(".vehicle-model").addClass('active');
            $('.tab-content').removeClass('vehicle-make-active').addClass('vehicle-model-active');
        }
        else{
            $(".vehicle-make").addClass('active');
            $('.tab-content').removeClass('vehicle-model-active').addClass('vehicle-make-active');
        }
    },
    vehicleReInitializeFunctions: function (){
        vehicleHanler.renderTemplate();
        vehicleHanler.vehicleTabActive();
        InputControls.customScroll();
        InputControls.rangeBar();
        InputControls.tooltip();
        InputControls.securityMessage();
        InputControls.populateAddEditSecurityMessage();
        InputControls.saveSecurityMessageDB();
        InputControls.addClassClick();
        colorPicker.init();
    },
}

/**
 * set cursor position in input and froala editor
 */
$.fn.setCursorPosition = function (element) {
    let $this = pos = '';
    if(element === 'froala'){
        // Selects the contenteditable element. You may have to change the selector.
        $this = document.querySelector(".fb-froala.focus .fr-view");
        // Selects the last and the deepest child of the element.
        if($this) {
            while ($this.lastChild) {
                $this = $this.lastChild;
            }
            // Gets length of the element's content.
            pos = $this.textContent.length;
            var range = document.createRange();
            var selection = window.getSelection();
            // Sets selection position to the end of the element.
            range.setStart($this, pos);
            range.setEnd($this, pos);
            // Removes other selection ranges.
            selection.removeAllRanges();
            // Adds the range to the selection.
            selection.addRange(range);
        }
    }
    else {
    $this = jQuery(element).closest('[data-parent]').find('.form-control')[0];
    jQuery($this).focus();
    pos = jQuery($this).val().length;
        if ($this.setSelectionRange) {
            $this.setSelectionRange(pos, pos);
        }
        else if ($this.createTextRange) {
            var range = $this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }
    return $this;
};

/*
** Integration Modal Shown Function
**/
function integration_modal_shown() {
    if (jQuery("body").hasClass('integrations-active')) {
        jQuery('#integration-active-modal').modal('show');
    }
    else {
        jQuery('#integration-active-modal').modal('hide');
    }
}

jQuery(window).load(function() {
    integration_modal_shown();
});
