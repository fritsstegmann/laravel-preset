<?php

namespace FritsStegmann\Preset;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Laravel\Ui\Presets\Preset as LaravelPreset;

class DefaultPreset extends LaravelPreset
{
    public static function install()
    {
        self::installPHPPackages();
        self::cleanDirectory();
        self::createDirectories();
        self::updatePackages();
        self::updateBaseFiles();
        self::updateResourceFiles();
        self::addJestToPackageJsonFile();
        self::updatePHP();
    }

    private static function installPHPPackages()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $requireDevList = $composer['require-dev'];
        $requireList = $composer['require'];

        $requireList = array_merge(
            [
                "laravel/sanctum" => '^2.4'
            ],
            $requireList
        );

        $requireDevList = array_merge(
            [
                "squizlabs/php_codesniffer" => "^3.0",
                "phpmd/phpmd" => "@stable",
                "barryvdh/laravel-ide-helper" => "^2.8",
            ],
            Arr::except(
                $requireDevList,
                [
                    'squizlabs/php_codesniffer',
                    'phpmd/phpmd',
                    "barryvdh/laravel-ide-helper",
                ]
            )
        );

        $dontDiscover = $composer['extra']['laravel']['dont-discover'];
        $dontDiscover = array_merge(
            [
                "barryvdh/laravel-ide-helper",
            ],
            Arr::except(
                $dontDiscover
                [
                    'barryvdh/laravel-ide-helper'
                ]
            )
        );

        $scripts = array_merge(
            ['phpcs' => 'composer dump-autoload && phpcs --standard=PSR1 ./app && phpcs --standard=PSR12 ./app && phpmd ./app text phpmd.xml && phpunit -c ./phpunit.xml && php artisan migrate:refresh --seed --force'],
            [
                'post-update-cmd' => [
                    "Illuminate\\Foundation\\ComposerScripts::postUpdate",
                    "@php artisan ide-helper:generate",
                    "@php artisan ide-helper:meta"
                ],
            ],
            $composer['scripts']
        );

        $composer['extra']['laravel']['dont-discover'] = $dontDiscover;
        $composer['scripts'] = $scripts;
        $composer['require'] = $requireList;
        $composer['require-dev'] = $requireDevList;
        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    private static function cleanDirectory()
    {
        File::cleanDirectory(resource_path('sass'));
        File::deleteDirectory(resource_path('sass'));

        File::cleanDirectory(resource_path('js'));
        File::deleteDirectory(resource_path('js'));
    }

    private static function createDirectories()
    {
        if (!File::exists(resource_path('scss'))) {
            File::makeDirectory(resource_path('scss'));
        }

        if (!File::exists(resource_path('ts'))) {
            File::makeDirectory(resource_path('ts'));
        }
        if (!File::exists(resource_path('ts/src'))) {
            File::makeDirectory(resource_path('ts/src'));
        }
        if (!File::exists(resource_path('ts/src/pages'))) {
            File::makeDirectory(resource_path('ts/src/pages'));
        }
        if (!File::exists(resource_path('ts/src/blocs'))) {
            File::makeDirectory(resource_path('ts/src/blocs'));
        }
        if (!File::exists(resource_path('ts/src/components'))) {
            File::makeDirectory(resource_path('ts/src/components'));
        }
        if (!File::exists(resource_path('ts/src/repository'))) {
            File::makeDirectory(resource_path('ts/src/repository'));
        }
        if (!File::exists(resource_path('ts/tests'))) {
            File::makeDirectory(resource_path('ts/tests'));
        }
    }

    protected static function updatePackageArray($packages)
    {
        return array_merge(
            self::newPackages(),
            Arr::except(
                $packages,
                [
                    'lodash',
                    'query',
                    'popper.js',
                    'bootstrap',
                ]
            )
        );
    }

    private static function addJestToPackageJsonFile()
    {
        $jestConfig = [
            "moduleNameMapper" => [
                "^@app/(.*)$" => "<rootDir>/resources/ts/src/$1",
            ],
            "modulePaths" => [
                "<rootDir>"
            ],
            "roots" => [
                "<rootDir>/resources/ts"
            ],
            "moduleFileExtensions" => [
                "ts",
                "tsx",
                "js",
                "json",
                "vue"
            ],
            "testMatch" => ["<rootDir>/resources/ts/tests/**/*.spec.ts"],
            "transform" => [
                "^.+\\.ts$" => "ts-jest",
                "^.+\\.vue$" => "vue-jest",
                "^.+\.(js|jsx)?$" => "babel-jest",
            ],
            "snapshotSerializers" => ["jest-serializer-vue"],
            "watchPlugins" => [
            ],
            "transformIgnorePatterns" => [
                "<rootDir>/node_modules/"
            ],
            "testURL" => "http://localhost/",
        ];

        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages['jest'] = $jestConfig;

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    private static function newPackages()
    {
        return [
            '@types/jest' => '^26.0.10',
            '@types/md5' => '^2.2.0',
            'tailwind-mix' => '^1.0.4',
            'vue' => '^2.6.11',
            'ts-loader' => '^8.0.2',
            '@vue/cli-plugin-unit-jest' => '^4.5.3',
            'typescript' => '^3.9.7',
            'tailwindcss' => '^1.6.2',
            'laravel-mix-eslint-config' => '^0.1.7',
            'eslint-loader' => '^4.0.2',
            'eslint-plugin-vue' => '6.2.2',
            'eslint' => '7.7.0',
            'babel-jest' => '^26.3.0',
            '@typescript-eslint/parser' => '^3.9.0',
            '@typescript-eslint/eslint-plugin' => '^3.9.0',
            'vue-class-component' => '^7.2.5',
            'vue-eslint-parser' => '^7.1.0',
            'vue-property-decorator' => '^9.0.0',
            'vue-template-compiler' => '^2.6.11',
            'vue-rx' => '^6.2.0',
            'rxjs' => '^6.6.2',
            'vue-router' => '3.4.3',
            'reflect-metadata' => '^0.1.13',
            "@vue/test-utils" => "^1.0.3",
            "jest" => "^26.4.0",
            "ts-jest" => "^27.2.0",
            "vue-jest" => "^3.0.6",
            "md5" => "2.3.0",
        ];
    }

    private static function updatePHP()
    {
        File::copy(__DIR__ . '/../stubs/php/AppServiceProvider.php', base_path('app/Providers/AppServiceProvider.php'));
        File::copy(__DIR__ . '/../stubs/php/config/ide-helper.php', base_path('config/ide-helper.php'));
        File::copy(__DIR__ . '/../stubs/php/config/sanctum.php', base_path('config/sanctum.php'));
    }

    private static function updateBaseFiles()
    {
        File::copy(__DIR__ . '/../stubs/base/.gitignore.stub', base_path('.gitignore'));
        File::copy(__DIR__ . '/../stubs/base/webpack.mix.js', base_path('webpack.mix.js'));
        File::copy(__DIR__ . '/../stubs/base/.eslintignore', base_path('.eslintignore'));
        File::copy(__DIR__ . '/../stubs/base/.editorconfig', base_path('.editorconfig'));
        File::copy(__DIR__ . '/../stubs/base/.eslintrc.json', base_path('.eslintrc.json'));
        File::copy(__DIR__ . '/../stubs/base/tailwind.config.js', base_path('tailwind.config.js'));
        File::copy(__DIR__ . '/../stubs/base/.php_cs.laravel.php', base_path('.php_cs.laravel.php'));
        File::copy(__DIR__ . '/../stubs/base/tsconfig.json', base_path('tsconfig.json'));
    }

    private static function updateResourceFiles()
    {
        // src files
        File::copy(__DIR__ . '/../stubs/resources/ts/src/app.ts', resource_path('ts/src/app.ts'));
        File::copy(__DIR__ . '/../stubs/resources/ts/src/router.ts', resource_path('ts/src/router.ts'));
        File::copy(
            __DIR__ . '/../stubs/resources/ts/src/pages/HomePage.vue',
            resource_path('ts/src/pages/HomePage.vue')
        );
        File::copy(
            __DIR__ . '/../stubs/resources/ts/src/pages/LoginPage.vue',
            resource_path('ts/src/pages/LoginPage.vue')
        );
        File::copy(
            __DIR__ . '/../stubs/resources/ts/src/components/Header.vue',
            resource_path('ts/src/components/Header.vue')
        );
        File::copy(
            __DIR__ . '/../stubs/resources/ts/src/components/GravatarImg.vue',
            resource_path('ts/src/components/GravatarImg.vue')
        );
        File::copy(__DIR__ . '/../stubs/resources/ts/src/App.vue', resource_path('ts/src/App.vue'));
        File::copy(__DIR__ . '/../stubs/resources/ts/src/AppScaffold.vue', resource_path('ts/src/AppScaffold.vue'));
        File::copy(
            __DIR__ . '/../stubs/resources/ts/src/VueBlocProvider.ts',
            resource_path('ts/src/VueBlocProvider.ts')
        );
        File::copy(__DIR__ . '/../stubs/resources/ts/src/blocs/AuthBloc.ts', resource_path('ts/src/blocs/AuthBloc.ts'));
        File::copy(
            __DIR__ . '/../stubs/resources/ts/src/repository/UserRepository.ts',
            resource_path('ts/src/repository/UserRepository.ts')
        );
        File::copy(__DIR__ . '/../stubs/resources/scss/app.scss', resource_path('scss/app.scss'));

        // test files
        File::copy(__DIR__ . '/../stubs/resources/ts/tests/Header.spec.ts', resource_path('ts/tests/Header.spec.ts'));
    }
}
