<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
    <div class="panel-aside panel-aside_zip">
        <div class="panel-aside__head">
            <div class="col-left">
                <h4 class="panel-aside__title has-icon zip-icon">
                <span>
                    <i class="ico ico-location head-icon"></i>
                    <span class="head-text">Zip Code</span>
                </span>
                </h4>
            </div>
            <div class="col-right">
                <span title="Zip Code" class="ico-arrow-right back-ico"></span>
            </div>
        </div>
        <div class="panel-aside-wrap">
            <div class="panel-aside-holder">
                <div class="panel-aside__body m-0 p-0">
            <!--Add Question Detail-->
            <div class="form-group fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">Question</div>
                    <div class="fb-modal__control fb-modal__control_middle">
                            <span class="fb-tooltip fb-tooltip_pb2">
                                <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                        <div class="fb-toggle">
                            <input checked class="fb-field-label" name="sticky_bar_active"
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
                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
                    <div class="fb-form">
                        <div class="fb-froala classic-editor__wrapper">
                            <div class="fb-froala__init"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Description -->
            <div class="form-group fb-modal__border-box_dropdown">
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
            <!-- Field Label -->
            <div class="form-group fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">Field Label</div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input checked class="fb-field-label" name="field_label"
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
                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block;">
                    <div class="fb-form">
<!--                        <div class="fb-form__caption">-->
<!--                            <span class="fb-form__middle">Blank Text Field Label</span>-->
<!--                            <span class="fb-tooltip">-->
<!--                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>-->
<!--                                </span>-->
<!--                        </div>-->
                        <div class="fb-form__group">
                            <input type="text" class="form-control fb-form-control" value="Zip Code">
                            <span class="tag-box">
                                    <i class="fa fa-tag"></i>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CTA Button -->
            <div class="form-group fb-modal__border-box_dropdown open">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">
                        CTA Button
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-modal__handler">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <div class="fb-modal__border-row fb-modal__border-row_menu" style="display: block">
                    <div class="fb-form">
<!--                        <div class="fb-form__caption">-->
<!--                            <span class="fb-form__middle">Button Text</span>-->
<!--                            <span class="fb-tooltip">-->
<!--                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>-->
<!--                                </span>-->
<!--                        </div>-->
                        <div class="fb-form__group">
                            <input type="text" value="Continue" class="form-control fb-form-control">
                            <span class="tag-box">
                                    <i class="fa fa-tag"></i>
                                </span>
                        </div>
                        <div class="fb-checkbox mt-3">
                            <input class="fb-checkbox__input" type="checkbox" id="showonly-option">
                            <label for="showonly-option" class="fb-checkbox__label">
                                <div class="fb-checkbox__box">
                                    <div class="fb-checkbox__inner-box"></div>
                                </div>
                                <div class="fb-checkbox__caption">
                                    Hide CTA button until the question is answered
<!--                                    Only show CTA button when question is answered-->
                                </div>
                            </label>
                        </div>
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
            <!--Settings-->
            <div class="form-group fb-modal__border-box_dropdown">
                <div class="tag-row">
                    <div class="tag-row__title">Settings</div>
                </div>
                <div class="fb-modal__row">
                    <div class="fb-modal__option fb-modal__option_light">
                        <span class="fb-modal__middle">Required</span>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input checked name="sticky_bar_active"
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
                <div class="fb-modal__row fb-modal__row_tb">
                    <div class="fb-modal__option fb-modal__option_light">
                        <span class="fb-modal__middle">Allow City or Zip Code</span>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input checked name="sticky_bar_active"
                                   type="checkbox"
                                   id="toggle-status"
                                   data-toggle="toggle"
                                   data-on="off"
                                   data-off="on"
                                   data-onstyle="off"
                                   data-offstyle="on" >
                        </div>
                    </div>
                </div>
                <div class="fb-modal__row fb-modal__row_tb">
                    <div class="fb-modal__option fb-modal__option_light">
                        <span class="fb-modal__middle">Require U.S. Zip Code</span>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input checked name="sticky_bar_active"
                                   type="checkbox"
                                   id="toggle-status"
                                   data-toggle="toggle"
                                   data-on="off"
                                   data-off="on"
                                   data-onstyle="off"
                                   data-offstyle="on" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
        <div class="panel-aside__footer">
            <div class="action">
                <ul class="action__list justify-content-end">
                    <li class="action__item">
                        <button class="button button-cancel">Close</button>
                    </li>
                    <li class="action__item">
                        <button class="button button-secondary">Save</button>
                    </li>
                </ul>
            </div>
        </div>
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
                content of the page
                <!-- content of the page -->

                <!-- content of the page -->
            </section>
        </main>
    </div>

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>