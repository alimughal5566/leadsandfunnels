<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
    <div class="panel-aside">
        <div class="panel-aside__head">
            <div class="col-left">
                <h4 class="panel-aside__title has-icon ctamessage-icon">
                <span>
                    <i class="ico ico-message head-icon"></i>
                    CTA Message
                </span>
                </h4>
            </div>
            <div class="col-right">
                <a href="funnel-question.php">
                    <span class="ico-arrow-right back-ico"></span>
                </a>
            </div>
        </div>
        <div class="panel-aside-wrap">
            <div class="panel-aside-holder">
                <div class="panel-aside__body m-0 p-0">

            <!-- Heading -->
            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown open">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">
                        Call-to-Action
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-modal__handler">
                            <!-- <i class="fbi fbi_arrow"></i>-->
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
                    <div class="fb-form">
                        <div class="fb-froala classic-editor__wrapper">
                            <div class="fb-froala__init"></div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Description -->
            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">Description</div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input class="fb-field-label" name="sticky_bar_active"
                                   type="checkbox"
                                   id="toggle-status"
                                   data-toggle="toggle"
                                   data-on="off"
                                   data-off="on"
                                   data-onstyle="off"
                                   data-offstyle="on">
                        </div>
                    </div>
                </div>
                <div class="fb-modal__border-row fb-modal__border-row_menu">
                    <div class="fb-form">
                        <div class="fb-froala classic-editor__wrapper">
                            <div class="fb-froala__init"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- cta button -->
            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">CTA Button</div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input class="fb-field-label" name="field_label"
                                   type="checkbox"
                                   id="toggle-status"
                                   data-toggle="toggle"
                                   data-on="off"
                                   data-off="on"
                                   data-onstyle="off"
                                   data-offstyle="on" checked>
                        </div>
                    </div>
                </div>
                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
                    <div class="fb-form">
                        <div class="fb-form__caption">
                            <span class="fb-form__middle">Button Text</span>
                            <span class="fb-tooltip">
                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                </span>
                        </div>
                        <div class="fb-form__group">
                            <input type="text" class="form-control fb-form-control" value="Continue">
                            <span class="tag-box">
                                <i class="fa fa-tag" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="cta-select">
                            <div class="fb-select-wrap fb-select2-group fb-select2-group_url">
                                <select class="fb-select_slider" id="fb-select-url" name="fb-select-url"></select>
                            </div>
                        </div>
                        <input type="text" class="form-control fb-form-control" placeholder="Add URL" value="">
                        <div class="cta-checkbox-pt">
                            <div class="fb-checkbox fb-checkbox_large">
                                <input class="fb-checkbox__input" type="checkbox" id="new-tab">
                                <label for="new-tab" class="fb-checkbox__label">
                                    <div class="fb-checkbox__box">
                                        <div class="fb-checkbox__inner-box"></div>
                                    </div>
                                    <div class="fb-checkbox__caption">
                                        Open link in new tab
                                    </div>
                                </label>
                            </div>
                        </div>
                       <!-- <div class="fb-checkbox mt-3">
                            <input class="fb-checkbox__input" type="checkbox" id="showonly-option">
                            <label for="showonly-option" class="fb-checkbox__label">
                                <div class="fb-checkbox__box">
                                    <div class="fb-checkbox__inner-box"></div>
                                </div>
                                <div class="fb-checkbox__caption">
                                    Hide CTA button until the question is answered
                                </div>
                            </label>
                        </div>-->
                    </div>
                </div>
            </div>
            <!-- Additional Content -->
            <div class="form-group fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">Additional Content</div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input class="fb-field-label" name="field_label"
                                   type="checkbox"
                                   id="toggle-status"
                                   data-toggle="toggle"
                                   data-on="off"
                                   data-off="on"
                                   data-onstyle="off"
                                   data-offstyle="on">
                        </div>
                    </div>
                </div>
                <div class="fb-modal__border-row fb-modal__border-row_menu">
                    <div class="fb-form">
                        <div class="fb-froala classic-editor__wrapper">
                            <div class="fb-froala__init"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
<!--        <div class="panel-aside__footer">-->
<!--                    <div class="action">-->
<!--                        <ul class="action__list justify-content-end">-->
<!--                            <li class="action__item">-->
<!--                                <button class="button button-cancel">Close</button>-->
<!--                            </li>-->
<!--                            <li class="action__item">-->
<!--                                <button class="button button-secondary">Save</button>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
    </div>
    <!-- contain the main content of the page -->
    <div id="content">
        <!-- header of the page -->
        <?php
        include ("includes/header.php");
        ?>
        <!-- contain main informative part of the site -->
        <!-- content of the page -->
        <main class="main">
            <section class="main-content">
                <!-- content of the page -->

                <!-- content of the page -->
            </section>
        </main>
    </div>

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>