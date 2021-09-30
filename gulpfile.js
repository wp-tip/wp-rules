const gulp = require('gulp');
const sass = require('gulp-sass');
const del = require('del');
const watch = require('gulp-watch');

gulp.task('styles', () => {
    return gulp.src('assets/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('clean', () => {
    return del([
        'assets/css/main.css',
    ]);
});

gulp.task('watch', () => {
    return watch('assets/scss/**/*.scss', gulp.series(['clean', 'styles']));
});

gulp.task('default', gulp.series(['clean', 'styles']));
