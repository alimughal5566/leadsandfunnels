$(document).ready(function () {


    var $form = $("#thankyou-page-from");
    ajaxRequestHandler.init("#thankyou-page-from");

    $('#main-submit').on('click', function () {
        // if (GLOBAL_MODE) {
        //     if (checkIfFunnelsSelected())
        //         $form.submit();
        // } else {
        //     $form.submit();
        // }
        $form.submit();
    });

    donn();

    //   $('#https_flag').trigger('change');
    //  $('#https_flag').trigger({type: 'select2:select'});


    // $(document).on('change', '#https_flag', function () {
    // $('#https_flag').on('change', function () {
    //     // debugger;

    //     // if (GLOBAL_ADJUSTMENT)
    //        /* if (GLOBAL_MODE) {
    //             var val = $(this).data('global_val');

    //             if (val === 'y') {
    //                 $(this).val('https://');
    //             } else if (val === 'n') {
    //                 $(this).val('http://');
    //             }

    //         } else {*/

    //             var val = $(this).data('val');

    //             if (val === 'y') {
    //                 $(this).val('https://');
    //             } else if (val === 'n') {
    //                 $(this).val('http://');
    //             }
    //         // }
    // });

    $($form).validate({
        rules: {
            footereditor: {
                thirldpurl: function (element) {
                    return $("#thirldparty").is(':checked');
                },
                required: function (element) {
                    return $("#thirldparty").is(':checked');
                }
            }
        },
        messages: {
            footereditor: {
                thirldpurl: "Please enter a valid URL.",
                required: "Please enter your URL."
            }
        },
        submitHandler: function (form) {
            ajaxRequestHandler.submitForm();
            // debugger;
            // if (GLOBAL_MODE) {
            //     if (checkIfFunnelsSelected()) {
            //         //  debugger;
            //         if (confirmationModalObj.globalConfirmationCurrentForm == $form) {
            //             form.submit();
            //         } else {
            //             showGlobalRequestConfirmationForm($form);
            //         }
            //     }
            //     // form.submit();
            // } else {
            //     form.submit();
            // }
        }
    });


    function donn() {
        var da = $('#https_flag');
        /* if (GLOBAL_MODE) {
             if ($(da).data('global_val') === 'y') {
                 $(da).val('https://')
             } else $(da).val('http://')
         } else {*/
        if ($(da).data('val') === 'y') {
            $(da).val('https://')
        } else $(da).val('http://');
        // }
        $(da).trigger('change')
    }


    var amIclosing = false;
    $('.url-prefix').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-url-prefix')
    }).on('select2:openning', function () {
        jQuery('.select2__parent-url-prefix .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2__parent-url-prefix .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2__parent-url-prefix .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-url-prefix .select2-dropdown').hide();
        jQuery('.select2__parent-url-prefix .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2__parent-url-prefix .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-url-prefix .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.url-prefix').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2__parent-url-prefix .select2-selection__rendered').show();
        jQuery('.select2__parent-url-prefix .select2-results__options').css('pointer-events', 'none');
    });

    $('.dynamic-anwser').select2({
        minimumResultsForSearch: -1,
        width: '430px', // need to override the changed default
        dropdownParent: $('.dynamic-anwser-parent')
    });


    //*
    // ** Active / Inactive options
    // *

    // $( "body" ).on( "change",".thktogbtn" , function(e) {
    // $( ".thktogbtn" ).on( "change", function(e) {]

    var tid = '';

    $(".thktogbtn").change(function (e) {

        if (tid === '')
            tid = e.currentTarget.id;


        if (e.currentTarget.id !== tid)
            return false;

        tid = e.currentTarget.id;

        setTimeout(function () {
            tid = ''
        }, 400);


        $("#changebtn").val("1");
        if ($(this).is(':checked')) {
            $('.thktogbtn').not(this).each(function () {
                $(this).bootstrapToggle("off");
            });
            $("#" + $(this).data("thelink")).val("y");
            $("#" + $(this).data("otherlink")).val("n");
            // $("#"+$("#thirldparty-toggle").data("thelink")).val("n");
        } else {
            $('.thktogbtn').not(this).each(function () {
                $(this).bootstrapToggle("on");
            });
            $("#" + $(this).data("thelink")).val("n");
            $("#" + $(this).data("otherlink")).val("y");
            // $("#"+$("#thirldparty-toggle").data("thelink")).val("y");
        }

    });


    $(".lp_thankyou_toggle").click(function (e) {
        e.preventDefault();
        $(".third-party__panel").slideToggle({
            start: function () {
                $(this).css({
                    display: "flex"
                });
                $(".action__link_edit").hide();
                $(".action__link_cancel").css({
                    display: "flex"
                });
                $("#thirldpurl").focus();
                $(".button-switch .thktogbtn").bootstrapToggle('on');
            }
        });

    });
    $(".action__link_cancel").click(function () {
        $(".third-party__panel").slideToggle({
            start: function () {
                $(this).css({
                    display: "flex"
                });
                $(".action__link_edit").show();
                $(".action__link_cancel").hide();
            }
        })
    });

    //*
    // ** URL Validation
    // *

    $("#thrd_url").blur(function () {
        var text = $(this).val();
        var replace = text.replace(/(^\w+:|^)\/\//, '');
        console.info(replace)
        $(this).val(replace);
        // return replace;
    });

    $.validator.addMethod("thirldpurl", function (value, element) {
        return this.optional(element) || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Please enter a valid URL.");


    //*
    // ** Thank You Edit Page Editor
    // *

    if ($('#lp-html-editor').length > 0) {
        // CK editor
        //CKEDITOR.replace( 'lp-html-editor' );
        //CKEDITOR.config.allowedContent = true;

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.toolbar_Basic =
            [
                ['Source'],
                ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'SpellChecker'],
                ['Undo', 'Redo', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
                ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
                ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'],
                ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'], ['TextColor', 'BGColor'], ['Maximize', 'ShowBlocks'],
                ['Link', 'Unlink', 'Anchor', 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'], ['Styles', 'Format', 'Font', 'FontSize']
            ];

        var editorauto = CKEDITOR.replace('lp-html-editor', {
            //toolbar : 'Basic',
            filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl: '/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/uploads/',
            filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/images/',
            filebrowserFlashUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash&currentFolder=/flash/',
            filebrowserWindowWidth: '1000',
            filebrowserWindowHeight: '700'
        });
    }

    $("#typ_logo").change(function (e) {
        //var editor =  CKEDITOR.instances['lp-html-editor'];
        let editor = lpHtmlEditor.getInstance();
        var advancehtml = editor.html.get();
        if ($(this).is(":checked")) {
            $("#thankyou_logo").val(1);
            var img = new Image();
            img.src = $("#default_logo").attr('src');
            console.log(img.src);
            img.onload = function () {
                /*
                if(this.width > 350)
                    var html = "<img alt=\"\" id=\"defaultLogo\" width=\"350\" src=\"" +$("#default_logo").attr('src') +"\" />";
                else
                    var html = "<img alt=\"\" id=\"defaultLogo\" src=\"" +$("#default_logo").attr('src') +"\" />";
               */
                //var html = "<img alt=\"\" id=\"defaultLogo\" width=\"350\" src=\"" +$("#default_logo").attr('src') +"\" />";
                var html = "<img alt=\"\" id=\"defaultLogo\" style=\"max-width: 350px; max-height: 120px;\" src=\"" + $("#default_logo").attr('src') + "\" class=\"fr-fic fr-dib thank-page-image\" />";

                editor.html.set("<p id=\"defaultLogoContainer\" style=\"text-align: center;\">" + html + "</p>" + advancehtml);
            }
        } else {

            $("#thankyou_logo").val(0);
            //advancehtml = advancehtml.replace(/<img(.*?)id="defaultLogo"(.*?)\/>/, '');
            advancehtml = advancehtml.replace(/<img(.*?)id="defaultLogo"(.*?)>/, '');
            advancehtml = advancehtml.replace(/<p(.*?)id="defaultLogoContainer"(.*?)>(.*?)<\/p>/, '');
            advancehtml = advancehtml.replace(/<p style="text-align: center;"><br><\/p>/, '');
            // advancehtml = advancehtml.replace(/<p>(.*?)<\/p>/, '');
            editor.html.set(advancehtml);
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

$('#clone-url').click(function () {
    copyToClipboard($('#url-text'));
    var html = '<div class="alert alert-success lp-success-msg">' +
        'Success! URL has been copied.' +
        '</div>';
    $(html).hide().appendTo("#msg").slideDown(500).delay(1000).slideUp(500, function () {
        $(this).remove();
    });

});


/*
function onThankYouToggleChange($id) {
    debugger;

     changeId =  $id === 'thankyou' ? 'thirldparty': 'thankyou';


    $("#changebtn").val("1");
    if ($('#' + $id).is(':checked')) {
        /!* $('.thktogbtn').not(this).each(function(){
             $(this).bootstrapToggle("off");
             return false;
         });*!/

        $('#' + changeId).bootstrapToggle("off");

    }else{
        // $('.thktogbtn').not(this).each(function(){
        // $(this).bootstrapToggle("on");
        // return false;
        //  });
        $('#' + changeId).bootstrapToggle("on");
    }

}
*/
