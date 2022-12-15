<?php
    date_default_timezone_set('America/Los_Angeles');
$page_name = (explode("?",basename($_SERVER['REQUEST_URI'])))[0];
define('VERSION','3.2.10');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- set the encoding of your site -->
    <meta charset="utf-8">
    <!-- set the viewport width and initial-scale on mobile devices  -->
    <meta name="viewport" content="width=1280">
    <!-- favicons -->
    <link rel="apple-touch-icon" sizes="120x120" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <title>leadPops™ Admin - Homepage</title>
    <!-- include the site stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/78d721c580.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/css/animate.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/dropzone/dropzone.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/owlcarousel/assets/owl.carousel.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/owlcarousel/assets/owl.theme.default.min.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/bootstrap-toggle/bootstrap-toggle.min.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/jquery-ui/jquery-ui.min.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/color-picker/colorpicker.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/select2js/select2.min.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/tooltipster/tooltipster.bundle.min.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/custom-scrollbar/jquery.mCustomScrollbar.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/css/froala_editor.min.css?v=4.4.49">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/css/froala_style.min.css?v=4.4.49">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.5/css/froala_editor.pkgd.min.css?v=4.4.49">
    <link rel="stylesheet" href="assets/external/froala-editor/css/froala_extend.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/froala-editor/css/froala_style.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/froala-editor/css/froala_custom.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/froala-editor/css/froala-template.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/date-picker/daterangepicker.css?v=<?php echo VERSION; ?>">
    <link rel="stylesheet" href="assets/external/bootstrap-slider/bootstrap-slider.css?v=<?php echo VERSION; ?>">
     <link rel="stylesheet" href="../lp_assets/theme_admin3/css/base.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/sidebar-menu.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/header.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/search-filter.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/home.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/footer.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/dev.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/pixel.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/modal.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/domain.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/accounts.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/thank-you.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/auto-responder.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/integration.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/lead-alert.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/inner-head.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/cta-message.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/pages-panel.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/panel-aside.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/stats.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/contact-info.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/browse.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/background.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/my-leads.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/theme-funnel.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/logo.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/cards.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/header-page.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/buttons-page.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/color-picker.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/name-tags.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/contests-page.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/platform-funnel.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/funnel-share.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/embed-webpage.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/questions-answer.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/progress-bar.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/new-transition.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/modal-thankyou.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/conditional-logic.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/funnel-questions.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/tabs.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/slider.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/sticky-bar.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/marketing-hub.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/sticky-bar-v1.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/ada.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/suport.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/email-fire.css?v=1.0<?php echo VERSION; ?>">
<link rel="stylesheet" href="../lp_assets/theme_admin3/css/backend.css?v=1.0<?php echo VERSION; ?>">	
    <link rel="stylesheet" href="assets/css/jquery.ics-gradient-editor.css?v=<?php echo VERSION; ?>">
</head>
<?php
$_SERVER['PHP_SELF'] = end(explode('/',$_SERVER['PHP_SELF']));
    $arr = array(
        'funnel-question.php',
        'new-transition.php',
        'fb-zip-code.php',
        'fb-menu.php',
        'fb-slider.php',
        'fb-text-field.php',
        'fb-drop-down.php',
        'fb-cta-message.php',
        'fb-date-birthday.php',
        'fb-list-of-states.php',
        'fb-vehicle-modal-make.php',
        'sticky-bar.php'
    );
    $page_arr = array(
        'funnel-question.php'=> 'Questions|content',
        'fb-zip-code.php'=> 'Questions|content',
        'fb-menu.php'=> 'Questions|content',
        'fb-list-of-states.php'=> 'Questions|content',
        'fb-vehicle-modal-make.php'=> 'Questions|content',
        'fb-slider.php'=> 'Questions|content',
        'fb-text-field.php'=> 'Questions|content',
        'fb-drop-down.php'=> 'Questions|content',
        'fb-cta-message.php'=> 'Questions|content',
        'fb-date-birthday.php'=> 'Questions|content',
        'new-transition.php'=> 'Questions|content',
        'cta-messaging.php'=> 'Call-to-Action|content',
        'create-security-messages.php'=> 'Security Message|content',
        'cta-message-advance.php' => 'Call-to-Action|content',
        'thank-you.php'=> 'Thank You Page|content',
        'thank-you-edit.php'=> 'Thank You Page|content',
        'thank-you-edit-basic.php' => 'Thank You Page|content',
        'autoresponder.php'=> 'Autoresponder|content',
        'auto-responder-basic.php'=> 'Autoresponder|content',
        'sender-email-list.php'=> 'Autoresponder|content',

        'theme-funnel.php'=> 'Themes|design',
        'header.php'=> 'Header|design',
        'footer.php'=> 'Footer|design',
        'footer-basic.php' => 'Footer|design',
        'privacy-policy.php'=> 'Footer|design',
        'featured-image.php'=> 'Featured Image|design',
        'background.php'=> 'Background|design',
        'background-advance.php'=> 'Background|design',
        'buttons.php'=> 'Buttons|design',
        'lp_fonts'=> 'Fonts|design',
        'progress-bar.php'=> 'Progress Bar|design',
        'contact-info.php'=> 'Contact Info|design',
        'logo.php'=> 'Logo|design',
        'question-answer.php'=> 'Q&A|design',

        'lead-alert.php'=> 'Lead Alerts|settings',
        'lp_partial_leads'=> 'Partial Leads|settings',
        'favicon.php'=> 'Favicon|settings',
        'pixels.php'=> 'Pixels|Settings',
        'integrations-funnel.php'=> 'Integrations|settings',
        'integration-velocify.php'=> 'Integrations|settings',
        'integration-salesforce.php'=> 'Integrations|settings',
        'intgration-bntouch.php'=> 'Integrations|settings',
        'integration-mortech.php'=> 'Integrations|settings',
        'integrations-advance.php'=> 'Integrations|settings',
        'create-contests-page.php'=> 'Funnel Contest|settings',
        'contests-page.php'=> 'Funnel Contest|settings',
        'dashboard-contests.php'=> 'Funnel Contest|settings',
        'integrations-ada.php'=> 'ADA Accessibility|settings',

        'lp_status'=> 'Status|settings',
        'lp_clone'=> 'Clone|settings',

        'name-tags.php'=> 'Name & Tags|basic info',
        'domain.php'=> 'Domains|basic info',
        'funnel-seo.php'=> 'SEO|basic info',

        'funnel-share.php'=> 'Share Your Funnel|Promote',
        'promote-embed-webpage.php'=> 'Embed in a Web Page|Promote',
        'promote-iframe-funnel.php'=> 'Place it in iFrame|Promote',
        'promote-openpop-funnel.php'=> 'Open in Popup|Promote',
        'promote-lightbox-funnel.php'=> 'Open in Lightbox|Promote',
        'platforms-funnel.php'=> 'Platforms|Promote',
        'platform-wordpress.php'=> 'Platforms|Promote',
        'platform-square-space.php'=> 'Platforms|Promote',
        'platform-weebly.php'=> 'Platforms|Promote',
        'platform-unbounce.php'=> 'Platforms|Promote',

        'sticky-bar.php'=> 'Sticky Bar|Promote',

        'stats.php'=> 'Statistics|funnel',
        'my-leads.php'=> 'My Leads|funnel',
    );

// variation pages navigation
$notSaveButton = array (
    'dashboard.php',
    'marketing-hub.php',
    'support.php',
    'stats.php',
    'my-leads.php'
);
$notGlobalOption = array (
	'create-contests-page.php',
	'contests-page.php',
	'dashboard-contests.php',
    'promote-embed-webpage.php',
    'promote-iframe-funnel.php,',
    'promote-openpop-funnel.php',
    'promote-lightbox-funnel.php',
    'platforms-funnel.php',
    'platform-wordpress.php',
    'platform-square-space.php',
    'platform-weebly.php',
    'platform-unbounce.php'
);

$variation1 =  array (
	'dashboard.php',
	'accounts.php'
);
$variation2 =  array (
	'footer-basic.php',
	'privacy-policy.php',
	'cta-messaging.php',
	'create-security-messages.php',
	'thank-you.php',
	'thank-you-edit-basic.php',
	'contact-info.php',
	'auto-responder-basic.php',
	//    design pages
	'theme-funnel.php',
	'header.php',
	'featured-image.php',
	'background.php',
	'question-answer.php',
	'buttons.php',
	'progress-bar.php',
	'logo.php',
	//    settings
	'lead-alert.php',
	'favicon.php',
	'pixels.php',
	'integrations-funnel.php',
	'integration-velocify.php',
	'integration-salesforce.php',
	'intgration-bntouch.php',
	'integration-mortech.php',
	'create-contests-page.php',
	'contests-page.php',
	'dashboard-contests.php',
	//    basic info
	'name-tags.php',
	'domain.php',
	'funnel-seo.php',
    //    promote pages
    'funnel-share.php',
    'promote-embed-webpage.php',
    'promote-iframe-funnel.php,',
    'promote-openpop-funnel.php',
    'promote-lightbox-funnel.php',
    'platforms-funnel.php',
    'platform-wordpress.php',
    'platform-square-space.php',
    'platform-weebly.php',
    'platform-unbounce.php',
    'integrations-ada.php'
);
$variation3 =  array (
	'funnel-question.php'
);
$variation4 =  array (
	'fb-zip-code.php',
	'fb-menu.php',
    'fb-slider.php',
    'fb-text-field.php',
    'fb-drop-down.php',
    'fb-cta-message.php',
    'fb-date-birthday.php',
    'fb-list-of-states.php',
    'fb-vehicle-modal-make.php',
    'new-transition.php'
);
$variation5 =  array (
	'stats.php',
	'my-leads.php'
);

function activeClass($curPage,$pageName){
    if($curPage == $pageName){
        return 'active';
    }
    else{
        return '';
    }
}
?>
<body class="<?php
    if(in_array(str_replace('/','',$_SERVER['PHP_SELF']),$arr)) {
        echo "aside-panel off-sidebar";
    }else{
        echo " sidebar-inner-active ";
    }
    if($page_name == 'dashboard.php') {
        echo " home-page sidebar-active ";
    }else{
        echo " inner-page ";
    }
    if ($page_name == 'accounts.php') {
        echo " account-page";
    }
    if($page_name == 'marketing-hub.php') {
        echo " single-sidebar";
    }
    if($page_name == 'funnel-question.php') {
        echo " responsive-view ";
    }
    if($page_name == 'sticky-bar.php') {
        echo " sticky-active ";
    }
    if(in_array(str_replace('/','',$_SERVER['PHP_SELF']),$variation4)) {
	    echo " funnel-editor ";
    }
    ?>">
<!-- main container of all the page elements -->
<div id="wrapper">
    <?php
        if (in_array(str_replace('/','',$_SERVER['PHP_SELF']), $notGlobalOption)) {
     ?>
        <div class="global global_mode-unavailable">
            <div class="global__bar">
                <p>GLOBAL SETTINGS MODE IS NOT AVAILABLE</p>
            </div>
        </div>
        <div class="global global_mode-off ">
            <div class="global__bar">
                <p>GLOBAL SETTINGS MODE IS OFF</p>
                <div class="switcher-min">
                    <input  id="global_mode_bar" name="global_mode_bar" data-toggle="toggle min"
                            data-onstyle="active" data-offstyle="inactive"
                            data-width="115" data-height="26" data-on="switch OFF"
                            data-off="switch ON" type="checkbox">
                </div>
            </div>
        </div>
     <?php
        }
     ?>
    <!-- wrapper holder of the page -->
    <div class="wrapper__holder">
