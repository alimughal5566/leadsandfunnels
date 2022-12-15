@php
    $stickybarVideo = isset($view->data->globalVideos['sticky-bars']) ? $view->data->globalVideos['sticky-bars'] : null;
@endphp
<script id="sticky-popup-html" type="text/template">
    <div id="sticky-popup-wrap" class="sticky-popup-wrap">
        <!-- sticky pop of the page -->
        <div class="sticky-pop">
            <!-- stikcy sidebar of the page -->
            <aside class="sticky-side">
                <form id="sticky-bar-form" method="POST" action="#" name="myForm">

                    <input type="hidden" name="client_leadpops_id" id="client_leadpops_id" value="0">
                    <input type="hidden" name="insert_flag" id="insert_flag" value="">
                    <input type="hidden" name="sticky_status" id="sticky_status" value="0">
                    <input type="hidden" name="pending_flag" id="pending_flag" value="0">
                    <input type="hidden" name="duplicate_url" id="duplicate_url" value="0">
                    <input type="hidden" name="sticky_script_type" id="sticky_script_type" value="a">
                    {{csrf_field()}}

                    <div class="sticky-side__wrap">
                        <div class="sticky-side__holder">
                            <div class="msg" id="msg" style="display: none;">
                                <div class="alert alert-success lp-sticky-bar__alert">
                                    <button type="button" class="sticky-side__close close">×</button>
                                    <strong>Success:</strong> <span class="msg-text">Sticky Bar has been updated.</span>
                                </div>
                            </div>
                            <header class="sticky-side__head">
                                <h1>Sticky Bar Builder<a href="#" data-target="#instrucation-modal" data-toggle="modal" class="sticky-side__instructions"><span class="tooltipster no-bg" data-container="sticky-side__head" data-toggle="tooltip" title="INSTRUCTIONS" data-html="true" data-placement="top"><i class="ico ico-document"></i></span></a></h1>
                                <label class="switcher-checkbox">
                                    <input type="checkbox" id="sticky-activate-btn">
                                    <span class="fake-check">
                                        <span class="inactive-text">inactive</span>
                                        <span class="active-text">active</span>
                                    </span>
                                </label>
                            </header>
                            <hr class="sticky-line">
                            <ul class="sticky-side__list">
                                <li class="sticky-side__list__li">
                                    @if($stickybarVideo && $stickybarVideo->wistia_id)
                                        <a data-lp-wistia-title="{{$stickybarVideo->title}}" data-lp-wistia-key="{{$stickybarVideo->wistia_id}}"  class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                            <i class="ico ico-video"></i>WATCH HOW-TO VIDEO</a>
                                    @else
                                        <a href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="ico ico-video"></i>how-to video</a>
                                    @endif
                                </li>
                            </ul>
                            <hr class="sticky-line">
                        </div>
                        <div class="owl-carousel">
                            <div class="slide">
                                <div class="scroll-holder">
                                    <div class="sticky-side__holder">
                                        <div class="sticky-side__field-wrap sticky-cta-text-wrap">
                                            <label for="sticky-text">What should your Sticky Bar say? </label>
                                            <div class="sticky-side__field">
                                                <input type="text" id="sticky-text" name="bar_title" class="form-control" value="Want to buy a home in a rural area for $0 down? A USDA loan can help">
                                            </div>
                                            <span class="error-message">This field is required</span>
                                        </div>
                                        <hr class="sticky-line">
                                        <div class="checker-number-wrap">
                                            <span class="checkbox-number">
                                                <label>
                                                    <input type="checkbox" id="phone-number_checker" name="cta_phone_number_checker">
                                                    <span class="fake-label">
                                                        <i class="icon"></i>
                                                        Phone Number
                                                    </span>
                                                </label>
                                            </span>
                                            <div class="number-slide">
                                                <div class="sticky-side__field-wrap">
                                                    <label for="sticky-phone-number">Get a Call or Text
                                                        <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                                            title="When Phone Number is checked, the CTA button becomes a click-to-call/text link to the phone number listed below instead of linking to your Lead Funnel." data-html="true" data-placement="top">
                                                                <i class="ico ico-question"></i>
                                                        </span>
                                                    </label>
                                                    <div class="sticky-side__field">
                                                        <input type="tel" id="sticky-phone-number" name="cta_title_phone_number" class="form-control phone" placeholder="(___) ___-____">
                                                    </div>
                                                    <span class="error-message">This field is required</span>
                                                </div>
                                                <hr class="sticky-line">
                                            </div>
                                            <div class="sticky-side__field-wrap sticky-cta-btn-wrap">
                                                <label for="sticky-btn">What should the CTA button say?</label>
                                                <div class="sticky-side__field">
                                                    <input type="text" id="sticky-btn" name="cta_title" class="form-control" value="See if I'm Eligible!">
                                                </div>
                                                <span class="error-message">This field is required</span>
                                            </div>
                                        </div>
                                        <hr class="sticky-line">
                                        <div class="sticky-side__field-wrap sticky-wesbite-url">
                                            <label for="url">What URL do you want to put the Sticky Bar on?</label>
                                            <div class="sticky-side__field">
                                                <label class="url" for="url"><i class="ico-link"></i></label>
                                                <div class="sticky-side__field">
                                                    <label class="url" for="url"><i class="ico-link"></i></label>
                                                    <input type="text" id="url" name="cta_url" class="form-control input-url" value="" placeholder="ex. https://xyzwebsite.com">
                                                    <i class="ico-cross sticky-url-ico" aria-hidden="true"></i>
                                                    <button id="sticky-website-preview-btn" class="sticky-website-preview-btn" aria-label="show preview button">Show Preview</button>
                                                </div>
                                                <span class="error-message">This field is required</span>
                                            </div>
                                        </div>
                                        <hr class="sticky-line">
                                        <div class="switcher-area">
                                            <ul class="sb-list-radio radio-switcher">
                                                <li class="sb-list-radio__li">
                                                    <label class="radio-label">
                                                        <input type="radio" id="all-pages-flag" name="pages_flag" value="1" checked>
                                                        <span class="fake-radio"><i class="icon"></i>Entire Website</span>
                                                    </label>
                                                </li>
                                                <li class="sb-list-radio__li">
                                                    <label class="radio-label">
                                                        <input type="radio" name="pages_flag" id="specific-pages-option" value="0">
                                                        <span class="fake-radio"><i class="icon"></i>Specific URL(s)</span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <div class="slide">
                                                <div class="switcher-area__wrap">
                                                    <a href="#" class="switcher__link">add url path</a>
                                                    <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                                        title="Add URL Path" data-html="true" data-placement="top"
                                                        data-tooltip-html-content-id="sticky-url-path-tooltip-template"
                                                        data-tooltip-css-class="sticky-url-path-tooltip-class">
                                                    <i class="ico ico-question"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="sticky-line">
                                        <div class="sticky-side__field-wrap sticky-advanced-fields-wrap p-0">
                                            <div class="setting-open-close">
                                                <a href="#" class="setting-open-close__opener">Advanced Settings</a>
                                                <div class="setting-open-close__slide">
                                                    <div class="advance-info">
                                                        <strong class="advance-info__title">Pin to:</strong>
                                                        <ul class="sb-list-radio radio-switcher">
                                                            <li class="sb-list-radio__li">
                                                                <label class="radio-label">
                                                                    <input type="radio" name="pin_flag" value="t" class="sticky-position-handler" checked>
                                                                    <span class="fake-radio"><i class="icon"></i>Top</span>
                                                                </label>
                                                            </li>
                                                            <li class="sb-list-radio__li">
                                                                <label class="radio-label">
                                                                    <input type="radio" name="pin_flag" value="b" class="sticky-position-handler" id="sticky-position-bottom-option">
                                                                    <span class="fake-radio"><i class="icon"></i>Bottom</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <hr class="sticky-line">
                                                    <div class="advance-info">
                                                        <strong class="advance-info__title">Size:</strong>
                                                        <ul class="sb-list-radio radio-switcher">
                                                            <li class="sb-list-radio__li">
                                                                <label class="radio-label">
                                                                    <input type="radio" name="size" value="f" class="sticky-size-handler" checked>
                                                                    <span class="fake-radio"><i class="icon"></i>Full</span>
                                                                </label>
                                                            </li>
                                                            <li class="sb-list-radio__li">
                                                                <label class="radio-label">
                                                                    <input type="radio" name="size" value="m" class="sticky-size-handler">
                                                                    <span class="fake-radio"><i class="icon"></i>Medium</span>
                                                                </label>
                                                            </li>
                                                            <li class="sb-list-radio__li">
                                                                <label class="radio-label">
                                                                    <input type="radio" name="size" value="s" class="sticky-size-handler">
                                                                    <span class="fake-radio"><i class="icon"></i>Slim</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <hr class="sticky-line">
                                                    <div class="advance-info">
                                                        <strong class="advance-info__title">Show "Hide" Option (X):</strong>
                                                        <ul class="sb-list-radio radio-switcher">
                                                            <li class="sb-list-radio__li">
                                                                <label class="radio-label">
                                                                    <input type="radio" name="cta_icon" value="0" id="sticky-close-toggle_hide" class="sticky-close-toggle" checked>
                                                                    <span class="fake-radio"><i class="icon"></i>No</span>
                                                                </label>
                                                            </li>
                                                            <li class="sb-list-radio__li">
                                                                <label class="radio-label">
                                                                    <input type="radio" name="cta_icon" value="1" id="sticky-close-toggle_show" class="sticky-close-toggle">
                                                                    <span class="fake-radio"><i class="icon"></i>Yes</span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <hr class="sticky-line">
                                                    <div class="setting-open-close__wrap">
                                                        <span class="title">Stack Order
                                                            <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                                                title="<p>The Stack Order (z-index) property specifies the stack order of an element. An element with greater stack order is always in front of an element with a lower stack order.</p><p>If you're unsure, leave this setting on ''Default''. If you're using a specific website provider, choose ''Website Provider'' and select the correct option from the drop down menu.</p>" data-html="true" data-placement="top">
                                                                    <i class="ico ico-question"></i>
                                                            </span>
                                                        </span>

                                                        <div class="inner-slide-area">
                                                            <ul class="sb-list-radio sb-radio-options">
                                                                <li class="sb-list-radio__li">
                                                                    <label class="radio-label">
                                                                        <input type="radio" name="zindex_type" value="1" checked data-title="sticky-default">
                                                                        <span class="fake-radio"><i class="icon"></i>Default</span>
                                                                    </label>
                                                                </li>
                                                                <li class="sb-list-radio__li">
                                                                    <label class="radio-label">
                                                                        <input type="radio" name="zindex_type" value="2" data-title="sticky-custom">
                                                                        <span class="fake-radio"><i class="icon"></i>Custom</span>
                                                                    </label>
                                                                </li>
                                                                <li class="sb-list-radio__li">
                                                                    <label class="radio-label">
                                                                        <input type="radio" name="zindex_type" value="3" data-title="sticky-website">
                                                                        <span class="fake-radio"><i class="icon"></i>Website Provider</span>
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                            <input id="zindex" type="hidden" name="zindex" value="1000000">
                                                            <div class="tab-content">
                                                                <div id="sticky-default" class="list-tab-item"></div>
                                                                <div id="sticky-custom" class="list-tab-item">
                                                                    <div class="range-slider-wrap">
                                                                        <input id="ex1" data-slider-id="ex1Slider" type="text" data-slider-min="0" data-slider-max="1000000" value="1000000">
                                                                        <div id="slider-val"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="sticky-website" class="list-tab-item">
                                                                    <div class="select-holder funnel-type select-parent1 provider-select-parent">
                                                                        <select class="select-default1" id="sticky-website-zindex">
                                                                            <option value="1">Select One</option>
                                                                            <option value="1000">Boomtown</option>
                                                                            <option value="1001">Commissions Inc. (CINC)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="sticky-line">
                                        <div class="sticky-side__field-wrap">
                                            <label for="site">Where should the button link to?
                                                <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                                      title="The Funnel URL below is where we'll take users that click your CTA button." data-html="true" data-placement="top">
                                                    <i class="ico ico-question"></i>
                                                </span>
                                            </label>
                                            <input type="text" id="site" name="sticky_bar_url" class="form-control" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="sticky-side__holder">
                                    <hr class="sticky-line">
                                    <ul class="list-btns">
                                        <li class="list-btns__li"><a href="#" class="button button-cancel sticky-close-btn">close</a></li>
                                        <li class="list-btns__li"><a href="#" class="button button-primary owl__btn-next">Save &amp; Continue</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="slide">
                                <div class="scroll-holder">
                                    <div class="sticky-side__holder">
                                        <div class="lp-code-block">
                                            <h2 class="lp-code-block__h2">OK, now give me the code!</h2>
                                            <p class="lp-sticky-bar__p">To install the Sticky Bar, copy and paste the following code from below right before your closing &lt;/body> tag </p>
                                            <div class="copy-code" id="code-block">
                                                &lt;!---------leadPops Sticky Bar Code Starts Here---------><br ><br >
                                                &lt;sript type=”text/javascript” src=”{!! env('STICKY_BAR_SCRIPT_DOMAIN','https://embed.clix.ly') !!}/c475a0c0ebf80d88ac.js”> &lt;/script><br ><br >
                                                &lt;!---------leadPops Sticky Bar Code Ends Here--------->
                                            </div>
                                            <hr class="sticky-line">
                                            <div class="code-switcher">
                                                <span class="copy-code__title">View Code without Script Tags </span>
                                                <label class="switcher-checkbox check-switcher">
                                                    <input type="checkbox" id="sticky-script-type-checkbox">
                                                    <span class="fake-check">
                                                        <span class="inactive-text">off</span>
                                                        <span class="active-text">on</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sticky-side__holder">
                                    <hr class="sticky-line">
                                    <div class="d-flex align-items-center justify-content-between lp-sticky__footer-btns">
                                        <a href="#" class="lp-sticky__btn-back">go back</a>
                                        <ul class="list-btns pt-0">
                                            <li class="list-btns__li"><a href="#" class="button button-cancel sticky-close-btn">close</a></li>
                                            <li class="list-btns__li"><a href="#" class="button button-primary btn-copy">COPY TO CLIPBOARD</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="url-slide">
                        <div class="url-slide__wrap">
                            <div class="url-slide__detail">
                                <strong class="title">Sticky Bar Builder
                                    <span class="sub-text">(Add URL Path)</span>
                                    <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                        title="Add Url Path" data-html="true" data-placement="top"
                                        data-tooltip-html-content-id="sticky-url-path-tooltip-template"
                                        data-tooltip-css-class="sticky-url-path-tooltip-class">
                                                <i class="ico ico-question"></i>
                                        </span>
                                </strong>
                                <div class="website-checkbox-wrap">
                                    <span class="checkbox-website">
                                        <label>
                                            <input type="checkbox" id="sticky-homepage-path-checkbox" name="pages[]" value="/">
                                            <span class="fake-label">
                                                <i class="icon"></i>
                                                <span id="sticky-url-popup-website">www.mywebsite.com</span> <span class="sub">(homepage)</span>
                                            </span>
                                        </label>
                                    </span>
                                </div>
                                <div class="url-fields-wrap">
                                </div>
                                <div class="btn-wrap">
                                    <a href="#" class="button add-url-btn">Add new path</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between lp-sticky__footer-btns">
                                    <a href="#" class="lp-sticky__btn-back back-url">go back</a>
                                    <ul class="list-btns pt-0">
                                        <li class="list-btns__li"><a href="#" class="button button-primary sticky-submit-btn">Save</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aside-loader">
                        <div class="lp-sticky-bar__loader">
                            <div class="lp-sticky-bar__loader__wrap">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                <div class="lp-sticky-bar__text-loader" id="loader-text">LOADING... </div>
                            </div>
                        </div>
                    </div>
                </form>
            </aside>
            <div class="sticky-content">
                <div class="sticky-bar">
                    <p class="sticky-bar__p" id="sticky-bar__p">Want to buy a home in a rural area for $0 down? A USDA loan can help!</p>
                    <a href="#" class="button button-primary" id="sticky-bar__btn">See if I'm Eligible!</a>
                    <a href="#" class="sticky-bar__close"><i class="fa fa-times"></i></a>
                </div>
                <div class="preview-area">
                    <div class="lp-sticky-bar__loader">
                        <div class="lp-sticky-bar__loader__wrap">
                            <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            <i class="ico-cross" aria-hidden="true"></i>
                            <div class="lp-sticky-bar__text-loader" id="loader-text">ADD URL TO SEE PREVIEW... </div>
                        </div>
                    </div>
                    <div id="sticky-url-screenshot-wrap"class="lp-sb__image">
                    </div>
                </div>
            </div>
        </div>
        <!-- Instruction Modal -->
        <div class="modal fade instrucation-modal" data-backdrop="static"  id="instrucation-modal" tabindex="-1" role="dialog" aria-labelledby="instrucation-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="ico-cross"></i>
                    </button>
                    <div class="modal-body instrucation-body-scroll">
                        <div class="modal-body-wrap">
                        <strong class="modal-body__heading">leadPops Sticky Bar Installation&nbsp;Instructions</strong>
                        <div class="modal-body__text-area">
                            <strong class="modal-body__title">Entire Website:</strong>
                            <ol>
                                <li>If desired, customize the field for, “What should your Sticky Bar&nbsp;say?”</li>
                                <li>If desired, customize the field for, “What should the CTA button&nbsp;say?”</li>
                                <li>Enter the website URL you want to place the Sticky Bar&nbsp;on.</li>
                                <li>Flip the toggle switch to “Active” then click “Save&nbsp;&&nbsp;Continue”</li>
                                <li>Click “Copy to&nbsp;Clipboard”</li>
                                <li>Install the code right before your closing &lt;/body> tag of the website, or if the website has an area for custom Javascript, add it&nbsp;there.</li>
                            </ol>
                        </div>
                        <div class="modal-body__text-area">
                            <strong class="modal-body__title">Wordpress Example:</strong>
                            <p>Some Wordpress websites have the ability to add custom Javascript that will be added to every page of the website. If that’s an option for your website, paste the code into that&nbsp;area.</p>
                            <p>Many Themes have this option in the “Appearance” section, under “Theme&nbsp;Options”</p>
                            <p>If your Wordpress website does not have that feature, your next option is to add the code to the&nbsp;FOOTER.</p>
                            <p>To customize the Footer on Wordpress, Click “Appearance” then “Widgets”. Your options here may vary. If a footer widget allows you to add HTML code, you can simply paste the code for the Sticky Bar into one of these&nbsp;modules.</p>
                            <p>You may also see an option on your screen that says “Custom HTML”. You can add this widget, name it, and paste the Sticky Bar code into that area and&nbsp;save.</p>
                           {{-- <p>Here’s a video that shows you how this works --<a href="#">Click Here to Watch the Video</a> (coming&nbsp;soon)</p>
                            <p>These instructions are for Wordpress, but this is going to be pretty universal for any website you’re going to be installing the Sticky Bar&nbsp;on.</p>--}}
                        </div>
                        <div class="modal-body__text-area">
                            <strong class="modal-body__title">Specific URL(s):</strong>
                            <ol>
                                <li>If desired, customize the field for, “What should your Sticky Bar&nbsp;say?”</li>
                                <li>If desired, customize the field for, “What should the CTA button&nbsp;say?”</li>
                                <li>Enter the top-level domain of the website you want to place the Sticky Bar&nbsp;on.</li>
                                <li>Click “Add URL Path” -- if you want to include the homepage, check the box at the&nbsp;top.<br>Otherwise, click the “+” button, and copy and paste the URL SLUG into the field (everything after “.com” or “.net”, etc.). Add however many pages you’d like to include by using the “+” button and pasting in additional URL slugs on the same top-level&nbsp;domain.</li>
                                <li>Click “Save” then “Go&nbsp;Back”</li>
                                <li>Flip the toggle switch to “Active” the click “Save&nbsp;&&nbsp;Continue”</li>
                                <li>Click “Copy to&nbsp;Clipboard”</li>
                                <li>Install the code right before your closing tag of the SPECIFIC PAGES of the website you’ve selected to add the Sticky Bar to, or if the website pages have an area for custom Javascript, add it&nbsp;there.</li>
                            </ol>
                        </div>
                        {{--<div class="modal-body__text-area">
                            <p>You can add the same Sticky Bar/Funnel to as many single property websites that you want, as long as they’re on the same top-level domain&nbsp;name.</p>
                            <p>Here’s a video that shows you how this works -- <a href="#">Click Here to Watch the&nbsp;Video</a></p>
                            <p>If you prefer, you can also use a dedicated Sticky Bar/Funnel for each single property&nbsp;website.</p>
                            <p>An example of why you may want to do this if you want to track leads that are coming from a specific SPW and have a dedicated Funnel for each. This also allows you to share leads with specific Realtors (listing agents) vs. all the single property websites sharing the same Sticky Bar and&nbsp;Funnel.</p>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- start Modal -->
    </div>

    <script id="sticky-url-path-tooltip-template" type="text/template">
        <p>Adding URL Paths allows you to place a Sticky Bar on<br>
        SPECIFIC pages of websites.</p>

        <p>A URL path, also known as the "slug," is the portion<br>
        after the ".com" or ".net" (or whatever the domain<br>
        extension is), which takes you to a specific page<br>
        of a website. Example:</p>

        <p>www.yourdomain.com/contact-us</p>

        <p>The "/contact-us" portion is the URL Path,and that's<br>
        what you’d want to add below.</p>

        <p>This would place the Sticky Bar on the Contact Us<br>
        Page of the given website.</p>

        <p>You want to INCLUDE the forward slash  ("/").</p>

        <p>Check the homepage box below if you want your<br>
        Sticky Bar to appear on the homepage in addition<br>
        to specific pages you list URL Paths for.</p>

        <div>You can add as many URL Paths as you’d like.</div>

    </script>
</script>

<!-- ===== Model Boxes - Sticky Bar Dialog - Start ===== -->
<div class="modal fade modal-sticky-bar-switch-dialog" id="modal-sticky-bar-switch-dialog" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title">Alert!</strong>
            </div>
            <div class="modal-body text-center">
                <p class="modal-msg modal-msg_light"><span class="sticky-switch-website"></span> already has an active Sticky Bar. A URL can only have 1 active Sticky Bar.
                    Would you like to go to that Sticky Bar to make&nbsp;edits?</p>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, NEVER MIND</button>
                        </li>
                        <li class="action__item">
                            <a class="button button-primary sticky-switch-btn" href="#" target="_blank">Yes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Sticky Bar Dialog - End ===== -->
