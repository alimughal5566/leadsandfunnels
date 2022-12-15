var ajaxCtaHandler = Object.assign({}, ajaxRequestHandler);

$(document).ready(function () {
    var amIclosing = false;
    autosize($('textarea'));
    // CTA POPUP validation

    var submitButton = '#main-submit',
        $form = $("#ctaform");

    // cta form validation popup
    if ($('#funnel_builder').length) {
        submitButton = '[data-save-cta-btn]';
        ajaxCtaHandler.init('#ctaform', {
            alwaysBindEvent:true,
            autoEnableDisableButton: true,
            toastMessage: 'Saving, Please wait...',
            submitButton: submitButton
        });
    } else {
        ajaxCtaHandler.init("#ctaform");
    }

    //submit CTA form
    $(submitButton).click(function (e) {
        if(FBHelper.isFunnelBuilder()) {
            e.preventDefault();
            if($form.valid()) {
                $form.submit();
            }
        } else {
            $form.submit();
        }
    });

    validateCTAForm($form,ajaxCtaHandler);

    $('.colorSelector-mmessagecp').css('backgroundColor', $("#mmessagecpval").val());
    $('.colorSelector-mdescp').css('backgroundColor', $("#dmessagecpval").val());

    var line_height = [
        {
            id: 1,
            text: '<div title="Single" class="line-height">Single</div>'
        },
        {
            id: 1.15,
            text: '<div title="1.15" class="line-height">1.15</div>'
        },
        {
            id: 1.5,
            text: '<div title="1.5" class="line-height"></i>1.5</div>'
        },
        {
            id: 2,
            text: '<div title="Double" class="line-height">Double</div>'
        }
    ];


    $('.select2-linehight-main-msg').select2({
        width: '100%',
        data: line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-mian-msg-parent'),
        templateResult: function (d) {
            return $(d.text);
        },
        templateSelection: function (d) {
            return $(d.text);
        }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $("#mlineheight").val($this_val).change();
        $("#mian__message").css('line-height', $this_val);
        autosize.update($('textarea'));
    }).on('select2:openning', function () {
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-main-msg').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'none');
    });

    $(".select2-linehight-main-msg").val($("#mlineheight").val()).change();

    $('.select2-linehight-dsc-msg').select2({
        width: '100%',
        data: line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-dsc-msg-parent'),
        templateResult: function (d) {
            return $(d.text);
        },
        templateSelection: function (d) {
            return $(d.text);
        }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $("#dlineheight").val($this_val).trigger('change');
        $("#desc__message").css('line-height', $this_val);
        autosize.update($('textarea'));
    }).on('select2:openning', function () {
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-dsc-msg').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'none');
    });
    $(".select2-linehight-dsc-msg").val($("#dlineheight").val()).change();

    /**
     * start main message cta color picker functionality
     */
    let color = $("#mmessagecpval").val();
    $(".colorSelector-mmessagecp").ColorPicker({
        color: color,
        flat: true,
        auto_show:false,
        opacity: true,
        append_to:".text-color-parent",
        onChange: function (hsb, hex, rgb, rgba) {
            let rgba_fn = lpUtilities.getRGBAString(rgba);
            // $("#mmessagecpval").val('#' + hex);
            $("#mmessagecpval").val(rgba_fn).trigger('change');
            $('.colorSelector-mmessagecp').css('backgroundColor', rgba_fn);
            $('#mian__message').css('color', rgba_fn);
        },
        onShow: function () {
          $('.colorSelector-mmessagecp').parent().addClass('color-picker-active');
        },
        onHide: function () {
          $('.colorSelector-mmessagecp').parent().removeClass('color-picker-active');
        },
    });
    /**
     * end main message cta color picker functionality
     */


    /**
     * start description color picker functionality
     */
    let dcolor = $("#dmessagecpval").val();
    $(".colorSelector-mdescp").ColorPicker({
        color: dcolor,
        opacity: true,
        flat:true,
        auto_show:false,
        append_to:".text-color-parent",
        onChange: function (hsb, hex, rgb, rgba) {
            let rgba_fn = lpUtilities.getRGBAString(rgba);
            $("#dmessagecpval").val(rgba_fn).trigger('change');
            $('.colorSelector-mdescp').css('backgroundColor', rgba_fn);
            $('#desc__message').css('color', rgba_fn);
        },
        onShow: function () {
          $('.colorSelector-mdescp').parent().addClass('color-picker-active');
        },
        onHide: function () {
          $('.colorSelector-mdescp').parent().removeClass('color-picker-active');
        },
    });
    /**
     * end description color picker functionality
     */

    $('.cta__message').click(function () {
        $(this).find('.text-area').focus();
    });

    $('#mian__message, #desc__message').focus(function () {
        jQuery(this).parent('.cta__message').addClass('focused');
    });

    $('#mian__message, #desc__message').blur(function () {
        jQuery(this).parent('.cta__message').removeClass('focused');
    });


    // SELECT 2
    $('#msgfontsize').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-font-size')
    }).on('select2:openning', function () {
        jQuery('.select2__parent-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2__parent-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2__parent-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-font-size .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2__parent-font-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('#msgfontsize').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);

    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-font-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#msgfontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2__parent-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty('opacity', '0', 'important');
        });
    }).on('select2:close', function () {
        jQuery('.select2__parent-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-font-size .select2-results__options').css('pointer-events', 'none');
    });

    $('#dfontsize').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-dfont-size')
    }).on('select2:openning', function () {
        jQuery('.select2__parent-dfont-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2__parent-dfont-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2__parent-dfont-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-dfont-size .select2-dropdown').hide();
        jQuery('.select2__parent-dfont-size .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2__parent-dfont-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-dfont-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#dfontsize').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
            });
        }, 400);
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-dfont-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#dfontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2__parent-dfont-size .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty('opacity', '0', 'important');
        });
    }).on('select2:close', function () {
        jQuery('.select2__parent-dfont-size .select2-selection__rendered').show();
        jQuery('.select2__parent-dfont-size .select2-results__options').css('pointer-events', 'none');
    });


    //*
    // ** Select2 Js Select Event
    // *


    $('#msgfontsize').on("select2:select", function () {
        var fontsize__msg = $(this).val();
        $("#mian__message").css('font-size', fontsize__msg);
        autosize.update($('textarea'));
    });


    $('#dfontsize').on("select2:select", function () {
        //  debugger;
        var fontsize__desc = $(this).val();
        $("#desc__message").css('font-size', fontsize__desc);
        autosize.update($('textarea'));
    });


});

//MN
function targetele(src) {
    var target_element = "";
    switch (src) {
        case 'mthefont':
        case 'mthefontsize':
            target_element = "mmainheadingval";
            break;
        case 'dthefont':
        case 'dthefontsize':
            target_element = "dmainheadingval";
            break;
    }
    return target_element;
}

function changefont(src, val) {
    target_element = targetele(src);
    var newval = val.replace("+", " ");
    newval = newval.replace("+", " ");
    newval = newval.replace("+", " ");
    // console.log(target_element);
    // console.log(src);
    $('#' + target_element).css('font-family', newval);
    $('#' + src).removeAttr('class');
    $('#' + src).addClass("selectpicker cta-font-size " + newval.replace(' ', '_').toLowerCase());
    $('#mlineheight').val($("#mmainheadingval").css("line-height"));
    $('#dlineheight').val($("#dmainheadingval").css("line-height"));
}

function changefontsize(src, val) {
    target_element = targetele(src);
    $('#' + target_element).css('font-size', val);
    $('#mlineheight').val($("#mmainheadingval").css("line-height"));
    $('#dlineheight').val($("#dmainheadingval").css("line-height"));
}

// FONTS
var fonts = lp_helper_font_families;
if(site.route === 'funnel-builder'){
    fonts = ctaFonts;
}

function ctaFontLoad() {
    var a = [];
    $.each(fonts, function (index, value) {
        // debugger;
        var font = value.replace(/\s/g, "+")
        var wf = document.createElement('link');
        wf.href = 'https://fonts.googleapis.com/css?family=' + font;
        wf.rel = 'stylesheet';

        var s = document.getElementsByTagName('link')[0];
        s.parentNode.insertBefore(wf, s);
    });
}


$(window).on('load', function () {
    //*
    // ** Load Font Object
    // *

    ctaFontLoad();
});


// SCROOL

$(".select2js__nice-scroll").click(function () {
    $('.select2-results__options').niceScroll({
        cursorcolor: "#fff",
        cursorwidth: "10px",
        autohidemode: false,
        smoothscroll: false,
        scrollspeed: 10,
        railpadding: {top: 0, right: 0, left: 0, bottom: 0}, // set padding for rail bar
        cursorborder: "1px solid #02abec",
    });
});


function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    params.term = params.term || '';

    if ($.trim(data.text.toUpperCase()).indexOf(params.term.toUpperCase()) == 0) {
        return data;
    }
    // Return `null` if the term should not be displayed
    return null;
}

function matchCustomFont(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
        return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
        return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
        var modifiedData = $.extend({}, data, true);
        modifiedData.text;

        // You can return modified objects from here
        // This includes matching the `children` how you want in nested data sets
        return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}

// FONT TYPE

var amIclosing = false;
var fontsss = new Object();
$("#msgfonttype").select2({
    placeholder: 'Times New Roman',
    width: '100%',
    dropdownParent: $('.select2__parent-font-type'),
    templateResult: function (data, container) {
        if (data.element) {
            var fff = $(data.element).prop("class");
            fontsss[fff] = fff;
            $(container).addClass($(data.element).prop("class"));
            $(container).css('font-family', $(data.element).prop("class"));
        }
        return data.text;
    },
    matcher: function (params, data) {
        return matchCustom(params, data);
    }
}).on('select2:openning', function () {
    jQuery('.select2__parent-font-type .select2-selection__rendered').css('opacity', '0');
}).on('select2:open', function () {
    $(".select2__parent-font-type .select2-search__field").attr("placeholder", "Search....");
    jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'none');
    setTimeout(function () {
        jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'auto');
    }, 300);
    jQuery('.select2__parent-font-type .select2-dropdown').hide();
    jQuery('.select2__parent-font-type .select2-dropdown').css({
        'display': 'block',
        'opacity': '1',
        'transform': 'scale(1, 1)'
    });
    jQuery('.select2__parent-font-type .select2-selection__rendered').hide();
    setTimeout(function () {
        jQuery('.select2__parent-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
            var getindex = jQuery('#msgfonttype').find(':selected').index();
            var defaultHeight = 44;
            var scrolledArea = getindex * defaultHeight - 50;
            $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
            this.style.setProperty( 'opacity', '1', 'important' );
        });
    }, 400);
}).on("select2:select", function () {
    var font_type = $(this).val();
    if (font_type == 'Exo 2') {
        font_type = "'Exo 2'";
    }
    $("#mian__message").css('font-family', font_type);
    $("#select2-msgfonttype-container").css('font-family', font_type);
    autosize.update($('textarea'));
}).on('select2:closing', function (e) {
    if (!amIclosing) {
        e.preventDefault();
        amIclosing = true;
        jQuery('.select2__parent-font-type .select2-dropdown').attr('style', '');
        setTimeout(function () {
            jQuery('#msgfonttype').select2("close");
        }, 200);
    } else {
        amIclosing = false;
    }
    jQuery('.select2__parent-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
        this.style.setProperty('opacity', '0', 'important');
    });
}).on('select2:close', function () {
    jQuery('.select2__parent-font-type .select2-selection__rendered').show();
    jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'none');
});


$("#dfonttype").select2({
    placeholder: 'Times New Roman',
    width: '100%',
    dropdownParent: $('.select2__parent-dfont-type'),
    templateResult: function (data, container) {
        if (data.element) {
            var fff = $(data.element).prop("class");
            fontsss[fff] = fff;
            $(container).addClass($(data.element).prop("class"));
            $(container).css('font-family', $(data.element).prop("class"));
        }
        return data.text;
    },
    matcher: function (params, data) {
        return matchCustom(params, data);
    }
}).on('select2:openning', function () {
    jQuery('.select2__parent-dfont-type .select2-selection__rendered').css('opacity', '0');
}).on('select2:open', function () {
    $(".select2__parent-dfont-type .select2-search__field").attr("placeholder", "Search....");
    jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'none');
    setTimeout(function () {
        jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'auto');
    }, 300);
    jQuery('.select2__parent-dfont-type .select2-dropdown').hide();
    jQuery('.select2__parent-dfont-type .select2-dropdown').css({
        'display': 'block',
        'opacity': '1',
        'transform': 'scale(1, 1)'
    });
    jQuery('.select2__parent-dfont-type .select2-selection__rendered').hide();
    lpUtilities.niceScroll();
    setTimeout(function () {
        jQuery('.select2__parent-dfont-type .select2-dropdown .nicescroll-rails-vr').each(function () {
            var getindex = jQuery('#dfonttype').find(':selected').index();
            var defaultHeight = 44;
            var scrolledArea = getindex * defaultHeight - 50;
            $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
            this.style.setProperty( 'opacity', '1', 'important' );
        });
    }, 400);
}).on("select2:select", function () {
    var font_type = $(this).val();
    if (font_type == 'Exo 2') {
        font_type = "'Exo 2'";
    }
    $("#desc__message").css('font-family', font_type);
    $("#select2-dfonttype-container").css('font-family', font_type);
    autosize.update($('textarea'));
}).on('select2:closing', function (e) {
    if (!amIclosing) {
        e.preventDefault();
        amIclosing = true;
        jQuery('.select2__parent-dfont-type .select2-dropdown').attr('style', '');
        setTimeout(function () {
            jQuery('#dfonttype').select2("close");
        }, 200);
    } else {
        amIclosing = false;
    }
    jQuery('.select2__parent-dfont-type .select2-dropdown .nicescroll-rails-vr').each(function () {
        this.style.setProperty('opacity', '0', 'important');
    });
}).on('select2:close', function () {
    jQuery('.select2__parent-dfont-type .select2-selection__rendered').show();
    jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'none');
});
