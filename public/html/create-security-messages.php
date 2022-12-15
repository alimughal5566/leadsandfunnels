<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
    <!-- contain the main content of the page -->
    <div id="content">
        <!-- header of the page -->
		<?php
		    include ("includes/header.php");
		?>
        <!-- contain main informative part of the site -->
        <!-- content of the page -->
        <main class="main">
            <section class="main-content security-message">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Security Message : <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <a data-lp-wistia-title="SEO" data-lp-wistia-key="ji1qu22nfq" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                        <span class="icon ico-video"></span>
                                        Watch how to video
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="list-security-messages.php" class="back-link">
                                        <span class="icon icon-back ico-caret-up"></span>
                                        Back to initial page
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <!-- content of the page -->
                <div class="lp-panel lp-panel_tabs">


                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title lp-panel__title_regent-gray">Green shield icon</h2>
                        </div>
                        <div class="col-right">
                            <ul class="nav nav__tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#Custom">
                                        <span class="el-tooltip" title="Computer & Tablet">
                                            <span class="ico ico-devices"></span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#FullPage">
                                        <span class="ico ico-Mobile el-tooltip" title="Mobile"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="lp-panel__body">
                        <div class="available-preview">
                            <div class="lp-panel__embed">
                                <div class="lp-panel__embed-preview">
                                    <div class="theme__wrapper">
                                        <div class="theme__header">
                                            <div class="dots"></div>
                                            <div class="dots"></div>
                                            <div class="dots"></div>
                                        </div>
                                        <div class="theme__body">
                                            <img src="assets/images/funnel-preview-ss-message.png" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__embed-setting-panel">
                                    <div class="preview-panel">
                                        <div class="preview-panel__head">
                                            <div class="form-group">
                                                <h3 class="preview-panel__title">
                                                    Security Message Icon
                                                </h3>
                                                <div class="switcher-min">
                                                    <input  id="message-icon" name="message-icon" data-toggle="toggle min"
                                                            data-onstyle="active" data-offstyle="inactive"
                                                            data-width="72" data-height="26" data-on="OFF"
                                                            data-off="ON" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-panel__body">
                                            <div class="icon-setting">
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Select an Icon</label>
                                                    <div class="btn-icon-wrapper">
                                                        <div class="icon-block">
                                                            <i class="ico ico-shield-2"></i>
                                                        </div>
                                                        <span class="arrow"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Icon Color</label>
                                                    <div class="text-color-parent">
                                                        <div id="clr-icon" class="last-selected">
                                                            <div class="last-selected__box" style="background: #24b928"></div>
                                                            <div class="last-selected__code">#24b928</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Icon Position</label>
                                                    <div class="select2js__icon-position-parent select2-parent">
                                                        <select name="select2js__icon-position" id="select2js__icon-position">
                                                            <option>Left Align</option>
                                                            <option>Right Align</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Icon Size</label>
                                                    <div class="range-slider">
                                                        <div class="input__wrapper">
                                                            <input id="ex1" class="form-control" data-slider-id='ex1Slider' type="text"/>
                                                            <input type="hidden" id="iconsize" value="28">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="default-setting">
                                                <div class="form-group form-group_security-message">
                                                    <label for="buttontext">
                                                        Security Message Text
                                                        <span class="question-mark el-tooltip" title="Tooltip Content">
                                                        <span class="ico ico-question"></span>
                                                    </span>
                                                    </label>
                                                    <div class="font-opitons-area security-font-option">
                                                        <div class="input__wrapper">
                                                            <input type="text" id="security_message_text" class="form-control" placeholder="Privacy & Security Guaranteed">
                                                        </div>
                                                        <div class="font-bold">
                                                            <button type="button" class="form-control txt-cta-bold"><i class="ico ico-alphabet-b"></i></button>
                                                        </div>
                                                        <div class="font-italic">
                                                            <button type="button" class="form-control txt-cta-italic"><i class="ico ico-alphabet-i"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preview-button-pop">Text Color</label>
                                                    <div class="text-color-parent">
                                                        <div id="clr-text" class="last-selected">
                                                            <div class="last-selected__box" style="background: #b4bbbc"></div>
                                                            <div class="last-selected__code">#b4bbbc</div>
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
                <!-- footer of the page -->
                <div class="footer">
                    <div class="row">
                        <img src="assets/images/footer-logo.png" alt="footer logo">
                    </div>
                </div>
                <!-- color picker modal -->
                <div class="modal fade" id="icon-picker">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Select Icon</h5>
                            </div>
                            <div class="modal-body pb-0">
                                <ul class="icon-wrapper"></ul>
                            </div>
                            <div class="modal-footer">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                                        </li>
                                        <li class="action__item">
                                            <button class="button button-bold button-primary btn-add-icon">Select</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!--  color picker -->
    <div class="color-box__panel-wrapper security-text-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="text-clr">
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
                <input class="color-box__hex-block" id="security-text-clr-trigger" value="#707d84" />
                <input type="hidden" class="color-opacity" value="1">
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
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
    <div class="color-box__panel-wrapper security-icon-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="icon-clr">
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
                <input class="color-box__hex-block" id="security-icon-clr-trigger" value="#707d84" />
                <input type="hidden" class="color-opacity" value="1">
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
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
include ("includes/video-modal.php");
include ("includes/footer.php");
?>