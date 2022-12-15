/**
 * @author Muhammad Akram
 * @description Copyright 2022, All rights reserved @leadpops.com
 * Date created: 16 feb 2022
 */
(function (FroalaEditor) {
    Object.assign(FroalaEditor.POPUP_TEMPLATES, {
        'phone_number.insert': '[_PHONE_BUTTONS_][_PHONE_LAYER_]'
    });

    // Add an option for your plugin.
    FroalaEditor.DEFAULTS = Object.assign(FroalaEditor.DEFAULTS, {
        phoneNumberButtons: ['PhonePopupClose']
    });

    // Define the plugin.
    // The editor parameter is the current instance.
    FroalaEditor.PLUGINS.phoneNumber = function (editor) {
        // privater plugin variables
        var m = editor.$;

        // Private plugin functions
        function initPopup (e) {
            if (e) return editor.popups.onRefresh("phone_number.insert", o), !0;
            // Popup buttons.
            var popup_button_phone = '';

            // Create the list of buttons.
            if (editor.opts.phoneNumberButtons.length >= 1) {
                popup_button_phone += '<div class="fr-buttons">';
                popup_button_phone += editor.button.buildList(editor.opts.phoneNumberButtons);
                popup_button_phone += '</div>';
            }

            // Load popup template.
            var template = {
                phone_buttons: popup_button_phone,
                phone_layer: '<div class="fr-link-insert-layer fr-layer fr-active" id="fr-link-insert-layer-phone">\n' +
                    '                   <div class="fr-input-line">\n' +
                    '                       <input id="fr-link-insert-layer-url-phone" type="text" name="href" class="fr-link-attr"  placeholder="Phone Number">\n' +
                    '                   </div>\n' +
                    '                   <div class="fr-link-insert-error">\n' +
                    '                   Please enter a valid phone number.' +
                    '                   </div>\n' +
                    '                   <div class="fr-input-line">\n' +
                    '                       <input id="fr-link-insert-layer-text" type="text" name="text" class="fr-link-attr" placeholder="Label">\n' +
                    '                   </div>\n' +
                    '                   <div class="fr-action-buttons">\n' +
                    '                       <button class="fr-command fr-submit__number" role="button" data-cmd="PhoneNumberInsert" href="#">Insert Phone Number</button>\n' +
                    '                   </div>\n'+
                    '               </div>'
            };
            // Create popup.
            var $popup = editor.popups.create('phone_number.insert', template);
            editor.popups.onRefresh("phone_number.insert", o);
            return $popup;
        }

        /**
         * populate link data into popup if clicked on link
         */
        function o() {
            var e = editor.popups.get("phone_number.insert"),
                t = editor.link.get();
            if (t) {
                var n,
                    i,
                    r = m(t),
                    a = e.find('input.fr-link-attr[type="text"]');
                for (n = 0; n < a.length; n++) (i = m(a[n])).val(r.attr(i.attr("name") || ""));
                e.find('input.fr-link-attr[type="text"][name="text"]').val(r.text());
            } else {
                e.find('input.fr-link-attr[type="text"]').val("");
                e.find('input.fr-link-attr[type="text"][name="text"]').val(editor.selection.text());
            }
            jQuery('#fr-link-insert-layer-url-phone').inputmask({"mask": "(999) 999-9999"});
            e.find("input.fr-link-attr").trigger("change"), (editor.image ? editor.image.get() : null) ? e.find('.fr-link-attr[name="text"]').parent().hide() : e.find('.fr-link-attr[name="text"]').parent().show();
        }

        /**
         * open link into Edit phone number popup
         */
        function update() {
            hidePopup();
            var e = editor.link.get();
            if (e) {
                var t = editor.popups.get("phone_number.insert");
                t || (t = initPopup()),
                editor.popups.isVisible("phone_number.insert") || (editor.popups.refresh("phone_number.insert"), editor.selection.save(), editor.helpers.isMobile() && (editor.events.disableBlur(), editor.$el.blur(), editor.events.enableBlur())),
                    editor.popups.setContainer("phone_number.insert", editor.$sc);
                var n = (editor.image ? editor.image.get() : null) || m(e),
                    i = n.offset().left + n.outerWidth() / 2,
                    r = n.offset().top + n.outerHeight();
                editor.popups.show("phone_number.insert", i, r, n.outerHeight(), !0);
            }
        }

        /**
         * change popup position for phone number popup
         * @param editor
         */
        function showPopup() {
            var e = editor.$tb.find('.fr-command[data-cmd="insertPhoneNumber"]'),
                t = editor.popups.get("phone_number.insert");
            if(t) t.find('input.fr-link-attr[type="text"]').val("");
            if ((t || (t = initPopup()), !t.hasClass("fr-active"))) {
                if ((editor.popups.refresh("phone_number.insert"), editor.popups.setContainer("phone_number.insert", editor.$tb || editor.$sc), e.isVisible())) {
                    var n = editor.button.getPosition(e),
                        i = n.left - 120,
                        r = n.top - 100;
                    editor.popups.show("phone_number.insert", i, r, e.outerHeight());
                } else editor.position.forSelection(t), editor.popups.show("phone_number.insert");
            }

            jQuery("#fr-link-insert-layer-url-phone").inputmask({"mask": "(999) 999-9999"});
            if(!t.parents('.classic-editor__wrapper').hasClass('head-dropdown-active')) {
                t.parents('.classic-editor__wrapper').addClass('head-dropdown-active');
            }
        }

        /**
         * This will hide phone popup
         */
        function hidePopup () {
            editor.popups.hide('phone_number.insert');
        }

        /**
         * initialize plugin
         * @private
         */
        function _init(){
            console.log("phoneNumber Plugin -> ", editor.opts.phoneNumberButtons);
        }

        return {
            _init: _init,
            showPopup: showPopup,
            hidePopup: hidePopup,
            update: update,
            /**
             * insert/update phone number after click on button
             */
            insertCallback: function () {
                let popup = editor.popups.get("phone_number.insert"),
                    phone_input = jQuery(popup.find("#fr-link-insert-layer-url-phone")),
                    phone_number = phone_input.val();
                if(phone_number != ""){
                    // var selection = jQuery(editor.selection.get().focusNode.parentElement);
                    phone_number = phone_number.replace(/\_/g, '');
                    if(phone_number.length == 14){
                        phone_input.removeClass("fr-error");
                        var text = popup.find("#fr-link-insert-layer-text").val() || phone_number;
                        // if(editor.selection.text().trim() == ''){
                        //     editor.link.insert('tel:'+phone_number, text,{'class':'fb-phone-number'});
                        // }else{
                        //     console.log("else", selection.get(0), '<a class="fb-phone-number" href="tel:'+phone_number+'"><u>'+text+'</u></a>');
                        //     var new_cta_html =  editor.html.get().replace(selection,'<a class="fb-phone-number" href="tel:'+phone_number+'"><u>'+text+'</u></a>');
                        //     editor.html.set(new_cta_html);
                        // }
                        var o = editor.helpers.scrollTop();
                        editor.link.insert('tel:'+phone_number, text,{'class':'fb-phone-number'}), m(editor.o_win).scrollTop(o);
                        hidePopup();
                    }else{
                        phone_input.addClass("fr-error");
                    }
                }
            }
        }
    }

    // Define an icon and command for the button that opens the custom popup.
    FroalaEditor.DefineIcon('insertPhoneNumber', {NAME: 'phone'});
    FroalaEditor.RegisterCommand('insertPhoneNumber', {
        title: 'Insert Click-to-Call',
        focus: true,
        undo: true,
        refreshAfterCallback: true,
        callback: function () {
            this.popups.isVisible("phone_number.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("phone_number.insert")) : this.phoneNumber.showPopup();
        },
        plugin: 'phoneNumber'
    });

    /**
     * data will be submitted when clicked on button,
     * froala view will be updated with latest link details
     */
    FroalaEditor.RegisterCommand("PhoneNumberInsert", {
        focus: !1,
        refreshAfterCallback: !1,
        callback: function () {
            this.phoneNumber.insertCallback();
        },
        refresh: function (e) {
            this.link.get() ? e.text(this.language.translate("Update Phone Number")) : e.text(this.language.translate("Insert Phone Number"));
        },
        plugin: "ctaLink"
    });

    /**
     * popup will be opened with link data auto filled into it
     */
    FroalaEditor.DefineIcon('phoneNumberEdit', {NAME: 'phone'});
    FroalaEditor.RegisterCommand('phoneNumberEdit', {
        title: 'Edit Phone Number',
        focus: true,
        undo: true,
        spellcheck: false,
        refreshAfterCallback: true,
        callback: function () {
            this.phoneNumber.update();
        },
        plugin: 'phoneNumber'
    });

    // Define custom popup close button icon and command.
    FroalaEditor.DefineIcon('PhonePopupClose', { NAME: 'arrow-left' });
    FroalaEditor.RegisterCommand('PhonePopupClose', {
        title: 'Close',
        undo: false,
        focus: true,
        callback: function () {
            this.phoneNumber.hidePopup();
        }
    });
})(FroalaEditor);
