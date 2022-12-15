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
                            <div class="login-flip {{ (Session::has('error') || Session::has('success') ) ? 'flip_height':''}}">
                                <div id="login-tabs">
                                    <div class="flip-front">
                                        <div class="login-block__content-box">
                                            <h2>Welcome back!</h2>
                                            <p>Login to your leadPops Funnels Admin Panel&nbsp;below.</p>
                                            <div class="login-box">
                                                <ul class="nav nav-tabs login-tabs" id="myTab" role="tablist" style="display: none;">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="funnels-tab" data-toggle="tab" href="#funnels" role="tab" aria-controls="funnels" aria-selected="true">FUNNELS 3.0 LOGIN</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="fire-tab" data-toggle="tab" href="#fire" role="tab" aria-controls="fire" aria-selected="false">EMAIL FIRE LOGIN</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content login-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="funnels" role="tabpanel" aria-labelledby="funnels-tab">
                                                        @if(Session::has('error'))
                                                            <div class="alert alert-danger alert-dismissible">
                                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                <strong>Error:</strong> {{  Session::get('error') }}
                                                            </div>
                                                        @endif
                                                        @if(Session::has('success'))
                                                            <div class="alert alert-success alert-dismissible">
                                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                <strong>Success:</strong> {{ Session::get('success') }}
                                                            </div>
                                                        @endif
                                                        <form class="login-form" id="funnel-form" action="{{ LP_PATH }}/login/go"  method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <div class="input-wrap">
                                                                    <input type="email" id="username" class="form-control" name="un" placeholder="Email Address" required="" aria-required="true">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-wrap">
                                                                    <input type="password" id="pw" class="form-control" name="pw" placeholder="Password" minlength="2" required="" aria-required="true">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <ul class="login-form__list">
                                                                    <li>
                                                                        <label class="form-label">
                                                                            <input type="checkbox" name="r" value="1">
                                                                            <span class="fake-input"></span>
                                                                            <span class="fake-label">Remember me</span>
                                                                        </label>
                                                                    </li>
                                                                    <li><a href="#" id="forgot-password">Forgot Password?</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="button-holder">
                                                                <input type="hidden" name="s_key" value="{{ request()->get('key') }}">
                                                                <button id="lb1" type="submit" class="btn btn-primary" title="Sign in"> Sign in <span class="icon ico-caret-right"></span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade" id="fire" role="tabpanel" aria-labelledby="fire-tab">
                                                        <form target="_blank" class="login-form" name="fire-form" id="fire-form" action="https://app.e2ma.net/app2/login/" method="post">
                                                            <div class="form-group">
                                                                <div class="input-wrap">
                                                                    <input type="email" class="form-control" name="username" placeholder="Email Address" aria-required="true" aria-invalid="true">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-wrap">
                                                                    <input type="password" class="form-control" name="password" placeholder="Password" aria-required="true">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <ul class="login-form__list">
                                                                    <li>
                                                                        <label class="form-label">
                                                                            <input type="checkbox">
                                                                            <span class="fake-input"></span>
                                                                            <span class="fake-label">Remember me</span>
                                                                        </label>
                                                                    </li>
                                                                    <li><a href="https://app.e2ma.net/app2/login/" target="_blank">Forgot Password?</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="button-holder">
                                                                <button id="emmaLoginBtn" type="submit" class="btn btn-primary" title="Sign in"> Sign in <span class="icon ico-caret-right"></span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-reset flip-back">
                                        <div class="login-block__content-reset">
                                            <h1 class="h2">Forgot your password?</h1>
                                            <div class="text">
                                                <p>Enter the email address for your account. We'll send an email with your&nbsp;password.</p>
                                            </div>

                                            <div class="login-box">
                                                <div class="login-content">
                                                    <div id="reset-password-alert" class="alert"></div>

                                                    <form name="reset-password-form" id="reset-password-form" action="#"  class="login-form reset-password-form" method="post">
                                                        <div class="form-group">
                                                            <div class="input-wrap">
                                                                <input type="text" class="form-control login-form-control" name="email" id="email" placeholder="Email Address"  required>
                                                            </div>
                                                        </div>
                                                        <div class="button-holder">
                                                            <a href="#" id="reset-password-btn" class="btn btn-primary">Reset My Password</a>
                                                            <a href="#" class="cancel-recovery" id="forgot-revert">cancel recovery</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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
