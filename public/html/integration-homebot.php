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
		<main class="main">
			<!-- content of the page -->
			<section class="main-content">
				<!-- Title wrap of the page -->
				<div class="main-content__head">
					<div class="col-left">
						<h1 class="title">
							Integrations / Homebot
						</h1>
						<input checked id="integration-homebot-page" name="integration-homebot-page" data-toggle="toggle"
						       data-onstyle="active" data-offstyle="inactive"
						       data-width="127" data-height="43" data-on="INACTIVE"
						       data-off="ACTIVE" type="checkbox">
					</div>
					<div class="col-right">
						<a href="integrations-funnel.php" class="back-link"><span class="icon icon-back ico-caret-up"></span> Back to integrations</a>
					</div>
				</div>
				<!-- content of the page -->

				<div class="lp-panel">
					<div class="lp-panel__head">
						<div class="col-left">
							<h2 class="lp-panel__title">
								<span class="font-regular">
									<img src="https://images.lp-images1.com/default/images/homebot-logo.png" width="35" alt="homebot">
									Funnel:</span> 203k Finder / 203k-loan-finner.secure-clix.com
							</h2>
						</div>
						<div class="col-right">
							<div class="switcher-min">
                                <input checked id="homebot-contact" name="homebot-contact" data-toggle="toggle min"
                                       data-onstyle="active" data-offstyle="inactive"
                                       data-width="92" data-height="28" data-on="INACTIVE"
                                       data-off="ACTIVE" type="checkbox">
                            </div>
						</div>
					</div>
					<div class="lp-panel__body">
						<div class="authenticate">
							<div class="authenticate__placeholder">
								<div class="authenticate__placeholder-text">This Funnel is connected to Homebot</div>
							</div>
							<div class="authenticate__panel">
								<h3 class="authenticate__head">
									Authenticate
								</h3>
								<p class="authenticate__desc">
									Hi! Enter your <a class="link" href="#">Velocify API Key</a> below to send submissions as contacts.
								</p>
								<form id="velocify_form" method="post" action="">
									<div class="authentication__form">
										<label for="api_key">API Key</label>
										<div class="input__wrapper">
											<input id="api_key" name="api_key" class="form-control" type="text">
										</div>
										<button class="button button-primary" type="submit">authenticate</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- content of the page -->

			</section>
		</main>
	</div>

<?php
include ("includes/footer.php");
?>