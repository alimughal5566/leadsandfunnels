<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
    <!-- sticky pop of the page -->
    <div class="sticky-pop">
        <!-- stikcy sidebar of the page -->
        <aside class="sticky-side">
            <div class="sticky-side__wrap">
                <div class="sticky-side__holder">
                    <div class="msg" id="msg" style="display: none;">
                        <div class="alert alert-success lp-sticky-bar__alert">
                            <button type="button" class="sticky-side__close close">×</button>
                            <strong>Success! </strong><span class="msg-text">Sticky Bar has been updated.</span>
                        </div>
                    </div>
                    <header class="sticky-side__head">
                        <h1>Sticky Bar Builder<a href="#" data-target="#instrucation-modal" data-toggle="modal" class="sticky-side__instructions"><span class="tooltipster no-bg" data-container="sticky-side__head" data-toggle="tooltip" title="INSTRUCTIONS" data-html="true" data-placement="top"><i class="ico ico-document"></i></span></a></h1>
                        <label class="switcher-checkbox">
                            <input type="checkbox">
                            <span class="fake-check">
                                <span class="inactive-text">inactive</span>
                                <span class="active-text">active</span>
                            </span>
                        </label>
                    </header>
                    <hr class="sticky-line">
                    <ul class="sticky-side__list">
                        <li class="sticky-side__list__li">
                            <a data-lp-wistia-title="Sticky Bar Builder" data-lp-wistia-key="tb54at5r97" class="sticky-side__list__link video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal"><i class="ico ico-video"></i>how-to video</a>
                        </li>
                    </ul>
                    <hr class="sticky-line">
                </div>
                <div class="owl-carousel">
                    <div class="slide">
                        <div class="scroll-holder">
                            <div class="sticky-side__holder">
                                <div class="sticky-side__field-wrap">
                                    <label for="sticky-text">What should your Sticky Bar say? </label>
                                    <div class="sticky-side__field">
                                        <input type="text" id="sticky-text" class="form-control" value="Want to buy a home in a rural area for $0 down? A USDA loan can help">
                                    </div>
                                </div>
                                <hr class="sticky-line">
                                <div class="checker-number-wrap">
                                    <span class="checkbox-number">
                                        <label>
                                            <input type="checkbox">
                                            <span class="fake-label">
                                                <i class="icon"></i>
                                                Phone Number
                                            </span>
                                        </label>
                                    </span>
                                    <div class="number-slide">
                                        <div class="sticky-side__field-wrap">
                                            <label for="tel01">Get a Call or Text
                                                <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                                      title="When Phone Number is checked, the CTA button becomes a click-to-call/text link to the phone number listed below instead of linking to your Lead Funnel." data-html="true" data-placement="top">
                                                          <i class="ico ico-question"></i>
                                                  </span>
                                            </label>
                                            <div class="sticky-side__field">
                                                <input type="tel" id="tel01" class="form-control phone" placeholder="(___) ___-____">
                                            </div>
                                        </div>
                                        <hr class="sticky-line">
                                    </div>
                                    <div class="sticky-side__field-wrap">
                                        <label for="sticky-btn">What should the CTA button say?</label>
                                        <div class="sticky-side__field">
                                            <input type="text" id="sticky-btn" class="form-control" value="See if I'm Eligible!">
                                        </div>
                                    </div>
                                </div>
                                <hr class="sticky-line">
                                <div class="sticky-side__field-wrap">
                                    <label for="url">What URL do you want to put the Sticky Bar on?</label>
                                    <div class="sticky-side__field">
                                        <label class="url" for="url"><i class="ico-link"></i></label>
                                        <div class="sticky-side__field">
                                            <label class="url" for="url"><i class="ico-link"></i></label>
                                            <input type="text" id="url" class="form-control input-url" value="">
                                        </div>
                                    </div>
                                </div>
                                <hr class="sticky-line">
                                <div class="switcher-area">
                                    <ul class="sb-list-radio radio-switcher">
                                        <li class="sb-list-radio__li">
                                            <label class="radio-label">
                                                <input type="radio" name="web-radio" checked>
                                                <span class="fake-radio"><i class="icon"></i>Entire Website</span>
                                            </label>
                                        </li>
                                        <li class="sb-list-radio__li">
                                            <label class="radio-label">
                                                <input type="radio" name="web-radio">
                                                <span class="fake-radio"><i class="icon"></i>Specific URL(s)</span>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="slide">
                                        <div class="switcher-area__wrap">
                                            <a href="#" class="switcher__link">add url path</a>
                                            <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                                  title="Add URL Path" data-html="true" data-placement="top">
                                            <i class="ico ico-question"></i>
                                             </span>
                                        </div>
                                    </div>
                                </div>
                                <hr class="sticky-line">
                                <div class="sticky-side__field-wrap p-0">
                                    <div class="setting-open-close">
                                        <a href="#" class="setting-open-close__opener">Advanced Settings</a>
                                        <div class="setting-open-close__slide">
                                            <div class="advance-info">
                                                <strong class="advance-info__title">Pin to:</strong>
                                                <ul class="sb-list-radio radio-switcher pb-0">
                                                    <li class="sb-list-radio__li">
                                                        <label class="radio-label">
                                                            <input type="radio" name="web-radio03" class="sticky-position-handler" checked>
                                                            <span class="fake-radio"><i class="icon"></i>Top</span>
                                                        </label>
                                                    </li>
                                                    <li class="sb-list-radio__li">
                                                        <label class="radio-label">
                                                            <input type="radio" name="web-radio03" class="sticky-position-handler bottom-controller">
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
                                                            <input type="radio" name="web-radio01" value="f" class="sticky-size-handler" checked>
                                                            <span class="fake-radio"><i class="icon"></i>Full</span>
                                                        </label>
                                                    </li>
                                                    <li class="sb-list-radio__li">
                                                        <label class="radio-label">
                                                            <input type="radio" name="web-radio01" value="m" class="sticky-size-handler">
                                                            <span class="fake-radio"><i class="icon"></i>Medium</span>
                                                        </label>
                                                    </li>
                                                    <li class="sb-list-radio__li">
                                                        <label class="radio-label">
                                                            <input type="radio" name="web-radio01" value="s" class="sticky-size-handler">
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
                                                            <input type="radio" name="web-radio02" class="sticky-close-toggle">
                                                            <span class="fake-radio"><i class="icon"></i>No</span>
                                                        </label>
                                                    </li>
                                                    <li class="sb-list-radio__li">
                                                        <label class="radio-label">
                                                            <input type="radio" name="web-radio02" class="sticky-close-toggle" checked>
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
                                                                <input type="radio" name="settings-radio" checked data-title="default">
                                                                <span class="fake-radio"><i class="icon"></i>Default</span>
                                                            </label>
                                                        </li>
                                                        <li class="sb-list-radio__li">
                                                            <label class="radio-label">
                                                                <input type="radio" name="settings-radio" data-title="custom">
                                                                <span class="fake-radio"><i class="icon"></i>Custom</span>
                                                            </label>
                                                        </li>
                                                        <li class="sb-list-radio__li">
                                                            <label class="radio-label">
                                                                <input type="radio" name="settings-radio" data-title="website">
                                                                <span class="fake-radio"><i class="icon"></i>Website Provider</span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div id="default" class="list-tab-item"></div>
                                                        <div id="custom" class="list-tab-item">
                                                            <div class="range-slider-wrap">
                                                                <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="400"/>
                                                                <div id="slider-val"></div>
                                                            </div>
                                                        </div>
                                                        <div id="website" class="list-tab-item">
                                                            <div class="select-holder funnel-type select-parent1 provider-select-parent">
                                                                <select class="select-default1" id="provider-select">
                                                                    <option>Select One</option>
                                                                    <option>Boomtown</option>
                                                                    <option>Commissions Inc. (CINC)</option>
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
                                    <input type="text" id="site" class="form-control" value="conv-hybrid-7000.secure-clix.com" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="sticky-side__holder">
                            <hr class="sticky-line">
                            <ul class="list-btns">
                                <li class="list-btns__li"><a href="#" class="button button-cancel">close</a></li>
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
                                        &lt;sript type=”text/javascript” src=”https://dev2itclix.com/c475a0c0ebf80d88ac.js”> &lt;/script><br ><br >
                                        &lt;!---------leadPops Sticky Bar Code Ends Here--------->
                                    </div>
                                    <hr class="sticky-line">
                                    <div class="code-switcher">
                                        <span class="copy-code__title">View code without script tags </span>
                                        <label class="switcher-checkbox check-switcher">
                                            <input type="checkbox">
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
                                    <li class="list-btns__li"><a href="#" class="button button-cancel">close</a></li>
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
                            <span class="sub-text">(Add Url Path)</span>
                            <span class="tooltipster sticky-tooltip" data-container="body" data-toggle="tooltip"
                                  title="Add Url Path" data-html="true" data-placement="top">
                                        <i class="ico ico-question"></i>
                                </span>
                        </strong>
                        <div class="website-checkbox-wrap">
                            <span class="checkbox-website">
                                <label>
                                    <input type="checkbox">
                                    <span class="fake-label">
                                        <i class="icon"></i>
                                        www.mywebsite.com <span class="sub">(homepage)</span>
                                    </span>
                                </label>
                            </span>
                        </div>
                        <div class="url-fields-wrap">
                            <div class="url-add-field">
                                <div class="field">
                                    <label for="url03"><i class="ico-link"></i></label>
                                    <input id="url03" class="form-control input-url-path" type="text" placeholder="/url-path-goes-here">
                                    <a href="#" class="close-field"><i class="ico-cross"></i></a>
                                    <span class="error-message">Please Enter a valid Path</span>
                                </div>
                                <div class="url-message">
                                    <span class="text">Are you sure you want to delete this path?</span>
                                    <ul class="url-option">
                                        <li><a href="#" class="remove-url">YES</a></li>
                                        <li><a href="#" class="active-url">NO</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <a href="#" class="button add-url-btn">Add new path</a>
                        </div>
                        <div class="d-flex align-items-center justify-content-between lp-sticky__footer-btns">
                            <a href="#" class="lp-sticky__btn-back back-url">go back</a>
                            <ul class="list-btns pt-0">
                                <li class="list-btns__li"><a href="#" class="button button-cancel">close</a></li>
                                <li class="list-btns__li"><a href="#" class="button button-primary">Save &amp; Continue</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="aside-loader">
                <div class="lp-sticky-bar__loader">
                    <div class="lp-sticky-bar__loader__wrap">
                        <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        <div class="lp-sticky-bar__text-loader">LOADING... </div>
                    </div>
                </div>
            </div>
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
                        <div class="lp-sticky-bar__text-loader" id="loader-text">ADD URL TO SEE PREVIEW... </div>
                    </div>
                </div>
                <div class="lp-sb__image">
                    <img src="assets/images/iframe-fullpage-funnels.png" alt="funnels">
                </div>
            </div>
        </div>
    </div>
    <!-- contain the main content of the page -->
    <div id="content">
        <!-- header of the page -->
        <?php
        include ("includes/header.php");
        ?>
        <!-- contain main informative part of the site -->
        <!-- content of the page -->
        <main class="main">
            <section class="main-content">

            </section>
        </main>
    </div>
<?php
include ("includes/global-settings/modals-global-setting.php");
include ("includes/footer.php");
?>