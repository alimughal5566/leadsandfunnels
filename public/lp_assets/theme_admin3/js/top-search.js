// set the dashboard funnel inner content nav items
window.navItems = {
    'edit' : {
        'content':[
            {label :'Autoresponder',href: site.baseUrl + site.lpPath + '/popadmin/autoresponder/', comingSoon:false, title: 'Autoresponder'},
            {label :'Call-to-Action',href: site.baseUrl + site.lpPath + '/popadmin/calltoaction/', comingSoon:false, title: 'Call-to-Action'},
            {label :'Contact Info',href: site.baseUrl + site.lpPath + '/popadmin/contact/', comingSoon:false, title: 'Contact Info'},
            {label :'Footer',href: site.baseUrl + site.lpPath + '/popadmin/footeroption/', comingSoon:false, title: 'Footer'},
            {label :'Questions',href: site.baseUrl + site.lpPath + '/popadmin/funnel/questions/', comingSoon:false, title: 'Questions'},
            {label :'Security Messages',href: site.baseUrl + site.lpPath + '/popadmin/security-messages/', comingSoon:false, title: 'Security Messages'},
            {label :'TCPA Messages',href: site.baseUrl + site.lpPath + '/popadmin/tcpa/', comingSoon:false, title: 'TCPA Messages'},
            {label :'Thank You Page',href: site.baseUrl + site.lpPath + '/popadmin/thank-you-pages/', comingSoon:false, title: 'Thank You Page'},
            {label :'Questions',href: '', comingSoon:true, title: 'You cannot edit this funnel since there <br> is and existing integration.'},
        ],
        'design':[
            {label :'Background',href: site.baseUrl + site.lpPath + '/popadmin/background/', comingSoon:false, title: 'Background'},
            {label :'Featured Image',href: site.baseUrl + site.lpPath + '/popadmin/featuredmedia/', comingSoon:false, title: 'Featured Image'},
            {label :'Logo',href: site.baseUrl + site.lpPath + '/popadmin/logo/', comingSoon:false, title: 'Logo'},
            {label :'Buttons',href:'', comingSoon:true, title: 'COMING SOON!'},
            {label :'Header',href:'', comingSoon:true, title: 'COMING SOON!'},
            {label :'Progress Bar',href:'', comingSoon:true, title: 'COMING SOON!'},
            {label :'Text',href:'', comingSoon:true, title: 'COMING SOON!'},
            {label :'Themes',href:'', comingSoon:true, title: 'COMING SOON!'},
        ],
        'settings':[
            {label :'ADA Accessibility',href: site.baseUrl + site.lpPath + '/popadmin/adaaccessibility/', comingSoon:false, title: 'ADA Accessibility'},
            {label :'Integrations',href: site.baseUrl + site.lpPath + '/popadmin/integration/', comingSoon:false, title: 'Integrations'},
            {label :'Lead Alerts',href: site.baseUrl + site.lpPath + '/account/contacts/', comingSoon:false, title: 'Lead Alerts'},
            {label :'Pixels',href: site.baseUrl + site.lpPath + '/popadmin/pixels/', comingSoon:false, title: 'Pixels'},
            {label :'Status',href:'', comingSoon:false, title: 'Status'},
            {label :'A/B Testing',href:'', comingSoon:true, title: 'COMING SOON!'},
            {label :'Partial Leads',href:'', comingSoon:true, title: 'COMING SOON!'},
            {label :'Webhooks',href:'', comingSoon:true, title: 'COMING SOON!'},
        ],
        'basic-info':[
            {label :'Domains',href: site.baseUrl + site.lpPath + '/popadmin/domain/', comingSoon:false, title: 'Domains'},
            {label :'Name / Folder / Tags',href:site.baseUrl + site.lpPath + '/tag/', comingSoon:false, title: 'Name / Folder / Tags'},
            {label :'SEO',href: site.baseUrl + site.lpPath + '/popadmin/seo/', comingSoon:false, title: 'SEO'},
            {label :'leadPops Branding',href: site.baseUrl + site.lpPath + '/branding/', comingSoon:false, title: 'leadPops Branding'},
            {label :'Favicon',href:'', comingSoon:true, title: 'COMING SOON!'}
        ]
    },
    'promote' : {
        'promote':[

            {label :'Share My Funnel',href:site.baseUrl + site.lpPath + '/promote/share/', comingSoon:false, title: 'Share My Funnel' },
            {label :'Sticky Bar Builder',href:'', comingSoon:false , title: 'Sticky Bar Builder'},
            {label :'Embed in a Web Page',href:'', comingSoon:true , title: 'COMING SOON!'},
            {label :'Open in Lightbox',href:'', comingSoon:true , title: 'COMING SOON!'},
            {label :'Open in Popup',href:'', comingSoon:true , title: 'COMING SOON!'},
            {label :'Place it in IFrame',href:'', comingSoon:true, title: 'COMING SOON!'},
            {label :'Platforms',href:'', comingSoon:true , title: 'COMING SOON!'},
        ]
    }
};

window.navItems.edit.content.splice(3, 0, {label :'Extra Content',href: site.baseUrl + site.lpPath + '/content/extra-content/', comingSoon:false, title: 'Extra Content', tag: '<span class="badge badge-tag sub-menu-tag" id="extra_content_new">New</span>'});

//set array skip route
window.routeList = ['dashboard','support','my_profile','hub'];

//some tags re-arrange according to category
window.category = [
    'Conventional Loans',
    'FHA Loans',
    'VA Loans',
    '203K Loans',
    'Jumbo Loans',
    'USDA Loans',
    'Reverse Mortgage',
    'HARP Loans',
    'Home Search',
    'Home Finder',
    'Home Values',
    'Open House',
    'Short Sale',
    'Auto Insurance',
    'Business Insurance',
    'Health Insurance',
    'Home Insurance',
    'Life Insurance',
    'Renters Insurance',
    'Bankruptcy',
    'DUI',
    'Debt Relief',
    'Annuity',
    'Credit Repair',
    'Mortgage Enterprise',
    'Bank Account',
    'Financial Advisor',
    'Roofing',
    'Solar' ];
window.isClone = 0;
var thirtyDayChartDays = 31;
var SevenDayChartDays = 7;
(function($){
    var rec = jQuery.parseJSON(funnel_json);
    window.rec = rec;
    window.data = rec;
    window.top_search_data = rec;
    var html = '';
    window.funnel_type = window.funnel_type_name = '';
    window.currentPage = (funnel_page)?funnel_page:1;
    window.is_lite_package =0;
    window.lite_funnels =[];
    if($("#is_lite_package").val() == '1'){
        window.is_lite_package =1;
        window.lite_funnels = $("#is_lite_funnels").val().split(',').map(function(itemFunnel) {
            return parseInt(itemFunnel, 10);
        });
    }
    window.currentPerPage = (funnel_perPage)?funnel_perPage:25;

    var container = $(".dashboard-funnels");

    var funnel_name = '';
    var disable_class = '';
    window.outsidewidth = 0;
    window.page_type = '';
    window.paginate;
    window.top_last_select_funnel_type_text =  window.top_last_select_funnel_type_value = window.last_select_funnel_type_text =  window.last_select_funnel_type_value = '';
    window.top_serach_tigger = 0;
    window.selected_tag_list = new Array();
    /**
     * this function use for load the top header funnel on the dashboard
     */
    topHeaderSrotingFunnel();
    $.fn.topHeaderFunnelLoader = function () {
        var html = '';
        if(top_search_data == null || top_search_data.length == 0){
            if($(".top-funnel-type-search").val() == 'w' && $(".top-funnel-type-search option:selected").data('count') == 0){
                $("#modal_mortgageWebsiteFunnel").modal('show');
            }else{
                if($(".top-funnel-type-search option:selected").data('count') == 0){
                    $('.top-messge').html("This folder is empty, you haven't added any funnels yet.");
                }else{
                    $('.top-messge').html('No matching Funnels found.');
                }
                $('.megamenu-funnels-msg').show();
                $('.megamenu .megamenu-funnels,.megamenu .total-funnels').hide();
            }
        }else {
            $(".top-header-funnel").empty();
            var i = 0;
            $(top_search_data).each(function (index, el) {
                i++;
                var disable_is_lite_class = url = funnel_url =  is_active ='';
                funnel_url =  'http://'+funnel_url +el['domain_name'];
                if(!routeList.includes(site.route)){
                    var str = window.location.href;
                    var lastIndex = str.lastIndexOf('/');
                    url = str.substr(0, lastIndex) + "/" + el['hash'];
                }else{
                    url = 'javascript:void(0)';
                }
                var url_target = "_self";


                if(window.is_lite_package == '1'){
                    if(window.lite_funnels.indexOf(el['leadpop_vertical_sub_id']) != -1 && el['leadpop_version_seq'] == 1){
                        disable_is_lite_class = '';
                    }else{
                        disable_is_lite_class = 'disable_lite_package';
                        funnel_url = '#';
                    }
                }
                if(funnel_hash== el['hash']){
                    is_active = 'funnel-active';
                }
                if (el['sticky_id'] != '') {
                    if(el['funnel_name'] != "" && el['funnel_name'] != null){
                        if(el['funnel_name'].length > 30) {
                            funnel_name = parseHTML(el['funnel_name']).substr(0, 30) + '...';
                        }else{
                            funnel_name = parseHTML(el['funnel_name']);
                        }
                    }else{
                        funnel_name = '';
                    }
                    var skip_route = '';
                    if(routeList.includes(site.route)){
                        skip_route = ' in-active';
                    }

                    var tags = getFunnelTag(el);
                    html += '<div class="megamenu-funnels__box '+disable_is_lite_class+'">' +
                        '<div class="row">' +
                        '                            <div class="megamenu-funnels__column">' +
                        '                                <div class="megamenu-hover-wrap'+skip_route+'">' +
                        '                               <a href="'+url+'" class="funnel-link funnel-link-name"'+ ' target="'+url_target+'">' +
                        '                               <span class="el-tooltip" title="'+parseHTML(el['funnel_name'])+'">'+funnel_name+'</span>'+
                        '                               </a>'+
                        '                               <a href="'+url+'" target="'+url_target+'" class="hover-text el-tooltip" title="'+parseHTML(el['funnel_name'])+'"><i class="check-ico"></i>select this funnel</a>'+
                        '                                 </div>' +
                        '                        </div>' +
                        '                        <div class="megamenu-funnels__column">' +
                        '                                <div class="megamenu-hover-wrap">' +
                        '                            <a href="'+funnel_url+'" class="funnel-link funnel-link-url '+is_active+' "' + '  target="_blank">' +
                        '                               <span class="el-tooltip" title="'+el['domain_name']+'">'+el['domain_name']+'</span>'+
                        '                            </a>' +
                        '                             <a href="'+funnel_url+'" target="_blank" class="hover-text el-tooltip" title="'+el['domain_name']+'"><i class="tab-ico"></i>open funnel in new tab</a>'+
                        '                            </div>' +
                        '                            </div>' +
                        '                            <div class="megamenu-funnels__column">' +
                        '                            <div class="tags-holder">' +
                        '                            <div class="tags-wrap">' +
                        '                            <div class="tag-select-wrap">' +
                        '                            <ul class="tags-list">'+tags;
                    html+='                         </ul>' +
                        '                           </div>' +
                        '                           <span class="more"><span class="more-tag">...</span></span>' +
                        '                           <div class="tags-popup-wrap">' +
                        '                           <div class="tags-popup"> <ul class="tags-list">'+tags+'</ul>' +
                        '                           </div>' +
                        '                           </div>' +
                        '                           </div>' +
                        '                           </div>' +
                        '                        </div>' +
                        '                        </div>' +
                        '</div>';
                }
            });
            $(".top-header-funnel").html(html);
            $('.megamenu .megamenu-funnels,.megamenu .total-funnels').show();
            $('.total-funnels b').text($(top_search_data).length);
            $('.megamenu-funnels-msg').hide();
            topHeaderTagPopup();
        }
    };

    /**
     * this function use for load the funnel on the dashboard
     */
    $.fn.funnelLoader = function () {
        window.items = [];
        window.litePackageItemsDisabled = [];
        if(data.length <= currentPerPage ){
            currentPage = 1;
        }
        if(data == null || data.length == 0){
            if($(".funnel-type-search").val() == 'w' && $(".funnel-type-search option:selected").data('count') == 0){
                $("#modal_mortgageWebsiteFunnel").modal('show');
            }else{

                if($(".funnel-type-search option:selected").data('count') == 0){
                    $('.funnel-empty-message').html("<span class='ico-folder'></span><p>This folder is empty, you haven't added any funnels yet.</p><a class='create-funnel' href='#'>Create A Funnel</a>").show();
                }else{
                    $('.funnel-empty-message').html('<span class="ico-search"></span><p>No results were found for this search. Try something else.</p>').show();
                }
                $('.funnels-block,.heading-bar__funnels-info.total_funnels,.heading-bar__funnels-info.total-leads,.heading-bar__sorting').addClass('d-none');
            }
        }
        else {
            var i = 0;
            $(data).each(function (index, el) {
                i++;
                var disable_is_lite_class  = cl = '';
                if(window.is_lite_package == '1'){
                    if(window.lite_funnels.indexOf(el['leadpop_vertical_sub_id']) != -1 && el['leadpop_version_seq'] == 1){
                        window.litePackageItemsDisabled.push(el['client_leadpop_id']);
                    }else{
                        disable_is_lite_class = 'disable_lite_package';
                    }
                }
                if (el['leadpop_vertical_id'] == client_type) {
                    ft_slug = el["funnel_type"];
                } else {
                    if (el["funnel_type"] == 'w')
                        ft_slug = "f modified_from_w";
                    else
                        ft_slug = el["funnel_type"];
                }

                if (el['sticky_id'] != '') {
                    html = '<div class="funnels-details '+ disable_is_lite_class +'" data-index="'+index+'" id="row-'+el['client_leadpop_id']+'-'+el['domain_id']+'-'+index+'" data-domain="'+el['domain_name']+'"  data-version-id="'+el['leadpop_version_id']+'" data-version-seq="'+el['leadpop_version_seq']+'">' +
                        '                          <div class="funnel-head">' +
                        '                            <div class="funnels-box">' +
                        '                                <div class="row">' + getFunnelInfo(el,0) +
                        '                                </div>' +
                        '                            </div>'+
                        '                          </div>';
                    if(disable_is_lite_class == '') {
                        html +='<div class="funnels-details-area"><div class="funnels-details-wrap"><div class="funnels-details__content">' + getFunnelNavItem(el, index) + rightPanel(el) +'</div></div></div>';
                    }
                    html +='</div>';
                    window.items.push(html);
                }

            });
            paginate.totalPages = Math.ceil(window.items.length / currentPerPage);
            paginate.show();
        }

        $(document).on('click', '.funnel_manu_edit_link', function (e) {
            e.preventDefault();
        });

        //Binding Event to Clone Funnel
        $(document).on('click','.cloneFunnelBtn', function(e) {
            e.preventDefault();

            Funnel.cloneFunnelCta($(this))
        });

        //Binding Event to Clone Funnel With Custom Sub Domain
        if (site.route == 'dashboard') {
            $(document).on("click", ".cloneFunnelSubdomainBtn", function (e) {
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
            });
        }

        //Binding Event to Delete Funnel
        $(document).on('click','.deleteFunnelBtn', function(e) {
            e.preventDefault();
            Funnel.deleteFunnelBtn($(this))
        });

        //Binding Event to Status Link
        $(document).on('click','.funnelStatusBtn', function(e) {

            e.preventDefault();
            FunnelStatusHandler.funnelStatusBtn($(this))

        });
        //Status CTA Function Ends
    };

    /**
     * this function use for dashboard pagination
     * @type {{next: string, animationPagination: paginate.animationPagination,
     * buildListItems: (function(*): []), last: string, prev: string, show: paginate.show,
     * pageClass: string, getItem: (function(): []), applystyle: paginate.applystyle,
     * prevClass: string, lastClass: string, PerPageList: (function(): *|jQuery|HTMLElement),
     * visiblePages: number, firstClass: string, activeClass: string,
     * disabledClass: string, totalPages: number, buildItem: (function(*=, *=, *=): *|jQuery|HTMLElement),
     * nextClass: string, next_btn: (function(*): []), getVisiblePages: (function(): {numeric: [],
     * currentPage: (*|number)}), render: paginate.render, first: string, prev_btn: (function(*): [])}}
     */
    paginate = {
        first: 'First',
        prev: '<',
        next: '>',
        last: 'Last',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'pagination-btn',
        activeClass: 'active',
        disabledClass: 'disabled',
        visiblePages: 5,
        totalPages:   0,

        prev_btn: function (pages){
            var listItems = [];
            // if (this.first) {
            //     listItems.push(this.buildItem('first', 1));
            // }

            if (this.prev) {
                var prev = pages.currentPage > 1 ? pages.currentPage - 1 : 1;
                listItems.push(this.buildItem('prev', prev,'<div class="prev page-btn '+this.disabledClass+'"></div>'));
            }

            return listItems;
        },
        next_btn: function (pages){

            var listItems = [];

            if (this.next) {
                var next = pages.currentPage < this.totalPages ? pages.currentPage + 1 : this.totalPages;
                listItems.push(this.buildItem('next', next,'<div class="next page-btn '+this.disabledClass+'"></div>'));
            }

            // if (this.last) {
            //     listItems.push(this.buildItem('last', this.totalPages));
            // }

            return listItems;

        },
        buildListItems: function (pages) {
            var listItems = [];
            for (var i = 0; i < pages.numeric.length; i++) {
                listItems.push(this.buildItem('page', pages.numeric[i],'<li></li>'));
            }

            return listItems;
        },
        buildItem: function (type, page,ele) {
            var $itemContainer = $(ele),
                $itemContent = $('<a></a>'),
                $itemText = (this[type]) ? this[type] : page;
            $itemContent.addClass(this[type + 'Class']);
            $itemContainer.attr('id',page);
            $itemContainer.data('page', page);
            $itemContainer.data('page-type', type);
            $itemContainer.append($itemContent.attr('href', '#').html($itemText));
            return $itemContainer;
        },
        getVisiblePages: function () {
            var pages = [];
            var half = Math.floor(this.visiblePages / 2);
            var start = currentPage - half + 1 - this.visiblePages % 2;
            var end = currentPage + half;
            // handle boundary case
            if (start <= 0) {
                start = 1;
                end =  (this.totalPages < this.visiblePages)?this.totalPages:this.visiblePages;
            }else if (end > this.totalPages) {
                start = this.totalPages - this.visiblePages + 1;
                start = (start <= 0)?1:start;
                end = this.totalPages;
            }

            var itPage = 1;
            while (itPage <= this.totalPages) {
                pages.push(itPage);
                itPage++;
            }

            return {"currentPage": currentPage, "numeric": pages};

        },
        getItem: function() {
            var page = [];
            var startPos = (currentPage-1)*currentPerPage;
            var li = window.items.slice(startPos, window.items.length);
            for (var i=0; i < currentPerPage; i++) {
                page.push(li[i]);
            }
            return page;
        },
        render: function() {
            var _this = this;
            // create buttons to manipulate current page
            var main = $('<div class="col-6" />');
            var label = $('<span>Page</span>');
            var sub_section = $('<div class="pagination-block__box justify-content-end" />');
            var slide = $('<div class="slide" />');
            var pagination = $('<ul class="za-page" />');
            var page_list = this.getVisiblePages();
            var prev = this.prev_btn(page_list);
            var next = this.next_btn(page_list);
            pagination.append(this.buildListItems(page_list));
            pagination.children().each(function () {
                var $this = $(this),
                    pageType = $this.data('page-type');
                switch (pageType) {
                    case 'page':
                        if ($this.data('page') == currentPage) {
                            $this.addClass(_this.activeClass);
                        }
                        break;
                    default:
                        break;
                }

            });
            sub_section.append(label);
            slide.append(pagination);
            $('.main-pagination').append(this.PerPageList()).append(main.append(sub_section.append(prev).append(slide).append(next)));
            if(this.totalPages > this.visiblePages){
                $(".next").removeClass(_this.disabledClass).addClass('active');
            }
        },

        PerPageList: function() {
            // create buttons to manipulate current per page
            var page_btn = [10,25,50,100];
            var pagination_right = $('<div class="col-6" />');

            var pagination_block  = $('<div class="pagination-block__box" />');
            pagination_right.append(pagination_block);
            pagination_block.append('<span>Funnels per page</span>');

            var pagination = $('<ul class="pagination" />');

            // add pages inbetween
            // truncate list when too large.
            for (var i=0; i < page_btn.length; i++) {

                if(window.items.length > page_btn[0] && window.items.length <= page_btn[1] && (i == 0 || i == 1 )){
                    disable_class = "";
                }else if(window.items.length > page_btn[1]  && window.items.length <= page_btn[2] && (i == 0 || i == 1 || i == 2 )){
                    disable_class = "";
                }else if(window.items.length > page_btn[2]){
                    disable_class = "";
                }else{
                    disable_class  = 'class="disabled"';
                }
                // markup for page button
                var pageBtn = $('<li '+disable_class+'></li>');

                // add active class for current page
                if (page_btn[i]  == currentPerPage) {
                    pageBtn.addClass('active');
                }
                pageBtn.append('<a href="#">' + page_btn[i] + '</a>');

                pagination_block.append(pagination.append(pageBtn));
            }
            pagination_right.append(pagination_right);
            return pagination_right;
        },
        show: function () {
            var page = this.getItem();
            $(".main-pagination").empty();
            container.empty();
            $('.funnel-empty-message').hide();
            if($("body").hasClass('hide-stats')){
                $('.heading-bar__funnels-info.total_funnels,.heading-bar__funnels-info.total-leads').addClass('d-none');
            }
            else{
                $('.heading-bar__funnels-info.total_funnels,.heading-bar__funnels-info.total-leads').removeClass('d-none');
            }
            $('.funnels-block,.heading-bar__sorting').removeClass('d-none');
            container.append(page);
            this.render();
            this.applystyle();
            renderFunc();
        },
        applystyle: function(){
            display = this.visiblePages;
            insidewidth = 0;
            offset = 4;

            $(".za-page").find('li').each(function(i,n){
                if(i == 0){
                    outsidewidth = (this.offsetWidth*display);
                }
                insidewidth += this.offsetWidth;
            });
            if($(".za-page").find('li').length <= 5){
                outsidewidth = $(".za-page").find('li').length*$(".za-page").find('li').width();
            }
            $(".za-page").css({'width': insidewidth+offset});
            $(".za-page").parent().css({width: outsidewidth});
        },
        animationPagination: function (){
            if(currentPage == this.totalPages){
                var left = outsidewidth+36;
            }else{
                left = outsidewidth;
            }
            if (page_type == 'prev') {
                $(".next").removeClass(paginate.disabledClass).addClass('active');
                $(".slide").animate({scrollLeft: $(".slide").scrollLeft()-left},'slow');
                if($(".slide").scrollLeft() <= parseInt($(".slide").css('width'))){
                    $(".prev").addClass(paginate.disabledClass).removeClass('active');
                }

            } else {
                $(".prev").removeClass(paginate.disabledClass).addClass('active');
                if($(".slide").scrollLeft()+left >= parseInt($(".slide").css('width'))){
                    $(".next").addClass(paginate.disabledClass).removeClass('active');
                }
                $(".slide").animate({scrollLeft: $(".slide").scrollLeft()+left},'slow');

            }
        }
    };

    window.keypresstimeout = 0;
    var setTimeout_function;
    window.is_refreah = 1;

    $(document).on('change','.funnel-sorting',function (e){
        e.preventDefault();
        sorting();
        tag_filter_session();
    });

    $(document).on('click','.heading-bar__sorting-links li',function (e){
        $('.heading-bar__sorting-links li').removeClass('active').addClass('inactive');
        $(this).addClass('active').removeClass('inactive');
        sorting();
        tag_filter_session();
    });

    $(document).on('keydown keyup','.funnel-search,.funnel-url, .dashboard-tag-result .select2-search__field',function(event){
        if(event.keyCode == 13){
            _search();
        }
    });

    $(document).on('keydown keyup','.top-funnel-search,.top-funnel-url, .top-tag-result .select2-search__field',function(event){
        if(event.keyCode == 13){
            topHeaderFunnelFilter();
        }
    });

    //filter by funnel type
    last_select_funnel_type_text = $(".funnel-type-search option:selected").text();
    last_select_funnel_type_value = $(".funnel-type-search").val();
    top_last_select_funnel_type_text = $(".top-funnel-type-search option:selected").text();
    top_last_select_funnel_type_value = $(".top-funnel-type-search").val();
    $(document).on('change','.funnel-type-search,.top-funnel-type-search',function (e){
        if($(this).val() == 'w' &&  $(this).find(":selected").data('count') ==  0){
            if($(this).parents('.megamenu-filter').length == 1) {
                window.top_serach_tigger = 1;
                top_search_data = [];
                $(".top-header-funnel").topHeaderFunnelLoader();
            }
            else{
                window.top_serach_tigger = 0;
                data = [];
                $('.funnels-details').funnelLoader();
            }
        }
        else {

        if($(this).parents('.megamenu-filter').length == 1){
            top_last_select_funnel_type_text = $(".top-funnel-type-search option:selected").text();
            top_last_select_funnel_type_value = $(".top-funnel-type-search").val();
            $(".top-tag-search,.top-funnel-search,.top-funnel-url").val('');
            $(".megamenu-filter .select2-selection__choice").remove();
            $('.top-tag-search .select2-search__field').attr('placeholder', 'Type in Funnel Tag(s)...');
            topHeaderFunnelFilter();
        }
        else {
            last_select_funnel_type_text = $(".funnel-type-search option:selected").text();
            last_select_funnel_type_value = $(".funnel-type-search").val();
            $(".funnel-search,.tag-search,.funnel-url").val('');
            $(".search-bar-slide .select2-selection__choice").remove();
            $('.tag-search .select2-search__field').attr('placeholder', 'Type in Funnel Tag(s)...');
            // Set selected Folder Name as Label
            $(".heading-bar__funnels h2").text(last_select_funnel_type_text);
            _search();
        }
        }
    });

    // filter by funnel name/tags
    $(document).on('change','.funnel-filter,.top-funnel-filter',function (e){
        $(".funnel-search,.tag-search,.top-tag-search,.top-funnel-search,.top-funnel-url,.funnel-url").val('');
        $(".search-bar__filter .select2-selection__choice").remove();
        $('.tag-search .select2-search__field,.top-tag-search .select2-search__field').attr('placeholder','Type in Funnel Tag(s)...');
        if($(this).parents('.megamenu-filter').length == 1){
            topHeaderFunnelFilter();
        }
        else {
            _search();
        }
    });

    $( ".funnel-search,.top-funnel-search,.funnel-url,.top-funnel-url" ).keydown(function() {
        keypresstimeout = 0;
        if(is_refreah == 0){
            clearTimeout(setTimeout_function);
        }
    });

    //A30-3068 removed as only required on ENTER & search button click ,.funnel-url,.top-funnel-url
    $( ".funnel-search,.top-funnel-search" ).keyup(function() {
        var megamenu_filter = $(this).parents('.megamenu-filter');
        if(is_refreah == 0) {
            clearTimeout(setTimeout_function);
        }
        is_refreah = 0;
        setTimeout_function = setTimeout(function(){
            if(keypresstimeout == 0){
                if(megamenu_filter.length == 1){
                    $(".top-header-search").trigger('click');
                }
                else {
                    _search();
                }
                keypresstimeout = 1;
            }
        }, 500);
    });

    //website model hide if have not website funnel
    $(document).on('click','#website_funnel_modal_hide',function (e){
        if(window.top_serach_tigger == 1) {
            $(".top-funnel-type-search").val(top_last_select_funnel_type_value);
            $(".megamenu__folder .select2-selection__rendered").text(top_last_select_funnel_type_text);
        }
        else{
            $(".funnel-type-search").val(last_select_funnel_type_value);
            $(".funnel-type .select2-selection__rendered").text(last_select_funnel_type_text);
        }
    });

    //pagination functionality
    $(document).on('click', '.pagination li', function (e) {
        e.preventDefault();
        // get current page from active button
        if(!$(this).hasClass('active') && !$(this).hasClass('disabled')) {
            currentPerPage = parseInt($(this).text(), 10),
                target = $(e.target);
            // get numbered page
            currentPerPage = parseInt(target.text(), 10);
            paginate.totalPages = Math.ceil(window.items.length / currentPerPage);
            // ensure newPage is in available range
            currentPage = 1;
            paginate.show();
            tag_filter_session();
        }
    });
    $(document).on('click', '.za-page li', function (e) {
        e.preventDefault();
        // get items page from active button
        if(!$(this).hasClass('active')) {
            paginate.totalPages = Math.ceil(window.items.length / currentPerPage);
            var target = $(e.target);
            // get numbered page
            currentPage = parseInt($(this).data('page'), 10);
            // ensure newPage is in available range
            if (currentPage > 0 && currentPage <=  paginate.totalPages) {
                paginate.show();
                tag_filter_session();
            }
            if(currentPage > 5) {
                paginate.animationPagination();
            }
        }
    });
    $(document).on('click', '.page-btn', function (e) {
        e.preventDefault();
        if(!$(this).hasClass('disabled')) {
            page_type = $(this).data('page-type');
            paginate.animationPagination();
        }
    });

    $(document).on('click', '.disable_lite_package', function (e) {
        e.preventDefault();
        showLitePackageDisableAlert();
        return false;
    });

    $(document).on('click', '.funnels-details .tag-btn', function (e) {
        e.preventDefault();
        return false;
    });

    $(document).ready(function(){
        $(document).on("keyup","#filter_conversion_rate",function (){
            if($(this).val() > 100){
                $(this).val(100);
            }
        });


        if(clone_flag == 'y'){
            $('body').addClass('client-plan-pro')
        }

    })

    $(".top-header-funnel").topHeaderFunnelLoader();
    $(document).ready(function (){
        if(data != null) {
            _search(false);
        }
    })

    let requesting = false;

    $(document).on('click', '.copy_funnel_url_on_click', function (e) {
        e.preventDefault();
        if(!requesting) {
            requesting = true;

            var copyText = $(this).attr('href');

            document.addEventListener('copy', function (e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            // console.log('copied text : ', copyText);
            let copy_url = $(this).data('url');
            setTimeout(() => {
                displayAlert('success', copy_url+' Funnel URL has been copied to the clipboard.');
                requesting = false;
            }, 300);
        }
    });

    //when remove all tag then drop down will be hide.
    $(document).on('keydown keyup','.select2-search__field',function(event){
        $('.dashboard-tag-result .za-tag-custom .select2-results__options').getNiceScroll().hide();
        if(event.keyCode === 8){
            if(!$(this).hasClass('select2-remove-focus')) {
                $(this).addClass('select2-remove-focus');
            }
            var selectedTag = $(this).parents('.select2-selection__rendered').find('.select2-selection__choice').length;
            var tagSearch = $(this).val();
            if(selectedTag === 0 && tagSearch === "") {
                $(this).trigger('click');
            }
            niceScrollHide = true;
            if(tagSearch === "") {
               $(this).removeClass('select2-remove-focus');
                $('.dashboard-tag-result .za-tag-custom .select2-results__options').getNiceScroll().show();
            }
        }
    });
    $(document).on('blur','.select2-search__field',function(event){
        $('.dashboard-tag-result .select2-search__field').val('').removeClass('select2-remove-focus');
    });

    /*
     * Adding this for sorting of funnel name A - Z and Z - A
   */

    $(document).on('click','.tag-sort',function(e){
        $('.tag-sort').removeClass('active');
        $(this).addClass('active');
        topHeaderSrotingFunnel();
        $(".top-header-funnel").topHeaderFunnelLoader();
    });

    /*
     * Adding this for sorting of funnel URL A - Z and Z - A
   */

    $(document).on('click','.url-tag-sort',function(e){
        $('.url-tag-sort').removeClass('active');
        let sort = $(this).addClass('active').data('sort');
        top_search_data.sort(function(a, b) {
            a = a['domain_name'].toLowerCase();
            b = b['domain_name'].toLowerCase();
            if(sort === 'url-asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
        $(".top-header-funnel").topHeaderFunnelLoader();
    });
})(jQuery);

$(window).resize(function(){
    $('.dashboard-funnels').funnelLoader();
});
/**
 * this function are using global in the file. whenever, change the filter value then will call it.
 * @param is_click
 * @private
 */
function _search(exe_ajax){
    jQuery(".clear-search").hide();
    if(exe_ajax === undefined) exe_ajax = true;
    window.top_serach_tigger = 0;
    funnel_filter();
    conversionRate(false);
    sorting();
    leadCount();
    if(currentPage > 5) {
        paginate.animationPagination();
    }
    if(data != null && exe_ajax==true) {
        tag_filter_session();
    }

    jQuery(".options-menu__item.view").hover(function () {
        jQuery(this).toggleClass('view-hover');
    });
}

/**
 * this function are using for dashboard top header filter
 */
function topHeaderFunnelFilter(){
    window.top_serach_tigger = 1;
    var data = [];
    var search = ($('.top-funnel-search').val())?$.trim($('.top-funnel-search').val().toLowerCase()):'';
    var tag_search = $(".top-tag-search").val();
    var funnel_url = ($('.top-funnel-url').val())?$.trim($('.top-funnel-url').val().toLowerCase().replace(/^https?:\/\//,'').replace(/[/]+$/,'')):'';
    var w = '';
    funnel_type = $(".top-funnel-type-search").val();
    var webiste_val = $(".top-funnel-type-search option:selected").data('value');

    /**
     * if funnel_type == 0 then all funnel will be show
     */
    if(funnel_type == 0){
        if(search != ""){
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                }
            });
        }
        /**
         * if funnel_type == 0 and funnel url is not empty
         * then funnel will be show into all funnel with funnel url
         */
        else if(funnel_url != ""){
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return el.domain_name.toLowerCase().indexOf(funnel_url) === 0;
                }
            });
        }
        /**
         *if funnel type == 0 and tag search is not empty
         * then funnel will be show into all funnel with search tag name
         */
        else if(tag_search != ""){
            data = jQuery.grep(rec, function (el, i) {
                if(el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return el;
                    }
                }
            });
        }else{
            data = rec;
        }

    }
    /**
     *tag search and funnel name search is empty and funnel_type is not website funnel
     * then funnel will be show with selected funnel type
     */
    else if ((search == "" && tag_search == "" && funnel_url == "") && parseInt(funnel_type)) {
        data = jQuery.grep(rec, function (el, i) {
            return parseInt(el.leadpop_folder_id) == parseInt(funnel_type);
        });
    }
    /**
     *tag search and funnel name search is empty and funnel_type == website funnel
     * then funnel will be website funnel show
     */
    else if ((search == "" && tag_search == "" && funnel_url == "") && funnel_type == 'w') {
        data = jQuery.grep(rec, function (el, i) {
            return  parseInt(el.leadpop_folder_id) == parseInt(webiste_val);
        });
    }
    /**
     *funnel name search is not empty and  search type == Search by Funnel Name
     * then matching funnel will be show with selected funnel name
     *
     */
    else if(search != "" &&  $(".top-funnel-filter").val() == 1){
        /**
         *if funnel type is not website funnel
         *
         */
        if (parseInt(funnel_type)) {
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return parseInt(el.leadpop_folder_id) == parseInt(funnel_type) && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                }
            });
        }
        /**
         *if funnel type is website funnel
         *
         */
        else{
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return (parseInt(el.leadpop_folder_id) == parseInt(webiste_val)) && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                }
            });
        }
    }

    /**
     *funnel url search is not empty and  search type == Search by Funnel URL
     * then matching funnel will be show with selected funnel url
     *
     */
    else if(funnel_url != "" &&  $(".top-funnel-filter").val() == 3){
        /**
         *if funnel type is not website funnel
         *
         */
        if (parseInt(funnel_type)) {
            data = jQuery.grep(rec, function (el, i) {
                if(el.domain_name) {
                    return parseInt(el.leadpop_folder_id) == parseInt(funnel_type) && el.domain_name.toLowerCase().indexOf(funnel_url) === 0;
                }
            });
        }
        /**
         *if funnel type is website funnel
         *
         */
        else{
            data = jQuery.grep(rec, function (el, i) {
                if(el.domain_name) {
                    return (parseInt(el.leadpop_folder_id) == parseInt(webiste_val)) && el.domain_name.toLowerCase().indexOf(funnel_url) === 0;
                }
            });
        }
    }

    /**
     *tag search is not empty then funnel will be show
     */
    else if (tag_search != "") {
        /**
         *if funnel type is not website funnel
         *
         */
        if (parseInt(funnel_type)) {
            data = jQuery.grep(rec, function (el, i) {
                if(el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return parseInt(el.leadpop_folder_id) == parseInt(funnel_type);

                    }
                }
            });
        }

        /**
         *if funnel type is website funnel
         *
         */
        else {
            data = jQuery.grep(rec, function (el, i) {
                if(el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return el.funnel_type == funnel_type;
                    }
                }
            });
        }
    }
    window.top_search_data = data;
    $(".top-header-funnel").topHeaderFunnelLoader();
    initScroll();
    lpUtilities.globalTooltip();
}


/**
 * this function are using for dashboard filter
 */
function funnel_filter(){

    var data = [];
    var search = ($('.funnel-search').val())?$.trim($('.funnel-search').val().toLowerCase()):'';
    var tag_search = $(".tag-search").val();
    var funnel_url = ($('.funnel-url').val())?$.trim($('.funnel-url').val().toLowerCase().replace(/^https?:\/\//,'').replace(/[/]+$/,'')):'';
    if(funnel_url.includes("#")){
    funnel_url = funnel_url.substr(0, funnel_url.indexOf('/'));
    }
    var w = '';
    funnel_type = $(".funnel-type-search").val();
    funnel_type_name = $(".funnel-type-search option:selected").text();
    var webiste_val = $(".funnel-type-search option:selected").data('value');
    /**
     * if funnel_type == 0 then all funnel will be show
     */
    if(funnel_type == 0){
        if(search != ""){
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                }
            });
            if(data){
                jQuery(".clear-search").show();
            }
        }
        /**
         * if funnel_type == 0 and funnel url is not empty
         * then funnel will be show into all funnel with funnel url
         */
        else if(funnel_url != ""){
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return el.domain_name.toLowerCase().indexOf(funnel_url) === 0;
                }
            });
            if(data){
                jQuery(".clear-search").show();
            }
        }
        /**
         *if funnel type == 0 and tag search is not empty
         * then funnel will be show into all funnel with search tag name
         */
        else if(tag_search != ""){
            data = jQuery.grep(rec, function (el, i) {
                if(el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return el;
                    }
                }
            });
        }else{
            data = rec;
        }

    }
    /**
     *tag search and funnel name search is empty and funnel_type is not website funnel
     * then funnel will be show with selected funnel type
     */
    else if ((search == "" && tag_search == "" && funnel_url == "") && parseInt(funnel_type)) {
        data = jQuery.grep(rec, function (el, i) {
            return parseInt(el.leadpop_folder_id) == parseInt(funnel_type);
        });
    }
    /**
     *tag search and funnel name search is empty and funnel_type == website funnel
     * then funnel will be website funnel show
     */
    else if ((search == "" && tag_search == "" && funnel_url == "") && funnel_type == 'w') {
        data = jQuery.grep(rec, function (el, i) {
            return  parseInt(el.leadpop_folder_id) == parseInt(webiste_val);
        });
    }
    /**
     *funnel name search is not empty and  search type == Search by Funnel Name
     * then matching funnel will be show with selected funnel name
     *
     */
    else if(search != "" &&  $(".funnel-filter").val() == 1){
        /**
         *if funnel type is not website funnel
         *
         */
        if (parseInt(funnel_type)) {
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return parseInt(el.leadpop_folder_id) == parseInt(funnel_type) && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                }
            });
        }
        /**
         *if funnel type is website funnel
         *
         */
        else{
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    return (parseInt(el.leadpop_folder_id) == parseInt(webiste_val)) && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                }
            });
        }
        if(data){
            jQuery(".clear-search").show();
        }
    }
    /**
     *funnel url search is not empty and  search type == Search by Funnel URL
     * then matching funnel will be show with selected funnel url
     *
     */
    else if(funnel_url != "" &&  $(".funnel-filter").val() == 3){
        /**
         *if funnel type is not website funnel
         *
         */
        if (parseInt(funnel_type)) {
            data = jQuery.grep(rec, function (el, i) {
                if(el.domain_name) {
                    return parseInt(el.leadpop_folder_id) == parseInt(funnel_type) && el.domain_name.toLowerCase().indexOf(funnel_url) === 0;
                }
            });
        }
        /**
         *if funnel type is website funnel
         *
         */
        else{
            data = jQuery.grep(rec, function (el, i) {
                if(el.domain_name) {
                    return (parseInt(el.leadpop_folder_id) == parseInt(webiste_val)) && el.domain_name.toLowerCase().indexOf(funnel_url) === 0;
                }
            });
        }
        if(data){
            jQuery(".clear-search").show();
        }
    }
    /**
     *tag search is not empty then funnel will be show
     */
    else if (tag_search != "") {
        /**
         *if funnel type is not website funnel
         *
         */
        if (parseInt(funnel_type)) {
            data = jQuery.grep(rec, function (el, i) {
                if(el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return parseInt(el.leadpop_folder_id) == parseInt(funnel_type);

                    }
                }
            });
        }

        /**
         *if funnel type is website funnel
         *
         */
        else {
            data = jQuery.grep(rec, function (el, i) {
                if(el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return el.funnel_type == funnel_type;
                    }
                }
            });
        }
    }
    var filter_funnel_visitor = $("#filter_funnel_visitor").val();
    var exclude_visitor = $("#exclude_visitor").is(":checked");
    if(filter_funnel_visitor === undefined){
        filter_funnel_visitor = exclude;
        exclude_visitor = visitor;
    }
    if((exclude_visitor == "true" || exclude_visitor == true) && filter_funnel_visitor != 0) {
        data = jQuery.grep(data, function (el, i) {
            if (el.total_visits) {
                return (parseInt(el.total_visits) >= parseInt(filter_funnel_visitor));
            }
        });
    }
    $("#total-funnels-setting").modal('hide');
    window.data = data;
}

/**
 * this function use for match the tag in funnel tag
 * @param needles
 * @param haystack
 * @returns {boolean}
 */
function containsAll(needles, haystack){
    if(needles) {
        /**
         * Has ALL of these tags
         */
        let type = 0;
        if(window.top_serach_tigger == 1){
            type = $(".top-tag-type").val();
        }
        else{
            type = $(".tag-type").val();
        }
        if (type == 2) {
            for (var i = 0, len = needles.length; i < len; i++) {
                if ($.inArray(needles[i], strReplaceOrg(haystack)) == -1) return false;
            }
            return true;
        }
        /**
         * Has ANY of these tags
         */
        else {
            for (var i = 0, len = needles.length; i < len; i++) {
                if ($.inArray(needles[i], strReplaceOrg(haystack)) != -1) return true;
            }
            return false;
        }
    }
}

/**
 * count total lead and show on the dashboard
 */
function leadCount(){
    var count = total_visitor = funnel_list = total_lead = 0;
    $(data).each(function (i,v){
        if(v.new_leads > v.total_leads){
            total_lead = v.new_leads;
        }
        else{
            total_lead = v.total_leads;
        }
        count += parseInt(total_lead);
        total_visitor +=  parseFloat(v.total_visits);
    });
    $('.total-leads span,.stats-total-leads').text(count.toLocaleString());
    $(".stats-total-visitors").text(total_visitor.toLocaleString());

    if(window.is_lite_package == 1){
        funnel_list = litePackageItemsDisabled.length;
    }else{
        funnel_list = data.length;
    }
    $('.heading-bar__funnels .total_funnels span,.stats-total-funnels').text(parseInt(funnel_list).toLocaleString());
}

/**
 * funnel sorting
 */
function sorting(){
    var sort = $('.heading-bar__sorting-links li.active').data('sort');
    /**
     * sort by created date
     */


    data.map(function (value, index) {

        var total_leads = parseInt(value['total_leads']);
        var new_leads = parseInt(value['new_leads']);
        if (new_leads > total_leads) {
            return value['total_leads'] = new_leads;
        }
    });



    if($(".funnel-sorting").val() == 1){
        data.sort(function(a, b) {
            a = new Date(a.date_added);
            b = new Date(b.date_added);
            if(sort == 'asc') {
                return a > b ? -1 : a < b ? 1 : 0;
            }else{
                return a < b ? -1 : a > b ? 1 : 0;
            }
        });
    }
    /**
     *sort by domain name
     */
    else if($(".funnel-sorting").val() == 2){
        data.sort(function(a, b) {
            a = a.domain_name;
            b = b.domain_name;
            if(sort == 'asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
    }
    /**
     * sort by funnel name
     */
    else if($(".funnel-sorting").val() == 3){
        data.sort(function(a, b) {
            a = strReplaceOrg((a.funnel_name)?a.funnel_name.toLowerCase():a.funnel_name);
            b = strReplaceOrg((b.funnel_name)?b.funnel_name.toLowerCase():b.funnel_name);
            if (sort == 'asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            } else {
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
    }
    /**
     * sort by last edit
     */
    else if($(".funnel-sorting").val() == 4){
        data.sort(function(a, b) {
            a = (a.last_edit == '0000-00-00 00:00:00')?new Date(a.date_added):new Date(a.last_edit);
            b = (b.last_edit == '0000-00-00 00:00:00')?new Date(b.date_added):new Date(b.last_edit);
            if(sort == 'asc') {
                return a > b ? -1 : a < b ? 1 : 0;
            }else{
                return a < b ? -1 : a > b ? 1 : 0;
            }
        });
    }
    /**
     * sort by last submission
     */
    else if($(".funnel-sorting").val() == 5){
        data.sort(function(a, b) {
            a = new Date(a.last_submission);
            b = new Date(b.last_submission);
            if(sort == 'asc') {
                return a > b ? -1 : a < b ? 1 : 0;
            }else{
                return a < b ? -1 : a > b ? 1 : 0;
            }
        });
    }
    /**
     * sort by total lead number
     */
    else if($(".funnel-sorting").val() == 6){
        data.sort(function(a, b) {
            a = parseInt(a.total_leads);
            b = parseInt(b.total_leads);
            if(sort == 'asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
    }
    /**
     * sort by total visits number
     */
    else if($(".funnel-sorting").val() == 7){
        data.sort(function(a, b) {
            a = parseInt(a.total_visits);
            b = parseInt(b.total_visits);
            if(sort == 'asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
    }
    /**
     * sort by lead conversion rate
     */
    else if($(".funnel-sorting").val() == 8){
        data.sort(function(a, b) {
            a = parseFloat(a.conversion_rate);
            b = parseFloat(b.conversion_rate);
            if(sort == 'asc') {
                return a < b ? -1 : a > b ? 1 : 0;
            }else{
                return a > b ? -1 : a < b ? 1 : 0;
            }
        });
    }
    /**
     * sort by tag
     */
    else if($(".funnel-sorting").val() == 9){
        data.sort(function(a, b) {
            if(a.client_tag_name) {
                a = strReplaceOrg(a.client_tag_name.split(',')[0]);
                b = strReplaceOrg(b.client_tag_name.split(',')[0]);
                if (sort == 'asc') {
                    return a < b ? -1 : a > b ? 1 : 0;
                } else {
                    return a > b ? -1 : a < b ? 1 : 0;
                }
            }
        });
    }
    $('.funnels-details').funnelLoader();
}

/**
 *selected filter option save in session
 */
function tag_filter_session(){
    var sidebar = searchFilter = statsFilter = 0;
    if($(".funnel-filter").val() != undefined) {
        if($("body").hasClass('sidebar-active')){
            sidebar = 1;
        }
        if($("body").hasClass('hide-seach')){
            searchFilter = 1;
        }
        if($("body").hasClass('hide-stats')){
            statsFilter = 1;
        }
        var filter_funnel_visitor = $("#filter_funnel_visitor").val();
        var exclude_visitor = $("#exclude_visitor").is(":checked");

        if(filter_funnel_visitor === undefined){
            filter_funnel_visitor = exclude;
            exclude_visitor = visitor;
        }
        if(exclude_visitor){
            jQuery(".funnel-box .stats-box__link-settings").addClass('active');
        }
        else{
            jQuery(".funnel-box .stats-box__link-settings").removeClass('active');
        }

        var excludeConversionRate = $("#conversionRate").is(":checked");
        var filter_ConversionRate = $("#filter_conversion_rate").val();
        if(filter_ConversionRate === undefined){
            filterConversionRate = filter_conversion_rate;
            excludeConversionRate = exclude_ConversionRate;
        }
        else{
            filterConversionRate = filter_ConversionRate;
        }
        if(excludeConversionRate){
            jQuery(".conversion-rate-box .stats-box__link-settings").addClass('active');
        }
        else{
            jQuery(".conversion-rate-box .stats-box__link-settings").removeClass('active');
        }

        jQuery("#total-funnels-setting .button-cancel").attr('data-value',filter_funnel_visitor);
        jQuery("#total-funnels-setting .button-cancel").attr('data-status',(exclude_visitor === true)?1:0);
        jQuery("#conversion-setting .button-cancel").attr('data-value',filterConversionRate);
        jQuery("#conversion-setting .button-cancel").attr('data-status',(excludeConversionRate === true)?1:0);

        var funnel_url= $(".funnel-url").val();
        if(funnel_url.includes("#")){
            funnel_url = funnel_url.substr(0, funnel_url.indexOf('#'));
        }
        funnel_type = $(".funnel-type-search").val();
        funnel_type_name = $(".funnel-type-search option:selected").text();
        var sorting_filters = 'sort=' + $(".funnel-sorting").val() + '&sort_name=' + $(".funnel-sorting option:selected").text() + '&order=' + $('.heading-bar__sorting-links li.active').data('sort');
        var current_selected_data = 'funnel=' + funnel_type + '&funnel_type_name=' + encodeURIComponent(strReplace(funnel_type_name))
            + '&search_type=' + $(".funnel-filter").val()
            + '&search_type_name=' + $(".funnel-filter option:selected").text().trim()
            + '&tag_type=' + $(".tag-type").val()
            + '&tag_type_name=' + $(".tag-type option:selected").text().trim()
            + '&tag=' + strReplace($(".tag-search").val())
            + '&funnel_search=' + encodeURIComponent(strReplace($('.funnel-search').val()))
            + '&funnel_url=' + funnel_url
            + '&perPage=' + currentPerPage + '&page=' + currentPage+'&sidebar='+sidebar+'&searchFilter='+searchFilter
            + '&statsFilter='+statsFilter + '&excludeVisitor='+exclude_visitor + '&filterFunnelVisitor='+filter_funnel_visitor
            + '&excludeConversionRate='+excludeConversionRate + '&filterConversionRate='+filterConversionRate;
        $.ajax({
            type: "POST",
            data: current_selected_data + "&" + sorting_filters + '&_token=' + ajax_token,
            url: site.baseUrl + "/lp/tagfiltersession",
            success: function (d) {
                if(isClone == 1) {
                    isClone = 0;
                    goToPage();
                }
            },
            error: function (response) {
            }
        });
    }
}

/**
 * get funnel nav item
 * @param el
 * @returns {string}
 */
function getFunnelNavItem(el,index){
    var clone_lite_package='';
    if(window.is_lite_package == 1){
        clone_lite_package='disable_lite_package';
    }
    var shortLinkClass = '';
    var lynxlyLink = site.allShortLinks[el['client_leadpop_id']];
    let funnelUrl = "https://" + el['domain_name'];
    if(typeof lynxlyLink != "undefined") {
        var shortLink = site.shortenerAppBaseUrl + '/' + (lynxlyLink ? lynxlyLink.slug_name : '');
        shortLinkClass = lynxlyLink ? 'view-has-short-url' : '';
    }
    var nav = '<div class="funnels-details__options">' +
        '                                        <span class="title">Options</span>' +
        '                                        <ul class="options-menu">' +
        '                                            <li class="options-menu__item view">' +
        '                                                <div class="view-wrap">' +
        '<a class="options-menu__link" href="'+ funnelUrl + '" target="_blank">' +
        '                                                    <span class="icon ico-view"></span>' +
        '                                                    View' +
        '                                                </a>' +
        '<div class="view-popup-wrap '+ shortLinkClass +'">' +
        '                <div class="view-popup">' +
        '                   <div class="view-popup__holder copy-btn-area">' +
        '                    <div class="view-popup__wrap">' +
        '                        <strong class="view-popup__title">full url:</strong>' +
        '                        <span class="view-popup__url">'+ funnelUrl + ' <span class="copy-text">' + funnelUrl + '</span> </span>' +
        '                        <div class="hover-block">' +
        '                            <ul class="url-option">' +
        '                                <li><a class="copy_funnel_url_on_click copy-btn menu-tooltip" title="Copy URL" href="' + funnelUrl + '" data-url="Full"><i class="ico-copy"></i></a></li>' +
        '                                <li><a href="' + funnelUrl + '" class="menu-tooltip" title="Open URL" target="_blank"><i class="ico-tab"></i></a></li>' +
        '                            </ul>' +
        '                        </div>' +
        '                       </div>' +
        '                    </div>';
    if(typeof lynxlyLink != "undefined"){
        nav += '        <div class="view-popup__holder copy-btn-area">' +
            '                    <div class="view-popup__wrap">' +
            '                        <strong class="view-popup__title">Short Link:</strong>' +
            '                        <span class="view-popup__url">'+ shortLink + ' <span class="copy-text">'+ shortLink + '</span> </span>' +
            '                        <div class="hover-block">' +
            '                            <ul class="url-option">' +
            '                                <li><a class="copy_funnel_url_on_click copy-btn  el-tooltip" title="Copy URL"  href="'+ shortLink + '" data-url="Short"><i class="ico-copy"></i></a></li>' +
            '                                <li><a href="'+ shortLink + '" class="el-tooltip" title="Open URL"  target="_blank"><i class="ico-tab"></i></a></li>' +
            '                            </ul>' +
            '                        </div>' +
            '                    </div>' +
            '                </div>';
    }
    '                </div>';

    nav += '</div></div>' +
        '                                            </li>' +
        '                                            <li class="options-menu__item options-menu__item_sub-menu">' +
        '                                                <a href="#" class="options-menu__link options-submenu">' +
        '                                                    <span class="icon ico-edit"></span>' +
        '                                                    Edit' +
        '                                                </a>' +funnelSubNavItem(el,'edit',index)+
        '                                            </li>' +
        '                                            <li class="options-menu__item options-menu__item_sub-menu">' +
        '                                                <a href="#" class="options-menu__link options-submenu">' +
        '                                                    <span class="icon ico-promote"></span>' +
        '                                                    Promote' +
        '                                                </a>' +funnelSubNavItem(el,'promote',index)+
        '                                            </li>' +
        '                                            <li class="options-menu__item">' +
        '                                                <a class="options-menu__link" href="' + site.baseUrl + site.lpPath + '/popadmin/stats/' + el['hash'] + '">' +
        '                                                    <span class="icon ico-stats"></span>' +
        '                                                    Stats' +
        '                                                </a>' +
        '                                            </li>' +
        '                                            <li class="options-menu__item">' +
        '                                                <a class="options-menu__link" href="' + site.baseUrl + site.lpPath + '/myleads/index/' + el['hash'] + '">' +
        '                                                    <span class="icon ico-multi-user"></span>' +
        '                                                    Leads' +
        '                                                </a>' +
        '                                            </li>';
    if (el['leadpop_vertical_id'] != vertical_id) {
        nav += '<li class="options-menu__item">' +
            '<a href="#" data-ctalink="' + site.baseUrl + site.lpPath + '/index/clonefunnel/' + el['hash'] + '" data-subdomain="' + el['subdomain_name'] + '" data-top-domain="' + el['top_level_domain'] + '" data-folder-id="' + el['leadpop_folder_id'] + '" data-tag-id="' + el['client_tag_id'] + '"    class="cloneFunnelSubdomainBtn options-menu__link' + clone_lite_package + '">' +
            ' <span class="icon ico-copy"></span>Clone</a></li>';
    }
    nav += '</ul>' +
        '</div>';
    return nav;
}

/**
 * This will update question menu item and it's order in menu
 * on the base of funnel builder is avctive or inactive
 * @param menu
 * @param index
 * @param isBackward
 * @returns {*}
 */
function updateQuestionMenuItem(menu, index, isBackward = false) {
    let tmpMenu = menu[index];
    if(isBackward) {
        // tmpMenu.href = site.baseUrl + site.lpPath + '/popadmin/funnel/questions/';
        // tmpMenu.comingSoon = false;
        // tmpMenu.title = "Questions";
        //
        // menu[index] = menu[index - 1];
        // menu[index - 1] = tmpMenu;
    } else {
        tmpMenu.href = '';
        tmpMenu.comingSoon = true;
        tmpMenu.title = "COMING SOON";

        menu[index] = menu[index + 1];
        menu[index + 1] = tmpMenu;
    }
    return menu;
}

/**
 * get subnav item
 * @param el
 * @param type
 * @returns {string}
 */
function funnelSubNavItem(el,type,index){

    var navList = window.navItems[type];
    var subNav = '<div class="menu__dropdown-wrapper">' +
        '<div class="menu__dropdown">';
    if(navList !== undefined){
        if(el['funnel_name'] != "" && el['funnel_name'] != null){
            if(el['funnel_name'].length > 30) {
                funnel_name = parseHTML(el['funnel_name']).substr(0, 30) + '...';
            }else{
                funnel_name = parseHTML(el['funnel_name']);
            }
        }else{
            funnel_name = '';
        }

        let isActiveFunnelBuilder = el['is_active_funnel_builder'] == undefined ? false : el['is_active_funnel_builder'];
        Object.keys(navList).map(function (key) {
            var menu = navList[key];
            var head  =  key.replace('-',' ');
            subNav +='<div class="menu__dropdown-col">' +
                '                        <h3 class="menu__dropdown-head">'+head+'</h3>' +
                '                        <ul class="menu__dropdown-list">';

            let menuItemsCount = menu.length - 1;
            let dashAdded = false;
            let disabledClass = '';
            for(var i = 0; i < menu.length; i++ ){
                // deactivate question link
                let menuTxt = menu[i].label.toLowerCase();

                if(menuTxt === "questions"){
                    if(isActiveFunnelBuilder && menu[i].comingSoon){
                        //Skip Question menu with comingSoon=true Options
                        continue;
                    }
                    else if(!isActiveFunnelBuilder && !menu[i].comingSoon){
                        //Skip Question menu with comingSoon=false Options
                        continue;
                    }
                }

                /*
                if(menuTxt === 'questions' && !isActiveFunnelBuilder) {
                    //swapping menu in case of disable menu
                    if(menuItemsCount > i) {
                        menu = updateQuestionMenuItem(menu, i);
                    }
                }
                */

                var cl = attr = del ='';

                if(menu[i].comingSoon)
                    if(!dashAdded && menu[i].comingSoon){
                        dashAdded = true;
                        disabledClass = ' disabled el-tooltip ';
                        subNav += '</ul>' +
                            '<ul class="menu__dropdown-list coming-soon">'
                    }


                if(!menu[i].comingSoon && menu[i].label.toLowerCase() !=  'status' && menu[i].href!=''){
                    var url = menu[i].href+el['hash'];
                } else {
                    var url = 'javascript:void(0)';
                }

                if (clone_flag == 'y' && el['leadpop_version_seq'] > 1) {
                    del = 'y';
                }else{
                    del = 'n';
                }
                if(menu[i].label.toLowerCase() ==  'status'){
                    cl = 'funnelStatusBtn funnelstatus_' + el['domain_id'];
                    attr = "data-status="+ el['leadpop_active'] +" data-leadpop_version_seq=" + el['leadpop_version_seq'] + " data-domain_id=" + el['domain_id'] + " data-leadpop_id=" + el['leadpop_id'] + " data-leadpop_version_id=" + el['leadpop_version_id'] + " data-funnel-name='"+funnel_name+"' data-delete="+del+"  data-link=" + site.baseUrl + site.lpPath + '/index/deletefunnel/' + el['hash']+"";
                }
                if (type == 'promote' && menu[i].label.toLowerCase() ==  'sticky bar builder' && (stickybar_flag === null || stickybar_flag == 1)) {
                    subNav += '<li class="menu__dropdown-item">'+stickBar(el,index)+'</li>';
                }else{
                    subNav += '<li class="menu__dropdown-item">' +
                        '        <a href="' + url + '" class="menu__dropdown-link ' + disabledClass  + cl + '" ' + attr + ' title="' + menu[i].title + '">' + menu[i].label;
                    subNav += '</a>';
                    if (menu[i].hasOwnProperty('tag')) {
                        subNav += menu[i].tag
                    }
                    subNav += '</li>';
                }
            }
            subNav +='</ul>' +
                '   </div>';
        });
    }

    subNav +=' </div>' +
        '    </div>';
    return subNav;
}

/**
 * stickbar link set
 * @param el
 */

function stickBar(el,index){
    var url = [];
    var funnel_sticky_status = sticky_id = sticky_status = sticky_js_file =
        sticky_funnel_url = sticky_url = sticky_button = sticky_cta = sticky_bar = ft_slug = "";
    var pending_flag = 0;
    var sticky_script_type = 'a';
    var sticky_page_path = '/';
    var sticky_website_flag = 0;
    var stickybar_number_flag = 0;
    var stickybar_number = '';
    if (el['sticky_url'] != '') {
        url[el['sticky_url']] = el['sticky_funnel_url'];
    }
    sticky_bar = 'sticky-bar-inactive';
    if (el['sticky_status'] != 0) {
        sticky_bar = 'sticky-bar-active';
    }
    sticky_id = el['sticky_id'];
    sticky_cta = el['sticky_cta'];
    sticky_button = el['sticky_button'];
    sticky_url = el['sticky_url'];
    sticky_funnel_url = el['sticky_funnel_url'];
    sticky_js_file = el['sticky_js_file'];
    sticky_status = el['sticky_status'];
    pending_flag = el['pending_flag'];
    var show_cta = el['show_cta'];
    var sticky_size = el['sticky_size'];
    var sticky_updated = el['sticky_updated'];
    sticky_script_type = el['sticky_script_type'];

    var sticky_zindex = el['zindex'];
    var sticky_zindex_type = el['zindex_type'];
    stickybar_number = el['stickybar_number'];
    stickybar_number_flag = el['stickybar_number_flag'];

    if (sticky_status === null){
        funnel_sticky_status = '';
    } else if (parseInt(sticky_status) == 1) {
        if(parseInt(pending_flag) == 1){
            funnel_sticky_status = '(Active)';
        } else {
            funnel_sticky_status = '(Pending Installation)';
        }
    } else {
        funnel_sticky_status = '(Inactive)';
    }

    sticky_page_path = el['sticky_url_pathname'];
    sticky_website_flag = el['sticky_website_flag'];

    var  html = '<a href="'+ site.lpPath + '/index?sticky-bar=' + el['hash'] +'" id="sticky-bar-btn' + index + '" class="sticky-bar-btn_v2 menu__dropdown-link " data-index="' + index + '"\
                                 data-field="' + el['domain_name'] + '"\
                                data-id="' + el['client_leadpop_id'] + '"\
                                data-element_id = "sticky-bar-btn' + index + '"\
                                data-sticky_id = "' + sticky_id + '"\
                                data-sticky_cta = "' + sticky_cta + '"\
                                data-sticky_button = "' + sticky_button + '"\
                                data-sticky_url = "' + sticky_url + '"\
                                data-sticky_funnel_url = "' + sticky_funnel_url + '"\
                                data-sticky_status = "' + sticky_status + '"\
                                data-sticky_show_cta = "' + show_cta + '"\
                                data-sticky_size = "' + sticky_size + '"\
                                data-pending_flag = "' + pending_flag + '"\
                                data-v_sticky_button = "' + el['v_sticky_button'] + '"\
                                data-v_sticky_cta = "' + el['v_sticky_cta'] + '"\
                                data-sticky_page_path = "' + sticky_page_path + '"\
                                data-sticky_website_flag = "' + sticky_website_flag + '"\
                                data-sticky_location = "' + el['sticky_location'] + '"\
                                data-sticky_script_type = "' + sticky_script_type + '"\
                                data-sticky_zindex = "' + sticky_zindex + '"\
                                data-sticky_zindex_type = "' + sticky_zindex_type + '"\
                                data-sticky_phone_number = "' + stickybar_number + '"\
                                data-sticky_js_file = "' + sticky_js_file + '"\
                                data-funnel_hash = "' + el['hash'] + '"\
                                data-sticky_phone_number_checked = "' + stickybar_number_flag + '">\
                                Sticky Bar Builder\
                                <span class="funnel-sticky-status">' + funnel_sticky_status + '</span></a>';
    return html;
}

/**
 * get dashboard funnel right panel
 * @returns {string}
 */


function rightPanel(el){
    var html = '<div class="funnels-details__box-wrapper">' +
        '                                            <div class="funnels-box">' +
        '                                                <div class="row">'+getFunnelInfo(el,1)+
        '                                                </div>' +
        '                                            </div>' +
        '                                            <div class="funnels-details__box"> ' +
        '                                               <div class="column">' +
        '                                                    <div class="funnel-stats">' +
        '                                                        <span class="funnel-stats__title">Funnel Stats</span>' +
        '                                                        <div class="row">'
        +getStatsInfo(el)+
        '                                                        </div>' +
        '                                                    </div>' +
        '                                                </div>'+
        '                                                <div class="column">' +
            `<div class="leads-graph">
                                                        <div class="leads-graph__title-holder">
                                                            <div class="leads-graph__title-wrap">
                                                                <span class="leads-graph__title">Leads by Day</span>
                                                                <ul class="graph-tabs-list">
                                                                    <li><a href="#" class="graph-tab-link days active">last 7 days</a></li>
                                                                    <li><a href="#" class="graph-tab-link month">last 30 days</a></li>
                                                                </ul>
                                                            </div>
                                                           <a href="${site.baseUrl + site.lpPath + '/popadmin/stats/' + el['hash']}"> <span class="text"><i class="icon ico-stats"></i>Full Stats</span></a>
                                                        </div>
                                                        <div class="leads-graph__holder">
                                                            <div class="graph-tab-content">
                                                                <div class="chart-tab active days-chart">
                                                                    <div id="statsChart_${el['client_leadpop_id']}_${el['domain_id']}_${SevenDayChartDays}" style="height: 318px;"></div>
                                                                </div>
                                                                <div class="chart-tab month-chart">
                                                                                                                                        <div id="statsChart_${el['client_leadpop_id']}_${el['domain_id']}_${thirtyDayChartDays}" style="height: 318px;"></div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
            `+
        '                                                </div>' +
        '                                            </div>' +
        '                                        </div>';
    return html;
}

/**
 * get funnel info ex: funnel name, funnel tags, new leads
 * @param el,cond == 1 then tooltip will be show
 */
function getFunnelInfo(el,cond){
    var funnel_name_tags = status = funnel_hide = funnel_show = word_length = word_length_status = funnel_name_status = cl = attr = del = total_lead = '';

    var reseizeWidth = $(window).width();
    status = (el['leadpop_active'] != 0) ? 'd-none' : '';
    //resize window set the funnel name length
    if(reseizeWidth >= 1200 && reseizeWidth < 1300){
        word_length_open = (status) ? 37 : 28;
        word_length_close = (status) ? 42 : 35;
        word_length_inner_open = 10;
        word_length_inner_close = (status) ? 15 :10;
    }
    else if(reseizeWidth >= 1300 && reseizeWidth < 1400){
        word_length_open = (status) ? 39 : 31;
        word_length_close = (status) ? 44 : 38;
        word_length_inner_open = 13;
        word_length_inner_close =  (status) ? 18 :13;
    }
    else if(reseizeWidth >= 1400 && reseizeWidth < 1500){
        word_length_open = (status) ? 41 : 33;
        word_length_close = (status) ? 46 : 40;
        word_length_inner_open = 10;
        word_length_inner_close = (status) ? 18 :10;
    }
    else if(reseizeWidth >= 1500 && reseizeWidth <= 1600){
        word_length_open = (status) ? 43 : 38;
        word_length_close = (status) ? 53 : 45;
        word_length_inner_open = 14;
        word_length_inner_close = (status) ? 22 : 14;
    }
    else if(reseizeWidth > 1600 && reseizeWidth < 1700){
        word_length_open = (status) ? 47 : 41;
        word_length_close = (status) ? 55 : 49;
        word_length_inner_open = 18;
        word_length_inner_close = (status) ? 27 : 18;
    }
    else{
        word_length_open = (status) ? 58 : 52;
        word_length_close = (status) ? 66 : 59;
        word_length_inner_open = 29;
        word_length_inner_close = (status) ? 36 : 29;
    }
    //cond =1 use in expend funnel detail
    if(cond == 1){
        word_length = word_length_inner_open;
        word_length_status = word_length_inner_close;
        funnel_name_tags = 'funnels-box-inner__tags';
    }else {
        word_length = word_length_open;
        word_length_status = word_length_close;
    }
    if ($("body").hasClass('sidebar-active')) {
        funnel_hide = 'd-none';
        funnel_show = '';
    } else {
        funnel_hide = '';
        funnel_show = 'style="display:none;"';
    }

    if(el['funnel_name'] != "" && el['funnel_name'] != null){
        if(el['funnel_name'].length > word_length) {
            funnel_name = parseHTML(el['funnel_name']).substr(0, word_length) + '(...)';
        }else{
            funnel_name = parseHTML(el['funnel_name']);
        }
        if(el['funnel_name'].length > word_length_status) {
            funnel_name_status = parseHTML(el['funnel_name']).substr(0, word_length_status) + '(...)';
        }else{
            funnel_name_status = parseHTML(el['funnel_name']);
        }
    }else{
        funnel_name = '';
    }
    if (clone_flag == 'y' && el['leadpop_version_seq'] > 1) {
        del = 'y';
    }else{
        del = 'n';
    }
   /* if(el['new_leads'] > el['total_leads']){
        total_lead = parseInt(el['new_leads']);
    }
    else{
        total_lead = parseInt(el['total_leads']);
    }*/
    total_lead = parseInt(el['total_leads']);
    total_lead = (total_lead) ? total_lead.toLocaleString():0;
        cl = 'funnelStatusBtn funnelstatus_' + el['domain_id'];
        attr = "data-status="+ el['leadpop_active'] +" data-leadpop_version_seq=" + el['leadpop_version_seq'] + " data-domain_id=" + el['domain_id'] + " data-leadpop_id=" + el['leadpop_id'] + " data-leadpop_version_id=" + el['leadpop_version_id'] + " data-funnel-name='"+funnel_name+"' data-delete="+del+"  data-link=" + site.baseUrl + site.lpPath + '/index/deletefunnel/' + el['hash']+"";
    funnel_name_status = (funnel_name_status)?funnel_name_status:funnel_name;
    var tags = getFunnelTag(el);
    var funnel = '  <div class="funnels-box__column">';
    if(cond == 1){
        funnel += '<span class="funnels-details__info-name funnels-box-inner__name funnels-box__name sidebar-open-show" data-word-length="'+word_length+'" '+funnel_show+'><span class="el-tooltip" title="'+el['funnel_name']+'">'+funnel_name+'</span></span>' +
            '<span class="funnels-details__info-name funnels-box__name sidebar-close-show '+funnel_hide+'" data-word-length="'+word_length_status+'"><span class="el-tooltip" title="'+el['funnel_name']+'">'+funnel_name_status+'</span><span class="tag-btn funnel-status '+status+' '+cl+' el-tooltip" ' + attr + ' onclick="return false;" title="Status: Inactive"><i class="ico ico-ban-solid"></i></span></span>';
    }
    else{
        funnel += '<span class="tag-btn funnel-status '+status+' '+cl+' el-tooltip" ' + attr + ' onclick="return false;" title="Status: Inactive"><i class="ico ico-ban-solid"></i></span><span class="funnels-details__info-name funnels-box__name sidebar-open-show el-tooltip" title="'+el['funnel_name']+'" data-word-length="'+word_length+'" '+funnel_show+'>'+funnel_name+'</span>' +
            '<span class="funnels-details__info-name funnels-box__name sidebar-close-show el-tooltip '+funnel_hide+'" title="'+el['funnel_name']+'" data-word-length="'+word_length_status+'">'+funnel_name_status+'</span>';
    }
    funnel += '</div>'+
        '<div class="funnels-box__column">' +
        '<div class="tags-holder">' +
        '<div class="tags-wrap">' +
        '<div class="tags-holder-wrap">'+
        '<ul class="funnels-box__tags '+funnel_name_tags+'">'+tags;
    funnel +='</ul>' +
        '</div>' +
        '<span class="more"><span class="more-tags">...</span></span>';
    if(cond != 1) {
        funnel += '<div class="tags-popup-wrap">' +
            '<div class="tags-popup"><ul class="funnels-box__tags">'+tags+'</ul></div>' +
            '</div>';
    }
    funnel +='</div>' +
        '</div>' +
        '</div>' +
        '       <div class="funnels-box__column">'+
        '         <span class="funnels-box__number">'+total_lead+'</span>'+
        '     </div>';
    return funnel;
}

/**
 * get funnel stats
 * @param el
 * @returns {string}
 */
function getStatsInfo(el){
    var conversion_rate_fit_text = new_leads = total_lead = visits_sunday = visits_month = total_visits = '';
    if(parseInt(el['conversion_rate']) >= 100){
        conversion_rate_fit_text = 'fit-text';
    }
    if(el['new_leads'] > el['total_leads']){
        total_lead = parseInt(el['new_leads']);
    }
    else{
        total_lead = parseInt(el['total_leads']);
    }

    new_leads = parseInt(el['new_leads']);
    visits_sunday = parseInt(el['visits_sunday']);
    visits_month = parseInt(el['visits_month']);
    total_visits = parseInt(el['total_visits']);

    var stats =  '<div class="funnel-stats__column">' +
        '            <div class="funnel-stats__box">' +
        '            <span class="funnel-stats__box-title">New <br> Leads</span>' +
        '            <span class="funnel-stats__box-number new_leads">';
    stats +=(new_leads) ? new_leads.toLocaleString() : '-';
    stats +=  '</span>' +
        '           </div>' +
        '        </div>';
    stats +=  '<div class="funnel-stats__column">' +
        '            <div class="funnel-stats__box">' +
        '            <span class="funnel-stats__box-title">Total <br> Leads</span>' +
        '            <span class="funnel-stats__box-number total_leads">';
    stats +=(total_lead) ? total_lead.toLocaleString() : '-';
    stats +=  '</span>' +
        '           </div>' +
        '        </div>';
    stats +=  '<div class="funnel-stats__column">' +
        '            <div class="funnel-stats__box">' +
        '            <span class="funnel-stats__box-title">Visitors <br> Since Sunday</span>' +
        '            <span class="funnel-stats__box-number  visits_sunday">';
    stats +=(visits_sunday) ? visits_sunday.toLocaleString() : '-';
    stats +=  '</span>' +
        '           </div>' +
        '        </div>';
    stats +=  '<div class="funnel-stats__column">' +
        '            <div class="funnel-stats__box">' +
        '            <span class="funnel-stats__box-title">Visitors <br> This Month</span>' +
        '            <span class="funnel-stats__box-number visits_month">';
    stats +=(visits_month) ? visits_month.toLocaleString() : '-';
    stats +=  '</span>' +
        '           </div>' +
        '        </div>';
    stats +=  '<div class="funnel-stats__column">' +
        '            <div class="funnel-stats__box">' +
        '            <span class="funnel-stats__box-title">Total <br> Visitors</span>' +
        '            <span class="funnel-stats__box-number total_visits">';
    stats +=(total_visits) ? total_visits.toLocaleString() : '-';
    stats +=  '</span>' +
        '           </div>' +
        '        </div>';
    stats +=  '<div class="funnel-stats__column">' +
        '            <div class="funnel-stats__box">' +
        '            <span class="funnel-stats__box-title">Conversion <br> Rate</span>' +
        '            <span class="funnel-stats__box-number conversion_rate '+conversion_rate_fit_text+'">';
    stats +=(el['conversion_rate']) ? el['conversion_rate'] + '<sub>%</sub>' : '-';
    stats +=  '</span>' +
        '           </div>' +
        '        </div>';
    return stats;
}

/**
 * get funnel tag
 * @param el
 * @returns {string}
 */
function getFunnelTag(el){
    var loan_type_group = [];
    var sub_category_group = [];
    var new_arr = [];
    var tag = '';
    /*
    * Note: this code is use to separates the loan type and sub-category
    * First loan type then sub-category
    * */
    var tags_list = ( el['client_tag_name'])?el['client_tag_name'].split(','):'';
    for(i = 0; i < tags_list.length; i++) {
        if(tags_list[i]) {
            if(jQuery.inArray(tags_list[i], category) !='-1'){
                loan_type_group.push(tags_list[i]);
            }else {
                sub_category_group.push(tags_list[i]);
            }
        }
    }

    tags = loan_type_group.concat(sub_category_group);
    for(i = 0; i < tags.length; i++) {
        if(tags[i]) {
            tag += '<li><span>' + parseHTML(strReplaceOrg(tags[i])) + '</span></li>';
        }
    }
    return tag;
}

/**
 * get funnel leads graph
 * @param el
 * @param row
 */
function getLeadsGraph(ele){
  //  debugger;
    var arr = window.data;
    var keys =  ele.split('-');
    var index = keys[3];
    var client_leadpop_id = keys[1];
    var domain_id = keys[2];
    var selectedFunnel = arr[keys[3]];

    var days7DaysGraph = selectedFunnel.funnelStats7DaysGraph.day;
    var leads7DaysGraph = selectedFunnel.funnelStats7DaysGraph.leads;
    let checkLeads7DaysGraph = eval(leads7DaysGraph.join("+"));
    var stepSize7DaysGraph = selectedFunnel.funnelStats7DaysGraph.step_size;
    var max7DaysGraph = selectedFunnel.funnelStats7DaysGraph.max_step;
    console.log("max7DaysGraph " + max7DaysGraph, "stepSize7DaysGraph " + stepSize7DaysGraph);


    var days30DaysGraph = selectedFunnel.funnelStats30DaysGraph.day;
    var leads30DaysGraph = selectedFunnel.funnelStats30DaysGraph.leads;
    let checkLeads30DaysGraph = eval(leads30DaysGraph.join("+"));
    var stepSize30DaysGraph = selectedFunnel.funnelStats30DaysGraph.step_size;
    var max30DaysGraph = selectedFunnel.funnelStats30DaysGraph.max_step;

    var graphId = 'statsChart_' + client_leadpop_id + '_' + domain_id;

    if(checkLeads7DaysGraph) {
        generateGraph(graphId,days7DaysGraph,leads7DaysGraph, stepSize7DaysGraph, max7DaysGraph, SevenDayChartDays);
    }
    else{
        $(".funnels-details.open.active .leads-graph__holder .days-chart").html(graphEmpty());
    }

    if(checkLeads30DaysGraph) {
        generateGraph(graphId,days30DaysGraph,leads30DaysGraph, stepSize30DaysGraph, max30DaysGraph, thirtyDayChartDays);
    }
    else{
        $(".funnels-details.open.active .leads-graph__holder .month-chart").html(graphEmpty());
    }
}



/**
 * set leads stats font size with used fittext lib
 * @param el
 * @param row
 */
function fitTextLeads(ele){
    var arr = window.data;
    var keys =  ele.split('-');
    var index = keys[3];
    var client_leadpop_id = keys[1];
    var domain_id = keys[2];
    var selectedFunnel = arr[keys[3]];
    var defaultSize = 0.2;
    var stats = ['new_leads','total_leads','visits_sunday','visits_month','total_visits','conversion_rate'];
    for(var i = 0; i < stats.length; i++){
        if(selectedFunnel[stats[i]]){
            var string = String(selectedFunnel[stats[i]]);
            if (string.length > 3) {
                defaultSize = 0.5;
            }
        }
        jQuery("."+stats[i]).fitText(defaultSize);
    }
}


/**
 *load funnel data for top header search funnel after domain/subdomain and tags/folder insertion and updation for admin v3
 */
function loadFunnel(){
    $.ajax({
        type: "GET",
        url: site.baseUrl + "/lp/load-top-header-funnel",
        success: function (d) {
            window.rec = window.top_search_data = jQuery.parseJSON(d);
            topHeaderFunnelFilter();
        },
        error: function (response) {
        },
        cache : false,
        async : true
    });
}

/**
 * get date day
 * @param date
 * @returns {string}
 */
function getDay(date){
    var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var d = new Date(date);
    var a = new Date();
    var month = (a.getMonth() < 12)?a.getMonth()+1:a.getMonth();
    var db_month = (d.getMonth() < 12)?d.getMonth()+1:d.getMonth();
    var day = (a.getDate() < 10)?"0"+a.getDate():a.getDate();
    var db_day = (d.getDate() < 10)?"0"+d.getDate():d.getDate();
    var today = month + "/" + day+ "/" + a.getFullYear();
    var cur_date = db_month + "/" + db_day + "/" + d.getFullYear().toLocaleString().substr(-2);
    if(today == date){
        return 'Today|'+cur_date;
    }
    return weekday[d.getDay()]+'|'+cur_date;
}

/**
 * init tagsPopup
 */
function tagsPopup(){
    jQuery('.more-tags').click(function(){
        var _self = jQuery(this);
        if(!_self.parents('.funnels-details').find('.funnel-head').hasClass('tags-active'))
        {
            $('.dashboard-funnels').find('.funnel-head.tags-active .tags-popup-wrap').fadeOut(500);
        }
        $('.dashboard-funnels').find('.funnel-head').removeClass('tags-active');
        _self.parents('.funnels-details').find('.funnel-head .tags-popup-wrap').fadeToggle(500);
        _self.parents('.funnels-details').find('.funnel-head').toggleClass('tags-active');
        return false;
    });
    //if tags width size greater than 500 then extra tags list hide
    jQuery('.tags-holder-wrap').each(function(){
        var temp_width = 45;
        var index = 0;
        var room = 500;
        jQuery(this).find('li').each(function(){
            temp_width = temp_width + jQuery(this).outerWidth();
            if(temp_width < room){
                index++;
            }
        });
        jQuery(this).find('li:gt('+ (index-1) +')').hide();
        jQuery(this).parents('.tags-holder').find('.more').show();
        if(temp_width <= room){
            jQuery(this).parents('.tags-holder').find('.more').hide();
        }
    });
}

function topHeaderTagPopup(){
    jQuery('.more-tag').click(function(){
        var _self = jQuery(this);
        $('.megamenu-funnels .megamenu-funnels__box.tag-active').find('.tags-popup-wrap').css({'top':''});
        if(!_self.parents('.megamenu-funnels__box').hasClass('tag-active'))
        {
            $('.megamenu-funnels .megamenu-funnels__box.tag-active').find('.tags-popup-wrap').hide();
        }
        var popup = _self.parents('.megamenu-funnels__column').find('.tags-popup-wrap');
        $('.megamenu-funnels').find('.megamenu-funnels__box').removeClass('tag-active');
        popup.find(".tags-popup").removeClass('top-position');
        var tagsOffsetTop = _self.offset().top;
        var popupHeight = popup.outerHeight();
        var popupOffset = tagsOffsetTop - 75 - popupHeight;
        if(tagsOffsetTop  < 260){
            popupOffset = tagsOffsetTop-17;
            popup.find(".tags-popup").addClass('top-position');
        }
        popup.css('top', popupOffset + 'px').fadeToggle(500);
        _self.parents('.megamenu-funnels__box').toggleClass('tag-active');
    });

    //if tags width size greater than 500 then extra tags list hide
    jQuery('.tag-select-wrap').each(function(){
        var temp_width = 45;
        var index = 0;
        var room = 430;
        jQuery(this).find('li').show().each(function(){
            temp_width = temp_width + jQuery(this).outerWidth();
            if(temp_width < room){
                index++;
            }
        });
        jQuery(this).find('li:gt('+ (index-1) +')').hide();
        if(temp_width <= room){
            jQuery(this).parents('.tags-holder').find('.more').hide();
        }
    });
}

function tagAlignment(){
    if($('.funnels-block__title_tag').length > 0) {
        var reseizeWidth = $(window).width();
        var offset_mins = '';
        //resize window set the funnel tags length
        if(reseizeWidth >= 1200 && reseizeWidth < 1300){
            offset_mins = 18;
        }
        else if(reseizeWidth > 1300 && reseizeWidth < 1400){
            offset_mins = 17;
        }
        else if(reseizeWidth > 1400 && reseizeWidth < 1500){
            offset_mins = 19;
        }
        else if(reseizeWidth > 1500 && reseizeWidth <= 1700){
            offset_mins = 16;
        }
        else{
            offset_mins = 15;
        }
        if($(".funnels-details-wrap").length) {
            $(".funnels-details-wrap").css({'visibility': 'visible', 'height': 'auto'});
            var $offset = $('.funnels-block__title_tag').parent().offset().left;
            var $offset_inner_tags = $('.funnels-box-inner__tags').parents('.tags-wrap').offset().left;
            var extraSpace = $offset_inner_tags - $offset - offset_mins;
            $('.funnels-box-inner__tags').parents('.funnels-box__column').css({'margin-left': '-' + parseInt(extraSpace) + 'px'});
            $('.funnels-box-inner__name').css({'padding-right': parseInt(extraSpace - 10) + 'px'});
            $(".funnels-details-wrap").hide();
        }
    }
}

/**
 * mcsutomscrollbar init in show all tags popup
 */
function initScroll(){
    if($('.tags-popup').length > 0) {
        setTimeout(function () {
            $('.tags-popup').mCustomScrollbar({
                mouseWheel: {scrollAmount: 80}
            });
        },500);
    }
}

//conversion rate calculate
function conversionRate(ele){
    var excludeConversionRate = $("#conversionRate").is(":checked");
    var filter_ConversionRate = $("#filter_conversion_rate").val();
    var total_leads = 0;
    var total_visits = 0;
    if(filter_ConversionRate === undefined){
        filterConversionRate = filter_conversion_rate ;
        excludeConversionRate = exclude_ConversionRate;
    }
    else{
        filterConversionRate = filter_ConversionRate;
    }
    var k = 0;
    jQuery(data).each(function (i, el) {
        if((excludeConversionRate == "true" || excludeConversionRate == true ) && filterConversionRate != 0) {
            if (parseFloat(el.conversion_rate) < parseFloat(filterConversionRate)) {
                total_leads += new Number(el.total_leads);
                total_visits += new Number(el.total_visits);
            }
        }
        else{
            k++;
            total_leads += new Number(el.total_leads);
            total_visits += new Number(el.total_visits);
        }

    });
    conversion_rate = parseFloat(total_leads/total_visits*100);
    if(isNaN(conversion_rate)) {
        conversion_rate = 0;
    }
    $(".total-conversion-rate").text(conversion_rate.toFixed(2));
    $("#conversion-setting").modal('hide');
    if(ele == true) {
        tag_filter_session();
    }
}

/**
 * this function use during the render funnel
 * with filter. pagination, sorting
 */
function renderFunc(){
    lpUtilities.addclasshover();
    lpUtilities.globalTooltip();
    lpUtilities.copyToClipboard();
    tagsPopup();
    initScroll();
    tagAlignment();
}

function graphEmpty(){
    var imageURL = site.baseUrl+site.lpAssetsPath+'/theme_admin3/images';
    return '<div class="leads-graph__empty">\n' +
        '    <img src="'+imageURL+'/bar-icon.png">\n' +
        '    <p>\n' +
        '        There is nothing to display here yet. <br>\n' +
        '        Talk to leadPops to jumpstart your marketing today.\n' +
        '    </p>\n' +
        '    <a class="button button-primary leadpop-assessment" href="https://book-demo.leadpops.com" target="_blank">\n' +
        '        <span class="image-wrap"><img src="'+site.rackspaceDefaultImages+'/logo-micro-white.png" alt="leadpops" class="micro-logo normal-img">\n' +
        '        <img src="'+site.rackspaceDefaultImages+'/logo-micro-orange.png" alt="leadpops" class="micro-logo hover-img"></span>\n' +
        '        Schedule My 1:1 Digital Marketing Assessment\n' +
        '    </a>\n' +
        '</div>\n' +
        '<div class="leads-graph__empty d-none">\n' +
        '    <img src="'+imageURL+'/bar-icon.png">\n' +
        '    <p>\n' +
        '        There is nothing to display here yet. <br>\n' +
        '        Visit leadPops Academy and learn how to generate more leads.\n' +
        '    </p>\n' +
        '    <a class="button button-primary leadpop-academy" href="javascript:void();">\n' +
        '        <i class="ico ico-knowledge"></i>\n' +
        '        go to leadpops academy\n' +
        '    </a>\n' +
        '</div>';
}

function clearSearch(){
    jQuery(".clear-search").hide();
    jQuery(".funnel-url, .funnel-search").val('');
    _search();
}

/**
 * clone funnel create from ajax request
 */
function ajaxClonFunnel(){
    let postData = $("#ClonefunnelSubdomain").serializeArray();
    $.ajax({
        type: "POST",
        data: postData,
        url: $("#ClonefunnelSubdomain").attr('action'),
        success: function (response) {
            displayAlert("success", response.message);
            window.data = window.rec = jQuery.parseJSON(response.result);
            var cloneFoler = $("#clone_folder_list option:selected").data('value');
            $(".top-funnel-type-search").val(cloneFoler);
            let folder = $(".funnel-type-search").val(cloneFoler);
            if(cloneFoler == 'w'){
                $(".funnel-type-search option:selected").attr("data-count",1);
                $(".top-funnel-type-search option:selected").attr("data-count",1);
            }
            isClone = 1;
            folder.change();
        },
        cache : false,
        async : false
    });
}

function goToPage(){
    // debugger;
    let funnelName = $("#clone_funnel_name").val().toLowerCase();
    if(data) {
        let index = data.findIndex(funnel => strReplaceOrg(funnel.funnel_name.toLowerCase()) == funnelName);
        if (index != -1) {
            let page = Math.ceil(index / currentPerPage);
            page = (page)?page:1;
            $(`.za-page li[id='${page}'`).click();
            var funnelID = "row-" + data[index]['client_leadpop_id'] + '-' + data[index]['domain_id'] + "-" + index;
            if ($("#" + funnelID).length > 0) {
                $("#" + funnelID).toggleClass('open active');
                $("#" + funnelID + ' .funnels-details-wrap').stop().slideToggle();
                getLeadsGraph(funnelID);
                $("html, body").animate({scrollTop: jQuery("#" + funnelID).offset().top - 200});
            }
        }
    }
    else{
        console.log('funnel data is empty..');
    }
    $('#modal_SubdomainCloneFunnel').modal('hide');
    $("#mask").hide();
}

function topHeaderSrotingFunnel(){
    let sort  = $('.tag-sort.active').data('sort');
    top_search_data.sort(function(a, b) {
        a = a['funnel_name'].toLowerCase();
        b = b['funnel_name'].toLowerCase();
        if(sort == 'name-asc') {
            return a < b ? -1 : a > b ? 1 : 0;
        }else{
            return a > b ? -1 : a < b ? 1 : 0;
        }
    });
}

function generateGraph(Id, days, leads, stepSize, max, NumOfDays) {
  // debugger;

    var todayDate = new Date();
    var todayDay = getDay(todayDate).split('|')[0];

    var graphId = Id+"_"+NumOfDays;
    var requiredDays = days;
    let requiredLeads =  leads;
    let pointWidth = NumOfDays === thirtyDayChartDays? 10: 62;
    let fontSize = NumOfDays === thirtyDayChartDays? "14px": '14px';
    let type = NumOfDays === thirtyDayChartDays? 'area': 'column';
    let xAxisStep = NumOfDays === thirtyDayChartDays? 1: 0;
    let gridLineWidth = NumOfDays === thirtyDayChartDays? 0: 1;
    let enableCrosshairs = false;
    let fontWeight = '700';
    var plotOptions = {
        series: {
            pointWidth: pointWidth,
            borderColor: 'transparent',
            lineWidth: 2,
            lineColor: '#02abec'
        },
        column: {
            colorByPoint: true
        }
    };

    if(NumOfDays === thirtyDayChartDays){
        // add a dummy last index
        requiredDays.push("some date");
        requiredLeads.push(0);

        enableCrosshairs = {
            width: 1,
            color: '#000',
            dashStyle: 'dash'
        }

        plotOptions =  {
            series: {
                lineWidth: 2,
                color: '#02abec',
                fillColor: 'rgba(2, 171, 236, 0.25)',
                states: {
                    hover: {
                        enabled: true,
                        lineWidth: 3
                    }
                },
                marker: {
                    radius: 0,
                },
                pointPlacement: 'on',
            },
            areaspline: {
                fillOpacity: 0.5
            },
        }
    }
    if (document.getElementById(graphId)) {
        var chart = Highcharts.chart(graphId, {
            chart: {
                type: type,
            },
            title: {
                text: ' '
            },
            subtitle: {
                text: ' '
            },
            tooltip: {
                outside: true,
                borderRadius: 8,
                backgroundColor: '#02abec',
                borderWidth: 0,
                shadow: false,
                useHTML: true,
                style: {
                    color: '#ffffff',
                    "font-size": "12px",
                    "font-weight": "bold",
                    "box-shadow": "none"
                },
                formatter: function () {
                    var ele = getDay(this.x).split('|');
                    if(NumOfDays >= thirtyDayChartDays){
                        return '<div class="chart-tooltip-wrapper chart-tooltip-wrapper_dashboard">' +
                            '<span class="point-date">' + ele[0] + "  " + ele[1] + '</span>' +
                            '<span class="point-year">' + this.y + '</span>' +
                            '<div>';
                    } else {
                        return '<div class="chart-tooltip-wrapper chart-tooltip-wrapper_dashboard">' +
                            '<span class="point-date">' + ele[0] + '</span>' +
                            '<span class="point-year">' + this.y + '</span>' +
                            '<div>';
                    }
                },
            },
            credits: {
                enabled: false
            },
            xAxis: {
                gridLineWidth: gridLineWidth,
                categories: requiredDays,
                crosshair: enableCrosshairs,
                labels: {
                    style: {
                        color: '#85969f',
                        fontSize: fontSize,
                        fontWeight: fontWeight,
                        fontFamily: '"Open Sans", "Arial", "Helvetica Neue", "Helvetica", sans-serif',
                    },
                    step: xAxisStep,
                    formatter: function () {

                        var ele = getDay(this.value).split('|');
                        var day = '';
                        if (ele[0].toLowerCase() == 'today') {
                            day = ele[0];
                        } else {
                            day = ele[0].substr(0, 3);
                        }
                         var todayDayUpperCase = todayDay.substr(0, 3).toUpperCase();
                        if(NumOfDays >= thirtyDayChartDays){
                            if(day.toUpperCase() === todayDayUpperCase) {
                                return day.toUpperCase() + '<br> <div class="chart-date">' + ele[1] + '</div>'
                            } else {
                                return "";
                            }
                        } else {
                            return day.toUpperCase() + '<br> <div class="chart-date">' + ele[1] + '</div>'
                        }

                    },
                },
            },
            yAxis: {
                max: max,
                min:0,
                offset: 0,
                tickInterval: stepSize,
                title: {
                    text: ''
                },
                labels: {
                    style: {
                        color: '#85969f',
                        fontSize: '15px',
                        fontFamily: '"Open Sans", "Arial", "Helvetica Neue", "Helvetica", sans-serif',
                    }
                },

            },
            colors: [
                'rgba(192, 234, 250)',
                'rgba(192, 234, 250)',
                'rgba(192, 234, 250)',
                'rgba(192, 234, 250)',
                'rgba(192, 234, 250)',
                'rgba(192, 234, 250)',
                'rgba(192, 234, 250)',
                'rgba(39, 194, 76)'
            ],

            plotOptions: plotOptions,
            lineWidth: 5,
            series: [{
                data: requiredLeads,
                showInLegend: false
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 630
                    },
                    chartOptions: {
                        plotOptions: {
                            series: {
                                pointWidth: 20,
                            }
                        }
                    }
                }, {
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        plotOptions: {
                            series: {
                                pointWidth: 20,
                            }
                        }
                    }
                }]
            },
            exporting: {enabled: false},
        },function (chart) {
            if(NumOfDays >= thirtyDayChartDays) {
                $(".highcharts-markers").find('path').eq(0).remove();
                $(".highcharts-markers").find('path').last().remove();
                $.each(chart.series[0].data, function (i, point) {
                     if (i == 0 || i == requiredLeads.length - 1) {
                        point.visible = false;
                    }
                });
            }
        });
    }
}
