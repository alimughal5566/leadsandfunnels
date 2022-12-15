@php

    $s_url = array();
    /* if  User Have Lite Package*/
    if(@$view->session->clientInfo->is_lite=='1'){
        $str_lite_funnels=$view->session->clientInfo->lite_funnels;
        $lite_funnels=explode(",",$str_lite_funnels);
    }
    /* End if  User Have Lite Package*/
    $clientVerticals = LP_Helper::getInstance()->getVerticals();
    $funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
    $default_vert_val = str_replace(' ','-', strtolower($clientVerticals[LP_Helper::getInstance()->clientTypeOrLandingPages()]));
    $arr = $tags_list = $tag = array();
    $funnel_type_name = $funnelTypes['f'];
    $search_type = $tag_type = 1;
    $funnel_search = $funnel_url = $funnel_option= '';
    $tag_option = $funnel_type_url = 'style=display:none;';
    $filter_search = @$view->session->tag_filter;
    $arr = folder_list();
    $tags_list = tag_list();
    if($arr){
        $funnel = array_search($funnelTypes['f'],array_column($arr, 'folder_name'));
        if(isset($arr[$funnel]) and !empty($arr[$funnel])){
            $funnel = $arr[$funnel]->id;
        }
    }
    else{
        $funnel = 0;
    }

    if($filter_search){
        if(!empty($filter_search->funnel_type_name)){
            $funnel = $filter_search->funnel;
            $funnel_type_name = $filter_search->funnel_type_name;
        }
        if(!empty($filter_search->search_type)){
            $search_type = $filter_search->search_type;
            $funnel_search = $filter_search->funnel_search;
        }
        if($filter_search->search_type == 3){
            $funnel_url = @$filter_search->funnel_url;
            $tag = explode(',',$filter_search->tag);
            $funnel_type_url = 'style=display:block;';
            $funnel_option = $tag_option = 'style=display:none;';
        }
        if($filter_search->search_type == 2 && !empty($filter_search->tag_type)){
            $tag_type = $filter_search->tag_type;
            $tag = explode(',',$filter_search->tag);
            $tag_option = 'style=display:block;';
            $funnel_option = 'style=display:none;';
        }
    }
     $hash_data = LP_Helper::getInstance()->getFunnelData();
    // header left side responsive option & scaling
    $arr_hr_option = array(
        'new-transition.php',
        'new-transition.php',
        'fb-zip-code.php',
        'fb-menu.php',
        'fb-slider.php',
        'fb-text-field.php',
        'fb-drop-down.php',
        'fb-cta-message.php',
        'fb-date-birthday.php',
        'fb-list-of-states.php',
        'fb-vehicle-modal-make.php'
    );
    // funnel builder page

    $funnel_builder = array(
        'funnel-question.php',
        'new-transition.php',
        'fb-zip-code.php',
        'fb-menu.php',
        'fb-slider.php',
        'fb-text-field.php',
        'fb-drop-down.php',
        'fb-cta-message.php',
        'fb-date-birthday.php',
        'fb-list-of-states.php',
        'fb-vehicle-modal-make.php'
    );

    $route = Request::route()->getName();

    $noProfileImage = "";
    $rackspaceClientImageBase = getCdnLink();
    if(!empty(@$view->session->clientInfo->avatar) && @getimagesize($rackspaceClientImageBase . "/pics/thumbnail-" . rawurlencode(@$view->session->clientInfo->avatar))) {
        $thubnailImage = $rackspaceClientImageBase . "/pics/thumbnail-" . $view->session->clientInfo->avatar;
    } else {
        if(isset($view->session->clientInfo->first_name) && !empty($view->session->clientInfo->first_name)) {
            $noProfileImage .= $view->session->clientInfo->first_name[0];
        }
        if(isset($view->session->clientInfo->last_name) && !empty($view->session->clientInfo->last_name)) {
            $noProfileImage .= $view->session->clientInfo->last_name[0];
        }
        $noProfileImage = strtoupper($noProfileImage);
    }

    $navigation_opts = LP_Helper::getInstance()->getVariationConfig($route);

    $client_products = LP_Helper::getInstance()->getClientProducts();
    $searchFilter = (isset($filter_search->searchFilter))?($filter_search->searchFilter ==1)?'':'d-none':'';
    $statsFilter = (isset($filter_search->statsFilter))?($filter_search->statsFilter ==1)?'d-block':'':'';
    $excludeVisitor = (isset($filter_search->excludeVisitor) and $filter_search->excludeVisitor == "true")?1:0;
    $excludeConversionRate = (isset($filter_search->excludeConversionRate) and $filter_search->excludeConversionRate == "true")?1:0;

    //Statictics Video
    $stats_wistia_title = "";
    $stats_wistia_id = null;
    if ((isset($view->data->stats_video['wistia_id']) && $view->data->stats_video['wistia_id'])) {
        if (isset($view->data->stats_video['title']) && $view->data->stats_video['title']) {
            $stats_wistia_title = $view->data->stats_video['title'];
        }
        $stats_wistia_id = $view->data->stats_video['wistia_id'];
    }

    // URL hash
    $current_url = url()->current();
    $arr_data = explode("/", $current_url);
    $current_funnel_hash = end($arr_data);
@endphp

<header class="header">
    <!-- header info-bar of the page -->
    <div class="info-bar">
        <div class="row justify-content-between">
            <div class="col-6">
                <div class="funnels-info">

                    @if ($route === "dashboard")
                        <span class="d-block funnels-info__title">Funnels Home</span>
                    @endif
                        @if ($route === "my_profile")
                            <span class="d-block funnels-info__title">Account</span>
                        @endif

                    @if(!in_array(str_replace('/','',$_SERVER['PHP_SELF']),$arr_hr_option) && $route !== "my_profile")
                        <div class="funnels-dropdown toggle-dropdown">
                            <a class="funnels-dropdown__button toggle-link" href="#">
                                <span class="funnel-active">@php if(isset($hash_data['funnel']) and $hash_data['funnel']['funnel_name']!=""){ echo (strlen(trim($hash_data['funnel']['funnel_name'])) > 16)?substr(trim($hash_data['funnel']['funnel_name']), 0, 16)."...":$hash_data['funnel']['funnel_name'];  }else { echo "Select Funnel";}@endphp</span>
                                <span class="icon ico-arrow-down"></span></a>
                            <div class="megamenu toggle-menu">
                                <div class="search-bar">
                                    <div class="search-bar__filter">
                                        <div class="row megamenu-filter">
                                            <div class="search-bar__column megamenu__folder select2js__nice-scroll">
                                                <select class="select-custom megamenu__folder_select top-funnel-type-search">
                                                    <option value="0" selected>All Funnels</option>
                                                    @php
                                                        if($arr){
                                                            foreach($arr as $v){
                                                            if(isset($v->is_website) and $v->is_website == 1){
                                                             $vl = 'w';
                                                            }else{
                                                             $vl = $v->id;
                                                            }
                                                            $ret = count(dashboardEmptyFolderSkip($vl));
                                                            if($vl == $funnel){
                                                            $selected = 'selected';
                                                            }else{
                                                            $selected = '';
                                                            }
                                                            echo "<option value=".$vl." data-value=".$v->id." data-count=".$ret.">$v->folder_name</option>";
                                                       }
                                                            }
                                                    @endphp
                                                </select>
                                            </div>
                                            <div class="search-bar__column megamenu__category">
                                                <select class="select-custom megamenu__category_select top-funnel-filter">
                                                    <option value="1" selected>Search by Funnel Name</option>
                                                    <option value="2">Search by Funnel Tags</option>
                                                    <option value="3">Search by Funnel URL</option>
                                                </select>
                                            </div>
                                            <div class="search-bar__column megamenu__tag" style="display: none;">
                                                <select class="select-custom megamenu__tag_select top-tag-type">
                                                    <option value="1" selected>Has Any of these tags</option>
                                                    <option value="2">Has All of these tags</option>
                                                </select>
                                            </div>
                                            <div class="search-bar__column funnel-name-search">
                                                <div class="input-holder">
                                                    <input type="search" class="form-control top-funnel-search"
                                                           placeholder="Type in the Funnel Name..." value="">
                                                    <span class="icon ico-search top-header-search" onclick="topHeaderFunnelFilter();"></span>
                                                </div>
                                            </div>
                                            <div class="search-bar__column funnel-url-search" style="display: none;">
                                                <div class="input-holder">
                                                    <input type="search" class="form-control top-funnel-url"
                                                           placeholder="Type in the Funnel URL..." value="">
                                                    <span class="icon ico-search top-header-url" onclick="topHeaderFunnelFilter();"></span>
                                                </div>
                                            </div>
                                            <div class="search-bar__column funnel-tag-search lp-tag">
                                                <div class="input-holder tag-result-common top-tag-result">
                                                    <select class="top-tag-search" multiple="multiple">
                                                        @if($tags_list)
                                                            @foreach($tags_list as $t)

                                                                <option value="{!! $t->tag_name !!}">{!! $t->tag_name !!}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="icon ico-search" onclick="topHeaderFunnelFilter();"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="total-funnels">Total Funnels: <b></b></div>
                                <!--megamenu funnels-->
                                <div class="megamenu-funnels">
                                    <div class="megamenu-funnels__holder">
                                        <div class="megamenu-funnels__box">
                                            <div class="row">
                                                <div class="megamenu-funnels__column">
                                                    <span class="heading">Funnel Name</span>
                                                    <div class="sorting-btns-wrap">
                                                       <span class="sort-up active tag-sort" data-sort="name-asc"></span>
                                                       <span class="sort-down tag-sort" data-sort="name-desc"></span>
                                                    </div>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <span class="heading">Funnel URL</span>
                                                    <div class="sorting-btns-wrap">
                                                       <span class="sort-up url-tag-sort" data-sort="url-asc"></span>
                                                        <span class="sort-down url-tag-sort" data-sort="url-desc"></span>
                                                    </div>
                                                </div>
                                                <div class="megamenu-funnels__column">
                                                    <span class="heading">Funnel Tags</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="top-header-funnel" data-client-leadpops-id="{{isset($hash_data['funnel'])?$hash_data['funnel']['client_leadpop_id']:''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="megamenu-funnels-msg">
                                    <div class="top-messge"></div>
                                </div>
                            </div>
                        </div>
                    @elseif(in_array(str_replace('/','',$_SERVER['PHP_SELF']),$arr_hr_option))
                        <div class="action action_dresponsive">
                            <ul class="action__list">
                                <li class="action__item desktop active">
                                    <i class="ico ico-devices"></i>
                                </li>
                                <li class="action__item mobile">
                                    <i class="ico ico-mobile"></i>
                                </li>
                                <li class="action__item">
                                    <div class="range-slider">
                                        <div class="input__wrapper">
                                            <input id="" class="form-control ex1" data-slider-id='ex1Slider'
                                                   type="text"/>
                                            <span class="ex1SliderVal">75%</span>
                                            <input type="hidden" class="defaultSize" value="75">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endif
                    @if(in_array($route, config("routes.top_nav_home")))
                        <ul class="actions-button">
                            <li class="actions-button__list">
                                <a class="actions-button__link actions-button__link_fhomepage el-button-tooltip" href="{{ URL::route('dashboard') }}" title="Funnels Homepage">
                                    <span class="actions-button__icon ico-home"></span>
                                    <span class="actions-button__text">Funnels Homepage</span>
                                </a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>

            <div class="col-6">
                <div class="client-setting">
                    @if ($route === "dashboard")
                        <ul class="list-actions list-actions_info">
                            <li class="list-actions__li item-stats"><a href="#" class="list-actions__link stats-trigger"><i class="icon ico-stats el-tooltip" title="<p class='global-tooltip font-small'>FUNNELS STATS SUMMARY</p>"></i></a></li>
                            <li class="list-actions__li item-search"><a href="#" class="list-actions__link search-trigger"><i class="icon ico-search el-tooltip" title="<p class='global-tooltip font-small'>SEARCH</p>"></i></a></li>
                        </ul>
                    @endif
                    <div class="client-setting__button">
                        <ul class="actions-button">
                        @foreach($navigation_opts['options'] as $button)

                            <!-- Create New Funnel -->
                            @if($button == "create_funnels")
                                <li class="actions-button__list">
                                    <a class="actions-button__link actions-button__link_create-funnels el-button-tooltip" href="#create-funnel"  title="Create New Funnel">
                                        <span class="actions-button__icon ico-plus"></span>
                                        <span class="actions-button__text">Create New Funnel</span>
                                    </a>
                                </li>
                            @endif

                            <!-- Global Settings -->
                            @if($button == "global_settings" && !in_array($route,array('domain')))
                                @include('partials.global-settings-menuitem', ['globalData' => [$currentRoute, $globalRoutes]])
                            @endif


                            {{--                            @if(!in_array(str_replace('/','',$_SERVER['PHP_SELF']),@$funnel_builder))--}}
                            {{--                                <!-- Email fire -->--}}
                            {{--                                <li class="actions-button__list">--}}
                            {{--                                    <a class="actions-button__link actions-button__link_email" href="#"--}}
                            {{--                                       title="Email Fire">--}}
                            {{--                                        <span class="actions-button__icon ico-fire"></span>--}}
                            {{--                                        <span class="actions-button__text">email <b>fire</b></span>--}}
                            {{--                                    </a>--}}
                            {{--                                </li>--}}
                            {{--                            @endif--}}

                            <!-- View Funnels -->
                            @if($button == "view_funnels")
                                <li class="actions-button__list">
                                    <a target="_blank" class="actions-button__link actions-button__link_view-funnels el-button-tooltip" href="{{ config("app.protocol") . @$hash_data['funnel']['domain_name'] }}" data-id="header_funnel_url" title=" View My Funnel">
                                        <span class="actions-button__icon ico-view"></span>
                                        <span class="actions-button__text">View My Funnel</span>
                                    </a>
                                </li>
                            @endif

                            <!-- Save Button -->
                            @if($button == "save" && ($route != "integrate" || $route == "integrate" && in_array(@$view->data->key, [config('integrations.iapp.TOTAL_EXPERT')['sysname'], config('integrations.iapp.HOMEBOT')['sysname']])))
                                <li class="actions-button__list">
                                    <button class="button button-secondary" id="main-submit" data-id="main-submit" data-lpkeys="{{$current_funnel_hash}}" disabled><span class="spiner-wrap">Save<span class="spiner"></span></span></button>
                                </li>
                            @endif

                        @endforeach
                        </ul>
                    </div>

                    <!-- PROFILE -->
                    <div class="client-setting__profile">
                        <div class="account-setting">
                            <div class="account-setting__info">
                                <div class="user-info">
                                    @if (!empty($noProfileImage))
                                        <div class="user-image no-image">{{$noProfileImage}}</div>
                                    @else
                                        <div class="user-image">
                                            <img src="{{ $thubnailImage }}" alt="{{ @$view->session->clientInfo->first_name.' '.@$view->session->clientInfo->last_name }}"
                                                 title="{{ @$view->session->clientInfo->first_name.' '.@$view->session->clientInfo->last_name }}">
                                        </div>
                                    @endif

                                    <div class="user-detail">
                                        <span class="user-name">{{ @$view->session->clientInfo->first_name.' '.@$view->session->clientInfo->last_name }}</span>
                                        <span class="user-id" data-clientId="{{ @$view->session->clientInfo->client_id }}">ID# {{ @$view->session->clientInfo->client_id }}</span>
                                        <a href="#" class="toggle-link"><span class="icon ico-arrow-down"></span></a>
                                    </div>
                                </div>
                            </div>
                            <ul class="settings__dropdown">
                                <li class="settings__dropdown__list">
                                    <a href="{{ URL::route('my_profile') }}" class="settings__dropdown__link">
                                        <span class="icon ico-settings"></span>
                                        Account Settings
                                    </a>
                                </li>
                                @if(isset($client_products[App\Constants\LP_Constants::PRODUCT_EMAILFIRE]) && $client_products[App\Constants\LP_Constants::PRODUCT_EMAILFIRE]==1)
                                    <li class="settings__dropdown__list">
                                        <a data-toggle="modal" href="#email_fire_popup" class="settings__dropdown__link">
                                            <span class="icon ico-fire"></span>
                                            Email Fire
                                        </a>
                                    </li>
                                @endif
                                <li class="settings__dropdown__list">
                                    <a href="{{ URL::route('support') }}" class="settings__dropdown__link">
                                        <span class="icon ico-message"></span>
                                        Support
                                    </a>
                                </li>
                                <li class="settings__dropdown__list">
                                    <a href="{{ URL::route('logout') }}" class="settings__dropdown__link">
                                        <span class="icon ico-logout"></span>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header Search of the page -->
    @if ($route === "dashboard")
        <div class="search-bar-slide {{$searchFilter}}">
          <div class="search-bar">
              <div class="search-bar-wrap">
                  <span class="search-bar__caption font-italic">Filter by:</span>
                  <div class="search-bar__filter">
                      <div class="row">
                          <div class="search-bar__column funnel-type select2js__nice-scroll">
                              <select class="select-custom select-custom_type funnel-type-search">
                                  <option value="0" selected>All Funnels</option>
                                  @php
                                      if($arr){
                                          foreach($arr as $v){
                                          if(isset($v->is_website) and $v->is_website == 1){
                                           $vl = 'w';
                                          }else{
                                           $vl = $v->id;
                                          }
                                          $ret = count(dashboardEmptyFolderSkip($vl));
                                          if($vl == $funnel){
                                          $selected = 'selected';
                                          }else{
                                          $selected = '';
                                          }
                                          echo "<option value=".$vl." ".$selected." data-value=".$v->id." data-count=".$ret.">$v->folder_name</option>";
                                     }
                                          }
                                  @endphp
                              </select>
                          </div>
                          <div class="search-bar__column funnel-category">
                              <select class="select-custom select-custom_category funnel-filter">
                                  <option value="1" {{getSelected(1,$search_type)}}>Search by Funnel Name</option>
                                  <option value="2" {{getSelected(2,$search_type)}}>Search by Funnel Tags</option>
                                  <option value="3" {{getSelected(3,$search_type)}}>Search by Funnel URL</option>
                              </select>
                          </div>
                          <div class="search-bar__column funnel-tag lp-tag" {{$tag_option}}>
                              <select class="select-custom select-custom_tag tag-type">
                                  <option value="1" {{getSelected(1,$tag_type)}}>Has Any of These Tags</option>
                                  <option value="2" {{getSelected(2,$tag_type)}}>Has All of These Tags</option>
                              </select>
                          </div>
                          <div class="search-bar__column funnel-name-search" {{$funnel_option}}>
                              <div class="input-holder">
                                  <input type="search" class="form-control funnel-search" placeholder="Type in the Funnel Name..." value="{{ $funnel_search }}">
                                  <span class="clear-search" onclick="clearSearch();">Clear Search</span>
                                  <span class="icon ico-search search-top" onclick="_search();"></span>
                              </div>
                          </div>
                          <div class="search-bar__column funnel-url-search" {{$funnel_type_url}}>
                              <div class="input-holder">
                                  <input type="search" class="form-control funnel-url" placeholder="Type in the Funnel URL..." value="{{ $funnel_url }}">
                                  <span class="clear-search" onclick="clearSearch();">Clear Search</span>
                                  <span class="icon ico-search search-top" onclick="_search();"></span>
                              </div>
                          </div>
                          <div class="search-bar__column funnel-tag-search" {{$tag_option}}>
                              <div class="input-holder">
                                  <div class="input__wrapper lp-tag">
                                      <div class="select2js__tags-parent tag-result-common dashboard-tag-result">
                                          <select class="form-control tag-drop-down tag-search" multiple="multiple" name="tag_list"
                                                  id="dashboard_tag_list">
                                              @if($tags_list)
                                                  @foreach($tags_list as $t)

                                                      <option value="{!! $t->tag_name !!}" {{ getSelectedArr($t->tag_name,$tag) }}>{!! $t->tag_name !!}</option>
                                                  @endforeach
                                              @endif
                                          </select>
                                          <span class="icon ico-search" onclick="_search();"></span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <span class="close-link-wrap">
                    <a href="#" class="close-link search-trigger"><i class="icon ico-cross el-tooltip" title="<p class='global-tooltip font-small'>CLOSE</p>"></i></a>
                      </span>
              </div>
          </div>
        </div>
        <div class="stats-area-slide  {{$statsFilter}}">
      <div class="stats-area">
        <div class="stats-head">
            <div class="title-wrap">
                @if($stats_wistia_id)
                    <a data-lp-wistia-title="{{$stats_wistia_title}}" data-lp-wistia-key="{{$stats_wistia_id}}" href="#" class="video-link lp-wistia-video fuunel-video el-tooltip" title="Watch How-To Video" data-toggle="modal" data-target="#lp-video-modal" >
                        <strong class="stats-area__title"><i class="icon ico-stats"></i>Funnels Stats Summary</strong>
                        <i class="ico-video"></i>
                    </a>
                @else
                    <a href="#" class="fuunel-video el-tooltip" title="Watch How-To Video" data-toggle="modal" data-target="#lp-video-modal">
                        <strong class="stats-area__title"><i class="icon ico-stats"></i>Funnels Stats Summary</strong>
                        <i class="ico-video"></i>
                    </a>
                @endif
            </div>
          <a href="#" class="close-stats stats-trigger"><i class="icon ico-cross el-tooltip" title="<p class='global-tooltip font-small'>CLOSE</p>"></i></a>
        </div>
        <div class="row">
          <div class="col-3">
            <div class="stats-box funnel-box">
              <div class="stats-box__head">
                  <span class="stats-box__title">Total Funnels</span>
                <a href="#total-funnels-setting" data-toggle="modal" class="stats-box__link-settings {{($excludeVisitor ==1)?"active":""}}"><i class="icon ico-settings el-tooltip" title="<p class='global-tooltip font-small'>SETTINGS</p>"></i></a>
              </div>
              <div class="stats-box__body">
                <strong class="stats-box__num stats-total-funnels">0</strong>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="stats-box">
              <div class="stats-box__head">
                <span class="stats-box__title">Total Visitors</span>
              </div>
              <div class="stats-box__body">
                <strong class="stats-box__num stats-total-visitors">0</strong>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="stats-box">
              <div class="stats-box__head">
                <span class="stats-box__title">Total Leads</span>
              </div>
              <div class="stats-box__body">
                <strong class="stats-box__num stats-total-leads">{{LP_Helper::getInstance()->total_leads}}</strong>
              </div>
            </div>
          </div>
          <div class="col-3">
            <div class="stats-box conversion-rate-box">
              <div class="stats-box__head">
                <span class="stats-box__title">Total Conversion Rate</span>
                <a href="#conversion-setting" data-toggle="modal" class="stats-box__link-settings {{($excludeConversionRate ==1)?"active":""}}"><i class="icon ico-settings el-tooltip" title="<p class='global-tooltip font-small'>SETTINGS</p>"></i></a>
              </div>
              <div class="stats-box__body">
                  <strong class="stats-box__num"><span class="total-conversion-rate">0</span><span class="unit">%</span></strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    <input type="hidden" id="is_lite_package" value="{{@$view->session->clientInfo->is_lite}}">
    <input type="hidden" id="is_lite_funnels" value="{{@$view->session->clientInfo->lite_funnels}}">
</header>
