@extends("layouts.leadpops-inner")

@section('content')
    @include("partials.flashmsgs")
    <!-- contain main informative part of the site -->
    <main class="main">
        <div class="main-content">

            <!-- page messages-->
            <!-- Title wrap of the page -->
            <div class="main-content__head">
                <div class="col-left">
                    <ul class="list-inline m-0 d-flex align-items-center">
                        <li class="list-inline-item">
                            <h1 class="title">leadPops Support</h1>
                        </li>
                    </ul>
                </div>
                <div class="col-right">
                    @if((isset($view->data->videolink) && $view->data->videolink) || (isset($view->data->wistia_id) && $view->data->wistia_id))
                        <a data-lp-wistia-title="{{ $view->data->videotitle }}" data-lp-wistia-key="{{ $view->data->wistia_id }}"
                           class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span>
                            <span class="action-title">
                                WATCH HOW-TO VIDEO
                            </span>
                        </a>
                    @endif
                </div>
            </div>
            <!-- support content of the page -->
            <div class="support-content-area">
                <!-- support block area -->
                <div class="support-block-area">
                    <div class="row">
                        <div class="col-6">
                            <div class="support-block-area__block">
                                <div class="support-block-area__head">
                                    <h2>Contact Info</h2>
                                </div>
                                <div class="support-block-area__map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d498.3826894594638!2d-117.22970727497747!3d32.826561027633325!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3680f9671aeb2612!2sleadPops%2C%20Inc!5e0!3m2!1sen!2sus!4v1601371660553!5m2!1sen!2sus"></iframe>
                                </div>
                                <div class="support-block-area__info">
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="contact-info list-unstyled">
                                                <li>
                                                    <a class="link-wrap" href="mailto:&#115;&#117;&#112;&#112;&#111;&#114;&#116;&#064;&#108;&#101;&#097;&#100;&#080;&#111;&#112;&#115;&#046;&#099;&#111;&#109;">
                                                        <span class="icon">
                                                            <i class="ico-smart-mail"></i>
                                                        </span>
                                                        <span class="text">&#115;&#117;&#112;&#112;&#111;&#114;&#116;&#064;&#108;&#101;&#097;&#100;&#080;&#111;&#112;&#115;&#046;&#099;&#111;&#109;</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="link-wrap" href="tel:8555323767">
                                                        <span class="icon">
                                                            <i class="ico-Mobile"></i>
                                                        </span>
                                                        <span class="text">855.leadPops (855.532.3767)</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <ul class="contact-info list-unstyled">
                                                <li>
                                                    <div class="link-wrap">
                                                        <span class="icon">
                                                            <i class="ico-building"></i>
                                                        </span>
                                                        <address class="text">
                                                            leadPops, Inc.<br>
                                                            2665 Ariane Dr #201<br>
                                                            San Diego, CA 92117
                                                        </address>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="support-chat-list list-unstyled">
                                    <li><a href="{{ URL::route('hub') }}" class="button button-primary"><i class="ico-marketing-hub"></i>Marketing Hub</a></li>
                                    <li><a href="https://support.leadpops.com/" target="_blank" class="button button-primary"><i class="ico-knowledge"></i>Knowledge Base</a></li>
                                    <li><a target="_blank" href="https://leadpops.com/consult" class="button button-primary">Schedule An Appointment</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <form name="lp-support-form" id="lp-support-form" method="post" action="{{ LP_PATH }}/support/feed">
                                {{csrf_field()}}
                                <input type="hidden" name="issuedatainfo" id="issuedatainfo" value='{{ json_encode($view->data->subissuedata) }}'>
                                <input type="hidden" name="targetele" id="targetele" value='{{ ($view->data->target_ele)?$view->data->target_ele: "" }}'>
                                <input type="hidden" name="mailmsg" id="mailmsg" value="">
                                <input type="hidden" name="mailsubject" id="mailsubject" value="">

                                <div class="support-block-area__block">
                                    <div class="support-block-area__head">
                                        <h2>Submit a Support Request</h2>
                                    </div>
                                    <div class="subject-select-wrap">
                                        <div class="subject-select-area">
                                            <strong class="subject-select-area__title">Category</strong>
                                            <div class="subject-select-parent subject-select-parent01 select2js__nice-scroll">
                                                <select name="maintopic" id="maintopic" class="subject-select01">
                                                    <option value="">Select Category</option>
                                                    @php
                                                        $first_key="";
                                                    @endphp
                                                    @foreach ($view->data->maintopic as $key => $title)
                                                        @php
                                                            if($first_key=="") $first_key=$key;
                                                        @endphp
                                                        <option value="{{ $key }}"{{ (isset($this->data->request) && $key == $this->data->request['type']) ? "selected" : "" }}>{{ $title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="subject-select-area">
                                            <strong class="subject-select-area__title">Topic</strong>
                                            <div class="subject-select-parent subject-select-parent02 select2js__nice-scroll">
                                                <select name="mainissue" id="mainissue" class="subject-select02" disabled>
                                                    <option value="">Select Topic</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="subject-select-wrap field">
                                        <div class="subject-select-area">
                                            <strong class="subject-select-area__title">Subject</strong>
                                            <div class="field-wrap">
                                                <input name="subject" id="subject" type="text" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="textarea-field">
                                        <textarea name="message" id="message" placeholder="" class="form-control">@if(isset($view->data->request)) {{ $view->data->request['message'] }} @endif</textarea>
                                    </div>
                                    <span class="btn-wrap">
                                        <input id="btn-spt-form" type="submit" name="btn-spt-form" class="button button-secondary" value="submit">
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- support video section -->
                <div class="support-video-section">
                    <div class="support-video-section__wrap">
                        <div class="support-video-section__head">
                            <h2>How-To Videos</h2>
                        </div>
                        <div class="video-accordion-area">
                            @php
                                $homepage=['Homepage Mortgage','Homepage Insurance','Homepage Real Estate'];
                                $client_type[]="Homepage ".LP_Helper::getInstance()->getClientType();
                                $notallow=array_diff($homepage, $client_type);
                                /*debug($notallow,'0','');
                                debug($this->data->support_video_data);*/

                                $i=1;
                            @endphp
                            @foreach ($view->data->support_video_data as $group=>$videos)
                                @if(!in_array($group, $notallow))
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                            <span>
                                                {{ str_replace('-',' > ',str_replace('_',' ',$group)) }}
                                            </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#group-{{ $i }}"><span></span></div>
                                    </div>
                                </div>
                                <div id="group-{{ $i }}" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            @foreach ($videos as $vdata)
                                                <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        @if($vdata["wistia_id"])
                                                            <a data-target="#lp-video-modal" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="{{$vdata["wistia_id"]}}" data-lp-wistia-title="@if(isset($vdata["title"]) && $vdata["title"]) {{ $vdata["title"] }} @endif">
                                                                <img src="{{LP_ASSETS_PATH}}/adminimages/videoph_thumb.png" title="{{ $vdata["title"] }}" alt="{{ $vdata["title"] }}">
                                                            </a>
                                                        @elseif($vdata["url"])
                                                            @php
                                                                $url_data=explode("/", $vdata["url"]);
                                                                $embed= end($url_data);
                                                            @endphp

                                                            @if($vdata["url"] == "#")
                                                                <a data-target="#lp-video-modal" data-toggle="modal" href="javascript:void(0)" class="video-link lp-wistia-video" data-lp-wistia-key="{{$vdata["url"]}}" data-lp-wistia-title="@if(isset($vdata["title"]) && $vdata["title"]) {{ $vdata["title"] }} @endif">
                                                                    <img src="{{LP_ASSETS_PATH}}/adminimages/videoph_thumb.png" title="{{ $vdata["title"] }}" alt="{{ $vdata["title"] }}">
                                                                </a>
                                                            @else
                                                                <a href="{{ $vdata["url"] }}" class="video-link lpsupportvideo" data-youtubed="{{ $embed }}" data-url="{{ $vdata["url"] }}">
                                                                    <img src="{{LP_ASSETS_PATH}}/adminimages/videoph_thumb.png" title="{{ $vdata["title"] }}" alt="{{ $vdata["title"] }}">
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <strong class="support-video-row__name">{{ $vdata["title"] }}</strong>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @php $i++; @endphp
                                    </div>
                                </div>
                            </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- support block area -->
                <div class="support-block-area mb-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="support-block-area__block">
                                <div class="support-block-area__head">
                                    <h2>Social Media</h2>
                                </div>
                                <div class="support-block-area__text">
                                    <p>Connect with the leadPops community on social media using the links below. We look forward to getting to know you!</p>
                                </div>
                                <ul class="social-networks list-unstyled">
                                    <li>
                                        <a target="_blank" href="{{ LP_SM_FB_LINK }}" class="facebook"><i class="icon ico-facebook"></i> facebook</a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="{{ LP_SM_TWITTER_LINK }}" class="twitter"><i class="icon ico-twitter"></i> twitter</a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="{{ LP_SM_LINKEDIN_LINK }}" class="linkedin"><i class="icon ico-linkedin"></i> linkedin</a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="{{ LP_SM_YOUTUBE_LINK }}" class="youtube"><i class="icon ico-youtube"></i> youtube</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="support-block-area__block">
                                <div class="support-block-area__head">
                                    <h2>Close Account</h2>
                                </div>
                                <div class="support-block-area__text">
                                    <p><b>Not getting the results you’d hoped for? We can help.</b></p>
                                    <p>Sometimes all it takes is a focused 1:1 call with your Marketing Advisor for leadPops to work for you like it has for thousands of our clients.</p>
                                    <a class="button button-primary" target="_blank" href="mailto:support@leadpops.com?subject=I would like to schedule a call with a Marketing Advisor">Schedule my 1:1 call</a>
                                    <p>With so many powerful features, we can sometimes miss out on making sure that you know how to harness these tools so you can:</p>
                                    <p></p>
                                    <ul>
                                        <li>
                                            <b>Get leads anywhere you market yourself;</b> installing a funnel can be done in just 30 seconds
                                        </li>
                                        <li>
                                            <b>Build a referral network</b> by putting your funnels on your partners’ websites
                                        </li>
                                        <li>
                                            <b>Turn your website into a revenue source.</b> Make sure your site is working for you.
                                        </li>
                                    </ul>
                                    <p></p>
                                    <p>
                                        There’s so much we can accomplish together.
                                    </p>
                                    <p>
                                        If you still want to cancel, click on the button below.
                                    </p>
                                    <p>
                                        <a target="_blank" href="mailto:support@leadpops.com?subject=I Want To Quit" class="button button-primary">I Want To Quit</a>
                                        <a target="_blank" href="mailto:support@leadpops.com?subject=I Want A Reason To Stay - Let’s Talk" class="button button-primary">I Want A Reason To Stay - Let’s Talk</a>
                                    </p>
                                    <p>We appreciate you giving us the chance to help you grow your business. If you try something else and it doesn’t work, we’ll be ready to welcome you back with open arms.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer of the page -->
            <div class="footer">
                <div class="row">
                    <img src="{{ config('view.rackspace_default_images') }}/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </div>
    </main>


    <!-- Model Boxes - Deactivate Account - Start -->
    <div id="cancelrequest" class="modal fade lp-modal-box" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Deactivate Account</h3>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">Are you sure you want to deactivate your Account?</p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button id="cancelrequestbtn" class="button button-bold button-primary"  type="button">Deactivate</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Model Boxes - Deactivate Account - End -->
@endsection
