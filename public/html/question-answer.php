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
            <section class="main-content header-page  embed-webpage">
                <!-- Title wrap of the page -->
                    <input type="hidden" id="hp_color_opacity" name="hp_color_opacity" value="39">
                    <input type="hidden" id="questions-modeowncolor-hex" name="" value="#34409E">
                    <input type="hidden" id="questions-modeowncolor-rgb" name="" value="rgb(52, 64, 158)">
                    <input type="hidden" id="dsc-modeowncolor-hex" name="" value="#34409E">
                    <input type="hidden" id="dsc-modeowncolor-rgb" name="" value="rgb(52, 64, 158)">
                    <div class="main-content__head main-content__head_tabs qesution-head">
                        <div class="col-left">
                            <h1 class="title">
                                Text / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title=" Questions & Answers" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div id="preview-panel" class="lp-panel lp-panel_tabs">
                        <div class="lp-panel__head pb-2">
                            <div class="col-left mt-0">
                                <h2 class="lp-panel__title">
                                    <span class="tab__title">Question & Answer Preview</span>
                                </h2>
                            </div>
                            <div class="col-right mt-0">
                                <ul class="nav nav__tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">
                                            <span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <span class="ico ico-mobile el-tooltip" title="Mobile"></span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="select2js__slct-question-parent select2js__nice-scroll">
                                    <select class="select2js__slct-question" name="slct-question" id="slct-question"></select>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="background-detail pb-0">
                                <div class="background-detail__area background-detail__area__questions">
                                    <div class="theme__header">
                                        <div class="dots"></div>
                                        <div class="dots"></div>
                                        <div class="dots"></div>
                                    </div>
                                    <div class="preview-wrapper">
                                        <h2 class="question-preview">Want to generate more and better quality leads?</h2>
                                        <p class="description-preview">Try Lead Funnels free for 30 days — once you see the results for yourself you'll never go back to the old way of doing things.</p>
                                        <div class="answer-preview">
                                            <div class="answer-preview__panel">
                                                <div class="anwser-preview-panel menu" id="menu">
                                                    <div class="menu__wrapper">
                                                        <ul class="menu__list">
                                                            <li class="menu__item">
                                                                <button class="button-answer">Single Family Home</button>
                                                            </li>
                                                            <li class="menu__item">
                                                                <button class="button-answer">Condominium</button>
                                                            </li>
                                                            <li class="menu__item">
                                                                <button class="button-answer">Townhome</button>
                                                            </li>
                                                            <li class="menu__item">
                                                                <button class="button-answer">Multi-Family Home</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="anwser-preview-panel zip-code" id="zipCode">
                                                    <div class="zip-code__wrapper">
                                                        <div class="input__wrapper focused">
                                                            <label id="label-zip-code" for="zip-code">Zip Code</label>
                                                            <input name="zip-code" id="zip-code" type="text">
                                                            <!--                                                        <div class="indicator">-->
                                                            <!--                                                            <img src="assets/images/check-tick.png" alt="check">-->
                                                            <!--                                                        </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="anwser-preview-panel slider" id="slider">
                                                    <div class="slider__wrapper">
                                                        <div class="slider__title">
                                                            $300,000 to $320,000
                                                        </div>
                                                        <input id="qa__slider" type="text" data-slider-min="50"
                                                               data-slider-max="138" data-slider-step="0.88" data-slider-value="100"
                                                               data-slider-tooltip="hide" data-value="138" value="138">
                                                        <div class="slider__label">
                                                            <span class="left">$80k</span>
                                                            <span class="right">$2M+</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="anwser-preview-panel text-field" id="textField">
                                                    <div class="txt-field__wrapper">
                                                        <div class="input__wrapper focused">
                                                            <label id="label-fav-movie" for="fav-movie">your answer</label>
                                                            <input name="fav-movie" id="fav-movie" type="text">
                                                            <!--                                                        <div class="indicator">-->
                                                            <!--                                                            <img src="assets/images/check-tick.png" alt="check">-->
                                                            <!--                                                        </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="anwser-preview-panel dropdown" id="dropDown">
                                                    <div class="select-box">
                                                        <span class="placeholder-text">select an option</span>
                                                        <i class="icon ico-arrow-down"></i>
                                                        <ul class="dropdown__list" style="display: none;">
                                                            <li class="dropdown__item">
                                                                Single Family Home
                                                            </li>
                                                            <li class="dropdown__item">
                                                                Condominium
                                                            </li>
                                                            <li class="dropdown__item">
                                                                Townhome
                                                            </li>
                                                            <li class="dropdown__item">
                                                                Multi Family Home
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="anwser-preview-panel contact-info" id="contactInfo">
                                                    <div class="input__wrapper focused">
                                                        <label id="label-f-name" for="f-name">first name</label>
                                                        <input name="f-name" id="f-name" value="" type="text">
                                                    </div>
                                                    <div class="input__wrapper">
                                                        <label id="label-l-name" for="l-name">last name</label>
                                                        <input name="l-name" id="l-name" value="" type="text">
                                                    </div>
                                                    <div class="input__wrapper">
                                                        <label id="label-e-address" for="e-address">email address</label>
                                                        <input name="e-address" id="e-address" value="" type="text">
                                                    </div>
                                                    <div class="input__wrapper">
                                                        <label id="p-num" for="p-num">phone number</label>
                                                        <input name="p-num" id="p-nume" value="" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-controls-block right-sidebar right-sidebar__question-answers">
                                    <div class="right-block-holder">
                                        <ul class="custom-accordion">
                                            <li class="custom-accordion__list">
                                                <a href="#" class="custom-accordion__opener">Questions <i class="ico ico-arrow-down"></i></a>
                                                <div class="custom-accordion__slide">
                                                    <div class="font-opitons-area">
                                                        <div class="select2__parent-questions-font-type select2js__nice-scroll">
                                                            <select class="form-control font-type" name="" id="questions-fonttype">
                                                            </select>
                                                        </div>
                                                        <div class="font-bold">
                                                            <button class="form-control btn-font q-button-bold active">
                                                                <i class="ico ico-alphabet-b"></i>
                                                            </button>
                                                        </div>
                                                        <div class="font-italic">
                                                            <button class="form-control btn-font q-button-italic">
                                                                <i class="ico ico-alphabet-i"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <ul class="bg-options">
                                                        <li class="bg-options__item">
                                                            <span class="bg-options__title">Text Color</span>
                                                            <div class="bg-options__select-holder">
                                                                <div id="clr_question_txt" class="last-selected bg__color-swatch">
                                                                    <div class="last-selected__box" style="background: #141c43"></div>
                                                                    <div class="last-selected__code">#141c43</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-options__item">
                                                            <span class="bg-options__title">Line Height</span>
                                                            <div class="bg-options__select-holder">
                                                                <div class="question-line-field">
                                                                    <label><i class="ico ico-line-height"></i></label>
                                                                    <div class="select2-linehight-question-parent">
                                                                        <select class="select2-linehight-question">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-options__item font-size-wrap">
                                                            <span class="bg-options__title">Font Size</span>
                                                            <div class="bg-options__select-holder">
                                                                <div class="bg__control_slider">
                                                                    <input id="question-fontsize" class="form-control" type="text"/>
                                                                    <input type="hidden" id="question-fontsize-val" value="20">
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="custom-accordion__btn-reset">
                                                        <button class="btn-reset question-button-reset">
                                                            <i class="ico ico-undo"></i> reset to default
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="custom-accordion__list">
                                                <a href="#" class="custom-accordion__opener">Descriptions <i class="ico ico-arrow-down"></i></a>
                                                <div class="custom-accordion__slide">
                                                    <div class="font-opitons-area">
                                                        <div class="select2__parent-dsc-font-type select2js__nice-scroll">
                                                            <select class="form-control font-type" name="" id="dsc-fonttype">
                                                            </select>
                                                        </div>
                                                        <div class="font-bold">
                                                            <button class="form-control btn-font a-button-bold">
                                                                <i class="ico ico-alphabet-b"></i>
                                                            </button>
                                                        </div>
                                                        <div class="font-italic">
                                                            <button class="form-control btn-font a-button-italic">
                                                                <i class="ico ico-alphabet-i"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <ul class="bg-options">
                                                        <li class="bg-options__item">
                                                            <span class="bg-options__title">Text Color</span>
                                                            <div class="bg-options__select-holder">
                                                                <div id="clr_dsc_txt" class="last-selected bg__color-swatch">
                                                                    <div class="last-selected__box" style="background: #94a2aa"></div>
                                                                    <div class="last-selected__code">#94a2aa</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-options__item">
                                                            <span class="bg-options__title">Line Height</span>
                                                            <div class="bg-options__select-holder">
                                                                <div class="question-line-field">
                                                                    <div class="select2-linehight-answer-parent">
                                                                        <select class="select2-linehight-answer">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-options__item font-size-wrap">
                                                            <span class="bg-options__title">Font Size</span>
                                                            <div class="bg-options__select-holder">
                                                                <div class="bg__control_slider">
                                                                    <input id="description-fontsize" class="form-control" type="text"/>
                                                                    <input type="hidden" id="description-fontsize-val" value="20">
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="custom-accordion__btn-reset">
                                                        <button class="btn-reset description-button-reset">
                                                            <i class="ico ico-undo"></i> reset to default
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="custom-accordion__list">
                                                <a href="#" class="custom-accordion__opener">Answers <i class="ico ico-arrow-down"></i></a>
                                                <div class="custom-accordion__slide">
                                                    <ul class="bg-options">
                                                        <li>
                                                            <div class="font-opitons-area">
                                                                <div class="select2__menufont-type-parent select2js__nice-scroll">
                                                                    <select class="select2__menufont-type font-type" id="menutypefont"></select>
                                                                </div>
                                                                <div class="font-bold">
                                                                    <button class="form-control btn-font a-button-bold">
                                                                        <i class="ico ico-alphabet-b"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="font-italic">
                                                                    <button class="form-control btn-font a-button-italic">
                                                                        <i class="ico ico-alphabet-i"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-options__item">
                                                            <span class="bg-options__title">Primary Color</span>
                                                            <div class="bg-options__select-holder">
                                                                <div id="primary-clr" class="last-selected bg__color-swatch">
                                                                    <div class="last-selected__box" style="background: #01c6f7"></div>
                                                                    <div class="last-selected__code">#01c6f7</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-options__item bg-options__item__secondary-color">
                                                            <span class="bg-options__title">Text Color</span>
                                                            <div class="bg-options__select-holder">
                                                                <div id="secondary-clr" class="last-selected bg__color-swatch bg__color-swatch__disabled">
                                                                    <div class="last-selected__box" style="background: #ffffff"></div>
                                                                    <div class="last-selected__code">#ffffff</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-options__item bg-options__item__label-color">
                                                            <span class="bg-options__title">Field Label Color</span>
                                                            <div class="bg-options__select-holder">
                                                                <div id="field-clr" class="last-selected bg__color-swatch">
                                                                    <div class="last-selected__box" style="background: #c8d1d5"></div>
                                                                    <div class="last-selected__code">#c8d1d5</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="custom-accordion__btn-reset">
                                                        <button class="btn-reset bp-button-reset">
                                                            <i class="ico ico-undo"></i> reset to default
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
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


    <!-- color picker question -->
    <div class="color-box__panel-wrapper question-txt-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="questionsowncolor__box">
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
    <!-- color picker desc -->
    <div class="color-box__panel-wrapper dsc-txt-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="dscowncolor__box">
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

    <!--  Design Options  -->

    <div class="color-box__panel-wrapper color-box__panel-wrapper_primary">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="primary-color"></div>
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
    <div class="color-box__panel-wrapper color-box__panel-wrapper_secondary">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="secondary-color"></div>
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
    <div class="color-box__panel-wrapper color-box__panel-wrapper_field">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="field-color"></div>
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



<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
