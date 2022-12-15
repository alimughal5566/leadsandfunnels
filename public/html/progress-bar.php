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
            <section class="main-content progress-bar-page">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Progress Bar / Funnel: <span class="funnel-name el-tooltip">203K Hybrid Loans</span>
                        </h1>
                        <input  id="progress-bar-page" name="progress-bar-page" data-toggle="toggle"
                                data-onstyle="active" data-offstyle="inactive"
                                data-width="127" data-height="43" data-on="INACTIVE"
                                data-off="ACTIVE" type="checkbox" >
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Progress Bar" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span>
                            Watch how to video
                        </a>
                    </div>
                </div>
                <!-- content of the page -->
                <div id="preview-panel" class="lp-panel lp-panel_tabs">
                    <div class="lp-panel__head pb-2">
                        <div class="col-left">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            Preview
                                        </li>
<!--                                        <li class="action__item theme__selection">-->
<!--                                            <label for="select2__selectbar">-->
<!--                                                Select progress bar style-->
<!--                                            </label>-->
<!--                                            <div class="select2__selectbar-parent">-->
<!--                                                <select id="select2__selectbar" class="form-control">-->
<!--                                                    <option value="h">Horizontal Bar</option>-->
<!--                                                    <option value="c">Circle Bar</option>-->
<!--                                                </select>-->
<!--                                            </div>-->
<!--                                        </li>-->
                                    </ul>
                                </div>
                            </div>
                        <div class="col-right">
                            <ul class="nav nav__tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Preview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="computer" data-toggle="pill" href="#computer">
                                        <span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
                                        <span class="text">Computer & Tablet</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="mobile" data-toggle="pill" href="#mobile">
                                        <span class="ico ico-mobile el-tooltip" title="Mobile"></span>
                                        <span class="text">Mobile</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="progress-content">
                            <div class="lp-panel-circle-bar">
                                <div class="progress-bar__wrapper">
                                    <div class="progress">
                                        <div class="progress__wrapper">
                                            <div class="progress__text progress__text_js progress__text_hide"><span class="sign-percentage">Completion</span><span class="sign-steps">Step 4 out of 10</span></div>
                                            <div class="progress__progress_meter">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 34 34" id="">
                                                    <circle cx="17" cy="17" r="15.5"
                                                            class="progress__progress_bar"/>

                                                    <circle id="js-countdown__progress" style="visibility: visible; stroke-dashoffset: 56.593px; stroke-dasharray: 70.389px, 60.389px;" cx="17" cy="17" r="15.5" stroke-linecap="round"
                                                            class="progress__js_progress js-countdown__progress"/>
                                                </svg>
                                                <div class="progress__text progress__text--percentage"><span class="sign-percentage">40%</span><span class="sign-steps">4/10</span></div>
                                                <div class="progress__overlay"><i class="fa fa-check"><span class="progress__overlay_icon"></span></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel-horizontal-bar">
                                <div class="horizontal-bar">
                                    <div class="horizontal-bar-bg">
                                        <div class="horizontal-bar__wrapper">
                                            <input id="ex1" type="text" class="form-control horizontal-slider">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-panel">
                    <div class="lp-panel-horizontal-bar">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">Horizontal Bar <span class="font-regular">Flag</span></h2>
                            </div>
                            <div class="col-right">
                                <input  id="horizontal-bar-check" name="horizontal-bar-check" data-toggle="toggle"
                                        data-onstyle="active" data-offstyle="inactive"
                                        data-width="127" data-height="43" data-on="INACTIVE"
                                        data-off="ACTIVE" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="form-group m-0">
                                <label for="horizontal-bar">Flag Display Style</label>
                                <div class="select2js__horizontal-bar-parent">
                                    <select class="select2js__horizontal-bar" name="horizontal-bar" id="horizontal-bar"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel-circle-bar">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">Circle Bar <span class="font-regular">Options</span></h2>
                            </div>
                            <div class="col-right">
                                <input  id="circle-bar-check" name="circle-bar-check" data-toggle="toggle"
                                        data-onstyle="active" data-offstyle="inactive"
                                        data-width="127" data-height="43" data-on="INACTIVE"
                                        data-off="ACTIVE" type="checkbox">
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="form-group m-0">
                                <label for="circelbar">Display Style</label>
                                <div class="select2js__circel-bar-parent">
                                    <select class="select2js__circel-bar" name="circelbar" id="circelbar">
                                        <option value="0">Percentage</option>
                                        <option value="1">Steps</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Color <span class="font-regular">Settings</span>
                                </h2>
                            </div>
<!--                            <div class="col-right">-->
<!--                                <div class="radio">-->
<!--                                    <ul class="radio__list">-->
<!--                                        <li class="radio__item radio__item_button-types">-->
<!--                                            <input type="radio" id="pullClrLogo" value="0" name="color-settings" checked>-->
<!--                                            <label class="radio__lbl" for="pullClrLogo">Pull From Logo</label>-->
<!--                                        </li>-->
<!--                                        <li class="radio__item radio__item_button-types">-->
<!--                                            <input type="radio" id="OwnClr" value="1" name="color-settings">-->
<!--                                            <label class="radio__lbl" for="OwnClr">Select My Own</label>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div class="lp-panel__body tab-content">
                            <div class="lp-panel-horizontal-bar">
                                <div class="clr-elm__wrapper clr-elm__wrapper_button">
                                    <div class="col-clr">
                                        <label>Background Color</label>
                                        <div class="inner__block">
<!--                                            <div id="clr-bg-horizontal-pull" class="last-selected pull-clr">-->
<!--                                                <div class="last-selected__box" style="background: #f8f9f9"></div>-->
<!--                                                <div class="last-selected__code">#f8f9f9</div>-->
<!--                                            </div>-->
                                            <div id="clr-bg-horizontal-colorpicker" class="last-selected clr-picker">
                                                <div class="last-selected__box" style="background: #ffffff"></div>
                                                <div class="last-selected__code">#ffffff</div>
                                            </div>
<!--                                            <div class="pull-clr__wrapper">-->
<!--                                                <span>Select one of the colors pulled from your logo</span>-->
<!--                                                <div class="color__wrapper">-->
<!--                                                    <div id="ics-gradient-editor-1-div" >-->
<!--                                                        <div class="gradient" id="ics-gradient-editor-1">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                    <div class="col-clr">
                                        <label>Base Color</label>
                                        <div class="inner__block">
                                            <!--                                            <div id="clr-brd-horizontal-pull" class="last-selected pull-clr">-->
                                            <!--                                                <div class="last-selected__box" style="background: #c9d7dd"></div>-->
                                            <!--                                                <div class="last-selected__code">#c9d7dd</div>-->
                                            <!--                                            </div>-->
                                            <div id="clr-brd-horizontal-colorpicker" class="last-selected clr-picker">
                                                <div class="last-selected__box" style="background: #c9d7dd"></div>
                                                <div class="last-selected__code">#c9d7dd</div>
                                            </div>
                                            <!--                                            <div class="pull-clr__wrapper">-->
                                            <!--                                                <span>Select one of the colors pulled from your logo</span>-->
                                            <!--                                                <div class="color__wrapper">-->
                                            <!--                                                    <div id="ics-gradient-editor-3-div" >-->
                                            <!--                                                        <div class="gradient" id="ics-gradient-editor-3">-->
                                            <!--                                                        </div>-->
                                            <!--                                                    </div>-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                    <div class="col-clr">
                                        <label>Progress Bar Color</label>
                                        <div class="inner__block">
<!--                                            <div id="clr-bar-horizontal-pull" class="last-selected pull-clr">-->
<!--                                                <div class="last-selected__box" style="background: #01aef0"></div>-->
<!--                                                <div class="last-selected__code">#01aef0</div>-->
<!--                                            </div>-->
                                            <div id="clr-bar-horizontal-colorpicker" class="last-selected clr-picker">
                                                <div class="last-selected__box" style="background: #01c6f7"></div>
                                                <div class="last-selected__code">#01c6f7</div>
                                            </div>
<!--                                            <div class="pull-clr__wrapper">-->
<!--                                                <span>Select one of the colors pulled from your logo</span>-->
<!--                                                <div class="color__wrapper">-->
<!--                                                    <div id="ics-gradient-editor-2-div" >-->
<!--                                                        <div class="gradient" id="ics-gradient-editor-2">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="clr-elm__wrapper-hover clr-elm__wrapper_flag">
                                    <div class="head">
                                        <div class="col-left">
                                            <h3 class="title">Progress Bar Flag Colors</h3>
                                        </div>
                                    </div>
                                    <div class="clr-elm__wrapper clr-elm__wrapper_button ">
                                        <div class="col-clr">
                                            <label for="selectedcolor">Background Color</label>
                                            <div class="inner__block">
<!--                                                <div id="clr-bg-horizontalpro-pull" class="last-selected pull-clr">-->
<!--                                                    <div class="last-selected__box" style="background: #073146"></div>-->
<!--                                                    <div class="last-selected__code">#073146</div>-->
<!--                                                </div>-->
                                                <div id="clr-bg-horizontalpro-colorpicker" class="last-selected clr-picker">
                                                    <div class="last-selected__box" style="background: #01c6f7"></div>
                                                    <div class="last-selected__code">#01c6f7</div>
                                                </div>
<!--                                                <div class="pull-clr__wrapper">-->
<!--                                                    <span>Select one of the colors pulled from your logo</span>-->
<!--                                                    <div class="color__wrapper">-->
<!--                                                        <div id="ics-gradient-editor-4-div" >-->
<!--                                                            <div class="gradient" id="ics-gradient-editor-4">-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="col-clr">
                                            <label for="selectedcolor">Text Color</label>
                                            <div class="inner__block">
<!--                                                <div id="clr-brd-horizontalpro-pull" class="last-selected pull-clr">-->
<!--                                                    <div class="last-selected__box" style="background: #f8f9f9"></div>-->
<!--                                                    <div class="last-selected__code">#f8f9f9</div>-->
<!--                                                </div>-->
                                                <div id="clr-txt-horizontalpro-colorpicker" class="last-selected clr-picker">
                                                    <div class="last-selected__box" style="background: #ffffff"></div>
                                                    <div class="last-selected__code">#ffffff</div>
                                                </div>
<!--                                                <div class="pull-clr__wrapper">-->
<!--                                                    <span>Select one of the colors pulled from your logo</span>-->
<!--                                                    <div class="color__wrapper">-->
<!--                                                        <div id="ics-gradient-editor-5-div" >-->
<!--                                                            <div class="gradient" id="ics-gradient-editor-5">-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel-circle-bar">
                                <div class="clr-elm__wrapper clr-elm__wrapper_button">
                                    <div class="col-clr">
                                        <label>Text Color</label>
                                        <div class="inner__block">
<!--                                            <div id="clr-txt-circel-pull" class="last-selected pull-clr">-->
<!--                                                <div class="last-selected__box" style="background: #b2b1be"></div>-->
<!--                                                <div class="last-selected__code">#b2b1be</div>-->
<!--                                            </div>-->
                                            <div id="clr-txt-circel-colorpicker" class="last-selected clr-picker">
                                                <div class="last-selected__box" style="background: #b2b1be"></div>
                                                <div class="last-selected__code">#b2b1be</div>
                                            </div>
<!--                                            <div class="pull-clr__wrapper">-->
<!--                                                <span>Select one of the colors pulled from your logo</span>-->
<!--                                                <div class="color__wrapper">-->
<!--                                                    <div id="ics-gradient-editor-6-div" >-->
<!--                                                        <div class="gradient" id="ics-gradient-editor-6">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                    <div class="col-clr">
                                        <label>Loader Text & Bar Color</label>
                                        <div class="inner__block">
<!--                                            <div id="clr-txtloader-circel-pull" class="last-selected pull-clr">-->
<!--                                                <div class="last-selected__box" style="background: #5665f6"></div>-->
<!--                                                <div class="last-selected__code">#5665f6</div>-->
<!--                                            </div>-->
                                            <div id="clr-txtloader-circel-colorpicker" class="last-selected clr-picker">
                                                <div class="last-selected__box" style="background: #5665f6"></div>
                                                <div class="last-selected__code">#5665f6</div>
                                            </div>
<!--                                            <div class="pull-clr__wrapper">-->
<!--                                                <span>Select one of the colors pulled from your logo</span>-->
<!--                                                <div class="color__wrapper">-->
<!--                                                    <div id="ics-gradient-editor-7-div" >-->
<!--                                                        <div class="gradient" id="ics-gradient-editor-7">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- footer of the page -->
                <div class="footer">
<!--                    <div class="row">-->
<!--                        <button type="submit" class="button button-secondary">Save</button>-->
<!--                    </div>-->
                    <div class="row">
                        <img src="assets/images/footer-logo.png" alt="footer logo">
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- color picker panel -->

    <div class="color-box__panel-wrapper clr-setting-bg">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="clr-setting-bg">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" />
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

    <div class="color-box__panel-wrapper clr-setting-bar">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="clr-setting-bar">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" />
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

    <div class="color-box__panel-wrapper clr-setting-brd">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="clr-setting-brd">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" />
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

    <div class="color-box__panel-wrapper clr-progress-bg">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="clr-progress-bg">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" />
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

    <div class="color-box__panel-wrapper clr-progress-txt">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="clr-progress-txt">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" />
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

    <div class="color-box__panel-wrapper clr-circle-txt">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="clr-circle-txt">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" />
            </div>
        </div>
        <div class="color-pull-block">
            pull colors
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
    <div class="color-box__panel-wrapper clr-circle-txtloader">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="clr-circle-txtloader">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" />
            </div>
        </div>
        <div class="color-pull-block">
            pull colors
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

    <div id="bodymovin"></div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>