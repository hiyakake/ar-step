 // development mode?
const devBuild = (process.env.NODE_ENV !== 'production');
 
 // modulesの読み込み
const gulp = require('gulp');
const sass = require('gulp-sass');
const noop = require('gulp-noop');//DevModeだったら何もしないなどを実現
const newer = require('gulp-newer');//新しいファイルのみビルドする
const imagemin = require('gulp-imagemin');//画像圧縮
const concat = require('gulp-concat');//全てのJSを一つのファイルにまとめる
const deporder = require('gulp-deporder');//依存関係が先にロードされるようにする
const terser = require('gulp-terser');//コードの最小化
const stripdebug = devBuild ? null : require('gulp-strip-debug');//console.logなどを削除
const sourcemaps = devBuild ? require('gulp-sourcemaps') : null; //ソースマップを生成
const postcss = require('gulp-postcss');
const assets = require('postcss-assets');//CSS内のファイルパスの解決やインラインイメージ化
const autoprefixer = require('autoprefixer');
const mqpacker = require('css-mqpacker');//メディアクエリをひとまとまりに
const cssnano = require('cssnano');//CSSの圧縮

// folders
const src = 'Code/',
build = 'Build/wp-content/themes/AR_STEP/';

/*画像圧縮*/
function images() {

    const out = build + 'images/';
  
    return gulp
        .src(src + 'PLATE_SITE/images/**/*')
        .pipe(gulp.src(src + 'AR_SCAN/images/**/*'))
        .pipe(newer(out))
        .pipe(imagemin({ optimizationLevel: 5 }))
        .pipe(gulp.dest(out));
  
  };
  exports.images = images;


/*JavaScript圧縮*/
function js_AR_SCAN() {
    //AR_SCAN
    return gulp.src(src + 'AR_SCAN/js/**/*')
      .pipe(sourcemaps ? sourcemaps.init() : noop())
      .pipe(deporder())
      .pipe(concat('ar_step.js'))
      .pipe(stripdebug ? stripdebug() : noop())
      .pipe(terser())
      .pipe(sourcemaps ? sourcemaps.write() : noop())
      .pipe(gulp.dest(build + 'js/'))
}
function js_PLATE_SITE(){
    //PLATE_SITE
    return gulp.src(src + 'PLATE_SITE/js/**/*')
        .pipe(sourcemaps ? sourcemaps.init() : noop())
        .pipe(deporder())
        .pipe(concat('plate_site.js'))
        .pipe(stripdebug ? stripdebug() : noop())
        .pipe(terser())
        .pipe(sourcemaps ? sourcemaps.write() : noop())
        .pipe(gulp.dest(build + 'js/'));
}
exports.js = gulp.series(js_AR_SCAN,js_PLATE_SITE);


/*CSS圧縮*/
function css_AR_STEP() {

    return gulp.src(src + 'AR_STEP/scss/**/*')
      .pipe(sourcemaps ? sourcemaps.init() : noop())
      .pipe(sass({
        outputStyle: 'nested',
        imagePath: '/images/',
        precision: 3,
        errLogToConsole: true
      }).on('error', sass.logError))
      .pipe(postcss([
        assets({ loadPaths: ['images/'] }),
        autoprefixer({ 
            browsers: ['last 2 versions', '> 2%'] ,
            grid: "autoplace"
        }),
        mqpacker,
        cssnano
      ]))
      .pipe(sourcemaps ? sourcemaps.write() : noop())
      .pipe(gulp.dest(build + 'style/'));
  }
  function css_PLATE_SITE() {

    return gulp.src(src + 'PLATE_SITE/scss/**/*')
      .pipe(sourcemaps ? sourcemaps.init() : noop())
      .pipe(sass({
        outputStyle: 'nested',
        imagePath: '/images/',
        precision: 3,
        errLogToConsole: true
      }).on('error', sass.logError))
      .pipe(postcss([
        assets({ loadPaths: ['images/'] }),
        autoprefixer({ 
            browsers: ['last 2 versions', '> 2%'] ,
            grid: "autoplace"
        }),
        mqpacker,
        cssnano
      ]))
      .pipe(sourcemaps ? sourcemaps.write() : noop())
      .pipe(gulp.dest(build + 'style/'));
  }
  exports.css = gulp.series(images, css_AR_STEP , css_PLATE_SITE);