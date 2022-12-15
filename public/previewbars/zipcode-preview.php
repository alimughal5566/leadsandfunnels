<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/zip-code-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/zip-code-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
    <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var raw_html = $("#preview-template").html();
                var template = Handlebars.compile(raw_html);

                const isSecurityModule = "<?php echo isset($_REQUEST['is_messages_module']) && $_REQUEST['is_messages_module'] == 1 ? 1 : 0; ?>";

                if(parseInt(isSecurityModule) === 1){
                    FunnelsPreview.isMessagesModule = 1;
                    FunnelsPreview.refreshHandlebarSecurityMessage('<?=$_REQUEST['ls_key']?>','<?=$_REQUEST['ques_id']?>');
                } else {
                    FunnelsPreview.refreshHandlebar('<?=$_REQUEST['ls_key']?>','<?=$_REQUEST['ques_id']?>');
                }

                FunnelsPreview.callback = function (refresh){
                    if (refresh) {
                        $("body").html(template(json));
                        zip_code_content.init();
                        FunnelsPreview.showHideCtaOnUserInput();
                    } else {
                        FunnelsPreview.setCTAButtonMode(json['options']['cta-button-settings']['enable-hide-until-answer'], funnel_info);
                    }
                }
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
                     <div class="zip-code-questions-wrap">
                        <div class="question_zip-code question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="question_zip-code__fields zip-code {{#ifCond city-or-zip-code '==' 1}}question-hide{{/ifCond}}">
                                            <div class="step-holder">
                                                <div class="form-group {{#ifCond enable-field-label '=='0}}without-label{{/ifCond}}">
                                                    <div class="input-wrap {{#ifCond question_value '!==' ''}}focused{{/ifCond}}">
                                                        <input type="tel" id="zip_code" value="{{{question_value}}}" class="form-control validate-input {{#ifCond question_value '!==' ''}}filled{{/ifCond}}" autocomplete="off" data-function-name="formValidation">
                                                        <label for="zip_code" class="input-label {{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</label>
                                                        <span class="icon-valid"><span class="ico-check"></span></span>
                                                        <span class="icon-invalid"><span class="ico-cross"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question_zip-code__fields zip-code-wtih-city-code {{#ifCond zip-code-only '==' 1}}question-hide{{/ifCond}}">
                                            <div class="step-holder">
                                                <div class="form-group {{#ifCond enable-field-label '=='0}}without-label{{/ifCond}}">
                                                    <div class="input-wrap">
                                                        <input type="tel" id="city_zip_code" class="form-control validate-input" autocomplete="off" data-function-name="formValidation">
                                                        <label for="city_zip_code" class="input-label {{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</label>
                                                        <span class="icon-valid"><span class="ico-check"></span></span>
                                                        <span class="icon-invalid"><span class="ico-cross"></span></span>
                                                        <div class="states-box scrollActive">
                                                            <div class="scroll-bar">
                                                                <div class="scroll-bar-wrap">
                                                                    <a href="#" class="states">00501, HOLTSVILLE, NY</a>
                                                                    <a href="#" class="states">00544, HOLTSVILLE, NY</a>
                                                                    <a href="#" class="states">00801, ST THOMAS, VI</a>
                                                                    <a href="#" class="states">00802, ST THOMAS, VI</a>
                                                                    <a href="#" class="states">00803, ST THOMAS, VI</a>
                                                                    <a href="#" class="states">00821, CHRISTIANSTED, VI</a>
                                                                    <a href="#" class="states">20001, WASHINGTON, DC</a>
                                                                    <a href="#" class="states">20002, WASHINGTON, DC</a>
                                                                    <a href="#" class="states">20003, WASHINGTON, DC</a>
                                                                    <a href="#" class="states">20004, WASHINGTON, DC</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question_zip-code__fields btns-fields">
                                            <div class="btn-wrap cta-btn-wrap {{#ifCond question_length '<' 2}}{{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}{{/ifCond}}">
                                                <a href="#" class="btn btn-secondary btn-next cta-btn {{#ifCond cta-button-settings.button-icon-position '==' 'RIGHT'}}right{{/ifCond}}"  style="font-size: {{cta-button-settings.font-size}}px;">
                                                    <span class="icon-holder" {{#ifCond cta-button-settings.enable-button-icon '==' 1}}style="display: inline"{{/ifCond}}><span class="icon-wrap"><i class="icon ico-{{cta-button-settings.button-icon}}" style="font-size: {{cta-button-settings.button-icon-size}}px;color:{{cta-button-settings.button-icon-color}};"></i></span></span>
                                                    {{button-text}}
                                                </a>
                                                <input type="hidden" id="hide_cta" value="{{cta-button-settings.enable-hide-until-answer}}">
                                            </div>
                                        </div>

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
