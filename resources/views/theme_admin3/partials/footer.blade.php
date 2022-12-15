</div>
</div>
@php
    use App\Constants\LP_Constants;
    use App\Models\LynxlyLinks;
    $route = Request::route()->getName();
        //  @include ("includes/global-settings/modals-global-setting.php");
@endphp

@include("partials.stickybar")
<!-- include custom JavaScript -->

<script src="{{ config('view.theme_assets') }}/js/jquery-3.4.1.min.js?v={{ LP_VERSION }}"></script>
<script src="{{ config('view.theme_assets') }}/js/migrate.-1.4.1.min.js?v={{ LP_VERSION }}"></script>
@php
    if (@$view->footer) {
        LP_Helper::getInstance()->get_overlay_detail();
        $items = LP_Helper::getInstance()->getOverlayData();
        if($items){
          $items = $items;
        }else{
          $items = '';
        }
    }
$lynxly_data =  LynxlyLinks::where('clients_leadpops_id', @$view->data->funnelData['client_leadpop_id'])->first() || null;
$lynxly_data = $lynxly_data? json_encode($lynxly_data): null
@endphp
<!-- include jQuery library -->
<script type="text/javascript">
    var ajax_token = '{{ csrf_token() }}';
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var site = {
        baseUrl: "{{ LP_BASE_URL }}",
        baseDir: "{{ public_path() }}",
        lpPath: "{{ LP_PATH }}",
        lpAssetsPath: "{{ LP_ASSETS_PATH }}",
        rackspaceDefaultImages: '{{ RACKSPACE_DEFAULT_IMAGES_URI }}',
        items: '{!! $items !!}',
        version: "{{LP_VERSION}}",
        route: "{{$route}}",
        showAdvance: "{{env('SHOW_ADVANCE', false)}}",
        screenshotServiceUrl: "{!! env('SCREENSHOT_SERVICE_URL', '/uploads/screenshots') !!}",
        stickyBarScriptDomain: "{!! env('STICKY_BAR_SCRIPT_DOMAIN','https://embed.clix.ly') !!}",
        stickyBarDefaultText: "{!! env('STICKY_BAR_DEFAULT_TEXT', 'I am you sticky bar and I am being awesome') !!}",
        clientID: "{{ $view->session->clientInfo->client_id }}",
        shortenerAppBaseUrl: "{{config('urlshortener.app_base_url')}}",
        allShortLinks: {!! json_encode(LP_Helper::getInstance()->getAllShortLinksForClient()) !!},
        app_env: "{{env('APP_ENV')}}",
        env_production: "{{config('app.env_production')}}"
    };
    var funnel_json = '{!! addslashes(json_encode(LP_Helper::getInstance()->getAllFunnel() , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
    var client_type = '{{ $view->session->clientInfo->client_type }}';
    var vertical_id = '{{ \App\Constants\LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES }}';
    var funnel_url = '{{ LP_Helper::getInstance()->getFunnelUrlTag() }}';
    var clone_flag = '{{ LP_Helper::getInstance()->getCloneFlag() }}';
    var stickybar_flag = '{{ $view->session->clientInfo->stickybar_flag }}';
    var funnel_perPage = '{{ @$view->session->tag_filter->perPage }}';
    var funnel_page = '{{ @$view->session->tag_filter->page }}';
    var folder_list = '{!! json_encode(folder_list()) !!}';
    var tag_list = '{!! json_encode(tag_list()) !!}';
    var funnelData = '{!! json_encode(@$view->data->funnelData ,JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS) ?? [] !!}';
    var funnel_hash = '{{ property_exists($view->data, 'funnelData') ? (isset($view->data->funnelData['hash']) ? $view->data->funnelData['hash'] : $view->data->funnelData['current_hash']) : '' }}';
    var exclude = '{!! (isset($view->session->tag_filter->filterFunnelVisitor))?$view->session->tag_filter->filterFunnelVisitor:config('lp.funnel_visitor') !!}';
    var visitor = '{!! @$view->session->tag_filter->excludeVisitor !!}';
    var exclude_ConversionRate = '{{ @$view->session->tag_filter->excludeConversionRate }}';
    var filter_conversion_rate = '{!! (isset($view->session->tag_filter->filterConversionRate) and $view->session->tag_filter->filterConversionRate !== 'undefined')?$view->session->tag_filter->filterConversionRate:config('lp.conversion_rate') !!}';
    var validationConfig = JSON.parse("{{json_encode(config('validation'))}}".replace(/&quot;/g,'"'));
    var lpkey = '{{@$view->data->lpkeys}}';
    var lynxly_data = '{!! $lynxly_data !!}';
    var hasWebsite = '{{ count(dashboardEmptyFolderSkip('w'))}}';
    var cloneFunnelNumber = '{{getFunnelCloneNumber()}}';
    var funnelCloneLimit  = '{{config('lp.funnel_clone_limit')}}';
    var page = window.location.pathname.split('/');
    var active_super_footer  = '{{config('lp.active_super_footer')}}';
    var phone_number = '{{ $view->session->clientInfo->phone_number }}';
    var contact_email = '{{ $view->session->clientInfo->contact_email }}';
    var contact_full_name = '{{ $view->session->clientInfo->first_name }} {{ $view->session->clientInfo->last_name }}';
    var froala_key = '{{config('lp.froala_editor.froala_editor_key')}}';
    var lp_helper_font_families = JSON.parse('{!! LP_Helper::getInstance()->getFontFamilies(true) !!}');
</script>
<script src="//fast.wistia.com/assets/external/E-v1.js?v={{ LP_VERSION }}" charset="ISO-8859-1"></script>
@if(@$route != "EditSecurityMessagesFromPage"){
<script src="{{ config('view.theme_assets') }}/js/security_messages/security-message-popup.js?v={{ LP_VERSION }}"></script>
@endif
@if(in_array($route,array('funnel-builder')))
    <script src="{{ config('view.theme_assets') }}/js/funnel-builder-scripts.min.js?v={{ LP_VERSION }}"></script>
@else
    <script src="{{ config('view.theme_assets') }}/js/global.min.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/external-script.min.js?v={{ LP_VERSION }}"></script>
@endif

@php
if(in_array(app('request')->route()->getAction()['as'],config('lp.cta_button_show_super_footer'))){
@endphp
<script src="{{ config('view.theme_assets') }}/external/froala-editor/js/super_footer_cta_link.js?v={{ LP_VERSION }}"></script>
@php
} else if(!in_array(app('request')->route()->getAction()['as'], array('branding'))) {
@endphp
<script src="{{ config('view.theme_assets') }}/external/froala-editor/js/cta_link.js?v={{ LP_VERSION }}"></script>
@php
}
@endphp
@if(!in_array($route,array('dashboard','branding')))
<script src="{{ config('view.theme_assets') }}/external/froala-editor/js/froala-custom.js?v={{ LP_VERSION }}"></script>
@endif

<script src="//fast.wistia.com/assets/external/E-v1.js?v={{ LP_VERSION }}" charset="ISO-8859-1"></script>
<script src="{{ config('view.theme_assets') }}/external/wista/wista-player.js?v={{ LP_VERSION }}"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script src="{{ config('view.theme_assets') }}/js/top-search.js?v={{ LP_VERSION }}"></script>
@if(in_array($route,array('branding')))
    <script src="{{ config('view.theme_assets') }}/external/dropzone/dropzone.js?v={{ LP_VERSION }}"></script>
@endif

<script src="{{ config('view.theme_assets') }}/js/custom.js?v={{ LP_VERSION }}"></script>

<script type="text/javascript">
    @php
        LP_Helper::getInstance()->get_overlay_detail();
        $items = LP_Helper::getInstance()->getOverlayData()?LP_Helper::getInstance()->getOverlayData():'';
    @endphp

    @if(in_array($route,array('funnel-builder')))
    $('.funnel-info-tag').hide();
    var GLOBAL_MODE = false;
    @else
        $(document).ready(function () {
            let mode = parseInt(localStorage.getItem('mode'));
            let _selectedGlobalFunnel  = localStorage.getItem('selectedFunnels');
            $("#_selectedGlobalFunnel").val(_selectedGlobalFunnel);
            adjustGlobalHeaderState( mode, '[name="global_mode_bar"]', "{{$route}}");
            if(mode){
                $('#global_checkbox_bar #global_mode_bar').bootstrapToggle('on');
                globalModalObj.previousMode = 1;
                var data = _selectedGlobalFunnel;
                var selectedFunnels =  JSON.parse(data.replace(/&quot;/g,'"'));
                window.selectedFunnels = selectedFunnels;


                if(selectedFunnels.length){
                    // selected funnels save btn
                    $("#funnelListingModalFinish").show();
                } else {
                    $("#funnelListingModalFinish").hide();
                }
            } else {
                $('.global__bar').slideUp(0);
            }
        });
    @endif
    </script>

@foreach ($view->assets_js as $js)
    <script type="text/javascript" src="{{ $js."?v=".LP_VERSION }}"></script>
@endforeach


<!-- Footer JavaScript Resources -->

@includeWhen(request()->get('toast') == "show", "partials.toast-sample")
@stack('footerScripts')

<!-- ===== Model Boxes - Domain Delete - Start ===== -->
<div class="modal fade confirmation-delete" data-backdrop="static"  id="modal_confirmCloneDelete">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form_confirmCloneDelete" method="post" action="">
                {{ csrf_field() }}
                <input type="hidden" name="current_hash" id="current_hash" value="">
                <input type="hidden" id="action_confirmCloneDelete" value=""/>
            </form>
            <div class="modal-header">
                <h5 class="modal-title">Delete Funnel</h5>
            </div>
            <div class="modal-body">
                <div class="modal-msg modal-msg_light">
                    You're about to delete <b>203K Hybrid Loans.</b> <br>
                    It'll be gone forever and we won't be able to recover it.
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No,
                                Never Mind
                            </button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary btnAction_confirmCloneDelete"
                                    type="submit">Yes, Delete
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Domain Delete - End ===== -->

<!-- ===== Model Boxes - Clone Funnel With Sub Domain - Start ===== -->
<div class="modal fade" data-backdrop="static"  id="modal_SubdomainCloneFunnel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content clone-new-tag">
            <form id="ClonefunnelSubdomain" action="" method="post" class="form-pop">
                <input type="hidden" id="SubDomainCloneFunnel" value="clone"/>
                <input type="hidden" name="current_hash" id="current_hash" value="">
                {{ csrf_field() }}
                <div class="model_notification" style="display:none;"></div>
                <div class="modal-header">
                    <h5 class="modal-title">Clone Funnel</h5>
                </div>
                <div class="modal-body quick-scroll">
                    <div class="form-group">
                        <label for="funnel-name" class="modal-lbl">New Funnel Name</label>
                        <div class="input__holder">
                            <input type="text" name="funnel_name" id="clone_funnel_name" placeholder="Enter the Funnel Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="funnel-name" class="modal-lbl">Funnel Tag(s)</label>
                        <div class="input__holder lp-tag lp-tag-scroll quick-scroll">
                            <div class="select2js__tags-parent tag-result-common clone-tag-result w-100">
                                <select id="clone_tag_list" class="form-control tag_list clone-tag-drop-down" multiple name="tag_list[]">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-0">
                        <label for="funnel-name" class="modal-lbl">Folder</label>
                        <div class="select2js__folder-parent w-100 select2js__nice-scroll">
                            <select class="select2js__folder" name="folder_id" id="clone_folder_list">
                                @php
                                    $rec = folder_list();
                                    foreach ($rec as $k => $v) {
                                         if(isset($v->is_website) and $v->is_website == 1){
                                           $vl = 'w';
                                          }else{
                                           $vl = $v->id;
                                          }
                                @endphp
                                <option value="{{  $v->id }}"  data-value="{{ $vl }}">{{  $v->folder_name }}</option>
                                @php
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="funnel-name" class="modal-lbl">Customize Sub-Domain</label>
                        <div class="input__holder">
                            <input type="text" name="subdomain" id="customzie_subdomain">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="funnel-name" class="modal-lbl">Top Level Domain</label>
                        <div class="input__holder">
                            <div class="select2js__lvl-domain-parent w-100 select2js__nice-scroll">
                                <select class="select2js__lvl-domain" id="topleveldomain" name="topleveldomain">
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
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                    Close
                                </button>
                            </li>
                            <li class="action__item">
                                <button type="button"
                                        class="button button-bold button-primary btnAction_SubDomainCloneFunnel">Clone &
                                    Save
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Clone Funnel With Sub Domain - End ===== -->

<!-- ===== Model Boxes - Funnel Status - Start ===== -->
<div class="modal fade" data-backdrop="static"  id="modal_status">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="status-modal" action="" method="get" class="form-pop">
                <div class="modal-header">
                    <h5 class="modal-title">Funnel Status</h5>
                    <a data-lp-wistia-title="Funnel Status" data-lp-wistia-key="mew5a0176b" class="video-link lp-wistia-video" href="#" data-dismiss="modal" data-toggle="modal" data-target="#lp-video-modal">
                        <span class="icon ico-video"></span> WATCH HOW-TO VIDEO</a>
                </div>
                <div class="modal-body">
                    <div class="form-group justify-content-between m-0">
                        <label for="modal_email" class="modal-lbl funnel-message">Select Funnel Status</label>
                        <input id="toggle-status" name="toggle-status" data-toggle="toggle"
                               data-onstyle="active" data-offstyle="inactive"
                               data-width="127" data-height="43" data-on="INACTIVE"
                               data-off="ACTIVE" type="checkbox" checked>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action d-flex justify-content-between w-100 align-items-center">
                        <span class="btn__back-pop">delete funnel</span>
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                        Close
                                    </button>
                                </li>
                                <li class="action__item">
                                    <button type="button"
                                            class="button button-bold button-primary btnAction_saveStatus">Save
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- ===== Model Boxes -  Funnel Status - End ===== -->

<!-- ===== Model Boxes - Unlimited Clone Request - Start ===== -->

<!--clone feature modal-->
<div class="modal fade clone-feature-modal" data-backdrop="static"  id="modal_cloneFunnelRequest">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><i class="ico ico-cross"></i></button>
            <div class="modal-body">
                <div class="funnel-plan-section">
                    <div class="funnel-plan-section__logo-area">
                        <strong class="funnel-plan-section__logo">
                            <a href="dashboard.php"><img src="{{ config('view.rackspace_default_images') }}/large-logo-white.png" title="LeadPops" alt="LeadPops"></a>
                        </strong>
                    </div>
                    <div class="funnel-plan-section__content">
                        <h2>Level up your marketing with <span>Unlimited Funnels</span></h2>
                        <div class="funnel-plan-section__quote-area">
                            <div class="funnel-plan-section__wrap">
                                <div class="funnel-plan-section__image">
                                    <img src="{{ config('view.rackspace_default_images') }}/enrique-braunschweiger.png" title="Enrique Braunschweiger" alt="Enrique Braunschweiger">
                                </div>
                                <blockquote>
                                    <q>“ I put a leadPops Funnels on ANYTHING that moves! ”</q>
                                    <cite>
                                        <span class="name">Enrique Braunschweiger</span>
                                        <span class="desination">First West Financial Corporation</span>
                                    </cite>
                                </blockquote>
                            </div>
                            <a href="#clone-feature-modal-price" data-toggle="modal" data-dismiss="modal" class="button button-plan">Upgrade My Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $planPrices = \App\Helpers\ChargeBeeHelpers::getClientPlansPricesData();
    $marketerPlanPrice = convertCentsToDollarsString($planPrices['marketer']);
    $proPlanPrice = convertCentsToDollarsString($planPrices['pro']);
    $yearlyProPlanPrice = convertCentsToDollarsString($planPrices['pro_yearly']);
@endphp

<div class="modal fade clone-feature-modal plan" data-backdrop="static"  id="clone-feature-modal-price">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><i class="ico ico-cross"></i></button>
            <div class="modal-body">
                <div class="upgrade-plan-area">
                    <h2>Upgrade your plan to unlock <span>Unlimited Funnels</span></h2>
                    <div class="nav-tabs-wrap">
                        <ul class="nav nav-tabs plan-tabs">
                            <li>
                                <a class="active" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="true">Monthly</a>
                            </li>
                            <li>
                                <a id="annually-tab" data-toggle="tab" href="#annually" role="tab" aria-controls="annually" aria-selected="false">Annually</a>
                            </li>
                            <li class="bg-animation"></li>
                        </ul>
                        <div class="upgrade-plan-area__discount-info">
                            <span class="upgrade-plan-area__text">Save 20%</span>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                            <div class="upgrade-plan-area__package-row-wrap">
                                <i class="arrow"></i>
                                <div class="upgrade-plan-area__package-row">
                                    <div class="upgrade-plan-area__package-col">
                                        <div class="upgrade-plan-area__content">
                                            <div class="upgrade-plan-area__heading">
                                                <h3>Marketer</h3>
                                                <span class="upgrade-plan-area__sub-text">35 Premade Funnels</span>
                                            </div>
                                            <div class="upgrade-plan-area__price-info">
                                                <strong class="price">${{ $marketerPlanPrice }}</strong>
                                                <span class="price-text">per month</span>
                                            </div>
                                            <a href="#" class="button button-plan disabled">Current Plan</a>
                                        </div>
                                        <div class="upgrade-plan-area__list-holder">
                                            <ul class="upgrade-plan-area__list">
                                                <li><span class="list-text"><i class="ico-check"></i>Access to optimized Funnels</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Access to Sticky Bar Builder</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Unlimited traffic & leads</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="upgrade-plan-area__package-col">
                                        <div class="upgrade-plan-area__content">
                                            <div class="upgrade-plan-area__heading">
                                                <h3>Pro</h3>
                                                <span class="upgrade-plan-area__sub-text">Yup, Unlimited Funnels</span>
                                            </div>
                                            <div class="upgrade-plan-area__price-info">
                                                <strong class="price">${{ $proPlanPrice }}</strong>
                                                <span class="price-text">per month</span>
                                            </div>
                                            <a href="#" class="button button-plan client-upgrade-plan-to-pro" data-plan-period="monthly">Upgrade My Plan</a>
                                        </div>
                                        <div class="upgrade-plan-area__list-holder">
                                            <ul class="upgrade-plan-area__list">
                                                <li><span class="list-heading">Everything in Marketer, plus:</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Clone feature gives you UNLIMITED Lead Funnels & Sticky Bars</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="annually" role="tabpanel" aria-labelledby="annually-tab">
                            <div class="upgrade-plan-area__package-row-wrap annually">
                                <i class="arrow"></i>
                                <div class="upgrade-plan-area__package-row">
                                    <div class="upgrade-plan-area__package-col">
                                        <div class="upgrade-plan-area__content">
                                            <div class="upgrade-plan-area__heading">
                                                <h3>Pro</h3>
                                                <span class="upgrade-plan-area__sub-text">Yup, Unlimited Funnels</span>
                                            </div>
                                            <div class="upgrade-plan-area__price-info">
                                                <strong class="price">${{ $yearlyProPlanPrice }}</strong>
                                                <span class="price-text">per year</span>
                                            </div>
                                            <a href="#" class="button button-plan client-upgrade-plan-to-pro" data-plan-period="yearly">Upgrade My Plan</a>
                                        </div>
                                        <div class="upgrade-plan-area__list-holder">
                                            <ul class="upgrade-plan-area__list">
                                                <li><span class="list-heading">Everything in Marketer, plus:</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Clone feature gives you UNLIMITED Lead Funnels & Sticky Bars</span></li>
                                            </ul>
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

<!-- ===== Model Boxes - Unlimited Clone Request - End ===== -->

<!-- ===== Model Boxes - Support Request - Start ===== -->
@php
if($route != 'support'){
@endphp
<div class="modal fade" data-backdrop="static"  id="modal_submitSupportRequest">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form name="lp-support-form" id="lp-support-form" method="post" action="{{ LP_PATH }}/support/feed" class="form-horizontal form-pop">
                <input type="hidden" name="issuedatainfo" id="global_issuedatainfo" value='{{ json_encode($view->data->global_subissuedata) }}'>
                <div class="modal-header">
                    <h5 class="modal-title">Submit a Support Request</h5>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-group">
                                <label class="modal-lbl" for="category">
                                    Category
                                </label>
                                <div class="input__holder">
                                    <div class="global_maintopic-parent w-100">
                                        <select name="maintopic" id="global_maintopic">
                                            <option value="">Select Category</option>
                                            @php
                                                $first_key="";
                                                foreach ($view->data->global_maintopic as $key => $title) {
                                                if($first_key=="") $first_key=$key;
                                                if(isset($view->data->request) && $key == $view->data->request['type']) $sel_attr = " selected";
                                                else $sel_attr = "";
                                            @endphp
                                            <option value="{{ $key }}"{{ $sel_attr }}>{{ $title }}</option>
                                            @php } @endphp
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="modal-lbl" for="topic">
                                    Topic
                                </label>
                                <div class="input__holder">
                                    <div class="global_mainissue-parent w-100">
                                        <select name="mainissue" id="global_mainissue" disabled>
                                            <option value="">Select Topic</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="modal-lbl" for="subject">Subject</label>
                        <div class="input__holder">
                            <input class="form-control" value="" name="subject" id="global_subject" type="text">

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input__holder">
                            <textarea name="message" id="global_message" aria-required="true" aria-invalid="false"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">
                                    Close
                                </button>
                            </li>
                            <li class="action__item">
                                <button type="submit" class="button button-bold button-secondary" id="global_btn-spt-form">
                                    Submit
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@php
}
@endphp
<!-- ===== Model Boxes - Support Request - End ===== -->

<!-- ===== Model Boxes - Funnel Lite - Start ===== -->
<div class="modal fade" data-backdrop="static"  id="modal_LitePackageFunnel">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activate Funnel</h5>
            </div>
            <div class="modal-body text-center">
                <p class="modal-msg modal-msg_light"> We'd love to talk to you about upgrading your account!</p>
                <a class="button button-secondary" href="{{  LP_Constants::URL_TO_SCHEDULE_LEADPOP_CALL }}" target="_blank">Click here to schedule a call with us.</a>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Funnel Lite - End ===== -->

<!-- ===== Survey Form & Overlay - Start ===== -->
@php
    use App\Services\DataRegistry;
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

    @if($sf && @DataRegistry::getInstance()->leadpops->skip_survey == 0)
        @include("partials.survey")
    @endif
@php } @endphp

<input type="hidden" name="flagoverlay" id="flagoverlay" value="{{ LP_Helper::getInstance()->getOverlayFlag() }}">
<input type="hidden" name="flagoverlayval" id="flagoverlayval" value="{{ LP_Helper::getInstance()->getOverlayFlagVal() }}">
@php
if(LP_Helper::getInstance()->getOverlayFlagVal()){
    DataRegistry::getInstance()->leadpops->show_overlay=0;
}
@endphp
<!-- ===== Survey Form & Overlay - End ===== -->
@php
if(env('PENDO_ACCESS', 0) == 1){
$accountType = LP_Helper::getInstance()->getClientAccountType();
$accountType = ($accountType == "Insurance" || $accountType == "Real Estate") ? "Standard" : $accountType;
@endphp
<!-- Start Pendo Tracking -->

<script>
    (function(apiKey){
        (function(p,e,n,d,o){var v,w,x,y,z;o=p[d]=p[d]||{};o._q=[];
            v=['initialize','identify','updateOptions','pageLoad','track'];for(w=0,x=v.length;w<x;++w)(function(m){
                o[m]=o[m]||function(){o._q[m===v[0]?'unshift':'push']([m].concat([].slice.call(arguments,0)));};})(v[w]);
            y=e.createElement(n);y.async=!0;y.src='https://cdn.pendo.io/agent/static/'+apiKey+'/pendo.js';
            z=e.getElementsByTagName(n)[0];z.parentNode.insertBefore(y,z);})(window,document,'script','pendo');
        // Call this whenever information about your visitors becomes available
        // Please use Strings, Numbers, or Bools for value types.
        pendo.initialize({
            visitor: {
                id: '{{ DataRegistry::getInstance()->leadpops->skeletonLogin ? '0000' : $view->session->clientInfo->client_id }}',   // Required if user is logged in
                email: '{{$view->session->clientInfo->contact_email}}',
                full_name: '{{$view->session->clientInfo->first_name}} {{$view->session->clientInfo->last_name}}',
                creationDate: '{{$view->session->clientInfo->join_date}}',
                current_lead_count: {{LP_Helper::getInstance()->total_leads}}
                // role:         // Optional
                // You can add any additional visitor level key-values here,
                // as long as it's not one of the above reserved names.
            },
            account: {
                id: '{{ $accountType }}',
                funnel_type: '{{ LP_Helper::getInstance()->getClientFunnelType(false) }}',
                primary_industry: '{{ LP_Helper::getInstance()->getClientIndustry() }}',
                internal_login: {{ DataRegistry::getInstance()->leadpops->skeletonLogin ? 'true' : 'false' }},
                chargebee_status:'{{@$view->session->clientInfo->chargebee_status}}'


                // name:         // Optional
                // is_paying:    // Recommended if using Pendo Feedback
                // monthly_value:// Recommended if using Pendo Feedback
                // planLevel:    // Optional
                // planPrice:    // Optional
                // creationDate: // Optional
                // You can add any additional account level key-values here,
                // as long as it's not one of the above reserved names.
            }
        });
    })('9460c14c-5eca-4418-4a3d-2e34d501141f');
</script>
<!-- End Pendo Tracking -->
@php
}
@endphp

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJRRB7K"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>

</html>
