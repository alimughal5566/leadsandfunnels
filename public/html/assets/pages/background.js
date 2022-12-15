$(window).on("load",function(){
    setupicseditor();
});
$(document).click(function(e) {
    var container = $(".pull-clr__wrapper,.color-box__panel-wrapper");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
        $('.last-selected').removeClass('open');
    }
});
$(document).ready(function() {
    //*
    // ** Tooltip
    // *

    $('.bg__el-tooltip').tooltipster({
        interactive:true,
        contentAsHTML:true
    });

    //*
    // ** Title text changer
    // *

    $(".nav__tab a").click(function () {
       var inner_txt = $(this).text();
        $(".inner__title").text(inner_txt);
    });

    $(".lp-image__input").click(function () {
        $(this).closest(".lp-image__input").val('');
    }).change(function() {
        readURL(this);
    });

    $('.btn-image__del').click(function () {
        $(this).closest('.lp-favicon__step1').slideDown();
        $(this).closest('.lp-favicon__step2').slideUp();
        $(this).closest(".browse__bg-image").css("background-image", "");
        $(this).closest(".lp-image__input").val('');
        $(this).closest('.file__size,.file__extension').slideUp("slow");
        $(this).closest('.del__img').hide();
    });

    //*
    // **  favicon Image Preview
    // *

    function readURL(input) {
        var this_input = input;
        console.info(input);
        if (input.files && input.files[0]) {

            /*
             ** Profile Image Upload Validation
             */

            var file = this_input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg']) == -1) {
                $(this_input).parentsUntil(".tab-pane.active").find('.file__extension').slideDown("slow");
                $(this_input).parentsUntil(".tab-pane.active").find('.file__size').slideUp("slow");
            }
            else if (file.size > 4000000) {
                $(this_input).parentsUntil(".tab-pane.active").find('.file__size').slideDown("slow");
                $(this_input).parentsUntil(".tab-pane.active").find('.file__extension').slideUp("slow");

            }
            else {
                $(this_input).parentsUntil(".tab-pane.active").find('.file__size,.file__extension').slideUp("slow");
                $(this_input).parentsUntil(".tab-pane.active").find('.browse__step1').slideUp();
                $(this_input).parentsUntil(".tab-pane.active").find('.browse__step2').slideDown();
                var reader = new FileReader();
                reader.onload = function (e) {
                    console.info(this_input);
                  $(this_input).parentsUntil(".tab-pane.active").find('.browse__bg-image').css('background-image', 'url('+e.target.result +')');
                  $(this_input).parentsUntil(".tab-pane.active").find('.del__img').show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    //*
    // **  Nice Scroll Global Style ((== select2js ==))
    // *

    $(".select2js__nice-scroll").click(function () {
        $('.select2-results__options').niceScroll({
            cursorcolor:"#fff",
            cursorwidth: "10px",
            autohidemode:false,
            railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #02abec",
        });
    });

    //*
    // ** Select2 Page Tab
    // *

    $('.select2__bgPage-repeat').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-repeat-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-repeat', this_val);
        // valid_obj.form();
    }).on('select2:openning', function() {
        jQuery('.select2__bgPage-repeat-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__bgPage-repeat-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__bgPage-repeat-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-repeat-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-repeat-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__bgPage-repeat-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgPage-repeat-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-repeat').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__bgPage-repeat-parent .select2-selection__rendered').show();
        jQuery('.select2__bgPage-repeat-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2__bgPage-postion').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-postion-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-position', this_val);
        // valid_obj.form();
    }).on('select2:openning', function() {
        jQuery('.select2__bgPage-postion-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__bgPage-postion-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__bgPage-postion-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-postion-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-postion-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__bgPage-postion-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgPage-postion-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-postion').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__bgPage-postion-parent .select2-selection__rendered').show();
        jQuery('.select2__bgPage-postion-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2__bgPage-cover').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-cover-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-size', this_val);
        // valid_obj.form();
    }).on('select2:openning', function() {
        jQuery('.select2__bgPage-cover-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__bgPage-cover-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__bgPage-cover-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-cover-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-cover-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__bgPage-cover-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgPage-cover-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-cover').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__bgPage-cover-parent .select2-selection__rendered').show();
        jQuery('.select2__bgPage-cover-parent .select2-results__options').css('pointer-events', 'none');
    });

    var amIclosing = false;
    $('.select2__bgPage-colormode').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-colormode-parent')
    }).on('change', function () {
        if($(this).val() == "hex"){
            var code_hex = $('#bgPage-modeowncolor-hex').val();
            $('#bgPage-colorval').val(code_hex);
        }else {
            var code_rgb = $('#bgPage-modeowncolor-rgb').val();
            $('#bgPage-colorval').val(code_rgb);
        }
    }).on('select2:openning', function() {
        jQuery('.select2__bgPage-colormode-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__bgPage-colormode-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__bgPage-colormode-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-colormode-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-colormode-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__bgPage-colormode-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgPage-colormode-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-colormode').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__bgPage-colormode-parent .select2-selection__rendered').show();
        jQuery('.select2__bgPage-colormode-parent .select2-results__options').css('pointer-events', 'none');
    });

    //*
    // ** Select2 From Tab
    // *

    $('.select2__bgForm-repeat').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgForm-repeat-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-repeat', this_val);
    });
    $('.select2__bgForm-postion').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgForm-postion-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-position', this_val);
    });
    $('.select2__bgForm-cover').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgForm-cover-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-size', this_val);
    });
    $('.select2__bgForm-colormode').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgForm-colormode-parent')
    }).on('change', function () {
        if($(this).val() == "hex"){
            var code_hex = $('#bgForm-modeowncolor-hex').val();
            $('#bgForm-colorval').val(code_hex);
        }else {
            var code_rgb = $('#bgForm-modeowncolor-rgb').val();
            $('#bgForm-colorval').val(code_rgb);
        }
    }).on('select2:openning', function() {
        jQuery('.select2__bgForm-colormode-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__bgForm-colormode-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__bgForm-colormode-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgForm-colormode-parent .select2-dropdown').hide();
        jQuery('.select2__bgForm-colormode-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__bgForm-colormode-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgForm-colormode-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgForm-colormode').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__bgForm-colormode-parent .select2-selection__rendered').show();
        jQuery('.select2__bgForm-colormode-parent .select2-results__options').css('pointer-events', 'none');
    });

    //*
    // ** Select2 Cards Tab
    // *

    $('.select2__bgCards-repeat').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgCards-repeat-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-repeat', this_val);
        // valid_obj.form();
    });
    $('.select2__bgCards-postion').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgCards-postion-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-position', this_val);
        // valid_obj.form();
    });
    $('.select2__bgCards-cover').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgCards-cover-parent')
    }).on('change', function () {
        var this_val = $(this).val();
        $(".browse__bg-image").css('background-size', this_val);
        // valid_obj.form();
    });
    $('.select2__bgCards-colormode').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgCards-colormode-parent')
    }).on('change', function () {
        if($(this).val() == "hex"){
            var code_hex = $('#bgCards-modeowncolor-hex').val();
            $('#bgCards-colorval').val(code_hex);
        }else {
            var code_rgb = $('#bgCards-modeowncolor-rgb').val();
            $('#bgCards-colorval').val(code_rgb);
        }
    });

    //*
    // ** Background overlay switch
    // *

    $( "body" ).on( "change","#bgPage__active-overlay" , function() {

        var color = "#fff";
        var value=0;
        if(!$(this).is(":checked")){
            color = $(".bgPageColor-picker__overlay").css('backgroundColor');
            value=$('#ex1').val();
        }
        $("#bgPagePreview-overlay").css({
            'background-color' : color,
            'opacity':value/100
        });
    });
    $( "body" ).on( "change","#bgForm__active-overlay" , function() {

        var color = "#fff";
        var value=0;
        if(!$(this).is(":checked")){
            color = $(".bgFormColor-picker__overlay").css('backgroundColor');
            value=$('#ex2').val();
        }
        $("#bgFormPreview-overlay").css({
            'background-color' : color,
            'opacity':value/100
        });
    });
    $( "body" ).on( "change","#bgCards__active-overlay" , function() {

        var color = "#fff";
        var value=0;
        if($(this).is(":checked")){
            color = $(".bgCardsColor-picker__overlay").css('backgroundColor');
            value=$('#ex3').val();
        }
        $("#bgCardsPreview-overlay").css({
            'background-color' : color,
            'opacity':value/100
        });
    });

    //*
    // ** Own color tabs
    // *

    $('.bgPageowncolor__box').ColorPicker({
        color: "#e6eef3",
        flat: true,
        opacity:true,
        width: 290,
        height: 290,
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
            var $this_elm = $(this).parents('.owncolor__wrapper');
            $this_elm.find('.last-selected__code').html('#'+hex);
            $this_elm.find('.last-selected__box').css('backgroundColor',rgba_fn);
            $('#bgPage-modeowncolor-hex').val('#'+hex);
            $('#bgPage-modeowncolor-rgb').val(rgb.r+', '+rgb.g+','+rgb.b);
            if($('.select2__bgPage-colormode').val() == 'hex'){
                $('#bgPage-colorval').val('#'+hex);
            }else {
                $('#bgPage-colorval').val(rgb.r+', '+rgb.g+', '+rgb.b);
            }
        }
    });
    $('.bgFormowncolor__box').ColorPicker({
        color: "#e6eef3",
        flat: true,
        opacity:true,
        width: 290,
        height: 290,
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
        onChange: function (hsb, hex, rgb) {
            var $this_elm = $(this).parents('.owncolor__wrapper');
            $this_elm.find('.last-selected__code').html('#'+hex);
            $this_elm.find('.last-selected__box').css('backgroundColor','#'+hex);
            $('#bgForm-modeowncolor-hex').val('#'+hex);
            $('#bgForm-modeowncolor-rgb').val(rgb.r+', '+rgb.g+', '+rgb.b);
            if($('.select2__bgForm-colormode').val() == 'hex'){
                $('#bgForm-colorval').val('#'+hex);
            }else {
                $('#bgForm-colorval').val(rgb.r+', '+rgb.g+', '+rgb.b);
            }
        }
    });
    // $('.bgCardsowncolor__box').ColorPicker({
    //     color: "#e6eef3",
    //     flat: true,
    //     width: 278,
    //     height: 292,
    //     outer_height: 113,
    //     outer_width: 390,
    //     onShow: function (colpkr) {
    //         $(colpkr).fadeIn(100);
    //         return false;
    //     },
    //     onHide: function (colpkr) {
    //         $(colpkr).fadeOut(100);
    //         return false;
    //     },
    //     onChange: function (hsb, hex, rgb) {
    //         $('#bgCards-modeowncolor-hex').val('#'+hex);
    //         $('#bgCards-modeowncolor-rgb').val(rgb.r+', '+rgb.g+','+rgb.b);
    //         if($('.select2__bgCards-colormode').val() == 'hex'){
    //             $('#bgCards-colorval').val('#'+hex);
    //         }else {
    //             $('#bgCards-colorval').val(rgb.r+','+rgb.g+','+rgb.b);
    //         }
    //     }
    // });

    //*
    // ** Hex to RGB
    // *

    function hexToRgb(hex) {
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    $('.bgPageColor-picker__overlay').click(function () {
        var name = ".main-bg-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('.bgFormColor-picker__overlay').click(function () {
        var name = ".funnel-bg-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    //*
    // ** Overlay color picker
    // *

    $('#mian-bg-colorpicker').ColorPicker({
        color: "#6a9994",
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
            $(".main-bg-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".main-bg-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".main-bg-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".main-bg-clr .color-box__hex-block").val('#'+hex);
            $("#bgPageImg-overlay").val('#'+hex);
            $('.bgPagePreview-overlay').css('backgroundColor', rgba_fn);
            $('.bgPageColor-picker__overlay').css('backgroundColor', rgba_fn);
            setpreviewsetting();
        }
    });
    $('#funnel-bg-colorpicker').ColorPicker({
        color: "#FFFFFF",
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
            $(".funnel-bg-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".funnel-bg-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".funnel-bg-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".funnel-bg-clr .color-box__hex-block").val('#'+hex);
            $("#bgFormImg-overlay").val('#'+hex);
            $('.bgFormPreview-overlay').css('backgroundColor', rgba_fn);
            $('.bgFormColor-picker__overlay').css('backgroundColor', rgba_fn);
            setpreviewsetting();
        }
    });
    // $('.bgCardsColor-picker__overlay').ColorPicker({
    //     color: "#FFFFFF",
    //     onShow: function (colpkr) {
    //         $(colpkr).fadeIn(100);
    //         return false;
    //     },
    //     onHide: function (colpkr) {
    //         $(colpkr).fadeOut(100);
    //         return false;
    //     },
    //     onChange: function (hsb, hex, rgb) {
    //         $("#bgCardsImg-overlay").val('#'+hex);
    //         $('.bgCardsPreview-overlay').css('backgroundColor', '#' + hex);
    //         $('.bgCardsColor-picker__overlay').css('backgroundColor', '#' + hex);
    //         setpreviewsetting();
    //     }
    // });


    //*
    // ** Opacity range slider
    // *

    $('#ex1').bootstrapSlider({
        formatter: function(value) {
            $('#bgPageOverlay_color_opacity').val(value);
            if (!$('#bgPage__active-overlay').is(":checked")){
                $("#bgPagePreview-overlay").css('opacity', value/100);
            }
            return   value +'%';
        },
        min: 1,
        max: 100,
        value: $('#bgPageOverlay_color_opacity').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    $('#ex2').bootstrapSlider({
        formatter: function(value) {
            $('#bgFormOverlay_color_opacity').val(value);
            if (!$('#bgForm__active-overlay').is(":checked")){
                $("#bgPagePreview-overlay").css('opacity', value/100);
            }
            return   value +'%';
        },
        min: 1,
        max: 100,
        value: $('#bgFormOverlay_color_opacity').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    $('#ex3').bootstrapSlider({
        formatter: function(value) {
            $('#bgCardsOverlay_color_opacity').val(value);
            if ($('#bgCards__active-overlay').is(":checked")){
                $("#bgCardsPreview-overlay").css('opacity', value/100);
            }
            return   value +'%';
        },
        min: 1,
        max: 100,
        value: $('#bgCardsOverlay_color_opacity').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    function setpreviewsetting(){
        $('.browse__bg-image').css({'background-repeat':$('#background-repeat').val(),'background-position':$('#background-position').val(),'background-size':$('#background_size').val()});
        var color = "#fff";
        var value=0;
        if(!$('#bgPage__active-overlay').is(":checked")){
            color = $(".bgPageColor-picker__overlay").css('backgroundColor');
            value=$('#ex1').val();
            $("#bgPagePreview-overlay").css({
                'background-color' : color,
                'opacity':value/100
            });
        }
        if(!$('#bgForm__active-overlay').is(":checked")){
            color = $(".bgFormColor-picker__overlay").css('backgroundColor');
            value=$('#ex2').val();
            $("#bgFormPreview-overlay").css({
                'background-color' : color,
                'opacity':value/100
            });
        }
        if($('#bgCards__active-overlay').is(":checked")){
            color = $(".bgFormColor-picker__overlay").css('backgroundColor');
            value=$('#ex3').val();
            $("#bgCardsPreview-overlay").css({
                'background-color' : color,
                'opacity':value/100
            });
        }



    }

});

//*
// ** Opacity range slider
// *

function setupicseditor(){

    var gicsgeOpts = {
        interface : ["swatches"],
        startingGradient : false,
        targetCssOutput : 'all',
        // targetElement : jQuery('.gradient'),
        defaultGradient : 'linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)',
        defaultCssSwatches : ['linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)','linear-gradient(to right bottom,rgba(31, 3, 130) 0%,rgba(3, 130, 63, 1) 100%)'],
        // targetInputElement : jQuery('.gradient-result')
    }
    jQuery('#ics-gradient-editor-1').icsge(gicsgeOpts);
    jQuery('#ics-gradient-editor-2').icsge(gicsgeOpts);
    jQuery('#ics-gradient-editor-3').icsge(gicsgeOpts);
}