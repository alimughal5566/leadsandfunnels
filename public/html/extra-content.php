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
			<section class="main-content">

				<form id="extra-content-page" method="get">
					<!-- Title wrap of the page -->
					<div class="main-content__head">
						<div class="col-left">
							<h1 class="title">
								Extra Content / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
							</h1>
						</div>
						<div class="col-right">
							<a data-lp-wistia-title="Extra Content" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
								<span class="icon ico-video"></span> Watch how to video</a>
						</div>
					</div>
					<!-- content of the page -->
					<div class="lp-panel">
						<div class="lp-panel__head">
							<div class="col-left">
								<h2 class="lp-panel__title">
									Extra Content Editor
									<span class="question-mark el-tooltip" title="Tooltip Content">
										<span class="ico ico-question"></span>
									</span>
								</h2>
							</div>
							<div class="col-right">
								<div class="action">
									<ul class="action__list">
										<li class="action__item">
											<input  id="fp-privacy-policy" name="fp-privacy-policy" data-toggle="toggle"
											        data-onstyle="active" data-offstyle="inactive"
											        data-width="127" data-height="43" data-on="INACTIVE"
											        data-off="ACTIVE" type="checkbox" checked>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="lp-panel__body">
                            <div class="classic-editor__wrapper exta-content froala-editor-fixed-width">
                                <textarea class="lp-froala-textbox"></textarea>
                            </div>
						</div>
                        <div class="lp-panel__footer">
                            <div class="checkbox">
                                <input type="checkbox" id="footercontenthide" name="footercontenthide" value="">
                                <label class="normal-font" for="footercontenthide"></label>
                                Hide Primary and Secondary footer content
                                <span class="question-mark el-tooltip" title="Tooltip Content">
                                    <span class="ico ico-question"></span>
                                </span>
                            </div>
                        </div>
					</div>
					<!-- content of the page -->
					<!-- footer of the page -->
					<div class="footer">
						<div class="row">
							<img src="assets/images/footer-logo.png" alt="footer logo">
						</div>
					</div>
				</form>
			</section>
		</main>
	</div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>