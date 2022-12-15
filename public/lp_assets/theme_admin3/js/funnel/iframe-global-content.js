// All Iframe/Preview On load events
// (FILE NOT REQUIRED ANYMORE) => this functionality is replaced with FunnelsPreview.showHideCtaOnUserInput();

jQuery(document).ready(function() {
    jQuery(document).on('keyup input paste','.form-control', FunnelsUtil.debounce(function (event) {
        var inputValue = jQuery(this).val();
        // hide CTA button
        if ($('#hide_cta').val() == 1) {
            if (inputValue == "" || inputValue.length <= 1) {
                $('.cta-btn-wrap').addClass('hide-btn');
            } else {
                if (inputValue.length >= 2) {
                    $('.cta-btn-wrap').removeClass('hide-btn');
                }
            }
        }

        // save value
        funnel_info.question_value = inputValue;
        FunnelsUtil.saveFunnelData(funnel_info);
    }, 500));
});
