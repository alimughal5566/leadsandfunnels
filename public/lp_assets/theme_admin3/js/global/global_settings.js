// JS to handle Global Settings

var GLOBAL_ADJUSTMENT = false;
var GLOBAL_MODE = false;
var Funnel_Label = 'Select Funnel';
var Timeout_Var = '';
var Update_Timeout = '';
$(document).ready(function () {
    if ($('.funnel-active').first().text() !== 'Select Funnel') {

        Funnel_Label = $('.funnel-active').first().text();

    }
    // alert(Funnel_Label);

    var currentMode = '';
    if($(".scroll").length > 0 ) {
        $(".scroll").mCustomScrollbar({
            mouseWheel: {scrollAmount: 300}
        });
    }

    /**
     *  Menu Modal: Drag and Drop Jquery
     * */

    if($(".funnel__list").length > 0 ) {
        $(".funnel__list").mCustomScrollbar({
            mouseWheel: {scrollAmount: 80}
        });
    }
    if($(".lp-table.sorting").length > 0 ) {

        $(".lp-table.sorting").mCustomScrollbar({
            mouseWheel: {scrollAmount: 80}
        });
    }

    $(document).on("change", '[name="global_mode_bar"]', function (e){
        e.preventDefault();
        e.stopPropagation();
        if (Update_Timeout)
            clearTimeout(Update_Timeout);
        var mode = $(this).is(':checked') === true ? 1 : 0;
        if(mode) {
            $('.funnel-info-tag').show();
            $('body').addClass('global-on global_mode-logo-page');
        }
        else {
            $('.funnel-info-tag').hide();
            $('body').removeClass('global-on global_mode-logo-page');
        }


        if (currentMode === "") {
            currentMode = mode;
        } else if (mode === currentMode) {
            return false;
        }
        adjustGlobalHeaderState(mode, '[name="global_mode_bar"]', $(this).data('route') || false);
        $('[name="global_mode_bar"]').bootstrapToggle(mode ? 'on' : 'off');
        currentMode = "";
        if($(this).attr('data-route') == undefined) {
            globalModalObj.processing = true;
            globalModalObj.saveFunnelData();
        }

    });
});


$(document).on('click', '.lp-wistia-video', function () {
    //  debugger;
    $('#global-setting-placeholder-pop').modal('hide');
});


$(document).on('click', '.pop-create-funnel', function () {
    //  debugger;
    $('#global-setting-placeholder-pop').modal('hide');
    $('#global-setting-funnel-list-pop').modal('show');
});


$(document).on('click', '#global-funnel-list', function () {
    $('#global-setting-placeholder-pop').modal('hide');
    $('#global-setting-funnel-list-pop').modal('show');
});


function adjustGlobalHeaderState(mode, that, $route = null) {
    if (Timeout_Var)
        clearTimeout(Timeout_Var);

    GLOBAL_MODE = mode;
    var message = '';

    var DoHide = false;

    switch ($route) {
        case 'funnel-question' :
            DoHide = true;
            message = 'GLOBAL SETTINGS MODE IS NOT AVAILABLE WHEN EDITING QUESTIONS';
            break;

        case 'domain' :
            DoHide = true;
            message = 'Global Settings Mode is not available for Domains/Sub-Domains';
            break;

        case 'statistics' :
            DoHide = true;
            message = 'Global Settings Mode is not available for Stats';
            break;

        case 'myleads':
            DoHide = true;
            message = 'Global Settings Mode is not available for myleads';
            break;

        case 'integration':
        case 'integrate':
            DoHide = true;
            message = 'Global Settings Mode is not available for Integrations';
            break;

        case 'shareFunnel':
            DoHide = true;
            message = 'Global Settings Mode is not available for Share Funnel';
            break;

        case 'my_profile':
            DoHide = true;
            message = 'Global Settings Mode is not available for Profile';
            break;

        case 'support':
            DoHide = true;
            message = 'Global Settings Mode is not available for Support';
            break;

        default:
            message = 'GLOBAL SETTINGS MODE IS ON';


    }

    // http://haroon-myleads.pk/lp/popadmin/calltoactionsave
    // http://haroon-myleads.pk/lp/global/saveglobalmaincontent

    adjustGlobalSwitches(mode, that, message);

    if (!mode || DoHide) {
        Timeout_Var = setTimeout(function () {
            $('.global__bar').slideUp(650);
            $('body').removeClass('global-bar-active');
        }, 5000);
    }

    goToByScroll('global-settings-ist-bar');
    $('#global-settings-ist-bar p').text(message);

    adjustFormActionUrls(mode);

}


$('.gfooter-toggle').change(function () {
    if ($(this).prop('checked') == true) {
        $('#' + $(this).data('field')).val('y');
    } else {
        $('#' + $(this).data('field')).val('n');
    }
    $("#gfot-ai-flg").val('1');

});



function adjustFormActionUrls(mode) {
    // debugger;
    GLOBAL_ADJUSTMENT = true;

    if ($('.funnel-active').first().text() !== 'Select Funnel') {

        Funnel_Label = $('.funnel-active').first().text();

    }
    var globalForms = $(".global-content-form");


    var nonGlobalWrappers = $(".non-global-divs");
    var globalActiveWrappers = $(".global-active-divs");
    var globalDisabled = $(".global-disabled");

    var globalInputs = $(".global-input-text");
    var globalSelectBoxes = $(".global-select");
    var globalSwitches = $(".global-switch");
    var globalCheckboxes = $(".global-checkbox");
    var globalRadio = $(".global-radio");
    var globalTextArea = $(".global-text-area");

    $('.funnel-active').first().text(Funnel_Label);

    if (mode) {
        $('.funnel-info-tag').show();
    } else {
        $('.funnel-info-tag').hide();
    }


    // $(this).bootstrapToggle("on");
    // var action = mode ?

    globalSelectBoxes.each(function () {
        var val = $(this).data('val');
        $(this).val(val ? val : '-1');
        $(this).trigger('change');
        $(this).trigger({type: 'select2:select'});
    });

    if (mode) {

        $('.funnel-active').first().text('Select Funnel');

        globalForms.each(function () {
            // debugger;
            $(this).data('global_mode', 1);
            // $(this).prop('data-global_mode', 1)
            $(this).prop('action', $(this).data('global_action'))


            jQuery.validator.setDefaults({
                // This will ignore all hidden elements alongside `contenteditable` elements
                // that have no `name` attribute
                ignore: ":hidden, [contenteditable='true']:not([name])"
            });
        });

        nonGlobalWrappers.each(function () {
            $(this).hide();
        });

        globalDisabled.each(function () {
            $(this).prop('disabled', true);
            $(this).addClass("disabled");
        });

        globalActiveWrappers.each(function () {
            $(this).show();
        });

        //tags-disabled class add on selected tags when global setting is enable
        if (typeof tagsDisable === 'function')
         tagsDisable();

    } else {

        globalForms.each(function () {
            $(this).data('global_mode', 0);
            // $(this).prop('data-global_mode', 0)
            $(this).prop('action', $(this).data('action'))

            jQuery.validator.setDefaults({
                // This will ignore all hidden elements alongside `contenteditable` elements
                // that have no `name` attribute
                ignore: ":hidden, [contenteditable='true']:not([name])"
            });
        });

        globalDisabled.each(function () {
            $(this).prop('disabled', false);
            $(this).removeClass("disabled");
        });


        nonGlobalWrappers.each(function () {
            $(this).show();
        });

        globalActiveWrappers.each(function () {
            $(this).hide();
        });

        //tags-disabled class remove on selected tags when global setting is disable
        if (typeof tagsDisable === 'function')
         tagsDisable();
    }
    GLOBAL_ADJUSTMENT = false;

}


/**
 * this use for save the selected funnel value through ajax call
 * @returns {[]}
 */
function selectedFunnelList(){
    let _values = [];
    if(jQuery("#funnelsExample .funnel-checkbox:checked").length) {
        jQuery("#funnelsExample .funnel-checkbox:checked").each(function (key, el) {
            var obj = {
                fkey: $(this).data('fkey'),
                leadpop_folder_id: parseInt($(this).data('leadpop_folder_id')),
                name: $(this).data('domain-name')
            }
            _values.push(obj);
        });
    }
    return _values;
}

function checkIfFunnelsSelected() {
    let selectedList = selectedFunnelList();
    if (!selectedList.length) {
        displayAlert('danger', 'Please select Funnels for global action.');
        return false;
    }
    return true;
}

function checkIfFunnelsSelectedWithoutMessage() {
    let selectedList = selectedFunnelList();
    if (!selectedList.length) {
        return false;
    }
    return true;
}

function adjustGlobalSwitches(mode, that, message) {
    if (mode) {
        $(that).parents('#wrapper').find('.global').removeClass('global_mode-off').addClass('global_mode-on');
        $(that).parents().find('.global__bar p').text(message);
        $(that).parents().find('.global__bar p').show();
        if(lpkey) {
            setGlobalFunnelCounter();
        }
        $('#global-settings-ist-bar').show();
        $(that).parents().find('.global__bar').show();
        $('body').addClass('global-bar-active');
        $('body').addClass('global_mode-logo-page');
        lpUtilities.heading_ellipsis();
    } else {
        $(that).parents('#wrapper').find('.global').removeClass('global_mode-on').addClass('global_mode-off');
        $(that).parents().find('.global__bar p').text("GLOBAL SETTINGS MODE IS OFF");
        $('#global-settings-ist-bar').hide();
        $('.funnel-plus-icon').addClass('d-none');
        $('#selected_funnels').remove();
    }
}


// **************************************************************************************************************************************************

// ======================================== GLOBAL MODAL ===========================================================================================


// **************************************************************************************************************************************************

// ======================================== GLOBAL MODAL  END ===========================================================================================


function goToByScroll(id) {
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    if (id != "" && id !== undefined) {
        if ($("#" + id).offset() !== undefined) {
            $('html,body').animate({
                    scrollTop: $("#" + id).offset().top - 100
                },
                'slow');
        }
    }
}


/**
 * selected checkbox option checked when show modal / reset the option
 */

function selectedCheckboxChecked(){
    let selectedFunnels = localStorage.getItem('selectedFunnels');
    if(globalModalObj.currentSelection.length > 0){
        selectedFunnels = globalModalObj.currentSelection;
    }
    var allCheckbox = $("#funnelsExample input:checkbox");
    allCheckbox.parents(".funnel__item").addClass('checked-0');
    allCheckbox.prop("checked", false);
    if(selectedFunnels) {
        let lastSaveRecord = JSON.parse(selectedFunnels);
        lastSaveRecord.forEach(id => {
            jQuery("input[data-fkey='" + id.fkey + "']").parents(".funnel__item").removeClass('checked-0');
            jQuery("input[data-fkey='" + id.fkey + "']").prop("checked", true);
        });
    }
    if (lpkey) {
        jQuery("input[data-fkey='" + lpkey + "']").parents(".funnel__item").removeClass('checked-0');
        jQuery("input[data-fkey='" + lpkey + "']").prop({"checked": true,"disabled": true});
    }
    globalModalObj.folders.forEach(folderInfo => {
          globalModalObj.checkParentFolder(folderInfo.parentInput, folderInfo.parentDiv);
     });
}

/**
 * this function use for set the selected funnel counter
 */
function setGlobalFunnelCounter()
{
    let mode = $('[name="global_mode_bar"]').is(':checked') === true ? 1 : 0;
    let selectedFunnels = localStorage.getItem('selectedFunnels');
    if(selectedFunnels) {
        let lastSaveRecord = JSON.parse(selectedFunnels);
        var currentFunnel = lastSaveRecord.find(x => x.fkey === lpkey);
        if (mode == 1) {
            if (currentFunnel && parseInt(lastSaveRecord.length) > 1) {
                 $('.funnel-plus-icon').removeClass('d-none');
                lpUtilities.heading_ellipsis();
            }
        } else {
            $('.funnel-plus-icon').addClass('d-none');
        }
        let selectedFunnelCountText = ' Selected Funnels';
        let funnelLength = lastSaveRecord.length;
        if (currentFunnel && (lastSaveRecord.length === 1 || lastSaveRecord.length === 2)) {
            selectedFunnelCountText = ' Selected Funnel';
            if (lastSaveRecord.length === 1) {
                funnelLength = '';
            }
            else{
                funnelLength = funnelLength-1;
            }
        }
        else if (!currentFunnel && lastSaveRecord.length === 1) {
            selectedFunnelCountText = ' Selected Funnel';
        }
        else if (currentFunnel && lastSaveRecord.length > 1) {
            funnelLength = funnelLength-1;
        }

        $('.selectedFunnelCount').text(funnelLength + selectedFunnelCountText);
    }
}
