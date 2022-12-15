<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once('head.php');
    ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-dropdown-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/funnel-question-dropdown-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
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
                    FunnelsPreview.handleAlphabetizeAndRandomizeSort(json);
                    $("body").html(template(json));
                    dropdown_content.init();
                } else {
                    dropdown_content.handleHideUntilNotAnswered();
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
                    <div class="dropdown-questions-wrap {{#ifCond show-question '=='0}}without-heading{{/ifCond}} {{#ifCond show-description '=='0}}without-description{{/ifCond}}">
            <div class="question_dropdown question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="question_dropdown__fields">
                                            <div class="step-holder" data-extra-options="{{extra_options.none}}" data-extra-options-other="{{extra_options.other}}">
                                                {{#if searchable}}
                                                    {{#if select-multiple}}
                                                    <div class="search-mode-area multi-select-area">
                                                        <div class="form-group">
                                                            <div class="search-input-wrap">
                                                                <label for="search" class="input-label">Search</label>
                                                                <input type="search" id="search" class="form-control search-input" autocomplete="off">
                                                                <span class="search-icon ico-search-2"></span>
                                                                <div class="tag-box">
                                                                    <ul class="tag-box__list"></ul>
                                                                </div>
                                                                <div class="search-box">
                                                                    <span class="search-box__title">search results</span>
                                                                    <div class="scroll-bar">
                                                                        <ul id="search-list" class="search-box__list" data-search-list>
                                                                            {{#each fields}}
                                                                                {{#if this}}
                                                                            <li>
                                                                                <label class="check-label" data-selection-input>
                                                                                    <input type="checkbox" class="checkbox" value="{{this}}">
                                                                                    <span class="fake-label">{{this}}</span>
                                                                                </label>
                                                                            </li>
                                                                                {{/if}}
                                                                            {{/each}}
                                                                        </ul>
                                                                    </div>
                                                                    <div class="bottom-area">
                                                                        <a href="#" class="finish-btn">i'm finished</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{else}}
                                                    <div class="search-mode-area single-select">
                                                        <div class="form-group">
                                                            <div class="search-input-wrap">
                                                                <label for="search-single" class="input-label">Search</label>
                                                                <input type="search" id="search-single" class="form-control search-input" autocomplete="off">
                                                                <span class="search-icon ico-search-2"></span>
                                                                <div class="tag-box">
                                                                    <div class="search-tag-text-wrap">
                                                                        <span class="search-tag-text"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="search-box">
                                                                    <span class="search-box__title">search results</span>
                                                                    <div class="scroll-bar">
                                                                        <ul class="single-search-option-list" data-search-list>
                                                                            {{#each fields}}
                                                                                {{#if this}}
                                                                            <li>
                                                                                <a href="#" data-selection-input>
                                                                                    <span>{{this}}</span>
                                                                                    <input type="radio" name="radio" class="checkbox" value="{{this}}" hidden="hidden">
                                                                                </a>
                                                                            </li>
                                                                                {{/if}}
                                                                            {{/each}}
                                                                        </ul>
                                                                    </div>
                                                                    <div class="single-bottom-area">
                                                                        <a href="#" class="single-finish-btn">i'm finished</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{/if}}
                                                {{else}}
                                                {{#if select-multiple}}
                                                    <div class="multi-select-area">
                                                        <div class="multi-select-opener-wrap">
                                                            <ul class="multi-select-area__tag"></ul>
                                                            <a href="#" class="multi-select-opener {{#ifCond
                                                            enable-field-label '==' 0}}without-label{{/ifCond}}">
                                                                <span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span>
                                                            </a>
                                                        </div>
                                                        <div class="multi-select-dropdown">
                                                            <strong class="multi-select-dropdown__title"><span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span> <span class="icon-cancel ico-cross"></span></strong>
                                                            <div class="scroll-bar">
                                                                <div class="multi-select-dropdown__wrap">
                                                                    <div class="multi-select-dropdown__holder">
                                                                        <ul class="multi-check-list">
                                                                            {{#each fields}}
                                                                                {{#if this}}
                                                                                    <li>
                                                                                        <label class="check-label" data-selection-input>
                                                                                            <input type="checkbox" class="checkbox" value="{{this}}">
                                                                                            <span class="fake-label">{{this}}</span>
                                                                                        </label>
                                                                                    </li>
                                                                                {{/if}}
                                                                            {{/each}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="bottom-area">
                                                                <a href="#" class="finish-btn">i'm finished</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{else}}
                                                    <div class="single-select-area">
                                                        <div class="single-select-opener-wrap">
                                                            <a href="#" class="select-opener {{#ifCond
                                                            enable-field-label '==' 0}}without-label{{/ifCond}}">
                                                                <span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span>
                                                            </a>
                                                            <span class="select-opener-text"></span>
                                                        </div>
                                                        <div class="single-select-dropdown">
                                                            <strong class="single-select-dropdown__title"><span class="{{#ifCond enable-field-label '==' 0}}question-hide{{/ifCond}}">{{field-label}}</span> <span class="icon-cancel ico-cross"></span></strong>
                                                            <div class="scroll-bar">
                                                                <div class="single-select-dropdown__wrap">
                                                                    <div class="single-select-dropdown__holder">
                                                                        <ul class="single-select-list">
                                                                            {{#each fields}}
                                                                                {{#if this}}
                                                                                    <li>
                                                                                        <a href="#" data-selection-input>
                                                                                            <span>{{this}}</span>
                                                                                            <input type="radio" name="radio" class="checkbox" value="{{this}}" hidden="hidden">
                                                                                        </a>
                                                                                    </li>
                                                                                {{/if}}
                                                                            {{/each}}
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="single-bottom-area">
                                                                <a href="#" class="single-finish-btn">i'm finished</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{/if}}
                                                {{/if}}
                                            </div>
                                        </div>
                                        <div class="question_dropdown__fields btns-fields">
                                            {{#ifCond automatic-progress '==' 0}}
                                                <div class="btn-wrap cta-btn-wrap {{#ifCond question_length '<' 2}}{{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}{{/ifCond}}">
                                                    <a href="#" class="btn btn-secondary btn-next cta-btn {{#ifCond cta-button-settings.button-icon-position '==' 'RIGHT'}}right{{/ifCond}}"  style="font-size: {{cta-button-settings.font-size}}px;">
                                                        <span class="icon-holder" {{#ifCond cta-button-settings.enable-button-icon '==' 1}}style="display: inline"{{/ifCond}}><span class="icon-wrap"><i class="icon ico-{{cta-button-settings.button-icon}}" style="font-size: {{cta-button-settings.button-icon-size}}px;color:{{cta-button-settings.button-icon-color}};"></i></span></span>
                                                        {{button-text}}
                                                    </a>
                                                    <input type="hidden" id="hide_cta" value="{{cta-button-settings.enable-hide-until-answer}}">
                                                </div>
                                            {{/ifCond}}
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
