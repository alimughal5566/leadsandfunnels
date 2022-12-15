@extends("layouts.leadpops-inner-sidebar")
@section('content')
    @php
    use App\Services\DataRegistry;
    $param = isset($_GET['app_theme'])?'?app_theme='.$_GET['app_theme']:'';
    $hash = LP_Helper::getInstance()->getFunnelData()["funnel"]['hash'];
    $integration_apps = config('integrations.iapp');
    $hasHomebot = LP_Helper::getInstance()->getHomebotInfo();
    $hasTotalExpert = LP_Helper::getInstance()->getTotalExpertInfo();

    $integrations = array();
    foreach($integration_apps as $i=>$app){
        $is_active = false;
        if(!$app['active']) continue;
        if( $app['sysname'] == config('integrations.iapp.LEADPOPS_AUTH')['sysname'] && @$view->data->zapLpIntegrations['lp_access_token'] !="") $is_active = true;
        else if($app['sysname'] == config('integrations.iapp.HOMEBOT')['sysname'] && (count($hasHomebot)>0 && $hasHomebot[0]['active']==1) && @$view->data->activeFunnelClientIntegrations[$app['sysname']]) $is_active = true;
        else if($app['sysname'] == config('integrations.iapp.TOTAL_EXPERT')['sysname'] && (count($hasTotalExpert)>0 && $hasTotalExpert[0]['active']==1) && @$view->data->activeFunnelClientIntegrations[$app['sysname']]) $is_active = true;
        else if($app['sysname'] == config('integrations.iapp.ZAPIER')['sysname'] && @$view->data->activeFunnelClientIntegrations[$app['sysname']]) $is_active = true;

        $app['is_active'] = $is_active;
        $integrations[$i] = $app;
    }

    @endphp
    <main class="main">
        <section class="main-content">
        {{LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view)}}
        @include("partials.flashmsgs")
            <div class="integration">
                <div class="integration__row">
                    @foreach($integrations as $integration)
                    <div class="integration__grid">
                        <div class="integration__link-wrap">
                            <a class="integration__link @if($integration["is_active"]) {{ 'integration__box_active' }} @else {{ '' }} @endif" href="{{LP_BASE_URL.LP_PATH.'/popadmin/integrate/'.$integration['sysname'].'/'.$hash.$param}}">
                                <div class="integration__box">
                                    <div class="integration__logo">
                                        <img src="https://images.lp-images1.com/default/images/{{ $integration['logo'] }}" alt="{{$integration['name']}} Logo">
                                    </div>
                                    <h2 class="integration__name">
                                        {{$integration['name']}}
                                    </h2>
                                    <div class="integration__check-box">
                                        <i class="ico ico-check"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="footer">
                @include("partials.footerlogo")
            </div>
            </section>
        </main>
        <div class="modal fade api-key-popup"  data-backdrop="static"  id="api-key-popup">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">API Authorization Key</h5>
                    </div>
                    <div class="modal-body">
                        <div class="api-key-field-holder copy-btn-area">
                            <div class="input-holder">
                                <input disabled class="form-control" id="lp_auth_access_key" value="{{ (@$view->data->LeadpopAccessToken ? @$view->data->LeadpopAccessToken : "") }}" aria-required="true" aria-invalid="false" readonly type="text">
                                <label for="lp_auth_access_key"><i class="ico-key"></i></label>
                                <span class="copy-text" >{{  (@$view->data->LeadpopAccessToken ? @$view->data->LeadpopAccessToken : "") }}</span>
                            </div>
                            <button  type="button" id="lp_auth_access_btn" class="button button-secondary">{{ (@$view->data->LeadpopAccessToken ? "Re-Generate Key" : "Generate Key") }}</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="link-wrap"><a href="https://documenter.getpostman.com/view/140573/leadpops-leads-api-production/6fbSMwY" target="_blank" class="api-link">leadpops api documentation</a></span>
                        <ul class="btns-list">
                            <li>
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li>
                                <button type="button" id="lp_auth_access_code_copy" class="button button-primary copy-btn" {{(@$view->data->LeadpopAccessToken ? "" : "disabled") }}>copy to clipboard</button>
                            </li>
                        </ul>
                        <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                        <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                    </div>
                </div>
            </div>
        </div>

    @include("partials.funnelselector")
@endsection
@push('footerScripts')
    <script src="{{ config('view.theme_assets') }}/pages/integration.js?v={{ LP_VERSION }}"></script>
@endpush
