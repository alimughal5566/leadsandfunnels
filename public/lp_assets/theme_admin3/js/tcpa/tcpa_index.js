jQuery(document).ready(function () {

    var tcpa_list = jQuery.parseJSON(tcpa_records);
    var tcpa_list_db =jQuery.parseJSON(tcpa_records);
    var tcpa_list_edit =jQuery.parseJSON(tcpa_records);
    window.tcpa_list_db =tcpa_list_db;
    window.tcpa_list_edit =tcpa_list_edit;
    window.tcpa_list = tcpa_list;
    window.tcpa_data = tcpa_list;
    window.tcpa_search_data = tcpa_list;
    $('body').addClass('tcpa-page');

    $(document).on("change",'input[name="tcpa-message"]', function () {
        var id = $(this).attr('data-id');
        if ($(this).is(':checked') && $(this).val() == 'on') {
            $("#toggle_tcpa_message_id").val(id);
            $('input[name="tcpa-message"]').prop('checked',false);
            $(this).prop('checked',true)
            changeToglle(true,id);
            // alert(id);
        }else{
            changeToglle(false,id);
        }
        enableDisableSaveButton();
    });

    changeToglle= function (toggle, id){
        if(toggle == false)
        {
            $(tcpa_list_edit).each(function(){
                if(this.id == id){
                    this.is_active = 0;
                }
            })
        }else{
            $(tcpa_list_edit).each(function(){
                if(this.id == id){
                    this.is_active = 1;
                }else{
                    this.is_active = 0;
                }
            })
        }
    };
    enableDisableSaveButton= function (){
        let isChanged = ajaxRequestHandler.isEquals(tcpa_list_db, tcpa_list_edit);
        setTimeout(function (){
            if(!isChanged){
                $('#main-submit').prop('disabled', false);
            }else{
                $('#main-submit').prop('disabled', true);
            }
        },50)
    };
    $(document).on('click','[data-delete-tcpa]',function (){
        let id= $(this).data('id');
        $('[data-delete-yes]').attr('data-id',id);
    });

    var ajaxToggleHandler = Object.assign({}, ajaxRequestHandler);
    ajaxToggleHandler.init('#toggleMessageForm', {
        autoEnableDisableButton: false,
    });

    ajaxToggleHandler.setActiveLoadingToastMessage(true);
    $("#main-submit").click(function (e) {
        ajaxToggleHandler.submitForm(function (response, isError) {
            console.log("ajaxToggleHandler callback...");
        }, true);
    });

    // Delete TCPA FORM
    var ajaxDeleteHandler = Object.assign({}, ajaxRequestHandler);
    ajaxDeleteHandler.init('#deleteMessageForm', {
        autoEnableDisableButton: false,
        submitButton: ".lp-table_yes"
    });

    bindCtaEvents = function () {
        let delLinkElem = $('.remove-tcpa'),
            delConfirmationNoElem = $('.lp-table_no'),
            delConfirmationYesElem = $('.lp-table_yes');

        delLinkElem.click(function (e) {
         //   debugger;
            e.preventDefault();
            var elem = $(this);

            $(this).parents('.lp-table-item').find('.lp-table__list').slideUp();
            $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideDown();
            $('#del_tcpa_message_id').val(elem.data('id'));
           // $('#del_client_id').val(elem.data('clientid'));
            $('.lp-table_yes').attr('data-id', elem.data('id'));
            $('.lp-table_yes').attr('data-clientid', elem.data('clientid'));
        });

        delConfirmationYesElem.click(function (e) {
            deleteProcess();
        });

        delConfirmationNoElem.click(function(){
            $(this).parents('.lp-table-item').find('.lp-table__list').slideDown();
            $(this).parents('.lp-table-item').find('.lp-table__item-msg').slideUp();
        });

    };

    deleteProcess =function () {
        var id = $(".lp-table_yes").attr('data-id');
        var clientid = $(".lp-table_yes").attr('data-clientid');

        $('#del_tcpa_message_id').val(id);
      //  $('#del_client_id').val(clientid);
        // $('#deleteRecipientForm').submit();
        ajaxDeleteHandler.submitForm(function (response, isError) {
            console.log("deleted lead alert callback...");
            if(response.status == true || response.status == 'true') {
                $('[data-delete-yes]').removeAttr('data-id');
                $('#tcpa-message-confirmation').modal('hide');
                $('#modal_delete_domain ._delete_btn').removeAttr('data-id');
                $('#modal_delete_domain ._delete_btn').removeAttr('data-clientid');
                $("#rcp_" + id).parents('.tcp-message-data').remove();
                var index_deleted = tcpa_search_data.findIndex(x => x.id === parseInt(id));
                console.log(id,index_deleted)
                tcpa_search_data.splice(index_deleted, 1);
                var index_deleted_db = tcpa_list_db.findIndex(x => x.id === parseInt(id));
                tcpa_list_db.splice(index_deleted, 1);
                tcpa_list_edit.splice(index_deleted, 1);
                console.log("#rcp_" + id + " parent div will be deleted");
                enableDisableSaveButton();
            }
        }, true);
    };

    bindCtaEvents();

     tcpaSroting =function(){
        let sort  = $('.tcpa-name-sort.active').data('sort');
         tcpa_search_data.sort(function(a, b) {
            a = a['tcpa_title'].toLowerCase();
            b = b['tcpa_title'].toLowerCase();
            if(sort == 'name-asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
    };

    $.fn.tcpaHeaderLoader = function () {
        var html = '';
        if(tcpa_search_data !== null && tcpa_search_data.length > 0) {
            $(".lp-table__body").empty();
            var i = 0;
            $(tcpa_search_data).each(function (index, el) {
                i++;
                var tcpa_url =site.baseUrl+site.lpPath+"/popadmin/tcpa-edit"+"/"+funnel_hash+"/"+el.id;
                var is_checked = "";
                if(el.is_active == 1)
                {
                    is_checked = "checked";
                }
                if(funnel_hash== el['hash']){
                    is_active = 'funnel-active';
                }

                    html += '<div class="lp-table-item tcp-message-data">'+
                        '<ul class="lp-table__list" id="rcp_'+el.id+'">'+
                        '        <li class="lp-table__item">' +
                        '             <span class="text-wrap">'+el.tcpa_title+'</span>' +
                        '        </li>' +
                        '        <li class="lp-table__item">'+
                        '             <span class="text-wrap">'+el.date_added+'</span>'+
                        '        </li>'+
                        '        <li class="lp-table__item">' +
                        '              <div class="action">' +
                        '                   <div class="action-wrap">' +
                        '                         <ul class="action__list">' +
                        '                               <li class="action__item">' +
                        '                                    <i class="fa fa-circle" aria-hidden="true"></i>'+
                        '                                    <i class="fa fa-circle" aria-hidden="true"></i>' +
                        '                                    <i class="fa fa-circle" aria-hidden="true"></i>' +
                        '                               </li>'+
                        '                          </ul>' +
                        '                          <ul class="options-btns">' +
                        '                               <li class="edit">' +
                        '                                    <a href="'+tcpa_url+'" class=" action__link el-tooltip" ' +
                        '                                         title="edit message" ><i class="ico-edit"></i></a>' +
                        '                               </li>' +
                        '                               <li class="remove">' +
                        '                                    <a href="#" data-target="#tcpa-message-confirmation" data-toggle="modal" data-id="'+el.id+'"' +
                        '                                        data-clientid="'+el.tcpa_title+'" class="el-tooltip" data-delete-tcpa'+
                        '                                        title="delete"> <i class="ico-cross"></i></a>' +
                        '                               </li>'+
                        '                          </ul>'+
                        '                   </div>'+
                        '                   <div class="tcpa-radio-btn">'+
                        '                         <label class="radio-label">'+
                        '                              <input class="field-label" data-id="'+el.id+'" name="tcpa-message" id="tcpa-message-toggle" type="checkbox" '+is_checked+'  data-form-field>'+
                        '                              <span class="radio-area"><span class="handle"></span></span>'+
                        '                         </label>'+
                        '                   </div>'+
                        '              </div>'+
                        '        </li>'+
                        '   </ul>'+
                        ' </div>'+
                        '</div>';
                    $(".lp-table__body").html(html);
                    lpUtilities.globalTooltip();
            });
        }
    };

    tcpaSroting();
    $(".lp-table__body").tcpaHeaderLoader();
    $(document).on('click','.tcpa-name-sort',function(e){
        $('.tcpa-date-sort').removeClass('active');
        $('.tcpa-name-sort').removeClass('active');
        $(this).addClass('active');
        tcpaSroting();
        $(".lp-table__body").tcpaHeaderLoader();
    });
    /*
    * Adding this for sorting of TCPA with created at date
  */

    $(document).on('click','.tcpa-date-sort',function(e){
        $('.tcpa-date-sort').removeClass('active');
        $('.tcpa-name-sort').removeClass('active');
        let sort = $(this).addClass('active').data('sort');
        if(sort === 'date-asc') {
            tcpa_search_data.sort(function(a,b){
                return new Date(a.date_added) - new Date(b.date_added);
            });
        }else{
            tcpa_search_data.sort(function(a,b){
                return new Date(b.date_added) - new Date(a.date_added);
            });
        }
        $(".lp-table__body").tcpaHeaderLoader();
    });
});
