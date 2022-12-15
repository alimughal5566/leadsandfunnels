$(document).ready(function(){
    var selectclosing = false;
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

    $('#clr-icon').click(function () {
        var name = ".icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#menu-clr-icon').click(function () {
        var name = ".menu-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#num-clr-icon').click(function () {
        var name = ".num-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#non-num-clr-icon').click(function () {
        var name = ".non-num-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#icon-clr').ColorPicker({
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
            $(".icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".icon-clr .color-box__hex-block").val('#'+hex);
            $('#clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#menu-icon-clr').ColorPicker({
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
            $(".menu-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".menu-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".menu-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".menu-icon-clr .color-box__hex-block").val('#'+hex);
            $('#menu-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#menu-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#num-icon-clr').ColorPicker({
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
            $(".num-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".num-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".num-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".num-icon-clr .color-box__hex-block").val('#'+hex);
            $('#num-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#num-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#non-num-icon-clr').ColorPicker({
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
            $(".non-num-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".non-num-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".non-num-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".non-num-icon-clr .color-box__hex-block").val('#'+hex);
            $('#non-num-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#non-num-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#fb-clr-icon').click(function () {
        var name = ".fb-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#fb-icon-clr').ColorPicker({
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
            $(".fb-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".fb-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".fb-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".fb-icon-clr .color-box__hex-block").val('#'+hex);
            $('#fb-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#fb-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#cta-clr-icon').click(function () {
        var name = ".cta-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#cta-icon-clr').ColorPicker({
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
            $(".cta-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".cta-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".cta-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".cta-icon-clr .color-box__hex-block").val('#'+hex);
            $('#cta-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#cta-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#dropdown-clr-icon').click(function () {
        var name = ".dropdown-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#dropdown-icon-clr').ColorPicker({
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
            $(".dropdown-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".dropdown-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".dropdown-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".dropdown-icon-clr .color-box__hex-block").val('#'+hex);
            $('#dropdown-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#dropdown-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#contact-clr-icon').click(function () {
        var name = ".contact-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#contact-icon-clr').ColorPicker({
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
            $(".contact-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".contact-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".contact-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".contact-icon-clr .color-box__hex-block").val('#'+hex);
            $('#contact-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#contact-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#textfield-clr-icon').click(function () {
        var name = ".textfield-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#textfield-icon-clr').ColorPicker({
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
            $(".textfield-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".textfield-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".textfield-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".textfield-icon-clr .color-box__hex-block").val('#'+hex);
            $('#textfield-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#textfield-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    $('#textfield-large-clr-icon').click(function () {
        var name = ".textfield-large-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#textfield-large-icon-clr').ColorPicker({
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
            $(".textfield-large-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".textfield-large-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".textfield-large-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".textfield-large-icon-clr .color-box__hex-block").val('#'+hex);
            $('#textfield-large-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#textfield-large-clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });

    // var completeUrl = window.location.href;
    var selectText = window.location.href.split("#").pop(); // => "Tabs1"
    // console.log(tabId);

    if(selectText == "global-question"){
        $('#question-select option[value="1"]').attr("selected",false);
        $('#question-select option[value="3"]').attr("selected",false);
        $('#question-select option[value="4"]').attr("selected",false);
        $('#question-select option[value="2"]').attr("selected",true);
        console.log($('#question-select').val());
        $('.question-transition').hide();
        $('.question-pre-made').hide();
        $('.question-standard').hide();
        $('.question-global').show();
    }else if(selectText == "pre-made-question"){
        $('#question-select option[value="1"]').attr("selected",false);
        $('#question-select option[value="2"]').attr("selected",false);
        $('#question-select option[value="4"]').attr("selected",false);
        $('#question-select option[value="3"]').attr("selected",true);
        console.log($('#question-select').val());
        $('.question-transition').hide();
        $('.question-standard').hide();
        $('.question-global').hide();
        $('.question-pre-made').show();
    }else if(selectText == "transitions"){
        $('#question-select option[value="1"]').attr("selected",false);
        $('#question-select option[value="2"]').attr("selected",false);
        $('#question-select option[value="3"]').attr("selected",false);
        $('#question-select option[value="4"]').attr("selected",true);
        console.log($('#question-select').val());
        $('.question-pre-made').hide();
        $('.question-standard').hide();
        $('.question-global').hide();
        $('.question-transition').show();
    }

    /**
     * Tooltip Plugin
     * */
    $.fn.lptooltip = function(options){
        // return this.each(function() {
        var settings = $.extend({
            bottomSpace:5,
            leftMargin:-3
        },options);
        var p = $(this).position();
        var w = $(this).find('.fb-tooltip__text').width() / 2;
        var top = p.top - 40 - settings.bottomSpace;
        var left = p.left - Math.ceil(w - settings.leftMargin);
        $(this).find('.fb-tooltip__text').css({'left':left , 'top':top})
        // });

    };

    /**
     * Init Tooltip Plugin
     * */

    /*   $('.fb-tooltip_init').lptooltip();
       $('.fb-question-item').mouseover(function(){
           console.info('length:'+$(this).find('.fb-tooltip_control').length);
           $(this).find('.fb-tooltip_control').lptooltip({
               bottomSpace:15,
               leftMargin: 2
           });
       });*/
    $('.el-tooltip-disabled').tooltipster({
        delay: 20,
        contentAsHTML:true
    });
    $('.fb-tooltip_control').tooltipster({
        parent:'.funnel-wrap',
        delay: 0,
        contentAsHTML:true,
        multiple: true
    });


    /**
     *  Drag and Drop Jquery
     * */

    var obj_data= {
        question_type:'',
        question_dsc:'',
        question_icon:'',
        question_class:'',
        question_transition:0,
        data_list:'',
        data_icon:'',
        dropable_only:''
    };



    $(".question-option__item").draggable({
        revert: 'invalid',
        cursor: "move",
        helper: "clone",
        connectToSortable: ".funnel-panel__sortable",
        appendTo: 'body',
        cursorAt: { top: 25, left: 50 },
        start: function(event, ui) {
            $('.question-option__item').addClass('question-option__item_disabled');
            obj_data.data_icon = '';
            if($(this).parent().hasClass('global-list')) {
                obj_data.data_list = 'fb-question-item_global';
                obj_data.data_icon = '<div class="fb-question-item__col fb-question-item__col_icon"><i class="fas fa-globe-americas"></i></div>'
            }else if($(this).parent().hasClass('pre-made-list')) {
                obj_data.data_list = 'fb-question-item_pre-made';
                obj_data.data_icon = '<div class="fb-question-item__col fb-question-item__col_icon"><i class="ico ico-start-rate"></i></div>'
            }
            obj_data.question_type = $(this).text();
            obj_data.question_icon = $(this).data('icon');
            obj_data.question_class = $(this).data('class');
            if($('.funnel-panel__sortable .fb-question-item').length == 2){
                $('.funnel-panel__sortable').removeClass("placeholder");
            }
        },
        stop: function (event, ui) {
            $('.question-option__item').removeClass('question-option__item_disabled');
        }
    });

    $(".question-option__item[disabled]").draggable({
        disabled: true
    });

    $(".dropable-funnel-option").droppable({
        accept: ".question-option__item",
        drop: function(event, ui) {
            obj_data.dropable_only = 1;
        }
    });
    // $( ".funnel-panel__sortable" ).droppable({
    //     disabled: true
    // });

    $('.funnel-panel__sortable').sortable({
        // disabled: false,
        placeholder: "fb-question-item__highlight",
        // items: ".fb-question-item:not(.fb-question-item_lock)",
        items: ".fb-question-item",
        // scroll: false,
        // axis: "y",
        handle: ".lp-control__link_cursor_move",
        // forcePlaceholderSize: true,
        tolerance: "pointer",
        // helper: 'clone',
        start:function(event,ui){
            // obj_data.dropable_only = '';
            var $item = ui.item;
            if ($item.hasClass('question-option__item_transition') || $item.hasClass('fb-question-item_transition')) {
                $('.fb-question-item__highlight').text('Drag & Drop Your Transition Here');
            }else {
                $('.fb-question-item__highlight').text('Drag & Drop Your Question Here');
            }
        },
        stop: function(event,ui) {
            // console.log(ui.item.html())
            if (obj_data.dropable_only == 1) {
                var i = 1;
                $(this).parents('.funnel-panel__body').find('.fb-question-item').not('.fb-question-item_transition').each(function(){
                    $(this).find('.fb-question-item__serial').text(i+'.');
                    i++;
                });
                $('.funnel-panel__placeholder').hide();
                $('.funnel-panel__sortable').show();
                $('.dropable-funnel-option').css({'height':'auto','margin':'0'});
                $('body').addClass('funnel-question-page_overlay');
                if (ui.item.hasClass('question-option__item_zipcode')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">FREE Down Payment Assistance Finder</span></div>';
                    setTimeout(function(){
                        $('body').addClass('zipcode-overlay');
                    }, 50);
                }
                if (ui.item.hasClass('question-option__item_menu')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">What type of loan do you need?</span></div>';
                    setTimeout(function(){
                        $('body').addClass('menu-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_number')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">What type of number do you need?</span></div>';
                }
                if (ui.item.hasClass('question-option__item_date-picker')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">Arrange an appointment?</span></div>';
                }
                if (ui.item.hasClass('question-option__item_state')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">In which state of the United States do you live?</span></div>';
                }
                if (ui.item.hasClass('question-option__item_slider')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">What is the purchase price of the new property?</span></div>';
                    setTimeout(function(){
                        $('body').addClass('slider-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_estimate')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">What is your estimated down payment?</span></div>';
                }
                if (ui.item.hasClass('question-option__item_credit')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">What is your estimated credit score?</span></div>';
                }
                if (ui.item.hasClass('question-option__item_type-home')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">What type of property are you purchasing?</span></div>';
                }
                if (ui.item.hasClass('question-option__item_textfield')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="sub-text">How will this property be used?</span></div>';
                    setTimeout(function(){
                        $('body').addClass('txtfield-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_dropdown')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="question-detail-null">Question N/A</span></div>';
                    setTimeout(function(){
                        $('body').addClass('dropdown-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_address')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="question-detail-null">Question N/A</span></div>';
                    setTimeout(function(){
                        $('body').addClass('address-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_cta')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="question-detail-null">Question N/A</span></div>';
                    setTimeout(function(){
                        $('body').addClass('cta-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_calendar')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="question-detail-null">Question N/A</span></div>';
                    setTimeout(function(){
                        $('body').addClass('date-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_birthday')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col"><span class="question-detail-null">Question N/A</span></div>';
                    setTimeout(function(){
                        $('body').addClass('birthday-overlay').css('overflow','hidden');
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_hidden-field')) {
                    $('#hidden-field-pop').modal('show');
                    setTimeout(function(){
                        $('.fb-question-item-loader').remove();
                    }, 500);
                }
                if (ui.item.hasClass('question-option__item_contact')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col fb-question-item__col_plr14">\n' +
                        '                                            <label class="fb-step-label">3 - STEP</label>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="fb-question-item__col">\n' +
                        '                                            <div class="fb-step">\n' +
                        '                                                <div class="fb-step__title">Step 1:</div>\n' +
                        '                                                <div class="fb-step__caption">Full Name</div>\n' +
                        '                                            </div>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="fb-question-item__col">\n' +
                        '                                            <div class="fb-step">\n' +
                        '                                                <div class="fb-step__title">Step 2:</div>\n' +
                        '                                                <div class="fb-step__caption">Email Address</div>\n' +
                        '                                            </div>\n' +
                        '                                        </div>\n' +
                        '                                        <div class="fb-question-item__col">\n' +
                        '                                            <div class="fb-step">\n' +
                        '                                                <div class="fb-step__title">Step 3:</div>\n' +
                        '                                                <div class="fb-step__caption">Phone Number</div>\n' +
                        '                                            </div>\n' +
                        '                                        </div>';
                    setTimeout(function(){
                        $('body').addClass('contact-overlay').css('overflow','hidden');
                    }, 500);
                }
                if(!ui.item.hasClass('ui-draggable')) return;
                if(obj_data.question_transition == 0) {
                    ui.item.replaceWith(
                        '<div class="fb-question-item slide '+ obj_data.data_list +' '+obj_data.question_class +'" >\n' +
                        '   <div class="question-item single-question-slide lp-control__link_cursor_move">\n' +
                        '   <div class="fb-question-item__serial">1.</div>\n' +
                        '      <div class="fb-question-item__detail">\n' +
                        '         <div class="fb-question-item__col">\n' +
                        '            <div class="icon-text '+obj_data.question_icon+'">'+obj_data.question_type+'</div>\n' +
                        '         </div> '+obj_data.question_dsc +
                        '         <div class="fb-question-item__col fb-question-item__col_control">\n' +
                        '            <a href="#" class="hover-hide">\n' +
                        '               <i class="fbi fbi_dots">\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '               </i>\n' +
                        '            </a>\n' +
                        '            <ul class="lp-control">\n' +
                        '                <li class="lp-control__item">\n' +
                        '                    <a title="Conditional&nbsp;Logic" class="lp-control__link fb-tooltip fb-tooltip_control" href="#conditional-logic" data-toggle="modal">\n' +
                        '                       <i class="lp-icon-conditional-logic ico-back"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item">\n' +
                        '                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-edit"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item">\n' +
                        '                    <a title="Duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-copy"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item lp-control__item_edit">\n' +
                        '                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control lp-icon-drag" href="#">\n' +
                        '                       <i class="ico-dragging"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item lp-control__item_edit">\n' +
                        '                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-cross" onclick="deleteDiv(this)"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '            </ul>\n' +
                        '         </div>\n' +
                        '          '+obj_data.data_icon+'  \n'+
                        '         <div class="fb-question-item__col fb-question-item__col_lock">\n' +
                        '              <a href="#">\n' +
                        '                 <i class="lp-icon-lock ico-lock"></i>\n' +
                        '              </a>\n' +
                        '         </div>\n' +
                        '   </div>\n' +
                        '   <div class="fb-question-item-loader">\n' +
                        '       <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>\n' +
                        '   </div>\n' +
                        '   </div>\n' +
                        '   </div>\n' +
                        '</div>');
                    var x = 1;
                    $(this).parents('.funnel-panel__body').find('.fb-question-item').not('.fb-question-item_transition').each(function(){
                        $(this).find('.fb-question-item__serial').text(x+'.');
                        x++;
                    });
                }else {
                    ui.item.replaceWith(
                        '<div class="fb-question-item fb-question-item_transition">\n' +
                        '      <div class="fb-question-item__detail">\n' +
                        '         <div class="fb-question-item__col">\n' +
                        '            <div class="icon-text '+obj_data.question_icon+'">'+obj_data.question_type+'</div>\n' +
                        '         </div>\n' +
                        '         <div class="fb-question-item__col fb-question-item__col_control">\n' +
                        '            <a href="#" class="hover-hide">\n' +
                        '               <i class="fbi fbi_dots">\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '               </i>\n' +
                        '            </a>\n' +
                        '            <ul class="lp-control">\n' +
                        '                <li class="lp-control__item lp-control__item_edit">\n' +
                        '                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-edit"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item">\n' +
                        '                    <a title="Duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-copy"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item">\n' +
                        '                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-dragging"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item">\n' +
                        '                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-cross"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '            </ul>\n' +
                        '         </div>\n' +
                        '         <div class="fb-question-item__col fb-question-item__col_lock">\n' +
                        '              <a href="#">\n' +
                        '                 <i class="lp-icon-lock ico-lock"></i>\n' +
                        '              </a>\n' +
                        '         </div>\n' +
                        '   </div>\n' +
                        '   <div class="fb-question-item-loader">\n' +
                        '       <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>\n' +
                        '   </div>\n' +
                        '</div>');
                }
                $('.fb-tooltip_control').tooltipster({
                    parent:'.funnel-wrap',
                    delay: 0,
                    contentAsHTML:true,
                    multiple: true
                });
            }else {
                ui.item.replaceWith('');
            }
        }
    });



    /**
     * Thank You Listing: Drag and Drop Jquery
     * */

    $('.funnel-panel__ty_sortable').sortable({
        placeholder: "fb-question-item__highlight",
        // items: ".fb-question-item:not(.fb-question-item_lock)",
        items: ".fb-question-item",
        scroll: false,
        axis: "y",
        handle: ".lp-control__link_cursor_move",
        forcePlaceholderSize: true,
        tolerance: "pointer",
        start:function(){
            $('.fb-question-item__highlight').text('Drag & Drop Your Page Here');
            $('.fb-tooltip_control').tooltipster('disable');
        },
        stop: function() {
            var ch = 'A';
            var i = 0;
            $(this).find('.fb-question-item').each(function(){
                $(this).find('.fb-question-item__serial').text(String.fromCharCode(ch.charCodeAt(0) + i));
                i++;
            });
            $('.fb-tooltip_control').tooltipster('enable');
        }
    });

    $('.lp-control__link_cursor_move').click(function (e) {
        e.preventDefault();
    })
    /**
     *  Funnel Question Select Jquery
     * */


    $('.question-option__item').click(function(){
        $('.question-option__item').removeClass('question-option__item_active');
        $(this).addClass('question-option__item_active');
        if($('#next').hasClass('lp-btn_disable'))$('#next').removeClass('lp-btn_disable');

    });

    /**
     *  Modal Dropdown
     * **/

    $(window).on('shown.bs.modal', function() {
        $('body').addClass('modal-open');
    });
    $(window).on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open');
        question_validator.resetForm();
        transition_validator.resetForm();
        clonequestion_validator.resetForm();
        clonetransition_validator.resetForm();
        Recipient.form_reset();
    });

    $('#conditional-logic-click').click(function (event) {
        event.preventDefault();
        jQuery.each(fbselectArr, function(index, item) {
            // do something with `item` (or `this` is also `item` if you like)
            initializeSelect2(item.element , item.wrap);
        });
        console.log("chaly ga ya nai ?");
    });

    $('.view-active__conditions').click(function () {
        $('#conditional-logic').modal('hide');
        $('#cl-preview').modal('show');
    });
    $('.back-condition__logic').click(function (event) {
        $('#cl-preview').modal('hide');
        $('#conditional-logic').modal('show');
    });

    $('.fb-modal__handler').click(function(){
        var parent_selector = $(this).closest('.fb-modal__border-box_dropdown');
        if(parent_selector.hasClass('open')){
            parent_selector.removeClass('open');
            parent_selector.find('.fb-modal__border-row_menu').slideUp(function () {
                parent_selector.find('.fb-froala__init').froalaEditor('events.focus', false);
            });
        }else{
            parent_selector.addClass('open');
            parent_selector.find('.fb-modal__border-row_menu').slideDown(function () {
                parent_selector.find('.fb-froala__init').froalaEditor('events.focus', true);
            });
        }
    });

    $('.fb-checkbox__input_toggle_ta').change(function(){
        $(this).parents('.fb-modal__border-box').find('textarea').toggleClass('fb-textarea_disabled');
    });

    $('[name="global_mode_bar"]').change(function(){
        if ($(this).is(':checked')) {
            $(this).parents('#wrapper').find('.global').removeClass('global_mode-off');
            $(this).parents('#wrapper').find('.global').addClass('global_mode-on');
            $(this).parents().find('.global__bar p').text("GLOBAL SETTINGS MODE IS ON");
        }else {
            $(this).parents('#wrapper').find('.global').removeClass('global_mode-on');
            $(this).parents('#wrapper').find('.global').addClass('global_mode-off');
            $(this).parents().find('.global__bar p').text("GLOBAL SETTINGS MODE IS OFF");
        }
    });

    $('#hidden-field-option').change(function(){
        if ($(this).is(':checked')) {
            $('.hidden-parameter').slideDown();
        }else {
            $('.hidden-parameter').slideUp();
        }
    });



    var select_answer = [
        {
            id:0,
            text:'<div class="select2_style">Select answer style: <span>Input Field</span></div>',
            title:'Select answer style: Input Field'
        },
        {
            id:1,
            text:'<div class="select2_style">Select answer style: <span>Select Field</span></div>',
            title:'Select answer style: Input Field'
        }
    ];
    var select_answer_style = [
        {
            id:0,
            text:'<div class="select2_style">Select answer style: <span>Select Field</span></div>',
            title:'Select answer style: Input Field'
        },
        {
            id:1,
            text:'<div class="select2_style">Select answer style: <span>Input Field</span></div>',
            title:'Select answer style: Input Field'
        }
    ];
    var year_display = [
        {
            id:0,
            text:'<div class="select2_style">Date format: <span>MM/DD/YYYY</span></div>',
            title:'Date format: MM/DD/YYYY'
        },
        {
            id:1,
            text:'<div class="select2_style">Date format: <span>100 years</span></div>',
            title:'Date format: 100 years'
        }
    ];
    var age_required = [
        {
            id:0,
            text:'<div class="select2_style">Set minimum required age: <span>18</span></div>',
            title:'Set minimum required age: 18'
        },
        {
            id:1,
            text:'<div class="select2_style">Set minimum required age: <span>26</span></div>',
            title:'Set minimum required age: 26'
        }
    ];
    var button_url = [
        {
            id:0,
            text:'<div class="select2_style">What should it link to?</div>',
            title:'What should it link to?'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">What should it link to?</span><span>Another URL</span></div>',
            title:'What should it link to? Another URL'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">What should it link to?</span><span>Next Step</span></div>',
            title:'What should it link to? Next Step'
        }
    ];

    $('.select2js__select-answer').select2({
        width: '100%',
        data:select_answer,
        minimumResultsForSearch: -1,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: $('.select2js__select-answer_parent')
    });

    $('.select2js__select-answer_style').select2({
        width: '100%',
        data:select_answer_style,
        minimumResultsForSearch: -1,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: $('.select2js__select-answer_parent_style')
    });

    $('.select2js__year-display').select2({
        width: '100%',
        data:year_display,
        minimumResultsForSearch: -1,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: $('.select2js__year-display_parent')
    }).on('change',function () {
        if ($(this).val() == 1) {
            $('.select2js__age-required_parent').show();
        }else {
            $('.select2js__age-required_parent').hide();
        }
    });

    $('.select2js__age-required').select2({
        width: '100%',
        data:age_required,
        minimumResultsForSearch: -1,
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: $('.select2js__age-required_parent')
    });

    $('#question-select').select2({
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.standard-question-option-parent')
    }).on('change',function () {
        obj_data.question_transition = 0;
        if($(this).val() == 1) {
            $('.question-transition').hide();
            $('.question-global').hide();
            $('.question-pre-made').hide();
            $('.question-standard').show();
            history.replaceState(null,null, window.location.pathname + "#standard-question");
        }else if($(this).val() ==  2){
            if ($('.question-option__list .question-option__item').length > 0)  {
                $('.question-global .placeholder').hide();
            }
            $('.question-transition').hide();
            $('.question-standard').hide();
            $('.question-pre-made').hide();
            $('.question-global').show();
            history.replaceState(null,null, window.location.pathname + "#global-question");
        }else if($(this).val() == 3) {
            $('.question-transition').hide();
            $('.question-standard').hide();
            $('.question-global').hide();
            $('.question-pre-made').show();
            history.replaceState(null,null, window.location.pathname + "#pre-made-question");
        }else if($(this).val() == 4) {
            if ($('.question-option__list .question-option__item').length > 0)  {
                $('.question-transition .placeholder').hide();
            }
            $('.question-standard').hide();
            $('.question-global').hide();
            $('.question-pre-made').hide();
            $('.question-transition').show();
            history.replaceState(null,null, window.location.pathname + "#transitions");
            obj_data.question_transition = 1;
        }
    }).on('select2:openning', function() {
        /*jQuery('.standard-question-option-parent .select2-selection__rendered').css('opacity', '0');*/
    }).on('select2:open', function() {
        jQuery('.standard-question-option-parent').find('.select2-dropdown').addClass('animated slideInDown').removeClass('slideInUp');
        /*jQuery('.standard-question-option-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.standard-question-option-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.standard-question-option-parent .select2-dropdown').hide();
        jQuery('.standard-question-option-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.standard-question-option-parent .select2-selection__rendered').hide();*/
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.standard-question-option-parent').find('.select2-dropdown').removeClass('slideInDown').addClass('slideInUp');
            setTimeout(function () {
                jQuery('#question-select').select2("close");
            }, 200);
            /*e.preventDefault();
            selectclosing = true;
            jQuery('.standard-question-option-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#question-select').select2("close");
            }, 200);*/
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        /*jQuery('.standard-question-option-parent .select2-selection__rendered').show();*/
        /*jQuery('.standard-question-option-parent .select2-results__options').css('pointer-events', 'none');*/
    });


    /* $('.standard-question-option').select2({
         minimumResultsForSearch: -1,
         width: '100%', // need to override the changed default
         dropdownParent: $('.standard-question-option-parent')
     }).on('change', function () {
         obj_data.question_transition = 0;
         if($(this).val() == 1) {
             $('.question-transition').hide();
             $('.question-global').hide();
             $('.question-pre-made').hide();
             $('.question-standard').show();
         }else if($(this).val() ==  2){
             if ($('.question-option__list .question-option__item').length > 0)  {
                 $('.question-global .placeholder').hide();
             }
             $('.question-transition').hide();
             $('.question-standard').hide();
             $('.question-pre-made').hide();
             $('.question-global').show();
         }else if($(this).val() == 3) {
             $('.question-transition').hide();
             $('.question-standard').hide();
             $('.question-global').hide();
             $('.question-pre-made').show();
         }else if($(this).val() == 4) {
             if ($('.question-option__list .question-option__item').length > 0)  {
                 $('.question-transition .placeholder').hide();
             }
             $('.question-standard').hide();
             $('.question-global').hide();
             $('.question-pre-made').hide();
             $('.question-transition').show();
             obj_data.question_transition = 1;
         }
     });*/

    var question_input_type = [
        {
            id:1,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-building"></i></span><span class="text">Address</span></div>',
            title:'Address'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-birthday"></i></span><span class="text">Birthday</span></div>',
            title:'Birthday'
        },
        {
            id:3,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-message"></i></span><span class="text">CTA Message</span></div>',
            title:'CTA Message'
        },
        {
            id:4,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-calander"></i></span><span class="text">Date Picker</span></div>',
            title:'Date Picker'
        },
        {
            id:5,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-oc799PIto"></i></span><span class="text">Drop Down</span></div>',
            title:'Drop Down'
        },
        {
            id:6,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hidden"></i></span><span class="text">Hidden Field</span></div>',
            title:'Hidden Field'
        },
        {
            id:7,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hamburger"></i></span><span class="text">menu</span></div>',
            title:'menu'
        },
        {
            id:8,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-hash"></i></span><span class="text">number</span></div>',
            title:'number'
        },
        {
            id:9,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-expand"></i></span><span class="text">slider</span></div>',
            title:'slider'
        },
        {
            id:10,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-select-text"></i></span><span class="text">Text Field</span></div>',
            title:'Text Field'
        },
        {
            id:11,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-time"></i></span><span class="text">time picker</span></div>',
            title:'time picker'
        },
        {
            id:12,
            text:'<div class="select2_style"><span class="icon-holder"><i class="ico-location"></i></span><span class="text">zip code</span></div>',
            title:'zip code'
        }
    ];

    $('.select2js__question-type').select2({
        data: question_input_type,
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__question-type-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('select2:openning', function() {
        jQuery('.select2js__question-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__question-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__question-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__question-type-parent .select2-dropdown').hide();
        jQuery('.select2js__question-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__question-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2js__question-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('.select2js__question-type').find(':selected').index();
                var defaultHeight = 40;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__question-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2js__question-type').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2js__question-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2js__question-type-parent .select2-selection__rendered').show();
        jQuery('.select2js__question-type-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2js__transition-type').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__transition-type-parent'),
    }).on('select2:openning', function() {
        jQuery('.select2js__transition-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__transition-type-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__transition-type-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__transition-type-parent .select2-dropdown').hide();
        jQuery('.select2js__transition-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__transition-type-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2js__transition-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('.select2js__transition-type').find(':selected').index();
                var defaultHeight = 36;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__transition-type-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2js__transition-type').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2js__transition-type-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2js__transition-type-parent .select2-selection__rendered').show();
        jQuery('.select2js__transition-type-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.select2js__sortby-questions').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__sortby-questions-parent')
    });

    $('.select2js__sortby-transition').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__sortby-transition-parent')
    });

    /*$('.select2js__folder').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__folder-parent')
    });*/

    jQuery('#fb-select-url').select2({
        data: button_url,
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
        dropdownParent: jQuery(".fb-select2-group_url"),
    }).on('change', function() {
        if($(this).val() == 2) {
            $(this).parents('.cta-select').nextAll().slideUp()
        }else {
            $(this).parents('.cta-select').nextAll().slideDown()
        }
    }).on('select2:openning', function() {
        jQuery('.fb-select2-group_url .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-select2-group_url .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-select2-group_url .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-select2-group_url .select2-dropdown').hide();
        jQuery('.fb-select2-group_url .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-select2-group_url .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-select2-group_url .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#fb-select-url').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-select2-group_url .select2-selection__rendered').show();
        jQuery('.fb-select2-group_url .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#fb-select-url option:eq(1)').val());

    $('.fb-select').each(function() {
        var placeholder = '';
        var dropdownParent = $(document.body);
        if ($(this).parents('.fb-select-wrap').length !== 0)
            dropdownParent = $(this).parents('.fb-select-wrap');
        if ($(this).parents('.fb-select-detail-page').length !== 0)
            dropdownParent = $(this).parents('.fb-select-detail-page');
        $(this).select2({
            width:'100%',
            minimumResultsForSearch: -1,
            dropdownParent: dropdownParent
        }).on("select2:open", function() {
            $(".select2-search__field").attr("placeholder", "Search....");
        });
    });

    jQuery('.fb-select_unit').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".fb-select_unit-wrap"),
    }).on('select2:openning', function() {
        jQuery('.fb-select_unit-wrap .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-select_unit-wrap .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-select_unit-wrap .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-select_unit-wrap .select2-dropdown').hide();
        jQuery('.fb-select_unit-wrap .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-select_unit-wrap .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-select_unit-wrap .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.fb-select_unit').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-select_unit-wrap .select2-selection__rendered').show();
        jQuery('.fb-select_unit-wrap .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('.fb-select_unit-1').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".fb-select_unit-wrap-1"),
    }).on('select2:openning', function() {
        jQuery('.fb-select_unit-wrap-1 .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-select_unit-wrap-1 .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-select_unit-wrap-1 .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-select_unit-wrap-1 .select2-dropdown').hide();
        jQuery('.fb-select_unit-wrap-1 .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-select_unit-wrap-1 .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-select_unit-wrap-1 .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.fb-select_unit-1').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-select_unit-wrap-1 .select2-selection__rendered').show();
        jQuery('.fb-select_unit-wrap-1 .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('.fb-select_by').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".fb-select_by-wrap"),
    }).on('select2:openning', function() {
        jQuery('.fb-select_by-wrap .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-select_by-wrap .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-select_by-wrap .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-select_by-wrap .select2-dropdown').hide();
        jQuery('.fb-select_by-wrap .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-select_by-wrap .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-select_by-wrap .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.fb-select_by').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-select_by-wrap .select2-selection__rendered').show();
        jQuery('.fb-select_by-wrap .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('.fb-select_by-1').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".fb-select_by-wrap-1"),
    }).on('select2:openning', function() {
        jQuery('.fb-select_by-wrap-1 .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-select_by-wrap-1 .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-select_by-wrap-1 .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-select_by-wrap-1 .select2-dropdown').hide();
        jQuery('.fb-select_by-wrap-1 .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-select_by-wrap-1 .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-select_by-wrap-1 .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.fb-select_by-1').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-select_by-wrap-1 .select2-selection__rendered').show();
        jQuery('.fb-select_by-wrap-1 .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('.fb-select_start').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".fb-select_start-wrap"),
    }).on('select2:openning', function() {
        jQuery('.fb-select_start-wrap .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-select_start-wrap .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-select_start-wrap .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-select_start-wrap .select2-dropdown').hide();
        jQuery('.fb-select_start-wrap .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-select_start-wrap .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-select_start-wrap .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.fb-select_start').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-select_start-wrap .select2-selection__rendered').show();
        jQuery('.fb-select_start-wrap .select2-results__options').css('pointer-events', 'none');
    });

    jQuery('.fb-select_start-1').select2({
        width:'100%',
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(".fb-select_start-wrap-1"),
    }).on('select2:openning', function() {
        jQuery('.fb-select_start-wrap-1 .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-select_start-wrap-1 .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-select_start-wrap-1 .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-select_start-wrap-1 .select2-dropdown').hide();
        jQuery('.fb-select_start-wrap-1 .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-select_start-wrap-1 .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-select_start-wrap-1 .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.fb-select_start-1').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-select_start-wrap-1 .select2-selection__rendered').show();
        jQuery('.fb-select_start-wrap-1 .select2-results__options').css('pointer-events', 'none');
    });



    function initializeSelect2(selectElementObj , selectWrap) {

        jQuery('.' + selectElementObj).select2({
            width:'100%',
            minimumResultsForSearch: -1,
            dropdownParent: jQuery("." + selectWrap),
        }).on('select2:openning', function(event) {
            // event.preventDefault();
            initializeSelect2(selectElementObj , selectWrap);
            jQuery('.' + selectWrap +'  .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function(event) {
            // event.preventDefault();
            jQuery('.' + selectWrap +' .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.' + selectWrap +' .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.' + selectWrap +' .select2-dropdown').hide();
            jQuery('.' + selectWrap +' .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.' + selectWrap +' .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            initializeSelect2(selectElementObj , selectWrap);
            if(!selectclosing) {
                e.preventDefault();
                selectclosing = true;
                jQuery('.' + selectWrap +' .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.' + selectElementObj).select2("close");
                }, 200);
            } else {
                selectclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.' + selectWrap +' .select2-selection__rendered').show();
            jQuery('.' + selectWrap +' .select2-results__options').css('pointer-events', 'none');
        });

    }


    /* $('body').on('shown.bs.modal', '.modal', function() {
         $(this).find('select').each(function() {
             var dropdownParent = $(document.body);
             if ($(this).parents('.fb-select-wrap').length !== 0)
                 dropdownParent = $(this).parents('.fb-select-wrap');
             $(this).select2({
                 dropdownParent: dropdownParent
             });
         });
     });*/

    /**
     *  Color Picker jquery
     * */

    $('.fb-color-picker').ColorPicker({
        color: "#FFFFFF",
        onShow: function (colpkr) {
            $(colpkr).fadeIn(100);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(100);
            return false;
        },
        onChange: function (hsb, hex, rgb , el) {
            $(el).css('backgroundColor', '#' + hex);
        }
    });





    $('.pop-create-question').click(function () {
        $('#manage-question-pop').modal('hide');
        $('#create-question-pop').modal('show');
    });

    $('.pop-transition-question').click(function () {
        $('#manage-transition-pop').modal('hide');
        $('#create-transition-pop').modal('show');
    });

    $('#manage-question-pop .action_nav .del').click(function () {
        $('#manage-question-pop').modal('hide');
        $('#clone-question-pop').modal('hide');
        $('#confirmation-delete-pop').modal('show');
    });
    $('#manage-transition-pop .action_nav .del').click(function () {
        $('#manage-transition-pop').modal('hide');
        $('#clone-transition-pop').modal('hide');
        $('#confirmation-delete-pop').modal('show');
    });



    $('.pop-create-funnel').click(function () {
        $('#global-setting-placeholder-pop').modal('hide');
        $('#global-setting-funnel-list-pop').modal('show');
    });

    $('#manage-question-pop .action_nav .clone').click(function () {
        $('#manage-question-pop').modal('hide');
        $('#clone-question-pop').modal('show');
        $('#clone-question-pop').find('#question_name_clone').val($(this).parents('.lp-table__list').find('.lp-table__item').first().text());
    });

    $('#manage-transition-pop .action_nav .clone').click(function () {
        $('#manage-transition-pop').modal('hide');
        $('#clone-transition-pop').modal('show');
        $('#clone-transition-pop').find('#transition_name_clone').val($(this).parents('.lp-table__list').find('.lp-table__item').first().text());
    });

    $('.sorting__item').click(function () {
        $('.sorting__item').removeClass('active');
        $(this).addClass('active');
    });

    $(".lp-table.sorting").mCustomScrollbar({
        mouseWheel:{ scrollAmount: 80}
    });

    /*$(".scroll-holder").mCustomScrollbar({
        mouseWheel:{ scrollAmount: 80},
        advanced:{
            updateOnContentResize:true,
            setHeight: false
        },
    });*/

    $(document).on("click","#clone-url",function (){
        var _self = jQuery(this);
        var $temp = $("<input>");
        $("body").append($temp);
        var getLink =  _self.parents('.tk-bar-field').find('.fb-form__copy-text').val().trim();
        var getText = _self.parents('.tk-bar-field').find('.link-prefix').html().trim();
        $temp.val(getText + getLink).select();
        var gettextitem = document.execCommand("copy");
        $temp.remove();
    });

    $(document).on("click",".tk-field__reset",function (e){
        e.preventDefault();
        jQuery(this).siblings('.fb-form__copy-text').val('thank-you');
    });


    $(document).on("click",".show_nav",function (){
        $(".show_nav").show();
        $(".action_nav").hide();
        $(this).hide().next(".action_nav").show();
    });
    /**
     *  Menu Modal: Add More Option
     *
     * */

    $('.organize-group__list').sortable({
        placeholder: "fb-options__highlight",
        /*revert: true,
        revertDuration: 100,*/
        scroll: true,
        axis: "y",
        handle: ".organize-group__action",
        start:function(){
            $('.fb-options__highlight').text('Drop Your Element Here');
        }
    });

    $(document).on('click' , '.lp-btn_add-option', function(e){
        e.preventDefault();
        var cloned = $(this).parents('.fb-options').find('.fb-options__list:last-child').clone();
        if (cloned.find('input').val().length != 0) {
            cloned.find('input').val('').end().hide().appendTo($(this).parents('.fb-options').find('.fb-options__clone')).slideDown(function () {cloned.find('input').focus()});
        }else {
            $(this).parents('.fb-options').find('.fb-options__list:last-child input').focus();
        }
    });

    $(document).on('keypress' , '.fb-options__clone input', function(e){
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if(keycode == '13'){
            if($(this).val().length != '') {
                $('.lp-btn_add-option').trigger('click');
            }
        }

    });

    var html_menu_group ="<div class=\"fb-options__group-clone\">\n" +
        "                            <div class=\"grouping-label\">Group 1</div>\n" +
        "                            <div class=\"group-head\">\n" +
        "                                <div class=\"fb-form__group\">\n" +
        "                                    <input type=\"text\" class=\"form-control fb-form-control\">\n" +
        "                                    <span class=\"tag-box\">\n" +
        "                                        <i class=\"fas fa-folder-open\"></i>\n" +
        "                                </span>\n" +
        "                                </div>\n" +
        "                                <div class=\"fb-options__col\">\n" +
        "                                    <a href=\"#\" class=\"fb-options__delete remove-group\">\n" +
        "                                        <i class=\"ico ico-cross\"></i>\n" +
        "                                    </a>\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                            <div class=\"fb-options__clone\">\n" +
        "                                <div class=\"fb-options__list\">\n" +
        "                                    <div class=\"fb-options__col fb-options__col_field\">\n" +
        "                                        <input type=\"text\" class=\"form-control fb-form-control\">\n" +
        "                                    </div>\n" +
        "                                    <div class=\"fb-options__col fb-options__col_handler\">\n" +
        "                                        <span class=\"tag-box tag-box_move tag-box_lg\">\n" +
        "                                            <i class=\"ico ico-dragging\"></i>\n" +
        "                                        </span>\n" +
        "                                    </div>\n" +
        "                                    <div class=\"fb-options__col\">\n" +
        "                                        <a href=\"#\" class=\"fb-options__delete\">\n" +
        "                                            <span class=\"tag-box tag-box_lg\">\n" +
        "                                                <i class=\"ico ico-cross\"></i>\n" +
        "                                            </span>\n" +
        "                                        </a>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                            <div class=\"fb-options__add-more\">\n" +
        "                                <a href=\"#\" class=\"lp-btn lp-btn_add-option\">\n" +
        "                                    <span class=\"lp-btn__icon\">\n" +
        "                                        <i class=\"ico ico-plus\"></i>\n" +
        "                                    </span>\n" +
        "                                    Add New Option\n" +
        "                                </a>\n" +
        "                            </div>\n" +
        "                        </div>";
    var html_drop_down_group ="<div class=\"fb-options__group-clone\">\n" +
        "                            <div class=\"grouping-label\">Group 1</div>\n" +
        "                            <div class=\"group-head\">\n" +
        "                                <div class=\"fb-form__group\">\n" +
        "                                    <input type=\"text\" class=\"form-control fb-form-control\">\n" +
        "                                    <span class=\"tag-box\">\n" +
        "                                        <i class=\"fas fa-folder-open\"></i>\n" +
        "                                </span>\n" +
        "                                </div>\n" +
        "                                <div class=\"fb-options__col\">\n" +
        "                                    <a href=\"#\" class=\"fb-options__delete remove-group\">\n" +
        "                                        <i class=\"ico ico-cross\"></i>\n" +
        "                                    </a>\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                            <div class=\"fb-options__clone\">\n" +
        "                                 <textarea name=\"\" id=\"\" class=\"form-control fb-textarea fb-textarea_option\" placeholder=\"Type in or paste your menu entries&nbsp;here (separated&nbsp;by&nbsp;line&nbsp;break)\"></textarea>\n"+
        "                            </div>\n" +
        "                        </div>";
    $('.lp-btn_add-option_group').click(function(e){
        e.preventDefault();
        if($(this).hasClass('lp-btn_drop-down')) {
            $(this).parents().find('.fb-modal__row_creat-group').before(html_drop_down_group);
        }else {
            $(this).parents().find('.fb-modal__row_creat-group').before(html_menu_group);
        }
        group_label();
    });

    $(document).on('click' , '.fb-options__delete', function(e){
        e.preventDefault();
        if($(this).parents('.fb-options').find('.fb-options__list').length > 1){
            $(this).parents('.fb-options__list').slideUp(function () {
                $(this).remove();
            });
        }
        if($(this).hasClass('remove-group')) {
            $(this).parents('.group-head').parent('.fb-options__group-clone').remove();
            group_label();
        }

    });




    $('#create-group').change(function () {
        if($(this).is(':checked')){
            $('.normal-option').slideUp();
            $('.group-option').slideDown();
        } else {
            $('.group-option').slideUp();
            $('.normal-option').slideDown();
        }
    });

    /**
     *  Menu Modal: Drag and Drop Jquery
     * */

    $('.fb-options__clone').sortable({
        placeholder: "fb-options__highlight",
        /*revert: true,
        revertDuration: 100,*/
        scroll: true,
        axis: "y",
        handle: ".fb-options__col_handler",
        start:function(){
            $('.fb-options__highlight').text('Drop Your Element Here');
        }
    });

    $(".scroll").mCustomScrollbar({
        mouseWheel:{ scrollAmount: 300 }
    });

    /**
     *  Menu Modal: Drag and Drop Jquery
     * */

    /**$(".gl-funnel__body").mCustomScrollbar({
        mouseWheel:{ scrollAmount: 80}
    });**/

    // var body_height = parseInt($(window).outerHeight() - 215);
    // $('.fb-modal__body_scroll').css({'max-height': body_height+'px'});
    // $('.fb-modal').find('.mCSB_scrollTools').css({'height': body_height - 40 +'px', 'margin-top':'20px'});
    // $(".fb-modal__body_scroll").mCustomScrollbar({
    //     mouseWheel:{ scrollAmount: 300 },
    //     scrollButtons:{ enable: true }
    // });
    // $(window).resize(function () {
    //     $('.fb-modal__body_scroll').css({'max-height': parseInt($(window).outerHeight() - 215)+'px'});
    // });




    $('.fb-enable-setting').on('change' , function(){
        $('.disabled-option').find('.fb-modal__option').toggleClass('fb-modal__option_disabled');
        $('.disabled-option').find('.fb-toggle').toggleClass('fb-toggle_disabled');
    });
    $('#auto-progress').on('change' , function(){
        $('.panel-aside__body').find('.form-group.cta-button').toggleClass('disabled');
        if ($(this).is(':checked')) {
            $('.el-tooltip-disabled').tooltipster('enable');
        }else {
            $('.el-tooltip-disabled').tooltipster('disable');
        }
    });

    $('#progress-status').on('change', function () {
        if ($(this).is(':checked')) {
            $('.el-tooltip-disabled').tooltipster('disable');
            $('#auto-progress').parents('div.fb-toggle').addClass('fb-toggle_disabled');
            $('.panel-aside__body').find('.form-group.cta-button').removeClass('disabled');
        }else {
            $('.el-tooltip-disabled').tooltipster('enable');
            $('#auto-progress').parents('div.fb-toggle').removeClass('fb-toggle_disabled');
            $('.panel-aside__body').find('.form-group.cta-button').addClass('disabled');
        }
    });


    /**
     *  Field label Toggle
     * */


    $('.fb-field-label').on('change' , function(){
        var parent_selector = $(this).closest('.fb-modal__border-box_dropdown');
        if($(this).prop('checked'))
            parent_selector.find('.fb-modal__border-row_menu').slideDown(function () {
                parent_selector.find('.fb-froala__init').froalaEditor('events.focus', true);
            });
        else
            parent_selector.find('.fb-modal__border-row_menu').slideUp(function () {
                parent_selector.find('.fb-froala__init').froalaEditor('events.focus', false);
            });
    });

    $('.fb-field-label-inner').on('change' , function(){
        var parent_selector = $(this).closest('.fb-modal__border-box_dropdown');
        if($(this).prop('checked'))
            parent_selector.find('.fb-modal__border-row_menu-inner').slideDown();
        else
            parent_selector.find('.fb-modal__border-row_menu-inner').slideUp();
    });

    $('.fb-inner-dd-toggle').on('change' , function(){
        var parent_selector = $(this).parents('.fb-modal__border-box_sub-dropdown');
        if($(this).prop('checked'))
            parent_selector.find('.fb-modal__border-row_sub-menu').slideDown();
        else
            parent_selector.find('.fb-modal__border-row_sub-menu').slideUp();
    });

    /**
     *  Slider modal: Segment
     * */

    $('.add-slider-range').click(function(e){
        e.preventDefault();
        var cloned = $(this).parents('.fb-tab__tab-pane').find('.slider-range-clone__item:first-child').clone();
        cloned.find('input').val('').end().hide().appendTo($(this).parents('.fb-tab__tab-pane').find('.slider-range-clone')).slideDown();
        $(this).parents('.panel-aside__body').find('select').each(function() {
            var dropdownParent = $(document.body);
            if ($(this).parents('.fb-select-wrap').length !== 0)
                dropdownParent = $(this).parents('.fb-select-wrap');
            $(this).select2({
                width:'100%',
                minimumResultsForSearch: -1,
                dropdownParent: dropdownParent
            });
        });
        $('.select2-container').next('.select2-container').remove();
        $(this).parents('.fb-tab__tab-pane').find('.question-mark_tooltip').tooltipster({delay:0,content:'Tooltip Content',multiple: true});
    });

    $(document).on('click' , '.slider-range-clone__del', function(){
        if($('.slider-range-clone__item').length > 1){
            $(this).parents('.slider-range-clone__item').slideUp(function () {
                $(this).remove();
            });
        }

    });


    /**
     *
     *   Contact: Add multiple form
     *
     * */


    $('#add-contact-form').click(function(e){
        e.preventDefault();
        var cloned = $(this).parents('.fb-contact').find('.fb-contact__item:first-child').clone();
        cloned.find('input').val('').end().hide().appendTo('.fb-contact__clone').slideDown();
        // $('.fb-select').select2();
        $(this).parents('.panel-aside__body').find('select').each(function() {
            var dropdownParent = $(document.body);
            if ($(this).parents('.fb-select-wrap').length !== 0)
                dropdownParent = $(this).parents('.fb-select-wrap');
            $(this).select2({
                width:'100%',
                minimumResultsForSearch: -1,
                dropdownParent: dropdownParent
            });
        });
        $('.select2-container').next('.select2-container').remove();
        contact_form_label();
    });
    $(document).on('click' , '.fb-contact__delete', function(){
        if($('.fb-contact__item').length > 1){
            $(this).parents('.fb-contact__item').slideUp(function () {
                $(this).remove();
                contact_form_label();
            });

        }

    });
    function contact_form_label() {
        var increment = 1;
        $('.contact-from-label').each(function(){
            $(this).text('input '+increment);
            increment++;
        });
    }

    function group_label() {
        var increment = 1;
        $('.grouping-label').each(function(){
            $(this).text('Group '+increment);
            increment++;
        });
        if ($('.fb-options').find('.fb-options__group-clone').length > 1) {
            $('.lp-btn_add-option_organize').css('display','flex');
        }else {
            $('.lp-btn_add-option_organize').hide();
        }

        $('.fb-options__clone').sortable({
            placeholder: "fb-options__highlight",
            /*revert: true,
            revertDuration: 100,*/
            scroll: true,
            axis: "y",
            handle: ".fb-options__col_handler",
            start:function(){
                $('.fb-options__highlight').text('Drop Your Element Here');
            }
        });
    }

    /**
     *
     *   Contact Modal Window Sorting
     *
     * */

    $('.fb-contact__clone').sortable({
        placeholder: "fb-contact__highlight",
        /*revert: true,
        revertDuration: 100,*/
        scroll: true,
        axis: "y",
        handle: ".contact-col_handler",
        start:function(){
            $('.fb-contact__highlight').text('Drop Your Element Here...');
        },
        stop: function() {
            contact_form_label();
        }
    });


    /**
     *
     * Funnel Builder: Froala Editor init
     *
     * */

    /*toolbarButtons:[ 'bold', 'italic','underline', 'fontSize' , 'fontFamily' , 'color', '|',  'paragraphFormat' ,'align', 'formatOL', 'formatUL' , '-',
        'strikeThrough', 'subscript', 'superscript', '|', 'inlineClass', 'inlineStyle', 'paragraphStyle', 'lineHeight', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote','|','insertLink', 'insertImage', 'insertVideo', 'embedly', 'insertFile', 'insertTable', '-',
        'emoticons', 'fontAwesome', 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'getPDF', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'
    ]*/
    var fontSize = [];
    for(var i = 8 ; i <=72 ; i++){
        fontSize.push(i);
    }
    var font_object={"ABeeZee": 'ABeeZee',
        "Abel": 'Abel',
        "Abhaya Libre": 'Abhaya Libre',
        "Abril Fatface": 'Abril Fatface',
        "Aclonica": 'Aclonica',
        "Acme": 'Acme',
        "Actor": 'Actor',
        "Adamina": 'Adamina',
        "Advent Pro": 'Advent Pro',
        "Aguafina Script": 'Aguafina Script',
        "Akronim": 'Akronim',
        "Aladin": 'Aladin',
        "Aldrich": 'Aldrich',
        "Alef": 'Alef',
        "Alegreya": 'Alegreya',
        "Alegreya SC": 'Alegreya SC',
        "Alegreya Sans": 'Alegreya Sans',
        "Alegreya Sans SC": 'Alegreya Sans SC',
        "Aleo": 'Aleo',
        "Alex Brush": 'Alex Brush',
        "Alfa Slab One": 'Alfa Slab One',
        "Alice": 'Alice',
        "Alike": 'Alike',
        "Alike Angular": 'Alike Angular',
        "Allan": 'Allan',
        "Allerta": 'Allerta',
        "Allerta Stencil": 'Allerta Stencil',
        "Allura": 'Allura',
        "Almendra": 'Almendra',
        "Almendra Display": 'Almendra Display',
        "Almendra SC": 'Almendra SC',
        "Amarante": 'Amarante',
        "Amaranth": 'Amaranth',
        "Amatic SC": 'Amatic SC',
        "Amethysta": 'Amethysta',
        "Amiko": 'Amiko',
        "Amiri": 'Amiri',
        "Amita": 'Amita',
        "Anaheim": 'Anaheim',
        "Andada": 'Andada',
        "Andika": 'Andika',
        "Angkor": 'Angkor',
        "Annie Use Your Telescope": 'Annie Use Your Telescope',
        "Anonymous Pro": 'Anonymous Pro',
        "Antic": 'Antic',
        "Antic Didone": 'Antic Didone',
        "Antic Slab": 'Antic Slab',
        "Anton": 'Anton',
        "Arapey": 'Arapey',
        "Arbutus": 'Arbutus',
        "Arbutus Slab": 'Arbutus Slab',
        "Architects Daughter": 'Architects Daughter',
        "Archivo": 'Archivo',
        "Archivo Black": 'Archivo Black',
        "Archivo Narrow": 'Archivo Narrow',
        "Aref Ruqaa": 'Aref Ruqaa',
        "Arima Madurai": 'Arima Madurai',
        "Arimo": 'Arimo',
        "Arizonia": 'Arizonia',
        "Armata": 'Armata',
        "Arsenal": 'Arsenal',
        "Artifika": 'Artifika',
        "Arvo": 'Arvo',
        "Arya": 'Arya',
        "Asap": 'Asap',
        "Asap Condensed": 'Asap Condensed',
        "Asar": 'Asar',
        "Asset": 'Asset',
        "Assistant": 'Assistant',
        "Astloch": 'Astloch',
        "Asul": 'Asul',
        "Athiti": 'Athiti',
        "Atma": 'Atma',
        "Atomic Age": 'Atomic Age',
        "Aubrey": 'Aubrey',
        "Audiowide": 'Audiowide',
        "Autour One": 'Autour One',
        "Average": 'Average',
        "Average Sans": 'Average Sans',
        "Averia Gruesa Libre": 'Averia Gruesa Libre',
        "Averia Libre": 'Averia Libre',
        "Averia Sans Libre": 'Averia Sans Libre',
        "Averia Serif Libre": 'Averia Serif Libre',
        "B612": 'B612',
        "B612 Mono": 'B612 Mono',
        "Bad Script": 'Bad Script',
        "Bahiana": 'Bahiana',
        "Bai Jamjuree": 'Bai Jamjuree',
        "Baloo": 'Baloo',
        "Baloo Bhai": 'Baloo Bhai',
        "Baloo Bhaijaan": 'Baloo Bhaijaan',
        "Baloo Bhaina": 'Baloo Bhaina',
        "Baloo Chettan": 'Baloo Chettan',
        "Baloo Da": 'Baloo Da',
        "Baloo Paaji": 'Baloo Paaji',
        "Baloo Tamma": 'Baloo Tamma',
        "Baloo Tammudu": 'Baloo Tammudu',
        "Baloo Thambi": 'Baloo Thambi',
        "Balthazar": 'Balthazar',
        "Bangers": 'Bangers',
        "Barlow": 'Barlow',
        "Barlow Condensed": 'Barlow Condensed',
        "Barlow Semi Condensed": 'Barlow Semi Condensed',
        "Barrio": 'Barrio',
        "Basic": 'Basic',
        "Battambang": 'Battambang',
        "Baumans": 'Baumans',
        "Bayon": 'Bayon',
        "Belgrano": 'Belgrano',
        "Bellefair": 'Bellefair',
        "Belleza": 'Belleza',
        "BenchNine": 'BenchNine',
        "Bentham": 'Bentham',
        "Berkshire Swash": 'Berkshire Swash',
        "Bevan": 'Bevan',
        "Bigelow Rules": 'Bigelow Rules',
        "Bigshot One": 'Bigshot One',
        "Bilbo": 'Bilbo',
        "Bilbo Swash Caps": 'Bilbo Swash Caps',
        "BioRhyme": 'BioRhyme',
        "BioRhyme Expanded": 'BioRhyme Expanded',
        "Biryani": 'Biryani',
        "Bitter": 'Bitter',
        "Black And White Picture": 'Black And White Picture',
        "Black Han Sans": 'Black Han Sans',
        "Black Ops One": 'Black Ops One',
        "Bokor": 'Bokor',
        "Bonbon": 'Bonbon',
        "Boogaloo": 'Boogaloo',
        "Bowlby One": 'Bowlby One',
        "Bowlby One SC": 'Bowlby One SC',
        "Brawler": 'Brawler',
        "Bree Serif": 'Bree Serif',
        "Bubblegum Sans": 'Bubblegum Sans',
        "Bubbler One": 'Bubbler One',
        "Buda": 'Buda',
        "Buenard": 'Buenard',
        "Bungee": 'Bungee',
        "Bungee Hairline": 'Bungee Hairline',
        "Bungee Inline": 'Bungee Inline',
        "Bungee Outline": 'Bungee Outline',
        "Bungee Shade": 'Bungee Shade',
        "Butcherman": 'Butcherman',
        "Butterfly Kids": 'Butterfly Kids',
        "Cabin": 'Cabin',
        "Cabin Condensed": 'Cabin Condensed',
        "Cabin Sketch": 'Cabin Sketch',
        "Caesar Dressing": 'Caesar Dressing',
        "Cagliostro": 'Cagliostro',
        "Cairo": 'Cairo',
        "Calligraffitti": 'Calligraffitti',
        "Cambay": 'Cambay',
        "Cambo": 'Cambo',
        "Candal": 'Candal',
        "Cantarell": 'Cantarell',
        "Cantata One": 'Cantata One',
        "Cantora One": 'Cantora One',
        "Capriola": 'Capriola',
        "Cardo": 'Cardo',
        "Carme": 'Carme',
        "Carrois Gothic": 'Carrois Gothic',
        "Carrois Gothic SC": 'Carrois Gothic SC',
        "Carter One": 'Carter One',
        "Catamaran": 'Catamaran',
        "Caudex": 'Caudex',
        "Caveat": 'Caveat',
        "Caveat Brush": 'Caveat Brush',
        "Cedarville Cursive": 'Cedarville Cursive',
        "Ceviche One": 'Ceviche One',
        "Chakra Petch": 'Chakra Petch',
        "Changa": 'Changa',
        "Changa One": 'Changa One',
        "Chango": 'Chango',
        "Charm": 'Charm',
        "Charmonman": 'Charmonman',
        "Chathura": 'Chathura',
        "Chau Philomene One": 'Chau Philomene One',
        "Chela One": 'Chela One',
        "Chelsea Market": 'Chelsea Market',
        "Chenla": 'Chenla',
        "Cherry Cream Soda": 'Cherry Cream Soda',
        "Cherry Swash": 'Cherry Swash',
        "Chewy": 'Chewy',
        "Chicle": 'Chicle',
        "Chivo": 'Chivo',
        "Chonburi": 'Chonburi',
        "Cinzel": 'Cinzel',
        "Cinzel Decorative": 'Cinzel Decorative',
        "Clicker Script": 'Clicker Script',
        "Coda": 'Coda',
        "Coda Caption": 'Coda Caption',
        "Codystar": 'Codystar',
        "Coiny": 'Coiny',
        "Combo": 'Combo',
        "Comfortaa": 'Comfortaa',
        "Coming Soon": 'Coming Soon',
        "Concert One": 'Concert One',
        "Condiment": 'Condiment',
        "Content": 'Content',
        "Contrail One": 'Contrail One',
        "Convergence": 'Convergence',
        "Cookie": 'Cookie',
        "Copse": 'Copse',
        "Corben": 'Corben',
        "Cormorant": 'Cormorant',
        "Cormorant Garamond": 'Cormorant Garamond',
        "Cormorant Infant": 'Cormorant Infant',
        "Cormorant SC": 'Cormorant SC',
        "Cormorant Unicase": 'Cormorant Unicase',
        "Cormorant Upright": 'Cormorant Upright',
        "Courgette": 'Courgette',
        "Cousine": 'Cousine',
        "Coustard": 'Coustard',
        "Covered By Your Grace": 'Covered By Your Grace',
        "Crafty Girls": 'Crafty Girls',
        "Creepster": 'Creepster',
        "Crete Round": 'Crete Round',
        "Crimson Text": 'Crimson Text',
        "Croissant One": 'Croissant One',
        "Crushed": 'Crushed',
        "Cuprum": 'Cuprum',
        "Cute Font": 'Cute Font',
        "Cutive": 'Cutive',
        "Cutive Mono": 'Cutive Mono',
        "Damion": 'Damion',
        "Dancing Script": 'Dancing Script',
        "Dangrek": 'Dangrek',
        "David Libre": 'David Libre',
        "Dawning of a New Day": 'Dawning of a New Day',
        "Days One": 'Days One',
        "Dekko": 'Dekko',
        "Delius": 'Delius',
        "Delius Swash Caps": 'Delius Swash Caps',
        "Delius Unicase": 'Delius Unicase',
        "Della Respira": 'Della Respira',
        "Denk One": 'Denk One',
        "Devonshire": 'Devonshire',
        "Dhurjati": 'Dhurjati',
        "Didact Gothic": 'Didact Gothic',
        "Diplomata": 'Diplomata',
        "Diplomata SC": 'Diplomata SC',
        "Do Hyeon": 'Do Hyeon',
        "Dokdo": 'Dokdo',
        "Domine": 'Domine',
        "Donegal One": 'Donegal One',
        "Doppio One": 'Doppio One',
        "Dorsa": 'Dorsa',
        "Dosis": 'Dosis',
        "Dr Sugiyama": 'Dr Sugiyama',
        "Duru Sans": 'Duru Sans',
        "Dynalight": 'Dynalight',
        "EB Garamond": 'EB Garamond',
        "Eagle Lake": 'Eagle Lake',
        "East Sea Dokdo": 'East Sea Dokdo',
        "Eater": 'Eater',
        "Economica": 'Economica',
        "Eczar": 'Eczar',
        "El Messiri": 'El Messiri',
        "Electrolize": 'Electrolize',
        "Elsie": 'Elsie',
        "Elsie Swash Caps": 'Elsie Swash Caps',
        "Emblema One": 'Emblema One',
        "Emilys Candy": 'Emilys Candy',
        "Encode Sans": 'Encode Sans',
        "Encode Sans Condensed": 'Encode Sans Condensed',
        "Encode Sans Expanded": 'Encode Sans Expanded',
        "Encode Sans Semi Condensed": 'Encode Sans Semi Condensed',
        "Encode Sans Semi Expanded": 'Encode Sans Semi Expanded',
        "Engagement": 'Engagement',
        "Englebert": 'Englebert',
        "Enriqueta": 'Enriqueta',
        "Erica One": 'Erica One',
        "Esteban": 'Esteban',
        "Euphoria Script": 'Euphoria Script',
        "Ewert": 'Ewert',
        "Exo": 'Exo',
        "Exo 2": 'Exo 2',
        "Expletus Sans": 'Expletus Sans',
        "Fahkwang": 'Fahkwang',
        "Fanwood Text": 'Fanwood Text',
        "Farsan": 'Farsan',
        "Fascinate": 'Fascinate',
        "Fascinate Inline": 'Fascinate Inline',
        "Faster One": 'Faster One',
        "Fasthand": 'Fasthand',
        "Fauna One": 'Fauna One',
        "Faustina": 'Faustina',
        "Federant": 'Federant',
        "Federo": 'Federo',
        "Felipa": 'Felipa',
        "Fenix": 'Fenix',
        "Finger Paint": 'Finger Paint',
        "Fira Mono": 'Fira Mono',
        "Fira Sans": 'Fira Sans',
        "Fira Sans Condensed": 'Fira Sans Condensed',
        "Fira Sans Extra Condensed": 'Fira Sans Extra Condensed',
        "Fjalla One": 'Fjalla One',
        "Fjord One": 'Fjord One',
        "Flamenco": 'Flamenco',
        "Flavors": 'Flavors',
        "Fondamento": 'Fondamento',
        "Fontdiner Swanky": 'Fontdiner Swanky',
        "Forum": 'Forum',
        "Francois One": 'Francois One',
        "Frank Ruhl Libre": 'Frank Ruhl Libre',
        "Freckle Face": 'Freckle Face',
        "Fredericka the Great": 'Fredericka the Great',
        "Fredoka One": 'Fredoka One',
        "Freehand": 'Freehand',
        "Fresca": 'Fresca',
        "Frijole": 'Frijole',
        "Fruktur": 'Fruktur',
        "Fugaz One": 'Fugaz One',
        "GFS Didot": 'GFS Didot',
        "GFS Neohellenic": 'GFS Neohellenic',
        "Gabriela": 'Gabriela',
        "Gaegu": 'Gaegu',
        "Gafata": 'Gafata',
        "Galada": 'Galada',
        "Galdeano": 'Galdeano',
        "Galindo": 'Galindo',
        "Gamja Flower": 'Gamja Flower',
        "Gentium Basic": 'Gentium Basic',
        "Gentium Book Basic": 'Gentium Book Basic',
        "Geo": 'Geo',
        "Geostar": 'Geostar',
        "Geostar Fill": 'Geostar Fill',
        "Germania One": 'Germania One',
        "Gidugu": 'Gidugu',
        "Gilda Display": 'Gilda Display',
        "Give You Glory": 'Give You Glory',
        "Glass Antiqua": 'Glass Antiqua',
        "Glegoo": 'Glegoo',
        "Gloria Hallelujah": 'Gloria Hallelujah',
        "Goblin One": 'Goblin One',
        "Gochi Hand": 'Gochi Hand',
        "Gorditas": 'Gorditas',
        "Gothic A1": 'Gothic A1',
        "Goudy Bookletter 1911": 'Goudy Bookletter 1911',
        "Graduate": 'Graduate',
        "Grand Hotel": 'Grand Hotel',
        "Gravitas One": 'Gravitas One',
        "Great Vibes": 'Great Vibes',
        "Griffy": 'Griffy',
        "Gruppo": 'Gruppo',
        "Gudea": 'Gudea',
        "Gugi": 'Gugi',
        "Gurajada": 'Gurajada',
        "Habibi": 'Habibi',
        "Halant": 'Halant',
        "Hammersmith One": 'Hammersmith One',
        "Hanalei": 'Hanalei',
        "Hanalei Fill": 'Hanalei Fill',
        "Handlee": 'Handlee',
        "Hanuman": 'Hanuman',
        "Happy Monkey": 'Happy Monkey',
        "Harmattan": 'Harmattan',
        "Headland One": 'Headland One',
        "Heebo": 'Heebo',
        "Henny Penny": 'Henny Penny',
        "Herr Von Muellerhoff": 'Herr Von Muellerhoff',
        "Hi Melody": 'Hi Melody',
        "Hind": 'Hind',
        "Hind Guntur": 'Hind Guntur',
        "Hind Madurai": 'Hind Madurai',
        "Hind Siliguri": 'Hind Siliguri',
        "Hind Vadodara": 'Hind Vadodara',
        "Holtwood One SC": 'Holtwood One SC',
        "Homemade Apple": 'Homemade Apple',
        "Homenaje": 'Homenaje',
        "IBM Plex Mono": 'IBM Plex Mono',
        "IBM Plex Sans": 'IBM Plex Sans',
        "IBM Plex Sans Condensed": 'IBM Plex Sans Condensed',
        "IBM Plex Serif": 'IBM Plex Serif',
        "IM Fell DW Pica": 'IM Fell DW Pica',
        "IM Fell DW Pica SC": 'IM Fell DW Pica SC',
        "IM Fell Double Pica": 'IM Fell Double Pica',
        "IM Fell Double Pica SC": 'IM Fell Double Pica SC',
        "IM Fell English": 'IM Fell English',
        "IM Fell English SC": 'IM Fell English SC',
        "IM Fell French Canon": 'IM Fell French Canon',
        "IM Fell French Canon SC": 'IM Fell French Canon SC',
        "IM Fell Great Primer": 'IM Fell Great Primer',
        "IM Fell Great Primer SC": 'IM Fell Great Primer SC',
        "Iceberg": 'Iceberg',
        "Iceland": 'Iceland',
        "Imprima": 'Imprima',
        "Inconsolata": 'Inconsolata',
        "Inder": 'Inder',
        "Indie Flower": 'Indie Flower',
        "Inika": 'Inika',
        "Inknut Antiqua": 'Inknut Antiqua',
        "Irish Grover": 'Irish Grover',
        "Istok Web": 'Istok Web',
        "Italiana": 'Italiana',
        "Italianno": 'Italianno',
        "Itim": 'Itim',
        "Jacques Francois": 'Jacques Francois',
        "Jacques Francois Shadow": 'Jacques Francois Shadow',
        "Jaldi": 'Jaldi',
        "Jim Nightshade": 'Jim Nightshade',
        "Jockey One": 'Jockey One',
        "Jolly Lodger": 'Jolly Lodger',
        "Jomhuria": 'Jomhuria',
        "Josefin Sans": 'Josefin Sans',
        "Josefin Slab": 'Josefin Slab',
        "Joti One": 'Joti One',
        "Jua": 'Jua',
        "Judson": 'Judson',
        "Julee": 'Julee',
        "Julius Sans One": 'Julius Sans One',
        "Junge": 'Junge',
        "Jura": 'Jura',
        "Just Another Hand": 'Just Another Hand',
        "Just Me Again Down Here": 'Just Me Again Down Here',
        "K2D": 'K2D',
        "Kadwa": 'Kadwa',
        "Kalam": 'Kalam',
        "Kameron": 'Kameron',
        "Kanit": 'Kanit',
        "Kantumruy": 'Kantumruy',
        "Karla": 'Karla',
        "Karma": 'Karma',
        "Katibeh": 'Katibeh',
        "Kaushan Script": 'Kaushan Script',
        "Kavivanar": 'Kavivanar',
        "Kavoon": 'Kavoon',
        "Kdam Thmor": 'Kdam Thmor',
        "Keania One": 'Keania One',
        "Kelly Slab": 'Kelly Slab',
        "Kenia": 'Kenia',
        "Khand": 'Khand',
        "Khmer": 'Khmer',
        "Khula": 'Khula',
        "Kirang Haerang": 'Kirang Haerang',
        "Kite One": 'Kite One',
        "Knewave": 'Knewave',
        "KoHo": 'KoHo',
        "Kodchasan": 'Kodchasan',
        "Kosugi": 'Kosugi',
        "Kosugi Maru": 'Kosugi Maru',
        "Kotta One": 'Kotta One',
        "Koulen": 'Koulen',
        "Kranky": 'Kranky',
        "Kreon": 'Kreon',
        "Kristi": 'Kristi',
        "Krona One": 'Krona One',
        "Krub": 'Krub',
        "Kumar One": 'Kumar One',
        "Kumar One Outline": 'Kumar One Outline',
        "Kurale": 'Kurale',
        "La Belle Aurore": 'La Belle Aurore',
        "Laila": 'Laila',
        "Lakki Reddy": 'Lakki Reddy',
        "Lalezar": 'Lalezar',
        "Lancelot": 'Lancelot',
        "Lateef": 'Lateef',
        "Lato": 'Lato',
        "League Script": 'League Script',
        "Leckerli One": 'Leckerli One',
        "Ledger": 'Ledger',
        "Lekton": 'Lekton',
        "Lemon": 'Lemon',
        "Lemonada": 'Lemonada',
        "Libre Barcode 39": 'Libre Barcode 39',
        "Libre Barcode 39 Extended": 'Libre Barcode 39 Extended',
        "Libre Barcode 39 Extended Text": 'Libre Barcode 39 Extended Text',
        "Libre Barcode 39 Text": 'Libre Barcode 39 Text',
        "Libre Barcode 128": 'Libre Barcode 128',
        "Libre Barcode 128 Text": 'Libre Barcode 128 Text',
        "Libre Baskerville": 'Libre Baskerville',
        "Libre Franklin": 'Libre Franklin',
        "Life Savers": 'Life Savers',
        "Lilita One": 'Lilita One',
        "Lily Script One": 'Lily Script One',
        "Limelight": 'Limelight',
        "Linden Hill": 'Linden Hill',
        "Lobster": 'Lobster',
        "Lobster Two": 'Lobster Two',
        "Londrina Outline": 'Londrina Outline',
        "Londrina Shadow": 'Londrina Shadow',
        "Londrina Sketch": 'Londrina Sketch',
        "Londrina Solid": 'Londrina Solid',
        "Lora": 'Lora',
        "Love Ya Like A Sister": 'Love Ya Like A Sister',
        "Loved by the King": 'Loved by the King',
        "Lovers Quarrel": 'Lovers Quarrel',
        "Luckiest Guy": 'Luckiest Guy',
        "Lusitana": 'Lusitana',
        "Lustria": 'Lustria',
        "M PLUS 1p": 'M PLUS 1p',
        "M PLUS Rounded 1c": 'M PLUS Rounded 1c',
        "Macondo": 'Macondo',
        "Macondo Swash Caps": 'Macondo Swash Caps',
        "Mada": 'Mada',
        "Magra": 'Magra',
        "Maiden Orange": 'Maiden Orange',
        "Maitree": 'Maitree',
        "Major Mono Display": 'Major Mono Display',
        "Mako": 'Mako',
        "Mali": 'Mali',
        "Mallanna": 'Mallanna',
        "Mandali": 'Mandali',
        "Manuale": 'Manuale',
        "Marcellus": 'Marcellus',
        "Marcellus SC": 'Marcellus SC',
        "Marck Script": 'Marck Script',
        "Margarine": 'Margarine',
        "Markazi Text": 'Markazi Text',
        "Marko One": 'Marko One',
        "Marmelad": 'Marmelad',
        "Martel": 'Martel',
        "Martel Sans": 'Martel Sans',
        "Marvel": 'Marvel',
        "Mate": 'Mate',
        "Mate SC": 'Mate SC',
        "Maven Pro": 'Maven Pro',
        "McLaren": 'McLaren',
        "Meddon": 'Meddon',
        "MedievalSharp": 'MedievalSharp',
        "Medula One": 'Medula One',
        "Meera Inimai": 'Meera Inimai',
        "Megrim": 'Megrim',
        "Meie Script": 'Meie Script',
        "Merienda": 'Merienda',
        "Merienda One": 'Merienda One',
        "Merriweather": 'Merriweather',
        "Merriweather Sans": 'Merriweather Sans',
        "Metal": 'Metal',
        "Metal Mania": 'Metal Mania',
        "Metamorphous": 'Metamorphous',
        "Metrophobic": 'Metrophobic',
        "Michroma": 'Michroma',
        "Milonga": 'Milonga',
        "Miltonian": 'Miltonian',
        "Miltonian Tattoo": 'Miltonian Tattoo',
        "Mina": 'Mina',
        "Miniver": 'Miniver',
        "Miriam Libre": 'Miriam Libre',
        "Mirza": 'Mirza',
        "Miss Fajardose": 'Miss Fajardose',
        "Mitr": 'Mitr',
        "Modak": 'Modak',
        "Modern Antiqua": 'Modern Antiqua',
        "Mogra": 'Mogra',
        "Molengo": 'Molengo',
        "Molle": 'Molle',
        "Monda": 'Monda',
        "Monofett": 'Monofett',
        "Monoton": 'Monoton',
        "Monsieur La Doulaise": 'Monsieur La Doulaise',
        "Montaga": 'Montaga',
        "Montez": 'Montez',
        "Montserrat": 'Montserrat',
        "Montserrat Alternates": 'Montserrat Alternates',
        "Montserrat Subrayada": 'Montserrat Subrayada',
        "Moul": 'Moul',
        "Moulpali": 'Moulpali',
        "Mountains of Christmas": 'Mountains of Christmas',
        "Mouse Memoirs": 'Mouse Memoirs',
        "Mr Bedfort": 'Mr Bedfort',
        "Mr Dafoe": 'Mr Dafoe',
        "Mr De Haviland": 'Mr De Haviland',
        "Mrs Saint Delafield": 'Mrs Saint Delafield',
        "Mrs Sheppards": 'Mrs Sheppards',
        "Mukta": 'Mukta',
        "Mukta Mahee": 'Mukta Mahee',
        "Mukta Malar": 'Mukta Malar',
        "Mukta Vaani": 'Mukta Vaani',
        "Muli": 'Muli',
        "Mystery Quest": 'Mystery Quest',
        "NTR": 'NTR',
        "Nanum Brush Script": 'Nanum Brush Script',
        "Nanum Gothic": 'Nanum Gothic',
        "Nanum Gothic Coding": 'Nanum Gothic Coding',
        "Nanum Myeongjo": 'Nanum Myeongjo',
        "Nanum Pen Script": 'Nanum Pen Script',
        "Neucha": 'Neucha',
        "Neuton": 'Neuton',
        "New Rocker": 'New Rocker',
        "News Cycle": 'News Cycle',
        "Niconne": 'Niconne',
        "Niramit": 'Niramit',
        "Nixie One": 'Nixie One',
        "Nobile": 'Nobile',
        "Nokora": 'Nokora',
        "Norican": 'Norican',
        "Nosifer": 'Nosifer',
        "Notable": 'Notable',
        "Nothing You Could Do": 'Nothing You Could Do',
        "Noticia Text": 'Noticia Text',
        "Noto Sans": 'Noto Sans',
        "Noto Sans JP": 'Noto Sans JP',
        "Noto Sans KR": 'Noto Sans KR',
        "Noto Sans SC": 'Noto Sans SC',
        "Noto Sans TC": 'Noto Sans TC',
        "Noto Serif": 'Noto Serif',
        "Noto Serif JP": 'Noto Serif JP',
        "Noto Serif KR": 'Noto Serif KR',
        "Noto Serif SC": 'Noto Serif SC',
        "Noto Serif TC": 'Noto Serif TC',
        "Nova Cut": 'Nova Cut',
        "Nova Flat": 'Nova Flat',
        "Nova Mono": 'Nova Mono',
        "Nova Oval": 'Nova Oval',
        "Nova Round": 'Nova Round',
        "Nova Script": 'Nova Script',
        "Nova Slim": 'Nova Slim',
        "Nova Square": 'Nova Square',
        "Numans": 'Numans',
        "Nunito": 'Nunito',
        "Nunito Sans": 'Nunito Sans',
        "Odor Mean Chey": 'Odor Mean Chey',
        "Offside": 'Offside',
        "Old Standard TT": 'Old Standard TT',
        "Oldenburg": 'Oldenburg',
        "Oleo Script": 'Oleo Script',
        "Oleo Script Swash Caps": 'Oleo Script Swash Caps',
        "Open Sans": 'Open Sans',
        "Open Sans Condensed": 'Open Sans Condensed',
        "Oranienbaum": 'Oranienbaum',
        "Orbitron": 'Orbitron',
        "Oregano": 'Oregano',
        "Orienta": 'Orienta',
        "Original Surfer": 'Original Surfer',
        "Oswald": 'Oswald',
        "Over the Rainbow": 'Over the Rainbow',
        "Overlock": 'Overlock',
        "Overlock SC": 'Overlock SC',
        "Overpass": 'Overpass',
        "Overpass Mono": 'Overpass Mono',
        "Ovo": 'Ovo',
        "Oxygen": 'Oxygen',
        "Oxygen Mono": 'Oxygen Mono',
        "PT Mono": 'PT Mono',
        "PT Sans": 'PT Sans',
        "PT Sans Caption": 'PT Sans Caption',
        "PT Sans Narrow": 'PT Sans Narrow',
        "PT Serif": 'PT Serif',
        "PT Serif Caption": 'PT Serif Caption',
        "Pacifico": 'Pacifico',
        "Padauk": 'Padauk',
        "Palanquin": 'Palanquin',
        "Palanquin Dark": 'Palanquin Dark',
        "Pangolin": 'Pangolin',
        "Paprika": 'Paprika',
        "Parisienne": 'Parisienne',
        "Passero One": 'Passero One',
        "Passion One": 'Passion One',
        "Pathway Gothic One": 'Pathway Gothic One',
        "Patrick Hand": 'Patrick Hand',
        "Patrick Hand SC": 'Patrick Hand SC',
        "Pattaya": 'Pattaya',
        "Patua One": 'Patua One',
        "Pavanam": 'Pavanam',
        "Paytone One": 'Paytone One',
        "Peddana": 'Peddana',
        "Peralta": 'Peralta',
        "Permanent Marker": 'Permanent Marker',
        "Petit Formal Script": 'Petit Formal Script',
        "Petrona": 'Petrona',
        "Philosopher": 'Philosopher',
        "Piedra": 'Piedra',
        "Pinyon Script": 'Pinyon Script',
        "Pirata One": 'Pirata One',
        "Plaster": 'Plaster',
        "Play": 'Play',
        "Playball": 'Playball',
        "Playfair Display": 'Playfair Display',
        "Playfair Display SC": 'Playfair Display SC',
        "Podkova": 'Podkova',
        "Poiret One": 'Poiret One',
        "Poller One": 'Poller One',
        "Poly": 'Poly',
        "Pompiere": 'Pompiere',
        "Pontano Sans": 'Pontano Sans',
        "Poor Story": 'Poor Story',
        "Poppins": 'Poppins',
        "Port Lligat Sans": 'Port Lligat Sans',
        "Port Lligat Slab": 'Port Lligat Slab',
        "Pragati Narrow": 'Pragati Narrow',
        "Prata": 'Prata',
        "Preahvihear": 'Preahvihear',
        "Press Start 2P": 'Press Start 2P',
        "Pridi": 'Pridi',
        "Princess Sofia": 'Princess Sofia',
        "Prociono": 'Prociono',
        "Prompt": 'Prompt',
        "Prosto One": 'Prosto One',
        "Proza Libre": 'Proza Libre',
        "Puritan": 'Puritan',
        "Purple Purse": 'Purple Purse',
        "Quando": 'Quando',
        "Quantico": 'Quantico',
        "Quattrocento": 'Quattrocento',
        "Quattrocento Sans": 'Quattrocento Sans',
        "Questrial": 'Questrial',
        "Quicksand": 'Quicksand',
        "Quintessential": 'Quintessential',
        "Qwigley": 'Qwigley',
        "Racing Sans One": 'Racing Sans One',
        "Radley": 'Radley',
        "Rajdhani": 'Rajdhani',
        "Rakkas": 'Rakkas',
        "Raleway": 'Raleway',
        "Raleway Dots": 'Raleway Dots',
        "Ramabhadra": 'Ramabhadra',
        "Ramaraja": 'Ramaraja',
        "Rambla": 'Rambla',
        "Rammetto One": 'Rammetto One',
        "Ranchers": 'Ranchers',
        "Rancho": 'Rancho',
        "Ranga": 'Ranga',
        "Rasa": 'Rasa',
        "Rationale": 'Rationale',
        "Ravi Prakash": 'Ravi Prakash',
        "Redressed": 'Redressed',
        "Reem Kufi": 'Reem Kufi',
        "Reenie Beanie": 'Reenie Beanie',
        "Revalia": 'Revalia',
        "Rhodium Libre": 'Rhodium Libre',
        "Ribeye": 'Ribeye',
        "Ribeye Marrow": 'Ribeye Marrow',
        "Righteous": 'Righteous',
        "Risque": 'Risque',
        "Roboto": 'Roboto',
        "Roboto Condensed": 'Roboto Condensed',
        "Roboto Mono": 'Roboto Mono',
        "Roboto Slab": 'Roboto Slab',
        "Rochester": 'Rochester',
        "Rock Salt": 'Rock Salt',
        "Rokkitt": 'Rokkitt',
        "Romanesco": 'Romanesco',
        "Ropa Sans": 'Ropa Sans',
        "Rosario": 'Rosario',
        "Rosarivo": 'Rosarivo',
        "Rouge Script": 'Rouge Script',
        "Rozha One": 'Rozha One',
        "Rubik": 'Rubik',
        "Rubik Mono One": 'Rubik Mono One',
        "Ruda": 'Ruda',
        "Rufina": 'Rufina',
        "Ruge Boogie": 'Ruge Boogie',
        "Ruluko": 'Ruluko',
        "Rum Raisin": 'Rum Raisin',
        "Ruslan Display": 'Ruslan Display',
        "Russo One": 'Russo One',
        "Ruthie": 'Ruthie',
        "Rye": 'Rye',
        "Sacramento": 'Sacramento',
        "Sahitya": 'Sahitya',
        "Sail": 'Sail',
        "Saira": 'Saira',
        "Saira Condensed": 'Saira Condensed',
        "Saira Extra Condensed": 'Saira Extra Condensed',
        "Saira Semi Condensed": 'Saira Semi Condensed',
        "Salsa": 'Salsa',
        "Sanchez": 'Sanchez',
        "Sancreek": 'Sancreek',
        "Sansita": 'Sansita',
        "Sarabun": 'Sarabun',
        "Sarala": 'Sarala',
        "Sarina": 'Sarina',
        "Sarpanch": 'Sarpanch',
        "Satisfy": 'Satisfy',
        "Sawarabi Gothic": 'Sawarabi Gothic',
        "Sawarabi Mincho": 'Sawarabi Mincho',
        "Scada": 'Scada',
        "Scheherazade": 'Scheherazade',
        "Schoolbell": 'Schoolbell',
        "Scope One": 'Scope One',
        "Seaweed Script": 'Seaweed Script',
        "Secular One": 'Secular One',
        "Sedgwick Ave": 'Sedgwick Ave',
        "Sedgwick Ave Display": 'Sedgwick Ave Display',
        "Sevillana": 'Sevillana',
        "Seymour One": 'Seymour One',
        "Shadows Into Light": 'Shadows Into Light',
        "Shadows Into Light Two": 'Shadows Into Light Two',
        "Shanti": 'Shanti',
        "Share": 'Share',
        "Share Tech": 'Share Tech',
        "Share Tech Mono": 'Share Tech Mono',
        "Shojumaru": 'Shojumaru',
        "Short Stack": 'Short Stack',
        "Shrikhand": 'Shrikhand',
        "Siemreap": 'Siemreap',
        "Sigmar One": 'Sigmar One',
        "Signika": 'Signika',
        "Signika Negative": 'Signika Negative',
        "Simonetta": 'Simonetta',
        "Sintony": 'Sintony',
        "Sirin Stencil": 'Sirin Stencil',
        "Six Caps": 'Six Caps',
        "Skranji": 'Skranji',
        "Slabo 13px": 'Slabo 13px',
        "Slabo 27px": 'Slabo 27px',
        "Slackey": 'Slackey',
        "Smokum": 'Smokum',
        "Smythe": 'Smythe',
        "Sniglet": 'Sniglet',
        "Snippet": 'Snippet',
        "Snowburst One": 'Snowburst One',
        "Sofadi One": 'Sofadi One',
        "Sofia": 'Sofia',
        "Song Myung": 'Song Myung',
        "Sonsie One": 'Sonsie One',
        "Sorts Mill Goudy": 'Sorts Mill Goudy',
        "Source Code Pro": 'Source Code Pro',
        "Source Sans Pro": 'Source Sans Pro',
        "Source Serif Pro": 'Source Serif Pro',
        "Space Mono": 'Space Mono',
        "Special Elite": 'Special Elite',
        "Spectral": 'Spectral',
        "Spectral SC": 'Spectral SC',
        "Spicy Rice": 'Spicy Rice',
        "Spinnaker": 'Spinnaker',
        "Spirax": 'Spirax',
        "Squada One": 'Squada One',
        "Sree Krushnadevaraya": 'Sree Krushnadevaraya',
        "Sriracha": 'Sriracha',
        "Srisakdi": 'Srisakdi',
        "Staatliches": 'Staatliches',
        "Stalemate": 'Stalemate',
        "Stalinist One": 'Stalinist One',
        "Stardos Stencil": 'Stardos Stencil',
        "Stint Ultra Condensed": 'Stint Ultra Condensed',
        "Stint Ultra Expanded": 'Stint Ultra Expanded',
        "Stoke": 'Stoke',
        "Strait": 'Strait',
        "Stylish": 'Stylish',
        "Sue Ellen Francisco": 'Sue Ellen Francisco',
        "Suez One": 'Suez One',
        "Sumana": 'Sumana',
        "Sunflower": 'Sunflower',
        "Sunshiney": 'Sunshiney',
        "Supermercado One": 'Supermercado One',
        "Sura": 'Sura',
        "Suranna": 'Suranna',
        "Suravaram": 'Suravaram',
        "Suwannaphum": 'Suwannaphum',
        "Swanky and Moo Moo": 'Swanky and Moo Moo',
        "Syncopate": 'Syncopate',
        "Tajawal": 'Tajawal',
        "Tangerine": 'Tangerine',
        "Taprom": 'Taprom',
        "Tauri": 'Tauri',
        "Taviraj": 'Taviraj',
        "Teko": 'Teko',
        "Telex": 'Telex',
        "Tenali Ramakrishna": 'Tenali Ramakrishna',
        "Tenor Sans": 'Tenor Sans',
        "Text Me One": 'Text Me One',
        "Thasadith": 'Thasadith',
        "The Girl Next Door": 'The Girl Next Door',
        "Tienne": 'Tienne',
        "Tillana": 'Tillana',
        "Timmana": 'Timmana',
        "Tinos": 'Tinos',
        "Titan One": 'Titan One',
        "Titillium Web": 'Titillium Web',
        "Trade Winds": 'Trade Winds',
        "Trirong": 'Trirong',
        "Trocchi": 'Trocchi',
        "Trochut": 'Trochut',
        "Trykker": 'Trykker',
        "Tulpen One": 'Tulpen One',
        "Ubuntu": 'Ubuntu',
        "Ubuntu Condensed": 'Ubuntu Condensed',
        "Ubuntu Mono": 'Ubuntu Mono',
        "Ultra": 'Ultra',
        "Uncial Antiqua": 'Uncial Antiqua',
        "Underdog": 'Underdog',
        "Unica One": 'Unica One',
        "UnifrakturCook": 'UnifrakturCook',
        "UnifrakturMaguntia": 'UnifrakturMaguntia',
        "Unkempt": 'Unkempt',
        "Unlock": 'Unlock',
        "Unna": 'Unna',
        "VT323": 'VT323',
        "Vampiro One": 'Vampiro One',
        "Varela": 'Varela',
        "Varela Round": 'Varela Round',
        "Vast Shadow": 'Vast Shadow',
        "Vesper Libre": 'Vesper Libre',
        "Vibur": 'Vibur',
        "Vidaloka": 'Vidaloka',
        "Viga": 'Viga',
        "Voces": 'Voces',
        "Volkhov": 'Volkhov',
        "Vollkorn": 'Vollkorn',
        "Vollkorn SC": 'Vollkorn SC',
        "Voltaire": 'Voltaire',
        "Waiting for the Sunrise": 'Waiting for the Sunrise',
        "Wallpoet": 'Wallpoet',
        "Walter Turncoat": 'Walter Turncoat',
        "Warnes": 'Warnes',
        "Wellfleet": 'Wellfleet',
        "Wendy One": 'Wendy One',
        "Wire One": 'Wire One',
        "Work Sans": 'Work Sans',
        "Yanone Kaffeesatz": 'Yanone Kaffeesatz',
        "Yantramanav": 'Yantramanav',
        "Yatra One": 'Yatra One',
        "Yellowtail": 'Yellowtail',
        "Yeon Sung": 'Yeon Sung',
        "Yeseva One": 'Yeseva One',
        "Yesteryear": 'Yesteryear',
        "Yrsa": 'Yrsa',
        "ZCOOL KuaiLe": 'ZCOOL KuaiLe',
        "ZCOOL QingKe HuangYou": 'ZCOOL QingKe HuangYou',
        "ZCOOL XiaoWei": 'ZCOOL XiaoWei',
        "Zeyada": 'Zeyada',
        "Zilla Slab": 'Zilla Slab',
        "Zilla Slab Highlight": 'Zilla Slab Highlight'
    };

    // Define popup template.
    $.extend($.FroalaEditor.POPUP_TEMPLATES, {
        "customPlugin.popup": '[_BUTTONS_]'
    });

    // Define popup buttons.

    $.extend($.FroalaEditor.DEFAULTS, {
        popupButtons: ['align','insertLink','formatUL','-','strikeThrough','fontAwesome','emoticons','-','undo','redo','html'],
    });

    // The custom popup is defined inside a plugin (new or existing).

    $.FroalaEditor.PLUGINS.customPlugin = function (editor) {
        // Create custom popup.
        function initPopup () {
            // Popup buttons.
            var popup_buttons = '';

            // Create the list of buttons.
            if (editor.opts.popupButtons.length > 1) {
                popup_buttons += '<div class="fr-buttons">';
                popup_buttons += editor.button.buildList(editor.opts.popupButtons);
                popup_buttons += '</div>';
            }

            // Load popup template.
            var template = {
                buttons: popup_buttons,
            };

            // Create popup.
            var $popup = editor.popups.create('customPlugin.popup', template);

            return $popup;
        }

        // Show the popup
        function showPopup () {
            // Get the popup object defined above.
            var $popup = editor.popups.get('customPlugin.popup');

            // If popup doesn't exist then create it.
            // To improve performance it is best to create the popup when it is first needed
            // and not when the editor is initialized.
            if (!$popup) $popup = initPopup();

            // Set the editor toolbar as the popup's container.
            editor.popups.setContainer('customPlugin.popup', editor.$tb);

            // This will trigger the refresh event assigned to the popup.
            // editor.popups.refresh('customPlugin.popup');

            // This custom popup is opened by pressing a button from the editor's toolbar.
            // Get the button's object in order to place the popup relative to it.
            var $btn = editor.$tb.find('.fr-command[data-cmd="myButton"]');

            // Set the popup's position.
            var left = $btn.offset().left + $btn.outerWidth() / 2;
            var top = $btn.offset().top + (editor.opts.toolbarBottom ? 10 : $btn.outerHeight() - 10);

            // Show the custom popup.
            // The button's outerHeight is required in case the popup needs to be displayed above it.
            editor.popups.show('customPlugin.popup', left, top, $btn.outerHeight());
        }

        // Hide the custom popup.
        function hidePopup () {
            editor.popups.hide('customPlugin.popup');
        }

        // Methods visible outside the plugin.
        return {
            showPopup: showPopup,
            hidePopup: hidePopup
        }
    }

    // Define an icon and command for the button that opens the custom popup.

    $.FroalaEditor.DefineIcon('buttonIcon', { NAME: 'star'});
    $.FroalaEditor.RegisterCommand('myButton', {
        title: 'More Options',
        icon: 'buttonIcon',
        undo: false,
        focus: false,
        plugin: 'customPlugin',
        callback: function () {
            this.customPlugin.showPopup();
        }
    });

    // Initialize the editor.

    var froala_init = $('.fb-froala__init');
    $(froala_init).froalaEditor({
        key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
        fontFamily: font_object,
        fontSize: fontSize,
        autofocus:true,
        charCounterCount: false,
        // toolbarButtons:[ 'bold', 'italic','underline', 'fontSize' , 'fontFamily' , '|' , 'paragraphFormat' ,'align', 'formatOL' , 'formatUL'     , 'outdent', 'indent' , '|' , 'insertLink' , 'insertImage' , 'undo' , 'redo' , 'help' , 'html'],
        toolbarButtons: ['bold','italic','underline','fontSize','fontFamily','color','insertImage','insertVideo', '|', 'myButton'],
        // pluginsEnsabled: ['customPlugin'],
        formatUL:{

        },
    }).on('froalaEditor.popups.show.emoticons', function (){
        $('.classic-editor__wrapper').addClass('pop-emotions');
    }).on('froalaEditor.popups.hide.emoticons', function (){
        $('.classic-editor__wrapper').removeClass('pop-emotions');
    }).on('froalaEditor.popups.show.link.insert', function (){
        $('.classic-editor__wrapper').addClass('pop-link');
    }).on('froalaEditor.popups.hide.link.insert', function (){
        $('.classic-editor__wrapper').removeClass('pop-link');
    })



    $.FroalaEditor.DefineIcon('insertCTALink', {NAME: 'arrow-right'});
    $.FroalaEditor.RegisterCommand('insertCTALink', {
        title: 'Add CTA Link',
        focus: true,
        undo: true,
        refreshAfterCallback: true,
        callback: function() {
            this.popups.isVisible("link.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("link.insert")) : this.link._showInsertPopup();
            //console.info(this.link.get());
        },
        refresh: function() {
            linkbutton = 'insertCTALink';
            //this.link.get().addStyle('cta_text_style');
            _link = this.link.get();
            if(typeof(linkbutton ) != "undefined" && linkbutton  !== null && linkbutton == 'insertCTALink') {
                jQuery(_link).css({'font-family': '"Open Sans", sans-serif','padding': '0.5em 1em','border-radius': '50px','line-height': '1','background-color': 'rgb(255, 135, 0)','border': '2px solid rgb(255, 135, 0)','text-transform': 'uppercase','color': '#ffffff','font-weight': '700','text-decoration': 'none','text-align': 'center','margin': 'auto','margin-bottom': '0','-webkit-box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)','-moz-box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)','box-shadow': '2px 6px 14px 0 rgba(0,0,0,0.2)','vertical-align': 'middle','-ms-touch-action': 'manipulation','touch-action': 'manipulation','background-image': 'none','position': 'relative','z-index': '100','display': 'inline-block'});
                jQuery(_link).addClass("cta_style");
                jQuery(_link).find("span").css('color','#ffffff');
                linkbutton = '';
            }
        },
        plugin: "link"

    });
    // $('.fb-froala__tk-init').froalaEditor({
    //     key: 'lB6C1B4C1E1G2wG1G1B2C1B1D7B4E1D4D4jXa1TEWUf1d1QSDb1HAc1==',
    //     fontFamily: font_object,
    //     fontSize: fontSize,
    //     toolbarButtons:[ 'bold', 'italic','underline', 'fontSize' , 'fontFamily' , '|' , 'paragraphFormat' ,'align', 'formatOL' , 'formatUL' , 'outdent', 'indent' , '|' , 'insertLink' , 'insertImage' ,'insertVideo', 'insertCTALink', 'undo' , 'redo' , 'help' , 'html']
    // });

    $('.question-mark_tooltip').tooltipster({
        interactive: true,
        multiple: true,
        contentAsHTML:true
    });


    /**
     *
     *   Modal window Animation (by using animate.css)
     *
     * **/


    var _target = '';
    $('#next').click(function(){
        if(!$(this).hasClass('lp-btn_disable')){
            $('#add_question').addClass('bounceOutLeft');
            // $(this).removeClass('fade');
            _target = $('.question-option__item_active').attr('data-target');
            // $('#'+_target).modal('show');
            $('#'+_target).modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#'+_target).addClass('bounceInRight');
            $('#'+_target).removeClass('bounceOutRight');
        }
    });
    $('.lp-btn_modal_dismiss').click(function(){
        _target = $('.question-option__item_active').attr('data-target');
        $('#add_question').removeClass('bounceOutLeft');
        $('#add_question').addClass('bounceInRight');
        $('#'+_target).addClass('bounceOutRight');
        $('#'+_target).removeClass('bounceInRight');
    });

    $('#add_question').on('hide.bs.modal', function (e) {
        $(this).removeClass('bounceOutLeft bounceInRight');
        $(this).addClass('bounceIn');
        $('.modal-backdrop').remove();
    });


    /**
     *
     *   Tabs Toggle
     *
     * */

    $('.fb-tab__link').click(function(e){
        $(this).parents('.fb-tab').find('.fb-tab__link').removeClass('fb-tab__link_active');
        $(this).addClass('fb-tab__link_active');
    });


    /**
     *
     *  Bootstrap Slider Init
     *
     * */


    $('.fb-slider').bootstrapSlider();

    $('#buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.defaultfontsize').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.defaultfontsize').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    $('#buttonFontSizeSlider2').bootstrapSlider({
        formatter: function(value) {
            $('.defaultfontsize2').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.defaultfontsize2').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    $('#buttonFontSizeSlider3').bootstrapSlider({
        formatter: function(value) {
            $('.defaultfontsize3').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.defaultfontsize3').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });


    $('#address-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.address-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.address-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#icon-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.icon-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.icon-buttonFontSizeSlider').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#icon-buttonFontSizeSlider01').bootstrapSlider({
        formatter: function(value) {
            $('.icon-buttonFontSizeSlider01').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.icon-buttonFontSizeSlider01').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#icon-buttonFontSizeSlider02').bootstrapSlider({
        formatter: function(value) {
            $('.icon-buttonFontSizeSlider02').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.icon-buttonFontSizeSlider02').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#icon-buttonFontSizeSlider03').bootstrapSlider({
        formatter: function(value) {
            $('.icon-buttonFontSizeSlider03').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.icon-buttonFontSizeSlider03').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#dropdown-icon-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.dropdown-icon-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.dropdown-icon-buttonFontSizeSlider').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#cta-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.cta-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.cta-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#dropdown-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.dropdown-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.dropdown-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#contact-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.contact-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.contact-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#textfield-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.textfield-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.textfield-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#textfield-large-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.textfield-large-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.textfield-large-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#fb-icon-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.fb-icon-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.fb-icon-buttonFontSizeSlider').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#cta-icon-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.cta-icon-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.cta-icon-buttonFontSizeSlider').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#contact-icon-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.contact-icon-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.contact-icon-buttonFontSizeSlider').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#textfield-icon-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.textfield-icon-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.textfield-icon-buttonFontSizeSlider').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#textfield-large-icon-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.textfield-large-icon-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.textfield-large-icon-buttonFontSizeSlider').val(),
        tooltip: 'hide',
        tooltip_position:'bottom'
    });

    $('#font-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.font-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.font-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#font-buttonFontSizeSlider01').bootstrapSlider({
        formatter: function(value) {
            $('.font-buttonFontSizeSlider01').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.font-buttonFontSizeSlider01').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#font-buttonFontSizeSlider02').bootstrapSlider({
        formatter: function(value) {
            $('.font-buttonFontSizeSlider02').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.font-buttonFontSizeSlider02').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#font-buttonFontSizeSlider03').bootstrapSlider({
        formatter: function(value) {
            $('.font-buttonFontSizeSlider03').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.font-buttonFontSizeSlider03').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });

    $('#birthday-buttonFontSizeSlider').bootstrapSlider({
        formatter: function(value) {
            $('.birthday-buttonFontSizeSlider').val(value);
            return   value +'px';
        },
        min: 0,
        max: 100,
        value: $('.birthday-buttonFontSizeSlider').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });


    $('#bd-year-old').bootstrapSlider({
        formatter: function(value) {
            jQuery('.select2js__slide__minimum-val').html(value);
        },
        min: 0,
        max: 100,
        value: $('#bd-year-old').val(),
        tooltip: 'false',
    });


    $('#bd-year-slider').bootstrapSlider({
        formatter: function(value) {
            jQuery('.select2js__slide__current-year').html(value);
        },
        min: 0,
        max: 100,
        value: $('#bd-year-slider').val(),
        tooltip: 'false',
    });



    /**
     *
     * Thank you page
     *
     * **/
    $( "body" ).on( "change",".thktogbtn" , function(e) {
        // $("#changebtn").val("1");
        if ($(this).is(':checked')) {
            $('.thktogbtn').not(this).each(function(){
                $(this).bootstrapToggle("off");
            });
        }else{
            $('.thktogbtn').not(this).each(function(){
                $(this).bootstrapToggle("on");
            });
        }
    });

    $('#fb-edit-url').click(function (e) {
        e.preventDefault();
        if($(this).hasClass('fb-toggle-button_open')){
            $(this).text('Edit URL')
        }else{
            $(this).text('cancel')
        }
        $(this).toggleClass('fb-toggle-button_open');
        $('.tk-field-wrap').slideToggle();
    });


    $('.fb-toggle-button_ty-detail-page').click(function () {
        $('#fb-thank-you').modal('hide');
        $('#fb-thank-you-detail').modal('show');
    });

    $('.url-prefix').select2({
        minimumResultsForSearch: -1,
        width: '140px', // need to override the changed default
        dropdownParent: $('.select2__parent-url-prefix')
    }).on('select2:openning', function() {
        jQuery('.select2__parent-url-prefix .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__parent-url-prefix .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-url-prefix .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-url-prefix .select2-dropdown').hide();
        jQuery('.select2__parent-url-prefix .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-url-prefix .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-url-prefix .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.url-prefix').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__parent-url-prefix .select2-selection__rendered').show();
        jQuery('.select2__parent-url-prefix .select2-results__options').css('pointer-events', 'none');
    });

    /**
     *
     * Custom dropdown jquery
     *
     * */


    $('#dynamic-answer').on('click' ,function (e) {
        e.stopPropagation();
        $(this).addClass('lp-dropdown__open');
        $(this).find('.lp-dropdown__menu').show();

    });
    $(document).click(function (e) {
        $('.lp-dropdown').removeClass('lp-dropdown__open');
        $('.lp-dropdown').find('.lp-dropdown__menu').hide();
    });
    $('#dynamic-answer').find('.lp-dropdown__item').on('click' , function (e) {
        e.stopPropagation();
        $('.lp-dropdown__item').removeClass('lp-dropdown__item_selected');
        $(this).addClass('lp-dropdown__item_selected');
        $(this).parents('.lp-dropdown').removeClass('lp-dropdown__open');
        $(this).parents('.lp-dropdown').find('.lp-dropdown__menu').hide();
        // $(this).parents('.lp-dropdown').find('.lp-dropdown__text').text($(this).text().replace(/[0-9]\./g,''));
        $(this).parents('.lp-dropdown').find('.lp-dropdown__text').text($(this).text());
    });


    $('#fb-thank-you-detail , #cl-preview').on('hidden.bs.modal', function() {
        $('body').addClass('modal-open');
    });

    $('#fb-thank-you').on('hidden.bs.modal', function() {
        $('#fb-edit-url').text('Edit URL');
        $('.tk-field-wrap').slideUp();
        $('#fb-edit-url').removeClass('fb-toggle-button_open');
    });


    /**
     *
     *  Conditional Logic
     *
     * */

    $('.cl-tooltip-init').tooltipster({
        position:'bottom',
        delay: 0,
        multiple: true
    });

    $(document).on('click' , '.fb-add-box_clone-if' ,function(e){

        var lastIndex = Object.keys(fbselectArr)[Object.keys(fbselectArr).length-1];
        var tempArr = [
            {
                element : 'fb-select-' + (parseInt(lastIndex) + 2),
                wrap : 'fb-select-wrap-' + (parseInt(lastIndex) + 2)
            },
            {
                element : 'fb-select-' + (parseInt(lastIndex) + 3),
                wrap : 'fb-select-wrap-' + (parseInt(lastIndex) + 3)
            },
            {
                element : 'fb-select-' + (parseInt(lastIndex) + 4),
                wrap : 'fb-select-wrap-' + (parseInt(lastIndex) + 4)
            }] ;

        e.preventDefault();
        var _parents = $(this).data('parents');
        var cloned = $(this).parents('.'+_parents).find('.cl-grid:first-child').clone();
        cloned.find('.cl-field_state').addClass('cl-field_disabled');
        cloned.find('.cl-field_value').addClass('cl-field_disabled');
        cloned.find('.cl-field_field').addClass('cl-field_disabled');

        jQuery.each(tempArr, function(index, item) {
            // do something with `item` (or `this` is also `item` if you like)
            cloned.find('.fb-select-' + (parseInt(index) + 1)).addClass(item.element).removeClass('fb-select-' + (parseInt(index) + 1));
            cloned.find('.fb-select-wrap-' + (parseInt(index) + 1)).addClass(item.wrap).removeClass('fb-select-wrap-' + (parseInt(index) + 1));
            cloned.find('.' + item.wrap).addClass("select2-parent");

            cloned.find('.' + item.wrap).attr("id" , item.wrap);
            cloned.find('.' + item.element).attr("id" , item.element);
            fbselectArr.push(item);
        });
        cloned.appendTo('.'+_parents).slideDown();
        jQuery.each(tempArr, function(index, item) {
            initializeSelect2(item.element, item.wrap);
            $('.select2-container--default').next('.select2-container--default').remove();
        });
        initializeSelect2(fbselectArr[0].element , fbselectArr[0].wrap);
        initializeSelect2(fbselectArr[1].element , fbselectArr[1].wrap);
        initializeSelect2(fbselectArr[2].element , fbselectArr[2].wrap);

    });


    $(document).on('click' , '.fb-add-box_clone-do' ,function(e){

        var lastIndex = Object.keys(fbselectArr)[Object.keys(fbselectArr).length-1];
        var tempArr = [
            {
                element : 'fb-select-' + (parseInt(lastIndex) + 2),
                wrap : 'fb-select-wrap-' + (parseInt(lastIndex) + 2)
            },
            {
                element : 'fb-select-' + (parseInt(lastIndex) + 3),
                wrap : 'fb-select-wrap-' + (parseInt(lastIndex) + 3)
            }] ;

        e.preventDefault();
        var _parents = $(this).data('parents');
        var cloned = $(this).parents('.'+_parents).find('.cl-grid:first-child').clone();

        cloned.find('.cl-field_state').addClass('cl-field_disabled');
        cloned.find('.cl-field_value').addClass('cl-field_disabled');
        cloned.find('.cl-field_field').addClass('cl-field_disabled');

        jQuery.each(tempArr, function(index, item) {
            // do something with `item` (or `this` is also `item` if you like)
            cloned.find('.fb-select-' + (parseInt(index) + 4)).addClass(item.element).removeClass('fb-select-' + (parseInt(index) + 4));
            cloned.find('.fb-select-wrap-' + (parseInt(index) + 4)).addClass(item.wrap).removeClass('fb-select-wrap-' + (parseInt(index) + 4));
            cloned.find('.' + item.wrap).addClass("select2-parent");

            cloned.find('.' + item.wrap).attr("id" , item.wrap);
            cloned.find('.' + item.element).attr("id" , item.element);
             fbselectArr.push(item);
        });
        cloned.appendTo('.'+_parents).slideDown();
        jQuery.each(tempArr, function(index, item) {
            initializeSelect2(item.element, item.wrap);
            $('.select2-container--default').next('.select2-container--default').remove();
        });
        initializeSelect2(fbselectArr[3].element , fbselectArr[3].wrap);
        initializeSelect2(fbselectArr[4].element , fbselectArr[4].wrap);
    });

    $(document).on('click' , '.fb-add-box_close', function(){

        $(this).parents('.cl-grid').slideUp(function () {
            $(this).remove();
        });
    });

    $(document).on('click' , '.panel-aside__head .back-ico', function(){
        $('body').toggleClass('panel-aside_closed');
    });


    $(document).on('click' , '.actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('.fb-question-item-loader').remove();
        $('body').removeClass('funnel-question-page_overlay');
    });

    $(document).on('click' , '.zipcode-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('zipcode-overlay');
    });

    $(document).on('click' , '.menu-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('menu-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.slider-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('slider-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.txtfield-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('txtfield-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.dropdown-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('dropdown-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.cta-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('cta-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.date-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('date-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.contact-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('contact-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.state-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('state-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.vehicle-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('vehicle-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.transition-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('transition-overlay').css('overflow','visible');
    });

    $(document).on('click' , '.birthday-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('birthday-overlay').css('overflow','visible');
    });

    // adding fb contact page open

    $(document).on('click' , '.lp-control__link_fb-contact', function(e){
        e.preventDefault();
        $('body').addClass('contact-overlay');
    });


    // new option

    $(document).on('click' , '.address-overlay .actions-button__link_close-funnels', function(e){
        e.preventDefault();
        $('body').removeClass('address-overlay');
    });


    $('.cl-preview-sorting').sortable({
        placeholder: "cl-preview-sorting__highlight",
        scroll: true,
        axis: "y",
        handle: ".cl-preview-control__item_move",
        start:function(e, ui){
            $('.cl-preview-sorting__highlight').text('Drop Your Element Here...');
            $('.cl-tooltip-init').tooltipster('disable');
            ui.placeholder.height(ui.item.outerHeight()-2);
        },
        stop: function() {
            $('.cl-tooltip-init').tooltipster('enable');
        }
    });

    var Recipient = {
        form_reset: function () {
            $("#question_name").val('');
            $("#transition_name").val('');
            $(".modal-content").find(".form-control.error").removeClass("error");
        }
    }

    var transition_modalvalidation = $('#new-transition'),
        transition_validator = transition_modalvalidation.validate({
            rules:{
                transition_name:{
                    required: true,
                },
            },
            messages:{
                transition_name: {
                    required: "Please add your new transition name."
                }
            },
            debug: false,
            submitHandler: function () {
                console.info('submitted');
            }
        });
    var question_modalvalidation = $('#new-question'),
        question_validator = question_modalvalidation.validate({
            rules:{
                question_name:{
                    required: true,
                },
            },
            messages:{
                question_name: {
                    required: "Please add your new global question name."
                }
            },
            debug: false,
            submitHandler: function () {
                console.info('submitted');
            }
        });

    $('#create-funnel-pop').validate({
        rules:{
            funnel_name:{
                required: true,
            },
            tag_list: {
                required:true,
            }
        },
        messages:{
            funnel_name: {
                required: "Please enter your new funnel name."
            },
            tag_list: {
                required:"Please add funnel tags."
            }
        }
    });

    var clonetransition_modalvalidation = $('#clone-transition'),
        clonetransition_validator = clonetransition_modalvalidation.validate({
            rules:{
                transition_name_clone:{
                    required: true,
                },
            },
            messages:{
                transition_name_clone: {
                    required: "Please add your clone transition name."
                }
            },
            debug: false,
            submitHandler: function () {
                console.info('submitted');
            }
        });

    var clonequestion_modalvalidation = $('#clone-question'),
        clonequestion_validator = clonequestion_modalvalidation.validate({
            rules:{
                question_name_clone:{
                    required: true,
                },
            },
            messages:{
                question_name_clone: {
                    required: "Please add your clone global question name."
                }
            },
            debug: false,
            submitHandler: function () {
                console.info('submitted');
            }
        });

    obj.init();

    //    contact info funnel builder js

    var message_type = [
        {
            id:0,
            text:'<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>Default Message</span></div>',
            title:'Message'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>Default Message</span></div>',
            title:'Message'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Select message:</span><span>Default Message</span></div>',
            title:'Message'
        }
    ];

    var icon_type = [
        {
            id:0,
            text:'<div class="select2_style"><span class="select2js-placeholder">Icon positioning:</span><span>Left Align</span></div>',
            title:'Left Align'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Icon positioning:</span><span>Right Align</span></div>',
            title:'Right Align'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Icon positioning:</span><span>Center Align</span></div>',
            title:'Center Align'
        }
    ];

    var input_type = [
        {
            id:0,
            text:'<div class="select2_style">Input Type</div>',
            title:'Input Type'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Input Type:</span><span>Name</span></div>',
            title:'Input Type Name'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Input Type:</span><span>Email</span></div>',
            title:'Input Type Email'
        },
        {
            id:3,
            text:'<div class="select2_style"><span class="select2js-placeholder">Input Type:</span><span>Phone</span></div>',
            title:'Input Type Phone '
        }
    ];

    var contact_variation = [
        {
            id:0,
            text:'<div class="select2_style">Variation</div>',
            title:'Variation'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Variation:</span><span>First Name</span></div>',
            title:'Variation First Name'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Variation:</span><span>First Name + Last Name</span></div>',
            title:'Variation First Name + Last Name'
        },
        {
            id:3,
            text:'<div class="select2_style"><span class="select2js-placeholder">Variation:</span><span>Full Name</span></div>',
            title:'Variation Full Name'
        }
    ];

    var country_code = [
        {
            id:0,
            text:'<div class="select2_style">Country Code</div>',
            title:'Country Code'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Country Code:</span><span>Off</span></div>',
            title:'Country Code Off'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Country Code:</span><span>On</span></div>',
            title:'Country Code On'
        }
    ];

    var phone_format = [
        {
            id:0,
            text:'<div class="select2_style">Auto-Format Phone Number</div>',
            title:'Auto-Format Phone Number'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Auto-Format Phone Number:</span><span>None</span></div>',
            title:'Auto-Format Phone Number None'
        }
    ];

    var edit_content = [
        {
            id:0,
            text:'<div class="select2_style">Edit Content For</div>',
            title:'Edit Content For'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Edit Content For:</span><span>First Step</span></div>',
            title:'Edit Content For First Step'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Edit Content For:</span><span>Second Step</span></div>',
            title:'Edit Content For Second Step'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Edit Content For:</span><span>Third Step</span></div>',
            title:'Edit Content For Third Step'
        }

    ];

    var edit_addressContent = [
        {
            id:0,
            text:'<div class="select2_style">Edit Content For</div>',
            title:'Edit Content For'
        },
        {
            id:1,
            text:'<div class="select2_style"><span class="select2js-placeholder">Edit Content For:</span><span>First Step</span></div>',
            title:'Edit Content For First Step'
        },
        {
            id:2,
            text:'<div class="select2_style"><span class="select2js-placeholder">Edit Content For:</span><span>Second Step</span></div>',
            title:'Edit Content For Second Step'
        }

    ];


    $('#message-type-menu').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.message-parent-menu'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.message-parent-menu .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.message-parent-menu .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.message-parent-menu .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.message-parent-menu .select2-dropdown').hide();
        jQuery('.message-parent-menu .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.message-parent-menu .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.message-parent-menu .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#message-type-menu').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.message-parent-menu .select2-selection__rendered').show();
        jQuery('.message-parent-menu .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#message-type-menu option:eq(1)').val());

    $('#slider-type-menu').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.slider-parent-menu'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.slider-parent-menu .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.slider-parent-menu .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.slider-parent-menu .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.slider-parent-menu .select2-dropdown').hide();
        jQuery('.slider-parent-menu .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.slider-parent-menu .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.slider-parent-menu .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#slider-type-menu').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.slider-parent-menu .select2-selection__rendered').show();
        jQuery('.slider-parent-menu .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#slider-type-menu option:eq(1)').val());

    $('#non-slider-type-menu').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.non-slider-parent-menu'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.non-slider-parent-menu .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.non-slider-parent-menu .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.non-slider-parent-menu .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.non-slider-parent-menu .select2-dropdown').hide();
        jQuery('.non-slider-parent-menu .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.non-slider-parent-menu .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.non-slider-parent-menu .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#non-slider-type-menu').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.non-slider-parent-menu .select2-selection__rendered').show();
        jQuery('.non-slider-parent-menu .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#snon-lider-type-menu option:eq(1)').val());

    $('#message-type').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-message-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-message-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-message-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-message-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-message-parent .select2-dropdown').hide();
        jQuery('.input-message-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-message-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-message-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#message-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-message-parent .select2-selection__rendered').show();
        jQuery('.input-message-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#message-type option:eq(1)').val());


    $('#cta-message-type').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.cta-input-message-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.cta-input-message-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.cta-input-message-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.cta-input-message-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.cta-input-message-parent .select2-dropdown').hide();
        jQuery('.cta-input-message-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.cta-input-message-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.cta-input-message-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#cta-message-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.cta-input-message-parent .select2-selection__rendered').show();
        jQuery('.cta-input-message-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#cta-message-type option:eq(1)').val());


    $('#dropdown-message-type').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.dropdown-input-message-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.dropdown-input-message-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.dropdown-input-message-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.dropdown-input-message-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.dropdown-input-message-parent .select2-dropdown').hide();
        jQuery('.dropdown-input-message-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.dropdown-input-message-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.dropdown-input-message-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#dropdown-message-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.dropdown-input-message-parent .select2-selection__rendered').show();
        jQuery('.dropdown-input-message-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#dropdown-message-type option:eq(1)').val());


    $('#contact-message-type').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.contact-input-message-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.contact-input-message-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.contact-input-message-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.contact-input-message-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.contact-input-message-parent .select2-dropdown').hide();
        jQuery('.contact-input-message-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.contact-input-message-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.contact-input-message-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#contact-message-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.contact-input-message-parent .select2-selection__rendered').show();
        jQuery('.contact-input-message-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#contact-message-type option:eq(1)').val());


    $('#fb-message-type').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.fb-input-message-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.fb-input-message-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-input-message-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-input-message-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-input-message-parent .select2-dropdown').hide();
        jQuery('.fb-input-message-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-input-message-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-input-message-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#fb-message-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-input-message-parent .select2-selection__rendered').show();
        jQuery('.fb-input-message-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#fb-message-type option:eq(1)').val());

    $('#textfield-message-type').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.textfield-input-message-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.textfield-input-message-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.textfield-input-message-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.textfield-input-message-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.textfield-input-message-parent .select2-dropdown').hide();
        jQuery('.textfield-input-message-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.textfield-input-message-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.textfield-input-message-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#textfield-message-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.textfield-input-message-parent .select2-selection__rendered').show();
        jQuery('.textfield-input-message-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#textfield-message-type option:eq(1)').val());

    $('#textfield-large-message-type').select2({
        data: message_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.textfield-large-input-message-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.textfield-large-input-message-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.textfield-large-input-message-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.textfield-large-input-message-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.textfield-large-input-message-parent .select2-dropdown').hide();
        jQuery('.textfield-large-input-message-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.textfield-large-input-message-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.textfield-large-input-message-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#textfield-large-message-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.textfield-large-input-message-parent .select2-selection__rendered').show();
        jQuery('.textfield-large-input-message-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#textfield-large-message-type option:eq(1)').val());


    $('#zip-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.zip-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.zip-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.zip-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.zip-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.zip-input-icon-parent .select2-dropdown').hide();
        jQuery('.zip-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.zip-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.zip-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#zip-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.zip-input-icon-parent .select2-selection__rendered').show();
        jQuery('.zip-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#zip-icon-type option:eq(1)').val());

    $('#num-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.num-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.num-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.num-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.num-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.num-input-icon-parent .select2-dropdown').hide();
        jQuery('.num-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.num-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.num-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#num-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.num-input-icon-parent .select2-selection__rendered').show();
        jQuery('.num-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#num-icon-type option:eq(1)').val());

    $('#non-num-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.non-num-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.non-num-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.non-num-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.non-num-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.non-num-input-icon-parent .select2-dropdown').hide();
        jQuery('.non-num-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.non-num-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.non-num-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#non-num-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.non-num-input-icon-parent .select2-selection__rendered').show();
        jQuery('.non-num-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#non-num-icon-type option:eq(1)').val());

    $('#menu-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.menu-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.menu-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.menu-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.menu-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.menu-input-icon-parent .select2-dropdown').hide();
        jQuery('.menu-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.menu-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.menu-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#menu-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.menu-input-icon-parent .select2-selection__rendered').show();
        jQuery('.menu-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#menu-icon-type option:eq(1)').val());

    $('#fb-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.fb-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.fb-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.fb-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.fb-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.fb-input-icon-parent .select2-dropdown').hide();
        jQuery('.fb-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.fb-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.fb-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#fb-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.fb-input-icon-parent .select2-selection__rendered').show();
        jQuery('.fb-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#fb-icon-type option:eq(1)').val());

    $('#dropdown-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.dropdown-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.dropdown-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.dropdown-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.dropdown-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.dropdown-input-icon-parent .select2-dropdown').hide();
        jQuery('.dropdown-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        /*jQuery('.dropdown-input-icon-parent .select2-selection__rendered').hide();*/
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.dropdown-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#dropdown-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        /*jQuery('.fb-input-icon-parent .select2-selection__rendered').show();*/
        jQuery('.fb-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#fb-icon-type option:eq(1)').val());

    $('#cta-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.cta-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.cta-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.cta-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.cta-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.cta-input-icon-parent .select2-dropdown').hide();
        jQuery('.cta-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.cta-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.cta-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#cta-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.cta-input-icon-parent .select2-selection__rendered').show();
        jQuery('.cta-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#cta-icon-type option:eq(1)').val());

    $('#contact-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.contact-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.contact-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.contact-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.contact-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.contact-input-icon-parent .select2-dropdown').hide();
        jQuery('.contact-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.contact-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.contact-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#contact-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.contact-input-icon-parent .select2-selection__rendered').show();
        jQuery('.contact-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#contact-icon-type option:eq(1)').val());

    $('#textfield-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.textfield-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.textfield-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.textfield-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.textfield-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.textfield-input-icon-parent .select2-dropdown').hide();
        jQuery('.textfield-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.textfield-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.textfield-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#textfield-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.textfield-input-icon-parent .select2-selection__rendered').show();
        jQuery('.textfield-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#textfield-icon-type option:eq(1)').val());

    $('#textfield-large-icon-type').select2({
        data: icon_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.textfield-large-input-icon-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.textfield-large-input-icon-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.textfield-large-input-icon-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.textfield-large-input-icon-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.textfield-large-input-icon-parent .select2-dropdown').hide();
        jQuery('.textfield-large-input-icon-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.textfield-large-input-icon-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.textfield-large-input-icon-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#textfield-large-icon-type').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.textfield-large-input-icon-parent .select2-selection__rendered').show();
        jQuery('.textfield-large-input-icon-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
    }).select2('val', $('#textfield-large-icon-type option:eq(1)').val());


    $('#input-type').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type-parent .select2-results__options').css('pointer-events', 'none');
        // setTimeout(function() {
            jQuery('.input-type-parent .select2-results__options').css('pointer-events', 'auto');
        // }, 300);
        jQuery('.input-type-parent .select2-dropdown').hide();
        jQuery('.input-type-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type-parent .select2-dropdown').attr('style', '');
            // setTimeout(function () {
                jQuery('#input-type').select2("close");
            // }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type-parent .select2-selection__rendered').show();
        jQuery('.input-type-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type option:eq(1)').val());


    $('#input-type1').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type1-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type1-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type1-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type1-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type1-parent .select2-dropdown').hide();
        jQuery('.input-type1-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type1-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type1-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type1').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type1-parent .select2-selection__rendered').show();
        jQuery('.input-type1-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type1 option:eq(2)').val());

    $('#input-type2').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type2-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type2-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type2-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type2-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type2-parent .select2-dropdown').hide();
        jQuery('.input-type2-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type2-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type2-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type2').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type2-parent .select2-selection__rendered').show();
        jQuery('.input-type2-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type2 option:eq(3)').val());


    $('#contact-variation').select2({
        data: contact_variation,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.contact-variation-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange");
        if (this.value == 1){
            $("#first-name").css("display", "block");
            $("#last-name").css("display", "none");
            $("#full-name").css("display", "none");
        }else if (this.value == 2){
            $("#first-name").css("display", "block");
            $("#last-name").css("display", "block");
            $("#full-name").css("display", "none");
        }else if (this.value == 3){
            $("#first-name").css("display", "none");
            $("#last-name").css("display", "none");
            $("#full-name").css("display", "block");
        }
        jQuery('#contact-variation').select2("close");
    }).on('select2:openning', function() {
        jQuery('.contact-variation-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.contact-variation-parent .select2-results__options').css('pointer-events', 'none');
        // setTimeout(function() {
            jQuery('.contact-variation-parent .select2-results__options').css('pointer-events', 'auto');
        // }, 300);
        jQuery('.contact-variation-parent .select2-dropdown').hide();
        jQuery('.contact-variation-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.contact-variation-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.contact-variation-parent .select2-dropdown').attr('style', '');
            // setTimeout(function () {
                jQuery('#contact-variation').select2("close");
            // }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.contact-variation-parent .select2-selection__rendered').show();
        jQuery('.contact-variation-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#contact-variation option:eq(1)').val());


    // advance settings

    $('#country-code').select2({
        data: country_code,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.country-code-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.country-code-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.country-code-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.country-code-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.country-code-parent .select2-dropdown').hide();
        jQuery('.country-code-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.country-code-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.country-code-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#country-code').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.country-code-parent .select2-selection__rendered').show();
        jQuery('.country-code-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#country-code option:eq(1)').val());

    $('#phone-format').select2({
        data: phone_format,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.phone-format-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.phone-format-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.phone-format-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.phone-format-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.phone-format-parent .select2-dropdown').hide();
        jQuery('.phone-format-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.phone-format-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.phone-format-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#phone-format').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.phone-format-parent .select2-selection__rendered').show();
        jQuery('.phone-format-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#phone-format option:eq(1)').val());

    // step 2 dropdown

    $('#edit-content-step2').select2({
        data: edit_content,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.edit-content-step2-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.edit-content-step2-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.edit-content-step2-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.edit-content-step2-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.edit-content-step2-parent .select2-dropdown').hide();
        jQuery('.edit-content-step2-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.edit-content-step2-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.edit-content-step2-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#edit-content-step2').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.edit-content-step2-parent .select2-selection__rendered').show();
        jQuery('.edit-content-step2-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#edit-content-step2 option:eq(2)').val());


    // step2 dropdowns

    $('#input-type-step2').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type-step2-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type-step2-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type-step2-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type-step2-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type-step2-parent .select2-dropdown').hide();
        jQuery('.input-type-step2-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type-step2-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type-step2-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type-step2').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type-step2-parent .select2-selection__rendered').show();
        jQuery('.input-type-step2-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type-step2 option:eq(1)').val());


    $('#input-type1-step2').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type1-step2-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type1-step2-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type1-step2-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type1-step2-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type1-step2-parent .select2-dropdown').hide();
        jQuery('.input-type1-step2-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type1-step2-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type1-step2-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type1-step2').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type1-step2-parent .select2-selection__rendered').show();
        jQuery('.input-type1-step2-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type1-step2 option:eq(2)').val());

    $('#input-type2-step2').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type2-step2-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type2-step2-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type2-step2-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type2-step2-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type2-step2-parent .select2-dropdown').hide();
        jQuery('.input-type2-step2-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type2-step2-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type2-step2-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type2-step2').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type2-step2-parent .select2-selection__rendered').show();
        jQuery('.input-type2-step2-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type2-step2 option:eq(3)').val());


    $('#contact-variation-step2').select2({
        data: contact_variation,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.contact-variation-step2-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.contact-variation-step2-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.contact-variation-step2-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.contact-variation-step2-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.contact-variation-step2-parent .select2-dropdown').hide();
        jQuery('.contact-variation-step2-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.contact-variation-step2-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.contact-variation-step2-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#contact-variation-step2').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.contact-variation-step2-parent .select2-selection__rendered').show();
        jQuery('.contact-variation-step2-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#contact-variation-step2 option:eq(1)').val());


    // step3 dropdowns

    $('#edit-content-step3').select2({
        data: edit_content,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.edit-content-step3-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.edit-content-step3-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.edit-content-step3-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.edit-content-step3-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.edit-content-step3-parent .select2-dropdown').hide();
        jQuery('.edit-content-step3-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.edit-content-step3-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.edit-content-step3-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#edit-content-step3').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.edit-content-step3-parent .select2-selection__rendered').show();
        jQuery('.edit-content-step3-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#edit-content-step3 option:eq(1)').val());

    $('#input-type-step3').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type-step3-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type-step3-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type-step3-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type-step3-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type-step3-parent .select2-dropdown').hide();
        jQuery('.input-type-step3-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type-step3-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type-step3-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type-step3').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type-step3-parent .select2-selection__rendered').show();
        jQuery('.input-type-step3-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type-step3 option:eq(1)').val());


    $('#input-type1-step3').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type1-step3-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type1-step3-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type1-step3-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type1-step3-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type1-step3-parent .select2-dropdown').hide();
        jQuery('.input-type1-step3-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type1-step3-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type1-step3-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type1-step3').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type1-step3-parent .select2-selection__rendered').show();
        jQuery('.input-type1-step3-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type1-step3 option:eq(2)').val());

    $('#input-type2-step3').select2({
        data: input_type,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.input-type2-step3-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.input-type2-step3-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.input-type2-step3-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.input-type2-step3-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.input-type2-step3-parent .select2-dropdown').hide();
        jQuery('.input-type2-step3-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.input-type2-step3-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.input-type2-step3-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#input-type2-step3').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.input-type2-step3-parent .select2-selection__rendered').show();
        jQuery('.input-type2-step3-parent .select2-results__options').css('pointer-events', 'none');
    }).on('select2:select', function () {
        // console.info($(this).html(' '))
    }).select2('val', $('#input-type2-step3 option:eq(3)').val());


    $('#contact-variation-step3').select2({
        data: contact_variation,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.contact-variation-step3-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        console.info("onChange")
    }).on('select2:openning', function() {
        jQuery('.contact-variation-step3-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.contact-variation-step3-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.contact-variation-step3-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.contact-variation-step3-parent .select2-dropdown').hide();
        jQuery('.contact-variation-step3-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.contact-variation-step3-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.contact-variation-step3-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#contact-variation-step3').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.contact-variation-step3-parent .select2-selection__rendered').show();
        jQuery('.contact-variation-step3-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#contact-variation-step3 option:eq(1)').val());

    // funnel builder address

    $('#edit-content-address').select2({
        data: edit_addressContent,
        width: '100%',
        minimumResultsForSearch: -1,
        dropdownParent: $('.edit-content-address-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); },
    }).on('change',function () {
        var $this = $(this).val();
        if($this == 1) {
            $('.fb-address-first-step').show();
            $('.fb-address-second-step').hide();
        }else {
            $('.fb-address-first-step').hide();
            $('.fb-address-second-step').show();
        }
    }).on('select2:openning', function() {
        jQuery('.edit-content-address-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.edit-content-address-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.edit-content-address-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.edit-content-address-parent .select2-dropdown').hide();
        jQuery('.edit-content-address-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.edit-content-address-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!selectclosing) {
            e.preventDefault();
            selectclosing = true;
            jQuery('.edit-content-address-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#edit-content-address').select2("close");
            }, 200);
        } else {
            selectclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.edit-content-address-parent .select2-selection__rendered').show();
        jQuery('.edit-content-address-parent .select2-results__options').css('pointer-events', 'none');
    }).select2('val', $('#contact-variation-step3 option:eq(1)').val());


    $('[name="address_required"]').change(function(){
        if ($(this).is(':checked')) {
            $('.edit-content-address-parent').tooltipster('disable');
            $('.edit-content-address-parent').removeClass('select2-parent_disabled');
        }else {
            $('.edit-content-address-parent').tooltipster('enable');
            $('.edit-content-address-parent').addClass('select2-parent_disabled');
        }
    });

    $('.select2js__opener').click(function (e){
        e.preventDefault()
        if(jQuery(this).parent('.select2js').hasClass('slide-active')) {
            jQuery(this).parent('.select2js').removeClass('slide-active');
        }
        else {
            jQuery('.select2js').removeClass('slide-active');
            jQuery(this).parent('.select2js').addClass('slide-active');
        }
    });

    $('.select2js__slide__label').click(function (e){
        e.preventDefault();
        jQuery(this).parents('.select2js').toggleClass('slide-active');
    });

    $(document).click(function (e) {
        if (!$(e.target).hasClass("select2js__opener") && $(e.target).parents(".select2js__slide__body-area").length === 0) {
            $(".select2js").removeClass('slide-active');
        }
    });


    // hidden fields

    $(document).on('change','#fb-checkbox__input',function () {
        if ($(this).is(':checked')) {
            $('.hidden-parameter').slideDown()
        }else {
            $('.hidden-parameter').slideUp()
        }
    });

    $('.select2js__slide__label').click(function (e){
        e.preventDefault();
        jQuery(this).parents('.select2js').toggleClass('slide-active');
    });

    $('#addinputbutton').click(function (e){
        e.preventDefault();
        if($("#input2").css("display") == "block"){

            if($("#input3").css("display") == "none"){
                $("#input3").css("display", "block");
                $("#inputlabel3").text("input 3");
                $("#inputlabel2").text("input 2");
            }
        }else {
            $("#input2").css("display", "block");
            $("#inputlabel3").text("input 3");
        }

        if($("#input2").css("display") == "block" && $("#input3").css("display") == "block" ){
            $("#addinputbutton").css("display", "none");
        }
        if($("#input2").css("display") == "block" || $("#input3").css("display") == "block" ){
            $("#organizebutton").css("display", "block");
        }
    });
    $('#hideinputbutton2').click(function (e){
        e.preventDefault();
        $("#input2").css("display", "none");
        $("#addinputbutton").css("display", "block");
        $("#organizebutton").css("display", "none");
        if($("#input2").css("display") == "none" && $("#input3").css("display") == "block"){
            $("#inputlabel3").text("input 2");
        }
    });
    $('#hideinputbutton3').click(function (e){
        e.preventDefault();
        $("#input3").css("display", "none");
        $("#addinputbutton").css("display", "block");
    });

    // sort dragged questions by holding mouse
    //$('.lp-control__link_cursor_move').css('cursor', 'default');
    $(document).on('mousedown', '.single-question-slide', function(event) {
        //attack code
        console.log("drag activated");
        $( ".funnel-panel__sortable" ).sortable( "option", "delay", 800 );
        setTimeout(function(){
            $('.lp-control__link_cursor_move').css('cursor', 'move');
        }, 800);
    });
    $(document).on('mouseup', '.single-question-slide', function(event) {
        //attack code
        $('.lp-control__link_cursor_move').css('cursor', 'default');
    });
    $(document).on('mouseleave', '.single-question-slide', function(event) {
        //attack code
        $('.lp-control__link_cursor_move').css('cursor', 'default');
    });


});

$(document).on('keyup',"#icon-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    if(rgb) {
        var value = $('.icon-clr .color-opacity').val();
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#clr-icon .last-selected__code').text($(this).val());
        $("#icon-clr").ColorPickerSetColor($(this).val());
    }
});

$(document).on('keyup',"#fb-icon-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    if(rgb) {
        var value = $('.fb-icon-clr .color-opacity').val();
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".fb-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".fb-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".fb-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#fb-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#fb-clr-icon .last-selected__code').text($(this).val());
        $("#fb-icon-clr").ColorPickerSetColor($(this).val());
    }
});

$(document).on('keyup',"#cta-icon-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    if(rgb) {
        var value = $('.cta-icon-clr .color-opacity').val();
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".cta-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".cta-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".cta-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#cta-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#cta-clr-icon .last-selected__code').text($(this).val());
        $("#cta-icon-clr").ColorPickerSetColor($(this).val());
    }
});

$(document).on('keyup',"#dropdown-icon-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    if(rgb) {
        var value = $('.dropdown-icon-clr .color-opacity').val();
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".dropdown-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".dropdown-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".dropdown-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#dropdown-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#dropdown-clr-icon .last-selected__code').text($(this).val());
        $("#dropdown-icon-clr").ColorPickerSetColor($(this).val());
    }
});

$(document).on('keyup',"#textfield-icon-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    if(rgb) {
        var value = $('.textfield-icon-clr .color-opacity').val();
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".textfield-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".textfield-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".textfield-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#textfield-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#textfield-clr-icon .last-selected__code').text($(this).val());
        $("#textfield-icon-clr").ColorPickerSetColor($(this).val());
    }
});

$(document).on('keyup',"#textfield-large-icon-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    if(rgb) {
        var value = $('.textfield-large-icon-clr .color-opacity').val();
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".textfield-large-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".textfield-large-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".textfield-large-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('#textfield-large-clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
        $('#textfield-large-clr-icon .last-selected__code').text($(this).val());
        $("#textfield-large-icon-clr").ColorPickerSetColor($(this).val());
    }
});

function deleteDiv(ele){
    // event.preventDefault();
    $(ele).parents(".slide").remove();
    var a = document.getElementsByClassName("slide")
    if(a[0]) {
        console.log(a[0]);
    }else {
        $(".funnel-panel__placeholder").removeAttr("style");
    }
}

var obj  = {
    'dd_selector':'.conditional-logic-if',
    'dd_cl_state':'.conditional-logic-state',
    'dd_cl_do':'.conditional-logic-do',
    'question':{
        'what is your name?':'what is your name?',
        'what is your name2?':'what is your name1?',
        'what is your name3?':'what is your name2?',
        'what is your name4?':'what is your name3?',
        'what is your name5?':'what is your name4?',
        'what is your name6?':'what is your name5?',
        'what is your name7?':'what is your name6?'
    },
    render_dropdown:function(){
        var $options = $();
        $options = $options.add($('<option>').attr('value', '').html('Select Question'));
        $.each(obj.question , function (index , value) {
            $options = $options.add(
                $('<option>').attr('value', index).html(value)
            );
        });
        $(obj.dd_selector).html($options).trigger('change');
    },
    toggle_dropdown:function(selector){
        if($(this).val() != ''){
            $(this).parents('.cl-grid').find(selector).removeClass('cl-field_disabled');
        }else{
            $(this).parents('.cl-grid').find(selector).addClass('cl-field_disabled');
        }
    },
    init:function(){
        obj.render_dropdown();
        $(document).on('change' , obj.dd_selector , function () {
            obj.toggle_dropdown.call(this , '.cl-field_state');
        });
        $(document).on('change' , obj.dd_cl_state , function(){
            obj.toggle_dropdown.call(this , '.cl-field_value');
        });
        $(document).on('change' , obj.dd_cl_do , function(){
            obj.toggle_dropdown.call(this , '.cl-field_field');
        });
    }
}


var fbselectArr = [
    {
        element : 'fb-select-1',
        wrap : 'fb-select-wrap-1'
    },
    {
        element : 'fb-select-2',
        wrap : 'fb-select-wrap-2'
    },
    {
        element : 'fb-select-3',
        wrap : 'fb-select-wrap-3'
    },
    {
        element : 'fb-select-4',
        wrap : 'fb-select-wrap-4'
    },
    {
        element : 'fb-select-5',
        wrap : 'fb-select-wrap-5'
    }
]
