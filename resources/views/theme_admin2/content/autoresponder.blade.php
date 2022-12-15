@extends("layouts.leadpops")

@section('content')
    @php
    if(isset($view->data->clickedkey) && @$view->data->clickedkey != "") {
        $firstkey = @$view->data->clickedkey;
    }else {
        $firstkey = "";
    }
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
        a.lp-btn__go span
        {
            color: #ffffff;
        }
        a.lp-btn__go:hover, a[href^="#GetStartedNow"]:hover{
            background-color:transparent;
            border:2px solid rgb(255, 135, 0);
            color:#000 !important;
            transition:all 0.3s linear 0s !important
        }
        a.lp-btn__go:hover span, a[href^="#GetStartedNow"]:hover span, a.lp-btn__go:hover, a[href^="#GetStartedNow"]:hover{
            color:#000 !important;
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
        .fr-element.fr-view > div, .fr-element.fr-view > span, .fr-element.fr-view > img, .fr-element.fr-view > p {
            text-align: left;
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


    <section id="page-auto-responder">
        <div class="container">
            @php  LP_Helper::getInstance()->getFunnelHeader(@$view);@endphp
            @php
            $treecookie = \View_Helper::getInstance()->getTreeCookie(@$view->data->client_id,$firstkey);
            @endphp
            <form class="form-inline" id="add_autoresponder" method="POST" action="@php echo LP_BASE_URL.LP_PATH."/popadmin/autorespondsave"; @endphp">
                {{ csrf_field() }}
                <input type="hidden" name="client_id" id="client_id"  value="@php echo @$view->data->client_id @endphp">
                <input type="hidden" name="sline" id="sinle"  value="text">
                <input type="hidden" name="firstkey" id="firstkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="clickedkey" id="clickedkey" value="@php echo $firstkey @endphp">
                <input type="hidden" name="treecookie" id="treecookie" value="@php echo $treecookie @endphp">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ @$view->data->currenthash }}">
                <input type="hidden" name="active_responderhtml" id="active_responderhtml" value="@php echo @$view->data->autoresponder['active'] @endphp">
                <input type="hidden" name="active_respondertext" id="active_respondertext" value="@php echo @$view->data->autoresponder['active'] @endphp">
                <input type="hidden" name="auto_active" id="auto_active" value="@php
                if(@$view->data->autoresponder['html_active']=='y'){
                    echo "html";
                }else{
                    echo "text";
                }
                @endphp">

                <div class="lp-auto-responder">            <!--class=lp-common-section-->
                    <div class="lp-auto-responder-head">    <!--class=lp-common-section-head-->
                        <div class="row">
                            <div class="col-md-10">
                                <div class="col-left"><h2 class="lp-heading-2">Autoresponder message details</h2></div>
                            </div>
                            <div class="col-md-2">
                                <div class="col-right">
                                    <div class="custom-btn-toggle">
                                        @php
                                        $checked="";
                                        if(@$view->data->autoresponder['active']=='y'){
                                            $checked="checked";
                                        }
                                        @endphp
                                        <input @php echo $checked; @endphp id="autoreschk"  data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="100" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" data-lpkeys="@php echo @$view->data->lpkeys; @endphp">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-msg-box">
                                <label for="textMsg" class="control-label lp-auto-responder-label">Message Subject</label>


                                <input name="subline" class="lp-auto-responder-textbox"  id="subline" value="@php if(@$view->data->autoresponder['subject_line']!=""){ echo @$view->data->autoresponder['subject_line'];}else { echo "Thank You For Contacting&nbsp;".@$view->session->clientInfo->company_name;} @endphp" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-auto-responder">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-auto-responder-head">
                                <div class="col-left"><h2 class="lp-heading-2">Message type</h2></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lp-email-box">
                                <div class="lp-email-wrapper">



                                    <div class="radio-inline html-email">
                                        <input data-id="html-editor"  type="radio" id="r3" name="theoption" value="html" @php if(@$view->data->autoresponder['html_active']=='y'){echo "checked";} @endphp/>
                                        <label for="r3"><span></span><b>Html</b> Email</label>
                                    </div>
                                    <div class="radio-inline text-email">
                                        <input data-id="text-editor" type="radio" id="r4" name="theoption" value="text" @php if(@$view->data->autoresponder['text_active']=='y'){echo "checked";} @endphp/>
                                        <label for="r4"><span></span><b>Text</b> Email</label>
                                    </div>
                                    <div class="lp-ck-wrapper"></div>
                                    <div id="textwrapper" class="lp-p25">
                                        <textarea name="htmlautoeditor" class="lp-froala-textbox">@php echo @$view->data->autoresponder['html'];  @endphp</textarea>
                                    </div>
                                    <div id="textwrapper-area">
                                        <textarea id="lp-text-editor" name="textautoeditor" rows="16" cols="114" class="lp-email-section">@php echo @$view->data->autoresponder['thetext']; @endphp</textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-save">
                            <div class="custom-btn-success">
                                <button type="button" class="btn btn-success" onclick="saveautooptions()"><strong>SAVE</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('partials.watch_video_popup')
@endsection
