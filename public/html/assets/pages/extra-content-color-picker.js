var color_picker = {

    hexToRgb: function (hex){
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    },

    /*
        ** Color Picker Styles
     */
    colorSwatchInit: function () {
        $(".ex-content__label-color-parent").click(function () {
            event.stopPropagation();
            $(".color-box__panel-wrapper:not(.ex-content__label-color)").hide();
            var window_height = $(window).height();
            var select_button = $(this).offset();
            var select_dropdown = $('.color-box__panel-wrapper').height();
            var select_total = select_button.top + select_dropdown;
            $(".color-box__panel-wrapper.ex-content__label-color").toggle();
            if (window_height < select_total) {
                $('.color-box__panel-wrapper.ex-content__label-color').addClass("up").removeClass('down');
                $(".color-box__panel-wrapper.ex-content__label-color").offset({
                    top: select_button.top - select_dropdown - 47,
                    left: select_button.left - 280
                });
            }
            else {
                $('.color-box__panel-wrapper.ex-content__label-color').addClass("down").removeClass('up');
                $(".color-box__panel-wrapper.ex-content__label-color").offset({
                    top: select_button.top + 47,
                    left: select_button.left - 280
                });
            }
        });

        $("#ex-content__label-color").ColorPicker({
            color: "#4822c5",
            flat: true,
            opacity: true,
            width: 203,
            height: 144,
            outer_height: 162,
            outer_width: 281,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(100);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(100);
                return false;
            },
            onChange: function (hsb, hex, rgb, rgba) {
                var rgba_fn = 'rgba(' + rgba.r + ', ' + rgba.g + ', ' + rgba.b + ', ' + rgba.a + ')';
                $(".ex-content__label-color .color-box__r .color-box__rgb").val(rgb.r);
                $(".ex-content__label-color .color-box__g .color-box__rgb").val(rgb.g);
                $(".ex-content__label-color .color-box__b .color-box__rgb").val(rgb.b);
                $(".ex-content__label-color .color-box__hex-block").val('#' + hex);
                $('.ex-content__label-color-parent').find('.ex-content__last-selected').css('background-color', rgba_fn);
                $('.ex-content__label-color-parent').find('.ex-content__last-code').text('#' + hex);
                $('.ex-content__label-color .color-opacity').val(Math.ceil((rgba.a * 100)));
                /*$('.button-cta').css('backgroundColor', rgba_fn);*/
            }
        });

        $(document).on('keyup', "#ex-content__background-trigger", function () {
            var rgb = color_picker.hexToRgb($(this).val());
            console.log(rgb);
            if (rgb) {
                var value = $('.ex-content__label-color .color-opacity').val();
                var $this_elm = $(this).parents('.ex-content__label-color');
                var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ',' + value / 100 + ')';
                $(".ex-content__label-color .color-box__r .color-box__rgb").val(rgb.r);
                $(".ex-content__label-color .color-box__g .color-box__rgb").val(rgb.g);
                $(".ex-content__label-color .color-box__b .color-box__rgb").val(rgb.b);
                $('.ex-content__label-color-parent').find('.ex-content__last-selected').css('background-color', rgba_fn);
                $('.ex-content__label-color-parent .ex-content__last-code').text($(this).val());
                $("#ex-content__label-color").ColorPickerSetColor($(this).val());
            }
        });


        $(".ex-content__strip-color-parent").click(function () {
            event.stopPropagation();
            $(".color-box__panel-wrapper:not(.ex-content__strip-color)").hide();
            var window_height = $(window).height();
            var select_button = $(this).offset();
            var select_dropdown = $('.color-box__panel-wrapper').height();
            var select_total = select_button.top + select_dropdown;
            $(".color-box__panel-wrapper.ex-content__strip-color").toggle();
            if (window_height < select_total) {
                $('.color-box__panel-wrapper.ex-content__strip-color').addClass("up").removeClass('down');
                $(".color-box__panel-wrapper.ex-content__strip-color").offset({
                    top: select_button.top - select_dropdown - 47,
                    left: select_button.left - 280
                });
            }
            else {
                $('.color-box__panel-wrapper.ex-content__strip-color').addClass("down").removeClass('up');
                $(".color-box__panel-wrapper.ex-content__strip-color").offset({
                    top: select_button.top + 47,
                    left: select_button.left - 280
                });
            }
        });

        $("#ex-content__strip-color").ColorPicker({
            color: "#4822c5",
            flat: true,
            opacity: true,
            width: 203,
            height: 144,
            outer_height: 162,
            outer_width: 281,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(100);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(100);
                return false;
            },
            onChange: function (hsb, hex, rgb, rgba) {
                var rgba_fn = 'rgba(' + rgba.r + ', ' + rgba.g + ', ' + rgba.b + ', ' + rgba.a + ')';
                $(".ex-content__strip-color .color-box__r .color-box__rgb").val(rgb.r);
                $(".ex-content__strip-color .color-box__g .color-box__rgb").val(rgb.g);
                $(".ex-content__strip-color .color-box__b .color-box__rgb").val(rgb.b);
                $(".ex-content__strip-color .color-box__hex-block").val('#' + hex);
                $('.ex-content__strip-color-parent').find('.ex-content__last-selected').css('background-color', rgba_fn);
                $('.ex-content__strip-color-parent').find('.ex-content__last-code').text('#' + hex);
                $('.ex-content__strip-color .color-opacity').val(Math.ceil((rgba.a * 100)));
                /*$('.button-cta').css('backgroundColor', rgba_fn);*/
            }
        });

        $(document).on('keyup', "#ex-content__strip-trigger", function () {
            var rgb = color_picker.hexToRgb($(this).val());
            console.log(rgb);
            if (rgb) {
                var value = $('.ex-content__strip-color .color-opacity').val();
                var $this_elm = $(this).parents('.ex-content__strip-color');
                var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ',' + value / 100 + ')';
                $(".ex-content__strip-color .color-box__r .color-box__rgb").val(rgb.r);
                $(".ex-content__strip-color .color-box__g .color-box__rgb").val(rgb.g);
                $(".ex-content__strip-color .color-box__b .color-box__rgb").val(rgb.b);
                $('.ex-content__strip-color-parent').find('.ex-content__last-selected').css('background-color', rgba_fn);
                $('.ex-content__strip-color-parent .ex-content__last-code').text($(this).val());
                $("#ex-content__strip-color").ColorPickerSetColor($(this).val());
            }
        });


        $(".ex-content__icon-color-parent").click(function () {
            event.stopPropagation();
            $(".color-box__panel-wrapper:not(.ex-content__icon-color)").hide();
            var window_height = $(window).height();
            var select_button = $(this).offset();
            var select_dropdown = $('.color-box__panel-wrapper').height();
            var select_total = select_button.top + select_dropdown;
            $(".color-box__panel-wrapper.ex-content__icon-color").toggle();
            if (window_height < select_total) {
                $('.color-box__panel-wrapper.ex-content__icon-color').addClass("up").removeClass('down');
                $(".color-box__panel-wrapper.ex-content__icon-color").offset({
                    top: select_button.top - select_dropdown - 42,
                    left: select_button.left - 180
                });
            }
            else {
                $('.color-box__panel-wrapper.ex-content__icon-color').addClass("down").removeClass('up');
                $(".color-box__panel-wrapper.ex-content__icon-color").offset({
                    top: select_button.top + 42,
                    left: select_button.left - 180
                });
            }
        });

        $("#ex-content__icon-color").ColorPicker({
            color: "#4822c5",
            flat: true,
            opacity: true,
            width: 203,
            height: 144,
            outer_height: 162,
            outer_width: 281,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(100);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(100);
                return false;
            },
            onChange: function (hsb, hex, rgb, rgba) {
                var rgba_fn = 'rgba(' + rgba.r + ', ' + rgba.g + ', ' + rgba.b + ', ' + rgba.a + ')';
                $(".ex-content__icon-color .color-box__r .color-box__rgb").val(rgb.r);
                $(".ex-content__icon-color .color-box__g .color-box__rgb").val(rgb.g);
                $(".ex-content__icon-color .color-box__b .color-box__rgb").val(rgb.b);
                $(".ex-content__icon-color .color-box__hex-block").val('#' + hex);
                $('.ex-content__icon-color-parent').find('.ex-content__last-selected').css('background-color', rgba_fn);
                $('.ex-content__icon-color-parent').find('.ex-content__last-code').text('#' + hex);
                $('.ex-content__icon-color .color-opacity').val(Math.ceil((rgba.a * 100)));
                /*$('.button-cta').css('backgroundColor', rgba_fn);*/
            }
        });

        $(document).on('keyup', "#ex-content__icon-trigger", function () {
            var rgb = color_picker.hexToRgb($(this).val());
            console.log(rgb);
            if (rgb) {
                var value = $('.ex-content__icon-color .color-opacity').val();
                var $this_elm = $(this).parents('.ex-content__icon-color');
                var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ',' + value / 100 + ')';
                $(".ex-content__icon-color .color-box__r .color-box__rgb").val(rgb.r);
                $(".ex-content__icon-color .color-box__g .color-box__rgb").val(rgb.g);
                $(".ex-content__icon-color .color-box__b .color-box__rgb").val(rgb.b);
                $('.ex-content__icon-color-parent').find('.ex-content__last-selected').css('background-color', rgba_fn);
                $('.ex-content__icon-color-parent .ex-content__last-code').text($(this).val());
                $("#ex-content__icon-color").ColorPickerSetColor($(this).val());
            }
        });
    },

    init: function() {
        color_picker.colorSwatchInit();
    },
};

jQuery(document).ready(function() {
    color_picker.init();
});

/*
* outsideClick function
* */
$(document).click(function(e) {
    var container = $(".pull-clr__wrapper,.color-box__panel-wrapper");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
        $('.last-selected').removeClass('up down');
    }
});