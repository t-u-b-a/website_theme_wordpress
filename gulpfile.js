'use strict';

var version = require('./package.json').version;
var config = {
    source: './wordpress_themes/tuba',
    output: './dist',
//    output: '/Applications/MAMP/htdocs/tuba/wp-content/themes/tuba',
    less: ['normalize.less', 'main.less'],
    js: ['tuba.js'],
    tasks: ['init', 'css', 'js', 'images', 'html']
};

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

gulp.task('images', function() {
    return gulp.src(config.source + '/images/**/*')
    .pipe(gulp.dest('./assets/images'));
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
    .pipe(minifyCSS(opts))
    .pipe(gulp.dest(config.output));
});

gulp.task('js', function () {
    var filename = 'tuba_' + version + '.js';
    var appendPath = function (files) {
        var prefix = config.source + '/js/';
        var result = [];
        var i;
        for (i = 0; i < files.length; i += 1) {
            result.push(prefix + files[i]);
        }
        return result;
    };
    var jsFiles = appendPath(config.js);
    return gulp.src(jsFiles)
    .pipe(concat(filename))
    .pipe(uglify({mangle: true}))
    .pipe(gulp.dest(config.output));
});

gulp.task('images', function() {
    return gulp.src(config.source + '/images/**/*')
    .pipe(gulp.dest(config.output + '/images'));
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