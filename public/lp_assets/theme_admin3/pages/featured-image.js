var sliderMinValue = 0;
var sliderMaxValue = 0;
var scalingPropertiesValue = 0;
var scalingPropertiesSelector = "";
var currentdropimagelogoSrc = "";
var featuredImageHandler ="";

$(document).ready(function () {
    featuredImageHandler = Object.assign({}, ajaxRequestHandler);
    featuredImageHandler.init("#fuploadload", {
        alwaysBindEvent: true
    });

    jQuery('#feature-image-modal').on('show.bs.modal', function (e) {
        jQuery('#submit-featured-image').prop('disabled', true);
    });

    bindEvent();
    jQuery(document).on("change", "#activedeactivebtn", function(e) {
        if ($(this).is(":checked")) {
            $("#imagestatus").val("active").trigger("change");
        } else {
            $("#imagestatus").val("inactive").trigger("change");
        }
    });

    featureImageModule.deleteImage();

    // Reset Featured Image Resizer
    $("#reset_featuredimage_size").on('click', function () {
        var current_max = parseInt($('#scaling_maxWidthPx').val());
        var allowed_max = parseInt(ImageConfigMaxAllowedWidthPx);
        if(current_max >= allowed_max){
            var initVal = parseInt(ImageConfigSliderDefault);
        } else {
            var initVal = Math.ceil(parseInt(logoConfigInitWidth) / current_max * 100);
        }
        $('#feature-image-resize-slider').bootstrapSlider('setValue', initVal, true);

        // Save information to database
        featureImageModule.changeImageScalingProperties();

    });

    featureImageModule.init();

    // Current LOGO Slider Setup
    elem_scale_bar = $('#scaling_defaultWidthPercentage');
    scalingPropertiesValue = $(elem_scale_bar).val();
    var newScalingProperties = ''; // new values going to be saved on db
    var currentdropimagelogo = $('#currentdropimagelogo');
     currentdropimagelogoSrc = $('#currentdropimagelogo').attr('src');
    var currentLogoHeight = 0;

    var heightWidthSlider = null;

});

function onSelect(event){
    fileChanged(event); //restore cloned file when cancel chrome issue
    if($('#logo').val()){
        $('.img-frame__controls').find('.btn-image__del').slideDown();
        $(".btn-image__del").show();
    }
}

var featureImageModule = {
    isFunnelBuilder: false,
    uploadingDropzone: false,

    deleteImage: function() {
        $('.btn-image__del').off().click(function () {
            $('.featured-img-del').hide();
            $('.btn-image__del').hide();
            $('.browse__step1').slideDown();
            $('.browse__step2').slideUp();
            $(".img-frame__preview").attr('src', '');
            $(".img-frame__preview").attr('alt', '');
            $(".lp-image__input").val('');
            $('#delete_image').val(1).trigger("change");
            $("#logo").val("").trigger("change");

            $('.browse__step1').css({'display':'flex'});
            $('.browse__step2').slideUp();
        });
    },
    init: function() {
        let $self = this,
            featuredImage = '',
            submitButton="#main-submit";

        if ($('#funnel_builder').length) {
            $self.isFunnelBuilder = true;
            submitButton = "#submit-featured-image";
            featuredImageHandler.submitButton = submitButton;
        }

        $(submitButton).click(function(e) {
            /**
             * image will be saved when uploaded
             * when executed from funnel builder
             * only will be executed when no file selected
             */
            if(myDropzone !== undefined && myDropzone.getQueuedFiles().length) {
                myDropzone.processQueue();
                return false;
            }

            if ($self.isFunnelBuilder && $('.dz-image').length == 0) {
                $("#imagestatus").val("inactive");
            }
            else if ($('#delete_image').val() == 1 && !$('#logo').val()) {
                $("#imagestatus").val("inactive");
            }
            else {
                if ($('#logo').val() && $('#logo').val() != 1) {
                    $("#imagestatus").val("active");
                } else if ($('#activedeactivebtn').length) {
                    if ($('#currentdropimagelogo').attr('src') == "") {
                        $("#imagestatus").val("inactive");
                        $('#activedeactivebtn').bootstrapToggle('off');
                    } else {
                        $("#imagestatus").val($('#activedeactivebtn').is(':checked') ? "active" : "inactive");
                    }
                }
            }

            if ($self.isFunnelBuilder && $('.dz-image').length == 0) {
                featuredImage = '';
            } else if ($self.isFunnelBuilder && $('.dz-image').length) {
                featuredImage = '1';
            } else {
                featuredImage = $('#currentdropimagelogo').attr('src');
            }

            var activedeactivebtn = $('#activedeactivebtn').is(':checked');

            if (featuredImage == "" && activedeactivebtn === true) {
                //displayAlert('warning', 'Please select the featured image.');
                //return false;
            }

            featuredImageHandler.toastMessage = 'Image upload is in process...';
            $('[name=_background_name]').remove(); // No need this field while submitting. Used only to clone and store previous selected image
            if (!$('#logo').val() || $self.isFunnelBuilder) {
                featuredImageHandler.toastMessage = 'Saving changes...';
            }

            if ($self.isFunnelBuilder) {
                featuredImageHandler.setActiveLoadingToastMessage(true);
            } else {
                featuredImageHandler.setActiveLoadingToastMessage(false);
            }
            featuredImageHandler.submitForm(function (response, isError) {
                if (response.status) {
                    let data = response.result;
                    if (data.image_src !== undefined) {
                        $('#currentdropimagelogo').attr('src', data.image_src);
                        $(".btn-image__del").show();
                        $('.browse__step1').slideUp();
                        $('.browse__step2').css({'display': 'flex'});
                        $('#selected_featured_image').val(data.image_src);
                        $('#activedeactivebtn').bootstrapToggle('on');
                    }
                    if (response.message.search('deactivated') !== -1) {
                        $('#activedeactivebtn').bootstrapToggle('off');
                    }

                    if ($self.isFunnelBuilder) {
                        if ($('.dz-image').length == 0) {
                            $('#selected_featured_image').val('');
                        }
                        let image_deactivated = response.message.search('deactivated') !== -1 ? true : false;
                        featureImageModule.updateFeaturedImageDOMState(image_deactivated);
                        // enable cta message and featured image rendering in right preview for first question only
                        FunnelsBuilder.enableCTAFeaturedImagePreviewTrigger();
                        $('#feature-image-modal').modal('hide');
                    }
                    $('#delete_image').val("n").trigger("change");
                }
            }, true);

        });


        $("#reset_default_image").click(function (e) {
            $self.activateDefaultImage();
            // $('#submit-featured-image').prop('disabled', true);
            $('#feature-image-modal').modal('hide');
        });

        $(".reset-close-modal").click(function (e) {
            $('#resetfeaturedimg').modal('hide');
            $('[data-edit-featured-image]').trigger('click');
            // $('#feature-image-modal').modal('show');
        });
    },
    /**
     * To reset to default featured image
     */
    activateDefaultImage: function () {
        let $self = this,
            url = site.baseUrl + site.lpPath + '/popadmin/activetodefaultimage',
            globalUrl = site.baseUrl + site.lpPath + '/global/reset-featured-image';

        let options = {
            url: featuredImageHandler.getCustomActionUrl(url, globalUrl),
            singleFunnelCb: $self.showConfirmationModal
        };

        featuredImageHandler.toastMessage = 'Saving changes...';
        featuredImageHandler.setActiveLoadingToastMessage(true);
        // disable global mode for funnel builder page
        if ($self.isFunnelBuilder) {
            GLOBAL_MODE = false;
        }
        featuredImageHandler.submitForm(function (response, isError) {
            if(response.status) {
                // for leadpop_version_id = 126 on reset we will simply turn off featured image
                if ($('#leadpop_version_id_featured_image_off').length && $('#leadpop_version_id_featured_image_off').val() == 1) {
                    $('#activedeactivebtn').bootstrapToggle('off');
                    $('#resetfeaturedimg').modal("hide");
                    $('.browse__step1').slideDown();
                    $('.browse__step2').slideUp();
                    $('.browse__step1').css({'display': 'flex'});
                    $('#currentdropimagelogo').hide();
                    // $('#selected_featured_image').val('');
                    $(".btn-image__del").hide();
                }
                else {
                    let data = response.result;
                    $('#delete_image').val("n").trigger("change");
                    $('#activedeactivebtn').bootstrapToggle('on');
                    if($('#scaling_defaultWidthPercentage').length && ('#scaling_maxWidthPx').length) {
                        $('#scaling_defaultWidthPercentage').val(parseInt(ImageConfigSliderDefault));
                        $('#scaling_maxWidthPx').val(parseInt(ImageConfigMaxAllowedWidthPx));
                    }

                    if (featuredImageHandler.originalFormValues['thankyou'] !== undefined) {
                        featuredImageHandler.originalFormValues['thankyou'].value = true;
                    }

                    $('#resetfeaturedimg').modal("hide");
                    $('.browse__step1').slideUp();
                    $('.browse__step2').css({'display': 'flex'});
                    $('#currentdropimagelogo').attr('src', data.imgsrc);
                    $('#selected_featured_image').val(data.imgsrc);
                    $('#activedeactivebtn').bootstrapToggle('on');
                    $(".btn-image__del").show();
                }

                if ($self.isFunnelBuilder) {
                    featureImageModule.updateFeaturedImageDOMState();
                    // enable cta message and featured image rendering in right preview for first question only
                    FunnelsBuilder.enableCTAFeaturedImagePreviewTrigger();
                    setupFeaturedImageDropZone("feature-image", true);
                }
            }
            $('#submit-featured-image').prop('disabled', false);
        }, true, options);
    },

    /**
     * update hidden variables in DOM for populating featured image popup
     *
     * @param image_deactivated
     */
    updateFeaturedImageDOMState: function(image_deactivated=null) {
        if (image_deactivated === true) {
            featureImageModule.deactivateFeaturedImageDOMState();
        } else {
            if ($('[data-toggle-feature-image]').is(':checked')) {
                $('[data-enable-featured-class]').removeClass('inactive');
                $('[data-edit-featured-image]').parent('.feature_image-item').addClass('active');
                $('#selected_featured_image_toggle').val(1);
            } else {
                featureImageModule.deactivateFeaturedImageDOMState();
            }
        }
    },

    /**
     * deactivate featured image state in DOM
     */
    deactivateFeaturedImageDOMState: function() {
        $('#activedeactivebtn').bootstrapToggle('off');
        $('[data-enable-featured-class]').addClass('inactive');
        $('[data-edit-featured-image]').parent('.feature_image-item').removeClass('active');
        $('#selected_featured_image_toggle').val(0);
    },

    /**
     * To show confirmation modal on singal funnel
     * @param cb
     */
    showConfirmationModal: function (cb) {
        $('#resetfeaturedimg').modal({
            show: true,
            backdrop: 'static',
            keyboard: true
        }).one('click', '#resetFeature', function (e) {
            cb();
        });
    },


    setupImageHeightSlider: function (min, max, sliderValue, logoChanged) {
        // Resize slider for Featured Image
     //   debugger;
        $('#feature-image-resize-slider').bootstrapSlider({
            formatter: function(value) {
                $('#feature-image-height').val(value);
                $(".img-frame__preview").css({
                    'width': Math.ceil((value / 100) *  $('#scaling_maxWidthPx').val()) +'px',
                });
                return   value +'%';
            },
            min: min,
            max: max,
            value: sliderValue,
            tooltip: 'always',
            tooltip_position: 'bottom'
        }).on("slide change", function (slideEvt) {
            var chnagevalue = 0;
            if (slideEvt.type === "slide") {
                chnagevalue = slideEvt.value;
            } else if (slideEvt.type === "change") {
                chnagevalue = slideEvt.value.newValue
            }
            // newScalingProperties['logoValue'] = chnagevalue;
            // var scalingJson = JSON.stringify(newScalingProperties);
            $(elem_scale_bar).val(chnagevalue);

            if (currentdropimagelogoSrc == $(currentdropimagelogo).attr('src')) {
                onlyScalePropertiesUpdate = true;
            } else {
                onlyScalePropertiesUpdate = false;
            }
        });


        setTimeout(() => {
                 $('#feature-image-resize-slider').bootstrapSlider('setValue', sliderValue, true);
              $('#feature-image-resize-slider').bootstrapSlider('refresh');
        }, 400)
    },


    changeImageScalingProperties: function () {
        let cur_hash = $("#current_hash").val(),
            url = site.baseUrl + site.lpPath + '/popadmin/update-featured-image-size/' + cur_hash,
            options = {};
        options["url"] = featuredImageHandler.getCustomActionUrl(url, url);

        featuredImageHandler.setActiveLoadingToastMessage(false);
        featuredImageHandler.submitForm(function (response, isError) {
        }, true, options);

    },
    initHeightWidthSlider: function (logoChanged = false) {
        // debugger;
        sliderMinValue = parseInt(ImageConfigSliderMin);
        sliderMaxValue = parseInt(ImageConfigSliderMax);

        currentdropimagelogo = $('#currentdropimagelogo');
        currentImageWidth = Math.round($(currentdropimagelogo).prop('naturalWidth'));

        // if current Image Height is less-than maxHeight than slider max val will be image height.
        var allowedWidth = parseInt(ImageConfigMaxAllowedWidthPx);
        if(currentImageWidth < allowedWidth){
            $("#scaling_maxWidthPx").val(currentImageWidth);
        } else {
            $("#scaling_maxWidthPx").val(allowedWidth);
        }

        featureImageModule.setupImageHeightSlider(sliderMinValue, sliderMaxValue, (elem_scale_bar).val(), logoChanged)

    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
function testing() {
    var fields = {};
    $("#fuploadload").find(":input").each(function () {
        if (this.id == 'required_logo' || this.id == 'logo')
            fields[this.id] = $(this).val();
    });
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
function cloneAndSetValue() {
    if ($("#logo").val()) { // if there is any image value in the main file selector then we will make a clone other wise no need
        $("#required_logo").remove();//Remove cloned field if there is any.
        $("#logo").clone().prop('id', 'temp_id').appendTo($("#logo").parent());   //clone original file selector (which may have some file) i.e. logo and give its id as temp_id
        $("#logo").attr('name', "logo"); // as it may have some file so we are setting its name to "background_name" which is required in back end
        $("#logo").attr('id', "required_logo"); // and we are setting its ids as required_logo
        $('#temp_id').attr('name', "_logo"); //now we are making newly cloned file selector the current file selector by giving its name _background_name
        $('#temp_id').attr('id', "logo"); //and giving its id logo
        // $("#required_background_name").parent().attr('for', "required_background_name");//Updating for val
        bindEvent(); // Finally we are binding events again as binding is broken due to clone
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
function bindEvent() {
    $("#logo").change(function () {
        // cloneAndSetValue();
        readURL(this);
    });
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//*
// **  favicon Image Preview
// *
function readURL(input) {
    var this_input = input;
    if (input.files && input.files[0]) {
        var filesize = input.files[0].size / 1024;
        var file = this_input.files[0];
        if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg', 'image/gif']) == -1 || file.name.match(/\.jfif$/i)) {
            let message = "Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.";
            displayAlert("danger", message);
            $(input).val("");
            $("#logo").val("");
        }
        else if (filesize > validationConfig.featured_image_size) {
            let message = "The file is too large. Maximum allowed file size is " + (validationConfig.featured_image_size / 1024) + "MB.";
            displayAlert("danger", message);
            $(input).val("");
            $("#logo").val("");
        }
        else {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#submit-featured-image').prop('disabled', false);
                $('#currentdropimagelogo').attr('src', e.target.result);
                $(".btn-image__del").show();

                $('.browse__step1').slideUp();
                $('.browse__step2').css({'display':'flex'});
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
}


/*
 * @deprecated deprecated in admin3.0
 * Individual Ajax replaced with common save button
 */

function changetodefaultimage() {
    var url = site.baseUrl + site.lpPath + '/popadmin/changetodefaultimage';
    if (GLOBAL_MODE) {
        url = site.baseUrl + site.lpPath + '/global/deactivateFeatureImageGlobalAdminThree';
    }
    var form_data = $('#fuploadload').serialize();
    var cur_hash = $("#current_hash").val();
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: url,
        data: form_data,
        success: function (d) {
            var message = 'Featured media has been deactivated.';
            displayAlert('success', message);
        },
        cache: false,
        async: false
    });
}

/**
 ** dropfile function
 **/
function setupFeaturedImageDropZone(id, reset=false) {
    let options = {
        thumbnailHeight: 350,
        thumbnailWidth: 350,
        maxFiles: 1,
        //autoProcessQueue: false,
        paramName: "logo",
        url : "/lp/popadmin/uploadimage",
        dictResponseError: "Server not Configured",
        dictFileTooBig: "File too big ({{filesize}}MB). Must be less than {{maxFilesize}}MB.",
        dictCancelUpload: "",
        autoProcessQueue: false,
        headers: {
            'X-CSRF-TOKEN': $('[name="_token"]').val()
        },
        init: function() {
            var self = this;
            let hideAlert = null;

            this.on("thumbnail", function(file, dataUrl) {
                $('.dz-image').last().find('img').attr({width: '100%', height: '100%'});
            }),

            // Send file starts
            this.on("sending", function(file, xhr, formData) {
                formData.append("funneldata", $('[name="funneldata"]').val());
                formData.append("client_id", $('[name="client_id"]').val());
                formData.append("imagestatus", 'active');
                //console.log("upload started", file);
                let {hide} = displayAlert("loading", "Image upload is in process...", 0);
                hideAlert = hide;
            });

            this.on("complete", function(file) {
                hideAlert();
                $('#submit-featured-image').prop('disabled', false);
            });

            this.on("success", function(file) {
                var response = JSON.parse(file.xhr.responseText);
                let data = response.result;
                if (response.status) {
                    if (data.image_src !== undefined) {
                        $('#activedeactivebtn').bootstrapToggle('on');
                    }
                    $('#delete_image').val("n").trigger("change");
                    $('#selected_featured_image').val(data.image_src);
                    featureImageModule.updateFeaturedImageDOMState();
                    // enable cta message and featured image rendering in right preview for first question only
                    FunnelsBuilder.enableCTAFeaturedImagePreviewTrigger();
                    displayAlert("success", response.message);
                    $('.dz-image').css({"width":"100%", "height":"auto"});
                    featureImageModule.deleteImage();
                    $('#submit-featured-image').prop('disabled', false);
                    $('#feature-image-modal').modal('hide');
                }
            });

            this.on("error", function(file, message) {
                displayAlert("danger", message.error);
                $('#submit-featured-image').prop('disabled', false);
            });

            this.on("maxfilesreached", function(file, response) {
                //alert("too big");
            });

            this.on("maxfilesexceeded", function(file, response) {
                this.removeFile(file);
            });

            this.on("removedfile", function(file) {
                $('#submit-featured-image').prop('disabled', false);
            });

            this.on("addedfile", function(file) {
                var filesize = file.size / 1024;
                if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg', 'image/gif']) == -1 || file.name.match(/\.jfif$/i)) {
                    let message = "Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.";
                    displayAlert("danger", message);
                    this.removeFile(file);
                }
                else if (filesize > validationConfig.featured_image_size) {
                    let message = "The file is too large. Maximum allowed file size is " + (validationConfig.featured_image_size / 1024) + "MB.";
                    displayAlert("danger", message);
                    this.removeFile(file);
                } else {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    $('#submit-featured-image').prop('disabled', false);
                }
            });
        },
        previewTemplate: `
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-wrap">
                          <div class="dz-image"><img data-dz-thumbnail /></div>
                          <div class="dz-remove">
                            <a href="javascript:undefined;" data-dz-remove="" class="remove-dropzone-image btn-image__del"><i class="icon ico-cross"></i></a>
                          </div>
                        </div>
                    </div>`
    };

    function loadExistingImage(myDropzone, reset=false) {
        let myFile = $('#selected_featured_image').val().trim();
        if (myFile != '') {
            if (myDropzone.files.length == 0 || reset) {
                if (reset) {
                    // delete already set image in case of reset
                    $('.dropzone')[0].dropzone.files.forEach(function(file) {
                        myDropzone.removeFile(file);
                        file.previewElement.remove();
                    });
                    $('#delete_image').val("n").trigger("change");
                }
                var mockFile = {
                    name: 'FileName',
                    size: '1000',
                    type: 'image/jpeg',
                    accepted: true            // required if using 'MaxFiles' option
                };
                myDropzone.files.push(mockFile);    // add to files array
                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile, myFile);
                myDropzone.emit("complete", mockFile);
            }
        }
    };

    try {
        if (myDropzone === null) {
            myDropzone = new Dropzone(`#${id}`, options);
            loadExistingImage(myDropzone, reset);
        } else {
            loadExistingImage(myDropzone, reset);
        }
        featureImageModule.deleteImage();
    } catch (e) {}
}


if ($('#funnel_builder').length) {
    Dropzone.autoDiscover = false;
    var myDropzone = null;
    setupFeaturedImageDropZone("feature-image");
}
