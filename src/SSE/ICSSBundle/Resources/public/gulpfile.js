var gulp          = require('gulp'),
    stylus        = require('gulp-stylus'),
    autoprefixer  = require('gulp-autoprefixer'),
    plumber       = require('gulp-plumber'),
    watch         = require('gulp-watch'),
    minifyCss     = require('gulp-minify-css');

gulp.task('default', function () {
  return gulp
    .src('css/*.styl')
    .pipe(plumber())
    .pipe(stylus())
    .pipe(autoprefixer())
    .pipe(minifyCss({compatibility: 'ie8'}))
    .pipe(gulp.dest('./css/'));
});

gulp.task('watch', function () {
  return watch('css/**/*.styl', function (file) {
    console.log('Changed: %s', file.path);
    gulp.start('default');
  });
})