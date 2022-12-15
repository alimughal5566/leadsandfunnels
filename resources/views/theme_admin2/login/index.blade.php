@extends("layouts.login")

@section('content')

    <section class="form-section">
        <div class="container">
            <div class="form-section__align">
                <div class="row-holder">
                    <div class="col bg-white">
                        <div  class="form-section__content login-flip {{ (Session::has('error') || Session::has('success') )?'flip_height':''}}">
                            <div id="login-tabs">
                                <div class="content-login flip-front">
                                    <h1 class="h2">Welcome back!</h1>
                                    <div class="text">
                                        <p>Login to your leadPops Funnels Admin Panel below.</p>
                                    </div>
                                    <!-- tabs -->
                                    <ul class="nav nav-tabs form-tabs" role="tablist">
                                        <li class="active">
                                            <a href="#funnel" data-toggle="tab">Funnels 2.0 Login</a>
                                        </li>
                                        <li>
                                            <a href="#file" data-toggle="tab">Email Fire Login</a>
                                        </li>
                                    </ul>
                                    <!-- Tab Content -->
                                    <div class="tab-content form-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="funnel">
                                            @if(Session::has('error'))
                                                <div class="alert alert-danger alert-dismissible">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong>Error:</strong> {{ Session::get('error') }}
                                                </div>
                                            @endif
                                            @if(Session::has('success'))
                                                <div class="alert alert-success alert-dismissible">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong>Success:</strong> {{ Session::get('success') }}
                                                </div>
                                            @endif
                                            <form class="login-form" id="go" action="{{ LP_PATH }}/login/go"  method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="input-wrap">
                                                                <span class="icon">
                                                                    <span class="ico-mail"></span>
                                                                </span>
                                                        <input type="email" id="username" class="form-control" name="un" placeholder="Email Address" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrap">
                                                        <span class="icon ico-lock"></span>
                                                        <input type="password" id="pw" class="form-control" name="pw" placeholder="Password" minlength="2" required>
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
                                                    <input type="submit" id="lb1"  class="button button_color_primary" value="Sign in">
                                                </div>
                                            </form>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="file">

                                            <form target="_blank" class="login-form" name="goemma" id="goemma" action="https://app.e2ma.net/app2/login/" method="post">
                                                <div class="form-group">
                                                    <div class="input-wrap">
                                                                <span class="icon">
                                                                    <span class="ico-mail"></span>
                                                                </span>
                                                        <input type="email" class="form-control" name="username" placeholder="Email Address">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrap">
                                                        <span class="icon ico-lock"></span>
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
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
                                                    <a href="#" id="emmaLoginBtn" class="button button_color_primary btn-sign-in">sign in</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-reset flip-back">
                                    <h1 class="h2">Forgot your password?</h1>
                                    <div class="text">
                                        <p>Enter the email address for your account. We'll send an email with your password.</p>
                                    </div>
                                    <div id="reset-password-alert" class="alert"></div>

                                    <form name="reset-password-form" id="reset-password-form" action="#"  class="login-form reset-password-form" method="post">
                                        <div class="form-group">
                                            <div class="input-wrap">
                                                    <span class="icon">
                                                        <span class="ico-mail"></span>
                                                    </span>
                                                <input type="text" class="form-control login-form-control" name="email" id="email" placeholder="Email Address"  required>
                                            </div>
                                        </div>
                                        <div class="button-holder">
                                            <a href="#" id="reset-password-btn" class="button button_color_primary">Reset My Password</a>
                                        </div>
                                        <a href="#" class="cancel-recovery" id="forgot-revert">cancel recovery</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(env('APP_ENV') === config('app.env_local'))
                    <div class="col bg-stretch" style="background-image: url({{asset('/login/img/bg.jpg')}})">
                    @else
                    <div class="col bg-stretch" style="background-image: url({{secure_asset('/login/img/bg.jpg')}})">
                    @endif
                        <div class="form-section__info">
                            <div class="logo">
                                @if(env('APP_ENV') === config('app.env_local'))
                                <a href="#"><img src="{{asset('login/img/leadpops-logo.png')}}" alt="leadpops"></a>
                                @else
                                <a href="#"><img src="{{secure_asset('login/img/leadpops-logo.png')}}" alt="leadpops"></a>
                                @endif
                            </div>
                            <h2><span>We've got</span> digital marketing <span>down to a science.</span></h2>
                            <span class="account-info">Don't have an account yet?</span>
                            <a href="https://mortgage.leadpops.com/free-trial/" class="button button_color_orange">start your free trial</a>
                        </div>
                    </div>
                </div>
            </div>
            @if(env('APP_ENV') === config('app.env_local'))
            <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{asset('login/img/leadpops-micro-logo.png')}}" alt="leadpops-micro-log"></a>
            @else
            <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{secure_asset('login/img/leadpops-micro-logo.png')}}" alt="leadpops-micro-log"></a>
            @endif
        </div>
    </section>
@endsection
