const gulp = require('gulp');
const sass = require('gulp-sass');
const sassGlob = require('gulp-sass-glob');
const cssmin = require('gulp-cssmin');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');
const concat = require('gulp-concat');
const autoprefixer = require('gulp-autoprefixer');
// const gih = require("gulp-include-html");
const imagemin = require('gulp-imagemin');
const mergeStream = require('merge-stream');
const jshint = require('gulp-jshint');
const uglify = require('gulp-uglify');
const babel = require('gulp-babel');
const browserSync = require('browser-sync').create();
const rename = require('gulp-rename');
const sftp = require('gulp-sftp-up4');
const sourcemaps = require('gulp-sourcemaps');
const changed = require('gulp-changed');

//WordPressテーマの変換
function convert_wp_theme() {
	const in_dir = './wp-theme/';
  const out_dir = './Dist/wp-theme/';
  const options = (dist_path = '') => {
		return {
      host: 'www6.conoha.ne.jp',
      port: 8022,
      user: 'c0704253',
      remotePlatform: 'unix',
      remotePath: '/home/c0704253/public_html/step.nextlav.xyz/wp-content/themes/match_plate/'+dist_path,
      key: '/Users/lavp/.ssh/key-2019-12-13-14-19.pem'
    }
  }
	return mergeStream(
		// in style css
		gulp
      .src(in_dir + '/style/**/*.scss')
      .pipe(changed(out_dir + 'style'))
			.pipe(sourcemaps.init())
			.pipe(
				plumber({ errorHandler: notify.onError('Error: <%= error.message %>') })
			)
			.pipe(sass())
			.pipe(autoprefixer({ grid: 'autoplace' }))
      .pipe(cssmin())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(out_dir + 'style'))
      .pipe(options('style')),
		// in root css
		gulp
      .src(in_dir + 'style.css')
      .pipe(changed(out_dir))
      .pipe(sourcemaps.init())
			.pipe(
				plumber({ errorHandler: notify.onError('Error: <%= error.message %>') })
			)
			.pipe(sass())
      .pipe(autoprefixer({ grid: 'autoplace' }))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(out_dir))
      .pipe(options('')),
		//js
		gulp
      .src(in_dir + '/js/**/*.js')
      .pipe(changed(out_dir + 'js'))
      .pipe(sourcemaps.init())
			.pipe(jshint())
      .pipe(babel({
        "presets": ["@babel/preset-env"]
      }))
      .pipe(uglify())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(out_dir + 'js'))
      .pipe(options('js')),
		// images
		gulp
      .src(in_dir + '/images/**/*')
      .pipe(changed(out_dir + 'images'))
			.pipe(imagemin())
      .pipe(gulp.dest(out_dir + 'images'))
      .pipe(options('images')),
		//root php
    gulp.src(in_dir + '*.php')
    .pipe(changed(out_dir))
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(out_dir))
    .pipe(options('')),
		//mpa parts
    gulp.src(in_dir + '/mpa/*.php')
    .pipe(changed(out_dir + '/mpa'))
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(out_dir + '/mpa'))
    .pipe(options('mpa'))
	);
}

//ar_scan_appの変換
function convert_ar_scan_app() {
	const in_dir = './ar_scan_app/';
  const out_dir = './Dist/ar/';
  const options = (dist_path = '') => {
		return {
      host: 'www6.conoha.ne.jp',
      port: 8022,
      user: 'c0704253',
      remotePlatform: 'unix',
      remotePath: '/home/c0704253/public_html/step.nextlav.xyz/ar/'+dist_path,
      key: '/Users/lavp/.ssh/key-2019-12-13-14-19.pem'
    }
	};
	return mergeStream(
		// style
		gulp
      .src(in_dir + '/style/**/*.scss')
      .pipe(changed(out_dir + 'style'))
      .pipe(sourcemaps.init())
			.pipe(
				plumber({ errorHandler: notify.onError('Error: <%= error.message %>') })
			)
			.pipe(sass())
			.pipe(autoprefixer({ grid: 'autoplace' }))
      .pipe(cssmin())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(out_dir + 'style'))
      .pipe(sftp(options('style'))),
		//js
		gulp
      .src(in_dir + '/js/**/*.js')
      .pipe(changed(out_dir + 'js'))
      .pipe(sourcemaps.init())
			.pipe(jshint())
      .pipe(babel({
        "presets": ["@babel/preset-env"]
      }))
      //.pipe(uglify())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(out_dir + 'js'))
      .pipe(sftp(options('js'))),
		// assets
    gulp.src(in_dir + '/assets/**/*')
    .pipe(changed(out_dir + 'assets'))
    .pipe(gulp.dest(out_dir + 'assets'))
    .pipe(sftp(options('assets'))),
		//root php
    gulp.src(in_dir + '*.php')
    .pipe(changed(out_dir))
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(out_dir))
    .pipe(sftp(options(''))),
		//ui parts
    gulp.src(in_dir + '/ui_parts/*.php')
    .pipe(changed(out_dir + '/ui_parts'))
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(out_dir + '/ui_parts'))
    .pipe(sftp(options('ui_parts')))
	);
}



function watch() {
	//変換処理
	gulp.watch('./wp-theme/**/*', convert_wp_theme);
	gulp.watch('./ar_scan_app/**/*', convert_ar_scan_app);
}

exports.default = gulp.series(
	convert_wp_theme,
	convert_ar_scan_app,
	watch
);
//exports.default = gulp.series(upload_wp_theme,upload_ar_scan_app);
