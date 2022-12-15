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
    "AbrilFatface": 'Abril Fatface',
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
    "ConcertOne": 'Concert One',
    "Cormorant": 'Cormorant',
    "CrimsonText": 'Crimson Text',
    "Exo2": 'Exo 2',
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
    "PTSans": 'PT Sans',
    "PTSerif": 'PT Serif',
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

function setupicseditor(){

    var gicsgeOpts = {
        interface : ["swatches"],
        startingGradient : false,
        targetCssOutput : 'all',
        // targetElement : jQuery('.gradient'),
        defaultGradient : 'linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)',
        defaultCssSwatches : ['linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)'],
        // targetInputElement : jQuery('.gradient-result')
    }
    $('#ics-gradient-editor-1').icsge(gicsgeOpts);
    $('#ics-gradient-editor-2').icsge(gicsgeOpts);
    $('#ics-gradient-editor-3').icsge(gicsgeOpts);
    $('#ics-gradient-editor-4').icsge(gicsgeOpts);
    $('#ics-gradient-editor-5').icsge(gicsgeOpts);
    $('#ics-gradient-editor-6').icsge(gicsgeOpts);
    $('#ics-gradient-editor-7').icsge(gicsgeOpts);
}

//*
// ** Window Load
// *

$(window).on('load',function() {
    // lpUtilities.hexToRgb(hex);
    setupicseditor();
    //*
    // ** Load Font Object
    // *

    font_load();
});
$(document).ready(function () {
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

    var amIclosing = false;

    $('#questions-fonttype').select2({
        // minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-questions-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-questions-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-questions-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-questions-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-questions-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-questions-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-questions-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-questions-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#questions-fonttype').find(':selected').index();
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
            jQuery('.select2__parent-questions-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#questions-fonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-questions-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-questions-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#questions-fonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $(".question-preview").css('font-family', font_type);
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

    $('.select2-linehight-question').select2({
        width: '100%',
        data:line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-question-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $(".question-preview").css('line-height', $this_val);
    }).on('select2:openning', function() {
        jQuery('.select2-linehight-question-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2-linehight-question-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2-linehight-question-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-question-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-question-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2-linehight-question-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-question-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-question').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2-linehight-question-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-question-parent .select2-results__options').css('pointer-events', 'none');
    });


    $('.select2-linehight-answer').select2({
        width: '100%',
        data:line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-answer-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $(".description-preview").css('line-height', $this_val);
    }).on('select2:openning', function() {
        jQuery('.select2-linehight-answer-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2-linehight-answer-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2-linehight-answer-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-answer-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-answer-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2-linehight-answer-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-answer-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-answer').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2-linehight-answer-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-answer-parent .select2-results__options').css('pointer-events', 'none');
    });

    // $(".question-preview").css({
    //     'line-height':'normal'
    // });

    // $('.select2-linehight').on("select2:open", function() {
    //     $(this).val(-1).trigger('change');
    // });
    // $('.select2-linehight').on("select2:close", function() {
    //     $(this).val(-1).trigger('change');
    // });


    $('#dsc-fonttype').select2({
        // minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-dsc-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-dsc-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-dsc-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-dsc-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-dsc-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-dsc-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-dsc-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-dsc-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#dsc-fonttype').find(':selected').index();
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
            jQuery('.select2__parent-dsc-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#dsc-fonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-dsc-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-dsc-font-type .select2-results__options').css('pointer-events', 'none');
    }).on("select2:select", function () {
        var font_type = $(this).val();
        $(".description-preview").css('font-family', font_type);
    });

    $('#questions-fontsize').select2({
        minimumResultsForSearch: -1,
        width: '105px', // need to override the changed default
        dropdownParent: $('.select2__parent-questions-font-size')
    }).on("select2:select", function () {
        var fontsize = $(this).val();
        $(".question-preview").css('font-size', fontsize+"px");
    }).on('select2:openning', function() {
        jQuery('.select2__parent-questions-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-questions-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-questions-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-questions-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-questions-font-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-questions-font-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-questions-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#questions-fontsize').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 100);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-questions-font-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#questions-fontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-questions-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-questions-font-size .select2-results__options').css('pointer-events', 'none');
    });


    $('#dsc-fontsize').select2({
        minimumResultsForSearch: -1,
        width: '105px', // need to override the changed default
        dropdownParent: $('.select2__parent-dsc-font-size')
    }).on("select2:select", function () {
        var fontsize = $(this).val();
        $(".description-preview").css('font-size', fontsize+"px");
    }).on('select2:openning', function() {
        jQuery('.select2__parent-dsc-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-dsc-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-dsc-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-dsc-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-dsc-font-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-dsc-font-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-dsc-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#dsc-fontsize').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 100);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-dsc-font-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#dsc-fontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-dsc-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-dsc-font-size .select2-results__options').css('pointer-events', 'none');
    });

    $('#menutypefont').select2({
        // minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__menufont-type-parent'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__menufont-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__menufont-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__menufont-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__menufont-type-parent .select2-dropdown').hide();
        jQuery('.select2__menufont-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__menufont-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__menufont-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#menutypefont').find(':selected').index();
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
            jQuery('.select2__menufont-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#menutypefont').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__menufont-type-parent .select2-selection__rendered').show();
        jQuery('.select2__menufont-type-parent .select2-results__options').css('pointer-events', 'none');
    });



    $('.select2__menufont-type').on("select2:select", function () {
        var font_type = $(this).val();
        $(".description-preview").css('font-family', font_type);
    });

    $('#zipfontselect').select2({
        // minimumResultsForSearch: -1,
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__zipfont-type-parent'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__zipfont-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__zipfont-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__menufont-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__zipfont-type-parent .select2-dropdown').hide();
        jQuery('.select2__zipfont-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__zipfont-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__zipfont-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#zipfontselect').find(':selected').index();
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
            jQuery('.select2__zipfont-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#zipfontselect').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__zipfont-type-parent .select2-selection__rendered').show();
        jQuery('.select2__zipfont-type-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2__zipfont-type').on("select2:select", function () {
        var font_type = $(this).val();
        $("#zip-code,.zip-code__wrapper label").css('font-family', font_type);
    });

    $('#sliderfontsize').select2({
        // minimumResultsForSearch: -1,
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__sliderfont-type-parent'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__sliderfont-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__sliderfont-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__menufont-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__sliderfont-type-parent .select2-dropdown').hide();
        jQuery('.select2__sliderfont-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__sliderfont-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__sliderfont-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#sliderfontsize').find(':selected').index();
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
            jQuery('.select2__sliderfont-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#sliderfontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__sliderfont-type-parent .select2-selection__rendered').show();
        jQuery('.select2__sliderfont-type-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2__sliderfont-type').on("select2:select", function () {
        var font_type = $(this).val();
        $(".slider__title,.slider__label span").css('font-family', font_type);
    });

    $('#txtfieldfont').select2({
        // minimumResultsForSearch: -1,
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__txtfieldfont-type-parent'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__txtfieldfont-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__txtfieldfont-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__txtfieldfont-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__txtfieldfont-type-parent .select2-dropdown').hide();
        jQuery('.select2__txtfieldfont-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__txtfieldfont-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__txtfieldfont-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#txtfieldfont').find(':selected').index();
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
            jQuery('.select2__txtfieldfont-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#txtfieldfont').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__txtfieldfont-type-parent .select2-selection__rendered').show();
        jQuery('.select2__txtfieldfont-type-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2__txtfieldfont-type').on("select2:select", function () {
        var font_type = $(this).val();
        $("#fav-movie,.txt-field__wrapper label").css('font-family', font_type);
    });

    $('#dropdownfonttype').select2({
        // minimumResultsForSearch: -1,
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__dropdownfont-type-parent'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__dropdownfont-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__dropdownfont-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__dropdownfont-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__dropdownfont-type-parent .select2-dropdown').hide();
        jQuery('.select2__dropdownfont-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__dropdownfont-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__dropdownfont-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#dropdownfonttype').find(':selected').index();
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
            jQuery('.select2__dropdownfont-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#dropdownfonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__dropdownfont-type-parent .select2-selection__rendered').show();
        jQuery('.select2__dropdownfont-type-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2__dropdownfont-type').on("select2:select", function () {
        var font_type = $(this).val();
        $(".dropdown .select-box").css('font-family', font_type);
    });

    $('#contactinfofont').select2({
        // minimumResultsForSearch: -1,
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__contact-infofont-type-parent'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family");
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__contact-infofont-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__contact-infofont-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__contact-infofont-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__contact-infofont-type-parent .select2-dropdown').hide();
        jQuery('.select2__contact-infofont-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__contact-infofont-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__contact-infofont-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#contactinfofont').find(':selected').index();
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
            jQuery('.select2__contact-infofont-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#contactinfofont').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__contact-infofont-type-parent .select2-selection__rendered').show();
        jQuery('.select2__contact-infofont-type-parent .select2-results__options').css('pointer-events', 'none');
    });


    $('.select2__contact-infofont-type').on("select2:select", function () {
        var font_type = $(this).val();
        $(".contact-info label").css('font-family', font_type);
    });

    $('.select2__questions-colormode').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__questions-colormode-parent')
    }).on('change', function () {
        if($(this).val() == "hex"){
            var code_hex = $('#questions-modeowncolor-hex').val();
            $('#questions-colorval').val(code_hex);
        }else {
            var code_rgb = $('#questions-modeowncolor-rgb').val();
            $('#questions-colorval').val(code_rgb);
        }
    });

    $('.select2__dsc-colormode').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__dsc-colormode-parent')
    }).on('change', function () {
        if($(this).val() == "hex"){
            var code_hex = $('#dsc-modeowncolor-hex').val();
            $('#dsc-colorval').val(code_hex);
        }else {
            var code_rgb = $('#dsc-modeowncolor-rgb').val();
            $('#dsc-colorval').val(code_rgb);
        }
    });

    // $('.select2js__menu-primaryClrOption').select2({
    //     minimumResultsForSearch: -1,
    //     width: '100%', // need to override the changed default
    //     dropdownParent: $('.select2js__menu-primaryClrOption-parent')
    // }).on('change', function () {
    //     if($(this).val() == 0) {
    //         $('.menu__own-colorpull').hide();
    //         $('.menu__own-colorpicker').show();
    //     }else {
    //         $('.menu__own-colorpicker').hide();
    //         $('.menu__own-colorpull').show();
    //     }
    // });
    // $('.select2js__zip-primaryClrOption').select2({
    //     minimumResultsForSearch: -1,
    //     width: '100%', // need to override the changed default
    //     dropdownParent: $('.select2js__zip-primaryClrOption-parent')
    // }).on('change', function () {
    //     if($(this).val() == 0) {
    //         $('.zip__own-colorpull').hide();
    //         $('.zip__own-colorpicker').show();
    //     }else {
    //         $('.zip__own-colorpicker').hide();
    //         $('.zip__own-colorpull').show();
    //     }
    // });
    // $('.select2js__slider-primaryClrOption').select2({
    //     minimumResultsForSearch: -1,
    //     width: '100%', // need to override the changed default
    //     dropdownParent: $('.select2js__slider-primaryClrOption-parent')
    // }).on('change', function () {
    //     if($(this).val() == 0) {
    //         $('.slider__own-colorpull').hide();
    //         $('.slider__own-colorpicker').show();
    //     }else {
    //         $('.slider__own-colorpicker').hide();
    //         $('.slider__own-colorpull').show();
    //     }
    // });
    // $('.select2js__txtfield-primaryClrOption').select2({
    //     minimumResultsForSearch: -1,
    //     width: '100%', // need to override the changed default
    //     dropdownParent: $('.select2js__txtfield-primaryClrOption-parent')
    // }).on('change', function () {
    //     if($(this).val() == 0) {
    //         $('.txtfield__own-colorpull').hide();
    //         $('.txtfield__own-colorpicker').show();
    //     }else {
    //         $('.txtfield__own-colorpicker').hide();
    //         $('.txtfield__own-colorpull').show();
    //     }
    // });



    // $('.input__wrapper input').focus(function(){
    //     $(this).parents('.input__wrapper').addClass('focused');
    // });

    // $('.input__wrapper input').blur(function(){
    //     if($(this).val() == '') {
    //         $(this).parents('.input__wrapper').removeClass('focused');
    //     }else {
    //         $(this).parents('.input__wrapper').addClass('focused');
    //     }
    // });

    // $(".input__wrapper label").click(function (){
    //     $(this).parents('.input__wrapper').find('input').focus();
    //     $(this).parents('.input__wrapper').addClass('focused');
    // });

    $(".q-button-bold").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".question-preview").css({
                'font-weight':'400'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".question-preview").css({
                'font-weight':'700'
            });
        }
    });

    $(".q-button-italic").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".question-preview").css({
                'font-style':'normal'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".question-preview").css({
                'font-style':'italic'
            });
        }
    });

    $(".a-button-bold").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".description-preview").css({
                'font-weight':'400'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".description-preview").css({
                'font-weight':'700'
            });
        }
    });
    $(".a-button-italic").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".description-preview").css({
                'font-style':'normal'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".description-preview").css({
                'font-style':'italic'
            });
        }
    });

    // $(".q-button-linehight").click(function () {
    //     if($(this).hasClass("active")) {
    //         $(this).toggleClass("active");
    //         $(".question-preview").css({
    //             'line-height':'normal'
    //         });
    //     }
    //     else {
    //         $(this).toggleClass("active");
    //         $(".question-preview").css({
    //             'line-height':'42px'
    //         });
    //     }
    // });
    // $(".a-button-linehight").click(function () {
    //     if($(this).hasClass("active")) {
    //         $(this).toggleClass("active");
    //         $(".description-preview").css({
    //             'line-height':'normal'
    //         });
    //     }
    //     else {
    //         $(this).toggleClass("active");
    //         $(".description-preview").css({
    //             'line-height':'42px'
    //         });
    //     }
    // });



    var question_type = [
        {
            id:0,
            text:'<div class="question-type" data-index="address"><i class="ico ico-building"></i>Address</div>',
            title:'Address'
        },
        {
            id:1,
            text:'<div class="question-type" data-index="birthday"><i class="ico ico-birthday"></i>Birthday</div>',
            title:'Birthday'
        },
        {
            id:2,
            text:'<div class="question-type" data-index="contactInfo"><i class="ico ico-mail"></i>Contact Info</div>',
            title:'Contact Info'
        },
        {
            id:3,
            text:'<div class="question-type" data-index="ctaMessage"><i class="ico ico-message"></i>CTA Message</div>',
            title:'CTA'
        },
        {
            id:4,
            text:'<div class="question-type" data-index="datePicker"><i class="ico ico-calander"></i>Date Picker</div>',
            title:'Date Picker'
        },
        {
            id:5,
            text:'<div class="question-type" data-index="dropDown"><i class="ico ico-oc799PIto"></i>Drop Down</div>',
            title:'Drop Down'
        },
        {
            id:6,
            text:'<div class="question-type" data-index="menu"><i class="ico ico-hamburger"></i>Menu</div>',
            title:'Menu'
        },
        {
            id:7,
            text:'<div class="question-type" data-index="number"><i class="ico ico-hash"></i>Number</div>',
            title:'Number'
        },
        {
            id:8,
            text:'<div class="question-type" data-index="slider"><i class="ico ico-expand"></i>Slider</div>',
            title:'Slider'
        },
        {
            id:9,
            text:'<div class="question-type" data-index="textField"><i class="ico ico-select-text"></i>Text Field</div>',
            title:'Text Field'
        },
        {
            id:10,
            text:'<div class="question-type" data-index="timePicker"><i class="ico ico-time"></i>Time Picker</div>',
            title:'Time Picker'
        },
        {
            id:11,
            text:'<div class="question-type" data-index="zipCode"><i class="ico ico-location"></i>Zip Code</div>',
            title:'Zip Code'
        }
    ];
    function resetDesignOption() {

    }
    $('.select2js__slct-question').select2({
        width: '100%',
        data:question_type,
        minimumResultsForSearch: -1,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: $('.select2js__slct-question-parent')
    }).on('change', function () {
        var $this_index = $('.question-type').data('index');
        var $questiontype = obj[$this_index];
        jQuery('.anwser-preview-panel').hide();
        jQuery('#'+$this_index).slideDown(function () {
            $('#primary-clr').find('.last-selected__box').css('backgroundColor', $questiontype.primaryColor);
            $('#primary-clr').find('.last-selected__code').text($questiontype.primaryColor);
            $('#secondary-clr').find('.last-selected__box').css('backgroundColor', $questiontype.secondaryColor);
            $('#secondary-clr').find('.last-selected__code').text($questiontype.secondaryColor);
            $('#field-clr').find('.last-selected__box').css('backgroundColor', $questiontype.secondaryColor);
            $('#field-clr').find('.last-selected__code').text($questiontype.secondaryColor);
        });
        if($this_index == 'zipCode') {
            $('.bg-options__item__secondary-color').addClass('disabled');
            $('.bg-options__item__label-color').removeClass('disabled');
        }
        else if($this_index == 'menu') {
            $('.bg-options__item__secondary-color').removeClass('disabled');
            $('.bg-options__item__label-color').addClass('disabled');
        }
        else if($this_index == 'slider') {
            $('.bg-options__item__secondary-color, .bg-options__item__label-color').addClass('disabled');
        }
        else {
            $('.bg-options__item__secondary-color, .bg-options__item__label-color').removeClass('disabled');
        }
        console.log($this_index);
    }).on('select2:openning', function() {
        jQuery('.select2js__slct-question-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__slct-question-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__slct-question-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__slct-question-parent .select2-dropdown').hide();
        jQuery('.select2js__slct-question-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__slct-question-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2js__slct-question-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#slct-question').find(':selected').index();
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
            jQuery('.select2js__slct-question-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2js__slct-question').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__slct-question-parent .select2-selection__rendered').show();
        jQuery('.select2js__slct-question-parent .select2-results__options').css('pointer-events', 'none');
    });

    window.obj_color = {
        questiontype:'',
        menuColor: '',
        zipCodeColor: '',
        sliderColor: '',

        ButtonBackgroundColor: '#01acee',
        ButtonTextColor: '#ffffff',
        ButtonBorderColor: '#01acee',
        ButtonHoverBackgroundColor: '#01acee',
        ButtonHoverTextColor: '#223840',
        ButtonHoverBorderColor: '#01acee',
        ButtonOutsideOption : 1
    };


    var obj = {
            menu: {
                fontType: 'Open Sans',
                primaryColor: '#01c6f7',
                secondaryColor: '#ffffff',
                fieldLableColor: '#8f9da6'
            },
            zipCode: {
                fontType: 'Open Sans',
                primaryColor: '#01c6f7',
                secondaryColor: '#ffffff',
                fieldLableColor: '#8f9da6'
            },
            slider: {
                fontType: 'Open Sans',
                primaryColor: '#01c6f7',
                secondaryColor: '#ffffff',
                fieldLableColor: '#8f9da6'
            },
            textField: {
                fontType: 'Open Sans',
                primaryColor: '#01c6f7',
                secondaryColor: '#ffffff',
                fieldLableColor: '#8f9da6'
            },
            dropDown: {
                fontType: 'Open Sans',
                primaryColor: '#01c6f7',
                secondaryColor: '#ffffff',
                fieldLableColor: '#8f9da6'
            },
            contactInfo: {
                fontType: 'Open Sans',
                primaryColor: '#01c6f7',
                secondaryColor: '#ffffff',
                fieldLableColor: '#8f9da6'
            }
    };


    $('#qa__slider').bootstrapSlider();
    $('#question-fontsize').bootstrapSlider({
        formatter: function(value) {
            $('#question-fontsize-val').val(value);
            return   value +'px';
        },
        min: 8,
        max: 50,
        value: $('#question-fontsize-val').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    $('#description-fontsize').bootstrapSlider({
        formatter: function(value) {
            $('#description-fontsize-val').val(value);
            return   value +'px';
        },
        min: 8,
        max: 50,
        value: $('#description-fontsize-val').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#primary-clr').click(function () {
        var name = ".color-box__panel-wrapper_primary";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        $('#primary-color').ColorPickerSetColor(get_color);
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $('#secondary-clr').click(function () {
        var name = ".color-box__panel-wrapper_secondary";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        $('#secondary-color').ColorPickerSetColor(get_color);
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $('#field-clr').click(function () {
        var name = ".color-box__panel-wrapper_field";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        $('#field-color').ColorPickerSetColor(get_color);
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#primary-color').ColorPicker({
        color: "#01c6f7",
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
            $(".color-box__panel-wrapper_primary .color-box__r .color-box__rgb").val(rgb.r);
            $(".color-box__panel-wrapper_primary .color-box__g .color-box__rgb").val(rgb.g);
            $(".color-box__panel-wrapper_primary .color-box__b .color-box__rgb").val(rgb.b);
            $(".color-box__panel-wrapper_primary .color-box__hex-block").val('#'+hex);
            var $this_index = $('.question-type').data('index');
            var $questiontype = obj[$this_index];
            $questiontype.primaryColor = '#'+hex+'';
            $('#primary-clr').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#primary-clr').find('.last-selected__code').text('#'+hex);
            if($this_index == 'menu') {
                $('.button-answer').css('backgroundColor', rgba_fn);
            }
            else if($this_index == 'zipCode'){
                $('#zip-code').css('border-color', rgba_fn);
            }
            else if($this_index == 'slider') {
                $('.slider-handle,.slider-selection').css('backgroundColor', rgba_fn);
                $('.slider__title, .slider__label').css('color', rgba_fn);
            }
            else if($this_index == 'textField') {
                $('#fav-movie').css('border-color', rgba_fn);
            }
            else if($this_index == 'dropDown') {
                $('.dropdown .select-box,.select-box .dropdown__list').css('backgroundColor', rgba_fn);
            }
            else if($this_index == 'contactInfo') {
                $('.contact-info .input__wrapper.focused input').css('border-color', rgba_fn);
            }
        }
    });
    $('#secondary-color').ColorPicker({
        color: "#ffffff",
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
            $(".color-box__panel-wrapper_secondary .color-box__r .color-box__rgb").val(rgb.r);
            $(".color-box__panel-wrapper_secondary .color-box__g .color-box__rgb").val(rgb.g);
            $(".color-box__panel-wrapper_secondary .color-box__b .color-box__rgb").val(rgb.b);
            $(".color-box__panel-wrapper_secondary .color-box__hex-block").val('#'+hex);
            var $this_index = $('.question-type').data('index');
            var $questiontype = obj[$this_index];
            $questiontype.secondaryColor = '#'+hex+'';
            $('#secondary-clr').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#secondary-clr').find('.last-selected__code').text('#'+hex);
            if($this_index == 'menu') {
                $('.button-answer').css('color', rgba_fn);
            }
            else if($this_index == 'dropDown') {
                $('.dropdown .select-box, .dropdown .select-box i').css('color', rgba_fn);
            }
            else if($this_index == 'contactInfo') {
                $('.contact-info .input__wrapper.focused input').css('border-color', rgba_fn);
            }
        }
    });
    $('#field-color').ColorPicker({
        color: "#c8d1d5",
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
            $(".color-box__panel-wrapper_field .color-box__r .color-box__rgb").val(rgb.r);
            $(".color-box__panel-wrapper_field .color-box__g .color-box__rgb").val(rgb.g);
            $(".color-box__panel-wrapper_field .color-box__b .color-box__rgb").val(rgb.b);
            $(".color-box__panel-wrapper_field .color-box__hex-block").val('#'+hex);
            var $this_index = $('.question-type').data('index');
            var $questiontype = obj[$this_index];
            $questiontype.secondaryColor = '#'+hex+'';
            $('#field-clr').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#field-clr').find('.last-selected__code').text('#'+hex);
            if($this_index == 'zipCode'){
                $('.zip-code__wrapper label').css('color', rgba_fn);
            }
            else if($this_index == 'textField') {
                $('.txt-field__wrapper label').css('color', rgba_fn);
            }
            else if($this_index == 'contactInfo') {
                $('.contact-info label').css('color', rgba_fn);
            }
        }
    });



    //*
    // ** Own color tabs
    // *

    $('#questionsowncolor__box').ColorPicker({
        color: "#141c43",
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
            $(".question-txt-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".question-txt-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".question-txt-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".question-txt-clr .color-box__hex-block").val('#'+hex);
            $("#clr_question_txt .last-selected__code").text('#'+hex);
            $("#clr_question_txt .last-selected__box").css('backgroundColor', rgba_fn);
            $('.question-preview').css('color', rgba_fn);
        }
    });
    $('#dscowncolor__box').ColorPicker({
        color: "#94a2aa",
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
            $(".dsc-txt-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".dsc-txt-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".dsc-txt-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".dsc-txt-clr .color-box__hex-block").val('#'+hex);
            $("#clr_dsc_txt .last-selected__code").text('#'+hex);
            $("#clr_dsc_txt .last-selected__box").css('backgroundColor', rgba_fn);
            $('.description-preview').css('color', rgba_fn);
            // var $this_elm = $(this).parents('.owncolor__wrapper')
            // $('#dsc-modeowncolor-hex').val('#'+hex);
            // $('.description-preview').css('color','#'+hex);
            // $this_elm.find('.last-selected__box').css('backgroundColor','#'+hex);
            // $this_elm.find('.last-selected__code').html('#'+hex);
            // $('#dsc-modeowncolor-rgb').val('rgb('+rgb.r+','+rgb.g+','+rgb.b+')');
            // if($('.select2__dsc-colormode').val() == 'hex'){
            //     $('#dsc-colorval').val('#'+hex);
            // }else {
            //     $('#dsc-colorval').val('rgb('+rgb.r+','+rgb.g+','+rgb.b+')');
            // }
        }
    });

    // custom color picker

    // $('#menu-owncolor').ColorPicker({
    //     color: "#01acee",
    //     flat: true,
    //     opacity:true,
    //     width: 203,
    //     height: 144,
    //     outer_height: 162,
    //     outer_width: 281,
    //     onShow: function (colpkr) {
    //         $(colpkr).fadeIn(100);
    //         return false;
    //     },
    //     onHide: function (colpkr) {
    //         $(colpkr).fadeOut(100);
    //         return false;
    //     },
    //     onChange: function (hsb, hex, rgb, rgba) {
    //         var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
    //         $(".menu-primary-clr .color-box__r .color-box__rgb").val(rgb.r);
    //         $(".menu-primary-clr .color-box__g .color-box__rgb").val(rgb.g);
    //         $(".menu-primary-clr .color-box__b .color-box__rgb").val(rgb.b);
    //         $(".menu-primary-clr .color-box__hex-block").val('#'+hex);
    //         $("#menu-primary-clrpic .last-selected__code").text('#'+hex);
    //         $("#menu-primary-clrpic .last-selected__box").css('backgroundColor', rgba_fn);
    //     }
    // });

    // zipcode color picker

    // $('#zip-owncolor').ColorPicker({
    //     color: "#01acee",
    //     flat: true,
    //     opacity:true,
    //     width: 203,
    //     height: 144,
    //     outer_height: 162,
    //     outer_width: 281,
    //     onShow: function (colpkr) {
    //         $(colpkr).fadeIn(100);
    //         return false;
    //     },
    //     onHide: function (colpkr) {
    //         $(colpkr).fadeOut(100);
    //         return false;
    //     },
    //     onChange: function (hsb, hex, rgb) {
    //         $(".zip-primary-clr .color-box__r .color-box__rgb").val(rgb.r);
    //         $(".zip-primary-clr .color-box__g .color-box__rgb").val(rgb.g);
    //         $(".zip-primary-clr .color-box__b .color-box__rgb").val(rgb.b);
    //         $(".zip-primary-clr .color-box__hex-block").val('#'+hex);
    //         $("#zip-primary-clrpic .last-selected__code").text('#'+hex);
    //         $("#zip-primary-clrpic .last-selected__box").css('backgroundColor', '#' + hex);
    //     }
    // });

    // slider color picker

    // $('#slider-owncolor').ColorPicker({
    //     color: "#01acee",
    //     flat: true,
    //     opacity:true,
    //     width: 203,
    //     height: 144,
    //     outer_height: 162,
    //     outer_width: 281,
    //     onShow: function (colpkr) {
    //         $(colpkr).fadeIn(100);
    //         return false;
    //     },
    //     onHide: function (colpkr) {
    //         $(colpkr).fadeOut(100);
    //         return false;
    //     },
    //     onChange: function (hsb, hex, rgb) {
    //         $(".slider-primary-clr .color-box__r .color-box__rgb").val(rgb.r);
    //         $(".slider-primary-clr .color-box__g .color-box__rgb").val(rgb.g);
    //         $(".slider-primary-clr .color-box__b .color-box__rgb").val(rgb.b);
    //         $(".slider-primary-clr .color-box__hex-block").val('#'+hex);
    //         $("#slider-primary-clrpic .last-selected__code").text('#'+hex);
    //         $("#slider-primary-clrpic .last-selected__box").css('backgroundColor', '#' + hex);
    //     }
    // });

    // text field color picker

    $('#txtfield-owncolor').ColorPicker({
        color: "#01acee",
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
            $(".txtfield-primary-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".txtfield-primary-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".txtfield-primary-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".txtfield-primary-clr .color-box__hex-block").val('#'+hex);
            $("#txtfield-primary-clrpic .last-selected__code").text('#'+hex);
            $("#txtfield-primary-clrpic .last-selected__box").css('backgroundColor', rgba_fn);
        }
    });



    $("#clr_question_txt").click(function () {
        var name = ".question-txt-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $("#clr_dsc_txt").click(function () {
        var name = ".dsc-txt-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });



    // $("#menu-primary-clrpic").click(function () {
    //     var name = ".menu-primary-clr";
    //     var color_box_name = $(name);
    //     var get_color = $(this).find('.last-selected__code').text();
    //     lpUtilities.custom_color_picker.call(this,name);
    //     lpUtilities.set_colorpicker_box(color_box_name,get_color);
    // });
    // $("#zip-primary-clrpic").click(function () {
    //     var name = ".zip-primary-clr";
    //     var color_box_name = $(name);
    //     var get_color = $(this).find('.last-selected__code').text();
    //     lpUtilities.custom_color_picker.call(this,name);
    //     lpUtilities.set_colorpicker_box(color_box_name,get_color);
    // });
    // $("#slider-primary-clrpic").click(function () {
    //     var name = ".slider-primary-clr";
    //     var color_box_name = $(name);
    //     var get_color = $(this).find('.last-selected__code').text();
    //     lpUtilities.custom_color_picker.call(this,name);
    //     lpUtilities.set_colorpicker_box(color_box_name,get_color);
    // });
    // $("#txtfield-primary-clrpic").click(function () {
    //     var name = ".txtfield-primary-clr";
    //     var color_box_name = $(name);
    //     var get_color = $(this).find('.last-selected__code').text();
    //     lpUtilities.custom_color_picker.call(this,name);
    //     lpUtilities.set_colorpicker_box(color_box_name,get_color);
    // });


    $(document).click(function(e) {

        $(".color-box__panel-wrapper").hide();
        if ($(e.target).is(".tbAnswers")) {
            $('#preview-panel').slideUp();
        }else if($(e.target).is(".tbQuestions")){
            $('#preview-panel .tab__title').text("Questions");
        }else if($(e.target).is(".tbDescriptions")){
            $('#preview-panel .tab__title').text("Descriptions");
        }
        if($(e.target).is(".tbQuestions,.tbDescriptions")) {
            $('#preview-panel').slideDown();
        }
    });
    $(".color-box__panel-wrapper").click(function (e) {
        e.stopPropagation();
    });

    /*$('.select-box').click(function () {
        var $this = $(this);
        $this.find('.dropdown__list').slideToggle(function () {
            $this.toggleClass('open');
       });
    });*/

    jQuery('.select-box').click(function () {
        if(jQuery(this).hasClass('open')) {
            jQuery(this).find('.dropdown__list').attr('style', '');
            jQuery(this).removeClass('open');
        } else {
            jQuery(this).addClass('open');
            jQuery(this).find('.dropdown__list').css({'display': 'block', 'opacity': '1', 'transform': 'scaleX(1) scaleY(1)'});
        }
    });

    $('.select-box .dropdown__item').click(function (e) {
        e.stopPropagation();
        $('.select-box .dropdown__item').removeClass('selected');
        var $txt = $(this).text();
        $(this).addClass('selected');
        $('.select-box').addClass('has-txt');
        $('.select-box').find('.selected-text').remove();
        $('.select-box').append('<span class="selected-text">'+ $txt +'</span>');
        $('.select-box').find('.dropdown__list').css({'display': 'block', 'opacity': '1', 'transform': 'scaleX(1) scaleY(1)'});
    });

    //    Reset question options

    $('.question-button-reset').click(function () {
        $('#questions-fonttype').val('Open Sans').trigger('change');
        $(".question-preview").css({
            'font-family':'Open Sans',
            'font-size':'34px',
            'line-height': '36px',
            'font-weight': '600',
            'font-style': 'normal',
            'color': '#394651'
        });
        $('#clr_question_txt .last-selected__code').html('#141c43');
        $('#clr_question_txt .last-selected__box').css('background-color','#141c43');
        $('#questions-fontsize').val(22).trigger('change');
        $('.q-button-bold').removeClass('active');
        $('.q-button-italic').removeClass('active');
    });

    $('.description-button-reset').click(function () {
        $('#dsc-fonttype').val('Open Sans').trigger('change');
        $(".description-preview").css({
            'font-family':'Open Sans',
            'font-size':'16px',
            'line-height': '20px',
            'font-weight': '400',
            'font-style': 'normal',
            'color': '#85969f'
        });
        $('#clr_dsc_txt .last-selected__code').html('#85969f');
        $('#clr_dsc_txt .last-selected__box').css('background-color','#85969f');
        $('#dsc-fontsize').val(22).trigger('change');
        $('.a-button-bold, .a-button-italic').removeClass('active');
    });

    $('.bp-button-reset').click(function () {
        $('#menutypefont').val('Open Sans').trigger('change');
        $(".question-preview").css({
            'font-family':'Open Sans',
            'font-size':'30px',
            'line-height': '32px',
            'font-weight': '700',
            'font-style': 'normal',
            'color': '#141c43'
        });
        $('#primary-clr .last-selected__code').html('#01c6f7');
        $('#secondary-clr .last-selected__code').html('#ffffff');
        $('#field-clr .last-selected__code').html('#c8d1d5');
        //revert style for menu
        $(".menu__item .button-answer").removeAttr("style");

        var a = $('#slct-question :selected').filter(":selected").val();

        if(a == 1) {
            //revert style for zip code
            $("#zip-code").removeAttr("style");
            $("#label-zip-code").removeAttr("style");
        }
        if(a == 2) {
            //revert style for zip code
            $(".slider__title").removeAttr("style");
            $("#qa__slider").css("background-color", "");
            $(".slider__label").css("color", "");
            $(".round").css("background-color", "");
            $(".slider-track .slider-selection").css("background-color", "");
        }
        if(a == 3) {
            //revert style for text field
            $("#label-fav-movie").removeAttr("style");
            $("#fav-movie").removeAttr("style");
        }
        if(a == 4) {
            //revert style for dropdown
            $(".select-box").removeAttr("style");
            $(".select-box .icon").removeAttr("style");
            $(".dropdown__list").removeAttr("style");
        }
        if(a == 5) {
            //revert style for contact info
            $("#label-f-name").removeAttr("style");
            $("#f-name").removeAttr("style");
            $("#label-l-name").removeAttr("style");
            $("#l-name").removeAttr("style");
            $("#label-e-address").removeAttr("style");
            $("#e-address").removeAttr("style");
            $("#label-p-num").removeAttr("style");
            $("#p-nume").removeAttr("style");
        }
    });


});
