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
                    <form id="thkform"  method="get" action="">
                        <!-- Title wrap of the page -->
                        <div class="main-content__head">
                            <div class="col-left">
                                <h1 class="title">
                                    Thank You Page / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                                </h1>
                            </div>
                            <div class="col-right">
                                <a data-lp-wistia-title="Thank You" data-lp-wistia-key="cx6hoxi228" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                    <span class="icon ico-video"></span> Watch how to video</a>
                            </div>
                        </div>
                        <!-- content of the page -->
                        <div class="lp-panel">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Thank You Page
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                                <span class="action__span">
                                                    <a href="thank-you-edit-basic.php" class="action__link">
                                                        <span class="ico ico-edit"></span>Edit Page
                                                    </a>
                                                </span>
                                            </li>
                                            <li class="action__item">
                                                <div class="button-switch">
                                                    <input checked  class="thktogbtn" id="thirldparty" name="thirldparty"
                                                           data-thelink="thirdparty_active" data-toggle="toggle"
                                                           data-onstyle="active" data-offstyle="inactive"
                                                           data-width="127" data-height="43" data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <p class="lp-custom-para">
                                    Upon submission, your Funnel will take potential clients to a customizable "Thank You" page.
                                </p>
                            </div>
                        </div>
                        <div class="lp-panel">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Third Party URL
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item action__item_separator">
                                                <span class="action__span action__span_3rd-party">
                                                    <a id="eurllink" href="javascript:void(0)" class="action__link action__link_edit lp_thankyou_toggle">
                                                        <span class="ico ico-edit"></span>edit url
                                                    </a>
                                                    <a href="javascript:void(0)" class="action__link action__link_cancel">
                                                        <span class="ico ico-cross"></span>cancel
                                                    </a>
                                                </span>
                                            </li>
                                            <li class="action__item">
                                                <div class="button-switch">
                                                    <input class="thktogbtn" id="thankyou" name="thankyou"
                                                           data-thelink="thankyou_active" data-toggle="toggle" data-onstyle="active"
                                                           data-offstyle="inactive" data-width="127" data-height="43"
                                                           data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="default__panel">
                                    <p class="lp-custom-para">
                                        This simple option gives your potential clients a quick thank you message,
                                        and then forwards them to a third party website of your choice. You can forward
                                        your potential clients to your company website, personal website, blog,
                                        Facebook page, or other&nbsp;website.
                                    </p>
                                </div>
                                <div class="third-party__panel">
                                        <div class="select2__parent-url-prefix">
                                            <select class="form-control flex-grow-0 url-prefix" name="">
                                                <option value="">http://</option>
                                                <option value="">https://</option>
                                            </select>
                                        </div>
                                        <div class="input-holder flex-grow-1">
                                            <input id="thrd_url" name="thrd_url" class="form-control" type="text" placeholder="www.facebook.com/MyBusinessPage">
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- content of the page -->
                        <!-- footer of the page -->
                        <div class="footer">
<!--                            <div class="row">-->
<!--                                <button type="submit" class="button button-secondary">Save</button>-->
<!--                            </div>-->
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