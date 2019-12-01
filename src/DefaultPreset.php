<?php

namespace FritsStegmann\Preset;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use \Illuminate\Foundation\Console\Presets\Preset as LaravelPreset;

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
        self::installWelcomePage();
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
        if (!File::exists(resource_path('ts/shims'))) {
            File::makeDirectory(resource_path('ts/shims'));
        }
        if (!File::exists(resource_path('ts/blocs'))) {
            File::makeDirectory(resource_path('ts/blocs'));
        }
    }

    protected static function updatePackageArray($packages)
    {
        return array_merge(self::newPackages(), Arr::except($packages, [
            'lodash',
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

        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages['jest'] = $jestConfig;

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    private static function newPackages()
    {
        return [
            'laravel-mix-tailwind' => '^0.1.0',
            'vue' => '^2.6.10',
            'ts-loader' => '^6.2.1',
            'typescript' => '^3.7.2',
            'tailwindcss' => '^1.1.3',
            'vue-property-decorator' => '^8.3.0',
            'vue-class-component' => '^7.1.0',
            'vue-template-compiler' => '^2.6.10',
            'vue-rx' => '^6.2.0',
            'rxjs' => '^6.5.3',
            'vuex' => '3.1.2',
            'vue-router' => '3.1.3',
            'reflect-metadata' => '^0.1.13',
            '@tailwindcss/custom-forms' => '^0.2.1',
            "@types/jest" => "^24.0.23",
            "@vue/test-utils" => "^1.0.0-beta.29",
            "babel-core" => "^6.26.3",
            "jest" => "^24.9.0",
            "ts-jest" => "^24.1.0",
            "vue-jest" => "^3.0.5",
        ];
    }

    private static function updateMix()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    private static function updateTypeScript()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/app.ts', resource_path('ts/app.ts'));

        File::copy(__DIR__ . '/../stubs/ui-stubs/store.ts', resource_path('ts/store.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/router.ts', resource_path('ts/router.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/http.ts', resource_path('ts/http.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/laravel.ts', resource_path('ts/laravel.ts'));

        File::copy(__DIR__ . '/../stubs/ui-stubs/tsconfig.json', base_path('tsconfig.json'));

        File::copy(__DIR__ . '/../stubs/ui-stubs/pages/HomePage.vue', resource_path('ts/pages/HomePage.vue'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/App.vue', resource_path('ts/App.vue'));

        File::copy(__DIR__ . '/../stubs/ui-stubs/shims/shims-$http.d.ts', resource_path('ts/shims/shims-$http.d.ts'));

        File::copy(__DIR__ . '/../stubs/ui-stubs/shims/vue-shim.d.ts', resource_path('ts/shims/vue-shim.d.ts'));

        File::copy(__DIR__ . '/../stubs/ui-stubs/VueBlocProvider.ts', resource_path('ts/VueBlocProvider.ts'));

        File::copy(__DIR__ . '/../stubs/ui-stubs/blocs/_vue_bloc.ts', resource_path('ts/blocs/_vue_bloc.ts'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/blocs/user_bloc.ts', resource_path('ts/blocs/user_bloc.ts'));
    }

    private static function updateStyleSheets()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/app.scss', resource_path('sass/app.scss'));
        File::copy(__DIR__ . '/../stubs/ui-stubs/custom.scss', resource_path('sass/custom.scss'));
    }

    private static function installTailwindCSS()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/tailwind.config.js', base_path('tailwind.js'));
    }

    private static function installWelcomePage()
    {
        File::copy(__DIR__ . '/../stubs/ui-stubs/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }
}
