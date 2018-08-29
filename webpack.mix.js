const axios = require('axios');

const path  = require("path");
// noinspection JSAnnotator
const {mix} = require('laravel-mix');
//const glob  = require('glob-all');

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

mix.setPublicPath('public_html')
    .js('resources/assets/js/app.js', 'js')
    .js('resources/assets/js/landing.js', 'js')
    .js('resources/assets/js/spreadsheet.js', 'js')
    .extract(['vue', 'jquery', 'axios', 'popper.js', 'bootstrap'])
    .autoload({
        jquery:      ['$', 'jQuery', 'jquery'],
        'popper.js': ['Popper', 'window.Popper']
    })
    .sass('resources/assets/sass/app.scss', 'css')
    .options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//         purifyCss: {
//             paths: glob.sync([
//                 path.join(__dirname, 'resources/views/**/*.twig'),
//                 path.join(__dirname, 'resources/assets/js/**/*.js')
//             ]),
//             purifyOptions: {
//                 info: true,
//                 // whitelist: ['*form*']
//             }
//
//         }, // Remove unused CSS selectors.
//   uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
    })
    .version().then(() => {
    //axios.post('https://maker.ifttt.com/trigger/webpack_build_complete/with/key/csrYq0ka2NZcdyYW40oQxx', {});
});
mix.browserSync({
    proxy:       '0.0.0.0:8000',
    files:       [
        "resources/views/**/*.twig",
        'app/**/*.php',
        'public_html/js/**/*.js',
        'public_html/css/**/*.css'
        //  "public_html/**/*"
    ],
    serveStatic: ['.', 'public_html/css']

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