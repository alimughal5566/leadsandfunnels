var slider_content = {
    slider_values: [
        '$80,000 or less',
        '$80,000 to $100,000',
        '$100,000 to $120,000',
        '$120,00 to $140,000',
        '$140,000 to $160,000',
        '$160,000 to $180,000',
        'Over $2,000,000'
    ],

    /**
     ** range slider single value
     **/
    rangeSlider: function() {
        jQuery("#range_slider").bootstrapSlider({
            formatter: function(index) {
                jQuery("#current_val").text(slider_content.slider_values[index]);
                return  index;
            },
            step: 1, min: 0, max: slider_content.slider_values.length - 1
        });
    },

    /**
     ** range slider double value function
     **/
    multiRangeSlider: function() {
        var lpslider = jQuery("#range_slider_multiple").slider({
            formatter: function(index) {
                return index;
            },
        });
        jQuery(".oldValue").text('$' + '1.4M').digits();
        lpslider.on('change',function(obj, newobj) {
            if(newobj) {
                obj = newobj            }

            var second_value = obj.value.newValue[1];
            jQuery(".newValue").text('$' + obj.value.newValue[0]).digits();
            if(second_value >= 1000000) {
                var v = (second_value / 1000000).toFixed(1) + 'M'
                jQuery(".oldValue").text('$' + v).digits();
            } else {}
            jQuery(".oldValue").text('$' + second_value).digits();

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
    ** init Function
    **/

    init: function() {
        jQuery.fn.digits = function(){
            return this.each(function(){
                jQuery(this).text( jQuery(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
            });
        };
        slider_content.rangeSlider();
        slider_content.multiRangeSlider();
        slider_content.addclass();
    },
};

jQuery(document).ready(function() {
    slider_content.init();
});

