window.selectItems = {
    'question-number-icon-type' :[
        {
            id:0,
            text:'<div class="select2_style"><span class="select2js-placeholder">Icon positioning:</span><span>Left Align</span></div>',
            title: 'Left Align'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Icon positioning:</span><span>Right Align</span></div>',
            title: 'Right Align'
        }
    ],

    'question-number-message' :[
        {
            id:0,
            text:'<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>Default Message</span></div>',
            title:'Message'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>Default Message</span></div>',
            title:'Message'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>Default Message</span></div>',
            title:'Message'
        }
    ],
};

var question_number_overlay = {

    overlay_select_list : [
        {selecter:".question-number-icon-type", parent:".question-number-input-icon-parent"},
        {selecter:".question-number-message", parent:".question-number-message-parent"},
    ],

    /*
    ** custom select loop
    **/

    allCustomSelect: function () {
        var selectlist = question_number_overlay.overlay_select_list;
        for(var i = 0; i < selectlist.length; i++){
            initSelect.initCustomSelect(selectlist[i].selecter,selectlist[i].parent);
        }
    },

    /**
     * Validate input min max
     */
    validateInputMinMax: function () {
        jQuery('[data-change-min-max]').on('keyup input paste', FunnelsUtil.debounce(function (event) {
            let val = event.target.value;
            if (val.trim() == "") {
                $(this).addClass('error');
                FunnelActions.disableFunnelSaveBtn();
                FunnelsUtil.setSubmitButtonErrorState(true);
                return;
            } else {
                $(this).removeClass('error');
            }
            const isMinEnabled = $('[data-field-name="enable-min-number"]').is(':checked');
            const isMaxEnabled = $('[data-field-name="enable-max-number"]').is(':checked');
            let min_val = $('[data-field-name="min-number"]').val().trim();
            let max_val = $('[data-field-name="max-number"]').val().trim();

            if (isMaxEnabled && isMinEnabled && parseInt(min_val) >= parseInt(max_val)) {
                $(this).addClass('error');
                FunnelsUtil.setSubmitButtonErrorState(true);
                $('[data-id="main-submit"]').data("disabled", true);
            } else if (isMaxEnabled && isMinEnabled && !min_val && !max_val){
                $(this).addClass('error');
                FunnelsUtil.setSubmitButtonErrorState(true);
            } else if (isMinEnabled && !min_val){
                $(this).addClass('error');
                FunnelsUtil.setSubmitButtonErrorState(true);
            } else if (isMaxEnabled && !max_val){
                $(this).addClass('error');
                FunnelsUtil.setSubmitButtonErrorState(true);
            } else {
                FunnelsUtil.setSubmitButtonErrorState(false);
                $('[data-field-name="max-number"]').removeClass('error');
                $('[data-field-name="min-number"]').removeClass('error');
                SaveChangesPreview.saveQuestion(event, "min-max", {fieldName:"min-number",value:Number(min_val)});
                SaveChangesPreview.saveQuestion(event, "min-max", {fieldName:"max-number",value:Number(max_val)});
            }
        }, 500));

        $('[data-field-name="enable-min-number"]').change(function (){
            const min = $('[data-field-name="min-number"]').val().trim();
            const max = $('[data-field-name="max-number"]').val().trim();
            const is_max_checked = $('[data-field-name="enable-max-number"]').is(':checked');
            if ($(this).is(':checked') && !min){
            }else if (is_max_checked && !max){
                setTimeout(function (){
                    FunnelActions.disableFunnelSaveBtn();
                },300)
            }else {
                $('[data-field-name="min-number"]').removeClass('error')
            }
            if (is_max_checked && $(this).is(':checked')){
                if (parseInt(min) >= parseInt(max)){
                    setTimeout(function (){
                        FunnelActions.disableFunnelSaveBtn();
                    },300)
                }
            }
        });

        $('[data-field-name="enable-max-number"]').change(function (){
            const min = $('[data-field-name="min-number"]').val().trim();
            const max = $('[data-field-name="max-number"]').val().trim();
            const is_min_checked = $('[data-field-name="enable-min-number"]').is(':checked');
            if ($(this).is(':checked') && !max){
            }else if (is_min_checked && !min){
               setTimeout(function (){
                   FunnelActions.disableFunnelSaveBtn();
               },300)
            }else {
                $('[data-field-name="max-number"]').removeClass('error')
            }
            if (is_min_checked && $(this).is(':checked')){
                if (parseInt(min) >= parseInt(max)){
                    setTimeout(function (){
                        FunnelActions.disableFunnelSaveBtn();
                    },300)
                }
            }
        })


    },

    /**
     * Toggle among format-with-comma/format-as-currency/format-as-percentage
     */
    toggleFormatOptions: function () {
        $('[data-toggle-format]').once('change', function (event) {
            SaveChangesPreview.saveJson($(this).data('field-name'), event.target.checked ? 1 : 0);
            if(event.target.checked) {
                if ($(this).data('field-name') == 'formatting.enable-format-as-currency') {
                    $('[data-field-name="formatting.enable-format-with-comma"]').prop('checked', false);
                    SaveChangesPreview.saveJson('formatting.enable-format-with-comma', 0);
                    $('[data-field-name="formatting.enable-format-as-percentage"]').prop('checked', false);
                    SaveChangesPreview.saveJson('formatting.enable-format-as-percentage', 0);
                } else if ($(this).data('field-name') == 'formatting.enable-format-as-percentage') {
                    $('[data-field-name="formatting.enable-format-with-comma"]').prop('checked', false);
                    SaveChangesPreview.saveJson('formatting.enable-format-with-comma', 0);
                    $('[data-field-name="formatting.enable-format-as-currency"]').prop('checked', false);
                    SaveChangesPreview.saveJson('formatting.enable-format-as-currency', 0);
                }
                else if($(this).data('field-name') == 'formatting.enable-format-with-comma')
                {
                    $('[data-field-name="formatting.enable-format-as-currency"]').prop('checked', false);
                    SaveChangesPreview.saveJson('formatting.enable-format-as-currency', 0);
                    $('[data-field-name="formatting.enable-format-as-percentage"]').prop('checked', false);
                    SaveChangesPreview.saveJson('formatting.enable-format-as-percentage', 0);
                }
            }
        });
    },

    /*
    ** init Function
    **/

    init: function() {
        question_number_overlay.allCustomSelect();
        question_number_overlay.validateInputMinMax();
        question_number_overlay.toggleFormatOptions();
    },
};

jQuery(document).ready(function() {
    question_number_overlay.init();
    FBEditor.init();
    InputControls.init();
    FunnelActions.saveFunnelInDB();
    InputControls.setIconSecurityDropdown();
});
