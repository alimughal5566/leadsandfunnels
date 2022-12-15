var reg = /[^0-9]/gi;
var regExpnumber = /[0-9\.\,]/;
var linebreak = /(\r\n|\n|\r)/gm;
var regSpace = /\s/g;
let requesting = false;
var amIclosing = false;
// Code Types
const CODETYPE = {
    BING_PIXEL: 5,
    FACEBOOK_PIXEL: 2,
    GOOGLE_ANALYTICS: 1,
    GOOGLE_TAG_MANAGER: 3,
    GOOGLE_CONVERSION_PIXEL: 4,
    GOOGLE_RETARGETING_PIXEL: 6,
    INFORMA_PIXEL: 7,
    FACEBOOK_DOMAIN_VERIFICATION: 10,
    FACEBOOK_CONVERSION_API: 11
}
const PIXEL_PLACEMENT = {
    PAGE_FUNNEL: 2,
    PAGE_THANKYOU: 4
}
const TRACKING_OPTION = {
    PAGE_VIEW: 1,
    PAGE_VIEW_PLUS_QUESTIONS: 3
}
// const BING_PIXEL = 5;
// const FACEBOOK_PIXEL = 2;
// const GOOGLE_ANALYTICS = 1;
// const GOOGLE_TAG_MANAGER = 3;
// const GOOGLE_CONVERSION_PIXEL = 4;
// const GOOGLE_RETARGETING_PIXEL = 6;
// const INFORMA_PIXEL = 7;


// const PAGE_FUNNEL = 2;
// const PAGE_THANKYOU = 4;
const PIXEL_ACTION_LEAD = 2;
//
// const PAGE_VIEW = 1;
// const PAGE_VIEW_PLUS_QUESTIONS = 3;

function initializeTractingOptions() {

    $('.select2js__trackoption').select2({
        dropdownPosition: 'above',
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2js__trackoption-parent'),
        templateResult: function (data, container) {
            if (data.element) {
                $(container).addClass($(data.element).attr("class"));
            }
            return data.text;
        }
    }).on("change", function (e) {
        if ($('#tracking_options').val() == TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS) {
            var $modalPixel = $('#model_pixel_code');
            $modalPixel.find('#ka-dd-toggle').removeClass('ka-dd__button_open');
            $modalPixel.find('.ka-dd__menu').slideUp();
            $(".question_options").slideDown();
            setTimeout(function () {
                pixelModelScrollbar();
                lpUtilities.globalTooltip();
            }, 900);

            // disable update button in case of Global
            if( $('.select2js__codetype').val() == CODETYPE.FACEBOOK_PIXEL) {
                if (GLOBAL_MODE) {
                    /*$('#add_code_submit').prop('disabled', true);*/
                    $('#add_code_submit').addClass('disabled');
                }
            }

        } else if ($('#tracking_options').val() == TRACKING_OPTION.PAGE_VIEW) {
            /*$('#add_code_submit').prop('disabled', false);*/
            $('#add_code_submit').removeClass('disabled');
            $(".question_options").slideUp();
        }
    }).on('select2:openning', function () {
        jQuery('.select2js__trackoption-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function () {
        jQuery('.select2js__trackoption-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function () {
            jQuery('.select2js__trackoption-parent .select2-results__options').css('pointer-events', 'auto');
            lpUtilities.globalTooltip();
        }, 300);
        jQuery('.select2js__trackoption-parent .select2-dropdown').hide();
        jQuery('.select2js__trackoption-parent .select2-dropdown').css({
            'display': 'block',
            'opacity': '1',
            'transform': 'scale(1, 1)'
        });
        jQuery('.select2js__trackoption-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function (e) {
        if (!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__trackoption-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2js__trackoption').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function () {
        jQuery('.select2js__trackoption-parent .select2-selection__rendered').show();
        jQuery('.select2js__trackoption-parent .select2-results__options').css('pointer-events', 'none');
    });
}

(function ($) {
    $(document).ready(function () {
       var modal_height = $("#model_pixel_code").height()-200;
        $("#model_pixel_code .modal-body").css({'max-height':modal_height+'px'});
        $('.pixel-quick-scroll').mCustomScrollbar({
            mouseWheel: {scrollAmount: 80}
        });
        var mk_mcscroll = $('.ka-dd__scroll').mCustomScrollbar({
            mouseWheel: {scrollAmount: 80}
        });
        CodeName_List();
        lpUtilities.addFunnelTags();

        var $form = $('#dd-code-popup')

        ajaxRequestHandler.init('#dd-code-popup', {
            autoEnableDisableButton: false,
            submitButton: "#add_code_submit",
            customFieldChangeCb: pixels.onChangeTrackingOptionsHandleButton
        });

        pixels.init();

        $("#add_code_submit").on('click', function (e) {
            e.preventDefault();
            var placement = $('.select2js__codetype').val();
            if(placement == CODETYPE.INFORMA_PIXEL && $("#pixel_placement").val() == PIXEL_PLACEMENT.PAGE_FUNNEL){
                displayAlert("danger", "Informa pixel isn't available on Funnel. it's only available on Thank You Page.");
                return false;
            }

            console.log("add_code_submit pressed...");
            if (GLOBAL_MODE) {
                var tracking_options =  $('#tracking_options').val();
                if(placement == CODETYPE.FACEBOOK_PIXEL &&
                    (tracking_options == TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS || tracking_options == null)){
                    displayAlert("danger", "Page View + Questions are not available in Global Setting mode. Turn off Global Setting at the top to add");
                    return false;
                }
                //
                // if (checkIfFunnelsSelected()) {
                //     if (confirmationModalObj.globalConfirmationCurrentForm === $form) {
                //         $($form).submit();
                //     } else {
                //         showGlobalRequestConfirmationForm($form);
                //     }
                // }
            }
            // else {
                $($form).submit();
            // }
        });

        var pixelModalShown = false;
        var $pixelModal = $("#model_pixel_code");

        $pixelModal
            .on('shown.bs.modal', function () {
                pixelModalShown = true
            })
            .on('hidden.bs.modal', function () {
                pixelModalShown = false
            })

        var wasPixelModalShowing = false;

        $('#global-setting-funnel-list-pop')
            .on('show.bs.modal', function () {
                if (pixelModalShown) {
                    wasPixelModalShowing = true;
                    $pixelModal.modal('hide')
                } else {
                    wasPixelModalShowing = false;
                }
            })
            .on('hide.bs.modal', function () {
                if (wasPixelModalShowing) {
                    $pixelModal.modal('show')
                }
                confirmationModalObj.removeCustomSubmitCallback();
            });

        $('.ka-dd__link > div,.label-tooltip').tooltipster({
            contentAsHTML: true
        });
        /*$('.ka-dd__link > div,.label-tooltip').tooltip({
            template: '<div class="tooltip question"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            // container: 'body'
            // container: '.tooltip-container'
        });*/
        $('#ka-dd-toggle').click(function () {
            if ($(this).hasClass('ka-dd__button_open')) {
                $(this).removeClass('ka-dd__button_open');
                $(this).parents('.ka-dd').find('.ka-dd__menu').slideUp();
            } else {
                $(this).addClass('ka-dd__button_open');
                $(this).parents('.ka-dd').find('.ka-dd__menu').slideDown('fast');
                setTimeout(function () {
                    pixelModelScrollbar();
                }, 900);
                // $(this).parents('.ka-dd').find('.ka-dd__menu').show();
            }
        });

        $(".ka-dd__link").click(function (event) {
            var href = $(this).attr("href");
            if ($(this).parent().find(".collapsed").length == 1) {
                $(".ka-dd__scroll .mCSB_container").animate({top: '-' + $(href).parent().position().top}, 1000);
                mk_mcscroll.mCustomScrollbar("scrollTo", $(href).parent().position().top);
            }
        });

        $(".btnCancel_confirmPixelDelete").click(function (e) {
            e.preventDefault();
            $("#id_confirmPixelDelete").val("");
        });

        // select2 js init

        $('.select2__loc').select2({
            dropdownPosition: 'above',
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select2__loc-parent')
        }).on('select2:openning', function () {
            jQuery('.select2__loc-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function () {
            jQuery('.select2__loc-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function () {
                jQuery('.select2__loc-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2__loc-parent .select2-dropdown').hide();
            jQuery('.select2__loc-parent .select2-dropdown').css({
                'display': 'block',
                'opacity': '1',
                'transform': 'scale(1, 1)'
            });
            jQuery('.select2__loc-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function (e) {
            if (!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2__loc-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select2__loc').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function () {
            jQuery('.select2__loc-parent .select2-selection__rendered').show();
            jQuery('.select2__loc-parent .select2-results__options').css('pointer-events', 'none');
        });

        $('.select2js__codetype').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select2js__pixel_codetype-parent')
        }).on('select2:openning', function() {
            jQuery('.select2js__pixel_codetype-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            jQuery('.select2js__pixel_codetype-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.select2js__pixel_codetype-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2js__pixel_codetype-parent .select2-dropdown').hide();
            jQuery('.select2js__pixel_codetype-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            lpUtilities.niceScroll();
            jQuery('.select2js__pixel_codetype-parent .select2-selection__rendered').hide();
            setTimeout(function () {
                jQuery('.select2js__pixel_codetype-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                    var getindex = jQuery('.select-custom_type').find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight - 50;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2js__pixel_codetype-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select2js__codetype').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function() {
            jQuery('.select2js__pixel_codetype-parent .select2-selection__rendered').show();
            jQuery('.select2js__pixel_codetype-parent .select2-results__options').css('pointer-events', 'none');
        });

        $('.select2js__pixelplacement').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select2js__pixelplacement-parent')
        }).on('select2:openning', function () {
            jQuery('.select2js__pixelplacement-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function () {
            jQuery('.select2js__pixelplacement-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function () {
                jQuery('.select2js__pixelplacement-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2js__pixelplacement-parent .select2-dropdown').hide();
            jQuery('.select2js__pixelplacement-parent .select2-dropdown').css({
                'display': 'block',
                'opacity': '1',
                'transform': 'scale(1, 1)'
            });
            jQuery('.select2js__pixelplacement-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function (e) {
            if (!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2js__pixelplacement-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('.select2js__pixelplacement').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function () {
            jQuery('.select2js__pixelplacement-parent .select2-selection__rendered').show();
            jQuery('.select2js__pixelplacement-parent .select2-results__options').css('pointer-events', 'none');
        });

        initializeTractingOptions();

        $('#pixel_type').on("change", function (e) {
            var placement = $("#pixel_placement").val();
            var type = $("#pixel_type").val();
            placement = addRemoveFunnelOption(type, placement);
            pixel_extra_fields(type, placement, false);
        });

        $('#pixel_placement').on("change", function (e) {
            var placement = $("#pixel_placement").val();
            var type = $("#pixel_type").val();

            pixel_extra_fields(type, placement, false);
        });

        $('[data-name="pixel_placement"] li,[data-name="pixel_type"] li').click(function () {
            var placement = $("#pixel_placement").val();
            var type = $("#pixel_type").val();
            pixel_extra_fields(type, placement, false);
        });
        $('.slider_question').inputmask();
        $(".slider_question").keyup(function () {
            var q = $(this).parent().parent().data("question");
            var min = String($('[data-question=' + q + ']').find(".min").data('min'));
            min = parseInt(min.replace(reg, ''));
            var max = String($('[data-question=' + q + ']').find(".max").data('max'));
            max = parseInt(max.replace(reg, ''));
            var mn = parseInt($('[data-question=' + q + ']').find(".min").val().replace(reg, ''));
            var mx = parseInt($('[data-question=' + q + ']').find(".max").val().replace(reg, ''));
            if ((mn < min || mx > max) || mx < mn) {
                $(this).addClass('za-error-value');
                $(this).parent().parent().parent().parent().find('.ka-dd__link').addClass('za-error-label');
                $(".pixel-model").attr("disabled", true);
                $($(this).parent().parent()).find('.answer').prop('checked', false);
            } else {
                $("#" + q).val(q + '|' + $('[data-question=' + q + ']').find(".min").val() + '~' + $('[data-question=' + q + ']').find(".max").val());
                $(this).parent().parent().parent().parent().find('.ka-dd__link').removeClass('za-error-label');
                $(this).parent().find('.min,.max').removeClass('za-error-value');
                $(".pixel-model").attr("disabled", false);
                if ($('[data-question=' + q + ']').find(".min").val() && $('[data-question=' + q + ']').find(".max").val()) {
                    $($(this).parent().parent()).find('.answer').prop('checked', true);
                }
            }

        });

        $('.answer').change(function () {
            var checked = $($(this).parent().parent().find('.item')).find('.answer:checked').length;
            if (checked > 0) {
                $(this).parent().parent().parent().find('.ka-dd__link').addClass('za-checkbox-checked');
            } else {
                $(this).parent().parent().parent().find('.ka-dd__link').removeClass('za-checkbox-checked');
            }
        });

        $('.zip_code').on('keydown keyup', function (e) {
            var key = e.charCode || e.keyCode || 0;
            var cursor = $(this).getCursorPosition();
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            if (!(key == 8 ||//Backspace
                key == 9 ||//Tab
                key == 37 ||//Setas
                key == 38 ||//Setas
                key == 39 ||//Setas
                key == 40 || //Setas
                key == 46 || // delete
                key == 65 || key == 67 || key == 86 || key == 88 || //ctrl+a,x,c,v
                key == 13 || // enter
                key >= 48 && key <= 57 || key >= 96 && key <= 105)) { // keyboard right side number pad
                e.preventDefault();
                return false;
            }

            var text = $(this).val();
            var nt = text.replace(/[^A-Za-z]/g, '');
            if (nt && key != 8) {
                $(this).parent().parent().parent().parent().find('.ka-dd__link').addClass('za-error-label');
                $(this).addClass('za-error-value');
                $(".pixel-model").attr("disabled", true);
                e.preventDefault();
            }
            else {
                $(this).parent().parent().parent().parent().find('.ka-dd__link').removeClass('za-error-label');
                $(this).removeClass('za-error-value');
                $(".pixel-model").attr("disabled", false);
            }
            var lines = text.split(linebreak);
            var nl = [];
            for (var i = 0; i < lines.length; i++) {
                if (i % 2 === 0) {
                    if (lines[i] && key != 8) {
                        if (!lines[i].replace(/[^,]/g, '') && lines[i].replace(reg, '').length == 5) {
                            if (text.indexOf(lines[i] + ',') != '-1') {
                                lines[i] = '';
                                lines[i + 1] = '';
                            } else {
                                lines[i] = lines[i] + ',\n';
                                lines[i + 1] = '';
                            }
                        }
                        else if ((lines[i]) && lines[i].length < 5) {
                            if (key == 13) {
                                e.preventDefault();
                            }
                        }
                        else if (lines[i].length > 6) {
                            if (lines[i].length > 10 && lines[i].match(/,/g)) {
                                var r = lines[i].split(',');
                                for (var a = 0; a < r.length; a++) {
                                    if (r[a]) {
                                        nl.push(r[a].substring(0, 5) + ',\n');
                                    }
                                }
                                nl.reverse();
                                lines[i] = '';
                                lines[i + 1] = '';
                            }
                            lines[i] = lines[i].substring(0, 5);
                            lines[i] = lines[i] + ',';
                            setCursorPos($(this)[0], cursor, cursor);
                            if (text.indexOf(lines[i]) != '-1') {
                                lines[i] = '';
                                lines[i + 1] = '';
                            }
                        }
                    }
                }
            }
            $.merge(lines, nl);

            lines = lines.filter(function (item) {
                if (item !== "") {
                    return item;
                }
            });

            $(this).val(lines.join(''));

        });
        $.fn.getCursorPosition = function () {
            var el = $(this).get(0);
            var pos = 0;
            if ('selectionStart' in el) {
                pos = el.selectionStart;
            } else if ('selection' in document) {
                el.focus();
                var Sel = document.selection.createRange();
                var SelLength = document.selection.createRange().text.length;
                Sel.moveStart('character', -el.value.length);
                pos = Sel.text.length - SelLength;
            }
            return pos;
        }


        //    js validation

        var pixelForm = $('#dd-code-popup').validate({
            rules: {
                pixel_name: {
                    required: true
                },
                pixel_code: {
                    required: true
                },
                pixel_other: {
                    required: function (element) {
                        return $("#pixel_type").val() == "11";
                    }
                }
            },
            messages: {
                pixel_name: {
                    required: "This field is required."
                },
                pixel_code: {
                    required: "This field is required."
                },
                pixel_other: {
                    required: "This field is required."
                }
            },
            debug: true,
            submitHandler: function (form) {
                // form.submit();
                ajaxRequestHandler.submitForm(function (response, isError) {
                    wasPixelModalShowing = false;
                    pixels.modal.modal('hide');
                    console.log("Pixel submit callback...");
                    if(response.result !== undefined && response.status == true || response.status == "true") {
                        let data = response.result,
                            pixel_name = pixels.modal.find("#pixel_name").val(),
                            pixel_type = $("#pixel_type").val();
                            table_cls = ".lp-table-item";
                        pixel_name = staticPixelName[pixel_type] !== undefined ? staticPixelName[pixel_type] : pixel_name;

                        if(data.action == "add") {
                            console.log("add action ...");
                            let id = data.id,
                                row_template = '<div class="lp-table-item">' +
                                '<ul class="lp-table__list" id="pixel_' + id + '">' +
                                    '<li class="lp-table__item" data-list-pixel-name>' + pixel_name + '</li>' +
                                    '<li class="lp-table__item">' +
                                       '<div class="action action_options">' +
                                            '<ul class="action__list">' +
                                                '<li class="action__item">' +
                                                    '<a href="#" class="action__link btn-editCode">' +
                                                        '<span class="ico ico-edit"></span>edit' +
                                                    '</a>' +
                                                '</li>' +
                                                '<li class="action__item">' +
                                                    '<a href="#" class="action__link btn-deleteCode">' +
                                                        '<span class="ico ico-cross"></span>delete' +
                                                    '</a>' +
                                                '</li>' +
                                            '</ul>' +
                                            '<ul class="action__list">' +
                                                '<li class="action__item">' +
                                                    '<i class="fa fa-circle" aria-hidden="true"></i>' +
                                                    '<i class="fa fa-circle" aria-hidden="true"></i>' +
                                                    '<i class="fa fa-circle" aria-hidden="true"></i>' +
                                                '</li>' +
                                            '</ul>' +
                                        '</div>' +
                                    '</li>' +
                                '</ul>' +
                                '<div class="lp-table__item-msg">' +
                                    '<div class="lp-table__item-confirmation">' +
                                        '<p>Are you sure you want to remove this pixel?</p>' +
                                        '<ul class="control">' +
                                            '<li class="control__item">' +
                                                '<a href="javascript:void(0);" class="lp-table_yes">Yes</a>' +
                                            '</li>' +
                                            '<li class="control__item">' +
                                                '<a href="javascript:void(0);" class="lp-table_no">No</a>' +
                                            '</li>' +
                                        '</ul>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                            let rowEl = $(row_template),
                                dataAttrbutes = pixels.getLinkDataAttributes(ajaxRequestHandler.formId);
                            dataAttrbutes['data-id'] = id;
                            dataAttrbutes = pixels.addTrackingOptionsAttributes(ajaxRequestHandler.formId, dataAttrbutes);
                            console.log("dataAttrbutes", dataAttrbutes);
                            pixels.addOrUpdateLinkDataAttributes(rowEl.find(".btn-editCode"), rowEl.find(".btn-deleteCode"), dataAttrbutes);
                            if($(table_cls).length) {
                                rowEl.insertAfter(table_cls + ":last");
                            } else {
                                $('.pixel-panel .message-block').css('display', 'none');
                                $(rowEl).appendTo(".lp-table__body");
                            }
                            pixels.bindEvents($("#pixel_" + id));
                        } else if(data.action == "update"){
                            let rowEl = $("#pixel_" + pixels.editData.id),
                                dataAttrbutes = pixels.getLinkDataAttributes(ajaxRequestHandler.formId);
                            if(staticPixelName[pixel_type] !== undefined) {
                                dataAttrbutes['data-pixel_name'] = staticPixelName[pixel_type];
                            }
                            dataAttrbutes = pixels.addTrackingOptionsAttributes(ajaxRequestHandler.formId, dataAttrbutes);

                            pixels.addOrUpdateLinkDataAttributes(rowEl.find(".btn-editCode"), rowEl.find(".btn-deleteCode"), dataAttrbutes);
                            console.log("Pixel name", rowEl.find("[data-list-pixel-name]").html());
                            rowEl.find("[data-list-pixel-name]").html(dataAttrbutes['data-pixel_name']);
                            console.log("Update", rowEl, pixels.editData.id, dataAttrbutes, dataAttrbutes['data-pixel_name']);
                        }
                    }
                });
            }
        });

        $(".lp-btn-addCode").click(function (e) {
            e.preventDefault();
            ajaxRequestHandler.setAutoEnableDisableButton(false);
            form_rest();
            pixels.addPixelCode();
            $(".modal-content").find(".form-control.error").removeClass("error");
            pixelForm.resetForm();
        });

        var $heading = $('.lp-table__head .lp-table__list');

        if ($('.lp-table__body .lp-table__list').length) {
            $heading.show();
        } else {
            $heading.hide();
        }

    });
})(jQuery);


function uniqueCode(arr, v) {
    var out = [];

    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == v) {
            out[i] = v;
        }
    }
    return out;
}

function setCursorPos(input, start, end) {
    if (arguments.length < 3) end = start;
    if ("selectionStart" in input) {
        setTimeout(function () {
            input.selectionStart = start;
            input.selectionEnd = end;
        }, 1);
    }
    else if (input.createTextRange) {
        var rng = input.createTextRange();
        rng.moveStart("character", start);
        rng.collapse();
        rng.moveEnd("character", end - start);
        rng.select();
    }
}

function setVisibleTrackingOptions(visibility, ...options) {
    let visible = visibility == 'visible';
    //setting visibility to true
    trackingOption.map((option) => {
        option.visible = !visible;
    });

    let selected_tracking_option = parseInt($('#tracking_options').attr('data-default-val'));
    let count = 0;
    //hiding selected options
    options.forEach((value) => {
        trackingOption.map((option) => {

            option.selected = selected_tracking_option == option.value ? true : false;
            return option.visible = option.value == value ? visible : option.visible;
        })
    })
    visibleOptions = trackingOption.filter((option) => {
        return option.visible;
    });
    if (visibleOptions.length > 1) {
        // $('#tracking_options').removeAttr('disabled');
        $('#tracking_options').removeAttr('readonly');
        $('#tracking_options').siblings().children().find('.select2-selection__arrow').show();
    } else {
        // $('#tracking_options').attr('disabled','disabled');
        $('#tracking_options').attr('readonly', 'readonly');
        $('#tracking_options').siblings().children().find('.select2-selection__arrow').hide()
    }

    // cleaning select options
    $("select[name=\"tracking_options\"] option").remove();


    //displaying the visible options
    visibleOptions.forEach((option) => {
        $("select[name=\"tracking_options\"]")[0].append(new Option(option.title, option.value, false, option.selected));
    });

}

function setHTMLLabelsAndVisibility(type, placement, elem) {
    // Slide Down = Show
    type = parseInt(type);
    placement = parseInt(placement);
    switch (type) {
        case CODETYPE.GOOGLE_ANALYTICS:
            $(".tracking_to_lender").html("Tracking ID");
            if (placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
                $(".pixel_position,.facebook-domain-verification").slideDown();
                $(".tracking_options").slideUp();
                $(".pixel_other").slideUp();
            }
            else if (placement == PIXEL_PLACEMENT.PAGE_THANKYOU) {
                setVisibleTrackingOptions('visible', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
                $(".pixel_other").slideUp();
            }
            break;
        case CODETYPE.FACEBOOK_PIXEL:
            $(".tracking_to_lender").html("Pixel ID");
            if (placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
                setVisibleTrackingOptions('hidden', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
                $(".pixel_other").slideUp();

                setTimeout(function () {
                    if (GLOBAL_MODE) {
                        $("#tracking_options option[value='"+ TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS+ "']").prop('disabled', true);
                        $("#tracking_options option[value='"+ TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS+ "']").addClass("el-tooltip page_view_plus_questions_tooltip disbale");
                        $("#tracking_options option[value='"+ TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS+ "']").parents('.tracking_options').addClass("disbale-parent");
                        // $('.select2-results__option :contains("Page View + Questions")').addClass("el-tooltip disbale");
                        $('.page_view_plus_questions_tooltip').attr('title', 'Page View + Questions are not available<br> in Global' + ' Setting' + ' mode. Turn<br> off Global Setting at the top to add');

                        if ($("#tracking_options").val() == TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS) {
                            /*$('#add_code_submit').prop('disabled', true);*/
                            $('#add_code_submit').addClass('disabled');
                        }
                    } else {
                        $("#tracking_options option[value='"+ TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS+"']").prop('disabled', false);
                        $("#tracking_options option[value='"+ TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS+ "']").removeClass("el-tooltip disbale");
                        $("#tracking_options option[value='"+ TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS+ "']").parents('.tracking_options').removeClass("disbale-parent");
                        /*$('#add_code_submit').prop('disabled', false);*/
                        $('#add_code_submit').removeClass('disabled');
                    }
                });

            }
            else if (placement == PIXEL_PLACEMENT.PAGE_THANKYOU) {
                setVisibleTrackingOptions('visible', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
                $(".pixel_other").slideUp();
            }
            // if(elem) {
            //     //Funnels can have only Leads as action so puting hardcoded lead value
            //     $("#pixel_action").val(PIXEL_ACTION_LEAD);
            //     $("#fb_pixel_conversion").val(elem.attr('data-pixel_other'));
            // }
            $('#tracking_options').trigger('change');
            break;
        case CODETYPE.GOOGLE_TAG_MANAGER:
            $(".tracking_to_lender").html("Container ID");

            if (placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
                $(".pixel_position,.facebook-domain-verification").slideDown();
                $(".tracking_options").slideUp();
                $(".pixel_other").slideUp();
            }
            else if (placement == PIXEL_PLACEMENT.PAGE_THANKYOU) {
                setVisibleTrackingOptions('visible', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
                $(".pixel_other").slideUp();
            }
            break;
        case CODETYPE.GOOGLE_CONVERSION_PIXEL:
            $(".pixel_other").slideDown();
            $(".pixel_other .pixel_other_label").html("Conversion Label");
            $(".tracking_to_lender").html("Conversion ID");
            if (placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
                $(".tracking_options").slideUp();
                $(".pixel_position,.facebook-domain-verification").slideDown();
                if (elem) {
                    $("#pixel_other").val(elem.attr('data-pixel_other'));
                }
            } else if (placement == PIXEL_PLACEMENT.PAGE_THANKYOU) {
                setVisibleTrackingOptions('visible', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
            }
            break;
        case CODETYPE.BING_PIXEL:
            $(".tracking_to_lender").html("Tag ID");
            if (placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
                $(".tracking_options").slideUp();
                $(".pixel_position,.facebook-domain-verification").slideDown();
            }
            else if (placement == PIXEL_PLACEMENT.PAGE_THANKYOU) {
                setVisibleTrackingOptions('visible', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
            }
            break;
        case CODETYPE.GOOGLE_RETARGETING_PIXEL:
            $(".tracking_to_lender").html("Conversion ID");
            if (placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
                $(".pixel_other .pixel_other_label").html("Targeting To");
                $(".pixel_other").slideDown();
                $(".pixel_position,.facebook-domain-verification").slideDown();
                $(".tracking_options").slideUp();

                if (elem) {
                    $("#pixel_other").val(elem.attr('data-pixel_other'));
                }
            }
            else if (placement == PIXEL_PLACEMENT.PAGE_THANKYOU) {
                setVisibleTrackingOptions('visible', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".pixel_other").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
            }
            break;
        case CODETYPE.INFORMA_PIXEL:
            $(".tracking_to_lender").html("Lender ID");
            if (placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
                $(".pixel_other").slideUp();
                $(".tracking_options").slideUp();
                $(".pixel_position,.facebook-domain-verification").slideDown();
            }
            else if (placement == PIXEL_PLACEMENT.PAGE_THANKYOU) {
                setVisibleTrackingOptions('visible', PIXEL_ACTION_LEAD);
                $(".pixel_position").slideUp();
                $(".pixel_other").slideUp();
                $(".tracking_options,.facebook-domain-verification").slideDown();
            }
            break;
        case CODETYPE.FACEBOOK_DOMAIN_VERIFICATION:
            $(".tracking_to_lender").html("Content");
            $(".pixel_position, .facebook-domain-verification, .tracking_options").slideUp();
            break;
        case CODETYPE.FACEBOOK_CONVERSION_API:
            $(".tracking_to_lender").html("Pixel ID");
            $(".pixel_other .pixel_other_label").html("Token");
            $(".pixel_position,.facebook-domain-verification,.tracking_options").slideUp();
            $(".pixel_other").slideDown();
            break;
    }

}

function pixel_extra_fields(type, placement, elem) {

    $('.pixel_extra,.tracking_options,.question_options').hide();
    $('#tracking_options').val($('[data-name="tracking_options"]').attr('data-default-val'));
    setHTMLLabelsAndVisibility(type, placement, elem);
    return
}

function form_rest() {
    $('.answer').prop("checked", false);
    $(".zip_code,.min,.max").val('');
    $(".zip_code").removeClass('za-error-value');
    $(".ka-dd__list .ka-dd__link").removeClass('za-checkbox-checked za-error-label');
    $(".ka-dd__link,.panel-collapse").attr("aria-expanded", "false");
    $(".ka-dd__link").addClass("collapsed");
    $(".panel-collapse").removeClass("in");
    $(".pixel-model").attr("disabled", false);
}

function CodeName_List() {
    var length = $('.pixel-panel .lp-table__body .lp-table__list .lp-table__item').length;
    if (length <= 0) {
        $('.pixel-panel .message-block').css('display', 'flex');
    } else {
        $('.pixel-panel .message-block').css('display', 'none');
    }
}

//this function use when select Tracking Options :- page view/page view + questions
function pixelModelScrollbar() {
    if ($(".pixel-quick-scroll .mCSB_scrollTools:eq(1)").css('display') == 'block') {
        var scroll_dragger = $(".pixel-quick-scroll .mCSB_dragger:eq(1)").height();
        var scroll_rail = $(".pixel-quick-scroll .mCSB_draggerRail:eq(1)").height();
        var container = $(".pixel-quick-scroll .mCSB_container:eq(0)").height();
        var new_scroll_height = parseFloat(scroll_rail) - parseFloat(scroll_dragger);
        var container_height = parseFloat(container) - parseFloat(scroll_rail) - 20;
        $(".pixel-quick-scroll .mCSB_container:eq(0)").animate({top: -container_height}, 350);
        $(".pixel-quick-scroll .mCSB_dragger:eq(1)").animate({top: new_scroll_height}, 350);
    }
}

jQuery('#deleteConfirm').click(function () {
    CodeName_List();
});


function addRemoveFunnelOption(type,placement) {
    if(type == CODETYPE.INFORMA_PIXEL){
        if(placement == PIXEL_PLACEMENT.PAGE_FUNNEL) {
            $("#pixel_placement").val(PIXEL_PLACEMENT.PAGE_THANKYOU).trigger('change.select2');
            placement = PIXEL_PLACEMENT.PAGE_THANKYOU;
        }
        // console.log($("#pixel_placement option[value='"+CODETYPE.PAGE_FUNNEL+"']"));

        $("#pixel_placement option[value='"+PIXEL_PLACEMENT.PAGE_FUNNEL+"']").remove();
        $("#pixel_placement").trigger("change");
    } else if($("#pixel_placement option[value='"+PIXEL_PLACEMENT.PAGE_FUNNEL+"']").length == 0) {
        $("#pixel_placement").prepend('<option value="'+PIXEL_PLACEMENT.PAGE_FUNNEL+'">Funnel</option>');
        $("#pixel_placement").trigger("change");
    }
    return placement;
}


var pixels = {
    editData: null,
    modal: $("#model_pixel_code"),
    init: function(){
       this.bindEvents();
    },
    bindEvents: function (containerElem) {
        if (containerElem == undefined) {
            delLinkElem = $('.btn-deleteCode');
            editLinkElem = $('.btn-editCode');
            delConfirmationNoElem = $('.lp-table_no');
            delConfirmationYesElem = $('.lp-table_yes');
        } else {
            delLinkElem = $(containerElem).find('.btn-deleteCode');
            editLinkElem = $(containerElem).find('.btn-editCode');

            //binding events on confirmation buttons
            let parentEl = $(containerElem).parents('.lp-table-item');
            delConfirmationNoElem = $(parentEl).find('.lp-table_no');
            delConfirmationYesElem = $(parentEl).find('.lp-table_yes');
            console.log("Parent", containerElem, parentEl);
        }

        let $self = this;
        editLinkElem.click(function (e) {
            e.preventDefault();
            form_rest();
            $self.editPixelCode($(this));
            ajaxRequestHandler.setAutoEnableDisableButton(true);
            ajaxRequestHandler.loadFormSavedValues();
        });

        delLinkElem.click(function (e) {
            e.preventDefault();
            $('#saved_pixel_code').val($(this).attr('data-pixel_code') || '');
            $('#saved_pixel_type').val($(this).attr('data-pixel_type') || '');
            $('#saved_pixel_placement').val($(this).attr('data-pixel_placement') || '');
            var pixel_name = $(this).attr('data-pixel_name');
            $("#notification_confirmPixelDelete").html('Do you want to delete ' + pixel_name + '?');
            //$("#id_confirmPixelDelete").val( $(this).attr('data-id') );
            $("#id_confirmPixelDelete").val($(this).attr('data-id'));

            $(this).parents('.lp-table-item').find('.lp-table__list').slideUp();
            $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideDown();
        });

        delConfirmationNoElem.click(function (e) {
            $(this).parents('.lp-table-item').find('.lp-table__list').slideDown();
            $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideUp();
        });

        delConfirmationYesElem.click(function (e) {
            e.preventDefault();
            let self = this;

            if (GLOBAL_MODE) {
                confirmationModalObj.setCustomSubmitCallback(function () {
                    $self.deletePixelCode($(self));
                });
                showGlobalRequestConfirmationForm($("#form_confirmpixelDelete"));
            } else {
                $self.deletePixelCode($(self));
            }
        });
    },

    editPixelCode: function(elem) {
        let data = {
            id: elem.attr('data-id'),
            pixelName: elem.attr('data-pixel_name'),
            pixelCode: elem.attr('data-pixel_code'),
            pixelType: elem.attr('data-pixel_type'),
            pixelTypeLabel: elem.attr('data-pixel_type_label'),
            pixelPlacement: elem.attr('data-pixel_placement'),
            pixelPlacementLabel: elem.attr('data-pixel_placement_label'),
            pixelPositionLabel: elem.attr('data-pixel_position_label'),
            fbQuestionFlag: elem.attr('data-fb_questions_flag'),
            pixelOther: elem.attr('data-pixel_other')
        }

        var $modalPixel = this.modal;

        $modalPixel.find("#id").val(data.id);
        $modalPixel.find("#pixel_name").val(data.pixelName);
        $modalPixel.find("#pixel_code").val(data.pixelCode);
        $("#pixel_other").val(data.pixelOther);

        $('#saved_pixel_code').val(data.pixelCode);
        $('#saved_pixel_type').val(data.pixelType);

        $modalPixel.find('#pixel_type').val(data.pixelType);
        $modalPixel.find('[data-name="pixel_type"]').find(".displayText").html(data.pixelTypeLabel);
        // $modalPixel.find('#pixel_type').trigger('change');

        if (data.pixelPlacement == 1 || data.pixelPlacement == 3) {
            $modalPixel.find('#pixel_placement').val(PIXEL_PLACEMENT.PAGE_FUNNEL);
            $modalPixel.find('[data-name="pixel_placement"]').find(".displayText").html('Funnel');
        } else {
            $modalPixel.find('#pixel_placement').val(data.pixelPlacement);
            $modalPixel.find('[data-name="pixel_placement"]').find(".displayText").html(data.pixelPlacementLabel);
        }
        // $("#pixel_placement").trigger("change");
        $modalPixel.find('#pixel_position').val(data.pixelPlacement);
        $modalPixel.find('[data-name="pixel_position"]').find(".displayText").html(data.pixelPositionLabel);
        $('.pixel_extra').slideUp();
        var v = 0;
        if (data.fbQuestionFlag == 1) {
            v = 3;
            $("#pixel_placement").val(2);
            var q;
            var ans_arr = elem.data('fb_questions_json');
            $.each(ans_arr, function (k, v) {
                $.each(v, function (a, r) {
                    if (k == 'enteryourzipcode') {
                        $(".zip_code").val(String(v).replace(/\,/g, ',\n'));
                        $('.zip_code').parent().parent().parent().parent().find('.ka-dd__link').addClass('za-checkbox-checked');
                    } else {
                        q = k + r.toLowerCase().replace('.', '_').replace(/[^A-Za-z0-9_]+/ig, "");
                        $("#" + q).prop('checked', true);
                        if ($('[data-question=' + k + ']').length == 1) {
                            $("input[data-value='" + k + "']").prop('checked', true);
                            $('#' + k).val(k + '|' + r);
                            var arr = r.split('~');
                            $('[data-question=' + k + ']').find(".min").val(arr[0]);
                            $('[data-question=' + k + ']').find(".max").val(arr[1]);
                        }
                    }
                    $('.answer').change();
                });
            });
        } else if (data.pixelPositionLabel == 4) {
            v = 2;
        } else {
            v = 1;
        }

        $('[data-name="tracking_options"]').attr('data-default-val', v);
        $('[data-name="tracking_options"]').attr('data-default-label', $('.tracking_options ul li[data-value="' + v + '"]').text());
        $(".pixel_position").slideDown();
        var placement = $("#pixel_placement").val();
        var type = $("#pixel_type").val();
        pixel_extra_fields(type, placement, elem);

        $modalPixel.find(".modal-title").html("Edit Pixels and Tracking Codes");
        $modalPixel.find("#action").val("update");
        $modalPixel.find(".lp-btn-add").val("UPDATE CODE");
        $modalPixel.find("select").trigger('change');
        $modalPixel.modal('show');

        this.editData = data;

        this.editData["fb_questions_json"] = ans_arr;

    },

    deletePixelCode: function(elem) {
        if (!requesting) {
            requesting = true;
            var data = {
                id: $("#id_confirmPixelDelete").val(),
                client_id: $("#client_id_confirmPixelDelete").val()
            }

            var url = "/lp/popadmin/deletepixelinfo";
            if (GLOBAL_MODE) {
                data.action = 'delete';
                let _values =  selectedFunnelList();
                data.selected_funnels = _values.map(val => val.fkey).join(',');
                data.current_hash = $('#current_hash').val();
                data.saved_pixel_code = $('#saved_pixel_code').val();
                data.saved_pixel_type = $('#saved_pixel_type').val();
                data.saved_pixel_placement = $('#saved_pixel_placement').val();
                url = "/lp/global/pixelActionGlobalAdminThree";
            }

            let {hide} = displayAlert("loading", "Processing your request");
            $.ajax({
                type: "POST",
                data: data,
                dataType: "json",
                url: url,
                success: function (d) {
                    if (d.status == true || d.status == 'true') {
                        var message = 'Code has been deleted.';
                        $('#pixel_' + $("#id_confirmPixelDelete").val().replace(/\'/g, '')).parent().remove();
                        displayAlert('success', message);
                        CodeName_List();
                    }
                    // else {
                    //     var message = 'Unable to delete code';
                    //     displayAlert('danger', message);
                    // }
                    // $("#model_confirmPixelDelete").modal('toggle');
                },
                error: function () {
                    if (response.error) {
                        setTimeout(function () {
                            displayAlert("danger", response.error);
                        }, 500);
                    } else {
                        setTimeout(function () {
                            displayAlert("danger", "Your request was not processed. Please try again.");
                        }, 500);
                    }
                    // var message = 'Application Error';
                    // displayAlert('danger', message);
                },
                complete: () => {
                    hide();
                    confirmationModalObj.removeCustomSubmitCallback();
                    $('#global-setting-funnel-list-pop').modal('hide');

                    var $heading = $('.lp-table__head .lp-table__list');

                    if ($('.lp-table__body .lp-table__list').length) {
                        $heading.show();
                    } else {
                        $heading.hide();
                    }

                    requesting = false;
                },
                cache: false,
                async: true
            });
        } else {
            console.log('Previous request is not completed!');
        }
    },

    addPixelCode: function() {
        var $modalPixel = $("#model_pixel_code");

        $modalPixel.find("#id").val('');
        $modalPixel.find("#pixel_name").val('');
        $modalPixel.find("#pixel_code").val('');
        // $('#tracking_options').attr('data-default-val','');

        $modalPixel.find('#pixel_type').val($modalPixel.find('#pixel_type').attr('data-default-val')).trigger('change');
        // $modalPixel.find('[data-name="pixel_type"]').find(".displayText").html( $('[data-name="pixel_type"]').attr('data-default-label') );

        $modalPixel.find('#pixel_placement').val($('[data-name="pixel_placement"]').attr('data-default-val'));
        $modalPixel.find('[data-name="pixel_placement"]').find(".displayText").html($('[data-name="pixel_placement"]').attr('data-default-label'));

        $modalPixel.find('#pixel_position').val($('[data-name="pixel_position"]').attr('data-default-val'));
        $modalPixel.find('[data-name="pixel_position"]').find(".displayText").html($('[data-name="pixel_position"]').attr('data-default-label'));

        $("#tracking_options").val('1').attr('data-default-val', 1);
        // $modalPixel.find('#tracking_options').val( $('[data-name="tracking_options"]').attr('data-default-val') );
        // $modalPixel.find('[data-name="tracking_options"]').find(".displayText").html( $('[data-name="tracking_options"]').attr('data-default-label') );
        $('.pixel_extra,.tracking_options,.question_options').slideUp();
        $(".pixel_position").slideDown();
        $(".tracking_to_lender").html("Tag ID");
        // $modalPixel.find('#pixel_action').val( $('[data-name="pixel_action"]').attr('data-default-val') );
        // $modalPixel.find('[data-name="pixel_action"]').find(".displayText").html( $('[data-name="pixel_action"]').attr('data-default-label') );
        $modalPixel.find('#pixel_action_' + $('[data-name="pixel_action"]').attr('data-default-val')).prop('checked', true);

        $modalPixel.find("div.pixel_other").slideUp();
        $modalPixel.find("#pixel_other").val('');

        $modalPixel.find(".modal-title").html("Add Pixels and Tracking Codes");
        $modalPixel.find("#action").val("add");
        $modalPixel.find(".lp-btn-add").val("ADD CODE");

        $modalPixel.find('#ka-dd-toggle').removeClass('ka-dd__button_open');
        $modalPixel.find('.ka-dd__menu').slideUp();
        // $modalPixel.find("select").trigger('change');
        $modalPixel.modal('show');
    },

    getLinkDataAttributes(formId){
        let values = {};
        jQuery(formId + ' [data-form-field]').each(function (index, el) {
            el = $(el);
            let name = el.attr('name');
            if(name !== undefined) {
                values["data-" + name] = el.val();
            }
        });

        if(values['data-pixel_type'] == CODETYPE.FACEBOOK_PIXEL && values["data-pixel_placement"] == PIXEL_PLACEMENT.PAGE_FUNNEL){
            values["data-pixel_placement"] 	= 1;
        }else if(values["data-pixel_placement"] != PIXEL_PLACEMENT.PAGE_THANKYOU){
            values["data-pixel_placement"] 	= values["data-pixel_position"];
        }

        return values;
    },

    /**
     * created function to update data attributes
     * because wasn't able to update all attributes as did in add functionality
     * @param editEl
     * @param delEl
     * @param data
     */
    addOrUpdateLinkDataAttributes(editEl, delEl, data){
        for(let key in data) {
            let value = data[key];
            if(key == "data-fb_questions_json" && typeof value === 'object') {
                value = JSON.stringify(value);
            }
            editEl.attr(key, value);
            delEl.attr(key, value);
        }
    },

    onChangeTrackingOptionsHandleButton: function (disabled) {
        console.log("onChangeTrackingOptionsHandleButton called...");
        if(!disabled) {
            return disabled;
        }

        let trackingOptions = pixels.addTrackingOptionsAttributes(ajaxRequestHandler.formId, pixels.editData);

        disabled = trackingOptions["data-fb_questions_flag"] == pixels.editData.fbQuestionFlag;
        if(!disabled) {
            return disabled;
        }

        let newObjType = typeof trackingOptions['data-fb_questions_json'],
            oldObjType = typeof pixels.editData.fb_questions_json;

        if(newObjType === 'object' && oldObjType === newObjType) {
            return ajaxRequestHandler.isEquals(trackingOptions['data-fb_questions_json'], pixels.editData.fb_questions_json);
        }

        return trackingOptions['data-fb_questions_json'] == pixels.editData.fb_questions_json;
        // jQuery(trackingOptions['data-fb_questions_json']).compare(pixels.editData.fb_questions_json, {
        //     caseSensitive: false,
        //     success: function(mixed) {
        //         disabled = true;
        //         console.log("passes");
        //     },
        //     error: function(mixed) {
        //         disabled = false;
        //         console.log("failed");
        //     }
        // });
        // return disabled;
    },

    /**
     * used to update data attributes for tracking option + question JSON
     * @param formId
     * @param data
     * @returns {*}
     */
    addTrackingOptionsAttributes: function (formId, data) {
        let tracking_options = $(formId + " #tracking_options").val();
        console.log("addTrackingOptionsAttributes", data, tracking_options);
        if(tracking_options && tracking_options == TRACKING_OPTION.PAGE_VIEW_PLUS_QUESTIONS){
            data["data-fb_questions_flag"] 	= 1;

            let questionJSON = {},
                zipCode = $(formId + " .zip_code").val();

            if(zipCode){
                let zipCodes = zipCode.split(",");

                $(zipCodes).each(function (index, zip) {
                    zip =  zip.replace(new RegExp('\r?\n','g'), "");
                    if(questionJSON['enteryourzipcode'] === undefined) {
                        questionJSON['enteryourzipcode'] = [];
                    }
                    questionJSON['enteryourzipcode'].push(zip);
                });
            }

            $(formId + ' input:checked').map(function(){
                let answer = $(this).val(),
                    answerArr = answer.split("|");
                if(questionJSON[answerArr[0]] === undefined) {
                    questionJSON[answerArr[0]] = [];
                }
                questionJSON[answerArr[0]].push(answerArr[1]);
            });
            data["data-fb_questions_json"] 	= questionJSON;
            // data["data-fb_questions_json"] 	= JSON.stringify(questionJSON);
        } else {
            data["data-fb_questions_flag"] 	= 0;
            data["data-fb_questions_json"] 	= "";
        }
        console.log("Tracking Options", data["data-fb_questions_flag"], data["data-fb_questions_json"]);
        return data;
    }
}
