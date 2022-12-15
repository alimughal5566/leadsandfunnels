@extends("layouts.guest")

@section('content')
    <div class="lp-wrapper">
        <div class="lp-wrapper__form">
            <form id="reset-password" action="" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <h2 class="lp-panel__heading">password change</h2>
                        <p class="lp-panel__dsc">
                            Create a new, strong password that will help keep <br class="hidden-xs">
                            your account&nbsp;secure.
                        </p>
                    </div>
                    <div class="lp-panel__body">
                        <div class="lp-input__holder">
                            <div class="tag-box">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input id="password" name="password" class="lp-input__field" type="password" placeholder="Enter New Password">
                            <div class="control-option">
                                <div class="view tooltip" title="Show password">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="validation">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>
                        <div class="lp-input__holder">
                            <div class="tag-box">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input id="confirm_password" name="confirm_password" class="lp-input__field" type="password" placeholder="Confirm New Password">
                            <div class="control-option">
                                <div class="view tooltip" title="Show password">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="validation">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        </div>

                        <div class="server-side-errors" @if ($errors->any()) style="display: block;" @endif>
                            @if($errors->has('password'))
                                <div id="password-error" class="error">{{$errors->first('password')}}</div>
                            @endif

                            @if(!$errors->has('password') && $errors->has('confirm_password'))
                                <div id="confirm_password-error" class="error">Password and confirmation password do not match.</div>
                            @endif
                        </div>

                        <div class="errorTxt"></div>
                    </div>
                    <div class="lp-panel__footer">
                        <button id="button-submit" class="button button-outline button-invalid" type="submit">save new password</button>
                    </div>
                </div>
                <div class="footer">
                    @if(env('APP_ENV') === config('app.env_local'))
                        <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{asset('login/img/leadpops-micro-logo.png')}}" alt="leadpops-micro-log"></a>
                    @else
                        <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{secure_asset('login/img/leadpops-micro-logo.png')}}" alt="leadpops-micro-log"></a>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{config('view.theme_assets').'/external/tooltipster/tooltipster.bundle.min.css?v='.LP_VERSION}}">
@endpush

@push('scripts')
    <script src="{{config('view.theme_assets').'/external/tooltipster/tooltipster.bundle.js?v='.LP_VERSION}}"></script>
    <script src="{{config('view.theme_assets').'/js/guest/activateClient.js?v='.LP_VERSION}}"></script>
@endpush
