@extends("layouts.login")

@section('content')

    <section class="form-section">
        <div class="container">
            <div class="form-section__align">
                <div class="row-holder">
                    <div class="col bg-white">
                        <div  class="form-section__content login-flip {{ (Session::has('error'))?'flip_height':''}}">
                        @if($view->data->token)
                                <div id="login-tabs">
                                    <div class="content-login flip-front">
                                        <h1 class="h2">Create a new Password</h1>
                                        <div class="text">
                                            <p>Enter your new password to reset.</p>
                                        </div>
                                        <!-- Tab Content -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="funnel">
                                                @if(Session::has('error'))
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        {{ Session::get('error') }}
                                                    </div>
                                                @endif
                                                    <form class="login-form" id="reset-password-form" action="{{ LP_PATH }}/password/reset" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <div class="input-wrap">
                                                                <span class="icon ico-lock"></span>
                                                                <input type="password" id="password" class="form-control" name="password" placeholder="New password" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="margin-bottom: 40px !important;">
                                                            <div class="input-wrap">
                                                                <span class="icon ico-lock"></span>
                                                                <input type="password" id="password2" class="form-control" name="password2" placeholder="Confirm Password" minlength="2" required>
                                                            </div>
                                                        </div>

                                                        <div class="button-holder">
                                                            <input type="hidden" name="token" id="token" value="{{ $view->data->token }}">
                                                            <input type="submit" class="button button_color_primary" value="Reset My Password" style="margin: 0 auto; max-width: 220px !important;">
                                                        </div>
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error:</strong> Password reset link has expired. Go <a href="{{ route('login') }}">back to the login</a> screen and click “forgot password” to request another password reset link.
                                </div>
                            @endif
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
        </div>
    </section>
@endsection
