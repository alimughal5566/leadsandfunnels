var brandingFile = brandingURL = '';
let postAttribute = true;
var lp_branding = {

    /**
    ** dropFile function
    **/
    dropZoneInit: function() {
        function setup(id) {
            let options = {
                thumbnailHeight: 70,
                thumbnailWidth: 70,
                maxFiles: 1,
                maxFilesize: 2048,
                url : site.baseUrl+site.lpPath+"/branding/upload-image/"+funnel_hash,
                dictResponseError: "Server not Configured",
                dictFileTooBig: "File too big. Must be less than 2MB.",
                dictCancelUpload: "",
                acceptedFiles: 'image/*',
                paramName: "branding", // The name that will be used to transfer the file
                headers: {
                    'X-CSRF-TOKEN':ajax_token
                },
                accept: function(file, done) {
                    file.acceptDimensions = done;
                    file.rejectDimensions = function() {
                       //$(".warning-msg").html().show("Please make sure the image width and height are not larger than "+options.thumbnailWidth+"px X "+options.thumbnailHeight+"px.");
                        displayAlert('danger', options.dictFileTooBig);
                    };
                },
                init: function() {
                    var alertMsg = '';
                    var mockFile = {
                        name: "mockfile.webp",
                        size: 12345,
                        type: 'image/webp',
                        url: ''
                    }
                    mockFile.url = $("#image_path").val();
                    if(mockFile.url){
                        this.emit("addedfile", mockFile);
                        this.emit("success", mockFile);
                        this.emit("thumbnail", mockFile, mockFile.url, true)
                    }
                    this.on('thumbnail', function (file) {
                        if (file.accepted !== false) {
                            let filesize = Math.ceil(file.size/1000);
                            if (filesize > options.maxFilesize) {
                                file.rejectDimensions();
                            } else {
                                alertMsg = displayAlert('loading', 'Image upload is in process', 0);
                                file.acceptDimensions();
                            }
                        }
                        lp_branding.fileReader(file);
                    });

                    this.on('success', function (file, resp) {
                        alertMsg.hide();
                        $('.logo-other-option').slideDown();
                        brandingFile = resp.rs_cdn;
                        brandingURL = resp.client_cdn;
                        jQuery('[name="branding_image"]').val(brandingFile).change();
                        jQuery("#main-bg-image .dz-image img").attr("src", brandingURL);
                        jQuery("#image_width").val(parseInt(resp.width));
                        jQuery("#image_height").val(parseInt(resp.height));
                        brandingInfoSaveLocalStorage();

                    });
                    this.on("removedfile", function (file) {
                        jQuery('.logo-other-option').slideUp();
                        $(".warning-msg").html("").hide();
                        brandingFile = brandingURL = '';
                        brandingInfoSaveLocalStorage();
                        jQuery('[name="branding_image"]').val(brandingFile).change();
                        jQuery("#image_width, #image_height").val('');
                    });
                },
                previewTemplate: `
						<div class="dz-preview dz-file-preview">
							<div class="dz-wrap">
							  <div class="dz-image"><img data-dz-thumbnail /></div>
							  <div class="dz-remove">
							    <a href="javascript:undefined;" data-dz-remove=""><i class="icon ico-cross"></i></a>
							  </div>
							</div>
						</div>`
            };
            try {
                var myDropzone = new Dropzone(`#${id}`, options);
            } catch (e) {
                console.log('dropzone issue: ', e);
            }
        }
        setup("main-bg-image");
    },
    /**
    ** range slider
    **/
    rangeSliderInit: function() {
        $('.bg-slider').bootstrapSlider({
            formatter: function(value) {
                return value + '%' ;
            },
            tooltip_position:'bottom',
            min: 20,
            max: 100,
            value: $('.bg-slider').val(),
            tooltip: 'always',

        }).on("slideStop", function(e) {
            brandingInfoSaveLocalStorage();
        });

    },
    /*
    ** select2js init
    **/
    select2js_init: function () {
        var amIclosing = false;
        $('#select2js__position').select2({
            minimumResultsForSearch: -1,
            width: '173px', // need to override the changed default
            dropdownParent: $('.select2js__position-parent')
        }).on('select2:openning', function() {
            jQuery('.select2js__position-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.select2js__position-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.select2js__position-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2js__position-parent .select2-dropdown').hide();
            jQuery('.select2js__position-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.select2js__position-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2js__position-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#select2js__position').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.select2js__position-parent .select2-selection__rendered').show();
            jQuery('.select2js__position-parent .select2-results__options').css('pointer-events', 'none');
        }).on('select2:select',function (){
            brandingInfoSaveLocalStorage();
        });

        //    new tab

        $('#select2js__link').select2({
            minimumResultsForSearch: -1,
            width: '173px', // need to override the changed default
            dropdownParent: $('.select2js__link-parent')
        }).on('select2:openning', function() {
            jQuery('.select2js__link-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.select2js__link-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.select2js__link-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2js__link-parent .select2-dropdown').hide();
            jQuery('.select2js__link-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.select2js__link-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2js__link-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#select2js__link').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.select2js__link-parent .select2-selection__rendered').show();
            jQuery('.select2js__link-parent .select2-results__options').css('pointer-events', 'none');
        }).on('select2:select',function (){
            brandingInfoSaveLocalStorage();
        });
    },
    /**
    ** scroll area
    * */
    initCustomScroll: function () {
        jQuery(".custom-scroll-holder").mCustomScrollbar({
            axis: "y",
            autoExpandScrollbar: true,
            autoHideScrollbar : true,
            mouseWheel: {
                scrollAmount: 100
            }
        });
    },

    /**
     ** branding option toggle
     * */
    brandingToggle: function () {
        $('[name="leadpop_branding_active"]').click(function(){
            if($(this).val() == '0') {
                $('.lp-panel_tabs').slideUp();
            }
            else {
                if ($('[data-selected-plan="pro"]').length) {
                    $('.lp-panel_tabs').slideDown();
                }
            }
        });
    },

    /**
     ** Embad option toggle
     * */
    embadToggle: function () {
        $('.backlink-opener').change(function () {
            if(this.checked){
                $('.backlink-slide').slideDown();
                $('.backlink-area').find('.form-control').focus();
            }else {
                $('.backlink-slide').slideUp();
                $('.backlink-area').find('.form-control').blur();
            }
        });
    },

    fileReader: function (file){
    var fr = new FileReader();
    fr.readAsDataURL(file);
    fr.addEventListener('load', function () {
        jQuery("#main-bg-image .dz-image img").attr("src", fr.result);
        });
    },

    /**
    ** init
    **/
    init: function () {
        lp_branding.dropZoneInit();
        lp_branding.rangeSliderInit();
        lp_branding.select2js_init();
        lp_branding.initCustomScroll();
        lp_branding.brandingToggle();
        lp_branding.embadToggle();
    }

};

$(document).ready(function () {
   lp_branding.init();
   $(document).on('keyup paste','[name="backlink_url"], [name="image_title"], [name="image_alt"]', lpUtilities.debounce(function (event) {
       brandingInfoSaveLocalStorage();
    }, 50));

   $(document).on('change','[name="backlink_enable"], [name="leadpop_branding"]',function (){
       brandingInfoSaveLocalStorage();
   });

    ajaxRequestHandler.init('#branding-form', {
        alwaysBindEvent: true
    });

    $(document).on('click','#main-submit',function(e){
        ajaxRequestHandler.toastMessage = 'Saving changes...';
        ajaxRequestHandler.submitForm(function (response, isError) {
            console.log("submit callback...", response, isError);
        },true);
    });

    $(document).on('click','#monthly-tab', function (){
        if(planList) {
            let plan = planList['plan']['pro']['month'];
            $(".upgrade-plan-area__unlock-pro .upgrade-plan-area__price-info .price").html('$' + plan['plan_price']);
            $(".upgrade-plan-area__price-info .price-text").html('per ' + plan['period_unit']);
            if(planList['addOn']) {
                $(".upgrade-plan-area__unlock-pre .upgrade-plan-area__price-info .price," +
                    " #feature-modal-price .upgrade-plan-area__price-info .price").html('$' + planList['addOn']['month']['plan_price']);
                $(".upgrade-plan-area__price-info.addon-info .price-text").html('per ' + planList['addOn']['month']['period_unit']);
            }
            $(".branding-upgrade-plan").attr('data-plan-period', 'month');
        }
    });

    $(document).on('click','#annually-tab', function (){
        if(planList) {
            var term = "month";
            if(planList['plan']['pro'].hasOwnProperty("year")) term = "year"
            let plan = planList['plan']['pro'][term];
            $(".upgrade-plan-area__unlock-pro .upgrade-plan-area__price-info .price").html('$' + plan['plan_price']);
            $(".upgrade-plan-area__price-info .price-text").html('per ' + plan['period_unit']);

            if(planList['addOn']) {
                $(".upgrade-plan-area__unlock-pre .upgrade-plan-area__price-info .price, " +
                    "#feature-modal-price .upgrade-plan-area__price-info .price").html('$' + planList['addOn']['year']['plan_price']);
                $(".upgrade-plan-area__price-info.addon-info .price-text").html('per ' + planList['addOn']['year']['period_unit']);
            }
            $(".branding-upgrade-plan").attr('data-plan-period', 'year');
        }
    });
    var upgradeAjaxRunning = false;
    $(document).on('click', '.branding-upgrade-plan', function (e){
        e.preventDefault();
        if(upgradeAjaxRunning){
            return
        }
        upgradeAjaxRunning = true;
        var loader = displayAlert('loading', 'Upgrading your subscription plan', 0)

        var showMessage = function (type, message) {
            loader.hide()
            setTimeout(function () {
                displayAlert(type, message)
            }, 300)
        }

        $.ajax({
            url: site.lpPath + '/branding/update-plan',
            data: {
                period: $(this).attr('data-plan-period'),
                addon: $(this).attr('data-addon'),
                current_hash: $('input[name="current_hash"]').val(),
                _token: ajax_token
            },
            dataType: 'json',
            method: 'post',
            success: function (response) {
                if(response && response.success){
                    showMessage('success', response.message);
                    location.reload();
                } else {
                    // As client should not be concerned with server side errors
                    // so showing a general message instead of server returned message
                    showMessage('danger', 'Sorry, something went wrong during plan upgrade, please contact us, we can help you!');
                    console.warn('Plan Upgrade Error: ' + response.message)
                }
            },
            error: function () {
                console.warn('Plan Upgrade Error: network/server error while upgrading')
                showMessage('danger', 'Sorry, something went wrong during plan upgrade, please contact us, we can help you!');
            },
            complete: function (){
                upgradeAjaxRunning = false
            }
        })
    });

    $(document).on("click",".close-modal",function (e){
        $('#brandingOff').click();
        $('.modal').modal('hide');
    });

    jQuery('.nav__tab .nav-link').click(function(e){
        e.preventDefault();
        jQuery('.nav-link').removeClass('active');
        jQuery(this).addClass('active');

        if(jQuery(this).hasClass('mobile-view-link')){
            postAttribute = 'mobile-preview';
        }
        else {
            postAttribute = 'desktop-preview';
        }
        brandingInfoSaveLocalStorage();
    });

});

Dropzone.autoDiscover = false;

/**
 *
 */
function brandingInfoSaveLocalStorage(){
 let formData = $('[data-form="branding-form"]').serializeArray();
 if(typeof preview_module != "undefined") {
     let funnelInfo = preview_module.funnelInfo;
     let rec = {};
     for (let e of formData) {
         rec[`${e.name}`] = e.value;
     }
     rec["file"] = brandingURL;
     funnelInfo.meta = {"branding": rec};
     previewIframe.reloadIframe(false, JSON.stringify(funnelInfo), postAttribute);
 }
}
$(window).on('load',function (){
    brandingURL = $("#image_path").val();
    brandingInfoSaveLocalStorage();
});
