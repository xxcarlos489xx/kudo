const {MIX_PACKAGE, NPM, VENDOR, OUTPUT, output} = require('laravel-multimix');


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

 let folder = MIX_PACKAGE
 const modulosPath = `${__dirname}/modulos/`;
 require(`${modulosPath}/${folder}/webpack.mix.js`);
