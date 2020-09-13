const mix = require('laravel-mix')
const path = require('path')
const tailwind = require('tailwindcss')

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
    .options({
        processCssUrls: false,
        postCss: [ tailwind('./tailwind.config.js') ],
    })
    .extract([
        'vue',
        'vue-rx',
        'rxjs',
        'axios',
        'vue-router',
    ], 'public/js/vendor.js')
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
                '@app': path.resolve(__dirname, 'resources/ts/'),
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

