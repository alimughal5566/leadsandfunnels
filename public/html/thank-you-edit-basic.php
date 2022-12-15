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
            <input type="hidden" name="client_id" id="client_id"  value="">
            <input type="hidden" name="theoption" id="theoption"  value="thankyou">
            <input type="hidden" name="theselectiontype" id="theselectiontype"  value="submissionthankyou">
            <input type="hidden" name="firstkey" id="firstkey" value="">
            <input type="hidden" name="clickedkey" id="clickedfirstkey" value="">
            <input type="hidden" name="treecookie" id="treecookie" value="">
            <input type="hidden" name="treecookiediv" id="treecookiediv" value="">
            <input type="hidden" name="current_hash" id="current_hash" value="">
            <input type="hidden" name="thankyou_logo" id="thankyou_logo" value="1">
            <img class="hide d-none" name="default_logo" id="default_logo" src="https://myleads.leadpops.com/images/clients/3/3111/logos/3111_178_1_3_83_89_89_1_3111globalcpmortgagelogov2.png" />
            <div class="main-content__head">
                <div class="col-left">
                    <h1 class="title">
                        Thank You Page Edit / Funnel: <span class="funnel-name">203K Hybrid Loans</span>
                    </h1>
                </div>
                <div class="col-right">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item action__item_separator">
                                <a href="thank-you.php" class="back-link"><span class="icon icon-back ico-caret-up"></span> Back to Thank You Page Options</a>
                            </li>
                            <li class="action__item">
                                <a data-lp-wistia-title="Thank You" data-lp-wistia-key="cx6hoxi228" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                    <span class="icon ico-video"></span> Watch how to video</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="msg"></div>
            <!-- content of the page -->
            <div class="lp-panel">
                <div class="lp-panel__head lp-panel__head_thankyou-edit">
                    <div class="col-left">
                        <h2 class="lp-panel__title">
                            Thank You Message
                        </h2>
                    </div>
                    <div class="col-right">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item action__item_en-logo">
                                    <input checked class="responder-toggle typ_logo" for="typ_logo" id="typ_logo" name="enlogo"
                                           data-thelink="en-logo_active" data-field="typ_logo" data-toggle="toggle"
                                           data-onstyle="active" data-offstyle="inactive"
                                           data-width="182" data-height="50" data-on="logo disabled"
                                           data-off="logo enabled" type="checkbox">
                                </li>
                                <li class="action__item">
                                    <a target="_blank" href="http://203k-purchase-3111.secure-clix.com/thank-you.html?preview=1&hash=jqxZl+ttX0d8LhB4X2Iov7m2iIHtL+MBr6rPwNVYuUA=" class="button button-secondary">
                                        preview
                                    </a>
                                </li>
                                <li class="action__item">
                                    <button id="clone-url" class="button button-primary">
                                        Copy Preview URL
                                    </button>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="lp-panel__body">
                    <div class="default__panel classic-editor__wrapper">
                        <input class="lp-thankyou-edit-textbox" name="thankyou_slug" type="hidden" id="thankyou_slug" value="thank.you.html">
                        <div class="thank-you-slug" id="url-text" style="display:none;">http://203k-purchase-3111.secure-clix.com/thank-you.html?hash=jqxZl+ttX0d8LhB4X2Iov7m2iIHtL+MBr6rPwNVYuUA=</div>
                        <div id="textwrapper" class="">
                                    <textarea class="lp-froala-textbox classic-editor" name="tfootereditor">
<p style="text-align: center;">
    <img alt="" id="defaultLogo" style="max-width: 350px; max-height: 120px;" src="http://itclix.com/images/clients/3/3111/logos/3111_162_1_3_75_81_81_1_kadeh7n5cgbp4ovznzt1.png" class="fr-fic fr-dii">
</p>
<p style="text-align: center;"><span style="color:#3f3e3e;"><span style="font-size: 20px;"><span style="font-family: arial,helvetica,sans-serif;">Thanks for Your Information Request!</span></span></span></p>
<p style="text-align: center;"><span style="font-size:14px;"><span style="font-family: arial,helvetica,sans-serif;">We have received your inquiry and are currently reviewing your information. One of our experts will follow up shortly to provide a FREE, personalized rate quote and one-on-one consultation.</span></span></p>
<p style="text-align: center;"><span style="font-size:14px;"><span style="font-family: arial,helvetica,sans-serif;">To speak with a mortgage expert immediately, <strong>call&nbsp;</strong></span></span><span style="font-size:14px;"><span style="font-family: arial,helvetica,sans-serif;"><strong>(444) 444-4444</strong></span></span>
	<br>&nbsp;</p>
<p style="text-align: center;"><span style="color:#3f3e3e;"><em><span style="font-size: 14px;"><span style="font-family: arial,helvetica,sans-serif;">Our Experts Are Standing By and Look Forward to Speaking with You!</span></span></em></span></p>
<p style="text-align: center;"><span style="font-size:12px;"><img alt="" src="https://myleads.leadpops.com/ckfinder/userfiles/1/152/images/Lock Icon.png" style="width: 282px; height: 57px;" class="fr-fic fr-dii"></span></p>
                                    </textarea>
                        </div>
                        <!--<div class="thank-you-editor classic-editor"></div>-->
                    </div>
                </div>
            </div>
            <!-- content of the page -->
            <!-- footer of the page -->
            <div class="footer">
<!--                <div class="row">-->
<!--                    <a href="#" class="button button-secondary">Save</a>-->
<!--                </div>-->
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