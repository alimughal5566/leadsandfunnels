window.selectItems = {
    'select-answer-style' :[
        {
            id:0,
            text:'<div class="select2_style">Select answer style: <span>Drop Downs</span></div>',
            title:'Drop Downs'
        },
        {
            id:1,
            text:'<div class="select2_style">Select answer style: <span>Select Field</span></div>',
            title:'Select Answer'
        }
    ],
};

var question_birthday_overlay = {
    inside_minimum_age: false,
    overlay_select_list : [
        {selecter:".select-answer-style", parent:".select-answer-style-parent"},
    ],

    /*
    ** custom select loop
    **/

    allCustomSelect: function () {
        var selectlist = question_birthday_overlay.overlay_select_list;
        for(var i = 0; i < selectlist.length; i++){
            initSelect.initCustomSelect(selectlist[i].selecter,selectlist[i].parent);
        }
    },

    /*
   ** Range bar Function
   **/

    rangebar: function () {

        let birthday_year_old_slider = jQuery('.birthday-year-old').bootstrapSlider({
            formatter: function(value) {
                jQuery('.birthday-select2js__slide__minimum-val').html(value);
                let val = $('[data-year-old-slider-value]').val();
                if (val == 0) {
                    jQuery('.birthday-select2js__slide__minimum-val').eq(0).html("0 (none)");
                    $('[data-years-old]').html('(no minimum age)');
                    question_birthday_overlay.inside_minimum_age = false;
                } else {
                    if (question_birthday_overlay.inside_minimum_age === false) {
                        if(val == 1)
                        {
                            $('[data-years-old]').html('year old');
                        }
                        else{
                            $('[data-years-old]').html('years old');
                        }
                        question_birthday_overlay.inside_minimum_age = true;
                    }
                }
            },
            min: 0,
            max: 100,
            value: $('[data-year-old-slider-value]').val(),
            tooltip: 'false',
        });

        birthday_year_old_slider.on('slideStop', function (event) {
            SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName:"data-year-old-slider-value"});
            let select_year = birthday_year_old_slider.bootstrapSlider("getValue");
            if(select_year == 1)
            {
                $('[data-years-old]').html('year old');
            }
            else{
                $('[data-years-old]').html('years old');
            }
        });


        let birthday_year_slider = jQuery('.birthday-year-slider').bootstrapSlider({
            formatter: function(value) {
                jQuery('.birthday-select2js__slide__current-year').html(value);
            },
            min: 0,
            max: 110,
            value: $('[data-year-slider-value]').val(),
            tooltip: 'false',
        });

        birthday_year_slider.on('slideStop', function (event) {
            SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName:"data-year-slider-value"});
            let select_year = birthday_year_slider.bootstrapSlider("getValue");
            if(select_year <= 1)
            {
                $('[data-slider-year-text]').text(' year');
            }
            else{
                $('[data-slider-year-text]').text(' years');
            }
        });

        birthday_year_slider.on('change', function (slideEvt) {
            if(slideEvt.value.newValue < 2) {
                jQuery(this).parents('.birthday-select2js__slide__range-wrap').find('.year-text').addClass('years-active');
            }
            else {
                jQuery(this).parents('.birthday-select2js__slide__range-wrap').find('.year-text').removeClass('years-active');
            }
        });
    },

    /*
     ** Outside click Function
     **/

    outsideclick: function () {
        jQuery(document).click(function(e) {
            var target = e.target;

            if (!jQuery(e.target).hasClass("birthday-select2js__opener") && jQuery(e.target).parents(".birthday-select2js__slide__body-area").length === 0) {
                jQuery(".birthday-select2js").removeClass('slide-active');
            }
        });
    },

    /*
    ** Birthday Select Function
    **/

    birthday_select: function () {
        jQuery('.birthday-select2js__opener').click(function (e){
            e.preventDefault();
            if(jQuery(this).parent('.birthday-select2js').hasClass('slide-active')) {
                jQuery(this).parent('.birthday-select2js').removeClass('slide-active');
            }

            else {
                jQuery('.birthday-select2js').removeClass('slide-active');
                jQuery(this).parent('.birthday-select2js').addClass('slide-active');
            }
        });

        jQuery('.birthday-select2js__slide__label').click(function (e){
            e.preventDefault();
            jQuery(this).parents('.birthday-select2js').toggleClass('slide-active');
        });
    },

    /*
    ** init Function
    **/

    init: function() {
        question_birthday_overlay.allCustomSelect();
        question_birthday_overlay.rangebar();
        question_birthday_overlay.outsideclick();
        question_birthday_overlay.birthday_select();
    },
};

jQuery(document).ready(function() {
    question_birthday_overlay.init();
    FBEditor.init();
    InputControls.init();
    FunnelActions.saveFunnelInDB();
    InputControls.setIconSecurityDropdown();
});

