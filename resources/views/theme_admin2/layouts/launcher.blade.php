<!DOCTYPE html>
<html lang="en">
<head>
    <!-- set the encoding of your site -->
    <meta charset="UTF-8">
    <!-- set the viewport width and initial-scale on mobile devices  -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ LP_ASSETS_PATH }}/adminimages/apple-touch-icon.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-32x32.png?v={{ LP_VERSION }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ LP_ASSETS_PATH }}/adminimages/favicon-16x16.png?v={{ LP_VERSION }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <title>Launch Your leadPops Account Now!</title>
    <meta name="description" content="Description content">
    <!-- SEO tags -->
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="Add title">
    <meta property="og:description" content="Description content">
    <meta property="og:url" content="page html link">
    <meta property="og:image" content="og:image link">
    <meta property="og:image:url" content="og:image link">
    <meta property="og:image:height" content="200"/>
    <meta property="og:image:width" content="200"/>
    <meta property="og:site_name" content="site name">
    <meta property="og:type" content="website" />
    <meta property="fb:app_id" content="445865492104197" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Add title">
    <meta name="twitter:description" content="Description content">
    <meta name="twitter:image:alt" content="site name">
    <meta name="twitter:image" content="og:image link" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet"><!-- include the site stylesheet -->
    <link rel="stylesheet" href="{{ config('view.theme_assets') }}/css/launcher.css?v={{LP_VERSION}}">
    <!-- push CSS to Header -->
    @stack('styles')
    @stack('scripts')
</head>
<body>
    @yield('content')

<!-- include jQuery library -->
<script src="{{ config('view.theme_assets') }}/external/jquery-3.4.1.min.js?v={{LP_VERSION}}"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="{{ config('view.theme_assets') }}/external/jquery.waypoints.min.js?v={{LP_VERSION}}"></script>
<!-- include custom JavaScript -->
<script src="{{ config('view.theme_assets') }}/external/inputmask.bundle.js?v={{LP_VERSION}}"></script>


    <!-- push JS to footer -->
    @stack('FooterScripts')
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
    </script>
    <div id="mask">
        <div class="preloader"><div class="spin base_clr_brd"><div class="clip left"><div class="circle"></div></div><div class="gap"><div class="circle"></div></div><div class="clip right"><div class="circle"></div></div></div></div>
    </div>
</body>
</html>
