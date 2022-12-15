var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var csso = require('gulp-csso');
var minifyJS = require('gulp-uglify');

var handlebars = require('gulp-handlebars');
var wrap = require('gulp-wrap');
var declare = require('gulp-declare');

var config = {
    'external_styles': [
        'public/lp_assets/theme_admin3/css/bootstrap.min.css',
        'public/lp_assets/theme_admin3/css/animate.css',
        'public/lp_assets/theme_admin3/external/dropzone/dropzone.css',
        'public/lp_assets/theme_admin3/external/owlcarousel/assets/owl.carousel.css',
        'public/lp_assets/theme_admin3/external/owlcarousel/assets/owl.theme.default.min.css',
        'public/lp_assets/theme_admin3/external/bootstrap-toggle/bootstrap-toggle.min.css',
        'public/lp_assets/theme_admin3/external/jquery-ui/jquery-ui.min.css',
        'public/lp_assets/theme_admin3/external/color-picker/colorpicker.css',
        'public/lp_assets/theme_admin3/external/select2js/select2.min.css',
        'public/lp_assets/theme_admin3/external/tooltipster/tooltipster.bundle.min.css',
        'public/lp_assets/theme_admin3/external/custom-scrollbar/jquery.mCustomScrollbar.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/froala_editor.min.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/froala_style.min.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/froala_editor.pkgd.min.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/froala_extend.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/froala_style.min.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/froala_custom.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/froala-template.css',
        'public/lp_assets/theme_admin3/external/froala-editor/css/third_party/font_awesome.css',
        'public/lp_assets/theme_admin3/external/date-picker/daterangepicker-new.css',
        'public/lp_assets/theme_admin3/external/date-picker/daterangepicker.css',
        'public/lp_assets/theme_admin3/external/bootstrap-slider/bootstrap-slider.css',
    ],
    'pages_style': [
        'public/lp_assets/theme_admin3/css/base.css',
        'public/lp_assets/theme_admin3/css/sidebar-menu.css',
        'public/lp_assets/theme_admin3/css/header.css',
        'public/lp_assets/theme_admin3/css/search-filter.css',
        'public/lp_assets/theme_admin3/css/home.css',
        'public/lp_assets/theme_admin3/css/footer.css',
        'public/lp_assets/theme_admin3/css/dev.css',
        'public/lp_assets/theme_admin3/css/pixel.css',
        'public/lp_assets/theme_admin3/css/modal.css',
        'public/lp_assets/theme_admin3/css/domain.css',
        'public/lp_assets/theme_admin3/css/accounts.css',
        'public/lp_assets/theme_admin3/css/thank-you.css',
        'public/lp_assets/theme_admin3/css/auto-responder.css',
        'public/lp_assets/theme_admin3/css/integration.css',
        'public/lp_assets/theme_admin3/css/lead-alert.css',
        'public/lp_assets/theme_admin3/css/inner-head.css',
        'public/lp_assets/theme_admin3/css/cta-message.css',
        'public/lp_assets/theme_admin3/css/pages-panel.css',
        'public/lp_assets/theme_admin3/css/panel-aside.css',
        'public/lp_assets/theme_admin3/css/stats.css',
        'public/lp_assets/theme_admin3/css/contact-info.css',
        'public/lp_assets/theme_admin3/css/browse.css',
        'public/lp_assets/theme_admin3/css/background.css',
        'public/lp_assets/theme_admin3/css/my-leads.css',
        'public/lp_assets/theme_admin3/css/theme-funnel.css',
        'public/lp_assets/theme_admin3/css/logo.css',
        'public/lp_assets/theme_admin3/css/cards.css',
        'public/lp_assets/theme_admin3/css/header-page.css',
        'public/lp_assets/theme_admin3/css/buttons-page.css',
        'public/lp_assets/theme_admin3/css/color-picker.css',
        'public/lp_assets/theme_admin3/css/name-tags.css',
        'public/lp_assets/theme_admin3/css/contests-page.css',
        'public/lp_assets/theme_admin3/css/platform-funnel.css',
        'public/lp_assets/theme_admin3/css/funnel-share.css',
        'public/lp_assets/theme_admin3/css/embed-webpage.css',
        'public/lp_assets/theme_admin3/css/questions-answer.css',
        'public/lp_assets/theme_admin3/css/progress-bar.css',
        'public/lp_assets/theme_admin3/css/new-transition.css',
        'public/lp_assets/theme_admin3/css/modal-thankyou.css',
        'public/lp_assets/theme_admin3/css/conditional-logic.css',
        'public/lp_assets/theme_admin3/css/funnel-questions.css',
        'public/lp_assets/theme_admin3/css/tabs.css',
        'public/lp_assets/theme_admin3/css/slider.css',
        'public/lp_assets/theme_admin3/css/sticky-bar.css',
        'public/lp_assets/theme_admin3/css/marketing-hub.css',
        'public/lp_assets/theme_admin3/css/sticky-bar-v1.css',
        'public/lp_assets/theme_admin3/css/ada.css',
        'public/lp_assets/theme_admin3/css/suport.css',
        'public/lp_assets/theme_admin3/css/email-fire.css',
        'public/lp_assets/theme_admin3/css/backend.css',
        'public/lp_assets/theme_admin3/css/jquery.ics-gradient-editor.css',
        'public/lp_assets/theme_admin3/css/froala-update-version-style.css',
        'public/lp_assets/theme_admin3/css/leadpops-branding.css',
        'public/lp_assets/theme_admin3/css/app-icomoon.css',
    ],
    'global_script': [
        'public/lp_assets/theme_admin3/js/popper.min.js',
        'public/lp_assets/theme_admin3/js/bootstrap.min.js',
        'public/lp_assets/theme_admin3/js/global-functions.js',
        'public/lp_assets/theme_admin3/js/custom-steele.js',
        'public/lp_assets/theme_admin3/js/ajax-request-handler.js',
        'public/lp_assets/theme_admin3/js/jquery.fittext.js',
        'public/lp_assets/theme_admin3/js/sticky-bar.js',
        'public/lp_assets/theme_admin3/js/global/global_settings.js',
        'public/lp_assets/theme_admin3/js/global/global_modal.js',
        'public/lp_assets/theme_admin3/js/global/confirmation_modal.js',
        'public/lp_assets/common/cogo-toaster.js',
        'public/lp_assets/common/extended-cogo-toaster.js',
    ],
    'external_scripts': [
        'public/lp_assets/theme_admin3/external/jquery-ui/jquery-ui.min.js',
        'public/lp_assets/theme_admin3/external/bootstrap-toggle/bootstrap-toggle.min.js',
        'public/lp_assets/theme_admin3/external/bootstrap-slider/bootstrap-slider.js',
        'public/lp_assets/theme_admin3/external/jquery-waypoint/jquery.waypoints.min.js',
        'public/lp_assets/theme_admin3/external/select2js/select2.min.js',
        'public/lp_assets/theme_admin3/external/color-picker/colorpicker.js',
        'public/lp_assets/theme_admin3/external/tooltipster/tooltipster.bundle.min.js',
        'public/lp_assets/theme_admin3/external/nice-scroll/jquery.nicescroll.min.js',
        'public/lp_assets/theme_admin3/external/custom-scrollbar/jquery.mCustomScrollbar.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/froala_editor.pkgd.min.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/video.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/more_options.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/third_party/font_awesome.min.js',
        'public/lp_assets/theme_admin3/external/auto-resize/autosize.min.js',
        'public/lp_assets/theme_admin3/external/jquery-validation/jquery.validate.js',
        'public/lp_assets/theme_admin3/external/input-mask/inputmask.bundle.min.js',
        'public/lp_assets/theme_admin3/external/wista/wista-player.js',
        'public/lp_assets/theme_admin3/external/charts-js/chart.min.js',
        'public/lp_assets/theme_admin3/external/date-picker/moment.js',
        'public/lp_assets/theme_admin3/external/date-picker/moment-timezone.min.js',
        'public/lp_assets/theme_admin3/external/date-picker/daterangepicker.js',
        'public/lp_assets/theme_admin3/external/jquery.ics-gradient-editor.js',
        'public/lp_assets/theme_admin3/external/color-thief.js',
        'public/lp_assets/theme_admin3/external/spectrum.js',
        'public/lp_assets/theme_admin3/external/jquery.base64.min.js',
        'public/lp_assets/theme_admin3/external/gradient-parser.js',
        'public/lp_assets/theme_admin3/external/tinycolor.js',
        'public/lp_assets/theme_admin3/external/bootstrap.touchspin.min.js',
        'public/lp_assets/theme_admin3/external/jquery.knob.min.js',
        'public/lp_assets/theme_admin3/external/owlcarousel/owl.carousel.min.js',
    ],
    'funnel_builder_scripts': [
        'public/lp_assets/theme_admin3/js/bootstrap.min.js',
        'public/lp_assets/theme_admin3/external/jquery-ui/jquery-ui.min.js',
        'public/lp_assets/theme_admin3/js/global-functions.js',
        'public/lp_assets/theme_admin3/js/custom-steele.js',
        'public/lp_assets/theme_admin3/js/ajax-request-handler.js',
        'public/lp_assets/common/cogo-toaster.js',
        'public/lp_assets/common/extended-cogo-toaster.js',
        'public/lp_assets/theme_admin3/external/bootstrap-toggle/bootstrap-toggle.min.js',
        'public/lp_assets/theme_admin3/external/bootstrap-slider/bootstrap-slider.js',
        'public/lp_assets/theme_admin3/external/select2js/select2.min.js',
        'public/lp_assets/theme_admin3/external/color-picker/colorpicker.js',
        'public/lp_assets/theme_admin3/external/tooltipster/tooltipster.bundle.min.js',
        'public/lp_assets/theme_admin3/external/nice-scroll/jquery.nicescroll.min.js',
        'public/lp_assets/theme_admin3/external/custom-scrollbar/jquery.mCustomScrollbar.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/froala_editor.pkgd.min.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/video.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/phone_number.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/more_options.js',
        'public/lp_assets/theme_admin3/external/froala-editor/js/third_party/font_awesome.min.js',
        'public/lp_assets/theme_admin3/external/jquery-validation/jquery.validate.js',
        'public/lp_assets/theme_admin3/external/input-mask/inputmask.bundle.min.js',
        'public/lp_assets/theme_admin3/external/wista/wista-player.js',
        'public/lp_assets/theme_admin3/js/global/global_settings.js',
        'public/lp_assets/theme_admin3/js/global/global_modal.js',
        'public/lp_assets/theme_admin3/js/global/confirmation_modal.js',
    ],
}

gulp.task('scss', function(){
    return gulp.src('resources/scss/*.scss')
        .pipe(sass()) // Converts Sass to CSS with gulp-sass
        .pipe(gulp.dest('public/lp_assets/theme_admin3/css'))
});

gulp.task('scss-datepicker', function(){
  return gulp.src('public/lp_assets/theme_admin3/external/date-picker/daterangepicker.scss')
    .pipe(sass()) // Converts Sass to CSS with gulp-sass
    .pipe(gulp.dest('public/lp_assets/theme_admin3/external/date-picker'))
});

gulp.task('external_styles', function(){
    return gulp.src(config.external_styles)
        .pipe(concat('external-style.min.css'))
        .pipe(csso())
        .pipe(gulp.dest('public/lp_assets/theme_admin3/css'));
});

gulp.task('pages_style', function(){
    return gulp.src(config.pages_style)
        .pipe(concat('app.min.css'))
        .pipe(csso())
        .pipe(gulp.dest('public/lp_assets/theme_admin3/css'));
});

gulp.task('global_script', function(){
    return gulp.src(config.global_script)
        .pipe(concat('global.min.js'))
        .pipe(gulp.dest('public/lp_assets/theme_admin3/js'));
});

gulp.task('external_scripts', function(){
    return gulp.src(config.external_scripts)
        .pipe(concat('external-script.min.js'))
        .pipe(gulp.dest('public/lp_assets/theme_admin3/js'));
});

gulp.task('funnel_builder_scripts', function(){
    return gulp.src(config.funnel_builder_scripts)
        .pipe(concat('funnel-builder-scripts.min.js'))
        .pipe(gulp.dest('public/lp_assets/theme_admin3/js'));
});


// Task to Pre-compile handlebars files into JS files
gulp.task('handlebars', function () {
    return gulp.src('resources/handlebars/theme_admin3/**/*.hbs')
        .pipe(handlebars())
        .pipe(wrap('Handlebars.template(<%= contents %>)'))
        .pipe(declare({
            namespace: 'FunnelBuilder.templates',
            noRedeclare: true, // Avoid duplicate declarations
        }))
        .pipe(concat('templates.js'))
        .pipe(gulp.dest('public/lp_assets/theme_admin3/js/funnel/handlebar'));
});

// Task to Pre-compile handlebars files into JS files for (HTML Version)
gulp.task('handlebars-html', function () {
    return gulp.src('public/html/assets/handlebars/*.hbs')
        .pipe(handlebars())
        .pipe(wrap('Handlebars.template(<%= contents %>)'))
        .pipe(declare({
            namespace: 'FunnelBuilder.templates',
            noRedeclare: true, // Avoid duplicate declarations
        }))
        .pipe(concat('templates.js'))   // to compile all hbs into single file. Comment this create separate file for each hbs
        .pipe(gulp.dest('public/html/assets/handlebars'));
});

gulp.task('watch', function(){
    gulp.task('build')()
    gulp.watch('resources/scss/**/*', gulp.series('scss', 'pages_style'));
    gulp.watch('public/lp_assets/theme_admin3/external/date-picker/daterangepicker.scss', gulp.series('scss-datepicker'));
    gulp.watch(config.external_styles, gulp.series('external_styles'));


    gulp.watch(config.global_script, gulp.series('global_script'));
    gulp.watch(config.external_scripts, gulp.series('external_scripts'));
    gulp.watch(config.funnel_builder_scripts, gulp.series('funnel_builder_scripts'));

    gulp.watch('resources/handlebars/theme_admin3/**/*.hbs', gulp.series('handlebars'));
    gulp.watch('public/html/assets/handlebars/*.hbs', gulp.series('handlebars-html'));
});

gulp.task('build-html', gulp.series('handlebars-html', 'scss'));
gulp.task('build', gulp.series('scss', 'scss-datepicker', 'external_styles', 'pages_style', 'global_script', 'external_scripts', 'handlebars', 'funnel_builder_scripts'));
