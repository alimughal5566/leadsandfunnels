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
                                Favicon  / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Favicon" data-lp-wistia-key="epni9wlwah" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->

                    <div class="browse__content">
                        <div class="browse__step1">
                            <div class="browse__desc">
                                <p>The favicon is used as a browser and app icon for your&nbsp;funnel.</p>
                                <p>
                                    The format for the image you choose should be at least 32x32&nbsp;pixels,&nbsp;using <br>
                                    either 8-bit or 24-bit colors. The format of the image must be one of PNG,&nbsp;JPG,&nbsp;or&nbsp;JPEG.
                                </p>
                                <div class="lp-image__browse">
                                    Click
                                    <label class="lp-image__button" for="browse_img">
                                        <input id="browse_img" name="profile_img" class="lp-image__input" type="file" accept="image/*" required value="" />
                                        Browse
                                    </label>
                                    to start uploading.
                                </div>
                                <div class="file__control">
                                    <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                    <p class="file__size">Maximum file size limit is 4MB.</p>
                                    <p class="file__imgsize">Image you choose should be at least 32x32&nbsp;pixels.</p>
                                </div>
                            </div>
                            <div class="browse__footer">
                                <p>
                                    Having issues with favicons? Try this out - <a href="http://faviconit.com" target="_blank">faviconit.com</a>
                                </p>
                            </div>
                        </div>
                        <div class="browse__step2">
                            <div class="img-frame__wrapper">
                                <div class="img-frame__content">
                                    <div class="preview__wrapper">
                                        <img class="img-frame__preview" src="" alt="">
                                    </div>
                                </div>
                                <div class="img-frame__controls">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item del__img">
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
                                                <div class="file__control">
                                                    <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                    <p class="file__size">Maximum file size limit is 4MB.</p>
                                                    <p class="file__imgsize">Image you choose should be at least 32x32&nbsp;pixels.</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- content of the page -->
                    <!-- footer of the page -->
                    <div class="footer">
<!--                        <div class="row lp-favicon__step2">-->
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