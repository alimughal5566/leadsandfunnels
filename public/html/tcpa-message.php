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
                        <a href="list-tcpa-message.php" class="back-link"><span class="icon icon-back ico-caret-up"></span>Back to message list</a>
					</div>
				</div>
                <!-- content of the page -->
                <div class="lp-panel tcpa-message-pannel">
                    <!-- content page head -->
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Add New Message
                            </h2>
                            <ul class="action-view-list">
                                <li class="action-view-item desktop active">
                                    <i class="ico ico-devices"></i>
                                </li>
                                <li class="action-view-item mobile">
                                    <i class="ico ico-Mobile"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="col-right">
                            <div class="tcpa-checkbox-btn">
                                <label class="checkbox-label">
                                    <input class="field-label" type="checkbox" checked>
                                    <span class="checkbox-area">
                                        <span class="handle"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- content page body -->
                    <div class="lp-panel__body">
                        <div class="tcpa-message-detail">
                            <div class="background-detail__area">
                                <div class="theme__header">
                                    <div class="dots"></div>
                                    <div class="dots"></div>
                                    <div class="dots"></div>
                                </div>
                                <div class="tcpa-iframe-holder">
                                    <div class="tcpa-iframe-area">
                                        <iframe class="tcpa-iframe" src="tcpa-message-content-handlebar.php"></iframe>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-controls-block">
                                <div class="right-block-holder">
                                    <div class="form-group">
                                        <div class="title-holder">
                                            <strong class="title">Message Name</strong>
                                        </div>
                                        <div class="field-holder">
                                            <input type="text" class="form-control" placeholder="Simple consent message">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="title-holder">
                                            <strong class="title">Content</strong>
                                        </div>
                                        <div class="field-holder">
                                            <div class="classic-editor__wrapper">
                                                <div class="tcpa-message-froala">
                                                    By clicking on “Submit” button, I verify this is my email address and consent to receive email messages via automated technology.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="field-holder">
                                           <div class="checkbox-area">
                                               <label class="label-text">Add “required” checkbox</label>
                                               <div class="tcpa-checkbox-btn-small">
                                                   <label class="checkbox-label">
                                                       <input class="field-label" type="checkbox">
                                                       <span class="checkbox-area">
                                                            <span class="handle"></span>
                                                        </span>
                                                   </label>
                                               </div>
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
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
