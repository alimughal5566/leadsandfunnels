let confirmationModalObj = {
    ids: [],
    folders: [],
    processing: false,
    requestProcessing: false,
    reset: false,
    globalConfirmationCurrentForm: '',
    customSubmitCallback: null,
    initFunnelList: function () {
        window.doPreSelectInBothModals();
    },
    setCustomSubmitCallback: function (callback) {
        this.customSubmitCallback = callback;
    },

    removeCustomSubmitCallback: function () {
        this.customSubmitCallback = null
    }
};

function showGlobalRequestConfirmationForm($form){
    confirmationModalObj.requestProcessing = false;
    $(".funnel__wrapper").css({'padding-top':'0'});
    $('#global-setting-funnel-list-pop').modal('show');
    $(".confimation-setting").show();
    $(".folder-input").prop('checked',true);
    $(".main-setting,.checked-0,.funnel-no-text,[data-funnel-builder]").hide();
    $(".funnels .btn-link").attr('aria-expanded','false');
    $(".funnels .setting-slide").removeClass('show');
    $('#selected_funnels').remove();
    let _values =  selectedFunnelList();
    var selectedKeys = _values.filter(function (value) {
        if(value.fkey != lpkey){
            return value.fkey;
        }
    });
    let _keys = selectedKeys.map(val => val.fkey).join(',');
    $("<input>").attr({
        name: "selected_funnels",
        id: "selected_funnels",
        type: "hidden",
        value: _keys
    }).appendTo($form);
    confirmationModalObj.globalConfirmationCurrentForm = $form;
}

function submitGlobalForm($form = "") {

    if(typeof confirmationModalObj.customSubmitCallback === 'function'){
        confirmationModalObj.customSubmitCallback();
    } else if (checkIfFunnelsSelected()) {
        if($form && !confirmationModalObj.globalConfirmationCurrentForm){
            confirmationModalObj.globalConfirmationCurrentForm = $form;
        }
        if(!confirmationModalObj.requestProcessing){
            confirmationModalObj.requestProcessing = true;
            setTimeout(function () {
                confirmationModalObj.requestProcessing = false;
            },9000)
        } else {
            return false;
        }

        if($(confirmationModalObj.globalConfirmationCurrentForm).attr("ajax-submit") === undefined) {
            var message = 'Saving changes...';
            displayAlert('loading', message, 0);
        }
        $(confirmationModalObj.globalConfirmationCurrentForm).submit();
    }
}

function setglobalConfirmationCurrentFormToDefault() {
    confirmationModalObj.globalConfirmationCurrentForm = '';
}
