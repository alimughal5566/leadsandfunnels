//*
// ** Font Load Function
// *

function font_load(){
    var a = [];
    $.each(font_object, function( index, value ) {
        a.push(value);
    });

    WebFontConfig = {
        google: { families: a }
    };

    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = true;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
}


var font_object = {};

//*
// ** Font Object
// *

font_object = {
    "Abril Fatface": 'Abril Fatface',
    "Antic Slab": 'Antic Slab',
    "Anton": 'Anton',
    "Archivo Black": 'Archivo Black',
    "Arial": 'Arial',
    "Arvo": 'Arvo',
    "Berkshire Swash": 'Berkshire Swash',
    "Bevan": 'Bevan',
    "Bree Serif": 'Bree Serif',
    "Bungee Inline": 'Bungee Inline',
    "Cardo": 'Cardo',
    "Chela One": 'Chela One',
    "Chivo": 'Chivo',
    "Cinzel": 'Cinzel',
    "Coiny": 'Coiny',
    "Concert One": 'Concert One',
    "Cormorant": 'Cormorant',
    "Crimson Text": 'Crimson Text',
    "Exo 2": 'Exo 2',
    "Fira Sans": 'Fira Sans',
    "Fjalla One": 'Fjalla One',
    "Frank Ruhl Libre": 'Frank Ruhl Libre',
    "Fugaz One": 'Fugaz One',
    "Josefin Sans": 'Josefin Sans',
    "Judson": 'Judson',
    "Julius Sans One": 'Julius Sans One',
    "Kanit": 'Kanit',
    "Karla": 'Karla',
    "Kavoon": 'Kavoon',
    "Lato": 'Lato',
    "Libre Baskerville": 'Libre Baskerville',
    "Lobster": 'Lobster',
    "Lora": 'Lora',
    "Martel": 'Martel',
    "Merienda": 'Merienda',
    "Merriweather": 'Merriweather',
    "Monoton": 'Monoton',
    "Montserrat": 'Montserrat',
    "Notable": 'Notable',
    "Noto Sans": 'Noto Sans',
    "Nunito": 'Nunito',
    "Oleo Script": 'Oleo Script',
    "Open Sans": 'Open Sans',
    "Open Sans Condensed": 'Open Sans Condensed',
    "Oswald": 'Oswald',
    "Pacifico": 'Pacifico',
    "Paytone One": 'Paytone One',
    "Permanent Marker": 'Permanent Marker',
    "Philosopher": 'Philosopher',
    "Playfair Display": 'Playfair Display',
    "Poiret One": 'Poiret One',
    "Poppins": 'Poppins',
    "PT Sans": 'PT Sans',
    "PT Serif": 'PT Serif',
    "Prata": 'Prata',
    "Quicksand": 'Quicksand',
    "Rajdhani": 'Rajdhani',
    "Rakkas": 'Rakkas',
    "Raleway": 'Raleway',
    "Roboto": 'Roboto',
    "Rock Salt": 'Rock Salt',
    "Rubik": 'Rubik',
    "Sintony": 'Sintony',
    "Source Sans Pro": 'Source Sans Pro',
    "Special Elite": 'Special Elite',
    "Spectral": 'Spectral',
    "Spirax": 'Spirax',
    "Times New Roman":'Times New Roman',
    "Ubuntu Condensed": 'Ubuntu Condensed',
    "Ultra": 'Ultra',
    "Work Sans": 'Work Sans'
};


//*
// ** Window Load
// *

$(window).on('load',function() {
    //*
    // ** Load Font Object
    // *
    autosize($('textarea'));
    font_load();
});

$(document).ready(function () {
    var amIclosing = false;

    autosize($('textarea'));

    //*
    // ** Font Object Loop
    // *
    var fontSize = [];
    for (var i = 8; i <= 72; i++) {
        fontSize.push(i);
    }

    //*
    // ** Send Object In Options
    // *

    var $options = $();
    $options = $options.add($('<option>').attr('value', '').html('Select Font Type'));
    $.each(font_object , function (index , value) {
        $class = value;
        $class = $class.replace(" ", "_");
        $options = $options.add(
            $('<option>').attr('value', index).html(value).css('font-family', value)
        );
    });
    $('select.font-type').html($options).trigger('change');

    function matchCustom(params, data) {
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

    //*
    // ** Select2 Js Init
    // *

    $('#msgfonttype').select2({
        // minimumResultsForSearch: -1,
        placeholder: 'Times New Roman',
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
        matcher: matchCustom,
    }).on('select2:openning', function() {
        jQuery('.select2__parent-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2__parent-font-type .select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('#msgfonttype').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight - 50;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
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
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2__parent-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#msgfonttype').val(1);
    // .on("change", function (e) {
        // var font_famil = $(this).val();
        // var $select2 = $(this).select2()
        // $select2.data('select2').$container.css('font-family', font_famil );

        // $(this).addClass("helo");
        // console.info($(this).val());


        // var a = $(this).select2('data');
        // var b = a[0].element.attributes.style;
        // $(".select2-selection__rendered").setAttribute(b);
        // console.info(b);
        // console.info(a[0]);
        // console.info(temp0.element.attributes.style);


        // var selected_element = $(e.currentTarget).css("font-family");
        // console.info(selected_element);
        // var select_val = selected_element.val();
    // });
    $('#msgfontsize').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-font-size')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-font-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
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
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
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
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2__parent-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-font-size .select2-results__options').css('pointer-events', 'none');
    });

    $('#dfonttype').select2({
        // minimumResultsForSearch: -1,
        placeholder: 'Arial',
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-dfont-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
        matcher: matchCustom,
    }).on('select2:openning', function() {
        jQuery('.select2__parent-dfont-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2__parent-dfont-type .select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-dfont-type .select2-dropdown').hide();
        jQuery('.select2__parent-dfont-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
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
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
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
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2__parent-dfont-type .select2-selection__rendered').show();
        jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#dfontsize').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-dfont-size')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-dfont-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-dfont-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-dfont-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-dfont-size .select2-dropdown').hide();
        jQuery('.select2__parent-dfont-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
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
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
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
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2__parent-dfont-size .select2-selection__rendered').show();
        jQuery('.select2__parent-dfont-size .select2-results__options').css('pointer-events', 'none');
    });

    //*
    // ** Select2 Js Select Event
    // *

    $('#msgfonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $("#mian__message").css('font-family', font_type);
        autosize.update($('textarea'));
    });
    $('#msgfontsize').on("select2:select", function () {
        var fontsize__msg = $(this).val();
        $("#mian__message").css('font-size', fontsize__msg+"px");
        autosize.update($('textarea'));
    });

    $('#dfonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $("#desc__message").css('font-family', font_type);
        autosize.update($('textarea'));
    });
    $('#dfontsize').on("select2:select", function () {
        var fontsize__desc = $(this).val();
        $("#desc__message").css('font-size', fontsize__desc+"px");
        autosize.update($('textarea'));
    });


    var line_height = [
        {
            id:1,
            text:'<div class="line-height">Single</div>'
        },
        {
            id:1.15,
            text:'<div class="line-height">1.15</div>'
        },
        {
            id:1.5,
            text:'<div class="line-height"></i>1.5</div>'
        },
        {
            id:2,
            text:'<div class="line-height">Double</div>'
        }
    ];

    $('.select2-linehight-main-msg').select2({
        width: '100%',
        data:line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-mian-msg-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $("#mian__message").css('line-height', $this_val);
        autosize.update($('textarea'));
    }).on('select2:openning', function() {
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-main-msg').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'none');
    });


    $('.select2-linehight-dsc-msg').select2({
        width: '100%',
        data:line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-dsc-msg-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $("#desc__message").css('line-height', $this_val);
        autosize.update($('textarea'));
    }).on('select2:openning', function() {
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-dsc-msg').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'none');
    });



    //*
    // ** Color Picker Init
    // *

    // call_clrpicker();
    // $('#homepage-cta-message-pop').on('shown.bs.modal', function() {
    //     // ... init all your modal here
    //     // alert(1)
    //     call_clrpicker();
    // });

    //*
    // ** TextArea Js
    // *


    $("#mian__message").css({
        'font-size' : '38px',
        'color' : '#0ccdba',
        'font-family' : 'Times New Roman'
    });
    $("#desc__message").css({
        'font-size' : '16px',
        'color' : '#3f3f3f',
        'font-family' : 'Arial'
    });

    $('.button-save').click(function () {
        $('#ctaform').submit();
    });

    //*
    // ** Validation Js Call-to-Action Page
    // *

    var valid_obj = $('#ctaform').validate({
        rules: {
            mian__message: {
                required: true
            }
        },
        messages: {
            mian__message: {
                required:"Please enter the message."
            }
        },
        submitHandler: function () {
            console.info('submitted');
        }
    });

    $('.colorSelector-mmessagecp').click(function () {
        var name = ".main-message-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });
    $('.colorSelector-mdescp').click(function () {
        var name = ".desc-message-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });



    $("#main-message-colorpicker").ColorPicker({
        color: "#707d84",
        flat: true,
        // opacity:true,

        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        // set_opacity: 0.22,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(100);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(100);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            console.info('change:'+rgba.a)
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".main-message-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".main-message-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".main-message-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".main-message-clr .color-box__hex-block").val('#'+hex);
            $("#mmessagecpval").val('#' + hex);
            $('.colorSelector-mmessagecp').css('backgroundColor', rgba_fn);
            $('#mian__message').css('color', rgba_fn);
        }
    });
    $("#desc-message-colorpicker").ColorPicker({
        color: "#3f3f3f",
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
            $(".desc-message-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".desc-message-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".desc-message-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".desc-message-clr .color-box__hex-block").val('#'+hex);
            $("#dmessagecpval").val('#' + hex);
            $('.colorSelector-mdescp').css('backgroundColor', rgba_fn);
            $('#desc__message').css('color', rgba_fn);
        }
    });

    $('.cta__message').click(function () {
       $(this).find('.text-area').focus();
    });

    $('#mian__message, #desc__message').focus(function () {
        jQuery(this).parent('.cta__message').addClass('focused');
    });

    $('#mian__message, #desc__message').blur(function () {
        jQuery(this).parent('.cta__message').removeClass('focused');
    });

});


function call_clrpicker() {
    // $('.colorSelector-mmessagecp').ColorPicker({
    //     color: '#0ccdba',
    //     onShow: function (colpkr) {
    //         $(colpkr).fadeIn(500);
    //         return false;
    //     },
    //     onHide: function (colpkr) {
    //         $(colpkr).fadeOut(500);
    //         return false;
    //     },
    //     onChange: function (hsb, hex, rgb) {
    //         $("#mmessagecpval").val('#' + hex);
    //         $('.colorSelector-mmessagecp').css('backgroundColor', '#' + hex);
    //         $('#mian__message').css('color', '#' + hex);
    //     },
    //
    // });
    // $('.colorSelector-mdescp').ColorPicker({
    //     color: '#3f3f3f',
    //     onShow: function (colpkr) {
    //         $(colpkr).fadeIn(500);
    //         return false;
    //     },
    //     onHide: function (colpkr) {
    //         $(colpkr).fadeOut(500);
    //         return false;
    //     },
    //     onChange: function (hsb, hex, rgb) {
    //         $("#dmessagecpval").val('#' + hex);
    //         $('.colorSelector-mdescp').css('backgroundColor', '#' + hex);
    //         $('#desc__message').css('color', '#' + hex);
    //     }
    // });


}

//*
// ** Reset TextArea Function
// *

function resethomepagemessage(cval) {
    var msg = $('#mian__message').val();
    // var current_hash=$("#current_hash").val(); //// not in use yet
    $("#success-alert").find('span').text("");
    //$("#leadpopovery").show();
    $("#mask").show();
    var resetfun="";
    switch (cval) {
        case "1":
            resetfun="resetctamessage";
            break;
        case "2":
            resetfun="resetctadescription";
            break;
    }

    var form_data=$('#ctaform').serializeArray();

    jQuery.ajax( {
        type : "POST",
        data:form_data,
        // url: site.baseUrl+site.lpPath+'/popadmin/'+resetfun+'/'+current_hash,
        success : function(data) {
            console.log(data);
            var style_data=jQuery.parseJSON(data);
            var fontfamily=style_data.style.font_family.replace(" ", "_");
            var fontsize=style_data.style.font_size;
            var color=style_data.style.color;
            var msg=style_data.style.main_message;
            var css_prop_obj={
                'font-family':style_data.style.font_family,
                'font-size':fontsize,
                'color':color,
            }
            switch (cval) {
                case "1":
                    $("#success-alert").find('span').text("CTA Main Message default style has been reset.");
                    $('#msgfonttype').val(style_data.style.font_family).trigger('change');
                    $('#msgfontsize').val(fontsize).trigger('change');
                    $("#mian__message").val(msg).css(css_prop_obj);
                    $('.colorSelector-mmessagecp').css('backgroundColor', color);
                    $('#mmessagecpval').val(color);
                    $('.colorSelector-mmessagecp').ColorPickerSetColor(color);

                    var ta = document.querySelector('textarea#mian__message');
                    autosize(ta);
                    ta.value = msg;
                    var evt = document.createEvent('Event');
                    evt.initEvent('autosize:update', true, false);
                    ta.dispatchEvent(evt);

                    break;
                case "2":
                    $("#success-alert").find('span').text("CTA Description default style has been reset.");
                    $('#dfonttype').val(style_data.style.font_family).trigger('change');
                    $('#dfontsize').val(fontsize).trigger('change');
                    $("#desc__message").val(msg).css(css_prop_obj);
                    $('.colorSelector-mdescp').css('backgroundColor', color);
                    $('#dmessagecpval').val(color);
                    $('.colorSelector-mdescp').ColorPickerSetColor(color);

                    var ta = document.querySelector('textarea#desc__message');
                    autosize(ta);
                    ta.value = msg;
                    var evt = document.createEvent('Event');
                    evt.initEvent('autosize:update', true, false);
                    ta.dispatchEvent(evt);
                    break;
            }
            $("#mask").hide();
            goToByScroll("success-alert");
            $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                $(this).slideUp(500);
            });

        },
    });

    return false;
}
