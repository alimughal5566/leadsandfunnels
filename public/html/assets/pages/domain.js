(function ($) {
    $(document).ready(function() {
        var amIclosing = false;
        //$('.domainlist.temporary').hide();
        $('#subdomaintoplist').select2({
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select2top-lvl-domain-parent')
        }).on("select2:select", function () {
            var select_val = $(this).val();
            var get_txt = $("#subdomainname").val();
            var url_txt = 'https://' + get_txt +'.'+ select_val;
            $("#url__text").text(url_txt);
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
            $("#url__text").html(url_txt);
            $(this).val(string);
            if ($(this).val() == ''){
                $("#url__text").html('');
            }
        });

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

        $.validator.addMethod("cus_url", function (value, element) {
            return this.optional(element) || /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test(value);
        }, "Please enter a valid url.");

        $('#subdomain').validate({
            rules: {
                domainname: {
                    required: true,
                    cus_url: true
                }
            },
            debug: true,
            submitHandler: function () {
                console.info('submitted');
            }
        });

        $('.button-save').click(function () {
            $('#subdomain').submit();
        })

    });
})(jQuery);

function copyToClipboard(element) {
    var $temp = $("<INPUT>");
    $("body").append($temp);
    $temp.val($.trim($(element).text())).select();
    document.execCommand("copy");
    $temp.remove();
}
$('#clone-url').click(function(){
    if($('#url__text').text()){
        copyToClipboard($('#url__text'));
        var html = '<div class="alert alert-success lp-success-msg">'+
            'Success! Sub-domain URL has been copied.'+
            '</div>';
        $(html).hide().appendTo("#msg").slideDown(500).delay(1000).slideUp(500 , function(){
            $(this).remove();
        });
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
    } else {
        $('#domainname').attr('disabled','disabled');
        $('#domainname').val("");
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
        data : "deleteThisDomain=" + ids[0], // global from above
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

                $('.view a').attr('href','http://'+subdomain+'.'+topdomain);
                $("#hdomain_name").val(subdomain);
                $("#htop_level").val(topdomain);
                $(".selectedFunnel").html(subdomain + '.' + topdomain);
                var tersub=(subdomain.length > 16)?subdomain.substring(0,16)+"...": subdomain;
                $("#top-nav.navbar-default .navbar-nav > li > a > span.funnel-active").text(tersub);
                $(".funnel-url-list li a.funnel-active").text(subdomain + '.' + topdomain);

                $(".selectedFunnel").text(subdomain + '.' + topdomain);


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
    if(thedomain.indexOf('_') > 0) {
        notification.error(notification_container, "Underscore characters are not allowed in domain names.");
        return false;
    }

    if((booldomain  == true) || thedomain == "" ) {
        notification.error(notification_container, "Please enter your domain name.");
        return false;
    }
    else if (nameok == false) {
        notification.error(notification_container, "Please enter a valid domain name.");
        return false;
    }
    else {
        notification.loading(notification_container);
        $.ajax( {
            type : "POST",
            data: "thedomain="+thedomain,
            url : "/checkdomainavailable.php",
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
        var datastr = "domaintype="+domaintype+"&thedomain="+thedomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id + "&hasunlimited=" + hasunlimited + "&beforedomainname=" + beforedomainname;
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

                if(slength > 2) {
                    $("#hdomain_name").val(thedomain);
                    $("#htop_level").val('');
                    $('#thedomain_id').val(ares[2]);
                    $('#domaintype').val(ares[1]);
                    $('#leadpop_id').val(ares[3]);

                    $('.view a').attr('href','http://'+thedomain);
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
                    $(".selectedFunnel").text(thedomain);

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
        url : "/getDomainFromId.php",
        data : "client_id=" + client_id + "&domain_id=" + domain_id,
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
            data: "subdomain="+subdomain+"&topdomain="+topdomain,
            url : "/lp/popadmin/checksubdomainavailable",
            //url : "/checksubdomainavailable.php",
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
        var dstr = "domaintype="+domaintype+"&subdomain="+subdomain+"&topdomain="+topdomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id;
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
                    $("#hdomain_name").val(subdomain);
                    $("#htop_level").val(topdomain);
                    $('#thedomain_id').val(cares[2]);
                    $('#domaintype').val(cares[1]);
                    $('#leadpop_id').val(cares[3]);
                    //$(".selectedFunnel").html(subdomain + '.' + topdomain);
                    var tersub=(subdomain.length > 16)?subdomain.substring(0,16)+"...": subdomain;
                    $("#top-nav.navbar-default .navbar-nav > li > a > span.funnel-active").text(tersub);
                    $(".funnel-url-list li a.funnel-active").text(subdomain + '.' + topdomain);

                    $(".selectedFunnel").text(subdomain + '.' + topdomain);

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
        var dstr = "domaintype="+domaintype+"&subdomain="+subdomain+"&topdomain="+topdomain+"&client_id="+client_id+"&version_seq="+version_seq+"&leadpop_id="+leadpop_id+"&thedomain_id="+thedomain_id;
        $("#modal_subdomain_available").find(".modal-msg").html('Please Wait... Processing your request...');
        $.ajax( {
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

                    $("#hdomain_name").val(subdomain);
                    $("#htop_level").val(topdomain);
                    $('#thedomain_id').val(cares[2]);
                    $('#domaintype').val(cares[1]);
                    $('#leadpop_id').val(cares[3]);
                    //$(".selectedFunnel").html(subdomain + '.' + topdomain);
                    var tersub=(subdomain.length > 16)?subdomain.substring(0,16)+"...": subdomain;
                    $("#top-nav.navbar-default .navbar-nav > li > a > span.funnel-active").text(tersub);
                    $(".funnel-url-list li a.funnel-active").text(subdomain + '.' + topdomain);

                    $(".selectedFunnel").text(subdomain + '.' + topdomain);

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