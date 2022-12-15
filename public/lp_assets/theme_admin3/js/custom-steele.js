/**
 * Created by root on 6/13/17.
 */
/*
  * Displays Alert message
  * @param type  = success | danger | warning
  * @param message = message to display
  * @param hideAfter = hide after {seconds} or 0 for disable auto hiding
  * */
function displayAlert(type, message, hideAfter=null) {
    // let htmlMessage = '';
    switch (type){
        case 'success':
            return lptoast.cogoToast.success(message, { position: 'top-center', heading: 'Success',  onClick: () => {
                    hide();
                }});
            //htmlMessage = `<div class="alert alert-success" id="custom-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Success:</strong> <span>${message}</span></div>`;
            break;
        case 'danger':
            return lptoast.cogoToast.error(message, { position: 'top-center', heading: 'Error' ,  onClick: () => {
                    hide();
                }});
            //htmlMessage = `<div class="alert alert-danger" id="custom-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Error:</strong> <span>${message}</span></div>`;
            break;
        case 'warning':
            return lptoast.cogoToast.warn(message, { position: 'top-center', heading: 'Warning' ,  onClick: () => {
                    hide();
                }});
            //htmlMessage = `<div class="alert alert-warning" id="custom-alert" ><button type="button" class="close" data-dismiss="alert">x</button><strong>Warning! </strong><span>${message}</span></div>`;
            break;
        case 'info':
            return lptoast.cogoToast.info(message, { position: 'top-center', heading: 'Information' ,  onClick: () => {
                    hide();
                }});
            //htmlMessage = `<div class="alert alert-info" id="custom-alert" ><button type="button" class="close" data-dismiss="alert">x</button><span>${message}</span></div>`;
            break;
        case 'loading':
            let options = { position: 'top-center', heading: 'Information' ,  onClick: () => {
                    hide();
                } };
            if(hideAfter!=null){
               options = { position: 'top-center', heading: 'Please wait...', hideAfter:hideAfter ,  onClick: () => {
                       hide();
                   }};
            }
            return lptoast.cogoToast.loading(message, options);
            //htmlMessage = `<div class="alert alert-info" id="custom-alert" ><button type="button" class="close" data-dismiss="alert">x</button><span>${message}</span></div>`;
            break;
    }

    // After toast messages we don't need below code
    /*
    goToByScroll("msg");
    $("#msg").html(htmlMessage).
    fadeTo(3000, 500).slideUp("slow", function(){
        $("#custom-alert").slideUp("slow");
    });
    */
}

function displayToastAlert(type, message, hideAfter=null) {
    if($(".ct-toast").length > 0) {
        setTimeout(displayAlert, 2200, type, message, hideAfter);
    } else {
        displayAlert(type, message, hideAfter)
    }

}

let formSubmitting = false;
var _list = {};
jQuery(document).ready(function (e) {
    window.copy_key = 1;

// JS starts here
    jQuery('html').removeClass('noscroll');

    AddValidatorCustomMethods();
    initAutoViewTrainingLibrary();
    FunnelStatusHandler.init();
    $('body').addClass('super_banner_body');
   if($(window).width() < 981){
        $('.super_banner__headline').addClass('super_banner__headline_medium');
        $('.super_banner__btn').addClass('btn--extra-small__medium');
        $('.super_banner__close').addClass('super_banner__close_medium');
        $('body').addClass('super-header-padding-t70');

   }
    if($(window).width() < 979){
        $('body').removeClass('super_banner_body');
        $('body').removeClass('super-header-padding-t70');
        /*var lp_right = ($('.container').offset().left)/2;
        $('.show-banner-nob').css({'right' : lp_right+'px' });*/
    }
    $(window).resize(function(){
        if($(window).width() < 981){
            $('.super_banner__headline').addClass('super_banner__headline_medium');
            $('.super_banner__btn').addClass('btn--extra-small__medium');
            $('.super_banner__close').addClass('super_banner__close_medium');
            $('body').addClass('super-header-padding-t70');
        }else if($(window).width() > 980){
            $('.super_banner__headline').removeClass('super_banner__headline_medium');
            $('.super_banner__btn').removeClass('btn--extra-small__medium');
            $('.super_banner__close').removeClass('super_banner__close_medium');
            $('body').removeClass('super-header-padding-t70');
        }
        if($(window).width() < 979){
            $('body').removeClass('super_banner_body');
            $('body').removeClass('super-header-padding-t70');
        }
    });
    $('.super_banner__close').click(function(e){
        e.preventDefault();
        $('.super_banner').slideUp(function(){
            $('.show-banner-nob').slideDown('fast');
        });
        $('body').addClass('super-header-padding');
    });
    $(document).on('click','.show-banner-nob',function(e){
        e.stopPropagation();
        $('body').removeClass('super-header-padding');
        $('.show-banner-nob').slideUp('fast');
        $('.super_banner').slideDown()
    });
    if ($('.super_banner').length) {
        _bar_height = $('.super_banner').height();
        _bar_height = _bar_height + 10;
        $('body').css('padding-top',_bar_height);

        $(window).on('resize', function(){
            setTimeout(function(){
                _bar_height = $('.super_banner').outerHeight();
                $('body').css('padding-top',_bar_height);
            },300);
        });
    }
    if($(".custom-scroll").length>0) {
        $(".custom-scroll").mCustomScrollbar({
            scrollInertia: 3000,
            autoExpandScrollbar: false,
            mouseWheel: {scrollAmount: 200},
            callbacks: {
                onUpdate: function () {
                    console.info("Inner");
                }
            },
            set_height: 'auto',
            advanced: {
                updateOnBrowserResize: true
            }
        });
    }
    // fix for User List navigation
    $(".dropdown .user-list li a").click(function(e) {
        e.preventDefault();
        self.location = $(this).attr('href');
    });


    $(".clone-feature-modal.plan .plan-tabs a").click(function () {
        $('.clone-feature-modal.plan .plan-tabs li').removeClass('active');
        $(this).parent().addClass('active');
    });

    var upgradeAjaxRunning = false;

    $('.client-upgrade-plan-to-pro').click(function (e){
        e.preventDefault();
        if(upgradeAjaxRunning){
            return
        }
        upgradeAjaxRunning = true;
        var loader = displayAlert('loading', 'Upgrading your subscription plan', 0)

        var showMessage = function (type, message) {
            loader.hide()
            setTimeout(function () {
                displayAlert(type, message)
            }, 300)
        }

        var clickedCloneBtn = $(this).data('clickedCloneBtn');

        $.ajax({
            url: site.lpPath + '/index/upgradetoproplan',
            data: { period: $(this).data('plan-period') },
            dataType: 'json',
            method: 'post',
            success: function (response) {
                if(response && response.success){
                    $('body').addClass('client-plan-pro')
                    showMessage('success', 'Plan successfully upgraded to Pro!')
                    if(clickedCloneBtn){
                        Funnel.cloneFunnelSubdomainCta($(clickedCloneBtn))
                    } else {
                        $('#clone-feature-modal-price').modal('hide')
                    }
                } else {
                    $('body').removeClass('client-plan-pro')
                    // As client should not be concerned with server side errors
                    // so showing a general message instead of server returned message
                    showMessage('danger', 'Sorry, something went wrong during plan upgrade, please contact us, we can help you!')
                    console.warn('Plan Upgrade Error: ' + response.message)
                }
            },
            error: function () {
                $('body').removeClass('client-plan-pro')
                console.warn('Plan Upgrade Error: network/server error while upgrading')
                showMessage('danger', 'Sorry, something went wrong during plan upgrade, please contact us, we can help you!')
            },
            complete: function (){
                upgradeAjaxRunning = false
            }
        })
    })

    jQuery(document).on('click', '.mega-dropdown', function(e) {
        e.stopPropagation()
    });
    $("body").on('click' , '.drop-menu' ,function() {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
        } else {
            $(this).addClass('open');
        };
    });
    $('.leadpop-dropdown li').click(function () {
        $("#"+$(this).parents('.leadpop-dropdown').attr('data-name')).val($(this).attr('data-value'))
    });

    $(document).mouseup(function(e) {
        var container = $(".funnels-menu.header-inner");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.find('.drop-menu').removeClass('open');
        }
    });

    $("#mask").delay(500).fadeOut(600);

    $(document).on("click",".funnel__item.disable_lite_package",function (e){
        e.preventDefault();
        showLitePackageDisableAlert();
        return false;

    });
    $(".funnel-row .disable_lite_package").click(function (e){
        e.preventDefault();
        showLitePackageDisableAlert();
        return false;

    });

    var $cloneFunnelNameField = $('#clone_funnel_name');

    $('#modal_SubdomainCloneFunnel').on('shown.bs.modal', function () {
        $cloneFunnelNameField.focus().val('');
        $(this).find('.select2js__tags-parent .select2-search__field').attr('placeholder', 'Add another tag');
    })
    .on('hidden.bs.modal',function (){
        $cloneFunnelNameField.val('');
    })
    .on('show.bs.modal', function (){
        $('#clone-feature-modal-price').modal('hide')
    })

    function getCurrentTimeZone(){
        // It would return undefined where Intl APIs are not supported
        // then we will fallback to server timezone
        try{
            return Intl.DateTimeFormat().resolvedOptions().timeZone
        } catch (e) {
            return undefined
        }
    }

    /**
     * setting cookie that will be retrieved in backend to get stats as per client timezone
     */
    function setClientsTimezoneOffset() {
        document.cookie = "tzo=" + getCurrentTimeZone();
    }

    setClientsTimezoneOffset()
});



(function($){

    /**  Code for model box for support ticket **/
    $('body').on('change','#global_maintopic',function(e){
        e.preventDefault();
       var global_support_issue_data = $.parseJSON($('#global_issuedatainfo').val());
        console.log($(this).val());
        if(global_support_issue_data[$(this).val()] != undefined){
            var option_val='<option value="">Select Topic</option>';
            $.each(global_support_issue_data[$(this).val()].subissue, function(key, value) {
                option_val+='<option value="'+key+'">'+value+'</option>';
            });
            $('#global_mainissue').empty().append(option_val).find('option:first').attr("selected","selected");
        }
    });


    window.globalSupportTicket = {
        openModel: function (){
            $('#modal_submitSupportRequest').modal('show');

            $('#global_maintopic').val('1');
            $('#global_maintopic').trigger('change');
            $('#global_mainissue').val('10');
            $('#global_subject').val('Upgrade me to Unlimited Funnels!');
            $('#global_message').val('I would like to upgrade my account to the Conversion Funnels Unlimited!');
        },
        submitTicket: function(){
            displayToastAlert('loading', 'Please Wait... Processing your request...',0);
            if(!formSubmitting){
                formSubmitting = true;

                var notification_container = ".global_ticket_notif";
                $(notification_container).css("text-align", "left");
                $.ajax( {
                    type : "POST",
                    data : "maintopic=" + $("#global_maintopic").val() + "&issuedatainfo=" + $("#global_issuedatainfo").val() + "&targetele=&mainissue=" + $("#global_mainissue").val() + "&mailmsg=&mailsubject=&subject=" + $("#global_subject").val() + "&message=" + $("#global_message").val() + "&format=json",
                    url : $("#lp-support-form").attr("action"),
                    dataType: "json",
                    error: function (e) {
                        formSubmitting = false;
                        $(".ct-group").html('');
                        displayAlert('danger', 'Your request was not processed. Please try again..');
                        },
                    success : function(d) {
                        $(".ct-group").html('');
                        if(d.code == '200'){
                            displayAlert('success', d.msg);
                        }
                        else {
                            displayAlert('danger', d.msg);
                        }
                        $('#global_maintopic').val('');
                        $('#global_maintopic').trigger('change');
                        $('#global_mainissue').val('');
                        $('#global_mainissue').trigger('change');
                        $('#global_subject').val('');
                        $('#global_message').val('');

                        setTimeout(function () {
                            formSubmitting = false;
                            $("#modal_submitSupportRequest").modal('toggle');
                        }, 1600);
                    },
                    cache : false,
                    async : true
                });
            }
        }
    };

    $('body').on('click','#global_ticket_model_open',function(e){
        e.preventDefault();
        $('#modal_cloneFunnelRequest').modal('hide');
        globalSupportTicket.openModel();
    });
    // $('body').on('click','#global_btn-spt-form',function(e){
    //     e.preventDefault();
    //     globalSupportTicket.submitTicket();
    // });


    /**  Code for model box for support ticket -- ends **/

    // Clone + Delete + Status Funnels - Starts
    var Funnel = {
        cloneFunnelRequest: function(elem) {
            $('#modal_cloneFunnelRequest').modal('show');
        },
        cloneFunnelSubdomainCta: function (elem){
            $("#ClonefunnelSubdomain").attr("action", elem.attr('data-ctalink'));
            $("#customzie_subdomain").val(elem.attr('data-subdomain'));

            var $topLevelDomain = $('#topleveldomain');
            var defaultDomain = elem.attr("data-top-domain");

            if(!defaultDomain || ! ($topLevelDomain.find(`option[value="${defaultDomain}"]`).length)){
                defaultDomain = $topLevelDomain.find('option').eq(0).val()
            }

            $topLevelDomain.val(defaultDomain)
            $topLevelDomain.change();

            $("#modal_SubdomainCloneFunnel #current_hash").val(elem.attr('data-hash'));
            $("#clone_folder_list").val(elem.attr('data-folder-id'));
            selected_clone_tag_list = jQuery.parseJSON(elem.attr('data-tag-id'));
            lpUtilities.tag_drop_down_list(2);
            $('.select2js__folder').select2({
                width: '100%',
                minimumResultsForSearch: -1,
                dropdownParent: $('.select2js__folder-parent')
            });

            $( '#modal_SubdomainCloneFunnel' ).modal('show');
        },
        cloneFunnelCta: function(elem) {
            $(".btnAction_confirmCloneDelete").html("Clone");
            $("#action_confirmCloneDelete").val("clone");
            $("#form_confirmCloneDelete").attr("action", elem.attr('data-ctalink'));

            var funnel_name = elem.parents('.funnel-row').find('.funnel-url').text();
            if(funnel_name == ""){
                funnel_name = $('.lp-url-color').text();
            }

            $(".notification_confirmCloneDelete").html("Clone " + funnel_name + "?");
            $('#modal_confirmCloneDelete').find('.modal-title').html('Clone Funnel');
            $('#modal_confirmCloneDelete').modal('show');
        },
        deleteFunnelBtn: function(elem) {
            $('#modal_status').modal('hide');
            $("#action_confirmCloneDelete").val("delete");
            $("#form_confirmCloneDelete").attr("action", elem.attr('data-ctalink'));
            $("#form_confirmCloneDelete #current_hash").val(elem.attr('data-hash'));
            var funnel_name = elem.attr('data-funnel-name');
            if(funnel_name == ""){
                funnel_name = $('.lp-url-color').text();
            }

            $(".modal-msg_light b").html(funnel_name);
            $('#modal_confirmCloneDelete').modal('show');
        },

        clone: function() {
        },
        delete: function() {
            $("#form_confirmCloneDelete").submit()
        }
    }
        $(".cloneFunnelBtn").click(function (e) {
            e.preventDefault();
            Funnel.cloneFunnelCta($(this))
        })

    if (typeof site != "undefined" && site.route != 'dashboard') {
        $(".cloneFunnelSubdomainBtn").click(function (e) {
            e.preventDefault();
            if ($(this).hasClass("disable_lite_package")) {
                showLitePackageDisableAlert();
                return false;
            }
            if($('body').hasClass('client-plan-pro')){
                Funnel.cloneFunnelSubdomainCta($(this))
            } else {
                Funnel.cloneFunnelRequest($(this))
            }

            $('.client-upgrade-plan-to-pro').data('clickedCloneBtn', this)
        })
    }


        $(document).on("click",".deleteFunnelBtn",function (e) {
            e.preventDefault();
            Funnel.deleteFunnelBtn($(this))
        })

    $(document).on( "click",".btnAction_confirmCloneDelete", function (e){
        if( $("#action_confirmCloneDelete").val() == "delete"){
            Funnel.delete();
        }
    });
    $(document).on('click',".btnAction_SubDomainCloneFunnel",function( event ) {
        $("#mask").show();
        setTimeout(function  (){
        FunnleNameValidation();
        },400);
    });


    $(".btnCancel_confirmCloneDelete").on( "click", function (e){
        $("#form_confirmCloneDelete").attr("action", "");
        $("#action_confirmCloneDelete").val("");
        $(".notification_confirmCloneDelete").html("");
    });

    /*disable global setting for lite package*/
    $(".global-settings.disable_lite_package").on( "click", function (e){
        e.preventDefault();
            showLitePackageDisableAlert();
            return false;

    });

    // Muhammad

    $('.btn-toggle').on('click', function(){
        if ($(this).hasClass("active")) {
            $('#advance-footer-wrapper').css('display','none');
        }else {
            $('#advance-footer-wrapper').css('display','block');
        }
    });
    // Clone + Delete + Status Funnels - Ends
    //Domain name validation on key
    $(document).on("keyup","#customzie_subdomain",function(){
        var notification_container = ".model_notification";
        var subdomain = $(this).val();
        if(/^[a-zA-Z0-9-]+$/.test(subdomain) == false) {
            notification.error(notification_container, "Special characters and spaces are not allowed in domain names.");
            $(".btnAction_SubDomainCloneFunnel").attr("disabled",true);
            return false;
        }else{
            $(".btnAction_SubDomainCloneFunnel").attr("disabled",false);
            $(notification_container).text('');
            return true;
        }
    });

    window.Funnel = Funnel;
// noteMsg
    $(document).on('click', "#lp_noteBox__li",function(){
        $('#msgNote').modal( 'show');
    });
})(jQuery);

function copyContentToClipboard(element) {
    var $temp = $("<INPUT>");
    $("body").append($temp);
    $temp.val($.trim($(element).val())).select();
    document.execCommand("copy");
    $temp.remove();
}

function update_type_dropdown(verticalDropdownElem){
    /* Card Description:
     * When the user clicks "Vertical" -- "Real Estate" the menu next to it for "Type" still says "Mortgage Funnels" and "Mortgage Website Funnels"
     *      -- unfortunately, that doesn't make any sense and needs to be corrected... should say "Real Estate Funnels" (which is automatic selection in that menu when user selects Vertical to be Real Estate)...
     *      and then it can still say -- Mortgage Website Funnels as the second option... which should behave as described before
     */
    var typeddl = verticalDropdownElem.find("span").html() + " Funnels";
    $(".vertical-dropdowntype .verText").html(typeddl);
    $(".vertical-dropdowntype li:first span").html(typeddl);
    //$( ".vertical-dropdowntype li:nth-child(2)" ).html(verticalDropdownElem.find("span").html() + " Website Funnels");
}

function resetVerticalDropdown(verticalTypeDropdownElem){
    var vertical = verticalTypeDropdownElem.attr("data-value").replace("-website-funnels","");
    var defaultEl = $(".vertical-dropdown .dropdown-list li.selectable[data-value='" + verticalTypeDropdownElem.attr("data-value").replace("-website-funnels","") + "']");
    update_type_dropdown(defaultEl);
    var _dropdown = $(".vertical-dropdown");
    _dropdown.find('.verText').text( verticalTypeDropdownElem.attr("data-client-type") );
    _dropdown.find('input[name=cd-dropdown]').val( vertical );
    $('.vertical_container').removeClass('active');
    $("."+vertical+'-funnels').addClass('active');
}

function FunnleNameValidation() {
    var response = true;
    var subdomain = $("#customzie_subdomain").val();
    var funnel_name = $("#clone_funnel_name").val();
    var topdomain = $("#topleveldomain").val();
    if(funnel_name == "") {
        displayAlert('warning', 'Funnel name is required.');
        $("#mask").hide();
        return false;
    }else if(/^[a-zA-Z0-9-\s]+$/.test(funnel_name) == false) {
        displayAlert('warning', 'Special characters are not allowed in funnel name.');
        $("#mask").hide();
        return false;
    }else if($("#clone_tag_list").val().length == 0) {
        displayAlert('warning', 'At least one Funnel tag is required.');
        $("#mask").hide();
        return false;
    }else  if(subdomain == "") {
        displayAlert('warning', 'Sub-domain name is required.');
        $("#mask").hide();
        return false;
    }else if(/^[a-zA-Z0-9-]+$/.test(subdomain) == false) {
        displayAlert('warning', 'Special characters and spaces are not allowed in domain names.');
        $("#mask").hide();
        return false;
    }else {
        var rec = jQuery.parseJSON(funnel_json);
        $(rec).each(function (index, el) {
            if(el.funnel_name != "" && el.funnel_name != null) {
                if (funnel_name.toLowerCase() == el.funnel_name.toLowerCase()) {
                    displayAlert('danger', 'Funnel name ' + funnel_name + ' is already in use. Please try something else.');
                    $("#mask").hide();
                    response = false;
                }
            }
        });
        if(response == true){
            response = false;
            $.ajax({
                type: "POST",
                data: "funnel_name=" + funnel_name+"&subdomain=" + subdomain + "&topdomain=" + topdomain+'&_token='+ajax_token,
                url: "/lp/ajax/checksubdomainavailable",
                success: function (d) {
                    response = true;
                    $("#mask").hide();
                    if (d == "ok") {
                        ajaxClonFunnel();
                        $('#modal_SubdomainCloneFunnel').modal('hide');
                    } else if (d == "taken") {
                        displayAlert('danger', 'Sub-domain ' + subdomain + '.' + topdomain + ' is not available.');
                    }
                    else if(d == "disabledClone"){
                        $('#modal_SubdomainCloneFunnel').modal('hide');
                        $('#modal_cloneFunnelRequest').modal('show');
                    }
                },
                cache : false,
                async : false
            });
        }
    }
}

function showLitePackageDisableAlert(){
    $('#modal_LitePackageFunnel').modal('show');
}


/**
 * Basicaly added to Fix problem with chrome on file cancellation, It's was removing already selected files
 * Added click and change event listeners
 */
//This is All Just For Logging:
var debug = true;//true: add debug logs when cloning
var evenMoreListeners = true;//demonstrat re-attaching javascript Event Listeners (Inline Event Listeners don't need to be re-attached)
if (evenMoreListeners) {
    var allFleChoosers = $("input[type='file']");
    addEventListenersTo(allFleChoosers);
    function addEventListenersTo(fileChooser) {
        fileChooser.change(function (event) {
            console.log("file( #" + event.target.id + " ) : " + event.target.value.split("\\").pop());
            // fileChanged(event);
        });
        fileChooser.click(function (event) {
            if (debug) {
                console.log("open( #" + event.target.id + " )");
            }
            // fileClicked(event);
        });
    }
}


var clone = {};

/**
 * Clone selected image, that will be replaced later
 * @param event
 */
function fileClicked(event) {
    var fileElement = event.target;
    if (fileElement.value != "") {
        if (debug) { console.log("Clone( #" + fileElement.id + " ) : " + fileElement.value.split("\\").pop()) }
        clone[fileElement.id] = $(fileElement).clone(); //'Saving Clone'
    }
    //What ever else you want to do when File Chooser Clicked
}

/**
 * Image will be replaced with previously cloned image if
 * On Chome cancel removing file name, So previous one will be replaced in that case
 * user selected unsupported file it will be replaced with previous selected
 * @param event
 */
function fileChanged(event) {
    var fileElement = event.target;

    if (clone[fileElement.id] !== undefined){
        var filetype = event.target.files.length > 0 ? event.target.files[0].type : false,
            isFileTypeError = (filetype !== "image/png" && filetype !== "image/jpeg" && !filetype !== "image/jpg" && !filetype !== "image/gif");

        if(fileElement.value == "" || isFileTypeError) {
            if (debug) {
                console.log("Restore( #" + fileElement.id + " ) : " + clone[fileElement.id].val().split("\\").pop())
            }
            clone[fileElement.id].insertBefore(fileElement); //'Restoring Clone'
            $(fileElement).remove(); //'Removing Original'
            if (evenMoreListeners) { addEventListenersTo(clone[fileElement.id]) }//If Needed Re-attach additional Event Listeners

            if(filetype !== false && isFileTypeError) {
                let message = "Invalid image format. Image format must be GIF, PNG, JPG, or JPEG.";
                displayAlert("danger", message);
            }
        }
    }
    //What ever else you want to do when File Chooser Changed
}

/**
 * create method to register/add custom validation methods for JQuery validator
 * @constructor
 */
function AddValidatorCustomMethods() {
    /**
     *  As default email implementation allowing dotless email addresses,
     *  created new regex by modifying default email validation regex
     */
    $.validator.addMethod("cus_email", function (value, element, regexpr) {
        return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])$/.test(value);
    }, "Please enter a valid email address.");
}

/**
 * Auto display training library overlay
 * when ?libpopup=show is passed in QueryString
 */
function initAutoViewTrainingLibrary() {
    var url = window.location.search;
    if (url == "?libpopup=show") {
        jQuery('body').addClass('libaray-open');
        $(".overlay_container").addClass("d-block");
    }
}

/**
 * created handler to active/inactive funnel status
 * moved all status related code into this handler
 */
var FunnelStatusHandler = {
    funnelStatus: 0,
    statusSubmitButton: ".btnAction_saveStatus",

    init: function () {
        this.initBindings();
    },
    initBindings: function () {
        let $self = this;

        $(".funnelStatusBtn").click(function (e) {
            e.preventDefault();
            $self.funnelStatusBtn($(this))
        })

        $(document).on( "change","#modal_status #toggle-status", function (e){
            let  disabled = $self.funnelStatus == $(this).prop('checked');
            $self.changeButtonStatus($self.statusSubmitButton, disabled);
        });

        $(document).on( "click", $self.statusSubmitButton, function (e){
            if(!formSubmitting){
                formSubmitting = true;
                var ctaElem = $(this);
                var status = $('#modal_status #toggle-status').prop('checked');
                var domain_id = ctaElem.attr('data-domain_id');
                var leadpop_id = ctaElem.attr('data-leadpop_id');
                var leadpop_version_id = ctaElem.attr('data-leadpop_version_id');
                var leadpop_version_seq = ctaElem.attr('data-leadpop_version_seq');
                var leadpop_version_seq = ctaElem.attr('data-leadpop_version_seq');
                var index = ctaElem.attr('data-index');

                let {hide} = displayAlert("loading", "Processing your request",0);
                $.ajax( {
                    type : "POST",
                    data : "domain_id=" + domain_id + "&leadpop_id=" + leadpop_id + "&leadpop_version_id=" + leadpop_version_id + "&leadpop_version_seq=" + leadpop_version_seq + "&status=" + status+"&_token="+ajax_token,
                    url : "/lp/index/modifydomainstatus",
                    dataType: "json",
                    error: function (e) {
                        hide();
                        formSubmitting = false;
                        displayAlert('error', 'Your request was not processed. Please try again.');
                    },
                    success : function(d) {
                        hide();
                        formSubmitting = false;
                        ctaElem.attr('data-domain_id', '');
                        ctaElem.attr('data-leadpop_id', '');
                        ctaElem.attr('data-leadpop_version_id', '');
                        ctaElem.attr('data-leadpop_version_seq', '');
                        //console.log(d.q);
                        $("#modal_status").modal('toggle');
                        if (d.status == "active") {
                            $(".funnelstatus_" + domain_id).attr('data-status', 1);
                            displayAlert('success', 'Funnel status has been changed to active.');
                            window.data[index].leadpop_active = 1;
                        }
                        else if (d.status == "inactive") {
                            $(".funnelstatus_" + domain_id).attr('data-status', 0);
                            displayAlert('success', 'Funnel status has been changed to inactive.');
                            window.data[index].leadpop_active = 0;
                        }
                        $('.funnels-details').funnelLoader();
                        var funnelID = "#row-"+window.data[index]['client_leadpop_id']+'-'+window.data[index]['domain_id']+"-"+index;
                        $(funnelID).toggleClass('open active');
                        setTimeout(function (){
                            //$(funnelID+ ' .funnels-details-wrap').stop().slideToggle();
                        },30);
                    },
                    cache : false,
                    async : true
                });

            }
        });
    },

    changeButtonStatus: function(button, disabled){
        $(button).prop('disabled', disabled);
    },
    funnelStatusBtn: function(elem){

        this.funnelStatus = elem.attr("data-status") == 1;
        if(elem.attr("data-status") == 1) {
            $('#modal_status #toggle-status').bootstrapToggle('on');
        }
        else {
            $('#modal_status #toggle-status').bootstrapToggle('off');
        }
        this.changeButtonStatus(this.statusSubmitButton, true);
        var ele=$("#modal_status #status-lp-video");
        ele.attr("data-lp-wistia-title","Status");
        ele.attr("data-lp-wistia-key","zudbzlbz4g");
        let index = jQuery(elem).parents('.funnels-details').attr('data-index');
        $(".btnAction_saveStatus").attr("data-domain_id", elem.attr("data-domain_id"));
        $(".btnAction_saveStatus").attr("data-leadpop_id", elem.attr("data-leadpop_id"));
        $(".btnAction_saveStatus").attr("data-leadpop_version_id", elem.attr("data-leadpop_version_id"));
        $(".btnAction_saveStatus").attr("data-leadpop_version_seq", elem.attr("data-leadpop_version_seq"));
        $(".btnAction_saveStatus").attr("data-index", index);
        var isDelete = elem.attr("data-delete");
        if(clone_flag == 'n' && cloneFunnelNumber <= funnelCloneLimit && elem.attr("data-leadpop_version_seq") > 1){
            isDelete = 'y';
        }
        if(isDelete == "y") {
            $(".btn__back-pop").removeAttr("title");
            if ($(".btn__back-pop").hasClass('tooltipstered')) {
                $(".btn__back-pop").tooltipster('disable');
            }
            $(".btn__back-pop").css('cursor','pointer');
            $(".btn__back-pop").addClass('deleteFunnelBtn');
            $(".deleteFunnelBtn").attr("data-ctalink", elem.attr("data-link"));
            $(".deleteFunnelBtn").attr("data-funnel-name", elem.attr("data-funnel-name"));
        }
        else{
            $(".btn__back-pop").removeClass('deleteFunnelBtn');
            $(".btn__back-pop").addClass('el-tooltip');
            $(".btn__back-pop").attr('title', "You cannot delete premade/stock Funnels.");
            if ($(".btn__back-pop").hasClass('tooltipstered')) {
                $(".btn__back-pop").tooltipster('enable');
            }
            $(".btn__back-pop").css('cursor','not-allowed');
        }
        $(".funnel-message").html("Select Funnel Status");
        $('#modal_status').modal('show');
    }
}
