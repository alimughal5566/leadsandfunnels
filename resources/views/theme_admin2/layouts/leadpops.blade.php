@php
    use App\Services\DataRegistry;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="noscroll">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        #mask { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: #f6f6f6; z-index: 10000; height: 100%; }
        #mask .preloader { display: inline-block; position: absolute; top: 50%; left: 50%; width: 36px; height: 36px; -webkit-animation: container-rotate 1568ms linear infinite; animation: container-rotate 1568ms linear infinite; }
        #mask #custom_loader { display: inline-block; position: absolute; top: 50%; left: 50%;}
        #mask .preloader .spin { position: absolute; width: 100%; height: 100%; opacity: 1; -webkit-animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both; animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both; border-color:#2A81E4; }
        #mask .preloader .circle { border-radius: 50%; }
        #mask .preloader .gap { position: absolute; top: 0; left: 45%; width: 10%; height: 100%; overflow: hidden; border-color: inherit; }
        #mask .preloader .gap .circle { width: 1000%; left: -450%; }
        #mask .preloader .clip { display: inline-block; position: relative; width: 50%; height: 100%; overflow: hidden; border-color: inherit; }
        #mask .preloader .clip .circle { width: 200%; height: 100%; border-width: 3px; border-style: solid; border-color: inherit; border-bottom-color: transparent !important; border-radius: 50%; -webkit-animation: none; animation: none; position: absolute; top: 0; right: 0; bottom: 0; }
        #mask .preloader .clip { display: inline-block; position: relative; width: 50%; height: 100%; overflow: hidden; border-color: inherit; }
        #mask .preloader .clip.left .circle { -webkit-animation: left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both; animation: left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both; }
        #mask .preloader .clip.right .circle { -webkit-animation: right-spin 1333/**/ms cubic-bezier(0.4, 0, 0.2, 1) infinite both; animation: right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both; }
        #mask .preloader .clip.left .circle { left: 0; border-right-color: transparent !important; -webkit-transform: rotate(129deg); transform: rotate(129deg); }
        #mask .preloader .clip.right .circle { left: -100%; border-left-color: transparent !important; -webkit-transform: rotate(-129deg); transform: rotate(-129deg); }
    </style>

    <link rel="apple-touch-icon" sizes="120x120" href="{{ LP_ASSETS_PATH }}/adminimages/apple-touch-icon.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-32x32.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-16x16.png?v={{ LP_VERSION }}">
    <link rel="manifest" href="/lp_assets/adminimages/favicon/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <link href="https://fonts.googleapis.com/css?family=Orbitron:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <meta name="theme-color" content="#ffffff">
    @php
    $sf = false;
    if(array_key_exists('survey_flag' , DataRegistry::getInstance()->leadpops->clientInfo)){
        $sf = DataRegistry::getInstance()->leadpops->clientInfo['survey_flag'];
    }
    @endphp
    @hasSection('page_title')
        <title>@yield('page_title')</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    @php
        $default_css = array();
        array_push($default_css, config('view.theme_assets').'/external/bootstrap/css/bootstrap.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/font-awesome-4.7.0/css/font-awesome.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/custom-scroll/jquery.mCustomScrollbar.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/bootstrap-toggle/css/bootstrap-toggle.min.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/colorpicker/css/colorpicker.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/colorpicker/css/layout.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/bootstrap-slider/css/bootstrap-slider.min.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/jquery.ics-gradient-editor.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/select2/css/select2.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/select/css/bootstrap-select.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/css/style.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/date-picker/daterangepicker.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/css/stats.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/css/style-steele.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/css/leadpops_helper.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/bootstrap/css/bootstrap-nonresponsive.css?v='.LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/owlcarousel/assets/owl.carousel.min.css?v=' . LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/external/owlcarousel/assets/owl.theme.default.min.css?v=' . LP_VERSION);
        array_push($default_css, "https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/css/froala_editor.min.css?v=" . LP_VERSION);
        array_push($default_css, "https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/css/froala_style.min.css?v=" . LP_VERSION);
        array_push($default_css, "https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/css/froala_editor.pkgd.min.css?v=" . LP_VERSION);
        array_push($default_css, config('view.theme_assets')."/external/froala-editor/css/froala_extend.css?v=" . LP_VERSION);
        array_push($default_css, config('view.theme_assets')."/external/froala-editor/css/froala_style.min.css?v=" . LP_VERSION);
        array_push($default_css, config('view.theme_assets')."/external/froala-editor/css/froala_custom.css?v=" . LP_VERSION);
        array_push($default_css, config('view.theme_assets').'/css/msg-note.css?v=' . LP_VERSION);
        array_push($default_css, "https://fonts.googleapis.com/css?family=Courgette");

        if($sf && @DataRegistry::getInstance()->leadpops->skip_survey == 0){
            array_push($default_css, LP_ASSETS_PATH.'/survey/css/survey.css?v='.LP_VERSION);
        }

        if ((@$view->session->clientInfo->sticky_bar_v2 == 1)){
            array_push($default_css, config('view.theme_assets').'/external/dropzone/dropzone.css?v='.LP_VERSION);
            array_push($default_css, config('view.theme_assets').'/external/nano-scroll/nanoscroller.css?v='.LP_VERSION);
            array_push($default_css, config('view.theme_assets').'/css/sticky-bar_v2.css?v='.LP_VERSION);
            array_push($default_css, config('view.theme_assets').'/css/stats_v2.css?v='.LP_VERSION);
        } else {
            array_push($default_css, config('view.theme_assets').'/css/sticky-bar.css?v='.LP_VERSION);
        }
    @endphp

    @foreach ($default_css as $css)
        <link href="{{ $css }}" rel="stylesheet" type="text/css">
    @endforeach

    @if ($view->assets_css)
        @foreach ($view->assets_css as $css)
            <link href="{{ $css."?v=".LP_VERSION  }}" rel="stylesheet" type="text/css">
        @endforeach
    @endif

    @if ($view->inline_css)
    <!-- Inline CSS -->
        <style type="text/css" media="screen" rel="stylesheet">
            {!! $view->inline_css !!}
        </style>
    @endif

    @php
        $idx = 0;
    @endphp
    <script>
        var ajax_token = '{{ csrf_token() }}';
        /*
        * Note: this variable is contain data of col sticky_data for table client_funnel_sticky
        * */
        var funnel_data = {!! json_encode(LP_Helper::getInstance()->getStickyBarData() , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS) !!};
    </script>
</head>
<body class="{{ implode(' ', $view->body_class) }}">
<style type="text/css">
    body {
        transition: all 0.6s;
        position: relative;
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
    body.super_banner_body {
        padding-top: 55px !important;
    }

    body.super-header-padding-t70 {
        padding-top: 70px !important;
    }

    body.super-header-padding {
        padding-top: 0 !important;
    }

    .super_banner {
        font-size: 0;
        position: fixed;
        z-index: 999;
        top: 0;
        left: 0;
        width: 100%;
        height: auto;
        margin: 0;
        padding: 5px 10px;
        text-align: center;
        background-color: #fee140;
        background-image: -webkit-gradient(linear, left top, right top, from(#fee140), to(#fa709a));
        background-image: -o-linear-gradient(left, #fee140 0%, #fa709a 100%);
        background-image: linear-gradient(90deg, #fee140 0%, #fa709a 100%);
    }

    .super_banner__link {
        display: table;
        width: 100%;
        height: 45px;
        margin: 0;
        text-align: center;
        text-decoration: none;
        color: #ffffff;
        padding: 6px 0;
        position: relative;
    }

    .super_banner__headline {
        font-size: 1.8rem;
        font-weight: 700;
        /*line-height: 45px;*/
        display: inline-block;
        margin-right: 15px;
        vertical-align: middle;
        opacity: 0;
    }

    .super_banner__headline_medium {
        font-size: 2.4rem;
    }

    .super_banner__headline:hover {
        color: #ffffff;
    }

    .super_banner .btn:last-child {
        margin-right: 0;
    }

    .super_banner .btn {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        font-family: "proxima-nova", sans-serif;
        font-weight: 600;
        line-height: 1.4;
        display: inline-block;
        margin: 0 10px 0 0;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-transition: all 0.2s;
        -o-transition: all 0.2s;
        transition: all 0.2s;
        text-align: center;
        white-space: normal;
        text-decoration: none;
        color: #ffffff;
        border: 0;
        border-radius: 5px;
        outline: none;
    }

    .super_banner .btn:hover {
        color: #ffffff;
    }

    .super_banner__btn {
        font-weight: 700;
        -webkit-transform: scale(0);
        -ms-transform: scale(0);
        transform: scale(0);
        vertical-align: middle;
        background-color: rgba(0, 0, 0, 0.25);
    }

    .btn--extra-small {
        font-size: 1.4rem;
        padding: 6px 15px;
    }

    .super_banner .btn--extra-small__medium {
        font-size: 2rem;
        line-height: 1.8;
    }

    .super_banner__btn-icon {
        position: relative;
        top: 0;
        display: inline-block;
        padding: 0 10px;
        height: 16px;
        fill: #ffffff;
        font-style: normal;
    }

    .show-banner-nob {
        height: 30px;
        width: 25px;
        background-color: #fee140;
        background-image: -webkit-gradient(linear, left top, right top, from(#fee140), to(#fa709a));
        background-image: -o-linear-gradient(left, #fee140 0%, #fa709a 100%);
        background-image: linear-gradient(90deg, #fee140 0%, #fa709a 100%);
        position: absolute;
        top: 0;
        right: 30px;
        color: #fff;
        border-radius: 0 0 4px 4px;
        cursor: pointer;
        display: none;
        text-align: center;
        font-size: 16px;
        padding-top: 5px;
        z-index: 9999;
    }

    .super_banner__close {
        font-size: 20px;
        position: absolute;
        right: 0;
        top: -4px;
    }

    .super_banner__close_medium {
        /*top: 15px;*/
    }

    /*.super_banner__btn-icon svg {
    height: 16px;
    fill: #ffffff;
    }*/

    .super_banner__btn-icon {
        -webkit-animation: slide-right 0.4s cubic-bezier(0.550, 0.085, 0.680, 0.530) infinite alternate forwards;
        animation: slide-right 0.4s cubic-bezier(0.550, 0.085, 0.680, 0.530) infinite alternate forwards;
    }

    @-webkit-keyframes slide-right {
        0% {
            -webkit-transform: translateX(0);
            transform: translateX(0);
        }
        100% {
            -webkit-transform: translateX(10px);
            transform: translateX(10px);
        }
    }

    @keyframes slide-right {
        0% {
            -webkit-transform: translateX(0);
            transform: translateX(0);
        }
        100% {
            -webkit-transform: translateX(10px);
            transform: translateX(10px);
        }
    }

    @media only screen and (max-width: 979px) {
        .super_banner .super_banner__btn {
            margin-top: 6px;
        }

        .super_banner__close_medium {
            /*top: 10px;*/
        }

        .super_banner__headline {
            margin-right: 30px;
            margin-left: 30px;
        }

        .super_banner__close {
            /*right: 10px;*/
        }

        body {
            position: unset;
        }
    }

    @media only screen and (max-width: 767px) {
        .super_banner__close {
            right: 5px;
            top: -4px;
        }

        .super_banner__headline_medium {
            font-size: 1.8rem;
        }
    }

    @media only screen and (max-width: 480px) {
        .super_banner__headline_medium {
            font-size: 1.6rem;
        }

        .super_banner .btn--extra-small__medium {
            font-size: 1.4rem;
            margin-top: 8px;
        }

        .show-banner-nob {
            right: 15px;
        }
    }

    @if(LP_Helper::getInstance()->isDisabledStickyBannerForClient($view->session->clientInfo->client_id))
        body.super_banner_body {
            padding-top: 0px !important;
        }
    @endif
</style>

@if(!LP_Helper::getInstance()->isDisabledStickyBannerForClient($view->session->clientInfo->client_id))
    <section class="super_banner">
        <span class="super_banner__link">
          <div class="super_banner__contents">
            <div class="super_banner__headline" style="opacity: 1; transform: translateX(0px) translateY(0px);">Schedule your FREE 1:1 Digital Marketing Assessment!</div>
            <a href="https://mortgage.leadpops.com/request-demo/" target="_blank"
               class="btn btn--extra-small super_banner__btn" style="color: rgb(255, 255, 255); transform: scale(1);">
              Book Now
              <i class="super_banner__btn-icon">
                >>
              </i>
            </a>
          </div>
          <a href="#" class="super_banner__close"><i class="fa fa-close"></i></a>
        </span>
    </section>
@endif

<div class="show-banner-nob"><i class="fa fa-arrow-down"></i></div>
<div id="mask">
    <div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
</div>
<div id="lp-mobile-check" class="">
    Though Funnels look and work great on mobile devices,<br> the Funnels Admin experience has been optimized for desktop
</div>
@if ($view->header_main)
    @include("partials.header-main")
@endif
@if ($view->header_partial)
    @include("partials.".$view->header_partial)
@endif
@include("partials.flash-message")
@yield('content')
@php
    if (@$view->footer) {
        LP_Helper::getInstance()->get_overlay_detail();
        $items = LP_Helper::getInstance()->getOverlayData();
        if($items){
          $items = $items;
        }else{
          $items = '';
        }
    }
@endphp
@if ($view->footer)
    @include("partials.footer")
@endif
@if ($view->popup)
    @include("partials.".$view->popup)
@endif
<script type="text/javascript">
    var site = {
        baseUrl: "{{ LP_BASE_URL }}",
        lpPath:"{{ LP_PATH }}",
        lpAssetsPath:"{{ LP_ASSETS_PATH }}",
        items : '{!! $items !!}',
        version : "{{LP_VERSION}}"
    };

    var funnel_json = '{!! json_encode(LP_Helper::getInstance()->getAllFunnel() , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS) !!}';
    var client_type = '{{ $view->session->clientInfo->client_type }}';
    var vertical_id  = '{{ \App\Constants\LP_Constants::VERTICAL_ID_FOR_LANDING_PAGES }}';
    var funnel_url = '{{ LP_Helper::getInstance()->getFunnelUrlTag() }}';
    var clone_flag = '{{ LP_Helper::getInstance()->getCloneFlag() }}';
    var stickybar_flag = '{{ $view->session->clientInfo->stickybar_flag }}';
    var funnel_perPage = '{{ @$view->session->tag_filter->perPage }}';
    var funnel_page = '{{ @$view->session->tag_filter->page }}';
    var folder_list = '{!! json_encode(folder_list()) !!}';
    var tag_list = '{!! json_encode(tag_list()) !!}';
    var funnel_hash = '{{@$view->data->funnelData['hash']}}';
    var tag_folder_enable = '{{(isset($_COOKIE['tag']) and $_COOKIE['tag'] == 1)?$_COOKIE['tag']:@$view->session->clientInfo->tag_folder}}';
</script>
@php
    $default_js = array();
    if(@$_COOKIE['dev'] == 'me'){
        array_push($default_js, config('view.theme_assets').'/external/jquery-3.2.1.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/bootstrap/js/bootstrap.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/select/js/bootstrap-select.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/select2/js/select2.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/colorpicker/js/colorpicker.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/custom-scroll/jquery.mCustomScrollbar.concat.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/bootstrap-slider/bootstrap-slider.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/bootstrap-toggle/js/bootstrap-toggle.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/leadpops_admin.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/validation/jquery.validate.js?v='.LP_VERSION);

        array_push($default_js, config('view.theme_assets').'/js/jquery.flip.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/input-mask/jquery.inputmask.bundle.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/jquery.ics-gradient-editor.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/date-picker/moment.js?v=".LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/date-picker/moment-timezone.min.js?v=".LP_VERSION);
        array_push($default_js, 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js');
        array_push($default_js, 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js');
        array_push($default_js, config('view.theme_assets')."/external/date-picker/daterangepicker.js?v=".LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/nice-scroll/jquery.nicescroll.min.js?v=".LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/lp_stats.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/lp_sticky_bar.js?v='.LP_VERSION);

        array_push($default_js, config('view.theme_assets').'/js/global-functions.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/custom.js?v='.LP_VERSION);
        array_push($default_js, "//fast.wistia.net/assets/external/E-v1.js");
        array_push($default_js, config('view.theme_assets').'/js/leadpops_helper.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/owlcarousel/owl.carousel.js?v=" . LP_VERSION);
        array_push($default_js, 'https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/js/froala_editor.min.js?v=' . LP_VERSION);
        array_push($default_js, 'https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/js/froala_editor.pkgd.min.js?v=' . LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/froala-editor/js/video.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/froala-editor/js/file.js?v=" . LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/froala-editor/js/font_family.min.js?v=" . LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/msg-note.js?v=' . LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/froala-editor/js/froala-custom.js?v=" . LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/custom-steele.js?v='.LP_VERSION);
    }
    else {
        array_push($default_js, config('view.theme_assets').'/external/jquery-3.2.1.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/jquery-ui.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/bootstrap/js/bootstrap.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/select/js/bootstrap-select.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/select2/js/select2.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/colorpicker/js/colorpicker.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/custom-scroll/jquery.mCustomScrollbar.concat.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/bootstrap-slider/bootstrap-slider.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/bootstrap-toggle/js/bootstrap-toggle.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/leadpops_admin.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/validation/jquery.validate.js?v='.LP_VERSION);

        array_push($default_js, config('view.theme_assets').'/js/jquery.flip.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/input-mask/jquery.inputmask.bundle.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/jquery.ics-gradient-editor.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/date-picker/moment.js?v=".LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/date-picker/moment-timezone.min.js?v=".LP_VERSION);
        array_push($default_js, 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js');
        array_push($default_js, 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js');
        array_push($default_js, config('view.theme_assets')."/external/date-picker/daterangepicker.js?v=".LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/nice-scroll/jquery.nicescroll.min.js?v=".LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/lp_stats.js?v='.LP_VERSION);

        array_push($default_js, config('view.theme_assets').'/js/global-functions.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/custom.js?v='.LP_VERSION);
        array_push($default_js, "//fast.wistia.net/assets/external/E-v1.js");
        array_push($default_js, config('view.theme_assets').'/js/leadpops_helper.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/owlcarousel/owl.carousel.js?v=" . LP_VERSION);
        array_push($default_js, 'https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/js/froala_editor.min.js?v=' . LP_VERSION);

        array_push($default_js, 'https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/js/froala_editor.pkgd.min.js?v=' . LP_VERSION);
        if(in_array(app('request')->route()->getAction()['as'], array('footeroption','global_settings','autoresponder','thankyoumessage'))){
        array_push($default_js, config('view.theme_assets').'/external/froala-editor/js/super_footer_cta_link.js?v='.LP_VERSION);
        }else{
         array_push($default_js, config('view.theme_assets').'/external/froala-editor/js/cta_link.js?v='.LP_VERSION);
        }
        array_push($default_js, config('view.theme_assets').'/external/froala-editor/js/video.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/froala-editor/js/file.js?v=" . LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/froala-editor/js/font_family.min.js?v=" . LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/msg-note.js?v=' . LP_VERSION);
        array_push($default_js, config('view.theme_assets')."/external/froala-editor/js/froala-custom.js?v=" . LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/custom-steele.js?v='.LP_VERSION);
    }
    if(@$view->session->clientInfo->sticky_bar_v2 == 1){
        array_push($default_js, config('view.theme_assets').'/external/froala-editor/js/font_awesome.min.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/nano-scroll/jquery.nanoscroller.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/froala-editor/js/stickybar_froala_custom.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/external/dropzone/dropzone.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/lp_sticky_bar_v2.js?v='.LP_VERSION);
        array_push($default_js, config('view.theme_assets').'/js/lp_stats_v2.js?v='.LP_VERSION);
    }else{
        array_push($default_js, config('view.theme_assets').'/js/lp_sticky_bar.js?v='.LP_VERSION);
    }

    if($sf && @DataRegistry::getInstance()->leadpops->skip_survey == 0){
        array_push($default_js, LP_ASSETS_PATH.'/survey/js/survey.js?v='.LP_VERSION);
    }
@endphp
@foreach ($default_js as $js)
    <script type="text/javascript" src="{{ $js }}"></script>
@endforeach
@foreach ($view->assets_js as $js)
    <script type="text/javascript" src="{{ $js."?v=".LP_VERSION }}"></script>
@endforeach
<script type="text/javascript">
    console.log("db: {{ config('database.connections.mysql.database') }}")
    console.log("dataSrc: {{ LP_Helper::getInstance()->datasrc }}");




    jQuery(document).ready(function() {

        {!! $view->inline_js !!}
    });

   /* jQuery(document).ready(function($) {

        if (window.history && window.history.pushState) {

            history.pushState(null, document.title, location.href);

           // window.history.pushState('forward', null, './#forward');

            $(window).on('popstate', function(event) {
                debugger;
                console.log(event)
                alert('Back button was pressed.');
            });

        }
    });*/

</script>
</body>
</html>
