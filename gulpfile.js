var gulp = require('gulp');

/**
 * 拷贝任何需要的文件
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copy", function() {

    gulp.src("vendor/bower/bootstrapvalidator/dist/css/bootstrapValidator.css")
        .pipe(gulp.dest("public/css/"));

    gulp.src("vendor/bower/bootstrapvalidator/dist/js/bootstrapValidator.js")
        .pipe(gulp.dest("public/js"));

});
