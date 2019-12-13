const gulp = require('gulp');
const sass = require('gulp-sass');
const sassGlob = require('gulp-sass-glob');
const cssmin = require('gulp-cssmin');
const plumber = require('gulp-plumber');
const notify = require("gulp-notify");
const concat = require('gulp-concat');
const autoprefixer = require('gulp-autoprefixer');
// const gih = require("gulp-include-html");
const imagemin = require('gulp-imagemin');
const mergeStream = require('merge-stream');
const jshint = require('gulp-jshint');
const uglify = require('gulp-uglify');
const browserSync = require('browser-sync').create();
const FtpDeploy = require('ftp-deploy');
const rename = require('gulp-rename');
const ftpDeploy = new FtpDeploy();


// ルート直下のphp
function php() {
  return gulp
      .src('./src/*.php')
      .pipe(gulp.dest('./build/themes/atea_company/'));
}
// ルート直下のstyle.css
function stylecss() {
  return gulp
      .src(['./src/style.css'], {sourcemaps: true})
      .pipe(autoprefixer({grid:'autoplace'}))
      .pipe(gulp.dest('./build/themes/atea_company/'));
}

//WordPressテーマの変換
function global_resources() {
  const in_dir = './wp-theme/';
  const out_dir = './build/themes/atea_company/';
  return mergeStream(
      // css
      gulp.src(in_dir+'/style/**/*.scss', {sourcemaps: true})
          .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
          .pipe(sass())
          .pipe(autoprefixer({grid:'autoplace'}))
          .pipe(cssmin())
          .pipe(gulp.dest(out_dir+'style')),
      //js
      gulp.src(in_dir+'/js/**/*.js')
          .pipe(jshint())
          .pipe(uglify())
          .pipe(gulp.dest(out_dir+'script')),
      // images
      gulp.src(in_dir+'/images/**/*')
          .pipe(imagemin())
          .pipe(gulp.dest(out_dir+'images'))
  );
}

//PHP_BLOCKS
function php_blocks() {
  const in_dir = './src/php_blocks/';
  const out_dir = './build/themes/atea_company/php_blocks/';
  return mergeStream(
      //php
      gulp.src(in_dir+'*.php')
          .pipe(gulp.dest(out_dir)),
      // css
      gulp.src(in_dir+'style/**/*.scss', {sourcemaps: true})
          .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
          .pipe(sass())
          .pipe(autoprefixer({grid:'autoplace'}))
          .pipe(cssmin())
          .pipe(gulp.dest(out_dir+'style/'))
  );
}

//各投稿タイプの関連ファイルのまとまり
function post_type_folder() {
  const in_dir = './src/*_post_type/';
  const out_dir = './build/themes/atea_company/';
  return mergeStream(
      // css
      gulp.src(in_dir+'*.scss', {sourcemaps: true})
          .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
          .pipe(sass())
          .pipe(autoprefixer({grid:'autoplace'}))
          .pipe(cssmin())
          .pipe(rename(function(path){
            path.dirname -= 'post_type';
          }))
          .pipe(gulp.dest(out_dir+'style/')),
      //js
      gulp.src(in_dir+'*.js')
          .pipe(jshint())
          .pipe(uglify())
          .pipe(rename(function(path){
            path.dirname -= 'post_type';
          }))
          .pipe(gulp.dest(out_dir+'script/')),
      // images
      gulp.src(in_dir+'images/**/*')
          .pipe(imagemin())
          .pipe(rename(function(path){
            path.dirname -= 'post_type';
          }))
          .pipe(gulp.dest(out_dir+'images/')),
      //php
      gulp.src(in_dir+'*.php')
      .pipe(rename(function(path){
        path.dirname -= 'post_type';
      }))
          .pipe(gulp.dest(out_dir))
  );
}

// browserSync 未使用
const browserSyncOption = {
  port: 8080,
  server: {
    baseDir: './build/themes/atea_company/'
    // index: 'index.html',
  },
  reloadOnRestart: true,
};
function browsersync(done) {
  browserSync.init(browserSyncOption);
  done();
}

// ftp
function ftp(done) {
  var config = {
    user: 'ae153ulm6t_trunk',
    password: "r3GJ2g_25J",
    host: "150.60.157.168",
    port: 21,
    localRoot: "./build/themes/atea_company/",
    remoteRoot: '/html/atea/wp-content/themes/atea_dev_a',
    include: ['*', '**/*'],
    deleteRemote: true
  };
  ftpDeploy.deploy(config, function(err) {
    if(err) console.log(err);
    else console.log('finished');
  });
  done();
}


function watch() {
  //新しいの
  gulp.watch('./src/*_post_type/**/*',post_type_folder);
  gulp.watch('./src/php_blocks/**/*', php_blocks);
  gulp.watch('./src/global_resources/**/*', global_resources);
  gulp.watch('./src/**/*.php', php)
  gulp.watch('./src/style.css', stylecss);

  gulp.watch('./build/themes/atea_company/**/*',ftp);
}

exports.default = gulp.series(php,stylecss,global_resources,php_blocks,post_type_folder,ftp,watch);

