@extends("layouts.loginv2")

@section('content')
    <!-- main container of all the page elements -->
    <div id="wrapper">
        <!-- contain main informative part of the site -->
        <main class="main">
            <!-- login-block of the page -->
            <section class="login-block">
                <div class="container">
                    <div class="row flex-lg-row-reverse">
                        <div class="login-block__content">
                            <ul class="login-block__content-list">
                                <li><span class="link">Don’t have an account?</span></li>
                                <li><a target="_blank" href="{{ env("DEMO_LINK", "https://mortgage.leadpops.com/request-demo/") }}" class="btn btn-secondary" title="Schedule Demo">Schedule a Demo <span class="icon ico-caret-right"></span></a></li>
                            </ul>
                            <div class="login-flip @if(!$view->data->token) token_expired @endif">
                                <div id="login-tabs">
                                    <div class="content-reset">
                                        <div class="login-block__content-reset">
                                            @if($view->data->token)
                                                <h1 class="h2">Create a new Password</h1>
                                                <div class="text">
                                                    <p>Enter your new password to reset.</p>
                                                </div>

                                                <div class="login-box">
                                                    <div class="login-content">
                                                        @if(Session::has('error'))
                                                            <div class="alert alert-danger alert-dismissible">
                                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                {{ Session::get('error') }}
                                                            </div>
                                                        @endif

                                                        <form name="reset-password-form" id="reset-password-form" action="{{ LP_PATH }}/password/reset" class="login-form reset-password-form" method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <div class="input-wrap">
                                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-required="true">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-wrap">
                                                                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" aria-required="true">
                                                                </div>
                                                            </div>
                                                            <div class="button-holder">
                                                                <input type="hidden" name="token" id="token" value="{{ $view->data->token }}">
                                                                <button id="reset-password-btn" type="submit" class="btn btn-primary" title="Sign in"> Reset My Password<span class="icon ico-caret-right"></span></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="login-box">
                                                    <div class="login-content">
                                                        <div class="alert alert-danger alert-dismissible">
                                                            <strong>Error:</strong> Password reset link has expired. Go <a href="{{ route('login') }}">back to the login</a> screen and click “forgot password” to request another password reset link.
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Login v2 sidebar--}}
                        @include('partials.sidebar-loginv2')
                        </div>
                    </div>
            </section>
        </main>
    </div>
@endsection
