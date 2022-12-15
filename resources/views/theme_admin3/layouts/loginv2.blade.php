<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- set the encoding of your site -->
    <meta charset="UTF-8">
    <!-- set the viewport width and initial-scale on mobile devices  -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="120x120"
          href="{{ LP_ASSETS_PATH }}/adminimages/apple-touch-icon.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="32x32"
          href="{{ LP_ASSETS_PATH }}/adminimages/favicon-32x32.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="16x16"
          href="{{ LP_ASSETS_PATH }}/adminimages/favicon-16x16.png?v={{ LP_VERSION }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    @hasSection('page_title')
        <title>@yield('page_title')</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <link href="{{ config('view.theme_assets') }}/external/bootstrap4/css/bootstrap.min.css?v={{ LP_VERSION }}" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,400i,500,600,700&display=swap"
          rel="stylesheet">

    @if(env('APP_ENV') == config('app.env_local'))
        <link href="{{asset('login/css/appv2.css?v='.LP_VERSION)}}" rel="stylesheet" type="text/css">
    @else
        <link href="{{secure_asset('login/css/appv2.css?v='.LP_VERSION)}}" rel="stylesheet" type="text/css">
    @endif

    @foreach ($view->assets_css as $css)
        <link href="{{ $css."?v=".LP_VERSION }}" rel="stylesheet" type="text/css">
    @endforeach
</head>
<body class="{{ implode(' ', $view->body_class) }}">
    @yield('content')

    <script type="text/javascript" src="{{ config('view.theme_assets') }}/external/jquery-3.2.1.min.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript"
            src="{{ config('view.theme_assets') }}/external/bootstrap4/js/bootstrap.min.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript"
            src="{{ config('view.theme_assets') }}/external/validation/jquery.validate.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/js/custom-steele.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var site = {
            baseUrl: "{{ LP_BASE_URL }}",
            baseDir: "{{ public_path() }}"
        };
        localStorage.setItem('mode',0);
        localStorage.setItem('selectedFunnels',[]);
    </script>
    @foreach ($view->assets_js as $js)
        <script type="text/javascript" src="{{ $js."?v=".LP_VERSION }}"></script>
    @endforeach
</body>
</html>
