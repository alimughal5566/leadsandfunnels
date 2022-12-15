const SELECTED_SWATCH_BORDER = '3px solid rgb(44 62 77)';
const SWATCH_BORDER = '3px solid rgb(203 210 212)';

$(document).ready(function () {
    var amIclosing = false;
    const security_message_text = $("#security_message_text");

    iframe_scaling();


    //*
    // ** icon setting toggle
    // *

    $('#message-icon').change(function () {
        if ($(this).is(':checked')) {
            current_security_message.icon.enabled = true;
            $('.icon-setting').slideDown();
        } else {
            current_security_message.icon.enabled = false;
            $('.icon-setting').slideUp();
        }
        adjustIconStyleInPreview();
    });

    $('.txt-cta-italic').click(function () {
        $(this).toggleClass('active');

        // debugger;
        if ($(this).hasClass("active")) {
            current_security_message.tcpa_text_style.is_italic = true;
            $(security_message_text).css("font-style", "italic");
        } else {
            current_security_message.tcpa_text_style.is_italic = false;
            $(security_message_text).css("font-style", "normal");
        }

        adjustTextStyleInPreview();
    });

    $('.txt-cta-bold').click(function () {
        $(this).toggleClass('active');

        if ($(this).hasClass("active")) {
            current_security_message.tcpa_text_style.is_bold = true;
            $(security_message_text).css("font-weight", "bold");
        } else {
            current_security_message.tcpa_text_style.is_bold = false;
            $(security_message_text).css("font-weight", "600");
        }
        adjustTextStyleInPreview();
    });


    //*
    // ** icon size range slider
    // *

    $('#ex1').bootstrapSlider({
        formatter: function (value) {
            $('#iconsize').val(value);
            return value + 'px';
        },
        min: 12,
        max: 50,
        value: $('#iconsize').val(),
        tooltip: 'always',
        tooltip_position: 'bottom',
    }).on('slide change', function () {
        current_security_message.icon.size = $(this).val();
        adjustIconStyleInPreview();
    });


    //*
    // ** icon align
    // *

    $('#select2js__icon-position').select2({
        minimumResultsForSearch: -1,
        width: '173px', // need to override the changed default
        dropdownParent: $('.select2js__icon-position-parent')
    }).on('select2:openning', function () {
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__icon-position-parent .select2-dropdown').hide();
        jQuery('.select2js__icon-position-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__icon-position-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#select2js__icon-position').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').show();
        jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'none');

        var selectedOption = $('#select2js__icon-position').val();
        current_security_message.icon.position = selectedOption;
        adjustIconStyleInPreview()
    });


    //*
    // ** color picker click event
    // *

    // jQuery(document).on("click", ".custom-color-picker", function (e){
    //     $(this).ColorPickerToggle(e);
    // });

    /*$('#clr-text').click(function () {
        var name = ".security-text-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this, name);
        lpUtilities.set_colorpicker_box(color_box_name, get_color);
    });

    $('#clr-icon').click(function () {
        $(this).ColorPickerShow();
        // var name = ".custom.color-box__panel-wrapper";
        // var color_box_name = $(name);
        // var get_color = $(this).find('.last-selected__code').text();
        // lpUtilities.custom_color_picker.call(this, name);
        // lpUtilities.set_colorpicker_box(color_box_name, get_color);
    });*/

    let txtColorEl = jQuery('#clr-text');
    txtColorEl.ColorPicker({
        color: current_security_message.tcpa_text_style.color,
        opacity: true,
        onChange: function (hsb, hex, rgb, rgba) {
            let rgba_fn = lpUtilities.getRGBAString(rgba);
            current_security_message.tcpa_text_style.color = rgba_fn;
            txtColorEl.find('.last-selected__box').css('backgroundColor', rgba_fn);
            txtColorEl.find('.last-selected__code').text("#" + hex);
          //  console.log(current_security_message.tcpa_text_style);
            adjustTextStyleInPreview();
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
        color: current_security_message.icon.color,
        opacity: true,
        onChange: function (hsb, hex, rgb, rgba) {
            let rgba_fn = lpUtilities.getRGBAString(rgba);
            current_security_message.icon.color = rgba_fn;
            icoColorEl.find('.last-selected__box').css('backgroundColor', rgba_fn);
            icoColorEl.find('.last-selected__code').text("#" + hex);
            adjustIconStyleInPreview();
        },
        onShow: function () {
          $('#clr-icon').parent().addClass('color-picker-active');
        },
        onHide: function () {
          $('#clr-icon').parent().removeClass('color-picker-active');
        },
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
        "ico-shield-5"
    ];

    function fontAwsome() {
        $('.icon__wrapper').html('');
        $.each(obj_fontawsome, function (index, value) {
            $('.icon-wrapper').append('<li class="list-icon-item"><span class="icon-wrap"><i class="ico ' + value + '"></i></li>');
        });
    }

    fontAwsome();

    var $fontAsome;
    var $fontAsomeClass;

    $('.btn-icon-wrapper').click(function () {
        $('#icon-picker').modal('show');
        var icon_class = $(this).find('i').attr('class');
        if (icon_class) {
            var new_icon = icon_class.replace(/ /g, ".");
            var icon_exist = $('.icon-wrapper').find('.' + new_icon);
            if (icon_exist) {
                $($(icon_exist)[0]).parents('.icon-wrap').addClass('active');
                $($(icon_exist)[0]).parents('.list-icon-item').addClass('parent-active');
            }
        }
    });

    jQuery('#icon-picker').on('hidden.bs.modal', function () {
        $('.icon-wrapper .icon-wrap').removeClass('active');
        $('.icon-wrapper .list-icon-item').removeClass('parent-active');
    });

    jQuery('#icon-picker').on('show.bs.modal', function () {
        jQuery('.button-primary').prop("disabled", true);
    });

    $('body').on('click', '.icon-wrapper .icon-wrap', function () {
        $('.icon-wrapper .icon-wrap').removeClass('active');
        $('.icon-wrapper .list-icon-item').removeClass('parent-active');
        $(this).addClass('active');
        $(this).parent('.list-icon-item').addClass('parent-active');
        $fontAsomeClass = $(this).find("i").attr("class");
        $fontAsome = $(this).html();
        if(saved_security_message.icon.icon === $fontAsomeClass) {
            jQuery('.button-primary').prop("disabled", true);
        } else {
            jQuery('.button-primary').prop("disabled", false);
        }
    });

    $('.btn-add-icon').click(function () {
        current_security_message.icon.icon = $fontAsomeClass;
        $('.btn-icon-wrapper .icon-block').html('');
        $('.btn-icon-wrapper .icon-block').html($fontAsome);
        $('#icon-picker').modal('toggle');

        adjustIconStyleInPreview();
    });

    jQuery('.security-nav-tab .nav-link').click(function (e) {
        e.preventDefault();
        jQuery('.nav-link').removeClass('active');
        jQuery(this).addClass('active');
        if (jQuery(this).hasClass('security-message-mobile-view')) {
            jQuery('.tcpa-security-preview-iframe-holder').addClass('mobile-view-active');
        }
        else {
            jQuery('.tcpa-security-preview-iframe-holder').removeClass('mobile-view-active');
        }
    });

});

$(document).on('keyup', "#security-icon-clr-trigger", function () {
    var rgb = lpUtilities.hexToRgb($(this).val());
    if (rgb) {
        var value = $('.security-icon-clr .color-opacity').val();
        var $this_elm = $(this).parents('.footer-background-clr');
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ',' + value + ')';
        $(".security-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".security-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".security-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#clr-icon .last-selected__code').text($(this).val());
        $("#icon-clr").ColorPickerSetColor($(this).val());
    }
});

// var preview_module = {
//     funnelInfo: {}
// };

jQuery(document).ready(function () {
    var $form = $("#messages-form");
    ajaxRequestHandler.init("#messages-form",{
        customFieldChangeCb: onChangeStyleHandleButton
    });
    ajaxRequestHandler.setActiveLoadingToastMessage(true);

    $('#main-submit').on('click', function () {
        // debugger;
        $form.submit();
    });

    // TCPA FORM
    $form.validate({
        rules: {
            tcpa_text: {
                required: true
            }
        },

        messages: {
            tcpa_text: {
                required: "Please enter the message text."
            },
            messageContent: {
                required: "Please enter the message content."
            }
        },

        submitHandler: function (form) {
            ajaxRequestHandler.submitForm(function (response, isError) {
                $('#iframe').attr('src', function (i, val) {
                    return val;
                });
            });
        }
    });

    getLogoColors();

    $("#security_message_text").on("change keyup", function () {
        // assignment by reference
        preview_module.funnelInfo.tcpa_messages[0]["tcpa_text"] = $(this).val();
        previewIframe.reloadIframe(false);
    });

    jQuery('.preview-link').click(function(e){
        e.preventDefault();
        let postAttribute = jQuery(this).hasClass('security-message-mobile-view') ? 'mobile-preview' : 'desktop-preview';
        previewIframe.reloadIframe(false, false, postAttribute);
    });

});


/*
* Render logo color swatches
* */
function getLogoColors() {
    var swatches = JSON.parse($("input[name='swatches']").val());
    if (swatches.length) {
        let index = 0;
        let colors = [];
        swatches.forEach((row) => {
            if (!colors.includes(row.swatch)) {
                colors.push(row.swatch);
                swatches.push(row);
                createLi(row, index++);
            }
        });
    }
}

/*
* Create a color div and append in the logo color div
* @param data //Swatch Response Data
* @param index //Index of the color
* */
var selectedSwatch = "";
function createLi(data, index) {
    let selected = (selectedSwatch == data.swatch) ? true : false;
    if (selected) {
        $("#swatchnumber").val(data.id);
    }
    let style = `background:${data.swatch}; height: 25px;width: 25px;border-radius: 6px; cursor:pointer`;

    let li = `<li style='${style}' id="custom-button-${index}" class="color-box__item" onclick="selectCustomButton1(${data.id}, ${JSON.stringify(data.swatch)})" class="${selected ? 'swatch-selected' : ''}" style="border: ${selected ? SELECTED_SWATCH_BORDER : SWATCH_BORDER} ;padding: 3px;width: auto;border-radius: 10px; display: inline-block; margin: 4px">
                    <div style='${style}'>
                        <input type="text" hidden value="${data.swatch}">
                    </div>
                </li>`;
    $(".logo-colors").append(li);
}


function selectCustomButton1(id,swatch) {
    $('#iconSelectedColor').css("background", );
    $('#iconSelectedCode').css("html", swatch);
    $("#icon-clr").ColorPickerSetColor(swatch);
}

// Preview
function adjustIconStyleInPreview(){
    preview_module.funnelInfo.tcpa_messages[0]["icon"] = JSON.stringify(current_security_message.icon);
    previewIframe.reloadIframe(false);

    $("#icon_style").val(JSON.stringify(current_security_message.icon)).trigger("change");
}

function adjustTextStyleInPreview(){
    preview_module.funnelInfo.tcpa_messages[0]["tcpa_text_style"] = JSON.stringify(current_security_message.tcpa_text_style);
    previewIframe.reloadIframe(false);

    $("#message_text_style").val(JSON.stringify(current_security_message.tcpa_text_style)).trigger("change");
}

/**
 * this function compare the last save value with new values.
 * if new values and last saved value did not match then will be save btn enable otherwise btn will disable.
 */
function onChangeStyleHandleButton(disabled) {
    if(!disabled) {
        return disabled;
    }

    let status = ajaxRequestHandler.isEquals(current_security_message, saved_security_message);
    return status;
}


function iframe_scaling(){
    var boxWidth = jQuery('.security-message .theme__body').width();
    var getScale = boxWidth / 1220;
    var boxHeight = 1 - getScale;
    var parentHeight = jQuery('.security-message .theme__wrapper').height();
    var getScaleHeight = parentHeight + (parentHeight * boxHeight) - 41;
    jQuery('.security-message .tcpa-security-preview-iframe').css({'height': getScaleHeight});
    if (getScale > 1) {
        return false;
    }
    else {
        jQuery('.security-message .tcpa-security-preview-iframe-holder').css({'transform': 'scale('+getScale+')'});
    }
}

jQuery(window).resize(function() {
    iframe_scaling();
});
