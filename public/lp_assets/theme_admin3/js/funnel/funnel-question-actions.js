var FunnelActions = {
    currentQuestionId: null,
    questionBeforeChange: null,
    isAjaxRequestInProgress: false,
    contact_desc: '<div class="fb-question-item__col fb-question-item__col_plr14">\n' +
        '                                            <label class="fb-step-label">1 - STEP</label>\n' +
        '                                        </div>\n' +
        '                                        <div class="fb-question-item__col">\n' +
        '                                            <div class="fb-step">\n' +
        '                                                <div class="fb-step__title"></div>\n' +
        '                                                <div class="fb-step__caption">Full Name</div>\n' +
        '                                            </div>\n' +
        '                                        </div>\n' +
        '                                        <div class="fb-question-item__col">\n' +
        '                                            <div class="fb-step">\n' +
        '                                                <div class="fb-step__title"></div>\n' +
        '                                                <div class="fb-step__caption">Email Address</div>\n' +
        '                                            </div>\n' +
        '                                        </div>\n' +
        '                                        <div class="fb-question-item__col">\n' +
        '                                            <div class="fb-step">\n' +
        '                                                <div class="fb-step__title"></div>\n' +
        '                                                <div class="fb-step__caption">Phone Number</div>\n' +
        '                                            </div>\n' +
        '                                        </div>',
    zipcode_desc: '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder" title="FREE Down Payment Assistance Finder"> <span class="sub-text">FREE Down Payment Assistance Finder</span></span></div>',

    resetBeforeQuestionEditSettings: function () {
        this.currentQuestionId = null;
        this.questionBeforeChange = null;
        FunnelsUtil.setSubmitButtonErrorState(false);
    },

    /**
     * Click handler for funnel question from grid
     * @param element
     */
    deleteFunnelQuestion: function (element) {
        let deleteId = $(element).parents('.slide').data('id');
        QuestionConditions.renderAttachedConditions(deleteId);
        if ($(element).parents('.slide').hasClass('hidden-field')) {
            deleteId = "hidden_" + deleteId;
        }
        $('[data-id="deleteId"]').val(deleteId);
    },

    /**
     * Enable funnel save button
     */
    enableFunnelSaveBtn: function () {
        setTimeout(function () {
            $('[data-id="main-submit"]').removeAttr("disabled");
        }, 1);
    },

    /**
     * Disable funnel save button
     */
    disableFunnelSaveBtn: function () {
        setTimeout(function () {
            $('[data-id="main-submit"]').prop("disabled", true);
        }, 1);
    },

    /**
     * Save sorted questions in local storage
     */
    lpSortQuestions: function () {
        let funnel_info = FunnelsUtil._getFunnelInfo();
        let first_question_old = funnel_info.sequence[0];

        // reset sequence array
        funnel_info.sequence = [];

        jQuery('.funnel-panel__sortable').find('.slide').each((pos, el) => {
            let question = new Number(jQuery(el).data('id').replace("ques", ""));
            funnel_info.sequence.push(question);
        });
        if (first_question_old != funnel_info.sequence[0]) {
            if (funnel_info.questions[funnel_info.sequence[0]]['question-type'] == 'contact') {
                let active_step = funnel_info.questions[funnel_info.sequence[0]]['options']['activesteptype'] - 1;
                funnel_info.questions[funnel_info.sequence[0]]['options']['all-step-types'][active_step]['steps'][0]['enable-auto-cursor-focus'] = 1;
            } else if (typeof funnel_info.questions[funnel_info.sequence[0]]['question-type'] !== 'vehicle') {
                if (funnel_info.questions[funnel_info.sequence[0]]['options']['enable-auto-cursor-focus'] !== undefined) {
                    funnel_info.questions[funnel_info.sequence[0]]['options']['enable-auto-cursor-focus'] = 1;
                }
            }
        }
        if (JSON.stringify(funnel_info.sequence) !== JSON.stringify(funnel_info.existing_sequence)) {
            FunnelsUtil.handleSubmitButtonState(funnel_info);
            FunnelsUtil.saveFunnelData(funnel_info);
        }
    },

    /**
     * Duplicate question in grid and local storage json
     * @param element
     */
    duplicateQuestion: function (element) {
        let newQuestionId;
        let questionId = $(element).parents('.slide').data('id');

        // make duplicate in grid
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        if ($(element).parents('.slide').hasClass('hidden-field')) {
            newQuestionId = FunnelsUtil._getHiddenQuestionKey(funnel_info);
            let question = $('.funnel-panel-hidden__sortable').find('[data-id="' + questionId + '"]').get(0).outerHTML;
            let newQuestion = question.replace(questionId, "ques" + newQuestionId);
            $('.funnel-panel-hidden__sortable').append(newQuestion);
        } else {
            newQuestionId = FunnelsUtil._getQuestionKey(funnel_info);
            let question = $('.funnel-panel__sortable').find('[data-id="' + questionId + '"]').get(0).outerHTML;
            let newQuestion = question.replace(questionId, "ques" + newQuestionId);
            $('.funnel-panel__sortable').find('[data-id="' + questionId + '"]').after(newQuestion)
        }

        // make duplicate in local storage
        questionId = questionId.replace('ques', '');
        if ($(element).parents('.slide').hasClass('hidden-field')) {
            let lsQuestion = funnel_info.hidden_fields[questionId];
            funnel_info.hidden_fields[newQuestionId] = lsQuestion;
        } else {
            let lsQuestion = funnel_info.questions[questionId];
            funnel_info.questions[newQuestionId] = lsQuestion;

            let new_question_index = funnel_info.sequence.indexOf(questionId) + 1;
            if (new_question_index == 0) {
                new_question_index = funnel_info.sequence.indexOf(parseInt(questionId)) + 1;
            }
            // question sequence will save next to the clone question
            funnel_info.sequence.splice(new_question_index, 0, newQuestionId.toString());
            // funnel_info.sequence.push(newQuestionId);
            FunnelsUtil.addNewQuestionId(funnel_info, newQuestionId);
        }
        FunnelsUtil.saveFunnelData(funnel_info);

        // update data-field in new question
        let funnel_info_update = FunnelsUtil._getFunnelInfo('local_storage');
        if ($(element).parents('.slide').hasClass('hidden-field')) {
            funnel_info_update.hidden_fields[newQuestionId] = FunnelActions.makeDuplicateHiddenField(funnel_info_update.hidden_fields[newQuestionId], newQuestionId);
            // Update hidden field label in DOM
            let updatedFieldLabel = funnel_info_update.hidden_fields[newQuestionId]['options']['field-label'];
            $('.fb-question-item.slide.hidden-field[data-id="ques' + newQuestionId + '"]').find('.sub-text:last').html(updatedFieldLabel);
        } else {
            if (funnel_info_update.questions[newQuestionId]['question-type'] == 'contact') {
                funnel_info_update.questions[newQuestionId]['options'] = FunnelsUtil.renameContactDataFields(funnel_info_update.questions[newQuestionId]['options'], questionId, newQuestionId);
            } else if (funnel_info_update.questions[newQuestionId]['question-type'] == 'vehicle') {
                for (let i = 0; i <= 1; i++) {
                    let value = funnel_info_update.questions[newQuestionId]['options']['data-field'][i];
                    let field = value.replace(questionId, newQuestionId);
                    funnel_info_update.questions[newQuestionId]['options']['data-field'][i] = field;
                    funnel_info_update.questions[newQuestionId]['options']['unique-variable-name'][i] = field;
                }
            } else {
                funnel_info_update.questions[newQuestionId]['options']['data-field'] = funnel_info_update.questions[newQuestionId]['options']['unique-variable-name'] = funnel_info_update.questions[newQuestionId]['options']['data-field'].replace(questionId, newQuestionId);
            }
        }
        FunnelsBuilder.item_length();
        FunnelsUtil.saveFunnelData(funnel_info_update);
        FunnelActions.enableFunnelSaveBtn();
        // open new question to edit
        $('.funnel-panel__sortable').find('[data-id="ques' + newQuestionId + '"] .lp-control__item.edit a').click();
    },

    /**
     * Make duplicate hidden field by keeping 'field-label', 'parameter' and 'data-field' attributes as unique
     *
     * @param newQuestion
     * @param newQuestionId
     * @returns {*}
     */
    makeDuplicateHiddenField: function (newQuestion, newQuestionId) {
        let count;
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        let updateDataField = true;

        // on duplicate update 'parameter' with unique value
        if (newQuestion['options']['parameter'] != "") {
            count = FunnelActions.getNewCount(newQuestion['options']['parameter']);
            if (count != 2) {
                var count_replace_param = count - 1;
                newQuestion['options']['parameter'] = newQuestion['options']['parameter'].replace("_" + count_replace_param, "_" + count);
            }
            newQuestion = FunnelActions.findDuplicateHiddenField(newQuestion, newQuestion['options']['parameter'], newQuestionId, count, funnel_info, updateDataField, 'parameter');
            updateDataField = false;
        }

        // on duplicate update 'field-label' with unique value
        count = FunnelActions.getNewCount(newQuestion['options']['field-label']);
        if (count != 2) {
            var count_replace = count - 1;
            newQuestion['options']['field-label'] = newQuestion['options']['field-label'].replace("_" + count_replace, "_" + count);
        }
        newQuestion = FunnelActions.findDuplicateHiddenField(newQuestion, newQuestion['options']['field-label'], newQuestionId, count, funnel_info, updateDataField, 'field-label');

        return newQuestion;
    },

    /**
     * Get new count if already have _ with some number value at the end of 'parameter' or 'field-label' then return its incremented value otherwise returns 2
     *
     * @param value
     * @returns {number}
     */
    getNewCount: function (value) {
        var n = value.lastIndexOf('_');
        var result = value.substring(n + 1);
        let count;

        if (isNaN(result) === false) {
            count = ++result;
        } else {
            count = 2;
        }

        return count;
    },

    /**
     * Recursive calling function to find for duplicate values and ignore them only return unique value for 'parameter', 'field-label' also auto calculate 'data-field'
     *
     * @param newQuestion
     * @param inputVal
     * @param newQuestionId
     * @param count
     * @param funnel_info
     * @param updateDataField
     * @param field
     * @param recursive
     * @returns {*}
     */
    findDuplicateHiddenField: function (newQuestion, inputVal, newQuestionId, count, funnel_info, updateDataField, field, recursive = false) {
        let found = false;
        let inputValUsed = (count != 2 && recursive === false) ? inputVal : inputVal + "_" + count;
        let dataField = inputValUsed.replace(/[^a-z0-9 ]/gi, '').replaceAll(' ', '_').toLowerCase();

        // search for duplicate values
        $.each(Object.keys(funnel_info.hidden_fields), function (k, key) {
            if (newQuestionId != key && (funnel_info.hidden_fields[key]['options']['field-label'] == inputValUsed || funnel_info.hidden_fields[key]['options']['parameter'] == inputValUsed || funnel_info.hidden_fields[key]['options']['data-field'] == dataField)) {
                found = true;
                return false;
            }
        });

        if (found) {
            count++;
            // find duplicate value so keep on searching by recursive call until find unique value
            return FunnelActions.findDuplicateHiddenField(newQuestion, inputVal, newQuestionId, count, funnel_info, updateDataField, field, true);
        } else {
            newQuestion['options'][field] = inputValUsed;
            // calculate data-field
            if (updateDataField) {
                newQuestion['options']['data-field'] = inputValUsed.replace(/[^a-z0-9 ]/gi, '').replaceAll(' ', '_').toLowerCase();
            }

            return newQuestion;
        }
    },

    /**
     * Edit question in grid using local storage json
     * @param element
     * @param question_id
     */
    editQuestion: function (element, question_id = null) {
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        this.currentQuestionId = question_id === null ? $(element).parents('.slide').data('id').replace('ques', '') : question_id;
        if (element !== null && $(element).parents('.slide').hasClass('hidden-field')) {
            FunnelsBuilder.isHiddenNew = false
            let currentQuestion = funnel_info.hidden_fields[this.currentQuestionId];
            FunnelsBuilder._setValuesToHiddenModal(currentQuestion);
            FunnelsBuilder.validHiddenField = true;
            $('body').addClass('hidden-field-modal');
            $('#hidden-field-modal').modal('show');
            $('[data-id="ques_id"]').val(this.currentQuestionId);
            if (!FunnelsBuilder.bindOpenClose) {
                FunnelsBuilder.bindOpenClose = true;
                InputControls.openclose();
            }
        } else {
            let active_step,
                active_slide;
            if (funnel_info.questions[this.currentQuestionId]['question-type'] == 'vehicle') {
                FunnelsUtil.tabStep = 0;
            }
            let currentQuestion = FunnelsBuilder.setQuestionOptions(this.currentQuestionId, true);
            if (question_type == 'contact') {
                active_step = currentQuestion['options']['activesteptype'] - 1;
                active_slide = currentQuestion.hasOwnProperty('active_slide') ? currentQuestion['active_slide'] : 0;
                currentQuestion['options']['all-step-types'][active_step]['steps'][active_slide] = FunnelsUtil.getOptionsValue(currentQuestion['options']['all-step-types'][active_step]['steps'][active_slide]);
            } else if (question_type !== 'vehicle') {
                currentQuestion['options'] = FunnelsUtil.getOptionsValue(currentQuestion['options']);
                currentQuestion['options']['edit'] = 1;
            }

            // render textarea
            if (question_type == 'textarea') {
                question_type = 'text';
            }

            if (question_type !== "bundle_question") {
                $('body').removeClass('overlay-active').addClass('overlay-active');
                hbar.renderTemplate(question_type + '.hbs', "questionEditor", currentQuestion, FunnelsUtil.debounce(function () {
                    if (question_type == 'contact') {
                        jQuery('[button-icon-color]').ColorPickerSetColor(currentQuestion['options']['all-step-types'][active_step]['steps'][active_slide]['cta-button-settings']['button-icon-color']);
                    } else {
                        jQuery('[button-icon-color]').ColorPickerSetColor(currentQuestion['options']['cta-button-settings']['button-icon-color']);
                    }
                }, 100));
            }
        }
        sessionStorage.setItem("unique_variable", $(element).data('seq'))
    },

    /**
     * cache current question values before change
     * @param question
     */
    setCurrentQuestion: function (question, questionId) {
        let currentQuestion = JSON.parse(JSON.stringify(question));
        this.deleteQuestionNotRequiredData(currentQuestion);
        this.currentQuestionId = questionId;
        this.questionBeforeChange = currentQuestion;
        $('[data-id="ques_id"]').removeData('new-question');
    },

    /**
     * change value in cached question
     * @param key
     * @param value
     */
    setCurrentQuestionOptionValue: function (key, value) {
        if (this.questionBeforeChange && this.questionBeforeChange.options[key] !== undefined) {
            this.questionBeforeChange.options[key] = value;
        }
    },

    isQuestionChanged: function () {
        if (typeof this.questionBeforeChange !== "object" || !this.currentQuestionId) {
            return false;
        }

        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage'),
            currentQuestion = funnel_info.questions[this.currentQuestionId];

        this.deleteQuestionNotRequiredData(currentQuestion);
        let isChanged = ajaxRequestHandler.isEquals(this.questionBeforeChange, currentQuestion);
        console.log(isChanged, this.questionBeforeChange, '---\n<br/>', currentQuestion);
        return !isChanged;
    },

    isNewQuestion: function () {
        return $('[data-id="ques_id"]').data('new-question');
    },

    /**
     * Get question html
     * @param obj_data
     * @param ui
     * @param questionId
     * @param question
     * @returns {string}
     */
    getQuestionHtml: function (obj_data, ui = null, questionId = null, question = null) {
        let hiddenField;
        let groupItem;
        if (ui == null) {
            hiddenField = question.icon == 'hidden-field';
            groupItem = question.icon == 'group';
        } else {
            hiddenField = ui.item.hasClass('hidden-field-item');
            groupItem = ui.item.hasClass('group-item');
        }

        // Code added for Conditional Logic Icon - Start
        let questionField = "";
        let clQuestionOptionValue = "";
        if (question !== null) {
            clQuestionOptionValue = question["question-type"] + "-" + questionId;
            if (question["question-type"] === "vehicle") {
                clQuestionOptionValue = question["question-type"] + "-make-" + questionId;
                questionField = question['options']['unique-variable-name'][0];
            } else if (question["question-type"] === "slider") {
                if (question["options"]['slider-numeric']['value'] == 1) {
                    clQuestionOptionValue = question["question-type"] + "_numeric-" + questionId;
                }
                questionField = question['options']['unique-variable-name'];
            } else if (question["question-type"] === "contact") {
                console.log('>>>>>>>>>>>>>>>>>>>>>>>>Contact qUESTION>>>>>>>>>>>>>>>>>>>>>>>>>>>');
                console.log(question);
                console.log('>>>>>>>>>>>>>>>>>>>>>>>>Contact qUESTION>>>>>>>>>>>>>>>>>>>>>>>>>>>');
                let activeStepType = question["options"]['activesteptype'];
                let allStepTypes = question["options"]['all-step-types'];
                let stepTypeData = allStepTypes[activeStepType - 1];
                let contactquestionFields = new Array();
                if (stepTypeData != "" && typeof stepTypeData == "object" && Object.keys(stepTypeData).length > 0) {
                    for (const [key, value] of Object.entries(stepTypeData['steps'])) {
                        let currObj = stepTypeData['steps'][key];
                        let dataFieldData = funnelQuestions._getContactDataField(currObj);
                        let dataField = dataFieldData['fields'];
                        console.log('>>>>>>>>>>>>>>>>>>>>>>>>x of Fields>>>>>>>>>>>>>>>>>>>>>>>>>>>');
                        for (const x of dataField) {
                            console.log(x);
                            contactquestionFields.push(x);
                        }
                        console.log('>>>>>>>>>>>>>>>>>>>>>>>>x of Fields>>>>>>>>>>>>>>>>>>>>>>>>>>>');
                    }
                    console.log('>>>>>>>>>>>>>>>>>>>>>>>>contactquestionFields>>>>>>>>>>>>>>>>>>>>>>>>>>>');
                    console.log(typeof contactquestionFields);
                    console.log(contactquestionFields.length);
                    console.log(contactquestionFields);
                    console.log(contactquestionFields.join("~~"));
                    console.log('>>>>>>>>>>>>>>>>>>>>>>>>contactquestionFields>>>>>>>>>>>>>>>>>>>>>>>>>>>');
                    questionField = (typeof contactquestionFields != undefined && contactquestionFields.length) ? contactquestionFields.join("~~") : "";
                    clQuestionOptionValue = "contact-" + questionField;
                }
            } else {
                questionField = question['options']['unique-variable-name'];
            }
        }
        let isClIcon = true;
        if (typeof (question) != "undefined" && question !== null) {
            switch (question["question-type"]) {
                case 'birthday':
                    isClIcon = true;
                    break;
                case 'ctamessage':
                    isClIcon = false;
                    break;

            }

        }
        // Code added for Conditional Logic Icon - End

        const unique_seq = (questionId && question) ? `${question['question-type']}_${questionId}` : `NEW`;
        let questionID = (questionId) ? 'ques' + questionId : 'new-ques';

        let html = "";

        html = '<div data-field="' + questionField + '" data-id="' + questionID + '" class="fb-question-item slide ' + obj_data.question_icon + (hiddenField ? ' hidden-field-active' : '') + obj_data.data_list + ' ' + obj_data.question_class + '" >\n' +
            '   <div class="question-item single-question-slide">\n' +
            '   <div class="fb-question-item__serial"></div>\n' +
            '      <div class="fb-question-item__detail">\n' +
            '         <div class="fb-question-item__col">\n' +
            '            <div class="question-text ' + obj_data.question_icon + (groupItem ? ' lastQuestion-colorText' : '') + '"><span class="sub-text">' + obj_data.question_type + '</span></div>\n' +
            (groupItem ? ' <a href="#" class="dropable-slide-opener"><span class="ico-arrow-down"></span></a>\n' : '') +
            '         </div> ' + obj_data.question_dsc +
            '         <div class="fb-question-item__col fb-question-item__col_control">\n' +
            '            <a href="#" class="hover-hide">\n' +
            '               <i class="fbi fbi_dots">\n' +
            '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '               </i>\n';
        html += '            <span class="conidtion-status-icon"><i class="ico-back"></i></span>\n';
        html += '         </a>\n' +
            '            <ul class="lp-control">\n';
        html += '            <li class="lp-control__item reply ' + (isClIcon === true ? '' : 'd-none') + '" >\n' +
            '                    <a title="Conditional&nbsp;Logic" data-cl-question-value="' + clQuestionOptionValue + '" data-cl-db-add-cond="cl-db-add-condition" class="lp-control__link fb-tooltip fb-tooltip_control" onclick="clList.addNewCLCondition(this)" href="javascript:void(0)" >\n' +
            '                       <i class="lp-icon-conditional-logic ico-back"></i>\n' +
            '                    </a>\n' +
            '                </li>\n' +
            '                <li class="lp-control__item edit">\n' +
            '                    <a title="Edit" data-seq="' + unique_seq + '" class="lp-control__link fb-tooltip fb-tooltip_control" onclick="FunnelActions.editQuestion(this)" href="javascript:void(0);">\n' +
            '                       <i class="ico-edit"></i>\n' +
            '                    </a>\n' +
            '                </li>\n' +
            '                <li class="lp-control__item copy">\n' +
            '                    <a title="Duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" onclick="FunnelActions.duplicateQuestion(this)" href="javascript:void(0);">\n' +
            '                       <i class="ico-copy"></i>\n' +
            '                    </a>\n' +
            '                </li>\n';
        html += '            <li class="lp-control__item lp-control__item_edit drag">\n' +
            '                  <span title="Move" class="inner-item-wrap fb-tooltip fb-tooltip_control">\n' +
            '                    <a class="lp-control__link lp-control__link_cursor_move lp-icon-drag" href="#">\n' +
            '                       <i class="ico-dragging"></i>\n' +
            '                    </a>\n' +
            '                   </span>\n' +
            '                </li>\n' +
            '                <li class="lp-control__item lp-control__item_edit delete">\n' +
            '                   <span title="Delete" class="inner-item-wrap fb-tooltip fb-tooltip_control">\n' +
            '                    <a class="lp-control__link" onclick="FunnelActions.deleteFunnelQuestion(this)" href="#confirmation-delete" data-toggle="modal">\n' +
            '                       <i class="ico-cross"></i>\n' +
            '                    </a>\n' +
            '                    </span>\n' +
            '                </li>\n' +
            '            </ul>\n' +
            '         </div>\n' +
            '          ' + obj_data.data_icon + '  \n' +
            '   </div>\n' +
            '   </div>\n' +
            (groupItem ? ' <div class="innerDropable-element"></div>\n' : '') +
            '   </div>\n' +
            '</div>';
        if (unique_seq === "NEW") {
            sessionStorage.setItem("unique_variable", unique_seq)
        }


        return html;
    },

    /**
     * Render HTML to load saved questions from local storage on page refresh
     */
    loadQuestions: function (append_html) {
        if (append_html === undefined) append_html = true;
        FunnelsUtil.setFunnelKey();
        if (FunnelsUtil.ls_key != "") {
            var obj_data = {
                question_icon: '',
                question_type: '',
                question_dsc: '',
                question_class: '',
                data_list: '',
                data_icon: ''
            };

            let funnel_info = FunnelsUtil._getFunnelInfo();

            let questionsHtml = '';
            let contactQuestionsHtml = '';
            let questions_json = hbar.getJson("questions.json");
            let popular_icon = questions_json['popular']['questions'];
            let more_icon = questions_json['more-questions']['questions'];

            for (let i = 0; i < funnel_info.sequence.length; i++) {
                if (funnel_info.sequence[i] !== null) {
                    let question = funnel_info.questions[funnel_info.sequence[i]];
                    // Question Text on dashboard
                    question['options'] = FunnelsUtil.getOptionsValue(question['options']);
                    let question_rel_title = FunnelActions.getQuestionRelTitle(question);
                    let rel = question_rel_title[0];

                    // question-type for textarea is text
                    if (question['question-type'] == 'textarea') {
                        question['question-type'] = 'text';
                    }

                    if (question['question-type'] == 'contact') {
                        obj_data.question_dsc = FunnelActions.getContactDesc(question);
                    } else {
                        obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder">' +
                            '<span class="sub-text"><span class="text">' + rel + '</span></span>' +
                            '</span>' +
                            '</div>';
                    }


                    obj_data.question_icon = popular_icon[question['question-type']] !== undefined ? popular_icon[question['question-type']]['icon'] : more_icon[question['question-type']]['icon'];
                    obj_data.question_type = popular_icon[question['question-type']] !== undefined ? popular_icon[question['question-type']]['label'] : more_icon[question['question-type']]['label'];

                    if (funnel_info.sequence.length == 1 && rel === 'contact' && append_html === true) {
                        contactQuestionsHtml = FunnelActions.getQuestionHtml(obj_data, null, funnel_info.sequence[i], question);
                    } else {
                        //special case; when we have only contact question and we edit and close contact question
                        // if (funnel_info.sequence.length == 1 && rel === 'contact') {
                        //     $('[data-id="ques1"]').remove();
                        //     contactQuestionsHtml = FunnelActions.getQuestionHtml(obj_data, null, funnel_info.sequence[i], question);
                        // } else {
                        //     questionsHtml += FunnelActions.getQuestionHtml(obj_data, null, funnel_info.sequence[i], question);
                        // }
                        questionsHtml += FunnelActions.getQuestionHtml(obj_data, null, funnel_info.sequence[i], question);
                    }
                }
            }

            if (funnel_info.sequence.length > 1) {
                $('.funnel-panel__placeholder').hide();
            }
            // else {
            //     $('.funnel-panel__placeholder').show();
            // }
            // set questions in droppable area
            if (contactQuestionsHtml != '') {
                $('.funnel-panel__sortable').append(contactQuestionsHtml);
                $(".fb-question-item.contact").addClass('fb-question-item_steps fb-question-item_lock fb-question-item_contact-info');
            }
            if (questionsHtml != '') {
                if (!append_html) {
                    $('.funnel-panel__sortable').html(questionsHtml).css({
                        "height": "auto",
                        "margin": "0px",
                        'min-height': 'inherit'
                    });
                } else {
                    $('.funnel-panel__sortable').append(questionsHtml).css({
                        "height": "auto",
                        "margin": "0px",
                        'min-height': 'inherit'
                    });
                }
            }

            // load hidden fields
            if (funnel_info.hidden_fields != null && Object.keys(funnel_info.hidden_fields).length != 0) {
                let hiddenQuestionsHtml = '<strong class="hidden-layer-title"><span class="text-wrap">hidden fields</span></strong>';
                obj_data.question_icon = 'hidden-field';
                obj_data.question_type = 'Hidden Field';

                for (let i = 1; i <= Object.keys(funnel_info.hidden_fields).max(); i++) {
                    if (funnel_info.hidden_fields[i] !== undefined) {
                        let rel = funnel_info.hidden_fields[i]['options']['field-label'].trim();
                        if (rel) {
                            rel = FunnelsUtil.strip_tags(rel);
                        } else {
                            rel = "N/A";
                        }
                        obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder"><span class="sub-text">' + rel + '</span></span></div>';
                        hiddenQuestionsHtml += FunnelActions.getQuestionHtml(obj_data, null, i, funnel_info.hidden_fields[i]);
                    }
                }

                jQuery('.funnel-panel-hidden__sortable').html(hiddenQuestionsHtml).find('.hidden-field-active').removeClass('hidden-field-active');
            }

            FunnelsBuilder.question_tooltip();
        }

    },


    /**
     * Get question title and rel
     * @returns {[string, string]}
     */
    getQuestionRelTitle: function (question) {
        let rel = "";
        let question_title = "";
        if (question && question.options['show-question'] == 0
            || ($.isArray(question.options.question) && question.options['show-question'][FunnelsUtil.tabStep] == 0)) { // Question OFF
            rel = '<span class="off-text">Question OFF</span>';
            question_title = 'Question OFF';
        } else if (question && question.options['show-question'] == 1 && question.options.question == ""
            || ($.isArray(question.options.question) && question.options['show-question'][FunnelsUtil.tabStep] == 1 && question.options.question[FunnelsUtil.tabStep] == "")) { // Question Empty
            rel = '<span class="off-text">Question N/A</span>';
            question_title = 'Question N/A';
        } else {
            if ($.isArray(question.options.question)) {
                rel = question.options['question-title'][FunnelsUtil.tabStep];
            } else {
                if (question.options['question-title']) {
                    rel = question.options['question-title']
                } else if (question.options['call-to-action']) {
                    rel = FunnelsUtil.strip_tags(question.options['call-to-action']);
                } else if (question['question-type'] == 'contact') {
                    rel = question['question-type'];
                } else {
                    rel = FunnelsUtil.strip_tags(question.options['question']);
                }
            }
            question_title = rel;
        }

        return [rel, question_title];
    },

    /**
     * Get contact question description for 1/2/3 step forms
     * @param question
     * @returns {string}
     */
    getContactDesc: function (question) {
        let activesteptype = question['options']['activesteptype'];
        let question_desc = '<div class="fb-question-item__col fb-question-item__col_plr14">\n' +
            '\t<label class="fb-step-label">' + activesteptype + ' - STEP</label>\n' +
            '</div>\n';

        if (activesteptype > 1) {
            question_desc += '<div class="fb-question-item__col fb-question-item__col__steps">\n';
        }

        for (let j = 0; j < activesteptype; j++) {
            let mappedStep = question['options']['all-step-types'][activesteptype - 1]['steps'][j];
            let sequence = mappedStep['field-order'];
            let nameVariation = false;

            if (activesteptype > 1) {
                question_desc += '<div class="fb-step">\n' +
                    '<div class="fb-step__title">Step ' + (j + 1) + ':</div>\n' +
                    '<ul class="fb-step__list">\n';
            }

            for (let i = 0; i <= sequence.length; i++) {
                let step_value = '';
                if (sequence[i] == 0 && mappedStep['fields'][0]['fullname']['value'] == 1) {
                    step_value = 'Full Name';
                } else if (sequence[i] == 3 && mappedStep['fields'][3]['only-first-name']['value'] == 1) {
                    step_value = 'First Name';
                } else if ($.inArray(sequence[i], [1, 2]) !== -1 && nameVariation === false && mappedStep['fields'][1]['first-name']['value'] == 1) {
                    step_value = 'First + Last Name';
                    nameVariation = true;
                } else if ($.inArray(sequence[i], [4, 5]) !== -1) {
                    if (sequence[i] == 4 && mappedStep['fields'][4]['email']['value'] == 1) {
                        step_value = 'Email Address';
                    } else if (sequence[i] == 5 && mappedStep['fields'][5]['phone']['value'] == 1) {
                        step_value = 'Phone Number';
                    }
                }

                if (step_value != '') {
                    if (activesteptype == 1) {
                        question_desc += '<div class="fb-question-item__col">\n' +
                            '<div class="fb-step">\n' +
                            '<div class="fb-step__title"></div>\n' +
                            '<div class="fb-step__caption">' + step_value + '</div>\n' +
                            '</div>\n' +
                            '</div>\n';
                    } else {
                        question_desc += '<li class="fb-step__list__item">' + step_value + '</li>\n';
                    }
                }
            }

            if (activesteptype > 1) {
                question_desc += '</ul>\n' +
                    '</div>\n';
            }
        }

        if (activesteptype > 1) {
            question_desc += '</div>';
        }

        return question_desc;
    },


    getIndexOfArray: function (uniqueId) {

        if (uniqueId == 'primaryemail' || uniqueId == 'email' || uniqueId == 'Email Address') uniqueId = 'email';
        if (uniqueId == 'primaryphone' || uniqueId == 'phone') uniqueId = 'phone';

        return uniqueId
    },

    /**
     * Click events for grid actions
     */
    actionsClickEvents: function () {

        /**
         * Delete question click handler from modal
         */
        $('[data-id="delete-question"]').click(function () {
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            let deleteId = $('[data-id="deleteId"]').val();

            if (deleteId.search('hidden_') !== -1) {
                let deleteID = Number(deleteId.replace('hidden_ques', ''));
                delete funnel_info.hidden_fields[deleteID];
                if (Object.keys(funnel_info.hidden_fields).length == 0) {
                    funnel_info.hidden_fields = null;
                }
                FunnelsUtil.saveFunnelData(funnel_info);
                // delete question div from grid
                deleteId = deleteId.replace('hidden_', '');
                $('.funnel-panel-hidden__sortable').find('[data-id="' + deleteId + '"]').remove();
                FunnelActions.enableFunnelSaveBtn();
            } else if (funnel_info.sequence.length > 1) {
                let deleteID = Number(deleteId.replace('ques', ''));

                /**
                 * Start working DELETE CL Before Question Delete
                 */
                QuestionConditions.removeConditionOnDraggedQuestion(deleteID)
                /**
                 * End working DELETE CL Before Question Delete
                 */

                delete funnel_info.questions[deleteID];

                // delete question from sequence
                if (funnel_info.sequence.indexOf(deleteId.replace('ques', '')) !== -1) { // if number is as string
                    funnel_info.sequence.splice($.inArray(deleteId.replace('ques', ''), funnel_info.sequence), 1);
                } else if (funnel_info.sequence.indexOf(deleteID) !== -1) { // if number is as number
                    funnel_info.sequence.splice($.inArray(deleteID, funnel_info.sequence), 1);
                }

                FunnelsUtil.removeNewQuestionId(funnel_info, deleteID);
                FunnelsUtil.saveFunnelData(funnel_info);
                FunnelsUtil.handleSubmitButtonState(funnel_info);

                // delete question div from grid
                $('.funnel-panel__sortable').find('[data-id="' + deleteId + '"]').remove();
            }

            $('#confirmation-delete').modal('hide');
        });

        FunnelActions.saveFunnelInDB(false);

    },

    /**
     * Save question in database using ajax call
     */
    saveFunnelInDB: function (unbind = true) {

        // unbind from edit/add question screen
        if (unbind) {
            $('[data-id="main-submit"]').unbind('click');
        }

        $('[data-id="main-submit"]').click(function (e, data) {
            let hash = funnel_hash;
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            if (data && data.question_confirmation_close) {
                $('#question-confirmation-close').modal('hide');
            }

            if (FunnelsUtil.isSubmitButtonErrorState()) {
                displayAlert('danger', 'There are some errors on question, Please fix them before saving');
                return false;
            } else if ($('[data-id="ques_id"]').val() !== '' && !FBValidator.isUniqueVariableName(funnel_info)) {
                displayAlert('danger', 'You have added duplicate unique variable name.');
                return false;
            }
            let current_ques_id = $('[data-id="ques_id"]').val();
            let active_slide;
            if($('body').hasClass('overlay-active') && current_ques_id.trim() != '' && funnel_info.questions[current_ques_id]['question-type'] == 'contact'){
                active_slide = funnel_info.questions[current_ques_id]['active_slide'];
            }
            FunnelActions.deleteNotRequiredData(funnel_info);

            // menu to dropdown question conversion for more than 8 options
            if ($('body').hasClass('overlay-active') && current_ques_id.trim() != '' && funnel_info.questions[current_ques_id]['question-type'] == 'menu' && funnel_info.questions[current_ques_id]['options']['fields'].length > 8) {
                funnel_info.questions[current_ques_id]['question-type'] = 'dropdown';
                // add following json attributes in menu json for fully conversion from menu to dropdown
                funnel_info.questions[current_ques_id]['options']['enable-field-label'] = 1;
                funnel_info.questions[current_ques_id]['options']['field-label'] = 'select an option';
                funnel_info.questions[current_ques_id]['options']['randomize'] = 0;
                funnel_info.questions[current_ques_id]['options']['searchable'] = 0;
                FunnelsUtil.saveFunnelData(funnel_info);
            }

            if (FunnelActions.isAjaxRequestInProgress) {
                return false;
            }
            FunnelActions.isAjaxRequestInProgress = true;

            let post = {
                questions: JSON.stringify(funnel_info.questions),
                sequence: funnel_info.sequence.join("-"),
                hidden_fields: JSON.stringify(funnel_info.hidden_fields),
                conditional_logic: JSON.stringify(clList.getFunnelConditions())
            };
            $.ajax({
                type: "POST",
                url: "/lp/ajax/savefunnelquestions/" + hash,
                data: post,
                dataType: "json",
                success: function (ret) {
                    // disable save button
                    if (ret.message == 'success') {
                        displayAlert("success", "Changes have been saved.");
                        menuToDropdown.reset();
                        funnelConditions.refreshCL();
                        let isSaveFunnelChanges = false;
                        if (data && data.question_confirmation_close) {
                            InputControls.closeQuestionOverlay();
                            if (FunnelsUtil.haveNewQuestions(funnel_info)) {
                                FunnelActions.enableFunnelSaveBtn();
                            } else {
                                FunnelActions.disableFunnelSaveBtn();
                            }
                        } else {
                            if (FunnelsUtil.haveNewQuestions(funnel_info)) {
                                FunnelsUtil.resetNewQuestions(funnel_info);
                                isSaveFunnelChanges = true;
                            }
                            if (funnel_info.questions[current_ques_id] !== undefined) {
                                FunnelActions.setCurrentQuestion(funnel_info.questions[current_ques_id], current_ques_id);
                            }
                            FunnelsUtil.setSubmitButtonErrorState(false);
                            FunnelActions.disableFunnelSaveBtn();
                        }
                        if (isSaveFunnelChanges || FunnelsUtil.isRemovedExistingQuestion(funnel_info) || FunnelsUtil.isSortingChanged(funnel_info)) {
                            FunnelsUtil.setRemovedExistingQuestion(funnel_info, false);
                            FunnelsUtil.resetExistingSequence(funnel_info);
                            FunnelsBuilder.enableCTAFeaturedImagePreview(funnel_info, current_ques_id);
                            if(active_slide){
                                funnel_info.questions[current_ques_id]['active_slide']=active_slide;
                            }
                            FunnelsUtil.saveFunnelData(funnel_info);
                        }
                    }
                },
                complete: function (data) {
                    FunnelActions.isAjaxRequestInProgress = false;
                },
                cache: false,
                async: false
            });
        });
    },

    /**
     * Delete not required question's json attributes while saving in database
     * @param funnel_info
     * @param active_slide
     */
    deleteNotRequiredData: function (funnel_info, active_slide = true) {
        delete funnel_info.questions["funneltype"];
        $.each(Object.keys(funnel_info.questions), function (k, key) {
            FunnelActions.deleteQuestionNotRequiredData(funnel_info.questions[key], active_slide);
        });
    },

    deleteQuestionNotRequiredData: function (question, active_slide = true) {
        if (question) {
            if (active_slide && question['active_slide'] !== undefined) {
                delete question['active_slide'];
            }
            // remove cta and featured image nodes as not required to save in database
            try {
                delete question['cta-main-message-style'];
                delete question['cta-main-message'];
                delete question['cta-description-style'];
                delete question['cta-description'];
                delete question['show-cta-image'];
            } catch (e) {
                console.error(e);
            }
        }
    }

};

var QuestionConditions = {
    /**
     * Delete Sequence and create string sequence again
     * @param key
     */
    deleteSequenceFromCL: function (key){
        let seq_arr = cl_object.conditionSequence.toString().split("-");
        const index = Object.keys(seq_arr).find(keys => seq_arr[keys] === key)
        seq_arr.splice(index, 1);
        if(seq_arr.length>1){
            cl_object.conditionSequence = seq_arr.join("-");
        }else {
            cl_object.conditionSequence = seq_arr.toString();
        }
    },

    /**
     * collect all fields from contact Question
     * one two three step
     * @param activeSlides - Active Contact Step's data for all steps
     * @returns {*[]}
     */
    getContactActiveFieldsList: function (activeSlides){
        let fields=[];
        let i=0;
        $.each(activeSlides ,function (index,slide) {
            if(slide['field-order'].length>0){
                $.each(slide['field-order'],function (k,v) {
                    fields[i] = slide['fields'][v][Object.keys(slide['fields'][v])[0]]['data-field'];
                    i++;
                })
            }
            else {
                fields[i] = slide['fields'][slide['field-order']][Object.keys(slide['fields'][v])[0]]['data-field'];
                i++;
            }
        });

        return fields;
    },

    /**
     * This function will check is question associated with any Condition in Triggers (IF section)
     *
     * @param actionFieldId - Question's field id from condition object
     * @param quesFieldId - Question's data field ID
     * @param quesType
     * @returns {boolean}
     */
    hasTriggerAssociations: function (actionFieldId, quesFieldId, quesType){
        let isLinked = false;
        if(actionFieldId === quesFieldId || (Array.isArray(quesFieldId) && quesFieldId.includes(actionFieldId)) ){
            isLinked = true;
        }
        return isLinked;
    },

    /**
     * This function will check is question associated with any Condition in Actions (Then Section)
     *
     * @param condition - Condition
     * @param quesFieldId - Question's data field ID
     * @param quesType
     * @returns {boolean}
     */
    hasActionAssociations: function (condition, quesFieldId, quesType){
        let isLinked = false;
        let actions = condition.actions.action;
        $.each(actions, function (index, action) {
            let uids = [];
            if(!Array.isArray(quesFieldId)){
                uids = quesFieldId.split(",")
            } else {
                // Car Make/Model + Contact Question
                uids = quesFieldId;
            }

            let uid = action['conditionalFieldId'].filter(value => uids.includes(value));
            if(uid.length > 0){
                isLinked = true;
            }
        })

        return isLinked;
    },

    /**
     * This function will check is question associated with any Condition in Actions (Then Section)
     *
     * @param condition - Condition
     * @param quesFieldId - Question's data field ID
     * @param quesType
     * @returns {boolean}
     */
    hasOtherAssociations: function (condition, quesFieldId, quesType){
        let isLinked = false;
        let altActionThens = condition.alt_actions.action;
        if (altActionThens !== '{}' && altActionThens !== undefined && Object.keys(altActionThens).length > 0) {
            let hasAltCondition = false;
            if(Array.isArray(quesFieldId))   // Bundle Question Case
                hasAltCondition = quesFieldId.includes(altActionThens.at1.conditionalFieldId[0]);
            else
                hasAltCondition = quesFieldId === altActionThens.at1.conditionalFieldId[0];

            if (hasAltCondition) {
                isLinked = true;
            }
        }

        return isLinked;
    },
    /**
     * check word contains Alphabet Or Not
     * @param value
     * @returns {boolean}
     */
    checkAlphabet:function(value) {
        var letters = /^[a-zA-Z\s]*$/;
        if (value.match(letters)) {
            return true;
        } else {
            return false;
        }
    },


/**
     *
     * @param actionFieldId
     * @param unique_id
     * @param condition
     * @param quesType
     * @returns {string}
     */
    getConditionHtml: function (actionFieldId,unique_id,condition,quesType){
        let html='';
        let title= clListingMarkup.getQuestionListingTitle(actionFieldId);
        if(title) {
            let operator = questionTriggers.list[condition.terms['t1'].operator].title
            let input_value = condition.terms['t1'].value.toString()
            html = '<li class="item-wrap">\n' +
                '                      <div class="text-area">\n' +
                '                        <div class="text-wrap">\n' +
                '                          <span class="text"><span class="blue">IF</span> - “' + title + '” <span class="blue">"' + operator + '"</span> - “' + input_value + '”</span>\n' +
                '                        </div>\n' +
                '                      </div>\n' +
                '                    </li>'
        }
        return html;
    },

    renderAttachedConditions: function (deleteId) {
        let deleteID = Number(deleteId.replace('ques', ''));
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        let quesType = funnel_info.questions[deleteID]['question-type'];
        let dataFieldId;
        let html = '';

        if (quesType === "contact") {
            let activesteptype = funnel_info.questions[deleteID].options['activesteptype'] - 1;
            let allStepTypes = funnel_info.questions[deleteID].options['all-step-types'][activesteptype].steps;

            dataFieldId = QuestionConditions.getContactActiveFieldsList(allStepTypes);
        }
        else {
            dataFieldId = funnel_info.questions[deleteID].options['data-field']
        }

        $.each(cl_object.conditions, function (key, condition) {
            let clFieldIds;
            if (quesType === "contact") clFieldIds = condition.terms['t1'].meta.contactActionFieldID; // Actual field on whhich condition is implemented in contact question
            else clFieldIds = condition.terms['t1'].actionFieldId;

            let termsActionFieldId = condition.terms['t1'].actionFieldId;
            if(QuestionConditions.hasTriggerAssociations(clFieldIds, dataFieldId, quesType)){
                html += QuestionConditions.getConditionHtml(termsActionFieldId, dataFieldId, condition, quesType)
            }

           else if(QuestionConditions.hasActionAssociations(condition, dataFieldId, quesType)){
                html += QuestionConditions.getConditionHtml(termsActionFieldId, dataFieldId, condition, quesType)
            }

            else if(QuestionConditions.hasOtherAssociations(condition, dataFieldId, quesType)){
                html += QuestionConditions.getConditionHtml(termsActionFieldId, dataFieldId, condition, quesType)
            }
        });

        if (html) {
            $('[data-condition-list-area]').removeClass('d-none');
            $('[data-active-condition-list]').html(html);
            $('#confirmation-delete .modal-body p').html("Are you sure you want to delete the question? Deleting this will also delete the attached conditions:")
        }
        else {
            $('[data-condition-list-area]').addClass('d-none');
            $('#confirmation-delete .modal-body p').html("Are you sure, you want to delete the question?")
        }
    },
    /**
     * @param deleteID
     */
    removeConditionOnDraggedQuestion: function (deleteID){
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        let quesType = funnel_info.questions[deleteID]['question-type'];
        let dataFieldId = '';

        if (quesType === "contact") {
            let activesteptype = funnel_info.questions[deleteID].options['activesteptype'] - 1;
            let allStepTypes = funnel_info.questions[deleteID].options['all-step-types'][activesteptype].steps;

            dataFieldId = QuestionConditions.getContactActiveFieldsList(allStepTypes);
        }
        else {
            dataFieldId = funnel_info.questions[deleteID].options['data-field']
        }

        $.each(cl_object.conditions, function (key, condition) {
            let clFieldIds;
            if (quesType === "contact") clFieldIds = condition.terms['t1'].meta.contactActionFieldID; // Actual field on which condition is implemented in contact question
            else clFieldIds = condition.terms['t1'].actionFieldId;
            if(QuestionConditions.hasTriggerAssociations(clFieldIds, dataFieldId, quesType)){
                delete cl_object.conditions[key];
                QuestionConditions.deleteSequenceFromCL(key);
            }
            else if(QuestionConditions.hasActionAssociations(condition, dataFieldId, quesType)){
                delete cl_object.conditions[key];
                QuestionConditions.deleteSequenceFromCL(key);
            }
            else if(QuestionConditions.hasOtherAssociations(condition, dataFieldId, quesType)){
                delete cl_object.conditions[key];
                QuestionConditions.deleteSequenceFromCL(key);
            }
        });
        funnelConditions.setQuestionCLActive();
    }
};
