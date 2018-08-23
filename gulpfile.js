/*jslint node:true*/    // For node.js turn off jslint used before it was defined warnings
'use strict';
var gulp = require('gulp');
var readme = require('gulp-readme-to-markdown');

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

gulp.task('default', ['readme']);
