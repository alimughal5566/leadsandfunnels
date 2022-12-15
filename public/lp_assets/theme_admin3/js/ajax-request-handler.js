/**
 * To AJAX requests handler
 */
var ajaxRequestHandler = {
    last_clicked: 0,
    time_since_clicked: Date.now(),
    isAjaxInProcess: false,
    formId: null,
    form: null,
    originalFormValues:{},
    options: {},
    froalaEditorCls: "lp-froala-textbox",
    buttonDisabled: true,
    autoEnableDisableButton: true,
    isBoundedSubmitEvent: false,
    toastMessage: 'Processing your request',
    submitButton: '#main-submit',
    requestMethod: 'POST',
    isChangedWhileAjaxInProgress: false,
    isActiveLoadingToastMessage: false,

    /**
     * initialize module and form bindings
     * @param formId
     */
    init:function(formId, options){
        this.formId = formId;
        this.form = $(formId);
        this.options = $.extend(this.options, options);
        //this will be used in global confirmation popup to not show loading toast message
        this.form.attr("ajax-submit", true);
        this.resetDefaultValues();
        this.setAutoEnableDisableButton();
        this.setSubmitButton();
        // setting custom message
        if(this.options && this.options.toastMessage !== undefined) {
            this.toastMessage = this.options.toastMessage;
        }

        let $self = this;
        if(this.autoEnableDisableButton === true) {
            setTimeout(function () {
                $self.log("Loading data & binding events");
                $self.loadFormSavedValues();
            }, 200);
        }
        this.bindFormEvents($self);
    },

    setAutoEnableDisableButton: function(autoEnableDisableButton){
        if(autoEnableDisableButton !== undefined) {
            this.autoEnableDisableButton = autoEnableDisableButton;
            this.log("this.autoEnableDisableButton", this.autoEnableDisableButton);
            this.changeSubmitButtonStatus(this.autoEnableDisableButton);
        } else if(this.options && this.options.autoEnableDisableButton !== undefined) {
            this.autoEnableDisableButton = this.options.autoEnableDisableButton;
        }
    },

    /**
     * reset fields to default values, only will be execute on initialization
     * useful when will be initialized multiple times
     */
    resetDefaultValues: function(){
        this.buttonDisabled =  true;
        this.isBoundedSubmitEvent =  false;
        this.toastMessage =  'Processing your request';
        this.submitButton =  '#main-submit';
        this.requestMethod =  'POST';
        this.isChangedWhileAjaxInProgress =  false;
        this.autoEnableDisableButton = true;
        this.isActiveLoadingToastMessage = false;
    },

    setActiveLoadingToastMessage: function(isActive) {
        if(isActive === undefined) {
            if(this.submitButton == "#main-submit") {
                this.isActiveLoadingToastMessage = false;
            } else {
                this.isActiveLoadingToastMessage = true;
            }
        } else {
            this.isActiveLoadingToastMessage = isActive;
        }
        this.log("this.isActiveLoadingToastMessage - " + this.isActiveLoadingToastMessage);
    },

    setSubmitButton: function(){
        if(this.options && this.options.submitButton !== undefined) {
            this.submitButton = this.options.submitButton;
            this.setActiveLoadingToastMessage();
        }
    },

    getType : function (el) {
        let tag_name = el.prop("tagName");
        if(tag_name == "INPUT") {
            return el.attr("type").toLowerCase()
        } else {
            return tag_name.toLowerCase();
        }
    },

    /**
     * change main submit button status disable OR enabled
     * @param disabled
     */
    changeSubmitButtonStatus: function(disabled){
        this.log(this.submitButton + "  Button changed to - " + disabled);
        this.buttonDisabled = disabled;
        $(this.submitButton).prop('disabled', disabled);
    },

    /**
     * load form original saved values from input fields
     * 1st time - load values on page load
     * load again - every time when save success
     */
    loadFormSavedValues: function(){
        this.changeSubmitButtonStatus(true);

        //loading data
        this.originalFormValues = this.getFormSavedValues();
        //Global callback to handle exceptional view specific cases
        this.globalFieldChangeHandler();

        this.log("original values", this.originalFormValues);
    },

    /**
     * This function will be called after AJAX success response
     * if auto button enable/disable option is enabled
     * @param formValues
     * @param reset
     */
    setFormSavedValues: function(formValues, reset){
        this.changeSubmitButtonStatus(true);

        //loading data
        this.originalFormValues = formValues;
        //Global callback to handle exceptional view specific cases
        this.globalFieldChangeHandler(reset);

        // check fields, if any field was changed when AJAX request was in progress
        if(this.isChangedWhileAjaxInProgress === true) {
            this.handleFieldValueChangeAndButton(this, null);
            this.isChangedWhileAjaxInProgress = false;
        }

        this.log("set original values", this.originalFormValues);
    },

    /**
     * TO retrieve form original saved values from input fields
     */
    getFormSavedValues: function(){
        let $self = this,
            form_values = {};
        jQuery($self.formId + ' [data-form-field]').each(function (index, el) {
            $self.getFieldSavedProperties($self, $(el), function(name, obj){
                if(name !== undefined) {
                    form_values[name] = obj;
                }
            });
        });
        return form_values;
    },

    /**
     * This function is created to get field saved data
     * retrieved data will be used later to enable/disable button
     * @param $self
     * @param el
     * @param cb
     */
    getFieldSavedProperties: function($self, el, cb){
        try {
            let name = el.attr('name'),
                id = el.attr('id'),
                isFroalaEditor = el.hasClass($self.froalaEditorCls),
                value;

            if (name !== undefined || id !== undefined || isFroalaEditor) {
                let type = $self.getType(el);
                if (type === "checkbox") {
                    value = el.prop('checked') == true;
                } else if (type === "radio") {
                    value = $("input[name=" + name + "]:checked").val();
                } else if (isFroalaEditor) {
                    let editor = lpHtmlEditor.getInstance();
                    if(editor && editor.html && editor.html.get !== undefined) {
                        value = editor.html.get();
                    } else {
                        value = el.val();
                    }
                    if (name === undefined) {
                        name = $self.froalaEditorCls;
                    }
                } else {
                    value = el.val();
                }

                let obj = {'type': type, 'value': value};

                if (name === undefined && id !== undefined) {
                    name = id;
                    obj['is_id'] = true;
                }

                cb(name, obj);
            }
        } catch (e) {
            console.log("Error: loading fields saved values ", e);
        }
    },

    getFieldName: function(targetEl, editor){
        let name = targetEl.attr('name'),
            id = targetEl.attr('id');
        name = (name === undefined ? id : name);
        if(name === undefined) {
            globalEditor = targetEl;
        }
        if(editor === true && name === undefined) {
            name = this.froalaEditorCls;
        }
        return name;
    },

    /**
     * bind event on form, it will check nor hidden fields and compare values with original values
     * if found any change in any field on form than it will show button as enabled
     */
    bindFormEvents: function($self){
        let targetEl;
        $(this.formId).bind('change keyup', function (e) {
            //$self.log("Form changed");

            //To handle exceptional case, field changed when AJAX request is in progress
            if($self.autoEnableDisableButton === true) {
                if($self.isAjaxInProcess) {
                    $self.isChangedWhileAjaxInProgress = true;
                    return false;
                }

                targetEl = jQuery(e.target);
                let name = $self.getFieldName(targetEl, targetEl.hasClass($self.froalaEditorCls)),
                    obj = $self.originalFormValues[name];
                //$self.log("Form changed.", name);
                if (obj !== undefined) {
                    // $self.handleFieldChangeAndButton($self, e, targetEl);
                    $self.handleFieldValueChangeAndButton($self, targetEl);
                } else if($self.options.customFieldChangeCb !== undefined && targetEl.attr('data-form-field-custom-cb') !== undefined) {
                    $self.handleFieldValueChangeAndButton($self, targetEl);
                    let disabled = $self.options.customFieldChangeCb($self.buttonDisabled);
                    $self.log("Custom field callback changing button status to - ", disabled);
                    $self.changeSubmitButtonStatus(disabled);
                }

                $self.globalFieldChangeHandler();
            }
        });

        /**
         * Exceptional case - Froala Editor fixed issue with editor
         * It was updating content in editor view
         * but wasn't sending updated HTML in AJAX request
         */
        jQuery(this.formId + ' .' + $self.froalaEditorCls).on('froalaEditor.html.set', function (e, editor) {
            $self.log("Form changed froalaEditor - html.set.");
            if($self.autoEnableDisableButton === true) {
                targetEl = jQuery(e.target);
                let name = $self.getFieldName(targetEl, true),
                    obj = $self.originalFormValues[name];
                if (obj !== undefined) {
                    $('.' + $self.froalaEditorCls).froalaEditor('undo.saveStep');
                }
            }
        });

        /**
         * checking froalaEditor events to enable/disable button
         */
        jQuery(this.formId + ' .' + $self.froalaEditorCls).on('froalaEditor.contentChanged', function (e, editor) {
            if($self.autoEnableDisableButton === true) {
                targetEl = jQuery(e.target);
                let name = $self.getFieldName(targetEl, true),
                    obj = $self.originalFormValues[name];
                if (obj !== undefined) {
                    $self.log("Form changed froalaEditor.contentChanged");
                    $self.handleFieldValueChangeAndButton($self, targetEl);
                }
            }
        });
    },

    globalFieldChangeHandler: function(reset){
        // Exceptional case - currently used in background page to handle different background forms option change
        if(this.options.globalCustomCb !== undefined) {
            let disabled = this.options.globalCustomCb(this.buttonDisabled, reset);
            this.log("Global Custom callback changing button status to - ", disabled);
            this.changeSubmitButtonStatus(disabled);
        }
    },

    /**
     * This function is created to compare cached/saved form values with values after any change
     * Will enable submit button if found any change otherwise disable button
     * @param e
     * @param targetEl
     */
    handleFieldValueChangeAndButton: function ($self, targetEl){
        try {
            let disable = true;
            $self.log("$self.originalFormValues", $self.originalFormValues);
            jQuery($self.formId + ' [data-form-field]').each(function (index, el) {
                el = $(el);
                disable = $self.getButtonStatusByCompareFieldValue($self, el, disable);

                if (!disable) {
                    $self.log("Data + Break loop -- ", disable);
                    return false;
                } // break out of loop
            });

            $self.log("Data + Button disabled changed to - " + disable);
            $self.changeSubmitButtonStatus(disable);
        } catch (e) {
            console.log("Error: handle field ", e);
        }
    },

    /**
     * get and compare form fields values
     * @param e
     * @param targetEl
     */
    handleFieldChangeAndButton: function ($self, e, targetEl){
        let disable = true;
        jQuery($self.formId + " :input").each(function (index, el) {
            el = $(el);
            disable = $self.getButtonStatusByCompareFieldValue($self, el, disable);
            if (!disable) {
                $self.log("Break loop -- ", disable);
                return false;
            } // break out of loop
        });

        $self.log("Button disabled changed to - " + disable);
        $self.changeSubmitButtonStatus(disable);
    },

    /**
     * This function will compare single form value
     * return enable/disable status after checking value
     * @param el
     * @param disable
     * @returns {boolean}
     */
    getButtonStatusByCompareFieldValue: function($self, el, disable){
        let isFroalaEditor = el.hasClass($self.froalaEditorCls),
            name = $self.getFieldName(el, isFroalaEditor),
            current_value = oldValue = "",
            obj = $self.originalFormValues[name];
        if(obj !== undefined) {
            let type = $self.getType(el);
            oldValue = obj.value;
            if (type === 'checkbox') {
                current_value = el.is(':checked');
            } else if(type === 'radio'){
                current_value = $("input[name="+name+"]:checked").val();
            }else if (isFroalaEditor) {
                let editor = lpHtmlEditor.getInstance();
                current_value = editor.html.get();
            } else {
                current_value = el.val();
                if(el.data('ignore-case') !== undefined) {
                    current_value = current_value.toLowerCase();
                    oldValue = oldValue.toLowerCase();
                }
            }

            disable = (oldValue == current_value);
            if (type != 'textarea') {
                $self.log(name + " of type " + type + " + Button disabled changed to - " + disable, oldValue, current_value);
            } else {
                $self.log(name + " of type " + type + " + Button disabled changed to - " + disable);
            }
        }
        return disable;
    },

    /**
     * TO track button is immediately clicked OR not
     * @returns {boolean}
     */
    isImmediatelyClicked: function() {
        if (this.last_clicked) {
            this.time_since_clicked = Date.now() - this.last_clicked;

            if (this.time_since_clicked < 2000) {
                return true
            }
        }

        this.last_clicked = Date.now();
        return false;
    },

    /**
     * Set check if button is not immediately clicked if not immediately clicked than return isAjaxInProcess bit
     */
    isAjaxRequestInProcess: function () {
        if(this.isImmediatelyClicked()) {
            return true;
        }
        return this.isAjaxInProcess;
    },

    /**
     * Set isAjaxInProcess bit before starting AJAX request
     */
    startingAjaxRequest: function () {
        this.isAjaxInProcess = true;
    },


    /**
     * Reset isAjaxInProcess bit after AJAX request completion
     */
    stoppingAjaxRequest: function () {
        this.isAjaxInProcess = false;
    },

    /**
     * initialize modal close event, this will fix multiple AJAX request exceptional issue with modal
     * Exceptional issue - after AJAX request modal take some delay to hide it self, between that time if button is clicked it was sending request
     */
    initModalClosedEvents: function (modals = false) {
        if(modals) {
            let $self = this;
            // $(document).on('hidden.bs.modal', modals, function (event) {
            $(modals).on('hidden.bs.modal', function () {
                $self.stoppingAjaxRequest();
            });
        }
    },

    /**
     * To get URL from form attributes
     * @param options
     * @returns {*}
     */
    getActionUrl: function(options){
        if(options !== undefined && options.url) {
            return options.url;
        }

        if (GLOBAL_MODE) {
            return this.form.data("global_action");
        }
        return this.form.attr("action");
    },

    /**
     * To pass customized URL to submit forms
     * @param url
     * @param globalUrl
     * @returns {*}
     */
    getCustomActionUrl: function(url, globalUrl){
        if (GLOBAL_MODE) {
            return globalUrl;
        }
        return url;
    },

    /**
     * To submit form in single + global mode
     * @param cb
     * @param bindSubmitEvent
     * @param options
     */
    submitForm: function(cb, bindSubmitEvent, options){
        let $self = this,
            url = this.getActionUrl(options);

        if (GLOBAL_MODE) {
            if (checkIfFunnelsSelected()){
                //  debugger;
                if(confirmationModalObj.globalConfirmationCurrentForm == this.form){
                    $self.log("Global - submitting form");
                    $self.sendRequest(url, cb);
                } else {
                    $self.log("Global - submitting popup", confirmationModalObj.globalConfirmationCurrentForm, this.form, (confirmationModalObj.globalConfirmationCurrentForm == this.form));
                    showGlobalRequestConfirmationForm(this.form);
                }
            }
        } else if(options === undefined || options.singleFunnelCb === undefined) {
            $self.log("Single - submitting form");
            this.sendRequest(url, cb);
        } else if(options.singleFunnelCb) {
            options.singleFunnelCb(function(){
                $self.log("Single funnel callback", url, cb);
                $self.sendRequest(url, cb);
            });
        }

        //binding enent to submit
        if((this.options.alwaysBindEvent !== undefined && this.options.alwaysBindEvent) || !this.isBoundedSubmitEvent && (bindSubmitEvent !== undefined && bindSubmitEvent == true)) {
            this.bindAjaxSubmitFormEvent(cb, options);
        }
    },

    /**
     * Exceptional case - global mode form is submitted directly when no validation handler used
     * @param cb
     * @param options
     */
    bindAjaxSubmitFormEvent: function(cb, options){
        let $self = this;
        this.log("Binding submit form");
        this.form.off("submit").on("submit", function (e) {
            e.preventDefault();
            $self.log("Submitting form");
            $self.submitForm(cb, false, options);
        });
        this.isBoundedSubmitEvent = true;
    },

    /**
     * To send AJAX requests
     * @param url
     * @param cb
     * @param data
     * @returns {boolean}
     */
    sendRequest: function (url, cb, data) {
        if(this.isAjaxRequestInProcess()) {
            return false;
        }
        this.startingAjaxRequest();
        let $self = this,
            processData = false,
            contentType = false,
            formSavedValues;

        if(data === undefined) {
            data = new FormData(jQuery($self.formId).get(0));
        } else {
            processData = undefined,
            contentType = undefined;
        }
        $self.log("Submitting request - ", url, this.isActiveLoadingToastMessage);

        // moved code here to handle exceptional case
        // To fix - Change any field while AJAX request in progress
        if($self.autoEnableDisableButton === true) {
            formSavedValues = $self.getFormSavedValues();
        }

        let {hide} = $self.handleRequestLoading();

        $.ajax({
            type: $self.requestMethod,
            data: data,
            url: url,
            processData:processData,
            contentType:contentType,
            error: function (data) {
                let response = data.responseJSON
                $self.log("Error", response);

                if(response.redirect !== undefined) {
                    window.location.href = response.redirect;
                } else {
                    if (response.error) {
                        $self.displayMessage(response.error);
                    } else if(response.warning !== undefined) {
                        $self.displayMessage(response.warning, "warning");
                    } else if(response.errors !== undefined) {
                        if(jQuery.isArray(response.errors)) {
                            $self.displayMessage(response.errors[0]);
                        } else {
                            for(let key in response.errors){
                                let error = response.errors[key];
                                $self.displayMessage(error[0]);
                                return false;
                            }
                        }
                    } else {
                        $self.displayMessage("Your request was not processed. Please try again.");
                    }

                    if (cb !== undefined) {
                        cb(response, true);
                    }
                }
            },
            success: function (response) {
                $self.log("Success", response);
                if(response.status == true || response.status == 'true') {
                    if (response.message) {
                        displayAlert("success", response.message);
                    }

                    if(formSavedValues !== undefined) {
                        $self.setFormSavedValues(formSavedValues, true);
                    }

                    if (cb !== undefined) {
                        cb(response);
                    }

                } else if(typeof response == "string") {
                    // this ok is added to call callback when verify domain OR subdomain
                    // TODO: This ok porion will be removed when clone request will be converted to use AJAX handler
                    //  & backend code will be updated
                    if (cb !== undefined) {
                        cb(response);
                    }
                }
            },
            complete: function (data) {
                if($self.isActiveLoadingToastMessage) {
                    if(hide !== undefined) hide();
                } else {
                    $self.handleSaveButtonLoading(false);
                }

                if (GLOBAL_MODE) {
                    $('#global-setting-funnel-list-pop').modal('hide');
                    setglobalConfirmationCurrentFormToDefault();
                }
                $self.stoppingAjaxRequest();
            },
            cache: false,
            async: true
        });
    },

    /**
     * This will show toast loading message
     * OR add loaded top save button if isActiveLoadingToastMessage bit isn't true
     * @returns {{}|*}
     */
    handleRequestLoading: function(){
        if(this.isActiveLoadingToastMessage) {
            return displayAlert("loading", this.toastMessage, 0);
        } else {
            this.handleSaveButtonLoading();

            //hiding global popup to make save button visible
            if (GLOBAL_MODE) {
                $('#global-setting-funnel-list-pop').modal('hide');
            }
        }
        return {};
    },

    /**
     * This will add/remove saving class on top save button
     * @param isActiveLoading
     */
    handleSaveButtonLoading: function(isActiveLoading = true){
        if(isActiveLoading) {
            this.log("adding saving class...");
            jQuery(this.submitButton).addClass("saving");
        } else {
            this.log("removing saving class...");
            jQuery(this.submitButton).removeClass("saving");
        }
    },

    displayMessage: function(error, type="danger"){
        setTimeout(function () {
            displayAlert(type, error);
        }, 500);
    },

    lookup: function(obj, prop, value){
        for (var i = 0, len = obj.length; i < len; i++) {
            if (obj[i] && obj[i][prop] === value) return obj[i];
        }
    },

    isEquals: function(obj1, obj2){
        obj1 = Object.keys(obj1).sort().reduce((r, k) => (r[k] = obj1[k], r), {});
        obj2 = Object.keys(obj2).sort().reduce((r, k) => (r[k] = obj2[k], r), {});
        return JSON.stringify(obj1) == JSON.stringify(obj2);
    },

    /**
     * Log function to log message in console
     * is create because here check will be added for production,
     * it won't log messages on production
     * @param message
     * @param args
     */
    log: function(message, ...args){
        //here check will be added for production
        if(site.app_env != site.env_production) {
            console.log(message, args);
        }
    },

    clone: function () {
        let $self = this;
        return jQuery.extend({}, $self);
    }
};

// Object.prototype.equals = function(object2) {
//     //For the first loop, we only check for types
//     for (propName in this) {
//         //Check for inherited methods and properties - like .equals itself
//         //https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty
//         //Return false if the return value is different
//         if (this.hasOwnProperty(propName) != object2.hasOwnProperty(propName)) {
//             return false;
//         }
//         //Check instance type
//         else if (typeof this[propName] != typeof object2[propName]) {
//             //Different types => not equal
//             return false;
//         }
//     }
//     //Now a deeper check using other objects property names
//     for(propName in object2) {
//         //We must check instances anyway, there may be a property that only exists in object2
//         //I wonder, if remembering the checked values from the first loop would be faster or not
//         if (this.hasOwnProperty(propName) != object2.hasOwnProperty(propName)) {
//             return false;
//         }
//         else if (typeof this[propName] != typeof object2[propName]) {
//             return false;
//         }
//         //If the property is inherited, do not check any more (it must be equa if both objects inherit it)
//         if(!this.hasOwnProperty(propName))
//             continue;
//
//         //Now the detail check and recursion
//
//         //This returns the script back to the array comparing
//         /**REQUIRES Array.equals**/
//         if (this[propName] instanceof Array && object2[propName] instanceof Array) {
//             // recurse into the nested arrays
//             if (!this[propName].equals(object2[propName]))
//                 return false;
//         }
//         else if (this[propName] instanceof Object && object2[propName] instanceof Object) {
//             // recurse into another objects
//             //console.log("Recursing to compare ", this[propName],"with",object2[propName], " both named \""+propName+"\"");
//             if (!this[propName].equals(object2[propName]))
//                 return false;
//         }
//         //Normal value comparison for strings and numbers
//         else if(this[propName] != object2[propName]) {
//             return false;
//         }
//     }
//     //If everything passed, let's say YES
//     return true;
// }

// Object.extend(Object, {
//     deepEquals: function(o1, o2) {
//         var k1 = Object.keys(o1).sort();
//         var k2 = Object.keys(o2).sort();
//         if (k1.length != k2.length) return false;
//         return k1.zip(k2, function(keyPair) {
//             if(typeof o1[keyPair[0]] == typeof o2[keyPair[1]] == "object"){
//                 return deepEquals(o1[keyPair[0]], o2[keyPair[1]])
//             } else {
//                 return o1[keyPair[0]] == o2[keyPair[1]];
//             }
//         }).all();
//     }
// });

var confirmationModal = {
    modalId: "#save-confirmation",
    set: function(btn, title, message) {
        if(!$(btn).is(":disabled")){
            let modal = $(this.modalId);
            if(title) {
                modal.find('.modal-title').html(title);
            }
            if(message) {
                modal.find('.modal-msg').html(message);
            }
            modal.modal('show');
            modal.find('[data-cta-confirmed]').off("click").on('click',function (){
                $(btn).trigger("click");
            });
        }
    }
};
