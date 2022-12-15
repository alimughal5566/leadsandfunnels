var email_type = [
    {
        id:0,
        text:'<div class="select2placeholder">select email address</div>',
        title:'Select email'
    },
    {
        id:1,
        text:'<div class="select2text">noreply@leadpops.com</div>',
        title:'noreply@leadpops.com'
    },
    {
        id:2,
        text:'<div class="addNew"><i class="ico ico-plus"></i>Add New Email Address</div>',
        title:'Add New Email Address'
    }
];
var grabCode = {
    initCustomSelect: function() {
        var amIclosing = false;
        // funnel type
        jQuery('.email-select').select2({
            data: email_type,
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".email-select__parent"),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
            width: '100%'
        }).on('change',function () {
            console.log($(this).val());
            if ($(this).val() == 2) {
                jQuery('.el-tooltip').tooltipster('enable');
                jQuery(this).parents('.modal-body').find('.subject-field').attr('disabled', true);
            }else {
                jQuery('.el-tooltip').tooltipster('disable');
                jQuery(this).parents('.modal-body').find('.subject-field').attr('disabled', false);
            }
        }).on('select2:open', function () {
            jQuery('.email-select__parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function () {
                jQuery('.email-select__parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.email-select__parent .select2-dropdown').hide();
            jQuery('.email-select__parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.email-select__parent .select2-selection__rendered').hide();
        }).on('select2:closing', function (e) {
            if (!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.email-select__parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.email-select').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function () {
            jQuery('.email-select__parent .select2-selection__rendered').show();
            jQuery('.email-select__parent .select2-results__options').css('pointer-events', 'none');
        }).select2('val', $('.email-select option:eq(1)').val());
    },

    /*
       ** Modal callbacks function
    **/

    modal_callbacks: function () {
        jQuery('#code-modal').on('shown.bs.modal', function () {
            jQuery('.modal-code-row__email-detail').find('#sender-name').focus();
        });

        jQuery('#login-modal').on('shown.bs.modal', function () {
            jQuery('.modal-content').find('#login-url').focus();
        });
    },


    init: function () {
        grabCode.initCustomSelect();
        grabCode.modal_callbacks();
    },
}

jQuery(document).ready(function () {
    grabCode.init();
});
