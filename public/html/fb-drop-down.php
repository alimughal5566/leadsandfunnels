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
            <h4 class="panel-aside__title has-icon dropdown-icon">
            <span>
                <i class="ico ico-oc799PIto head-icon"></i>
                Drop Down
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
            <!--Add Question Detail-->
            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">Question</div>
                    <div class="fb-modal__control fb-modal__control_middle">
                            <span class="fb-tooltip fb-tooltip_pb2">
                                <span class="question-mark question-mark_mr10 question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                        <div class="fb-toggle">
                            <input class="fb-field-label" name="sticky_bar_active"
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
            <!-- Field Label -->
            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">Field Label</div>
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
                        <div class="fb-form__caption">
                            <span class="fb-form__middle">Drop Down Field Label</span>
                            <span class="fb-tooltip">
                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                </span>
                        </div>
                        <div class="fb-form__group">
                            <input type="text" class="form-control fb-form-control" value="">
                            <span class="tag-box">
                                    <i class="fa fa-tag"></i>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Options -->
            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                <div class="fb-modal__row">
                    <div class="fb-modal__option">
                        Options
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-modal__handler">
                            <!-- <i class="fbi fbi_arrow"></i>-->
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
                <div class="fb-modal__border-row fb-modal__border-row_pb0 fb-modal__border-row_menu">
                    <div class="fb-none-opt p-0 border-0">
                        <div class="fb-checkbox">
                            <input class="fb-checkbox__input" type="checkbox" id="create-group">
                            <label for="create-group" class="fb-checkbox__label">
                                <div class="fb-checkbox__box">
                                    <div class="fb-checkbox__inner-box"></div>
                                </div>
                                <div class="fb-checkbox__caption">
                                    Create content groups
                                </div>
                            </label>
                        </div>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-options border-0 normal-option">
                        <div class="fb-form">
                            <textarea name="" id="" class="form-control fb-textarea fb-textarea_option" placeholder="Type in or paste your menu entries&nbsp;here (separated&nbsp;by&nbsp;line&nbsp;break)"></textarea>
                        </div>
                    </div>
                    <div class="fb-options fb-options_drop-down border-0 group-option">
                        <div class="fb-options__group-clone">
                            <div class="grouping-label">Group 1</div>
                            <div class="group-head">
                                <div class="fb-form__group">
                                    <input type="text" class="form-control fb-form-control">
                                    <span class="tag-box">
                                        <i class="fas fa-folder-open"></i>
                                </span>
                                </div>
                                <div class="fb-options__col">
                                    <a href="#" class="fb-options__delete">
                                        <i class="ico ico-cross"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="fb-options__clone">
                                <textarea name="" id="" class="form-control fb-textarea fb-textarea_option" placeholder="Type in or paste your menu entries&nbsp;here (separated&nbsp;by&nbsp;line&nbsp;break)"></textarea>
                            </div>
                        </div>
                        <div class="fb-modal__row_creat-group">
                            <div class="fb-modal__row">
                                <a href="javascript:void();" class="lp-btn lp-btn_add-option_group lp-btn_drop-down button-primary">
                                    <span class="lp-btn__icon">
                                        <i class="ico ico-plus"></i>
                                    </span>
                                    Add New Group
                                </a>
                                <a data-toggle="modal" href="#group-organize-pop" class="lp-btn lp-btn_add-option_organize button-primary">
                                    <span class="lp-btn__icon">
                                        <i class="ico ico-plus"></i>
                                    </span>
                                    Organize
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="fb-modal__row">
                        <div class="fb-modal__option">Multiple​ ​Selections</div>
                        <div class="fb-modal__control">
                            <div class="fb-toggle">
                                <input name="sticky_bar_active"
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
                </div>

            </div>
            <!-- CTA Button -->
            <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown open">
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
                        <div class="fb-form__caption">
                            <span class="fb-form__middle">Button Text</span>
                            <span class="fb-tooltip">
                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                </span>
                        </div>
                        <div class="fb-form__group">
                            <input type="text" class="form-control fb-form-control">
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

            <div class="form-group fb-modal__border-box fb-modal__border-box_bm_none">
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
                            <input name="sticky_bar_active"
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
                <div class="fb-modal__row fb-modal__row_tb">
                    <div class="fb-modal__option fb-modal__option_light">
                        <span class="fb-modal__middle">Alphabetize</span>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input name="sticky_bar_active"
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
                        <span class="fb-modal__middle">Randomize</span>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input name="sticky_bar_active"
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
                        <span class="fb-modal__middle">Search Mode</span>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input name="search-mode"
                                   type="checkbox"
                                   id="search-mode"
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
                        <span class="fb-modal__middle">Automatic Progress</span>
                        <span class="fb-tooltip">
                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                            </span>
                    </div>
                    <div class="fb-modal__control">
                        <div class="fb-toggle">
                            <input name="sticky_bar_active"
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
                <!-- content of the page -->

                <!-- content of the page -->
            </section>
        </main>
    </div>

    <div class="modal fade organize-pop" id="group-organize-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Organize Groups</h5>
                </div>
                <div class="modal-body">
                    <div class="organize-group">
                        <ul class="organize-group__head">
                            <span>Group Name</span>
                            <span>Options</span>
                        </ul>
                        <ul class="organize-group__list">
                            <li class="organize-group__item">
                                <span class="organize-group__name">Real estate property types</span>
                                <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                            </li>
                            <li class="organize-group__item">
                                <span class="organize-group__name">Luxurious car brands</span>
                                <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                            </li>
                            <li class="organize-group__item">
                                <span class="organize-group__name">Select your hometown</span>
                                <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                            </li>
                            <li class="organize-group__item">
                                <span class="organize-group__name">Select market value</span>
                                <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                            </li>
                            <li class="organize-group__item">
                                <span class="organize-group__name">Tax rates</span>
                                <span class="organize-group__action">
                                    <i class="ico ico-dragging"></i>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Cancel</button>
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
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>