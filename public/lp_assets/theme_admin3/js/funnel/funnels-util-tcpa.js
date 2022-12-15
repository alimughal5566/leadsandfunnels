Array.prototype.max = function() {
    return Math.max.apply(null, this);
};

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

var FunnelsUtilTcpa = {
    debug : (typeof site === 'undefined' || site.env_production.toLowerCase() === "local") ? true : false,
    ls_prefix : "",
    ls_key : "",
    load_data: "local_storage",
    funnel: {
        sequence: [],
        questions:{},
        tcpa_messages: [],
        question_value: ""
    },
    questionInputFieldName: [],
    callback: function(){},

    /**
     * This function creates localstorage key for Funnel which we are going to create
     *  - First we need to check we have any key in hash if yes then we don't need to
     *      create another localstorage key
     */
    create: function(){
        this._log(typeof this.funnel.sequence)
        this._log(typeof this.funnel.questions)

        // get new key
        this.setFunnelKey();

        // information not in localstorage lets set it now
        if(this.ls_key !== "" && localStorage.getItem(this.ls_key) === null){
            localStorage.setItem(this.ls_key, JSON.stringify(this.funnel));
        }
    },

    /**
     * On Dragging question this function add selected question to funnel json and save in localstorage
     * @param dragged_question DOM object
     */
    addQuestion: function(dragged_question){
        this.create();
        let type = dragged_question.data('question-type');
        let question_props = hbar.getJson(type+".json");
        if(FunnelsUtilTcpa.debug) this._log(question_props);

        let qkey = this._getQuestionKey();
        let funnel_info =  FunnelsUtilTcpa.setDataField(type,question_props,qkey);
        localStorage.setItem(this.ls_key, JSON.stringify(funnel_info));
        return qkey;
    },

    /**
     * Create key if not already exist in URL / set key if already exists in URL
     */
    setFunnelKey: function() {
        this.ls_key = this.ls_key === "" ? this.ls_prefix + $('[data-id="main-submit"]').data("lpkeys") : this.ls_key;
    },

    /**
     * Save funnel data in local storage
     * @param funnel_info
     */
    saveFunnelData: function(funnel_info) {
      //  debugger;
        localStorage.setItem(FunnelsUtilTcpa.ls_key, JSON.stringify(funnel_info));
        // this.temporaryFieldName();
    },

    /**
     * This functions get updated funnel information from local storage.
     * @private
     */
    _getFunnelInfo: function(load_from=null){
       // debugger;
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

    _log: function(args, label){
        if(this.debug){
            if(label === undefined) console.log(args);
            else console.log(args, label);
        }
    },

    _getQuestionKey: function (){
        let num = 0;
        let funnel_info = this._getFunnelInfo();
        if(funnel_info.sequence.length == 0){
            num = funnel_info.sequence.length + 1;
        } else {
            this._log(typeof funnel_info.sequence)
            num = funnel_info.sequence.max() + 1
        }

        return num;
    },

    /**
     * Rename data fields by concating data-field with 'contact' and question key
     * @param options
     * @param qkey
     * @param newkey
     */
    renameContactDataFields: function (options, qkey, newkey=null) {

        let total_steps = options['all-step-types'].length - 1;
        for (let i = 0; i <= total_steps; i++) {
            let step = options['all-step-types'][i]['steps'];
            $.each(step, function (index, value) {
                let current_step = value['fields'];
                $.each(current_step, function (step_index, step_value) {
                    let key = Object.keys(step_value);
                    step[index]['fields'][step_index][key[0]]['data-field'] = (newkey !== null) ? step_value[key[0]]['data-field'].replace("contact_" + qkey, "contact_" + newkey) : key[0] + "_step" + (index + 1) + "_contact_" + qkey;
                    step[index]['fields'][step_index][key[0]]['unique-variable-name'] = step[index]['fields'][step_index][key[0]]['data-field'];
                });
            });
        }

        return options;
    },

    /**
     * loads saved DB Questions
     */
    loadDBQuestion:function (){
        this.setFunnelKey();

        // reset funnel in local storage on page refresh
        //this.resetFunnel();

        let questions = JSON.parse(question_json);
        let sequence = JSON.parse(funnel_sequence);

        if(this.ls_key !== "" && localStorage.getItem(this.ls_key) === null){
            for (let i = 0; i < sequence.length; i++) {
                let question = questions[sequence[i]];
                let type = question['question-type'].toLowerCase();
                FunnelsUtilTcpa.setDataField(type, question, sequence[i], false);
            }
            FunnelsUtilTcpa.create();
        } else {
            this.funnel.questions = questions;
            this.funnel.sequence = sequence;
            FunnelsUtilTcpa.saveFunnelData(this.funnel);
        }
    },

    setDataField: function (type,question_props,qkey,add_question=true){
        let funnel_info = this._getFunnelInfo();
        funnel_info.questions[qkey] = {};
        if (add_question) {
            if (type === 'contact') {
                funnel_info.questions[qkey]['options'] = this.renameContactDataFields(question_props['options'], qkey);
            } else {
                this._log(funnel_info.questions[qkey]);
                funnel_info.questions[qkey]['options'] = question_props['options'];
                funnel_info.questions[qkey]['options']['data-field'] = funnel_info.questions[qkey]['options']['unique-variable-name'] = type.replace('-', '') + "_" + qkey;
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
    customQuestion: function() {
        var selectlist = question_select_list;
        for(var i = 0; i < selectlist.length; i++){
            this.questionsSelectinit(selectlist[i].selecter,selectlist[i].parent);
        }
    },

    /*
    ** init custom select
    **/
    questionsSelectinit: function (selecter,parent) {
        var amIclosing = false;
        var _selector = jQuery(selecter);
        var _parent = jQuery(parent);
        var selectorClass = selecter.replace(/[#.]/g,'');
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
        }).on('change',function () {
            $(this).parents('.select-area').addClass('chnage-active');
            var questionID = $(this).val();
            if(questionID == 4) {
                $(this).parents('.conditional-select-wrap').find('.recipients-slide').show();
                $(this).parents('.conditional-select-wrap').find('.show-queston-slide').hide();
            }
            else {
                $(this).parents('.conditional-select-wrap').find('.show-queston-slide').show();
                $(this).parents('.conditional-select-wrap').find('.recipients-slide').hide();
                var questionConfig = then_questions_options_list['then_question_config_' + questionID];
                if(questionConfig != undefined) {
                    var select2_config = {
                        minimumResultsForSearch: -1,
                        width: '100%', // need to override the changed default
                        dropdownParent: $(this).parents('.conditional-select-wrap').find('.show-question-parent'),
                        data: questionConfig.then_Options,
                        templateResult: function (d) { return $(d.text); },
                        templateSelection: function (d) { return $(d.text); }
                    };
                    var findQuestion = $(this).parents('.conditional-select-wrap').find('.show-question');
                    if(findQuestion.data('select2')) {
                        showQuestionSelect2(findQuestion.select2('destroy').empty(), select2_config);
                    }
                    else {
                        showQuestionSelect2(findQuestion.empty(), select2_config);
                    }
                }
                else {
                    console.log('then_not define');
                }
            }
        }).on('select2:opening', function() {
            _parent.find('.select2-selection__rendered').css('opacity', '0');

            /*
            ** Triggered whenever the drop-down is opened.
            ** select2:opening is fired before this and can be prevented.
            */
        }).on('select2:open', function() {
            var _selectoptions = _parent.find('.select2-results__options');
            var _selectdropdown = _parent.find('.select2-dropdown');

            _selectoptions.css('pointer-events', 'none');

            setTimeout(function() {
                _selectoptions.css('pointer-events', 'auto');
            }, 300);

            _selectdropdown.hide();
            _selectdropdown.css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            _parent.find('.select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                _parent.find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                    var getindex = _selector.find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 100);

            /*
            ** Triggered before the drop-down is closed.
            */
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
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
        }).on('select2:close', function() {
            _parent.find('.select2-selection__rendered').show();
            _parent.find('.select2-selection__rendered').css('opacity', '1');
            _parent.find('.select2-results__options').css('pointer-events', 'none');
        });
    },

    /**
     * Reset Funnel
     */
    resetFunnel: function () {
        localStorage.removeItem(this.ls_key);
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
        return function() {
            let context = this, args = arguments;
            let later = function() {
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

    temporaryFieldName: function (){

        let funnelData = this._getFunnelInfo("local_storage");

       // debugger;
        var fieldName = [];
        if(funnelData) {
            let field = 'jjjj';
            /*for (let i = 0; i < funnelData.sequence.length; i++) {
                if(typeof funnelData.questions[funnelData.sequence[i]]['options'] != "undefined") {
                    if(funnelData.questions[funnelData.sequence[i]]['options'].hasOwnProperty('unique-variable-name')){
                        field =  funnelData.questions[funnelData.sequence[i]]['options']['unique-variable-name'];
                    }
                    else{
                        field =  funnelData.questions[funnelData.sequence[i]].options['data-field'];
                    }
                    if(typeof field != "undefined"){
                        fieldName.push(field);
                    }
                }
            }*/
            fieldName.push(field);
            this.questionInputFieldName = fieldName;
        }
    },

    /**
     * Escape html entities
     * @param val
     * @returns {*}
     */
    escapeHtmlEntities: function (val, reverse=false) {
        let htmlEntities = ['"', "'", "&", "/", "`", "=", "<", ">"];
        let characterEntities = ['&quot;', '&apos;', '&amp;', '&#x2F;', '&#x60;', '&#x3D;', '&lt;', '&gt;'];
        $.each( htmlEntities, function( index, value ) {
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
    sortByValue: function (a, b){
    var a = a.toLowerCase();
    var b = b.toLowerCase();
    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    }
};
