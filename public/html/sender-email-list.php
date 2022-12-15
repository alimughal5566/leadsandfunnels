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
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Sender Email Addresses
                            </h1>
                        </div>
                        <div class="col-right">
                            <a href="autoresponder.php" class="back-link">
                                <span class="icon icon-back ico-caret-up"></span>
                                Back to autoresponder
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel pb-0">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Added Emails
                                </h2>
                            </div>
                        </div>
                        <div class="lp-panel__body p-0">
                            <div class="lp-table sender-email-table">
                                <div class="lp-table__head">
                                    <ul class="lp-table__list">
                                        <li class="lp-table__item"><span>Email Address</span></li>
                                        <li class="lp-table__item"><span>Email Type</span></li>
                                        <li class="lp-table__item"><span>Options</span></li>
                                    </ul>
                                </div>
                                <div class="lp-table__body">
                                    <ul class="lp-table__list ">
                                        <li class="lp-table__item"><span>info@form-secure.com</span></li>
                                        <li class="lp-table__item"><span>SMTP</span></li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-editCode">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-deleteCode">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="lp-table__list ">
                                        <li class="lp-table__item"><span>robertpilc@gmail.com</span></li>
                                        <li class="lp-table__item"><span>Verified</span></li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-editCode">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-deleteCode">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="lp-table__list ">
                                        <li class="lp-table__item"><span>mynewaddress@yahoo.com</span></li>
                                        <li class="lp-table__item"><span>Verified</span></li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-editCode">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-deleteCode">
                                                            <span class="ico ico-cross"></span>delete
                                                        </a>
                                                    </li>
                                                </ul>
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
    include ("includes/footer.php");
?>