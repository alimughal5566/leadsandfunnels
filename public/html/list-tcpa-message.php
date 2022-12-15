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
			<section class="main-content tcpa-message-content">
				<!-- Title wrap of the page -->
				<div class="main-content__head">
					<div class="col-left">
						<h1 class="title">
                            TCPA Language / Funnel : <span class="funnel-name">203K Hybrid Loans</span>
						</h1>
					</div>
					<div class="col-right">
						<a data-lp-wistia-title="TCPA Language" data-lp-wistia-key="ji1qu22nfq" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
							<span class="icon ico-video"></span>
							Watch how to video
						</a>
					</div>
				</div>
                <!-- content of the page -->
                <div class="lp-panel">
                    <!-- content page head -->
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                TCPA Messages
                                <span class="question-mark el-tooltip" title="Tooltip Content">
                                    <span class="ico ico-question"></span>
                                </span>
                            </h2>
                        </div>
                        <div class="col-right">
                            <a href="tcpa-message.php" class="button button-primary">add new message</a>
                        </div>
                    </div>
                    <!-- content page body -->
                    <div class="lp-panel__body">
                        <div class="lp-table">
                            <div class="lp-table__head">
                                <ul class="lp-table__list">
                                    <li class="lp-table__item">
                                        <span class="text-wrap">
                                            Message Name
                                            <span class="sorting-opener-wrap">
                                                <a href="#" class="sort-up"></a>
                                                <a href="#" class="sort-down"></a>
                                            </span>
                                        </span>
                                    </li>
                                    <li class="lp-table__item">
                                        <span class="text-wrap">
                                            Date Created
                                             <span class="sorting-opener-wrap">
                                                <a href="#" class="sort-up"></a>
                                                <a href="#" class="sort-down"></a>
                                            </span>
                                        </span>
                                    </li>
                                    <li class="lp-table__item">
                                        <span class="text-wrap">Status</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="lp-table__body">
                                <ul class="lp-table__list">
                                    <li class="lp-table__item">
                                        <span class="text-wrap">Default TCPA Language</span>
                                    </li>
                                    <li class="lp-table__item">
                                        <span class="text-wrap">January 25, 2021</span>
                                    </li>
                                    <li class="lp-table__item">
                                        <div class="action">
                                            <div class="action-wrap">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                                <ul class="options-btns">
                                                    <li class="edit">
                                                        <a href="tcpa-message.php" class="el-tooltip" title='<div class="tcpa-tooltip">edit message</div>'><i class="ico-edit"></i></a>
                                                    </li>
                                                    <li class="remove">
                                                        <a href="#tcpa-message-delete" data-toggle="modal" class="el-tooltip" title='<div class="tcpa-tooltip">delete</div>'><i class="ico-cross"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tcpa-radio-btn">
                                                <label class="radio-label">
                                                    <input class="field-label" name="tcpa-message" type="radio" checked>
                                                    <span class="radio-area">
                                                        <span class="handle"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="lp-table__list">
                                    <li class="lp-table__item">
                                        <span class="text-wrap">Simple consent message</span>
                                    </li>
                                    <li class="lp-table__item">
                                        <span class="text-wrap">January 28, 2021</span>
                                    </li>
                                    <li class="lp-table__item">
                                        <div class="action">
                                            <div class="action-wrap">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                                <ul class="options-btns">
                                                    <li class="edit">
                                                        <a href="tcpa-message.php" class="el-tooltip" title='<div class="tcpa-tooltip">edit message</div>'><i class="ico-edit"></i></a>
                                                    </li>
                                                    <li class="remove">
                                                        <a href="#tcpa-message-delete" data-toggle="modal" class="el-tooltip" title='<div class="tcpa-tooltip">delete</div>'><i class="ico-cross"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tcpa-radio-btn">
                                                <label class="radio-label">
                                                    <input class="field-label" name="tcpa-message" type="radio">
                                                    <span class="radio-area">
                                                        <span class="handle"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="lp-table__list">
                                    <li class="lp-table__item">
                                        <span class="text-wrap">Consumer Protection</span>
                                    </li>
                                    <li class="lp-table__item">
                                        <span class="text-wrap">February 5, 2021</span>
                                    </li>
                                    <li class="lp-table__item">
                                        <div class="action">
                                            <div class="action-wrap">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                                <ul class="options-btns">
                                                    <li class="edit">
                                                        <a href="tcpa-message.php" class="el-tooltip" title='<div class="tcpa-tooltip">edit message</div>'><i class="ico-edit"></i></a>
                                                    </li>
                                                    <li class="remove">
                                                        <a href="#tcpa-message-delete" data-toggle="modal" class="el-tooltip" title='<div class="tcpa-tooltip">delete</div>'><i class="ico-cross"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tcpa-radio-btn">
                                                <label class="radio-label">
                                                    <input class="field-label" name="tcpa-message" type="radio">
                                                    <span class="radio-area">
                                                        <span class="handle"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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
    <!-- delete TCPA Message Modal -->
    <div class="modal fade tcpa-message-delete-modal" id="tcpa-message-delete">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete TCPA Message Page</h5>
                </div>
                <div class="modal-body">
                    <p class="modal-msg modal-msg_light">
                        Are you sure you want to remove this TCPA Message?
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">No, Never Mind</button>
                            </li>
                            <li class="action__item">
                                <button class="button button-primary"  type="submit">Yes, Delete</button>
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
