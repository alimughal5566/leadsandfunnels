/**
 * @author Muhammad Akram
 * Copyright 2022, All rights reserved @leadpops.com
 */
(function (FroalaEditor) {
    Object.assign(FroalaEditor.POPUP_TEMPLATES, {
        'cta_link.insert': '[_BUTTONS_][_CUSTOM_LAYER_]'
    });

    // Add an option for your plugin.
    FroalaEditor.DEFAULTS = Object.assign(FroalaEditor.DEFAULTS, {
        ctaLinkInsertButtons: [] //["linkCtaBack"]
    });

    // Define the plugin.
    // The editor parameter is the current instance.
    FroalaEditor.PLUGINS.ctaLink = function (editor) {
        // Private variable visible only inside the plugin scope.
        var m = editor.$;

        // Private method that is visible only inside plugin scope.
        /**
         * populate link data into popup if clicked on link
         * OR selected text than clicked on CTA link
         */
        function o() {
            var e = editor.popups.get("cta_link.insert"),
                t = editor.link.get();
            if (t) {
                var n,
                    i,
                    r = m(t),
                    a = e.find('input.fr-link-attr[type="text"]'),
                    l = e.find('input.fr-link-attr[type="checkbox"]');
                for (n = 0; n < a.length; n++) (i = m(a[n])).val(r.attr(i.attr("name") || ""));
                for (l.attr("checked", !1), n = 0; n < l.length; n++) (i = m(l[n])), r.attr(i.attr("name")) == i.data("checked") && i.attr("checked", !0);
                e.find('input.fr-link-attr[type="text"][name="text"]').val(r.text());
            } else e.find('input.fr-link-attr[type="text"]').val(""), e.find('input.fr-link-attr[type="checkbox"]').attr("checked", !1), e.find('input.fr-link-attr[type="text"][name="text"]').val(editor.selection.text());
            e.find("input.fr-link-attr").trigger("change"), (editor.image ? editor.image.get() : null) ? e.find('.fr-link-attr[name="text"]').parent().hide() : e.find('.fr-link-attr[name="text"]').parent().show();
        }

        /**
         * initialize popup
         * @param e
         * @returns {cta_link.insert|*}
         */
        function initPopup (e) {
            if (e) return editor.popups.onRefresh("cta_link.insert", o), !0;
            // Image buttons.
            let input_layer = '',
                tab_idx = 0,
                link_buttons = editor.opts.ctaLinkInsertButtons.length ? '<div class="fr-buttons fr-tabs">'.concat(editor.button.buildList(editor.opts.ctaLinkInsertButtons), "</div>") : '',
                checkmark = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10" height="10" viewBox="0 0 32 32"><path d="M27 4l-15 15-7-7-5 5 12 12 20-20z" fill="#FFF"></path></svg>';

            input_layer += '<div class="custom_cta_pop-wrap-block fr-cta_link-insert-layer fr-layer fr-active" id="fr-cta_link-insert-layer-'.concat(editor.id, '">') +
                '<div class="custom_cta_pop-wrap">' +
                    '<div class="custom_cta_pop">'+
                        '<input id="top_funnel" type="radio" name="type_of_link" checked>' +
                        '<label class="pop-label" for="top_funnel">Top of Funnel</label>' +
                    '</div>' +
                    '<div class="text_or">OR</div>'+
                    '<div class="custom_cta_pop">' +
                        '<input id="outside_url" type="radio" name="type_of_link">' +
                        '<label class="pop-label" for="outside_url">Outside URL</label>' +
                    '</div>' +
                '</div>';

            input_layer += '<div class="fr-input-line">' +
                    '<input id="fr-cta_link-insert-layer-url-' + editor.id + '" name="href" type="text" class="fr-link-attr" placeholder=URL tabIndex="' + (++tab_idx) + '">' +
                '</div>';

            input_layer += '<div class="fr-input-line">' +
                    '<input id="fr-cta-link-insert-layer-text-' + editor.id + '" name="text" type="text" class="fr-link-attr" placeholder="' + editor.language.translate('Text') + '" tabIndex="' + (++tab_idx) + '">' +
                '</div>';

            if (!editor.opts.linkAlwaysBlank) {
                input_layer += '<div class="fr-checkbox-line d-none">' +
                    '<span class="fr-checkbox">' +
                        '<input name="target" class="fr-link-attr" data-checked="_blank" type="checkbox" id="fr-link-target-' + editor.id + '" tabIndex="' + (++tab_idx) + '">' +
                        '<span>' + checkmark + '</span>' +
                    '</span>' +
                    '<label id="fr-label-target-' + editor.id + '">' + editor.language.translate('Open in new tab') + '</label>' +
                '</div>';
            }

            input_layer += '<div class="fr-action-buttons">' +
                    '<button class="fr-command fr-submit" role="button" data-cmd="linkCtaInsert" href="#" tabIndex="' + (++tab_idx) + '" type="button">' + editor.language.translate('Insert') + '</button>' +
                '</div>' +
                '</div>';

            var template = {
                buttons: link_buttons,
                custom_layer: input_layer
            }

            // Set the template in the popup.
            var $popup = editor.popups.create('cta_link.insert', template);

            if (editor.$wp) {
                editor.events.$on(editor.$wp, 'scroll.cta_link-insert', function () {
                    var $current_image = editor.image ? editor.image.get() : null;
                    if ($current_image && editor.popups.isVisible('cta_link.insert')) {
                        editor.image.imageLink();
                    }else if (editor.link.get() && editor.popups.isVisible('cta_link.insert')) {
                        update();
                    }
                });
            }

            editor.popups.onRefresh("cta_link.insert", o);

            return $popup;
        }

        /**
         * Event to control option switch
         */
        function initCtaLinkEvents() {
            let popupId = "#fr-cta_link-insert-layer-" + editor.id;
            jQuery(document).on('change', popupId + " input[name='type_of_link']",function (){
                let url_input = jQuery(popupId).find("input[name='href']"),
                    checkBoxWrapper = jQuery(popupId).find(".fr-checkbox-line");
                if($(this).attr('id') == 'outside_url'){
                    url_input.parent().show();
                    checkBoxWrapper.removeClass("d-none");
                }else{
                    url_input.parent().hide();
                    checkBoxWrapper.addClass("d-none");
                }
            });
        }

        /**
         * select option when link is opened into popup
         */
        function selectUrlOption() {
            let popupId = "#fr-cta_link-insert-layer-" + editor.id;
            let url_input = jQuery(popupId).find("input[name='href']"),
                checkBoxWrapper = jQuery(popupId).find(".fr-checkbox-line"),
                url = jQuery.trim(url_input.val());
            if(url == "" || jQuery.inArray(url,["#GetStartedNow",'#top']) !== -1){
                if(url == "") {
                    url_input.val("#top");
                }
                url_input.parent().hide();
                $(popupId).find("#top_funnel").prop("checked","checked");
                checkBoxWrapper.addClass("d-none");
            }else{
                url_input.parent().show();
                $(popupId).find("#outside_url").prop("checked","checked");
                checkBoxWrapper.removeClass("d-none");
            }
        }

        // Public method that is visible in the instance scope.
        /**
         * function to show CTA plugin popup
         */
        function showPopup () {
            var e = editor.$tb.find('.fr-command[data-cmd="insertCtaLink"]'),
                t = editor.popups.get("cta_link.insert");
            if ((t || (t = initPopup()), !t.hasClass("fr-active")))
                if ((editor.popups.refresh("cta_link.insert"), editor.popups.setContainer("cta_link.insert", editor.$tb || editor.$sc), e.isVisible())) {
                    var n = editor.button.getPosition(e),
                        i = n.left,
                        r = n.top;
                    editor.popups.show("cta_link.insert", i, r, e.outerHeight());
                } else editor.position.forSelection(t), editor.popups.show("cta_link.insert");

            selectUrlOption();
        }

        /**
         * Hide CTA plugin popup
         */
        function hidePopup () {
            editor.popups.hide('cta_link.insert');
        }

        /**
         * open link into Edit link popup
         */
        function update() {
            hidePopup();
            var e = editor.link.get();
            if (e) {
                var t = editor.popups.get("cta_link.insert");
                t || (t = initPopup()),
                editor.popups.isVisible("cta_link.insert") || (editor.popups.refresh("cta_link.insert"), editor.selection.save(), editor.helpers.isMobile() && (editor.events.disableBlur(), editor.$el.blur(), editor.events.enableBlur())),
                    editor.popups.setContainer("cta_link.insert", editor.$sc);
                var n = (editor.image ? editor.image.get() : null) || m(e),
                    i = n.offset().left + n.outerWidth() / 2,
                    r = n.offset().top + n.outerHeight();
                editor.popups.show("cta_link.insert", i, r, n.outerHeight(), !0);
            }
            selectUrlOption();
        }

        /**
         * The start point for plugin.
         */
        function _init () {
            initCtaLinkEvents();

            /**
             * before inserting link adding CTA button class on link
             */
            editor.events.on('link.beforeInsert', function (link, text, attrs) {
                if (is_cta_popup || jQuery(editor.link.get()).hasClass("za_cta_style")) {
                    attrs.class = "za_cta_style";
                }
            });
        }

        return {
            _init: _init,
            showInsertPopup: showPopup,
            hidePopup: hidePopup,
            update: update,
            insertCtaCallback: function k() {
                var e,
                    t,
                    n = editor.popups.get("cta_link.insert"),
                    i = n.find('input.fr-link-attr[type="text"]'),
                    r = n.find('input.fr-link-attr[type="checkbox"]'),
                    a = (i.filter('[name="href"]').val() || "").trim(),
                    l = editor.opts.linkText ? i.filter('[name="text"]').val() : "",
                    s = {};

                for (t = 0; t < i.length; t++) (e = m(i[t])), ["href", "text"].indexOf(e.attr("name")) < 0 && (s[e.attr("name")] = e.val());
                for (t = 0; t < r.length; t++) (e = m(r[t])).is(":checked") ? (s[e.attr("name")] = e.data("checked")) : (s[e.attr("name")] = e.data("unchecked") || null);
                n.rel && (s.rel = n.rel);
                var o = editor.helpers.scrollTop();
                editor.link.insert(a, l, s), m(editor.o_win).scrollTop(o);
            }
        }
    }

    FroalaEditor.DefineIcon('insertCtaLink', {NAME: 'arrow-right'});
    FroalaEditor.RegisterCommand('insertCtaLink', {
        title: 'Add CTA Link',
        focus: true,
        undo: true,
        refreshAfterCallback: true,
        callback: function () {
            console.log("cta_link.insert", this.popups.isVisible('cta_link.insert'));
            this.popups.isVisible("cta_link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("cta_link.insert")) : this.ctaLink.showInsertPopup();
        },
        plugin: "ctaLink"
    });

    /**
     * popup will be opened when clicked on button
     */
    FroalaEditor.RegisterCommand("linkCtaInsert", {
        focus: !1,
        refreshAfterCallback: !1,
        callback: function () {
            this.ctaLink.insertCtaCallback();
        },
        refresh: function (e) {
            this.link.get() ? e.text(this.language.translate("Update")) : e.text(this.language.translate("Insert"));
        },
        plugin: "ctaLink"
    });

    /**
     * this command will be executed for both plugins
     * link & CTA
     */
    FroalaEditor.RegisterCommand("linkEdit", {
        title: "Edit Link",
        undo: !1,
        refreshAfterCallback: !1,
        popup: !0,
        callback: function () {
            if(jQuery(this.link.get()).hasClass("za_cta_style")) {
                this.ctaLink.update();
            } else {
                this.link.update();
            }
        },
        refresh: function (e) {
            this.link.get() ? e.removeClass("fr-hidden") : e.addClass("fr-hidden");
        },
        plugin: "link",
    });
})(FroalaEditor);
