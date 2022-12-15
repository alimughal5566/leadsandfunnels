$(document).ready(function() {

    $(".lp-image__input").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function() {
        readURL(this);
        // valid_obj.form();
    });

    $('.btn-image__del').click(function () {
        $('.featured-img-del').hide();
        $('.browse__step1').slideDown();
        $('.browse__step2').slideUp();
        $(".img-frame__preview").attr('src','');
        $(".img-frame__preview").attr('alt','');
        $(".lp-image__input").val('');
        $('.file__size,.file__extension').slideUp("slow");
    });

    //*
    // **  favicon Image Preview
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
            }
            else if (file.size > 4000000) {
                $('.file__size').slideDown("slow");
                $('.file__extension').slideUp("slow");

            }
            else {
                $('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function() {
                        $('.file__imgsize').slideUp("slow");
                        $('.browse__step1').slideUp();
                        $('.browse__step2').css({'display':'flex'});
                        $('.img-frame__preview').attr('src', e.target.result );
                        $('.img-frame__preview').attr('alt', file.name );
                        $('.featured-img-del').show();
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

});