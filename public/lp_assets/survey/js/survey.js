var _om_count =  0;   // offline and online marketing flags
var _offm_count = 0;
var progress = 0;
var isCtrl = false;
var isSync = true;
var _isCheck = false;
var _isCheck_last = false;
var pf = 0;


var survey = {
    '0': {'item': 'step1', 'type': 1, 'state': 'survey-overlay__btn'},
    '1': {'item': 'step2', 'type': 2, 'state': 'os-checkbox_first'},
    '2': {'item': 'step3', 'type': 2, 'state': 'os-checkbox_first'},
    '3': {'item': 'step4', 'type': 3, 'state': 'survey-overlay__btn'},
    '4': {'item': 'step5', 'type': 4, 'state': 'os-select__option_first'},
    '5': {'item': 'step6', 'type': 5, 'state': 'os-radio__focus'},
    '6': {'item': 'step7', 'type': 5, 'state': 'os-radio__focus'},
    '7': {'item': 'step8', 'type': 4, 'state': 'os-select__option_first'},
    '8': {'item': 'step9', 'type': 4, 'state': 'os-select__option_first'},
    '9': {'item': 'step10', 'type': 1, 'state': 'survey-overlay__btn'},
};
var current_step = {
    'item' : 'step1',
    'type' : 1,
    'state': 'survey-overlay__btn'
};
var summary = {
    'online_marketing':'N/A',
    'offline_marketing':'N/A',
    'monthly_marketing_budget':'N/A',
    'lead_management_system':'N/A',
    'website_url':'N/A',
    'landing_page_url':'N/A',
    'average_loans_closed_monthly':'N/A',
    'goal_loans_closed_monthly':'N/A'
};
if(site.items) {
    $('html').addClass('en-survey');
}
$(document).ready(function(){

    init();

    $('.temp-close').click(function(){

        $('.survey-overlay').hide();
    });
    $('#os-slider').bootstrapSlider({
        formatter: function(value) {
            summary.monthly_marketing_budget = value;
            var val = value;
            if(value == 50000){
                val = '50k +';
            }
            $('.lp-step4__price-label').text('$'+val);
            $(".lp-step4__price-label").digits();
            return  value;
        },
        step: 500,
        min: 0,
        max: 50000,
        value: 0
    });
    var _owl = $('.survey-overlay__inner');
    var resize_owl = _owl.owlCarousel({
        items: 1,
        loop: false,
        autoHeight:true,
        pause: "true",
        margin:60,
        touchDrag: false,
        mouseDrag: false,
        responsiveBaseElement: '.survey-overlay__inner',
    });
    $('body').on('click' , '.os-continue' , function (e) {
        e.preventDefault();
        progress_dragger();
        generate_summary();
        $('.os-progress-bar').fadeIn('fast');
        if(current_step.type == 2){
            set_state('survey-overlay__btn');
        }
        _owl.trigger('next.owl.carousel');
        get_state();
        // $(this).closest('.owl-item').next().focus();
        check_back_button($(this));
    });
    $('body').on('click' , '.survey-overlay__btn_back' , function(){
        progress--;
        var w = progress*11;
        $('.os-progress-bar__dragger').css({'width':w+'%'});
        if(progress == 0){
            $('.os-progress-bar').fadeOut();
        }
        _owl.trigger('prev.owl.carousel');
        get_prev_state();
    });
    _owl.on('changed.owl.carousel', function(event) {
        // console.info('changed index:' + event.item.index );
        if(event.item.index == 0){
            $('#os-prv').hide();
        }
        if(event.item.index == 7){
            _isCheck = false;
        }
        pf =  event.item.index;
        current_step.item = survey[pf].item;
        current_step.type = survey[pf].type;
        current_step.state = survey[pf].state;
    });
    _owl.on('change.owl.carousel', function(event) {
        if(event.item == undefined){
            return;
        }
        if(event.item.index == 5){
            _isCheck = false;
        }
        if(event.item.index == 9){
            _isCheck_last = false;
        }
    });
    $('.survey-overlay__items').each(function(){
        $(this).attr('tabindex' , 0);
    });
    $('.os-checkbox input[type="checkbox"]').click(function(){
        var checkBoxId = $(this).attr("id");
        if($(this).prop("checked") == true){
            $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
            if(checkBoxId == 14){
                $('.os-checkbox input[name="online_marketing[]"]').prop('checked' , false);
                $(this).prop("checked",true);
                $(".lp-step2 .os-checkbox").removeClass('os-checkbox_checked')
                $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
            } else {
                $('.os-checkbox input[name="online_marketing[]"]#14').prop('checked' , false);
                $('.os-checkbox input[name="online_marketing[]"]#14').closest('.os-checkbox').removeClass('os-checkbox_checked');
            }
        }else{
            $(this).closest('.os-checkbox').removeClass('os-checkbox_checked');
        }
    });

    $('.os-radio input[type="radio"]').click(function(){
        if($(this).prop("checked") == true){
            $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
        }else{
            $(this).closest('.os-checkbox').removeClass('os-checkbox_checked');
        }
    });

    // Step2
    $('.lp-step1 .survey-overlay__btn').on('keydown , keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            event.preventDefault();
        }

    });

    $('.lp-step2 .survey-overlay__btn').on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            $('.lp-step2').find('.os-checkbox:first-child').focus();
        }

    });

    $('.os-checkbox input[name="online_marketing[]"]').on('click' , function(event){

        if($(this).prop("checked") == true){
            _om_count++;
            $('.lp-step2 .survey-overlay__btn').removeClass('disabled').addClass('os-continue');
        }else{
            _om_count--;
            if(_om_count == 0){
                $('.lp-step2 .survey-overlay__btn').removeClass('os-continue').addClass('disabled');
            }
        }
    });
    $('.lp-step2 .os-checkbox').on('keypress' , function(event){
        var checkBoxId = $(this).find('input').attr("id");
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13){
            if(checkBoxId == 14){
                $('.os-checkbox input[name="online_marketing[]"]').prop('checked' , false);
                $(this).prop("checked",true);
                $(".lp-step2 .os-checkbox").removeClass('os-checkbox_checked')
                $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
            } else {
                $('.os-checkbox input[name="online_marketing[]"]#14').prop('checked' , false);
                $('.os-checkbox input[name="online_marketing[]"]#14').closest('.os-checkbox').removeClass('os-checkbox_checked');
            }
            if($(this).find('input').prop("checked") == true){

                _om_count--;
                $(this).find('input').prop("checked" , false);
                $(this).removeClass('os-checkbox_checked');
                if(_om_count == 0){
                    $('.lp-step2 .survey-overlay__btn').removeClass('os-continue').addClass('disabled');
                }
            }else{
                _om_count++;
                $(this).find('input').prop("checked" , true);
                $(this).addClass('os-checkbox_checked');
                $('.lp-step2 .survey-overlay__btn').removeClass('disabled').addClass('os-continue');

            }
           // $(this).find('input').prop('checked' , true);
        }
    });

    // Step3
    $('.lp-step3 .survey-overlay__btn').on('keydown , keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            $('.lp-step3').find('.os-checkbox:first-child').focus();
            return;
        }
        if(keyCode == 13) {
            setTimeout(function(){
                $('#item3').focus();
            } , 300);
        }
    });
    $('.os-checkbox input[name="offline_marketing[]"]').click(function(){
        var checkBoxId = $(this).attr("id");
        if(checkBoxId == "om12"){
            $('.os-checkbox input[name="offline_marketing[]"]').prop('checked' , false);
            $(this).prop("checked",true);
            $(".lp-step3 .os-checkbox").removeClass('os-checkbox_checked')
            $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
        } else {
            $('.os-checkbox input[name="offline_marketing[]"]#om12').prop('checked' , false);
            $('.os-checkbox input[name="offline_marketing[]"]#om12').closest('.os-checkbox').removeClass('os-checkbox_checked');
        }
        if($(this).prop("checked") == true){
            _offm_count++;
            $('.lp-step3 .survey-overlay__btn').removeClass('disabled').addClass('os-continue');
        }else{
            _offm_count--;
            if(_offm_count == 0){
                $('.lp-step3 .survey-overlay__btn').removeClass('os-continue').addClass('disabled');
            }
        }
    });
    $('.lp-step3 .os-checkbox').on('keypress' , function(event){
        var checkBoxId = $(this).find('input').attr("id");
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13){
            if(checkBoxId == "om12"){
                $('.os-checkbox input[name="offline_marketing[]"]').prop('checked' , false);
                $(this).prop("checked",true);
                $(".lp-step3 .os-checkbox").removeClass('os-checkbox_checked')
                $(this).closest('.os-checkbox').addClass('os-checkbox_checked');
            } else {
                $('.os-checkbox input[name="offline_marketing[]"]#om12').prop('checked' , false);
                $('.os-checkbox input[name="offline_marketing[]"]#om12').closest('.os-checkbox').removeClass('os-checkbox_checked');
            }
            if($(this).find('input').prop("checked") == true){
                _offm_count--;
                $(this).find('input').prop("checked" , false);
                $(this).removeClass('os-checkbox_checked');
                if(_offm_count == 0){
                    $('.lp-step3 .survey-overlay__btn').removeClass('os-continue').addClass('disabled');
                }
            }else{
                _offm_count++;
                $(this).find('input').prop("checked" , true);
                $(this).addClass('os-checkbox_checked');
                $('.lp-step3 .survey-overlay__btn').removeClass('disabled').addClass('os-continue');

            }
            // $(this).find('input').prop('checked' , true);
        }
    });
    //step4

    $('.lp-step4 .survey-overlay__btn').on('keydown , keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            event.preventDefault();
        }
    });



    // Step5

        $('.lp-step5 .os-select__option').click(function(){
            if(_isCheck){return;}
            _isCheck = true;
            lp_options($(this), 'lp-step5' , '#leadms' , _owl);

        });

    $('.lp-step5 .os-select__option').on('keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13){
            if(_isCheck){return;}
            _isCheck = true;
            lp_options($(this), 'lp-step5' , '#leadms' , _owl);
        }
    });
    $('.lp-step5 .os-select__option.os-select__option_last').on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){ // tab
            event.preventDefault();
            $('.lp-step5 .os-select__option.os-select__option_first').focus();
        }
    });
    //    Step6
    $('.lp-step6 .os-radio input').click(function(){

        url_form($(this), 'lp-step6' , resize_owl , '#website-url');

    });
    $('.lp-step6 .os-radio').on('keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13) {
            $(this).find('input').prop('checked', true);
            url_form($(this).find('input'), 'lp-step6', resize_owl , '#website-url');
        }
    });
    // var abc = true;
    $('#website-url').on('keyup keypress' , function(event){
        check_url($(this) , 'lp-step6');
    });
    $('#website-url').on('keydown' , function(event){
        event.stopPropagation();
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13 && $('.lp-step6 .survey-overlay__btn').hasClass('os-continue')) {
            $('.lp-step6__btn').trigger('click');
        }

    });

    $('.lp-step6 .survey-overlay__btn').on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            event.preventDefault();
            $('.lp-step6 .os-radio:first-child').focus();
            // event.preventDefault();
        }
    });

    // Step 7

    $('.lp-step7 .os-radio input').click(function(){

        url_form($(this), 'lp-step7' , resize_owl , '#landing-page-url');
    });
    $('.lp-step7 .os-radio').on('keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13) {
            $(this).find('input').prop('checked', true);
            url_form($(this).find('input'), 'lp-step7' , resize_owl , '#landing-page-url');
        }
    });
    $('#landing-page-url').on('keyup keypress' , function(){
        check_url($(this) , 'lp-step7');
    });
    $('#landing-page-url').on('keydown' , function(event){
        event.stopPropagation();
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13 && $('.lp-step7 .survey-overlay__btn').hasClass('os-continue')) {
            $('.lp-step7__btn').trigger('click');
        }
    });
    $('.lp-step7 .survey-overlay__btn').on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            event.preventDefault();
            $('.lp-step7 .os-radio:first-child').focus();
            // event.preventDefault();
        }
    });

    // Step8
    $('.lp-step8 .os-select__option.os-select__option_last').on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            event.preventDefault();
            $('.lp-step8 .os-select__option.os-select__option_first').focus();
        }
    });
    $('.lp-step8 .os-select__option').click(function(e){
        // e.stopImmediatePropagation();
        if(_isCheck){return;}
        _isCheck = true;
        lp_options($(this), 'lp-step8' , '#loan-per-month' , _owl);
    });

    $('.lp-step8 .os-select__option').on('keypress' , function(event){
        // event.stopImmediatePropagation();
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13) {
            if(_isCheck){return;}
            _isCheck = true;
            lp_options($(this), 'lp-step8' , '#loan-per-month' , _owl);
        }
    });
    $(".skip-question").click(function () {
        setTimeout(function () {
            _owl.trigger('next.owl.carousel');
            progress_dragger();
        },300);
    });
    // Step9
    $('.lp-step9 .os-select__option.os-select__option_last').on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 9){
            event.preventDefault();
            $('.lp-step9 .os-select__option.os-select__option_first').focus();
        }
    });
    $('.lp-step9 .os-select__option').click(function(event){
        // event.stopImmediatePropagation();
        if(_isCheck_last){return;}
        _isCheck_last = true;
        lp_options($(this), 'lp-step9' , '#loan-close-each-month' , _owl);
    });
    $('.lp-step9 .os-select__option').on( 'keypress' , function(event){
        // event.stopImmediatePropagation();
        var keyCode = event.keyCode || event.which;
        if(keyCode == 13) {
            if(_isCheck_last){return;}
            _isCheck_last = true;
            lp_options($(this), 'lp-step9' , '#loan-close-each-month' , _owl);
        }
    });
    //step 10
    $('.lp-step10__btn').click(function(){
        $('.os-progress-bar__dragger').css({'width':'100%'});
        ajax_save();
    });


});

function init() {
    $(".os-select").mCustomScrollbar(
        {
            mouseWheel:{ scrollAmount: 300 },
            keyboard:{ enable: false },
            advanced:{ autoScrollOnFocus: "div" }
        }
    );
    $('.lp-step1').focus();
    $(document).on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 17) {
            isCtrl = true
        }
        if(keyCode == 89 && isCtrl){
            ajax_set_session();
            //$('.overlay_container').show();
            $('.survey-overlay').fadeOut();
            $("body").css({'overflow':'auto'});
        }
    });
    $(document).on('keyup' , function(event){
        var keyCode = event.keyCode || event.which;
        if(keyCode == 17) {
            isCtrl = false
        }
    });
    $(document).on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;

        if(keyCode == 8) {
            if (!$('input').is(":focus")) {
                event.preventDefault();
                $('.survey-overlay__btn_back').trigger('click');
                get_prev_state();
            }
        }
    });
    $.fn.digits = function(){
        return this.each(function(){
            $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
        })
    };


    $(".lp-step4__price-label").digits();
    setTimeout(function(){
        $('#main-loader.os-loader').hide();
        $('.survey-overlay__wrapper').css({'overflow':'auto'});
    },600);
    int_scrollbar();
    $(window).resize(function(){
        int_scrollbar();
    });

    $(document).on('keypress' , function(event){
        var keyCode = event.keyCode || event.which;
        var focused = $(':focus');
        if(keyCode == 13 && current_step.type == 1 && !focused.hasClass('btn')) {
            $('.lp-'+current_step.item+' .'+current_step.state).trigger('click');
        }
    });

    $('.os-checkbox').each(function(){
        $(this).attr('tabindex' , '0');
    });
    $('.os-select__option').each(function(){
        $(this).attr('tabindex' , '0');
    });
    $(document).on('keydown' , function(event){
        var keyCode = event.keyCode || event.which;
        if(current_step.type == 4){
            var focused = $(':focus');
            if(keyCode == 40 && !focused.hasClass('os-select__option_last')) {
                event.preventDefault();
                focused.next().focus();
            }
            if(keyCode == 38 && !focused.hasClass('os-select__option_first')){
                focused.prev().focus();
            }
        }
    });
}
function get_prev_state(){
    setTimeout(function(){
        if(current_step.type != 3){
            $('.lp-'+current_step.item+' .'+current_step.state).focus();
        }else{
            $('#item'+ pf).focus();
        }
    } , 300);
}
function get_state(){
    setTimeout(function () {
        if (current_step.type != 1 && current_step.type != 3) {
            $('.lp-' + current_step.item + ' .'+current_step.state).focus();
        }else{
            console.info('kas:'+pf);
            $('#item'+ pf).focus();
        }
    }, 300);
}

function set_state(state){
    survey[pf].state = state;
}
function lp_options(_this , prefix , input_selector , _owl ){
    $('.'+prefix+' .os-select__option').removeClass('os-select__option_selected');
    _this.addClass('os-select__option_selected');
    $(input_selector).val(_this.data('value'));
    generate_summary();
    set_state('os-select__option_selected');
    setTimeout(function () {
        _owl.trigger('next.owl.carousel');
        progress_dragger();
        get_state();
    },300);

}
function int_scrollbar(){
    if($(window).width() <= 767){
        $(".lp-step2__inner,.lp-step3__inner").mCustomScrollbar({mouseWheel:{scrollAmount: 300}});
    }
}
function ajax_save() {
    $('#inner-loader.os-loader').show();
    $('.overlay_container').show();
    $.ajax({
        type : "POST",
        url : "/lp/survey/index",
        data : {'value':summary,_token:ajax_token},
        success : function(data) {
            // $('.os-loader').hide();
            $('.survey-overlay').fadeOut(function(){
                $('html').removeClass('en-survey');
            });
        },
        cache : false,
        async : true
    });
}
function ajax_set_session() {
    $.ajax({
        type : "POST",
        url : "/lp/survey/setsurveysession",
        data : {'_token':ajax_token},
        success : function() {},
        cache : false,
        async : true
    });
}
function generate_summary() {
    var omlist = '';
    var ofmlist = '';
    // online marketing
    $('input[name="online_marketing[]"]:checked').each(function(){
        if(omlist == ''){
            omlist = $(this).val();
        }else{
            omlist = omlist+';'+$(this).val();
        }

    });
    $('input[name="offline_marketing[]"]:checked').each(function(){
        if(ofmlist == ''){
            ofmlist = $(this).val();
        }else{
            ofmlist = ofmlist+';'+$(this).val();
        }

    });
    summary.website_url = 'N/A';
    summary.landing_page_url = 'N/A';
    if($('input[name="website"]:checked').val() == 'yes'){
        summary.website_url = $('#website-url').val();
    }
    if($('input[name="landing_page"]:checked').val() == 'yes'){
        summary.landing_page_url = $('#landing-page-url').val();
    }
    summary.online_marketing = omlist;
    summary.offline_marketing = ofmlist;
    summary.lead_management_system = $('#leadms').val();
    summary.average_loans_closed_monthly = $('#loan-per-month').val();
    summary.goal_loans_closed_monthly= $('#loan-close-each-month').val();
    if(summary.average_loans_closed_monthly ==""){
        summary.average_loans_closed_monthly = "N/A"
    }
    summary.goal_loans_closed_monthly= $('#loan-close-each-month').val();
    if(summary.goal_loans_closed_monthly ==""){
        summary.goal_loans_closed_monthly = "N/A"
    }
    var summary_html =
        '<ul class="os-summary">\n' +
            '<li class="os-summary__items">Online Marketing: <span class="os-summary__bold"> '+summary.online_marketing+'</span></li>\n' +
            '<li class="os-summary__items">Offline Marketing:<span class="os-summary__bold"> '+summary.offline_marketing+'</span></li>\n' +
            '<li class="os-summary__items os-summary__items_budget">Monthly Marketing Budget:<span class="os-summary__bold"> '+$('.lp-step4__price-label').text()+'</span></li>\n' +
            '<li class="os-summary__items">Lead Management System or CRM:<span class="os-summary__bold"> '+summary.lead_management_system+'</span></li>\n' +
            '<li class="os-summary__items">Website URL:<span class="os-summary__bold"> '+summary.website_url+'</span></li>\n' +
            '<li class="os-summary__items">Landing Page URL:<span class="os-summary__bold"> '+summary.landing_page_url+'</span></li>\n' +
            '<li class="os-summary__items">Average Loans Closed Monthly:<span class="os-summary__bold"> '+summary.average_loans_closed_monthly+'</span></li>\n' +
            '<li class="os-summary__items">Goal Loans Closed Monthly:<span class="os-summary__bold"> '+summary.goal_loans_closed_monthly+'</span></li>\n' +
        '</ul>';
    // $('.os-summary__items_budget span').digits();
    $('.lp-step10__inner').html(summary_html);
}

function url_form(_this , _selector , resize_owl , _fselector){
    if(_this.val() == 'yes'){
        $('#'+_selector+'__form-group').fadeIn(function () {
            resize_owl.trigger('refresh.owl.carousel');
        });
        $('.'+_selector).css({'margin-top':'118px'});
        var __this = $('#'+_selector+'__form-group').find('input');
        check_url(__this , _selector);
        resize_owl.trigger('refresh.owl.carousel');
        $(_fselector).focus();
        set_state('survey-overlay__form-control');
    }else{
        $('.'+_selector+' .survey-overlay__btn').removeClass('disabled').addClass('os-continue');
        $('#'+_selector+'__form-group').slideUp(function(){
            resize_owl.trigger('refresh.owl.carousel');
        });
        $('.'+_selector).css({'margin-top':'220px'});
        set_state('survey-overlay__btn');
    }
}

function check_url(_this , _selector) {
    var $regexname = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
    if (!_this.val().match($regexname)) {
        if(_this.val() != ''){
            _this.addClass('error');
        }
        $('.'+_selector+' .survey-overlay__btn').removeClass('os-continue').addClass('disabled');
    }
    else {
        _this.removeClass('error');
        $('.'+_selector+' .survey-overlay__btn').removeClass('disabled').addClass('os-continue');
    }
}

function check_back_button(_this) {
    if (_this.index() == 0) {
        $('#os-prv').fadeOut();
    } else {
        $('#os-prv').fadeIn();
    }
}
function progress_dragger() {
    progress++;
    var w = progress*11;
    $('.os-progress-bar__dragger').css({'width':w+'%'});
}
