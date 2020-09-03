/**
* Gulp file for ppv-addons
*/
'use strict';
var gulp = require('gulp'),
    readme = require('gulp-readme-to-markdown'),
    sass = require('gulp-sass'),
    cleanCSS = require('gulp-clean-css'),
    rename = require('gulp-rename'),
    changed = require('gulp-changed'),
    zip = require('gulp-zip'),
    pkg = require('./package.json'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync').create();

var pluginName = pkg.name;  // Set plugin name from pacakge.json name
var packageFolder = 'dist';  // Folder to put Zip file in
// The following must be changed to match the local WordPress setup
var projectURL = 'wpsite/';  // Set local URL if using Browser-Sync
var WPpluginFolder = '../wpsite/wp-content/plugins/';  // Relative path from source to WordPress plugins
var pluginFolder = WPpluginFolder + pluginName;

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
    cssAdminDestination: pluginFolder + '/admin/css',
    cssPublicDestination: pluginFolder + '/public/css'
};

var watchPHPFiles =  [
    '**/*.php',
    '!node_modules/**/*'
];

var copyFiles =  [
    './**',
    '!node_modules/**',
    '!dist/**',
    '!*/scss/**',
    '!.git/**',
    '!.browserslistrc',
    '!.eslintrc.js',
    '!.gitignore',
    '!gulpfile.js',
    '!package.json',
    '!package-lock.json'
];

var zipFiles =  WPpluginFolder + pluginName + "/**";

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
* Build admin styles
*/
gulp.task('adminstyles', function () {
    return gulp.src(SOURCEPATHS.sassAdminSource)
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(gulp.dest(DESTINATIONPATHS.cssAdminDestination))
        .pipe(browserSync.stream()) // Reloads css if enqueued
        .pipe(cleanCSS({compatibility: 'ie9'}))
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest(DESTINATIONPATHS.cssAdminDestination))
        .pipe(browserSync.stream()); // Reloads min.css if enqueued
});

/**
* Copy non-processed files if changed
*/
gulp.task('copy-files', function() {
    return gulp.src(copyFiles)
        .pipe(changed(pluginFolder))
        .pipe(gulp.dest(pluginFolder));
});

/**
* Package the plugin in a ZIP file
* Base option of gulp.src is one level above plugin folder
*     so the packaged zip has the folder name inside the zip
*/
gulp.task('package', function (done) {
    gulp.src(zipFiles, {base: WPpluginFolder})
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
    gulp.watch(SOURCEPATHS.sassAdminSource, gulp.parallel('adminstyles'));
});

/**
* Watch files for changes (without Browser-Sync)
*/
gulp.task('watch', function () {
    gulp.watch(SOURCEPATHS.sassPublicSource, gulp.parallel('publicstyles')); // Watch SCSS files
    gulp.watch(SOURCEPATHS.sassAdminSource, gulp.parallel('adminstyles'));
    gulp.watch('README.txt', gulp.parallel('readme')); // Watch readme.txt file
});

/**
* Runs tasks without watch or Browser-Sync
*/
gulp.task('default', gulp.series('readme', gulp.parallel('publicstyles', 'adminstyles', 'copy-files')));


/**
* Creates zip file to install or upload to production site
*/
gulp.task('build', gulp.series('default', 'package'));
