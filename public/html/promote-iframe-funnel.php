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
            <section class="main-content embed-webpage">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            iFrame Your Funnel / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="iFrame Your Funnel" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span> Watch how to video</a>
                    </div>
                </div>
                <!-- content of the page -->
                <div class="lp-panel lp-panel_tabs">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title lp-panel__title_regent-gray">iFrame Your Funnel</h2>
                        </div>
                        <div class="col-right">
                            <ul class="nav nav__tab" role="tablist">
                                <li class="nav-item">
                                    <div class="select-custom-size-parent select2-parent">
                                        <select id="custom-size" name="height" class="form-control select2js-custom-size">
                                        </select>
                                    </div>
                                </li>
                                <li class="nav-item nav-item__frame-settings">
                                    <a href="#" class="nav-link tab-opener active" data-slide="iframe-setting">
                                        <span class="ico ico-settings"></span>iFrame Settings
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
                                    <img src="assets/images/advance-background.png" alt="Mortgage">
                                </div>
                            </div>
                            <div class="bg-controls-block right-sidebar">
                                <div class="right-block-holder">
                                    <div class="tab-content">
                                        <div class="tab-slide tab-slide-active" data-id="iframe-setting" style="display: block">
                                            <div class="embed-setting">
                                                <div class="embed-setting__basic">
                                                    <div class="form-group disabled">
                                                        <label for="width">Width</label>
                                                        <div class="input__wrapper">
                                                            <input id="width" name="width" class="form-control" type="text" value="1250">
                                                        </div>
                                                        <div class="select2js__width-unit-parent">
                                                            <select id="width" name="width" class="form-control select2js__width-unit">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group disabled">
                                                        <label for="height">Height</label>
                                                        <div class="input__wrapper">
                                                            <input id="height" name="height" class="form-control" type="text" value="800">
                                                        </div>
                                                        <div class="select2js__height-unit-parent">
                                                            <select id="height" name="height" class="form-control select2js__height-unit">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="embed-setting__seamless">
                                                    <div class="seamless-box">
                                                        <div class="left">
                                                            <label for="seamless">
                                                                Hide Header
                                                            </label>
                                                        </div>
                                                        <div class="right">
                                                            <div class="switcher-min">
                                                                <input id="hideheader" name="hideheader" data-toggle="toggle min"
                                                                        data-onstyle="active" data-offstyle="inactive"
                                                                        data-width="71" data-height="28" data-on="OFF"
                                                                        data-off="ON" type="checkbox">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="seamless-box">
                                                        <div class="left">
                                                            <label for="seamless">
                                                                Hide Footer
                                                            </label>
                                                        </div>
                                                        <div class="right">
                                                            <div class="switcher-min">
                                                                <input id="hidefooter" name="hidefooter" data-toggle="toggle min"
                                                                       data-onstyle="active" data-offstyle="inactive"
                                                                       data-width="71" data-height="28" data-on="OFF"
                                                                       data-off="ON" type="checkbox">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-slide" data-id="grab-code">
                                            <ul class="custom-accordion">
                                                <li class="custom-accordion__list">
                                                    <a href="#" class="custom-accordion__opener">I can install code myself <i class="ico ico-arrow-down"></i></a>
                                                    <div class="custom-accordion__slide">
                                                        <div class="copy-box">
                                                            <div id="script-code" class="lp-panel__grab-code">&lt;sript type=”text/javascript” <br>src=”https://dev2itclix.com/c475a0c0ebf80d88ac.js”&gt; &lt;/script&gt;</div>
                                                            <div class="info-text">
                                                                <p>Paste this code in your site's HTML on the page you want your fullscreen Funnel to appear. </p>
                                                            </div>
                                                            <button class="button button-primary btn-embed-webpage-copy" onclick="copyToClipboard('#script-code')">copy code</button>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="custom-accordion__list">
                                                    <a href="#" class="custom-accordion__opener">Send to website admin <i class="ico ico-arrow-down"></i></a>
                                                    <div class="custom-accordion__slide">
                                                        <div class="info-text">
                                                            <p>If you don't feel comfortable dealing with code, you can click the button below to send an email containing the code snippet to your system administrator or website developer and they will know what to do!</p>
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
<?php
include ("includes/code-modal.php");
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
