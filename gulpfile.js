/*jslint node:true*/    // For node.js turn off jslint used before it was defined warnings
'use strict';
var gulp = require('gulp');
var readme = require('gulp-readme-to-markdown');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');

var autoprefixerOptions = {
    browsers: [
        "Android 2.3",
        "Android >= 4",
        "Chrome >= 20",
        "Firefox >= 24",
        "Explorer >= 9",
        "iOS >= 6",
        "Opera >= 12",
        "Safari >= 6"
    ]
};

var sassOptions = {
    precision: 8,
    errLogToConsole: true,
    outputStyle: 'expanded'
};

var SOURCEPATHS = {
    sassAdminSource : 'admin/scss/*.scss',
    sassPublicSource : 'public/scss/*.scss'
};

var DESTINATIONPATHS = {
    cssAdminDestination: 'admin/css',
    cssPublicDestination: 'public/css'
};

/**
* Convert WordPress readme.txt to github readme.md
*/
gulp.task('readme', function () {
    gulp.src([ 'readme.txt' ])
        .pipe(readme({
            details: false
        }))
        .pipe(gulp.dest('.'));
});


/**
* Build public styles
*/
gulp.task('publicstyles', function () {
    return gulp.src(SOURCEPATHS.sassPublicSource)
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(sass(sassOptions).on('error', sass.logError))
        .pipe(gulp.dest(DESTINATIONPATHS.cssPublicDestination))
        .pipe(cleanCSS({compatibility: 'ie9'}))
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest(DESTINATIONPATHS.cssPublicDestination));
});

gulp.task('default', ['readme', 'publicstyles']);
