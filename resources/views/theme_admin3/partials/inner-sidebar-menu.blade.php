@php
    use App\Constants\LP_Constants;
    $funnel_data = LP_Helper::getInstance()->getFunnelData();
    $funnel = @$funnel_data['funnel'];
    $sticky_id = $sticky_status = $sticky_js_file = $sticky_funnel_url = $sticky_url = $sticky_button = $sticky_cta = $sticky_bar = "";
    $pending_flag = 0;
    $funnel_sticky_status = '';
    $sticky_script_type = 'a';
    $sticky_page_path = '/';
    $sticky_website_flag = 1;
    if(!empty($funnel['sticky_id'])){
        $sticky_bar = 'sticky-bar-inactive';
        if($funnel['sticky_status'] != 0){
            $sticky_bar = 'sticky-bar-active';
        }
        $sticky_id = $funnel['sticky_id'];
        $sticky_cta = $funnel['sticky_cta'];
        $sticky_button = $funnel['sticky_button'];
        $sticky_url = $funnel['sticky_url'];
        $sticky_funnel_url = $funnel['sticky_funnel_url'];
        $sticky_js_file = $funnel['sticky_js_file'];
        $sticky_status = $funnel['sticky_status'];
        $pending_flag = $funnel['pending_flag'];
        $show_cta = $funnel['show_cta'];
        $sticky_size = $funnel['sticky_size'];

        $sticky_updated = $funnel['sticky_updated'];
        $sticky_script_type = $funnel['sticky_script_type'];

        $sticky_zindex = $funnel['zindex'];
        $sticky_zindex_type = $funnel['zindex_type'];

        if($sticky_updated){
            if($sticky_status==0){
                $funnel_sticky_status = '(Inactive)';
            }else if($pending_flag == 0){
                $funnel_sticky_status = '(Pending Installation)';
            }else{
                $funnel_sticky_status = '(Active)';
            }
        }

        $sticky_page_path = $funnel['sticky_url_pathname'];
        $sticky_website_flag = $funnel['sticky_website_flag'];
    }


    $stickbar_link = ' data-funnel_hash="'. $funnel['hash'] .'" data-field="'.$funnel['domain_name'].'" data-id="'.$funnel['client_leadpop_id'].'" data-element_id = "sticky-bar-btn-menu" data-sticky_id = "'.@$sticky_id.'" data-sticky_cta = "'.@$sticky_cta.'"data-sticky_button = "'.@$sticky_button.'"data-sticky_url = "'.@$sticky_url.'"
                               data-sticky_funnel_url = "'.@$sticky_funnel_url.'" data-sticky_js_file = "'.@$sticky_js_file.'" data-sticky_status = "'.@$sticky_status.'" data-sticky_show_cta = "'.@$show_cta.'"  data-sticky_size = "'.@$sticky_size.'" data-pending_flag = "'.@$pending_flag.'" data-v_sticky_button = "'.str_replace('###','\'' , $funnel['v_sticky_button'] ).'" data-v_sticky_cta = "'.str_replace('###','\'' , $funnel['v_sticky_cta'] ).'" data-sticky_page_path = "'.@$sticky_page_path.'" data-sticky_website_flag = "'.@$sticky_website_flag.'" data-sticky_location = "'.$funnel['sticky_location'].'" data-sticky_script_type = "'.@$sticky_script_type.'" data-sticky_zindex = "'.@$sticky_zindex.'" data-sticky_zindex_type = "'.@$sticky_zindex_type.'"';
    $subdomain_name = $funnel['subdomain_name'];
    $top_level_domain = $funnel['top_level_domain'];
     if (LP_Helper::getInstance()->getCloneFlag()  == 'y' && $funnel['leadpop_version_seq'] > 1) {
        $del = 'y';
    }else{
        $del = 'n';
    }

    $status_link = 'data-status="'.$funnel['leadpop_active'].'" data-leadpop_version_seq="'.$funnel['leadpop_version_seq'].'" data-domain_id="'.$funnel['domain_id'].'" data-leadpop_id="'.$funnel['leadpop_id'].'" data-leadpop_version_id="'.$funnel['leadpop_version_id'].'" data-funnel-name="'.$funnel['funnel_name'].'" data-delete="'.$del.'"  data-link="'.LP_BASE_URL.LP_PATH.'/index/deletefunnel/'.$funnel['hash'].'" class="funnelStatusBtn funnelstatus_'.$funnel['domain_id'].' menu__dropdown-link" title="Status"';
     if($funnel['leadpop_vertical_id'] != App\Constants\LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES ){
    $clone_link = 'data-ctalink="'.LP_BASE_URL.LP_PATH.'/index/clonefunnel/'.$funnel['hash'].'" data-subdomain="'.$subdomain_name.'" data-top-domain="'.$top_level_domain.'"  data-folder-id="'.$funnel['leadpop_folder_id'].'" data-tag-id="'.$funnel['client_tag_id'].'"';
    }
    $module = activeModule($view->data->active_menu);
    $menu = LP_Constants::getBreadcrumText($view->data->active_menu);
$route = Request::route()->getName();
$isActiveFunnelBuilder = (isset($funnel["is_active_funnel_builder"]) && $funnel["is_active_funnel_builder"]);
@endphp

<aside class="sidebar-inner">
    <div class="sidebar-inner-holder">
        <div class="menu-holder">
            <div class="menu-holder__head">
                <h6>{{$module}}<span>{{str_replace(' / Funnel','',$menu)}}</span></h6>
            </div>
            <div class="sidebar-inner-menu-wrap">
                <ul class="menu list-unstyled">
                    <li class="menu__list active">
                        <a href="{{ URL::route('dashboard') }}" title="Home" class="menu__link">
                            <span class="menu__link-icon ico-home"></span><span class="menu__link-text">Home</span>
                        </a>
                    </li>
                    <li class="menu__list view">
                        <div class="view-wrap">
                    <a href="{{ ($funnel['domain_name'])? config("app.protocol") .$funnel['domain_name'] :'#' }}" title="View" class="menu__link" target="_blank">
                                <span class="menu__link-icon ico-view"></span><span class="menu__link-text">View</span>
                            </a>

                            @php
                                $allShortLinks = LP_Helper::getInstance()->getAllShortLinksForClient();

                             //   dd($allShortLinks);
        //                       $shortLinkData = $allShortLinks[$funnel['client_leadpop_id']] ?? [];
                                $shortLinkData = $allShortLinks[$funnel['client_leadpop_id']] ?? [];
                             //   dd($shortLinkData);
                                $shortLink = trim(config('urlshortener.app_base_url')) . '/' . ($shortLinkData['slug_name'] ?? '');
                            @endphp

                            <div class="view-popup-wrap {{ $shortLinkData ? 'view-has-short-url' : '' }}">
                                <div class="view-popup">
                                    <div class="view-popup__holder copy-btn-area">
                                        <div class="view-popup__wrap">
                                            <strong class="view-popup__title">full url:</strong>
                                            <span class="view-popup__url  full-url">
                                        {{ ($funnel['domain_name'])? config("app.protocol") .$funnel['domain_name'] :'#' }}
                                        <span class="copy-text">{{ ($funnel['domain_name'])? config("app.protocol") .$funnel['domain_name'] :'#' }}</span>
                                    </span>
                                            <div class="hover-block">
                                                <ul class="url-option">
                                            <li><a href="{{ ($funnel['domain_name'])? config("app.protocol") .$funnel['domain_name'] :'#' }}" class="copy_funnel_url_on_click copy-btn menu-tooltip" data-url="Full"  title="Copy URL"><i class="ico-copy"></i>             </a></li>
                                            <li><a href="{{ ($funnel['domain_name'])? config("app.protocol") .$funnel['domain_name'] :'#' }}" target="_blank" class="menu-tooltip" title="Open URL"><i class="ico-tab"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="view-popup__holder copy-btn-area view-short-url-wrap {{ $shortLinkData ? 'view-has-short-url' : '' }}">
                                        <div class="view-popup__wrap">
                                            <strong class="view-popup__title">Short Link:</strong>
                                            <span class="view-popup__url">
                                    {{ $shortLink }}
                                                <span class="copy-text">{{ $shortLink }}</span>
                                </span>
                                        </div>
                                        <div class="hover-block">
                                            <ul class="url-option">
                                                <li><a href="{{ $shortLink }}"
                                                       class="copy_funnel_url_on_click copy-btn el-tooltip"
                                                       data-url="Short" title="Copy URL"><i class="ico-copy"></i> </a>
                                                </li>
                                                <li><a href="{{ $shortLink }}" class="el-tooltip" title="Open URL"
                                                       target="_blank"><i class="ico-tab"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="menu__list menu__list_sub-menu">
                        <a href="#" title="Edit"
                           class="menu__link @if(LP_Helper::getInstance()->isActiveSidebarParentNav("edit", $route)) active @endif">
                            <span class="menu__link-icon ico-edit"></span><span class="menu__link-text">Edit</span>
                        </a>
                        <div class="menu__dropdown-wrapper">
                            <div class="menu__dropdown">
                                <div class="menu__dropdown-col">
                                    <h3 class="menu__dropdown-head">content</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/autoresponder/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "autoresponder") active @endif"
                                               title="Autoresponder">Autoresponder</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/calltoaction/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "calltoaction") active @endif"
                                               title="Call-to-Action">Call-to-Action</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/contact/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "contact") active @endif"
                                               title="Contact Info">Contact Info</a>
                                        </li>
                                            <li class="menu__dropdown-item">
                                                <a href="{{route('advance_footer', ["hash" => $funnel['hash']]) }}"
                                                   class="menu__dropdown-link @if($route == "advance_footer") active @endif"
                                                   title="Extra Content">Extra Content</a> <span
                                                        class="badge badge-tag pl-0" id="extra_content_new">New</span>
                                            </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/footeroption/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if(LP_Helper::getInstance()->isActiveSidebarMenuLink('edit', $route, 'footeroption')) active @endif"
                                               title="Footer">Footer</a>
                                        </li>

                                        @if($isActiveFunnelBuilder)
                                            <li class="menu__dropdown-item">
                                                <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/funnel/questions/'.$funnel['hash']}}"
                                                   class="menu__dropdown-link" title="Questions">Questions</a>
                                            </li>
                                        @endif

                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/security-messages/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "SecurityMessagesIndex") active @endif"
                                               title="Autoresponder">Security Messages</a>
                                        </li>

                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/tcpa/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "tcpaIndex") active @endif"
                                               title="Autoresponder">TCPA Messages</a>
                                        </li>

                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/thank-you-pages/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if(LP_Helper::getInstance()->isActiveSidebarMenuLink('edit', $route, 'thankyou')) active @endif"
                                               title="Thank You Page">Thank You Page</a>
                                        </li>

                                        @if(!$isActiveFunnelBuilder)
                                    </ul>
                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="You cannot edit this funnel since there <br> is and existing integration.">Questions</a>
                                        </li>
                                        @endif

                                    </ul>

                                </div>
                                <div class="menu__dropdown-col">
                                    <h3 class="menu__dropdown-head">design</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/popadmin/background/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "background") active @endif"
                                               title="Background">Background</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/popadmin/featuredmedia/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "featuredmedia") active @endif"
                                               title="Featured Image">Featured Image</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/popadmin/logo/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "logo") active @endif"
                                               title="Logo">Logo</a>
                                        </li>
                                    </ul>

                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">Buttons</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">Header</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">Progress Bar</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">Text</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">Themes</a>
                                        </li>
                                    </ul>


                                </div>
                                <div class="menu__dropdown-col">
                                    <h3 class="menu__dropdown-head">settings</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/popadmin/adaaccessibility/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "ada_accessibility") active @endif"
                                               title="ADA Accessibility">ADA Accessibility</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/popadmin/integration/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if(LP_Helper::getInstance()->isActiveSidebarMenuLink('edit', $route, 'integration')) active @endif"
                                               title="Integrations">Integrations</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/account/contacts/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "contacts") active @endif"
                                               title="Lead Alerts">Lead Alerts</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/popadmin/pixels/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "pixels") active @endif"
                                               title="Pixels">Pixels</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" {!! $status_link  !!}>Status</a>
                                        </li>
                                    </ul>

                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">A/B Testing</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">Partial Leads</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Webhooks</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="menu__dropdown-col menu__dropdown-col_110">
                                    <h3 class="menu__dropdown-head">basic info</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH."/popadmin/domain/".$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "domain") active @endif"
                                               title="Domains">Domains</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL . LP_PATH . "/tag/" . $funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "tag") active @endif"
                                               title="Name / Folder / Tags">Name / Folder / Tags</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/seo/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "seo") active @endif"
                                               title="SEO">SEO</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/branding/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "branding") active @endif"
                                               title="leadPops Branding">leadPops Branding</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip"
                                               title="COMING SOON!">Favicon</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="menu__list menu__list_sub-menu">
                        <a href="#" title="Promote"
                           class="menu__link @if(LP_Helper::getInstance()->isActiveSidebarParentNav("promote", $route)) active @endif">
                            <span class="menu__link-icon ico-promote"></span><span
                                    class="menu__link-text">Promote</span>
                        </a>
                        <div class="menu__dropdown-wrapper">
                            <div class="menu__dropdown">
                                <div class="menu__dropdown-col menu__dropdown-col_250">
                                    <h3 class="menu__dropdown-head">Promote</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="{{LP_BASE_URL.LP_PATH.'/promote/share/'.$funnel['hash']}}"
                                               class="menu__dropdown-link @if($route == "shareFunnel") active @endif"
                                               title="Share My Funnel">Share My Funnel</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="{{ Request::url() . '?sticky-bar=' . $funnel['hash'] }}"
                                               id="sticky-bar-btn-menu"
                                               class="sticky-bar-btn_v2 sticky-bar-menu-link menu__dropdown-link"
                                               title="Sticky Bar" {!! $stickbar_link !!}>Sticky Bar Builder <span
                                                        class="funnel-sticky-status"> {{ $funnel_sticky_status }}</span></a>
                                        </li>
                                        {{--<li class="menu__dropdown-item">--}}
                                        {{--<a href="promote-iframe-funnel.php" class="menu__dropdown-link" title="Place it in iFrame">Place it in iFrame</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="menu__dropdown-item">--}}
                                        {{--<a href="promote-openpop-funnel.php" class="menu__dropdown-link" title="Open in Popup">Open in Popup</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="menu__dropdown-item">--}}
                                        {{--<a href="promote-lightbox-funnel.php" class="menu__dropdown-link" title="Open in Lightbox">Open in Lightbox</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="menu__dropdown-item">--}}
                                        {{--<a href="platforms-funnel.php" class="menu__dropdown-link" title="Platforms">Platforms</a>--}}
                                        {{--</li>--}}
                                    </ul>
                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="javascript:void(0);"
                                               class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Embed
                                                in a Web Page</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="javascript:void(0);"
                                               class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Open
                                                in Lightbox</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="javascript:void(0);"
                                               class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Open
                                                in Popup</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="javascript:void(0);"
                                               class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Place
                                                it in iFrame</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="javascript:void(0);"
                                               class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Platforms</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="menu__list">
                        <a href="{{LP_BASE_URL.LP_PATH."/popadmin/stats/".$funnel['hash']}}"
                           data-hash="{{ $funnel['hash'] }}" title="Stats"
                           class="menu__link @if($route == "statistics") active @endif">
                            <span class="menu__link-icon ico-stats"></span><span class="menu__link-text">Stats</span>
                        </a>
                    </li>
                    <li class="menu__list">
                        <a href="{{LP_BASE_URL.LP_PATH."/myleads/index/".$funnel['hash']}}" title="Leads"
                           class="menu__link @if($route == "myleads") active @endif">
                            <span class="menu__link-icon ico-multi-user"></span><span
                                    class="menu__link-text">Leads</span>
                        </a>
                    </li>
                    <li class="menu__list">
                        <a href="#" {!! $clone_link !!} title="Clone" class="menu__link cloneFunnelSubdomainBtn">
                            <span class="menu__link-icon ico-copy"></span><span class="menu__link-text">Clone</span>
                        </a>
                    </li>
                    <!--            <li class="menu__list">-->
                    <!--                <a href="#" title="Status" class="menu__link">-->
                    <!--                    <span class="menu__link-icon ico-info"></span><span class="menu__link-text">Status</span>-->
                    <!--                </a>-->
                    <!--            </li>-->
                </ul>
            </div>
        </div>
    </div>
</aside>
