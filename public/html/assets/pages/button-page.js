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

    font_load();
});

$(document).ready(function() {
    var amIclosing = false;

    var obj_fontawsome = {
        "plus": 'Plus',
        "arrow-thick-right": 'Forwad',
        "forwad": 'Replay',
        "long-arrow": 'Next',
        "double-arrow": 'Refer',
        "check": 'Check',
        "dotted-check": 'Mark',
        "lock": 'Lock',
        "search": 'Search',
        "thumbs": 'Thumb',
        "start-rate": 'Star',
        "heart": 'Heart',
        "location": 'Location',
        "client": 'Client',
        "email": 'Email',
        "file-upload": 'Upload',
    };

    function fontAwsome() {
        $('.icons-list').html('');
        $.each(obj_fontawsome,function (index,value) {
            $('.icons-list').append('<li><span class="icon-label"><span class="icon-wrap"><i class="icon ico-'+index+'"></i></span>' +
                '<span class="text-icon-wrap"><span class="icon-title">Icon:</span><span class="text-icon">'+value+'</span></span></span></li>');
        });
    }
    fontAwsome();

    var $fontAsome;


    $('.select-icon-opener').click(function () {
        jQuery(this).addClass('icon-popup-active');
    });

    $('.btn-cancel-icon').click(function () {
        $('.icons-list li > span').removeClass('active');
    });

    $('#select-icon-modal').on('hidden.bs.modal', function () {
        $('.select-icon-opener').removeClass('icon-popup-active');
        $('.icons-list li > span').removeClass('active');
    });

    $('body').on('click','.icons-list li > span', function(){
        var _self = jQuery(this);
        $('.icons-list li > span').removeClass('active');
        _self.addClass('active');
        $fontAsome = _self.html();
        if ($('.icons-list li > span').hasClass('active')){
            _self.parents('.select-icon-modal').find('.button-primary').removeClass('disabled');
            _self.parents('.select-icon-modal').find('.button-primary').removeAttr('disabled');
        }
    });

    $('.btn-add-icon').click(function () {
        $('.icon-popup-active').html('');
        $('.icon-popup-active').html($fontAsome);
        $('.select-icon-opener').removeClass('icon-popup-active');
        $('.icons-list li > span').removeClass('active');
        $('#select-icon-modal').modal('toggle');
    });

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
    $options = $options.add($('<option>').attr('value', '').html('Open Sans'));
    $.each(font_object , function (index , value) {
        $class = value;
        $class = $class.replace(" ", "_");
        $options = $options.add(
            $('<option>').attr('value', index).html(value).css('font-family', value)
        );
    });
    $('select.font-type').html($options).trigger('change');

    $('#ex02').bootstrapSlider({
        formatter: function(value) {
            $('#lightbox-fontsize').val(value);
            return   value +'px';
        },
        min: 8,
        max: 50,
        value: $('#lightbox-fontsize').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#ex03').bootstrapSlider({
        formatter: function(value) {
            $('#button-radius').val(value);
            return   value +'px';
        },
        min: 0,
        max: 36,
        value: $('#button-radius').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#ex04').bootstrapSlider({
        formatter: function(value) {
            $('#button-shadow').val(value);
            return   value +'%';
        },
        min: 0,
        max: 100,
        value: $('#button-shadow').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#ex06').bootstrapSlider({
        formatter: function(value) {
            $('#icon-size').val(value);
            return   value +'px';
        },
        min: 8,
        max: 50,
        value: $('#icon-size').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#button-font-family').select2({
        // minimumResultsForSearch: -1,
        //placeholder: 'Open sans',
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-button-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-button-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-button-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-button-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-button-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-button-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        //jQuery('.select2__parent-button-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-button-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#button-font-family').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight - 50;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 100);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-button-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#button-font-family').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-button-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-button-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#hover-option').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.hover-option-parent')
    }).on('change',function () {
        console.log($(this).val());
        if ($(this).val() == 1) {
            $('.hover-option-slide').slideDown();
        }else {
            $('.hover-option-slide').slideUp();
        }
    }).on('select2:openning', function() {
        jQuery('.hover-option-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.hover-option-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.hover-option-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.hover-option-parent .select2-dropdown').hide();
        jQuery('.hover-option-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.hover-option-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.hover-option-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#hover-option').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.hover-option-parent .select2-selection__rendered').show();
        jQuery('.hover-option-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('#animation-option').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.animation-option-parent')
    }).on('select2:openning', function() {
        jQuery('.animation-option-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.animation-option-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.animation-option-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.animation-option-parent .select2-dropdown').hide();
        jQuery('.animation-option-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.animation-option-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.animation-option-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('#animation-option').find(':selected').index();
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
            jQuery('.animation-option-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#animation-option').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.animation-option-parent .select2-selection__rendered').show();
        jQuery('.animation-option-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('#frequency-option').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.frequency-option-parent')
    }).on('select2:openning', function() {
        jQuery('.frequency-option-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.frequency-option-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.frequency-option-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.frequency-option-parent .select2-dropdown').hide();
        jQuery('.frequency-option-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.frequency-option-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.frequency-option-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('#frequency-option').find(':selected').index();
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
            jQuery('.frequency-option-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#frequency-option').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.frequency-option-parent .select2-selection__rendered').show();
        jQuery('.frequency-option-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('#icon-postion').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2-parent_icon-aligment')
    }).on('select2:openning', function() {
        jQuery('.select2-parent_icon-aligment .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2-parent_icon-aligment .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2-parent_icon-aligment .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-parent_icon-aligment .select2-dropdown').hide();
        jQuery('.select2-parent_icon-aligment .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2-parent_icon-aligment .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-parent_icon-aligment .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#icon-postion').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2-parent_icon-aligment .select2-selection__rendered').show();
        jQuery('.select2-parent_icon-aligment .select2-results__options').css('pointer-events', 'none');
    });

    //*
    // ** font size range slider
    // *

    $('#ex1').bootstrapSlider({
        formatter: function(value) {
            $('#fontsize').val(value);
            $(".button-pop").css('font-size', value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('#fontsize').val(),
        tooltip: 'always',
        tooltip_position:'bottom',
    });

    $('#ex2').bootstrapSlider({
        formatter: function(value) {
            $('#brdradius').val(value);
            $(".button-pop").css('border-radius', value/2.5);
            return   value +'%';
        },
        min: 0,
        max: 100,
        value: $('#brdradius').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#converttolink').val(this.checked);
    $('#converttolink').change(function () {
        var txtColor = $("#preview-button-pop-hiden").val();
        if(this.checked){
            $('.range-slider_brdradius').removeClass('disabled')
            $('.button-pop-preview .button-pop').removeClass('textlink');
            $('.button-pop-preview .button-pop').css({
                'color':'#fff' ,
                'background':txtColor
            });
        }else {
            $('.range-slider_brdradius').addClass('disabled')
            $('.button-pop-preview .button-pop').addClass('textlink');
            $('.button-pop-preview .button-pop').css({
                'color': txtColor,
                'background':'none'
            });
        }
    });

    $('#popauto').val(this.checked);
    $('#popauto').change(function () {
        if(this.checked){
            $('.available-preview').show();
            $('.unavailabel-preview').hide();
        }else {
            $('.available-preview').hide();
            $('.unavailabel-preview').show();
        }
    });

    $('.lightboxauto').change(function () {
        if(this.checked){
            $(this).parents('.lp-panel_tabs').addClass('setting-active');
            $('.toggle-delay-box').slideDown();
        }else {
            $(this).parents('.lp-panel_tabs').removeClass('setting-active');
            $('.toggle-delay-box').slideUp();
        }
    });

    $('.stealth-mode').change(function () {
        if(this.checked){
            $(this).parents('.lp-panel_tabs').removeClass('stealth-active');
            $('.stealth-mode-slide').slideDown();
        }else {
            $(this).parents('.lp-panel_tabs').addClass('stealth-active');
            $('.stealth-mode-slide').slideUp();
        }
    });

    $('.close-submit').change(function () {
        if(this.checked){
            $('.toggle-delay-closing').slideDown(function () {
                $('.right-sidebar').mCustomScrollbar("scrollTo","bottom",{
                    scrollInertia: 500
                });
            });
        }else {
            $('.toggle-delay-closing').slideUp();
        }
    });

    $('.convert-text-link').change(function () {
        if(this.checked){
            $('.convert-link-slide').slideDown();
            $('.button-accordion').slideUp();
            $(this).parents('.lp-panel_tabs').addClass('convert-link-active');
        }else {
            $('.convert-link-slide').slideUp();
            $('.button-accordion').slideDown();
            $(this).parents('.lp-panel_tabs').removeClass('convert-link-active');
        }
    });

    $('.button-icon-opener').change(function () {
        if(this.checked){
            $('.button-icon-slide').slideDown();
        }else {
            $('.button-icon-slide').slideUp();
        }
    });

    $('.txt-cta-italic').click(function () {
        $(this).toggleClass('active');
    });

    $('.txt-cta-bold').click(function () {
        $(this).toggleClass('active');
    });


    //*
    // ** Color Picker Init
    // *

    $('#bg_color01').click(function () {
        var name = ".button-background-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#bg_color02').click(function () {
        var name = ".button-text-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#bg_color03').click(function () {
        var name = ".button-background01-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#bg_color04').click(function () {
        var name = ".button-text-clr01";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#bg_color05').click(function () {
        var name = ".button-background02-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#bg_color06').click(function () {
        var name = ".button-hover-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#bg_color07').click(function () {
        var name = ".button-hover-text-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#bg_color08').click(function () {
        var name = ".button-hover-border-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('#button-hover-border-clr').ColorPicker({
        color: '#373bc1',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-hover-border-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-hover-border-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-hover-border-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-hover-border-clr .color-box__hex-block").val('#'+hex);
            $('#bg_color08').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color08').find('.last-selected__code').text('#'+hex);
        },
    });

    $('#button-hover-text-clr').ColorPicker({
        color: '#ffffff',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-hover-text-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-hover-text-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-hover-text-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-hover-text-clr .color-box__hex-block").val('#'+hex);
            $('#bg_color07').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color07').find('.last-selected__code').text('#'+hex);
        },
    });

    $('#button-hover-clr').ColorPicker({
        color: '#01c6f7',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-hover-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-hover-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-hover-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-hover-clr .color-box__hex-block").val('#'+hex);
            $('#bg_color06').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color06').find('.last-selected__code').text('#'+hex);
        },
    });

    $('#button-background-clr').ColorPicker({
        color: '#2f3743',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-background-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-background-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-background-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-background-clr .color-box__hex-block").val('#'+hex);
            $('#bg_color01').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color01').find('.last-selected__code').text('#'+hex);
        },
    });

    $('#button-background01-clr').ColorPicker({
        color: '#01c6f7',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-background01-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-background01-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-background01-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-background01-clr .color-box__hex-block").val('#'+hex);
            $('#bg_color03').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color03').find('.last-selected__code').text('#'+hex);
        },
    });

    $('#button-background02-clr').ColorPicker({
        color: '#ffffff',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-background02-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-background02-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-background02-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-background02-clr .color-box__hex-block").val('#'+hex);
            $('#bg_color05').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color05').find('.last-selected__code').text('#'+hex);
        },
    });

    $('#button-text-clr').ColorPicker({
        color: '#ffffff',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-text-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-text-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-text-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-text-clr .color-box__hex-block").val('#'+hex);
            $('#bg_color02').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color02').find('.last-selected__code').text('#'+hex);
        },
    });

    $('#button-text-clr01').ColorPicker({
        color: '#ffffff',
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".button-text-clr01 .color-box__r .color-box__rgb").val(rgb.r);
            $(".button-text-clr01 .color-box__g .color-box__rgb").val(rgb.g);
            $(".button-text-clr01 .color-box__b .color-box__rgb").val(rgb.b);
            $(".button-text-clr01 .color-box__hex-block").val('#'+hex);
            $('#bg_color04').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#bg_color04').find('.last-selected__code').text('#'+hex);
        },
    });

});

function copyToClipboard(element) {
    var myStr = $(element).text();
    var trimStr = $.trim(myStr);
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(trimStr).select();
    document.execCommand("copy");
    $temp.remove();
}
