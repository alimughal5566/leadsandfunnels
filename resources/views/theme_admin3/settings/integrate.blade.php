@extends("layouts.leadpops-inner-sidebar")
@section('content')
    @php

        $param = isset($_GET['app_theme'])?'?app_theme='.$_GET['app_theme']:'';
        $funnelData = LP_Helper::getInstance()->getFunnelData()["funnel"];
        $hash = $funnelData['hash'];
        $active_on_account = null;
        /*
        * All Funnels
        **/
        $all_funnels = array();
        foreach (LP_Helper::getInstance()->getFunnels() as $vertical_id => $groups) {
            foreach ( $groups as $group_id => $group_item ) {
                foreach ( $group_item as $sub_verticals ) {
                    foreach ( $sub_verticals as $funnel ) {
                        $all_funnels[] = array("label"=>strtolower($funnel['domain_name']." -- ".$funnel['fs_display_label']), "domain_id"=>$funnel['domain_id'], "display"=>$funnel['fs_display_label']);
                        //$all_funnels[] = strtolower($funnel['domain_name']). " (".$funnel['fs_display_label'].")";
                    }
                }
            }
        }

        /*
        * Total Expert Details
        **/
        $totalExpertInfo = LP_Helper::getInstance()->getTotalExpertInfo();

        $teIsActivated = "no"; // default not authorized
        $teCurrentStatus = "inactive"; // status in DB
        $totalExpertActive = false; // UI default false
        if (is_array($totalExpertInfo) && count($totalExpertInfo) > 0) { // has authorized
            if($view->data->key == config('integrations.iapp.TOTAL_EXPERT')['sysname']) {
                $active_on_account = $totalExpertInfo[0]["active"];
            }

           if ($totalExpertInfo[0]["active"] == 1) {
               $teIsActivated = "yes";
               $teCurrentStatus = "active";
               $totalExpertActive = true;
           }
        }
        Session::put('totalExpertHash', @$view->data->currenthash);
        $scope = "postLeads+leadSurveyInteraction";
        $session_id = session()->getId();


        /*
        * Homebot Details
        **/
        $homebotInfo = LP_Helper::getInstance()->getHomebotInfo();
        $homebotHasActivated = "no"; // default not authorized
        $homebotCurrentStatus = "inactive"; // status in DB
        $homebotActive = false; // UI default false

        if (count($homebotInfo) > 0) { // has authorized
            if($view->data->key == config('integrations.iapp.HOMEBOT')['sysname']) {
                $active_on_account = $homebotInfo[0]["active"];
            }
           if ($homebotInfo[0]["active"] == 1) {
               $homebotHasActivated = "yes";
               $homebotCurrentStatus = "active";
               $homebotActive = true;
           }
        }
        Session::put('homebotExpertHash', @$view->data->currenthash);

        $isActiveOnFunnel = true;
        if($active_on_account && !$view->data->isActiveClientIntegration) {
            $isActiveOnFunnel = false;
        }

        $integrationName = "";
    @endphp

    <main class="main">
        <section class="main-content">
            <div class="main-content__head">
                <div class="col-left">
                    <h1 class="title">
                        Integrations /
                        @switch($view->data->key)
                            @case(config('integrations.iapp.LEADPOPS_AUTH')['sysname']){{$integrationName = "leadPops API Key"}} @break
                            @case(config('integrations.iapp.ZAPIER')['sysname']){{$integrationName = "Zapier"}} @break
                            @case(config('integrations.iapp.TOTAL_EXPERT')['sysname']){{$integrationName = "Total Expert"}} @break
                            @case(config('integrations.iapp.HOMEBOT')['sysname']){{$integrationName = "Homebot"}} @break
                        @endswitch
                    </h1>

                    @if($active_on_account !== null)
                        <span class="el-tooltip" data-container="body" data-toggle="tooltip" title="This controls your integration with {{$integrationName}} at an account-level." data-html="true" data-placement="top">
                            <input @if($active_on_account) checked @endif
                                   class="integration-toggle"
                                   data-html="true" data-placement="top"
                                   id="account-switch" name="account-switch" data-toggle="toggle"
                                   data-onstyle="active" data-offstyle="inactive"
                                   data-width="127" data-height="43" data-on="INACTIVE"
                                   data-field = 'active_on_account'
                                   data-off="ACTIVE" type="checkbox">
                        </span>
                    @endif
                </div>
                <div class="col-right">
                    <a href="{{LP_BASE_URL.LP_PATH.'/popadmin/integration/'.$hash.$param}}" class="back-link"><span class="icon icon-back ico-caret-up"></span> Back to integrations</a>
                </div>
            </div>
            @include("partials.flashmsgs")
            <form id="createauthkey" enctype="multipart/form-data" action="{    { LP_BASE_URL.LP_PATH.'/popadmin/createauthkey' }}" method="post">
                <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                <input type="hidden" name="integration_activated" id="integration_activated" value="{{ is_null($active_on_account) ? "no" : "yes" }}">
                <input type="hidden" name="type" id="type" value="{{ $view->data->key }}">

                @if($active_on_account !== null)
                    {{-- Only for hombot and total expert integration--}}
                    <input type="hidden" name="active_on_account" id="active_on_account" value="{{ $active_on_account ? "active" : "inactive" }}" data-form-field>
                    <input type="hidden" name="active_on_funnel" id="active_on_funnel" value="{{ $view->data->isActiveClientIntegration ? "active" : "inactive" }}" data-form-field>
                    <input type="hidden" name="update_type" id="update_type" value="">
                @endif
            </form>

            <div class="lp-panel copy-btn-area">
                @switch($view->data->key)
                    @case(config('integrations.iapp.ZAPIER')['sysname'])
                    <div class="lp-panel__head d-block">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Zapier Integration
                            </h2>
                        </div>
                        <div class="row">
                            <div class="col lp-panel__head-disc ml-0">
                                <ul>
                                    <li>
                                        To integrate Zapier with leadPops Funnels you need an authorization token for your account.
                                    </li>
                                    <li>
                                        While creating a Zap, this authorization token will be asked by Zapier to identify your account.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                leadPops Authorization Key
                            </h2>
                        </div>
                    </div>
                    <div class="input__wrapper">
                        <input id="zapier_access_key" name="zapier_access_key" class="form-control" type="text" value="{{ (@$view->data->clientToken ? @$view->data->clientToken : "") }}" disabled>
                        <span class="copy-text" >{{ (@$view->data->clientToken ? @$view->data->clientToken : "") }}</span>
                    </div>
                    <div class="col lp-panel__head-disc ml-0">
                        <button  id="zapierKeyBtn" class="button button-secondary">{{ (@$view->data->clientToken ? "Re-Generate Key" : "Generate Key") }}</button>
                        <button id="zapierKeyBtn_copy" class="button button-primary copy-btn" {{(@$view->data->clientToken ? "" : "disabled") }}>Copy to Clipboard</button>
                        <input type="hidden" name="zapier_integrations" id="zapier_integrations" value="{{ @$view->data->integrations }}" />
                        {{--                            <button class="button button-primary" id="funnel-for-zapier" data-target="#funnel-selector"><i class="fa fa-cog"></i> Select Funnels for Zapier</button>--}}
                        {{--                            <button class="button button-primary" id="pre-configured-zaps" data-target="#lp_zap_templates"><i class="fa fa-cog"></i> Pre-configured Zaps</button>--}}

                        <a href="#" data-toggle="modal" class="button button-primary  lp-secondary-clr" data-target="#funnel-selector" onclick="_openZapierModal()"><i class="fa fa-cog"></i>&nbsp;Select Funnels for Zapier</a>
                        <a href="#" data-toggle="modal" class="button button-primary  lp-secondary-clr" data-target="#lp_zap_templates"><i class="fa fa-cog"></i>&nbsp;Pre-configured Zaps</a>
                    </div>
                    @break
                    @case(config('integrations.iapp.TOTAL_EXPERT')['sysname'])

                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                <span class="font-regular">
									<img src="https://images.lp-images1.com/default/images/totalexpert-logo.png" width="35" alt="Total Expert">
									Funnel:
                                </span> {{$funnelData['funnel_name']}} / {{strtolower($funnelData['domain_name'])}}
                            </h2>
                        </div>
                        @if($active_on_account !== null)
                            <div class="col-right">
                                <div class="switcher-min">
                                    <input @if($view->data->isActiveClientIntegration) checked @endif
                                    class="integration-toggle funnel-switch"
                                           id="homebot-contact" name="homebot-contact" data-toggle="toggle min"
                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="92" data-height="28" data-on="INACTIVE"
                                           data-field = 'active_on_funnel'
                                           data-off="ACTIVE" type="checkbox">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="lp-panel__body">
                        <div class="authenticate">
                            <div class="authenticate__placeholder" @if(!$active_on_account || !$view->data->isActiveClientIntegration) style="display: none" @endif>
                                <div class="authenticate__placeholder-text">This Funnel is connected to Total Expert</div>
                            </div>
                            <div class="authenticate__panel" @if(!$active_on_account || !$view->data->isActiveClientIntegration) style="display: block" @endif>
                                <h3 class="authenticate__head">
                                    {{(!is_null($active_on_account) ?'Revoke':'Authenticate')}}
                                </h3>
                                @if(is_null($active_on_account))
                                    <p class="authenticate__desc">
                                        Authenticate your <a class="link" target="_blank" href="https://totalexpert.net/">Total Expert account</a>  to integrate your Funnels.
                                    </p>
                                @else
                                    <p class="authenticate__desc">
                                        Your account is integrated with {{$integrationName}}, but this Funnel's integration is inactive.
                                    </p>
                                @endif
                                <div class="authentication__form">
                                    @if(is_null($active_on_account))
                                        <button id="activedeactivebtn"  class="button button-primary">authenticate</button>
                                    @else
                                        <button id="activedeactivebtn"  class="button button-cancel">revoke</button>
                                    @endif
                                    <div style="display: none;">
                                        @php
                                            $te_link = "https://public.totalexpert.net/v1/authorize?response_type=code&client_id=leadpops&scope=". $scope." &state=". $session_id;
                                            if((isset($_COOKIE['sso_te']) && $_COOKIE['sso_te'] == 1) || @$view->data->client_id = 10604){
                                                $te_link = "https://totalexpert.net/authorize?response_type=code&client_id=leadpops&scope=". $scope." &state=". $session_id;
                                            }
                                        @endphp
                                        <a id="teactivate" target="_blank" style="color: #000 !important; transition: none !important;" href="{{ $te_link }}">
                                            For Surveys Click Here
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @break
                    @case(config('integrations.iapp.HOMEBOT')['sysname'])

                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                <span class="font-regular">
									<img src="https://images.lp-images1.com/default/images/homebot-logo.png" width="35" alt="homebot">
									Funnel:
                                </span> {{$funnelData['funnel_name']}} / {{strtolower($funnelData['domain_name'])}}
                            </h2>
                        </div>
                        @if($active_on_account !== null)
                            <div class="col-right">
                                <div class="switcher-min">
                                    <input @if($view->data->isActiveClientIntegration) checked @endif
                                            class="integration-toggle funnel-switch"
                                           id="homebot-contact" name="homebot-contact" data-toggle="toggle min"
                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="92" data-height="28" data-on="INACTIVE"
                                           data-field = 'active_on_funnel'
                                           data-off="ACTIVE" type="checkbox">
                                </div>
                            </div>
                         @endif
                    </div>
                    <div class="lp-panel__body">
                        <div class="authenticate">
                            <div class="authenticate__placeholder" @if(!$active_on_account || !$view->data->isActiveClientIntegration) style="display: none" @endif>
                                <div class="authenticate__placeholder-text">This Funnel is connected to Homebot</div>
                            </div>
                            <div class="authenticate__panel" @if(!$active_on_account || !$view->data->isActiveClientIntegration) style="display: block" @endif>
                                <h3 class="authenticate__head">
                                    {{(!is_null($active_on_account) ? 'Revoke':'Authenticate')}}
                                </h3>
                                @if(is_null($active_on_account))
                                    <p class="authenticate__desc">
                                        Authenticate your <a class="link" target="_blank" href="https://homebot.ai/">Homebot account</a>  to integrate your Funnels.
                                    </p>
                                @else
                                    <p class="authenticate__desc">
                                        Your account is integrated with {{$integrationName}}, but this Funnel's integration is inactive.
                                    </p>
                                @endif
                                <div class="authentication__form">
                                    @if(is_null($active_on_account))
                                        <button id="homebotactivedeactivebtn"  class="button button-primary">authenticate</button>
                                    @else
                                        <button id="homebotactivedeactivebtn"  class="button button-cancel">revoke</button>
                                    @endif
                                    <div style="display: none;">
                                        <!-- Changing app.leadpops.com back to myleads.leadpops.com until homebot update our callback URL -->
                                        <a id="homebotactivate" target="_blank" style="color: #000 !important; transition: none !important;" href="https://api.homebotapp.com/oauth/authorize?response_type=code&client_id=GGZbPSDB6P06ZEpNPaMzuN3AqqANnwsNnS0iNPT0B5U&redirect_uri={{ env("APP_URL") }}/api/homebot.php&state={{ $session_id }}">
                                            For Homebot Click Here
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @break
                @endswitch
            </div>
            <div class="footer">
                @include("partials.footerlogo")
            </div>
        </section>
    </main>
    @include("partials.funnelselector")
@endsection
@push('footerScripts')
    <script src="{{ config('view.theme_assets') }}/pages/integration.js?v={{ LP_VERSION }}"></script>
@endpush
