<?php


namespace FritsStegmann\Preset;

use Illuminate\Foundation\Console\Presets\Preset as LaravelPreset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Laravel\Ui\AuthCommand;

class TailwindAuthCommandPreset extends LaravelPreset
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

        self::ensureDirectoriesExist();
        self::exportViews($views);

        File::copy(__DIR__ . '/../stubs/auth-stubs/welcome.stub', resource_path('views/welcome.blade.php'));
        File::copy(__DIR__ . '/../stubs/auth-stubs/router.ts', resource_path('ts/router.ts'));
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected static function ensureDirectoriesExist()
    {
        if (! is_dir($directory = resource_path('views/layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = resource_path('views/auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @param $views
     * @return void
     */
    private static function exportViews($views)
    {
        foreach ($views as $key => $value) {
            File::copy(
                __DIR__ . '/../stubs/auth-stubs/' . $key,
                resource_path('views/' . $value)
            );
        }
    }
}