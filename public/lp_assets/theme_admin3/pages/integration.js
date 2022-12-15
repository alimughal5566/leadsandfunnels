let global = {
    ids: [],
    folders: [],
    integrations: [],
    processing:false,
    reset:false,
};

function  _openZapierModal() {
    var amIclosing = false;
    $("#funnel-search-by-zapier")
        .select2({
            minimumResultsForSearch: -1,
            dropdownParent: $("#funnel-search-by-zapier-parent"),
            width: "100%"
        })
        .on("change", function() {
            resetFilters($(this).val());
        }).on('select2:openning', function() {
        jQuery('#funnel-search-by-zapier-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('#funnel-search-by-zapier-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('#funnel-search-by-zapier-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('#funnel-search-by-zapier-parent .select2-dropdown').hide();
        jQuery('#funnel-search-by-zapier-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('#funnel-search-by-zapier-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('#funnel-search-by-zapier-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#funnel-search-by-zapier').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('#funnel-search-by-zapier-parent .select2-selection__rendered').show();
        jQuery('#funnel-search-by-zapier-parent .select2-results__options').css('pointer-events', 'none');
    });
    //commented from @mzac90
    //resetFilters('n');
}
function setFunneFolderListSelection(element) {
    if ($(element).is(":checked")) {
        $("#zapier_funnelsExample input:checkbox").prop("checked", true).trigger('change');
    } else {
        $("#zapier_funnelsExample input:checkbox").prop("checked", false).trigger('change');
    }
}

function resetFilters(value, resetAll) {
    setTimeout(function() {
        if(resetAll){
            global.integrations = (global.reset)?[]:$("#zapier_integrations").val().split(",");
        }
        $("#searchInput").val("");
        $("#funnel-search-by-zapier").val(value)//.trigger("change.select2");
        $("#tag_list-pop-zapier").val([])//.trigger("change.select2");
        // $("#zapier-funnel-tag-parent .select2-selection__choice").remove();
        $(
            "#zapier-funnel-tag-parent .select2-container .select2-search--inline .select2-search__field"
        ).attr("placeholder", "Type in Funnel Tag(s)...");
        //

        if (value == "n") {
            $("#search-funnel-by-tag").hide();
            $("#search-funnel-by-name").show();
        } else {
            $("#search-funnel-by-name").hide();
            $("#search-funnel-by-tag").show();
        }
        // if(clearIntegration){
        //     global.integrations = [];
        //     global.reset = false;
        // }
        funnelChecked();
    });
}

function popupCenter (url, title, w, h) {
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


/**
* Sets passed param and its value in the current URL
* @param key
* @param value
*/

function updateURLParams(key, value, clear = false){

    var currentUrl = window.location.href;
    var url;
    if(clear){
        var params = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        let index = params.findIndex((param)=>{
            return param ==key+'='+value;
        });
        if(index!=-1){
            params.splice(index, 1);
        }
        let paramString = params.join('&');
        if(paramString.length){
            paramString = "?"+paramString;
        }
        currentUrl = window.location.href.split('?')[0]+paramString;
        url = new URL(currentUrl);
    }else{
        url = new URL(currentUrl);
        url.searchParams.set(key, value);
    }

    var newurl = url.href;
    if (history.pushState) {
        window.history.pushState({path:newurl},'',newurl);
    }else{
        window.location.replace(newurl);
}

}
function getParamObjects(){
    var params = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    var paramObjs = {};
    params.forEach(function(param){
        let paramVal = param.split('=');
        paramObjs[`${paramVal[0]}`] = paramVal[1];
    })

    return paramObjs;
}

(function (){

    if(window.opener){
        // we are in popup window
        // send parent window message to load itself
        window.opener.postMessage('lp:admin:refreshIntegrationPage', '*');
        // close popup
        window.close();
    }

    window.addEventListener('message', function(event){
        // we are in parent window
        if(event.data == 'lp:admin:refreshIntegrationPage'){
            // refresh window if integration is completed
            updateURLParams("te_success", 1);

            window.location.reload()
        }
    })
})();

$(document).ready(function() {
    let params = getParamObjects();
    if(params['te_success']){
        displayAlert('success', 'Total Expert integration has been completed.');
        updateURLParams('te_success', 1, true);
    }
    //integrations-funnel page
    var rec = jQuery.parseJSON(funnel_json);
    var folderList = jQuery.parseJSON(folder_list);
    window.rec = rec;
    window.funnels = rec;
    global.integrations = ($("#zapier_integrations").val() || '').split(",");

    /* function to show animation when copy to clipboard event is called */
    jQuery('#lp_auth_access_code_copy').click(function (){
        var _self = jQuery(this);
        _self.parents().find('.modal-body .api-key-field-holder.copy-btn-area').addClass('active');
        setTimeout(function () {
            _self.parents().find('.modal-body .api-key-field-holder.copy-btn-area').removeClass('active');
        }, 1000);
    });

    IntegrationModule.init();

    // $(".integration__box").click(function() {
    //     $(".integration__box").removeClass("integration__box_active");
    //     $(this).addClass("integration__box_active");
    // });

    $("#velocify_form").validate({
        rules: {
            api_key: {
                required: true
            }
        },
        messages: {
            api_key: {
                required: "This field is required."
            }
        },
        debug: true,
        submitHandler: function() {
            console.info("submitted");
        }
    });

    $("#bntouch_form").validate({
        rules: {
            user_name: {
                required: true
            },
            password: {
                required: true,
                minlength: 5
            },
            sec_token: {
                required: true
            }
        },
        messages: {
            user_name: {
                required: "Please enter your first name."
            },
            password: {
                required: "Please enter your password.",
                minlength: "Please enter at least 5 characters."
            },
            sec_token: {
                required: "Please enter your security token."
            }
        },
        debug: true,
        submitHandler: function() {
            console.info("submitted");
        }
    });

    $("#mortech_form").validate({
        rules: {
            user_name: {
                required: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            user_name: {
                required: "Please enter your first name."
            },
            password: {
                required: "Please enter your password.",
                minlength: "Please enter at least 5 characters."
            }
        },
        debug: true,
        submitHandler: function() {
            console.info("submitted");
        }
    });

    function goHomebotOuath2() {
        console.log($("#homebotactivate").attr("href"));
        $("#homebotactivate")
            .get(0)
            .click();
    }

    $("#homebotactivedeactivebtn").on("click", function() {
        var homebot_activated = $("#integration_activated").val();
        var client_id = $("#client_id").val();

        if (homebot_activated == "no") {
            goHomebotOuath2();
        } else {
            $.ajax({
                type: "POST",
                url: site.baseUrl + site.lpPath + "/popadmin/homebotdelete",
                data: "client_id=" + client_id + "&_token=" + ajax_token,
                success: function(d) {
                    window.location.reload(true);
                }
            });
        }
    });

    function goOuath2() {
        console.log($("#teactivate").attr("href"));
        $("#teactivate")
            .get(0)
            .click();
    }

    $("#activedeactivebtn").on("click", function() {
        var te_activated = $("#integration_activated").val();
        var client_id = $("#client_id").val();
        if (te_activated == "no") {
            goOuath2();
        } else {
            $.ajax({
                type: "POST",
                url: site.baseUrl + site.lpPath + "/popadmin/totalexpertdelete",
                data: "client_id=" + client_id + "&_token=" + ajax_token,
                success: function(d) {
                    window.location.reload(true);
                }
            });
        }
    });
    $("#search").keyup(function() {
        var search = $(this).val();
        if (search != "") {
            $('div[class="item"]').hide();
            $('input[data-value *="' + search + '"]')
                .parent()
                .show();
        } else {
            $('div[class="item"]').show();
        }
    });
    $("#reset-filter").click(function() {
        //from @mzac90
        //when trigger the reset then reset saved the checkbox
        global.reset = false;
        global.integrations = [];
        resetFilters('n',true);
        // global.integrations = [];//$("#zapier_integrations").val().split(",");
        //$("#funnel-selector input[type=checkbox]").prop("checked", false);
    });
    $("#integration-all-funnel-checkbox").change(function() {
        setFunneFolderListSelection(this);
    });

    $(document).on("change", ".sub-group", function() {
        var group = $(this).data("key");
        if ($(this).is(":checked")) {
            $("#funnel-selector li.active input[type=checkbox]").each( function( index, el ) {
                if ($(el).hasClass(group)) {
                    $(el).prop("checked", true).trigger('change');
                }
            });
        } else {
            $("#funnel-selector input[type=checkbox]").each(function( index, el ) {
                if ($(el).hasClass(group)) {
                    $(el).prop("checked", false).trigger('change');
                }
            });
        }
    });
    $(document).on('keydown', '#searchInput', function (event) {
        //   debugger;
        if (event.keyCode == 13) {
            // alert('enter')
            zapierFunnelFilter();
        }
    });
    $.fn.integrationFunnelLoader = function() {
        let html = "";
        $(folderList).each(function(index, value) {
            var folder = value["folder_name"]
                .replaceAll(" ", "-")
                .toLowerCase();
            var folderid = value["folder_name"]
                .replaceAll(" ", "")
                .toLowerCase();

            let funnelCount = funnels.filter(funnel => {
                return funnel["leadpop_folder_id"] == value["id"];
            }).length;

            if(funnelCount) {
                let folder_id = `${folderid}funnel`;
                let collapse_div_id = `collapse${index}`;

                // console.log(funnel['leadpop_folder_id'], value['id']);
                html += ` <div class="funnels">
                                <div class="funnels__header" id="heading${index}">
                                    <div class="checkbox">
                                    <input type="checkbox" class="sub-group" onchange="folderChanged('${folder_id}', '${collapse_div_id}')" id="${folder_id}" name="${folder}" data-key="${folder}" value="">
                                    <label class="funnel-label" for="${folder_id}"></label>
                                    </div>
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#${collapse_div_id}" aria-expanded="true" aria-controls="collapseOne">${value["folder_name"]}</button>
                                    <span class="funnel-no-text">Funnels Selected: <span class="no" id="selected_funnels_${collapse_div_id}"></span></span>
                                </div>
                                <div id="${collapse_div_id}" class="collapse integration-slide" aria-labelledby="headingMortgage"
                                 data-parent="#zapier_funnelsExample">
                                    <div class="card-body">
                                        <div class="funnel-list-wrap">
                                            <div class="scroll-holder">
                                                <ul class="funnel__list">`;
                var disable_is_lite_class = (subvertical = "");
                $(funnels).each(function (key, funnel) {
                    if (window.is_lite_package == "1") {
                        if (
                            window.lite_funnels.indexOf(
                                funnel["leadpop_vertical_sub_id"]
                            ) != -1 &&
                            funnel["leadpop_version_seq"] == 1
                        ) {
                            disable_is_lite_class = "active";
                        } else {
                            disable_is_lite_class = "disable_lite_package";
                        }
                    } else {
                        disable_is_lite_class = "active";
                    }
                    if (funnel["leadpop_folder_id"] === value["id"]) {
                        var fkey =
                            funnel["leadpop_vertical_id"] +
                            "~" +
                            funnel["leadpop_vertical_sub_id"] +
                            "~" +
                            funnel["leadpop_id"] +
                            "~" +
                            funnel["leadpop_version_seq"];
                        var zkey =
                            funnel["leadpop_id"] +
                            "~" +
                            funnel["leadpop_vertical_id"] +
                            "~" +
                            funnel["leadpop_vertical_sub_id"] +
                            "~" +
                            funnel["leadpop_template_id"] +
                            "~" +
                            funnel["leadpop_version_id"] +
                            "~" +
                            funnel["leadpop_version_seq"] +
                            "~" +
                            funnel["domain_name"].toLowerCase();

                        var filed_ref = "z_wfunnel" + funnel["client_leadpop_id"];
                        var domain_name = funnel["domain_name"].toLowerCase();
                        var domain_id = funnel["domain_id"];
                        if (subvertical != funnel["lead_pop_vertical_sub"]) {
                            subvertical = funnel["display_label"]
                                .replace(" ", "-")
                                .toLowerCase();
                        }
                        var funnel_market =
                            (funnel["funnel_market"] == "w" ? "website " : "") +
                            funnel["funnel_market"] +
                            "_" +
                            subvertical;
                        var tags = getFunnelTag(funnel);
                        setParentsInfo(`${folder_id}`, `${collapse_div_id}`);
                        html += `<li class="funnel__item ${disable_is_lite_class}">
                                                        <div>
                                                            <div class="checkbox">
                                                             <input type="checkbox" id="${filed_ref}"
                                                             onchange="selectionChanged('${folder_id}', '${collapse_div_id}', '${zkey}', event )"
                                                             name="domains[]"
                                                             class="${folder +
                        " " +
                        subvertical +
                        " domain_" +
                        domain_id +
                        " " +
                        funnel_market}"
                                                             value="${domain_id}"
                                                             data-value="${domain_name}"
                                                             data-fkey="${fkey}"
                                                             data-zkey="${zkey}"
                                                             data-domainid="${domain_id}">
                                                                <label class="funnel-label el-tooltip" title="${funnel["funnel_name"]}" for="${filed_ref}">
                                                                    ${
                            funnel[
                                "funnel_name"
                                ]
                            }
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                        <div class="inte-modal-tags-holder">
                                                          <div class="inte-modal-tags-wrap">
                                                            <div class="inte-modal-tags-holder-wrap">
                                                                <ul class="tags-list">
                                                                      ${tags}
                                                                </ul>
                                                                </div>
                                                                <span class="inte-modal-more"><span class="inte-modal-more-tags">...</span></span>
                                                                  <div class="inte-modal-tags-popup-wrap">
                                                                    <div class="inte-modal-tags-popup">
                                                                    <ul class="tags-list">
                                                                      ${tags}
                                                                </ul> </div>
                                                                </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                    </li>`;
                    }
                });
                html += `
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            }

        });

        // $('#zapier_funnelsExample input[data-fkey="' + funnel.fkey + '"]').each(function (index, el) {
        //     $(this).prop('checked', true)
        // });
        $("#zapier_funnelsExample").html(html);
        intemodalTagPopup();
        initScroll();
        //selected funnel checkbox checked
        funnelChecked();

        /*$(".scroll-holder").mCustomScrollbar({});*/
        $('.scroll-holder').mCustomScrollbar({
            scrollInertia: 0,
            live: true,
            callbacks:{
                onScroll:function(){
                    jQuery('.inte-modal-tags-popup-wrap').fadeOut();
                }
            }
        });
    };

    $('#homebotactivate, #teactivate').click(function (e){
        e.preventDefault();
        var link = $(this).attr('href');
        var id = $(this).attr('id');
        // 800 and 500 are just convenient width and height for these integrations
        popupCenter(link, id, IntegrationModule.popupWidth, IntegrationModule.popupHeight);
    });
    $("#zapier_funnelsExample").integrationFunnelLoader();

    //code by @mzac90
    $(document).on('click','.funnels__header', function(){
            //if tags width size greater than 500 then extra tags list hide
        //each loop work for first time expand the row
        if(!jQuery(this).hasClass('tags-opened')) {
            jQuery(this).next().find('.inte-modal-tags-holder-wrap').each(function () {
                var inte_tags_holder = jQuery(this).parents('.inte-modal-tags-holder');
                var temp_width = 45;
                var index = 0;
                var room = 500;
                jQuery(this).find('li').show().each(function () {
                    temp_width = temp_width + jQuery(this).outerWidth();
                    if (temp_width < room) {
                        index++;
                    }
                });
                jQuery(this).find('li:gt(' + (index - 1) + ')').hide();
                inte_tags_holder.find('.inte-modal-more').show();
                if (temp_width <= room) {
                    inte_tags_holder.find('.inte-modal-more').hide();
                }
            });
        }
        jQuery(this).addClass('tags-opened');
    });

    $('.authenticate__desc .link').click(function (e){
        e.preventDefault()
        var link = $(this).attr('href')
        popupCenter(link, link, IntegrationModule.popupWidth, IntegrationModule.popupHeight );
    });


    /* ** ** ** ** INTEGRATIONS - Start ** ** ** ** */
    $("#zapierKeyBtn").click(function(e){
        e.preventDefault();
        $("#zapier_access_key").val('Please wait... Generating authorization key...');
        createZapierKey();
    });

    $("#lp_auth_access_btn").click(function(e){
        e.preventDefault();
        $("#lp_auth_access_key").val('Please wait... Generating authorization key...');
        createAuthKey();
    });
    $('#lp_auth_access_code_copy').click(function(e){
        e.preventDefault();
        if(copy_key == 1) {
            copy_key = 2;
            copyContentToClipboard($('#lp_auth_access_key'));
            displayAlert('success', 'leadPops Authorization Key has been copied to the clipboard.');
            setTimeout(function(){
                copy_key = 1;
            },3000);
        }
    });

    $('#zapierKeyBtn_copy').click(function(e){
        e.preventDefault();
        if(copy_key == 1) {
            copy_key = 2;
            copyContentToClipboard($('#zapier_access_key'));
            displayAlert('success', 'leadPops Authorization Key has been copied to the clipboard.');
            setTimeout(function(){
                copy_key = 1;
            },3000);
        }
    });


    $('#funnel-selector').on('show.bs.modal', function () {
        $('#funnel-selector').attr("data-action", "on");
    });

    $('#funnel-selector').on('hidden.bs.modal', function () {
        if( $("#funnel-selector").hasClass("zapier-selector") ){
            $("#funnel-selector").removeClass("zapier-selector");
            resetZapierFunnelPopup();
        } else {
            if($('#funnel-selector').attr("data-action") == "on"){
                $('#funnel-selector').attr("data-action", "off");
            }
        }
    });

    /* ** ** ** ** INTEGRATIONS - End ** ** ** ** */

});
function folderChanged( inputId , collapseDivId) {
    checkMain();


}
function setParentsInfo ( parentInput , parentDiv ) {
    if ( !global.folders.find(parent => {parent.parentInput == parentInput && parent.parentDiv == parentDiv;}) ) {
        global.folders.push({ parentInput: parentInput, parentDiv: parentDiv });
    }
}
function selectionChanged ( parentInput, parentDiv, key, event ) {
    checkParent(parentInput, parentDiv);
    IntegrationModule.onChangeZapierSelectionHandleButton();
}

function checkMain(){

    $('#zapier_all_selected').html($(`#zapier_funnelsExample input[type=checkbox]:checked`).not('.sub-group').length);
    if( $(`#zapier_funnelsExample input[type=checkbox]`).length == $(`#zapier_funnelsExample input[type=checkbox]:checked`).length ){
        $('#integration-all-funnel-checkbox').prop("checked", true);
    }else{
        $('#integration-all-funnel-checkbox').prop("checked", false);
    }
}
function checkParent ( parentInput, parentDiv ) {
    $("#selected_funnels_"+parentDiv).html($(`#${parentDiv} input[type=checkbox]:checked`).length);
    if ( $(`#${parentDiv} input[type=checkbox]`).length != 0 && $(`#${parentDiv} input[type=checkbox]`).length == $(`#${parentDiv} input[type=checkbox]:checked`).length ) {
        $("#" + parentInput).prop("checked", true);
    } else {
        $("#" + parentInput).prop("checked", false);
    }
    checkMain();

}
function changed(event) {
    console.log(event);
}
/**
 * this function are using for zapier funnel filter
 */
function zapierFunnelFilter() {
    var data = [];
    var search = $(".zapier-funnel-name-search").val()? $.trim( $(".zapier-funnel-name-search").val().toLowerCase()) : "";
    var tag_search = $(".zapier-funnel-tag").val();
    /**
     *funnel name search is not empty and  search type == Search by Funnel Name
     * then matching funnel will be show with selected funnel name
     *
     */
    if (search != "" && $("#funnel-search-by-zapier").val() == "n") {
        data = jQuery.grep(rec, function(el, i) {
            if (el.funnel_name) {
                return ( strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1);
            }
        });
    } else if (tag_search != "" && $("#funnel-search-by-zapier").val() == "t") {
        /**
         *tag search is not empty then funnel will be show
         */
        data = jQuery.grep(rec, function(el, i) {
            if (el.client_tag_name) {
                var t = el.client_tag_name.split(",");
                if (containsAll(tag_search, t)) {
                    return el;
                }
            }
        });
    } else {
        data = rec;
    }
    window.funnels = data;
    $("#zapier_funnelsExample").integrationFunnelLoader();
}

function intemodalTagPopup(){
    jQuery('.inte-modal-more-tags').click(function(){
        var _self = jQuery(this);
        /*  var html = _self.parents('.inte-modal-tags-wrap').find('.inte-modal-tags-holder-wrap .tags-list').clone();
          _self.parents('.funnel__item').find('.inte-modal-tags-popup').html(html);*/
        var popup = _self.parents('.funnel__item').find('.inte-modal-tags-popup-wrap');
        $('.inte-modal-tags-holder').find('.inte-modal-tags-popup-wrap').hide();
        popup.fadeToggle(500);
        var popupHeight = popup.outerHeight();
        var modalTop = 30;
        var tagsOffsetTop = _self.offset().top;
        console.log(tagsOffsetTop);
        var popupOffset = tagsOffsetTop - modalTop - popupHeight;
        jQuery(".inte-modal-tags-popup").removeClass('top-position');
        if(tagsOffsetTop  < 300){
            popupOffset = tagsOffsetTop;
            _self.parents('.funnel__item').find(".inte-modal-tags-popup").addClass('top-position');
        }
        popup.css('top', popupOffset + 'px');
        _self.parents('.inte-modal-tags-holder').toggleClass('inte-modal-seetings-tags');
    });
}

/**
 * mcsutomscrollbar init in show all tags popup
 */
function initScroll(){
    $('.inte-modal-tags-popup').mCustomScrollbar({
        mouseWheel:{ scrollAmount: 80}
    });
}


var IntegrationModule = {
    activeOnAccount : false,
    activeOnFunnel : false,
    type: false,
    updateType: $("#update_type"),
    popupWidth:  500,
    popupHeight:  500,
    integrations:{'homebot':"Homebot", 'total-expert':"Total Expert"},

    init: function () {
        this.type = $("#type").val();
        this.activeOnAccount = $("#active_on_account").val();
        this.activeOnFunnel = $("#active_on_funnel").val();
        this.initSwitchHandlers();
        let $self = this;

        if(this.type == "zapier") {
            console.log(this.type + " + binding events");
            ajaxRequestHandler.init('#createauthkey', {
                autoEnableDisableButton: false,
                submitButton:"#zapier_save_integrations"
            });
            ajaxRequestHandler.changeSubmitButtonStatus(true);

            $("#zapier_save_integrations").click(function(e) {
                e.preventDefault();
                IntegrationModule.updateZapierIntegration();
            });
        } else if(["homebot", "total-expert"].indexOf(this.type) !== -1) {
            console.log(this.type + " + binding events");
            ajaxRequestHandler.init('#createauthkey');

            $("#main-submit").click(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                IntegrationModule.setUpdateType();
                // if(jQuery.inArray(IntegrationModule.updateType.val(), ["account", "funnel", "both"]) !== -1) {
                IntegrationModule.updateIntegration();
                // } else {
                //     displayAlert('warning', "Please do changes to submit request.");
                // }
            });
        }
    },
    initSwitchHandlers(){
        $('.integration-toggle').change(function() {
            if ($(this).prop('checked') == true) {
                $('#'+$(this).data('field')).val($(this).data('onstyle')).trigger('change');
            }else {
                $('#'+$(this).data('field')).val($(this).data('offstyle')).trigger('change');
            }
        });

        $( "body" ).on( "change",".funnel-switch" , function() {
            if($(this).is(":checked")){ // $("#account-switch").is(":checked") &&
                $('.authenticate__placeholder').slideDown();
                $('.authenticate__panel').slideUp();
            }else {
                $('.authenticate__placeholder').slideUp();
                $('.authenticate__panel').slideDown();
            }
        });
    },

    setUpdateType: function () {
        let active_on_account = $("#active_on_account").val();
        let active_on_funnel = $("#active_on_funnel").val();

        IntegrationModule.updateType.val("");
        if(IntegrationModule.activeOnAccount !== active_on_account && IntegrationModule.activeOnFunnel !== active_on_funnel) {
            IntegrationModule.updateType.val("both");
        } else if(IntegrationModule.activeOnAccount !== active_on_account) {
            IntegrationModule.updateType.val("account");
        }else if(IntegrationModule.activeOnFunnel !== active_on_funnel) {
            IntegrationModule.updateType.val("funnel");
        }
        console.log("Integration", IntegrationModule.type, IntegrationModule.activeOnAccount, IntegrationModule.activeOnFunnel);

    },

    updateIntegration: function () {
        let active_on_account = $("#active_on_account").val(),
            active_on_funnel = $("#active_on_funnel").val(),
            update_type = $("#update_type").val();

        if(update_type == "funnel" && active_on_account != "active") {
            displayAlert('warning', "Please activate account-level integration to enable/disable integration on funnel.");
            return;
        }

        let url = "/lp/popadmin/" + IntegrationModule.type + "/update",
            iType = IntegrationModule.integrations[IntegrationModule.type];

        ajaxRequestHandler.sendRequest(url ,function (response, isError) {
            console.log(iType + " submit callback...");
            if (response.status == true || response.status == "true") {
                // displayAlert("success", iType + " changes has been saved.");

                //if account level toggle changed than update funnel status too
                if(update_type == "account" || update_type == "both") {
                    ajaxRequestHandler.originalFormValues['active_on_funnel'].value = active_on_account;
                    $("#active_on_funnel").val(active_on_account);
                }

                IntegrationModule.activeOnAccount = active_on_account;
                IntegrationModule.activeOnFunnel = $("#active_on_funnel").val();

                if(IntegrationModule.activeOnFunnel == "active"){
                    $(".funnel-switch").prop("checked", true).trigger('change');
                }else {
                    $(".funnel-switch").prop("checked", false).trigger('change');
                }
            }
        });
        // global.processing = true;
        // let {hide} = displayAlert("loading", "Processing your request...");
        // let data = $("#createauthkey").serialize();
        //
        // $.ajax({
        //     type: "POST",
        //     url: "/lp/popadmin/" + IntegrationModule.type + "/update",
        //     data: data,
        //     success: function(rsp) {
        //         hide();
        //         global.processing = false;
        //         if(rsp.status) {
        //             displayAlert("success", iType + " changes has been saved.");
        //
        //             //if account level toggle changed than update funnel status too
        //             if(update_type == "account" || update_type == "both") {
        //                 $("#active_on_funnel").val(active_on_account);
        //             }
        //
        //             IntegrationModule.activeOnAccount = active_on_account;
        //             IntegrationModule.activeOnFunnel = $("#active_on_funnel").val();
        //
        //             if(IntegrationModule.activeOnFunnel == "active"){
        //                 $(".funnel-switch").prop("checked", true).trigger('change');
        //             }else {
        //                 $(".funnel-switch").prop("checked", false).trigger('change');
        //             }
        //             console.log("Integration", IntegrationModule.type, IntegrationModule.activeOnAccount, IntegrationModule.activeOnFunnel);
        //         } else {
        //             setTimeout(function(){
        //                 let message = 'Something went wrong. Please try again.';
        //                 displayAlert('danger', message );
        //             });
        //         }
        //     },
        //     error:function(){
        //         hide();
        //         global.processing = false;
        //         setTimeout(function(){
        //             let message = 'Something went wrong. Please try again.';
        //             displayAlert('danger', message );
        //         });
        //     },
        //     cache: false,
        //     async: true
        // });
    },
    updateZapierIntegration: function () {
        let _values = this.getCurrentZapierSelectedFunnels();

        if (_values.length < 1) {
            $("#selectedfunnel").val("");
            displayAlert("danger", "Please select at least one Funnel.");
            $("#zapier_save_integrations").removeAttr("disabled");
            // $('#funnle_selector-lp-alert').modal('show');
            return;
        }

        let url = "/lp/popadmin/savezapierfunnels",
            data = "funnels=" + _values +
                "&existing_funnels=" + $("#zapier_integrations").val() +
                "&current_hash=" + $("#current_hash").val();
        ajaxRequestHandler.sendRequest(url ,function (response, isError) {
            console.log("Zapier submit callback...");
            if (response.status) {
                $("#funnel-selector").modal("hide");
                $("#zapier_integrations").val(_values);
                global.integrations = $("#zapier_integrations").val();
                $("#searchInput").val("");
                $("#funnel-search-by-zapier").val('n');
                $("#tag_list-pop-zapier").val([]);
            }
        }, data);

        // if(global.processing == false){
        //     var existing_integrations = $("#zapier_integrations").val();
        //     var current_hash = $("#current_hash").val();
        //     // setTimeout(function() {
        //     global.processing = true;
        //     let {hide} = displayAlert("loading", "Processing your request...");
        //
        //     $.ajax({
        //         type: "POST",
        //         url: "/lp/popadmin/savezapierfunnels",
        //         data:
        //             "funnels=" +
        //             _values +
        //             "&existing_funnels=" +
        //             existing_integrations +
        //             "&current_hash="+current_hash+
        //             "&_token=" +
        //             ajax_token,
        //         success: function(rsp) {
        //             hide();
        //             global.processing = false;
        //             $("#funnel-selector").modal("hide");
        //             $("#zapier_integrations").val(_values);
        //             global.integrations = $("#zapier_integrations").val();
        //             displayAlert("success", "Zapier selected funnel has been saved.");
        //             $("#searchInput").val("");
        //             $("#funnel-search-by-zapier").val('n')
        //             $("#tag_list-pop-zapier").val([])
        //         },
        //         error:function(){
        //             hide();
        //             global.processing = false;
        //             setTimeout(function(){
        //                 let message = 'Something went wrong. Please try again.';
        //                 displayAlert('danger', message );
        //             });
        //         },
        //         cache: false,
        //         async: true
        //     });
        //     // }, 1000);
        // }
    },

    getCurrentZapierSelectedFunnels: function(){
        let _values = [];
        $("#funnel-selector input[type=checkbox]:checked").each( function( index,el ) {
            if ($(el).attr("data-zkey"))
                _values.push($(el).attr("data-zkey"));
        });
        return _values;
    },

    onChangeZapierSelectionHandleButton: function () {
        let disabled = true,
            existing_integrations = ($("#zapier_integrations").val() || '').split(","),
            currentSelection = this.getCurrentZapierSelectedFunnels();

        if(typeof existing_integrations == 'object' && typeof currentSelection == 'object') {
            disabled = ajaxRequestHandler.isEquals(currentSelection, existing_integrations);
            console.log("Objects compared - ", disabled);
            ajaxRequestHandler.changeSubmitButtonStatus(disabled);
            return disabled;
        }

        disabled = (currentSelection == existing_integrations);
        console.log("compared - ", disabled);
        ajaxRequestHandler.changeSubmitButtonStatus(disabled);
        return disabled;
    }
};


function funnelChecked(){
   let selectedFunnel = fkey =  [];
   let funnel_id = '';
    selectedFunnel = $("#zapier_integrations").val() || '';
    selectedFunnel = selectedFunnel.split(',');
    $("#zapier_funnelsExample input:checkbox").prop("checked", false);
    selectedFunnel.forEach(id => {
        fkey = id.split('~');
        funnel_id = fkey[1]+'~'+fkey[2]+'~'+fkey[0]+'~'+fkey[5];
        jQuery("input[data-fkey='"+funnel_id+"']").prop("checked", true);
    });
    global.folders.forEach(folderInfo => {
        checkParent(folderInfo.parentInput, folderInfo.parentDiv);
    });
}


/* Global change zapier funnel selector */
function resetZapierFunnelPopup(){
    $("#funnel-selector input[type=checkbox]").prop('checked', false);
    $("#funnel-selector input[type=checkbox]").next().removeClass('lp-white');

    $("#funnel-selector").find(".modal-title").html('Funnel Selector');
    $( ".funnel-selector-alert" ).remove();
    $("#finish").show();
    $("#zap_save_integrations").hide();
}
function disableZapierButtons(disable){
    if(disable){
        $("#zapierKeyBtn").attr('disabled', 'disabled');
        $("#zapierKeyBtn_copy").attr('disabled', 'disabled');
    }else{
        $("#zapierKeyBtn").removeAttr('disabled');
        $("#zapierKeyBtn_copy").removeAttr('disabled');
    }
}
function disableLPButtons(disable){
    if(disable){
        $("#lp_auth_access_btn").attr('disabled', 'disabled');
        $("#lp_auth_access_code_copy").attr('disabled', 'disabled');
    }else{
        $("#lp_auth_access_btn").removeAttr('disabled');
        $("#lp_auth_access_code_copy").removeAttr('disabled');
    }
}
function createZapierKey(){
    disableZapierButtons(true);
    $.ajax( {
        type : "POST",
        data: "current_hash="+$("#current_hash").val()+"&client_id="+$("#client_id").val()+"&type=zapier"+"&_token="+ajax_token,
        dataType:"json",
        url : "/lp/popadmin/createauthkey",
        success : function(d) {
            if (d.status == "success") {
                window.copy_key = 1;
                displayAlert('success', 'New Zapier key has been generated.');
                $("#zapier_access_key").val(d.key).removeClass('error');
                $(".copy-text").text(d.key);
                setTimeout(function (){
                    disableZapierButtons(false);
                    $(".zapier_toggle .toggle-group .btn").css('cursor','no-drop');
                },3000);
            }else{
                $("#zapier_access_key").val('');
                $(".copy-text").val('');
                displayAlert('danger', d.error);
                // $("#zapier_access_key").val(d.error).addClass('error');
            }
        },
        error : function () {
            disableZapierButtons(false);
            displayAlert('danger', 'Application Error');
            $("#zapier_access_key").val('');
            // $("#zapier_access_key").val('Application Error').addClass('error');
        },
        cache : false,
        async : true
    });
}
function createAuthKey(){
    disableLPButtons(true);
    $.ajax( {
        type : "POST",
        data: "current_hash="+$("#current_hash").val()+"&client_id="+$("#client_id").val()+"&type=leadpops_auth"+"&_token="+ajax_token,
        dataType:"json",
        url : "/lp/popadmin/createauthkey",
        success : function(d) {
            if (d.status == "success") {
                window.copy_key = 1;
                displayAlert('success', 'New Authorization key has been generated.');
                $("#lp_auth_access_key").val(d.key).removeClass('error');
                $("#lp_auth_access_key").siblings('.copy-text').html(d.key)
                setTimeout(function (){
                    disableLPButtons(false);
                    $(".lp_auth_toggle .toggle-group .btn").css('cursor','no-drop');
                },3000);
            }else{
                displayAlert('danger', d.error);
                $("#lp_auth_access_key").val('');
                $("#lp_auth_access_key").siblings('.copy-text').html("")
                // $("#lp_auth_access_key").val(d.error).addClass('error');
            }
        },
        error : function () {
            disableLPButtons(false);
            displayAlert('danger', 'Application Error');
            $("#lp_auth_access_key").val('');
            $("#lp_auth_access_key").siblings('.copy-text').html("")
            // $("#lp_auth_access_key").val('Application Error').addClass('error');
        },
        cache : false,
        async : true
    });
}

