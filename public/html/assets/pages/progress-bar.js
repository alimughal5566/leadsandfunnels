$(window).on('load',function() {
    setupicseditor();
});
$(document).ready(function() {
    var amIclosing = false;
    
    $('#select2__selectbar').select2({
        minimumResultsForSearch: -1,
        width: '192px', // need to override the changed default
        dropdownParent: $('.select2__selectbar-parent')
    }).on('change', function () {
        if($(this).val() == 'h') {
            $('.lp-panel-circle-bar').slideUp();
            $('.lp-panel-horizontal-bar').slideDown();
        }else {
            $('.lp-panel-horizontal-bar').slideUp();
            $('.lp-panel-circle-bar').slideDown();
        }
    });






    var bar_style = [
        {
            id:0,
            text:'<div class="bar_style">Percentage <span>(use % of completion to visualize your progress)</span></div>',
            title:'Percentage ( use the % to visualize your progress )'
        },
        {
            id:1,
            text:'<div class="bar_style">Steps <span>(use the total # of questions to visualize your progress)</span></div>',
            title:'Steps ( use the total # to visualize your progress )'
        }
    ];

    $('.select2js__horizontal-bar').select2({
        width: '510px',
        data:bar_style,
        minimumResultsForSearch: -1,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: $('.select2js__horizontal-bar-parent')
    }).on('select2:openning', function() {
        $('.select2js__horizontal-bar-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $('.select2js__horizontal-bar-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            $('.select2js__horizontal-bar-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        $('.select2js__horizontal-bar-parent .select2-dropdown').hide();
        $('.select2js__horizontal-bar-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        $('.select2js__horizontal-bar-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            $('.select2js__horizontal-bar-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                $('.select2js__horizontal-bar').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        $('.select2js__horizontal-bar-parent .select2-selection__rendered').show();
        $('.select2js__horizontal-bar-parent .select2-results__options').css('pointer-events', 'none');
    });
    
    

    $('.select2js__circel-bar').select2({
        width: '222px',
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2js__circel-bar-parent')
    }).on('change',function () {
        if ($(this).val() == 0) {
            $('.sign-steps').hide();
            $('.sign-percentage').show();
            $('.progress').removeClass('steps');
        }else {
            $('.sign-steps').show();
            $('.progress').addClass('steps');
            $('.sign-percentage').hide();
        }
    });

    $('.pull-clr').click(function (e) {
        e.stopPropagation();
        $('.pull-clr__wrapper').fadeOut();
        $('.pull-clr').removeClass('open');
        $(this).toggleClass('open');
        $(this).parents('.col-clr').find('.pull-clr__wrapper').fadeToggle();
    });
    $('[name="color-settings"]').click(function(){
        if($(this).val() == 0) {
            $('.inner__block').find('.last-selected.clr-picker').hide();
           $('.inner__block').find('.last-selected.pull-clr').css('display','flex');
        }else {
            $('.inner__block').find('.last-selected.pull-clr').hide();
            $('.inner__block').find('.last-selected.clr-picker').css('display','flex');
        }
    });

    // var select_button = $(elm2).offsetParent();
    // var select_total = $(select_button).offset().top + select_dropdown;

    // function lpUtilities.custom_color_picker(elm,elm2){
    //     event.stopPropagation();
    //     var window_height = $(window).height();
    //     var select_button = $(elm2).offsetParent();
    //     var pos_top = $(select_button).offset().top;
    //     var pos_left = $(select_button).offset().left;
    //     var select_dropdown = $('.color-box__panel-wrapper').height();
    //     var select_total = pos_top + select_dropdown;
    //     // $(this).toggleClass('open');
    //     // $('.selection-dropdown__inner-wrapper').not(this).removeClass('open');
    //     var notthis = $('.color-box__panel-wrapper'+ elm +'');
    //     $('.color-box__panel-wrapper').not(notthis).fadeOut();
    //     $('.color-box__panel-wrapper'+ elm +'').fadeToggle();
    //     if(window_height < select_total){
    //         $('.color-box__panel-wrapper').addClass("shadow-none");
    //         $('.color-box__panel-wrapper'+ elm +'').offset({top:pos_top - select_dropdown -45, left:pos_left-190});
    //         console.info(pos_top-select_dropdown -45);
    //     }
    //     else {
    //         $('.color-box__panel-wrapper').removeClass("shadow-none");
    //         $('.color-box__panel-wrapper'+ elm +'').offset({top:pos_top+49, left:pos_left-190});
    //     }
    // }

    // function lpUtilities.custom_color_picker(elm,elm2){
    //     event.stopPropagation();
    //     var window_height = $(window).height();
    //     var select_button = $(elm2).offsetParent();
    //     var pos_top = $(select_button).offset().top;
    //     var pos_left = $(select_button).offset().left;
    //     var select_dropdown = $('.color-box__panel-wrapper').outerHeight();
    //     var select_total = pos_top + select_dropdown + $(elm2).height() - $(window).scrollTop();
    //     // $(this).toggleClass('open');
    //     // $('.selection-dropdown__inner-wrapper').not(this).removeClass('open');
    //     var notthis = $('.color-box__panel-wrapper'+ elm +'');
    //     $('.color-box__panel-wrapper').not(notthis).fadeOut();
    //     $('.color-box__panel-wrapper'+ elm +'').fadeToggle();
    //     var rtl = pos_left + select_button.outerWidth() -330;
    //     if(window_height < select_total){
    //         $('.color-box__panel-wrapper'+ elm +'').offset({top:pos_top - select_dropdown, left: rtl });
    //     }
    //     else {
    //         $('.color-box__panel-wrapper'+ elm +'').offset({top:pos_top+49, left: rtl });
    //     }
    // }

    $('#clr-bg-horizontal-colorpicker').click(function () {
        var name = ".clr-setting-bg";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);

        // lpUtilities.custom_color_picker('.clr-setting-bg',$(this));
    });
    $('#clr-bar-horizontal-colorpicker').click(function () {
        var name = ".clr-setting-bar";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
        // lpUtilities.custom_color_picker.call('.clr-setting-bar',$(this));
    });
    $('#clr-brd-horizontal-colorpicker').click(function () {
        var name = ".clr-setting-brd";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
        // lpUtilities.custom_color_picker.call('.clr-setting-brd',$(this));
    });
    $('#clr-bg-horizontalpro-colorpicker').click(function () {
        var name = ".clr-progress-bg";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
        // lpUtilities.custom_color_picker.call('.clr-progress-bg',$(this));
    });
    $('#clr-txt-horizontalpro-colorpicker').click(function () {
        var name = ".clr-progress-txt";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
        // lpUtilities.custom_color_picker.call('.clr-progress-txt',$(this));
    });

    $('#clr-txt-circel-colorpicker').click(function () {
        var name = ".clr-circle-txt";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        // lpUtilities.custom_color_picker.call('.clr-circle-txt',$(this));
    });
    $('#clr-txtloader-circel-colorpicker').click(function () {
        var name = ".clr-circle-txtloader";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        // lpUtilities.custom_color_picker.call('.clr-circle-txtloader',$(this));
    });

    var setting_bg_colorpicker = $('#clr-setting-bg');
    var setting_bar_colorpicker = $('#clr-setting-bar');
    var setting_brd_colorpicker = $('#clr-setting-brd');
    var progress_bg_colorpicker = $('#clr-progress-bg');
    var progress_txt_colorpicker = $('#clr-progress-txt');
    var circle_txt = $('#clr-circle-txt');
    var circle_txtloader = $('#clr-circle-txtloader');

    $(setting_bg_colorpicker).ColorPicker({
        color: "#f8f9f9",
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
        onChange: function (hsb, hex, rgb) {
            $(".clr-setting-bg .color-box__r .color-box__rgb").val(rgb.r);
            $(".clr-setting-bg .color-box__g .color-box__rgb").val(rgb.g);
            $(".clr-setting-bg .color-box__b .color-box__rgb").val(rgb.b);
            $(".clr-setting-bg .color-box__hex-block").val('#'+hex);
            $('#clr-bg-horizontal-colorpicker').find(".last-selected__code").text('#'+hex);
            $('#clr-bg-horizontal-colorpicker').find(".last-selected__box").css('backgroundColor', '#' + hex);
            $('.horizontal-bar-bg').css('backgroundColor', '#' + hex);
        }
    });
    $(setting_bar_colorpicker).ColorPicker({
        color: "#01aef0",
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
        onChange: function (hsb, hex, rgb) {
            $(".clr-setting-bar .color-box__r .color-box__rgb").val(rgb.r);
            $(".clr-setting-bar .color-box__g .color-box__rgb").val(rgb.g);
            $(".clr-setting-bar .color-box__b .color-box__rgb").val(rgb.b);
            $(".clr-setting-bar .color-box__hex-block").val('#'+hex);
            $('#clr-bar-horizontal-colorpicker').find(".last-selected__code").text('#'+hex);
            $('#clr-bar-horizontal-colorpicker').find(".last-selected__box").css('backgroundColor', '#' + hex);
            $('.slider-selection').css('backgroundColor', '#' + hex);
        }
    });
    $(setting_brd_colorpicker).ColorPicker({
        color: "#c9d7dd",
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
        onChange: function (hsb, hex, rgb) {
            $(".clr-setting-brd .color-box__r .color-box__rgb").val(rgb.r);
            $(".clr-setting-brd .color-box__g .color-box__rgb").val(rgb.g);
            $(".clr-setting-brd .color-box__b .color-box__rgb").val(rgb.b);
            $(".clr-setting-brd .color-box__hex-block").val('#'+hex);
            $('#clr-brd-horizontal-colorpicker').find(".last-selected__code").text('#'+hex);
            $('#clr-brd-horizontal-colorpicker').find(".last-selected__box").css('backgroundColor', '#' + hex);
            $('.slider-track').css('background-color','#' +hex);
        }
    });
    $(progress_bg_colorpicker).ColorPicker({
        color: "#073146",
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
        onChange: function (hsb, hex, rgb) {
            $(".clr-progress-bg .color-box__r .color-box__rgb").val(rgb.r);
            $(".clr-progress-bg .color-box__g .color-box__rgb").val(rgb.g);
            $(".clr-progress-bg .color-box__b .color-box__rgb").val(rgb.b);
            $(".clr-progress-bg .color-box__hex-block").val('#'+hex);
            $('#clr-bg-horizontalpro-colorpicker').find(".last-selected__code").text('#'+hex);
            $('#clr-bg-horizontalpro-colorpicker').find(".last-selected__box").css('backgroundColor', '#' + hex);
            $('.horizontal-bar__wrapper .slider-horizontal .tooltip-inner').css('backgroundColor', '#' + hex);
            $('.horizontal-bar__wrapper .slider-horizontal .tooltip-arrow').css('border-bottom-color', '#' + hex +'!important');
        }
    });
    $(progress_txt_colorpicker).ColorPicker({
        color: "#f8f9f9",
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
        onChange: function (hsb, hex, rgb) {
            $(".clr-progress-brd .color-box__r .color-box__rgb").val(rgb.r);
            $(".clr-progress-brd .color-box__g .color-box__rgb").val(rgb.g);
            $(".clr-progress-brd .color-box__b .color-box__rgb").val(rgb.b);
            $(".clr-progress-brd .color-box__hex-block").val('#'+hex);
            $('#clr-txt-horizontalpro-colorpicker').find(".last-selected__code").text('#'+hex);
            $('#clr-txt-horizontalpro-colorpicker').find(".last-selected__box").css('backgroundColor', '#' + hex);
            $('.horizontal-bar__wrapper .slider-horizontal .tooltip-inner').css('color', '#' + hex);
        }
    });
    $(circle_txt).ColorPicker({
        color: "#b2b1be",
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
        onChange: function (hsb, hex, rgb) {
            $(".clr-circle-txt .color-box__r .color-box__rgb").val(rgb.r);
            $(".clr-circle-txt .color-box__g .color-box__rgb").val(rgb.g);
            $(".clr-circle-txt .color-box__b .color-box__rgb").val(rgb.b);
            $(".clr-circle-txt .color-box__hex-block").val('#'+hex);
            $('.progress__text_js').css('color','#'+hex);
            $('#clr-txt-circel-colorpicker').find(".last-selected__code").text('#'+hex);
            $('#clr-txt-circel-colorpicker').find(".last-selected__box").css('backgroundColor', '#' + hex);
        }
    });
    $(circle_txtloader).ColorPicker({
        color: "#5665f6",
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
        onChange: function (hsb, hex, rgb) {
            $(".clr-circle-txtloader .color-box__r .color-box__rgb").val(rgb.r);
            $(".clr-circle-txtloader .color-box__g .color-box__rgb").val(rgb.g);
            $(".clr-circle-txtloader .color-box__b .color-box__rgb").val(rgb.b);
            $(".clr-circle-txtloader .color-box__hex-block").val('#'+hex);
            $('.progress__text--percentage').css('color','#'+hex);
            $('.progress__js_progress').css('stroke','#'+hex);
            $('#clr-txtloader-circel-colorpicker').find(".last-selected__code").text('#'+hex);
            $('#clr-txtloader-circel-colorpicker').find(".last-selected__box").css('backgroundColor', '#' + hex);
        }
    });

    $('#ex1').bootstrapSlider({
        formatter: function(value) {
            $('#bgPageOverlay_color_opacity').val(value);
            if ($('#bgPage__active-overlay').is(":checked")){
                $("#bgPagePreview-overlay").css('opacity', value/100);
            }
            if ($('.select2js__horizontal-bar').val() == 0) {
                return   value +'%';
            }
            else {
                return   value +'px';
            }
        },
        min: 1,
        max: 100,
        value: $('#bgPageOverlay_color_opacity').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });


    $('#mobile').click(function () {
        $('.progress-content').css('transform','scale(0.7)');
    });
    $('#computer').click(function () {
        $('.progress-content').css('transform','scale(1)');
    });

    $( "body" ).on( "change","#horizontal-bar-check" , function() {
        if($(this).is(":checked")){
            $('.clr-elm__wrapper_flag .col-clr').removeClass('disabled');
            $('.horizontal-bar .slider .tooltip.tooltip-main.bottom.in').fadeIn();
        }else {
            $('.clr-elm__wrapper_flag .col-clr').addClass('disabled');
            $('.horizontal-bar .slider .tooltip.tooltip-main.bottom.in').fadeOut();
        }
    });


});

function setupicseditor(){

    var gicsgeOpts = {
        interface : ["swatches"],
        startingGradient : false,
        targetCssOutput : 'all',
        // targetElement : $('.gradient'),
        defaultGradient : 'linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)',
        defaultCssSwatches : ['linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)'],
        // targetInputElement : $('.gradient-result')
    }
    $('#ics-gradient-editor-1').icsge(gicsgeOpts);
    $('#ics-gradient-editor-2').icsge(gicsgeOpts);
    $('#ics-gradient-editor-3').icsge(gicsgeOpts);
    $('#ics-gradient-editor-4').icsge(gicsgeOpts);
    $('#ics-gradient-editor-5').icsge(gicsgeOpts);
    $('#ics-gradient-editor-6').icsge(gicsgeOpts);
    $('#ics-gradient-editor-7').icsge(gicsgeOpts);
}
$(document).click(function(e) {
    var container = $(".pull-clr__wrapper,.color-box__panel-wrapper");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
        $('.last-selected').removeClass('open');
    }
});