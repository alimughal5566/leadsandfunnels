/**
 * @author Muhammad Akram
 * Copyright 2022, All rights reserved @leadpops.com
 */

(function (FroalaEditor) {
    Object.assign(FroalaEditor.POPUP_TEMPLATES, {
        'more_options.popup': '[_BUTTONS_]'
    });

    // Add an option for your plugin.
    FroalaEditor.DEFAULTS = Object.assign(FroalaEditor.DEFAULTS, {
        moreOptionsButtons: [ 'subscript','superscript','paragraphStyle','paragraphFormat','embedly', 'insertFile','-', 'insertTable', 'selectAll', 'clearFormatting','spellChecker', 'help' , 'specialCharacters']
    });

    // Define the plugin.
    // The editor parameter is the current instance.
    FroalaEditor.PLUGINS.moreOptions = function (editor) {

        function initPopup () {
            // Popup buttons.
            var popup_buttons = '';

            // Create the list of buttons.
            if (editor.opts.moreOptionsButtons.length > 1) {
                popup_buttons += '<div class="fr-buttons">';
                popup_buttons += editor.button.buildList(editor.opts.moreOptionsButtons);
                popup_buttons += '</div>';
            }

            // Load popup template.
            var template = {
                buttons: popup_buttons,
            };

            // Create popup.
            var $popup = editor.popups.create('more_options.popup', template);

            return $popup;
        }

        /**
         * change popup position for Star link popup
         * @param editor
         */
        function showPopup() {
            var e = editor.$tb.find('.fr-command[data-cmd="starOption"]'),
                t = editor.popups.get("more_options.popup");
            if ((t || (t = initPopup()), !t.hasClass("fr-active")))
                if ((editor.popups.refresh("more_options.popup"), editor.popups.setContainer("more_options.popup", editor.$tb || editor.$sc), e.isVisible())) {
                    var n = editor.button.getPosition(e),
                        i = n.left,
                        r = n.top;
                    editor.popups.show("more_options.popup", i, r, e.outerHeight());
                } else editor.position.forSelection(t), editor.popups.show("more_options.popup");
        }

        function hidePopup () {
            editor.popups.hide('more_options.popup');
        }

        /**
         * initialize plugin
         * @private
         */
        function _init(){
            console.log("moreOptions Plugin -> ", editor.opts.moreOptionsButtons);
        }

        return {
            _init: _init,
            showPopup: showPopup,
            hidePopup: hidePopup
        }
    }

    // Define an icon and command for the button that opens the custom popup.
    FroalaEditor.DefineIcon('starOption', {NAME: 'star'});
    FroalaEditor.RegisterCommand('starOption', {
        title: 'More Options',
        undo: false,
        focus: false,
        plugin: 'moreOptions',
        callback: function () {
            this.moreOptions.showPopup();
        }
    });
})(FroalaEditor);
