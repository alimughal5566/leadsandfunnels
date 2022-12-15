@extends("layouts.leadpops-inner-sidebar")

@section('content')
    @php
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }
        $footerLinkTitle = empty($view->data->bottomlinks['terms_text']) ? "Terms of Use" : $view->data->bottomlinks['terms_text'];
        $footerLinkTitle = trim($footerLinkTitle);
        $footerLinkFullTitle = $footerLinkTitle;
        // 14 is the number of characters in word Privacy Policy
        $footerLinkTitle = strlen($footerLinkTitle) > 14 ? substr($footerLinkTitle, 0, 11) . '...' : $footerLinkTitle;

    @endphp

    <main class="main">
        <section class="main-content">
        {{--            @php LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view) @endphp--}}
        <!-- Title wrap of the page -->
            @php
                $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
            @endphp


            {{--<form id="pricay-page" method="get" action="">--}}
            <form id="pricay-page" enctype="multipart/form-data"
                  name="ffooter" id="ffooter" method="POST"
                  class="global-content-form"
                  data-global_action="{{ LP_BASE_URL.LP_PATH }}/global/saveFooterOptionsAdminThree"
                  data-action="@php echo LP_BASE_URL.LP_PATH."/popadmin/savefooteroptions"; @endphp"
                  action="">

                <!-- Title wrap of the page -->

                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id" value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="theselectiontype" id="theselectiontype" value="termsofuse">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash"
                       value="@php echo @$view->data->currenthash @endphp">


                {{--<input type="hidden" name="is_include" id="is_include" value="y">--}}
                <input type="hidden" name="lpkey_termsofuse" id="lpkey_termsofuse" value="">
                <input type="hidden" name="theselectiontype" id="theselectiontype" value="termsofuse">
                <input type="hidden" name="terms_of_use_active" id="terms_of_use_active"
                       value="{{  @$view->data->bottomlinks['terms_active'] }}">
                <input type="hidden" name="gfot_ai_val" id="gfot_ai_val"
                       value="{{  @$view->data->globalOptions['terms_of_use_active'] }}">
                <input type="hidden" name="thelink" id="thelink" value="terms_active">
                <input type="hidden" name="gfot-ai-flg" id="gfot-ai-flg" value="0">


                <input type="hidden" name="theselection" id="theselection"
                       value="@php echo @$view->data->bottomlinks['terms_type'] @endphp">


            @php

                $backUrl = route('footeroption', [@$view->data->currenthash, 'app_theme' => 'theme_admin3']);
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, $backUrl, false);@endphp
            @include("partials.flashmsgs")
            <!-- content of the page -->
                <div class="alert alert-danger" id="alert-danger" style="display: none;">
                    <button type="button" class="close">x</button>
                    <strong>Error:</strong>
                    <p></p>
                </div>
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                @php echo (@$view->data->bottomlinks['terms_text'] == "" ? "Terms of Use" : @$view->data->bottomlinks['terms_text']);  @endphp
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item">
                                        @php
                                            $checked="";
                                            if(@$view->data->bottomlinks['terms_active']=='y'){
                                                $checked="checked";
                                            }
                                        @endphp
                                        <input @php echo $checked; @endphp id="fp-privacy-policy"
                                               name="fp-privacy-policy" data-toggle="toggle"
                                               data-onstyle="active" data-offstyle="inactive"
                                               data-width="127" data-height="43" data-on="INACTIVE"
                                               data-global_val="{{@$view->data->globalOptions['terms_of_use_active']}}"
                                               data-val="{{@$view->data->bottomlinks['terms_active']}}"
                                               data-field='terms_of_use_active'
                                               class="pptogbtn global-switch gfooter-toggle"
                                               data-lpkeys="@php echo @$view->data->lpkeys."~terms_active"; @endphp"
                                               data-off="ACTIVE" type="checkbox" data-form-field>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="options-page">
                            <div class="form-group">
                                <label for="linktype">Link <span>{{ $footerLinkTitle }}</span> to
                                    <span class="question-mark el-tooltip" data-container="body" data-toggle="tooltip" title="Link {{ $footerLinkFullTitle }} to" data-html="true" data-placement="top">
                                        <i class="ico ico-question"></i>
                                    </span>
                                </label>
                                <div class="input__wrapper">
                                    <div class="select2js__linkpage-option-parent">
                                        <select class="select2js__linkpage-option global-select"
                                                data-global_val="{{@$view->data->globalOptions['terms_type']}}"
                                                data-val="{{@$view->data->bottomlinks['terms_type']}}"
                                                name="linktype" id="linktype"
                                                onchange="mytoggledestination()" data-form-field>
                                            {{--<option value="-1">Select One</option>--}}
                                            <option value="u">
                                                Another Website
                                            </option>
                                            <option value="m">
                                                Your Funnel
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="theurltext">Link text</label>
                                <div class="input__wrapper">
                                    <input id="theurltext" name="theurltext" class="form-control global-input-text"
                                           type="text"
                                           data-global_val="{{ @$view->data->globalOptions['terms_text'] }}"
                                           data-val="@php echo @$view->data->bottomlinks['terms_text'];  @endphp"
                                           value="@php echo @$view->data->bottomlinks['terms_text'];  @endphp" data-form-field>
                                </div>
                            </div>
                        </div>
                        <div class="content__wrapper">
                            <div class="own-web" id="webmodal"
                                 style=" @php echo (@$view->data->bottomlinks['terms_type']=='m'?'display:block':'display:none') @endphp;">
                                <div class="classic-editor__wrapper froala-editor-full-width froala-editor-fixed-width funnel-setting-pages-editor">
                                    <textarea name="footereditor" id="footereditor"
                                              data-global_val="#text-area-content-global"
                                              data-val="#text-area-content"
                                              class="lp-froala-textbox global-text-area" data-form-field>
                                        @php echo @$view->data->bottomlinks['terms']; @endphp
                                    </textarea>
                                </div>
                            </div>
                            <div class="another-web" id="webaddress">
                                <div class="row align-items-center">
                                    <div class="col-2">
                                        <label class="m-0" for="otherurl">URL(with http://)</label>
                                    </div>
                                    <div class="col-10 pl-2">
                                        <div class="input__wrapper">
                                            <input id="theurl" name="theurl" class="form-control global-input-text"
                                                   data-global_val="{{ @$view->data->globalOptions['terms_url'] }}"
                                                   data-val="@php echo @$view->data->bottomlinks['terms_url'];@endphp"
                                                   value="@php echo @$view->data->bottomlinks['terms_url'];@endphp"
                                                   type="text" data-form-field>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                    {{-- <div class="row">
                         <button type="submit" class="button button-secondary">Save
                         </button>
                     </div>--}}
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </form>
            <div id="text-area-content"
                 style="display: none">@php echo htmlspecialchars_decode(@$view->data->bottomlinks['terms']) @endphp</div>
            <div id="text-area-content-global" style="display: none">{!! @$view->data->globalOptions['terms'] !!}</div>


        </section>
    </main>
@endsection
@push('body_classes') terms-of-use-settings-page @endpush
