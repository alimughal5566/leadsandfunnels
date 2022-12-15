@extends("layouts.login")

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="login-logo text-center">
                    <a href="#"><img src="{{ LP_ASSETS_PATH }}/adminimages/logo.png"></a>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" id="global_issuedatainfo" value="[]">
            <div class="col-sm-8 col-sm-push-2">
                <div class="flip-wrapper">
                    <div id="login-tabs">
                        <div id="lp-forget-wrapper" class="flip-front">

                            <div id="forget" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="form-forget-msg">
                                        <h3>Create a new Password</h3>
                                        <p>Enter the new password for your account. After reset you will be able to login to your account.</p>
                                        <hr>
                                    </div>
                                    <div class="col-sm-8 col-sm-push-2">
                                        <div id="reset-password-alert" class="alert"></div>
                                        <div class="form-wrapper">
                                            @if($view->data->token)
                                            <form name="reset-password-form" id="reset-password-form" action="{{ route('password_update') }}" method="post">
                                                @csrf
                                                <div class="login-form">
                                                    <div class="form-group login-border">
                                                        <label for="password" class="form-label">New Password</label>
                                                        <input type="password" class="form-control login-form-control" name="password" id="password" required>
                                                    </div>

                                                    <div class="form-group login-border">
                                                        <label for="password2" class="form-label">Re-Type New Password</label>
                                                        <input type="password" class="form-control login-form-control" name="password2" id="password2" required>
                                                    </div>

                                                    <input type="hidden" name="token" id="token" value="{{ $view->data->token }}">
                                                    <input type="hidden" name="email" id="email" value="{{ $view->data->email }}">
                                                    <a href="#" id="reset-password-btn" class="btn btn-sign-in">Reset My Password</a>
                                                    <div class="cancel-recovery">
                                                        <a href="{{ route('login') }}" id="login_screen">Login</a>
                                                    </div>

                                                </div>
                                            </form>
                                            @else
                                                <div class="alert alert-danger alert-dismissible">
                                                    Password reset token is expired. Please create new reset link to update password. <a href="{{ route('login') }}">Go Back to Login</a>
                                                </div>
                                            @endif
                                        </div>
                                        <h3 class="account-trial">Don't have an account? <a href="#">Start your free trial!</a></h3>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection