let requesting =false;
let defaultBackgroundImageURL ='';


function onSelect(event){
    console.log(event.target.value);
    if($('#browse_img').val()){
        $('.img-frame__controls').find('.btn-image__del').slideDown();
    }
}
$(document).ready(function() {

    defaultBackgroundImageURL =imagePath;
    bindEvent();
    moduleShareFunnel.init();

    function bindEvent(){
        console.log("binding!");
        $("#browse_img").click(function () {

        }).change(function() {
            // cloneAndSetValue();
            readURL(this);
        });
    }
    function cloneAndSetValue(){
        if($("#browse_img").val()){ // if there is any image value in the main file selector then we will make a clone other wise no need
            $("#required_social_image").remove();//Remove cloned field if there is any.
            $("#browse_img").clone().prop('id', 'temp_id').appendTo($("#browse_img").parent());   //clone original file selector (which may have some file) i.e. browse_img and give its id as temp_id
            $("#browse_img").attr('name', "image"); // as it may have some file so we are setting its name to "background_name" which is required in back end
            $("#browse_img").attr('id', "required_social_image"); // and we are setting its ids as required_social_image
            $('#temp_id').attr('name', "_image"); //now we are making newly cloned file selector the current file selector by giving its name _background_name
            $('#temp_id').attr('id', "browse_img"); //and giving its id browse_img
            bindEvent(); // Finally we are binding events again as binding is broken due to clone
        }
    }

    //*
    // ** Tooltip
    // *

    $('.el-tooltip').tooltipster({
        contentAsHTML:true,
        debug:false
    });

    // $(".lp-image__input").click(function () {
    //     $('.file__size,.file__extension').hide();
    // }).change(function() {
    //     readURL(this);
    // });

    $('#delete_social_image').on('click', ()=>{
        $('#delete_social_media_image').modal('show');
    });

    $('.reset_share_image').on('click', ()=>{
        $('#reset_social_media_image').modal('show');
    });

    $('#_reset_social_media_image').on('click', ()=>{
        $('#_delete_social_media_image').trigger('click');
        $('#reset_social_media_image').modal('hide');
    });

    $('.btn-image__del').click(function () {
        $('#update_og_image').slideUp();
        $('#upload_og_image').slideDown();
        $("#delete_og_image").slideUp();
        moduleShareFunnel.resetSocialImage();
        setTimeout(function () {
            $('#og_image_preview').attr('src', '');
        }, 200)
        $('#delete_social_media_image').modal('hide');
        // $('#required_social_image').val('');
        // $('#browse_img').val('');
        // if(defaultBackgroundImageURL){
        //     // $("#og_image_preview").slideUp();
        //     $("#og_image_preview").attr("src", defaultBackgroundImageURL);
        //     // $("#og_image_preview").slideDown();
        //     $('.img-frame__controls').find('.btn-image__del').slideUp();
        // }else{
        //     $('.browse__step1').slideDown();
        //     $('.browse__step2').slideUp();
        //     $(".img-frame__preview").attr('src','');
        //     $(".img-frame__preview").attr('alt','');
        //     // $(".lp-image__input").val('');
        //     $('.file__size,.file__extension').slideUp("slow");
        //     $('.img-frame__wrapper .button-cancel').css({
        //         'cursor':'not-allowed',
        //     });
        // }

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
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg', 'image/gif']) == -1) {
                // $('.file__extension').slideDown("slow");
                // $('.file__size').slideUp("slow");
                // $('.file__imgsize').slideUp("slow");
                displayAlert('danger', 'Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.');
                moduleShareFunnel.resetSocialImage();
            }
            else if (file.size / 1224 > 2048) {
                // $('.file__size').slideDown("slow");
                // $('.file__extension').slideUp("slow");
                // $('.file__imgsize').slideUp("slow");
                displayAlert('danger', 'The file is too large. Maximum allowed file size is 2MB.');
                moduleShareFunnel.resetSocialImage();
            }
            else {
                $('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function() {
                        console.log(this.width, this.height);
                        if(this.width < 1200 || this.height < 630){
                            displayAlert('danger', 'Please select at least 1200x630 pixels image.');
                            moduleShareFunnel.resetSocialImage();
                            $('.btn-image__del').trigger('click');
                            // $('.file__imgsize').slideDown("slow");
                        }else {

                            $('.file__imgsize').slideUp("slow");
                            $("#browse_og_image").show();
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

/*    jQuery('body').on( "click", ".link-swatcher", function(e) {
        e.preventDefault();
        //This feature will be done later
        return;
        jQuery(this).parents('.lp-panel__body').find('.funnel_url .input-holder').toggleClass('disable');
        jQuery(this).parents('.lp-panel__body').find('.funnel_url').toggleClass('hide-btns');
        jQuery(this).parents('.lp-panel__body').find('.url-expand').slideToggle();
    });*/


    jQuery('body').on( "blur", ".form-url-text", function(e) {
        // jQuery('.form-url-text').prop('readonly', true);
    });

    $("#fbshare").on("click", function(e){

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
    if(!requesting){
        requesting = true;
        // displayAlert('success', 'Funnel URL has been copied.');
        setTimeout(()=>{
            requesting = false;
        }, 2500);
    }
}

var moduleShareFunnel = {

    init: function () {
        this.initImageContainer();
        this.bindFormEvents();
        this.initFacebookShare();
        this.initTwitterShare();
        this.initLinkedinShare();
        this.initEmailShare();
    },

    bindFormEvents: function(){
        let $self = this;
        ajaxRequestHandler.init("#social_share_form");
        $('#main-submit').click((e)=>{
            if(ajaxRequestHandler.isAjaxInProcess) {
                return false;
            }

            let button_2_val1 = $('#browse_img').val();
            if(!hasImage && !button_2_val1){
                displayAlert('danger', 'Please select an image to upload.');
            }else if (!button_2_val1){
                displayAlert('info', 'You haven’t made any changes.' );
            }else{
                let url = ajaxRequestHandler.form.attr('action');
                ajaxRequestHandler.requestMethod = "POST";
                ajaxRequestHandler.toastMessage = "Image upload is in process...";
                ajaxRequestHandler.sendRequest(url, function (response, isError) {
                    console.log("Share funnel callback...", response);
                    if(response.status) {
                        let data = response.result;
                        if(data.id !== undefined && data.id) {
                            hasImage = true;
                            jQuery("#og_image_id").val(data.id);
                            $self.initImageContainer();
                            jQuery("#browse_og_image").slideUp();
                            jQuery("#delete_og_image").slideDown();
                            $self.resetSocialImage();
                        }
                    }
                });
            }
        });


        $('#_delete_social_media_image').on('click', ()=>{
            let form_data ={
                id:$('#og_image_id').val()
            };

            if(ajaxRequestHandler.isAjaxInProcess) {
                return false;
            }

            let url = site.baseUrl+site.lpPath+'/promote/image';
            ajaxRequestHandler.requestMethod = "DELETE";
            ajaxRequestHandler.sendRequest(url, function (response, isError) {
                console.log("delete share funnel callback...", response);
                $('#delete_social_media_image').modal('hide');
                if(response.status) {
                    $('#update_og_image').slideUp();
                    $('#upload_og_image').slideDown();
                    $("#delete_og_image").slideUp();
                    $('.reset_share_image_list').hide();
                    $('#og_image_preview').attr('src', '');
                    $self.resetSocialImage();
                    defaultBackgroundImageURL = '';
                    hasImage = false;
                }
            }, form_data);
        });
    },

    initImageContainer: function(){
        if(hasImage){
            $('#upload_og_image').hide();
            $('#update_og_image').show();
            $('.reset_share_image_list').show();
        }else{
            $('#upload_og_image').show();
            $('#update_og_image').hide();
            $('.reset_share_image_list').hide();
        }
        $('.img-frame__controls').find('.btn-image__del').hide();
    },

    resetSocialImage: function(){
        $('#browse_img').val('').trigger('change');
        // $('#required_social_image').val('');
    },

    initFacebookShare: function () {
        $("#fbshare").on("click", function (e) {
            e.preventDefault();
            moduleShareFunnel.popupCenter('https://www.facebook.com/sharer/sharer.php?u=' + shareURL + '&quote=' + facebookTemplate + '&t=' + facebookTemplate, '', containerWidth, containerHeight);
        });
    },

    initTwitterShare: function () {
        $("#twitter-share").on("click", function (e) {
            e.preventDefault();
            moduleShareFunnel.popupCenter('https://twitter.com/intent/tweet?text=' + twitterTemplate, '', containerWidth, containerHeight);
        });
    },

    initLinkedinShare: function () {
        $("#linkedin-share").on("click", function (e) {
            e.preventDefault();
            moduleShareFunnel.popupCenter('https://www.linkedin.com/sharing/share-offsite/?url=' + shareURL + '&summary=' + linkedinTemplate, 'linkedin-share-dialogue', containerWidth, containerHeight);
        });
    },

    initEmailShare: function () {
        $("#email-share").on("click", function (e) {
            e.preventDefault();
            var url = 'mailto:?subject=' + emailSubject + '&body=' + emailTemplate;
            var emailWindow = moduleShareFunnel.popupCenter(url, 'emailWindow', containerWidth, containerHeight);

            /**
             * Workaround (For extrnal program,
             * if external applocation is opened, than closing blank window after few seconds
             */
            setTimeout(function () {
                try {
                    console.log("Window", emailWindow.location, emailWindow.location.href)
                    if (emailWindow.location.href === 'about:blank') {
                        emailWindow.close();
                    }
                } catch  (error) {
                    console.log(error);
                }
            }, 5000);
        });
    },

    popupCenter: (url, title, w, h) => {
        // Fixes dual-screen position                             Most browsers      Firefox
        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

        const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var systemZoom = width / window.screen.availWidth;
        var left = (width - w) / 2 / systemZoom + dualScreenLeft
        var top = (height - h) / 2 / systemZoom + dualScreenTop
        var newWindow = window.open(url, title,
            `
          scrollbars=yes,
          resizable=yes,
          width=${w / systemZoom},
          height=${h / systemZoom},
          top=${top},
          left=${left}
          `
        );

        if (window.focus) newWindow.focus();

        return newWindow;
    }
};


function copyToClipboardInputValue(element, self) {
    var myStr = $(element).val();
    var trimStr = $.trim(myStr);
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(trimStr).select();
    document.execCommand("copy");
    $temp.remove();

    $(self).attr('disabled', true);

    setTimeout(() => {
        $(self).attr('disabled', false);
    }, 2000);

    // displayAlert('success', 'Funnel URL has been copied.');
}

