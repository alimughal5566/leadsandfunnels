<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/lp_assets/theme_admin3/external/bootstrap-slider/bootstrap-slider.css">
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-slider.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/external/bootstrap-slider/bootstrap-slider.min.js"></script>
        <script src="/lp_assets/theme_admin3/js/funnel/scripts/funnel-question-slider-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var raw_html = $("#preview-template").html();
            var template = Handlebars.compile(raw_html);

            Handlebars.registerPartial("one-puck-slider", Handlebars.compile($("#one-puck-slider").html()));
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
                    slider_content.init();
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
                    <div class="funnel-slider-wrap">
                        <div class="question_slider question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="puck-sliders-wrap">
                                             {{#ifCond slider-numeric.value '==' 1 }}
                                                {{#ifCond slider-numeric.one-puck.value '==' 1 }}
                                                    {{>one-puck-slider slider=slider-numeric.one-puck}}
                                                {{/ifCond}}

                                                 {{#ifCond slider-numeric.two-puck.value '==' 1 }}
                                                    <div class="question_slider__fields">
                                                        <div class="range-slider">
                                                            <div id="current_val" class="current-val two-puck-starting-point">{{slider-numeric.two-puck.customize-slider-labels.left}} to {{slider-numeric.two-puck.customize-slider-labels.right}}</div>
                                                            <input type="text" data-slider-two-puck-point-value data-slider-min="0" data-slider-max="" data-slider-step="1"  data-slider-value="{{#ifCond slider-numeric.two-puck.slider-starting-point.value '==' 1}}{{slider-numeric.two-puck.slider-starting-point.starting-value}},{{slider-numeric.two-puck.slider-starting-point.ending-value}}{{/ifCond}}">
                                                            <ul class="range-slider__value">
                                                                <li class="slider-left-label">{{slider-numeric.two-puck.customize-slider-labels.left_label}}</li>
                                                                <li class="slider-right-label">{{slider-numeric.two-puck.customize-slider-labels.right_label}}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                  {{/ifCond}}
                                            {{/ifCond}}
                                            {{#ifCond slider-non-numeric.value '==' 1 }}
                                                {{>one-puck-slider slider=slider-non-numeric}}
                                            {{/ifCond}}
                                        </div>
                                        <div class="question_slider__fields btns-fields">
                                            <div class="btn-wrap vehicle-btn-wrap cta-btn-wrap {{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}">
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

<script id="one-puck-slider" type="text/x-handlebars-template">
    <div class="question_slider__fields">
        <div class="range-slider">
            <div id="current_val" class="current-val">{{slider.customize-slider-labels.left}}</div>
            <input id="range_slider" data-slider-one-puck type="text" data-slider-tooltip="hide" data-slider-min="" data-slider-max="" data-slider-step="1" data-slider-value="{{#ifCond slider.slider-starting-point.value '==' 1}}{{slider.slider-starting-point.starting-value}}{{/ifCond}}"/>
            <ul class="range-slider__value">
                <li class="slider-left-label">{{slider.customize-slider-labels.left_label}}</li>
                <li class="slider-right-label">{{slider.customize-slider-labels.right_label}}</li>
            </ul>
        </div>
    </div>
</script>
</body>
</html>
