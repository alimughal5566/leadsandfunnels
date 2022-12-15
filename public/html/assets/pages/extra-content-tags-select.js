window.parentClass = selector = render = selected_folder_list = '';
window.selected_tag_list = funnel_selected_tag_list = window.selected_clone_tag_list = new Array();
window.niceScrollHide = false;
var extra_content_tags = {

    lp_tag_list : [
        {selecter:".create_funnel_tag_list", parent:".create_funnel_tag_list_parent"},
        {selecter:".create_funnel_tags", parent:".create_funnel_tags_parent"},
    ],

    funneltagsloop: function () {
        var taglist = extra_content_tags.lp_tag_list;
        for(var i = 0; i < taglist.length; i++){
            extra_content_tags.initSelect2(taglist[i].selecter,taglist[i].parent);
        }
    },


    // Create New Funnel - custom select jQuery functions
    exCustomSelect: function () {
        jQuery('.lp-custom-select__opener').click(function(e){
            e.preventDefault();
            var _self = jQuery(this);
            _self.parent('.lp-custom-select').addClass('lp-custom-select-active');
        });

        // ON Selection in Folder custom dropdown
        jQuery(document).on('click', '.lp-custom-select__list__item', function(e){
            var getHTML = jQuery(this).html();
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').html(getHTML);
            jQuery('.lp-custom-select__list__item').removeClass('selected');
            jQuery(this).addClass('selected');
            jQuery(this).parents('.lp-custom-select').removeClass('lp-custom-select-active');
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').addClass('text-selected');
        });

        jQuery(document).on('click', '.new-tags-opener', function(e){
            e.preventDefault();
            jQuery(this).parent('.new-tags-holder').addClass('lp-text-field-active');
            setTimeout(function (){
                jQuery("#new_folder").focus();
            },500);
        });

        jQuery('.lp-close-custom-tag').click(function(e){
            e.preventDefault();
            jQuery(this).parents('.new-tags-holder').removeClass('lp-text-field-active');
        });

        // ON adding new Folder in custom dropdown
        jQuery(document).on('click', '.lp-add-custom-tag', function(e){
            e.preventDefault();
            jQuery('.lp-custom-select__list__item').removeClass('selected');
            var getVal = jQuery(this).parents('.new-tag-field').find('input').val();
            if($.trim(getVal).length === 0)
            {
                return false;
            }
            $("#create_funnel_folder_id").val("new_"+getVal);
            var setVal = '<li class="lp-custom-select__list__item selected">'+ getVal +'</li>';
            jQuery('.lp-custom-select__list').append(setVal);
            jQuery(this).parents('.new-tags-holder').removeClass('lp-text-field-active');
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').html(getVal);
            jQuery(this).parents('.lp-custom-select').removeClass('lp-custom-select-active');
            jQuery(this).parents('.lp-custom-select').find('.lp-custom-select__opener').addClass('text-selected');
            jQuery("#new_folder").val('');
        });
    },

    /*
    * funnel tag(s) select2js start match
    * */

    matchStart: function (params, data) {
        params.term = params.term || '';

        if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
            return data;
        }

        return null;
    },

    /*
    * funnel tag(s) select2js
    * */

    initSelect2:function (selecter,parent) {
        var dropdown =  $(selecter).select2({
            width: '100%',
            placeholder: 'Type in Funnel Tag(s)...',
            dropdownParent: $(parent),
            selectionAdapter: $.fn.select2.amd.require("CustomSelectionAdapter"),
            templateResult: function (data, container) {
                if (data.element) {
                    $(container).addClass('za-tag-list');
                }
                var $result = $("<span></span>");

                $result.text(data.text);
                return $result;
            },
            matcher: function (params, data) {
                return extra_content_tags.matchStart(params, data);
            },
            sorter: function(data){
                return data.sort(function (a,b){
                    return a.text.localeCompare(b.text)
                })
            },
            language:{
                noResults: function() {
                    if(parent == '.create_funnel_tag_list_parent') {
                        var term = $(parent).find("input[type='search']").val();
                        return $(`<span class='result-text'>No results found</span><div class='add-tag-wrap'><a href='#' class='add-tag' 
data-parent="${parentClass}" data-tag="${term}"><i class='ico ex-content-ico-plus'></i>Create new tag <br ><span class='tag-item'><i class='ico ex-content-ico-tag'></i>${term}</span></a></div>`);
                    }
                    else if($.inArray(parent,['.create_funnel_tag_list']) != -1) {
                        return '';
                    }
                    return "No results found";
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            }
        });

        dropdown.on("select2:open", function () {
            selector = '';
            parentClass = parent.replace(/[#.]/g,'');
            $(`.${parentClass} .select2-dropdown`).addClass('za-tag-custom za-tag-dropdown-modifier');
            $(".select2-search.select2-search--inline .select2-search__field").addClass('za-tag-dropdown-modifier').css('border-radius', '3px 3px 0 0');
            // $('.lp-tag .clone-tag-result .select2-container .select2-search--inline .select2-search__field').attr('placeholder', '');
            if(niceScrollHide === false && parentClass === "dashboard-tag-result") {
                tagScroll();
            }
            else{
                tagScroll();
            }
            if($.inArray( parentClass,['clone-new-tag','funnel-tag-result']) != -1) {
                $(`.${parentClass}`).parents('.modal').addClass('tag-dropdown-active');
            }
            $(parent).find('.select2-search__field').removeClass('select2-remove-focus');
        });

        dropdown.on("select2:close", function () {
            extra_content_tags.select2jsPlaceholder();
            $("#tag_list-error").remove();
            $(`.${parentClass}`).parents('.modal').removeClass('tag-dropdown-active');

        });

        dropdown.on('select2:select', function (e) {
            if($.inArray( parentClass,['tag-result','clone-new-tag','funnel-tag-result']) != -1) {
                tagManage(parentClass);
            }
            var self = this
            var element = e.params.data.element;
            var $element = $(element);
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
            setTimeout(function (){
                $($(parent).find(".select2-search__field")[0]).focus();
                extra_content_tags.select2jsPlaceholder();
            },100);
            requestAnimationFrame(function () {
                var $parents = $(self).parents('.lp-tag-scroll, .lp-tag-scroll > .mCustomScrollBox');
                $parents.scrollTop(0)
            });
            $(parent).find('.select2-search__field').removeClass('select2-remove-focus');
        });

        dropdown.on('select2:unselecting', function (e) {
            dropdown.on('select2:opening', function (e) {
                e.preventDefault();
                dropdown.off('select2:opening');
            });
        });
        dropdown.on('select2:unselect', function (e) {
            parentClass = parent.replace(/[#.]/g,'');
            if(jQuery(e.target.offsetParent).hasClass('dashboard-tag-result')) {
                if (site.route == 'dashboard') {
                    var selectedTag = $(".dashboard-tag-result .select2-selection__choice").length;
                    var tagSearch = $(".dashboard-tag-result .select2-search__field").val();
                    if(selectedTag === 0 && tagSearch === "") {
                        _search();
                    }
                }
            }
            if($.inArray( parentClass,['tag-result','clone-new-tag','funnel-tag-result']) != -1) {
                $(parent).find('.select2-search__field').addClass('select2-remove-focus');
                var tag = '';
                tagManage(parentClass);
                extra_content_tags.tag_drop_down_list(render,2);
            }
            setTimeout(function (){
                $(parent).find(".select2-search__field").focus();
                extra_content_tags.select2jsPlaceholder();
            },100);
        });
    },

    /**
     * select2 dropdown set width accroding to selected tags
     * calculate the width of selected tags and set the dropdown depend on search box remaining width
     */
    setSelectDropDownPosition: function (){
        let searchBoxWidth = 182; //max search box width
        let defaultWidth = 130; //min search box width
        let searchBoxTopOffset = selectedTagsTopOffset = width = remainingWidth = 0; // use value default set 0
        let renderData =  jQuery(".tags-render .select2-selection__rendered");
        let selectedTags = jQuery(renderData).find('li.select2-selection__choice'); // get selected tags list
        let searchBoxli = renderData.find('.select2-search'); // search box li
        if(selectedTags.length){
            selectedTagsTopOffset = selectedTags[0].offsetTop; // getting one selected tag top offset
        }
        if(searchBoxli.length) {
            searchBoxTopOffset = (searchBoxli) ? parseInt(searchBoxli[0].offsetTop) + selectedTagsTopOffset : selectedTagsTopOffset; // getting search box li top offset
        }
        selectedTags.each( function (index,el){
            selectedTagsTopOffset = parseInt(jQuery(el)[0].offsetTop); // getting each tag top offset
            if(searchBoxTopOffset == selectedTagsTopOffset) {
                width += parseFloat(jQuery(el).outerWidth());
            }
        });
        width = parseInt(width);
        let boxWidth = renderData.outerWidth()-searchBoxWidth;
        let element = jQuery(".tags-render .za-tag-custom,.tags-render .za-tag-custom .select2-results__options");
        remainingWidth = parseInt(boxWidth-width);
        if(remainingWidth >= defaultWidth && remainingWidth <= searchBoxWidth){ // if remaining value greater than and less than to min and max value
            remainingWidth = remainingWidth;
        }
        else  if(remainingWidth >= 50 && remainingWidth <= defaultWidth){ //if  remaining value less than to min value
            let newWidth = remainingWidth+(140-(searchBoxWidth-remainingWidth));
            remainingWidth = newWidth;
        }
        else{
            remainingWidth  =  searchBoxWidth; // default search box value
        }
        jQuery('.za-tag-custom,.select2-search__field').removeClass('za-tag-dropdown-modifier'); // remove the css set width
        element.css('width',remainingWidth+'px'); // set new width  of dropdown
        setTimeout(function (){
            renderData.find('.select2-search__field').css('width',remainingWidth+'px'); // set new width search box
        },100);
    },


    //from @mzac09
    //tag drop down list
    tag_drop_down_list: function(ele = 1 , del = 1){
        var opt = render_class = '';
        var selected_list = [];
        //ele = 2 for clone funnel tags list, ele = 3 for create new funnel tag list
        if(ele == 2){
            selected_list = selected_clone_tag_list;
            render_class = '.clone-tag-drop-down';
        }
        else if(ele == 3){
            selected_list = funnel_selected_tag_list;
            render_class = '.create_funnel_tasg_list';
        }
        else{
            selected_list = selected_tag_list;
            render_class = '.tag-drop-down';
        }

        var tagsToRender = tag_dropdown;
        // Disabling order on delete
        if(del == 2) {
            var savedSelectedTagsIds = selected_list;

            if (savedSelectedTagsIds && savedSelectedTagsIds.length) {
                var selectedTagsIds = [];

                savedSelectedTagsIds.forEach(function (id) {
                    var index = tag_dropdown.findIndex(tag => tag.id === id)

                    if (index > -1) {
                        selectedTagsIds.push(tag_dropdown[index])
                    }
                });

                tagsToRender = selectedTagsIds;

                tag_dropdown.forEach(function (tag) {
                    if (savedSelectedTagsIds.indexOf(tag.id) < 0) {
                        tagsToRender.push(tag)
                    }
                });
            }
        }
        $(tagsToRender).each(function (index, el) {
            opt += '<option value="'+el.id+'"  '+lpUtilities.isSelected(selected_list,el.id)+'>'+el.tag_name+'</option>';
        });
        $(render_class).html(opt);
    },


    /*
    * funnel tag(s) select2js dropdown positions
    * */

    dropdownpos: function (ele) {
            $(".za-tag-custom").parent().css({
                top: $("." + ele + " .select2-search--inline")[0].offsetTop + $("." + ele + " .select2-search--inline")[0].offsetHeight - 4,
                left: $("." + ele + " .select2-search__field")[0].parentNode.offsetLeft + 1
            });
    },

    /*
    * funnel tag(s) placeholder
    *
    .tag-result-common remove class in placeholder from @mzac90
     */
    select2jsPlaceholder: function () {
        if(selector == '') {
            $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').show();
            if ($(".lp-tag .select2-container ul li").hasClass('select2-selection__choice') == false) {
                placeholder = 'Type in Funnel Tag(s)...';
            } else {
                placeholder = 'Add another tag';
            }
            $('.lp-tag .select2-container .select2-search--inline .select2-search__field').attr('placeholder', placeholder);
        }
        $('.create_funnel_tag_list .select2-container .select2-search--inline .select2-search__field').attr('placeholder', 'Type in Funnel Folder...');
    },

    /*
    * funnel tag(s) select2js add funnels
    * */

    addFunnelTags: function () {
        $.fn.select2.amd.define("CustomSelectionAdapter", [
                "select2/utils",
                "select2/selection/multiple",
                "select2/selection/placeholder",
                "select2/selection/eventRelay",
                "select2/selection/search",
            ],
            function(Utils, MultipleSelection, Placeholder,EventRelay,SelectionSearch) {

                var adapter = Utils.Decorate(MultipleSelection, Placeholder);
                adapter = Utils.Decorate(adapter, SelectionSearch);
                adapter = Utils.Decorate(adapter, EventRelay);

                adapter.prototype.update = function(data) {
                    this.clear();
                    if (data.length === 0) {

                        this.$selection.find('.select2-selection__rendered')
                            .append(this.$searchContainer);
                        return;
                    }

                    var $selections = [];
                    var selected_tag_list = jQuery(".tag-result").data('tags');

                    for (var d = 0; d < data.length; d++) {
                        var selection = data[d];
                        var $selection = this.selectionContainer();
                        if ($('[name="global_mode_bar"]').is(':checked')) {
                            jQuery(selected_tag_list).each(function (k, v) {
                                if(selection.id.indexOf('new_') === -1) {
                                    if (selection.id == v) {
                                        $selection.addClass('tags-disabled');
                                        $(".tags-disabled .select2-selection__choice__remove").hide();
                                    }
                                }
                            });
                        }
                        else{
                            $(".tags-disabled .select2-selection__choice__remove").hide();
                        }
                        var formatted = this.display(selection, $selection);
                        $selection.append(formatted);
                        $selection.prop('title', selection.title || selection.text);
                        $selection.data('data', selection);
                        $selections.push($selection);
                    }
                    var $rendered = this.$selection.find('.select2-selection__rendered');
                    Utils.appendMany($rendered, $selections);
                    var searchHadFocus = this.$search[0] == document.activeElement;
                    // this.$search.attr('placeholder', '');
                    this.$selection.find('.select2-selection__rendered')
                        .append(this.$searchContainer);
                    this.resizeSearch();
                    if (searchHadFocus) {
                        this.$search.focus();
                    }
                };

                return adapter;
            });
        // select init for get the drop down position
        var Defaults = $.fn.select2.amd.require('select2/defaults');
        $.extend(Defaults.defaults, {
            dropdownPosition: 'auto'
        });
        var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');
        AttachBody.prototype._positionDropdown = function() {
            var $offsetParent = this.$dropdownParent;
            if($offsetParent.hasClass(parentClass)) {
                $('.tag-result-common .select2-selection__choice').mouseenter(function () {
                    extra_content_tags.dropdownpos(parentClass);
                    $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').hide();
                });
                $('.tag-result-common .select2-selection__choice').mouseleave(function () {
                    $('.tag-result-common .select2-search, .tag-result-common .za-tag-custom').show();
                    extra_content_tags.dropdownpos(parentClass);
                    extra_content_tags.select2jsPlaceholder();
                });
                $('.tag-result-common .select2-search__field').blur(function () {
                    extra_contentextra_content_tags.dropdownpos(parentClass);
                    extra_content_tags.select2jsPlaceholder();
                });
                extra_content_tags.dropdownpos(parentClass);
            }
            else{
                var $window = $(window);
                var isCurrentlyAbove = this.$dropdown.hasClass('select2-dropdown--above');
                var isCurrentlyBelow = this.$dropdown.hasClass('select2-dropdown--below');

                var newDirection = null;

                var offset = this.$container.offset();

                offset.bottom = offset.top + this.$container.outerHeight(false);

                var container = {
                    height: this.$container.outerHeight(false)
                };

                container.top = offset.top;
                container.bottom = offset.top + container.height;

                var dropdown = {
                    height: this.$dropdown.outerHeight(false)
                };

                var viewport = {
                    top: $window.scrollTop(),
                    bottom: $window.scrollTop() + $window.height()
                };

                var enoughRoomAbove = viewport.top < (offset.top - dropdown.height);
                var enoughRoomBelow = viewport.bottom > (offset.bottom + dropdown.height);

                var css = {
                    left: offset.left,
                    top: container.bottom
                };

                // Determine what the parent element is to use for calciulating the offset
                // For statically positoned elements, we need to get the element
                // that is determining the offset
                if ($offsetParent.css('position') === 'static') {
                    $offsetParent = $offsetParent.offsetParent();
                }

                var parentOffset = $offsetParent.offset();

                css.top -= parentOffset.top
                css.left -= parentOffset.left;
                var dropdownPositionOption = this.options.get('dropdownPosition');

                if (dropdownPositionOption === 'above' || dropdownPositionOption === 'below') {

                    newDirection = dropdownPositionOption;

                } else {

                    if (!isCurrentlyAbove && !isCurrentlyBelow) {
                        newDirection = 'below';
                    }

                    if (!enoughRoomBelow && enoughRoomAbove && !isCurrentlyAbove) {
                        newDirection = 'above';
                    } else if (!enoughRoomAbove && enoughRoomBelow && isCurrentlyAbove) {
                        newDirection = 'below';
                    }

                }

                if (newDirection == 'above' ||
                    (isCurrentlyAbove && newDirection !== 'below')) {
                    css.top = container.top - parentOffset.top - dropdown.height;
                }

                if (newDirection != null) {
                    this.$dropdown
                        .removeClass('select2-dropdown--below select2-dropdown--above')
                        .addClass('select2-dropdown--' + newDirection);
                    this.$container
                        .removeClass('select2-container--below select2-container--above')
                        .addClass('select2-container--' + newDirection);
                }
                this.$dropdownContainer.css(css);
            }
        };
        if(parentClass == 'tag-result') {
            AttachBody.prototype._resizeDropdown = function (decorated) {
                extra_content_tags.setSelectDropDownPosition();
            };
        }
    },

    /**
     ** add new tag function
     **/
    addTagInit: function() {
        var tag_dropdown = [];
        $(document).on('click', '.add-tag', function (e) {
            e.preventDefault();
            var id = 'new_' + $(this).data('tag');
            $('#create_funnel_tag_list').append('<option value="'+id+'">'+$(this).data('tag')+'</option>');
            var getVal = jQuery('#create_funnel_tag_list').val();
            getVal.push(id);
            $("#create_funnel_tag_list").val(getVal);
            setTimeout(function (){
                $('.create_funnel_tag_list_parent').find("input[type='search']").val('').click();
            },100);
        });
    },

    /*
      ** init Function
    **/

    init: function() {
        extra_content_tags.exCustomSelect();
        extra_content_tags.addFunnelTags();
        extra_content_tags.funneltagsloop();
        extra_content_tags.addTagInit();
    },
};

jQuery(document).ready(function() {
    extra_content_tags.init();
});


//nice scroll init for tags dropdown
function tagScroll(){
    $('.za-tag-custom .select2-results__options').niceScroll({
        background: "#02abec",
        cursorcolor: "#ffffff",
        cursorwidth: "7px",
        autohidemode: false,
        railalign: "right",
        railvalign: "bottom",
        railpadding: {top: 0, right: 0, left: 0, bottom: 4}, // set padding for rail bar
        cursorborder: "1px solid #fff",
        cursorborderradius: "5px"
    });
}
function tagManage(parentClass){
    var tag = '';
    render = 1;
    if(parentClass == 'tag-result') {
        selected_tag_list = new Array();
        if ($("#tag_list").val()) {
            $($("#tag_list").val()).each(function (k, v) {
                if(parseInt(v)){
                    tag = parseInt(v);
                }
                else{
                    tag = v;
                }
                selected_tag_list.push(tag);
            });
        }
    }
    if(parentClass == 'funnel-tag-result') {
        funnel_selected_tag_list = new Array();
        if ($("#create_funnel_tag_list").val()) {
            $($("#create_funnel_tag_list").val()).each(function (k, v) {
                if(parseInt(v)){
                    tag = parseInt(v);
                }
                else{
                    tag = v;
                }
                funnel_selected_tag_list.push(tag);
            });
        }
        render = 3;
    }
    if(parentClass == 'clone-new-tag') {
        selected_clone_tag_list = new Array();
        if ($(".tag_list").val()) {
            $($(".tag_list").val()).each(function (k, v) {
                if(parseInt(v)){
                    tag = parseInt(v);
                }
                else{
                    tag = v;
                }
                selected_clone_tag_list.push(tag);
            });
        }
        render = 2;
    }
}