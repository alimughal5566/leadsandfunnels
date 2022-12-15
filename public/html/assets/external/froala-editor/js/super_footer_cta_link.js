/*!
 * froala_editor v2.7.0 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2017 Froala Labs
 */
window.global = 1;
window.cta_label = 'Insert CTA Button';
window.cl = window.editor_type = '';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = function( root, jQuery ) {
            if ( jQuery === undefined ) {
                // require('jQuery') returns a factory that requires window to
                // build a jQuery instance, we normalize how we use modules
                // that require this pattern but the window provided is a noop
                // if it's defined (how jquery works)
                if ( typeof window !== 'undefined' ) {
                    jQuery = require('jquery');
                }
                else {
                    jQuery = require('jquery')(root);
                }
            }
            return factory(jQuery);
        };
    } else {
        // Browser globals
        factory(window.jQuery);
    }
}(function ($) {

    $.extend($.FE.POPUP_TEMPLATES, {
        'link.edit': '[_BUTTONS_]',
        'link.insert': '[_BUTTONS_][_INPUT_LAYER_]'
    })

    $.extend($.FE.DEFAULTS, {
        linkEditButtons: ['linkOpen', "linkStyle",'linkEdit', 'linkRemove'],
        linkInsertButtons: ["linkBack", "|"],
        linkAttributes: {},
        linkAutoPrefix: 'http://',
        linkMultipleStyles: true,
        linkConvertEmailAddress: true,
        linkAlwaysBlank: false,
        linkAlwaysNoFollow: false,
        linkStyles: {
            "fr-green": "Green",
            "fr-strong": "Thick"
        },
        linkList: [
            {
                text: 'Froala',
                href: 'https://froala.com',
                target: '_blank'
            },
            {
                text: 'Google',
                href: 'https://google.com',
                target: '_blank'
            },
            {
                displayText: 'Facebook',
                href: 'https://facebook.com'
            }
        ],
        linkText: true
    });

    $.FE.PLUGINS.zalink = function (editor) {
        function get () {
            var $current_image = editor.image ? editor.image.get() : null;

            if (!$current_image && editor.$wp) {
                var c_el = editor.selection.ranges(0).commonAncestorContainer;

                if (c_el && (c_el.contains && c_el.contains(editor.el) || !editor.el.contains(c_el) || editor.el == c_el)) c_el = null;

                if (c_el && c_el.tagName === 'A') return c_el;
                var s_el = editor.selection.element();
                var e_el = editor.selection.endElement();

                if (s_el.tagName != 'A' && !editor.node.isElement(s_el)) {
                    s_el = $(s_el).parentsUntil(editor.$el, 'a:first').get(0);
                }

                if (e_el.tagName != 'A' && !editor.node.isElement(e_el)) {
                    e_el = $(e_el).parentsUntil(editor.$el, 'a:first').get(0);
                }

                if (e_el && (e_el.contains && e_el.contains(editor.el) || !editor.el.contains(e_el) || editor.el == e_el)) e_el = null;

                if (s_el && (s_el.contains && s_el.contains(editor.el) || !editor.el.contains(s_el) || editor.el == s_el)) s_el = null;

                if (e_el && e_el == s_el && e_el.tagName == 'A') {

                    return s_el;
                }

                return null;
            }
            else if (editor.el.tagName == 'A') {

                return editor.el;
            }
            else {
                if ($current_image && $current_image.get(0).parentNode && $current_image.get(0).parentNode.tagName == 'A') {

                    return $current_image.get(0).parentNode;
                }
            }
        }

        function allSelected () {
            var $current_image = editor.image ? editor.image.get() : null;
            var selectedLinks = [];

            if ($current_image) {
                if ($current_image.get(0).parentNode.tagName == 'A') {
                    selectedLinks.push($current_image.get(0).parentNode);
                }
            }
            else {
                var range;
                var containerEl;
                var links;
                var linkRange;

                if (editor.win.getSelection) {
                    var sel = editor.win.getSelection();

                    if (sel.getRangeAt && sel.rangeCount) {
                        linkRange = editor.doc.createRange();

                        for (var r = 0; r < sel.rangeCount; ++r) {
                            range = sel.getRangeAt(r);
                            containerEl = range.commonAncestorContainer;

                            if (containerEl && containerEl.nodeType != 1) {
                                containerEl = containerEl.parentNode;
                            }

                            if (containerEl && containerEl.nodeName.toLowerCase() == 'a') {
                                selectedLinks.push(containerEl);
                            }
                            else {
                                links = containerEl.getElementsByTagName('a');

                                for (var i = 0; i < links.length; ++i) {
                                    linkRange.selectNodeContents(links[i]);

                                    if (linkRange.compareBoundaryPoints(range.END_TO_START, range) < 1 && linkRange.compareBoundaryPoints(range.START_TO_END, range) > -1) {
                                        selectedLinks.push(links[i]);
                                    }
                                }
                            }
                        }

                        // linkRange.detach();
                    }
                }
                else if (editor.doc.selection && editor.doc.selection.type != 'Control') {
                    range = editor.doc.selection.createRange();
                    containerEl = range.parentElement();

                    if (containerEl.nodeName.toLowerCase() == 'a') {
                        selectedLinks.push(containerEl);
                    }
                    else {
                        links = containerEl.getElementsByTagName('a');
                        linkRange = editor.doc.body.createTextRange();

                        for (var j = 0; j < links.length; ++j) {
                            linkRange.moveToElementText(links[j]);

                            if (linkRange.compareEndPoints('StartToEnd', range) > -1 && linkRange.compareEndPoints('EndToStart', range) < 1) {
                                selectedLinks.push(links[j]);
                            }
                        }
                    }
                }
            }

            return selectedLinks;
        }

        function _edit (e) {
            if (editor.core.hasFocus()) {
                _hideEditPopup();

                // Do not show edit popup for link when ALT is hit.
                if (e && e.type === 'keyup' && (e.altKey || e.which == $.FE.KEYCODE.ALT)) return true;

                setTimeout (function () {

                    // No event passed.
                    // Event passed and (left click or other event type).
                    if (!e || (e && (e.which == 1 || e.type != 'mouseup'))) {
                        var link = get();
                        var $current_image = editor.image ? editor.image.get() : null;

                        if (link && !$current_image) {
                            if (editor.image) {
                                var contents = editor.node.contents(link);

                                // https://github.com/froala/wysiwyg-editor/issues/1103
                                if (contents.length == 1 && contents[0].tagName == 'IMG') {
                                    var range = editor.selection.ranges(0);

                                    if (range.startOffset === 0 && range.endOffset === 0) {
                                        $(link).before($.FE.MARKERS);
                                    }
                                    else {
                                        $(link).after($.FE.MARKERS);
                                    }

                                    editor.selection.restore();

                                    return false;
                                }
                            }

                            if (e) {
                                e.stopPropagation();
                            }
                            _showEditPopup(link);
                        }
                    }
                }, editor.helpers.isIOS() ? 100 : 0);
            }
        }

        function _showEditPopup (link) {
            var $popup = editor.popups.get('link.edit');
            $popup = _initEditPopup();

            var $link = $(link);

            if (!editor.popups.isVisible('link.edit')) {
                editor.popups.refresh('link.edit');
            }
            editor.popups.setContainer('link.edit', editor.$sc);
            var left = $link.offset().left + $(link).outerWidth() / 2;
            var top = $link.offset().top + $link.outerHeight();
            editor.popups.show('link.edit', left, top, $link.outerHeight());
        }

        function _hideEditPopup () {
            editor.popups.hide('link.edit');
        }

        function _initEditPopup () {

            // Link buttons.
            var link_buttons = '';
            $(".fr-popup.fr-active").remove();
            if (editor.opts.linkEditButtons.length > 1) {
                if (editor.el.tagName == 'A' && editor.opts.linkEditButtons.indexOf('linkRemove') >= 0) {
                    editor.opts.linkEditButtons.splice(editor.opts.linkEditButtons.indexOf('linkRemove'), 1);
                }

                link_buttons = '<div class="fr-buttons">' + editor.button.buildList(editor.opts.linkEditButtons) + '</div>';
            }

            var template = {
                buttons: link_buttons
            };

            // Set the template in the popup.
            var $popup = editor.popups.create('link.edit', template);

            if (editor.$wp) {
                editor.events.$on(editor.$wp, 'scroll.link-edit', function () {
                    if (get() && editor.popups.isVisible('link.edit')) {
                        _showEditPopup(get());
                    }
                });
            }

            return $popup;
        }

        /**
         * Hide link insert popup.
         */
        function _hideInsertPopup () {
        }

        function _refreshInsertPopup () {
            var $popup = editor.popups.get('link.insert');
            var link = get();

            if (link) {
                var $link = $(link);
                var text_inputs = $popup.find('input.fr-link-attr[type="text"]');
                var check_inputs = $popup.find('input.fr-link-attr[type="checkbox"]');
                var i;
                var $input;

                for (i = 0; i < text_inputs.length; i++) {
                    $input = $(text_inputs[i]);
                    $input.val($link.attr($input.attr('name') || ''));
                }

                check_inputs.prop('checked', false);

                for (i = 0; i < check_inputs.length; i++) {
                    $input = $(check_inputs[i]);

                    if ($link.attr($input.attr('name')) == $input.data('checked')) {
                        $input.prop('checked', true);
                    }
                }

                $popup.find('input.fr-link-attr[type="text"][name="text"]').val($link.text());
            }
            else {
                $popup.find('input.fr-link-attr[type="text"]').val('');
                $popup.find('input.fr-link-attr[type="checkbox"]').prop('checked', false);
                $popup.find('input.fr-link-attr[type="text"][name="text"]').val(editor.selection.text());
            }
            $popup.find('input.fr-link-attr').trigger('change');
            var $current_image = editor.image ? editor.image.get() : null;

            if ($current_image) {
                $popup.find('.fr-link-attr[name="text"]').parent().hide();
            }
            else {
                $popup.find('.fr-link-attr[name="text"]').parent().show();
            }
        }

        function superFooterInsertPopup () {
            var self = this;
            if(window.editor_type == 'cta') {
                var $btn = editor.$tb.find('.fr-command[data-cmd="insertCTALink"]');
            }else{
                var $btn = editor.$tb.find('.fr-command[data-cmd="insertLink"]');
            }
            var $popup = editor.popups.get('link.insert');

            $popup = _initInsertPopup();

            if (!$popup.hasClass('fr-active')) {
                editor.popups.refresh('link.insert');
                editor.popups.setContainer('link.insert', editor.$tb || editor.$sc);

                if ($btn.is(':visible')) {
                    var left = $btn.offset().left + $btn.outerWidth() / 2;
                    var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);
                    editor.popups.show('link.insert', left, top, $btn.outerHeight());
                }
                else {
                    editor.position.forSelection($popup);
                    editor.popups.show('link.insert');
                }
            }
            $(".fr-popup").trigger("focusin");
        }

        function _initInsertPopup () {
            // Image buttons.
            var link_buttons = '';
            var input_layer = '';
            var tab_idx = 0;
            var checkmark = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10" height="10" viewBox="0 0 32 32"><path d="M27 4l-15 15-7-7-5 5 12 12 20-20z" fill="#FFF"></path></svg>';
            input_layer = '<div class="fr-link-insert-layer fr-layer fr-active super_footer_popup" id="fr-link-insert-layer-' + editor.id + '">';
            if(window.global == 1 && window.editor_type == 'cta') {
                input_layer += '<div class="fr-input-line">' +
                    '<div class="select2-search-input">' +
                    '<div class="custom_cta_pop">'+
                    '<input id="top_funnel" type="radio" name="type_of_link" checked>' +
                    '<label for="top_funnel">Top of Funnel</label>' +
                    '</div>' +
                    '<div class="custom_cta_pop text_or">OR</div>'+
                    '<div class="custom_cta_pop">' +
                    '<input id="outside_url" type="radio" name="type_of_link">' +
                    '<label for="outside_url">Outside URL</label>' +
                    '</div></div></div>' +
                    '<div class="clearfix"></div>';
                window.cl = 'url_input';
            }else{
                window.cl = '';
            }

            input_layer += '<div class="fr-input-line label_hide '+window.cl+'"' +
                '><input id="fr-link-insert-layer-url-' + editor.id + '" name="href" type="text" class="fr-link-attr" placeholder="URL" tabIndex="' + (++tab_idx) + '">' +
                '</div>';

            if (editor.opts.linkText) {
                input_layer += '<div class="fr-input-line label_hide">' +
                    '<input id="fr-link-insert-layer-text-' + editor.id + '" name="text" type="text" class="fr-link-attr" placeholder="' + editor.language.translate('Text') + '" tabIndex="' + (++tab_idx) + '">' +
                    '</div>';
            }

            if (!editor.opts.linkAlwaysBlank) {
                input_layer += '<div class="fr-checkbox-line '+window.cl+'"><span class="fr-checkbox"><input name="target" class="fr-link-attr" data-checked="_blank" type="checkbox" id="fr-link-target-' + editor.id + '" tabIndex="' + (++tab_idx) + '"><span>' + checkmark + '</span></span><label for="fr-link-target-' + editor.id + '">' + editor.language.translate('Open in new tab') + '</label></div>';
            }

            input_layer += '<div class="fr-action-buttons">' +
                '<button class="fr-command fr-submit" role="button" data-cmd="linkInsert" href="#" tabIndex="' + (++tab_idx) + '" type="button">' + editor.language.translate('Insert') + '</button>' +
                '</div>' +
                '</div>';

            var template = {
                buttons: link_buttons,
                input_layer: input_layer
            }

            // Set the template in the popup.
            var $popup = editor.popups.create('link.insert', template);

            if (editor.$wp) {
                editor.events.$on(editor.$wp, 'scroll.link-insert', function () {
                    var $current_image = editor.image ? editor.image.get() : null;

                    if ($current_image && editor.popups.isVisible('link.insert')) {
                        imageLink();
                    }

                    if (get && editor.popups.isVisible('link.insert')) {
                        update();
                    }
                });
            }


            return $popup;
        }

        function remove () {
            var link = get();
            var $current_image = editor.image ? editor.image.get() : null;

            if (editor.events.trigger('link.beforeRemove', [link]) === false) return false;

            if ($current_image && link) {
                $current_image.unwrap();
                editor.image.edit($current_image);
            }
            else if (link) {
                editor.selection.save();
                $(link).replaceWith($(link).html());
                editor.selection.restore();
                _hideEditPopup();
            }
        }

        function _init () {

            // Edit on keyup.
            editor.events.on('keyup', function (e) {
                if (e.which != $.FE.KEYCODE.ESC) {
                    _edit(e);
                }
            });

            editor.events.on('window.mouseup', _edit);

            // Do not follow links when edit is disabled.
            editor.events.$on(editor.$el, 'click', 'a', function (e) {
                if (editor.edit.isDisabled()) {
                    e.preventDefault();
                }
            });

            if (editor.helpers.isMobile()) {
                editor.events.$on(editor.$doc, 'selectionchange', _edit);
            }

            _initInsertPopup(true);


            // Init on link.
            if (editor.el.tagName == 'A') {
                editor.$el.addClass('fr-view');
            }

            // Hit ESC when focus is in link edit popup.
            editor.events.on('toolbar.esc', function () {
                if (editor.popups.isVisible('link.edit')) {
                    editor.events.disableBlur();
                    editor.events.focus();

                    return false;
                }
            }, true);
        }

        function usePredefined (val) {
            var link = editor.opts.linkList[val];
            var $popup = editor.popups.get('link.insert');
            var text_inputs = $popup.find('input.fr-link-attr[type="text"]');
            var check_inputs = $popup.find('input.fr-link-attr[type="checkbox"]');
            var $input;
            var i;

            for (i = 0; i < text_inputs.length; i++) {
                $input = $(text_inputs[i]);

                if (link[$input.attr('name')]) {
                    $input.val(link[$input.attr('name')]);
                }
                else if ($input.attr('name') != 'text') {
                    $input.val('');
                }
            }

            for (i = 0; i < check_inputs.length; i++) {
                $input = $(check_inputs[i]);
                $input.prop('checked', $input.data('checked') == link[$input.attr('name')]);
            }
            editor.accessibility.focusPopup($popup);
        }

        function _usePlekLink (link) {
            var $popup = editor.popups.get('link.insert');
            var text_inputs = $popup.find('input.fr-link-attr[type="text"]');
            var check_inputs = $popup.find('input.fr-link-attr[type="checkbox"]');
            var $input;
            var i;

            for (i = 0; i < text_inputs.length; i++) {
                $input = $(text_inputs[i]);

                if (link[$input.attr('name')]) {
                    $input.val(link[$input.attr('name')]);
                }
                else if ($input.attr('name') != 'text') {
                    $input.val('');
                }
            }

            for (i = 0; i < check_inputs.length; i++) {
                $input = $(check_inputs[i]);
                $input.prop('checked', $input.data('checked') == link[$input.attr('name')]);
            }
            editor.accessibility.focusPopup($popup);
        }

        function insertCallback () {
            var $popup = editor.popups.get('link.insert');
            var text_inputs = $popup.find('input.fr-link-attr[type="text"]');
            var check_inputs = $popup.find('input.fr-link-attr[type="checkbox"]');
            var href = text_inputs.filter('[name="href"]').val();
            var text = text_inputs.filter('[name="text"]').val();
            console.log($(".fr-popup.fr-active").is(":checked"));
            if ($(".fr-popup #top_funnel").is(":checked") || $(".fr-popup.fr-active").length == 0) {
                    href = '#top';
                    text_inputs.filter('[name="href"]').val('');
            }
            console.log(href);
            var attrs = {};
            var $input;
            var i;

            for (i = 0; i < text_inputs.length; i++) {
                $input = $(text_inputs[i]);

                if (['href', 'text'].indexOf($input.attr('name')) < 0) {
                    attrs[$input.attr('name')] = $input.val();
                }
            }

            for (i = 0; i < check_inputs.length; i++) {
                $input = $(check_inputs[i]);

                if ($input.is(':checked')) {
                    attrs[$input.attr('name')] = $input.data('checked');
                }
                else {
                    attrs[$input.attr('name')] = $input.data('unchecked') || null;
                }
            }

            var t = editor.helpers.scrollTop();
            insert(href, text, attrs);
            $(editor.o_win).scrollTop(t);
        }

        function _split () {
            if (!editor.selection.isCollapsed()) {
                editor.selection.save();
                var markers = editor.$el.find('.fr-marker').addClass('fr-unprocessed').toArray();

                while (markers.length) {
                    var $marker = $(markers.pop());
                    $marker.removeClass('fr-unprocessed');

                    // Get deepest parent.
                    var deep_parent = editor.node.deepestParent($marker.get(0));

                    if (deep_parent) {
                        var node = $marker.get(0);
                        var close_str = '';
                        var open_str = '';

                        do {
                            node = node.parentNode;

                            if (!editor.node.isBlock(node)) {
                                close_str = close_str + editor.node.closeTagString(node);
                                open_str = editor.node.openTagString(node) + open_str;
                            }
                        } while (node != deep_parent);

                        var marker_str = editor.node.openTagString($marker.get(0)) + $marker.html() +  editor.node.closeTagString($marker.get(0));

                        $marker.replaceWith('<span id="fr-break"></span>');
                        var h = deep_parent.outerHTML;

                        h = h.replace(/<span id="fr-break"><\/span>/g, close_str + marker_str + open_str);

                        deep_parent.outerHTML = h;
                    }

                    markers = editor.$el.find('.fr-marker.fr-unprocessed').toArray();
                }

                editor.html.cleanEmptyTags();

                editor.selection.restore();
            }
        }

        /**
         * Insert link into the editor.
         */
        function insert (href, text, attrs) {
            var txt = '';
            if (typeof attrs == 'undefined') attrs = {};

            if (editor.events.trigger('link.beforeInsert', [href, text, attrs]) === false) return false;

            // Get image if we have one selected.
            var $current_image = editor.image ? editor.image.get() : null;

            if (!$current_image && editor.el.tagName != 'A') {
                editor.selection.restore();
                editor.popups.hide('link.insert');
            }
            else if (editor.el.tagName == 'A') {
                editor.$el.focus();
            }

            var original_href = href;

            // Convert email address.
            if (editor.opts.linkConvertEmailAddress) {
                var regex = $.FE.MAIL_REGEX;

                if (regex.test(href) && !/^mailto:.*/i.test(href)) {
                    href = 'mailto:' + href;
                }
            }

            // Check if is local path.
            var local_path = /^([A-Za-z]:(\\){1,2}|[A-Za-z]:((\\){1,2}[^\\]+)+)(\\)?$/i;

            // Add autoprefix.
            if (editor.opts.linkAutoPrefix !== '' && !new RegExp('^(' + $.FE.LinkProtocols.join('|') + '):.', 'i').test(href) && !/^data:image.*/i.test(href) && !/^(https?:|ftps?:|file:|)\/\//i.test(href) && !local_path.test(href)) {

                // Do prefix only if starting character is not absolute.
                if (['/', '{', '[', '#', '('].indexOf((href || '')[0]) < 0) {
                    href = editor.opts.linkAutoPrefix + href;
                }
            }

            // Sanitize the URL.
            href = editor.helpers.sanitizeURL(href);

            // Default attributs.
            if (editor.opts.linkAlwaysBlank) attrs.target = '_blank';

            if (editor.opts.linkAlwaysNoFollow) attrs.rel = 'nofollow';

            // https://github.com/froala/wysiwyg-editor/issues/1576.
            if (attrs.target == '_blank') {
                if (!attrs.rel) attrs.rel = 'noopener noreferrer';
                else attrs.rel += ' noopener noreferrer';
            }
            else if (attrs.target == null) {
                if (attrs.rel) {
                    attrs.rel = attrs.rel.replace(/noopener/, '').replace(/noreferrer/, '');
                }
                else {
                    attrs.rel = null;
                }
            }

            // Format text.
            text = text || '';

            if (href === editor.opts.linkAutoPrefix) {
                var $popup = editor.popups.get('link.insert');
                $popup.find('input[name="href"]').addClass('fr-error');
                editor.events.trigger('link.bad', [original_href]);

                return false;
            }

            // Check if we have selection only in one link.
            var link = get();
            var $link;
            var _target = '_top';
            if (attrs.target == '_blank') {
                _target="_blank";
            }
            if (link) {
                $link = $(link);

                $link.attr('href', href);
                $link.attr('target',_target);
                // Change text if it is different.
                if (text.length > 0 && $link.text() != text && !$current_image) {
                    var new_link = $($link).html().replace($link.text().trim(),text.trim());
                    $link.html(new_link);
                }
            }
            else {

                // We don't have any image selected.
                if (!$current_image) {


                    // Remove current links.
                    editor.format.remove('a');
                    $(".za_cta_style").removeAttr('id');
                    var last_inner_html = inner_html = anchor_id = cta_button = '';
                    var html_tag = editor.html.getSelected().replace(/[^a-z0-9<></>\s]/gi, '').replace(/<\/?sub>/g,'');
                    if($(html_tag).children().length > 0) {
                         last_inner_html = $(html_tag).children().last();
                         inner_html = $(editor.html.getSelected()).children().last();
                         console.log(inner_html);
                        if (last_inner_html[0] !== undefined) {
                            if ($(last_inner_html.html()).prop('tagName') == undefined) {
                                last_inner_html = inner_html[0].outerHTML;

                            } else {
                                last_inner_html = inner_html.html();
                            }
                        }
                    }
                    if(last_inner_html == '' || last_inner_html == undefined || $(last_inner_html).prop('tagName') == undefined) {
                        if ($(html_tag).prop('tagName') == undefined) {
                            txt = '<span id="current"> ' + text + ' </span>';
                        } else {
                            txt = editor.selection.text();
                            var html = $(editor.html.getSelected())[0].outerHTML;
                            if ($(html_tag).prop('tagName') == undefined) {
                                html = $(html).attr('id', 'current')[0].outerHTML;
                            } else {
                                html = $($(editor.html.getSelected())[0].outerHTML).attr('id', 'current')[0].outerHTML;
                            }
                            txt = html.replace(txt, ' ' + txt + ' ');
                        }
                    }else{
                        txt = editor.selection.text();
                        html = $(last_inner_html).attr('id', 'current')[0].outerHTML;
                        txt = html.replace(txt, ' ' + txt + ' ');
                        txt = $(editor.html.getSelected())[0].outerHTML.replace(last_inner_html,txt);
                    }
                    if(window.editor_type != 'cta'){
                         anchor_id = 'default_active';
                        cta_button = '';
                    }else{
                         anchor_id = 'cta_active';
                         cta_button = 'za_cta_style';
                    }
                    editor.html.insert('<a href="' + href + '" target="'+_target+'" class="'+cta_button+'" id="'+anchor_id+'">' + txt + '</a>');
                    editor.selection.restore();
                }
                else {

                    // Just wrap current image with a link.
                    $current_image.wrap('<a href="' + href + '"></a>');
                }

                // Set attributes.
                var links = allSelected();

                for (var i = 0; i < links.length; i++) {
                    $link = $(links[i]);
                    $link.attr(attrs);
                    $link.removeAttr('_moz_dirty');
                }

                // Show link edit if only one link.
                if (links.length == 1 && editor.$wp && !$current_image) {
                    $(links[0])
                        .prepend($.FE.START_MARKER)
                        .append($.FE.END_MARKER);

                    editor.selection.restore();
                }
            }

            // Hide popup and try to edit.
            if (!$current_image) {
                _edit();
            }
            else {
                var $pop = editor.popups.get('link.insert');

                if ($pop) {
                    $pop.find('input:focus').blur();
                }

                editor.image.edit($current_image);
            }
            var selection = editor.selection.get();
            var offset = selection.focusOffset-1;
            setCaretPosition(offset);

            window.cta_button = false;
            $(".fr-popup").remove();
        }

        function update () {
            _hideEditPopup();

            var link = get();

            if (link) {
                var $popup = editor.popups.get('link.insert');
                var html = $(editor.html.getSelected()).html();
                if(!$(link).hasClass('za_cta_style')){
                    window.editor_type = 'default';
                }else{
                    window.editor_type = 'cta';
                    if(window.global != 0){
                        window.global = 1;
                    }
                }
                $popup = _initInsertPopup();

                if (!editor.popups.isVisible('link.insert')) {
                    editor.popups.refresh('link.insert');
                    editor.selection.save();

                    if (editor.helpers.isMobile()) {
                        editor.events.disableBlur();
                        editor.$el.blur();
                        editor.events.enableBlur();
                    }
                }

                editor.popups.setContainer('link.insert', editor.$sc);
                var $ref = (editor.image ? editor.image.get() : null) || $(link);
                var left = $ref.offset().left + $ref.outerWidth() / 2;
                var top = $ref.offset().top + $ref.outerHeight();

                editor.popups.show('link.insert', left, top, $ref.outerHeight());
            }
        }

        function back () {
            var $current_image = editor.image ? editor.image.get() : null;

            if (!$current_image) {
                editor.events.disableBlur();
                editor.selection.restore();
                editor.events.enableBlur();

                var link = get();

                if (link && editor.$wp) {
                    editor.selection.restore();
                    _hideEditPopup();
                    _edit();
                }
                else if (editor.el.tagName == 'A') {
                    editor.$el.focus();
                    _edit();
                }
                else {
                    editor.popups.hide('link.insert');
                    editor.toolbar.showInline();
                }
            }
            else {
                editor.image.back();
            }
        }

        function imageLink () {
            var $el = editor.image ? editor.image.getEl() : null;

            if ($el) {
                var $popup = editor.popups.get('link.insert');

                if (editor.image.hasCaption()) {
                    $el = $el.find('.fr-img-wrap');
                }

                $popup = _initInsertPopup();
                _refreshInsertPopup(true);
                editor.popups.setContainer('link.insert', editor.$sc);
                var left = $el.offset().left + $el.outerWidth(true) / 2;
                var top = $el.offset().top + $el.outerHeight(true);
                editor.popups.show('link.insert', left, top, $el.outerHeight());
            }
        }

        /**
         * Apply specific style.
         */
        function applyStyle (val, linkStyles, multipleStyles) {
            if (typeof multipleStyles == 'undefined') multipleStyles = editor.opts.linkMultipleStyles;

            if (typeof linkStyles == 'undefined') linkStyles = editor.opts.linkStyles;
            var link = get();

            if (!link) return false;

            // Remove multiple styles.
            if (!multipleStyles) {
                var styles = Object.keys(linkStyles);
                styles.splice(styles.indexOf(val), 1);
                $(link).removeClass(styles.join(' '));
            }

            $(link).toggleClass(val);

            _edit();
        }

        function setCursorPos(input, start, end) {
            if (arguments.length < 3) end = start;
            if ("selectionStart" in input) {
                setTimeout(function() {
                    input.selectionStart = start;
                    input.selectionEnd = end;
                }, 1);
            }
            else if (input.createTextRange) {
                var rng = input.createTextRange();
                rng.moveStart("character", start);
                rng.collapse();
                rng.moveEnd("character", end - start);
                rng.select();
            }
        }

        return {
            _init: _init,
            remove: remove,
            _superFooterInsertPopup: superFooterInsertPopup,
            usePredefined: usePredefined,
            insertCallback: insertCallback,
            insert: insert,
            update: update,
            get: get,
            allSelected: allSelected,
            back: back,
            imageLink: imageLink,
            applyStyle: applyStyle
        }
    }

    // Register the link command.
    $.FE.DefineIcon("insertLink", {
        NAME: "link"
    })
        $.FE.RegisterCommand("insertLink", {
        title: "Insert Link",
        undo: !1,
        focus: false,
        refreshOnCallback: !1,
        popup: !0,
        callback: function() {
            window.editor_type  = 'default';
            this.zalink._superFooterInsertPopup();
        },
        plugin: "zalink"
    })
    $.FE.DefineIcon('linkEdit', { NAME: 'edit' });
    $.FE.RegisterCommand('linkEdit', {
        title: 'Edit Link',
        undo: false,
        refreshAfterCallback: false,
        popup: true,
        callback: function () {
            $(".fr-popup").remove();
            this.zalink.update();
        },
        refresh: function ($btn) {
            var link = this.zalink.get();

            if (link) {
                $btn.removeClass('fr-hidden');
            }
            else {
                $btn.addClass('fr-hidden');
            }
        },
        plugin: 'zalink'
    })

    $.FE.DefineIcon('linkRemove', { NAME: 'unlink' });
    $.FE.RegisterCommand('linkRemove', {
        title: 'Unlink',
        callback: function () {
            this.zalink.remove();
        },
        refresh: function ($btn) {
            var link = this.zalink.get();

            if (link) {
                $btn.removeClass('fr-hidden');
            }
            else {
                $btn.addClass('fr-hidden');
            }
        },
        plugin: 'zalink'
    })

    $.FE.DefineIcon('linkList', { NAME: 'search' });
    $.FE.RegisterCommand('linkList', {
        title: 'Choose Link',
        type: 'dropdown',
        focus: false,
        undo: false,
        refreshAfterCallback: false,
        html: function () {
            var c = '<ul class="fr-dropdown-list" role="presentation">';
            var options =  this.opts.linkList;

            for (var i = 0; i < options.length; i++) {
                c += '<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="linkList" data-param1="' + i + '">' + (options[i].displayText || options[i].text) + '</a></li>';
            }
            c += '</ul>';

            return c;
        },
        callback: function (cmd, val) {
            this.zalink.usePredefined(val);
        },
        plugin: 'zalink'
    })

    $.FE.RegisterCommand('linkInsert', {
        focus: false,
        refreshAfterCallback: false,
        callback: function () {
            this.zalink.insertCallback();
        },
        refresh: function ($btn) {
            var link = this.zalink.get();

            if (link) {
                $btn.text(this.language.translate('Update'));
            }
            else {
                $btn.text(this.language.translate('Insert'));
            }
        },
        plugin: 'zalink'
    })

    // Image link.
    $.FE.DefineIcon('imageLink', { NAME: 'link' })
    $.FE.RegisterCommand('imageLink', {
        title: 'Insert Link',
        undo: false,
        focus: false,
        popup: true,
        callback: function () {
            this.zalink.imageLink();
        },
        refresh: function ($btn) {
            var link = this.zalink.get();
            var $prev;

            if (link) {
                $prev = $btn.prev();

                if ($prev.hasClass('fr-separator')) {
                    $prev.removeClass('fr-hidden');
                }

                $btn.addClass('fr-hidden');
            }
            else {
                $prev = $btn.prev();

                if ($prev.hasClass('fr-separator')) {
                    $prev.addClass('fr-hidden');
                }

                $btn.removeClass('fr-hidden');
            }
        },
        plugin: 'zalink'
    })

    // Link styles.
    $.FE.DefineIcon('linkStyle', { NAME: 'magic' })
    $.FE.RegisterCommand('linkStyle', {
        title: 'Style',
        type: 'dropdown',
        html: function () {
            var c = '<ul class="fr-dropdown-list" role="presentation">';
            var options =  this.opts.linkStyles;

            for (var cls in options) {
                if (options.hasOwnProperty(cls)) {
                    c += '<li role="presentation"><a class="fr-command" tabIndex="-1" role="option" data-cmd="linkStyle" data-param1="' + cls + '">' + this.language.translate(options[cls]) + '</a></li>';
                }
            }
            c += '</ul>';

            return c;
        },
        callback: function (cmd, val) {
            this.zalink.applyStyle(val);
        },
        refreshOnShow: function ($btn, $dropdown) {
            var link = this.zalink.get();

            if (link) {
                var $link = $(link);

                $dropdown.find('.fr-command').each (function () {
                    var cls = $(this).data('param1');
                    var active = $link.hasClass(cls);
                    $(this).toggleClass('fr-active', active).attr('aria-selected', active);
                })
            }
        },
        plugin: 'zalink'
    })

}));

$(document).on('click','.nav-tabs li a',function(){
    $(".fr-popup").remove();
    if($(this).attr('href') == '#footer-tab'){
        window.global = 1;
        window.cta_label = 'Insert CTA Button';
    }else{
        window.global = 0;
        window.editor_type = 'cta';
       window.cta_label = 'Add CTA Link';
    }
});
$(document).on('change',".fr-popup.fr-active input[name='type_of_link']",function (){
    if($(this).attr('id') == 'outside_url'){
        $(".url_input").show();
    }else{
        $(".url_input").hide();
    }
});
$(document).on('mouseover','[data-cmd="insertCTALink"]',function (e){
    $(this).find('span').html(window.cta_label);
    $(".fr-tooltip").html(window.cta_label);
});
$(document).on('click','.za_cta_style',function() {
    $(".fr-popup").remove();
});

function setCaretPosition(pos)
{
    var el = document.querySelector("#cta_active #current");
    if(pos <= 0){
        pos = el.innerText.length-1;
    }
    // console.log(el.childNodes);
    // console.log(pos+' new position');
    // console.log(el);
    // console.log(el.childNodes.length);
    if(el) {
        var index = el.childNodes.length - 1;
        var range = document.createRange();
        var sel = window.getSelection();
        range.setStart(el.childNodes[index], pos);
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
        el.focus();
    }
}

function getCaretPosition () {
    var CaretPos = window.getSelection().anchorOffset;
    return CaretPos;
}
