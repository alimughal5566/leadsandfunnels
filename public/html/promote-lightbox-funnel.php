<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
    <!-- contain the main content of the page -->
    <div  id="content">
        <!-- header of the page -->
        <?php
        include ("includes/header.php");
        ?>
        <!-- contain main informative part of the site -->
        <main class="main">
            <!-- content of the page -->
            <section class="main-content embed-webpage promote-lightbox-section">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Open in Lightbox / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Open in Lightbox" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span> Watch how to video</a>
                    </div>
                </div>
                <!-- content of the page -->
                <div class="lp-panel lp-panel_tabs stealth-active">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title lp-panel__title_regent-gray">Customize Your Lightbox</h2>
                        </div>
                        <div class="col-right">
                            <ul class="nav nav__tab" role="tablist">
                                <li class="nav-item">
                                    <a href="#" class="nav-link tab-opener active" data-slide="lightbox-setting">
                                        <span class="ico ico-settings"></span>Lightbox Settings
                                    </a>
                                </li>
                                <li class="nav-item button-setting-link">
                                    <a href="#" class="nav-link tab-opener" data-slide="button-setting">
                                        <span class="ico ico-btn"></span>Button Settings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link tab-opener" data-slide="grab-code">
                                        <span class="ico ico-code"></span>Grab the Code
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="background-detail">
                            <div class="background-detail__area">
                                <div class="theme__header">
                                    <div class="dots"></div>
                                    <div class="dots"></div>
                                    <div class="dots"></div>
                                </div>
                                <div class="background-detail__overlay-image">
                                    <img src="assets/images/promote-lightbox-funnel-image.png" alt="image">
                                </div>
                            </div>
                            <div class="bg-controls-block right-sidebar">
                                <div class="right-block-holder">
                                    <div class="tab-content">
                                        <div class="tab-slide tab-slide-active" data-id="lightbox-setting" style="display: block">
                                            <div class="embed-setting">
                                                <div class="embed-setting__basic">
                                                    <div class="basic-setting">
                                                        <div class="form-group">
                                                            <label for="open-popup">Lightbox Mode</label>
                                                            <div class="select2js__lightbox-mode-parent">
                                                                <select name="open-popup" id="open-popup" class="select2js__lightbox-mode"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="width">Width</label>
                                                        <div class="input__wrapper">
                                                            <input id="width" name="width" class="form-control" type="text" value="60">
                                                        </div>
                                                        <div class="select2js__width-unit-parent">
                                                            <select id="width" name="width" class="form-control select2js__width-unit">
                                                                <option>px</option>
                                                                <option selected="selected">%</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="height">Height</label>
                                                        <div class="input__wrapper">
                                                            <input id="height" name="height" class="form-control" type="text" value="60">
                                                        </div>
                                                        <div class="select2js__height-unit-parent">
                                                            <select id="height" name="height" class="form-control select2js__height-unit">
                                                                <option>px</option>
                                                                <option selected="selected">%</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="other-controls bg-wrap">
                                                        <div class="form-group border-none">
                                                            <label for="preview-button-pop">Background Color</label>
                                                            <div id="bg_color01" class="last-selected">
                                                                <div class="last-selected__box" style="background: #2f3743"></div>
                                                                <div class="last-selected__code">#2f3743</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group opacity-wrap">
                                                            <label>Background Opacity</label>
                                                            <div class="main__control bg__control_slider">
                                                                <input id="ex01" class="form-control" data-slider-id='ex1Slider' type="text"/>
                                                                <input type="hidden" id="lightbox-Background" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="lightboxauto">Launch Lightbox Automatically
                                                                <span class="question-mark question-mark_modal question-tooltip" title="Tooltip Content">?</span>
                                                            </label>
                                                            <div class="switcher-min">
                                                                <input id="lightboxauto" class="lightboxauto" name="lightboxauto"
                                                                       data-toggle="toggle min"
                                                                    data-onstyle="active" data-offstyle="inactive"
                                                                    data-width="71" data-height="28" data-on="OFF"
                                                                    data-off="ON" type="checkbox">
                                                            </div>
                                                        </div>
                                                        <div class="toggle-delay-box" style="display: none">
                                                            <div class="form-group">
                                                                <label for="delay-second">Launching Delay</label>
                                                                <div class="launching-delay-parent select2-parent">
                                                                    <select id="launching-delay" name="delay">
                                                                        <option>5 Seconds</option>
                                                                        <option>10 Seconds</option>
                                                                        <option>15 Seconds</option>
                                                                        <option>20 Seconds</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="stealth-mode">Stealth Mode
                                                                <span class="question-mark question-mark_modal question-tooltip" title="Tooltip Content">?</span>
                                                            </label>
                                                            <div class="switcher-min">
                                                                <input id="stealth-mode" class="stealth-mode" name="lightboxauto"
                                                                       data-toggle="toggle min"
                                                                    data-onstyle="active" data-offstyle="inactive"
                                                                    data-width="71" data-height="28" data-on="OFF"
                                                                    data-off="ON" type="checkbox">
                                                            </div>
                                                        </div>
                                                        <div class="stealth-mode-slide" style="display: none">
                                                            <div class="form-group">
                                                                <label for="hide01">Hide Header</label>
                                                                <div class="switcher-min">
                                                                    <input id="hide01" name="hide01" data-toggle="toggle min"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="71" data-height="28" data-on="OFF"
                                                                        data-off="ON" type="checkbox" checked>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="hide02">Hide Progress Bar</label>
                                                                <div class="switcher-min">
                                                                    <input id="hide02" name="hide02"
                                                                        data-toggle="toggle min"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="71" data-height="28" data-on="OFF"
                                                                        data-off="ON" type="checkbox" checked>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="hide03">Hide Footer </label>
                                                                <div class="switcher-min">
                                                                    <input id="hide03" name="hide03"
                                                                        data-toggle="toggle min"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="71" data-height="28" data-on="OFF"
                                                                        data-off="ON" type="checkbox" checked>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="hide04">Hide Form Background
                                                                </label>
                                                                <div class="switcher-min">
                                                                    <input id="hide04" name="hide04" data-toggle="toggle min"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="71" data-height="28" data-on="OFF"
                                                                        data-off="ON" type="checkbox" checked>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="close-submit">Close After Submit</label>
                                                            <div class="switcher-min">
                                                                <input id="close-submit" class="close-submit" name="close-submit"
                                                                       data-toggle="toggle min"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="71" data-height="28" data-on="OFF"
                                                                   data-off="ON" type="checkbox">
                                                            </div>
                                                        </div>
                                                        <div class="toggle-delay-closing" style="display: none">
                                                            <div class="form-group">
                                                                <label for="delay-second">Delay Closing for</label>
                                                                <div class="closing-delay-parent select2-parent">
                                                                    <select id="closing-delay" name="delay">
                                                                        <option>0 Seconds</option>
                                                                        <option>5 Seconds</option>
                                                                        <option>10 Seconds</option>
                                                                        <option>15 Seconds</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-slide" data-id="button-setting">
                                            <div class="button-code-area">
                                                <div class="other-controls">
                                                    <div class="form-group">
                                                        <label for="link-text" class="link-text">Convert To Text Link
                                                            <span class="question-mark question-mark_modal question-tooltip" title="Tooltip Content">?</span>
                                                        </label>
                                                        <div class="switcher-min">
                                                            <input id="link-text" class="convert-text-link" name="link-text"
                                                                   data-toggle="toggle min"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="71" data-height="28" data-on="OFF"
                                                                data-off="ON" type="checkbox">
                                                        </div>
                                                    </div>
                                                    <div class="convert-link-slide" style="display: none">
                                                        <div class="form-group">
                                                            <strong class="title">Link Settings</strong>
                                                        </div>
                                                        <div class="field-holder">
                                                            <input type="text" class="form-control" placeholder="Find out now!">
                                                        </div>
                                                        <div class="font-opitons-area">
                                                            <div class="select2__parent-button-text-font-type select2js__nice-scroll">
                                                                <select class="form-control font-type" id="button-text-font-family">
                                                                </select>
                                                            </div>
                                                            <div class="font-bold">
                                                                <button type="button" class="form-control txt-cta-bold"><i class="ico ico-alphabet-b"></i></button>
                                                            </div>
                                                            <div class="font-italic">
                                                                <button type="button" class="form-control txt-cta-italic"><i class="ico ico-alphabet-i"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="form-group border-none">
                                                            <label>Text Color</label>
                                                            <div id="bg_color04" class="last-selected text-selected">
                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                <div class="last-selected__code">#ffffff</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group opacity-wrap border-none button-font-size">
                                                            <label>Font Size</label>
                                                            <div class="main__control bg__control_slider">
                                                                <input id="ex05" class="form-control" data-slider-id='ex1Slider' type="text"/>
                                                                <input type="hidden" id="button-fontsize" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="custom-accordion button-accordion">
                                                        <li class="custom-accordion__list">
                                                            <a href="#" class="custom-accordion__opener active">Button Text <i class="ico ico-arrow-down"></i></a>
                                                            <div class="custom-accordion__slide" style="display: block">
                                                               <div class="field-holder">
                                                                   <input type="text" class="form-control" placeholder="Find out now!">
                                                               </div>
                                                                <div class="font-opitons-area">
                                                                    <div class="select2__parent-button-font-type select2js__nice-scroll">
                                                                        <select class="form-control font-type" id="button-font-family">
                                                                        </select>
                                                                    </div>
                                                                    <div class="font-bold">
                                                                        <button type="button" class="form-control txt-cta-bold"><i class="ico ico-alphabet-b"></i></button>
                                                                    </div>
                                                                    <div class="font-italic">
                                                                        <button type="button" class="form-control txt-cta-italic"><i class="ico ico-alphabet-i"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group border-none">
                                                                    <label>Text Color</label>
                                                                    <div id="bg_color02" class="last-selected text-selected">
                                                                        <div class="last-selected__box" style="background: #ffffff"></div>
                                                                        <div class="last-selected__code">#ffffff</div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group opacity-wrap border-none button-font-size">
                                                                    <label>Font Size</label>
                                                                    <div class="main__control bg__control_slider">
                                                                        <input id="ex02" class="form-control" data-slider-id='ex1Slider' type="text"/>
                                                                        <input type="hidden" id="lightbox-fontsize" value="0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="custom-accordion__list">
                                                            <a href="#" class="custom-accordion__opener">Button Design <i class="ico ico-arrow-down"></i></a>
                                                            <div class="custom-accordion__slide">
                                                                <div class="form-group border-none">
                                                                    <label>Background Color</label>
                                                                    <div id="bg_color03" class="last-selected text-selected">
                                                                        <div class="last-selected__box" style="background: #01c6f7"></div>
                                                                        <div class="last-selected__code">#01c6f7</div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group opacity-wrap border-none button-font-size">
                                                                    <label>Border Radius</label>
                                                                    <div class="main__control bg__control_slider">
                                                                        <input id="ex03" class="form-control" data-slider-id='ex1Slider' type="text"/>
                                                                        <input type="hidden" id="button-radius" value="0">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group opacity-wrap border-none button-shadow-wrap">
                                                                    <label>Button Shadow</label>
                                                                    <div class="main__control bg__control_slider">
                                                                        <input id="ex04" class="form-control"  data-slider-id='ex1Slider' type="text"/>
                                                                        <input type="hidden" id="button-shadow" value="0">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group button-icon-wrap">
                                                                    <label for="link-text">Button Icon</label>
                                                                    <div class="switcher-min">
                                                                        <input id="link-text" class="button-icon-opener" name="link-text"
                                                                               data-toggle="toggle min"
                                                                               data-onstyle="active" data-offstyle="inactive"
                                                                               data-width="71" data-height="28" data-on="OFF"
                                                                               data-off="ON" type="checkbox">
                                                                    </div>
                                                                </div>
                                                                <div class="button-icon-slide" style="display: none">
                                                                    <div class="fb-modal__row icon-select-row">
                                                                        <div class="icon-select">
                                                                            <a href="#select-icon-modal" data-toggle="modal" class="select-icon-opener icon-select__wrapper">
                                                                                <span class="icon-wrap">
                                                                                    <i class="ico-start-rate"></i>
                                                                                </span>
                                                                                <span class="text-icon-wrap">
                                                                                    <span class="icon-title">Icon:</span>
                                                                                    <span class="text-icon">Star</span>
                                                                                </span>
                                                                            </a>
                                                                        </div>
                                                                        <div class="icon-color">
                                                                            <div id="bg_color05" class="last-selected">
                                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                                <div class="last-selected__code">#ffffff</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group border-none icon-postion-wrap">
                                                                        <label>Icon positioning</label>
                                                                        <div class="select2-parent_icon-aligment select2-parent">
                                                                            <select id="icon-postion" class="form-control">
                                                                                <option>Left Align</option>
                                                                                <option>Center Align</option>
                                                                                <option>Right Align</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group opacity-wrap border-none">
                                                                        <label>Icon Size</label>
                                                                        <div class="main__control bg__control_slider">
                                                                            <input id="ex06" class="form-control" data-slider-id='ex1Slider' type="text"/>
                                                                            <input type="hidden" id="icon-size" value="15">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="custom-accordion__list">
                                                            <a href="#" class="custom-accordion__opener">Hover Effects <i class="ico ico-arrow-down"></i></a>
                                                            <div class="custom-accordion__slide">
                                                                <div class="hover-effect-detail">
                                                                    <strong class="title">Select Hover Effect</strong>
                                                                    <div class="hover-option-parent select2-parent">
                                                                        <select id="hover-option" class="form-control">
                                                                            <option value="0">"Inside out" option</option>
                                                                            <option value="1">Define custom colors</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="hover-option-slide" style="display: none">
                                                                        <div class="form-group border-none">
                                                                            <label>Background Color</label>
                                                                            <div id="bg_color06" class="last-selected">
                                                                                <div class="last-selected__box" style="background: #01c6f7"></div>
                                                                                <div class="last-selected__code">#01c6f7</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group border-none">
                                                                            <label>Text Color</label>
                                                                            <div id="bg_color07" class="last-selected">
                                                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                                                <div class="last-selected__code">#ffffff</div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group border-none">
                                                                            <label>Border Color</label>
                                                                            <div id="bg_color08" class="last-selected">
                                                                                <div class="last-selected__box" style="background: #373bc1"></div>
                                                                                <div class="last-selected__code">#373bc1</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="custom-accordion__list">
                                                            <a href="#" class="custom-accordion__opener">Animations <i class="ico ico-arrow-down"></i></a>
                                                            <div class="custom-accordion__slide">
                                                                <div class="animation-effect-detail">
                                                                    <strong class="title">Select Animation</strong>
                                                                    <div class="animation-option-parent select2-parent select2js__nice-scroll">
                                                                        <select id="animation-option" class="form-control">
                                                                            <option value="0">RubberBand</option>
                                                                            <option value="1">Loader</option>
                                                                            <option value="2">FadeIn</option>
                                                                            <option value="3">FadeOut</option>
                                                                            <option value="4">Circle</option>
                                                                            <option value="5">Pulse</option>
                                                                            <option value="6">Shake</option>
                                                                            <option value="7">Bounce</option>
                                                                            <option value="8">Swing</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group border-none">
                                                                        <label>Animation Frequency</label>
                                                                        <div class="frequency-option-parent select2-parent select2js__nice-scroll">
                                                                            <select id="frequency-option" class="form-control">
                                                                                <option value="0">5 seconds</option>
                                                                                <option value="1">10 seconds</option>
                                                                                <option value="2">15 seconds</option>
                                                                                <option value="3">20 seconds</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-slide" data-id="grab-code">
                                            <ul class="custom-accordion">
                                            <li class="custom-accordion__list">
                                                <a href="#" class="custom-accordion__opener">I can install code myself <i class="ico ico-arrow-down"></i></a>
                                                <div class="custom-accordion__slide">
                                                    <div class="copy-box">
                                                        <div class="copy-box-wrap">
                                                            <div id="script-code" class="lp-panel__grab-code">&lt;sript type=”text/javascript” <br>src=”https://dev2itclix.com/c475a0c0ebf80d88ac.js”&gt; &lt;/script&gt;</div>
                                                            <div class="copy-box__hover-box">
                                                                <button class="btn-copy" onclick="copyToClipboard('#script-code')"><i class="ico ico-copy"></i>copy code to clipboard</button>
                                                            </div>
                                                        </div>
                                                        <div class="info-text">
                                                            <p>Place the code in your page's HTML where you want your Funnel launcher button to&nbsp;appear.</p>
                                                        </div>
                                                        <button class="button button-primary btn-embed-webpage-copy" onclick="copyToClipboard('#script-code')">copy code</button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="custom-accordion__list">
                                                <a href="#" class="custom-accordion__opener">Send to website admin <i class="ico ico-arrow-down"></i></a>
                                                <div class="custom-accordion__slide">
                                                    <div class="info-text">
                                                        <p>If you don't feel comfortable dealing with code, you can click the button below to send an email containing the code snippet to your system administrator or website developer and they will know what to do! </p>
                                                    </div>
                                                    <button class="button button-info" data-toggle="modal" data-target="#code-modal">send to website admin</button>
                                                </div>
                                            </li>
                                            <li class="custom-accordion__list">
                                                <a href="#" class="custom-accordion__opener">Let us help you <i class="ico ico-arrow-down"></i></a>
                                                <div class="custom-accordion__slide">
                                                    <div class="info-text">
                                                        <p>If you don't have a technical person on your team, we can help. Simply submit your request here.</p>
                                                        <p>This service is included with your leadPops membership, <strong>absolutely free.</strong></p>
                                                    </div>
                                                    <button class="button button-info" data-toggle="modal" data-target="#login-modal">let us do it for you for free</button>
                                                </div>
                                            </li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer of the page -->
                <div class="footer">
                    <div class="row">
                        <img src="assets/images/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!--  color picker -->
    <div class="color-box__panel-wrapper button-background-clr background-clr-picker-lightbox">
        <div class="picker-inner-wrap">
            <div class="color-box__panel-dropdown">
                <select class="color-picker-options">
                    <option value="1">Color Selection:  Pick My Own</option>
                    <option value="2">Color Selection:  Pull from Logo</option>
                </select>
            </div>
            <div class="color-picker-block">
                <div class="picker-block" id="button-background-clr">
                </div>
                <label class="color-box__label">Add custom color code</label>
                <div class="color-box__panel-rgb-wrapper">
                    <div class="color-box__r">
                        R: <input class="color-box__rgb" value="47"/>
                    </div>
                    <div class="color-box__g">
                        G: <input class="color-box__rgb" value="55"/>
                    </div>
                    <div class="color-box__b">
                        B: <input class="color-box__rgb" value="67"/>
                    </div>
                </div>
                <div class="color-box__panel-hex-wrapper">
                    <label class="color-box__hex-label">Hex code:</label>
                    <input class="color-box__hex-block" value="#2f3743" />
                </div>
            </div>
            <div class="color-pull-block">
                <label class="color-box__label">Pulled Colors</label>
                <ul class="color-box__list">
                    <li class="color-box__item"></li>
                    <li class="color-box__item red"></li>
                    <li class="color-box__item green"></li>
                    <li class="color-box__item black"></li>
                    <li class="color-box__item blue"></li>
                    <li class="color-box__item orange"></li>
                    <li class="color-box__item yellow"></li>
                    <li class="color-box__item parrot"></li>
                </ul>
            </div>
            <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
        </div>
    </div>

    <div class="color-box__panel-wrapper button-text-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="button-text-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="255"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#ffffff" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled Colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>

    <div class="color-box__panel-wrapper button-text-clr01">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="button-text-clr01">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="255"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#ffffff" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled Colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>

    <div class="color-box__panel-wrapper button-background01-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="button-background01-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="12"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="205"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="186"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#01c6f7" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled Colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>

    <div class="color-box__panel-wrapper button-background02-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="button-background02-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="255"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#ffffff" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled Colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>

    <div class="color-box__panel-wrapper button-hover-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="button-hover-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="1"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="198"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="247"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#01c6f7" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled Colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>

    <div class="color-box__panel-wrapper button-hover-text-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="button-hover-text-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="255"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="255"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#ffffff" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled Colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>

    <div class="color-box__panel-wrapper button-hover-border-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="button-hover-border-clr">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="55"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="59"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="193"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#373bc1" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled Colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
<?php
include ("includes/code-modal.php");
include ("includes/video-modal.php");
include ("includes/footer.php");
?>