var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

var handlebars = require('gulp-handlebars');
var wrap = require('gulp-wrap');
var declare = require('gulp-declare');

var rename = require('gulp-rename');

// Task to Compile SCSS files into CSS files
gulp.task('sass', function(){
    return gulp.src('./src/scss/app.scss')
        .pipe(sass()) // Converts Sass to CSS with gulp-sass
        .pipe(gulp.dest('assets/css'))
});

// Task to Pre-compile handlebars files into JS files
gulp.task('handlebars', function () {
    return gulp.src('./assets/handlebars/*.hbs')
        .pipe(handlebars())
        .pipe(wrap('Handlebars.template(<%= contents %>)'))
        .pipe(declare({
            namespace: 'FunnelBuilder.templates',
            noRedeclare: true, // Avoid duplicate declarations
        }))
        .pipe(concat('templates.js'))   // to compile all hbs into single file. Comment this create separate file for each hbs
        .pipe(gulp.dest('./assets/handlebars'));
});


// Task to compile into HTML from Handlebars
/*
gulp.task('handlebars-html', function () {
    return gulp.src('./assets/templates/preview.hbs')
        .pipe(rename('preview.html'))
        .pipe(gulp.dest('assets/templates'));
});
*/


gulp.task('watch', function(){
    gulp.watch('./src/scss/**/*', gulp.series('sass'));
    gulp.watch('./assets/handlebars/*.hbs', gulp.series('handlebars'));
});
