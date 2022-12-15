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
            <section class="main-content page-theme">
                <!-- Title wrap of the page -->
                    <input type="hidden" id="hp_color_opacity" name="hp_color_opacity" value="39">
                    <input type="hidden" id="questions-modeowncolor-hex" name="" value="#34409E">
                    <input type="hidden" id="questions-modeowncolor-rgb" name="" value="rgb(52, 64, 158)">
                    <input type="hidden" id="dsc-modeowncolor-hex" name="" value="#34409E">
                    <input type="hidden" id="dsc-modeowncolor-rgb" name="" value="rgb(52, 64, 158)">
                    <div class="main-content__head main-content__head_tabs qesution-head">
                        <div class="col-left">
                            <h1 class="title">
                                Themes / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Theme" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div id="preview-panel" class="lp-panel lp-panel_tabs">
                        <div class="lp-panel__head">
                            <div class="col-left mt-0">
                                <h2 class="lp-panel__title">
                                    <span class="tab__title">Theme Preview</span>
                                </h2>
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
                            <div class="col-right mt-0">
                                <div class="theme-selection-area">
                                    <div class="theme-select-box">
                                        <label for="theme">Select Theme</label>
                                        <div class="theme-select-parent select2-parent">
                                            <select id="theme" class="theme-select"></select>
                                        </div>
                                    </div>
                                    <div class="action-button" style="display: none;">
                                        <button type="button" class="button button-primary" data-target="#custom-theme" data-toggle="modal">
                                            save custom theme
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="background-detail pb-0">
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
                                <div class="bg-controls-block right-sidebar right-sidebar__question-answers">
                                    <div class="right-block-holder">
                                        <div class="theme_select-area">
                                            <label for="layout">Select Design Layout</label>
                                            <div class="select2-parent layout-select-parent">
                                                <select class="layout-select"></select>
                                            </div>
                                        </div>
                                        <div class="code-wrap-area">
                                            <div class="form-group">
                                                <label for="lightboxauto">Add Customt CSS
                                                    <span class="question-mark question-mark_modal question-tooltip" title="Tooltip Content">?</span>
                                                </label>
                                                <div class="switcher-min">
                                                    <input id="code-switcher" class="code-switcher" name="code-switcher" data-toggle="toggle min" data-onstyle="active"  data-offstyle="inactive" data-width="71" data-height="28" data-on="OFF" data-off="ON" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="code-slide" style="display: none;">
                                                <div class="code-head">
                                                    <a href="#custom-code-theme" data-toggle="modal"><i class="ico ico-full-screen"></i>
                                                        Full Screen
                                                    </a>
                                                    <a href="#" class="clear-code"><i class="ico ico-cross"></i>
                                                        clear code
                                                    </a>
                                                </div>
                                                <div class="code-body">
                                                    <textarea class="codemirror-textarea"></textarea>
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
            </section>
        </main>
    </div>
    <!-- Model theme settinig -->
    <div class="modal fade custom-theme" id="custom-theme" tabindex="-1" role="dialog" aria-labelledby="custom-theme"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Custom Theme</h5>
                </div>
                <div class="modal-body quick-scroll">
                    <div class="modal-body-wrap">
                        <div class="modal-field">
                            <label for="theme-name">New Theme Name</label>
                            <div class="field">
                                <input type="text" value="Dark-Blue w/o background" id="theme-name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Model Manage theme -->
    <div class="modal fade manage-theme" id="manage-theme" tabindex="-1" role="dialog" aria-labelledby="manage-theme" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Themes</h5>
                </div>
                <div class="modal-body">
                    <div class="manage-theme-head">
                        <div class="heading">
                            <div class="heading-box">
                                Theme Name
                                <span class="sorter"><span class="arrow-up"></span><span class="arrow-down"></span></span>
                            </div>
                            <div class="heading-box">
                                Options
                            </div>
                        </div>
                        <div class="manage-theme-listing quick-scroll">
                            <div class="manage-theme-listing-wrap">
                                <div class="list-item">
                                    <span class="item-name">leadPops Default</span>
                                </div>
                                <div class="list-item">
                                    <span class="item-name">Dark-Blue w/o background</span>
                                    <div class="actions-area">
                                        <span class="dots">
                                            <i class="fa fa-circle"></i>
                                            <i class="fa fa-circle"></i>
                                            <i class="fa fa-circle"></i>
                                        </span>
                                        <ul class="actions-list">
                                            <li><a href="#"><i class="ico ico-edit"></i></a></li>
                                            <li><a href="#"><i class="ico ico-cross"></i></a></li>
                                        </ul>
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
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Model theme settinig -->
    <div class="modal fade custom-code-theme" id="custom-code-theme" tabindex="-1" role="dialog" aria-labelledby="custom-code-theme" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Custom CSS Code</h5>
                    <a href="#" class="code-reset"><i class="ico ico-cross"></i>clear code</a>
                </div>
                <div class="modal-body quick-scroll">
                    <div class="modal-body-wrap">
                        <div class="modal-field">
                            <div class="label-holder">
                                <label for="theme-name-alt">Theme Name</label>
                            </div>
                            <div class="field">
                                <input type="text" value="Dark-Blue w/o background" id="theme-name-alt">
                            </div>
                        </div>
                        <div class="modal-code">
                            <textarea class="codemirror-textarea-modal"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
