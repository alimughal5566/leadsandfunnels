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
			<section class="main-content block-bg">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Background / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title=" Open in Popup" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span> Watch how to video</a>
                    </div>
                </div>
                <div class="lp-panel lp-panel_tabs">
                    <div class="lp-panel__head">
                        <div class="col-left mt-0">
                            <h2 class="lp-panel__title lp-panel__title_regent-gray">Customize Background</h2>
                            <ul class="nav nav__tab" role="tablist">
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
                        <div class="right-col">
                            <ul class="nav nav__tab tabs-bg" role="tablist">
                                <li class="nav-item">
                                    <a href="#" class="nav-link tab-opener active" data-slide="main-background">
                                        <span class="ico ico-image"></span>
                                        <span class="tabs-bg__text">Page Background</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link tab-opener" data-slide="form-background">
                                        <span class="ico ico-terminal el-tooltip" title="Mobile"></span>
                                        <span class="tabs-bg__text">Funnel Background</span>
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
                            <div class="bg-controls-block">
                                <div class="tab-content">
                                    <div class="tab-slide tab-slide-active" data-id="main-background" style="display: block">
                                        <div class="right-block-holder background-right-block">
                                            <div class="custom-scroll-holder">
                                                <div class="custom-scroll-holder__wrap">
                                                    <ul class="bg-list-accordion">
                                                        <li class="bg-list-accordion__item">
                                                            <label class="bg-list-accordion__opener">
                                                                <input type="radio" name="background" checked>
                                                                <span class="bg-list-accordion__fake-radio"></span>
                                                                <span class="bg-list-accordion__text">Customize Your Colors</span>
                                                            </label>
                                                            <div class="bg-list-accordion__slide" style="display: block;">
                                                                <div class="bg-list-accordion__slide__wrap">
                                                                    <div class="bg-list-accordion__color-picker">
                                                                        <span class="bg-list-accordion__color-title">Background Color</span>
                                                                        <!-- background bg color picker-->
                                                                        <div class="color-picker-holder">
                                                                            <div id="background-bg-opener" class="background-bg-opener last-selected has-shadow-parent">
                                                                                <div class="last-selected__box" style="background: rgb(246, 248, 248);"></div>
                                                                                <div class="last-selected__code">#f6f8f8</div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="bg-list-accordion__item">
                                                            <label class="bg-list-accordion__opener">
                                                                <input type="radio" name="background">
                                                                <span class="bg-list-accordion__fake-radio"></span>
                                                                <span class="bg-list-accordion__text">Upload a Background Image</span>
                                                            </label>
                                                            <div class="bg-list-accordion__slide">
                                                                <div class="bg-list-accordion__slide__wrap">
                                                                    <div class="dropzone needsclick bg-main__dropzone" id="main-bg-image-holder">
                                                                        <div class="dz-message needsclick">
                                                                            <div class="dz-message__opener">
                                                                                <i class="icon ico-plus"></i>
                                                                                <span class="text-uppercase">Add image</span>
                                                                            </div>
                                                                            <div class="gallery-dropdown" style="display: none;">
                                                                                <span class="gallery-dropdown__title">add image</span>
                                                                                <ul class="dropdown-list">
                                                                                    <li class="dropdown-list__item">
                                                                                        <div  id="main-bg-image">Upload from your computer </div>
                                                                                    </li>
                                                                                    <li class="dropdown-list__item">
                                                                                        <a class="modal-opener" data-toggle="modal"
                                                                                           href="#background-design">Select a background design</a>
                                                                                    </li>
                                                                                    <li class="dropdown-list__item">
                                                                                        <a data-toggle="modal"
                                                                                           href="#browse-gallery"
                                                                                           class="modal-opener">Browse
                                                                                            image gallery</a>
                                                                                    </li>
                                                                                    <li class="dropdown-list__item">
                                                                                        <a href="#" class="dropdown-list__canva">
                                                                                        <span class="canva-logo">
                                                                                            <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/logo-canva.png" alt="Canva">
                                                                                        </span>
                                                                                            Design on Canva
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="bg-options__wrap">
                                                                        <div class="bg-switcher bg-switcher__main">
                                                                            <span class="bg-main__title">Background Overlay Color</span>
                                                                            <div class="switcher-min">
                                                                                <input id="bg-main-switcher" name="sb-script-switcher" data-toggle="toggle min"
                                                                                       data-onstyle="active" data-offstyle="inactive"
                                                                                       data-width="71" data-height="30" data-on="OFF"
                                                                                       data-off="ON" type="checkbox" class="bg-overlay-controller">
                                                                            </div>
                                                                        </div>
                                                                        <div class="bg-options-slide">
                                                                            <ul class="bg-options">
                                                                                <li class="bg-options__item">
                                                                                    <span class="bg-options__title">Overlay Color</span>
                                                                                    <!-- background overlay color picker-->
                                                                                    <div class="color-picker-holder">
                                                                                        <div id="background-overlay-opener" class="background-overlay-opener last-selected has-shadow-parent">
                                                                                            <div class="last-selected__box" style="background: rgb(24, 76, 220);"></div>
                                                                                            <div class="last-selected__code">#184cdc</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="bg-options-area">
                                                                            <ul class="bg-options">
                                                                                <li class="bg-options__item">
                                                                                    <span class="bg-options__title">Background Repeat</span>
                                                                                    <div class="background-option-select">
                                                                                        <div class="select-bg-repeat-parent select2-parent select2js__nice-scroll">
                                                                                            <select class="select-bg-repeat">
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="bg-options__item">
                                                                                    <span class="bg-options__title">Background Position</span>
                                                                                    <div class="background-option-select">
                                                                                        <div class="select-bg-position-parent select2-parent select2js__nice-scroll">
                                                                                            <select class="select-bg-position">
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="bg-options__item">
                                                                                    <span class="bg-options__title">Background Size</span>
                                                                                    <div class="background-option-select">
                                                                                        <div class="select-bg-size-parent select2-parent  select2js__nice-scroll">
                                                                                            <select class="select-bg-size">
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
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
                                    <div class="tab-slide" data-id="form-background">
                                        <div class="right-block-holder funnel-right-block">
                                            <div class="custom-scroll-holder">
                                                <div class="custom-scroll-holder__wrap">
                                                    <div class="bg-switcher bg-switcher__form-activater">
                                                        <span class="bg-main__title">Funnel Background</span>
                                                        <div class="switcher-min">
                                                            <input id="bg-content-switcher" name="sb-script-switcher" data-toggle="toggle min"
                                                                   data-onstyle="active" data-offstyle="inactive"
                                                                   data-width="71" data-height="30" data-on="OFF"
                                                                   data-off="ON" type="checkbox" checked>
                                                        </div>
                                                    </div>
                                                    <div class="bg-slide-holder">
                                                <div class="bg-shadow-controller">
                                                    <div class="bg-shadow-controller__slider">
                                                        <span class="bg-options__title">Background Shadow</span>
                                                        <div class="bg-options__select-holder">
                                                            <input id="bg__shadow-slider" class="bg__shadow-slider" type="text" data-slider-min="0" data-slider-max="100" value="60"/>
                                                        </div>
                                                    </div>
                                                    <div class="bg-shadow-controller__slider">
                                                        <span class="bg-options__title">Corner Radius</span>
                                                        <div class="bg-options__select-holder">
                                                            <input id="bg__corner-radius" class="bg__corner-radius" type="text" data-slider-min="0" data-slider-max="100" value="60"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="bg-list-accordion">
                                                    <li class="bg-list-accordion__item">
                                                        <label class="bg-list-accordion__opener">
                                                            <input type="radio" name="bg-form" checked>
                                                            <span class="bg-list-accordion__fake-radio"></span>
                                                            <span class="bg-list-accordion__text">Customize Your Colors</span>
                                                        </label>
                                                        <div class="bg-list-accordion__slide" style="display: block;">
                                                            <div class="right-block-holder">
                                                                <div class="bg-list-accordion__slide__wrap">
                                                                    <div class="bg-list-accordion__color-picker">
                                                                        <span class="bg-list-accordion__color-title">Background Color</span>
                                                                        <!-- funnel bg color picker-->
                                                                        <div class="color-picker-holder">
                                                                            <div id="funnel-bg-opener" class="funnel-bg-opener last-selected has-shadow-parent">
                                                                                <div class="last-selected__box" style="background: rgb(255, 255, 255);"></div>
                                                                                <div class="last-selected__code">#ffffff</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="bg-list-accordion__item funnel-bg">
                                                        <div class="right-block-holder">
                                                            <label class="bg-list-accordion__opener">
                                                                <input type="radio" name="bg-form">
                                                                <span class="bg-list-accordion__fake-radio"></span>
                                                                <span class="bg-list-accordion__text">Upload a Background Image</span>
                                                            </label>
                                                            <div class="bg-list-accordion__slide">
                                                                <div class="bg-list-accordion__slide__wrap">
                                                                    <div class="dropzone needsclick bg-main__dropzone" id="form-bg-image-holder">
                                                                        <div class="dz-message needsclick">
                                                                            <div class="dz-message__opener">
                                                                                <i class="icon ico-plus"></i>
                                                                                <span class="text-uppercase">Add image</span>
                                                                            </div>
                                                                            <div class="gallery-dropdown" style="display: none;">
                                                                                <span class="gallery-dropdown__title">add image</span>
                                                                                <ul class="dropdown-list">
                                                                                    <li class="dropdown-list__item">
                                                                                        <div  id="form-bg-image">Upload from your computer </div>
                                                                                    </li>
                                                                                    <li class="dropdown-list__item">
                                                                                        <a class="modal-opener" data-toggle="modal"
                                                                                           href="#background-design">Select a background design</a>
                                                                                    </li>
                                                                                    <li class="dropdown-list__item">
                                                                                        <a data-toggle="modal" class="modal-opener"
                                                                                           href="#browse-gallery">Browse image gallery</a>
                                                                                    </li>
                                                                                    <li class="dropdown-list__item">
                                                                                        <a href="#" class="dropdown-list__canva">
                                                                                        <span class="canva-logo">
                                                                                            <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/logo-canva.png" alt="Canva">
                                                                                        </span>
                                                                                            Design on Canva
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div class="canvas-wrapper-area">
                                                                            <div class="canvas-image" id="canvas-parent">
                                                                                <span class="overlay overlay-top"></span>
                                                                                <span class="overlay overlay-left"></span>
                                                                                <span class="overlay overlay-right"></span>
                                                                                <span class="overlay overlay-bottom"></span>
                                                                                <canvas id="canvas" width="276"
                                                                                        height="148"></canvas>
                                                                            </div>
                                                                            <div class="image-actions-area">
                                                                                <input id="image-handler" type="text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="bg-options__wrap">
                                                                        <div class="bg-switcher">
                                                                            <span class="bg-main__title">Background Overlay Color</span>
                                                                            <div class="switcher-min">
                                                                                <input id="bg-form-switcher" name="sb-script-switcher" data-toggle="toggle min"
                                                                                       data-onstyle="active" data-offstyle="inactive"
                                                                                       data-width="71" data-height="30" data-on="OFF"
                                                                                       data-off="ON" type="checkbox" class="bg-overlay-controller">
                                                                            </div>
                                                                        </div>
                                                                        <div class="bg-options-slide">
                                                                            <ul class="bg-options">
                                                                                <li class="bg-options__item">
                                                                                    <span class="bg-options__title">Overlay Color</span>
                                                                                    <!-- funnel overlay color picker-->
                                                                                    <div class="color-picker-holder">
                                                                                        <div id="funnel-overlay-opener" class="last-selected has-shadow-parent funnel-overlay-opener">
                                                                                            <div class="last-selected__box" style="background: rgb(255, 255, 255);"></div>
                                                                                            <div class="last-selected__code">#ffffff</div>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
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
                        </div>
                    </div>
                </div>
			</section>
		</main>
	</div>

    <!-- browse gallery modal -->
    <div class="modal fade bg-advance-modal bg-advance-gallery-modal" id="browse-gallery">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Browse image gallery</h5>
                    <ul class="bg-advance__list-radio">
                        <li class="bg-advance__list-radio__li">
                            <label class="bg-advance__radio-label">
                                <input type="radio" value="0" checked="" name="gallery">
                                <span class="bg-advance__fake-radio"><i class="icon"></i>Free</span>
                            </label>
                        </li>
                        <li class="bg-advance__list-radio__li">
                            <label class="bg-advance__radio-label">
                                <input type="radio" value="1" name="gallery">
                                <span class="bg-advance__fake-radio"><i class="icon"></i>Premium</span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <div class="modal-body-wrap">
                        <ul class="nav nav-tabs bg-advance__tabset" id="galleryTab" role="tablist">
                            <li class="nav-item bg-advance__tabset__li" role="presentation">
                                <a class="nav-link active bg-advance__tabset__item" id="browse-tab" data-toggle="tab"
                                   href="#browse" role="tab" aria-controls="browse" aria-selected="true">browse images</a>
                            </li>
                            <li class="nav-item bg-advance__tabset__li" role="presentation">
                                <a class="nav-link bg-advance__tabset__item" id="recently-tab" data-toggle="tab" href="#recently" role="tab" aria-controls="recently" aria-selected="false">Recently used</a>
                            </li>
                            <li class="nav-item bg-advance__tabset__li" role="presentation">
                                <a class="nav-link bg-advance__tabset__item" id="favorites-tab" data-toggle="tab" href="#favorites" role="tab" aria-controls="favorites" aria-selected="false">favorites</a>
                            </li>
                        </ul>
                        <div class="bg-advance-filters-area">
                            <form action="#" class="bg-advance-form-search" date-field>
                                <input type="search" class="form-control" placeholder="Search images ...">
                                <button type="submit" class="button button-primary"><i class="icon ico-search"></i></button>
                            </form>
                            <div class="bg-advance-sort-parent select2-parent">
                                <select class="bg-advance-sort-select"></select>
                            </div>
                            <div class="sorting-btns">
                                <a href="#" class="btn-ascending"><i class="icon ico-arrow-up"></i></a>
                                <a href="#" class="btn-decending"><i class="icon ico-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="tab-content" id="galleryTabContent">
                            <div class="tab-pane show active" id="browse" role="tabpanel" aria-labelledby="browse-tab">
                                <div class="bg-advance-custom-scrollbar bg-advance__gallery-box quick-scroll">
                                    <ul class="gallery-list" id="browse-images">
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane" id="recently" role="tabpanel" aria-labelledby="recently-tab">
                                <div class="bg-advance-custom-scrollbar bg-advance__gallery-box quick-scroll">
                                    <ul class="gallery-list" id="recent-images">
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane" id="favorites" role="tabpanel" aria-labelledby="favorites-tab">
                                <div class="bg-advance-custom-scrollbar bg-advance__gallery-box quick-scroll">
                                    <ul class="gallery-list" id="favorite-images"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="footer-image">
                        <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/extra-content/splash.png" alt="Splash">
                    </div>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">cancel</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-bold button-primary btn-insert-image" data-dismiss="modal" disabled>insert image</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- background design modal -->
    <div class="modal fade bg-advance-modal bg-advance-gallery-modal" id="background-design">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select a background design</h5>
                </div>
                <div class="modal-body">
                    <div class="modal-body-wrap">
                        <div class="bg-advance-custom-scrollbar bg-advance__gallery-box quick-scroll">
                            <ul class="gallery-list" id="background-images">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">cancel</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-bold button-primary disabled btn-insert-image" data-dismiss="modal">Select</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Color setting modal -->
    <div class="modal fade color-setting-modal" id="color-setting-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Apply This Color to Other Sections
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="color-setting__info">
                        <p>We can take this color and apply it to different sections of your Funnel. You can always
                            access this color across the admin through the colorpicker.</p>
                        <p>Apply this color to:</p>
                    </div>
                    <div class="color-options-box quick-scroll">
                        <ul class="color-options-list">
                            <li>
                                <label class="default-fake-check">
                                    <input type="checkbox">
                                    <span class="fake-check-box"></span>
                                    Answers (Primary Color)
                                </label>
                            </li>
                            <li>
                                <label class="default-fake-check">
                                    <input type="checkbox">
                                    <span class="fake-check-box"></span>
                                    Homepage CTA (Main Message)
                                </label>
                            </li>
                            <li>
                                <label class="default-fake-check">
                                    <input type="checkbox">
                                    <span class="fake-check-box"></span>
                                    Progress Bar (Bar & Flag)
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer justify-flex-end">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-bold button-primary" disabled>Apply</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- page background color picker -->
    <div class="color-box__panel-wrapper background-bg-color has-shadow">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="background-bg-color">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="246"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="248"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="248"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#f6f8f8" />
                <input type="hidden" id="background-bg-clr-trigger"
                       value="1">
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

    <!-- page background overlay color picker -->
    <div class="color-box__panel-wrapper has-shadow background-overlay-color">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="background-overlay-color">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="24"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="74"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="220"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#184cdc" />
                <input type="hidden" id="background-overlay-clr-trigger" value="1">
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

    <!-- page funnel color picker -->
    <div class="color-box__panel-wrapper funnel-bg-color has-shadow">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="funnel-bg-color">
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
                <input type="hidden" id="funnel-bg-clr-trigger"
                       value="1">
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

    <!-- page funnel overlay color picker -->
    <div class="color-box__panel-wrapper has-shadow funnel-overlay-color">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="funnel-overlay-color">
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
                <input type="hidden" id="funnel-overlay-clr-trigger" value="1">
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
