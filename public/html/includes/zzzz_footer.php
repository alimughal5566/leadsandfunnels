    </div>
</div>
    <?php
        @include ("includes/global-settings/modals-global-setting.php");
    ?>
    <!-- include jQuery library -->
    <script src="assets/js/jquery-3.4.1.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="assets/external/jquery-ui/jquery-ui.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/js/popper.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/js/bootstrap.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/js/jquery.ba-throttle-debounce.js"></script>
    <script src="assets/pages/google-fonts.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/bootstrap-toggle/bootstrap-toggle.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/bootstrap-slider/bootstrap-slider.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/jquery-waypoint/jquery.waypoints.min.js?v=<?php echo VERSION; ?>"></script>
<!--    <script src="assets/external/select2js/select2.full.min.js?v=--><?php //echo VERSION; ?><!--"></script>-->
    <script src="assets/external/select2js/select2.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/color-picker/colorpicker.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/tooltipster/tooltipster.bundle.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/nice-scroll/jquery.nicescroll.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/custom-scrollbar/jquery.mCustomScrollbar.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/froala-editor/js/froala_editor.pkgd.min.js?v=<?php echo VERSION; ?>"></script>
    <?php
        if($page_name == 'auto-responder-basic.php' || $page_name == 'footer-basic.php' || $page_name == 'thank-you-edit-basic.php') {
            ?>
                <script src="assets/external/froala-editor/js/super_footer_cta_link.js?v=<?php echo VERSION; ?>"></script>
            <?php
        } else {
            ?>
                <script src="assets/external/froala-editor/js/cta_link.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        ?>
    <script src="assets/external/froala-editor/js/video.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/froala-editor/js/file.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/froala-editor/js/font_family.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/froala-editor/js/font_awesome.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/froala-editor/js/froala-custom.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/auto-resize/autosize.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/jquery-validation/jquery.validate.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/input-mask/inputmask.bundle.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="//fast.wistia.com/assets/external/E-v1.js?v=<?php echo VERSION; ?>" charset="ISO-8859-1"></script>
    <script src="assets/external/wista/wista-player.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/date-picker/moment.js?v=<?php echo VERSION; ?>"></script>
<!--    <script src="assets/external/charts-js/chart.bundle.min.js?v=--><?php //echo VERSION; ?><!--"></script>-->
<!--    <script src="assets/external/charts-js/chart.min.js?v=--><?php //echo VERSION; ?><!--"></script>-->
<!--    <script src="assets/js/highstock.js?v=--><?php //echo VERSION; ?><!--"></script>-->
<!--    <script src="assets/js/exporting.js?v=--><?php //echo VERSION; ?><!--"></script>-->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="assets/external/date-picker/moment-timezone.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/date-picker/daterangepicker.js?v=<?php echo VERSION; ?>"></script>

    <script src="assets/external/jquery.ics-gradient-editor.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/color-thief.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/spectrum.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/jquery.base64.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/gradient-parser.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/tinycolor.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/bootstrap.touchspin.min.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/external/jquery.knob.min.js?v=<?php echo VERSION; ?>"></script>

    <?php
    if(@$_COOKIE['handlebar'] == 1){
    ?>
    <!--<script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.runtime.js"></script>
    <script src="assets/handlebars/templates.js"></script>
    <script src="assets/fbjs/handlbars-util.js?v=<?php echo VERSION; ?>"></script>
    <script src="assets/fbjs/funnels-util.js?v=<?php echo VERSION; ?>"></script>
    <script type="text/javascript">
        window.HANDLEBAR_ENABLE = true;
        // hbar.renderTemplate('standard.hbs', "questionsList", "questions.json");
        // hbar.renderTemplate('funnel-panel.hbs', "funnelPanel", "questions.json");
    </script>
    <?php
    } else {
        ?>
        <script type="text/javascript">
            window.HANDLEBAR_ENABLE = false;
        </script>
        <?php
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js?v=1.6.2" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TimelineLite.min.js?v=1.6.2" type="text/javascript"></script>
    <!-- include custom JavaScript -->
    <script src="assets/js/custom.js?v=<?php echo VERSION; ?>"></script>
    <?php
        if($page_name == 'accounts.php') {
            ?>
                <script src="assets/pages/account_profile.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'autoresponder.php' || $page_name == 'auto-responder-basic.php') {
            ?>
                <script src="assets/pages/auto-reponder.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'cta-messaging.php' || $page_name == 'cta-advance-pop.php' || $page_name == 'cta-message-advance.php' || $page_name == 'funnel-question.php' || $page_name == 'funnel-question-advance.php' ) {
            ?>
                <script src="assets/pages/cta_messages.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'domain.php') {
            ?>
                <script src="assets/pages/domain.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-seo.php') {
            ?>
                <script src="assets/pages/funnel_seo.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'integrations-funnel.php' || $page_name == 'integration-mortech.php' || $page_name == 'integration-salesforce.php' || $page_name == 'integration-velocify.php' || $page_name == 'intgration-bntouch.php' || $page_name == 'integration-homebot.php' ) {
            ?>
                <script src="assets/pages/integration.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'integrations-advance.php') {
            ?>
            <script src="assets/pages/integration-advance.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/js/slick-slider.min.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'lead-alert.php') {
            ?>
            <script src="assets/pages/leads_alert.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'pixels.php') {
            ?>
                <script src="assets/pages/pixels.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'thank-you.php' || $page_name == 'thank-you-edit.php' || $page_name == 'funnel-thank-you-edit.php' || $page_name == 'funnel-add-new-page.php' ||  $page_name == 'thank-you-edit-basic.php') {
            ?>
                <script src="assets/pages/thank_you.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-thank-you-page.php') {
            ?>
            <script src="assets/pages/funnel_thank_you.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'stats.php') {
            ?>
                <script src="assets/pages/stats.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'contact-info.php') {
            ?>
                <script src="assets/pages/contact-info.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'favicon.php' || $page_name == 'featured-image.php') {
            ?>
                <script src="assets/pages/favicon.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'featured-image.php') {
            ?>
                <script src="assets/pages/featured-img.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'my-leads.php') {
            ?>
                <script src="assets/pages/my-leads.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'background.php') {
            ?>
                <script src="assets/pages/background.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'background-advance.php') {
            ?>
            <script src="assets/external/dropzone/dropzone.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/background-advance.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'theme-funnel.php') {
            ?>
                <script src="assets/pages/theme-funnel.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'logo.php') {
            ?>
                <script src="assets/pages/logo.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'header.php') {
            ?>
                <script src="assets/pages/header-page.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'footer.php' || $page_name == 'footer-basic.php') {
            ?>
            <script src="https://www.jqueryscript.net/demo/Dynamic-Image-Resizing-Plugin-with-jQuery/src/jquery.ae.image.resize.js"></script>
            <script src="assets/external/dropzone/dropzone.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/footer-page.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/footer-advance-page.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'privacy-policy.php') {
            ?>
                <script src="assets/pages/privacy-policy.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'buttons.php') {
            ?>
                <script src="assets/pages/button-page.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'name-tags.php') {
            ?>
                <script src="assets/pages/name_tags.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'contests-page.php' || $page_name == 'dashboard-contests.php') {
            ?>
                <script src="assets/pages/contests-page.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-share.php' || $page_name == 'platform-wordpress.php' || $page_name == 'platform-square-space.php' || $page_name == 'platform-weebly.php' || $page_name == 'platform-unbounce.php') {
            ?>
                <script src="assets/pages/funnel-share.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-share-advance.php' || $page_name == 'dashboard-contests.php') {
            ?>
            <script src="assets/pages/funnel-share.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'promote-embed-webpage.php') {
            ?>
                <script src="assets/pages/embed-webpage.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/grab-code.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'promote-iframe-funnel.php') {
            ?>
                <script src="assets/pages/iframe-yourfunnel.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/grab-code.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'promote-openpop-funnel.php' || $page_name == 'promote-lightbox-funnel.php') {
            ?>
                <script src="assets/pages/pop-yourfunnel.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/grab-code.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'text.php') {
            ?>
                <script src="assets/pages/question-answer.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'progress-bar.php') {
            ?>
                <script src="assets/pages/progress-bar/jquery.ui.touch-punch.min.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/progress-bar/lottie.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/progress-bar/DrawSVGPlugin.min.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/progress-bar/CSSPlugin.min.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/progress-bar/Physics2DPlugin.min.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/progress-bar.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'new-transition.php') {
            ?>
                <script src="assets/pages/new-transition.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-question-group.php') {
            ?>
            <script src="assets/pages/funnel-question-group.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/text-field-overlay.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/text-field-content.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-question-group-zip-code.php') {
            ?>
            <script src="assets/pages/zip-code-overlay.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/zip-code-content.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-question-group-menu.php') {
            ?>
            <script src="assets/pages/funnel-question-menu-content.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/funnel-question-menu-overlay.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'funnel-question-group-text-field.php' || $page_name == 'funnel-question-group-text-field-iframe.php' ) {
            ?>
            <script src="assets/pages/text-field-overlay.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/text-field-content.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }

        if($page_name == 'funnel-question-advance.php' || $page_name == 'funnel-question.php' || $page_name == 'fb-zip-code.php' || $page_name == 'fb-menu.php' || $page_name == 'fb-slider.php' || $page_name == 'fb-text-field.php' || $page_name == 'fb-drop-down.php' || $page_name == 'fb-cta-message.php' || $page_name == 'fb-date-birthday.php' || $page_name == 'fb-list-of-states.php' || $page_name == 'fb-vehicle-modal-make.php') {
            ?>
                <script src="assets/pages/name_tags.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/pages/funnel-questions.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'sticky-bar.php') {
            ?>
                <script src="assets/external/owlcarousel/owl.carousel.min.js?v=<?php echo VERSION; ?>"></script>
                <script src="assets/external/dropzone/dropzone.js?v=<?php echo VERSION; ?>"></script>
<!--                <script src="assets/pages/lp_sticky_bar.js?v=--><?php //echo VERSION; ?><!--"></script>-->
                <script src="assets/js/sticky.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'support.php') {
            ?>
            <script src="assets/pages/support.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'create-security-messages.php') {
            ?>
            <script src="assets/pages/security-messages.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        if($page_name == 'leadpops-branding.php') {
            ?>
            <script src="assets/external/dropzone/dropzone.js?v=<?php echo VERSION; ?>"></script>
            <script src="assets/pages/leadpops-branding.js?v=<?php echo VERSION; ?>"></script>
            <?php
        }
        ?>
    </body>
</html>
