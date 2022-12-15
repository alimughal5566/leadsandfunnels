@include("partials.stats")
@php
    use App\Services\DataRegistry;
    use App\Constants\LP_Constants;
    $data = LP_Helper::getInstance()->getOverlayData();

    $sf = false;
    if(array_key_exists('survey_flag' , DataRegistry::getInstance()->leadpops->clientInfo)){
        $sf = DataRegistry::getInstance()->leadpops->clientInfo['survey_flag'];
    }

    if(!empty($data)){
        $overlaydata=json_decode($data,true);
        LP_Helper::getInstance()->setOverlaySetting();
        $client_train_data=LP_Helper::getInstance()->getOverlaySetting();
@endphp
            @include("partials.leadpops-helper")

            @if(@DataRegistry::getInstance()->leadpops->clientInfo['sticky_bar_v2'] == 1)
                @include("partials.stickybar-v2")
                @include("partials.stats_v2")
            @else
                @include("partials.stickybar")
            @endif
            @if($sf && @DataRegistry::getInstance()->leadpops->skip_survey == 0))
                @include("partials.survey")
            @endif
@php
   }
@endphp

<!--************Email Fire login POPUP************-->
<div class="modal fade lp_modal email-fire-login" id="emailfire">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"> Email Fire Dashboard Login</h3>
            </div>
            <div class="modal-body login-body">
                <div class="row">
                    <form  target="_blank" name="goemma" id="goemma" action="https://app.e2ma.net/app2/login/" method="post"   class="login-wrapper">
                        <div class="form-group login-border">
                            <div class="login-lable">
                                <label class="control-label" for="email">Email Address</label>
                            </div>
                            <div class="">
                                <input type="email"  name = "username" class="form-control fire-control" id="emmaUsername" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="login-lable">
                                <label class="control-label" for="password">Password</label>
                            </div>
                            <div class="">
                                <input type="password" autocomplete="off" rel="" class="form-control fire-control" id="emmaPass" name="password" required>
                            </div>
                        </div>
                        <!--data-toggle="modal" data-target="#email-forgot"-->
                        <div class="forgot"><a href="https://app.e2ma.net/app2/login/" id="emma-forgot-password" target="_blank">Forgot Password ?</a></div>

                        <div class="lp-modal-footer footer-border text-center">

                            <a data-dismiss="modal" class="btn lp-btn-cancel" id="modal-close">Close</a>
                            <!-- <a id="edit_rcpt" class="btn lp-btn-add" href="#">sign in</a>-->
                            <input type="submit" id="edit_rcpt" class="btn lp-btn-add" value ="Sign in">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--************Email Fire Forgot password POPUP************-->

<!-- ===== Status POPUP - Start ===== -->
<div class="modal fade add_recipient home_popup" id="modal_status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Funnel Status</h3>
                <a id="status-lp-video" data-lp-wistia-title="" data-lp-wistia-key="" class="btn-video lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="lp-icon-strip lp-cam-icon"></i><span class="action-title">Watch how to video</span></a>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-pp-wrap">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="funnel-message message-size lp-msg">Select Funnel Status</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-btn-toggle p-active-btn">
                                            <input type="checkbox" id="toggle-status" data-toggle="toggle" data-on="INACTIVE" data-off="ACTIVE" data-onstyle="success" data-offstyle="danger" data-width="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-modal-footer lp-footer-border">
                                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                                <a data-leadpop_version_seq="" data-domain_id="" data-leadpop_id="" data-leadpop_version_id="" class="btn lp-btn-add btnAction_saveStatus">Save</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ===== Status POPUP - Ends ===== -->

<!-- ===== Model Boxes - Unlimited Clone Request - Start ===== -->
<div id="modal_cloneFunnelRequest" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Conversion Funnels Unlimited</h3>
                <!--<a href="javascript:void(0)" data-dismiss="modal" aria-hidden="true" class="modalCloseBtn">&times;</a>-->
            </div>
            <div class="modal-body model-action-body">
                <div class="row lp-lead-modal-action-wrap">
                    <div class="col-sm-12">
                        <div class="notification_landingPages" align="center">
                            Upgrade to Conversion Funnels Unlimited for just {{ setPlanPrice() }} per month to enjoy UNLIMITED amounts of Funnels!<br /><br />
                            <!--                            <a class="btn btn-success" href="-->@php //echo LP_BASE_URL.LP_PATH; @endphp<!--/support?sup=ticket&req=upgrade" target="_blank">Click here to upgrade your account!</a>-->
                            <a class="btn btn-success" id="global_ticket_model_open" href="#">Click here to upgrade your account!</a>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer lp-modal-action-footer">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Unlimited Clone Request - End ===== -->

<!-- ===== Model Boxes - Domain Delete - Start ===== -->
<div id="modal_confirmCloneDelete" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title"></h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-sm-12 modal-action-msg-wrap">
                            <div class="notification_confirmCloneDelete modal-msg"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-footer lp-modal-action-footer">
                <form id="form_confirmCloneDelete" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="current_hash" id="current_hash" value="">
                    <input type="hidden" id="action_confirmCloneDelete" value="" />
                </form>
                <a data-dismiss="modal" class="btn btnCancel_confirmCloneDelete lp-btn-cancel">Close</a>
                <a class="btn lp-btn-add btnAction_confirmCloneDelete">Clone</a>&nbsp;
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Domain Delete - End ===== -->
<!-- ===== Model Boxes - Clone Funnel With Sub Domain - Start ===== -->
<!--Muhammad Zulfiqar-->
<div id="modal_SubdomainCloneFunnel" class="modal fade add_recipient">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Clone Funnel</h3>
            </div>
            <div class="modal-body recipient-body">
                <div class="row">
                    <form id="ClonefunnelSubdomain" action="" method="POST" style="padding-top: 11px;">
                        <input type="hidden" id="SubDomainCloneFunnel" value="clone" />
                        <input type="hidden" name="current_hash" id="current_hash" value="">
                        {{ csrf_field() }}
                        <div class="model_notification" style="display:none;"></div>

                        @if( @DataRegistry::getInstance()->leadpops->clientInfo['dashboard_v2'] == 1 )
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label class="control-label" for="subdomain">Funnel Name</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text"  name="funnel_name" class="form-control custom-control" id="funnel_name" placeholder="Enter the Funnel Name">
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label class="control-label" for="subdomain">Customize Sub-Domain</label>
                                </div>
                                <div class="col-sm-7">
                                    <input type="text"  name="subdomain" class="form-control custom-control" id="subdomain">
                                </div>
                            </div>
                        </div>
                        <div class="form-group textToggleCtrl">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label class="control-label" for="topleveldomain">Top Level Domain</label>
                                </div>
                                <div class="col-sm-7">
                                    <select class="lp-select2 modal-select2" data-style="form-control select-control" id="topleveldomain" name="topleveldomain" data-width = "296px">
                                        @php
                                        $rec = LP_Helper::getInstance()->getTopLevelDomain();
                                        foreach ($rec as $k => $v) {
                                        @endphp
                                        <option value="{{  $v['domain'] }}">{{  $v['domain'] }}</option>
                                        @php
                                        }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="lp-modal-footer footer-border">
                            <a data-dismiss="modal" class="btn lp-btn-cancel" id="modal-close">Close</a>
                            <input type="button" class="btn lp-btn-add btnAction_SubDomainCloneFunnel" value ="Clone & Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Clone Funnel With Sub Domain - End ===== -->
<!-- ===== Model Boxes - Delete Blocked IP - Start ===== -->
<div id="modal_confirmDeleteIp" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Remove IP</h3>
            </div>
            <div class="modal-body modal-body-notif-msg model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-sm-12 modal-action-msg-wrap">
                            <div class="notification_confirmDeleteIp">Remove IP Address from block list.</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="lp-modal-footer lp-modal-action-footer">
                <form id="form_confirmDeleteIp" method="post" action="">
                    <input type="hidden" id="action_confirmDeleteIp" value="" />
                </form>
                <a data-dismiss="modal" class="btn btnCancel_confirmDeleteIp lp-btn-cancel">Close</a>
                <a class="btn lp-btn-add btnAction_confirmDeleteIp">Remove</a>&nbsp;
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Delete Blocked IP - End ===== -->

<!-- ===== Model Boxes - Landing Pages leadPops Call - Start ===== -->
<div id="modal_landingPages" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Landing Pages</h3>
                <!--<a href="javascript:void(0)" data-dismiss="modal" aria-hidden="true" class="modalCloseBtn">&times;</a>-->
            </div>
            <div class="modal-body model-action-body">
                <div class="row lp-lead-modal-action-wrap">
                    <div class="col-sm-12">
                        <div class="notification_landingPages" align="center">
                            We'd love to talk to you about leadPops high-converting landing pages.<br /><br />
                            <a class="btn btn-success" href="{{  LP_Constants::URL_TO_SCHEDULE_LEADPOP_CALL }}" target="_blank">Click here to schedule a call with us.</a>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer lp-modal-action-footer">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Landing Pages leadPops Call - End ===== -->

<!-- ===== Model Boxes - Stats Warning Start ===== -->
<div id="modal_statsWarning" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Stats Alert</h3>
                <!--<a href="javascript:void(0)" data-dismiss="modal" aria-hidden="true" class="modalCloseBtn">&times;</a>-->
            </div>
            <div class="modal-body model-action-body">
                <div class="row lp-lead-modal-action-wrap">
                    <div class="col-sm-12">
                        <div class="notification_statsWarning" align="center">
                            The graph and advanced stats processing is a new feature that was implemented on 10/31/17.<br /><br />Prior data cannot be processed/shown this way.
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer lp-modal-action-footer">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Stats Warning End ===== -->

<!-- ===== Model Boxes - Mortgage Website Funnels leadPops Call - Start ===== -->
<div id="modal_mortgageWebsiteFunnel" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content modal-action-header">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">leadPops ConversionPro<i style="font-size:10px;vertical-align: text-top;" class="fa fa-trademark" aria-hidden="true"></i> <span class="modal_mortgageWebsiteFunnel_client_type"></span> Websites</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="row lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="col-sm-12">
                        <div class="notification_mortgageWebsiteFunnel" align="center">
                            We'd love to talk to you about leadPops ConversionPro <i style="font-size:10px;vertical-align: text-top;" class="fa fa-trademark" aria-hidden="true"></i><span class="modal_mortgageWebsiteFunnel_client_type"></span> Websites.<br /><br />
                            <a class="btn btn-success" href="{{  LP_Constants::URL_TO_SCHEDULE_LEADPOP_CALL }}" target="_blank">Click here to schedule a call with us.</a>
                        </div>
                    </div>
                </div>

                <div class="lp-modal-footer lp-modal-action-footer">
                    <a class="btn lp-btn-cancel" id="website_funnel_modal_hide">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Mortgage Website Funnels leadPops Call - End ===== -->

<!--FOOTER-->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="footer">
                    <a id="f-logo" href="#"><img src="{{  LP_ASSETS_PATH }}/adminimages/footer-logo.png"></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- ===== Performance Reporting - Start ===== -->
<div class="modal fade add_recipient home_popup" id="modal_performance_reporting">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Performance Reporting</h3>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="add-code-popup" class="form-inline lp-popup-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-pp-wrap">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="funnel-message message-size lp-msg">
                                            Would you like to register for the leadPops Performance Reporting Portal?<br /><br />
                                            There is no additional cost, and you'll get access to a treasure trove of additional resources!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-modal-footer lp-footer-border">
                                <a data-dismiss="modal" class="btn lp-btn-cancel">No, not at this time</a>
                                <a class="btn lp-btn-add btnAction_sync_portal">Yes, let me in!</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ===== Performance Reporting - Ends ===== -->

<!-- ===== Model Boxes - Performance Reporting Success - Start ===== -->
<div id="modal_confirmPeromanceReportingMessage" class="modal fade lp-modal-box in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title" id="pr_title"></h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap ">
                    <div class="row">
                        <div class="col-sm-12 modal-action-msg-wrap rp">
                            <div class="modal-msg" id="pr_msg"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-footer lp-modal-action-footer">
                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- ===== Model Boxes - Performance Reporting Success- End ===== -->
<div class="lp-lead-layer rp_loader" id="loader-reporting" >
    <div class="middle"></div>
    <div class="lead-layer-text"><i class="fa fa-spinner fa-spin"></i>Please wait processing data ...</div>
</div>

