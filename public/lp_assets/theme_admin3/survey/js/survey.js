
var progress = 0;
var isCtrl = false;
var _isCheck = false;
var _isCheck_last = false;
var pf = 0;

var survey = {
    '0': {'item': 'step1', 'type': 1, 'state': 'survey-overlay__btn'},
    '1': {'item': 'step2', 'type': 4, 'state': 'os-select__option_first'},
    '2': {'item': 'step3', 'type': 4, 'state': 'os-select__option_first'},
    '3': {'item': 'step4', 'type': 4, 'state': 'os-select__option_first'},
    '4': {'item': 'step5', 'type': 4, 'state': 'os-select__option_first'},
    '5': {'item': 'step-summary', 'type': 1, 'state': 'survey-overlay__btn'}
};
var current_step = {
    'item' : 'step1',
    'type' : 1,
    'state': 'survey-overlay__btn'
};

if(site.items) {
    $('html').addClass('en-survey');
}
$(document).ready(function(){
    $('.temp-close').click(function(){
        $('.survey-overlay').hide();
    });

    $('.survey-overlay__items').each(function(){
        $(this).attr('tabindex' , 0);
    });

    // Step2
    $('.lp-step1 .survey-overlay__btn').on('keydown , keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            event.preventDefault();
        }
    });


    $(".skip-question").click(function () {
        setTimeout(function () {
            surveyModule._owl.trigger('next.owl.carousel');
            surveyModule.changeProgress();
        },300);
    });

    surveyModule.init();
});


function ajax_set_session() {
    $.ajax({
        type : "POST",
        url : "/lp/survey/setsurveysession",
        data : {'_token':ajax_token},
        success : function() {},
        cache : false,
        async : true
    });
}


var surveyModule = {
    _owl: $('.survey-overlay__inner'),
    resize_owl: null,
    progressPerStep: 0,

    init: function () {
        surveyModule.initPlugins();
        surveyModule.bindDocumentEvents();
        surveyModule.initOwlCarousel();
        surveyModule.initOsSelectQuestion();
        surveyModule.initSubmitSurvey();
        surveyModule.progressPerStep = (100 / (totalSurveyQuestions + 2)); // Number of Questions + (Start+Finish Step)
    },

    initPlugins: function(){
        $(".os-select").mCustomScrollbar(
            {
                mouseWheel:{ scrollAmount: 300 },
                keyboard:{ enable: false },
                advanced:{ autoScrollOnFocus: "div" }
            }
        );
        $('.lp-step1').focus();

        $('#os-slider').bootstrapSlider({
            formatter: function(value) {
                summary.monthly_marketing_budget = value;
                var val = value;
                if(value == 50000){
                    val = '50k +';
                }
                $('.lp-step4__price-label').text('$'+val);
                $(".lp-step4__price-label").digits();
                return  value;
            },
            step: 500,
            min: 0,
            max: 50000,
            value: 0
        });

        $('.os-checkbox input[type="checkbox"]').click(function(){
            var checkBoxId = $(this).attr("id");
            if($(this).prop("checked") == true){
                $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
                if(checkBoxId == 14){
                    $('.os-checkbox input[name="online_marketing[]"]').prop('checked' , false);
                    $(this).prop("checked",true);
                    $(".lp-step2 .os-checkbox").removeClass('os-checkbox_checked')
                    $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
                } else {
                    $('.os-checkbox input[name="online_marketing[]"]#14').prop('checked' , false);
                    $('.os-checkbox input[name="online_marketing[]"]#14').closest('.os-checkbox').removeClass('os-checkbox_checked');
                }
            }else{
                $(this).closest('.os-checkbox').removeClass('os-checkbox_checked');
            }
        });

        $('.os-radio input[type="radio"]').click(function(){
            if($(this).prop("checked") == true){
                $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
            }else{
                $(this).closest('.os-checkbox').removeClass('os-checkbox_checked');
            }
        });
    },

    bindDocumentEvents: function(){
        $(document).on('keydown' , function(event){
            var keyCode = event.keyCode || event.which;
            if(keyCode == 17) {
                isCtrl = true
            }
            if(keyCode == 89 && isCtrl){
                ajax_set_session();
                //$('.overlay_container').show();

               // $('.survey-overlay').fadeOut();
              //  $("body").css({'overflow':'auto'});

              $('.survey-overlay').fadeOut(function(){
                 $('html').removeClass('en-survey');
                });
            }
        });
        $(document).on('keyup' , function(event){
            var keyCode = event.keyCode || event.which;
            if(keyCode == 17) {
                isCtrl = false
            }
        });
        $(document).on('keydown' , function(event){
            var keyCode = event.keyCode || event.which;

            if(keyCode == 8) {
                if (!$('input').is(":focus")) {
                    event.preventDefault();
                    $('.survey-overlay__btn_back').trigger('click');
                    surveyModule.getPreviousState();
                }
            }
        });
        $.fn.digits = function(){
            return this.each(function(){
                $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
            })
        };

        setTimeout(function(){
            $('#main-loader.os-loader').hide();
            $('.survey-overlay__wrapper').css({'overflow':'auto'});
        },600);

        $(document).on('keypress' , function(event){
            var keyCode = event.keyCode || event.which;
            var focused = $(':focus');
            if(keyCode == 13 && current_step.type == 1 && !focused.hasClass('btn')) {
                $('.lp-'+current_step.item+' .'+current_step.state).trigger('click');
            }
        });

        $('.os-checkbox').each(function(){
            $(this).attr('tabindex' , '0');
        });
        $('.os-select__option').each(function(){
            $(this).attr('tabindex' , '0');
        });
        $(document).on('keydown' , function(event){
            var keyCode = event.keyCode || event.which;
            if(current_step.type == 4){
                var focused = $(':focus');
                if(keyCode == 40 && !focused.hasClass('os-select__option_last')) {
                    event.preventDefault();
                    focused.next().focus();
                }
                if(keyCode == 38 && !focused.hasClass('os-select__option_first')){
                    focused.prev().focus();
                }
            }
        });
    },

    initOwlCarousel: function(){
        surveyModule.resize_owl = surveyModule._owl.owlCarousel({
            items: 1,
            loop: false,
            autoHeight:true,
            pause: "true",
            margin:60,
            touchDrag: false,
            mouseDrag: false,
            responsiveBaseElement: '.survey-overlay__inner',
        });

        $('body').on('click' , '.os-continue' , function (e) {
            e.preventDefault();
            surveyModule.changeProgress();
            surveyModule.updateSurveyData(parseInt(current_step.item));

            $('.os-progress-bar').fadeIn('fast');
            if(current_step.type == 2){
                surveyModule.setState('survey-overlay__btn');
            }
            surveyModule._owl.trigger('next.owl.carousel');
            surveyModule.getState();
            surveyModule.checkBackButton($(this));
        });
        $('body').on('click' , '.survey-overlay__btn_back' , function(e){
            e.preventDefault();
            progress--;
            var w = progress * surveyModule.progressPerStep;

            $('.os-progress-bar__dragger').css({'width':w+'%'});
            if(progress == 0){
                $('.os-progress-bar').fadeOut();
            }
            surveyModule._owl.trigger('prev.owl.carousel');
            surveyModule.getPreviousState();
        });
        surveyModule._owl.on('changed.owl.carousel', function(event) {
            // console.info('changed index:' + event.item.index );
            if(event.item.index == 0){
                $('#os-prv').hide();
            }
            if(current_step  && current_step.type == 4){
                _isCheck = false;
            }
            pf =  event.item.index;
            current_step.item = survey[pf].item;
            current_step.type = survey[pf].type;
            current_step.state = survey[pf].state;
        });
        surveyModule._owl.on('change.owl.carousel', function(event) {
            if(event.item == undefined){
                return;
            }
            if(current_step  && current_step.type == 4){
                _isCheck = false;
            }
            if(event.item.index == 9){
                _isCheck_last = false;
            }
        });
    },
    initOsSelectQuestion: function () {
        $('.lp-survey-step .os-select__option').click(function(){
            if(_isCheck){return;}
            _isCheck = true;

            let step = $(this).parents(".lp-survey-step").data('lp-step');
            console.log("Step 1 -- " + step, _isCheck);
            surveyModule.lpOptions($(this), step);

        });

        $('.lp-survey-step .os-select__option').on('keypress' , function(event){
            let step = $(this).parents(".lp-survey-step").data('lp-step');
            console.log("Step 2 -- " + step);
            var keyCode = event.keyCode || event.which;
            if(keyCode == 13){
                if(_isCheck){return;}
                _isCheck = true;
                surveyModule.lpOptions($(this), step);
            }
        });
        $('.lp-survey-step .os-select__option.os-select__option_last').on('keydown' , function(event){
            let step = $(this).parents(".lp-survey-step").data('lp-step');
            console.log("Step 3 -- " + step);

            var keyCode = event.keyCode || event.which;
            if(keyCode == 9){ // tab
                event.preventDefault();
                $('.lp-step' + step + ' .os-select__option.os-select__option_first').focus();
            }
        });
    },

    lpOptions: function(_this , currentStep){
        $('.lp-step'+currentStep+' .os-select__option').removeClass('os-select__option_selected');
        _this.addClass('os-select__option_selected');
        $("#lp-field-"+currentStep).val(_this.data('value'));

        surveyModule.updateSurveyData(currentStep);
        surveyModule.setState('os-select__option_selected');

        setTimeout(function () {
            surveyModule._owl.trigger('next.owl.carousel');
            surveyModule.changeProgress();
            surveyModule.getState();
        },300);
    },

    initSubmitSurvey: function () {
        $('.lp-step-summary__btn').click(function(){
            $('.os-progress-bar__dragger').css({'width':'100%'});
            surveyModule.submitSurvey();
        });
    },

    submitSurvey: function () {
        $('#inner-loader.os-loader').show();
        //$('.overlay_container').show();

        console.log("Survey data",surveyData);
        $.ajax({
            type : "POST",
            url : "/lp/survey/index",
            data : {'value':surveyData, _token:ajax_token},
            success : function(data) {
                // $('.os-loader').hide();
                $('.survey-overlay').fadeOut(function(){
                    $('html').removeClass('en-survey');
                });
            },
            cache : false,
            async : true
        });
    },

    getPreviousState: function(){
        setTimeout(function(){
            if(current_step.type != 3){
                $('.lp-'+current_step.item+' .'+current_step.state).focus();
            }else{
                $('#item'+ pf).focus();
            }
        } , 300);
    },

    getState: function(){
        setTimeout(function () {
            if (current_step.type != 1 && current_step.type != 3) {
                $('.lp-' + current_step.item + ' .'+current_step.state).focus();
            }else{
                console.info('kas:'+pf);
                $('#item'+ pf).focus();
            }
        }, 300);
    },

    setState: function(state){
        survey[pf].state = state;
    },
    changeProgress: function () {
        progress++;
        var w = progress * surveyModule.progressPerStep;
        $('.os-progress-bar__dragger').css({'width':w+'%'});
    },

    checkBackButton: function(_this) {
        if (_this.index() == 0) {
            $('#os-prv').fadeOut();
        } else {
            $('#os-prv').fadeIn();
        }
    },

    updateSurveyData: function (step) {
        let field = $("#lp-field-" + step);
        if(field.attr('name')) {
            surveyData[field.attr('name')] = field.val();
            $("#question_summary_"+step).html(field.val());
            console.log("Item", step, field.attr('name'));
        }
    }
};
