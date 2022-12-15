@extends("layouts.leadpops-inner-sidebar")
@section('content')
    @include("partials.flashmsgs")
    @php
        if(config('app.beta_feature') && in_array($view->data->client_id, config('app.beta_clients'))){
                $_class = 'new_design';
            } else {
                $_class = '';
            }
    @endphp
    <main class="main">
        <section class="main-content" id="extra-content-page">
            <!-- Title wrap of the page -->
            @php
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
            @endphp

            <form id="extra-content-form"
                  class="global-content-form"
                  data-global_action="{{route("advanceFooterSaveActionGlobalAdminThree")}}"
                  data-action="{{route('advance_footer', ["hash" => $view->data->currenthash])}}"
                  action=""
                  method="post">

                {{ csrf_field() }}
                <input type="hidden" name="advancehtml" value="">
                <input type="hidden" name="templatetype" id="templatetype" value="">
                <input type="hidden" name="default_tpl_cta_msg" id="default_tpl_cta_msg" value="">
                <input type="hidden" name="logo_color" id="logo_color"
                       value="@php echo $view->data->advancedfooteroptions['logocolor']; @endphp">
                <input type="hidden" name="current_hash" id="current_hash"
                       value="@php echo $view->data->currenthash @endphp">
                <input type="hidden" name="clientfname" id="clientfname"
                       value="@php echo $view->data->advancedfooteroptions["first_name"]; @endphp">
                <!-- content of the page -->
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Extra Content Editor
                                <span class="question-mark el-tooltip">
										<span class="ico ico-question"></span>
									</span>
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item">
                                        @php $checked="";
                                            if($view->data->bottomlinks["advanced_footer_active"]=="y"){
                                                $checked="checked";
                                            }
                                        @endphp
                                        <input @php echo $checked; @endphp class="pfobtn global-switch global_super_status_btn"
                                               data-lpkeys="@php echo $view->data->lpkeys; @endphp~advanced_footer_active"
                                               id="global_super_status_btn"
                                               data-toggle="toggle"
                                               data-thelink="advanced_footer_active"
                                               name="advanced_footer_active"
                                               data-global_val="{{@$view->data->globalOptions['advanced_footer_active']}}"
                                               data-val="{{@$view->data->bottomlinks["advanced_footer_active"]}}"
                                               data-onstyle="active" data-offstyle="inactive"
                                               data-width="127" data-height="43" data-on="INACTIVE"
                                               data-off="ACTIVE" type="checkbox" value="y" data-form-field>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="superfooter">
                        <div class="lp-panel__body">
                            <div class="lp-panel-wrap">
                                <div class="classic-editor__wrapper exta-content froala-editor-fixed-width lp-thankyou-head funnel-setting-pages-editor">
                                    <div class="classic-editor-wrap local-super-footer {{$_class}}">
                                            <textarea class="lp-froala-textbox" data-form-field>
                                                @php  echo $view->data->bottomlinks["advancehtml"]; @endphp
                                            </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__footer">
                        <div class="checkbox">
                            @php $checked="";
                                if($view->data->bottomlinks["hide_primary_footer"] == "y"){
                                    $checked="checked";
                                }
                            @endphp
                            <input @php echo $checked; @endphp class="sub-group"
                                   id="footercontenthide"
                                   data-key="hideofooter" name="hideofooter"
                                   type="checkbox" value="y" data-form-field>
                            <label class="normal-font" for="footercontenthide">Hide Primary and Secondary footer content</label>
                            <span class="question-mark el-tooltip">
                                    <span class="ico ico-question"></span>
                                </span>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <!-- footer of the page -->
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

@push('body_classes') footer-option-settings-page @endpush
