(function($){
    window.id = window.index = window.table = is_present = '';
    window.folder_data = jQuery.parseJSON(folder_list);
    window.tag_data = jQuery.parseJSON(tag_list);
    var is_default = folder_id_array = '';
    window.selected_tag_list = new Array();
    window.response = false;
    window.duplicate_funnel_name_msg = 'Name is already used by an existing funnel try again.';
    tooltip();
    /**
     * use for set the selected2 dropdown position if room has been not enough
     */
    var Defaults = $.fn.select2.amd.require('select2/defaults');
    $.extend(Defaults.defaults, {
        dropdownPosition: 'auto'
    });
    var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');
    var _positionDropdown = AttachBody.prototype._positionDropdown;
    AttachBody.prototype._positionDropdown = function() {

        var $offsetParent = this.$dropdownParent;
        if($offsetParent.hasClass('folder-result')) {
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
            else {
            tagWindowPositionSet();
        }
    };
    /**
     * save folder
     * @type {jQuery|undefined}
     */
    var folder = $(".add-folder-form").validate({
        rules: {
            folder_name: {
                required: true
            }
        },
        messages: {
            folder_name: {
                required: "Please enter the folder name."
            }
        },
        submitHandler: function() {
            is_present = 0;
            var r =   jQuery.grep(folder_data, function (el, i) {
                return el.folder_name.toLowerCase() == $("#folder_name").val().toLowerCase() && el.id != id;
            });
            if(r.length > 0) {
                notification.error('.folder-notifcations', '<strong>Warning!</strong> Folder name already exists in the list.');
                is_present = 1;
            }
            if(is_present == 0){
                if(id){
                    is_default = folder_data[index].is_default;
                }else{
                    is_default = 0;
                }
                $.ajax(
                    {
                    type : "POST",
                    data: { hash: funnel_hash, id: id, is_default: is_default, folder_name: $("#folder_name").val(),_token:ajax_token },
                    url : "/lp/tag/addfolder",
                    dataType : "json",
                    error: function (e) {
                    },
                    success : function(rsp) {
                        if(rsp.response == 'added'){
                            notification.success('.folder-notifcations', '<strong>Success:</strong> Folder name has been added.');
                        }
                        else if(rsp.response == 'updated'){
                            notification.success('.folder-notifcations', '<strong>Success:</strong> Folder name has been updated.');
                        }
                        else if(rsp.response == 'error'){
                            notification.error('.folder-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.');
                        }
                        else if(rsp.response == 'logout'){
                            location.reload();
                        }
                        window.folder_data = jQuery.parseJSON(rsp.html);
                    },
                    complete :function(e){
                        values_update();
                    },
                    cache : false,
                    async : false
                });
            }
        }
    });
    /**
     * save tag
     * @type {jQuery|undefined}
     */
    var tag = $(".add-tag-form").validate({
        rules: {
            tag_name: {
                required: true,
                minlength: 1
            }
        },
        messages: {
            tag_name: {
                required: "Please enter the tag name."
            }
        },
        submitHandler: function() {
            is_present = 0;
            var r =   jQuery.grep(tag_data, function (el, i) {
                return el.tag_name.toLowerCase() == $("#tag_name").val().toLowerCase() && el.id != id;
            });
            if(r.length > 0) {
                notification.error('.tag-notifcations', '<strong>Warning!</strong> Tag name already exists in the list.');
                is_present = 1;
            }
            if(is_present == 0){
                if(id){
                    is_default = tag_data[index].is_default;
                }else{
                    is_default = 0;
                }
                $.ajax(
                    {
                        type : "POST",
                        data: { hash: funnel_hash, id: id, is_default: is_default, tag_name: $("#tag_name").val(),_token:ajax_token },
                        url : "/lp/tag/addtag",
                        dataType : "json",
                        error: function (e) {
                        },
                        success : function(rsp) {
                            if(rsp.response == 'added'){
                                notification.success('.tag-notifcations', '<strong>Success:</strong> Tag name has been added.');
                            }
                            else if(rsp.response == 'updated'){
                                notification.success('.tag-notifcations', '<strong>Success:</strong> Tag name has been updated.');
                            }else if(rsp.response == 'error'){
                                notification.error('.tag-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.');
                            }
                            else if(rsp.response == 'logout'){
                                location.reload();
                            }
                            window.tag_data = jQuery.parseJSON(rsp.html);
                        },
                        complete :function(e){
                             values_update();
                        },
                        cache : false,
                        async : false
                    });
            }
        }
    });
    /**
     * tag and folder assign to the selected funnel
     */
    $(".set-tag-folder").validate({
        /*Now, no need to validation*/
        rules: {
            funnel_name: {
                required: true
            }
        },
        messages: {
            funnel_name: {
                required: "Please enter your funnel name."
            }
        },
        submitHandler: function() {
               funnelNameValidation();
              if(response) {
                  var funnel_name = $("#funnel_name").val();
                  $.ajax({
                      type: "POST",
                      data: {
                          hash: funnel_hash,
                          folder_list: $("#folder_list").val(),
                          tag_list: $("#tag_list").val(),
                          funnel_name:funnel_name,
                          old_funnel_name: $("#funnel_name").attr('data-funnel-name'),
                          _token: ajax_token
                      },
                      url: "/lp/tag/savefunneltag",
                      dataType: "json",
                      error: function (e) {
                      },
                      success: function (rsp) {
                          if (rsp.response == 'updated') {
                              notification.success('.funnel-notifcations', '<strong>Success:</strong> Name & Tags have been updated.<br />');
                              selected_tag_list = new Array();
                              if ($("#tag_list").val()) {
                                  $($("#tag_list").val()).each(function (k, v) {
                                      selected_tag_list.push(parseInt(v));
                                  });
                              }
                              $(".selectedFunnel").text(funnel_name);
                              $("#funnel_name").attr('data-funnel-name',funnel_name);
                          }else if (rsp.response == 'warning') {
                              notification.error('.funnel-notifcations', '<strong>Warning!</strong> '+duplicate_funnel_name_msg+'<br />');
                          } else if (rsp.response == 'error' && rsp.funnel_name == 0) {
                              $("#funnel_name").addClass('error');
                              $(".tag-section .tag-block label.error").text('Please enter your funnel name.').show();
                          }else if (rsp.response == 'error') {
                              notification.error('.funnel-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.<br />');
                          } else if (rsp.response == 'logout') {
                              location.reload();
                          }
                      },
                      cache: false,
                      async: false
                  });
              }
        }
    });
    /**
     * special character validation method use for jquery vailator
     */
    jQuery.validator.addMethod("stringvalid", function(value, element) {
        if(/^[a-zA-Z0-9-()_\s]+$/.test(value)) {
            return true;
        }else{
            return false;
        }
    }, 'Special characters are not allowed.');

    /**
     * funnel name unique validation method use for jquery vailator
     */
    $("#funnel_name").on('blur',function(){
       funnelNameValidation();
    });


    /**
     * on blur remove special character
     */
    $("#folder_name,#tag_name,#funnel_name").on('blur',function(){
        var v = $(this).val();
        if(v) {
            v = v.replace(/\\/g, '');
            $(this).val(v);
            $(this).removeClass('error');
            $('.add-folder-form label.error,.add-tag-form label.error').remove();
        }
    });
    /**
     * delete tag and folder
     */
    $(document).on("click","#delete",function (){
        new_str = table.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
        });
        $.ajax(
            {
                type : "POST",
                data: { hash: funnel_hash, id: id, table: table,_token:ajax_token },
                url : "/lp/tag/delete",
                dataType : "json",
                error: function (e) {
                },
                success : function(rsp) {
                    if(rsp.response == 'deleted'){
                        notification.success('.'+table+'-notifcations', '<strong>Success:</strong> '+new_str+' name has been deleted.');

                    }
                    else if(rsp.response == 'error'){
                        notification.error('.'+table+'-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.');
                    }
                    else if(rsp.response == 'logout'){
                        location.reload();
                    }
                    $("#delete_folder").modal('hide');
                    if(table == 'folder'){
                        window.folder_data = jQuery.parseJSON(rsp.html);
                    }else{
                        window.tag_data = jQuery.parseJSON(rsp.html);
                    }
                    $("#tag_name,#folder_name").focus();
                },
                complete :function(e){
                    values_update();
                },
                cache : false,
                async : false
            });
    });
    /**
     * folder list sorting
     */
    $( ".sorting" ).sortable({
        handle: ".move",
        placeholder : "folder-highlight",
        scroll: true,
        axis: "y",
        start:function(){
        $('.folder-highlight').text('Drop Your Element Here...');
        },
        update  : function(event, ui)
        {
            sorting_list();
        }
    });
    /**
     * save the sorting folder lit
     */
    $(".btnAction_sort").on("click",function (){
        folder.resetForm();
        sorting_list();
        $.ajax(
            {
                type : "POST",
                data: { hash: funnel_hash,folder_ids: folder_id_array,_token:ajax_token },
                url : "/lp/tag/savesorting",
                dataType : "json",
                error: function (e) {
                },
                success : function(rsp) {
                    if(rsp.response == 'updated'){
                        notification.success('.folder-notifcations', '<strong>Success:</strong> Sorting has been updated.');
                        window.folder_data = jQuery.parseJSON(rsp.html);
                        values_update();
                    }
                    else if(rsp.response == 'logout'){
                        location.reload();
                    }
                },
                cache : false,
                async : false
            });
    });
    /**
     * select2 are using for folder list
     * @type {*|jQuery|HTMLElement|undefined}
     */
    var folder_dropdown = $(".folder-dropdown").select2({
        dropdownParent: $(".folder-result"),
        dropdownPosition: 'below',
        templateResult: function (data, container) {
            if (data.element) {
                $(container).addClass('za-folder-list');
            }
            var $result = $("<span></span>");

            $result.text(data.text);
            return $result;
        }
    });
    folder_dropdown.on('select2:select', function (e) {
        $("#folder_list").attr('data-folder',$("#folder_list").val());
    });
    folder_dropdown.on("select2:open", function () {
        $(".select2-dropdown").addClass('za-folder-custom select2-dropdown--below');
        folder_drop_down_height();
    });
    /**
     * multiselect select2 are using for tag lit
     * @type {*|jQuery|HTMLElement|undefined}
     */
    var dropdown = $(".tag-drop-down").select2({
        placeholder: 'Start typing to add a tag',
        dropdownParent: $(".tag-result"),
        templateResult: function (data, container) {
            if (data.element) {
                $(container).addClass('za-tag-list');
            }
            var $result = $("<span></span>");

            $result.text(data.text);
            return $result;
        },
        matcher: function(params, data) {
            return matchStart(params, data);
        }
    });
    dropdown.on("select2:open", function () {
        $(".select2-dropdown").addClass('za-tag-custom');
        $(".select2-search.select2-search--inline").css('border-radius','3px 3px 0 0');
        $('.lp-tag .tag-result .select2-container .select2-search--inline .select2-search__field').attr('placeholder','');
        $('.za-tag-custom .select2-results__options').niceScroll({
            //background: "#009edb",
            background: "#02abec",
            cursorcolor:"#ffffff",
            cursorwidth: "7px",
            autohidemode:false,
            railalign:"right",
            railvalign:"bottom",
            railpadding: { top: 0, right: 0, left: 0, bottom: 4 }, // set padding for rail bar
            cursorborder: "1px solid #fff",
            cursorborderradius:"5px"
        });
        $('.za-tag-custom .select2-results__options').animate({
            scrollTop: 0
        }, 200);
    });
    dropdown.on('select2:select', function (e) {
        selected_tag_list = new Array();
        if($("#tag_list").val()) {
            $($("#tag_list").val()).each(function(k,v){
                selected_tag_list.push(parseInt(v));
            });
        }
    });
    dropdown.on('select2:unselect', function (e) {
        selected_tag_list = new Array();
        if($("#tag_list").val()) {
            $($("#tag_list").val()).each(function(k,v){
                selected_tag_list.push(parseInt(v));
            });
        }
    });
    dropdown.on("select2:close", function () {
        var placeholder = '';
        if($(".lp-tag .tag-result .select2-container ul li").hasClass('select2-selection__choice') == false ){
            placeholder = 'Start typing to add a tag';
        }else{
            placeholder = 'Add another tag';
        }
        $('.lp-tag .tag-result .select2-container .select2-search--inline .select2-search__field').attr('placeholder',placeholder);
        $("#tag_list-error").remove();
    });
    /**
     * after window load
     * if any tag selected then tag list placeholder will be change
     */
    $(window).on('load', function (){
        if($(".lp-tag .tag-result .select2-container ul li").hasClass('select2-selection__choice') == false ){
            placeholder = 'Start typing to add a tag';
        }else{
            placeholder = 'Add another tag';
        }
        $('.lp-tag .tag-result .select2-container .select2-search--inline .select2-search__field').attr('placeholder',placeholder);
        tagHoverRemover();
    });

    /**
     * folder and tag form reset whenever, modal will closed
     */
    $('.add-folder').on('hidden.bs.modal', function (e) {
        values_update();
        folder.resetForm();
        tag.resetForm();
    });
    /**
     * whenever, delete modal will close then scroll bar issue will be fixed on the other modal
     */
    $('#delete_folder').on('hidden.bs.modal', function (e) {
        $("body").addClass('modal-open');
    });
    /**
     * on click tag and folder nav show
     */
    $(document).on("click",".show_nav",function (){
        $(".show_nav").show();
        $(".action_nav").hide();
        $(this).hide().next(".action_nav").show();
    });
    /**
     * show folder modal
     */
    $(".edit-folder-popup").on("click",function (){
        $('#add-folder').modal('show');
        values_update();
    });
    /**
     * show tag modal
     */
    $(".edit-tag-popup").on("click",function (){
        $('#add-tag').modal('show');
        values_update();
    });
    /**
     * when on click edit folder link then selected folder will be editable
     */
    $(document).on("click",".edit-folder",function (){
        id =  $(this).data('id');
        index =  $(this).data('index');
        var r =   folder_data[index].folder_name;
        $(".folder-btn").val('Update Folder');
        $("#folder_name").val(parseHTML(r)).focus();
        folder.resetForm();
    });
    /**
     * when on click edit tag link then selected tag will be editable
     */
    $(document).on("click",".edit-tag",function (){
        id =  $(this).data('id');
        index =  $(this).data('index');
        var r =   tag_data[index].tag_name;
        $(".tag-btn").val('Update Tag');
        $("#tag_name").val(parseHTML(r)).focus();
        tag.resetForm();
    });
    /**
     * delete confirmation modal show for folder and tag
     */
    $(document).on("click",".del",function (){
        id =  $(this).data('id');
        table =  $(this).data('table');
        if(table == 'folder'){
            $("#delete_folder h3").text('Delete Folder');
            $("#delete_folder .modal-msg").text('Are you sure to delete this Folder?');

        }else{
            $("#delete_folder h3").text('Delete Tag');
            $("#delete_folder .modal-msg").text('Are you sure to delete this Tag?');
        }
        $("#delete_folder").modal('show');
    });
    /**
     * saved tag show in tag dropdown list
     * @type {jQuery}
     */
    selected_tag_list =  $(".tag-result").data('tags');
    /**
     * render folder drop down list
     */
    folder_drop_down_list();
    /**
     * render tag drop down list
     */
    tag_drop_down_list();
})(jQuery);

/**
 * this function use for select2 autocomplete. whenever, search the tag in dropdown list.
 * @param params
 * @param data
 * @returns {null|*}
 */
function matchStart(params, data) {
    params.term = params.term || '';
    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
        return data;
    }
    return null;
}
//folder popup html render
function folder_html_render(){
    var html = '';
    $(folder_data).each(function (index, el) {
        html += '<div class="folder-col" data-id="'+el.id+'">\
            <div class="row">\
            <div class="col-sm-6"><h4>'+el.folder_name+'</h4></div>\
        <div class="col-sm-6" align="right">\
            <a href="#" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>\
        <ul class="action_nav">\
            <li> <a href="#" class="move" data-id="'+el.id+'"><i class="fa fa-arrows"></i>MOVE</a></li>\
        <li> <a href="#" class="edit-folder" data-id="'+el.id+'" data-index="'+index+'"><i class="fa fa-pencil"></i>EDIT</a></li>';
        if(el.is_default == 0) {
            html += '<li> <a href="#" class="del" data-id="' + el.id + '" data-table="folder"><i class="fa fa-remove"></i>DELETE</a></li>';
        }
            html += '</ul>\
        </div>\
        </div>\
        </div>';
    });
    $( '.folder-listing .sorting' ).html(html);
    $(".folder-listing").mCustomScrollbar();
}
//tag popup html render
function tag_html_render(){
    var html = '';
    $(tag_data).each(function (index, el) {
        html += '<div class="folder-col" data-id="'+el.id+'">\
            <div class="row">\
            <div class="col-sm-8"><h4>'+el.tag_name+'</h4></div>\
        <div class="col-sm-4" align="right">\
            <a href="#" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>\
        <ul class="action_nav">\
        <li> <a href="#" class="edit-tag" data-id="'+el.id+'" data-index="'+index+'"><i class="fa fa-pencil"></i>EDIT</a></li>\
        <li> <a href="#" class="del" data-id="'+el.id+'" data-table="tag"><i class="fa fa-remove"></i>DELETE</a></li>\
        </ul>\
        </div>\
        </div>\
        </div>';
    });
    $('.tag-listing').html(html);
    $('.tag-listing').mCustomScrollbar();
}
//form reset
function restform(){
    $(".folder-listing,.tag-listing").mCustomScrollbar("destroy"); //First we have to destroy
    $('[data-toggle="tooltip"]').tooltip('destroy'); //  tooltip destroy
    $('.add-folder-form input[type="text"], .add-tag-form input[type="text"]').val('').removeClass('error');
    $(".folder-btn").val('Add Folder');
    $(".tag-btn").val('Add Tag');
}
//folder drop down list
function folder_drop_down_list(){
    var opt = '';
    opt = '<option value="0">All Funnels</option>';
    $(folder_data).each(function (index, el) {
        opt += '<option value="'+el.id+'">'+el.folder_name+'</option>';
    });
    $( '.folder-dropdown' ).html(opt);
    $(".folder-dropdown").val($("#folder_list").attr('data-folder'));
}
//tag drop down list
function tag_drop_down_list(){
    var opt = '';
    $(tag_data).each(function (index, el) {
        opt += '<option value="'+el.id+'"  '+selected(selected_tag_list,el.id)+'>'+el.tag_name+'</option>';
    });
    $( '.tag-drop-down' ).html(opt);
}
//after del,add,update,sorting values update
function values_update(){
    folder_drop_down_list();
    tag_drop_down_list();
    restform();
    window.id = window.index = is_present = 0;
    tooltip();
    folder_html_render();
    tag_html_render();
}
//drop down option selected function
function selected(v,m){
    var ret = '';
    if(typeof v === 'number') {

        if (v == m) {
            ret = 'selected';
        }
    }else{
        if(jQuery.inArray(m, v) !== -1) {
            ret = 'selected';
        }
    }
    return ret;
}
// tooltip
function tooltip(){
    $('.tag-tooltip').tooltip({
        container: '.lp-tag'
    });
}
//sorting folder list
function sorting_list(){
    folder_id_array = new Array();
    $('.sorting .folder-col').each(function(){
        folder_id_array.push($(this).data("id"));
    });
}
//set height of folder drop down till 4 options otherwise use the default height
function folder_drop_down_height(){
    var len = $(".folder-dropdown option").length-1;
    if(len <= 4)
    {
        var height = (len == 1)?54:len*47;
        $(".select2-dropdown").css({height: height});
        $(".za-folder-custom .select2-results__options").css({width:210});
    }else{
        $(".za-folder-custom .select2-results__options").css({width:200});
        $('.za-folder-custom .select2-results__options').niceScroll({
            background :"#009edb",
            cursorcolor:"#ffffff",
            cursorwidth: "7px",
            autohidemode:false,
            railalign:"right",
            railvalign:"bottom",
            railpadding: { top: 0, right: 0, left: -18, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #fff",
            cursorborderradius:"5px"
        });
        $(".select2-dropdown").css({height: 215});
    }
}

/**
 * tag remove hover
 */
function tagHoverRemover(){
    $(document).on({
        mouseenter: function(){
            var width = $(this)[0].clientWidth;
            $(this).css({'width':parseInt(width+20) });
            tagWindowPositionSet();
        },
        mouseleave: function(){
            var width = $(this)[0].clientWidth;
            $(this).css({'width':parseInt(width-20) });
            tagWindowPositionSet();
        }
    }, '.tag-result .select2-selection__choice');
}

/**
 * set tag window position left and top
 */
function tagWindowPositionSet(){
    $(".za-tag-custom").parent().css({
        top: $(".select2-search--inline")[0].offsetTop + $(".select2-search--inline")[0].offsetHeight,
        left: $(".select2-search__field")[0].offsetLeft-7
    });
}

/**
 * funnel name duplicate validation
 */
function funnelNameValidation(){
    var old_funnel_name = jQuery("#funnel_name").data('funnel-name').toLowerCase();
    var funnel_name = jQuery("#funnel_name").val().toLowerCase();
    if(funnel_name != '') {
        if(old_funnel_name != funnel_name)
        {
            var rec = jQuery.parseJSON(funnel_json);
            $(rec).each(function (index, el) {
                if (el.funnel_name != "" && el.funnel_name != null) {
                    if (funnel_name == parseHTML(el.funnel_name.toLowerCase())) {
                        $(".tag-section .tag-block label.error").text(duplicate_funnel_name_msg).show();
                        window.response = false;
                        return false;
                    } else {
                        $(".tag-section .tag-block label.error").text('');
                        window.response = true;
                    }
                }
            });
        }else{
            window.response = true;
        }
        }else {
        console.log('funnel name is empty');
        window.response = false;
    }
}
