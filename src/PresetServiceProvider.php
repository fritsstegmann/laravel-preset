<?php

namespace FritsStegmann\Preset;

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
        if (class_exists('Laravel\Ui\UiCommand')) {
            \Laravel\Ui\UiCommand::macro('vuets', function ($command) {
                DefaultPreset::install();
            });
        }
    }
}
