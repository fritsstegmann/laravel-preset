const mix = require('laravel-mix')
require('tailwind-mix')
require('laravel-mix-eslint-config')

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
    .ts('resources/ts/app.ts', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .tailwind('./tailwind.config.js')
    .disableSuccessNotifications()
    .options({
        hmrOptions: {
            host: "localhost",
            port: 3000
        }
    })
    .webpackConfig({
        module: {
            rules: [
                {
                    enforce: 'pre',
                    exclude: /node_modules/,
                    loader: 'eslint-loader',
                    test: /\.(js|vue)?$/
                },
            ]
        },
        devServer: {
            proxy: {
                '*': 'http://localhost:8000'
            }
        }
    })

