(function($){

    var Defaults = $.fn.select2.amd.require('select2/defaults');
    $.extend(Defaults.defaults, {
        dropdownPosition: 'auto'
    });
    var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');
    var _positionDropdown = AttachBody.prototype._positionDropdown;
    AttachBody.prototype._positionDropdown = function() {

        var $offsetParent = this.$dropdownParent;
        if($offsetParent.hasClass('za-dropdown')) {
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
            var left =  0;
           if( $(".select2-search--inline")[0].offsetLeft == 5){
               left = 1;
           }else{

               // $('.select2-selection__choice').each(function(index) {
               //     left += parseInt($(this)[0].offsetLeft);
               // });
           }
            $(".za-custom-select2").parent().css({
                top: $(".select2-search--inline")[0].offsetTop + $(".select2-search--inline")[0].offsetHeight + 14,
                left: $(".mk-dropdown_select2")[0].offsetLeft + $(".select2-search--inline")[0].offsetLeft -left
            });
        }
    };

    var rec = jQuery.parseJSON(funnel_json);
    window.rec = rec;
    window.data = rec;
    window.width;
    var url = [];
    var sticky_id = sticky_status = sticky_js_file = sticky_funnel_url = sticky_url = sticky_button = sticky_cta = sticky_bar = ft_slug = "";
    var pending_flag = 0;
    var funnel_sticky_status = '';
    var sticky_script_type = 'a';
    var sticky_page_path = '/';
    var sticky_website_flag = 0;
    var stickybar_number_flag = 0;
    var stickybar_number = '';
    var html = '';
    window.funnel_type = window.funnel_type_name = '';
    window.currentPage = (funnel_page)?funnel_page:$(".funnels-section_v2").data('page');
    window.is_lite_package =0;
    window.lite_funnels =[];
    if($("#is_lite_package").val() == '1'){
        window.is_lite_package =1;
        window.lite_funnels = $("#is_lite_funnels").val().split(',').map(function(itemFunnel) {
            return parseInt(itemFunnel, 10);
        });
    }
    if( window.is_lite_package  == 1){
        window.currentPerPage = (funnel_perPage)?funnel_perPage:$(".funnels-section_v2").data('perpage');
    }else{
        window.currentPerPage = (funnel_perPage)?funnel_perPage:$(".funnels-section_v2").data('perpage');
    }

    var container = $(".funnels-details");

    window.expand = true;
    var items = null;
    var litePackageItemsDisabled = null;
    var funnel_name = '';
    var disable_class = '';
    window.outsidewidth = 0;
    window.page_type = '';
    window.paginate;
    var category = [
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
    window.last_select_funnel_type_text = '';
    window. last_select_funnel_type_value = '';
    window.selected_tag_list = new Array();
    /**
     * this function use for load the funnel on the dashboard
     */
    $.fn.funnel_tag_loader = function () {
        var paginations = $(this);
        paginations.each(function (index, el) {
            var selector = $(this);
            items = [];
            litePackageItemsDisabled = [];
            if(data.length <= currentPerPage ){
                currentPage = 1;
            }
            if(data == null || data.length == 0){
                if(funnel_type == 'w' && ($(".funnel-search").val() || $(".tag-search").val()) == ""){
                    $("#modal_mortgageWebsiteFunnel").modal('show');
                    $('.tag-vertical-dropdown.funnel-type .verLabel .verText').text(last_select_funnel_type_text );
                    $(".funnels-section_v2 .section-title-wrapper .section-title").text(last_select_funnel_type_text);
                }else{
                    if($(".funnel-type option:selected").data('count') == 0){
                        $('.mk-record,.total-leads,.mk-record-no-found').hide();
                        $('.folder-empty').show();
                     }else{
                        $('.mk-record-no-found').show();
                        $('.mk-record,.total-leads,.folder-empty').hide();
                        }
                    tag_filter_session();
                }
            }else {
               var i = 0;
                $(data).each(function (index, el) {
                    i++;
                    var domain_name = el['domain_name'];
                    var tooltip = 'tooltip';
                    var disable_is_lite_class = count_disable_is_lite = cl = '';
                    width = 0;
                    if(window.is_lite_package == '1'){
                        if(window.lite_funnels.indexOf(el['leadpop_vertical_sub_id']) != -1 && el['leadpop_version_seq'] == 1){
                             disable_is_lite_class = '';
                             count_disable_is_lite = '';
                        }else{
                            disable_is_lite_class = 'disable_lite_package';
                            count_disable_is_lite = 'count_disable_is_lite';
                            tooltip = '';
                            domain_name = '';
                        }
                    }
                    var loan_type_group = [];
                    var sub_category_group = [];
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
                    if (el['sticky_url'] != '') {
                        url[el['sticky_url']] = el['sticky_funnel_url'];
                    }
                    if (el['leadpop_vertical_id'] == client_type) {
                        ft_slug = el["funnel_type"];
                    } else {
                        if (el["funnel_type"] == 'w')
                            ft_slug = "f modified_from_w";
                        else
                            ft_slug = el["funnel_type"];
                    }
                    if(el.funnel_name != "" && el.funnel_name != null){
                        if(el.funnel_name.length > 30) {
                            funnel_name = parseHTML(el.funnel_name).substr(0, 30) + '...';
                        }else{
                            funnel_name = parseHTML(el.funnel_name);
                        }
                    }else{
                        funnel_name = '';
                    }
                    if (el['sticky_id'] != '') {
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
                        if (sticky_updated) {
                            if (sticky_status == 0) {
                                funnel_sticky_status = '(Inactive)';
                            } else if (pending_flag == 0) {
                                funnel_sticky_status = '(Pending Installation)';
                            } else {
                                funnel_sticky_status = '(Active)';
                            }
                        }

                        sticky_page_path = el['sticky_url_pathname'];
                        sticky_website_flag = el['sticky_website_flag'];
                        html = '<li class="funnel-row tooltip-container za-question-tooltip' + count_disable_is_lite + '">'
                            + '<a class="f-expand za-f-expand ' + disable_is_lite_class + '">'
                            + '<div class="row">'
                            + '<div class="col-sm-4">'
                            + '<h3 class="funnel-text funnel-url lp-funnel-url label-tooltip" data-toggle="'+tooltip+'" data-placement="top" data-html="true"  title="' + domain_name + '">' + funnel_name + '</h3>';
                        html += '</div>'
                            + '<div class="col-sm-7 custom-tag-block">';
                        for(i = 0; i < loan_type_group.length; i++) {
                            if(loan_type_group[i]) {
                                html += '<div class="za-funnel-name">' + parseHTML(strReplaceOrg(loan_type_group[i])) + '</div>';
                            }
                        }
                        for(i = 0; i < sub_category_group.length; i++) {
                            if(sub_category_group[i]) {
                                html += '<div class="za-funnel-name">' + parseHTML(strReplaceOrg(sub_category_group[i])) + '</div>';
                            }
                        }
                        html +='</div>'
                            + '<div class="col-sm-1">'
                            + '<h3 class="funnel-text funnel-version za-leads text-right">' + el['total_leads'] + '</h3>'
                            + '</div>'
                            + '</div>'
                            + '</a>';
                        if(disable_is_lite_class == '') {
                            html += '<div class="f-detail">'
                                + '<div class="row">'
                                + '<div class="col-sm-12">'
                                + '<div class="edit-menu-wrapper">'
                                + '<div class="funnels-menu">'
                                + '<ul class="edit-menu home-menu">'
                                + '<li class="view"><a target="_blank" href="' + funnel_url + el['domain_name'] + '">View</a></li>'
                                + '<li class="edit drop-menu"><a class="funnel_manu_edit_link" href="#"><span>Edit</span> <span class="caret"></span></a>'
                                + '<ul class="drop-menu-down lp-version-2">';
                            if (el['leadpop_vertical_id'] == vertical_id) {
                                html += '<li class="sub-drop-down"><span>Content</span>'
                                    + '<ul class="sub-drop-menu-down">'
                                    + '<div class="sub-menu-wrapper">'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/seo/' + el['hash'] + '">SEO</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/thankyou/' + el['hash'] + '">Thank You</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/autoresponder/' + el['hash'] + '">Autoresponder</a></li>'
                                    + '</div>'
                                    + '</ul>'
                                    + '</li>';
                            } else {
                                html += '<li class="sub-drop-down"><span>Content</span>'
                                    + '<ul class="sub-drop-menu-down">'
                                    + '<div class="sub-menu-wrapper">'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/calltoaction/' + el['hash'] + '">Call-to-Action</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/footeroption/' + el['hash'] + '">Footer</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/autoresponder/' + el['hash'] + '">Autoresponder</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/seo/' + el['hash'] + '">SEO</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/contact/' + el['hash'] + '">Contact Info</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/thankyou/' + el['hash'] + '">Thank You</a></li>'
                                    + '</div>'
                                    + '</ul>'
                                    + '</li>'
                                    + '<li class="sub-drop-down"><span>Design</span>'
                                    + '<ul class="sub-drop-menu-down">'
                                    + '<div class="sub-menu-wrapper">'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/logo/' + el['hash'] + '">Logo</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/background/' + el['hash'] + '">Background</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/featuredmedia/' + el['hash'] + '">Featured Image</a></li>'
                                    + '</div>'
                                    + '</ul>'
                                    + '</li>'
                                    + '<li class="sub-drop-down"><span>Settings</span>'
                                    + '<ul class="sub-drop-menu-down">'
                                    + '<div class="sub-menu-wrapper">';
                                    if(tag_folder_enable == 1){
                                        html += '<li><a href="' + site.baseUrl + site.lpPath + '/tag/' + el['hash'] + '">Name & Tags</a></li>'
                                    }
                                    html += '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/domain/' + el['hash'] + '">Domains</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/pixels/' + el['hash'] + '">Pixels</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/integration/' + el['hash'] + '">Integrations</a></li>'
                                    + '<li><a href="' + site.baseUrl + site.lpPath + '/popadmin/adaaccessibility/' + el['hash'] + '">ADA Accessibility</a></li>'
                                    + '</div>'
                                    + '</ul>'
                                    + '</li>';
                                if (stickybar_flag === null || stickybar_flag == 1) {
                                    html += '<li class="sub-drop-down"><span>Promote</span>'
                                        + '<ul class="sub-drop-menu-down">'
                                        + '<div class="sub-menu-wrapper">'
                                        + '<li>'
                                        + '<a href="#" id="sticky-bar-btn' + index + '" class="sticky-bar-btn_v2" data-index="' + index + '"\
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
                                data-sticky_phone_number_checked = "' + stickybar_number_flag + '">\
                                Sticky Bar\
                                <span class="funnel-sticky-status">' + funnel_sticky_status + '</span>\
                                </div>'
                                        + '</a></li>'
                                        + '</ul>'
                                        + '</li>';

                                }

                            }
                            html += '</ul>'
                                + '</li>'
                                + '<li class="alerts"><a href="' + site.baseUrl + site.lpPath + '/account/contacts/' + el['hash'] + '">Lead Alerts</a></li>'
                                + '<li class="stats"><a href="#" class="statsPopupCta" data-hash="' + el['hash'] + '">Stats</a></li>'
                                + '<li class="my-leads"><a href="' + site.baseUrl + site.lpPath + '/myleads/index/' + el['hash'] + '">My Leads</a></li>'
                                + '<li class="status status-icon"><a class="funnelStatusBtn funnelstatus_' + el['domain_id'] + '" href="#" data-status="' + el['leadpop_active'] + '" data-leadpop_version_seq="' + el['leadpop_version_seq'] + '" data-domain_id="' + el['domain_id'] + '" data-leadpop_id="' + el['leadpop_id'] + '" data-leadpop_version_id="' + el['leadpop_version_id'] + '">Status</a></li>';
                            var clone_lite_package='';
                            if(window.is_lite_package == 1){
                                clone_lite_package='disable_lite_package';
                            }
                            if (clone_flag == 'y' && el['leadpop_vertical_id'] != vertical_id) {
                                html += '<li class="clone"><a href="#" data-ctalink="' + site.baseUrl + site.lpPath + '/index/clonefunnel/' + el['hash'] + '" data-subdomain="' + el['subdomain_name'] + '" data-top-domain="' + el['top_level_domain'] + '" class="cloneFunnelSubdomainBtn ' + clone_lite_package + '">Clone</a></li>';
                            } else if (clone_flag == 'n' && el['leadpop_vertical_id'] != vertical_id) {
                                html += '<li class="clone"><a href="#" class="cloneFunnelReqBtn">Clone</a></li>';
                            }
                            if (clone_flag == 'y' && el['leadpop_version_seq'] > 1) {
                                html += '<li class="right-btns"><a href="#" data-ctalink="' + site.baseUrl + site.lpPath + '/index/deletefunnel/' + el['hash'] + '" class="funnel-btn delete-btn deleteFunnelBtn">Delete</a></li>';
                            }
                            html += '<div class="clearfix"></div>'
                                + '</ul>'
                                + '</div>'
                                + '</div>'
                                + '</div>'
                                + '</div>'
                                + '<div class="row seven-cols">'
                                + '<div class="lead-wrapper">'
                                + '<div class="col-sm-1">'
                                + '<div class="leadbox">'
                                + '<span class="lead-title">New<span class="nl">Leads</span></span>'
                                + '<span class="count">';
                            html += (el['new_leads']) ? el['new_leads'] : '-' + '</span>';
                            html += '</div>'
                                + '</div>'
                                + '<div class="col-sm-1">'
                                + '<div class="leadbox">'
                                + '<span class="lead-title">Total<span class="nl">Leads</span></span>'
                                + '<span class="count">';
                            html += (el['total_leads']) ? el['total_leads'] : '-' + '</span>';
                            html += '</div>'
                                + '</div>'
                                + '<div class="col-sm-1">'
                                + '<div class="leadbox">'
                                + '<span class="lead-title">Visitors Since<span class="nl">Sunday</span></span>'
                                + '<span class="count">';
                            html += (el['visits_sunday']) ? el['visits_sunday'] : '-' + '</span>';
                            html += '</div>'
                                + '</div>'
                                + '<div class="col-sm-1">'
                                + '<div class="leadbox">'
                                + '<span class="lead-title">Visitors This<span class="nl">Month</span></span>'
                                + '<span class="count">';
                            html += (el['visits_month']) ? el['visits_month'] : '-' + '</span>';
                            html += '</div>'
                                + '</div>'
                                + '<div class="col-sm-1">'
                                + '<div class="leadbox">'
                                + '<span class="lead-title">Total<span class="nl">Visitors</span></span>'
                                + '<span class="count">';
                            html += (el['total_visits']) ? el['total_visits'] : '-' + '</span>';
                            html += '</div>'
                                + '</div>'
                                + '<div class="col-sm-1">'
                                + '<div class="leadbox last">'
                                + '<span class="lead-title">Conversion<span class="nl">Rate</span></span>'
                                + '<span class="count">';
                            html += (el['conversion_rate']) ? el['conversion_rate'] + '%' : '-' + '</span>'
                                + '</div>'
                                + '</div>'
                                + '<div class="clearfix"></div>'
                                + '</div>'
                                + '</div>'
                                + '</div>';
                        }

                        html +='</li>';
                        if(disable_is_lite_class==''){
                            litePackageItemsDisabled.push(html);
                        }
                        items.push(html);
                        $(".remove_tag_list").remove();
                    }

                });
                paginate.totalPages = Math.ceil(items.length / currentPerPage);
                paginate.show();
            }
            $(this).off('click').on('click', '.za-page li', function (e) {
                e.preventDefault();
                // get items page from active button
                if(!$(this).hasClass('active')) {
                    paginate.totalPages = Math.ceil(items.length / currentPerPage);
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

            $(this).on('click', '.page-btn', function (e) {
                e.preventDefault();
                if(!$(this).hasClass('disabled')) {
                    page_type = $(this).data('page-type');
                    paginate.animationPagination();
                }

            });
            $(this).on('click', '.funnel-url-list .disable_lite_package', function (e) {
                e.preventDefault();
                showLitePackageDisableAlert();
                return false;

            });
            $(this).on('click', '.funnel-row .disable_lite_package', function (e) {
                e.preventDefault();
                showLitePackageDisableAlert();
                return false;

            });
            $(this).on('click', '.funnel_manu_edit_link', function (e) {
                e.preventDefault();
            });
            $(this).on('click', '.pagingControls_mk li', function (e) {
                e.preventDefault();
                // get current page from active button
                if(!$(this).hasClass('active') && !$(this).hasClass('disabled')) {
                    currentPerPage = parseInt($(this).text(), 10),
                        target = $(e.target);

                    // get numbered page
                    currentPerPage = parseInt(target.text(), 10);
                    paginate.totalPages = Math.ceil(items.length / currentPerPage);
                    // ensure newPage is in available range
                    currentPage = 1;
                    paginate.show();
                    tag_filter_session();
                }
            });

            $(this).on('click','li[data-slug]', function(e) {
                e.preventDefault();
                $(this).closest('.qa-list').find('li').removeClass('hide-sort');
                $(this).addClass('hide-sort');
                var _dropdown = $(this).closest('.qa-dropdown');
                window._dropdown = _dropdown;
                _dropdown.find('.qaText').text($(this).text().trim());
                _dropdown.attr('data-value',$(this).data('value'));
                sorting();
                tag_filter_session();
            });

            $(this).on('click','.f-expand', function(e) {
                e.preventDefault();
                var _funnel = $(this);
                if (_funnel.hasClass('opened')) {
                    _funnel.next().hide();
                    _funnel.removeClass('opened');
                } else {
                    _funnel.next().show();
                    _funnel.addClass('opened');
                };
            });

            //Binding Event to Clone Funnel
            $(this).on('click','.cloneFunnelBtn', function(e) {
                e.preventDefault();

                Funnel.cloneFunnelCta($(this))
            });

            //Binding Event to Clone Funnel With Custom Sub Domain
            $(this).on("click",".cloneFunnelSubdomainBtn",function (e) {
                e.preventDefault();
                if($(this).hasClass("disable_lite_package")) {
                    showLitePackageDisableAlert();
                    return false;
                }
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

            $(this).on('click','.sticky-bar-btn_v2', function(e) {
                e.stopPropagation();
                var _this = $(this);
                showstickybarpopup(_this);
            });

            $(document).mouseup(function (e) {
                var container = selector.find(".drop-menu");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.removeClass('open');
                }
            });

            $(this).on('click','.tag-setting', function (e){
                e.stopPropagation();
                $(".za-funnel-name").toggle();
                icon = $(this).find("i");
                icon.toggleClass("fa-eye fa-eye-slash");
            });

        });
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
                listItems.push(this.buildItem('prev', prev,'<div class="pagingControls_mk prev page-btn '+this.disabledClass+'"></div>'));
            }

            return listItems;
        },
        next_btn: function (pages){

            var listItems = [];

            if (this.next) {
                var next = pages.currentPage < this.totalPages ? pages.currentPage + 1 : this.totalPages;
                listItems.push(this.buildItem('next', next,'<div class="pagingControls_mk next page-btn '+this.disabledClass+'"></div>'));
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
            var li = items.slice(startPos, items.length);
            for (var i=0; i < currentPerPage; i++) {
                page.push(li[i]);
            }
            return page;
        },

        render: function() {
            var _this = this;
            // create buttons to manipulate current page
            var main = $('<div class="col-md-3 text-right" />');
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
            slide.append(pagination);
            $('.pagination-section').append(this.PerPageList()).append(main.append(prev).append(slide).append(next));
            if(this.totalPages > this.visiblePages){
                $(".next").removeClass(_this.disabledClass).addClass('active');
            }
        },

        PerPageList: function() {
            // create buttons to manipulate current per page
            var page_btn = [10,25,50,100];
            var pagination_right = $('<div class="col-md-9 text-left" />');

            pagination_right.append('<span class="lp-pagination-label">Funnels Per Page</span>');

            var right_side = $('<div class="col-md-6"/>');

            var pagination = $('<ul class="pagingControls pagingControls_mk" />');

            // add pages inbetween
            // truncate list when too large.
            for (var i=0; i < page_btn.length; i++) {

                if(items.length > page_btn[0] && items.length <= page_btn[1] && (i == 0 || i == 1 )){
                    disable_class = "";
                }else if(items.length > page_btn[1]  && items.length <= page_btn[2] && (i == 0 || i == 1 || i == 2 )){
                    disable_class = "";
                }else if(items.length > page_btn[2]){
                    disable_class = "";
                }else{
                    disable_class  = "disabled";
                }
                // markup for page button
                var pageBtn = $('<li class="'+disable_class+'" ></li>');

                // add active class for current page
                if (page_btn[i]  == currentPerPage) {
                    pageBtn.addClass('active');
                    pageBtn.text(page_btn[i]);
                } else {
                    pageBtn.append('<a href="#">' + page_btn[i] + '</a>');
                }
                pagination_right.append(pagination.append(pageBtn));
            }
            pagination_right.append(pagination_right);
            return pagination_right;
        },

        show: function () {
            var paging_control = container.find('.pagingControls'),
                page = this.getItem();
            $(".pagination-section").empty();
            container.find('.funnels-list > ul').empty();
            if (this.window === undefined) {
                $('.mk-record-no-found').hide();
                $('.mk-record,.total-leads').show();
                container.find('.funnels-list > ul').append(page);
            }
            this.render();
            if(window.is_lite_package == 1){
                container.find('.funnels-header .funnels-header-title span').text(litePackageItemsDisabled.length);
            }else{
                container.find('.funnels-header .funnels-header-title span').text(items.length);
            }

            if($(".tag-setting i").hasClass('fa-eye-slash')){
                var cl = 'none';
            }else{
                var cl = 'inline-block';
            }
            //container.find('.za-funnel-name').css('display',cl);

            this.applystyle();
            $('[data-toggle="tooltip"]').tooltip();
        },

        applystyle: function(){
            display = this.visiblePages;
            insidewidth = 0;

            $(".za-page").find('li').each(function(i,n){
                if(i == 0){
                    outsidewidth = (this.offsetWidth*display);
                }
                insidewidth += this.offsetWidth;
            });
            if($(".za-page").find('li').length <= 5){
                outsidewidth = $(".za-page").find('li').length*$(".za-page").find('li').width();
            }
            $(".za-page").css({'width': insidewidth});
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
    $( ".funnel-search" ).keydown(function() {
        keypresstimeout = 0;
        if(is_refreah == 0){
            clearTimeout(setTimeout_function);
        }
    });
    $( ".funnel-search" ).keyup(function() {
        if(is_refreah == 0) {
            clearTimeout(setTimeout_function);
        }
        is_refreah = 0;
        setTimeout_function = setTimeout(function(){
            if(keypresstimeout == 0){
                $(".search-top").trigger('click');
                keypresstimeout = 1;
            }
        }, 500);
    });
    /**
     * dashboard tag list
     */
    var dropdown = $(".tag-search").select2({
        placeholder: 'Type in Funnel Tag(s)...',
        dropdownParent: $(".tag-option"),
        templateResult: function (data, container) {
            if (data.element) {
                $(container).addClass('tag-list');
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
        $(".select2-dropdown").addClass('za-custom-select2');
        $('.search-tag-box .select2-search__field').attr('placeholder','');
        $('.select2-results__options').niceScroll({
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

    });
    dropdown.on("select2:close", function () {
        $('.search-tag-box .select2-search__field').attr('placeholder','Type in Funnel Tag(s)...');
    });
    dropdown.on('select2:unselect', function (e) {
       _search();
    });
    /**
     * dashboard folder list
     */
    var folder_drop_down = $(".folder-drop-down").select2({
        dropdownParent: $(".za-dropdown"),
        dropdownPosition: 'below',
        templateResult: function (data, container) {
            if (data.element) {
                $(container).addClass('za-folder-list');
            }
            var $result = $("<span></span>");

            $result.text(data.text);
            return $result;
        },
    });
    folder_drop_down.on("select2:open", function () {
        var _left = '';
        $(".select2-dropdown").addClass('za-folder-custom');
        folder_drop_down_height();
    });

    $(document).on('click','.sort-by',function (e){
        $('.sort-by').removeClass('active').addClass('inactive');
        $(this).addClass('active').removeClass('inactive');
        sorting();
        tag_filter_session();
    });
    /* Vertical Dropdown Trigger */
    $(".tag-vertical-dropdown .dropdown-list li.selectable").click(function() {
           last_select_funnel_type_text = $('.tag-vertical-dropdown.funnel-type .verLabel .verText').text();
           last_select_funnel_type_value = $('.tag-vertical-dropdown.funnel-type').attr('data-value');
        var _dropdown = $(this).closest('.tag-vertical-dropdown');
        _dropdown.attr('data-value',$(this).data('value'));
        _dropdown.find('.verText').text($(this).text().trim());
        if($(this).closest('.za-tag-type').length == 0)
        {
            $(".funnel-search,.tag-search").val('');
            $(".select2-selection__choice").remove();
            $('.search-tag-box .select2-search__field').attr('placeholder','Type in Funnel Tag(s)...');
        }

        if($(this).closest('.funnel-type').length == 1){
            currentPage = 1;
            $(".funnels-section_v2 .section-title-wrapper .section-title").text($(this).text().trim());
        }
        if($(this).closest('.funnel-filter').length == 1){
            if($(".funnel-filter").attr('data-value') == 1){
                $(".funnel-option").show();
                $(".tag-option").hide();
                $('.bottom-bar_v2').removeClass('bottom-bar_wrap');
                $(".za-dropdown .select2-container").css('width','271');
            }else{
                $('.bottom-bar_v2').addClass('bottom-bar_wrap');
                $(".funnel-option").hide();
                $(".tag-option").css('display','inline-block');
            }
        }
        _search();

    });
    $('.funnel-search').keypress(function(event){
        if(event.keyCode == 13){
            _search();
        }
    });
    $(".search-tag-box .search-icon").click(function (){
        _search();
    });
    $(document).on('click','.select2-search__field',function (){
               $(".select2-search.select2-search--inline").css('border-radius','3px 3px 0 0');
                $(".za-custom-select2").show();
        });
    $('.funnels-details').funnel_tag_loader();
    if(tag_folder_enable == 1) {
            //$(".funnel-type").trigger('change');
            last_select_funnel_type_text = $(".funnel-type option:selected").text();
            last_select_funnel_type_value = $(".funnel-type option:selected").data('value');
        $(".funnel-type").on('change', function () {
            if($(this) .val() != 'w'){
                last_select_funnel_type_text = $(".funnel-type option:selected").text();
                last_select_funnel_type_value = $(".funnel-type option:selected").data('value');
            }
            $(".funnel-search,.tag-search").val('');
            $(".select2-selection__choice").remove();
            $('.search-tag-box .select2-search__field').attr('placeholder','Type in Funnel Tag(s)...');
            $(".funnels-section_v2 .section-title-wrapper .section-title").text($(".funnel-type option:selected").text());
            _search();
        });
    }
    $(document).on('click','#website_funnel_modal_hide',function (e){
        if(tag_folder_enable == 1) {
            $(".funnels-section_v2 .section-title-wrapper .section-title,.za-dropdown .select2-selection__rendered").text(last_select_funnel_type_text);
            $(".funnel-type").val(last_select_funnel_type_value);
        }
        $('.tag-vertical-dropdown.funnel-type').attr('data-value',last_select_funnel_type_value);
        $("#modal_mortgageWebsiteFunnel").modal('hide');
        $(".modal-backdrop").remove();
        _search();
    });
    if(data != null) {
        _search(true);
    }
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

/**
 * this function are using global in the file. whenever, change the filter value then will call it.
 * @param is_click
 * @private
 */
function _search(is_click){
    if(is_click === undefined){
        is_click = false;
    }
    funnel_filter();
    leadCount();
    sorting();
    if(currentPage > 5) {
        paginate.animationPagination();
    }
    if(is_click == false) {
        tag_filter_session();
    }

}

/**
 * this function are using for dashboard filter
 */
function funnel_filter(){

    var data = [];
    var search = ($('.funnel-search').val())?$.trim($('.funnel-search').val().toLowerCase()):'';
    var tag_search = $(".tag-search").val();
    var w = '';
    if(tag_folder_enable == 1) {
        funnel_type = $(".funnel-type").val();
        funnel_type_name = $(".funnel-type option:selected").text();
        var webiste_val = $(".funnel-type option:selected").data('value');
    }else {
        /**
         * this is for old folder list
         */
        funnel_type = $(".funnel-type").attr('data-value');
        funnel_type_name = $(".funnel-type .verText").text().trim();
    }
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
         *if funnel type == 0 and tag search is not empty
         * then funnel will be show into all funnel with search tag name
         */
        else if(tag_search != ""){
            data = jQuery.grep(rec, function (el, i) {
                if(el.client_tag_name) {
                    var t = el.client_tag_name.split(',');
                    if (containsAll(tag_search, t)) {
                        return el;
                    } else if (containsAll(tag_search, t)) {
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
    else if ((search == "" && tag_search == "") && parseInt(funnel_type)) {
        data = jQuery.grep(rec, function (el, i) {
            if(tag_folder_enable == 1){
                return parseInt(el.leadpop_folder_id) == parseInt(funnel_type);
            }else{
                return parseInt(el.leadpop_vertical_id) == parseInt(funnel_type) && el.funnel_market == 'f';
            }
        });
    }
    /**
     *tag search and funnel name search is empty and funnel_type == website funnel
     * then funnel will be website funnel show
     */
    else if ((search == "" && tag_search == "") && funnel_type == 'w') {
        data = jQuery.grep(rec, function (el, i) {
            return (tag_folder_enable == 1)?(el.leadpop_folder_id == webiste_val) : el.funnel_type == funnel_type;
        });
    }
    /**
     *funnel name search is not empty and  search type == Search by Funnel Name
     * then matching funnel will be show with selected funnel name
     *
     */
    else if(search != "" &&  $(".funnel-filter").attr('data-value') == 1){
        /**
         *if funnel type is not website funnel
         *
         */
        if (parseInt(funnel_type)) {
            data = jQuery.grep(rec, function (el, i) {
                if(el.funnel_name) {
                    if(tag_folder_enable == 1){
                        return parseInt(el.leadpop_folder_id) == parseInt(funnel_type) && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                    }else{
                        return parseInt( el.leadpop_vertical_id) == parseInt(funnel_type) && el.funnel_market == 'f' && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                    }
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
                    if(tag_folder_enable == 1){
                        return (parseInt(el.leadpop_folder_id) == parseInt(webiste_val)) && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                    }else{
                        return el.funnel_type == funnel_type && strReplaceOrg(el.funnel_name).toLowerCase().indexOf(search) != -1;
                    }
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
                        if(tag_folder_enable == 1){
                            return parseInt(el.leadpop_folder_id) == parseInt(funnel_type);
                        }else{
                            return parseInt(el.leadpop_vertical_id) ==  parseInt(funnel_type) && el.funnel_market == 'f';
                        }

                    } else if (containsAll(tag_search, t)) {

                        if(tag_folder_enable == 1){
                            return parseInt(el.leadpop_folder_id) == parseInt(funnel_type);
                        }else{
                            return parseInt(el.leadpop_vertical_id) ==  parseInt(funnel_type) && el.funnel_market == 'f';
                        }
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
                        return (tag_folder_enable == 1)?(el.leadpop_folder_id == webiste_val) : el.funnel_type == funnel_type;
                    } else if (containsAll(tag_search, t)) {
                        return (tag_folder_enable == 1)?(el.leadpop_folder_id == webiste_val) : el.funnel_type == funnel_type;
                    }
                }
            });
        }
    }
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
         * Has ANY of these tags
         */
        if ($(".za-tag-type").attr("data-value") == 2) {
            for (var i = 0, len = needles.length; i < len; i++) {
                if ($.inArray(needles[i], strReplaceOrg(haystack)) == -1) return false;
            }
            return true;
        }
        /**
         * Has ALL of these tags
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
    var count = 0;
    $(data).each(function (i,v){
        count += parseInt(v.total_leads);
    });
    $('.total-leads span').text(count);
}
// function mousehover(ele,c){
//         if (c == 1) {
//             $(ele).find(".row > div:nth-child(1)").removeClass('col-sm-4').addClass('col-sm-11');
//             $(ele).find(".row > div:nth-child(2)").hide();
//         } else {
//             $(ele).find(".row > div:nth-child(1)").removeClass('col-sm-11').addClass('col-sm-4');
//             $(ele).find(".row > div:nth-child(2)").show();
//     }
// }

function sorting(){
    var sort = $('.sort-by.active').data('sort');
    /**
     * sort by created date
     */
    if($(".qa-dropdown").attr('data-value') == 1){
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
    else if($(".qa-dropdown").attr('data-value') == 2){
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
    else if($(".qa-dropdown").attr('data-value') == 3){
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
    else if($(".qa-dropdown").attr('data-value') == 4){
        data.sort(function(a, b) {
            a = new Date(a.last_edit);
            b = new Date(b.last_edit);
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
    else if($(".qa-dropdown").attr('data-value') == 5){
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
    else if($(".qa-dropdown").attr('data-value') == 6){
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
    else if($(".qa-dropdown").attr('data-value') == 7){
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
    else if($(".qa-dropdown").attr('data-value') == 8){
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
    else if($(".qa-dropdown").attr('data-value') == 9){
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
    $('.funnels-details').funnel_tag_loader();
}

/**
 *selected filter option save in session
 */
function tag_filter_session(){

    if($(".funnel-filter").attr('data-value') != undefined) {
        if(tag_folder_enable == 1){
            funnel_type = $(".funnel-type").val();
            funnel_type_name = $(".funnel-type option:selected").text();
        }else{
            /**
             * this is for old folder list
             */
            funnel_type = $(".funnel-type").attr('data-value');
            funnel_type_name = $(".funnel-type .verText").text().trim();
        }
        var sorting_filters = 'sort=' + $(".qa-dropdown").attr('data-value') + '&sort_name=' + $(".qa-dropdown .sort .qaText").text().trim() + '&order=' + $('.sort-by.active').data('sort');
        var current_selected_data = 'funnel=' + funnel_type + '&funnel_type_name=' + encodeURIComponent(strReplace(funnel_type_name))
            + '&search_type=' + $(".funnel-filter").attr('data-value')
            + '&search_type_name=' + $(".funnel-filter .verText").text().trim()
            + '&tag_type=' + $(".za-tag-type").attr("data-value")
            + '&tag_type_name=' + $(".za-tag-type .verText").text().trim()
            + '&tag=' + strReplace($(".tag-search").val())
            + '&funnel_search=' + encodeURIComponent(strReplace($('.funnel-search').val()))
            + '&perPage=' + currentPerPage + '&page=' + currentPage;

        if(getCookie('tag') == 1){
            if(data != '' && data[0].client_id) {
                document.cookie = 'folder_filter_' + data[0].client_id + '=' + current_selected_data + '&' + sorting_filters;
            }
            }else{
            $.ajax({
                type: "POST",
                data: current_selected_data + "&" + sorting_filters + '&_token=' + ajax_token,
                url: site.baseUrl + "/lp/tagfiltersession",
                success: function (d) {

                },
                error: function (response) {
                }
            });
        }
    }
}
function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

//set height of folder drop down till 4 options  otherwise use the default height
function folder_drop_down_height(){
    var len = $(".folder-drop-down option").length-1;
    var _width;
    if(len <= 4)
    {
        var height = (len == 1)?60:len*50;
        $(".select2-dropdown").css({height: height});
    }else {
        if($(".bottom-bar .bottom-bar_wrap").length == 1){
            _width = 180;
        }else{
            _width = 250;
        }
        $(".za-folder-custom .select2-results__options").css({width:_width});
        $('.za-folder-custom .select2-results__options').niceScroll({
            background :"#009edb",
            cursorcolor:"#ffffff",
            cursorwidth: "7px",
            autohidemode:false,
            railalign:"right",
            railvalign:"bottom",
            railpadding: { top: 0, right: 0, left: -16, bottom: 0 }, // set padding for rail bar
            cursorborder: "1px solid #fff",
            cursorborderradius:"5px"
        });
    }
}
