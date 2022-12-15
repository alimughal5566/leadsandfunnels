<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/vehicle-field-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/vehicle-field-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var raw_html = $("#preview-template").html();
            var template = Handlebars.compile(raw_html);
            FunnelsUtil.tabStep = <?=$_REQUEST['bundle_question_step'];?>;
            const isSecurityModule = "<?php echo isset($_REQUEST['is_messages_module']) && $_REQUEST['is_messages_module'] == 1 ? 1 : 0; ?>";
            if(parseInt(isSecurityModule) === 1){
                FunnelsPreview.isMessagesModule = 1;
                FunnelsPreview.refreshHandlebarSecurityMessage('<?=$_REQUEST['ls_key']?>','<?=$_REQUEST['ques_id']?>');
            } else {
                FunnelsPreview.refreshHandlebar('<?=$_REQUEST['ls_key']?>','<?=$_REQUEST['ques_id']?>');
            }
            FunnelsPreview.callback =  function (refresh){
                if (refresh) {
                    vehicle_field_content.setModels(json);
                    $("body").html(template(json));
                    vehicle_field_content.init();
                }
                if(FunnelsUtil.tabStep === 1){
                    $(".make-list").hide();
                    $(".model-list").show();
                }
                else{
                    $(".make-list").show();
                    $(".model-list").hide();
                }
                vehicle_field_content.handleHideUntilNotAnswered();
            };

            FunnelsPreview.callback(true);
            FunnelsPreview.changesTrigger();
            FunnelsPreview.setIframeHeight();
            FunnelsPreview.desktopFont();
        });
    </script>
</head>
<body>
<script id="preview-template" type="text/x-handlebars-template">
    {{#with options}}
        <div class="<?php echo isset($_REQUEST['is_messages_module']) && $_REQUEST['is_messages_module'] == 1 ? 'funnel-iframe-inner-holder inner-iframe-parent' : 'funnel-iframe-inner-holder'; ?>">
            <div class="funnel-iframe-inner-area">
                <div class="funnel-iframe-inner-wrap">
                    <div class="vehicle-message-wrap">
                        <div class="question_vehicle question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
                            <!-- funnel header html-->
                            <?php
                            include("funnel-header.php");
                            ?>
                            <div class="cta-feature-preview-holder">
                                <div class="row{{#ifCond ../show-cta-image '!=' ''}} with-image{{/ifCond}}">
                                    <div class="col cta-preview-col">
                                        <!-- CTA message preview html-->
                                        <?php
                                        include("cta-message-preview.php");
                                        ?>
                                        <!-- Question heading and description Preview html -->
										<?php
										include("question-heading-description-preview.php");
										?>
                                        <div class="question_vehicle__fields">
                                            <div class="single-select-area make-list">
                                                <div class="single-select-opener-wrap {{#ifCond enable-field-label '==' 0}}without-label-text{{/ifCond}}">
                                                    <a href="#" class="select-opener"><span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span></a>
                                                    <span class="select-opener-text"></span>
                                                </div>
                                                <div class="single-select-dropdown">
                                                    <strong class="single-select-dropdown__title"><span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span> <span class="icon-cancel ico-cross"></span></strong>
                                                    <div class="scroll-bar">
                                                        <div class="single-select-dropdown__wrap">
                                                            <div class="single-select-dropdown__holder">
                                                                <ul class="single-select-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <span>Acura</span>
                                                                            <input type="radio" name="radio" value="Acura" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                    <a href="#">
                                                                        <span>Alfa Romeo</span>
                                                                        <input type="radio" name="radio" value="Alfa Romeo" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>AMC</span>
                                                                        <input type="radio" name="radio" value="AMC" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Aston Martin</span>
                                                                        <input type="radio" name="radio" value="Aston Martin" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Audi</span>
                                                                        <input type="radio" name="radio" value="Audi" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Avanti</span>
                                                                        <input type="radio" name="radio" value="Avanti" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Bentley</span>
                                                                        <input type="radio" name="radio" value="Bentley" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>BMW </span>
                                                                        <input type="radio" name="radio" value="BMW " hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Buick</span>
                                                                        <input type="radio" name="radio" value="Buick" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Cadillac</span>
                                                                        <input type="radio" name="radio" value="Cadillac" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Chevrolet</span>
                                                                        <input type="radio" name="radio" value="Chevrolet" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Chrysler</span>
                                                                        <input type="radio" name="radio" value="Chrysler" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Daewoo</span>
                                                                        <input type="radio" name="radio" value="Daewoo" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Daihatsu</span>
                                                                        <input type="radio" name="radio" value="Daihatsu" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Datsun</span>
                                                                        <input type="radio" name="radio" value="Datsun" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>DeLorean</span>
                                                                        <input type="radio" name="radio" value="DeLorean" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Dodge</span>
                                                                        <input type="radio" name="radio" value="Dodge" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Eagle</span>
                                                                        <input type="radio" name="radio" value="Eagle" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Ferrari</span>
                                                                        <input type="radio" name="radio" value="Ferrari" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Fiat</span>
                                                                        <input type="radio" name="radio" value="Fiat" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Ford</span>
                                                                        <input type="radio" name="radio" value="Ford" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Geo</span>
                                                                        <input type="radio" name="radio" value="Geo" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>GMC</span>
                                                                        <input type="radio" name="radio" value="GMC" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Honda</span>
                                                                        <input type="radio" name="radio" value="Honda" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>HUMMER</span>
                                                                        <input type="radio" name="radio" value="HUMMER" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Hyundai</span>
                                                                        <input type="radio" name="radio" value="Hyundai" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Infiniti</span>
                                                                        <input type="radio" name="radio" value="Infiniti" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Isuzu</span>
                                                                        <input type="radio" name="radio" value="Isuzu" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Jaguar</span>
                                                                        <input type="radio" name="radio" value="Jaguar" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Jeep</span>
                                                                        <input type="radio" name="radio" value="Jeep" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Kia</span>
                                                                        <input type="radio" name="radio" value="Kia" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Lamborghini</span>
                                                                        <input type="radio" name="radio" value="Lamborghini" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Lancia</span>
                                                                        <input type="radio" name="radio" value="Lancia" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Land Rover</span>
                                                                        <input type="radio" name="radio" value="Land Rover" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Lexus</span>
                                                                        <input type="radio" name="radio" value="Lexus" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Lincoln</span>
                                                                        <input type="radio" name="radio" value="Lincoln" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Lotus</span>
                                                                        <input type="radio" name="radio" value="Lotus" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Maserati</span>
                                                                        <input type="radio" name="radio" value="Maserati" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Maybach</span>
                                                                        <input type="radio" name="radio" value="Maybach" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Mazda</span>
                                                                        <input type="radio" name="radio" value="Mazda" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Mercedes-Benz</span>
                                                                        <input type="radio" name="radio" value="Mercedes-Benz" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Mercury</span>
                                                                        <input type="radio" name="radio" value="Mercury" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Merkur</span>
                                                                        <input type="radio" name="radio" value="Merkur" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>MINI</span>
                                                                        <input type="radio" name="radio" value="MINI" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Mitsubishi</span>
                                                                        <input type="radio" name="radio" value="Mitsubishi" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Nissan</span>
                                                                        <input type="radio" name="radio" value="Nissan" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Oldsmobile</span>
                                                                        <input type="radio" name="radio" value="Oldsmobile" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Peugeot</span>
                                                                        <input type="radio" name="radio" value="Peugeot" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Plymouth</span>
                                                                        <input type="radio" name="radio" value="Plymouth" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Pontiac</span>
                                                                        <input type="radio" name="radio" value="Pontiac" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Porsche</span>
                                                                        <input type="radio" name="radio" value="Porsche" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Renault</span>
                                                                        <input type="radio" name="radio" value="Renault" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Rolls-Royce</span>
                                                                        <input type="radio" name="radio" value="Rolls-Royce" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Saab</span>
                                                                        <input type="radio" name="radio" value="Saab" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Saturn</span>
                                                                        <input type="radio" name="radio" value="Saturn" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Scion</span>
                                                                        <input type="radio" name="radio" value="Scion" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Smart</span>
                                                                        <input type="radio" name="radio" value="Smart" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Sterling</span>
                                                                        <input type="radio" name="radio" value="Sterling" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Subaru</span>
                                                                        <input type="radio" name="radio" value="Subaru" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Suzuki</span>
                                                                        <input type="radio" name="radio" value="Suzuki" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Toyota</span>
                                                                        <input type="radio" name="radio" value="Toyota" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Triumph</span>
                                                                        <input type="radio" name="radio" value="Triumph" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Volkswagen</span>
                                                                        <input type="radio" name="radio" value="Volkswagen" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Volvo</span>
                                                                        <input type="radio" name="radio" value="Volvo" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Yugo</span>
                                                                        <input type="radio" name="radio" value="Yugo" hidden="hidden">
                                                                    </a>
                                                                </li>  <li>
                                                                    <a href="#">
                                                                        <span>Other</span>
                                                                        <input type="radio" name="radio" value="Other" hidden="hidden">
                                                                    </a>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="single-select-area model-list" style="display: none;">
                                                <div class="single-select-opener-wrap {{#ifCond enable-field-label '==' 0}}without-label-text{{/ifCond}}">
                                                    <a href="#" class="select-opener"><span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span></a>
                                                    <span class="select-opener-text"></span>
                                                </div>
                                                <div class="single-select-dropdown">
                                                    <strong class="single-select-dropdown__title"><span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span> <span class="icon-cancel ico-cross"></span></strong>
                                                    <div class="scroll-bar">
                                                        <div class="single-select-dropdown__wrap">
                                                            <div class="single-select-dropdown__holder">
                                                                <ul class="single-select-list">
                                                                    <li>
                                                                        <a href="#">
                                                                            <span>124</span>
                                                                            <input type="radio" name="radio01" value="124" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>181</span>
                                                                            <input type="radio" name="radio01" value="181" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>540iT</span>
                                                                            <input type="radio" name="radio01" value="540iT" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Maranello</span>
                                                                            <input type="radio" name="radio01" value="Maranello" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Axiom</span>
                                                                            <input type="radio" name="radio01" value="Axiom" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Aztek</span>
                                                                            <input type="radio" name="radio01" value="Aztek" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>B-Series Pickup</span>
                                                                            <input type="radio" name="radio01" value="B-Series Pickup" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Blackwood</span>
                                                                            <input type="radio" name="radio01" value="Blackwood" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Brooklands</span>
                                                                            <input type="radio" name="radio01" value="Brooklands" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Cabriolet</span>
                                                                            <input type="radio" name="radio01" value="Cabriolet" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Cimarron</span>
                                                                            <input type="radio" name="radio01" value="Cimarron" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Colorado</span>
                                                                            <input type="radio" name="radio01" value="Colorado" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Conquest</span>
                                                                            <input type="radio" name="radio01" value="Conquest" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Durango</span>
                                                                            <input type="radio" name="radio01" value="Durango" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>E-150 and Econoline 150</span>
                                                                            <input type="radio" name="radio01" value="E-150 and Econoline 150" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Explorer Sport Trac</span>
                                                                            <input type="radio" name="radio01" value="Explorer Sport Trac" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Fairmont</span>
                                                                            <input type="radio" name="radio01" value="Fairmont" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Fifth Avenue</span>
                                                                            <input type="radio" name="radio01" value="Fifth Avenue" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Freelander</span>
                                                                            <input type="radio" name="radio01" value="Freelander" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Gallardo</span>
                                                                            <input type="radio" name="radio01" value="Gallardo" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>GL320 Bluetec</span>
                                                                            <input type="radio" name="radio01" value="GL320 Bluetec" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Grand Marquis</span>
                                                                            <input type="radio" name="radio01" value="Grand Marquis" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Grand Vitara</span>
                                                                            <input type="radio" name="radio01" value="Grand Vitara" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Highlander</span>
                                                                            <input type="radio" name="radio01" value="Highlander" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>HS 250h</span>
                                                                            <input type="radio" name="radio01" value="HS 250h" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>MAZDASPEED3</span>
                                                                            <input type="radio" name="radio01" value="MAZDASPEED3" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Mondial</span>
                                                                            <input type="radio" name="radio01" value="Mondial" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Mystique</span>
                                                                            <input type="radio" name="radio01" value="Mystique" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Navigator</span>
                                                                            <input type="radio" name="radio01" value="Navigator" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Ninety-Eight</span>
                                                                            <input type="radio" name="radio01" value="Ninety-Eight" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Odyssey</span>
                                                                            <input type="radio" name="radio01" value="Odyssey" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Other Aston Martin Models</span>
                                                                            <input type="radio" name="radio01" value="Other Aston Martin Models" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Other Isuzu Models</span>
                                                                            <input type="radio" name="radio01" value="Other Isuzu Models" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Pacifica</span>
                                                                            <input type="radio" name="radio01" value="Pacifica" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Phoenix</span>
                                                                            <input type="radio" name="radio01" value="Phoenix" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Quantum</span>
                                                                            <input type="radio" name="radio01" value="Quantum" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Quattroporte</span>
                                                                            <input type="radio" name="radio01" value="Quattroporte" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Range Rover Sport</span>
                                                                            <input type="radio" name="radio01" value="Range Rover Sport" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>S400 Hybrid</span>
                                                                            <input type="radio" name="radio01" value="S400 Hybrid" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Santa Fe</span>
                                                                            <input type="radio" name="radio01" value="Santa Fe" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Silhouette</span>
                                                                            <input type="radio" name="radio01" value="Silhouette" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Spider Veloce</span>
                                                                            <input type="radio" name="radio01" value="Spider Veloce" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Thunderbird</span>
                                                                            <input type="radio" name="radio01" value="Thunderbird" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Town & Country</span>
                                                                            <input type="radio" name="radio01" value="Town & Country" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Transit Connect</span>
                                                                            <input type="radio" name="radio01" value="Transit Connect" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>V8 Quattro</span>
                                                                            <input type="radio" name="radio01" value="V8 Quattro" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Veracruz</span>
                                                                            <input type="radio" name="radio01" value="Veracruz" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Wagoneer</span>
                                                                            <input type="radio" name="radio01" value="Wagoneer" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Yukon XL</span>
                                                                            <input type="radio" name="radio01" value="Yukon XL" hidden="hidden">
                                                                        </a>
                                                                    </li>  <li>
                                                                        <a href="#">
                                                                            <span>Zephyr</span>
                                                                            <input type="radio" name="radio01" value="Zephyr" hidden="hidden">
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                                <!-- Comment this code now we add the option static not from json file
                                                                 -->
                                                                <!--<ul class="single-select-list">
                                                                {{#each models}}
                                                                    {{#if this}}
                                                                    <li>
                                                                        <a href="#">
                                                                            <span>{{this}}</span>
                                                                            <input type="radio" name="radio" value="{this}}" hidden="hidden">
                                                                        </a>
                                                                    </li>
                                                                    {{/if}}
                                                                {{/each}}
                                                                </ul>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{#ifCond automatic-progress '==' 0}}
                                        <div class="question_vehicle__fields btns-fields">
                                            <div class="btn-wrap vehicle-btn-wrap cta-btn-wrap {{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}">
                                                <a href="#" class="btn btn-secondary btn-next cta-btn {{#ifCond cta-button-settings.button-icon-position '==' 'RIGHT'}}right{{/ifCond}}" style="font-size: {{cta-button-settings.font-size}}px;">
                                                    <span class="icon-holder" {{#ifCond cta-button-settings.enable-button-icon '==' 1}}style="display: inline"{{/ifCond}}><span class="icon-wrap"><i class="icon ico-{{cta-button-settings.button-icon}}" style="font-size: {{cta-button-settings.button-icon-size}}px;color:{{cta-button-settings.button-icon-color}};"></i></span></span>
                                                    {{button-text}}
                                                </a>
                                                <input type="hidden" id="hide_cta" value="{{cta-button-settings.enable-hide-until-answer}}">
                                            </div>
                                        </div>
                                        {{/ifCond}}
                           <!-- privacy additional content -->
                           <?php
                            include("privacy-additional-content-section.php");
                            ?>
                                    </div>
                                    <!-- feature image preview html-->
                                    <?php
                                    include("feature-image.php");
                                    ?>
                                </div>
                            </div>
                            <!-- funnel footer html-->
                            <?php
                            include("funnel-footer.php");
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{/with}}
</script>
</body>
</html>
