<?php

namespace FritsStegmann\Preset;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Laravel\Ui\Presets\Preset as LaravelPreset;

class DefaultPreset extends LaravelPreset
{
    public static function install()
    {
        self::cleanDirectory();
        self::deleteJSDirectory();
        self::createTSDirectory();
        self::updatePackages();
        self::updateMix();
        self::updateTypeScript();
        self::updateStyleSheets();
        self::installTailwindCSS();
        self::cleanJs();
        self::addJestToPackageJsonFile();
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
        return array_merge(self::newPackages(), Arr::except($packages, [
            'lodash',
            'query',
            'popper.js',
            'bootstrap',
        ]));
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
            'vue-property-decorator' => '^9.0.0',
            'vue-class-component' => '^7.2.5',
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

    private static function updateMix()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    private static function updateTypeScript()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/app.ts', resource_path('ts/app.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/router.ts', resource_path('ts/router.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/tsconfig.json', base_path('tsconfig.json'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/pages/HomePage.vue', resource_path('ts/pages/HomePage.vue'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/pages/LoginPage.vue', resource_path('ts/pages/LoginPage.vue'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/components/Header.vue', resource_path('ts/components/Header.vue'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/components/GravatarImg.vue', resource_path('ts/components/GravatarImg.vue'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/App.vue', resource_path('ts/App.vue'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/VueBlocProvider.ts', resource_path('ts/VueBlocProvider.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/blocs/AuthBloc.ts', resource_path('ts/blocs/AuthBloc.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/repository/UserRepository.ts', resource_path('ts/repository/UserRepository.ts'));
    }

    private static function updateStyleSheets()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/app.scss', resource_path('sass/app.scss'));
    }

    private static function installTailwindCSS()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/tailwind.config.js', base_path('tailwind.config.js'));
    }
}
