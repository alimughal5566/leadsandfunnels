/**
 * Created by root on 6/13/17.
 */

var _list = {};
jQuery(document).ready(function (e) {


// JS starts here
    jQuery('html').removeClass('noscroll');

    // $('.other-back').hide();
    // $(document).on('click' , '#forgot-password' ,function(){
    //     $('.other-front').hide();
    //     $('.other-back').show();
    // });
    // $(document).on('click' , '#forgot-revert' ,function(){
    //     $('.other-back').hide();
    //     $('.other-front').show();
    //
    // });

    //$("#modal_landingPages").modal("show");
    // $(".tab-pane:last-child .funnel-url-list:last-child").addClass('last');
   /* var lp_right = ($('.container').offset().left)/2;
    $('.show-banner-nob').css({'right' : lp_right+'px' });
    r = lp_right;
    if(lp_right < 15)r=parseInt(lp_right+10);
    $('.super_banner__close').css({'right' : r+'px' });
    $(window).resize(function(){
        var lp_right = ($('.container').offset().left)/2;
        r = lp_right;
        if(lp_right < 15)r=parseInt(lp_right+10);
        $('.show-banner-nob').css({'right' : lp_right+'px' });
        $('.super_banner__close').css({'right' : r+'px' });
    });*/
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
            /*var lp_right = ($('.container').offset().left)/2;
            $('.show-banner-nob').css({'right' : lp_right+'px' });*/
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

        // $('.lp-lpcustom-scroll').mCustomScrollbar('destroy');
        // scroll-3

        /*$(".mega-dropdown-menu").mCustomScrollbar({
            // setHeight:175
            scrollInertia: 3000,
            autoExpandScrollbar: false,
            mouseWheel: {scrollAmount: 1000},
            set_height: 'auto',
            advanced: {
                updateOnBrowserResize: true
            }
        });*/
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
    $(".product-dropdown .dropdown-list li.selectable").click(function() {
        if($("#funnels-section").length == 0){
            self.location = "/lp/";
            return false;
        }

        if($(this).attr('data-navlink') == "conversion_pro_website"){ // ConversionPro Website
            if( $(this).attr("data-type_available") == "1" ){
                $(".vertical-select-menu, .ft-select-menu").css("visibility", 'visible');
                $(".product_landingpages").removeClass('active');
                var fns = $(".vertical-select-menu").find('[name=cd-dropdown]').val();
                $("."+fns+"-funnels").addClass('active');

                setTimeout(function(){
                    $(".mortgage-funnel-type").find("li[data-ftslug='w']").trigger('click');
                    $(".lp-type-dropdown").removeClass('open');
                },100);

                // for selected link
                var _dropdown = $(this).closest('.product-dropdown');
                _dropdown.find('.prodText').text("ConversionPro");
                _dropdown.removeClass('active');
                $('.top-products').removeClass('opened');

            } else {
                var selectedVerticalTxt = $(".vertical-dropdown li.selectable[data-value='"+$(".vertical-dropdown").attr("data-value")+"']").find('span').html();
                var _dropdownType = $(".vertical-dropdowntype .dropdown-list li").closest('.vertical-dropdowntype');
                if(selectedVerticalTxt != undefined)
                    _dropdownType.find('.verText').text(selectedVerticalTxt+" Funnels");
                _dropdownType.find('input[name=cd-dropdown]').val("mortgage-funnels");
                $(".modal_mortgageWebsiteFunnel_client_type").html($(this).attr("data-client-type"))
                $("#modal_mortgageWebsiteFunnel").modal('show')
            }
        } else if($(this).attr('data-navlink') == "product_landingpages"){ // Landing Pages
            if($(this).attr('data-value') == 1){
                $(".vertical-select-menu, .ft-select-menu").css("visibility", 'hidden');
                $(".product_landingpages").addClass('active');
                $(".product_funnels").removeClass('active');

                // for selected link
                var _dropdown = $(this).closest('.product-dropdown');
                _dropdown.find('.prodText').text($(this).text().trim());
                _dropdown.removeClass('active');
                $('.top-products').removeClass('opened');

                // resetting type dropdown to "f" flag
                $("ul").find("[data-ftslug='w']").removeClass('active');
                $("ul").find("[data-ftslug='f']").addClass('active');
                var _dropdown = $("ul").find("[data-ftslug='f']").closest('.vertical-dropdowntype');
                var selectedVerticalTxt = $(".vertical-dropdown li.selectable[data-value='"+$(".vertical-dropdown").attr("data-value")+"']").find('span').html();
                _dropdown.find('.verText').text(selectedVerticalTxt+" Funnels");
                $('.funnels-details').funnel_loader();
            }else{
                var _dropdown = $(this).closest('.product-dropdown');
                _dropdown.find('.prodText').text("Funnels 2.0");
                $("#modal_landingPages").modal('show')
            }
        }else if($(this).attr('data-navlink') == "supercalc_io"){
            console.info("test");
            window.open('https://supercalc.io');
            return true;
        }else{  // Funnels
            $(".vertical-select-menu, .ft-select-menu").css("visibility", 'visible');
            $(".product_landingpages").removeClass('active');

            var fns = $(".vertical-select-menu").find('[name=cd-dropdown]').val();
            $("."+fns+"-funnels").addClass('active');

            // for selected link
            var _dropdown = $(this).closest('.product-dropdown');
            _dropdown.find('.prodText').text($(this).text().trim());
            _dropdown.removeClass('active');
            $('.top-products').removeClass('opened');
        }
    });

    /* Type Dropdown Trigger */
    $(".vertical-dropdowntype .dropdown-list li").click(function() {
        /* if second option is selected in type and its type is not equal to vertical then change vertical
         *     e.g if user type is mortgage and second value in dropdown should be mortgage website funnels...
         *         if user clicks on mortgage website funnels and vertical has different value then it should reset vertical to mortgage.
         *         similar for other verticals & types like if user type is insurance and clicks on insurance website funnels and vertical has different value then it should reset vertical to insurance.
         */

        // if($.trim($('.vertical-dropdown').find('.verText').text()) === "Mortgage"){
        $('.mortgage-funnels').find('.section-title').text('Mortgage Funnels');
        if($(this).attr('data-value') === "mortgage-website-funnels"){
            $('.mortgage-funnels').find('.section-title').text('Mortgage Website Funnels');
        }

        if($(this).attr("data-type_available") == "1" && $(this).attr("data-ftslug") == "w" && ($(this).attr("data-value").replace("-website-funnels","") != $(".vertical-dropdown").attr("data-value")) ){
            resetVerticalDropdown($(this));
        }

        var _dropdown = $(this).closest('.vertical-dropdowntype');
        _dropdown.find('.verText').text($(this).text().trim());
        _dropdown.find('input[name=cd-dropdown]').val($(this).data('value'));
        $('.vertical-dropdowntype .dropdown-list li').removeClass('active');
        $(this).addClass('active');

        if( $(this).attr("data-type_available") == "1" ){
            $('.funnels-details').funnel_loader();
        } else {
            //_dropdown.find('.verText').text($(this).attr("data-client-type")+" Funnels");
            var selectedVerticalTxt = $(".vertical-dropdown li.selectable[data-value='"+$(".vertical-dropdown").attr("data-value")+"']").find('span').html();
            _dropdown.find('.verText').text(selectedVerticalTxt+" Funnels");
            _dropdown.find('input[name=cd-dropdown]').val("mortgage-funnels");
            $(".modal_mortgageWebsiteFunnel_client_type").html($(this).attr("data-client-type"))
            $("#modal_mortgageWebsiteFunnel").modal('show')
        }

    });

    /* Vertical Dropdown Trigger */
    $(".vertical-dropdown .dropdown-list li.selectable").click(function() {
        update_type_dropdown($(this));

        // resetting type dropdown back to "f"
        $(".vertical-dropdowntype .dropdown-list li").removeClass('active');
        $(".vertical-dropdowntype .dropdown-list li[data-ftslug=f]").addClass('active');
        var _ftslug = $(".vertical-dropdowntype .dropdown-list li.active").data('ftslug');
        $('.funnels-details').funnel_loader();
        if($(this).data('value') === 'mortgage'){
            $('.mortgage-funnels').find('.section-title').text('Mortgage Funnels');
        }
        var _dropdown = $(this).closest('.vertical-dropdown');
        _dropdown.find('.verText').text($(this).text().trim());
        _dropdown.find('input[name=cd-dropdown]').val($(this).data('value'));
        $('.vertical_container').removeClass('active');
        $("."+$(this).data('value')+'-funnels').addClass('active');
        var show_train=false;
        if($(this).data("value")){
            var sel_ver=$(this).data("value");
            sel_ver=sel_ver.replace(" ", "-").toLowerCase();
            // $("#train-module a#lp-train-module").attr("data-ov-target","lp-ol-"+sel_ver);
            if($(".lp-ol-"+sel_ver).length){
                show_train=true;
            }
        }
        /*
        if(show_train==true){
            $("#train-module").show();
        }else{
            $("#train-module").hide();
        }
        */
    });

    // fix for User List navigation
    $(".dropdown .user-list li a").click(function(e) {
        e.preventDefault();
        self.location = $(this).attr('href');
    });

    // $(".drop-menu").click(function() {
    //     if ($(this).hasClass('open')) {
    //         $(this).removeClass('open');
    //     } else {
    //         $(this).addClass('open');
    //     };
    // });
    // $(this).on('click', '.drop-menu > a', function(e) {
    //     e.preventDefault();
    //     var drop_menu = $(this).closest('.drop-menu');
    //     if (drop_menu.hasClass('open')) {
    //         drop_menu.removeClass('open');
    //     } else {
    //         drop_menu.addClass('open');
    //     };
    // });
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

    // $(".product-dropdown .dropdown-list li.selectable").click(function() {
    //     $('.prodText').text($(this).text().trim());
    //     $('.product-dropdown').removeClass('active');
    //     $('.top-products').removeClass('opened');
    // });
    // $(".business-dropdown .dropdown-list li.selectable").click(function() {
    //     $('.selText').text($(this).text().trim());
    //     $('.business-dropdown').removeClass('active');
    // });
    // $(".business-dropdown .dropdown-list li").click(function() {
    //     $('.business-dropdown').removeClass('active');
    // });
    // $(".vertical-dropdown .dropdown-list li.selectable").click(function() {
    //     $('.verText').text($(this).text().trim());
    //     $('.vertical-dropdown').removeClass('active');
    //     $('#funnels-section').removeClass();
    //     $('#funnels-section').addClass($(this).text().trim());
    // });
    // $(".vertical-dropdown .dropdown-list li").click(function() {
    //     $('.vertical-dropdown').removeClass('active');
    // });

    $('.leadpop-dropdown li').click(function () {
        $("#"+$(this).parents('.leadpop-dropdown').attr('data-name')).val($(this).attr('data-value'))
    });


    // $(document).on('click', '.funnels-menu.header-inner .drop-menu > a', function(e) {
    //     e.preventDefault();
    //     var drop_menu = $(this).closest('.drop-menu');
    //     if (drop_menu.hasClass('open')) {
    //         drop_menu.removeClass('open');
    //     } else {
    //         drop_menu.addClass('open');
    //     };
    // });
    $(document).mouseup(function(e) {
        var container = $(".funnels-menu.header-inner");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.find('.drop-menu').removeClass('open');
        }
    });

    /* ** ** ** ** INTEGRATIONS - Start ** ** ** ** */
    $("#zapierKeyBtn").click(function(e){
        e.preventDefault();
        $("#zapier_access_key").val('Please wait... Generating authorization key...');
        createZapierKey();
    });

    $("#lp_auth_access_btn").click(function(e){
        e.preventDefault();
        $("#lp_auth_access_key").val('Please wait... Generating authorization key...');
        createAuthKey();
    });

    $('#lp_auth_access_code_copy').click(function(e){
        e.preventDefault();
        copyContentToClipboard($('#lp_auth_access_key'));
        var html = '<div class="alert alert-success lp-success-msg">'+
            '<strong>Success:</strong> copied'+
            '</div>';
        $(html).css('margin-bottom','10px').hide().appendTo("#clip-msg").slideDown(500).delay(1000).slideUp(500 , function(){
            $(this).remove();
        });

    });

    $('#zapierKeyBtn_copy').click(function(e){
        e.preventDefault();
        copyContentToClipboard($('#zapier_access_key'));
        var html = '<div class="alert alert-success lp-success-msg">'+
            '<strong>Success:</strong> copied'+
            '</div>';
        $(html).css('margin-bottom','10px').hide().appendTo("#clip-msg").slideDown(500).delay(1000).slideUp(500 , function(){
            $(this).remove();
        });
    });

    // Muhammad

    $('.btn-toggle').on('click', function(){
        if ($(this).hasClass("active")) {
            $('#advance-footer-wrapper').css('display','none');
        }else {
            $('#advance-footer-wrapper').css('display','block');
        }
    });

    $('#totalExpertActiveDeactiveBtn').on("change", function() {
        var te_activated = $("#te_activated").val();
        var te_status = $("#te_status").val();
        var client_id = $("#client_id").val();
        var newStatus = "";
        if ($(this).is(":checked") && te_activated == "no") {
            //goOuath2 redirect
            console.log($("#teactivate").attr("href"));
            $("#teactivate").get(0).click();

            this.checked = !this.checked;
            console.log("checked");
        } else {
            $.ajax( {
                type : "POST",
                url: site.baseUrl+site.lpPath+'/popadmin/totalexpertdelete',
                data: "client_id=" + client_id + "&_token=" +ajax_token,
                success : function(d) {
                    $("#te_activated").val("no");
                }
            });
        }
    });


    /* ** ** ** ** INTEGRATIONS - End ** ** ** ** */

    $("#mask").delay(500).fadeOut(600);

    /* Global change zapier funnel selector */
    function resetZapierFunnelPopup(){
        $("#funnel-selector input[type=checkbox]").prop('checked', false);
        $("#funnel-selector input[type=checkbox]").next().removeClass('lp-white');

        $("#funnel-selector").find(".modal-title").html('Funnel Selector');
        $( ".funnel-selector-alert" ).remove();
        $("#finish").show();
        $("#zap_save_integrations").hide();
    }


    $('#funnel-selector').on('show.bs.modal', function () {
        $('#funnel-selector').attr("data-action", "on");
    });

    $('#funnel-selector').on('hidden.bs.modal', function () {
        if( $("#funnel-selector").hasClass("zapier-selector") ){
            $("#funnel-selector").removeClass("zapier-selector");
            resetZapierFunnelPopup();
        } else {
            if($('#funnel-selector').attr("data-action") == "on"){
                $('#funnel-selector').attr("data-action", "off");
                //$("#search").val('');
                //$("#funnel-selector input[type=checkbox]").prop('checked', false);
                //$("#funnel-selector input[type=checkbox]").next().removeClass('lp-white');
            }
        }
    });

    $(".zapier-funnel-selector").click(function(e){
        var funnels = $("#zapier_integrations").val();
        if(funnels){
            var integrations = funnels.split(",");
            $.each(integrations, function(i, key) {
                $("#funnel-selector input[data-zkey='" + key + "']").prop('checked', true);
                $("#funnel-selector input[data-zkey='" + key + "']").next().addClass('lp-white');
            });
        }

        $("#finish").hide();
        $("#zap_save_integrations").show();
        $("#funnel-selector").find(".modal-title").html('Zapier Funnel Selector')
        $("#funnel-selector").addClass('zapier-selector');
        $( '<span class="label funnel-selector-alert pull-left"></span>' ).insertBefore( $("#funnel-selector").find( ".lp-btn-cancel" ) );
    });

    $("#zap_save_integrations").click(function(e){
        e.preventDefault();
        var _values = [];

        $('#funnel-selector input[type=checkbox]:checked').each(function (index, el){
            if($(el).attr('data-zkey'))
                _values.push( $(el).attr('data-zkey') );
        });

        if(_values.length < 1){
            $("#selectedfunnel").val('');
            $('#funnle_selector-lp-alert').modal('show');
            return;
        }

        //remove the duplicated values from array
        _values = _values.filter( function( item, index, inputArray ) {
            return inputArray.indexOf(item) == index;
        });

        _values = _values.join(',');

        var existing_integrations = $("#zapier_integrations").val();

        $(".funnel-selector-alert").html('Please wait... Saving Funnels...');
        $.ajax( {
            type : "POST",
            url : "/lp/popadmin/savezapierfunnels",
            data : "funnels=" + _values + "&existing_funnels=" + existing_integrations+"&_token="+ajax_token,
            success : function(rsp) {
                resetZapierFunnelPopup();
                $("#funnel-selector").modal('toggle');
                $(".funnel-selector-alert").remove();
                $("#zapier_integrations").val(_values);
            },
            cache : false,
            async : false
        });

    });
    /* Global change zapier funnel selector - ends */

    $(".funnel-url-list .disable_lite_package").click(function (e){
        e.preventDefault();
        showLitePackageDisableAlert();
        return false;

    });
    $(".funnel-row .disable_lite_package").click(function (e){
        e.preventDefault();
        showLitePackageDisableAlert();
        return false;

    });
});



(function($){

    /**  Code for model box for support ticket **/
    var global_issuedatainfo = $('#global_issuedatainfo').val() === undefined ? "[]" : $('#global_issuedatainfo').val();
    global_support_issue_data = $.parseJSON(global_issuedatainfo);
    $('body').on('change','#global_maintopic',function(e){
        e.preventDefault();
        if(global_support_issue_data[$(this).val()] != undefined){
            var option_val='<option value="">Select Topic</option>';
            $.each(global_support_issue_data[$(this).val()].subissue, function(key, value) {
                option_val+='<option value="'+key+'">'+value+'</option>';
            });
            $('#global_mainissue').empty().append(option_val).find('option:first').attr("selected","selected");
            $('#global_mainissue').selectpicker('refresh');
        }
    });
    $('body').on('click','#global_ticket_model_open',function(e){
        e.preventDefault();
        $('#modal_cloneFunnelRequest').modal('hide');
        globalSupportTicket.openModel();
    });
    $('body').on('click','#global_btn-spt-form',function(e){
        e.preventDefault();
        globalSupportTicket.submitTicket();
    });


    var globalSupportTicket = {
        openModel: function (){
            $('#model_cloneFunnelSupportTicket').modal('show');

            $('#global_maintopic').val('1');
            $('#global_maintopic').trigger('change');
            $('#global_mainissue').val('10');
            $('#global_subject').val('Upgrade me to Unlimited Funnels!');
            $('#global_message').val('I would like to upgrade my account to the Conversion Funnels Unlimited!');
        },
        submitTicket: function(){
            var notification_container = ".global_ticket_notif";
            $(notification_container).css("text-align", "left");

            notification.info(notification_container, 'Please wait... processing you request...');
            $.ajax( {
                type : "POST",
                data : "maintopic=" + $("#global_maintopic").val() + "&issuedatainfo=" + $("#global_issuedatainfo").val() + "&targetele=&mainissue=" + $("#global_mainissue").val() + "&mailmsg=&mailsubject=&subject=" + $("#global_subject").val() + "&message=" + $("#global_message").val() + "&format=json",
                url : $("#global-lp-support-form").attr("action"),
                dataType: "json",
                error: function (e) {
                    notification.error(notification_container, 'Your request was not processed. Please try again.');
                },
                success : function(d) {
                    notification.success(notification_container, d.msg);

                    $('#global_maintopic').val('');
                    $('#global_maintopic').trigger('change');
                    $('#global_mainissue').val('');
                    $('#global_mainissue').trigger('change');
                    $('#global_subject').val('');
                    $('#global_message').val('');

                    setTimeout(function () {
                        $("#model_cloneFunnelSupportTicket").modal('toggle');
                    }, 1600);
                },
                cache : false,
                async : false
            });
        }
    };

    /**  Code for model box for support ticket -- ends **/

    var paginate = {
        startPos: function(pageNumber, perPage) {
            return pageNumber * perPage;
        },

        getPage: function(items, startPos, perPage) {
            var page = [];
            items = items.slice(startPos, items.length);
            for (var i=0; i < perPage; i++) {
                page.push(items[i]);
            }

            return page;
        },

        totalPages: function(items, perPage) {
            // determine total number of pages
            return Math.ceil(items.length / perPage);
        },

        createBtns: function(totalPages, currentPage) {
            // create buttons to manipulate current page
            var pagination = $('<ul class="pagingControls" />');


            // add pages inbetween
            for (var i=1; i <= totalPages; i++) {
                // truncate list when too large

                // markup for page button
                var pageBtn = $('<li></li>');

                // add active class for current page
                if (i == currentPage) {
                    pageBtn.addClass('active');
                    pageBtn.text(i);
                    // pageBtn.append('<a class="pagination-btn active" href="#">'+i+'</a>');
                }else{
                    pageBtn.append('<a class="pagination-btn" href="#">'+i+'</a>');
                }
                pagination.append(pageBtn);
            }

            return pagination;
        },

        createPage: function(container, items,litePackageItemsDisabled, currentPage, perPage) {
            // remove pagination from the page
            var paging_control = container.find('.pagingControls'),
                startPos = this.startPos(currentPage - 1, perPage),
                page = this.getPage(items, startPos, perPage);

            if(!jQuery.isArray(items)){
                items = items.detach().toArray()
            }

            //console.info(items);
            var page_flag = 0;
            if(items.length > perPage){
                page_flag = 1;
            }
            paging_control.remove();
            container.find('.funnels-list > ul').empty();
            $.each(page, function(){
                if (this.window === undefined) {
                    container.find('.funnels-list > ul').append($(this)); }
            });
            var totalPages = this.totalPages(items, perPage),
                pageButtons = this.createBtns(totalPages, currentPage);
            if($("#is_lite_package").val()!=''){
                if(litePackageItemsDisabled.length!==undefined){
                    container.find('.funnels-header .funnels-header-title span').text(items.length - litePackageItemsDisabled.length);
                }
            }else{
                container.find('.funnels-header .funnels-header-title span').text(items.length);
            }
            if (page_flag)
            {
                container.find('.funnels-body').append(pageButtons);
            }

        }
    };

    $.fn.funnel_loader = function(perPage) {
        var paginations = $(this);
        paginations.each(function (index, el) {
            var selector = $(this);
            var items = null;//$(this).find('.funnels-list > ul > li');
            var litePackageItemsDisabled = null;
            var _index = $(this).closest('.funnels-details').data('funnel-row');

            if(_list[_index]==undefined){
                _list[_index] = $(this).find('.funnels-list > ul > li');
            }
            items = list = _list[_index];

            // default perPage to 10
            if (isNaN(perPage) || perPage === undefined) {
                if($(".currentClientId").attr('data-clientId') == 3189)
                    perPage = 100;
                else
                    perPage = 10;
            }

            var _ftslug = $(".vertical-dropdowntype .dropdown-list li.active").data('ftslug');

            items = [];

            if(_ftslug!='all'){

                $(list).each(function (index, el) {
                    if($(el).hasClass(_ftslug)) {
                        items.push(el);
                    }
                });
            }else{
                $(list).each(function (index, el) {
                    items.push(el);
                });
            }

            var _slug = $(this).closest('.funnels-details').find('ul.qa-list li.active').data('slug');

            fitems = [];
            if(_slug!='all'){
                $(items).each(function (index, el) {
                    if($(el).hasClass(_slug)) {
                        fitems.push(el);
                    }
                });
            }
            if(fitems.length > 0){
                items=fitems;
            }
            litePackageItemsDisabled=[];
            if($("#is_lite_package").val()==1){
                $(items).each(function (index, el) {
                    if($(el).hasClass("count_disable_is_lite")) {
                        litePackageItemsDisabled.push(el);
                    }
                });
            }

            paginate.createPage($(this), items,litePackageItemsDisabled, 1, perPage);

            // console.info(items.length);
            // handle click events on the buttons
            $(this).off('click').on('click', '.pagination-btn', function(e) {
                e.preventDefault();
                // get current page from active button
                var currentPage = parseInt($('.pagingControls').find('li.active').find('.pagination-button').text(), 10),
                    newPage = currentPage,
                    totalPages = paginate.totalPages(items, perPage),
                    target = $(e.target);

                // get numbered page
                newPage = parseInt(target.text(), 10);

                // ensure newPage is in available range
                if (newPage > 0 && newPage <= totalPages) {
                    paginate.createPage($(this).closest('.funnels-details'), items,litePackageItemsDisabled, newPage, perPage); }
            });


            $(this).on('click','li[data-slug]', function(e) {
                e.preventDefault();
                $(this).closest('.qa-list').find('li').removeClass('active');
                $(this).addClass('active');
                var _dropdown = $(this).closest('.qa-dropdown');
                _dropdown.find('.qaText').text($(this).text().trim());
                var _slug = $(this).data('slug');
                var __index = $(this).closest('.funnels-details').data('funnel-row');
                console.info(__index);
                items = [];

                var _ftslug = $(".vertical-dropdowntype .dropdown-list li.active").data('ftslug');

                if(_ftslug!='all'){
                    $(_list[__index]).each(function (index, el) {
                        if($(el).hasClass(_ftslug)) {
                            items.push(el);
                        }
                    });
                }else{
                    $(_list[__index]).each(function (index, el) {
                        items.push(el);
                    });
                }

                fitems = [];
                if(_slug!='all'){
                    $(items).each(function (index, el) {
                        if($(el).hasClass(_slug)) {
                            fitems.push(el);
                        }
                    });
                }

                if(fitems.length > 0){
                    items=fitems;
                }
                litePackageItemsDisabled=[];
                if($("#is_lite_package").val()==1){
                    $(items).each(function (index, el) {
                        if($(el).hasClass("count_disable_is_lite")) {
                            litePackageItemsDisabled.push(el);
                        }
                    });
                }
                paginate.createPage($(this).closest('.funnels-details'), items,litePackageItemsDisabled, 1, perPage);
            });

            $(this).on('click','.f-expand', function(e) {
                e.preventDefault();
                if($(this).hasClass("disable_lite_package")){
                    showLitePackageDisableAlert();
                    return false;
                }
                var _funnel = $(this);
                if (_funnel.hasClass('opened')) {
                    _funnel.next().slideUp(200, function () {
                        _funnel.removeClass('opened');
                        });
                } else {
                    _funnel.next().slideDown(200, function () {
                        _funnel.addClass('opened');
                    });
                };
            });

            //Binding Event to Clone Funnel
            $(this).on('click','.cloneFunnelBtn', function(e) {
                e.preventDefault();

                Funnel.cloneFunnelCta($(this))
            });

            //Binding Event to Clone Funnel With Custom Sub Domain
            $(this).on("click",".cloneFunnelSubdomainBtn",function (e) {
                if($(this).hasClass("disable_lite_package")) {
                    showLitePackageDisableAlert();
                    return false;
                }
                e.preventDefault();
                Funnel.cloneFunnelSubdomainCta($(this))
            });

            //Binding event to CloneEnableRequest Button
            $(this).on('click','.cloneFunnelReqBtn', function(e) {
                e.preventDefault();
                Funnel.cloneFunnelRequest($(this))
            });

            //Binding Event to Delete Funnel
            $(this).on('click','.deleteFunnelBtn', function(e) {
                e.preventDefault();

                Funnel.deleteFunnelBtn($(this))
            })

            //Binding Event to Status Link
            $(this).on('click','.funnelStatusBtn', function(e) {

                e.preventDefault();
                Funnel.funnelStatusBtn($(this))

            });
            //Status CTA Function Ends

            //Binding Event to Stats Link
            $(this).on('click','.statsPopupCta', function(e) {
                e.preventDefault();
                Stats.init( $(this) );
            });
            //Stats Link Ends

            $(this).on('click','.sticky-bar-btn', function(e) {
                e.stopPropagation();
                if($(this).parents(".f-expand").hasClass("disable_lite_package")) {
                    showLitePackageDisableAlert();
                    return false;
                }
                var _this = $(this);
                showstickybarpopup(_this);
            });

            // $(this).on('click', '.drop-menu', function(e) {
            //     e.preventDefault();
            //     var drop_menu = $(this).closest('.drop-menu');
            //     if (drop_menu.hasClass('open')) {
            //         drop_menu.removeClass('open');
            //     } else {
            //         drop_menu.addClass('open');
            //     };
            // });




            $(document).mouseup(function(e) {
                var container = selector.find(".drop-menu");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.removeClass('open');
                }
            });

        });
    };

    // Clone + Delete + Status Funnels - Starts
    var Funnel = {
        cloneFunnelRequest: function(elem) {
            $('#modal_cloneFunnelRequest').modal('show');
        },
        cloneFunnelSubdomainCta: function (elem){
            $("#ClonefunnelSubdomain").attr("action", elem.attr('data-ctalink'));
            $("#subdomain").val(elem.attr('data-subdomain'));
            //$("#topleveldomain option[value='"+elem.attr("data-top-domain")+"']").attr('selected', 'selected');
            $('#topleveldomain').val(elem.attr("data-top-domain")).trigger('change');
            $("#select2-topleveldomain-container").text(elem.attr("data-top-domain"));
            $("#modal_SubdomainCloneFunnel #current_hash").val(elem.attr('data-hash'));
            $( '#modal_SubdomainCloneFunnel' ).modal('show');
            $('#modal_SubdomainCloneFunnel').on('shown.bs.modal', function () {
                $('#funnel_name').focus();
                $('#funnel_name').val('');
            });
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
            $(".btnAction_confirmCloneDelete").html("Delete");
            $("#action_confirmCloneDelete").val("delete");
            $("#form_confirmCloneDelete").attr("action", elem.attr('data-ctalink'));
            $("#form_confirmCloneDelete #current_hash").val(elem.attr('data-hash'));
            var funnel_name = elem.parents('.funnel-row').find('.funnel-url').text();
            if(funnel_name == ""){
                funnel_name = $('.lp-url-color').text();
            }

            $(".notification_confirmCloneDelete").html("Delete " + funnel_name + "?<br /><span class='altr'>All assets and data will be deleted.</span>");
            $('#modal_confirmCloneDelete').find('.modal-title').html('Delete Funnel');
            $('#modal_confirmCloneDelete').modal('show');
        },
        funnelStatusBtn: function(elem){

            if(elem.attr("data-status") == 1) {
                    $('#modal_status #toggle-status').bootstrapToggle('on');
                }
            else {
                    $('#modal_status #toggle-status').bootstrapToggle('off');
                }
            var ele=$("#modal_status #status-lp-video");
            ele.attr("data-lp-wistia-title","Status");
            ele.attr("data-lp-wistia-key","zudbzlbz4g");

            $(".btnAction_saveStatus").attr("data-domain_id", elem.attr("data-domain_id"));
            $(".btnAction_saveStatus").attr("data-leadpop_id", elem.attr("data-leadpop_id"));
            $(".btnAction_saveStatus").attr("data-leadpop_version_id", elem.attr("data-leadpop_version_id"));
            $(".btnAction_saveStatus").attr("data-leadpop_version_seq", elem.attr("data-leadpop_version_seq"));

            $(".funnel-message").html("Select Funnel Status");
            $('#modal_status').modal('show');
        },
        clone: function() {
        },
        delete: function() {
            $("#form_confirmCloneDelete").submit()
        }
    }

    if($('.funnels-details').length == 0) {
        $(".cloneFunnelBtn").click(function (e) {
            e.preventDefault();
            Funnel.cloneFunnelCta($(this))
        })

        $(".cloneFunnelSubdomainBtn").click(function (e) {
            e.preventDefault();
            if($(this).hasClass("disable_lite_package")) {
                showLitePackageDisableAlert();
                return false;
            }
            Funnel.cloneFunnelSubdomainCta($(this))
        })

        $(".cloneFunnelReqBtn").click(function (e) {
            e.preventDefault();
            Funnel.cloneFunnelRequest($(this))
        })

        $(".deleteFunnelBtn").click(function (e) {
            e.preventDefault();
            Funnel.deleteFunnelBtn($(this))
        })

        $(".funnelStatusBtn").click(function (e) {
            console.info("test");
            e.preventDefault();
            Funnel.funnelStatusBtn($(this))
        })
    }

    $(".btnAction_confirmCloneDelete").on( "click", function (e){
        if( $("#action_confirmCloneDelete").val() == "delete"){
            Funnel.delete();
        }
    });
    $( ".btnAction_SubDomainCloneFunnel").on('click',function( event ) {
        $("#mask").show();
        setTimeout(function  (){
        FunnleNameValidation();
        },400);
    });

    // $("#funnel_name").on( "keyup", function (e){
    //     if(e.keyCode == 13){
    //         $(".btnAction_SubDomainCloneFunnel").trigger('click');
    //     }
    // });
    // $("#subdomain").on( "keyup", function (e){
    //     if(e.keyCode == 13){
    //         $(".btnAction_SubDomainCloneFunnel").trigger('click');
    //     }
    // });
    // $("#topleveldomain").on( "keyup", function (e){
    //     if(e.keyCode == 13){
    //         $(".btnAction_SubDomainCloneFunnel").trigger('click');
    //     }
    // });

    $(".btnCancel_confirmCloneDelete").on( "click", function (e){
        $("#form_confirmCloneDelete").attr("action", "");
        $("#action_confirmCloneDelete").val("");
        $(".notification_confirmCloneDelete").html("");
    });

    $(".btnAction_saveStatus").on( "click", function (e){
        var ctaElem = $(this);
        var notification_container = ".funnel-message";
        var status = $('#modal_status #toggle-status').prop('checked');
        var domain_id = ctaElem.attr('data-domain_id');
        var leadpop_id = ctaElem.attr('data-leadpop_id');
        var leadpop_version_id = ctaElem.attr('data-leadpop_version_id');
        var leadpop_version_seq = ctaElem.attr('data-leadpop_version_seq');

        notification.loading(notification_container);
        $.ajax( {
            type : "POST",
            data : "domain_id=" + domain_id + "&leadpop_id=" + leadpop_id + "&leadpop_version_id=" + leadpop_version_id + "&leadpop_version_seq=" + leadpop_version_seq + "&status=" + status+"&_token="+ajax_token,
            url : "/lp/index/modifydomainstatus",
            dataType: "json",
            error: function (e) {
                notification.error(notification_container, 'Your request was not processed. Please try again.');
            },
            success : function(d) {
                ctaElem.attr('data-domain_id', '');
                ctaElem.attr('data-leadpop_id', '');
                ctaElem.attr('data-leadpop_version_id', '');
                ctaElem.attr('data-leadpop_version_seq', '');
                //console.log(d.q);
                if (d.status == "active") {
                    $(".funnelstatus_" + domain_id).attr('data-status', 1);
                    notification.success(notification_container, "Funnel status has been changed to active.");
                }
                else if (d.status == "inactive") {
                    $(".funnelstatus_" + domain_id).attr('data-status', 0);
                    notification.success(notification_container, "Funnel status has been changed to inactive.");
                }

                setTimeout(function () {
                    $("#modal_status").modal('toggle');
                }, 800);
            },
            cache : false,
            async : false
        });
    });
    /*disable global setting for lite package*/
    $(".global-settings.disable_lite_package").on( "click", function (e){
        e.preventDefault();
            showLitePackageDisableAlert();
            return false;

    });
    // Clone + Delete + Status Funnels - Ends
    //Domain name validation on key
    $(document).on("keyup","#subdomain",function(){
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

})(jQuery);
$('.funnels-details').funnel_loader();
function createZapierKey(){
    $.ajax( {
        type : "POST",
        data: "current_hash="+$("#current_hash").val()+"&client_id="+$("#client_id").val()+"&type=zapier"+"&_token="+ajax_token,
        dataType:"json",
        url : "/lp/popadmin/createauthkey",
        success : function(d) {
            if (d.status == "success") {
                $("#zapier_access_key").prop('disabled', false);
                $("#zapier_access_key").css('cursor','text');
                $("#zapier_access_key").val(d.key).removeClass('error');

                $("#zapierKeyBtn").text("Re-Generate Key");
                $(".zapier_toggle .toggle-group .btn").css('cursor','no-drop');
            }else{
                $("#zapier_access_key").val(d.error).addClass('error');
            }
        },
        error : function () {
            $("#zapier_access_key").val('Application Error').addClass('error');
        },
        cache : false,
        async : false
    });
}

function createAuthKey(){
    $.ajax( {
        type : "POST",
        data: "current_hash="+$("#current_hash").val()+"&client_id="+$("#client_id").val()+"&type=leadpops_auth"+"&_token="+ajax_token,
        dataType:"json",
        url : "/lp/popadmin/createauthkey",
        success : function(d) {
            if (d.status == "success") {
                $("#lp_auth_access_key").prop('disabled', false);
                $("#lp_auth_access_key").css('cursor','text');
                $("#lp_auth_access_key").val(d.key).removeClass('error');

                $("#lp_auth_access_btn").text("Re-Generate Key");
                $(".lp_auth_toggle .toggle-group .btn").css('cursor','no-drop');
            }else{
                $("#lp_auth_access_key").val(d.error).addClass('error');
            }
        },
        error : function () {
            $("#lp_auth_access_key").val('Application Error').addClass('error');
        },
        cache : false,
        async : false
    });
}

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
    var notification_container = ".model_notification";
    var subdomain = $("#subdomain").val();
    var funnel_name = $("#funnel_name").val();
    var topdomain = $("#topleveldomain").val();
    if(funnel_name == "") {
        notification.error(notification_container, "Funnel name is required.");
        $("#mask").hide();
        return false;
    }else if(/^[a-zA-Z0-9-\s]+$/.test(funnel_name) == false) {
        notification.error(notification_container, "Special characters are not allowed in domain names.");
        $("#mask").hide();
        return false;
    }else  if(subdomain == "") {
        notification.error(notification_container, "Sub-domain name is required.");
        $("#mask").hide();
        return false;
    }else if(/^[a-zA-Z0-9-]+$/.test(subdomain) == false) {
        notification.error(notification_container, "Special characters and spaces are not allowed in domain names.");
        $("#mask").hide();
        return false;
    }else {
        var rec = jQuery.parseJSON(funnel_json);
        $(rec).each(function (index, el) {
            if(el.funnel_name != "" && el.funnel_name != null) {
                if (funnel_name.toLowerCase() == el.funnel_name.toLowerCase()) {
                    notification.error(notification_container, 'Funnel name ' + funnel_name + ' is already in use. Please try something else.');
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
                    if (d == "ok") {
                        $( "#ClonefunnelSubdomain" ).submit();
                    } else if (d == "taken") {
                        $("#mask").hide();
                        notification.error(notification_container, 'Sub-domain ' + subdomain + '.' + topdomain + ' is not available.');
                    }
                },
                cache : false,
                async : false
            });
        }
    }
}

function showLitePackageDisableAlert(){
    $('#emailfiremodel .modal-title').html("Activate Funnel");
    $('#emailfiremodel .funnel-message').addClass("disable_alert");
    $('#emailfiremodel .funnel-message').html("We'd love to talk to you about upgrading your account!<br> <a class='btn btn-success' href='https://leadpops.com/consult/' target='_blank'>Click here to schedule a call with us.</a>");
    $('#emailfiremodel').modal('show');
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
            isFileTypeError = (filetype !== "image/png" && filetype !== "image/jpeg" && !filetype !== "image/jpg");

        if(fileElement.value == "" || isFileTypeError) {
            if (debug) {
                console.log("Restore( #" + fileElement.id + " ) : " + clone[fileElement.id].val().split("\\").pop())
            }
            clone[fileElement.id].insertBefore(fileElement); //'Restoring Clone'
            $(fileElement).remove(); //'Removing Original'
            if (evenMoreListeners) { addEventListenersTo(clone[fileElement.id]) }//If Needed Re-attach additional Event Listeners

            if(filetype !== false && isFileTypeError) {
                alert('Please use an image in one of these formats: PNG, JPG, or JPEG.');
            }
        }
    }
    //What ever else you want to do when File Chooser Changed
}
