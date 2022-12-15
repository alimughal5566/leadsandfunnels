<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-number-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/external/input-mask/inputmask.bundle.min.js"></script>
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/funnel-question-number-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
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

            FunnelsPreview.callback =  function (refresh){
                if (refresh) {
                    $("body").html(template(json));
                    number_content.init();
                    // apply number have logic to handle FunnelsPreview.showHideCtaOnUserInput() functionality to show/hide cta button
                    number_content.applyNumberValidation();
                    $('.form-control').keyup();
                } else {
                    $('.form-control').keyup();
                    FunnelsPreview.setCTAButtonMode(json['options']['cta-button-settings']['enable-hide-until-answer'], funnel_info);
                }
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
                    <div class="funnel-number-wrap">
        <div class="question_number question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="number-fields-area">
                                            <!-- Question heading and description Preview html -->
											<?php
											include("question-heading-description-preview.php");
											?>
                                        <div class="question_number__fields">
                                            <div class="form-group {{#ifCond enable-field-label '=='0}}without-label{{/ifCond}}">
                                                <div class="input-wrap number__field {{#ifCond enable-auto-cursor-focus '==' 1}}_focused_{{/ifCond}}  {{#ifCond formatting.enable-format-as-currency '==' 1}}currency-prefix{{/ifCond}} {{#ifCond formatting.enable-format-as-percentage '==' 1}}percantage-prefix{{/ifCond}}">
                                                    <input type="text" id="{{data-field}}" class="form-control number-input validate-input {{#ifCond question_value '!==' ''}}filled{{/ifCond}}" value="{{{question_value}}}" autocomplete="off" data-function-name="formValidation">
                                                    <label for="{{data-field}}" class="input-label {{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</label>
                                                    <span class="icon-valid"><span class="ico-check"></span></span>
                                                    <span class="icon-invalid"><span class="ico-cross"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="form-group error-message" data-error-msg></div>
                                        <div class="question_number__fields btns-fields">
                                            <div class="btn-wrap cta-btn-wrap {{#ifCond question_length '<' 2}}{{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}{{/ifCond}}">
                                                <a href="#" class="btn btn-secondary btn-next cta-btn {{#ifCond cta-button-settings.button-icon-position '==' 'RIGHT'}}right{{/ifCond}}" style="font-size: {{cta-button-settings.font-size}}px;">
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
