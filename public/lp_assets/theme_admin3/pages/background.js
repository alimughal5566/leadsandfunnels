const AUTO_PULL_LOGO_COLOR = 1;
const CUSTOMIZE_OWN_COLOR = 2;
const UPLOAD_BACKGROUND_IMAGE = 3;
const SELECTED_SWATCH_BORDER = '3px solid rgb(44 62 77)';
const SWATCH_BORDER = '3px solid rgb(203 210 212)';
const COLOR_MODE_RGB = 'rgb';
const COLOR_MODE_RGBA_OBJ = 'rgba_obj';
const COLOR_MODE_RGBA = 'rgba';
const COLOR_MODE_HEX = 'hex';
let selectedImage = null;
let requesting = false;
let formSubmission = 1; //if formSubmission = 1 then form submit else no submit

function omitPercent(str) {
    return str.substring(0, str.length - 1);
}

function setColorPickerOpacity() {
    var opacity = getOwnColorOpacity();
    var pixel = 290 - Math.ceil(290 / 100 * opacity);
    pixel = pixel + "px";
    $("#bgOwnColorPage .colorpicker_opacity").children().css("top", pixel);
}


$(window).on("load", function () {
    setupicseditor();
    setColorPickerOpacity();
});
$(document).click(function (e) {
    var container = $(".pull-clr__wrapper,.color-box__panel-wrapper");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
        $('.last-selected').removeClass('open');
    }
});

$(document).ready(function () {
    getLogoColors();
    setBackgroundOverlay();
    setBacakgroundRepeat();
    setBackgroundPosition();
    setBackgroundSize();
    backgroundModule.init();


    $("body").on("change", ".bgoverly", function () {
        setpreviewsetting();
    });

    $('#overlay_previous').click(function (event) {
        let color = event.target.children[0].value;
        overlaySetColor(color);
    });

    function onFormSubmit($form) {

        var res = checkValidation($form);
        if (res) {
            ajaxRequestHandler.toastMessage = 'Saving changes...';
            ajaxRequestHandler.submitForm(function (response, isError) {
                console.log("submit callback...", response, isError);
            },true);
        }
    }

    function checkValidation($form) {
        if ($('#bgImagePage').css('display') == 'block') { //background image option

            let button_2_val1 = $('#Pagebrowse_img2').val();
            let button_2_val2 = $('#required_background_name').val();

            if (!hasImage && !button_2_val1 && !button_2_val2) {
                displayAlert('danger', 'Please select an image to upload.');
                return false;
            }

            // validate current color value
            if(lpUtilities.hexToRgb($(".color-box__hex-block").val()) == null) {
                displayAlert('danger', "Please enter correct color code.");
                return false;
            }

            $('[name=_background_name]').remove(); // No need this field while submitting. Used only to clone and store previous selected image
            requesting = true;
            return true;

        } else if ($('#bgOwnColorPage').css('display') == 'block') { //own color option selected
            // validate current color value

           var hexColor =  lpUtilities.hexToRgb($("#bgPage-modeowncolor-hex").val());
            if(hexColor == null) {
                displayAlert('danger', "Please enter correct color code.");
                return false;
            }
            return true;

        } else if ($('#bgLogoColorPage').css('display') == 'block') { //logo color option selected
            var background = $('.swatch-selected input').val();
            if(background === undefined) {
                displayAlert('danger', "Please select color.");
                return false;
            }

            var start = parseInt(background.indexOf("0%,"));
            var end = parseInt(background.indexOf("100%"));
            var testFontColor = background.slice(start,end);
            var regExp = /\(([^)]+)\)/;
            var fontcolor = "";

            try {
                var matches = regExp.exec(testFontColor);
                var rgba = matches[1].split(",");
                var red = rgba[0].trim();
                var green = rgba[1].trim();
                var blue = rgba[2].trim();
                var alpha = rgba[3].trim();
                fontcolor = rgbToHex(red,green,blue,alpha);
            }
            catch(err) {
                var loc =  testFontColor.indexOf("#");
                var tempstr = testFontColor.substring(loc);
                fontcolor = tempstr.trim();
            }
            $form.find('[name=background]').val(background);
            $form.find('[name=fontcolor]').val(fontcolor);

            // $form.submit();
            return true;
        }
    }

    $('#main-submit').click((e) => {
        e.preventDefault();

      /*  if (requesting) {
            return;
        }*/

        var $form = null;

        confirmationModalObj.removeCustomSubmitCallback();

        if ($('#bgImagePage').css('display') == 'block') { //background image option

            $form = $('#background_form');

        }
        else if ($('#bgOwnColorPage').css('display') == 'block') { //own color option selected

            let customColor = $("#customize_last_selected");
            //if we will click on save button
                customOwnColorValidate();
                let hexColor = customColor.val();
            if(customColor.val().indexOf('#') == -1){
                 hexColor = lpUtilities.rgbToHex(hexColor);
            }
            $("input[name='hexcolor']").val(hexColor);
            $form = $('#ownColorsForm');
        }
        else if ($('#bgLogoColorPage').css('display') == 'block') { //logo color option selected

            $form = $('#bgLogoColorPageForm');

            confirmationModalObj.setCustomSubmitCallback(function () {

                var background = $('.swatch-selected input').val();
                var start = parseInt(background.indexOf("0%,"));
                var end = parseInt(background.indexOf("100%"));
                var testFontColor = background.slice(start,end);
                var regExp = /\(([^)]+)\)/;
                var fontcolor = "";

                try {
                    var matches = regExp.exec(testFontColor);
                    var rgba = matches[1].split(",");
                    var red = rgba[0].trim();
                    var green = rgba[1].trim();
                    var blue = rgba[2].trim();
                    var alpha = rgba[3].trim();
                    fontcolor = rgbToHex(red,green,blue,alpha);
                }
                catch(err) {
                    var loc =  testFontColor.indexOf("#");
                    var tempstr = testFontColor.substring(loc);
                    fontcolor = tempstr.trim();
                }
                $form.find('[name=background]').val(background);
                $form.find('[name=fontcolor]').val(fontcolor);
                $form.submit();
            })

        }
        onFormSubmit($form);
    });
    //*
    // ** Tooltip
    // *
    $('.bg__el-tooltip').tooltipster({
        interactive: true,
        contentAsHTML: true,
        debug:false
    });

    //* A30-1867
    // ** Title text changer
    // *

    $(".nav__tab a").click(function () {
        var inner_txt = $(this).text();
        $(".inner__title").text(inner_txt);
    });
    bindEvent();


    $('.btn-image__del').click(function () {
        $('#Pagebrowse_img1').val('');
        $('#required_background_name').val('');
        $('#Pagebrowse_img2').val('');
        // $('[name=background_name]').val('');
        // $('[name=_background_name]').val('');
        $(this).closest('.lp-favicon__step1').slideDown();
        $(this).closest('.lp-favicon__step2').slideUp();
        $(this).closest(".browse__bg-image").css("background-image", "url('" + defaultBackgroundImageURL + "')");
        $(this).closest(".lp-image__input").val('');
        $(this).closest('.file__size,.file__extension').slideUp("slow");
        $(this).closest('.del__img').hide();
        $("#background_image_delete").hide();
        if(!hasImage){
            $('.browse__step1').slideDown();
            $('.browse__step2').slideUp();
        }
        ajaxRequestHandler.changeSubmitButtonStatus(true);
    });


    //*
    // **  Nice Scroll Global Style ((== select2js ==))
    // *

    $(".select2js__nice-scroll").click(function () {
        $('.select2-results__options').niceScroll({
            cursorcolor: "#fff",
            cursorwidth: "10px",
            autohidemode: false,
            railpadding: {top: 0, right: 0, left: 0, bottom: 0}, // set padding for rail bar
            cursorborder: "1px solid #02abec",
        });
    });

    //background repeat set
    function setBacakgroundRepeat() {
        var this_val = $('.select2__bgPage-repeat').val();
        $(".browse__bg-image").css('background-repeat', this_val);
    }

    //*
    // ** Select2 Page Tab
    // *

    $('.select2__bgPage-repeat').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-repeat-parent')
    }).on('change', function () {
        setBacakgroundRepeat();
        // valid_obj.form();
    }).on('select2:openning', function () {
        jQuery('.select2__bgPage-repeat-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2__bgPage-repeat-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2__bgPage-repeat-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-repeat-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-repeat-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2__bgPage-repeat-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgPage-repeat-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-repeat').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2__bgPage-repeat-parent .select2-selection__rendered').show();
        jQuery('.select2__bgPage-repeat-parent .select2-results__options').css('pointer-events', 'none');
    });

    function setBackgroundPosition() {
        var this_val = $('.select2__bgPage-postion').val();
        $(".browse__bg-image").css('background-position', this_val);
    }

    $('.select2__bgPage-postion').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-postion-parent')
    }).on('change', function () {
        setBackgroundPosition();
        // valid_obj.form();
    }).on('select2:openning', function () {
        jQuery('.select2__bgPage-postion-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2__bgPage-postion-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2__bgPage-postion-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-postion-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-postion-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2__bgPage-postion-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__bgPage-postion-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('.select2__bgPage-postion').find(':selected').index();
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
            jQuery('.select2__bgPage-postion-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-postion').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2__bgPage-postion-parent .select2-selection__rendered').show();
        jQuery('.select2__bgPage-postion-parent .select2-results__options').css('pointer-events', 'none');
    });

    function setBackgroundSize() {
        var this_val = $('.select2__bgPage-cover').val();
        $(".browse__bg-image").css('background-size', this_val);
    }

    $('.select2__bgPage-cover').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-cover-parent')
    }).on('change', function () {
        setBackgroundSize();
        // valid_obj.form();
    }).on('select2:openning', function () {
        jQuery('.select2__bgPage-cover-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2__bgPage-cover-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2__bgPage-cover-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-cover-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-cover-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2__bgPage-cover-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgPage-cover-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-cover').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2__bgPage-cover-parent .select2-selection__rendered').show();
        jQuery('.select2__bgPage-cover-parent .select2-results__options').css('pointer-events', 'none');
    });

    var amIclosing = false;
    $('.select2__bgPage-colormode').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__bgPage-colormode-parent')
    }).on('change', function () {
        if ($(this).val() == "hex") {
            var code_hex = $('#bgPage-modeowncolor-hex').val();
            $('#customize_last_selected,#bgPage-colorval').val(code_hex);
            $('#customize_last_selected').attr('maxlength',7);

        } else {
            var code_rgb = $('#bgPage-modeowncolor-rgb').val();
            $('#customize_last_selected,#bgPage-colorval').val(code_rgb);
            $('#customize_last_selected').attr('maxlength',13);
        }
    }).on('select2:openning', function () {
        jQuery('.select2__bgPage-colormode-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2__bgPage-colormode-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2__bgPage-colormode-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__bgPage-colormode-parent .select2-dropdown').hide();
        jQuery('.select2__bgPage-colormode-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2__bgPage-colormode-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__bgPage-colormode-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__bgPage-colormode').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
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
        if ($(this).val() == "hex") {
            var code_hex = $('#bgForm-modeowncolor-hex').val();
            $('#bgForm-colorval').val(code_hex);
        } else {
            var code_rgb = $('#bgForm-modeowncolor-rgb').val();
            $('#bgForm-colorval').val(code_rgb);
        }
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
        if ($(this).val() == "hex") {
            var code_hex = $('#bgCards-modeowncolor-hex').val();
            $('#bgCards-colorval').val(code_hex);
        } else {
            var code_rgb = $('#bgCards-modeowncolor-rgb').val();
            $('#bgCards-colorval').val(code_rgb);
        }
    });

    //bg overlay
    function setBackgroundOverlay() {
        var color = "#fff";
        var value = 0;

        if ($("#bgPage__active-overlay").is(":checked")) {
            color = $(".bgPageColor-picker__overlay").css('backgroundColor');
            value = backgroundModule.getBgImageColorOpacity();
        }
        $(".bgPageColor-picker__overlay").css("opacity", (backgroundModule.getBgImageColorOpacity()/ 100));

        color = lpUtilities.rgbToRgba(color, value/100);
        $("#bgPagePreview-overlay").css({
            'background-color': color,
            'opacity': value/100
        });
    }

    //*
    // ** Background overlay switch
    // *

    $("body").on("change", "#bgPage__active-overlay", function () {
        setBackgroundOverlay();
    });
    // $( "body" ).on( "change","#bgForm__active-overlay" , function() {
    //
    //     var color = "#fff";
    //     var value=0;
    //     if(!$(this).is(":checked")){
    //         color = $(".bgFormColor-picker__overlay").css('backgroundColor');
    //         value=$('#ex2').val();
    //     }
    //     $("#bgFormPreview-overlay").css({
    //         'background-color' : color,
    //         'opacity':value/100
    //     });
    // });
    // $( "body" ).on( "change","#bgCards__active-overlay" , function() {
    //
    //     var color = "#fff";
    //     var value=0;
    //     if($(this).is(":checked")){
    //         color = $(".bgCardsColor-picker__overlay").css('backgroundColor');
    //         value=$('#ex3').val();
    //     }
    //     $("#bgCardsPreview-overlay").css({
    //         'background-color' : color,
    //         'opacity':value/100
    //     });
    // });


    var myOwnCustomColor = getColors();
    // $('#colorMode').val($('#saved_color_mode').val());
    $('#bgPage-colorval').val($('#saved_color_mode').val() == COLOR_MODE_RGB ? $('#background_custom_color').val() : myOwnCustomColor[COLOR_MODE_HEX]);

    //
    // let color = myOwnCustomColor['rgba_obj'];
    // $('.bgPageowncolor__box').ColorPickerSetColor(color);

    $('.last-selected__box').css('backgroundColor', myOwnCustomColor[COLOR_MODE_RGBA]);
    $('#customize_last_selected').html(myOwnCustomColor[COLOR_MODE_HEX]);
    let opVal = getOwnColorOpacity();
    if (opVal > 0) {
        opVal = opVal;
    }

    $('#bgPage-modeowncolor-hex').val(myOwnCustomColor[COLOR_MODE_HEX]);
    var rgba_obj = myOwnCustomColor[COLOR_MODE_RGBA_OBJ];
    $('#bgPage-modeowncolor-rgb').val(rgba_obj.r + ', ' + rgba_obj.g + ', ' + rgba_obj.b);

    /**
     *start own color selection @mzac90
     */
    $('.bgPageowncolor__box').ColorPicker({
        color: myOwnCustomColor[COLOR_MODE_HEX],
        flat: true,
        opacity: true,
        // opacityVal:opVal,
        set_opacity: opVal/100,
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
            var rgba_fn = 'rgba(' + rgba.r + ', ' + rgba.g + ', ' + rgba.b + ', ' + rgba.a + ')';
            // $('#background_overlay_opacity').val(Math.floor(rgba.a * 100) + '%');
            let opacity = Math.floor(rgba.a * 100);
            $("#own-color-opacity").text(opacity+'%');
            $('.own-color-opacity-slider').bootstrapSlider('setValue', opacity);
            var $this_elm = $(this).parents('.owncolor__wrapper');
            $this_elm.find('.last-selected__code').val('#' + hex).trigger('change');
            $this_elm.find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bgPage-modeowncolor-hex').val('#' + hex);
            $('#bgPage-modeowncolor-rgb').val(rgb.r + ', ' + rgb.g + ', ' + rgb.b);
            if ($('.select2__bgPage-colormode').val() == 'hex') {
                $('#saved_color_mode').val(COLOR_MODE_HEX);
                $('#bgPage-colorval').val('#' + hex);
                $('#background_custom_color').val('#' + hex);
            } else {
                $('#customize_last_selected,#bgPage-colorval').val(rgb.r + ', ' + rgb.g + ', ' + rgb.b).trigger('change');
                $('#saved_color_mode').val(COLOR_MODE_RGB);
                $('#background_custom_color').val(rgb.r + ', ' + rgb.g + ', ' + rgb.b);
            }
        }
    });

    var debounceCustomOwnColorValidate = lpUtilities.debounce(customOwnColorValidate,400);

    $(document).on("keyup","#customize_last_selected",function (e){
        var colorCode = $(this).val();
        if(e.keyCode === 13){
            customOwnColorValidate();
        }

        debounceCustomOwnColorValidate();
    });

    /**
     *end own color selection @mzac90
     */
    $('.bgFormowncolor__box').ColorPicker({
        color: "#e6eef3",
        flat: true,
        opacity: true,
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
            $this_elm.find('.last-selected__code').html('#' + hex);
            $this_elm.find('.last-selected__box').css('backgroundColor', '#' + hex);
            $('#bgForm-modeowncolor-hex').val('#' + hex);
            $('#bgForm-modeowncolor-rgb').val(rgb.r + ', ' + rgb.g + ', ' + rgb.b);
            if ($('.select2__bgForm-colormode').val() == 'hex') {
                $('#bgForm-colorval').val('#' + hex);
            } else {
                $('#bgForm-colorval').val(rgb.r + ', ' + rgb.g + ', ' + rgb.b);
            }
        }
    });

    $('.bgPageColor-picker__overlay').click(function () {
        var name = ".main-bg-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this, name);
        lpUtilities.set_colorpicker_box(color_box_name, get_color);
    });

    $('.bgFormColor-picker__overlay').click(function () {
        var name = ".funnel-bg-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this, name);
        lpUtilities.set_colorpicker_box(color_box_name, get_color);
    });

    //*
    // ** Overlay color picker
    // *
////


    /**
     * start background color picker and opacity set @mzac90
     */
    $('#mian-bg-colorpicker').ColorPicker({
        color: "#6a9994",
        flat: true,
        opacity: true,
        set_opacity: backgroundModule.getBgImageColorOpacity()/100,
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
            $(".main-bg-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".main-bg-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".main-bg-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".main-bg-clr .color-box__hex-block").val('#' + hex).trigger('change');
            $("#bgPageImg-overlay").val('#' + hex).trigger('change');
            $('.bgPagePreview-overlay').css('backgroundColor', rgba_fn);
            $('.bgPageColor-picker__overlay').css({'backgroundColor': rgba_fn, 'opacity': ''});

            let opacity = Math.ceil((rgba.a * 100));
            $('#bgPageOverlay_color_opacity').val(opacity );
            $('#bg-image-opacity').val(opacity + '%');
            $('.bg-image-opacity-slider').bootstrapSlider('setValue', opacity);

            $("#last_selected_code").html('#' + hex);

            setpreviewsetting();
        }
    });

    $(document).on('keyup',".main-bg-clr .color-box__hex-block",function (){
        var rgb = lpUtilities.hexToRgb($(this).val());
        if(rgb) {
            var value = backgroundModule.getBgImageColorOpacity();
            var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+ value/100 +')';
            $(".main-bg-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".main-bg-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".main-bg-clr .color-box__b .color-box__rgb").val(rgb.b);
            $('#bgPagePreview-overlay').css('backgroundColor', rgba_fn);
            $('.bgPageColor-picker__overlay').css({'background-color': rgba_fn, 'opacity': ''});
            $('#bgPageImg-overlay').val($(this).val()).trigger('change');
            $("#last_selected_code").html($(this).val());
            $("#mian-bg-colorpicker").ColorPickerSetColor($(this).val());
        }
    });

    $(document).on('blur',".main-bg-clr .color-box__hex-block",function (){
        if(lpUtilities.hexToRgb($(this).val()) == null) {
            displayAlert('danger', "Please enter correct color code.");
        }
    });

    /**
     * end background color picker and opacity set @mzac90
     */

    overlaySetColor(backgroundOverlayColor);

    jQuery('body').on('change', '.background-card input[type="radio"]', function(){
        var _self = jQuery(this);
        jQuery('.background-slide').slideUp();
        jQuery('.background-card').removeClass('active');
        _self.parents('.background-card').addClass('active');
        _self.parents('.background-card').find('.background-slide').slideDown();
        let formId = _self.parents('.background-card').find("form").attr('id');

        console.log("Background ...", formId);
         ajaxRequestHandler.init("#"+formId, {
             globalCustomCb: backgroundModule.onGlobalFieldChangeHandleButton,
             alwaysBindEvent: true
         });
    });
    selectedFormFieldValue();
});

//*
// ** Opacity range slidermain-submit
// *

function setupicseditor() {

    var gicsgeOpts = {
        interface: ["swatches"],
        startingGradient: false,
        targetCssOutput: 'all',
        // targetElement : jQuery('.gradient'),
        defaultGradient: 'linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)',
        defaultCssSwatches: ['linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)'],
        // targetInputElement : jQuery('.gradient-result')
    }
    jQuery('#ics-gradient-editor-1').icsge(gicsgeOpts);
    jQuery('#ics-gradient-editor-2').icsge(gicsgeOpts);
    jQuery('#ics-gradient-editor-3').icsge(gicsgeOpts);
    var color = $('#background-overlay').val();
    if (!color) {
        color = '#ffffff';
    }
    if ($('#background-overlay').val())
        $('.colorpicker_color').css('background-color', color);
    $('.colorpicker_new_color').css('background-color', color);
}


/*
* Render logo color swatches
* */
function getLogoColors() {
    var swatches = JSON.parse($("input[name='swatches']").val());
    if(swatches.length) {
        let index = 0;
        let colors = [];
         swatches.forEach((row) => {
            if (!colors.includes(row.swatch)) {
                colors.push(row.swatch);
                swatches.push(row);
                createDiv(row, index++);
            }
        });
    }
}

/*
* Create a color div and append in the logo color div
* @param data //Swatch Response Data
* @param index //Index of the color
* */
function createDiv(data, index) {
    let selected = (selectedSwatch == data.swatch) ? true : false;
    if(selected){
        $("#swatchnumber").val(data.id);
    }
    let style = `background:${data.swatch}; height: 50px;width: 50px;border-radius: 6px; cursor:pointer`;
    let div = `<div id="custom-button-${index}" onclick="selectCustomButton(${data.id},${index})" class="${selected ? 'swatch-selected' : ''}" style="border: ${selected ? SELECTED_SWATCH_BORDER : SWATCH_BORDER} ;padding: 3px;width: auto;border-radius: 10px; display: inline-block; margin: 4px">
                    <div style='${style}'>
                        <input type="text" hidden value="${data.swatch}">
                    </div>
                </div>`;
    $("#logo-colors").append(div);
}

function selectCustomButton(id,index) {
    $("#swatchnumber").val(id).trigger('change');
    $('.swatch-selected').css('border', SWATCH_BORDER);
    $('#logo-colors .swatch-selected').attr('class', '');
    $(`#custom-button-${index}`).css('border', SELECTED_SWATCH_BORDER);
    $(`#custom-button-${index}`).addClass('swatch-selected');

}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b, a) {
    return rgbStringToHex(`rgba(${r}, ${g}, ${b}, ${a})`);
}

function setpreviewsetting() {
    $('.browse__bg-image').css({
        'background-repeat': $('select[name=background-repeat]').val(),
        'background-position': $('#background-position').val(),
        'background-size': $('#background_size').val()
    });
    var color = "#fff";
    var value = 0;
    if ($('#bgPage__active-overlay').is(":checked")) {
        color = $(".bgPageColor-picker__overlay").css('backgroundColor');
        value = backgroundModule.getBgImageColorOpacity();
        color = lpUtilities.rgbToRgba(color, value/100);
        let opacity = value/100;
        $("#bgPagePreview-overlay").css({
            'background-color': color,
            'opacity': opacity
        });
        $(".bgPageColor-picker__overlay").css('opacity', opacity);
    }
    if (!$('#bgForm__active-overlay').is(":checked")) {
        color = $(".bgFormColor-picker__overlay").css('backgroundColor');
        value = $('#ex2').val();
        $("#bgFormPreview-overlay").css({
            'background-color': color,
            'opacity': value / 100
        });
    }
    if ($('#bgCards__active-overlay').is(":checked")) {
        color = $(".bgFormColor-picker__overlay").css('backgroundColor');
        value = $('#ex3').val();
        $("#bgCardsPreview-overlay").css({
            'background-color': color,
            'opacity': value / 100
        });
    }
}

/**
 * Hex to RGB
 * */
function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

/*Overlay Set Color
*@param: color
* **/
function overlaySetColor(color) {
    $('#mian-bg-colorpicker').ColorPickerSetColor(color);
    var alpha = backgroundModule.getBgImageColorOpacity();
    let rgb = hexToRgb(color);
    var rgba_fn = 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + alpha + ')';
    $(".main-bg-clr .color-box__r .color-box__rgb").val(rgb.r);
    $(".main-bg-clr .color-box__g .color-box__rgb").val(rgb.g);
    $(".main-bg-clr .color-box__b .color-box__rgb").val(rgb.b);
    $(".main-bg-clr .color-box__hex-block").val(color);
    $("#bgPageImg-overlay").val(color);
    $('.bgPagePreview-overlay').css('backgroundColor', rgba_fn);
    $('.bgPageColor-picker__overlay').css('backgroundColor', rgba_fn);
    setpreviewsetting();
}

function getOwnColorOpacity() {
    return $('#background_overlay_opacity').val() || 100;
}

function bindEvent() {
    $(".lp-image__input").click(function () {


    }).change(function () {
        readURL(this);
    });
}

function cloneAndSetValue() {
    if ($("#Pagebrowse_img2").val()) { // if there is any image value in the main file selector then we will make a clone other wise no need
        $("#required_background_name").remove();//Remove cloned field if there is any.
        $("#Pagebrowse_img2").clone().prop('id', 'temp_id').appendTo($("#Pagebrowse_img2").parent());   //clone original file selector (which may have some file) i.e. Pagebrowse_img2 and give its id as temp_id
        $("#Pagebrowse_img2").attr('name', "background_name"); // as it may have some file so we are setting its name to "background_name" which is required in back end
        $("#Pagebrowse_img2").attr('id', "required_background_name"); // and we are setting its ids as required_background_name
        $('#temp_id').attr('name', "_background_name"); //now we are making newly cloned file selector the current file selector by giving its name _background_name
        $('#temp_id').attr('id', "Pagebrowse_img2"); //and giving its id Pagebrowse_img2
        // $("#required_background_name").parent().attr('for', "required_background_name");//Updating for val
        bindEvent(); // Finally we are binding events again as binding is broken due to clone
    }
}


//*
// **  favicon Image Preview
// *

function readURL(input) {
    var this_input = input;
    if (input.files && input.files[0]) {

        /*
         ** Profile Image Upload Validation
         */

        var file = this_input.files[0];

        if(!isValidExtension(file.name)){
        // if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg']) == -1) {
            let message = "Invalid image format. Image format must be PNG, JPG, or JPEG.";
            displayAlert("danger", message);
            // $(this_input).parentsUntil(".tab-pane.active").find('.file__extension').slideDown("slow");
            // $(this_input).parentsUntil(".tab-pane.active").find('.file__size').slideUp("slow");
            $(input).val("");
            $('#Pagebrowse_img2').val('');
        }
        else if ((file.size / 1024) > validationConfig.background_image_size) {
            let message = "The file is too large. Maximum allowed file size is " + (validationConfig.background_image_size / 1024) + "MB.";
            displayAlert("danger", message);
            // $(this_input).parentsUntil(".tab-pane.active").find('.file__size').slideDown("slow");
            // $(this_input).parentsUntil(".tab-pane.active").find('.file__extension').slideUp("slow");
            $(input).val("");
            $('#Pagebrowse_img2').val('');
        }
        else {
            cloneAndSetValue();
            // var $this = $(input), $clone = $this.clone();
            // $this.after($clone).appendTo("#background_form");

            $(this_input).parentsUntil(".tab-pane.active").find('.file__size,.file__extension').slideUp("slow");
            $(this_input).parentsUntil(".tab-pane.active").find('.browse__step1').slideUp();
            $(this_input).parentsUntil(".tab-pane.active").find('.browse__step2').slideDown();
            var reader = new FileReader();
            reader.onload = function (e) {
                selectedImage = JSON.parse(JSON.stringify(e.target.result));
                $(this_input).parentsUntil(".tab-pane.active").find('.browse__bg-image').css('background-image', 'url(' + e.target.result + ')');
                $(this_input).parentsUntil(".tab-pane.active").find('.del__img').show();
                $("#background_image_delete").show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

}


//*
// ** Own color tabs
// *
function getColors() {
    let savedColor = $('#background_custom_color').val() || "#ffffff";
    let colorMode = $('#saved_color_mode').val() || "hex";
    let color = {};
    if (savedColor.length) {
        if (colorMode == COLOR_MODE_RGB) {
            let rgb = savedColor.split(',');
            let r = rgb[0];
            let g = rgb[1];
            let b = rgb[2];
            let a = getOwnColorOpacity() / 100;

            color[COLOR_MODE_RGB] = `rgb(${r},${g},${b})`;
            color[COLOR_MODE_RGBA] = `rgba(${r},${g},${b},${a})`;
            color[COLOR_MODE_HEX] = rgbToHex(r, g, b, a);
            color[COLOR_MODE_RGBA_OBJ] = {r: r, g: g, b: b, a: a};
        } else {
            color[COLOR_MODE_HEX] = savedColor;
            let rgb = hexToRgb(savedColor);
            let r = rgb.r;
            let g = rgb.g;
            let b = rgb.b;
            let a = getOwnColorOpacity() / 100;

            color[COLOR_MODE_RGB] = `rgb(${r},${g},${b})`;
            color[COLOR_MODE_RGBA] = `rgba(${r},${g},${b},${a})`;
            color[COLOR_MODE_RGBA_OBJ] = {r: r, g: g, b: b, a: a};

        }
    } else {
        color[COLOR_MODE_RGB] = `rgb(255,255,255)`;
        color[COLOR_MODE_RGBA] = `rgb(255,255,255,255)`;
        color[COLOR_MODE_RGBA_OBJ] = {r: 255, g: 255, b: 255, a: 1};
    }
    return color;

};


/**
 * New functions will be added into this module
 * @type {{init: backgroundModule.init, initOwnColorBindings: backgroundModule.initOwnColorBindings}}
 */
var backgroundModule = {
    background_option: null,
    init: function() {
        this.initOwnColorBindings();
        this.initBgImageColorBindings();
        this.setBackgroundOption();
    },

    initOwnColorBindings: function () {
        $('.own-color-opacity-slider').bootstrapSlider({
            min: 0,
            max: 100,
            value: background_overlay_opacity,
            step: 1,
            tooltip: 'always',
            tooltip_position:'bottom',
            formatter: function(value) {
                return value + '%' ;
            },
        }).on("change", function(slideEvt) {
            $(".bgPageowncolor__box").ColorPickerSetOpacity((slideEvt.value.newValue / 100));
            // $('.last-selected__box').css('backgroundColor', getColors()[COLOR_MODE_RGBA]);
            $('.active').find('.owncolor__wrapper .last-selected__box').css('backgroundColor', getColors()[COLOR_MODE_RGBA]);
        });
    },

    setBackgroundOption: function () {
        backgroundModule.background_option = $('.background-card input[type="radio"]:checked').val();
    },

    getBgImageColorOpacity: function() {
        return $("#bg_image_overlay_opacity").val() || 100;
    },
    initBgImageColorBindings: function () {
        $('.bg-image-opacity-slider').bootstrapSlider({
            min: 0,
            max: 100,
            value: $("#bgPageOverlay_color_opacity").val(),
            step: 1,
            tooltip: 'always',
            tooltip_position:'bottom',
            formatter: function(value) {
                return value + '%' ;
            },
        }).on("change", function(slideEvt) {

            if ($("#bgPage__active-overlay").is(":checked")) {

                let opacity = (slideEvt.value.newValue / 100);

                $("#mian-bg-colorpicker").ColorPickerSetOpacity(opacity);

                //Updating color overlay
                $('.bgPageColor-picker__overlay').css('opacity', opacity);
                //Updating image preview css
                $('#bgPagePreview-overlay').css('opacity', opacity);
                let rgb = $('#bgPagePreview-overlay').css('background-color');
                let rgba = lpUtilities.rgbToRgba(rgb, opacity);
                $('#bgPagePreview-overlay').css('background-color', rgba);
                $('.bgPageColor-picker__overlay').css('background-color', rgba);
            }
        });
    },

    /**
     * used to change submit buttion on the base of background option change
     * Will reset initial value after changes will be saved
     * will be executed when any form field will be changes
     * @param disabled
     * @param reset
     * @returns {boolean|*}
     */
    onGlobalFieldChangeHandleButton: function (disabled, reset) {
        if(!disabled) {
            return disabled;
        }

        if(reset === true) {
            // reset value to current value after changes saved
            backgroundModule.setBackgroundOption();
        }

        console.log("Background option - ", $('.background-card input[type="radio"]:checked').val(), backgroundModule.background_option, reset);
        return $('.background-card input[type="radio"]:checked').val() == backgroundModule.background_option;
    }
};


/**
 * this function use for check the custom own color code validation
 * @param coloCode
 */
function customOwnColorValidate() {
    let rgb = colorCode = '';
    colorCode = $("#customize_last_selected").val();
    let findIndex = colorCode.indexOf('#');
    if(formSubmission === 0) {
        if ($('.select2__bgPage-colormode').val() === 'hex' && lpUtilities.hexToRgb(colorCode) === null) {
            displayAlert('danger', "Please enter correct color code.");
        }
        if ($('.select2__bgPage-colormode').val() === 'rgb' && lpUtilities.rgbToHex(colorCode) === null) {
            displayAlert('danger', "Please enter correct color code.");
        }
        formSubmission = 2;
    }

    if (findIndex == -1 && colorCode.length === 6) {
        colorCode = '#' + colorCode;
    } else if (findIndex == -1 && colorCode.length === 7) {
        colorCode = '#' + colorCode.substr(0, 6);
    }
    if ($('.select2__bgPage-colormode').val() === 'rgb') {
        colorCode = lpUtilities.rgbToHex(colorCode);
    }
    rgb = lpUtilities.hexToRgb(colorCode);
    if(rgb)
    {
        var $this_elm = $('#customize_last_selected').parents('.owncolor__wrapper');
        var value = $('#background_overlay_opacity').val();
        var rgba_fn = 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ',' + value / 100 + ')';
        $this_elm.find('.last-selected__box').css('backgroundColor', rgba_fn);
        $(".bgPageowncolor__box").ColorPickerSetColor(colorCode);
        if ($('.select2__bgPage-colormode').val() === 'rgb') {
            $('#bgPage-modeowncolor-rgb,#customize_last_selected,#bgPage-colorval').val(rgb.r + ', ' + rgb.g + ', ' + rgb.b);
        } else {
            $('#bgPage-colorval').val(colorCode);
            $("#bgPage-modeowncolor-hex,#customize_last_selected").val(colorCode);
        }
        formSubmission = 1;
    }
}

function selectedFormFieldValue(){
    let forms = $(".background-slide");
    forms.each(function (i, el){
       if($(el).css('display') == 'block'){
           let formId = $(el).find("form").attr('id');

           console.log("Background selectedFormFieldValue ...", formId);
           ajaxRequestHandler.init("#"+formId, {
               globalCustomCb: backgroundModule.onGlobalFieldChangeHandleButton,
               alwaysBindEvent: true
           });
       }
    });
}
