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
                                Unbounce
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
                                    <h3 class="setup-code__heading">How to add your form into Unbounce</h3>
                                    <ul class="setup-code__list">
                                        <li>In the Unbounce Dashboard click "Edit" on the variant
                                            that you would like to add&nbsp;form.</li>
                                        <li>Add a Custom HTML field to a page&nbsp;section.</li>
                                        <li>Paste the code above into the embed custom
                                            HTML screen. Click&nbsp;"Save".</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col col_script">
                                <div class="setup-code clearfix">
                                    <textarea disabled id="un-code" class="setup-code__script"><script type=”text/javascript” src=”https://sample.form-secure.com”></script>
                                    </textarea>
                                    <button class="button button-bold float-right button-primary" onclick="copyToClipboard('#un-code')">copy code</button>
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