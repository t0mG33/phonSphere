const gulp = require('gulp');
const concat = require('gulp-concat');
const cleanCss = require('gulp-clean-css');

function compileSass() {
    return gulp.src('scss/**/[^_]*.?(s)css') // Path to your SCSS files
      .pipe(concat('main.min.css'))
    //   .pipe(sass().on('error', sass.logError))
      .pipe(cleanCss())
      .pipe(gulp.dest('css')); // Output directory for CSS files
  }gulp.task('sass', compileSass);

  function watchSass() {
    gulp.watch('src/scss/**/[^_]*.?(s)css', compileSass);
  }gulp.task('watch', watchSass);