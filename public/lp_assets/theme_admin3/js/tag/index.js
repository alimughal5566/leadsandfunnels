var global = { submit : false };
var amIclosing = false;
var isSort = false;
let funnelTag = [];
function set_folder_dropdown(){
    $('.select2__folder').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__folder-parent')
    }).on('select2:openning', function() {
        jQuery('.select2__folder-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2__folder-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__folder-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__folder-parent .select2-dropdown').hide();
        jQuery('.select2__folder-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__folder-parent .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__folder-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('.select2__folder').find(':selected').index();
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
            jQuery('.select2__folder-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2__folder').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2__folder-parent .select2-selection__rendered').show();
        jQuery('.select2__folder-parent .select2-results__options').css('pointer-events', 'none');
    });
}
jQuery(document).ready(function (e) {
    set_folder_dropdown();
    ajaxRequestHandler.init(".name-tag-form", {
        customFieldChangeCb: onChangeTagListHandleButton
    });
    funnelTag = $('#tag_list').val().map(i=>Number(i)).sort();
});



(function($){
    var id = '', index = '', table = '', is_present = '';
    var  is_edit = 0;
    var folder_data = jQuery.parseJSON(folder_list);
    var tag_data = tag_dropdown;
    // folder_data = folder_data.sort(function(a, b) {
    //     return b.id - a.id;
    // });
    var is_default = folder_id_array = is_sorted  = '';

    var folder = $(".add-folder-form").validate({
        rules: {
            folder_name: {
                required: true,
                stringvalid: true
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
                var message = 'Folder name already exists in the list.';
                displayAlert("danger", message);
                is_present = 1;
            }
            else if($("#folder_name").val().toLowerCase() === 'website funnels'){
                displayAlert('danger', 'Folder name "Website Funnels" is not allowed.');
                is_present = 1;
            }
            if(is_present == 0){
                sorting_list();
                if(is_sorted > 1) {
                    folder_id_array = folder_id_array;
                }
                else{
                    folder_id_array = '';
                }
                if(id){
                    is_default = folder_data[index].is_default;
                }else{
                    is_default = 0;
                }
                $.ajax(
                {
                    type : "POST",
                    data: { hash: funnel_hash, id: id, is_default: is_default, folder_name: $("#folder_name").val(),order: $(".sorting .folder-col").length,folder_ids: folder_id_array,_token:ajax_token },
                    url : "/lp/tag/addfolder",
                    dataType : "json",
                    error: function (e) {
                    },
                    success : function(rsp) {
                        if(rsp.response == 'added'){
                            var message = 'Folder name has been added.';
                            displayAlert("success", message);
                        }
                        else if(rsp.response == 'updated'){
                            var message = 'Folder name has been updated.';
                            displayAlert("success", message);
                        }
                        else if(rsp.response == 'error'){
                            var message = 'Something went wrong. Please try again.';
                            displayAlert("danger", message);
                        }
                        else if(rsp.response == 'logout'){
                            location.reload();
                        }
                        folder_data = jQuery.parseJSON(rsp.html);
                        hasWebsite = rsp.hasWebsite;
                        // folder_data = jQuery.parseJSON(rsp.html).sort(function(a, b) {
                        //     return b.id - a.id;
                        // });
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
    var tag = $(".add-tag-form").validate({
        rules: {
            tag_name: {
                required: true,
                stringvalid: true,
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
                displayAlert('warning', 'Tag name already exists in the list.');
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
                        tag_dropdown  = jQuery.parseJSON(rsp.html);
                        tag_data = jQuery.parseJSON(rsp.html);
                        if(rsp.response == 'added'){
                            var message = 'Tag name has been added.';
                            displayAlert('success', message);
                        }
                        else if(rsp.response == 'updated'){
                            is_edit = 1;
                            $(".folder-col[data-id='"+id+"'] .tag-col").find('h4').html($("#tag_name").val());
                            var message = 'Tag name has been updated.';
                            displayAlert('success', message);
                        }else if(rsp.response == 'error'){

                            var message = 'Something went wrong. Please try again.';
                            displayAlert('danger', message);
                        }
                        else if(rsp.response == 'logout'){
                            location.reload();
                        }

                    },
                    complete :function(e){
                        values_update();
                        lpUtilities.tag_drop_down_list(1,2);
                    },
                    cache : false,
                    async : false
                });
            }
        }
    });
    $(".name-tag-form").validate({
        rules: {
            funnel_name: {
                required: true
            },
            "tag_list[]": {
                required: true
            }
        },
        messages: {
            funnel_name: {
                required: "Please enter the funnel name."
            },
            "tag_list[]": {
                required: "Please add at least one tag."
            }
        },
        submitHandler: function() {
            var response = funnelNameValidation();
            if(response) {
                ajaxRequestHandler.submitForm(function (response, isError) {
                    if(response.status) {
                        $('.funnel-active').html($.trim($('#funnel_name').val()));
                        $('.funnel-name').html($.trim($('#funnel_name').val()));
                        $('.funnel-name').tooltipster('content', $.trim($('#funnel_name').val()));
                        loadFunnel();
                        $(".top-header-funnel").topHeaderFunnelLoader();
                        let data = response.result;
                        if (data._tags !== undefined) {
                            jQuery(".tag-result").data('tags', data._tags);
                            funnelTag = data._tags.map(i => Number(i)).sort();
                            window.selected_tag_list = funnelTag;
                        }

                        //when a new tag is added
                        if (data._new_tags !== undefined && Object.keys(data._new_tags).length > 0) {
                            let _tag_list = JSON.parse(window.tag_list);
                            jQuery.each(data._new_tags, function (id, name) {
                                id = parseInt(id);
                                _tag_list.push({ id: id, tag_name: name, client_id: parseInt(site.clientID), is_default: 0});
                                $('#tag_list option[value="new_'+ name +'"]').val(id);
                            });
                            // updating dropdown
                            window.tag_list = JSON.stringify(_tag_list);
                            window.tag_dropdown = _tag_list;
                            lpUtilities.tag_drop_down_list(2,2);
                            if(typeof tagsDisable === "function") {
                                tagsDisable();
                            }
                        }
                    }
                });
            }
        }
    });

    $(document).on('click','#main-submit',function(e){
        global.submit = true;
        var $form = $('.name-tag-form');
        $form.submit();
    });


    jQuery.validator.addMethod("stringvalid", function(value, element) {
        if(/^[a-zA-Z0-9-_\s]+$/.test(value)) {
            return true;
        }else{
            return false;
        }
    }, 'Special characters are not allowed.');

    $(document).on("click","#delete",function (){
        new_str = table.toLowerCase().replace(/\b[a-z]/g, function(txtVal) {
            return txtVal.toUpperCase();
        });
        displayToastAlert('loading', 'Please Wait... Processing your request...',0);
        setTimeout( function () {
            $.ajax(
                {
                    type : "POST",
                    data: { hash: funnel_hash, id: id, table: table,_token:ajax_token },
                    url : "/lp/tag/delete",
                    dataType : "json",
                    error: function (e) {
                    },
                    success : function(rsp) {
                        $(".ct-group").html('');
                        if(rsp.response == 'deleted'){
                            loadFunnel();
                            var message = new_str+' name has been deleted.';
                            displayAlert('success', message);
                        }
                        else if(rsp.response == 'error'){

                            var message = 'Something went wrong. Please try again.';
                            displayAlert('danger', message);
                        }
                        else if(rsp.response == 'logout'){
                            location.reload();
                        }
                        $("#delete_folder").modal('hide');
                        if(table == 'folder'){
                            folder_data = jQuery.parseJSON(rsp.html);
                            $("#add-folder").modal('show');
                        }else{
                            $(".folder-col[data-id='"+id+"']").remove();
                            is_edit = 1;
                            $("#add-tag").modal('show');
                        }

                    },
                    complete :function(e){
                        values_update();
                    },
                    cache : false,
                    async : false
                });
        },200);

    });
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
            isSort = true;
            sorting_list();
        }
    });
    $(".btnAction_sort").on("click",function (e){
        e.preventDefault();
        folder.resetForm();
        sorting_list();
        if(isSort) {
            $.ajax(
                {
                    type: "POST",
                    data: {hash: funnel_hash, folder_ids: folder_id_array, _token: ajax_token},
                    url: "/lp/tag/savesorting",
                    dataType: "json",
                    error: function (e) {
                    },
                    success: function (rsp) {
                        if (rsp.response == 'updated') {
                            isSort = false;
                            let message = 'Sorting has been updated.'
                            displayAlert("success", message);
                            folder_data = jQuery.parseJSON(rsp.html);
                            values_update();
                        } else if (rsp.response == 'logout') {
                            location.reload();
                        }
                        $("#add-folder").modal('hide');
                    },
                    cache: false,
                    async: false
                });
        }
    });

    $('.add-folder').on('hidden.bs.modal', function (e) {
        // values_update();
       folder.resetForm();
       tag.resetForm();
    });

    $(".edit-folder-popup").on("click",function (){
        $('.modal').modal('hide');
        $('#add-folder').modal('show');
        values_update();
    });
    $(".edit-tag-popup").on("click",function (){
        $('.modal').modal('hide');
        $('#add-tag').modal('show');
        values_update();
    });
    $(document).on("click",".edit-folder",function (){
        id =  $(this).data('id');
        index =  $(this).data('index');
        var r =   folder_data[index].folder_name;
        $(".folder-btn").val('Update Folder');
        $("#folder_name").val(r).focus();
        folder.resetForm();
    });
    $(document).on("click",".edit-tag",function (){
        id =  $(this).data('id');
        index =  $(this).data('index');
        var r = $(".folder-col[data-id='"+id+"'] .tag-col").find('h4').html();
        $(".tag-btn").val('Update Tag');
        $("#tag_name").val(r).focus();
        tag.resetForm();
    });
    $(document).on("click",".del",function (){
        id =  $(this).data('id');
        table =  $(this).data('table');
        if(table == 'folder'){
            $(".delete-tag-notification p").html('Are you sure you want to delete this folder?');
        }
        else{
            $(".delete-tag-notification p").html('Are you sure you want to delete this tag?');
        }
            $(".tag-col").slideDown();
            $(".funnel__action").slideUp();
            $(".folder-col[data-id='"+id+"'] .tag-col").slideUp();
            $(".folder-col[data-id='"+id+"'] .funnel__action").slideDown();
    });
    $(document).on('click','.delete-cancel', function (){
        $(".tag-col").slideDown();
        $(".funnel__action").slideUp();
    });


    selected_tag_list =  $(".tag-result").data('tags');
    folder_drop_down_list();
    lpUtilities.tag_drop_down_list();

    //folder popup html render
    function folder_html_render(){
        var html = '';
        $(folder_data).each(function (index, el) {

            html +=
            '<div class="folder-col" data-id="'+el.id+'" data-order="'+el.order+'">\
               <div class="tag-col"> <div class="folder-inner"><div class="col">\
                    <h4>'+el.folder_name+'</h4>\
                </div>\
                <div class="col">\
                    <div class="action action_options">\
                        <ul class="action__list">\
                            <li class="action__item">\
                                <a href="#" class="action__link move" data-id="'+el.id+'" data-index="0">\
                                    <span class="ico ico ico-dragging"></span>MOVE\
                                </a>\
                            </li>\
                            <li class="action__item">\
                                <a href="#" class="action__link edit-folder" data-id="'+el.id+'" data-index="'+index+'">\
                                    <span class="ico ico-edit"></span>EDIT\
                                </a>\
                            </li>';

            if(el.is_default == 0){
                html +=
                            '<li class="action__item">\
                                <a href="#" class="action__link del" data-id="'+el.id+'" data-table="folder">\
                                    <span class="ico ico-cross"></span>DELETE\
                                </a>\
                            </li>';
            }

            html +=
                        '</ul>\
                        <ul class="action__list">\
                            <li class="action__item">\
                                <i class="fa fa-circle" aria-hidden="true"></i>\
                                <i class="fa fa-circle" aria-hidden="true"></i>\
                                <i class="fa fa-circle" aria-hidden="true"></i>\
                            </li>\
                        </ul>\
                    </div>\
                </div></div></div>';
            html += confirmationAlert();
            html +='</div>';

        });
        $( '.folder-listing .sorting' ).html(html);
        $(".folder-listing").mCustomScrollbar({
            mouseWheel:{
                scrollAmount: 80
            }
        });
    }

    //tag popup html render
    function tag_html_render(){
        var html = '';
        if(tag_data && is_edit == 0) {
            $(tag_data).each(function (index, el) {

                html +=
                    '<div class="folder-col" data-id="' + el.id + '">\
                <div class="tag-col"><div class="folder-inner"><div class="col">\
                    <h4>' + el.tag_name + '</h4>\
                </div>\
                <div class="col">\
                    <div class="action action_options">\
                        <ul class="action__list">\
                            <li class="action__item">\
                                <a href="#" class="action__link edit-tag" data-id="' + el.id + '" data-index="' + index + '">\
                                    <span class="ico ico-edit"></span>edit\
                                </a>\
                            </li>\
                            <li class="action__item">\
                                <a href="#" class="action__link del" data-id="' + el.id + '" data-table="tag">\
                                    <span class="ico ico-cross"></span>delete\
                                </a>\
                            </li>\
                        </ul>\
                        <ul class="action__list">\
                            <li class="action__item">\
                                <i class="fa fa-circle" aria-hidden="true"></i>\
                                <i class="fa fa-circle" aria-hidden="true"></i>\
                                <i class="fa fa-circle" aria-hidden="true"></i>\
                            </li>\
                        </ul>\
                    </div>\
                </div></div></div>';
                html += confirmationAlert();
                html +='</div>';

            });

            $('.tag-listing').html(html);
            $('.tag-listing').mCustomScrollbar({
                mouseWheel: {scrollAmount: 80}
            });
        }
    }

    //form reset
    function restform(){
        $('.add-folder-form input[type="text"], .add-tag-form input[type="text"]').val('').removeClass('error');
        $(".folder-btn").val('Add Folder');
        $(".tag-btn").val('Add Tag');
    }
    //folder drop down list
    function folder_drop_down_list(){
        var opt = '';
        let data = folder_data;
        if(hasWebsite == 0){
            data  = folder_data.filter(function( obj ) {
                return obj.is_website !== 1;
            });
        }
        $(data).each(function (index, el) {
            opt += '<option value="'+el.id+'" '+lpUtilities.isSelected($("#folder_list").data('folder'),el.id)+'>'+el.folder_name+'</option>';
        });
        $( '.folder-dropdown' ).html(opt);
    }

    function populate_tag_popup(){
        $(".tag-listing").mCustomScrollbar("destroy"); //First we have to destroy
        tag_html_render();
        tagsDisable();
        restform();
        id = index = is_present = 0;
    }

    function populate_folder_popup(){
        $(".folder-listing").mCustomScrollbar("destroy"); //First we have to destroy
        folder_html_render();
        folder_drop_down_list();
        restform();
        id = index = is_present = 0;
    }

    //after del,add,update,sorting values update
    function values_update(){
        populate_tag_popup();
        populate_folder_popup();
    }

    //sorting folder list
    function sorting_list(){
        folder_id_array = new Array();
        is_sorted = 0;
        $('.sorting .folder-col').each(function(){
            if($(this).data("order") == 0){
                is_sorted++;
            }
            folder_id_array.push($(this).data("id"));
        });
    }
    //set height of folder drop down till 4 options otherwise use the default height
    function folder_drop_down_height(){
        var len = $(".folder-dropdown option").length;
        if(len <= 4)
        {
            var height = (len == 1)?54:len*46;
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
            $(".select2-dropdown").css({height: 220});
        }
    }

    $('#funnel_name').on('change', function() {
        $(this).addClass('changed');
    });
    $('#tag_list').on('change', function() {
        $(this).addClass('changed');
            // preSave();
    });
    $('#folder_list').on('change', function() {
        $(this).addClass('changed');
    });

    /* Abubakar added this code to fix point A30-1790 */
    $('.modal-opener').click(function() {
        $('body').addClass('modal-tags-open');
    });

    $('#add-tag .button-cancel, #add-folder .button-cancel').click(function() {
        $('body').removeClass('modal-tags-open');
    });

    /**
     * funnel name unique validation method use for jquery vailator
     */
    $("#funnel_name").on('blur',function(){
        funnelNameValidation();
    });

    /*
      * Adding this for sorting of tags A - Z and Z - A
    */

    $(document).on('click','.tag-sort',function(e){
        $('.tag-sort').removeClass('active');
        let sort = $(this).addClass('active').data('sort');
        tag_data.sort(function(a, b) {
            a = a.tag_name.toLowerCase();
            b = b.tag_name.toLowerCase();
            if(sort == 'asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
        values_update();
    });

})(jQuery);

function displaySuccessMessage(){
    var funnel_name = $('#funnel_name').hasClass('changed');
    var tag_list = $('#tag_list').hasClass('changed');
    var folder_list = $('#folder_list').hasClass('changed');
    var message = '';
    if($('.changed').length==3 || (folder_list) ){
        message = 'Information has been updated.';
    }
    else if(funnel_name && tag_list){
            message = 'Funnel name & tags have been updated.';
    }
    else if(tag_list){
        message = 'Tags have been updated.';
    }
    else if (funnel_name){
        message = 'Funnel name has been updated.';
    }else{
        message = 'Information has been updated.';
    }

    displayAlert("success", message);

    $('#funnel_name').removeClass('changed');
    $('#tag_list').removeClass('changed');
    $('#folder_list').removeClass('changed');
}

function confirmationAlert(){
     return '<div class="funnel__action delete-tag-notification">' +
        '                                    <div class="gl-funnel__item gl-funnel__item_confirmation">' +
        '                                        <p></p>' +
        '                                        <ul class="control">' +
        '                                            <li class="control__item">' +
        '                                                <a href="javascript:void();" id="delete">Yes</a>' +
        '                                            </li>' +
        '                                            <li class="control__item">' +
        '                                                <a href="javascript:void();" class="delete-cancel">No</a>' +
        '                                            </li>' +
        '                                        </ul>' +
        '                                    </div>' +
        '</div>';
}

/**
 * funnel name duplicate validation
 */
function funnelNameValidation(){
    var old_funnel_name = jQuery("#old_funnel_name").val().toLowerCase();
    var funnel_name = jQuery("#funnel_name").val().toLowerCase();
    if(funnel_name != '') {
        if(old_funnel_name != funnel_name)
        {
            var rec = jQuery.parseJSON(funnel_json);
            rec =  rec.find(function(el){
                if (el.funnel_name != "" && el.funnel_name != null) {
                    return funnel_name == parseHTML(el.funnel_name.toLowerCase());
                    }
                }
              );
             if(rec) {
                 if($(".ct-group").length > 0) {
                     $(".ct-group").html('');
                 }
                 displayAlert('danger', 'Name is already used by an existing funnel try again.');
                 return false;
             }
             else{
                 return true;
             }
        }else{
            return true;
        }
    }else {
        return false;
    }
}

/**
 * this function compare the last save value with new values.
 * if new values and last saved value did not match then will be save btn enable otherwise btn will disable.
 */
function onChangeTagListHandleButton(disabled) {
    if(!disabled) {
        return disabled;
    }

    let tags = $('#tag_list').val().map(i => Number(i)).sort();
    if (tags.length != funnelTag.length) {
        return false;
    }
    return ajaxRequestHandler.isEquals(tags, funnelTag);
}
