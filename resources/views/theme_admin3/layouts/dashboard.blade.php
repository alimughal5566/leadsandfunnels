@php
    $globalRoutes = config("routes.globalSettings");
    $currentRoute = Request::route()->getName();
@endphp


@include("partials.head", ['globalData' => [$globalRoutes, $currentRoute]])
 {{--contain sidebar of the page --}}
@include("partials.sidebar-menu")

<div id="content">

    @include("partials.header", ['globalData' => [$globalRoutes, $currentRoute]])

    @yield('content')

</div>

@include ("partials.video-modal")

{{--@includeWhen( in_array($currentRoute, $globalRoutes ), "partials.global-settings-modal", ['globalData' => [$globalRoutes, $currentRoute]])--}}
@include(  "partials.global-settings-modal", ['globalData' => [$globalRoutes, $currentRoute]])

@include ("partials.footer", ['globalData' => [$globalRoutes, $currentRoute]])
