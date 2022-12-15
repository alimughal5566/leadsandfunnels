var FunnelsBuilder = {
    bindOpenClose: false,
    validHiddenField: false,
    validHiddenParam: true,
    isHiddenNew: false,

    /**
     * Funnel builder events
     */
    funnelBuilderEvents: function () {

        var amIclosing = false;
        var obj_data= {
            question_type:'',
            question_dsc:'',
            question_icon:'',
            question_class:'',
            question_transition:0,
            data_list:'',
            data_icon:'',
            dropable_only:''
        };

        $('#question-select-group').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.standard-question-option-parent-group-wrap'),
        }).on('change',function () {
            obj_data.question_transition = 0;
            if($(this).val() == 1) {
                $('.question-transition').hide();
                $('.question-standard').show();

                hbar.renderTemplate('questionlist-standard.hbs', "questionsList", "questions.json");

                // binding accordion events for drop down
                lpUtilities.initCustomAccordion();
                lpUtilities.scrollmenu();

                /** moved drag and drop related functions in leftMenuDragDropEvents */
                FunnelsBuilder.leftMenuDragDropEvents();

                let hash = window.location.hash;
                hash = hash.replace('#transition', '');
                hash = (hash.indexOf("standard-question") !== -1) ? hash : hash + "#standard-question";
                history.replaceState(null,null, window.location.pathname+ hash);
            }else if($(this).val() ==  2) {
                if ($('.question-option-list > li').length > 0) {
                    $('.question-global .placeholder').hide();
                }

                hbar.renderTemplate('questionlist-transition.hbs', "questionsList", "transition.json");

                $('.question-standard').hide();
                $('.question-transition').show();

                /** moved drag and drop related functions in leftMenuDragDropEvents */
                FunnelsBuilder.leftMenuDragDropEvents();

                let hash = window.location.hash;
                hash = hash.replace('#standard-question', '');
                hash = (hash.indexOf("transition") !== -1) ? hash : hash + "#transition";
                history.replaceState(null, null, window.location.pathname + hash);
                obj_data.question_transition = 1
            }
        }).on('select2:openning', function() {
            jQuery('.standard-question-option-parent-group-wrap .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.standard-question-option-parent-group-wrap .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.standard-question-option-parent-group-wrap .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.standard-question-option-parent-group-wrap .select2-dropdown').hide();
            jQuery('.standard-question-option-parent-group-wrap .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.standard-question-option-parent-group-wrap .select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                jQuery('.standard-question-option-parent-group-wrap .select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                    var getindex = jQuery('#question-select-group').find(':selected').index();
                    var defaultHeight = 36;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.standard-question-option-parent-group-wrap .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#question-select-group').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.standard-question-option-parent-group-wrap .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.standard-question-option-parent-group-wrap .select2-selection__rendered').show();
            jQuery('.standard-question-option-parent-group-wrap .select2-results__options').css('pointer-events', 'none');
        });

        $('.select2js__transition-type').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select2js__transition-type-parent'),
        }).on('select2:openning', function() {
            jQuery('.select2js__transition-type-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.select2js__transition-type-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.select2js__transition-type-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2js__transition-type-parent .select2-dropdown').hide();
            jQuery('.select2js__transition-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.select2js__transition-type-parent .select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                jQuery('.select2js__transition-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                    var getindex = jQuery('.select2js__transition-type').find(':selected').index();
                    var defaultHeight = 36;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2js__transition-type-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select2js__transition-type').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.select2js__transition-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.select2js__transition-type-parent .select2-selection__rendered').show();
            jQuery('.select2js__transition-type-parent .select2-results__options').css('pointer-events', 'none');
        });

        $('.title-tooltip').tooltipster({
            contentAsHTML:true
        });

        $('.text-tooltip').tooltipster({
            contentAsHTML: true
        });

        jQuery('#hidden-field-modal').on('shown.bs.modal', function (e) {
            jQuery('[data-field-name="hidden.field-label"]').focus();


            // remove the space form input field
            jQuery('.form-control').val().trim();
            jQuery('.form-control').on('keydown', function(e) {
                //remove this functionality because mention in FBS-1592 bug card
                // if (e.which === 32 &&  e.target.selectionStart === 0) {
                //     return false;
                // }
            });
        });

        jQuery('#hidden-field-modal').on('show.bs.modal', function (e) {
            jQuery('[data-hidden-save-btn]').prop("disabled", true);
            jQuery('.form-control').removeClass("error");
        });

        jQuery(document).on('click' ,'#hidden-field-modal .button-cancel', function(e){
            // reset the value once modal is close
            jQuery('.form-control').val('');
            jQuery('[data-hidden-field-label-error]').hide();
            jQuery('[data-field-name="hidden.enable-dynamic-population"]').prop("checked", false);
            jQuery('.hidden-parameter-slide').slideUp();
            jQuery('[data-hidden-save-btn]').prop("disabled", true);
        });

        jQuery('#hidden-field-modal').on('hidden.bs.modal', function (e) {
            jQuery('body').removeClass('hidden-field-modal');
            FunnelsBuilder.item_length();
        });

        jQuery('#icon-color-modal').on('shown.bs.modal', function (event) {
            jQuery('.question-icon-text').each(function () {
                if(jQuery(this).outerWidth() > 268) {
                    jQuery('.title-tooltip').tooltipster('enable');
                }
                else {
                    jQuery('.title-tooltip').tooltipster('disable')
                }
            });
        });

        jQuery('#icon-color-modal').on('hidden.bs.modal', function (event) {
            jQuery('.question-text').removeClass('lastQuestion-colorText');
        });

        $(document).on('click' ,'.dropable-slide-opener', function(e){
            e.preventDefault();
            var _self = jQuery(this);
            _self.toggleClass('active');
            _self.parents('.question-item').parent('.fb-question-item').find('.innerDropable-element').first().slideToggle();
        });

        // sort dragged questions by holding mouse
        $(document).on('mouseenter', '.single-question-slide', function(event) {
            setTimeout(function(){
                var handle = $( ".funnel-panel__sortable" ).sortable( "option", "handle" );
                $( ".funnel-panel__sortable" ).sortable( "option", "handle", ".single-question-slide" );
                $('.single-question-slide').css('cursor', 'move');
            }, 1000);
        });

        $(document).on('mouseleave', '.single-question-slide', function(event) {
            var handle = $( ".funnel-panel__sortable" ).sortable( "option", "handle" );
            $( ".funnel-panel__sortable" ).sortable( "option", "handle", ".lp-control__link_cursor_move" );
            $('.single-question-slide').css('cursor', 'default');
        });

        // $('.icon-color-opener').click(function () {
        //     var name = ".icon-color-picker-parent";
        //     lpUtilities.custom_color_picker.call(this,name);
        // });

        $('.icon-color-opener').ColorPicker({
            opacity: true,
            onChange: function (hsb, hex, rgb, rgba) {
                var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
                $('.icon-color-opener').find('.last-selected__box').css('backgroundColor', rgba_fn);
                $('.icon-color-opener').find('.last-selected__code').text('#'+hex);
                $('.lastQuestion-colorText').css('color', rgba_fn).closest('.fb-question-item').find(' >.innerDropable-element').attr('data-color', rgba_fn);
            },
        });

    },

    item_length: function () {
      setTimeout(function () {
        jQuery('.funnel-panel__sortable').each(function(){
          var items = jQuery(this).find('.fb-question-item').length;

          if(items < 2) {
            jQuery(this).addClass('only-child');
          } else {
            jQuery(this).removeClass('only-child');
          }
        });

        jQuery('.funnel-panel-hidden__sortable').each(function(){
          var items = jQuery(this).find('.hidden-field').length;

          if(items > 1) {
            jQuery(this).removeClass('only-child');
          } else {
            jQuery(this).addClass('only-child');
          }
        });
      }, 100);
    },

    /**
     * left menu drag drop events
     */
    leftMenuDragDropEvents: function () {

        function initdragAccordion(el) {
            jQuery(el).each(function (){
                var _self = jQuery(this);
                var getLength = _self.children().length;
                if(getLength > 0) {
                    _self.parent('.fb-question-item').find('.dropable-slide-opener').addClass('slide-opener');
                }
                else {
                    _self.parent('.fb-question-item').find('.dropable-slide-opener').removeClass('slide-opener');
                }
            });
        }

        function initColorChanger(el) {
            jQuery(el).each(function(){
                var getCurrColor = jQuery(this).attr('data-color') || "#b6c7cd";
                jQuery(this).find('.question-text:not(.group)').css('color', getCurrColor);
            });
        }

        let getQuestionDescription = function(draggedQuestion, section) {
            let ret = '';
            if (draggedQuestion == 'hidden') {
                ret = ' ';
            } else {
                let questions_type_description = hbar.getJson(draggedQuestion + ".json")['options'];
                if (questions_type_description) {
                    ret = (questions_type_description.question) ? questions_type_description.question : (draggedQuestion == 'contact' ? 'contact' : questions_type_description.rel);
                }
            }

            return ret;
        };

        var obj_data= {
            question_type:'',
            question_dsc:'',
            question_icon:'',
            question_class:'',
            question_transition:0,
            data_list:'',
            data_icon:'',
            dropable_only:1 // make it equal to 1 for fixing deleting items on sorting after page refresh
        };

        var is_draging = false;

        $(".question-standard").on('mouseover', function () {
            if (is_draging){
                jQuery('body').addClass('drag-enable');
            }
        });

        $(".main-content").on('mouseover', function () {
            if (is_draging){
                jQuery('body').removeClass('drag-enable');
            }
        });

        /*
        * QUESTION ITEM - DRAGGING
        **/
        $(".question-list-item").draggable({
            revert: 'invalid',
            cursor: "move",
            helper: "clone",
            connectToSortable: ".funnel-panel__sortable",
            tolerance: "pointer",
            appendTo: 'body',
            cursorAt: {top: 10, left: 10},
            start: function (event, ui) {
                is_draging = true;
                $('.question-list-item, .question-list-item-hidden').addClass('disabled');
                obj_data.data_icon = '';
                obj_data.question_type = $(this).text().trim();
                obj_data.question_icon = $(this).data('icon');
                obj_data.question_class = $(this).data('class');
                if ($('.funnel-panel__sortable .fb-question-item').length == 2) {
                    $('.funnel-panel__sortable').removeClass("placeholder");
                    FunnelsBuilder.item_length();
                }
            },
            stop: function (event, ui) {
                is_draging = false;
                jQuery('body').removeClass('drag-enable');
                $('.question-list-item, .question-list-item-hidden').removeClass('disabled');
                if ($(this).hasClass('hidden-field-item')) {
                    $('.funnel-body-scroll-group').addClass('hidden-label-active');
                }
                FunnelsBuilder.item_length();
            }
        });

        $(".question-list-item[disabled]").draggable({
            disabled: true
        });

        $(".dropable-funnel-option").droppable({
            accept: ".question-list-item",
            drop: function (event, ui) {
                console.log("here we drop the question item");
                obj_data.dropable_only = 1;
            }
        });

        /*
        * QUESTION CONTAINER - SORTABLE AREA
        **/
        $('.funnel-panel__sortable').sortable({
            connectWith: '.innerDropable-element',
            placeholder: "fb-question-item__highlight",
            items: ".fb-question-item",
            handle: ".lp-control__link_cursor_move",
            tolerance: "pointer",
            update: function (event, ui) {
                initColorChanger('.innerDropable-element');
            },
            start: function (event, ui) {
                var $item = ui.item;
                if (ui.item.hasClass('transition-item')) {
                    $('.fb-question-item__highlight').text('Drag & Drop Your Transition Here');
                } else {
                    $('.fb-question-item__highlight').text('Drag & Drop Your Question Here');
                }
            },
            stop: function (event, ui) {
                let questionTitle = (obj_data.question_type == 'zipcode')?"Zip Code": obj_data.question_type;
                if (obj_data.dropable_only == 1) {
                    let draggedQuestion = ui.item.attr('class').split(' ')[0];

                    // Vehicle Make/Model Case
                    if (ui.item.hasClass('bundle-item')) {
                        let makeModelDescription = getQuestionDescription(ui.item.attr('data-question-type'), ui.item.attr('data-question-section'));

                        let questionDescription = makeModelDescription[0];

                        obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder"><span class="sub-text">' + questionDescription + '</span></span></div>';
                        $('.question-icon-text').text(questionDescription);
                        $('.question-icon-text').tooltipster('content', questionDescription);
                    }
                    else {
                        // apply place holder on dragged event only
                        if (draggedQuestion.indexOf('fb-question-item') === -1) {
                            let questionDescription = getQuestionDescription(ui.item.attr('data-question-type'), ui.item.attr('data-question-section'));
                            if (questionDescription) {
                                obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder"><span class="sub-text">' + questionDescription + '</span></span></div>';
                                $('.question-icon-text').text(questionDescription);
                                $('.question-icon-text').tooltipster('content', questionDescription);
                            }
                        } else {
                            FunnelActions.lpSortQuestions();
                        }
                    }

                    if (ui.item.hasClass('group-item')) {
                        $('#icon-color-modal').modal('show');
                        $('#icon-color-modal').on('show.bs.modal', function (event) {
                            $('.icon-color-opener').find('.last-selected__box').css('backgroundColor', '#b6c7cd');
                            $('.icon-color-opener').find('.last-selected__code').text('#b6c7cd');
                        });
                    }

                    if (!ui.item.hasClass('ui-draggable')) return;

                    if (obj_data.question_transition == 0) {
                        // check if contact question exists for new funnel
                        let contact_question='';
                        if (jQuery('.funnel-panel__sortable').find('.slide').length == 0) {
                            if ($('[data-id="ques1"]').hasClass('contact')) {
                                contact_question = $('[data-id="ques1"]');
                                $('[data-id="ques1"]').remove();
                            }
                        }

                        if (ui.item.hasClass('contact-item')) {
                            obj_data.question_dsc = FunnelActions.contact_desc;
                        } else if (ui.item.hasClass('zip-code-item')) {
                            obj_data.question_dsc = FunnelActions.zipcode_desc;
                        }
                        ui.item.replaceWith(FunnelActions.getQuestionHtml(obj_data, ui));

                        // save question in local storage and update sorting
                        let qKey = FunnelsUtil.addQuestion(ui.item);
                        $('[data-id="new-ques"]').attr('data-id', "ques" + qKey);

                        // set contact question inside funnel-panel__sortable
                        if (contact_question != '') {
                            $('.funnel-panel__sortable').append(contact_question);
                        }

                        if (ui.item.data('question-type') != "hidden") {
                            FunnelActions.lpSortQuestions();
                        }

                        // For Hidden Question
                        if (ui.item.hasClass('hidden-field-item') && ui.item.data('question-type') === "hidden") {
                            FunnelsBuilder.isHiddenNew = true
                            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
                            let currentHiddenQuestion = funnel_info.hidden_fields[qKey];
                            FunnelsBuilder._setValuesToHiddenModal(currentHiddenQuestion);
                            FunnelsBuilder.validHiddenField = false;
                            $('body').addClass('hidden-field-modal');
                            $('#hidden-field-modal').modal('show');
                            $('[data-id="ques_id"]').val(qKey);
                            if (!FunnelsBuilder.bindOpenClose) {
                                FunnelsBuilder.bindOpenClose = true;
                                InputControls.openclose();
                            }
                        }
                        // For Rest of all other questions except Bundle Question
                        else if(ui.item.data('question-type') !== "bundle_question"){
                            if (ui.item.data('question-type') == 'vehicle')
                            {
                                FunnelsUtil.tabStep = 0;
                            }
                            let currentQuestion = FunnelsBuilder.setQuestionOptions(null, true);
                            // load edit question modal
                            $('body').addClass('overlay-active');
                            hbar.renderTemplate(ui.item.data('question-type')+'.hbs', "questionEditor", currentQuestion);
                        }
                    }
                    else {
                        ui.item.replaceWith(
                            '<div class="fb-question-item fb-question-item_transition">\n' +
                            '   <div class="question-item">\n' +
                            '      <div class="fb-question-item__detail">\n' +
                            '         <div class="fb-question-item__col">\n' +
                            '            <i class="bar"></i><div class="question-text ' + obj_data.question_icon + '"><span class="sub-text">' + questionTitle + '</span></div>\n' +
                            '         </div>\n' +
                            '         <div class="fb-question-item__col fb-question-item__col_control">\n' +
                            '            <a href="#" class="hover-hide">\n' +
                            '               <i class="fbi fbi_dots">\n' +
                            '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                            '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                            '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                            '               </i>\n' +
                            '            </a>\n' +
                            '            <ul class="lp-control">\n' +
                            '                <li class="lp-control__item lp-control__item_edit reply">\n' +
                            '                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                            '                       <i class="ico-edit"></i>\n' +
                            '                    </a>\n' +
                            '                </li>\n' +
                            '                <li class="lp-control__item edit">\n' +
                            '                    <a title="Duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                            '                       <i class="ico-copy"></i>\n' +
                            '                    </a>\n' +
                            '                </li>\n' +
                            '                <li class="lp-control__item drag">\n' +
                            '                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">\n' +
                            '                       <i class="ico-dragging"></i>\n' +
                            '                    </a>\n' +
                            '                </li>\n' +
                            '                <li class="lp-control__item delete">\n' +
                            '                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#delete-tranistion" data-toggle="modal">\n' +
                            '                       <i class="ico-cross"></i>\n' +
                            '                    </a>\n' +
                            '                </li>\n' +
                            '            </ul>\n' +
                            '         </div>\n' +
                            '         <div class="fb-question-item__col fb-question-item__col_lock">\n' +
                            '              <a href="#">\n' +
                            '                 <i class="lp-icon-lock ico-lock"></i>\n' +
                            '                 <i class="ico-back"></i>\n' +
                            '                 <i class="ico-globe"></i>\n' +
                            '              </a>\n' +
                            '         </div>\n' +
                            '   </div>\n' +
                            '   </div>\n' +
                            '</div>');
                    }

                    var hiddenClone = jQuery('.hidden-field-active').clone();
                    jQuery('.funnel-panel-hidden__sortable').append(hiddenClone).find('.hidden-field-active').removeClass('hidden-field-active');
                    jQuery('.hidden-field-active').remove();
                    if (jQuery('.funnel-panel__sortable > div').length > 1) {
                        $('.funnel-panel__sortable').show().css({'height': 'auto', 'margin': '0'});
                        $('.funnel-panel__placeholder').hide();
                    } else {
                        $('.funnel-panel__placeholder').show();
                    }

                    $('.fb-tooltip_control').tooltipster({
                        delay: 0,
                        contentAsHTML: true,
                    });

                    $('.text-tooltip').tooltipster({
                        contentAsHTML: true
                    });

                    $('.text-tooltip').tooltipster('disable');
                    $('.innerDropable-element .innerDropable-element .text-tooltip').tooltipster('enable');

                    $('.innerDropable-element').sortable({
                        connectWith: '.funnel-panel__sortable',
                        placeholder: "inner-fb-question-item__highlight",
                        handle: ".lp-control__link_cursor_move",
                        tolerance: 'pointer',
                        start: function (event, ui) {
                            //$('.inner-fb-question-item__highlight').text('Drag & Drop Your Question Into Question Group');
                            $('.inner-fb-question-item__highlight').text('Drag & Drop Your Question Here');
                        },
                        stop: function (event, ui) {
                            initdragAccordion('.innerDropable-element');
                        }
                    });

                    initdragAccordion('.innerDropable-element');
                } else {
                    ui.item.replaceWith('');
                }
                initColorChanger('.innerDropable-element');
                /*getFunnelQuestionsCL(2);
                console.log('******************Start question_select******************');
                console.log(question_select);
                console.log('******************END question_select******************');
                $('.select-question').select2().trigger('change');*/
            }
        });
    },

    /* question text length funcation */

    /*question_title_events: function () {
        var col_left =  $('.fb-question-item__col:first-child').width();
        var title_width =  $('.sub-text-holder').width();
        var total_width =  title_width - 30;
        jQuery('.sub-text-holder .sub-text').css({"max-width": total_width});
    },*/

    /* question tooltip funcation */

    question_tooltip: function () {
        $('.fb-tooltip_control').tooltipster({
            delay: 0,
            contentAsHTML:true,
        });

        $('.text-tooltip').tooltipster({
            contentAsHTML:true
        });
    },


    /**
     * Modifies Current Question's options on run time like as cta button icon, question id and Is_key
     * it will work when drag and drop any question and on edit question
     * @param qKey
     * @returns {*}
     */
    setQuestionOptions: function(qKey=null, isQuestionEditorOverlay = false){
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        let questionKey = qKey;
        qKey = qKey===null ? FunnelsUtil._getQuestionKey() -1 : qKey;
        let currentQuestion = funnel_info.questions[qKey];

        // clear question value on edit question
        if (qKey !== null) {
            funnel_info.question_value = "";
        }

        // enable cta message and featured image rendering in right preview for first question only
        FunnelsBuilder.enableCTAFeaturedImagePreview(funnel_info, qKey);

        // save above cta message and question_value settings in local storage
        if(isQuestionEditorOverlay) {
            FunnelActions.setCurrentQuestion(funnel_info.questions[qKey], qKey);
        }
        FunnelsUtil.saveFunnelData(funnel_info);
        FunnelsUtil.handleSubmitButtonState(funnel_info, qKey);

        // set button icon
        var obj_fontawsome = {
            "plus": 'Plus',
            "arrow-thick-right": 'Forward',
            "forward": 'Replay',
            "long-arrow": 'Next',
            "double-arrow": 'Refer',
            "check": 'Check',
            "dotted-check": 'Mark',
            "lock": 'Lock',
            "search": 'Search',
            "thumbs": 'Thumb',
            "start-rate": 'Star',
            "heart": 'Heart',
            "location": 'Location',
            "client": 'Client',
            "email": 'Email',
            "file-upload": 'Upload',
        };

        if (currentQuestion['question-type'] == 'contact') {
            let active_step_type = currentQuestion['options']['activesteptype'] - 1;
            let button_icon = currentQuestion['options']['all-step-types'][active_step_type]['steps'][0]['cta-button-settings']['button-icon'];
            currentQuestion['options']['all-step-types'][active_step_type]['steps'][0]['button-icon-name'] = obj_fontawsome[button_icon];
            currentQuestion['step-form'] =  currentQuestion['options']['all-step-types'][active_step_type];
        }
        else if (currentQuestion['question-type'] == 'vehicle') {
              currentQuestion = FunnelsUtil.vehicleOptionSetByIndex(currentQuestion['options'],currentQuestion);
            let button_icon = currentQuestion['options']['cta-button-settings']['button-icon'];
            currentQuestion['options']['button-icon-name'] = obj_fontawsome[button_icon];
        }
        else if (currentQuestion['question-type'] != 'hidden') {
            if(currentQuestion.hasOwnProperty('options')) {
                let button_icon = currentQuestion['options']['cta-button-settings']['button-icon'];
                currentQuestion['options']['button-icon-name'] = obj_fontawsome[button_icon];
            }
        }

        currentQuestion['ques_id'] = qKey;
        currentQuestion['ls_key'] = FunnelsUtil.ls_key;
        currentQuestion['header_funnel_url'] = $('[data-id="header_funnel_url"]').attr('href');
        currentQuestion['bundle_question_step'] = FunnelsUtil.tabStep;
        window.question_type  = currentQuestion['question-type'];
        window.current_question_id  = qKey;

        // enable CTA icon active class
        if ($('[data-enable-cta-class]').hasClass('active')) {
            currentQuestion['enable-cta-class'] = 1;
        }
        else {
            currentQuestion['enable-cta-class'] = 0;
        }
        // enable Featured image active class
        if (!$('[data-enable-featured-class]').hasClass('inactive')) {
            currentQuestion['enable-featured-image'] = 1;
        }
        else {
            currentQuestion['enable-featured-image'] = 0;
        }
        //To Make CTA Icon only available for First Question
        if(funnel_info.sequence[0] == qKey) currentQuestion['show_home_cta_icon'] = 1
        else currentQuestion['show_home_cta_icon'] = 0

        // set zoom settings
        let zoom = FunnelsUtil._getZoomSettings();
        if (zoom && zoom['lock'] == 1) {
            currentQuestion['zoom'] = 1;
            currentQuestion['zoom_value'] = Number(zoom['value'])/100;
        }

        // quick access links in header section
        currentQuestion['quick_access_links'] = FunnelsBuilder.getQuickAccessLinks(funnel_info);
        currentQuestion['funnel-name'] = $(".funnel-name").attr('data-old-name');
        currentQuestion['funnel-total-questions'] = funnel_info.sequence.length;

        // disable funnel builder page tooltip temporarily to fix showing tooltip in add/edit question screen right side preview
        // setTimeout(function () {
        //     $('.fb-tooltip_control').tooltipster('disable');
        // }, 200);

        return currentQuestion;
    },

    /**
     * Enable disable CTA in right preview
     * @param funnel_info
     * @param qKey
     */
    enableCTAFeaturedImagePreview: function(funnel_info, qKey) {
        if(funnel_info.sequence[0] == qKey && $('[data-enable-cta-class]').hasClass('active')) {
            funnel_info.questions[qKey]['cta-main-message-style'] = $('[data-cta-main-message]').attr('style');
            funnel_info.questions[qKey]['cta-main-message'] = $('[data-cta-main-message]').val().trim();
            funnel_info.questions[qKey]['cta-description-style'] = $('[data-cta-description]').attr('style');
            funnel_info.questions[qKey]['cta-description'] = $('[data-cta-description]').val().trim();
        } else {
            // clear cta and featured nodes which are not required
            FunnelActions.deleteNotRequiredData(funnel_info, false);
            funnel_info.questions[qKey]['cta-main-message'] = '';
        }
        if(funnel_info.sequence[0] == qKey) {
            funnel_info.questions[qKey]['show-cta-image'] = !$('[data-enable-featured-class]').hasClass('inactive') ? $('#selected_featured_image').val() : '';
        } else {
            funnel_info.questions[qKey]['show-cta-image'] = '';
        }
    },

    /**
     * enable cta preview and featured image to save in local storage
     */
    enableCTAFeaturedImagePreviewTrigger: function() {
        if ($('body').hasClass('overlay-active')) {
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            FunnelsBuilder.enableCTAFeaturedImagePreview(funnel_info, $('[data-id="ques_id"]').val());
            FunnelsUtil.saveFunnelData(funnel_info);

            // refresh right preview in edit screen
            SaveChangesPreview.iframePostMessage();
        }
    },

    /**
     * Get quick access links
     * @param funnel_info
     * @returns {[]}
     */
    getQuickAccessLinks: function(funnel_info) {
        let questions_json = hbar.getJson("questions.json");
        let popular_icon = questions_json['popular']['questions'];
        let more_icon = questions_json['more-questions']['questions'];
        let quick_access_links = [];

        for (let i = 0; i < funnel_info.sequence.length; i++) {
            let question = funnel_info.questions[funnel_info.sequence[i]];
            question['options'] = FunnelsUtil.getOptionsValue(question['options']);
            let question_rel_title = FunnelsBuilder.getQuestionTitle(question);
            // textarea handling as text field to pick quick access icon
            let question_type;
            if (question['question-type'] == 'textarea') {
                question_type = 'text';
            } else {
                question_type = question['question-type'];
            }

            console.log(popular_icon, more_icon);
            console.log(question_type, "=>", popular_icon[question_type]);
            console.log("");
            quick_access_links.push({
                id: i+1,
                question_id: funnel_info.sequence[i],
                icon: popular_icon[question_type] !== undefined ? popular_icon[question_type]['quick-access-icon'] : more_icon[question_type]['quick-access-icon'],
                question_type: popular_icon[question_type] !== undefined ? popular_icon[question_type]['label'] : more_icon[question_type]['label'],
                question_title: question_rel_title
            });
        }

        return quick_access_links;
    },

    getQuestionTitle: function(question) {
        let question_rel_title = FunnelActions.getQuestionRelTitle(question);
        if (question['question-type'] == 'contact') {
            let contact_description = FunnelActions.getContactDesc(question);
            question_rel_title[1] = contact_description;
        }
        else if (question_rel_title[1] == 'Question OFF' || question_rel_title[1] == 'Question N/A') {
            question_rel_title[1] = question_rel_title[0];
        }

        return question_rel_title[1];
    },

    _setValuesToHiddenModal: function(opts){
        $(".hidden-field-modal__field-label").val(opts['options']['field-label']);
        $(".hidden-field-modal__parameter").val(opts['options']['parameter']);
        $(".hidden-field-modal__value").val(opts['options']['default-value']);
        $("#hidden-field-option").prop( "checked", opts['options']['enable-dynamic-population'] == 1);
        if (opts['options']['enable-dynamic-population'] == 1) {
            $('#hidden-field-modal .hidden-parameter-slide').slideDown();
        }else {
            $('#hidden-field-modal .hidden-parameter-slide').slideUp();
        }
    },

    htmlDecode: function(s) {
        return $('<div>').html(s).text();
    },

    // Edit Funnel Homepage CTA Message popup load data
    ctaLoadDataClick: function(unbind=true) {

        // unbind from edit/add question screen
        if (unbind) {
            $('[data-edit-cta-popup]').unbind('click');
            $('[data-edit-featured-image]').unbind('click');
        }

        // todo sync togle button with save button
        // $( "[data-toggle-cta]" ).change(function() {
        //     $('[data-save-cta-btn]').attr('disabled',false);
        // });

        $('[data-edit-cta-popup]').click(function () {
            if ($('#selected_cta_toggle').val() == 1) {
                $('[data-toggle-cta]').bootstrapToggle('on');
            } else {
                $('[data-toggle-cta]').bootstrapToggle('off');
            }
            let cta_main_msg = FunnelsBuilder.htmlDecode($('#selected_cta_main_message').val());
            let cta_main_des = FunnelsBuilder.htmlDecode($('#selected_cta_description').val());
            // set main message settings
            $('[data-cta-main-message]').val(cta_main_msg);
            let selected_font_main_message = $('#selected_font_main_message').val();
            $('#homepage-cta-message-pop').find('#msgfonttype').val(selected_font_main_message).change();
            let selected_font_size_main_message= $('#selected_font_size_main_message').val();
            $('#homepage-cta-message-pop').find('#msgfontsize').val(selected_font_size_main_message).change();
            let selected_line_spacing_main_message = $('#selected_line_spacing_main_message').val();
            $('#homepage-cta-message-pop').find('[data-main-message-line-spacing]').val(selected_line_spacing_main_message).change();
            $('#homepage-cta-message-pop').find('#mlineheight').val(selected_line_spacing_main_message);
            let selected_color_main_message = $('#selected_color_main_message').val();
            $('.colorSelector-mmessagecp').css('backgroundColor', selected_color_main_message);
            $('#homepage-cta-message-pop').find('.select2__parent-font-type .select2-selection__rendered').css('font-family',selected_font_main_message);
            let style_main = 'font-family:' + selected_font_main_message + ';font-size:' + selected_font_size_main_message + ';line-height:' + selected_line_spacing_main_message + ';color:' + selected_color_main_message;
            $('[data-cta-main-message]').attr('style', style_main);
            // set description settings
            $('[data-cta-description]').val(cta_main_des);
            let selected_font_description = $('#selected_font_description').val();
            $('#homepage-cta-message-pop').find('#dfonttype').val(selected_font_description).change();
            let selected_font_size_description = $('#selected_font_size_description').val();
            $('#homepage-cta-message-pop').find('#dfontsize').val(selected_font_size_description).change();
            let selected_line_spacing_description = $('#selected_line_spacing_description').val()
            $('#homepage-cta-message-pop').find('[data-description-line-spacing]').val(selected_line_spacing_description).change();
            $('#homepage-cta-message-pop').find('#dlineheight').val(selected_line_spacing_description);
            let selected_color_description = $('#selected_color_description').val();
            $('.colorSelector-mdescp').css('backgroundColor', selected_color_description);
            $('#homepage-cta-message-pop').find('.select2__parent-dfont-type .select2-selection__rendered').css('font-family',selected_font_description);
            let style_desc = 'font-family:' + selected_font_description + ';font-size:' + selected_font_size_description + ';line-height:' + selected_line_spacing_description + ';color:' + selected_color_description;
            $('[data-cta-description]').attr('style', style_desc);
            setTimeout(function () {
                autosize.update($('textarea'));
                if ($('#selected_featured_image_toggle').val() == 1) {
                    $('[data-cta-main-message]').removeClass('homepage_off');
                    $('[data-cta-description]').removeClass('homepage_off');
                } else {
                    $('[data-cta-main-message]').addClass('homepage_off');
                    $('[data-cta-description]').addClass('homepage_off');
                }
                ajaxCtaHandler.loadFormSavedValues();
            }, 300);
        });

        $('[data-edit-featured-image]').click(function () {
            if ($('#selected_featured_image_toggle').val() == 1) {
                $('[data-toggle-feature-image]').bootstrapToggle('on');
                $("#imagestatus").val("active");
            } else {
                $('[data-toggle-feature-image]').bootstrapToggle('off');
                $("#imagestatus").val("inactive");
            }
            let selected_featured_image = $('#selected_featured_image').val();
            setupFeaturedImageDropZone("feature-image", true);
            if (selected_featured_image != '') {
                $('#delete_image').val("n").trigger("change");
                $(".btn-image__del").show();
            } else {
                $(".btn-image__del").click();
            }
        });


    },

    /**
     * remove hidden field if not saved at first time
     */
    removeHiddenFieldOnModalClose: function (){
        $('#hidden-field-modal .button-cancel').click(function (event){
            $('[data-hidden-parameter-error]').hide();
            if (FunnelsBuilder.isHiddenNew){
                let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
                let deleteId = $('[data-id="ques_id"]').val();
                delete funnel_info.hidden_fields[deleteId];
                if (Object.keys(funnel_info.hidden_fields).length == 0) {
                    funnel_info.hidden_fields = {};
                }
                FunnelsUtil.saveFunnelData(funnel_info);
                // delete question div from grid
                $('.funnel-panel-hidden__sortable').find('[data-id="ques'+deleteId+'"]').remove();
            }
        })
    },

    /**
     * Entry point for funnel builder
     */
    init: function () {
        FunnelsBuilder.removeHiddenFieldOnModalClose();

        FunnelsBuilder.leftMenuDragDropEvents();

        FunnelActions.actionsClickEvents();

        FunnelsBuilder.funnelBuilderEvents();

        /**
         * load the last saved questions from db and set the FunnelsUtil.questions, FunnelsUtil.sequence
         */
        FunnelsUtil.loadDBQuestion();

        FunnelsUtil.customQuestion();

        FunnelsBuilder.ctaLoadDataClick(false);

        // disable closing hidden field popup on escape key or press on document
        $('#hidden-field-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        $('#confirmation-delete').on('hidden.bs.modal', function (e) {
            FunnelsBuilder.item_length();
        });

    }
};

//*
// ** Window Load
// *

$(window).on('load',function() {
    FunnelsBuilder.item_length();
    //*
    // ** Load Font Object
    // *
    //autosize($('textarea'));
});

jQuery(document).ready(function () {
    /************** Start: Hidden fields popup handling *******************/

    $('[data-hidden-save-btn]').click(function () {
        // validate field label
        if ($('[data-field-name]').val().trim() == '') {
            $('[data-hidden-field-label-error]').show();
            return false;
        }
        // validate hidden field
        if (!FunnelsBuilder.validHiddenField || !FunnelsBuilder.validHiddenParam) {
            return false;
        }
        const btn_save = jQuery('[data-hidden-save-btn]');
        const label = $('[data-change-hidden-field-label]').val()
        const default_text = $('[data-change-hidden-field-default]').val()
        const param_text = $('[data-change-hidden-parameter]').val()
        const is_checked = $('[data-field-name="hidden.enable-dynamic-population"]').is(':checked')
        const key = $('[data-id="ques_id"]').val();
        let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
        let current_question = funnel_info.hidden_fields[key]
        current_question.options['field-label'] = label
        $('.fb-question-item.slide.hidden-field[data-id="ques' +key+ '"]').find('.sub-text:last').html(label);
        current_question.options['default-value'] = default_text
        current_question.options['parameter'] = param_text
        current_question.options['enable-dynamic-population'] = is_checked ? 1: 0;
        current_question.options['unique-variable-name'] = `$hidden_${key}`
        localStorage.setItem(FunnelsUtil.ls_key, JSON.stringify(funnel_info));
        $('[data-hidden-save-btn]').prop('disabled', true);
        btn_save.addClass("saving");
        setTimeout(function () {
            $('[data-id="main-submit"]').click();
        }, 500);
        setTimeout(function () {
            jQuery('[data-hidden-save-btn]').removeClass("saving");
            $('[data-hidden-save-btn]').prop('disabled', false);
            $("#hidden-field-modal").modal('hide')
        }, 500);
        $('body').removeClass('hidden-field-modal');
    });


    // disable when field is empty
    jQuery(".form-control").keyup(function(){
        const label_val = $('[data-change-hidden-field-label]').val().trim();
        const param_val = $('[data-change-hidden-parameter]').val().trim();

        if ($(this).data('field-name') != 'hidden.field-label'){
            if (label_val && FunnelsBuilder.validHiddenField) {
                jQuery('[data-hidden-save-btn]').prop("disabled", false);
            } else {
                jQuery('[data-hidden-save-btn]').prop("disabled", true);
            }
        }
        if (($('#hidden-field-option').is(':checked') && !param_val)){
            jQuery('[data-hidden-save-btn]').prop("disabled", true);
        }
    });


    // field label required and unique validation
    jQuery('[data-change-hidden-field-label]').on('keyup input paste', FunnelsUtil.debounce(function (event) {
        let inputVal = $(this).val().trim();
        if (inputVal == "") {
            FunnelsBuilder.validHiddenField = false;
            $('[data-hidden-field-label-error]').show();
            jQuery(this).addClass('error');
        } else {
            FunnelsBuilder.validHiddenField = true;
            $('[data-hidden-field-label-error]').hide();
            jQuery(this).removeClass('error');
        }
        // unique validation
        let found = false;
        if (inputVal != "") {
            let ques_id = $('[data-id="ques_id"]').val();
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            for(let key in funnel_info.hidden_fields){
                let field = funnel_info.hidden_fields[key]
                if (field && ques_id != key  && (field['options']['field-label'] == inputVal)) {
                    found = true;
                    break;
                }
            }
        }
        if (found) {
            FunnelsBuilder.validHiddenField = false;
            $('[data-hidden-field-label-error]').html('Already exists, Please enter different field label.').show();
            jQuery(this).addClass('error');
            jQuery('[data-hidden-save-btn]').prop("disabled", true);
        }else if (inputVal && FunnelsBuilder.validHiddenParam){
            jQuery('[data-hidden-save-btn]').prop("disabled", false);
        }else {
            jQuery('[data-hidden-save-btn]').prop("disabled", true);
        }
        const param_val = $('[data-change-hidden-parameter]').val().trim();
        if (($('#hidden-field-option').is(':checked') && !param_val)){
            jQuery('[data-hidden-save-btn]').prop("disabled", true);
        }
    }, 500));


    // parameter unique validation
    jQuery('[data-change-hidden-parameter]').on('keyup input paste', FunnelsUtil.debounce(function (event) {
        let inputVal = $(this).val().trim();
        // unique validation
        let found = false;
        if (inputVal != "") {
            let ques_id = $('[data-id="ques_id"]').val();
            let funnel_info = FunnelsUtil._getFunnelInfo('local_storage');
            for(let key in funnel_info.hidden_fields){
                let field = funnel_info.hidden_fields[key]
                if (ques_id != key  && (field['options']['parameter'] == inputVal)) {
                    found = true;
                    break;
                }
            }
        }
        if (found) {
            FunnelsBuilder.validHiddenParam = false;
            $('[data-hidden-parameter-error]').show();
            jQuery('[data-hidden-save-btn]').prop("disabled", true);
        } else {
            FunnelsBuilder.validHiddenParam = true;
            $('[data-hidden-parameter-error]').hide();
        }
    }, 500));

    /************** End: Hidden fields popup handling *******************/

    $('#hidden-field-option').change(function(event){
        const label_val = $('[data-change-hidden-field-label]').val().trim();
        const param_field = $('[data-field-name="hidden.parameter"]')
        if ($(this).is(':checked')) {
            $('.hidden-parameter-slide').slideDown(400, function() {
                param_field.focus();
                $('[data-hidden-save-btn]').prop("disabled", (!label_val || !param_field.val().trim() || !FunnelsBuilder.validHiddenField || !FunnelsBuilder.validHiddenParam));
            });
        }else {
            $('[data-field-name="hidden.parameter"]').blur();
            $('.hidden-parameter-slide').slideUp();
            $('[data-hidden-save-btn]').prop("disabled", (!label_val || !FunnelsBuilder.validHiddenField));
        }
    });


    // activate/deactivate featured image
    jQuery('[data-toggle-feature-image]').change(function (event) {
        let enable_featured_image = (event.target.checked) ? 1 : 0;
        if (enable_featured_image == 1) {
            $("#imagestatus").val("active");
        } else {
            $("#imagestatus").val("inactive");
        }
    });
    //*
    // ** Send Object In Options
    // *

    var $options = $();
    $options = $options.add($('<option>').attr('value', '').html('Select Font Type'));
    $.each(ctaFonts , function (index , value) {
        $class = value;
        $options = $options.add(
            $('<option class="'+$class+'">').attr('value', value).html(value).css('font-family', value)
        );
    });
    $('select.font-type').html($options).trigger('change');

    // Entry point for funnel builder
    FunnelsBuilder.init();

    // Render html to load questions from local storage on page refresh
    FunnelActions.loadQuestions();

    /* custom accordion function */
    jQuery('.custom-accordion__opener').click(function (e) {
        e.preventDefault();
        var _self = jQuery(this);
        if(_self.hasClass('active')) {
            _self.removeClass('active');
            _self.next('.custom-accordion__slide').slideUp();
        }

        else {
            _self.parents('.custom-accordion').find('.custom-accordion__opener').removeClass('active');
            _self.parents('.custom-accordion').find('.custom-accordion__slide').slideUp();
            _self.addClass('active');
            _self.next('.custom-accordion__slide').slideDown();
        }
    });

    jQuery(".question-option-scroll").mCustomScrollbar({
        axis: "y",
        scrollInertia: 500,
        autoExpandScrollbar: true,
        //autoHideScrollbar : true,
    });

    // Third Party URL - Edit
    $(".lp_thankyou_toggle").click(function () {
        $(".thankyou-page-cancel").click();
        $(".third-party__panel").slideToggle({
            start: function () {
                $(".action__link_edit").hide();
                $(".action__link_cancel").css({
                    display: "flex"
                });
                $("#thrd_url").focus();
            }
        });
        $('#thankyou').bootstrapToggle('off');
    });

    // Third Party URL - Cancel
    $(".action__link_cancel").click(function () {
        if($(".third-party__panel").is(":visible")){
            $(".third-party__panel").slideToggle({
                start: function () {
                    $(".action__link_edit").show();
                    $(".action__link_cancel").hide();
                }
            })
        }
    });

    // Thank you Editor - Edit
    $(".thankyou-edit-page").click(function (e) {
        e.preventDefault();
        $(".action__link_cancel").click();
        $(this).parents('.funnel-thankyou-page-pannel').addClass('active');
        $(this).parents('.funnel-thankyou-page-pannel').find('.lp-custom-para').slideUp();
        $(this).parents('.funnel-thankyou-page-pannel').find('.thankyou-page-text-area').slideDown(
            function () {
                $(".thank-you-modal-scroll").getNiceScroll().resize();
            }
        );
        $(this).hide();
        $(".thankyou-page-cancel").css({
            display: "flex"
        });
    });

    // Thank you Editor - Cancel
    $(".thankyou-page-cancel").click(function (e) {
        e.preventDefault();
        $(this).parents('.funnel-thankyou-page-pannel').removeClass('active');
        $(this).parents('.funnel-thankyou-page-pannel').find('.lp-custom-para').slideDown();
        $(this).parents('.funnel-thankyou-page-pannel').find('.thankyou-page-text-area').slideUp(
            function () {
                $(".thank-you-modal-scroll").getNiceScroll().resize();
            }
        );
        $(this).hide();
        $(".thankyou-edit-page").css({
            display: "flex"
        });
    });

    $(".funnel-edit").on('click',function (){
        $(".funnel-name-wrap").addClass('funnel-edit-active');
        $(".funnel-name").attr("contenteditable",true).focus();
    });

    $(".funnel-edit-close").on('click',function (){
        $(".funnel-name-wrap").removeClass('funnel-edit-active');
        let old_funnel_name = $(".funnel-name").attr('data-old-name');
        $(".funnel-name").html(old_funnel_name).attr("contenteditable",false);
    });

    $(".funnel-name").on('keyup',function(event){
        let old_funnel_name = $(".funnel-name").attr('data-old-name');
        var keycode = (event.keyCode ?event.keyCode : event.which);
        // if($(this).html() == "") {
        //     $(".funnel-name").html(old_funnel_name).attr("contenteditable",true).focus();
        // }
        if(keycode === 13){
            $(".funnel-edit-check").click();
        }
    });

    $('#homepage-cta-message-pop').on('shown.bs.modal', function (event) {
        autosize.update($('textarea'));

        jQuery('[data-form-field]').keypress(function(e) {
          console.log('typing testing');
          if (e.which === 32 && e.target.selectionStart === 0) {
            return false;
          }
        })
    });

    $('#homepage-cta-message-pop').on('show.bs.modal', function (event) {
      $('.cta__message label.error').css({
        display: "none"
      });
    });

    // CTA modal cancel button
    $('#cta-cancel-btn').on('click',function (){
        confirmationModal.set('[data-save-cta-btn]');
    });

    // Security message modal cancel button
    $('[data-security-message-close-btn]').on('click',function (){
        confirmationModal.set('[data-security-message-save]');
    });

    $(".funnel-edit-check").on('click',function (){
        let funnel_name = $(".funnel-name").text();
        var response = true;
        let old_funnel_name = $(".funnel-name").attr('data-old-name');
        $(".funnel-name-wrap").removeClass('funnel-edit-active');
        if(funnel_name == "" || funnel_name.trim() == "") {
            $(".funnel-name").html(old_funnel_name).attr("contenteditable",false);
            response = false;
        }
        // else if(funnel_name != "" && funnel_name != old_funnel_name) {
        //     var rec = jQuery.parseJSON(funnel_json);
        //     $(rec).each(function (index, el) {
        //         if(el.funnel_name != "" && el.funnel_name != null)
        //         {
        //             if (funnel_name === el.funnel_name) {
        //                 displayAlert('danger', 'Funnel name ' + funnel_name + ' is already in use. Please try something else.');
        //                 response = false;
        //             }
        //         }
        //     });
        // }
            if (response) {
                $(".funnel-name").attr("contenteditable", false);
                let hash = $('[data-id="main-submit"]').data("lpkeys");
                if(funnel_name != old_funnel_name)
                {
                    $.ajax(
                        {
                            type: "POST",
                            data: {hash: hash, funnel_name: funnel_name, _token: ajax_token},
                            url: "/lp/funnel-builder/update-funnel-name",
                            dataType: "json",
                            cache: false,
                            async: false,
                            error: function (e) {
                                if (e.responseJSON.warning) {
                                    let message = e.responseJSON.warning;
                                    displayAlert("warning", message);
                                    let old_funnel_name = $(".funnel-name").attr('data-old-name');
                                    $(".funnel-name").html(old_funnel_name)
                                } else {
                                    let message = e.responseJSON.error;
                                    displayAlert("danger", message);
                                }
                            },
                            success: function (rsp) {
                                if (rsp.status) {
                                    $(".funnel-name").attr({'data-old-name': funnel_name});
                                    var rec = jQuery.parseJSON(funnel_json);
                                    $(rec).each(function (index, el) {
                                        if (old_funnel_name.toLowerCase() == el.funnel_name.toLowerCase()) {
                                            el.funnel_name = funnel_name;
                                            $(".funnel-name").attr('data-old-name', funnel_name);
                                            $(".funnel-name").attr('title', funnel_name);
                                            $(".funnel-name").tooltipster();
                                            $('.funnel-active').html(funnel_name);
                                        }
                                    });
                                    funnel_json = JSON.stringify(rec);
                                    $('.funnel-name').tooltipster('content', funnel_name);
                                    loadFunnel();
                                    $(".top-header-funnel").topHeaderFunnelLoader();
                                    let message = rsp.message;
                                    displayAlert("success", message);
                                }
                            }
                        });
                }
        }
    });

    window.addEventListener("beforeunload", function (e) {
        FunnelsUtil.removeLocalStorage();
    });

    $(document).on('change','#typ_logo',function (e){
        //var editor =  CKEDITOR.instances['lp-html-editor'];
        let editor = lpHtmlEditor.getInstance();
        var advancehtml = editor.html.get();

        if($(this).is(":checked")){
            $("#typ_logo").val(1);
            var img = new Image();
            let thankyou_id = $('[name="submission_id"]').val();
            let attr_src = thankyouList[thankyou_id].thankyou;
            let src_url = $(attr_src).find('#defaultLogo').attr('src');
            img.src = src_url;
            console.log(img.src);
            img.onload = function() {
                /*
                if(this.width > 350)
                    var html = "<img alt=\"\" id=\"defaultLogo\" width=\"350\" src=\"" +$("#default_logo").attr('src') +"\" />";
                else
                    var html = "<img alt=\"\" id=\"defaultLogo\" src=\"" +$("#default_logo").attr('src') +"\" />";
               */
                //var html = "<img alt=\"\" id=\"defaultLogo\" width=\"350\" src=\"" +$("#default_logo").attr('src') +"\" />";
                var html = "<img alt=\"\" id=\"defaultLogo\" style=\"max-width: 350px; max-height: 120px;\" src=\"" +src_url +"\"  class=\"fr-fic fr-dib thank-page-image\" />";

                editor.html.set("<p id=\"defaultLogoContainer\" style=\"text-align: center;\">"+html+"</p>"+advancehtml);
            }
        } else {
            $("#typ_logo").val(0);
            //advancehtml = advancehtml.replace(/<img(.*?)id="defaultLogo"(.*?)\/>/, '');
            advancehtml = advancehtml.replace(/<img(.*?)id="defaultLogo"(.*?)>/, '');
            advancehtml = advancehtml.replace(/<p(.*?)id="defaultLogoContainer"(.*?)>(.*?)<\/p>/, '');
            advancehtml = advancehtml.replace(/<p style="text-align: center;"><br><\/p>/, '');
            // advancehtml = advancehtml.replace(/<p>(.*?)<\/p>/, '');
            editor.html.set(advancehtml);
        }
        return;
    });

    // //toast message remove when click no feature and cta modal action
    //   $(document).on('click','[data-edit-cta-popup], [data-edit-featured-image]',function (){
    //       if($(".ct-toast").length > 0){
    //           $(".ct-toast").remove();
    //       }
    //   });
});
