/**
 * @author Muhammad Akram
 * Copyright 2022, All rights reserved @leadpops.com
 */

(function (FroalaEditor) {
    // Add an option for your plugin.
    FroalaEditor.DEFAULTS = Object.assign(FroalaEditor.DEFAULTS, {
        options: {}
    });

    // Define the plugin.
    // The editor parameter is the current instance.
    FroalaEditor.PLUGINS.ctaLink = function (editor) {
        /**
         * change popup position for CTA link popup
         * @param editor
         */
        function showPopup() {
            editor.link.showInsertPopup();
            var e = editor.$tb.find('.fr-command[data-cmd="insertCtaLink"]'),
                n = editor.button.getPosition(e),
                i = n.left,
                r = n.top;
            editor.popups.show("link.insert", i, r, e.outerHeight());
        }

        /**
         * initialize plugin
         * @private
         */
        function _init(){
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
            showPopup: showPopup
        }
    }

    FroalaEditor.DefineIcon('insertCtaLink', {NAME: 'arrow-right'});
    FroalaEditor.RegisterCommand('insertCtaLink', {
        title: 'Add CTA Link',
        focus: true,
        undo: true,
        refreshAfterCallback: true,
        callback: function () {
            this.popups.isVisible("link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("link.insert")) : this.ctaLink.showPopup();
        }
    });
})(FroalaEditor);
