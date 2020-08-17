const mix = require('laravel-mix')
const path = require('path')

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
    .ts('resources/ts/src/app.ts', 'public/js')
    .sass('resources/scss/app.scss', 'public/css')
    .tailwind('./tailwind.config.js')
    .disableSuccessNotifications()
    .options({
        hmrOptions: {
            host: 'localhost',
            port: 3000,
        },
    })
    .webpackConfig({
        resolve: {
            alias: {
                '@app': path.resolve(__dirname, 'resources/ts/src/'),
            },
        },
        module: {
            rules: [
                {
                    enforce: 'pre',
                    exclude: /node_modules/,
                    loader: 'eslint-loader',
                    test: /\.(js|vue)?$/,
                },
            ],
        },
        devServer: {
            proxy: {
                '*': 'http://localhost:8000',
            },
        },
    })

