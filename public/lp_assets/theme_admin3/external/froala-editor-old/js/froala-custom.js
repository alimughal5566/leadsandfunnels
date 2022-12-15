var font_object = {};
var arr = ['extra-content','footeroption','thankyoumessage','global'];
var super_footer = ['extra-content','footeroption','global','thankyoumessage','autoresponder'];
var show_video = ['footeroption','thankyoumessage'];
var show_cta = ['autoresponder','thankyoumessage','global'];
var global_setting = ['global'];
window.speacific_advance_footer = 0;
var is_image_del = true;
var stop_image_del = false;
window.cta_button = false;
jQuery(document).ready(function() {
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
        "Oxygen" : 'Oxygen',
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


    $(function() {
        var chk = cta_super_footer =  false;
        var fileuploadpath = 'footerimageupload';
        var fileremovepath = 'footerimageremove';
        for(var i = 0; i <= page.length; i++){
            if(jQuery.inArray( page[i], arr ) != '-1'){
                chk = true;
            }
        }
        for(var i = 0; i <= page.length; i++){
            if(jQuery.inArray( page[i], super_footer ) != '-1'){
                cta_super_footer = true;
            }
        }
        if(page[3] == "autoresponder"){
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
        if(page[3] == "thankyoumessage"){
            window.global = 0;
        }
        for(var i = 0; i <= page.length; i++){
            if(jQuery.inArray( page[i], global_setting ) != '-1'){
                console.info(window.location.pathname);
                fileuploadpath = 'globalimageupload';
                fileremovepath = 'globalimageremove';
                setTimeout(function () {
                    $('#template_dropdown-1').hide();
                    if(window.location.pathname != '/lp/global'){
                        $('#insertCTALink-1').hide();
                    }
                },400);
            }
        }
        if($("#global-section").find("#thankyou").length == 1) {
            chk = true;
        }
        if(chk) {
            $.FroalaEditor.DefineIcon('template_dropdown', {NAME: 'columns'});
            $.FroalaEditor.RegisterCommand('template_dropdown', {
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
                   insertTemplate(val,this);
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
        // $.FroalaEditor.DefineIcon('insertReviewBlock', {NAME: 'quote-left'});
        // $.FroalaEditor.RegisterCommand('insertReviewBlock', {
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
        for(var i = 0; i <= page.length; i++){
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

        var toolbarButtonsList = [ 'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize','color', 'lineHeight', 'align', 'formatOL', 'formatUL', 'outdent', 'indent','insertLink','insertImage','insertVideo','emoticons', 'insertHR','insertCTALink', 'html' , 'undo','redo', 'starOption' ];
        if(['extra-content', 'footeroption','thankyoumessage'].indexOf(page[3]) !== -1) {
        toolbarButtonsList     = [ 'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize','color', 'lineHeight', 'align', 'formatOL', 'formatUL', 'outdent', 'indent','insertLink', 'insertImage','insertVideo','emoticons', 'insertHR','insertCTALink', 'template_dropdown', 'html' ,'undo',  'redo','starOption' ];
        }
       var toolbarButtonListPopup = [ 'subscript','superscript','paragraphStyle','paragraphFormat','embedly', 'insertFile','-', 'insertTable', 'selectAll', 'clearFormatting','spellChecker', 'help' , 'specialCharacters'];

        // Define popup template.
        $.extend($.FroalaEditor.POPUP_TEMPLATES, {
            "customPlugin.popup": '[_BUTTONS_]'
        });

        // Define popup buttons.

        $.extend($.FroalaEditor.DEFAULTS, {
            popupButtons: toolbarButtonListPopup
        });

        // The custom popup is defined inside a plugin (new or existing).

        $.FroalaEditor.PLUGINS.customPlugin = function (editor) {
            // Create custom popup.
            function initPopup () {
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
            function showPopup () {
                // Get the popup object defined above.
                var $popup = editor.popups.get('customPlugin.popup');

                // We are removing previous popup (if exists) and generating
                // new popup because old popup gets in unstable state upon screen
                // resizing and the separtor element get removed from popup, so to
                // fix this issue we generator new popup
                if($popup && $popup.length){
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
            function hidePopup () {
                editor.popups.hide('customPlugin.popup');
            }

            // Methods visible outside the plugin.
            return {
                showPopup: showPopup,
                hidePopup: hidePopup
            }
        }

        // Define an icon and command for the button that opens the custom popup.

        $.FroalaEditor.DefineIcon('buttonIcon', { NAME: 'star'});
        $.FroalaEditor.RegisterCommand('starOption', {
            title: 'More Options',
            icon: 'buttonIcon',
            undo: false,
            focus: false,
            plugin: 'customPlugin',
            callback: function () {
                this.customPlugin.showPopup();
            }
        });

        if(is_cta){
            $.FroalaEditor.DefineIcon('insertCTALink', {NAME: 'arrow-right'});
            $.FroalaEditor.RegisterCommand('insertCTALink', {
                title: 'Add CTA Link',
                focus: true,
                undo: true,
                refreshAfterCallback: true,
                callback: function() {
                    window.editor_type = 'cta';
                    if(cta_super_footer){
                        this.popups.isVisible("link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("link.insert")) : this.zalink._superFooterInsertPopup();
                    }else {
                        this.popups.isVisible("link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("link.insert")) : this.link._showInsertPopup();
                    }
                    //console.info(this.link.get());
                },
                refresh: function() {
                    //this.link.get().addStyle('cta_text_style');
                    if(this.zalink && cta_super_footer){
                        _link = this.zalink.get();
                    }else {
                        _link = this.link.get();
                    }
                    // console.log(_link);
                    // console.log(linkbutton);
                    if(typeof(linkbutton ) != "undefined" && linkbutton  !== null && linkbutton == 'insertCTALink') {
                        if(this.link && window.global == 0) {
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
        // $.FroalaEditor.DefineIcon('insertCTALink2', {NAME: 'arrow-right'});
        // $.FroalaEditor.RegisterCommand('insertCTALink2', {
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
        if(is_cta){
            $.FroalaEditor.DefineIcon('CTA', {NAME: 'arrow-right'});
            $.FroalaEditor.RegisterCommand('CTA', {
                title: 'Add CTA Button',
                focus: true,
                undo: true,
                refreshAfterCallback: true,
                callback: function () {
                    if (this.html.getSelected() != '') {
                        var $ctatext = this.selection.text();
                        var $addcta = '<a href="#GetStartedNow">'+$ctatext+'</a>';
                        var $ctahtml = this.html.getSelected();
                        $ctahtml = $ctahtml.replace($ctatext, $addcta);
                        this.html.insert($ctahtml);
                        // this.undo.saveStep();
                    }
                }
            });
        }

        // var $startrating = '<div class = "rating-wrapper"><img class="rating" src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png"></div>';
        // $.FroalaEditor.DefineIcon('startrating', {NAME: 'star'});
        // $.FroalaEditor.RegisterCommand('startrating', {
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

        function getFroalaCursorState(prevState, defaultFocusParent){
            var selection = window.getSelection();
            return {
                prevNode: prevState.currentNode || defaultFocusParent.childNodes[0],
                prevOffset: prevState.currentOffset || 0,
                currentNode: selection.focusNode || defaultFocusParent.childNodes[0],
                currentOffset: selection.focusOffset || 0
            }
        }

        var froalaCursorState = getFroalaCursorState({}, document.body)

        $(document).on('lpFroalaEditorUpdateCurrentNode', function (){
            froalaCursorState = getFroalaCursorState(froalaCursorState, $('.fr-element.fr-view').get(0))
        });


        function getClosestCtaBtn(node, stopNode){
            if(!stopNode){
                stopNode = document.body;
            }

            if(node.nodeType !== Node.TEXT_NODE && node.classList.contains('za_cta_style')){
                return node
            }

            if(node === stopNode){
                return null
            }

            var parentNode = node.parentNode;
            while(parentNode){
                if(parentNode === document.body){
                    return null
                }
                if(parentNode.classList.contains('za_cta_style')){
                    return parentNode
                }
                parentNode = parentNode.parentNode;
            }

            return null
        }

        function findTextNode(node, returnLast){
            var nodePos = 'firstChild';
            if(returnLast){
                nodePos = 'lastChild';
            }

            if(!node){
                return null
            }

            if(node.nodeType === Node.TEXT_NODE){
                return node
            }

            var targetNode = node[nodePos]
            while(targetNode){
                if(targetNode.nodeType === Node.TEXT_NODE){
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
        function makePhoneClickableInTree(parentElement){
            // return if element if undefined ot has no childs
            if(!parentElement || !parentElement.childNodes.length) return;

            // traverse through all its child and find a phone number
            parentElement.childNodes.forEach(function(currentNode){
                // if current node is a link we skip it
                if(currentNode.nodeName.toLowerCase() === 'a'){
                    return
                }

                // if we find a text node, we search it for phone number
                if(currentNode.nodeType === Node.TEXT_NODE){
                    // made the regex less strict to detect phone numbers in different format
                    var phoneRegex = /\(\s*(\d{3})\s*\)[ \xa0\-_]{0,3}(\d{3})([ \xa0\.\-\_])[ \xa0\.\-\_]{0,2}(\d{4})|(\d{3})([ \xa0\.\-\_])[ \xa0\.\-\_]{0,2}(\d{3})([ \xa0\.\-\_])[ \xa0\.\-\_]{0,2}(\d{4})/g
                    var match = null

                    // for each match we get in the text node
                    while(match = phoneRegex.exec(currentNode.textContent)){

                        var phone = '';
                        var unformattedPhone = match[0];
                        // we make a phone string from selected parts
                        if(match[1]){
                            // the phone number has parenthsis and other allowed characters
                            phone = `(${match[1]}) `
                            for(var i = 2; i <= 4; i++){
                                phone += match[i]
                            }
                        } else {
                            // the phone number is without parenthesis and other allowed characters
                            for(var i = 5; i <= 9; i++){
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

        $froalaTextBox.on('froalaEditor.initialized', function (){
            $('#dropdown-menu-fontFamily-1 .fr-command').click(function(e){
                var font_family = $(this).css('font-family');
                $("#fontFamily-1 span").css({'font-family':font_family});
            });
        })

        window.lp_html_editor =  $froalaTextBox.froalaEditor({
            key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
            autofocus:true,
            //toolbarInline: false,
            // Set the image upload URL.
            htmlRemoveTags : [],
            imageUploadURL: site.baseUrl+'/lp/popadmin/'+fileuploadpath,
            // Set the file upload URL.
            fileUploadURL:  site.baseUrl+'/lp/popadmin/'+fileuploadpath,
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
            videoAllowedProviders : ['.*'],
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
            enter: $.FroalaEditor.ENTER_DIV,
            listAdvancedTypes: true,
            // toolbarButtonsSM: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo', 'insertReviewBlock'],
            // toolbarButtonsXS: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo', 'insertReviewBlock'],
            //toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '|', 'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html']

            toolbarButtons: toolbarButtonsList,
            imageEditButtons: ['insertImage','imageReplace', 'imageAlign', 'imageCaption', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'],
            /*toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
            toolbarButtonsMD: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
            toolbarButtonsSM: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
            toolbarButtonsXS: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo']*/
            fontSize: fontSize,
            fontFamily: font_object,
            fontFamilySelection: true
        })
            .on('froalaEditor.file.beforeUpload', function(e, editor, files) {
                // Return false if you want to stop the file upload.
                console.log('files', files);
            })
            /*.on('froalaEditor.file.uploaded', function (e, editor, response) {
            // File was uploaded to the server.
            console.log('responce uploaded',responce);
            })*/
            .on('froalaEditor.file.inserted', function(e, editor, $file, response) {
                // File was inserted in the editor.
                console.log('Inserted file', $file);
                console.log('Inserted responce', response);
            })
            .on('froalaEditor.video.beforeRemove', function(e, editor, $video) {
                /*src=$($('#footer_compliance_text').froalaEditor('selection.element')).find('video').attr('src');
                console.log('video src',src);*/
            })
            // link selected
            .on('froalaEditor.link.beforeInsert', function (e, editor, link, text, attrs) {
                // console.info(link);
                // $(link).each(function(){
                //       if($('> span',this).length >= 1)
                //       {
                //          alert('has span');
                //       } else {
                //          alert('dont has span');
                //       }
                //   });
            })
            .on('froalaEditor.commands.before', function (e, editor, cmd) {
                ctapopup = false;
                if(cmd == 'insertCTALink') {
                    ctapopup = true;
                }
                // if (ctapopup && cmd == 'insertLink'){
                //     linkbutton = 'insertCTALink';
                // }else
                if (window.editor_type == 'cta' && cmd == 'linkInsert'){
                    linkbutton = 'insertCTALink';
                }else{
                    linkbutton = '';
                }
            })
            .on('froalaEditor.url.linked', function (e, editor, link) {
                //console.info(link);
            })
            .on('froalaEditor.paste.after', function (e, editor) {
                console.log("froalaEditor.paste.after");
                // loading if any new font is added
                fontFamilies.load(editor);
            })
            .on('froalaEditor.commands.after', function (e, editor,cmd) {

                if(cmd === 'imageAlign'){
                    var imageSrc = editor.image.get();
                    if($(imageSrc).hasClass('fr-fil') || $(imageSrc).hasClass('fr-fir')){
                        $($(imageSrc).parent($(imageSrc).parent()[0].tagName)).removeAttr('style');
                    }
                    else{
                        $(imageSrc).parent($(imageSrc).parent()[0].tagName).css({'text-align':'center'});
                        let imageOffset = $(imageSrc);
                        $(imageSrc).click();
                    }
                }
                else if(cmd == 'linkRemove') {
                    $(".fr-popup").removeClass('fr-active');
                }
                //user for super footer cta link
                else if(cmd == 'linkEdit') {
                    _initSelector();
                } else if(cmd == "html"){
                    console.log("froalaEditor code view button hit.");
                    // loading if any new font is added
                    fontFamilies.load(editor);
                }

                /*
                * Make clickable checkbox of froala achor pop-up
                * */
                $(".fr-checkbox span").css('cursor','pointer');
                $(".fr-checkbox span").unbind('click').bind('click' ,function(){
                    $(this).parents('.fr-checkbox-line').find("label").trigger('click');
                });

                if(cmd == 'insertCTALink') {
                    linkbutton = cmd;
                }
            })
            .on('froalaEditor.video.removed', function(e, editor, $video) {
                $.ajax({
                    // Request method.
                    method: "POST",

                    // Request URL.
                    url: site.baseUrl+'/lp/popadmin/footerimageremove',

                    // Request params.

                    data: {
                        src: $video.attr('src'),
                        current_hash: jQuery("#current_hash").val(),
                        _token: ajax_token
                    }
                })
                    .done(function(data) {
                        console.log('image was deleted');
                    })
                    .fail(function() {
                        console.log('image delete problem');
                    })
            })
            .on('froalaEditor.file.unlink', function(e, editor, file) {
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
            })
            .on('froalaEditor.file.error', function(e, editor, error, response) {
                let message = error.message;
                if(error.code === 6){
                    message = 'PDF, Microsoft Word, Microsoft Excel, Microsoft PowerPoint file type allowed.';
                }
                editor.popups.areVisible()
                    .find('.fr-file-progress-bar-layer.fr-error .fr-message')
                    .text(message);
            })
            .on('froalaEditor.image.beforeUpload', function(e, editor, images) {
                // Return false if you want to stop the image upload.
                console.log(images);
            })
            .on('froalaEditor.image.uploaded', function(e, editor, response) {
                // Image was uploaded to the server.
                console.info("test");
                console.log(response);
            })
            .on('froalaEditor.image.inserted', function(e, editor, $img, response) {
                // Image was inserted in the editor.
                console.log($img);
                console.log(response);
            })
            .on('froalaEditor.image.replaced', function(e, editor, $img, response) {
                // Image was replaced in the editor.
                console.log($img);
                console.log(response);
            })
            .on('froalaEditor.image.error', function(e, editor, error, response) {
                // Bad link.\
                console.log('Error code is '+error.code+' and  error message is '+error.message);
                if (error.code == 5) {
                    editor.popups.areVisible()
                        .find('.fr-image-progress-bar-layer.fr-error .fr-message')
                        .text("The file is too large. Maximum allowed file size is 2MB.");
                }
            })
            .on('froalaEditor.click', function (e, editor, domEvent) {
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
                setTimeout(function (){
                    var font_family = $("#fontFamily-1 span").text();
                    $("#fontFamily-1 span").css({'font-family':font_family});
                },200);

            })
            .on('froalaEditor.keydown', function (e, editor, domEvent) {
                window.cta_button = false;

                var keyCode = domEvent.which || domEvent.keyCode;
                var key = domEvent.key;
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
                if([ 9, 13, 37, 38, 39, 40 ].indexOf(keyCode) < 0){
                    var selection = window.getSelection();
                    var ctaBtn = getClosestCtaBtn(selection.focusNode, domEvent.target);

                    var isCombination = domEvent.ctrlKey || domEvent.altKey || domEvent.metaKey;

                    if(!isCombination && ctaBtn && key.length === 1 && selection.focusNode.nodeType === Node.TEXT_NODE){
                        e.preventDefault();
                        domEvent.preventDefault()
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
                if( [ 8, 32 ].indexOf(keyCode) > -1 ){
                    var ctaBtn = getClosestCtaBtn(froalaCursorState.currentNode, domEvent.target)
                    if(ctaBtn){
                        var currentNode = froalaCursorState.currentNode;
                        var currentOffset = froalaCursorState.currentOffset;

                        if(
                            currentOffset === 0 &&
                            currentNode === ctaBtn.firstChild
                        ){
                            if(keyCode === 8){
                                var ctaPrevSibling = ctaBtn.previousSibling;
                                if(ctaPrevSibling){
                                    var siblingLastTextNode = findTextNode(ctaPrevSibling, true);
                                    if(siblingLastTextNode){
                                        window.getSelection().collapse(siblingLastTextNode, siblingLastTextNode.length)
                                    }
                                }
                            } else if( keyCode === 32){

                                var textNode = findTextNode(currentNode)

                                textNode.textContent = '\xa0' + textNode.textContent
                                window.getSelection().collapse(textNode, 1);
                                ctaBtn.focus()
                            }

                        } else if (
                            currentNode === ctaBtn ||
                            currentNode === ctaBtn.lastChild
                        ){
                            var textNode = findTextNode(currentNode, true)

                            var textNodeOffset = currentOffset;
                            if(currentNode.nodeType !== Node.TEXT_NODE){
                                textNodeOffset = Array.prototype.indexOf.call(textNode.parentNode.childNodes, textNode)
                            }

                            if(currentOffset === textNode.length || textNodeOffset === currentOffset - 1){
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
            })
            .on('froalaEditor.image.removed', function(e, editor, $img) {
                if(is_image_del){
                    /*
                    * Note: We don't delete the images which are uploaded to froala editor because when user delete image mistakenly then user do CTRL+Z image will back on editor but its delete from rackspace
                    * */
                    if(stop_image_del ){
                        $.ajax({
                            // Request method.
                            method: "POST",

                            // Request URL.
                            url: site.baseUrl+'/lp/popadmin/'+fileremovepath,

                            // Request params.
                            data: {
                                src: $img.attr('src'),
                                current_hash: jQuery("#current_hash").val(),
                                _token: ajax_token
                            }
                        })
                            .done(function(data) {
                                console.log('image was deleted');
                            })
                            .fail(function() {
                                console.log('image delete problem');
                            })
                    }
                }

            })
            .on('froalaEditor.input froalaEditor.paste.after', function (e, editor){

                var selection = editor.selection.get();

                if(!selection) return; // focus is out of editor or on iframe

                var currentElement = editor.selection.element();

                if($(currentElement).closest('a').length) return; // we are already in a phone link

                if(selection.anchorNode !== selection.focusNode) return; // text is split into multiple elements

                var currentTextNode = selection.focusNode;

                if(currentTextNode.nodeType != Node.TEXT_NODE) return; // return if node is not of text type

                var phoneRegex = /\(\d{3}\)[ \xa0]{1,3}\d{3}-\d{4}|\d{3}\.\d{3}\.\d{4}|\d{3}\-\d{3}\-\d{4}/g

                var match = null

                while(match = phoneRegex.exec(currentTextNode.textContent)){

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
            })
            .on('froalaEditor.html.set froalaEditor.paste.after', function(e, editor) {
                var editorEl = editor.$el.get(0)
                makePhoneClickableInTree(editorEl)
            })
            .on('froalaEditor.image.error', function(e, editor){
                var $popup = editor.popups.get('image.insert');
                var $layer = $popup.find('.fr-image-progress-bar-layer');
                $layer.find('h3').text("Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.");
            })


            $('.fr-element.fr-view').on('keyup click contextmenu', function (e){
                froalaCursorState = getFroalaCursorState(froalaCursorState, this)
            })

        var advancehtml = $('.local-super-footer .lp-froala-textbox').froalaEditor('html.get').length;
        if ($('.local-super-footer .lp-froala-textbox').length && advancehtml == 0) {
            window.speacific_advance_footer = 1;
            insertTemplate('default_template');
            // $('.local-super-footer .lp-froala-textbox').froalaEditor('html.set', $('#default-html').html());
        }else{
            //console.info("local-super-footer asd");
        }

        /*$('#footer_license_text').froalaEditor({
        theme: "dark",
        //toolbarInline: false,
        height: 200
        });*/
    });

    $("a[href='#GetStartedNow']").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        if (jQuery('#enteryourzipcode').val() == '') {
            jQuery('#enteryourzipcode').select();
        }
        return false;
    });

});

jQuery(window).on('load',function() {
    font_load();
});

function font_load(){
    var a = [];
    $.each(font_object, function( index, value ) {
        a.push(value);
    });

    //adding any new font-family if found in HTML
    let newFonts = fontFamilies.get();
    if(newFonts.length) {
        console.log("font_load ...", newFonts);
        a = a.concat(newFonts)
    }

    fontFamilies.loadGoogleWebFonts(a);
}
//user for super footer cta link
function _initSelector () {
    var url = $(".fr-popup.fr-active input[name='href']").val();
    if(url && $.inArray(url,["#GetStartedNow",'#top']) == -1){
        $(".fr-popup.fr-active .url_input").show();
        $(".fr-popup.fr-active #outside_url").prop("checked","checked");
    }else{
        $(".fr-popup.fr-active .url_input").hide();
        $(".fr-popup.fr-active #top_funnel").prop("checked","checked");
    }
}

//TODO: We will remove the code after move on the production

/**
 * insert link with exta space in CTA Button
 * @param _link url html
 * @param editor
 * @param type keydown,click
 */
function insertLink(_link,editor,type){
    var txt = '';
    txt  = $(_link).text().trim();
    if($(_link).hasClass('za_cta_style') && window.cta_button == false) {

        var replaceText = '&nbsp;' + txt + '&nbsp;';
        // var replaceText = txt;
        // if(!txt.match(/[\xa0\ \t]$/)){
        //     replaceText = replaceText + '\xa0';
        // }

        // if(!txt.match(/^[\xa0\ \t]/)){
        //     replaceText = '\xa0' + replaceText;
        // }



        // if(replaceText != txt){
            txt = $(_link).html().replace(txt,replaceText);
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
function insertTemplate(val,editor){
    var type = 'insert';
    if(editor === undefined) {
        type = 'set';
    }
    editor = window.lp_html_editor;

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

    if (val == 'review_template') {
        var $review_template = "<div class='lp-contact-review reivew-template'><div class='block-quote'><p>&ldquo;Our experience with John from XYZ Company was a breath of fresh air! With a super fast closing and great communication every step of the way, we couldn't ask for more. Thank&nbsp;you!&rdquo;</p></div><div class='desc'><span class='lp-contact-review__img'><img class='lozad' data-src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/iconfinder_Woman.svg' alt='' title='' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/iconfinder_Woman.svg' data-loaded='true'></span><div class='info'><h6>Sally Q. Homebuyer</h6><div><p><span>First-time Homebuyer | Somewhere, California</span></p></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><p></p></div></div><div class='clearfix'></div></div><p></p>";
        editor.froalaEditor('html.'+type,$review_template);
        // this.undo.saveStep();
    } else if (val == 'branded_template') {

        var $branded_template = "<div class='container advanced-container'><div class='co_branded'><table class='fr-no-border' style='width: 100%; text-align: center;'><tbody><tr><td style='width: 50.0000%;text-align: left;'><div class='lp-contact-review'><div><span class='lp-contact-review__img'><img class='lozad fr-fic fr-dii' alt='Leo Lender' title='Leo Lender' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/co_branded_template1.png'></span><div class='info'><h6>Leo Lender</h6><p>Senior Loan Officer<br>XYZ Mortgage Company, Inc.<br>NMLS #123456</p><div><br></div></div></div></div></td><td style='width: 50.0000%;text-align: left;'><div class='lp-contact-review'><div><span class='lp-contact-review__img'><img class='lozad fr-fic fr-dii' alt='Roxy Realtor' title='Roxy Realtor' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/co_branded_template2.png'></span><div class='info'><h6>Roxy Realtor</h6><p>Real Estate Broker<br>XYZ Realty Company, Inc.<br>NMLS #123456</p><div><br></div></div></div></div></td></tr></tbody></table></div></div><p></p>";
        editor.froalaEditor('html.'+type,$branded_template);
        // this.undo.saveStep();
    } else if (val == 'property_template') {
        var $property_template = '<div class="container advanced-container property_template" style="font-family: Open Sans;"><div class="row" style="text-align: center;"><div class="col-md-12"><span style="font-family: Poppins; font-size: 40px; color: rgb(40, 50, 78);">Beautiful San Diego Home for&nbsp;Sale</span></div></div><div class="row"> <br></div><div class="row"> <br></div><div class="row"><table class="fr-no-border" style="width: 100%;"><tbody><tr><td style="width: 50.1458%;"><p data-unit="px" data-web-font="Arial, Helvetica, sans-serif"><span style="color: rgb(40, 50, 78); font-size: 28px; font-weight: 700;">$3,750,000</span></p><p data-unit="px" data-web-font="Arial, Helvetica, sans-serif" style="color: rgb(40, 50, 78);font-size: 16px;font-weight: 700;margin: 0;">631 Ocean Blvd</p><p style="color: rgb(40, 50, 78);font-size: 16px;font-weight: 700;margin: 0px;">Coronado, CA 92118</p><p style="color: rgb(40, 50, 78);font-size: 16px;font-weight: 700;margin: 0px;">4 Bedroom | 4&nbsp;Bathroom | 3,270&nbsp;Sqft |2016&nbsp;Built&nbsp;</p><hr><div style="font-size: 16px;font-weight: 700;"><span style="color: rgb(40, 50, 78);">Single Family Home |&nbsp;MLS #312836&nbsp;|</span>&nbsp;<span style="color: rgb(97, 189, 109);">Active</span></div> <br>It is hard to believe but sometimes you can get better than new! This home is in perfect, like new condition and has features you can&#39;t get or afford from a builder. Neutral grey colors and warm wood floors throughout the home, welcome you home! Spacious living area has stone fireplace! Kitchen is fit for a chef with stainless steel appliances, white cabinets and quartz counter&nbsp;tops! <br> <br>Master suite is spacious and well laid out and has wood floors and a spa like bath! Home has large secondary rooms, large office and 3 full baths. Backyard is where it is at! Home features nice covered patio with extended rock patio. Awesome lot that features views of the beach and backs up to no&nbsp;one!</td><td style="width: 49.8542%;"> <br><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-1.jpeg" style="width: 495px;" class="fr-fic fr-dib"><div data-empty="true" style="text-align: center;"> <br></div><div data-empty="true" style="text-align: center;"><span style="color: rgb(44, 130, 201);"><u>Start Photo Slideshow</u></span> | <span style="color: rgb(44, 130, 201);"><u>Virtual Tour</u></span></div></td></tr></tbody></table></div><div class="row"><div> <br></div><table class="fr-no-border" style="width: 100%;"><tbody><tr><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-2.jpeg" style="width: 242px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-3.jpeg" style="width: 244px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-4.jpeg" style="width: 242px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-5.jpeg" style="width: 245px;" class="fr-fic fr-dib"></td></tr><tr><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-6.jpeg" style="width: 238px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-7.jpeg" style="width: 243px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-8.jpeg" style="width: 241px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-9.jpeg" style="width: 244px;" class="fr-fic fr-dib"></td></tr></tbody></table><div style="text-align: center;"> <br></div><div style="text-align: center;"><span style="font-size: 15px;"><br></span></div><div style="text-align: center;"><span style="font-size: 15px;">Click below to see if you qualify for this home. If yes, we&#39;ll provide you with a FREE, no-obligation pre-approval letter, PLUS we&#39;ll send you additional full-size photos, a 3D virtual tour link, and a detailed property report on this&nbsp;listing!</span></div><div style="text-align: center;"> <br></div><div style="text-align: center;"> <br></div><div style="text-align: center;"><span style="font-size: 24px;"><a href="#GetStartedNow" class="za_cta_style" id="cta_active">&nbsp;See if You Qualify for This Home Now!</a></span></div><div style="text-align: center;"> <br></div><div style="text-align: center;"> <br><em style="font-size: 14px;">This simple quiz only takes about 60 seconds and it won&#39;t affect your credit&nbsp;score!</em></div><div style="text-align: center;"> <br></div><hr><div style="text-align: left;"> <br></div><div style="text-align: left; margin-left: 40px; font-size: 14px; line-height: 1.42857143;">Listing brought to you by:</div><div style="text-align: left; margin-left: 40px; font-size: 14px; line-height: 1.42857143;"><div>Shelly Jackson, Broker</div><div font-size: 14px; line-height: 1.42857143;>Keller Williams Premier Properties</div></div><div style="text-align: left; margin-left: 40px;"> <br></div></div></div><p></p>';
        editor.froalaEditor('html.'+type,$property_template);
        // this.undo.saveStep();
    }else if (val == 'property_template2') {
        var $property_template = '<div class="property_template2"><h1 style="text-align: center; line-height: 1.15;"><span style="font-size: 26px; font-family: Oxygen;"><strong>&nbsp;Spectacular Must-See La Jolla, California Home for&nbsp;Sale</strong></span><div class="clearfix" style="height: 0px;"></div><span style="font-size: 26px; font-family: Oxygen;"><strong>&nbsp;~&nbsp;</strong></span><br><span style="font-size: 26px; font-family: Oxygen; color: rgb(26, 188, 156);">Check Out the 3D Virtual Tour&nbsp;Below!</span></h1><div style="text-align: center;"><br></div><div style="text-align: center; padding: 0 25px; box-sizing: border-box;"><iframe width="100%" height="500" src="https://my.matterport.com/show/?m=JGPnGQ6hosj&play=1" frameborder="0" allowfullscreen=""></iframe></div><div style="text-align: center;"><br></div><div class="container advanced-container" style="font-family: Open Sans;"><br /><p data-unit="px" data-web-font="Arial, Helvetica, sans-serif" style="margin: 0px;"><span style="font-size: 22px;font-weight: 700;">$3,750,000</span></p><p style="font-size: 16px;font-weight: 700;margin: 0px;">San Diego, CA 92124</p><p style="font-size: 14px;font-weight: 700;margin: 0px;">4 Bedroom | 4 Bathroom | 3,270&nbsp;SqFt | 2016&nbsp;Built</p><p style="font-size: 12px;padding: 18px 0px;"><a href="#GetStartedNow" class="za_cta_style" id="cta_active">&nbsp;Get Pre-Approved!</a></p><hr><div style="font-size: 16px;padding-top: 19px;font-weight: 700;"><span>Single Family Home | MLS&nbsp;#312836 | </span><span style="color: rgb(97, 189, 109);">Active</span></div><span style="font-size: 16px;">It is hard to believe but sometimes you can get better than new! This home is in perfect, like new condition and has features you can&#39;t get or afford from a builder. Neutral grey colors and warm wood floors throughout the home, welcome you home! Spacious living area has stone fireplace! Kitchen is fit for a chef with stainless steel appliances, white cabinets and quartz counter&nbsp;tops!<br><br>Master suite is spacious and well laid out and has wood floors and a spa like bath! Home has large secondary rooms, large office and 3 full baths. Backyard is where it is at! Home features nice covered patio with extended rock patio. Awesome lot that features views of the beach and backs up to no&nbsp;one!</span><div class="row"><br></div><div class="row"><div><br></div><table class="fr-no-border" style="width: 100%;"><tbody><tr><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-2.jpeg" style="width: 242px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-3.jpeg" style="width: 244px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-4.jpeg" style="width: 242px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-5.jpeg" style="width: 245px;" class="fr-fic fr-dib"></td></tr><tr><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-6.jpeg" style="width: 238px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-7.jpeg" style="width: 243px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-8.jpeg" style="width: 241px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-9.jpeg" style="width: 244px;" class="fr-fic fr-dib"></td></tr></tbody></table><div style="text-align: center;"><br></div><div style="text-align: center;"><span style="font-size: 15px;"><br></span></div><div style="text-align: center;"><p style="font-size: 15px;margin: 0px;">Click below to see if you qualify for this home. If yes, we&#39;ll provide you with a FREE, no-obligation pre-approval letter,&nbsp;</p><p style="font-size: 15px;margin: 0px;">PLUS we&#39;ll send you additional full-size photos, a 3D virtual tour link, and a detailed property report on this&nbsp;listing!</p></div><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div><div style="text-align: center;"><span style="font-size: 24px;"><a href="#GetStartedNow" class="za_cta_style" id="cta_active">&nbsp;See if You Qualify for This Home Now!</a></span></div><div style="text-align: center;"><br></div><div style="text-align: center;"><br><em style="font-size: 14px;">This simple quiz only takes about 60 seconds and it won&#39;t affect your credit&nbsp;score!</em></div><div style="text-align: center;"><br></div><hr><div style="text-align: left;"><br></div><div style="text-align: left; margin-left: 40px; font-size: 14px; line-height: 1.42857143">Listing brought to you by:</div><div style="text-align: left; margin-left: 40px; font-size: 14px; line-height: 1.42857143"><div>Shelly Jackson, Broker</div><div style="font-size: 14px; line-height: 1.42857143">Keller Williams Premier Properties</div></div><div style="text-align: left; margin-left: 40px;"><br></div></div></div><p><br></p><div style="line-height: 1; text-align: center;"><em><div style="font-size: 9px;">*Pre-approval is based on a preliminary review of credit information provided to POP Mortgage Corp. which has not been reviewed by Underwriting. Final loan approval is subject to a full</div></em><em><div style="font-size: 9px;">Underwriting review of support documentation including, but not limited to, applicants&rsquo; creditworthiness, assets, income information, and a satisfactory&nbsp;appraisal.</div></em></div><div style="line-height: 1; text-align: center;"><br></div><div style="line-height: 1; text-align: center;"><br></div></div>';
        editor.froalaEditor('html.'+type,$property_template);
        // this.undo.saveStep();
    } else if (val == 'default_template') {
        var clientfname = $('#clientfname').val();
        var $default_template = '<div class="container advanced-container default-template"> <div class="row"> <div class="col-sm-12"><h2 class="funnel__title"><span><strong>How this&nbsp;works...</strong></span></h2></div></div><div class="clearfix" style="height: 0px;"></div><div class="row"> <div class="col-lg-5"> <div class="box funnel__box"> <div class="box__counter">1</div><div class="box__content"> <h3 class="box__heading"><span style="font-size: 20px;">60-Second Digital&nbsp;Pre-Approval</span></h3> <p class="box__des">Share some basic info; if qualified, we&#39;ll provide you with a free,<span style="white-space: nowrap"> no-obligation</span> <span style="white-space: nowrap">pre-approval</span>&nbsp;letter.</p></div></div><div class="box funnel__box"> <div class="box__counter">2</div><div class="box__content"> <h3 class="box__heading"><span style="font-size: 20px;">Choose the Best Options for&nbsp;You</span></h3> <p class="box__des">Choose from a variety of loan options, including our conventional 20% down&nbsp;product. <br><br>We also offer popular 5%-15% down home loans... AND we can even go as low as 0%&nbsp;down.</p></div></div><div class="box funnel__box"> <div class="box__counter">3</div><div class="box__content"> <h3 class="box__heading"><span style="font-size: 20px;">Start Shopping for Your&nbsp;Home!</span></h3> <p class="box__des">It only takes about 60 seconds to get everything under way. Simply enter your zip code right&nbsp;now.</p></div></div><div style="text-align: center;margin: 20px auto;"><a class="lp-btn__go za_cta_style" href="#GetStartedNow" id="cta_active" tabindex="-1" title="">&nbsp;Get Started Now!</a></div><div class="funnel__caption"> <p style="text-align: center; margin-left: 20px;"><em><span style="font-size: 11px;max-width: 287px;">This hassle-free process only takes about 60&nbsp;seconds, and it won&#39;t affect your credit&nbsp;score!</span></em></p><p> <br></p></div></div><div class="col-lg-7"> <div class="animate-container"> <div class="first animated desktop slideInRight"><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-1.png" class="fr-fic fr-dii"></div><div class="second animated desktop fadeIn"> <h2 class="animate__heading" style="font-size: 18px;"><span style="font-size: 18px;">Share some basic info</span></h2><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-2.png" class="fr-fic fr-dii"></div><div class="third animated desktop zoomIn"><strong><span style="color: rgb(3, 177, 253); font-size: 18px;">10% Down</span></strong></div><div class="fourth animated desktop fadeInLeft"><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-4.png" class="fr-fic fr-dii"></div><div class="fifth animated desktop slideInRight"> <p style="max-width: 188px;"><span class="clientfname">Hi, I&#39;m ' + $("#clientfname").val() + ', your loan&nbsp;</span>officer. It looks like you may qualify for a lot more than you&nbsp;thought!</p></div></div><div class="clearfix"></div><p></p></div><br></div></div><p></p>';
        editor.froalaEditor('html.'+type,$default_template);
        // this.undo.saveStep();
    } else if (val == 'blank_template') {
        $('.fr-view').html('');
        is_image_del = false;
        // this.html.set('<p></p>');
        //this.html.insert('<p></p>');
        //this.undo.saveStep();
    } else if (val == 'cta_template_right_img') {
        var $cta_template_right_img = '<div class="container advanced-container"><div class="row" style="text-align: center;"><br><table class="fr-no-border fr-thick" style="text-align: center;margin: 0 20px;width: 100%"><tbody><tr><td style="width: 50%; text-align: center;"><div style="line-height: 1.42857143;"><span style="font-family: Orbitron; font-size: 30px;"><strong><span style="color: rgb(114, 56, 204);">Instantly get a fast,&nbsp;free,&nbsp;</span></strong></span><span style="color: rgb(114, 56, 204);"><strong><br><span style="font-family: Orbitron; font-size: 30px;">and no-obligation&nbsp;</span><br></strong></span><span style="font-family: Orbitron; font-size: 30px; color: rgb(114, 56, 204);"><strong>digital rate&nbsp;quote.</strong>&nbsp;</span></div><br><div style="display: inline-block;max-width: 396px;font-family: Open Sans, sans-serif;font-size:14px; line-height: 1.42857143;">Answer some super easy questions and we&#39;ll provide you with a fast and hassle-free digital rate quote in just&nbsp;seconds.<br>&nbsp;</div><br><span style="font-size: 26px; color: rgb(184, 49, 47);"><a href="#GetStartedNow" class="za_cta_style" id="cta_active">&nbsp;Get Started Now!</a></span></td><td style="width: 50.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/cta_template_img.png" style="width: 300px;" class="fr-fic fr-dib fr-fil"></td></tr></tbody></table></div><div class="row" style="text-align: center;"><br></div><div class="row" style="text-align: left;"></div></div><p></p>';
        editor.froalaEditor('html.'+type,$cta_template_right_img);
        // this.undo.saveStep();
    } else if (val == 'cta_template_left_img') {
        var $cta_template_left_img = '<div class="container advanced-container"><div class="row" style="text-align: center;"><br><table class="fr-no-border fr-thick" style="text-align: center;margin: 0 20px;width: 100%"><tbody><tr><td style="width: 50.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/cta_template_img_1.png" style="width: 300px;" class="fr-fic fr-dib fr-fil"></td><td style="width: 50%; text-align: center;"><div style="line-height: 1.42857143;"><span style="font-family: Orbitron; font-size: 30px;"><strong><span style="color: rgb(114, 56, 204);">Instantly get a fast,&nbsp;free,&nbsp;</span></strong></span><span style="color: rgb(114, 56, 204);"><strong><br><span style="font-family: Orbitron; font-size: 30px;">and no-obligation&nbsp;</span><br></strong></span><span style="font-family: Orbitron; font-size: 30px; color: rgb(114, 56, 204);"><strong>digital rate&nbsp;quote.</strong>&nbsp;</span></div><br><div style="display: inline-block;max-width: 396px;font-family: Open Sans, sans-serif;font-size:14px; line-height: 1.42857143;">Answer some super easy questions and we&#39;ll provide you with a fast and hassle-free digital rate quote in just&nbsp;seconds.<br>&nbsp;</div><br><span style="font-size: 26px; color: rgb(184, 49, 47);"><a href="#GetStartedNow" class="za_cta_style" id="cta_active">&nbsp;Get Started Now!</a></span></td></tr></tbody></table></div><div class="row" style="text-align: center;"><br></div><div class="row" style="text-align: left;"></div></div><p></p>';
        editor.froalaEditor('html.'+type,$cta_template_left_img);
        // this.undo.saveStep();
    } else if (val == 'secure_clix_template') {
        var $secure_clix_template = '<div class="container advanced-container secure_clix_template"><div style="text-align: center;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/secure-clix-security.png" style="width: 53px;" class="fr-fic fr-dib"><strong><span style="font-family: Orbitron;font-size: 22px;color:#000000;">Secure-Clix: <span style="color: rgb(26, 188, 156);">SAFE-SITE</span></span></strong></div><div style="text-align: center;"><strong>&nbsp;<span style="font-size: 12px; color: rgb(0, 0, 0);">THIS WEBSITE DOES <u>NOT</u> SELL YOUR&nbsp;INFORMATION</span>&nbsp;</strong> <br><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/secure-clix-arrowdown.png" style="width: 38px;" class="fr-fic fr-dib"><div class="secure-template-title" style="display: inline-block;width: 518px;"><strong>&nbsp;<span style="font-size: 30px; font-family: Palanquin;color: rgb(0, 0, 0);">&nbsp;Beware of &quot;Internet Lead&quot; websites like:<br>Zillow<sub>&reg;</sub>, Realtor.com<sub>&reg;</sub>, LendingTree<sub>&reg;</sub>,<br>Quicken Loans<sub>&reg;</sub>, LowerMyBills<sub>&reg;</sub>, etc.&nbsp;</span>&nbsp;</strong></div></div> <br><div style="text-align: center;"><div style="font-size: 18px;font-family: Palanquin;color: rgb(0, 0, 0);">&nbsp;<strong>&nbsp;It turns out selling your personal information is not just<br>&nbsp;insanely profitable for big social media tech companies. </strong> <br><br>Internet lead websites&mdash;like those listed above... <br><br>Their ENTIRE existence depends on capturing and selling<br>consumer information online. <br><br>That means if, heaven forbid, you fill something out on one of<br>those websites, they will take and SELL your personal information... <br><br>Often to 10-20 (or more) organizations and individual salespeople. <br><br>You&#39;ll get hounded&mdash;mostly by banks with big call centers, and a<br>whole bunch of loan officers and real estate agents from all over<br>the US. <br><br>It&#39;s a nightmare. <br><br>You may have to move out of the country to escape. <br><br>OK, I&#39;m kidding about having to move out of the country. <br><br><strong>&nbsp;But&mdash;using those websites WILL result in an onslaught of unwanted<br>phone calls, emails, and text messages from aggressive &ldquo;<strong>Boiler Room&quot;</strong><br>style salespeople&mdash;often for months without end.<br></strong> <br>Don&#39;t take my word for it, though <br><br>You can see it for yourself. <br><br>By law, they&#39;re forced to admit to all of this (and much more)<br>in their website privacy policies.<br><br>This dystopian hellscape I&#39;m describing is known as the<br>&quot;internet lead industry.&quot; <br><br>When you&#39;re searching on one of those internet lead websites... <br><br>That&#39;s all you are to them. <br><br>An &quot;internet lead.&quot; <br><br>A lead whose information they can sell for a lot of money. <br><br>Over and over again. <br><br><strong>These websites make billions of dollars doing this.</strong> <br><br>And there are a TON of these types of internet lead websites out there. <br><br>Big companies with household names, like the ones listed above (and many more),<br>whose business model is just basically getting web traffic and selling internet leads. <br><br>It&#39;s how they fund their ginormous websites and advertising campaigns. <br><br>Let me cut to the chase. <br><br><strong>I&#39;m sharing all of this because that&#39;s <u>NOT</u> what we do.</strong> <br><br>We&#39;re A LOT different. <br><br><strong>While you may find us listed on websites like Zillow, that&#39;s about all we have in<br>common.</strong> <br><br>We&#39;re an actual mortgage lender, not an internet middleman or data re-seller. <br><br>We take extra security precautions, and <u>we do not sell your information to 3rd parties</u>. <br><br><strong>That&#39;s why this website is a&nbsp;</strong> <span style="font-family: Orbitron;"><strong>Secure-Clix: <span style="color: rgb(26, 188, 156);">SAFE-SITE</span></strong></span> <br> <br>So you can shop for your new home and a mortgage loan, and get answers, without <br>getting hassled. <br> <br><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/secure-clix-horizontaldotshidden.png" style="width: 55px;" class="fr-fic fr-dib"> <span style="font-size: 12px;font-family: Palanquin;">Secure-Clix helps you identify when you&#39;re on a website that SAFEGUARDS your personal information.</span></div> <br><div data-empty="true" style="text-align: center;"><span style="font-size: 28px;"><a href="#GetStartedNow" class="za_cta_style" id="cta_active" style="font-family: Palanquin;">&nbsp;AWESOME, NOW GET&#39;S STARTED!</a></span></div></div></div>';
        editor.froalaEditor('html.'+type,$secure_clix_template);
        // this.undo.saveStep();
    }
    else if (val == 'personally_branded') {
        var $personally_branded = '<div class="personally-branded-container"><div class="personally-branded-template"><div class="personally-branded-detail"><div class="personally-branded-detail-wrap"><div class="detail-left-content"><div class="image-holder"><div class="image-wrap"><img src="https://images.lp-images1.com/default/images/personall-branded-image02.png" alt="image-description"></div></div><div class="personally-branded-heading"><div class="name-wrap"><h2 class="name">'+contact_full_name+'</h2><h3 class="desination">Loan Officer</h3></div><div class="info-wrap"><h3 class="number"><a href="#">'+phone_number+'</a></h3><h3 class="email"><a href="#">'+contact_email+'</a></h3></div></div></div><div class="personally-branded-description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi quam dui, condimentum commodo ullamcorper sit amet, malesuada sit amet erat. In et ultrices mauris. Sed imperdiet leo sapien, in porta sem suscipit efficitur. Proin sed molestie neque, vel dignissim ante. Proin vitae risus a diam rhoncus feugiat. Praesent placerat nibh eget tempor finibus. Aliquam pulvinar nibh eu consectetur consectetur. </p></div></div><div class="quote-area"><h2 class="quote-title">Get Your mortgage rate Quote</h2><span class="btn-wrap"><a class="za_cta_style brand-cta-btn" href="#GetStartedNow" id="cta_active" tabindex="-1">I want my free mortgage rate quote</a></span></div></div></div></div>';
        editor.froalaEditor('html.'+type,$personally_branded);
    }
}

var fontFamilies = {
    regex: /font-family\:.+?;/gm,
    newFonts: [],
    /**
     * get font-families from HTML & added into font-families list if didn't found
     * @returns {*}
     */
    get: function(editor) {
        let $self = this,
            fontFamilies = [],
            str = editor ? editor.html.get() : $(".lp-froala-textbox").html(),
            m;
        str = str.replace(/&quot;/g, '');
        while ((m = $self.regex.exec(str)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (m.index === $self.regex.lastIndex) {
                $self.regex.lastIndex++;
            }
            // The result can be accessed through the `m`-variable.
            m.forEach((match, groupIndex) => {
                let value = $.trim(match.replace('font-family:', '')).replace(/["';]/g, '');;
                if (font_object[value] === undefined && $self.newFonts.indexOf(value) == -1) {
                    $self.newFonts.push(value);
                    fontFamilies.push(value);
                    console.log("font added ", value);
                }
            });
        }
        return fontFamilies;
    },

    /**
     * load font family, if any new font-family will be added by client
     */
    load: function(editor) {
        let $self = this,
            fontFamilies = $self.get(editor);
        if(fontFamilies.length) {
            let wf = $("#google-web-fonts");
            if(wf.length) {
                WebFont.load({
                    google: {
                        families: fontFamilies
                    }
                });
                console.log("loading new fontFamilies", fontFamilies);
            } else {
                console.log("loading fontFamilies", fontFamilies);
                $self.loadGoogleWebFonts(fontFamilies);
            }
        }
    },

    /**
     * add webfont script to load fonts from googl
     * @param fontFamilies
     */
    loadGoogleWebFonts: function(fontFamilies){
        WebFontConfig = {
            google: { families: fontFamilies }
        };
        let wf = document.createElement('script');
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = true;
        wf.id = "google-web-fonts";
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    }
};
