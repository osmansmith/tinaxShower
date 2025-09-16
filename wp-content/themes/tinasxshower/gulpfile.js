/**
 * Gulpfile for TinasXShower WordPress Theme
 *
 * @package TinasXShower
 */

const gulp = require('gulp');
const postcss = require('gulp-postcss');
const tailwindcss = require('tailwindcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();
const rename = require('gulp-rename');
const uglify = require('gulp-uglify');
const babel = require('gulp-babel');
const concat = require('gulp-concat');
const eslint = require('gulp-eslint');
const stylelint = require('gulp-stylelint');

// Configuration
const config = {
  // Local development URL
  proxy: 'localhost/tinasxshower',
  
  // Source paths
  src: {
    css: './assets/css/**/*.css',
    tailwind: './assets/css/tailwind.css',
    js: './assets/js/**/*.js',
  },
  
  // Destination paths
  dist: {
    css: './assets/css/',
    js: './assets/js/',
  },
};

// CSS processing
function css() {
  return gulp
    .src(config.src.tailwind)
    .pipe(sourcemaps.init())
    .pipe(postcss([
      tailwindcss('./tailwind.config.js'),
      autoprefixer(),
      cssnano(),
    ]))
    .pipe(rename({ suffix: '.min' }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.dist.css))
    .pipe(browserSync.stream());
}

// JavaScript processing
function js() {
  return gulp
    .src(config.src.js)
    .pipe(sourcemaps.init())
    .pipe(babel({
      presets: ['@babel/preset-env']
    }))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.dist.js))
    .pipe(browserSync.stream());
}

// Watch files
function watchFiles() {
  browserSync.init({
    proxy: config.proxy,
    notify: false,
  });
  
  gulp.watch(['./**/*.php']).on('change', browserSync.reload);
  gulp.watch(['./tailwind.config.js', config.src.css], css);
  gulp.watch(config.src.js, js);
}

// Lint JavaScript
function lintJS() {
  return gulp
    .src(config.src.js)
    .pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError());
}

// Lint CSS
function lintCSS() {
  return gulp
    .src(config.src.css)
    .pipe(stylelint({
      reporters: [
        { formatter: 'string', console: true }
      ]
    }));
}

// Define tasks
const lint = gulp.parallel(lintCSS, lintJS);
const build = gulp.series(lint, gulp.parallel(css, js));
const watch = gulp.series(build, watchFiles);

// Export tasks
exports.css = css;
exports.js = js;
exports.lint = lint;
exports.lintJS = lintJS;
exports.lintCSS = lintCSS;
exports.build = build;
exports.watch = watch;
exports.default = watch;