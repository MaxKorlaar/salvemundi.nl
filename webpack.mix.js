const {mix} = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .extract(['vue', 'jquery', 'axios', 'popper.js', 'bootstrap'])
    .autoload({
        jquery:      ['$', 'jQuery', 'jquery'],
        'popper.js': ['Popper', 'window.Popper']
    })
   .sass('resources/assets/sass/app.scss', 'public/css');
mix.browserSync({
    proxy: '0.0.0.0:8000',
    // files: [
    //   "resources/views/**/*.twig"
    // ],
    // snippetOptions: {
    //     ignorePaths: "templates/*.html",
    //     rule:        {
    //         match: /<\/(footer|body)>/i,
    //         fn:    function (snippet, match) {
    //             return snippet + match;
    //         }
    //     }
    // }
});