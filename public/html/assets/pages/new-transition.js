$(document).ready(function () {
    var selectclosing = false;
    $('#ex1').bootstrapSlider({
        formatter: function(value) {
            $('#defaultSize').val(value);
            $(".button-pop").css('font-size', value);
            return   value +'%';
        },
        min: 25,
        max: 100,
        value: $('#defaultSize').val(),
        tooltip: 'hide',
        tooltip_position:'bottom',
    }).on("slide", function(slideEvt) {
        $("#ex1SliderVal").text(slideEvt.value+'%');
        $('.scaling-viewport').css('transform','scale('+slideEvt.value/100+')');
    });

    function get_fraola_html(selector)
    {
        var html = "";
        var paragraph_html = $(selector).find('.fr-element.fr-view').html();
        html = html+paragraph_html;
        return html;
    }

    $.FroalaEditor.DefineIcon('question', {NAME: 'question'});
    $.FroalaEditor.RegisterCommand('question', {
        title: 'Question Mark',
        focus: true,
        undo: true,
        refreshAfterCallback: true,
        callback: function () {

        },
        // plugin: 'phonePlugin'

    });
    var froala_init = $('.fb-froala__init');
    $(froala_init).froalaEditor({
        key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
        // fontFamily: font_object,
        // fontSize: fontSize,
        charCounterCount: false,
        toolbarButtons:[ 'bold', 'italic','underline', 'fontSize' , 'fontFamily' , '|','paragraphFormat', 'question' ]
    });
    $(froala_init).on('froalaEditor.click', function (e, editor, clickEvent) {
        var fraolaHtml =  get_fraola_html('.classic-editor__wrapper .fr-wrapper');
        $('.transition-preview__text').html(fraolaHtml);
    });
    $(froala_init).on('froalaEditor.keyup', function (e, editor, keyupEvent) {
        var fraolaHtml =  get_fraola_html('.classic-editor__wrapper .fr-wrapper');
        $('.transition-preview__text').html(fraolaHtml);
        console.log(fraolaHtml);
    });
    $(froala_init).on('froalaEditor.commands.after', function (e, editor, clickEvent) {
        var fraolaHtml =  get_fraola_html('.classic-editor__wrapper .fr-wrapper');
        $('.transition-preview__text').html(fraolaHtml);
    });

    jQuery('#transition-duration').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2js__transition-duration-parent"),
    }).on('select2:openning', function() {
        jQuery('.select2js__transition-duration-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__transition-duration-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__transition-duration-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__transition-duration-parent .select2-dropdown').hide();
        jQuery('.select2js__transition-duration-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__transition-duration-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.select2js__transition-duration-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#transition-duration').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__transition-duration-parent .select2-selection__rendered').show();
        jQuery('.select2js__transition-duration-parent .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('#positioning-select').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2js__positioning-parent"),
    }).on('select2:openning', function() {
        jQuery('.select2js__positioning-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__positioning-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__positioning-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__positioning-parent .select2-dropdown').hide();
        jQuery('.select2js__positioning-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__positioning-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.select2js__positioning-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#positioning-select').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__positioning-parent .select2-selection__rendered').show();
        jQuery('.select2js__positioning-parent .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('#size-select').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".select2js__size-parent"),
    }).on('select2:openning', function() {
        jQuery('.select2js__size-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__size-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__size-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__size-parent .select2-dropdown').hide();
        jQuery('.select2js__size-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__size-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.select2js__size-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#size-select').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__size-parent .select2-selection__rendered').show();
        jQuery('.select2js__size-parent .select2-results__options').css('pointer-events', 'none');
    });

   /* $('.select2js__positioning').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__positioning-parent')
    });*/

    /*$('.select2js__size').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__size-parent')
    });*/

    $('.loader__wrapper').click(function () {
        var get_loader = $(this).html();
        $('.transition-preview__loader').html(get_loader);
        $('.loader__wrapper').removeClass('active');
        $(this).addClass('active')
    });

    $('.toggle-arrow').click(function () {
        if($(this).hasClass('open')) {
            $(this).removeClass("open");
            $(this).parents('.form-group').find('.toggle-block').slideUp();
        }else {
            $(this).addClass("open");
            $(this).parents('.form-group').find('.toggle-block').slideDown();
        }
    });

    $('.action_dresponsive .action__item').click(function () {
        $('.action__item').removeClass('active');
        $(this).addClass('active');
        if($(this).hasClass('mobile')) {
            $('.scaling-viewport').css('transform','scale(0.5)');
        }else if($(this).hasClass('desktop')) {
            $('.scaling-viewport').css('transform','scale(1)');
        }
    });

});