@extends('layouts.leadpops-inner-sidebar')

@section('content')
    <!-- contain main informative part of the site -->
    <!-- content of the page -->
    @include("partials.flashmsgs")
    <main class="main">
        <!-- content of the page -->
        <section class="main-content lp-branding">
            <!-- Title wrap of the page -->
            {{ LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view) }}
            <form action="{{ LP_BASE_URL.LP_PATH."/branding/store" }}" method="post" id="branding-form" data-form="branding-form"
                  data-action="{{ LP_BASE_URL.LP_PATH."/branding/store" }}"
                  data-global_action="{{ LP_BASE_URL.LP_PATH."/branding/branding-global-setting" }}">
                {{ csrf_field() }}
                <input type="hidden" name="current_hash" value="{{ $view->data->currenthash }}">
                <!--image_path input just use for js-->
                <input type="hidden" id="image_path" value="{{ $view->data->imagePath }}">
                <input type="hidden" id="image_width" name="image_width" value="{{ $view->data->imageWidth }}">
                <input type="hidden" id="image_height" name="image_height" value="{{ $view->data->imageHeight }}">
            <div class="lp-panel lp-panel_switch">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">Would you like to turn leadPops branding off?</h2>
                    </div>
                    <div class="col-right">
                        <div class="radio">
                            <ul class="radio__list">
                                <li class="radio__item" data-toggle="modal" {{($view->data->active_branding_plan_id == "" && $view->data->branding_active === 0)?'data-target=#'.$view->data->planModal.'':'data-selected-plan=pro' }}>
                                    <input type="radio" id="brandingOn" value="1" name="leadpop_branding_active" data-form-field {{getChecked(1,$view->data->branding_active)}}>
                                    <label for="brandingOn">Yes, turn it off</label>
                                </li>
                                <li class="radio__item">
                                    <input type="radio" id="brandingOff" value="0" name="leadpop_branding_active" data-form-field
                                           {{getChecked(0,$view->data->branding_active)}}>
                                    <label for="brandingOff">No, leave it as it is</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-panel lp-panel_tabs" style="display: {{($view->data->active_branding_plan_id && $view->data->branding_active === 1)?'block':'none'}}">
                    <div class="lp-panel__head">
                    <div class="col-left m-0">
                        <h2 class="lp-panel__title lp-panel__title_regent-gray">Customize Your Own</h2>
                        <ul class="nav nav__tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link desktop-view-link active" href="#">
                                    <span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mobile-view-link" href="#">
                                    <span class="ico ico-Mobile el-tooltip" title="Mobile"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="right-col">
                        <input  id="lp-branding-page" name="leadpop_branding" data-toggle="toggle"
                                data-onstyle="active" data-offstyle="inactive"
                                data-width="127" data-height="43" data-on="INACTIVE"
                                data-off="ACTIVE" type="checkbox" data-form-field {{getChecked(1,isset($view->data->branding->leadpop_branding)?$view->data->branding->leadpop_branding:1)}}>
                    </div>
                </div>
                <div class="lp-panel__body">
                    <div class="background-detail">
                        <div class="background-detail__area">
                            <div class="theme__header">
                                <div class="dots"></div>
                                <div class="dots"></div>
                                <div class="dots"></div>
                            </div>
                            <div id="preview_iframe">
                                <img src="{{ config('view.theme_assets') }}/images/advance-background.png" alt="Mortgage">
                            </div>
                        </div>
                        <div class="bg-controls-block">
                            <div class="custom-scroll-holder">
                                <div class="custom-scroll-holder__wrap">
                                    <div class="logo-upload-option">
                                        <label>Upload an Image
                                            <span class="question-mark el-tooltip" title="Tooltip Content">
                                        <span class="ico ico-question"></span>
                                    </span>
                                        </label>
                                        <div class="dropzone needsclick bg-main__dropzone" id="main-bg-image">
                                            <div class="dz-message needsclick">
                                                <i class="icon ico-plus"></i>
                                                <span class="text-uppercase">upload image</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="branding_image" value="{{@$view->data->branding->branding_image}}" data-form-field>
                                        <div class="warning-msg"></div>
                                    </div>
                                    <div class="logo-other-option" style="display:{{isset($view->data->branding->branding_image)?'block':'none'}}">
                                        <div class="form-group">
                                            <label>Image Size</label>
                                            <div class="slider-wrapper">
                                                <input class="bg-slider" name="image_size" type="text" data-slider-min="0" data-slider-max="100" value="{{isset($view->data->branding->image_size)?$view->data->branding->image_size:65}}" data-form-field/>
                                            </div>
                                        </div>
                                        <div class="form-group image-pos">
                                            <label>Image Position</label>
                                            <div class="select2js__position-parent select2-parent">
                                                <select name="image_position" id="select2js__position" data-form-field>
                                                    <option value="right" {{getSelected('right',@$view->data->branding->image_position)}}>Bottom Right</option>
                                                    <option value="left" {{getSelected('left',@$view->data->branding->image_position)}}>Bottom Left</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="backlink-area">
                                            <div class="form-group">
                                                <label for="backlink">Embed Backlink  </label>
                                                <div class="switcher-min">
                                                    <input id="backlink" class="backlink-opener" name="backlink_enable"
                                                           data-toggle="toggle min"
                                                           data-onstyle="active" data-offstyle="inactive"
                                                           data-width="71" data-height="28" data-on="OFF"
                                                           data-off="ON" type="checkbox" data-form-field  {{getChecked(1,isset($view->data->branding->backlink_enable)?$view->data->branding->backlink_enable:0)}}>
                                                </div>
                                            </div>
                                            <div class="backlink-slide" style="display: {{(isset($view->data->branding->backlink_enable) and $view->data->branding->backlink_enable === 1) ?'block':'none'}}">
                                                <div class="form-group">
                                                    <div class="input-icon">
                                                        <span><i class="ico ico-link"></i></span>
                                                        <input class="form-control" type="text" name="backlink_url" placeholder="Backlink URL" value="{{@$view->data->branding->backlink_url}}" data-form-field>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Open Backlink in</label>
                                                    <div class="select2js__link-parent select2-parent">
                                                        <select name="backlink_target" id="select2js__link" data-form-field>
                                                            <option value="_blank"  {{getSelected('_blank',@$view->data->branding->backlink_target)}}>New Window</option>
                                                            <option value="_self"  {{getSelected('_self',@$view->data->branding->backlink_target)}}>Same</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="logo-text">
                                            <div class="form-group">
                                                <label>Title Text
                                                    <span class="question-mark el-tooltip" title="Tooltip Content">
                                                <span class="ico ico-question"></span>
                                            </span>
                                                </label>
                                                <input name="image_title" class="form-control" type="text" value="{{@$view->data->branding->image_title}}" data-form-field>
                                            </div>
                                            <div class="form-group">
                                                <label>Image Alt Text</label>
                                                <input name="image_alt" class="form-control" type="text" value="{{@$view->data->branding->image_alt}}" data-form-field>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </section>
    </main>

    <!-- Branding Modal - Start -->
    @if(isset($view->data->planList['currentPlan']) && isset($view->data->planList['plan']) && $view->data->active_branding_plan_id == "")
        @if($view->data->planList['currentPlan'] === 'marketer')
            <!-- MARKETER Branding Modal -->
            <div class="modal fade" id="branding-feature-modal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="close close-modal"><i class="ico ico-cross"></i></button>
                        <div class="modal-body">
                            <div class="funnel-plan-section">
                                <div class="funnel-plan-section__logo-area">
                                    <div class="upgrade-plan-area premium">
                                        <h2>You discovered a <span>premium feature</span>!</h2>
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
                                                <ul class="upgrade-plan-area__list">
                                                    <li><span class="list-heading">Funnels branding customizations allow you to:</span></li>
                                                    <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span></li>
                                                    <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span></li>
                                                </ul>
                                            </div>
                                            <div class="tab-pane fade" id="annually" role="tabpanel" aria-labelledby="annually-tab">
                                                <ul class="upgrade-plan-area__list">
                                                    <li><span class="list-heading">Funnels branding customizations allow you to:</span></li>
                                                    <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span></li>
                                                    <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="funnel-plan-section__content">
                                    <h2>Funnel branding customization is a Premium feature <br>
                                        that's only available on the "<strong>Pro</strong>" plan.</h2>
                                    <span class="funnel-plan-section__subtitle">You can Upgrade to "Pro" and unlock this feature here!</span>
                                    <div class="funnel-plan-section__quote-area">
                                        <div class="funnel-plan-section__wrap">
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
                                                                <strong class="price">${{$view->data->planList['plan']['marketer']['month']['plan_price']}}</strong>
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
                                                            <div class="upgrade-plan-area__package-unlock">
                                                                <div class="upgrade-plan-area__unlock-pro">
                                                                    <div class="upgrade-plan-area__heading">
                                                                        <h3>Pro</h3>
                                                                        <span class="upgrade-plan-area__sub-text">Yup, Unlimited Funnels</span>
                                                                    </div>
                                                                    <div class="upgrade-plan-area__price-info">
                                                                        <strong class="price">${{$view->data->planList['plan']['pro']['month']['plan_price']}}</strong>
                                                                        <span class="price-text">per month</span>
                                                                    </div>
                                                                </div>
                                                                @if(!empty($view->data->planList['addOn']))
                                                                <span class="ico ico-plus"></span>
                                                                <div class="upgrade-plan-area__unlock-pre">
                                                                    <div class="upgrade-plan-area__heading">
                                                                        <h3>Premium</h3>
                                                                        <span class="upgrade-plan-area__sub-text">Remove leadPops Branding</span>
                                                                    </div>
                                                                    <div class="upgrade-plan-area__price-info addon-info">
                                                                        <strong class="price">${{$view->data->planList['addOn']['month']['plan_price']}}</strong>
                                                                        <span class="price-text">per month</span>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <a href="#" class="button button-plan branding-upgrade-plan" data-plan-period="month" data-addon="0">Upgrade My Plan + unlock premium</a>
                                                        </div>
                                                        <div class="upgrade-plan-area__list-holder">
                                                            <ul class="upgrade-plan-area__list package-right-list">
                                                                <li><span class="list-heading">Everything in Marketer, plus:</span></li>
                                                                <li><span class="list-text"><i class="ico-check"></i>Clone feature gives you UNLIMITED <br> Lead Funnels & Sticky Bars</span></li>                                               <li><span class="list-text"><i class="ico-check"></i>Remove leadPops Branding</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnel-plan-section__footer">
                                                <p>This is an account-wide upgrade, not just for this Funnel. You can cancel this feature any time.</p>
                                                <span class="close-modal">no thanks</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(!empty($view->data->planList['addOn']))
            <!-- PRO Branding Modal -->
            <div class="modal fade clone-feature-modal plan" id="feature-modal-price">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="close close-modal"><i class="ico ico-cross"></i></button>
                        <div class="modal-body">
                            <div class="upgrade-plan-area">
                                <h2>You discovered a <span>premium feature</span>!</h2>
                                <div class="nav-tabs-wrap">
                                    <ul class="nav nav-tabs plan-tabs">
                                        <li>
                                            <a class="active" id="monthly-tab" data-toggle="tab" href="#monthly"
                                               role="tab" aria-controls="monthly" aria-selected="true">Monthly</a>
                                        </li>
                                        <li>
                                            <a id="annually-tab" data-toggle="tab" href="#annually" role="tab"
                                               aria-controls="annually" aria-selected="false">Annually</a>
                                        </li>
                                        <li class="bg-animation"></li>
                                    </ul>
                                    <div class="upgrade-plan-area__discount-info">
                                        <span class="upgrade-plan-area__text">Save 20%</span>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="monthly" role="tabpanel"
                                         aria-labelledby="monthly-tab">
                                        <div class="upgrade-plan-area__package-row-wrap">
                                            <div class="upgrade-plan-area__package-row">
                                                <div class="upgrade-plan-area__package-col">
                                                    <div class="upgrade-plan-area__content">
                                                        <div class="upgrade-plan-area__heading">
                                                            <h3>Premium</h3>
                                                            <span class="upgrade-plan-area__sub-text">Unlimited Premium Features</span>
                                                        </div>
                                                        <div class="upgrade-plan-area__price-info addon-info">
                                                            <strong
                                                                class="price">${{$view->data->planList['addOn']['month']['plan_price']}}</strong>
                                                            <span class="price-text">per month</span>
                                                        </div>
                                                        <a href="#" class="button button-plan branding-upgrade-plan"
                                                           data-plan-period="month" data-addon="1">unlock premium</a>
                                                    </div>
                                                    <div class="upgrade-plan-area__list-holder">
                                                        <ul class="upgrade-plan-area__list">
                                                            <li><span class="list-heading">Funnels branding customizations allow you to:</span>
                                                            </li>
                                                            <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span>
                                                            </li>
                                                            <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnel-plan-section__footer">
                                                <p>This is an account-wide upgrade, not just for this Funnel. <br> You
                                                    can cancel this feature any time.</p>
                                                <span class="close-modal">no thanks</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="annually" role="tabpanel"
                                         aria-labelledby="annually-tab">
                                        <div class="upgrade-plan-area__package-row-wrap annually">
                                            <div class="upgrade-plan-area__package-row">
                                                <div class="upgrade-plan-area__package-col">
                                                    <div class="upgrade-plan-area__content">
                                                        <div class="upgrade-plan-area__heading">
                                                            <h3>Premium</h3>
                                                            <span class="upgrade-plan-area__sub-text">Unlimited Premium Features</span>
                                                        </div>
                                                        <div class="upgrade-plan-area__price-info addon-info">
                                                            <strong
                                                                class="price">${{$view->data->planList['addOn']['month']['plan_price']}}</strong>
                                                            <span class="price-text">per month</span>
                                                        </div>
                                                        <a href="#" class="button button-plan branding-upgrade-plan"
                                                           data-plan-period="year" data-addon="1">unlock premium</a>
                                                    </div>
                                                    <div class="upgrade-plan-area__list-holder">
                                                        <ul class="upgrade-plan-area__list">
                                                            <li><span class="list-heading">Funnels branding customizations allow you to:</span>
                                                            </li>
                                                            <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span>
                                                            </li>
                                                            <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="funnel-plan-section__footer">
                                                <p>This is an account-wide upgrade, not just for this Funnel. <br> You
                                                    can cancel this feature any time.</p>
                                                <span class="close-modal">no thanks</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <!-- Branding Modal - End -->
@endsection
@php
    if(!empty($view->data->active_branding_plan_id)){
        if (!isset($tcpaMessage['tcpa_text'])){
           // set default tcpa_text
           $tcpaMessage['tcpa_text'] =  '';
        }

       $iframeProps  = [ "localStoragePrefix" => "tcpa_module_", "currenthash" => @$view->data->currenthash, "iframeHolder"=> "#preview_iframe", "iframeSrc" => $view->data->questionPreview->iframeSrc];
@endphp

@include("partials.messages-preview-setup", ['data' => [$view, @$tcpaMessage, $iframeProps]])
@php
}
@endphp
@push('footerScripts')
<script>
    var planList = {!! json_encode($view->data->planList) !!}
</script>
@endpush
