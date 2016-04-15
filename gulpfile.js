'use strict';

var version = require('./package.json').version;
var config = {
    source: './wordpress_themes/tuba',
//    output: './dist',
    output: '/Applications/MAMP/htdocs/tuba/wp-content/themes/tuba',
    less: ['normalize.less', 'main.less'],
    js: ['tuba.js'],
    tasks: ['init', 'images', 'css', 'js', 'favicon', 'html']
};
var base64 = require('gulp-base64');
var clean = require('gulp-clean');
var concat = require('gulp-concat');
var gulp = require('gulp');
var handlebars = require('gulp-compile-handlebars');
var jshint = require('gulp-jshint');
var jsonlint = require("gulp-jsonlint");
var less = require('gulp-less');
var minifyCSS = require('gulp-clean-css');
var minifyHTML = require('gulp-htmlmin');
var nodemon = require('gulp-nodemon');
var path = require('path');
var sprite = require('gulp.spritesmith');
var uglify = require('gulp-uglify');

// Dependent tasks will be executed before others
gulp.task('init', [], function (done) {
    return done;
});

gulp.task('jshint', function () {
    return gulp.src(config.js)
    .pipe(jshint())
    .pipe(jshint.reporter('default', { verbose: true }));
});

gulp.task('css', function() {
    var filename = 'style.css';
    var appendPath = function (files) {
        var prefix = config.source + '/less/';
        var result = [];
        var i;
        for (i = 0; i < files.length; i += 1) {
            result.push(prefix + files[i]);
        }
        return result;
    };
    var lessFiles = appendPath(config.less);
    var opts = {
        keepBreaks: false,
        compatibility: 'ie8',
        keepSpecialComments: 0
    };
    return gulp.src(lessFiles)
    .pipe(less({
      paths: [ path.join(__dirname, 'less', 'includes') ]
    }))
    .pipe(concat(filename))
    .pipe(base64({
        extensions: ['png']
    }))
    .pipe(minifyCSS(opts))
    .pipe(gulp.dest(config.output));
});

gulp.task('js', function () {
    return gulp.src(config.source + '/*.js')
    .pipe(uglify({mangle: true}))
    .pipe(gulp.dest(config.output));
});

gulp.task('images', function() {
/*
    var spriteData = gulp.src(config.source + '/images/*.png')
        .pipe(sprite({
            imgName: 'sprite.png',
            cssName: 'sprite.css',
        }));
    spriteData.img.pipe(gulp.dest(config.output + '/images/'));
    spriteData.css.pipe(gulp.dest(config.output));
    return;
*/
    return gulp.src(config.source + '/less/images/**/*')
    .pipe(gulp.dest(config.output + '/images'));

});

gulp.task('favicon', function() {
    return gulp.src(config.source + '/favicon.ico')
    .pipe(gulp.dest(config.output));
});

gulp.task('html', function () {
    var options = {
        ignorePartials: true,
        batch : [config.source + '/partials']
    };
    var optsHtml = {
        collapseWhitespace: true,
        keepClosingSlash: true
    };
    return gulp.src(config.source + '/*.php')
    .pipe(handlebars({}, options))
    .pipe(minifyHTML(optsHtml))
    .pipe(gulp.dest(config.output));
});

gulp.task('build', config.tasks);