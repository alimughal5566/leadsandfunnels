Array.prototype.max = function() {
    return Math.max.apply(null, this);
};

/**
 * Checks if a value exists in an array
 * @param needle needle is a string, the comparison is done in a case-sensitive manner.
 * @returns {boolean}
 */
Array.prototype.inArray = function(needle) {
    let length = this.length;
    for(var i = 0; i < length; i++) {
        if(this[i] == needle) return true;
    }
    return false;
};

String.prototype.replaceAll = function (find, replace) {
    var str = this;
    return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
};

/**
 * This will bind events only once
 */
$.fn.once = function (type, fn) {
    if(!this.hasClass("ev-handler")) {
        this.addClass("ev-handler");
        this.on(type, fn);
    }
};

/**
 * This will re-bind events
 */
$.fn.rebind = function (type, fn) {
    let data = $._data($(this)[0], 'events');
    if (data[type] === undefined || data.length === 0) {
        this.on(type, fn);
    }
    else{
        this.off(type).on(type, fn);
    }
};

jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ?
                matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}

var then_questions_options_list = {
    "then_question_config_1": {
        "then_Options": [
            {
                id:1,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">3.1. Great, what kind of home are you purchasing?</span></div>',
                title: 'Purchase',
            },
            {
                id:2,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">3.2. Estimate your credit score:</span></div>',
                title: 'Credit Score',
            },
            {
                id:3,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">3.3. Is this your first property purchase?</span></div>',
                title: 'Property Purchase',
            },
            {
                id:4,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-location"></i></span><span class="text">4. Enter your zip code</span></div>',
                title: 'Zip Code',
            },
            {
                id:5,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-birthday"></i></span><span class="text">5. When is your birthday</span></div>',
                title: 'Birthday',
            },
            {
                id:6,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-select-text"></i></span><span class="text">6. Anything else we should consider?</span></div>',
                title: 'Consider',
            },
            {
                id:7,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span class="text">7. What is youe estimated down payment</span></div>',
                title: 'Down Payment',
            },
            {
                id:8,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-group"></i></span><span class="text">8. Loan Type: Refinance</span></div>',
                title: 'Refinance',
            }
        ],
    },
    "then_question_config_2": {
        "then_Options": [
            {
                id:1,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-group"></i></span><span class="text">4. Loan Type: Refinance</span></div>',
                title: 'Refinance',
            },
            {
                id:2,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-birthday"></i></span><span class="text">5. When is your birthday</span></div>',
                title: 'Birthday',
            },
            {
                id:3,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-select-text"></i></span><span class="text">6. Anything else we should consider?</span></div>',
                title: 'Consider',
            },
            {
                id:4,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span class="text">7. What is youe estimated down payment</span></div>',
                title: 'Down Payment',
            },
            {
                id: 5,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-group"></i></span><span class="text">8. Loan Type: Refinance</span></div>',
                title: 'Refinance',
            },
            {
                id:6,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-select-text"></i></span><span class="text">6. Anything else we should consider?</span></div>',
                title: 'Consider',
            },
            {
                id:7,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span class="text">7. What is youe estimated down payment</span></div>',
                title: 'Down Payment',
            },
            {
                id:8,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-group"></i></span><span class="text">8. Loan Type: Refinance</span></div>',
                title: 'Refinance',
            }
        ]
    },
    "then_question_config_3": {
        "then_Options": [
            {
                id:1,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-heart-page"></i></span><span class="text">A. Default Success Message</span></div>',
                title: 'Success Message'
            },
            {
                id:2,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-link"></i></span><span class="text">3rd Party</span></div>',
                title: '3rd Party'
            },
            {
                id:3,
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-heart-page"></i></span><span class="text">B. Default Success Message</span></div>',
                title: 'Success Message'
            },
        ]
    },
    "then_question_config_4": {
        "then_Options": [
            {
                id:1,
                text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                title: 'select Answer',
            },
            {
                id:2,
                text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                title: 'select Answer',
            },
            {
                id:3,
                text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                title: 'select Answer',
            },
            {
                id:4,
                text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                title: 'select Answer',
            }
        ]
    },
};

var question_select_list = [
    {selecter:".url-prefix", parent:".select2__parent-url-prefix"}
];

var FunnelsUtil = {
    debug: (typeof site === 'undefined' || site.env_production.toLowerCase() === "local") ? true : false,
    ls_prefix: "lp_",
    ls_key: "",
    load_data: "db",
    tabStep: 0,
    funnel: {
        sequence: [],
        questions: {},
        hidden_fields: {},
        tcpa_messages: [],
        meta: {},
        question_value: ""
    },
    zoom: {
        lock: 0,
        value: 100
    },
    questionInputFieldName: [],
    callback: function () {
    },
    sliderOption: [],
    mainSubmit: $('[data-id="main-submit"]'),

    /**
     * set submit button error state
     * @param haveErrors
     */
    setSubmitButtonErrorState: function(haveErrors = false) {
        this.mainSubmit.data("have-errors", haveErrors);
    },

    /**
     * return submit button error state
     * @returns {*|jQuery}
     */
    isSubmitButtonErrorState: function(){
        return this.mainSubmit.data("have-errors");
    },

    /**
     * This function creates localstorage key for Funnel which we are going to create
     *  - First we need to check we have any key in hash if yes then we don't need to
     *      create another localstorage key
     */
    create: function () {
        this._log(typeof this.funnel.sequence)
        this._log(typeof this.funnel.questions)

        // remove all lp_ keys in local storage
        this.removeLocalStorage();

        // get new key
        this.setFunnelKey();

        // information not in localstorage lets set it now
        if (this.ls_key !== "" && localStorage.getItem(this.ls_key) === null) {
            localStorage.setItem(this.ls_key, JSON.stringify(this.funnel));
        }
    },

    /**
     * This function remove all funnel builder keys in localstorage
     */
    removeLocalStorage: function (){
        if (this.ls_key !== "" && localStorage.getItem(this.ls_key) !== null) {
            localStorage.removeItem(this.ls_key);
        }
    },

    /**
     * On Dragging question this function add selected question to funnel json and save in localstorage
     * @param dragged_question DOM object
     */
    addQuestion: function (dragged_question) {
        let funnel_info, qkey;
        let type = dragged_question.data('question-type');
        let question_props = hbar.getJson(type + ".json");
        if (FunnelsUtil.debug) this._log(question_props);

        if (type == 'hidden') {
            qkey = this._getHiddenQuestionKey();
            funnel_info = this._getFunnelInfo();
            if (funnel_info.hidden_fields == null) {
                funnel_info.hidden_fields = {};
            }

            funnel_info.hidden_fields[qkey] = {};
            funnel_info.hidden_fields[qkey]['options'] = question_props['options'];
            funnel_info.hidden_fields[qkey]['options']['data-field'] = funnel_info.hidden_fields[qkey]['options']['unique-variable-name'] = type.replace('-', '') + "_" + qkey;
            funnel_info.hidden_fields[qkey]['question-type'] = question_props['question-type'];
        } else {
            qkey = this._getQuestionKey();
            funnel_info = FunnelsUtil.setDataField(type, question_props, qkey);
            this.addNewQuestionId(funnel_info, qkey);
        }

        localStorage.setItem(this.ls_key, JSON.stringify(funnel_info));

        return qkey;
    },

    /**
     * add new questio ID into local storage
     * @param funnel_info
     * @param questionId
     */
    addNewQuestionId: function(funnel_info, questionId) {
        if($.inArray(questionId, funnel_info.meta.new_questions) === -1) {
            funnel_info.meta.new_questions.push(questionId);
        }
    },

    /**
     * reset new questions
     * @param funnel_info
     */
    resetNewQuestions: function(funnel_info) {
        funnel_info.meta.new_questions = [];
    },

    /**
     * remove question ID from new_questions array
     * @param funnel_info
     * @param questionId
     */
    removeNewQuestionId: function(funnel_info, questionId) {
        let index = funnel_info.meta.new_questions.indexOf(questionId);
        if(index === -1) {
            this.setRemovedExistingQuestion(funnel_info, true);
        } else {
            funnel_info.meta.new_questions.splice(index, 1);
        }
    },

    isRemovedExistingQuestion: function(funnel_info) {
        return funnel_info.meta.is_removed_existing_question;
    },

    /**
     * remove exiting sequence
     * @param funnel_info
     * @param isRemoved
     */
    setRemovedExistingQuestion: function(funnel_info, isRemoved) {
        funnel_info.meta.is_removed_existing_question = isRemoved;
    },

    /**
     * reset existing sequence
     * @param funnel_info
     */
    resetExistingSequence: function(funnel_info) {
        funnel_info.meta.existing_sequence = funnel_info.sequence;
    },

    /**
     * will check sorting on dashboard
     * @param funnel_info
     * @returns {boolean}
     */
    isSortingChanged: function(funnel_info) {
        return JSON.stringify(funnel_info.meta.existing_sequence) !== JSON.stringify(funnel_info.sequence);
    },

    isActivateDashboardSaveBtn: function(funnel_info) {
        return !FunnelActions.currentQuestionId && (this.isRemovedExistingQuestion(funnel_info) || this.isSortingChanged(funnel_info));
    },

    /**
     * return true if added new question which is still not saved
     * @param funnel_info
     * @returns {[]|*|number}
     */
    haveNewQuestions: function(funnel_info) {
        return funnel_info.meta.new_questions && funnel_info.meta.new_questions.length;
    },

    /**
     * check if question ID exists
     * @param funnel_info
     * @param questionId
     * @returns {boolean}
     */
    isNewQuestion: function (funnel_info, questionId) {
        if(questionId == "") {
            questionId = SaveChangesPreview.ques_id;
        }
        return $.inArray(parseInt(questionId), funnel_info.meta.new_questions) !== -1;
    },

    handleSubmitButtonState: function(funnel_info, questionId=null) {
        questionId = questionId ? questionId : SaveChangesPreview.ques_id;
        if(FunnelActions.questionBeforeChange && FunnelActions.questionBeforeChange['question-type'] === "slider"){
            slider.checkErrors();
        }
        // enable/disable main submit button
        if(this.isSubmitButtonErrorState()) {
            FunnelActions.disableFunnelSaveBtn();
        } else if(FunnelsUtil.isNewQuestion(funnel_info, questionId) || FunnelsUtil.isActivateDashboardSaveBtn(funnel_info) || FunnelActions.isQuestionChanged()) {
            FunnelActions.enableFunnelSaveBtn();
        } else {
            FunnelActions.disableFunnelSaveBtn();
        }
    },

    /**
     * Create key if not already exist in URL / set key if already exists in URL
     */
    setFunnelKey: function () {
        this.ls_key = this.ls_key === "" ? this.ls_prefix + $('[data-id="main-submit"]').data("lpkeys") : this.ls_key;
    },

    /**
     * Save funnel data in local storage
     * @param funnel_info
     */
    saveFunnelData: function (funnel_info) {
        localStorage.setItem(FunnelsUtil.ls_key, JSON.stringify(funnel_info));
        FunnelsUtil.handleSubmitButtonState(funnel_info);
    },

    /**
     * Save zoom settings in local storage
     * @param zoom
     */
    saveZoomSettings: function (zoom) {
        let client_id = $('[name="client_id"]').val();
        localStorage.setItem(client_id + "_zoom", JSON.stringify(zoom));
    },

    /**
     * This functions get updated funnel information from local storage.
     * @private
     */
    _getFunnelInfo: function (load_from = null) {
        if (load_from) {
            this.load_data = load_from;
        }
        this.setFunnelKey();
        let info;
        if (localStorage.getItem(this.ls_key) !== null && this.load_data === 'local_storage') {
            info = JSON.parse(localStorage.getItem(this.ls_key));
        } else {
            info = this.funnel;
        }
        return info
    },

    /**
     * Get zoom settings
     * @private
     */
    _getZoomSettings: function () {
        let client_id = $('[name="client_id"]').val();
        return JSON.parse(localStorage.getItem(client_id + "_zoom"));
    },

    _log: function (args, label) {
        if (this.debug) {
            if (label === undefined) console.log(args);
            else console.log(args, label);
        }
    },

    _getQuestionKey: function () {
        let num = 0;
        let funnel_info = this._getFunnelInfo();
        if (funnel_info.sequence.length == 0) {
            num = funnel_info.sequence.length + 1;
        } else {
            this._log(typeof funnel_info.sequence)
            num = funnel_info.sequence.max() + 1
        }

        return num;
    },

    _getHiddenQuestionKey: function () {
        let funnel_info = this._getFunnelInfo();
        let num = funnel_info.hidden_fields == null ? 0 : (Object.keys(funnel_info.hidden_fields).length ? Object.keys(funnel_info.hidden_fields).max() : 0);
        return num + 1;
    },

    /**
     * Rename data fields by concating data-field with 'contact' and question key
     * @param options
     * @param qkey
     * @param newkey
     */
    renameContactDataFields: function (options, qkey, newkey = null) {

        let total_steps = options['all-step-types'].length - 1;
        for (let i = 0; i <= total_steps; i++) {
            let step = options['all-step-types'][i]['steps'];
            $.each(step, function (index, value) {
                let current_step = value['fields'];
                $.each(current_step, function (step_index, step_value) {
                    let key = Object.keys(step_value);
                    step[index]['fields'][step_index][key[0]]['data-field'] = (newkey !== null) ? step_value[key[0]]['data-field'].replace("contact_" + qkey, "contact_" + newkey) : key[0] + "_contact_" + qkey;
                    step[index]['fields'][step_index][key[0]]['unique-variable-name'] = step[index]['fields'][step_index][key[0]]['data-field'];
                });
            });
        }

        return options;
    },

    /**
     * loads saved DB Questions
     */
    loadDBQuestion: function (questions_params = false, sequences_params = false ) {
        this.setFunnelKey();
        // reset funnel in local storage on page refresh
        //this.resetFunnel();

        let questions = questions_params? questions_params : JSON.parse(question_json),
            sequence = sequences_params? sequences_params: JSON.parse(funnel_sequence);

        // convert menu to dropdown fallback questions
        questions = menuToDropdown.getConvertedQuestions(questions);

        /* let questions = JSON.parse(question_json);
         let sequence = JSON.parse(funnel_sequence);*/
        let hidden_fields = JSON.parse(hidden_fields_json);
        //remove null entries from array
        if (Array.isArray(hidden_fields)){
            hidden_fields = hidden_fields.filter(item => item !== null)
            hidden_fields = Object.assign({}, hidden_fields)
        }
        if (!hidden_fields || hidden_fields == 'null'){
            hidden_fields = {}
        }

        //remove null entries from array
        if (Array.isArray(hidden_fields)){
            hidden_fields = hidden_fields.filter(item => item !== null)
            hidden_fields = Object.assign({}, hidden_fields)
        }
        if (!hidden_fields || hidden_fields == 'null'){
            hidden_fields = {}
        }

        // load zoom settings
        let zoom = this._getZoomSettings();
        if (zoom !== null) {
            this.zoom = zoom;
        } else {
            this.saveZoomSettings(FunnelsUtil.zoom);
        }
        // set tcpa_messages
        let tcpa_messages = JSON.parse(ls_tcpa_messages);
        if (tcpa_messages.length != 0) {
            this.funnel.tcpa_messages = tcpa_messages;
        }
        // set hidden fields
        this.funnel.hidden_fields = hidden_fields;
        // set header footer info
        this.funnel.meta = {
            header_logo: ls_meta_logo,
            header_contact_info: JSON.parse(ls_meta_contact_info),
            footer_links: JSON.parse(ls_meta_footer_links),
            footer_logos: JSON.parse(ls_meta_footer_logos),
            footer_bab_logos: JSON.parse(ls_meta_footer_bab_logos),
            footer_mobile_logos: JSON.parse(ls_meta_footer_mobile_logos),
            footer_copyright: JSON.parse(ls_meta_footer_copyright),
            is_removed_existing_question: false,
            existing_sequence: sequence.length ? sequence.map(Number) : [],
            new_questions: []
        };

        if (this.ls_key !== "" && localStorage.getItem(this.ls_key) === null) {
            for (let i = 0; i < sequence.length; i++) {
                let question = questions[sequence[i]];
                let type = question['question-type'].toLowerCase();
                FunnelsUtil.setDataField(type, question, sequence[i], false);
            }
            FunnelsUtil.create();
        } else {
            this.funnel.questions = questions;
            this.funnel.sequence = sequence;
            FunnelsUtil.saveFunnelData(this.funnel);
        }
    },

    setDataField: function (type, question_props, qkey, add_question = true) {
        let funnel_info = this._getFunnelInfo();
        funnel_info.questions[qkey] = {};
        if (add_question) {
            if (type === 'contact') {
                funnel_info.questions[qkey]['options'] = this.renameContactDataFields(question_props['options'], qkey);
            } else {
                this._log(funnel_info.questions[qkey]);
                funnel_info.questions[qkey]['options'] = question_props['options'];
                if (type === 'vehicle') {
                    for(let i=0; i<=1;i++) {
                        let value = funnel_info.questions[qkey]['options']['data-field'][i];
                        let field = value.replace('-', '') + "_" + qkey;
                        funnel_info.questions[qkey]['options']['data-field'][i] = field;
                        funnel_info.questions[qkey]['options']['unique-variable-name'][i] = field;
                    }
                } else {
                    funnel_info.questions[qkey]['options']['data-field'] = funnel_info.questions[qkey]['options']['unique-variable-name'] = type.replace('-', '') + "_" + qkey;
                }
            }
        } else {
            funnel_info.questions[qkey]['options'] = question_props['options'];
        }
        funnel_info.questions[qkey]['question-type'] = question_props['question-type'];
        funnel_info.sequence.push(qkey);
        return funnel_info;
    },

    /**
     * strip tags
     * @param input
     * @param allowed
     * @returns {*}
     */
    strip_tags: function (input, allowed) {
        if(input === undefined) {
            return "";
        }

        input = input.replaceAll('&lt;p&gt;', '');
        input = input.replaceAll('&lt;&#x2F;p&gt;', '');

        allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
        var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi
        var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi
        return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : ''
        });
    },
    /*
   ** custom select loop
   **/
    customQuestion: function () {
        var selectlist = question_select_list;
        for (var i = 0; i < selectlist.length; i++) {
            this.questionsSelectinit(selectlist[i].selecter, selectlist[i].parent);
        }
    },
    /*
    ** init custom select
    **/
    questionsSelectinit: function (selecter, parent) {
        var amIclosing = false;
        var _selector = jQuery(selecter);
        var _parent = jQuery(parent);
        var selectorClass = selecter.replace(/[#.]/g, '');
        _selector.select2({
            //data: selectItems[selectorClass],/*(selecter == '.add-sticky-bar__select')?stickybar.add_StickyBarOption: stickybar.sb_ButtonPosition,*/
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(parent),
            width: '100%',
            /*templateResult: function (d) {
                return $(d.text);
            },
            templateSelection: function (d) {
                return $(d.text);
            }*/

            /*
            ** Triggered before the drop-down is opened.
            */
        }).on('change', function () {
            $(this).parents('.select-area').addClass('chnage-active');
            var questionID = $(this).val();
            if (questionID == 4) {
                $(this).parents('.conditional-select-wrap').find('.recipients-slide').show();
                $(this).parents('.conditional-select-wrap').find('.show-queston-slide').hide();
            } else {
                $(this).parents('.conditional-select-wrap').find('.show-queston-slide').show();
                $(this).parents('.conditional-select-wrap').find('.recipients-slide').hide();
                var questionConfig = then_questions_options_list['then_question_config_' + questionID];
                if (questionConfig != undefined) {
                    var select2_config = {
                        minimumResultsForSearch: -1,
                        width: '100%', // need to override the changed default
                        dropdownParent: $(this).parents('.conditional-select-wrap').find('.show-question-parent'),
                        data: questionConfig.then_Options,
                        templateResult: function (d) {
                            return $(d.text);
                        },
                        templateSelection: function (d) {
                            return $(d.text);
                        }
                    };
                    var findQuestion = $(this).parents('.conditional-select-wrap').find('.show-question');
                    if (findQuestion.data('select2')) {
                        showQuestionSelect2(findQuestion.select2('destroy').empty(), select2_config);
                    } else {
                        showQuestionSelect2(findQuestion.empty(), select2_config);
                    }
                }
            }
        }).on('select2:opening', function () {
            _parent.find('.select2-selection__rendered').css('opacity', '0');

            /*
            ** Triggered whenever the drop-down is opened.
            ** select2:opening is fired before this and can be prevented.
            */
        }).on('select2:open', function () {
            var _selectoptions = _parent.find('.select2-results__options');
            var _selectdropdown = _parent.find('.select2-dropdown');

            _selectoptions.css('pointer-events', 'none');

            setTimeout(function () {
                _selectoptions.css('pointer-events', 'auto');
            }, 300);

            _selectdropdown.hide();
            _selectdropdown.css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            _parent.find('.select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                _parent.find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty('opacity', '1', 'important');
                    var getindex = _selector.find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty('opacity', '1', 'important');
                });
            }, 100);

            /*
            ** Triggered before the drop-down is closed.
            */
        }).on('select2:closing', function (e) {
            if (!amIclosing) {
                e.preventDefault();
                amIclosing = true;

                _parent.find('.select2-dropdown').attr('style', '');

                setTimeout(function () {
                    _selector.select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }

            /*
            ** Triggered whenever the drop-down is closed.
            ** select2:closing is fired before this and can be prevented.
            */
        }).on('select2:close', function () {
            _parent.find('.select2-selection__rendered').show();
            _parent.find('.select2-selection__rendered').css('opacity', '1');
            _parent.find('.select2-results__options').css('pointer-events', 'none');
        });
    },

    /**
     * Reset Funnel
     */
    resetFunnel: function (ls_key) {
        localStorage.removeItem(ls_key);
    },

    /**
     * On keypress debounce input and textarea to not overload browser
     * @param func
     * @param wait
     * @param immediate
     * @returns {function(...[*]=)}
     */
    debounce(func, wait, immediate) {
        let timeout;
        return function () {
            let context = this, args = arguments;
            let later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            let callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    },

    /**
     * Get key by value from an object
     * @param object_log
     * @param value
     * @returns {string}
     */
    getKeyByValue: function (object, value) {
        return Object.keys(object).find(key => object[key] === value);
    },

    // TODO: cleanup with references
    temporaryFieldName: function () {
        let funnelData = this._getFunnelInfo();
        var fieldName = [];
        if (funnelData) {
            let field = '';
            for (let i = 0; i < funnelData.sequence.length; i++) {
                let sequence = funnelData.sequence[i],
                    question = funnelData.questions[sequence];
                if (typeof question.options != "undefined") {
                    if(question['question-type'] === "contact"){
                        let uniqueVariables = [];
                        $.each(question.options['all-step-types'][question.options.activesteptype - 1].steps, function (index, step) {
                            $.each(step.fields, function (idx, stepQuestion) {
                                let key = Object.keys(stepQuestion);
                                if (stepQuestion[key[0]].value) {
                                    if (stepQuestion[key[0]].hasOwnProperty('unique-variable-name')) {
                                        uniqueVariables.push(stepQuestion[key[0]]['unique-variable-name']);
                                    } else {
                                        uniqueVariables.push(stepQuestion[key[0]]['data-field']);
                                    }
                                }
                            });
                        });
                        if(uniqueVariables.length) {
                            fieldName[sequence] = uniqueVariables;
                        }
                    } else {
                        if (question.options.hasOwnProperty('unique-variable-name')) {
                            field = question.options['unique-variable-name'];
                        } else {
                            field = question.options['data-field'];
                        }
                        if (typeof field != "undefined") {
                            // fieldName.push(field);
                            fieldName[sequence] = field;
                        }
                    }
                }
            }
            this.questionInputFieldName = fieldName;
        }
    },

    /**
     * TODO: cleanup with references
     * validate unique variable name on all questions
     * @param name
     * @param currentQuestion
     * @returns {boolean}
     */
    isUniqueVariable: function (name, currentQuestion) {
        let questionId = parseInt($('[data-id="ques_id"]').val()),
            currentQuestionName = this.questionInputFieldName[questionId];

        if($.isArray(currentQuestionName)) {
            let num = jQuery.grep(currentQuestionName, function (a) { return a == name; }).length;
            if(num > 1) {
                return false;
            }
            let found = $.inArray(name, currentQuestionName);
            if(found !== -1) {
                if (currentQuestion['question-type'] === 'contact' && found != $('[data-id="active_slide"]').val()) {
                    return false;
                } else if (currentQuestion['question-type'] === "vehicle" && found != FunnelsUtil.tabStep) {
                    return false;
                }
            }
        }

        return isUniqueVariableName();

        function isUniqueVariableName() {
            for(let sequence in FunnelsUtil.questionInputFieldName) {
                let variableName = FunnelsUtil.questionInputFieldName[sequence];
                if ($.isArray(variableName)) {
                    if(JSON.stringify(currentQuestionName) !== JSON.stringify(variableName)) {
                        return $.inArray(name, variableName) === -1;
                    }
                } else if (sequence != questionId && name === $.trim(variableName)) {
                    return false;
                }
            }
            return true;
        }
    },

    /**
     * Escape html entities
     * @param val
     * @returns {*}
     */
    escapeHtmlEntities: function (val, reverse = false) {
        let htmlEntities = ['"', "'", "/", "`", "=", "<", ">"];
        let characterEntities = ['&quot;', '&apos;', '&#x2F;', '&#x60;', '&#x3D;', '&lt;', '&gt;'];
        $.each(htmlEntities, function (index, value) {
            val = reverse ? val.replaceAll(characterEntities[index], htmlEntities[index]) : val.replaceAll(htmlEntities[index], characterEntities[index]);
        });
        return val;
    },
    /**
     * This will sort your array value
     * @param a
     * @param b
     * @returns {number}
     */
    sortByValue: function (a, b) {
        var a = a.toLowerCase();
        var b = b.toLowerCase();
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    /**
     * load vehicle question and get the options by tabs index
     * @param bundleNodeArray
     * @returns {*}
     */
    vehicleOptionSetByIndex: function (bundleNodeArray, currentQuestion) {
        $.each(bundleNodeArray, function (index, value) {
            if ($.isArray(value)) {
                if (value[FunnelsUtil.tabStep] && $.inArray(jQuery.type(value[FunnelsUtil.tabStep]), ['number','array','object']) === -1) {
                    currentQuestion['options'][index] = FunnelsUtil.escapeHtmlEntities(value[FunnelsUtil.tabStep], true);
                } else {
                    currentQuestion['options'][index] = value[FunnelsUtil.tabStep];
                }
            }
        });
        return currentQuestion;
    },

    /**
     * This will sort array randomize
     * @param array
     * @returns {*}
     */

    randomizeSort: function (array) {
        return array.sort(() => Math.random() - 0.5);
    },

    /**
     * every question options value escape html entities
     * @param json
     * @returns {*}
     */
    getOptionsValue: function (json) {
        $.each(json,function (index,value){
            if($.inArray(jQuery.type(value),['array','object']) !== -1){
               FunnelsUtil.getOptionsValue(value)
            }
            else if(value && !$.isNumeric(value)){
                json[index] = FunnelsUtil.escapeHtmlEntities(value, true);
            }
            else{
                json[index] = value;
            }
        });
        return json;
    },

    /**
     * slider value set
     */
    setSliderValue: function (){
        if(json['options']['slider-numeric']['value'] == 1){
            if(json['options']['slider-numeric']['one-puck']['value'] == 1){
                this.setSliderOptions(json['options']['slider-numeric']['one-puck']);
            } else {
                this.setSliderOptions(json['options']['slider-numeric']['two-puck'], true);
            }
        } else {
            this.setSliderOptions(json['options']['slider-non-numeric']);
        }
    },

    /**
     * set slider options
     * @param element
     */
    setSliderOptions: function (element, isTwoPuck = false) {
        let length = element['range'].length;
        if(length) {
            if(isTwoPuck) {
                slider.setInitialValue([0,1]);
            } else {
                slider.setInitialValue(0);
            }

            let lastIndex = length - 1,
                startingValue = (typeof element['range'][0] === "object" ? (element['unit'].indexOf('%') === -1 ? element['unit'] + element['range'][0]["start"] : element['range'][0]["start"] + element['unit']) : element['range'][0]),
                endingValue = (typeof element['range'][lastIndex] === "object" ? (element['unit'].indexOf('%') ? element['unit'] + element['range'][lastIndex]["end"] : element['range'][lastIndex]["end"] + element['unit']) : element['range'][lastIndex]);
            slider.setIsTwoPuck(isTwoPuck);
            slider.setMinRangeValue(startingValue);
            slider.setMaxRangeValue(endingValue);
            slider.setRange(FunnelsUtil.sliderValue(element));
        }
    },

    /**
     * slider array set according to set range
     * @param element
     * @param curreny
     * @returns {[]}
     */
    sliderValue: function (element){
        let valueArray = [];
        if(element['customize-slider-labels']['value'] === 1 && element['customize-slider-labels']['left'] != "") {
            valueArray.push(element['customize-slider-labels']['left']);
        }
        if(json['options']['slider-non-numeric']['value'] === 1){
            valueArray = valueArray.concat(json['options']['slider-non-numeric']['range']);
        }
        else {
            element['range'].forEach(function (value, index) {
                // slider.setTempOptionsCount(valueArray.length);
                let start = parseInt(value['start']),
                    end = parseInt(value['end']),
                    by = parseInt(value['by']),
                    nextRange = element['range'][index+1],
                    previousRange = element['range'][index-1];

                // To fix issue with one-puck slider range when previous ending & current starting values are same
                if(!slider.isTwoPuckSlider() && previousRange !== undefined
                    && parseInt(previousRange.end) === start
                    && !FunnelsUtil.isAddStartingNumber(start, end, by, parseInt(element["starting-number-ends"]))) {
                    valueArray[valueArray.length-1].end -= 1;
                }
                valueArray = valueArray.concat(FunnelsUtil.sliderRange(start, end, by, element, nextRange));
            });
        }
        if(element['customize-slider-labels']['value'] === 1 && element['customize-slider-labels']['right'] != "") {
            valueArray.push(element['customize-slider-labels']['right']);
        }

        slider.setValue(element, valueArray);

        return valueArray;
    },

    /**
     * @param start
     * @param end
     * @param by
     * @param startingNumber
     * @param lastValue
     * @returns {boolean}
     */
    isAddStartingNumber: function (start, lastValue, by, startingNumber) {
        return (by > 1 && startingNumber && start < lastValue && start % 10 === 0) ? true : false;
    },

    /**
     * make the range string from start, end and step variables
     * @param start
     * @param end
     * @param step
     * @param curreny
     * @returns {string[]}
     */
    sliderRange: function (start, end, step = 1, element, nextRange) {
        let rangeValues = [],
            startingNumber = parseInt(element["starting-number-ends"]),
            lastValue = end,
            is_increment = false;
        if(step) {
            const len = Math.floor((end - start) / step);
            if(Number.isFinite(len) && len > 0) {
                let lastIndex = len-1;
                for(let idx=0; idx < len; idx++) {
                    if (idx == 0) {
                        end = start + step;
                    } else {
                        start = end;
                        end = start + step;
                    }
                    is_increment = FunnelsUtil.isAddStartingNumber(start, lastValue, step, startingNumber);
                    addRangeValue(start, end, (idx === lastIndex));
                }

                //adding last value as slider value when not exactly ends on ending value
                if(end != lastValue && (nextRange === undefined || parseInt(nextRange.start) !== lastValue)) {
                   addRangeValue((slider.isTwoPuckSlider() ? lastValue : end), lastValue);
                }
            }
        }
        return rangeValues;

        /**
         * closure function to add range value
         * @param start
         * @param end
         */
        function addRangeValue(start, end, isLastValue=false){
            if(slider.isTwoPuckSlider()) {
                rangeValues.push({ unit: element['unit'], value: start, is_increment: is_increment});
                if(isLastValue && (nextRange === undefined || nextRange.start !== end)) {
                    rangeValues.push({unit: element['unit'], value: end, is_increment: is_increment});
                }
            } else {
                if(startingNumber){
                    start = is_increment ? start : (start + 1);
                } else if (end !== lastValue && step > 1) {
                    end = is_increment ? end : (end - 1);
                }
                rangeValues.push({unit: element['unit'], start: is_increment ? (start + startingNumber) : start, end: end});
            }
        }
    },

    /**
     * get current loaded question json
     */
    currentLoadedQuestion: function (){
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        window.json = funnel_info.questions[$('[data-id="ques_id"]').val()];
    },
    /**
     * Get tcpa message array index
     * @param selected_val
     */
    getTcpaMessageIndex: function (selected_val, tcpa_messages=null) {
        let messageIndex=-1;
        // return 0 for add security message popup
        if (selected_val == 0) {
            return 0;
        }
        tcpa_messages = tcpa_messages === null ? this.funnel.tcpa_messages : tcpa_messages;
        $.each(tcpa_messages, function (index, value) {
            if (selected_val == value['id']) {
                messageIndex = index;
                return false;
            }
        });

        return messageIndex;
    },

    numberWithCommas: function(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    },

    twoPuckSlider: function (param){
        if(jQuery("[data-slider-two-puck-point-value]").length) {
            let twoPuckSlider = jQuery("[data-slider-two-puck-point-value]").bootstrapSlider({
                    step: 1,
                    min: 0,
                    max: slider.getMaxRangeCount(),
                    value: slider.getInitialValue(),
                    id: "two-puck"
                }).on('slideStop', function (event) {
                    let value = twoPuckSlider.bootstrapSlider('getValue'),
                        firstValue = parseInt(value[0]),
                        secondValue = parseInt(value[1]);
                    if (firstValue > 0 && firstValue == secondValue) {
                        secondValue = value[1] + 1;
                        // in case first puck value is greater than last
                        if (firstValue >=  slider.getRangeCount()-1) {
                            firstValue = value[1] - 1;
                        }
                    }
                    // case when both pucks on 1st position
                    if (firstValue == 0 && firstValue == secondValue) {
                        secondValue = secondValue + 1;
                    }
                    twoPuckSlider.bootstrapSlider('setValue', [firstValue, secondValue], true).trigger("change");
                    if(typeof param != "undefined" && param === 'left-panel') {
                        slider.setInitialValueByKey(0, firstValue);
                        slider.setInitialValueByKey(1, secondValue);
                        SaveChangesPreview.saveJson("slider-numeric.two-puck.slider-starting-point.starting-value", firstValue);
                        SaveChangesPreview.saveJson("slider-numeric.two-puck.slider-starting-point.ending-value", secondValue);
                    }
                }).on('change', function (event) {
                    let newvalue = event.target.value.split(','),
                        firstValue = parseInt(newvalue[0]),
                        secondValue = parseInt(newvalue[1]);
                    if(firstValue == 0 && firstValue == secondValue){
                        secondValue = secondValue + 1;
                    }
                    // in case first puck value is greater than last
                    if(secondValue == (slider.getRangeCount()-1) && firstValue === secondValue) {
                        firstValue = firstValue-1;
                    }
                    slider.setTwoPuckFormattedValue(firstValue,secondValue);
                });

            twoPuckSlider.trigger('change');
        }
    },

    exitFullScreen: function () {
        jQuery(document).keydown(function(e){
           let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            var keycode = (e.keyCode ? e.keyCode : e.which);
            //full screen exit on press the ESC button
            if(keycode == 27 && $(window.parent.document.body).hasClass('full-screen-preview')) {
                $(window.parent.document.body).removeClass('full-screen-preview');
                jQuery('.full-screen-link').removeClass('active');
                funnel_info.meta['full_screen'] = 0;
                FunnelsUtil.saveFunnelData(funnel_info);
                // to remove iframe-full-screen-preview class from right preview
                SaveChangesPreview.iframePostMessage('full_screen', ['full_screen']);
            }
        });
    },

    /**
     * Assesding sort menu/dropdown question options
     * @param is_alphabetize
     * @param options
     */
    alphabetizeOptions: function (is_alphabetize, options) {
        if(is_alphabetize && options.length > 1) {
            options.sort();
        }
    },
    refreshVehicleIframePreview: function (){
        jQuery(".funnel-iframe-holder iframe").attr('src', site.baseUrl + '/previewbars/vehicle-preview.php?ques_id=' + jQuery('[data-id="ques_id"]').val() + '&ls_key=' + FunnelsUtil.ls_key+ '&bundle_question_step='+FunnelsUtil.tabStep);
    }
};

var menuToDropdown = {
    convertedQuestionKeys: [],
    /**
     * will change question type according to business requirement
     * @param question
     * @returns {string|*}
     */
    getConvertedQuestions: function(questions){
        let $self = this;
        jQuery.each(questions, function(index, question) {
            //convert menu dropdown questions
            if(question["question-type"] == "menu") {
                //will change to dropdown if options are greater than 8, otherwise to menu
                if(question.options.fields !== undefined && question.options.fields.length > 8) {
                    question["question-type"] = "dropdown";
                    questions[index] = $self.getConvertedQuestion(index, question);
                }
            }
        });

        return questions;
    },

    /**
     * add/remove menu/dropdown specific question attributes
     * @param question
     * @returns {*}
     */
    getConvertedQuestion: function (key, question) {
        if (question["question-type"] == 'dropdown' && question['options']['searchable'] === undefined) {
            // add following json attributes in menu json for fully conversion from menu to dropdown
            question['options']['enable-field-label'] = 1;
            question['options']['field-label'] = 'select an option';
            question['options']['randomize'] = 0;
            question['options']['searchable'] = 0;
            this.addConvertedQuestion(key);
        } else if(question["question-type"] == 'menu' && this.isConverted(key)){
            // delete following json attribute from menu json
            delete question['options']['enable-field-label'];
            delete question['options']['field-label'];
            delete question['options']['randomize'];
            delete question['options']['searchable'];
            this.removeConvertedQuestion(key);
        }
        return question;
    },

    /**
     * Conversion from menu to dropdown and vice versa
     * only convert from dropdown to menu till changes aren't saved
     * @param question_type
     */
    saveConvertedQuestion: function(key, question_type) {
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        funnel_info.questions[key]['question-type'] = question_type;
        funnel_info.questions[key] = this.getConvertedQuestion(key, funnel_info.questions[key]);
        FunnelsUtil.saveFunnelData(funnel_info);
    },

    /**
     * check if converted question
     * @param key
     * @returns {boolean}
     */
    isConverted: function(key){
        return (this.convertedQuestionKeys.indexOf(key) !== -1);
    },

    /**
     * add converted question
     * @param key
     */
    addConvertedQuestion: function(key) {
        if(!this.isConverted(key)) {
            this.convertedQuestionKeys.push(key);
        }
    },

    /**
     * remove converted question
     * @param key
     */
    removeConvertedQuestion: function(key){
        if(this.isConverted(key)) {
            let index = this.convertedQuestionKeys.indexOf(key);
            if (index !== -1) {
                this.convertedQuestionKeys.splice(index, 1);
            }
        }
    },

    /**
     * reset converted question keys array
     */
    reset: function(){
        this.convertedQuestionKeys = [];
    }
}


var slider = {
    isTwoPuck: false,
    initialValue: 0,
    range: [],
    tmpOptsCount: 0,
    min: 0,
    max: 0,

    /**
     * check slider errors
     */
    checkErrors: function() {
        let activeTab = $('.fb-tab__tab-pane.active');
        var emptyFields = activeTab.find('[data-segment]').filter(function() { return this.value == ""; }).length;
        if(emptyFields || activeTab.find('[data-change-text].error').length > 0 || activeTab.find('[data-segment].error').length){
            FunnelsUtil.setSubmitButtonErrorState(true);
        } else {
            FunnelsUtil.setSubmitButtonErrorState(false);
        }
    },

    isSliderNumeric: function() {
      return json['options']['slider-numeric']['value'] == 1;
    },

    /**
     * set current values count after every range processed
     * @param count
     */
    setTempOptionsCount: function (count) {
        this.tmpOptsCount = count;
    },

    /**
     * To get correct index when setting initial value
     * @returns {number}
     */
    getTempOptionsCount: function() {
      return this.tmpOptsCount;
    },

    /**
     * set slider values
     * @param range
     */
    setRange: function (range){
        this.range = range;
    },

    /**
     * To get slider values
     * @returns {[]}
     */
    getRange: function () {
        return this.range;
    },

    /**
     * set slider min value
     * @param value
     */
    setMinRangeValue: function (value) {
        this.min = value;
    },

    /**
     * set slider max value
     * @param value
     */
    setMaxRangeValue: function (value) {
        this.max = value;
    },

    /**
     * TO get first slider value
     * @returns {number|string}
     */
    getMinRangeValue: function () {
        return this.min !== undefined ? this.min : "";
    },

    /**
     * to get last slider value
     * @returns {number|string}
     */
    getMaxRangeValue: function () {
        return this.max !== undefined ? this.max : "";
    },

    /**
     * To get slider specific value by index
     * @param key
     * @returns {*}
     */
    getRangeValueByKey:function (key){
        return this.range[key] === undefined ? this.range[0] : this.range[key];
    },

    /**
     * return values count
     * @returns {number}
     */
    getRangeCount: function () {
        return this.range.length;
    },

    /**
     * return slider current value
     * @returns {number}
     */
    getInitialValue: function () {
        return this.initialValue;
    },

    /**
     * set initial value for slider
     * @param initialValue
     */
    setInitialValue: function (initialValue) {
        this.initialValue = initialValue;
    },

    /**
     * set value for two-puck slider by key 0/1
     * @param key
     * @param value
     */
    setInitialValueByKey: function (key,value) {
        this.initialValue[key] = value;
    },

    isTwoPuckSlider: function () {
        return this.isTwoPuck;
    },

    setIsTwoPuck: function (isTwoPuck) {
        this.isTwoPuck = isTwoPuck;
    },

    /**
     * return max index for slider values
     * @returns {slider.range.length|number}
     */
    getMaxRangeCount: function (){
        let rangeCount = this.getRangeCount();
        return (rangeCount === 1) ? rangeCount : rangeCount - 1;
    },

    /**
     * show right & left labels on left pane & preview for slider
     */
    setLabels: function () {
        let left_label="",
            right_label = "";
        if(json['options']['slider-numeric']['value'] === 1) {
            if(this.isTwoPuckSlider()) {
                left_label = this.getLeftLabel(json['options']['slider-numeric']["two-puck"]["customize-slider-labels"]);
                right_label = this.getRightLabel(json['options']['slider-numeric']["two-puck"]["customize-slider-labels"]);
                // Slider: TwoPuck in left pane
                this.updateLeftRightLabels("two-puck", left_label, right_label);
            } else {
                left_label = this.getLeftLabel(json['options']['slider-numeric']["one-puck"]["customize-slider-labels"]);
                right_label = this.getRightLabel(json['options']['slider-numeric']["one-puck"]["customize-slider-labels"]);
                // Slider: OnePuck in left pane
                this.updateLeftRightLabels("one-puck", left_label, right_label);
            }
        } else if(json['options']['slider-non-numeric']['value'] === 1) {
            left_label = this.getLeftLabel(json['options']["slider-non-numeric"]["customize-slider-labels"], false);
            right_label = this.getRightLabel(json['options']["slider-non-numeric"]["customize-slider-labels"], false);
            // Slider: Non-numeric sin left pane
            this.updateLeftRightLabels("non-numeric-puck", left_label, right_label);
        }
        jQuery(".range-slider__value .slider-left-label").html(left_label);
        jQuery(".range-slider__value .slider-right-label").html(right_label);
    },

    /**
     * update labels in parent window
     * @param cls_prfix
     */
    updateLeftRightLabels: function(cls_prfix, left_label, right_label) {
        jQuery(".bs-slider__label." + cls_prfix + "-left").html(left_label);
        jQuery(".bs-slider__label." + cls_prfix + "-right").html(right_label);
    },

    /**
     * return left calculate label OR left value from slider JSON
     * @param customSliderLabels
     * @param isNumeric
     * @returns {string|*|string|slider.min}
     */
    getLeftLabel: function(customSliderLabels, isNumeric=true){
        if (customSliderLabels["value"] == 0 || customSliderLabels["left_label"] === "") {
            if(customSliderLabels["value"] == 0 || customSliderLabels["left"] == "") {
                let firstValue = this.getMinRangeValue();
                return isNumeric ? this.generateStringFromNumber(firstValue, customSliderLabels["value"] == 1 ? customSliderLabels["left"] : "") : firstValue;
            }
            return "";
        }
        return customSliderLabels["left_label"];
    },

    /**
     * return right calculate label OR right value from slider JSON
     * @param customSliderLabels
     * @param isNumeric
     * @returns {string|*|string|slider.max}
     */
    getRightLabel: function(customSliderLabels, isNumeric=true){
        if (customSliderLabels["value"] == 0 || customSliderLabels["right_label"] === "") {
            if(customSliderLabels["value"] == 0 || customSliderLabels["right"] == "") {
                let lastValue = this.getMaxRangeValue();
                return isNumeric ? this.generateStringFromNumber(lastValue, customSliderLabels["value"] == 1 ? customSliderLabels["right"] : "") : lastValue;
            }
            return "";
        }
        return customSliderLabels["right_label"];
    },

    /**
     * calculate value from given number for left/right label
     * @param number
     * @param customLabel
     * @returns {string|*}
     */
    generateStringFromNumber: function (number, customLabel = "") {
        let postVal = '',
            compareNumber = customLabel.toLowerCase();
        if(compareNumber.indexOf("any") !== -1) {
            return number;
        } else if (compareNumber.indexOf("more than") !== -1 || compareNumber.indexOf("over") !== -1) {
            postVal = "+";
        }

        number = number.replaceAll(",", "")
        if (number.indexOf(postVal) > 0) {
            postVal = "";
        }

        let numArr = this.getNumberDetailsFromString(number),
            units = ['', 'K', 'M', 'B', 'T', 'Q'];

        let logBase = 1000,
            base1000Log = this.logFactory(logBase),
            unit = base1000Log(numArr.number);
        if (unit !== undefined && unit && units[unit] !== undefined) {
            return numArr.prefix + (numArr.number / Number(Math.pow(logBase, unit)).toFixed(2)) + units[unit] + numArr.postfix + postVal;
        }
        return number + postVal;
    },

    /**
     * create function to get number by setting base log
     * currently using to get 1000 base log
     * @param base
     * @returns {function(*=): number}
     */
    logFactory: function (base) {
        let log = Math.log;
        return x => {
            return parseInt(log(x) / log(base), 10);
        }
    },

    /**
     * will return number along with prefix/postfix string
     * @param number
     * @returns {{number: string, prefix: string, postfix: string}}
     */
    getNumberDetailsFromString: function (number) {
        let numArr = number.replaceAll(",", "").split(""),
            details = {prefix: '', number: '', postfix: ''};
        for (let i = 0; i < numArr.length; i++) {
            if (isNaN(parseInt(numArr[i])) && details.number == '') {
                details.prefix += numArr[i];
            } else if (!isNaN(parseInt(numArr[i])) && details.postfix == '') {
                details.number += numArr[i];
            } else if (details.number != '') {
                details.postfix += numArr[i];
            }
        }
        return details;
    },

    getSliderValueByKey: function (index, is_first=true) {
        let number = this.range[index];
        if(number !== undefined) {
            if (number.indexOf(" to ") !== -1) {
                number = this.getFromFormattedValue(number, is_first);
            }

            let detail = this.getNumberDetailsFromString(number);
            return detail.number;
        }
        return "";
    },

    /**
     * show one-puck slider display value
     * @param value
     */
    setOnePuckFormattedValue:function(value){
        value  = this.getRangeValueByKey(value);
        if(value && value.start !== undefined) {
            let start = this.getDisplayValue(value.unit, value.start),
                end = this.getDisplayValue(value.unit, value.end);
            value = start + " to " + end;
        }
        jQuery("#current_val,.starting-point").html(value);
    },



    /**
     * show two-puck slider display value
     * @param firstValue
     * @param secondValue
     */
    setTwoPuckFormattedValue: function (firstValue, secondValue) {
        firstValue  = this.getRangeValueByKey(firstValue);
        secondValue = this.getRangeValueByKey(secondValue);
        if(firstValue && firstValue.value !== undefined) {
            firstValue = this.getDisplayValue(firstValue.unit, firstValue.is_increment ? (firstValue.value + 1) : firstValue.value);
        }
        if(secondValue && secondValue.value !== undefined) {
            secondValue = this.getDisplayValue(secondValue.unit, secondValue.value);
        }
        $(".two-puck-starting-point").html(firstValue + " to " + secondValue);
    },

    /**
     * return formatted value which will be shown as value
     * @param unit
     * @param value
     * @returns {string}
     */
    getDisplayValue: function(unit, value){
        value = this.numFormatter(value);
        if(unit.indexOf('%') !== -1) {
            return `${value}`.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + unit;
        }
        return unit + `${value}`.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    },

    numFormatter: function(num) {
        const formats = window.parent.document.querySelector('[data-slider-format-checkbox]:checked');
        const format = formats ? formats.getAttribute('data-format-option') : null;
        if (format){
            if(format === 'thousands' && num >= 1000){
                num =  (num/1000).toFixed(0) + 'K';
            }else if(format === 'millions' && num >= 1000000){
                num = (num/1000000).toFixed(1) + 'M';
            } else if(format === 'billions' && num >= 1000000000){
                num = (num/1000000000).toFixed(1) + 'B';
            }
        }
        return num
    },

    /**
     * set slider starting/ending index as value if found index
     * check value starting/ending in values if found than set index as value
     * @param element
     * @param values
     */
    setValue: function (element, values) {
        if(element["slider-starting-point"]["value"] === 1) {
            let $self = this,
                startingValue = element["slider-starting-point"]['starting-value'];
            if (this.isTwoPuck) {
                let endingValue = element["slider-starting-point"]['ending-value'];
                $.each([startingValue, endingValue], function (index, value) {
                    if (value != "") {
                        if (values[value] !== undefined) {
                            $self.initialValue[index] = value;
                        } else {
                            let valueIndex = values.indexOf(value);
                            if (valueIndex !== -1) {
                                $self.initialValue[index] = valueIndex;
                            } else {
                                //checking numeric value in start/end range value, to get correct starting point for old funnels
                                values.find((obj, i) => {
                                    if(typeof obj === "object") {
                                        if (value >= obj.value && value <= values[i+1].value) {
                                            $self.setInitialValueByKey(index, i);
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
            } else if (startingValue != "") {
                if (values[startingValue] !== undefined) {
                    this.initialValue = startingValue;
                } else {
                    let index = values.indexOf(startingValue);
                    if (index !== -1) {
                        this.initialValue = index;
                    } else {
                        //checking numeric value in start/end range value, to get starting point for old funnels
                        values.find((obj, i) => {
                            if(typeof obj === "object") {
                                if (startingValue >= obj.start && startingValue <= obj.end) {
                                    this.initialValue = i;
                                }
                            }
                        });
                    }
                }
            }
        }
    },

    /**
     * To show correct customer selected value when enable/disable custom labels toggle
     * @param element
     */
    updateInitialValueIndex: function(element) {
        let $self = this;
        if(element['customize-slider-labels']['left'] != "") {
            let maxCount = this.getRangeCount();
            if($self.isTwoPuckSlider()) {
                if(element['customize-slider-labels']["value"] == 1) {
                    if($self.initialValue[0] < maxCount) {
                        element["slider-starting-point"]['starting-value'] = $self.initialValue[0] + 1;
                    }
                    if($self.initialValue[1] <= maxCount) {
                        element["slider-starting-point"]['ending-value'] = $self.initialValue[1] + 1;
                    }
                } else {
                    if($self.initialValue[0] > 0) {
                        element["slider-starting-point"]['starting-value'] = $self.initialValue[0] - 1;
                    }
                    if($self.initialValue[1] > 1) {
                        element["slider-starting-point"]['ending-value'] = $self.initialValue[1] - 1;
                    }
                }
            } else {
                if(element['customize-slider-labels']["value"] == 1 && $self.initialValue <= maxCount) {
                    element["slider-starting-point"]['starting-value'] = $self.initialValue+1;
                } else if(element['customize-slider-labels']["value"] == 0 && $self.initialValue > 0) {
                    element["slider-starting-point"]['starting-value'] = $self.initialValue-1;
                }
            }
        }
    },

    /**
     * refresh slider in left pane after enable/disable custom labels toggle
     */
    refresh: function(isCustomLabelsChanged = false) {
        let slider;
        if(this.isSliderNumeric()) {
            if(this.isTwoPuckSlider()) {
                slider = jQuery("[data-slider-two-puck-point-value]");
            } else {
                slider = jQuery(".fb-slider");
            }
        } else {
            slider = jQuery(".non-numeric-slider");
        }

        if(slider !== undefined) {
            if(isCustomLabelsChanged) {
                FunnelsUtil.currentLoadedQuestion();
                FunnelsUtil.setSliderValue();
            }
            slider.bootstrapSlider("setAttribute", "max", this.getMaxRangeCount());
            slider.bootstrapSlider("refresh");
            slider.bootstrapSlider("setValue", this.getInitialValue(), true).trigger('change');
            this.setLabels();
        }
    }
};

var securityMessage = {
    getDefaultMessage: function () {
        return security_message_config.defaults;
    },

    getIcon: function (icon_style={}) {
        icon_style.enabled = $('[data-security-message-icon]').is(":checked");
        icon_style.icon = $('[data-security-message-icon-class]').find('.ico').attr("class");
        icon_style.color = $('[data-security-message-icon-color]').find('.custom-color-value').val();
        icon_style.position = $("[data-security-message-icon-position]").val();
        icon_style.size = $("[data-security-message-icon-size]").val();
        return JSON.stringify(icon_style);
    },

    getStyle: function (tcpa_text_style = {}) {
        tcpa_text_style.is_bold = $('[data-security-message-bold]').hasClass('active') ? true : false;
        tcpa_text_style.is_italic = $('[data-security-message-italic]').hasClass('active') ? true : false;
        tcpa_text_style.color = $('[data-security-message-text-color]').find('.custom-color-value').val();
        return JSON.stringify(tcpa_text_style);
    },

    getButtonText: function() {
        return $('[data-security-message-button-text]').val().trim();
    },

    getMessage: function (message ) {
        if(typeof message !== "object") {
            message = Object.assign({}, this.getDefaultMessage());
        } else {
            message = Object.assign({}, message);
            message.icon = JSON.parse(message.icon);
            message.tcpa_text_style = JSON.parse(message.tcpa_text_style);
        }
        message.icon = this.getIcon(message.icon);
        message.tcpa_text_style = this.getStyle(message.tcpa_text_style);
        message.tcpa_text = this.getButtonText();
        return message;
    }
};


var FBValidator = {
    isUniqueVariableName: function (funnel_info) {
        let questionId = parseInt($('[data-id="ques_id"]').val()),
            question_unique_variable_name = $('[data-change-unique-variable]').val(),
            contactUniqueVariableNames = [],
            question = funnel_info.questions[questionId],
            isMarkError = true,
            vehicleTabStep = 0;

        if(question['question-type'] == "contact") {
            let stepKey = $('[data-id="active_slide"]').val();
                // uniqueVariables = [];
            $.each(question.options['all-step-types'][question.options.activesteptype - 1].steps, function (index, step) {
                $.each(step.fields, function (idx, stepQuestion) {
                    let key = Object.keys(stepQuestion);
                    if (stepQuestion[key[0]].value) {
                        let variableName = getUniqueVariableName(stepQuestion[key[0]]);
                        contactUniqueVariableNames.push(variableName);
                        // getting current step question unique variable name
                        // if(stepKey == index) {
                        //     contactUniqueVariableNames[uniqueVariables.length -1] = variableName;
                        // }
                    }
                });
            });

            if(!isValidContactQuestion(contactUniqueVariableNames, questionId)) {
                return false;
            }
        } else if(question['question-type'] == "vehicle") {
            let variableNames = getUniqueVariableName(question.options);
            isMarkError = false;
            vehicleTabStep = FunnelsUtil.tabStep ? 0 : 1;
            if(!isUniqueVariableName(variableNames[vehicleTabStep])) {
                return false;
            }
            vehicleTabStep = FunnelsUtil.tabStep;
        }
        isMarkError = true;

        return isUniqueVariableName(question_unique_variable_name);

        function isUniqueVariableName(unique_variable_name) {
            for (let i = 0; i < funnel_info.sequence.length; i++) {
                let sequence = funnel_info.sequence[i],
                    q = funnel_info.questions[sequence];
                if(q['question-type'] == "contact") {
                    let uniqueVariables = [];
                    $.each(q.options['all-step-types'][q.options.activesteptype - 1].steps, function (index, step) {
                        $.each(step.fields, function (idx, stepQuestion) {
                            let key = Object.keys(stepQuestion);
                            if (stepQuestion[key[0]].value) {
                                let variableName = getUniqueVariableName(stepQuestion[key[0]]);
                                uniqueVariables.push(variableName);
                            }
                        });
                    });

                    if(contactUniqueVariableNames.length === 0){
                        if($.inArray(unique_variable_name, uniqueVariables) !== -1) {
                            markFieldError();
                            return false;
                        }
                    } else if(!isValidContactQuestion(uniqueVariables, sequence)) {
                        return false;
                    }
                } else {
                    let variableName = getUniqueVariableName(q.options);
                    if(contactUniqueVariableNames.length) {
                        if ($.isArray(variableName)) {
                            for (let k = 0; k <= variableName.length; k++) {
                                if($.inArray($.trim(variableName[k]), contactUniqueVariableNames) !== -1) {
                                    markFieldError(variableName[k]);
                                    return false;
                                }
                            }
                        } else if($.inArray($.trim(variableName), contactUniqueVariableNames) !== -1) {
                            markFieldError(variableName);
                            return false;
                        }
                    } else if ($.isArray(variableName)) {
                        if(!isUniqueName(variableName, unique_variable_name, sequence, vehicleTabStep)) {
                            markFieldError();
                            return false;
                        }
                    } else if (sequence != questionId && unique_variable_name === $.trim(variableName)) {
                        markFieldError();
                        return false;
                    }
                }
            }
            return true;
        }

        function getUniqueVariableName(options) {
            if (options.hasOwnProperty('unique-variable-name')) {
                return options['unique-variable-name'];
            }
            return options['data-field'];
        }

        function isUniqueName(names, name, sequence, currentKey) {
            let num = jQuery.grep(names, function (a) { return a == name; }).length;
            if(num > 1) {
                return false;
            } else if ($.isArray(names)) {
                let found = $.inArray(name, names);
                if(found !== -1 && (sequence != questionId || (sequence == questionId && found != currentKey))) {
                    return false;
                }
            }
            return true;
        }

        function isValidContactQuestion(uniqueVariables, sequence) {
            for (let index = 0; index <= contactUniqueVariableNames.length; index++) {
                if (!isUniqueName(uniqueVariables, contactUniqueVariableNames[index], sequence, index)) {
                    markFieldError(contactUniqueVariableNames[index]);
                    return false;
                }
            }
            return true;
        }

        function markFieldError(name) {
            if(isMarkError) {
                let unique_variable_field = $('[data-change-unique-variable]');
                if (name) {
                    $.each(unique_variable_field, function (i, field) {
                        field = $(field);
                        if (field.val().trim() == $.trim(name)) {
                            field.addClass('error');
                        }
                    });
                } else {
                    unique_variable_field.addClass('error');
                }
            }
        }
    }
};
