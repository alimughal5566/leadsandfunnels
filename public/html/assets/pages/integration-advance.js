$(document).ready(function () {
    var amIclosing = false;

    jQuery(".all-integration-area__view-more").click(function (e) {
        e.preventDefault();
        lpUtilities.scrollArea();
        jQuery(this).toggleClass('active');
        $('.advance-intergration-holder__col').each(function(){
            if ( jQuery(this).hasClass('active'))
            {
                jQuery(this).slideUp().removeClass('active');
            }
            if ( jQuery(this).css('display') == 'none')
            {
                jQuery(this).slideDown().addClass('active');
            }
        });
    });

    jQuery('.popular-integration-slider').slick({
        slidesToScroll: 1,
        rows: 0,
        infinite: false,
        slidesToShow: 6,
        prevArrow: '<button class="slick-prev"><span class="ico-arrow-left"></span></button>',
        nextArrow: '<button class="slick-next"><span class="ico-arrow-right"></span></button>',
        responsive: [{
            breakpoint: 1700,
            settings: {
                slidesToScroll: 1,
                slidesToShow: 5
            }
        }, {
            breakpoint: 1600,
            settings: {
                slidesToScroll: 1,
                slidesToShow: 5
            }
        }, {
            breakpoint: 1440,
            settings: {
                slidesToScroll: 1,
                slidesToShow: 4
            }
        }]
    });

    $('#alphabet-sorting').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.alphabet__sorting-parent'),
    }).on('select2:openning', function() {
        jQuery('.alphabet__sorting-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.alphabet__sorting-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.alphabet__sorting-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.alphabet__sorting-parent .select2-dropdown').hide();
        jQuery('.alphabet__sorting-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.alphabet__sorting-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.alphabet__sorting-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#alphabet-sorting').find(':selected').index();
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
            jQuery('.alphabet__sorting-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#alphabet-sorting').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.alphabet__sorting-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.alphabet__sorting-parent .select2-selection__rendered').show();
        jQuery('.alphabet__sorting-parent .select2-results__options').css('pointer-events', 'none');
    });

    var question_input_type = [
        {
            id:1,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-dotted-check"></i></span><span class="text">All Categories</span></div>',
            title:'Address'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-settings"></i></span><span class="text">Advanced</span></div>',
            title:'Birthday'
        },
        {
            id:3,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-start-rate"></i></span><span class="text">Premium</span></div>',
            title:'CTA Message'
        },
        {
            id:4,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-z"></i></span><span class="text">Zapier</span></div>',
            title:'Date Picker'
        },
        {
            id:5,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-plugin"></i></span><span class="text">Compatible</span></div>',
            title:'Drop Down'
        }
    ];

    $('#category-sorting').select2({
        data: question_input_type,
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.category__sorting-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('select2:openning', function() {
        jQuery('.category__sorting-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.category__sorting-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.category__sorting-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.category__sorting-parent .select2-dropdown').hide();
        jQuery('.category__sorting-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.category__sorting-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.category__sorting-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#category-sorting').find(':selected').index();
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
            jQuery('.category__sorting-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#category-sorting').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.category__sorting-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.category__sorting-parent .select2-selection__rendered').show();
        jQuery('.category__sorting-parent .select2-results__options').css('pointer-events', 'none');
    });
});

$(window).resize(function(){
    jQuery('.popular-integration-slider').slick('refresh');
});