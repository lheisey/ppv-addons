/**
* Gulp file for ppv-addons
*/
'use strict';
var gulp = require('gulp'),
    readme = require('gulp-readme-to-markdown'),
    sass = require('gulp-sass'),
    cleanCSS = require('gulp-clean-css'),
    rename = require('gulp-rename'),
    zip = require('gulp-zip'),
    pkg = require('./package.json'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync').create();

var projectURL = 'localhost/wordpress/';  // Set local URL if using Browser-Sync
var pluginName = pkg.name;                // Set plugin name from pacakge.json name
var packageFolder = '../../../../bundle'; // Put Zip file outside of Wordpress in folder bundle

var sassOptions = {
    precision: 8,
    errLogToConsole: true,
    outputStyle: 'expanded'
};

var browserSyncOptions = {
    notify: false,
    open: true,
    proxy: projectURL,
    injectChanges: true
};

var SOURCEPATHS = {
    sassAdminSource : 'admin/scss/*.scss',
    sassPublicSource : 'public/scss/*.scss'
};

var DESTINATIONPATHS = {
    cssAdminDestination: 'admin/css',
    cssPublicDestination: 'public/css'
};

var watchPHPFiles =  [
    '**/*.php',
    '!node_modules/**/*'
];

var zipFiles =  [
    '../' + pluginName + '/**',
    '!node_modules/**',
    '!.git/**',
    '!.browserslistrc',
    '!.eslintrc.js',
    '!.gitignore',
    '!gulpfile.js',
    '!package.json',
    '!package-lock.json'
];

/**
* Convert WordPress readme.txt to github readme.md
*/
gulp.task('readme', function (done) {
    gulp.src([ 'README.txt' ])
        .pipe(readme({
            details: false
        }))
        .pipe(gulp.dest('.'));
    done();
});

/**
* Build public styles
*/
gulp.task('publicstyles', function () {
    return gulp.src(SOURCEPATHS.sassPublicSource)
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(gulp.dest(DESTINATIONPATHS.cssPublicDestination))
        .pipe(browserSync.stream()) // Reloads css if enqueued
        .pipe(cleanCSS({compatibility: 'ie9'}))
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest(DESTINATIONPATHS.cssPublicDestination))
        .pipe(browserSync.stream()); // Reloads min.css if enqueued
});

/**
* Package the plugin in a ZIP file
* base option of gulp.src uses '../' to go up one level so the packaged zip has the folder name inside the zip
*/
gulp.task('package', function (done) {
    gulp.src(zipFiles, { base: "../" })
        .pipe(zip(pluginName + '.zip'))
        .pipe(gulp.dest(packageFolder));
    done();
});

/**
* Browser-Sync watch files and inject changes
*/
gulp.task('browsersync', function () {
    var files = [
        SOURCEPATHS.sassPublicSource,
        watchPHPFiles
    ];
    browserSync.init(files, browserSyncOptions);
    gulp.watch(SOURCEPATHS.sassPublicSource, gulp.parallel('publicstyles')); // Reload on SCSS file changes
});

/**
* Watch files for changes (without Browser-Sync)
*/
gulp.task('watch', function () {

    gulp.watch(SOURCEPATHS.sassPublicSource, gulp.parallel('publicstyles')); // Watch SCSS files
    gulp.watch('README.txt', gulp.parallel('readme')); // Watch readme.txt file

});

/**
* Watches for changes and runs tasks
*/
gulp.task('default', gulp.parallel('readme', 'publicstyles'));
