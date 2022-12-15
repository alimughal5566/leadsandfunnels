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
            <section class="main-content funnel-share">
                <!-- Title wrap of the page -->
                <div class="main-content__head">
                    <div class="col-left">
                        <h1 class="title">
                            Share Your Funnel / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a data-lp-wistia-title="Share Your Funnel" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span> Watch how to video</a>
                    </div>
                </div>
                <!-- content of the page -->
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Your Funnel Lives in This Link
                            </h2>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="form-group m-0 funnel_url">
                            <label for="funnel_url">Funnel URL:</label>
                            <div class="input__wrapper">
                                <div class="input-holder input-holder_icon position-relative">
                                    <span class="ico ico-lock"></span>
                                    <div id="funnelUrl" name="funnel_url" class="form-control pl-6 d-flex">
                                        <div class="url-text">http://pops28.funnel.com/to/eBM3Vi</div>
                                        <a href="#" class="hover-hide">
                                            <i class="fbi fbi_dots">
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                                <i class="fa fa-circle" aria-hidden="true"></i>
                                            </i>
                                        </a>
                                        <ul class="lp-controls">
                                            <li class="lp-controls__item lp-controls__item_copy-url">
                                                <a href="#" class="lp-controls__link el-tooltip" title="Copy Full Funnel URL" onclick="copyToClipboard('#funnelUrl')">
                                                    <i class="ico ico-copy"></i>
                                                </a>
                                            </li>
                                            <li class="lp-controls__item">
                                                <a href="#" class="lp-controls__link el-tooltip" title="Open Funnel Link In New Tab">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="form-control link-swatcher el-tooltip" data-container="body" title="SHORTEN URL (Coming Soon!)"><i class="fas fa-exchange-alt"></i></a>
                            <button class="button button-bold button-primary" onclick="copyToClipboard('#funnelUrl')">SAVE & COPY URL</button>
                        </div>
                        <div class="url-expand">
                            <div class="form-group m-0">
                                <label for="shortUrl">Short URL: </label>
                                <div class="input__wrapper">
                                    <div class="input-holder input-holder_icon position-relative">
                                        <span class="ico ico-link"></span>
                                        <div id="shortUrl" class="shortUrl">
                                            <div class="input-holder">
                                                <div class="url-text">https://lynx.ly/<strong class="inner-text font-weight-normal">refi</strong></div>
                                                <input type="text" name="funnel_url" class="form-control pl-6 form-url-text" value="refi" readonly>
                                            </div>
                                            <a href="#" class="hover-hide">
                                                <i class="fbi fbi_dots">
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                </i>
                                            </a>
                                            <ul class="lp-controls">
                                                <li class="lp-controls__item"><a href="#" class="lp-controls__link lp-controls__edit el-tooltip" title="Edit"><i class="ico ico-edit"></i></a></li>
                                                <li class="lp-controls__item">
                                                    <a href="#" class="lp-controls__link el-tooltip" title="Open Funnel Link in New Tab"><i class="fas fa-external-link-alt"></i></a>
                                                </li>
                                            </ul>
                                            <ul class="option_list">
                                                <li><a href="#" id="doEditPopUpBtn">Save</a></li>
                                                <li><a href="#" class="cancel-option">Cancel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="form-control link-swatcher el-tooltip" data-container="body" title="Remove & Delete This Short URL"><i class="fas fa-times"></i></a>
                                <button class="button button-bold button-primary" onclick="copyToClipboard('#shortUrl')">SAVE & COPY URL</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Social Media and Email
                            </h2>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="action social-media">
                            <ul class="action__list">
                                <li class="action__item">
                                    <a href="#" class="action__link">
                                        <span class="social-share facebook">
                                            <i class="fa fa-facebook"></i>
                                            facebook
                                        </span>
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="#" class="action__link">
                                        <span class="social-share twitter">
                                            <i class="fa fa-twitter"></i>
                                            twitter
                                        </span>
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="#" class="action__link">
                                        <span class="social-share linkedin">
                                            <i class="fa fa-linkedin"></i>
                                            linkedin
                                        </span>
                                    </a>
                                </li>
<!--                                <li class="action__item">-->
<!--                                    <a href="#" class="action__link">-->
<!--                                        <span class="social-share buffer">-->
<!--                                            <i class="fab fa-buffer"></i>-->
<!--                                            bufferapp-->
<!--                                        </span>-->
<!--                                    </a>-->
<!--                                </li>-->
                                <li class="action__item">
                                    <a href="#" class="action__link">
                                        <span class="social-share email">
                                            <i class="fas fa-envelope-open-text"></i>
                                            email
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="lp-panel pb-0">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Social Share Image
                                <span class="question-mark el-tooltip" title="<p>Your Social Share Image is what shows when you share your <br> Funnel link on social media.</p><p>Ideal dimensions for a custom social share image that works <br> well on Facebook, Twitter, and LinkedIn are 1,200 x 628 pixels.</p><p>If you don't upload a social share image, we'll automatically <br> pull your Funnel's Featured Image.</p><p>If you don't have a Featured Image, <br> we'll pull your Funnel's Logo.</p><p class='m-0'>If you don't have a Logo or a Featured Image, and you don't <br> upload a Social share Image below, no image will be shown <br> when you share your Funnel link.</p>">
                                    <span class="ico ico-question"></span>
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="lp-panel__body p-0">
                        <div class="browse__content browse__content_upload-social">
                            <div class="browse__step1">
                                <div class="browse__desc">
                                    <p>
                                        You have not added any Social Share image yet.
                                    </p>
                                    <div class="lp-image__browse">
                                        Click
                                        <label class="lp-image__button" for="Pagebrowse_img1">
                                            <input id="Pagebrowse_img1" name="Pagebrowse_img1" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                            Browse
                                        </label>
                                        to start uploading.
                                    </div>
                                    <div class="file__control">
                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                    </div>
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
                                                        <p class="file__imgsize">Image you choose should be at least 32x32&nbsp;pixels</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content of the page -->
                <!-- footer of the page -->
                <div class="footer">
                    <div class="row">
                        <button class="button button-secondary">Save</button>
                    </div>
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
