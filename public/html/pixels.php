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
                                Pixels / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Pixels" data-lp-wistia-key="9jk5o1yf66" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span> Watch how to video</a>

                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel lp-panel__pb-0 pixel-panel">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Tracking Pixels and Codes
                                </h2>
                            </div>
                            <div class="col-right">
                                <button class="button button-primary lp-btn-addCode">add code</button>
                            </div>
                        </div>
                        <div class="lp-panel__body p-0">
                            <div class="lp-table">
                                <div class="lp-table__head">
                                    <ul class="lp-table__list">
                                        <li class="lp-table__item">Code Name</li>
                                        <li class="lp-table__item">Options</li>
                                    </ul>
                                </div>
                                <div class="lp-table__body">
                                    <div class="message-block" style="">(You haven't added any Tracking Pixels or Codes yet!)</div>
                                    <ul class="lp-table__list">
                                        <li class="lp-table__item">Tracking Code</li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-editCode">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-deleteCode" data-pixel_name="Tracking Code">
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
                                        <li class="lp-table__item">My Custom Code</li>
                                        <li class="lp-table__item">
                                            <div class="action action_options">
                                                <ul class="action__list">
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-editCode">
                                                            <span class="ico ico-edit"></span>edit
                                                        </a>
                                                    </li>
                                                    <li class="action__item">
                                                        <a href="#" class="action__link btn-deleteCode" data-pixel_name="My Custom Code">
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
                    <!-- content of the page -->
                    <!-- footer of the page -->
                    <div class="footer">
<!--                        <div class="row">-->
<!--                            <a href="#" class="button button-secondary">Save</a>-->
<!--                        </div>-->
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
                </section>
            </main>
        </div>



<!-- start Modal -->

<div class="modal fade pixel-code__pop" id="model_pixel_code" tabindex="-1" role="dialog" aria-labelledby="model_pixel_code" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="dd-code-popup" class="form-pop" method="post" action="">
                <input name="action" id="action" type="hidden" value="add">
                <input name="id" id="id" type="hidden" value="">
                <input name="current_hash" id="current_hash" type="hidden" value="m0THOWdtDg3MH/QPxlZhf8Ws79hjanD3WTMIPIwMfto=">
                <input name="client_id" id="client_id" type="hidden" value="3111">
                <div class="modal-header">
                    <h5 class="modal-title">Add Pixels and Tracking Codes</h5>
                </div>
                <div class="modal-body quick-scroll">
                    <div class="form-group">
                        <label class="modal-lbl">Code Type</label>
                        <div class="input__holder">
                            <div class="select2 select2js__codetype-parent select2js__nice-scroll">
                                <select class="form-control select2js__codetype" data-name="pixel_type" data-default-val="5" data-default-label="Bing Pixel" id="pixel_type">
                                    <option value="5">Bing Pixel</option>
                                    <option value="2">Facebook Pixel</option>
                                    <option value="1">Google Analytics</option>
                                    <option value="3">Google Tag Manager</option>
                                    <option value="4">Google Conversion Pixel</option>
                                    <option value="6">Google Re-targeting Pixel</option>
                                    <option value="7">Informa Pixel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="modal-lbl">Pixel Placement</label>
                        <div class="input__holder">
                            <div class="select2 select2js__pixelplacement-parent">
                                <select class="form-control select2js__pixelplacement" id="pixel_placement" name="pixel_placement">
                                    <option value="2">Funnel</option>
                                    <option value="4">Thank You Page</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="modal-lbl">Code Name</label>
                        <div class="input__holder">
                            <input class="form-control" id="pixel_name" name="pixel_name" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="modal-lbl tracking_to_lender">Tag ID</label>
                        <div class="input__holder">
                            <input class="form-control" type="text" id="pixel_code" name="pixel_code">
                        </div>
                    </div>
                    <div class="pixel_extra pixel_other" style="display: none;">
                        <div class="form-group">
                            <label class="modal-lbl pixel_other_label"></label>
                            <div class="input__holder">
                                <input class="form-control" type="text" name="pixel_other" id="pixel_other">
                            </div>
                        </div>
                    </div>
                    <div class="tracking_options" style="display: none;">
                        <div class="form-group">
                            <label class="modal-lbl">Tracking Options</label>
                            <div class="input__holder">
                                <!--<span class="form-control cursor-pointer">Lead Conversion</span>-->
                                <div class="select2 select2js__trackoption-parent">
                                    <select class="form-control select2js__trackoption" data-name="tracking_options" id="tracking_options">
                                        <option value="1">Page View</option>
                                        <option value="3">Page View + Questions</option>
                                        <option value="2">Lead Conversion</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question_options" style="display: none;">
                        <div class="form-group align-items-start">
                            <label class="modal-lbl my-2 py-1">
                                Question Options <span class="question-mark question-mark_tooltip question-mark_modal el-tooltip ml-1"
                              title="We'll fire a Facebook Pixel (Contact Event) to build your custom <br /> audience based on how people answer questions in your leadPops<br />  Funnel. <br /><br /> This allows leadPops to dynamically 'tell' Facebook what types of <br /> characteristics you prefer in an ideal client, i.e. -- they answer Excellent <br /> or Good credit, they make at least $80K per year, they have a minimum <br />  of 10% for a down payment, etc.<br /> <br />Simply check the box next to answer(s) that you'd like your ideal client <br />  to provide, and our technology will take care of the rest!"><span class="ico-question "></span></span>
                            </label>
                            <div class="ka-dd">

                                    <div id="ka-dd-toggle" class="ka-dd__button">
                                        <span class="displayText">Select Question(s)</span>
                                        <span class="caret"></span>
                                    </div>
                                    <div class="ka-dd__menu" id="scroll-area">
                                        <div class="ka-dd__scroll">
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelenteryourzipcode" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Zip Code">
                                                        <span class="question">Zip Code</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelenteryourzipcode" aria-expanded="false">
                                                    <div class="item za-zip-code">
                                                        <label for="enteryourzipcode"><span></span>
                                                            <strong>Enter 1 Zip Code Per Line Below</strong>
                                                            <br>
                                                            <textarea type="text" class="form-control ka-dd__form-control zip_code txt" name="zip_code" cols="6" rows="10"></textarea>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunneltypeloan" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What type of loan do you need?">
                                                        <span class="question">What type of loan do you need?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunneltypeloan" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="typeloanhomepurchase" class="answer" name="answer[]" value="typeloan|Home Purchase">
                                                        <label for="typeloanhomepurchase"><span></span>
                                                            <strong>Home Purchase</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="typeloanhomerefinance" class="answer" name="answer[]" value="typeloan|Home Refinance">
                                                        <label for="typeloanhomerefinance"><span></span>
                                                            <strong>Home Refinance</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunneltypeofproperty" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Great! What type of property are you purchasing&nbsp;/&nbsp;refinancing?">
                                                        <span class="question">Great! What type of property are you purchasi</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunneltypeofproperty" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="typeofpropertysinglefamilyhome" class="answer" name="answer[]" value="typeofproperty|Single Family Home">
                                                        <label for="typeofpropertysinglefamilyhome"><span></span>
                                                            <strong>Single Family Home</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="typeofpropertycondominium" class="answer" name="answer[]" value="typeofproperty|Condominium">
                                                        <label for="typeofpropertycondominium"><span></span>
                                                            <strong>Condominium</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="typeofpropertytownhome" class="answer" name="answer[]" value="typeofproperty|Townhome">
                                                        <label for="typeofpropertytownhome"><span></span>
                                                            <strong>Townhome</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="typeofpropertymultifamilyhome" class="answer" name="answer[]" value="typeofproperty|Multi-Family Home">
                                                        <label for="typeofpropertymultifamilyhome"><span></span>
                                                            <strong>Multi-Family Home</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelyourcreditprofile" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Estimate your credit score.">
                                                        <span class="question">Estimate your credit score.</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelyourcreditprofile" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="yourcreditprofileexcellent740" class="answer" name="answer[]" value="yourcreditprofile|Excellent 740+">
                                                        <label for="yourcreditprofileexcellent740"><span></span>
                                                            <strong>Excellent 740+</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="yourcreditprofilegood700739" class="answer" name="answer[]" value="yourcreditprofile|Good 700-739">
                                                        <label for="yourcreditprofilegood700739"><span></span>
                                                            <strong>Good 700-739</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="yourcreditprofileaverage660699" class="answer" name="answer[]" value="yourcreditprofile|Average 660-699">
                                                        <label for="yourcreditprofileaverage660699"><span></span>
                                                            <strong>Average 660-699</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="yourcreditprofilefair600659" class="answer" name="answer[]" value="yourcreditprofile|Fair 600-659">
                                                        <label for="yourcreditprofilefair600659"><span></span>
                                                            <strong>Fair 600-659</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="yourcreditprofilepoor600" class="answer" name="answer[]" value="yourcreditprofile|Poor < 600">
                                                        <label for="yourcreditprofilepoor600"><span></span>
                                                            <strong>Poor &lt; 600</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelpropertypurchasesituation" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is your current property purchase situation?">
                                                        <span class="question">What is your current property purchase situat</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelpropertypurchasesituation" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="propertypurchasesituationsignedapurchaseagreement" class="answer" name="answer[]" value="propertypurchasesituation|Signed a Purchase Agreement">
                                                        <label for="propertypurchasesituationsignedapurchaseagreement"><span></span>
                                                            <strong>Signed a Purchase Agreement</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="propertypurchasesituationofferpendingfoundproperty" class="answer" name="answer[]" value="propertypurchasesituation|Offer Pending / Found Property">
                                                        <label for="propertypurchasesituationofferpendingfoundproperty"><span></span>
                                                            <strong>Offer Pending / Found Property</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="propertypurchasesituationbuyingin26months" class="answer" name="answer[]" value="propertypurchasesituation|Buying in 2-6 Months">
                                                        <label for="propertypurchasesituationbuyingin26months"><span></span>
                                                            <strong>Buying in 2-6 Months</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="propertypurchasesituationresearchingoptions" class="answer" name="answer[]" value="propertypurchasesituation|Researching Options">
                                                        <label for="propertypurchasesituationresearchingoptions"><span></span>
                                                            <strong>Researching Options</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelpropertyusedfor" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="How will this property be used?">
                                                        <span class="question">How will this property be used?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelpropertyusedfor" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="propertyusedforprimaryhome" class="answer" name="answer[]" value="propertyusedfor|Primary Home">
                                                        <label for="propertyusedforprimaryhome"><span></span>
                                                            <strong>Primary Home</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="propertyusedforsecondaryhome" class="answer" name="answer[]" value="propertyusedfor|Secondary Home">
                                                        <label for="propertyusedforsecondaryhome"><span></span>
                                                            <strong>Secondary Home</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="propertyusedforrentalproperty" class="answer" name="answer[]" value="propertyusedfor|Rental Property">
                                                        <label for="propertyusedforrentalproperty"><span></span>
                                                            <strong>Rental Property</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelpurchaseprice" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is the purchase price of the new property?">
                                                        <span class="question">What is the purchase price of the new propert</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelpurchaseprice" aria-expanded="false">
                                                    <div class="item za-slider" data-question="purchaseprice">
                                                        <input type="checkbox" data-value="purchaseprice" id="purchaseprice" class="answer" name="answer[]" value="purchaseprice|80,000~2,000,000">
                                                        <label for="purchaseprice"><span></span>
                                                            <strong>$80k - $2M+</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="80,000" value="" data-min="80,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="2,000,000" value="" data-max="2,000,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunneldownpayment" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is your estimated down payment?">
                                                        <span class="question">What is your estimated down payment?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunneldownpayment" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpaymentzerodown" class="answer" name="answer[]" value="downpayment|Zero Down">
                                                        <label for="downpaymentzerodown"><span></span>
                                                            <strong>Zero Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment1down" class="answer" name="answer[]" value="downpayment|1% Down">
                                                        <label for="downpayment1down"><span></span>
                                                            <strong>1% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment3down" class="answer" name="answer[]" value="downpayment|3% Down">
                                                        <label for="downpayment3down"><span></span>
                                                            <strong>3% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment3_5down" class="answer" name="answer[]" value="downpayment|3.5% Down">
                                                        <label for="downpayment3_5down"><span></span>
                                                            <strong>3.5% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment5down" class="answer" name="answer[]" value="downpayment|5% Down">
                                                        <label for="downpayment5down"><span></span>
                                                            <strong>5% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment10down" class="answer" name="answer[]" value="downpayment|10% Down">
                                                        <label for="downpayment10down"><span></span>
                                                            <strong>10% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment15down" class="answer" name="answer[]" value="downpayment|15% Down">
                                                        <label for="downpayment15down"><span></span>
                                                            <strong>15% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment20down" class="answer" name="answer[]" value="downpayment|20% Down">
                                                        <label for="downpayment20down"><span></span>
                                                            <strong>20% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment25down" class="answer" name="answer[]" value="downpayment|25% Down">
                                                        <label for="downpayment25down"><span></span>
                                                            <strong>25% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment30down" class="answer" name="answer[]" value="downpayment|30% Down">
                                                        <label for="downpayment30down"><span></span>
                                                            <strong>30% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment35down" class="answer" name="answer[]" value="downpayment|35% Down">
                                                        <label for="downpayment35down"><span></span>
                                                            <strong>35% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment40down" class="answer" name="answer[]" value="downpayment|40% Down">
                                                        <label for="downpayment40down"><span></span>
                                                            <strong>40% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment45down" class="answer" name="answer[]" value="downpayment|45% Down">
                                                        <label for="downpayment45down"><span></span>
                                                            <strong>45% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpayment50down" class="answer" name="answer[]" value="downpayment|50% Down">
                                                        <label for="downpayment50down"><span></span>
                                                            <strong>50% Down</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="downpaymentmorethan50down" class="answer" name="answer[]" value="downpayment|More Than 50% Down">
                                                        <label for="downpaymentmorethan50down"><span></span>
                                                            <strong>More Than 50% Down</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelratedesired" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What kind of rate do you prefer?">
                                                        <span class="question">What kind of rate do you prefer?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelratedesired" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="ratedesiredadjustable" class="answer" name="answer[]" value="ratedesired|Adjustable">
                                                        <label for="ratedesiredadjustable"><span></span>
                                                            <strong>Adjustable</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="ratedesiredfixed" class="answer" name="answer[]" value="ratedesired|Fixed">
                                                        <label for="ratedesiredfixed"><span></span>
                                                            <strong>Fixed</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelbornbefore" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is your gross annual household income?">
                                                        <span class="question">What is your gross annual household income?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelbornbefore" aria-expanded="false">
                                                    <div class="item za-slider" data-question="bornbefore">
                                                        <input type="checkbox" data-value="bornbefore" id="bornbefore" class="answer" name="answer[]" value="bornbefore|0~250,000">
                                                        <label for="bornbefore"><span></span>
                                                            <strong>$0 - $250k+</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="0" value="" data-min="0" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="250,000" value="" data-max="250,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelemploymentstatus" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is your employment status?">
                                                        <span class="question">What is your employment status?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelemploymentstatus" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="employmentstatusemployed" class="answer" name="answer[]" value="employmentstatus|Employed">
                                                        <label for="employmentstatusemployed"><span></span>
                                                            <strong>Employed</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="employmentstatusnotemployed" class="answer" name="answer[]" value="employmentstatus|Not Employed">
                                                        <label for="employmentstatusnotemployed"><span></span>
                                                            <strong>Not Employed</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="employmentstatusselfemployed" class="answer" name="answer[]" value="employmentstatus|Self Employed">
                                                        <label for="employmentstatusselfemployed"><span></span>
                                                            <strong>Self Employed</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="employmentstatusmilitary" class="answer" name="answer[]" value="employmentstatus|Military">
                                                        <label for="employmentstatusmilitary"><span></span>
                                                            <strong>Military</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="employmentstatusother" class="answer" name="answer[]" value="employmentstatus|Other">
                                                        <label for="employmentstatusother"><span></span>
                                                            <strong>Other</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelfiledbankruptcy" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Bankruptcy, short sale, or foreclosure in the last 3&nbsp;years?">
                                                        <span class="question">Bankruptcy, short sale, or foreclosure in the</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelfiledbankruptcy" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="filedbankruptcyyes" class="answer" name="answer[]" value="filedbankruptcy|Yes">
                                                        <label for="filedbankruptcyyes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="filedbankruptcyno" class="answer" name="answer[]" value="filedbankruptcy|No">
                                                        <label for="filedbankruptcyno"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelshowproof" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Can you show proof of income?">
                                                        <span class="question">Can you show proof of income?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelshowproof" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="showproofyes" class="answer" name="answer[]" value="showproof|Yes">
                                                        <label for="showproofyes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="showproofno" class="answer" name="answer[]" value="showproof|No">
                                                        <label for="showproofno"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelworkingwith" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Are you working with a real estate agent?">
                                                        <span class="question">Are you working with a real estate agent?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelworkingwith" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="workingwithyes" class="answer" name="answer[]" value="workingwith|Yes">
                                                        <label for="workingwithyes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="workingwithno" class="answer" name="answer[]" value="workingwith|No">
                                                        <label for="workingwithno"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelyear" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What year did you purchase your home?">
                                                        <span class="question">What year did you purchase your home?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelyear" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="year20102019" class="answer" name="answer[]" value="year|2010-2019">
                                                        <label for="year20102019"><span></span>
                                                            <strong>2010-2019</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="year20002009" class="answer" name="answer[]" value="year|2000-2009">
                                                        <label for="year20002009"><span></span>
                                                            <strong>2000-2009</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="year19901999" class="answer" name="answer[]" value="year|1990-1999">
                                                        <label for="year19901999"><span></span>
                                                            <strong>1990-1999</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="yearbefore1990" class="answer" name="answer[]" value="year|Before 1990">
                                                        <label for="yearbefore1990"><span></span>
                                                            <strong>Before 1990</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelestimatedvalue" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Please estimate the value of the property.">
                                                        <span class="question">Please estimate the value of the property.</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelestimatedvalue" aria-expanded="false">
                                                    <div class="item za-slider" data-question="estimatedvalue">
                                                        <input type="checkbox" data-value="estimatedvalue" id="estimatedvalue" class="answer" name="answer[]" value="estimatedvalue|80,000~2,000,000">
                                                        <label for="estimatedvalue"><span></span>
                                                            <strong>$80k - $2M+</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="80,000" value="" data-min="80,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="2,000,000" value="" data-max="2,000,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelfirstmortgagebalance" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is the remaining 1<sup>st</sup> mortgage balance?">
                                                        <span class="question">What is the remaining 1<sup>st</sup> mortgage</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelfirstmortgagebalance" aria-expanded="false">
                                                    <div class="item za-slider" data-question="firstmortgagebalance">
                                                        <input type="checkbox" data-value="firstmortgagebalance" id="firstmortgagebalance" class="answer" name="answer[]" value="firstmortgagebalance|0~2,500,000">
                                                        <label for="firstmortgagebalance"><span></span>
                                                            <strong>0% - 125%</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="0" value="" data-min="0" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="2,500,000" value="" data-max="2,500,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelfirstmortgagerate" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is your 1<sup>st</sup> mortgage interest rate?">
                                                        <span class="question">What is your 1<sup>st</sup> mortgage interest</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelfirstmortgagerate" aria-expanded="false">
                                                    <div class="item za-slider" data-question="firstmortgagerate">
                                                        <input type="checkbox" data-value="firstmortgagerate" id="firstmortgagerate" class="answer" name="answer[]" value="firstmortgagerate|0~12">
                                                        <label for="firstmortgagerate"><span></span>
                                                            <strong>0% - 12%+</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="0" value="" data-min="0" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="12" value="" data-max="12" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelfirstpropertypurchase" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="How will this property be used? / Is this your first <br> property purchase?">
                                                        <span class="question">How will this property be used? / Is this you</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelfirstpropertypurchase" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="firstpropertypurchaseprimaryhome" class="answer" name="answer[]" value="firstpropertypurchase|Primary Home">
                                                        <label for="firstpropertypurchaseprimaryhome"><span></span>
                                                            <strong>Primary Home</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="firstpropertypurchasesecondaryhome" class="answer" name="answer[]" value="firstpropertypurchase|Secondary Home">
                                                        <label for="firstpropertypurchasesecondaryhome"><span></span>
                                                            <strong>Secondary Home</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="firstpropertypurchaserentalproperty" class="answer" name="answer[]" value="firstpropertypurchase|Rental Property">
                                                        <label for="firstpropertypurchaserentalproperty"><span></span>
                                                            <strong>Rental Property</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="firstpropertypurchaseyes" class="answer" name="answer[]" value="firstpropertypurchase|Yes">
                                                        <label for="firstpropertypurchaseyes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="firstpropertypurchaseno" class="answer" name="answer[]" value="firstpropertypurchase|No">
                                                        <label for="firstpropertypurchaseno"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelexistingtypeofrate" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What kind of rate do you have?">
                                                        <span class="question">What kind of rate do you have?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelexistingtypeofrate" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="existingtypeofrateadjustable" class="answer" name="answer[]" value="existingtypeofrate|Adjustable">
                                                        <label for="existingtypeofrateadjustable"><span></span>
                                                            <strong>Adjustable</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="existingtypeofratefixed" class="answer" name="answer[]" value="existingtypeofrate|Fixed">
                                                        <label for="existingtypeofratefixed"><span></span>
                                                            <strong>Fixed</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelsecondmortgage" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Do you have a second mortgage?">
                                                        <span class="question">Do you have a second mortgage?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelsecondmortgage" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="secondmortgageyes" class="answer" name="answer[]" value="secondmortgage|Yes">
                                                        <label for="secondmortgageyes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="secondmortgageno" class="answer" name="answer[]" value="secondmortgage|No">
                                                        <label for="secondmortgageno"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunneladditionalcash" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Would you like to borrow additional cash?">
                                                        <span class="question">Would you like to borrow additional cash?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunneladditionalcash" aria-expanded="false">
                                                    <div class="item za-slider" data-question="additionalcash">
                                                        <input type="checkbox" data-value="additionalcash" id="additionalcash" class="answer" name="answer[]" value="additionalcash|0~200,000">
                                                        <label for="additionalcash"><span></span>
                                                            <strong>$0 - $200K</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="0" value="" data-min="0" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="200,000" value="" data-max="200,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelbankruptcylastthree" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Bankruptcy, short sale, or foreclosure in the last 3&nbsp;years?">
                                                        <span class="question">Bankruptcy, short sale, or foreclosure in the</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelbankruptcylastthree" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="bankruptcylastthreeyes" class="answer" name="answer[]" value="bankruptcylastthree|Yes">
                                                        <label for="bankruptcylastthreeyes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="bankruptcylastthreeno" class="answer" name="answer[]" value="bankruptcylastthree|No">
                                                        <label for="bankruptcylastthreeno"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelproofincome" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Can you show proof of income?">
                                                        <span class="question">Can you show proof of income?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelproofincome" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="proofincomeyes" class="answer" name="answer[]" value="proofincome|Yes">
                                                        <label for="proofincomeyes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="proofincomeno" class="answer" name="answer[]" value="proofincome|No">
                                                        <label for="proofincomeno"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelaveragemonthlyincome" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What is your average monthly income?">
                                                        <span class="question">What is your average monthly income?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelaveragemonthlyincome" aria-expanded="false">
                                                    <div class="item za-slider" data-question="averagemonthlyincome">
                                                        <input type="checkbox" data-value="averagemonthlyincome" id="averagemonthlyincome" class="answer" name="answer[]" value="averagemonthlyincome|0~50,000">
                                                        <label for="averagemonthlyincome"><span></span>
                                                            <strong>$0 - $50K</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="0" value="" data-min="0" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="50,000" value="" data-max="50,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelaveragemonthlyexpenses" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="What are your average monthly expenses?">
                                                        <span class="question">What are your average monthly expenses?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelaveragemonthlyexpenses" aria-expanded="false">
                                                    <div class="item za-slider" data-question="averagemonthlyexpenses">
                                                        <input type="checkbox" data-value="averagemonthlyexpenses" id="averagemonthlyexpenses" class="answer" name="answer[]" value="averagemonthlyexpenses|0~50,000">
                                                        <label for="averagemonthlyexpenses"><span></span>
                                                            <strong>$0 - $50K</strong>
                                                            <input type="text" class="form-control ka-dd__form-control slider_question min txt" placeholder="0" value="" data-min="0" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false"> -
                                                            <input type="text" class="form-control ka-dd__form-control slider_question max txt" placeholder="50,000" value="" data-max="50,000" data-inputmask="'alias': 'decimal','rightAlign': false,  'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 'digitsOptional': false">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnelcurrentfha" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Do you currently have an FHA loan?">
                                                        <span class="question">Do you currently have an FHA loan?</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnelcurrentfha" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="currentfhayes" class="answer" name="answer[]" value="currentfha|Yes">
                                                        <label for="currentfhayes"><span></span>
                                                            <strong>Yes</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="currentfhano" class="answer" name="answer[]" value="currentfha|No">
                                                        <label for="currentfhano"><span></span>
                                                            <strong>No</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ka-dd__list">
                                                <a class="ka-dd__link collapsed" href="#gfunnellatepayments" data-toggle="collapse" aria-expanded="false">
                                                    <div class="ka-dd__ellipsis" title="Any late mortgage payments in the last 12 months?">
                                                        <span class="question">Any late mortgage payments in the last 12 mon</span>
                                                    </div>
                                                </a>
                                                <div class="panel-collapse collapse" id="gfunnellatepayments" aria-expanded="false">
                                                    <div class="item ">
                                                        <input type="checkbox" id="latepaymentsnone" class="answer" name="answer[]" value="latepayments|None">
                                                        <label for="latepaymentsnone"><span></span>
                                                            <strong>None</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="latepayments1latepayment" class="answer" name="answer[]" value="latepayments|1 Late Payment">
                                                        <label for="latepayments1latepayment"><span></span>
                                                            <strong>1 Late Payment</strong>
                                                        </label>
                                                    </div>
                                                    <div class="item ">
                                                        <input type="checkbox" id="latepayments2latepayments" class="answer" name="answer[]" value="latepayments|2+ Late Payments">
                                                        <label for="latepayments2latepayments"><span></span>
                                                            <strong>2+ Late Payments</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="pixel_position">
                        <div class="form-group">
                            <label class="modal-lbl" for="pixel_position">Code Location</label>
                            <div class="input__holder">
                                <div class="select2 select2__loc-parent">

                                    <select class="form-control select2__loc" data-name="pixel_position" data-default-val="1" data-default-label="Head" id="pixel_position">
                                        <option value=1"">Head</option>
                                        <option value="2">Body</option>
                                        <option value="3">Footer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <input class="button button-primary lp-btn-add pixel-model" value="add code" type="submit">
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- PIXEL DELETE POPUP - Start -->
<div id="model_confirmPixelDelete" class="modal fade lp-modal-box in">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title">Confirmation</h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper lp-lead-modal-action-wrap">
                    <div class="row">
                        <div class="col-sm-12 modal-action-msg-wrap">
                            <div id="notification_confirmPixelDelete" class="modal-msg"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer lp-modal-action-footer">
                <form id="form_confirmpixelDelete" method="post" action="">
                    <input type="hidden" id="id_confirmPixelDelete" value="" />
                    <input id="current_hash_confirmPixelDelete" type="hidden" value="#" />
                    <input id="client_id_confirmPixelDelete" type="hidden" value="#" />
                </form>
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel btnCancel_confirmPixelDelete" data-dismiss="modal">Close</button>
                        </li>
                        <li class="action__item">
                            <button type="button" class="button button-primary btnAction_confirmPixelDelete">Delete</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- PIXEL DELETE POPUP - End -->

<?php
    include ("includes/video-modal.php");
    include ("includes/footer.php");
?>
