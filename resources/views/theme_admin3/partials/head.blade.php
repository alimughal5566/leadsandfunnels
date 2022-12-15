@php
date_default_timezone_set('America/Los_Angeles');
$page_name = basename($_SERVER['REQUEST_URI']);
define('VERSION','3.2.1');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- set the encoding of your site -->
    <meta charset="utf-8">
    <!-- set the viewport width and initial-scale on mobile devices  -->
    <meta name="viewport" content="width=1280">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicons -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{ config('view.rackspace_default_images') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ config('view.rackspace_default_images') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ config('view.rackspace_default_images') }}/favicon-16x16.png">
    <!-- google fonts -->
    {{--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&family=Orbitron:400,500,600,700,800,900&family=Courgette&display=swap" rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css2?family=Courgette&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Orbitron:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @hasSection('page_title')
        <title>@yield('page_title')</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <!-- include the site stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/78d721c580.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/external-style.min.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/app.min.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/text-field-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/text-field-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/vehicle-field-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/vehicle-field-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/zip-code-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/zip-code-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-contact-info-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-contact-info-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-number-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-number-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-menu-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-menu-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-dropdown-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-dropdown-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-cta-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-cta-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-birthday-content.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-birthday-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/security-message.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-slider-overlay.css?v={{ LP_VERSION }}">
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/funnel-question-slider.css?v={{ LP_VERSION }}">

@if ($view->assets_css)
        @foreach ($view->assets_css as $css)
           @if(strpos($css,'fonts.googleapis') !== false)
               <link href="{{ $css }}" rel="stylesheet" type="text/css">
                @else
                <link href="{{ $css."?v=".LP_VERSION  }}" rel="stylesheet" type="text/css">
               @endif
        @endforeach
    @endif
    @if ($view->inline_css)
    <!-- Inline CSS -->
        <style type="text/css" media="screen" rel="stylesheet">
            {!! $view->inline_css !!}
        </style>
    @endif
    <style type="text/css" media="screen" rel="stylesheet">
        .box__counter {
            border: 2px solid @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        .personally-branded-detail-wrap .image-holder:before {
            border: 1px solid @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        .personally-branded-detail-wrap .image-holder:after,
        .personally-branded-heading .name-wrap:before {
            background: @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        .animate-container .fifth.desktop::after {
            border-bottom: 16px solid @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        .animate-container .fifth.desktop {
            background-color: @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
        }
        .lp-contact-review .lp-contact-review__img .fr-fic.fr-dii,
        .lp-contact-review .lp-contact-review__img .fr-fil.fr-dib,
        .lp-contact-review .lp-contact-review__img .co-branded-image,
        .lp-contact-review .lp-contact-review__img .review-image,
        .review-template-section .lp-contact-review__img .fr-dib,
        .review-template-section .lp-contact-review__img .fr-dii,
        .review-template-section .lp-contact-review__img .fr-dib.fr-fir {
            border-color: @php echo @$view->data->advancedfooteroptions["logocolor"]; @endphp;
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
        @if(LP_Helper::getInstance()->isDisabledStickyBannerForClient($view->session->clientInfo->client_id))
       body.super_banner_body {
            padding-top: 0 !important;
        }
        @endif
    </style>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-TJRRB7K');</script>
    <!-- End Google Tag Manager -->
</head>
@php
// LP-TODO: We will replace this array with route-names when we will create these pages.

 $filter_search = @$view->session->tag_filter;
$sidebar = '';
$searchFilter = (isset($filter_search->searchFilter))?($filter_search->searchFilter ==1)?' hide-seach':'':' hide-seach';
$statsFilter = (isset($filter_search->statsFilter))?($filter_search->statsFilter ==1)?' hide-stats':'':'';
@endphp
<body class="{{in_array(Request::route()->getName(), config('lp.sidebar-off-page')) ?"aside-panel off-sidebar" : "sidebar-inner-active"}}
{{ Request::route()->getName() == "dashboard" ? "home-page ".$sidebar.$searchFilter.$statsFilter."" : "inner-page" }}
{{ (Request::route()->getName() == "support" || Request::route()->getName() == "videos") ? "support-page" : '' }}
{{ (Request::route()->getName() == "support" || Request::route()->getName() == "ticket") ? "support-page" : '' }}
{{ Request::route()->getName() == "my_profile" ? " account-page" : "" }}
{{ (Request::route()->getName() == "hub" || Request::route()->getName() == "hubdetail") ? " marketing-hub-page" : "" }}
@stack('body_classes')">
<!-- ==== Loader Screen ==== -->
<div id="mask">
    <div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
</div>
<!-- main container of all the page elements -->
<div id="wrapper">
    @includeWhen(Request::route()->getName() == "funnel-question", "partials.funnel-question")
    @include("partials.global-settings", ['globalData' => [$globalRoutes, $currentRoute]])
    <!-- wrapper holder of the page -->
    <div class="wrapper__holder">
