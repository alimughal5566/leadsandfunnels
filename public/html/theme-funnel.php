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
            <section class="main-content theme-page">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Themes / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Themes / Funnel" data-lp-wistia-key="ukxb3c6k74" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span>
                            Watch how to video
                        </a>
                    </div>
                </div>
                <!-- content of the page -->
                <div class="lp-panel lp-panel_tabs lp-panel__pb-0">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <div class="action">
                                <ul class="action__list">
                                    <li class="action__item">
                                        Themes
                                    </li>
                                    <li class="action__item theme__selection">
                                        <label for="select2__theme">
                                            Select Theme
                                        </label>
                                        <div class="select2__theme-parent">
                                            <select id="select2__theme" class="form-control select2__theme">
                                                <option value="boxed">Boxed</option>
                                                <option value="fullwidth">Full - Width</option>
                                            </select>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-right">
                            <ul class="nav nav__tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" target="_blank" href="http://ltest-refinance-site-7171.secure-clix.com">Preview</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#computer">
                                        <span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#mobile">
                                        <span class="ico ico-mobile el-tooltip" title="Mobile"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="theme__wrapper">
                            <div class="theme__header">
                                <div class="dots"></div>
                                <div class="dots"></div>
                                <div class="dots"></div>
                            </div>
                            <div class="theme__body">
                                <div class="tab-content">
                                    <div id="computer" class="tab-pane show active">
                                        <img src="assets/images/theme-img.png" width="100%" alt="theme image">
                                    </div>
                                    <div id="mobile" class="tab-pane">
                                        <img src="assets/images/theme-img.png" width="100%" alt="theme image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="lp-panel__footer">-->
<!--                        <div class="theme__desc">-->
<!--                            <p>*** due to specific design the selected-->
<!--                                “Magic” theme will disable the ability to-->
<!--                                customize Progress Bar and Form&nbsp;Background-->
<!--                            </p>-->
<!--                        </div>-->
<!--                    </div>-->
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