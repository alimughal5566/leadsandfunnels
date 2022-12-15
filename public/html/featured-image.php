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

                <form id="favicon-form" method="post" action="">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Featured Image  / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Featured Media" data-lp-wistia-key="z106urnox6" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->

                    <div class="lp-panel featured-image-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Featured Image
                                </h2>
                            </div>
                            <div class="col-right">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item action__item_separator">
                                                <span class="action__span">
                                                    <a href="#" class="action__link">
                                                        <span class="ico ico-undo"></span>reset default image
                                                    </a>
                                                </span>
                                        </li>
                                        <li class="action__item">
                                            <input checked class="thktogbtn" id="thankyou" name="thankyou"
                                                   data-thelink="thankyou_active" data-toggle="toggle" data-onstyle="active"
                                                   data-offstyle="inactive" data-width="127" data-height="43"
                                                   data-on="INACTIVE" data-off="ACTIVE" type="checkbox">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="img-frame__wrapper">
                                <div class="message-block" style="">(You haven't uploaded a featured image yet!)</div>
                                <div class="img-frame__content">
                                    <div class="preview__wrapper">
                                        <img class="img-frame__preview" src="" alt="">
                                    </div>
                                </div>
                                <div class="img-frame__controls">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item featured-img-del">
                                                <button class="btn-image__del button button-cancel">
                                                    delete
                                                </button>
                                            </li>
                                            <li class="action__item">
                                                <div class="lp-image__browse">
                                                    <label class="button button-primary" for="browse_img">
                                                        <input id="browse_img" class="lp-image__input" type="file" accept="image/*" required value="" />
                                                        Browse
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="file__control">
                                            <p class="file__extension">Invalid image format! image format must be PNG, JPG, JPEG</p>
                                            <p class="file__size">Maximum file size limit is 4MB.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- content of the page -->
                    <!-- footer of the page -->
                    <div class="footer">
<!--                        <div class="row">-->
<!--                            <button type="submit" class="button button-secondary">Save</button>-->
<!--                        </div>-->
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