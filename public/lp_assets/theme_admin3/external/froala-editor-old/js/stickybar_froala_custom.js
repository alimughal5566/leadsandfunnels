// Cta Button height

$.FroalaEditor.DefineIcon('height', {NAME: 'arrows-v'});
$.FroalaEditor.RegisterCommand('height', {
    title: 'Button Height',
    focus: true,
    undo: true,
    refreshAfterCallback: false,
    plugin: 'heightPlugin',
    callback: function () {
        this.heightPlugin.showPopup();
    }
});
// Define popup template.
$.extend($.FroalaEditor.POPUP_TEMPLATES, {
    key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
    "heightPlugin.popup": '[_BUTTONS_][_HEIGHT_LAYER_]'
});
// Define popup buttons.
$.extend($.FroalaEditor.DEFAULTS, {
    popupButtonheight: ['heightpopupClose',]
});
$.FroalaEditor.PLUGINS.heightPlugin = function (editor) {
    // Create custom popup.
    function initPopup () {
        // Popup buttons.
        var popup_button_height = '';

        // Create the list of buttons.
        if (editor.opts.popupButtonheight.length >= 1) {
            popup_button_height += '<div class="fr-buttons">';
            popup_button_height += editor.button.buildList(editor.opts.popupButtonheight);
            popup_button_height += '</div>';
        }

        // Load popup template.
        var template = {
            buttons: popup_button_height,
            height_layer: '<div class="fr-link-insert-layer sticky-bar-slider fr-layer fr-active">\n' +
            '               <div class="cta__slider">' +
            '                   <div class="slidecontainer">\n' +
            '                       <input type="range" min="1" max="100" value="50" class="slider" id="cta_height">\n' +
            '                   </div>\n'+
            '                </div>\n'+
            '             </div>'
        };



        // Create popup.
        var $popup = editor.popups.create('heightPlugin.popup', template);

        return $popup;
    }

    // Show the popup
    function showPopup () {
        // Get the popup object defined above.
        var $popup = editor.popups.get('heightPlugin.popup');

        // If popup doesn't exist then create it.
        // To improve performance it is best to create the popup when it is first needed
        // and not when the editor is initialized.
        if (!$popup) $popup = initPopup();

        // Set the editor toolbar as the popup's container.
        editor.popups.setContainer('heightPlugin.popup', editor.$tb);

        // This will trigger the refresh event assigned to the popup.
        // editor.popups.refresh('customPlugin.popup');

        // This custom popup is opened by pressing a button from the editor's toolbar.
        // Get the button's object in order to place the popup relative to it.
        var $btn = editor.$tb.find('.fr-command[data-cmd="height"]');

        // Set the popup's position.
        var left = $btn.offset().left + $btn.outerWidth() / 2;
        var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);

        // Show the custom popup.
        // The button's outerHeight is required in case the popup needs to be displayed above it.
        editor.popups.show('heightPlugin.popup', left, top, $btn.outerHeight());
    }

    // Hide the custom popup.
    function hidePopup () {
        editor.popups.hide('heightPlugin.popup');
    }

    // Methods visible outside the plugin.
    return {
        showPopup: showPopup,
        hidePopup: hidePopup
    }
};
// Define custom popup close button icon and command.
$.FroalaEditor.DefineIcon('heightpopupClose', { NAME: 'arrow-left' });
$.FroalaEditor.RegisterCommand('heightpopupClose', {
    title: 'Close',
    undo: false,
    focus: true,
    callback: function () {
        this.heightPlugin.hidePopup();
    }
});

// Cta Button width

$.FroalaEditor.DefineIcon('width', {NAME: 'arrows-h'});
$.FroalaEditor.RegisterCommand('width', {
    title: 'Button Width',
    focus: false,
    undo: true,
    refreshAfterCallback: false,
    plugin: 'widthPlugin',
    callback: function () {
        this.widthPlugin.showPopup();
    }
});
// Define popup template.
$.extend($.FroalaEditor.POPUP_TEMPLATES, {
    key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
    "widthPlugin.popup": '[_WIDTH_BUTTONS_][_WIDTH_LAYER_]'
});
// Define popup buttons.
$.extend($.FroalaEditor.DEFAULTS, {
    popupButtonwidth: ['widthpopupClose',]
});
$.FroalaEditor.PLUGINS.widthPlugin = function (editor) {
    // Create custom popup.
    function initPopup () {
        // Popup buttons.
        var popup_button_width = '';

        // Create the list of buttons.
        if (editor.opts.popupButtonwidth.length >= 1) {
            popup_button_width += '<div class="fr-buttons">';
            popup_button_width += editor.button.buildList(editor.opts.popupButtonwidth);
            popup_button_width += '</div>';
        }

        // Load popup template.
        var template = {
            width_buttons: popup_button_width,
            width_layer: '<div class="fr-link-insert-layer sticky-bar-slider fr-layer fr-active">\n' +
            '               <div class="cta__slider">' +
            '                   <div class="slidecontainer">\n' +
            '                       <input type="range" min="1" max="100" value="50" class="slider" id="cta_width">\n' +
            '                   </div>\n'+
            '                </div>\n'+
            '             </div>'
        };



        // Create popup.
        var $popup = editor.popups.create('widthPlugin.popup', template);

        return $popup;
    }

    // Show the popup
    function showPopup () {
        // Get the popup object defined above.
        var $popup = editor.popups.get('widthPlugin.popup');

        // If popup doesn't exist then create it.
        // To improve performance it is best to create the popup when it is first needed
        // and not when the editor is initialized.
        if (!$popup) $popup = initPopup();

        // Set the editor toolbar as the popup's container.
        editor.popups.setContainer('widthPlugin.popup', editor.$tb);

        // This will trigger the refresh event assigned to the popup.
        // editor.popups.refresh('customPlugin.popup');

        // This custom popup is opened by pressing a button from the editor's toolbar.
        // Get the button's object in order to place the popup relative to it.
        var $btn = editor.$tb.find('.fr-command[data-cmd="width"]');

        // Set the popup's position.
        var left = $btn.offset().left + $btn.outerWidth() / 2;
        var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);

        // Show the custom popup.
        // The button's outerHeight is required in case the popup needs to be displayed above it.
        editor.popups.show('widthPlugin.popup', left, top, $btn.outerHeight());
    }

    // Hide the custom popup.
    function hidePopup () {
        editor.popups.hide('widthPlugin.popup');
    }

    // Methods visible outside the plugin.
    return {
        showPopup: showPopup,
        hidePopup: hidePopup
    }
};

// Define custom popup close button icon and command.
$.FroalaEditor.DefineIcon('widthpopupClose', { NAME: 'arrow-left' });
$.FroalaEditor.RegisterCommand('widthpopupClose', {
    title: 'Close',
    undo: false,
    focus: false,
    callback: function () {
        this.widthPlugin.hidePopup();
    }
});

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
        var $btn = $("#phone-1");

        // Set the popup's position.

        var left = $btn.offset().left -190;
        var top = $btn.offset().top  - 15;


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
        var $btn = $("#phoneEdit-1");

        // Set the popup's position.

        var left = $btn.offset().left -190;
        var top = $btn.offset().top  - 15;

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

/*
$.FroalaEditor.DefineIcon('line-height', {NAME: 'arrows-v'});
$.FroalaEditor.RegisterCommand('line-height', {
    title: 'Line Height',
    focus: true,
    undo: true,
    refreshAfterCallback: false,
    plugin: 'lineHeightPlugin',
    callback: function () {
        this.heightPlugin.showPopup();
    }
});
// Define popup template.
$.extend($.FroalaEditor.POPUP_TEMPLATES, {
    key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
    "lineHeightPlugin.popup": '[_BUTTONS_][_HEIGHT_LAYER_]'
});
// Define popup buttons.
$.extend($.FroalaEditor.DEFAULTS, {
    popupButtonlineheight: ['lineHeightpopupClose',]
});
$.FroalaEditor.PLUGINS.LineHeightPlugin = function (editor) {
    // Create custom popup.
    function initPopup () {
        // Popup buttons.
        var popup_button_line_height = '';

        // Create the list of buttons.
        if (editor.opts.popupButtonlineheight.length >= 1) {
            popup_button_line_height += '<div class="fr-buttons">';
            popup_button_line_height += editor.button.buildList(editor.opts.popupButtonlineheight);
            popup_button_line_height += '</div>';
        }

        // Load popup template.
        var template = {
            buttons: popup_button_line_height,
            line_height_layer: '<div class="fr-link-insert-layer sticky-bar-slider fr-layer fr-active">\n' +
                '               <div class="cta__slider">' +
                '                   <div class="slidecontainer">\n' +
                '                       <input type="range" min="1" max="100" value="50" class="slider" id="fr_line_height">\n' +
                '                   </div>\n'+
                '                </div>\n'+
                '             </div>'
        };



        // Create popup.
        var $popup = editor.popups.create('lineHeightPlugin.popup', template);

        return $popup;
    }

    // Show the popup
    function showPopup () {
        // Get the popup object defined above.
        var $popup = editor.popups.get('lineHeightPlugin.popup');

        // If popup doesn't exist then create it.
        // To improve performance it is best to create the popup when it is first needed
        // and not when the editor is initialized.
        if (!$popup) $popup = initPopup();

        // Set the editor toolbar as the popup's container.
        editor.popups.setContainer('lineHeightPlugin.popup', editor.$tb);

        // This will trigger the refresh event assigned to the popup.
        // editor.popups.refresh('customPlugin.popup');

        // This custom popup is opened by pressing a button from the editor's toolbar.
        // Get the button's object in order to place the popup relative to it.
        var $btn = editor.$tb.find('.fr-command[data-cmd="lineheight"]');

        // Set the popup's position.
        var left = $btn.offset().left + $btn.outerWidth() / 2;
        var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);

        // Show the custom popup.
        // The button's outerHeight is required in case the popup needs to be displayed above it.
        editor.popups.show('LineHeightPlugin.popup', left, top, $btn.outerHeight());
    }

    // Hide the custom popup.
    function hidePopup () {
        editor.popups.hide('lineHeightPlugin.popup');
    }

    // Methods visible outside the plugin.
    return {
        showPopup: showPopup,
        hidePopup: hidePopup
    }
};
// Define custom popup close button icon and command.
$.FroalaEditor.DefineIcon('lineHeightpopupClose', { NAME: 'arrow-left' });
$.FroalaEditor.RegisterCommand('lineHeightpopupClose', {
    title: 'Close',
    undo: false,
    focus: true,
    callback: function () {
        this.heightPlugin.hidePopup();
    }
});
*/
