var funnel_thank_you = {

    /*
    * clone thank you page
    * */
    clonePage: function () {
        jQuery(document).on('click', '.lp-control__link__copy', function (e){
            e.preventDefault();
            var _self = jQuery(this);
            var form = _self.parents('#thankyou-pages-form');
            const submission_id = _self.data('submission-id');
            const current_hash = $('[data-id="main-submit"]').data("lpkeys");
            $.ajax({
                type: 'POST',
                url: '/lp/popadmin/thank-you-pages/duplicate',
                data: { submission_id,current_hash },
                beforeSend: function() {
                    //   lptoast.cogoToast.warn('Please wait...', { position: 'top-center', heading: 'Alert!' });
                },
                success: function(response) {
                    if (response.status) {
                        thankyou_hbar.renderThankyouTemplate(thankyou_hbar.templtate, "thankyouList",response.result.data);
                        lptoast.cogoToast.success(response.message, { position: 'top-center', heading: 'Success' });
                    } else {
                        lptoast.cogoToast.error(response.message, { position: 'top-center', heading: 'Success' });

                    }
                }
            })

            lpUtilities.globalTooltip();
        });
    },

    addPage: function () {
        jQuery('.add-thankyou_page').click(function (e){
            e.preventDefault();
            let cta = jQuery('.add-thankyou_page');
            const form = $(this).parents('#thankyou-pages-form');
            const uuid = Math.floor(Math.random() * 1000) + 1;
            const hash = $('[data-id="main-submit"]').data("lpkeys");
            $.ajax({
                method: 'post',
                url: '/lp/popadmin/thank-you-pages/save/' + hash,
                data: { noOfPages: 1, 'current_hash': hash },
                beforeSend: function() {
                    cta.find('.add-box__text').html('Please Wait...');
                    cta.css('cursor', 'not-allowed');
                },
                success: function(response) {
                    if (response.status) {
                        lptoast.cogoToast.success(response.message, { position: 'top-center', heading: 'Success' });
                        thankyou_hbar.renderThankyouTemplate(thankyou_hbar.templtate, "thankyouList",response.result.data);
                    }
                },
                complete: function (data) {
                    cta.find('.add-box__text').html('Add New Page');
                    cta.css('cursor', 'pointer');
                }
            });
            lpUtilities.globalTooltip();
        });
    },

    sortable: function () {
        $( ".fb-question-items-wrap" ).sortable({
            items: ".fb-question-item",
            placeholder: "thankyou-item__highlight",
            handle: ".lp-control__link_cursor_move",
            start:function(event,ui){
                $('.thankyou-item__highlight').text('Drag & Drop Your Page Here');
            },
            stop:function(event,ui){
                var ids = $(".fb-question-items-wrap").sortable("toArray");
                var a = $(".fb-question-items-wrap").sortable("serialize", {
                    attribute: "id"
                });
                $.ajax({
                    type: 'POST',
                    url: '/lp/popadmin/thank-you-pages/re-ordering',
                    data: {
                        ids: ids
                    },
                    success: function(response) {
                        console.log('response', response)
                        lptoast.cogoToast.success(response.message, { position: 'top-center', heading: 'Success' });
                    }
                })
                $('.thankyou-item__highlight').text('Drag & Drop Your Page Here');
            }
        });
    },

    deletePage: function () {
        $(document.body).on('click', '.delete-page', function() {
            const _self = $(this);
            const submission_id = _self.data('submission-id');
            const isExisting = _self.data('existing');
            const _form = _self.parents('#thankyou-pages-form');
            const itemId = _self.data('uuid');
            if (typeof isExisting != "undefined" && isExisting == 1) {
                $('#submission-page-id').remove();
                $('#confirmation-delete-funnel').find('form').append(`<input type="hidden" name="id" id="submission-page-id" value="${submission_id}">`)
                $('#confirmation-delete-funnel').modal('show')
            } else if(itemId) {
                $('.itemId-' + itemId).remove();
            }
        })
    },

    deleteSubmissionPage: function() {
        $('#deleteSubmit').on('click', function() {
            const id = $('#submission-page-id').val();
            const _self = $(this);
            const btnText = _self.html();
            const formUrl = $(this).parents('form').attr('action');
            if (id) {
                $.ajax({
                    method: 'delete',
                    data: {id},
                    url: formUrl,
                    beforeSend: function() {
                        _self.empty().html('Please Wait...');
                        _self.prop('disabled', true);
                    },
                    success: function (response) {
                        _self.empty().html(btnText);
                        _self.prop('disabled', false);
                        if (response.status) {
                            $('#' + id).remove();
                            $('#confirmation-delete-funnel').modal('hide')
                            lptoast.cogoToast.success(response.message, { position: 'top-center', heading: 'Success' });
                            if(jQuery(".fb-question-items-wrap .fb-question-item").length === 1){
                                jQuery("[data-hide]").remove();
                            }
                        } else {
                            lptoast.cogoToast.error(response.message, { position: 'top-center', heading: 'Error' });

                        }
                    }
                })
            }
        })
    },

    savePage: function() {
        $('#main-submit').on('click', function(e) {
            e.stopPropagation();
            const hash = $('#current_hash').val();
            const newItems = $('.new-item').length;
            const _self = $(this);
            const btnText = _self.html();
            if (newItems) {
                $.ajax({
                    method: 'post',
                    url: '/lp/popadmin/thank-you-pages/save/' + hash,
                    data: { noOfPages: newItems, 'current_hash': hash },
                    beforeSend: function() {
                        _self.empty().html('Please Wait...');
                        _self.prop('disabled', true);
                    },
                    success: function(response) {
                        _self.empty().html(btnText);
                        _self.prop('disabled', false);
                        if (response.status) {
                            $('.fb-question-item').removeClass('new-item');
                            lptoast.cogoToast.success(response.message, { position: 'top-center', heading: 'Success' });
                            window.location.reload();
                        }
                    }
                })
            }
        })
    },

    disabledSaveBtn: function() {
        $('#main-submit').prop('disabled', true)
    },

    enablePagination: function(e) {
        $('.pagination li a').on('click', function(e) {
            if(!$(this).parent().hasClass('disabled')) {
                e.stopPropagation();
            }
        })
    },

    addThirdParty: function () {
        $("#thrd_url").blur(function () {
            var text = $(this).val();
            var replace = text.replace(/(^\w+:|^)\/\//, '');
            $(this).val(replace);
        });

        $.validator.addMethod("thrd_url", function (value, element) {
            return this.optional(element) || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
        }, "Please enter a valid URL.");

        $("#thankyou-page-from").validate({
            rules: {
                footereditor: {
                    thrd_url: function (element) {
                        return $("#thirldparty").is(':checked');
                    },
                    required: function (element) {
                        return $("#thirldparty").is(':checked');
                    }
                }
            },
            messages: {
                footereditor: {
                    thrd_url: "Please enter a valid URL.",
                    required: "Please enter your URL."
                }
            },
            submitHandler: function (form) {

                const hash = $('[data-id="main-submit"]').data("lpkeys");
                const flag = jQuery("#https_flag").val();
                const thrd_url = jQuery("#thrd_url").val();
                const thirdparty_active = jQuery("#thirldparty").is(":checked")?"y":"n";
                const thankyou_active = jQuery("#thankyou").is(":checked")?"y":"n";
                const id = jQuery("[name='submission_id']").val();
                let editor = lpHtmlEditor.getInstance();
                const advancehtml = editor.html.get();
                console.log(advancehtml,226)
                const third_party_url = $('#thrd_url').val();
                if(thirdparty_active == 'y' && ( third_party_url == '' || third_party_url =='undefined'))
                {
                    $('#eurllink').click();
                    $('#thrd_url').addClass('error');
                    displayAlert('warning','Please enter a valid URL.');
                    return false;
                }
                $.ajax({
                    method: 'post',
                    url: '/lp/popadmin/thank-you-pages/funnel-builder-thankyou-setting',
                    data: {thankyou_title: $("#thankyou-title")?.val(),thankyou_slug: $("#thankyou_slug")?.val(), thankyou: advancehtml, 'https_flag': flag, 'thirdparty': thrd_url, 'thirdparty_active': thirdparty_active,'thankyou_active':thankyou_active,'id':id ,'current_hash': hash,'noOfPages':1,'thankyou_logo':$('#typ_logo')?.val() },
                    success: function(response) {
                        if (response.status) {
                            displayAlert('success',response.message);
                            thankyouList = response.result.data;
                            thankyou_hbar.renderThankyouTemplate('funnel-builder-thankyou-pages-list.hbs', "thankyouList",response.result.data);
                            jQuery("#fb-thank-you").modal('hide');
                            jQuery(".save-third-party").prop('disabled',true);
                            jQuery(".action__link_edit, .thankyou-edit-page").show();
                            jQuery(".thankyou-page-cancel, .third-party__panel, .action__link_cancel," +
                                " .thankyou-page-text-area").hide();
                        }
                    }
                });
                lpUtilities.globalTooltip();
            }
        });
    },

    init: function () {
        funnel_thank_you.clonePage();
        funnel_thank_you.addPage();
        funnel_thank_you.sortable();
        funnel_thank_you.deletePage();
        funnel_thank_you.savePage();
        funnel_thank_you.deleteSubmissionPage();
        // funnel_thank_you.disabledSaveBtn();
        funnel_thank_you.enablePagination();
        funnel_thank_you.addThirdParty();
    },
}

jQuery(document).ready(function () {
    funnel_thank_you.init();
    /**
     *
     * Thank you page
     *
     */
    $( "body" ).off("change").on( "change",".thktogbtn" , function(e) {
        if ($(this).is(':checked')) {
            if($(this).attr('id') === 'thirldparty'){
                jQuery("#thankyou").prop("checked",false).parents('.toggle').removeClass('btn-active').addClass('btn-inactive off');
            }
            else{
                jQuery("#thirldparty").prop("checked",false).parents('.toggle').removeClass('btn-active').addClass('btn-inactive off');
            }
        }
        else{
            if($(this).attr('id') === 'thirldparty'){
                jQuery("#thankyou").prop("checked",true).parents('.toggle').removeClass('btn-inactive off').addClass('btn-active');
            }
            else{
                jQuery("#thirldparty").prop("checked",true).parents('.toggle').removeClass('btn-inactive off').addClass('btn-active');
            }
        }
    });

    jQuery(document).on('click',"[data-thankyou-edit]",function (){
        let href = jQuery(this).data('href');
        let url = jQuery(this).data('url').replace(/https?\:\/\//ig, '');
        let http_flag = jQuery(this).data('http-flag');
        let id = jQuery(this).data('id');
        if(http_flag == 'y'){
            http_flag = 'https://';
        }
        else{
            http_flag = 'http://';
        }
        let data = thankyouList[id] !== undefined ? thankyouList[id] : [];

        jQuery("#thankyou-title").val(data.thank_you_title);
        jQuery("#thankyou_slug").val(data.thankyou_slug);
        jQuery(".slug_url").text(data.funnel_url+'/');
        jQuery("[name='submission_id']").val(id)
        let editor = lpHtmlEditor.getInstance();
        editor.html.set(data.thankyou);
        if(data.thankyou_logo == 1){
            $("#thankyou_logo").val(0);
            var advancehtml = editor.html.get();
            advancehtml = advancehtml.replace(/<img(.*?)id="defaultLogo"(.*?)>/, '');
            advancehtml = advancehtml.replace(/<p(.*?)id="defaultLogoContainer"(.*?)>(.*?)<\/p>/, '');
            advancehtml = advancehtml.replace(/<p>&nbsp;<\/p>/, '');
            advancehtml = advancehtml.replace(/<p style="text-align: center;"><br><\/p>/, '');
            // advancehtml = advancehtml.replace(/<p>(.*?)<\/p>/, '');
            editor.html.set(advancehtml);
           $('#typ_logo').bootstrapToggle("on");
        }else{
           $('#typ_logo').val(0);
            $('#typ_logo').bootstrapToggle("off");
        }
        let url_preview = data.funnel_url+"/thank-you.html?preview=1&hash="+data.hash;
        $('[data-preview]').attr('href',url_preview);
        $('[data-copy]').text(url_preview);

        let save_button_value = $('.save-third-party').is(":disabled");
        jQuery("#https_flag").val(http_flag).change();
        if(save_button_value == true)
        {
            $('.save-third-party').prop('disabled',true);
        }
        jQuery(".edit-thankyou").attr('href',href);
        jQuery("#thrd_url").val(url);

        jQuery("#fb-thank-you").modal("show");
        $(".lp-custom-para").show();
        if(data.thirdparty_active === 'y'){
            jQuery("#thirldparty").prop("checked",true).parents('.toggle').removeClass('btn-inactive off').addClass('btn-active');
            jQuery("#thankyou").prop("checked",false).parents('.toggle').removeClass('btn-active').addClass('btn-inactive off');
        }
        else{
            jQuery("#thankyou").prop("checked",true).parents('.toggle').removeClass('btn-inactive off').addClass('btn-active');
            jQuery("#thirldparty").prop("checked",false).parents('.toggle').removeClass('btn-active').addClass('btn-inactive off');
        }
        $(".thankyou-edit-page,.action__link_edit").css({
            display: "flex"
        });
        $(".third-party__panel, .thankyou-page-text-area, .action__link_cancel, .thankyou-page-cancel").hide();
    });

    $('#thankyou-title, #thankyou_slug, #thrd_url ').bind('change keyup input',function (e){
        $('.save-third-party').prop('disabled',false);
    });


    $('[data-toggle="toggle"]').click(function (e){
        $('.save-third-party').prop('disabled',false);
    });
    $('#https_flag').change(function (e){
        $('.save-third-party').prop('disabled',false);
    });


    $('#thankyou-title').on('keyup', function () {
        const text = $(this).val();
        const slug = text.toLowerCase()
            .replace(/ /g,'-')
            .replace(/[^\w-]+/g,'');
        $('#thankyou_slug').val(slug);
    });

    $('#fb-thank-you').on('hidden.bs.modal', function () {
        $('.save-third-party').prop("disabled", true);
    });

    $('#fb-thank-you').on('show.bs.modal', function () {
        $('.thank-you-modal-scroll').niceScroll({
            background: "#f0f3f4",
            cursorcolor: "#02abec",
            cursorwidth: "5px",
            autohidemode: true,
            railalign: "right",
            railvalign: "bottom",
            railpadding: {top: 0, right: 0, left: 0, bottom: 0}, // set padding for rail bar
            cursorborder: "1px solid #02abec",
            cursorborderradius: "5px"
        });
        $(".thank-you-modal-scroll").niceScroll().scrollstart(function(info){
            var select_button = $(".thank-you-modal-scroll").find('.fr-wrapper').offset();
            var block_height = $(".thank-you-modal-scroll").find('.fr-wrapper').height();
            var window_height = $('.thank-you-modal-scroll .modal-body-wrap').height();
            var select_dropdown = $('.fr-popup.fr-active').height();
            if(select_button !== undefined && !$('.funnel-thankyou-page-pannel').find('.fr-popup').hasClass('fr-active'))
            {
                // Add this code for hide the popup on scrolling to avoid the cutting of popup
                $('.fr-popup').removeClass('fr-active');
                $('.fr-image-resizer').removeClass('fr-active');
                $('.fr-video-resizer').removeClass('fr-active');
               /* var select_total = select_button.top + select_dropdown;
                lpUtilities.editorPopupPosition(window_height,select_total,select_dropdown,block_height,select_button);*/
            }
        })
    });
});
