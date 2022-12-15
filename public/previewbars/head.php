<?php
include_once('env.php');
$dir = explode("public", __DIR__);
$env = new Env($dir[0] . ".env");
$env->load();
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="/lp_assets/theme_admin3/css/iconmoon.css">
<link rel="stylesheet" href="/lp_assets/theme_admin3/external/custom-scrollbar/jquery.mCustomScrollbar.css">

<link rel="stylesheet" href="/lp_assets/theme_admin3/css/funnel-preview-global.css?v=<?php echo getenv('ASSET_VERSION'); ?>">

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
<script src="https://images.lp-images1.com/default/js/handlebar/handlebars.min-v4.7.7.js"></script>

<script src="/lp_assets/theme_admin3/external/custom-scrollbar/jquery.mCustomScrollbar.js"></script>

<script src="/lp_assets/theme_admin3/js/funnel/funnels-util.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
<script src="/lp_assets/theme_admin3/js/funnel/handlbars-util.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
<script src="/lp_assets/theme_admin3/js/funnel/funnels-preview.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>
<!-- dyanmic colors for funnel builder funnel questions js file -->
<script src="/lp_assets/theme_admin3/js/funnel/funnels-preview-theme-colors.js?v=<?php echo getenv('ASSET_VERSION'); ?>"></script>