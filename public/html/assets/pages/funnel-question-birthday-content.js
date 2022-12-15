var birthday_content = {

    /*
    ** Iframe custom scroll Function
    **/

    iframe_custom_scroll: function() {

        if(jQuery('.scroll-bar').length > 0) {
            jQuery('.scroll-bar').mCustomScrollbar({
                axis: "y",
            });
        }
    },

    /*
    ** Single Select DropDown Question function
    **/

    single_select_dropdown: function() {
        jQuery('.field-opener').click(function(e){
            e.preventDefault();
            jQuery('.field-holder').removeClass('select-active');
            jQuery(this).parent().addClass('select-active');
        });

        jQuery(document).on('click' , '.list-options a', function(e){
           e.preventDefault();
           var getText = jQuery(this).html();
           jQuery(this).parents('.field-holder').removeClass('select-active');
           jQuery(this).parents('.field-holder').find('.selected_text').html(getText);
           jQuery(this).parents('.list-options').find('active').removeClass('active');
           jQuery('.list-options a').removeClass('active');
           jQuery(this).addClass('active');
           jQuery(this).parents('.field-holder').find('.field-opener').addClass('field-active');
        });
    },


    /*
    ** Outside click Function
    **/

    outsideclick: function () {
        jQuery(document).click(function(e) {
            var target = e.target;

            if (jQuery('.field-holder').hasClass('select-active')) {
                if (jQuery(target).parents('.field-holder').length > 0) {
                }
                else {
                    jQuery('.field-holder').removeClass('select-active');
                }
            }
        });
    },

    /*
   ** add Class Function
   **/
    addclass: function() {
        if(jQuery('.cta-btn').width() > 250) {
            jQuery('.cta-btn').addClass('large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('large-btn');
        }

        if(jQuery('.cta-btn').width() > 420) {
            jQuery('.cta-btn').addClass('x-large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('x-large-btn');
        }
    },

    /*
  ** Days Month Function
  **/

    days_month_funcation: function () {
        jQuery(document).on('click' , '.month-holder .list-options a', function(){
            var month = jQuery(this).attr('data-title');
            var year = new Date().getFullYear();
            var total = new Date(year, month, 0).getDate();
            jQuery('.days-holder .list-options').html('');
            var text = '';
            for (var i = 1; i <= total; i++) {
                text += "<li><a href='#'>"+ i + "</li></a>";
            }
            jQuery('.days-holder .list-options').html(text);
        });
    },

    /*
    ** init Function
    **/

    init: function() {
        birthday_content.iframe_custom_scroll();
        birthday_content.single_select_dropdown();
        birthday_content.outsideclick();
        birthday_content.addclass();
        birthday_content.days_month_funcation();
    },
};

jQuery(document).ready(function() {
    birthday_content.init();
});

