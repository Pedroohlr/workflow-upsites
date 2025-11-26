const { src, dest, watch, series, parallel } = require('gulp');
const $ = require('gulp-load-plugins')();
const browserSync = require('browser-sync').create();
const webpack = require('webpack');
const webpackConfig = require('./webpack.config.js');
const sass = require('sass');
const gulpSass = require('gulp-sass')(sass);
const autoprefixer = require('gulp-autoprefixer');
const changed = require('gulp-changed');
const path = require('path');
const fs = require('fs');

// Função para obter lista de páginas
function getPageFiles() {
  const pagesDir = './src/sass/';
  const mobileDir = './src/sass/mobile';
  const pageFiles = [];
  const mobilePageFiles = [];

  // Lista arquivos desktop em src/sass/ (ignora arquivos que começam com _, main.scss e main-mobile.scss)
  if (fs.existsSync(pagesDir)) {
    const files = fs.readdirSync(pagesDir);
    files.forEach((file) => {
      if (file.endsWith('.scss') && !file.startsWith('_') && file !== 'main.scss' && file !== 'main-mobile.scss') {
        const filePath = path.join(pagesDir, file);
        // Verifica se é arquivo (não diretório)
        if (fs.statSync(filePath).isFile()) {
          pageFiles.push(filePath);
        }
      }
    });
  }

  // Lista arquivos mobile em src/sass/mobile (ignora arquivos que começam com _)
  if (fs.existsSync(mobileDir)) {
    const files = fs.readdirSync(mobileDir);
    files.forEach((file) => {
      if (file.endsWith('.scss') && !file.startsWith('_')) {
        const filePath = path.join(mobileDir, file);
        // Verifica se é arquivo (não diretório)
        if (fs.statSync(filePath).isFile()) {
          mobilePageFiles.push(filePath);
        }
      }
    });
  }

  return { pageFiles, mobilePageFiles };
}

// Função para obter nome da página do arquivo
function getPageName(filePath, isMobile = false) {
  const basename = path.basename(filePath, '.scss');
  return isMobile ? `${basename}-mobile` : basename;
}

// Tasks dinâmicas para compilação de páginas
const { pageFiles, mobilePageFiles } = getPageFiles();
const allPageTasks = [];
const allPageReleaseTasks = [];

// Cria tasks para páginas desktop
pageFiles.forEach((file) => {
  const pageName = getPageName(file);

  const compileTask = function () {
    return src(file)
      .pipe($.plumber())
      .pipe($.sourcemaps.init())
      .pipe(
        gulpSass({
          includePaths: ['./node_modules/'],
          outputStyle: 'expanded',
        }).on('error', gulpSass.logError)
      )
      .pipe($.rename(`${pageName}.css`))
      .pipe($.sourcemaps.write())
      .pipe(dest('./assets/css/'))
      .pipe(browserSync.stream());
  };

  allPageTasks.push(compileTask);

  // Task de release
  const releaseTask = function () {
    return src(`./assets/css/${pageName}.css`, { allowEmpty: true })
      .pipe(autoprefixer())
      .pipe($.rename({ suffix: '.min' }))
      .pipe($.cleanCss())
      .pipe(dest('./assets/css/'));
  };

  allPageReleaseTasks.push(releaseTask);
});

// Cria tasks para páginas mobile
mobilePageFiles.forEach((file) => {
  const pageName = getPageName(file, true);

  const compileTask = function () {
    return src(file)
      .pipe($.plumber())
      .pipe($.sourcemaps.init())
      .pipe(
        gulpSass({
          includePaths: ['./node_modules/'],
          outputStyle: 'expanded',
        }).on('error', gulpSass.logError)
      )
      .pipe($.rename(`${pageName}.css`))
      .pipe($.sourcemaps.write())
      .pipe(dest('./assets/css/'))
      .pipe(browserSync.stream());
  };

  allPageTasks.push(compileTask);

  // Task de release
  const releaseTask = function () {
    return src(`./assets/css/${pageName}.css`, { allowEmpty: true })
      .pipe(autoprefixer())
      .pipe($.rename({ suffix: '.min' }))
      .pipe($.cleanCss())
      .pipe(dest('./assets/css/'));
  };

  allPageReleaseTasks.push(releaseTask);
});

/**
 * Icons
 */
function svgicons() {
  return src('./src/img/icons/*.svg', { allowEmpty: true })
    .pipe(
      $.svgmin((file) => {
        const prefix = path.basename(file.relative, path.extname(file.relative));
        return {
          plugins: [
            {
              name: 'removeAttrs',
              params: { attrs: 'fill' }
            },
            {
              name: 'cleanupIDs',
              params: {
                prefix: prefix + '-',
                minify: true,
              }
            }
          ],
        };
      })
    )
    .pipe($.svgstore())
    .pipe(dest('./assets/img/'));
}

/**
 * SVG Optimization
 */
function svgoptimize() {
  return src('./src/img/svg/*.svg', { allowEmpty: true })
    .pipe(changed('./assets/img/'))
    .pipe($.svgmin())
    .pipe(dest('./assets/img/'));
}

/**
 * Sass Compilation - Desktop
 */
function sassMain() {
  return src('./src/sass/main.scss')
    .pipe($.plumber())
    .pipe($.sourcemaps.init())
    .pipe(
      gulpSass({
        includePaths: ['./node_modules/'],
        outputStyle: 'expanded',
      }).on('error', gulpSass.logError)
    )
    .pipe($.sourcemaps.write())
    .pipe(dest('./assets/css/'))
    .pipe(browserSync.stream());
}

/**
 * Sass Compilation - Mobile
 */
function sassMainMobile() {
  return src('./src/sass/main-mobile.scss')
    .pipe($.plumber())
    .pipe($.sourcemaps.init())
    .pipe(
      gulpSass({
        includePaths: ['./node_modules/'],
        outputStyle: 'expanded',
      }).on('error', gulpSass.logError)
    )
    .pipe($.sourcemaps.write())
    .pipe(dest('./assets/css/'))
    .pipe(browserSync.stream());
}

/**
 * Sass Compilation - Home Desktop
 */
function sassHome() {
  return src('./src/sass/pages/_home.scss')
    .pipe($.plumber())
    .pipe($.sourcemaps.init())
    .pipe(
      gulpSass({
        includePaths: ['./node_modules/'],
        outputStyle: 'expanded',
      }).on('error', gulpSass.logError)
    )
    .pipe($.rename('home.css'))
    .pipe($.sourcemaps.write())
    .pipe(dest('./assets/css/'))
    .pipe(browserSync.stream());
}

/**
 * Sass Compilation - Home Mobile
 */
function sassHomeMobile() {
  return src('./src/sass/pages/mobile/_home.scss')
    .pipe($.plumber())
    .pipe($.sourcemaps.init())
    .pipe(
      gulpSass({
        includePaths: ['./node_modules/'],
        outputStyle: 'expanded',
      }).on('error', gulpSass.logError)
    )
    .pipe($.rename('home-mobile.css'))
    .pipe($.sourcemaps.write())
    .pipe(dest('./assets/css/'))
    .pipe(browserSync.stream());
}

/**
 * Sass Release - Main Desktop (minified)
 */
function sassMainRelease() {
  return src('./assets/css/main.css')
    .pipe(autoprefixer())
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.cleanCss())
    .pipe(dest('./assets/css/'));
}

/**
 * Sass Release - Main Mobile (minified)
 */
function sassMainMobileRelease() {
  return src('./assets/css/main-mobile.css')
    .pipe(autoprefixer())
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.cleanCss())
    .pipe(dest('./assets/css/'));
}

/**
 * Sass Release - Home Desktop (minified)
 */
function sassHomeRelease() {
  return src('./assets/css/home.css', { allowEmpty: true })
    .pipe(autoprefixer())
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.cleanCss())
    .pipe(dest('./assets/css/'));
}

/**
 * Sass Release - Home Mobile (minified)
 */
function sassHomeMobileRelease() {
  return src('./assets/css/home-mobile.css', { allowEmpty: true })
    .pipe(autoprefixer())
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.cleanCss())
    .pipe(dest('./assets/css/'));
}

/**
 * JavaScript Build - MainJS
 */
function jsMainRelease() {
  return src('./assets/js/mainJS.js')
    .pipe($.terser())
    .pipe($.rename({ suffix: '.min' }))
    .pipe(dest('./assets/js/'));
}

/**
 * JavaScript Build - Seletric
 */
function jsSeletricRelease() {
  return src('./assets/js/seletric.js')
    .pipe($.terser())
    .pipe($.rename({ suffix: '.min' }))
    .pipe(dest('./assets/js/'));
}

/**
 * JavaScript Build - Slick
 */
function jsSlickRelease() {
  return src('./assets/js/slick.js')
    .pipe($.terser())
    .pipe($.rename({ suffix: '.min' }))
    .pipe(dest('./assets/js/'));
}

/**
 * JavaScript Build - ScrollReveal
 */
function jsScrollRevealRelease() {
  return src('./assets/js/scrollreveal.js')
    .pipe($.terser())
    .pipe($.rename({ suffix: '.min' }))
    .pipe(dest('./assets/js/'));
}

/**
 * Webpack Development
 */
function scripts(cb) {
  const compiler = webpack(webpackConfig);

  compiler.run((err, stats) => {
    if (err) {
      console.error(err);
      return cb(err);
    }

    if (stats.hasErrors()) {
      console.error(stats.compilation.errors);
    }

    if (stats.hasWarnings()) {
      console.warn(stats.compilation.warnings);
    }

    // Log apenas em caso de erro ou warning
    if (stats.hasErrors() || stats.hasWarnings()) {
      console.log(stats.toString({
        colors: true,
        chunks: false,
        modules: false,
        children: false,
      }));
    }

    browserSync.reload();
    cb();
  });
}

/**
 * BrowserSync Server
 */
function serve(cb) {
  browserSync.init({
    proxy: 'adsolutions-sistemas.local', // Ajuste para o seu domínio local
    open: true,
    notify: false,
    injectChanges: true, // Injeta CSS sem recarregar a página
    reloadOnRestart: true,
    // Se não usar proxy, descomente:
    // server: { baseDir: './' }
  });
  cb();
}

/**
 * Watch Files
 */
function watchFiles() {
  // Watch PHP files
  watch('./**/*.php', { ignoreInitial: true }).on('change', browserSync.reload);

  // Watch SCSS files - qualquer mudança em qualquer arquivo SCSS recompila tudo
  watch('./src/sass/**/*.scss', { ignoreInitial: true })
    .on('change', () => {
      parallel(sassMain, sassMainMobile, sassHome, sassHomeMobile)();
    });

  // Watch JS files
  watch('./src/js/**/*.js', { ignoreInitial: true })
    .on('change', () => {
      scripts();
    });

  // Watch SVG icons
  watch('./src/img/icons/*.svg', { allowEmpty: true, ignoreInitial: true }, svgicons);

  // Watch SVG images
  watch('./src/img/svg/*.svg', { allowEmpty: true, ignoreInitial: true }, svgoptimize);
}

/**
 * Compila todas as páginas
 */
function compileAllPages() {
  if (allPageTasks.length === 0) {
    return Promise.resolve();
  }
  return parallel(...allPageTasks)();
}

/**
 * Release todas as páginas
 */
function releaseAllPages() {
  if (allPageReleaseTasks.length === 0) {
    return Promise.resolve();
  }
  return parallel(...allPageReleaseTasks)();
}

/**
 * Watch apenas CSS (sem BrowserSync)
 */
function watchCSS() {
  // Compila tudo primeiro (páginas + release)
  series(
    compileAllPages,
    releaseAllPages
  )((err) => {
    if (err) {
      console.error('Error on initial compile:', err);
    }
  });

  // Depois observa mudanças
  watch('./src/sass/**/*.scss', { ignoreInitial: true })
    .on('change', (changedPath) => {
      // Executa o build completo (compila + minifica) para garantir que tudo seja salvo
      series(
        compileAllPages,
        releaseAllPages
      )((err) => {
        if (err) {
          console.error('Error compiling CSS:', err);
        } else {
          // Força atualização do timestamp de todos os arquivos CSS gerados
          const cssDir = './assets/css';
          if (fs.existsSync(cssDir)) {
            const files = fs.readdirSync(cssDir);
            const cssFiles = files.filter(f => f.endsWith('.css') && !f.endsWith('.min.css'));
            const now = new Date();

            cssFiles.forEach(file => {
              const filePath = path.join(cssDir, file);
              try {
                fs.utimesSync(filePath, now, now);
              } catch (e) {
                // Ignora erros
              }
            });
          }
        }
      });
    });
}

/**
 * Build Tasks
 */
const buildStyles = allPageTasks.length > 0
  ? parallel(...allPageTasks)
  : parallel(sassMain, sassMainMobile, sassHome, sassHomeMobile);

const buildSvg = parallel(svgicons, svgoptimize);
const buildDev = parallel(buildStyles, scripts, buildSvg);

const releaseStyles = series(
  buildStyles,
  allPageReleaseTasks.length > 0
    ? parallel(...allPageReleaseTasks)
    : parallel(sassMainRelease, sassMainMobileRelease, sassHomeRelease, sassHomeMobileRelease)
);

const releaseJs = parallel(
  jsMainRelease,
  jsSeletricRelease,
  jsSlickRelease,
  jsScrollRevealRelease
);

const buildRelease = series(releaseStyles, releaseJs);

/**
 * Export Tasks
 */
exports.svgicons = svgicons;
exports.svgoptimize = svgoptimize;
exports.sassMain = sassMain;
exports.sassMainMobile = sassMainMobile;
exports.sassHome = sassHome;
exports.sassHomeMobile = sassHomeMobile;
exports.scripts = scripts;
exports.serve = serve;
exports.watch = series(buildDev, serve, watchFiles);
exports.watchCSS = watchCSS;
exports.build = buildDev;
exports['sass:release'] = releaseStyles;
exports['js:release'] = releaseJs;
exports.release = buildRelease;
exports.default = series(buildDev, serve, watchFiles);
