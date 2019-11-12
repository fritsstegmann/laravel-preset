<?php

namespace FritsStegmann\Preset;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use \Illuminate\Foundation\Console\Presets\Preset as LaravelPreset;

class Preset extends LaravelPreset
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
    }

    private static function cleanDirectory()
    {
        File::cleanDirectory(resource_path('sass'));
        File::cleanDirectory(resource_path('js'));
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
    }

    protected static function updatePackageArray($packages)
    {
        return array_merge(self::newPackages(), Arr::except($packages, [
            'lodash',
        ]));
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
        ];
    }

    private static function updateMix()
    {
        File::copy(__DIR__ . '/../stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    private static function updateTypeScript()
    {
        File::copy(__DIR__ . '/../stubs/bootstrap.ts', resource_path('ts/bootstrap.ts'));
        File::copy(__DIR__ . '/../stubs/app.ts', resource_path('ts/app.ts'));
        File::copy(__DIR__ . '/../stubs/App.vue', resource_path('ts/App.vue'));
        File::copy(__DIR__ . '/../stubs/tsconfig.json', base_path('tsconfig.json'));
    }

    private static function updateStyleSheets()
    {
        File::copy(__DIR__ . '/../stubs/app.scss', resource_path('sass/app.scss'));
        File::copy(__DIR__ . '/../stubs/custom.scss', resource_path('sass/custom.scss'));
    }

    private static function installTailwindCSS()
    {
        File::copy(__DIR__ . '/../stubs/tailwind.config.js', base_path('tailwind.js'));
    }

    private static function installWelcomePage()
    {
        File::copy(__DIR__ . '/../stubs/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }
}
