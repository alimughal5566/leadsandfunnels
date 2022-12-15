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
                <h4 class="panel-aside__title has-icon slider-icon">
                <span>
                    <i class="ico ico-expand head-icon"></i>
                    Slider
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
            <!-- Tabs -->
            <ul class="nav nav-tabs fb-tab" role="tablist">
                <li class="nav-item fb-tab__item">
                    <a href="#numeric" data-toggle="tab" role="tab" aria-controls="numeric" aria-selected="true" class="fb-tab__link fb-tab__link_active">
                        numeric
                    </a>
                </li>
                <li class="nav-item fb-tab__item">
                    <a href="#non-numeric" data-toggle="tab" role="tab" aria-controls="non-numeric" aria-selected="false" class="fb-tab__link">
                        non-numeric
                    </a>
                </li>
            </ul>
            <div class="tab-content">

                <!-- Numeric tabs content-->

                <div id="numeric" role="tabpanel"  class="tab-pane fade show active">

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

                    <!-- Slider Setup -->

                    <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                        <div class="fb-modal__row">
                            <div class="fb-modal__option">
                                Slider Setup
                            </div>
                            <div class="fb-modal__control">
                                <div class="fb-modal__handler">
                                    <!-- <i class="fbi fbi_arrow"></i>-->
                                    <i class="fa fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="fb-modal__border-row fb-modal__border-row_ptb0 fb-modal__border-row_menu">
                            <ul class="nav nav-tabs fb-tab fb-tab_plr0" role="tablist">
                                <li class="fb-tab__item">
                                    <a href="#puck1" data-toggle="tab" class="fb-tab__link fb-tab__link_inner fb-tab__link_active">
                                        1-Puck Slider
                                    </a>
                                </li>
                                <li class="fb-tab__item">
                                    <a href="#puck2" data-toggle="tab" class="fb-tab__link fb-tab__link_inner">
                                        2-Puck Slider
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">

                                <!--Puck 1 Content-->

                                <div role="tabpanel" id="puck1" class="tab-pane fb-tab__tab-pane active">
                                    <div class="fb-form" >
                                        <div class="slider-range-clone slider-range-clone_puck1">
                                            <div class="slider-range-clone__item">
                                                    <span class="slider-range-clone__del">
                                                        <i class="ico ico-cross"></i>
                                                    </span>
                                                <div class="fb-form__caption">
                                                    <span class="fb-form__middle">Slider Range</span>
                                                </div>
                                                <div class="segment-grid">
                                                    <div class="segment-grid__item segment-grid__item_17">
                                                        <div class="fb-select-wrap">
                                                            <select class="fb-select fb-select_unit fb-select_slider" name="state">
                                                                <option value="$">$</option>
                                                                <option value="%">%</option>
                                                                <option value="#">#</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_41">
                                                        <input type="text" class="form-control fb-form-control">
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_41">
                                                        <input type="text" class="form-control fb-form-control">
                                                    </div>
                                                </div>
                                                <div class="segment-grid">
                                                    <div class="segment-grid__item segment-grid__item_43">
                                                        <div class="fb-select-wrap fb-select2-group">
                                                            <select class="fb-select fb-select_by fb-select_slider" name="state">
                                                                <option value="subranges">By: Subranges</option>
                                                                <option value="increment">By: Increment</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_56">
                                                        <input type="text" class="form-control fb-form-control">
                                                    </div>
                                                </div>
                                                <div class="segment-grid">
                                                    <div class="segment-grid__item segment-grid__item_94">
                                                        <div class="fb-select-wrap fb-select2-group fb-select2-group_space">
                                                            <select class="fb-select fb-select_start fb-select_slider" name="state">
                                                                <option value="0">Starting Number Ends with: 0</option>
                                                                <option value="1">Starting Number Ends with: 1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_6">

                                                        <span class="fb-tooltip">
                                                            <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fb-options__add-more fb-options__add-more_h84">
                                        <a href="#" id="add-slider-range" class="lp-btn lp-btn_add-option add-slider-range button-primary border-0">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-plus"></i>
                                                </span>
                                            Add New Segment
                                        </a>
                                    </div>

                                    <!-- Customize Slider Labels -->

                                    <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
                                        <div class="fb-modal__row">
                                            <div class="fb-modal__option fb-modal__option_light">
                                                <span class="fb-modal__middle">Customize Slider Labels</span>
                                                <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
                                            </div>
                                            <div class="fb-modal__control">
                                                <div class="fb-toggle">
                                                    <input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
                                        <div class="fb-modal__border-row fb-modal__border-row_sub-menu">
                                            <div class="slider-label">
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Left Label">
                                                </div>
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
                                                </div>
                                            </div>
                                            <div class="slider-label">
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Right Label">
                                                </div>
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slider Starting Point -->

                                    <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
                                        <div class="fb-modal__row">
                                            <div class="fb-modal__option fb-modal__option_light">
                                                <span class="fb-modal__middle">Slider Starting Point</span>
                                                <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
                                            </div>
                                            <div class="fb-modal__control">
                                                <div class="fb-toggle">
                                                    <input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
                                        <div class="fb-modal__border-row fb-modal__border-row_sub-menu">
                                            <div class="bs-slider">
                                                <input type="text" class="fb-slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-tooltip="hide">
                                                <div class="bs-slider__label-wrapper">
                                                    <span class="bs-slider__label">Left Label</span>
                                                    <span class="bs-slider__label">$100000</span>
                                                    <span class="bs-slider__label">Right Label</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Puck 2 Content-->

                                <div role="tabpanel" id="puck2" class="tab-pane fb-tab__tab-pane fade">
                                    <div class="fb-form">
                                        <div class="slider-range-clone">
                                            <div class="slider-range-clone__item">
                                                    <span class="slider-range-clone__del">
                                                        <i class="ico ico-cross"></i>
                                                    </span>
                                                <div class="fb-form__caption">
                                                    <span class="fb-form__middle">Slider Range</span>
                                                </div>
                                                <div class="segment-grid">
                                                    <div class="segment-grid__item segment-grid__item_17">
                                                        <select class="fb-select fb-select_unit fb-select_slider" name="state">
                                                            <option value="$">$</option>
                                                            <option value="%">%</option>
                                                            <option value="#">#</option>
                                                        </select>
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_41">
                                                        <input type="text" class="form-control fb-form-control">
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_41">
                                                        <input type="text" class="form-control fb-form-control">
                                                    </div>
                                                </div>
                                                <div class="segment-grid">
                                                    <div class="segment-grid__item segment-grid__item_43">
                                                        <div class="fb-select2-group">
                                                            <select class="fb-select fb-select_by fb-select_slider" name="state">
                                                                <option value="subranges">By: Subranges</option>
                                                                <option value="increment">By: Increment</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_56">
                                                        <input type="text" class="form-control fb-form-control">
                                                    </div>
                                                </div>
                                                <div class="segment-grid">
                                                    <div class="segment-grid__item segment-grid__item_94">
                                                        <div class="fb-select2-group fb-select2-group_space">
                                                            <select class="fb-select fb-select_start fb-select_slider" name="state">
                                                                <option value="0">Starting Number Ends with: 0</option>
                                                                <option value="1">Starting Number Ends with: 1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="segment-grid__item segment-grid__item_6">
                                                            <span class="fb-tooltip">
                                                                <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fb-options__add-more fb-options__add-more_h84">
                                        <a href="#" id="add-slider-range" class="lp-btn lp-btn_add-option add-slider-range button-primary border-0">
                                                <span class="lp-btn__icon">
                                                    <i class="ico ico-plus"></i>
                                                </span>
                                            Add New Segment
                                        </a>
                                    </div>
                                    <!-- Puck2 Customize Slider Labels -->

                                    <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
                                        <div class="fb-modal__row">
                                            <div class="fb-modal__option fb-modal__option_light">
                                                <span class="fb-modal__middle">Customize Slider Labels</span>
                                                <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
                                            </div>
                                            <div class="fb-modal__control">
                                                <div class="fb-toggle">
                                                    <input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
                                        <div class="fb-modal__border-row fb-modal__border-row_sub-menu">
                                            <div class="slider-label">
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Left Label">
                                                </div>
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
                                                </div>
                                            </div>
                                            <div class="slider-label">
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Right Label">
                                                </div>
                                                <div class="slider-label__col-6">
                                                    <input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Puck2 Slider Starting Point -->

                                    <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
                                        <div class="fb-modal__row">
                                            <div class="fb-modal__option fb-modal__option_light">
                                                <span class="fb-modal__middle">Slider Starting Point</span>
                                                <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
                                            </div>
                                            <div class="fb-modal__control">
                                                <div class="fb-toggle">
                                                    <input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
                                        <div class="fb-modal__border-row fb-modal__border-row_sub-menu">
                                            <div class="bs-slider">
                                                <input type="text" class="fb-slider" data-slider-min="10" data-slider-max="200000" data-slider-step="1"  data-slider-value="[60000,150000]" data-slider-tooltip="hide">
                                                <div class="bs-slider__label-wrapper">
                                                    <span class="bs-slider__label">Left Label</span>
                                                    <span class="bs-slider__label">$100000 to $200000</span>
                                                    <span class="bs-slider__label">Right Label</span>
                                                </div>
                                            </div>
                                        </div>
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
                                           data-offstyle="on" >
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
                    <!-- Settings -->

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
                    </div>

                    <!-- slider range shorts -->

                    <div class="form-group fb-modal__border-box_dropdown">
                        <div class="fb-modal__row">
                            <div class="fb-modal__option">Show Thousands as K</div>
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
                    </div>
                    <div class="form-group fb-modal__border-box_dropdown">
                        <div class="fb-modal__row">
                            <div class="fb-modal__option">Show Millions as M</div>
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
                    </div>
                    <div class="form-group fb-modal__border-box_dropdown">
                        <div class="fb-modal__row">
                            <div class="fb-modal__option">Show Billions as B</div>
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
                    </div>
                </div>

                <!-- Non-Numeric tabs content-->

                <div id="non-numeric" role="tabpanel" class="tab-pane fade">

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
                                           data-offstyle="on" >
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

                    <!-- Slider Setup -->

                    <div class="form-group fb-modal__border-box fb-modal__border-box_dropdown">
                        <div class="fb-modal__row">
                            <div class="fb-modal__option">
                                Slider Setup
                            </div>
                            <div class="fb-modal__control">
                                <div class="fb-modal__handler">
                                    <!-- <i class="fbi fbi_arrow"></i>-->
                                    <i class="fa fa-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="fb-modal__border-row fb-modal__border-row_pb0 fb-modal__border-row_menu">
                            <div class="tab-content">
                                <div class="fb-form">
                                    <div class="fb-form__caption">
                                        <span class="fb-form__middle">Custom Values</span>
                                    </div>
                                </div>
                                <div class="fb-options">
                                    <div class="fb-options__clone">
                                        <div class="fb-options__list">
                                            <div class="fb-options__col fb-options__col_field">
                                                <input type="text" class="form-control fb-form-control">
                                            </div>
                                            <div class="fb-options__col fb-options__col_handler">
                                                    <span class="tag-box tag-box_move tag-box_lg">
<!--                                                        <i class="fbi fbi_drag-dark"></i>-->
                                                        <i class="ico ico-dragging"></i>
                                                    </span>
                                            </div>
                                            <div class="fb-options__col">
                                                <a href="#" class="fb-options__delete">
                                                        <span class="tag-box tag-box_lg">
<!--                                                            <i class="fbi fbi_cross-dark"></i>-->
                                                            <i class="ico ico-cross"></i>
                                                        </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fb-options__add-more">
                                        <a href="#" class="lp-btn lp-btn_add-option">
                                                <span class="lp-btn__icon">
<!--                                                    <i class="fbi fbi_plus-sm"></i>-->
                                                    <i class="ico ico-plus"></i>
                                                </span>
                                            Add New Value
                                        </a>
                                    </div>
                                </div>

                                <!-- Customize Slider Labels -->

                                <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
                                    <div class="fb-modal__row">
                                        <div class="fb-modal__option fb-modal__option_light">
                                            <span class="fb-modal__middle">Customize Slider Labels</span>
                                            <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
                                        </div>
                                        <div class="fb-modal__control">
                                            <div class="fb-toggle">
                                                <input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
                                    <div class="fb-modal__border-row fb-modal__border-row_sub-menu">
                                        <div class="slider-label">
                                            <div class="slider-label__col-6">
                                                <input type="text" class="form-control fb-form-control" placeholder="Left Label">
                                            </div>
                                            <div class="slider-label__col-6">
                                                <input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
                                            </div>
                                        </div>
                                        <div class="slider-label">
                                            <div class="slider-label__col-6">
                                                <input type="text" class="form-control fb-form-control" placeholder="Right Label">
                                            </div>
                                            <div class="slider-label__col-6">
                                                <input type="text" class="form-control fb-form-control" placeholder="Slider Shows">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slider Starting Point -->

                                <div class="fb-modal__border-box fb-modal__border-box_plr0 fb-modal__border-box_sub-dropdown">
                                    <div class="fb-modal__row">
                                        <div class="fb-modal__option fb-modal__option_light">
                                            <span class="fb-modal__middle">Slider Starting Point</span>
                                            <span class="fb-tooltip">
                                                    <span class="question-mark question-mark_modal question-mark_tooltip" title="Tooltip Content">?</span>
                                                </span>
                                        </div>
                                        <div class="fb-modal__control">
                                            <div class="fb-toggle">
                                                <input class="fb-inner-dd-toggle" name="sticky_bar_active"
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
                                    <div class="fb-modal__border-row fb-modal__border-row_sub-menu">
                                        <div class="bs-slider">
                                            <input type="text" class="fb-slider" data-slider-min="10" data-slider-max="200000" data-slider-step="1"  data-slider-value="[60000,150000]" data-slider-tooltip="hide">
                                            <div class="bs-slider__label-wrapper">
                                                <span class="bs-slider__label">Left Label</span>
                                                <span class="bs-slider__label">$100000 to $200000</span>
                                                <span class="bs-slider__label">Right Label</span>
                                            </div>
                                        </div>
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
                                    <input class="fb-checkbox__input" type="checkbox" id="showonly-option-non-n">
                                    <label for="showonly-option-non-n" class="fb-checkbox__label">
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
                                           data-offstyle="on" >
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

                    <!-- Settings -->

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

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>