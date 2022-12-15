<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-number-content.css">
    <script src="/lp_assets/theme_admin3/external/input-mask/inputmask.bundle.min.js"></script>
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/funnel-question-number-content.js"></script>

    <script src="/lp_assets/theme_admin3/js/funnel/iframe-global-content.js"></script>
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
    <div class="funnel-number-wrap">
        <div class="question_number mobile-preview">
            <div class="number-fields-area">
                <div class="question_number__title">
                    {{#ifCond show-question '==' 1 }}
                        {{#ifCond question '!==' ''}}
                            <h1>{{{question}}}</h1>
                        {{/ifCond}}
                    {{/ifCond}}
                    {{#ifCond show-description '==' 1 }}
                        {{#ifCond description '!==' ''}}
                            <div class="question_answer__text">
                                {{{description}}}
                            </div>
                        {{/ifCond}}
                    {{/ifCond}}
                </div>
                <div class="question_number__fields">
                    <div class="form-group">
                        <div class="input-wrap number__field">
                            <input type="text" id="{{data-field}}" class="form-control validate-input {{#ifCond question_value '!==' ''}}filled{{/ifCond}}" value="{{{question_value}}}" autocomplete="off" data-function-name="formValidation">
                            <label for="{{data-field}}" class="input-label {{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</label>
                            <span class="icon-valid"><span class="ico-check"></span></span>
                            <span class="icon-invalid"><span class="ico-cross"></span></span>
                        </div>
                    </div>
                </div>
                <div class="question_number__fields btns-fields">
                    <div class="btn-wrap cta-btn-wrap">
                        <a href="#" class="btn btn-secondary btn-next cta-btn {{#ifCond cta-button-settings.button-icon-position '==' 'RIGHT'}}right{{/ifCond}}" style="font-size: {{cta-button-settings.font-size}}px;">
                            <span class="icon-holder" {{#ifCond cta-button-settings.enable-button-icon '==' 1}}style="display: inline"{{/ifCond}}><span class="icon-wrap"><i class="icon ico-{{cta-button-settings.button-icon}}" style="font-size: {{cta-button-settings.button-icon-size}}px;color:{{cta-button-settings.button-icon-color}};"></i></span></span>
                            {{button-text}}
                        </a>
                    </div>
                </div>
                <span class="privacy-text" {{#ifCond enable-security-message '==' 0}}style="display: none"{{/ifCond}}>
                       <span class="privacy">{{{security_tcpa_messages}}}</span>
                </span>
                <span class="additional-content-text"  {{#ifCond enable-additional-content '==' 0}}style="display: none;"{{/ifCond}}>
                       <span class="text">{{{additional-content}}}</span>
                </span>
            </div>
        </div>
    </div>
    {{/with}}
</script>
</body>
</html>
