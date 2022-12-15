$(document).ready(function(){
    autosize($('textarea'));
    setTimeout(function () {
        $('#mlineheight').val($("#mmainheadingval").css("line-height"));
        $('#dlineheight').val($("#dmainheadingval").css("line-height"));
        $("#mmainheadingval").css("line-height" , 'inherit');
        $("#dmainheadingval").css("line-height" , 'inherit');
        },500);

    $( "body" ).on( "keypress","#mmainheadingval , #dmainheadingval " , function(e) {
        $('#mlineheight').val($("#mmainheadingval").css("line-height"));
        $('#dlineheight').val($("#dmainheadingval").css("line-height"));
    });
    //console.log("hello to the call to actoin js file ");
    $('.colorSelector-mmessagecp').ColorPicker({
        color: $("#mmessagecpval").val(),
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $("#mmessagecpval").val('#' + hex);
            $('.colorSelector-mmessagecp').css('backgroundColor', '#' + hex);
            $('#mmainheadingval').css('color', '#' + hex);
            console.info("change");
        },

    });

    //color picker
    $('.colorSelector-mdescp').ColorPicker({
        color: $("#dmessagecpval").val(),
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $("#dmessagecpval").val('#' + hex);
            $('.colorSelector-mdescp').css('backgroundColor', '#' + hex);
            $('#dmainheadingval').css('color', '#' + hex);
        }
    });
    // CTA POPUP validation


    var $form = $("#ctaform"),
    $successMsg = $(".alert");
    $form.validate({
        rules: {
            mmainheadingval: {
                required: true,
                //minlength: 30
            },
            dmainheadingval: {
                required: false,
                //minlength: 50
            }
        },
        messages: {
            mmainheadingval: {
                required:"Please enter the message."
            },
            dmainheadingval: {
                required:"Please enter the description."
            }
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
    $('.colorSelector-mmessagecp').css('backgroundColor', $("#mmessagecpval").val());
    $('.colorSelector-mdescp').css('backgroundColor', $("#dmessagecpval").val());
    /*$("#mthefont,#dthefont").each(function(){
      $(this).children("option").each(function(){
        $(this).css("fontFamily",this.value);
        //console.log($(this));
      });
    });*/









});
    //MN
    function targetele(src){
        var target_element="";
        switch (src) {
            case 'mthefont':
            case 'mthefontsize':
                target_element="mmainheadingval";
            break;
            case 'dthefont':
            case 'dthefontsize':
                target_element="dmainheadingval";
            break;
        }
        return target_element;
    }
    function changefont(src,val) {
        target_element=targetele(src);
        var newval = val.replace("+"," ");
        newval = newval.replace("+"," ");
        newval = newval.replace("+"," ");
        console.log(target_element);
        console.log(src);
        $('#'+target_element).css('font-family',newval);
        $('#'+src).removeAttr('class');
        $('#'+src).addClass("selectpicker cta-font-size "+newval.replace(' ','_').toLowerCase());
        $('#mlineheight').val($("#mmainheadingval").css("line-height"));
        $('#dlineheight').val($("#dmainheadingval").css("line-height"));
    }

    function changefontsize(src,val) {
        target_element=targetele(src);
        $('#'+target_element).css('font-size',val);
        $('#mlineheight').val($("#mmainheadingval").css("line-height"));
        $('#dlineheight').val($("#dmainheadingval").css("line-height"));
    }

    function resethomepagemessage(cval) {
        var msg = $('#mmainheadingval').val();
        var current_hash=$("#current_hash").val();
        $("#success-alert").find('span').text("");
        //$("#leadpopovery").show();
        $("#mask").show();
        var resetfun="";
        switch (cval) {
            case "1":
                resetfun="resetctamessage";
            break;
            case "2":
                resetfun="resetctadescription";
            break;
        }
        var form_data=$('#ctaform').serializeArray();
        jQuery.ajax( {
            type : "POST",
            data:form_data,
            url: site.baseUrl+site.lpPath+'/popadmin/'+resetfun+'/'+current_hash,
            success : function(data) {
                var style_data=jQuery.parseJSON(data);
                var fontfamily=style_data.style.font_family.replace(" ", "_");
                var fontsize=style_data.style.font_size;
                var color=style_data.style.color;
                var msg=style_data.style.main_message;
                var css_prop_obj={
                    'font-family':style_data.style.font_family,
                    //'font-family':"Times new Romen,Sans serif",
                    'font-size':fontsize,
                    //'font-size':'14px',
                    'color':color,
                    //'color':"#000",
                }
                switch (cval) {
                    case "1":
                        $("#success-alert").find('span').text("CTA Main Message default style has been reset.");
                        $('#mthefont').val(style_data.style.font_family).trigger('change');
                        $('#mthefontsize').val(fontsize).trigger('change');
                        $("#mmainheadingval").val(msg).css(css_prop_obj);
                        $('.colorSelector-mmessagecp').css('backgroundColor', color);
                        $('#mmessagecpval').val(color);
                        $('.colorSelector-mmessagecp').ColorPickerSetColor(color);

                        var ta = document.querySelector('textarea#mmainheadingval');
                        autosize(ta);
                        ta.value = msg;
                        var evt = document.createEvent('Event');
                        evt.initEvent('autosize:update', true, false);
                        ta.dispatchEvent(evt);

                    break;
                    case "2":
                        $("#success-alert").find('span').text("Cta Description default style has been reset.");
                        $('#dthefont').val(style_data.style.font_family).trigger('change');
                        $('#dthefontsize').val(fontsize).trigger('change');
                        $("#dmainheadingval").val(msg).css(css_prop_obj);
                        $('.colorSelector-mdescp').css('backgroundColor', color);
                        $('#dmessagecpval').val(color);
                        $('.colorSelector-mdescp').ColorPickerSetColor(color);

                        var ta = document.querySelector('textarea#dmainheadingval');
                        autosize(ta);
                        ta.value = msg;
                        var evt = document.createEvent('Event');
                        evt.initEvent('autosize:update', true, false);
                        ta.dispatchEvent(evt);
                    break;
                }
                //$("#leadpopovery").hide();
                $("#mask").hide();
                goToByScroll("success-alert");
                $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                    $(this).slideUp(500);
                });

            },
        });

        /*$('#ctaform').attr('action',site.baseUrl+site.lpPath+'/popadmin/'+resetfun+'/'+current_hash);
        $('#ctaform').submit();*/
        return false;
    }
