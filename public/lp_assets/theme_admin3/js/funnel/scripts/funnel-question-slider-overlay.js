var field = '';
// it will work for non-numeric slider question
var nonNumericOption = {
    /**
     *  Clone menu option and append
     */
    cloneOption: function (){
        var cloned = $('.fb-options__list:last-child').clone();
        cloned.addClass('empty-field');
        let optionLength = $('.empty-field').length;
        cloned.find('input').val('');
        if(optionLength == 0) {
            $('.fb-options__list:last-child').after(cloned);
            cloned.find('input').focus();
        }
        else {
            $('.empty-field').find('input').focus();
        }
        // tab key bind again
        $('.form-control').unbind('keydown');
        FunnelsUtil.setSubmitButtonErrorState(true);
    },

    /**
     * Toggle (enable/disable) delete and move operation
     * @param toggle
     */
    toggleMoveDelete: function () {
        let remaining_opts = nonNumericOption.getFieldsLength();

        if (remaining_opts == 1) {
            $('.fb-options').find('.fb-options__list').addClass('not-allowed');
            //$("[data-option-sort], .dropdown-option-list").sortable('disable');
            $("[data-option-sort]").sortable('disable');
        } else {
            $('.fb-options').find('.fb-options__list').removeClass('not-allowed');
            $("[data-option-sort]").sortable('enable');
        }
    },

    /**
     * Get fields length from local storage
     * @returns number
     */
    getFieldsLength: function () {
        //return $('[data-menu-options]').length;
        return $(".fb-options__list").find("[data-non-numeric-options]").length;
    },

    optionsValueChecker: function (_this){
        let findValue = jQuery.grep($('[data-non-numeric-options]'), function (el, i) {
            if (el.value) {
                return el.value.toLowerCase() == $(_this).val().toLowerCase();
            }
        });
        return findValue;
    },

    init: function (){
        nonNumericOption.toggleMoveDelete();
        //add new option add in menu question when click on add new option button
        $('.lp-btn_add-option').click(function(e){
            e.preventDefault();
            nonNumericOption.cloneOption();
            nonNumericOption.toggleMoveDelete();
        });

        //sort menu option
        $("[data-option-sort]").sortable({
            handle: ".fb-options__col_handler",
            tolerance: "pointer",
            update: function (event, ui) {
                nonNumericOption.saveOption();
            }
        });

        //remove dropdown and menu option
        $(document).off('click' , '.slider-non-numeric-delete').on('click' , '.slider-non-numeric-delete',function (event) {
            event.preventDefault();
            let _self = this;
            $(_self).parents('.fb-options__list').remove();
            // disable delete/move
            nonNumericOption.toggleMoveDelete();
            // save changes
            nonNumericOption.saveOption();
        });

        //dropdown and menu add new option,duplicate and write the text
        jQuery(document).on('keyup input','[data-non-numeric-options]', FunnelsUtil.debounce(function (event) {
            var keycode = (event.keyCode ?event.keyCode : event.which);
            if(keycode === 13){
                if ($(this).val().length != '') {
                    nonNumericOption.cloneOption();
                }
            } else {
                nonNumericOption.saveOption();
                let result = nonNumericOption.optionsValueChecker(this);
                if (result == "" || result.length == 1) {
                    jQuery(this).removeClass('error');
                    if (jQuery(this).val()) {
                        jQuery(this).parents('.fb-options__list').removeClass('empty-field');
                    } else {
                        jQuery(this).parents('.fb-options__list').addClass('empty-field');
                    }
                    // disable delete/move
                    nonNumericOption.toggleMoveDelete();
                } else {
                    displayAlert('warning', 'You have added duplicate entry.');
                    jQuery(this).parents('.fb-options__list').addClass('empty-field');
                }
            }
        }, 50));

        //dropdown and menu option value reset
        jQuery(document).on('click','.clear-btn',function (event){
            jQuery(this).parents('.fb-options__list').find('.fb-form-control').val('').focus();
            jQuery(this).parents('.fb-options__list').addClass('empty-field');
            nonNumericOption.saveOption();
            // disable delete/move
            nonNumericOption.toggleMoveDelete();
        });
    },

    saveOption: function (){
        let arrayValue = $('[data-non-numeric-options]').map((i,el) => (el.value != '')?el.value:null).toArray();

        arrayValue =nonNumericOption.checkCaseSensitive(arrayValue,false);

        SaveChangesPreview.saveJson("slider-non-numeric.range", arrayValue);
        sliderOptionLoad();
        sliderManage();
    },
    checkCaseSensitive: function (arr, caseSensitive){

        let temp = [];
        return [...new Set(caseSensitive ? arr : arr.filter(x => {
            let _x = typeof x === 'string' ? x.toLowerCase() : x;
            if(temp.indexOf(_x) === -1){
                temp.push(_x)
                return x;
            }
        }))];

    }
};



jQuery(document).ready(function() {
    FBEditor.init();
    InputControls.init();
    FunnelActions.saveFunnelInDB();
    InputControls.setIconSecurityDropdown();
    nonNumericOption.init();
    jQuery('.slider-tab-link').click(function(e){
        e.preventDefault();
        jQuery('.slider-tab-link').removeClass('active');
        jQuery(this).addClass('active');
        if(jQuery(this).hasClass('non-numeric')){
            jQuery('.tab-content').addClass('non-numeric-active');
            SaveChangesPreview.saveJson('slider-non-numeric.value', 1);
            SaveChangesPreview.saveJson('slider-numeric.value', 0);
        }
        else {
            jQuery('.tab-content').removeClass('non-numeric-active');
            SaveChangesPreview.saveJson('slider-non-numeric.value', 0);
            SaveChangesPreview.saveJson('slider-numeric.value', 1);
            if(!$('.fb-tab__link.fb-tab__link_inner').hasClass('active'))
            {
                $('.fb-tab__link[href=#puck1]').click();
            }
        }

        sliderOptionLoad();
        sliderManage();
    });
    jQuery('.fb-tab__link').click(function(e){
        e.preventDefault();
        if(jQuery(this).attr('href') == '#puck2'){
            SaveChangesPreview.saveJson('slider-numeric.one-puck.value', 0);
            SaveChangesPreview.saveJson('slider-numeric.two-puck.value', 1);
        }
        else {
            SaveChangesPreview.saveJson('slider-numeric.one-puck.value', 1);
            SaveChangesPreview.saveJson('slider-numeric.two-puck.value', 0);
        }
        sliderOptionLoad();
        sliderManage();
    });

    $("[data-slider-segment]").click(function (event){
        event.preventDefault();
        let parents = $(this).parents('#'+$(this).attr('data-parent'));
        if(parents){
            var cloned = parents.find(".slider-range-clone__item:last").clone();
            let num = parseInt(cloned.find('[data-range]').attr('data-slider-start'))+1;
            let increment = 0;
            if($('.fb-tab__tab-pane.active .fb-select_start').eq(0).val() == 1){
                increment = 1;
            }
            let startValue = parseInt(cloned.find('[data-slider-end]').val())+increment;
            cloned.find('.slider-range-clone__del').removeClass('question-hide');
            cloned.find('select').removeClass('select-unit select-by select-start').attr('disabled',true);
            cloned.find('.select2-container').addClass('select2-container--disabled');
            cloned.find('[data-slider-start]').val(startValue).attr('data-slider-start',num).removeClass('error');
            cloned.find('[data-slider-end]').val('').attr('data-slider-end',num).removeClass('error');
            cloned.find('[data-slider-by]').val('').attr('data-slider-by',num);
            cloned.find('.segment-grid .el-tooltip').attr('title', 'Tooltip Content');
            parents.find('.fb-form').append(cloned);
            FunnelActions.disableFunnelSaveBtn();
            InputControls.tooltip();
        }
    });

    $(document).off("click",".slider-range-clone__del").on("click",".slider-range-clone__del",function (event){
        event.preventDefault();
        $(this).parents('.slider-range-clone__item').remove();
        field = $('.fb-tab__tab-pane.active');
        makeRange();
    });

    $(document).on('keyup','[data-segment]',FunnelsUtil.debounce(function (e) {
        field = $('.fb-tab__tab-pane.active');
        sliderValidator.validate($(this));

        let maxLength =  12;
        if(this.value.length >= maxLength){
            $(this).val(this.value.slice(0, maxLength));
        }

        if($('.fb-tab__tab-pane.active').find('[data-segment].error').length == 0){
            makeRange();
        }
    },2600));

    /**
     * this for preventing special charcter
     */
    $(document).on('keypress','[data-segment]',function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $(document).on('change','.fb-tab__tab-pane.active .fb-select_unit',function (){
        $(".fb-tab__tab-pane.active .fb-select_unit-wrap .select2-selection__rendered .select2_style").html($(this).find('option:selected').text());
    });

    $(document).on('change','.fb-tab__tab-pane.active .fb-select_by',function (){
        if($(this).val() == 'increment')
        {
            $('[data-slider-segment]').parent('.fb-options__add-more').hide();
            $('.fb-tab__tab-pane.active .slider-range-clone__del').each(function(index){
                if( index > 0)
                {
                    let remove_div=$(this);
                    setTimeout(function() {
                        $(remove_div).click();
                    }, 200);
                }
            });
            $('.slider-range-clone__item').css("padding-bottom",'20px');
        }
        else{
            $('[data-slider-segment]').parent('.fb-options__add-more').show();
            $('.slider-range-clone__item').css("padding-bottom",'0px');
        }
        $(".fb-tab__tab-pane.active .fb-select_by-wrap .select2-selection__rendered .select2_style").html($(this).find('option:selected').text());
    });

    $(document).on('change','.fb-tab__tab-pane.active .fb-select_start',function (){
        $(".fb-tab__tab-pane.active .fb-select_start-wrap .select2-selection__rendered .select2_style").html($(this).find('option:selected').text());
    });

    jQuery('.slider-label-wrap .form-control').focus(function(){
        jQuery(this).parents('.slider-label-wrap').addClass('focus-active');
    });

    jQuery('.slider-label-wrap .form-control').blur(function(){
        var parent = jQuery(this).parents('.slider-label-wrap');
        var inputValue = jQuery(this).val();
        parent.removeClass('focus-active filled');
        if (inputValue == "") {
            parent.removeClass('focus-active filled');
        } else {
            parent.addClass('filled');
        }
    });

   jQuery('.slider-label-wrap .form-control').keyup(function(){
        var inputValue = jQuery(this).val();
        if (inputValue == "") {
            jQuery(this).parents('.slider-label-wrap').removeClass('focus-active filled');
        } else {
            jQuery(this).parents('.slider-label-wrap').addClass('filled');
        }
    });


    sliderOptionLoad();
    sliderManage();

});

function makeRange(){
    let arrayValue = [];
    let fieldName = field.data('field-name');
    $(field).find('[data-range]').each(function (index, value){
        let row = $(value).attr("data-slider-start");
        let start = $(field).find('[data-slider-start='+row+']').val();
        let end = $(field).find('[data-slider-end='+row+']').val();
        let by = $(field).find('[data-slider-by='+row+']').val();
        arrayValue.push({
                by: by,
                end: end,
                start: start
            });
    });

    SaveChangesPreview.saveJson(fieldName, arrayValue);
    sliderOptionLoad();
    if(slider.getRange().indexOf(slider.getRangeValueByKey(slider.getInitialValue())) === -1){
        jQuery("[data-slider-one-puck-point-value]").attr('data-slider-value',1).val(1);
        SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName:"data-slider-one-puck-point-value"});
    }
    slider.refresh();
}

function sliderManage() {
    if(json['options']['slider-numeric']['value'] === 1) {
        if(json['options']['slider-numeric']['one-puck']['value'] === 1) {
            let onePuckSlider = jQuery(".fb-slider").bootstrapSlider({
                    formatter: function (index) {
                        slider.setOnePuckFormattedValue(index);
                        return index;
                    },
                    step: 1,
                    min: 0,
                    max: slider.getMaxRangeCount(),
                    value: slider.getInitialValue(),
                    id: "one-puck"
                }).on('slideStop', function (event) {
                    slider.setInitialValue(onePuckSlider.bootstrapSlider("getValue"));
                    SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName: "data-slider-one-puck-point-value"});
                });
            onePuckSlider.trigger('change');
        }
        if(json['options']['slider-numeric']['two-puck']['value'] === 1) {
            FunnelsUtil.twoPuckSlider('left-panel');
        }
    }
    else {
        let nonNumericSlider = jQuery(".non-numeric-slider").bootstrapSlider({
                formatter: function (index) {
                    jQuery(".non-numeric-starting-point").text(slider.getRangeValueByKey(index));
                    return index;
                },
                step: 1,
                min: 0,
                max: slider.getMaxRangeCount(),
                value: slider.getInitialValue(),
                id: "non-numeric"
            }).on('slideStop', function (event) {
                slider.setInitialValue(nonNumericSlider.bootstrapSlider("getValue"));
                SaveChangesPreview.saveQuestion(event, 'rangeSlider', {fieldName: "data-slider-non-numeric-point-value"});
            });
        nonNumericSlider.trigger('change');
    }
}

function sliderOptionLoad() {
    FunnelsUtil.currentLoadedQuestion();
    FunnelsUtil.setSliderValue();
    slider.setLabels();
}

var sliderValidator = {
    currentStart: null,
    currentEnd: null,
    currentBy: null,

    validate: function ($this) {
        if($this.attr("data-slider-start") !== undefined) {
            let key = $this.attr("data-slider-start");
            this.setValues(key);
            this.validateStartAndEnd(parseInt(key));
        } else if($this.attr("data-slider-end") !== undefined) {
            let key = $this.attr("data-slider-end");
            this.setValues(key);
            this.validateStartAndEnd(parseInt(key));
        } else if($this.attr("data-slider-by") !== undefined) {
            let key = $this.attr("data-slider-by");
            this.setValues(key);
            this.validateBy();
        }

        slider.checkErrors();
        if(FunnelsUtil.isSubmitButtonErrorState()) {
            FunnelActions.disableFunnelSaveBtn();
        }
    },

    /**
     * set current values to validate
      * @param key
     */
    setValues: function(key){
        this.currentStart = jQuery(field).find('[data-slider-start=' + key + ']');
        this.currentEnd = jQuery(field).find('[data-slider-end=' + key + ']');
        this.currentBy = jQuery(field).find('[data-slider-by=' + key + ']');
    },

    /**
     * validate by
     */
    validateBy: function (){
        let by_value = parseInt(this.currentBy.val());
        if (this.currentBy.val() == "" || by_value == 0 || by_value > (parseInt(this.currentEnd.val()) - parseInt(this.currentStart.val()))) {
            this.currentBy.addClass('error');
        } else {
            this.currentBy.removeClass('error');
        }
    },

    validateStartAndEnd: function (key) {
        let start = parseInt(this.currentStart.val()),
            end = parseInt(this.currentEnd.val()),
            prevEnd = this.currentEnd.parents('.slider-range-clone__item').prev().find("[data-slider-end]"),
            nextStart = this.currentStart.parents('.slider-range-clone__item').next().find("[data-slider-start]");

        this.validateBy();
        if(this.currentStart.val() == "" || this.currentEnd.val() == "") {
            this.currentStart.addClass('error');
            this.currentEnd.addClass('error');
        }else if(start >= end) {
            this.currentStart.addClass('error');
            this.currentEnd.addClass('error');
        } else if(prevEnd.length && start < parseInt(prevEnd.val())) {
            this.currentStart.addClass('error');
            prevEnd.addClass('error');
         } else if(nextStart.length && end > parseInt(nextStart.val())) {
            this.currentEnd.addClass('error');
            nextStart.addClass('error');
        } else {
            this.currentStart.removeClass('error');
            this.currentEnd.removeClass('error');
            if(prevEnd.length && prevEnd.val() != "") {
                prevEnd.removeClass('error');
            }
            if(nextStart.length && nextStart.val() != "") {
                nextStart.removeClass('error');
            }
        }
    }
};
