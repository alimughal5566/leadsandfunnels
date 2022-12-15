var birthday_content = {

    /*
    ** Iframe custom scroll Function
    **/

    iframe_custom_scroll: function() {

        if(jQuery('.scroll-bar').length > 0) {
            jQuery('.scroll-bar').mCustomScrollbar({
                axis: "y",
                scrollInertia: 500,
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
            if(jQuery('.mobile-preview').hasClass('mobile-view')) {
                jQuery('.funnel-iframe-inner-holder').mCustomScrollbar("scrollTo","top",{
                    scrollInertia: 100
                });
                setTimeout(function () {
                    jQuery('.funnel-iframe-inner-holder').addClass('dropdown-active');
                },300);
            }

            // Add this Function for move the scroll accroding to the active item
            var _self = jQuery(this);
            var _length = _self.parent('.field-holder').find('.list-options a.active').length;

            if (_length > 0) {
                setTimeout(function () {
                    var getindex = _self.parent('.field-holder').find('.list-options a.active').parent().index();
                    var item_height = _self.parent('.field-holder').find('.list-options > li').height();
                    var defaultHeight = item_height;
                    var scrolledArea = getindex * defaultHeight;
                    jQuery('.scroll-bar').mCustomScrollbar('scrollTo', scrolledArea, {
                        scrollInertia: 500
                    });
                }, 200);
            }
        });

        jQuery(document).on('click' , '.list-options a', function(e){
           e.preventDefault();
           var getText = jQuery(this).html();
           jQuery(this).parents('.field-holder').removeClass('select-active');
           jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
           jQuery(this).parents('.field-holder').find('.selected_text').html(getText);
           jQuery(this).parents('.list-options').find('active').removeClass('active');
           jQuery('.list-options a').removeClass('active');
           jQuery(this).addClass('active');
           jQuery(this).parents('.field-holder').find('.field-opener').addClass('field-active');
           birthday_content.showMinimumAgeError();
           birthday_content.handleHideUntilNotAnswered();
        });

        jQuery('.icon-cancel').click(function(e){
            e.preventDefault();
            jQuery(this).parents('.field-holder').removeClass('select-active');
            jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
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
                    jQuery('.funnel-iframe-inner-holder').removeClass('dropdown-active');
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

        if(jQuery('.cta-btn').width() > 550) {
            jQuery('.cta-btn').addClass('xx-large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('xx-large-btn');
        }

        if(jQuery('.cta-btn').width() > 650) {
            jQuery('.cta-btn').addClass('xxx-large-btn');
        }
        else {
            jQuery('.cta-btn').removeClass('xxx-large-btn');
        }
    },

    /*
   ** Days Year Function
   **/
    days_year_function: function (){
        jQuery(document).on('click' , '.year-holder .list-options a', function(){
            var year = jQuery(this).attr('data-title');
            var month = $('.month-holder .selected_text').text();

            var leap_year = (year % 100 === 0) ? (year % 400 === 0) : (year % 4 === 0);
            if(leap_year && month == 'February'){
                var total = new Date(year, 2, 0).getDate();
                jQuery('.days-holder .list-options').html('');
                var text = '';
                for (var i = 1; i <= total; i++) {
                    text += "<li><a href='#'>"+ i + "</li></a>";
                }
                jQuery('.days-holder .list-options').html(text);

                birthday_content.previosSelectedDate(total);
            }
        });
    },

    /*
  ** Days Month Function
  **/

    days_month_funcation: function () {
        jQuery(document).on('click' , '.month-holder .list-options a', function(){
            var month = jQuery(this).attr('data-title');
            var year = new Date().getFullYear();
            if($('.year-holder .selected_text').text()  !='')
            {
                year = $('.year-holder .selected_text').text();
            }
            var total = new Date(year, month, 0).getDate();

            jQuery('.days-holder .list-options').html('');
            var text = '';
            for (var i = 1; i <= total; i++) {
                text += "<li><a href='#'>"+ i + "</li></a>";
            }
            jQuery('.days-holder .list-options').html(text);
            birthday_content.previosSelectedDate(total);
        });
    },


    /**
     * Previous selected date
     */
    previosSelectedDate: function (total){
        // if selected date is greater than month's maximum date
        let selected_date = $('.days-holder').find('.selected_text').html();
        if (Number(selected_date) > total) {
            $('.days-holder').find('.selected_text').html(total);
            $('.days-holder .list-options li').eq(selected_date-1).find('a').addClass('active')
        }else  if(Number(selected_date) > 0){
            $('.days-holder .list-options li').eq(selected_date-1).find('a').addClass('active')
        }
    },

    /**
     * Get years list based on how many years needs to go back
     * @param years_back
     * @param minimum_age
     * @returns {string}
     */
    getYearsList: function (years_back, minimum_age) {
        var year = new Date().getFullYear();
        year = year - minimum_age;
        var years = '';

        for (let i=0; i <= years_back; i++) {
            var year_used = year - i;
            years+='<li><a href="#" data-title="'+year_used+'">'+year_used+'</a></li>';
        }

        return years;
    },

    /**
     * Show minimum age error
     */
    showMinimumAgeError: function () {
        $('[data-error-msg]').html('');
        let month = '', date = '', year = '';

        $(".selected_text").each(function(i, obj){
            if (i == 0) {
               month = $(this).html();
            } else if (i == 1) {
                date = $(this).html();
            } else if (i == 2) {
                year = $(this).html();
            }
        });

        if (month != '' && date != '' && year != '') {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            dt1 = new Date(month+" "+date+", "+year+" 00:00:00");

            let maximum_date = new Date(),
                minimum_age = parseInt(json['options']['minimum-age']);

            if(minimum_age) {
                maximum_date.setFullYear(maximum_date.getFullYear() - minimum_age);
            }

            if(dt1.getTime() > maximum_date.getTime()) {
                $('[data-error-msg]').html('Your selected birthday is less than minimum required age');
            }
        }
    },

    /**
     * Difference in years between two dates
     * @param dt2
     * @param dt1
     * @returns {number}
     */
    diff_years: function(dt2, dt1)
    {
        var diff =(dt2.getTime() - dt1.getTime()) / 1000;
        diff /= (60 * 60 * 24);

        return Math.abs(Math.round(diff/365.25));
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
        birthday_content.days_year_function();
    },

    handleHideUntilNotAnswered: function () {
        let is_hide_until_not_answered = json['options']['cta-button-settings']['enable-hide-until-answer'];
        //when enable-hide-until-answer is enabled than hide button until user not answered question
        if(is_hide_until_not_answered) {
            let month = jQuery(".month-holder .selected_text").html(),
                day = jQuery(".day-holder .selected_text").html(),
                year = jQuery(".year-holder .selected_text").html();

            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered, (month != "" && day != "" && year != ""));
        } else {
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered);
        }
    }
};

jQuery(document).ready(function() {
    birthday_content.init();
});

