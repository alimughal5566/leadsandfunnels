var setting = {
    'sticky_cta': 'Do you know how much home you can afford?',
    'sticky_button' : 'Get Pre-Approved Now!',
    'sticky_url' : 'example.com',
    'sticky_js_file':'',
    'sticky_status' : '0',
    'pending_flag' : '0',
    'script_type' : 'a',
    'zindex' : '1000000',
    'zindex_type' : 1,
    'sticky_size':'f',
    'ratio':1

};
var update_form = false;
var token = '';
var element_id = '';
var active_flag = false;
var add_flag = true;
var data_id = 0;
var url_arr = '';
var previous_sticky_url = '';
var lp_stop = true;
var current_funnel_sticky_id = '';
/*
var inactive_funnel_url = '';
*/
var dublicate_website_url_flag = false;
var toggle_clicked = true;



function showstickybarpopup(_this) {
    $( "input[name='_token']" ).remove();
    $('#sticky-bar-form').append('<input type="hidden" name="_token" value="'+ajax_token+'">');
    var funnel_name = _this.attr("data-field");
    data_id = _this.attr("data-id");
    token = '';
    if(_this.data("v_sticky_button")!=""){
        setting.sticky_button = _this.data("v_sticky_button");
    }

    if(_this.data("v_sticky_cta")!=""){
        var onloaad_cat_text = _this.data("v_sticky_cta");
        console.info($('<div>'+onloaad_cat_text+'</div>').text());
        setting.sticky_cta = _this.data("v_sticky_cta");
    }


    set_default_value(setting);

    if(setting.zindex_type != 2){
        $('#bs-slider-bar').bootstrapSlider('refresh');
        $('#zindex-label').text(1);
    }

    // $('.lp-sticky-bar__toggle div').removeClass('btn-success on').addClass('btn-danger off');
    $('#toggle-status').bootstrapToggle('off');
    element_id = '#'+_this.attr('data-element_id');
    var pending = 0;

    $('.lp-sticky-bar__note').text('');

    if(_this.attr('data-sticky_cta') != '') {
        token = hash = _this.attr('data-sticky_js_file');
        current_funnel_sticky_id = _this.attr('data-sticky_id');
        console.log(_this);
        var obj = {
            "sticky_cta" : _this.attr('data-sticky_cta'),
            "sticky_cta_text" : $('<span>' + _this.attr('data-sticky_cta') + '</span>').text(),
            "sticky_button" : _this.attr('data-sticky_button'),
            "sticky_url" : _this.attr('data-sticky_url'),
            "sticky_status" : _this.attr('data-sticky_status'),
            "script_type" : _this.attr('data-sticky_script_type'),
            "zindex" : _this.attr('data-sticky_zindex'),
            "zindex_type" : _this.attr('data-sticky_zindex_type'),
            "sticky_size" : _this.attr('data-sticky_size'),
            "sticky_js_file" : hash
        };
        var pending = _this.attr('data-pending_flag');
        // if(pending != 0 && obj.sticky_status != 0){
        //     $('.lp-sticky-bar__note').text('(Installed Successfully)');
        // }
        if(obj.script_type == 'f'){
            $('#switch-script').prop('checked' , true);
            $('.code-switch__caption').text('View Code without Script Tags'); //with
        }
        if(obj.sticky_status != 0){
            $('#toggle-status').bootstrapToggle('on');
            // $('.lp-sticky-bar__toggle div').removeClass('btn-danger off').addClass('btn-success');
            if(pending != 0){
                $(".lp-sticky-bar__note").text('(Installed Successfully)').show();
            }else{
                $(".lp-sticky-bar__note").text('(Pending Installation)').show();
            }
        }else{
            // hide
            if(pending != 0){
                $(".lp-sticky-bar__note").text('(Pending Installation)').show();
            }else{
                $(".lp-sticky-bar__note").hide();
            }
        }
        var cta_title_phone_number = _this.attr('data-sticky_phone_number');
        $('#cta_title_phone_number').val(cta_title_phone_number);
        var phone_number_checked = _this.attr('data-sticky_phone_number_checked');
        if(phone_number_checked == "1"){
            $('#phone-number_checker').prop('checked',true);
            $("#cta_title_phone_number").inputmask({"mask": "(999) 999-9999"});
            $('.lp-sticky-bar__form-group_phone-number').slideDown();
            $('.lp-sticky-bar__form-group_phone-number').addClass('lp-sticky-bar__form-group_phone-number_show');
        }else {
            $('#phone-number_checker').prop('checked',false);
            $('.lp-sticky-bar__form-group_phone-number').slideUp();
            $('.lp-sticky-bar__form-group_phone-number').removeClass('lp-sticky-bar__form-group_phone-number_show');
        }



        set_default_value(obj);

        //    sticky specific pages path

        var pages_flag = _this.attr('data-sticky_website_flag');
        $('#all_pages').prop('checked' , true);
        $('.lp-sticky-bar_page').hide();
        if(pages_flag == 0){
            $('#specific_pages').prop('checked' , true);
            $('.lp-sticky-bar_page').show();
        }
        var sticky_location = _this.attr('data-sticky_location');
        $("#pin_flag_top").prop('checked' , true);
        $('.leadpops-wrap').removeClass('sticky-position-bottom');
        if(sticky_location == 'b'){
            $("#pin_flag_bottom").prop('checked' , true);
            $('.leadpops-wrap').addClass('sticky-position-bottom');
        }

        var sticky_show_cta = _this.attr('data-sticky_show_cta');
        if(sticky_show_cta == '1'){
            $("#pin_cta_show").prop('checked' , true);
            $('.sticky-hide').show();
        }
        var sticky_size = _this.attr('data-sticky_size');
        if(sticky_size == 's'){
            $("#pin_size_slim").prop('checked' , true);
            $('.leadpops-wrap').removeClass('sticky-medium');
            $('.leadpops-wrap').addClass('sticky-slim');
            setting.ratio = 0.5;
        }else if(sticky_size == 'm'){
            $("#pin_size_medium").prop('checked' , true);
            $('.leadpops-wrap').removeClass('sticky-slim');
            $('.leadpops-wrap').addClass('sticky-medium');
            setting.ratio = 0.75;
        }else if(sticky_size == 'f'){
            $("#pin_size_full").prop('checked' , true);
            $('.leadpops-wrap').removeClass('sticky-slim sticky-medium');
            setting.ratio = 1;
        }
        specific_page_render();
        specific_page_validation();

    }
    if(token === ''){
        update_form = true;
    }
    previous_sticky_url = _this.attr("data-sticky_url");
    $("#mask").show();
    $("#stickybarurl").val(funnel_name);
    $("#stickybarname").val("");
    $("#stickybarbtnurl").val("");
    $(".lp-sticky-bar").attr("data-funnel", funnel_name);
    $('#client_leadpops_id').val(data_id);
    $('#pending_flag').val(pending);
    $('.sticky_bar_url').val(funnel_name);
    $(".lp-sticky-bar").addClass("hidden");
    setTimeout(function () {
        $(".lp-sticky-bar").removeClass("hidden").addClass("show");
        $('body').css('overflow', 'hidden');
        $("#mask").hide();
    }, 500);

    process_input();

}
function specific_page_render() {
    var pages_path = $(element_id).attr('data-sticky_page_path');
    var path_arr = pages_path.split("~");
    if(path_arr[0] == '/'){
        $('#sticky-home-page').prop('checked' , true);
        path_arr.splice(0 ,1);
    }
    for(var i = 0 ; i < path_arr.length; i++){
        // $('.lp-sticky-bar__form-control').val('google');
        var field = '<div class="lp-sticky-bar__form-group pb15 lp-sticky-bar_clone">\n' +
            '                    <div class="lp-sticky-bar__left">\n' +
            '                        <input type="text" id="pages" name="pages[]" class="form-control lp-sticky-bar__form-control" value="'+path_arr[i]+'"/>\n' +
            '                        <label id="" class="error sticky-page__error" for="" style="">This field is required.</label>\n' +
            '                    </div>\n' +
            '                    <div class="lp-sticky-bar__right">\n' +
            '                        <div class="lp-sticky-bar__confirmation">\n' +
            '                            <span class="lp-note">Delete Path?</span>\n' +
            '                            <a href="#" class="yes">Yes</a>\n' +
            '                            <a href="#" class="no">No</a>\n' +
            '                        </div>\n' +
            '                        <a href="#" id="remove" class="lp-sticky-bar__remove"><i class="fa fa-remove"></i></a>\n' +
            '                    </div>\n' +
            '                </div>';
        $('.add-more').before(field);
        // $('.copy input').val('');
    }
}
function specific_page_validation(){
    $('.lp-sticky-bar_clone input').on('blur',function(){
        // $(this).closest('.lp-sticky-bar_clone').next().find('input').focus();
        var url = $(this).val();
        var char = url.charAt(0);


        if(url != ''){
            // url = url.replace(/\/$/g,'');
            url = url.replace("\\", "");
            $(this).val(url);
            if(char !== '/' && char !== '?'){
                $(this).addClass('error');
                $(this).next().text('Please enter a valid url.').show();
            }
        }else{
            $(this).addClass('error');
            $(this).next().show();
        }

    });
}
function set_default_value(setting){

    $('.cta').html(setting.sticky_cta);
    $('.lp-cta-text').text(setting.sticky_button);
    $('.bar_title').val(setting.sticky_cta);
    if(setting.hasOwnProperty('sticky_cta_text')){
        $('.bar_title[name=bar_title_visible]').val(setting.sticky_cta_text);
    }
    $('#cta_title').val(setting.sticky_button);
    $('#cta_url').val(setting.sticky_url);
    $('#insert_flag').val(setting.sticky_js_file);
    $('#sticky_status').val(setting.sticky_status);
    $('#sticky_script_type').val(setting.script_type);
    $('#zindex').val(setting.zindex);
    $('.lp-popup-radio_zindex[value='+setting.zindex_type+']').trigger('change');
    $('.lp-popup-radio_zindex[value='+setting.zindex_type+']').prop('checked', true);
    if(setting.zindex_type == 2){
        $('#bs-slider-bar').bootstrapSlider('setValue', setting.zindex);
        $('#zindex-label').text(setting.zindex);
        $('#zindex-label').digits();
    }else if(setting.zindex_type == 3){
        $(".zindex-company").val(setting.zindex).trigger('change');
    }
    if(setting.sticky_size == 'f'){
        $('.leadpops-wrap').removeClass('sticky-slim sticky-medium');
        setting.ratio = 1;
    }
    $('.leadpops-wrap').removeClass('sticky-position-bottom');
    $("#pin_size_full").prop('checked' , true);
    $("#pin_cta_hide").prop('checked' , true);
    $('.sticky-hide').hide();
}
function get_sticky_status(obj) {
    var status = obj.sticky.sticky_status;
    $(element_id).attr('data-sticky_status' , obj.sticky.sticky_status);
    $(element_id).attr('data-pending_flag' , obj.sticky.pending_flag);
}
function update_attributes(obj){
    $(element_id).attr('data-sticky_cta' , obj.sticky.sticky_cta);
    $(element_id).attr('data-sticky_button' , obj.sticky.sticky_button);
    $(element_id).attr('data-sticky_url' , obj.sticky.sticky_url);
    $(element_id).attr('data-sticky_funnel_url' , obj.sticky.sticky_funnel_url);
    $(element_id).attr('data-sticky_js_file' , obj.hash);
    $(element_id).attr("data-sticky_website_flag",obj.sticky.sticky_website_flag);
    $(element_id).attr("data-sticky_page_path",obj.sticky.sticky_url_pathname);
    $(element_id).attr("data-sticky_location",obj.sticky.sticky_location);
    $(element_id).attr("data-sticky_script_type",obj.sticky.script_type);
    $(element_id).attr("data-sticky_zindex",obj.sticky.zindex);
    $(element_id).attr("data-sticky_zindex_type",obj.sticky.zindex_type);
    $(element_id).attr("data-sticky_show_cta",obj.sticky.show_cta);
    $(element_id).attr("data-sticky_phone_number",obj.sticky.stickybar_number);
    $(element_id).attr("data-sticky_phone_number_checked",obj.sticky.stickybar_number_flag);
    console.info(obj);
    get_sticky_status(obj);
}

function alert_message(msg , str){
    str = str || "success";
    var title = 'Success';
    if(str == 'danger'){
        title = 'Error';
    }
    var html = '<div class="alert alert-'+str+' lp-sticky-bar__alert">\n' +
        '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
        '  <strong>'+title+'! </strong>'+ msg +
        '</div>';
    $(".msg").html('');
    $(html).appendTo(".msg");
    $(".msg").slideUp(50);
    $("html, body").animate({ scrollTop: 0 }, "slow");
    $(".msg").slideDown(500).delay(5000).slideUp(500 , function(){
        $('.url-alert').remove();
        lp_stop = true;
    });
    /*$(html).hide().appendTo(".msg").slideDown(500).delay(30000).slideUp(5000 , function(){
        $(this).remove();
    });*/
}

function generate_code(url , type){
    type = type || 'a';
    if(type == 'a'){
        var script = '&lt!---------------leadPops Sticky Bar Code Starts Here---------------><br /><br />' +
            '&lt;script  type="text/javascript" src="'+url+'">&lt;/script>' + '<br /><br />' +
            '&lt!---------------leadPops Sticky Bar Code Ends Here--------------->';
        $('#copy_code').html(script);
    }else{
        var script ='\/* leadPops Sticky Bar Code Starts Here *\/'+'<br /><br />var lpsticky = document.createElement(\'script\');<br />' +
            'lpsticky.async = true;<br />' +
            'lpsticky.src=\''+ url + '\';<br />' +
            'var lpstickytag = document.getElementsByTagName(\'script\')[0];<br />' +
            'lpstickytag.parentNode.insertBefore(lpsticky , lpstickytag);<br /><br />'+'\/* leadPops Sticky Bar Code Ends Here *\/';
        $('#copy_code').html(script);
    }
}
function clearForm(form) {
    $(':input', form).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
        if (type == 'text' || type == 'hidden'|| type == 'password' || tag == 'textarea') {
            this.value = "";
        }else if (type == 'checkbox') {
            this.checked = false;
        }else if (tag == 'select') {
            this.selectedIndex = -1;
        }
    });
};

function setactiveinactiveflag(obj) {
    active_flag = false;
    // sticky_status();
    var st = obj.sticky.sticky_status; //$(element_id).attr('data-sticky_status');
    var pnd = obj.sticky.pending_flag; //$(element_id).attr('data-pending_flag');

    var _text = "";
    var innner_status_text='';
    if(st==0){
        // Inactive
        $(".lp-sticky-bar__note").hide();
        _text = "(Inactive)";
        $('#toggle-status').bootstrapToggle('off');
        $('#sticky_status').val(0);
    }else{
        if(pnd==0){
            // Pending Installation
            innner_status_text =    _text = "(Pending Installation)";
        }else{
            // Active
            innner_status_text = _text = "(Active)";
        }
        $(".lp-sticky-bar__note").show();
        $('#toggle-status').bootstrapToggle('on');
        $('#sticky_status').val(1);
    }
    $(element_id).find('.funnel-sticky-status').text(_text);
    $('.lp-sticky-bar__note').text(_text)
}
function closestickypopup() {
    $(".lp-sticky-bar").removeClass("show").removeAttr("data-funnel");
}
function hideUrlNotice() {
    $('.msg').slideUp(500,function(e){
        // $(this).html('').show();
        // $(this).html('')
        // $(this).hide();
        lp_stop = true;
    });
}

function checkfunneldomain(clicked,submit) {
    if($('#cta_url').val()  == 'example.com'){
        var message = 'Please change the domian example.com.';
        var html = '<div class="alert  alert-danger lp-sticky-bar__alert url-alert">\n' +
            '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '  <strong>Alert! </strong>'+ message +
            '</div>';
        $(".msg").html('');
        $(html).appendTo(".msg");
        $(".msg").slideUp(50);
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $(".msg").slideDown(500).delay(5000).slideUp(500 , function(){
            $('.url-alert').remove();
        });
        return false;
    }
    if($('#toggle-status').prop('checked') ==  false){
        var sticky_status_db = 0;
        if(($(element_id).attr("data-sticky_status") != 1) && clicked == 1){
            // check dublication
            sticky_status_db = 1;
        }else if(($(element_id).attr("data-sticky_status") != 1) && clicked == 0){
            // dont check dublication
            sticky_status_db = 0;
        }else if(($(element_id).attr("data-sticky_status") == 1) && clicked == 0){
            // check dublication
            sticky_status_db = 1;
        }else if(($(element_id).attr("data-sticky_status") == 1) && clicked == 1){
            // dont check dublication
            sticky_status_db = 0;
        }
        var all_pages_flag = $('#all_pages').prop('checked');
        var pages = '';
        lp_stop = true;
        $('.lp-sticky-bar__loader').show();
        var pages_length = $("input[name='pages[]']").length;
        if($('#sticky-home-page').prop('checked')){
            pages = '/';
        }
        for (var i = 1; i <= pages_length;i++ ){
            if($("input[name='pages[]']").eq(i).val() && $("input[name='pages[]']").eq(i).val() !== undefined && $("input[name='pages[]']").eq(i).val() != null ){
                pages = $("input[name='pages[]']").eq(i).val()+'~'+pages;
            }
        }
        $.ajax({
            type : "POST",
            url : "/lp/popadmin/checkfunneldomain",
            data : {'id': current_funnel_sticky_id, 'sticky_status_db':sticky_status_db,'domain': $('#cta_url').val(),'all_pages_flag':all_pages_flag,'pages':pages,'_token':ajax_token},
            success : function(data) {
                var obj = $.parseJSON(data);
                if(obj.status == 'error'){
                    var message = obj.message;
                    var html = '<div class="alert alert-success lp-sticky-bar__alert url-alert">\n' +
                        '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
                        '  <strong>Alert! </strong>'+ message +
                        '</div>';
                    $('#duplicate_url').val('1');
                    if(lp_stop){
                        $('.lp-sticky-bar__loader').hide();
                        lp_stop = false;
                        $('.url-alert').hide();
                        if(sticky_status_db == 1){
                            $('#toggle-status').bootstrapToggle('off');
                            $('#sticky_status').val(0);
                        }
                        dublicate_website_url_flag =true;
                        $(".msg").html('');
                        $(html).appendTo(".msg");
                        $(".msg").slideUp(50);
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $(".msg").slideDown(500).delay(5000).slideUp(500 , function(){
                            $('.url-alert').remove();
                            lp_stop = true;
                        });

                    }
                    return false;
                }else{
                    if(obj.status_flag  == 1){
                        $('#sticky_status').val(1);
                        $('#toggle-status').bootstrapToggle('on');
                    }else{
                        $('#sticky_status').val(0);
                        $('#toggle-status').bootstrapToggle('off');
                    }
                    toggle_clicked = false;
                    dublicate_website_url_flag = false;
                    $('.lp-sticky-bar__loader').hide();
                    hideUrlNotice();
                    $('#duplicate_url').val('0');
                    if(submit == 0){
                        $("#sticky-bar-form").submit();
                    }
                }
            },
            cache : false,
            async : false
        });
    }else{
        toggle_clicked = false;
        dublicate_website_url_flag = false;
        hideUrlNotice();
        $('#duplicate_url').val('0');
        $('#toggle-status').bootstrapToggle('off');
        $('#sticky_status').val(0);
        if(submit == 0){
            $("#sticky-bar-form").submit();
        }
    }

}

function ShowUrlNotice(_selector) {
    var url = _selector.val();
    url = url.replace(/^(?:https?:\/\/)?/i, "").split('/')[0];
    var message = 'URL you are adding is already set up with funnel "'+url_arr[url]+'"- after you save the previous funnel will become inactive. Remember to delete the code associated with "'+url_arr[url]+'" on your domain and replace it with the generated code.';
    var html = '<div class="alert alert-success lp-sticky-bar__alert url-alert">\n' +
        '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
        '  <strong>Alert! </strong>'+ message +
        '</div>';
    // $('[data-sticky_url="'+url+'"]').attr('data-sticky_website_flag');
    var radio_status = $('.sticky-radio:checked').val();
    if(url_arr[url] != undefined && radio_status != '' && url_arr[url] != $('.sticky_bar_url').val().toLowerCase()){
        $('#duplicate_url').val('1');
        if(lp_stop){
            lp_stop = false;
            $(".msg").html('');
            $(html).appendTo(".msg");
            $(".msg").slideUp(50);
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $(".msg").slideDown(500).delay(5000).slideUp(500 , function(){
                $('.url-alert').remove();
                lp_stop = true;
            });
        }
    }else{
        hideUrlNotice();
        $('#duplicate_url').val('0');
    }
}
$(window).on("load",function(){
    var result = $("body").innerHeight();

    var height = (result - 50)+'px';
    $('.lp-sticky-bar__outer').css({'height':height});
    $(".lp-sticky-bar__inner").mCustomScrollbar({
        axis:"y",
        autoExpandScrollbar: false,
        mouseWheel:{ scrollAmount: 300 }
    });
    $(".lp-sticky-bar__clone-wrap").mCustomScrollbar({
        axis:"y",
        autoExpandScrollbar: false,
        mouseWheel:{ scrollAmount: 300 }
    });

});
$(document).ready(function () {

    $.fn.digits = function(){
        return this.each(function(){
            $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
        })
    };


    $('.bar_title').blur(function phonenumber(inputtxt)
    {
        var phoneregex = /\(?([0-9]{3})\)?[-. ]?([0-9]{3}[-. ]?[0-9]{4})/;
        var sticky_bar_say = $('.bar_title').val();
        console.info(sticky_bar_say);
        var compares = sticky_bar_say.match(phoneregex);
        if (compares!= null ){
            var phone_number = compares[0];
            var hrf = " <a href='tel:"+phone_number+"'>"+ phone_number+"</a>";
            var cta_text=$('.bar_title').val().replace(/\(?([0-9]{3})\)?[-. ]?([0-9]{3}[-. ]?[0-9]{4})/g, hrf);
            $('.cta').html(cta_text);
            $('.bar_title_hidden').val(cta_text);
            // console.info($('.bar_title').val());
            var html  = "ksadhfkds jhfkjsad hfkjds fkjdsf <a href='#'>123.123.1234</a> kjhkjh";
            console.info($('<div>'+html+'</div>').text());

        }

    });

    $('#phone-number_checker').click(function() {
        update_form = true;
        if($(this).is(':checked')){
            $("#cta_title_phone_number").inputmask({"mask": "(999) 999-9999"});
            var phonenumber = $("#cta_title_phone_number").val();
            $('.lp-sticky-bar__form-group_phone-number').slideDown();
            $('.lp-sticky-bar__form-group_phone-number').addClass('lp-sticky-bar__form-group_phone-number_show');
            setTimeout(function(){
                owl.trigger('refresh.owl.carousel');
            },400)
        }
        else {
            $('.lp-sticky-bar__form-group_phone-number').slideUp(function () {
                $('.lp-sticky-bar__form-group_phone-number').removeClass('lp-sticky-bar__form-group_phone-number_show');
            });
            setTimeout(function(){
                owl.trigger('refresh.owl.carousel');
            },400)
        }
    });


    $('#advance-option-toggle').click(function (event) {
        event.preventDefault();
        $('.advance-option-box').slideToggle();
        $(this).find('i').toggleClass('rotate-icon');
        setTimeout(function(){
            owl.trigger('refresh.owl.carousel');
        },400)
    });

    if($('#s-url').length > 0){
        url_arr = $.parseJSON($('#s-url').val());
        // console.info(url_arr);
    }
    if(url_arr[$('#cta_url')] != undefined && radio_status != '') {
        $('#duplicate_url').val('1');
    }
    $('[name="cta_icon"]').click(function(){
        if($(this).val() == 0){
            $('.sticky-hide').hide();
        }else{
            $('.sticky-hide').show();
        }
    });
    $('[name="size"]').change(function () {
        if($(this).val() == 'f'){
            $('.leadpops-wrap').removeClass('sticky-slim sticky-medium');
            setting.ratio = 1;
        }else if($(this).val() == 'm'){
            $('.leadpops-wrap').removeClass('sticky-slim');
            $('.leadpops-wrap').addClass('sticky-medium');
            setting.ratio = 0.75; // 75%
        }else if($(this).val() == 's'){
            $('.leadpops-wrap').removeClass('sticky-medium');
            $('.leadpops-wrap').addClass('sticky-slim');
            setting.ratio = 0.5; // 50%
        }
        process_input();
    });
    $('[name="pin_flag"]').change(function () {
        $('.leadpops-wrap').removeClass('sticky-position-bottom');
        if($(this).val() == 'b'){
            $('.leadpops-wrap').addClass('sticky-position-bottom');
        }
    });
    $(".lp_instruction_box" ).on('click', function(){
        $('#instruction-modal').modal('show');
    });
    $(".stickyBarVideo" ).on('click', function(){
        $('#stickyBarVideo-modal').modal('show');
    });
    //    switch script tag
    $('#switch-script').change(function (e) {
        var hash = $(element_id).attr('data-sticky_js_file');
        $('.code-switch__caption').text('View Code without Script Tags');
        var val = 'a';
        if( $('#sticky_script_type').val() == 'a'){
            $('.code-switch__caption').text('View Code without Script Tags'); //with
            val = 'f';
        }else{
            val = 'a';
        }
        $('#sticky_script_type').val(val);
        $(element_id).attr("data-sticky_script_type",val);
        var file_name = 'https://dev2itclix.com/' +hash+".js";
        $('.lp-sticky-bar__loader').show();
        $.ajax({
            type : "POST",
            url : "/lp/popadmin/updatestickycodetype",
            data : {'value':val , 'client_leadpops_id':$('#client_leadpops_id').val(),'_token':ajax_token},
            success : function(data) {
                var obj = $.parseJSON(data);
                $('.lp-sticky-bar__loader').hide();
                if(obj.status == 'success'){
                    alert_message(obj.message);
                    generate_code(file_name , val);
                }else{
                    alert_message(obj.message);
                    $('#switch-script').prop('checked' , false);
                }
            },
            cache : false,
            async : false
        });
    });


    $('.lp-sticky-bar__video').click(function () {
        $('#lp-video-modal').modal('show');
    });
    $('#close-video-modal').click(function(){
        $(this).modal('hide');
    });
    $('#lp-video-modal').on('hidden.bs.modal', function (e) {
        var ele = $('#lp-video-modal .modal-title').text().split(':');
        if(ele[1].toLowerCase().replace(/ /g,'') == 'stickybar') {
          $('body').addClass('modal-open');
        }
    });
    $(window).resize(function(){
        var result = $("body").innerHeight();
        var height = (result - 50)+'px';
        $('.lp-sticky-bar__outer').css({'height':height});
        process_input();
    });
    var value = 0;
    $('.lp-sticky-bar__toggle').click(function(e){
       /* e.stopPropagation();
        active_flag = true;
        console.info($(this).find('#toggle-status').val());
        /!*return;*!/
        $("#sticky-bar-form").submit();*/
    });
    // $('#toggle-status').change(function(){

    //     if($(this).prop('checked')){
    //         value = 1;
    //         $('#sticky_status').val(value);
    //     }else{
    //         value = 0;
    //         $('#sticky_status').val(value);
    //     }
    //     $('.lp-sticky-bar__loader').show();
    //     $("#sticky-bar-form").submit();
    //     $.ajax({
    //         type : "POST",
    //         url : "/lp/popadmin/updatestickybarstatus",
    //         data : {'value':value , 'client_leadpops_id':$('#client_leadpops_id').val()},
    //         success : function(data) {
    //             var obj = $.parseJSON(data);
    //             $('.lp-sticky-bar__loader').hide();
    //             if(obj.status == 'success'){
    //                 alert_message(obj.message);
    //                 sticky_status();
    //                 var st = $(element_id).attr('data-sticky_status');
    //                 var pnd = $(element_id).attr('data-pending_flag');
    //                 if(st == 1 && pnd == 1){
    //                     $(element_id).find('.funnel-sticky-status').text('(Active)');
    //                 }else{
    //                     $(element_id).find('.funnel-sticky-status').text('(Pending)');
    //                 }
    //                 if(st == 1){
    //                     // show
    //                     $(".lp-sticky-bar__note").show();
    //                 }else{
    //                     // hide
    //                     $(".lp-sticky-bar__note").hide();
    //                 }
    //             }else{
    //                 alert_message(obj.message);
    //             }
    //
    //
    //         },
    //         cache : false,
    //         async : false
    //     });
    // });
    var owl = $('.owl-carousel');
    $(".sticky-bar-btn").click(function (e) {
        e.stopPropagation();
        if($(this).parents(".f-expand").hasClass("disable_lite_package")) {
            showLitePackageDisableAlert();
            return false;
        }

        var _this = $(this);
        showstickybarpopup(_this);
    });
    $(".sticky-bar-menu-link").click(function (e) {
        e.stopPropagation();
        var _this = $(this);
        showstickybarpopup(_this);
    });

    $("#close-sticky-bar").click(function () {
        closestickypopup();
        hideUrlNotice();
        owl.trigger('to.owl.carousel', [0, 300]);
        $('.advance-option-box').hide();
        var validator = $( "#sticky-bar-form" ).validate();
        validator.resetForm();
        $('#advance-option-toggle').find('.fa').removeClass('rotate-icon');
        $( "#sticky-bar-form input").removeClass('error');
        clearForm('#sticky-bar-form');
        $('.lp-sticky-bar__modal').css({
            'opacity': '0'
        });
        $('body').css({'overflow':''});
        $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').remove();
        $('#all_pages').prop('checked' , true);
        $('.lp-sticky-bar_page').hide();
        update_form = false;
    });
    $('.sticky-tooltip').tooltip();
    owl.owlCarousel({
        items: 1,
        loop: false,
        autoHeight:true,
        pause: "true",
        touchDrag: false,
        mouseDrag: false
    });
    owl.on('changed.owl.carousel', function(event) {
        $('.lp-sticky-bar__modal').css({
            'opacity': '1',
            'transition':'all 0.6s ease'
        });
        $('.lp-owl-dot').removeClass( 'active' );
        $('.lp-owl-dot').eq(event.item.index).addClass('active');
        var ln = ($('.owl-item').length)-1;
        $('#continue-sticky-bar').show();
        $('#copy-sticky-bar').hide();
        if(event.item.index == ln){
            $('#continue-sticky-bar').hide();
            $('#copy-sticky-bar').show();
            $('#copy-sticky-bar').focus();
        }
        if(event.item.index == 0){
            $('#prev-sticky-bar').hide();
        }
    });
    $('#prev-sticky-bar').click(function() {
        owl.trigger('prev.owl.carousel', [300]);
    });
    $( '.lp-owl-dot' ).on( 'click', function() {
        active_flag = false;
        if(update_form != true) {
            $file_name='';
            if(token != ''){
                $file_name = 'https://dev2itclix.com/' + token + '.js';
            }
            var lp_script_type = $('#sticky_script_type').val();
            generate_code($file_name, lp_script_type);
            owl.trigger('to.owl.carousel', [$(this).index(), 300]);
            $('.owl-dot').removeClass('active');
            $(this).addClass('active');
            if ($(this).index() == 0) {
                $('#prev-sticky-bar').hide();
            } else {
                $('#prev-sticky-bar').show();
            }
        }else{
            $("#sticky-bar-form").submit();
        }
    });
    $( ".bar_title" ).keyup(function() {
        update_form = true;
        $('.cta').text($(this).val());
        $('.bar_title_hidden').val($(this).val());
        process_input();
    });
    $('#cta_title').keyup(function(){
        update_form = true;
        $('.lp-cta-text').text($(this).val());
    });
    $('#cta_url').keyup(function(){
        update_form = true;
    });
    $('#continue-sticky-bar').click(function(){
        active_flag = false;
        if(update_form){
            $("#sticky-bar-form").submit();
        }else{
            hideUrlNotice();
            owl.trigger('next.owl.carousel', [300]);
            $file_name = '';
            if(token != ''){
                $file_name = 'https://dev2itclix.com/' + token + '.js';
            }
            var type = $('#sticky_script_type').val();
            generate_code($file_name , type);
            $('#prev-sticky-bar').show();
        }

    });
    var $form = $("#sticky-bar-form"),
        $successMsg = $(".alert");
    $.validator.addMethod("equals", function(value, element) {
        return this.optional(element) || value.match('^((?!example).)*$');
    }, "change the domain name.");
    $.validator.addMethod("phonenumber_digits", function(value, element) {
        value = value.replace(/\_/g, '');
        var length= value.length;
        if($('#phone-number_checker').is(':checked')){
            if(length == 14)
            {
                return true;
            }
        }
    }, "Please enter a valid phone number.");

    $.validator.addMethod("cus_url", function(value, element) {

        if(value.substr(0,7) != 'http://' && value.substr(0,8) != 'https://'){
            value = 'http://' + value;
        }
        if(value.substr(value.length-1, 1) != '/'){
            value = value + '/';
        }
        return this.optional(element) || /^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,10}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Not valid url.");
    $form.validate({
        rules: {
            bar_title_visible: {
                required: true
            },
            cta_title: {
                required: true
            },
            cta_title_phone_number:{
                required: true,
                phonenumber_digits:true
            },
            cta_url: {
                required: true,
                cus_url: true,
                equals: true
            },
            pages:{
                required: true
            }
        },
        messages: {
            bar_title_visible: {
                required: "This field is required."
            },
            cta_title: {
                required: "This field is required."
            },
            cta_url: {
                required: "This field is required.",
                cus_url: "Please enter a valid URL.",
                equals: 'Please change the "example" domain.'
            },
            pages: {
                required: "This field is required."
            }
        },
        submitHandler: function() {
            if(toggle_clicked != false){
                checkfunneldomain(0,1);
            }
            if(dublicate_website_url_flag == false){

                var old_url='';
                $('.lp-sticky-bar__loader').show();
                /*var old_url = $(element_id).attr('data-sticky_url');
                var new_url = $('#cta_url').val();
                if(old_url.toLowerCase() !== new_url.toLowerCase()){
                    // $('.lp-sticky-bar__note').text('(Pending Installation)');
                    $(element_id).find('.funnel-sticky-status').text('(Pending Installation)');
                    $(element_id).attr('data-pending_flag' , 0);
                    $('#pending_flag').val(0);
                }*/
                // $('#toggle-status').bootstrapToggle('on');
                /*var __this = $('#toggle-status');
                if(__this.prop('checked')){
                    value = 0;
                }else{
                    value = 1;
                }*/
                var form_data = $('#sticky-bar-form').serialize();
                $.ajax({
                    type : "POST",
                    url : "/lp/popadmin/savestickybar",
                    data : form_data,
                    success : function(data) {
                        var obj = $.parseJSON(data);
                        if(obj.status == 'success'){
                            $('#insert_flag').val(obj.hash);
                            token = obj.hash;
                            var file_name = 'https://dev2itclix.com/' + obj.hash+".js";
                            var type = $('#sticky_script_type').val();
                            generate_code(file_name , type);
                            // console.info(obj);
                            update_attributes(obj);
                            setactiveinactiveflag(obj);
                            owl.trigger('next.owl.carousel', [300]);
                            $('.lp-sticky-bar__loader').hide();
                            alert_message(obj.message);
                            $('#prev-sticky-bar').show();
                            update_form = false;
                            var radio_status = $('.sticky-radio:checked').val();
                            // var domain_specific_arr = url_arr[obj.sticky.sticky_url];
                            /*if(inactive_funnel_url != ''  && radio_status != ''){ // change the previous funnel status
                                $('[data-sticky_url="'+obj.sticky.sticky_url+'"]').not('[data-sticky_funnel_url="'+obj.sticky.sticky_funnel_url+'"]').attr('data-sticky_status' , '0');
                                $('[data-sticky_url="'+obj.sticky.sticky_url+'"]').not('[data-sticky_funnel_url="'+obj.sticky.sticky_funnel_url+'"]').find('.funnel-sticky-status').text('(Inactive)');
                                // $('[data-sticky_funnel_url="'+inactive_funnel_url+'"]').not('[data-sticky_funnel_url="'+obj.sticky.sticky_funnel_url+'"]').find('.funnel-sticky-status').text('(Inactive)');
                                // console.info('[data-sticky_funnel_url="'+url_arr[obj.sticky.sticky_url]+'"]');
                            }*/
                             url_arr[obj.sticky.sticky_url]=obj.sticky.sticky_funnel_url;
                             if(obj.sticky.sticky_url != previous_sticky_url){
                                 if(!$('[data-sticky_url="'+obj.sticky.sticky_url+'"]').length)
                                     delete url_arr[previous_sticky_url];
                                 previous_sticky_url = obj.sticky.sticky_url;
                             }
                            toggle_clicked = true;
                        }else{
                            $('.lp-sticky-bar__loader').hide();
                            alert_message(obj.message , 'danger');
                        }
                    },
                    cache : false,
                    async : false
                });
            }
        }
    });

    $('body').on('blur','#cta_url',function(){
        var url_str = $('#cta_url').val();
        var regex = /^((?:http:\/\/|https:\/\/|\/\/)?[^\r\n\t\f\v \/\:]+)/i;
        var match = url_str.match(regex);
        if(match){
            $('#cta_url').val(match[1]);
        }
        $(this).val($(this).val().replace(/\/$/, ''));
        lp_stop = true;
    });
    $('body').on('click','.lp-sticky-bar__toggle',function(e){
        e.preventDefault();
        checkfunneldomain(1,0);
        e.stopPropagation();
    });
    $('#cta_url').keypress(function(event){
        // e.preventDefault();
        var keyCode = event.keyCode || event.which;
        if (keyCode == 9) {
            event.preventDefault();
            $('#continue-sticky-bar').focus();
        }
    });


    function copyToClipboard(element) {
        var script_flag = $(element_id).attr("data-sticky_script_type");
        var $temp = $("<textarea>");
        var brRegex = /<br\s*[\/]?>/gi;
        if(script_flag == 'a'){
            var script = $(element).text().replace(brRegex, "\r\n");
        }else{
            var script = $(element).html().replace(brRegex, "\r\n");
        }
        $("body").append($temp);
        $temp.val($.trim(script)).select();
        document.execCommand("copy");
        $temp.remove();
    }
//    copy the code
    $('#copy-sticky-bar').click(function(){
        copyToClipboard($('#copy_code'));
        var html = '<div class="alert alert-success lp-sticky-bar__alert">\n' +
            '  <button type="button" class="close" data-dismiss="alert">&times;</button>\n' +
            '  <strong>Success:</strong> Sticky Bar code has been copied to the clipboard.' +
            '</div>';
        $(".msg").html('');
        $(html).appendTo(".msg");
        $(".msg").slideUp(50);
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $(".msg").slideDown(500).delay(5000).slideUp(500 , function(){
            $('.url-alert').remove();
        });
    });

    //  Manage specific Pages JS

    $('.sticky-radio').change(function(){
        update_form = true;
        if($(this).val() != '/'){
            hideUrlNotice();
            $('.lp-sticky-bar_page').show();
        }else{
            ShowUrlNotice($('#cta_url'));
            $('.lp-sticky-bar_page').hide();
        }
    });

    $('#cta_title_phone_number , #pin_flag_top, #pin_flag_bottom, #pin_size_full, #pin_size_slim, #pin_size_medium, #pin_cta_show, #pin_cta_hide').change(function(){
        update_form = true;
    });

    $('.lp-sticky-bar_page').on('click' , function(){
        $(window).resize();
        if($('#cta_url').val() != "example.com"){
            if(!$('#cta_url').hasClass('error')){
                var url_str = $('#cta_url').val();
                var regex = /^((?:http:\/\/|https:\/\/|\/\/)?[^\r\n\t\f\v \/\:]+)/i;
                var match = url_str.match(regex);
                if(match){
                    $('#cta_url').val(match[1]);
                }
                if($('#sticky-home-page').hasClass('sticky-home-page')){
                    $('#sticky-home-page').prop('checked' , true);
                }
                $('.lp-prefix').text($('#cta_url').val());
                $('.lp-prefix.lp-input-prefix').text($('#cta_url').val());
                $('.lp-sticky-bar__outer_pages').fadeIn('fast');
                $('.lp-sticky-bar__outer_builder').hide();
                add_flag = true;
            }
        }else{

            $('#cta_url').addClass('error');
            $('#cta_url').after('<label id="cta_url-error" class="error" for="cta_url">Please change the "example" domain.</label>');
        }

    });
    $('#sticky-home-page').change(function(){
        if($(this).prop('checked')){
            $(this).addClass('sticky-home-page');
        } else{
            $(this).removeClass('sticky-home-page');
        }
    });
    $('#close_sticky_page').click(function(){
        // $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').removeClass('db_remove');
        // $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').addClass('db_save');
        // $('.db_remove').remove();
        owl.trigger('to.owl.carousel', [0, 300]);
        $('.lp-sticky-bar__clone-wrap .db_remove').show().removeClass('db_remove');
        $('.lp-sticky-bar__clone-wrap .db_save').remove();
        $('.sticky-home-page').prop('checked' , false);
        $('#sticky-home-page').removeClass('.sticky-home-page');
        $('.lp-sticky-bar__outer_builder').fadeIn('fast');
        $('.lp-sticky-bar__outer_pages').fadeOut('fast');
    });
    $('.close-sticky-bar_pages').click(function(){
        // $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').removeClass('db_remove');
        // $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').addClass('db_save');
        // $('.db_remove').remove();

        $('.lp-sticky-bar__clone-wrap .db_remove').show().removeClass('db_remove');
        $('.lp-sticky-bar__clone-wrap .db_save').remove();
        $('.sticky-home-page').prop('checked' , false);
        $('#sticky-home-page').removeClass('.sticky-home-page');
        $('.lp-sticky-bar__outer_builder').fadeIn('fast');
        $('.lp-sticky-bar__outer_pages').fadeOut('fast');
        $("#close-sticky-bar").trigger('click');
    });
    $('body').on('click','#add', function(e){
        if(add_flag){
            var field = $('.copy').html();
            $('.add-more').before(field);
            add_flag = false;
        }else{
            $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone input').each(function(){
                if($(this).val() == ''){
                    $(this).addClass('error');
                    $(this).next().show();
                }
            });
        }

        // $(this).closest('.lp-sticky-bar_clone').clone()
        //        .find('input[type="text"]').val('').end()
        //        .insertAfter('.lp-sticky-bar_clone:last');
        $('.lp-sticky-bar_clone input').keyup(function(){
            if($(this).val() !== ''){
                url = $(this).val();
                var char = url.charAt(0);
                if(char == '/' || char == '?'){
                    add_flag = true;  // Prevent to add/save new element if it's false
                    $(this).removeClass('error');
                    $(this).next().text('This field is required.').hide();
                }
            }else{
                $(this).addClass('error');
                $(this).next().show();
            }
        });
        specific_page_validation();
    });
    $('body').on('click','#remove', function(e){
        __this = $(this);
        $(this).hide();
        $(this).prev().show();
        $('.yes').on('click',function(){
            add_flag = true;
            __this.closest('.lp-sticky-bar_clone').addClass('db_remove');
            // __this.closest('.lp-sticky-bar_clone').removeClass('db_save');
            __this.closest('.lp-sticky-bar_clone').slideUp(function(){
                // $(this).remove();
            });
            __this.prev().hide();
            __this.show();
        });
        $('.no').on('click',function(){
            __this.prev().hide();
            __this.show();
        });
    });
    $('#save-sticky-bar_page').click(function(){
        update_form = true;
        $('.db_remove').remove();
        if(add_flag){
            // Inactive the status when user save the specific page url

            /* if($(element_id).attr("data-sticky_website_flag") == '1' && $('#sticky_status').val() == '1'){
                 var pending = $(element_id).attr('data-pending_flag');
                 $('#sticky_status').val('0');
                 $('#toggle-status').bootstrapToggle('off');
                 $(".lp-sticky-bar__note").text('(Pending Installation)').show();
                 if(pending != 1){
                     $(".lp-sticky-bar__note").hide();
                 }

                 $(element_id).find('.funnel-sticky-status').text('(Pending Installation)');
             }*/
            $("#sticky-bar-form").submit();
            $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone').removeClass('db_save');
            // $('.lp-sticky-bar__outer_builder').fadeIn('slow');
            // $('.lp-sticky-bar__outer_pages').fadeOut('fast');
        }else{
            $('.lp-sticky-bar__clone-wrap .lp-sticky-bar_clone input').each(function(){
                if($(this).val() == ''){
                    $(this).addClass('error');
                    $(this).next().show();
                }
            });
        }
    });


    //  z-index js

    //  Manage specific Pages JS
    if($('#bs-slider-bar').length) {
        $('#bs-slider-bar').bootstrapSlider().on('slide', function () {
            var zindex = $(this).val();
            if (zindex > 1000) {
                zindex = zindex - 1;
            }
            $('#zindex-label').text(zindex);
            $('#zindex-label').digits();
            $('#zindex').val(zindex);
            return zindex;
        });
    }
    $(".zindex-company").select2({
        dropdownParent: $(".zindex-dropdown")
    });
    $('[name="zindex_type"]').change(function(){
        var zindex_option = $(this).val();
        update_form = true;

        if(zindex_option == 1){
            $('.zindex-custom-hide').slideUp();
            $('.zindex-company-hide').slideUp();
            $('#zindex').val('1000000');
        }else if(zindex_option == 2){
            $('.zindex-custom-hide').slideDown();
            $('.zindex-company-hide').slideUp();
            $('#zindex').val($('#zindex-label').text());
        }else if(zindex_option == 3){
            $('.zindex-custom-hide').slideUp();
            $('.zindex-company-hide').slideDown();
            $('#zindex').val('1000');
        }
        setTimeout(function(){
            owl.trigger('refresh.owl.carousel');
        },400)

    });
    $('[name="zindex_company"]').change(function () {
        $('#zindex').val($(this).val());
    })




});

PixelCalc = function(baseNum, percentIncDec, percent_format) {
    var is_percentage = percent_format === undefined ? false : percent_format;

    //Generally, 1em = 12pt = 16px = 100%
    var perPercent = 6.25;	//1px = 6.25%
    var changedNum = Math.round(baseNum * percentIncDec);

    if(baseNum === 0){
        if(is_percentage) return "0%";
        else return "0px";
    }

    if(is_percentage){
        return ((changedNum * perPercent).toFixed(2) + "%");
    }
    else{
        return (changedNum + "px");
    }
};




var isIE = false || !!document.documentMode;
var isEdge = !isIE && !!window.StyleMedia;

function process_input(){
    {
        window.parent.document.body.style.width = '100%';
        window.parent.document.body.style.height = '100%';
        window.parent.document.body.style.padding = '0px';
        window.parent.document.body.style.margin = '0px';
        var ctaChars = jQuery(".cta").text().length;
        // var ctaLinkChars = jQuery(".ctalink").text().length;
        var ctaLinkChars = jQuery("#linkanimation").text().length;
        var currentWidth = jQuery(window).width();
        /*console.info("(ctaLinkChars) > "+(ctaLinkChars));
        console.info("(ctaChars) > "+(ctaChars));
        console.info("(ctaChars + ctaLinkChars) > "+(ctaChars + ctaLinkChars));*/
        if ((ctaChars + ctaLinkChars) > 90) { // needs to be responsive if > 1 row
            // console.info('linw break');
            jQuery(".leadpops-left").css("flex-direction","column");
            if (isIE || isEdge) {
                jQuery(".leadpops-left").css("align-items","stretch");
            }

            jQuery(".ctalink").css("display","flex");
            jQuery(".ctalink").css("justify-content","center");

            jQuery(".cta").css("display","flex");
            jQuery(".cta").css("justify-content","center");

            jQuery(".ctalink").css("align-items","center");
            jQuery(".cta").css("align-items","center");

            if (currentWidth <= 767) { // mobile size

                jQuery("p.ctalink").css("font-size", PixelCalc(16 , setting.ratio));
                jQuery("p.ctalink").css("line-height", PixelCalc(16 , setting.ratio));
                jQuery("p.cta").css("font-size", PixelCalc(18 , setting.ratio));
                jQuery("p.cta").css("line-height", PixelCalc(18 , setting.ratio));
                jQuery("p.cta").css("margin", PixelCalc(4 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                jQuery("p.ctalink").css("margin", PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

            } else if (currentWidth > 767 && currentWidth <= 979) { // mobile size
                jQuery("p.ctalink").css("font-size", PixelCalc(20 , setting.ratio));
                jQuery("p.ctalink").css("line-height", PixelCalc(20 , setting.ratio));
                jQuery("p.cta").css("font-size", PixelCalc(22 , setting.ratio));
                jQuery("p.cta").css("line-height", PixelCalc(22 , setting.ratio));
                jQuery("p.cta").css("margin", PixelCalc(4 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                jQuery("p.ctalink").css("margin", PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

            }
            else if (currentWidth > 979) {
                jQuery(".leadpops-left").css("flex-direction","column");
                jQuery("p.ctalink").css("font-size", PixelCalc(24 , setting.ratio));
                jQuery("p.ctalink").css("line-height", PixelCalc(24 , setting.ratio));
                jQuery("p.cta").css("font-size", PixelCalc(24 , setting.ratio));
                jQuery("p.cta").css("line-height", PixelCalc(24 , setting.ratio));
                jQuery("p.cta").css("margin", PixelCalc(4 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                jQuery("p.ctalink").css("margin", PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

            }

            jQuery(window).resize(function() {
                var newWidth = jQuery(window).width();
                if (newWidth <= 767) { // mobile size

                    jQuery("p.ctalink").css("font-size", PixelCalc(16 , setting.ratio));
                    jQuery("p.ctalink").css("line-height", PixelCalc(16 , setting.ratio));
                    jQuery("p.cta").css("font-size", PixelCalc(18 , setting.ratio));
                    jQuery("p.cta").css("line-height", PixelCalc(18 , setting.ratio));
                    jQuery("p.cta").css("margin", PixelCalc(4 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                    jQuery("p.ctalink").css("margin", PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                    jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

                } else if (newWidth > 767 && newWidth <= 979) { // mobile size
                    jQuery("p.ctalink").css("font-size", PixelCalc(20 , setting.ratio));
                    jQuery("p.ctalink").css("line-height", PixelCalc(20 , setting.ratio));
                    jQuery("p.cta").css("font-size", PixelCalc(22 , setting.ratio));
                    jQuery("p.cta").css("line-height", PixelCalc(22 , setting.ratio));
                    jQuery("p.cta").css("margin", PixelCalc(4 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                    jQuery("p.ctalink").css("margin", PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                    jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

                }
                else if (newWidth > 979) {
                    jQuery(".leadpops-left").css("flex-direction","column");
                    jQuery("p.ctalink").css("font-size", PixelCalc(24 , setting.ratio));
                    jQuery("p.ctalink").css("line-height", PixelCalc(24 , setting.ratio));
                    jQuery("p.cta").css("font-size", PixelCalc(24 , setting.ratio));
                    jQuery("p.cta").css("line-height", PixelCalc(24 , setting.ratio));
                    jQuery("p.cta").css("margin", PixelCalc(4 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                    jQuery("p.ctalink").css("margin", PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio)+" "+PixelCalc(12 , setting.ratio)+" "+PixelCalc(0 , setting.ratio));
                    jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

                }
            });
        }
        else { // only one line
            // console.info('one line');
            if (currentWidth <= 767) { // mobile size
                jQuery(".leadpops-left").css("flex-direction","column");

                jQuery(".ctalink").css("display","flex");
                jQuery(".ctalink").css("justify-content","center");
                jQuery(".ctalink").css("align-items","center");

                jQuery(".cta").css("display","flex");
                jQuery(".cta").css("justify-content","center");
                jQuery(".cta").css("align-items","center");

                jQuery("p.ctalink").css("font-size", PixelCalc(22, setting.ratio));
                jQuery("p.ctalink").css("line-height",PixelCalc(22, setting.ratio));
                jQuery("p.cta").css("font-size", PixelCalc(26, setting.ratio));
                jQuery("p.cta").css("line-height", PixelCalc(26, setting.ratio));

                jQuery("p.cta").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));
                jQuery("p.ctalink").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));

                jQuery("#linkanimation").css("padding",PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

            } else if (currentWidth > 767 && currentWidth <= 979) { // mobile size
                jQuery(".leadpops-left").css("flex-direction","column");

                jQuery(".ctalink").css("display","flex");
                jQuery(".ctalink").css("justify-content","center");
                jQuery(".ctalink").css("align-items","center");

                jQuery(".cta").css("display","flex");
                jQuery(".cta").css("justify-content","center");
                jQuery(".cta").css("align-items","center");

                jQuery("p.ctalink").css("font-size", PixelCalc(24, setting.ratio));
                jQuery("p.ctalink").css("line-height",PixelCalc(24, setting.ratio));
                jQuery("p.cta").css("font-size", PixelCalc(28, setting.ratio));
                jQuery("p.cta").css("line-height", PixelCalc(28, setting.ratio));

                jQuery("p.cta").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));
                jQuery("p.ctalink").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));

                jQuery("#linkanimation").css("padding",PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

            }
            else if (currentWidth > 979) { // mobile size

                jQuery(".leadpops-left").css("flex-direction","row");

                jQuery("p.ctalink").css("margin-left", PixelCalc(3 , setting.ratio));
                jQuery(".cta").css("margin-right", PixelCalc(3 , setting.ratio));

                jQuery("p.ctalink").css("font-size", PixelCalc(26 , setting.ratio));
                jQuery("p.ctalink").css("line-height", PixelCalc(26 , setting.ratio));
                jQuery("p.cta").css("font-size", PixelCalc(30 , setting.ratio));
                jQuery("p.cta").css("line-height", PixelCalc(30 , setting.ratio));

                jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

            }

            jQuery(window).resize(function() {
                var newWidth = jQuery(window).width();
                if (newWidth <= 767 ) {
                    jQuery(".leadpops-left").css("flex-direction","column");

                    jQuery(".ctalink").css("display","flex");
                    jQuery(".ctalink").css("justify-content","center");
                    jQuery(".ctalink").css("align-items","center");

                    jQuery(".cta").css("display","flex");
                    jQuery(".cta").css("justify-content","center");
                    jQuery(".cta").css("align-items","center");

                    jQuery("p.ctalink").css("font-size", PixelCalc(22, setting.ratio));
                    jQuery("p.ctalink").css("line-height",PixelCalc(22, setting.ratio));
                    jQuery("p.cta").css("font-size", PixelCalc(26, setting.ratio));
                    jQuery("p.cta").css("line-height", PixelCalc(26, setting.ratio));

                    jQuery("p.cta").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));
                    jQuery("p.ctalink").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));

                    jQuery("#linkanimation").css("padding",PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));
                } else if (newWidth > 767 && newWidth <= 979) {
                    jQuery(".leadpops-left").css("flex-direction","column");

                    jQuery(".ctalink").css("display","flex");
                    jQuery(".ctalink").css("justify-content","center");
                    jQuery(".ctalink").css("align-items","center");

                    jQuery(".cta").css("display","flex");
                    jQuery(".cta").css("justify-content","center");
                    jQuery(".cta").css("align-items","center");

                    jQuery("p.ctalink").css("font-size", PixelCalc(24, setting.ratio));
                    jQuery("p.ctalink").css("line-height",PixelCalc(24, setting.ratio));
                    jQuery("p.cta").css("font-size", PixelCalc(28, setting.ratio));
                    jQuery("p.cta").css("line-height", PixelCalc(28, setting.ratio));

                    jQuery("p.cta").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));
                    jQuery("p.ctalink").css("margin",PixelCalc(2, setting.ratio)+" "+PixelCalc(0, setting.ratio));
                    jQuery("#linkanimation").css("padding",PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));

                } else if (newWidth > 979) {
                    jQuery(".leadpops-left").css("flex-direction","row");

                    jQuery("p.ctalink").css("margin-left", PixelCalc(3 , setting.ratio));
                    jQuery(".cta").css("margin-right", PixelCalc(3 , setting.ratio));

                    jQuery("p.ctalink").css("font-size", PixelCalc(26 , setting.ratio));
                    jQuery("p.ctalink").css("line-height", PixelCalc(26 , setting.ratio));
                    jQuery("p.cta").css("font-size", PixelCalc(30 , setting.ratio));
                    jQuery("p.cta").css("line-height", PixelCalc(30 , setting.ratio));

                    jQuery("#linkanimation").css("padding", PixelCalc(8, setting.ratio)+" "+PixelCalc(20, setting.ratio));
                }

            });

        }

    }
}
