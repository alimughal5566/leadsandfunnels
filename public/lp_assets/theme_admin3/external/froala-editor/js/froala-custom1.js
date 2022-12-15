//Getting Templates From ../json/templates.json File
var templates_json = (function () {
    var json = null;
    $.ajax({
        'async': false,
        'global': false,
        'url': site.baseUrl + "/lp_assets/theme_admin3/external/froala-editor/json/templates.json",
        'dataType': "json",
        'success': function (data) {
            json = data;
        }
    });
    return json;
})();
var font_object = {};
var arr = ['extra-content', 'footeroption', 'thankyoumessage', 'global'];
var super_footer = ['extra-content', 'footeroption', 'global', 'thankyoumessage', 'autoresponder'];
var show_video = ['footeroption', 'thankyoumessage'];
var show_cta = ['autoresponder', 'thankyoumessage', 'global'];
var global_setting = ['global'];
window.speacific_advance_footer = 0;
var is_image_del = true;
var stop_image_del = false;
window.cta_button = false;
window.lp_html_editor = "";
jQuery(document).ready(function () {
    var linkbutton = '';
    var fontSize = [];
    for (var i = 8; i <= 72; i++) {
        fontSize.push(i);
    }

    font_object = {
        "Abril Fatface": 'Abril Fatface',
        "Antic Slab": 'Antic Slab',
        "Anton": 'Anton',
        "Archivo Black": 'Archivo Black',
        "Arial": 'Arial',
        "Arvo": 'Arvo',
        "Berkshire Swash": 'Berkshire Swash',
        "Bevan": 'Bevan',
        "Bree Serif": 'Bree Serif',
        "Bungee Inline": 'Bungee Inline',
        "Cardo": 'Cardo',
        "Chela One": 'Chela One',
        "Chivo": 'Chivo',
        "Cinzel": 'Cinzel',
        "Coiny": 'Coiny',
        "Concert One": 'Concert One',
        "Cormorant": 'Cormorant',
        "Crimson Text": 'Crimson Text',
        "'Exo 2'": 'Exo 2',
        "Fira Sans": 'Fira Sans',
        "Fjalla One": 'Fjalla One',
        "Frank Ruhl Libre": 'Frank Ruhl Libre',
        "Fugaz One": 'Fugaz One',
        "Josefin Sans": 'Josefin Sans',
        "Judson": 'Judson',
        "Julius Sans One": 'Julius Sans One',
        "Kanit": 'Kanit',
        "Karla": 'Karla',
        "Kavoon": 'Kavoon',
        "Lato": 'Lato',
        "Libre Baskerville": 'Libre Baskerville',
        "Lobster": 'Lobster',
        "Lora": 'Lora',
        "Martel": 'Martel',
        "Merienda": 'Merienda',
        "Merriweather": 'Merriweather',
        "Monoton": 'Monoton',
        "Montserrat": 'Montserrat',
        "Notable": 'Notable',
        "Noto Sans": 'Noto Sans',
        "Nunito": 'Nunito',
        "Oleo Script": 'Oleo Script',
        "Open Sans": 'Open Sans',
        "Open Sans Condensed": 'Open Sans Condensed',
        "Orbitron": 'Orbitron',
        "Oswald": 'Oswald',
        "Oxygen": 'Oxygen',
        "Pacifico": 'Pacifico',
        "Palanquin": 'Palanquin',
        "Paytone One": 'Paytone One',
        "Permanent Marker": 'Permanent Marker',
        "Philosopher": 'Philosopher',
        "Playfair Display": 'Playfair Display',
        "Poiret One": 'Poiret One',
        "Poppins": 'Poppins',
        "PT Sans": 'PT Sans',
        "PT Serif": 'PT Serif',
        "Prata": 'Prata',
        "Quicksand": 'Quicksand',
        "Rajdhani": 'Rajdhani',
        "Rakkas": 'Rakkas',
        "Raleway": 'Raleway',
        "Roboto": 'Roboto',
        "Rock Salt": 'Rock Salt',
        "Rubik": 'Rubik',
        "Sintony": 'Sintony',
        "Source Sans Pro": 'Source Sans Pro',
        "Special Elite": 'Special Elite',
        "Spectral": 'Spectral',
        "Spirax": 'Spirax',
        "Ubuntu Condensed": 'Ubuntu Condensed',
        "Ultra": 'Ultra',
        "Work Sans": 'Work Sans'
    };


    $(function () {
        var chk = cta_super_footer = false;
        var fileuploadpath = 'footerimageupload';
        var fileremovepath = 'footerimageremove';
        for (var i = 0; i <= page.length; i++) {
            if (jQuery.inArray(page[i], arr) != '-1') {
                chk = true;
            }
        }
        for (var i = 0; i <= page.length; i++) {
            if (jQuery.inArray(page[i], super_footer) != '-1') {
                cta_super_footer = true;
            }
        }
        if (page[3] == "autoresponder") {
            window.global = 0;
            //custom font use for autoresponder
            font_object = {
                "Comic Sans MS": 'Comic Sans MS',
                "Garamond": 'Garamond',
                "Georgia": 'Georgia',
                "Tahoma ": 'Tahoma ',
                "Trebuchet MS": 'Trebuchet MS',
                "Verdana": 'Verdana',
            };
        }
        if (page[3] == "thankyoumessage") {
            window.global = 0;
        }
        for (var i = 0; i <= page.length; i++) {
            if (jQuery.inArray(page[i], global_setting) != '-1') {
                console.info(window.location.pathname);
                fileuploadpath = 'globalimageupload';
                fileremovepath = 'globalimageremove';
                setTimeout(function () {
                    $('#template_dropdown-1').hide();
                    if (window.location.pathname != '/lp/global') {
                        $('#insertCTALink-1').hide();
                    }
                }, 400);
            }
        }
        if ($("#global-section").find("#thankyou").length == 1) {
            chk = true;
        }
        if (chk) {
            FroalaEditor.DefineIcon('template_dropdown', {NAME: 'columns'});
            FroalaEditor.RegisterCommand('template_dropdown', {
                title: 'Select Templates',
                type: 'dropdown',
                focus: false,
                undo: false,
                refreshAfterCallback: true,
                options: {
                    'blank_template': 'Blank Template',
                    'branded_template': 'Co-Branded Template',
                    'cta_template_left_img': 'CTA Template (media left)',
                    'cta_template_right_img': 'CTA Template (media right)',
                    'default_template': 'Default Template',
                    'property_template': 'Property Template',
                    'property_template2': 'Property Template 2',
                    'review_template': 'Review Template',
                    'secure_clix_template': 'Secure-Clix Template',
                    'personally_branded': 'Personally Branded'

                },
                callback: function (cmd, val) {
                    insertTemplate(val, this);
                    jQuery('#templatetype').val(val);
                },
                // Callback on refresh.
                refresh: function ($btn) {
                },
                // Callback on dropdown show.
                refreshOnShow: function ($btn, $dropdown) {
                    console.log('do refresh when show');
                }
            });
        }
        // var $reviewblock_temp1 = "<div class='lp-contact-review'><div class='block-quote'><p>Our experience with John from XYZ Company was a breath of fresh air! With a super fast closing and great communication every step of the way, we couldn't ask for more. Thank you!</p></div><div class='desc'><span class='lp-contact-review__img'><img class='lozad' data-src='/images/advancedfooter/iconfinder_Woman.svg' alt='' title='' src='/images/advancedfooter/iconfinder_Woman.svg' data-loaded='true'></span><div class='info'><h6>Sally Q. Homebuyer</h6><p>First-time Homebuyer | Somewhere, California</p><div class = 'rating-wrapper'><img class='rating' src='/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='/images/advancedfooter/stars1.1.png'></div><p></p></div></div><div class='clearfix'></div></div>";
        // FroalaEditor.DefineIcon('insertReviewBlock', {NAME: 'quote-left'});
        // FroalaEditor.RegisterCommand('insertReviewBlock', {
        //     title: 'Insert Review Block',
        //     focus: true,
        //     undo: true,
        //     refreshAfterCallback: true,
        //     callback: function () {
        //        console.log (this.selection.text());
        //       this.html.insert($reviewblock_temp1);
        //       this.undo.saveStep();
        //       // this.cursor.enter(true);
        //       // this.selection.element();

        //       //this.selection.setBefore($('lp-contact-review'));
        //       // this.selection.setAfter($('.lp-contact-review blockquote'));
        //     }
        //   });

        var is_cta = false;
        for (var i = 0; i <= page.length; i++) {
            is_cta = true;
        }


        //currently hide pdf and upload file.
        //getPDF,insertFile

        // comment code by Muhammad Abdullah

        // if(is_video){
        //     var toolbarButtonsList = ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineClass', 'inlineStyle', 'paragraphStyle', 'lineHeight' , '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help' , 'html' , 'CTA' , 'insertCTALink' , 'template_dropdown',  'undo', 'redo' , '|', ];
        // } else {
        //     var toolbarButtonsList = ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineClass', 'inlineStyle', 'paragraphStyle', 'lineHeight' , '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'embedly', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help' , 'html' , 'CTA' , 'insertCTALink' , 'template_dropdown',  'undo', 'redo' , '|', ];
        // }

        // star popup = Muhammad Abdullah

        var toolbarButtonsList = ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'lineHeight', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink', 'insertImage', 'insertVideo', 'emoticons', 'insertHR', 'insertCTALink', 'html', 'undo', 'redo', 'starOption'];
        if (['extra-content', 'footeroption', 'thankyoumessage'].indexOf(page[3]) !== -1) {
            toolbarButtonsList = ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'color', 'lineHeight', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink', 'insertImage', 'insertVideo', 'emoticons', 'insertHR', 'insertCTALink', 'template_dropdown', 'html', 'undo', 'redo', 'starOption'];
        }
        var toolbarButtonListPopup = ['subscript', 'superscript', 'paragraphStyle', 'paragraphFormat', 'embedly', 'insertFile', '-', 'insertTable', 'selectAll', 'clearFormatting', 'spellChecker', 'help', 'specialCharacters'];

        // Define popup template.
        $.extend(FroalaEditor.POPUP_TEMPLATES, {
            "customPlugin.popup": '[_BUTTONS_]'
        });

        // Define popup buttons.

        $.extend(FroalaEditor.DEFAULTS, {
            popupButtons: toolbarButtonListPopup
        });

        // The custom popup is defined inside a plugin (new or existing).

        FroalaEditor.PLUGINS.customPlugin = function (editor) {
            // Create custom popup.
            function initPopup() {
                // Popup buttons.
                var popup_buttons = '';

                // Create the list of buttons.
                if (editor.opts.popupButtons.length > 1) {
                    popup_buttons += '<div class="fr-buttons">';
                    popup_buttons += editor.button.buildList(editor.opts.popupButtons);
                    popup_buttons += '</div>';
                }

                // Load popup template.
                var template = {
                    buttons: popup_buttons,
                };

                // Create popup.
                var $popup = editor.popups.create('customPlugin.popup', template);

                return $popup;
            }

            // Show the popup
            function showPopup() {
                // Get the popup object defined above.
                var $popup = editor.popups.get('customPlugin.popup');

                // We are removing previous popup (if exists) and generating
                // new popup because old popup gets in unstable state upon screen
                // resizing and the separtor element get removed from popup, so to
                // fix this issue we generator new popup
                if ($popup && $popup.length) {
                    $popup.remove();
                }
                // Generating new popup
                $popup = initPopup();

                // Set the editor toolbar as the popup's container.
                editor.popups.setContainer('customPlugin.popup', editor.$tb);

                // This will trigger the refresh event assigned to the popup.
                // editor.popups.refresh('customPlugin.popup');

                // This custom popup is opened by pressing a button from the editor's toolbar.
                // Get the button's object in order to place the popup relative to it.
                var $btn = editor.$tb.find('.fr-command[data-cmd="starOption"]');

                // Set the popup's position.
                var left = $btn.offset().left + $btn.outerWidth() / 2;
                var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);

                // Show the custom popup.
                // The button's outerHeight is required in case the popup needs to be displayed above it.
                editor.popups.show('customPlugin.popup', left, top, $btn.outerHeight());
            }

            // Hide the custom popup.
            function hidePopup() {
                editor.popups.hide('customPlugin.popup');
            }

            // Methods visible outside the plugin.
            return {
                showPopup: showPopup,
                hidePopup: hidePopup
            }
        }

        // Define an icon and command for the button that opens the custom popup.

        FroalaEditor.DefineIcon('buttonIcon', {NAME: 'star'});
        FroalaEditor.RegisterCommand('starOption', {
            title: 'More Options',
            icon: 'buttonIcon',
            undo: false,
            focus: false,
            plugin: 'customPlugin',
            callback: function () {
                this.customPlugin.showPopup();
            }
        });

        if (is_cta) {
            FroalaEditor.DefineIcon('insertCTALink', {NAME: 'arrow-right'});
            FroalaEditor.RegisterCommand('insertCTALink', {
                title: 'Add CTA Link',
                focus: true,
                undo: true,
                refreshAfterCallback: true,
                callback: function () {
                    window.editor_type = 'cta';
                    if (cta_super_footer) {
                        this.popups.isVisible("link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("link.insert")) : this.zalink._superFooterInsertPopup();
                    } else {
                        this.popups.isVisible("link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("link.insert")) : this.link._showInsertPopup();
                    }
                    //console.info(this.link.get());
                },
                refresh: function () {
                    //this.link.get().addStyle('cta_text_style');
                    if (this.zalink && cta_super_footer) {
                        _link = this.zalink.get();
                    } else {
                        _link = this.link.get();
                    }
                    // console.log(_link);
                    // console.log(linkbutton);
                    if (typeof (linkbutton) != "undefined" && linkbutton !== null && linkbutton == 'insertCTALink') {
                        if (this.link && window.global == 0) {
                            /*jQuery(_link).css({
                                'padding': '0.5em 1em',
                                'border-radius': '50px',
                                'line-height': '1',
                                'background-color': 'rgb(255, 135, 0)',
                                'border': '2px solid rgb(255, 135, 0)',
                                'color': '#ffffff !important',git
                                'text-decoration': 'none',
                                'text-align': 'center',
                                'margin-top': '4px',
                                '-webkit-box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)',
                                '-moz-box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)',
                                'box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)',
                                'vertical-align': 'middle',
                                '-ms-touch-action': 'manipulation',
                                'touch-action': 'manipulation',
                                'background-image': 'none',
                                'position': 'relative',
                                'z-index': '100',
                                'display': 'inline-block'
                            });*/
                            jQuery(_link).addClass("za_cta_style current");
                        }
                        linkbutton = '';
                    }
                },
                plugin: "link"

            });
            is_cta = false;
        }
        // FroalaEditor.DefineIcon('insertCTALink2', {NAME: 'arrow-right'});
        // FroalaEditor.RegisterCommand('insertCTALink2', {
        //     title: 'Add CTA Link2',
        //     focus: true,
        //     undo: true,
        //     refreshAfterCallback: true,
        //     callback: function() {
        //         this.popups.isVisible("link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("link.insert")) : this.zalink._superFooterInsertPopup('cta');
        //         //console.info(this.link.get());
        //     },
        //     refresh: function() {
        //         //this.link.get().addStyle('cta_text_style');
        //         _link = this.zalink.get();
        //         if(typeof(linkbutton ) != "undefined" && linkbutton  !== null && linkbutton == 'insertCTALink') {
        //             jQuery(_link).css({'font-family': '"Open Sans", sans-serif','padding': '0.5em 1em','border-radius': '50px','line-height': '1','background-color': 'rgb(255, 135, 0)','border': '2px solid rgb(255, 135, 0)','text-transform': 'uppercase','color': '#ffffff','font-weight': '700','text-decoration': 'none','text-align': 'center','margin': 'auto','margin-bottom': '0','-webkit-box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)','-moz-box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)','box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)','vertical-align': 'middle','-ms-touch-action': 'manipulation','touch-action': 'manipulation','background-image': 'none','position': 'relative','z-index': '100','display': 'inline-block'});
        //             jQuery(_link).addClass("cta_style");
        //             jQuery(_link).find("span").css('color','#ffffff');
        //             linkbutton = '';
        //         }
        //     },
        //     plugin: "link"
        //
        // });

        //if insertCTALink option does not enable then it will be enable
        if (is_cta) {
            FroalaEditor.DefineIcon('CTA', {NAME: 'arrow-right'});
            FroalaEditor.RegisterCommand('CTA', {
                title: 'Add CTA Button',
                focus: true,
                undo: true,
                refreshAfterCallback: true,
                callback: function () {
                    if (this.html.getSelected() != '') {
                        var $ctatext = this.selection.text();
                        var $addcta = '<a href="#GetStartedNow">' + $ctatext + '</a>';
                        var $ctahtml = this.html.getSelected();
                        $ctahtml = $ctahtml.replace($ctatext, $addcta);
                        this.html.insert($ctahtml);
                        // this.undo.saveStep();
                    }
                }
            });
        }

        // var $startrating = '<div class = "rating-wrapper"><img class="rating" src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png"></div>';
        // FroalaEditor.DefineIcon('startrating', {NAME: 'star'});
        // FroalaEditor.RegisterCommand('startrating', {
        //     title: 'Add Star Rating',
        //     focus: true,
        //     undo: true,
        //     refreshAfterCallback: true,
        //     callback: function () {
        //         console.info("test");
        //       this.html.insert($startrating);
        //       this.undo.saveStep();
        //     }
        //   });

        function getFroalaCursorState(prevState, defaultFocusParent) {
            var selection = window.getSelection();
            return {
                prevNode: prevState.currentNode || defaultFocusParent.childNodes[0],
                prevOffset: prevState.currentOffset || 0,
                currentNode: selection.focusNode || defaultFocusParent.childNodes[0],
                currentOffset: selection.focusOffset || 0
            }
        }

        var froalaCursorState = getFroalaCursorState({}, document.body)

        $(document).on('lpFroalaEditorUpdateCurrentNode', function () {
            froalaCursorState = getFroalaCursorState(froalaCursorState, $('.fr-element.fr-view').get(0))
        });


        function getClosestCtaBtn(node, stopNode) {
            if (!stopNode) {
                stopNode = document.body;
            }

            if (node.nodeType !== Node.TEXT_NODE && node.classList.contains('za_cta_style')) {
                return node
            }

            if (node === stopNode) {
                return null
            }

            var parentNode = node.parentNode;
            while (parentNode) {
                if (parentNode === document.body) {
                    return null
                }
                if (parentNode.classList.contains('za_cta_style')) {
                    return parentNode
                }
                parentNode = parentNode.parentNode;
            }

            return null
        }

        function findTextNode(node, returnLast) {
            var nodePos = 'firstChild';
            if (returnLast) {
                nodePos = 'lastChild';
            }

            if (!node) {
                return null
            }

            if (node.nodeType === Node.TEXT_NODE) {
                return node
            }

            var targetNode = node[nodePos]
            while (targetNode) {
                if (targetNode.nodeType === Node.TEXT_NODE) {
                    return targetNode
                }

                targetNode = targetNode[nodePos]
            }

            return null
        }

        /**
         * It would traverse decendent dom tree and find a phone number and would
         * make it a link
         */
        function makePhoneClickableInTree(parentElement) {
            // return if element if undefined ot has no childs
            if (!parentElement || !parentElement.childNodes.length) return;

            // traverse through all its child and find a phone number
            parentElement.childNodes.forEach(function (currentNode) {
                // if current node is a link we skip it
                if (currentNode.nodeName.toLowerCase() === 'a') {
                    return
                }

                // if we find a text node, we search it for phone number
                if (currentNode.nodeType === Node.TEXT_NODE) {
                    // made the regex less strict to detect phone numbers in different format
                    var phoneRegex = /\(\s*(\d{3})\s*\)[ \xa0\-_]{0,3}(\d{3})([ \xa0\.\-\_])[ \xa0\.\-\_]{0,2}(\d{4})|(\d{3})([ \xa0\.\-\_])[ \xa0\.\-\_]{0,2}(\d{3})([ \xa0\.\-\_])[ \xa0\.\-\_]{0,2}(\d{4})/g
                    var match = null

                    // for each match we get in the text node
                    while (match = phoneRegex.exec(currentNode.textContent)) {

                        var phone = '';
                        var unformattedPhone = match[0];
                        // we make a phone string from selected parts
                        if (match[1]) {
                            // the phone number has parenthsis and other allowed characters
                            phone = `(${match[1]}) `
                            for (var i = 2; i <= 4; i++) {
                                phone += match[i]
                            }
                        } else {
                            // the phone number is without parenthesis and other allowed characters
                            for (var i = 5; i <= 9; i++) {
                                phone += match[i]
                            }
                        }

                        // get the match index in string
                        var startIndex = match.index;

                        // split that portion of string which contain phone number
                        // and make it a new node
                        var phoneNode = currentNode.splitText(startIndex);
                        phoneNode.splitText(unformattedPhone.length);

                        // create a link element and populate phone number information
                        var linkNode = document.createElement('a');
                        linkNode.href = "tel:" + phone;
                        linkNode.textContent = phone;
                        linkNode.classList.add('lp-fr-phone-link');

                        // wrap the phone number text node with newly created link
                        // and add the link as child to parent node
                        phoneNode.parentNode.replaceChild(linkNode, phoneNode);
                    }
                } else {
                    // if it is not a text node, recurse into its child node
                    makePhoneClickableInTree(currentNode)
                }
            })
        }

        var $froalaTextBox = $('.lp-froala-textbox');

        $froalaTextBox.on('froalaEditor.initialized', function () {
            $('#dropdown-menu-fontFamily-1 .fr-command').click(function (e) {
                var font_family = $(this).css('font-family');
                $("#fontFamily-1 span").css({'font-family': font_family});
            });
        })

        lp_html_editor = new FroalaEditor(".lp-froala-textbox", {
            key: froala_key,
            iconsTemplate: 'font_awesome',
            autofocus: true,
            //toolbarInline: false,
            // Set the image upload URL.
            htmlRemoveTags: [],
            imageUploadURL: site.baseUrl + '/lp/popadmin/' + fileuploadpath,
            // Set the file upload URL.
            fileUploadURL: site.baseUrl + '/lp/popadmin/' + fileuploadpath,
            // Additional upload params.
            imageUploadParams: {
                id: 'footer_image',
                uploadtype: jQuery("#uploadtype").val(),
                current_hash: jQuery("#current_hash").val(),
                client_id: jQuery("#client_id").val(),
                _token: ajax_token
            },
            // Additional upload params.
            fileUploadParams: {
                id: 'footer_compliance_text',
                uploadtype: 'file',
                current_hash: jQuery("#current_hash").val(),
                client_id: jQuery("#client_id").val(),
                _token: ajax_token
            },
            linkList: [
                {
                    text: 'Google',
                    href: 'http://google.com',
                    target: '_blank',
                    rel: 'nofollow'
                }
                // {
                //   displayText: 'Get Started Now',
                //   href: '#GetStartedNow',
                // }
            ],
            // Set request type.
            imageUploadMethod: 'POST',
            // Set request type.
            fileUploadMethod: 'POST',
            // Set max image size to 5MB.
            imageMaxSize: 2 * 1024 * 1024,
            // Set max file size to 20MB.
            fileMaxSize: 1024 * 1024 * 5,
            //fileUseSelectedText: true,
            // Allow to upload PNG and JPG.
            imageAllowedTypes: ['gif', 'jpeg', 'jpg', 'png'],
            // Allow to upload any file.
            //fileAllowedTypes: ["txt","doc","pdf","json","html"],
            fileAllowedTypes: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel'],
            // Set the video upload URL.
            videoUploadURL: 'https://myleads.leadpops.com/lp/popadmin/footervideoupload/',
            videoResponsive: true,
            videoUploadParams: {
                id: 'footer_compliance_text'
            },
            videoAllowedProviders: ['.*'],
            /*height: 250,*/
            heightMin: 250,
            //fullPage: true,
            tableStyles: {
                'fr-dashed-borders': 'Dashed Borders',
                'fr-alternate-rows': 'Alternate Rows',
                'fr-thick': 'Thick Borders',
                'fr-no-border': 'No Borders'
            },
            imageDefaultDisplay: "inline",
            charCounterCount: false,
            enter: FroalaEditor.ENTER_DIV,
            listAdvancedTypes: true,
            // toolbarButtonsSM: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo', 'insertReviewBlock'],
            // toolbarButtonsXS: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo', 'insertReviewBlock'],
            //toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '|', 'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html']

            toolbarButtons: toolbarButtonsList,
            imageEditButtons: ['insertImage', 'imageReplace', 'imageAlign', 'imageCaption', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'],
            /*toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
            toolbarButtonsMD: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
            toolbarButtonsSM: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
            toolbarButtonsXS: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo']*/
            fontSize: fontSize,
            fontFamily: font_object,
            fontFamilySelection: true,
            events: {
                //File Functions
                'file.beforeUpload': function (files) {
                    // Return false if you want to stop the file upload.
                    console.log('files', files);
                },
                'file.inserted': function ($file, response) {
                    // File was inserted in the editor.
                    console.log('Inserted file', $file);
                    console.log('Inserted responce', response);
                },
                'file.unlink': function (link) {
                    // $.ajax({
                    //     // Request method.
                    //     method: 'POST',
                    //
                    //     // Request URL.
                    //     url: "https://myleads.leadpops.com/lp/popadmin/footerimageremove",
                    //
                    //     // Request params.
                    //     data: {
                    //         src: file.getAttribute('href')
                    //     }
                    // })
                    //     .done(function(data) {
                    //         console.log('File was deleted');
                    //     })
                    //     .fail(function(err) {
                    //         console.log('File delete problem: ' + JSON.stringify(err));
                    //     })
                },
                'file.error': function (error, response) {
                    let message = error.message;
                    if (error.code === 6) {
                        message = 'PDF, Microsoft Word, Microsoft Excel, Microsoft PowerPoint file type allowed.';
                    }
                    editor.popups.areVisible()
                        .find('.fr-file-progress-bar-layer.fr-error .fr-message')
                        .text(message);
                },

                //Image Functions
                'image.beforeUpload': function (images) {
                    // Return false if you want to stop the image upload.
                    console.log(images);
                },
                'image.uploaded': function (response) {
                    // Image was uploaded to the server.
                    console.info("test");
                    console.log(response);
                },
                'image.inserted': function ($img, response) {
                    // Image was inserted in the editor.
                    console.log($img);
                    console.log(response);
                },
                'image.replaced': function ($img, response) {
                    // Image was replaced in the editor.
                    console.log($img);
                    console.log(response);
                },
                'image.error': function (editor, error) {
                    // Bad link.\
                    console.log('Error code is ' + error.code + ' and  error message is ' + error.message);
                    if (error.code == 5) {
                        editor.popups.areVisible()
                            .find('.fr-image-progress-bar-layer.fr-error .fr-message')
                            .text("The file is too large. Maximum allowed file size is 2MB.");
                    }
                },
                'image.removed': function ($img) {
                    if (is_image_del) {
                        /*
                        * Note: We don't delete the images which are uploaded to froala editor because when user delete image mistakenly then user do CTRL+Z image will back on editor but its delete from rackspace
                        * */
                        if (stop_image_del) {
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

                },

                //Video Functions
                'video.beforeRemove': function ($video) {
                    /*src=$($('#footer_compliance_text').froalaEditor('selection.element')).find('video').attr('src');
                    console.log('video src',src);*/
                },
                'video.removed': function ($video) {
                    $.ajax({
                        // Request method.
                        method: "POST",
                        // Request URL.
                        url: site.baseUrl + '/lp/popadmin/footerimageremove',
                        // Request params.
                        data: {
                            src: $video.attr('src'),
                            current_hash: jQuery("#current_hash").val(),
                            _token: ajax_token
                        }
                    }).done(function (data) {
                        console.log('image was deleted');
                    })
                    .fail(function () {
                        console.log('image delete problem');
                    })
                },

                // link Functions
                'link.beforeInsert': function (link, text, attrs) {
                    // console.info(link);
                    // $(link).each(function(){
                    //       if($('> span',this).length >= 1)
                    //       {
                    //          alert('has span');
                    //       } else {
                    //          alert('dont has span');
                    //       }
                    //   });
                },

                // URL Functions
                'url.linked': function (link) {
                    //console.info(link);
                },

                // Commands Functions
                'commands.before': function (cmd, param1, param2) {
                    ctapopup = false;
                    if (cmd == 'insertCTALink') {
                        ctapopup = true;
                    }
                    // if (ctapopup && cmd == 'insertLink'){
                    //     linkbutton = 'insertCTALink';
                    // }else
                    if (window.editor_type == 'cta' && cmd == 'linkInsert') {
                        linkbutton = 'insertCTALink';
                    } else {
                        linkbutton = '';
                    }
                },
                'commands.after': function (cmd) {
                    if (cmd === 'imageAlign') {
                        var imageSrc = editor.image.get();
                        if ($(imageSrc).hasClass('fr-fil') || $(imageSrc).hasClass('fr-fir')) {
                            $($(imageSrc).parent($(imageSrc).parent()[0].tagName)).removeAttr('style');
                        } else {
                            $(imageSrc).parent($(imageSrc).parent()[0].tagName).css({'text-align': 'center'});
                            let imageOffset = $(imageSrc);
                            $(imageSrc).click();
                        }
                    }
                    if (cmd == 'linkRemove') {
                        $(".fr-popup").removeClass('fr-active');
                    }
                    //user for super footer cta link
                    if (cmd == 'linkEdit') {
                        _initSelector();
                    }

                    /*
                    * Make clickable checkbox of froala achor pop-up
                    * */
                    $(".fr-checkbox span").css('cursor', 'pointer');
                    $(".fr-checkbox span").unbind('click').bind('click', function () {
                        $(this).parents('.fr-checkbox-line').find("label").trigger('click');
                    });

                    if (cmd == 'insertCTALink') {
                        linkbutton = cmd;
                    }
                },

                // Commands Functions
                'click': function (keydownEvent) {
                    window.cta_button = false;
                    // TODO: We will remove the code after move on the production
                    // if (this.zalink && cta_super_footer) {
                    //     _link = editor.zalink.get();
                    // } else {
                    //     _link = editor.link.get();
                    // }
                    // var el = '';
                    // if(jQuery(_link).hasClass('current')){
                    //     el = $(".current");
                    //     el = el.text();
                    // }
                    // else{
                    //     $(".za_cta_style").removeClass('current');
                    //     $(_link).addClass('current');
                    //     el = $(".current");
                    //     el = el.text();
                    // }
                    // console.log('click');
                    // console.log(el.length);
                    // console.log(getCaretPosition());
                    // if(el &&  el.length == getCaretPosition()) {
                    //     console.log('add space');
                    //     insertLink(_link, editor, el.length+1);
                    // }
                    setTimeout(function () {
                        var font_family = $("#fontFamily-1 span").text();
                        $("#fontFamily-1 span").css({'font-family': font_family});
                    }, 200);

                },

                // Keydown Functions
                'keydown': function (keydownEvent) {
                    window.cta_button = false;

                    var keyCode = keydownEvent.which || keydownEvent.keyCode;
                    var key = keydownEvent.key;
                    /**
                     * Following keys are escape keys, only these keys should allow the cursor to
                     * move out of CTA button
                     *
                     * key 9: tab
                     * key 13: enter
                     * key 37: arrow left
                     * key 38: arrow up
                     * key 39: arrow right
                     * key 40: arrow down
                     */
                    if ([9, 13, 37, 38, 39, 40].indexOf(keyCode) < 0) {
                        var selection = window.getSelection();
                        var ctaBtn = getClosestCtaBtn(selection.focusNode, keydownEvent.target);

                        var isCombination = keydownEvent.ctrlKey || keydownEvent.altKey || keydownEvent.metaKey;

                        if (!isCombination && ctaBtn && key.length === 1 && selection.focusNode.nodeType === Node.TEXT_NODE) {
                            e.preventDefault();
                            keydownEvent.preventDefault()
                            var text = selection.focusNode.textContent;
                            var offset = selection.focusOffset;
                            text = text.substring(0, offset) + key + text.substring(offset);
                            selection.focusNode.textContent = text;
                            selection.collapse(selection.focusNode, offset + 1);
                        }
                    }

                    /**
                     * If the cursor is in CTA, then
                     * 1) on space key,space should be added to CTA button
                     * 2) on backspace key, the cursor should move to correct place where character was deleted
                     *
                     * key 8: backspace,
                     * key 32: space
                     *
                     * TODO: backspace cursor control functionality is not working in all cases
                     * on all browsers, need to fix this, this is currently on standby for later fix
                     */
                    if ([8, 32].indexOf(keyCode) > -1) {
                        var ctaBtn = getClosestCtaBtn(froalaCursorState.currentNode, keydownEvent.target)
                        if (ctaBtn) {
                            var currentNode = froalaCursorState.currentNode;
                            var currentOffset = froalaCursorState.currentOffset;

                            if (
                                currentOffset === 0 &&
                                currentNode === ctaBtn.firstChild
                            ) {
                                if (keyCode === 8) {
                                    var ctaPrevSibling = ctaBtn.previousSibling;
                                    if (ctaPrevSibling) {
                                        var siblingLastTextNode = findTextNode(ctaPrevSibling, true);
                                        if (siblingLastTextNode) {
                                            window.getSelection().collapse(siblingLastTextNode, siblingLastTextNode.length)
                                        }
                                    }
                                } else if (keyCode === 32) {

                                    var textNode = findTextNode(currentNode)

                                    textNode.textContent = '\xa0' + textNode.textContent
                                    window.getSelection().collapse(textNode, 1);
                                    ctaBtn.focus()
                                }

                            } else if (
                                currentNode === ctaBtn ||
                                currentNode === ctaBtn.lastChild
                            ) {
                                var textNode = findTextNode(currentNode, true)

                                var textNodeOffset = currentOffset;
                                if (currentNode.nodeType !== Node.TEXT_NODE) {
                                    textNodeOffset = Array.prototype.indexOf.call(textNode.parentNode.childNodes, textNode)
                                }

                                if (currentOffset === textNode.length || textNodeOffset === currentOffset - 1) {
                                    textNode.textContent = textNode.textContent + '\xa0';
                                    window.getSelection().collapse(textNode, textNode.length);
                                    ctaBtn.focus()
                                }
                            }
                        }
                    }
                    //TODO: We will remove the code after move on the production
                    //for backspace and delete key
                    // if(keydownEvent.keyCode == 8 || keydownEvent.keyCode  == 46) {
                    //     if (this.zalink && cta_super_footer) {
                    //         _link = editor.zalink.get();
                    //     } else {
                    //         _link = editor.link.get();
                    //     }
                    //     var el = $(".current");
                    //     if(el) {
                    //         console.log('remove');
                    //         console.log(el);
                    //         var str = el.html();
                    //         if (str && !str.endsWith("&nbsp;")) {
                    //             insertLink(_link, editor, el.text().length);
                    //         }
                    //     }
                    // }
                },

                // HTML Functions
                'html.set paste.after': function (editor) {
                    var editorEl = editor.$el.get(0)
                    makePhoneClickableInTree(editorEl)
                },
                'input paste.after': function (editor) {

                    var selection = editor.selection.get();

                    if (!selection) return; // focus is out of editor or on iframe

                    var currentElement = editor.selection.element();

                    if ($(currentElement).closest('a').length) return; // we are already in a phone link

                    if (selection.anchorNode !== selection.focusNode) return; // text is split into multiple elements

                    var currentTextNode = selection.focusNode;

                    if (currentTextNode.nodeType != Node.TEXT_NODE) return; // return if node is not of text type

                    var phoneRegex = /\(\d{3}\)[ \xa0]{1,3}\d{3}-\d{4}|\d{3}\.\d{3}\.\d{4}|\d{3}\-\d{3}\-\d{4}/g

                    var match = null

                    while (match = phoneRegex.exec(currentTextNode.textContent)) {

                        var phone = match[0];
                        var startIndex = match.index;

                        var phoneNode = currentTextNode.splitText(startIndex);
                        phoneNode.splitText(phone.length);

                        var linkNode = document.createElement('a');
                        linkNode.href = "tel:" + phone;
                        linkNode.textContent = phone;
                        linkNode.classList.add('lp-fr-phone-link');

                        phoneNode.parentNode.replaceChild(linkNode, phoneNode);

                        editor.selection.setAfter(linkNode)

                    }

                    editor.selection.restore()
                }
            }
        })

        $('.fr-element.fr-view').on('keyup click contextmenu', function (e) {
            froalaCursorState = getFroalaCursorState(froalaCursorState, this)
        })

        var advancehtml = lp_html_editor.html.get().length;
        if ($('.local-super-footer .lp-froala-textbox').length && advancehtml == 0) {
            window.speacific_advance_footer = 1;
            insertTemplate('default_template');
            // $('.local-super-footer .lp-froala-textbox').froalaEditor('html.set', $('#default-html').html());
        } else {
            //console.info("local-super-footer asd");
        }

        /*$('#footer_license_text').froalaEditor({
        theme: "dark",
        //toolbarInline: false,
        height: 200
        });*/
    });

    $("a[href='#GetStartedNow']").click(function () {
        $("html, body").animate({scrollTop: 0}, "slow");
        if (jQuery('#enteryourzipcode').val() == '') {
            jQuery('#enteryourzipcode').select();
        }
        return false;
    });

});

jQuery(window).on('load', function () {
    font_load();
});

function font_load() {
    var a = [];
    $.each(font_object, function (index, value) {
        a.push(value);
    });

    WebFontConfig = {
        google: {families: a}
    };

    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = true;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
}

//user for super footer cta link
function _initSelector() {
    var url = $(".fr-popup.fr-active input[name='href']").val();
    if (url && $.inArray(url, ["#GetStartedNow", '#top']) == -1) {
        $(".fr-popup.fr-active .url_input").show();
        $(".fr-popup.fr-active #outside_url").prop("checked", "checked");
    } else {
        $(".fr-popup.fr-active .url_input").hide();
        $(".fr-popup.fr-active #top_funnel").prop("checked", "checked");
    }
}

//TODO: We will remove the code after move on the production

/**
 * insert link with exta space in CTA Button
 * @param _link url html
 * @param editor
 * @param type keydown,click
 */
function insertLink(_link, editor, type) {
    var txt = '';
    txt = $(_link).text().trim();
    if ($(_link).hasClass('za_cta_style') && window.cta_button == false) {

        var replaceText = '&nbsp;' + txt + '&nbsp;';
        // var replaceText = txt;
        // if(!txt.match(/[\xa0\ \t]$/)){
        //     replaceText = replaceText + '\xa0';
        // }

        // if(!txt.match(/^[\xa0\ \t]/)){
        //     replaceText = '\xa0' + replaceText;
        // }


        // if(replaceText != txt){
        txt = $(_link).html().replace(txt, replaceText);
        $(_link).html(txt);
        setCaretPosition(type);
        // }
        window.cta_button = true;
    }
}

/**
 * insert selected template in froala editor
 * @param val
 */
function insertTemplate(val, editor) {
    var type = 'insert';
    if (editor === undefined) {
        type = 'set';
    }
    editor = lp_html_editor;

    /**
     * The purpose of this variable is to load template only related to currently loaded page
     * its value will be 'footer' on footer page and 'thank-you-message' on thank you message page
     * the data value is defined in footeroption.js and thankyoumesssage.js
     * this change was in accordance with requirement mentioned on A30-2090 to seperate the templates
     * for both pages so that they can contain different content based on the page.
     * if in future the template content gets changed for both pages,
     * please use this varaible to load template conditionally according to loaded page
     */
    var loadTemplateFor = $(document).data('lpFroalaEditorLoadTemplateFor');

    //Getting Templates keys from templates_json that one is getting from the templates.json file.
    var templates = Object.keys(templates_json);

    if (val == 'blank_template') {
        editor.html.set('');
        is_image_del = false;
    }
    if (templates.includes(val)) {
        var get_html = editor.html.get();
        editor.html.set(get_html + templates_json[val]);
    }
}
