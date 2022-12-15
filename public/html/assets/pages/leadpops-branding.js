var lp_branding = {

    /**
    ** dropFile function
    **/
    dropZoneInit: function() {
        function setup(id) {
            let options = {
                thumbnailHeight: 210,
                thumbnailWidth: 140,
                maxFiles: 1,
                url : "/upload-target",
                dictResponseError: "Server not Configured",
                dictFileTooBig: "File too big ({{filesize}}MB). Must be less than {{maxFilesize}}MB.",
                dictCancelUpload: "",
                // previewsContainer: ".logo-list-left",
                init: function() {
                    var self = this;
                    //New file added
                    self.on("addedfile", function(file) {
                        $('.logo-other-option').slideDown();
                        // lp_advance_footer.rangeSliderChange($('.logo-slider'));
                        // $(this.element).next().show();
                        // setTimeout(function (){
                        //     lp_advance_footer.footerLogoPreview();
                        // },200);
                    });

                    self.on("removedfile", function(file) {
                        $('.logo-other-option').slideUp();
                        // $(this.element).next().hide();

                        // console.info($(this.element.id))

                    });
                    // Send file starts
                    self.on("sending", function(file) {
                        // console.log("upload started", file);
                    });

                    self.on("complete", function(file, response) {
                        if (file.name !== "442343.jpg") {
                            //this.removeFile(file);
                        }
                    });

                    self.on("maxfilesreached", function(file, response) {
                        //alert("too big");
                    });

                    self.on("maxfilesexceeded", function(file, response) {
                        this.removeFile(file);
                    });
                },
                previewTemplate: `
						<div class="dz-preview dz-file-preview">
							<div class="dz-wrap">
							  <div class="dz-image"><img data-dz-thumbnail /></div>
							  <!--<div class="dz-error-message"><i class="fa fa-warning">&nbsp;</i><span data-dz-errormessage></span></div>
							  <div class="dz-filename"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" focusable="false" viewBox="0 0 12 12" aria-hidden="true" class="upload-item-icon"><path fill="none" stroke="currentColor" stroke-linecap="round" d="M2.5 4v4.5c0 1.7 1.3 3 3 3s3-1.3 3-3v-6c0-1.1-.9-2-2-2s-2 .9-2 2v6c0 .6.4 1 1 1s1-.4 1-1V4"></path></svg><span data-dz-name></span></div>
							  <div class="dz-progress">
							    <span class="dz-upload" data-dz-uploadprogress></span>
							  </div>-->
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
            value: 100,
            tooltip: 'always'
        });

        $(".bg-slider").change(function(){
            // lp_advance_footer.rangeSliderChange($(this));
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
        $('[name="lp-branding"]').click(function(){
            if($(this).val() == 'brandingOn') {
                $('.lp-panel_tabs').slideUp();
            }else {
                $('.lp-panel_tabs').slideDown();
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
            }else {
                $('.backlink-slide').slideUp();
            }
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
});

Dropzone.autoDiscover = false;