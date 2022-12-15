@extends("layouts.leadpops-inner-sidebar")

@section('content')

    @php
        if(isset($view->data->clickedkey) && $view->data->clickedkey != "") {
            $firstkey = $view->data->clickedkey;
        }else {
            $firstkey = "";
        }
    @endphp
    @php
        $treecookie = \View_Helper::getInstance()->getTreeCookie($view->data->client_id,$firstkey);
    @endphp

    <main class="main">
        <section class="main-content">

            <form id="footer-page"
                  class="global-content-form"
                  data-global_action="{{route('footerOptionPageSaveActionGlobalAdminThree')}}"
                  data-action="@php echo LP_BASE_URL.LP_PATH."/popadmin/footeroption/".$view->data->currenthash; @endphp"
                  action=""
                  method="post">
                {{ csrf_field() }}
                <input type="hidden" name="openSections" id="openSections" value="">
                <input type="hidden" name="client_id" id="client_id" value="@php echo $view->data->client_id @endphp">
                <input type="hidden" name="theoption" id="theoption" value="thirdparty">
                <input type="hidden" name="logocolor" id="logocolor"
                       value="@php echo $view->data->advancedfooteroptions['logocolor']; @endphp">
                <input type="hidden" name="changebtn" id="changebtn" value="0">
                <input type="hidden" name="templatetype" id="templatetype" value="">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="thelink" id="thelink"  value="compliance_active~license_number_active">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash"
                       value="@php echo $view->data->currenthash @endphp">
                <input type="hidden" id="lp-keys-value" name="lp-keys-value" value="@php echo $view->data->lpkeys @endphp">

                <input type="hidden" name="lpkey_secfot" id="lpkey_secfot" value="">
                <input type="hidden" name="sec_fot_url_active" id="sec_fot_url_active" value="{{ @$view->data->globalOptions['sec_fot_url_active'] }}">
                <input type="hidden" name="sec_fot_license_number_active" id="sec_fot_license_number_active" value="{{ @$view->data->globalOptions['sec_fot_license_number_active'] }}">
                <input type="hidden" name="gfot_ai_val" id="gfot_ai_val" value="{{ @$view->data->globalOptions['sec_fot_url_active'] }}">
                <input type="hidden" name="gfot_ai_val1" id="gfot_ai_val1" value="{{ @$view->data->globalOptions['sec_fot_license_number_active'] }}">
                {{--<input type="hidden" name="totalkeys" id="totalkeys" value="{{ $total_keys }}">--}}
                <input type="hidden" name="thelink" id="thelink"  value="compliance_active~license_number_active">
                <input type="hidden" name="gfot-ai-flg" id="gfot-ai-flg"  value="0">
                <input type="hidden" name="gfot-ai-flg1" id="gfot-ai-flg1"  value="0">

                <input type="hidden" name="compliance_text" value="">
                <input type="hidden" name="compliance_link" value="">
                <input type="hidden" name="license_number_text" value="">
                <input type="hidden" name="license_number_link" value="">
                <input type="hidden" name="license_number_is_linked" value="n">
                <input type="hidden" name="compliance_is_linked" value="n">
                <input type="hidden" name="defaultTplCtaMessage" value="">
                <input type="hidden" name="advancehtml" value="">
                <!-- Title wrap of the page -->
                @php

                    LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, null, false, true);

                @endphp

                @include("partials.flashmsgs")

                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success" id="success-alert" style="display: none">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Success:</strong>
                            <span>Secondary Footer Option has been saved.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success" id="advanced-success-alert" style="display: none">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Success:</strong>
                            <span>Advanced Footer Option has been saved.</span>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                {{--<div class="tab-content">
                    <div id="tbOptions" class="tab-pane active">--}}

                @include('content.footer.primary-footer', ['data' => [$view]])

                @include('content.footer.secondary-footer', ['data' => [$view]])

                <div class="footer">
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </form>
        </section>
    </main>

    <!-- Model Boxes - Property CTA - Start -->
    <div id="modal_proerty_template" class="modal fade lp-modal-box in" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-template">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title property-modal-text title-bold title-18" >Would you like to use our default CTA Message that goes with Property Template?&nbsp;<i class="el-tooltip fa fa-question-circle CTA-wraning" title="<div class='text-center'>No matter which option you select below, you can always further <br> customize the CTA messaging from the 'Edit > Content&nbsp;> Call-to-Action'<br> section of the Funnels Admin Panel.</div>"></i></h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                        <div class="row">
                            <div class="col-sm-12 modal-action-msg-wrap">
                                <div class="modal-msg property-msg">
                                    <div class="radio">
                                        <input type="radio" class="lp-popup-radio" value="y" id="property_cta_yes" name="property_cta">
                                        <label class="radio-control-label" for="property_cta_yes"></label>
                                        <span class="text">Yes, use the default CTA message that goes with this template</span>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" class="lp-popup-radio" value="n" checked="" id="property_cta_no" name="property_cta">
                                        <label class="radio-control-label" for="property_cta_no"></label>
                                        <span class="text">No, I'd like to keep what I have now</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer lp-modal-action-footer lp-modal-action-footer-template">
                    <ul class="action__list">
                        <li class="action__item">
                            <button data-dismiss="modal" class="button button-bold button-cancel ">Close</button>
                        </li>
                        <li class="action__item">
                            <button id="_update_template_cta_btn" class="button button-bold button-primary ">Save & Continue</button>&nbsp;
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Boxes - Property CTA - End -->
@endsection

@push('footerScripts')
    <script>
        let openSections = "{{session('openSections') }}".split(',');
        console.log(openSections);
        $('#primaryfooter').collapse('hide');
        $('#secondaryfooter').collapse('hide');
        if($('#superfooter').length) {
            $('#superfooter').collapse('hide');
        }
    </script>
@endpush

@push('body_classes') footer-option-settings-page @endpush
