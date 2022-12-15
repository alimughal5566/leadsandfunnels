Array.prototype.max = function() {
    return Math.max.apply(null, this);
};

var Funnels = {
    debug : true,
    ls_prefix : "lpfbapp",
    ls_key : "",
    funnel: {
        sequence: [],
        questions:{}
    },

    /**
     * This function creates localstorage key for Funnel which we are going to create
     *  - First we need to check we have any key in hash if yes then we don't need to
     *      create another localstorage key
     */
    create: function(){
        console.log(typeof this.funnel.sequence)
        console.log(typeof this.funnel.questions)

        // get new key
        this.setFunnelKey();

        // information not in localstorage lets set it now
        if(this.ls_key !== "" && localStorage.getItem(this.ls_key) === null){
            localStorage.setItem(this.ls_key, JSON.stringify(this.funnel));
            history.replaceState(null, null, window.location.pathname + "#" + this.ls_key);
            // need discussion with Sir Jaz on below code
            /*if(window.location.hash) {
                if(fbhash === "") history.replaceState(null, null, window.location.pathname + window.location.hash + "&" + this.ls_key);
            }
            else{
                history.replaceState(null, null, window.location.pathname + "#" + this.ls_key);
            }*/
        }
    },

    /**
     * On Dragging question this function add selected question to funnel json and save in localstorage
     * @param dragged_question DOM object
     */
    addQuestion: function(dragged_question){
        this.create();
        let section = dragged_question.data('question-section');
        let type = dragged_question.data('question-type');
        let question_props = hbar.getJson("questions.json")[section]['questions'][type];

        let funnel_info = this._getFunnelInfo();
        let qkey = this._getQuestionKey(funnel_info);
        funnel_info.questions[qkey] = question_props['options'];
        funnel_info.questions[qkey]['icon'] = question_props['icon'];
        funnel_info.questions[qkey]['label'] = question_props['label'];
        funnel_info.sequence.push(qkey);
        localStorage.setItem(this.ls_key, JSON.stringify(funnel_info));

        return qkey;
    },

    /**
     * Create key if not already exist in URL / set key if already exists in URL
     */
    setFunnelKey: function(page_reload=false) {
        let fbhash = "";
        if(window.location.hash) {
            let uri_fregment = window.location.hash.substring(1);

            let fregment_arr = uri_fregment.split("&");
            if(fregment_arr.length > 1){
                for(let i=0; i<fregment_arr.length; i++){
                    if(fregment_arr[i].indexOf(Funnels.ls_prefix) !== -1){
                        fbhash = (fregment_arr[i].indexOf("#") !== -1) ? fregment_arr[i].split("#")[0] : fregment_arr[i];
                    }
                }
            }
            else{
                if(uri_fregment.indexOf(Funnels.ls_prefix) !== -1){
                    fbhash = (uri_fregment.indexOf("#") !== -1) ? uri_fregment.split("#")[0] : uri_fregment;
                }
            }
        }

        if (page_reload) {
            this.ls_key = fbhash;
        } else {
            this.ls_key = fbhash === "" ? this.ls_prefix + Math.floor(Date.now() / 1000) : fbhash;
        }
    },

    /**
     * load saved questions from local storage on page refresh
     */
    loadQuestions: function() {
        // set funnel key
        this.setFunnelKey(true);

        if (this.ls_key != "") {
            var obj_data = {
                question_class: '',
                data_list: '',
                data_icon: ''
            };

            let funnel_info = this._getFunnelInfo();
            let questionsHtml = '';

            for (let i = 0; i < funnel_info.sequence.length; i++) {
                if (funnel_info.sequence[i] !== null) {
                    let question = funnel_info.questions[funnel_info.sequence[i]];

                    // if rel is not present
                    question.rel = (question && question.rel !== undefined) ? question.rel : question.label;
                    let questionField = "";
                    let clQuestionOptionValue = question["question-type"]+"-"+questionId;
                    if(question["question-type"] == "vehicle"){
                        clQuestionOptionValue = question["question-type"]+"-make-"+questionId;
                        questionField = question['options']['unique-variable-name'][0];
                    }else if(question["question-type"] == "slider"){
                        if(question["options"]['slider-numeric']['value'] == 1){
                            clQuestionOptionValue = question["question-type"]+"_numeric-"+questionId;
                        }
                        questionField = question['options']['unique-variable-name'];
                    }else{
                        questionField = question['options']['unique-variable-name'];
                    }

                    let question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="' + question.rel + '"><span class="sub-text">' + question.rel + '</span></span></div>';

                    questionsHtml += '<div data-field="'+questionField+'" data-id="ques' + funnel_info.sequence[i] + '" class="fb-question-item slide ' + question.icon + (question.icon == 'hidden-field' ? ' hidden-field-active' : '') + obj_data.data_list + ' ' + obj_data.question_class + '" >\n' +
                        '   <div class="question-item single-question-slide">\n' +
                        '   <div class="fb-question-item__serial"></div>\n' +
                        '      <div class="fb-question-item__detail">\n' +
                        '         <div class="fb-question-item__col">\n' +
                        '            <div class="question-text ' + question.icon + (question.icon == 'group' ? ' lastQuestion-colorText' : '') + '"><span class="sub-text">' + question.label + '</span></div>\n' +
                        (question.icon == 'group' ? ' <a href="#" class="dropable-slide-opener"><span class="ico-arrow-down"></span></a>\n' : '') +
                        '         </div> ' + question_dsc +
                        '         <div class="fb-question-item__col fb-question-item__col_control">\n' +
                        '            <a href="#" class="hover-hide">\n' +
                        '               <i class="fbi fbi_dots">\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '               </i>\n' +
                        '            </a>\n' +
                        '            <ul class="lp-control">\n' +
                        '                <li class="lp-control__item reply">\n' +
                        '                    <a title="Conditional&nbsp;Logic" class="lp-control__link fb-tooltip fb-tooltip_control" href="#conditional-logic" data-toggle="modal">\n' +
                        '                       <i class="lp-icon-conditional-logic ico-back"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item edit">\n' +
                        '                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-edit"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item copy">\n' +
                        '                    <a title="Duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-copy"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item lp-control__item_edit drag">\n' +
                        '                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control lp-icon-drag" href="#">\n' +
                        '                       <i class="ico-dragging"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item lp-control__item_edit delete">\n' +
                        '                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" onclick="deleteFunnelQuestion(this)" href="#confirmation-delete" data-toggle="modal">\n' +
                        '                       <i class="ico-cross"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '            </ul>\n' +
                        '         </div>\n' +
                        '          ' + obj_data.data_icon + '  \n' +
                        '         <div class="fb-question-item__col fb-question-item__col_lock">\n' +
                        '              <a href="#">\n' +
                        '                 <i class="lp-icon-lock ico-lock"></i>\n' +
                        '                 <i class="ico-back"></i>\n' +
                        '                 <i class="ico-globe"></i>\n' +
                        '              </a>\n' +
                        '         </div>\n' +
                        '   </div>\n' +
                        '   </div>\n' +
                        (question.icon == 'group' ? ' <div class="innerDropable-element"></div>\n' : '') +
                        '   </div>\n' +
                        '</div>';
                }
            }

            // set questions in dropable area
            if (questionsHtml != '') {
                $('.funnel-panel__placeholder').hide().css('height', 'auto').css('margin', '0px');
                $('.funnel-panel__sortable').append(questionsHtml).css('height', 'auto').css('margin', '0px');
            }
        }
    },

    /**
     * This functions get updated funnel information from local storage.
     * @private
     */
    _getFunnelInfo: function(){
        let info;
        if (localStorage.getItem(this.ls_key) !== null) {
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

    _getQuestionKey: function (funnel_info){
        let num = 0;

        if(funnel_info.sequence.length == 0){
            num = funnel_info.sequence.length + 1;
        } else {
            console.log(typeof funnel_info.sequence)
            num = funnel_info.sequence.max() + 1
        }

        return num;
    }
};
