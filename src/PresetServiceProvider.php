<?php

namespace FritsStegmann\Preset;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class PresetServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (class_exists('\Illuminate\Foundation\Console\PresetCommand')) {
            \Illuminate\Foundation\Console\PresetCommand::macro('vuets', function ($command) {
                DefaultPreset::install();
            });
        }

        if (class_exists('Laravel\Ui\UiCommand')) {
            \Laravel\Ui\UiCommand::macro('vuets', function ($command) {
                DefaultPreset::install();
            });
        }

        if (class_exists('\Laravel\Ui\AuthCommand')) {
            \Laravel\Ui\AuthCommand::macro('tailwind', function ($command) {
                AuthCommandPreset::install();
            });
        }
    }
}
