@foreach ($overlaydata as $vdata)
    @php
        $ol_class="lp-ol-".str_replace(' ','-', strtolower($vdata["vertical"]["vertical_name"]));
        $id="lp-ol-".str_replace(' ','-', strtolower($vdata["vertical"]["id"]));
        $v_name=str_replace(' ','-', strtolower($vdata["vertical"]["vertical_name"]));
    @endphp
    <div id="{{ $id }}" class="{{ $ol_class }} overlay_container">
        <!-- fade off-->
        <div class="helper_overlay">

            <a href="#" data-ov-target="{{ $ol_class }}" class="close_btn cl-ovl-pop" id="close_btn"><i class="glyphicon glyphicon-remove lp-ho-cls"></i></a>
            <div class="container">

                <div class="header">
                    <div class="row lp-ov-logo">
                        <div class="col-xs-12 text-center">
                            <img src="{{ LP_BASE_URL.LP_ASSETS_PATH }}/adminimages/ovlogo.png" alt="" class="iconimage">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">

                            <ul class="lp-noteBox">
                                <li class="lp_noteBox__li">
                                    <a class ="lp_noteBox__li pulse" id="lp_noteBox__li" href="#">
                                        <h2>Click Here for<br/> an Important Message from leadPops</h2>
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <div class="col-sm-8">
                            <h3 class="header__h3">Fast Track to Success with</h3>
                            <h2 class="header__h2">leadPops Funnels</h2>
                        </div>
                    </div>
                </div>
                <div id="msgNote" class="modal msgNote" role="dialog">
                    <a href="#" data-dismiss="modal" class="close_btn cl-ovl-pop" id="close_btn"><i class="glyphicon glyphicon-remove lp-ho-cls"></i></a>
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-body">
                                <p class="msgNote__p">
                                    <strong>An Important Message from leadPops</strong><br/><br/>
                                    First and foremost, thanks for being a leadPops client.<br/><br/>
                                    The tools and strategies we share are meant to help increase your leads, sales, and efficiency<br/> in your business and marketing efforts.<br/><br/>
                                    A consistent lead flow is crucial for anyone in sales, but knowing where to start and setting<br/> up the right systems is a big challenge.<br/><br/>
                                    leadPops is here to help you overcome it.<br/><br/>
                                    Insider marketing knowledge is available throughout this admin, including the <strong>Training Library</strong><br/>and <strong>Marketing Hub…</strong><br/><br/>
                                    PLUS the ability for you to <strong>schedule a 1:1 call</strong> with a highly-knowledgeable marketing<br/> coach any time.<br/><br/>
                                    For tools, we give you immediate access to: Funnels, ConversionPro Marketing Websites,<br/>
                                    Email Fire, PagePops, and tech support.<br/><br/>
                                    <strong>Funnels are your secret weapon.</strong><br/><br/>
                                    Without Funnels, nothing else really works as it should in terms of your marketing ROI.<br/><br/>
                                    Putting time and effort into promoting your business without an effective mouse trap is like<br/>
                                    setting your money on fire.<br/><br/>
                                    That's why ALL the big companies, like:<br/><br/>
                                    Zillow, Trulia, Realtor.com, Bankrate, LowerMyBills, QuoteWizard, QuoteLab, and<br/>
                                    COUNTLESS other juggernauts in the marketing/lead generation space...<br/><br/>
                                    Spend EVERY advertising dollar they have driving audiences to their Funnels.<br/><br/>
                                    They NEVER just use a bunch of stuff to read, or a "contact me" form asking for name,<br/>
                                    email, and phone number, as their lead generation approach...<br/><br/>
                                    <strong>Funnels are a LOT smarter than that.</strong><br/><br/>
                                    Funnels know certain questions scare people away, while others invite them in.<br/><br/>
                                    Funnels know there's a way to present messaging on the page; a way to ask for key<br/>
                                    information...<br/><br/>
                                    A way to welcome your potential clients—make them feel comfortable, and actually have<br/>
                                    fun in the process of connecting with you.<br/><br/>
                                    And that's how Funnels were created.<br/><br/>
                                    Our Funnel question and answer selections are based on feedback from experts within the<br/>
                                    industries we work in—Mortgage, Real Estate, and Insurance.<br/><br/>
                                    <strong>We have also tested different formats and variations of our Funnels.</strong><br/><br/>
                                    The number of questions we ask; the order of questions asked...<br/><br/>
                                    The colors, images, messaging, and much more...<br/><br/>
                                    On MILLIONS of REAL WORLD consumers.<br/><br/>
                                    TENS OF MILLIONS of dollars have been spent marketing our Funnels over the last several<br/>
                                    years.<br/><br/>
                                    We get unparalleled access to REAL data to see what works and what doesn't, and we make<br/>
                                    ongoing improvements to Funnels, resulting in our high-conversion formulas.<br/><br/>
                                    That means you get the lead generation tools you need to start generating business right<br/>
                                    out the gate.<br/><br/>
                                    No need to spend endless hours fiddling with technology, not even knowing whether or not<br/>
                                    you're moving the needle in the right direction.<br/><br/>
                                    So pick a Funnel, copy the URL, and start plugging it in ALL over the web… and repeat.<br/><br/>
                                    Integrate Funnels into your email blasts, blog content, website content, autoresponders,<br/>
                                    monthly e-newsletters, social media posts, Facebook ads, retargeting ads, banners, PPC…<br/><br/>
                                    ANYWHERE and EVERYWHERE  you get traffic.<br/><br/>
                                    And watch as suddenly, you start seeing 2-4X more quality leads every month from the stuff<br/>
                                    you're ALREADY doing.<br/><br/>
                                    --<br/><br/>
                                    Sincerely,<br/><br/>
                                    <img src="{{ LP_BASE_URL.LP_ASSETS_PATH }}/adminimages/sign.png" width="25%" alt="" class="iconimage"><br/>
                                    leadPops.com<br/>
                                    Co-Founder & CEO
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if( isset($vdata["vertical_item"]) && is_array($vdata["vertical_item"]))
                        @foreach ($vdata["vertical_item"] as $index=>$item)
                            <div class="col-md-4 col-sm-6">
                                @php
                                    $item_vertical=$item["vertical_id"];
                                    $item_id=$item["id"];
                                    $checked="";
                                    if(isset($client_train_data["overlay_setting"][$item_vertical])){
                                        if($client_train_data["overlay_setting"][$item_vertical][$item_id]=="1"){
                                            $checked="checked";
                                        }
                                    }
                                @endphp
                                <input {{ $checked }} type="checkbox" name="{{ $item["id"] }}" data-itemid="{{ $item["id"] }}" data-vertical="{{ $item["vertical_id"] }}" data-ov-target="{{ $ol_class }}" class="lp-ovr-tran-vid-{{ $item["id"] }}" id="lp-ovr-tran-vid-tp-{{ $item["id"] }}" data-verticalname="{{ $v_name }}" value="">
                                <label id="ebd-1-label" for="lp-ovr-tran-vid-tp-{{ $item["id"] }}"></label>

                                <div class="item_box text-center">
                                    <div class="lp-helper-img">
                                        <img src="{{ LP_BASE_URL.LP_ASSETS_PATH }}/adminimages/{{ $item["icon_name"] }}">
                                    </div>
                                    <h3 class="lp-ovr-tran-vid-{{ $item["id"] }}">{!! $item["item_name"] !!}</h3>
                                    <p>{{ $item["short_description"]}}</p>
                                    <div class="read-more">
                                        <a data-ov-target="{{ $ol_class }}" data-verticalname="{{ $v_name }}" data-verticalid="{{ $item["vertical_id"] }}" data-verticaltar="{{ "ver".$item["vertical_id"] }}"  data-ovid="{{ $index }}" href="#" class="lp_read_more" >Learn More</a>
                                    </div>


                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="cta_container">
                    <div class="lp_helper_btn">
                        @if(@$vdata["vertical_cta"])
                            @foreach ($vdata["vertical_cta"] as $cta)
                            <div class="row cta-desc">
                                <div class="col-md-12 text-center">
                                    <a href="{{ $cta["cta_url"] }}" class="leadpops_helper_btn text-center" target="{{ $cta["cta_target"] }}">{{ $cta["cta_name"] }}</a>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                @if(LP_Helper::getInstance()->getOverlayFlagVal()==1)
                    <div class="row" id="lp-helper-close">
                        <div class="col-xs-12 text-center">
                            <a href="#" class="footer_close_link">Close this screen and don’t see it again on login</a>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <div class="helper_popup hidden">
            <a href="#" data-ov-target="{{ $ol_class }}" class="close_btn v_2 cl-ovl-pop"><i class="glyphicon glyphicon-remove lp-ho-cls"></i></a>
            <div class="helper_popup_border">
                <div class="helper_popup_content">
                    <div class="left_column">
                        <a href="#" class="btn btn-default sidebar_toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
                        <div class="left_column_scrollbar">
                            <div class="helper_sidebar helper_overlay_detail">
                                <div class="sidebar_header">
                                    <h3>Fast Track to Success With</h3>
                                    <h2>leadPops Funnels</h2>
                                </div>
                                <ul >
                                    @php
                                        if(isset($vdata["vertical_item"]) && is_array($vdata["vertical_item"])){
                                        $x = 0;
                                        foreach ($vdata["vertical_item"] as $index=>$item){ @endphp
                                    <li class="list" data-verticalname="{{ $v_name }}" data-verticalid="{{ $item["vertical_id"] }}" data-ovid="{{ $index }}">
                                        @php
                                            $item_vertical=$item["vertical_id"];
                                            $item_id=$item["id"];
                                            $checked="";
                                            if(isset($client_train_data["overlay_setting"][$item_vertical])){
                                            if($client_train_data["overlay_setting"][$item_vertical][$item_id]=="1"){
                                            $checked="checked";
                                            }
                                            }
                                        @endphp
                                        <input {{ $checked }} type="checkbox" name="{{ $item["id"] }}" data-itemid="{{ $item["id"] }}" data-vertical="{{ $item["vertical_id"] }}" class="lp-ovr-tran-vid-{{ $item["id"] }}" id="lp-ovr-tran-vid-bt-{{ $item["id"] }}" data-verticalname="{{ $v_name }}" value="">
                                        <label id="ebd-1-label" for="lp-ovr-tran-vid-bt-{{ $item["id"] }}"></label>
                                        <a data-lp-wistia-title="{{ $item["title"] }}" data-lp-wistia-key="{{ $item["wistia_id"] }}"  data-ov-target="{{ $ol_class }}" data-verticalname="{{ $v_name }}" data-verticalid="{{ $item["vertical_id"] }}" data-ovid="{{ $index }}" href="#" class="leadpops_helper_btn transparent learn " id="listitem{{ $index }}"><span>{{ $x+1 }}.</span>
                                            <span>
                                                @php
                                                    //echo preg_replace('/\<br(\s*)?\/?\>/i', "\n", $item["item_name"]);
                                                    echo $item["item_name"];
                                                @endphp
                                            </span>
                                        </a></li>
                                    @php
                                        $x ++;
                                        }
                                    @endphp
                                    @php } @endphp
                                </ul>
                                <div class="sidebar_footer">
                                    <h3>{!! $vdata["vertical"]["summary_title"]  !!} </h3>
                                    <p>{!!  $vdata["vertical"]["summary"] !!} </p>
                                    <a target="_blank" href="{{ $vdata["vertical"]["cta_url"] }}" class="leadpops_helper_btn green">{{ $vdata["vertical"]["cta_title"] }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_column">
                        <div class="right-section">
                            <div class="lp-row">
                                <span class="sr_no"></span><h2 class="heading lp-overlay-heading"></h2>

                            </div>
                            <!--                            <span class="sr_no"></span><span></span><h2 class="heading"></h2>-->
                            <div class="iframe_container"></div>
                            <div class="description"></div>
                            <p class="lp_navigation_btn"><a data-itemid="" data-vertical="" class="accordian lp-ol-nav-btn"  data-ov-target="{{ $ol_class }}"  href="#" class="leadpops_helper_btn accordian">Complete this module and continue to the next <i class="glyphicon glyphicon-arrow-right"></i></a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endforeach

