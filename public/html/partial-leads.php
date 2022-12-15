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

				<form id="pricay-page" method="get" action="">
					<!-- Title wrap of the page -->
					<div class="main-content__head">
						<div class="col-left">
							<h1 class="title">
								Partial Leads / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
							</h1>
						</div>
						<div class="col-right">
							<a data-lp-wistia-title="Header" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
								<span class="icon ico-video"></span>
								Watch how to video
							</a>
						</div>
					</div>
					<!-- content of the page -->
					<div class="lp-panel lp-panel_partial-leads">
                        <div class="lp-panel__checkbox">
                            <p>
                                Do you want to receive partial leads that aren't fully completed?
                            </p>
                            <div class="radio">

                                <ul class="radio__list">
                                    <li class="radio__item">
                                        <input class="lp-popup-radio" type="radio" id="partialLeads_yes" name="partailLeads" value="y">
                                        <label class="radio__lbl" for="partialLeads_yes">Yes</label>
                                    </li>
                                    <li class="radio__item">
                                        <input class="lp-popup-radio" type="radio" id="partialLeads_no" name="partailLeads" value="n" checked="checked">
                                        <label class="radio__lbl" for="partialLeads_no" val="no">No</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
						<div class="lp-panel__content">
                            <p>
                                Partial Lead Submissions lets you collect the information someone entered into a Funnel <br>
                                before they decided to abandon it.
                            </p>
                            <p>
                                This means if they leave/close your Funnel, or if they remain idle for more than 5 minutes, <br>
                                we deliver all the data we've collected to you.
                            </p>
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