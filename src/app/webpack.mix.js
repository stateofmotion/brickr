const mix = require('laravel-mix');
const LiveReloadPlugin = require('webpack-livereload-plugin');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .extract(['vue'])
  .autoload({
    axios: ['axios'],
  })
  .sourceMaps()
  .version();

if (process.env.APP_DEBUG) {
  console.log("Running in debug mode...");
  console.log("Working");
  mix.sourceMaps();

  mix.webpackConfig({
    plugins: [
      new LiveReloadPlugin()
    ]
  });
}



