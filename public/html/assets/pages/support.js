var support = {

    /*
    ** Select support Function
    **/

    selectSupport: function () {
        var amIclosing = false;

        $('.subject-select01').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.subject-select-parent01')
        }).on('select2:opening', function() {
            // jQuery('.subject-select-parent01 .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.subject-select-parent01 .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.subject-select-parent01 .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.subject-select-parent01 .select2-dropdown').hide();
            jQuery('.subject-select-parent01 .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.subject-select-parent01 .select2-selection__rendered').hide();
            setTimeout(function () {
                jQuery('.subject-select-parent01 .select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.subject-select-parent01 .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.subject-select01').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.subject-select-parent01 .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.subject-select-parent01 .select2-selection__rendered').show();
            jQuery('.subject-select-parent01 .select2-results__options').css('pointer-events', 'none');
        }).on('select2:select', function(){
            $('.subject-select02').removeAttr('disabled');
        });

        $('.subject-select02').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.subject-select-parent02')
        }).on('select2:opening', function(e) {
            if($(this).find('option').length < 2){
                e.preventDefault()
            }
        }).on('select2:open', function() {
            jQuery('.subject-select-parent02 .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.subject-select-parent02 .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.subject-select-parent02 .select2-dropdown').hide();
            jQuery('.subject-select-parent02 .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.subject-select-parent02 .select2-selection__rendered').hide();
            setTimeout(function () {
                jQuery('.subject-select-parent02 .select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.subject-select-parent02 .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.subject-select02').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.subject-select-parent02 .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.subject-select-parent02 .select2-selection__rendered').show();
            jQuery('.subject-select-parent02 .select2-results__options').css('pointer-events', 'none');
        });
    },

    /*
   ** init Function
   **/

    init: function () {
        support.selectSupport();
    }
};

jQuery(document).ready(function() {
    support.init();
});