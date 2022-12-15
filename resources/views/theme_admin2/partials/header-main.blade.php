<!--HEADER Start -->
@php
    use App\Services\DataRegistry;
    use App\Constants\LP_Constants;
    $current_uri = str_replace(App::make('url')->to('/'), "", URL::current());
    $client_products = LP_Helper::getInstance()->getClientProducts();
    $current_hash = LP_Helper::getInstance()->getCurrentHash();
    $hash_data = LP_Helper::getInstance()->getFunnelData();
    $funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
    $client_data = LP_Helper::getInstance()->getDirectClientInfo();

    $current_url = url()->current();
    $action = app('request')->route()->getAction();
    $controller = class_basename($action['controller']);
    list($controller, $action) = explode('@', $controller);
    $controller = strtolower(str_replace("Controller", "", $controller));
    $action = strtolower(str_replace("Action", "", $action));


    /* if  User Have Lite Package*/
    if(@$view->session->clientInfo->is_lite=='1'){
        $str_lite_funnels=$view->session->clientInfo->lite_funnels;
        $lite_funnels=explode(",",$str_lite_funnels);
    }
    /* End if  User Have Lite Package*/
@endphp
<header class="navigation-bar is-visible" data-nav-status="toggle">
    <div class="tob-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav id="top-nav" class="navbar navbar-default">
                        <div class="">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="">
                                <ul class="nav navbar-nav">
                                    <li><span>Funnels</span> 2.0 Management</li>
                                    <li class="dropdown top-products">
                                        <div class="top-prod product-dropdown dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span class="firstLabel prodLabel">Product: <span class="prodText white"><span>{{ ($client_products[LP_Constants::PRODUCT_FUNNEL] == "1" ? "Funnels 2.0" : ($client_products[LP_Constants::PRODUCT_FUNNEL] == "0" && $client_products[LP_Constants::PRODUCT_LANDING] == "1" ? "Landing Pages" : "") ) }}</span></span> <span class="caret"></span></span>
                                            <input type="hidden" name="cd-dropdown">
                                            <ul class="product-list dropdown-list">
                                                @php
                                                if($client_products[LP_Constants::PRODUCT_FUNNEL]==1){
                                                    $client_funnel=1;
                                                }else{
                                                    $client_funnel=0;
                                                }
                                                @endphp
                                                <li class="selectable" data-value="{{  $client_funnel }}" >
                                                    <span><a class="email_fire_" data-navlink="product_funnels" data-value="{{ $client_funnel }}" data-title="My Funnels" data-message="We'd love to talk to you about leadPops high-converting Funnels. <br /><br /><a class='btn btn-success' href='{{ LP_Constants::URL_TO_SCHEDULE_LEADPOP_CALL }}' target='_blank'>Click here to schedule a call with us.</a>" data-redirect="{{ ( in_array($current_uri, array("/lp","/lp/","/lp/index","/lp/index/")) ? 0 : 1) }}" href="{{ LP_BASE_URL.LP_PATH }}/index">Funnels 2.0</a></span>
                                                </li>
                                                @php
                                                if($client_products[LP_Constants::PRODUCT_LANDING]==1){
                                                    $landing_page=1;
                                                }else{
                                                    $landing_page=0;
                                                }

                                                if($landing_page == 1)
                                                {
                                                @endphp
                                                <li class="selectable" data-navlink="product_landingpages" data-value="{{ $landing_page }}">
                                                    <span>Landing Pages</span>
                                                </li>
                                                @php
                                                }
                                                @endphp

                                                @php
                                                $_name = str_replace(' ','-', strtolower($funnelTypes['w']));
                                                if( LP_Helper::getInstance()->checkHaveWebsiteFunnels() == true && !empty(LP_Helper::getInstance()->websiteFunnelsList()) )
                                                    $type_available = 1;
                                                else
                                                    $type_available = 0;
                                                @endphp
                                                <li class="selectable" data-navlink="conversion_pro_website" data-type_available="{{ $type_available }}" data-value="{{ $_name }}" data-client-type="{{ LP_Helper::getInstance()->getClientType() }}"><span>ConversionPro Website</span></li>
                                                <li class="selectable" data-navlink="supercalc_io">
                                                    <span><a class="" href="https://supercalc.io" target="_blank">SuperCalc.io</a></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    @php
                                    $selected = "";
                                    if($current_hash!=""){
                                        $selected="funnel-active";
                                    } @endphp
                                    <li class="dropdown mega-dropdown">
                                        <a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="white lp-funnel-drop {{ $selected }}">@php if($hash_data['funnel']['domain_name']!=""){ echo substr($hash_data['funnel']['domain_name'], 0, 17)."...";  }else { echo "Select Funnel";} @endphp</span> <span class="caret"></span></a>
                                        <ul id="mega-dropdown-scroll" class="dropdown-menu mega-dropdown-menu row">
                                            <li class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mega-panel panel panel-primary">
                                                            <div class="panel-heading">
                                                                <!-- Tabs -->
                                                                <ul class="nav panel-tabs">
                                                                    @php
                                                                    foreach (LP_Helper::getInstance()->getVerticals() as $vertical_id => $vertical){
                                                                        $selected = "";
                                                                        if($vertical_id == LP_Helper::getInstance()->clientTypeOrLandingPages()){
                                                                            $selected = "active";
                                                                        }
                                                                        echo "<li class=\"$selected\"><a href=\"#tab$vertical_id\" data-toggle=\"tab\">$vertical</a></li>";
                                                                    }
                                                                    @endphp
                                                                </ul>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="tab-content">
                                                                    @php

                                                                    foreach (LP_Helper::getInstance()->getVerticals() as $vertical_id => $vertical){
                                                                    $selected = "";
                                                                    if($vertical_id == LP_Helper::getInstance()->clientTypeOrLandingPages()){
                                                                        $selected = "active";
                                                                    }
                                                                    $funnels = LP_Helper::getInstance()->getFunnels();
                                                                    $group_ids = $funnels[$vertical_id];
                                                                    @endphp
                                                                    <div class="tab-pane {{ $selected  }}" id="tab{{ $vertical_id }}">
                                                                        <div class="row">
                                                                            @php
                                                                            $flag = 3;
                                                                            foreach($group_ids as $group_id=>$group_item){
                                                                            if($flag % 3 == 0 && $flag > 3){
                                                                                echo '</div><div class="row">';
                                                                            }

                                                                            @endphp
                                                                            <div class="col-md-4 pr">
                                                                                <h2 class="details-title">{{ LP_Helper::getInstance()->getGroupName($group_id) }}: <span>{{ LP_Helper::getInstance()->getGroupCount($group_id) }}</span></h2>
                                                                                <ul class="funnel-url-list custom-scroll">
                                                                                    @php

                                                                                    $disable_is_lite_class="";

                                                                                    foreach($group_item as $sv_id=>$sub_verticals){
                                                                                        if(@$view->session->clientInfo->is_lite=='1'){
                                                                                            if(!in_array($sv_id,$lite_funnels)){
                                                                                                $disable_is_lite_class="disable_lite_package";
                                                                                           }
                                                                                        }

                                                                                        foreach ($sub_verticals as $funnel){
                                                                                            if($current_hash==""){
                                                                                                $arr_data = explode(strtolower($action."/"),$current_url);
                                                                                                $current_hash = end($arr_data);
                                                                                            }

                                                                                            $isfunnelHash = LP_Helper::getInstance()->funnel_hash($current_hash);
                                                                                            if($current_url=='/lp' || $current_url=='/lp/index' || $current_url=='/lp/support' || $current_url=='/lp/global'|| $current_url=='/lp/account/profile' || $current_url=='/lp/emailfire/index' || empty($isfunnelHash) ){
                                                                                                $current_action_url='http://'.strtolower($funnel['domain_name']);
                                                                                                $_target="target='_blank'";
                                                                                            }
                                                                                            else{
                                                                                                $arr_data = explode(strtolower($action."/"),$current_url);
                                                                                                $current_action_url=$arr_data[0].$action."/index/".$funnel['hash'];
                                                                                                $_target="";
                                                                                            }

                                                                                            $selected='';
                                                                                            if($funnel['hash']==$current_hash){
                                                                                                $selected = "funnel-active";
                                                                                            }
                                                                                            echo "<li ><a class='".$selected." ".$disable_is_lite_class."'    href='".$current_action_url."'   ".$_target.">".strtolower($funnel['domain_name'])."</a></li>";
                                                                                        }
                                                                                    }
                                                                                    @endphp
                                                                                </ul>
                                                                            </div>
                                                                            @php
                                                                            $flag++;
                                                                            }
                                                                            @endphp
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                    }
                                                                    @endphp
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                    @php
                                    if(LP_Helper::getInstance()->getClientType() != "") {
                                    @endphp
                                    <div id="train-module">
                                        <a href="#" data-ov-target="lp-ol-{{ str_replace(' ','-',strtolower(LP_Helper::getInstance()->getClientType())) }}"  id="lp-train-module">View Training Library</a>
                                    </div>
                                    @php
                                        }
                                    @endphp

                                    <li class="dropdown top-users last">
                                        <div class="dropdown top-user user-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <span data-clientId="{{ @$view->session->clientInfo->client_id }}" class="currentClientId firstLabel userLabel">Welcome <span class="white">{{ @$view->session->clientInfo->first_name.' '.@$view->session->clientInfo->last_name }}</span> ID# {{ @$view->session->clientInfo->client_id }} <span class="caret"></span></span>
                                            <ul class="user-list dropdown-list">
                                                <li class="account">
                                                    <a href="{{ LP_PATH }}/account/profile">My Account</a>
                                                </li>
                                                <li class="support">
                                                    <a href="{{ LP_PATH }}/support">Support</a>
                                                </li>
                                                <li class="logout">
                                                    <a href="{{ LP_PATH }}/logout?reset=1">Logout</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    @php
                                    if(@$_COOKIE['design']=='leadpops'){
                                    $jpgurl= LP_Helper::getInstance()->getDesignjpgurl();
                                    @endphp
                                    <li><a href='{{ LP_PATH }}/design/index?file={{ $jpgurl }}' target="_blank">Design</a></li>
                                    @php
                                    }
                                    @endphp


                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="logo-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="row">

                        @php
                        //                        if(@$_COOKIE['development'] == 'syncpass') {
                        $cssColOne = "col-md-6 col-sm-5 col-xs-5 lpp-col-7 right-padding-0";
                        $cssColTwo = "col-md-6 col-sm-7 col-xs-7 lpp-col-5 left-padding-0";
                        //                        } else {
                        //                            $cssColOne = "col-md-5 col-sm-5 col-xs-5";
                        //                            $cssColTwo = "col-md-7 col-sm-7 col-xs-7";
                        //                        }
                        @endphp
                        <div class="{{ $cssColOne }}">
                            <ul class="logo-list">
                                <li class="logo-wrapper-width"><a href="{{ LP_BASE_URL.LP_PATH }}"><img class="lp-main-logo" src="{{ LP_ASSETS_PATH }}/adminimages/logo.png"></a></li>
                                <li><a href="{{ LP_BASE_URL.LP_PATH }}" class="icon home">Home</a></li>
                                @php
                                if($client_data['is_mm'] == 1 || $client_data['is_fairway'] == 1 || @$_COOKIE['kas-icon']){
                                if($client_data['ifs_email']==''){
                                $c_email = $client_data['contact_email'];
                                }else{
                                $c_email = $client_data['ifs_email'];
                                }

                                $c_email = urlencode($c_email);
                                $c_email = str_replace("+", "%2B",$c_email);
                                $c_email = urldecode($c_email);
                                $encrypted_email = str_replace("+", "~", LP_Helper::getInstance()->encrypt($c_email));

                                if($client_data['is_mm'] == 1){
                                $portal = MOVEMENT_PORTAL;
                                }
                                else if($client_data['is_fairway'] == 1){
                                $portal = FAIRWAY_PORTAL;
                                }

                                $loginUrl = $portal . "/lplogin?myleads=".$encrypted_email;
                                @endphp
                                <li><a href="{{ $loginUrl }}" target="_blank" data-syncpass="{{ $client_data['sync_password'] }}" class="">
                                        <i class="chart-icon"></i><span class="color-dark">Performance</span>
                                    </a></li>
                                @php } @endphp
                                <li class="pp-last"><a href="https://support.leadpops.com/hc/en-us" target="_blank" data-syncpass="{{ $client_data['sync_password'] }}" class="">
                                        <i class="knowledge-icon"></i><span>Knowledge</span>
                                    </a></li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>

                        <div class="{{ $cssColTwo }}">
                            <div class="collapse navbar-collapse email-list">
                                <input type="hidden" name="flagoverlay" id="flagoverlay" value="{{ LP_Helper::getInstance()->getOverlayFlag() }}">
                                <input type="hidden" name="flagoverlayval" id="flagoverlayval" value="{{ LP_Helper::getInstance()->getOverlayFlagVal() }}">
                                @php
                                if(LP_Helper::getInstance()->getOverlayFlagVal()){
                                DataRegistry::getInstance()->leadpops->show_overlay=0;
                                } @endphp
                                <ul id="email-fire" class="nav navbar-nav">
                                    @php
                                    //Remove Email Fire from FW and MM clients
                                    if($client_data['is_mm'] == 0 && $client_data['is_fairway'] == 0 && $client_data['is_fairway_branch'] == 0){
                                    @endphp
                                    <li class="dropdown">
                                        <div class="btn btn-leadpops dropdown-toggle email-fire-btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ LP_ASSETS_PATH }}/adminimages/email-fire.png"><span class="caret"></span></div>
                                        <ul class="dropdown-menu emaildrop-list">

                                            @php
                                            //debug(LP_Constants::PRODUCT_EMAILFIRE);
                                            if($client_products[LP_Constants::PRODUCT_EMAILFIRE]==1){
                                            $email_fire=1;

                                            }else{
                                            $email_fire=0;

                                            }
                                            @endphp
                                            <li><a data-toggle="modal" data-class="product_alert" class="email_fire email_firelogin-box" data-value="{{ $email_fire }}" data-title="Email Fire" data-message="We'd love to talk to you about Email Fire.<br /> <a class='btn btn-success' href='{{ LP_Constants::URL_TO_SCHEDULE_LEADPOP_CALL }}' target='_blank'>Click here to schedule a call with us.</a>"   href="{{ LP_BASE_URL.LP_PATH }}/emailfire/index">Go to / Login</a></li>
                                            <li><a  data-toggle="modal" data-class="product_alert" class="email_fire" data-value="{{ $email_fire }}" data-title="Email Fire" data-message="We'd love to talk to you about Email Fire.<br /> <a class='btn btn-success' href='{{ LP_Constants::URL_TO_SCHEDULE_LEADPOP_CALL }}' target='_blank'>Click here to schedule a call with us.</a>" href="{{ LP_BASE_URL.LP_PATH }}/emailfire/manage"><!--configure-->Funnels + Email Fire</a></li>

                                        </ul>
                                    </li>
                                    @php
                                    }
                                    @endphp

                                    <li><a href="{{ LP_PATH }}/popadmin/hub" class="btn m-hub btn-leadpops">MARKETING HUB</a></li>
                                    <li><a href="{{ LP_BASE_URL.LP_PATH.'/global'  }}" class="global-settings {{ ((@$view->session->clientInfo->is_lite == '1') ? 'disable_lite_package' : '') }}"><i class="fa fa-cog"></i><span>Global Settings</span></a></li>

                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--////////////////////////Pop Message FOr Select Product//////////-->
<div class="modal fade lp-modal-box in" id="emailfiremodel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title"> </h3>
            </div>
            <div class="modal-body model-action-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                    <div class="row lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="col-sm-12 popup-wrapper modal-action-msg-wrap">
                            <div class="funnel-message" align="center"></div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="lp-modal-footer lp-modal-action-footer">
                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
            </div>

        </div>
    </div>
</div>