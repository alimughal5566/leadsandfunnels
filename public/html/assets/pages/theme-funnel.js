$(document).ready(function() {
    var amIclosing = false;
    $('.select2__theme').select2({
        minimumResultsForSearch: -1,
        width: '192px', // need to override the changed default
        dropdownParent: $('.select2__theme-parent')
    }).on('select2:openning', function() {
        jQuery('.select2__theme-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__theme-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__theme-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__theme-parent .select2-dropdown').hide();
        jQuery('.select2__theme-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__theme-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__theme-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__theme').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__theme-parent .select2-selection__rendered').show();
        jQuery('.select2__theme-parent .select2-results__options').css('pointer-events', 'none');
    });
});