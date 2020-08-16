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
        self::deleteJSDirectory();
        self::createTSDirectory();
        self::updatePackages();
        self::updateBaseFiles();
        self::updateResourceFiles();
        self::cleanJs();
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
                ]
            )
        );

        $dontDiscover = $composer['extra']['laravel']['dont-discover'];
        $dontDiscover = array_merge(
            [
                "barryvdh/laravel-ide-helper",
            ],
            $dontDiscover
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

    private static function cleanJs()
    {
        File::cleanDirectory(resource_path('js'));
    }

    private static function cleanDirectory()
    {
        File::cleanDirectory(resource_path('sass'));
    }

    private static function deleteJSDirectory()
    {
        File::deleteDirectory(resource_path('js'));
    }

    private static function createTSDirectory()
    {
        if (!File::exists(resource_path('ts'))) {
            File::makeDirectory(resource_path('ts'));
        }
        if (!File::exists(resource_path('ts/pages'))) {
            File::makeDirectory(resource_path('ts/pages'));
        }
        if (!File::exists(resource_path('ts/blocs'))) {
            File::makeDirectory(resource_path('ts/blocs'));
        }
        if (!File::exists(resource_path('ts/components'))) {
            File::makeDirectory(resource_path('ts/components'));
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
            "moduleFileExtensions" => [
                "js",
                "ts",
                "json",
                "vue"
            ],
            "transform" => [
                ".*\\.(vue)$" => "vue-jest",
                "^.+\\.tsx?$" => "ts-jest"
            ],
            "testURL" => "http://127.0.0.1:8000/",
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
            'tailwind-mix' => '^1.0.4',
            'vue' => '^2.6.11',
            'ts-loader' => '^8.0.2',
            'typescript' => '^3.9.7',
            'tailwindcss' => '^1.6.2',
            'laravel-mix-eslint-config' => '^0.1.7',
            'eslint-loader' => '^4.0.2',
            'eslint-plugin-vue' => '6.2.2',
            'eslint' => '7.7.0',
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
            "@types/jest" => "^26.0.9",
            "@vue/test-utils" => "^1.0.3",
            "jest" => "^26.4.0",
            "ts-jest" => "^26.2.0",
            "vue-jest" => "^3.0.6",
            "md5" => "2.3.0",
        ];
    }

    private static function updatePHP()
    {
        File::copy(__DIR__ . '/../stubs/AppServiceProvider.php', base_path('app/Providers/AppServiceProvider.php'));
        File::copy(__DIR__ . '/../stubs/ide-helper.php', base_path('config/ide-helper.php'));
        File::copy(__DIR__ . '/../stubs/sanctum.php', base_path('config/sanctum.php'));
    }

    private static function updateBaseFiles()
    {
        File::copy(__DIR__ . '/../stubs/.gitignore.stub', base_path('.gitignore'));
        File::copy(__DIR__ . '/../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        File::copy(__DIR__ . '/../stubs/.eslintignore', base_path('.eslintignore'));
        File::copy(__DIR__ . '/../stubs/.editorconfig', base_path('.editorconfig'));
        File::copy(__DIR__ . '/../stubs/.eslintrc.json', base_path('.eslintrc.json'));
        File::copy(__DIR__ . '/../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        File::copy(__DIR__ . '/../stubs/.php_cs.laravel.php', base_path('.php_cs.laravel.php'));
    }

    private static function updateResourceFiles()
    {
        File::copy(__DIR__ . '/../stubs/app.ts', resource_path('ts/app.ts'));
        File::copy(__DIR__ . '/../stubs/router.ts', resource_path('ts/router.ts'));
        File::copy(__DIR__ . '/../stubs/tsconfig.json', base_path('tsconfig.json'));
        File::copy(__DIR__ . '/../stubs/pages/HomePage.vue', resource_path('ts/pages/HomePage.vue'));
        File::copy(__DIR__ . '/../stubs//pages/LoginPage.vue', resource_path('ts/pages/LoginPage.vue'));
        File::copy(__DIR__ . '/../stubs/components/Header.vue', resource_path('ts/components/Header.vue'));
        File::copy(__DIR__ . '/../stubs/components/GravatarImg.vue', resource_path('ts/components/GravatarImg.vue'));
        File::copy(__DIR__ . '/../stubs/App.vue', resource_path('ts/App.vue'));
        File::copy(__DIR__ . '/../stubs/AppScaffold.vue', resource_path('ts/AppScaffold.vue'));
        File::copy(__DIR__ . '/../stubs/VueBlocProvider.ts', resource_path('ts/VueBlocProvider.ts'));
        File::copy(__DIR__ . '/../stubs/blocs/AuthBloc.ts', resource_path('ts/blocs/AuthBloc.ts'));
        File::copy(
            __DIR__ . '/../stubs/repository/UserRepository.ts',
            resource_path('ts/repository/UserRepository.ts')
        );
        File::copy(__DIR__ . '/../stubs/app.scss', resource_path('sass/app.scss'));
    }
}
