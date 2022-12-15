<div class="lp-sticky-bar">
    <div ng-app="myApp" ng-controller="myCtrl">

        <div class="lp-sticky-bar__wrapper">
            <div class="leadpops-wrap">
                <div class="leadpops-left"><p class="cta"></p>
                    <p class="ctalink"><a href="#" id="linkanimation" class="lp-cta-text"></a></p>
                    <a href="#" title="Dismiss" class="sticky-hide"></a>
                </div>
            </div>
            <div class="emply-row"></div>
            <form class="" id="sticky-bar-form" method="POST" action="#" name="myForm">
                {{csrf_field()}}
                <div class="lp-sticky-bar__outer lp-sticky-bar__outer_builder">
                    <div class="lp-sticky-bar__inner">
                        <div class="lp-sticky-bar__modal">
                            <div class="lp-sticky-bar__loader">
                                <div class="lp-sticky-bar__middle"></div>
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </div>
                            <div class="lp-sticky-bar__title">
                                Sticky Bar Builder
                                <div class="lp-sticky-bar__instruction">
                                    <div class="lp_instruction_box">
                                        <i class="lp-instrution-icon"></i>
                                        <span class="watch-video__caption">INSTRUCTIONS</span>
                                    </div>
                                </div>
                            </div>
                            <div class="msg"></div>

                            <ul class="lp-sticky-bar__controller">
                                <li class="lp-sticky-bar__item lp-owl-dot active"><a class="lp-sticky-bar__step_link"
                                                                                     href="#">step1</a></li>
                                <li class="lp-sticky-bar__item lp-owl-dot"><a class="lp-sticky-bar__step_link" href="#">step2</a>
                                </li>
                                <!--                    <li class="lp-sticky-bar__item owl-dot"><a class="lp-sticky-bar__step_link" href="#">step3</a></li>-->
                                <!--                    <li class="lp-sticky-bar__item"><a class="lp-sticky-bar__step_link" href="#">step4</a></li>-->
                                <!--                    <li class="lp-sticky-bar__item"><a class="lp-sticky-bar__step_link" href="#">step5</a></li>-->
                                <li class="custom-btn-toggle lp-sticky-bar__toggle"><input name="sticky_bar_active"
                                                                                           type="checkbox"
                                                                                           id="toggle-status"
                                                                                           data-toggle="toggle"
                                                                                           data-on="INACTIVE"
                                                                                           data-off="ACTIVE"
                                                                                           data-onstyle="success"
                                                                                           data-offstyle="danger"
                                                                                           data-width="60"></li>
                            </ul>
                            <div class="lp-sticky-bar__note">Pending Installation</div>

                            <input type="hidden" name="client_leadpops_id" id="client_leadpops_id" val="">
                            <input type="hidden" name="insert_flag" id="insert_flag">
                            <input type="hidden" name="sticky_status" id="sticky_status">
                            <input type="hidden" name="pending_flag" id="pending_flag">
                            <input type="hidden" name="duplicate_url" id="duplicate_url" value="0">
                            <input type="hidden" name="sticky_script_type" id="sticky_script_type" value="a">
{{csrf_field()}}
                            <div class="owl-carousel">
                                <div class="lp-sticky-bar__block">
                                    <div class="lp-sticky-bar__form-group">

                                        <label class="lp-sticky-bar__caption">What should your Sticky Bar say?</label>
                                        <input type="text" name="bar_title_visible"
                                               class="form-control lp-sticky-bar__form-control bar_title" value=''>
                                        <input type="hidden" value=''  name="bar_title" class="form-control lp-sticky-bar__form-control bar_title bar_title_hidden">
                                    </div>
                                    <div class="lp-sticky-bar__form-group_wrapper">
                                        <div class="phone-number_checker-wrapper">
                                            <input type="checkbox" id="phone-number_checker" name="cta_phone_number_checker">
                                            <label for="phone-number_checker" class="phone-number_checker"><span></span>Phone Number</label>
                                        </div>
                                        <div class="lp-sticky-bar__form-group lp-sticky-bar__form-group_phone-number">
                                            <div class="sticky-small ">
                                                <label class="lp-sticky-bar__caption">Get a Call or Text
                                                    <a href="#" class="sticky-tooltip" data-toggle="tooltip"
                                                       title='<p>When "Phone Number" is checked, the CTA button becomes a click-to-call/text link to the phone number listed below instead of linking to your Lead Funnel.</p>'
                                                       data-html="true" data-placement="right">
                                                        <i class="fa fa-question-circle"></i>
                                                    </a></label>
                                                <input id="cta_title_phone_number" name="cta_title_phone_number" type="tel"
                                                       class="form-control lp-sticky-bar__form-control">
                                            </div>
                                        </div>
                                        <div class="lp-sticky-bar__form-group">
                                            <label class="lp-sticky-bar__caption">What should the CTA button say?</label>
                                            <input id="cta_title" name="cta_title" type="text"
                                                   class="form-control lp-sticky-bar__form-control">
                                        </div>
                                    </div>
                                    <div class="lp-sticky-bar__form-group">
                                        <label class="lp-sticky-bar__caption">What URL do you want to put the Sticky Bar
                                            on?</label>
                                        <input id="cta_url" name="cta_url" type="text"
                                               class="form-control lp-sticky-bar__form-control">
                                    </div>
                                    <div class="lp-sticky-bar__form-group pb15">
                                    <span class="radio-inline pl0">
                                        <input type="radio" class="lp-popup-radio sticky-radio" value="/"
                                               name="pages_flag" id="all_pages" checked/>
                                        <label class="radio-control-label"
                                               for="all_pages"><span></span>Entire Website</label>
                                    </span>
                                        <span class="radio-inline">
                                        <input type="radio" class="lp-popup-radio sticky-radio" value=""
                                               id="specific_pages" name="pages_flag"/>
                                        <label class="radio-control-label" for="specific_pages"><span></span>Specific URL(s)</label>
                                    </span>
                                        <a href="#" class="lp-sticky-bar_page">Add URL Path</a>
                                    </div>
                                    <div class="lp-sticky-bar__form-group pt20" id="advance-option-toggle">
                                        <div class="advance-option">
                                            <label class="lp-sticky-bar__caption">Advanced Settings</label>
                                            <div class="adv-icon">
                                                <a href="#"><i class="fa fa-chevron-down"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="advance-option-box">
                                        <div class="lp-sticky-bar__form-group pb15">
                                            <label class="lp-sticky-bar__caption lp-sticky-bar__caption__inline">Size:</label>
                                            <span class="radio-inline pl0">
                                        <input id="pin_size_full" type="radio" class="lp-popup-radio" value="f"
                                               name="size" checked/>
                                        <label class="radio-control-label" for="pin_size_full"><span></span>Full</label>
                                       </span>
                                            <span class="radio-inline">
                                        <input id="pin_size_medium" type="radio" class="lp-popup-radio" value="m"
                                               name="size"/>
                                        <label class="radio-control-label"
                                               for="pin_size_medium"><span></span>Medium</label>
                                        </span>
                                            <span class="radio-inline">
                                        <input id="pin_size_slim" type="radio" class="lp-popup-radio" value="s"
                                               name="size"/>
                                        <label class="radio-control-label" for="pin_size_slim"><span></span>Slim</label>
                                    </span>
                                        </div>
                                        <div class="lp-sticky-bar__form-group pb15">
                                            <label class="lp-sticky-bar__caption lp-sticky-bar__caption__inline">Show
                                                "Hide" Option (X):</label>
                                            <span class="radio-inline  pl0">
                                            <input id="pin_cta_hide" type="radio" class="lp-popup-radio" value="0"
                                                   name="cta_icon" checked/>
                                            <label class="radio-control-label"
                                                   for="pin_cta_hide"><span></span>No</label>
                                        </span>
                                            <span class="radio-inline">
                                            <input id="pin_cta_show" type="radio" class="lp-popup-radio" value="1"
                                                   name="cta_icon"/>
                                            <label class="radio-control-label"
                                                   for="pin_cta_show"><span></span>Yes</label>
                                        </span>
                                        </div>
                                        <div class="lp-sticky-bar__form-group pb15">
                                            <label class="lp-sticky-bar__caption lp-sticky-bar__caption__inline">Stack
                                                Order
                                                <a href="#" class="sticky-tooltip" data-toggle="tooltip"
                                                   title="<p>The Stack Order (z-index) property specifies the stack order of an element. An element with greater stack order is always in front of an element with a lower stack order.</p><p>If you're unsure, leave this setting on ''Default''. If you're using a specific website provider, choose ''Website Provider'' and select the correct option from the drop down menu.</p>"
                                                   data-html="true" data-placement="right">
                                                    <i class="fa fa-question-circle"></i>
                                                </a> :</label>
                                            <span class="radio-inline pl0">
                                            <input id="zindex-default" type="radio"
                                                   class="lp-popup-radio lp-popup-radio_zindex" value="1"
                                                   name="zindex_type" checked/>
                                            <label class="radio-control-label" for="zindex-default"><span></span>Default</label>
                                        </span>
                                            <span class="radio-inline">
                                            <input id="zindex-custom" type="radio"
                                                   class="lp-popup-radio lp-popup-radio_zindex" value="2"
                                                   name="zindex_type"/>
                                            <label class="radio-control-label"
                                                   for="zindex-custom"><span></span>Custom</label>
                                        </span>
                                            <span class="radio-inline">
                                            <input id="zindex-company" type="radio"
                                                   class="lp-popup-radio lp-popup-radio_zindex" value="3"
                                                   name="zindex_type"/>
                                            <label class="radio-control-label" for="zindex-company"><span></span>Website Provider</label>
                                        </span>
                                            <input id="zindex" type="hidden" name="zindex" value="1000000">
                                        </div>
                                        <div class="lp-sticky-bar__form-group zindex-custom-hide">
                                            <div class="lp-sb-slider-wrapper">
                                                <div class="sticky-bar-slider">
                                                    <input id="bs-slider-bar" type="text" data-slider-tooltip="hide"
                                                           data-slider-min="1"
                                                           data-slider-max="100000" data-slider-step="1000"/>
                                                </div>
                                                <div class="lp-sticky-bar__caption" id="zindex-label">1</div>
                                            </div>
                                        </div>
                                        <div class="lp-sticky-bar__form-group zindex-company-hide">
                                            <div class="zindex-dropdown">
                                                <select class="zindex-company" data-style="form-control select-control"
                                                        name="zindex_company" data-width="100%">
                                                    <option value="">Select One</option>
                                                    <option value="1000">Boomtown</option>
                                                    <option value="1001">Commissions Inc. (CINC)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="lp-sticky-bar__form-group pb15">
                                            <label class="lp-sticky-bar__caption lp-sticky-bar__caption__inline">Pin
                                                to:</label>
                                            <span class="radio-inline pl0">
                                            <input id="pin_flag_top" type="radio" class="lp-popup-radio" value="t"
                                                   name="pin_flag" checked/>
                                            <label class="radio-control-label"
                                                   for="pin_flag_top"><span></span>Top</label>
                                        </span>
                                            <span class="radio-inline">
                                            <input id="pin_flag_bottom" type="radio" class="lp-popup-radio" value="b"
                                                   name="pin_flag"/>
                                            <label class="radio-control-label" for="pin_flag_bottom"><span></span>Bottom</label>
                                        </span>
                                        </div>
                                    </div>

                                    <div class="lp-sticky-bar__form-group">
                                        <label class="lp-sticky-bar__caption">What URL should user go to when they click
                                            your CTA button?</label>
                                        <input name="sticky_bar_url" type="text"
                                               class="form-control lp-sticky-bar__form-control sticky_bar_url" disabled>
                                        <input id="sticky_bar_url" name="sticky_bar_url" type="hidden"
                                               class="form-control lp-sticky-bar__form-control sticky_bar_url">
                                    </div>
                                </div>
                                <div class="lp-sticky-bar__block">
                                    <div class="lp-sticky-bar__message">
                                        OK, now give me the code!
                                    </div>
                                    <p class="lp-sticky-bar__description">To install the Sticky Bar, copy and paste the
                                        following code from below right before your closing &lt;/body> tag </p>
                                    <div class="lp-sticky-bar__code-wrapper">
                                        <div id="copy_code" class="lp-sticky-bar__textarea">
                                            &lt;script type="text/javascript" src="dd">&lt;/script>
                                        </div>
                                        <div class="code-switch">
                                            <label class="switch">
                                                <input id="switch-script" type="checkbox">
                                                <span class="slider round"></span>
                                            </label>
                                            <span class="code-switch__caption">View Code without Script Tags</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="lp-sticky-bar__action">
                                <a href="#" id="prev-sticky-bar" class="lp-sticky-bar_prev">&lt; Go Back</a>
                                <a href="#" id="close-sticky-bar"
                                   class="btn lp-sticky-bar__btn lp-sticky-bar__btn_danger">Close</a>
                                <a href="#" id="continue-sticky-bar" class="btn lp-sticky-bar__btn">Save & Continue</a>
                                <a href="#" id="copy-sticky-bar" class="btn lp-sticky-bar__btn">Copy to clipboard</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="lp-sticky-bar__outer lp-sticky-bar__outer_pages">
                    <div class="lp-sticky-bar__inner">
                        <div class="lp-sticky-bar__modal">
                            <div class="lp-sticky-bar__loader">
                                <div class="lp-sticky-bar__middle"></div>
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </div>
                            <div class="lp-sticky-bar__title">
                                Sticky Bar Builder <span class="lp-sticky-bar__sub-title">(Add Url Path)</span>
                                <div class="lp-sticky-bar__instruction">
                                    <div class="lp_instruction_box">
                                        <i class="lp-instrution-icon"></i>
                                        <span class="watch-video__caption">INSTRUCTIONS</span>
                                    </div>
                                </div>
                            </div>
                            <div class="msg"></div>
                            <div class="lp-sticky-bar__specific-pages">
                                <div class="lp-sticky-bar__form-group pb15">
                                    <input id="sticky-home-page" name="pages[]" value="/" type="checkbox">
                                    <label class="sticky-checkbox-label" for="sticky-home-page"><span
                                                class="lp-checkbox-icon"></span>
                                        <div class="lp-prefix">sit.itclixk.co</div>
                                        (homepage)</label>
                                </div>
                                <div class="lp-sticky-bar__clone-wrap">
                                    <div class="lp-prefix lp-input-prefix">sit.itclixk.co</div>
                                    <div class="add-more">
                                        <a href="#" id="add" class="btn btn-default lp-sticky-bar__copy">+</a>
                                    </div>
                                </div>
                                <div class="lp-sticky-bar__action lp-sticky-bar__action_pt30">
                                    <a href="#" id="close_sticky_page"
                                       class="lp-sticky-bar_prev lp-sticky-bar_page_prev">&lt; Go Back</a>
                                    <a href="#"
                                       class="btn lp-sticky-bar__btn lp-sticky-bar__btn_danger close-sticky-bar_pages">Close</a>
                                    <a href="#" id="save-sticky-bar_page" class="btn lp-sticky-bar__btn">Save</a>
                                </div>
                                <!--                            <a href="#" id="close-sticky-bar_pages" class="btn lp-sticky-bar__btn lp-sticky-bar__btn_danger">Close</a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="copy hidden">
                <div class="lp-sticky-bar__form-group pb15 lp-sticky-bar_clone db_save">
                    <div class="lp-sticky-bar__left">
                        <input type="text" id="pages" name="pages[]" class="form-control lp-sticky-bar__form-control"
                               value=""/>
                        <label id="" class="error sticky-page__error" for="" style="">This field is required.</label>
                    </div>
                    <div class="lp-sticky-bar__right">
                        <div class="lp-sticky-bar__confirmation">
                            <span class="lp-note">Delete Path?</span>
                            <a href="#" class="yes">Yes</a>
                            <a href="#" class="no">No</a>
                        </div>
                        <a href="#" id="remove" class="lp-sticky-bar__remove"><i class="fa fa-remove"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add_recipient video-modal" id="sticky-video-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><span>How To Video:</span></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="ifram-wrapper">
                        <div class="video">
                            @php
                            $thumbnail = LP_ASSETS_PATH . "/adminimages/videoph.png";
                            if (isset($view->data->videothumbnail) && $view->data->videothumbnail != "") {
                                $thumbnail = $view->data->videothumbnail;
                            }
                            @endphp

                            @if (isset($view->data->wistia_id) && $view->data->wistia_id)
                            <div class="video__youtube" data-wistia="wistia-video">
                                <img src="{{ $thumbnail }}" class="video__placeholder"/>
                                <button class="video__button"
                                        data-video-title="@if (isset($view->data->videotitle) && $view->data->videotitle){{ $view->data->videotitle }}@endif"
                                        data-wistia-button="@if (isset($view->data->wistia_id) && $view->data->wistia_id){{ $view->data->wistia_id }}@endif"></button>
                            </div>

                            @elseif (isset($view->data->videolink) && $view->data->videolink)
                            <div class="video__youtube" data-youtube="youtube-video">
                                <img src="{{ $thumbnail }}" class="video__placeholder"/>
                                <button class="video__button"
                                        data-video-title="@if (isset($view->data->videotitle) && $view->data->videotitle){{ $view->data->videotitle }}@endif"
                                        data-youtube-button="@if (isset($view->data->videolink) && $view->data->videolink){{ $view->data->videolink }}@endif"></button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-footer footer-border">
                <a id="close-video-modal" class="btn lp-btn-cancel">Close</a>
            </div>

        </div>
    </div>
</div>

<!--instruction modal-->
<div id="instruction-modal" class="modal msgNote" role="dialog">
    <a href="#" data-dismiss="modal" class="close_btn cl-ovl-pop" id="close_btn"><i
                class="glyphicon glyphicon-remove lp-ho-cls"></i></a>
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="instruction__p">
                    <h1><strong>leadPops Sticky Bar Installation Instructions</strong></h1>
                    <br/>
                    <h4><strong><u>Entire Website:</u></strong></h4>
                    <ol>
                        <li>If desired, customize the field for, “What should your Sticky Bar say?”</li>
                        <li>If desired, customize the field for, “What should the CTA button say?”</li>
                        <li>Enter the website URL you want to place the Sticky Bar on.</li>
                        <li>Flip the toggle switch to “Active” then click “Save & Continue”</li>
                        <li>Click “Copy to Clipboard”</li>
                        <li>Install the code right before your closing &lt/body> tag of the website, or if the website
                            has an area for custom Javascript, add it there.
                        </li>
                    </ol>
                    <hr>
                    <h4><strong><u>Wordpress Example:</u></strong></h4>
                    Some Wordpress websites have the ability to add custom Javascript that will be added to every page
                    of the website. If that’s an option for your website, paste the code into that area.<br/><br/>
                    Many Themes have this option in the “Appearance” section, under “Theme Options”<br/><br/>
                    If your Wordpress website does not have that feature, your next option is to add the code to the
                    FOOTER.<br/><br/>
                    To customize the Footer on Wordpress, Click “Appearance” then “Widgets”. Your options here may vary.
                    If a footer widget allows you to add HTML code, you can simply paste the code for the Sticky Bar
                    into one of these modules.<br/><br/>
                    You may also see an option on your screen that says “Custom HTML”. You can add this widget, name it,
                    and paste the Sticky Bar code into that area and save.<br/><br/>
                    Here’s a video that shows you how this works --<a class="" href="#">Click Here to Watch the
                        Video</a> (coming soon)
                    <br/><br/>
                    These instructions are for Wordpress, but this is going to be pretty universal for any website
                    you’re going to be installing the Sticky Bar on.<br/>
                    <hr>
                    <h4><strong><u>Specific URL(s):</u></strong></h4>
                    <ol>
                        <li>If desired, customize the field for, “What should your Sticky Bar say?”</li>
                        <li>If desired, customize the field for, “What should the CTA button say?”</li>
                        <li>Enter the top-level domain of the website you want to place the Sticky Bar on.</li>
                        <li>Click “Add URL Path” -- if you want to include the homepage, check the box at the top.
                            <br/>
                            Otherwise, click the “+” button, and copy and paste the URL SLUG into the field (everything
                            after “.com” or “.net”, etc.). Add however many pages you’d like to include by using the “+”
                            button and pasting in additional URL slugs on the same top-level domain.
                        </li>
                        <li>Click “Save” then “Go Back”</li>
                        <li>Flip the toggle switch to “Active” the click “Save & Continue”</li>
                        <li>Click “Copy to Clipboard”</li>
                        <li>Install the code right before your closing </body> tag of the SPECIFIC PAGES of the website
                            you’ve selected to add the Sticky Bar to, or if the website pages have an area for custom
                            Javascript, add it there.
                        </li>
                    </ol>
                    <hr>
                    <h4><strong><u>Single Property Websites (Total Expert Example): </u></strong></h4>
                    <ol>
                        <li>Once you’ve customized the Sticky Bar how you want it, Activate it, and enter the top level
                            domain of the Single Property Website
                        </li>
                        <li>Choose “Specific URL(s)” and then “Add URL Path”</li>
                        <li>Click the “+” button then copy and paste the slug of the specific page you want to feature
                            the Sticky Bar on. Click “Save” and then “Go Back”
                        </li>
                        <li>Click “Save & Continue” then on the next step, “Copy to Clipboard”</li>
                        <li>Paste the Javascript code into the “Custom Javascript” area of the single property website
                            and Save.
                        </li>
                    </ol>
                    You can add the same Sticky Bar/Funnel to as many single property websites that you want, as long as
                    they’re on the same top-level domain name.<br/><br/>
                    Here’s a video that shows you how this works -- <a data-lp-wistia-title="Sticky Bar"
                                                                       data-lp-wistia-key="na4pux1gtm"
                                                                       class="btn-video lp-wistia-video" href="#"
                                                                       data-toggle="modal"
                                                                       data-target="#lp-video-modal"><span
                                class="action-title">Click Here to Watch the Video</span></a><br/><br/>
                    If you prefer, you can also use a dedicated Sticky Bar/Funnel for each single property website.<br/><br/>
                    An example of why you may want to do this if you want to track leads that are coming from a specific
                    SPW and have a dedicated Funnel for each. This also allows you to share leads with specific Realtors
                    (listing agents) vs. all the single property websites sharing the same Sticky Bar and
                    Funnel.<br/><br/>
                </div>
            </div>
        </div>
    </div>
</div>


