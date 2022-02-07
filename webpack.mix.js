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

mix.js('resources/js/app.js', './js')
    .js('resources/js/order/*.js', './js/order')
    .js('resources/js/checkout/cart.js', './js/checkout')
    .js('resources/js/checkout/checkout.js', './js/checkout')
    .postCss('resources/css/app.css', './css', [
        require('tailwindcss'),
    ])
    .extract([], './js/vendors.js')
    .options({ runtimeChunkPath: './js' })
    .version();
