<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/text-field-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/text-field-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
    <script src="/lp_assets/theme_admin3/js/funnel/iframe-global-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
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
                    text_field_content.init();
                    FunnelsPreview.showHideCtaOnUserInput();
                } else {
                    // On changing checkbox value from options
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
                    <div class="text-field-questions-wrap">
                        <div class="question_answer question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="question_answer__fields">
                                            <div class="step-holder {{#ifCond ../question-type '==' 'textarea'}}textarea-active{{/ifCond}}">
                                                <div class="form-group text-field {{#ifCond enable-field-label '=='0}}without-label{{/ifCond}}">
                                                    <div class="input-wrap {{#ifCond enable-auto-cursor-focus '==' 1}}_focused_{{/ifCond}}">
                                                        <input type="text" value="{{{question_value}}}" class="form-control validate-input {{#ifCond question_value '!==' ''}}filled{{/ifCond}}" id="{{data-field}}" autocomplete="off" data-function-name="formValidation">
                                                        <label for="{{data-field}}" class="input-label {{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</label>
                                                        <span class="icon-valid"><span class="ico-check"></span></span>
                                                        <span class="icon-invalid"><span class="ico-cross"></span></span>
                                                    </div>
                                                </div>
                                                <div class="form-group textarea-field {{#ifCond enable-field-label '=='0}}without-label{{/ifCond}}">
                                                    <div class="input-wrap {{#ifCond enable-auto-cursor-focus '==' 1}}_focused_{{/ifCond}}">
                                                        <textarea class="form-control validate-input" autocomplete="off" id="your_notes_{{data-field}}" data-function-name="formValidation">{{{question_value}}}</textarea>
                                                        <label for="your_notes_{{data-field}}" class="input-label {{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</label>
                                                        <span class="icon-valid"><span class="ico-check"></span></span>
                                                        <span class="icon-invalid"><span class="ico-cross"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question_answer__fields btns-fields">
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
