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

                <form id="contact-info" method="post" action="">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Contact Info / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Contact Info" data-lp-wistia-key="epni9wlwah" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->

                        <div class="lp-contact__content">
                            <label class="lp-contact__label" for="company_name">Company Name</label>
                            <div class="input__wrapper">
                                <input name="company_name" class="form-control" type="text">
                            </div>
                            <div class="lp-contact__control">
                                <input checked class="conttogbtn companyname_tbt" name="companyname_tbt"
                                       data-toggle="toggle" data-onstyle="active" data-offstyle="inactive"
                                       data-width="127" data-height="43" data-on="INACTIVE"
                                       data-off="ACTIVE" type="checkbox">
                            </div>
                        </div>
                        <div class="lp-contact__content">
                            <label class="lp-contact__label" for="phone_number">Phone Number</label>
                            <div class="input__wrapper">
                                <input name="phone_number" class="form-control" type="text">
                            </div>
                            <div class="lp-contact__control">
                                <input checked class="conttogbtn phonenumber_tbt" name="phonenumber_tbt"
                                        data-toggle="toggle" data-onstyle="active" data-offstyle="inactive"
                                        data-width="127" data-height="43" data-on="INACTIVE"
                                        data-off="ACTIVE" type="checkbox">
                            </div>
                        </div>
                        <div class="lp-contact__content">
                            <label class="lp-contact__label" for="email">Email Address</label>
                            <div class="input__wrapper">
                                <input name="email" class="form-control" type="text">
                            </div>
                            <div class="lp-contact__control">
                                <input class="conttogbtn email_tbt" name="email_tbt"
                                        data-toggle="toggle" data-onstyle="active" data-offstyle="inactive"
                                        data-width="127" data-height="43" data-on="INACTIVE"
                                        data-off="ACTIVE" type="checkbox">
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