<?php
    include ("includes/head.php");
    include ("includes/sidebar-menu.php");
    include ("includes/inner-sidebar-menu.php");
?>
        <!-- contain the main content of the page -->
        <div id="content" class="w-100">
            <!-- header of the page -->
            <?php
                include ("includes/header.php");
            ?>
            <!-- contain main informative part of the site -->
            <main class="main">
                <section class="main-content">

                    <form id="auto_responderform" action="">
                        <!-- Title wrap of the page -->
                        <div class="main-content__head">
                            <div class="col-left">
                                <h1 class="title">
                                    Email Fire Configuration
                                </h1>
                            </div>
                            <div class="col-right">
                                <a data-lp-wistia-title="Email Fire" data-lp-wistia-key="otqs4eib4i" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span> Watch how to video</a>
                            </div>
                        </div>
                        <!-- content of the page -->

                        <div class="lp-panel">
                            <div class="lp-panel__head flex-nowrap">
                                <div class="col-left">
                                    <h2 class="lp-panel__title heading">
                                        Select the corresponding Email Fire list(s) to automatically drop your leads into.
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="heading-bar__sorting-list has-border">
                                        <select class="select-custom select-custom_sorting">
                                            <option value="1" selected>Mortgage Funnels</option>
                                            <option value="2">New Funnel</option>
                                            <option value="3">Funnel Name</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel__body">
                                <div class="selection-area">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <ul class="list-selection">
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="home-finder" name="home-finder" value="">
                                                        <label class="funnel-label" for="home-finder">203K Home Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="foreclosure" name="foreclosure" value="">
                                                        <label class="funnel-label" for="foreclosure">Foreclosure Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="luxury" name="luxury" value="" checked>
                                                        <label class="funnel-label" for="luxury">Luxury Home Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="short-sale" name="short-sale" value="">
                                                        <label class="funnel-label" for="short-sale">Short Sale</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="reverse" name="reverse" value="">
                                                        <label class="funnel-label" for="reverse">Reverse Mortgage</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="conventional" name="conventional" value="" checked>
                                                        <label class="funnel-label" for="conventional">Conventional Hybrid</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="loan_hybrid" name="loan_hybrid" value="">
                                                        <label class="funnel-label" for="loan_hybrid">VA Loan Hybrid</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="refinance" name="refinance" value="">
                                                        <label class="funnel-label" for="refinance">USDA Refinance</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="203k" name="203k" value="">
                                                        <label class="funnel-label" for="203k">203K Purchase</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="jumbo" name="jumbo" value="">
                                                        <label class="funnel-label" for="jumbo">Jumbo Purchase</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="harp" name="harp" value="">
                                                        <label class="funnel-label" for="harp">HARP Loan</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="list-selection">
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="home-finder1" name="home-finder1" value="">
                                                        <label class="funnel-label" for="home-finder1">203K Home Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="foreclosure1" name="foreclosure1" value="">
                                                        <label class="funnel-label" for="foreclosure1">Foreclosure Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="luxury1" name="luxury1" value="">
                                                        <label class="funnel-label" for="luxury1">Luxury Home Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="short-sale1" name="short-sale1" value="">
                                                        <label class="funnel-label" for="short-sale1">Short Sale</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="reverse1" name="reverse1" value="">
                                                        <label class="funnel-label" for="reverse1">Reverse Mortgage</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="conventional1" name="conventional1" value="">
                                                        <label class="funnel-label" for="conventional1">Conventional Hybrid</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="loan_hybrid1" name="loan_hybrid1" value="">
                                                        <label class="funnel-label" for="loan_hybrid1">VA Loan Hybrid</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="refinance1" name="refinance1" value="">
                                                        <label class="funnel-label" for="refinance1">USDA Refinance</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="203k1" name="203k1" value="">
                                                        <label class="funnel-label" for="203k1">203K Purchase</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="jumbo1" name="jumbo1" value="">
                                                        <label class="funnel-label" for="jumbo1">Jumbo Purchase</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <ul class="list-selection">
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="home-finder2" name="home-finder2" value="">
                                                        <label class="funnel-label" for="home-finder2">203K Home Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="foreclosure2" name="foreclosure2" value="">
                                                        <label class="funnel-label" for="foreclosure1">Foreclosure Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="luxury2" name="luxury2" value="">
                                                        <label class="funnel-label" for="luxury2">Luxury Home Finder</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="short-sale2" name="short-sale2" value="">
                                                        <label class="funnel-label" for="short-sale2">Short Sale</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="reverse2" name="reverse2" value="">
                                                        <label class="funnel-label" for="reverse2">Reverse Mortgage</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="conventional2" name="conventional2" value="">
                                                        <label class="funnel-label" for="conventional2">Conventional Hybrid</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="loan_hybrid2" name="loan_hybrid2" value="">
                                                        <label class="funnel-label" for="loan_hybrid2">VA Loan Hybrid</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="refinance2" name="refinance2" value="">
                                                        <label class="funnel-label" for="refinance2">USDA Refinance</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="203k2" name="203k2" value="">
                                                        <label class="funnel-label" for="203k1">203K Purchase</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="jumbo2" name="jumbo2" value="">
                                                        <label class="funnel-label" for="jumbo1">Jumbo Purchase</label>
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
                            <div class="row">
                                <img src="assets/images/footer-logo.png" alt="footer logo">
                            </div>
                        </div>
                    </form>
                </section>
            </main>
        </div>


<!-- start Modal -->

<?php
    include ("includes/video-modal.php");
    include ("includes/footer.php");
?>