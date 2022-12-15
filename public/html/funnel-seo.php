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

                    <form id="add-seo" action="">
                        <!-- Title wrap of the page -->
                        <div class="main-content__head">
                            <div class="col-left">
                                <h1 class="title">
                                    SEO / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
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
                        <div class="lp-panel">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Title Tag
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <input checked  id="titletag" name="titletag"
                                            data-thelink="titletag_active" data-toggle="toggle"
                                            data-onstyle="active" data-offstyle="inactive"
                                            data-width="127" data-height="43" data-on="INACTIVE"
                                            data-off="ACTIVE" type="checkbox">
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="form-group m-0">
                                    <div class="input__holder">
                                        <input id="title__tag" name="title__tag" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Description
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <input  checked id="description" name="description"
                                            data-thelink="description_active" data-toggle="toggle"
                                            data-onstyle="active" data-offstyle="inactive"
                                            data-width="127" data-height="43" data-on="INACTIVE"
                                            data-off="ACTIVE" type="checkbox">
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="form-group m-0">
                                    <div class="input__holder">
                                        <textarea id="seo__desc" name="seo__desc"  class="form-control text-area"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel">
                            <div class="lp-panel__head">
                                <div class="col-left">
                                    <h2 class="lp-panel__title">
                                        Keywords
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <input  id="keyword" name="keyword"
                                            data-thelink="keyword_active" data-toggle="toggle"
                                            data-onstyle="active" data-offstyle="inactive"
                                            data-width="127" data-height="43" data-on="INACTIVE"
                                            data-off="ACTIVE" type="checkbox" >
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="form-group m-0">
                                    <textarea id="seo__keyword" name="seo__keyword" class="form-control text-area"></textarea>
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