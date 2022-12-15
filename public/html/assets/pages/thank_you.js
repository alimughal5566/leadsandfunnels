$(document).ready(function () {

    var amIclosing = false;
    $('.url-prefix').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
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

    $('.dynamic-anwser').select2({
        minimumResultsForSearch: -1,
        width: '430px', // need to override the changed default
        dropdownParent: $('.dynamic-anwser-parent')
    }).on('select2:openning', function() {
        jQuery('.dynamic-anwser-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.dynamic-anwser-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.dynamic-anwser-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.dynamic-anwser-parent .select2-dropdown').hide();
        jQuery('.dynamic-anwser-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.dynamic-anwser-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.dynamic-anwser-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.dynamic-anwser').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.dynamic-anwser-parent .select2-selection__rendered').show();
        jQuery('.dynamic-anwser-parent .select2-results__options').css('pointer-events', 'none');
    });


    //*
    // ** Active / Inactive options
    // *

    $( "body" ).on( "change",".thktogbtn" , function(e) {
        $("#changebtn").val("1");
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

    $(".lp_thankyou_toggle").click(function () {
        $(".third-party__panel").slideToggle({
            start: function () {
                $(this).css({
                    //display: "flex"
                });
                $(".action__link_edit").hide();
                $(".action__link_cancel").css({
                    display: "flex"
                });
            }
        });
    });
    $(".action__link_cancel").click(function () {
        $(".third-party__panel").slideToggle({
            start: function () {
                $(this).css({
                    //display: "flex"
                });
                $(".action__link_edit").show();
                $(".action__link_cancel").hide();
            }
        })
    });

    //*
    // ** URL Validation
    // *

    $("#thrd_url").blur(function(){
        var text = $(this).val();
        var replace = text.replace(/(^\w+:|^)\/\//, '');
        console.info(replace)
        $(this).val(replace);
        // return replace;
    });

    $.validator.addMethod("cus_url", function (value, element) {
        return this.optional(element) || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Please enter a valid URL.");

    $("#thkform").validate({
        rules: {
            thrd_url: {
                required: true,
                cus_url: true
            }
        },
        messages: {
            thrd_url: {
                required: "Please enter your URL."
            }
        },
        submitHandler: function(form) {
            console.info('valid form submitted'); // for demo
            return false; // for demo
        }
    });

    //*
    // ** Thank You Edit Page Editor
    // *

    if($('#lp-html-editor').length > 0){
        // CK editor
        //CKEDITOR.replace( 'lp-html-editor' );
        //CKEDITOR.config.allowedContent = true;

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.toolbar_Basic =
            [
                ['Source'],
                ['Cut','Copy','Paste','PasteText','PasteFromWord', 'SpellChecker'],
                ['Undo','Redo','Find','Replace','-','SelectAll','RemoveFormat'],
                ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
                ['NumberedList','BulletedList','Outdent','Indent','Blockquote','CreateDiv'],
                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['TextColor','BGColor'],['Maximize', 'ShowBlocks'],
                ['Link','Unlink','Anchor','Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],['Styles','Format','Font','FontSize']
            ];

        var editorauto = CKEDITOR.replace( 'lp-html-editor',  {
            //toolbar : 'Basic',
            filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl :  '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/uploads/',
            filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/images/',
            filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash&currentFolder=/flash/',
            filebrowserWindowWidth : '1000',
            filebrowserWindowHeight : '700'
        });
    }

    $("#typ_logo").change(function (e){
        //var editor =  CKEDITOR.instances['lp-html-editor'];
        var advancehtml = $('.lp-froala-textbox').froalaEditor('html.get');
        if($(this).is(":checked")){
            $("#thankyou_logo").val(1);
            var img = new Image();
            img.src = $("#default_logo").attr('src');
            console.log(img.src);
            img.onload = function() {
                /*
                if(this.width > 350)
                    var html = "<img alt=\"\" id=\"defaultLogo\" width=\"350\" src=\"" +$("#default_logo").attr('src') +"\" />";
                else
                    var html = "<img alt=\"\" id=\"defaultLogo\" src=\"" +$("#default_logo").attr('src') +"\" />";
               */
                //var html = "<img alt=\"\" id=\"defaultLogo\" width=\"350\" src=\"" +$("#default_logo").attr('src') +"\" />";
                var html = "<img alt=\"\" id=\"defaultLogo\" style=\"max-width: 350px; max-height: 120px;\" src=\"" +$("#default_logo").attr('src') +"\" />";

                $('.lp-froala-textbox').froalaEditor('html.set', "<p id=\"defaultLogoContainer\" style=\"text-align: center;\">"+html+"</p>"+advancehtml);
            }
        } else {
            $("#thankyou_logo").val(0);
            //advancehtml = advancehtml.replace(/<img(.*?)id="defaultLogo"(.*?)\/>/, '');
            advancehtml = advancehtml.replace(/<img(.*?)id="defaultLogo"(.*?)>/, '');
            advancehtml = advancehtml.replace(/<p(.*?)id="defaultLogoContainer"(.*?)>(.*?)<\/p>/, '');
            advancehtml = advancehtml.replace(/<p style="text-align: center;"><br><\/p>/, '');
            advancehtml = advancehtml.replace(/<p>(.*?)<\/p>/, '');
            $('.lp-froala-textbox').froalaEditor('html.set', advancehtml);
        }
        return;
    });

});

function copyToClipboard(element) {
    var $temp = $("<INPUT>");
    $("body").append($temp);
    $temp.val($.trim($(element).text())).select();
    document.execCommand("copy");
    $temp.remove();
}
$('#clone-url').click(function(){
    copyToClipboard($('#url-text'));
    var html = '<div class="alert alert-success lp-success-msg">'+
        'Success! URL has been copied.'+
        '</div>';
    $(html).hide().appendTo("#msg").slideDown(500).delay(1000).slideUp(500 , function(){
        $(this).remove();
    });

});


