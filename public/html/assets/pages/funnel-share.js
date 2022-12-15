$(document).ready(function() {

    //*
    // ** Tooltip
    // *

    $('.el-tooltip').tooltipster({
        contentAsHTML:true
    });

    $(".lp-image__input").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function() {
        readURL(this);
    });

    $('.btn-image__del').click(function () {
        $('.browse__step1').slideDown();
        $('.browse__step2').slideUp();
        $(".img-frame__preview").attr('src','');
        $(".img-frame__preview").attr('alt','');
        $(".lp-image__input").val('');
        $('.file__size,.file__extension').slideUp("slow");
        $('.img-frame__wrapper .button-cancel').css({
            'cursor':'not-allowed',
        });
    });

    //*
    // **  Image Preview
    // *

    function readURL(input) {
        if (input.files && input.files[0]) {

            /*
             ** Profile Image Upload Validation
             */



            var file = input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg']) == -1) {
                $('.file__extension').slideDown("slow");
                $('.file__size').slideUp("slow");
                $('.file__imgsize').slideUp("slow");
            }
            else if (file.size > 4000000) {
                $('.file__size').slideDown("slow");
                $('.file__extension').slideUp("slow");
                $('.file__imgsize').slideUp("slow");

            }
            else {
                $('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function() {
                        if(this.width < 32 || this.height < 32){
                            $('.file__imgsize').slideDown("slow");
                        }else {
                            $('.file__imgsize').slideUp("slow");
                            $('.browse__step1').slideUp();
                            $('.browse__step2').css({'display':'flex'});
                            $('.img-frame__preview').attr('src', e.target.result );
                            $('.img-frame__preview').attr('alt', file.name );
                            $('.img-frame__wrapper .button-cancel').css({
                                'cursor':'pointer',
                            });
                        }
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    $('.link-swatcher').click(function (e) {
        e.preventDefault();
        jQuery(this).parents('.lp-panel__body').find('.funnel_url .input-holder').toggleClass('disable');
        jQuery(this).parents('.lp-panel__body').find('.funnel_url').toggleClass('hide-btns');
        jQuery(this).parents('.lp-panel__body').find('.url-expand').slideToggle();
    });


    jQuery('body').on( "click", ".lp-controls__edit", function(e) {
        e.preventDefault();
        var currVal = jQuery(this).parents('.url-expand').find('input.form-control').val();
        jQuery(this).parents('.url-expand').find('input.form-control').removeAttr('readonly').focus().val('');
        jQuery(this).parents('.url-expand').find('input.form-control').val(currVal);
        var _self = jQuery(this);
        _self.parents('.url-expand').find('input.form-control').select();
    });

    jQuery('body').on( "keyup", ".form-url-text", function(e) {
        e.preventDefault();
        var currVal = jQuery(this).val();
        console.log(currVal);
        jQuery(this).next().find('.inner-text').html(currVal);
    });

    jQuery('body').on( "blur", ".form-url-text", function(e) {
        jQuery('.form-url-text').prop('readonly', true);
    });
});

function copyToClipboard(element) {
    var myStr = $(element).text();
    var trimStr = $.trim(myStr);
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(trimStr).select();
    document.execCommand("copy");
    $temp.remove();
}