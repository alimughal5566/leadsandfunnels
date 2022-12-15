jQuery(document).ready(function () {
    var amIclosing = false;
    //*
    // ** icon size range slider
    // *
    let securityIconSlider = $('.security-icon-size-parent').bootstrapSlider({
        formatter: function(value) {
            $('.security-icon-size').val(value);
            return   value +'px';
        },
        min: 12,
        max: 50,
        value: $('.security-icon-size').val(),
        tooltip: 'always',
        tooltip_position:'bottom',
    });


    /**
     * TODO: cleanup, this code will be removed
    securityIconSlider.on('slideStop', function (event) {
        InputControls.updatedSecurityMessage('icon');
    });*/

    jQuery('.icon-size-reset').click(function(){
        let defaults = securityMessage.getDefaultMessage();
        jQuery('.security-icon-size').val(defaults.icon.size);
        jQuery('.security-icon-size-parent').bootstrapSlider('setValue', defaults.icon.size).trigger("change");
        // InputControls.updatedSecurityMessage('icon');
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

    $('#clr-icon').click(function () {
        var name = ".security-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    let txtColorEl = jQuery('#clr-text');
    txtColorEl.ColorPicker({
        flat:true,
        opacity:true,
        auto_show:false,
        onChange: function (hsb, hex, rgb, rgba) {
            let rgba_fn = lpUtilities.getRGBAString(rgba);
            txtColorEl.find('.last-selected__box').css('backgroundColor', rgba_fn);
            txtColorEl.find('.last-selected__code').text('#'+hex);
            txtColorEl.find('.custom-color-value').val(rgba_fn).trigger('change');
        },
        onShow: function () {
          $('#clr-text').parent().addClass('color-picker-active');
        },
        onHide: function () {
          $('#clr-text').parent().removeClass('color-picker-active');
        },
    });

    let icoColorEl = jQuery('#clr-icon');
    icoColorEl.ColorPicker({
        flat:true,
        opacity:true,
        auto_show:false,
        onChange: function (hsb, hex, rgb, rgba) {
            let rgba_fn = lpUtilities.getRGBAString(rgba);
            icoColorEl.find('.last-selected__box').css('backgroundColor', rgba_fn);
            icoColorEl.find('.last-selected__code').text('#'+hex);
            icoColorEl.find('.custom-color-value').val(rgba_fn).trigger('change');
        },
        onShow: function () {
          $('#clr-icon').parent().addClass('color-picker-active');
        },
        onHide: function () {
          $('#clr-icon').parent().removeClass('color-picker-active');
        },
    });


    $('.message-icon').change(function () {
        if($(this).is(':checked')) {
            $('.icon-setting').slideDown();
            $('body').addClass('security-text-color-active');
            $('body').removeClass('security-text-color-active-without-scroll');
        }else {
            $('.icon-setting').slideUp();
            $('body').removeClass('security-text-color-active');
            $('body').addClass('security-text-color-active-without-scroll');
        }
    });

    $('.txt-cta-italic').click(function () {
        $(this).toggleClass('active');
        if(jQuery(this).hasClass('active')){
            $(".form-group_security-message .form-control").css({
                'font-style': 'italic',
            });
            $('#cta-text-itelic-form-field').val('itelic').trigger('change');
        }
        else {
            $(".form-group_security-message .form-control").css({
                'font-style': 'normal',
            });
            $('#cta-text-itelic-form-field').val('none').trigger('change');
        }
    });

    $('.txt-cta-bold').click(function () {
        $(this).toggleClass('active');
        if(jQuery(this).hasClass('active')){
            $(".form-group_security-message .form-control").css({
                'font-weight': '700',
            });
            $('#cta-text-bold-form-field').val('active').trigger('change');
        }
        else {
            $(".form-group_security-message .form-control").css({
                'font-weight': '600',
            });
            $('#cta-text-bold-form-field').val('none').trigger('change');
        }
    });

    //*
    // ** add icon
    // *

    var obj_fontawsome_security = [
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
        $.each(obj_fontawsome_security,function (index,value) {
            $('.icon-wrapper').append('<li class="list-icon-item"><span class="icon-wrap"><i class="ico '+value+'"></i></span></li>');
        });
    }
    fontAwsome();

    var $fontAsome_security;


    $('.btn-icon-wrapper').click(function () {
        $('#icon-picker').modal('show');
        var icon_class = $(this).find('i').attr('class');
        if(icon_class) {
            var new_icon =  icon_class.replace(/ /g, ".");
            var icon_exist = $('.icon-wrapper').find('.' +new_icon);
            if(icon_exist){
                $($(icon_exist)[0]).parents('.icon-wrap').addClass('active');
                $($(icon_exist)[0]).parents('.list-icon-item').addClass('parent-active');
                $('[data-btn-add-security-icon]').attr('data-active-list',$($(icon_exist)[0]).parents('.list-icon-item.parent-active span').html());
            }
        }
    });

    jQuery('#icon-picker').on('hidden.bs.modal', function () {
        $('.icon-wrapper .icon-wrap').removeClass('active');
        $('.icon-wrapper .list-icon-item').removeClass('parent-active');
    });

    $('body').on('click', '.icon-wrapper .icon-wrap', function(){
        $('.icon-wrapper .icon-wrap').removeClass('active');
        $('.icon-wrapper .list-icon-item').removeClass('parent-active');
        $(this).addClass('active');
        $(this).parent('.list-icon-item').addClass('parent-active');
        $fontAsome_security = $(this).html();

        if($fontAsome_security == $('[data-active-list]').attr('data-active-list')) {
            jQuery('.button-primary').prop("disabled", true);
        } else{
            jQuery('.button-primary').prop("disabled", false);
        }
    });

    jQuery('#icon-picker').on('show.bs.modal', function () {
        jQuery('.button-primary').prop("disabled", true);
    });

    $('.btn-add-security-icon').click(function () {
        $('.btn-icon-wrapper .icon-block').html('');
        $('.btn-icon-wrapper .icon-block').html($fontAsome_security);
        $('#icon-picker').modal('hide');
        $('#security-message-modal').modal('show');
        $('#ico-shield-form-field').val($fontAsome_security).trigger('change');
    });

    if(jQuery(".security-modal-body").length > 0) {
        jQuery(".security-modal-body").mCustomScrollbar({
            axis: "y",
            scrollInertia: 500,
            callbacks: {
                whileScrolling: function () {
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.last-selected').removeClass('down up');
                },
                onScroll:function(){
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.last-selected').removeClass('down up');
                },
            },
        });
    }

    if(jQuery('.color-box__panel-wrapper-holder').length > 0) {
        jQuery('.color-box__panel-wrapper-holder').mCustomScrollbar({
            axis: "y",
        });
    }
});
