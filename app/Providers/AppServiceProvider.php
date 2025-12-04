<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // Tambahkan ini
use App\Models\User; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $file = app_path('Helpers/CmsHelper.php');
        if (file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate untuk ADMIN
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate untuk REDAKTUR
        Gate::define('redaktur', function (User $user) {
            return $user->role === 'redaktur';
        });
    }
}