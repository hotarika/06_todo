const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .sass("resources/sass/app.scss", "public/css")
    .sourceMaps();

mix.webpackConfig({
    devtool: "source-map",
});

mix.browserSync({
    proxy: "http://localhost:8888/99_OP/201004_laravel-todo/public/login",
    notify: {
        styles: {
            top: "auto",
            bottom: "20px",
        },
    },
});
