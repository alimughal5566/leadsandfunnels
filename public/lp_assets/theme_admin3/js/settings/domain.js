let requesting = false;
(function ($) {
    $(document).ready(function() {
        domainModule.init();
        window.subdomainURL = $.trim($("#url__text").text());
        window.old_domain_url = '';
        $("#clone-url").html('COPY URL');

        var amIclosing = false;
        //$('.domainlist.temporary').hide();
        window.copy = 0;
        document.onkeydown=function(evt){
            var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
            if(keyCode == 13){
                $("#main-submit").trigger("click");
                evt.preventDefault();
            }
        }


        $('#subdomaintoplist').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select2top-lvl-domain-parent')
        }).on("select2:select", function () {
            var select_val = $(this).val();
            var get_txt = $("#subdomainname").val();
            var url_txt = 'https://' + get_txt +'.'+ select_val;
            $("#url__text").text(url_txt);
        }).on('select2:select', function() {
            $('[name="subdomainname"]').trigger('keyup');
        }).on('select2:openning', function() {
            jQuery('.select2top-lvl-domain-parent .select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
            $(".select2top-lvl-domain-parent .select2-search__field").attr("placeholder", "Search....");
            jQuery('.select2top-lvl-domain-parent .select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                jQuery('.select2top-lvl-domain-parent .select2-results__options').css('pointer-events', 'auto');
            }, 300);
            jQuery('.select2top-lvl-domain-parent .select2-dropdown').hide();
            jQuery('.select2top-lvl-domain-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            jQuery('.select2top-lvl-domain-parent .select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                jQuery('.select2top-lvl-domain-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                    var getindex = jQuery('#subdomaintoplist').find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 400);
        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;
                jQuery('.select2top-lvl-domain-parent .select2-dropdown').attr('style', '');
                setTimeout(function () {
                    jQuery('#subdomaintoplist').select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
            jQuery('.select2top-lvl-domain-parent .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '0', 'important' );
            });
        }).on('select2:close', function() {
            jQuery('.select2top-lvl-domain-parent .select2-selection__rendered').show();
            jQuery('.select2top-lvl-domain-parent .select2-results__options').css('pointer-events', 'none');
        });

        $(".select2js__nice-scroll").click(function () {
            $('.select2-results__options').niceScroll({
                cursorcolor:"#fff",
                cursorwidth: "10px",
                autohidemode:false,
                railpadding: { top: 0, right: 0, left: 0, bottom: 0 }, // set padding for rail bar
                cursorborder: "1px solid #02abec",
            });
        });

        $('[name="subdomainname"]').keyup(function () {
            var string = $(this).val().replace(/[^a-z0-9\-\s]/gi, '').replace(/[_\s]/g, '').toLowerCase();
            var get_txt = $("#subdomaintoplist").val();
            var url_txt = 'https://' + string +'.'+ get_txt;
            $("#url__text, .url__text").html(url_txt);
            $(this).val(string);
            if ($(this).val() == ''){
                $("#url__text").html('');
            }
            var new_url =  $.trim($("#url__text").text());
            if(window.subdomainURL != new_url){
                $(".domain-card .copy-url .copy-btn").attr({'disabled':true});
                $(".domain-card .funnel-url-copy .lp-controls__link").css({'pointer-events':'none'});
            } else {
                $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
                $(".domain-card .funnel-url-copy .lp-controls__link").css({'pointer-events':'all'});
            }
        });

        $('a[href="#"]').click(function(e){
            e.preventDefault();
        });

        $("#main-submit").click(function(e){
            e.preventDefault();
            e.stopImmediatePropagation();

            // to prevent multiple toast messages
            $(this).prop('disabled', true);
            setTimeout(() => {
                $(this).prop('disabled', false);
            }, 1100);

            window.copy = 0;
            $('#subdomain').submit();
            //checking if domain accordion is active
            if($('#domain').css('display') == 'block') {
                if($("#domainname").val() != "" && $("#domainname").val() == old_domain_url){
                    $('#checkboxdomainname').prop('checked', false);
                    displayAlert('success', 'Domain '+ $("#domainname").val() + ' has been saved.');
                    $('#domainname').attr('disabled',true);
                }
                else {
                    domainModule.verifyDomainName();
                }
            } else {
                domainModule.verifySubDomainName();
            }
        });

        domainModule.initModalClosedEvents();

        // subdomain and own doamin toggle functionality
        jQuery('body').on('change', '.domain-card input[type="radio"]', function(){
            var _self = jQuery(this);
            //jQuery('.sub-domain  .active .domain-slide').slideUp();
            jQuery('.domain-card.active .domain-slide').slideUp();
            jQuery('.domain-card').removeClass('active');
            _self.parents('.domain-card').addClass('active');
            _self.parents('.domain-card').find('.domain-slide').slideDown();
        });

        ajaxRequestHandler.init("#subdomain", {
            customFieldChangeCb: onChangeDomainHandleButton
        });
        domainFromValidation();
    });
})(jQuery);

function copyToClipboard(element) {
    var $temp = $("<INPUT>");
    $("body").append($temp);
    $temp.val($.trim($(element).text())).select();
    document.execCommand("copy");
    $temp.remove();
}
$('#clone-url,#funnel-clone-url').click(function(){
        var new_url =  $.trim($("#url__text").text());
        if(window.subdomainURL == new_url){
            copyToClipboard($('#url__text'));
            setTimeout(() => {
                displayToastAlert('success', 'Funnel URL has been copied to the clipboard.');
            },1200);
        }

});

function changesubdomainname() {
    if($("#checkboxsubdomainname").is(':checked')==true) {
        $('#subdomainname').attr('disabled',false);
    } else {
        $('#subdomainname').attr('disabled','disabled');
    }
}

function changetopleveldomain() {
    if($("#checkboxsubdomainnametop").is(':checked')==true) {
        $('#subdomaintoplist').removeAttr('disabled');
    }else {
        $('#subdomaintoplist').attr('disabled',true);
    }
}

/* Add New Domain */
function addunlimiteddomain() {
    $("#checkboxdomainname").prop('checked', true);
    $('#domainname').attr('disabled',false);
    $('#domainname').val("");
    $('#beforedomainname').val("");
}

function changedomainname() {
    if($("#checkboxdomainname").is(':checked')==true) {
        $('#domainname').attr('disabled',false);
        $('#domainname').val("");
        $('#beforedomainname').val("");     // if this is reset then it will add new entry
        $('#domainname').focus();
        domainFromValidation();
    } else {
        $( "#subdomain" ).validate().destroy();
        $('#domainname').val("").attr('disabled','disabled').removeClass('error');
        $("#domainname-error").remove();
    }
}

function saveopensubdomaintest() {
    var subdomain = "";
    var topdomain = "";
    subdomain = $("#subdomainname").val();
    topdomain = $("#subdomaintoplist").val();
    var changesubok = $('#changesubok').val();
    var client_id = $('#client_id').val();
    var version_seq = $('#version_seq').val();
    var leadpop_id = $('#leadpop_id').val();
    var thedomain_id = $('#thedomain_id').val();
    var domaintype = $('#domaintype').val();

    if(subdomain == "" || changesubok == 'n' ||  changesubok == '' ) {
        displayAlert('danger', "Sub-domain name is required.");
        return false;
    }
    else {
        var dstr = "domaintype="+domaintype+"&subdomain="+subdomain+"&topdomain="+topdomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id;
        $("#modal_subdomain_available").find(".modal-msg").html('Please Wait... Processing your request...');
        $.ajax( {
            type : "POST",
            data: dstr,
            url : "/lp/popadmin/savechecksubdomainavailabletest",
            error: function (e) {
                displayAlert('danger', 'Your request was not processed. Please try again.');
                $("#modal_subdomain_available").modal('toggle');
            },
            success : function(d) {
                var cares = d.split("~");
                var slength = cares.length;
                //var  view_url='http://'+subdomain+topdomain;
                if(slength > 2) {
                    domainModule.updateFunnelUrlInMenus(subdomain, topdomain);

                    $("#hdomain_name").val(subdomain);
                    $("#htop_level").val(topdomain);
                    $('#thedomain_id').val(cares[2]);
                    $('#domaintype').val(cares[1]);
                    $('#leadpop_id').val(cares[3]);

                    displayAlert('success', 'Sub-domain '+ subdomain + '.' + topdomain + ' has been saved.');
                    $("#modal_subdomain_available").modal('toggle');
                }else  {
                    displayAlert('danger', 'Error: Sub-domain '+ subdomain + '.' + topdomain + ' is not available.');
                    $("#modal_subdomain_available").modal('toggle');
                    $('#changesubok').val('n');
                }

                // remove domain list if updating domain to sub-domain
                if($(".domain-grid__list").not(".fd_temporary").length == 1){
                    $(".domain-grid__list").not(".fd_temporary").remove();
                }
                $("#checkboxdomainname").prop('checked', false);
            },
            cache : false,
            async : false
        });
    }
}

var domainModule = {
    last_clicked: 0,
    time_since_clicked: Date.now(),
    isAjaxInProcess: false,
    client_id: null,

    init: function(){
        this.client_id = $("#client_id").val();
        this.bindEvents();

        let $self = this;
        $("#_delete_domain_btn").unbind().on("click", function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            $self.deleteDomain();
        });

        $("#_save_open_domain").click($self.saveDomainName);

        // Subdomain specific events
        $("#_save_open_subdomain").click(function(e){
            e.stopImmediatePropagation();
            domainModule.saveSubDomainName();
        });

        $("#_save_open_subdomain_test").click(function(e){
            saveopensubdomaintest();
        });
    },

    bindEvents: function (containerElem) {
        if (containerElem == undefined) {
            editLinkElem = $('.btn-edit-domain');
            deleteLinkElem = $('.btn-delete-domain');
        } else {
            editLinkElem = $(containerElem).find('.btn-edit-domain');
            deleteLinkElem = $(containerElem).find('.btn-delete-domain');
        }
        editLinkElem.click(this.editDomainName);
        deleteLinkElem.click(this.deleteDomainName);
    },

    /**
     * To edit main domain
     * @param e
     */
    editDomainName: function(e) {
        e.preventDefault();
        let domain_id = $(this).data("domain_id");
        $('#thedomain_id').val(domain_id);
        $("#checkboxdomainname").prop('checked', true);

        $('#domainname').val("");
        $('#beforedomainname').val("");
        $('#domainname').attr('disabled',false);

        $.ajax( {
            type : "POST",
            url : "/lp/ajax/getdomainfromid",
            data : "client_id=" + domainModule.client_id + "&domain_id=" + domain_id,
            success : function(d) {
                $('#domainname').val("");
                old_domain_url = d;
                $('#domainname').val(d);
                $('#beforedomainname').val(d);
                $('#domainname').focus();
            },
            cache : false,
            async : false
        });
    },

    /**
     *  Delete Domain Functions
     */
    deleteDomainName: function(e) {
        e.preventDefault();
        let domain_id = $(this).data("domain_id");
        $("#modal_delete_domain").find(".modal-msg").html('<p>Do you want to delete this domain ?</p>');
        $("#modal_delete_domain").find('#_delete_domain_id').val(domain_id);
        $("#modal_delete_domain").modal();
    },

    /**
     * This function will send AJAX request to delete domain
     * @returns {boolean}
     */
    deleteDomain: function() {
        let subdomain = "",
            topdomain = "",
            _olddomain = "",
            elem = $("#modal_delete_domain").find(".modal-msg").html('Please Wait... Processing your request...'),
            domain_id = $("#modal_delete_domain").find('#_delete_domain_id').val();

        ajaxRequestHandler.sendRequest("/lp/popadmin/deletethisdomain", function (response, isError) {
            let data = response.result;
            if(isError === true) {
                $("#modal_subdomain_available").modal('toggle');
                $('#changesubok').val('n');
            } else {
                if(data.action !== undefined && data.action == "delete") {
                    $("#hdomain_name").val(data.current_domain);
                    domainModule.updateFunnelUrlInMenus(false, data.current_domain);
                    $('#thedomain_id').val(data.domain_id);
                    _olddomain = data.deleted_domain;
                    $('.full-url').text(data.current_domain);
                } else {
                    domainModule.updateFunnelUrlInMenus(data.subdomain, data.top_level_domain);
                    var funnelUrl = 'https://'+data.subdomain + '.' + data.top_level_domain;
                    $("#url__text").text( funnelUrl);
                    $('#thedomain_id').val(data.domain_id);
                    $('#domaintype').val(data.domain_type);
                    $('#leadpop_id').val(data.leadpop_id);
                    $('#subdomainname').val(data.subdomain);
                    $('#subdomaintoplist').val(data.top_level_domain);

                    $("#hdomain_name").val(data.subdomain);
                    $("#htop_level").val(data.top_level_domain);
                    $(".lp-controls__link,.menu__link").attr('href',funnelUrl);
                    $('.full-url').text(funnelUrl);
                    if(data.lynxly_hash) {
                        $('.view-short-url-wrap').show();
                    }
                    $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
                    subDomainFullURL();
                }

                $(".domain_" + domain_id + "_" + domainModule.client_id ).remove();
                if($(".domain-grid__list").length == 0){
                    $("#checkboxdomainname").prop('checked', true);
                    $('#domainname').attr('disabled',false);
                    $('#domainname').val("");
                    $('#beforedomainname').val("");     // if this is reset then it will add new entry
                    $('#domainname').focus();
                }
                loadFunnel();
            }
            $('#modal_delete_domain').modal('hide');
        }, "deleteThisDomain=" + domain_id);

        // if(domainModule.isAjaxRequestInProcess()) {
        //     return false;
        // }
        // domainModule.startingAjaxRequest();
        //
        // $.ajax( {
        //     type : "POST",
        //     url : "/lp/popadmin/deletethisdomain",
        //     data : "deleteThisDomain=" + ids[0], // global from above
        //     error: function (e) {
        //         displayAlert('danger', 'Your request was not processed. Please try again.');
        //     },
        //     success : function(d) {
        //         var cares = d.split("~");
        //         var slength = cares.length;
        //         if(slength > 2) {
        //             if(cares[0] == 'delete'){
        //                 $("#hdomain_name").val(cares[2]);
        //                 domainModule.updateFunnelUrlInMenus(false, cares[2]);
        //                 $('#thedomain_id').val(cares[4]);
        //                 _olddomain = cares[3];
        //                 $('.full-url').text(cares[2]);
        //             } else {
        //                 subdomain = cares[4];
        //                 topdomain = cares[5];
        //                 _olddomain = cares[6];
        //
        //                 domainModule.updateFunnelUrlInMenus(subdomain, topdomain);
        //                 var funnelUrl = 'https://'+subdomain + '.' + topdomain;
        //                 $("#url__text").text( funnelUrl);
        //                 $('#thedomain_id').val(cares[2]);
        //                 $('#domaintype').val(cares[1]);
        //                 $('#leadpop_id').val(cares[3]);
        //                 $('#subdomainname').val(cares[4]);
        //                 $('#subdomaintoplist').val(cares[5]);
        //
        //                 $("#hdomain_name").val(subdomain);
        //                 $("#htop_level").val(topdomain);
        //                 $(".lp-controls__link,.menu__link").attr('href',funnelUrl);
        //                 $('.full-url').text(funnelUrl);
        //                 if(cares[7]) {
        //                     $('.view-short-url-wrap').show();
        //                 }
        //                 // $("#checkboxsubdomainname").prop('checked', true);
        //                 // $('#subdomainname').attr('disabled',false);
        //
        //                 // $("#checkboxsubdomainnametop").prop('checked', true);
        //                 // $('#subdomaintoplist').attr('disabled',false);
        //                 $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
        //                 subDomainFullURL();
        //             }
        //             loadFunnel();
        //             displayAlert('success', 'Domain '+ _olddomain + ' has been deleted.');
        //         }else  {
        //             $("#modal_subdomain_available").modal('toggle');
        //             $('#changesubok').val('n');
        //         }
        //
        //         //window.location.href = '/lp/popadmin/domain/' + $("#current_hash").val();
        //         $(".domain_"+domain_client).remove();
        //
        //         if($(".domain-grid__list").length == 0){
        //             $("#checkboxdomainname").prop('checked', true);
        //             $('#domainname').attr('disabled',false);
        //             $('#domainname').val("");
        //             $('#beforedomainname').val("");     // if this is reset then it will add new entry
        //             $('#domainname').focus();
        //         }
        //     },
        //     complete: function(response){
        //         $('#modal_delete_domain').modal('hide');
        //         // domainModule.stoppingAjaxRequest();
        //     },
        //     cache : false,
        //     async : false
        // });
    },

    /**
     * This will send request to verify domain name
     * @returns {boolean}
     */
    verifyDomainName: function() {
        var booldomain = $("#domainname").prop('disabled');
        var thedomain = "";
        thedomain = $("#domainname").val();
        var nameok = domainNameValid(thedomain);
        if(thedomain.indexOf('_') > 0) {
            displayAlert('danger', "Underscore characters are not allowed in domain names.");
            return false;
        }

        if((booldomain  == true) || thedomain == "" ) {
            displayAlert('danger', "Please enter your domain name.");
            return false;
        }
        else if (nameok == false) {
            displayAlert('danger', "Please enter a valid domain name.");
            return false;
        }
        else {
            ajaxRequestHandler.sendRequest("/lp/ajax/checkdomainavailable", function (d, isError) {
                if(isError !== true) {
                    if (d == "ok") {
                        $("#modal_domain_available").find(".modal-msg").html('Domain <strong class="domain-text">' + thedomain + '</strong> is&nbsp;available. <br /><br />Using a domain deletes any existing sub-domains.');
                        $("#modal_domain_available").modal();
                        $('#changedomainok').val('y');
                    } else if (d == "taken") {
                        displayAlert('danger', 'Domain ' + thedomain + ' is not available.');
                        $('#changedomainok').val('n');
                    }
                }
            }, "thedomain="+thedomain+"&_token="+ajax_token);

            // if(domainModule.isAjaxRequestInProcess()) {
            //     return false;
            // }
            // domainModule.startingAjaxRequest();
            // $.ajax( {
            //     type : "POST",
            //     data: "thedomain="+thedomain+"&_token="+ajax_token,
            //     url : "/lp/ajax/checkdomainavailable",
            //     success : function(d) {
            //         if (d == "ok") {
            //             $("#modal_domain_available").find(".modal-msg").html('Domain <strong class="domain-text">'+ thedomain  + '</strong> is&nbsp;available. <br /><br />Using a domain deletes any existing sub-domains.');
            //             $("#modal_domain_available").modal();
            //             $('#changedomainok').val('y');
            //         }
            //         else if (d == "taken") {
            //             displayAlert('danger', 'Domain '+ thedomain  + ' is not available.');
            //             $('#changedomainok').val('n');
            //         }
            //     },
            //     complete: function(response){
            //         domainModule.stoppingAjaxRequest();
            //     },
            //     cache : false,
            //     async : false
            // });
        }
    },

    /**
     * This function will send AJAX request to save main domain
     * @returns {boolean}
     */
    saveDomainName: function (e) {
        e.preventDefault();
        var changedomainok = $('#changedomainok').val();
        var client_id = domainModule.client_id;
        var version_seq = $('#version_seq').val();
        var leadpop_id = $('#leadpop_id').val();
        var thedomain_id = $('#thedomain_id').val();
        var domaintype = $('#domaintype').val();
        var thedomain = $("#domainname").val();
        var nameok = domainNameValid(thedomain);
        var hasunlimited = $("#hasunlimited").val();
        var beforedomainname = $('#beforedomainname').val();
        if( thedomain == "" || changedomainok == 'n'  || changedomainok == '') {
            displayAlert('danger', 'Unverified domain name cannot be saved.');
            //$('#savechangesubdomaindiv').dialog('open');
            return false;
        }
        else if (nameok == false) {
            $('#baddomainname').dialog('open');
            return false;
        }
        else {
            if(ajaxRequestHandler.isAjaxInProcess) {
                return false;
            }
            var datastr = "domaintype="+domaintype+"&thedomain="+thedomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id + "&hasunlimited=" + hasunlimited + "&beforedomainname=" + beforedomainname;
            $("#modal_domain_available").find(".modal-msg").html('Please Wait... Processing your request...');

            ajaxRequestHandler.sendRequest("/lp/popadmin/savecheckdomainavailable", function (response, isError) {
                $('#modal_domain_available').modal('hide');
                let data = response.result;
                if(isError) {
                    if(data !== undefined && data.taken) {
                        console.log("domain taken.....", data);
                        $('#changedomainok').val('n');
                        $('#domainname').val(thedomain).attr('disabled',true);
                    }
                } else {
                    if(data !== undefined && data['domain_id'] !== undefined) {
                        domainModule.updateFunnelUrlInMenus(false, thedomain);
                        $("#hdomain_name").val(thedomain);
                        $("#htop_level").val('');
                        $('#thedomain_id').val(data.domain_id);
                        $('#domaintype').val(data.domain_type);
                        $('#leadpop_id').val(data.leadpop_id);
                        loadFunnel();
                        $('.menu__list.view a').attr('href', 'https://' + thedomain);
                        $('.full-url').text('https://' + thedomain);

                        //for edit case
                        if(beforedomainname != ""){
                            console.log("Edit domain....." + beforedomainname);
                            var domainWrapper = ".domain_" + thedomain_id + "_" + client_id,
                                old_domain_class = ".fd_"+beforedomainname.replace(".","");
                            $(domainWrapper).show();

                            //$(old_domain_class+" span").html(thedomain);
                            $(domainWrapper + " .domain-name").html(thedomain);
                            $(domainWrapper).addClass("fd_"+thedomain.replace(".",""));
                            $(".domain-grid__list").removeClass(old_domain_class.replace(".",""));
                        }else{
                            console.log("New domain.....");
                            $(".domain-card .copy-url .copy-btn").attr({'disabled':true});
                            $("#url__text").text('');

                            //this will add new row in domain section
                            let el_class = 'domain_' + data.domain_id + '_' + client_id,
                                new_html = '<div class="domain-grid__list ' + el_class + ' fd_'+thedomain.replace(".","")+'">' +
                                        '<span class="domain-name">' + thedomain + '</span>' +
                                        '<div class="action action_options">' +
                                            '<ul class="action__list">' +
                                                '<li class="action__item">' +
                                                    '<a data-domain_id="' + data.domain_id + '" href="javascript:void(0)" class="action__link btn-edit-domain">' +
                                                        '<span class="ico ico-edit"></span>edit' +
                                                    '</a>' +
                                                '</li>' +
                                                '<li class="action__item">' +
                                                    '<a data-domain_id="' + data.domain_id + '" href="javascript:void(0)" class="action__link btn-delete-domain">' +
                                                       '<span class="ico ico-cross"></span>delete' +
                                                    '</a>' +
                                                '</li>' +
                                            '</ul>' +
                                            '<ul class="action__list">' +
                                                '<li class="action__item">' +
                                                    '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                                                    '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                                                    '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
                                                '</li>' +
                                            '</ul>' +
                                        '</div>' +
                                    '</div>';

                            $(".domain-grid").append(new_html);
                            domainModule.bindEvents($("." + el_class));
                            //if updating from sub-domain to domain and sub-domains fields still have values then reset it
                            if($("#subdomainname").val() != ""){
                                $("#checkboxsubdomainname").prop('checked', false);
                                $('#subdomainname').val("").attr('disabled',true);
                                $("#checkboxsubdomainnametop").prop('checked', false);
                                $('#subdomaintoplist').attr('disabled',true);
                            }
                            subDomainFullURL('add');
                            $('.view-short-url-wrap').hide();
                        }
                        $("#main-submit").attr('disabled',true);
                        $('#domainname').val(thedomain).attr('disabled',true);
                    }
                }
            }, datastr);

            // $.ajax( {
            //     type : "POST",
            //     data: datastr ,
            //     url : "/lp/popadmin/savecheckdomainavailable",
            //     error: function (e) {
            //         displayAlert('danger', 'Your request was not processed. Please try again.');
            //     },
            //     success : function(d) {
            //         var ares = d.split("~");
            //         var slength = ares.length;
            //
            //         if($('#checkboxdomainname').prop("checked")){
            //             $('#checkboxdomainname').prop('checked', false);
            //         }
            //
            //         if(slength > 2) {
            //             domainModule.updateFunnelUrlInMenus(false, thedomain);
            //
            //             $("#hdomain_name").val(thedomain);
            //             $("#htop_level").val('');
            //             $('#thedomain_id').val(ares[2]);
            //             $('#domaintype').val(ares[1]);
            //             $('#leadpop_id').val(ares[3]);
            //             loadFunnel();
            //             displayAlert('success', 'Domain '+ thedomain + ' has been saved.');
            //
            //             $('.menu__list.view a').attr('href', 'https://' + thedomain)
            //             $('.full-url').text('https://' + thedomain)
            //
            //             //for edit case
            //             if(beforedomainname != ""){
            //                 var domainWrapper = ".domain_" + thedomain_id + "_" + client_id,
            //                     old_domain_class = ".fd_"+beforedomainname.replace(".","");
            //                 $(domainWrapper).show();
            //
            //                 //$(old_domain_class+" span").html(thedomain);
            //                 $(domainWrapper + " .domain-name").html(thedomain);
            //                 $(domainWrapper).addClass("fd_"+thedomain.replace(".",""));
            //                 $(".domain-grid__list").removeClass(old_domain_class.replace(".",""));
            //             }else{
            //                 $(".domain-card .copy-url .copy-btn").attr({'disabled':true});
            //                 $("#url__text").text('');
            //                 //this will add new row in domain section
            //                 var new_domain_id = ares[2];
            //                 var new_html = '<div class="domain-grid__list domain_' + new_domain_id + '_' + client_id + ' fd_'+thedomain.replace(".","")+'">' +
            //                     '<span class="domain-name">' + thedomain + '</span>' +
            //                     '<div class="action action_options">' +
            //                     '<ul class="action__list">' +
            //                     '<li class="action__item">' +
            //                     '<a onclick="editdomainname(\'' + new_domain_id + '\',\''+client_id+'\')" href="javascript:void(0)" class="action__link btn-editCode">' +
            //                     '<span class="ico ico-edit"></span>edit' +
            //                     '</a>' +
            //                     '</li>' +
            //                     '<li class="action__item">' +
            //                     '<a onclick="deletedomainname(\'' + new_domain_id + '\',\''+client_id+'\')" href="javascript:void(0)" class="action__link btn-deleteCode">' +
            //                     '<span class="ico ico-cross"></span>delete' +
            //                     '</a>' +
            //                     '</li>' +
            //                     '</ul>' +
            //                     '<ul class="action__list">' +
            //                     '<li class="action__item">' +
            //                     '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
            //                     '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
            //                     '<i class="fa fa-circle" aria-hidden="true"></i>\n' +
            //                     '</li>' +
            //                     '</ul>' +
            //                     '</div>' +
            //                     '</div>';
            //
            //                 // var new_html = '<div class="domain-edit domain_'+new_domain_id+'_'+client_id+' domainlist fd_'+thedomain.replace(".","")+'"><span>'+thedomain+'</span> <a href="#" onclick="deletedomainname(\''+new_domain_id+'\',\''+client_id+'\')"><i class="fa fa-remove"></i>DELETE</a><a href="#" onclick="editdomainname(\''+new_domain_id+'\',\''+client_id+'\')"><i class="glyphicon glyphicon-pencil"></i>EDIT</a></div>';
            //                 $(".domain-grid").append(new_html);
            //
            //                 //if updating from sub-domain to domain and sub-domains fields still have values then reset it
            //                 if($("#subdomainname").val() != ""){
            //                     $("#checkboxsubdomainname").prop('checked', false);
            //                     $('#subdomainname').val("").attr('disabled',true);
            //
            //                     $("#checkboxsubdomainnametop").prop('checked', false);
            //                     $('#subdomaintoplist').attr('disabled',true);
            //                 }
            //                 subDomainFullURL('add');
            //                 $('.view-short-url-wrap').hide();
            //             }
            //             $("#main-submit").attr('disabled',true);
            //
            //         } else  {
            //             displayAlert('danger', 'Domain '+ thedomain + ' is not available.');
            //             $('#changedomainok').val('n');
            //         }
            //
            //         //reset fields
            //         ///// $("#checkboxdomainname").prop('checked', false);
            //         $('#domainname').val(thedomain).attr('disabled',true);
            //     },
            //     complete: function(response){
            //         //close modal box
            //         $('#modal_domain_available').modal('hide');
            //         // domainModule.stoppingAjaxRequest();
            //     },
            //     cache : false,
            //     async : false
            // });
        }
    },

    /**
     * Update old funnel URL in top menu and sticky bar
     */
    updateFunnelUrlInMenus: function (subDomain, topLevelDomain) {
        // $('.view a').attr('href','http://'+subdomain+'.'+topdomain);

        // $("#top-nav.navbar-default .navbar-nav > li > a > span.funnel-active").text(tersub);
        // $(".funnel-url-list li a.funnel-active").text(subdomain + '.' + topdomain);
        //
        // $(".selectedFunnel").text(subdomain + '.' + topdomain);

        var funnelUrl = (subDomain === false ? topLevelDomain : (subDomain + "." + topLevelDomain));

        // var oldFunnelUrl = $("#hdomain_name").val() + "." + $("#htop_level").val();
        // var el = $(".funnels-dropdown .funnel-link:contains('" + oldFunnelUrl + "')");
        // if(el) {
        //     el.text(funnelUrl);
        // }

        //setting text for selected item in menu
        $(".megamenu  > a.funnel-active").text(funnelUrl);

        //setting span text in top selected menu
        $(".actions-button__link_view-funnels").attr('href','http://'+funnelUrl);

        //updating sticky bar data-field value
        this.updateFunnelUrlInStickyBar(funnelUrl);
    },

    /**
     * StickyBar attribute will be updated
     * @param funnelUrl
     */
    updateFunnelUrlInStickyBar: function(funnelUrl) {
        // $('.view a').attr('href','http://'+subdomain+'.'+topdomain);
        // $('.edit-menu .sticky-icon #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);
        // $('.inner .sub-drop-down .sub-menu-wrapper #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);
        $('#sticky-bar-btn-menu').attr('data-field',funnelUrl);
    },

    /**
     * TO track button is immediately clicked OR not
     * @returns {boolean}
     */
    isImmediatelyClicked() {
        if (this.last_clicked) {
            this.time_since_clicked = Date.now() - this.last_clicked;
        }

        this.last_clicked = Date.now();

        if (this.time_since_clicked < 2000) {
            return true
        }
        return false;
    },

    /**
     * Set check if button is not immediately clicked if not immediately clicked than return isAjaxInProcess bit
     */
    isAjaxRequestInProcess: function () {
        if(this.isImmediatelyClicked()) {
            return true;
        }
        return this.isAjaxInProcess;
    },

    /**
     * Set isAjaxInProcess bit before starting AJAX request
     */
    startingAjaxRequest: function () {
        this.isAjaxInProcess = true;
    },

    /**
     * Reset isAjaxInProcess bit after AJAX request completion
     */
    stoppingAjaxRequest: function () {
        this.isAjaxInProcess = false;
    },

    /**
     * initialize modal close event, this will fix multiple AJAX request exceptional issue with modal
     * Exceptional issue - after AJAX request modal take some delay to hide it self, between that time if button is clicked it was sending request
     */
    initModalClosedEvents: function () {
        // $(document).on('hidden.bs.modal', '#modal_delete_domain', function (event) {
        $('#modal_delete_domain,#modal_domain_available, #modal_subdomain_available').on('hidden.bs.modal', function (){
            domainModule.stoppingAjaxRequest();
        });
    },

    /**
     * This function will send request to verify sub domain name
     * @param skipModal
     * @returns {boolean}
     */
    verifySubDomainName: function (skipModal) {
        // console.info("in");
        skipModal = skipModal !== undefined ? skipModal : false;
        var subname = $("#subdomainname").attr("disabled");
        var sublist = $('#subdomaintoplist').attr('disabled');
        var subdomain = "";
        var topdomain = "";
        subdomain = $("#subdomainname").val();
        topdomain = $("#subdomaintoplist").val();

        if(subdomain.indexOf('_') > 0) {
            displayAlert('danger', "Underscore characters are not allowed in domain names.");
            return false;
        }
        if((subname  == "disabled" && sublist == "disabled") || subdomain == "") {
            displayAlert('danger', "Enable sub-domain or top-level domain to continue. Sub-domain name is required.");
            return false;
        }
        else {
            ajaxRequestHandler.setActiveLoadingToastMessage(false);
            ajaxRequestHandler.sendRequest("/lp/ajax/checksubdomainavailable", function (d, isError) {
                console.log("checksubdomainavailable callback", d,isError);
                if (d == "ok") {
                    $('#changesubok').val('y');
                    if(skipModal){
                        domainModule.saveSubDomainName(skipModal);
                    }
                    else{
                        $("#modal_subdomain_available").find(".modal-msg").html('Sub-domain <strong class="domain-text">'+ subdomain + '.' + topdomain + '</strong> is&nbsp;available.<br /><br />By selecting a new sub-domain, you will be replacing the existing sub-domain this Funnel is using with the new one.');
                        setTimeout(function () {
                            $("#modal_subdomain_available").modal();
                        }, 1000);
                    }
                }else if (d == "taken") {
                    $(".ct-group").html('');
                    setTimeout(function () {
                        displayAlert('danger', 'That sub-domain is already in use. Please try something else.');
                    }, 1000)
                    $('#changesubok').val('n');
                }else {
                    hide();
                }
            }, "subdomain="+subdomain+"&topdomain="+topdomain+"&module=domain");

            // $.ajax( {
            //     type : "POST",
            //     data: "subdomain="+subdomain+"&topdomain="+topdomain+"&module=domain",
            //     url : "/lp/ajax/checksubdomainavailable",
            //     //url : "/checksubdomainavailable.php",
            //     success : function(d) {
            //         if (d == "ok") {
            //             $('#changesubok').val('y');
            //             if(skipModal){
            //                 hide();
            //                 domainModule.saveSubDomainName(skipModal);
            //             }
            //             else{
            //                 $("#modal_subdomain_available").find(".modal-msg").html('Sub-domain <strong class="domain-text">'+ subdomain + '.' + topdomain + '</strong> is&nbsp;available.<br /><br />By selecting a new sub-domain, you will be replacing the existing sub-domain this Funnel is using with the new one.');
            //                 setTimeout(function () {
            //                     hide();
            //                     $("#modal_subdomain_available").modal();
            //                 }, 1000);
            //             }
            //         }else if (d == "taken") {
            //             $(".ct-group").html('');
            //             setTimeout(function () {
            //                 hide();
            //                 displayAlert('danger', 'That sub-domain is already in use. Please try something else.');
            //             }, 1000)
            //             $('#changesubok').val('n');
            //         }else {
            //             hide();
            //         }
            //     },
            //     error:function(){
            //         hide();
            //     },
            //     complete: function(response){
            //         domainModule.stoppingAjaxRequest();
            //     },
            //     cache : false,
            //     async : false
            // });

        }
    },

    /**
     * This function will send AJAX request to save subdomain name
     * @param skipAjaxRequestInProcessValidation
     * @returns {boolean}
     */
    saveSubDomainName: function(skipAjaxRequestInProcessValidation) {
        skipAjaxRequestInProcessValidation = skipAjaxRequestInProcessValidation !== undefined ? skipAjaxRequestInProcessValidation : false;
        var subdomain = "";
        var topdomain = "";
        subdomain = $("#subdomainname").val();
        topdomain = $("#subdomaintoplist").val();
        var changesubok = $('#changesubok').val();
        var client_id = $('#client_id').val();
        var version_seq = $('#version_seq').val();
        var leadpop_id = $('#leadpop_id').val();
        var thedomain_id = $('#thedomain_id').val();
        var domaintype = $('#domaintype').val();
        if(subdomain == "" || changesubok == 'n' ||  changesubok == '' ) {
            $(".ct-group").html('');
            displayAlert('danger', "Sub-domain name is required.");
            return false;
        }
        else {
            var dstr = "domaintype="+domaintype+"&subdomain="+subdomain+"&topdomain="+topdomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id+"&_token="+ajax_token;
            $("#modal_subdomain_available").find(".modal-msg").html('Please Wait... Processing your request...');

            if(ajaxRequestHandler.isAjaxInProcess && !skipAjaxRequestInProcessValidation) {
                return false;
            }

            ajaxRequestHandler.sendRequest("/lp/popadmin/savechecksubdomainavailable", function (response, isError) {
                $("#modal_subdomain_available").modal('hide');
                let data = response.result;
                if (isError) {
                    if(data !== undefined && data.taken) {
                        console.log("sub domain taken.....");
                        $(".ct-group").html('');
                        $('#changesubok').val('n');
                    }
                } else {
                    $(".ct-group").html('');
                    domainModule.updateFunnelUrlInMenus(subdomain, topdomain);
                    $("#hdomain_name").val(subdomain);
                    $("#htop_level").val(topdomain);
                    $('#thedomain_id').val(data.domain_id);
                    $('#domaintype').val(data.domain_type);
                    $('#leadpop_id').val(data.leadpop_id);
                    $("#domainname").val('');
                    loadFunnel();
                    if(window.copy == 1){
                        copyToClipboard($('#url__text'));
                        setTimeout(function () {
                            displayToastAlert('success', 'Sub-domain has been saved and copied to clipboard.');
                            window.subdomainURL = $("#url__text").text();
                            $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
                        }, 3500);
                    }
                    else{
                        $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
                        displayAlert('success', 'Sub-domain '+ subdomain + '.' + topdomain + ' has been saved.');
                    }

                    var fullDomain = $("#url__text").text();
                    $('.menu__list.view a').attr('href', fullDomain)
                    $('.view-popup__url').text(fullDomain)
                    $("#main-submit").attr('disabled',true);
                }

                // remove domain list if updating domain to sub-domain
                if($(".domain-grid__list").not(".fd_temporary").length == 1){
                    $(".domain-grid__list").not(".fd_temporary").remove();
                }
                $("#checkboxdomainname").prop('checked', false);
            }, dstr);

            // if(domainModule.isAjaxRequestInProcess() && !skipAjaxRequestInProcessValidation) {
            //     return false;
            // }
            // domainModule.startingAjaxRequest();
            //
            // $.ajax( {
            //     type : "POST",
            //     data: dstr,
            //     url : "/lp/popadmin/savechecksubdomainavailable",
            //     error: function (e) {
            //         displayAlert('danger', 'Your request was not processed. Please try again.');
            //         $("#modal_subdomain_available").modal('toggle');
            //     },
            //     success : function(d) {
            //         $(".ct-group").html('');
            //         var cares = d.split("~");
            //         var slength = cares.length;
            //         //var  view_url='http://'+subdomain+topdomain;
            //         if(slength > 2) {
            //             domainModule.updateFunnelUrlInMenus(subdomain, topdomain);
            //
            //             $("#hdomain_name").val(subdomain);
            //             $("#htop_level").val(topdomain);
            //             $('#thedomain_id').val(cares[2]);
            //             $('#domaintype').val(cares[1]);
            //             $('#leadpop_id').val(cares[3]);
            //             $("#domainname").val('');
            //             loadFunnel();
            //             if(window.copy == 1){
            //                 copyToClipboard($('#url__text'));
            //                 setTimeout(function () {
            //                     displayToastAlert('success', 'Sub-domain has been saved and copied to clipboard.');
            //                     window.subdomainURL = $("#url__text").text();
            //                     $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
            //                 }, 3500);
            //             }
            //             else{
            //                 $(".domain-card .copy-url .copy-btn").attr({'disabled':false});
            //                 displayAlert('success', 'Sub-domain '+ subdomain + '.' + topdomain + ' has been saved.');
            //             }
            //
            //             var fullDomain = $("#url__text").text();
            //             $('.menu__list.view a').attr('href', fullDomain)
            //             $('.view-popup__url').text(fullDomain)
            //             $("#main-submit").attr('disabled',true);
            //         }else  {
            //             displayAlert('danger', 'That sub-domain is already in use. Please try something else.');
            //             $('#changesubok').val('n');
            //         }
            //
            //         // remove domain list if updating domain to sub-domain
            //         if($(".domain-grid__list").not(".fd_temporary").length == 1){
            //             $(".domain-grid__list").not(".fd_temporary").remove();
            //         }
            //         $("#checkboxdomainname").prop('checked', false);
            //     },
            //     complete: function(response){
            //         $("#modal_subdomain_available").modal('hide');
            //         // domainModule.stoppingAjaxRequest();
            //     },
            //     cache : false,
            //     async : false
            // });
        }
    }

};

//copy and open url hide/show according the domain and subdomain enable
function subDomainFullURL(ele){
    if(typeof ele != "undefined" && ele === 'add') {
        jQuery(".short-icon,#make_shorten_url,.url-expand").addClass('d-none');
    }
    else{
        jQuery(".short-icon,#make_shorten_url,.url-expand").removeClass('d-none');
    }
}


/**
 * this function compare the last save value with new values.
 * if new values and last saved value did not match then will be save btn enable otherwise btn will disable.
 */
function onChangeDomainHandleButton() {
    let stats = true,
        domainName = $("#domainname").val(),
        savedDomain = $.map(jQuery(".domain-name"),(e) => {return $.trim(jQuery(e).html())});
    if(domainName) {
        if (jQuery.inArray(domainName, savedDomain) == -1) {
            stats = false;
        }
    }
    ajaxRequestHandler.changeSubmitButtonStatus(stats);
}

function domainFromValidation(){

    $.validator.addMethod("cus_url", function (value, element) {
        return this.optional(element) || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
    }, "Please enter a valid URL.");

    $('#subdomain').validate({
        rules: {
            domainname: {
                required: true,
                cus_url: true
            }
        },
        debug: false,
        submitHandler: function () {
            console.info('submitted');
        }
    });
}
