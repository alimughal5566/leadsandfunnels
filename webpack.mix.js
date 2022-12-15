const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//mix.js('resources/js/app.js', 'public/js').sass('resources/scss/app.scss', 'public/lp_assets/theme_admin3/css1');

mix.webpackConfig({
    entry: __dirname + '/resources/js/module-cogo-toast.js',
    output: {
        filename: 'cogo-toaster.js',
        path: __dirname + '/public/lp_assets/common',
        libraryTarget: 'var',
        library: 'lptoast'
    }
});