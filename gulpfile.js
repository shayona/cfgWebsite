let gulp = require('gulp');
var del = require('del');
var runSequence = require('run-sequence');
let concat = require('gulp-concat');
let cleanCSS = require('gulp-clean-css');
let gcmq = require('gulp-group-css-media-queries');
let uglify = require('gulp-terser');

gulp.task('css', function() {
  return gulp.src('src/css/*.css')
    .pipe(concat('styles.css'))
    .pipe(cleanCSS())
    .pipe(gcmq())
    .pipe(cleanCSS())
    .pipe(gulp.dest('public/dist'))
});

gulp.task("js", function() {
  return gulp.src('src/js/*.js')
    .pipe(concat('script.js'))
    .pipe(uglify())
    .pipe(gulp.dest('public/dist'));
});

gulp.task('default', function() {
  del(['public/dist']);
  runSequence('css', 'js');
});

gulp.task('watch', function() {
  gulp.watch('src/css/*.css', ['css']);
  gulp.watch('src/js/*.js', ['js']);
});