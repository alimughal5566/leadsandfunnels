@php
    //use App\Services\DataRegistry;
    $routeName = Request::route()->getName();
    //START - Website URL
    $website =  "";
    $is_active = false;
    if(isset($view->session->clientInfo->lp_marketing_website) && !empty($view->session->clientInfo->lp_marketing_website)) {
        $website = $view->session->clientInfo->lp_marketing_website;
        $parsed = parse_url($website);
        if (empty($parsed['scheme'])) {
            $website = 'https://' . ltrim($website, '/');
        }
        //validate URL
        if(filter_var($website, FILTER_VALIDATE_URL) !== false) {
            $is_active = true;
        }
    }
    //END - Website URL

    $my_website_text = config('lp.my_website_text');
    $funnel_link_inactive = array("hub","hubdetail","support","my_profile");


    //  dd($view);
   @$client_vertical = @$view->session->clientInfo->client_type;

   // initalize defalut values
   $client_vertical_name =  "Mortgage";
    $requestDemoLink = 'https://mortgage.leadpops.com/request-demo/';
    $graderWebsiteLink = 'https://mortgage.leadpops.com/website-grader/';

@endphp

@switch(@$client_vertical)
    @case(1)
    @php
        $client_vertical_name =  "Insurance";
     $requestDemoLink = 'https://insurance.leadpops.com/request-demo/';
     $graderWebsiteLink = 'https://insurance.leadpops.com/website-grader/';
    @endphp
    @break


    @case(3)
    @php
        $client_vertical_name =  "Mortgage";
     $requestDemoLink = 'https://mortgage.leadpops.com/request-demo/';
       $graderWebsiteLink = 'https://mortgage.leadpops.com/website-grader/';
    @endphp
    @break


    @case(5)
    @php
        $client_vertical_name = "Real Estate";
    $requestDemoLink = 'https://realestate.leadpops.com/request-demo/';
        $graderWebsiteLink = 'https://realestate.leadpops.com/website-grader/';
    @endphp
    @break


    @default
    @php
        $client_vertical_name =  "Mortgage";
     $requestDemoLink = 'https://mortgage.leadpops.com/request-demo/';
     $graderWebsiteLink = 'https://mortgage.leadpops.com/website-grader/';
    @endphp
    @break

@endswitch

<aside class="sidebar">
    <div class="menu-holder">
        <div class="menu-holder__logo">
            <a href="{{ URL::route('dashboard') }}">
                <img src="{{ config('view.rackspace_default_images') }}/logo-micro-white-min.png" alt="leadpops" class="micro-logo">
                <img src="{{ config('view.rackspace_default_images') }}/logo-micro-white-min.png" alt="leadpops" class="large-logo">
            </a>
        </div>
        <div class="sidebar-inner-wrap">
            <ul class="menu list-unstyled">
{{--            <li class="menu__list">--}}
{{--                <a href="#" class="menu__link">--}}
{{--                    <span title="Launch Checklists" class="menu__link-icon ico-checklist"></span><span class="menu__link-text">Launch Checklists</span>--}}
{{--                </a>--}}
{{--            </li>--}}
<!--            <li class="menu__list active">-->
<!--                <a href="#" class="menu__link">-->
<!--                    <span title="Dashboard" class="menu__link-icon ico-dashboard"></span><span class="menu__link-text">Dashboard</span>-->
<!--                </a>-->
<!--            </li>-->
            <li class="menu__list">
                <a href="#" data-ov-target="lp-ol-{{ str_replace(' ','-',strtolower(LP_Helper::getInstance()->getClientType())) }}"  id="lp-train-module" class="menu__link">
                    <span title="Quick Start" class="menu__link-icon ico-quick"></span><span class="menu__link-text">Quick Start</span>
                </a>
            </li>
            <li class="menu__list">
                <a href="{{ URL::route('dashboard') }}" class="menu__link {{  !in_array($routeName,$funnel_link_inactive)? "active" : "" }}">
                    <span title="Lead Funnels" class="menu__link-icon ico-funnels-icon"></span><span class="menu__link-text">Lead Funnels</span>
                </a>
            </li>
            <li class="menu__list">
                <a href="javascript:void(0)" class="menu__link disable">
                    <span title="Sticky Bar Dashboard (coming soon!)" class="menu__link-icon ico-clixly"></span><span class="menu__link-text"><span title="Coming Soon!" class="el-tooltip">Sticky Bar Dashboard</span></span>
                </a>
            </li>
            <li class="menu__list">
                <a data-toggle="modal" href="javascript:void(0)" class="menu__link disable">
                    <span title="Campaign Fire (coming soon!)" class="menu__link-icon ico-fire"></span><span class="menu__link-text"><span title="Coming Soon!" class="el-tooltip">Campaign Fire</span></span>
                </a>
            </li>
            <li class="menu__list">
                @php
                    if(!isset($funnelTypes)) {
                        $funnelTypes = LP_Helper::getInstance()->getFunnelTypes(LP_Helper::getInstance()->getClientType());
                    }
                    $_name = str_replace(' ','-', strtolower($funnelTypes['w']));
                    if( LP_Helper::getInstance()->checkHaveWebsiteFunnels() == true && !empty(LP_Helper::getInstance()->websiteFunnelsList()) ) {
                        $type_available = 1;
                     } else {
                        $type_available = 0;
                    }
                @endphp
                <a href="javascript:void(0)" data-lp-wistia-title="My Website" class="menu__link" id="conversion_pro_website" data-lp-wistia-key="44rrt6ay0b" data-navlink="conversion_pro_website" data-type_available="{{ $type_available }}" data-value="{{ $_name }}" data-client-type="{{ LP_Helper::getInstance()->getClientType() }}" data-website="{{$website}}" data-status="{{$is_active}}">
                    <span title="My Website" class="menu__link-icon ico-landing"></span><span class="menu__link-text">My Website</span>
                </a>
            </li>
            <li class="menu__list">
                <a href="{{ URL::route('hub') }}" class="menu__link {{ ($routeName=="hub" || $routeName=="hubdetail") ? "active" : "" }}">
                    <span title="Marketing Hub" class="menu__link-icon ico-marketing-hub"></span><span class="menu__link-text">Marketing Hub</span>
                </a>
            </li>
            <li class="menu__list">
                <a href="https://support.leadpops.com" target="_blank" class="menu__link">
                    <span title="Knowledge Base" class="menu__link-icon ico-knowledge"></span><span class="menu__link-text">Knowledge Base</span>
                </a>
            </li>
            @if ($routeName == "dashboard")
            <li class="menu__list collapse-item">
                <a href="#" class="menu__link collapse-link">
                    <span class="menu__link-icon ico-right-chevron"></span>
                </a>
            </li>
            @endif
        </ul>
        </div>
    </div>
</aside>
<!-- start Modal -->
<div class="modal fade add_recipient video-modal lp-global-opener website-video-modal" data-backdrop="static"  id="website-video-modal" tabindex="-1" role="dialog" aria-labelledby="website-video-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close lp-btn-cancel" data-dismiss="modal"><i class="icon ico-cross"></i></button>
            <div class="modal-header">
                <h5 class="modal-title">leadPops ConversionPro&trade; <span>{{$client_vertical_name}} Marketing Websites</span></h5>
            </div>
            <div class="modal-body">
                <div class="ifram-wrapper">
                    <div class="video">
                        <div class="video__youtube" data-wistia="wistia-video">
                            <img src="{{config('view.rackspace_default_images')}}/videoph-min.png" class="video__placeholder" />
                        </div>
                    </div>
                </div>
                <div class="video-description">
                    {{--<p>{{$my_website_text}}</p>--}}
                </div>
                <div class="description-btn">
                    {{--<button type="button" class="button button-secondary" onclick="window.open('https://book-demo.leadpops.com/', '_blank');">--}}
                    <span class="btn-title-wrap">
                        <span class="btn-title">start here!</span>
                    </span>
                    <button type="button" class="button button-secondary" onclick="window.open('{{$requestDemoLink}}', '_blank');">
                        <span class="btn-text">Book a 1:1 call with a {{$client_vertical_name}} Website Specialist Now!</span>
                        {{--<span class="text">Book your 1:1 consultation with a leadPops Marketing Specialist NOW. </span>--}}
                    </button>
                    <span class="text">Or, Use our <a href="{{$graderWebsiteLink}}" target="_blank"> FREE {{$client_vertical_name}} Website Grader</a> to see how your website stacks up against the competition! </span>
                </div>
            </div>
        </div>
    </div>
</div>

