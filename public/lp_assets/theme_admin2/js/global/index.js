$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
        placement:"bottom"
    });

    $(".custom-radio-btn").click(function () {
        $(".custom-radio-btn").find("input[name='is_ada_accessibility']:checked").removeAttr("checked");
        $(this).find("input[name='is_ada_accessibility']").attr("checked", "checked");
    });

    setTimeout(function () {
        $('#mlineheight').val($("#mmainheadingval").css("line-height"));
        $('#dlineheight').val($("#dmainheadingval").css("line-height"));
    },500);

    $( "body" ).on( "keypress","#mmainheadingval , #dmainheadingval " , function(e) {
        $('#mlineheight').val($("#mmainheadingval").css("line-height"));
        $('#dlineheight').val($("#dmainheadingval").css("line-height"));
    });


    $( window ).on("load", function() {
        $("#textwrapper #template_dropdown-1").hide();
    });
	// Global setting page
    $('#clone-url').click(function(){
        copyToClipboard($('#url-text'));
        var html = '<div class="alert alert-success lp-success-msg">'+
                    'Success! Thank You Page URL has been copied'+
                    '</div>';
        $(html).hide().appendTo("#msg").slideDown(500).delay(1000).slideUp(500 , function(){
            $(this).remove();
        });

    });

    $( "body" ).on( "blur","#thirdpartyurl" , function(e) {
        var text = $(this).val();
        var replace = text.replace(/(^\w+:|^)\/\//, '');
        $(this).val(replace);
    });

    $( "body" ).on( "keypress",".lp-auto-responder-textbox_stop_event" , function(e) {
        var keyCode = event.keyCode || event.which;
        if (keyCode == 13) {
            e.preventDefault();
        }
    });
    $( "body" ).on( "keypress",".cta-text_stop_event" , function(e) {
        var keyCode = event.keyCode || event.which;
        if (keyCode == 13) {
            e.preventDefault();
        }
    });
    $( "body" ).on( "keypress",".lp-tg-textbox_stop_event" , function(e) {
        var keyCode = event.keyCode || event.which;
        if (keyCode == 13) {
            e.preventDefault();
        }
    });
    $( "body" ).on( "keypress","#thirdpartyurl" , function(e) {
        var keyCode = event.keyCode || event.which;
        if (keyCode == 13) {
            e.preventDefault();
            var error_flag = false;
            error_flag = checkURL($(this));
            if(error_flag){
                globalsavethankyou();
            }
        }
    });
    function _change(e){
        e.preventDefault();
        if ($(this).is(':checked')) {
            $("#"+$(this).data("thelink")).val("y");
            $("#"+$('#thankyou-toggle').data("thelink")).val("n");
            $('#thankyou-toggle').prop('checked', false).trigger('change');
        }else{
            $('#thankyou-toggle').prop('checked', true).trigger('change');
            $("#"+$(this).data("thelink")).val("n");
            $("#"+$('#thankyou-toggle').data("thelink")).val("y");
        }
    }

    $("#thirldparty-toggle").bind('change',_change);

    // $("#thirldparty-toggle").change(function (e) {
    //     e.preventDefault();
    //     // if ($(this).is(':checked')) {
    //     //     console.info('checked');
    //     //     $('#thankyou-toggle').prop('checked', false).trigger('change');
    //     // }else{
    //     //     console.info('not checked');
    //     //     $('#thankyou-toggle').prop('checked', true).trigger('change');
    //     // }
    // });

    $("#thankyou-toggle").change(function (e) {
        e.preventDefault();
        if ($(this).is(':checked')) {
            $("#"+$(this).data("thelink")).val("y");
            $("#"+$("#thirldparty-toggle").data("thelink")).val("n");

            $("#thirldparty-toggle").unbind('change',_change);
            $("#thirldparty-toggle").bootstrapToggle('off');
            $("#thirldparty-toggle").bind('change',_change);

        }else{
            $("#thirldparty-toggle").unbind('change',_change);
            $("#thirldparty-toggle").bootstrapToggle('on');
            $("#thirldparty-toggle").bind('change',_change);
            // $("#"+$(this).data("thelink")).val("y");
            $("#"+$(this).data("thelink")).val("n");
            $("#"+$("#thirldparty-toggle").data("thelink")).val("y");
        }
    });

   /* $( "body" ).on( "change",".glvthktogbtn" , function(e) {
        e.preventDefault();
        $("#changebtn").val("1");

        if ($(this).is(':checked')) {
            $("#"+$(this).data("thelink")).val("y");
            console.info($(this).data("target"));
            $($(this).data("target")).bootstrapToggle("off");

            // $(this).bootstrapToggle("on");
            // $('.thktogbtn').not(this).each(function(){
            //      $("#"+$(this).data("thelink")).val("n");
            //      $(this).bootstrapToggle("off");
            // });
        }
        else{
            $("#"+$(this).data("thelink")).val("n");
            $($(this).data("target")).bootstrapToggle("on");
            // $('.thktogbtn').bootstrapToggle("on");
            // $(this).bootstrapToggle("off");
            // $('.thktogbtn').not(this).each(function(){
            //     $("#"+$(this).data("thelink")).val("y");
            //      $(this).bootstrapToggle("on");
            // });
        }
        // $($(this).data("target")).prop('checked');
    });
    */

    $('.lp_thankyou_toggle').click(function (e) {
        e.preventDefault();
        if($('#lp-thankyou-url-edit').hasClass('hide')){
            $(this).html('<i class="fa fa-remove"></i> CANCEL');
            $('#lp-thankyou-url-edit').removeClass('hide');
        }else{
            $('#lp-thankyou-url-edit').addClass('hide');
            $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT URL');
        }
    });

    $('#colorpicker').ColorPicker({
        flat: true,
        width: 277,
        height: 277,
        outer_height: 300,
        outer_width: 390,
        onChange: function (cal, hex, rgb) {
            $('#col-code').html('#'+hex);
            $('#col-prev').css('background-color' , '#'+hex);
        }
    });
    $('#ex3').bootstrapSlider({
        formatter: function(value) {
            return   value +'%';
        },
        min: 1,
        max: 100,
        value: 20,
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    $('.funnel-caret a').click(function(){
//        console.info($(this).children().hasClass('fa-caret-down'));
        _target = $(this).children();
        if(_target.hasClass('fa-caret-down')){
            _target.removeClass('fa-caret-down');
            _target.addClass('fa-caret-up');
        }else{
            _target.removeClass('fa-caret-up');
            _target.addClass('fa-caret-down');
        }
    });


    $('#pixel_type').change(function(){
        if($(this).val() == 2 && $('#pixel_placement').val() == 4){
            $(".facebook_pixel_action").show();
        }else{
            $(".facebook_pixel_action").hide();
        }
    });

    $('#pixel_placement').change(function(){
        if($(this).val() == 4 && $('#pixel_type').val() == 2){
            $(".facebook_pixel_action").show();
        }else{
            $(".facebook_pixel_action").hide();
        }
    });


    $('#pixel_type, #pixel_placement').change(function () {
        var placement = $("#pixel_placement").val();
        var type = $("#pixel_type").val();
        pixel_extra_fields(type, placement, false);
    });

    $(".pixel_global_add_btn").click(function(){

        // if ($("#lpkey_pixels").val() == '') {
        //     errormessage("Please Select Funnel From List.");
        //     return;
        // };

        var notification_container = $(".lp-pixel-alerts");
        var pixel_code = $("#pixel_code").val();
        var is_include = $('.is_include').prop('checked');

        var domain_ids = $('input[name="domains\[\]"]:checked').map(function () {
            return this.value;
        }).get().join(",");

        if (domain_ids == '') {
            $("#alert-danger").find('span').html("");
            errormessage("Please Select Funnel From List.");
            $("#alert-danger").fadeTo(3000, 500).slideUp(500, function(){
                $(this).slideUp(500);
            });
            return;
        };

        $("#domains_ids").val(domain_ids)
        if(is_include){
            $("#domains_include").val(1)
        }else{
            $("#domains_include").val(0)
        }

        var form_data= $('#maincontent_pixel').serialize();
        if(pixel_code == ""){
            $("#pixel_code").focus();
            $("#alert-danger").find("span").text("Tracking ID is required...");
            goToByScroll("alert-danger");
            $("#alert-danger").fadeTo(3000, 500).slideUp(500, function(){
                $(this).slideUp(500);
            });
            //notification.error(notification_container, "Tracking ID is required...");

            return false;
        }
        //$("#leadpopovery").show();
        $("#mask").show();

        //notification.loading(notification_container);
        $.ajax( {
            type : "POST",
            data: form_data,
            dataType:"json",
            url : "/lp/popadmin/savepixelinfo",
            success : function(d) {
                $("#mask").hide();
                if (d.status == "success") {
                    $("#success-alert").find("span").text(d.message);
                    goToByScroll("success-alert");
                    $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                        $(this).slideUp(500);
                    });

                    $(".global-pixel-list").html(d.html);

                    $("#reset").trigger('click');
                    $("#maincontent_pixel").find("#domains_include").val("");
                    $("#maincontent_pixel").find("#action").val("global.add");
                    $("#maincontent_pixel").find("#id").val("");
                    $("#maincontent_pixel").find("#domains_ids").val("");
                    $("#maincontent_pixel").find(".pixel_global_add_btn").html("<strong>ADD CODE</strong>");
                    $("#maincontent_pixel").find(".lp-heading-2").html("Add Pixel Code");

                    $("#pixel_name").val("");
                    $("#pixel_code").val("");
                    $("#pixel_type").val("1");
                    $('#pixel_type').trigger('change');
                    $("#pixel_placement").val("2");
                    $("#pixel_placement").trigger('change');
                    $('.facebook_pixel_action').find('input[type=checkbox]:checked').prop('checked',false);
                    //$("#pixel_action").val("1");
                    //$("#pixel_action").trigger('change');


                    // Edit Button Callback
                    $(".btn-edit-GlobalPixel").click(function(e){
                        e.preventDefault();
                        editGlobalPixel($(this));
                    })

                    // Delete Button Callback
                    $(".btn-delete-GlobalPixel").click(function(e){
                        e.preventDefault();
                        $("#notification_confirmPixelDelete").html('Do you want to delete '+$(this).attr('data-pixel_name')+'?');
                        $("#id_confirmPixelDelete").val( $(this).attr('data-id') );
                        $("#model_confirmPixelDelete").modal('show');
                    });
                }
                else{
                    $("#alert-danger").find("span").text("Unable to add code");
                    goToByScroll("alert-danger");
                    $("#alert-danger").fadeTo(3000, 500).slideUp(500, function(){
                        $(this).slideUp(500);
                    });
                }
            },
            error : function () {
                //$("#leadpopovery").hide();
                $("#mask").hide();
                $("#alert-danger").find("span").text("Application Error");
                goToByScroll("alert-danger");
                $("#alert-danger").fadeTo(3000, 500).slideUp(500, function(){
                    $(this).slideUp(500);
                });
                //notification.error(notification_container, 'Application Error');
            },
            cache : false,
            async : false
        });
    })

    // Delete Button Callback
    $(".btn-delete-GlobalPixel").click(function(e){
        e.preventDefault();
        $("#notification_confirmPixelDelete").html('Do you want to delete '+$(this).attr('data-pixel_name')+'?');
        $("#id_confirmPixelDelete").val( $(this).attr('data-id') );
        $("#model_confirmPixelDelete").modal('show');
    });

    // Cancel button — Delete Popup
    $(".btnCancel_confirmPixelDelete").click(function(e){
        e.preventDefault();
        $("#id_confirmPixelDelete").val( "" );

        $("[data-id='integration-pixels']").trigger('click');
    });

    // Confirm button — Delete Popup
    $(".btnAction_confirmPixelDelete").click(function(e){
        e.preventDefault();
        var elem = $(this);
        var notification_container = $("#notification_confirmPixelDelete");
        notification.loading(notification_container, "Please wait... Deleting...");
        $.ajax( {
            type : "POST",
            data: "group_identifier="+$("#id_confirmPixelDelete").val()+"&client_id="+$("#client_id_confirmPixelDelete").val()+'&_token='+ajax_token,
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
                notification.error(notification_container, 'Application Error');
            },
            cache : false,
            async : false
        });

        $("[data-id='integration-pixels']").trigger('click');
    });

    // Edit Button Callback
    $(".btn-edit-GlobalPixel").click(function(e){
        e.preventDefault();
        editGlobalPixel($(this));
    })

    function editGlobalPixel(elem) {

        $("#pixel_name").val(elem.attr('data-pixel_name'));
        $("#pixel_code").val(elem.attr('data-pixel_code'));
        $("#pixel_other").val(elem.attr('data-pixel_other'));

        $("#pixel_type").val(elem.attr('data-pixel_type'));
        $('#pixel_type').trigger('change');

        if(elem.attr('data-pixel_placement') < 4){
            var page_placement = 2;
        } else {
            var page_placement = 4;
            if(elem.attr('data-pixel_type') == 2){
                $("#fb_pixel_conversion").val(elem.attr('data-pixel_other'));
            }
        }

        $("#pixel_placement").val(page_placement);
        $("#pixel_placement").trigger('change');


        $("#pixel_position").val(elem.attr('data-pixel_placement'));
        $("#pixel_position").trigger('change');

        //$("#pixel_action").val(elem.attr('data-pixel_action'));
        //$("#pixel_action").trigger('change');
        if(elem.attr('data-pixel_action') != "") {
            var pixel_actions = elem.attr('data-pixel_action').split(",");
            $.each(pixel_actions, function (i, id) {
                $('#pixel_action_' + id ).prop('checked',true);
            });
        }

        $("#funnel-selector").find("input[type=checkbox]").prop("checked", false);
        var domains_ids = elem.attr('data-domains_ids').split(',');
        $.each(domains_ids, function (index, domainid) {
            $("input[type=checkbox][value=" + domainid + "]").prop("checked", true);
        });
        $('[data-target="#funnel-selector"]').html('<i class="fa fa-cog"></i> Selected (' + domains_ids.length + ')');

        $("#maincontent_pixel").find("#domains_include").val(1);
        $("#maincontent_pixel").find("#action").val("global.update");
        $("#maincontent_pixel").find("#id").val(elem.attr('data-id'));
        $("#maincontent_pixel").find("#domains_ids").val(elem.attr('data-domains_ids'));
        $("#maincontent_pixel").find(".pixel_global_add_btn").html("<strong>UPDATE CODE</strong>");
        $("#maincontent_pixel").find(".lp-heading-2").html("Update Pixel Code");
    }



    $('.close').click(function() {
        $("#alert-danger").find('span').text("");
        $('.alert').hide();
    });

    $('a[data-id]').not('.action-btn').click(function () {
        $('.global-items').removeClass('item-active');
        $("#gl-"+$(this).data('id')).addClass('item-active');
    });

    $(".glo-links ul li").on("click", function(e) {
        e.preventDefault();
        $(".glo-links ul li").removeClass("gl_active");
        $(this).addClass("gl_active");
    });

    $('.set-logo-toggle').checkboxpicker({
        html: true,
        offLabel: 'Client Logo <span class="glyphicon glyphicon-ok">',
        onLabel: 'Default Logo <span class="glyphicon">'
    });
    $('.set-logo-toggle').change(function() {
        $(this).siblings('.btn-group-cls').find('a.active span').addClass('glyphicon-ok');
        $(this).siblings('.btn-group-cls').find('a.active').siblings('a').find('span').removeClass('glyphicon-ok');

        if ($(this).prop('checked') == true) {
            $('#usedefault_logo').val('y');
            $('#logo_source').val('default');
            $('#useme_logo').val('n');
        }else{
            $('#useme_logo').val('y');
            $('#logo_source').val('client');
            $('#usedefault_logo').val('n');
        }
    });

    $('.set-image-toggle').checkboxpicker({
        html: true,
        offLabel: 'Client Image <span class="glyphicon">',
        onLabel: 'Default Image <span class="glyphicon glyphicon-ok">'
    });
    $('.set-image-toggle').change(function() {
        $(this).siblings('.btn-group-cls').find('a.active span').addClass('glyphicon-ok');
        $(this).siblings('.btn-group-cls').find('a.active').siblings('a').find('span').removeClass('glyphicon-ok');

        if ($(this).prop('checked') == true) {
        $('#use_me').val('n');
        $('#use_default').val('y');
        }else{
        $('#use_me').val('y');
        $('#use_default').val('n');
        }
    });

    //color picker
    //
    $('.colorSelector').ColorPicker({
        color: '#0000ff',


        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb) {
            $('#colorSelector').css('backgroundColor', '#' + hex);
            $("#background-overlay").val('#'+hex);
            setpreviewsetting();
        }
    });

    $('#ex1').bootstrapSlider({
        formatter: function(value) {
            $('#overlay_color_opacity').val(value);
            if ($('#overlay_active_btn').is(":checked")){
                $("#preview-overlay").css('opacity', value/100);
            }
            return   value +'%';
        },
        min: 1,
        max: 100,
        value: $('#overlay_color_opacity').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    //setupicseditor();
    $('#ex2').bootstrapSlider({
        formatter: function(value) {
            $('#background_size').val(value);
            $('#previewbox').css('background-size', value+'%');
            return   value +'%';
        },
        min: 1,
        max: 100,
        value: $('#background_size').val(),
        tooltip: 'always',
        tooltip_position:'bottom'
    });
    $( "body" ).on( "change","#overlay_active_btn" , function() {
            if($(this).is(":checked")) {
                $("#active-overlay").val("y");
            } else {
                $("#active-overlay").val("n");
            }
            setpreviewsetting();
    });
    //setupicseditor();
    function setpreviewsetting(){
        $('#previewbox').css({'background-repeat':$('#background-repeat').val(),'background-position':$('#background-position').val(),'background-size':$('#background_size').val()});
        //$('#previewbox').css({'background-repeat':'no-repeat','background-position':'center center','background-size':'cover'});
        var color = "#fff";
        var value=0;
        if($('#overlay_active_btn').is(":checked")){
            color = $("#colorSelector").css('backgroundColor');
            //$("#background-overlay").val('#'+hex);
            value=$('#ex1').val();
        }
        $("#preview-overlay").css("background-color", color);
        $("#preview-overlay").css('opacity', value/100);
    }
    $( "body" ).on( "change","#updateglobalbackgroundimage input:file" , function(e) {
        e.preventDefault();
        var filetype = this.files[0].type;
        if(filetype == "image/png" ||filetype == "image/jpeg" ||filetype == "image/jpg"){
        }else {
            jQuery("#bg-img-action-btn").hide();
            jQuery(this).parent("#bd-img-browse").removeClass("hide");
            jQuery('#previewbox').css('background-image', 'url("")');
            alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
            jQuery('#background_name').val('');
            jQuery("#bg-option-image-url").val('');
            return false;
        }
        var filesize=this.files[0].size/1024/1024;
        if(filesize < 2) {
            $("#bg-img-action-btn").show();
            $(this).parent("#bd-img-browse").addClass("hide");
            readURL(this);
            setpreviewsetting();
        }else {
            jQuery("#bg-img-action-btn").hide();
            jQuery(this).parent("#bd-img-browse").removeClass("hide");
            jQuery('#previewbox').css('background-image', 'url("")');
            alert('The size of image is too large, please try a smaller image.');
            jQuery('#background_name').val('');
            jQuery("#bg-option-image-url").val('');
        }

        return;
     });

    $("#updateglobalbackgroundimage #bg-img-change").on("click",function(e){
        e.preventDefault();
        $('#updateglobalbackgroundimage input:file').trigger('click');
        return;
    });
    $("#bg-img-remove").on("click",function(e){
        e.preventDefault();
        $("#bg-option-image-url").val("");
        $("#background_name").val("");
        $("#bg-img-action-btn").hide();
        $('#previewbox').css('background-image', "none");
        $("#preview-overlay").css('background-color','inherit');
        $("#preview-overlay").css('opacity', '1');
        $("#bd-img-browse").removeClass('hide');
        return;
    });
    $('#background-repeat').on('change', function(e) {
        e.preventDefault();
        $('#previewbox').css('background-repeat', this.value);
    });
    $('#background-position').on('change', function(e) {
        e.preventDefault();
        $('#previewbox').css('background-position', this.value);
    });
    $('#background_size').on('change', function(e) {
        e.preventDefault();
        $('#previewbox').css('background-size', this.value);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewbox').css('background-image', 'url(' + e.target.result + ')');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    jQuery("#bgimgapply").on('click',function(e){
        e.preventDefault();
        var target_element="";
        target_element=$(".collapse-bg-img:not(.collapsed)").data("targetele");
        switch (target_element) {
            case 'pulllogocolor':
                updateglobalbackgroundcolor();
            break;
            case 'backgroundimage':
                $("#background_type").val("3");
                if ($("#lpkey_backgroundimage").val() == '') {
                  errormessage("Please Select Funnel From List.");
                  //alert("Please Select Funnel From List");
                  return;
                }else if ($("#background_name").val() == '' && $("#bg-option-image-url").val() =='') {
                    errormessage("Please Select the Background Image.");
                    return;
                /*}else if ($("#background-overlay").attr('name') != '' && $("#background-overlay").val() == '') {
                    alert("Background Overlay is Empty");
                    return;*/
                /*}else if(jQuery('#background_name').val() == '' && $("#bg-option-image-url").val() !=''){
                    alert("You are not select the Background Image.We will use the old Image for that setting. ")*/
                }
                $('#updateglobalbackgroundimage').submit();
            break;
        }
    });
    if ($("#bg-option-image-url").val() !='') {
        $("#bd-img-browse").addClass('hide');
        $("#bg-img-action-btn").show();
        var previewcss={
            'background-image':'url(' + $("#bg-option-image-url").val() + ')',
            'background-repeat':$("#bg-image-data-info").data('background-repeat'),
            'background-position':$("#bg-image-data-info").data('background-position'),
            'background-size':$("#bg-image-data-info").data('background-size')
        }
        $("#background-repeat").val($("#bg-image-data-info").data('background-repeat')).change();
        $("#background-position").val($("#bg-image-data-info").data('background-position')).change();
        $("#background_size").val($("#bg-image-data-info").data('background-size')).change();
        var previewcssoverlay={
            'background-color':$("#background-overlay").val(),
            'opacity':$('#overlay_color_opacity').val()/100
        }
        $('#previewbox').css(previewcss);
        if ($('#overlay_active_btn').is(":checked")){
            $('#preview-overlay').css(previewcssoverlay);
            //$('#preview-overlay').css(previewcssoverlay);
        }

    }

    $('#isnewrowid').val('y');
    $('#thankyou_active').val('y');
    $('#thirdparty_active').val('n');
    $('#https_active').val('n');
    $('#html_active').val('y');
    $('#text_active').val('n');
    $('#responder_active').val('y');
    $('#use_default').val('n');
    $('#use_me').val('y');
    $('#usedefault_logo').val('n');
    $('#useme_logo').val('y');
    $('#is_primary').val('n');

    //    Auto responder
    $('input[data-id]').click(function(){
        if($('#r3').is(':checked')){
            $('#textwrapper').removeClass('editor-inactive');
//                $('#textwrapper-area').addClass('editor-inactive');
            $('#lp-html-editor').addClass('editor-active');
            $('#lp-text-editor').removeClass('editor-active');
            $('#html_active').val('y');
            $('#text_active').val('n');
        }else{
            $('#textwrapper').addClass('editor-inactive');
            $('#lp-html-editor').removeClass('editor-active');
            $('#lp-text-editor').addClass('editor-active');
            $('#text_active').val('y');
            $('#html_active').val('n');
        }
    });
    // $('input[data-id]').click(function () {
    //     $('.lp-email-section').removeClass('editor-active');
    //     var cur_editor=$(this).data('id').split("-");
    //     if ($(this).data('id') == "html-editor") {
    //         $('#html_active').val('y');
    //         $('#text_active').val('n');
    //     }else if ($(this).data('id') == "text-editor"){
    //         $('#text_active').val('y');
    //         $('#html_active').val('n');
    //       }
    //     $("#theoption").val(cur_editor[0]);
    //     $("#lp-"+$(this).data('id')).addClass('editor-active');
    //     if ($('#textwrapper').hasClass('editor-inactive')) {
    //         $('#textwrapper').removeClass('editor-inactive');
    //     } else {
    //         $('#textwrapper').addClass('editor-inactive');
    //     }
    // });
    $('.seo-toggle,.company-toggle,.phonenumber-toggle,.email-toggle,.https-toggle,.responder-toggle').change(function() {
          if ($(this).prop('checked') == true) {
            $('#'+$(this).data('field')).val('y');
        }else {
            $('#'+$(this).data('field')).val('n');
        }
    });
    $("#is_update_subline,#is_update_companyname,#is_update_phonenumber,#is_update_email,#is_update_newemail").change(function() {
        var id = $(this).attr('id');
        var input_id = id.split('_');
        if(this.checked) {
            $('#'+input_id[2]).attr('name', input_id[2]);
        }else{
            $('#'+input_id[2]).attr('name', '');
        }
    });

    // CTA
    $('.colorSelector-mmessagecp').ColorPicker({
            color: '#0000ff',
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
            }
        });

        //color picker
        $('.colorSelector-mdescp').ColorPicker({
            color: '#0000ff',
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
        /*var $form = $("#maincontent"),
        $successMsg = $(".alert");
        $form.validate({
            rules: {
                mmainheadingval: {
                    required: true,
                    minlength: 30
                },
                dmainheadingval: {
                    required: true,
                    minlength: 50
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

        });*/
        $('.thankyou-toggle').change(function() {

            if ($(this).prop('checked') == false) {
                $('#'+$(this).data('field')).val('n');
            }else {
                $('#'+$(this).data('field')).val('y');
            }
        });
        $('.gfooter-toggle').change(function() {
            if ($(this).prop('checked') == true) {
                $('#'+$(this).data('field')).val('y');
            }else {
                $('#'+$(this).data('field')).val('n');
            }
            $('#'+$(this).data('flagfield')).val('1');
        });

        //Url-edit-footer ,liences edit
        $('.lp_footer_toggle').click(function (e) {
            e.preventDefault();
            var tar_ele=$(this).data('togele');
            if($('#'+tar_ele).hasClass('hide')){
                $(this).html('<i class="fa fa-remove"></i> CANCEL');
                $('#'+tar_ele).removeClass('hide');
            }else{
                $('#'+tar_ele).addClass('hide');
                $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
            }
        });
    $('.lp_footer_toggle_compliance').click(function (e) {
        e.preventDefault();
        var tar_ele=$(this).data('togele');
        if($('#'+tar_ele).hasClass('hide')){
            $(this).html('<i class="fa fa-remove"></i> CANCEL');
            $('#compliance_text').prop("disabled", false);
            $('#'+tar_ele).removeClass('hide');

        }else{
            $('#'+tar_ele).addClass('hide');
            $('#compliance').removeClass('hide');
            $('#compliance_text').prop("disabled", true);
            $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
        }
    });
    $('.lp_footer_toggle_licence').click(function (e) {
        e.preventDefault();
        var tar_ele=$(this).data('togele');
        if($('#'+tar_ele).hasClass('hide')){
            $(this).html('<i class="fa fa-remove"></i> CANCEL');
            $('#license_number_text').prop("disabled", false);
            $('#'+tar_ele).removeClass('hide');

        }else{
            $('#'+tar_ele).addClass('hide');
            $('#license_number_text').prop("disabled", true);
            $(this).html('<i class="glyphicon glyphicon-pencil"></i> EDIT ');
        }
    });
        $('#compliance_is_linked,#license_number_is_linked').change(function(){
            var tar_ele=$(this).data('tarele');
            if($(this).is(':checked')){
                $('#'+tar_ele).prop('disabled' , false);
            }else{
                $('#'+tar_ele).prop('disabled' , true);
            }
        });

        $( "body" ).on( "click","#bkactive,#bkinactive" , function() {
        });
        $(".gsmainmenu").on('click',function(e){
            e.preventDefault();
            var ele_val=$(this).data('id');
            var target_ele="";
            $(".gsmainmenu").removeClass("gl_active");
            $(this).addClass("gl_active");
            switch(ele_val){
                case 'design':
                    target_ele="gl-design";
                break;
                case 'content':
                    target_ele="gl-content";
                break;
                case 'integration-pixels':
                    target_ele="gl-integration-pixels";
                break;
            }
            $("#"+target_ele).addClass('item-active');
            $("#"+target_ele+" .sub-tab-section .nav-tabs li:not(:first-child)").removeClass('active');
            $("#"+target_ele+" .sub-tab-section .nav-tabs li:first-child").addClass('active');
            $("#"+target_ele+" .tab-content div.tab-pane").removeClass('active in');
            $("#"+target_ele+" .tab-content > div:first-child").addClass('active in');
            if (!$(".global-links").find(".btn-wrapper").is(':visible')){
                $(".global-links").find(".btn-wrapper").show()
            }

        })

        $(".integration-pixels").find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href")
            if(target == "#integration"){
                $(".global-links").find(".btn-wrapper").hide()
            } else {
                $(".global-links").find(".btn-wrapper").show()
            }
        });

    $( "body" ).on( "change",".global_super_status_btn" , function() {
        update_super_footer_status($(this).prop('checked'));
    });
    $("#_reset_default_btn").click(function(e){ resetdefaultfooter();});

    $('#hideofooter:checkbox').click(function (){
        $("#global-advance-footer-save-btn").trigger('click');
    });

    $( "body" ).on( "click","#global-advance-footer-save-btn" , function() {
        update_super_footer_save(true);
    });
    setTimeout(function () {
        var advancehtml = $('.global_advance_footer .lp-froala-textbox').froalaEditor('html.get').length;
        if (advancehtml == 0) {
            $('.global_advance_footer .lp-froala-textbox').froalaEditor('html.set', $('#default-html').html());
        }
    },400);

    $("#_update_template_cta_btn").click(function(e){
        var radioValue = $("input[name='property_cta']:checked").val();
        if(radioValue == 'y'){
            updateglobaltemplatecta();
        } else {
            $('#modal_proerty_template').modal('toggle');
        }
        update_super_footer_save(false, radioValue);
        return;
    });
});

jQuery(window).on('load',function(){
    var active_inactive_flag=$("#active-inactive_info").data("activeinacflag");
    //console.log(active_inactive_flag);
    if(active_inactive_flag=="y"){
        // $("#bkactive").trigger("click");
        var _selector = $("#bkactive").attr('href');
        $(_selector).addClass('in');
        $("#bkinactive").addClass('collapsed');

    }else if(active_inactive_flag=="n"){
        // $("#bkinactive").trigger("click");
        var _selector = $("#bkinactive").attr('href');
        $(_selector).addClass('in');
        $("#bkactive").addClass('collapsed');
    }else{
        // $("#bkactive").trigger("click");
        var _selector = $("#bkactive").attr('href');
        $(_selector).addClass('in');
        $("#bkinactive").addClass('collapsed');
    }
    /*var b_size=$('#background_size').val();
    $('#previewbox').css('background-size', b_size);*/
    setupicseditor();

});

/*    $('#funnel-select').multiselect({
        enableFiltering: true,
        enableClickableOptGroups: true,
        includeSelectAllOption: true,
        maxHeight: 200,
        onChange: function(element,checked) {
            var getval = [];
            if ($('input.is_include').prop('checked') == false) {
                $(".multiselect-container").find('li').each(function(index, el) {
                    if (!$(el).hasClass('active') && !$(el).hasClass('multiselect-item')) {
                        key = $(el).find('input').val(); //3~8~22~1
                        getval.push(key);
                    };
                });
            }else if($('input.is_include').prop('checked') == true){
                $('#funnel-select option:selected').map(function(a, item){
                    getval.push(item.value);
                });
            }
            getval = getval.join(',');
            $("#lpkey_secfot,#lpkey,#lpkey_seo,#lpkey_thankyou,#lpkey_responder,#lpkey_maincontent,#lpkey_image,#lpkey_logo,#lpkey_background,#lpkey_notification,#lpkey_backgroundcolor,#lpkey_backgroundimage").val(getval);
        },
        onSelectAll: function() {
            var getval = [];
            if($('input.is_include').prop('checked') == true){
                $('#funnel-select option:selected').map(function(a, item){
                    getval.push(item.value);
                });
            }
            getval = getval.join(',');
            $("#lpkey_secfot,#lpkey,#lpkey_seo,#lpkey_thankyou,#lpkey_responder,#lpkey_maincontent,#lpkey_image,#lpkey_logo,#lpkey_background,#lpkey_notification,#lpkey_backgroundcolor,#lpkey_backgroundimage").val(getval);
        },
        onDeselectAll: function() {
            var getval = [];
            $('#funnel-select option:selected').map(function(a, item){
                getval.push(item.value);
            });
            getval = getval.join(',');
            $("#lpkey_secfot,#lpkey,#lpkey_seo,#lpkey_thankyou,#lpkey_responder,#lpkey_maincontent,#lpkey_image,#lpkey_logo,#lpkey_background,#lpkey_notification,#lpkey_backgroundcolor,#lpkey_backgroundimage").val(getval);
        }
    });
*/    function globalGetfileName(myFile){
        var file = myFile.files[0];
        console.info(file);
        var filename = file.name;
        jQuery("span.inputfilename").html(filename);
    }
    function uploadgloballogo(el) {
        var logosavetype = $(el).attr("id");
        $('#logosavetype').val(logosavetype);
        console.info($('.inputfilename').val());
        if ($('.inputfilename').html() == "" || $('.inputfilename').html() == "no file selected") {
            alert("Please Select Logo.");
            return;
        }
        $('#uploadgloballogo').submit();
    }
    function savegloballogo1(event,el) {
        event.preventDefault();
        var logosavetype = $(el).attr("id");
        $('#logosavetype').val(logosavetype);
        if ($('.main-logo img').attr('src') == "") {
            alert("Please Select Logo.");
            return;
        }
        if ($("#lpkey_logo").val() == '') {
            errormessage("Please Select Funnel From List.");
            //alert("Please Select Funnel From List");
            return;
        };
        if ($("#lpkey").val() == '') {
            console.info("select the Funnels");
            return;
        };
        $('#uploadgloballogo').submit();
    }
    function globalGetImagefileName(myFile){
        var file = myFile.files[0];
        console.info(file);
        var filename = file.name;
        jQuery("span.inputimagefilename").html(filename);
    }

    function uploadglobalimage(el) {

        var saveimagetype = $(el).attr("id");
        $('#saveimagetype').val(saveimagetype);
        if ($('.inputimagefilename').html() == "" || $('.inputimagefilename').html() == "no file selected") {
            alert("Please Select Image.");
            return;
        }
        $('#uploadglobalimage').submit();
    }
    function saveglobalimage(event,el) {
        event.preventDefault();
        var saveimagetype = $(el).attr("id");
        $('#saveimagetype').val(saveimagetype);
        if ($('.main-image img').attr('src') == "") {
            alert("Please Select Image.");
            return;
        }
        if ($("#lpkey_image").val() == '') {
            //alert("Please Select Funnel From List");
            errormessage("Please Select Funnel From List.");
          return;
        };
        if ($("#lpkey").val() == '') {
            return;
        };
        $('#uploadglobalimage').submit();
    }
    function setupicseditor(){
        var gtempswatches=Array();
       var gswatchesjson=$("#data-background-swatches").val();
        if(gswatchesjson){
            gtempswatches = jQuery.parseJSON(gswatchesjson);
        }
        var gicsgeOpts = {
            interface : ['gradient',"swatches"],
            startingGradient : true,
            targetCssOutput : 'all',
            targetElement : jQuery('.gradient'),
            defaultGradient : 'linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)',
            defaultCssSwatches : ['linear-gradient(to right bottom,rgba(3, 130, 63, 1) 0%,rgba(3, 130, 63, 1) 100%)'],
            targetInputElement : jQuery('.gradient-result'),
            localStoragePrefix: '' // default value for getting the swatches from local storage 'icsge' otherwise value has been empty

        };
        if(gtempswatches.length > 0){
            gicsgeOpts.startingGradient=gtempswatches[0];
            gicsgeOpts.defaultGradient=gtempswatches[0];
            gicsgeOpts.defaultCssSwatches=gtempswatches;
        }
        if(gtempswatches.length < 28){
            gicsgeOpts.startingGradient = false;
            gicsgeOpts.localStoragePrefix = 'icsge';
        }
        //console.log(gicsgeOpts.defaultGradient);
        //console.log(gicsgeOpts.defaultCssSwatches);
        jQuery('#ics-gradient-editor-1').icsge(gicsgeOpts);

    }

    /**
     * Returns an array with arrays of the given size.
     *
     * @param myArray {Array} array to split
     * @param chunk_size {Integer} Size of every group
     */
    function chunkArray(myArray, chunk_size){
        var index = 0;
        var arrayLength = myArray.length;
        var tempArray = [];

        for (index = 0; index < arrayLength; index += chunk_size) {
            myChunk = myArray.slice(index, index+chunk_size);
            tempArray.push(myChunk);
        }

        return tempArray;
    }

    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    function updateglobalbackgroundcolor(){
        if ($("#lpkey_backgroundcolor").val() == '') {
          errormessage("Please Select Funnel From List.");
          //alert("Please Select Funnel From List");
          return false;
        };
        //$("#leadpopovery").show();
        $("#mask").show();
        var background = $(".gradient-result").val();
        var start = parseInt(background.indexOf("###") + 6);
        var end = parseInt(background.indexOf("@@@") - 3);
        var testFontColor = background.slice(start,end);
        var regExp = /\(([^)]+)\)/;
        var fontcolor = "";
        try {
          var matches = regExp.exec(testFontColor);
          var rgba = matches[1].split(",");
          var red = rgba[0].trim();
          var green = rgba[1].trim();
          var blue = rgba[2].trim();
          var alpha = rgba[3].trim();
          fontcolor = rgbToHex(red,green,blue,alpha);
        }
        catch(err) {
            var loc =  testFontColor.indexOf("#");
            var tempstr = testFontColor.substring(loc);
            fontcolor = tempstr.trim();
        }


        var data = "background=" + encodeURIComponent($(".gradient-result").val());
        data = data + "&gradient=" + encodeURIComponent($("#colordiv").attr("style"));
        data = data + "&client_id=" + jQuery("#client_id").val();
        data = data + "&fc=" + fontcolor;
        data = data + "&fontcolor=" + rgb2hex(fontcolor);
        data = data + "&lpkey_backgroundcolor=" + encodeURIComponent($("#lpkey_backgroundcolor").val());
        data = data + "&total_keys=" + encodeURIComponent($("#totalkeys").val());
        data = data + "&swatchnumber=1";
        data = data + "&background_type=1";
        data = data + '&_token='+ajax_token;
        jQuery.ajax( {
            type : "POST",
            data : data,
            timeout: 10000,
            url: site.baseUrl+site.lpPath+'/global/updateglobalbackgroundcolor',
            success : function() {
                //$("#leadpopovery").hide();
                $("#mask").hide();
                goToByScroll("success-alert");
                $("#success-alert").find('span').text("Background Color has been saved.");
                $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                    $(this).slideUp(500);
                });
               //$(window).load();
            },
            error: function (data, textStatus, errorThrown) {
                console.log(textStatus);
                if(textStatus == "timeout") {
                    console.log("Got timeout");
                    setTimeout(function(e){
                        $("#mask").hide();
                        goToByScroll("success-alert");
                        $("#success-alert").find('span').text("Background Color has been saved.");
                        $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                            $(this).slideUp(500);
                        });
                    }, (120 * 100))
                }
            }
        });
    }

    function rgb2hex(color) {
        var isRgb = color.includes("rgb");
        if(isRgb) {
            rgb = color.match(/rgb.*\((\d+),\s*(\d+),\s*(\d+).*\)$/);
            return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
        } else {
            return color;
        }
    }
    function hex(x) {
        var hexDigits = new Array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
        return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
    }

    function saveglobalautoresponder() {
        //$('#savingmodal').dialog('open');
        if ($("#lpkey_responder").val() == '') {
            errormessage("Please Select Funnel From List.");
            //alert("Please Select Funnel From List");
            return;
        };
        if ($("#html_active").val()=='y') {
            var html = lp_html_editor.froalaEditor('html.get');
            newstr = html.replace(/(\r\n|\n|\r)/gm,"");
            newstr = newstr.replace(/\t/g, '');
            if(newstr.indexOf('<body></body>') == -1){
                $('#globalfhtml').submit();
            }else{
                alert("Auto Responder is Empty");
                return;
            }
        }else if($("#text_active").val()=='y'){
            var oEditortext = $('.textautoeditor');
            var text = oEditortext.val();
            newtext = text.replace(/(\r\n|\n|\r)/gm,"");
            newtext = newtext.replace(/\t/g, '');
            if(newtext == ''){
                alert("Auto Responder is Empty");
                return;
            }else{
                $('#globalfhtml').submit();
            }
        }

    }
    function saveglobalcontactmessage() {
        if ($("#lpkey").val() == '') {
            errormessage("Please Select Funnel From List.");
            //alert("Please Select Funnel From List");
            return;
        };
        var companyname = $("#companyname").attr('name');
        var phonenumber = $("#phonenumber").attr('name');
        var email = $("#email").attr('name');

        /*if (companyname =='companyname' && $('#companyname').val() =='') {
            alert("Selected Field is Empty");
            return;
        }else if(phonenumber=='phonenumber' && $('#phonenumber').val() ==''){
            alert("Selected Field is Empty");
            return;
        }else if(email=='email' && $('#email').val() ==''){
            alert("Selected Field is Empty");
            return;
        }*/
        $('#globalcontactinfo').submit();
    }

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

    function updateAdaAccessibility() {
        if ($("#lpkey_ada_accessibility").val() == '') {
            errormessage("Please Select Funnel From List.");
            //alert("Please Select Funnel From List");
            return;
        };

        if ($("input[name='is_ada_accessibility']:checked").val() == undefined) {
            errormessage("Please Select ADA accessibility option.");
            return;
        }

        $('#adaAccessibilityForm').submit();
    }


    function saveglobalmaincontent() {
        if ($("#lpkey_maincontent").val() == '') {
            errormessage("Please Select Funnel From List.");
            //alert("Please Select Funnel From List");
            return;
        };
        $('#maincontent').submit();
    }

    function checkURL(element) {
        var value = element.val();
        if(value == ''){
            element.addClass('error');
            $('.thirdpartyurl_error').text('Please enter URL.').slideDown();
            return false;
        }
        if(value.substr(0,7) != 'http://' && value.substr(0,8) != 'https://')value = 'http://' + value;
        if(value.substr(value.length-1, 1) != '/')value = value + '/';

        var url = new RegExp(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,7}(:[0-9]{1,5})?(\/.*)?$/i);

        if (url.test(value)) {
            element.removeClass('error');
            $('.thirdpartyurl_error').text('Please enter a valid URL.').slideUp();
            return true;
        }else{
            element.addClass('error');
            $('.thirdpartyurl_error').text('Please enter a valid URL.').slideDown();
        }
        return false;
    }
    var error_flag = false;
    $('#thirdpartyurl').on('keyup',function(){
        if(error_flag){
            checkURL($(this));
        }


    });

    function globalsavethankyou() {
        error_flag = true
        var html = $('.lp-thankyou .lp-froala-textbox').froalaEditor('html.get');
        newstr = html.replace(/(\r\n|\n|\r)/gm,"");
        newstr = newstr.replace(/\t/g, '');
        if ($("#lpkey_thankyou").val() == '') {
            errormessage("Please Select Funnel From List.");
            //alert("Please Select Funnel From List");
            return;
        };
        if($('#thirldparty-toggle').prop('checked')){
            if(checkURL($('#thirdpartyurl'))){
                $('#thirdpartyurl').trigger("blur");
                $('#globalthankyou').submit();
            }
        }else{
            $('#thirdpartyurl').trigger("blur");
            $('#globalthankyou').submit();
        }

        /*if(newstr.indexOf('<body></body>') == -1){
            $('#globalthankyou').submit();
        }else{
            alert("Thank You Message is Empty");
            return;
        }    */
    }

    function globalsaveseo(){
        if ($("#lpkey_seo").val() == '') {
            errormessage("Please Select Funnel From List.");
            //alert("Please Select Funnel From List");
            return;
        };
        $('#globalseo').submit();
    }

    function update_super_footer_status(status) {
        var error=false;
        var client_id = $('#client_id').val();
        if ($("#selectedfunnel").val() == '') {
            $('.global_super_status_btn').parents().find('#advance-footer-wrapper .custom-btn-toggle .toggle').removeClass('btn-success').addClass('btn-danger off');
            $('.global_super_status_btn').parents().find('#advance-footer-wrapper .toggle-group').removeClass('lp-white');
            errormessage("Please Select Funnel From List. <br>");
            return false;
        }else {
            var funnelinfo = $("#selectedfunnel").val();
            $.ajax( {
                type : "POST",
                url : "/lp/global/updatestatusglobaladvancefooter",
                data : { "funnels-info":funnelinfo, "footer_status":status, _token:ajax_token },
                success : function(d) {
                    // $('.global_super_status_btn').parents().find('#advance-footer-wrapper .custom-btn-toggle .toggle').removeClass('btn-danger off').addClass('btn-success');
                    // $('.global_super_status_btn').parents().find('#advance-footer-wrapper .toggle-group').addClass('lp-white');
                },
                cache : false,
                async : false
            });
        }

    }

    function update_super_footer_save(flag, defaultTplCtaMessage = "n") {
        var error=false;
        var client_id = $('#client_id').val();
        if ($("#selectedfunnel").val() == '') {
            $('.global_super_status_btn').parents().find('#advance-footer-wrapper .custom-btn-toggle .toggle').removeClass('btn-success').addClass('btn-danger off');
            $('.global_super_status_btn').parents().find('#advance-footer-wrapper .toggle-group').removeClass('lp-white');
            errormessage("Please Select Funnel From List. <br>");
            return false;
        }else {
            if(flag == true){
                var templatetype = $('#templatetype').val();
                if ((templatetype == 'property_template' || templatetype == 'property_template2')) {
                    // $("#modal_proerty_template").find(".modal-msg").html('<p>Would you like to use our default CTA Message that goes with Property Template?</p>');
                    $("#modal_proerty_template").modal();
                    return;
                }
            }
            var funnelinfo = $("#selectedfunnel").val();
            var html =  $('.global_advance_footer .lp-froala-textbox').froalaEditor('html.get');

            var hideofooter  = '';
            if($('#hideofooter:checkbox:checked').length){
                hideofooter = 'y';
            } else {
                hideofooter  = 'n';
            }

            $.ajax( {
                type : "POST",
                url : "/lp/global/updateglobaladvancefooter",
                data : {"funnels-info":funnelinfo,"client_id":$('#client_id').val() ,"logocolor":$('#logocolor').val(), "templatetype":$('#templatetype').val(), "defaultTplCtaMessage":defaultTplCtaMessage, "fr-html":html,"hideofooter":hideofooter,_token:ajax_token},
                success : function(d) {
                    succmessage("Advanced footer option has been saved.");
                },
                cache : false,
                async : false
            });
        }
    }
    function updateglobaltemplatecta(){
        var error = false;
        var client_id = $('#client_id').val();
        var funnelinfo = $("#selectedfunnel").val();
        var html =  $('.global_advance_footer .lp-froala-textbox').froalaEditor('html.get');
        var hideofooter  = '';
        if($('#hideofooter:checkbox:checked').length){
            hideofooter = 'y';
        } else {
            hideofooter  = 'n';
        }
        $.ajax( {
            type : "POST",
            url : "/lp/ajax/updatetemplatecta",
            data : {"funnels-info":funnelinfo,"fr-html":html,"client_id":$('#client_id').val(),"hideofooter":hideofooter,'is_global':true,_token:ajax_token},
            success : function(d) {
                if (d == 'y') {
                    $('#modal_proerty_template').modal('toggle');
                }
            },
            cache : false,
            async : false
        });
    }

    function compliance_update () {
        var error=false;
        var client_id = $('#client_id').val();
        if ($("#lpkey_secfot").val() == '') {
            errormessage("Please Select Funnel From List. <br>");
            return;
        }
        //$("#leadpopovery").show();
        $("#mask").show();
        var compliance_text = $('#compliance_text').val();
        var compliance_is_linked = 'n';
        var compliance_link = $('#compliance_link').val();
        var license_number_text = $('#license_number_text').val();

        if($('#compliance_is_linked:checkbox:checked').length){
            if(compliance_link=="")
                compliance_link = "#";
            label_compliance_text = "<a target='_blank' href='"+compliance_link+"'>"+compliance_text+"</a>";
            compliance_is_linked = 'y';
        }else{
            label_compliance_text = compliance_text;
        }

        var license_number_is_linked = 'n';
        if($('#license_number_is_linked:checkbox:checked').length){
            license_number_is_linked = 'y';
        }
        var license_number_link = $('#license_number_link').val();

        $('#label_compliance_text').html(label_compliance_text);
        $('#label_license_number_text').html(license_number_text);

        //var post =  "client_id=" + client_id + "&vertical_id=" + vertical_id +  "&subvertical_id=" + subvertical_id + "&leadpop_id=" + leadpop_id + "&version_seq=" + version_seq + "&compliance_text="+compliance_text+"&compliance_is_linked="+compliance_is_linked+"&compliance_link="+compliance_link+"&license_number_text="+license_number_text+"&license_number_link="+license_number_link+"&license_number_is_linked="+license_number_is_linked;
        var post = {client_id:client_id,lpkey_secfot:$("#lpkey_secfot").val(),compliance_text:compliance_text,compliance_is_linked:compliance_is_linked,compliance_link:compliance_link,license_number_text:license_number_text,license_number_link:license_number_link,license_number_is_linked:license_number_is_linked,_token:ajax_token};
        post.sec_fot_url_active=$("#sec_fot_url_active").val();
        post.sec_fot_license_number_active=$("#sec_fot_license_number_active").val();
        post.gfot_ai_val=$("#gfot_ai_val").val();
        post.gfot_ai_val1=$("#gfot_ai_val1").val();
        post.thelink=$("#thelink").val();
        post.gfot_ai_flg=$("#gfot-ai-flg").val();
        post.gfot_ai_flg1=$("#gfot-ai-flg1").val();
        console.log(post);
        if(error===false){
            $.ajax( {
                type : "POST",
                url: site.baseUrl+site.lpPath+'/global/updatecompliance',
                data : post,
                success : function(data) {
                    var obj = jQuery.parseJSON( data );
                    /*console.log(obj.changeto);
                    console.log(obj.changeto1);
                    console.log(obj.result);*/
                    if(obj.changeto !="undefined" && obj.changeto !="" ){
                        $("#sec_fot_url_active").val(obj.changeto);
                        $("#gfot_ai_val").val(obj.changeto);
                    }
                    if(obj.changeto1 !="undefined" && obj.changeto1 !="" ){
                        $("#sec_fot_license_number_active").val(obj.changeto1);
                        $("#gfot_ai_val1").val(obj.changeto1);
                    }
                    //$("#leadpopovery").hide();
                    $("#mask").hide();
                    $("#gfot-ai-flg").val('0');
                    $("#gfot-ai-flg1").val('0');
                    if(obj.result==true){
                        $("#success-alert").find("span").text("Success ! Global Secondary Footer Option has been saved..");
                        goToByScroll("success-alert");
                        $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                            $(this).slideUp(500);
                        });
                    }else{
                        errormessage("Error:Setting compliance and lincense.");
                    }
                }
            });
        }
        return false;
    }
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($.trim($(element).text())).select();
        document.execCommand("copy");
        $temp.remove();
    }

    function pixel_extra_fields___old(type, placement, elem){
        if(type == 2 && placement == 4){
            $(".pixel_extra").hide();
            $("#pixel_other").val('');

            $(".facebook_pixel_action").show();

            if(elem) {
                $("#pixel_action").val(elem.attr('data-pixel_action'));
                $('[data-name="pixel_action"]').find(".displayText").html(elem.attr('data-pixel_action_label'));
            }
        }
        else if(type == 4 || type == 6 || type == 7){
            $(".pixel_extra").hide();
            $("#pixel_action").val('');
            $(".pixel_other").show();

            if(type == 4) $(".pixel_other .pixel_other_label").html("Conversion Label");
            if(type == 6) $(".pixel_other .pixel_other_label").html("Targeting to");
            if(type == 7) $(".pixel_other .pixel_other_label").html("Lender ID");

            if(elem) {
                $("#pixel_other").val(elem.attr('data-pixel_other'));
            }
        }
        else{
            $(".pixel_extra").hide();
            $("#pixel_action").val('');
            $("#pixel_other").val('');
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

    $(".pixel_extra").hide();
    $("#pixel_other").val('');



    if(type == GOOGLE_ANALYTICS) $(".tracking_to_lender").html("Tracking ID");
    else if(type == FACEBOOK_PIXEL) $(".tracking_to_lender").html("Pixel ID");
    else if(type == GOOGLE_TAG_MANAGER) $(".tracking_to_lender").html("Container ID");
    else if(type == GOOGLE_CONVERSION_PIXEL) $(".tracking_to_lender").html("Conversion ID");
    else if(type == BING_PIXEL) $(".tracking_to_lender").html("Tag ID");
    else if(type == GOOGLE_RETARGETING_PIXEL) $(".tracking_to_lender").html("Conversion ID");
    else if(type == INFORMA_PIXEL) $(".tracking_to_lender").html("Lender ID");



    if(placement == PAGE_THANKYOU){

        $(".pixel_position").hide();

        if(type == FACEBOOK_PIXEL){
            $(".facebook_pixel_action").show();

            $("#pixel_action").val(PIXEL_ACTION_LEAD);
            if(elem) {
                /*
                if(elem.attr('data-pixel_action') !== "") {
                    var pixel_actions = elem.attr('data-pixel_action').split(",");
                    $.each(pixel_actions, function (i, id) {
                        $("#pixels").find('#pixel_action_' + id ).prop('checked',true);
                    });
                }
                */

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
function activetodefaultadvancedfooter(){
    if ($("#lpkey_thankyou").val() == '') {
        errormessage("Please Select Funnel From List.");
        //alert("Please Select Funnel From List");
        return;
    };
    $("#modal_reset_default").find(".modal-msg").html('<p>Are you sure you want to reset back to the default advanced footer content?</p>');
    $("#modal_reset_default").modal();
}
function resetdefaultfooter(){
    $('.global_advance_footer .lp-froala-textbox').froalaEditor('html.set', $('#default-html').html());
    $('.global_advance_footer .lp-froala-textbox').froalaEditor('events.focus', false);
    $('#modal_reset_default').modal('toggle');
    $('#advance-footer-wrapper .lp-footer-save .custom-btn-success button').trigger('click');
    goToByScroll("advanced-success-alert");
    $("#advanced-success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $(this).slideUp(500);
    });
}
