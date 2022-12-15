let globalModalObj = {
    ids: [],
    folders: [],
    processing: false,
    previousMode: 0,
    currentSelection:[],
    initFunnelList: function (param) {
        window.doPreSelectInBothModals();
        $(".confimation-setting").hide();
        $(".main-setting,.checked-0,.funnel-no-text").show();
        $(".funnels .setting-slide").removeClass('show');
        $(".funnel__wrapper").css({'padding-top':''});
        if(typeof param !== "undefined" && param === 'funnel-builder'){
            $(".global-setting-pop-funnel").addClass('funnel-builder-funnel-selection-cta');
            $("[data-funnel-builder]").show();
            $("[data-global-setting]").hide();
            setTimeout(function (){
                // selected funnel checked in funnel builder CTA question
                jQuery("input[data-domainid='"+$(".select-funnel-opener").attr('data-domain-id')+"'].funnel-radio").prop("checked", true);
            },100);
        }
        else{
            $(".global-setting-pop-funnel").removeClass('funnel-builder-funnel-selection-cta');
            $("[data-funnel-builder]").hide();
            $("[data-global-setting]").show();
        }
        selectedCheckboxChecked();
    },
    modal_funnel_filter: function () {
        var data = [];
        var search = ($('#modal-search-bar').val()) ? $.trim($('#modal-search-bar').val().toLowerCase()) : '';
        var tag_search = $(".tag-drop-down-pop").val();
        var w = '';
        if (search != "" && $("#funnel-search__by").val() == "n") {
            data = jQuery.grep(rec, function (el, i) {
                if (el.funnel_name) {
                    return strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                }
            });
        }
        /**
         *if funnel type == 0 and tag search is not empty
         * then funnel will be show into all funnel with search tag name
         */
        else if (tag_search.length > 0 && $("#funnel-search__by").val() == "t") {
            data = jQuery.grep(rec, function (el, i) {
                if (el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return el;
                    }
                }
            });
        } else {
            data = rec;
        }
        globalModalObj.funnelList = data;
        if (data == null || data.length == 0) {
                $("#funnel-selection-modal-body").addClass("no-result-found")
        }
        else {
            $(".global-setting-pop .funnel__item,.global-setting-pop .funnels").hide();
            $("#funnel-selection-modal-body").removeClass("no-result-found");
            $(data).each(function (index, funnel) {
                $(`.folder-${funnel.leadpop_folder_id},.funnel-${funnel.client_leadpop_id}`).show();
            });
        }
        window.doPreSelectInBothModals();
    },
    resetFilters: function (value) {

        $(".tag-drop-down-pop").val([]).trigger("change.select2");
        $("#funnel-search__by").val(value).trigger("change.select2");
        $("#modal-search-bar").val("");
        if (value == 'n') {
            $("#global-funnel-search-by-tag").hide();
            $("#global-funnel-search-by-name").show(1000, function () {
                $('#modal-search-bar').focus();
            });

        } else {
            $("#global-funnel-search-by-name").hide();
            $("#global-funnel-search-by-tag").show(1000, function () {
                jQuery(this).find('.select2-search__field').focus();
            });
        }
    },
    resetGlobalModalFilters: function (value) {
        globalModalObj.resetFilters(value);
        globalModalObj.modal_funnel_filter();
    },
    setGlobalParentsInfo: function (parentInput, parentDiv) {
        var keyExist = jQuery.grep(globalModalObj.folders, function (parent, i) {
            return parent.parentInput == parentInput && parent.parentDiv == parentDiv;
        });
        if (keyExist.length === 0) {
            globalModalObj.folders.push({parentInput: parentInput, parentDiv: parentDiv});
        }
    },
    checkedAll: function () {
        let selectedFunnelCounter = 0;
        let selectedFunnelLength = selectedFunnelList();
        let allCheckbox = $(`#funnelsExample .funnel-checkbox`).length
        if (allCheckbox == selectedFunnelLength.length)  {
            $('#selectAllFunnelSelectionModal').prop("checked", true);
        } else {
            $('#selectAllFunnelSelectionModal').prop("checked", false);
        }
            if (selectedFunnelLength.length === 0) {
                globalModalObj.currentSelection = globalModalObj.currentSelection;
            } else {
                globalModalObj.currentSelection = JSON.stringify(selectedFunnelLength);
            }
            if(globalModalObj.currentSelection.length > 0) {
                selectedFunnelCounter = JSON.parse(globalModalObj.currentSelection).length;
            }
        $('#global_all_selected').html(selectedFunnelCounter);
    },
    checkParentFolder: function (parentInput, parentDiv) {
        const folderCheckboxesCheckedLength = $(`#${parentDiv} input[type=checkbox]:checked`).length;
        $("#global_selected_funnels_"+parentDiv).html(folderCheckboxesCheckedLength);
        const folderCheckboxesLength = $(`#${parentDiv} input[type=checkbox]`).length;
        if ( folderCheckboxesLength === folderCheckboxesCheckedLength) {
            $("#" + parentInput).parents('.funnels').removeClass('checked-0');
            $("#" + parentInput).prop("checked", true);
        }else if (folderCheckboxesCheckedLength) {
            $("#" + parentInput).parents('.funnels').removeClass('checked-0');
        } else {
            $("#" + parentInput).parents('.funnels').addClass('checked-0');
            $("#" + parentInput).prop("checked", false);
        }
        globalModalObj.checkedAll();

    },
////////////////////////////////////////////////////////////
    saveFunnelData: function (submit) {
        if(this.processing) {
            let mode = $('[name="global_mode_bar"]').is(':checked') === true ? 1 : 0;
            if (submit == 1) {
                let {hide} = displayAlert("loading", "Processing your request...");
            }
            let selectedFunnels = selectedFunnelList();
            localStorage.setItem('mode',mode);
            localStorage.setItem('selectedFunnels',JSON.stringify(selectedFunnels));
            globalModalObj.resetFilters('n');
            this.processing = false;
            window.doPreSelectInBothModals();
            if (selectedFunnels.length) {
                $("#funnelListingModalFinish").show();
            } else {
                $("#funnelListingModalFinish").hide();
            }
            adjustFormActionUrls(mode);
            globalModalObj.previousMode = mode;
            setGlobalFunnelCounter();
            globalModalObj.currentSelection = [];
            selectedCheckboxChecked();
            globalModalObj.resetGlobalModalFilters('n');
        }
    }
};


$(document).ready(function () {
        var amIclosing = false;
        $('#funnel-search__by').select2({
            minimumResultsForSearch: -1,
            dropdownParent: $(".funnel-search-global-parent"),
            width: '100%'
        }).on('change', function () {
            globalModalObj.resetGlobalModalFilters($(this).val());
        }).on('select2:openning', function () {
            jQuery('.funnel-search-global-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function () {
            jQuery('.funnel-search-global-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function () {
                jQuery('.funnel-search-global-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.funnel-search-global-parent .select2-dropdown').hide();
            jQuery('.funnel-search-global-parent .select2-dropdown').css({
                'display': 'block',
                'opacity': '1',
                'transform': 'scale(1, 1)'
            });
            jQuery('.funnel-search-global-parent .select2-selection__rendered').hide();
        }).on('select2:closing', function (e) {
            if (!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.funnel-search-global-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#funnel-search__by').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        }).on('select2:close', function () {
            jQuery('.funnel-search-global-parent .select2-selection__rendered').show();
            jQuery('.funnel-search-global-parent .select2-results__options').css('pointer-events', 'none');
        });

        // var globalModalObj = {};
        (function ($) {
            var rec = jQuery.parseJSON(funnel_json);
            var folderList = jQuery.parseJSON(folder_list);
            globalModalObj.folderList = folderList;
            globalModalObj.global_rec = rec;
            globalModalObj.funnelList = rec;
            globalModalObj.globl_top_search_data = rec;
            var html = '';
            globalModalObj.funnel_type = globalModalObj.funnel_type_name = '';

            globalModalObj.container = $("#funnelsExample");

            var funnel_name = '';
            var disable_class = '';

            /**
             * this function use for load the funnel on the global setting popup
             */
            globalModalObj.GlobalFunnelLoader = function() {

                globalModalObj.folders = [];
                globalModalObj.items = [];
                litePackageItemsDisabled = [];
                $("#funnelsExample").html('');
                html = "";
                    var i = 0;
                    $(globalModalObj.folderList).each(function (index, folder) {
                        var folderHtml = '';
                        var numberOfFunnels = 0;
                            let folder_id = `gloFunnelFolder${index}`;
                            let collapse_div_id = `globalModalCollapseAccordian${index}`;
                            folderHtml += `
                             <div class="funnels folder-${folder['id']}">
                                <div class="funnels__header" id="headingMortgage">
                                        <div class="checkbox" data-global-setting>
                                            <input type="checkbox" class="folder-input" id="${folder_id}" name="mortgagefunnel" value="" data-key="${collapse_div_id}">
                                            <label class="funnel-label" for="${folder_id}"></label>
                                        </div>
                                 <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#${collapse_div_id}" aria-expanded="true" aria-controls="collapseOne">${folder['folder_name']}</button>
                                 <span class="funnel-no-text" data-global-setting>Funnels Selected: <span class="no" id="global_selected_funnels_${collapse_div_id}"></span></span>
                                </div>
                                <div id="${collapse_div_id}" class="collapse setting-slide" aria-labelledby="headingRealEstate"
                                data-parent="#funnelsExample">
                                    <div class="card-body">
                                        <div class="funnel-list-wrap">
                                            <div class="scroll-holder">
                                                <ul class="funnel__list" id="ul${folder_id}">`;
                            $(globalModalObj.funnelList).each(function (index, funnel) {
                                if (funnel['leadpop_folder_id'] === folder['id']) {
                                    var disable_is_lite_class = subvertical = '';
                                    numberOfFunnels++;

                                    if (window.is_lite_package == '1') {
                                        if (window.lite_funnels.indexOf(funnel['leadpop_vertical_sub_id']) != -1 && funnel['leadpop_version_seq'] == 1) {
                                            disable_is_lite_class = 'active';
                                        } else {
                                            disable_is_lite_class = 'disable_lite_package';
                                        }
                                    } else {
                                        disable_is_lite_class = 'active';
                                    }

                                    //  debugger;
                                    var $fkey = funnel['leadpop_vertical_id'] + "~"
                                        + funnel['leadpop_vertical_sub_id'] + "~"
                                        + funnel['leadpop_id'] + "~"
                                        + funnel['leadpop_version_seq'];

                                    var $zkey = funnel['leadpop_id'] + "~"
                                        + funnel['leadpop_vertical_id'] + "~"
                                        + funnel['leadpop_vertical_sub_id'] + "~"
                                        + funnel['leadpop_template_id'] + "~"
                                        + funnel['leadpop_version_id'] + "~"
                                        + funnel['leadpop_version_seq'] + "~"
                                        + (funnel['domain_name']).toLowerCase();

                                    var $filed_ref = "gfunnel" + funnel['client_leadpop_id'];
                                    globalModalObj.setGlobalParentsInfo(`${folder_id}`, `${collapse_div_id}`);
                                    let disable_class = '';
                                    if($fkey == lpkey){
                                        disable_class = 'disabled';
                                    }
                                    folderHtml += `
                                               <li class="funnel__item ${disable_is_lite_class} funnel-${funnel['client_leadpop_id']}">
                                                                <div>
                                                                    <div class="checkbox" data-global-setting>
                                                                        <input type="checkbox" id="${$filed_ref}"
                                                                        onchange="globalModalObj.checkParentFolder('${folder_id}', '${collapse_div_id}')"
                                                                        data-value="${(funnel['domain_name']).toLowerCase()}"
                                                                        data-domainid="${funnel['domain_id']}"
                                                                        data-leadpop_folder_id="${funnel['leadpop_folder_id']}"
                                                                        data-domain-name="${funnel['funnel_name']}"
                                                                        value="${funnel['domain_id']}"
                                                                        data-fkey="${$fkey}"
                                                                        data-zkey="${$zkey}"
                                                                         name="reName1" class="funnel-checkbox" ${disable_class}>
                                                                        <label class="funnel-label el-tooltip" title="${funnel['funnel_name']}" for="${$filed_ref}">
                                                                            ${funnel['funnel_name']}
                                                                        </label>
                                                                    </div>
                                                                     <div class="radio" data-funnel-builder>
                                                                        <input type="radio" id="builder_${$filed_ref}"
                                                                        onchange="funnelBuilderSelectFunnel('${$filed_ref}')"
                                                                        data-value="${(funnel['domain_name'])}"
                                                                        data-domainid="${funnel['domain_id']}"
                                                                        data-leadpop_folder_id="${funnel['leadpop_folder_id']}"
                                                                        data-domain-name="${funnel['funnel_name']}"
                                                                        value="${funnel['domain_id']}"
                                                                        data-fkey="${$fkey}"
                                                                        data-zkey="${$zkey}"
                                                                         name="funnel_name" class="funnel-radio" ${disable_class}>
                                                                        <label class="funnel-label el-tooltip" title="${funnel['funnel_name']}" for="builder_${$filed_ref}">
                                                                            ${funnel['funnel_name']}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                <div class="modal-tags-holder">
                                                                    <div class="modal-tags-wrap">
                                                                        <div class="modal-tags-holder-wrap">
                                                                            <ul class="tags-list">
                                                                              ${getFunnelTag(funnel)}
                                                                            </ul>
                                                                          </div>
                                                                          <span class="modal-more"><span class="modal-more-tags">...</span></span>
                                                                          <div class="modal-tags-popup-wrap">
                                                                            <div class="modal-tags-popup">
                                                                              <ul class="tags-list">
                                                                              ${getFunnelTag(funnel)}
                                                                            </ul>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                 </li>`;
                                }
                            });
                            folderHtml += `</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        if(numberOfFunnels) //empty folders
                            html += folderHtml;
                    });

                    globalModalObj.items.push(html);
                    $("#funnelsExample").html(html);
                    modalTagPopup();
                    if($('.modal-tags-popup').length > 0) {
                        $('.modal-tags-popup').mCustomScrollbar({
                            mouseWheel: {scrollAmount: 80}
                        });
                    }
                    //selected funnel checkbox checked during the render the html
                    selectedCheckboxChecked();
            };

            globalModalObj.GlobalFunnelLoader();

        })(jQuery);

    //code by @mzac90
    $(document).on('click','#funnelsExample .funnels__header', function(){
        //if tags width size greater than 500 then extra tags list hide
        //each loop work for first time expand the row
        if(!jQuery(this).hasClass('tags-opened')) {

            jQuery(this).next().find('.modal-tags-holder-wrap').each(function(){
                var global_tag = jQuery(this).parents('.modal-tags-holder');
                var temp_width = 45;
                var index = 0;
                var room = 500;
                jQuery(this).find('li').show().each(function(){
                    temp_width = temp_width + jQuery(this).outerWidth();
                    if(temp_width < room){
                        index++;
                    }
                });
                jQuery(this).find('li:gt('+ (index-1) +')').hide();
                global_tag.find('.modal-more').show();
                if(temp_width <= room){
                    global_tag.find('.modal-more').hide();
                }
            });
        }
        jQuery(this).addClass('tags-opened');
    });

        //render funnel tags
        function getFunnelTag(el) {
            var loan_type_group = [];
            var sub_category_group = [];
            var tag = '';
            /*
            * Note: this code is use to separates the loan type and sub-category
            * First loan type then sub-category
            * */
            if(['client_tag_name']) {
                var tags_list = el['client_tag_name'].split(',');
                for (i = 0; i < tags_list.length; i++) {
                    if (tags_list[i]) {
                        if (jQuery.inArray(tags_list[i], sub_category_group) != '-1') {
                            loan_type_group.push(tags_list[i]);
                        } else {
                            sub_category_group.push(tags_list[i]);
                        }
                    }
                }

                tags = loan_type_group.concat(sub_category_group);
                for (i = 0; i < tags.length; i++) {
                    if (tags[i]) {
                        tag += '<li><span>' + parseHTML(strReplaceOrg(tags[i])) + '</span></li>';
                    }
                }
            }
            return tag;
        }

        // Funnel Selector FINISH Button
        $(document).on('click', '#funnelSelectionFinish', function (e) {
            e.preventDefault();
            let _values =  selectedFunnelList();
            let _keys = _values.map(val => val.fkey).join(',');
            $("#lpkey_termsofuse," +
                "#lpkey_privacypolicy," +
                "#lpkey_licensinginformation," +
                "#lpkey_disclosures," +
                "#lpkey_contactus," +
                "#lpkey_aboutus," +
                "#lpkey_secfot," +
                "#lpkey,#lpkey_seo," +
                "#lpkey_thankyou," +
                "#lpkey_responder," +
                "#lpkey_maincontent," +
                "#lpkey_image," +
                "#lpkey_ada_accessibility," +
                "#lpkey_logo," +
                "#lpkey_background," +
                "#lpkey_notification," +
                "#lpkey_backgroundcolor," +
                "#lpkey_backgroundimage," +
                "#selectedfunnel," +
                "#funnel_select_count," +
                "#lpkey_pixels," +
                "#lpkey_recip").val(_keys);
            if (_values.length && globalModalObj.previousMode == 0) {
                $('#global_checkbox_bar #global_mode_bar').attr('data-route','/');
                // If previously no funnel selected then on funnel selection auto enable global mode
                $('#global_mode_bar').bootstrapToggle('on');
            }
            else if (_values.length == 0){
                // If no funnel selected then auto disable global mode on continue button
                $('#global_mode_bar').bootstrapToggle('off');
            }
            globalModalObj.processing = true;
            globalModalObj.saveFunnelData(1);
            window.doPreSelectInBothModals();
            $('#global_checkbox_bar #global_mode_bar').removeAttr('data-route');
            $('#global-setting-funnel-list-pop').modal('hide');
        });

        // Funnel Selection Modal Reset Button
        $(document).on('click', '#resetGlobalFunnels', function (e) {
            //from @mzac90
            //when trigger the reset then we will reload the global setting funnel model html and checked the saved checkbox
            globalModalObj.currentSelection = [];
            selectedCheckboxChecked();
        });


        // Funnel Selector Close Button
        $(document).on('click', '#funnelSelectionCloseBtn', function (e) {
            e.preventDefault();
            globalModalObj.processing = false;
            let _values =  selectedFunnelList();
                $('#global_checkbox_bar #global_mode_bar').attr('data-route','/');
                if (_values.length && globalModalObj.previousMode == 1) {
                    $('#global_mode_bar').bootstrapToggle('on');
                }
                else if ((_values.length == 0 || _values.length) && globalModalObj.previousMode == 0){
                    // If no funnel selected then auto disable global mode on continue button
                    $('#global_mode_bar').bootstrapToggle('off');
                }
            $('#global_checkbox_bar #global_mode_bar').removeAttr('data-route');
            globalModalObj.currentSelection = [];
            if($('#modal-search-bar').val() || $(".tag-drop-down-pop").val().length > 0) {
               globalModalObj.resetGlobalModalFilters('n');
            }
            else{
                selectedCheckboxChecked();
            }
        });

        //select all functionality here
        $(document).on('change', '#selectAllFunnelSelectionModal', function () {
            if ($(this).is(':checked')) {
                $('#funnelsExample .folder-input').prop("checked", true).trigger('change');
            } else {
                $('#funnelsExample .folder-input').prop("checked", false).trigger('change');
            }
    });

        //select all inner funnels from folder checkbox
        $(document).on('change', 'input[id^=gloFunnelFolder]', function () {
            var id = $(this).prop('id');
            var groupId = $(this).data("key");
            if ($(this).is(':checked')) {
                $(`#${groupId} input[type=checkbox]`).not(":disabled").prop('checked', true);
            } else {
                $(`#${groupId} input[type=checkbox]`).not(":disabled").prop('checked', false);
            }
            $("#global_selected_funnels_"+groupId).text($(`#${groupId} input[type=checkbox]:checked`).length);
            globalModalObj.checkedAll();
        });

        //search by funnel name and funnel tags
        $(document).on('click', '#searchIcon,#searchIcon-tag', function (event) {
            globalModalObj.modal_funnel_filter();
        });

        //search by funnel name when press enter
        $(document).on('keydown', '#modal-search-bar', function (event) {
            if (event.keyCode == 13) {
                globalModalObj.modal_funnel_filter();
            }
        });

        //search funnel when select any new tags from dropdown
        $(document).on('change', '.tag-drop-down-pop', function (event) {
            globalModalObj.modal_funnel_filter();
        });


        // ============================================================================================================================================
        // ====================================================== Global Funnels Selected Listing Modal ========================================================

        window.doPreSelectInBothModals = function () {
            if(window.confirmationFunnelLoader)
            window.confirmationFunnelLoader();
        };

        window.doPreSelectInBothModals();


    // Funnel builder Selector FINISH Button
    $(document).on('click', '#funnelBuilderSelection', function (e) {
        e.preventDefault();
        let selectedFunnel = jQuery("#funnelsExample .radio .funnel-radio:checked");
        $(".select-funnel-opener").addClass('selected').find("span").html(selectedFunnel.attr('data-domain-name'));
        $('#global-setting-funnel-list-pop').modal('hide');
        $("#funnelBuilderSelection").attr('disabled',true);
        SaveChangesPreview.saveJson('cta-button-settings.leadpops-funnel-name',selectedFunnel.attr('data-domain-name'));
        SaveChangesPreview.saveJson('cta-button-settings.leadpops-domain-id',selectedFunnel.val());
        var top_field_name = 'cta-button-settings.link-destination';
        var top_field_value = $('[data-field-name="cta-button-settings.link-destination"]').val();
        SaveChangesPreview.saveJson(top_field_name,top_field_value);
        $(".select-funnel-opener").attr('data-domain-id',selectedFunnel.val());
    });

});

//tags set in global settings funnels
function modalTagPopup(){
    jQuery('.modal-more-tags').click(function(){
        var _self = jQuery(this);
        var popup = _self.parents('.funnel__item').find('.modal-tags-popup-wrap');
        if(!_self.parents('.modal-tags-holder').hasClass('modal-seetings-tags'))
        {
            $('.modal-tags-holder.modal-seetings-tags').find('.modal-tags-popup-wrap').hide();
        }
        popup.fadeToggle(500);
        var popupHeight = popup.outerHeight();
        var modalTop = 30;
        var tagsOffsetTop = _self.offset().top;
        var popupOffset = tagsOffsetTop - modalTop - popupHeight;
        $(".modal-tags-popup").removeClass('top-position');
        if(tagsOffsetTop  < 300){
            popupOffset = tagsOffsetTop+17;
            _self.parents('.funnel__item').find(".modal-tags-popup").addClass('top-position');
        }
        popup.css('top', popupOffset + 'px');
        $('.accordion').find('.modal-tags-holder').removeClass('modal-seetings-tags');
        _self.parents('.modal-tags-holder').toggleClass('modal-seetings-tags');
    });

}

// Funnel builder funnel selector
function funnelBuilderSelectFunnel(selector){
        if($("#builder_"+selector).is(":checked")){
            $("#funnelBuilderSelection").removeAttr('disabled');
        }
}
