var question_select_list = [
    {selecter:".select-action", parent:".select-action-parent"},
    {selecter:".select-action-other", parent:".select-action-other-parent"},
    {selecter:".recipient-select", parent:".recipient-select-parent"},
    {selecter:".recipient-select", parent:".recipient-select-parent"},
    {selecter:".conditional-field-select", parent:".conditional-field-select-parent"},
    {selecter:".select-conditional", parent:".select-conditional-parent"},
    {selecter:".select2js__cell-carrier", parent:".select2js__cell-carrier-parent"},
    {selecter:".select-answer", parent:".select-answer-parent"}
];

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
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span' +
                ' class="text">7. What is your estimated down payment</span></div>',
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
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span' +
                ' class="text">7. What is your estimated down payment</span></div>',
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
                text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span' +
                ' class="text">7. What is your estimated down payment</span></div>',
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
/*
** custom select loop
**/
function customQuestion() {
    var selectlist = question_select_list;
    for(var i = 0; i < selectlist.length; i++){
        questionsSelectinit(selectlist[i].selecter,selectlist[i].parent);
    }
}

function showQuestionSelect2(element, config) {
    var amIclosing = false;
    $(element).select2(config)
        .on('select2:openning', function() {
            $(this).parent().find('.select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
        var _self = jQuery(this);
        _self.parent().find('.select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            _self.parent().find('.select2-results__options').css('pointer-events', 'auto');
        }, 300);
        _self.parent().find('.select2-dropdown').hide();
        _self.parent().find('.select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        _self.parent().find('.select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            _self.parent().find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = _self.find(':selected').index();
                var defaultHeight = 40;
                var scrolledArea = getindex * defaultHeight;
                _self.parent().find(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            var _self = jQuery(this);
            e.preventDefault();
            amIclosing = true;
            _self.parent().find('.select2-dropdown').attr('style', '');
            setTimeout(function () {
                _self.select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery(this).parent().find('.select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery(this).parent().find('.select2-selection__rendered').show();
        jQuery(this).parent().find('.select2-results__options').css('pointer-events', 'none');
    });
}

/*
** init custom select
**/
function questionsSelectinit(selecter,parent) {
    var amIclosing = false;
    var _selector = jQuery(selecter);
    var _parent = jQuery(parent);
    var selectorClass = selecter.replace(/[#.]/g,'');
    _selector.select2({
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(parent),
        width: '100%',

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

    if (selectorClass == 'select2js__cell-carrier') {
        _selector.on('change', function () {
            $("#edit-rcpt").trigger("click");
        });
    }

    if (selectorClass == 'select-answer') {
        _selector.on('change', function () {
            if($(this).val() == 'zip-option') {
                $('.select-code-field-slide').hide();
                $('.zip-code-field-slide').show();
            }else if($(this).val() ==  'state-option') {
                $('.zip-code-field-slide').hide();
                $('.select-code-field-slide').show();
            }
        });
        _selector.on('select2:unselect', function (evt) {
            if (!evt.params.originalEvent) {
                return;
            }
            evt.params.originalEvent.stopPropagation();
        });
    }
}

jQuery(document).ready(function () {
    var amIclosing = false;

    customQuestion();
    var i = 0;
    $(document).on('click', '.add-row', function(e){
        i++;
        e.preventDefault();
        var ClonedItem = $('.conditional-select-wrap.hidden').clone().removeClass('hidden');
        var parentItem = 'select-action-parent' + i;
        var selectorItem = 'select-action' + i;
        ClonedItem.find('.select-action-alt').addClass(selectorItem);
        ClonedItem.find('.select-action-parent-alt').addClass(parentItem);
        ClonedItem.find('.show-question-alt').removeClass('show-question-alt').addClass('show-question');
        ClonedItem.find('.show-question-parent-alt').removeClass('show-question-parent-alt').addClass('show-question-parent');
        $(this).parents('.conditional-select-area').append(ClonedItem);
        questionsSelectinit('.' +selectorItem, '.' +parentItem);
    });

    var question_select = [
        {
            id:0,
            text:'<div class="select2_style"><span class="text">select question</span></div>',
            title: 'qeustion',
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-location"></i></span><span class="text">1. Question N/A</span></div>',
            title: 'qeustion',
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">2. What type of loan do you need?</span></div>',
            title: 'Loan',
        },
        {
            id:3,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">3.1. Great, what kind of home are you purchasing?</span></div>',
            title: 'Purchase',
        },
        {
            id:4,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">3.2. Estimate your credit score:</span></div>',
            title: 'Credit Score',
        },
        {
            id:5,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">3.3. Is this your first property purchase?</span></div>',
            title: 'Property Purchase',
        },
        {
            id:6,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-location"></i></span><span class="text">4. Enter your zip code</span></div>',
            title: 'Zip Code',
        },
        {
            id:7,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-birthday"></i></span><span class="text">5. When is your birthday</span></div>',
            title: 'Birthday',
        },
        {
            id:8,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-select-text"></i></span><span class="text">6. Anything else we should consider?</span></div>',
            title: 'Consider',
        },
        {
            id:9,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span' +
            ' class="text">7. What is your estimated down payment</span></div>',
            title: 'Down Payment',
        },
        {
            id:10,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-group"></i></span><span class="text">8. Loan Type: Refinance</span></div>',
            title: 'Refinance',
        }
    ];

    var question_show = [
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
            title: 'Zip code',
        },
        {
            id:5,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-birthday"></i></span><span class="text">5. When is your birthday</span></div>',
            title: 'qeustion',
        },
        {
            id:6,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-select-text"></i></span><span class="text">6. Anything else we should consider?</span></div>',
            title: 'Consider',
        },
        {
            id:7,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span' +
            ' class="text">7. What is your estimated down payment</span></div>',
            title: 'Down Payment',
        },
        {
            id:8,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-group"></i></span><span class="text">8. Loan Type: Refinance</span></div>',
            title: 'Refinance',
        }
    ];

    var questions_options_list = {
        "question_config_1": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Is", value: "1"},
                {title: "Is not", value: "2"},
                {title: "Is any of", value: "3"},
                {title: "Is none of", value: "4"},
                {title: "Is Known", value: "5"},
                {title: "Is unKnown", value: "6"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                    title:'select Answer',
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                    title:'select Answer',
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                    title:'select Answer',
                },
                {
                    id:4,
                    text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                    title:'select Answer',
                }
            ]
        },
        "question_config_2": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Is", value: "1"},
                {title: "Is not", value: "2"},
                {title: "Is any of", value: "3"},
                {title: "Is none of", value: "4"},
                {title: "Is Known", value: "5"},
                {title: "Is unKnown", value: "6"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">select Answer</span></div>',
                    title:'select Answer',
                },
                {
                    id:2,
                    text:'<div class="select2_style"><label class="fake-checkbox"><span class="text"><i class="check-icon"></i>Purchase</span> </label></div>',
                    title:'Purchase',
                },
                {
                    id:3,
                    text:'<div class="select2_style">' +
                    '<label class="fake-checkbox">' +
                    '<span class="text"><i class="check-icon"></i>Refinance</span> </label>' +
                    '</div>',
                    title:'Refinance',
                },
                {
                    id:4,
                    text:'<div class="select2_style">' +
                    '<label class="fake-checkbox">' +
                    '<span class="text"><i class="check-icon"></i>Home-Equity Loans</span> </label>' +
                    '</div>',
                    title:'Home-Equity Loans',
                },
                {
                    id:5,
                    text:'<div class="select2_style">' +
                    '<label class="fake-checkbox">' +
                    '<span class="text"><i class="check-icon"></i>Fixed-Rate Loans</span> </label>' +
                    '</div>',
                    title:'Fixed-Rate Loans',
                },
            ],
            "answersType": "multiple"

        },
        "question_config_3": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Is", value: "1"},
                {title: "Is not", value: "2"},
                {title: "Is any of", value: "3"},
                {title: "Is none of", value: "4"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
            ],

        },
        "question_config_4": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Is", value: "1"},
                {title: "Is not", value: "2"},
                {title: "Is any of", value: "3"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:4,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:5,
                    text:'<div class="select2_style"><span class="text">select Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
            ],

        },
        "question_config_5": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Is", value: "1"},
                {title: "Is not", value: "2"},
                {title: "Is any of", value: "3"},
                {title: "Is none of", value: "4"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">Sub Answer</span></div>',
                    title:'select Sub Answer',
                },
            ],
        },
        "question_config_6": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Contains exactly", value: "1"},
                {title: "Doesn't contain exactly", value: "2"},
                {title: "Starts with", value: "3"},
                {title: "Doesn't Start with", value: "4"},
                {title: "Ends with", value: "5"},
                {title: "Doesn't End with", value: "6"},
                {title: "Is Empty", value: "7"},
                {title: "Is Filled", value: "8"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">Answer options</span></div>',
                    title:'Answer options',
                },
                {
                    id: 'zip-option',
                    text:'<div class="select2_style"><span class="text">Enter Zip Code(s)</span></div>',
                    title:'Enter Zip Code(s)',
                },
                {
                    id: 'state-option',
                    text:'<div class="select2_style"><span class="text">Select States From a List</span></div>',
                    title:'Select States From a List',
                },
            ],
        },
        "question_config_7": {
            "options": [
                {title: "Is Equal to", value: "0"},
                {title: "Is before", value: "1"},
                {title: "Is after", value: "2"},
                {title: "Is between", value: "3"},
                {title: "Is Known", value: "4"},
                {title: "Is UnKnown", value: "5"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">Answer options</span></div>',
                    title:'Answer options'
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">Birthday Answer 01</span></div>',
                    title:'Answer options 01'
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">Birthday Answer 02</span></div>',
                    title:'Answer options 02'
                },
                {
                    id:4,
                    text:'<div class="select2_style"><span class="text">Birthday Answer 03</span></div>',
                    title:'Answer options 03'
                }
            ]
        },
        "question_config_8": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Contains exactly", value: "1"},
                {title: "Doesn't contain exactly", value: "2"},
                {title: "Starts with", value: "3"},
                {title: "Doesn't Start with", value: "4"},
                {title: "Ends with", value: "5"},
                {title: "Doesn't End with", value: "6"},
                {title: "Is Empty", value: "7"},
                {title: "Is Filled", value: "8"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">Answer options</span></div>',
                    title:'Answer options'
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">Answer 1</span></div>',
                    title:'Answer 1'
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">Answer 2</span></div>',
                    title:'Answer 2'
                },
            ],
        },
        "question_config_9": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Is equal", value: "1"},
                {title: "Is not equal to", value: "2"},
                {title: "Is greater then", value: "3"},
                {title: "Is greater then or equal to", value: "4"},
                {title: "Is less then", value: "5"},
                {title: "Is less then or equal to", value: "6"},
                {title: "Is Between", value: "7"},
                {title: "Is Known", value: "8"},
                {title: "Is unKnown", value: "9"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">Answer options</span></div>',
                    title:'Answer options'
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">Answer 1</span></div>',
                    title:'Answer 1'
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">Answer 2</span></div>',
                    title:'Answer 2'
                },
            ],
        },
        "question_config_10": {
            "options": [
                {title: "Select Conditional", value: "0"},
                {title: "Loan Type", value: "1"},
                {title: "Loan Type", value: "2"},
                {title: "Loan Type", value: "3"},
            ],
            "answersOptions": [
                {
                    id:1,
                    text:'<div class="select2_style"><span class="text">Answer options</span></div>',
                    title:'Answer options'
                },
                {
                    id:2,
                    text:'<div class="select2_style"><span class="text">Purchase</span></div>',
                    title:'Purchase'
                },
                {
                    id:3,
                    text:'<div class="select2_style"><span class="text">Refinance</span></div>',
                    title:'Refinance'
                },
            ],
        },
    };

    function getOptionsFormat(options) {
        var optionsHtml = '';
        jQuery(options).each(function(index, option){
            optionsHtml += '<option value="'+option.value+'"><label>'+option.title +'</label></option>';
        });
        return optionsHtml;
    }

    $('.select-question').select2({
        data: question_select,
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select-question-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('select2:openning', function() {
        jQuery('.select-question-parent .select2-selection__rendered').css('opacity', '0');
    }).on('change', function() {
        if($(this).val() != 6) {
            $('.select-code-field-slide').hide();
            $('.zip-code-field-slide').hide();
        }
        var questionID = $(this).val();
        var questionConfig = questions_options_list['question_config_' + questionID];
        if(questionConfig != undefined) {
            jQuery('.select-conditional-parent, .select-answer-parent').removeClass('disabled');
            var answersType = questionConfig.answersType ? questionConfig.answersType : false;
            var optionsHTML = getOptionsFormat(questionConfig.options);
            $(".select-conditional ").html(optionsHTML).trigger('change');
            var select2_config = {
                minimumResultsForSearch: -1,
                width: '100%', // need to override the changed default
                dropdownParent: $('.select-answer-parent'),
                data: questionConfig.answersOptions,
                templateResult: function (d) { return $(d.text); },
                templateSelection: function (d) { return $(d.text); }
            };

            if(answersType == 'multiple') {
                select2_config['multiple'] = true;
                select2_config['closeOnSelect'] = false;
                select2_config['placeholder'] = 'Select Answers';
            } else {
                $('.select-answer').removeAttr("multiple");
            }
            $('.select-answer').select2('destroy').empty().select2(select2_config);
        }
    }).on('select2:open', function() {
        jQuery('.select-question-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select-question-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select-question-parent .select2-dropdown').hide();
        jQuery('.select-question-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select-question-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select-question-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('.select-question').find(':selected').index();
                var defaultHeight = 40;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select-question-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select-question').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select-question-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select-question-parent .select2-selection__rendered').show();
        jQuery('.select-question-parent .select2-results__options').css('pointer-events', 'none');
    });

    showQuestionSelect2('.show-question', {
        data: question_show,
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent:function(){
            return $(this).parent();
        },
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    });

    $('.form-control-textarea').keyup(function () {
        if (jQuery(this).val() != '') {
            jQuery(this).addClass('empty');
        }
        else {
            jQuery(this).removeClass('empty');
        }
    });

    $(document).on('click' , '.remove-row', function(e) {
        e.preventDefault();
        jQuery(this).parents('.conditional-select-wrap').hide();
    });

    $(document).on('click' , '.select-states-opener', function(e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#select-state-modal').modal('show');
    });

    $(document).on('click' , '.state-modal-close', function(e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('show');
        $('#select-state-modal').modal('hide');
    });

    $(document).on('click' , '.select-receipient-opener', function(e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#select-recipient-modal').modal('show');
    });

    $(document).on('click' , '.new-recipient-opener', function(e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#select-recipient-modal').modal('hide');
        $('#lead-recipients-modal').modal('show');
    });

    $(document).on('click' , '.recipient-modal-close', function(e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('show');
        $('#select-recipient-modal').modal('hide');
    });

    $(document).on('click' , '.lead-recipients-modal-close', function(e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#select-recipient-modal').modal('show');
        $('#lead-recipients-modal').modal('hide');
    });

    $(document).on('click' , '.status-modal-opener', function(e) {
        e.preventDefault();
        $('#condition-modal-status').modal('show');
        $('#active-condition-modal').modal('hide');
    });

    $(document).on('click' , '.status-modal-close', function(e) {
        e.preventDefault();
        $('#condition-modal-status').modal('hide');
        $('#active-condition-modal').modal('show');
    });

    $('.state-all-checked').change(function () {
        if(this.checked){
            $(this).parents('.select-state-modal').find('.state-checkbox').prop("checked", true);
            $(this).parents('.select-state-modal').find('.state-save-btn').prop("disabled", false);
        }
        else {
            $(this).parents('.select-state-modal').find('.state-checkbox').prop("checked", false);
            $(this).parents('.select-state-modal').find('.state-save-btn').prop("disabled", true);
        }
    });

    $('.state-reset-btn').click(function (e) {
        e.preventDefault();
        $(this).parents('.select-state-modal').find('.state-checkbox').prop("checked", false);
        $(this).parents('.select-state-modal').find('.state-all-checked').prop("checked", false);
        $(this).parents('.select-state-modal').find('.state-save-btn').prop("disabled", true);
    });

    $(document).on('click' , '.block-opener', function(e) {
        e.preventDefault();
        $(this).parents('.item-wrap').toggleClass('slide-active');
        $(this).toggleClass('active');
        $(this).parents('.item-wrap').find('.condition-slide').slideToggle();

        if($(this).hasClass('active')) {
            $(this).tooltipster('content', '<div class="condition-tooltip">Collapsed Condition</div>');
        }
        else {
            $(this).tooltipster('content', '<div class="condition-tooltip">Expand Condition</div>');
        }
    });

    $(document).on('click' , '.list-tags .remove-tag', function(e) {
        e.stopPropagation();
        $(this).parent().remove();
    });

    $('.state-checkbox').change(function () {
        if ($('.state-checkbox:checked').length <= 0) {
            $(this).parents('.select-state-modal').find('.state-save-btn').prop("disabled", true);
        } else {
            $(this).parents('.select-state-modal').find('.state-save-btn').prop("disabled", false);
        }
    });

    $('#select-state-modal').on('show.bs.modal', function (event) {
        $('.state-checkbox').prop("checked", false);
        $('.state-all-checked').prop("checked", false);
        $('.state-save-btn').prop("disabled", true);
    });

    $('.recipient-all-checked').change(function () {
        if(this.checked){
            $(this).parents('.select-recipient-modal').find('.recipient-checkbox').prop("checked", true);
            $(this).parents('.select-recipient-modal').find('.recipient-save-btn').prop("disabled", false);
        }
        else {
            $(this).parents('.select-recipient-modal').find('.recipient-checkbox').prop("checked", false);
            $(this).parents('.select-recipient-modal').find('.recipient-save-btn').prop("disabled", true);
        }
    });

    $('.recipient-reset-btn').click(function (e) {
        e.preventDefault();
        $(this).parents('.select-recipient-modal').find('.recipient-checkbox').prop("checked", false);
        $(this).parents('.select-recipient-modal').find('.recipient-all-checked').prop("checked", false);
        $(this).parents('.select-recipient-modal').find('.recipient-save-btn').prop("disabled", true);
    });

    $('.recipient-checkbox').change(function () {
        if ($('.recipient-checkbox:checked').length <= 0) {
            $(this).parents('.select-recipient-modal').find('.recipient-save-btn').prop("disabled", true);
        } else {
            $(this).parents('.select-recipient-modal').find('.recipient-save-btn').prop("disabled", false);
        }
    });

    $('#select-recipient-modal').on('show.bs.modal', function (event) {
        $('.recipient-checkbox').prop("checked", false);
        $('.recipient-all-checked').prop("checked", false);
        $('.recipient-save-btn').prop("disabled", true);
    });

    $('.active-condition-link').click(function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#active-condition-modal').modal('show');
    });

    $('.active-condition-modal-close').click(function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('show');
        $('#active-condition-modal').modal('hide');
    });

    $('.add-condition-link').click(function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('show');
        $('#active-condition-modal').modal('hide');
    });

    $('.condition-all-checked').change(function () {
        if(this.checked){
            $(this).parents('.active-condition-modal').find('.condition-check').prop("checked", true);
            $(this).parents('.active-condition-modal').find('.delete-select-btn').show();
            $(this).parents('.active-condition-modal').find('.item-wrap').addClass('check-parent-active');
        }
        else {
            $(this).parents('.active-condition-modal').find('.condition-check').prop("checked", false);
            $(this).parents('.active-condition-modal').find('.delete-select-btn').hide();
            $(this).parents('.active-condition-modal').find('.item-wrap').removeClass('check-parent-active');
        }
    });

    $('.condition-check').change(function () {
        if ($('.condition-check:checked').length <= 0) {
            $(this).parents('.active-condition-modal').find('.delete-select-btn').hide();
        } else {
            $(this).parents('.active-condition-modal').find('.delete-select-btn').show();
        }

        if(this.checked){
            $(this).parents('.item-wrap').addClass('check-parent-active');
        }
        else {
            $(this).parents('.item-wrap').removeClass('check-parent-active');
        }
    });

    $('.delete-select-btn').click(function (e) {
        e.preventDefault();
        $(this).parents('.active-condition-modal').find('.check-parent-active').hide();
        $(this).parents('.active-condition-modal').find('.condition-all-checked').prop("checked", false);
        $(this).hide();
    });

    $('#active-condition-modal').on('show.bs.modal', function (event) {
        $('.condition-all-checked').prop("checked", false);
        $('.condition-check').prop("checked", false);
        $('.delete-select-btn').hide();
        $('.item-wrap').removeClass('check-parent-active').show();
    });

    $('#active-condition-modal').on('shown.bs.modal', function (event) {
        $('.tooltip-label').each(function () {
            if($(this).outerWidth() > 638) {
                $(this).tooltipster('enable');
            }
            else {
                $(this).tooltipster('disable');
            }
        });
    });

    $('.celphone-radio').change(function (e) {

        if ($(this).val() == 'y'){
            $(".cell-number-slide").slideDown();
            $('.lead-recipient-form').find('#cel-number').focus();
        }
        else {
            $(".cell-number-slide").slideUp();
            $('.lead-recipient-form').find('#cel-number').blur();
        }
    });

    $('#cel-number').inputmask({"mask": "(999) 999-9999"});

    $('.add-recipient-btn').click(function () {
        var is_valid = true;
        var error = [];
        $.validator.addMethod("emailValid", function (value, element, regexpr) {
            return regexpr.test(value);
        }, "Please enter a valid email address.");
        $.validator.addMethod("phoneValid", function (value, element, regexpr) {
            return regexpr.test(value);
        }, "Please enter a valid phone number.");
        $('#lead-recipients-form').validate({
            rules: {
                full_name: {
                    required: false
                },
                cell_number: {
                    required: true,
                    phoneValid: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/
                },
                cell_carrier: {
                    required: true
                },
                new_email: {
                    required: true,
                    emailValid: /(.+)@(.+){2,}\.(.+){2,}/
                }
            },
            messages: {
                full_name: {
                    required: "Please enter your first name."
                },
                cell_number: {
                    required: "Mobile number is required to receive text alerts."
                },
                cell_carrier: {
                    required: "You must select a Carrier to receive text alerts."
                },
                new_email: {
                    required: "Please enter your email address."
                }
            },
        });
        return is_valid;
    });

    $('#lead-recipients-modal').on('shown.bs.modal', function (event) {
        $('.lead-recipient-form').find('#full-name').focus();
    });

    $('#lead-recipients-modal').on('hidden.bs.modal', function (event) {
        $(this).find(".form-control.error").removeClass("error");
        $('label.error').hide();
        $(".cell-number-slide").slideUp();
        $('#cell-text-yes').prop("checked", false);
        $("#cell-text-no").prop("checked", true);
        $('.lead-recipient-form').find('#cel-number').blur();
    });
});
