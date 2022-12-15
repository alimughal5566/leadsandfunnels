<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script type="text/javascript" src="/lp_assets/external/jquery-3.2.1.min.js?v=2.5.0"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#testAjax").click(function(e){
                    $.ajax({
                        type: "POST",
                        data: {'_token': '{{csrf_token()}}'},
                        cache: false,
                        url: "/ajax-data",
                        success: function (rsp) {
                            var html = '';
                            $.each(rsp, function(index, value) {
                                html += "<h2>"+index+": "+value+"</h2>";
                            });

                            $("#ajaxResponse").html(html)
                        },
                        error: function (e) {
                            $("#ajaxResponse").html("ERROR")
                        },
                        always: function (d) {
                        }
                    });
                })
            });
        </script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <?php echo $welcome; ?><br />

                    <input type="button" id="testAjax" value="Get AJAX Data" >
                </div>

                <div id="ajaxResponse">

                </div>
            </div>
        </div>
    </body>
</html>
