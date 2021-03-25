const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/icon.scss', 'public/css');
mix.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
]);
mix.postCss('resources/css/landing.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
]);

mix.copyDirectory('resources/img', 'public/img');

mix.version();

mix.sourceMaps();

mix.disableNotifications();
