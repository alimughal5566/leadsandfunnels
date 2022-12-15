var customFroalaPhoneNumber = {
    init: function(){
        // Define popup template.
        $.extend($.FroalaEditor.POPUP_TEMPLATES, {
            key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
            "phonePlugin.popup": '[_PHONE_BUTTONS_][_PHONE_LAYER_]'
        });
        // Define popup buttons.
        $.extend($.FroalaEditor.DEFAULTS, {
            popupButtonphone: ['phonepopupClose']
        });
        $.FroalaEditor.PLUGINS.phonePlugin = function (editor) {
            // Create custom popup.
            function initPopup () {
                // Popup buttons.
                var popup_button_phone = '';

                // Create the list of buttons.
                if (editor.opts.popupButtonphone.length >= 1) {
                    popup_button_phone += '<div class="fr-buttons">';
                    popup_button_phone += editor.button.buildList(editor.opts.popupButtonphone);
                    popup_button_phone += '</div>';
                }

                // Load popup template.
                var template = {
                    phone_buttons: popup_button_phone,
                    phone_layer: '<div class="fr-link-insert-layer fr-layer fr-active" id="fr-link-insert-layer-phone">\n' +
                    '                   <div class="fr-input-line">\n' +
                    '                       <input id="fr-link-insert-layer-url-phone"  type="text"  placeholder="Phone Number">\n' +
                    '                   </div>\n' +
                    '                   <div class="fr-link-insert-error">\n' +
                    '                   Please enter a valid phone number.' +
                    '                   </div>\n' +
                    '                   <div class="fr-input-line">\n' +
                    '                       <input id="fr-link-insert-layer-text"  type="text" placeholder="Label">\n' +
                    '                   </div>\n' +
                    '                   <div class="fr-action-buttons">\n' +
                    '                       <button class="fr-command fr-submit__number">Insert Phone Number</button>\n' +
                    '                   </div>\n'+
                    '               </div>'
                };

                $("#fr-link-insert-layer-url-phone").inputmask({"mask": "(999) 999-9999"});

                // Create popup.
                var $popup = editor.popups.create('phonePlugin.popup', template);

                return $popup;
            }

            // Show the popup
            function showPopup () {
                // Get the popup object defined above.
                var $popup = editor.popups.get('phonePlugin.popup');

                // If popup doesn't exist then create it.
                // To improve performance it is best to create the popup when it is first needed
                // and not when the editor is initialized.
                if (!$popup) $popup = initPopup();

                // Set the editor toolbar as the popup's container.
                editor.popups.setContainer('phonePlugin.popup', editor.$tb);

                // This will trigger the refresh event assigned to the popup.
                // editor.popups.refresh('customPlugin.popup');

                // This custom popup is opened by pressing a button from the editor's toolbar.
                // Get the button's object in order to place the popup relative to it.
                var $btn = $("[data-cmd='phone']");

                // Set the popup's position.

                var left = $btn.offset().left + 20;
                var top = $btn.offset().top  - 65;


                // Show the custom popup.
                // The button's outerHeight is required in case the popup needs to be displayed above it.
                editor.popups.show('phonePlugin.popup', left, top, $btn.outerHeight());
            }

            // Hide the custom popup.
            function hidePopup () {
                editor.popups.hide('phonePlugin.popup');
            }

            // Methods visible outside the plugin.
            return {
                showPopup: showPopup,
                hidePopup: hidePopup
            }
        };
        // Define custom popup close button icon and command.
        $.FroalaEditor.DefineIcon('phonepopupClose', { NAME: 'arrow-left' });
        $.FroalaEditor.RegisterCommand('phonepopupClose', {
            title: 'Close',
            undo: false,
            focus: true,
            callback: function () {
                this.phonePlugin.hidePopup();
            }
        });


        // Update Phone Number POP
        // Define popup template.
        $.extend($.FroalaEditor.POPUP_TEMPLATES, {
            key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
            "editphonePlugin.popup": '[_EDITPHONE_BUTTONS_][_EDITPHONE_LAYER_]'
        });
        // Define popup buttons.
        $.extend($.FroalaEditor.DEFAULTS, {
            popupButtonphoneedit: ['editphonepopupClose']
        });
        $.FroalaEditor.PLUGINS.editphonePlugin = function (editor) {
            // Create custom popup.
            function initPopup () {
                // Popup buttons.
                var popup_button_phoneedit = '';

                // Create the list of buttons.
                if (editor.opts.popupButtonphoneedit.length >= 1) {
                    popup_button_phoneedit += '<div class="fr-buttons">';
                    popup_button_phoneedit += editor.button.buildList(editor.opts.popupButtonphoneedit);
                    popup_button_phoneedit += '</div>';
                }

                // Load popup template.
                var template = {
                    editphone_buttons: popup_button_phoneedit,
                    editphone_layer: '<div class="fr-link-edit-layer fr-layer fr-active" id="fr-link-edit-layer-phone">\n' +
                    '                   <div class="fr-input-line">\n' +
                    '                       <input id="fr-link-edit-layer-url-phone"  type="text"  placeholder="Phone Number">\n' +
                    '                   </div>\n' +
                    '                   <div class="fr-link-edit-error">\n' +
                    '                   Please enter a valid phone number.' +
                    '                   </div>\n' +
                    '                   <div class="fr-input-line">\n' +
                    '                       <input id="fr-link-edit-layer-text"  type="text" placeholder="Label">\n' +
                    '                   </div>\n' +
                    '                   <div class="fr-action-buttons">\n' +
                    '                       <button class="fr-command fr-update__number">Update Phone Number</button>\n' +
                    '                   </div>\n'+
                    '               </div>'
                };

                $("#fr-link-insert-layer-url-phone").inputmask({"mask": "(999) 999-9999"});

                // Create popup.
                var $popup = editor.popups.create('editphonePlugin.popup', template);

                return $popup;
            }

            // Show the popup
            function showPopup () {
                // Get the popup object defined above.
                var $popup = editor.popups.get('editphonePlugin.popup');

                // If popup doesn't exist then create it.
                // To improve performance it is best to create the popup when it is first needed
                // and not when the editor is initialized.
                if (!$popup) $popup = initPopup();

                // Set the editor toolbar as the popup's container.
                editor.popups.setContainer('editphonePlugin.popup', editor.$tb);


                // This will trigger the refresh event assigned to the popup.
                // editor.popups.refresh('customPlugin.popup');

                // This custom popup is opened by pressing a button from the editor's toolbar.
                // Get the button's object in order to place the popup relative to it.
                var $btn = $("[data-cmd='phoneEdit']");

                // Set the popup's position.

                var left = $btn.offset().left;
                var top = $btn.offset().top - 20;

                // Show the custom popup.
                // The button's outerHeight is required in case the popup needs to be displayed above it.
                editor.popups.show('editphonePlugin.popup', left, top, $btn.outerHeight());
            }

            // Hide the custom popup.
            function hidePopup () {
                editor.popups.hide('editphonePlugin.popup');
            }

            // Methods visible outside the plugin.
            return {
                showPopup: showPopup,
                hidePopup: hidePopup
            }
        };

        // Define custom popup close button icon and command.
        $.FroalaEditor.DefineIcon('editphonepopupClose', { NAME: 'arrow-left' });
        $.FroalaEditor.RegisterCommand('editphonepopupClose', {
            title: 'Close',
            undo: false,
            focus: true,
            callback: function () {
                this.editphonePlugin.hidePopup();
            }
        });

        $.FroalaEditor.DefineIcon('phone', {NAME: 'phone'});
        $.FroalaEditor.RegisterCommand('phone', {
            title: 'Insert Click-to-Call',
            focus: true,
            undo: true,
            refreshAfterCallback: true,
            callback: function (object) {
                var current  = this;
                let selectedHtml = $(".classic-editor__wrapper.focus .fb-froala__init .fr-view").html();
                var frtext = current.selection.text();
                current.phonePlugin.showPopup();
                $("#fr-link-insert-layer-url-phone").val('');
                $("#fr-link-insert-layer-text").val(frtext);
                $("#fr-link-insert-layer-url-phone").inputmask({"mask": "(999) 999-9999"});
                $(".fr-submit__number").off('click').click(function () {
                    if($("#fr-link-insert-layer-url-phone").val() != ""){
                        var phonenumber = $("#fr-link-insert-layer-url-phone").val();
                        phonenumber = phonenumber.replace(/\_/g, '');
                        if(phonenumber.length == 14){
                            $("#fr-link-insert-layer-phone").removeClass("fr-error");
                            var lbl_val = $("#fr-link-insert-layer-text").val();
                            if(frtext.trim() == ''){
                                current.link.insert('tel:'+phonenumber, lbl_val,{'class':'fb-phone-number'});
                            }else{
                                var new_cta_html =  selectedHtml.replace(frtext,'<a class="fb-phone-number" href="tel:'+phonenumber+'"><u>'+lbl_val+'</u></a>');
                                current.html.set(new_cta_html);
                            }
                            current.phonePlugin.hidePopup();
                        }else{
                            $("#fr-link-insert-layer-phone").addClass("fr-error");
                        }
                    }

                });
            },
            plugin: 'phonePlugin'

        });
        $.FroalaEditor.DefineIcon('phoneEdit', {NAME: 'phone'});
        $.FroalaEditor.RegisterCommand('phoneEdit', {
            title: 'Edit Phone Number',
            focus: true,
            undo: true,
            spellcheck: false,
            refreshAfterCallback: true,
            callback: function () {
                var current = this;
                let selectedHtml = $(".classic-editor__wrapper.focus .fb-froala__init .fr-view").html();
                var ele = $(".phone-active");
                var frtext = ele.text();
                var html = ele[0].outerHTML;
                var phone_number = decodeURIComponent(ele.attr('href'));
                current.editphonePlugin.showPopup();
                $("#fr-link-edit-layer-url-phone").inputmask({"mask": "(999) 999-9999"});
                $('#fr-link-edit-layer-url-phone').val(phone_number);
                $('#fr-link-edit-layer-text').val(frtext);
                $(".fr-update__number").off('click').click(function () {
                    if($("#fr-link-edit-layer-url-phone").val() != ""){
                        var phonenumber = $("#fr-link-edit-layer-url-phone").val();
                        phonenumber = phonenumber.replace(/\_/g, '');
                        if(phonenumber.length == 14){
                            var lbl_val = $("#fr-link-edit-layer-text").val();
                            var new_cta_html =  selectedHtml.replace(html,'<a class="fb-phone-number" href="tel:'+phonenumber+'">'+lbl_val+'</a>');
                            current.html.set(new_cta_html);
                            current.editphonePlugin.hidePopup();
                        }else{
                            /*
                            * error case
                            * */
                            $("#fr-link-edit-layer-phone").addClass("fr-error");
                        }
                    }
                });
            },
            plugin: 'editphonePlugin'
        });
    }
};
