$(document).ready(function () {

    var amIclosing = false;

    //*
    // ** icon setting toggle
    // *

    $('#message-icon').change(function () {
        if($(this).is(':checked')) {
            $('.icon-setting').slideDown();
        }else {
            $('.icon-setting').slideUp();
        }
    });

    $('.txt-cta-italic').click(function () {
        $(this).toggleClass('active');
    });

    $('.txt-cta-bold').click(function () {
        $(this).toggleClass('active');
    });

    //*
    // ** icon size range slider
    // *

    $('#ex1').bootstrapSlider({
        formatter: function(value) {
            $('#iconsize').val(value);
            // $(".button-pop").css('font-size', value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('#iconsize').val(),
        tooltip: 'hide',
        // tooltip_position:'bottom',
    });

    //*
    // ** icon align
    // *

    $('#select2js__icon-position').select2({
        minimumResultsForSearch: -1,
        width: '173px', // need to override the changed default
        dropdownParent: $('.select2js__icon-position-parent')
    }).on('select2:openning', function() {
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__icon-position-parent .select2-dropdown').hide();
        jQuery('.select2js__icon-position-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__icon-position-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#select2js__icon-position').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').show();
        jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'none');
    });


    //*
    // ** color picker click event
    // *

    $('#clr-text').click(function () {
        var name = ".security-text-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#clr-icon').click(function () {
        var name = ".security-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#text-clr').ColorPicker({
        color: "#b4bbbc",
        flat: true,
        opacity:true,
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
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".security-text-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".security-text-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".security-text-clr .color-box__b .color-box__rgb").val(rgb.b);
            $('.security-text-clr .color-opacity').val(rgba.a)
            $(".security-text-clr .color-box__hex-block").val('#'+hex);
            $('#clr-text').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#clr-text').find('.last-selected__code').text('#'+hex);

        }
    });
    $('#icon-clr').ColorPicker({
        color: "#24b928",
        flat: true,
        opacity:true,
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
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".security-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".security-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".security-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $('.security-icon-clr .color-opacity').val(rgba.a)
            $(".security-icon-clr .color-box__hex-block").val('#'+hex);
            $('#clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });


    //*
    // ** add icon
    // *

    var obj_fontawsome = [
        "ico-lock-1",
        "ico-lock-2",
        "ico-lock-3",
        "ico-lock-5",
        "ico-lock-4",
        "ico-shield-1",
        "ico-shield-2",
        "ico-shield-3",
        "ico-shield-4",
        "ico-shield-5",
    ];

    function fontAwsome() {
        $('.icon__wrapper').html('');
        $.each(obj_fontawsome,function (index,value) {
            $('.icon-wrapper').append('<li><i class="ico '+value+'"></i></li>');
        });
    }
    fontAwsome();

    var $fontAsome;


    $('.btn-icon-wrapper').click(function () {
        $('#icon-picker').modal('show');
        // $('#removeicon').parent().hide();
        var icon_class = $(this).find('i').attr('class');
        if(icon_class) {
            var new_icon =  icon_class.replace(/ /g, ".");
            var icon_exist = $('.icon-wrapper').find('.' +new_icon);
            if(icon_exist){
                $($(icon_exist)[0]).parent().addClass('active');
            }
            if ($('.icon-wrapper li ').hasClass('active')){
                // $('#removeicon').parent().show();
            }
        }
    });

    $('.btn-cancel-icon').click(function () {
        $('#icon-picker').modal('hide');
        $('.icon-wrapper li').removeClass('active');
    });

    $('body').on('click','.icon-wrapper li', function(){
        $('.icon-wrapper li').removeClass('active');
        $(this).addClass('active');
        $fontAsome = $(this).html();
    });

    $('.btn-add-icon').click(function () {
        $('.btn-icon-wrapper .icon-block').html('');
        $('.btn-icon-wrapper .icon-block').html($fontAsome);
        $('#icon-picker').modal('toggle');
    });


});

$(document).on('keyup',"#security-icon-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    if(rgb) {
        var value = $('.security-icon-clr .color-opacity').val();
        var $this_elm = $(this).parents('.footer-background-clr');
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".security-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".security-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".security-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#clr-icon .last-selected__code').text($(this).val());
        $("#icon-clr").ColorPickerSetColor($(this).val());
    }
});

$(document).on('keyup',"#security-text-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    console.info('rgba' + rgb);
    if(rgb) {
        var value = $('.security-text-clr .color-opacity').val();
        var $this_elm = $(this).parents('.security-text-clr');
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        console.info(rgba_fn);
        $(".security-text-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".security-text-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".security-text-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#clr-text').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#clr-text .last-selected__code').text($(this).val());
        $("#text-clr").ColorPickerSetColor($(this).val());
    }
});