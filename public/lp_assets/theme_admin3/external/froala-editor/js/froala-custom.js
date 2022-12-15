var font_object = lp_helper_font_families;
var arr = ['extra-content','footeroption','thankyoumessage','global'];
var super_footer = ['extra-content','footeroption','global','thankyoumessage','autoresponder'];
var show_video = ['footeroption','thankyoumessage'];
var show_cta = ['autoresponder','thankyoumessage','global'];
var global_setting = ['global'];
window.speacific_advance_footer = 0;
var is_image_del = true;
var lp_html_editor = null,
    stop_image_del = false,
    is_iframe = true,
    is_cta_popup = false,
    videoInsertButtons = ["videoBack", "|", "videoByURL", "videoEmbed", "videoUpload"],
    fileuploadpath = 'footerimageupload',
    fileremovepath = 'footerimageremove';
window.cta_button = false;

jQuery(document).ready(function() {
    // var linkbutton = '';
    var fontSize = [];
    for (var i = 8; i <= 72; i++) {
        fontSize.push(i);
    }

    $(function() {
        var chk = cta_super_footer =  false;
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
            videoInsertButtons = ["videoBack", "|", "videoByURL"];
            is_iframe = false;
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
            FroalaEditor.DefineIcon('template_dropdown', {NAME: 'columns'});
            FroalaEditor.RegisterCommand('template_dropdown', {
                title: 'Select Templates',
                type: 'dropdown',
                focus: false,
                undo: false,
                refreshAfterCallback: true,
                options: lpHtmlEditor.getTemplatesAsOptions(),

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

        var is_cta = false;
        for(var i = 0; i <= page.length; i++){
            is_cta = true;
        }

        var toolbarButtonsList = [ 'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'lineHeight', 'align', 'formatOL', 'formatUL', 'outdent', 'indent','insertLink','insertImage','insertVideo','emoticons', 'insertHR','insertCtaLink', 'html' , 'undo','redo', 'starOption' ];
        if(['extra-content', 'footeroption'].indexOf(page[3]) !== -1) {
            toolbarButtonsList     = [ 'bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'lineHeight', 'align', 'formatOL', 'formatUL', 'outdent', 'indent','insertLink', 'insertImage','insertVideo','emoticons', 'insertHR','insertCtaLink', 'template_dropdown', 'html' ,'undo',  'redo','starOption' ];
        }

        function getFroalaCursorState(prevState, defaultFocusParent){
            var selection = window.getSelection();
            return {
                prevNode: prevState.currentNode || defaultFocusParent.childNodes[0],
                prevOffset: prevState.currentOffset || 0,
                currentNode: selection.focusNode || defaultFocusParent.childNodes[0],
                currentOffset: selection.focusOffset || 0
            }
        }

        // setting cursor state, when click everywhere inside froala editor
        var froalaCursorState = getFroalaCursorState({}, document.body)

        $(document).on('lpFroalaEditorUpdateCurrentNode', function (){
            froalaCursorState = getFroalaCursorState(froalaCursorState, $('.fr-element.fr-view').get(0))
        });

        jQuery(document).on('keyup click contextmenu', '.fr-element.fr-view', function (e){
            froalaCursorState = getFroalaCursorState(froalaCursorState, this)
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

        lp_html_editor = new FroalaEditor(".lp-froala-textbox", {
            key: froala_key,
            iconsTemplate: 'font_awesome',
            autofocus: true,
            videoInsertButtons: videoInsertButtons,
            //toolbarInline: false,
            // Set the image upload URL.
            htmlRemoveTags: [],
            imageUploadURL: site.baseUrl + '/lp/popadmin/' + fileuploadpath,
            // Set the file upload URL.
            fileUploadURL: site.baseUrl + '/lp/popadmin/' + fileuploadpath,
            //Custom option added to video plugin
            isVideoInsertByUrlIFrame: is_iframe,
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
            fileAllowedTypes: ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel'],
            // Set the video upload URL.
            videoUploadURL: 'https://myleads.leadpops.com/lp/popadmin/footervideoupload/',
            videoResponsive: false,
            videoUploadParams: {
                id: 'footer_compliance_text'
            },
            videoAllowedProviders: ['.*'],
            heightMin: 250,
            //fullPage: true,
            tableStyles: {
                'fr-dashed-borders': 'Dashed Borders',
                'fr-alternate-rows': 'Alternate Rows',
                'fr-thick': 'Thick Borders',
                'fr-no-border': 'No Borders'
            },
            charCounterCount: false,
            enter: FroalaEditor.ENTER_DIV,
            listAdvancedTypes: true,

            toolbarButtons: toolbarButtonsList,
            imageEditButtons: ['insertImage', 'imageReplace', 'imageAlign', 'imageCaption', 'imageRemove', 'imageLink', 'linkOpen', '-', 'linkEdit', 'linkRemove', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'],
            fontSize: fontSize,
            fontFamily: font_object,
            fontFamilySelection: false,
            events: {
                "initialized": function(){
                    // START::Added class for version 4.0.5 CSS
                    let parent = jQuery(".lp-froala-textbox").parents(".classic-editor__wrapper");
                    if(!parent.hasClass("update-version")) {
                        parent.addClass("update-version");
                    }
                    if (jQuery('.classic-editor__wrapper').hasClass('update-version') || jQuery('.classic-editor').hasClass('update-version')) {
                        jQuery("body").addClass("froala-editor-update");
                    } else {
                        jQuery("body").removeClass("froala-editor-update");
                    }

                    // add this for fixed the issue of CTA auto multiple button added
                    jQuery('.za_cta_style').contents().each(function() {
                        if (this.nodeType === 3) {
                            this.textContent = this.textContent.replace(/\u00A0/g, '');
                        }
                    });
                    // END::Added class for version 4.0.5 CSS

                    /**
                     * insert default template HTML if advance footer HTML is empty
                     * added timeout because getting core undefined without timeout
                     */
                    if ($('.local-super-footer .lp-froala-textbox').length && this.core.isEmpty()) {
                        window.speacific_advance_footer = 1;
                        insertTemplate('default_template');
                        // $('.local-super-footer .lp-froala-textbox').froalaEditor('html.set', $('#default-html').html());
                    }
                },
                /**
                 * AJAX request handler will enable/disable related form button
                 */
                'contentChanged': function(){
                    jQuery(this.$oel[0]).trigger("change");
                    //add phone number automatically, if pattern matched
                    makePhoneClickableInTree(this.$el.get(0));
                    $('.save-third-party').prop('disabled',false);
                    $(".thank-you-modal-scroll").getNiceScroll().resize();
                },
                'file.beforeUpload': function (files) {
                    // Return false if you want to stop the file upload.
                    console.log('files', files);
                },
                'file.inserted': function ($file, response) {
                    // File was inserted in the editor.
                    console.log('Inserted file', $file);
                    console.log('Inserted responce', response);
                },
                'commands.before': function (cmd) {
                    if (cmd == 'insertCtaLink' || (is_cta_popup && $.inArray(cmd, ["linkInsert", "linkCtaInsert", 'linkList']) !== -1)) {
                        let link = jQuery(this.link.get());
                        if(link.length && !link.hasClass("za_cta_style")){
                            is_cta_popup = false;
                        } else {
                            is_cta_popup = true;
                        }
                    } else {
                        is_cta_popup = false;
                    }
                },
                'paste.after': function () {
                    console.log("froalaEditor.paste.after");
                    // loading if any new font is added
                    fontFamilies.loadFromFroala(this);
                    $('.save-third-party').prop('disabled',false);
                },
                'commands.after': function (cmd, param1, param2) {
                    $('.save-third-party').prop('disabled',false);
                    jQuery('.fr-sc-container').parents('.fr-popup').addClass('fr-sc-container-wrap');
                    /* This code for Personal branding template compatible with froala option */
                    let branding_image_name = jQuery('.personally-branded-image');
                    if (branding_image_name.hasClass('fr-dib')) {
                        branding_image_name.parents('.personally-branded-section').addClass("break-option-active");
                    } else {
                        branding_image_name.parents('.personally-branded-section').removeClass("break-option-active");
                    }

                    if (branding_image_name.hasClass('fr-fir')) {
                        branding_image_name.parents('.personally-branded-section').addClass("right-option-active");
                    } else {
                        branding_image_name.parents('.personally-branded-section').removeClass("right-option-active");
                    }

                    /* This code for Thank you page compatible with froala option */
                    let image_logo_name = jQuery('.thank-page-image');

                    if (image_logo_name.hasClass('fr-dii')) {
                        image_logo_name.parent().addClass('logo-image-wrap');
                        image_logo_name.parents('.fr-view').addClass("thank-you-break-option-active");
                    } else {
                        image_logo_name.parent().removeClass('logo-image-wrap');
                        image_logo_name.parents('.fr-view').removeClass("thank-you-break-option-active");
                    }

                    if (image_logo_name.hasClass('fr-fir')) {
                        image_logo_name.parents('.fr-view').addClass("thank-you-right-option-active");
                    } else {
                        image_logo_name.parents('.fr-view').removeClass("thank-you-right-option-active");
                    }

                    let editor = this;
                    if (cmd === 'imageAlign') {
                        var imageSrc = editor.image.get();
                        if ($(imageSrc).hasClass('fr-fil') || $(imageSrc).hasClass('fr-fir')) {
                            $($(imageSrc).parent($(imageSrc).parent()[0].tagName)).removeAttr('style');
                        } else {
                            $(imageSrc).parent($(imageSrc).parent()[0].tagName).css({'text-align': 'center'});
                            let imageOffset = $(imageSrc);
                            $(imageSrc).click();
                        }
                        /* This code for co-branded template compatible with froala option */
                        if ($(imageSrc).hasClass('fr-fir')) {
                            $($(imageSrc).parent($(imageSrc).parent().addClass('right-option-active')));
                        } else {
                            $($(imageSrc).parent($(imageSrc).parent().removeClass('right-option-active')));
                        }
                    } else if (cmd == 'linkRemove') {
                        $(".fr-popup").removeClass('fr-active');
                    } else if (cmd == "imageDisplay") {
                        if ($('body').hasClass('funnel-thank-you-page') || $('.thankyou-modal-editor').hasClass('update-version')) {
                            $(".fr-image-resizer").removeClass('fr-active');
                            $(".fr-popup").removeClass('fr-active');
                        }
                    } else if (cmd == "html") {
                        // loading if any new font is added
                        fontFamilies.loadFromFroala(editor);
                    }
                    jQuery(".custom_cta_pop-wrap-block").parent().addClass("cta_pop-parent");

                    /*
                    * Make clickable checkbox of froala achor pop-up
                    * */
                    $(".fr-checkbox span").css('cursor', 'pointer');
                    $(".fr-checkbox span").unbind('click').bind('click', function () {
                        $(this).parents('.fr-checkbox-line').find("label").trigger('click');
                    });
                },
                'video.removed': function ($video) {
                    let editor = this;
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
                    })
                        .done(function (data) {
                            console.log('image was deleted');
                        })
                        .fail(function () {
                            console.log('image delete problem');
                        })
                    $('.save-third-party').prop('disabled',false);
                },
                'file.error': function (error, response) {
                    let message = error.message;
                    if (error.code === 6) {
                        message = 'PDF, Microsoft Word, Microsoft Excel, Microsoft PowerPoint file type allowed.';
                    }
                    this.popups.areVisible()
                        .find('.fr-file-progress-bar-layer.fr-error .fr-message')
                        .text(message);
                },
                'image.beforeUpload': function (images) {
                    // Return false if you want to stop the image upload.
                    console.log(images);
                },
                'image.uploaded': function (response) {
                    // Image was uploaded to the server.
                $('.save-third-party').prop('disabled',false);
                    console.info("test");
                    console.log(response);
                },
                'image.inserted': function ($img, response) {
                    // Image was inserted in the editor.
                    // jQuery('img.fr-dii').parent().addClass('froala-image-parent');
                    // $('.save-third-party').prop('disabled',false);
                },
                'image.replaced': function ($img, response) {
                    // Image was replaced in the editor.
                $('.save-third-party').prop('disabled',false);
                    console.log($img);
                    console.log(response);
                },
                'image.error': function (error, response) {
                    // Bad link.\
                    console.log('Error code is ' + error.code + ' and  error message is ' + error.message);
                    if (error.code == 5) {
                        this.popups.areVisible()
                            .find('.fr-image-progress-bar-layer.fr-error .fr-message')
                            .text("The file is too large. Maximum allowed file size is 2MB.");
                    } else if(error.code == 6) {
                        this.popups.areVisible()
                            .find('.fr-image-progress-bar-layer.fr-error .fr-message')
                            .text("Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.");
                    }
                },
                'click': function (clickEvent) {
                    window.cta_button = false;
                    setTimeout(function () {
                        var font_family = $("#fontFamily-1 span").text();
                        $("#fontFamily-1 span").css({'font-family': font_family});
                    }, 200);

                },
                'keydown': function (domEvent) {
                    window.cta_button = false;
                $('.save-third-party').prop('disabled',false);
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
                    if ([9, 13, 37, 38, 39, 40].indexOf(keyCode) < 0) {
                        var selection = window.getSelection();
                        var ctaBtn = getClosestCtaBtn(selection.focusNode, domEvent.target);

                        var isCombination = domEvent.ctrlKey || domEvent.altKey || domEvent.metaKey;

                        if (!isCombination && ctaBtn && key.length === 1 && selection.focusNode.nodeType === Node.TEXT_NODE) {
                            domEvent.preventDefault();
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
                    if ([8, 32].indexOf(keyCode) > -1) {
                        var ctaBtn = getClosestCtaBtn(froalaCursorState.currentNode, domEvent.target)
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
                            })
                                .done(function (data) {
                                    console.log('image was deleted');
                                })
                                .fail(function () {
                                    console.log('image delete problem');
                                })
                        }
                    }

                },
                'html.set': function () {
                    makePhoneClickableInTree(this.$el.get(0));
                }
            }
        });
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
    $.each(font_object, function(index, value) {
        if(fontFamilies.isNotExcluded(value)) {
            a.push(value);
        }
    });

    //adding any new font-family if found in HTML
    let newFonts = fontFamilies.get();
    if(newFonts.length) {
        a = a.concat(newFonts)
    }

    fontFamilies.load(a);
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

/**
 * insert selected template in froala editor
 * @param val
 */
function insertTemplate(val,editor){
    var type = 'insert';
    if(editor === undefined) {
        type = 'set';
    }

    /**
     * The purpose of this variable is to load template only related to currently loaded page
     * its value will be 'footer' on footer page and 'thank-you-message' on thank you message page
     * the data value is defined in footeroption.js and thankyoumesssage.js
     * this change was in accordance with requirement mentioned on A30-2090 to seperate the templates
     * for both pages so that they can contain different content based on the page.
     * if in future the template content gets changed for both pages,
     * please use this varaible to load template conditionally according to loaded page
     */
    let template = lpHtmlEditor.getTemplate(val);
    if(template) {
        if (val == 'blank_template') {
            type = "set";
            is_image_del = false;
        }
        lp_html_editor.html[type](template.html);
        lp_html_editor.undo.saveStep();
    }
}

/**
 * Helper object to load font-families from google dynamically
 *
 */
var fontFamilies = {
    isLoadCss:false,
    regex: /font-family\:.+?;/gm,
    fonts: [],
    excludeFonts: ['Arial', 'Courier New', 'Georgia', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],

    /**
     * excluding fonts those will be auto loaded
     * we won't need to load them
     * @param fontfamily
     * @returns {boolean}
     */
    isNotExcluded: function(fontfamily){
        return jQuery.inArray(fontfamily, this.excludeFonts) === -1;
    },

    /**
     * get font-families from HTML & added into font-families list if didn't found
     * @returns {*}
     */
    get: function(html) {
        let $self = this,
            fontFamilies = [],
            str = html ? html : $(".lp-froala-textbox").html(),
            m;
        // TODD: we need to remove froala-custom.js references from uncessary pages.
        if(str==undefined){
            return fontFamilies;
        }
        str = str.replace(/&quot;/g, '');
        while ((m = $self.regex.exec(str)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (m.index === $self.regex.lastIndex) {
                $self.regex.lastIndex++;
            }
            // The result can be accessed through the `m`-variable.
            m.forEach((match, groupIndex) => {
                let value = $.trim(match.replace('font-family:', '')).replace(/["';]/g, '');;
                if (!jQuery.inArray(value, $self.fonts) && fontFamilies.indexOf(value) == -1) {
                    fontFamilies.push(value);
                    console.log("font added ", value);
                }
            });
        }
        return fontFamilies;
    },

    /**
     * load font-families from HTML
     * @param el
     */
    loadFromEl: function (el) {
        let fontFamilies = this.get(el.html());
        this.load(fontFamilies);
    },

    /**
     * get and load font-families from froala editor content
     * @param editor
     */
    loadFromFroala: function (editor) {
        let fontFamilies = this.get(editor.html.get());
        this.load(fontFamilies);
    },

    /**
     * load font family, if any new font-family will be added by client
     */
    load: function(fontFamilies) {
        let $self = this;
        if(fontFamilies.length) {
            if(typeof WebFont === "object") {
                WebFont.load({
                    google: {
                        families: fontFamilies
                    }
                });
            } else {
                $self.loadGoogleWebFonts(fontFamilies);
            }
            $self.setFonts(fontFamilies);
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

        if(this.isLoadCss) {
            this.loadCss(fontFamilies);
        }
    },

    /**
     * This function is for internal use only
     * @param fontFamilies
     */
    setFonts: function (fontFamilies) {
        this.fonts = this.fonts.concat(fontFamilies);
    },

    loadCss: function(fonts) {
        if(fonts === undefined) {
            fonts = this.fonts;
        }

        if(fonts.length) {
            $.each(fonts, function (key, font) {
                try {
                    let wf = document.createElement('link');
                    wf.href = 'https://fonts.googleapis.com/css?family=' + font;
                    wf.rel = 'stylesheet';
                    let s = document.getElementsByTagName('link')[0];
                    s.parentNode.insertBefore(wf, s);
                }catch(e) {
                    console.error(e);
                }
            });
            // try {
            //     let wf = document.createElement('link');
            //     wf.href = 'https://fonts.googleapis.com/css?family=' + fonts.join("|");
            //     wf.rel = 'stylesheet';
            //     wf.crossorigin = 'anonymous';
            //     let s = document.getElementsByTagName('link')[0];
            //     s.parentNode.insertBefore(wf, s);
            // }catch (e) {
            //     console.error(e);
            // }
        }
    }
};


var lpHtmlEditor = {
    ajaxRequestHandler: null,
    getInstance: function (editorEl = ".lp-froala-textbox") {
        if(typeof editorEl !== 'object') {
            editorEl = jQuery(editorEl);
        }
        if(editorEl) {
            return editorEl[0]['data-froala.editor'];
        }
        return null;
    },

    initialized: function() {
        if(this.ajaxRequestHandler) {
            this.ajaxRequestHandler.log("Loading data & binding events -> froala initialized");
            this.ajaxRequestHandler.loadFormSavedValues();
        }
    },

    getTemplate(template) {
        return this.templates[template];
    },

    getTemplatesAsOptions: function (){
        let $self = this,
            options = {};
        // jQuery.each(this.templates, function(template, key){
        //     options[key] = template.title;
        //     console.log(key, template.title);
        // });
        for(let key in $self.templates) {
            options[key] = $self.templates[key].title;
        }
        return options;
    },

    templates: {
        'blank_template': {
            title: 'Blank Template',
            html: ""
        },
        'branded_template': {
            title:'Co-Branded Template',
            html: "<div class='container advanced-container branded-template-section'><div class='co_branded'><table class='fr-no-border' style='width: 100%; text-align: center;'><tbody><tr><td style='width: 50.0000%;text-align: left;'><div class='lp-contact-review'><div><span class='lp-contact-review__img'><img class='lozad fr-fic fr-dii co-branded-image fr-rounded' alt='Leo Lender' title='Leo Lender' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/co_branded_template1.png'></span><div class='info'><h6><strong>Leo Lender</strong></h6><p><strong>Senior Loan Officer<br>XYZ Mortgage Company, Inc.<br>NMLS #123456</strong></p><div><br></div></div></div></div></td><td style='width: 50.0000%;text-align: left;'><div class='lp-contact-review'><div><span class='lp-contact-review__img'><img class='lozad fr-fic fr-dii co-branded-image fr-rounded' alt='Roxy Realtor' title='Roxy Realtor' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/co_branded_template2.png'></span><div class='info'><h6><strong>Roxy Realtor</strong></h6><p><strong>Real Estate Broker<br>XYZ Realty Company, Inc.<br>NMLS #123456</strong></p><div><br></div></div></div></div></td></tr></tbody></table></div></div><p></p>"
        },
        'cta_template_left_img': {
            title: 'CTA Template (media left)',
            html: '<div class="container advanced-container media-left-template-section"><div class="row"><br><table class="fr-no-border fr-thick" style="text-align: center;margin: 0 20px;width: 100%"><tbody><tr><td style="width: 50.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/cta_template_img_1.png" style="width: 300px;" class="fr-fic fr-dib fr-fil"></td><td style="width: 50%; text-align: center;"><div class="heading-wrap"><span style="font-family: Orbitron;"><strong>Instantly get a fast, free, <br>and no-obligation <br>digital rate quote.</strong></span></div><br><div><p class="text-wrap">Answer some super easy questions and we&#39;ll provide you with a fast and hassle-free digital rate quote in just&nbsp;seconds.</p></div><br><span style="font-size: 26px; color: rgb(184, 49, 47);"><span class="cta-btn-wrap"><a href="#GetStartedNow" class="za_cta_style fr-strong" id="cta_active">&nbsp;Get Started Now!</a></span></span></td></tr></tbody></table></div><div class="row" style="text-align: center;"><br></div><div class="row" style="text-align: left;"></div></div><p></p>'
        },
        'cta_template_right_img': {
            title: 'CTA Template (media right)',
            html: '<div class="container advanced-container media-right-template-section"><div class="row"><br><table class="fr-no-border fr-thick" style="text-align: center;margin: 0 20px;width: 100%"><tbody><tr><td style="width: 50%; text-align: center;"><div class="heading-wrap"><span style="font-family: Orbitron;"><strong>Instantly get a fast, free, <br>and no-obligation <br>digital rate quote.</strong></span></div><br><div><p class="text-wrap">Answer some super easy questions and we&#39;ll provide you with a fast and hassle-free digital rate quote in just&nbsp;seconds.</p></div><br><span style="font-size: 26px; color: rgb(184, 49, 47);"><a href="#GetStartedNow" class="za_cta_style fr-strong" id="cta_active">&nbsp;Get Started Now!</a></span></td><td style="width: 50.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/cta_template_img.png" style="width: 300px;" class="fr-fic fr-dib fr-fil"></td></tr></tbody></table></div><div class="row" style="text-align: center;"><br></div><div class="row" style="text-align: left;"></div></div><p></p>'
        },
        'default_template': {
            title: 'Default Template',
            html: '<div class="container advanced-container default-template default-template-section"> <div class="row"> <div class="col-sm-12"><h2 class="funnel__title"><span><strong>How this&nbsp;works...</strong></span></h2></div></div><div class="clearfix" style="height: 0;"></div><div class="row"> <div class="col-lg-5"> <div class="box funnel__box"> <div class="box__counter">1</div><div class="box__content"> <h3 class="box__heading"><span style="font-size: 20px;">60-Second Digital&nbsp;Pre-Approval</span></h3> <p class="box__des">Share some basic info; if qualified, we&#39;ll provide you with a free,<span style="white-space: nowrap"> no-obligation</span> <span style="white-space: nowrap">pre-approval</span>&nbsp;letter.</p></div></div><div class="box funnel__box"> <div class="box__counter">2</div><div class="box__content"> <h3 class="box__heading"><span style="font-size: 20px;">Choose the Best Options for&nbsp;You</span></h3> <p class="box__des">Choose from a variety of loan options, including our conventional 20% down&nbsp;product. <br><br>We also offer popular 5%-15% down home loans... AND we can even go as low as 0%&nbsp;down.</p></div></div><div class="box funnel__box"> <div class="box__counter">3</div><div class="box__content"> <h3 class="box__heading"><span style="font-size: 20px;">Start Shopping for Your&nbsp;Home!</span></h3> <p class="box__des">It only takes about 60 seconds to get everything under way. Simply enter your zip code right&nbsp;now.</p></div></div><div style="text-align: center;margin: 20px auto;"><a class="lp-btn__go za_cta_style fr-strong" href="#GetStartedNow" id="cta_active" tabindex="-1" title="">Get Started Now!</a></div><div class="funnel__caption"> <p style="text-align: center; margin-left: 20px;"><em><span style="font-size: 11px;max-width: 287px;">This hassle-free process only takes about 60&nbsp;seconds, and it won&#39;t affect your credit&nbsp;score!</span></em></p><p> <br></p></div></div><div class="col-lg-7"> <div class="animate-container"> <div class="first animated desktop slideInRight"><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-1.png" class="fr-fic fr-dii"></div><div class="second animated desktop fadeIn"> <h2 class="animate__heading" style="font-size: 18px;"><span style="font-size: 18px;">Share some basic info</span></h2><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-2.png" class="fr-fic fr-dii"></div><div class="third animated desktop zoomIn"><strong><span style="color: rgb(3, 177, 253); font-size: 18px;">10% Down</span></strong></div><div class="fourth animated desktop fadeInLeft"><img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-4.png" class="fr-fic fr-dii"></div><div class="fifth animated desktop slideInRight"> <p style="max-width: 188px;"><span class="clientfname">Hi, I&#39;m ' + $("#clientfname").val() + ', your loan&nbsp;</span>officer. It looks like you may qualify for a lot more than you&nbsp;thought!</p></div></div><div class="clearfix"></div><p></p></div><br></div></div><p></p>'
        },
        'property_template': {
            title: 'Property Template',
            html: '<div class="container advanced-container property_template Property property-template-section"> <div class="row" style="text-align: center;"> <p class="col-md-12 heading-wrap"><span style="font-family: Poppins; font-size: 40px; color: rgb(40, 50, 78);">Beautiful San Diego Home for&nbsp;Sale</span></p></div><div class="row"><br/></div><div class="row"><br/></div><div class="row"> <table class="fr-no-border" style="width: 100%;"> <tbody> <tr> <td style="width: 50.1458%;"> <p data-unit="px" data-web-font="Arial, Helvetica, sans-serif"> <span style="color: rgb(40, 50, 78); font-size: 28px;"><strong>$3,750,000</strong></span> </p><p data-unit="px" data-web-font="Arial, Helvetica, sans-serif" style="color: rgb(40, 50, 78); font-size: 16px; margin: 0;"><strong>631 Ocean Blvd</strong></p><p style="color: rgb(40, 50, 78); font-size: 16px; margin: 0;"><strong>Coronado, CA 92118</strong></p><p style="color: rgb(40, 50, 78); font-size: 16px; margin: 0;"><strong>4 Bedroom | 4&nbsp;Bathroom | 3,270&nbsp;Sqft |2016&nbsp;Built&nbsp;</strong></p><hr/> <div style="font-size: 16px;"> <strong><span style="color: rgb(40, 50, 78);">Single Family Home |&nbsp;MLS #312836&nbsp;|</span>&nbsp;<span style="color: rgb(97, 189, 109);">Active</span></strong> </div><br/> It is hard to believe but sometimes you can get better than new! This home is in perfect, like new condition and has features you can&#39;t get or afford from a builder. Neutral grey colors and warm wood floors throughout the home, welcome you home! Spacious living area has stone fireplace! Kitchen is fit for a chef with stainless steel appliances, white cabinets and quartz counter&nbsp;tops! <br/> <br/> Master suite is spacious and well laid out and has wood floors and a spa like bath! Home has large secondary rooms, large office and 3 full baths. Backyard is where it is at! Home features nice covered patio with extended rock patio. Awesome lot that features views of the beach and backs up to no&nbsp;one! </td><td style="width: 49.8542%;"> <br/> <img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-1.jpeg" style="width: 495px;" class="fr-fic fr-dib"/> <div data-empty="true" style="text-align: center;"><br/></div><div data-empty="true" style="text-align: center;"> <span style="color: rgb(44, 130, 201);"><u>Start Photo Slideshow</u></span> | <span style="color: rgb(44, 130, 201);"><u>Virtual Tour</u></span> </div></td></tr></tbody> </table> </div><div class="row"> <div><br/></div><table class="fr-no-border" style="width: 100%;"> <tbody> <tr> <td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-2.jpeg" style="width: 248px;" class="fr-fic fr-dib"/></td><td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-3.jpeg" style="width: 248px;" class="fr-fic fr-dib"/></td><td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-4.jpeg" style="width: 248px;" class="fr-fic fr-dib"/></td><td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-5.jpeg" style="width: 248px;" class="fr-fic fr-dib"/></td></tr><tr> <td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-6.jpeg" style="width: 248px;" class="fr-fic fr-dib"/></td><td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-7.jpeg" style="width: 248px;" class="fr-fic fr-dib"/></td><td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-8.jpeg" style="width: 248px;" class="fr-fic fr-dib"/></td><td style="width: 25%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-9.jpeg" style="width: 244px;" class="fr-fic fr-dib"/></td></tr></tbody> </table> <div style="text-align: center;"><br/></div><div style="text-align: center;"> <span style="font-size: 15px;"><br/></span> </div><div style="text-align: center;"> <p class="below-text-wrap"><span style="font-size: 15px;"> Click below to see if you qualify for this home. If yes, we&#39;ll provide you with a FREE, no-obligation pre-approval letter, PLUS we&#39;ll send you additional full-size photos, a 3D virtual tour link, and a detailed property report on this&nbsp;listing! </span></p> </div><div style="text-align: center;"><br/></div><div style="text-align: center;"><br/></div><div style="text-align: center;"> <span style="font-size: 24px;"><a href="#GetStartedNow" class="za_cta_style fr-strong" id="cta_active">&nbsp;See if You Qualify for This Home Now!</a></span> </div><div style="text-align: center;"><br/></div><div style="text-align: center;"> <br/> <p class="bottom-text-wrap"><span class="bottom-text"><em style="font-size: 14px;">This simple quiz only takes about 60 seconds and it won&#39;t affect your credit&nbsp;score!</em></span></p> </div><div style="text-align: center;"><br/></div><hr/> <div class="author-info-area"> <div><br/></div><p class="sub-text">Listing brought to you by:</p><p class="sub-text">Shelly Jackson, Broker</p><p class="sub-text">Keller Williams Premier Properties</p></div><br/></div></div></div></div><p></p>'
        },
        'property_template2': {
            title: 'Property Template 2',
            html: '<div class="property_template2 property2-template-section"><p class="property2-template-heading-wrap"><strong class="property2-template-heading" style=" line-height: 1.15; font-family: Oxygen;"><span><strong>&nbsp;Spectacular Must-See La Jolla, California Home for&nbsp;Sale</strong></span></strong></p><p class="top-arrow-wrap" style="text-align: center; font-size: 26px; font-family: Oxygen;"><strong>&nbsp;~&nbsp;</strong></p><p class="check-out-text" style="text-align: center; font-family: Oxygen; color: rgb(26, 188, 156);">Check Out the 3D Virtual Tour&nbsp;Below!</p><div style="text-align: center;"></div><div style="text-align: center; padding: 0 25px; box-sizing: border-box;"><iframe width="100%" height="500" src="https://my.matterport.com/show/?m=JGPnGQ6hosj&play=1" frameborder="0" allowfullscreen=""></iframe></div><div style="text-align: center;"><br></div><div class="container advanced-container" style="font-family: Open Sans;"><br /><p class="amount-text" data-unit="px" data-web-font="Arial, Helvetica, sans-serif" style="margin: 0;"><strong>$3,750,000</strong></p><p class="name-title" style="margin: 0;"><strong>San Diego, CA 92124</strong></p><p style="margin: 0;" class="info-text"><strong>4 Bedroom | 4 Bathroom | 3,270&nbsp;SqFt | 2016&nbsp;Built</strong></p><p style="font-size: 12px;padding: 18px 0;"><a href="#GetStartedNow" class="za_cta_style fr-strong" id="cta_active">&nbsp;Get Pre-Approved!</a></p><hr><p class="heading-text"><strong><span>Single Family Home | MLS&nbsp;#312836 | </span><span style="color: rgb(97, 189, 109);">Active</span></strong></p><p class="detail-text-area">It is hard to believe but sometimes you can get better than new! This home is in perfect, like new condition and has features you can&#39;t get or afford from a builder. Neutral grey colors and warm wood floors throughout the home, welcome you home! Spacious living area has stone fireplace! Kitchen is fit for a chef with stainless steel appliances, white cabinets and quartz counter&nbsp;tops!<br><br></p><p class="detail-text-area">Master suite is spacious and well laid out and has wood floors and a spa like bath! Home has large secondary rooms, large office and 3 full baths. Backyard is where it is at! Home features nice covered patio with extended rock patio. Awesome lot that features views of the beach and backs up to no&nbsp;one!</p><div class="row"><br></div><div class="row"><div><br></div><table class="fr-no-border" style="width: 100%;"><tbody><tr><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-2.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-3.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img' +
            ' src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-4.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-5.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td></tr><tr><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-6.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img' +
            ' src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-7.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img' +
            ' src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-8.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td><td style="width: 25.0000%;"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/property-image-9.jpeg" style="width: 248px;" class="fr-fic fr-dib"></td></tr></tbody></table><div style="text-align:' +
            ' center;"><br></div><div style="text-align: center;"><span style="font-size: 15px;"><br></span></div><div style="text-align: center;"><p style="font-size: 15px;margin: 0;">Click below to see if you qualify for this home. If yes, we&#39;ll provide you with a FREE, no-obligation pre-approval letter,&nbsp;</p><p style="font-size: 15px;margin: 0;">PLUS we&#39;ll send you additional full-size photos, a 3D virtual tour link, and a detailed property report on this&nbsp;listing!</p></div><div style="text-align: center;"><br></div><div style="text-align: center;"><br></div><div style="text-align: center;"><span style="font-size: 24px;"><a href="#GetStartedNow" class="za_cta_style fr-strong" id="cta_active">&nbsp;See if You Qualify for This Home Now!</a></span></div><div style="text-align: center;"><br></div><div style="text-align: center;"><br><p class="bottom-info-text"><em>This simple quiz only takes about 60 seconds and it won&#39;t affect your credit&nbsp;score!</em></p></div><div style="text-align: center;"><br></div><hr><div style="text-align: left;"><br></div><div class="author-info-area"> <p class="sub-text">Listing brought to you by:</p><p class="sub-text">Shelly Jackson, Broker</p><p class="sub-text">Keller Williams Premier Properties</p></div><p class="author-info-bottom-text"><em>*Pre-approval is based on a preliminary review of credit information provided to POP Mortgage Corp. which has not been reviewed by Underwriting. Final loan approval is subject to a full</em><em>Underwriting review of support documentation including, but not limited to, applicants’ creditworthiness, assets, income information, and a satisfactory appraisal.</em></p></div>'
        },
        'review_template': {
            title: 'Review Template',
            html: "<div class='lp-contact-review reivew-template review-template-section'><div class='block-quote'><p><em>&ldquo;Our experience with John from XYZ Company was a breath of fresh air! With a super fast closing and great communication every step of the way, we couldn't ask for more. Thank&nbsp;you!&rdquo;</em></p></div><div class='desc'><div class='desc-wrap'><span class='lp-contact-review__img'><img class='review-image" +
            " fr-rounded lozad fr-dii' data-src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/iconfinder_Woman.svg' alt='' title='' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/iconfinder_Woman.svg' data-loaded='true'></span><div class='info'><h6><strong>Sally Q. Homebuyer</strong></h6><div><p><strong>First-time Homebuyer | Somewhere, California</strong></p></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><div class = 'rating-wrapper'><img class='rating' src='https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/stars1.1.png'></div><p></p></div></div></div><div class='clearfix'></div></div><p></p>"
        },
        'secure_clix_template': {
            title: 'Secure-Clix Template',
            html: '<div class="container advanced-container secure_clix_template secure-clix-template-section"><div style="text-align: center;"><div class="secure-logo-wrap"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/secure-clix-security.png" style="width: 53px;" class="fr-fic fr-dib"></div><div class="heading-text-holder"><p class="heading-text-wrap"><strong><span style="font-family: Orbitron;font-size: 22px;color:#000000;">Secure-Clix: <span style="color: rgb(26, 188, 156);">SAFE-SITE</span></span></strong></p><p class="sub-text-wrap"><span class="sub-text">THIS WEBSITE DOES <u>NOT</u> SELL YOUR&nbsp;INFORMATION</span></strong></div> <br><div class="arrow-image-wrap"><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/secure-clix-arrowdown.png" style="width: 38px;" class="fr-fic fr-dib"></div><p class="secure-template-title"><strong>&nbsp;<span style="font-size: 30px; font-family: Palanquin;color: rgb(0, 0, 0);">&nbsp;Beware of &quot;Internet Lead&quot; websites like:<br>Zillow<sub>&reg;</sub>, Realtor.com<sub>&reg;</sub>, LendingTree<sub>&reg;</sub>,<br>Quicken Loans<sub>&reg;</sub>, LowerMyBills<sub>&reg;</sub>, etc.&nbsp;</span>&nbsp;</strong></p></div> <br><div style="text-align: center;"><div class="main-content-area" style="font-family: Palanquin;"><p><span><strong>&nbsp;It turns out selling your personal information is not just<br>&nbsp;insanely profitable for big social media tech companies.</strong></span></p> <br><p>Internet lead websites&mdash;like those listed above...</p> <br><p>Their ENTIRE existence depends on capturing and selling<br>consumer information online.</p> <br><p>That means if, heaven forbid, you fill something out on one of<br>those websites, they will take and SELL your personal information...</p> <br><p>Often to 10-20 (or more) organizations and individual salespeople.</p> <br><p>You&#39;ll get hounded&mdash;mostly by banks with big call centers, and a<br>whole bunch of loan officers and real estate agents from all over<br>the US.</p> <br><p>It&#39;s a nightmare.</p> <br><p>You may have to move out of the country to escape.</p> <br><p>OK, I&#39;m kidding about having to move out of the country.</p> <br><p><span><strong>&nbsp;But&mdash;using those websites WILL result in an onslaught of unwanted<br>phone calls, emails, and text messages from aggressive &ldquo;<strong>Boiler Room&quot;</strong><br>style salespeople&mdash;often for months without end.<br></strong></span></p> <br><p>Don&#39;t take my word for it, though</p> <br><p>You can see it for yourself.</p> <br><p>By law, they&#39;re forced to admit to all of this (and much more)<br>in their website privacy policies.</p><br><p>This dystopian hellscape I&#39;m describing is known as the<br>&quot;internet lead industry.&quot; </p><br><p>When you&#39;re searching on one of those internet lead websites...</p> <br><p>That&#39;s all you are to them. </p><br><p>An &quot;internet lead.&quot; </p><br><p>lead whose information they can sell for a lot of money. </p><br><p>Over and over again. </p><br><p><span><strong>These websites make billions of dollars doing this.</strong></span></p> <br><p>And there are a TON of these types of internet lead websites out there.</p> <br><p>Big companies with household names, like the ones listed above (and many more),<br>whose business model is just basically getting web traffic and selling internet leads.</p> <br><p>It&#39;s how they fund their ginormous websites and advertising campaigns.</p> <br><p>Let me cut to the chase.</p> <br><p><span><strong>I&#39;m sharing all of this because that&#39;s <u>NOT</u> what we do.</strong></span></p> <br><p>We&#39;re A LOT different.</p> <br><p><span><strong>While you may find us listed on websites like Zillow, that&#39;s about all we have in<br>common.</strong></span></p> <br><p>We&#39;re an actual mortgage lender, not an internet middleman or data re-seller.</p> <br><p>We take extra security precautions, and <u>we do not sell your information to 3rd parties</u>.</p><br><p><span><strong>That&#39;s why this website is a&nbsp;</strong></span> <span style="font-family: Orbitron;"><strong>Secure-Clix: <span style="color: rgb(26, 188, 156);">SAFE-SITE</span></strong></span></p> <br><p>So you can shop for your new home and a mortgage loan, and get answers, without <br>getting hassled.</p> <br><img src="https://97ef80c3dd73167a36b8-170a2364f5ad6ce92aa698d6ee4aeaa4.ssl.cf2.rackcdn.com/default/images/advancedfooter/secure-clix-horizontaldotshidden.png" style="width: 55px;" class="fr-fic fr-dib"><p class="bottom-text-wrap"><span class="bottom-text" style="font-family: Palanquin;">Secure-Clix helps you identify when you&#39;re on a website that SAFEGUARDS your personal information.</span></p></div> <br><div data-empty="true" style="text-align: center;"><span class="cta-btn-wrap" style="font-size: 28px;"><a href="#GetStartedNow" class="za_cta_style fr-strong" id="cta_active" style="font-family: Palanquin;">&nbsp;AWESOME, NOW GET&#39;S STARTED!</a></span></div></div></div>'
        },
        'personally_branded': {
            title: 'Personally Branded',
            html: '<div class="personally-branded-section"><div class="personally-branded-container"><div class="personally-branded-template"><div class="personally-branded-detail"><div class="personally-branded-detail-wrap"><div class="detail-left-content"><div class="image-holder"><div class="image-wrap"><img class="personally-branded-image fr-rounded fr-dii" src="https://images.lp-images1.com/default/images/personall-branded-image02.png" alt="image-description"></div></div><div class="personally-branded-heading"><div class="name-wrap"><h2 class="name"><strong>'+contact_full_name+'</strong></h2><h3 class="desination">Loan Officer</h3></div><div class="info-wrap"><h3 class="number"><a href="tel:'+phone_number+'">'+phone_number+'</a></h3><h3 class="email"><a href="#">'+contact_email+'</a></h3></div></div></div><div class="personally-branded-description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi quam dui, condimentum commodo ullamcorper sit amet, malesuada sit amet erat. In et ultrices mauris. Sed imperdiet leo sapien, in porta sem suscipit efficitur. Proin sed molestie neque, vel dignissim ante. Proin vitae risus a diam rhoncus feugiat. Praesent placerat nibh eget tempor finibus. Aliquam pulvinar nibh eu consectetur consectetur. </p></div></div><div class="quote-area"><h2 class="quote-title"><strong>Get Your mortgage rate Quote</strong></h2><span class="btn-wrap"><a class="fr-strong za_cta_style brand-cta-btn" href="#GetStartedNow" id="cta_active" tabindex="-1">I want my free mortgage rate quote</a></span></div></div></div></div></div>'
        }
    }
}
