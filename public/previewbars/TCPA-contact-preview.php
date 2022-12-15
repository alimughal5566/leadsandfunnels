<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-contact-info-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/funnel-question-contact-info-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
    <script src="/lp_assets/theme_admin3/external/input-mask/inputmask.bundle.min.js"></script>
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
                if(json !== undefined)
                {
                    let active_step = json['options']['activesteptype'] - 1;
                    let active_slide = json['active_slide'];
                    json['contact-form'] =  json['options']['all-step-types'][active_step].steps[active_slide];
                    if (refresh) {
                        $("body").html(template(json));
                        contact_info_content.init();
                    }
                    contact_info_content.handleHideUntilNotAnswered();
                }else{
                    let json = [];
                    json['text'] = ['here is the message'];
                    json['text']['message'] = 'No Phone Number Field Available';
                    $("body").addClass('tcpa-error-message-active').html(template(json));
                }


            };
            FunnelsPreview.callback(true);
            FunnelsPreview.changesTrigger();
            FunnelsPreview.setIframeHeight();
            FunnelsPreview.desktopFont();
        });
    </script>
</head>
<script id="preview-template" type="text/x-handlebars-template">
    {{#with contact-form}}

    <div class="<?php echo isset($_REQUEST['is_messages_module']) && $_REQUEST['is_messages_module'] == 1 ? 'funnel-iframe-inner-holder inner-iframe-parent' : 'funnel-iframe-inner-holder'; ?>">
        <div class="funnel-iframe-inner-area">
            <div class="funnel-iframe-inner-wrap">
                <div class="contact-info-questions-wrap">
                    <div class="question_contact-info question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                    <div class="question_contact-info__fields">
                                        <div class="step-holder">
                                            {{#if field-order}}
                                            {{#each field-order}}                                        {{#getProperty ../fields .}}
                                            {{#if value}}
                                            <div class="form-group {{#ifCond enable-field-label '=='1}}without-label{{/ifCond}}">
                                                <div class="input-wrap {{#ifCond ../../enable-auto-cursor-focus '==' 1}}field-focus{{/ifCond}}">
                                                    <input type="{{#ifCond auto-format '==' 1}}tel{{else}}text{{/ifCond}}" id="{{#ifCond validation '==' 'phone'}}phone_number{{else}}{{data-field}}{{/ifCond}}" class="form-control validate-input" autocomplete="off" data-function-name="formValidation" data-required="{{required}}">
                                                    <label for="{{data-field}}" class="input-label">{{field-label}}</label>
                                                    <span class="icon-valid"><span class="icon-check"></span></span>
                                                    <span class="icon-invalid"><span class="icon-cross"></span></span>
                                                </div>
                                            </div>
                                            {{/if}}
                                            {{/getProperty}}
                                            {{/each}}
                                            {{/if}}
                                        </div>
                                    </div>
                                    <div class="question_contact-info__fields btns-fields">
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
                                    include("tcpa-privacy-additional-content-section.php");
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
    {{#with text}}
    <div class="<?php echo isset($_REQUEST['is_messages_module']) && $_REQUEST['is_messages_module'] == 1 ? 'funnel-iframe-inner-holder inner-iframe-parent' : 'funnel-iframe-inner-holder'; ?>">
        <div class="funnel-iframe-inner-area">
            <div class="funnel-iframe-inner-wrap">
                <div class="contact-info-questions-wrap">
                    <div class="question_contact-info question-preview-parent mobile-preview">
                        <h1>{{ message }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{/with}}
</script>
<body>
</body>
</html>
