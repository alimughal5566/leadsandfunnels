jQuery(document).ready(function() {
    FBEditor.init();
    InputControls.init();
    FunnelActions.saveFunnelInDB();
    InputControls.setIconSecurityDropdown();
    jQuery(".funnel-iframe-holder iframe").on('load', function() {
        if(jQuery('[data-field-name="zip-code-only"]').is(":checked"))
        {
            jQuery("[data-automatic-progress-option]").addClass('question-hide');
        }
    });
});
