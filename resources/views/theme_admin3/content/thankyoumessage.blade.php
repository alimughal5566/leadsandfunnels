@extends("layouts.leadpops-inner-sidebar")

@section('content')

    @php

  //  dd(@$view->data->globalOptions);
        if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
            $firstkey = @$view->data->clickedkey;
        }else {
            $firstkey = "";
        }
        $default_logo = \View_Helper::getInstance()->getCurrentLogoImageSource(@$view->data->client_id,0,@$view->data->funnelData);
              //  LP_Helper::getInstance()->getFunnelHeader($view);
         $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
         $view->route = route('thankyou', ['hash' => $view->data->currenthash, 'app_theme' => 'theme_admin3']);
         $view->title = 'BACK TO THANK YOU PAGE OPTIONS';
    @endphp

    <main class="main">
        <!-- content of the page -->
        <form class="form-inline global-content-form" id="thankYouMessageForm" name="" method="POST"
              data-global_action="{{route('GlobalSaveThankyouMessageAdminThree')}}"
              data-action="@php echo LP_BASE_URL.LP_PATH."/popadmin/thankmessagesave"; @endphp"
              action="@php echo LP_BASE_URL.LP_PATH."/popadmin/thankmessagesave"; @endphp">
            <section class="main-content w-100">

                <!-- Title wrap of the page -->
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id" value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="theoption" id="theoption" value="thankyou">
                <input type="hidden" name="theselectiontype" id="theselectiontype" value="submissionthankyou">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedfirstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash"
                       value="@php echo @$view->data->currenthash @endphp">
                @php
                    $_funnel_data=json_encode(@$view->data->funnelData,JSON_HEX_APOS);
                @endphp
                <input type="hidden" name="funneldata" id="funneldata" value='{{ $_funnel_data }}'>
                <input type="hidden" name="thankyou_logo" id="thankyou_logo"
                       value="@php echo @$view->data->submission['thankyou_logo']; @endphp">
                <input type="hidden" id="clientfname"
                       value="@php echo @$view->session->clientInfo->first_name; @endphp">
                <img class="hide d-none" name="default_logo" id="default_logo" src="@php echo $default_logo; @endphp"/>
                @php LP_Helper::getInstance()->getFunnelHeaderAdminThreeThankYouPage($view, @$view->data->currenthash) @endphp
                @include("partials.flashmsgs")
                <div id="msg"></div>
                <!-- content of the page -->
                <div class="lp-panel lp-email-box">
                    <div class="lp-panel__head lp-panel__head_thankyou-edit">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Thank You Message
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item action__item_en-logo">
                                        @php
                                            $protocol = "http://";
                                            if(@$view->is_secured){
                                                $protocol = "https://";
                                            }
                                            $hash_url=$protocol.trim(str_replace(" ","",@$view->data->workingLeadpop))."/thank-you.html?hash=".@$view->data->currenthash;
                                            $preview_url=$protocol.trim(str_replace(" ","",@$view->data->workingLeadpop))."/thank-you.html?preview=1&hash=".@$view->data->currenthash;
                                        @endphp

                                        <input @php echo (@$view->data->submission['thankyou_logo'] == 1 ? "checked" : ""); @endphp
                                               class="responder-toggle typ_logo" for="typ_logo" id="typ_logo"
                                               onchange="logo_trigger()"
                                               {{--name="enlogo"--}}
                                               data-thelink="en-logo_active" data-field="typ_logo" data-toggle="toggle"
                                               data-onstyle="active" data-offstyle="inactive"
                                               data-width="182" data-height="50" data-on="logo disabled"
                                               data-off="logo enabled" type="checkbox">
                                    </li>
                                    <li class="action__item">
                                        <a target="_blank"
                                           href="@php echo $preview_url;@endphp"
                                           class="button button-secondary">
                                            preview
                                        </a>
                                    </li>
                                    <li class="action__item">
                                        <button type="button" id="clone-url" class="button button-primary">
                                            Copy Preview URL
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="lp-panel__body lp-panel__thankyou-editor">
                        <div class="default__panel classic-editor__wrapper froala-editor-fixed-width froala-editor-thank-you-page funnel-setting-pages-editor">
                            <input class="lp-thankyou-edit-textbox" name="thankyou_slug" type="hidden"
                                   id="thankyou_slug" value="thank.you.html">
                            <div class="thank-you-slug" id="url-text"
                                 style="display:none">@php echo $hash_url;@endphp</div>
                            <div id="textwrapper" class="">
                                    <textarea class="lp-froala-textbox classic-editor" id="tfootereditor1" name="tfootereditor" data-form-field>{!! stripslashes( @$view->data->submission['thankyou']) !!}</textarea>
                            </div>
                            <!--<div class="thank-you-editor classic-editor"></div>-->
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                   {{-- <div class="row">
                        <button type="submit" class="button button-secondary">SAVE</button>
                    </div>--}}
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </section>
        </form>

    </main>
    <div id="globalHtml" style="display: none">{!! stripslashes(@$view->data->globalOptions['thankyou_message'])  !!}</div>
    <div id="contentHtml" style="display: none">{!! stripslashes( @$view->data->submission['thankyou']) !!}</div>
@endsection

@push('body_classes') thank-you-message-settings-page @endpush
