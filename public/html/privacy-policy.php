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

                <form id="pricay-page" method="get" action="">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                <span class="inner__title">Footer / Privacy Policy</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a href="footer.php" class="back-link">
                                <span class="icon icon-back ico-caret-up"></span>
                                Back to Footer Options
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Privacy Policy
                                </h2>
                            </div>
                            <div class="col-right">
                                <div class="action">
                                    <ul class="action__list">
                                        <li class="action__item">
                                            <input  id="fp-privacy-policy" name="fp-privacy-policy" data-toggle="toggle"
                                                    data-onstyle="active" data-offstyle="inactive"
                                                    data-width="127" data-height="43" data-on="INACTIVE"
                                                    data-off="ACTIVE" type="checkbox" checked>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="options-page">
                                    <div class="form-group">
                                        <label for="linktype">Link Privacy Policy to
                                            <span class="question-mark el-tooltip" data-container="body" data-toggle="tooltip" title="Tooltip Text" data-html="true" data-placement="top">
                                                <i class="ico ico-question"></i>
                                            </span>
                                        </label>
                                        <div class="input__wrapper">
                                            <div class="select2js__linkpage-option-parent">
                                                <select class="select2js__linkpage-option" name="linktype" id="linktype" onchange="mytoggledestination()">
                                                    <option value="u">Another Website</option>
                                                    <option value="m" selected="selected">Your Funnel</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="theurltext">Link text</label>
                                        <div class="input__wrapper">
                                            <input id="theurltext" name="theurltext" class="form-control" type="text">
                                        </div>
                                    </div>
                            </div>
                            <div class="content__wrapper">
                                <div class="own-web">
                                    <div class="classic-editor__wrapper froala-editor-full-width froala-editor-fixed-width">
                                        <textarea class="lp-froala-textbox"></textarea>
                                    </div>
                                </div>
                                <div class="another-web">
                                        <div class="row align-items-center">
                                            <div class="col-2">
                                                <label class="m-0" for="otherurl">URL</label>
                                            </div>
                                            <div class="col-10 pl-2">
                                                <div class="input__wrapper">
                                                    <input id="otherurl" name="otherurl" class="form-control" type="text">
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