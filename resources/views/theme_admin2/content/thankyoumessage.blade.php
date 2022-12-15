@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }
    $default_logo = \View_Helper::getInstance()->getCurrentLogoImageSource(@$view->data->client_id,0,@$view->data->funnelData);
    @endphp
    <style type="text/css">
        #hide-other {
            padding: 10px 0;
        }
        #hide-other input[type="checkbox"] {
            display:none;
        }
        #hide-other input[type="checkbox"]:checked + label span {
            background:url('../../../../../../../../lp_assets/adminimages/checkbox.png') -27px top no-repeat;
        }
        #hide-other input[type="checkbox"] + label span {
            display:inline-block;
            width:26px;
            height:27px;
            margin:0 0 0 15px;
            vertical-align:middle;
            background:url('../../../../../../../../lp_assets/adminimages/checkbox.png') left top no-repeat;
            cursor:pointer;
        }
        /*#hide-other input[type="checkbox"]:hover + label span {
            background:url('../../../../../../../../lp_assets/adminimages/modal-checkbox.png') -52px top no-repeat !important;
        }*/
        #hide-other input[type="checkbox"]:checked + label span {
            background: url('../../../../../../../../lp_assets/adminimages/modal-checkbox.png') -26px top no-repeat !important;
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
            border: 2px solid @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        .animate-container .fifth.desktop::after {
            border-bottom: 16px solid @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        .animate-container .fifth.desktop {
            background-color: @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        a.lp-btn__go, a[href^="#GetStartedNow"]{
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
            transition: all 0.3s linear 0s ;
            margin-bottom: 0;
            box-shadow: 2px 6px 14px 0 rgba(0,0,0,0.2);
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            /*-webkit-user-select: none;*/
            /*-moz-user-select: none;*/
            /*-ms-user-select: none;*/
            /*user-select: none;*/
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
        a.lp-btn__go:hover, a[href^="#GetStartedNow"]:hover{
            background-color:transparent;
            border:2px solid rgb(255, 135, 0);
            color:#000 !important;
            transition:all 0.3s linear 0s !important
        }
        .fr-popup .fr-action-buttons button.fr-command {
            color: #1e88e5 !important;
        }
        .fr-wrapper p, .fr-wrapper h1, .fr-wrapper h2, .fr-wrapper h3, .fr-wrapper h5, .fr-wrapper h6, .fr-box.fr-basic .fr-element, .fr-wrapper div {
            color: #5b5b5b;
        }
        .fr-box.fr-basic .fr-element {
            padding: 40px 11px 11px 11px;

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
            margin:0 40px 0 0;
            padding-bottom: 20px;
            background: url(lp_assets/adminimages/quotes-1.png) right top no-repeat;
        }

        .lp-contact-review .block-quote p{
            font-family: "Open Sans";
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
            color: #919191;
            padding: 0;
            font-style: normal;
            text-align: left;
            margin:0;
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
            border: 3px solid @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
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
        .lp-email-box #textwrapper .fr-view{
            overflow: inherit;
        }

        /*Review Block Template 1*/
    </style>

    <div class="container">
        @php
            LP_Helper::getInstance()->getFunnelHeader($view);
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
        @endphp
        <form class="form-inline" id="" name="" method="POST" action="@php echo LP_BASE_URL.LP_PATH."/popadmin/thankmessagesave"; @endphp">
            {{ csrf_field() }}
            <input type="hidden" name="client_id" id="client_id"  value="@php echo @$view->data->client_id @endphp">
            <input type="hidden" name="theoption" id="theoption"  value="thankyou">
            <input type="hidden" name="theselectiontype" id="theselectiontype"  value="submissionthankyou">
            <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
            <input type="hidden" name="clickedkey" id="clickedfirstkey" value="@php echo $firstkey @endphp">
            <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
            <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
            <input type="hidden" name="current_hash" id="current_hash" value="@php echo @$view->data->currenthash @endphp">
            @php
                $_funnel_data=json_encode(@$view->data->funnelData,JSON_HEX_APOS);
            @endphp
            <input type="hidden" name="funneldata" id="funneldata" value='{{ $_funnel_data }}'>
            <input type="hidden" name="thankyou_logo" id="thankyou_logo" value="@php echo @$view->data->submission['thankyou_logo']; @endphp">
            <input type="hidden" id="clientfname" value="@php echo @$view->session->clientInfo->first_name; @endphp">
            <img class="hide" name="default_logo" id="default_logo" src="@php echo $default_logo; @endphp" />
            <div class="lp-auto-responder lp-thank-slug">
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-auto-responder-head lp-th-edit">
                            <div class="col-left">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h2 class="lp-heading-2">Thank You Page</h2>
                                    </div>
                                    @php
                                    $protocol = "http://";
                                    if(@$view->is_secured){
                                        $protocol = "https://";
                                    }
                                    $hash_url=$protocol.trim(str_replace(" ","",@$view->data->workingLeadpop))."/thank-you.html?hash=".@$view->data->currenthash;
                                    $preview_url=$protocol.trim(str_replace(" ","",@$view->data->workingLeadpop))."/thank-you.html?preview=1&hash=".@$view->data->currenthash;
                                    @endphp
                                    <div class="col-md-9 text-right">
                                        <div id="typ_img_toggle" class="custom-btn-toggle inc-toggle">
                                            <input @php echo (@$view->data->submission['thankyou_logo'] == 1 ? "checked" : ""); @endphp
                                                   data-toggle="toggle" class="responder-toggle typ_logo"
                                                   data-onstyle="success" data-offstyle="danger"
                                                   id="typ_logo" onchange="logo_trigger()" for="typ_logo"
                                                   data-field='typ_logo' data-width="170" data-on="LOGO DISABLED"
                                                   data-off="LOGO ENABLED" type="checkbox">
                                        </div>
                                        <div class="lp-action-button">
                                            <a href="@php echo $preview_url;@endphp" class="btn btn-preview" target="_blank">Preview</a>
                                            <a href="#" id="clone-url" class="btn btn-clone">Copy URL</a>
                                        </div>
                                    </div>
                                    <div class="thank-you-slug" id="url-text" style="display:none">@php echo $hash_url;@endphp</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="lp-slug-divider">
                <div id="msg"></div>
                <input type="hidden" class="lp-thankyou-edit-textbox" name="thankyou_slug" id="thankyou_slug" value="thank.you.html">
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-email-box">
                            <div id="textwrapper" class="">
                                <textarea class="lp-froala-textbox" name="tfootereditor">@php echo @$view->data->submission['thankyou'];  @endphp</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="lp-save">
                        <div class="custom-btn-success">
                            <button type="submit" class="btn btn-success"><strong>SAVE</strong></button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @include('partials.watch_video_popup')
@endsection
