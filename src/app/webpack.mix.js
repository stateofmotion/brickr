const mix = require('laravel-mix');
const LiveReloadPlugin = require('webpack-livereload-plugin');

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .extract(['vue'])
  .autoload({
    axios: ['axios'],
  })
  .version();

if (process.env.APP_DEBUG) {
  console.log("Running in debug mode...");
  mix.sourceMaps();

  mix.webpackConfig({
    plugins: [
      new LiveReloadPlugin()
    ]
  });
}



