@extends("layouts.leadpops")

@section('content')
    @php
        if(isset($view->data->clickedkey) && $view->data->clickedkey != "") {
            $firstkey = $view->data->clickedkey;
        }else {
            $firstkey = "";
        }
    @endphp
    <section id="page-footer">
        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="success-alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success:</strong>
                        <span>Secondary Footer Option has been saved.</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success" id="advanced-success-alert">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success:</strong>
                        <span>Advanced Footer Option has been saved.</span>
                    </div>
                </div>
            </div>

            @php  LP_Helper::getInstance()->getFunnelHeader($view);@endphp
            @php
                $treecookie = \View_Helper::getInstance()->getTreeCookie($view->data->client_id,$firstkey);
            @endphp
            <form class="form-inline" role="form">
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
                <div class="lp-thankyou">
                    <div class="lp-thankyou-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-collapse"><h2 class="footer-head-color">Primary Footer Options</h2>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right">
                                    <a href="#primary-footer" data-toggle="collapse" id="lp-footer-collapse"
                                       class="lp-footer-collapse footer-expand"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="primary-footer" class="collapse">
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left"><h3
                                                    class="lp-heading-3">@php echo ($view->data->bottomlinks['privacy_text'] == "" ? "Privacy Policy" : $view->data->bottomlinks['privacy_text']);  @endphp</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/privacypolicy/".$view->data->currenthash; @endphp"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["privacy_active"]=="y"){
                                                $checked="checked";
                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="pfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~privacy_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left"><h3
                                                    class="lp-heading-3">@php echo ($view->data->bottomlinks['terms_text'] == "" ? "Terms of Use" : $view->data->bottomlinks['terms_text']);  @endphp</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/termsofuse/".$view->data->currenthash; @endphp"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["terms_active"]=="y"){
                                                $checked="checked";

                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="pfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~terms_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left"><h3
                                                    class="lp-heading-3">@php echo ($view->data->bottomlinks['disclosures_text'] == "" ? "Disclosures" : $view->data->bottomlinks['disclosures_text']);  @endphp</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/disclosures/".$view->data->currenthash; @endphp"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["disclosures_active"]=="y"){
                                                $checked="checked";

                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="pfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~disclosures_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left"><h3
                                                    class="lp-heading-3">@php echo ($view->data->bottomlinks['licensing_text'] == "" ? "Licensing Information" : $view->data->bottomlinks['licensing_text']);  @endphp</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/licensinginformation/".$view->data->currenthash; @endphp"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["licensing_active"]=="y"){
                                                $checked="checked";

                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="pfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~licensing_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left"><h3
                                                    class="lp-heading-3">@php echo ($view->data->bottomlinks['about_text'] == "" ? "About Us" : $view->data->bottomlinks['about_text']);  @endphp</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/aboutus/".$view->data->currenthash; @endphp"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["about_active"]=="y"){
                                                $checked="checked";

                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="pfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~about_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left"><h3
                                                    class="lp-heading-3">@php echo ($view->data->bottomlinks['contact_text'] == "" ? "Contact Us" : $view->data->bottomlinks['contact_text']);  @endphp</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="@php echo LP_BASE_URL.LP_PATH."/popadmin/contactus/".$view->data->currenthash; @endphp"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT PAGE</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["contact_active"]=="y"){
                                                $checked="checked";
                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="pfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~contact_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-thankyou">
                    <div class="lp-thankyou-head">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-collapse"><h2 class="footer-head-color =">Secondary Footer Options</h2>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right">
                                    <a href="#secondary-footer" data-toggle="collapse" id="lp-footer-collapse"
                                       class="lp-footer-collapse footer-expand"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="secondary-footer" class="collapse">
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left">
                                            <label for="Compliance" class="lp-label" id="compliance">Compliance
                                                Text:</label>
                                            <input type="text" name="compliance_text"
                                                   value="@php echo $view->data->bottomlinks['compliance_text']; @endphp"
                                                   id="compliance_text" class="lp-footer-textbox " disabled>
                                        <!--<label for="Compliance" class="lp-label" id="compliance">@php
                                            /* if($view->data->bottomlinks['compliance_is_linked']=='y'){
                                                 $compliance_link = $view->data->bottomlinks['compliance_link'];
                                                 if($compliance_link==''){
                                                     $compliance_link = '#';
                                                 }
                                                 echo "".$view->data->bottomlinks['compliance_text']."";
                                             }else{
                                                 echo $view->data->bottomlinks['compliance_text'];
                                             }
                                             */@endphp</label>-->

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="#" class="lp_footer_toggle_compliance"
                                               data-togele="lp-footer-url-edit"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["compliance_active"]=="y"){
                                            $checked="checked";
                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="sfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~compliance_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="lp-footer-url-edit" class="hide">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="lp-thankyou-head">
                                        @php
                                            $checked="";
                                            $disable="disabled";
                                            if($view->data->bottomlinks['compliance_is_linked']=='y') {
                                            $checked='checked';
                                            $disable="";
                                            }
                                        @endphp
                                        <input @php echo $checked; @endphp  type="checkbox" name="compliance_is_linked"
                                               id="compliance_is_linked" data-tarele="compliance_link" value="y"/>
                                        <label class="lp-footer-label" for="compliance_is_linked"><span
                                                    class="lp-checkbox-icon"></span>Link Text to URL</label>
                                        <label for="" class="control-label lp-footer-label">
                                            URL
                                        </label>
                                        <input type="text" class="lp-footer-textbox-2" name="compliance_link"
                                               value="@php echo $view->data->bottomlinks['compliance_link']; @endphp"
                                               id="compliance_link" @php echo $disable; @endphp>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-8">
                                        <div class="col-left">
                                            <label for="License" class="lp-label" id="licence">License #:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                            <input class="lp-footer-textbox " type="text" name="license_number_text"
                                                   value="@php echo $view->data->bottomlinks['license_number_text']; @endphp"
                                                   id="license_number_text" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <a href="#" class="lp_footer_toggle_licence"
                                               data-togele="lp-footer1-url-edit"><i
                                                        class="glyphicon glyphicon-pencil"></i>EDIT</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="custom-btn-toggle">
                                            @php $checked="";
                                            if($view->data->bottomlinks["license_number_active"]=="y"){
                                            $checked="checked";
                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="sfobtn"
                                                   data-lpkeys="@php echo $view->data->lpkeys; @endphp~license_number_active"
                                                   data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                   data-width="100" data-on="INACTIVE" data-off="ACTIVE"
                                                   type="checkbox">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="lp-footer1-url-edit" class="hide">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="lp-thankyou-head">
                                        @php
                                            $checked="";
                                            $disable="disabled";

                                            if($view->data->bottomlinks['license_number_is_linked']=='y') {
                                            $checked='checked';
                                            $disable="";
                                            }
                                        @endphp
                                        <input @php echo $checked; @endphp type="checkbox"
                                               name="license_number_is_linked" id="license_number_is_linked"
                                               data-tarele="license_number_link" value="y"/>
                                        <label class="lp-footer-label" for="license_number_is_linked"><span
                                                    class="lp-checkbox-icon"></span>Link Text to URL</label>
                                        <label for="" class="control-label lp-footer-label">
                                            URL
                                        </label>
                                        <input type="text" class="lp-footer-textbox-2" name="license_number_link"
                                               value="@php echo $view->data->bottomlinks['license_number_link']; @endphp"
                                               id="license_number_link" @php echo $disable; @endphp>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="lp-footer-save">
                                    <div class="custom-btn-success">
                                        <button type="button"
                                                onclick="return compliance_update('@php echo $view->data->lpkeys @endphp');"
                                                class="btn btn-success"><strong>SAVE</strong></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <style type="text/css">
                    #hide-other {
                        padding: 10px 0;
                    }

                    #hide-other input[type="checkbox"] {
                        display: none;
                    }

                    #hide-other input[type="checkbox"]:checked + label span {
                        background: url({{LP_ASSETS_PATH}}/adminimages/checkbox.png) -27px top no-repeat;
                    }

                    #hide-other input[type="checkbox"] + label span {
                        display: inline-block;
                        width: 26px;
                        height: 27px;
                        margin: 0 0 0 15px;
                        vertical-align: middle;
                        background: url({{LP_ASSETS_PATH}}/adminimages/checkbox.png) left top no-repeat;
                        cursor: pointer;
                    }

                    /*#hide-other input[type="checkbox"]:hover + label span {
                        background:url(
                    {{LP_ASSETS_PATH}}
                    /lp_assets/adminimages/modal-checkbox.png) -52px top no-repeat !important;
                                        }*/
                    #hide-other input[type="checkbox"]:checked + label span {
                        background: url({{LP_ASSETS_PATH}}/adminimages/modal-checkbox.png) -26px top no-repeat !important;
                    }

                    #hide-other label {
                        color: #768086;
                        font-size: 14px;
                        font-weight: 700;
                        margin-bottom: 0;
                        margin-left: 60px;
                    }

                    .lp-footer-save .col-center {
                        padding: 14px !important;
                        text-align: center;
                    }

                    .lp-footer-save .col-center span:first-child {
                        font-size: 16px;
                        color: #768086;
                        padding-right: 8px;
                        font-weight: 400;
                    }

                    .lp-footer-save .col-center span:last-child {
                        font-size: 14px;
                        font-weight: 700;
                        color: #768086;
                    }

                    .box__counter {
                        border: 2px solid@php echo $view->data->advancedfooteroptions["logocolor"]; @endphp;
                    }

                    .animate-container .fifth.desktop::after {
                        border-bottom: 16px solid@php echo $view->data->advancedfooteroptions["logocolor"]; @endphp;
                    }

                    .animate-container .fifth.desktop {
                        background-color: @php echo $view->data->advancedfooteroptions["logocolor"]; @endphp;
                    }

                    a.lp-btn__go, a[href^="#GetStartedNow"] {
                        font-family: "Open Sans", sans-serif;
                        padding: 0.5em 1em;
                        border-radius: 50px;
                        line-height: 1;
                        background-color: rgb(255, 135, 0);
                        border: 2px solid rgb(255, 135, 0);
                        text-transform: uppercase;
                        color: #fff !important;
                        font-weight: 700;
                        text-decoration: none;
                        text-align: center;
                        margin: auto;
                        transition: all 0.3s linear 0s;
                        margin-bottom: 0;
                        box-shadow: 2px 6px 14px 0 rgba(0, 0, 0, 0.2);
                        vertical-align: middle;
                        -ms-touch-action: manipulation;
                        touch-action: manipulation;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        user-select: none;
                        background-image: none;
                        position: relative;
                        z-index: 100;
                        display: inline-block;
                    }

                    .bombbombwrapper {
                        display: inline-block;
                        width: 80px;
                        vertical-align: top;
                        margin-top: 8px;
                        margin-left: 10px;
                        cursor: pointer;
                    }

                    /*a.lp-btn__go, a[href^="#GetStartedNow"] span , a.lp-btn__go:hover span, a[href^="#GetStartedNow"]:hover span{
                        display: inline-block;
                        vertical-align: sub;
                    }*/
                    a.lp-btn__go:hover, a[href^="#GetStartedNow"]:hover {
                        background-color: transparent;
                        border: 2px solid rgb(255, 135, 0);
                        color: #000 !important;
                        transition: all 0.3s linear 0s !important
                    }

                    .fr-popup .fr-action-buttons button.fr-command {
                        color: #1e88e5 !important;
                    }

                    .fr-wrapper p, .fr-wrapper h1, .fr-wrapper h2, .fr-wrapper h3, .fr-wrapper h5, .fr-wrapper h6, .fr-box.fr-basic .fr-element, .fr-wrapper div {
                        color: #5b5b5b;
                    }

                    .fr-box.fr-basic .fr-element {
                        padding: 40px 10px 11px 10px;

                    }

                    .quote-description {
                        font-weight: 500;
                        color: #787878;
                        font-size: 14px;
                    }

                    hr.quote-divider {
                        width: 100%;
                        height: 2px;
                        background-color: #ececec;
                        margin: 30px auto;
                        border-top: 0;
                        padding: 0;
                    }

                    /*Review Block Template 1*/
                    .lp-contact-review {
                        margin-top: 10px;
                        /*border-top: 2px solid #f2f2f2;*/
                        padding: 20px 40px;
                    }

                    .lp-contact-review .block-quote {
                        font-family: "Open Sans";
                        font-size: 14px;
                        font-weight: 600;
                        line-height: 1.4;
                        color: #919191;
                        padding: 0;
                        font-style: normal;
                        text-align: left;
                        border-bottom: 1px solid #f2f2f2;
                        border-left: none;
                        margin: 0 40px 0 0;
                        padding-bottom: 20px;
                        background: url({{LP_ASSETS_PATH}}/adminimages/quotes-1.png) right top no-repeat;
                    }

                    .lp-contact-review .block-quote p {
                        font-family: "Open Sans";
                        font-size: 14px;
                        font-weight: 600;
                        line-height: 1.4;
                        color: #919191;
                        padding: 0;
                        font-style: normal;
                        text-align: left;
                        margin: 0;
                        font-style: italic;
                    }

                    .bombomb_desc {
                        position: absolute;
                        display: inline-block;
                        white-space: normal;
                        line-height: 1.2;
                        font-size: 10px;
                        width: 200px;
                        box-shadow: 1px 1px 1px #ccc;
                        padding: 5px 10px;
                        border: 1px solid #ccc;
                        right: 0;
                        top: 33px;
                        background-color: #fff;
                        z-index: 100;
                        display: none;;

                    }

                    .lp-contact-review .desc {
                        padding-top: 32px;
                    }

                    /*.lp-contact-review .lp-contact-review__img {

                    }*/
                    .lp-contact-review .lp-contact-review__img .fr-fic.fr-dii {
                        float: left;
                        width: 85px;
                        border: 3px solid@php echo $view->data->advancedfooteroptions["logocolor"]; @endphp;
                        border-radius: 100px;
                        margin-top: -8px;
                        min-height: 85px;
                        margin-right: 24px;
                        /*width: 100%;*/
                        height: auto;
                        object-fit: cover;
                        line-height: 0;
                        display: block;
                        border-radius: 100%;
                    }

                    .lp-contact-review .info {
                        float: left;
                        /*width: calc(100% - 110px);*/
                        text-align: left;
                    }

                    .lp-contact-review .info h6 {
                        font-size: 22px;
                        color: #1a1a1a;
                        line-height: 20px;
                        font-family: "Open Sans";
                        font-weight: 700;
                        margin-bottom: 10px;
                        margin-top: 0;
                    }

                    .lp-contact-review .info p {
                        font-family: "Open Sans";
                        font-size: 13px;
                        color: #6f6e6e;
                        line-height: 15px;
                        font-weight: 700;
                        margin-bottom: 10px;
                    }

                    .fr-wrapper .rating-wrapper {
                        position: relative;
                        float: left;
                        display: inline-block;
                        width: 17px;
                        height: 14px
                    }

                    .fr-wrapper .rating-wrapper img {
                        position: absolute;
                        top: 0;
                        left: 0;
                        height: 14px;
                        /*background: url(../../../../../../../../lp_assets/adminimages/stars1.1.png) no-repeat;*/
                        margin: 0 auto;
                    }

                    .fr-view .secure-template-title strong {
                        display: inline-block;
                    }

                    .co_branded .lp-contact-review {
                        margin-top: 10px;
                        padding: 0 40px;
                        display: inline-block;
                    }

                    .co_branded {
                        padding: 10px 0;
                    }

                    /*Review Block Template 1*/
                </style>

                <div class="lp-thankyou" id="advance-footer-wrapper">
                    <div class="lp-thankyou-head">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="col-collapse"><h2 class="footer-head-color =">Super Footer Options</h2>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-btn-toggle">
                                    @php $checked="";
                                    if($view->data->bottomlinks["advanced_footer_active"]=="y"){
                                    $checked="checked";
                                    }
                                    @endphp
                                    <input @php echo $checked; @endphp class="pfobtn"
                                           data-lpkeys="@php echo $view->data->lpkeys; @endphp~advanced_footer_active"
                                           data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                           data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right">
                                    <a href="#advance-footer" data-toggle="collapse" id="lp-footer-collapse"
                                       class="lp-footer-collapse footer-expand"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="advance-footer" class="collapse">
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                </div>
                            </div>
                        </div>
                        <div class="lp-thankyou-head">
                            <div class="row">
                                <div class="lp-custom-width">
                                    <div class="col-md-12">
                                        <div class="col-left local-super-footer">
                                        <textarea class="lp-froala-textbox">
                                         @php  echo $view->data->bottomlinks["advancehtml"]; @endphp
                                        </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="lp-footer-save">
                                <div class="custom-btn-success">
                                    <div class="col-md-2">
                                        <div class="col-center">
                                            <span class="fa fa-rotate-left"></span><span style="cursor: pointer;"
                                                                                         onclick="activetodefaultadvancedfooter()">RESET DEFAULT</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-push-1">
                                        <button type="button"
                                                onclick="return advancefooter_update('@php echo $view->data->lpkeys @endphp');"
                                                class="btn btn-success save_option"><strong>SAVE</strong></button>
                                    </div>
                                    <div class="col-md-5" class="col-center">
                                        <div id="hide-other">
                                            @php $checked="";
                                            if($view->data->bottomlinks["hide_primary_footer"] == "y"){
                                            $checked="checked";
                                            }
                                            @endphp
                                            <input @php echo $checked; @endphp class="sub-group" id="hideofooter"
                                                   data-key="hideofooter" name="hideofooter" type="checkbox">
                                            <label for="hideofooter">Hide Primary and Secondary footer
                                                content<span></span></label>

                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="default-html" style="display: none;">
                    <div class="container advanced-container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="funnel__title">How this works...</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <div class="box funnel__box">
                                    <div class="box__counter">1</div>
                                    <div class="box__content">
                                        <h3 class="box__heading"><span style="font-size: 20px;">60-Second Digital Pre-Approval</span>
                                        </h3>
                                        <p class="box__des">Share some basic info; if qualified, we&#39;ll provide you
                                            with a free, no-obligation pre-approval letter.</p>
                                    </div>
                                </div>
                                <div class="box funnel__box">
                                    <div class="box__counter">2</div>
                                    <div class="box__content">
                                        <h3 class="box__heading"><span style="font-size: 20px;">Choose the Best Options for You</span>
                                        </h3>
                                        <p class="box__des">Choose from a variety of loan options, including our
                                            conventional 20% down product.
                                            <br>
                                            <br>We also offer popular 5%-15% down home loans... AND we can even go as
                                            low as 0% down.</p>
                                    </div>
                                </div>
                                <div class="box funnel__box">
                                    <div class="box__counter">3</div>
                                    <div class="box__content">

                                        <h3 class="box__heading"><span style="font-size: 20px;">Start Shopping for Your Home!</span>
                                        </h3>

                                        <p class="box__des">It only takes about 60 seconds to get everything under way.
                                            Simply enter your zip code right now.</p>
                                    </div>
                                </div>
                                <!-- <a class="funnel__btn" href="#">Find My 203K</a> -->
                                <div style="text-align: center;margin: 20px auto;"><a class="lp-btn__go"
                                                                                      href="#GetStartedNow"
                                                                                      id="btn-submit" tabindex="-1"
                                                                                      title="">Get Started Now!</a>
                                </div>
                                <div class="funnel__caption">

                                    <p style="text-align: center; margin-left: 20px;"><em><span
                                                    style="font-size: 11px;">This hassle-free process only takes about 60 seconds,&nbsp;</span></em>
                                        <br><em><span style="font-size: 11px;">and it won&#39;t affect your credit score!</span></em>
                                    </p>

                                    <p>
                                        <br>
                                    </p>
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="animate-container">
                                    <div class="first animated desktop slideInRight"><img
                                                src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-1.png"
                                                class="fr-fic fr-dii"></div>
                                    <div class="second animated desktop fadeIn">


                                        <h2 class="animate__heading" style="font-size: 18px;"><span
                                                    style="font-size: 18px;">Share some basic info</span></h2><img
                                                src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-2.png"
                                                class="fr-fic fr-dii"></div>
                                    <div class="third animated desktop zoomIn"><strong><span
                                                    style="color: rgb(3, 177, 253); font-size: 18px;">10% Down</span></strong>
                                    </div>
                                    <div class="fourth animated desktop fadeInLeft"><img
                                                src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-4.png"
                                                class="fr-fic fr-dii"></div>
                                    <div class="fifth animated desktop slideInRight">

                                        <p>
                                            <span class="clientfname">Hi, I&#39;m @php echo $view->data->advancedfooteroptions["first_name"]; @endphp
                                                , your loan&nbsp;</span>officer.
                                            <br>It looks like you may qualify for<br>a lot more than you thought!</p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <p></p>
                            </div>
                            <br>
                        </div>
                        <p></p>
                    </div>
                </div>


                <!-- Model Boxes - Property CTA - Start -->
                <div id="modal_proerty_template" class="modal fade lp-modal-box in">
                    <div class="modal-dialog modal-dialog-template">
                        <div class="modal-content">
                            <div class="modal-header modal-action-header">
                                <h3 class="modal-title modal-action-title property-modal-text title-bold title-18">Would
                                    you like to use our default CTA Message that goes with Property Template?&nbsp;<i
                                            class="fa fa-question-circle sticky-tooltip" data-placement="top"
                                            data-html="true" data-toggle="tooltip"
                                            title='No matter which option you select below, you can always further customize the CTA messaging from the "Edit > Content > Call-to-Action" section of the Funnels Admin Panel.'
                                            aria-hidden="true"></i></h3>
                            </div>
                            <div class="modal-body model-action-body">
                                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                                    <div class="row">
                                        <div class="col-sm-12 modal-action-msg-wrap">
                                            <div class="modal-msg property-msg">
                                                <p><span class="radio">
                                                <input type="radio" class="lp-popup-radio" value="y"
                                                       id="property_cta_yes" name="property_cta">
                                                <label class="radio-control-label" for="property_cta_yes"><span></span></label>
                                            </span>Yes, use the default CTA message that goes with this template
                                                    &nbsp&nbsp&nbsp</p>
                                                <p><span class="radio">
                                                <input type="radio" class="lp-popup-radio" value="n" checked=""
                                                       id="property_cta_no" name="property_cta">
                                                <label class="radio-control-label"
                                                       for="property_cta_no"><span></span></label>
                                            </span>No, I'd like to keep what I have now &nbsp&nbsp&nbsp</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-modal-footer lp-modal-action-footer lp-modal-action-footer-template">
                                <a data-dismiss="modal" class="btn lp-btn-cancel lp-btn-cancel-template">Close</a>
                                <a id="_update_template_cta_btn" class="btn lp-btn-add lp-btn-add-template">Save &
                                    Continue</a>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Model Boxes - Property CTA - End -->

                <!-- Model Boxes - Domain Delete - Start -->
                <div id="modal_reset_default" class="modal fade lp-modal-box in">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-action-header">
                                <h3 class="modal-title modal-action-title">Reset To Default Footer Content</h3>
                            </div>
                            <div class="modal-body model-action-body">
                                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                                    <div class="row">
                                        <div class="col-sm-12 modal-action-msg-wrap">
                                            <div class="modal-msg"></div>
                                            <input type="hidden" id="_delete_domain_id"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-modal-footer lp-modal-action-footer">
                                <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                                <a id="_reset_default_btn" class="btn lp-btn-add">Yes</a>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Model Boxes - Domain Delete - End -->
            </form>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
