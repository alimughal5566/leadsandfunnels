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

                <form id="fuploadload" enctype="multipart/form-data" action="">
                    <input type="hidden" name="swatches" id="swatches" value="">
                    <input type="hidden" name="key" id="key" value="">
                    <input type="hidden" name="scope" id="scope" value="">
                    <input type="hidden" name="logocnt" id="logocnt" value="3">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Logo / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Logo" data-lp-wistia-key="afbu8blfww" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="row logo-row">
                        <div class="col mb-1">
                            <div class="lp-panel mb-4">
                                <div class="lp-panel__head">
                                    <div class="col-left">
                                        <h2 class="lp-panel__title">
                                            Default Logo
                                        </h2>
                                    </div>
                                </div>
                                <div class="lp-panel__body">
                                    <div class="logo__wrapper">
                                        <div class="logo__body">
                                            <div class="img-content-logo">
                                                <img rel="stock" src="assets/images/default-logo.png" alt="Default logo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-1">
                            <div class="lp-panel mb-4">
                                <div class="lp-panel__head">
                                    <div class="col-left">
                                        <h2 class="lp-panel__title">
                                            Current Logo
                                        </h2>
                                    </div>
                                </div>
                                <div class="lp-panel__body lp-default-logo" id="droppable-photos-container-logo">
                                    <div class="logo__wrapper logo-default-img" id="lp-logo-default-img">
                                    </div>
                                </div>
                                <div class="lp-panel__footer drag__info">
                                    <p>
                                        Click and drag the logo of your choice from below into this&nbsp;box
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1">
                            <div class="lp-panel mb-4">
                                <div class="lp-panel__head">
                                    <div class="col-left">
                                        <h2 class="lp-panel__title">
                                            Upload Logos
                                        </h2>
                                    </div>
                                    <div class="col-right">
                                        <div class="file__control mr-4">
                                            <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                            <p class="file__size">Maximum file size limit is 4MB.</p>
                                        </div>
                                        <div class="action">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <div class="lp-image__browse d-flex align-items-center">
                                                        <p class="file-name"></p>
                                                        <label class="button button-primary" for="logo">
                                                            <input id="logo" class="lp-image__input" type="file" accept="image/*" required="" value="">
                                                            Browse
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__body">
                                    <div class="upload-logo__wrapper">
                                        <div class="row justify-content-center">
                                            <div class="col-4 p-0">
                                                <div class="upload-logo">
                                                    <div class="upload-logo__img">
                                                        <div class="img-content-logo">
                                                            <img rel="client" src="assets/images/client-logo1.png" alt="Default logo">
                                                        </div>
                                                    </div>
                                                    <div class="upload-logo__button">
                                                        <button class="button button-cancel del-logo">delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 p-0">
                                                <div class="upload-logo">
                                                    <div class="upload-logo__img">
                                                        <div class="img-content-logo">
                                                            <img rel="client" src="assets/images/client-logo2.png" alt="Default logo">
                                                        </div>
                                                    </div>
                                                    <div class="upload-logo__button">
                                                        <button class="button button-cancel del-logo">delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 p-0">
                                                <div class="upload-logo">
                                                    <div class="upload-logo__img">
                                                        <div class="img-content-logo">
                                                            <img rel="client" src="assets/images/client-logo3.png" alt="Default logo">
                                                        </div>
                                                    </div>
                                                    <div class="upload-logo__button">
                                                        <button class="button button-cancel del-logo">delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="lp-panel__head border-0 p-0">
                                        <div class="col-left">
                                            <h2 class="card-title">
                                            <span>
                                                Co-Marketing Logo Combinator <!--<span class="new">(new feature!)</span>-->
                                            </span>
                                            </h2>
                                        </div>
                                        <div class="col-right">
                                            <div class="card-link expandable" data-toggle="collapse" href="#combinator"></div>
                                        </div>
                                    </div>

                                </div>
                                <div id="combinator" class="collapse show" >
                                    <div class="card-body">
                                        <div class="card-body__row border-0">
                                            <div class="comb__wrapper">
                                                <div class="comb__col">
                                                    <div class="file__control mw-100">
                                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                                    </div>
                                                    <div class="upload-drag__wrapper">
                                                        <div class="upload-drag__step1">
                                                            <div class="upload-drag-browse__wrapper">
                                                                <div class="upload-drag-browse__img">
                                                                    <img src="assets/images/browse-placehlder.png" alt="browse placeholder">
                                                                </div>
                                                                <div class="upload-drag-browse__desc">
                                                                    <p>
                                                                        Drag and drop files here to upload. <br>
                                                                        Or <span>browse files</span> from your computer.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="upload-drag__step2">
                                                            <img class="pre-image" src="" alt="">
                                                        </div>
                                                        <input id="comb1" class="upload-drag__file" type="file">
                                                    </div>
                                                </div>
                                                <div class="comb__col">
                                                    <div class="file__control mw-100">
                                                        <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                        <p class="file__size">Maximum file size limit is 4MB.</p>
                                                    </div>
                                                    <div class="upload-drag__wrapper">
                                                        <div class="upload-drag__step1">
                                                            <div class="upload-drag-browse__wrapper">
                                                                <div class="upload-drag-browse__img">
                                                                    <img src="assets/images/browse-placehlder.png" alt="browse placeholder">
                                                                </div>
                                                                <div class="upload-drag-browse__desc">
                                                                    <p>
                                                                        Drag and drop files here to upload. <br>
                                                                        Or <span>browse files</span> from your computer.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="upload-drag__step2">
                                                            <img class="post-image" src="" alt="">
                                                        </div>
                                                        <input id="comb2" class="upload-drag__file" type="file">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sliders__wrapper">
                                            <div class="comb__wrapper">
                                                <div class="comb__col">
                                                    <div class="slider__wrapper">
                                                        <input id="ex1" data-slider-id='ex1Slider' data-slider-min='' data-slider-max='' type="text"/>
                                                    </div>
                                                </div>
                                                <div class="comb__col">
                                                    <div class="slider__wrapper">
                                                        <input id="ex2" data-slider-id='ex1Slider' type="text"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body__row">
                                            <div class="button-control mt-4">
                                                <button type="button" id="combinelogo" class="button button-primary" onclick="combinelogos()">combine</button>
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