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
        <div class="main-content">
            <!-- Title wrap of the page -->
            <div class="main-content__head">
                <div class="col-left">
                    <h1 class="title">
                        ADA Accessibility / Funnel: <span class="funnel-name el-tooltip" title="Conv Purchase">Conv Purchase</span>
                    </h1>
                </div>
                <div class="col-right">
                    <a data-lp-wistia-title="ADA Accessibility" data-lp-wistia-key="tb54at5r97" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                        <span class="icon ico-video"></span> Watch how to video</a>
                </div>
            </div>
            <!-- content of the page -->
            <div class="box-ada">
                <div class="row">
                    <div class="col col-md-6">
                        <label class="label-ada">
                            <input type="radio" name="ada-selection" checked="checked">
                            <div class="box-ada__label-box inactive-area">
                                            <span class="box-ada__wrap">
                                                <span class="box-ada__text">inactive</span>
                                            </span>
                            </div>
                            <div class="ada-sign integration__check-box inactive-area">
                                <i class="ico ico-check"></i>
                            </div>
                        </label>
                    </div>
                    <div class="col col-md-6">
                        <label class="label-ada">
                            <input type="radio" name="ada-selection">
                            <div class="box-ada__label-box">
                                            <span class="box-ada__wrap">
                                                <span class="box-ada__img">
                                                    <img src="assets/images/ada-complaint.png" alt="ADA COMPLIANT">
                                                </span>
                                                <span class="box-ada__text">active</span>
                                            </span>
                            </div>
                            <div class="ada-sign integration__check-box">
                                <i class="ico ico-check"></i>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <!-- footer of the page -->
            <div class="footer">
                <div class="row">
                    <img src="assets/images/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </div>
    </main>
</div>

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>

