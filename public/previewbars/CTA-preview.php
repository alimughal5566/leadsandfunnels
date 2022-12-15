<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-cta-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
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
                    FunnelsPreview.showHideCtaOnUserInput();
                } else {
                    FunnelsPreview.setCTAButtonMode(json['options']['cta-button-settings']['enable-hide-until-answer'], funnel_info);
                }
            };

            FunnelsPreview.callback(true);
            FunnelsPreview.changesTrigger();
            FunnelsPreview.setIframeHeight();
        });
    </script>
</head>
<body>
<script id="preview-template" type="text/x-handlebars-template">
    {{#with options}}
        <div class="<?php echo isset($_REQUEST['is_messages_module']) && $_REQUEST['is_messages_module'] == 1 ? 'funnel-iframe-inner-holder inner-iframe-parent' : 'funnel-iframe-inner-holder'; ?>">
            <div class="funnel-iframe-inner-area">
                <div class="funnel-iframe-inner-wrap">
                    <div class="cta-message-wrap">
                        <div class="question_cta question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="question-preview-parent__title">
                                         {{#ifCond show-question '==' 1 }}
                                            {{#ifCond call-to-action '!==' ''}}
                                                <h1 class="question-heading-text" froala-prview-size>
                                                    {{{call-to-action}}}
                                                </h1>
                                            {{/ifCond}}
                                            {{/ifCond}}
                                            {{#ifCond show-description '==' 1 }}
                                                {{#ifCond description '!==' ''}}
                                                    <div class="question-description-text" froala-prview-size>
                                                        {{{description}}}
                                                    </div>
                                                {{/ifCond}}
                                            {{/ifCond}}
                                        </div>
                                        {{#ifCond cta-button '==' 1 }}
                                        <div class="question_answer__fields btns-fields">
                                            <div class="btn-wrap cta-btn-wrap {{#ifCond question_length '<' 2}}{{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}{{/ifCond}}">
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
