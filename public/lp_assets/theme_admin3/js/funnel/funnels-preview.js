var FunnelsPreview = {
    /**
     * any functionality execute to use this callback function
     */
    callback: function(){},

    /**
     * Refresh handle bar function to get latest json from local storage
     * @param key
     * @param questionId
     */
    refreshHandlebar: function (key, questionId) {
        // get question json
        FunnelsUtil.ls_key = key;
        window.funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        window.ques_id = questionId;
        window.json = funnel_info.questions[questionId];
        window.json['meta'] = funnel_info.meta;
        this.transformData();
    },


    /* Froala font size reduce on mobile mode */
    getChildrenToChangeFontSize: function($element) {
        let elements = [];
        jQuery.each($element.find('span[style]'), function(i, childWithStyle){
            let fontSize = parseInt(childWithStyle.style.fontSize);
            if(fontSize > 0) {
                elements.push({
                    el: childWithStyle,
                    fontSize: fontSize
                });
            }
        });
        return elements;
    },


    /* Apply Reduce font size on mobile mode */
    applyChildrenFontSize: function(els, isDesktop = true) {
        if(els.length) {
            jQuery.each(els, function (i, obj) {
                jQuery(obj.el).css('font-size', isDesktop ? obj.fontSize : (obj.fontSize * 0.75));
            });
        }
    },

    /* Desktop font function */
    desktopFont: function(e) {
        let button = jQuery('.btn-secondary')[0];
        let button_icon = jQuery('.btn-secondary .icon-wrap .icon')[0];
        let security_icon = jQuery('.privacy .privacy-icon')[0];
        let cta_heading = jQuery('.cta-message h1')[0];
        let cta_description = jQuery('.description-text')[0];

       window.fontHandler = {
            /* Froala font size */
            'heading': FunnelsPreview.getChildrenToChangeFontSize(jQuery('.question-heading-text')),
            'description': FunnelsPreview.getChildrenToChangeFontSize(jQuery('.question-description-text')),
            'additional_content': FunnelsPreview.getChildrenToChangeFontSize(jQuery('.additional-content-text')),

            /* Font size reduce without span */
            'button': button !== undefined ? button.style && button.style.fontSize ? parseInt(button.style.fontSize) : 0 : 0,
            'button_icon':  button_icon !== undefined ? button_icon.style && button_icon.style.fontSize ? parseInt(button_icon.style.fontSize) : 0 : 0,
            'security_icon':  security_icon !== undefined ? security_icon.style && security_icon.style.fontSize ? parseInt(security_icon.style.fontSize) : 0 : 0,
            'cta_heading':  cta_heading !== undefined ? cta_heading.style && cta_heading.style.fontSize ? parseInt(cta_heading.style.fontSize) : 0 : 0,
            'cta_description':  cta_description !== undefined ? cta_description.style && cta_description.style.fontSize ? parseInt(cta_description.style.fontSize) : 0 : 0,
        };
        //load fonts family
        FunnelsPreview.getFontFamilies();
    },

    /* FontChange function */
    fontChanges: function (e) {

        if(typeof window.fontHandler !== "object") {
            return false;
        }

        let isDesktop = true,
            deepCopy = Object.assign({}, window.fontHandler);

        /* Mobile mode condition */
        if(jQuery('.mobile-preview').hasClass('mobile-view')) {
            isDesktop = false;
            deepCopy.button = deepCopy.button * 0.75;
            deepCopy.button_icon = deepCopy.button_icon * 0.75;
            deepCopy.security_icon = deepCopy.security_icon * 0.75;
            deepCopy.cta_heading = deepCopy.cta_heading * 0.75;
            deepCopy.cta_description = deepCopy.cta_description * 0.75;
        }

        /* Froala font size update */
        FunnelsPreview.applyChildrenFontSize(deepCopy.heading, isDesktop);
        FunnelsPreview.applyChildrenFontSize(deepCopy.description, isDesktop);
        FunnelsPreview.applyChildrenFontSize(deepCopy.additional_content, isDesktop);

        /* font size update */
        if(deepCopy.button > 0 ) {
            jQuery('.btn-secondary').css('font-size', deepCopy.button + 'px');
        }
        if(deepCopy.button_icon > 0 ) {
            jQuery('.btn-secondary .icon-wrap .icon').css('font-size', deepCopy.button_icon + 'px');
        }
        if(deepCopy.security_icon > 0 ) {
            jQuery('.privacy .privacy-icon').css('font-size', deepCopy.security_icon + 'px');
        }
        if(deepCopy.cta_heading > 0 ) {
            jQuery('.cta-message h1').css('font-size', deepCopy.cta_heading + 'px');
        }
        if(deepCopy.cta_description > 0 ) {
            jQuery('.description-text').css('font-size', deepCopy.cta_description + 'px');
        }
    },

    /* Scale on question preview question */
    slide_scale: function (slideEvt) {
        jQuery('.funnel-iframe-inner-wrap').css('transform','scale('+slideEvt/100+')');
    },

    /**
     * On receiving Post message trigger in iframe
     */
    changesTrigger: function () {
        let previewType = "desktop-preview",
            scrollTop = undefined;
        this.bindEvent(window, 'message', function (e) {
            if($(".funnel-iframe-inner-holder").length) {
                let $scrollerOuter = $( '.mCustomScrollbar' ),
                    $dragger       = $scrollerOuter.find( '.mCSB_dragger' ),
                    scrollHeight   = $scrollerOuter.find( '.mCSB_container' ).height(),
                    draggerTop     = $dragger.position().top;
                    scrollTop = draggerTop / ($scrollerOuter.height() - $dragger.height()) * (scrollHeight - $scrollerOuter.height());
            }
            if(FunnelsPreview.isMessagesModule === 1){
                FunnelsPreview.refreshHandlebarSecurityMessage(FunnelsUtil.ls_key, window.ques_id);
            } else {
                FunnelsPreview.refreshHandlebar(FunnelsUtil.ls_key, window.ques_id);
            }
            if (e.data === "refresh-data") {
                FunnelsPreview.callback(true);
                if(previewType === "mobile-preview") {
                    $(".mobile-preview").addClass('mobile-view');
                    $(".funnel-iframe-inner-wrap").addClass('mobile-view-active');
                    $(".funnel-iframe-inner-holder").addClass('mobile-view-parent').mCustomScrollbar("update");
                }
                FunnelsPreview.desktopFont();
            } else if (e.data === "no-refresh-data") {
                FunnelsPreview.callback(false);
            } else if (e.data === "mobile-preview") {
                $(".mobile-preview").addClass('mobile-view');
                $(".funnel-iframe-inner-wrap").addClass('mobile-view-active');
                $(".funnel-iframe-inner-holder").addClass('mobile-view-parent').mCustomScrollbar("update");
                FunnelsPreview.fontChanges();
                previewType = e.data;
            } else if (e.data === "desktop-preview") {
                $(".mobile-preview").removeClass('mobile-view');
                $(".funnel-iframe-inner-wrap").removeClass('mobile-view-active');
                $(".funnel-iframe-inner-holder").removeClass('mobile-view-parent').mCustomScrollbar("update");
                FunnelsPreview.fontChanges();
                previewType = e.data;
            } else if (e.data.hasOwnProperty('scale-view')) {
                FunnelsPreview.slide_scale(e.data['scale-view']);
            }

            // set iframe height
            FunnelsPreview.setIframeHeight(scrollTop);
            FunnelsPreview.froala_font_size();
            FunnelsPreview.froala_video_resize();
            FunnelsPreview.preview_height();
            FunnelsPreview.preview_scaling();
            FunnelsPreview.privacy_text_aligment();

            // show/hide header footer on full screen
            if (json.hasOwnProperty('meta') && json['meta']['full_screen'] !== undefined && json['meta']['full_screen'] == 1) {
                $('.mobile-preview').addClass('funnel-header-active funnel-footer-active');
                $(".funnel-iframe-inner-holder").addClass('iframe-full-screen-preview');
            } else {
                $('.mobile-preview').removeClass('funnel-header-active funnel-footer-active');
                $(".funnel-iframe-inner-holder").removeClass('iframe-full-screen-preview');
            }
            //load fonts family
            FunnelsPreview.getFontFamilies();
            FunnelsUtil.exitFullScreen();
        });
    },

    /**
     * Bind post message
     * @param element
     * @param eventName
     * @param eventHandler
     */
    bindEvent: function (element, eventName, eventHandler) {
        if (element.addEventListener) {
            element.addEventListener(eventName, eventHandler, false);
        } else if (element.attachEvent) {
            element.attachEvent('on' + eventName, eventHandler);
        }
    },

    /**
     * hide button until question isn't answered
     * @param current_slide
     */
    hideUntilNotAnswered: function (is_hide_until_not_answered, isValidated=false) {
        let cta_button = jQuery(".cta-btn-wrap");
        //when enable-hide-until-answer is enabled than hide button until user not answered question
        if(Number(is_hide_until_not_answered) && !isValidated) {
            cta_button.addClass('hide-btn');
        } else {
            cta_button.removeClass('hide-btn');
        }
    },

    /**
     * handle menu/dropdown alphabetize sorting
     * @param questionJson
     */
    handleAlphabetizeOptions: function (questionJson) {
        let is_alphabetize = (questionJson['options']['alphabetize'] == 1);
        FunnelsUtil.alphabetizeOptions(is_alphabetize, questionJson['options']['fields']);
    },


    /**
     * handle dropdown alphabetize and randomize sorting
     * @param questionJson
     */
    handleAlphabetizeAndRandomizeSort: function (questionJson) {
        let is_alphabetize = (questionJson['options']['alphabetize'] == 1),
            is_randomize = (questionJson['options']['randomize'] == 1);
        if(is_alphabetize) {
            FunnelsUtil.alphabetizeOptions(is_alphabetize, questionJson['options']['fields']);
        } else if(is_randomize) {
            questionJson['options']['fields'] = FunnelsUtil.randomizeSort(questionJson['options']['fields']);
        }
    },

    // Froala Editor preivew font size

    froala_font_size: function() {
        jQuery('[froala-prview-size] span').each(function(){
            if (jQuery(this).is(':empty')) {
                jQuery(this).parent('p').remove();
            }
        });

        jQuery('[froala-prview-size] p').each(function(){
            if (jQuery(this).is(':empty')) {
                jQuery(this).remove();
            }
        });
    },

    // Froala Editor preivew video resizer
    froala_video_resize: function() {
        jQuery('.fr-video iframe').each(function(){
            var parent_width = jQuery('.cta-preview-col').width();
            var element_width = jQuery('.fr-video').width();

            if (parent_width < element_width) {
                jQuery(this).parent('.fr-video').addClass('iframe-resize');
            }
            else {
                jQuery(this).parent('.fr-video').removeClass('iframe-resize');
            }
        });
    },

    // preview condition according to the height
    preview_height: function() {
        var parent_height = jQuery('.cta-feature-preview-holder .row').height();
        if (parent_height > 520) {
            jQuery('.funnel-iframe-inner-holder').addClass('dropdown-up');
        }
        else {
            jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-up');
        }
    },

    // Privcay Text Alignment Function
    privacy_text_aligment: function() {

        if ((jQuery('.privacy-text li').css('text-align') == 'left') || (jQuery('.privacy-text p').css('text-align') == 'left')) {
            jQuery('.privacy-text').addClass('left-align');
        }
        else {
            jQuery('.privacy-text').removeClass('left-align');
        }

        if ((jQuery('.privacy-text li').css('text-align') == 'right') || (jQuery('.privacy-text p').css('text-align') == 'right')) {
            jQuery('.privacy-text').addClass('right-align');
        }
        else {
            jQuery('.privacy-text').removeClass('right-align');
        }

        if(jQuery('.description-text').is(':empty') || jQuery('.description-text span').is(':empty')) {
            jQuery('.cta-description').addClass('empty');
        }
        else {
            jQuery('.cta-description').removeClass('empty');
        }

        if(jQuery('.cta-message-heading span').is(':empty')) {
            jQuery('.cta-message-heading').addClass('empty');
        }
        else {
            jQuery('.cta-message-heading').removeClass('empty');
        }

        var childdivs = jQuery('[froala-prview-size] span');
        var withbackground = childdivs.filter('[style*=background-color]');

        jQuery(withbackground).addClass('background-added');
    },

    // Preview Scaling Function
    preview_scaling: function() {
       var boxWidth = jQuery(window).width();
       var parentWidth = jQuery(parent.window).width();
       var sidePanel = 420;
       var getScale = boxWidth / 1330;
       var boxHeight = 1 - getScale;
       var parentwindowHeight = jQuery(window.parent.document).height();
       var parentHeight = jQuery(window).height();
       var getScaleHeight = parentHeight + (parentHeight * boxHeight);
        if (getScale > 1) {
            return false;
        }
        else {
            jQuery('.funnel-iframe-inner-wrap').css({'transform': 'scale('+getScale+')'});
        }
    },

    /**
     * show/hide CTA button
     * @param enable_hide_until_answer
     * @param funnel_info
     */
    setCTAButtonMode: function(enable_hide_until_answer, funnel_info) {
        if (enable_hide_until_answer == 1) {
            $('.cta-btn-wrap').addClass('hide-btn');
            $('#hide_cta').val(1);
        } else {
            $('.cta-btn-wrap').removeClass('hide-btn');
            $('#hide_cta').val(0);
        }

        // show CTA button if input has 2 characters or more
        if (funnel_info.question_value.length >=2) {
            $('.cta-btn-wrap').removeClass('hide-btn');
        }
    },
    /**
     * Transform data to load in handle bar view
     * @param json
     * @param funnel_info
     */
    transformData: function() {
        if(json['question-type'] == 'contact') {
            let active_step = json['options']['activesteptype'] - 1;
            let active_slide = json.hasOwnProperty('active_slide') ? json['active_slide'] : 0;
            json['options']['all-step-types'][active_step]['steps'][active_slide] = FunnelsUtil.getOptionsValue(json['options']['all-step-types'][active_step]['steps'][active_slide]);
            // set security message
            let selected_val = json['options']['all-step-types'][active_step]['steps'][active_slide]['security-message-id'];
            let selected_val_index = FunnelsUtil.getTcpaMessageIndex(selected_val, funnel_info.tcpa_messages);
            if(funnel_info.tcpa_messages[selected_val_index]) {
                let icon = JSON.parse(funnel_info.tcpa_messages[selected_val_index]['icon']);
                let text_style = JSON.parse(funnel_info.tcpa_messages[selected_val_index]['tcpa_text_style']);
                let tcpa_message_is_required = funnel_info.tcpa_messages[0]['is_required'] || false;
                json['options']['all-step-types'][active_step]['steps'][active_slide]['security_tcpa_messages'] = (icon.enabled ? '<i class="privacy-icon ' + icon.icon + '" style="font-size:' + icon.size + 'px;color:' + icon.color + '"></i>' : '') + '<span style="' + (text_style.is_bold ? 'font-weight:bold;' : '') + '' + (text_style.is_italic ? 'font-style:italic;' : '') + 'color:' + text_style.color + '">' + funnel_info.tcpa_messages[selected_val_index]['tcpa_text'] + '</span>';
                // icon alignment
                json['options']['all-step-types'][active_step]['steps'][active_slide]['icon-position'] = icon.position;
                json['options']['all-step-types'][active_step]['steps'][active_slide]['tcpa_message_is_required'] = tcpa_message_is_required;
            }
            json['options']['all-step-types'][active_step]['steps'][active_slide]['question_value'] = funnel_info.question_value;
            json['options']['all-step-types'][active_step]['steps'][active_slide]['question_length'] = funnel_info.question_value.length;
        }
        else if (json['question-type'] == 'vehicle') {
            json = FunnelsUtil.vehicleOptionSetByIndex(json['options'],json);
            json = this.setSecurityMessage();
        }
        else {
            json['options'] = FunnelsUtil.getOptionsValue(json['options']);
            json['options']['question_value'] = funnel_info.question_value;
            json['options']['question_length'] = funnel_info.question_value.length;
            json = this.setSecurityMessage();
        }
    },

    setSecurityMessage: function (){
        // set security message
        let selected_val = json['options']['security-message-id'];
        let selected_val_index = FunnelsUtil.getTcpaMessageIndex(selected_val, funnel_info.tcpa_messages);
        if(funnel_info.tcpa_messages[selected_val_index]){
            let icon = JSON.parse(funnel_info.tcpa_messages[selected_val_index]['icon']);
            let text_style = JSON.parse(funnel_info.tcpa_messages[selected_val_index]['tcpa_text_style']);
            let tcpa_message_is_required = funnel_info.tcpa_messages[0]['is_required'] || 0;
            if(icon) {
                json['options']['security_tcpa_messages'] = (icon.enabled ? '<i class="privacy-icon ' + icon.icon + '" style="font-size:' + icon.size + 'px;color:' + icon.color + '"></i>' : '') + '<span style="' + (text_style.is_bold ? 'font-weight:bold;' : '') + '' + (text_style.is_italic ? 'font-style:italic;' : '') + 'color:' + text_style.color + '">' + funnel_info.tcpa_messages[selected_val_index]['tcpa_text'] + '</span>';
                // icon alignment
                json['options']['icon-position'] = icon.position;
            }

            json['options']['tcpa_message_is_required'] = tcpa_message_is_required;
        }
        return json;
    },


    /**
     * This function will set height attribute to Previewbar iframe from inside content
     * Usage:
     *      - On load
     *      - On receiving postmessage in changesTrigger();
     */
   setIframeHeight: function(scrollTop){
        if (jQuery('.funnel-iframe-inner-holder').length > 0) {
            jQuery('.funnel-iframe-inner-holder').mCustomScrollbar({
                axis: "y",
                scrollInertia: 200
            });
            if(scrollTop) {
                jQuery('.funnel-iframe-inner-holder').mCustomScrollbar(
                    "scrollTo", scrollTop
                );
            }
        }
       /*if(window.parent.site.route === 'branding-page') {
            jQuery('.funnel-iframe-inner-holder').mCustomScrollbar("scrollTo","bottom",{
                scrollInertia: 100
            });
        }*/
    },

    /**
     * Pick JSON directly from json files to work standlone on previewbars
     * @param jsonfile
     * @param key
     * @param questionId
     */
    temporaryHandlebarOpts: function (jsonfile, key, questionId) {
        // get question json
        FunnelsUtil.ls_key = key;
        window.funnel_info = JSON.parse('{"sequence":["1"],"questions":{},"tcpa_messages":[],"question_value":""}');
        window.ques_id = questionId;
        window.json = JSON.parse($.getJSON({'url': window.location.protocol +"//"+ window.location.host + "/lp_assets/theme_admin3/js/funnel/json/"+jsonfile, 'async': false}).responseText);
        this.transformData();
    },

    /**
     * This funciton work on <Hide CTA button until the question is answered> selection
     * On User input it will show/hide CTA
     */
    showHideCtaOnUserInput: function(){
        //Bind Events
        $('.form-control').off('keyup input paste').on('keyup input paste', FunnelsUtil.debounce(function (event) {
            var inputValue = jQuery(this).val();
            // hide CTA button
            if ($('#hide_cta').val() == 1) {
                if (inputValue == "" || inputValue.length <= 1) {
                    $('.cta-btn-wrap').addClass('hide-btn');
                } else {
                    if (inputValue.length >= 2) {
                        $('.cta-btn-wrap').removeClass('hide-btn');
                    }
                }
            }

            // save value
            funnel_info.question_value = inputValue;
            FunnelsUtil.saveFunnelData(funnel_info);
        }, 500));
    },

    /**
     *get all inline font families in preview html and load the selected font from google fonts.
     */
    getFontFamilies: function (){
        const regex = /font-family\:.+?;/gm;
        if($(".row").length){
            const str = $(".row").html().replace(/&quot;/g,'');
            let m;
            let a = [];

            while ((m = regex.exec(str)) !== null) {
                // This is necessary to avoid infinite loops with zero-width matches
                if (m.index === regex.lastIndex) {
                    regex.lastIndex++;
                }
                // The result can be accessed through the `m`-variable.
                m.forEach((match, groupIndex) => {
                    let value = $.trim(match.replace('font-family:','').replace(';',''));
                    if(a.indexOf(value) == -1){
                        a.push(value);
                    }
                });
                WebFontConfig = {
                    google: { families: a }
                };

                var wf = document.createElement('script');
                wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type = 'text/javascript';
                wf.async = true;
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
        }

        }
    },

    isMessagesModule: 0,

    /**
     * Refresh handle bar function to get latest json from local storage
     * @param key
     * @param questionId
     */
    refreshHandlebarSecurityMessage: function (key, questionId) {
        // get question json
        FunnelsUtil.ls_key =  key;
        window.funnel_info = JSON.parse(localStorage.getItem(key));
        window.ques_id = questionId;
        window.json = funnel_info.questions[questionId];
        this.transformDataNonFbPreview();
        if(funnel_info.meta.hasOwnProperty('branding')){
            this.brandingPreview();
        }
    },


    /**
     * This function converts data into such format which we need to use on handlebar template for all those screens which are not in funnel builder / question menu
     * @param json
     * @param funnel_info
     */
    transformDataNonFbPreview: function () {

        if(json !== undefined)
        {
            let cta_main_message = funnel_info.cta_main_message || "";
            let cta_description = funnel_info.cta_description || "";
            let feature_image = funnel_info.feature_image || "";

            let cta_main_message_style = funnel_info.cta_main_message_style || "";
            let cta_description_style = funnel_info.cta_description_style || "";

            json['cta-main-message'] = cta_main_message;
            json['cta-main-message-style'] = cta_main_message_style;
            json['cta-description'] = cta_description;
            json['cta-description-style'] = cta_description_style;
            json['show-cta-image'] = feature_image;


            if (json['question-type'] === 'contact') {
                /* let active_step = 0;
                 let active_slide =  0;*/

                let active_step = json['options']['activesteptype'] - 1;
                let active_slide = json.hasOwnProperty('active_slide') ? json['active_slide'] : 0;

                json['active_slide'] = active_slide;
                json['options']['all-step-types'][active_step]['steps'][active_slide] = FunnelsUtil.getOptionsValue(json['options']['all-step-types'][active_step]['steps'][active_slide]);
                // explicitly setting value to enable preview
                json['options']['all-step-types'][active_step]['steps'][active_slide]['enable-security-message'] = 1;
                let icon = JSON.parse(funnel_info.tcpa_messages[0]['icon'] || "{}" );
                let text = funnel_info.tcpa_messages[0]['tcpa_text'] || "";
                let tcpa_message_is_required = funnel_info.tcpa_messages[0]['is_required'] || 0;
                let text_style = JSON.parse(funnel_info.tcpa_messages[0]['tcpa_text_style'] || "{}");
                json['options']['all-step-types'][active_step]['steps'][active_slide]['security_tcpa_messages'] =  (icon.enabled ? '<i class="privacy-icon ' + icon.icon + '" style="font-size:' + icon.size + 'px;color:' + icon.color + '"></i>' : '') + '<span style="' + (text_style.is_bold ? 'font-weight:bold;' : '') + '' + (text_style.is_italic ? 'font-style:italic;' : '') + 'color:' + text_style.color + '">' + text + '</span>';
                // icon alignment
                json['options']['all-step-types'][active_step]['steps'][active_slide]['tcpa_message_is_required'] = tcpa_message_is_required;
                json['options']['all-step-types'][active_step]['steps'][active_slide]['icon-position'] = icon.position || "";
            }
            else if (json['question-type'] == 'vehicle') {
                json = FunnelsUtil.vehicleOptionSetByIndex(json['options'],json);
            }
            else {
                json['options'] = FunnelsUtil.getOptionsValue(json['options']);
                // explicitly setting value to enable preview
                json['options']['enable-security-message'] = 1;
            }

            if (json['question-type'] != 'contact') {
                // set security message
                if (funnel_info.tcpa_messages[0]) {
                    let icon = JSON.parse(funnel_info.tcpa_messages[0]['icon'] || "{}");
                    let text = funnel_info.tcpa_messages[0]['tcpa_text'] || "";
                    let tcpa_message_is_required = funnel_info.tcpa_messages[0]['is_required'] || 0;
                    let text_style = JSON.parse(funnel_info.tcpa_messages[0]['tcpa_text_style'] || "{}");

                    json['options']['security_tcpa_messages'] = (icon.enabled ? '<i class="privacy-icon ' + icon.icon + '" style="font-size:' + icon.size + 'px;color:' + icon.color + '"></i>' : '') + '<span style="' + (text_style.is_bold ? 'font-weight:bold;' : '') + '' + (text_style.is_italic ? 'font-style:italic;' : '') + 'color:' + text_style.color + '">' + text + '</span>';
                    // icon alignment
                    json['options']['tcpa_message_is_required'] = tcpa_message_is_required;
                    json['options']['icon-position'] = icon.position || "";
                }
            }
        }
    },
    /**
     * update branding preview
     */
    brandingPreview:function () {
        let meta = funnel_info.meta.branding;
        $(".funnel-iframe-inner-area").find(".branding-logo").remove();
        if (meta.leadpop_branding === "on" && meta.file) {
            let position_class = 'right';
            if (meta.image_position === 'left') {
                position_class = 'left';
            }
            let brandingHtml = `<div class="branding-logo ${position_class}">`;
            if(meta.backlink_enable){
                brandingHtml += `<a href="${(meta.backlink_url)?meta.backlink_url:'#'}" target="${meta.backlink_target}">`;
            }
            let image_size = 25;
            if(meta.image_width != "" && meta.image_height != ""){
                image_size = Math.ceil((meta.image_size/100) * meta.image_width);
            }

            brandingHtml += `<img src="${meta.file}" alt="${meta.image_alt}" title="${meta.image_title}" style="max-width: ${image_size}px">`;
            brandingHtml += `</div>`;
            $(".funnel-iframe-inner-area").append(brandingHtml);
        }
    }

};

jQuery(document).ready(function() {
    FunnelsPreview.froala_font_size();
    FunnelsPreview.froala_video_resize();
    FunnelsPreview.getFontFamilies();
    FunnelsPreview.preview_height();
    FunnelsPreview.privacy_text_aligment();
    FunnelsPreview.preview_scaling();
});

jQuery(window).resize(function() {
    FunnelsPreview.froala_video_resize();
    FunnelsPreview.preview_scaling();
});

jQuery(document).click(function (e) {
    var parentWindow = parent.document.body;
    if (jQuery(parentWindow).find(".disable-options").length) {
        jQuery(parentWindow).find(".disbale-option-tooltip-area.mobile-mode").css({"display":"none","opacity": '0', "visibility": 'hidden'});
    }
});
