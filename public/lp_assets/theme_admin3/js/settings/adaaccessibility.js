let requesting = false;
$(document).ready(function () {
    // var $form = $('#ada_accessibility_form');
    ajaxRequestHandler.init('#ada_accessibility_form');

    $("#main-submit").click(function (e) {
        ajaxRequestHandler.submitForm(function (response, isError) {
            console.log("ADA accessibility callback...");
        }, true);
        // alert('HELLO');
        // if (GLOBAL_MODE) {
        //     if (checkIfFunnelsSelected()) {
        //         //  debugger;
        //         /*if (!requesting)
        //             requesting = true;*/
        //         showGlobalRequestConfirmationForm($form);
        //     }
        // } else {
        //     if (!requesting) {
        //         requesting = true;
        //         $($form).submit();
        //     }
        // }
    });
});

