var slider_content = {
    /**
     ** range slider single value
     **/
    rangeSlider: function() {
        let onePuckSlider = jQuery("[data-slider-one-puck]");
        if(onePuckSlider.length) {
            onePuckSlider.data("slider-min", slider.getMinRangeValue())
                .data("slider-max", slider.getMaxRangeValue());
            onePuckSlider.slider({
                formatter: function (index) {
                    slider.setOnePuckFormattedValue(index);
                    return index;
                },
                step: 1,
                min: 0,
                value: slider.getInitialValue(),
                max: slider.getMaxRangeCount()
            }).trigger('change');
        }
    },


    /**
     * to handle hide until not answered functionality
     * @param is_validated
     */
    handleHideUntilNotAnswered: function (is_validated=true) {
        let is_hide_until_not_answered = json['options']['cta-button-settings']['enable-hide-until-answer'];
        //when enable-hide-until-answer is enabled than hide button until user not answered question
        if(is_hide_until_not_answered) {
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered, is_validated);
        } else {
            FunnelsPreview.hideUntilNotAnswered(is_hide_until_not_answered);
        }
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
    ** init Function
    **/
    init: function() {
        jQuery.fn.digits = function(){
            return this.each(function(){
                jQuery(this).text( jQuery(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
            });
        };
        FunnelsUtil.setSliderValue();
        slider_content.rangeSlider();
        FunnelsUtil.twoPuckSlider();
        slider_content.addclass();
        slider.setLabels();
    }
};
