jQuery(document).ready(function() {
    InputControls.init();
    FunnelActions.saveFunnelInDB();
    InputControls.setIconSecurityDropdown();
    vehicleHanler.init();
});
