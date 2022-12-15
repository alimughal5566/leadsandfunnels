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
                            <span class="platform__name">
                                Wordpress
                            </span>
                            <span class="platform__dsc">
                                (click here for the self hosted <a href="#">WordPress.com</a> version)
                            </span>
                        </h1>
                    </div>
                    <div class="col-right">
                        <a href="platforms-funnel.php" class="back-link">
                            <span class="icon icon-back ico-caret-up"></span> Back to platforms
                        </a>
                    </div>
                </div>
                <!-- content of the page -->

                <div class="lp-panel">
                    <div class="lp-panel__head">
                        <div class="col-left">
                            <h2 class="lp-panel__title">
                                Code Setup
                            </h2>
                        </div>
                    </div>
                    <div class="lp-panel__body">
                        <div class="row">
                            <div class="col">
                                <div class="setup-code">
                                    <h3 class="setup-code__heading">How to add your form into WordPress.com</h3>
                                    <ul class="setup-code__list">
                                        <li>On a WordPress "Post" page, click "Add New".</li>
                                        <li>Click "HTML" tab above post text area.</li>
                                        <li>Copy form code above.</li>
                                        <li>Paste it into the "HTML" text area.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col col_script">
                                <div class="setup-code clearfix">
                                    <textarea disabled id="wp-code" class="setup-code__script">
                                        [embed]https://sample.form-secure.com[/embed]
                                    </textarea>
                                    <button class="button button-bold float-right button-primary" onclick="copyToClipboard('#wp-code')">copy code</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- content of the page -->

            </section>
        </main>
    </div>
<?php
include ("includes/footer.php");
?>