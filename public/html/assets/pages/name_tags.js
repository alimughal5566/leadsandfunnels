(function($){
    window.id = window.index = window.table = is_present = '';
    // window.folder_data = jQuery.parseJSON(folder_list);
    // window.tag_data = jQuery.parseJSON(tag_list);
    var is_default = folder_id_array = '';
    window.selected_tag_list = new Array();


    var folder = $(".add-folder-form").validate({
        rules: {
            folder_name: {
                required: true,
                // stringvalid: true
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
                // $.ajax(
                //     {
                //         type : "POST",
                //         data: { hash: funnel_hash, id: id, is_default: is_default, folder_name: $("#folder_name").val(),_token:ajax_token },
                //         url : "/lp/tag/addfolder",
                //         dataType : "json",
                //         error: function (e) {
                //         },
                //         success : function(rsp) {
                //             if(rsp.response == 'added'){
                //                 notification.success('.folder-notifcations', '<strong>Success:</strong> Folder name has been added.');
                //             }
                //             else if(rsp.response == 'updated'){
                //                 notification.success('.folder-notifcations', '<strong>Success:</strong> Folder name has been updated.');
                //             }
                //             else if(rsp.response == 'error'){
                //                 notification.error('.folder-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.');
                //             }
                //             else if(rsp.response == 'logout'){
                //                 location.reload();
                //             }
                //             window.folder_data = jQuery.parseJSON(rsp.html);
                //         },
                //         complete :function(e){
                //             values_update();
                //         },
                //         cache : false,
                //         async : false
                //     });
            }
        }
    });
    var tag = $(".add-tag-form").validate({
        rules: {
            tag_name: {
                required: true,
                // stringvalid: true,
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
                // $.ajax(
                //     {
                //         type : "POST",
                //         data: { hash: funnel_hash, id: id, is_default: is_default, tag_name: $("#tag_name").val(),_token:ajax_token },
                //         url : "/lp/tag/addtag",
                //         dataType : "json",
                //         error: function (e) {
                //         },
                //         success : function(rsp) {
                //             if(rsp.response == 'added'){
                //                 notification.success('.tag-notifcations', '<strong>Success:</strong> Tag name has been added.');
                //             }
                //             else if(rsp.response == 'updated'){
                //                 notification.success('.tag-notifcations', '<strong>Success:</strong> Tag name has been updated.');
                //             }else if(rsp.response == 'error'){
                //                 notification.error('.tag-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.');
                //             }
                //             else if(rsp.response == 'logout'){
                //                 location.reload();
                //             }
                //             window.tag_data = jQuery.parseJSON(rsp.html);
                //         },
                //         complete :function(e){
                //             values_update();
                //         },
                //         cache : false,
                //         async : false
                //     });
            }
        }
    });
    var folder_tag = $(".name-tag-form").validate({
        rules: {
            funnel_name: {
                required: true,
                // stringvalid: true,
            }
        },
        messages: {
            funnel_name: {
                required: "Please enter the funnel name."
            }
        },
        submitHandler: function() {
            console.info("Submited");
        }
    });
    $(".set-tag-folder").validate({
        /*Now, no need to validation*/
        // rules: {
        //     tag_list: {
        //         required: true
        //     }
        // },
        // messages: {
        //     tag_list: {
        //         required: "Please select the tags."
        //     }
        // },
        // submitHandler: function() {
        //     $.ajax({
        //         type : "POST",
        //         data: { hash: funnel_hash, folder_list: $("#folder_list").val(),tag_list: $("#tag_list").val(),_token:ajax_token },
        //         url : "/lp/tag/savefunneltag",
        //         dataType : "json",
        //         error: function (e) {
        //         },
        //         success : function(rsp) {
        //             if(rsp.response == 'updated'){
        //                 notification.success('.funnel-notifcations', '<strong>Success:</strong> Name & Tags have been updated successfully.<br />');
        //                 selected_tag_list = new Array();
        //                 if($("#tag_list").val()) {
        //                     $($("#tag_list").val()).each(function(k,v){
        //                         selected_tag_list.push(parseInt(v));
        //                     });
        //                 }
        //             }
        //             else if(rsp.response == 'error'){
        //                 notification.error('.funnel-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.<br />');
        //             }
        //             else if(rsp.response == 'logout'){
        //                 location.reload();
        //             }
        //         },
        //         cache : false,
        //         async : false
        //     });
        // }
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
        // $.ajax(
        //     {
        //         type : "POST",
        //         data: { hash: funnel_hash, id: id, table: table,_token:ajax_token },
        //         url : "/lp/tag/delete",
        //         dataType : "json",
        //         error: function (e) {
        //         },
        //         success : function(rsp) {
        //             if(rsp.response == 'deleted'){
        //                 notification.success('.'+table+'-notifcations', '<strong>Success:</strong> '+new_str+' name has been deleted.');
        //             }
        //             else if(rsp.response == 'error'){
        //                 notification.error('.'+table+'-notifcations', '<strong>Error:</strong> Something went wrong. Please try again.');
        //             }
        //             else if(rsp.response == 'logout'){
        //                 location.reload();
        //             }
        //             $("#delete_folder").modal('hide');
        //             if(table == 'folder'){
        //                 window.folder_data = jQuery.parseJSON(rsp.html);
        //             }else{
        //                 window.tag_data = jQuery.parseJSON(rsp.html);
        //             }
        //         },
        //         complete :function(e){
        //             values_update();
        //         },
        //         cache : false,
        //         async : false
        //     });
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
            sorting_list();
        }
    });
    $(".btnAction_sort").on("click",function (){
        folder.resetForm();
        sorting_list();
        // $.ajax(
        //     {
        //         type : "POST",
        //         data: { hash: funnel_hash,folder_ids: folder_id_array,_token:ajax_token },
        //         url : "/lp/tag/savesorting",
        //         dataType : "json",
        //         error: function (e) {
        //         },
        //         success : function(rsp) {
        //             if(rsp.response == 'updated'){
        //                 notification.success('.folder-notifcations', '<strong>Success:</strong> Sorting has been updated.');
        //                 window.folder_data = jQuery.parseJSON(rsp.html);
        //                 values_update();
        //             }
        //             else if(rsp.response == 'logout'){
        //                 location.reload();
        //             }
        //         },
        //         cache : false,
        //         async : false
        //     });
    });



    $('.add-folder').on('hidden.bs.modal', function (e) {
        values_update();
       folder.resetForm();
       tag.resetForm();
    });
    $('#delete_folder').on('hidden.bs.modal', function (e) {
        $("body").addClass('modal-open');
    });

    $('.modal-opener').click(function() {
        $('body').addClass('modal-tags-open');
    });

    $('#add-tag .button-cancel, #add-folder .button-cancel').click(function() {
        $('body').removeClass('modal-tags-open');
    });
    /*$('#add-tag').on('hidden.bs.modal', function (e) {
        $('body').removeClass('modal-tags-open');
    });*/
    // $(document).on("click",".show_nav",function (){
    //     $(".show_nav").show();
    //     $(".action_nav").hide();
    //     $(this).hide().next(".action_nav").show();
    // });
    $('.lp-btn-save-folders').click(function () {
        if (window.location.href.indexOf("funnel-question.php") > -1) {
            $('.modal').modal('hide');
            $('#create-funnel').modal('show');
        }
    });
    $('.lp-btn-save-folders').click(function () {
        if (window.location.href.indexOf("funnel-question.php") > -1) {
            $('.modal').modal('hide');
            $('#create-funnel').modal('show');
        }
    });
    $(".edit-folder-popup").on("click",function (){
        $('.modal').modal('hide');
        $('#add-folder').modal('show');
        $('.el-tooltip').tooltipster('hide');
        values_update();
    });
    $(".edit-tag-popup").on("click",function (){
        $('.modal').modal('hide');
        $('#add-tag').modal('show');
        $('.el-tooltip').tooltipster('hide');
        values_update();
    });
    $(document).on("click",".edit-folder",function (e){
        e.preventDefault();
        id =  $(this).attr('data-id');
        index =  $(this).attr('data-index');
        var value = $(this).parents('.folder-col').find('.folder-name').text();
        $(".folder-btn").val('Update Folder');
        $(".folder-btn").addClass('update-folder');
        $("#folder_name").val(value).focus();
        //folder.resetForm();
    });
    $(document).on("click",".update-folder",function (e){
        e.preventDefault();
        var name = $('#folder_name').val();
        console.info(name);
        var value = $(this).parents().find('.folder-col[data-id='+id+']').find('.folder-name').text(name);
        console.info(value);
        $('#folder_name').val('');
        $(".folder-btn").val('ADD Folder');
        $(".folder-btn").removeClass('update-folder');
    });
    $(document).on("click",".edit-tag",function (){
        id =  $(this).data('id');
        index =  $(this).data('index');
        var r =   tag_data[index].tag_name;
        $(".tag-btn").val('Update Tag');
        $("#tag_name").val(r).focus();
        tag.resetForm();
    });
    $(document).on("click",".del",function (){
        id =  $(this).data('id');
        table =  $(this).data('table');
        if(table == 'folder'){
            $("#delete_folder h3").text('Delete Folder');
            $("#delete_folder .modal-msg").text('Are you sure to delete this folder?');

        }else{
            $("#delete_folder h3").text('Delete Tag');
            $("#delete_folder .modal-msg").text('Are you sure to delete this tag?');
        }
        $("#add-tag").modal('hide');
        $("#add-folder").modal('hide');
        $("#delete_folder").modal('show');
    });
    selected_tag_list =  $(".tag-result").data('tags');
    // folder_drop_down_list();
    // tag_drop_down_list();




    //
    // $('.el-tooltip').tooltip();

    var amIclosing = false;
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

})(jQuery);
//folder popup html render
function folder_html_render(){
    var html = '';
    $(folder_data).each(function (index, el) {
        html += '<div class="folder-col" data-id="'+el.id+'">\
            <div class="row">\
            <div class="col-sm-6"><h4>'+el.folder_name+'</h4></div>\
        <div class="col-sm-6" align="right" style="padding: 0px;">\
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
    $(".folder-listing").mCustomScrollbar({
        mouseWheel:{ scrollAmount: 80}
    });
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
    $('.tag-listing').mCustomScrollbar({
        mouseWheel:{ scrollAmount: 80}
    });
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
    opt = '<option value="0">All Funnels</option>';
    $(folder_data).each(function (index, el) {
        opt += '<option value="'+el.id+'" '+selected($("#folder_list").data('folder'),el.id)+'>'+el.folder_name+'</option>';
    });
    $( '.folder-dropdown' ).html(opt);
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
    $(".folder-listing,.tag-listing").mCustomScrollbar("destroy"); //First we have to destroy
    // $('[data-toggle="tooltip"]').tooltip('destroy'); //  tooltip destroy
    //folder_html_render();
    //tag_html_render();
    //folder_drop_down_list();
    //tag_drop_down_list();
    restform();
    window.id = window.index = is_present = 0;
    // tooltip();
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


//sorting folder list
function sorting_list(){
    folder_id_array = new Array();
    $('.sorting .folder-col').each(function(){
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
jQuery(document).ready(function () {
   jQuery('body').addClass('name-tags');
});
