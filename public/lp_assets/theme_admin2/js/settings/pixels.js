var reg = /[^0-9]/gi;
var regExpnumber = /[0-9\.\,]/;
var linebreak = /(\r\n|\n|\r)/gm;
var regSpace = /\s/g;
(function ($) {
    $(document).ready(function() {
    $('.ka-dd__link > div,.label-tooltip').tooltip({
        // container: 'body'
        container: '.tooltip-container'
    });
    $('#ka-dd-toggle').click(function(){
           if($(this).hasClass('ka-dd__button_open')){
               $(this).removeClass('ka-dd__button_open');
               $(this).parents('.ka-dd').find('.ka-dd__menu').slideUp();
           }else{
               $(this).addClass('ka-dd__button_open');
               $(this).parents('.ka-dd').find('.ka-dd__menu').slideDown('fast');
               // $(this).parents('.ka-dd').find('.ka-dd__menu').show();
           }
        });
    var mk_mcscroll = $('.ka-dd__scroll').mCustomScrollbar({
            mouseWheel:{ scrollAmount: 80}
        });
    $(".ka-dd__link").click(function (event){
            var href=$(this).attr("href");
            if($(this).parent().find(".collapsed").length == 1) {
                $(".ka-dd__scroll .mCSB_container").animate({top: '-' + $(href).parent().position().top}, 1000);
                mk_mcscroll.mCustomScrollbar("scrollTo", $(href).parent().position().top);
            }
        });
    $(".lp-btn-addCode").click(function(e){
            e.preventDefault();
            form_rest();
            addPixelCode();
        });
    $(".btn-editCode").click(function(e){
            $('.zip_code').parent().parent().parent().parent().find('.ka-dd__link').removeClass('za-error-label');
            $('.zip_code').removeClass('za-error-value');
            $(".pixel-model").attr("disabled", false);
            editPixelCode($(this));
        });
    $(".btn-deleteCode").click(function(e){
            e.preventDefault();
            $("#notification_confirmPixelDelete").html('Do you want to delete '+$(this).attr('data-pixel_name')+'?');
            //$("#id_confirmPixelDelete").val( $(this).attr('data-id') );
            $("#id_confirmPixelDelete").val( $(this).attr('data-id') );

            $("#model_confirmPixelDelete").modal('show');
        });
    $(".btnAction_confirmPixelDelete").click(function(e){
            e.preventDefault();
            deletePixelCode($(this));
        });
    $(".btnCancel_confirmPixelDelete").click(function(e){
            e.preventDefault();
            $("#id_confirmPixelDelete").val( "" );
        });
    $('[data-name="tracking_options"] li').click(function () {
            if($('#tracking_options').val() == 3){
                $(".question_options").show();
            }else{
                $(".question_options").hide();
            }
        });
    $('[data-name="pixel_placement"] li,[data-name="pixel_type"] li').click(function () {
            var placement = $("#pixel_placement").val();
            var type = $("#pixel_type").val();
            pixel_extra_fields(type, placement, false);
        });
    $('.slider_question').inputmask();
    $(".slider_question").keyup(function (){
            var q = $(this).parent().parent().data("question");
            var min =  String($('[data-question='+q+']').find(".min").data('min'));
            min =  parseInt(min.replace(reg,''));
            var max = String($('[data-question='+q+']').find(".max").data('max'));
            max = parseInt(max.replace(reg,''));
            var mn = parseInt($('[data-question='+q+']').find(".min").val().replace(reg,''));
            var mx =  parseInt($('[data-question='+q+']').find(".max").val().replace(reg,''));
            if((mn < min || mx > max) || mx < mn){
              $(this).addClass('za-error-value');
              $(this).parent().parent().parent().parent().find('.ka-dd__link').addClass('za-error-label');
              $(".pixel-model").attr("disabled",true);
              $($(this).parent().parent()).find('.answer').prop('checked',false);
            }else{
              $("#"+q).val(q+'|'+$('[data-question='+q+']').find(".min").val()+'~'+$('[data-question='+q+']').find(".max").val());
              $(this).parent().parent().parent().parent().find('.ka-dd__link').removeClass('za-error-label');
              $(this).parent().find('.min,.max').removeClass('za-error-value');
              $(".pixel-model").attr("disabled",false);
              if($('[data-question='+q+']').find(".min").val() && $('[data-question='+q+']').find(".max").val()) {
                  $($(this).parent().parent()).find('.answer').prop('checked', true);
              }
          }

        });
    $('.answer').change(function(){
             var checked = $($(this).parent().parent().find('.item')).find('.answer:checked').length;
            if (checked > 0){
                $(this).parent().parent().parent().find('.ka-dd__link').addClass('za-checkbox-checked');
            }else {
                $(this).parent().parent().parent().find('.ka-dd__link').removeClass('za-checkbox-checked');
            }
        });
    $('.zip_code').on('keydown keyup', function(e) {
            var key = e.charCode || e.keyCode || 0;
            var cursor = $(this).getCursorPosition();
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            if (!(key==8 ||//Backspace
                    key==9 ||//Tab
                    key==37 ||//Setas
                    key==38 ||//Setas
                    key==39 ||//Setas
                    key==40 || //Setas
                    key==46 || // delete
                    key==65 ||  key==67 || key== 86 || key== 88 || //ctrl+a,x,c,v
                    key== 13 || // enter
                    key >= 48 && key <= 57 || key >= 96 && key <= 105) ){ // keyboard right side number pad
                e.preventDefault();
                return false;
            }

            var text = $(this).val();
            var nt = text.replace(/[^A-Za-z]/g,'');
            if(/^[0-9-,\n]+$/.test(text) == false && text){
                $(this).parent().parent().parent().parent().find('.ka-dd__link').addClass('za-error-label');
                $(this).addClass('za-error-value');
                $(".pixel-model").attr("disabled", true);
            }
            else{
                $(this).parent().parent().parent().parent().find('.ka-dd__link').removeClass('za-error-label');
                $(this).removeClass('za-error-value');
                $(".pixel-model").attr("disabled", false);
            }
                var lines = text.split(linebreak);
                var nl = [];
                for (var i = 0; i < lines.length; i++) {
                    if (i % 2 === 0) {
                        if (lines[i] && key != 8) {
                            if (!lines[i].replace(/[^,]/g, '') && lines[i].replace(reg, '').length == 5) {
                                if (text.indexOf(lines[i]+ ',') != '-1') {
                                    lines[i] = '';
                                    lines[i+1] = '';
                                } else {
                                    lines[i] = lines[i] + ',\n';
                                    lines[i+1] = '';
                                }
                            }
                            else if ((lines[i]) && lines[i].length < 5) {
                                if (key == 13) {
                                    e.preventDefault();
                                }
                                $(".pixel-model").attr("disabled", true);
                            }
                            else if (lines[i].length > 6){
                                if (lines[i].length > 10  && lines[i].match(/,/g)) {
                                    var r = lines[i].split(',');
                                    for (var a = 0; a < r.length; a++) {
                                        if (r[a]) {
                                            nl.push(r[a].substring(0, 5) + ',\n');
                                        }
                                    }
                                    nl.reverse();
                                    lines[i] = '';
                                    lines[i + 1] = '';
                                }
                                lines[i] = lines[i].substring(0, 5);
                                lines[i] = lines[i] + ',';
                                setCursorPos($(this)[0], cursor, cursor);
                                if (text.indexOf(lines[i]) != '-1') {
                                    lines[i] = '';
                                    lines[i + 1] = '';
                                }
                            }
                        }else{
                         if ((lines[i]) && lines[i].length < 5) {
                             if (key == 13) {
                                    e.preventDefault();
                                }
                                $(".pixel-model").attr("disabled", true);
                            }
                        }
                    }
                }
            $.merge(lines,nl);

            lines = lines.filter(function(item) {
                if(item !== ""){
                    return item;
                }
            });

               $(this).val(lines.join(''));

        });
    $.fn.getCursorPosition = function() {
            var el = $(this).get(0);
            var pos = 0;
            if ('selectionStart' in el) {
                pos = el.selectionStart;
            } else if ('selection' in document) {
                el.focus();
                var Sel = document.selection.createRange();
                var SelLength = document.selection.createRange().text.length;
                Sel.moveStart('character', -el.value.length);
                pos = Sel.text.length - SelLength;
            }
            return pos;
        }
    });
})(jQuery);
function uniqueCode(arr,v){
    var out = [];
    console.log(v);
    console.log(arr);

        for (var i = 0; i < arr.length; i++) {
          if(arr[i] == v){
              out[i] = v;
          }
        }
        console.log(out);
    return out;
}
function setCursorPos(input, start, end) {
    if (arguments.length < 3) end = start;
    if ("selectionStart" in input) {
        setTimeout(function() {
            input.selectionStart = start;
            input.selectionEnd = end;
        }, 1);
    }
    else if (input.createTextRange) {
        var rng = input.createTextRange();
        rng.moveStart("character", start);
        rng.collapse();
        rng.moveEnd("character", end - start);
        rng.select();
    }
}
function pixel_extra_fields(type, placement, elem){
    var GOOGLE_ANALYTICS = 1;
    var FACEBOOK_PIXEL = 2;
    var GOOGLE_TAG_MANAGER = 3;
    var GOOGLE_CONVERSION_PIXEL = 4;
    var BING_PIXEL = 5;
    var GOOGLE_RETARGETING_PIXEL = 6;
    var INFORMA_PIXEL = 7;

    var PAGE_FUNNEL = 2;
    var PAGE_THANKYOU = 4;

    var PIXEL_ACTION_LEAD = 2;

    $('.pixel_extra,.tracking_options,.question_options').hide();
    $("#pixel_other").val('');

    if(type == GOOGLE_ANALYTICS) $(".tracking_to_lender").html("Tracking ID");
    else if(type == FACEBOOK_PIXEL) $(".tracking_to_lender").html("Pixel ID");
    else if(type == GOOGLE_TAG_MANAGER) $(".tracking_to_lender").html("Container ID");
    else if(type == GOOGLE_CONVERSION_PIXEL) $(".tracking_to_lender").html("Conversion ID");
    else if(type == BING_PIXEL) $(".tracking_to_lender").html("Tag ID");
    else if(type == GOOGLE_RETARGETING_PIXEL) $(".tracking_to_lender").html("Conversion ID");
    else if(type == INFORMA_PIXEL) $(".tracking_to_lender").html("Lender ID");

    if(type == FACEBOOK_PIXEL && placement == PAGE_FUNNEL){
        $('.tracking_options, .tracking_options ul li, .tracking_options .caret').show();
        $('.tracking_options ul li[data-value ="'+PIXEL_ACTION_LEAD+'"]').hide();
        $(".pixel_position").hide();
        $('#tracking_options').val( $('[data-name="tracking_options"]').attr('data-default-val') );
        $('.tracking_options .displayText').html( $('[data-name="tracking_options"]').attr('data-default-label') );
        if($('#tracking_options').val() == 3){
            $(".question_options").show();
        }


    }else if(placement == PAGE_THANKYOU){

        $(".pixel_position, .tracking_options .caret").hide();
        $('.tracking_options ul li[data-value="'+PIXEL_ACTION_LEAD+'"]').siblings().hide();
        $(".tracking_options").show();
        $('#tracking_options').val( PIXEL_ACTION_LEAD );
        $('.tracking_options .displayText').html( $('.tracking_options ul li[data-value="'+PIXEL_ACTION_LEAD+'"]').text() );
        if(type == FACEBOOK_PIXEL){
            //$(".facebook_pixel_action").show();

            if(elem) {
                /*
                if(elem.attr('data-pixel_action') !== "") {
                    var pixel_actions = elem.attr('data-pixel_action').split(",");
                    $.each(pixel_actions, function (i, id) {
                        $("#model_pixel_code").find('#pixel_action_' + id ).prop('checked',true);
                    });
                }
                */

                //Funnels can have only Leads as action so puting hardcoded lead value
                $("#pixel_action").val(PIXEL_ACTION_LEAD);
                $("#fb_pixel_conversion").val(elem.attr('data-pixel_other'));
            }
        }
    }
    else{
        $(".pixel_position").show();
        $("#pixel_action").val('');

        if(type == GOOGLE_CONVERSION_PIXEL || type == GOOGLE_RETARGETING_PIXEL){     // GOOGLE_CODE_CONVERSION_PIXEL
            $(".pixel_other").show();

            if(type == GOOGLE_CONVERSION_PIXEL) $(".pixel_other .pixel_other_label").html("Conversion Label");
            if(type == GOOGLE_RETARGETING_PIXEL) $(".pixel_other .pixel_other_label").html("Targeting To");

            if(elem) {
                $("#pixel_other").val(elem.attr('data-pixel_other'));
            }
        }
    }
}
function addPixelCode() {
    $("#model_pixel_code").find("#id").val('');
    $("#model_pixel_code").find("#pixel_name").val('');
    $("#model_pixel_code").find("#pixel_code").val('');

    $("#model_pixel_code").find('#pixel_type').val( $('[data-name="pixel_type"]').attr('data-default-val') );
    $("#model_pixel_code").find('[data-name="pixel_type"]').find(".displayText").html( $('[data-name="pixel_type"]').attr('data-default-label') );

    $("#model_pixel_code").find('#pixel_placement').val( $('[data-name="pixel_placement"]').attr('data-default-val') );
    $("#model_pixel_code").find('[data-name="pixel_placement"]').find(".displayText").html( $('[data-name="pixel_placement"]').attr('data-default-label') );

    $("#model_pixel_code").find('#pixel_position').val( $('[data-name="pixel_position"]').attr('data-default-val') );
    $("#model_pixel_code").find('[data-name="pixel_position"]').find(".displayText").html( $('[data-name="pixel_position"]').attr('data-default-label') );

    $("#model_pixel_code").find('#tracking_options').val( $('[data-name="tracking_options"]').attr('data-default-val') );
    $("#model_pixel_code").find('[data-name="tracking_options"]').find(".displayText").html( $('[data-name="tracking_options"]').attr('data-default-label') );
    $('.pixel_extra,.tracking_options,.question_options').hide();
    $(".pixel_position").show();
    $(".tracking_to_lender").html("Tag ID");
    // $("#model_pixel_code").find('#pixel_action').val( $('[data-name="pixel_action"]').attr('data-default-val') );
    // $("#model_pixel_code").find('[data-name="pixel_action"]').find(".displayText").html( $('[data-name="pixel_action"]').attr('data-default-label') );
    $("#model_pixel_code").find('#pixel_action_' + $('[data-name="pixel_action"]').attr('data-default-val') ).prop('checked',true);

    $("#model_pixel_code").find("div.pixel_other").hide();
    $("#model_pixel_code").find("#pixel_other").val('');

    $("#model_pixel_code").find(".modal-title").html("Add Pixels and Tracking Codes");
    $("#model_pixel_code").find("#action").val("add");
    $("#model_pixel_code").find(".lp-btn-add").val("ADD CODE");
    $("#model_pixel_code").modal('show');
}
function editPixelCode(elem) {
    $("#model_pixel_code").find("#id").val(elem.attr('data-id'));
    $("#model_pixel_code").find("#pixel_name").val(elem.attr('data-pixel_name'));
    $("#model_pixel_code").find("#pixel_code").val(elem.attr('data-pixel_code'));

    $("#model_pixel_code").find('#pixel_type').val(elem.attr('data-pixel_type'));
    $("#model_pixel_code").find('[data-name="pixel_type"]').find(".displayText").html(elem.attr('data-pixel_type_label'));
    //$("#model_pixel_code").find('#pixel_type').trigger('change');

    if(elem.attr('data-pixel_placement') == 1 || elem.attr('data-pixel_placement') == 3){
        $("#model_pixel_code").find('#pixel_placement').val(2);
        $("#model_pixel_code").find('[data-name="pixel_placement"]').find(".displayText").html('Funnel');
    }else {
        $("#model_pixel_code").find('#pixel_placement').val(elem.attr('data-pixel_placement'));
        $("#model_pixel_code").find('[data-name="pixel_placement"]').find(".displayText").html(elem.attr('data-pixel_placement_label'));
    }

    //$("#model_pixel_code").find('#pixel_placement').trigger('change');
    $("#model_pixel_code").find('#pixel_position').val(elem.attr('data-pixel_placement'));
    $("#model_pixel_code").find('[data-name="pixel_position"]').find(".displayText").html(elem.attr('data-pixel_position_label'));
    $('.pixel_extra').hide();
    var v = 0;
    if(elem.attr('data-fb_questions_flag') == 1){
        v = 3;
        $("#pixel_placement").val(2);
        var q;
        var ans_arr = elem.data('fb_questions_json');
        $.each(ans_arr,function (k,v){
            $.each(v,function (a,r) {
                if(k == 'enteryourzipcode'){
                    $(".zip_code").val(String(v).replace(/\,/g,',\n'));
                    $('.zip_code').parent().parent().parent().parent().find('.ka-dd__link').addClass('za-checkbox-checked');

                }else {
                    q = k + r.toLowerCase().replace('.', '_').replace(/[^A-Za-z0-9_]+/ig, "");
                    $("#" + q).prop('checked', true);
                    if ($('[data-question=' + k + ']').length == 1) {
                        $("input[data-value='" + k + "']").prop('checked', true);
                        $('#' + k).val(k + '|' + r);
                        var arr = r.split('~');
                        $('[data-question=' + k + ']').find(".min").val(arr[0]);
                        $('[data-question=' + k + ']').find(".max").val(arr[1]);
                    }
                }
                $('.answer').change();

            });
        });
    }else if(elem.attr('data-pixel_position_label') == 4){
        v = 2;
    }else{
        v = 1;
    }

    $('[data-name="tracking_options"]').attr('data-default-val',v);
    $('[data-name="tracking_options"]').attr('data-default-label',$('.tracking_options ul li[data-value="'+v+'"]').text() );
    $(".pixel_position").show();
    var placement = $("#pixel_placement").val();
    var type = $("#pixel_type").val();
    pixel_extra_fields(type, placement, elem);

    $("#model_pixel_code").find(".modal-title").html("Edit Pixels and Tracking Codes");
    $("#model_pixel_code").find("#action").val("update");
    $("#model_pixel_code").find(".lp-btn-add").val("UPDATE CODE");
    $("#model_pixel_code").modal('show');
}
function deletePixelCode(elem) {
    var notification_container = $("#notification_confirmPixelDelete");
    notification.loading(notification_container, "Please wait... Deleting...");
    console.info($("#id_confirmPixelDelete").val());
    console.info("in");
    $.ajax( {
        type : "POST",
        data: "id="+$("#id_confirmPixelDelete").val()+"&client_id="+$("#client_id_confirmPixelDelete").val()+"&_token="+ajax_token,
        dataType:"json",
        url : "/lp/popadmin/deletepixelinfo",
        success : function(d) {
            if (d.status == "success") {
                notification.success(notification_container, 'Code has been deleted.');
                $('.pixel_' + $("#id_confirmPixelDelete").val() ).remove();
            }else{
                notification.error(notification_container, 'Your request was not processed. Please try again.');
            }

            setTimeout(function () {
                $("#model_confirmPixelDelete").modal('toggle');
            }, 2000);
        },
        error : function () {
            notification.error(notification_container, 'Your request was not processed. Please try again.');
        },
        cache : false,
        async : false
    });
}
function form_rest(){
    $('.answer').prop("checked",false);
    $(".zip_code,.min,.max").val('');
    $(".zip_code").removeClass('za-error-value');
    $(".ka-dd__list .ka-dd__link").removeClass('za-checkbox-checked za-error-label');
    $(".ka-dd__link,.panel-collapse").attr("aria-expanded","false");
    $(".ka-dd__link").addClass("collapsed");
    $(".panel-collapse").removeClass("in");
    $(".pixel-model").attr("disabled",false);

}
