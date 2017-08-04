//
//––––––––––––––––––––––––––––––––––––––––––––––––––
//  GULP BUILD
//––––––––––––––––––––––––––––––––––––––––––––––––––
//
var gulp = require('gulp');

// CSS.
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

// JS.
var uglify = require('gulp-uglify');

// Shared.
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');
var livereload = require('gulp-livereload');



gulp.task('admin-styles', function () {
  gulp.src('css/scss/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(sourcemaps.write({includeContent: false}))
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(autoprefixer({
      browsers: [
        'last 5 version', 
        '> 50%',
        'Firefox < 20',
        'ie 9-11'
      ],
      remove: false
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('css/'))
    .pipe(livereload());
});


// gulp.task('scripts', function() {
//   gulp.src('./js/main.js')
//     .pipe(sourcemaps.init())
//     .pipe(rename('main.min.js'))
//     .pipe(uglify())
//     .pipe(sourcemaps.write('./'))
//     .pipe(gulp.dest('./js'))
//     .pipe(livereload());
// });


gulp.task('watch', ['admin-styles'], function () {
  livereload.listen();
  gulp.watch('css/scss/**/*.scss', ['admin-styles']);
  // gulp.watch('./js/main.js', ['scripts']);
});


gulp.task('default', ['watch']);