<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ffffff">
    @hasSection('page_title')
        <title>@yield('page_title')</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <link rel="apple-touch-icon" sizes="120x120" href="{{ LP_ASSETS_PATH }}/adminimages/apple-touch-icon.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-32x32.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-16x16.png?v={{ LP_VERSION }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <script type="text/javascript" src="{{ config('view.theme_assets') }}/external/jquery-3.2.1.min.js?v={{ LP_VERSION }}"></script>
    <script type="text/javascript" src="{{ config('view.theme_assets') }}/external/validation/jquery.validate.js?v={{ LP_VERSION }}"></script>
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/78d721c580.js" crossorigin="anonymous"></script>

    <link href="{{config('view.theme_assets').'/css/guest.css?v='.LP_VERSION}}" rel="stylesheet" type="text/css">
    @stack('styles')
    @stack('scripts')
</head>
<body>
    @yield('content')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var site = {
            baseUrl: "{{ LP_BASE_URL }}",
            baseDir:"{{ public_path() }}"
        };
    </script>
</body>
</html>
