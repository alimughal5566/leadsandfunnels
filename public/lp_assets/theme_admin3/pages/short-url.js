let deleteShortId = 0;
let that = 0;
let ajaxRequesting = 0;
let currentAlert = 0;
const sapp_base_url = site.shortenerAppBaseUrl + '/';
let funnelRecord = (funnelData)?JSON.parse(funnelData):'';
let hash = funnelRecord.current_hash;
let currentAlertMessage = 0;
let formData = {
    clients_leadpops_id: funnelRecord.client_leadpop_id,
    client_id: funnelRecord.client_id,
    leadpop_id: funnelRecord.leadpop_id,

    _token: ajax_token,
    current_hash: hash,
    slug: funnelRecord.funnel.lynxly_hash,
    old_slug: funnelRecord.funnel.lynxly_hash
};


$(document).ready(function () {


    //create short url
    $('#make_shorten_url').click(function (e) {
      //  console.log(JSON.stringify(funnelRecord));
        e.preventDefault();
        that = $(this);
        //reset subdomain value if change funnel not saved.
       resetSubDomain();
        if (!ajaxRequesting) {
            ajaxRequesting = 1;

            if (currentAlert)
                currentAlert.hide();

            var message = 'Short URL creation is in process...';
            var alertMsg = displayAlert('loading', message, 0);

            $.ajax({
                type: "POST",
                data: formData,
                cache: false,
                url: site.baseUrl + site.lpPath + "/url-shortener/createShortenUrl",
                success: function (rsp) {
                    alertMsg.hide();

                    $('#url_slug_val').val(rsp.result.slug_name);
                    $('#short_url_link').attr('href', rsp.short_url);
                    $('#shortLinkVal').val(rsp.short_url);
                    $('#shortLinkValDiv').html(rsp.short_url);
                    ajaxRequesting = 0;
                    formData.old_slug = rsp.result.slug_name;
                    shareURL = rsp.short_url;
                    jQuery(".funnel-url-copy").removeClass('d-none');
                    if(typeof socialLinkRender ===  "function") {
                        socialLinkRender();
                    }
                    var $viewPopupWrap = $('.view-popup-wrap');
                    var $shortLinkWrap = $viewPopupWrap.find('.view-short-url-wrap');
                    $shortLinkWrap.addClass('view-has-short-url');
                    var shortLink = site.shortenerAppBaseUrl + '/' + rsp.result.slug_name;
                    $shortLinkWrap.find('a').attr('href', shortLink);
                    $shortLinkWrap.find('.view-popup__url').html(`
                                ${shortLink} <span class="copy-text">${shortLink}</span>
                            `);
                    lpUtilities.viewhoverblock();

                    updateEditFormDataObj();

                    adjustToggle(that);
                    currentAlert = displayAlert('success', 'Short URL has been created.');
                },
                statusCode: {
                    500: function () {
                        alertMsg.hide();
                        displayAlert('danger', 'Something went wrong, please try again.');
                    }
                },
                always: function (d) {
                    setTimeout(() => {
                        alertMsg.hide();
                        ajaxRequesting = 0;
                    }, 2000);
                }
            });
        }


    });

      //edit short url
    jQuery('body').on( "click", ".lp-controls__edit", function(e) {
        e.preventDefault();
        var currVal = jQuery(this).parents('.url-expand').find('input.form-control').val();
        jQuery(this).parents('.url-expand').find('input.form-control').removeAttr('readonly').focus().val('');
        jQuery(this).parents('.url-expand').find('input.form-control').val(currVal);
        var _self = jQuery(this);
        _self.parents('.url-expand').find('input.form-control').select();
    });

    //delete
    $('#remove_short_url').click(function (e) {
        e.preventDefault();
        that = $(this);
        $('#deleteSlugName').modal('show');
    });


    $(document).on('click', '#doCanelEdit', function (event) {
        $('#url_slug_val').val(formData.old_slug).prop('readonly', true);
        updateEditFormDataObj();
    });

    $(document).on('click', '#doDeletePopUpBtn', function (event) {

        $('#doDeletePopUpBtn').prop('disabled', true);
        //reset subdomain value if change funnel not saved.
        resetSubDomain();
        $.ajax({
            type: "POST",
            data: formData,
            cache: false,
            url: site.baseUrl + site.lpPath + "/url-shortener/removeShortenUrl",
            success: function (rsp) {
                currentAlert = displayAlert('success', 'Short URL has been deleted.');
                $('#deleteSlugName').modal('hide');
                adjustToggle(that);
                jQuery(".funnel-url-copy").addClass('d-none');
                $('.view-short-url-wrap').removeClass('view-has-short-url');
                setTimeout(function () {
                    $('#doDeletePopUpBtn').prop('disabled', false);
                }, 2000);
                shareURL = jQuery("#funnelUrl .copy-text").text();
                if(typeof socialLinkRender ===  "function") {
                    socialLinkRender();
                }
                lpUtilities.viewhoverblock();

            },
            error: function (e) {

            },
            always: function (d) {
            }
        });

        setTimeout(function () {
            $('#doDeletePopUpBtn').prop('disabled', false);
        }, 7000)

    });
    //delete END

    // EDIT
    $(document).on('change', '#url_slug_val', function (event) {
        updateEditFormDataObj();
    });

    $(document).on('keyup', '#url_slug_val', function (event) {
        if (event.keyCode === 13) {
            $('#doEditPopUpBtn').trigger('click');
        }
    });

    $(document).on('click', '#doEditPopUpBtn', function (e) {

        if (currentAlert)
            currentAlert.hide();

        if (formData.slug === "" || formData.slug.length < 2) {

            currentAlert = displayAlert("danger", 'Slug name must be at least 2 characters long.');
            return false;
        }

        if (formData.slug.length > 50) {
            currentAlert = displayAlert("danger", 'Slug name must be at most 50 characters long.');

            return false;
        }

        if (formData.slug === formData.old_slug) {
            if (currentAlert)
                currentAlert.hide();

            jQuery(this).parents('.shortUrl').removeClass('active');
            jQuery('.form-url-text').prop('readonly', true);
            return false;
        }

        var message = 'Short URL update is in process...';
        currentAlert = displayAlert('loading', message, 0);

        jQuery('.form-url-text').prop('readonly', true);
        jQuery(this).parents('.shortUrl').removeClass('active');
        $.ajax({
            type: "POST",
            data: formData,
            cache: false,
            url: site.baseUrl + site.lpPath + "/url-shortener/editShortenUrl",
            success: function (rsp) {
                $('#short_url_link').attr('href', sapp_base_url + formData.slug);
                $('#shortLinkVal').val(sapp_base_url + formData.slug);
                $('#shortLinkValDiv').html(sapp_base_url + formData.slug);
                shareURL = sapp_base_url + formData.slug;
                if(typeof socialLinkRender ===  "function") {
                    socialLinkRender();
                }
                var $viewPopupWrap = $('.view-popup-wrap');
                var $shortLinkWrap = $viewPopupWrap.find('.view-short-url-wrap');
                $viewPopupWrap.addClass('view-has-short-url');
                var shortLink = site.shortenerAppBaseUrl + '/' + $('#url_slug_val').val();
                $shortLinkWrap.find('a').attr('href', shortLink);
                $shortLinkWrap.find('.view-popup__url').html(`
                        ${shortLink} <span class="copy-text">${shortLink}</span>
                    `);

                currentAlert.hide();
                formData.old_slug = formData.slug;
                currentAlert = displayAlert('success', 'Short URL has been updated.');
            },
            statusCode: {
                406: function (err) {
                    currentAlert.hide();
                    currentAlert = displayAlert('danger', 'Sorry! That Short URL is already in use. Please try something else.');
                    $('#url_slug_val').val(formData.old_slug);
                    updateEditFormDataObj();
                },
                500: function (err) {
                    currentAlert.hide();
                    currentAlert =        displayAlert('danger', 'Sorry! something went wrong, please try again.');

                    $('#url_slug_val').val(formData.old_slug);
                    updateEditFormDataObj();
                }

            },
            error: function (e) {

            },
            always: function (d) {
            }
        });


    });
    // EDIT END

    // if (formData.old_slug && funnelRecord.funnel.leadpop_type_id === 1) {
    if (lynxly_data && funnelRecord.funnel.leadpop_type_id === 1) {
        var that = $('#make_shorten_url');
        adjustToggle(that);
    }

    $('#deleteSlugName').modal({
        show: false,
        backdrop: 'static',
        keyboard: true
    });
});


function adjustToggle(that) {
    jQuery(that).parents('.lp-panel__body').find('.funnel_url .input-holder').toggleClass('disable');
    jQuery(that).parents('.lp-panel__body').find('.funnel_url').toggleClass('hide-btns');
    jQuery(that).parents('.lp-panel__body').find('.url-expand').slideToggle();
    jQuery(that).parents('.lp-panel__body').find(".funnel-url-copy").removeClass('d-none');

}


function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
}

function updateEditFormDataObj() {
    var new_slug = $('#url_slug_val').val();
    new_slug = new_slug.toLowerCase().trim();
    new_slug = slugify(new_slug);
    $('#url_slug_val').val(new_slug);
    formData.slug = new_slug;
}



function copyToClipboardDiv(element, self) {

    var myStr = $(element).text();
    var trimStr = $.trim(myStr);
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(trimStr).select();
    document.execCommand("copy");
    $temp.remove();
    setTimeout(() => {
        $(self).attr('disabled', false);
        if(currentAlertMessage)
            currentAlertMessage.hide();
        if (element == '#shortLinkValDiv') {
            currentAlertMessage = displayAlert('success', 'Short Funnel URL has been copied to the clipboard.');
        } else {
            currentAlertMessage = displayAlert('success', 'Full Funnel URL has been copied to clipboard.');
        }
    },1200);
}

function resetSubDomain(){
    var domain_name =  $("#hdomain_name").val();
    if(typeof domain_name !== "undefined") {
        var top_level = $("#htop_level").val();
        $("#subdomainname").val(domain_name);
        $(".url__text").html('https://' + domain_name + '.' + top_level);
        $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
        $(".domain-card .funnel-url-copy .lp-controls__link").css({'pointer-events':'all'});
    }
}
