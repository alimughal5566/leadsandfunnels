var WIDTH = '';
var MAX_WIDTH = 540;
var PAD = 15;
var HEIGHT = '';
let HttpRequest = 0;
let elementTypes = {
    ELEMENT: 'element',
    CLONE_ELEMENT: 'cloneElement',
}
$(document).ready(function () {
    ajaxRequestHandler.init("#fuploadload", {
        alwaysBindEvent: true
    });
    setSlider1Values();

    var onlyScalePropertiesUpdate = false;
    // Save Button Handler
    $('#main-submit').on('click', function () {

        if ($('#currentLogoSource').val() != "") {
                download_image_and_create_swatches($('#currentLogoSource').val());
        }
        // Changing Logo
    });

    // Reset Logo Resizer
    $("#reset_logo_size").on('click', function () {
        var current_max = parseInt($('#scaling_maxHeightPx').val());
        var allowed_max = parseInt(logoConfigMaxAllowedHeightPx);
        if(current_max >= allowed_max){
            var initVal = parseInt(logoConfigDefaultHeight);
        } else {
            var initVal = Math.floor(parseInt(logoConfigInitHeight) / current_max * 100);
        }
        $('#logo-height-slider').bootstrapSlider('setValue', initVal, true);

        if ($('#currentLogoSource').val() != "") {
            changelogo();
        }
    });


    console.log(logoConfigMinHeight, logoConfigMaxHeight);
    // Current LOGO Slider Setup
    var elem_scale_bar = $('#scaling_defaultHeightPercentage');
    var newScalingProperties = ''; // new values going to be saved on db
    var currentdropimagelogo = $('#currentdropimagelogo');
    var currentdropimagelogoSrc = $('#currentdropimagelogo').attr('src');
    var currentLogoHeight = 0;

    var sliderMinValue = parseInt(logoConfigMinHeight);
    var sliderMaxValue = parseInt(logoConfigMaxHeight);

    var heightWidthSlider = null;

    function setupLogoHeightSlider() {
        var sliderValue =  $(elem_scale_bar).val();
        $('#logo-height-slider').bootstrapSlider({
            formatter: function (value) {
                $('#logo-height').val(value);
                return value + '%';
            },
            min: sliderMinValue,
            max: sliderMaxValue,
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
            $(elem_scale_bar).val(chnagevalue);
            var heightCal = Math.ceil((chnagevalue / 100) *  $('#scaling_maxHeightPx').val());
            $(".logo-image-wrap").css({
                'max-height': heightCal,
            });
            $("#current_logo_height").val(heightCal);

            setAllLogoMaxHeight();

            if (currentdropimagelogoSrc == currentdropimagelogo.attr('src')) {
                onlyScalePropertiesUpdate = true;
            } else {
                onlyScalePropertiesUpdate = false;
            }
        });
    }


    $(".lp-image__input").click(function () {
        $('.file__size,.file__extension').hide();
    }).change(function () {
        readURL(this);
    });

    function bindDragEvent() {
        $(".upload-drag__file").click(function () {
            $('.file__size,.file__extension').hide();
        }).change(function () {
            // cloneAndSetLogoValue(1);
            readCombURL(this);
        });
    }

    function bindLogoCombinator1Event() {
        // $("#comb1").unbind('change');
        $("#comb1").on('change', onImage1Change);
        bindDragEvent();

    }

    function bindLogoCombinator2Event() {
        // $("#comb2").unbind('change');
        $("#comb2").on('change', onImage2Change);
        bindDragEvent();
    }

    bindDragEvent();
    bindLogoCombinator1Event();
    bindLogoCombinator2Event();

    function onImage1Change() {
        cloneAndSetLogoValue(1);
        setSliders();
    }

    function onImage2Change() {
        cloneAndSetLogoValue(2);
        setSliders();
    }

    function cloneAndSetLogoValue(imageType) {
        let uid = "comb" + imageType;
        let cloneUid = "comb" + imageType + "_clone";

        let id = "#" + uid;
        let cloneId = "#" + cloneUid;

        let name = (imageType == 1) ? "pre-image" : "post-image";
        let cloneName = (imageType == 1) ? "pre-image-clone" : "post-image-clone";

        if ($($(id)).val()) {

            //Remove cloned field if there is any.
            $(cloneId).remove();

            //clone original file selector (which may have some file) and set its id
            $(id).clone().prop('id', cloneUid).appendTo($(id).parent());

            /* Swapping name */
            // Now we are modifying the name of the original file selctor to clone name
            $(id).attr('name', cloneName);

            // Now we are modifying the name of cloned file selector to original name
            $(cloneId).attr('name', name);

            /* Swapping ids */
            //Now we will change the id of orignal file selector with temp.
            $(id).attr('id', cloneUid + "temp");

            //Now we will change the id of cloned file selector.
            $(cloneId).attr('id', uid);

            //Now we will change the id of orignal file selector.
            $(cloneId + "temp").attr('id', cloneUid);


            $(cloneId).parent().attr('for', id);//Updating for val

        }

        (imageType == 1) ? bindLogoCombinator1Event() : bindLogoCombinator2Event();

    }

    function setSliders() {
        setTimeout(function () {
            var pre_width = Math.round($('.pre-image').width());
            var pre_height = Math.round($('.pre-image').height());
            var post_width = Math.round($('.post-image').width());
            var post_height = Math.round($('.post-image').height());
            if (pre_width > 270) {
                pre_width = MAX_WIDTH - post_width;
                $('.pre-image').width(pre_width);
            }
            if (post_width > 270) {
                post_width = MAX_WIDTH - pre_width;
                $('.post-image').width(post_width);
            }
            var $preimagestyle = pre_width + "~" + pre_height;
            var $postimagestyle = post_width + "~" + post_height;

            $("#pre-image-style").val($preimagestyle);
            $("#post-image-style").val($postimagestyle);
        }, 500)

    }

    function readCombURL(input) {
        var this_input = input;
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg', 'image/gif']) == -1 || file.name.match(/\.jfif$/i)) {
                let message = "Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.";
                displayAlert('danger', message);

                // $(this_input).parents(".comb__col").find('.file__extension').slideDown("slow");
                // $(this_input).parents(".comb__col").find('.file__size').slideUp("slow");
                $(input).val("");
            } else if ((file.size / 1024) > validationConfig.logo_image_size) {
                let message = 'The file is too large. Maximum allowed file size is ' + (validationConfig.logo_image_size / 1024) + 'MB.';
                displayAlert('danger', message);

                // $(this_input).parents(".comb__col").find('.file__size').slideDown("slow");
                // $(this_input).parents(".comb__col").find('.file__extension').slideUp("slow");
                $(input).val("");
            } else {
                $(this_input).parents(".comb__col").find('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function () {
                        $(this_input).parents(".comb__col").find('.file__imgsize').slideUp("slow");
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step1").hide();
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2 img").attr('src', e.target.result);
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2 img").attr('alt', file.name);
                        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2").show();

                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            if ($.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg', 'image/gif']) == -1 || file.name.match(/\.jfif$/i)) {
                let message = "Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.";
                displayAlert('danger', message);

                // $('.logo__col .file__extension').slideDown("slow");
                // $('.logo__col .file__size').slideUp("slow");
                // $(".logo__col .file-name").text("");
                // $(".logo__col .file-name").hide();
                $(input).val("");
            } else if ((file.size / 1024) > validationConfig.logo_image_size) {
                var message = 'The file is too large. Maximum allowed file size is ' + (validationConfig.logo_image_size / 1024) + 'MB.';
                displayAlert('danger', message);

                // $('.logo__col .file__size').slideDown("slow");
                // $('.logo__col .file__extension').slideUp("slow");
                // $(".logo__col .file-name").text("");
                // $(".logo__col .file-name").hide();
                $(input).val("");
            } else {
                $('.file__size,.file__extension').slideUp("slow");
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = new Image();
                    img.onload = function () {
                        $('.file__imgsize').slideUp("slow");
                        $(".file-name").text("");
                        $(".file-name").text(file.name);
                        $(".file-name").show();
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    }

    $('.logo-delete').click(function () {
        var this_input = this;
        $(this_input).parents(".upload-drag__wrapper").find(".upload-drag__step2,.logo-btns-action").hide();
        $(this_input).parents(".upload-drag__wrapper").find('.upload-drag__step1').slideDown("fast");
        $(this_input).parents(".upload-drag__wrapper").find('.upload-drag__file').val('');
    });

    setupLogoHeightSlider();
    // Create dummy image to get real size and set height width on load
    $(window).on('load', function () {
        var path = $("#currentdropimagelogo").attr('src');
        if (path != "") {
            set_logo_dimension(path);
        }
        setAllLogoMaxHeight();
    });


    $("#logo").on("change", function (e) {
        var filename = e.target.files[0] ? e.target.files[0].name : '';
        if (!filename) return;

        if (filename.length > 18) {
            filename = filename.substring(0, 18);
            filename += "...";
        }

        $(this).parents().find("#logonamesel").text("");
        $(this).parents().find("#logonamesel").text(filename);
        $(this).parents().find("#logonamesel").show();
        uploadlogo();
    });

    $slider1 = $('#ext1').bootstrapSlider({
        formatter: function (value) {
            _width = value;
            if ($('.pre-image').attr('src').indexOf("upload-image.png") < 0 && $('.pre-image').attr('src') != '' && $('.post-image').attr('src') != '') {
                $('.pre-image').css('width', _width + 'px');
            }
            var $_imagestyle = Math.round($('.pre-image').width()) + "~" + Math.round($('.pre-image').height());
            var pre_width = Math.round($('.pre-image').width());
            var post_width = MAX_WIDTH - pre_width;
            if (value > 270) {
                $('.post-image').width(post_width);
                var $_postimagestyle = Math.round($('.post-image').width()) + "~" + Math.round($('.post-image').height());

                // var $_postimagestyle = $('.post-image').css("width") + "~" + $('.post-image').css("height");
                $("#post-image-style").val($_postimagestyle);
                // $("#ex2").slider('setValue', post_width, true);
                // $("#ex2").slider('refresh');
            }
            $("#pre-image-style").val($_imagestyle);
            return value + 'px';
        },
        min: 40,
        step: 10,
        max: 400,
        value: Math.round($('.pre-image').width()),
        // value: 350,
        tooltip_position: 'bottom'
    });

    $slider2 = $('#ex2').bootstrapSlider({
        formatter: function (value) {
            _width = value;
            if ($('.post-image').attr('src').indexOf("upload-image.png") < 0 && $('.post-image').attr('src') != '' && $('.post-image').attr('src') != '') {
                $('.post-image').css('width', _width + 'px');
            }


            var $_imagestyle = Math.round($('.post-image').width()) + "~" + Math.round($('.post-image').height());
            var post_width = Math.round($('.post-image').width());
            var pre_width = MAX_WIDTH - post_width;
            if (value > 270) {
                $('.pre-image').width(pre_width);


                var $_preimagestyle = Math.round($('.pre-image').width()) + "~" + Math.round($('.pre-image').height());
                $("#pre-image-style").val($_preimagestyle);
            }
            $("#post-image-style").val($_imagestyle);
            return value + 'px';
        },
        min: 40,
        step: 10,
        max: 400,
        value: Math.round($('.post-image').width()),
        tooltip_position: 'bottom'
    });

    function setSlider1Values(event = {value: {newValue: 270, oldValue: 270}}) {
        var a = event.value.newValue;
        var b = event.value.oldValue;

        var pre_width = Math.round($('.pre-image').width());
        var post_width = MAX_WIDTH - pre_width;
        if (a > 270) {
            //$slider2.slider('setValue', post_width, true);
            var ex2 = $('#ex2').bootstrapSlider();
            $('#ex2').bootstrapSlider('setValue', post_width);
            //$slider2.slider('refresh');
        }

        var src1_img_h = Math.round($('.pre-image').height());
        var src2_img_h = Math.round($('.post-image').height());
        HIGHT = src1_img_h - (PAD * 2);
        if (src2_img_h > src1_img_h) {
            HIGHT = src2_img_h - (PAD * 2);
        }
        $(".image-divider").css("height", HIGHT);

    }

    setTimeout(function () {
        $slider1.on('change', function (event) {
            setSlider1Values(event);
        });
    }, 200);

    function setSlider2Values(event = {value: {newValue: 270, oldValue: 270}}) {

        var a = event.value.newValue;
        var b = event.value.oldValue;

        var post_width = Math.round($('.post-image').width());
        var pre_width = MAX_WIDTH - post_width;
        if (a > 270) {
            var ext1 = $('#ext1').bootstrapSlider();
            $('#ext1').bootstrapSlider('setValue', pre_width);
        }

        var src1_img_h = Math.round($('.pre-image').height());
        var src2_img_h = Math.round($('.post-image').height());
        HIGHT = src1_img_h - (PAD * 2);
        if (src2_img_h > src1_img_h) {
            HIGHT = src2_img_h - (PAD * 2);
        }
        $(".image-divider").css("height", HIGHT);
    }

    setTimeout(function () {
        $slider2.on('change', function (event) {
            setSlider2Values(event);
        });
    }, 200);

    $("body").on("click", "#uploadlogo", function () {
        uploadlogo();
    });

    $("#comb-logo-wrapper input").change(function () {
        readURL(this);
    });

    $("#lp-default-logo .logo-default-img img").dblclick(function () {
        var path = $(this).attr('src');
        var id = $(this).attr('id');
        $('#droppable-photos-container-logo .logo-default-img img').remove('');
        $('#droppable-photos-container-logo .logo-default-img').append('<img src="' + path + '" id="currentdropimagelogo" class="abc" >');
        set_logo_dimension(path);
        $('#logo_source').val('default');
        $('#logo_id').val(id);
        changelogo();
    });

    $("div[id^='lp-cur-logo-'] img").dblclick(function () {
        var path = $(this).attr('src');
        var id = $(this).attr('id');
        $('#droppable-photos-container-logo .logo-default-img img').remove('');
        $('#droppable-photos-container-logo .logo-default-img').append('<img src="' + path + '" id="currentdropimagelogo" class="abc" >');
        set_logo_dimension(path);
        $('#logo_source').val('client');
        $('#logo_id').val(id);
        changelogo();
    });

    $(".img-content-logo").draggable({
        helper: "clone",
        appendTo: 'body'
    });

    $("#droppable-photos-container-logo .logo-default-img").droppable({
        accept: ".img-content-logo",
        drop: function (ev, ui) {
            //debugger;
            var path = ui.draggable.find('img').attr('src');
            var id = ui.draggable.find('img').attr('id');
            var rel = ui.draggable.find('img').attr('rel');
            var swatch = ui.draggable.find('img').attr('data-swatches');
            var height = parseInt(ui.draggable.find('img').attr('data-height'));
            var maxHeight = parseInt(ui.draggable.find('img').attr('data-maxHeight'));
            $("#swatches").val(swatch);

            if (swatch != "") {
                // Create dummy image to get real size and set height width
                set_logo_dimension(path);
            }
            $('#logo_source').val('client');
            if (rel == 'stock') {
                $('#logo_source').val('default');
            }
            $('#logo_id').val(id);
            $('#currentLogoSource').val(path);
            $('#droppable-photos-container-logo .logo-default-img img').remove('');
            $('#droppable-photos-container-logo .logo-default-img').append('<img src="' + path + '" id="currentdropimagelogo" class="logo-image-wrap" style="max-height:'+height+'px">');
            $("#scaling_maxHeightPx").val(maxHeight);
            $("#current_logo_height").val(height);
            var formValues = ajaxRequestHandler.originalFormValues;
            let state = '';
            if (formValues.currentLogoSource.value == $('#currentLogoSource').val()) {
                state = true;
            } else {
                state = false;
            }

            ajaxRequestHandler.changeSubmitButtonStatus(state);

        }
    });

    $(".upload-drag__wrapper").hover(function (e){
        let _this = $(this);
        if(_this.find('.upload-drag__step2').is(':visible')){
            _this.find('.logo-btns-action').show();
        }
    },function (e){
        $(this).find('.logo-btns-action').hide();
    });

});

function set_logo_dimension(path) {

    $("#temporary_image").attr("src", path).on('load', function () {
        var realWidth = this.width;
        var realHeight = this.height;
        var W = 400;
        var H = 120;
        var src_w = this.width;
        var src_h = this.height;
        var _w = '';
        var _h = '';
        if (src_w > W) {
            _w = W;
            _h = (_w * src_h) / src_w;
            if (_h > H) {
                _h = H;
                _w = (_h * src_w) / src_h;
            }
        } else if (src_h > H) {
            _h = H;
            _w = (_h * src_w) / src_h;
            if (_w > W) {
                _w = W;
                _h = (_w * src_h) / src_w;
            }
        } else {
            _w = src_w;
            _h = src_h;
        }
        $('#currentdropimagelogo').css({
            'width': _w,
            'height': _h
        });

    });

}

function deletelogo(logoid, that) {
    let url = site.baseUrl + site.lpPath + '/popadmin/deletelogo',
        client_id = $('#client_id').val(),
        data = "logo_id=" + logoid + "&client_id=" + client_id + "&key=" + $('#key').val() + "&current_hash=" + $("#current_hash").val();

    ajaxRequestHandler.setActiveLoadingToastMessage(true);
    ajaxRequestHandler.toastMessage = 'Deleting the logo is in process...';
    ajaxRequestHandler.sendRequest(url, function (response, isError) {
        console.log("Delete logo callback...", response);
        if (response.status) {
            let data = response.result;
            if (data.logosrc !== undefined) {
                $('#currentdropimagelogo').attr("src", data.logosrc);
                $("#currentLogoSource").val(data.logosrc);
                $("#logo_source").val(data.use);
            }

            if (ajaxRequestHandler.autoEnableDisableButton) {
                ajaxRequestHandler.loadFormSavedValues();
            }
            jQuery("[data-id=" + logoid + "]").remove();
            $('#logocnt').val($(".upload-logo").length);
        }
    }, data);
}

// Upload Combine Logos
function combinelogos() {
    var $form = $('#fuploadload');
    var cnt = $('#logocnt').val();
    if ($('.pre-image').attr('src').indexOf("upload-image.png") > 0 || $('.post-image').attr('src').indexOf("upload-image.png") > 0 || $('.pre-image').attr('src') == '' || $('.post-image').attr('src') == '') {
        var message = "Please select a logo.";
        displayAlert('warning', message);
    } else if (cnt == 3 && !GLOBAL_MODE) {
        $("#logonamesel").text("");
        var message = 'Maximum of three logos uploaded at one time. Delete one logo then upload its replacement.';
        displayAlert('danger', message);
    } else {
        $("#uploadlogotype").val('combine');
        ajaxRequestHandler.setActiveLoadingToastMessage(true);
        ajaxRequestHandler.toastMessage = 'Combining logos is in process...';
        ajaxRequestHandler.submitForm(function (response, isError) {
            if (!isError) {
                $(".upload-drag__wrapper").find(".upload-drag__step1").show();
                $(".upload-drag__wrapper").find(".upload-drag__step2,.logo-btns-action").hide();
                $(".upload-drag__wrapper").find('.upload-drag__file').val('');

                let data = response.result;
                if (data.id !== undefined) {
                    renderLogo(data);
                }
            }
        });
    }
}


function swaplogos() {
    var cnt = $('#logocnt').val();

    if ($('.pre-image').attr('src').indexOf("upload-image.png") > 0 || $('.post-image').attr('src').indexOf("upload-image.png") > 0 || $('.pre-image').attr('src') == '' || $('.post-image').attr('src') == '') {
        var message = "Please select second logo.";
        displayAlert('warning', message);
        return;
    } else {
        var pre_src = $('.pre-image').attr('src');
        var post_src = $('.post-image').attr('src');
        $('.pre-image').attr('src', post_src);
        $('.post-image').attr('src', pre_src);
    }

}

// Upload Logo
function uploadlogo() {
    if (!HttpRequest) {
        HttpRequest = 1;
        $('.del-logo').prop('disabled', true);
    } else {
        return false;
    }
    var cnt = $('#logocnt').val();
    if ($('#logo').val() == "") {

        var message = "Please select a logo.";
        displayAlert('warning', message);
        return false;
    } else if (cnt == 3) {
        $("#logonamesel").text("");
        var message = 'Maximum of three logos uploaded at one time. Delete one logo then upload its replacement.';
        var alert = displayAlert('danger', message);
        setTimeout(() => {
            HttpRequest = 0;
            $('.del-logo').prop('disabled', false);
        }, 2000);
        return false;
    } else {
        $("#uploadlogotype").val('');
        ajaxRequestHandler.setActiveLoadingToastMessage(true);
        ajaxRequestHandler.toastMessage = 'Logo upload is in process...';
        ajaxRequestHandler.submitForm(function (response, isError) {
            HttpRequest = 0;
            if (!isError) {
                $('#logo').val('');
                $(".file-name").text("");

                let data = response.result;
                if (data.id !== undefined) {
                    renderLogo(data);
                }
            }
        });
    }
}

function changelogo() {
    let cur_hash = $("#current_hash").val(),
        url = site.baseUrl + site.lpPath + '/popadmin/changelplogo/' + cur_hash,
        globalUrl = site.baseUrl + site.lpPath + '/global/changeLpLogoGlobalAdminThree',
        options = {};
        options["url"] = ajaxRequestHandler.getCustomActionUrl(url, globalUrl);

    ajaxRequestHandler.setActiveLoadingToastMessage(false);
    ajaxRequestHandler.submitForm(function (response, isError) {
        console.log("submit callback...", response, isError);
    }, true, options);

}

var ua = window.navigator.userAgent;
var msie = ua.indexOf("MSIE ");

if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    $("label img").on("click", function () {
        $("#" + $(this).parents("label").attr("for")).click();
    });
}


function readImage(url, is_upload_form) {
    var img = new Image();
    img.addEventListener("load", function () {

        var colorThief = new ColorThief();
        var tred, tgreen, tblue = "";
        var palette = [];
        palette = colorThief.getPalette(this, 6, 10);

        var str = "";
        var first = 1;
        for (i = 0; i < palette.length; i++) {
            tred = palette[i][0];
            tgreen = palette[i][1];
            tblue = palette[i][2];
            str += tred + "-" + tgreen + "-" + tblue;
            if (i < (palette.length - 1)) {
                str += "#";
            }
        }

        $("#swatches").val(str);

        if (is_upload_form) {
            uploadlogo();
        } else {
            changelogo();
        }

    });
    img.src = url;
}

function download_image_and_create_swatches(path) {
    $.ajax({
        type: "POST",
        url: "/lp/ajax/download_rs_image",
        data: "image_link=" + path + '&_token=' + ajax_token + '&global=1',
        dataType: "json",
        error: function (e, s) {
            console.error(e);
            console.error(s);
        },
        success: function (d) {
            readImage(site.baseUrl + "/" + d.file, false);
            $('#currentdropimagelogo')[0].src = site.baseUrl + "/" + d.file;
        }
    });
}

function renderLogo(data) {
    let logoSrc = data.image_src;
    let id = data.id;
    let swatches = data.swatches === undefined ? null : data.swatches;
    $('#logocnt').val(($(".upload-logo").length + 1));
    let logoHtml = `<div class="col-4 p-0" data-id="${id}" data-logo>
        <div class="upload-logo">
            <div class="upload-logo__img">
                <div class="img-content-logo">
                    <img class="logo-img" rel="client"
                         src="${logoSrc}"
                         id="${id}"
                         data-swatches="${swatches}"
                         data-height="${logoConfigInitHeight}"
                         data-maxHeight="${logoConfigMaxAllowedHeightPx}"
                         alt="Default logo">
                </div>
            </div>
            <div class="upload-logo__button">
                <button class="button button-cancel del-logo"
                        onClick='deletelogo("${id}", this)'>
                    delete
                </button>
            </div>
        </div>
    </div>`;

    $('.justify-content-center')
        .append(logoHtml).load(function () {
            imageHeightCalculation(id);
        });

    $('.del-logo').prop('disabled', false);
    $(".img-content-logo").draggable({
        helper: "clone",
        appendTo: 'body'
    });
}

function setAllLogoMaxHeight(){
    var logoList = $("[data-logo]");
    if(logoList.length){
        for(var i = 0; i <= logoList.length; i++){
            imageHeightCalculation($(logoList[i]).attr('data-id'));
        }
    }
}

function imageHeightCalculation(id){
        var allowedHeight = parseInt(logoConfigMaxAllowedHeightPx);
    if(id) {
        let selector = $('#' + id);
        currentLogoHeight = Math.round(selector.prop('naturalHeight'));
        let sliderValue = jQuery('#logo-height-slider').bootstrapSlider('getValue');
        if (currentLogoHeight < allowedHeight) {
            allowedHeight = currentLogoHeight;
        }
        var newHeight = Math.ceil((sliderValue / 100) * allowedHeight);
        selector.attr({'data-height': newHeight,'data-maxHeight': allowedHeight});
      }
}
