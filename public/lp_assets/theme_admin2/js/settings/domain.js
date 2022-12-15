(function ($) {
    $(document).ready(function() {
        //$('.domainlist.temporary').hide();

        $('a[href="#"]').click(function(e){
            e.preventDefault();
        });

        $("#domain_btn").click(function(e){
            e.preventDefault();
            verifyopendomain();
        });

        $("#_save_open_subdomain").click(function(e){
            saveopensubdomain();
        });

        $("#_save_open_subdomain_test").click(function(e){
            saveopensubdomaintest();
        });
        $("#_save_open_domain").click(function(e){saveopendomain();});
        $("#_delete_domain_btn").click(function(e){ deletedomain();});

        /* Sub domain validatin Start */
        /* Saif */

        $('#subdomainname').blur(function () {
            var $slug = '';
            var trimmed = $.trim($(this).val());
            $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            replace(/-+/g, '-').
            replace(/^-|-$/g, '');
            $(this).val($slug.toLowerCase());
        });
        /* Sub domain validatin end */

        $('#domainname').keyup(function () {
            own_domain_validation();
        });

    });
})(jQuery);

function own_domain_validation() {
        var regex = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\-]+\.[a-zA-Z]{2,5}[\.]{0,1}[a-zA-Z]*|^$/;
        var url = $('#domainname').val();
        if($('#checkboxdomainname').prop("checked")){
            if(url.match(regex) == null){
                $('#domainname').removeClass("error");
                $('#domainname-error').remove();
                $('#domainname').addClass("error");
                $('#domainname').after('<label id="domainname-error" class="error" style="margin-left: 148px" for="domainname">Please enter a valid URL.</label>');
                return false;
            }else {
                $('#domainname').removeClass("error");
                $('#domainname-error').remove();
            }
        }
}

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
    $('#subdomaintoplist').selectpicker('refresh');
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
        $('#domainname').removeClass('error');
        $('#domainname-error').remove();
    } else {
        $('#domainname').attr('disabled','disabled');
        $('#domainname').val("");
        $('#domainname').removeClass('error');
        $('#domainname-error').remove();

    }
}

/* Delete Domain Functions */
function deletedomainname(domain_id, client_id) {
    $("#modal_delete_domain").find(".modal-msg").html('<p>Do you want to delete this domain ?</p>');
    $("#modal_delete_domain").find('#_delete_domain_id').val(domain_id+"_"+client_id);
    $("#modal_delete_domain").modal();
}

function deletedomain() {
    var subdomain = "";
    var topdomain = "";
    var _olddomain = "";
    var notification_container = ".lp-subdomain-notifcations";
    var elem = $("#modal_delete_domain").find(".modal-msg").html('Please Wait... Processing your request...');
    var domain_client = $("#modal_delete_domain").find('#_delete_domain_id').val();
    var ids = domain_client.split("_");
    $.ajax( {
        type : "POST",
        url : "/lp/popadmin/deletethisdomain",
        data : "deleteThisDomain=" + ids[0]+"&_token="+ajax_token, // global from above
        success : function(d) {
            var cares = d.split("~");
            var slength = cares.length;
            if(slength > 2) {
                subdomain = cares[4];
                topdomain = cares[5];
                _olddomain = cares[6];

                $('#thedomain_id').val(cares[2]);
                $('#domaintype').val(cares[1]);
                $('#leadpop_id').val(cares[3]);
                $('#subdomainname').val(cares[4]);
                $('#subdomaintoplist').val(cares[5]);
                $(".cloneFunnelSubdomainBtn").attr('data-top-domain','itclix.com');
                $('.view a').attr('href','http://'+subdomain+'.'+topdomain);
                $('.edit-menu .sticky-icon #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);
                $('.inner .sub-drop-down .sub-menu-wrapper #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);
                $("#hdomain_name").val(subdomain);
                $("#htop_level").val(topdomain);
                //$(".selectedFunnel").html(subdomain + '.' + topdomain);
                var tersub=(subdomain.length > 16)?subdomain.substring(0,16)+"...": subdomain;
                $("#top-nav.navbar-default .navbar-nav > li > a > span.funnel-active").text(tersub);
                $(".funnel-url-list li a.funnel-active").text(subdomain + '.' + topdomain);

                //$(".selectedFunnel").text(subdomain + '.' + topdomain);


                // $("#checkboxsubdomainname").prop('checked', true);
                // $('#subdomainname').attr('disabled',false);

                // $("#checkboxsubdomainnametop").prop('checked', true);
                // $('#subdomaintoplist').attr('disabled',false);


                notification.success(notification_container, 'Success! Domain '+ _olddomain + ' has been Deleted.');
            }else  {
                $("#modal_subdomain_available").modal('toggle');
                $('#changesubok').val('n');
            }

            //window.location.href = '/lp/popadmin/domain/' + $("#current_hash").val();
            $(".domain_"+domain_client).remove();
            $('#modal_delete_domain').modal('toggle');

            if($(".domainlist").length == 0){
                $("#checkboxdomainname").prop('checked', true);
                $('#domainname').attr('disabled',false);
                $('#domainname').val("");
                $('#beforedomainname').val("");     // if this is reset then it will add new entry
                $('#domainname').focus();
            }
        },
        cache : false,
        async : false
    });
}


function verifyopendomain() {
    //var notification_container = ".lp-domain-notifcations";
    var notification_container = ".lp-subdomain-notifcations";
    var booldomain = $("#domainname").prop('disabled');
    var thedomain = "";
    thedomain = $("#domainname").val();
    var nameok = domainNameValid(thedomain);
    if($('#checkboxdomainname').prop("checked")){
        if($('#domainname').hasClass('error')){
            return false;
        }
    }
    if(thedomain.indexOf('_') > 0) {
        notification.error(notification_container, "Underscore characters are not allowed in domain names.");
        return false;
    }

    if((booldomain  == true) || thedomain == "" ) {
        own_domain_validation();
        notification.error(notification_container, "Please enter your domain name.");
        return false;
    }
    else if (nameok == false) {
        own_domain_validation();
        notification.error(notification_container, "Please enter a valid domain name.");
        return false;
    }
    else {
        own_domain_validation();
        notification.loading(notification_container);
        $.ajax( {
            type : "POST",
            data: "thedomain="+thedomain+"&_token="+ajax_token,
            url : "/lp/ajax/checkdomainavailable",
            success : function(d) {

                if (d == "ok") {

                    $(notification_container).html('');
                    $("#modal_domain_available").find(".modal-msg").html('Domain '+ thedomain  + ' is available. <br /><br />Using a domain deletes any existing sub-domains.');
                    $("#modal_domain_available").modal();
                    $('#changedomainok').val('y');
                }
                else if (d == "taken") {
                    notification.error(notification_container, 'Domain '+ thedomain  + ' is not available.');
                    $('#changedomainok').val('n');
                    $('html, body').animate({
                        scrollTop: $(notification_container).offset().top - 100
                    }, 500);
                }
            },
            cache : false,
            async : false
        });

    }
}

function saveopendomain() {
   // console.info("saveopendomain");
    // var notification_container = ".lp-domain-notifcations";
    var notification_container = ".lp-subdomain-notifcations";
    var changedomainok = $('#changedomainok').val();
    var client_id = $('#client_id').val();
    var version_seq = $('#version_seq').val();
    var leadpop_id = $('#leadpop_id').val();
    var thedomain_id = $('#thedomain_id').val();
    var domaintype = $('#domaintype').val();
    var thedomain = $("#domainname").val();
    var nameok = domainNameValid(thedomain);
    var hasunlimited = $("#hasunlimited").val();
    var beforedomainname = $('#beforedomainname').val();
    if( thedomain == "" || changedomainok == 'n'  || changedomainok == '') {
        notification.error(notification_container, 'Unverified domain name cannot be saved.');
        //$('#savechangesubdomaindiv').dialog('open');
        return false;
    }
    else if (nameok == false) {
        $('#baddomainname').dialog('open');
        return false;
    }
    else {
        var datastr = "domaintype="+domaintype+"&thedomain="+thedomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id + "&hasunlimited=" + hasunlimited + "&beforedomainname=" + beforedomainname+"&_token="+ajax_token;
        $("#modal_domain_available").find(".modal-msg").html('Please Wait... Processing your request...');
        $.ajax( {
            type : "POST",
            data: datastr ,
            url : "/lp/popadmin/savecheckdomainavailable",
            error: function (e) {
                notification.error(notification_container, 'Your request was not processed. Please try again.');
            },
            success : function(d) {
                var ares = d.split("~");
                var slength = ares.length;

                if($('#checkboxdomainname').prop("checked")){
                    $('#checkboxdomainname').prop('checked', false);
                }


                    if(slength > 2) {
                    $("#hdomain_name").val(thedomain);
                    $("#htop_level").val('');
                    $('#thedomain_id').val(ares[2]);
                    $('#domaintype').val(ares[1]);
                    $('#leadpop_id').val(ares[3]);
                    $(".cloneFunnelSubdomainBtn").attr('data-top-domain','secure-clix.com');

                    $('.view a').attr('href','http://'+thedomain);
                    $('.edit-menu .sticky-icon #sticky-bar-btn-menu').attr('data-field',thedomain);
                    $('.inner .sub-drop-down .sub-menu-wrapper #sticky-bar-btn-menu').attr('data-field',thedomain);
                    notification.success(notification_container, 'Success! Domain '+ thedomain + ' has been saved.');

                    //for edit case
                    if(beforedomainname != ""){
                        //this will update existing row
                        var old_domain_class = ".fd_"+beforedomainname.replace(".","");
                        $(old_domain_class).show();
                        //$(old_domain_class+" span").html(thedomain);
                        $(".domain_"+thedomain_id+"_"+client_id+" span").html(thedomain);
                        $(old_domain_class).addClass("fd_"+thedomain.replace(".",""));
                        $(".domainlist").removeClass(old_domain_class.replace(".",""));
                    }else{
                        //this will add new row in domain section
                        var new_domain_id = ares[2];
                        var new_html = '<div class="domain-edit domain_'+new_domain_id+'_'+client_id+' domainlist fd_'+thedomain.replace(".","")+'"><span>'+thedomain+'</span> <a href="#" onclick="deletedomainname(\''+new_domain_id+'\',\''+client_id+'\')"><i class="fa fa-remove"></i>DELETE</a><a href="#" onclick="editdomainname(\''+new_domain_id+'\',\''+client_id+'\')"><i class="glyphicon glyphicon-pencil"></i>EDIT</a></div>';
                        $(".domain-grid").append(new_html);

                        //if updating from sub-domain to domain and sub-domains fields still have values then reset it
                        if($("#subdomainname").val() != ""){
                            $("#checkboxsubdomainname").prop('checked', false);
                            $('#subdomainname').val("").attr('disabled',true);

                            $("#checkboxsubdomainnametop").prop('checked', false);
                            $('#subdomaintoplist').attr('disabled',true);
                        }
                    }
                    //$(".selectedFunnel").text(thedomain);

                } else  {
                    notification.error(notification_container, 'Domain '+ thedomain + ' is not available.');
                    $('#changedomainok').val('n');
                }

                //reset fields
                ///// $("#checkboxdomainname").prop('checked', false);
                $('#domainname').val("").attr('disabled',true);

                //close modal box
                $('#modal_domain_available').modal('hide');
                $(notification_container).fadeTo(3000, 500).slideUp(500, function(){
                        $(this).slideUp(500);
                });
                $("#domainname").val(thedomain);
            },
            cache : false,
            async : false
        });
    }
}

function editdomainname(domain_id,client_id) {
    $('#thedomain_id').val(domain_id);
    $("#checkboxdomainname").prop('checked', true);

    $('#domainname').val("");
    $('#beforedomainname').val("");
    $('#domainname').attr('disabled',false);

    $.ajax( {
        type : "POST",
        url : "/lp/ajax/getdomainfromid",
        data : "client_id=" + client_id + "&domain_id=" + domain_id+"&_token="+ajax_token,
        success : function(d) {
            $('#domainname').val("");
            $('#domainname').val(d);
            $('#beforedomainname').val(d);
            $('#domainname').focus();
        },
        cache : false,
        async : false
    });
}

function verifyopensubdomain() {
   // console.info("in");
    var notification_container = ".lp-subdomain-notifcations";
    var subname = $("#subdomainname").attr("disabled");
    var sublist = $('#subdomaintoplist').attr('disabled');
    var subdomain = "";
    var topdomain = "";
    subdomain = $("#subdomainname").val();
    topdomain = $("#subdomaintoplist").val();

    if(subdomain.indexOf('_') > 0) {
        notification.error(notification_container, "Underscore characters are not allowed in domain names.");
        return false;
    }
    if((subname  == "disabled" && sublist == "disabled") || subdomain == "") {
        notification.error(notification_container, "Enable sub-domain or top-level domain to continue. Sub-domain name is required.");
        return false;
    }
    else {
        //notification.loading(notification_container);
        $.ajax( {
            type : "POST",
            data: "subdomain="+subdomain+"&topdomain="+topdomain+"&_token="+ajax_token,
            url : "/lp/ajax/checksubdomainavailable",
            success : function(d) {
                if (d == "ok") {
                    $(notification_container).html('');
                    $("#modal_subdomain_available").find(".modal-msg").html('Sub-domain '+ subdomain + '.' + topdomain + ' is available.<br /><br />Using a sub-domain deletes any existing domains.');
                    $("#modal_subdomain_available").modal();
                    $('#changesubok').val('y');
                }else if (d == "taken") {
                    notification.error(notification_container, 'Sub-domain '+ subdomain + '.' + topdomain + ' is not available.');
                    $('#changesubok').val('n');
                }
            },
            cache : false,
            async : false
        });

    }
}

function saveopensubdomain() {
    var notification_container = ".lp-subdomain-notifcations";
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
        notification.error(notification_container, "Sub-domain name is required.");
        return false;
    }
    else {
        var dstr = "domaintype="+domaintype+"&subdomain="+subdomain+"&topdomain="+topdomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id+"&_token="+ajax_token;
        $("#modal_subdomain_available").find(".modal-msg").html('Please Wait... Processing your request...');
        $.ajax( {
            type : "POST",
            data: dstr,
            url : "/lp/popadmin/savechecksubdomainavailable",
            error: function (e) {
                notification.error(notification_container, 'Your request was not processed. Please try again.');
                $("#modal_subdomain_available").modal('toggle');
            },
            success : function(d) {
                var cares = d.split("~");
                var slength = cares.length;
                //var  view_url='http://'+subdomain+topdomain;
                if(slength > 2) {
                    $('.view a').attr('href','http://'+subdomain+'.'+topdomain);
                    $('.edit-menu .sticky-icon #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);
                    $('.inner .sub-drop-down .sub-menu-wrapper #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);

                    $("#hdomain_name").val(subdomain);
                    $("#htop_level").val(topdomain);
                    $('#thedomain_id').val(cares[2]);
                    $('#domaintype').val(cares[1]);
                    $('#leadpop_id').val(cares[3]);
                    $("#domainname").val('');
                    //$(".selectedFunnel").html(subdomain + '.' + topdomain);
                    var tersub=(subdomain.length > 16)?subdomain.substring(0,16)+"...": subdomain;
                    $("#top-nav.navbar-default .navbar-nav > li > a > span.funnel-active").text(tersub);
                    $(".funnel-url-list li a.funnel-active").text(subdomain + '.' + topdomain);

                    //$(".selectedFunnel").text(subdomain + '.' + topdomain);

                    notification.success(notification_container, 'Success! Sub-domain '+ subdomain + '.' + topdomain + ' has been saved.');
                    $("#modal_subdomain_available").modal('toggle');
                }else  {
                    notification.error(notification_container, 'Error: Sub-domain '+ subdomain + '.' + topdomain + ' is not available.');
                    $("#modal_subdomain_available").modal('toggle');
                    $('#changesubok').val('n');
                }

                // remove domain list if updating domain to sub-domain
                if($(".domainlist").not(".fd_temporary").length == 1){
                    $(".domainlist").not(".fd_temporary").remove();
                }
                $("#checkboxdomainname").prop('checked', false);

                $(notification_container).fadeTo(3000, 500).slideUp(500, function(){
                        $(this).slideUp(500);
                });
            },
            cache : false,
            async : false
        });

    }

}
function saveopensubdomaintest() {
    var notification_container = ".lp-subdomain-notifcations";
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
        notification.error(notification_container, "Sub-domain name is required.");
        return false;
    }
    else {
        var dstr = "domaintype="+domaintype+"&subdomain="+subdomain+"&topdomain="+topdomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id+"&_token="+ajax_token;
        $("#modal_subdomain_available").find(".modal-msg").html('Please Wait... Processing your request...');
        $.ajax({
            type : "POST",
            data: dstr,
            url : "/lp/popadmin/savechecksubdomainavailabletest",
            error: function (e) {
                notification.error(notification_container, 'Your request was not processed. Please try again.');
                $("#modal_subdomain_available").modal('toggle');
            },
            success : function(d) {
                var cares = d.split("~");
                var slength = cares.length;
                //var  view_url='http://'+subdomain+topdomain;
                if(slength > 2) {
                    console.info('http://'+subdomain+'.'+topdomain);
                    $('.view a').attr('href','http://'+subdomain+'.'+topdomain);
                    $('.edit-menu .sticky-icon #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);
                    $('.inner .sub-drop-down .sub-menu-wrapper #sticky-bar-btn-menu').attr('data-field',subdomain+'.'+topdomain);
                    $("#hdomain_name").val(subdomain);
                    $("#htop_level").val(topdomain);
                    $('#thedomain_id').val(cares[2]);
                    $('#domaintype').val(cares[1]);
                    $('#leadpop_id').val(cares[3]);
                    //$(".selectedFunnel").html(subdomain + '.' + topdomain);
                    var tersub=(subdomain.length > 16)?subdomain.substring(0,16)+"...": subdomain;
                    $("#top-nav.navbar-default .navbar-nav > li > a > span.funnel-active").text(tersub);
                    $(".funnel-url-list li a.funnel-active").text(subdomain + '.' + topdomain);

                    //$(".selectedFunnel").text(subdomain + '.' + topdomain);

                    notification.success(notification_container, 'Success! Sub-domain '+ subdomain + '.' + topdomain + ' has been saved.');
                    $("#modal_subdomain_available").modal('toggle');
                }else  {
                    notification.error(notification_container, 'Error: Sub-domain '+ subdomain + '.' + topdomain + ' is not available.');
                    $("#modal_subdomain_available").modal('toggle');
                    $('#changesubok').val('n');
                }

                // remove domain list if updating domain to sub-domain
                if($(".domainlist").not(".fd_temporary").length == 1){
                    $(".domainlist").not(".fd_temporary").remove();
                }
                $("#checkboxdomainname").prop('checked', false);

                $(notification_container).fadeTo(3000, 500).slideUp(500, function(){
                        $(this).slideUp(500);
                });
            },
            cache : false,
            async : false
        });

    }

}
