@extends("layouts.leadpops-inner-sidebar")

@section('content')

    @php
        if(isset($view->data->clickedkey) && $view->data->clickedkey != "") {
            $firstkey = $view->data->clickedkey;
        }else {
            $firstkey = "";
        }
    @endphp

    {{--    @php  LP_Helper::getInstance()->getFunnelHeader($view);@endphp--}}
    @php
        $treecookie = \View_Helper::getInstance()->getTreeCookie($view->data->client_id,$firstkey);
    @endphp

    <main class="main">
        <section class="main-content">

            <form id="footer-page" action="">
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id" value="@php echo $view->data->client_id @endphp">
                <input type="hidden" name="theoption" id="theoption" value="thirdparty">
                <input type="hidden" name="logocolor" id="logocolor"
                       value="@php echo $view->data->advancedfooteroptions['logocolor']; @endphp">
                <input type="hidden" name="clientfname" id="clientfname"
                       value="@php echo $view->data->advancedfooteroptions["first_name"]; @endphp">
                <input type="hidden" name="changebtn" id="changebtn" value="0">
                <input type="hidden" name="templatetype" id="templatetype" value="">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash"
                       value="@php echo $view->data->currenthash @endphp">


                <input type="hidden" id="fp-modeowncolor-hex" name="fp-modeowncolor-hex" value="">
                <input type="hidden" id="fp-modeowncolor-rgb" name="fp-modeowncolor-rgb" value="">
                <input type="hidden" id="fp-bg_opacity" name="fp-bg_opacity" value="39">
                <!-- Title wrap of the page -->
            {{--    <div class="main-content__head main-content__head_tabs">
                    <div class="col-left">
                        <h1 class="title">
                            <span class="inner__title">Footer</span>
                        </h1>
                        <div class="disabled-wrapper el-tooltip" title="This feature is coming soon!">
                            <input id="footer-page" name="footer-page" data-toggle="toggle"
                                   data-onstyle="active" data-offstyle="inactive"
                                   data-width="127" data-height="43" data-on="INACTIVE"
                                   data-off="ACTIVE" type="checkbox">
                        </div>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Footer" data-lp-wistia-key="csu0gemvgx"
                           class="video-link lp-wistia-video" href="#" data-toggle="modal"
                           data-target="#lp-video-modal">
                            <span class="icon ico-video"></span>
                            Watch how to video
                        </a>
                    </div>
                </div>--}}
            @php

                $tabs = [
                        ["tab"=>"Options", "href"=>"#tbOptions", "active"=>true],
                        ["tab"=>"Colors", "href"=>"#tbColors", "disabled"=>true ]
                    ];
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, null, true);

            @endphp
            <!-- content of the page -->
                <div class="tab-content">
                    <div id="tbOptions" class="tab-pane active">
                        <div class="lp-panel py-0">
                            <div class="card-header">
                                <div class="lp-panel__head border-0 p-0">
                                    <div class="col-left">
                                        <h2 class="card-title">
                                            <span>
                                                Primary Footer Options
                                            </span>
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="card-link collapsed expandable" data-toggle="collapse"
                                             href="#primaryfooter"></div>
                                    </div>
                                </div>

                            </div>
                            <div id="primaryfooter" class="collapse show">
                                <div class="card-body">
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h3 class="lp-panel__title">
                                                    @php echo ($view->data->bottomlinks['privacy_text'] == "" ? "Privacy Policy" : $view->data->bottomlinks['privacy_text']);  @endphp
                                                </h3>
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/privacypolicy/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>

                                                                {{-- <a href="{{route('privacypolicy', [@$view->data->currenthash, 'app_theme' => 'theme_admin3'])}}" class="action__link">
                                                                     <span class="ico ico-edit"></span>edit page
                                                                 </a>--}}
                                                            </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["privacy_active"]=="y"){
                                                $checked="checked";
                                            }
                                                            @endphp
                                                            {{--  <input id="fp-privacy-policy" name="fp-privacy-policy"
                                                                     data-toggle="toggle"
                                                                     data-onstyle="active" data-offstyle="inactive"
                                                                     data-width="127" data-height="43" data-on="INACTIVE"
                                                                     data-off="ACTIVE" type="checkbox">--}}

                                                            <input @php echo $checked;@endphp class="pfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~privacy_active"
                                                                   data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43"
                                                                   data-on="INACTIVE" data-off="ACTIVE"
                                                                   type="checkbox">

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h3 class="lp-panel__title">
                                                    @php echo ($view->data->bottomlinks['terms_text'] == "" ? "Terms of Use" : $view->data->bottomlinks['terms_text']);  @endphp
                                                </h3>
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/termsofuse/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["terms_active"]=="y"){
                                                $checked="checked";

                                            }
                                                            @endphp
                                                            <input @php echo $checked; @endphp class="pfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~terms_active"
                                                                   data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                                   data-off="ACTIVE" type="checkbox">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h3 class="lp-panel__title">
                                                    @php echo ($view->data->bottomlinks['disclosures_text'] == "" ? "Disclosures" : $view->data->bottomlinks['disclosures_text']);  @endphp
                                                </h3>
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/disclosures/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["disclosures_active"]=="y"){
                                                $checked="checked";

                                            }
                                                            @endphp
                                                            <input @php echo $checked; @endphp class="pfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~disclosures_active"
                                                                   data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                                   data-off="ACTIVE" type="checkbox">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h3 class="lp-panel__title">
                                                    @php echo ($view->data->bottomlinks['licensing_text'] == "" ? "Licensing Information" : $view->data->bottomlinks['licensing_text']);  @endphp
                                                </h3>
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/licensinginformation/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["licensing_active"]=="y"){
                                                $checked="checked";

                                            }
                                                            @endphp
                                                            <input @php echo $checked; @endphp class="pfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~licensing_active"
                                                                   data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                                   data-off="ACTIVE" type="checkbox">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h3 class="lp-panel__title">
                                                    @php echo ($view->data->bottomlinks['about_text'] == "" ? "About Us" : $view->data->bottomlinks['about_text']);  @endphp
                                                </h3>
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/aboutus/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["about_active"]=="y"){
                                                $checked="checked";

                                            }
                                                            @endphp
                                                            <input @php echo $checked; @endphp class="pfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~about_active"
                                                                   data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                                   data-off="ACTIVE" type="checkbox">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <h3 class="lp-panel__title">
                                                    @php echo ($view->data->bottomlinks['contact_text'] == "" ? "Contact Us" : $view->data->bottomlinks['contact_text']);  @endphp
                                                </h3>
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/contactus/".$view->data->currenthash; @endphp?app_theme=theme_admin3"
                                                                   class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["contact_active"]=="y"){
                                                $checked="checked";
                                            }
                                                            @endphp
                                                            <input @php echo $checked; @endphp class="pfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~contact_active"

                                                                   data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                                   data-off="ACTIVE" type="checkbox">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel py-0">
                            <div class="card-header">
                                <div class="lp-panel__head border-0 p-0">
                                    <div class="col-left">
                                        <h2 class="card-title">
                                            <span>
                                                Secondary Footer Options
                                            </span>
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="card-link collapsed expandable" data-toggle="collapse"
                                             href="#secondaryfooter"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="secondaryfooter" class="collapse">
                                <div class="card-body">
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <input class="form-control line-input lp-footer-textbox" disabled
                                                       value="@php echo $view->data->bottomlinks['compliance_text']; @endphp"
                                                       id="compliance_text"
                                                       type="text">
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                                <span class="action__span action__span_toggle">
                                                                    <a href="javascript:void(0)"
                                                                       class="action__link action__link_edit">
                                                                        <span class="ico ico-edit"></span>edit
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                       class="action__link action__link_cancel">
                                                                        <span class="ico ico-cross"></span>cancel
                                                                    </a>
                                                                </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["compliance_active"]=="y"){
                                            $checked="checked";
                                            }
                                                            @endphp

                                                            <input @php echo $checked; @endphp class="sfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~compliance_active"
                                                                   data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                                   data-off="ACTIVE" type="checkbox">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        @php
                                            $checked="";
                                            $disable="disabled";
                                            if($view->data->bottomlinks['compliance_is_linked']=='y') {
                                            $checked='checked';
                                            $disable="";
                                            }
                                        @endphp

                                        <div class="collapse-box hide border-top-0">
                                            <div class="row align-items-center">
                                                <div class="col-sm-4 col-xl-2">
                                                    <div class="checkbox mt-2">
                                                        <input @php echo $checked; @endphp type="checkbox"
                                                               name="compliance_is_linked" class="collapse-checkbox"
                                                               id="compliance_is_linked" data-tarele="compliance_link"
                                                               value="y">
                                                        <label class="normal-font" for="checkboxcomplainlink">
                                                            Link to URL
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 col-xl-7">
                                                    <div class="form-group m-0">

                                                        <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                                        <input class="form-control collapse-next-input" type="text"
                                                               name="compliance_link"
                                                               value="@php echo $view->data->bottomlinks['compliance_link']; @endphp"
                                                               id="compliance_link" @php echo $disable; @endphp>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-panel">
                                        <div class="lp-panel__head">
                                            <div class="col-left">
                                                <input class="form-control line-input" disabled
                                                       name="license_number_text"
                                                       value="@php echo $view->data->bottomlinks['license_number_text']; @endphp"
                                                       id="license_number_text"
                                                       type="text">
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item action__item_separator">
                                                                <span class="action__span action__span_toggle">
                                                                    <a href="javascript:void(0)"
                                                                       class="action__link action__link_edit">
                                                                        <span class="ico ico-edit"></span>edit
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                       class="action__link action__link_cancel">
                                                                        <span class="ico ico-cross"></span>cancel
                                                                    </a>
                                                                </span>
                                                        </li>
                                                        <li class="action__item">
                                                            @php $checked="";
                                            if($view->data->bottomlinks["license_number_active"]=="y"){
                                            $checked="checked";
                                            }
                                                            @endphp
                                                            <input @php echo $checked; @endphp class="sfobtn"
                                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~license_number_active"
                                                                   id="fp-terms" name="fp-terms" data-toggle="toggle"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="127" data-height="43" data-on="INACTIVE"
                                                                   data-off="ACTIVE" type="checkbox">
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="collapse-box hide">
                                            <div class="row align-items-center">
                                                <div class="col-sm-4 col-xl-2">
                                                    <div class="checkbox mt-2">
                                                        @php
                                                            $checked="";
                                                            $disable="disabled";

                                                            if($view->data->bottomlinks['license_number_is_linked']=='y') {
                                                            $checked='checked';
                                                            $disable="";
                                                            }
                                                        @endphp

                                                        <input @php echo $checked; @endphp type="checkbox"
                                                               class="collapse-checkbox"
                                                               id="license_number_is_linked"
                                                               name="license_number_is_linked"
                                                               data-tarele="license_number_link" value="y">
                                                        <label class="normal-font" for="checkboxLicensenumber">
                                                            Link to URL
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8 col-xl-7">
                                                    <div class="form-group m-0">
                                                        <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                                        <input class="form-control collapse-next-input"
                                                               name="license_number_link"
                                                               value="@php echo $view->data->bottomlinks['license_number_link']; @endphp"
                                                               id="license_number_link"
                                                               type="text" @php echo $disable; @endphp>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lp-panel__footer mt-0 pt-4 border-top-0">
                                        <div class="row">
                                            <div class="col text-center">
                                                <button type="submit"
                                                        onclick="return compliance_update('@php echo $view->data->lpkeys @endphp');"
                                                        class="button button-secondary">Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel py-0">
                            <div class="card-header">
                                <div class="lp-panel__head border-0 p-0">
                                    <div class="col-left">
                                        <h2 class="card-title">
                                                <span>
                                                    Super Footer Options
                                                    <!-- <span class="new">(new feature!)</span> -->
                                                </span>
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <div class="card-link collapsed expandable ml-3 col-super-footer"
                                                         data-toggle="collapse" href="#superfooter"></div>
                                                </li>
                                                <li class="action__item">
                                                    @php $checked="";
                                    if($view->data->bottomlinks["advanced_footer_active"]=="y"){
                                    $checked="checked";
                                    }
                                                    @endphp
                                                    <input @php echo $checked; @endphp class="pfobtn"
                                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~advanced_footer_active"
                                                           data-toggle="toggle"
                                                           data-onstyle="active" data-offstyle="inactive"
                                                           data-width="127" data-height="43" data-on="INACTIVE"
                                                           data-off="ACTIVE" type="checkbox">
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="superfooter" class="collapse">
                                <div class="card-body">
                                    <div class="lp-panel">
                                        <div class="classic-editor__wrapper">
                                                <textarea class="lp-froala-textbox">
                                                    @php  echo $view->data->bottomlinks["advancehtml"]; @endphp
                                                    {{-- <div class="container advanced-container">
                                                         <div class="row">
                                                             <div class="col-sm-12">
                                                                 <h2 class="funnel__title">
                                                                     How this works...
                                                                 </h2>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="col-lg-5">
                                                                 <div class="box funnel__box">
                                                                     <div class="box__counter">1</div>
                                                                     <div class="box__content">
                                                                         <h3 class="box__heading">
                                                                             <span style="font-size: 20px;">60-Second Digital Pre-Approval</span>
                                                                         </h3>
                                                                         <p class="box__des">Share some basic info; if qualified, we'll provide you with a free, no-obligation pre-approval letter.</p>
                                                                     </div>
                                                                 </div>
                                                                 <div class="box funnel__box">
                                                                     <div class="box__counter">2</div>
                                                                     <div class="box__content">
                                                                         <h3 class="box__heading">
                                                                             <span style="font-size: 20px;">Choose the Best Options for You</span>
                                                                         </h3>
                                                                         <p class="box__des">Choose from a variety of loan options,
                                                                             including our conventional 20% down product.<br><br>
                                                                             We also offer popular 5%-15% down home loans... AND
                                                                             we can even go as low as 0% down.
                                                                         </p>
                                                                     </div>
                                                                 </div>
                                                                 <div class="box funnel__box">
                                                                     <div class="box__counter">3</div>
                                                                     <div class="box__content">
                                                                         <h3 class="box__heading">
                                                                             <span style="font-size: 20px;">Start Shopping for Your Home!</span>
                                                                         </h3>
                                                                         <p class="box__des">It only takes about 60 seconds to get everything under way.
                                                                             Simply enter your zip code right now.
                                                                         </p>
                                                                     </div>
                                                                 </div>
                                                                 <!-- <a class="funnel__btn" href="#">Find My 203K</a> -->
                                                                 <div style="text-align: center;margin: 20px auto;">
                                                                     <a class="lp-btn__go" href="#GetStartedNow"
                                                                        id="btn-submit" tabindex="-1" title="">
                                                                         Get Started Now!
                                                                     </a>
                                                                 </div>
                                                                 <div class="funnel__caption">
                                                                     <p style="text-align: center; margin-left: 20px;">
                                                                         <em>
                                                                             <span style="font-size: 11px;">
                                                                                 This hassle-free process only takes about 60 seconds,
                                                                                 &nbsp;</span>
                                                                         </em>
                                                                         <br>
                                                                         <em>
                                                                             <span style="font-size: 11px;">and it won't affect your credit score!</span>
                                                                         </em>
                                                                     </p>
                                                                     <p>
                                                                         <br></p>
                                                                 </div>
                                                             </div>
                                                             <div class="col-lg-7">
                                                                 <div class="animate-container">
                                                                     <div class="first animated desktop slideInRight">
                                                                         <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-1.png"
                                                                              class="fr-fic fr-dii fr-draggable">
                                                                     </div>
                                                                     <div class="second animated desktop fadeIn">
                                                                         <h2 class="animate__heading"
                                                                             style="font-size: 18px;">
                                                                             <span style="font-size: 18px;">Share some basic info</span>
                                                                         </h2>
                                                                         <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-2.png"
                                                                              class="fr-fic fr-dii fr-draggable">
                                                                     </div>
                                                                     <div class="third animated desktop zoomIn">
                                                                         <strong><span
                                                                                     style="color: rgb(3, 177, 253); font-size: 18px;">10% Down</span></strong>
                                                                     </div><div
                                                                             class="fourth animated desktop fadeInLeft">
                                                                         <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-4.png"
                                                                              class="fr-fic fr-dii fr-draggable">
                                                                     </div>
                                                                     <div class="fifth animated desktop slideInRight">
                                                                         <p>
                                                                             <span class="clientfname">Hi, I'm pete, your loan&nbsp;</span>officer.<br>
                                                                             It looks like you may qualify for<br>a lot more than you thought!
                                                                         </p>
                                                                     </div>
                                                                 </div>
                                                                 <div class="clearfix">
                                                                     <br>
                                                                 </div>
                                                                 <p>
                                                                     <br>
                                                                 </p>
                                                             </div>
                                                             <br>
                                                         </div>
                                                         <p>
                                                             <br>
                                                         </p>
                                                     </div>--}}
                                                </textarea>
                                        </div>
                                        <div class="lp-panel__footer mt-4 pt-4">
                                            <div class="row">
                                                <div class="col pr-0 d-flex align-items-center">
                                                    <div class="superfooter">
                                                            <span class="reset-froala"
                                                                  onclick="activetodefaultadvancedfooter()">
                                                                <i class="ico ico-undo"></i> reset default
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="col-2 p-0 text-center">
                                                    <button type="submit"
                                                            onclick="return advancefooter_update('@php echo $view->data->lpkeys @endphp');"
                                                            class="button button-secondary">Save
                                                    </button>
                                                </div>
                                                <div class="col p-0 flex-row-reverse d-flex align-items-center footer-content-text">
                                                    <div class="checkbox h-100 ml-3 mt-2">

                                                        @php $checked="";
                                            if($view->data->bottomlinks["hide_primary_footer"] == "y"){
                                            $checked="checked";
                                            }
                                                        @endphp

                                                        <input @php echo $checked; @endphp class="sub-group"
                                                               id="hideofooter"
                                                               data-key="hideofooter" name="hideofooter"
                                                               type="checkbox">
                                                        <label class="normal-font" for="footercontenthide"></label>
                                                    </div>
                                                    Hide Primary and Secondary footer&nbsp;content
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <div class="row">
                                <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                            </div>
                        </div>
                    </div>
                    <div id="tbColors" class="tab-pane">
                        <div class="lp-panel pb-0">
                            <div class="lp-panel__head pb-2">
                                <div class="col-left">
                                    <h2 class="card-title"><span>Customize Your</span> Own Colors</h2>
                                </div>
                                <div class="col-right">
                                    <ul class="nav nav__tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#footer">
                                                Footer
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#text">
                                                Text
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="lp-panel__body p-0">
                                <div class="tab-content">
                                    <div id="footer" class="tab-pane fade in show active">
                                        <div class="card-body border-0">
                                            <div class="owncolor p-0">
                                                <div class="owncolor__wrapper">
                                                    <div class="fpPageowncolor__box owncolor__box"></div>
                                                    <div class="owncolor__info">
                                                        <label for="selectedcolor">Selected Color</label>
                                                        <div class="last-selected">
                                                            <div class="last-selected__box"></div>
                                                            <div class="last-selected__code">#e6eef3</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="owncolor__controls">
                                                    <div class="head">
                                                        <h2>Add custom color code</h2>
                                                    </div>
                                                    <div class="owncolor__inner">
                                                        <div class="form-group">
                                                            <label>Color Mode</label>
                                                            <div class="main__control">
                                                                <div class="select2__fpPage-colormode-parent">
                                                                    <select class="select2__fpPage-colormode">
                                                                        <option value="hex" selected="">HEX</option>
                                                                        <option value="rbg">RGB</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fpPage-colorval">Color Value</label>
                                                            <div class="main__control">
                                                                <input id="fpPage-colorval" class="form-control"
                                                                       value="#34409E" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fp-opacity">Opacity</label>
                                                            <div class="main__control">
                                                                <input id="ex1" class="form-control select2__fp-overlay"
                                                                       data-slider-id='ex1Slider' type="text"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="text" class="tab-pane fade">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <i class="ico ico-info"></i>
                                                <span>Select single color for all footer text elements</span>
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body__row">
                                                <div class="clr-elm__wrapper">
                                                    <div class="col-clr justify-content-start">
                                                        <label for="selectedcolor">Text Color</label>
                                                        <div id="clr-txt" class="last-selected">
                                                            <div class="last-selected__box"
                                                                 style="background: #effbff"></div>
                                                            <div class="last-selected__code">#effbff</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <div class="row">
                                <button type="submit" class="button button-secondary">Save</button>
                            </div>
                            <div class="row">
                                <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection

