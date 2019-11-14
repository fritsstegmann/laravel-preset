<?php


namespace FritsStegmann\Preset;

use Illuminate\Foundation\Console\Presets\Preset as LaravelPreset;
use Illuminate\Support\Facades\File;

class AuthCommandPreset extends LaravelPreset
{
    public static function install()
    {
        $views = [
            'auth/login.stub' => 'auth/login.blade.php',
            'auth/passwords/confirm.stub' => 'auth/passwords/confirm.blade.php',
            'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
            'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
            'auth/register.stub' => 'auth/register.blade.php',
            'auth/verify.stub' => 'auth/verify.blade.php',
            'home.stub' => 'home.blade.php',
            'layouts/app.stub' => 'layouts/app.blade.php',
            'layouts/auth.stub' => 'layouts/auth.blade.php',
        ];

        AuthCommandPreset::exportViews($views);

        File::copy(__DIR__ . '/../stubs/auth-stubs/welcome.stub', resource_path('views/welcome.blade.php'));
    }

    /**
     * Export the authentication views.
     *
     * @param $views
     * @return void
     */
    private static function exportViews($views)
    {
        if (!File::exists(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs'))) {
            File::makeDirectory(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs'));
        }

        if (!File::exists(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs/auth'))) {
            File::makeDirectory(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs/auth'));
        }

        if (!File::exists(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs/auth/passwords'))) {
            File::makeDirectory(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs/auth/passwords'));
        }

        if (!File::exists(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs/layouts'))) {
            File::makeDirectory(base_path('vendor/laravel/ui/src/Auth/tailwind-stubs/layouts'));
        }

        foreach ($views as $key => $value) {
            File::copy(
                __DIR__ . '/../stubs/auth-stubs/' . $key,
                base_path('vendor/laravel/ui/src/Auth/tailwind-stubs/' . $key)
            );
        }
    }
}