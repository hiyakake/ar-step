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
const htmlclean = require('gulp-htmlclean'); //htmlのコメントなど不要なものを削除
const browserify = require('browserify'); //JSライブラリの依存関係を解決
const source = require('vinyl-source-stream');//上のに必要


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


// HTML圧縮
function html() {
  const out = build + 'test/';

  return gulp.src(src + '**/*.html')
    .pipe(newer(out))
    .pipe(devBuild ? noop() : htmlclean())
    .pipe(gulp.dest(out));
}
exports.html = gulp.series(images, html);



/*JavaScript圧縮*/
function js_AR_SCAN_browserify(){
  browserify({
    entries: [src + 'AR_SCAN/js/ar_scan.js']
  })
  .bundle()
  .pipe(source('ar_scan.js'))
  .pipe(gulp.dest(build+'js/ar_scan.js'));
};
function js_AR_SCAN() {
    //AR_SCAN
      return gulp.src(build+'js/ar_scan.js')
      .pipe(sourcemaps ? sourcemaps.init() : noop())
      .pipe(deporder())
      .pipe(concat('ar_scan.js'))
      .pipe(stripdebug ? stripdebug() : noop())
      .pipe(terser())
      .pipe(sourcemaps ? sourcemaps.write() : noop())
      .pipe(gulp.dest(build + 'js/ar_scan.js'));
}

function js_PLATE_SITE_browserify(){
  browserify({
    entries: [src + 'PLATE_SITE/js/plate_site.js']
  })
  .bundle()
  .pipe(source('plate_site.js'))
  .pipe(gulp.dest(build+'js/plate_site.js'));
};
function js_PLATE_SITE(){
    //PLATE_SITE
    return gulp.src(build+'js/plate_site.js')
        .pipe(sourcemaps ? sourcemaps.init() : noop())
        .pipe(deporder())
        .pipe(concat('plate_site.js'))
        .pipe(stripdebug ? stripdebug() : noop())
        .pipe(terser())
        .pipe(sourcemaps ? sourcemaps.write() : noop())
        .pipe(gulp.dest(build + 'js/plate_site.js'));
}

exports.js = gulp.series(js_AR_SCAN_browserify,js_AR_SCAN,js_PLATE_SITE_browserify,js_PLATE_SITE);



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



// run all tasks
exports.build = gulp.parallel(exports.html, exports.css, exports.js);


// watch for file changes
function watch(done) {

  // image changes
  gulp.watch(src + 'images/**/*', images);
  // html changes
  gulp.watch(src + '**/*', html);
  // css changes
  gulp.watch(src + 'Scss/**/*', css);
  // js changes
  gulp.watch(src + 'js/**/*', js);

  done();

}
exports.watch = watch;

// default task
exports.default = gulp.series(exports.build, exports.watch);