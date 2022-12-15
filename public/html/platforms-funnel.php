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
            <section class="main-content">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Platforms / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Platforms / Funnel" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span> Watch how to video</a>
                    </div>
                </div>
                <!-- content of the page -->
                <div class="integration integration_platforms-funnel">
                    <div class="integration__row">
                        <div class="integration__grid">
                            <a class="integration__link" href="platform-wordpress.php">
                                <div class="integration__box">
                                    <div class="integration__logo">
                                        <img src="assets/images/logos/wordpress-logo.png" alt="WordPress Logo">
                                    </div>
                                    <h2 class="integration__name">
                                        Wordpress.com
                                    </h2>
                                    <p class="integration__desc">
                                        Lorem ipsum dolor sit amet
                                        consectetur&nbsp;adipiscing.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="integration__grid">
                            <a class="integration__link" href="platform-square-space.php">
                                <div class="integration__box">
                                    <div class="integration__logo">
                                        <img src="assets/images/logos/square-space-logo.png" alt="Square Space Logo">
                                    </div>
                                    <h2 class="integration__name">
                                        SquareSpace
                                    </h2>
                                    <p class="integration__desc">
                                        Lorem ipsum dolor sit amet
                                        consectetur&nbsp;adipiscing.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="integration__grid">
                            <a class="integration__link" href="platform-weebly.php">
                                <div class="integration__box">
                                    <div class="integration__logo">
                                        <img src="assets/images/logos/weebly-logo.png" alt="Weebly Logo">
                                    </div>
                                    <h2 class="integration__name">
                                        Weebly
                                    </h2>
                                    <p class="integration__desc">
                                        Lorem ipsum dolor sit amet
                                        consectetur&nbsp;adipiscing.
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="integration__grid">
                            <a class="integration__link" href="platform-unbounce.php">
                                <div class="integration__box">
                                    <div class="integration__logo">
                                        <img src="assets/images/logos/unbounce-logo.png" alt="Unbounce Logo">
                                    </div>
                                    <h2 class="integration__name">
                                        Unbounce
                                    </h2>
                                    <p class="integration__desc">
                                        Lorem ipsum dolor sit amet
                                        consectetur&nbsp;adipiscing.
                                    </p>
                                </div>
                            </a>
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
            </section>
        </main>
    </div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
