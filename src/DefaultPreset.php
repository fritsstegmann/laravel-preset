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
        self::updateCypress();
        self::updateStorage();
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
                'laracasts/cypress' => '^1.1'
            ],
            Arr::except(
                $requireDevList,
                [
                    'laracasts/cypress',
                    'squizlabs/php_codesniffer',
                    'phpmd/phpmd',
                    "barryvdh/laravel-ide-helper",
                ]
            )
        );

        $dontDiscover = $composer['extra']['laravel']['dont-discover'];
        $dontDiscover = array_unique(
            array_merge(
                $dontDiscover,
                ['barryvdh/laravel-ide-helper']
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
        if (!File::exists(resource_path('ts/tests/unit'))) {
            File::makeDirectory(resource_path('ts/tests/unit'));
        }
        if (!File::exists(resource_path('ts/tests/unit/components'))) {
            File::makeDirectory(resource_path('ts/tests/unit/components'));
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
            'cypress' => '^5.0.0',
            '@types/jest' => '^26.0.10',
            '@types/md5' => '^2.2.0',
            'tailwind-mix' => '^1.0.4',
            'vue' => '^2.6.11',
            'ts-loader' => '^8.0.2',
            'cypress-intellij-reporter' => '0.0.4',
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

    private static function updateCypress()
    {
        $files = [
            'fixtures/example.json',
            'integration/login.spec.js',
            'plugins/index.js',
            'plugins/swap-env.js',
            'support/assertions.js',
            'support/commands.js',
            'support/index.js',
            'support/laravel-commands.js'
        ];

        foreach ($files as $file) {
            self::copyFile($file, __DIR__ . '/../stubs/cypress/', 'tests/Cypress/');
        }
    }

    private static function updatePHP()
    {
        File::copy(__DIR__ . '/../stubs/php/AppServiceProvider.php', base_path('app/Providers/AppServiceProvider.php'));
        File::copy(__DIR__ . '/../stubs/php/config/ide-helper.php', base_path('config/ide-helper.php'));
        File::copy(__DIR__ . '/../stubs/php/config/sanctum.php', base_path('config/sanctum.php'));

        File::copy(__DIR__ . '/../stubs/php/routes/api.php', base_path('routes/api.php'));
        File::copy(__DIR__ . '/../stubs/php/routes/web.php', base_path('routes/web.php'));

        File::copy(__DIR__ . '/../stubs/php/Http/Kernel.php', base_path('app/Http/Kernel.php'));
    }

    private static function copyFile(
        $file,
        $src,
        $dest
    ) {
        $destFilePath = $dest . str_replace('.stub', '', $file);
        $destFolder = dirname($destFilePath);

        if (!File::exists(base_path($destFolder))) {
            File::makeDirectory(base_path($destFolder), 0755, true);
        }
        File::copy($src . $file, base_path($dest . str_replace('.stub', '', $file)));
    }

    private static function updateBaseFiles()
    {
        $files = [
            '.gitignore.stub',
            'webpack.mix.js',
            '.eslintignore',
            '.eslintrc.json',
            '.editorconfig',
            'tailwind.config.js',
            'tsconfig.json',
            '.env.cypress',
            'cypress.json',
        ];

        foreach ($files as $file) {
            self::copyFile($file, __DIR__ . '/../stubs/base/', '');
        }
    }

    private static function updateStorage()
    {
        $files = [
            'Cypress/.gitignore.stub'
        ];

        foreach ($files as $file) {
            self::copyFile($file, __DIR__ . '/../stubs/storage/', 'storage/');
        }
    }

    private static function updateResourceFiles()
    {
        $files = [
            // blade
            'views/layouts/app.blade.php',

            // ts
            'ts/src/app.ts',
            'ts/src/router.ts',

            'ts/src/models/User.ts',
            'ts/src/blocs/AuthBloc.ts',
            'ts/src/repository/UserRepository.ts',
            'ts/src/VueBlocProvider.ts',

            'ts/src/App.vue',
            'ts/src/AppScaffold.vue',

            'ts/src/pages/HomePage.vue',
            'ts/src/pages/LoginPage.vue',

            'ts/src/components/Header.vue',
            'ts/src/components/GravatarImg.vue',

            // tests
            'ts/tests/unit/components/Header.spec.ts',
            // scss
            'scss/app.scss',
        ];

        foreach ($files as $file) {
            self::copyFile($file, __DIR__ . '/../stubs/resources/', 'resources/');
        }
    }
}
