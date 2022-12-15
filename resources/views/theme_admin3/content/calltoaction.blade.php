@extends("layouts.leadpops-inner-sidebar")

@section('content')



    <main class="main">

    @php
  //  dd($view);
        $noimage = "noimage";
        $funnel_data = LP_Helper::getInstance()->getFunnelData();
        if($funnel_data){
        $imagesrc = \View_Helper::getInstance()->getCurrentFrontImageSource($view->data->client_id,$funnel_data['funnel']);
        if($imagesrc){
        list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc);
        }
        }
        $descriptionClass = '';

        $_class = 'homepage_on';

        if($noimage=="noimage"){
            $featured_image_active="n";
            $_class = $descriptionClass = 'homepage_off';
        }
        else {
            $featured_image_active="y";
        }
        if(isset($view->data->clickedkey) && $view->data->clickedkey != "") {
            $firstkey = $view->data->clickedkey;
        }else {
            $firstkey = "";
        }
        // @todo add global columns in global_settings table
        /*
        * fontfamily
        * fontsize

       */
   // dd($view->data);
    @endphp

    <!-- content of the page -->
        <section class="main-content cta-message-page">

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" id="success-alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong>Success:</strong>
                        <span></span>
                    </div>

                </div>
            </div>

            @php
                $treecookie = \View_Helper::getInstance()->getTreeCookie($view->data->client_id,$firstkey);
            @endphp

            <form id="ctaform" name="ctaform" method="POST"
                  class="global-content-form"
                  data-global_action="{{ LP_BASE_URL.LP_PATH."/popadmin/calltoactionsave" }}"
                  data-action="{{ LP_BASE_URL.LP_PATH."/popadmin/calltoactionsave" }}"
                  action="">
                <!-- Title wrap of the page -->

                {{ csrf_field() }}
                <input name="saved" id="saved" value="{{ @$view->saved }}" type="hidden">
                <input type="hidden" name="firstkey" id="firstkey" value="{{ $firstkey }}">
                <input type="hidden" name="clickedkey" id="clickedkey" value="{{ $firstkey }}">
                <input type="hidden" name="treecookie" id="treecookie" value="{{ $treecookie }}">
                <input type="hidden" name="mlineheight" id="mlineheight" value="{{@$view->data->lineheight}}" data-form-field>
                <input type="hidden" name="dlineheight" id="dlineheight" value="{{@$view->data->dlineheight}}" data-form-field>
                <input type="hidden" name="client_id"  value="{{$view->data->client_id}}">
                <input type="hidden" name="current_hash" id="current_hash" value="{{ $view->data->currenthash }}">
                <input type="hidden" name="treecookiediv" id="treecookiediv" value="browserdivpopadmin">
                <input type="hidden" name="featured_image_active" id="featured_image_active"
                       value="{{ $featured_image_active }}">
            {{-- <div class="main-content__head">
                 <div class="col-left">
                     <h1 class="title">
                         Call-to-Action / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                     </h1>
                 </div>
                 <div class="col-right">
                     <a data-lp-wistia-title="CTA Messaging" data-lp-wistia-key="uneyp2xgwm" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                         <span class="icon ico-video"></span>
                         Watch how to video
                     </a>
                 </div>
             </div>--}}

            @php
                $tabs = [
                    ["tab"=>"Basic", "href"=>"#tbbasic", "active"=>true],
                    ["tab"=>"Advanced", "href"=>"#tbadvanced", "disabled"=>true ]
                ];
                LP_Helper::getInstance()->getFunnelHeaderAdminTheme3($view, null, $tabs);
            @endphp

            @include("partials.flashmsgs")

            <!-- content of the page -->
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Main Message
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item action__item_separator">
                                        <span class="action__span">
                                            <a href="javascript:void(0)" onclick="return resethomepagemessage('1', this);"
                                               class="action__link el-tooltip" title="This will reset your Main Message <br> to the leadPops default messaging <br> and styling for this type of Funnel.">
                                                <span class="ico ico-undo"></span>Reset
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="cta">
                            <div class="cta__message-control">
                                <ul class="action__list">
                                    <li class="action__item">
                                        <div class="font-type">
                                            <label>Font Type</label>
                                            @php
                                                $scfont="";
                                                if(isset($view->data->fontfamily))
                                                $scfont = str_replace(" ", "_", strtolower(trim($view->data->fontfamily) ));
                                            @endphp
                                            <div class="select2__parent-font-type select2js__nice-scroll">
                                            <select class="global-select form-control font-type"
                                                    name="mthefont" id="msgfonttype"
                                                    data-global_val="{{trim(@$view->data->fontfamily)}}"
                                                    data-val="{{trim(@$view->data->fontfamily)}}" data-form-field>
                                                @php
                                                    foreach ($view->data->fontfamilies as $font){
                                                        $cfont = str_replace(" ", "_", strtolower(trim($font)));
                                                @endphp
                                                <option class="{{trim($font)}}"
                                                        value='{{ trim($font) }}' {{ (isset($view->data->fontfamily) && trim($view->data->fontfamily)==trim($font)?'selected="selected"':'') }} >
                                                    {{ $font }}
                                                </option>
                                                @php
                                                    }
                                                @endphp
                                            </select>
                                            </div>

                                        </div>
                                    </li>
                                    <li class="action__item">
                                        <div class="font-size">
                                            <label>Font Size</label>
                                            <div class="select2__parent-font-size select2js__nice-scroll global-select">
                                                <select name="mthefontsize" id="msgfontsize"
                                                        data-global_val=""
                                                        data-val="{{@$view->data->fontsize}}"
                                                        class="form-control" data-form-field>
                                                    <option value="10px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='10px'?'selected="selected"':"") }} >
                                                        10 px
                                                    </option>
                                                    <option value="11px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='11px'?'selected="selected"':"") }}>
                                                        11 px
                                                    </option>
                                                    <option value="12px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='12px'?'selected="selected"':"") }}>
                                                        12 px
                                                    </option>
                                                    <option value="13px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='13px'?'selected="selected"':"") }}>
                                                        13 px
                                                    </option>
                                                    <option value="14px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='14px'?'selected="selected"':"") }}>
                                                        14 px
                                                    </option>
                                                    <option value="15px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='15px'?'selected="selected"':"") }}>
                                                        15 px
                                                    </option>
                                                    <option value="16px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='16px'?'selected="selected"':"") }}>
                                                        16 px
                                                    </option>
                                                    <option value="17px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='17px'?'selected="selected"':"") }}>
                                                        17 px
                                                    </option>
                                                    <option value="18px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='18px'?'selected="selected"':"") }}>
                                                        18 px
                                                    </option>
                                                    <option value="19px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='19px'?'selected="selected"':"") }}>
                                                        19 px
                                                    </option>
                                                    <option value="20px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='20px'?'selected="selected"':"") }}>
                                                        20 px
                                                    </option>
                                                    <option value="21px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='21px'?'selected="selected"':"") }}>
                                                        21 px
                                                    </option>
                                                    <option value="22px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='22px'?'selected="selected"':"") }}>
                                                        22 px
                                                    </option>
                                                    <option value="23px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='23px'?'selected="selected"':"") }}>
                                                        23 px
                                                    </option>
                                                    <option value="24px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='24px'?'selected="selected"':"") }}>
                                                        24 px
                                                    </option>
                                                    <option value="25px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='25px'?'selected="selected"':"") }}>
                                                        25 px
                                                    </option>
                                                    <option value="26px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='26px'?'selected="selected"':"") }}>
                                                        26 px
                                                    </option>
                                                    <option value="27px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='27px'?'selected="selected"':"") }}>
                                                        27 px
                                                    </option>
                                                    <option value="28px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='28px'?'selected="selected"':"") }}>
                                                        28 px
                                                    </option>
                                                    <option value="29px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='29px'?'selected="selected"':"") }}>
                                                        29 px
                                                    </option>
                                                    <option value="30px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='30px'?'selected="selected"':"") }}>
                                                        30 px
                                                    </option>
                                                    <option value="31px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='31px'?'selected="selected"':"") }}>
                                                        31 px
                                                    </option>
                                                    <option value="32px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='32px'?'selected="selected"':"") }}>
                                                        32 px
                                                    </option>
                                                    <option value="33px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='33px'?'selected="selected"':"") }}>
                                                        33 px
                                                    </option>
                                                    <option value="34px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='34px'?'selected="selected"':"") }}>
                                                        34 px
                                                    </option>
                                                    <option value="35px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='35px'?'selected="selected"':"") }}>
                                                        35 px
                                                    </option>
                                                    <option value="36px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='36px'?'selected="selected"':"") }}>
                                                        36 px
                                                    </option>
                                                    <option value="37px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='37px'?'selected="selected"':"") }}>
                                                        37 px
                                                    </option>
                                                    <option value="38px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='38px'?'selected="selected"':"") }}>
                                                        38 px
                                                    </option>
                                                    <option value="39px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='39px'?'selected="selected"':"") }}>
                                                        39 px
                                                    </option>

                                                    <option value="40px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='40px'?'selected="selected"':"") }}>
                                                        40 px
                                                    </option>
                                                    <option value="41px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='41px'?'selected="selected"':"") }}>
                                                        41 px
                                                    </option>
                                                    <option value="42px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='42px'?'selected="selected"':"") }}>
                                                        42 px
                                                    </option>
                                                    <option value="43px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='43px'?'selected="selected"':"") }}>
                                                        43 px
                                                    </option>
                                                    <option value="44px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='44px'?'selected="selected"':"") }}>
                                                        44 px
                                                    </option>
                                                    <option value="45px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='45px'?'selected="selected"':"") }}>
                                                        45 px
                                                    </option>
                                                    <option value="46px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='46px'?'selected="selected"':"") }}>
                                                        46 px
                                                    </option>
                                                    <option value="47px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='47px'?'selected="selected"':"") }}>
                                                        47 px
                                                    </option>
                                                    <option value="48px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='48px'?'selected="selected"':"") }}>
                                                        48 px
                                                    </option>
                                                    <option value="49px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='49px'?'selected="selected"':"") }}>
                                                        49 px
                                                    </option>
                                                    <option value="50" {{ (isset($view->data->fontsize) && $view->data->fontsize=='50px'?'selected="selected"':"") }}>
                                                        50 px
                                                    </option>
                                                    <option value="51px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='51px'?'selected="selected"':"") }}>
                                                        51 px
                                                    </option>
                                                    <option value="52px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='52px'?'selected="selected"':"") }}>
                                                        52 px
                                                    </option>
                                                    <option value="53px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='53px'?'selected="selected"':"") }}>
                                                        53 px
                                                    </option>
                                                    <option value="54px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='54px'?'selected="selected"':"") }}>
                                                        54 px
                                                    </option>
                                                    <option value="55px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='55px'?'selected="selected"':"") }}>
                                                        55 px
                                                    </option>
                                                    <option value="56px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='56px'?'selected="selected"':"") }}>
                                                        56 px
                                                    </option>
                                                    <option value="57px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='57px'?'selected="selected"':"") }}>
                                                        57 px
                                                    </option>
                                                    <option value="58px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='58px'?'selected="selected"':"") }}>
                                                        58 px
                                                    </option>
                                                    <option value="59px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='59px'?'selected="selected"':"") }}>
                                                        59 px
                                                    </option>
                                                    <option value="60px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='60px'?'selected="selected"':"") }}>
                                                        60 px
                                                    </option>
                                                    <option value="61px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='61px'?'selected="selected"':"") }}>
                                                        61 px
                                                    </option>
                                                    <option value="62px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='62px'?'selected="selected"':"") }}>
                                                        62 px
                                                    </option>
                                                    <option value="63px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='63px'?'selected="selected"':"") }}>
                                                        63 px
                                                    </option>
                                                    <option value="64px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='64px'?'selected="selected"':"") }}>
                                                        64 px
                                                    </option>
                                                    <option value="65px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='65px'?'selected="selected"':"") }}>
                                                        65 px
                                                    </option>
                                                    <option value="66px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='66px'?'selected="selected"':"") }}>
                                                        66 px
                                                    </option>
                                                    <option value="67px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='67px'?'selected="selected"':"") }}>
                                                        67 px
                                                    </option>
                                                    <option value="68px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='68px'?'selected="selected"':"") }}>
                                                        68 px
                                                    </option>
                                                    <option value="69px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='69px'?'selected="selected"':"") }}>
                                                        69 px
                                                    </option>
                                                    <option value="70px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='70px'?'selected="selected"':"") }}>
                                                        70 px
                                                    </option>
                                                    <option value="70px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='70px'?'selected="selected"':"") }}>
                                                        71 px
                                                    </option>
                                                    <option value="72px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='72px'?'selected="selected"':"") }}>
                                                        72 px
                                                    </option>
                                                    <option value="73px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='73px'?'selected="selected"':"") }}>
                                                        73 px
                                                    </option>
                                                    <option value="74px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='74px'?'selected="selected"':"") }}>
                                                        74 px
                                                    </option>
                                                    <option value="75px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='75px'?'selected="selected"':"") }}>
                                                        75 px
                                                    </option>
                                                    <option value="76px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='76px'?'selected="selected"':"") }}>
                                                        76 px
                                                    </option>
                                                    <option value="77px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='77px'?'selected="selected"':"") }}>
                                                        77 px
                                                    </option>
                                                    <option value="78px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='78px'?'selected="selected"':"") }}>
                                                        78 px
                                                    </option>
                                                    <option value="79px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='79px'?'selected="selected"':"") }}>
                                                        79 px
                                                    </option>
                                                    <option value="80px" {{ (isset($view->data->fontsize) && $view->data->fontsize=='80px'?'selected="selected"':"") }}>
                                                        80 px
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="action__item mr-3">
                                        <div class="font-linehight">
                                            <label>Line Spacing</label>
                                            <div class="select2-linehight-mian-msg-parent">
                                                <select class="select2-linehight-main-msg global-select" data-global_val="" data-val="{{@$view->data->lineheight}}"></select>
                                            </div>
                                        </div>
                                    </li>


                                    <li class="action__item">
                                        <div class="text-color">
                                            <label>Text Color</label>
                                            <div class="text-color-parent">
                                                <div class="color-picker colorSelector-mmessagecp cta-color-selector"
                                                     style="background-color: #0ccdba;"></div>
                                                <input type="hidden" name="mmessagecpval" id="mmessagecpval" class="global-input-text"
                                                       data-global_val="{{@$view->data->color}}"
                                                       data-val="{{@$view->data->color}}"
                                                       value="@php if(isset($view->data->color) && ($view->data->color)) echo $view->data->color @endphp" data-form-field>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="cta__message">
                                <textarea type="text"
                                          class=" form-control text-area cta-text cta-text-format {{ $_class }}"
                                          name="mmainheadingval" id="mian__message"
                                          data-global_val=""
                                          data-val="@php if(isset($view->data->homePageMessageMainMessage)){ echo trim(textCleaner($view->data->homePageMessageMainMessage));} @endphp"
                                          style="{{ @$view->data->messageStyle }}" data-form-field>@php if(isset($view->data->homePageMessageMainMessage)){ echo trim(textCleaner($view->data->homePageMessageMainMessage));} @endphp</textarea>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Description
                            </h2>
                        </div>
                        <div class="col-right">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item action__item_separator">
                                        <span class="action__span">
                                            <a href="javascript:void(0)" onclick="return resethomepagemessage('2', this);"
                                               class="action__link el-tooltip" title="This will reset your Description text <br> to the leadPops default messaging<br> and styling for this type of Funnel.">
                                                <span class="ico ico-undo"></span>Reset
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="cta">
                            <div class="cta__message-control">
                                <ul class="action__list">
                                    <li class="action__item">
                                        <div class="font-type">
                                            <label>Font Type</label>
                                            <div class="select2__parent-dfont-type select2js__nice-scroll">
                                            <select class=" form-control font-type global-select"
                                                    name="dthefont" id="dfonttype"
                                                    data-global_val="{{@$view->data->dfontfamily}}"
                                                    data-val="{{@$view->data->dfontfamily}}" data-form-field>
                                                @php
                                                    foreach ($view->data->fontfamilies as $font){
                                                        $cfont = str_replace(" ", "_", strtolower($font));
                                                @endphp
                                                <option class="{{ $cfont }}"
                                                        value='{{ $font }}'>{{ $font }}</option>
                                                @php
                                                    }
                                                @endphp
                                            </select>
                                            </div>
                                            {{--</div>--}}
                                        </div>
                                    </li>
                                    <li class="action__item">
                                        <div class="font-size">
                                            <label>Font Size</label>
                                            <div class="select2__parent-dfont-size select2js__nice-scroll global-select">
                                                <select name="dthefontsize" id="dfontsize"
                                                        data-global_val=""
                                                        data-val="{{@$view->data->dfontsize}}" data-form-field>
                                                    <option value="10px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='10px'?'selected="selected"':"") }}>
                                                        10 px
                                                    </option>
                                                    <option value="11px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='11px'?'selected="selected"':"") }}>
                                                        11 px
                                                    </option>
                                                    <option value="12px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='12px'?'selected="selected"':"") }}>
                                                        12 px
                                                    </option>
                                                    <option value="13px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='13px'?'selected="selected"':"") }}>
                                                        13 px
                                                    </option>
                                                    <option value="14px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='14px'?'selected="selected"':"") }}>
                                                        14 px
                                                    </option>
                                                    <option value="15px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='15px'?'selected="selected"':"") }}>
                                                        15 px
                                                    </option>
                                                    <option value="16px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='16px'?'selected="selected"':"") }}>
                                                        16 px
                                                    </option>
                                                    <option value="17px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='17px'?'selected="selected"':"") }}>
                                                        17 px
                                                    </option>
                                                    <option value="18px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='18px'?'selected="selected"':"") }}>
                                                        18 px
                                                    </option>
                                                    <option value="19px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='19px'?'selected="selected"':"") }}>
                                                        19 px
                                                    </option>
                                                    <option value="20px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='20px'?'selected="selected"':"") }}>
                                                        20 px
                                                    </option>
                                                    <option value="21px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='21px'?'selected="selected"':"") }}>
                                                        21 px
                                                    </option>
                                                    <option value="22px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='22px'?'selected="selected"':"") }}>
                                                        22 px
                                                    </option>
                                                    <option value="23px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='23px'?'selected="selected"':"") }}>
                                                        23 px
                                                    </option>
                                                    <option value="24px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='24px'?'selected="selected"':"") }}>
                                                        24 px
                                                    </option>
                                                    <option value="25px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='25px'?'selected="selected"':"") }}>
                                                        25 px
                                                    </option>
                                                    <option value="26px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='26px'?'selected="selected"':"") }}>
                                                        26 px
                                                    </option>
                                                    <option value="27px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='27px'?'selected="selected"':"") }}>
                                                        27 px
                                                    </option>
                                                    <option value="28px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='28px'?'selected="selected"':"") }}>
                                                        28 px
                                                    </option>
                                                    <option value="29px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='29px'?'selected="selected"':"") }}>
                                                        29 px
                                                    </option>
                                                    <option value="30px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='30px'?'selected="selected"':"") }}>
                                                        30 px
                                                    </option>
                                                    <option value="31px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='31px'?'selected="selected"':"") }}>
                                                        31 px
                                                    </option>
                                                    <option value="32px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='32px'?'selected="selected"':"") }}>
                                                        32 px
                                                    </option>
                                                    <option value="33px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='33px'?'selected="selected"':"") }}>
                                                        33 px
                                                    </option>
                                                    <option value="34px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='34px'?'selected="selected"':"") }}>
                                                        34 px
                                                    </option>
                                                    <option value="35px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='35px'?'selected="selected"':"") }}>
                                                        35 px
                                                    </option>
                                                    <option value="36px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='36px'?'selected="selected"':"") }}>
                                                        36 px
                                                    </option>
                                                    <option value="37px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='37px'?'selected="selected"':"") }}>
                                                        37 px
                                                    </option>
                                                    <option value="38px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='38px'?'selected="selected"':"") }}>
                                                        38 px
                                                    </option>
                                                    <option value="39px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='39px'?'selected="selected"':"") }}>
                                                        39 px
                                                    </option>
                                                    <option value="40px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='40px'?'selected="selected"':"") }}>
                                                        40 px
                                                    </option>
                                                    <option value="41px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='41px'?'selected="selected"':"") }}>
                                                        41 px
                                                    </option>
                                                    <option value="42px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='42px'?'selected="selected"':"") }}>
                                                        42 px
                                                    </option>
                                                    <option value="43px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='43px'?'selected="selected"':"") }}>
                                                        43 px
                                                    </option>
                                                    <option value="44px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='44px'?'selected="selected"':"") }}>
                                                        44 px
                                                    </option>
                                                    <option value="45px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='45px'?'selected="selected"':"") }}>
                                                        45 px
                                                    </option>
                                                    <option value="46px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='46px'?'selected="selected"':"") }}>
                                                        46 px
                                                    </option>
                                                    <option value="47px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='47px'?'selected="selected"':"") }}>
                                                        47 px
                                                    </option>
                                                    <option value="48px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='48px'?'selected="selected"':"") }}>
                                                        48 px
                                                    </option>
                                                    <option value="49px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='49px'?'selected="selected"':"") }}>
                                                        49 px
                                                    </option>
                                                    <option value="50" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='50px'?'selected="selected"':"") }}>
                                                        50 px
                                                    </option>
                                                    <option value="51px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='51px'?'selected="selected"':"") }}>
                                                        51 px
                                                    </option>
                                                    <option value="52px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='52px'?'selected="selected"':"") }}>
                                                        52 px
                                                    </option>
                                                    <option value="53px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='53px'?'selected="selected"':"") }}>
                                                        53 px
                                                    </option>
                                                    <option value="54px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='54px'?'selected="selected"':"") }}>
                                                        54 px
                                                    </option>
                                                    <option value="55px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='55px'?'selected="selected"':"") }}>
                                                        55 px
                                                    </option>
                                                    <option value="56px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='56px'?'selected="selected"':"") }}>
                                                        56 px
                                                    </option>
                                                    <option value="57px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='57px'?'selected="selected"':"") }}>
                                                        57 px
                                                    </option>
                                                    <option value="58px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='58px'?'selected="selected"':"") }}>
                                                        58 px
                                                    </option>
                                                    <option value="59px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='59px'?'selected="selected"':"") }}>
                                                        59 px
                                                    </option>
                                                    <option value="60px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='60px'?'selected="selected"':"") }}>
                                                        60 px
                                                    </option>
                                                    <option value="61px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='61px'?'selected="selected"':"") }}>
                                                        61 px
                                                    </option>
                                                    <option value="62px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='62px'?'selected="selected"':"") }}>
                                                        62 px
                                                    </option>
                                                    <option value="63px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='63px'?'selected="selected"':"") }}>
                                                        63 px
                                                    </option>
                                                    <option value="64px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='64px'?'selected="selected"':"") }}>
                                                        64 px
                                                    </option>
                                                    <option value="65px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='65px'?'selected="selected"':"") }}>
                                                        65 px
                                                    </option>
                                                    <option value="66px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='66px'?'selected="selected"':"") }}>
                                                        66 px
                                                    </option>
                                                    <option value="67px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='67px'?'selected="selected"':"") }}>
                                                        67 px
                                                    </option>
                                                    <option value="68px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='68px'?'selected="selected"':"") }}>
                                                        68 px
                                                    </option>
                                                    <option value="69px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='69px'?'selected="selected"':"") }}>
                                                        69 px
                                                    </option>
                                                    <option value="70px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='70px'?'selected="selected"':"") }}>
                                                        70 px
                                                    </option>
                                                    <option value="70px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='70px'?'selected="selected"':"") }}>
                                                        71 px
                                                    </option>
                                                    <option value="72px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='72px'?'selected="selected"':"") }}>
                                                        72 px
                                                    </option>
                                                    <option value="73px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='73px'?'selected="selected"':"") }}>
                                                        73 px
                                                    </option>
                                                    <option value="74px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='74px'?'selected="selected"':"") }}>
                                                        74 px
                                                    </option>
                                                    <option value="75px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='75px'?'selected="selected"':"") }}>
                                                        75 px
                                                    </option>
                                                    <option value="76px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='76px'?'selected="selected"':"") }}>
                                                        76 px
                                                    </option>
                                                    <option value="77px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='77px'?'selected="selected"':"") }}>
                                                        77 px
                                                    </option>
                                                    <option value="78px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='78px'?'selected="selected"':"") }}>
                                                        78 px
                                                    </option>
                                                    <option value="79px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='79px'?'selected="selected"':"") }}>
                                                        79 px
                                                    </option>
                                                    <option value="80px" {{ (isset($view->data->dfontsize) && $view->data->dfontsize=='80px'?'selected="selected"':"") }}>
                                                        80 px
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="action__item mr-3">
                                        <div class="font-linehight">
                                            <label>Line Spacing</label>
                                            <div class="text-color-parent">
                                                <div class="select2-linehight-dsc-msg-parent">
                                                    <select class="select2-linehight-dsc-msg golobal-select" data-global_val="" data-val="{{@$view->data->dlineheight}}"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </li>


                                    {{--<li class="action__item">
                                        <div class="text-color">
                                            <label for="textcolor">Text Color</label>
                                            <div class="text-color-parent">
                                                --}}{{--<div  class="color-picker colorSelector-mdescp cta-color-selector" data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval" style="background-color:#3f3f3f"></div>--}}{{--
                                                <div id="colorSelector" class="color-picker colorSelector-mdescp cta-color-selector" data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval" style="{{ ($view->data->dcolor!="") ? "background-color:".$view->data->dcolor: "\"background-color:\"#FFFFFF" }}"></div>
                                                <input type="hidden" name="dmessagecpval" id="dmessagecpval" value="@php if(isset($view->data->dcolor) && ($view->data->dcolor)) echo $view->data->dcolor; @endphp">

                                            </div>
                                        </div>
                                    </li>--}}

                                    <li class="action__item">
                                        <div class="text-color">
                                            <label for="textcolor">Text Color</label>
                                            <div class="text-color-parent">
                                                <div class="color-picker colorSelector-mdescp cta-color-selector"
                                                     data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval"
                                                     style="background-color:#3f3f3f"></div>
                                                <input type="hidden" name="dmessagecpval" id="dmessagecpval"
                                                       data-global_val="@php if(isset($view->data->dcolor) && ($view->data->dcolor)) echo $view->data->dcolor; @endphp"
                                                       data-val="@php if(isset($view->data->dcolor) && ($view->data->dcolor)) echo $view->data->dcolor; @endphp"
                                                       value="@php if(isset($view->data->dcolor) && ($view->data->dcolor)) echo $view->data->dcolor; @endphp" data-form-field>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="cta__message">
                                <textarea class="form-control text-area cta-textarea cta-text-format {{$descriptionClass}}"
                                          id="desc__message" name="dmainheadingval"
                                          style="{{ @$view->data->dmessageStyle }}" data-form-field>@php if(isset($view->data->homePageMessageDescription)){  echo trim($view->data->homePageMessageDescription); } @endphp</textarea>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                   {{-- <div class="row">
                        <button type="submit" class="button button-secondary">Save</button>
                    </div>--}}
                    <div class="row">
                        <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </form>
        </section>
    </main>






    <!-- Main Message color picker -->
    <div class="color-box__panel-wrapper main-message-clr cta">
        <div class="picker-block" id="main-message-colorpicker">
        </div>
        <label class="color-box__label">Add custom color code</label>
        <div class="color-box__panel-rgb-wrapper">
            <div class="color-box__r">
                R: <input class="color-box__rgb" value="12"/>
            </div>
            <div class="color-box__g">
                G: <input class="color-box__rgb" value="205"/>
            </div>
            <div class="color-box__b">
                B: <input class="color-box__rgb" value="186"/>
            </div>
        </div>
        <div class="color-box__panel-hex-wrapper">
            <label class="color-box__hex-label">Hex code:</label>
            <input class="color-box__hex-block" value="#707d84" maxlength="7"/>
        </div>
        <div class="color-box__panel-pre-wrapper" style="display: none">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
    <!-- Description color picker -->
    <div class="color-box__panel-wrapper desc-message-clr cta">
        <div class="picker-block" id="desc-message-colorpicker">
        </div>
        <label class="color-box__label">Add custom color code</label>
        <div class="color-box__panel-rgb-wrapper">
            <div class="color-box__r">
                R: <input class="color-box__rgb" value="63"/>
            </div>
            <div class="color-box__g">
                G: <input class="color-box__rgb" value="63"/>
            </div>
            <div class="color-box__b">
                B: <input class="color-box__rgb" value="63"/>
            </div>
        </div>
        <div class="color-box__panel-hex-wrapper">
            <label class="color-box__hex-label">Hex code:</label>
            <input class="color-box__hex-block" value="#3f3f3f" maxlength="7"/>
        </div>
        <div class="color-box__panel-pre-wrapper" style="display: none">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
@endsection
