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
const rename = require('gulp-rename');
var sftp = require('gulp-sftp-up4');



//WordPressテーマの変換
function convert_wp_theme() {
  const in_dir = './wp-theme/';
  const out_dir = './Dist/wp-theme/';
  return mergeStream(
      // in style css
      gulp.src(in_dir+'/style/**/*.scss', {sourcemaps: true})
          .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
          .pipe(sass())
          .pipe(autoprefixer({grid:'autoplace'}))
          .pipe(cssmin())
          .pipe(gulp.dest(out_dir+'style')),
      // in root css
      gulp.src(in_dir+'style.css', {sourcemaps: true})
          .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
          .pipe(sass())
          .pipe(autoprefixer({grid:'autoplace'}))
          .pipe(gulp.dest(out_dir)),
      //js
      gulp.src(in_dir+'/js/**/*.js')
          .pipe(jshint())
          //.pipe(uglify())
          .pipe(gulp.dest(out_dir+'js')),
      // images
      gulp.src(in_dir+'/images/**/*')
          .pipe(imagemin())
          .pipe(gulp.dest(out_dir+'images')),
      //root php
      gulp.src(in_dir+'*.php')
        .pipe(gulp.dest(out_dir)),
      //mpa parts
      gulp.src(in_dir+'/mpa/*.php')
        .pipe(gulp.dest(out_dir+'/mpa'))
  );
}

//ar_scan_appの変換
function convert_ar_scan_app() {
  const in_dir = './ar_scan_app/';
  const out_dir = './Dist/ar/';
  return mergeStream(
      // style
      gulp.src(in_dir+'/style/**/*.scss', {sourcemaps: true})
          .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
          .pipe(sass())
          .pipe(autoprefixer({grid:'autoplace'}))
          .pipe(cssmin())
          .pipe(gulp.dest(out_dir+'style')),
      //js
      gulp.src(in_dir+'/js/**/*.js')
          .pipe(jshint())
          //.pipe(uglify())
          .pipe(gulp.dest(out_dir+'js')),
      // assets
      gulp.src(in_dir+'/assets/**/*')
          .pipe(gulp.dest(out_dir+'assets')),
      //root php
      gulp.src(in_dir+'*.php')
        .pipe(gulp.dest(out_dir)),
      //ui parts
      gulp.src(in_dir+'/ui_parts/*.php')
        .pipe(gulp.dest(out_dir+'/ui_parts'))
  );
}

//upload_wp_theme
function upload_wp_theme(){
  const options = {
    host: 'www6.conoha.ne.jp',
    port: 8022,
    user: 'c0704253',
    remotePlatform: 'unix',
    remotePath: '/home/c0704253/public_html/step.nextlav.xyz/wp-content/themes/match_plate',
    key:'/Users/lavp/.ssh/key-2019-12-13-14-19.pem'
  };
  return mergeStream(
    gulp.src('./Dist/wp-theme/**/*')
      .pipe(sftp(options))
    );
};

//upload_ar_scan_app
function upload_ar_scan_app(){
  const options = {
    host: 'www6.conoha.ne.jp',
    port: 8022,
    user: 'c0704253',
    remotePlatform: 'unix',
    remotePath: '/home/c0704253/public_html/step.nextlav.xyz/ar',
    key:'/Users/lavp/.ssh/key-2019-12-13-14-19.pem'
  };
  return mergeStream(
    gulp.src('./Dist/ar/**/*')
    .pipe(sftp(options))
  );
}


function watch() {
  //変換処理
  gulp.watch('./wp-theme/**/*',convert_wp_theme);
  gulp.watch('./ar_scan_app//**/*',convert_ar_scan_app);
  //アップロード
  gulp.watch('./Dist/wp-theme/**/*',upload_wp_theme);
  gulp.watch('./Dist/ar/**/*',upload_ar_scan_app);
}

exports.default = gulp.series(convert_wp_theme,convert_ar_scan_app,upload_wp_theme,upload_ar_scan_app,watch);
//exports.default = gulp.series(upload_wp_theme,upload_ar_scan_app);

