var lpSticky = {
    $owl : jQuery('.owl-carousel'),

    /**
     ** Url Validation
     **/
    urlValidationInit: function() {
        var ValidateUrl = function(domainName) {
            if (domainName!= null && domainName!= undefined) {
                var pattern = new RegExp(/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[A-Za-z0-9]+([\-\.]{1}[A-Za-z0-9]+)*\.[A-Za-z]{2,63}(:[0-9]{1,5})?(\/.*)?$/);
                return pattern.test(domainName);
            }
            else {
                return false;
            }
        }
        $('.input-url').keyup(function() {
            var _self = jQuery(this);
            var value = $(this).val();
            var valid = ValidateUrl(value);
            if (valid) {
                setTimeout(function(){
                    if(jQuery('body').hasClass('iframe-active')){

                    }
                    else {
                        jQuery('body').addClass('loader-active');
                        jQuery('#loader-text').html('website preview is loading...');
                    }
                }, 1000);

                setTimeout(function(){
                    jQuery('body').removeClass('loader-active').addClass('iframe-active');
                }, 3000);
            }
            else {
                setTimeout(function(){
                    jQuery('body').removeClass('loader-active');
                }, 1000);
                setTimeout(function(){
                    jQuery('body').removeClass('loader-active iframe-active');
                    jQuery('#loader-text').html('ADD URL TO SEE PREVIEW');
                }, 3000);
            }
            var winWidth = jQuery(window).width();
            var stickyHeight = jQuery('.sticky-bar').outerHeight();
            console.log(winWidth);
            var sidePanel = jQuery('.sticky-side').width();
            console.log(sidePanel);
            var getScale = 1 - sidePanel / winWidth;
            var heightScale = stickyHeight - stickyHeight * getScale;
            jQuery('.preview-area').css('margin-top', '-'+heightScale+'px' );
        });
    },

    /**
     ** Url Path Validation
     **/
    urlPathInit: function() {
        var ValidateUrl = function(path) {
            /*if (domainName!= null && domainName!= undefined) {
                var pattern = new RegExp(/^(?:\.{2})?(?:\/\.{2})*(\/[a-zA-Z0-9]+)+$/);
                return pattern.test(domainName);
            }
            else {
                return false;
            }*/

            if (path) {
                return path.indexOf('/') === 0;
            }
            else {
                return false;
            }
        }

        jQuery('body').on('keyup', '.input-url-path', function(){
            var value = $(this).val();
            var valid = ValidateUrl(value);
            if (valid) {
                jQuery(this).parents('.url-add-field').removeClass('has-error');
            }
            else {
            }
        });

        jQuery('body').on('keydown', '.input-url-path', function (e){
            if (e.keyCode === 13) {
                var _self = jQuery(this);
                var value = $(this).val();
                var valid = ValidateUrl(value);
                if (valid) {
                    jQuery(this).parents('.url-add-field').removeClass('has-error');
                    jQuery(this).parents('.url-slide__detail').find('.add-url-btn').click();
                    jQuery(this).parents('.url-fields-wrap').find('.url-add-field:last-child input').focus();
                }
                else {
                    jQuery(this).parents('.url-add-field').addClass('has-error');
                }
            }
        });
    },

    /**
     ** Url Validation
     **/
    selectInit: function() {
        jQuery('.select-holder__slide').slideUp();
        jQuery('.select-holder .select-holder__opener').click(function(e) {
            e.preventDefault();
            var _self = jQuery(this);
            _self.parent().toggleClass('select-active');
            _self.next().slideToggle();
        });

        jQuery('.list-options__link').click(function(e){
            e.preventDefault();
            var _self = jQuery(this);
            var clickedItem = _self.html();
            _self.parents('.select-holder__slide').slideUp();
            _self.parents('.select-holder').find('.select-holder__opener').html(clickedItem);
        });

        jQuery(document).on("click", function(e) {
            if (jQuery(e.target).is('.select-holder__opener'))  return false;
            else {
                jQuery('.select-holder').removeClass('select-active');
                jQuery('.select-holder__slide').slideUp();
            }
        });
    },

    /**
     ** open close funcation
     **/
    openCloseInit: function() {
        jQuery('.setting-open-close__slide').slideUp();
        jQuery('.setting-open-close__opener').click(function(e) {
            e.preventDefault();
            var _self = jQuery(this);
            _self.parent().toggleClass('slide-active');
            _self.next().slideToggle();
            setTimeout(function () {
                $('.owl-carousel').trigger('refresh.owl.carousel');
            }, 600);
        });
    },

    /**
     ** radioSwicher funcation
     **/

    radioSwicherInit: function() {
        jQuery('body').on('change', '.radio-switcher input[type="radio"]', function(){
            var _self = jQuery(this);
            _self.parents('.switcher-area').find('.slide').slideToggle();
            setTimeout(function () {
                $('.owl-carousel').trigger('refresh.owl.carousel');
            }, 600);
        });

        jQuery('body').on('change', '.checker-number-wrap input[type="checkbox"]', function(){
            var _self = jQuery(this);
            _self.parents('.checker-number-wrap').find('.number-slide').slideToggle(function(){
                _self.parents('.checker-number-wrap').find('.number-slide input').focus();
            });
            setTimeout(function () {
                $('.owl-carousel').trigger('refresh.owl.carousel');
            }, 600);
        });
    },

    /**
     ** range slider single value
     **/
    rangeSliderInit: function() {

        jQuery('#slider').bootstrapSlider({
            formatter: function(value) {
                return 'Current value: ' + value;
            }
        });
    },

    /*
    **
    **/
    customSelectInit: function() {
        var amIclosing = false;

        jQuery('.select-default').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".select-parent"),
            width: '100%'
        });

        jQuery('#provider-select').select2({
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(".provider-select-parent"),
            width: '100%'
        }).on('select2:openning', function() {
            jQuery('.provider-select-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.provider-select-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.provider-select-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.provider-select-parent .select2-dropdown').hide();
            jQuery('.provider-select-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.provider-select-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.provider-select-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#provider-select').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.provider-select-parent .select2-selection__rendered').show();
            jQuery('.provider-select-parent .select2-results__options').css('pointer-events', 'auto');
        });

        var question_type = [
            {
                id:0,
                text:'<div class="bar-type"><i class="icon icon-website"></i>My Own Website or Page</div>',
                title:'My Own Website or Page'
            },
            {
                id:1,
                text:'<div class="bar-type"><i class="icon icon-funnel"></i>This funnel</div>',
                title:'This funnel'
            },
            {
                id:2,
                text:'<div class="bar-type"><i class="icon icon-3rd-party"></i>3rd Party Website or Page</div>',
                title:'3rd Party Website or Page'
            },
        ];
        $('.select2js__slct-question').select2({
            width: '100%',
            data:question_type,
            minimumResultsForSearch: -1,
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); },
            dropdownParent: $('.select2js__slct-question-parent')
        });
    },

    /*
    **
    **/
    rangeSlider: function() {
        $('#ex1').slider({
            formatter: function(value) {
                jQuery('#slider-val').html(value);
            }
        });
    },

    /**
     ** Tooltip Initialization
     **/
    tooltip: function () {
        jQuery('.tooltipster').tooltipster({
            trigger: 'hover',
            animation: 'fade',
            contentAsHTML: true,
            maxWidth: 300,
            delay: 100,
            contentCloning: true,
            interactive: true
        });
    },

    /**
     ** add url
     **/

    addurl: function () {
        jQuery('.switcher__link').click(function () {
            jQuery(this).parents('.sticky-side').addClass('url-active');
        });

        jQuery('.back-url').click(function () {
            jQuery(this).parents('.sticky-side').removeClass('url-active');
        });
    },

    /*
   ** owlCarousel Function
   **/
    owlCarousel: function () {
        lpSticky.$owl.owlCarousel({
            loop: false,
            margin: 0,
            nav: true,
            dots: true,
            touchDrag: false,
            mouseDrag: false,
            autoHeight : true,
            items:1,
        });
    },

    owlPrev: function () {
        jQuery('.lp-sticky__btn-back').on('click',function(e){
            e.preventDefault();
            lpSticky.$owl.trigger('prev.owl.carousel', [300]);
        });
    },

    owlNext: function () {
        jQuery('.owl__btn-next').on('click',function(e){
            e.preventDefault();
            lpSticky.$owl.trigger('next.owl.carousel', [300]);
        });
    },

    /*
    ** scroll Function
    **/
    scroll: function () {
        jQuery(".scroll-holder").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar : true,
            mouseWheel:{
                scrollAmount: 100
            },
        });

        jQuery(".url-slide__wrap").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar : true,
            mouseWheel:{
                scrollAmount: 100
            },
        });

        jQuery(".url-slide__wrap").mCustomScrollbar("update");
    },

    /*
   ** code switcher Function
   **/
    codeSwicherInit: function() {
        jQuery('body').on('change', '.check-switcher input[type="checkbox"]', function(){
            var _self = jQuery(this);
            if(_self.prop("checked") == true){
                jQuery("#code-block").html('&lt;sript type=”text/javascript” <br>src=”https://dev2itclix.com/c475a0c0ebf80d88ac.js”&gt; &lt;/script&gt;');
            }
            else {
                jQuery("#code-block").html("&lt;!---------leadPops Sticky Bar Code Starts Here---------><br ><br >\
                                        &lt;sript type=”text/javascript” src=”https://dev2itclix.com/c475a0c0ebf80d88ac.js”> &lt;/script><br ><br >\
                                        &lt;!---------leadPops Sticky Bar Code Ends Here--------->");
            }
            _self.parents('.lp-code-block').toggleClass('non-script');
        });
    },


    /*
   ** code switcher Function
   **/
    alertActiveInit: function() {
        var timerID  = null;
        jQuery('body').on('change', '.switcher-checkbox input[type="checkbox"]', function(){
            clearTimeout(timerID);
            var _self = jQuery(this);
            _self.parents('.sticky-side__wrap').find('#msg .msg-text').html('Sticky Bar has been updated.');
            _self.parents('.sticky-side__wrap').find('#msg').slideDown();

            timerID = setTimeout(function(){
                _self.parents('.sticky-side__wrap').find('#msg').slideUp();
            }, 5000);
        });
    },

    alertCloseinit: function() {
        jQuery('.sticky-side__close').click(function(){
            jQuery(this).parents('#msg').slideUp();
        });
    },

    /*
    ** radio tabs
    **/
    radioTabsInit: function() {
        jQuery('body').on('change', '.sb-radio-options input[type="radio"]', function(){
            var _self = jQuery(this);
            var currentVal = jQuery(this).attr('data-title');
            jQuery('.list-tab-item').slideUp();
            jQuery('.list-tab-item').each(function(){
                var currId = jQuery(this).attr('id');
                if (currId == currentVal) {
                    jQuery(this).slideDown();
                }
            });
            setTimeout(function () {
                $('.owl-carousel').trigger('refresh.owl.carousel');
            }, 600);
        });
    },

    /*
    ** add URL field
    **/
    addUrlInit: function() {
        var html = '<div class="url-add-field" style="display: none;">\
                        <div class="field">\
                            <label><i class="ico-link"></i></label>\
                            <input class="form-control input-url-path" type="text" placeholder="/url-path-goes-here">\
                            <a href="#" class="close-field"><i class="ico-cross"></i></a>\
                            <span class="error-message">Please Enter a valid Path</span>\
                        </div>\
                        <div class="url-message">\
                            <span class="text">Are you sure you want to delete this path?</span>\
                            <ul class="url-option">\
                                <li><a href="#" class="remove-url">YES</a></li>\
                                <li><a href="#" class="active-url">NO</a></li>\
                            </ul>\
                        </div>\
                    </div>';
        jQuery('body').on('click', '.add-url-btn', function(e){
            e.preventDefault();
            var _self = jQuery(this);
            var ValidateUrl = function(path) {
                /*if (domainName!= null && domainName!= undefined) {
                    var pattern = new RegExp(/^(?:\.{2})?(?:\/\.{2})*(\/[a-zA-Z0-9]+)+$/);
                    return true;
                }
                else {
                    return false;
                }*/
                if (path) {
                    return path.indexOf('/') === 0;
                }
                else {
                    return false;
                }
            }
            var value = jQuery('.url-fields-wrap').find('.url-add-field:last-child input').val();
            var valid = ValidateUrl(value);
            if (valid) {
                _self.parents('.url-slide__detail').find('.url-fields-wrap').append(html);
                jQuery('.url-add-field:last-child').slideDown();
                jQuery('.url-fields-wrap').find('.url-add-field:last-child').removeClass('has-error');
            }
            else {
                jQuery('.url-fields-wrap').find('.url-add-field:last-child').addClass('has-error');
            }

            var checklength = jQuery('.url-fields-wrap').children().length;
            if(checklength == 0){
                _self.parents('.url-slide__detail').find('.url-fields-wrap').append(html);
                jQuery('.url-add-field:last-child').slideDown();
            }
        });

        jQuery('body').on('click', '.close-field', function(e){
            e.preventDefault();
            var _self = jQuery(this);
            _self.parents('.url-add-field').addClass('active');
        });

        jQuery('body').on('click', '.active-url', function(e){
            e.preventDefault();
            var _self = jQuery(this);
            _self.parents('.url-add-field').removeClass('active');
        });

        jQuery('body').on('click', '.remove-url', function(e){
            e.preventDefault();
            var _self = jQuery(this);
            _self.parents('.url-add-field').slideUp();
            setTimeout(function () {
                _self.parents('.url-add-field').remove();
            }, 200);
        });
    },

    scaledArea: function() {
        var winWidth = jQuery(window).width();
        var stickyHeight = jQuery('.sticky-bar').outerHeight();
        console.log(winWidth);
        var sidePanel = jQuery('.sticky-side').width();
        console.log(sidePanel);
        var getScale = 1 - sidePanel / winWidth;
        var heightScale = stickyHeight - stickyHeight * getScale;
        jQuery('.preview-area').css('margin-top', '-'+heightScale+'px' );
        jQuery('.sticky-bar').css({'transform': 'scale('+getScale+')', 'width': winWidth});
    },

    /*
    **sticky text
    **/
    stickyTextinit: function () {
        jQuery('body').on('keyup', '#sticky-text', function(e){
            jQuery('#sticky-bar__p').html(jQuery(this).val());
        });
        jQuery('body').on('keyup', '#sticky-btn', function(e){
            jQuery('#sticky-bar__btn').html(jQuery(this).val());
        });
    },
    /*
    ** resizeEffect Function
    **/
    resizeEffect: function () {
        jQuery(window).resize(function () {
            lpSticky.scaledArea();
        });
    },

    /*
    **copy the code
    **/
    copyTextinit: function () {
        var timerID  = null;
        jQuery('.btn-copy').click(function(e){
            e.preventDefault();
            var _self = jQuery(this);
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('#code-block').text()).select();
            document.execCommand("copy");
            $temp.remove();
            _self.parents('.sticky-side__wrap').find('#msg .msg-text').html('Sticky Bar code has been copied.');
            _self.parents('.sticky-side__wrap').find('#msg').slideDown();
            clearTimeout(timerID);
            timerID = setTimeout(function(){
                _self.parents('.sticky-side__wrap').find('#msg').slideUp();
            }, 5000);
        });
    },

    stickyCloseinit: function () {
        jQuery('body').on('change', '.sticky-close-toggle', function(){
            jQuery('.sticky-bar__close').fadeToggle();
        });
    },

    stickybarPositioninit: function () {
        jQuery('body').on('change', '.sticky-position-handler', function(){
            jQuery('.sticky-bar').toggleClass('fixed-bottom');
            jQuery('.sticky-content').toggleClass('bottom-align');
            var winWidth = jQuery(window).width();
            var stickyHeight = jQuery('.sticky-bar').outerHeight();
            var sidePanel = jQuery('.sticky-side').width();
            var getScale = 1 - sidePanel / winWidth;
            var heightScale = stickyHeight - stickyHeight * getScale;
            var checkstate = jQuery('.bottom-controller').is('checked');
            if($('.bottom-controller').is(':checked')) {
                jQuery('.preview-area').css('margin-top', 0);
            }
            else {
                jQuery('.preview-area').css('margin-top', '-' + heightScale + 'px');
            }
        });
    },

    stickybarSizesinit: function () {
        jQuery('body').on('change', '.sticky-size-handler', function(){
            if (jQuery(this).val() == 'f') {
                jQuery('.sticky-bar').removeClass('sticky-slim sticky-medium');
                jQuery('.sticky-content').removeClass('content-slim content-medium');
            }
            else if (jQuery(this).val() == 'm') {
                $('.sticky-bar').removeClass('sticky-slim');
                $('.sticky-bar').addClass('sticky-medium');
                jQuery('.sticky-content').removeClass('content-slim').addClass('content-medium');
            }
            else if ($(this).val() == 's') {
                $('.sticky-bar').removeClass('sticky-medium');
                $('.sticky-bar').addClass('sticky-slim');
                jQuery('.sticky-content').removeClass('content-medium').addClass('content-slim');
            }
        });
    },

    /*
    * init Function
    * */
    init: function () {
        lpSticky.urlValidationInit();
        lpSticky.selectInit();
        lpSticky.radioSwicherInit();
        lpSticky.openCloseInit();
        lpSticky.rangeSliderInit();
        lpSticky.customSelectInit();
        lpSticky.rangeSlider();
        lpSticky.tooltip();
        lpSticky.addurl();
        lpSticky.codeSwicherInit();
        lpSticky.scroll();
        lpSticky.radioTabsInit();
        lpSticky.addUrlInit();
        lpSticky.urlPathInit();
        lpSticky.owlPrev();
        lpSticky.owlNext();
        lpSticky.scaledArea();
        lpSticky.resizeEffect();
        lpSticky.stickyTextinit();
        lpSticky.alertActiveInit();
        lpSticky.copyTextinit();
        lpSticky.alertCloseinit();
        lpSticky.stickyCloseinit();
        lpSticky.stickybarPositioninit();
        lpSticky.stickybarSizesinit();
        jQuery(".phone").inputmask({"mask": "(999) 999-9999"});
    },
};

jQuery(document).ready(function () {
    lpSticky.init();
});

jQuery(window).on('load', function() {
    lpSticky.owlCarousel();
});