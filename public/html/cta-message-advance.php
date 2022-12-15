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
        <main class="main">
            <!-- content of the page -->
            <section class="main-content">
                <form id="ctaform" action="">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Call-to-Action / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="CTA Messaging" data-lp-wistia-key="uneyp2xgwm" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                            <div class="tab__wrapper">
                                <ul class="nav nav__tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tbbasic">Basic</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#tbadvanced">Advanced</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="tab-content">
                        <div id="tbbasic" class="tab-pane">
                            <div class="lp-panel">
                                <div class="lp-panel__head">
                                    <div class="col-left">
                                        <h2 class="lp-panel__title">
                                            Main Message
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item action__item_separator">
                                        <span class="action__span">
                                            <a href="javascript:void(0)" onclick="return resethomepagemessage('1');" class="action__link">
                                                <span class="ico ico-undo"></span>Reset
                                            </a>
                                        </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__body">
                                    <div class="cta">
                                        <div class="cta__message-control">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <div class="font-type">
                                                        <label>Font Type</label>
                                                        <div class="select2__parent-font-type select2js__nice-scroll">
                                                            <select class="form-control font-type" name="" id="msgfonttype">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="action__item">
                                                    <div class="font-size">
                                                        <label>Font Size</label>
                                                        <div class="select2__parent-font-size select2js__nice-scroll">
                                                            <select class="form-control" name="" id="msgfontsize">
                                                                <option value="10">10 px</option>
                                                                <option value="11">11 px</option>
                                                                <option value="12">12 px</option>
                                                                <option value="13">13 px</option>
                                                                <option value="14">14 px</option>
                                                                <option value="15">15 px</option>
                                                                <option value="16">16 px</option>
                                                                <option value="17">17 px</option>
                                                                <option value="18">18 px</option>
                                                                <option value="19">19 px</option>
                                                                <option value="20">20 px</option>
                                                                <option value="21">21 px</option>
                                                                <option value="22">22 px</option>
                                                                <option value="23">23 px</option>
                                                                <option value="24">24 px</option>
                                                                <option value="25">25 px</option>
                                                                <option value="26">26 px</option>
                                                                <option value="27">27 px</option>
                                                                <option value="28">28 px</option>
                                                                <option value="29">29 px</option>
                                                                <option value="30">30 px</option>
                                                                <option value="31">31 px</option>
                                                                <option value="32">32 px</option>
                                                                <option value="33">33 px</option>
                                                                <option value="34">34 px</option>
                                                                <option value="35">35 px</option>
                                                                <option value="36">36 px</option>
                                                                <option value="37">37 px</option>
                                                                <option value="38" selected="selected">38 px</option>
                                                                <option value="39">39 px</option>
                                                                <option value="40">40 px</option>
                                                                <option value="41">41 px</option>
                                                                <option value="42">42 px</option>
                                                                <option value="43">43 px</option>
                                                                <option value="44">44 px</option>
                                                                <option value="45">45 px</option>
                                                                <option value="46">46 px</option>
                                                                <option value="47">47 px</option>
                                                                <option value="48">48 px</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="action__item">
                                                    <div class="text-color">
                                                        <label>Text Color</label>
                                                        <div class="text-color-parent">
                                                            <div class="color-picker colorSelector-mmessagecp cta-color-selector" style="background-color: #0ccdba;"></div>
                                                            <input type="hidden" name="mmessagecpval" id="mmessagecpval" value="">
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="cta__message">
                                            <textarea class="form-control text-area" name="mian__message" id="mian__message"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="lp-panel__head">
                                    <div class="col-left">
                                        <h2 class="lp-panel__title">
                                            Description
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item action__item_separator">
                                        <span class="action__span">
                                            <a href="javascript:void(0)" onclick="return resethomepagemessage('2');" class="action__link">
                                                <span class="ico ico-undo"></span>Reset
                                            </a>
                                        </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__body">
                                    <div class="cta">
                                        <div class="cta__message-control">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <div class="font-type">
                                                        <label>Font Type</label>
                                                        <div class="select2__parent-dfont-type select2js__nice-scroll">
                                                            <select class="form-control font-type" id="dfonttype" name="">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="action__item">
                                                    <div class="font-size">
                                                        <label>Font Size</label>
                                                        <div class="select2__parent-dfont-size select2js__nice-scroll">
                                                            <select class="form-control" name="" id="dfontsize">
                                                                <option value="10">10 px</option>
                                                                <option value="11">11 px</option>
                                                                <option value="12">12 px</option>
                                                                <option value="13">13 px</option>
                                                                <option value="14">14 px</option>
                                                                <option value="15">15 px</option>
                                                                <option value="16" selected="selected">16 px</option>
                                                                <option value="17">17 px</option>
                                                                <option value="18">18 px</option>
                                                                <option value="19">19 px</option>
                                                                <option value="20">20 px</option>
                                                                <option value="21">21 px</option>
                                                                <option value="22">22 px</option>
                                                                <option value="23">23 px</option>
                                                                <option value="24">24 px</option>
                                                                <option value="25">25 px</option>
                                                                <option value="26">26 px</option>
                                                                <option value="27">27 px</option>
                                                                <option value="28">28 px</option>
                                                                <option value="29">29 px</option>
                                                                <option value="30">30 px</option>
                                                                <option value="31">31 px</option>
                                                                <option value="32">32 px</option>
                                                                <option value="33">33 px</option>
                                                                <option value="34">34 px</option>
                                                                <option value="35">35 px</option>
                                                                <option value="36">36 px</option>
                                                                <option value="37">37 px</option>
                                                                <option value="38">38 px</option>
                                                                <option value="39">39 px</option>
                                                                <option value="40">40 px</option>
                                                                <option value="41">41 px</option>
                                                                <option value="42">42 px</option>
                                                                <option value="43">43 px</option>
                                                                <option value="44">44 px</option>
                                                                <option value="45">45 px</option>
                                                                <option value="46">46 px</option>
                                                                <option value="47">47 px</option>
                                                                <option value="48">48 px</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="action__item">
                                                    <div class="text-color">
                                                        <label for="textcolor">Text Color</label>
                                                        <div class="text-color-parent">
                                                            <div  class="color-picker colorSelector-mdescp cta-color-selector" data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval" style="background-color:#3f3f3f"></div>
                                                            <input type="hidden" name="dmessagecpval" id="dmessagecpval" value="">
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="cta__message">
                                            <textarea class="form-control text-area" name="desc__message" id="desc__message"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tbadvanced" class="tab-pane active show">
                            <div class="lp-panel">
                                <div class="lp-panel__head">
                                    <div class="col-left">
                                        <h2 class="lp-panel__title">
                                            Main Message
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item action__item_separator">
                                                <span class="action__span">
                                                    <a href="javascript:void(0)" onclick="return resethomepagemessage('1');" class="action__link">
                                                        <span class="ico ico-undo"></span>Reset
                                                    </a>
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__body">
                                    <div class="classic-editor__wrapper">
                                        <textarea class="lp-froala-textbox"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="lp-panel__head">
                                    <div class="col-left">
                                        <h2 class="lp-panel__title">
                                            Description
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item action__item_separator">
                                                <span class="action__span">
                                                    <a href="javascript:void(0)" onclick="return resethomepagemessage('2');" class="action__link">
                                                        <span class="ico ico-undo"></span>Reset
                                                    </a>
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__body">
                                    <div class="classic-editor__wrapper">
                                        <textarea class="lp-froala-textbox"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <!-- footer of the page -->
                    <div class="footer">
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <!-- Main Message color picker -->
    <div class="color-box__panel-wrapper main-message-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options color-picker-options-message">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="main-message-colorpicker">
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
                <input class="color-box__hex-block" value="#707d84" />
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
    <!-- Description color picker -->
    <div class="color-box__panel-wrapper desc-message-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options color-picker-options-description">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="desc-message-colorpicker">
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
                <input class="color-box__hex-block" value="#707d84" />
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
    include ("includes/video-modal.php");
    include ("includes/footer.php");
?>