import gulp from 'gulp';
import watch from 'gulp-watch';
import {
  exec
} from 'child_process';
import cleanCSS from 'gulp-clean-css';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import fonter from 'gulp-fonter';
import ttf2woff2 from 'gulp-ttf2woff2';
import svgmin from 'gulp-svgmin';
import svgstore from 'gulp-svgstore';
import rename from 'gulp-rename';
import fs from 'fs';
import path from 'path';

// Minify JavaScript
gulp.task('minify-js', function (done) {
  console.log('Starting minify-js task');
  return gulp.src('assets/js/scripts/*.js')
    .pipe(concat('scripts.min.js'))
    .pipe(uglify().on('error', function (err) {
      console.error('Uglify error:', err.toString());
      this.emit('end');
    }))
    .pipe(gulp.dest('assets/js'))
    .on('end', function () {
      console.log('minify-js task completed');
      done();
    });
});

// Combine, minify, and autoprefix CSS, then output to style-rtl.css
gulp.task('minify-css', function () {
  console.log('Starting minify-css task');
  return gulp.src('assets/css/draft/*.css')
    .pipe(concat('noakirel-styles-rtl.css'))
    .pipe(postcss([autoprefixer()]))
    .pipe(cleanCSS())
    .pipe(gulp.dest('assets/css/'));
});

// Compile RTL CSS after minifying CSS
gulp.task('compile-rtl', function (done) {
  console.log('Starting compile-rtl task');
  exec('npm run compile:rtl', (error, stdout, stderr) => {
    if (error) {
      console.error(`exec error: ${error}`);
      done(error);
      return;
    }
    console.log(`stdout: ${stdout}`);
    console.error(`stderr: ${stderr}`);
    done();
  });
});

// Convert fonts to WOFF2
gulp.task('convert-fonts', () => {
  return gulp.src('assets/fonts/theme/*.{ttf,otf}')
    .pipe(fonter({
      formats: ['woff2']
    }))
    .pipe(ttf2woff2())
    .pipe(gulp.dest('assets/fonts/theme/'));
});

// Generate fonts CSS
gulp.task('generate-fonts-css', (done) => {
  const fontDir = 'assets/fonts/theme';
  const cssFile = 'assets/css/draft/__02-fonts.css';
  let cssContent = '';
  let cssVariables = ':root {\n';

  fs.readdirSync(fontDir).forEach(file => {
    if (file.endsWith('.woff2')) {
      const baseName = path.basename(file, '.woff2');
      const varName = baseName.replace(/[-_](.)/g, (_, c) => c.toUpperCase());
      cssContent += `
@font-face {
  font-family: '${baseName}';
  src: url('../fonts/${file}') format('woff2');
  font-weight: normal;
  font-style: normal;
  font-display: swap;
}
`;
      cssVariables += `  --font-${varName}: '${baseName}';\n`;
    }
  });

  cssVariables += '}\n';
  cssContent += '\n' + cssVariables;

  fs.writeFileSync(cssFile, cssContent);
  done();
});

// Optimize SVG icons
gulp.task('svg-optimize', () => {
  return gulp.src('assets/images/icons/*.svg')
    .pipe(svgmin())
    .pipe(gulp.dest('assets/images/icons'));
});

gulp.task('svg-combine', () => {
  return gulp.src('assets/images/icons/*.svg')
    .pipe(svgstore({
      inlineSvg: true
    }))
    .pipe(rename('sprite.svg'))
    .pipe(gulp.dest('assets/images'));
});

// Font, SVG
gulp.task('fonts', gulp.series('convert-fonts', 'generate-fonts-css'));
gulp.task('icons', gulp.series('svg-optimize', 'svg-combine'));

// Watch task to run tasks on file changes
gulp.task('watch', function () {
  console.log('Watching files...');
  watch('assets/css/draft/*.css', {
      events: ['add', 'change']
    }, gulp.series('minify-css', 'compile-rtl'))
    .on('change', (path) => console.log(`File changed: ${path}`));
  watch('assets/js/scripts/*.js', gulp.series('minify-js'));
});

// Default task to run watch
gulp.task('default', gulp.series('watch'));