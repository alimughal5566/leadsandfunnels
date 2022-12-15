<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('head.php'); ?>
    <link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-question-birthday-content.css?v=<?php echo getenv('ASSET_VERSION'); ?>">
    <script src="/lp_assets/theme_admin3/js/funnel/scripts/funnel-question-birthday-content.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
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
                $years_back = json['options']['year-start'];
                window.json['options']['years-list'] = birthday_content.getYearsList(json['options']['year-start'], json['options']['minimum-age']);
                if (refresh) {
                    $("body").html(template(json));
                    birthday_content.init();
                }
                if($years_back < 4)
                {
                    $('[data-years-list]').addClass('less-years');
                }
                birthday_content.handleHideUntilNotAnswered();
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
                    <div class="funnel-birthday-wrap {{#ifCond show-question '=='0}}without-heading{{/ifCond}} {{#ifCond show-description '=='0}}without-description{{/ifCond}}">
                        <div class="question_birthday question-preview-parent mobile-preview{{#ifCond ../cta-main-message '!=' ''}} cta-message-active{{/ifCond}}">
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
                                        <div class="question_birthday__fields">
                                            <div class="form-group">
                                                <div class="field-holder month-holder">
                                                    <a href="#" class="field-opener">
                                                        <div class="field-opener__wrap">
                                                            <span class="label_text">Month</span>
                                                            <span class="selected_text"></span>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-holder">
                                                        <div class="dropdown-wrap">
                                                            <strong class="title">select month</strong>
                                                            <span class="icon-cancel">
                                                                <i class="ico-cross"></i>
                                                            </span>
                                                            <div class="list-holder scroll-bar">
                                                                <ul class="list-options">
                                                                    <li><a href="#" data-title="01">January</a></li>
                                                                    <li><a href="#" data-title="02">February</a></li>
                                                                    <li><a href="#" data-title="03">March</a></li>
                                                                    <li><a href="#" data-title="04">April</a></li>
                                                                    <li><a href="#" data-title="05">May</a></li>
                                                                    <li><a href="#" data-title="06">June</a></li>
                                                                    <li><a href="#" data-title="07">July</a></li>
                                                                    <li><a href="#" data-title="08">August</a></li>
                                                                    <li><a href="#" data-title="09">September</a></li>
                                                                    <li><a href="#" data-title="10">October</a></li>
                                                                    <li><a href="#" data-title="11">November</a></li>
                                                                    <li><a href="#" data-title="12">December</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="field-holder days-holder">
                                                    <a href="#" class="field-opener">
                                                        <div class="field-opener__wrap">
                                                            <span class="label_text">day</span>
                                                            <span class="selected_text"></span>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-holder">
                                                        <div class="dropdown-wrap">
                                                            <strong class="title">select day</strong>
                                                            <span class="icon-cancel">
                                                                <i class="ico-cross"></i>
                                                            </span>
                                                            <div class="list-holder scroll-bar">
                                                                <ul class="list-options">
                                                                    <li><a href="#" data-title="1">1</a></li>
                                                                    <li><a href="#" data-title="2">2</a></li>
                                                                    <li><a href="#" data-title="3">3</a></li>
                                                                    <li><a href="#" data-title="4">4</a></li>
                                                                    <li><a href="#" data-title="5">5</a></li>
                                                                    <li><a href="#" data-title="6">6</a></li>
                                                                    <li><a href="#" data-title="7">7</a></li>
                                                                    <li><a href="#" data-title="8">8</a></li>
                                                                    <li><a href="#" data-title="9">9</a></li>
                                                                    <li><a href="#" data-title="10">10</a></li>
                                                                    <li><a href="#" data-title="11">11</a></li>
                                                                    <li><a href="#" data-title="12">12</a></li>
                                                                    <li><a href="#" data-title="13">13</a></li>
                                                                    <li><a href="#" data-title="14">14</a></li>
                                                                    <li><a href="#" data-title="15">15</a></li>
                                                                    <li><a href="#" data-title="16">16</a></li>
                                                                    <li><a href="#" data-title="17">17</a></li>
                                                                    <li><a href="#" data-title="18">18</a></li>
                                                                    <li><a href="#" data-title="19">19</a></li>
                                                                    <li><a href="#" data-title="20">20</a></li>
                                                                    <li><a href="#" data-title="21">21</a></li>
                                                                    <li><a href="#" data-title="22">22</a></li>
                                                                    <li><a href="#" data-title="23">23</a></li>
                                                                    <li><a href="#" data-title="24">24</a></li>
                                                                    <li><a href="#" data-title="25">25</a></li>
                                                                    <li><a href="#" data-title="26">26</a></li>
                                                                    <li><a href="#" data-title="27">27</a></li>
                                                                    <li><a href="#" data-title="28">28</a></li>
                                                                    <li><a href="#" data-title="29">29</a></li>
                                                                    <li><a href="#" data-title="30">30</a></li>
                                                                    <li><a href="#" data-title="31">31</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="field-holder year-holder  " data-years-list>
                                                    <a href="#" class="field-opener">
                                                        <div class="field-opener__wrap">
                                                            <span class="label_text">year</span>
                                                            <span class="selected_text"></span>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-holder">
                                                        <div class="dropdown-wrap">
                                                            <strong class="title">select Year</strong>
                                                            <span class="icon-cancel">
                                                                <i class="ico-cross"></i>
                                                            </span>
                                                            <div class="list-holder scroll-bar">
                                                                <ul class="list-options">
                                                                    {{{years-list}}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question_birthday__fields btns-fields">
                                            {{#ifCond automatic-progress '==' 0}}
                                                <div class="btn-wrap cta-btn-wrap {{#ifCond question_length '<' 2}}{{#ifCond cta-button-settings.enable-hide-until-answer '==' 1}}hide-btn{{/ifCond}}{{/ifCond}}">
                                                    <a href="#" class="btn btn-secondary btn-next cta-btn {{#ifCond cta-button-settings.button-icon-position '==' 'RIGHT'}}right{{/ifCond}}" style="font-size: {{cta-button-settings.font-size}}px;">
                                                        <span class="icon-holder" {{#ifCond cta-button-settings.enable-button-icon '==' 1}}style="display: inline"{{/ifCond}}><span class="icon-wrap"><i class="icon ico-{{cta-button-settings.button-icon}}" style="font-size: {{cta-button-settings.button-icon-size}}px;color:{{cta-button-settings.button-icon-color}};"></i></span></span>
                                                        {{button-text}}
                                                    </a>
                                                    <input type="hidden" id="hide_cta" value="{{cta-button-settings.enable-hide-until-answer}}">
                                                </div>
                                            {{/ifCond}}
                                            <div class="form-group error-message" data-error-msg></div>
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
