<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link rel="apple-touch-icon" sizes="120x120" href="{{ LP_ASSETS_PATH }}/adminimages/apple-touch-icon.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-32x32.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-16x16.png?v={{ LP_VERSION }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    @hasSection('page_title')
    <title>@yield('page_title')</title>
    @else
    <title>{{ config('app.name') }}</title>
    @endif

    <link href="{{ config('view.theme_assets') }}/external/bootstrap/css/bootstrap.css?v={{ LP_VERSION }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet" type="text/css">

    @if(env('APP_ENV') == config('app.env_local'))
    <link href="{{asset('login/css/app.css?v='.LP_VERSION)}}" rel="stylesheet" type="text/css">
    @else
    <link href="{{secure_asset('login/css/app.css?v='.LP_VERSION)}}" rel="stylesheet" type="text/css">
    @endif

    @foreach ($view->assets_css as $css)
    <link href="{{ $css."?v=".LP_VERSION }}" rel="stylesheet" type="text/css">
    @endforeach
</head>
<body class="{{ implode(' ', $view->body_class) }}">
    @yield('content')

    <script type="text/javascript">
        var ajax_token = '{{ csrf_token() }}';
        var site = {
            baseUrl: "{{ LP_BASE_URL }}",
            baseDir:"{{ public_path() }}"
        };
    </script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/external/jquery-3.2.1.min.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/external/bootstrap/js/bootstrap.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/external/validation/jquery.validate.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/js/jquery.flip.min.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/js/custom-steele.js?v={{ LP_VERSION }}"></script>
    @foreach ($view->assets_js as $js)
    <script type="text/javascript" src="{{ $js."?v=".LP_VERSION }}"></script>
    @endforeach
    <script type="text/javascript">
        jQuery(document).ready(function() {
            {{ $view->inline_js }}
        });
    </script>
</body>
</html>