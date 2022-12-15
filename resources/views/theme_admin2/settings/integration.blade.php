@extends("layouts.leadpops")

@section('content')
    @php
        use Illuminate\Support\Facades\Session;

        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        } else {
            $firstkey = "";
        }

        $clientData  = LP_Helper::getInstance()->getDirectClientInfo();
        $hasTotalExpert = LP_Helper::getInstance()->getTotalExpertInfo();

        $teHasActivated = "no"; // default not authorized
        $teCurrentStatus = "inactive"; // status in DB
        $active_inactive_checked = ""; // UI default no
        if (is_array($hasTotalExpert) && count($hasTotalExpert) > 0) { // has authorized
           if ($hasTotalExpert[0]["active"] == 1) {
               $teHasActivated = "yes";
               $teCurrentStatus = "active";
               $active_inactive_checked = "checked='checked'";
           }
        }
        Session::put('totalExpertHash', @$view->data->currenthash);
        $scope = "postLeads+leadSurveyInteraction";
        $session_id = session()->getId();

        $hasHomebot = LP_Helper::getInstance()->getHomebotInfo();
        $homebotHasActivated = "no"; // default not authorized
        $homebotCurrentStatus = "inactive"; // status in DB
        $homebot_active_inactive_checked = ""; // UI default no


        if (count($hasHomebot) > 0) { // has authorized

           if ($hasHomebot[0]["active"] == 1) {
               $homebotHasActivated = "yes";
               $homebotCurrentStatus = "active";
               $homebot_active_inactive_checked = "checked='checked'";
           }
        }
        Session::put('homebotExpertHash', @$view->data->currenthash);

    @endphp
    <section id="">
        <div class="container">
            @php  LP_Helper::getInstance()->getFunnelHeader($view); @endphp
            <div id="integration" class="">
                <form id="createauthkey" enctype="multipart/form-data" action="{{ LP_BASE_URL.LP_PATH.'/popadmin/createauthkey' }}" method="post">
                    <input type="hidden" name="client_id" id="client_id" value="{{ @$view->data->client_id }}">
                    <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                    <input type="hidden" name="te_activated" id="te_activated" value="{{ $teHasActivated }}">
                    <input type="hidden" name="te_status" id="te_status" value="{{ $teCurrentStatus }}">
                    <input type="hidden" name="homebot_activated" id="homebot_activated" value="{{ $homebotHasActivated }}">
                    <input type="hidden" name="homebot_status" id="homebot_status" value="{{ $homebotCurrentStatus }}">
                </form>

                <div id="clip-msg"></div><br />

                <div class="panel-group" id="accordion">

                    <!-- leadPops Auathorization Accordion -->
                    <div class="panel custom-accordion">
                        <div class="panel-heading">
                            <div class="lp-domain-wrapper integration-head">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                        <i class="lp_radio_icon_lg"></i>
                                        leadPops API Authorization Key</a>
                                </h4>
                            </div>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="item-wrapp">
                                <div class="input-wrapp">
                                    <div class="lp-seo integration">
                                        <div class="lp-seo-head">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="lp-seo-box integration">
                                                        <input disabled class="lp-tg-textbox valid" id="lp_auth_access_key" value="{{ (@$view->data->LeadpopAccessToken ? @$view->data->LeadpopAccessToken : "") }}" aria-required="true" aria-invalid="false" readonly type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="lp-seo-box__ integration__">
                                                        <a href="#" id="lp_auth_access_btn" class="btn lp-btn-success">{{ (@$view->data->LeadpopAccessToken ? "Re-Generate Key" : "Generate Key") }}</a>
                                                        <a href="#" id="lp_auth_access_code_copy" class="btn lp-btn-primary">Copy to Clipboard</a>
                                                        <a class="btn btn-small lp-btn-success lp-secondary-clr" target="_blank" href="https://documenter.getpostman.com/view/140573/leadpops-leads-api-production/6fbSMwY">leadPops API Documentation</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- leadPops Auathorization Accordion - Ends -->

                    <!-- Zapier Accordion -->
                    <div class="panel custom-accordion integration-panel">
                        <div class="panel-heading">
                            <div class="lp-domain-wrapper int-head">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                        <i class="lp_radio_icon_lg"></i>
                                        Zapier Integration</a>
                                </h4>
                            </div>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="">
                                <div class="tab-title">
                                    <p>- To integrate Zapier with leadPops Funnels you need an authorization token for your account.</p>
                                    <p>- While creating a Zap, this authorization token will be asked by Zapier to identify your account.</p>
                                </div>
                                <div>
                                    <div class="item-wrapp">
                                        <div class="input-wrapp">
                                            <div class="lp-seo">
                                                <div class="lp-seo-head">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-left">
                                                                <h2 class="lp-heading-2">leadPops Authorization Key</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="lp-seo-box">
                                                                <input disabled class="lp-tg-textbox valid" id="zapier_access_key" value="{{ (@$view->data->clientToken ? @$view->data->clientToken : "") }}" aria-required="true" aria-invalid="false" readonly type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="lp-seo-box__ integration__">
                                                                <a href="#" id="zapierKeyBtn" class="btn lp-btn-success">{{ (@$view->data->clientToken ? "Re-Generate Key" : "Generate Key") }}</a>
                                                                <a href="#" id="zapierKeyBtn_copy" class="btn lp-btn-primary">Copy to Clipboard</a>
                                                                <input type="hidden" name="zapier_integrations" id="zapier_integrations" value="{{ @$view->data->integrations }}" />
                                                                <a href="#" data-toggle="modal" class="btn lp-btn-success zapier-funnel-selector lp-secondary-clr" data-target="#funnel-selector"><i class="fa fa-cog"></i> Select Funnels for Zapier</a>
                                                                <a href="#" data-toggle="modal" class="btn lp-btn-success zapier-funnel-selector lp-secondary-clr" data-target="#lp_zap_templates"><i class="fa fa-cog"></i> Pre-configured Zaps</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Zapier Accordion - Ends -->

                    <!-- Movement Mortgage Total Expert Starts -->
                    <div class="panel custom-accordion integration-panel">
                        <div class="panel-heading">
                            <div class="lp-domain-wrapper int-head">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                        <i class="lp_radio_icon_lg"></i>
                                        Total Expert Integration <span style="color: #ff6666">{{ Session::get('totalExpertError') }}</span></a>
                                </h4>

                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="custom-btn-toggle">
                                        <input id="activedeactivebtn" {!! $active_inactive_checked !!} data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                        <div style="display: none; float:right; border: 1px solid #ff6666">
                                            @php
                                                $te_link = "https://public.totalexpert.net/v1/authorize?response_type=code&client_id=leadpops&scope=". $scope." &state=". $session_id;
                                                if((isset($_COOKIE['sso_te']) && $_COOKIE['sso_te'] == 1) || @$view->data->client_id = 10604){
                                                    $te_link = "https://totalexpert.net/authorize?response_type=code&client_id=leadpops&scope=". $scope." &state=". $session_id;
                                                }
                                            @endphp
                                            <a id="teactivate" style="color: #000 !important; transition: none !important;" href="{{ $te_link }}">For Surveys Click Here</a></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Movement Mortgage Total Expert Ends -->

                    <!-- Homebot Starts -->
                    <div class="panel custom-accordion integration-panel">
                        <div class="panel-heading">
                            <div class="lp-domain-wrapper int-head">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                        <i class="lp_radio_icon_lg"></i>
                                        Homebot Integration <span style="color: #ff6666">{{ Session::get('homebotError') }}</span></a>
                                </h4>

                                <div id="collapse4" class="panel-collapse collapse">
                                    <div class="custom-btn-toggle">
                                        <input id="homebotactivedeactivebtn" <?php  echo $homebot_active_inactive_checked; ?> data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                        <div style="display: none; float:right; border: 1px solid #ff6666"><a id="homebotactivate" style="color: #000 !important; transition: none !important;" href="https://api.homebotapp.com/oauth/authorize?response_type=code&client_id=GGZbPSDB6P06ZEpNPaMzuN3AqqANnwsNnS0iNPT0B5U&redirect_uri=https://myleads.leadpops.com/api/homebot.php&state={{ $session_id }}">For Homebot Click Here</a></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Homebot Ends -->

</div>

</div>
</div>
</section>
@include('partials.watch_video_popup')
@include('partials.funnelselector')
@endsection
