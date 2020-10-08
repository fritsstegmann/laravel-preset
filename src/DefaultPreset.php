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
        self::updatePackages();
        self::updateBaseFiles();
        self::updateResourceFiles();
        self::addJestToPackageJsonFile();
        self::updatePHP();
        self::updateCypress();
        self::updateStorage();
        self::updateJest();

        system('echo "run \'composer update && npm install\'"');
    }

    private static function installPHPPackages()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $requireDevList = $composer['require-dev'];
        $requireList = $composer['require'];

        $requireList = array_merge(
            [
                "laravel/sanctum" => '^2.6'
            ],
            $requireList
        );

        $requireDevList = array_merge(
            [
                "squizlabs/php_codesniffer" => "^3.0",
                "phpmd/phpmd" => "@stable",
                "barryvdh/laravel-ide-helper" => "^2.8",
                'laracasts/cypress' => '^1.1',
                'brainmaestro/composer-git-hooks' => '^2.8',
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

        $extra = $composer['extra'];
        $extra['hooks'] = [
            'pre-commit' => [
                "echo committing as $(git config user.email)",
                'cd $(git rev-parse --show-toplevel)',
                'vendor/bin/phpcs --standard=PSR1 ./app && \\',
                'vendor/bin/phpcs --standard=PSR12 ./app && \\',
                'vendor/bin/phpmd ./app text phpmd.xml && \\',
                'vendor/bin/phpunit -c ./phpunit.xml > /dev/null 2>&1',
                'exit $?'
            ],
            'post-merge' => [
                'composer install',
            ],
        ];

        $composer['extra'] = $extra;

        $dontDiscover = $composer['extra']['laravel']['dont-discover'];
        $dontDiscover = array_unique(
            array_merge(
                $dontDiscover,
                ['barryvdh/laravel-ide-helper']
            )
        );

        $scripts = array_merge(
            $composer['scripts'],
            [
                'cghooks' => 'vendor/bin/cghooks',
                'phpcs' => [
                    'phpcs --standard=PSR1 ./app',
                    'phpcs --standard=PSR12 ./app',
                    'phpmd ./app text phpmd.xml',
                    'phpunit -c ./phpunit.xml',
                ],
                'post-update-cmd' => [
                    "Illuminate\\Foundation\\ComposerScripts::postUpdate",
                    'cghooks update',
                ],
                'post-install-cmd' => [
                    'cghooks add --ignore-lock'
                ],
            ]
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
                "^@app/(.*)$" => "<rootDir>/resources/ts/$1",
            ],
            "modulePaths" => [
                "<rootDir>"
            ],
            "moduleFileExtensions" => [
                "ts",
                "tsx",
                "js",
                "jsx",
                "json",
                "vue"
            ],
            "testMatch" => ["<rootDir>/tests/Jest/**/*.spec.ts"],
            "transform" => [
                "^.+\\.ts$" => "ts-jest",
                "^.+\\.vue$" => "vue-jest",
                "^.+\.(js|jsx)?$" => "babel-jest",
            ],
            "transformIgnorePatterns" => [
                "<rootDir>/node_modules/",
                "<rootDir>/vendor/"
            ],
            "testURL" => "http://localhost/",
        ];

        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages['jest'] = $jestConfig;

        $packages['browserslist'] = [
            "> 1%",
            "last 2 versions",
            "not ie <= 8"
        ];

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    private static function newPackages()
    {
        return [
            'babel-core' => '^6.26.3',
            '@vue/cli-plugin-typescript' => '^4.5.6',
            'cypress' => '^5.2.0',
            '@types/jest' => '^26.0.14',
            '@types/md5' => '^2.2.0',
            'tailwind-mix' => '^1.0.4',
            'vue' => '^2.6.12',
            'ts-loader' => '^8.0.3',
            'cypress-intellij-reporter' => '0.0.4',
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
            'sass-loader' => '^10.0.2',
            'fibers' => '^5.0.0',
            'sass' => '^1.26.10',
            'vue-eslint-parser' => '^7.1.0',
            'vue-property-decorator' => '^9.0.0',
            'vue-template-compiler' => '^2.6.12',
            'vue-rx' => '^6.2.0',
            'rxjs' => '^6.6.2',
            'vue-router' => '3.4.3',
            'reflect-metadata' => '^0.1.13',
            "@vue/test-utils" => "^1.0.3",
            "jest" => "^26.4.0",
            "ts-jest" => "^26.2.0",
            "vue-jest" => "^3.0.6",
            "md5" => "2.3.0",
        ];
    }

    private static function updateJest()
    {
        $files = [
            'components/Header.spec.ts',
        ];

        foreach ($files as $file) {
            self::copyFile($file, __DIR__ . '/../stubs/jest/', 'tests/Jest/');
        }
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
            'phpmd.xml',
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
            'ts/app.ts',
            'ts/router.ts',

            'ts/models/User.ts',
            'ts/blocs/AuthBloc.ts',
            'ts/repository/UserRepository.ts',

            'ts/App.vue',
            'ts/AppScaffold.vue',

            'ts/pages/HomePage.vue',
            'ts/pages/LoginPage.vue',

            'ts/components/Header.vue',
            'ts/components/GravatarImg.vue',

            'ts/shims/shims-vue.d.ts',

            // scss
            'scss/app.scss',


        ];

        foreach ($files as $file) {
            self::copyFile($file, __DIR__ . '/../stubs/resources/', 'resources/');
        }
    }
}
