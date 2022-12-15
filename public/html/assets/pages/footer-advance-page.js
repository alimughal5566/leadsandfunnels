window.selectItems = {
    'terms-select':[
        {
            id: 0,
            text: '<div class="options-style">Your Funnel</div>',
            title: 'Your Funnel'
        },
        {
            id: 1,
            text: '<div class="options-style">Another Website</div>',
            title: 'Another Website'
        },
    ],
};

var lp_advance_footer = {
    advance_footer_select_list : [
        {selecter:".terms-select", parent:".terms-select-parent"},
    ],
    /*
    ** custom select loop
    **/
    allCustomSelect: function () {
        var selectlist = lp_advance_footer.advance_footer_select_list;
        for(var i = 0; i < selectlist.length; i++){
            lp_advance_footer.initCustomSelect(selectlist[i].selecter,selectlist[i].parent);
        }
    },



    /*
    ** init custom select
    **/
    initCustomSelect: function (selecter,parent) {
        var amIclosing = false;
        var _selector = jQuery(selecter);
        var _parent = jQuery(parent);
        var selectorClass = selecter.replace(/[#.]/g,'');
        _selector.select2({
            data: selectItems[selectorClass],
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(parent),
            width: '100%',
            templateResult: function (d) {
                return $(d.text);
            },
            templateSelection: function (d) {
                return $(d.text);
            }

            /*
            ** Triggered before the drop-down is opened.
            */
        }).on('select2:opening', function() {
            _parent.find('.select2-selection__rendered').css('opacity', '0');

            /*
            ** Triggered whenever the drop-down is opened.
            ** select2:opening is fired before this and can be prevented.
            */
        }).on('select2:open', function() {
            var _selectoptions = _parent.find('.select2-results__options');
            var _selectdropdown = _parent.find('.select2-dropdown');

            _selectoptions.css('pointer-events', 'none');

            setTimeout(function() {
                _selectoptions.css('pointer-events', 'auto');
            }, 300);

            _selectdropdown.hide();
            _selectdropdown.css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            _parent.find('.select2-selection__rendered').hide();

            /*
            ** Triggered before the drop-down is closed.
            */
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;

                _parent.find('.select2-dropdown').attr('style', '');
                setTimeout(function () {
                    _selector.select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }

            /*
            ** Triggered whenever the drop-down is closed.
            ** select2:closing is fired before this and can be prevented.
            */
        }).on('select2:close', function() {
            _parent.find('.select2-selection__rendered').show();
            _parent.find('.select2-selection__rendered').css('opacity', '1');
            _parent.find('.select2-results__options').css('pointer-events', 'none');
        });

        if (selectorClass == 'terms-select') {
            _selector.on('change', function () {
                if(jQuery(this).val() == 0) {
                    jQuery(this).parents('.modal-terms').find('#webaddress').hide();
                    jQuery(this).parents('.modal-terms').find('#webmodal').show();
                }
                if(jQuery(this).val() == 1) {
                    jQuery(this).parents('.modal-terms').find('#webaddress').show();
                    jQuery(this).parents('.modal-terms').find('#webmodal').hide();
                }
            });
        }
    },


    /**
     ** footer background colorPicker function
     **/
    footerBackgroundColorPicker : function () {

        $("#footer-background-clr").ColorPicker({
            color: "#ffffff",
            flat: true,
            opacity:true,
            width: 203,
            height: 144,
            outer_height: 162,
            outer_width: 281,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(100);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(100);
                return false;
            },
            onChange: function (hsb, hex, rgb, rgba) {
                var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
                $(".footer-background-clr .color-box__r .color-box__rgb").val(rgb.r);
                $(".footer-background-clr .color-box__g .color-box__rgb").val(rgb.g);
                $(".footer-background-clr .color-box__b .color-box__rgb").val(rgb.b);
                $('.footer-background-clr .color-opacity').val(rgba.a);
                $(".footer-background-clr .color-box__hex-block").val('#'+hex);
                $('#clr_bg_footer').css('backgroundColor', rgba_fn);
                // $('#clr_bg_footer').find('.last-selected__code').text('#'+hex);
                $('.fp-area').css('backgroundColor', rgba_fn);
            }
        });

    },
    /**
     ** footer text colorPicker function
     **/
    footerTextColorPicker : function () {

        $('#footer-text-clr').ColorPicker({
            color: "#b4bbbc",
            flat: true,
            opacity:true,
            width: 203,
            height: 144,
            outer_height: 162,
            outer_width: 281,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(100);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(100);
                return false;
            },
            onChange: function (hsb, hex, rgb, rgba) {
                var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
                $(".footer-text-clr .color-box__r .color-box__rgb").val(rgb.r);
                $(".footer-text-clr .color-box__g .color-box__rgb").val(rgb.g);
                $(".footer-text-clr .color-box__b .color-box__rgb").val(rgb.b);
                $('.footer-text-clr .color-opacity').val(rgba.a);
                $(".footer-text-clr .color-box__hex-block").val('#'+hex);
                $('#clr_txt_footer').css('backgroundColor', rgba_fn);
                // $('#clr_txt_footer').find('.last-selected__code').text('#'+hex);
                $('.fp-copyright, .fp-nav__link').css('color', rgba_fn);
            }
        });

    },
    /**
     ** footer background colorPicker click function
     **/
    footerBackgroundClick: function () {

        $('#clr_bg_footer').click(function () {
            var name = ".footer-background-clr";
            var color_box_name = $(name);
            var get_color = $(this).find('.last-selected__code').text();
            lpUtilities.custom_color_picker.call(this,name);
            lpUtilities.set_colorpicker_box(color_box_name,get_color);
        });

    },
    /**
     ** footer text colorPicker click function
     **/
    footerTextClick: function () {

        $('#clr_txt_footer').click(function () {
            var name = ".footer-text-clr";
            var color_box_name = $(name);
            var get_color = $(this).find('.last-selected__code').text();
            lpUtilities.custom_color_picker.call(this,name);
            lpUtilities.set_colorpicker_box(color_box_name,get_color);
        });

    },
    /**
     ** logo preview function
     **/
    footerLogoPreview: function () {
        var imagePathLeft = '';
        var imagePathRight = '';
        var imageIndex = '';
        $('.logo__list.left').find('.dz-image').each(function (index,value) {
            var imageIndex = $(this).parents('li').data('index');
            imagePathLeft += '<li data-index="'+ imageIndex +'">'+ jQuery(this).html()+'</li>';
        });
        $('.logo-list-left').html(imagePathLeft);

        $('.logo__list.right').find('.dz-image').each(function (index,value) {
            var imageIndex = $(this).parents('li').data('index');
            imagePathRight += '<li data-index="'+ imageIndex +'">'+ jQuery(this).html()+'</li>';
        });
        $('.logo-list-right').html(imagePathRight);
    },
    /**
     ** logo sorting function
     **/
    footerLogoSorting: function () {
        $(".logo__list.left").sortable({
            items: ".logo__item",
            handle: ".drag-link",
            scroll: false,
            axis: "x",
            tolerance: "pointer",
            stop: function(event,ui) {
                lp_advance_footer.footerLogoPreview();
            }
        });

        $(".logo__list.right").sortable({
            items: ".logo__item",
            handle: ".drag-link",
            scroll: false,
            axis: "x",
            tolerance: "pointer",
            stop: function(event,ui) {
                lp_advance_footer.footerLogoPreview();
            }
        });
    },
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
                        lp_advance_footer.rangeSliderChange($('.logo-slider'));
                        $(this.element).next().show();
                        setTimeout(function (){
                            lp_advance_footer.footerLogoPreview();
                        },200);
                    });

                    self.on("removedfile", function(file) {
                        $(this.element).next().hide();
                        setTimeout(function (){
                            lp_advance_footer.footerLogoPreview();
                        },200);
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

                    self.on("addedfile", function(file) {
                        const pattern = /\d{6}(\.)(jpg|jpeg|png)/;

                        if (!pattern.test(file.name)) {
                            //   this.removeFile(file);
                        }
                    });

                    self.on("uploadprogress", function(file, progress, bytesSent) {
                        if (file.previewElement) {
                            var progressElement = file.previewElement.querySelector("[data-dz-uploadprogress]");
                            progressElement.style.width = progress + "%";
                            progressElement.querySelector(".dz-progress-counter").textContent = parseInt(progress) + "%";
                        }
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
							  <div class="dz-progress">
                                    <span class="file-name" data-dz-name></span>
                                    <div class="dz-upload-wrap">
                                        <span class="dz-upload" data-dz-uploadprogress>
                                            <span class="dz-progress-counter"></span>
                                        </span>
                                    </div>
                                </div>
							  <div class="dz-remove">
							    <a href="javascript:undefined;" class="drag-link"><i class="icon ico-dragging"></i></a>
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
        setup("bg-image1");
        setup("bg-image2");
        setup("bg-image3");
        setup("bg-image4");
        setup("bg-image5");
        setup("bg-image6");
    },
    rangeSliderChange: function (input) {
        var $this_val = input.val();
        var $this = input.parents('.logo__item').find('.dz-image img');
        var imageIndex = input.parents('.logo__item').data('index');
        var indexValue = $('.fp-area').find("li[data-index='"+imageIndex+"']").find('img');
        if($this_val > 40) {
            if($this.clientHeight > $this.clientWidth ) {
                $($this).css({
                    'width': input.val() ,
                    'height': 'auto'
                });
                $(indexValue).css({
                    'width': input.val() ,
                    'height': 'auto'
                });
            }else {
                $($this).css({
                    'width': 'auto' ,
                    'height': input.val() * 0.55
                });
                $(indexValue).css({
                    'width': 'auto' ,
                    'height': input.val() * 0.55
                });
            }
        }
    },
    /*
    ** range slider
    **/
    rangeSliderInit: function() {
        $('.logo-slider').bootstrapSlider({
            formatter: function(value) {
                return value + '%' ;
            },
            tooltip_position:'bottom',
            value: 75,
            tooltip: 'always'
        });

        $(".logo-slider").change(function(){
            lp_advance_footer.rangeSliderChange($(this));
        });
    },

    /*
    ** range slider
    **/

    footerPageSorting: function () {
        $('.page-panel__sortable').sortable({
            placeholder: "footer-item__highlight",
            items: ".lp-panel",
            handle: ".ico-drag-dots",
            tolerance: "pointer",
            start:function(event,ui){
                var $item = ui.item;
                $item.addClass('active');
                jQuery('.footer-item__highlight').text('Drag & Drop Your Options Here');
            },
            stop:function(event,ui){
                var $item = ui.item;
                $item.removeClass('active');
                jQuery('.footer-item__highlight').text('Drag & Drop Your Options Here');
            }
        });
    },

    /*
     ** footer sortable
     **/
    footerPageSortingFull: function () {
        $('.page-panel__sortable').sortable({
            // placeholder: "page-item__highlight",
            items: ".lp-panel",
            handle: ".drag-feature",
            tolerance: "pointer",
            start:function(event,ui){
                var $item = ui.item;
                $item.addClass('active');
                // $('.page-item__highlight').text('Drag & Drop Your Transition Here');
            },
            stop:function(event,ui){
                var $item = ui.item;
                $item.removeClass('active');
                // $('.page-item__highlight').text('Drag & Drop Your Transition Here');
            }
        });
    },

    /**
     ** mousedown function for sortable function
     **/
    footerPageSortableMouseDown: function () {
        $(document).on('mousedown', '.lp-panel', function (event) {
            $(".page-panel__sortable").sortable("option", "delay", 250);
            setTimeout(function () {
                $('.drag-feature').css('cursor', 'move');
                console.log("drag activated");
            }, 250);
        });
        $(document).on('mouseup', '.lp-panel', function (event) {
            $('.drag-feature').css('cursor', 'default');
        });
        $(document).on('mouseleave', '.lp-panel', function (event) {
            $('.drag-feature').css('cursor', 'default');
        });
    },

    /*
    ** init function
    **/
    init: function () {
        lp_advance_footer.footerBackgroundColorPicker();
        lp_advance_footer.footerTextColorPicker();
        lp_advance_footer.footerBackgroundClick();
        lp_advance_footer.footerTextClick();
        lp_advance_footer.dropZoneInit();
        lp_advance_footer.rangeSliderInit();
        lp_advance_footer.footerLogoSorting();
        lp_advance_footer.footerPageSorting();
        lp_advance_footer.footerPageSortingFull();
        lp_advance_footer.footerPageSortableMouseDown();
        lp_advance_footer.allCustomSelect();
    }
};

$(document).ready(function () {
    lp_advance_footer.init()
});

$(document).on('keyup',"#footer-background-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    // console.log(rgb);
    if(rgb) {
        var value = $('.footer-background-clr .color-opacity').val();
        var $this_elm = $(this).parents('.footer-background-clr');
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".footer-background-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".footer-background-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".footer-background-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('.clr_bg_footer').find('.last-selected__box').css('backgroundColor', rgba_fn);
        // $('.clr_bg_footer .last-selected__code').text($(this).val());
        $("#footer-background-clr").ColorPickerSetColor($(this).val());
    }
});

$(document).on('keyup',"#footer-text-clr-trigger",function (){
    var rgb = lpUtilities.hexToRgb($(this).val());
    // console.log(rgb);
    if(rgb) {
        var value = $('.footer-text-clr .color-opacity').val();
        var $this_elm = $(this).parents('.footer-text-clr');
        var rgba_fn = 'rgb(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ','+value+')';
        $(".footer-text-clr .color-box__r .color-box__rgb").val(rgb.r);
        $(".footer-text-clr .color-box__g .color-box__rgb").val(rgb.g);
        $(".footer-text-clr .color-box__b .color-box__rgb").val(rgb.b);
        $('.clr_txt_footer').css('backgroundColor', rgba_fn);
        // $('.clr_txt_footer .last-selected__code').text($(this).val());
        $("#footer-text-clr").ColorPickerSetColor($(this).val());
    }
});

Dropzone.autoDiscover = false;