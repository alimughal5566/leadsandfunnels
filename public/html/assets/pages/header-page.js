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
    $('#phone-number').inputmask({"mask": "(999) 999-9999"});
    $('#cta-phone-number').inputmask({"mask": "(999) 999-9999"});
});

var WIDTH = '';
var MAX_WIDTH = 540;
var PAD = 15;
var HEIGHT = '';
$(document).click(function(e) {
    var container = $(".pull-clr__wrapper,.color-box__panel-wrapper");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.hide();
        $('.last-selected').removeClass('open');
    }
});
$(document).ready(function () {

    //*
    // ** tooltip
    // *

    $('.question-mark_tooltip').tooltipster({
        interactive: true,
        multiple: true,
        contentAsHTML:true
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
    $options = $options.add($('<option>').attr('value', '').html('Open sans'));
    $.each(font_object , function (index , value) {
        $class = value;
        $class = $class.replace(" ", "_");
        $options = $options.add(
            $('<option>').attr('value', index).html(value).css('font-family', value)
        );
    });
    $('select.font-type').html($options).trigger('change');

    var amIclosing = false;

    $('#companyfonttype').select2({
        // minimumResultsForSearch: -1,
        //placeholder: 'Open sans',
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__parent-company-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-company-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-company-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-company-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-company-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-company-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-company-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-company-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#companyfonttype').find(':selected').index();
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
            jQuery('.select2__parent-company-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#companyfonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-company-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-company-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#ctafonttype').select2({
        // minimumResultsForSearch: -1,
        //placeholder: 'Open sans',
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__parent-cta-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-cta-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-cta-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-cta-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-cta-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-cta-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-cta-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-cta-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#ctafonttype').find(':selected').index();
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
            jQuery('.select2__parent-cta-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#ctafonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-cta-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-cta-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#phonefonttype').select2({
        // minimumResultsForSearch: -1,
        //placeholder: 'Open sans',
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__parent-phone-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-phone-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-phone-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-phone-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-phone-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-phone-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-phone-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-phone-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#phonefonttype').find(':selected').index();
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
            jQuery('.select2__parent-phone-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#phonefonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-phone-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-phone-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#emailfonttype').select2({
        // minimumResultsForSearch: -1,
        //placeholder: 'Open sans',
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__parent-email-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-email-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-email-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-email-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-email-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-email-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-email-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-email-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#emailfonttype').find(':selected').index();
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
            jQuery('.select2__parent-email-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#emailfonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-email-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-email-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#mobilefonttype').select2({
        // minimumResultsForSearch: -1,
        //placeholder: 'Open sans',
        width: '235px', // need to override the changed default
        dropdownParent: $('.select2__parent-mobile-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
    }).on('select2:openning', function() {
        jQuery('.select2__parent-mobile-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-mobile-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-mobile-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-mobile-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-mobile-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-mobile-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-mobile-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#mobilefonttype').find(':selected').index();
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
            jQuery('.select2__parent-mobile-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#mobilefonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-mobile-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-mobile-font-type .select2-results__options').css('pointer-events', 'none');
    });


    //*
    // ** Select2 Js Select Event
    // *

    $('#companyfonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $(".info__name").css('font-family', font_type);
    });
    $('#ctafonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $(".info__cta").css('font-family', font_type);
    });
    $('#phonefonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $(".info__cellnumber").css('font-family', font_type);
    });
    $('#emailfonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $(".info__email").css('font-family', font_type);
    });
    $('#mobilefonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $("#mobile .cta-button").css('font-family', font_type);
    });

    //*
    // ** Font sizes select2js
    // *

    $('#companyfontsize').select2({
        minimumResultsForSearch: -1,
        width: '105px', // need to override the changed default
        dropdownParent: $('.select2__parent-company-font-size')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-company-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-company-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-company-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-company-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-company-font-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-company-font-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-company-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#companyfontsize').find(':selected').index();
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
            jQuery('.select2__parent-company-font-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#companyfontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-company-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-company-font-size .select2-results__options').css('pointer-events', 'none');
    });



    $('#ctafontsize').select2({
        minimumResultsForSearch: -1,
        width: '105px', // need to override the changed default
        dropdownParent: $('.select2__parent-cta-font-size')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-cta-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-cta-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-cta-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-cta-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-cta-font-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-cta-font-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-cta-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#ctafontsize').find(':selected').index();
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
            jQuery('.select2__parent-cta-font-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#ctafontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-cta-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-cta-font-size .select2-results__options').css('pointer-events', 'none');
    });

    $('#phonefontsize').select2({
        minimumResultsForSearch: -1,
        width: '105px', // need to override the changed default
        dropdownParent: $('.select2__parent-phonenumber-font-size')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-phonenumber-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-phonenumber-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-phonenumber-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-phonenumber-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-phonenumber-font-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-phonenumber-font-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-phonenumber-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#phonefontsize').find(':selected').index();
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
            jQuery('.select2__parent-phonenumber-font-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#phonefontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-phonenumber-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-phonenumber-font-size .select2-results__options').css('pointer-events', 'none');
    });

    $('#emailfontsize').select2({
        minimumResultsForSearch: -1,
        width: '105px', // need to override the changed default
        dropdownParent: $('.select2__parent-email-font-size')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-email-font-size .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-email-font-size .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-email-font-size .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-email-font-size .select2-dropdown').hide();
        jQuery('.select2__parent-email-font-size .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-email-font-size .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-email-font-size .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#emailfontsize').find(':selected').index();
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
            jQuery('.select2__parent-email-font-size .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#emailfontsize').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-email-font-size .select2-selection__rendered').show();
        jQuery('.select2__parent-email-font-size .select2-results__options').css('pointer-events', 'none');
    });
    //*
    // ** Font sizes select2js live preview
    // *

    $('#companyfontsize').on("select2:select", function () {
        var fontsize__msg = $(this).val();
        $(".info__name").css('font-size', fontsize__msg+"px");
    });
    $('#ctafontsize').on("select2:select", function () {
        var fontsize__msg = $(this).val();
        $(".info__cta,#mobile .cta-button").css('font-size', fontsize__msg+"px");
    });
    $('#phonefontsize').on("select2:select", function () {
        var fontsize__msg = $(this).val();
        $(".info__cellnumber").css('font-size', fontsize__msg+"px");
    });
    $('#emailfontsize').on("select2:select", function () {
        var fontsize__msg = $(this).val();
        $(".info__email").css('font-size', fontsize__msg+"px");
    });

    //*
    // ** Nice Scroll
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

    $(".lp-image__input").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg']) == -1) {
                $('.file__extension').slideDown("slow");
                $('.file__size').slideUp("slow");
                $(".file-name").text("");
                $(".file-name").hide();
            }
            else if (file.size > 4000000) {
                $('.file__size').slideDown("slow");
                $('.file__extension').slideUp("slow");
                $(".file-name").text("");
                $(".file-name").hide();
            }
            else {
                $('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function() {
                        $('.file__imgsize').slideUp("slow");
                        $(".file-name").text("");
                        $(".file-name").text(file.name);
                        $(".file-name").show();
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    $(".img-content-logo").draggable({
        helper: "clone",
        appendTo: 'body'
    });
    $(".drop-hplogo").droppable({
        accept: ".img-content-logo",
        drop: function(ev, ui) {
            obj_clr_check.remove_header_logo = 1;
            $(".del-logo").text("delete");
            $('.upload-logo').removeClass("active");
            $(".del-logo").addClass("selected");
            var el = ui.draggable;
            $(el).parents(".upload-logo").find(".del-logo").text("remove from header");
            $('.hp-message').slideUp();
            $(el).parents(".upload-logo").find(".del-logo").addClass("selected");
            $(el).closest(".upload-logo").addClass("active");
            // console.info(el);
            var path = ui.draggable.find('img').attr('src');
            var dimage = path.indexOf("/clients/");
            $('.drop-hplogo .hp__logo img').remove('');
            if(dimage == -1 ) {
                $('.drop-hplogo .hp__logo').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
            }else {
                $('.drop-hplogo .hp__logo').append('<img src="'+path+'" id="currentdropimagelogo" class="abc" >');
            }

            $('.hp-step1').slideUp();
            $('.hp-step2').slideDown();
        }
    });

    $('.upload-logo .img-content-logo').keypress(function () {
        $(this).addClass("active");
    });

    $(".del-logo").click(function () {
        if($(this).parents(".upload-logo").hasClass("active")) {
            $(".del-logo").text("delete");
            $('.hp-message').slideDown();
            $('.upload-logo').removeClass("active");
            $(".drop-hplogo .hp__logo img").attr('src','');
            obj_clr_check.remove_header_logo = 0;
            removeEmptyHeader();
        }
        else {
            $(this).parents(".col.col-md-6").remove();
            var count = $(".upload-logo").length;
            if(count == 0){
                $(".nologo-step").show();
            }

        }
    });


    //*
    // ** color object checker
    // *

    window.obj_clr_check = {
        clr_company_txt:0,
        clr_cta_txt:0,
        clr_phone_txt:0,
        clr_email_txt:0,
        clr_global_txt:1,
        remove_header_logo:0,
        mobile_tab:false,
    };

    function removeEmptyHeader() {
        $check_empty_header = true;
        $.each( obj_clr_check, function( key, value ) {
            if(value == 1 && key != 'clr_global_txt'){
                $check_empty_header = false;
            };
        });
       /* if($check_empty_header){
            $('.hp-step2').slideUp('fast',function(){
                $('.hp-step1').slideDown();
            });
        }else{
            $('.hp-step1').slideUp('fast',function(){
                $('.hp-step2').slideDown();
            });
        }*/
    }
    function checkbases() {
        obj_clr_check.clr_global_txt = 1;
        $.each( obj_clr_check, function( key, value ) {
            if(value == 0)obj_clr_check.clr_global_txt = 0;
            if(value != 1) {
                $('#'+ key).parents('.col-clr').addClass('disabled');
                // $('.hp-step2').slideDown();
            }else {
                $('#'+ key).parents('.col-clr').removeClass('disabled');
                // $('.hp-step2').slideUp();
            }
        });
        if(obj_clr_check.clr_global_txt == 1){
            $('#clr_global_txt').parents('.col-clr').removeClass('disabled')
        }else{
            $('#clr_global_txt').parents('.col-clr').addClass('disabled')
        }
    }

    $('#tbcolors').click(function () {
        checkbases();
    });

    $('#tblogo').click(function () {
        if($('.hp-step2').is(":visible")) {
            $('.hp-message').hide();
        }

        else {
            $('.hp-message').show();
        }

        if($('.hp__logo img').attr('src') != ''){
            $('.logo-size-item').show();
        }
    });
    $('#tbcontactinfo').click(function () {
        $('.hp-message').hide();
        $('.logo-size-item').hide();
    });

    $('#tbcomputer').click(function () {
        obj_clr_check.mobile_tab = false;
        val_checker();
    });
    $('#tbmobile').click(function () {
        obj_clr_check.mobile_tab = true;
        $('.hp-area__head').removeClass('justify-content-center text-center');
    });


    $('#comanyname_as_logo').change(function () {
        if ($(this).is(':checked')) {
            $('.hp__logo img, .hp__cta .info__name').hide();
            $('.hp__logo .alt-logo').show();
        }else{
            $('.hp__logo .alt-logo').hide();
            $('.hp__logo img, .hp__cta .info__name').show();
        }
    });



    //*
    // ** Active / Inactive options
    // *


    $( "body" ).on( "change", ".info-check-field" , function(e) {
        if ($(this).is(':checked')) {
            $(this).parents(".lp-panel_cta-info").find(".panel-hp__setting").removeClass('hide');

        } else {
            $(this).parents(".lp-panel_cta-info").find(".panel-hp__setting").addClass('hide');
        }
        var check_length = $(this).parents(".lp-panel_cta-info-wrap").find(".info-check-field:checked").length;
        var getSrc = jQuery('.hp__logo img').attr('src');
        if(check_length >= 1 || getSrc !== "") {
            $('.hp-step1').slideUp();
            $('.hp-step2').slideDown();
        }
        else {
            $('.hp-step2').slideUp();
            $('.hp-step1').slideDown();
        }
    });

    $( "body" ).on( "change", "#mobile" , function(e) {
        if ($(this).is(':checked')) {
            $('a[href*="#mobile"]').trigger('click');
        }
        else {
            $('a[href*="#computer"]').trigger('click');
        }
    });


    //*
    // ** Contact info inputs keyup event
    // *

    $("#company-name").keyup(function () {
       var this_val = $(this).val();
       $(".info__name").text(this_val);
        val_checker();
    });
    $("#cta-phone-number").keyup(function () {
        var this_val = $(this).val();
        $(".info__cta").text(this_val);
        val_checker();
    });
    $("#phone-number").keyup(function () {
        var this_val = $(this).val();
        $("#mobile .cta-button").attr('href','tel:'+this_val+'');
        $(".info__cellnumber").text(this_val);
        val_checker();
    });
    $("#company-email").keyup(function () {
        var this_val = $(this).val();
        $(".info__email").text(this_val);
        val_checker();
    });
    $("#mobile-text").keyup(function () {
        var $num = $("#phone-number").val();
        $(this).attr('href','tel:'+$num+'');
        var this_val = $(this).val();
        $(".cta-button span").text(this_val);
        val_checker();
    });



    $( "body" ).on( "change","#logocenter" , function(e){
        val_checker();
    });

    //*
    // ** Center logo header function
    // *

    function val_checker(){
        var $name =  $('#company-name').val();
        var $cta_number = $('#cta-phone-number').val();
        var $cta_phone = $('#phone-number').val();
        var $email = $('#company-email').val();
        // var $cta_phone_button = $('#mobile-text').val();
        if ($('#logocenter').is(':checked')) {
            if (obj_clr_check.mobile_tab == true){
                $('.hp-area__head').removeClass('justify-content-center text-center')
            }else {
                if ($name == '' && ($cta_number == '' || $cta_number == undefined) && $cta_phone == '' && $email == '') {
                    $('.hp-area__head').addClass('justify-content-center text-center');
                }else {
                    $('.hp-area__head').removeClass('justify-content-center text-center')
                }
            }
        }else {
            $('.hp-area__head').removeClass('justify-content-center text-center')
        }
    }

    //*
    // ** Contact info bold/italic
    // *

    $(".txt-company-bold").click(function () {
       if($(this).hasClass("active")) {
           $(this).toggleClass("active");
           $(".info__name").css({
               'font-weight':'400'
           });
       }
       else {
           $(this).toggleClass("active");
           $(".info__name").css({
               'font-weight':'700'
           });
       }
    });
    $(".txt-company-italic").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".info__name").css({
                'font-style':'normal'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".info__name").css({
                'font-style':'italic'
            });
        }
    });

    $(".txt-cta-bold").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".info__cta").css({
                'font-weight':'400'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".info__cta").css({
                'font-weight':'700'
            });
        }
    });
    $(".txt-cta-italic").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".info__cta").css({
                'font-style':'normal'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".info__cta").css({
                'font-style':'italic'
            });
        }
    });

    $(".txt-phone-bold").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".info__cellnumber").css({
                'font-weight':'400'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".info__cellnumber").css({
                'font-weight':'700'
            });
        }
    });
    $(".txt-phone-italic").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".info__cellnumber").css({
                'font-style':'normal'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".info__cellnumber").css({
                'font-style':'italic'
            });
        }
    });

    $(".txt-email-bold").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".info__email").css({
                'font-weight':'400'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".info__email").css({
                'font-weight':'700'
            });
        }
    });
    $(".txt-email-italic").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $(".info__email").css({
                'font-style':'normal'
            });
        }
        else {
            $(this).toggleClass("active");
            $(".info__email").css({
                'font-style':'italic'
            });
        }
    });

    $(".txt-mobile-bold").click(function () {
        if($(this).hasClass("active")) {
            $(this).toggleClass("active");
            $("#callnow span").css({
                'font-weight':'400'
            });
        }
        else {
            $(this).toggleClass("active");
            $("#callnow span").css({
                'font-weight':'700'
            });
        }
    });

    //*
    // ** color picker all tabs
    // *

    var hp_backgroundColor = $('#clr_bg_header');
    var txtCompanyColor =  $('#clr_company_txt');
    var txtCtaColor =  $('#clr_cta_txt');
    var txtPhoneColor =  $('#clr_phone_txt');
    var txtEmailColor =  $('#clr_email_txt');
    var txtGlobalColor =  $('#clr_global_txt');
    var txtBgButtonColor =  $('#clr-bgbutton-txt');
    var txtClrButtonColor =  $('#clr-clrbutton-txt');

    $(hp_backgroundColor).click(function () {
        var name = ".main-bgheader-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $(txtCompanyColor).click(function () {
        var name = ".company-name-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $(txtCtaColor).click(function () {
        var name = ".cta-number-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $(txtPhoneColor).click(function () {
        var name = ".phone-number-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $(txtEmailColor).click(function () {
        var name = ".email-address-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $(txtClrButtonColor).click(function () {
        var name = ".mobile-call-txt-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });
    $(txtBgButtonColor).click(function () {
        var name = ".mobile-call-bg-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });



    $('#main-bgheader-colorpicker').ColorPicker({
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
            $(".main-bgheader-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".main-bgheader-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".main-bgheader-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".main-bgheader-clr .color-box__hex-block").val('#'+hex);
            $(hp_backgroundColor).find('.color-picker').css('backgroundColor', rgba_fn);
            $(hp_backgroundColor).find('.last-selected__code').text('#'+hex);
            $('.hp-area__head-bg').css('backgroundColor', rgba_fn);
        }
    });

    $('#company-name-colorpicker').ColorPicker({
        color: "#cfdadd",
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
            $(".main-bgheader-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".main-bgheader-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".main-bgheader-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".main-bgheader-clr .color-box__hex-block").val('#'+hex);
            $(txtCompanyColor).find('.last-selected__box').css('backgroundColor', rgba_fn);
            $(txtCompanyColor).find('.last-selected__code').text('#'+hex);
            $('.info__name').css('color', rgba_fn);
        }
    });

    $('#cta-number-colorpicker').ColorPicker({
        color: "#00afef",
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
            $(".cta-number-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta-number-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta-number-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta-number-clr .color-box__hex-block").val('#'+hex);
            $(txtCtaColor).find('.last-selected__box').css('backgroundColor', rgba_fn);
            $(txtCtaColor).find('.last-selected__code').text('#'+hex);
            $('.info__cta').css('color', rgba_fn);
        }
    });

    $('#phone-number-colorpicker').ColorPicker({
        color: "#61717c",
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
            $(".phone-number-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".phone-number-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".phone-number-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".phone-number-clr .color-box__hex-block").val('#'+hex);
            $(txtPhoneColor).find('.last-selected__box').css('backgroundColor', rgba_fn);
            $(txtPhoneColor).find('.last-selected__code').text('#'+hex);
            $('.info__cellnumber').css('color', rgba_fn);
        }
    });

    $('#email-address-colorpicker').ColorPicker({
        color: "#00afef",
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
            $(".email-address-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".email-address-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".email-address-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".email-address-clr .color-box__hex-block").val('#'+hex);
            $(txtEmailColor).find('.last-selected__box').css('backgroundColor', rgba_fn);
            $(txtEmailColor).find('.last-selected__code').text('#'+hex);
            $('.info__email').css('color', rgba_fn);
        }
    });

    $('#mobile-calltxt-colorpicker').ColorPicker({
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
        onChange: function (hsb, hex, rgb,rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".mobile-calltxt-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".mobile-calltxt-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".mobile-calltxt-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".mobile-calltxt-clr .color-box__hex-block").val('#'+hex);
            $(txtClrButtonColor).find('.color-picker').css('backgroundColor', rgba_fn);
            $(txtClrButtonColor).find('.last-selected__code').text('#'+hex);
            $('#mobile .cta-button, #mobile .cta-button span').css('color', rgba_fn);
        }
    });

    $('#mobile-callbg-colorpicker').ColorPicker({
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
            $(".mobile-calltxt-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".mobile-calltxt-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".mobile-calltxt-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".mobile-calltxt-clr .color-box__hex-block").val('#'+hex);
            $(txtBgButtonColor).find('.color-picker').css('backgroundColor', rgba_fn);
            $(txtBgButtonColor).find('.last-selected__code').text('#'+hex);
            $('#mobile .cta-button').css('backgroundColor', rgba_fn);
        }
    });

    //*
    // ** hex to rgb / rgb to hex = select2js
    // *

    $('.select2__hpPage-colormode').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__hpPage-colormode-parent')
    }).on('change', function () {
        if($(this).val() == "hex"){
            var code_hex = $('#hp-modeowncolor-hex').val();
            $('#hpPage-colorval').val(code_hex);
        }else {
            var code_rgb = $('#hp-modeowncolor-rgb').val();
            $('#hpPage-colorval').val(code_rgb);
        }
    });

    //    logo combinator
    $(".upload-drag__file").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function () {
        readCombURL(this);
    });

    function readCombURL(input) {
        var this_input = input;
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg']) == -1) {
                $(this_input).parents(".comb__col").find('.file__extension').slideDown("slow");
                $(this_input).parents(".comb__col").find('.file__size').slideUp("slow");
            }
            else if (file.size > 4000000) {
                $(this_input).parents(".comb__col").find('.file__size').slideDown("slow");
                $(this_input).parents(".comb__col").find('.file__extension').slideUp("slow");

            }
            else {
                $(this_input).parents(".comb__col").find('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function() {
                        $(this_input).parents(".comb__col").find('.file__imgsize').slideUp("slow");
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step1," +
                            " .upload-drag__step2").hide();
                        $(this_input).parents(".upload-drag__wrapper").find(".hp-progress-area").show();
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2 img").attr('src', e.target.result );
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2 img").attr('alt', file.name );
                        var i = 1;
                        var elem = $(this_input).parents(".upload-drag__wrapper").find('.progress');
                        var elemVal = $(this_input).parents(".upload-drag__wrapper").find('.progress-val');
                        $(this_input).parents(".upload-drag__wrapper").find('.file-name').html(file.name);
                        var width = 1;
                        var id = setInterval(frame, 10);
                        function frame() {
                            if (width >= 100) {
                                clearInterval(id);
                                i = 0;
                            } else {
                                width++;
                                elem.css('width', width + "%");
                                elemVal.html(width + "%");
                            }
                        }
                        setTimeout(function(){
                            $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2").show();
                            $(this_input).parents(".upload-drag__wrapper").find(".hp-progress-area").hide();
                        },1200);

                        jQuery('#combinator .upload-drag__step2').each(function(){
                            var activeLength = 0;
                            if(jQuery(this).is(":visible")) {
                                activeLength++;
                            }
                            if(activeLength >= 1 ) {
                                jQuery('#combinelogo').attr('disabled', false);
                            }
                        });
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    $slider1 = $('#combex1').bootstrapSlider({
        formatter: function(value) {
            _width = value;
            if ($('.pre-image').attr('src').indexOf("upload-image.png") < 0 && $('.pre-image').attr('src') != '' && $('.post-image').attr('src') != '') {
                $('.pre-image').css('width',_width+'px');
            }
            var $_imagestyle = Math.round($('.pre-image').width()) + "~" + Math.round($('.pre-image').height());
            var pre_width = Math.round($('.pre-image').width());
            var post_width = MAX_WIDTH - pre_width;
            if (value > 50) {
                $('.post-image').width(post_width);
                var $_postimagestyle = $('.post-image').css("width") + "~" + $('.post-image').css("height");
                $("#post-image-style").val($_postimagestyle);
                // $("#ex2").slider('setValue', post_width, true);
                // $("#ex2").slider('refresh');
            }
            $("#pre-image-style").val($_imagestyle);
            return value +'px';
        },
        min: 40,
        step: 10,
        max: 200,
        value: Math.round($('.pre-image').width()),
         //value: 100,
        tooltip_position:'bottom'
    });

    $slider2 = $('#combex2').bootstrapSlider({
        formatter: function(value) {
            _width = value;
            if ($('.post-image').attr('src').indexOf("upload-image.png") < 0 && $('.post-image').attr('src') != '' && $('.post-image').attr('src') != '') {
                $('.post-image').css('width',_width+'px');
            }


            var $_imagestyle = Math.round($('.post-image').width()) + "~" + Math.round($('.post-image').height());
            var post_width = Math.round($('.post-image').width());
            var pre_width = MAX_WIDTH - post_width;
            if (value > 50) {
                $('.pre-image').width(pre_width);


                var $_preimagestyle = Math.round($('.pre-image').width()) + "~" + Math.round($('.pre-image').height());
                $("#pre-image-style").val($_preimagestyle);
            }
            $("#post-image-style").val($_imagestyle);
            return value +'px';
        },
        min: 40,
        step: 10,
        max: 200,
        value: Math.round($('.post-image').width()),
        tooltip_position:'bottom'
    });

    setTimeout(function(){
        $slider1.on('change', function(event) {
            var a = event.value.newValue;
            var b = event.value.oldValue;

            var pre_width = Math.round($('.pre-image').width());
            var post_width = MAX_WIDTH - pre_width;
            if (a > 50) {
                //$slider2.slider('setValue', post_width, true);
                var ex2 = $('#combex2').bootstrapSlider();
                $('#combex2').bootstrapSlider('setValue', post_width);
                //$slider2.slider('refresh');
            }

            var src1_img_h = Math.round($('.pre-image').height());
            var src2_img_h = Math.round($('.post-image').height());
            HIGHT = src1_img_h - (PAD*2);
            if(src2_img_h > src1_img_h){
                HIGHT = src2_img_h - (PAD*2);
            }
            $(".image-divider").css("height",HIGHT);
        });
    },200);

    setTimeout(function(){
        $slider2.on('change', function(event) {
            var a = event.value.newValue;
            var b = event.value.oldValue;

            var post_width = Math.round($('.post-image').width());
            var pre_width = MAX_WIDTH - post_width;
            if (a > 50) {
                //$slider2.slider('setValue', post_width, true);
                var ex1 = $('#combex1').bootstrapSlider();
                $('#combex1').bootstrapSlider('setValue', pre_width);
                //$slider2.slider('refresh');
            }

            var src1_img_h = Math.round($('.pre-image').height());
            var src2_img_h = Math.round($('.post-image').height());
            HIGHT = src1_img_h  - (PAD*2);
            if(src2_img_h > src1_img_h){
                HIGHT = src2_img_h - (PAD*2);
            }
            $(".image-divider").css("height",HIGHT);
        });
    },200);

});
function combinelogos() {
    var cnt = $('#logocnt').val();
    /*console.log(cnt);
    return;*/
    if ($('.pre-image').attr('src').indexOf("upload-image.png") > 0 || $('.post-image').attr('src').indexOf("upload-image.png") > 0 || $('.pre-image').attr('src') == '' || $('.post-image').attr('src') == '') {
        alert("Please select a logo.");
        return;
    }else if( cnt == 3 ) {
        $("#logonamesel").text("");
        alert('Maximum of three logos uploaded at one time. Delete one logo then upload its replacement.');
        return;
    }else {
        $("#uploadlogotype").val('combine');
        $('#fuploadload').submit();
    }
}

var header_advance = {

    /**
     ** dropFile function
     **/
    dropZoneInit: function() {
        function setup(id) {
            let options = {
                thumbnailWidth: 220,
                maxFiles: 3,
                url : "/upload-target",
                dictResponseError: "Server not Configured",
                dictFileTooBig: "File too big ({{filesize}}MB). Must be less than {{maxFilesize}}MB.",
                dictCancelUpload: "",
                // previewsContainer: ".logo-list-left",
                init: function() {
                    var self = this;
                    //New file added
                    self.on("addedfile", function(file) {
                    });

                    self.on("removedfile", function(file) {
                        var getLength = $("#logos-append .dz-preview").length;
                        if(getLength >= 1) {
                            jQuery('#logos-head').css('display', 'flex');
                            jQuery('.nologo-step').hide();
                        }
                        else {
                            jQuery('#logos-head').css('display', 'none');
                            jQuery('.nologo-step').show();
                        }
                    });
                    // Send file starts
                    self.on("sending", function(file) {
                        if(id == 'logo-image') {
                            $("#logos-append").append(file.previewTemplate);
                        }

                        var getLength = $("#logos-append .dz-preview").length;
                        if(getLength >= 1) {
                            jQuery('#logos-head').css('display', 'flex');
                            jQuery('.nologo-step').hide();
                        }
                        else {
                            jQuery('#logos-head').css('display', 'none');
                            jQuery('.nologo-step').show();
                        }
                    });

                    self.on("complete", function(file, response) {
                        if (file.name !== "442343.jpg") {
                        }
                    });

                    self.on("maxfilesreached", function(file, response) {

                    });

                    self.on("maxfilesexceeded", function(file, response) {
                        this.removeFile(file);
                    });
                    self.on("totaluploadprogress", function (progress) {
                        $(".the-progress-text").text(parseInt(progress) + '%');
                    });
                },
                previewTemplate: `
						<div class="dz-preview dz-file-preview">
							<div class="dz-wrap">
							  <div class="dz-image"><img data-dz-thumbnail /></div>
							    <div class="dz-image-detail">
                                  <div class="dz-filename"><span data-dz-name></span></div>
                                  <div class="dz-progress">
                                    <span class="dz-upload" data-dz-uploadprogress></span>
                                  </div>
                                  <span class="the-progress-text"></span>
                                 </div>
                                  <div class="dz-remove">
                                    <a href="javascript:undefined;" data-dz-remove="" class="remove-image">delete</a>
                                    <a href="#" class="remove-header-image">remove from header</a>
                                  </div>
							</div>
						</div>`
            };
            try {
                var myDropzone = new Dropzone(`#${id}`, options);
            } catch (e) {
                console.log('dropzone issue: ', e);
            }
        }
        setup("logo-image");
    },

    dropzoneTriggerInit: function(){
      jQuery('.btn-dropzone').click(function(e){
          e.preventDefault();
         jQuery('#logo-image').click();
      });
    },

    logoSelection: function () {
        jQuery(document).on('click', '.logos-preview .dz-image', function () {
            var getSrc = jQuery(this).find('img').attr('src');
            var altText = jQuery(this).find('img').attr('alt');

            if(jQuery(this).parents('.dz-preview').hasClass('selected')) {
                jQuery(this).parents('.dz-preview').removeClass('selected');
            }

            else {
                jQuery('.logos-preview .dz-preview').removeClass('selected');
                jQuery(this).parents('.dz-preview').addClass('selected');
            }
            jQuery('.hp-step1').hide();
            jQuery('.hp-step2').show();
            jQuery('.logo-size-item').show();
            jQuery('.hp__logo img').attr('src', getSrc);
            jQuery('.hp__logo img').attr('alt', altText);
        });

        jQuery(document).on('click', '.logos-preview .remove-header-image', function (e) {
            e.preventDefault();
            jQuery(this).parents('.dz-preview').removeClass('selected');
            jQuery('.hp__logo img').attr('src', '');
            jQuery('.hp__logo img').attr('alt', '');

            var $name =  $('#company-name').val();
            var $cta_number = $('#cta-phone-number').val();
            var $cta_phone = $('#phone-number').val();
            var $email = $('#company-email').val();
            jQuery('.logo-size-item').hide();
            if ($name == '' && ($cta_number == '' || $cta_number == undefined) && $cta_phone == '' && $email == '') {
                jQuery('.hp-step1').show();
                jQuery('.hp-step2').hide();
            }
        });
    },

    initRange: function () {
        $('.logo-size-slider').bootstrapSlider({
            formatter: function(value) {
                return   value +'px';
            },
            min: 40,
            max: 200,
            step: 1,
            value: 100,
            tooltip_position:'bottom',
        }).on("slide", function(slideEvt) {
            $('.hp__logo').css('max-width', slideEvt.value);
        });
    },

    /**
     ** init
     **/
    init: function () {
        header_advance.dropZoneInit();
        header_advance.dropzoneTriggerInit();
        header_advance.logoSelection();
        header_advance.initRange();
    }
};

$(document).ready(function () {
    header_advance.init();
});

Dropzone.autoDiscover = false;