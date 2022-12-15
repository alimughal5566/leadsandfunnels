@extends("layouts.leadpops-inner-sidebar")
@section('content')
    @include("partials.funnel-builder-sidebar")
    <!-- content of the page -->
    <main class="main">
        <section class="main-content">
            <!-- Title wrap of the page -->
            <input type="hidden" id="theme_color" value="{{ $view->data->advancedfooteroptions["logocolor"] ?? '#abb3b6'}}">
            @php
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view);
            @endphp

            <!-- content of the page -->
            <div class="funnel-wrap">
                <div class="funnel-panel">
                    <div class="funnel-panel__head-wrap">
                        <div class="funnel-panel__head">
                            <h2 class="funnel-panel__title">
                                Funnel Questions
                                <span class="question-mark-wrap">
                                    <span class="question-mark el-tooltip" title="TOOLTIP CONTENT" data-tooltip-content="#tooltip_seamlesscontent">
                                        <span class="ico ico-question"></span>
                                    </span>
                                </span>
                            </h2>
                            <ul class="funnel-panel__options">
                                <li class="funnel-panel__item edit-funnel {{$view->data->enable_cta_class}}" data-enable-cta-class>
                                    <a href="#homepage-cta-message-pop" data-edit-cta-popup data-toggle="modal" class="btn panel-button__btn"> <i class="ico ico-promote"></i>
                                        <span class="opt-text">Edit Homepage CTA Message <span class="on-text">(ON)</span></span>
                                    </a>
                                </li>
                                <li class="funnel-panel__item feature_image-item{{$view->data->featured_image_active != '' ? ' active' : ''}}">
                                    <a href="#feature-image-modal" data-edit-featured-image data-toggle="modal" class="feature-icon-btn btn panel-button__btn">
                                        <i class="icon ico-image"></i>
                                        <span class="opt-text">Featured Image <span class="on-text">(ON)</span></span>
                                    </a>
                                </li>
                                <li class="funnel-panel__item logic el-tooltip conditional-logic-item {{ ($view->data->conditional_active) ? "active" : "z--".$view->data->conditional_active }}">
                                        <a href="#" data-cl-init-button class="btn panel-button__btn">
                                            <i class="lp-icon-conditional-logic lp-icon-conditional-logic_pt3 ico-back"></i>
                                            <span class="opt-text">Conditional Logic  <span class="on-text">(ON)</span></span>
                                        </a>

                                </li>
                                <li class="funnel-panel__item leads el-tooltip" title="Partial Leads is a new feature that is in <br >development and will be coming soon!">
                                    {{--<a href="#partial-leads-pop" data-toggle="modal" class="btn panel-button__btn">--}}
                                        <span class="btn panel-button__btn">
                                            <i class="lp-icon-users ico-multi-user"></i>
                                            <span class="opt-text">Partial Leads</span>
                                        </span>
                                    {{--</a>--}}
                                </li>
                                {{-- if current funnel's leadpop_version_id is less than 126 (its a stock funnel) then reset is allow.--}}
                                @if($view->data->funnelData['leadpop_version_id'] < config('funnelbuilder.funnel_builder_version_id'))
                                <li class="funnel-panel__item reset">
                                    <a href="#reset-default-pop" data-toggle="modal" class="btn panel-button__btn">
                                        <i class="lp-icon-refresh ico-reload"></i>
                                        <span class="opt-text">Reset to Default Provided Questions</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="funnel-body-scroll-group">
                        <div data-hbs="funnelPanel"  class="funnel-panel__body"></div>
                        <div class="funnel-panel-hidden__sortable">
                            <strong class="hidden-layer-title"><span class="text-wrap">hidden fields</span></strong>
                        </div>
                    </div>
                </div>

                <!-- Question Editor Panel -->
                <div data-hbs="questionEditor"></div>

                <!-- Thank you page Listing -->
                <div class="funnel-panel funnel-panel_thankyou funnel-body-thankyou-group">
                    <div class="funnel-panel__head">
                        <h2 class="funnel-panel__title">
                            Thank You Page
                        </h2>
                    </div>
                    <div class="funnel-panel__body">
                        <div class="funnel-panel__ty_sortable">
                            <div class="fb-question-items-wrap" data-hbs="thankyouList">
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    if($view->data->funnelData['leadpop_version_id'] == config('funnelbuilder.funnel_builder_version_id') && 1==2){
                @endphp
                <div class="funnel-panel__add">
                    <div class="add-btn-wrap">
                        <a href="{{LP_BASE_URL.LP_PATH."/popadmin/thank-you-pages/add/".$view->data->currenthash}}?refer=funnel-builder" class="add-box add-box_page">
                            <i class="lp-icon-plus lp-icon-plus_large ico-plus"></i>
                            <span class="add-box__text">Add New Page</span>
                        </a>
                    </div>
                </div>
                @php
                }else{
                @endphp
                <div class="funnel-panel__add disbale-page-option">
                    <div class="add-btn-wrap el-tooltip" title='<div class="thankyou-page-tooltip">Add New Thank You Page <br> (coming soon!) </div>'>
                        <div class="add-box add-box_page" data-backdrop="static" data-keyboard="false">
                            <i class="lp-icon-plus lp-icon-plus_large ico-plus"></i>
                            <span class="add-box__text">Add New Page</span>
                        </div>
                    </div>
                </div>
                @php
                    }
                @endphp
            </div>
        </section>
    </main>
    <!-- Confirmation modal -->
    <div class="modal fade confirmaton-funnel-modal" id="confirmaton-funnel-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">You have unsaved changes.</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to exit the Question Editor? </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Stay</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary">Don't Save & Continue</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary">Save & Continue</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature Image modal -->
    <div class="modal fade feature-image-modal" id="feature-image-modal">
        @php
            $firstkey = isset($view->data->clickedkey)?@$view->data->clickedkey:'';

            $imagesrc = \View_Helper::getInstance()
            ->getCurrentFrontImageSource( @$view->data->client_id, @$view->data->funnelData );

            if($imagesrc){
                list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc);
                $currentImage = "";
                if(!empty($theimage)) {
                    $arr = explode('/', $theimage);
                    if(is_array($arr)) {
                        $currentImage = end($arr);
                    }
                }

                if($imagestatus == 'default') {
                   $imagedescr =  "homedefault";
               } else if($imagestatus == 'mine') {
                   $imagedescr =  "myhome";
               }

                $active_inactive_checked="checked";

                if($noimage=="noimage") {
                    $active_inactive_checked="";
                    $imagedescr =  "nohome";

                    $imagestatus = 'inactive';
                } else {
                    $imagestatus = 'active';
                }
            } else {
               $theimage = '';
               $active_inactive_checked="";
               $imagedescr =  "nohome";
               $imagestatus = 'inactive';
            }
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);

            if (config('rackspace.rs_featured_image_dir') == 'stockimages/classicimages/' )
                $class = " classicimages";
            else
                $class = "";
        @endphp
        <form id="fuploadload" name="fuploadload"
              enctype="multipart/form-data"
              action="{{ LP_BASE_URL.LP_PATH."/popadmin/uploadimage" }}"
              class="global-content-form"
              data-action="{{ LP_BASE_URL.LP_PATH."/popadmin/uploadimage" }}"
              data-global_action="{{ route('uploadGlobalImageAdminThree')}}"
              method="POST">
            @csrf
            <input type="hidden" name="client_id" value="{{ @$view->data->client_id }}">
            @php
                $_funnel_data=json_encode(@$view->data->funnelData["funnel"],JSON_HEX_APOS);
            @endphp
            <input type="hidden" name="funneldata" value='{{ $_funnel_data }}'>
            <input type="hidden" name="current_hash" value="{{ @$view->data->currenthash }}">
            <input name="theselectiontype" value="imageedit" type="hidden">
            <input name="imagestatus" id="imagestatus" value="{{ $imagestatus }}" type="hidden" data-form-field/>
            <input type="hidden" name="logo_source" value="">
            <input type="hidden" name="badimage" value="{{ @$view->data->badupload }}">
            <input type="hidden" name="firstkey" value="{{ $firstkey }}">
            <input type="hidden" name="clickedkey" value="{{ $firstkey }}">
            <input type="hidden" name="treecookie" value="{{ $treecookie }}">
            <input type="hidden" name="imageuploaded" value="{{ @$view->data->imageuploaded }}">
            <input type="hidden" name="treecookiediv" value="browserdivpopadmin">
            <input type="hidden" name="reset_defaultimg" value="no">
            <input type="hidden" name="delete_image" id="delete_image" value="n" data-form-field>
            <input type="hidden" id="logo" value="{{@$view->data->featured_image_active != '' ? '1' : ''}}">
            <input type="hidden" id="funnel_builder" value="1">
            <input type="hidden" data-enable-featured-class class="@php if($view->data->featured_image_active == '') echo 'inactive' @endphp">
            <!-- hidden variables to manage featured image popup state in DOM -->
            <input type="hidden" id="selected_featured_image_toggle" value="{{@$view->data->featured_image_active != '' ? 1 : 0}}">
            <input type="hidden" id="selected_featured_image" value="{{@$theimage}}">
            @php
                if($view->data->funnelData['leadpop_version_id'] == config('funnelbuilder.funnel_builder_version_id')){
                    echo '<input type="hidden" id="leadpop_version_id_featured_image_off" value="1">';
                }
            @endphp
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Featured Image</h5>
                        <div class="fb-toggle-wrap">
                            <span class="reset-btn-wrap">
                                <a href="javascript:void(0)" id="reset_default_image" class="image-reset el-tooltip" title='<div class="reset-image-tooltip">reset default image</div>'><i class="ico-undo"></i></a>
                            </span>
                            <div class="fb-toggle">
                                <input @php if($view->data->featured_image_active != '') echo 'checked' @endphp data-toggle-feature-image class="fb-field-label" type="checkbox" id="activedeactivebtn" data-toggle="toggle" data-on="OFF" data-off="ON" data-onstyle="off" data-offstyle="on">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body quick-scroll">
                        <div class="modal-body-wrap">
                            <div class="feature-image-area">
                                <div class="feature-image-wrap">
                                  {{--  @php echo '<img id="currentdropimagelogo" data-current-featured-image class="img-frame__preview" src="'.$theimage.'" alt="">' @endphp--}}
                                    <div class="dropzone needsclick feature-image-area__dropzone" data-current-featured-image id="feature-image">
                                        <div class="dz-message needsclick">
                                            <i class="icon ico-plus"></i>
                                            <span class="text-uppercase">upload image</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <ul class="feature-image-option-list" style="visibility: hidden;">
                            <li {!! empty($currentImage) ? "style='display:none;'" : "style='display:block;'" !!} class="btn-image__del"><a href="#">delete</a></li>
                            <li>
                                <label class="browse-image-wrap">
                                    <input onchange="onSelect(event)" onclick="fileClicked(event)" type="file" accept="image/*">
                                    <span class="text">UPLOAD IMAGE</span>
                                </label>
                            </li>
                        </ul>
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-bold button-cancel" data-dismiss="modal">close</button>
                                </li>
                                <li class="action__item">
                                    <button type="button" id="submit-featured-image" class="button button-bold button-primary" disabled>save</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade add_recipient video-modal" id="resetfeaturedimg" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="lp-video-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Featured Image</h5>
                </div>
                <div class="modal-body">
                    <div class="modal-msg mb-0">Are you sure you want to reset featured image?</div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel lp-btn-cancel reset-close-modal" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary" id="resetFeature">Reset</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- funnel builder modals -->
    @include("partials.funnel-builder-modal")
    @include("partials.conditional-logic-modals")
@endsection
@push('body_classes')
    funnel-question-page funnel-question-page-group
    @if(!$view->data->funnelData['funnel']['is_active_funnel_builder']) _disable-elements_ @endif
    @if($view->data->client_integrations > 0) integrations-active @endif
@endpush
@push('footerScripts')
    <script src="https://images.lp-images1.com/default/js/handlebar/handlebars.runtime.min-v4.7.7.js"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/handlebar/templates.js"></script>

{{--    <script src="{{ config('view.theme_assets') }}/js/funnel/handlebar/templates.js"></script>--}}
{{--    @php--}}
{{--        $handlebars = [--}}
{{--            'funnel-panel.js',--}}
{{--            'question-header.js',--}}
{{--            'questionlist-standard.js',--}}
{{--            'questionlist-transition.js',--}}
{{--            'text-field.js'--}}
{{--        ];--}}
{{--    @endphp--}}
{{--    @foreach ($handlebars as $handlebar)<script src="{{ config('view.theme_assets') }}/js/funnel/handlebar/{{$handlebar}}?v={{ LP_VERSION }}"></script>@endforeach--}}
    <script type="text/javascript">
        var question_json = '{!! addslashes(json_encode($view->data->funnelQuestion , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var conditional_json = '{!! addslashes(json_encode($view->data->conditionalLogic , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var funnel_sequence = '{!! json_encode($view->data->funnelSequence) !!}';
        var hidden_fields_json = '{!! json_encode($view->data->funnelHiddenField) !!}';
        var ls_tcpa_messages = '{!! addslashes(json_encode($view->data->ls_tcpa_messages , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var security_message_config = JSON.parse('{!! json_encode(config('lp.security_message')) !!}');
        // header footer info for preview
        var ls_meta_logo = '{{$view->data->selected_logo_src}}';
        var ls_meta_contact_info = '{!! addslashes(json_encode($view->data->contact_info , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var ls_meta_footer_links = '{!! addslashes(json_encode($view->data->bottomlinks , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var ls_meta_footer_logos = '{!! addslashes(json_encode($view->data->footer_copyright_logo , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var ls_meta_footer_bab_logos = '{!! addslashes(json_encode($view->data->footer_bab_logo , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var ls_meta_footer_mobile_logos = '{!! addslashes(json_encode($view->data->footer_copyright_logo_mobile , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';
        var ls_meta_footer_copyright = '{!! addslashes(json_encode($view->data->footer_copyright , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}';

        var app_config = {
            "app": {
                "url": "{{ env("APP_URL") }}",
                "assets": "{{ config('view.theme_assets') }}",
                "LP_VERSION": "{{ LP_VERSION }}"
            }
        };
    </script>
    <script src="{{ config('view.theme_assets') }}/external/dropzone/dropzone.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/pages/featured-image.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/handlbars-util.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript">
        hbar.renderTemplate('questionlist-standard.hbs', "questionsList", "questions.json");
        hbar.renderTemplate('funnel-panel.hbs', "funnelPanel", "{}");
        var ctaFonts = JSON.parse('{!! LP_Helper::getInstance()->getFontFamilies(true,'calltoaction') !!}');
    </script>

    <script src="{{ config('view.theme_assets') }}/js/funnel/funnels-util.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/funnel-question-actions.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/funnel-builder.js?v={{ LP_VERSION }}"></script>
    <script src="/lp_assets/theme_admin3/js/funnel/save-preivew-changes.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/thankyou/thankyou-util.js?v={{ LP_VERSION }}"></script>
    <!--question controls js files-->
    <script src="/lp_assets/theme_admin3/js/funnel/question-controls.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/content/thankyou-pages.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/content/thankyoumessage.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/constants.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/funnel-question-reset.js?v={{ LP_VERSION }}"></script>
    <script src="/lp_assets/theme_admin3/external/date-picker/moment-new.js?v={{ LP_VERSION }}"></script>
    <script src="/lp_assets/theme_admin3/external/date-picker/daterangepicker-new.js?v={{ LP_VERSION }}"></script>
    <script src="{{ config('view.theme_assets') }}/js/funnel/conditional-logic.js?v={{ LP_VERSION }}"></script>
    <script>
        thankyou_hbar.templtate = 'funnel-builder-thankyou-pages-list.hbs';
        window.thankyouList = JSON.parse('{!! addslashes(json_encode($view->data->thankyouPageList , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS)) !!}');
        thankyou_hbar.renderThankyouTemplate('funnel-builder-thankyou-pages-list.hbs' ,"thankyouList", thankyouList);
    </script>
    <script src="{{ config('view.theme_assets') }}/js/content/calltoaction.js?v={{ LP_VERSION }}"></script>
@endpush
