var dropdown_overlay = {

    /*
    ** Menu Group Function
    **/

    menugroup: function () {

        $('.organize-group__list').sortable({
            placeholder: "fb-options__highlight",
            scroll: true,
            axis: "y",
            handle: ".organize-group__action",
            start:function(){
                $('.fb-options__highlight').text('Drop Your Element Here');
            }
        });

        $(document).on('click' , '.lp-btn_add-option', function(e){
            e.preventDefault();
            var cloned = $(this).parents('.fb-options').find('.fb-options__list:last-child').clone();
            if (cloned.find('input').val().length != 0) {
                cloned.find('input').val('').end().hide().appendTo($(this).parents('.fb-options').find('.fb-options__clone')).slideDown(function () {cloned.find('input').focus()});
            }else {
                $(this).parents('.fb-options').find('.fb-options__list:last-child input').focus();
            }
        });

        $(document).on('keypress' , '.fb-options__clone input', function(e){
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if(keycode == '13'){
                if($(this).val().length != '') {
                    $('.lp-btn_add-option').trigger('click');
                }
            }
        });

        var html_menu_group ="<div class=\"fb-options__group-clone\">\n" +
            "                            <div class=\"grouping-label\">Group 1</div>\n" +
            "                            <div class=\"group-head\">\n" +
            "                                <div class=\"fb-form__group\">\n" +
            "                                    <input type=\"text\" class=\"form-control fb-form-control\">\n" +
            "                                    <span class=\"tag-box\">\n" +
            "                                        <i class=\"fas fa-folder-open\"></i>\n" +
            "                                </span>\n" +
            "                                </div>\n" +
            "                                <div class=\"fb-options__col\">\n" +
            "                                    <a href=\"#\" class=\"fb-options__delete remove-group\">\n" +
            "                                        <i class=\"ico ico-cross\"></i>\n" +
            "                                    </a>\n" +
            "                                </div>\n" +
            "                            </div>\n" +
            "                            <div class=\"fb-options__clone\">\n" +
            "                                <div class=\"fb-options__list\">\n" +
            "                                    <div class=\"fb-options__col fb-options__col_field\">\n" +
            "                                        <input type=\"text\" class=\"form-control fb-form-control\">\n" +
            "                                    </div>\n" +
            "                                    <div class=\"fb-options__col fb-options__col_handler\">\n" +
            "                                        <span class=\"tag-box tag-box_move tag-box_lg\">\n" +
            "                                            <i class=\"ico ico-dragging\"></i>\n" +
            "                                        </span>\n" +
            "                                    </div>\n" +
            "                                    <div class=\"fb-options__col\">\n" +
            "                                        <a href=\"#\" class=\"fb-options__delete\">\n" +
            "                                            <span class=\"tag-box tag-box_lg\">\n" +
            "                                                <i class=\"ico ico-cross\"></i>\n" +
            "                                            </span>\n" +
            "                                        </a>\n" +
            "                                    </div>\n" +
            "                                </div>\n" +
            "                            </div>\n" +
            "                            <div class=\"fb-options__add-more\">\n" +
            "                                <a href=\"#\" class=\"lp-btn lp-btn_add-option\">\n" +
            "                                    <span class=\"lp-btn__icon\">\n" +
            "                                        <i class=\"ico ico-plus\"></i>\n" +
            "                                    </span>\n" +
            "                                    Add New Option\n" +
            "                                </a>\n" +
            "                            </div>\n" +
            "                        </div>";
        var html_drop_down_group ="<div class=\"fb-options__group-clone\">\n" +
            "                            <div class=\"grouping-label\">Group 1</div>\n" +
            "                            <div class=\"group-head\">\n" +
            "                                <div class=\"fb-form__group\">\n" +
            "                                    <input type=\"text\" class=\"form-control fb-form-control\">\n" +
            "                                    <span class=\"tag-box\">\n" +
            "                                        <i class=\"fas fa-folder-open\"></i>\n" +
            "                                </span>\n" +
            "                                </div>\n" +
            "                                <div class=\"fb-options__col\">\n" +
            "                                    <a href=\"#\" class=\"fb-options__delete remove-group\">\n" +
            "                                        <i class=\"ico ico-cross\"></i>\n" +
            "                                    </a>\n" +
            "                                </div>\n" +
            "                            </div>\n" +
            "                            <div class=\"fb-options__clone\">\n" +
            "                                 <textarea name=\"\" id=\"\" class=\"form-control fb-textarea fb-textarea_option\" placeholder=\"Type in or paste your menu entries&nbsp;here (separated&nbsp;by&nbsp;line&nbsp;break)\"></textarea>\n"+
            "                            </div>\n" +
            "                        </div>";

        $('.lp-btn_add-option_group').click(function(e){
            e.preventDefault();
            if($(this).hasClass('lp-btn_drop-down')) {
                $(this).parents().find('.fb-modal__row_creat-group').before(html_drop_down_group);
            }else {
                $(this).parents().find('.fb-modal__row_creat-group').before(html_menu_group);
            }
            group_label();
        });

        $(document).on('click' , '.fb-options__delete', function(e){
            e.preventDefault();
            if($(this).parents('.fb-options').find('.fb-options__list').length > 1){
                $(this).parents('.fb-options__list').slideUp(function () {
                    $(this).remove();
                });
            }
            if($(this).hasClass('remove-group')) {
                $(this).parents('.group-head').parent('.fb-options__group-clone').slideUp();
                group_label();
            }
        });

        function contact_form_label() {
            var increment = 1;
            $('.contact-from-label').each(function(){
                $(this).text('input '+increment);
                increment++;
            });
        }

        function group_label() {
            var increment = 1;
            $('.grouping-label').each(function(){
                $(this).text('Group '+increment);
                increment++;
            });
            if ($('.fb-options').find('.fb-options__group-clone').length > 1) {
                $('.lp-btn_add-option_organize').css('display','flex');
            }else {
                $('.lp-btn_add-option_organize').hide();
            }
        }

        $('#create-group').change(function () {
            if($(this).is(':checked')){
                $('.normal-option').slideUp();
                $('.group-option').slideDown();
            } else {
                $('.group-option').slideUp();
                $('.normal-option').slideDown();
            }
        });
    },

    /*
    ** init Function
    **/

    init: function() {
        dropdown_overlay.menugroup();
    },
};

jQuery(document).ready(function() {
    FBEditor.init();
    InputControls.init();
    FunnelActions.saveFunnelInDB();
    InputControls.setIconSecurityDropdown();
});

