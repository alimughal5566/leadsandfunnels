<?php
include ("includes/head.php");
?>
<!-- contain sidebar of the page -->

<!-- contain the main content of the page -->
<div id="content" class="w-100">
    <!-- header of the page -->
    <?php
    include ("includes/header.php");
    ?>
    <!-- contain main informative part of the site -->
    <main class="main">
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <div class="main-content d-flex justify-content-center">
            <button class="button button-primary" data-target="#homepage-cta-message-pop" data-toggle="modal">Cta Message Advance Popup</button>
        </div>
    </main>
</div>
<div class="modal fade homepage-cta-message" id="homepage-cta-message-pop">
    <div class="modal-dialog modal-dialog-centered modal-max__dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title">Edit Funnel Homepage CTA Message</h5>
                <div class="tab__wrapper">
                    <ul class="nav nav__tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tbbasic">Basic</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="pill" href="#tbadvanced">Advanced</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-body p-0 quick-scroll">
                <div class="tab-content">
                    <div id="tbbasic" class="tab-pane">
                        <div class="cta-msg lp-panel rounded-0 p-0">
                            <div class="cta-msg__head">
                                <div class="cta-msg__head-col">
                                    <h2 class="cta-msg__title">
                                        Main message
                                    </h2>
                                </div>
                                <div class="cta-msg__head-col">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                            <span class="action__span">
                                                <a href="javascript:void(0)" class="action__link">
                                                    <span class="ico ico-undo"></span>Reset
                                                </a>
                                            </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="cta-msg__body">
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
                                                <div class="font-linehight">
                                                    <label>Line Spacing</label>
                                                    <div class="select2-linehight-mian-msg-parent">
                                                        <select class="select2-linehight-main-msg"></select>
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
                        <div class="cta-msg lp-panel rounded-0 border-bottom-0 p-0">
                            <div class="cta-msg__head">
                                <div class="cta-msg__head-col">
                                    <h2 class="cta-msg__title">
                                        Description
                                    </h2>
                                </div>
                                <div class="cta-msg__head-col">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                            <span class="action__span">
                                                <a href="javascript:void(0)" class="action__link">
                                                    <span class="ico ico-undo"></span>Reset
                                                </a>
                                            </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="cta-msg__body">
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
                                                <div class="font-linehight">
                                                    <label>Line Spacing</label>
                                                    <div class="select2-linehight-dsc-msg-parent">
                                                        <select class="select2-linehight-dsc-msg"></select>
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
                    <div id="tbadvanced" class="tab-pane show active">
                        <div class="cta-msg">
                            <div class="cta-msg__head">
                                <div class="cta-msg__head-col">
                                    <h2 class="cta-msg__title">
                                        Main message
                                    </h2>
                                </div>
                                <div class="cta-msg__head-col">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                            <span class="action__span">
                                                <a href="javascript:void(0)" class="action__link">
                                                    <span class="ico ico-undo"></span>Reset
                                                </a>
                                            </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="cta-msg__body">
                                <div class="classic-editor__wrapper">
                                    <textarea class="lp-froala-textbox"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="cta-msg">
                            <div class="cta-msg__head">
                                <div class="cta-msg__head-col">
                                    <h2 class="cta-msg__title">
                                        Description
                                    </h2>
                                </div>
                                <div class="cta-msg__head-col">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                            <span class="action__span">
                                                <a href="javascript:void(0)" class="action__link">
                                                    <span class="ico ico-undo"></span>Reset
                                                </a>
                                            </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="cta-msg__body">
                                <div class="classic-editor__wrapper">
                                    <textarea class="lp-froala-textbox"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                        </li>
                        <li class="action__item">
                            <button class="button button-bold button-primary" type="submit">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Main Message color picker -->
    <div class="color-box__panel-wrapper main-message-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
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
            <label class="color-box__label">Pull colors</label>
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
            <select class="color-picker-options">
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
            <label class="color-box__label">Pull colors</label>
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

