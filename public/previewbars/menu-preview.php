<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-menu-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/funnel-question-menu-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
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
                    FunnelsPreview.handleAlphabetizeOptions(json);
                    $("body").html(template(json));
                    menu_content.init();
                } else {
                    menu_content.handleHideUntilNotAnswered();
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
                    <div class="funnel-menu-wrap">
                        <div class="question_menu question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="menu-steps-wrap">

                                            {{#if fields}}
                                                {{#ifCond fields.length '<' 5}}
                                                    <!--start four option radio and checkbox-->
                                            <div class="question {{#if select-multiple}}question_single-question-checkbox{{else}}question_radio-question{{/if}}">
                                                <div class="step-holder" data-extra-options="{{#ifCond include-none '==' 1}}{{extra_options.none}}{{/ifCond}}" data-extra-options-other="{{#ifCond add-other-option '==' 1}}{{extra_options.other}}{{/ifCond}}">
                                                    {{#if select-multiple}}
                                                        {{#each fields}}
                                                            {{#if this}}
                                                    <div class="question__fields">
                                                        <div class="form-group">
                                                            <div class="input-wrap">
                                                                <div class="checkbox-button" data-selection-input>
                                                                    <span class="fake-input"></span>
                                                                    <span>{{this}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                       {{/if}}
                                                        {{/each}}
                                                        {{else}}
                                                        {{#each fields}}
                                                            {{#if this}}
                                                                <div class="question__fields">
                                                                    <div class="form-group">
                                                                        <div class="input-wrap">
                                                                            <div class="radio-button single-radio" data-selection-input>
                                                                                <span>{{this}}</span>
                                                                                <span class="icon-valid"><span class="ico-check"></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{/if}}
                                                        {{/each}}
                                                    {{/if}}
                                            </div>
                                            </div>
                                                {{/ifCond}}
                                                <!--end four option radio and checkbox-->
                                                <!--start above four option radio and checkbox-->
                                                {{#ifCond fields.length '>' 4}}
                                                    <div class="question {{#if select-multiple}}question_single-question-checkbox-group{{else}}question_radio-question-group{{/if}}">
                                                        <div class="step-holder" data-extra-options="{{#ifCond include-none '==' 1}}{{extra_options.none}}{{/ifCond}}" data-extra-options-other="{{#ifCond add-other-option '==' 1}}{{extra_options.other}}{{/ifCond}}">
                                                                {{#if select-multiple}}
                                                                        {{#eachRow fields 2}}
                                                                                <div class="question-holder">
                                                                                    <div class="form-group">
                                                                                    {{#each columns}}
                                                                                        {{#if this}}
                                                                                            <div class="question__fields">
                                                                                            <div class="input-wrap">
                                                                                                <div class="checkbox-button" data-selection-input>
                                                                                                    <span class="fake-input"></span>
                                                                                                    <span>{{this}}</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        {{/if}}
                                                                                    {{/each}}
                                                                                    </div>
                                                                                </div>
                                                                        {{/eachRow}}
                                                                {{else}}
                                                                    {{#eachRow fields 2}}
                                                                            <div class="question-holder">
                                                                                <div class="form-group">
                                                                                    {{#each columns}}
                                                                                        {{#if this}}
                                                                                        <div class="question__fields">
                                                                                            <div class="input-wrap">
                                                                                                <div class="radio-button single-radio" data-selection-input>
                                                                                                    <span>{{this}}</span>
                                                                                                    <span class="icon-valid"><span class="ico-check"></span></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        {{/if}}
                                                                                    {{/each}}
                                                                                </div>
                                                                            </div>
                                                                    {{/eachRow}}
                                                                {{/if}}
                                                        </div>
                                                    </div>
                                                {{/ifCond}}
                                                <!--end above four option radio and checkbox-->
                                            {{/if}}
                                        </div>
                                        {{#ifCond automatic-progress '==' 0}}
                                        <div class="question__fields btns-fields">
                                            <div class="btn-wrap cta-btn-wrap {{#ifCond question_length '<' 2}}{{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}{{/ifCond}}">
                                                <a href="#" class="btn btn-secondary btn-next cta-btn {{#ifCond cta-button-settings.button-icon-position '==' 'RIGHT'}}right{{/ifCond}}"  style="font-size: {{cta-button-settings.font-size}}px;">
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
