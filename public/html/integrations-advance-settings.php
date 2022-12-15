<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
    <!-- contain the main content of the page -->
    <div  id="content">
        <!-- header of the page -->
        <?php
        include ("includes/header.php");
        ?>
        <!-- contain main informative part of the site -->
        <main class="main">
            <!-- content of the page -->
            <section class="main-content integration-advance-page">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Integrations / BNTouch
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Integrations" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span> Watch how to video</a>
                        <a href="integrations-advance.php" class="back-link"><span class="icon icon-back ico-caret-up"></span> Back to integrations page</a>
                    </div>
                </div>
                <div class="integration-content-block-holder">
                    <!-- integration-content-block -->
                    <div class="integration-content-block">
                        <div class="integration-apps-detail">
                            <strong class="integration-apps-detail__title"><i class="icon ico-settings"></i> Advanced</strong>
                            <div class="integration-logos-area">
                                <span class="arrow"><i class="ico-arrow-right"></i></span>
                                <div class="integration-logos-area__wrap">
                                    <div class="integration-logos-area__logo-block">
                                        <img src="assets/images/logo-micro.png" width="34" title="Leadpops" alt="Leadpops">
                                    </div>
                                    <div class="integration-logos-area__logo-block setting">
                                        <img src="assets/images/advance-integrations-logos/bn-touch-logo.png" title="BnTouch" alt="BnTouch">
                                    </div>
                                </div>
                            </div>
                            <strong class="integration-apps-detail__heading">leadPops BNTouch Integration</strong>
                            <p>Easily create and update contacts in BNTouch with leadPops powerful data capture&nbsp;forms.</p>
                            <div class="integration-apps-detail__btn-holder">
                                <a href="#" class="button button-primary">Talk to Us</a>
                            </div>
                        </div>
                    </div>
                    <!-- integration-content-block -->
                    <div class="integration-content-block">
                        <div class="integration-text-area">
                            <strong class="integration-text-area__heading">About BNTouch</strong>
                            <p>BNTouch is an IT business management platform that helps service providers improve efficiency and data visibility. With leadPops BNTouch integration, you can send form data to your BNTouch system and automatically create or update new contacts. No manual data entry needed! Easily collect customer data and get access to key Formstack features for your team, including flexible form management & publishing, streamlined approvals, and data&nbsp;routing.</p>
                            <ul class="integration-text-area__list">
                                <li>Map form fields to your fields in BNTouch</li>
                                <li>Create or update contacts (& associated company&nbsp;records)</li>
                                <li>Simplify workflows & empower your service desk with smart data capture&nbsp;forms</li>
                                <li>Supports both cloud & on-premise versions of&nbsp;ConnectWise</li>
                            </ul>
                            <span class="list-text">This BNTouch integration is one of leadPops Advanced Integrations - <a href="#">sign up here</a>.</span>
                            <div class="integration-text-area__list-holder">
                                <strong class="integration-text-area__heading">What you'll need</strong>
                                <ul class="integration-text-area__list">
                                    <li>leadPops account</li>
                                    <li>BNTouch account</li>
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
<?php
include ("includes/footer.php");
?>