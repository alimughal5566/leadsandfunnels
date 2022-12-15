$(document).ready(function(){
    advanceFooterModule.init();
});


var advanceFooterModule = {
    form: $("#extra-content-form"),

    init: function() {
        ajaxRequestHandler.init('#extra-content-form');

        $('#main-submit').on('click', function () {
            if(advanceFooterModule.isSuperFooterUpdate()) {
                advanceFooterModule.saveForm();
            }
        });

        $("#_update_template_cta_btn").click(function (e) {
            advanceFooterModule.updateCtaTemplate();
        });
    },

    updateCtaTemplate: function(){
        var radioValue = $("input[name='property_cta']:checked").val();
        $('#modal_proerty_template').modal('hide');

        if(advanceFooterModule.isSuperFooterUpdate(false, radioValue)) {
            advanceFooterModule.saveForm();
        }
    },

    isSuperFooterUpdate: function (is_cta_update = true,  default_tpl_cta_msg = "n") {
        let editor = lpHtmlEditor.getInstance(),
            advancehtml = editor.html.get(),
            templatetype = $('#templatetype').val();

        if ((templatetype == 'property_template' || templatetype == 'property_template2') && is_cta_update) {
            $("#modal_proerty_template").modal();
            return false;
        }

        var fields = {
            default_tpl_cta_msg: default_tpl_cta_msg,
            advancehtml: advancehtml
        }
        console.log("default_tpl_cta_msg", default_tpl_cta_msg);

        for (var name in fields) {
            $('[name="' + name + '"]').val(fields[name])
        }

        return true;
    },

    saveForm: function () {
        ajaxRequestHandler.submitForm(function (response, isError) {
            console.log("Advance Footer submit callback...", response, isError);
        }, true);

        // console.log(advanceFooterModule.form.attr('action'), advanceFooterModule.form.attr('method'), advanceFooterModule.form.serializeArray());
        // if (GLOBAL_MODE) {
        //     if (checkIfFunnelsSelected()){
        //         //  debugger;
        //         if(confirmationModalObj.globalConfirmationCurrentForm == advanceFooterModule.form){
        //             advanceFooterModule.form.submit();
        //         } else {
        //             showGlobalRequestConfirmationForm(advanceFooterModule.form);
        //         }
        //     }
        //     // form.submit();
        // } else {
        //     advanceFooterModule.form.submit();
        // }
    }
};


