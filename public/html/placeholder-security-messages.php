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
				<!-- Title wrap of the page -->
				<div class="main-content__head">
					<div class="col-left">
						<h1 class="title">
							Security Message : <span class="funnel-name">203K Hybrid Loans</span>
						</h1>
					</div>
					<div class="col-right">
						<a data-lp-wistia-title="SEO" data-lp-wistia-key="ji1qu22nfq" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
							<span class="icon ico-video"></span>
							Watch how to video
						</a>
					</div>
				</div>
				<!-- content of the page -->
				<div class="c-contest__panel">
					<div class="c-contest__wrapper">
						<h2 class="c-contest__placeholder">You haven't created any security messages yet.</h2>
						<a class="button button-primary" href="list-security-messages.php">create my first message</a>
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