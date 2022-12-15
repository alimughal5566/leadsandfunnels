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
            <div class="panel-aside__head-holder">
                <div class="panel-aside__head m-0 p-0">
                <h4 class="panel-aside__title">
                    <span class="question-standard">
                        <span>Standard Questions</span>
<!--                        <span class="dnd d-none">(Drag and Drop)</span>-->
                    </span>
                    <span class="question-global">
                        <span>
                            <i class="fas fa-globe-americas head-icon"></i>
                            Global Questions
                        </span>
                        <span class="question-mark el-tooltip" title="<p class='global-tooltip'>Global questions are type of questions that can be used <br> accross multiple funnels. Whenever you edit these questions <br> all the funnels that contain them will be effected.</p>">
                            <span class="ico ico-question"></span>
                        </span>
<!--                        <span class="dnd">(Drag and Drop)</span>-->
                    </span>
                    <span class="question-pre-made">
                        <span>
                            <i class="ico ico-start-rate head-icon"></i>
                            Pre-Made Questions
                        </span>
<!--                        <span class="dnd">(Drag and Drop)</span>-->
                    </span>
                    <span class="question-transition">
                        <span>Transitions</span>
<!--                        <span class="dnd">(Drag and Drop)</span>-->
                    </span>
                </h4>
            </div>
            </div>
            <div class="panel-aside__body-holder">
                <div class="panel-aside__body">
                    <div class="question-option">
                        <div class="standard-question-option-parent">
                            <select id="question-select" class="form-control standard-question-option">
                                <option value="-1">CHOOSE QUESTION TYPE</option>
                                <option value="1" selected>Standard Questions</option>
                                <option value="2">Global Questions</option>
                                <option value="3">Pre-Made Questions</option>
                                <option value="4">Transitions</option>
                            </select>
                        </div>
                        <div class="question-option-scroll">
                            <div class="question-standard">
                                <ul class="question-option__list">
                                    <li class="question-option__item question-option__item_address" data-icon="icon-text_address">address</li>
                                    <li class="question-option__item question-option__item_birthday" data-icon="icon-text_birthday">birthday</li>
                                    <li class="question-option__item question-option__item_contact" data-class="fb-question-item_lock fb-question-item_contact-info" data-icon="icon-text_contact">Contact</li>
                                    <li class="question-option__item question-option__item_cta" data-icon="icon-text_cta">CTA message</li>
                                    <li class="question-option__item question-option__item_date-picker" data-icon="icon-text_date-picker">date picker</li>
                                    <li class="question-option__item question-option__item_dropdown" data-icon="icon-text_dropdown">drop down</li>
                                    <li class="question-option__item question-option__item_hidden-field" data-icon="icon-text_hidden-field">Hidden Field</li>
                                    <li class="question-option__item question-option__item_menu" data-icon="icon-text_menu">menu</li>
                                    <li class="question-option__item question-option__item_number" data-icon="icon-text_number">number</li>
                                    <li class="question-option__item question-option__item_slider" data-icon="icon-text_slider">slider</li>
                                    <li class="question-option__item question-option__item_textfield" data-icon="icon-text_textfield">text field</li>
                                    <li class="question-option__item question-option__item_time-picker" data-icon="icon-text_time-picker">time picker</li>
                                    <li class="question-option__item question-option__item_zipcode" data-icon="icon-text_zipcode">zip code</li>
                                </ul>
                            </div>
                            <div class="question-global">
                                <div class="placeholder">
                                    <p>You have not created any Global Questions&nbsp;yet.</p>
                                    <div class="create-question">
                                        <a class="btn-create" href="#create-question-pop" data-toggle="modal">
                                            create your first question
                                        </a>
                                    </div>
                                </div>
                                <ul class="question-option__list global-list">
                                    <li class="question-option__item question-option__item_slider" data-icon="icon-text_slider">$0-$2M (Advanced Slider)</li>
                                    <li class="question-option__item question-option__item_estimate" data-icon="icon-text_estimate">Estimated Down Payment</li>
                                    <li class="question-option__item question-option__item_credit" data-icon="icon-text_credit">Estimated Credit Score</li>
                                    <li class="question-option__item question-option__item_type-home" data-icon="icon-text_type-home">Type of Home</li>
                                </ul>
                                <div class="create-question">
                                    <a class="btn-create" href="#create-question-pop" data-toggle="modal">
                                        create New question
                                    </a>
                                </div>
                                <div class="manage-question">
                                    <a class="btn-manage" href="#manage-question-pop" data-toggle="modal">
                                        manage global questions
                                    </a>
                                </div>
                            </div>
                            <div class="question-pre-made">
                                <ul class="question-option__list pre-made-list">
                                    <li class="question-option__item question-option__item_state" data-icon="icon-text_state">List of United States</li>
                                    <!-- <li class="question-option__item question-option__item_car" data-icon="icon-text_car">Vehicle Make + Model</li>-->
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
                                <ul class="question-option__list">
                                    <li class="question-option__item question-option__item_transition" data-icon="icon-text_transition">3 Dots</li>
                                    <li class="question-option__item question-option__item_transition" data-icon="icon-text_transition">Circle loader</li>
                                    <li class="question-option__item question-option__item_transition" data-icon="icon-text_transition">Short transition</li>
                                </ul>
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
                                    <span class="question-mark el-tooltip" title="TOOLTIP CONTENT" data-tooltip-content="#tooltip_seamlesscontent">
                                        <span class="ico ico-question"></span>
                                    </span>
                                </h2>
                                <ul class="funnel-panel__options">
                                    <li class="funnel-panel__item edit-funnel">
                                        <a href="#homepage-cta-message-pop" data-toggle="modal" class="btn panel-button__btn">
                                            <i class="ico ico-promote"></i>
                                            <span class="opt-text">Edit Homepage CTA Message <span class="on-text">(ON)</span></span>
                                        </a>
                                    </li>
                                    <li class="funnel-panel__item logic">
                                        <a id="conditional-logic-click" href="#" data-toggle="modal" data-target="#conditional-logic" class="btn panel-button__btn">
                                            <i class="lp-icon-conditional-logic lp-icon-conditional-logic_pt3 ico-back"></i>
                                            <span class="opt-text">Conditional Logic  <span class="on-text">(ON)</span></span>
                                        </span>
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
                            <div class="funnel-body-scroll">
                                <div class="funnel-panel__body">
                                <div class="funnel-panel__sortable dropable-funnel-option">
                                    <div class="funnel-panel__placeholder dropable-funnel-option placeholder">
                                        <h2 class="funnel-panel__placeholder-title">You have not added any questions yet.</h2>
                                        <p class="funnel-panel__placeholder-dsc">Drag and drop questions from sidebar to add them to your Funnel.</p>
                                    </div>
                                </div>
                                <div class="funnel-panel__lock">
                                    <div class="fb-question-item fb-question-item_steps fb-question-item_lock fb-question-item_contact-info">
                                        <div class="fb-question-item__serial">1.</div>
                                        <div class="fb-question-item__detail">
                                            <div class="fb-question-item__col">
                                                <div class="icon-text icon-text_contact">Contact</div>
                                            </div>
                                            <div class="fb-question-item__col fb-question-item__col_plr14">
                                                <label class="fb-step-label">3 - STEP</label>
                                            </div>
                                            <div class="fb-question-item__col">
                                                <div class="fb-step">
                                                    <div class="fb-step__title">Step 1:</div>
                                                    <div class="fb-step__caption">Full Name</div>
                                                </div>
                                            </div>
                                            <div class="fb-question-item__col">
                                                <div class="fb-step">
                                                    <div class="fb-step__title">Step 2:</div>
                                                    <div class="fb-step__caption">Email Address</div>
                                                </div>
                                            </div>
                                            <div class="fb-question-item__col">
                                                <div class="fb-step">
                                                    <div class="fb-step__title">Step 3:</div>
                                                    <div class="fb-step__caption">Phone Number</div>
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
                                                            <!--                                            <i class="fbi fbi_back-white"></i>-->
                                                            <i class="lp-icon-conditional-logic ico-back"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item lp-control__item_edit">
                                                        <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                            <!--                                            <i class="fbi fbi_edit-white"></i>-->
                                                            <i class="ico-edit"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item">
                                                        <a title="duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                            <!--                                            <i class="fbi fbi_copy-white"></i>-->
                                                            <i class="ico-copy"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item">
                                                        <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">
                                                            <!--                                            <i class="fbi fbi_drag-white"></i>-->
                                                            <i class="ico-dragging"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item">
                                                        <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                            <!--                                            <i class="fbi fbi_cross-white"></i>-->
                                                            <i class="ico-cross"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                               <!-- <ul class="lp-control">
                                                    <li class="lp-control__item lp-control__item_edit">
                                                        <a class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control tooltipstered" href="#">
                                                            <i class="ico-dragging"></i>
                                                        </a>
                                                    </li>
                                                    <li class="lp-control__item lp-control__item_edit">
                                                        <a class="lp-control__link fb-tooltip fb-tooltip_control tooltipstered" href="#">
                                                            <i class="ico-cross"></i>
                                                        </a>
                                                    </li>
                                                </ul>-->
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

                    <!-- Thank you page Listing -->

                    <div class="funnel-panel funnel-panel_thankyou">
                        <div class="funnel-panel__head">
                            <h2 class="funnel-panel__title">
                                Thank You Page
                            </h2>
                        </div>
                        <div class="funnel-panel__body">
                            <div class="funnel-panel__ty_sortable">
                                <div class="fb-question-item fb-question-item_lock">
                                    <div class="fb-question-item__serial">A</div>
                                    <div class="fb-question-item__detail">
                                        <div class="fb-question-item__col">
                                            <!--icon-text_third-party-->
                                            <div class="icon-text icon-text_link">
                                                Thank you
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
                                                        <!--                                            <i class="fbi fbi_back-white"></i>-->
                                                        <i class="lp-icon-conditional-logic ico-back"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item lp-control__item_edit">
                                                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_edit-white"></i>-->
                                                        <i class="ico-edit"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_copy-white"></i>-->
                                                        <i class="ico-copy"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_drag-white"></i>-->
                                                        <i class="ico-dragging"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_cross-white"></i>-->
                                                        <i class="ico-cross"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="fb-question-item__col fb-question-item__col_lock">
                                            <a href="#">
                                                <!-- <i class="fbi fbi_lock"></i>-->
                                                <i class="lp-icon-lock ico-lock"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-question-item d-none">
                                    <div class="fb-question-item__serial">B</div>
                                    <div class="fb-question-item__detail">
                                        <div class="fb-question-item__col">
<!--                                            icon-text_ty-page-->
                                            <div class="icon-text  p-0">Thank You</div>
                                        </div>
                                        <div class="fb-question-item__col">
                                            <div class="tu-url">
                                                <div class="tu-url__url">Sebonix Funnel Version1</div>
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
                                                        <!--                                            <i class="fbi fbi_back-white"></i>-->
                                                        <i class="lp-icon-conditional-logic ico-back"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item lp-control__item_edit">
                                                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_edit-white"></i>-->
                                                        <i class="ico-edit"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_copy-white"></i>-->
                                                        <i class="ico-copy"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_drag-white"></i>-->
                                                        <i class="ico-dragging"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_cross-white"></i>-->
                                                        <i class="ico-cross"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="fb-question-item__col fb-question-item__col_lock">
                                            <a href="#">
                                                <!-- <i class="fbi fbi_lock"></i>-->
                                                <i class="lp-icon-lock ico-lock"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="fb-question-item d-none">
                                    <div class="fb-question-item__serial">C</div>
                                    <div class="fb-question-item__detail">
                                        <div class="fb-question-item__col">
<!--                                            icon-text_ty-page-->
                                            <div class="icon-text p-0">Thank You</div>
                                        </div>
                                        <div class="fb-question-item__col">
                                            <div class="tu-url">
                                                <div class="tu-url__url">Custom Test Funnel</div>
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
                                                        <!--                                            <i class="fbi fbi_back-white"></i>-->
                                                        <i class="lp-icon-conditional-logic ico-back"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item lp-control__item_edit">
                                                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_edit-white"></i>-->
                                                        <i class="ico-edit"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_copy-white"></i>-->
                                                        <i class="ico-copy"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_drag-white"></i>-->
                                                        <i class="ico-dragging"></i>
                                                    </a>
                                                </li>
                                                <li class="lp-control__item">
                                                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">
                                                        <!--                                            <i class="fbi fbi_cross-white"></i>-->
                                                        <i class="ico-cross"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="fb-question-item__col fb-question-item__col_lock">
                                            <a href="#">
                                                <!-- <i class="fbi fbi_lock"></i>-->
                                                <i class="lp-icon-lock ico-lock"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                               <!-- <div class="funnel-panel__add">
                                    <div class="add-box add-box_page" data-toggle="modal" data-target="#fb-thank-you" data-backdrop="static" data-keyboard="false">
                                        <i class="lp-icon-plus lp-icon-plus_large ico-plus"></i>
                                        <span class="add-box__text">Add New Page</span>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <!--add tags & folders modal-->
    <div class="modal fade add-folder" id="add-folder" tabindex="-1" role="dialog" aria-labelledby="add-folder" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Folders</h5>
                </div>
                <div class="modal-body pb-0">
                    <form action="" method="post" name="add-folder" class="add-folder-form form-pop" novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="lp-group">
                                    <label class="control-label" for="add-folder">Add New Folder</label>
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="form-group m-0">
                                                <div class="input__holder">
                                                    <input type="text" name="folder_name" class="form-control" id="folder_name" placeholder="New Folder" required="" aria-required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 pl-0">
                                            <input type="submit" class="button folder-btn" value="Add Folder">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    <div class="folder-list">
                        <div class="folder-col">
                            <div class="col">
                                <h3>Folder Name</h3>
                            </div>
                            <div class="col">
                                <h3>Options</h3>
                            </div>
                        </div>
                        <div class="folder-listing">
                            <div class="sorting ui-sortable">
                                <div class="folder-col" data-id="168">
                                    <div class="tag-col">
                                        <div class="folder-inner">
                                            <div class="col">
                                                <h4>Mortgage Funnels</h4>
                                            </div>
                                            <div class="col">
                                        <div class="action action_options">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <a href="#" class="action__link move" data-id="168" data-index="0">
                                                        <span class="ico ico ico-dragging"></span>MOVE
                                                    </a>
                                                </li>
                                                <li class="action__item">
                                                    <a href="#" class="action__link edit-folder" data-id="168" data-index="0">
                                                        <span class="ico ico-edit"></span>EDIT
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--                                            <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>-->
                                        <!--                                            <ul class="action_nav">-->
                                        <!--                                                <li> <a href="javascript:void(0);" class="move" data-id="168"><i class="ico ico-dragging"></i>MOVE</a></li>-->
                                        <!--                                                <li> <a href="javascript:void(0);" class="edit-folder" data-id="168" data-index="0"><i class="ico ico-edit"></i>EDIT</a></li>-->
                                        <!--                                            </ul>-->
                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="folder-col" data-id="169">
                                    <div class="tag-col">
                                        <div class="folder-inner">
                                            <div class="col">
                                                <h4>Real Estate Funnels</h4>
                                            </div>
                                            <div class="col">
                                        <div class="action action_options">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <a href="#" class="action__link move" data-id="169" data-index="0">
                                                        <span class="ico ico ico-dragging"></span>MOVE
                                                    </a>
                                                </li>
                                                <li class="action__item">
                                                    <a href="#" class="action__link edit-folder" data-id="169" data-index="0">
                                                        <span class="ico ico-edit"></span>EDIT
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--                                            <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>-->
                                        <!--                                            <ul class="action_nav">-->
                                        <!--                                                <li> <a href="javascript:void(0);" class="move" data-id="169"><i class="ico ico-dragging"></i>MOVE</a></li>-->
                                        <!--                                                <li> <a href="javascript:void(0);" class="edit-folder" data-id="169" data-index="0"><i class="ico ico-edit"></i>EDIT</a></li>-->
                                        <!--                                            </ul>-->
                                    </div>
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
                                <input class="button button-primary lp-btn-save-folders" value="Save" type="submit">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade add-folder" id="add-tag" tabindex="-1" role="dialog" aria-labelledby="add-tag" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Global Tag Management</h5>
                </div>
                <div class="modal-body pb-0">
                    <form action="" method="post" name="add-folder" class="add-tag-form form-pop" novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="lp-group">
                                    <label class="control-label" for="tag_name">Add New Tag</label>
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="form-group m-0">
                                                <div class="input__holder">
                                                    <input type="text" name="tag_name" class="form-control" id="tag_name" placeholder="New Tag" required="" aria-required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 pl-0">
                                            <input type="submit" class="button tag-btn" value="Add Tag">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    <div class="folder-list">
                        <div class="folder-col">
                            <div class="col">
                                <h3>Tag Name</h3>
                            </div>
                            <div class="col">
                                <h3>Options</h3>
                            </div>
                        </div>
                        <div class="folder-listing">
                            <div class="folder-col" data-id="168">
                                <div class="col">
                                    <h4>Mortgage Funnels</h4>
                                </div>
                                <div class="col">
                                    <div class="action action_options">
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <a href="#" class="action__link edit-folder" data-id="168" data-index="0">
                                                    <span class="ico ico-edit"></span>edit
                                                </a>
                                            </li>
                                            <li class="action__item">
                                                <a href="#" class="action__link del" data-id="168">
                                                    <span class="ico ico-cross"></span>delete
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--                                        <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>-->
                                    <!--                                        <ul class="action_nav">-->
                                    <!--                                            <li> <a href="javascript:void(0);" class="edit-folder" data-id="168" data-index="0"><i class="ico ico-edit"></i>EDIT</a></li>-->
                                    <!--                                            <li> <a href="javascript:void(0);" class="del" data-id="168"><i class="ico ico-cross"></i>Delete</a></li>-->
                                    <!--                                        </ul>-->
                                </div>
                            </div>
                            <div class="folder-col" data-id="169">
                                <div class="col">
                                    <h4>Real Estate Funnels</h4>
                                </div>
                                <div class="col">
                                    <div class="action action_options">
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <a href="#" class="action__link edit-folder" data-id="168" data-index="0">
                                                    <span class="ico ico-edit"></span>edit
                                                </a>
                                            </li>
                                            <li class="action__item">
                                                <a href="#" class="action__link del" data-id="168">
                                                    <span class="ico ico-cross"></span>delete
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                            </li>
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
                                <input class="button button-primary lp-btn-save-tags" value="Save" type="submit">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="modal-overlay"></span>

    <!--funnel question modal-->
    <div class="modal fade create-question" id="create-question-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="new-question" class="form-pop" action="" method="get">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Global Question</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="question_name" class="modal-lbl">Question Name</label>
                            <div class="input__holder">
                                <input id="question_name" name="question_name" class="form-control" type="text" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="question_type" class="modal-lbl">Question Type</label>
                            <div class="input__holder">
                                <div class="select2js__question-type-parent fuunel-select2js__nice-scroll w-100">
                                    <select class="select2js__question-type" name="question_type" id="question_type">
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
    <div class="modal fade manage-question" id="manage-question-pop">
        <div class="modal-dialog modal-extra__dailog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Manage Global Questions
                        <span class="question-mark el-tooltip" title="<p class='global-tooltip'>Global questions are type of questions that can be used <br> accross multiple funnels. Whenever you edit these questions <br> all the funnels that contain them will be effected.</p>">
                            <span class="ico ico-question"></span>
                        </span>
                    </h5>
                </div>
                <div class="modal-body p-0">
                    <div class="lp-table__head">
                        <ul class="lp-table__list">
                            <li class="lp-table__item">
                                <div class="item-wrap">
                                    Question Name
                                    <span class="sort-link">
                                        <span class="up"></span>
                                        <span class="down"></span>
                                    </span>
                                </div>
                            </li>
                            <li class="lp-table__item">
                                <div class="item-wrap">
                                    Date Created
                                    <span class="sort-link">
                                        <span class="up"></span>
                                        <span class="down"></span>
                                    </span>
                                </div>
                            </li>
                            <li class="lp-table__item">Options</li>
                        </ul>
                    </div>
                    <div class="lp-table__body">
                        <ul class="lp-table sorting ui-sortable">
                            <li class="lp-table__list">
                                <span class="lp-table__item">$0-$2M (Advanced Slider)</span>
                                <span class="lp-table__item"><span class="item-wrap">12/18/2019</span></span>
                                <span class="lp-table__item">
                                    <a href="javascript:void(0);" class="show_nav">
                                        <i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i>
                                    </a>
                                    <ul class="action_nav">
                                        <li> <a href="javascript:void();" class="edit"><i class="ico ico-edit"></i></a></li>
                                        <li> <a href="javascript:void();" class="clone"><i class="ico ico-copy"></i></a></li>
                                    </ul>
                                </span>
                            </li>
                            <li class="lp-table__list">
                                <span class="lp-table__item">Estimated Down Payment</span>
                                <span class="lp-table__item"><span class="item-wrap">12/19/2019</span></span>
                                <span class="lp-table__item">
                                    <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></a>
                                    <ul class="action_nav">
                                        <li> <a href="javascript:void();" class="edit"><i class="ico ico-edit"></i></a></li>
                                        <li> <a href="javascript:void();" class="clone"><i class="ico ico-copy"></i></a></li>
                                    </ul>
                                </span>
                            </li>
                            <li class="lp-table__list">
                                <span class="lp-table__item">Estimated Credit Score</span>
                                <span class="lp-table__item"><span class="item-wrap">11/05/2019</span></span>
                                <span class="lp-table__item">
                                    <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></a>
                                    <ul class="action_nav">
                                        <li> <a href="javascript:void();" class="edit"><i class="ico ico-edit"></i></a></li>
                                        <li> <a href="javascript:void();" class="clone"><i class="ico ico-copy"></i></a></li>
                                    </ul>
                                </span>
                            </li>
                            <li class="lp-table__list">
                                <span class="lp-table__item">Type of Home</span>
                                <span class="lp-table__item"><span class="item-wrap">11/28/2019</span></span>
                                <span class="lp-table__item">
                                    <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i><i class="fa fa-circle" aria-hidden="true"></i></a>
                                    <ul class="action_nav">
                                        <li> <a href="javascript:void();" class="edit"><i class="ico ico-edit"></i></a></li>
                                        <li> <a href="javascript:void();" class="clone"><i class="ico ico-copy"></i></a></li>
                                    </ul>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer d-block m-0">
                    <div class="row">
                        <div class="col">
                            <a href="javascript:void(0);" class="pop-create-question">
                                create new question
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
    <!--funnel transitions-->
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
                                <input id="transition_name" name="transition_name" class="form-control" type="text" placeholder="">
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

    <div class="modal fade clone-pop" id="clone-question-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="clone-question" action="" method="get" class="form-pop">
                    <div class="modal-header">
                        <h5 class="modal-title">Clone Question</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="question_name_clone" class="modal-lbl">Question Name</label>
                            <div class="input__holder">
                                <input id="question_name_clone" name="question_name_clone" class="form-control" type="text">
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
                                    <button class="button button-bold button-primary"  type="submit">Clone & Save</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade clone-pop" id="clone-transition-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="clone-transition" action="" method="get" class="form-pop">
                    <div class="modal-header">
                        <h5 class="modal-title">Clone Transition</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="transition_name_clone" class="modal-lbl">Transition Name</label>
                            <div class="input__holder">
                                <input id="transition_name_clone" name="transition_name_clone" class="form-control" type="text">
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
                                    <button class="button button-bold button-primary"  type="submit">Clone & Save</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade homepage-cta-message" id="homepage-cta-message-pop">
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
                <div class="modal-body p-0 quick-scroll">
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
                                        <li class="action__item text-color-holder">
                                            <div class="text-color">
                                                <label for="textcolor">Text Color</label>
                                                <div class="text-color-parent">
                                                    <div  class="color-picker colorSelector-mdescp cta-color-selector" data-ctaid="dmessagecpval" data-ctavalue="dmainheadingval" style="background-color:#6e787d"></div>
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
    <!-- delete modal -->
    <div class="modal fade confirmation-delete" id="confirmation-delete-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Question</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Are you sure you want to delete question?
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
    <!-- Hidden Field modal -->
    <div class="modal fade hidden-field" id="hidden-field-pop">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-pop" action="">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ico-hidden"></i> Hidden Field</h5>
                    </div>
                    <div class="modal-body quick-scroll">
                        <div class="form-group">
                            <label for="field-label">
                                Field Label
                            </label>
                            <span class="question-mark el-tooltip" title="TOOLTIP CONTENT" data-tooltip-content="#tooltip_seamlesscontent">
                                <span class="ico ico-question"></span>
                            </span>
                        </div>
                        <div class="form-group fb-form__group">
                            <input type="text" class="form-control fb-form-control" value="Hidden Field">
                            <span class="tag-box">
                                <i class="fa fa-tag"></i>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="default-val">
                                Default Value <span class="italic">(optional)</span>
                            </label>
                            <span class="question-mark el-tooltip" title="TOOLTIP CONTENT" data-tooltip-content="#tooltip_seamlesscontent">
                                <span class="ico ico-question"></span>
                            </span>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Enter Default Value" type="text">
                        </div>
                        <div class="form-group">
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
                                <span class="question-mark el-tooltip" title="TOOLTIP CONTENT" data-tooltip-content="#tooltip_seamlesscontent">
                                    <span class="ico ico-question"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group hidden-parameter">
                            <input class="form-control" placeholder="Parameter" type="text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-bold button-cancel" data-dismiss="modal">Close</button>
                                </li>
                                <li class="action__item">
                                    <button class="button button-bold button-primary"  type="submit">Save</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Main Message color picker -->
    <div class="color-box__panel-wrapper main-message-clr color-picker-homepage-cta-message">
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
    <!-- Description color picker -->
    <div class="color-box__panel-wrapper desc-message-clr color-picker-homepage-cta-message">
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
                        <!-- <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-plus"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-arrow-thick-right"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-forwad"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-long-arrow"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-double-arrow"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-check"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-dotted-check"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-lock1"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-search"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-thumbs"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-start-rate"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-heart"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-location"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-client"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-email"></i>
                                     </span>
                             </label>
                         </li>
                         <li>
                             <label>
                                 <input type="radio" name="select-icon">
                                 <span class="icon-wrap">
                                         <i class="ico-file-upload"></i>
                                     </span>
                             </label>
                         </li>-->
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <ul class="btns-list">
                    <li>
                        <button type="button" class="button button-cancel btn-cancel-icon" data-dismiss="modal">Close</button>
                    </li>
                    <li>
                        <button type="button" class="button button-primary btn-add-icon disabled" disabled>Select</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
    @include ("includes/funnel-builder/fb-zip-code.php");
    @include ("includes/funnel-builder/fb-menu.php");
    @include ("includes/funnel-builder/fb-slider.php");
    @include ("includes/funnel-builder/fb-text-field.php");
    @include ("includes/funnel-builder/fb-drop-down.php");
    @include ("includes/funnel-builder/fb-cta-message.php");
    @include ("includes/funnel-builder/fb-contact-info.php");
    @include ("includes/funnel-builder/fb-address.php");
    @include ("includes/funnel-builder/fb-list-of-states.php");
    @include ("includes/funnel-builder/fb-vehicle-modal-make.php");
    @include ("includes/funnel-builder/fb-transition.php");
    @include ("includes/funnel-builder/fb-date-birthday.php");
    @include ("includes/conditional-logic/conditional-logic.php");
    @include ("includes/conditional-logic/view-conditional-logic.php");
    @include ("includes/thankyou/thankyou.php");
    @include ("includes/thankyou/thankyou-detail.php");
    include ("includes/video-modal.php");
    include ("includes/footer.php");
?>
