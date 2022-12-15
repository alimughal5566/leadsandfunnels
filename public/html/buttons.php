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
        <input type="hidden" id="box_shadow" name="box_shadow" value="100">
        <input type="hidden" id="horizontal_cta" name="horizontal" value="100">
        <input type="hidden" id="vertical_cta" name="vertical" value="69">

        <main class="main">
            <section class="main-content embed-webpage buttons-page">
                <!-- Title wrap of the page -->
                    <input type="hidden" id="bgbuttonhover" name="bgbuttonhover" value="#7888ff">
                    <div class="main-content__head main-content__head_tabs">
                        <div class="col-left">
                            <h1 class="title">
                                Buttons / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Buttons" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel lp-panel_tabs">
                        <div class="lp-panel__head py-1">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Button Preview
                                </h2>
                            </div>
                            <div class="col-right">
                                <ul class="nav nav__tab" role="tablist">
                                    <li class="nav-item btn-reset-wrap">
                                        <a class="btn-reset description-button-reset nav-link" href="#"><i class="ico ico-undo"></i> reset to default</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">
                                            <span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <span class="ico ico-Mobile el-tooltip" title="Mobile"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="background-detail">
                                <div class="background-detail__area background-detail__area__questions">
                                    <div class="theme__header">
                                        <div class="dots"></div>
                                        <div class="dots"></div>
                                        <div class="dots"></div>
                                    </div>
                                    <div class="preview-wrapper">
                                        <button type="button" class="button-cta">
                                            continue
                                        </button>
                                    </div>
                                </div>
                                <div class="bg-controls-block right-sidebar right-sidebar__question-answers">
                                    <div class="right-block-holder">
                                        <div class="button-code-area">
                                            <div class="other-controls">
                                                <ul class="custom-accordion button-accordion">
                                                    <li class="custom-accordion__list">
                                                        <a href="#" class="custom-accordion__opener">Button Text <i class="ico ico-arrow-down"></i></a>
                                                        <div class="custom-accordion__slide">
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
                                                                        <option value="6">Vroom Effect</option>
                                                                        <option value="7">Shake</option>
                                                                        <option value="8">Bounce</option>
                                                                        <option value="9">Swing</option>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer of the page -->
                    <div class="footer">
<!--                        <div class="row">-->
<!--                            <button type="submit" class="button button-secondary">Save</button>-->
<!--                        </div>-->
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
            </section>
        </main>
    </div>

    <div class="modal fade" id="modalFontAwesome">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Select an Icon</h3>
                </div>
                <div class="modal-body pt-2">
                    <ul class="icon__wrapper"></ul>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel btn-cancel-icon">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary btn-add-icon">Add icon</button>
                            </li>
                            <li class="action__item">
                                <button id="removeicon" class="button btn-danger">remove icon</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
