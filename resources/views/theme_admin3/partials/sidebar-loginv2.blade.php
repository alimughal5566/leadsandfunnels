@if(env('APP_ENV') === config('app.env_local'))
    <div class="login-block__banner bg-stretch" style="background-image: url({{asset('login/img/bg-login.png')}}">
@else
    <div class="login-block__banner bg-stretch" style="background-image: url({{secure_asset('login/img/bg-login.png')}}">
@endif
    <div class="login-block__banner-logo">
        @if(env('APP_ENV') === config('app.env_local'))
            <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{asset('login/img/mortgage-leadpops-footer-micro-logo.png')}}" alt="Mortgage Leads by leadPops Logo" title="leadPops Mortgage Lead Generation Logo"></a>
        @else
            <a href="{{LP_BASE_URL}}" class="micro-logo"><img src="{{secure_asset('login/img/mortgage-leadpops-footer-micro-logo.png')}}" alt="Mortgage Leads by leadPops Logo" title="leadPops Mortgage Lead Generation Logo"></a>
        @endif
    </div>
    <h2>We've got digital marketing down to&nbsp;a&nbsp;science.</h2>
    <div class="login-block__banner-text">
        <p>You don’t need more traffic — you need a fun, sticky way to capture more of the visitors you’re already&nbsp;getting</p>
    </div>
    <a href="https://book-demo.leadpops.com/" class="btn btn-primary btn-lg" title="Request a Demo">Request a Demo <span class="icon ico-caret-right"></span></a>
    <span class="login-block__banner-caption">Copyright ©{{date('Y')}} <a href="https://leadpops.com/">leadPops, Inc.</a></span>
</div>
