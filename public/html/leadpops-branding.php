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
		<section class="main-content lp-branding">
			<!-- Title wrap of the page -->
			<div class="main-content__head">
				<div class="col-left">
					<h1 class="title">
						leadPops Branding / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
					</h1>
				</div>
				<div class="col-right">
					<a data-lp-wistia-title=" Open in Popup" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
						<span class="icon ico-video"></span> Watch how to video</a>
				</div>
			</div>
            <div class="lp-panel lp-panel_switch">
                <div class="lp-panel__head">
                    <div class="col-left">
                        <h2 class="lp-panel__title">Would you like to turn leadPops branding off?</h2>
                    </div>
                    <div class="col-right">
                        <div class="radio">
                            <ul class="radio__list">
                                <li class="radio__item" data-toggle="modal" data-target="#branding-feature-modal">
                                    <input type="radio" id="brandingOn" value="brandingOn" name="lp-branding" checked>
                                    <label for="brandingOn">Yes, turn it off</label>
                                </li>
                                <li class="radio__item">
                                    <input type="radio" id="brandingOff" value="brandingOff" name="lp-branding">
                                    <label for="brandingOff">No, leave it as it is</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
			<div class="lp-panel lp-panel_tabs">
				<div class="lp-panel__head">
					<div class="col-left m-0">
						<h2 class="lp-panel__title lp-panel__title_regent-gray">Customize Your Own</h2>
						<ul class="nav nav__tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" href="#">
									<span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span class="ico ico-mobile el-tooltip" title="Mobile"></span>
								</a>
							</li>
						</ul>
					</div>
					<div class="right-col">
						<input  id="lp-branding-page" name="lp-branding-page" data-toggle="toggle"
						        data-onstyle="active" data-offstyle="inactive"
						        data-width="127" data-height="43" data-on="INACTIVE"
						        data-off="ACTIVE" type="checkbox" checked>
					</div>
				</div>
				<div class="lp-panel__body">
					<div class="background-detail">
						<div class="background-detail__area">
							<div class="theme__header">
								<div class="dots"></div>
								<div class="dots"></div>
								<div class="dots"></div>
							</div>
							<div class="background-detail__overlay-image">
								<img src="assets/images/advance-background.png" alt="Mortgage">
							</div>
						</div>
						<div class="bg-controls-block">
                            <div class="custom-scroll-holder">
                                <div class="custom-scroll-holder__wrap">
                                    <div class="logo-upload-option">
                                        <label>Upload an Image
                                            <span class="question-mark el-tooltip" title="Tooltip Content">
                                        <span class="ico ico-question"></span>
                                    </span>
                                        </label>
                                        <div class="dropzone needsclick bg-main__dropzone" id="main-bg-image">
                                            <div class="dz-message needsclick">
                                                <i class="icon ico-plus"></i>
                                                <span class="text-uppercase">upload image</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="logo-other-option">
                                        <div class="form-group">
                                            <label>Image Size</label>
                                            <div class="slider-wrapper">
                                                <input class="bg-slider" type="text" data-slider-min="0" data-slider-max="100" value="65"/>
                                            </div>
                                        </div>
                                        <div class="form-group image-pos">
                                            <label>Image Position</label>
                                            <div class="select2js__position-parent select2-parent">
                                                <select name="select2js__position" id="select2js__position">
                                                    <option>Bottom Right</option>
                                                    <option>Top Right</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="backlink-area">
                                            <div class="form-group">
                                                <label for="backlink">Embed Backlink  </label>
                                                <div class="switcher-min">
                                                    <input id="backlink" class="backlink-opener" name="hide03"
                                                           data-toggle="toggle min"
                                                           data-onstyle="active" data-offstyle="inactive"
                                                           data-width="71" data-height="28" data-on="OFF"
                                                           data-off="ON" type="checkbox">
                                                </div>
                                            </div>
                                            <div class="backlink-slide" style="display: none">
                                            <div class="form-group">
                                                <div class="input-icon">
                                                    <span><i class="ico ico-link"></i></span>
                                                    <input class="form-control" type="text" placeholder="Backlink URL">
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Open Backlink in</label>
                                            <div class="select2js__link-parent select2-parent">
                                                <select id="select2js__link">
                                                    <option>New Window</option>
                                                    <option>Same</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="logo-text">
                                            <div class="form-group">
                                                <label>Title Text
                                                    <span class="question-mark el-tooltip" title="Tooltip Content">
                                                <span class="ico ico-question"></span>
                                            </span>
                                                </label>
                                                <input class="form-control" type="text" value="Calculate your credit score!">
                                            </div>
                                            <div class="form-group">
                                                <label>Image Alt Text</label>
                                                <input class="form-control" type="text" value="Fairway Corporate Logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
</div>

<div class="modal fade clone-feature-modal plan" id="feature-modal-price">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><i class="ico ico-cross"></i></button>
            <div class="modal-body">
                <div class="upgrade-plan-area">
                    <h2>You discovered a <span>premium feature</span>!</h2>
                    <div class="nav-tabs-wrap">
                        <ul class="nav nav-tabs plan-tabs">
                            <li>
                                <a class="active" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="true">Monthly</a>
                            </li>
                            <li>
                                <a id="annually-tab" data-toggle="tab" href="#annually" role="tab" aria-controls="annually" aria-selected="false">Annually</a>
                            </li>
                            <li class="bg-animation"></li>
                        </ul>
                        <div class="upgrade-plan-area__discount-info">
                            <span class="upgrade-plan-area__text">Save 20%</span>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                            <div class="upgrade-plan-area__package-row-wrap">
                                <div class="upgrade-plan-area__package-row">
                                    <div class="upgrade-plan-area__package-col">
                                        <div class="upgrade-plan-area__content">
                                            <div class="upgrade-plan-area__heading">
                                                <h3>Premium</h3>
                                                <span class="upgrade-plan-area__sub-text">Unlimited Premium Features</span>
                                            </div>
                                            <div class="upgrade-plan-area__price-info">
                                                <strong class="price">$100</strong>
                                                <span class="price-text">per month</span>
                                            </div>
                                            <a href="#" class="button button-plan">unlock premium</a>
                                        </div>
                                        <div class="upgrade-plan-area__list-holder">
                                            <ul class="upgrade-plan-area__list">
                                                <li><span class="list-heading">Funnels branding customizations allow you to:</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="funnel-plan-section__footer">
                                    <p>This is an account-wide upgrade, not just for this Funnel. <br> You can cancel this feature any time.</p>
                                    <span data-dismiss="modal">no thanks</span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="annually" role="tabpanel" aria-labelledby="annually-tab">
                            <div class="upgrade-plan-area__package-row-wrap annually">
                                <div class="upgrade-plan-area__package-row">
                                    <div class="upgrade-plan-area__package-col">
                                        <div class="upgrade-plan-area__content">
                                            <div class="upgrade-plan-area__heading">
                                                <h3>Premium</h3>
                                                <span class="upgrade-plan-area__sub-text">Unlimited Premium Features</span>
                                            </div>
                                            <div class="upgrade-plan-area__price-info">
                                                <strong class="price">$100</strong>
                                                <span class="price-text">per month</span>
                                            </div>
                                            <a href="#" class="button button-plan">unlock premium</a>
                                        </div>
                                        <div class="upgrade-plan-area__list-holder">
                                            <ul class="upgrade-plan-area__list">
                                                <li><span class="list-heading">Funnels branding customizations allow you to:</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span></li>
                                                <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="funnel-plan-section__footer">
                                    <p>This is an account-wide upgrade, not just for this Funnel. <br> You can cancel this feature any time.</p>
                                    <span data-dismiss="modal">no thanks</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--feature modal-->
<div class="modal fade" id="branding-feature-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><i class="ico ico-cross"></i></button>
            <div class="modal-body">
                <div class="funnel-plan-section">
                    <div class="funnel-plan-section__logo-area">
                        <div class="upgrade-plan-area">
                            <h2>You discovered a <span>premium feature</span>!</h2>
                            <div class="nav-tabs-wrap">
                                <ul class="nav nav-tabs plan-tabs">
                                    <li>
                                        <a class="active" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="true">Monthly</a>
                                    </li>
                                    <li>
                                        <a id="annually-tab" data-toggle="tab" href="#annually" role="tab" aria-controls="annually" aria-selected="false">Annually</a>
                                    </li>
                                    <li class="bg-animation"></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                    <ul class="upgrade-plan-area__list">
                                        <li><span class="list-heading">Funnels branding customizations allow you to:</span></li>
                                        <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span></li>
                                        <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span></li>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="annually" role="tabpanel" aria-labelledby="annually-tab">
                                    <ul class="upgrade-plan-area__list">
                                        <li><span class="list-heading">Funnels branding customizations allow you to:</span></li>
                                        <li><span class="list-text"><i class="ico-check"></i>Remove leadPops branding from any of your Funnels</span></li>
                                        <li><span class="list-text"><i class="ico-check"></i>Replace leadPops branding with your own logo and backlink</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="funnel-plan-section__content">
                        <h2>Funnel branding customization is a Premium feature <br>
                            that's only available on the "<strong>Pro</strong>" plan.</h2>
                        <span class="funnel-plan-section__subtitle">You can Upgrade to "Pro" and unlock this feature here!</span>
                        <div class="funnel-plan-section__quote-area">
                            <div class="funnel-plan-section__wrap">
                                <div class="upgrade-plan-area__package-row-wrap">
                                    <i class="arrow"></i>
                                    <div class="upgrade-plan-area__package-row">
                                        <div class="upgrade-plan-area__package-col">
                                            <div class="upgrade-plan-area__content">
                                                <div class="upgrade-plan-area__heading">
                                                    <h3>Marketer</h3>
                                                    <span class="upgrade-plan-area__sub-text">35 Premade Funnels</span>
                                                </div>
                                                <div class="upgrade-plan-area__price-info">
                                                    <strong class="price">$97</strong>
                                                    <span class="price-text">per month</span>
                                                </div>
                                                <a href="#" class="button button-plan disabled">Current Plan</a>
                                            </div>
                                            <div class="upgrade-plan-area__list-holder">
                                                <ul class="upgrade-plan-area__list">
                                                    <li><span class="list-text"><i class="ico-check"></i>Access to optimized Funnels</span></li>
                                                    <li><span class="list-text"><i class="ico-check"></i>Access to Sticky Bar Builder</span></li>
                                                    <li><span class="list-text"><i class="ico-check"></i>Unlimited traffic & leads</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="upgrade-plan-area__package-col">
                                            <div class="upgrade-plan-area__content">
                                                <div class="upgrade-plan-area__package-unlock">
                                                    <span class="ico ico-plus"></span>
                                                    <div class="upgrade-plan-area__unlock-pro">
                                                        <div class="upgrade-plan-area__heading">
                                                            <h3>Pro</h3>
                                                            <span class="upgrade-plan-area__sub-text">Yup, Unlimited Funnels</span>
                                                        </div>
                                                        <div class="upgrade-plan-area__price-info">
                                                            <strong class="price">$197</strong>
                                                            <span class="price-text">per month</span>
                                                        </div>
                                                    </div>
                                                    <div class="upgrade-plan-area__unlock-pre">
                                                        <div class="upgrade-plan-area__heading">
                                                            <h3>Premium</h3>
                                                            <span class="upgrade-plan-area__sub-text">Remove leadPops Branding</span>
                                                        </div>
                                                        <div class="upgrade-plan-area__price-info">
                                                            <strong class="price">$100</strong>
                                                            <span class="price-text">per month</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="#feature-modal-price" data-toggle="modal" data-dismiss="modal" class="button button-plan">Upgrade My Plan + unlock premium</a>
                                            </div>
                                            <div class="upgrade-plan-area__list-holder">
                                                <ul class="upgrade-plan-area__list">
                                                    <li><span class="list-heading">Everything in Marketer, plus:</span></li>
                                                    <li><span class="list-text"><i class="ico-check"></i>Clone feature gives you UNLIMITED <br> Lead Funnels & Sticky Bars</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="funnel-plan-section__footer">
                                    <p>This is an account-wide upgrade, not just for this Funnel. You can cancel this feature any time.</p>
                                    <span data-dismiss="modal">no thanks</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
