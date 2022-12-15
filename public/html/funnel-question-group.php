<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
<div class="panel-aside">
    <div class="pannel-aside-wrap">
        <div class="panel-aside-holder">
            <div class="standard-question-option-parent-group">
                <div class="standard-question-option-parent-group-wrap el-tooltip" title='<div class="select-question-tooltip">More cool stuff coming soon!</div>'>
                    <select id="question-select-group" class="form-control standard-question-option-group">
                        <option value="-1">CHOOSE QUESTION TYPE</option>
                        <option value="1" selected>Standard Questions</option>
                        <option value="2">Transitions</option>
                    </select>
                </div>
            </div>
            <div class="panel-aside__body-holder">
                <div class="panel-aside__body">
                    <div class="question-option">
                        <div class="question-option-scroll">
                            <div class="question-standard">
                                <ul class="custom-accordion">
                                    <li class="custom-accordion__list">
                                        <a href="#" class="custom-accordion__opener active">Most Popular <i class="ico ico-arrow-down"></i></a>
                                        <div class="custom-accordion__slide" style="display: block">
                                            <div class="question-option-list">
                                                <div class="address-item question-list-item" data-icon="address">
                                                    <span class="question-text address"><span class="sub-text">address</span></span>
                                                </div>
                                                <div class="birthday-item question-list-item" data-icon="birthday">
                                                    <span class="question-text birthday"><span class="sub-text">birthday</span></span>
                                                </div>
                                                <div class="contact-item question-list-item" data-icon="contact">
                                                    <span class="question-text contact"><span class="sub-text">Contact</span></span>
                                                </div>
                                                <div class="cta-message-item question-list-item" data-icon="cta-message">
                                                    <span class="question-text cta-message"><span class="sub-text">cta message</span></span>
                                                </div>
                                                <div class="date-picker-item question-list-item" data-icon="date-picker">
                                                    <span class="question-text date-picker"><span class="sub-text">date picker</span></span>
                                                </div>
                                                <div class="dropdown-item question-list-item" data-icon="dropdown">
                                                    <span class="question-text dropdown"><span class="sub-text">Drop Down</span></span>
                                                </div>
                                                <div class="hidden-field-item question-list-item" data-icon="hidden-field">
                                                    <span class="question-text hidden-field"><span class="sub-text">Hidden Field</span></span>
                                                </div>
                                                <div class="menu-item question-list-item" data-icon="menu">
                                                    <span class="question-text menu"><span class="sub-text">menu</span></span>
                                                </div>
                                                <div class="number-item question-list-item" data-icon="number">
                                                    <span class="question-text number"><span class="sub-text">number</span></span>
                                                </div>
                                                <div class="group-item question-list-item" data-icon="group">
                                                    <span class="question-text group"><span class="sub-text">question group</span></span>
                                                </div>
                                                <div class="slider-item question-list-item" data-icon="slider">
                                                    <span class="question-text slider"><span class="sub-text">slider</span></span>
                                                </div>
                                                <div class="text-field-item-iframe question-list-item" data-icon="text-field">
                                                    <span class="question-text text-field"><span class="sub-text">Text Field</span></span>
                                                </div>
                                                <div class="time-picker-item question-list-item" data-icon="time-picker">
                                                    <span class="question-text time-picker"><span class="sub-text">time picker</span></span>
                                                </div>
                                                <div class="zip-code-item question-list-item" data-icon="zip-code">
                                                    <span class="question-text zip-code"><span class="sub-text">zip code</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="custom-accordion__list">
                                        <a href="#" class="custom-accordion__opener">More Options <i class="ico ico-arrow-down"></i></a>
                                        <div class="custom-accordion__slide">
                                            <div class="question-option-list">
                                                <div class="address-item question-list-item" data-icon="address" disabled>
                                                    <span class="question-text address"><span class="sub-text">address</span></span>
                                                </div>
                                                <div class="birthday-item question-list-item" data-icon="birthday" disabled>
                                                    <span class="question-text birthday"><span class="sub-text">birthday</span></span>
                                                </div>
                                                <div class="cta-message-item question-list-item" data-icon="cta-message" disabled>
                                                    <span class="question-text cta-message"><span class="sub-text">cta message</span></span>
                                                </div>
                                                <div class="bundle-item question-list-item" data-icon="bundle">
                                                    <span class="question-text bundle"><span class="sub-text">Vehicle Make & Model</span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="question-transition">
                                <div class="placeholder">
                                    <p>You have not created any kind of transition&nbsp;yet.</p>
                                    <div class="create-question">
                                        <a class="btn-create" href="#create-transition-pop" data-toggle="modal">
                                            create your first transition
                                        </a>
                                    </div>
                                </div>
                                <div class="question-option-list">
                                    <div class="transition-item question-list-item" data-icon="transition">
                                        <span class="question-text transition"><span class="sub-text">Short transition</span></span>
                                    </div>
                                    <div class="transition-item question-list-item" data-icon="transition">
                                        <span class="question-text transition"><span class="sub-text">Circle loader</span></span>
                                    </div>
                                    <div class="transition-item question-list-item" data-icon="transition">
                                        <span class="question-text transition"><span class="sub-text">3 Dots</span></span>
                                    </div>
                                </div>
                                <div class="create-question">
                                    <a class="btn-create" href="#create-transition-pop" data-toggle="modal">
                                        create new transition
                                    </a>
                                </div>
                                <div class="manage-question">
                                    <a class="btn-manage" href="#manage-transition-pop" data-toggle="modal">
                                        manage global transition
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Questions / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Questions / Funnel" data-lp-wistia-key="ji1qu22nfq" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span>
                            Watch how to video
                        </a>
                    </div>
                </div>
                <!-- content of the page -->
                <div class="funnel-wrap">
                    <div class="funnel-panel">
                        <div class="funnel-panel__head-wrap">
                            <div class="funnel-panel__head">
                                <h2 class="funnel-panel__title">
                                    Funnel Questions
                                    <span class="question-mark-wrap">
                                        <span class="question-mark el-tooltip" title="TOOLTIP CONTENT" data-tooltip-content="#tooltip_seamlesscontent">
                                            <span class="ico ico-question"></span>
                                        </span>
                                    </span>
                                </h2>
                                <ul class="funnel-panel__options">
                                    <li class="funnel-panel__item edit-funnel">
                                        <a href="#homepage-cta-message-pop" data-toggle="modal" class="btn panel-button__btn"> <i class="ico ico-promote"></i>
                                            <span class="opt-text">Edit Homepage CTA Message <span class="on-text">(ON)</span></span>
                                        </a>
                                    </li>
                                    <li class="funnel-panel__item logic">
                                        <a href="#" data-toggle="modal" data-target="#conditional-logic-group" class="btn panel-button__btn">
                                            <i class="lp-icon-conditional-logic lp-icon-conditional-logic_pt3 ico-back"></i>
                                            <span class="opt-text">Conditional Logic  <span class="on-text">(ON)</span></span>
                                        </a>
                                    </li>
                                    <li class="funnel-panel__item leads">
                                        <a href="#partial-leads-pop" data-toggle="modal" class="btn panel-button__btn">
                                            <i class="lp-icon-users ico-multi-user"></i>
                                            <span class="opt-text">Partial Leads</span>
                                        </a>
                                    </li>
                                    <li class="funnel-panel__item reset">
                                        <a href="#reset-default-pop" data-toggle="modal" class="btn panel-button__btn">
                                            <i class="lp-icon-refresh ico-reload"></i>
                                            <span class="opt-text">Reset to Default Provided Questions</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="funnel-body-scroll-group">
                            <div class="funnel-panel__body">
                                <div class="funnel-panel__sortable funnel-panel__sortable-wrap dropable-funnel-option">
                                    <div class="funnel-panel__placeholder dropable-funnel-option placeholder">
                                        <h2 class="funnel-panel__placeholder-title">You have not added any questions yet.</h2>
                                        <p class="funnel-panel__placeholder-dsc">Drag and drop questions from sidebar to add them to your Funnel.</p>
                                    </div>
                                </div>
                                <div class="funnel-panel__lock">
                                    <div class="fb-question-item fb-question-item_steps fb-question-item_lock fb-question-item_contact-info">
                                        <div class="question-item single-question-slide">
                                            <div class="fb-question-item__serial"></div>
                                            <div class="fb-question-item__detail">
                                                <div class="fb-question-item__col">
                                                    <div class="question-text contact"><span class="sub-text">Contact</span></div>
                                                </div>
                                                <div class="fb-question-item__col fb-question-item__col_plr14">
                                                    <label class="fb-step-label">3 - STEP</label>
                                                </div>
                                                <div class="fb-question-item__col fb-question-item__col__steps">
                                                    <div class="fb-step">
                                                        <div class="fb-step__title">Step 1:</div>
                                                        <ul class="fb-step__list">
                                                            <li class="fb-step__list__item">First Name</li>
                                                            <li class="fb-step__list__item">Email Address</li>
                                                        </ul>
                                                    </div>
                                                    <div class="fb-step">
                                                        <div class="fb-step__title">Step 2:</div>
                                                        <ul class="fb-step__list">
                                                            <li class="fb-step__list__item">Email Address</li>
                                                        </ul>
                                                    </div>
                                                    <div class="fb-step">
                                                        <div class="fb-step__title">Step 3:</div>
                                                        <ul class="fb-step__list">
                                                            <li class="fb-step__list__item">Phone Number</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="fb-question-item__col fb-question-item__col_control">
                                                    <a href="#" class="hover-hide">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                    <ul class="lp-control">
                                                        <li class="lp-control__item">
                                                            <a title="conditional&nbsp;logic" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                                <i class="lp-icon-conditional-logic ico-back"></i>
                                                            </a>
                                                        </li>
                                                        <li class="lp-control__item lp-control__item_edit">
                                                            <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                                <i class="ico-edit"></i>
                                                            </a>
                                                        </li>
                                                        <li class="lp-control__item">
                                                            <a title="duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                                <i class="ico-copy"></i>
                                                            </a>
                                                        </li>
                                                        <li class="lp-control__item">
                                                            <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">
                                                                <i class="ico-dragging"></i>
                                                            </a>
                                                        </li>
                                                        <li class="lp-control__item">
                                                            <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#confirmation-delete" data-toggle="modal">
                                                                <i class="ico-cross"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="fb-question-item__col fb-question-item__col_lock">
                                                    <a href="#">
                                                        <i class="lp-icon-lock ico-lock"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="funnel-panel-hidden__sortable">
                                <strong class="hidden-layer-title"><span class="text-wrap">hidden fields</span></strong>
                            </div>
                        </div>
                    </div>
                    <!-- Thank you page Listing -->
                    <div class="funnel-panel funnel-panel_thankyou funnel-body-thankyou-group">
                        <div class="funnel-panel__head">
                            <h2 class="funnel-panel__title">
                                Thank You Page
                            </h2>
                        </div>
                        <div class="funnel-panel__body">
                            <div class="funnel-panel__ty_sortable">
                                <div class="fb-question-item fb-question-item_lock">
                                    <div class="question-item single-question-slide">
                                        <div class="fb-question-item__serial"></div>
                                        <div class="fb-question-item__detail">
                                            <div class="fb-question-item__col">
                                                <div class="question-text thankyou">
                                                    <span class="sub-text">Thank you</span>
                                                </div>
                                            </div>
                                            <div class="fb-question-item__col">
                                                <div class="tu-url">
                                                    <div class="tu-url__url">Default Success Message</div>
                                                </div>
                                            </div>
                                            <div class="fb-question-item__col fb-question-item__col_control">
                                                <a href="#" class="hover-hide">
                                                    <i class="fbi fbi_dots">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </i>
                                                </a>
                                                <ul class="lp-control">
                                                    <li class="lp-control__item">
                                                        <a title="conditional&nbsp;logic" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                            <i class="lp-icon-conditional-logic ico-back"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item lp-control__item_edit">
                                                        <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                            <i class="ico-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item">
                                                        <a title="duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                            <i class="ico-copy"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item">
                                                        <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">
                                                            <i class="ico-dragging"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item">
                                                        <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                            <i class="ico-cross"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="fb-question-item__col fb-question-item__col_lock">
                                                <a href="#">
                                                    <i class="lp-icon-lock ico-lock"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="funnel-panel__add">
                        <div class="add-box add-box_page" data-toggle="modal" data-target="#fb-thank-you">
                            <i class="lp-icon-plus lp-icon-plus_large ico-plus"></i>
                            <span class="add-box__text">Add New Page</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Conditional Logic Group Modal -->
    <div class="modal fade conditional-logic-group-modal" id="conditional-logic-group">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title-holder">
                        <strong class="modal-title">Conditional Logic</strong>
                        <span class="text">Offer intelligent Funnels to your users based on their selections</span>
                    </div>
                    <div class="switcher-min">
                        <div class="funnel-checkbox">
                            <label class="checkbox-label">
                                <input class="fb-field-label" type="checkbox" checked>
                                <span class="checkbox-area">
                                    <span class="handle"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-body-wrap">
                    <div class="modal-body quick-scroll">
                        <div class="modal-body-inner">
                            <div class="conditional-select-area">
                                <div class="conditional-select-wrap">
                                    <div class="form-group">
                                        <label class="label-text">IF</label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-question-parent select2-parent select2js__nice-scroll">
                                                    <select class="select-question">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="label-text"></label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-conditional-parent select2-parent select2js__nice-scroll disabled">
                                                    <select class="select-conditional">
                                                        <option value="1">Select conditional</option>
                                                        <option value="is">Is</option>
                                                        <option value="is-not">Is not</option>
                                                        <option value="is-any">Is any of</option>
                                                        <option value="is-none">Is none of</option>
                                                        <option value="is-known">Is known</option>
                                                        <option value="is-unknown">Is unknown</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="label-text"></label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-answer-parent select2-parent select2js__nice-scroll disabled">
                                                    <select class="select-answer">
                                                        <option value="answer-option">Select Answer</option>
                                                        <option value="zip-option">Enter Zip Code(s)</option>
                                                        <option value="state-option">Select States From a List</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="zip-code-field-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <textarea class="form-control-textarea" placeholder="Type in Zip Code(s)"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area two-cols">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="select-code-field-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <a href="#" data-toggle="modal" data-target="#select-state-modal" class="select-states-opener">Select States <i class="arrow"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="conditional-select-area">
                                <div class="conditional-select-wrap hidden">
                                    <div class="form-group mb-0">
                                        <label class="label-text">THEN</label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-action-parent-alt select2-parent select2js__nice-scroll">
                                                    <select class="select-action-alt">
                                                        <option value="0">Select Action</option>
                                                        <option value="1">Show Question</option>
                                                        <option value="2">Hide Question</option>
                                                        <option value="3">Show Specific Thank You Page</option>
                                                        <option value="4">Change Lead Alert Recipient</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="btn-wrap">
                                                <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="show-queston-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="show-question-parent-alt select2-parent select2js__nice-scroll">
                                                        <select class="show-question-alt">
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recipients-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <div data-toggle="modal" data-target="#select-recipient-modal"
                                                             class="select-receipient-opener quick-scroll">
                                                            <div class="scroll-wrap">
                                                                <span class="placeholder-text">Select Recipients</span>
                                                                <ul class="list-tags">
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                </ul>
                                                                <i class="arrow"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="conditional-select-wrap">
                                    <div class="form-group mb-0">
                                        <label class="label-text">THEN</label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-action-parent select2-parent select2js__nice-scroll">
                                                    <select class="select-action">
                                                        <option value="0">Select Action</option>
                                                        <option value="1">Show Question</option>
                                                        <option value="2">Hide Question</option>
                                                        <option value="3">Show Specific Thank You Page</option>
                                                        <option value="4">Change Lead Alert Recipient</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="btn-wrap">
                                                <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="show-queston-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="show-question-parent select2-parent select2js__nice-scroll">
                                                        <select class="show-question">
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recipients-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <div data-toggle="modal" data-target="#select-recipient-modal"
                                                           class="select-receipient-opener quick-scroll">
                                                            <div class="scroll-wrap">
                                                                <span class="placeholder-text">Select Recipients</span>
                                                                <ul class="list-tags">
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                </ul>
                                                                <i class="arrow"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="conditional-select-area other-case-parent">
                                <div class="conditional-select-wrap">
                                    <div class="form-group other-case mb-0">
                                        <label class="label-text"><span>In</span> ALL <span>other cases</span></label>
                                        <div class="select-area">
                                            <div class="select-field">
                                                <div class="select-action-other-parent select2-parent select2js__nice-scroll">
                                                    <select class="select-action-other">
                                                        <option value="0">Select Action</option>
                                                        <option value="1">Show Question</option>
                                                        <option value="2">Hide Question</option>
                                                        <option value="3">Show Specific Thank You Page</option>
                                                        <option value="4">Change Lead Alert Recipient</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="show-queston-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="show-question-parent select2-parent select2js__nice-scroll">
                                                        <select class="show-question">
                                                        </select>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recipients-slide" style="display: none">
                                        <div class="form-group">
                                            <label class="label-text"></label>
                                            <div class="select-area">
                                                <div class="select-field">
                                                    <div class="input-field">
                                                        <div data-toggle="modal" data-target="#select-recipient-modal"
                                                             class="select-receipient-opener quick-scroll">
                                                            <div class="scroll-wrap">
                                                                <span class="placeholder-text">Select Recipients</span>
                                                                <ul class="list-tags">
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="tag-item">Rosa Romaine</span>
                                                                        <span class="remove-tag">×</span>
                                                                    </li>
                                                                </ul>
                                                                <i class="arrow"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="btn-wrap">
                                                    <a href="#" class="add-row"><i class="ico-plus"></i></a>
                                                    <a href="#" class="remove-row"><i class="ico-cross"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" data-toggle="modal" data-target="#active-condition-modal" class="active-condition-link">active conditions</a>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">cancel</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary" type="submit">save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select State Modal -->
    <div class="modal fade select-state-modal conditional-logic-modals" id="select-state-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title">Select States</strong>
                </div>
                <div class="modal-body">
                    <div class="search-area">
                        <div class="input-holder">
                            <input type="search" class="form-control" placeholder="Type in the State Name ...">
                            <button type="submit" class="search-btn"><i class="ico-search"></i></button>
                        </div>
                    </div>
                    <div class="check-area">
                        <div class="check-head">
                            <div class="checkbox-wrap">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="state-all-checked">
                                    <span class="checkbox-text"><i class="icon"></i> Select all States</span>
                                </label>
                            </div>
                            <a href="#" class="reset-btn state-reset-btn"><i class="ico-undo"></i>reset</a>
                        </div>
                        <div class="check-body">
                            <div class="check-list-wrap">
                                <ul class="check-list">
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Alabama</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Alaska</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Arizona</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Arkansas</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>California</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Colorado</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Connecticut</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Delaware</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Florida</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Georgia</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Colorado</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Connecticut</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Delaware</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Florida</span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="state-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Georgia</span>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel state-modal-close" data-dismiss="modal">close</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary state-save-btn" type="submit" disabled>select</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Recipient Modal -->
    <div class="modal fade select-recipient-modal conditional-logic-modals" id="select-recipient-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title">Select Recipient(s)</strong>
                </div>
                <div class="modal-body">
                    <div class="search-area">
                        <div class="recipient-select-parent select2-parent">
                            <select class="recipient-select">
                                <option value="1">Search by Name</option>
                                <option value="2">Search by Tags</option>
                            </select>
                        </div>
                        <div class="input-holder">
                            <input type="search" class="form-control" placeholder="Type in the Recipient Name ...">
                            <button type="submit" class="search-btn"><i class="ico-search"></i></button>
                        </div>
                    </div>
                    <div class="check-area">
                        <div class="check-head">
                            <div class="checkbox-wrap">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="recipient-all-checked">
                                    <span class="checkbox-text"><i class="icon"></i>Select all Recipients</span>
                                </label>
                            </div>
                            <a href="#" class="reset-btn recipient-reset-btn"><i class="ico-undo"></i>reset</a>
                        </div>
                        <div class="check-body">
                            <div class="check-list-wrap">
                                <ul class="check-list">
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Rosa Romaine</span>
                                            </label>
                                        </div>
                                        <span class="email">rosaromaine@gmail.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Christian Steverson</span>
                                            </label>
                                        </div>
                                        <span class="email">csteverson@gmail.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Peter Barankiewicz</span>
                                            </label>
                                        </div>
                                        <span class="email">peter.b@mail.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Gabe Stathopoulos</span>
                                            </label>
                                        </div>
                                        <span class="email">gabe.stat@yahoo.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Sammie Lombardi</span>
                                            </label>
                                        </div>
                                        <span class="email">sammie.office@sebonix.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Charles Dean</span>
                                            </label>
                                        </div>
                                        <span class="email">charlesdean@wix.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Suzanne LaFlamme</span>
                                            </label>
                                        </div>
                                        <span class="email">suzanne.lf@mortgage.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Josh Nevelson</span>
                                            </label>
                                        </div>
                                        <span class="email">josh.info@office.biz</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>James Keeline</span>
                                            </label>
                                        </div>
                                        <span class="email">james2010@realestate.biz</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Remi Newman</span>
                                            </label>
                                        </div>
                                        <span class="email">newman.r@realestate.biz</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Rosa Romaine</span>
                                            </label>
                                        </div>
                                        <span class="email">rosaromaine@gmail.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Sammie Lombardi</span>
                                            </label>
                                        </div>
                                        <span class="email">sammie.office@sebonix.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Charles Dean</span>
                                            </label>
                                        </div>
                                        <span class="email">charlesdean@wix.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Suzanne LaFlamme</span>
                                            </label>
                                        </div>
                                        <span class="email">suzanne.lf@mortgage.com</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Josh Nevelson</span>
                                            </label>
                                        </div>
                                        <span class="email">josh.info@office.biz</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>James Keeline</span>
                                            </label>
                                        </div>
                                        <span class="email">james2010@realestate.biz</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Remi Newman</span>
                                            </label>
                                        </div>
                                        <span class="email">newman.r@realestate.biz</span>
                                    </li>
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" class="recipient-checkbox">
                                                <span class="checkbox-text"><i class="icon"></i>Rosa Romaine</span>
                                            </label>
                                        </div>
                                        <span class="email">rosaromaine@gmail.com</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="new-recipient-opener" data-toggle="modal" data-target="#lead-recipients">add new recipient</a>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel recipient-modal-close" data-dismiss="modal">close</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary recipient-save-btn" type="submit" disabled>save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Recipient Modal -->
    <div class="modal fade lead-recipients-modal conditional-logic-modals-modals" id="lead-recipients-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="lead-recipients-form" method="post" action="#" class="lead-recipient-form">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Recipient</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="full-name" class="modal-lbl">Full Name</label>
                            <div class="input__holder">
                                <input type="text" id="full-name" name="full_name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email-address" class="modal-lbl">Email Address</label>
                            <div class="input__holder">
                                <input type="email" id="email-address" name="new_email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group cell-phone-field">
                            <label class="modal-lbl">Text Cellphone</label>
                            <div class="input__holder">
                                <div class="radio">
                                    <ul class="radio__list">
                                        <li class="radio__item">
                                            <input class="lp-popup-radio celphone-radio" type="radio" id="cell-text-yes" name="new-cell" value="y">
                                            <label class="radio__lbl" for="cell-text-yes" val="yes">Yes</label>
                                        </li>
                                        <li class="radio__item">
                                            <input class="lp-popup-radio celphone-radio" type="radio" id="cell-text-no" name="new-cell" value="n" checked>
                                            <label class="radio__lbl" for="cell-text-no" val="no">No</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="cell-number-slide">
                            <div class="form-group">
                                <label for="cel-number" class="modal-lbl">Cellphone Number</label>
                                <div class="input__holder">
                                    <input type="tel" id="cel-number" name="cell_number" placeholder="(___) ___-____" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="modal-lbl">
                                    Cell Carrier
                                </label>
                                <div class="input__holder">
                                    <div class="select2 select2js__cell-carrier-parent select2js__nice-scroll">
                                        <select id="cell_carrier" name="cell_carrier" class="form-control select2js__cell-carrier">
                                            <option value="">Select</option>
                                            <option value="message.alltel.com">Alltel</option>
                                            <option value="txt.att.net">AT&amp;T</option>
                                            <option value="myboostmobile.com">Boost Mobile</option>
                                            <option value="myblue.com">Centennial Wireless</option>
                                            <option value="mms.mycricket.com">Cricket</option>
                                            <option value="einsteinmms.com">Einstein PCS</option>
                                            <option value="mymetropcs.com">Metro PCS</option>
                                            <option value="messaging.nextel.com">Nextel</option>
                                            <option value="omnipointpcs.com">Omnipoint</option>
                                            <option value="teleflip.com">Other</option>
                                            <option value="qwestmp.com">Qwest</option>
                                            <option value="messaging.sdiepcs.com">Sdie</option>
                                            <option value="messaging.sprintpcs.com">Sprint</option>
                                            <option value="tmomail.net">T-Mobile</option>
                                            <option value="utext.com">Unicell</option>
                                            <option value="email.uscc.net">US Celluar</option>
                                            <option value="vtext.com">Verizon</option>
                                            <option value="vmobl.com">Virgin Mobile</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-cancel lead-recipients-modal-close" data-dismiss="modal">Cancel</button>
                                </li>
                                <li class="action__item">
                                    <button id="edit-rcpt" type="submit" class="button button-primary add-recipient-btn">add recipient</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Active Condition Modal -->
    <div class="modal fade active-condition-modal conditional-logic-modals" id="active-condition-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Active Conditions: <span class="total-no">5</span></h5>
                    <div class="switcher-wrap">
                        <div class="switcher-min">
                            <div class="funnel-checkbox">
                                <label class="checkbox-label">
                                    <input class="fb-field-label" type="checkbox" checked>
                                    <span class="checkbox-area">
                                        <span class="handle"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="status-tooltip-block">
                            <div class="status-tooltip-wrap">
                                <strong class="title">conditions status </strong>
                                <ul class="condition-status-list">
                                    <li class="active">Active: <strong>4</strong> Conditions </li>
                                    <li class="inactive">Inactive: <strong>1</strong> Condition </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="search-area">
                        <div class="conditional-field-select-parent select2-parent">
                            <select class="conditional-field-select">
                                <option value="1">Search by: All Fields</option>
                                <option value="2">Search by: Fields</option>
                            </select>
                        </div>
                        <div class="input-holder">
                            <input type="search" class="form-control" placeholder="Enter a search query ....">
                            <button type="submit" class="search-btn"><i class="ico-search"></i></button>
                        </div>
                    </div>
                    <div class="check-area">
                        <div class="check-head">
                            <div class="checkbox-wrap">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="condition-all-checked">
                                    <span class="checkbox-text"><i class="icon"></i>Select all Conditions</span>
                                </label>
                            </div>
                            <a href="#" class="delete-select-btn reset-btn"><i class="ico-cross"></i>Delete selected</a>
                        </div>
                        <div class="check-body-holder">
                            <div class="check-body">
                                <div class="check-list-wrap">
                                    <ul class="active-condition-list">
                                        <li class="item-wrap">
                                            <div class="checkbox-wrap">
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="condition-check">
                                                    <span class="checkbox-text"><i class="icon"></i></span>
                                                </label>
                                                <span class="disable-btn"><i class="ico-ban-solid"></i></span>
                                            </div>
                                            <div class="text-area">
                                                <div class="text-wrap">
                                                    <span class="text tooltip-label el-tooltip" title="<strong>IF</strong> - &ldquo;1. Enter your zip code&rdquo; <strong>CONTAINS EXACTLY</strong> &ldquo;90231, 90232, 90238, 90239&rdquo;"><i class="icon ico-arrow-thick-right"></i><span class="blue">IF</span> - “1. Enter your zip code” <span class="blue">contains exactly</span> - “90231, 90232, 90238, 90239”</span>
                                                </div>
                                                <div class="condition-slide">
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="THEN"><i class="icon ico-line"></i><span class="sub-heading">then</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>SHOW QUESTIONS</strong> - &ldquo;5. Estimate your credit score&rdquo;">
                                                            <i class="icon ico-view"></i><span class="green">Show Questions</span> - “5. Estimate your credit score”
                                                        </span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>HIDE QUESTIONS</strong> - &ldquo;6. Is this your first property purchase?&rdquo;">
                                                            <i class="icon ico-hidden"></i><span class="green">Hide Questions</span> - “6. Is this your first property purchase?”
                                                        </span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="IN ALL OTHER CASES"><i class="icon ico-line"></i><span class="sub-heading">In ALL Other  Cases</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>CHNAGE LEAD ALERT RECIPIENT</strong> - &ldquo;<strong>3</strong> Recipients Selected &rdquo;">
                                                            <i class="icon ico-client"></i><span class="orange">Change Lead Alert Recipient </span> - “<span class="num">3</span> Recipients Selected”
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="hover-block">
                                                    <ul class="option-hover-list">
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Delete</div>'><span class="ico-cross"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Move</div>'><span class="ico-dragging"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Copy</div>'><span class="ico-copy"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Edit</div>'><span class="ico-edit"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#condition-modal-status" class="el-tooltip status-modal-opener" title='<div  class="option-tooltip">Status</div>'><span class="ico-info"></span></a>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="hover-opener">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="opener-wrap">
                                                <a href="#" class="block-opener el-tooltip" title='<div class="condition-tooltip">expand condition</div>'><i class="ico-arrow-down"></i></a>
                                            </span>
                                        </li>
                                        <li class="item-wrap">
                                            <div class="checkbox-wrap">
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="condition-check">
                                                    <span class="checkbox-text"><i class="icon"></i></span>
                                                </label>
                                                <span class="disable-btn"><i class="ico-ban-solid"></i></span>
                                            </div>
                                            <div class="text-area">
                                                <div class="text-wrap">
                                                    <span class="text tooltip-label el-tooltip" title="<strong>IF</strong> - &ldquo;2. What type of loan do you need?&rdquo; <strong>IS</strong> - &ldquo;Purchase&rdquo;"><i class="icon ico-arrow-thick-right"></i><span class="blue">IF</span> - “2. What type of loan do you need?”  <span class="blue">Is</span> - “Purchase”</span>
                                                </div>
                                                <div class="condition-slide">
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="THEN"><i class="icon ico-line"></i><span class="sub-heading">then</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>SHOW QUESTIONS</strong> - &ldquo;3.1. Great, what kind of home are you purchasing?&rdquo;">
                                                            <i class="icon ico-view"></i><span class="green">Show Questions</span> - “3.1. Great, what kind of home are you purchasing?”
                                                        </span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>HIDE QUESTIONS</strong> - &ldquo;4. Loan Type: Refinance&rdquo;">
                                                            <i class="icon ico-hidden"></i><span class="green">Hide Questions</span> - “4. Loan Type: Refinance”
                                                        </span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="IN ALL OTHER CASES"><i class="icon ico-line"></i><span class="sub-heading">In ALL Other  Cases</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>SHOW SPECIFIC THANK YOU PAGE</strong> - &ldquo;C. Custom thank you page&rdquo;">
                                                            <i class="icon ico-heart"></i><span class="purple">Show Specific Thank You Page </span> - “C. Custom thank you page”
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="hover-block">
                                                    <ul class="option-hover-list">
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Delete</div>'><span class="ico-cross"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Move</div>'><span class="ico-dragging"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Copy</div>'><span class="ico-copy"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Edit</div>'><span class="ico-edit"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#condition-modal-status" class="el-tooltip status-modal-opener" title='<div  class="option-tooltip">Status</div>'><span class="ico-info"></span></a>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="hover-opener">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="opener-wrap">
                                                <a href="#" class="block-opener el-tooltip" title='<div class="condition-tooltip">expand condition</div>'><i class="ico-arrow-down"></i></a>
                                            </span>
                                        </li>
                                        <li class="item-wrap">
                                            <div class="checkbox-wrap">
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="condition-check">
                                                    <span class="checkbox-text"><i class="icon"></i></span>
                                                </label>
                                                <span class="disable-btn"><i class="ico-ban-solid"></i></span>
                                            </div>
                                            <div class="text-area">
                                                <div class="text-wrap">
                                                    <span class="text el-tooltip tooltip-label" title="<strong>IF</strong> - &ldquo;4.11. What is your employment status?&rdquo; <strong>IS KNOWN</strong>"><i class="icon ico-arrow-thick-right"></i><span class="blue">IF</span> -  “4.11. What is your employment status?”   <span class="blue">is known</span></span>
                                                </div>
                                                <div class="condition-slide">
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="THEN"><i class="icon ico-line"></i><span class="sub-heading">then</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>CHNAGE LEAD ALERT RECIPIENT</strong> - &ldquo;<strong>1</strong> Recipients Selected &rdquo;">
                                                            <i class="icon ico-client"></i><span class="orange">Change Lead Alert Recipient </span> - “<span class="num">1</span> Recipients Selected”
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="hover-block">
                                                    <ul class="option-hover-list">
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Delete</div>'><span class="ico-cross"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Move</div>'><span class="ico-dragging"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Copy</div>'><span class="ico-copy"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Edit</div>'><span class="ico-edit"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#condition-modal-status" class="el-tooltip status-modal-opener" title='<div  class="option-tooltip">Status</div>'><span class="ico-info"></span></a>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="hover-opener">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="opener-wrap">
                                                <a href="#" class="block-opener el-tooltip" title='<div class="condition-tooltip">expand condition</div>'><i class="ico-arrow-down"></i></a>
                                            </span>
                                        </li>
                                        <li class="item-wrap">
                                            <div class="checkbox-wrap">
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="condition-check">
                                                    <span class="checkbox-text"><i class="icon"></i></span>
                                                </label>
                                                <span class="disable-btn"><i class="ico-ban-solid"></i></span>
                                            </div>
                                            <div class="text-area">
                                                <div class="text-wrap">
                                                    <span class="text tooltip-label el-tooltip" title="<strong>IF</strong> - &ldquo;6.1. Would you like to borrow additional cash?&rdquo; <strong>IS EQUAL TO</strong> &ldquo;Yes&rdquo;"><i class="icon ico-arrow-thick-right"></i><span class="blue">IF</span> -  “6.1. Would you like to borrow additional cash?”  <span class="blue">Is equal to</span> - “Yes”</span>
                                                </div>
                                                <div class="condition-slide">
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="THEN"><i class="icon ico-line"></i><span class="sub-heading">then</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>SHOW QUESTIONS</strong> - &ldquo;14. How much would you like to borrow?&rdquo;">
                                                            <i class="icon ico-view"></i><span class="green">Show Questions</span> - “14. How much would you like to borrow?”
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="hover-block">
                                                    <ul class="option-hover-list">
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Delete</div>'><span class="ico-cross"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Move</div>'><span class="ico-dragging"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Copy</div>'><span class="ico-copy"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Edit</div>'><span class="ico-edit"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#condition-modal-status" class="el-tooltip status-modal-opener" title='<div  class="option-tooltip">Status</div>'><span class="ico-info"></span></a>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="hover-opener">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="opener-wrap">
                                                <a href="#" class="block-opener el-tooltip" title='<div class="condition-tooltip">expand condition</div>'><i class="ico-arrow-down"></i></a>
                                            </span>
                                        </li>
                                        <li class="item-wrap">
                                            <div class="checkbox-wrap">
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="condition-check">
                                                    <span class="checkbox-text"><i class="icon"></i></span>
                                                </label>
                                                <span class="disable-btn"><i class="ico-ban-solid"></i></span>
                                            </div>
                                            <div class="text-area">
                                                <div class="text-wrap">
                                                    <span class="text tooltip-label el-tooltip" title="<strong>IF</strong> - &ldquo;8. Can you show proof of income?&rdquo; <strong>IS</strong> - &ldquo;No&rdquo;"><i class="icon ico-arrow-thick-right"></i><span class="blue">IF</span> -  “8. Can you show proof of income?”   <span class="blue">Is</span> - “No”</span>
                                                </div>
                                                <div class="condition-slide">
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="THEN"><i class="icon ico-line"></i><span class="sub-heading">then</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>SHOW QUESTIONS</strong> - &ldquo;18. Do you currently have a FHA loan?&rdquo;">
                                                            <i class="icon ico-view"></i><span class="green">Show Questions</span> - “18. Do you currently have a FHA loan?”
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="hover-block">
                                                    <ul class="option-hover-list">
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Delete</div>'><span class="ico-cross"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Move</div>'><span class="ico-dragging"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Copy</div>'><span class="ico-copy"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Edit</div>'><span class="ico-edit"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#condition-modal-status" class="el-tooltip status-modal-opener" title='<div  class="option-tooltip">Status</div>'><span class="ico-info"></span></a>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="hover-opener">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="opener-wrap">
                                                <a href="#" class="block-opener el-tooltip" title='<div class="condition-tooltip">expand condition</div>'><i class="ico-arrow-down"></i></a>
                                            </span>
                                        </li>
                                        <li class="item-wrap disabled">
                                            <div class="checkbox-wrap">
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="condition-check">
                                                    <span class="checkbox-text"><i class="icon"></i></span>
                                                </label>
                                                <span class="disable-btn"><i class="ico-ban-solid"></i></span>
                                            </div>
                                            <div class="text-area">
                                                <div class="text-wrap">
                                                    <span class="text tooltip-label el-tooltip" title="<strong>IF</strong> - &ldquo;1. Enter your zip code&rdquo; <strong>CONTAINS EXACTLY</strong> &ldquo;90231, 90232, 90238, 90239&rdquo;"><i class="icon ico-arrow-thick-right"></i><span class="blue">IF</span> - “1. Enter your zip code” <span class="blue">contains exactly</span> - “90231, 90232, 90238, 90239”</span>
                                                </div>
                                                <div class="condition-slide">
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="THEN"><i class="icon ico-line"></i><span class="sub-heading">then</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>SHOW QUESTIONS</strong> - &ldquo;5. Estimate your credit score&rdquo;">
                                                            <i class="icon ico-view"></i><span class="green">Show Questions</span> - “5. Estimate your credit score”
                                                        </span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>HIDE QUESTIONS</strong> - &ldquo;6. Is this your first property purchase?&rdquo;">
                                                            <i class="icon ico-hidden"></i><span class="green">Hide Questions</span> - “6. Is this your first property purchase?”
                                                        </span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="IN ALL OTHER CASES"><i class="icon ico-line"></i><span class="sub-heading">In ALL Other  Cases</span></span>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <span class="text tooltip-label el-tooltip" title="<strong>CHNAGE LEAD ALERT RECIPIENT</strong> - &ldquo;<strong>3</strong> Recipients Selected &rdquo;">
                                                            <i class="icon ico-client"></i><span class="orange">Change Lead Alert Recipient </span> - “<span class="num">3</span> Recipients Selected”
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="hover-block">
                                                    <ul class="option-hover-list">
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Delete</div>'><span class="ico-cross"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Move</div>'><span class="ico-dragging"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Copy</div>'><span class="ico-copy"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="el-tooltip" title='<div class="option-tooltip">Edit</div>'><span class="ico-edit"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#condition-modal-status" class="el-tooltip status-modal-opener" title='<div  class="option-tooltip">Status</div>'><span class="ico-info"></span></a>
                                                        </li>
                                                    </ul>
                                                    <a href="#" class="hover-opener">
                                                        <i class="fbi fbi_dots">
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                            <span class="opener-wrap">
                                                <a href="#" class="block-opener el-tooltip" title='<div class="condition-tooltip">expand condition</div>'><i class="ico-arrow-down"></i></a>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <ul class="links-list">
                        <li><a href="#" class="active-condition-modal-close" data-dismiss="modal">back</a></li>
                        <li><a href="#" class="add-condition-link">add new condition</a></li>
                    </ul>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel active-condition-modal-close" data-dismiss="modal">Cancel</button>
                            </li>
                            <li class="action__item">
                                <button id="edit-rcpt" type="submit" class="button button-primary">finish</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Condition Status Modal -->
    <div class="modal fade condition-modal-status" id="condition-modal-status">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Condition Status</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label class="label-text" for="toggle-status">Select Condition Status</label>
                        <input id="toggle-status" name="toggle-status" data-toggle="toggle" data-onstyle="active" data-offstyle="inactive" data-width="127" data-height="43" data-on="INACTIVE" data-off="ACTIVE" type="checkbox" checked>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="delete-condition-btn">delete condition</a>
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel status-modal-close" data-dismiss="modal">cancel</button>
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

    <!-- reset to default -->
    <div class="modal fade reset-default" id="reset-default-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset to Default Provided Questions</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Are you sure you want to reset your Funnel questions back <br>
                        to the default provided questions?
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary"  type="submit">Yes, Reset</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Partial Leads modal -->
    <div class="modal fade partial-leads" id="partial-leads-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Partial Leads</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit craseuise
                        mod efficitur tincidunt quis enim velit sed varius ante mi.
                    </p>
                    <div class="partial-leads">
                        <div class="checkbox pl-2 ml-1">
                            <input type="checkbox" id="partialLeadsCheckbox" class="all-check-box" name="partialLeadsCheckbox" value="">
                            <label class="lead-label" for="partialLeadsCheckbox">
                                Yes, Receive Partial Leads
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Cancel</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary"  type="submit">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal -->
    <div class="modal fade confirmation-delete" id="confirmation-delete">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Your Question</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Are you sure, you want to delete the Question
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary"  type="submit">Yes, Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete transition modal -->
    <div class="modal fade confirmation-delete" id="delete-tranistion">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove Transition</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Are you sure, you want to remove the Transition
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-bold button-cancel" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary"  type="submit">Yes, Delete</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- create-transition-pop modal -->
    <div class="modal fade create-question" id="create-transition-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="new-transition" class="form-pop" method="get" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Transition</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="transition_name" class="modal-lbl">Transition Name</label>
                            <div class="input__holder">
                                <input id="transition_name" name="transition_name" class="form-control" type="text" placeholder="" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transition-type" class="modal-lbl">Transition Type</label>
                            <div class="input__holder">
                                <div class="select2js__transition-type-parent select2js__nice-scroll w-100">
                                    <select class="select2js__transition-type" name="transition-type" id="transition-type">
                                        <option value="">Short Transition</option>
                                        <option value="">Circle Transition</option>
                                        <option value="">3 Dots</option>
                                    </select>
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
                                    <button class="button button-bold button-primary"  type="submit">Next</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- manage-transition-pop modal -->
    <div class="modal fade manage-question" id="manage-transition-pop">
        <div class="modal-dialog modal-extra__dailog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Manage Transitions
                    </h5>
                </div>
                <div class="modal-body p-0">
                    <div class="lp-table__head">
                        <ul class="lp-table__list">
                            <li class="lp-table__item">
                                <div class="item-wrap">
                                    Transition Name
                                </div>
                            </li>
                            <li class="lp-table__item">
                                <div class="item-wrap">
                                    Date Created
                                </div>
                            </li>
                            <li class="lp-table__item">Options</li>
                        </ul>
                    </div>
                    <div class="lp-table__body">
                        <ul class="lp-table sorting ui-sortable">
                            <li class="lp-table__list ">
                                <span class="lp-table__item">Short Transition</span>
                                <span class="lp-table__item"><span class="item-wrap">12/18/2019</span></span>
                                <span class="lp-table__item">
                                        <a href="javascript:void(0);" class="show_nav">
                                            <i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i>
                                        </a>
                                        <ul class="action_nav">
                                            <li> <a href="javascript:void(0);" class="edit"><i class="ico ico-edit"></i></a></li>
                                            <li> <a href="javascript:void(0);" class="clone"><i class="ico ico-copy"></i></a></li>
                                        </ul>
                                    </span>
                            </li>
                            <li class="lp-table__list ">
                                <span class="lp-table__item">Circle Loader</span>
                                <span class="lp-table__item"><span class="item-wrap">12/19/2019</span></span>
                                <span class="lp-table__item">
                                        <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></a>
                                        <ul class="action_nav">
                                            <li> <a href="javascript:void(0);" class="edit"><i class="ico ico-edit"></i></a></li>
                                            <li> <a href="javascript:void(0);" class="clone"><i class="ico ico-copy"></i></a></li>
                                        </ul>
                                    </span>
                            </li>
                            <li class="lp-table__list ">
                                <span class="lp-table__item">3 dots</span>
                                <span class="lp-table__item"><span class="item-wrap">11/05/2019</span></span>
                                <span class="lp-table__item">
                                        <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></a>
                                        <ul class="action_nav">
                                            <li> <a href="javascript:void(0);" class="edit"><i class="ico ico-edit"></i></a></li>
                                            <li> <a href="javascript:void(0);" class="clone"><i class="ico ico-copy"></i></a></li>
                                        </ul>
                                    </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer d-block m-0">
                    <div class="row">
                        <div class="col">
                            <a href="javascript:void(0);" class="pop-transition-question">
                                create new transition
                            </a>
                        </div>
                        <div class="col">
                            <div class="action d-flex justify-content-end">
                                <ul class="action__list">
                                    <li class="action__item">
                                        <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                                    </li>
                                    <li class="action__item">
                                        <input class="button button-bold button-primary" value="Save" type="submit">
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- icon-color-modal -->
    <div class="modal fade" id="icon-color-modal" tabindex="-1" role="dialog" aria-labelledby="icon-color-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Question Group</h5>
                </div>
                <div class="modal-body">
                    <div class="color-picker-field">
                        <label>Group Name</label>
                        <div class="field-area">
                            <div class="field-holder">
                                <span class="question-icon-text title-tooltip" title="Loan Type: Purchase">Loan Type: Purchase</span>
                            </div>
                            <div class="last-selected icon-color-opener">
                                <div class="last-selected__box" style="background:#b6c7cd"></div>
                                <div class="last-selected__code">#b6c7cd</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">cancel</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary" data-dismiss="modal">finish</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main icon color picker -->
    <div class="color-box__panel-wrapper icon-color-picker-parent">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block icon-color-picker">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="182"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="199"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="205"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#b6c7cd" />
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

    <!-- Home CTA message modal -->
    <div class="modal fade homepage-cta-message funnel-group-home-modal" id="homepage-cta-message-pop">
        <div class="modal-dialog modal-dialog-centered modal-max__dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Funnel Homepage CTA Message</h5>
                    <div class="fb-toggle">
                        <input checked class="fb-field-label"
                               type="checkbox"
                               id="toggle-status"
                               data-toggle="toggle"
                               data-on="Inactive"
                               data-off="Active"
                               data-onstyle="off"
                               data-offstyle="on">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="lp-panel m-0 px-0 rounded-0">
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
                                                    <select class="form-control msgfontsize" name="" id="msgfontsize">
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
                                                    <!-- Main Message color picker -->
                                                    <div class="color-box__panel-wrapper main-message-clr">
                                                        <div class="picker-inner-wrap">
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
                                                    </div>

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
                    <div class="lp-panel border-bottom-0 m-0 px-0 rounded-0">
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
                                                    <select class="form-control dfontsize" name="" id="dfontsize">
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
                                        <li class="action__item text-color-holder">
                                            <div class="text-color">
                                                <label for="textcolor">Text Color</label>
                                                <div class="text-color-parent">
                                                    <div class="color-picker colorSelector-mdescp cta-color-selector" data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval" style="background-color:#6e787d"></div>
                                                    <!-- Description color picker -->
                                                    <div class="color-box__panel-wrapper desc-message-clr">
                                                        <div class="picker-inner-wrap">
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
                                                    </div>

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

    <!-- Thank you page modal -->
    <div class="modal fade fb-thank-you-modal" id="fb-thank-you">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Thank You
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="lp-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Thank You Page
                                </h2>
                            </div>
                            <div class="col-right">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item action__item_separator">
                                            <span class="action__span">
                                                <a href="funnel-thank-you-edit.php" class="action__link">
                                                    <span class="ico ico-edit"></span>Edit
                                                </a>
                                            </span>
                                        </li>
                                        <li class="action__item">
                                            <div class="button-switch">
                                                <input checked class="thktogbtn" id="thirldparty" name="thirldparty"
                                                       data-thelink="thirdparty_active" data-toggle="toggle"
                                                       data-onstyle="active" data-offstyle="inactive"
                                                       data-width="127" data-height="43" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <p class="lp-custom-para">
                                This is the most basic submission option. Upon submission, your LeadPops will simply forward clients to a customizable "Thank You Message." After a few seconds it then redirects the client to the first step of your LeadPops.

                            </p>
                        </div>
                    </div>
                    <div class="lp-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Third Party URL
                                </h2>
                            </div>
                            <div class="col-right">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item action__item_separator">
                                            <span class="action__span action__span_3rd-party">
                                                <a id="eurllink" href="javascript:void(0)" class="action__link action__link_edit lp_thankyou_toggle">
                                                    <span class="ico ico-edit"></span>edit url
                                                </a>
                                                <a href="javascript:void(0)" class="action__link action__link_cancel">
                                                    <span class="ico ico-cross"></span>cancel
                                                </a>
                                            </span>
                                        </li>
                                        <li class="action__item">
                                            <div class="button-switch">
                                                <input class="thktogbtn" id="thankyou" name="thankyou"
                                                       data-thelink="thankyou_active" data-toggle="toggle" data-onstyle="active"
                                                       data-offstyle="inactive" data-width="127" data-height="43"
                                                       data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="default__panel">
                                <p class="lp-custom-para">
                                    This simple option gives your potential clients a quick thank you message,
                                    and then forwards them to a third party website of your choice. You can forward
                                    your potential clients to your company website, personal website, blog,
                                    Facebook page, or other&nbsp;website.
                                </p>
                            </div>
                            <div class="third-party__panel">
                                <div class="select2__parent-url-prefix">
                                    <select class="form-control flex-grow-0 url-prefix">
                                        <option value="http">Type in the URL http://</option>
                                        <option value="https">Type in the URL https://</option>
                                    </select>
                                </div>
                                <div class="input-holder flex-grow-1">
                                    <input id="thrd_url" name="thrd_url" class="form-control" type="text" placeholder="myleads.leadpops.com/popadmin/footeroptionsprivacypolicy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">close</button>
                            </li>
                            <li class="action__item">
                                <button type="button" class="button button-primary" data-dismiss="modal">save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Field modal -->
    <div class="modal fade hidden-field-modal" id="hidden-field-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ico-hidden"></i> Hidden Field</h5>
                </div>
                <div class="modal-body-wrap">
                    <div class="modal-body quick-scroll">
                        <div class="modal-body-inner">
                            <div class="form-group hidden-field">
                                <div class="label-wrap">
                                    <label>Field Label</label>
                                    <span class="question-mark el-tooltip" title='<div class="hidden-field-tooltip">tooltip content</div>'>
                                        <span class="ico ico-question"></span>
                                    </span>
                                </div>
                                <div class="field-holder">
                                    <div class="field">
                                        <input type="text" class="form-control" placeholder="Enter Field Label">
                                        <span class="tag-box">
                                            <i class="fa fa-tag"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label-wrap">
                                    <label>Default Value <span class="optional">(optional)</span></label>
                                    <span class="question-mark el-tooltip" title='<div class="hidden-field-tooltip">tooltip content</div>'>
                                        <span class="ico ico-question"></span>
                                    </span>
                                </div>
                                <div class="field-holder">
                                    <div class="field">
                                      <input type="text" class="form-control" placeholder="Enter Default Value">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="label-wrap">
                                    <div class="fb-checkbox">
                                        <input class="fb-checkbox__input" type="checkbox" id="hidden-field-option">
                                        <label for="hidden-field-option" class="fb-checkbox__label">
                                            <div class="fb-checkbox__box">
                                                <div class="fb-checkbox__inner-box"></div>
                                            </div>
                                            <div class="fb-checkbox__caption">
                                                Allow field to be populated dynamically
                                            </div>
                                        </label>
                                    </div>
                                    <span class="question-mark el-tooltip" title='<div class="hidden-field-tooltip">tooltip content</div>'>
                                        <span class="ico ico-question"></span>
                                    </span>
                                </div>
                                <div class="hidden-parameter-slide">
                                  <div class="field-holder">
                                      <div class="field">
                                        <input class="form-control" type="text" placeholder="Parameter">
                                      </div>
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
                                <button class="button button-primary" type="submit">Save</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Question Editor Panel -->
    <div data-hbs="questionEditor"></div>

    <!-- select icon modal -->
    <div class="modal fade select-icon-modal" id="select-icon-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Icon</h5>
                </div>
                <div class="modal-body">
                    <div class="icons-list-holder">
                        <ul class="icons-list">

                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <ul class="btns-list">
                        <li>
                            <button type="button" class="button button-cancel btn-cancel-icon" data-dismiss="modal">Close</button>
                        </li>
                        <li>
                            <button type="button" class="button button-primary btn-add-icon">Select</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Security message modal -->
    <div class="modal fade select-security-message-modal" id="security-message-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Security Message</h5>
                </div>
                <div class="modal-body security-modal-body">
                   <div class="security-message">
                       <div class="preview-panel">
                           <div class="preview-panel__head">
                               <div class="form-group">
                                   <h3 class="preview-panel__title">
                                       Security Message Icon
                                   </h3>
                                   <div class="switcher-min">
                                       <input class="message-icon" name="message-icon" data-toggle="toggle min" data-onstyle="active" data-offstyle="inactive" data-width="72" data-height="26" data-on="OFF" data-off="ON" type="checkbox">
                                   </div>
                               </div>
                           </div>
                           <div class="preview-panel__body">
                               <div class="icon-setting">
                                   <div class="form-group">
                                       <label for="preview-button-pop">Select an Icon</label>
                                       <div class="btn-icon-wrapper" data-dismiss="modal">
                                           <div class="icon-block">
                                               <i class="ico ico-shield-2"></i>
                                           </div>
                                           <span class="arrow"></span>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label for="preview-button-pop">Icon Color</label>
                                       <div class="text-color-parent">
                                           <div id="clr-icon" class="last-selected">
                                               <div class="last-selected__box" style="background: #24b928"></div>
                                               <div class="last-selected__code">#24b928</div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label for="preview-button-pop">Icon Position</label>
                                       <div class="select2js__icon-position-parent select2-parent">
                                           <select name="select2js__icon-position" id="select2js__icon-position">
                                               <option>Left Align</option>
                                               <option>Right Align</option>
                                           </select>
                                       </div>
                                   </div>
                                   <div class="form-group icon-size-wrap">
                                       <label for="preview-button-pop">Icon Size</label>
                                       <div class="range-slider">
                                           <div class="input__wrapper">
                                               <input class="form-control security-icon-size-parent" data-slider-id='ex1Slider' type="text"/>
                                               <input type="hidden" class="security-icon-size" value="20">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="default-setting">
                                   <div class="form-group form-group_security-message">
                                       <label for="buttontext">
                                           Security Message Text
                                           <span class="question-mark el-tooltip" title="Tooltip Content">
                                                <span class="ico ico-question"></span>
                                            </span>
                                       </label>
                                       <div class="font-opitons-area security-font-option">
                                           <div class="input__wrapper">
                                               <input type="text" id="buttontext" class="form-control" placeholder="Privacy & Security Guaranteed">
                                           </div>
                                           <div class="font-bold">
                                               <button type="button" class="form-control txt-cta-bold"><i class="ico ico-alphabet-b"></i></button>
                                           </div>
                                           <div class="font-italic">
                                               <button type="button" class="form-control txt-cta-italic"><i class="ico ico-alphabet-i"></i></button>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <label for="preview-button-pop">Text Color</label>
                                       <div class="text-color-parent">
                                           <div id="clr-text" class="last-selected">
                                               <div class="last-selected__box" style="background: #b4bbbc"></div>
                                               <div class="last-selected__code">#b4bbbc</div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <ul class="btns-list">
                        <li>
                            <button type="button" class="button button-cancel btn-cancel-icon" data-dismiss="modal">Close</button>
                        </li>
                        <li>
                            <button type="button" class="button button-primary btn-add-icon">Save</button>
                        </li>
                    </ul>
                </div>
                <!--  color picker -->
                <div class="color-box__panel-wrapper security-text-clr">
                    <div class="color-box__panel-wrapper-holder">
                        <div class="color-box__panel-wrapper-wrap">
                            <div class="color-box__panel-dropdown">
                                <select class="color-picker-options">
                                    <option value="1">Color Selection:  Pick My Own</option>
                                    <option value="2">Color Selection:  Pull from Logo</option>
                                </select>
                            </div>
                            <div class="color-picker-block">
                                <div class="picker-block" id="text-clr">
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
                                    <input class="color-box__hex-block" id="security-text-clr-trigger" value="#707d84" />
                                    <input type="hidden" class="color-opacity" value="1">
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
                    </div>
                </div>
                <div class="color-box__panel-wrapper security-icon-clr">
                    <div class="color-box__panel-wrapper-holder">
                        <div class="color-box__panel-wrapper-wrap">
                            <div class="color-box__panel-dropdown">
                                <select class="color-picker-options">
                                    <option value="1">Color Selection:  Pick My Own</option>
                                    <option value="2">Color Selection:  Pull from Logo</option>
                                </select>
                            </div>
                            <div class="color-picker-block">
                                <div class="picker-block" id="icon-clr">
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
                                    <input class="color-box__hex-block" id="security-icon-clr-trigger" value="#707d84" />
                                    <input type="hidden" class="color-opacity" value="1">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- icon picker modal -->
    <div class="modal fade" id="icon-picker">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Icon</h5>
                </div>
                <div class="modal-body pb-0">
                    <ul class="icon-wrapper"></ul>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" data-target="#security-message-modal" data-toggle="modal" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-bold button-primary btn-add-security-icon">Select</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
    include ("includes/footer.php");
?>
