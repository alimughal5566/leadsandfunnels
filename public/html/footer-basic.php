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
                <form id="footer-page" action="" class="global-content-form">
                    <input type="hidden" id="fp-modeowncolor-hex" name="fp-modeowncolor-hex" value="">
                    <input type="hidden" id="fp-modeowncolor-rgb" name="fp-modeowncolor-rgb" value="">
                    <input type="hidden" id="fp-bg_opacity" name="fp-bg_opacity" value="39">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head main-content__head_tabs">
                        <div class="col-left">
                            <h1 class="title">
                                Footer / Funnel: <span class="funnel-name el-tooltip">203K Hybrid Loans</span>
                            </h1>
                            <div class="disabled-wrapper el-tooltip" title="This feature is coming soon!">
                                <input checked id="footer-page" name="footer-page" data-toggle="toggle"
                                        data-onstyle="active" data-offstyle="inactive"
                                        data-width="127" data-height="43" data-on="INACTIVE"
                                        data-off="ACTIVE" type="checkbox">
                            </div>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Footer" data-lp-wistia-key="csu0gemvgx" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel py-0">
                        <div class="card-header">
                            <div class="lp-panel__head border-0 p-0">
                                <div class="col-left">
                                    <h2 class="card-title">
                                            <span>
                                                Primary Footer Options
                                            </span>
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="card-link expandable" data-toggle="collapse" href="#primaryfooter"></div>
                                </div>
                            </div>

                        </div>
                        <div id="primaryfooter" class="collapse show" >
                            <div class="card-body">
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <h3 class="lp-panel__title">
                                                Privacy Policy
                                            </h3>
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="privacy-policy.php" class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-privacy-policy" name="fp-privacy-policy" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <h3 class="lp-panel__title">
                                                Terms of Use
                                            </h3>
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="#" class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-terms" name="fp-terms" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <h3 class="lp-panel__title">
                                                Disclosures
                                            </h3>
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="#" class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-disclosures" name="fp-disclosures" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <h3 class="lp-panel__title">
                                                Licensing Information
                                            </h3>
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="#" class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-disclosures1" name="fp-disclosures1" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <h3 class="lp-panel__title">
                                                About Us
                                            </h3>
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="#" class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-about-us" name="fp-about-us"
                                                                data-thelink="header-page_active" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <h3 class="lp-panel__title">
                                                Contact Us
                                            </h3>
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                            <span class="action__span">
                                                                <a href="#" class="action__link">
                                                                    <span class="ico ico-edit"></span>edit page
                                                                </a>
                                                            </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-contact-us" name="fp-contact-us"
                                                                data-thelink="header-page_active" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel py-0">
                        <div class="card-header">
                            <div class="lp-panel__head border-0 p-0">
                                <div class="col-left">
                                    <h2 class="card-title">
                                            <span>
                                                Secondary Footer Options
                                            </span>
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="card-link collapsed expandable" data-toggle="collapse" href="#secondaryfooter"></div>
                                </div>
                            </div>
                        </div>
                        <div id="secondaryfooter" class="collapse" >
                            <div class="card-body">
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <input class="form-control line-input" disabled value="Compliance Text" type="text">
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                                <span class="action__span action__span_toggle">
                                                                    <a href="javascript:void(0)" class="action__link action__link_edit">
                                                                        <span class="ico ico-edit"></span>edit
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="action__link action__link_cancel">
                                                                        <span class="ico ico-cross"></span>cancel
                                                                    </a>
                                                                </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-privacy-policy" name="fp-privacy-policy" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse-box hide border-top-0">
                                        <div class="row align-items-center">
                                            <div class="col-sm-4 col-xl-2">
                                                <div class="checkbox mt-2">
                                                    <input type="checkbox" class="collapse-checkbox" id="checkboxcomplainlink" name="checkboxcomplainlink" checked value="">
                                                    <label class="normal-font" for="checkboxcomplainlink">
                                                        Link to URL
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-xl-7">
                                                <div class="form-group m-0">
                                                    <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                                    <input class="form-control collapse-next-input" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel">
                                    <div class="lp-panel__head">
                                        <div class="col-left">
                                            <input class="form-control line-input" disabled value="License Number" type="text">
                                        </div>
                                        <div class="col-right">
                                            <div class="action">
                                                <ul class="action__list">
                                                    <li class="action__item action__item_separator">
                                                                <span class="action__span action__span_toggle">
                                                                    <a href="javascript:void(0)" class="action__link action__link_edit">
                                                                        <span class="ico ico-edit"></span>edit
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="action__link action__link_cancel">
                                                                        <span class="ico ico-cross"></span>cancel
                                                                    </a>
                                                                </span>
                                                    </li>
                                                    <li class="action__item">
                                                        <input  id="fp-terms" name="fp-terms" data-toggle="toggle"
                                                                data-onstyle="active" data-offstyle="inactive"
                                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                                data-off="ACTIVE" type="checkbox">
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse-box hide">
                                        <div class="row align-items-center">
                                            <div class="col-sm-4 col-xl-2">
                                                <div class="checkbox mt-2">
                                                    <input type="checkbox" class="collapse-checkbox" id="checkboxLicensenumber" name="checkboxLicensenumber" checked value="">
                                                    <label class="normal-font" for="checkboxLicensenumber">
                                                        Link to URL
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 col-xl-7">
                                                <div class="form-group m-0">
                                                    <label class="col-sm-2 col-xl-1 pl-0">URL</label>
                                                    <input class="form-control collapse-next-input" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lp-panel__footer mt-0 pt-4 border-top-0">
                                    <div class="row">
                                        <div class="col text-center">
                                            <button type="submit" class="button button-secondary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lp-panel py-0">
                        <div class="card-header">
                            <div class="lp-panel__head border-0 p-0">
                                <div class="col-left">
                                    <h2 class="card-title">
                                                <span>
                                                    Super Footer Options <!-- <span class="new">(new feature!)</span> -->
                                                </span>
                                    </h2>
                                </div>
                                <div class="col-right">
                                    <div class="action">
                                        <ul class="action__list">
                                            <li class="action__item">
                                                <div class="card-link collapsed expandable ml-3 col-super-footer"  data-toggle="collapse" href="#superfooter"></div>
                                            </li>
                                            <li class="action__item">
                                                <input  id="fp-privacy-policy" name="fp-privacy-policy" data-toggle="toggle"
                                                        data-onstyle="active" data-offstyle="inactive"
                                                        data-width="127" data-height="43" data-on="INACTIVE"
                                                        data-off="ACTIVE" type="checkbox">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="superfooter" class="collapse" >
                            <div class="card-body">
                                <div class="lp-panel">
                                    <div class="classic-editor__wrapper">
                                        <div class="classic-wrap-area">
                                                <textarea class="lp-froala-textbox">
                                                    <div class="container advanced-container">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <h2 class="funnel__title">
                                                                    How this works...
                                                                </h2>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                <div class="box funnel__box">
                                                                    <div class="box__counter">1</div>
                                                                    <div class="box__content">
                                                                        <h3 class="box__heading">
                                                                            <span style="font-size: 20px;">60-Second Digital Pre-Approval</span>
                                                                        </h3>
                                                                        <p class="box__des">Share some basic info; if qualified, we'll provide you with a free, no-obligation pre-approval letter.</p>
                                                                    </div>
                                                                </div>
                                                                <div class="box funnel__box">
                                                                    <div class="box__counter">2</div>
                                                                    <div class="box__content">
                                                                        <h3 class="box__heading">
                                                                            <span style="font-size: 20px;">Choose the Best Options for You</span>
                                                                        </h3>
                                                                        <p class="box__des">Choose from a variety of loan options,
                                                                            including our conventional 20% down product.<br><br>
                                                                            We also offer popular 5%-15% down home loans... AND
                                                                            we can even go as low as 0% down.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="box funnel__box">
                                                                    <div class="box__counter">3</div>
                                                                    <div class="box__content">
                                                                        <h3 class="box__heading">
                                                                            <span style="font-size: 20px;">Start Shopping for Your Home!</span>
                                                                        </h3>
                                                                        <p class="box__des">It only takes about 60 seconds to get everything under way.
                                                                            Simply enter your zip code right now.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <!-- <a class="funnel__btn" href="#">Find My 203K</a> -->
                                                                <div style="text-align: center;margin: 20px auto;">
                                                                    <a class="lp-btn__go" href="#GetStartedNow" id="btn-submit" tabindex="-1" title="">
                                                                        Get Started Now!
                                                                    </a>
                                                                </div>
                                                                <div class="funnel__caption">
                                                                    <p style="text-align: center; margin-left: 20px;">
                                                                        <em>
                                                                            <span style="font-size: 11px;">
                                                                                This hassle-free process only takes about 60 seconds,
                                                                                &nbsp;</span>
                                                                        </em>
                                                                        <br>
                                                                        <em>
                                                                            <span style="font-size: 11px;">and it won't affect your credit score!</span>
                                                                        </em>
                                                                    </p>
                                                                    <p>
                                                                        <br></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7">
                                                                <div class="animate-container">
                                                                    <div class="first animated desktop slideInRight">
                                                                        <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-1.png" class="fr-fic fr-dii fr-draggable">
                                                                    </div>
                                                                    <div class="second animated desktop fadeIn">
                                                                        <h2 class="animate__heading" style="font-size: 18px;">
                                                                            <span style="font-size: 18px;">Share some basic info</span>
                                                                        </h2>
                                                                        <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-2.png" class="fr-fic fr-dii fr-draggable">
                                                                    </div>
                                                                    <div class="third animated desktop zoomIn">
                                                                        <strong><span style="color: rgb(3, 177, 253); font-size: 18px;">10% Down</span></strong>
                                                                    </div><div class="fourth animated desktop fadeInLeft">
                                                                        <img src="https://c59b285ada27f89b9f8d-3eb81b6eb5bfb6eff5a10a4aa6a00a8f.ssl.cf2.rackcdn.com/footer-animate-4.png" class="fr-fic fr-dii fr-draggable">
                                                                    </div>
                                                                    <div class="fifth animated desktop slideInRight">
                                                                        <p>
                                                                            <span class="clientfname">Hi, I'm peter, your loan&nbsp;</span>officer.<br>
                                                                            It looks like you may qualify for<br>a lot more than you thought!
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix">
                                                                    <br>
                                                                </div>
                                                                <p>
                                                                    <br>
                                                                </p>
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <p>
                                                            <br>
                                                        </p>
                                                    </div>
                                                </textarea>
                                        </div>
                                    </div>
                                    <div class="lp-panel__footer mt-4 pt-4">
                                        <div class="row">
                                            <div class="col pr-0 d-flex align-items-center">
                                                <div class="superfooter">
                                                            <span class="reset-froala">
                                                                <i class="ico ico-undo"></i> reset default
                                                            </span>
                                                </div>
                                            </div>
                                            <div class="col-2 p-0 text-center">
                                                <button type="submit" class="button button-secondary">Save</button>
                                            </div>
                                            <div class="col p-0 flex-row-reverse d-flex align-items-center footer-content-text">
                                                <div class="checkbox h-100 ml-3 mt-2">
                                                    <input type="checkbox" id="footercontenthide" name="footercontenthide" checked value="">
                                                    <label class="normal-font" for="footercontenthide"></label>
                                                </div>
                                                Hide Primary and Secondary footer&nbsp;content
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
                    <!-- content of the page -->
                    <!-- footer of the page -->
                </form>
            </section>
        </main>
    </div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>
