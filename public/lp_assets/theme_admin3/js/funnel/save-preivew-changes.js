var SaveChangesPreview = {
    mappedFields: [],
    ques_id: 0,
    inputEvent: '',
    /**
     * This function gets the JSON Field+value question to update in local storage
     * @param event
     * @param field_type
     * @param updateData
     */
    saveQuestion: function (event, field_type = null, updateData = null) {

        let val = '';
        let fieldName = '';

        if (field_type === 'rangeSlider') {
            let element = jQuery('['+updateData.fieldName+']');
            val = Number(element.val());
            fieldName = element.data('field-name');
        } else if (field_type === 'add-icon') {
            val = jQuery('.icon-wrap i').attr('class').replace('ico-', '');
            fieldName = jQuery('[data-text-icon]').data('field-name');
        } else if (field_type === 'fontSlider' || field_type === 'froalaEditor' || field_type === 'min-max') {
            val = updateData?.value ? updateData.value : '';
            fieldName = updateData?.fieldName ? updateData.fieldName : '';
        } else if (field_type === 'color-picker') {
            let element = $('[button-icon-color]');
            fieldName = element.data('field-name');
            val = element.find('.custom-color-value').val();
        } else if (field_type === 'multiOption') {
            fieldName = 'fields';
            val = multiOptions.getOptions();
        }  else {
            fieldName = event.target.dataset.fieldName;
            if (fieldName !== '' && field_type != 'field') {
                if (field_type === 'text' || field_type === 'select') {
                    val = event.target.value;
                } else {
                    val = event.target.checked ? 1 : 0;
                }
            }
            if(field_type == 'field'){
                fieldName = 'data-field';
                var regexp = /[^a-zA-Z-0-9-_]/g;
                val = event.target.value.replace(regexp,'');
            }
        }
        if(site.env_production.toLowerCase() == "local") console.log('val', val, fieldName);
        if(event && typeof event.target.getAttribute == "function")
        {
            if($.inArray(event.target.getAttribute('data-field-name'), ["enable-min-number", "enable-max-number"]) !== -1) {
                const min_val = $('[data-field-name="min-number"]').val().trim(),
                    max_val = $('[data-field-name="max-number"]').val().trim(),
                    min_checkbox = $('[data-field-name="enable-min-number"]'),
                    max_checkbox = $('[data-field-name="enable-max-number"]'),
                    min_checked = min_checkbox.is(":checked"),
                    max_checked = max_checkbox.is(":checked");

                min_checkbox.removeClass("error");
                max_checkbox.removeClass("error");
                FunnelsUtil.setSubmitButtonErrorState(false);
                if(min_checked && max_checked) {
                    if(!min_val || !max_val) {
                        min_checkbox.addClass("error");
                        max_checkbox.addClass("error");
                        FunnelsUtil.setSubmitButtonErrorState(true);
                    }
                } else if(min_checked && !min_val) {
                    min_checkbox.addClass("error");
                    FunnelsUtil.setSubmitButtonErrorState(true);
                } else if(max_checked && !max_val) {
                    max_checkbox.addClass("error");
                    FunnelsUtil.setSubmitButtonErrorState(true);
                }
            }
        }
        if (fieldName !== '') {
            this.inputEvent = event;
            this.saveJson(fieldName, val);
        }
    },


    /**
     * To update question JSON single field
     * @param field
     * @param value
     * @param funnel_info
     * @returns {*}
     */
    getJsonObject: function (field, value, funnel_info) {
        const current_ques =  $('[data-id="ques_id"]').val();
        if(field.indexOf('.') === -1) {
            if(funnel_info.questions[current_ques]['options'][field]) {
                funnel_info.questions[current_ques]['options'][field] = value;
            }
        } else {
            let arr = field.split('.'),
                lastIndex = (arr.length - 1);
            var pointer = funnel_info.questions[current_ques]['options'];

            if (arr.length) {
                for (var i = 0; i < arr.length; i++) {
                    if (i == lastIndex) {
                        pointer[arr[i]] = value;
                    } else {
                        if(pointer[arr[i]])
                            pointer = pointer[arr[i]];
                    }
                }
            }
        }
        console.log("getJsonObject",funnel_info.questions[current_ques]);
        return funnel_info;
    },

    /**
     * To save signle/multiple JSON attributes, also able to pass JSON object as value against key
     * @param fields
     * @param value
     * @param funnel_info
     */
    saveJsonObject: function (fields, value=null, funnel_info=null) {

        funnel_info = funnel_info===null ? FunnelsUtil._getFunnelInfo('local_storage') : funnel_info;
        this.ques_id = $('[data-id="ques_id"]').val();
        var valu_button = '';
        if (funnel_info.questions[this.ques_id]) {
            if(typeof fields === "object") {
                let $self = this;
                $.each(fields, function( field, value) {
                    if(typeof value == "string")
                    {
                        valu_button = value;
                    }
                    funnel_info = $self.getJsonObject(field, value, funnel_info);
                });
            } else {
                funnel_info = this.getJsonObject(fields, value, funnel_info);
            }
            console.log("saveJsonObject",funnel_info.questions[this.ques_id]);
            this.saveQuestionJson(funnel_info, "");
            this.saveJson('button-text', valu_button);
        }
    },

    /**
     * This function prepare json to save in local storage
     *
     * @param fieldName
     * @param val
     * @param funnel_info
     * @param auto_save
     */
    saveJson: function (fieldName, val, funnel_info=null, auto_save=true) {
        funnel_info = funnel_info===null ? FunnelsUtil._getFunnelInfo('local_storage') : funnel_info;

        // save funnel zoom settings
        if (fieldName == 'zoom_lock') {
            let zoom = FunnelsUtil._getZoomSettings();
            zoom['lock'] = val;
            zoom['value'] = $('.size-range-bar-val').val();
            FunnelsUtil.saveZoomSettings(zoom);
            return;
        }

        this.ques_id = $('[data-id="ques_id"]').val();

        // fix issue of saving data in database when string have double quotes in it
        if (typeof val === 'string') {
            val = FunnelsUtil.escapeHtmlEntities(val);
        }

        if (fieldName.search('hidden.') === -1 && funnel_info.questions[this.ques_id] && funnel_info.questions[this.ques_id]['question-type'] === 'contact') {
            this.mappedFields = SaveContactPreviewChanges.getContactMappedFields(funnel_info, false);
        }

        if(typeof fieldName !== "undefined") {
            if (fieldName == 'full_screen') {
                funnel_info.meta['full_screen'] = val;
            } else if (fieldName.search('hidden.') !== -1) {
                let fieldNameHidden = fieldName.replace('hidden.', '');
                funnel_info.hidden_fields[this.ques_id]['options'][fieldNameHidden] = val;
                // calculate data-field from field label OR parameter
                if (fieldNameHidden == 'field-label' && val.trim() != '' && funnel_info.hidden_fields[this.ques_id]['options']['parameter'].trim() == '') {
                    funnel_info.hidden_fields[this.ques_id]['options']['data-field'] = val.replace(/[^a-z0-9 ]/gi,'').replaceAll(' ', '_').toLowerCase();
                } else if (fieldNameHidden == 'parameter' && val.trim() != '') {
                    funnel_info.hidden_fields[this.ques_id]['options']['data-field'] = val.replace(/[^a-z0-9 ]/gi,'').replaceAll(' ', '_').toLowerCase();
                } else if (fieldNameHidden == 'parameter' && val.trim() == '') {
                    funnel_info.hidden_fields[this.ques_id]['options']['data-field'] = funnel_info.hidden_fields[this.ques_id]['options']['field-label'].replace(/[^a-z0-9 ]/gi,'').replaceAll(' ', '_').toLowerCase();
                }
            } else if (fieldName == 'question-type') {
                funnel_info.questions[this.ques_id][fieldName] = val;
            } else if (fieldName.match(/\./g) !== null && fieldName.match(/\./g).length > 1 && funnel_info.questions[this.ques_id]['question-type'] === 'slider') {
                funnel_info = this.sliderSetting(funnel_info, fieldName, val);
            } else if (fieldName.indexOf('.') !== -1) {
                funnel_info = this.CTAButtonSetting(funnel_info, fieldName, val);
            } else {
                funnel_info = this.funnelOptionsSetting(funnel_info, fieldName, val);
            }

            // format option event work slider value formatting
            if(typeof this.inputEvent !== "undefined" && this.inputEvent !== "" && typeof this.inputEvent.target.dataset !== "undefined") {
                if(this.inputEvent.target.dataset.formatOption){
                    funnel_info = this.sliderFormat(funnel_info);
                }
            }
        }

        // directly save in local storage if auto_save is true
        if (auto_save) {
            this.saveQuestionJson(funnel_info, fieldName);
        } else {
            // return object to enable multiple fields saving in only one call
            return funnel_info;
        }
    },

    /**
     * This function save prepared json in local storage
     *
     * @param funnel_info
     * @param fieldName
     */
    saveQuestionJson: function(funnel_info, fieldName) {
        // Delete extra json attributes which are not regular in our JSON
        if (funnel_info.questions[this.ques_id]) {
            delete funnel_info.questions[this.ques_id]['options']['tooltips'];
            delete funnel_info.questions[this.ques_id]['options']['question_value'];
            delete funnel_info.questions[this.ques_id]['options']['security_tcpa_messages'];
        }

        FunnelsUtil.saveFunnelData(funnel_info);
        if (fieldName.search('hidden.') === -1) {
            let nonRefreshFieldArray = ['cta-button-settings.enable-hide-until-answer', 'full_screen'];
            SaveChangesPreview.iframePostMessage(fieldName, nonRefreshFieldArray);
        }

        // update question text in quick access links in DOM
        if ((fieldName == 'question' || fieldName == 'show-question') && funnel_info.questions[this.ques_id]['question-type'] != 'contact') {
            SaveChangesPreview.updateQuickAccessLinks();
        } else if(fieldName.indexOf("customize-slider-labels.value") !== -1 || fieldName.indexOf("starting-number-ends") !== -1) {
            slider.refresh(true);
        }
        FunnelsUtil.handleSubmitButtonState(funnel_info);
    },

    /**
     * Dynamically save multiple json fields in local storage for bootstrap toggle, we get dynamic fields from data attributes
     * i.e. data-on-checked-update-fields='"automatic-progress":0,"alphabetize":1' And data-on-unchecked-update-fields='"automatic-progress":1,"alphabetize":0'
     *
     * @param update_field
     * @param val
     * @param update_fields
     */
    updateMultipleFields: function(update_field, val, update_fields) {
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        funnel_info = SaveChangesPreview.saveJson(update_field, val, funnel_info, false);

        // make json from data attribute value to update multiple fields in local storage
        update_fields = JSON.parse('{'+update_fields+'}');

        // update multiple fields by loop through all fields given under data-on-checked-update-fields and data-on-unchecked-update-fields
        $.each(update_fields, function( index, value ) {
            funnel_info = SaveChangesPreview.saveJson(index, value, funnel_info, false);
        });

        // update multiple fields in only one call below
        SaveChangesPreview.saveQuestionJson(funnel_info, update_field);
    },

    /**
     * Update quick access links in DOM
     */
    updateQuickAccessLinks: function() {
        setTimeout(function () {
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            let ques_id = $('[data-id="ques_id"]').val();
            let question = funnel_info.questions[ques_id];
            let question_rel_title = FunnelsBuilder.getQuestionTitle(question);

            $('[data-quick-access-title="' + ques_id + '"]').html(question_rel_title);
        }, 300);
    },

    /**
     * save options trigger on change, click. keyup
     */
    saveOptions: function ($this){
        let updateData = [];
        updateData['fieldName'] = jQuery($this.$box).data('field-name');
        updateData['value'] = $this.html.get();
        this.saveQuestion(event, 'froalaEditor', updateData);
    },

    /**
     * Send Post message to iframe for right side preview
     * @param fieldName
     * @param nonRefreshableFields
     */
    iframePostMessage: function (fieldName='', nonRefreshableFields=[]) {

        if(site.env_production.toLowerCase() == "local") console.info('iframe post message');
        let postMessage = '';
        if ($.inArray(fieldName,nonRefreshableFields) !== -1) {
            postMessage = 'no-refresh-data';
        } else {
            postMessage = 'refresh-data';
        }

        jQuery(".funnel-iframe-holder iframe")[0].contentWindow.postMessage(postMessage, '*');
        // if(question_type === 'dropdown' || question_type === 'menu'){
        //     let fields_length = multiOptions.getFieldsLength();
        //     if(fields_length > 0){
        //         FunnelActions.enableFunnelSaveBtn();
        //     }
        //     else{
        //         FunnelActions.disableFunnelSaveBtn();
        //     }
        // } else if(question_type === 'slider'){
        //     let activeTab = $('.fb-tab__tab-pane.active');
        //     if(activeTab.find('[data-change-text].error').length > 0 || activeTab.find('[data-segment].error').length){
        //         FunnelActions.disableFunnelSaveBtn();
        //     } else {
        //         FunnelActions.enableFunnelSaveBtn();
        //     }
        // }
        // else {
        //     FunnelActions.enableFunnelSaveBtn();
        // }
    },
    /**
     * CTA button setting update
     * @param funnel_info
     * @param fieldName
     * @param val
     * @returns {*}
     * @constructor
     */

    CTAButtonSetting: function (funnel_info,fieldName,val){
        if (fieldName == 'cta-button-settings.button-icon-position') {
            val = Constants.BUTTON_ICON_POSITION[val];
        }
        let arr = fieldName.split('.');
        if (funnel_info.questions[this.ques_id]['question-type'] == 'contact') {
            if (arr[1] == 'required') {
                let index = SaveContactPreviewChanges.getFieldIndex(arr[0]);
                this.mappedFields['fields'][index][arr[0]]['required'] = val;
            } else {
                this.mappedFields[arr[0]][arr[1]] = val;
            }
        }
        else if ($.inArray(funnel_info.questions[this.ques_id]['question-type'],['vehicle']) !== -1){
            let value = funnel_info.questions[this.ques_id]['options'][arr[0]];
            if($.isArray(value)){
                value[FunnelsUtil.tabStep][arr[1]] = val;
            }
            else {
                value[arr[1]] = val;
            }
            funnel_info.questions[this.ques_id]['options'][arr[0]] = value;
        }
        else {
            funnel_info.questions[this.ques_id]['options'][arr[0]][arr[1]] = val;
        }


        return funnel_info;
    },

    /**
     * funnel question options setting
     * @param funnel_info
     * @param fieldName
     * @param val
     * @returns {*}
     */

    funnelOptionsSetting: function (funnel_info,fieldName,val){

        if (funnel_info.questions[this.ques_id]['question-type'] == 'contact') {
            if (fieldName == 'country-code' || fieldName == 'auto-format') {
                this.mappedFields['fields'][5]['phone'][fieldName] = Number(val);
            } else if (fieldName == 'activesteptype') {
                funnel_info.questions[this.ques_id]['options'][fieldName] = val;
            } else {
                this.mappedFields[fieldName] = val;
                if($(".question-editor").hasClass('focus'))
                {
                    let question_title = $(".question-editor.focus .fr-view").text();
                    this.mappedFields["question-title"] = question_title;
                }
            }
        }
        else if ($.inArray(funnel_info.questions[this.ques_id]['question-type'],['vehicle']) !== -1){
            let value = funnel_info.questions[this.ques_id]['options'][fieldName];
            if($.isArray(value)){
                if(fieldName === "automatic-progress"){
                    // On ENABLE of Automatic Progress & CTA Button & Required should be disabled
                    if(val === 1){
                        funnel_info.questions[this.ques_id]['options']["cta-button"][FunnelsUtil.tabStep] = 0;
                        funnel_info.questions[this.ques_id]['options']["required"][FunnelsUtil.tabStep] = 0;
                    }
                    else{
                        funnel_info.questions[this.ques_id]['options']["cta-button"][FunnelsUtil.tabStep] = 1;
                        funnel_info.questions[this.ques_id]['options']["required"][FunnelsUtil.tabStep] = 1;
                    }
                }
                else if(fieldName === "question"){
                    if($(".question-editor").hasClass('focus')) {
                        let question_title = $(".question-editor.focus .fr-view").text();
                        funnel_info.questions[this.ques_id]['options']["question-title"][FunnelsUtil.tabStep] = question_title;
                    }
                }
                value[FunnelsUtil.tabStep] = val;
            }
            else {
                value = val;
            }
            funnel_info.questions[this.ques_id]['options'][fieldName] = value;
        }
        else {
            if(fieldName === "automatic-progress"){
                // On ENABLE of Automatic Progress & CTA Button & Required should be disabled
                if(val === 1){
                    funnel_info.questions[this.ques_id]['options']["automatic-progress"] = 1;
                    funnel_info.questions[this.ques_id]['options']["cta-button"] = 0;
                    funnel_info.questions[this.ques_id]['options']["required"] = 0;
                }
                else{
                    funnel_info.questions[this.ques_id]['options']["automatic-progress"] = 0;
                    funnel_info.questions[this.ques_id]['options']["cta-button"] = 1;
                    funnel_info.questions[this.ques_id]['options']["required"] = 1;
                }
            }
            else{
                if(fieldName === "question" || fieldName === "call-to-action"){
                    if($(".question-editor").hasClass('focus')) {
                        let question_title = $(".question-editor.focus .fr-view").text();
                        funnel_info.questions[this.ques_id]['options']["question-title"] = question_title;
                    }
                }
                funnel_info.questions[this.ques_id]['options'][fieldName] = val;
            }
        }
        return funnel_info;
    },

    /**
     * slider number format option setting
     * @param funnel_info
     * @returns {*}
     */
    sliderFormat: function (funnel_info){
        let otherFormatOption = $('[data-slider-format-checkbox]:not([data-format-option="'+this.inputEvent.target.dataset.formatOption+'"])');
        $(otherFormatOption).each(function (index, value){
            $(value).prop('checked',false);
            let arr = $(value).attr('data-field-name').split('.');
            funnel_info.questions[SaveChangesPreview.ques_id]['options'][arr[0]][arr[1]] = 0;
        });
        return funnel_info;
    },

    /**
     * slider options setting
     * @param funnel_info
     * @param fieldName
     * @param val
     */
    sliderSetting: function (funnel_info,fieldName,val){
        let arr = fieldName.split('.'),
            lastIndex = (arr.length-1);
        var pointer = funnel_info.questions[this.ques_id]['options'];
        if(arr.length){
            for(var i = 0; i < arr.length; i++){
                if(i == lastIndex){
                    pointer[arr[i]] = val
                } else {
                    pointer = pointer[arr[i]];
                }
            }
        }

        if(fieldName.indexOf("customize-slider-labels.value") !== -1) {
            var sliderSettings;
            if(arr.length == 3) {
                sliderSettings = funnel_info.questions[this.ques_id]['options'][arr[0]];
            } else {
                sliderSettings = funnel_info.questions[this.ques_id]['options'][arr[0]][arr[1]];
            }
            slider.updateInitialValueIndex(sliderSettings);
        }
        this.validateSliderLabels(fieldName, arr);
        return funnel_info;
    },

    /**
     * left, right labels dependent field validation
     * @param fieldName
     * @param attributes
     */
    validateSliderLabels: function (fieldName, attributes) {
        let activeTab = jQuery('.tab-content.non-numeric-active');
        if(!activeTab.length) {
            activeTab = $('.fb-tab__tab-pane.active');
        }

        let labelName = attributes[attributes.length - 1],
            field = activeTab.find("[data-field-name='" + fieldName +"']"),
            dependentField = undefined;
        if(labelName == "left_label" || labelName == "left") {
            let dependentFieldName = labelName == "left_label" ? "left" : "left_label";
            dependentField = activeTab.find("[data-field-name='" + fieldName.replace(labelName, dependentFieldName) +"']");
        } else if(labelName  == "right_label" || labelName  == "right") {
            let dependentFieldName = labelName == "right_label" ? "right" : "right_label";
            dependentField = activeTab.find("[data-field-name='" + fieldName.replace(labelName, dependentFieldName) +"']");
        }

        if(field && dependentField) {
            // add/remove error class
            field.removeClass("error");
            dependentField.removeClass("error");
            if ((field.val().trim() == "" && dependentField.val().trim() != "") || (dependentField.val().trim() == "" && field.val().trim() != "")) {
                field.addClass("error");
                dependentField.addClass("error");
            }
        }
    }
}
