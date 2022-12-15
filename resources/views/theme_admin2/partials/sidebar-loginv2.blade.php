@if(env('APP_ENV') === config('app.env_local'))
    <div class="login-block__banner bg-stretch" style="background-image: url({{asset('login/img/bg-login.png')}}">
@else
    <div class="login-block__banner bg-stretch" style="background-image: url({{secure_asset('login/img/bg-login.png')}}">
@endif
    <div class="login-block__banner-logo">
        @if(env('APP_ENV') === config('app.env_local'))
            <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{asset('login/img/mortgage-leadpops-footer-micro-logo.png')}}" alt="leadPops Lead Generation Logo" title="leadPops Lead Generation Logo"></a>
        @else
            <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{secure_asset('login/img/mortgage-leadpops-footer-micro-logo.png')}}" alt="leadPops Lead Generation Logo" title="leadPops Lead Generation Logo"></a>
        @endif
    </div>
    <h2>We've got digital marketing down to&nbsp;a&nbsp;science.</h2>
    <div class="login-block__banner-text">
        <p>You don’t need more traffic — you need a fun, sticky way to capture more of the visitors you’re already&nbsp;getting</p>
    </div>
    <a href="{{ env('FREE_TRIAL_LINK') }}" class="btn btn-primary btn-lg" title="Start Your FREE 30-Day Trial of leadPops Mortgage Lead Generation Software">Start Your Free Trial <span class="icon ico-caret-right"></span></a>
    <span class="login-block__banner-caption">Copyright ©2021 <a href="https://leadpops.com" target="_blank">leadPops, Inc.</a></span>
</div>
