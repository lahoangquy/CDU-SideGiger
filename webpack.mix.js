const mix = require('laravel-mix');
const path = require('path');
const tailwindcss = require('tailwindcss');
require('laravel-mix-svg-vue');

mix.webpackConfig({
  resolve: {
    alias: {
      '@': path.resolve('resources/js')
    }
  }
});

mix
  .js('resources/js/app.js', 'public/js')
  .vue()
  .svgVue({ svgoSettings: [{ prefixIds: true }] })
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')]
  })
  // .browserSync({
  //   proxy: 'http://localhost:8000'
  // })
  .disableNotifications();
